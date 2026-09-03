<?php
include ("./lib/body_head.php");
?>

<?php
$no = $_POST['no'];
if (isset($no)) {

// $sap= $_POST['sap'];
// $secc = $_POST['secc'];
 $direccion = isset($_POST['direccion']) ? $_POST['direccion'] : '';
 $nombre = $_POST['nombre_'];
 $departamento = $_POST['dpto'];
 $departamento2 = $departamento;
 $puesto = $_POST['puesto'];
// $nivel = $_POST['nivel'];
// $correoelectronico = $_POST['correoelectronico'];
// $telefono = $_POST['telefono'];
// $telefono_movil = $_POST['telefono_movil'];
// $fecha_nacimiento = $_POST['fecha_nacimiento'];
 $quien = $_POST['quien'];
 $historia = "Se dio de alta por ".user_legend($quien)." el ".$fecha;
 $hash = password_hash($no, PASSWORD_DEFAULT);
 $fecha_hoy = date('Y-m-d');

// $telefono2 = $_POST['telefono2'];
// $telefono_extension = $_POST['telefono_extension'];
// $profesion = $_POST['profesion'];
// $profesion_abr = $_POST['profesion_abr'];

$sql = "INSERT INTO empleados(
nitavu, nombre, direccion, departamento, dpto, puesto, nip, hash,
correoelectronico, telefono, telefono_movil, historia, prefijo, telefono_extension,
telefono2, profesion_abr, profesion, control_asistencia, domicilio_calle,
domicilio_entrecalles, estado, sexo, comida, horario_entrada, horario_salida,
correo_vobo, correo_vobo_token, recibirCorreos, curp, numNoti, sueldo,
compensacion, iniciolaboral, deducciones, impuestosretenidos, rfc, adscripcion, orden
) VALUES (
'$no', '$nombre', '$direccion', '$departamento', '$departamento2', '$puesto', '$no', '$hash',
'', '', '', '$historia', '', '',
'', '', '', '', '',
'', '', '', '00:00:00', '00:00:00', '00:00:00',
'0', '', '0', '', '0', '0',
'0', '$fecha_hoy', '0', '0', '', '', '0'
)";

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
		mensaje($msg,'./empleado_nuevo.php');
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