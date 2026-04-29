<?php
require ("unica/config.php");
require ('unica/funciones.php');
// echo "<ul class='done'>";
//include ("./unica/body_head.php");

// $nitavuemp= $_POST['nitavu'];

$IdTipoTramite =$_POST['IdTipoTramite'];
$IdRequisito =$_POST['IdRequisito'];
$Clase =$_POST['Clase'];

$tipo = $_POST['tipo'];
if($tipo==1){

  $sql = 'INSERT INTO TramitesListaRequisitos(IdTipoTramite,IdRequisito, Clase)values("'.$IdTipoTramite.'",'.$IdRequisito.','.$Clase.')';
  //echo $sql;
  if ($conexion->query($sql) == TRUE){            
    echo 'agregue';
  }else{
    echo "error";
  }

}else{
  $sql = "DELETE FROM TramitesListaRequisitos WHERE IdTipoTramite=".$IdTipoTramite." and IdRequisito=".$IdRequisito."" ;
  //echo $sql;
    if ($conexion->query($sql) == TRUE){
      echo 'lo hice';
    }else{
      echo "error";
    }
}



?>


   