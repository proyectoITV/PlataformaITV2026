
<?php

function pases_desfase($nitavu_, $desde, $hasta, $detalles){
require("config.php");	
	$sql = "SELECT * FROM empleados_salidas_temporal WHERE (registro_entrada>hora_hasta) AND
	(solicito_fecha>='".$desde."') AND (solicito_fecha<='".$hasta."') AND
	(nitavu='".$nitavu_."') ORDER by dpto ASC";
	$rc= $conexion -> query($sql);
	$resumen="";
	$r2="";
	$total_retraso="00:00:00";
	
	while($f = $rc -> fetch_array()) {
					$retraso =  tiempo_restar_hr($f['hora_hasta'],$f['registro_entrada']);	

				if ($retraso>$tolerancia){

					$lapso =  tiempo_restar_hr($f['hora_desde'],$f['hora_hasta']);					
					$total_retraso = tiempo_sumar_hr($total_retraso,$retraso);

					if ($f['registro_salida']>$f['hora_desde']){
							$desfase_permiso = tiempo_restar_hr($f['hora_desde'],$f['registro_salida']);

							if ($desfase_permiso>$tolerancia){
							$r2="Salio despues de la hora solicitada ".$desfase_permiso."min";
							}
					}
					else 
					{
						$desfase_permiso = tiempo_restar_hr($f['registro_salida'],$f['hora_desde']);	
						if ($desfase_permiso>$tolerancia){
							$r2="Salio ".$desfase_permiso." minutos antes de la hora que solicito";
						}
				
					}

					$resumen = $resumen. "<li>".fecha_larga($f['solicito_fecha'])." [".$lapso."min] para las ".$f['hora_desde']."hr tuvo un retraso de llegada de <b>".$retraso."min. </b><span class='tenue'>(Salida: ".$f['registro_salida'].", Regreso: ".$f['registro_entrada'].")</span> ";

					if ($r2<>""){$resumen=$resumen.$r2;}
					$resumen= $resumen."</li>";
				}

		}

	if ($detalles=='TRUE'){
		if ($resumen<>""){return "<b class='alerta'>Retraso:  ".$total_retraso." minutos.</b><br><lu>".$resumen."</lu>";}

	}
	else
	{
		return $total_retraso;	
	}
	

}




function dia_semana($fecha_){
$dias = array('Lunes','Martes','Miercoles','Jueves','Viernes','Sabado','Domingo');
$n= date('N', strtotime($fecha_));
$fecha = $dias[$n-1];
return $fecha;
//return $fecha_;
//return date('N', strtotime($fecha_));
}
function fecha_larga($fecha_){
	return  dia_semana($fecha_)." ".date('d/M/Y', strtotime($fecha_));
}

function itop($ip){
require("config.php");	
$sql = "SELECT * FROM ipinterface WHERE (ipaddress='".$ip."')";
$r2 = $conexionitop -> query($sql);
$tmp="";
while($f = $r2 -> fetch_array())
	{//Categorias de Aplicaciones
	
		
		echo $f['comment']. " [ mac:".$f['macaddress'].", Gateway: ".$f['ipgateway']."]";
		
	
	}
}

function pases_detalles($id){
require("config.php");	
		$sql = "SELECT * FROM empleados_salidas_temporal WHERE (id='$id')";
					
		//$pases = $r -> num_rows;
		$rc= $conexion -> query($sql);
		if($f = $rc -> fetch_array())
		{
			return "".$f['id']." de las ".$f['hora_desde']."hr a las ".$f['hora_hasta']." para el ".$f['fecha']." de asunto ".$f['asunto'];
		}
		else
		{
			return FALSE;
		}	

		
		

}



function pases_quien($id){
require("config.php");	
		$sql = "SELECT * FROM empleados_salidas_temporal WHERE (id='$id')";
		$rc= $conexion -> query($sql);
		if($f = $rc -> fetch_array())

		{
			return $f['nitavu'];
		}
		else
		{
			return FALSE;
		}	

		
		

}

