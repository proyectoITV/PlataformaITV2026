<?php
require("seguridad.php");
require("plantilla-core.php");
require("lib/funciones.php");
require("config.php");
require("var_clean.php");

$IdPlantilla = 2;

$IdTrimeste = 123;
$Anio = 2020;
$Formato = "Lotes"; //Viviendas o Creditos

$id_aplicacion ="indicadores"; 
$nivel = aplicacion_nivel($id_aplicacion, $nitavu);
// $nivel = 1; //<--- Administrador completo
// $nivel = 2; //<--- Delegacion (Delegado)
$nivel = 3; //<--- Oficinas Centrales
// $nivel = 4; //<-- Capturista
if (isset($_GET['IdDelegacion'])){
    $IdDelegacion = VarClean($_GET['IdDelegacion']);
} else {
    $IdDelegacion = "";
}

if (sanpedro($id_aplicacion, $nitavu)==TRUE){

} else {
    echo "Sin acceso ";
}






?>