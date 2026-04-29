<?php
require("unica/seguridad.php"); 

if ($_GET['tipo']=='pesos'){
    $valor = $_GET['valor'];

    $salida = "$ ".number_format($valor,2,'.',',');

    echo $salida;
}

// echo ":)";


?>