function carga_apps_free_info(){
require("config.php");
$sql = "SELECT * FROM aplicaciones WHERE (idapcat='8') AND version >'0'";
$r2 = $conexion -> query($sql);
$tmp="";
while($f = $r2 -> fetch_array())
	{//Categorias de Aplicaciones
	
		
				 		$tmp = $tmp."<article>";
					 	$tmp = $tmp. "<a href='".$f['vinculo']."'>";
					 	$tmp = $tmp. "<table border='0'><tr><td>";
						
						if ($f['icono']<>"") {
					 		$tmp = $tmp. "<img src='./icon/".$f['icono']."' class='icono_menu'>";
						 	}
					 	$tmp = $tmp. "</td><td><b class='normal menu_font_n'>".$f['nombre'].":</b> ";
					 	$tmp = $tmp. "<cite class='tenue menu_font_d pc'>".$f['descripcion']."</cite>";
					 	$tmp = $tmp. "</td></tr></table></a></article>";	
		
	
	}
	return $tmp;	
}


function carga_apps_free(){
require("config.php");
$sql = "SELECT * FROM aplicaciones WHERE (idapcat='2') AND version >'0'";
$r2 = $conexion -> query($sql);
$tmp="";
while($f = $r2 -> fetch_array())
	{//Categorias de Aplicaciones
	
		
				 		$tmp = $tmp."<article>";
					 	$tmp = $tmp. "<a href='".$f['vinculo']."'>";
					 	$tmp = $tmp. "<table border='0'><tr><td>";
						
						if ($f['icono']<>"") {
					 		$tmp = $tmp. "<img src='./icon/".$f['icono']."' class='icono_menu'>";
						 	}
					 	$tmp = $tmp. "</td><td><b class='normal menu_font_n'>".$f['nombre'].":</b> ";
					 	$tmp = $tmp. "<cite class='tenue menu_font_d pc'>".$f['descripcion']."</cite>";
					 	$tmp = $tmp. "</td></tr></table></a></article>";	
		
	
	}
	return $tmp;	
}

function carga_apps($idapcat, $nitavu){
require("config.php");
$sql = "SELECT * FROM aplicaciones WHERE (idapcat='".$idapcat."') AND version >'0'";
$r2 = $conexion -> query($sql);
$tmp="";
while($f = $r2 -> fetch_array())
	{//Categorias de Aplicaciones
	
		if (sanpedro($f['idapp'],$nitavu)==TRUE){
				 		$tmp = $tmp."<article>";
					 	$tmp = $tmp. "<a href='".$f['vinculo']."'>";
					 	$tmp = $tmp. "<table border='0'><tr><td>";
						
						if ($f['icono']<>"") {
					 		$tmp = $tmp. "<img src='./icon/".$f['icono']."' class='icono_menu'>";
						 	}
					 	$tmp = $tmp. "</td><td><b class='normal menu_font_n'>".$f['nombre'].":</b> ";
					 	$tmp = $tmp. "<cite class='tenue menu_font_d pc'>".$f['descripcion']."</cite>";
					 	$tmp = $tmp. "</td></tr></table></a></article>";	
		
		}
	}
	return $tmp;	
}


function visitas($nitavu){
require("config.php");	
		$nivel = aplicacion_nivel('ap15', $nitavu);
		$dpto = nitavu_dpto($nitavu);

		if ($nivel=='1') {
			$sql = "SELECT * FROM visitas WHERE (autorizo_nitavu='')";
			$r= $conexion -> query($sql);			
			$visitas = $r -> num_rows;
			return $visitas;
		}
		
		if ($nivel=='2') {
			$sql = "SELECT * FROM visitas WHERE (autorizo_nitavu='' AND dpto='".$dpto."')";
			$r= $conexion -> query($sql);			
			$visitas = $r -> num_rows;
			return $visitas;
		}
		
}


function pases($nitavu){
require("config.php");	
		$nivel = aplicacion_nivel('ap12', $nitavu);
		$dpto = nitavu_dpto($nitavu);
		$pases = 0;
		if ($nivel==1) {
			$sql = "SELECT * FROM empleados_salidas_temporal WHERE (autorizo_nitavu='' AND fecha>='".$fecha."')";
			$r= $conexion -> query($sql);			
			$pases = $r -> num_rows;
		}
		
		if ($nivel==2) {
			$sql = "SELECT * FROM empleados_salidas_temporal WHERE (autorizo_nitavu='' AND dpto='".$dpto."' AND fecha>='".$fecha."')";
			$r= $conexion -> query($sql);			
			$pases = $r -> num_rows;
		}
		

		return $pases;

}


function archivo_pases($nitavu, $fecha_, $hr_salida){
$nombrearchivo = "salidas/".$nitavu."_".str_replace("-", "", $fecha_)."_".str_replace(":", "", $hr_salida)."";
return $nombrearchivo;

}

