<?php

//WIDGET PROTOTIPO

$nitavu = $_GET['nitavu'];
require_once("config.php");
require_once("lib/funciones.php");
//mi turno actual

$TurnoActual =  MiTurnoActual($nitavu);
if ($TurnoActual == ""){
    echo "<b style='font-size:14pt;'>Sin Turno actualmente</b>";
} else {
    echo $TurnoActual;
    echo "<br><span style='font-size:8pt; color:gray; font-family:Light;'>".MiTurnoActual_Detalle($nitavu)."</span>";
}


//echo $tmp."</section>";
?>

