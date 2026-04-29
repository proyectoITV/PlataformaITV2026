<?php
header("Refresh: 600; URL='mantenimiento.php?unlimited=1'");
?>
<?php
//include ("./unica/seguridad.php"); 
include ("./unica/body_head.php");
include ("./unica/body_menu.php");

// contenido:
?>
<?php

//$unlimited=1;
//$r=10;



//Correos no enviados
echo "<h1>Realizando tareas de mantenimiento</h1>";

echo "<div id='mantenimiento_correos'>";
$c=0; $x=0;
$tmp="";
$sql = "select * from correos where estado=0 and fecha=curdate()"; //0 no enviado, 2 re-enviado
$r2 = $conexion -> query($sql); while($f = $r2 -> fetch_array())
{
	//1.- paso uno cambiar el estado a 2, para que ya no entre en el proximo ciclo
	$sql = "UPDATE correos SET estado=2 WHERE id=".$f['id']."";
	//echo $sql;
	$r = $conexion -> query($sql); 
	if ($conexion->query($sql) == TRUE){

	}

	//2.- Reenviar el correo, si falla o no se vuelve a agregar a la cola con estado 1 ó 0
	//notificacion_add ($f['nuc'], "RE-".$f['asunto'], $fecha, $itavu_manda, $contenido);
	$enviado = correo(nitavu_correo($f['nuc']), nitavu_nombre($f['nuc']), $f['responder_a'], $f['responder_a_name'], "RE-".$f['asunto'], $f['contenido'], $f['nuc']);
	if($enviado == TRUE){
		$tmp = "Se realizo re-envio del correo para ".$f['correo'].", ".$f['correo_name']." de ".$f['responder_a_name']." desde ".$f['responder_a']." con el asunto ".$f['asunto']." del dia ".$f['fecha']." que no se habia podido enviar";
		historia($nitavu, $tmp);
		notificacion_add ($f['nuc'], 'chat', $fecha, $nitavu, $tmp);
		$c=$c+1;

	} else {
		$tmp = "Se intento realizar un reenvio del correo para ".$f['correo'].", ".$f['correo_name']." de ".$f['responder_a_name']." desde ".$f['responder_a']." con el asunto ".$f['asunto']." del dia ".$f['fecha']." que no se habia podido enviar. <B>SERIA CONVENIENTE QUE CHEQUES TU CUENTA DE CORREO, O LA ACTIVES PARA QUE TE PUEDAN LLEGAR LOS CORREOS DESDE LA PLATAFORMA</B>";
		notificacion_add ($f['nuc'], 'chat', $fecha, $nitavu, $tmp);
		$x=$x+1;
	}
}
echo "Se realizaron ".$c." reenvios de correos y fallaron ".$x;
historia($nitavu, "Tarea de mantenimiento de reenvio de correos pendientes: ".$c.", y fallos:".$x);
notificacion_add($nitavu, 'chat', $fecha, $nitavu, "Tarea de mantenimiento de reenvio de correos pendientes: (".fecha_larga($fecha)." - ".hora12($hora)."".$c." y fallos:".$x);


echo "</div>";

//REVISAR FECHA DE CADUCIDAD DEL OFICIO
echo "<div id='mantenimiento_oficiosCaducados'>";
$c=0;
$tmp='';
//Obtiene los numeros de oficio que no se han utlizado y tienen mas de 5 dias de haberse solicitado.
$sql = " SELECT *, DATEDIFF( NOW(),fechacrea)  from cp_controlcorrespondencia  WHERE DATEDIFF( NOW(),fechacrea)>5 and utilizado=0 and numero<>0";
 $r2 = $conexion -> query($sql); 
while($f = $r2 -> fetch_array())
{
	// //1.- Actualizamos el estatus a 2, para identificar que ese Número de oficio ha caducado, por pasar el limite de dias permitido.
	 $sql = "UPDATE cp_controlcorrespondencia SET utilizado=2 WHERE id='".$f['id']."'";
     echo $sql;
     echo "<br>";
	//$r = $conexion -> query($sql); 
	 if ($conexion->query($sql) == TRUE) 
	 {
		 //2.- Se notifica a quien solicito el numero, que dicho número ha expirado.
		$tmp = "EL número de oficio <b>". $f['numdocumento']."</b>, ha expirado (han trascurrido 5 dias sin utilizarse), y ya no se será posible ser utilizado. En caso de ser necesario, favor de generar un número nuevo.";
		notificacion_add ($f['nitavuCrea'], 'chat', $fecha, $nitavu, $tmp);
	 	$c=$c+1;


	 }

	
	
} 	


//ENVIAR NOTIFICACION DE DIAS FALTANTES A UN OFICIO
echo $hora;