function tiempo_restar_fecha($fecha_i, $fecha_f){
	$dias	= (strtotime($fecha_i)-strtotime($fecha_f))/86400;
	$dias 	= abs($dias); $dias = floor($dias);		
	return $dias;

}


function tiempo_sumar_hr($horaini,$horafin)
{
	$horai=substr($horaini,0,2);
	$mini=substr($horaini,3,2);
	$segi=substr($horaini,6,2);
 
	$horaf=substr($horafin,0,2);
	$minf=substr($horafin,3,2);
	$segf=substr($horafin,6,2);
 
	$ini=((($horai*60)*60)+($mini*60)+$segi);
	$fin=((($horaf*60)*60)+($minf*60)+$segf);
 
	$dif=$fin+$ini;
 
	$difh=floor($dif/3600);
	$difm=floor(($dif-($difh*3600))/60);
	$difs=$dif-($difm*60)-($difh*3600);
	return date("H:i:s",mktime($difh,$difm,$difs));
}

function tiempo_restar_hr($horaini,$horafin)
{
	$horai=substr($horaini,0,2);
	$mini=substr($horaini,3,2);
	$segi=substr($horaini,6,2);
 
	$horaf=substr($horafin,0,2);
	$minf=substr($horafin,3,2);
	$segf=substr($horafin,6,2);
 
	$ini=((($horai*60)*60)+($mini*60)+$segi);
	$fin=((($horaf*60)*60)+($minf*60)+$segf);
 
	$dif=$fin-$ini;
 
	$difh=floor($dif/3600);
	$difm=floor(($dif-($difh*3600))/60);
	$difs=$dif-($difm*60)-($difh*3600);
	return date("H:i:s",mktime($difh,$difm,$difs));
}

function geo_guarda($nitavu_, $lat, $lon, $descripcion){
require("config.php");	
	$sql = "INSERT INTO empleados_geo
		(nitavu, lat, lon, fecha, hora, descripcion)
		VALUES
		('$nitavu', '$lat', '$lon', '$fecha', '$hora','$descripcion')";
		if ($conexion->query($sql) == TRUE)
		{
			return TRUE;
			//header('location:../index.php');	
		}
		else
		{
			return FALSE;
			//echo $sql;
		}
}



function historia($nitavu_, $descripcion){
		require("config.php");
		//funcion que otorga acceso a las aplicaciones
		$sql = "INSERT INTO historia
		(nitavu, fecha, hora, descripcion)
		VALUES
		('$nitavu_', '$fecha', '$hora','$descripcion')";
		if ($conexion->query($sql) == TRUE)
		{	//echo "ok";
			return TRUE;
		}
		else
		{	//echo $sql;
			return FALSE;
		}


}
		
function aplicacion_historia($nitavu_, $descripcion, $version){
		require("config.php");
		//funcion que otorga acceso a las aplicaciones
		$sql = "INSERT INTO aplicacion_historia
		(nitavu, fecha, descripcion, version)
		VALUES
		('$nitavu_', '$fecha', '$descripcion', '$version')";
		if ($conexion->query($sql) == TRUE)
		{
			return TRUE;
		}
		else
		{
			return FALSE;
		}
}





function valida_fecha($fecha_){
if(preg_match('/^[0-9]{4}-[0-9]{2}-[0-9]{2}$/', $fecha_)){
//it's ok
return TRUE;
}else{
//it's bad
return FALSE;
}

}
function sugerencia($msg){
	$msg = '
	<div id="sugerencias">
			<table border="0"><tr>
				<td><img src="./icon/sugerencia.png" class="icono"></td>
				<td>
						 '.$msg.'
				</td></tr></table>
			</div>
	';
	return $msg;
	}
function ponerfoto($archivo,$clase)
	{
	if (file_exists($archivo)){
		return '<a href="'.$archivo.'"><img src="'.$archivo.'" class="'.$clase.'"></a>';
		}
	else
	{
		return '<img src="img/sinfoto.png" class="'.$clase.'">';
	}
	}

function ponerfoto_app($archivo,$clase)
	{
	if (file_exists($archivo)){
		return '<a href="'.$archivo.'"><img src="'.$archivo.'" class="'.$clase.'"></a>';
		}
	else
	{
		//return '<img src="img/sinfoto.png" class="'.$clase.'">';
		return "";
	}
	}


