<?php
include ("./lib/body_head.php");
?>

<?php

$nip_old = $_POST['nip_old'];
$nip_new = $_POST['nip_new'];
$nitavu =  $_POST['nitavu_']; 



$sql="UPDATE empleados SET nip='".$nip_new."' WHERE nitavu='".$nitavu."'";

//echo $sql;
//$resultado = $conexion -> query($sql);
if ($conexion->query($sql) == TRUE) 
		{

		$msg = "Excelente para la seguridad de tu cuenta, NIP actualizado con exito".$sql;
		historia($nitavu,'Actualizo su NIP');		
		mensaje("NIP cambiado con exito",'');

		//header('location:../index.php');	
		} 
	else 
		{
		$msg="Error inesperado ".$sql; //<-- Descripcion de error

		//creamos un historial de error extraordinario

		header("location:../lib/error.php?er=".$msg);	
		} 
		

?>