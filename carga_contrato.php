<?php
require("seguridad.php");
require("plantilla-core.php");
require("lib/funciones.php");
require("config.php");
require("var_clean.php");



$IdPlantilla = VarClean($_GET['IdPlantilla']);

$lote = VarClean($_GET['lote']);
$manzana = VarClean($_GET['manzana']);
$nomcolonia = VarClean($_GET['nomcolonia']);
$superficie = VarClean($_GET['superficie']);
$colindancia1 = VarClean($_GET['colindancia1']);
$colindancia2 = VarClean($_GET['colindancia2']);
$colindancia3 = VarClean($_GET['colindancia3']);
$colindancia4 = VarClean($_GET['colindancia4']);
$beneficiario = VarClean($_GET['beneficiario']);

$fechaComoEntero = strtotime($fecha);
$anio = date("Y", $fechaComoEntero);
$mes = date("m", $fechaComoEntero);
$dia = date("d", $fechaComoEntero);
$meses = ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"];
$mesletra = $meses[$mes - 1];



$MiPlantilla = new Plantilla($IdPlantilla,$nitavu);
$MiPlantilla->setVC001($beneficiario);
$MiPlantilla->setVC002($lote);
$MiPlantilla->setVC003($manzana);
$MiPlantilla->setVC004($nomcolonia);
$MiPlantilla->setVC005($superficie);
$MiPlantilla->setVC006($colindancia1);
$MiPlantilla->setVC007($colindancia2);
$MiPlantilla->setVC008($colindancia3);
$MiPlantilla->setVC009($colindancia4);
$MiPlantilla->setVC010($dia);
$MiPlantilla->setVC011($mesletra);
$MiPlantilla->setVC012($anio);
$MiPlantilla->setVC013($beneficiario);
$MiPlantilla->Create();
if ($MiPlantilla->Exito == TRUE){
    echo $MiPlantilla->html;
} else {
    echo $MiPlantilla->Respuesta;
}







?>