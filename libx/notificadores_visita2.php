<?php
//include ("./lib/seguridad.php"); 
include ("./lib/body_head.php");
include ("./lib/body_menu.php");

// contenido:
?>


<section id="alertas">
<!-- 	La funcion escribe los article segun las alertas que existan -->
</section>

<?php
$id_aplicacion ="ap27"; //ap07=Permisos de Aplicacion
$nivel = aplicacion_nivel($id_aplicacion, $nitavu);
//$nivel =1;
echo "<h5 class='pc'>".app_detalle($id_aplicacion)."</div>";
echo nivel_detalle($nivel,'');
if (sanpedro($id_aplicacion, $nitavu)==TRUE){
		// lista de notificaciones disponibles
		historia($nitavu,'Consultando notificaciones');

		if (isset($_GET['brig'])){ // si brig entra en '' = 1
			if ($_GET['brig']==''){
				$_GET['brig']=1;
			}
		}

			echo "<table  class='' border='0' width='90%' align='center'><tr>";
			echo "<td align='right' valign='top' width='10%'>";
			//echo "<a class='movil' href='notificadores_visita2.php?brig'><img src='icon/atras.png' class='icono2'></a>";
			echo "<a class=' Mbtn btn-default' href='notificadores_visita2.php?brig'><br>Regresar<br></a>";			
			echo "</td>";

			
			echo "<td  align='center' class=''>";
			$url = 'notificadores_visita2.php?';
			$url = $url.'brig='.$_GET['brig'];
			if (isset($_GET['col'])){$url = $url.'&col='.$_GET['col'];}
			if (isset($_GET['mun'])){$url = $url.'&mun='.$_GET['mun'];}
			if (isset($_GET['m'])){$url = $url.'&m='.$_GET['m'];}
			
			buscar($url,"BUSCAR nombre, contrato, manzana, lote...",$_GET['brig']);
			echo "<span class='tchico tenue'>".midelegacion($nitavu)."</span>";
			echo "</td>";

			
			echo "<td class='tenue tchico' width='10%'>Notificaciones <br>por entregar: <br>";
				$notis = notificadores_pendientes($nitavu, $_GET['brig']);
				if ($notis >0 ){
					echo "<span class='alerta tgrande'>".$notis."</span>";
				}
				else {
					echo "0";
				}
			echo "</td>";

			if ($nivel=='2' or $nivel=='1') {
				echo "<td class='tenue tchico' width='10%'>Notificaciones <br>por VoBo: <br>";
				$notis = notificadores_pendientes_vobo($nitavu, $nivel);
				if ($notis >0 ){
					echo "<span class='ejecutandose tgrande'><a class='ejecutandose' href='?busqueda=VoBo&brig='>".$notis."</a></span>";
				}
				else {
										echo "<span class='tenue tgrande'><a class='tenue' href='?busqueda=VoBo&brig='>".$notis."</a></span>";
				}
			echo "</td>";

			}

			echo "</tr></table>";
		
			// echo "<span  align='center' class='movil'>";
			// buscar("notificadores_visita.php","BUSCAR CONTRATO  o con parte del mismo",$_GET['brig']);
			// echo "</span>";
			
if (isset($_GET['l'])){
$sql = "SELECT * FROM notificadores_visitas WHERE 
brigada_id='".$_GET['brig']."' AND id_colonia='".$_GET['col']."' AND id_municipio='".$_GET['mun']."' AND manzana='".$_GET['m']."' AND lote='".$_GET['l']."' ";

$sql_prev=  str_replace("'","\"",$sql); //prepara la sql para guardar
//echo $sql_prev;
$rc= $conexion -> query($sql);
if($f = $rc -> fetch_array())
{


echo "<div class='notificadores_contenedor'>";

if ($f['visitada']==''){//capturar////////////////////////////

	echo "<form action='' method='post' enctype='multipart/form-data'>";
	echo "<input type='hidden' name='sql' id='sql' value='".$sql_prev."'>";

	echo "<table  width='100%' class='tabla_punteada tabla2'>";
	echo "<tr>";
		echo "<td width='45%' class='pc' bgcolor='#F7EBD1' valing='top' align='center'>";
		echo "<h3>Informacion sobre su credito:</h3>";

		echo "<br>Meses de atraso: ".round($f['mesesdeatraso'])."<br>";
		echo "<br>Ultimo pago realizado: <b>".fecha_larga($f['fecha_ultimopago'])."</b><br>";

		echo "<b class='tenue tchico'>* Calculo hecho al corte de ".$f['fecha']."</b>";
	echo "</td>";

	echo "<td width='55%' align='left' valign='top' bgcolor='#F1F1F1'>";
	echo "<h3><img src='icon/ubicame.png' class='mini_icono3'>Geolocalizacion:</h3>";
					echo "<div>";
					echo "<label>Latitud: </label>";
					echo "<input type='text' name='lat' id='lat' readonly='readonly'>";
					echo "</div>";

					echo "<div>";
					echo "<label>Longitud: </label>";
					echo "<input type='text' name='lon' id='lon' readonly='readonly'>";
					echo "</div>";

					echo "<input type='hidden' name='acu' id='acu' readonly='readonly'>";
					echo "<br>";
					echo "<div>";		
					echo "<label>Croquis de Localizacion</label>";
					echo '<img class="img_map" id="img_map" name="img_map" src="" width="600"  >';
					echo "<input type='hidden' name='croquis' id='croquis' >";
					echo "</div>";


					echo "<div>";		
					echo "<label>Foto de Satelite</label>";
					echo '<img class="img_map" id="img_map2" name="img_map2" src="" width="600"  >';
					echo "<input type='hidden' name='sat' id='sat' value='' >";
					echo "</div>";
	echo "</td>";
	echo "</tr>";

	echo "<tr>"; //*
	echo "<td class='pc' bgcolor='#FBECB5'>";

		echo "<h3>Informacion Personal:</h3>";
			echo "<br>Nacionalidad: ".$f['nacionalidad']."<br>";
			echo "<br>Lugar de Nacimiento: <b>".$f['lugar_nacimiento']."</b><br>";
			echo "<br>Fecha de Nacimiento: <b>".$f['nacimiento']."</b><br>";
	echo "</td>";
	echo "<td align='center' bgcolor='#FFECEC'>";
			echo "<div>";	

			if (($f['visita_fecha']<>'0000-00-00')){//MUESTRA LA FOTO ANTERIOR	
			echo "<label>Fotografia Anterior:</label>";	
			$archivo_foto = 'notificadores/'.$f['contrato'].'_'.$f['visita_fecha'].'_lote.jpg';			
			echo "<img src='".$archivo_foto."' class='foto_mapa'>";
			}
	
			echo "<hr><label>Fotografia Nueva:</label>";	
			echo " <output id='list'></output>";				
			echo "<input type='file' name='files' id='files' required='required'>";
			echo "</div>";
	echo "</td>";
	echo "</tr>";

	echo "<tr>";
	echo "<td class='pc' bgcolor='#F7EBD1'>";
	echo "<h3>Delegacion:</h3>";
	echo "<br>Id de delegacion: ".$f['delegacion']."<br>";
	echo "<br>Nombre de la delegacion: <b>".delegacion_id($f['delegacion'])."</b><br>";
	echo "</td>";

	echo "<td align='center' bgcolor='#DDDDDE'>";
				echo "<span>";		
					echo "<label>Beneficiario:</label>";					
					echo "<input class='tmediano normal' type='text' name='beneficiario' id='beneficiario' value='".$f['nombre']." ".$f['paterno']." ".$f['materno']."' readonly='readonly'>";
				echo "</span>";

				echo "<div>";		
					echo "<label>Contrato</label>";					
					echo "<input type='text' name='contrato' id='contrato' value='".$f['contrato']."' readonly='readonly'>";

				echo "</div>";

				echo "<div>";		
					echo "<label>Manzana y Lote</label>";					
					echo "<input type='text' name='ml' id='ml' value='".$f['manzana'].": ".$f['lote']."' readonly='readonly'>";
				echo "</div>";

				echo "<span>";		
					echo "<label>Colonia:</label>";					
					echo "<input type='text' name='col' id='col' value='".colonia_nombre($f['id_colonia'], $f['id_municipio'])."' readonly='readonly'>";
				echo "</span>";
				
	echo "</td>";
	echo "</tr>";


	echo "<tr>";
	echo "<td class='pc' bgcolor='#FBECB5'>";
	echo "<h3>Municipio:</h3>";

	echo "<br>Id de municipio: ".$f['id_municipio']."<br>";
	echo "<br> <b>".municipio_nombre($f['id_municipio'])."</b><br>";
	echo "</td>";

	echo "<td bgcolor='#ccffcc'>";
	echo "<h3><img src='icon/ver.png' class='mini_icono3'>Verificacion Visual:</h3>";

				echo "<div>";		
					echo "<label>Situacion del Lote</label>";					
					echo "<select name='cat_estado_lotes' id='cat_estado_lotes' required='required'>";
					$rtmp= $conexion -> query("select * from cat_estado_lotes");while($fcat = $rtmp -> fetch_array())
					{					
						
						if ($f['id_estado_lote']==$fcat['id']){//si el reg guardado es igual a algo del cat
							echo "<option value='".$fcat['id']."' selected='selected'>".$fcat['nombre']."</option>";
						} else {echo "<option value='".$fcat['id']."'>".$fcat['nombre']."</option>";}
					}
					

					echo "</select>";
				echo "</div>";


				echo "<div>";		
					echo "<label>Situacion de la Unidad Basica de Vivienda</label>";					
					echo "<select name='cat_estado_ubv' id='cat_estado_ubv' required='required'>";
					$rtmp= $conexion -> query("select * from cat_estado_ubv");while($fcat = $rtmp -> fetch_array())
					{					
						if ($f['id_estado_ubv']==$fcat['id']){//si el reg guardado es igual a algo del cat
							echo "<option value='".$fcat['id']."' selected='selected'>".$fcat['nombre']."</option>";
						} else {echo "<option value='".$fcat['id']."'>".$fcat['nombre']."</option>";}

						
					}
					echo "</select>";
				echo "</div>";


				echo "<div>";		
					echo "<label>¿Es un transpaso de propiedad?</label>";					
					echo "<select name='transpaso' id='transpaso' required='required'>";
					$rtmp= $conexion -> query("select * from cat_transpasos");while($fcat = $rtmp -> fetch_array())
					{					
						if ($f['transpaso']==$fcat['id']){//si el reg guardado es igual a algo del cat
							echo "<option value='".$fcat['id']."' selected='selected'>".$fcat['nombre']."</option>";
						} else {echo "<option value='".$fcat['id']."'>".$fcat['nombre']."</option>";}

						
					}
					echo "</select>";
				echo "</div>";


	echo "</td>";
	echo "</tr>";

	echo "<tr>";
	echo "<td class='pc'  bgcolor='#F7EBD1'>";
	echo "<h3>Programa:</h3>";

	echo "<br>Id de programa: ".$f['id_programa']."<br>";
	echo "<br>Nombre del programa: <b>".programa_nombre($f['id_programa'])."</b><br>";
	echo "</td>";

	echo "<td bgcolor='#E9FFE1'>";
	echo "<h3><img src='icon/update.png' class='mini_icono3'>Act. de Datos:</h3>";
		
				echo "<div>";		
					echo "<label>CURP:</label>";					
					echo "<input type='text' name='curp' id='curp' value='".$f['act_curp']."'>";
				echo "</div>";


				echo "<div>";		
					echo "<label>¿Tiene error en el nombre o en algun dato?:</label>";					
					echo "<select id='errores' name='errores'>";

					if ($f['error']=='TRUE'){//si el reg guardado es igual a algo del cat
							echo "<option value='TRUE' selected='selected'>SI</option>";
							echo "<option value='FALSE'>NO</option>";
						} else {echo "<option value='FALSE'>NO</option><option value='TRUE'>SI</option>";}
					echo "</select>";
				echo "</div>";

				echo "<input type='hidden' name='idsolicitante' id='idsolicitante' value='".$f['id_solicitante']."'>";
	echo "</td>";
	echo "</tr>";



	echo "<tr>";
	echo "<td class='pc' bgcolor='#F1F1F1'>";
	echo "</td>";

	echo "<td bgcolor='#ccffcc'>";
	echo "<h3><img src='icon/mail.png' class='mini_icono3'>Información en papel:</h3>";
				echo "<div>";		
					echo "<label>¿Se entrego la notificación?:</label>";					
					echo "<select id='entregada' name='entregada'>";
					if ($f['entregada']=='TRUE'){//si el reg guardado es igual a algo del cat
							echo "<option value='TRUE' selected='selected'>SI</option>";
							echo "<option value='FALSE'>NO</option>";
						} else {echo "<option value='FALSE' selected='selected'>NO</option><option value='TRUE'>SI</option>";}
					echo "</select>";
				echo "</div>";

				if (escritura_lista($f['contrato'])=='TRUE'){
					//echo "Esta listo para Escriturar";
					echo "<div>";		
					echo "<label>¿Se entrego invitacion para escrituracion?:</label>";					
					echo "<select id='entregada_escritura' name='entregada_escritura'>";
					if ($f['entregada_invitacionescritura']=='TRUE'){//si el reg guardado es igual a algo del cat
							echo "<option value='TRUE' selected='selected'>SI</option>";
							echo "<option value='FALSE'>NO</option>";
						} else {echo "<option value='FALSE' selected='selected'>NO</option><option value='TRUE'>SI</option>";}
					echo "</select>";
				echo "</div>";
				}

	echo "</td>";
	echo "</tr>";



	echo "<tr>";
	echo "<td class='pc' bgcolor='#F1F1F1'>";
	echo "</td>";


	echo "<td bgcolor='#E9FFE1'>";
	echo "<h3>Act. datos de contacto:</h3>";



	echo "<div>";		
		echo "<label>Telefono Movil:</label>";					
		echo "<input type='text' name='tel_movil' id='tel_movil' value='".$f['act_telefono']."'>";
	echo "</div>";


	echo "<div>";		
		echo "<label>Telefono Casa:</label>";					
		echo "<input type='text' name='tel_casa' id='tel_casa' value='".$f['act_telefono_movil']."'>";
	echo "</div>";


	echo "</td>";
	echo "</tr>";




	echo "<tr>";
	echo "<td class='pc' bgcolor='#F1F1F1'>";
	echo "</td>";

	echo "<td bgcolor='#E9FFE1'>";
	echo "<h3>Comentarios o descripcion de algun error:</h3>";
	echo "<span class='alerta tchico'>".$f['visita_comentarios']."</span>";
	echo "<textarea height='800px' name='comentarios' id='comentarios'></textarea>";
	echo "</td>";
	echo "</tr>";


	echo "<tr>";
	echo "<td class='pc' bgcolor='#F1F1F1'>";
	echo "</td>";


	echo "<td align='center' bgcolor='#E9FFE1'>";
	if ($nivel=='3'){
	echo "<input type='submit' name='submit_captura' class='Mbtn btn-default' value='Guardar Visita'>";
	} else {
		echo "Solo un usuario con nivel de operador, puede GUARDAR LA VISITA.";
	}
	echo "</td>";
	echo "</table>";
		
	echo "<input type='hidden' value='".$nitavu."' name='notificador_nitavu' id='notificador_nitavu'>";			
	echo "<input type='hidden' value='".$_GET['brig']."' name='brigada' id='brigada'>";
	echo "</form>";
} // fin captura
else { //sino visitada=''
//echo 'Mostrar capturado';
//*** permisos regresa despues de guardar *** ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////



	//echo "<form action='' method='post' enctype='multipart/form-data'>";
	echo "<input type='hidden' name='sql' id='sql' value='".$sql_prev."'>";
	
	echo "<table  width='100%' class='tabla3 tabla_punteada'>";
	echo "<tr>";
		echo "<td width='45%' class='pc' bgcolor='#F7EBD1' valing='top' align='center'>";
		echo "<h3>Informacion sobre su credito:</h3>";

		echo "<br>Meses de atraso: ".round($f['mesesdeatraso'])."<br>";
		echo "<br>Ultimo pago realizado: <b>".fecha_larga($f['fecha_ultimopago'])."</b><br>";

		echo "<b class='tenue tchico'>* Calculo hecho al corte de ".$f['fecha']."</b>";
	echo "</td>";

	echo "<td width='55%' align='left' valign='top' bgcolor='#F1F1F1'>";
	echo "<h3><img src='icon/ubicame.png' class='mini_icono3'>Geolocalizacion:</h3>";
					echo "<div>";
					echo "<label>Latitud: </label>";
					echo "<input type='text' name='lat2' id='lat2' value='".$f['visita_lat']."' readonly='readonly'>";
					echo "</div>";

					echo "<div>";
					echo "<label>Longitud: </label>";
					echo "<input type='text' name='lon2' id='lon2' value='".$f['visita_lon']."'  readonly='readonly'>";
					echo "</div>";

					echo "<input type='hidden' name='acu' id='acu' readonly='readonly' >";
				
					echo "<div style='display:inline-block;margin:10px;'>";		
					echo "<label>Croquis de Localizacion</label>";
					$archivo_croquis = 'notificadores/'.$f['contrato'].'_'.$f['visita_fecha'].'_croquis.jpg';
				 	//$archivo_croquis = 'notificadores/'.$_POST['contrato'].'_'.$fecha.'_croquis.jpg';
					//$archivo_satelite = 'notificadores/'.$_POST['contrato'].'_'.$fecha.'_satelite.jpg';

					echo '<img  id="croquis" name="croquis" src="'.$archivo_croquis.'" class="foto_mapa" >';
					echo "<input type='hidden' name='croquis' id='croquis' >";
					echo "</div>";


					echo "<div  style='display:inline-block; margin:10px;'>";		
					echo "<label>Foto de Satelite</label>";
					$archivo_satelite = 'notificadores/'.$f['contrato'].'_'.$f['visita_fecha'].'_satelite.jpg';
					echo '<img  id="mapxa" name="mapax" src="'.$archivo_satelite.'"  class="foto_mapa" >';
					echo "<input type='hidden' name='sat' id='sat' value='' >";
					echo "</div>";
	echo "</td>";
	echo "</tr>";

	echo "<tr>"; //*
	echo "<td class='pc' bgcolor='#FBECB5'>";

		echo "<h3>Informacion Personal:</h3>";
			echo "<br>Nacionalidad: ".$f['nacionalidad']."<br>";
			echo "<br>Lugar de Nacimiento: <b>".$f['lugar_nacimiento']."</b><br>";
			echo "<br>Fecha de Nacimiento: <b>".$f['nacimiento']."</b><br>";
	echo "</td>";
	echo "<td align='center' bgcolor='#FFECEC'>";
			echo "<div>";		
			echo "<label>Fotografia:</label>";	
			//echo " <output id='list'></output>";	
			$archivo_foto = 'notificadores/'.$f['contrato'].'_'.$f['visita_fecha'].'_lote.jpg';			
			echo "<img src='".$archivo_foto."' class='foto_mapa'>";
			//echo "<input type='file' name='files' id='files' required='required'>";
			echo "</div>";
	echo "</td>";
	echo "</tr>";

	echo "<tr>";
	echo "<td class='pc' bgcolor='#FFECEC'>";
	echo "<h3>Delegacion:</h3>";
	echo "<br>Id de delegacion: ".$f['delegacion']."<br>";
	echo "<br>Nombre de la delegacion: <b>".delegacion_id($f['delegacion'])."</b><br>";
	echo "</td>";

	echo "<td align='center' bgcolor='#DDDDDE'>";
				echo "<span>";		
					echo "<label>Beneficiario:</label>";					
					echo "<input class='tmediano normal' type='text' name='beneficiario' id='beneficiario' value='".$f['nombre']." ".$f['paterno']." ".$f['materno']."' readonly='readonly'>";
				echo "</span>";

				echo "<div>";		
					echo "<label>Contrato</label>";					
					echo "<input type='text' name='contrato' id='contrato' value='".$f['contrato']."' readonly='readonly'>";

				echo "</div>";

				echo "<div>";		
					echo "<label>Manzana y Lote</label>";					
					echo "<input type='text' name='ml' id='ml' value='".$f['manzana'].": ".$f['lote']."' readonly='readonly'>";
				echo "</div>";

				echo "<span>";		
					echo "<label>Colonia:</label>";					
					echo "<input type='text' name='col' id='col' value='".colonia_nombre($f['id_colonia'], $f['id_municipio'])."' readonly='readonly'>";
				echo "</span>";
				
	echo "</td>";
	echo "</tr>";


	echo "<tr>";
	echo "<td class='pc' bgcolor='#F1F1F1'>";
	echo "<h3>Municipio:</h3>";

	echo "<br>Id de municipio: ".$f['id_municipio']."<br>";
	echo "<br> <b>".municipio_nombre($f['id_municipio'])."</b><br>";
	echo "</td>";

	echo "<td bgcolor='#ccffcc'>";
	echo "<h3><img src='icon/ver.png' class='mini_icono3'>Verificacion Visual:</h3>";

				echo "<div>";		
					echo "<label>Situacion del Lote</label>";					
					echo "<select name='cat_estado_lotes' id='cat_estado_lotes'>";
					echo "<option value='".$f['id_estado_lote']."'>".id_estado_lote_nombre($f['id_estado_lote'])."</option>";
					// $rtmp= $conexion -> query("select * from cat_estado_lotes");while($fcat = $rtmp -> fetch_array())
					// {					
					// 	echo "<option value='".$fcat['id']."'>".$fcat['nombre']."</option>";
					// }
					echo "</select>";
				echo "</div>";


				echo "<div>";		
					echo "<label>Situacion de la Unidad Basica de Vivienda</label>";					
					echo "<select name='cat_estado_ubv' id='cat_estado_ubv'>";
					echo "<option value='".$f['id_estado_ubv']."'>".id_estadoubv_nombre($f['id_estado_ubv'])."</option>";
					// $rtmp= $conexion -> query("select * from cat_estado_ubv");while($fcat = $rtmp -> fetch_array())
					// {					
					// 	echo "<option value='".$fcat['id']."'>".$fcat['nombre']."</option>";
					// }
					echo "</select>";
				echo "</div>";



				echo "<div>";		
					echo "<label>¿Es un transpaso?</label>";					
					echo "<select name='cat_estado_ubv' id='cat_estado_ubv' required='required'>";
					// $rtmp= $conexion -> query("select * from cat_estado_ubv");while($fcat = $rtmp -> fetch_array())
					// {					
						// if ($f['id_estado_ubv']==$fcat['id']){//si el reg guardado es igual a algo del cat
						// 	echo "<option value='".$fcat['id']."' selected='selected'>".$fcat['nombre']."</option>";
						// } else {echo "<option value='".$fcat['id']."'>".$fcat['nombre']."</option>";}
						echo "<option value='".$f['transpaso']."' selected='selected'>".id_transpaso($f['transpaso'])."</option>";

						
					//}
					echo "</select>";
				echo "</div>";


	echo "</td>";
	echo "</tr>";

	echo "<tr>";
	echo "<td class='pc' bgcolor='#FFECEC'>";
	echo "<h3>Programa:</h3>";

	echo "<br>Id de programa: ".$f['id_programa']."<br>";
	echo "<br>Nombre del programa: <b>".programa_nombre($f['id_programa'])."</b><br>";
	echo "</td>";

	echo "<td bgcolor='#E9FFE1'>";
	echo "<h3><img src='icon/update.png' class='mini_icono3'>Act. de Datos:</h3>";
		
				echo "<div>";		
					echo "<label>CURP:</label>";					
					echo "<input type='text' name='curp' id='curp' value='".$f['curp']."' readonly='readonly'>";
				echo "</div>";


				echo "<div>";		
					echo "<label>¿Tiene error en el nombre o en algun dato?:</label>";							
					 echo "<select id='errores' name='errores'>";
					 echo "<option value='".$f['error']."'>".$f['error']."</option>";			
					// echo "<option value='FALSE' selected='selected'>NO</option>";
					// echo "<option value='TRUE'>SI</option>";
					echo "</select>";
				echo "</div>";

				echo "<input type='hidden' name='idsolicitante' id='idsolicitante' value='".$f['id_solicitante']."'>";
	echo "</td>";
	echo "</tr>";



	echo "<tr>";
	echo "<td class='pc' bgcolor='#F1F1F1'>";
	echo "</td>";

	echo "<td bgcolor='#ccffcc'>";
	echo "<h3><img src='icon/mail.png' class='mini_icono3'>Información en papel:</h3>";
				echo "<div>";		
					echo "<label>¿Se entrego la notificación?:</label>";					
					echo "<select id='entregada' name='entregada'>";
					if ($f['entregada']=='TRUE') {
						echo "<option value='".$f['entregada']."'>SI</option>";
					} else {echo "<option value='".$f['entregada']."'>NO</option>";}
					// echo "<option value='FALSE' selected='selected'>NO</option>";
					// echo "<option value='TRUE'>SI</option>";
					echo "</select>";
				echo "</div>";

				if (escritura_lista($f['contrato'])=='TRUE'){
					//echo "Esta listo para Escriturar";
					echo "<div>";		
					echo "<label>¿Se entrego invitacion para escrituracion?:</label>";					
					echo "<select id='entregada_escritura' name='entregada_escritura'>";
					if ($f['entregada_invitacionescritura']=='TRUE') {
						echo "<option value='".$f['entregada_invitacionescritura']."'>SI</option>";
					} else {echo "<option value='".$f['entregada_invitacionescritura']."'>NO</option>";}
					
					// echo "<option value='FALSE' selected='selected'>NO</option>";
					// echo "<option value='TRUE'>SI</option>";
					echo "</select>";
				echo "</div>";
				}

	echo "</td>";
	echo "</tr>";



	echo "<tr>";
	echo "<td class='pc' bgcolor='#F1F1F1'>";
	echo "</td>";


	echo "<td bgcolor='#E9FFE1'>";
	// echo "<h3>Act. datos de contacto:</h3>";



	// echo "<div>";		
	// 	echo "<label>Telefono Movil:</label>";					
	// 	echo "<input type='text' name='tel_movil' id='tel_movil' value=''>";
	// echo "</div>";


	// echo "<div>";		
	// 	echo "<label>Telefono Casa:</label>";					
	// 	echo "<input type='text' name='tel_casa' id='tel_casa' value=''>";
	// echo "</div>";


	// echo "</td>";
	echo "</tr>";




	echo "<tr>";
	echo "<td class='pc' bgcolor='#F1F1F1'>";
	echo "Capturado el ".fecha_larga($f['visita_fecha'])." a las ".$f['visita_hora']." por ".nitavu_nombre($f['notificador_nitavu'])."";
	echo "</td>";

	echo "<td bgcolor='#E9FFE1'>";
	echo "<h3>Comentarios o descripcion de algun error:</h3>";
	echo "<b>".$f['visita_comentarios']."</b>";	


	if ($nivel=='2' or $nivel=='1') { //SI ES ADMINISTRADOR
		echo "<form action='' method='POST'>";
		echo "<input type='hidden' name='comentarios_old' value='".$f['visita_comentarios']."'>";
		echo "<textarea height='800px' name='comentarios' id='comentarios'><br><br><br></textarea>";
		echo "<br>";
		echo "<input type='submit' name='submit_recaptura' class='Mbtn btn-cancel' value='Recapturar y Comentar Visita'>";	
		echo "</form>";

		echo "<br>";
		if ($f['vobo']==''){
		echo "<form action='' method='POST'>";
		echo "<input type='submit' name='submit_vobo' class='Mbtn btn-default' value='Vo.Bo'>";	
		echo "</form>";
		}



	}

	echo "</td>";
	echo "</tr>";


	echo "<tr>";
	echo "<td class='pc' bgcolor='#F1F1F1'>";
	echo "</td>";


	echo "<td align='center' bgcolor='#E9FFE1'>";



	
	echo "</td>";
	echo "</table>";
		
	echo "<input type='hidden' value='".$nitavu."' name='notificador_nitavu' id='notificador_nitavu'>";			
	echo "<input type='hidden' value='".$_GET['brig']."' name='brigada' id='brigada'>";
	//echo "</form>";






















































if ($nivel=='3'){
	//echo "<h1>No cuenta con permiso para</h1>";
	//** bloquear el boton para recaptura, solo lectura
}




}



echo "</div>";




///////////////////////////////////////////////////\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\
//               guardar 
if (isset($_POST['submit_captura'])){
echo "listo para guardar";
//echo $_POST['sql'];
//$url_actual= 'notificadores_visita2.php?brig='.$_GET['brig'].'&col='.$_GET['col']."&mun=".$_GET['mun']."&m=".$_GET['m']."&l=".$_GET['l'];

//actual menos el lote para que aparezca la lista de lote de esa manzana
$url_actual= 'notificadores_visita2.php?brig='.$_GET['brig'].'&col='.$_GET['col']."&mun=".$_GET['mun']."&m=".$_GET['m'];
//mensaje("probando",$url_actual);

	if (isset($_POST['croquis']) and isset($_POST['sat'])){
 	$croquis_url = $_POST['croquis'];
 	$satelite_url = $_POST['sat'];

	$archivo = 'notificadores/'.$_POST['contrato'].'_'.$fecha.'_lote';
 	$archivo_croquis = 'notificadores/'.$_POST['contrato'].'_'.$fecha.'_croquis.jpg';
	$archivo_satelite = 'notificadores/'.$_POST['contrato'].'_'.$fecha.'_satelite.jpg';

    $time = time();
    file_put_contents($archivo_croquis,file_get_contents($croquis_url));
    file_put_contents($archivo_satelite,file_get_contents($satelite_url));
	}

	$subida= subir2('files', $archivo, 'jpg'); //si no devuelve nada, se subio 

	if ($subida==''){// si se subio la foto comenzamos a guardar
		if ($_POST['curp']<>''){//ACTUALIZAR LOS BENEFICIARIOS

		
		} 
		$sql_update="
		UPDATE 
			notificadores_visitas
		SET 
			visitada='TRUE', notificador_nitavu='".$nitavu."', visita_fecha='".$fecha."', visita_hora='".$hora."',
			visita_lat='".$_POST['lat']."', visita_lon='".$_POST['lon']."', visita_acu='".$_POST['acu']."', visita_comentarios='Notificador ".$nitavu.": ".$_POST['comentarios']."<br>',
			entregada='".$_POST['entregada']."', id_estado_lote='".$_POST['cat_estado_lotes']."', id_estado_ubv='".$_POST['cat_estado_ubv']."', curp='".$_POST['curp']."',
			error='".$_POST['errores']."', act_telefono='".$_POST['tel_casa']."', act_telefono_movil='".$_POST['tel_movil']."', vobo='', entregada_invitacionescritura='".$_POST['entregada_escritura']."', transpaso='".$_POST['transpaso']."'

		WHERE (contrato='".$_POST['contrato']."' and visitada='' and brigada_id='".$_GET['brig']."')";
		//$r_up = $conexion -> query($sql_update);	
		if ($conexion->query($sql_update) == TRUE)
		{ mensaje("Guardado correctamente",$url_actual);}
		else {
			historia($nitavu, "<b class='alerta'>ERROR</b>:Marco error al guardar notificacion (".$sql_update.")");

				////// NOTIFICA AL DPTO DE INFORMATICA SOBRE EL ERROR
				$r2up = $conexion -> query("select * from empleados where dpto='55'"); while($a = $r2up -> fetch_array())
				{notifica ($a['nitavu'], "ERROR al notificar ".$_POST['contrato'], $fecha, $nitavu, "Error al guardar una notificacion ".$sql_update);}

			
			mensaje("ERROR AL GUARDAR; se ha informado al dpto de informatica ".$sql_update,$url_actual);
		}






	}





}


} else {  mensaje("Ha habido un error: ".$sql, ''); }





if (isset($_POST['submit_recaptura'])){
$url_actual= 'notificadores_visita2.php?brig='.$_GET['brig'].'&col='.$_GET['col']."&mun=".$_GET['mun']."&m=".$_GET['m'];
		$sql_update="
		UPDATE 
			notificadores_visitas
		SET 
			visitada='', visita_comentarios= '".$_POST['comentarios_old']."<br> <br> Administrador ".$nitavu.": ".$_POST['comentarios']."<br>', vobo=''
		WHERE (contrato='".$f['contrato']."'  and brigada_id='".$_GET['brig']."')";
		//echo $sql_update;
		//$r_up = $conexionmigra -> query($sql_update);	
		if ($conexion->query($sql_update) == TRUE)
		{
				historia($nitavu, "Creo recaptura de L".$_GET['l'].", M".$_GET['m']." de la Col ".colonia_nombre($_GET['col'], $_GET['mun'])." de ".municipio_nombre($_GET['mun']));
				mensaje("Guardado correctamente (admin)",$url_actual);

		}
		else {
			historia($nitavu, "<b class='alerta'>ERROR</b>:Marco error al guardar notificacion (".$sql_update.")");

				////// NOTIFICA AL DPTO DE INFORMATICA SOBRE EL ERROR
				$r2up = $conexion -> query("select * from empleados where dpto='55'"); while($a = $r2up -> fetch_array())
				{notifica ($a['nitavu'], "ERROR al notificar ".$_POST['contrato'], $fecha, $nitavu, "Error al guardar una notificacion ".$sql_update);}

			
			mensaje("ERROR AL GUARDAR; se ha informado al dpto de informatica ".$sql_update,$url_actual);
		}
}




if (isset($_POST['submit_vobo'])){
$url_actual= 'notificadores_visita2.php?brig='.$_GET['brig'].'&col='.$_GET['col']."&mun=".$_GET['mun']."&m=".$_GET['m'];
		$sql_update="
		UPDATE 
			notificadores_visitas
		SET 
			vobo='".$nitavu."'
		WHERE (contrato='".$f['contrato']."'  and brigada_id='".$_GET['brig']."')";
		//echo $sql_update;
		//$r_up = $conexionmigra -> query($sql_update);	
		if ($conexion->query($sql_update) == TRUE)
		{ mensaje("Guardado correctamente (admin)",$url_actual);}
		else {
			historia($nitavu, "<b class='alerta'>ERROR</b>:Marco error al guardar notificacion (".$sql_update.")");

				////// NOTIFICA AL DPTO DE INFORMATICA SOBRE EL ERROR
				$r2up = $conexion -> query("select * from empleados where dpto='55'"); while($a = $r2up -> fetch_array())
				{notifica ($a['nitavu'], "ERROR al notificar ".$_POST['contrato'], $fecha, $nitavu, "Error al guardar una notificacion ".$sql_update);}

			
			mensaje("ERROR AL GUARDAR; se ha informado al dpto de informatica ".$sql_update,$url_actual);
		}
}







} else {

			if (isset($_GET['busqueda'])){//si hay una busqueda cambiar el sql
					$busqueda = $_GET['busqueda'];
					if ($busqueda == 'VoBo'){
						if ($nivel=='2') {
							$id_delegacion = midelegacion_id($nitavu);
							$sql = "
							SELECT
								*
							FROM
								notificadores_visitas
							WHERE
								visitada<>''
								AND vobo=''
								AND delegacion='".$id_delegacion."'

							ORDER by lote
							";

							}

						if ($nivel=='1') {
							$sql="SELECT
							*
							FROM
								notificadores_visitas
							WHERE
								visitada<>''
								AND vobo=''
							order by lote
							";
						}


						

					} else {
					$sql= "
					SELECT
					* from notificadores_visitas
					WHERE
					nombre like'%$busqueda%' OR
					paterno like'%$busqueda%' OR
					materno like'%$busqueda%' OR
					contrato like'%$busqueda%' OR
					colonia like'%$busqueda%' OR
					visita_comentarios like'%$busqueda%' OR
					curp like'%$busqueda%' OR
					manzana like'%$busqueda%' OR
					lote like'%$busqueda%' 
					



					";
					}
				//echo $sql;
				echo "<H1>LISTA DE LOTES de <b class='ejecutandose'>".$_GET['busqueda']."</b>:</H1>";
				echo "<table class='tabla' width='100%'>";
				echo "<th width='10px' class='pc'>"."Brig"."</th>";
				echo "<th>"."M"."</th>";
				echo "<th>"."L"."</th>";
				echo "<th class='pc'>Col.</th>";
				echo "<th class='pc'>Mun.</th>";

				echo "<th width='50%'>"."Beneficiario"."</th>";
				echo "<th width='100px'>".""."</th>";
				
				
					$r2 = $conexion -> query($sql); while($f = $r2 -> fetch_array())
					{
						if (escritura_lista($f['contrato'])=='TRUE'){
						echo "<tr class='ejecutandose'>";
					}
					else
					{
						if ($f['curp']=='' or $f['curp']=='NULL'){
						echo "<tr class='alerta'>";
						} else {echo "<tr>";}
					}
						echo "<td class='pc'>".$f['brigada_id']."</td>";
						echo "<td>".$f['manzana']."</td>";
						echo "<td>".$f['lote']."</td>";
						echo "<td class='pc'>".colonia_nombre($f['id_colonia'],$f['id_municipio'])."</td>";
						echo "<td class='pc'>".municipio_nombre($f['id_municipio'])."</td>";

						echo "<td><b>".$f['nombre']."</b> ".$f['paterno']." ".$f['materno']."</td>";
						echo "<td>";

						if ($f['visitada']<>''){
						echo "<a href='notificadores_visita2.php?brig=".$_GET['brig']."&col=".$f['id_colonia']."&mun=".$f['id_municipio']."&m=".$f['manzana']."						
						&l=".$f['lote']."' class='Mbtn btn-secundario'>Vo.Bo </a>";
						} else {
						echo "<a href='notificadores_visita2.php?brig=".$_GET['brig']."&col=".$f['id_colonia']."&mun=".$f['id_municipio']."&m=".$f['manzana']."						
						&l=".$f['lote']."' class='Mbtn btn-default'>Verificar </a>";
						
						}

						

						echo "</td>";								
						echo "</tr>";


					


					}

				echo "</table>";
				echo "<br><br>";
				echo "<b class='ejecutandose tchico'>* Candidatos a Escrituracion</b> <b class='alerta tchico'> * Falta dato de CURP </b>";






		
			} else {


			// CREA MENU DE MANZANAS Y LOTES
			
			if (isset($_GET['col'])){
					// //echo $sqlm;	e
					//echo $nivel;			
					echo "<b class='normal'>".colonia_nombre($_GET['col'], $_GET['mun'])."</b>";


					if ($nivel==1) { //SuperAdmin, ve todo sin captura, solo puede marcarlo y comentar									
						$sqlm="
						SELECT DISTINCT
							manzana,
							colonia,
							id_colonia,
							id_municipio, delegacion
						FROM
							notificadores_visitas
						WHERE
							id_colonia = '".$_GET['col']."'
						AND id_municipio = '".$_GET['mun']."'
						and visitada=''

						ORDER BY
							manzana ASC
							";
					}


					if ($nivel==3 or $nivel==2) { // solo puede ver las de su delegacion Operador y Admin										
						$sqlm="
						SELECT DISTINCT
							manzana,
							colonia,
							id_colonia,
							id_municipio, delegacion
						FROM
							notificadores_visitas
						WHERE
							id_colonia = '".$_GET['col']."'
						AND id_municipio = '".$_GET['mun']."'
						AND delegacion = '".midelegacion_id($nitavu)."'
						ORDER BY
							manzana ASC
							";
					}


					//echo "<b>".$sqlm."</b><hr>";

						$rm = $conexion -> query($sqlm);	
						echo "<div id='manzanas'><label>Manzanas:</label>";						
						while($m = $rm -> fetch_array())
						{

							if (isset($_GET['m']))
							{
								if ($_GET['m']==$m['manzana']){//seleccionada
										echo "<a class='manzana_seleccionada' href='notificadores_visita2.php?brig=".$_GET['brig']."&m=".$m['manzana']."&col=".$m['id_colonia']."&mun=".$_GET['mun']."'>".$m['manzana']."</a>";

								} 
								else
								{
										echo "<a href='notificadores_visita2.php?brig=".$_GET['brig']."&m=".$m['manzana']."&col=".$m['id_colonia']."&mun=".$_GET['mun']."'>".$m['manzana']."</a>";
								}

							} else {
										echo "<a href='notificadores_visita2.php?brig=".$_GET['brig']."&m=".$m['manzana']."&col=".$m['id_colonia']."&mun=".$_GET['mun']."'>".$m['manzana']."</a>";
								

							}
						
							
					 	}
					 	echo "</div>";



			} else {

				
					if ($nivel=='3') { // solo puede ver las de su delegacion Operador y Admin										
						$sqlmc="SELECT DISTINCT
						colonia, id_colonia, id_municipio
						FROM
						notificadores_visitas
						WHERE
						visitada = ''
						and delegacion='".midelegacion_id($nitavu)."'
						order by lote
						";
					}

				if ($nivel=='2') { // solo puede ver las de su delegacion Operador y Admin										
						$sqlmc="SELECT DISTINCT
						colonia, id_colonia, id_municipio
						FROM
						notificadores_visitas
						WHERE
						delegacion='".midelegacion_id($nitavu)."' order by lote
						";
					}

					if ($nivel=='1') { // sUPER adMIN PUEDE VER TODO,										
						$sqlmc="SELECT DISTINCT
						colonia, id_colonia, id_municipio
						FROM
						notificadores_visitas
						order by lote
						";
					}

					//echo "m".$sqlmc;
					echo "<label class='normal'>Colonias con actividad de notificacion:</label>";
					$rmc = $conexion -> query($sqlmc);	while($mc = $rmc -> fetch_array())
					{
					$avance=notificadores_colonia_avance($mc['id_colonia']);
				if ($avance==100){
					echo "<div id='colonias' 
					style='   
					background: url(../img/wall2.png);   
					background-size: ".$avance."%, 10%;
    				background-repeat: no-repeat;
    				background-color: white;
    				border: 1px solid #ABF574;
    				color: white;
    				'
    				>";
    			} else {
    				echo "<div id='colonias' 
					style='   
					background: url(../img/wall.png);   
					background-size: ".$avance."%, 100%;
    				background-repeat: no-repeat;
    				background-color: white;
    				border: 1px solid #ABF574;
    				'
    				>";
    			}
					//echo "<div id='barra_act' style='width:30%;'></div>";

					echo "<a href='?brig=&col=".$mc['id_colonia']."&mun=".$mc['id_municipio']."'>";
					echo "".$mc['colonia']."</b>, ".municipio_nombre($mc['id_municipio']);
					//echo " <span class='tchico tenue'> id=".$mc['id_colonia'].".".$mc['id_municipio'].",</span>";
					echo "</a>";
					$faltan= notificadores_colonia_faltan($mc['id_colonia']);

					if (($faltan> 0) and ($avance <> 0))

						{
							echo "<b class='ejecutandose' title='$faltan'> ".number_format($avance, 2, '.', '')."%</b>";	
						}

					echo  "</div>";				
					}

			
			}


			if  (	isset($_GET['mun']) and 
					isset($_GET['col']) and 
					  isset($_GET['m']) and 
				   isset($_GET['brig']) 
				)
			{////////////////////////////////////\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\ 

				echo "<H1>LISTA DE LOTES:</H1>"; /////
				echo "<table class='tabla' width='100%'>";
				echo "<th width='10px' class='pc'>"."Brig"."</th>";
				echo "<th>"."M"."</th>";
				echo "<th>"."L"."</th>";
				echo "<th width='50%'>"."Beneficiario"."</th>";
				echo "<th width='20px'>".""."</th>";

				if ($nivel=='3') { // solo puede ver las de su delegacion Operador y Admin		
				$sql = "
				SELECT 		manzana, lote,
							colonia,
							id_colonia, contrato,
							id_municipio, delegacion, brigada_id, nombre, paterno, materno, visitada, curp
						FROM
							notificadores_visitas
						WHERE
							id_colonia = '".$_GET['col']."'
						AND id_municipio = '".$_GET['mun']."'
						AND manzana = '".$_GET['m']."'
						AND visitada=''
						AND vobo=''

						ORDER BY
							lote ASC
				";
				}

				if ($nivel=='2' or $nivel=='1') { //	
				$sql = "
				SELECT 		manzana, lote,
							colonia,
							id_colonia, contrato,
							id_municipio, delegacion, brigada_id, nombre, paterno, materno, visitada, curp
						FROM
							notificadores_visitas
						WHERE
							id_colonia = '".$_GET['col']."'
						AND id_municipio = '".$_GET['mun']."'
						AND manzana = '".$_GET['m']."'
						
						ORDER BY
							lote ASC
				";
				}


				//echo $sql;
					$r2 = $conexion -> query($sql); while($f = $r2 -> fetch_array())
					{
						if (escritura_lista($f['contrato'])=='TRUE'){
						echo "<tr class='ejecutandose'>";
					}
					else
					{
						if ($f['curp']=='' or $f['curp']=='NULL'){
						echo "<tr class='alerta'>";
						} else {echo "<tr>";}
					}
						echo "<td class='pc'>".$f['brigada_id']."</td>";
						echo "<td>".$f['manzana']."</td>";
						echo "<td>".$f['lote']."</td>";
						echo "<td><b>".$f['nombre']."</b> ".$f['paterno']." ".$f['materno']."</td>";
						echo "<td>";

						if ($f['visitada']<>''){
						echo "<a href='notificadores_visita2.php?brig=".$_GET['brig']."&col=".$f['id_colonia']."&mun=".$f['id_municipio']."&m=".$f['manzana']."						
						&l=".$f['lote']."' class='Mbtn btn-secundario'>Vo.Bo </a>";
						} else {
						echo "<a href='notificadores_visita2.php?brig=".$_GET['brig']."&col=".$f['id_colonia']."&mun=".$f['id_municipio']."&m=".$f['manzana']."						
						&l=".$f['lote']."' class='Mbtn btn-default'>Verificar </a>";
						
						}
						

						echo "</td>";								
						echo "</tr>";


					


					}

				echo "</table>";
				echo "<br><br>";
				echo "<b class='ejecutandose tchico'>* Candidatos a Escrituracion</b> <b class='alerta tchico'> * Falta dato de CURP </b>";



			}



		}


			



	}
}// fin l
else
{
	mensaje("no tiene permiso para usar esta aplicacion",'');
}

