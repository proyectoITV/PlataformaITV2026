<?php 
require_once("config.php");
require_once("lib/flor_funciones.php");
require_once("lib/funciones.php");

    $res = "";
  if (isset($_POST['FolioTramite'])){
    $FolioTramite = $_POST['FolioTramite'];
    $nitavu = $_POST['nitavu'];
   $sql = 'SELECT sum(Dato) as ingresoMensual from solicitudesinformacion WHERE IdSolicitud = '.$FolioTramite.' and IdRequisito = 28 and (Clase = 4 or Clase = 2)';
   $rc= $conexion -> query($sql);
   if($f = $rc -> fetch_array()){
      $res =  $f['ingresoMensual'];
      if (GuardarSolicitudDato($FolioTramite, 76, $res , "text", $nitavu, 10,1) == FALSE) {
          echo "<script>console.log('Error al guadar Folio: ".$FolioTramite.", el requisito: 76-IngresoMensualFamiliar');</script>"; 
        }

   }else{
      $res = '0';
   } 
   echo $res;
    
  }
?>
