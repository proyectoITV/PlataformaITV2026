<?php include ("./lib/body_head.php"); include ("./lib/body_menu.php"); ?>
<?php
$id_aplicacion ="ap35"; 
$nivel = aplicacion_nivel($id_aplicacion, $nitavu);
if (sanpedro($id_aplicacion, $nitavu)==TRUE){
	echo "<div id='AppDetalle'>".app_detalle($id_aplicacion, $nitavu)."</div>";
	//echo "Nivel: ".$nivel;

	if ($nivel=='3'){

	if(isset($_POST['submit']))
		{//VALIDAMOS Y GUARDAMOS
		$nombre = $_POST['nombre']; $paterno= $_POST['paterno']; $materno=$_POST['materno'];
		$curp_titular = $_POST['curp'];
		
		$nombre_conyugue = $_POST['nombre_conyugue']; $paterno_conyugue= $_POST['paterno_conyugue']; $materno_conyugue=$_POST['materno_conyugue'];
		$curp_conyugue = $_POST['curp_conyugue'];

		$domicilio = $_POST['domicilio']; $telefono = $_POST['telefono']; $ingreso = $_POST['ingreso'];
		$propiedad = $_POST['propiedad']; $apoyo = $_POST['apoyo']; $comentario = $_POST['comentario'];

		$lat = $_POST['lat']; $lon = $_POST['lon']; $acu=$_POST['acu'];

		$id = $_POST['id'];

		
	$subida="";		
	$archivo = 'docs/solicitudes/ife_a_'.$id;
	$subida= $subida.subir2('ife_frente', $archivo, 'jpg');

	$archivo = 'docs/solicitudes/ife_b_'.$id;
	$subida= $subida.subir2('ife_atras', $archivo, 'jpg');


	$subida2="";
	$archivo = 'docs/solicitudes/ife_a_conyugue'.$id;
	$subida2= $subida2.subir2('ife_frente_conyugue', $archivo, 'jpg');

	$archivo = 'docs/solicitudes/ife_b_conyugue'.$id;
	$subida2= $subida2.subir2('ife_atras_conyugue', $archivo, 'jpg');

	$archivo = 'docs/solicitudes/foto_'.$id;
	$subida2= $subida2.subir2('foto', $archivo, 'jpg');

	if ($subida=="")
	{		

		$sql = "INSERT INTO solicitudes_jornada
		(id, nombre, paterno, materno, curp, conyuge_nombre, conyuge_paterno, conyuge_materno, curp_conyuge, domicilio, propiedad, ingreso_familiar, telefono, apoyo, lat, lon, acu, fecha, hora, nitavu, comentario )
		VALUES
		('$id', '$nombre', '$paterno', '$materno', '$curp_titular','$nombre_conyugue', '$paterno_conyugue', '$materno_conyugue', '$curp_conyugue', '$domicilio', '$propiedad', '$ingreso', '$telefono', '$apoyo', '$lat', '$lon', '$acu','$fecha', '$hora', '$nitavu','$comentario')";
		if ($conexion->query($sql) == TRUE)
		{ 
			historia($nitavu,"Hizo una presolicitud a ".$nombre." ".$paterno." ".$materno." con ID ".$id);
			mensaje ("Se ha guardado correctamente, con el ID ".$id.". <br> Puede continuar capturando...",'solicitudes_jornada.php');
		}
		else{ mensaje("Error al guardar notificacion (".$sql.")",'');}



	}
	else {//no subio la foto
		mensaje("No se podido cargar la foto de la credencial, intentalo de nuevamente",'');
		historia($nitavu,"Intento hacer solicitud, y marco error ".$nombre." ".$paterno." ".$materno." con ID ".$id."<br> ERROR de ".$subida. " o ".$sql);

	}


			
		}

	else {
	$soli =	presolicitud_no(FALSE,1);
	historia ($nitavu,"Uso captura de solicitud no. ".$soli." de la jornada multidiciplinaria ITAVU DIF<br> app:".$id_aplicacion);
	echo '
	<form action="solicitudes_jornada.php" method="post" enctype="multipart/form-data">
		<div class="cuadro_ fondo_tenue_map">
			<div>
					<label>ID de Solicitud</label>
					<input type="text" name="id" value="'.$soli.'" readonly="readonly">
			</div>

			<div>

				<label>Nombre (Titular):</label>
				<input type="text" name="nombre" required="required">
			</div>
			<div>
				<label>Ap. Paterno (Titular):</label>
				<input type="text" name="paterno" required="required">
			</div>
			<div>
				<label>Ap. Materno (Titular):</label>
				<input type="text" name="materno" required="required">
			</div>
			<div>
				<label>CURP (Titular):</label>
				<input type="text" name="curp">
			</div>
			<div>
				<label>Foto del credencial FRENTE (Titular): * Se requiere</label>
				<input type="file" name="ife_frente">
			</div>
			<div>
				<label>Foto del credencial ATRAS (Titular): * Se requiere</label>
				<input type="file" name="ife_atras">
			</div>
		</div>
		<div class="cuadro_  fondo_tenue_amarillo">
			<div>
				<label>Nombre (Conyugue):</label>
				<input type="text" name="nombre_conyugue">
			</div>
			<div>
				<label>Ap. Paterno (Conyugue):</label>
				<input type="text" name="paterno_conyugue">
			</div>
			<div>
				<label>Ap. Materno (Conyugue):</label>
				<input type="text" name="materno_conyugue">
			</div>
			<div>
				<label>CURP (Conyugue):</label>
				<input type="text" name="curp_conyugue">
			</div>
			<div>
				<label>Foto del credencial FRENTE (Conyugue):</label>
				<input type="file" name="ife_frente_conyugue">
			</div>
			<div>
				<label>Foto del credencial ATRAS (Conyugue):</label>
				<input type="file" name="ife_atras_conyugue">
			</div>
		</div>
		<div class="cuadro_  fondo_tenue_amarillo">		
		<div>
			<label>Domicilio:</label>
			<input type="text" name="domicilio" required="required">
		</div>
		<div>
			<label>¿Cuanta con otra Propiedad?:</label>
			<select name="propiedad">
				<option value="NO" selected="selected">NO</option>
				<option value="SI">SI</option>
			</select>
			
		</div>
		<div>
			<label>Ingreso Familiar:</label>
			<input type="number" name="ingreso" min="1000" max="10000" step="1000">
		</div>
		<div>
			<label>Telefono:</label>
			<input type="tel" name="telefono" required="required">
		</div>
		<div>
			<label>Apoyo solicitado: (si elige otros, especifique en los comentarios)</label>
			<select name="apoyo" required="required">
				<option value="VIIVIENDA COMPLETA" selected="selected">VIVIENDA COMPLETA</option>
				<option value="PISO">PISO</option>
				<option value="BLOCK">BLOCK</option>
				<option value="LAMINA">LAMINA</option>
				<option value="TINACO">TINACO</option>
				<option value="TECNO CONCRETO">TECNO CONCRETO</option>
				<option value="CUARTO ADICIONAL">CUARTO ADICIONAL</option>
				<option value="OTRO">Otro...</option>
			</select>
		</div>

			<div>
				<label>Fotografia:</label>
				<input type="file" name="foto">
			</div>

		</div>
		<div>
			<label>Comentario del Entrevistador:</label>
			<textarea name="comentario"></textarea>
		</div>
		<div class="cuadro_">
			<label>GEOLOCALIZACION:</label>
			<div>
				<label>Longitud:</label>
				<input type="text" name="lon" id="lon" readonly="readonly">
				<label>Latitud:</label>
				<input type="text" name="lat" id="lat" readonly="readonly">
			</div>
			
			<input type="hidden" name="acu" id="acu" readonly="readonly">
			<div>
				<label>Croquis de Localizacion</label>
				<img class="img_map" id="img_map" name="img_map" src="" width="600"  >
			</div>
		</div>
		<div>
		<input type="submit" name="submit"class="Mbtn btn-default" value="Guardar">
		</div>
	</form>


	';
	
	}	
	} // fin nivel 3

	if ($nivel=='2'){//BUSQUEDA Y EDICION

		if (isset($_GET['busqueda'])){
			$sql = "select * from solicitudes_jornada where (nombre like'%".$_GET['busqueda']."%' or paterno like'%".$_GET['busqueda']."%' or materno like'%".$_GET['busqueda']."%') order by fecha, hora ASC";
			$r = $conexion -> query($sql);	$c = $r -> num_rows;
			//echo $sql;
			historia ($nitavu,"Busco ".$_GET['busqueda']." en las solicitudes de la jornada multidiciplinaria ITAVU DIF<br> app:".$id_aplicacion);
			if ($c<=0){//si no hay resultados
				echo '<div class ="centrar_mensaje_padre"><div class = "centrar_mensaje_hijo">';
				echo "<br> No se han encontrado nada con las palabras que usaste - ".$_GET['busqueda']." - "."<a href='solicitudes_jornada.php'>Buscar nuevamente.</a>";
				echo "</div></div>";

				}	
			else {		
			$encontrados = "
			<h1>Busqueda sobre <b>".$_GET['busqueda']."</b></h1>
			<table class='tabla' border='0'>		
			<th class='pc'>ID</th>
			<th >Nombre</th>
			<th>Apoyo</th>
			<th class='pc'>Telefono</th>
			<th class='pc'>Comentario</th>
			<th></th>
			";
			while($d = $r -> fetch_array())
			{
			//$foto= ponerfoto("fotos/".$d['nitavu'].".jpg",'icono'); 
			$doc = "<tr>";
			$doc = $doc."<td class='pc'>".$d['id']."</td>";
			$doc = $doc."<td>".$d['nombre']." ".$d['paterno']." ".$d['materno']."</td>";
			$doc = $doc."<td>".$d['apoyo']."</td>";
			$doc = $doc."<td class='pc'>".$d['telefono']."</td>";
			$doc = $doc."<td class='pc'>".$d['comentario']."</td>";
			$doc = $doc."<td width='110px'>";
			$doc = $doc."<a href='solicitudes_jornada.php?edit=".$d['id']."'>Corregir</a>";
			
			$doc = $doc."</td>";
			$doc = $doc."</tr>";
			
			$encontrados=$encontrados.$doc;

			}//while
			$encontrados = $encontrados."</table>";

			echo "<section id='digitales'>";
			echo $encontrados;
			echo "</section>";
			}// else (no encontro)

		} else {

			if (isset($_GET['edit'])){
				//echo "Editar ".$_GET['edit'];
				$sql = "SELECT * from solicitudes_jornada WHERE id='".$_GET['edit']."'";
				$rc= $conexion -> query($sql);				
				if($f = $rc -> fetch_array())
					{
					echo '
					<form action="solicitudes_jornada.php" method="post" enctype="multipart/form-data">
					<input type="hidden" name="edit">
					<div class="cuadro_ fondo_tenue_map">
					<div>
						<label>ID de Solicitud</label>
						<input type="text" name="id" value="'.$_GET['edit'].'" readonly="readonly">
					</div>

					<div>
						<label>Nombre (Titular):</label>
						<input type="text" name="nombre" required="required" value="'.$f['nombre'].'">
					</div>
				
					<div>
						<label>Ap. Paterno (Titular):</label>
						<input type="text" name="paterno" required="required" value="'.$f['paterno'].'">
					</div>
				
					<div>
						<label>Ap. Materno (Titular):</label>
						<input type="text" name="materno" required="required" value="'.$f['materno'].'">
					</div>
					
					<div>
						<label>CURP (Titular):</label>
						<input type="text" name="curp" value="'.$f['curp'].'">
					</div>
				
				<div>';
				echo ponerfoto("docs/solicitudes/ife_a_".$f['id'].".jpg",'foto');
				echo '
					
					<label>Foto del credencial FRENTE (Titular):</label>
					<input type="file" name="ife_frente">
				</div>

				<div>';
				echo ponerfoto("docs/solicitudes/ife_b_".$f['id'].".jpg",'foto');
				echo '
					
					<label>Foto del credencial ATRAS (Titular):</label>
					<input type="file" name="ife_atras">
				</div>

					<div>';
			echo ponerfoto("docs/solicitudes/foto_".$f['id'].".jpg",'foto');
			echo '
				<label>Fotografia:</label>
				<input type="file" name="foto">
			</div>


				</div>


				<div class="cuadro_  fondo_tenue_amarillo">
					<div>
						<label>Nombre (Conyugue):</label>
						<input type="text" name="nombre_conyugue" value="'.$f['conyuge_nombre'].'">
					</div>
					<div>
						<label>Ap. Paterno (Conyugue):</label>
						<input type="text" name="paterno_conyugue" value="'.$f['conyuge_paterno'].'">
					</div>
					<div>
						<label>Ap. Materno (Conyugue):</label>
						<input type="text" name="materno_conyugue" value="'.$f['conyuge_materno'].'">
					</div>
					<div>
						<label>CURP (Conyugue):</label>
						<input type="text" name="curp_conyugue" value="'.$f['curp_conyuge'].'">
					</div>
					<div>';
						echo ponerfoto("docs/solicitudes/ife_a_conyugue".$f['id'].".jpg",'foto');
					
					echo '					
						<label>Foto del credencial FRENTE (Conyugue):</label>
						<input type="file" name="ife_frente_conyugue">
					</div>
					<div>';
						echo ponerfoto("docs/solicitudes/ife_b_conyugue".$f['id'].".jpg",'foto');
					echo '
						
						<label>Foto del credencial ATRAS (Conyugue):</label>
						<input type="file" name="ife_atras_conyugue">
					</div>
				</div>
		<span>
			<label>Domicilio:</label>
			<input type="text" name="domicilio" required="required" value="'.$f['domicilio'].'">
		</span>
		<div>
			<label>¿Cuanta con otra Propiedad?:</label>
			<select name="propiedad">';
			if ($f['propiedad']=="SI"){ echo '<option value="SI" selected="selected">SI</option>';}
			else {echo '<option value="SI">SI</option>';}

			if ($f['propiedad']=="NO"){ echo '<option value="SI" selected="selected">NO</option>';}
			else {echo '<option value="SI">NO</option>';}

			echo '
				
			</select>
			
		</div>
		<div>
			<label>Ingreso Familiar:</label>
			<input type="number" name="ingreso" min="1000" max="10000" step="1000" value="'.$f['ingreso_familiar'].'">
		</div>
		<div>
			<label>Telefono:</label>
			<input type="tel" name="telefono" required="required" value="'.$f['telefono'].'">
		</div>
		<div>
			<label>Apoyo solicitado: (si elige otros, especifique en los comentarios)</label>

			<select name="apoyo" required="required">
			';
			if ($f['apoyo']=="VIIVIENDA COMPLETA"){ echo '<option value="VIIVIENDA COMPLETA" selected="selected">VIIVIENDA COMPLETA</option>';}
			else {echo '<option value="VIIVIENDA COMPLETA">VIIVIENDA COMPLETA</option>';}

			if ($f['apoyo']=="PISO"){ echo '<option value="PISO" selected="selected">PISO</option>';}
			else {echo '<option value="PISO">PISO</option>';}

			if ($f['apoyo']=="BLOCK"){ echo '<option value="BLOCK" selected="selected">BLOCK</option>';}
			else {echo '<option value="BLOCK">BLOCK</option>';}

			if ($f['apoyo']=="LAMINA"){ echo '<option value="LAMINA" selected="selected">LAMINA</option>';}
			else {echo '<option value="LAMINA">LAMINA</option>';}

			if ($f['apoyo']=="TINACO"){ echo '<option value="TINACO" selected="selected">TINACO</option>';}
			else {echo '<option value="TINACO">TINACO</option>';}

			if ($f['apoyo']=="TECNO CONCRETO"){ echo '<option value="TECNO CONCRETO" selected="selected">TECNO CONCRETO</option>';}
			else {echo '<option value="TECNO CONCRETO">TECNO CONCRETO</option>';}

			if ($f['apoyo']=="CUARTO ADICIONAL"){ echo '<option value="CUARTO ADICIONAL" selected="selected">CUARTO ADICIONAL</option>';}
			else {echo '<option value="CUARTO ADICIONAL">CUARTO ADICIONAL</option>';}

			if ($f['apoyo']=="OTRO"){ echo '<option value="OTRO" selected="selected">OTRO</option>';}
			else {echo '<option value="OTRO">OTRO</option>';}

			echo '
				
			</select>
			</div>
			
		


			<div>
				<label>Comentario del Entrevistador: '.$f['comentario'].'<br></label>
				<input type="hidden" name="comentario_anterior" value="'.$f['comentario'].'">
				<textarea name="comentario"></textarea>
			</div>
			<div class="cuadro_">';


			echo '<div id="mapa"></div>';


			$info= "['".ponerfoto("docs/solicitudes/foto_".$f['id'].".jpg",'icono')."<br>".$f['nombre']." ". $f['paterno']." ".$f['materno']." <BR> Solicito ".$f['apoyo']." el ".$f['fecha'].", Sol. ID: ".$f['id']."',".$f['lat'].",".$f['lon']."],";
























			echo '
				
			</div>
			<div>
			<input type="submit" name="submit_actualizar"class="Mbtn btn-default" value="Actualizar">
			</div>
		</form>


	';









				}else
				{
					mensaje("No se encontro el id para editar (".$id.")",'');
				}


					

			}else {




	if(isset($_POST['submit_actualizar']))
							{//VALIDAMOS Y ACUALIZAMOS
							$nombre = $_POST['nombre']; $paterno= $_POST['paterno']; $materno=$_POST['materno'];
							$curp_titular = $_POST['curp'];
							
							$nombre_conyugue = $_POST['nombre_conyugue']; $paterno_conyugue= $_POST['paterno_conyugue']; $materno_conyugue=$_POST['materno_conyugue'];
							$curp_conyugue = $_POST['curp_conyugue'];

							$domicilio = $_POST['domicilio']; $telefono = $_POST['telefono']; $ingreso = $_POST['ingreso'];
							$propiedad = $_POST['propiedad']; $apoyo = $_POST['apoyo']; $comentario = $_POST['comentario'];

							$comentario_anterior = $_POST['comentario_anterior'];
							$comentario = $comentario_anterior."<br>(".$fecha.", ".$hora.", Modifico:".nitavu_nombre($nitavu).")".$comentario."<br>";

							$lat = $_POST['lat']; $lon = $_POST['lon']; $acu=$_POST['acu'];

							$id = $_POST['id'];

							
						$subida="";		
						$archivo = 'docs/solicitudes/ife_a_'.$id;
						$subida= $subida.subir2('ife_frente', $archivo, 'jpg');

						$archivo = 'docs/solicitudes/ife_b_'.$id;
						$subida= $subida.subir2('ife_atras', $archivo, 'jpg');


						$subida2="";
						$archivo = 'docs/solicitudes/ife_a_conyugue'.$id;
						$subida2= $subida2.subir2('ife_frente_conyugue', $archivo, 'jpg');

						$archivo = 'docs/solicitudes/ife_b_conyugue'.$id;
						$subida2= $subida2.subir2('ife_atras_conyugue', $archivo, 'jpg');

						$archivo = 'docs/solicitudes/foto_'.$id;
						$subida2= $subida2.subir2('foto', $archivo, 'jpg');

							$sql="UPDATE solicitudes_jornada
							SET 
							nombre='$nombre', paterno='$paterno', materno='$materno', curp='$curp_titular', conyuge_nombre='$nombre_conyugue',
							conyuge_paterno='$paterno_conyugue', conyuge_materno='$materno_conyugue', curp_conyuge='$curp_conyugue', domicilio='$domicilio',
							propiedad='$propiedad', ingreso_familiar='$ingreso', telefono='$telefono', apoyo='$apoyo', comentario='$comentario'
							WHERE id='".$id."'";


							if ($conexion->query($sql) == TRUE)
							{ 
								historia($nitavu,"Actualizo una solicitud a ".$nombre." ".$paterno." ".$materno." con ID ".$id." de la Jornada Multidiciplinaria");
								mensaje ("Se ha ACTUALIZADO correctamente, con el ID ".$id.". <br> Puede continuar capturando...",'solicitudes_jornada.php');
							}
							else{ mensaje("Error al guardar notificacion (".$sql.")",'');}


								
		}//submit_actualizar
		else {	echo '<div class ="centrar_mensaje_padre"><div class = "centrar_mensaje_hijo">';
				buscar('solicitudes_jornada.php','Nombre:','');
				echo "</div></div>"; 
				}
		}
	
		}



	}// FIN NIVEL 2









	if ($nivel=='1'){//BUSQUEDA Y EDICION, Y VALIDACION. PUEDE AGREGAR COMENTARIO

		if (isset($_GET['busqueda'])){
			$sql = "select * from solicitudes_jornada where (
			nombre like'%".$_GET['busqueda']."%' or 
			paterno like'%".$_GET['busqueda']."%' or 
			materno like'%".$_GET['busqueda']."%' or 
			apoyo like'%".$_GET['busqueda']."%' or
			domicilio like'%".$_GET['busqueda']."%' or
			comentario like'%".$_GET['busqueda']."%' 
			

			) order by fecha, hora ASC";
			$r = $conexion -> query($sql);	$c = $r -> num_rows;
			//echo $sql;
			historia ($nitavu,"Busco ".$_GET['busqueda']." en las solicitudes de la jornada multidiciplinaria ITAVU DIF<br> app:".$id_aplicacion);
			if ($c<=0){//si no hay resultados
				echo '<div class ="centrar_mensaje_padre"><div class = "centrar_mensaje_hijo">';
				echo "<br> No se han encontrado nada con las palabras que usaste - ".$_GET['busqueda']." - "."<a href='digital.php'>Buscar nuevamente.</a>";
				echo "</div></div>";

				}	
			else {		
			$encontrados = "
			<h1>Busqueda sobre <b>".$_GET['busqueda']."</b></h1>
			<table class='tabla' border='0'>		
			<th class='pc'>ID</th>
			<th >Nombre</th>
			<th>Apoyo</th>
			<th class='pc'>Telefono</th>
			<th class='pc'>Comentario</th>
			<th></th>
			";
			while($d = $r -> fetch_array())
			{
			//$foto= ponerfoto("fotos/".$d['nitavu'].".jpg",'icono'); 
			$doc = "<tr>";
			$doc = $doc."<td class='pc'>".$d['id']."</td>";
			$doc = $doc."<td>".$d['nombre']." ".$d['paterno']." ".$d['materno']."</td>";
			$doc = $doc."<td>".$d['apoyo']."</td>";
			$doc = $doc."<td class='pc'>".$d['telefono']."</td>";
			$doc = $doc."<td class='pc'>".$d['comentario']."</td>";
			$doc = $doc."<td width='110px'>";
			$doc = $doc."<a href='solicitudes_jornada.php?edit=".$d['id']."'>Comentar</a>";
			
			$doc = $doc."</td>";
			$doc = $doc."</tr>";
			
			$encontrados=$encontrados.$doc;

			}//while
			$encontrados = $encontrados."</table>";

			echo "<section id='digitales'>";
			echo $encontrados;
			echo "</section>";
			}// else (no encontro)

		} else {

			if (isset($_GET['edit'])){
				//echo "Editar ".$_GET['edit'];
				$sql = "SELECT * from solicitudes_jornada WHERE id='".$_GET['edit']."'";
				$rc= $conexion -> query($sql);				
				if($f = $rc -> fetch_array())
					{
					echo '
					<form action="solicitudes_jornada.php" method="post" enctype="multipart/form-data">
					<input type="hidden" name="edit">
					<div class="cuadro_ fondo_tenue_map">
					<div>
						<label>ID de Solicitud</label>
						<input type="text" name="id" value="'.$_GET['edit'].'" readonly="readonly">
					</div>

					<div>
						<label>Nombre (Titular):</label>
						<input type="text" name="nombre" required="required" value="'.$f['nombre'].'" readonly="readonly">
					</div>
				
					<div>
						<label>Ap. Paterno (Titular):</label>
						<input type="text" name="paterno" required="required" value="'.$f['paterno'].'" readonly="readonly">
					</div>
				
					<div>
						<label>Ap. Materno (Titular):</label>
						<input type="text" name="materno" required="required" value="'.$f['materno'].'" readonly="readonly">
					</div>
					
					<div>
						<label>CURP (Titular):</label>
						<input type="text" name="curp" value="'.$f['curp'].'" readonly="readonly">
					</div>
				
				<div>';
				echo ponerfoto("docs/solicitudes/ife_a_".$f['id'].".jpg",'foto');
				echo '
					
					<label>Foto del credencial FRENTE (Titular):</label>
					<input type="file" name="ife_frente">
				</div>

				<div>';
				echo ponerfoto("docs/solicitudes/ife_b_".$f['id'].".jpg",'foto');
				echo '
					
					<label>Foto del credencial ATRAS (Titular):</label>
					<input type="file" name="ife_atras">
				</div>

					<div>';
			echo ponerfoto("docs/solicitudes/foto_".$f['id'].".jpg",'foto');
			echo '
				<label>Fotografia:</label>
				<input type="file" name="foto">
			</div>


				</div>


				<div class="cuadro_  fondo_tenue_amarillo">
					<div>
						<label>Nombre (Conyugue):</label>
						<input type="text" name="nombre_conyugue" value="'.$f['conyuge_nombre'].'" readonly="readonly">
					</div>
					<div>
						<label>Ap. Paterno (Conyugue):</label>
						<input type="text" name="paterno_conyugue" value="'.$f['conyuge_paterno'].'" readonly="readonly">
					</div>
					<div>
						<label>Ap. Materno (Conyugue):</label>
						<input type="text" name="materno_conyugue" value="'.$f['conyuge_materno'].'" readonly="readonly">
					</div>
					<div>
						<label>CURP (Conyugue):</label>
						<input type="text" name="curp_conyugue" value="'.$f['curp_conyuge'].'" readonly="readonly">
					</div>
					<div>';
						echo ponerfoto("docs/solicitudes/ife_a_conyugue".$f['id'].".jpg",'foto');
					
					echo '					
						<label>Foto del credencial FRENTE (Conyugue):</label>
						<input type="file" name="ife_frente_conyugue">
					</div>
					<div>';
						echo ponerfoto("docs/solicitudes/ife_b_conyugue".$f['id'].".jpg",'foto');
					echo '
						
						<label>Foto del credencial ATRAS (Conyugue):</label>
						<input type="file" name="ife_atras_conyugue">
					</div>
				</div>

		<div class="cuadro_  fondo_tenue_amarillo">		
		<div>
			<label>Domicilio:</label>
			<input type="text" name="domicilio" required="required" value="'.$f['domicilio'].'" readonly="readonly">
		</div>
		<div>
			<label>¿Cuanta con otra Propiedad?:</label>
			<select name="propiedad">';
			if ($f['propiedad']=="SI"){ echo '<option value="SI" selected="selected">SI</option>';}
			else {//echo '<option value="SI">SI</option>';
			}

			if ($f['propiedad']=="NO"){ echo '<option value="SI" selected="selected">NO</option>';}
			else {//echo '<option value="SI">NO</option>';
			}

			echo '
				
			</select>
			
		</div>
		<div>
			<label>Ingreso Familiar:</label>
			<input type="number" name="ingreso" min="1000" max="10000" step="1000" value="'.$f['ingreso_familiar'].'" readonly="readonly">
		</div>
		<div>
			<label>Telefono:</label>
			<input type="tel" name="telefono" required="required" value="'.$f['telefono'].'" readonly="readonly">
		</div>
		<div>
			<label>Apoyo solicitado: (si elige otros, especifique en los comentarios)</label>

			<select name="apoyo" required="required">
			';
			if ($f['apoyo']=="VIIVIENDA COMPLETA"){ echo '<option value="VIIVIENDA COMPLETA" selected="selected">VIIVIENDA COMPLETA</option>';}
			else {//echo '<option value="VIIVIENDA COMPLETA">VIIVIENDA COMPLETA</option>';
			}

			if ($f['apoyo']=="PISO"){ echo '<option value="PISO" selected="selected">PISO</option>';}
			else {//echo '<option value="PISO">PISO</option>';
			}

			if ($f['apoyo']=="BLOCK"){ echo '<option value="BLOCK" selected="selected">BLOCK</option>';}
			else {//echo '<option value="BLOCK">BLOCK</option>';
			}

			if ($f['apoyo']=="LAMINA"){ echo '<option value="LAMINA" selected="selected">LAMINA</option>';}
			else {//echo '<option value="LAMINA">LAMINA</option>';
			}

			if ($f['apoyo']=="TINACO"){ echo '<option value="TINACO" selected="selected">TINACO</option>';}
			else {//echo '<option value="TINACO">TINACO</option>';
			}

			if ($f['apoyo']=="TECNO CONCRETO"){ echo '<option value="TECNO CONCRETO" selected="selected">TECNO CONCRETO</option>';}
			else {//echo '<option value="TECNO CONCRETO">TECNO CONCRETO</option>';
			}

			if ($f['apoyo']=="CUARTO ADICIONAL"){ echo '<option value="CUARTO ADICIONAL" selected="selected">CUARTO ADICIONAL</option>';}
			else {//echo '<option value="CUARTO ADICIONAL">CUARTO ADICIONAL</option>';
			}

			if ($f['apoyo']=="OTRO"){ echo '<option value="OTRO" selected="selected">OTRO</option>';}
			else {//echo '<option value="OTRO">OTRO</option>';
			}

			echo '
				
			</select>
			</div>
			
		</div>


			<div>
				<label>Comentario del Entrevistador: '.$f['comentario'].'<br></label>
				<input type="hidden" name="comentario_anterior" value="'.$f['comentario'].'">
				<textarea name="comentario"></textarea>
			</div>
			<div class="cuadro_">
				';


			echo '<div id="mapa"></div>';


			$info= "['".ponerfoto("docs/solicitudes/foto_".$f['id'].".jpg",'icono')."<br>".$f['nombre']." ". $f['paterno']." ".$f['materno']." <BR> Solicito ".$f['apoyo']." el ".$f['fecha'].", Sol. ID: ".$f['id']."',".$f['lat'].",".$f['lon']."],";



				echo '



				
			</div>
			<div>
			<input type="submit" name="submit_actualizar"class="Mbtn btn-default" value="Actualizar">
			</div>
		</form>


	';









				}else
				{
					mensaje("No se encontro el id para editar (".$id.")",'');
				}


					

			}else {




	if(isset($_POST['submit_actualizar']))
							{//VALIDAMOS Y ACUALIZAMOS
							$nombre = $_POST['nombre']; $paterno= $_POST['paterno']; $materno=$_POST['materno'];
							$curp_titular = $_POST['curp'];
							
							$nombre_conyugue = $_POST['nombre_conyugue']; $paterno_conyugue= $_POST['paterno_conyugue']; $materno_conyugue=$_POST['materno_conyugue'];
							$curp_conyugue = $_POST['curp_conyugue'];

							$domicilio = $_POST['domicilio']; $telefono = $_POST['telefono']; $ingreso = $_POST['ingreso'];
							$propiedad = $_POST['propiedad']; $apoyo = $_POST['apoyo']; $comentario = $_POST['comentario'];

							$comentario_anterior = $_POST['comentario_anterior'];
							$comentario = $comentario_anterior."<br>(".$fecha.", ".$hora.", Modifico:".nitavu_nombre($nitavu).")".$comentario."<br>";

							$lat = $_POST['lat']; $lon = $_POST['lon']; $acu=$_POST['acu'];

							$id = $_POST['id'];

							
						$subida="";		
						$archivo = 'docs/solicitudes/ife_a_'.$id;
						$subida= $subida.subir2('ife_frente', $archivo, 'jpg');

						$archivo = 'docs/solicitudes/ife_b_'.$id;
						$subida= $subida.subir2('ife_atras', $archivo, 'jpg');


						$subida2="";
						$archivo = 'docs/solicitudes/ife_a_conyugue'.$id;
						$subida2= $subida2.subir2('ife_frente_conyugue', $archivo, 'jpg');

						$archivo = 'docs/solicitudes/ife_b_conyugue'.$id;
						$subida2= $subida2.subir2('ife_atras_conyugue', $archivo, 'jpg');

						$archivo = 'docs/solicitudes/foto_'.$id;
						$subida2= $subida2.subir2('foto', $archivo, 'jpg');

							$sql="UPDATE solicitudes_jornada
							SET 
							nombre='$nombre', paterno='$paterno', materno='$materno', curp='$curp_titular', conyuge_nombre='$nombre_conyugue',
							conyuge_paterno='$paterno_conyugue', conyuge_materno='$materno_conyugue', curp_conyuge='$curp_conyugue', domicilio='$domicilio',
							propiedad='$propiedad', ingreso_familiar='$ingreso', telefono='$telefono', apoyo='$apoyo', comentario='$comentario'
							WHERE id='".$id."'";


							if ($conexion->query($sql) == TRUE)
							{ 
								historia($nitavu,"Actualizo una solicitud a ".$nombre." ".$paterno." ".$materno." con ID ".$id." de la Jornada Multidiciplinaria");
								mensaje ("Se ha ACTUALIZADO correctamente, con el ID ".$id.". <br> Puede continuar capturando...",'solicitudes_jornada.php');
							}
							else{ mensaje("Error al guardar notificacion (".$sql.")",'');}


								
		}//submit_actualizar
		else {	

			echo '<div class ="centrar_mensaje_padre"><div class = "centrar_mensaje_hijo">';
				buscar('solicitudes_jornada.php','Buscar por nombre, apoyo, domicilio, comentario:','');

				echo grafica_pastel('apoyo','solicitudes_jornada','apoyo','APOYOS SOLICITADOS',400,400);
				//echo grafica_pastel('notificador_nitavu','notificadores_visitas','nitavu','APOYOS SOLICITADOS',400,400);
				//echo grafica_dona('notificador_nitavu','notificadores_visitas','nitavu');


				$total= 0;
				//$sql = "SELECT COUNT(DISTINCT nitavu) AS n FROM historia WHERE (fecha='".$fecha."')"; 
				$sql = "SELECT COUNT(*) as n from solicitudes_jornada";
				$rc= $conexion -> query($sql); if($f = $rc -> fetch_array()){$total = $f['n'];}	
			

				
				
				
				echo "</div></div>"; 


				}
		}
	
		}


	}// FIN NIVEL 2


}
else {
	mensaje("No tiene acceso a esta aplicacion",'');
}

