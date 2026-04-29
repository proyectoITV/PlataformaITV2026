<?php
include ("head.php");


$CorreoDestino = "printepolis@gmail.com";
$Asunto = "Test";
$ContenidoDelCorreo = "<p>Hola Mundo </p>";
EnviarCorreo($CorreoDestino, $Asunto, $ContenidoDelCorreo);



include ("footer.php");
?>