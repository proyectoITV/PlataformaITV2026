<?php
require ("config.php");
require ("lib/flor_funciones.php");

$idmandante = $_POST['idmandante'];
$idcolonia = $_POST['idcolonia'];
$idmunicipio = $_POST['idmunicipio'];

echo GastosEscMandante($idmandante,$idcolonia,$idmunicipio);
    
?>