function ponericono($archivo,$clase)
	{
	if (file_exists($archivo)){
		return '<a href="'.$archivo.'"><img src="'.$archivo.'" class="'.$clase.'"></a>';
		}
	else
	{
		return '<img src="icon/sinfoto.png" class="'.$clase.'">';
	}
	}



	function subir($nombredelcontrol, $archivo, $ext)
	{
		$msgE='';
						
		if (substr($_FILES[$nombredelcontrol]['type'], 0, 11)=="application"){
			$msgE= "ERROR: Es una aplicacion";
			}
			else
			{
				if ($_FILES[$nombredelcontrol]['size']<2000000) {
					//$target_path = "".$donde."/";
					$target_path = $archivo.'.'.$ext;
					if(move_uploaded_file($_FILES[$nombredelcontrol]['tmp_name'], $target_path))
						{ $msgE= "La foto se  ". $archivo.'.'.$ext. " ha guardado exito<br>";
						} else{
						$msgE= "No se actualizo ".$nombredelcontrol.", ";
						}
				} else {
					$msgE ="ERROR: El archivo que intenta subir es mayor de 2mb";
					}
				
			}
			
	return $msgE;
	}
		
	function notificaciones_ver($no_oficio,$nitavu_){
		require("config.php");
		$sql = "SELECT * FROM notificaciones WHERE (nitavu='".$nitavu_."' AND no_oficio='".$no_oficio."')";
		$rc= $conexion -> query($sql);
		if($f = $rc -> fetch_array())
						{
			$sql="UPDATE notificaciones SET lectura_fecha='".$fecha."', lectura_hora='".$hora."' WHERE (nitavu='".$nitavu_."' AND no_oficio='".$no_oficio."')";
			$resultado = $conexion -> query($sql);
			if ($conexion->query($sql) == TRUE)
				{
				return TRUE;
				}
				else
				{
					return FALSE;
				}
			
			}
		else
		{
			return FALSE;
		}
			
	}
	function ceropapel(){
		require("config.php");
		$sql = "SELECT * FROM contadores WHERE id='0'";
		$rc= $conexion -> query($sql);
		if($f = $rc -> fetch_array())
						{
								return $f['ceropapel'];
			}
			
	}
	function docdigital_no($consulta, $cuantas){
		require("config.php");
		$sql = "SELECT * FROM contadores WHERE id='0'";
		$rc= $conexion -> query($sql);
		if($f = $rc -> fetch_array())
						{
			if ($consulta==TRUE) {
							return $f['docdigital'];
			}
			else
			{ // sino es consulta entonces aumentarle y aumentar el contador de ceropapel
			// la diferencia entre ceropapel y este, es que cero papel se multiplica
			// por las copias que se entregan o con copia, para estadistica de cuanto se ha ahorrado
			$docdigital = $f['docdigital'];
			$docdigitalnew = $docdigital + 1;
			$ceropapel = $f['ceropapel'] + $cuantas;
			$sql="UPDATE contadores SET docdigital='".$docdigitalnew."', ceropapel='".$ceropapel."' WHERE id='0'";
			$resultado = $conexion -> query($sql);
			if ($conexion->query($sql) == TRUE) {
				return $f['docdigital'];
			}
			else {return  FALSE;}
						}
		}
		else
		{ return FALSE;}
	}
