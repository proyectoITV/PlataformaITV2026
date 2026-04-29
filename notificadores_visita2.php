<?php
//include (".//seguridad.php"); 
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
//$nivel =3;
echo "<h5 class='pc'>".app_detalle($id_aplicacion, $nitavu)."</div>";
echo nivel_detalle($nivel,'');
if (sanpedro($id_aplicacion, $nitavu)==TRUE){
		// lista de notificaciones disponibles
		//historia($nitavu,'Consultando notificaciones');

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
			if (isset($_GET['brig'])){
				$url = $url.'brig='.$_GET['brig'];
			} else {$url = $url.'brig=';}
			


			if (isset($_GET['col'])){$url = $url.'&col='.$_GET['col'];}
			if (isset($_GET['mun'])){$url = $url.'&mun='.$_GET['mun'];}
			if (isset($_GET['m'])){$url = $url.'&m='.$_GET['m'];}
			
			buscar($url,"BUSCAR nombre, contrato, manzana, lote...",'');
			echo "<span class='tchico tenue'>".midelegacion($nitavu)."</span>";
			echo "</td>";

			
			echo "<td class='tenue tchico' width='10%'>Notificaciones <br>por entregar: <br>";
				$notis = notificadores_pendientes($nitavu, '');
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
	echo "<input type='hidden' name='datos_g' id='datos_g' value='FALSE'>";
	echo "<table  width='100%' class='tabla_punteada tabla2'>";
	echo "<tr>";
		echo "<td width='45%' class='pc' bgcolor='#F7EBD1' valing='top' align='center'>";
		echo "<h3>Informacion sobre su credito:</h3>";

		//echo "<br>Meses de atraso: ".round($f['mesesdeatraso'])."<br>";
		echo "<br>Ultimo pago realizado: <b>".fecha_larga($f['fecha_ultimopago'])."</b><br>";

		echo "<b class='tenue tchico'>* Calculo hecho al corte de ".$f['fecha']."</b>";
	echo "</td>";

	echo "<td width='55%' align='left' valign='top' bgcolor='#F1F1F1'>";
	echo "<h3><img src='icon/ubicame.png' class='mini_icono3'>Geolocalizacion:</h3>";

			if (($f['visita_fecha']<>'0000-00-00')){//SI YA TENIA UNA VISITA	
					echo "<div style='border: 2px red solid; height:100px; border-radius:10px; padding:5px;'>";
					echo "<label><b>¿Utilizar informacion Guardada?</b> (";
					echo "Croquis, Satelite y fotografia y opcional de la visita anterior del ".$f['visita_fecha']."): </label>";
					echo "<select id='datos_g' name='datos_g'>";
					echo "<option value='TRUE'>SI</option>";
					echo "<option value='FALSE'>NO</option>";
					echo "</select>";
					echo "</div>";

					echo "<div>";
					echo "<label>Latitud: (Guardada: ".$f['visita_lat'].") </label>";
					echo "<input type='text' name='lat' id='lat' readonly='readonly'>";
					echo "</div>";

					echo "<div>";
					echo "<label>Longitud: (Guardada: ".$f['visita_lon'].")</label>";
					echo "<input type='text' name='lon' id='lon' readonly='readonly'>";
					echo "</div>";

					echo "<input type='hidden' name='acu' id='acu' readonly='readonly'>";
					echo "<br>";
					echo "<div>";	


					echo "<div style='display:inline-block;margin:10px;'>";		
					echo "<label>Croquis de Localizacion Guardado:</label>";
					$archivo_croquis = 'notificadores/'.$f['contrato'].'_'.$f['visita_fecha'].'_croquis.jpg';
					echo '<img  id="croquis" name="croquis" src="'.$archivo_croquis.'" class="foto_mapa" >';

					echo "<hr><label>Croquis de Localizacion actual:</label>";
					echo '<img class="img_map" id="img_map" name="img_map" src="" width="600"  >';
					echo "<input type='hidden' name='croquis' id='croquis' >";
					echo "</div>";


					echo "<div  style='display:inline-block; margin:10px;'>";		
					echo "<label>Foto de Satelite Guardada</label>";
					$archivo_satelite = 'notificadores/'.$f['contrato'].'_'.$f['visita_fecha'].'_satelite.jpg';
					echo '<img  id="mapxa" name="mapax" src="'.$archivo_satelite.'"  class="foto_mapa" >';
					echo "<hr><label>Foto de Satelite Actual</label>";
					echo '<img class="img_map" id="img_map2" name="img_map2" src="" width="600"  >';
					echo "<input type='hidden' name='sat' id='sat' value='' >";
					echo "</div>";



			


			} else
			{// SI ES NUEVO
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

				

			}

	
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

				echo "<hr><label>* Fotografia Nueva de ser necesaria:</label>";	
				echo " <output id='list'></output>";				
				echo "<input type='file' name='files' id='files' >";
				echo "</div>";

				echo "<hr><div  style='display:inline-block; margin:10px;'>";		
					$archivo_op = 'notificadores/'.$f['contrato'].'_'.$f['visita_fecha'].'_op.jpg';
					if (file_exists($archivo_op)){
						echo "<label>Foto Opcional (guardada)</label>";					
						echo '<img  src="'.$archivo_op.'"  class="foto_mapa" >';
					}

					echo "<hr><label>Fotografia opcional<br>

					<span class='normal'> Puede utilizarla para observaciones e irregularidades; no olvide describir la situacion en las observaciones<span></label>";
					echo " <output id='list2'></output>";				
					//echo '<img class="img_map" id="img_map2" name="img_map2" src="" width="600"  >';
					echo "<input type='file' name='foto_op' id='foto_op' value='' >";
					echo "</div>";


			} else
			{
				echo "<label>Fotografia:</label>";	
				echo " <output id='list'></output>";				
				echo "<input type='file' name='files' id='files' required='required'>";
				echo "</div>";

						
					echo "<hr><div  style='display:inline-block; margin:10px;'>";		
					$archivo_op = 'notificadores/'.$f['contrato'].'_'.$f['visita_fecha'].'_op.jpg';
					if (file_exists($archivo_op)){
						echo "<label>Foto Opcional (guardada)</label>";					
						echo '<img  src="'.$archivo_op.'"  class="foto_mapa" >';
					}

					echo "<hr><label>Fotografia opcional<br>

					<span class='normal'> Puede utilizarla para observaciones e irregularidades; no olvide describir la situacion en las observaciones<span></label>";
					echo " <output id='list2'></output>";				
					//echo '<img class="img_map" id="img_map2" name="img_map2" src="" width="600"  >';
					echo "<input type='file' name='foto_op' id='foto_op' value='' >";
					echo "</div>";
			}
	

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
					echo "<label><b>¿Tiene error en los datos? o ¿Hay alguna irregularidad?</b>:</label>";					
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
				} else {echo "<input type='hidden' name='entregada_escritura' id='entregada_escritura' value=''>";}

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
	echo "<input type='hidden' name='comentarios_old' value='".$f['visita_comentarios']."'>";

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

		//echo "<br>Meses de atraso: ".round($f['mesesdeatraso'])."<br>";
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
					echo "<label>Croquis de Localizacion ".$f['visita_fecha']."</label>";
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
			echo "<hr>";
			echo "<label>Fotografia Opcional</label>";
			$archivo_op = 'notificadores/'.$f['contrato'].'_'.$f['visita_fecha'].'_op.jpg';			
			echo "<img src='".$archivo_op."' class='foto_mapa'>";
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
					echo "<label><b>¿Tiene error en los datos? o ¿Hay alguna irregularidad?</b>:</label>";					
					 echo "<select id='errores' name='errores'>";
					 if ($f['error']=='TRUE'){
					 	echo "<option value='".$f['error']."'>SI</option>";			
					 } else {echo "<option value='".$f['error']."'>NO</option>";			}
					 
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
	if ($f['vobo']==''){
		echo "<br>Aun no se dar el Vo.bo. por parte de la delegacion.";
	}
	else
	{
		echo "<br>Dio el Vo.Bo. <b>".nitavu_nombre($f['vobo'])."</b><br>";
	}
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
		echo "<input type='hidden' name='comentarios_old' value='".$f['visita_comentarios']."'>";		
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
//               GUARDANDO 
if (isset($_POST['submit_captura'])){
//echo "listo para guardar";
//echo $_POST['sql'];
//$url_actual= 'notificadores_visita2.php?brig='.$_GET['brig'].'&col='.$_GET['col']."&mun=".$_GET['mun']."&m=".$_GET['m']."&l=".$_GET['l'];

//actual menos el lote para que aparezca la lista de lote de esa manzana
$url_actual= 'notificadores_visita2.php?brig='.$_GET['brig'].'&col='.$_GET['col']."&mun=".$_GET['mun']."&m=".$_GET['m'];
//mensaje("probando",$url_actual);

	if (isset($_POST['croquis']) and isset($_POST['sat'])){
 	$croquis_url = $_POST['croquis'];
 	$satelite_url = $_POST['sat'];

	$archivo = 'notificadores/'.$_POST['contrato'].'_'.$fecha.'_lote';
	$archivo_op = 'notificadores/'.$_POST['contrato'].'_'.$fecha.'_op';
 	$archivo_croquis = 'notificadores/'.$_POST['contrato'].'_'.$fecha.'_croquis.jpg';
	$archivo_satelite = 'notificadores/'.$_POST['contrato'].'_'.$fecha.'_satelite.jpg';
	$subida='i'; $subida_op='i';
    $time = time();
    	if ($_POST['datos_g']=='FALSE'){//si selecciona no utilizar los datos guardados
    		file_put_contents($archivo_croquis,file_get_contents($croquis_url));
    		file_put_contents($archivo_satelite,file_get_contents($satelite_url));
    		$subida= subir2('files', $archivo, 'jpg'); //si no devuelve nada, se subio 
    		$subida_op= subir2('foto_op', $archivo_op, 'jpg'); //si no devuelve nada, se subio 
    	}
	}

	$errores = $_POST['errores'];
	if ($subida_op==''){
		$errores = 'TRUE';
	}
	

	if ($subida==''){// si se subio la foto comenzamos a guardar
		if ($_POST['curp']<>''){//ACTUALIZAR LOS BENEFICIARIOS

		
		} 
		$sql_update="
		UPDATE 
			notificadores_visitas
		SET 
			visitada='TRUE', notificador_nitavu='".$nitavu."', visita_fecha='".$fecha."', visita_hora='".$hora."',
			visita_lat='".$_POST['lat']."', visita_lon='".$_POST['lon']."', visita_acu='".$_POST['acu']."', visita_comentarios='".
			$_POST['comentarios_old']."<br> 
			".$fecha.":".$hora." | <b class=tenue>Notificador (".$nitavu.")</b><b class=normal> ".nitavu_nombre($nitavu)."</b>: "

			.$_POST['comentarios']."<br>',
			entregada='".$_POST['entregada']."', id_estado_lote='".$_POST['cat_estado_lotes']."', id_estado_ubv='".$_POST['cat_estado_ubv']."', curp='".$_POST['curp']."',
			error='".$errores."', act_telefono='".$_POST['tel_casa']."', act_telefono_movil='".$_POST['tel_movil']."', vobo='', entregada_invitacionescritura='".$_POST['entregada_escritura']."', transpaso='".$_POST['transpaso']."'

		WHERE (contrato='".$_POST['contrato']."' and brigada_id='".$_GET['brig']."')";
		//$r_up = $conexion -> query($sql_update);	
		if ($conexion->query($sql_update) == TRUE)
		{ 	historia($nitavu,"Guardo Visita para notificar a M:".$f['manzana'].", L:".$f['lote']." de la Col. ".colonia_nombre($f['id_colonia'], $f['id_municipio'])." de ".municipio_nombre($f['id_municipio']));

			mensaje("Guardado correctamente",$url_actual);}
		else {
			historia($nitavu, "<b class='alerta'>ERROR</b>:Marco error al guardar notificacion (".$sql_update.")");

				////// NOTIFICA AL DPTO DE INFORMATICA SOBRE EL ERROR
				$r2up = $conexion -> query("select * from empleados where dpto='55'"); while($a = $r2up -> fetch_array())
				{notifica ($a['nitavu'], "ERROR al notificar ".$_POST['contrato'], $fecha, $nitavu, "Error al guardar una notificacion ".$sql_update);}

			
			mensaje("ERROR AL GUARDAR; se ha informado al dpto de informatica ".$sql_update,$url_actual);
		}






	} else {//si no s subio la foto
		if ($f['visita_fecha']<>''){ //si ya tiene una visita
			if ($_POST['datos_g']=='TRUE'){
				$sql_update="
				UPDATE 
					notificadores_visitas
				SET 
					visitada='TRUE', notificador_nitavu='".$nitavu."', 
					visita_comentarios='".
					$_POST['comentarios_old']."<br>".$fecha.":".$hora." | <b class=tenue>Notificador (".$nitavu.")</b><b class=normal> ".nitavu_nombre($nitavu)."</b>: ".$_POST['comentarios']."<br>',

					entregada='".$_POST['entregada']."', id_estado_lote='".$_POST['cat_estado_lotes']."', id_estado_ubv='".$_POST['cat_estado_ubv']."', curp='".$_POST['curp']."',
					error='".$_POST['errores']."', act_telefono='".$_POST['tel_casa']."', act_telefono_movil='".$_POST['tel_movil']."', vobo='', entregada_invitacionescritura='".$_POST['entregada_escritura']."', transpaso='".$_POST['transpaso']."'

				WHERE (contrato='".$_POST['contrato']."' and visitada='' and brigada_id='".$_GET['brig']."')";
			}else {

				$sql_update="
				UPDATE 
					notificadores_visitas
				SET 
					visitada='TRUE', notificador_nitavu='".$nitavu."', visita_fecha='".$fecha."', visita_hora='".$hora."',
					visita_lat='".$_POST['lat']."', visita_lon='".$_POST['lon']."', visita_acu='".$_POST['acu']."', 

					visita_comentarios='".$_POST['comentarios_old']."<br> 
					".$fecha.":".$hora." | <b class=normal>Notificador (".$nitavu.")</b><b class=ejecutandose> ".nitavu_nombre($nitavu)."</b>: "

					.$_POST['comentarios']."<br>',


					entregada='".$_POST['entregada']."', id_estado_lote='".$_POST['cat_estado_lotes']."', id_estado_ubv='".$_POST['cat_estado_ubv']."', curp='".$_POST['curp']."',
					error='".$_POST['errores']."', act_telefono='".$_POST['tel_casa']."', act_telefono_movil='".$_POST['tel_movil']."', vobo='', entregada_invitacionescritura='".$_POST['entregada_escritura']."', transpaso='".$_POST['transpaso']."'

				WHERE (contrato='".$_POST['contrato']."' and visitada='' and brigada_id='".$_GET['brig']."')";

			}
			//echo $sql_update;
			//$r_up = $conexion -> query($sql_update);	
			if ($conexion->query($sql_update) == TRUE)
			{   
				//historia($nitavu,"Actualizo Visita para notificar a M:".$f['manzana'].", L:".$f['lote']." de la Col. ".
				//colonia_nombre($f['id_colonia'],$f['id_municipio'])." de ".municipio_nombre($f['id_municipio']));

				mensaje("Guardado correctamente",$url_actual);}
			else {
				historia($nitavu, "<b class='alerta'>ERROR</b>:Marco error al guardar notificacion (".$sql_update.")");

					////// NOTIFICA AL DPTO DE INFORMATICA SOBRE EL ERROR
					$r2up = $conexion -> query("select * from empleados where dpto='55'"); while($a = $r2up -> fetch_array())
					{notifica ($a['nitavu'], "ERROR al notificar ".$_POST['contrato'], $fecha, $nitavu, "Error al guardar una notificacion ".$sql_update);}

				
				mensaje("ERROR AL GUARDAR; se ha informado al dpto de informatica ".$sql_update,$url_actual);
			}
			echo "ok";

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
			visitada='', visita_comentarios= '".$_POST['comentarios_old']."<br>".$fecha.":".$hora." |<b class=alerta>Admin |Recaptura| (".$nitavu.")</b><b class=normal> ".nitavu_nombre($nitavu)."</b>: ".$_POST['comentarios']."<br>', vobo=''

		WHERE (contrato='".$f['contrato']."'  and brigada_id='".$_GET['brig']."')";
		//echo $sql_update;
		//$r_up = $conexionmigra -> query($sql_update);	
		if ($conexion->query($sql_update) == TRUE)
		{
				historia($nitavu, "Creo recaptura de L".$_GET['l'].", M".$_GET['m']." de la Col ".colonia_nombre($_GET['col'], $_GET['mun'])." de ".municipio_nombre($_GET['mun']));
				mensaje("Guardado correctamente (admin)",$url_actual);
				//echo "ok";

		}
		else {
			historia($nitavu, "<b class='alerta'>ERROR</b>:Marco error al guardar notificacion (".$sql_update.")");

				////// NOTIFICA AL DPTO DE INFORMATICA SOBRE EL ERROR
				$r2up = $conexion -> query("select * from empleados where dpto='55'"); while($a = $r2up -> fetch_array())
				{notifica ($a['nitavu'], "ERROR al notificar ".$f['contrato'], $fecha, $nitavu, "Error al guardar una notificacion ".$sql_update);}

			
			mensaje("ERROR AL GUARDAR; se ha informado al dpto de informatica ".$sql_update,$url_actual);
			//echo "x";
		}
}




if (isset($_POST['submit_vobo'])){
$url_actual= 'notificadores_visita2.php?brig='.$_GET['brig'].'&col='.$_GET['col']."&mun=".$_GET['mun']."&m=".$_GET['m'];
		$sql_update="
		UPDATE 
			notificadores_visitas
		SET 
			vobo='".$nitavu."', 
			visitada='TRUE', 
			visita_comentarios= '".$_POST['comentarios_old']."<br>"			
			.$fecha.":".$hora." | <b class=tenue>Admin |Vo.Bo| (".$nitavu.")</b><b class=normal> ".nitavu_nombre($nitavu)."</b>: "
			.$_POST['comentarios']."<br>'

		WHERE (contrato='".$f['contrato']."'  and brigada_id='".$_GET['brig']."')";
		//echo $sql_update;
		//$r_up = $conexionmigra -> query($sql_update);	
		if ($conexion->query($sql_update) == TRUE)
		{historia($nitavu, "Dio Vo.Bo. de L".$_GET['l'].", M".$_GET['m']." de la Col ".colonia_nombre($_GET['col'], $_GET['mun'])." de ".municipio_nombre($_GET['mun']));
			mensaje("Vo.Bo. Guardado correctamente (admin)",$url_actual);
			//echo "ok";
		}
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
					//lista de municipios

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
						echo "<a href='notificadores_visita2.php?brig="."&col=".$f['id_colonia']."&mun=".$f['id_municipio']."&m=".$f['manzana']."						
						&l=".$f['lote']."' class='Mbtn btn-tercero'><img src='icon/mas.png'> </a>";
						} else {
						echo "<a href='notificadores_visita2.php?brig="."&col=".$f['id_colonia']."&mun=".$f['id_municipio']."&m=".$f['manzana']."						
						&l=".$f['lote']."' class='Mbtn btn-tercero'><img src='icon/veri.png'> </a>";
						
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


					if ($nivel==1 or $nivel==4) { //SuperAdmin, ve todo sin captura, solo puede marcarlo y comentar									
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
						

						ORDER BY
							manzana ASC
							";
					}


					if ($nivel==3 or $nivel==2 ) { // solo puede ver las de su delegacion Operador y Admin										
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

					//echo "SQL de manzana: ".$sqlm."</br>";
					//echo "<b>".$sqlm."</b><hr>";

						$rm = $conexion -> query($sqlm);	
						echo "<div id='manzanas'><label>Manzanas:</label>";						
						while($m = $rm -> fetch_array())
						{
							$avance_m=notificadores_colonia_manzana_avance($_GET['col'],$m['manzana']);

							$mp = manzana_pendientes($m['id_colonia'], $m['id_municipio'], $m['manzana']);
							//echo $mp;
							if (isset($_GET['m']))
							{
								if ($_GET['m']==$m['manzana']){//seleccionada

								echo "<a ";

								if ($mp>0){echo " class='manzana_seleccionada titilar_dark'";}
								else {echo " class='manzana_seleccionada' ";}

								echo "

										style='   
										background: url(../img/wall.png);   

										background-size: ".$avance_m."%, 800px;
					    				background-repeat: no-repeat;
					    				background-color: #CDCDCD;
					    				
					    				'

										 href='notificadores_visita2.php?brig=".$_GET['brig']."&m=".$m['manzana']."&col=".$m['id_colonia']."&mun=".$_GET['mun']."' title='".$avance_m."%'>".$m['manzana']."</a>";

								} 
								else
								{
										echo "<a ";

								if ($mp>0){echo " class='titilar_dark'";}
								else {echo " class='' ";}

										echo "
										style='   
										background: url(../img/wall.png);   
										background-size: ".$avance_m."%, 800px;
					    				background-repeat: no-repeat;
					    				background-color: #CDCDCD;
					    				
					    				'
										href='notificadores_visita2.php?brig=".$_GET['brig']."&m=".$m['manzana']."&col=".$m['id_colonia']."&mun=".$_GET['mun']."'  title='".$avance_m."%'>".$m['manzana']."</a>";
								}

							} else {
										echo "<a ";
										if ($mp>0){echo " class=' titilar_dark'";}
										else {echo " class='' ";}
										echo "
										style='   
										background: url(../img/wall.png);   
										background-size: ".$avance_m."%, 800px;
					    				background-repeat: no-repeat;
					    				background-color: #CDCDCD;
					    				
					    				'
										href='notificadores_visita2.php?brig=".$_GET['brig']."&m=".$m['manzana']."&col=".$m['id_colonia']."&mun=".$_GET['mun']."'  title='".$avance_m."%'>".$m['manzana']."</a>";
								

							}
						
							
					 	}
					 	echo "</div>";



			} else {



				//////////////////GRAFICAS//////////////////////////////
				
				echo "<hr>";
				echo "<h3>Resumen Global</h3>";

				if ($nivel=='2' or $nivel=='1' or $nivel=='4'){

				







					echo "<div id='colonias'>";
					
					$sql = "
						select 
							count(*) as total,
							(select count(*) from notificadores_visitas where vobo<>'') as vobo_ok

						FROM notificadores_visitas

						where notificadores_visitas.visitada='TRUE'

					";
					$rc= $conexion -> query($sql);
					if($f = $rc -> fetch_array())
					{	echo "<h3>Avance de Vo.Bo. de las Delegaciones</h3>";
						echo "<table class='tabla3' width='100%'>";						
						
						echo "<th>Visitadas</th>";
						echo "<th>Vo.Bo.</th>";
						echo "<tr>";
						
						echo "<td>".$f['total']."</td>";
						echo "<td>".$f['vobo_ok']."</td>";
						
						echo "</tr>";

						echo "</table>";

					}

					$data2="";
					$data2 = $data2."['Invitaciones para Escrituracion', 'Avance'],";
					//$data2 = $data2."['Visitadas', ".$f['visitadas']."],";
					//$data2 = $data2."['Entregadas', ".$f['entregadas']."],";

					$grafica2 = "
					   <script type='text/javascript' src='lib/gstatic_loader.js'></script>
						  <script type='text/javascript'>
						    google.charts.load('current', {packages:['corechart']});
						    google.charts.setOnLoadCallback(drawChart);
						    function drawChart() {
						      var data = google.visualization.arrayToDataTable([
						        ['Situacion', 'Valor', { role: 'style' } ],
						        ['visitada', ".$f['total'].", '#045EA1'],
						        ['vobo', ".$f['vobo_ok'].", '#E3D79F']
						        
						      ]);

						      var view = new google.visualization.DataView(data);
						      view.setColumns([0, 1,
						                       { calc: 'stringify',
						                         sourceColumn: 1,
						                         type: 'string',
						                         role: 'annotation' },
						                       2]);

						      var options = {
						        title: 'Avance del Vo.Bo. del registro actual',
						       
						        bar: {groupWidth: '95%'},
						        legend: { position: 'none' },
						      };
						      var chart = new google.visualization.ColumnChart(document.getElementById('columnchart_values'));
						      chart.draw(view, options);
						  }
						  </script>
						<div id='columnchart_values' style='width: 90%; '></div>";

					echo $grafica2;



					echo "</div>";
























					echo "<div id='colonias'>";
					
					$sql = "
						select 
							count(*) as escrituras,
							(select count(*) from notificadores_visitas, tmp_escrituraslistas where notificadores_visitas.contrato = tmp_escrituraslistas.contrato and notificadores_visitas.visitada='TRUE' and notificadores_visitas.vobo<>'') visitadas,
							(select count(*) from notificadores_visitas, tmp_escrituraslistas where  notificadores_visitas.contrato = tmp_escrituraslistas.contrato and notificadores_visitas.entregada_invitacionescritura='TRUE' and notificadores_visitas.vobo<>'') entregadas
							
							

						FROM notificadores_visitas, tmp_escrituraslistas
						where notificadores_visitas.contrato = tmp_escrituraslistas.contrato

					";
					$rc= $conexion -> query($sql);
					if($f = $rc -> fetch_array())
					{	echo "<h3>Invitaciones para Escrituracion</h3>";
						echo "<table class='tabla3' width='100%'>";						
						echo "<th>Total</th>";
						echo "<th>Visitadas</th>";
						echo "<th>Entregadas</th>";
						echo "<tr>";
						echo "<td>".$f['escrituras']."</td>";
						echo "<td>".$f['visitadas']."</td>";
						echo "<td>".$f['entregadas']."</td>";
						
						echo "</tr>";

						echo "</table>";

					}

					$data2="";
					$data2 = $data2."['Invitaciones para Escrituracion', 'Avance'],";
					$data2 = $data2."['Visitadas', ".$f['visitadas']."],";
					$data2 = $data2."['Entregadas', ".$f['entregadas']."],";

					$grafica2 = "
					    <script type='text/javascript'>
					     google.charts.load('current', {'packages':['corechart']});
					      google.charts.setOnLoadCallback(drawChart);

					      function drawChart() {
					        var data = google.visualization.arrayToDataTable([

					            ".$data2."
					             
					        
					             ]);

					       var options = {
					          title: '',
					          hAxis: {title: 'Invitaciones para Escrituracion',  titleTextStyle: {color: '#333'}},
					          vAxis: {minValue: 0},
					          legend: {position: 'top', maxLines: 2},
					         
					          
					        };
					        var chart = new google.visualization.PieChart(document.getElementById('chart_top2'));

					        
					        chart.draw(data, options);

					      }
					    </script>
					  <div id='chart_top2' style='width: 90%; background-color:white;'' ></div>";

					 echo $grafica2;



///AVANCE GRAFICAS
					//echo "<div id='colonias'>";
					echo "<hr>";
					$sql = "
						select 
						count(*) as total,
						(select count(*) from notificadores_visitas where  visitada='TRUE') as visitadas,
						(select count(*) from notificadores_visitas where  visitada='TRUE' and entregada='TRUE') as entregadas
						

					FROM notificadores_visitas
					

					";
					$rc= $conexion -> query($sql);
					if($f = $rc -> fetch_array())
					{	echo "<h3>Entrega de notificaciones</h3>";
						echo "<table class='tabla2' width='100%'>";						
						echo "<th>Total</th>";
						echo "<th>Visitadas</th>";
						echo "<th>Entregadas</th>";
						echo "<tr>";
						echo "<td>".$f['total']."</td>";
						echo "<td>".$f['visitadas']."</td>";
						echo "<td>".$f['entregadas']."</td>";
						
						echo "</tr>";

						echo "</table>";

					}

					$data2="";
					$data2 = $data2."['Invitaciones para Escrituracion', 'Avance'],";
					$data2 = $data2."['Visitadas', ".$f['visitadas']."],";
					$data2 = $data2."['Entregadas', ".$f['entregadas']."],";

					$grafica3 = "
					    <script type='text/javascript'>
					     google.charts.load('current', {'packages':['corechart']});
					      google.charts.setOnLoadCallback(drawChart);

					      function drawChart() {
					        var data = google.visualization.arrayToDataTable([

					            ".$data2."
					             
					        
					             ]);

					       var options = {
					          title: '',
					          hAxis: {title: 'Invitaciones para Escrituracion',  titleTextStyle: {color: '#333'}},
					          vAxis: {minValue: 0},
					          legend: {position: 'top', maxLines: 2},
					         
					          
					        };
					        var chart = new google.visualization.PieChart(document.getElementById('chart_top3'));

					        
					        chart.draw(data, options);

					      }
					    </script>
					  <div id='chart_top3' style='width: 90%; background-color:white;'' ></div>";

					 echo $grafica3;
					
					//echo "</div>";


					echo "</div>";





					



					////
					///AVANCE
					echo "<div id='colonias'>";
					$sql = "
						SELECT DISTINCT
							notificadores_visitas.id_estado_lote as id_estado,
							(select cat_estado_lotes.nombre from cat_estado_lotes where id=id_estado) as estado,
							(select count(*) from notificadores_visitas where id_estado_lote=id_estado and visitada='TRUE' ) as avance
							
						FROM
							notificadores_visitas, cat_estado_lotes
						WHERE
							notificadores_visitas.visitada = 'TRUE'
						

					";
					$rc= $conexion -> query($sql);
					$r= $conexion -> query($sql);	
						echo "<h3>Resumen de Estado de Lotes</h3>";
						echo "<table class='tabla2' width='100%'>";						
						echo "<th>Estado</th>";
						echo "<th>Avance</th>";
						$data2="";
						$data2 = $data2."['Invitaciones para Escrituracion', 'Avance'],";
						//$data2 = $data2."['Visitadas', ".$f['visitadas']."],";

						while($f = $r -> fetch_array())		
							{	
								echo "<tr>";
								echo "<td>".$f['estado']."</td>";
								echo "<td>".$f['avance']."</td>";	
								$data2 = $data2."['".$f['estado']."', ".$f['avance']."],";	
								
								echo "</tr>";			

							}


					
					
  						$data2 =   trim($data2, ',');
					$grafica4 = "
					    <script type='text/javascript'>
					     google.charts.load('current', {'packages':['corechart']});
					      google.charts.setOnLoadCallback(drawChart);

					      function drawChart() {
					        var data = google.visualization.arrayToDataTable([

					            ".$data2."
					             
					        
					             ]);

					       var options = {
					          title: '',
					          hAxis: {title: 'Invitaciones para Escrituracion',  titleTextStyle: {color: '#333'}},
					          vAxis: {minValue: 0},
					          legend: {position: 'top', maxLines: 2},
					         
					          
					        };
					        var chart = new google.visualization.PieChart(document.getElementById('chart_top4'));

					        
					        chart.draw(data, options);

					      }
					    </script>
					  <div id='chart_top4' style='width: 90%; background-color:white;'' ></div>";

					 echo $grafica4;



							echo "</table>";
							echo "</div>";

					








					//grafica transpaso

					echo "<div id='colonias'>";
					$sql = "
					select 
							count(*) as total_visitados,
							(select count(*) from notificadores_visitas where transpaso=1) as Transpasos,
							(select count(*) from notificadores_visitas where transpaso=2) as NOtranspasos,
							(select count(*) from notificadores_visitas where transpaso=3) as SinEntrevistar

					FROM
							notificadores_visitas
					WHERE	
							visitada='TRUE'

					";
					//echo $sql;
					 $r= $conexion -> query($sql);	
					//  ['Task', 'Hours per Day'],
			  //         ['Work',     11],
			  //         ['Eat',      2],
			  //         ['Commute',  2],
			  //         ['Watch TV', 2],
			  //         ['Sleep',    7]
					$data ="['Entrevista','Total'],";

					echo "<h3>Entrevistas de  Transpasos</h3>";
						echo "<table class='tabla3' width='100%'>";						
						echo "<th>Total</th>";
						echo "<th>SI</th>";
						echo "<th>NO</th>";				
						echo "<th>Sin Entrevistar</th>";				

					while($t = $r -> fetch_array())		
					{	
						echo "<tr>";
						echo "<td>".$t['total_visitados']."</td>";
						echo "<td>".$t['Transpasos']."</td>";
						echo "<td>".$t['NOtranspasos']."</td>";
						echo "<td>".$t['SinEntrevistar']."</td>";
								
						echo "</tr>";

						$data = $data."['SI', ".$t['Transpasos']."],";
						$data = $data."['NO' ,".$t['NOtranspasos']."],";
						$data = $data."['Sin Entrevistar', ".$t['SinEntrevistar']."]";
						
					

					}
					echo "</table>";

					//echo $data;
					$grafica8 = "
					<script type='text/javascript'>
					google.charts.load('current', {packages:['corechart']});
      				google.charts.setOnLoadCallback(drawChart);
      				function drawChart() {
        				var data = google.visualization.arrayToDataTable([
  						['Entrevista','Total'],['SI', 18],['NO' ,74],['Sin Entrevistar', 433]
        			]);

        			var options = {
          				title: 'Transpasos',
          				pieHole: 0.4,
        				};

        			var chart = new google.visualization.PieChart(document.getElementById('chart_top8'));
        			chart.draw(data, options);
      				}
      				</script>
     				  <div id='chart_top8' style='width: 100%; background-color:white;' ></div>";
					 echo $grafica8;


					echo "</div>";

					

				}





				
					if ($nivel=='3') { // solo puede ver las de su delegacion Operador y Admin										
						$sqlmc="SELECT DISTINCT
						colonia, id_colonia, id_municipio
						FROM
						notificadores_visitas
						WHERE
						visitada = ''
						and delegacion='".midelegacion_id($nitavu)."'

						";
					}

				if ($nivel=='2') { // solo puede ver las de su delegacion Operador y Admin										
						$sqlmc="SELECT DISTINCT
						colonia, id_colonia, id_municipio
						FROM
						notificadores_visitas
						WHERE
						delegacion='".midelegacion_id($nitavu)."'
						";
					}

					if ($nivel=='1' or $nivel=='4') { // sUPER adMIN PUEDE VER TODO,										
						$sqlmc="SELECT DISTINCT
						colonia, id_colonia, id_municipio
						FROM
						notificadores_visitas

						
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
					background-size: ".$avance."%, 100%;
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
				echo "<th width='150px'>".""."</th>";

				if ($nivel=='3') { // solo puede ver las de su delegacion Operador y Admin		
				$sql = "
				SELECT 		manzana, lote,
							colonia,
							id_colonia, contrato, visita_hora, visita_fecha, visita_lat, visita_lon, id_estado_lote, 
							id_municipio, delegacion, brigada_id, nombre, paterno, materno, visitada, curp, visita_fecha, vobo, notificador_nitavu
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

				if ($nivel=='2' or $nivel=='1' or $nivel=='4') { //	
				$sql = "
				SELECT 		manzana, lote,
							colonia,
							id_colonia, contrato, visita_hora, visita_fecha, visita_lat, visita_lon, id_estado_lote, 
							id_municipio, delegacion, brigada_id, nombre, paterno, materno, visitada, curp, visita_fecha, vobo, notificador_nitavu
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
						echo "<tr class='";
							if (escritura_lista($f['contrato'])=='TRUE'){echo "ejecutandose ";}
							if ($f['curp']=='' or $f['curp']=='NULL'){echo " alerta ";} 
							if ($f['visita_fecha']<>'0000-00-00'){echo " oscura ";}

						echo "'>";
					

						echo "<td class='pc'>".$f['brigada_id']."</td>";
						echo "<td>".$f['manzana']."</td>";
						echo "<td>".$f['lote']."</td>";
						echo "<td><b>".$f['nombre']."</b> ".$f['paterno']." ".$f['materno']."</td>";
						echo "<td align='center' valing='top'>";
						if ($nivel=='4'){






									if ($f['visita_fecha']<>'0000-00-00' and $f['visitada']=='TRUE' and $f['vobo']<>'') {
										$archivo_foto = 'notificadores/'.$f['contrato'].'_'.$f['visita_fecha'].'_lote.jpg';       
										$title= "Manzana ".$f['manzana']." Lote ".$f['lote'];
							            $des = "Beneficiario: ".$f['nombre']." ".$f['paterno']." ".$f['materno']."<br>";
							            $des = $des." Col. ".colonia_nombre($f['id_colonia'], $f['id_municipio'])."<br>";
							            $des = $des."Contrato: ".$f['contrato']."";
							            $des = $des."<br><br>Visita hecha por <b>".nitavu_nombre($f['notificador_nitavu'])."</b> a las ".$f['visita_hora']." de ".$f['visita_fecha']." y Verificada (Vo.Bo.) Vo.Bo. por <b> ".nitavu_nombre($f['vobo'])."</b>";

							            $div = "<h1>".$title."</h1><div>".$des."<div>"."<img width=400px src=".$archivo_foto."><br> Clasificada como ".id_estado_lote_nombre($f['id_estado_lote']);

							            echo " <a class='Mbtn btn-tercero ' href='
							            geomapa.php?lat=".$f['visita_lat']."&lon=".$f['visita_lon']."&title=".$title."&div=".$div."'>";

							            echo "<img src='icon/mapa.png' >";

							            echo "</a>";


										

										echo " <a href='notificadores_visita2.php?brig=".$_GET['brig']."&col=".$f['id_colonia']."&mun=".$f['id_municipio']."&m=".$f['manzana']."		&l=".$f['lote']."'";
										echo "class='Mbtn btn-tercero'>";
										echo "<img src='icon\mas.png'>";	
										echo "</a>";
									} 
									else
									{
										//echo "Aun no si visita";
									}
	

								
										
									
														

						}
						else {

								if ($nivel=='2' or $nivel=='1'){
										$archivo_foto = 'notificadores/'.$f['contrato'].'_'.$f['visita_fecha'].'_lote.jpg';       
										$title= "Manzana ".$f['manzana']." Lote ".$f['lote'];
							            $des = "Beneficiario: ".$f['nombre']." ".$f['paterno']." ".$f['materno']."<br>";
							            $des = $des." Col. ".colonia_nombre($f['id_colonia'], $f['id_municipio'])."<br>";
							            $des = $des."Contrato: ".$f['contrato']."";
							            $des = $des."<br><br>Visita hecha por <b>".nitavu_nombre($f['notificador_nitavu'])."</b> a las ".$f['visita_hora']." de ".$f['visita_fecha']." y Verificada (Vo.Bo.) Vo.Bo. por <b> ".nitavu_nombre($f['vobo'])."</b>";

							            $div = "<h1>".$title."</h1><div>".$des."<div><img width=400px src=".$archivo_foto."><br> Clasificada como ".id_estado_lote_nombre($f['id_estado_lote']);

							            echo " <a class='Mbtn btn-tercero ' href='
							            geomapa.php?lat=".$f['visita_lat']."&lon=".$f['visita_lon']."&title=".$title."&div=".$div."'>";

							            echo "<img src='icon/mapa.png' >";

							            echo "</a>  ";
							    }


								echo "<a href='notificadores_visita2.php?brig=".$_GET['brig']."&col=".$f['id_colonia']."&mun=".$f['id_municipio']."&m=".$f['manzana']."		&l=".$f['lote']."'";

									if ($f['visita_fecha']=='0000-00-00' and $f['visitada']=='') {
										echo "class='Mbtn btn-tercero' title='Haga clic aqui para Verificar'>";
										//echo "Verificar";	
										echo "<img src='icon/veri.png' >";	
									}
									if ($f['visita_fecha']<>'0000-00-00' and $f['visitada']=='') {
										echo "class='Mbtn btn-cancel' title='Haga clic aqui para RE Verificar'>";
										//echo "Re-Verificar";	
										echo "<img src='icon/reveri.png'>";	
									}
									if ($f['visita_fecha']<>'0000-00-00' and $f['visitada']=='TRUE' and $f['vobo']=='') {
										echo "class='Mbtn btn-secundario' title='Haga clic aqui para hacer el Vo.Bo.'>";
										//echo "<b class='normal'>Vo.Bo</b>";	
										echo "<img src='icon/vobo.png'>";	
									}
								
									if ($f['visita_fecha']<>'0000-00-00' and $f['visitada']=='TRUE' and $f['vobo']<>'') {
										echo "class='Mbtn btn-tercero' title='Haga clic aqui para ver mas informacion'>";
										echo "<img src='icon/mas.png'>";	
									}
								echo "</a>";
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


$indicaciones= "
<h3>Indicaciones sobre los nuevos botoneS: </h3>
<img src='img/indicadoresdemanzana.png'  class='sugerencias_img'>
<img srC='img/indicadoresdebotones.png' class='sugerencias_img'>
";
echo sugerencia("".$indicaciones);
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
	<?php
	echo '
    <script src="https://maps.googleapis.com/maps/api/js?key='.$key_map_static.'&callback=initMap"
    async defer></script>
	';

	?>





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
				 document.getElementById("list2").innerHTML = ['<img class="thumb" src="', e.target.result,'" title="', escape(theFile.name), '"/>'].join('');
				};
			  })(f);
		
			  reader.readAsDataURL(f);
			}
		  }
		
		  document.getElementById('foto_op').addEventListener('change', archivo, false);
		</script>
    


			
			<br><br><br><br><br><br><br><br><br><br><br><br><br><br>
<?php
include ("./lib/body_footer.php");
?>