if(($hora >= '08:00:00') AND ($hora <= '09:00:00')){
	//echo "TRUE";

	$query = "select *, DATEDIFF(fecha_termino,NOW()) as diasFaltan from cp_nuevosdocumentos where fecha_termino <> '0000-00-00' and fecha_termino > CURRENT_DATE() and estado = 0";
	
	$r2 = $conexion -> query($query); 
	while($f = $r2 -> fetch_array())
	{
		
		echo '<br>'.$f['oficioNumero'].'<br>';
		if($f['diasFaltan']==1){
			$asunto="Falta ".$f['diasFaltan']." día para el termino del oficio ".$f['oficioNumero']."";
			$tmp = "Al número de oficio <b>". $f['oficioNumero']." con asunto de: <b>".$f['asunto']." ".$f['descripcion']."</b></b>, le falta ".$f['diasFaltan']." día para su termino.";
			
			if(buscarSiYaSeEnvioElCorreoDiario($asunto)=='FALSE'){
				$colaboradores = participantesDelCaso($f['id']);
					for($i=0; $i < sizeof($colaboradores); $i++){
						if($colaboradores[$i]!=null || $colaboradores[$i]!= ""){
							notificacion_add($colaboradores[$i], $asunto, $fecha,$f['nitavuCaptura'], $tmp);
						}
					}
				//notificacion_add($f['nitavuCaptura'], $asunto, $fecha, $f['nitavuCaptura'], $tmp);
				//notificarParticipantes ($f['id'],$f['nitavuCaptura'],$tmp,$asunto);
			}else{
				echo "ya se envio el dia de hoy";
			}

			
		}else{
			$asunto="Faltan ".$f['diasFaltan']." días para el termino del oficio ".$f['oficioNumero']."";
			$tmp = "Al número de oficio <b>". $f['oficioNumero']." con asunto de: <b>".$f['asunto']." ".$f['descripcion']."</b></b>, le faltan ".$f['diasFaltan']." días para su termino.";
			
			if(buscarSiYaSeEnvioElCorreoDiario($asunto)=='FALSE'){
				$colaboradores = participantesDelCaso($f['id']);
					for($i=0; $i < sizeof($colaboradores); $i++){
						if($colaboradores[$i]!=null || $colaboradores[$i]!= ""){
							notificacion_add($colaboradores[$i], $asunto, $fecha,$f['nitavuCaptura'], $tmp);
						}
					}
				//notificacion_add($f['nitavuCaptura'], $asunto, $fecha, $f['nitavuCaptura'], $tmp);
				//notificarParticipantes ($f['id'],$f['nitavuCaptura'],$tmp,$asunto);
				
			}else{
				echo "ya se envio el dia de hoy";
			}

		}	
	} 	
	
}else{

	if(($hora >= '12:00:00') AND ($hora <= '13:00:00')){
	
		$query = "select *, DATEDIFF(fecha_termino,NOW()) as diasFaltan from cp_nuevosdocumentos where fecha_termino <> '0000-00-00' and fecha_termino > CURRENT_DATE() and estado = 0";
	
		$r2 = $conexion -> query($query); 
		while($f = $r2 -> fetch_array())
		{
			echo '<br>'.$f['oficioNumero'].'<br>';
			if($f['diasFaltan']==1){
				
				$asunto="Falta ".$f['diasFaltan']." día para el termino del oficio ".$f['oficioNumero']."";
				$tmp = "Al número de oficio <b>". $f['oficioNumero']." con asunto de: <b>".$f['asunto']." ".$f['descripcion']."</b></b>, le falta ".$f['diasFaltan']." día para su termino.";
				
				if(buscarSiYaSeEnvioElCorreoDiario2($asunto)=='no'){
					$colaboradores = participantesDelCaso($f['id']);
					for($i=0; $i < sizeof($colaboradores); $i++){
						if($colaboradores[$i]!=null || $colaboradores[$i]!= ""){
							notificacion_add($colaboradores[$i], $asunto, $fecha,$f['nitavuCaptura'], $tmp);
						}
					}
					//notificacion_add($f['nitavuCaptura'], $asunto, $fecha, $f['nitavuCaptura'],$tmp);
					//notificarParticipantes ($f['id'],$f['nitavuCaptura'],$tmp,$asunto);
				}else{
					echo "Ya se envio por segunda vez. Por que le falta un dia al oficio.";
				}


				

				
			}
		} 
	}
}





		 //3.- Se notifica a quien solicito el numero, que dicho número ha expirado.
//historia($nitavu, "Tarea de mantenimiento se han marcado ".$c.", número de oficio(s) como caducado(s) debido a que han pasado mas de 5 dias desde su creación y no se han utilizado.");
//notificacion_add($nitavu, 'chat', $fecha, $nitavu, "Tarea de mantenimiento se han marcado ".$c.", número de oficio(s) como caducado(s) debido a que han pasado mas de 5 dias desde su creación y no se han utilizado.");



echo "</div>";

?>


<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>


<?php
include ("./unica/body_footer.php");
?>
