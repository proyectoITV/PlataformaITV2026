<?php
include ("lib/body_head.php");// Estructura de Plataforma
include ("lib/body_menu.php"); //interfaz de menus


$CorreoDestino = "printepolis@gmail.com";
$Asunto = "TEST ".$hora; $Contenido="Testing ".$fecha." ".$hora; 
if (EnviarCorreo($Asunto, $Contenido, $CorreoDestino,"","",$nitavu) == TRUE){
    echo "correo Enviado ".$CorreoDestino."";
} else {
    echo "Error al enviar el correo ".$CorreoDestino."";
}

include ("./lib/body_footer.php"); //Cierre de Estructura de la Plaforma
?>