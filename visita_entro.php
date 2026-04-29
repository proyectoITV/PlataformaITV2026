<?php
include ("./lib/body_head.php");
?>
<?php
$id = $_GET['id'];
$idapp = 'ap13';




$sql = "SELECT * FROM aplicaciones_permisos WHERE (nitavu='".$nitavu."' AND idapp='".$idapp."')";
$rc= $conexion -> query($sql);
//echo $sql;
if($f = $rc -> fetch_array()){ // SE ENCONTRARON PERMISOS Y SE ACTUALIZARON

	$sql="UPDATE visitas SET registro_hr_entrada='$hora', registro_fecha_entrada='".$fecha."' WHERE (id='$id')";
	if ($conexion->query($sql) == TRUE)
			{
			//mensaje ("Operacion realizada con exito",'vigilancia.php');
			header("location:../vigilancia.php");
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