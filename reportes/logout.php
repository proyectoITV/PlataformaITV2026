<?php 	require("components.php"); ?>
<?php 	require_once("rintera-config.php"); ?>
<?php 


$nitavu = "";
$nitavuName = "";

 //Crear sesión
 session_name($SesionName);
 session_start();

 //Vaciar sesión
 $_SESSION = array();


 SESSION_close(session_id());
 //Destruir Sesión
 session_unset();
 session_destroy();
 
  

 if(isset($_COOKIE[session_name()])) { 
    setcookie(session_name(), '', time() - 42000, '/'); 
  } 
  
unset($_SESSION['nitavu']);
 //Redireccionar a login.php

header("location:../index.php");

?>