<?php

require("config.php");
require_once('seguridad.php');
require_once('pdf/tcpdf.php');
//$nitavu="2809";
require('lib/yes_funciones.php');
require('lib/funciones.php');

error_reporting(0);

if (isset($_GET['NumContrato'])) {    

    $numcontrato=$_GET['NumContrato'];
    $idtipousosuelo=$_POST['usodesuelo'];
    $costoescritura=$_POST['costoescritura'];
    $observaciones=$_POST['observaciones'];
    $causahabientemenor=$_POST['causahabientemenor'];
    $causahabiente=$_POST['causahabiente'];
    // $clave_catastral=$_POST['cvecastral'];
   

    
if (isset($_POST['vista'])) 
{
  echo "vistA";
}
else if (isset($_POST['grabar'])) 
{
  /* GRABAR INFORMACION DEL LOTE  */
  $iddelegacion=str_pad($iddelegacion, 2, "0", STR_PAD_LEFT);
  $idprograma=str_pad($idprograma, 2, "0", STR_PAD_LEFT);
  $versionplano=ObtenerVersionPlanoLotes($idlote);
  $versionplano=str_pad($versionplano, 2, "0", STR_PAD_LEFT);
  $numescritura= $iddelegacion.  $idprograma.$idlote.$versionplano;

  $sqllote="Update lote set NumEscritura='".$numescritura."' , IdUsoDeSuelo=".$$idtipousosuelo.", CVE_CATASTRAL='".$clave_catastral."' where IdLote='".$idlote."'";
   echo $sqllote;
    // if ($Vivienda->query($sqllote) == TRUE){
    //     historia($nitavu, 'se actualizó de manera correcta los datos de la solicitud en la tabla Lotes');
    // }else{
    //     historia($nitavu, 'ERROR: al actualizar la informacion de la solicitud en la tabla lotes');
    // }
   
}

}

 
 else{
            mensaje('No se envio la informacion correctamente','');
}


?>