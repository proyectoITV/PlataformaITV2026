<?php
ob_start();

if (session_status() === PHP_SESSION_NONE) {
    $isHttps = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ||
               (isset($_SERVER['SERVER_PORT']) && $_SERVER['SERVER_PORT'] == 443) ||
               (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] === 'https');

    session_set_cookie_params([
        'lifetime' => 0,
        'path'     => '/',
        'domain'   => '',
        'secure'   => $isHttps,
        'httponly' => true,
        'samesite' => 'Lax'
    ]);
    session_start();
}

require("config.php");
require("var_clean.php");
require("lib/funciones.php");

function toastLoginJs($texto, $tipo = 'error') {
    $titulo = ($tipo === 'success') ? 'Acceso' : (($tipo === 'info') ? 'Aviso' : 'Error');
    $textoJs = json_encode((string)$texto, JSON_UNESCAPED_UNICODE);
    $tituloJs = json_encode($titulo, JSON_UNESCAPED_UNICODE);
    $tipoJs = json_encode($tipo);
    echo "<script>if (typeof $.toast === 'function') { $.toast({ heading: {$tituloJs}, text: {$textoJs}, showHideTransition: 'slide', icon: {$tipoJs} }); }</script>";
}

function obtenerIpClienteLogin() {
    $candidatos = [];
    if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        $partes = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
        foreach ($partes as $p) {
            $candidatos[] = trim($p);
        }
    }
    if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
        $candidatos[] = trim($_SERVER['HTTP_CLIENT_IP']);
    }
    if (!empty($_SERVER['REMOTE_ADDR'])) {
        $candidatos[] = trim($_SERVER['REMOTE_ADDR']);
    }

    foreach ($candidatos as $ip) {
        if (filter_var($ip, FILTER_VALIDATE_IP)) {
            return substr($ip, 0, 45);
        }
    }
    return 'DESCONOCIDA';
}

function resumenEquipoLogin() {
    $ua = isset($_SERVER['HTTP_USER_AGENT']) ? strtoupper($_SERVER['HTTP_USER_AGENT']) : '';
    $os = 'OTRO';
    if (strpos($ua, 'ANDROID') !== false) {
        $os = 'Android';
    } elseif (strpos($ua, 'IPHONE') !== false || strpos($ua, 'IPAD') !== false) {
        $os = 'iOS';
    } elseif (strpos($ua, 'WIN') !== false) {
        $os = 'Windows';
    } elseif (strpos($ua, 'MAC') !== false) {
        $os = 'MAC';
    } elseif (strpos($ua, 'LINUX') !== false) {
        $os = 'LIN';
    }

    $nav = 'OTRO';
    if (strpos($ua, 'EDG') !== false) {
        $nav = 'EDGE';
    } elseif (strpos($ua, 'OPR') !== false || strpos($ua, 'OPERA') !== false) {
        $nav = 'OPERA';
    } elseif (strpos($ua, 'CHROME') !== false) {
        $nav = 'CHROME';
    } elseif (strpos($ua, 'FIREFOX') !== false) {
        $nav = 'FIREFOX';
    } elseif (strpos($ua, 'SAFARI') !== false) {
        $nav = 'SAFARI';
    }

    return "SO: {$os}, Nav: {$nav}";
}

