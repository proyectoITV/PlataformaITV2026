<?php
include ("./lib/body_head.php");
?>
<?php
$id_aplicacion ="ap49";
$nivel =aplicacion_nivel($id_aplicacion, $nitavu);

if (sanpedro($id_aplicacion, $nitavu)==TRUE)
{
$id = $_GET['n'];
$idDepartamento=nitavu_iddpto($nitavu);
$cantidad=1;
$idUnidad=1;



			if(requisicionIdConcepto_add($id, $cantidad, $idUnidad,$idDepartamento,$nitavu)==TRUE)
			{
				//historia ($nitavu,"Eliminó del cátalogo de cocneptos ".nombreIdConcepto($id));				
				mensaje ("agregado!!!!",'req.php');
			}
			else
			{
				$msg="Error inesperado "; //<-- Descripcion de error
			}
			
	   	}
else{echo "	<br><br>";echo "No tiene acceso a ".$id_aplicacion;}
?>