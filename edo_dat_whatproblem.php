<?php
// require("seguridad.php"); 
require_once("config.php");
require_once("lib/funciones.php");
require_once("lib/flor_funciones.php");
require("lib/curp_fun.php");
require("var_clean.php");
$id_aplicacion ="v002";
// error_reporting(0); //<-- para simular produccion
$IdProblema = VarClean($_POST['IdProblema']);
// sleep(10);
echo ProblemaName($IdProblema);
echo "<script>$('#PanelLoader').css('background-color','#ff5400');</script>";
?>

