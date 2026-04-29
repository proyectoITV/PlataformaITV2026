<?php
include ("./lib/body_head.php");
?>

<?php
$no = $_POST['no'];
if (isset($no)) {

 //$sap= $_POST['sap'];
// $secc = $_POST['secc'];
// $direccion = $_POST['direccion'];
 $nombre = $_POST['nombre'];
// $departamento = $_POST['departamento'];
// //$puesto = $_POST['puesto'];
// $nivel = $_POST['nivel'];
 $correoelectronico = $_POST['correoelectronico'];
 //$telefono = $_POST['telefono'];
 $telefono_movil = $_POST['telefono_movil'];
 $fecha_nacimiento = $_POST['fecha_nacimiento'];

 $quien = $_POST['quien']; // se requiere ya no esta disponible $nitavu

 $telefono2 = $_POST['telefono2'];
//$telefono_extension = $_POST['telefono_extension'];
//$profesion = $_POST['profesion'];
//$profesion_abr = $_POST['profesion_abr'];


$domicilio_calle = $_POST['domicilio_calle'];
$domicilio_num_int = $_POST['domicilio_num_int'];
$domicilio_num_ext = $_POST['domicilio_num_ext'];
$domicilio_entrecalles = $_POST['domicilio_entrecalles'];
$domicilio_colonia = $_POST['domicilio_colonia'];
$domicilio_cp = $_POST['domicilio_cp'];
$domicilio_ciudad = $_POST['domicilio_ciudad'];
$estadocivil = $_POST['estadocivil'];


$historia = user_historia($no).", Actualizo datos generales por ".user_legend($quien)." el ".$fecha;



//$sql ="UPDATE empleados SET secc='$secc', sap='$sap', nombre='$nombre', nivel='$nivel', correoelectronico='$correoelectronico', telefono='$telefono', telefono_movil='$telefono_movil', fecha_nacimiento='$fecha_nacimiento',historia='$historia', telefono2='$telefono2', telefono_extension='$telefono_extension', profesion='$profesion', profesion_abr='$profesion_abr', direccion='$direccion', departamento='$departamento' WHERE nitavu='$no'";


$sql ="UPDATE empleados SET nombre='$nombre', correoelectronico='$correoelectronico', telefono_movil='$telefono_movil', fecha_nacimiento='$fecha_nacimiento',historia='$historia', telefono2='$telefono2', domicilio_calle='$domicilio_calle', domicilio_num_int='$domicilio_num_int', domicilio_num_ext = '$domicilio_num_ext', domicilio_entrecalles = '$domicilio_entrecalles', domicilio_colonia='$domicilio_colonia', domicilio_cp='$domicilio_cp', estadocivil='$estadocivil', domicilio_ciudad='$domicilio_ciudad' WHERE nitavu='$no'";

if ($conexion->query($sql) == TRUE) 
		{
		$msg="";

		$archivo = 'fotos/'.$no.'';
		$msg= $msg.subir('foto_file', $archivo, 'jpg');
		
		//$archivo = 'firmas/'.$no.'';
		//$msg= $msg.subir('firma_file', $archivo, 'jpg');
		
		historia($quien,'Actualizo datos de '.$no);
		
		$msg = $msg."Se ha Actualizado con exito con exito.";
		mensaje($msg,'empleados.php?search=');
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