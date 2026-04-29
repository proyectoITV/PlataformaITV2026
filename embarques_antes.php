

<?php
include ("./lib/body_head.php"); include ("./lib/body_menu.php");
$id_aplicacion ="ap61"; 
$nivel =aplicacion_nivel($id_aplicacion, $nitavu);
$nivel=1;
//$nivel = 1;
//1 = Admin Gral       2= Admin     3 Operador Normal
echo "<div id='AppDetalle'>".app_detalle($id_aplicacion, $nitavu)."</div>";
if (sanpedro($id_aplicacion, $nitavu)==TRUE){    
	historia($nitavu, "[".$id_aplicacion."] Uso la app Embarques ");

	//BARRA DE MENU
	
	echo "<br><section id='submenu' style='margin-top:5px;'>";		
		if ($nivel==1){submenu_add('?permisos','asistencia.png','Administrar','Permisos');}
		if ($nivel==1){submenu_add('?guias','guias.png','Administrar','Guias');}
		if ($nivel==1){submenu_add('?estadistica','embarques_estadisticar.png','Estadisticas','');}
		submenu_add('?personal','cartero.png','Envio ','ITAVU');
		
		//if ($nivel==1){submenu_add('?foraneo','boton_foraneo.png','Registrar ','Foraneo');}
		//if ($nivel==2 or soytitular($nitavu)<>'FALSE'){submenu_add('?enviar','embarques_enviar.png','Registrar','Envio');}
		
	echo "</section>";
		


	if (isset($_GET['personal'])){ //MODULO CARTERO //--------------------------------------------------------
		echo "<br><br><br><br><table width=100%>";
		echo "<tr>";
		echo "<td width=30% align=left valign=top style='background-color:transparent;' class='pc'>";
			echo "<img src='icon/cartero.png' style='width:100%;'>";
		echo "</td>";

		echo "<td align=left valign=top>";
		echo "<h1>Envio de Paqueteria con Personal de ITAVU</h1>";

		echo "<form action='embarques.php?personal' method='POST' style='text-align:left;'>";
		echo "<div><input type='text' name='destino' value='' placeholder='Nombre del destino' required> </div>";
		echo "<div><input type='text' name='destino_domicilio' value='' placeholder='A que domicilio se enviara' required> </div>";
		echo "<div><input type='text' name='destino_telefono' value='' placeholder='Telefono del destino'> </div>";
		echo "<div><input type='text' name='destino_ciudad' value='' placeholder='Ciudad de Destino'> </div>";
		echo "<span><label>Describa el paquete que envia:</label><textarea name='destino_descripcion'></textarea></span>";
		
		if (isset($_GET['dpto'])){
			$midpto = $_GET['dpto'];
		} else {
			$midpto = nitavu_dpto($nitavu);		
		}


		echo '<div><select name="cartero" id="cartero" onchange="cartero2_llenar('.$midpto.');"  required>';
			$sql="select nitavu, nombre from empleados where estado='' and dpto='".$midpto."'";
			$r2 = $conexion -> query($sql);
			echo '<option value="">¿Quien entregara?</option>';
			while($f = $r2 -> fetch_array())		
			{	echo "<option value='".$f['nitavu']."'>".$f['nombre']."</option>";	}
			
			
		echo "</select></div>";	
		
		echo '<div id="div_cartero2"><select id="cartero2" name="cartero2" >';
			// $sql="select nitavu, nombre from empleados where estado='' and dpto='".$midpto."'";
			// $r2 = $conexion -> query($sql);
			// // echo "<option value=''>¿Quien mas entregara?</option>";
			// // while($f = $r2 -> fetch_array())		
			// // {	echo "<option value='".$f['nitavu']."'>".$f['nombre']."</option>";	}
			
			
		echo "</select></div>";	

		$npase_reservado = npase(FALSE);
		echo "<input type='hidden' name='npase' value='".$npase_reservado."'>";
		echo "<div><input type='submit' class='Mbtn btn-default' name='CarteroGuardar' value='Guardar (NPase ".$npase_reservado.")'></div>";
		
		
		
		echo "</form>";

		

		echo "</td>";
		echo "</tr>";
		echo "</table>";

		if (isset($_POST['CarteroGuardar'])){
			$npase = $_POST['npase'];
			if (paselibre($npase)==FALSE)
			{//solicitamos nuevamente un numero de pase
			$npase = npase(FALSE);}

			$sql = "INSERT INTO embarques_cartero 
			(idpase, asignacion, asignacion2, registro, registro_fecha, registro_hora, origen, 
			destino, destino_ciudad, destino_telefono, destino_domicilio, descripcion) 
			VALUES 
			(
				'".$npase."', '".$_POST['cartero']."', '".$_POST['cartero2']."', '".$nitavu."', '".$fecha."', '".$hora."', '".$midpto."',
				'".$_POST['destino']."', '".$_POST['destino_ciudad']."', '".$_POST['destino_telefono']."', '".$_POST['destino_domicilio']."',
				'".$_POST['destino_descripcion']."'

			)";
			if ($conexion->query($sql) == TRUE){
				historia($nitavu,"Agrego un nuevo envio para ".$_POST['destino']." en ".$_POST['destino_domicilio'].", ".$_POST['destino_ciudad'].", con ".nitavu_nombre($_POST['cartero']).",".nitavu_nombre($_POST['cartero2']));
				$descripcion = "<p>".$_POST['destino_descripcion']."</p><p>DESTINO: <b>".$_POST['destino']."</b><br>DOMICILIO: <b>".$_POST['destino_domicilio']."</b>
				<br>CIUDAD:<b>".$_POST['destino_ciudad']."</b><br>TELEFONO:<b>".$_POST['destino_telefono']."</b>";
				
				$okPase = CrearPase($npase, $_POST['cartero'], $hora, $descripcion, $_POST['destino'],$nitavu);
				if ($okPase ==TRUE){historia($nitavu,"Solicito Pase de Salida para entregar paqueteria ".$_POST['destino']." para ".nitavu_nombre($_POST['cartero'])." con NPASE: ".$npase);}
				


				if ($_POST['cartero2']==''){} else {
					
					$okPase2 = CrearPase(npase(FALSE), $_POST['cartero2'], $hora, $descripcion, $_POST['destino'], $nitavu);
					if ($okPase2 ==TRUE){historia($nitavu,"Solicito Pase de Salida para entregar paqueteria ".$_POST['destino']." para ".nitavu_nombre($_POST['cartero2'])." con NPASE: ".$npase);}
					
				}

				mensaje("Se ha guardado con exito (".$_POST['cartero2'].")",'embarques.php?personal');
			}
			else {mensaje("ERROR: al guardar envio con personal de itavu:<br>Toma una foto o imprime pantalla, e informa al Dpto. de Informatica.<br>".$sql,'');}

		}
		echo "<hr class='punteado'>";
		if (isset($_GET['VF']) and isset($_GET['VFclose'])) {			
			ltbox_foto($nitavu, $_GET['VF'], $_GET['VFclose']);
		}
						
		if (isset($_GET['busqueda'])){
				echo "<h1>Resultados de busqueda de <b>".$_GET['busqueda']."</b>:</h1>";
			$sql="select 
				embarques_cartero.idpase as NPase,
				(select autorizo_nitavu from empleados_salidas_temporal where empleados_salidas_temporal.id = NPase) as OK,
				(select nombre from empleados where empleados.nitavu=embarques_cartero.asignacion) as Asignacion1,
				(select nombre as nombre2 from empleados where empleados.nitavu=embarques_cartero.asignacion2) as Asignacion2,	
				embarques_cartero.destino,
				(select justificacion from empleados_salidas_temporal where empleados_salidas_temporal.id = NPase) as Descripcion,
				(select recibido from empleados_salidas_temporal where empleados_salidas_temporal.id = NPase) as Recibido,
				registro_fecha, embarques_cartero.origen,
				(select rechazada from empleados_salidas_temporal where empleados_salidas_temporal.id = NPase) as rechazada,
				embarques_cartero.recibido_img
				
			from 
				embarques_cartero
			WHERE
			DATE_FORMAT(registro_fecha, '%m') = DATE_FORMAT(now(), '%m') 
			and origen ='".$midpto."'
			and descripcion like'%".$_GET['busqueda']."%'
			";
		} else {
				echo "<h1>Envios de este mes:</h1>";
		$sql="select 
				embarques_cartero.idpase as NPase,
				(select autorizo_nitavu from empleados_salidas_temporal where empleados_salidas_temporal.id = NPase) as OK,
				(select nombre from empleados where empleados.nitavu=embarques_cartero.asignacion) as Asignacion1,
				(select nombre as nombre2 from empleados where empleados.nitavu=embarques_cartero.asignacion2) as Asignacion2,	
				embarques_cartero.destino,
				(select justificacion from empleados_salidas_temporal where empleados_salidas_temporal.id = NPase) as Descripcion,
				(select recibido from empleados_salidas_temporal where empleados_salidas_temporal.id = NPase) as Recibido,
				registro_fecha, embarques_cartero.origen,
				(select rechazada from empleados_salidas_temporal where empleados_salidas_temporal.id = NPase) as rechazada,
				embarques_cartero.recibido_img
				
			from 
				embarques_cartero
			WHERE
			DATE_FORMAT(registro_fecha, '%m') = DATE_FORMAT(now(), '%m') 
			and origen ='".$midpto."'
			";
		}
	
		echo "<table class='tabla'>";
		
		echo "<th>NPase</th>";  echo "<th class='pc'>Asignacion</th>"; echo "<th>Destino</th>"; echo "<th class='pc'>Descripcion</th>";
		echo "<th class='pc'>Recibido</th>"; echo "<th></th>";
		$ed="";	
		//echo $sql;
		$r2 = $conexion -> query($sql);
		$r_count2 = $r2 -> num_rows;
if($r_count2>0){
			while($f = $r2 -> fetch_array())		
			{	
			$ed="";
			if ($f['rechazada']=='TRUE'){
				echo "<tr style='background-color:red;'>"; //roja
				$ed="Rechazada por ".nitavu_nombre($f['OK'])."";
			} else {
				if ($f['OK']<>''){
					echo "<tr style='background-color:#00CC33;'>"; //verde
					$ed="Aprobada por ".nitavu_nombre($f['OK'])."";
				} else {
					echo "<tr>"; //normal
				}
			}
				
				echo "<td>".$f['NPase']."<br>".$f['registro_fecha']."</td>";
				
				echo "<td class='pc'>";
					if ($f['Asignacion2']==''){
						echo $f['Asignacion1'];
					}else {
						echo $f['Asignacion1']." y ".$f['Asignacion2'];
					}
				echo "</td>";
				echo "<td>".$f['destino']."</td>";
				echo "<td class='pc'>";
				echo "<p style='width:90%; font-size:8pt; '>";
				$DescripcionNew = str_replace(",", ", ", $f['descripcion']); //agrega espacios despues de la coma
				echo "<p style='width:90%; font-size:8pt; '>".$DescripcionNew."</p>";

				echo $ed."</td>";
				echo "<td class='pc' width='200px'>";
				echo $f['Recibido'];
				
					if ($f['Recibido']==''){
						echo "<form name='carteroForm' id='carteroForm' action='embarques.php?personal' method='POST' enctype='multipart/form-data' style='width:100%;'>";
						echo '<input type="file" name="file_recibido" id="file_recibido" onchange="recibido_fl();" class=""  accept=".jpg">';
						echo "<input type='text' name='recibido_text' placeholder='Descripcion del Envio' >";
						echo "<input type='hidden' value='".$f['NPase']."' name='NPase'>";
						echo "<input type='submit' value='Guardar' name='recibido_g' class='Mbtn btn-tercero'>";
						echo "</form>";
					}
					else {//mostramos la imagen de recibido
						echo "<br>";
						$src="embarques_carteroimg.php?NPase=".$f['NPase'].""; 
						$src= ponerfoto_src('img_embarques/'.$f['NPase'].'','foto');
						//echo "src=".$src."<br>";
						$origen="embarques.php?personal";
						//echo "<a href='".$src."&VFclose=".$origen."' ' title='Imprimir' class='Mbtn btn-default'>Imprimir</a>";
						
						echo '<a href="?personal&VF='.$src.'&VFclose='.$origen.'" title="Haga clic aqui para visualizarla">';
						echo ponerfoto('img_embarques/'.$f['NPase'],'foto');
						echo '</a>';
						


						//echo "<a href='embarques_img/".$f['NPase']."'><img src='embarques_carteroimg.php?NPase=".$f['NPase']."' class='foto'></a>";

					}
				

				echo "</td>";
				echo "<td>";
				echo "<a href='embarques_cartero_print.php?nuc=".$nitavu."&guia=".$f['NPase']."' class='Mbtn btn-default'>imprimir</a>";
				echo "</td>";
				echo "</tr>";
				
			}

		}
		echo "</table>";
		$tmp="";
		if (isset($_POST['recibido_g'])){
			if (  !empty( $_FILES['file_recibido']['name']) && !empty($_FILES['file_recibido']['tmp_name'])  ) 
			{
				if($_FILES["file_recibido"]["type"]=="image/jpeg"){//que solo acepte imagen			
					$tmp="<br>Operacion de recibido por ".nitavu_nombre($nitavu)." el ".$fecha." a las ".$hora;
					$imagen="";
					if (subir('file_recibido', 'img_embarques/'.$_POST['NPase'].'','jpg')=='Archivo subido con exito.!!'){$imagen='Imagen subida con exito';}
					//$imagen = $conexion->real_escape_string(file_get_contents($_FILES["file_recibido"]["tmp_name"]));
					
					$sql="UPDATE embarques_cartero SET recibido='".$_POST['recibido_text'].$tmp."' WHERE idpase='".$_POST['NPase']."'";	

					if ($conexion->query($sql) == TRUE)
						{	
							historia($nitavu, "Registro recibido el envio con id NPASE=".$_POST['NPase']);
							//notificacion_add ($_POST['empleado'], 'Acceso a '.app_nombre($id_aplicacion), $fecha, $nitavu, "Le he ortorgado permiso para usar la aplicacion de ".app_nombre($id_aplicacion)." de la Plataforma ITAVU.".$app_reso);
							mensaje("Operacion de Recibido, hecha correctamente .".$imagen,'embarques.php?personal');
						}
					else {
						//historia($nitavu, "Dio permiso para usar [".$id_aplicacion."] ".app_nombre($id_aplicacion)." a ".$_POST['empleado'].", ".nitavu_nombre($_POST['empleado'])."<hr>".$sql);				
						mensaje("ERROR: al crear recibido <br> ".$sql,'embarques.php?personal');
					}
				} else 
					{mensaje("ERROR: Tipo de archivo no permitido, solamente se aceptan .JPG",'embarques.php?personal');}

				}
				else {mensaje("ERROR: al recibir el archivo",'embarques.php?personal');}

			

		}

		
		echo "<br><br>";
		buscar('embarques.php?personal', 'Buscar en mis envios', 'personal');

	}// FIN DE MODULO CARTERO ----------------------------------------------------------

	

	if (isset($_GET['enviar'])){//si le dieron clic al boton registrar envio
		echo '<form action="embarques.php?enviar" method="POST" enctype="multipart/form-data" style="background-color:#FFF0D2; border: 1px dashed #FFCC66; margin-top:0px; padding-top:10px;" >';
		echo "<h1>Asignación de Envio: </h1>";	
		echo "<div><input type='text' name='guia' value='".$_GET['enviar']."' readonly></div>";
		
		echo "<div><select name='destino'>";
			$tipoDpto = EstoyenDelegacion($nitavu);
			if ($tipoDpto == 'del'){// soy delegacion
				$sql = "SELECT * FROM cat_gerarquia where id<>0 and nivel = 'del' and id<>".nitavu_dpto($nitavu)." and id<>45
				union
				SELECT * FROM cat_gerarquia where id<>0 and id=59 and id<>".nitavu_dpto($nitavu)." and id<>45 order by dependencia DESC";
			} else {
				$sql = "SELECT * FROM cat_gerarquia where id<>0";
			}
			$guia_dpto = "";
			echo $sql;
			$r2 = $conexion -> query($sql);
			while($f = $r2 -> fetch_array())		
			{	
					if ($f['id']==$guia_dpto){		
						if ($f['id']==59){		
							echo "<option value='".$f['id']."' selected>Oficinas Centrales</option>";
						} else {
							echo "<option value='".$f['id']."' selected>".$f['nombre']."</option>";
						}
					} else {
						if ($f['id']==59){
							echo "<option value='".$f['id']."'>Oficinas Centrales</option>";
						}
						else {
							echo "<option value='".$f['id']."'>".$f['nombre']."</option>";
						}
						
					}
				
			}
		echo "</select></div>";	

		echo "<span><textarea name='descripcion'></textarea></span>";
		echo "<div><label>fotografia (Opcional)</label><input type='file' name='foto'></div>";
		echo "<div><label class='pc'>No olvide, incluir en el paquete el Ticket de Envio</label><input type='submit' name='guardar_envio' value='Asignar Envio' class='Mbtn btn-default'></div><hr>";

		echo '</form>';
		$url="";
		if (isset($_POST['guardar_envio'])){//GUARDAR REGISTRO DEL ENVIO-----------------------------
			//update
			$sql="UPDATE embarques_guias SET destino='".$_POST['destino']."', descripcion='".$_POST['descripcion']."' WHERE guia='".$_POST['guia']."'";
					if ($conexion->query($sql) == TRUE)
						{	
						$img="";					
						$archivo='img_embarques/'.$_POST['guia']."_";
						$imgx = subir('foto', $archivo,'');
						//echo "<h1>".$imgx."</h1>";
						if ($imgx=='Archivo subido con exito.!!'){
							
							$img = ponerfoto_correo($archivo,'');
							historia($nitavu, "[".$id_aplicacion."] subio la foto para embarques con guia ".$_POST['guia']."<br>".$img);							
						}

						//ciclo de dpto destino
						$url=embarque_rastreo_url($_POST['guia']);
						$dpto_origen = embarque_origen($_POST['guia']);
						$dpto_origen = dpto_id($dpto_origen);
						$descripcion = embarque_descripcion($_POST['guia']);

						$titular=titular($_POST['destino']);

						$contenido = "<p>Buen dia <b>"."</b>:</p>";
							$contenido = $contenido."<p>"."He enviado un paquete a tu departamento  desde <b>".$dpto_origen."</b>, podras recibirlo y registrar su recepcion con el TOKEN(codigo de envio) que he puesto dentro del paquete."."</p><p>".$descripcion."</p>";
							$contenido = $contenido."<p style=background-color:#FFD5AA;border-color:#FF9966;border-radius:4px;border-style:solid;border-width:1px;
							padding:5px;font-size:10pt;color:#FF6600;>"."La guia es: <b>".$_POST['guia']."</b>. Podras consultar su rastreo en la pagina 
							<a href=".$url.">".$url."</a></p></p>En caso de tardar demasiado, informar al departamento de Rec. Materiales</p>";
							$contenido = $contenido."<p>"."Saludos, y está atento al paquete seguro no tardara."."</p>";
							
							$contenido = $contenido."<p style=background-color:#DDFFFF;border-color:#79FFFF;border-radius:4px;border-style:solid;border-width:1px;
							padding:5px;font-size:8pt;color:#009595;>
							"."* Si no te ha llegado el correo de esta notificación, verifica que este activado. Te aconsejamos tambien configures tu correo en tu telefono, asi te informaremos de este y otro tipo de notificaciones referentes al Instituto. Cualquier duda, comlibrse al Dpto. de Informatica"."</p>";
							
							$contenido = $contenido."<p>".$img."</p>";


						$sql2="select 
							nitavu as usuario,
							aplicaciones_permisos.*,
							(select dpto from empleados where nitavu=usuario) as dpto

						from aplicaciones_permisos where idapp='ap61' and nivel=2 
						";	$r2 = $conexion -> query($sql2);
						//echo $sql2;
						 while($d = $r2 -> fetch_array())
						 {	
							if ($d['dpto']==$_POST['destino']){//solo a los destino con permiso
								notificacion_add ($d['nitavu'], 'Paquete de '.$dpto_origen.' | guia: '.$_POST['guia'], $fecha, $nitavu, $contenido);
								historia($d['nitavu'], "Se le notifico: ".$contenido.$sql2);
							}
						 }
						//fin ciclo dpto destino
						//notificacion_add ($d['nitavu'], 'Paquete de '.$dpto_origen.' | guia: '.$_POST['guia'], $fecha, $nitavu, $contenido);
						
						notificacion_add ($titular, 'Paquete de '.$dpto_origen.' | guia: '.$_POST['guia'], $fecha, $nitavu, $contenido);
						historia($titular, "Se le notifico: ".$contenido.$sql2);
						historia($nitavu, "Realizo el registro de envio de la guia <b>".$_POST['guia']."</b> a ".dpto_id($_POST['destino'])."");										
						mensaje("Registro de Envio, correctamente.<br>Imprima el Ticket de envio.<br>En Donde esta el <b>token (codigo de envio)</b> que utilizara, el destino para registrar su recepcion.",'embarques.php');
					}

					else {
							historia($nitavu, "ha habido un ERROR en la aplicacion de EMBARQUES al intentar actualizar. ".$sql);
							mensaje("Error al intentar actualizar: ".$sql,'');

					}


			//envio a correo al todo el departamento, para que esten enterados y puedan recibir el paquete


		}//FIN DE GUARDAR REGISTRO DE ENVIO--------------------------------------------------------------


	}


	
	if (isset($_GET['foraneo']) and ($nivel==1)){//si le dieron clic al boton registrar envio
		echo '<form action="embarques.php?foraneo" method="POST" enctype="multipart/form-data" style="background-color:#AADBFF; border: 1px dashed #004C85; margin-top:0px; padding-top:10px;" >';
		echo "<h1>Asignación de Envio Foraneo (fuera de ITAVU): </h1>";	
		echo "<div><input type='text' name='guia' value='".$_GET['foraneo']."' readonly></div>";
		
		echo "<div>"."<input type='text' name='destino' placeholder='Nombre del Destino'>"."</div>";
		echo "<div>"."<input type='text' name='domicilio' placeholder='Domicilio (no olvide incluir el CP)'>"."</div>";
		echo "<div>"."<input type='text' name='telefono' placeholder='Telefono'>"."</div>";
		echo "<div>"."<input type='text' name='ciudad' placeholder='Ciudad'>"."</div>";
		
		echo "<span><label>Descripcion:</label><textarea name='descripcion'></textarea></span>";
		echo "<div><label>fotografia (Opcional)</label><input type='file' name='foto'></div>";
		echo "<div><label class='pc'>No olvide, incluir en el paquete el Ticket de Envio</label><input type='submit' name='guardar_envioforaneo' value='Guardar' class='Mbtn btn-default'></div><hr>";

		echo '</form>';
		$url="";
		if (isset($_POST['guardar_envioforaneo'])){//GUARDAR REGISTRO DEL ENVIO-----------------------------
			//update
			$sql="UPDATE embarques_guias SET destino='".$_POST['destino']."', 
			foraneo='1', ciudad='".$_POST['ciudad']."', domicilio='".$_POST['domicilio']."', telefono='".$_POST['telefono']."',
			descripcion='".$_POST['descripcion']."', autorizo='".$nitavu."' WHERE guia='".$_POST['guia']."'";
					if ($conexion->query($sql) == TRUE)
						{	
						$img="";					
						$archivo='img_embarques/'.$_POST['guia']."_";
						$imgx = subir('foto', $archivo,'');
						//echo "<h1>".$imgx."</h1>";
						if ($imgx=='Archivo subido con exito.!!'){
							
							$img = ponerfoto_correo($archivo,'');
							historia($nitavu, "[".$id_aplicacion."] subio la foto para embarques con guia ".$_POST['guia']."<br>".$img);							
						}

						$contenido='<p>Ya estan listos los datos para que envies la guia que has solitado</p>';
						notificacion_add (embarque_asignado($_POST['foraneo']), 'Ya esta lista tu guia foranea '.$_POST['foranea'], $fecha, $nitavu, $contenido);
						//historia($titular, "Se le notifico: ".$contenido.$sql2);
						historia($nitavu, "Realizo cambio de envio a foraneo de la guia<b>".$_POST['foraneo']."</b> ");										
						mensaje("Registro de guia foranea, correctamente.<br>Se le ha avisado al responsable",'embarques.php');
					}

					else {
							historia($nitavu, "ha habido un ERROR en la aplicacion de EMBARQUES foraneo al intentar actualizar. ".$sql);
							mensaje("Error al intentar actualizar: ".$sql,'');

					}


			//envio a correo al todo el departamento, para que esten enterados y puedan recibir el paquete


		}//FIN DE GUARDAR REGISTRO DE ENVIO--------------------------------------------------------------


	}



    if ($nivel=='1'){
        //Generar Permisos de Acceso 
		//lista de guias con asignacion activas


	}
	

	









	if (isset($_GET['recibir'])){//si le dieron clic al boton registrar envio
	
	if (embarque_recibido($_GET['recibir'])==''){
		
		if (nitavu_dpto($nitavu) <> embarque_destino($_GET['recibir']) and $_GET['recibir']<>''){
			historia($nitavu, "[".$id_aplicacion."] Intento usar la guia  ".$_GET['guia']." que es de otro departamento");							
			mensaje("ERROR: No esta autorizado a recibir el paquete con Guia ".$_GET['guia']." ya que es de otro departamento",'embarques.php');
		}

		echo '<form action="embarques.php?recibir" method="GET"  style="background-color:#D9FFD9; margin-top:0px; padding-top:10px; border-color:#66CC33; border-style:solid;border-width:1px;" >';
		echo "<h1>Registrar Recepcion</h1>";	
		echo "<input type='hidden' name='recibir' value='".$_GET['recibir']."'>";
		echo "<div><label>GUIA: </label><input style='background-color:#CCEEFF;border-color:#006666;border-style:solid;border-width:1px;' type='text' name='guia' value='".$_GET['recibir']."' readonly></div>";
		
		echo "<div><label>El Codigo de envio, esta impreso dentro del paquete, escriabalo aqui</label>";
		echo "<input type='text' name='token' value='' placeholder='Codigo de Envio'>";
		echo "</div>";	

		echo "<span><label>comentarios (opcional):</label><textarea name='descripcion'></textarea></span>";
		
		echo "<div><label class='pc'></label><input type='submit' name='guardar_envio' value='Registrar Recepcion' class='Mbtn btn-default'></div>";

		echo '</form>';
		$url="";
		if (isset($_GET['token']) and isset($_GET['guia'])){//GUARDAR REGISTRO de recepcion-----------------------------

			//VALIDACION DEL TOKEN
			$token_valido = embarque_codigo($_GET['guia']);
			if ($_GET['token']==$token_valido){
				//MARCAMOS COMO RECIBIDA mensaje("CORRECTO: El codigo de envio no <b>".$_GET['token']."</b> no corresponde a este paquete.",'embarques.php?recibir='.$_GET['recibir'].'&guia='.$_GET['recibir']);
				//update
				$descripcion_a = embarque_descripcion($_GET['guia']);
				$descripcion = $descripcion_a."<hr>".$nitavu."-".nitavu_nombre($nitavu).":<br>".$_GET['descripcion'];
				
				$sql="UPDATE embarques_guias SET recibido='".$nitavu."', descripcion='".$descripcion."', recibio_fecha='".$fecha."', recibio_hora='".$hora."' WHERE guia='".$_GET['guia']."'";
						if ($conexion->query($sql) == TRUE)
							{	

							//ciclo de dpto destino
							$dpto_origen = embarque_origen($_GET['guia']);
							$titular = titular($dpto_origen);
							$dpto_origen = dpto_id($dpto_origen);
							
							$contenido = "<p>Te aviso <b>".nombre_corto($titular,0)."</b>:</p>";
								$contenido = $contenido."<p>"."Ya recibimos tu paquete </b>, que nos enviaste de ".$dpto_origen."</b>,Gracias. <img src=".$urlsite."/txtplus/emoticons/smile.gif style=width:12px;></p>";
								$contenido = $contenido."<p style=background-color:#FFD5AA;border-color:#FF9966;border-radius:4px;border-style:solid;border-width:1px;
								padding:5px;font-size:10pt;color:#FF6600;>"."<b>".$descripcion."</b></p>";
								notificacion_add ($titular, 'Paquete de '.$dpto_origen.' | guia: '.$_GET['guia'], $fecha, $nitavu, $contenido);

								
							historia($nitavu, "Recibio paquete con guia <b>".$_GET['guia']."</b> ");										
							mensaje("Se ha Registrado la Recepcion del paquete con guia ".$_GET['guia']." <br>".$descripcion,'embarques.php');
						}

						else {
								historia($nitavu, "ha habido un ERROR en la aplicacion de EMBARQUES al intentar recibir paquete. ".$sql);
								mensaje("ERROR: ".$sql,'');
								//echo "<code>".$sql."</code>";

						}

			} else {
				mensaje("ERROR: El codigo de envio  <b>".$_GET['token']."</b>  no corresponde a este paquete.",'embarques.php?recibir='.$_GET['recibir'].'&guia='.$_GET['recibir']);
			}
			
		}//FIN DE GUARDAR REGISTRO repcepcion--------------------------------------------------------------
	}
	else{
		mensaje("ERROR: Este paquete con guia ".$_GET['recibir']." ya fue recibido por ".nitavu_nombre(embarque_recibido($_GET['recibir'])),'embarques.php');
	}

	}











	
    if (isset($_GET['guias']) and  ($nivel=='1') and !isset($_GET['foraneo'])){

		if (isset($_GET['act'])){	
		echo "<form action='embarques.php?guias=' method='post' style='background-color:#FFE8E8;border-bottom-color:#FF6699;border-bottom-style:dashed;border-bottom-width:1px;border-top-color:#FF6699;border-top-style:dashed;border-top-width:1px;'>";
		echo "<h1>Actualizar guia:</h1>";
		}
		else{
		echo "<form action='embarques.php?guias=' method='post' style='background-color:#E5E5E5;border-bottom-color:#C8C8C8;border-bottom-style:dashed;border-bottom-width:1px;border-top-color:#C8C8C8;border-top-style:dashed;border-top-width:1px;'>";
		echo "<h1>Registrar guia: </h1>";
			
		}
		$guia=""; $proveedor=""; $guia_dpto="";
		if (isset($_GET['act'])){		
			$sql = "SELECT * FROM embarques_guias WHERE (guia='".$_GET['act']."')";
			$rc= $conexion -> query($sql);
			if($f = $rc -> fetch_array())
			{
				$guia = $_GET['act']; $proveedor=$f['paqueteria_id']; $guia_dpto=$f['origen'];			
			} 			
		}

		if (isset($_GET['act'])){	
			echo "<div>"."<input type='text'  name='guia' placeholder='Numero de Guia' value='".$guia."' readonly style='background-color:#CCEEFF;border-color:#006666;border-style:solid;border-width:1px;'>"."</div>";
		}
		else 
		{
			echo "<div>"."<input type='text'  name='guia' placeholder='Numero de Guia' value='".$guia."' required style='background-color:#CCEEFF;border-color:#006666;border-style:solid;border-width:1px;'>"."</div>";
		}
				
		echo "<div><select name='proveedor'>";
			$r2 = $conexion -> query("SELECT * FROM embarques_proveedores");
			while($f = $r2 -> fetch_array())		
			{	if ($f['id']==$proveedor){
					echo "<option value='".$f['id']."' selected>".$f['nombre']."</option>";
				} else {echo "<option value='".$f['id']."'>".$f['nombre']."</option>";}
				
			}
		echo "</select></div>";	
		
		echo "<div><select name='asignacion'>";
			$r2 = $conexion -> query("SELECT * FROM cat_gerarquia where id<>0");
			while($f = $r2 -> fetch_array())		
			{	if ($f['id']==$guia_dpto){
				echo "<option value='".$f['id']."' selected>".$f['nombre']."</option>";
				} else {echo "<option value='".$f['id']."'>".$f['nombre']."</option>";}
				
			}
		echo "</select></div>";	

		
		if (isset($_GET['act'])){		
			echo "<div>"."<input type='submit' name='actualizar_guia' value='Actualizar' class='Mbtn btn-default'>"."</div>";	
		} else {
			echo "<div>"."<input type='submit' name='guardar_guia' value='Registrar' class='Mbtn btn-default'>"."</div>";
		}
		
		echo "</form>";

		$asignacion="";
		if (isset($_POST['actualizar_guia'])){//ACTUALIZAR GUIA------------
		$asignacion=''; //asignacion = titular y si no lo hay alguien que tenga permiso admin 2
				$asignacion = titular($_POST['asignacion']);
				if ($asignacion=='FALSE' or $asignacion==''){//sin titular
					$asignacion= aplicacion_nivel_quien($id_aplicacion,'2');
					if ($asignacion==''){// sin titular y sin permisos
					}
				}
			
				if ($asignacion=='' or $asignacion=='FALSE'){// sin titular y sin permisos
					mensaje("No se puede asignar porque no hay nadie con permiso en dicho dpto, o no tiene un titular. ".$_POST['asignacion'],'embarques.php?act='.$_GET['act']);
				}else{
					$sql="UPDATE embarques_guias SET asignacion='$asignacion', registro='$nitavu', registro_fecha='$fecha',
					registro_hora='$hora', origen='".$_POST['asignacion']."', paqueteria_id='".$_POST['proveedor']."'  WHERE guia='".$_POST['guia']."'";
					if ($conexion->query($sql) == TRUE)
						{	
						$reso_paqueteria="<p>Use la guia que se le ha asginado a su consideración, solo el titular de su departamento o a quien le haya asignado el permiso por parte de Rec. Materiales
						podra registrar un Envio, que es la manera de indicar a que área va dirigido su paquete y para que éste atento a su llegada. Cualquier personal de su departamento podrá recibir 
						paqueteria enviada a usted y registrar su recepción. </p> <p></p>";
						$contenido = "<p>Buen dia <b>".nombre_corto($asignacion,0)."</b>:</p>";
						$contenido = $contenido."<p>Le he asignado la guia con numero ".$_POST['guia']." de ".embarque_proveedor($_POST['proveedor'])."</p>".$reso_paqueteria;
						notificacion_add ($asignacion, 'GUIA: '.$_POST['guia'], $fecha, $nitavu, $contenido);
							historia($nitavu, "Re-Asigno la guia ".$_POST['guia']." para Embarques,  a ".nitavu_nombre($asignacion)." de ".nitavu_dpto_nombre($asignacion)."");
							mensaje("Guia ".$guia." actualizada correctamente",'embarques.php?guias=');}
					else {
							historia($nitavu, "ha habido un ERROR en la aplicacion de EMBARQUES al intentar actualizar. ".$sql);
							mensaje("Error al intentar actualizar: ".$sql,'');

					}
				}

		
		}//........ fin act
		
		if (isset($_POST['guardar_guia'])){//GUARDAR GUIA NUEVA			-------------			
			$sql = "SELECT * FROM embarques_guia WHERE guia='".$_POST['guia']."'";
			if ($conexion->query($sql) == TRUE) {
				$rc= $conexion -> query($sql);
				if($f = $rc -> fetch_array())
				{
				mensaje("Ya existe reguisto de este numero de guia, con una asignacion a ".nitavu_nombre($f['asignacion']),'embarques.php?guias=');
				}
			}
			else
			{//si no esta podemos agregarlo
				$asignacion=''; //asignacion = titular y si no lo hay alguien que tenga permiso admin 2
				$asignacion = titular($_POST['asignacion']);
				//echo "===".$asignacion."|".$_POST['asignacion'];
				if ($asignacion=='FALSE' or $asignacion==''){//sin titular
					$asignacion= aplicacion_nivel_quien($id_aplicacion,'2');
					//echo "===".$asignacion."";
					if ($asignacion==''){// sin titular y sin permisos


					}

				}
			
				if ($asignacion=='' or $asignacion=='FALSE'){// sin titular y sin permisos
					mensaje("--No se puede asignar porque no hay nadie con permiso en dicho dpto, o no tiene un titular",'embarques.php?guias=');
				}else{
					$sql = "INSERT INTO embarques_guias (guia, asignacion, registro, registro_fecha, registro_hora, paqueteria_id, token, origen) 
					VALUES ('".$_POST['guia']."', '".$asignacion."','".$nitavu."', '".$fecha."', '".$hora."', '".$_POST['proveedor']."','".token_correo(FALSE)."','".$_POST['asignacion']."')";
					
					if ($conexion->query($sql) == TRUE)
					{
						historia($nitavu, "Registro la guia <b>".$_POST['guia']."</b> para Embarques,  a ".nitavu_nombre($asignacion)." de ".nitavu_dpto_nombre($asignacion)."");
						$reso_paqueteria="<p>Use la guia que se le ha asginado a su consideración, solo el titular de su departamento o a quien le haya asignado el permiso por parte de Rec. Materiales
						podra registrar un Envio, que es la manera de indicar a que área va dirigido su paquete y para que éste atento a su llegada. Cualquier personal de su departamento podrá recibir 
						paqueteria enviada a usted y registrar su recepción. </p> <p></p>";
						$contenido = "<p>Buen dia <b>".nombre_corto($asignacion,0)."</b>:</p>";
						$contenido = $contenido."<p>Le he asignado la guia con numero ".$_POST['guia']." de ".embarque_proveedor($_POST['proveedor'])."</p>".$reso_paqueteria;
						notificacion_add ($asignacion, 'GUIA: '.$_POST['guia'], $fecha, $nitavu, $contenido);
						mensaje("Guia registrada correctamente",'embarques.php?guias=');
					}
					else {
						historia($nitavu, "ERROR en EMBARQUES: ".$sql);
						mensaje("Ha habido un error al guardar la guia, no se ha guardado<br>Puede deberse a que ha escrito mal el no. de guia o que ya este usada; <br> Vuelva a intentarlo.".$sql,'embarques.php?guias=');
					}
				}

			}
			//(1t4vu-14n)
		}

		//lista de guias con asignacion activas
		if (isset($_GET['busqueda'])){
			$r2 = $conexion -> query("SELECT * FROM embarques_guias WHERE guia like '%".$_GET['busqueda']."%'  order by registro_fecha LIMIT 0,100");
		}else {

			$r2 = $conexion -> query("SELECT * FROM embarques_guias WHERE recibido='' AND destino='' order by registro_fecha LIMIT 0,100");
		}
		
		echo "<table class='tabla'>";
		echo "<th>Guia</th><th>Origen Asignado</th><th class='pc'>Descripcion</th><th></th>";
		while($f = $r2 -> fetch_array()){
			echo "<tr>";
			echo "<td>".$f['guia']."</td>";
			echo "<td>".dpto_id($f['origen'])."</td>";
			//echo "<td>".dpto_id($f['destino'])."</td>";
			echo "<td class='pc'>";
			echo "<p style='width:90%; font-size:8pt; '>";
			$DescripcionNew = str_replace(",", ", ", $f['descripcion']); //agrega espacios despues de la coma
			echo "<p style='width:90%; font-size:8pt; '>".$DescripcionNew."</p>";
			
			
			if ($f['foraneo']=='1')
			{
				echo "Asignada como envio Foraneo<br>";
				echo "Destino: ".$f['destino']."<br>";
				echo "Domicilio: ".$f['domicilio']."<br>";
				echo "Telefono: ".$f['telefono']."<br>";
				echo "Ciudad: ".$f['ciudad']."<br>";

			}

			if ($f['recibido']<>''){
			echo "<br>Recibido por  ".nitavu_nombre($f['recibido']);
			echo "<br>".$f['recibio_fecha']." ".$f['recibio_hora'];

			echo "<br><br>".ponerfoto('img_embarques/'.$f['guia'].'_','foto');
			}
			echo "</td>";
			
			echo "<td>";
			if ($f['recibido']=='' or $f['destino']==''){
			echo "<a href='?guias=&act=".$f['guia']. "'><img src='icon/actualiza2.png' style='border-color:#E4E4E4; border-width:1px; border-style:solid; width:50px; height:40px; background-color:white; border-radius:3px;'></a>";
			echo "<a href='?guias=&foraneo=".$f['guia']. "'><img src='icon/boton_foraneo.png' style='border-color:#E4E4E4; border-width:1px; border-style:solid; width:50px; height:40px; background-color:white; border-radius:3px;'></a>";
			
			}
			echo "</td>";
			echo "</tr>";
		}
		echo "</table>";
		echo "<hr>";
		buscar('embarques.php?guias=','Buscar guia ', 'guias');
	}


    //PARA GENERAR PERMISOS O SER TITULAR DE UN PDTO.

    if (isset($_GET['permisos'])){
		echo "<br><hr><h2><center>OTORGAR PERMISO PARA USAR ESTA APLIACIÓN</center></h2><br>";
	echo "<div id='req_mod' style='width:100%' >";
	//echo "<div id='AppDetalle'><b>Otorgar permiso para usar esta aplicacion</b></div>";
	echo "<form action='embarques.php?permisos' method='POST'>";
	echo "<input type='hidden' name='nitavu_' value='".$nitavu."'>";
	echo "<div>";
	echo "<label for='empleado'>Seleccione a quien le ortorgara permiso:";
	echo "<select name='empleado'>";	
		$sql = "SELECT
			empleados.nitavu, nombre
		FROM
			empleados
		WHERE
				estado = ''
		
		ORDER BY
			nombre ASC";
		$r = $conexion -> query($sql);
		while($f = $r -> fetch_array())
			{ // resultado de la busqueda.................
				echo "<option value='".$f['nitavu']."'>".$f['nitavu']."-".$f['nombre']. "</option>";
			}
	
	echo "</select>";
	echo "</label>";
	echo "</div>";

	
	echo "<div>";
	echo "<label>Si da permiso, podra Administras las guias asignadas. <br>* El Titular del dpto, tiene esta misma facultad.</label>";
	echo "<input type='submit' value='Dar permiso' class='Mbtn btn-default' name='submit_todos'>";
	echo "</div>";
	echo "</form>";
	echo "</div>";

	


	echo "<div style='width:100%;'>";
	echo "<h4>Los siguientes empleados actualmente tienen acceso a la Aplicacion</h4>";
	echo "<table class=tabla>";
	echo "<th>Empleado: </th><th>Dpto</th><th>Quien Autorizo</th><th></th>";
	$sql = "SELECT
			empleados.nitavu, nombre, aplicaciones_permisos.*
		FROM
			empleados, aplicaciones_permisos
		WHERE
				estado = ''
		AND	(empleados.nitavu = aplicaciones_permisos.nitavu  and  aplicaciones_permisos.idapp='ap61' )
		ORDER BY
			nombre ASC";
	$r2 = $conexion -> query($sql); while($f = $r2 -> fetch_array())
	{
		echo "<tr>";
		echo "<td>".nitavu_nombre($f['nitavu'])."</td>";
		//echo "<td>".$f['nivel']."</td>";
		echo "<td>".nitavu_puesto($f['nitavu'])." de ".nitavu_dpto_nombre($f['nitavu'])."</td>";
		echo "<td>".nitavu_nombre($f['quien_autorizo'])." el ".$f['fecha_autorizacion']."</td>";
		echo "<td width=20px><a href='?permisos&eliminar=".$f['nitavu']."'><img src='icon/x.png' style='width:18px; height:18px;'></a>"."</td>";

		echo "</tr>";

	}
	echo "</table>";
	echo "<label>* Para quitar el acceso de clic en el icono Eliminar</label>";
	echo "</div>";

			

	if (isset($_POST['submit_todos'])){///guardar permisos
		$sql = "INSERT INTO aplicaciones_permisos (nitavu, idapp, nivel, quien_autorizo, fecha_autorizacion) VALUES ('".$_POST['empleado']."', '".$id_aplicacion."', '2', '".$nitavu."', '".$fecha."')";
		if ($conexion->query($sql) == TRUE)
			{	historia($nitavu, "Dio permiso para usar [".$id_aplicacion."] ".app_nombre($id_aplicacion)." a ".$_POST['empleado'].", ".nitavu_nombre($_POST['empleado']));
				notificacion_add ($_POST['empleado'], 'Acceso a '.app_nombre($id_aplicacion), $fecha, $nitavu, "Le he ortorgado permiso para usar la aplicacion de ".app_nombre($id_aplicacion)." de la Plataforma ITAVU.".$app_reso);
				mensaje("Permiso creado correctamente ",'embarques.php');
			}
		else {
			historia($nitavu, "Dio permiso para usar [".$id_aplicacion."] ".app_nombre($id_aplicacion)." a ".$_POST['empleado'].", ".nitavu_nombre($_POST['empleado'])."<hr>".$sql);				
			mensaje("Ha ocurrido un error al otorgar permiso ",'embarques.php');
		}
		


	}

	

	if (isset($_GET['eliminar'])){//eliminar permiso
		$sql = "DELETE FROM aplicaciones_permisos WHERE nitavu='".$_GET['eliminar']."' and idapp='".$id_aplicacion."'";
		if ($conexion->query($sql) == TRUE)
			{	historia($nitavu, "REVOCO el permiso para usar Embarques a ".$_GET['eliminar'].", ".nitavu_nombre($_GET['eliminar'])."");
				notificacion_add ($_GET['eliminar'], 'Se le ha REVOCADO el acceso a Embarques', $fecha, $nitavu, "Le he REVOCADO el permiso para usar la Administracion aplicacion de Embarques de la Plataforma ITAVU");
				mensaje("Permiso REVOCADO creado correctamente ",'embarques.php');
			}
		else {
			historia($nitavu, "ERROR al REVOCAR permiso de aplicacion de Embarques (req_permisos) ".$sql);
			mensaje("Ha ocurrido un error al REVOCAR  permiso ",'embarques.php');
		}
	}  
	}//fin de ver permisos  






//} san pedro

//area sin permisos
	if (!isset($_GET['guias']) AND !isset($_GET['permisos'])  AND !isset($_GET['estadistica']) AND !isset($_GET['enviar'])  AND !isset($_GET['enviarforaneo']) AND !isset($_GET['personal']) ) {
	if ($nivel=='2' or $nivel=='1'){//si el encargado de embarques le dio permisos
	//o es un titular de departamento: info disponible para titular o nivel 2

		$r2 = $conexion -> query("SELECT * FROM embarques_guias WHERE recibido='' and origen='".nitavu_dpto($nitavu)."' and destino=''");
		echo "<h1>Guias asignadas sin usar: </h1>";
		echo "<table class='tabla3'>";
		echo "<th>Guia</th><th>Destino</th><th>Recibido</th><th></th>";
		while($f = $r2 -> fetch_array()){
			echo "<tr>";
			echo "<td>".$f['guia']."</td>";
			//echo "<td>".dpto_id($f['origen'])."</td>";
			echo "<td>".dpto_id($f['destino'])."</td>";
			echo "<td>".nitavu_nombre($f['recibido'])."</td>";
			
			echo "<td>";
			if ($f['destino']==''){
				echo "<a title='Enviar' href='?enviar=".$f['guia']. "'><img src='icon/embarques_enviar.png' style='width:20px; height:20px; background-color:gray; border-radius:3px;'></a>";
				
				//echo " <a title='Envio fuera de ITAVU' href='?enviarforaneo=".$f['guia']. "'><img src='icon/embarques_enviar2.png' style='width:20px; height:20px; background-color:gray; border-radius:3px;'></a>";
			} else 
			{
				echo "<a target:_blank href='embarque_reporte_old.php?guia=".$f['guia']. "&nuc=$nitavu'><img src='icon/embarques_print.png' style='width:20px; height:20px; background-color:gray; border-radius:3px;'></a>";
			}
			
			echo "</td>";
			echo "</tr>";
		}
		echo "</table>";
	
	


	}}//--- FIN: info disponible para titular o nivel 2
	




	



//---------------------------------------------------------
if (!isset($_GET['guias']) AND !isset($_GET['permisos'])  AND !isset($_GET['estadistica']) AND !isset($_GET['enviar']) AND !isset($_GET['enviarforaneo']) AND !isset($_GET['personal']) ) {
	if (isset($_POST['descripcion'])) {//actualizamos la descripcion si se ha recibido
					$sql = "UPDATE embarques_guias SET descripcion='".$_POST['descripcion']."' WHERE guia='".$_POST['guia']."'";
//					echo $sql;
					$r = $conexion -> query($sql);
					if ($conexion->query($sql) == TRUE) {
						historia($nitavu, "Modifico la descripcion de la guia ".$_POST['guia'].": (".$_POST['descripcion'].")");
						mensaje("Se actualizo correctamente la descripcion de la guia ".$_POST['guia'],'embarques.php');
						//header('location:../vigilancia3.php');						
					}
					else {mensaje("ERROR Al actualizar la descripcion de la guia ".$_POST['guia']."(".$sql.")",'embarques.php');}
		}

		//$sql = "SELECT * FROM embarques_guias WHERE destino<>'' and origen='".nitavu_dpto($nitavu)."' and date_format (registro_fecha, '%m') = date_format (now(), '%m')  order by recibido";
		if (isset($_GET['dpto'])){
			$midpto = $_GET['dpto'];
		} else {
			$midpto = nitavu_dpto($nitavu);		
		}

		if (isset($_GET['full'])){
			$sql = "SELECT * FROM embarques_guias WHERE destino<>'' and origen='".$midpto."'  order by recibido";
		} else {
			$sql = "SELECT * FROM embarques_guias WHERE destino<>'' and origen='".$midpto."'  and recibio_fecha='' order by recibido";
		}
		// if ($nitavu == '2809'){
		// 	$sql = "SELECT * FROM embarques_guias WHERE destino<>'' order by registro_fecha DESC limit 100 ";
		// }
		
		// echo $sql;
		$r2 = $conexion -> query($sql);
		echo "<div id='indicadores' style='width:90%; background-color:#ECF2D9; border-color:#C8DA92; color:#006600;
		overflow:auto; height:400px;
		'
		
		
		><h1 style='color:#006600;'>Enviados de este mes: </h1>";
		echo "<table class='tabla' s>";
		echo "<th style='width:50%;'>Guia</th><th>Destino</th><th>Recibido</th><th></th>";

		

		while($f = $r2 -> fetch_array()){
			echo "<tr>";
			if ($f['recibido']==''){echo "<td  style='background-color:#C8DA92; ' width=20%>";}else {echo "<td width=40px>";}
			echo "".$f['guia']."<br><label style='font-size:8pt;'>"."</label>";
			//$f['descripcion']
			//editar descripcion solo si aun no se imprime(de clic a imprimir)
			//echo $f['visto_paraimprimir'];
			if ($f['visto_paraimprimir']=='0' and $f['recibido']=='' ){
				echo "<form action='embarques.php' method='POST' class='pc' >";
				echo "<textarea  name='descripcion'>".$f['descripcion']."</textarea>";
				echo "<input type='hidden' name='guia' value='".$f['guia']."'>";
				//echo "<input type='text' value='".$f['descripcion']."'>";
				echo "<input type='submit' value='Actualizar descripcion' class='Mbtn btn-default'>";
				echo "</form>";

				
				
			}else {
				$DescripcionNew = str_replace(",", ", ", $f['descripcion']); //agrega espacios despues de la coma
				echo "<p style='width:90%; font-size:8pt; '>".$DescripcionNew."</p>";
			}
			echo "</td>";



			if ($f['recibido']==''){echo "<td width=30% style='background-color:#C8DA92; font-size:9pt; '   valign=top align=center>";}else {echo "<td  style='font-size:9pt;' valign=top align=center>";}
			if ($f['foraneo']=='1'){	
				echo "Asignada como envio Foraneo<br>";
				echo "Destino: ".$f['destino']."<br>";
				echo "Domicilio: ".$f['domicilio']."<br>";
				echo "Telefono: ".$f['telefono']."<br>";
				echo "Ciudad: ".$f['ciudad']."<br>";
			 } else {
				 echo "".dpto_id($f['destino']);
			 }
			

			if ($f['registro_fecha']<>'0000-00-00'){echo "<label style='font-size:8pt;'>Salio el ".fecha_larga($f['registro_fecha'])." a las ".hora12($f['registro_hora']);}
			echo "</td>";


			if ($f['recibido']==''){echo "<td style='background-color:#C8DA92; font-size:9pt; '   valign=top align=center>";}else {echo "<td  style='font-size:9pt;' valign=top align=center>";}
			echo "".nitavu_nombre($f['recibido']);
			if ($f['recibio_fecha']<>'0000-00-00') {echo "<label style='font-size:8pt;'> Recibido el ".fecha_larga($f['recibio_fecha'])." a las ".hora12($f['recibio_hora'])."</label>";}
			
			
			echo "</td>";
			if ($f['recibido']==''){echo "<td style='background-color:#C8DA92; font-size:9pt; '   valign=top align=center>";}else {echo "<td  style='font-size:9pt;' valign=top align=center>";}
			
			
			if ($f['destino']==''){
				echo "<a href='?guias=&enviar=".$f['guia']. "'><img src='icon/embarques_enviar.png' style='width:20px; height:20px; background-color:gray; border-radius:3px;'></a>";
			} else {
					echo "<a target:_blank href='embarque_reporte_old.php?guia=".$f['guia']. "&nuc=$nitavu'><img src='icon/embarques_print.png' style='width:20px; height:20px; background-color:gray; border-radius:3px; margin:5px;'></a>";

					if ($f['recibido']==''){
					//echo "<a target:_blank href='embarque_reporte_caida.php?guia=".$f['guia']. "&nuc=$nitavu'> 	<img src='icon/embarques_print2.png' style='width:20px; height:20px; background-color:gray; border-radius:3px; margin:5px;'></a>";
					}

			}
			
			echo "</td>";
			echo "</tr>";
		}
		echo "</table>";
		echo "<a href='?full=' class='Mbtn btn-Default'>ver mas.. </a>";
		echo "</div>";
	
	
	}

	// ------------------------------------------------------
	



//--------------------------------------------------------- paquetes por recibir
if (!isset($_GET['guias']) AND !isset($_GET['permisos'])  AND !isset($_GET['estadistica']) AND !isset($_GET['enviar']) AND !isset($_GET['enviarforaneo'])  AND !isset($_GET['personal']) ) {
	$sqlx= 	"SELECT * FROM embarques_guias WHERE recibido='' and destino='".nitavu_dpto($nitavu)."'  limit 0, 30";
	$r2 = $conexion -> query($sqlx);
	// echo $sqlx;
		echo "<div id='indicadores' style=' width: 90%; background-color:#F2E6CC; border-color:#BE7C7C; color:#663333;  overflow:auto; height:400px;'><h1 style='color:#663333;'>Por llegar: </h1>";
		
		echo "<table class='tabla'>";
		echo "<th>Guia</th><th>Desde</th><th>Descripcion</th><th></th>";
		while($f = $r2 -> fetch_array()){
			echo "<tr>";
			echo "<td>".$f['guia']."</td>";
			//echo "<td>".dpto_id($f['origen'])."</td>";
			echo "<td style='font-size:9pt;' valign=top align=center>".dpto_id($f['origen'])."<label>".$f['registro_fecha']."</label></td>";
			echo "<td style='font-size:9pt; color:663333;' valign=top align=center>";
			
			echo "<p style='width:90%; font-size:8pt; '>";
			$DescripcionNew = str_replace(",", ", ", $f['descripcion']); //agrega espacios despues de la coma
			echo "<p style='width:90%; font-size:8pt; '>".$DescripcionNew."</p>";

			
			
			echo "</td>";
			
			echo "<td>";
			if ($f['destino']==''){
				//echo "<a href='?enviar=".$f['guia']. "'><img src='icon/embarques_enviar.png' style='width:20px; height:20px; background-color:gray; border-radius:3px;'></a>";
			} else {
					echo "<a target:_blank href='embarque_reporte_old.php?guia=".$f['guia']. "&notoken&nuc=$nitavu'><img src='icon/embarques_print.png' style='width:20px; height:20px; background-color:gray; border-radius:3px;'></a>";

			}
					echo "<a href='?recibir=".$f['guia']. "'> <img src='icon/ok.png' style='width:20px; height:20px; background-color:gray; border-radius:3px;'></a>";
			
			echo "</td>";
			echo "</tr>";
		}
		echo "</table>";
		
		// //LEER CODIGO QR
		// require("qr/qrpdz-include.php");
		// echo "<label>Registrar por QR</label>";
		// echo "    
		// <form action='' method='POST' enctype='multipart/form-data'>
		// 	<input type='file' name='foto' id='foto'>
		// 	<input type='submit' value='Leer codigo QR' name='qr_form' class='Mbtn btn-tercero'>
		// </form>";
		// if (isset($_POST['qr_form'])){
		// 		if (pdz_up('foto',$nitavu)==TRUE){
		// 			echo pdz_img($nitavu);
		// 		}
		// 		else {
		// 			echo '<b style=color:red>ERROR</b>';
		// 		}
		// 	}

		
		// qrpdz_init('codigo','fotoimg');

		echo "</div>";
	
	

	}
	// ------------------------------------------------------




//--------------------------------------------------------- paquetes por recibir
if (!isset($_GET['guias']) AND !isset($_GET['permisos'])  AND !isset($_GET['estadistica']) AND !isset($_GET['enviar']) AND !isset($_GET['enviarforaneo'])  AND !isset($_GET['personal'])) {
		$r2 = $conexion -> query("SELECT * FROM embarques_guias WHERE recibido<>'' and destino='".nitavu_dpto($nitavu)."' and recibio_fecha<>'' and recibio_fecha<>'' order by registro_fecha DESC limit 100");
		echo "<div id='indicadores' style ='width:90%; overflow:auto; height:400px;'><h1>Paqueteria recibida: </h1>";
		echo "<table class='tabla'>";
		echo "<th>Guia</th><th>Descripcion</th><th></th>";
		while($f = $r2 -> fetch_array()){
			echo "<tr>";
			echo "<td>".$f['guia']."</td>";
			//echo "<td>".dpto_id($f['origen'])."</td>";
			echo "<td style='font-size:8pt;'>";
			echo "De <b>".dpto_id($f['origen'])."</b>, enviada el ".fecha_larga($f['registro_fecha'])." y Recibida por <b>".nitavu_nombre($f['recibido'])."</b> el ".fecha_larga($f['recibio_fecha'])." a las ".hora12($f['recibio_hora']);
			
			
			echo "</td>";
			echo "<td>";
			if ($f['destino']==''){
				echo "<a href='?guias=&enviar=".$f['guia']. "'><img src='icon/embarques_enviar.png' style='width:20px; height:20px; background-color:gray; border-radius:3px;'></a>";
			} else {
					echo "<a href='embarque_reporte_old.php?guia=".$f['guia']. "&nuc=$nitavu'><img src='icon/embarques_print.png' style='width:20px; height:20px; background-color:gray; border-radius:3px;'></a>";

			}
			
			echo "</td>";
			echo "</tr>";
		}
		echo "</table>";
		echo "<a href='?full=' class='Mbtn btn-Default'>ver mas.. </a>";
		echo "</div>";
	
	
	}

	// ------------------------------------------------------

	
	







//PARA GENERAR PERMISOS O SER TITULAR DE UN PDTO.

    if (isset($_GET['estadistica'])){
	$data="['Dpto','Uso','Asignadas'],";		
		//echo "Grafica";

		if ($_GET['estadistica']==''){					
			$sql ="
			SELECT 
			DISTINCT(origen) as Qorigen,
			(select nombre from cat_gerarquia where id=Qorigen) as Dpto,
			(select count(*) from embarques_guias where origen=Qorigen and destino<>'') as Quso,
			(select count(*) from embarques_guias where origen=Qorigen) as Qasignadas
			from embarques_guias
			WHERE DATE_FORMAT(registro_fecha, '%m') = DATE_FORMAT(now(), '%m')";
			echo "<h2>Grafica sobre datos de este mes</h2>";
			
		} else {
			
			$sql ="
			SELECT 
			DISTINCT(origen) as Qorigen,
			(select nombre from cat_gerarquia where id=Qorigen) as Dpto,
			(select count(*) from embarques_guias where origen=Qorigen and destino<>'') as Quso,
			(select count(*) from embarques_guias where origen=Qorigen) as Qasignadas
			from embarques_guias
			";
		}
		//echo $sql;
		$r2 = $conexion -> query($sql);

		while($f = $r2 -> fetch_array()){
			$data=$data."['".$f['Dpto']."',".$f['Quso'].",".$f['Qasignadas']."],";
			
		}
	$data =   trim($data, ',');
	$grafica = "
    <script type='text/javascript'>
     google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {
        var data = google.visualization.arrayToDataTable([

				    ".$data."
				     
				
				     ]);

       var options = {
		 fontSize: 12,
          title: 'Uso de guias por Dptos ',
          hAxis: {title: 'Departamentos',  titleTextStyle: {color: '#333'}},
          vAxis: {minValue: 0},
         
          animation: {
          duration: 1500,
          easing: 'out',
          startup: true
      		}
        };

        var chart = new google.visualization.AreaChart(document.getElementById('chart_div'));
        chart.draw(data, options);

      }
    </script>
	<div id='chart_div' ></div>

				";
				echo "<center>";
	echo $grafica;
	echo "<br><br><a href='?estadistica=all' class='Mbtn btn-default'>Mostrar Grafica de todos los tiempos</a>";
	echo "</center>";
	}



} else { mensaje("ERROR: No tiene acceso a esta aplicacion",'');}








