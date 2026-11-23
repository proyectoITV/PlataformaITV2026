<?php
if (session_status() == PHP_SESSION_NONE) {
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
ob_start();

if (isset($_SESSION['nitavu'])) {
    // 1) Validar que la sesión activa esté dentro del horario permitido (7:00 AM a 7:00 PM)
    if (function_exists('itavu_en_horario_acceso') && !itavu_en_horario_acceso($_SESSION['nitavu'])) {
        itavu_destruir_sesion_y_redirigir('fuera_horario=1', $conexion, true);
    }

    // 2) Validar tiempo máximo de inactividad (Session Timeout)
    $limiteInactividadSeg = (isset($SessionInactividadMin) && (int)$SessionInactividadMin > 0)
        ? ((int)$SessionInactividadMin * 60)
        : 900;
    if (isset($_SESSION['ultima_actividad']) && (time() - (int)$_SESSION['ultima_actividad']) > $limiteInactividadSeg) {
        itavu_destruir_sesion_y_redirigir('inactividad=1', $conexion, true);
    }

    // 3) Validar que el empleado siga activo (bloquear Baja permanente o cualquier estado inactivo)
    if (function_exists('itavu_empleado_estado_acceso')) {
        $estadoAcceso = itavu_empleado_estado_acceso($conexion, $_SESSION['nitavu']);
        if (!$estadoAcceso['existe'] || !$estadoAcceso['activo']) {
            itavu_destruir_sesion_y_redirigir('cuenta_baja=1', $conexion, true);
        }
    }

    // 4) Validar sesión única simultánea (si inició sesión en otro dispositivo/navegador, cerrar esta)
    if (function_exists('itavu_sesion_validar_unica') && !itavu_sesion_validar_unica($conexion, $_SESSION['nitavu'])) {
        // eliminarTokenEnBd = false para no borrar el token nuevo del dispositivo más reciente
        itavu_destruir_sesion_y_redirigir('sesion_duplicada=1', $conexion, false);
    }

    // Actualizar marca de actividad en cada petición válida
    $_SESSION['ultima_actividad'] = time();

    $nitavu = $_SESSION['nitavu'];
    $MyIp = '';
} else {
    if (isset($_GET['location'])) {
        $location = $_GET['location'];
    } else {
        $location = "";
    }

    if ($location <> '') {
        echo '<script>window.location.replace("login.php?location=' . htmlspecialchars($location, ENT_QUOTES, 'UTF-8') . '")</script>';
    } else {
        echo '<script>window.location.replace("login.php?nos=")</script>';
    }
}
?>