function mensaje($mensaje, $link){
	if ($link=="") {$link = "../index.php";}
			echo '<div class="centrar_mensaje_padre"><div class="centrar_mensaje_hijo">';
				
				echo '<div id="mensaje">';
					echo '<p>'.$mensaje.'</p>';
					echo '<br><br>';
					
					echo '<a class="Mbtn btn-default" href="'.$link.'">Aceptar</a>';
					
				echo '</div></div></div>';
		}
	




		function ver($no_oficio){
		require("config.php");
		//funcion que otorga acceso a las aplicaciones
		$sql = "INSERT INTO notificaciones
		(nitavu, asunto, entregar_fecha, nitavu_manda, contenido)
		VALUES
		('$usuario', '$asunto', '$entregar_fecha','$itavu_manda', '$contenido')";
		if ($conexion->query($sql) == TRUE)
		{
			return TRUE;
		}
		else
		{
			return FALSE;
		}
		}
		function notificacion_add ($usuario, $asunto, $entregar_fecha, $itavu_manda, $contenido){
		require("config.php");
		//funcion que otorga acceso a las aplicaciones
		$oficio = docdigital_no(FALSE, 2);
		$sql = "INSERT INTO notificaciones
		(nitavu, asunto, entregar_fecha, nitavu_manda, contenido, no_oficio)
		VALUES
		('$usuario', '$asunto', '$entregar_fecha','$itavu_manda', '$contenido', '$oficio')";
		if ($conexion->query($sql) == TRUE)
		{
			return TRUE;
		}
		else
		{
			return FALSE;
		}
		}
		function notificaciones_detalle($oficio){
		require("config.php");
			$sql = "SELECT * FROM notificaciones WHERE no_oficio='".$oficio."'";
			$rc= $conexion -> query($sql);
			$hay = 0;
			$msg="";
			while($m = $rc -> fetch_array()) {
				$msg= $msg."<li>".$m['no_oficio']." entregada ".$m['entregar_fecha']." a ".nitavu_nombre($m['nitavu']).". Asunto: ".$m['asunto']."";
					if ($m['lectura_hora']=="") {
							$msg = $msg.". Aun sin leer"	;
					}
					else {
						$msg = $msg. ", leida el ".$m['lectura_fecha']." a las ".$m['lectura_hora']."hrs.";
					}
				echo "</li>";
				$hay = $hay +1;
			}
			//$msg = $msg."</lu>";
			$msg=$msg."";
			if ($hay>0) {
				return $msg."";
			}
			else{
				return "";
			}
			
		}


	function aplicaciones_nivel($n){
		require("config.php");
			$sql = "SELECT * FROM aplicaciones_permisos	 WHERE nitavu='".$n."'";
			$rc= $conexion -> query($sql);
			$msg="";
			if($f = $rc -> fetch_array())
				{
					
					return $f['nivel'];
					}
			else
				{ return FALSE;}
		}



	function aplicacion_categoria($idapp){
		require("config.php");
			$sql = "SELECT * FROM aplicaciones	WHERE idapp='".$idapp."'";
			$rc= $conexion -> query($sql);
			$msg="";
			if($f = $rc -> fetch_array())
				{				
					return $f['idapcat'];
				}
			else
				{ return FALSE;}
		}


		function nivel_que($n){
		require("config.php");
			$sql = "SELECT * FROM aplicaciones_nivelusuario	 WHERE id='".$n."'";
			$rc= $conexion -> query($sql);
			$msg="";
			if($f = $rc -> fetch_array())
				{
					
					return $f['modo'];
					}
			else
				{ return FALSE;}
		}















		function idapp_categoria($idapp){
		require("config.php");
			$sql = "SELECT * FROM aplicaciones WHERE idapp='".$idapp."'";
			$rc= $conexion -> query($sql);
			$msg="";
			if($f = $rc -> fetch_array())
				{
					
								
					return $msg['idapcat'];
					}
			else
				{ return FALSE;}
		}




		function app_detalle($idapp){
		require("config.php");
			$sql = "SELECT * FROM aplicaciones WHERE idapp='".$idapp."'";
			$rc= $conexion -> query($sql);
			$msg="";
			if($f = $rc -> fetch_array())
				{

					$msg="<table><tr>";
					$msg= $msg."<td>";
					$archivo = "icon/".$f['icono'];
				
						$foto = "<img src='icon/".$f['icono']."' class='mini_icono2'>";
						$msg = $msg.$foto;					
					
					$msg=  $msg. "</td>";
					$msg = $msg."<td><span class='app_titulo'>".$f['nombre']."</span><span class='app_version'>".$f['version']."</span></td>";
					$msg = $msg."<td class='pc'><span class='app_des'>".$f['descripcion']."</span></td>";
					$msg= $msg."</tr></table>";
					return $msg;
					}
			else
				{ return FALSE;}
		}

function app_nombre($idapp){
		require("config.php");
			$sql = "SELECT * FROM aplicaciones WHERE idapp='".$idapp."'";
			$rc= $conexion -> query($sql);
			$msg="";
			if($f = $rc -> fetch_array())
				{
						return $f['nombre'];
				}
			else
				{ return FALSE;}
		}		