function registrarLoginHistoria($conexion, $modoProduccion, $fecha, $hora, $nitavu, $lat, $lon, $precision, $gpsStatus, $ip) {
    if ($modoProduccion !== TRUE) {
        return false;
    }

    try {
        if ($lat !== null && $lon !== null) {
            $gpsTexto = sprintf('%.7f, %.7f', $lat, $lon);
            if ($precision !== null) {
                $gpsTexto .= ' (±' . round($precision) . 'm)';
            }
        } else {
            $gpsTexto = 'No disponible (' . $gpsStatus . ')';
        }

        $descripcion = '[LOGIN] Inicio de sesión | IP: ' . $ip . ' | GPS: ' . $gpsTexto . ' | ' . resumenEquipoLogin();

        // Inspeccionar dinámicamente qué columnas existen realmente en la tabla historia
        $columnasExistentes = [];
        $resCols = $conexion->query("SHOW COLUMNS FROM historia");
        if ($resCols) {
            while ($col = $resCols->fetch_assoc()) {
                $columnasExistentes[strtolower($col['Field'])] = $col['Field'];
            }
            $resCols->free();
        }

        $campos = ['nitavu', 'fecha', 'hora', 'descripcion'];
        $valores = [$nitavu, $fecha, $hora, $descripcion];

        $latStr = ($lat !== null) ? number_format($lat, 7, '.', '') : null;
        $lonStr = ($lon !== null) ? number_format($lon, 7, '.', '') : null;
        $precStr = ($precision !== null) ? number_format($precision, 2, '.', '') : null;

        $opcionales = [
            'latitud'       => $latStr,
            'longitud'      => $lonStr,
            'gps_precision' => $precStr,
            'gps_estado'    => $gpsStatus,
            'ip_acceso'     => $ip,
        ];

        foreach ($opcionales as $clave => $val) {
            if (isset($columnasExistentes[$clave])) {
                $campos[] = $columnasExistentes[$clave];
                $valores[] = $val;
            }
        }

        $placeholders = implode(', ', array_fill(0, count($campos), '?'));
        $sql = 'INSERT INTO historia (' . implode(', ', $campos) . ') VALUES (' . $placeholders . ')';
        $stmt = $conexion->prepare($sql);
        if ($stmt) {
            $tipos = str_repeat('s', count($valores));
            $stmt->bind_param($tipos, ...$valores);
            $ok = $stmt->execute();
            $stmt->close();
            return $ok;
        }
    } catch (\Throwable $e) {
        // Nunca impedir el inicio de sesión si ocurre algún error al registrar la bitácora
        return false;
    }

    return false;
}

$IdEmpleado = isset($_POST['Usuario']) ? VarClean($_POST['Usuario']) : '';
// No pasamos la contraseña por VarClean para soportar símbolos complejos (!@#$%&*_-)
$Password = isset($_POST['NIP']) ? (string)$_POST['NIP'] : '';
$CaptchaInput = isset($_POST['Captcha']) ? strtoupper(trim((string)$_POST['Captcha'])) : '';

$LatRaw = isset($_POST['Lat']) ? trim((string)$_POST['Lat']) : '';
$LonRaw = isset($_POST['Lon']) ? trim((string)$_POST['Lon']) : '';
$PrecRaw = isset($_POST['Precision']) ? trim((string)$_POST['Precision']) : '';
$GpsStatusRaw = isset($_POST['GpsStatus']) ? trim((string)$_POST['GpsStatus']) : '';

$Lat = (is_numeric($LatRaw) && (float)$LatRaw >= -90 && (float)$LatRaw <= 90) ? round((float)$LatRaw, 7) : null;
$Lon = (is_numeric($LonRaw) && (float)$LonRaw >= -180 && (float)$LonRaw <= 180) ? round((float)$LonRaw, 7) : null;
$GpsPrecision = (is_numeric($PrecRaw) && (float)$PrecRaw >= 0 && (float)$PrecRaw <= 1000000) ? round((float)$PrecRaw, 2) : null;
$GpsStatus = preg_replace('/[^A-Z0-9_]/', '', strtoupper(substr($GpsStatusRaw, 0, 30)));
if ($Lat !== null && $Lon !== null) {
    $GpsStatus = 'OK';
} elseif ($GpsStatus === '') {
    $GpsStatus = 'NO_ENVIADO';
}

$ipAcceso = obtenerIpClienteLogin();
$gpsResumen = ($Lat !== null && $Lon !== null)
    ? sprintf('%.7f, %.7f', $Lat, $Lon) . ($GpsPrecision !== null ? ' (±' . round($GpsPrecision) . 'm)' : '')
    : 'No disponible (' . $GpsStatus . ')';

$msg = "";

// Validar horario permitido de acceso (7:00 AM a 7:00 PM)
if (function_exists('itavu_en_horario_acceso') && !itavu_en_horario_acceso($IdEmpleado)) {
    $msg .= "Fuera de horario";
    toastLoginJs("El acceso a la plataforma solo está permitido de 7:00 AM a 7:00 PM.", "error");
    echo "<script>$('#R_login').html('<span style=\"color:#990000;font-weight:600;\">Acceso restringido: el horario de servicio es de 7:00 AM a 7:00 PM.</span>'); recargarCaptcha();</script>";
}

