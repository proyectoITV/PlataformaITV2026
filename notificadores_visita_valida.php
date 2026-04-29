<?php
include("validas_config.php");

//validamos las variables post
$msgERROR = "";
$prueba=" ";

if (isset($_POST['lat'])){//si viene del formulario
		if ($_POST['lat']==''){
		mensaje("No se ha podido localizar: Active el geolocalizador o comuniquese a soporte",'notificadores_visita.php');
		}

		//paso de variables
		$notificador_nitavu=$_POST['notificador_nitavu'];
		$lat = $_POST['lat'];
		$lon = $_POST['lon'];
		$acu = $_POST['acu'];
		$contrato = $_POST['contrato'];
		$manzana = $_POST['manzana'];
		$fecha_corte = $_POST['fecha_corte'];
		$fecha_corte2 = $_POST['fecha_corte2'];
		$colonia = $_POST['colonia'];
		$curp = $_POST['curp'];
		$ife = $_POST['ife'];
		$nombre_ = $_POST['nombre_'];
		$paterno = $_POST['paterno'];
		$materno = $_POST['materno'];
		$nacimiento = $_POST['nacimiento'];
		$domicilio = $_POST['domicilio'];
		$sexo = $_POST['sexo'];
		$telefono_casa = $_POST['telefono_casa'];
		$telefono_trabajo = $_POST['telefono_trabajo'];
		$telefono_movil = $_POST['telefono_movil'];
		$correo = $_POST['correo'];
		$facebook = $_POST['facebook'];
		$twitter = $_POST['twitter'];
		$brigada_id = $_POST['brigada'];
		$brigada = brigada($brigada_id);
		
		$id_delegacion = $_POST['delegacion'];
		$visita_comentarios = $_POST['observaciones'];
		$id_solicitante = $_POST['id_solicitante'];
		
//foto_lote
//foto_lote2
//ife_frente
//ife_atras		
		$curp = $_POST['curp'];
		if ($curp==''){$msgERROR=$msgERROR."Se requiere el CURP";}

		$edolote_baldio = $_POST['edolote_baldio'];
		if ($edolote_baldio==0){$msgERROR=$msgERROR."¿Esta Baldio el Lote?";}
		
		$edolote_habitado = $_POST['edolote_habitado'];
		if ($edolote_habitado==0){$msgERROR=$msgERROR."¿Esta Habitado el Lote?";}
		
		$edolote_construccion = $_POST['edolote_construccion'];
		if ($edolote_construccion==0){$msgERROR=$msgERROR."¿Esta en construccion el Lote?";}
		
		$edolote_rentado = $_POST['edolote_rentado'];
		if ($edolote_rentado==0){$msgERROR=$msgERROR."¿Esta rentado el Lote?";}
		
		$ubv_habitada = $_POST['ubv_habitada'];
		if ($ubv_habitada==0){$msgERROR=$msgERROR."¿U.B.V Habitada?";}
		
		$ubv_rentada = $_POST['ubv_rentada'];
		if ($ubv_rentada==0){$msgERROR=$msgERROR."¿U.B.V. rentada?";}
		

		$ubv_vacia_buen = $_POST['ubv_vacia_buen'];
		if ($ubv_vacia_buen==0){$msgERROR=$msgERROR."¿U.B.V vacia en buen estado?";}
		

		$ubv_vacia_banda = $_POST['ubv_vacia_banda'];
		if ($ubv_vacia_banda==0){$msgERROR=$msgERROR."¿U.B.V. vacia vandalizada?";}
		

		$observaciones = $_POST['observaciones'];

if($msgERROR==''){
//SINO HAY ERRORES GUARDAMOS

$subida="";		
$archivo = 'notificadores/'.$contrato.'_'.$fecha.'_lote';
$subida= $subida.subir2('fotolote', $archivo, 'jpg');

//$archivo = 'notificadores/'.$contrato.'_'.$fecha.'_ifefrente';
//$subida= $subida.subir2('ife_frente', $archivo, 'jpg');

//$archivo = 'notificadores/'.$contrato.'_'.$fecha.'_ifeatras';
//$subida= $subida.subir2('ife_atras', $archivo, 'jpg');

//subir las fotos
//$archivo = 'notificadores/'.$contrato.'_'.$fecha.'_lote';
//$subida= $subida.subir2('fotolote2', $archivo, 'jpg');

if ($subida=="")
{		



		$msg="";
		
		//pasamos la notificacion a notificadores_visitas en la bd nueva
		$sql = "INSERT INTO notificadores_visitas
		(notificador_nitavu, fecha, visita_fecha, visita_hora, visita_lat, visita_lon, visita_acu, brigada_des, brigada_id, colonia, manzana_lote, contrato, act_curp, act_telefono, act_telefono2, act_telefono_movil, act_facebook, act_twitter, act_correo, estado_lotebaldio, estado_lotehabitado, estado_loteenconstruccion, estado_loterentado, estado_ubvhabitada, estado_ubvvaciaenbuenestado, estado_ubvvaciavandalizada, estado_ubvrentada, delegacion, visita_comentarios)
		VALUES
		('$notificador_nitavu', '$fecha_corte2', '$fecha','$hora','$lat', '$lon', '$acu', '$brigada','$brigada_id', '$colonia', '$manzana', '$contrato','$curp', '$telefono_casa','$telefono_trabajo', '$telefono_movil', '$facebook', '$twitter', '$correo', '$edolote_baldio', '$edolote_habitado','$edolote_construccion','$edolote_rentado', '$ubv_habitada','$ubv_vacia_buen','$ubv_vacia_banda','$ubv_rentada','$id_delegacion','$visita_comentarios')";
		if ($conexion->query($sql) == TRUE)
		{ $msg=$msg."Visita, ";
		}
		else{ $msg=$msg."Error al guardar notificacion (".$sql.")";}



		//pasamos los datos del beneficiarios a la nueva bd
		$sql = "INSERT INTO beneficiarios
		(curp, nombre, paterno, materno, telefono1, telefono2, telefono_movil, correo, facebook, twitter, domicilio, id_solicitante)
		VALUES
		('$curp', '$nombre_', '$paterno', '$materno', '$telefono_casa', '$telefono_trabajo', '$telefono_movil', '$correo', '$facebook', '$twitter', '$domicilio', '$id_solicitante')";
		if ($conexion->query($sql) == TRUE)
		{ $msg=$msg."Beneficiario, ";
		}
		else{ //puede que este repetida, actualizamos 
			
			$sql2="UPDATE beneficiarios SET nombre='$nombre_', paterno='$paterno', materno='$materno', telefono1='$telefono_casa', telefono2='$telefono_trabajo', telefono_movil='$telefono_movil', correo='$correo', facebook='$facebook', twitter='$twitter', domicilio='$domicilio', id_solicitante='$id_solicitante' WHERE (curp='".$curp."')";		
			$r = $conexion -> query($sql2);	
			if ($conexion->query($sql2) == TRUE)
			{ 	$msg = $msg."Actualizacion de Beneficiario, ";
				$str_histo= 'Se actualizaron sus datos por '.nitavu_nombre($notificador_nitavu)."(".$notificador_nitavu.") el ".fecha_larga($fecha)." a ".$hora."";
				beneficiario_historia($curp,$str_histo);
				//echo $str_histo;

				$str_repe = ''.$fecha." : ".$hora." Se encontro repetida una notificacion contrario: ".$contrato.", ".$manzana." en la delegacion ".delegacion_id($id_delegacion)." (".$id_delegacion.") por ".nitavu_nombre($notificador_nitavu)."(".$notificador_nitavu.")";
				beneficiario_notirepetidas($curp,$str_repe);
				//echo $str_repe;

			}
			else { $msg=$msg."Error al Actualizar Beneficiario  (".$sql2.")";}
		}



		//marcamos la notificacion
		$sql="UPDATE notificaciones_old SET folio='X' WHERE (contrato='".$contrato."' AND fecha_corte='".$fecha_corte."')";
		$r = $conexionmigra -> query($sql);
		if ($conexionmigra->query($sql) == TRUE)
		{ $msg = $msg."Se marco la visita";}
		else { $msg=$msg."Error al guardar marcar la visita (".$sql.")";}


		//añadimos un control historico
		historia($notificador_nitavu,' Entrego notificacion de '.$nombre_.' '.$paterno.' ('.$manzana.') en la Col.'.$colonia.' en '.delegacion_id($id_delegacion));
		


		mensaje("Proceso terminado: ".$msg,'notificadores_visita.php?brig=1&busqueda=*');


		}
		else
		{
			mensaje ("NO SE HA PODIDO GUARDAR!, Hubo un error al cargar la foto. Intentelo nuevamente".$subida,'');
		}

}
else
{
	
		mensaje("Hay datos vacios, por favor llenelos ".$msgERROR,'notificadores_visita.php');
}
}
















?>