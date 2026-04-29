<?php
include ("./unica/body_head.php");
?>

<?php
$fecha_ = $_POST['fecha_'];
$hr_salida = $_POST['otro_hr_salida'];
$hr_salida = date("H:i:s" , strtotime($_POST['otro_hr_salida']));

$hr_regreso = date("H:i:s" , strtotime($_POST['otro_hr_regreso']));
//$hr_regreso = tiempo_sumar_hr($hr_salida,$_POST['tiempo']);


$asunto = $_POST['asunto'];
$justificacion = $_POST['justificacion'];
$dpto = nitavu_dpto($_POST['empleado']);
$archivo = archivo_pases($nitavu,$fecha_,$hr_salida);
$empleado = $_POST['empleado'];

$resumen="";
$msg="";
//echo $archivo;

if (isset($_POST['jefe'])){
			// si tiene permiso se el pase viene del jefe y aprobarlo.
$jefe = $_POST['jefe'];				
$sql = "INSERT INTO empleados_salidas_temporal
		(nitavu, hora_desde, hora_hasta, justificacion, solicito_fecha, solicito_hora,  asunto, fecha, dpto, autorizo_nitavu, autorizo_fecha, autorizo_hora)
		VALUES
		('$empleado', '$hr_salida', '$hr_regreso', '$justificacion', '$fecha_', '$hora','$asunto', '$fecha','$dpto','$jefe','$fecha','$hora');";
		$msg = $msg."Se autorizo. ";

}
else
{
$sql = "INSERT INTO empleados_salidas_temporal
		(nitavu, hora_desde, hora_hasta, justificacion, solicito_fecha, solicito_hora,  asunto, fecha, dpto)
		VALUES
		('$empleado', '$hr_salida', '$hr_regreso', '$justificacion', '$fecha_', '$hora','$asunto', '$fecha','$dpto');";
}


		//echo $sql;
		if ($conexion->query($sql) == TRUE)
		{
			$msg = $msg."Se realizo con exito para ".fecha_larga($fecha_)."";
			$msg= $msg.subir('auscencia_file', $archivo, 'jpg');
			mensaje ($msg."", '');
			//header('location:../index.php');	
		}
		else
		{
			//return FALSE;
			echo $sql;
		}


?>