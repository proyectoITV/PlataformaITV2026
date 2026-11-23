<?php
// Iniciar la sesión
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once("config.php");

// Eliminar el registro de sesión activa en BD solo si coincide con el token actual
if (isset($_SESSION['nitavu']) && isset($_SESSION['session_token']) && function_exists('itavu_sesion_eliminar')) {
    itavu_sesion_eliminar($conexion, $_SESSION['nitavu'], $_SESSION['session_token']);
}

// Destruir todas las variables de sesión
$_SESSION = array();

// Borrar también la cookie de sesión
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(
        session_name(),
        '',
        time() - 42000,
        $params["path"],
        $params["domain"],
        $params["secure"],
        $params["httponly"]
    );
}

// Finalmente, destruir la sesión
session_destroy();

// Redirigir al login con el motivo correspondiente
if (isset($_GET['fuera_horario'])) {
    header("Location: login.php?fuera_horario=1");
} elseif (isset($_GET['inactividad'])) {
    header("Location: login.php?inactividad=1");
} elseif (isset($_GET['sesion_duplicada'])) {
    header("Location: login.php?sesion_duplicada=1");
} else {
    header("Location: index.php");
}
exit;
?>
