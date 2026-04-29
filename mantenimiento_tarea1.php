<?php


    require("config.php");
    require_once("lib/funciones.php");
    require_once("lib/flor_funciones.php");
//ENVIAR NOTIFICACION DE DIAS FALTANTES A UN OFICIO
$msg="";
echo "<b>".$hora.":</b> ";
if(($hora >= '08:00:00') AND ($hora <= '09:00:00')){
	echo "TRUE";

	$query = "select *, DATEDIFF(fecha_termino,NOW()) as diasFaltan from cp_nuevosdocumentos where fecha_termino <> '0000-00-00' and fecha_termino > CURRENT_DATE() and estado = 0";
	// echo $query;
	$r2 = $conexion -> query($query); 
	while($f = $r2 -> fetch_array())
	{
		$msg = '<br>'.$f['oficioNumero'].'<br>';
		echo '<br>'.$f['oficioNumero'].'<br>';
		if($f['diasFaltan']==1 || $f['diasFaltan']==2 || $f['diasFaltan']==3 ){
			$asunto="Falta ".$f['diasFaltan']." dias naturales para el termino del oficio ".$f['oficioNumero']."";
			$tmp = "Al número de oficio <b>". $f['oficioNumero']." con asunto de: <b>".$f['asunto']." ".$f['descripcion']."</b></b>, le falta ".$f['diasFaltan']." día para su termino.";
			
			if(buscarSiYaSeEnvioElCorreoDiario($asunto)=='FALSE'){
				$colaboradores = participantesDelCaso($f['id']);
					for($i=0; $i < sizeof($colaboradores); $i++){
                        echo 'Colaborador: '.$colaboradores[$i].'<br>';
						if($colaboradores[$i]!=null || $colaboradores[$i]!= ""){
							notificacion_add($colaboradores[$i], $asunto, $fecha,$f['nitavuCaptura'], $tmp);
						}
					}
				//notificacion_add($f['nitavuCaptura'], $asunto, $fecha, $f['nitavuCaptura'], $tmp);
				//notificarParticipantes ($f['id'],$f['nitavuCaptura'],$tmp,$asunto);
			}else{
                echo "ya se envio el dia de hoy";
                $msg = $msg. "ya se envio el dia de hoy";
			}

			
		}else{
            $msg = $msg."Faltan ".$f['diasFaltan']." dias naturales para el termino del oficio ".$f['oficioNumero']."";
			$asunto="Faltan ".$f['diasFaltan']." dias naturales para el termino del oficio ".$f['oficioNumero']."";
			$tmp = "Al número de oficio <b>". $f['oficioNumero']." con asunto de: <b>".$f['asunto']." ".$f['descripcion']."</b></b>, le faltan ".$f['diasFaltan']." días para su termino.";
			$msg = $msg."<br>".$tmp;
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
                echo "<b style='color:yellow;'>ya se envio el dia de hoy</b>";
                $msg = $msg."ya se envio el dia de hoy";
			}

		}	
	} 	
	
}else{
    
	if(($hora >= '12:00:00') AND ($hora <= '14:00:00')){
        
	
		$query = "select *, DATEDIFF(fecha_termino,NOW()) as diasFaltan from cp_nuevosdocumentos where fecha_termino <> '0000-00-00' and fecha_termino > CURRENT_DATE() and estado = 0";
	
		$r2 = $conexion -> query($query); 
		while($f = $r2 -> fetch_array())
		{
            $msg = $msg.$f['oficioNumero'].'<br>';
			echo '<br>'.$f['oficioNumero'].'<br>';
			if($f['diasFaltan']==1 || $f['diasFaltan']==2 || $f['diasFaltan']==3){
				
				$asunto="Falta ".$f['diasFaltan']." dias naturales para el termino del oficio ".$f['oficioNumero']."";
				$tmp = "Al número de oficio <b>". $f['oficioNumero']." con asunto de: <b>".$f['asunto']." ".$f['descripcion']."</b></b>, le falta ".$f['diasFaltan']." día para su termino.";
                $msg = $msg."<br>".$asunto."<br>".$tmp;
                
				if(buscarSiYaSeEnvioElCorreoDiario2($asunto)=='no'){
                    
					$colaboradores = participantesDelCaso($f['id']);
					for($i=0; $i < sizeof($colaboradores); $i++){
						if($colaboradores[$i]!=null || $colaboradores[$i]!= ""){
                            notificacion_add($colaboradores[$i], $asunto, $fecha,$f['nitavuCaptura'], $tmp);
                            echo "-Se notifico";
						}
					}
					//notificacion_add($f['nitavuCaptura'], $asunto, $fecha, $f['nitavuCaptura'],$tmp);
					//notificarParticipantes ($f['id'],$f['nitavuCaptura'],$tmp,$asunto);
				}else{
                    echo "<b style='color:yellow;'>Ya se envio por segunda vez. Por que le falta un dia al oficio.</b>";
                    $msg = $msg."Ya se envio por segunda vez. Por que le falta un dia al oficio.";
				}


				

				
			} else {
                

                
            }
            echo "[".$f['diasFaltan']." dias].<hr>";
		} 
	} else {
        echo "Sin Envios pendientes";
        $msg = $msg."Sin envios pendientes";
    }
}
// historia("0",$msg);



// TicketEnviarNotificaciones();

echo "<img src='icon/ok.png' style='width:18px;'>";

?>