<?php
require_once("config.php");
require_once("lib/funciones.php");
require_once("lib/yes_funciones.php");
require_once("lib/flor_funciones.php");
$id = $_POST['id'];      
$nitavu= $_POST['nitavu'];  
 // // ACTUALIZMOS CONTROL CONTRATOS
//echo $nitavu;
 if(nitavu_dpto($nitavu)!=1)
 {
 $sql = "update historial_actividades set visto=1 where Id=(select MAX(Id)
 from historial_actividades where IdActividad=".$id.") and IdActividad=".$id ;
 //(echo $sql;
  if ($conexion->query($sql) == TRUE){   
  
   
      
        echo     sugerencia(UltimaObservacion($id));
     
  }else{
    echo  sugerencia("No fue posible ver la observación echa por el director"); ;
     
 } 
}else
{
    echo     sugerencia(UltimaObservacion($id));
     
}
?>