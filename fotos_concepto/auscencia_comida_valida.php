<?php
include ("./unica/body_head.php");
?>

<?php
$fecha_ = $_POST['fecha_'];
//$hr_salida = $_POST['hr_salida'];
$hr_salida = date("H:i:s" , strtotime($_POST['hr_salida']));
//$hr_regreso = $_POST['hr_regreso'];
$hr_regreso = tiempo_sumar_hr($hr_salida,$_POST['tiempo']);



$asunto = $_POST['asunto'];
$justificacion = "";
$dpto = nitavu_dpto($_POST['empleado']);
//$archivo = archivo_pases($nitavu,$fecha_,$hr_salida);
$empleado = $_POST['empleado'];

$resumen="";
if (isset($_POST['dia1'])) {$dia1=$_POST['dia1'];} else {$dia1="";}
if (isset($_POST['dia2'])) {$dia2=$_POST['dia2'];} else {$dia2="";}
if (isset($_POST['dia3'])) {$dia3=$_POST['dia3'];} else {$dia3="";}
if (isset($_POST['dia4'])) {$dia4=$_POST['dia4'];} else {$dia4="";}
if (isset($_POST['dia5'])) {$dia5=$_POST['dia5'];} else {$dia5="";}

//echo $archivo;

if ($hr_salida<$hora) {
		mensaje ("VERIFICA!, la hora que estas indicando ".$hr_salida." es menor o casi igual que la hora actual (.".$hora.")",'auscencia2.php?pes=comida');
}
else {


// en el campo solicito_fecha, va la fecha de cuando se ejecutara el pase
// debiera ser fecha, pero ya hay datos asi que se queda este en $dia se almancena los dias extras

if ($dia1<>''){
$sql1="INSERT INTO empleados_salidas_temporal
		(nitavu, hora_desde, hora_hasta, justificacion, solicito_fecha, solicito_hora,  asunto, fecha, dpto)
		VALUES
		('$empleado', '$hr_salida', '$hr_regreso', '$justificacion', '$dia1', '$hora','$asunto', '$fecha_','$dpto');";
	//echo $sql1;
	if ($conexion->query($sql1) == TRUE)
		{$resumen = $resumen.fecha_larga($dia1).", ";}
}


if ($dia2<>''){
$sql2="INSERT INTO empleados_salidas_temporal
		(nitavu, hora_desde, hora_hasta, justificacion, solicito_fecha, solicito_hora,  asunto, fecha, dpto)
		VALUES
		('$empleado', '$hr_salida', '$hr_regreso', '$justificacion', '$dia2', '$hora','$asunto', '$fecha_','$dpto');";
	//echo $sql2;
	if ($conexion->query($sql2) == TRUE)
		{$resumen = $resumen.fecha_larga($dia2).", ";}
}


if ($dia3<>''){
$sql3="INSERT INTO empleados_salidas_temporal
		(nitavu, hora_desde, hora_hasta, justificacion, solicito_fecha, solicito_hora,  asunto, fecha, dpto)
		VALUES
		('$empleado', '$hr_salida', '$hr_regreso', '$justificacion', '$dia3', '$hora','$asunto', '$fecha_','$dpto');";
	//echo $sql3;
	if ($conexion->query($sql3) == TRUE)
		{$resumen = $resumen.fecha_larga($dia3).", ";}
}


if ($dia4<>''){
$sql4="INSERT INTO empleados_salidas_temporal
		(nitavu, hora_desde, hora_hasta, justificacion, solicito_fecha, solicito_hora,  asunto, fecha, dpto)
		VALUES
		('$empleado', '$hr_salida', '$hr_regreso', '$justificacion', '$dia4', '$hora','$asunto', '$fecha_','$dpto');";
	//echo $sql4;
	if ($conexion->query($sql4) == TRUE)
		{$resumen = $resumen.fecha_larga($dia4).", ";}
}

if ($dia5<>''){
$sql5="INSERT INTO empleados_salidas_temporal
		(nitavu, hora_desde, hora_hasta, justificacion, solicito_fecha, solicito_hora,  asunto, fecha, dpto)
		VALUES
		('$empleado', '$hr_salida', '$hr_regreso', '$justificacion', '$dia5', '$hora','$asunto', '$fecha_','$dpto');";
	//echo $sql5;
	if ($conexion->query($sql5) == TRUE)
		{$resumen = $resumen.fecha_larga($dia5).", ";}
}


if (isset($_POST['jefe'])){
			// si tiene permiso se el pase viene del jefe y aprobarlo.
$jefe = $_POST['jefe'];				
$sql = "INSERT INTO empleados_salidas_temporal
		(nitavu, hora_desde, hora_hasta, justificacion, solicito_fecha, solicito_hora,  asunto, fecha, dpto, autorizo_nitavu, autorizo_fecha, autorizo_hora)
		VALUES
		('$empleado', '$hr_salida', '$hr_regreso', '$justificacion', '$fecha', '$hora','$asunto', '$fecha_','$dpto','$jefe','$fecha','$hora');";
		$msg = $msg = "Se autorizo. ";

}
else
{
$sql = "INSERT INTO empleados_salidas_temporal
		(nitavu, hora_desde, hora_hasta, justificacion, solicito_fecha, solicito_hora,  asunto, fecha, dpto)
		VALUES
		('$empleado', '$hr_salida', '$hr_regreso', '$justificacion', '$fecha', '$hora','$asunto', '$fecha_','$dpto');";
}

		//echo $sql;
		if ($conexion->query($sql) == TRUE)
		{
			//return TRUE;
		//echo $archivo;
		if ($resumen<>''){
				$msg ="Se realizo con exito para ".fecha_larga($fecha_)." y ".$resumen.".";
		} else {$msg ="Se realizo con exito ".fecha_larga($fecha_).".";}
		//$msg= $msg.subir('auscencia_file', $archivo, 'jpg');
		

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