function app_version($idapp){
		require("config.php");
			$sql = "SELECT * FROM aplicaciones WHERE idapp='".$idapp."'";
			$rc= $conexion -> query($sql);
			$msg="";
			if($f = $rc -> fetch_array())
				{
						return $f['version'];
				}
			else
				{ return FALSE;}
		}
		function notificaciones_count($nitavu){
		require("config.php");
			$sql = "SELECT * FROM notificaciones WHERE (nitavu='".$nitavu."' AND lectura_hora='')";
			$r = $conexion -> query($sql);
			$r_count = $r -> num_rows;
			return $r_count;
			
		}


		function aplicacion_nivel($idapp,$usuario){
		require("config.php");
		//funcion que otorga acceso a las aplicaciones
		$sql = "SELECT * FROM aplicaciones_permisos WHERE (nitavu='".$usuario."' AND idapp='".$idapp."')";
			$rc= $conexion -> query($sql);
			if($f = $rc -> fetch_array())
				{
					return $f['nivel'];
				}
			else
				{ return 0;}
		}






		function sanpedro ($idapp,$usuario){
		require("config.php");
		//funcion que otorga acceso a las aplicaciones
		//pero a san pedro no le importa tu nivel, si estas en la lista te deja pasar
		$sql = "SELECT * FROM aplicaciones_permisos WHERE (nitavu='".$usuario."' AND idapp='".$idapp."' )";
			$rc= $conexion -> query($sql);
			if($f = $rc -> fetch_array())
				{
					return TRUE;
				}
			else
				{ return FALSE;}
		}



		function dedondeeres($id){
		require("config.php");
			$sql = "SELECT * FROM empleados WHERE nitavu='".$id."'";
			$rc= $conexion -> query($sql);
			$msg="";
			if($f = $rc -> fetch_array())
				{
					return $f['ciudad'].", Tamaulipas.";
				}
			else
				{ return FALSE;}
		}

	
		function nitavu_tel_ext($id){
		require("config.php");
			$sql = "SELECT * FROM empleados WHERE nitavu='".$id."'";
			$rc= $conexion -> query($sql);
			$msg="";
			if($f = $rc -> fetch_array())
				{
					return $f['telefono_extension'];
				}
			else
				{ return FALSE;}
		}




function nitavu_tel($id){
		require("config.php");
			$sql = "SELECT * FROM empleados WHERE nitavu='".$id."'";
			$rc= $conexion -> query($sql);
			$msg="";
			if($f = $rc -> fetch_array())
				{
					return $f['telefono'];
				}
			else
				{ return FALSE;}
		}		

		function nitavu_nombre($id){
		require("config.php");
			$sql = "SELECT * FROM empleados WHERE nitavu='".$id."'";
			$rc= $conexion -> query($sql);
			$msg="";
			if($f = $rc -> fetch_array())
				{
				if ($f['profesion_abr']==""){
						return $f['nombre'];}
					else
						{return $f['profesion_abr'].". ".$f['nombre'];}
				}
			else
				{ return FALSE;}
		}


		function nitavu_dir($id){
		require("config.php");
			$sql = "SELECT * FROM empleados WHERE nitavu='".$id."'";
			$rc= $conexion -> query($sql);
			$msg="";
			if($f = $rc -> fetch_array())
				{return $f['direccion'];}
			else
				{ return FALSE;}
		}



		function dpto_au($id){
		require("config.php");
			$sql = "SELECT * FROM empleados_salidas_temporal WHERE id='".$id."'";
			$rc= $conexion -> query($sql);
			$msg="";
			if($f = $rc -> fetch_array())
				{return nitavu_dpto($f['nitavu']);}
			else
				{ return FALSE;}
		}























		function nitavu_dpto($id){
		require("config.php");
			$sql = "SELECT * FROM empleados WHERE nitavu='".$id."'";
			$rc= $conexion -> query($sql);
			$msg="";
			if($f = $rc -> fetch_array())
				{return $f['departamento'];}
			else
				{ return FALSE;}
		}
		function nitavu_puesto($id){
		require("config.php");
			$sql = "SELECT * FROM empleados WHERE nitavu='".$id."'";
			$rc= $conexion -> query($sql);
			$msg="";
			if($f = $rc -> fetch_array())
				{return $f['puesto'];}
			else
				{ return FALSE;}
		}
		function user_quien($id){
		require("config.php");
			$sql = "SELECT * FROM empleados WHERE nitavu='".$id."'";
			$rc= $conexion -> query($sql);
			$msg="";
			if($f = $rc -> fetch_array())
				{
					
					$msg ="<b>".$f['nombre']."</b>, ".$f['puesto']." de ".$f['departamento'];
					
					return $msg;
					}
			else
				{ return FALSE;}
		}
		function user_historia($id){
		require("config.php");
			$sql = "SELECT * FROM empleados WHERE nitavu='".$id."'";
			$rc= $conexion -> query($sql);
			$msg="";
			if($f = $rc -> fetch_array())
				{
					
					$msg ="".$f['historia']."<br>";
					
					return $msg;
					}
			else
				{ return FALSE;}
		}
		function user_legend($id){
		require("config.php");
			$sql = "SELECT * FROM empleados WHERE nitavu='".$id."'";
			$rc= $conexion -> query($sql);
			$msg="";
			if($f = $rc -> fetch_array())
				{
					
					$msg = $msg."<b>".$f['nombre']."</b><br>";
					$msg = $msg.$f['puesto']." de ".$f['departamento'];
					
					return $msg;
					}
			else
				{ return FALSE;}
		}


