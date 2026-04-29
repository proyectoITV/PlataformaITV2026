<?php
include ("./unica/body_head.php");
?>

<?php
$fecha_ = $_POST['fecha_'];
$hr_salida = $_POST['hr_salida'];
$hr_regreso = $_POST['hr_regreso'];
$asunto = $_POST['asunto'];
$justificacion = $_POST['justificacion'];
$dpto = nitavu_dpto($_POST['empleado']);
$archivo = archivo_pases($nitavu,$fecha_,$hr_salida);
$empleado = $_POST['empleado'];

$resumen="";
if (isset($_POST['dia1'])) {$dia1=$_POST['dia1'];} else {$dia1="";}
if (isset($_POST['dia2'])) {$dia2=$_POST['dia2'];} else {$dia2="";}
if (isset($_POST['dia3'])) {$dia3=$_POST['dia3'];} else {$dia3="";}
if (isset($_POST['dia4'])) {$dia4=$_POST['dia4'];} else {$dia4="";}
if (isset($_POST['dia5'])) {$dia5=$_POST['dia5'];} else {$dia5="";}

//echo $archivo;

if ($hr_regreso<$hr_salida) {
		mensaje ("VERIFICA!, la hora de regreso que estas indicando ".$hr_regreso." es menor que la de salida.".$hr_salida,'auscencia.php');
}
else {


if ($dia1<>''){
$sql1="INSERT INTO empleados_salidas_temporal
		(nitavu, hora_desde, hora_hasta, justificacion, solicito_fecha, solicito_hora,  asunto, fecha, dpto)
		VALUES
		('$empleado', '$hr_salida', '$hr_regreso', '$justificacion', '$dia1', '$hora','$asunto', '$fecha_','$dpto');";
	if ($conexion->query($sql1) == TRUE)
		{$resumen = $resumen.$dia1.", ";}
}


if ($dia2<>''){
$sql2="INSERT INTO empleados_salidas_temporal
		(nitavu, hora_desde, hora_hasta, justificacion, solicito_fecha, solicito_hora,  asunto, fecha, dpto)
		VALUES
		('$empleado', '$hr_salida', '$hr_regreso', '$justificacion', '$dia2', '$hora','$asunto', '$fecha_','$dpto');";
	if ($conexion->query($sql2) == TRUE)
		{$resumen = $resumen.$dia2.", ";}
}


if ($dia3<>''){
$sql3="INSERT INTO empleados_salidas_temporal
		(nitavu, hora_desde, hora_hasta, justificacion, solicito_fecha, solicito_hora,  asunto, fecha, dpto)
		VALUES
		('$empleado', '$hr_salida', '$hr_regreso', '$justificacion', '$dia3', '$hora','$asunto', '$fecha_','$dpto');";
	if ($conexion->query($sql3) == TRUE)
		{$resumen = $resumen.$dia3.", ";}
}


if ($dia4<>''){
$sql4="INSERT INTO empleados_salidas_temporal
		(nitavu, hora_desde, hora_hasta, justificacion, solicito_fecha, solicito_hora,  asunto, fecha, dpto)
		VALUES
		('$empleado', '$hr_salida', '$hr_regreso', '$justificacion', '$dia4', '$hora','$asunto', '$fecha_','$dpto');";
	if ($conexion->query($sql4) == TRUE)
		{$resumen = $resumen.$dia4.", ";}
}

if ($dia5<>''){
$sql5="INSERT INTO empleados_salidas_temporal
		(nitavu, hora_desde, hora_hasta, justificacion, solicito_fecha, solicito_hora,  asunto, fecha, dpto)
		VALUES
		('$empleado', '$hr_salida', '$hr_regreso', '$justificacion', '$dia5', '$hora','$asunto', '$fecha_','$dpto');";
	if ($conexion->query($sql5) == TRUE)
		{$resumen = $resumen.$dia5.", ";}
}



$sql = "INSERT INTO empleados_salidas_temporal
		(nitavu, hora_desde, hora_hasta, justificacion, solicito_fecha, solicito_hora,  asunto, fecha, dpto)
		VALUES
		('$empleado', '$hr_salida', '$hr_regreso', '$justificacion', '$fecha', '$hora','$asunto', '$fecha_','$dpto');";

		if ($conexion->query($sql) == TRUE)
		{
			//return TRUE;
		//echo $archivo;
		if ($resumen<>''){
				$msg ="Se realizo con exito para ".$fecha_." y ".$resumen.".";
		} else {$msg ="Se realizo con exito ".$fecha_.".";}
		$msg= $msg.subir('auscencia_file', $archivo, 'jpg');
		

			mensaje ($msg, '');
			//header('location:../index.php');	
		}
		else
		{
			//return FALSE;
			echo $sql;
		}
}

?>