?>




    <script type="text/javascript" src="https://maps.google.com/maps/api/js?sensor=true"></script>
    <script type="text/javascript">
    function initialize() {
       var marcadores = [
 		<?php 
 		//echo $info;

 		?>      

       ];


      var map = new google.maps.Map(document.getElementById('mapa'), {
        zoom: 10,

        center: new google.maps.LatLng(23.7428613,-99.152534),	
        mapTypeId: google.maps.MapTypeId.ROADMAP
      });

      var infowindow = new google.maps.InfoWindow();
      var marker, i;
      for (i = 0; i < marcadores.length; i++) {  
        marker = new google.maps.Marker({
          position: new google.maps.LatLng(marcadores[i][1], marcadores[i][2]),
          map: map
        });
        google.maps.event.addListener(marker, 'click', (function(marker, i) {
          return function() {
            infowindow.setContent(marcadores[i][0]);
            infowindow.open(map, marker);
          }
        })(marker, i));
      }
    }
    google.maps.event.addDomListener(window, 'load', initialize);
    </script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDFrRZEYqnAuGMggPnDdD2qEm-bOpDdoNA&callback=initMap"
    async defer></script>





<script type="text/javascript">
function pedirPosicion(pos) { 
   //document.write("¡Hola! Estas en : "+pos.coords.latitude+ ","+pos.coords.longitude); 
   //document.write(" Rango de localización de +/- "+pos.coords.accuracy+" metros"); 


  //escribe los valores en los input id
  document.getElementById('lat').value  =  pos.coords.latitude; 
   document.getElementById('lon').value  =  pos.coords.longitude;
   document.getElementById('acu').value  =  pos.coords.accuracy;

//https://maps.googleapis.com/maps/api/staticmap?maptype=satellite&center=37.530101,38.600062&zoom=14&size=640x400&key=YOUR_API_KEY

var url = "https://maps.googleapis.com/maps/api/staticmap?autoscale=1&size=400x400&maptype=roadmap&format=jpg&visual_refresh=true&markers=size:mid%7Ccolor:0xff0000%7Clabel:1%7C";
var url2 = "https://maps.googleapis.com/maps/api/staticmap?maptype=satellite&zoom=20&autoscale=1&size=400x400&maptype=roadmap&format=jpg&visual_refresh=true&markers=size:mid%7Ccolor:0xff0000%7Clabel:1%7C";

//var url = "maps.google.com";
var lat = pos.coords.latitude; 
var lon =  ",+"+pos.coords.longitude;
var key = "&key="+"AIzaSyCc2fdtBRrEiHBG4mEAIrFZ6kUrFbw3VL8";
var url_final = url.concat(lat, lon,key);
var url_final2 = url2.concat(lat, lon,key);

//alert(url_final);

//document.getElementById('img_map').src = "hola";
document.getElementById('img_map').src=url_final;
document.getElementById('img_map2').src=url_final2;
document.getElementById('croquis').value=url_final;
document.getElementById('sat').value  =  url_final2; 

//document.getElementById('a_img_map').href = url_final;
      
}