if ($msg == "" && $IdEmpleado == "") {
    $msg .= "Escribe el Numero de Empleado";
    toastLoginJs("Escribe el Número de Empleado", "error");
    echo "<script>$('#wrapUsuario').css('border-color','#e67e22');</script>";
} else {
    echo "<script>$('#wrapUsuario').css('border-color','#eee');</script>";
}

if ($msg == "" && $Password == "") {
    $msg .= ", Escribe un NIP";
    toastLoginJs("Escribe tu contraseña (NIP)", "error");
    echo "<script>$('#wrapPassword').css('border-color','#e67e22');</script>";
} else {
    echo "<script>$('#wrapPassword').css('border-color','#eee');</script>";
}

if ($msg == "" && $CaptchaInput == "") {
    $msg .= ", Escribe el código de verificación";
    toastLoginJs("Escribe el código CAPTCHA", "error");
    echo "<script>$('#wrapCaptcha').css('border-color','#e67e22'); $('#R_login').html('<span style=\"color:#b45309;\">Ingresa el código de verificación.</span>');</script>";
} else {
    echo "<script>$('#wrapCaptcha').css('border-color','#eee');</script>";
}

// Rate Limiting: verificar si la cuenta o la IP tienen un bloqueo temporal activo
if ($msg == "" && function_exists('itavu_ratelimit_verificar')) {
    $estadoRL = itavu_ratelimit_verificar($conexion, $IdEmpleado, $ipAcceso);
    if (!empty($estadoRL['bloqueado'])) {
        $mins = max(1, (int)$estadoRL['minutos_restantes']);
        $textoMins = ($mins === 1) ? '1 minuto' : ($mins . ' minutos');
        $msg .= "Rate limit activo";
        toastLoginJs("Acceso bloqueado temporalmente por intentos fallidos (" . $textoMins . ").", "error");
        echo "<script>$('#R_login').html('<span style=\"color:#990000;font-weight:600;\">Demasiados intentos fallidos. Tu acceso está bloqueado temporalmente; intenta de nuevo en " . $textoMins . ".</span>'); $('#Intentos').html('<b style=\"color:#990000;\">Bloqueo temporal activo (" . $textoMins . " restantes)</b>'); recargarCaptcha();</script>";
    }
}

// Si en config.php está activo $EXIGIR_geo_ini = TRUE, exigir coordenadas GPS válidas antes de continuar
if ($msg == "" && isset($EXIGIR_geo_ini) && $EXIGIR_geo_ini === TRUE && ($Lat === null || $Lon === null)) {
    $msg .= "GPS requerido";
    toastLoginJs("Debes permitir la ubicación GPS para ingresar", "error");
    echo "<script>$('#gpsBar').css('border-color','#c0392b'); $('#R_login').html('<span style=\"color:#990000;font-weight:600;\">Por seguridad es obligatorio autorizar tu ubicación GPS en el navegador para ingresar.</span>');</script>";
}

// Validación de CAPTCHA en sesión (expira a los 5 minutos y es de un solo uso)
if ($msg == "") {
    $captchaGuardado = isset($_SESSION['login_captcha']) ? strtoupper((string)$_SESSION['login_captcha']) : '';
    $captchaTiempo = isset($_SESSION['login_captcha_time']) ? (int)$_SESSION['login_captcha_time'] : 0;
    $captchaExpirado = ($captchaTiempo <= 0) || ((time() - $captchaTiempo) > 300);

    // Invalidar inmediatamente para evitar reutilización
    unset($_SESSION['login_captcha'], $_SESSION['login_captcha_time']);

    if ($captchaGuardado === '' || $captchaExpirado) {
        $msg .= "CAPTCHA expirado";
        toastLoginJs("El código de verificación expiró, intenta de nuevo", "error");
        echo "<script>$('#wrapCaptcha').css('border-color','#c0392b'); $('#R_login').html('<span style=\"color:#990000;\">El código de verificación expiró. Ingresa el nuevo código.</span>'); recargarCaptcha();</script>";
    } elseif (!hash_equals($captchaGuardado, $CaptchaInput)) {
        $msg .= "CAPTCHA incorrecto";
        toastLoginJs("Código de verificación incorrecto", "error");
        echo "<script>$('#wrapCaptcha').css('border-color','#c0392b'); $('#R_login').html('<span style=\"color:#990000;\">Código de verificación incorrecto.</span>'); recargarCaptcha();</script>";
    }
}

