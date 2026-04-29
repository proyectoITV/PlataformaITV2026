<?php
require("config.php");
require("lib/funciones.php");
sleep(4);

//variables que ocupo
$Horadepase = ""; $fecha_ = $fecha; 
$npase = npase(FALSE);  $usuario=""; 
if (isset($_POST['Horadepase'])){    
    $Horadepase = date("H:i:s" , strtotime($_POST['Horadepase']));
}

$asunto = 'personal';
if (isset($_POST['asunto'])){
    $asunto = $_POST['asunto'];
}

if (isset($_POST['usuario'])){
    $usuario = $_POST['usuario'];
}
$justificacion = "Pase de COMIDA";
$dpto=nitavu_dpto($usuario);
$sql = "INSERT INTO empleados_salidas_temporal
		(id, nitavu, hora_desde, justificacion,  asunto, fecha, dpto)
		VALUES
		('$npase','$usuario', '$Horadepase',  '$justificacion', 'COMIDA', '$fecha','$dpto');";
$h="";
$msg="";
if ($conexion->query($sql) == TRUE)
	{
			$msg =$msg. "Pase Guardado con exito; Espere autorizacion.";
			//subir($npase, 'jpg');
			// mensaje ("Pase solicitado con exito, espere la notificación de aprobación.", 'index.php');
			//header('location:../index.php');	
			$m='<p>'.nitavu_nombre($usuario).' solicita usar el pase para comida para las '.$hora.' de '.fecha_larga($fecha).'</p><br><br><br> 

			<P style=color:gray>Para aprobar entre a la plataforma, en la seccion: APROBAR SALIDAS.</P>
			
			<a  style=background-color:#66FFFF;color:#006699;width:100%;padding:10px;border-style:solid;border-color:#006699;font-size:14pt;border-radius:5px;   href=http://plataformaitavu.tamaulipas.gob.mx/auscencia_temporal_autoriza3.php target=_blank>Ir a APROBAR SALIDAS</a>
			
			';
			
			//notificacion_add (titular(nitavu_dpto($usuario)), "Pase de salida ", date('Y-m-d'), $usuario,"solicito pase para salida a comer a las  ".$hora);	
			// notificacion_add (titular(nitavu_dpto($usuario)), 'Pase de Comida del '.$fecha, $fecha, $usuario, $m);

			$h="".nitavu_nombre($usuario)." (".$usuario.") ha solicitado un pase de salida para <span class='tenue'>".$justificacion."</span>";
			$h = $h."para el dia ".$fecha_.".";
            historia($usuario, $h);
            echo "Pase Listo";
	}
else
	{
			
			historia($usuario, "ERROR | (".$sql.") al intentar guardar pase de salida");
            // mensaje ("Error :".$sql,'');
            echo "Error al solicitar el pase: ".$sql;
	}