?>

<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
	



	<script>
	function cartero2_llenar(dpto) {	
		var cod = document.getElementById("cartero").value;
		var combo = document.getElementById("cartero");
		var seleccionado = combo.options[combo.selectedIndex].text;

		console.log("Seleccionado: "+seleccionado+", con Nitavu="+cod);
			if (cod=="") {
				document.getElementById("div_cartero2").innerHTML="";
				return;
			} 

			if (window.XMLHttpRequest) {// code for IE7+, Firefox, Chrome, Opera, Safari
				xmlhttp=new XMLHttpRequest();
			} else { // code for IE6, IE5
			 	xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
			}

			xmlhttp.onreadystatechange=function() {
				if (this.readyState==4 && this.status==200) {
			 	document.getElementById("div_cartero2").innerHTML=this.responseText;
			 	}
			}
			
			xmlhttp.open("GET","embarques_cartero2.php?user="+cod+"&dpto="+dpto,true);
			xmlhttp.send();
			
	}
	</script>		

	<!-- <script>
	function recibido_fl(){
		var archivo = document.getElementById("file_recibido").value;
		var Forma = document.getElementById("carteroForm");
		if (archivo==""){
			//archivo.classList.add('');
			Forma.classList.remove("carteroRecibido");
		} else {
			Forma.classList.add("carteroRecibido");
			
    		
		}
	}
	</script> -->

	<script>
	function recibido_fl(){
		var archivo = document.getElementById("file_recibido").value;		
		var Forma = document.getElementById("carteroForm");
		if (archivo==""){
			//archivo.classList.add('');
			Forma.classList.remove("carteroRecibido");
		} else {
			Forma.classList.add("carteroRecibido");
			
    		
		}
	}
	</script>


<?php
include ("./lib/body_footer.php");
?>