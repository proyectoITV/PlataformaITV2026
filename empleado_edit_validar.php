<?php
include ("./lib/body_head.php");
?>

<?php
$no = $_POST['no'];
if (isset($no)) {

$sap= $_POST['sap'];
$secc = $_POST['secc'];
$direccion = $_POST['direccion'];
$nombre = $_POST['nombre'];
$departamento = $_POST['departamento'];
//$puesto = $_POST['puesto'];
$nivel = $_POST['nivel'];
$correoelectronico = $_POST['correoelectronico'];
$telefono = $_POST['telefono'];
$telefono_movil = $_POST['telefono_movil'];
$fecha_nacimiento = $_POST['fecha_nacimiento'];
$quien = $_POST['quien'];

$telefono2 = $_POST['telefono2'];
$telefono_extension = $_POST['telefono_extension'];
$profesion = $_POST['profesion'];
$profesion_abr = $_POST['profesion_abr'];

$historia = user_historia($no).", Actualizacion por ".user_legend($quien)." el ".$fecha;



$sql ="UPDATE empleados SET secc='$secc', sap='$sap', nombre='$nombre', nivel='$nivel', correoelectronico='$correoelectronico', telefono='$telefono', telefono_movil='$telefono_movil', fecha_nacimiento='$fecha_nacimiento',historia='$historia', telefono2='$telefono2', telefono_extension='$telefono_extension', profesion='$profesion', profesion_abr='$profesion_abr', direccion='$direccion', departamento='$departamento' WHERE nitavu='$no'";


if ($conexion->query($sql) == TRUE) 
		{
		$msg="";

		$archivo = 'fotos/'.$no.'';
		$msg= $msg.subir('foto_file', $archivo, 'jpg');
		
		$archivo = 'firmas/'.$no.'';
		$msg= $msg.subir('firma_file', $archivo, 'jpg');
		
		historia($quien,'Acutalizo datos de '.$no);
		
		$msg = $msg."Se ha Actualizado con exito con exito.";
		mensaje($msg,'');
		//header('location:../index.php');	

		} 
	else 
		{
		$msg="Error inesperado ".$sql; //<-- Descripcion de error
		//echo $sql;
		//creamos un historial de error extraordinario
		header("location:../lib/error.php?er=".$msg);	
		} 
		
}
else {
	echo "algo anda mal";
}
?>