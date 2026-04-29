<?php
require("seguridad.php"); 

if ($_GET['tipo']=='pesos'){
    $valor = $_GET['valor'];

    // echo $_GET['valor']; $salida = 0;

    $salida = "$ ".number_format($valor,2,'.',',');

    echo $salida;
}

// echo ":)";


?>

