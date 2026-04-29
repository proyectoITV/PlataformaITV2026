<?php

//WIDGET PROTOTIPO

$nitavu = $_GET['nitavu'];
require_once("unica/config.php");
require_once("unica/funciones.php");
//mi turno actual

$TurnoActual =  MiTurnoActual($nitavu);
if ($TurnoActual == ""){
    echo "<b style='font-size:14pt;'>Sin Turno actualmente</b>";
} else {
    echo $TurnoActual;
}


//echo $tmp."</section>";
?>

