<?php
/**
 * Módulo de Seguridad Avanzada - Plataforma ITAVU
 * - Rate Limiting (bloqueo temporal por intentos fallidos por cuenta e IP)
 * - Control de inactividad (Session Timeout)
 * - Sesión única simultánea por empleado
 */

if (!function_exists('itavu_obtener_ip_cliente')) {
    function itavu_obtener_ip_cliente() {
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
}

if (!function_exists('itavu_asegurar_tablas_seguridad')) {
    function itavu_asegurar_tablas_seguridad($conexion) {
        static $verificado = false;
        if ($verificado) {
            return true;
        }
        if (!$conexion || !($conexion instanceof mysqli)) {
            return false;
        }
        $verificado = true;

        try {
            $conexion->query(
                "CREATE TABLE IF NOT EXISTS seguridad_intentos_login (
                    id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
                    tipo ENUM('USER','IP') NOT NULL,
                    clave VARCHAR(64) NOT NULL,
                    intentos INT UNSIGNED NOT NULL DEFAULT 0,
                    bloqueado_hasta DATETIME NULL DEFAULT NULL,
                    ultimo_intento DATETIME NOT NULL,
                    ip_origen VARCHAR(45) NULL DEFAULT NULL,
                    UNIQUE KEY uq_tipo_clave (tipo, clave),
                    KEY idx_bloqueado_hasta (bloqueado_hasta)
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4"
            );

            $conexion->query(
                "CREATE TABLE IF NOT EXISTS seguridad_sesiones_activas (
                    nitavu VARCHAR(30) NOT NULL PRIMARY KEY,
                    session_token VARCHAR(64) NOT NULL,
                    php_session_id VARCHAR(128) NOT NULL,
                    ip_acceso VARCHAR(45) NULL DEFAULT NULL,
                    user_agent VARCHAR(255) NULL DEFAULT NULL,
                    actualizado_en DATETIME NOT NULL
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4"
            );
            return true;
        } catch (\Throwable $e) {
            // Si el usuario de BD no tiene permisos CREATE TABLE, las consultas
            // individuales fallarán de forma controlada sin tumbar la plataforma.
            return false;
        }
    }
}

if (!function_exists('itavu_ratelimit_verificar')) {
    function itavu_ratelimit_verificar($conexion, $nitavu, $ip) {
        $activo = isset($GLOBALS['LoginRateLimitActivo']) ? (bool)$GLOBALS['LoginRateLimitActivo'] : true;
        $resp = [
            'bloqueado'          => false,
            'motivo'             => '',
            'minutos_restantes'  => 0,
            'segundos_restantes' => 0,
        ];

        if (!$activo || !$conexion || !($conexion instanceof mysqli)) {
            return $resp;
        }

        itavu_asegurar_tablas_seguridad($conexion);

        $chequeos = [];
        $nitavuNorm = trim((string)$nitavu);
        $ipNorm = trim((string)$ip);
        if ($nitavuNorm !== '') {
            $chequeos[] = ['USER', $nitavuNorm];
        }
        if ($ipNorm !== '' && $ipNorm !== 'DESCONOCIDA') {
            $chequeos[] = ['IP', $ipNorm];
        }

        try {
            $stmt = $conexion->prepare(
                "SELECT bloqueado_hasta, TIMESTAMPDIFF(SECOND, NOW(), bloqueado_hasta) AS seg_restantes
                 FROM seguridad_intentos_login
                 WHERE tipo = ? AND clave = ? AND bloqueado_hasta IS NOT NULL AND bloqueado_hasta > NOW()
                 LIMIT 1"
            );
            if ($stmt) {
                foreach ($chequeos as $par) {
                    $tipo = $par[0];
                    $clave = $par[1];
                    $stmt->bind_param("ss", $tipo, $clave);
                    if ($stmt->execute()) {
                        $res = $stmt->get_result();
                        if ($row = $res->fetch_assoc()) {
                            $seg = max(1, (int)$row['seg_restantes']);
                            if ($seg > $resp['segundos_restantes']) {
                                $resp['bloqueado'] = true;
                                $resp['motivo'] = $tipo;
                                $resp['segundos_restantes'] = $seg;
                                $resp['minutos_restantes'] = (int)ceil($seg / 60);
                            }
                        }
                    }
                }
                $stmt->close();
            }
        } catch (\Throwable $e) {
            return $resp;
        }

        return $resp;
    }
}

if (!function_exists('itavu_ratelimit_incrementar_clave')) {
    function itavu_ratelimit_incrementar_clave($conexion, $tipo, $clave, $maxIntentos, $minutosBloqueo, $ipOrigen) {
        $intentos = 1;
        $bloqueadoAhora = false;

        try {
            $stmtSel = $conexion->prepare(
                "SELECT intentos,
                        TIMESTAMPDIFF(MINUTE, ultimo_intento, NOW()) AS mins_desde_ultimo,
                        (bloqueado_hasta IS NOT NULL AND bloqueado_hasta <= NOW()) AS bloqueo_expirado
                 FROM seguridad_intentos_login
                 WHERE tipo = ? AND clave = ?
                 LIMIT 1"
            );
            $existe = false;
            if ($stmtSel) {
                $stmtSel->bind_param("ss", $tipo, $clave);
                if ($stmtSel->execute()) {
                    $res = $stmtSel->get_result();
                    if ($row = $res->fetch_assoc()) {
                        $existe = true;
                        $minsDesdeUltimo = (int)$row['mins_desde_ultimo'];
                        $bloqueoExpirado = ((int)$row['bloqueo_expirado'] === 1);
                        if ($bloqueoExpirado || $minsDesdeUltimo >= $minutosBloqueo) {
                            $intentos = 1;
                        } else {
                            $intentos = ((int)$row['intentos']) + 1;
                        }
                    }
                }
                $stmtSel->close();
            }

            $bloqueadoAhora = ($intentos >= $maxIntentos);

            if ($existe) {
                if ($bloqueadoAhora) {
                    $stmtUpd = $conexion->prepare(
                        "UPDATE seguridad_intentos_login
                         SET intentos = ?, bloqueado_hasta = DATE_ADD(NOW(), INTERVAL ? MINUTE), ultimo_intento = NOW(), ip_origen = ?
                         WHERE tipo = ? AND clave = ?"
                    );
                    if ($stmtUpd) {
                        $stmtUpd->bind_param("iisss", $intentos, $minutosBloqueo, $ipOrigen, $tipo, $clave);
                        $stmtUpd->execute();
                        $stmtUpd->close();
                    }
                } else {
                    $stmtUpd = $conexion->prepare(
                        "UPDATE seguridad_intentos_login
                         SET intentos = ?, bloqueado_hasta = NULL, ultimo_intento = NOW(), ip_origen = ?
                         WHERE tipo = ? AND clave = ?"
                    );
                    if ($stmtUpd) {
                        $stmtUpd->bind_param("isss", $intentos, $ipOrigen, $tipo, $clave);
                        $stmtUpd->execute();
                        $stmtUpd->close();
                    }
                }
            } else {
                if ($bloqueadoAhora) {
                    $stmtIns = $conexion->prepare(
                        "INSERT INTO seguridad_intentos_login (tipo, clave, intentos, bloqueado_hasta, ultimo_intento, ip_origen)
                         VALUES (?, ?, ?, DATE_ADD(NOW(), INTERVAL ? MINUTE), NOW(), ?)"
                    );
                    if ($stmtIns) {
                        $stmtIns->bind_param("ssiis", $tipo, $clave, $intentos, $minutosBloqueo, $ipOrigen);
                        $stmtIns->execute();
                        $stmtIns->close();
                    }
                } else {
                    $stmtIns = $conexion->prepare(
                        "INSERT INTO seguridad_intentos_login (tipo, clave, intentos, bloqueado_hasta, ultimo_intento, ip_origen)
                         VALUES (?, ?, ?, NULL, NOW(), ?)"
                    );
                    if ($stmtIns) {
                        $stmtIns->bind_param("ssis", $tipo, $clave, $intentos, $ipOrigen);
                        $stmtIns->execute();
                        $stmtIns->close();
                    }
                }
            }
        } catch (\Throwable $e) {
            return ['intentos' => 0, 'bloqueado_ahora' => false];
        }

        return ['intentos' => $intentos, 'bloqueado_ahora' => $bloqueadoAhora];
    }
}

if (!function_exists('itavu_ratelimit_registrar_fallo')) {
    function itavu_ratelimit_registrar_fallo($conexion, $nitavu, $ip) {
        $activo = isset($GLOBALS['LoginRateLimitActivo']) ? (bool)$GLOBALS['LoginRateLimitActivo'] : true;
        $maxCuenta = isset($GLOBALS['LoginMaxIntentosCuenta']) ? max(1, (int)$GLOBALS['LoginMaxIntentosCuenta']) : 5;
        $maxIp = isset($GLOBALS['LoginMaxIntentosIP']) ? max(1, (int)$GLOBALS['LoginMaxIntentosIP']) : 5;
        $minBloqueo = isset($GLOBALS['LoginBloqueoMinutos']) ? max(1, (int)$GLOBALS['LoginBloqueoMinutos']) : 15;

        $res = [
            'bloqueado_ahora' => false,
            'intentos_cuenta' => 0,
            'intentos_ip'     => 0,
            'max_cuenta'      => $maxCuenta,
            'max_ip'          => $maxIp,
            'minutos_bloqueo' => $minBloqueo,
        ];

        if (!$activo || !$conexion || !($conexion instanceof mysqli)) {
            return $res;
        }

        itavu_asegurar_tablas_seguridad($conexion);

        $nitavuNorm = trim((string)$nitavu);
        $ipNorm = trim((string)$ip);

        if ($nitavuNorm !== '') {
            $rUser = itavu_ratelimit_incrementar_clave($conexion, 'USER', $nitavuNorm, $maxCuenta, $minBloqueo, $ipNorm);
            $res['intentos_cuenta'] = $rUser['intentos'];
            if ($rUser['bloqueado_ahora']) {
                $res['bloqueado_ahora'] = true;
            }
        }

        if ($ipNorm !== '' && $ipNorm !== 'DESCONOCIDA') {
            $rIp = itavu_ratelimit_incrementar_clave($conexion, 'IP', $ipNorm, $maxIp, $minBloqueo, $ipNorm);
            $res['intentos_ip'] = $rIp['intentos'];
            if ($rIp['bloqueado_ahora']) {
                $res['bloqueado_ahora'] = true;
            }
        }

        return $res;
    }
}

if (!function_exists('itavu_ratelimit_limpiar')) {
    function itavu_ratelimit_limpiar($conexion, $nitavu, $ip) {
        if (!$conexion || !($conexion instanceof mysqli)) {
            return;
        }
        try {
            $nitavuNorm = trim((string)$nitavu);
            $ipNorm = trim((string)$ip);
            $stmt = $conexion->prepare("DELETE FROM seguridad_intentos_login WHERE tipo = ? AND clave = ?");
            if ($stmt) {
                if ($nitavuNorm !== '') {
                    $tipo = 'USER';
                    $stmt->bind_param("ss", $tipo, $nitavuNorm);
                    $stmt->execute();
                }
                if ($ipNorm !== '' && $ipNorm !== 'DESCONOCIDA') {
                    $tipo = 'IP';
                    $stmt->bind_param("ss", $tipo, $ipNorm);
                    $stmt->execute();
                }
                $stmt->close();
            }
        } catch (\Throwable $e) {
            // Silencioso si la tabla no existe aún
        }
    }
}

if (!function_exists('itavu_sesion_registrar')) {
    function itavu_sesion_registrar($conexion, $nitavu, $ip = '') {
        $token = bin2hex(random_bytes(32));
        $_SESSION['session_token'] = $token;
        $_SESSION['ultima_actividad'] = time();

        $activa = isset($GLOBALS['SesionUnicaActiva']) ? (bool)$GLOBALS['SesionUnicaActiva'] : true;
        if (!$activa || !$conexion || !($conexion instanceof mysqli) || trim((string)$nitavu) === '') {
            return $token;
        }

        itavu_asegurar_tablas_seguridad($conexion);

        try {
            $nitavuStr = (string)$nitavu;
            $phpSid = (string)session_id();
            $ipStr = ($ip !== '') ? substr((string)$ip, 0, 45) : itavu_obtener_ip_cliente();
            $ua = isset($_SERVER['HTTP_USER_AGENT']) ? substr((string)$_SERVER['HTTP_USER_AGENT'], 0, 255) : '';

            $stmt = $conexion->prepare(
                "INSERT INTO seguridad_sesiones_activas (nitavu, session_token, php_session_id, ip_acceso, user_agent, actualizado_en)
                 VALUES (?, ?, ?, ?, ?, NOW())
                 ON DUPLICATE KEY UPDATE
                    session_token = VALUES(session_token),
                    php_session_id = VALUES(php_session_id),
                    ip_acceso = VALUES(ip_acceso),
                    user_agent = VALUES(user_agent),
                    actualizado_en = NOW()"
            );
            if ($stmt) {
                $stmt->bind_param("sssss", $nitavuStr, $token, $phpSid, $ipStr, $ua);
                $stmt->execute();
                $stmt->close();
            }
        } catch (\Throwable $e) {
            // No bloquear login si la tabla aún no existe
        }

        return $token;
    }
}

if (!function_exists('itavu_sesion_validar_unica')) {
    function itavu_sesion_validar_unica($conexion, $nitavu) {
        $activa = isset($GLOBALS['SesionUnicaActiva']) ? (bool)$GLOBALS['SesionUnicaActiva'] : true;
        if (!$activa || !$conexion || !($conexion instanceof mysqli) || trim((string)$nitavu) === '') {
            return true;
        }

        itavu_asegurar_tablas_seguridad($conexion);

        try {
            $nitavuStr = (string)$nitavu;
            $stmt = $conexion->prepare("SELECT session_token FROM seguridad_sesiones_activas WHERE nitavu = ? LIMIT 1");
            if (!$stmt) {
                return true;
            }
            $stmt->bind_param("s", $nitavuStr);
            if ($stmt->execute()) {
                $res = $stmt->get_result();
                if ($row = $res->fetch_assoc()) {
                    $tokenBd = (string)$row['session_token'];
                    $tokenSesion = isset($_SESSION['session_token']) ? (string)$_SESSION['session_token'] : '';
                    $stmt->close();
                    if ($tokenSesion === '' || !hash_equals($tokenBd, $tokenSesion)) {
                        return false;
                    }
                    return true;
                } else {
                    $stmt->close();
                    // Transición limpia: si no había registro aún para una sesión previa al despliegue, registrarla ahora
                    itavu_sesion_registrar($conexion, $nitavuStr);
                    return true;
                }
            }
            $stmt->close();
        } catch (\Throwable $e) {
            return true;
        }

        return true;
    }
}

if (!function_exists('itavu_sesion_eliminar')) {
    function itavu_sesion_eliminar($conexion, $nitavu, $token = '') {
        if (!$conexion || !($conexion instanceof mysqli) || trim((string)$nitavu) === '') {
            return;
        }
        try {
            $nitavuStr = (string)$nitavu;
            $tokenStr = (string)$token;
            if ($tokenStr !== '') {
                // Solo borrar si el token coincide, para que una sesión desplazada nunca cierre la nueva sesión
                $stmt = $conexion->prepare("DELETE FROM seguridad_sesiones_activas WHERE nitavu = ? AND session_token = ?");
                if ($stmt) {
                    $stmt->bind_param("ss", $nitavuStr, $tokenStr);
                    $stmt->execute();
                    $stmt->close();
                }
            }
        } catch (\Throwable $e) {
            // Silencioso
        }
    }
}

if (!function_exists('itavu_destruir_sesion_y_redirigir')) {
    function itavu_destruir_sesion_y_redirigir($motivoQuery, $conexion = null, $eliminarTokenEnBd = true) {
        $nitavuTmp = isset($_SESSION['nitavu']) ? (string)$_SESSION['nitavu'] : '';
        $tokenTmp = isset($_SESSION['session_token']) ? (string)$_SESSION['session_token'] : '';

        if ($eliminarTokenEnBd && $conexion && $nitavuTmp !== '' && $tokenTmp !== '') {
            itavu_sesion_eliminar($conexion, $nitavuTmp, $tokenTmp);
        }

        $_SESSION = [];
        if (ini_get('session.use_cookies')) {
            $params = session_get_cookie_params();
            setcookie(
                session_name(),
                '',
                time() - 42000,
                $params['path'],
                $params['domain'],
                $params['secure'],
                $params['httponly']
            );
        }
        if (session_status() === PHP_SESSION_ACTIVE) {
            session_destroy();
        }

        $base = file_exists('login.php') ? 'login.php' : '../login.php';
        $loginUrl = $base . ($motivoQuery !== '' ? ('?' . $motivoQuery) : '');
        $esAjax = !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';

        if (!$esAjax && !headers_sent()) {
            header('Location: ' . $loginUrl);
        }
        echo '<script>top.location.replace(' . json_encode($loginUrl) . ');</script>';
        exit;
    }
}