if (navigator.geolocation) {
      navigator.geolocation.getCurrentPosition(pedirPosicion,showError);
} 

function showError(error){
//alert(error.code);
  switch(error.code) {
    case error.PERMISSION_DENIED:
      geo_label.innerHTML+="No has otorgado el permiso para Geolocalizacion";
      document.getElementById('acu').value  = "No has otorgado el permiso para Geolocalizacion";

      break;
    case error.POSITION_UNAVAILABLE:
      geo_label.innerHTML+="La información de la localización no está disponible.";
        document.getElementById('acu').value  = "La información de la localización no está disponible.";
      break;
    case error.TIMEOUT:
      geo_label.innerHTML+="El tiempo de espera para buscar la localización ha expirado.";
      document.getElementById('acu').value  = "El tiempo de espera para buscar la localización ha expirado.";
      break;
    case error.UNKNOWN_ERROR:
      geo_label.innerHTML+="Ha ocurrido un error desconocido.";
      document.getElementById('acu').value  ="Ha ocurrido un error desconocido.";
      break;
    }   
}
</script>

 <script>
		  function archivo(evt) {
			var files = evt.target.files; // FileList object
		
			// Obtenemos la imagen del campo "file".
			for (var i = 0, f; f = files[i]; i++) {
			  //Solo admitimos imágenes.
			  if (!f.type.match('image.*')) {
				continue;
			  }
		
			  var reader = new FileReader();
		
			  reader.onload = (function(theFile) {
				return function(e) {
				  // Insertamos la imagen
				 document.getElementById("list").innerHTML = ['<img class="thumb" src="', e.target.result,'" title="', escape(theFile.name), '"/>'].join('');
				};
			  })(f);
		
			  reader.readAsDataURL(f);
			}
		  }
		
		  document.getElementById('files').addEventListener('change', archivo, false);
		</script>
    


			
			<br><br><br><br><br><br><br><br><br><br><br><br><br><br>
<?php
include ("./lib/body_footer.php");
?>