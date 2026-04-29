<?php
require ("config.php");
require ('lib/funciones.php');
// echo "<ul class='done'>";
//include ("./lib/body_head.php");

// $nitavuemp= $_POST['nitavu'];

$IdTipoTramite =$_POST['IdTipoTramite'];
$IdRequisito =$_POST['IdRequisito'];
$Clase =$_POST['Clase'];

$tipo = $_POST['tipo'];
if($tipo==1){

  $sql = 'INSERT INTO tramiteslistarequisitos(IdTipoTramite,IdRequisito, Clase)values("'.$IdTipoTramite.'",'.$IdRequisito.','.$Clase.')';
  //echo $sql;
  if ($conexion->query($sql) == TRUE){            
    echo 'agregue';
  }else{
    echo "error";
  }

}else{
  $sql = "DELETE FROM tramiteslistarequisitos WHERE IdTipoTramite=".$IdTipoTramite." and IdRequisito=".$IdRequisito."" ;
  //echo $sql;
    if ($conexion->query($sql) == TRUE){
      echo 'lo hice';
    }else{
      echo "error";
    }
}



?>


   