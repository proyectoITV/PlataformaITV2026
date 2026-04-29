<?php
include ("./lib/body_head.php");
?>

<?php
$no = $_POST['no'];
if (isset($no)) {

// $sap= $_POST['sap'];
// $secc = $_POST['secc'];
//  $direccion = $_POST['direccion'];
 $nombre = $_POST['nombre_'];
 $departamento = $_POST['dpto'];
//  $departamento2 = $_POST['dpto'];
 $puesto = $_POST['puesto'];
// $nivel = $_POST['nivel'];
// $correoelectronico = $_POST['correoelectronico'];
// $telefono = $_POST['telefono'];
// $telefono_movil = $_POST['telefono_movil'];
// $fecha_nacimiento = $_POST['fecha_nacimiento'];
 $quien = $_POST['quien'];
 $historia = "Se dio de alta por ".user_legend($quien)." el ".$fecha;

// $telefono2 = $_POST['telefono2'];
// $telefono_extension = $_POST['telefono_extension'];
// $profesion = $_POST['profesion'];
// $profesion_abr = $_POST['profesion_abr'];

$sql = "INSERT INTO empleados(nitavu, nombre, direccion, departamento, dpto, puesto, nip, historia) 
VALUES ('$no', '$nombre','$direccion', '$departamento','$departamento2', '$puesto','$no','$historia')";

//$sql = "INSERT INTO empleados(nitavu,secc, sap, nombre, direccion, departamento, puesto, nivel, correoelectronico, telefono, telefono_movil, fecha_nacimiento, historia, nip, telefono2, telefono_extension, profesion, profesion_abr) 
//VALUES ('$no', '$secc', '$sap', '$nombre','$direccion', '$departamento', '$puesto', '$nivel', '$correoelectronico','$telefono', '$telefono_movil', '$fecha_nacimiento', '$historia','$no', '$telefono2', '$telefono_extension', '$profesion', '$profesion_abr')";

if ($conexion->query($sql) == TRUE) 
		{
		$msg="";

		//$archivo = 'fotos/'.$no.'';
		//$msg= $msg.subir('foto_file', $archivo, 'jpg');
		
		//$archivo = 'firmas/'.$no.'';
		//$msg= $msg.subir('firma_file', $archivo, 'jpg');
		
		historia($quien,'Alta de empleado con No.  '.$no);

		
		$msg = $msg."Se ha hecho la ALTA con exito.";
		mensaje($msg,'../itavu/index.php?home=');
		//header('location:../index.php');	
		} 
	else 
		{
		$msg="Error inesperado ".$sql; //<-- Descripcion de error
		echo $sql;
		//creamos un historial de error extraordinario
		//header("location:../lib/error.php?er=".$msg);	
		} 
		
}
else {
	echo "algo anda mal";
}
?>