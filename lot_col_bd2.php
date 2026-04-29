<?php
require_once("config.php");
require_once("lib/funciones.php");
require_once("lib/yes_funciones.php");



$Funcion=$_POST['Funcion'];

$IdMunicipio = $_POST['IdMunicipio'];      
$IdColonia = $_POST['IdColonia'];       
$Campo=$_POST['Campo'];

    echo ValidarDatoActualColonia($IdMunicipio,$IdColonia, $Campo);


    

    
?>