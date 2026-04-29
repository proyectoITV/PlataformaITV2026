<?php
require("seguridad.php");
require("plantilla-core.php");
require("lib/funciones.php");
require("config.php");
require("var_clean.php");

$IdPlantilla = VarClean($_POST['IdPlantilla']);


$MiPlantilla = new Plantilla($IdPlantilla,$nitavu);
$MiPlantilla->setVC001("Juan Jose Pedraza Perales");
$MiPlantilla->setVC005("Test de Contrato con el Usuario ".$nitavu);
$MiPlantilla->Create();
if ($MiPlantilla->Exito == TRUE){
    echo $MiPlantilla->html;
} else {
    echo $MiPlantilla->Respuesta;
}







?>