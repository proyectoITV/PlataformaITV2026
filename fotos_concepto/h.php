<?php
require("unica/config.php"); require("unica/funciones.php");
//include("unica/geo.php");

$quien=$_GET['id'];
$descripcion=$_GET['l'];
$descripcion= "<b class=alerta>LOG EXTERNO:</b><br>".$descripcion;
echo historia($quien,$descripcion);



?>

