<?php
include ("./lib/body_head.php");
?>
<?php
$visita_nombre = $_POST['visita_nombre'];
$visita_asunto = $_POST['visita_asunto'];
$visita_persona = $_POST['personal'];
$visita_fecha = $_POST['visita_fecha'];
$visita_hora = $_POST['visita_hr'];
$dpto= nitavu_dpto($visita_persona);

$sql = "INSERT INTO  visitas (nombre, asunto, fecha, hora, nitavu_quienvisita, solicita_nitavu, solicita_hr, solicita_fecha, dpto)
VALUES ('$visita_nombre', '$visita_asunto', '$visita_fecha', '$visita_hora', '$visita_persona', '$nitavu', '$hora', '$fecha','$dpto')";
//echo $sql;
if ($conexion->query($sql) == TRUE)
		{
			mensaje("Se ha registrado correctamente, espere la autorizacion",'');
		}
	else
		{
		$msg="Error inesperado ".$sql; //<-- Descripcion de error
		//creamos un historial de error extraordinario
			header("location:../lib/error.php?er=".$msg);
		}
		

	
	//header("location:../index.php");
?>