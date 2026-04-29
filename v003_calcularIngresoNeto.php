<?php 
require_once("config.php");
require_once("lib/flor_funciones.php");
require_once("lib/funciones.php");

    $res = "";
  if (isset($_POST['FolioTramite'])){
    $FolioTramite = $_POST['FolioTramite'];
    $nitavu = $_POST['nitavu'];
   $sql = 'Select (Select Dato  from solicitudesinformacion WHERE IdSolicitud = '.$FolioTramite.' and Clase = 10 and IdRequisito = 76 ) - 
   (Select Dato  from solicitudesinformacion WHERE IdSolicitud = '.$FolioTramite.' and Clase = 10 and IdRequisito = 77 limit 1) Total';
   //echo $sql;
   $rc= $conexion -> query($sql);
   if($f = $rc -> fetch_array()){
      $res =  $f['Total'];
      if (GuardarSolicitudDato($FolioTramite, 85, $res , "text", $nitavu, 10,1) == FALSE) {
          echo "<script>console.log('Error al guadar Folio: ".$FolioTramite.", el requisito: 85-Ingreso Neto');</script>"; 
        }

   }else{
      $res = '0';
   } 
   echo $res;
    
  }
?>
