<?php
ob_start();
require("seguridad.php");
require("config.php");
require_once("lib/funciones.php");
require_once("lib/password_fun.php");

function responderNipJson($ok, $message, $errors = [], $extra = []) {
    if (ob_get_length()) {
        ob_clean();
    }
    header('Content-Type: application/json; charset=UTF-8');
    header('Cache-Control: no-store, no-cache, must-revalidate, max-age=0');
    echo json_encode(array_merge([
        'ok'      => (bool)$ok,
        'message' => (string)$message,
        'errors'  => array_values($errors),
    ], $extra), JSON_UNESCAPED_UNICODE);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    responderNipJson(false, 'Método de solicitud no permitido.');
}

if (!isset($nitavu) || trim((string)$nitavu) === '') {
    responderNipJson(false, 'Tu sesión ha expirado. Inicia sesión nuevamente.');
}

// 1) Validar token CSRF
$csrfRecibido = isset($_POST['csrf_token']) ? (string)$_POST['csrf_token'] : '';
$csrfEsperado = isset($_SESSION['csrf_nip_update']) ? (string)$_SESSION['csrf_nip_update'] : '';
if ($csrfEsperado === '' || !hash_equals($csrfEsperado, $csrfRecibido)) {
    responderNipJson(false, 'Token de seguridad inválido o expirado. Recarga la página e intenta de nuevo.');
}

// No pasar contraseñas por VarClean para conservar símbolos complejos (!@#$%&*_-)
$NipActual = isset($_POST['NipActual']) ? (string)$_POST['NipActual'] : '';
$NipNuevo1 = isset($_POST['NipNuevo1']) ? (string)$_POST['NipNuevo1'] : '';
$NipNuevo2 = isset($_POST['NipNuevo2']) ? (string)$_POST['NipNuevo2'] : '';

if ($NipActual === '' || $NipNuevo1 === '' || $NipNuevo2 === '') {
    responderNipJson(false, 'Todos los campos son obligatorios.');
}

// 2) Validar contraseña actual
if (PasswordCheck($nitavu, $NipActual) !== TRUE) {
    responderNipJson(false, 'La contraseña actual no coincide con la registrada en la plataforma.');
}

// 3) Validar confirmación
if (!hash_equals($NipNuevo1, $NipNuevo2)) {
    responderNipJson(false, 'La nueva contraseña y su confirmación no coinciden.');
}

// 4) Validar que sea distinta a la contraseña actual
if (hash_equals($NipActual, $NipNuevo1)) {
    responderNipJson(false, 'La nueva contraseña debe ser diferente a tu contraseña actual.');
}

// 5) Validar complejidad con el nuevo esquema de seguridad
$maxLen = itavu_nip_max_len($conexion);
$validacion = itavu_validar_password_segura($NipNuevo1, $nitavu, $maxLen);
if (!$validacion['valida']) {
    responderNipJson(
        false,
        'La nueva contraseña no cumple con los requisitos mínimos de seguridad.',
        $validacion['errores']
    );
}

// 6) Guardar nueva contraseña (con hash + sentencia preparada, sin exponer clave en historia)
if (PasswordHash_create($nitavu, $NipNuevo1) !== TRUE) {
    responderNipJson(false, 'Hubo un problema al actualizar tu contraseña. Intenta nuevamente.');
}

// Rotar token CSRF y regenerar ID de sesión tras cambio de contraseña
$_SESSION['csrf_nip_update'] = bin2hex(random_bytes(32));
if (!headers_sent()) {
    session_regenerate_id(true);
}

// 7) Notificación de confirmación SIN exponer la contraseña en texto plano
$notificado = false;
try {
    $Correo = CorreoForce($nitavu);
    $DestinoName = nitavu_nombre($nitavu);
    $Asunto = "Actualizaste tu contraseña en la Plataforma ITAVU";
    $Contenido = "
        <p>Buen día <b>" . htmlspecialchars((string)$DestinoName, ENT_QUOTES, 'UTF-8') . "</b>,</p>
        <p>Se ha actualizado con éxito tu contraseña en la Plataforma Informática de ITAVU el día <b>" . date('d/m/Y') . "</b> a las <b>" . date('H:i:s') . "</b>.</p>
        <p>Por seguridad, tu contraseña no se incluye en este mensaje. Recuerda no compartirla con nadie, ya que eres responsable de las operaciones realizadas con tu usuario.</p>
        <p>Si tú no realizaste este cambio, comunícate de inmediato al Departamento de Informática: <b>(834) 318 55 16</b> exts. <b>46580, 46530 y 46524</b>.</p>
    ";
    $notificado = (EnviarCorreo($Asunto, $Contenido, $Correo, $DestinoName, "", "", $nitavu) === TRUE);
} catch (\Throwable $e) {
    $notificado = false;
}

responderNipJson(
    true,
    $notificado
        ? 'Tu contraseña se actualizó correctamente y se envió una confirmación a tu cuenta.'
        : 'Tu contraseña se actualizó correctamente.',
    [],
    ['csrf_token' => $_SESSION['csrf_nip_update']]
);
