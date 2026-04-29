<?php
//include ("./unica/body_head.php");
?>

<?php 	require("unica/seguridad.php"); ?>
<?php 	//require("unica/funciones.php"); ?>
<?php 	include_once("unica/funciones.php"); ?>
<?php 	//require("cano_funciones.php"); ?>
<?php 	//require("laura_funciones.php"); ?>
<?php 	//require("yes_funciones.php"); ?>
<?php 	require("unica/config.php"); ?>
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
			header("location:../vigilancia3.php?r=15");

			}
		else
			{
			$msg="Error inesperado ".$sql; //<-- Descripcion de error
			//creamos un historial de error extraordinario
				header("location:../unica/error.php?er=".$msg);
			}
			
	
}
else {// NO TIENE PERMISOS Y LE AGREGAMOS

	mensaje("No tiene permiso para usar esta aplicacion",'');
}
	
	//header("location:../index.php");
?>