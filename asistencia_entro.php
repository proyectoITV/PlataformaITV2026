<?php
include ("./lib/body_head.php");
?>

<?php 	require("seguridad.php"); ?>
<?php 	//require("lib/funciones.php"); ?>
<?php 	include_once("lib/funciones.php"); ?>
<?php 	//require("cano_funciones.php"); ?>
<?php 	//require("laura_funciones.php"); ?>
<?php 	//require("yes_funciones.php"); ?>
<?php 	require("config.php"); ?>
<?php // error_reporting(E_ALL ^ E_NOTICE);
?>
<?php
$id = $_GET['id'];
$idapp = 'ap13'; //app de vigilancia




$sql = "SELECT * FROM aplicaciones_permisos WHERE (nitavu='".$nitavu."' AND idapp='".$idapp."')";
$rc= $conexion -> query($sql);
//echo $sql;
if($f = $rc -> fetch_array()){ // SE ENCONTRARON PERMISOS Y SE ACTUALIZARON

		$sql = "INSERT INTO asistencia
		(nitavu, fecha, entrada, verificador)
		VALUES
		('$id', '$fecha', '$hora', '$nitavu')";

	if ($conexion->query($sql) == TRUE)
			{
			//mensaje ("Operacion realizada con exito",'vigilancia.php');
			historia ($nitavu,"Dio entrada de Asistencia a ".nitavu_nombre($id));				
			//header("location:Desarrollo/vigilancia3.php?r=15");
			mensaje("Asistencia registrada correctamente",'vigilancia3.php?r=15');
			}
		else
			{
			$msg="Error inesperado ".$sql; //<-- Descripcion de error
			//creamos un historial de error extraordinario
				//header("location:../lib/error.php?er=".$msg);
				mensaje("Surgió un error inseperado, favor de intentarlo nuevamente!!  ",'vigilancia3.php?r=15');
			}
			
	
}
else {// NO TIENE PERMISOS Y LE AGREGAMOS

	mensaje("No tiene permiso para usar esta aplicacion",'');
}
	
	//header("location:../index.php");
?>