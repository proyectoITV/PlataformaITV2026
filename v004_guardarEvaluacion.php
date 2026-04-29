<?php 
require("seguridad.php"); 
require_once("config.php");
require_once("lib/funciones.php");
require_once("lib/flor_funciones.php");
require_once("lib/yes_funciones.php");
    
  if (isset($_POST['Folio'])){
    $FolioTramite = $_POST['FolioTramite'];
    $nitavu = $_POST['nitavu'];
    $IdPrograma = $_POST['IdPrograma'];
    $IdDelegacion = $_POST['IdDelegacion'];
    $Folio = $_POST['Folio'];
    
    $res =  enviarDatosEvaluacionaVivienda($FolioTramite, $nitavu,2, $IdPrograma, $IdDelegacion, $Folio);
  
    if($res==TRUE){
      actualizaraAprobadoContratar($IdDelegacion, $IdPrograma, $Folio, $nitavu);
      $sql = "UPDATE solicitudestemp SET Estado = 3 WHERE IdSolicitud = ".$FolioTramite."";
      //echo $sql;
      if ($conexion->query($sql) == TRUE) {
        echo 'Se actualizaron los datos con éxito';
      }else{
        echo 'Error al actualizar el estatus de la solicitud';
      }
    }else{
      echo 'Error al actualizar la evaluación, favor de intentarlo nuevamente';
    }
  }
?>