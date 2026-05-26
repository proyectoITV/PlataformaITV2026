<?php
//AUTORIZACION PARA ADMINISTRADOR
if (session_status() === PHP_SESSION_NONE) {
	@ini_set('session.use_cookies', '1');
	@ini_set('session.use_only_cookies', '1');
	@ini_set('session.use_trans_sid', '0');
	session_start();
	if (!headers_sent() && !isset($_COOKIE[session_name()])) {
		setcookie(session_name(), session_id(), 0, '/');
	}
}
if (isset($_SESSION['nitavu'])){
	require("config.php");
	require("funciones.php");
	$nitavu = $_SESSION['nitavu'];
} else {
		$_SESSION = array(); 
		session_destroy();		
		unset($nitavu);
		header("location:login.php?info=Sesion Expirada");	
}

?>