<?php
//include ("./lib/body_head.php");
?>



<?php 	require("seguridad.php"); ?>
<?php 	require("lib/funciones.php"); ?>
<?php 	//require("cano_funciones.php"); ?>
<?php 	//require("laura_funciones.php"); ?>
<?php 	//require("yes_funciones.php"); ?>
<?php 	require("config.php"); ?>
<?php // error_reporting(E_ALL ^ E_NOTICE);
?>

<?php
$id = $_GET['id'];
$idapp = 'ap13';




$sql = "SELECT * FROM aplicaciones_permisos WHERE (nitavu='".$nitavu."' AND idapp='".$idapp."')";
$rc= $conexion -> query($sql);
//echo $sql;
if($f = $rc -> fetch_array()){ // SE ENCONTRARON PERMISOS Y SE ACTUALIZARON

	$sql="UPDATE empleados_salidas_temporal SET registro_salida='$hora' WHERE (id='$id')";
	if ($conexion->query($sql) == TRUE)
			{
			//mensaje ("Operacion realizada con exito",'vigilancia.php');
			historia($nitavu, "Dio Salida en Caseta a ".pase_id_nombre($id));	
			docdigital_no(FALSE, 2);//aumenta 2 al contador de papel	
			header("location:../vigilancia.php?r=300");
			}
		else
			{
			$msg="Error inesperado ".$sql; //<-- Descripcion de error
			//creamos un historial de error extraordinario
				header("location:../lib/error.php?er=".$msg);
			}
			
	
}
else {// NO TIENE PERMISOS Y LE AGREGAMOS

	mensaje("No tiene permiso para usar esta aplicacion",'');
}
	
	//header("location:../index.php");
?>