

<?php
	require("unica/config.php"); require("unica/funciones.php"); 
	require("unica/seguridad.php");


		if(isset($_GET['msj'])){
			notificacion_add ($_GET['chat'], 'chat', $fecha, $nitavu, $_GET['msj']);
			//en asunto se marca como chat, para que no se envien correo por cuando se chatea
			
		}
?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Expires" content="0">
<meta http-equiv="Last-Modified" content="0">
<meta http-equiv="Cache-Control" content="no-cache, mustrevalidate">
<meta http-equiv="Pragma" content="no-cache">
	<title>NOTIFICACIONES</title>
	
	<link rel="stylesheet" href="unica/css_estructura.css">
	
	<style>
		body {
			background-image: none;
			/* background-color: white; */
		}
	</style>
		<script src="jquery-3.2.1.min.js"></script>
  		<script language="javascript" src="txtplus_chat.js" type="text/javascript"></script> 
	<style>
	table:active {

	}
	#preloader2{width:100%;height:100%;background-color:white;opacity:0.9;position:absolute;top:0;z-index:1000;margin:0px}
	
	#loaderx {position: absolute;top: 40%; left: 45%; z-index: 3000;}
	#loaderx img {width: 80px; height: 80px; z-index: 3001; filter: contrast(100%) brightness(140%) grayscale(100%); opacity: 0.7;

	}
	.fotos_mini{width:40px; height:40px; padding:0px; margin:0PX;border-radius:50%;border: 3px white solid;}
	.fotos_mini2{width:40px; height:40px; padding:0px; margin:0PX;border-radius:50%; border: 3px red solid;}
	.fotos_mini3{width:40px; height:40px; padding:0px; margin:0PX;border-radius:50%; border: 3px orange solid;}
	body {
		margin: 0px;
		padding: -5px;
		font-size:11pt;
		font-family:"Compacta";
	}


	::-webkit-scrollbar {
	    width: 12px;
	}
	 
	::-webkit-scrollbar-track {
	    -webkit-box-shadow: inset 0 0 6px rgba(0,0,0,0.3); 
	    border-radius: 10px;
	}
	 
	::-webkit-scrollbar-thumb {
	    border-radius: 10px;
	    -webkit-box-shadow: inset 0 0 6px rgba(0,0,0,0.5); 
	}
</style>

</head>


<body >


<div id="preloader2">
<div id="loaderx" >
			
    		<img src="loader2.gif" ><br>
    		
   			
