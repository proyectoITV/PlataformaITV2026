<?php
//AUTORIZACION PARA ADMINISTRADOR
//session_start();	
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