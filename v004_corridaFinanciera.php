<?php
require_once("config.php");
require_once("lib/funciones.php");
require_once("lib/flor_funciones.php");

$FolioTramite = $_POST['FolioTramite'];
$nitavu = $_POST['nitavu'];
$IdPrograma = $_POST['IdPrograma'];
$IdDelegacion = $_POST['IdDelegacion'];
if(isset($_POST['FolioVivienda'])){
  $FolioVivienda = $_POST['FolioVivienda'];

  //REVISAMOS SI YA SE HABIAN GUARDADO LOS DATOS PARA YA NO HACERLO
$corrida = revisarSiYaSeCreoCorridaFinanciera($FolioTramite);

  if($corrida == 0){
    crearCorridaFinanciera($FolioTramite, $IdPrograma, $IdDelegacion, $FolioVivienda, $nitavu);
  }else{
    echo "Anteriormente se habían generado los registros de la corrida financiera.";
  }
}else{
  echo "No existe un FolioVivienda en la Solicitud, favor de comunicarse con el Dpto. de Informática.";
}





?>