?>



    <script type="text/javascript" src="https://maps.google.com/maps/api/js?sensor=true"></script>
    <script type="text/javascript">
    function initialize() {
       var marcadores = [
 		<?php 
 		echo $info;

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
		<script src="https://maps.googleapis.com/maps/api/js?key='.$key_mapkmz.'&callback=initMap"
		async defer></script>
		';
	?>

<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
<script type="text/javascript">
function pedirPosicion(pos) {
//document.write("¡Hola! Estas en : "+pos.coords.latitude+ ","+pos.coords.longitude);
//document.write(" Rango de localización de +/- "+pos.coords.accuracy+" metros");
//escribe los valores en los input id
document.getElementById('lat').value  =  pos.coords.latitude;
document.getElementById('lon').value  =  pos.coords.longitude;
document.getElementById('acu').value  =  pos.coords.accuracy;
var url = "https://maps.googleapis.com/maps/api/staticmap?autoscale=1&size=400x400&maptype=roadmap&format=jpg&visual_refresh=true&markers=size:mid%7Ccolor:0xff0000%7Clabel:1%7C";
//var url = "maps.google.com";
var lat = pos.coords.latitude;
var lon =  ",+"+pos.coords.longitude;
var key = "&key="+"AIzaSyCc2fdtBRrEiHBG4mEAIrFZ6kUrFbw3VL8";
var url_final = url.concat(lat, lon,key);
//alert(url_final);
//document.getElementById('img_map').src = "hola";
document.getElementById('img_map').src=url_final;
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
<?php include ("./lib/body_footer.php"); ?>