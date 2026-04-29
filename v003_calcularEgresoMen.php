<?php 
require_once("config.php");
require_once("lib/flor_funciones.php");
require_once("lib/funciones.php");

  $res = "";
  if (isset($_POST['FolioTramite'])){
    $FolioTramite = $_POST['FolioTramite'];
    $nitavu = $_POST['nitavu'];
    $res = calcularEgresoMensaul($FolioTramite);
    if (GuardarSolicitudDato($FolioTramite, 77, $res , "text", $nitavu, 10,1) == FALSE) {
      echo "<script>console.log('Error al guadar Folio: ".$FolioTramite.", el requisito: 77-EgresoMensual');</script>"; 
    }

    echo $res;
    
  }
?>