function user_alertas($id){
require("config.php");
	$sql = "SELECT * FROM empleados WHERE nitavu='".$id."'";
	$rc= $conexion -> query($sql);
	$msg="";
	if($f = $rc -> fetch_array())
		{
			$msg="";

			if ($f['nitavu']==$f['nip']) // una alerta; PONERLAS EN ARTICLEca
				{
				$msg = $msg."<article><a href='nip_update.php'>".
							"<b>Debe cambiar su NIP por seguridad.</b> <cite> Debido a que de manera predeterminada es el mismo que su Numero de ITAVU</cite>"
				."</a></article>";
				}
			
			$pases = pases($f['nitavu']);
			if ($pases>0) // una alerta; PONERLAS EN ARTICLE
				{
				$msg = $msg."<article><a href='auscencia_temporal_autoriza.php'>".
							"<b>Hay ".$pases." pases por aprobar</b> </cite>"
				."</a></article>";
				}
				

			$visitas = visitas($f['nitavu']);
			if ($visitas>0) // una alerta; PONERLAS EN ARTICLE
				{
				$msg = $msg."<article><a href='visitas.php'>".
							"<b>Tienes ".$visitas." Visitas, Verifica las aprobaciones</b> </cite>"
				."</a></article>";
				}


			$desface = pases_desfase($f['nitavu'], $fecha, $fecha, 'FALSE')	;			
			if ($desface>0) // una alerta; PONERLAS EN ARTICLE
				{
				$msg = $msg."<article>".
							"<b>Tienes ".$desface."min. de retraso en tu pase de salida</b> "
				."</article>";
				}

			return $msg;
			
			}
	else
		{ return FALSE;}
}



function detectar()
		{
			$browser=array("IE","OPERA","MOZILLA","NETSCAPE","FIREFOX","SAFARI","CHROME");
			$os=array("WIN","MAC","LINUX");
			# definimos unos valores por defecto para el navegador y el sistema operativo
			$info['browser'] = "OTHER";
			$info['os'] = "OTHER";
			# buscamos el navegador con su sistema operativo
			foreach($browser as $parent)
			{
				$s = strpos(strtoupper($_SERVER['HTTP_USER_AGENT']), $parent);
				$f = $s + strlen($parent);
				$version = substr($_SERVER['HTTP_USER_AGENT'], $f, 15);
				$version = preg_replace('/[^0-9,.]/','',$version);
				if ($s)
				{
					$info['browser'] = $parent;
					$info['version'] = $version;
					
				}
			}
			# obtenemos el sistema operativo
			foreach($os as $val)
			{
				if (strpos(strtoupper($_SERVER['HTTP_USER_AGENT']),$val)!==false)
					$info['os'] = $val;
			}
			# devolvemos el array de valores
			
			echo getenv('HTTP_CLIENT_IP');
			echo getenv('HTTP_X_FORWADED_FOR');
			echo getenv('REMOTE_ADDR');
			$infofull="";
			$infofull = $infofull. "SO: ".$info['os']."<br>";
			$infofull = $infofull. "Nav: ".$info['browser']."<br>";
			$infofull = $infofull. "Ver: ".$info['version']."<br>";
			$infofull = $infofull. "Agente ".$_SERVER['HTTP_USER_AGENT']."<br>";
			
			$infofull = $infofull. "ip: ".getenv('HTTP_CLIENT_IP')."<br>";
			$infofull = $infofull. "ip: ".getenv('HTTP_X_FORWADED_FOR')."<br>";
			$infofull = $infofull. "ip: ".getenv('REMOTE_ADDR')."<br>";
			
			return $infofull;
		}
?>