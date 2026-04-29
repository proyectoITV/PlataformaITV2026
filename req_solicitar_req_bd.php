

<?php
include ("./lib/body_head.php");
?>

<?php

$id_aplicacion ="ap49";
$nivel =aplicacion_nivel($id_aplicacion, $nitavu);

if (sanpedro($id_aplicacion, $nitavu)==TRUE)
{




if (isset($_POST['btnAgrupar'])) 
{
 if(isset($_POST["idrequisiciones"]) && isset($_POST["idrequisiciones"])=="1")

{
 
 	 $selected = '';
         $num_countries = count($_POST['idrequisiciones']);
         $current = 0;
         foreach ($_POST['idrequisiciones'] as $key => $value) 
         {
             if ($current != $num_countries-1)
                 $selected .=  "(^".$value."$)|";
             else
                 $selected .= "(^".$value."$)";
           $current++;
       }
 

$sql ="CALL sp_agruparRequisiciones(".$nitavu.",'".$selected."')";

//echo $sql;
if ($conexion->query($sql) == TRUE) 
		{
			$msg="";
			
			
			historia($nitavu,'Req_Se han agrupado las requisiciones de los siguientes Dptos:'.$selected);			
			$msg = $msg."Se han agrupado las requisiciones seleccionadas";
			mensaje($msg,'req.php');
			//header('location:../index.php');	
		} 
	else 
		{
		$msg="Error inesperado ".$sql; //<-- Descripcion de error
		//creamos un historial de error extraordinario
		//header("location:../lib/error.php?er=".$msg);
		mensaje($msg,'req.php');
		} 

 }

 else
 {
 	 $selected = 'Debe seleccionar al menos una requisición';
 	 mensaje($selected,'req_solicitar_req.php');
 }



   
}  



			}
else{echo "<br><br>";echo "No tiene acceso a ".$id_aplicacion;}
?>