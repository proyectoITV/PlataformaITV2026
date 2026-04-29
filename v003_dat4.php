<?php 
require_once("seguridad.php"); 
require_once("config.php");
require_once("lib/funciones.php");
require_once("lib/flor_funciones.php");
require_once("lib/yes_funciones.php");
    
  if (isset($_POST['Folio'])){
    $FolioTramite = $_POST['Folio'];
    $nitavu = $_POST['nitavu'];
    $Porcentaje = Procentajesolicitudestemp($FolioTramite);
    if($Porcentaje >= 100){

      $IdPrograma = SolicitudPrograma($FolioTramite);
      $IdDelegacion = SolicitudDelegacion($FolioTramite);

      //VALIDAMOS TECHO FINANCIERO
      $recursoActual =  Valida_TechoFinanciero( $IdDelegacion, $IdPrograma);
      if($recursoActual <= 0){
        return 'Imposible continuar, no hay recurso para este programa';
      }



     //enviarDatosaVivienda($FolioTramite, $IdPrograma, $IdDelegacion, $Folio, $IdSolicitante, $origenDeEnvio, $tipoInfo, $nitavu, $operacion) 
     //EN OPERACION MANDAMOS UN 1 POR QUE ES UN INSERT 
     echo enviarDatosaVivienda($FolioTramite, '','','','','',1,$nitavu,1,'');
    }else{
      echo 'Aun faltan datos obligatorios por captruar';
    }

    
  }
?>