$LimiteDeIntentos = 8;
$AlertaDeIntentos = 3;

if ($msg == "") {
    // 1) Revisar bloqueo maestro sin re-incluir config en funciones auxiliares.
    $cuentaBloqueada = FALSE;
    $stmtBloqueo = $conexion->prepare("SELECT status FROM bloqueomaestro WHERE Nitavu = ? LIMIT 1");
    if ($stmtBloqueo) {
        $stmtBloqueo->bind_param("s", $IdEmpleado);
        if ($stmtBloqueo->execute()) {
            $resBloqueo = $stmtBloqueo->get_result();
            if ($rowBloqueo = $resBloqueo->fetch_assoc()) {
                $cuentaBloqueada = ($rowBloqueo['status'] != '0');
            }
        }
        $stmtBloqueo->close();
    }

    if ($cuentaBloqueada == TRUE) {
        echo "<script>$('#Intentos').html('<b style=color:red>Cuenta Bloqueada</b>'); recargarCaptcha();</script>";
    } else {
        // 2) Contar intentos fallidos de hoy (tag LOGIN, status abierto).
        $Intentos = 1;
        $stmtIntentos = $conexion->prepare("SELECT COUNT(*) AS n FROM problemas WHERE IdEmpleado = ? AND TAG = 'LOGIN' AND fecha = ? AND status = '0'");
        if ($stmtIntentos) {
            $stmtIntentos->bind_param("ss", $IdEmpleado, $fecha);
            if ($stmtIntentos->execute()) {
                $resIntentos = $stmtIntentos->get_result();
                if ($rowIntentos = $resIntentos->fetch_assoc()) {
                    $Intentos = ((int)$rowIntentos['n']) + 1;
                }
            }
            $stmtIntentos->close();
        }

        if ($Intentos <= $LimiteDeIntentos) {
            // 3) Validar estado laboral (bloquear Baja permanente o inactivos) y NIP contra empleados.
            $NIPValido = FALSE;
            $cuentaInactiva = FALSE;
            $estadoEmpleado = '';
            $esBajaPermanente = FALSE;

            $stmtNip = $conexion->prepare("SELECT nip, estado FROM empleados WHERE nitavu = ? LIMIT 1");
            if ($stmtNip) {
                $stmtNip->bind_param("s", $IdEmpleado);
                if ($stmtNip->execute()) {
                    $resNip = $stmtNip->get_result();
                    if ($rowNip = $resNip->fetch_assoc()) {
                        $estadoEmpleado = trim((string)($rowNip['estado'] ?? ''));
                        $esBajaPermanente = (strcasecmp($estadoEmpleado, 'Baja permanente') === 0);

                        if ($esBajaPermanente || $estadoEmpleado !== '') {
                            $cuentaInactiva = TRUE;
                        } else {
                            $NIPValido = hash_equals((string)$rowNip['nip'], (string)$Password);
                        }
                    }
                }
                $stmtNip->close();
            }

            if ($cuentaInactiva == TRUE) {
                $msgEstado = $esBajaPermanente
                    ? 'Acceso denegado: tu cuenta está registrada como Baja permanente.'
                    : 'Acceso denegado: tu cuenta no se encuentra activa (' . htmlspecialchars($estadoEmpleado, ENT_QUOTES, 'UTF-8') . ').';
                if (function_exists('itavu_ratelimit_registrar_fallo')) {
                    itavu_ratelimit_registrar_fallo($conexion, $IdEmpleado, $ipAcceso);
                }
                toastLoginJs($esBajaPermanente ? 'Acceso denegado: cuenta en Baja permanente' : 'Acceso denegado: cuenta inactiva', 'error');
                echo "<script>$('#R_login').html('<span style=\"color:#990000;font-weight:600;\">" . $msgEstado . "</span>'); recargarCaptcha();</script>";
                try {
                    Problema_create("LOGIN", "Intento de acceso denegado (Estado: " . $estadoEmpleado . ") | IP: " . $ipAcceso . " | GPS: " . $gpsResumen, $IdEmpleado);
                } catch (\Throwable $e) {
                    // Continuar sin romper la respuesta
                }
            } elseif ($NIPValido == TRUE) {
                // 1) Regenerar ID de sesión inmediatamente tras validar credenciales (previene Session Fixation)
                if (!headers_sent()) {
                    session_regenerate_id(true);
                }
                $_SESSION['nitavu'] = $IdEmpleado;
                $_SESSION['ultima_actividad'] = time();

                // 2) Limpiar contadores de intentos fallidos (Rate Limiting)
                if (function_exists('itavu_ratelimit_limpiar')) {
                    itavu_ratelimit_limpiar($conexion, $IdEmpleado, $ipAcceso);
                }

                // 3) Registrar sesión única simultánea (invalida sesiones previas en otros dispositivos)
                if (function_exists('itavu_sesion_registrar')) {
                    itavu_sesion_registrar($conexion, $IdEmpleado, $ipAcceso);
                }

                // 4) Registrar ingreso exitoso en la tabla historia con ubicación GPS e IP
                registrarLoginHistoria(
                    $conexion,
                    $ModoProduccion,
                    $fecha,
                    $hora,
                    $IdEmpleado,
                    $Lat,
                    $Lon,
                    $GpsPrecision,
                    $GpsStatus,
                    $ipAcceso
                );

                if (isset($_SESSION['nitavu']) && $_SESSION['nitavu'] == $IdEmpleado) {
                    toastLoginJs("Acceso concedido", "success");
                    echo "<script>$('#R_login').html('<span style=\"color:#16a34a;font-weight:600;\">Acceso concedido. Ingresando...</span>'); top.location.replace('index.php');</script>";
                } else {
                    echo "<script>$('#R_login').html('<span style=\"color:#990000;\">Hubo un problema al iniciar sesión.</span>'); recargarCaptcha();</script>";
                }
            } else {
                $rlFallo = function_exists('itavu_ratelimit_registrar_fallo')
                    ? itavu_ratelimit_registrar_fallo($conexion, $IdEmpleado, $ipAcceso)
                    : ['bloqueado_ahora' => false, 'intentos_cuenta' => 0, 'max_cuenta' => 5, 'minutos_bloqueo' => 15];

                if (!empty($rlFallo['bloqueado_ahora'])) {
                    $minBloq = (int)$rlFallo['minutos_bloqueo'];
                    toastLoginJs("Acceso bloqueado temporalmente por " . $minBloq . " minutos.", "error");
                    echo "<script>$('#R_login').html('<span style=\"color:#990000;font-weight:600;\">Has superado el límite de intentos fallidos. Tu acceso quedó bloqueado temporalmente durante " . $minBloq . " minutos.</span>'); $('#Intentos').html('<b style=\"color:#990000;\">Bloqueo temporal: " . $minBloq . " minutos</b>'); recargarCaptcha();</script>";
                } else {
                    $restantes = max(1, (int)$rlFallo['max_cuenta'] - (int)$rlFallo['intentos_cuenta']);
                    echo "<script>$('#R_login').html('<span style=\"color:#990000;\">Credenciales incorrectas</span>'); $('#Intentos').html('<span style=\"color:#b45309;\">Te quedan <b>" . $restantes . "</b> intento(s) antes del bloqueo temporal de " . (int)$rlFallo['minutos_bloqueo'] . " minutos.</span>'); recargarCaptcha();</script>";
                }

                try {
                    Problema_create("LOGIN", "Intento Fallido de Login | IP: " . $ipAcceso . " | GPS: " . $gpsResumen, $IdEmpleado);
                } catch (\Throwable $e) {
                    // Continuar sin romper la respuesta
                }
            }

            if ($NIPValido != TRUE && $Intentos > $AlertaDeIntentos) {
                echo "<script>$('#Intentos').append('<p style=font-size:9pt;margin-top:4px;><b>CUIDADO</b> Tu cuenta se bloqueará por completo a los " . $LimiteDeIntentos . " intentos fallidos del día (llevas " . $Intentos . ").</p>');</script>";
            }

            unset($IdEmpleado, $Password);
        } else {
            echo "<script>$('#R_login').html('Tu cuenta está bloqueada'); recargarCaptcha();</script>";
            toastLoginJs("Comunícate al Dpto. de Informática para solicitar el desbloqueo", "info");
            echo "<script>$('#Intentos').html('<b style=color:red>Cuenta Bloqueada</b>.<br>" . $Intentos . " intentos fallidos');</script>";
        }
    }
}

ob_end_flush();
?>
