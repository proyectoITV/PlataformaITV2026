<?php
include ("lib/body_head.php");
?>

<?php

$nitavu_ = $_POST['empleado'];
$telefono = $_POST['telefono'];
$telefono_ext = $_POST['telefono_ext'];



if(BorrarExrensionAnterior($telefono_ext,$telefono)==TRUE)
{
$sql="UPDATE empleados SET telefono='$telefono', telefono_extension='$telefono_ext' WHERE nitavu='$nitavu_'";

//$resultado = $conexion -> query($sql);
if ($conexion->query($sql) == TRUE) 
		{

		$msg = "Excelente se ha actualizado con exito el telefono de ".$nitavu_;
		historia($nitavu,'Actualizo la extension de '.$nitavu_);
		$destino = "./index.php";
		mensaje($msg,'soporte_ext.php');

		//header('location:../index.php');	
		} 
	else 
		{
		$msg="Error inesperado ".$sql; //<-- Descripcion de error

		//creamos un historial de error extraordinario

		header("location:../lib/error.php?er=".$msg);	
		} 
}	

?>