</div>
</div>



 <div  id='chat_contactos' >


	<?php 
	if (isset($_GET['chat'])){
		//echo "<script>location.reload(); </script>";
		//si selecciono un contacto CHAT
		echo "<div id='chat_top1'>";
		echo "<table width=100% class='tabla' style='margin:0px; padding:0px; border-bottom-width: 0px; border-collapse: auto;
	border-spacing: 0px 0px;'><tr>
		<td width=22px style='background-color:#1BA691; margin: 0px; padding: 0px;'><a href='?='>";
			echo "<img src='left2.png' style='width:30px; height:30px; margin-top:7px; '></a>";

		echo "</td>";
		echo "<td style='background-color:#106457; color: #A2C30D; font-size:11pt;'>".$_GET['chat']."";
		echo "<label style='font-size:8pt; margin-top: -4px; color:#8CB0AE;'>".$_GET['chat']." de ".$_GET['chat']."</label>
		</td></tr></table>
		</div>";
		
		echo "<div id='chat_historia'>";

		$sql = "
		SELECT
			*
		FROM
			notificaciones
		WHERE
			
		
			(nitavu_manda = '".$_GET['chat']."' and  nitavu='".$nitavu."')
		or	(nitavu_manda = '".$nitavu."' and  nitavu='".$_GET['chat']."')

		ORDER BY
		 	id DESC
		LIMIT 0,
		 100
 ";
		$r2 = $conexion -> query($sql);
		//echo $sql;
		//echo "<label >Notificaciones sin leer:</label>";
		
		while($msg = $r2 -> fetch_array())
			{//Acceso a todos los mensajes
			//nitavu_nombre($msg['nitavu_manda'])
			notificaciones_ver($msg['id'],$nitavu);
			if ($msg['nitavu_manda']==$nitavu){//yo
				echo "<div id='chat_nosoyyo'><table class='' border='0' style=''>";
				if ($msg['lectura_fecha']=='0000-00-00'){//aun sin leer
					echo "<tr style='background-color: #FFFF99;' >";
				} else
				{echo "<tr >";}
				
				echo "<td width=30px align=center valign=center>";
				//echo "<img src='fotos/".$msg['nitavu_manda'].".jpg' style=''>";
				echo ponerfoto('fotos/'.$msg['nitavu_manda'].".jpg",'fotos_mini');


				echo "</td>";	

				echo "<td align=left><a href='iframe_chat.php?ver=".$msg['nitavu_manda']."&p=0' title='Pase con ID: ".$msg['id'].", Visto el ".fecha_larga($msg['lectura_fecha'])." a las ".$msg['lectura_hora']." del dia ".fecha_larga($msg['entregar_fecha'])."' style='display: block; color: black;'>";
				
				echo $msg['contenido']."";
				echo "</td>";
				
				
				echo "</a>";
				echo "<tr>";	
				echo "</table></div>";
				
			}
			else{//sino soy yo
				echo "<div id='chat_yo'><table class='' border='0' style=''>";
				if ($msg['lectura_fecha']=='0000-00-00'){//aun sin leer
					echo "<tr style='background-color: #EEEEEE;' >";
				} else
				{echo "<tr >";}
				
				
				
				echo "<td align=left><a href='iframe_chat.php?ver=".$msg['nitavu_manda']."&p=0' title='Pase con ID: ".$msg['id'].", Visto ".fecha_larga($msg['lectura_fecha'])." a las ".$msg['lectura_hora']." del dia ".fecha_larga($msg['entregar_fecha'])."' style='display: block; color: black;'>";

				echo $msg['contenido']."";
				echo "</td>";
				echo "<td width=40px align=right valign=center>";
				echo ponerfoto('fotos/'.$msg['nitavu_manda'].".jpg",'fotos_mini');
				//echo "<img src='fotos/".$msg['nitavu_manda'].".jpg' style='width:40px; height:40px; padding:0px; border-radius:50%;'>";
				echo "</td>";	
				echo "</a>";
				echo "<tr>";	
				echo "</table></div>";

			}
			
			
			
			}	
		echo "</table>";

		echo "</div>";

		echo "	

";
		
	  	echo "<div  id='chat_box_msj'     >";
	  	echo "<form action='iframe_chat.php' method='get'>";	  	
	  	echo "<input type='hidden' name='chat' value='".$_GET['chat']."'>";
	  	//echo "<table border=1><tr>";
	  		
			echo "<div id='chat_box_msj_textarea'  style='width: 315px; left:17px; margin-left:-15px; position: absolute;'><textarea name='msj'></textarea></div>";				
			echo "<div id='chat_box_msj_boton' style='right:0px; margin-right:0px; position: absolute;'><button id='boton_enviar' >";
			echo "<img src='chat_enviar.png' >";
			echo "</button>";

			echo "</div>";
			
		//echo "</table>";
		echo "</form>";
		echo "</div>";


	}
	else {

	if (isset($_GET['q-chat'])){
		echo '<div id="beta_buscar" style="border-radius:0px; width:100%; margin:0px; border: 0px solid white; border-bottom-style: dashed; border-bottom-width: 1px; border-bottom-color:#D6D6D6;">';
		echo '<form action="" method="get">';
		echo "<input type='hidden' name='contactos'>";
		echo '<table broder="1" width="100%"><tr>';
			echo '<td><input required="required" type="text" id="beta_buscar_input" name="q-chat" placeholder="" value="'.$_GET['q-chat'].'"/></td>';
			echo '<td align="right" width="15px">                    
					<button id="beta_buscar_boton">
					<img  src="buscar.png"></button>
					</td>';
		echo '</tr></table>';
			echo '</form>';
		echo '</div>';


		$sql2="SELECT * FROM empleados WHERE nombre like '%".$_GET['q-chat']."%' and estado='' limit 0,10";
		//echo $sql2;
		$r2 = $conexion -> query($sql2);
		echo "<table class='tabla'>";
		while($f = $r2 -> fetch_array())
		{
			echo "<tr>";
			echo "<td width=40px align=center valign=center>";
			echo ponerfoto("fotos/".$f['nitavu'].".jpg",'fotos_mini');
			//echo "<img src='fotos/".$f['nitavu'].".jpg' style='width:40px; height:40px; padding:0px; border-radius:50%;'>";
			echo "</td>";
			
			echo "<td align=left>
			<a style='display: block; color:gray; font-size:9pt;' href='?chat=".$f['nitavu']."&contactos'>".$f['nombre']."</a></td>";
			echo "</tr>";
		}
		echo "</table>";
	} else 
	{

	
		echo '<div id="beta_buscar" style="border-radius:0px; width:100%; margin:0px; border: 0px solid white; border-bottom-style: dashed; border-bottom-width: 1px; border-bottom-color:#D6D6D6;">';
		echo '<form action="" method="get">';
		echo "<input type='hidden' name='contactos'>";
		echo '<table broder="1" width="100%"><tr>';
			echo '<td><input required="required" type="text" id="beta_buscar_input" name="q-chat" placeholder="" /></td>';
			echo '<td align="right" width="15px">                    
					<button id="beta_buscar_boton">
					<img  src="buscar.png"></button>
					</td>';
		echo '</tr></table>';
			echo '</form>';
		echo '</div>';

		//vamos a mostrar las notificaciones sin ver.

		// $sql = "SELECT DISTINCT(nitavu_manda) FROM notificaciones WHERE (nitavu='".$nitavu."'AND lectura_hora='') ORDER by entregar_fecha DESC limit 0,100";
		// $r2 = $conexion -> query($sql);
		// //echo $sql;
		// echo "<label class='normal' >Notificaciones sin leer:</label>";
		// echo "<section id='chat_sinleer' style='background-color: rgba(0, 0, 0, 0.26)'>";
		// while($msg = $r2 -> fetch_array())
		// 	{//Acceso a todos los mensajes
		// 	//nitavu_nombre($msg['nitavu_manda'])
		// 	echo "<article style='border-radius: 3px;'>";

		// 	echo "<td width=40px align=center valign=center>";
		// 	echo "<a href='iframe_chat.php?chat=".$msg['nitavu_manda']."&p=0' title='".nitavu_nombre($msg['nitavu_manda'])."' style='display: block; color: black;'>";
		// 	//echo "<img src='fotos/".$msg['nitavu_manda'].".jpg'  style='border-radius: 3px;'>";
		// 	echo ponerfoto("fotos/".$msg['nitavu'].".jpg",'fotos_mini');
		// 	echo "</a>";
		// 	echo "</article>";		
				
			
			
			
		// 	}	
		// echo "</section>";


		//vamos a mostrar las notificaciones sin ver.

		$sql = "
		SELECT DISTINCT
		(nitavu) AS Qnuc,
	
			(	SELECT	count(*)		FROM	notificaciones
				WHERE	nitavu = Qnuc
				AND nitavu_manda = '".$nitavu."'		AND lectura_hora = ''	) AS misenvios_sinleer,

			
			(SELECT nombre FROM empleados WHERE nitavu = Qnuc) AS nombre,

			(	SELECT	count(*)		FROM		notificaciones
				WHERE		nitavu = '".$nitavu."'		
				AND nitavu_manda = Qnuc		AND lectura_hora = ''	) AS loquenoheleido

		FROM
			notificaciones
		WHERE
			nitavu_manda = '".$nitavu."' or nitavu = '".$nitavu."'


		UNION

		SELECT DISTINCT
			(nitavu_manda) AS Qnuc,
			
			(	SELECT	count(*)		FROM	notificaciones
				WHERE	nitavu = Qnuc
				AND nitavu_manda = '".$nitavu."'		AND lectura_hora = ''	) AS misenvios_sinleer,

			
			(SELECT nombre FROM empleados WHERE nitavu = Qnuc) AS nombre,

			(	SELECT	count(*)		FROM		notificaciones
				WHERE		nitavu = '".$nitavu."'		
				AND nitavu_manda = Qnuc		AND lectura_hora = ''	) AS loquenoheleido

		FROM
			notificaciones
		WHERE
			nitavu_manda = '".$nitavu."' or nitavu = '".$nitavu."'

		
		";
		$r2 = $conexion -> query($sql);
		//echo $sql;
		//echo "<label> Recientes:</label>";
		echo "<section id='chat_sinleer'>";
		//echo $sql;
		$title="";
		while($msg = $r2 -> fetch_array())
			{//Acceso a todos los mensajes
			//nitavu_nombre($msg['nitavu_manda'])
			$title = ''.$msg['nombre'];
			if ($msg['misenvios_sinleer']<>0){
				$title = $title.', no ha leido '.$msg['misenvios_sinleer'].' mensajes que le he enviado';
			}
			
			if ($msg['loquenoheleido']<>0){
				$title = $title.", Pero yo tengo ".$msg['loquenoheleido']." que no he leido.";
			}
			
			echo "<article style='border-radius: 50%;'>";

			echo "<td width=40px align=center valign=center>";

			echo "<a title='".$title."' href='iframe_chat.php?chat=".$msg['Qnuc']."&p=0' title='".nitavu_nombre($msg['Qnuc'])."' style='display: block; color: black;'>";
			//echo "<img src='fotos/".$msg['nitavu'].".jpg' >";
			
			if ($msg['loquenoheleido']<>'0'){
				echo ponerfoto("fotos/".$msg['Qnuc'].".jpg",'fotos_mini2');
			}
			else{
				if ($msg['misenvios_sinleer']<>'0'){
					echo ponerfoto("fotos/".$msg['Qnuc'].".jpg",'fotos_mini3');
				}
				else{echo ponerfoto("fotos/".$msg['Qnuc'].".jpg",'fotos_mini');}
			}
			
			
			echo "</a>";
			echo "</article>";		
			}
			
			
			
			}	
		echo "</section>";













	}



	?>



	
	
</div>	



<script type="text/javascript"> // Desaparece el preloader
document.getElementById("preloader2").style.display='none';

</script> 


</body>
</html>	