<?php
//include ("./unica/seguridad.php"); 
include ("./unica/body_head.php");
include ("./unica/body_menu.php");
?>
<?php
$id_aplicacion = 'ap02';
$nivel =aplicacion_nivel($id_aplicacion, $nitavu);
//PROCESO PARA TOCAR LA PUERTA DE SAN PEDRO
$id_aplicacion ="ap02"; //ap07=Permisos de Aplicacion
if (sanpedro($id_aplicacion, $nitavu)==TRUE){
	echo "<h5>".app_detalle($id_aplicacion)."</h5>";

	$n=$_GET['n'];//var con la que nos manda la busqueda y nos indica que numero de itavu tiene

	$sql = "SELECT * FROM empleados WHERE nitavu='".$n."'";
	$rc= $conexion -> query($sql);
	if($f = $rc -> fetch_array()){

		if($nivel <> 2){
			historia($nitavu,'Vio perfil de '.nitavu_nombre($f['nitavu']));
		echo "<br><div id='pesta_elementos'>";
		$mas="";
		if (isset($_GET['n'])){
				$mas="&n=".$_GET['n'];
		}
		if (isset($_GET['pes'])) {
				if ($_GET['pes']=='gral'){
					echo "<a class='seleccionada' href='?pes=gral".$mas."'>GENERALES</a>";	
					echo "<a class='sinseleccion' href='?pes=lab".$mas."'>LABORALES</a>";	
					// echo "<a class='sinseleccion' href='?pes=doc".$mas."'>DOCUMENTOS</a>";	
				}	
			}

		if (isset($_GET['pes'])) {
				if ($_GET['pes']=='lab'){
					echo "<a class='sinseleccion' href='?pes=gral".$mas."'>GENERALES</a>";	
					echo "<a class='seleccionada' href='?pes=lab".$mas."'>LABORALES</a>";	
					// echo "<a class='sinseleccion' href='?pes=doc".$mas."'>DOCUMENTOS</a>";	
				}	
			}

		if (isset($_GET['pes'])) {
				if ($_GET['pes']=='doc'){
					echo "<a class='sinseleccion' href='?pes=gral".$mas."'>GENERALES</a>";	
					echo "<a class='sinseleccion' href='?pes=lab".$mas."'>LABORALES</a>";	
					// echo "<a class='seleccionada' href='?pes=doc".$mas."'>DOCUMENTOS</a>";	
				}	
			}

		echo "</div>";







	



		if (isset($_GET['pes'])) {
			if ($_GET['pes']=='gral'){echo "<div id='generales' class='pesta visible'>";	
			//echo "<h5>GENERALES:</h5>";

			echo "<form action='empleado_edit_valida2_gral.php'  method='POST' enctype='multipart/form-data'>";
			echo "<input type='hidden' value='".$nitavu."' name='quien'>";
			echo "<input type='hidden' value='".$_GET['n']."' name='no'>";
			
			echo "<div>";
			echo ponerfoto("fotos/".$f['nitavu'].".jpg",'foto');
			echo "<label for='foto_file'>Para actualizar la foto, seleccione un archivo:</label>";
			echo "<input type='file' name='foto_file' id='foto_file' >";
			echo "</div>";


			echo "<div>";
			echo "<label for='nombre'>Nombre completo (escriba primero nombre y despues apellidos, respetando mayusculas y minusculas):</label>";
			echo "<input type='text' name='nombre' id='nombre2' required='required' value='".$f['nombre']."'>";
			echo "</div>";


			echo "<div>";
			echo "<label for='no'>Numero de ITAVU:</label>";
			echo "<input type='text' name='no' id='no' readonly='readonly' value='".$n."'>";
			echo "</div>";
			
		

		
		


			echo "<div>";
			echo "<label for='correoelectronico'>Correo electronico:</label>";
			echo "<input type='email' name='correoelectronico' id='correoelectronico' value='".$f['correoelectronico']."'>";
			echo "</div>";

			echo "<div>";
			echo "<label for='telefono2'>Telefono Personal:</label>";
			echo "<input type='tel' name='telefono2' id='telefono' value='".$f['telefono2']."'>";
			echo "</div>";

			echo "<div>";
			echo "<label for='telefono_movil'>Telefono Movil:</label>";
			echo "<input type='tel' name='telefono_movil' id='telefono_movil' value='".$f['telefono_movil']."'>";
			echo "</div>";

			echo "<div>";
			echo "<label for='fecha_nacimiento'>Fecha de Nacimiento:</label>";
			echo "<input type='date' name='fecha_nacimiento' id='fecha_nacimiento' required='required' placeholder='AAAA-MM-DD' 
			value='".$f['fecha_nacimiento']."'>";
			echo "</div>";


echo '

<div>
<label> Estado Civil </label>
<select name="estadocivil" id="estadocivil">';
$sql = "SELECT * FROM cat_edocivil ";
$tmp="";
$r2 = $conexion -> query($sql);
while($fx = $r2 -> fetch_array())
	{//Categorias de Aplicaciones
	
	echo '<option value="'.$fx['IdEstadoCivil'].'">'.$fx['EstadoCivil'].'</option>';
	if ($f['estadocivil']==$fx['IdEstadoCivil']){$tmp=$fx['EstadoCivil'];}
	}

	if ($tmp==''){
	echo '<option value="0" selected="selected">NINGUNO</option>';	
	}
	else
	{
	echo '<option value="'.$f['estadocivil'].'" selected="selected">'.$tmp.'</option>';	
	}


echo '
</select>
</div>';



	echo "<span class='ejecutandose'>";
	echo "<h1>DOMICILIO: </h1>";
	echo "<div>";
	echo "<label for='domicilio_calle'>Calle:</label>";
	echo "<input type='text' name='domicilio_calle' id='domicilio_calle' value='".$f['domicilio_calle']."'>";
	echo "</div>";

	echo "<div>";
	echo "<label for='domicilio_num_int'>Num. Int:</label>";
	echo "<input type='text' name='domicilio_num_int' id='domicilio_num_int' value='".$f['domicilio_num_int']."'>";
	echo "</div>";

	echo "<div>";
	echo "<label for='domicilio_num_ext'>Num. Ext:</label>";
	echo "<input type='text' name='domicilio_num_ext' id='domicilio_num_ext' value='".$f['domicilio_num_ext']."'>";
	echo "</div>";

	echo "<div>";
	echo "<label for='domicilio_entrecalles'>Entre que calles:</label>";
	echo "<input type='text' name='domicilio_entrecalles' id='domicilio_entrecalles' value='".$f['domicilio_entrecalles']."'>";
	echo "</div>";

	echo "<div>";
	echo "<label for='domicilio_colonia'>Colonia:</label>";
	echo "<input type='text' name='domicilio_colonia' id='domicilio_colonia' value='".$f['domicilio_colonia']."'>";
	echo "</div>";

	echo "<div>";
	echo "<label for='domicilio_ciudad'>Ciudad:</label>";
	echo "<input type='text' name='domicilio_ciudad' id='domicilio_ciudad' value='".$f['domicilio_ciudad']."'>";
	echo "</div>";

	echo "<div>";
	echo "<label for='domicilio_cp'>Codigo Postal:</label>";
	echo "<input type='text' name='domicilio_cp' id='domicilio_cp' value='".$f['domicilio_cp']."'>";
	echo "</div>";

	echo "</span>";










			echo "<span>";
			echo sugerencia("No utilice apostrofes o comillas, afecta a la integredad de los datos.");
			echo "<div>";

			echo "<input type='submit' value='Actualizar Datos' class='btn btn-default'>";
			echo "</div></div></span>";



			echo "</form>";







			//echo "</div>";
			}
			else
			{echo "<div id='generales' class='pesta invisible'></div>";}
			}

		

		if (isset($_GET['pes'])) {
			if ($_GET['pes']=='lab'){
				echo "<div id='laborales' class='pesta visible'>";	

			echo "<form action='empleado_edit_valida2_lab.php'  method='POST' enctype='multipart/form-data'>";
			echo "<input type='hidden' value='".$nitavu."' name='quien'>";
			echo "<input type='hidden' value='".$_GET['n']."' name='no'>";

				echo "<div>";
				echo "<label for='direccion'>Direccion: ".$f['direccion'];
				echo "<select name='direccion'>";
				
					$sql = "SELECT * FROM cat_gerarquia where nivel='dir' ORDER by nombre ASC";
					$r = $conexion -> query($sql);
					while($f2 = $r -> fetch_array())
						{ // resultado de la busqueda.................
							if ($f['direccion']==$f2['id']){
								echo "<option selected='selected' value='".$f2['id']."'>".$f2['nombre']. " </option>";							
							} else {
								echo "<option value='".$f2['id']."'>".$f2['nombre']. " </option>";						
							}
						}
						
				echo "</select>";
				echo "</label>";
				echo "</div>";


				// echo "<div>";
				// echo "<label for='departamento'>Departamento:".$f['departamento'];
				// echo "<select name='depa'>";
				
				// 	$sql = "SELECT * FROM cat_gerarquia where nivel<>'dir' and nivel <>'sub' and nivel<>'CONSEJO' ORDER by nombre ASC";					
				// 	$r = $conexion -> query($sql);
				// 	while($f3 = $r -> fetch_array())
				// 		{ // resultado de la busqueda.................
				// 			if ($f['dpto']==$f2['id']){
				// 				echo "<option selected='selected' value='".$f2['id']."'>".$f2['nombre']. " </option>";							
				// 			} else {
				// 				echo "<option value='".$f2['id']."'>".$f2['nombre']. " </option>";						
				// 			}
				// 		}
				
				// echo "</select>";
				// echo "</label>";
				// echo "</div>";


				echo "<div>";
				echo "<label for='departamento'>Departamento: ID";
				echo "<select name='dpto' >";
				
					$sql = "SELECT * FROM cat_gerarquia order by nombre";
					$r = $conexion -> query($sql);
					$t="";
					while($f3 = $r -> fetch_array())
						{ // resultado de la busqueda.................
							echo "<option  value='".$f3['id']."'>".$f3['nombre']. " </option>";		
							if ($f['dpto']==$f3['id']){$t=$f3['nombre'];}						
						}
							echo "<option selected='selected'  value='".$f['dpto']."'>".$t. " </option>";								
				
				echo "</select>";
				echo "</label>";
				echo "</div>";



				echo "<div>";
				echo "<label for='departamento'>Titular de:";
				echo "<select name='titular' >";
				
					$sql = "SELECT * FROM cat_gerarquia where titular='' or titular='".$f['nitavu']."'";
					// echo $sql;
					$r = $conexion -> query($sql);
					$t2="";
					while($f3 = $r -> fetch_array())
						{ // resultado de la busqueda.................
							echo "<option  value='".$f3['id']."'>".$f3['nombre']. " </option>";		
							if ($f['nitavu']==$f3['id']){$t2=$f3['nombre'];}						
						
						
						}
						$sql = "SELECT * FROM cat_gerarquia WHERE titular='".$_GET['n']."'";
						$rc= $conexion -> query($sql);
						if($fs = $rc -> fetch_array())
						{
							echo "<option selected='selected'  value='".$fs['id']."'>".$fs['nombre']. " </option>";
						}
						else {						
							echo "<option selected='selected'  value=''>Personal Operativo</option>";								
						}
						
						echo "<option value=''>Personal Operativo o Vacante</option>";
				echo "</select>";
				echo "</label>";
				echo "</div>";


				
				echo "<div>";
				echo "<label for='puesto'>Puesto:";
				echo "<input type='text' name='puesto' value='".$f['puesto']."' >";
				echo "</label>";
				echo "</div>";




				echo "<div>";
				echo "<label for='nivel' required='required'>Nivel:</label>";
				echo "<input type='text' name='nivel' id='nivel' value='".$f['nivel']."'>";
				echo "</div>";
				

				echo "<div>";
				echo "<label for='secc'>SECC:</label>";
				echo "<input type='text' name='secc' id='secc' value=".$f['secc'].">";
				echo "</div>";


				echo "<div>";
				echo "<label for='sap'>Numero SAPP:</label>";
				echo "<input type='text' name='sap' id='sap' value=".$f['sap'].">";
				echo "</div>";
			


				echo "<div>";
				echo "<label for='telefono'>Telefono de Oficina:</label>";
				echo "<input type='tel' name='telefono' id='telefono' value='".$f['telefono']."'>";
				echo "</div>";




				echo "<div>";
				echo "<label for='telefono_extension'>Extension de telefono:</label>";
				echo "<input type='text' name='telefono_extension' id='telefono' value='".$f['telefono_extension']."'>";
				echo "</div>";

				echo "<div>";
					echo "<div>";
					echo "<label for='profesion_abr'>Profesion abreviatura:</label>";
					echo "<input type='text' name='profesion_abr' id='profesion_abr' value='".$f['profesion_abr']."'>";
					echo "</div>";

					echo "<div>";
					echo "<label for='profesion'>Profesion:</label>";
					echo "<input type='text' name='profesion' id='telefono' value='".$f['profesion']."'>";
					echo "</div>";

				echo "</div>";

				//AGREGANDO SUELDO Y COMPE
				echo "<div>";
					echo "<label for='sueldo'>Sueldo:</label>";
					echo "<input type='text' name='sueldo' id='sueldo' value='".$f['sueldo']."'>";
				echo "</div>";

				// echo "<div>";
				// 	echo "<label for='sueldo'>Compensación:</label>";
					echo "<input type='hidden' name='compe' id='compe' value='".$f['compensacion']."'>";
				// echo "</div>";




				echo "<div>";
				echo ponerfoto("firmas/".$f['nitavu'].".jpg",'icono_usuario');
				echo "<label for='firma_file'>Archivo de la rubrica de la firma:</label>";
				echo "<input type='file' name='firma_file' id='firma_file'>";
				echo "</div>";


				echo "<span>";
				echo "<label class='alerta'>Utilize esta opcion para darlo de baja o suspencion temporal <b class='ejecutandose'>* NO TENDRA ACCESO A LA PLATAFORMA</b></label>";

				echo "<select name='estado'>";


				echo "<option value=''>Activo</option>";
				echo "<option value='Baja permanente'>Baja permanente</option>";
				echo "<option value='Baja temporal'>Baja temporal</option>";
				echo "<option value='comisionado'>comisionado</option>";
				//echo "<option value='Bloqueado'>Bloquear acceso a la plataforma</option>";

				echo "<option value='".$f['estado']."' selected='selected'>".$f['estado']."</option>";
				echo "</select>";
				echo "</span>";



				echo "<hr>";


				echo "<div class='alerta'>";
				echo "<label for='comida'>Tiempo autorizado para comida:</label>";
				
				echo "<select name='comida' id='comida'>";
				if ($f['comida'] == '00:30:00'){
					echo "<option value='00:30:00' selected>30min</option>";					
				}

				if ($f['comida'] == '01:00:00'){
					echo "<option value='01:00:00' selected>1hr</option>";					
				}

				if ($f['comida'] == '01:30:00'){
					echo "<option value='01:30:00' selected>1hr 30min</option>";					
				}

				if ($f['comida'] == '02:00:00'){
					echo "<option value='02:00:00' selected>2hr</option>";					
				}
				if ($f['comida'] == '03:00:00'){
					echo "<option value='03:00:00' selected>3hr</option>";					
				}

				if ($f['comida'] == '03:30:00'){
					echo "<option value='00:30:00' selected>3hr 30min</option>";					
				}

				if ($f['comida'] == '04:00:00'){
					echo "<option value='04:00:00' selected>4hr</option>";					
				}

				echo "<option value='00:30:00'>30min</option>";
				echo "<option value='01:00:00'>1hr</option>";
				echo "<option value='01:30:00'>1hr 30min</option>";
				echo "<option value='02:00:00'>2hr</option>";
				echo "<option value='02:30:00'>2hr 30min</option>";
				echo "<option value='03:00:00'>3hr</option>";
				echo "<option value='03:30:00'>3hr 30min</option>";
				echo "<option value='04:00:00'>4hr</option>";
				
				





				echo "</select>";
				// echo "<input type='time' name='comida' id='comida' value='".$f['comida']."' >";
				
				echo "</div>";


				echo "<hr>";
				echo "<h1>COMIDA</h1>";
				echo "<div>";
				echo "<label for='horario_entrada'>Entrada:</label>";
				echo "<input type='time' name='horario_entrada' id='horario_entrada' value='".$f['horario_entrada']."'>";
				echo "</div>";

				echo "<div>";
				echo "<label for='horario_salida'>Salida:</label>";
				echo "<input type='time' name='horario_salida' id='horario_salida' value='".$f['horario_salida']."'>";
				echo "</div>";

				

				
				echo "<hr>";



				echo "<span>";
				echo sugerencia("No utilice apostrofes o comillas, afecta a la integredad de los datos.");
				echo "<div>";

				echo "<input type='submit' value='Actualizar Datos' class='btn btn-default'>";
				echo "</div></div></span>";



				echo "</form>";

			//echo "</div>";


			}
			else
			{echo "<div id='lab' class='pesta invisible'></div>";}
		}



		if (isset($_GET['pes'])) {
			if ($_GET['pes']=='doc'){
				echo "<div id='doc' class='pesta visible'>";	
				echo "<h5>DOCUMENTOS:</h5>";
				echo "<form action='empleado_edit_doc_valida.php' method='POST' enctype='multipart/form-data'>";
				echo "<input type='hidden' value='".$nitavu."' name='quien'>";
				echo "<input type='hidden' value='".$_GET['n']."' name='no'>";

				echo "<article>";
				echo "CURP:<br>";
				echo ponerfoto("docs/".$f['nitavu']."_curp.jpg",'foto');	
				echo "<label for='curp'> Seleccione un archivo (.JPG) para actualizar </label>";
				echo "<div class='fileUpload btn btn-secundario'>";				
				echo "Seleccionar";
				echo "<input type='file' name='curp' class='upload'>";	
				echo "</div>";
				echo "</article>";



				echo "<article>";
				echo "ACTA DE NACIMIENTO:<br>";
				echo ponerfoto("docs/".$f['nitavu']."_acta.jpg",'foto');	
				echo "<label for='acta'> Seleccione un archivo (.JPG) para actualizar </label>";
				echo "<div class='fileUpload btn btn-secundario'>";				
				echo "Seleccionar";
				echo "<input type='file' name='acta' class='upload'>";	
				echo "</div>";
				echo "</article>";

    
				echo "<article>";
				echo "IFE: credencial de elector<br>";
				echo ponerfoto("docs/".$f['nitavu']."_ife.jpg",'foto');	
				echo "<label for='ife'> Seleccione un archivo (.JPG) para actualizar </label>";
				echo "<div class='fileUpload btn btn-secundario'>";				
				echo "Seleccionar";
				echo "<input type='file' name='ife' class='upload'>";	
				echo "</div>";
				echo "</article>";



				echo "<article>";
				echo "Curriculum Vitae:<br>";
				$archivo = "docs/".$f['nitavu']."_cv.pdf";

				echo ponerpdf($archivo,'foto');
				//echo "<a href='".$archivo."'> Ver completo";
				//echo "</a>";


				echo "<label for='cv'> Seleccione un archivo (.PDF) para actualizar </label>";
				echo "<div class='fileUpload btn btn-secundario'>";				
				echo "Seleccionar";
				echo "<input type='file' name='cv' class='upload'>";	
				echo "</div>";
				echo "</article>";






				echo "<article>";
				echo "<input type='submit' class='btn btn-default' value='Guardar Documentos'>";
				echo "</<article>";
				
				echo "</form>";
				echo "</div>";


			
			}else{
				echo "<div id='doc' class='pesta invisible'></div>";
			}
		}
//-----------------Si el nivel es 2 (El director)-------------------------------------------------------------------------------------
		}else{
			echo 'soy director';
			historia($nitavu,'Vio perfil de '.nitavu_nombre($f['nitavu']));
			echo "<br><div id='pesta_elementos'>";
			$mas="";
			if (isset($_GET['n'])){
				$mas="&n=".$_GET['n'];
			}
			if (isset($_GET['pes'])) {
				if ($_GET['pes']=='gral'){
					echo "<a class='seleccionada' href='?pes=gral".$mas."'>GENERALES</a>";	
					echo "<a class='sinseleccion' href='?pes=lab".$mas."'>LABORALES</a>";	
					// echo "<a class='sinseleccion' href='?pes=doc".$mas."'>DOCUMENTOS</a>";	
				}	
			}

			if (isset($_GET['pes'])) {
				if ($_GET['pes']=='lab'){
					echo "<a class='sinseleccion' href='?pes=gral".$mas."'>GENERALES</a>";	
					echo "<a class='seleccionada' href='?pes=lab".$mas."'>LABORALES</a>";	
					// echo "<a class='sinseleccion' href='?pes=doc".$mas."'>DOCUMENTOS</a>";	
				}	
			}

			echo "</div>";


		if (isset($_GET['pes'])) {
			if ($_GET['pes']=='gral'){
				echo "<div id='generales' class='pesta visible'>";	

				
					echo "<input type='hidden' value='".$nitavu."' name='quien'>";
					echo "<input type='hidden' value='".$_GET['n']."' name='no'>";
					
					echo "<div style='float: left; width: 50%;'>";
						
						echo ponerfoto("fotos/".$f['nitavu'].".jpg",'fotopp');
						

					echo "</div>";
					echo "<div style='float: right; width: 50%;'>";
						echo "<div>";
						echo "<label for='nombre'>Nombre completo</label>";
						echo "<input type='text' name='nombre' id='nombre2' required='required' value='".$f['nombre']."' readonly>";
						echo "</div>";


						echo "<div>";
						echo "<label for='no'>Numero de ITAVU:</label>";
						echo "<input type='text' name='no' id='no' readonly='readonly' value='".$n."'>";
						echo "</div>";

						echo "<div>";
						echo "<label for='telefono_movil'>Telefono Movil:</label>";
						echo "<input type='tel' name='telefono_movil' id='telefono_movil' value='".$f['telefono_movil']."' readonly>";
						echo "</div>";

						echo "<div>";
						echo "<label for='fecha_nacimiento'>Fecha de Nacimiento:</label>";
						echo "<input type='date' name='fecha_nacimiento' id='fecha_nacimiento' required='required' placeholder='AAAA-MM-DD' 
						value='".$f['fecha_nacimiento']."' readonly>";
						echo "</div>";

						echo "<span class='ejecutandose'>";
						echo "<div>";
						echo "<label for='domicilio_calle'>Domicilio:</label>";
						echo "<input type='text' name='domicilio_calle' id='domicilio_calle' value='Calle: ".$f['domicilio_calle']." Num. Int: ".$f['domicilio_num_int']."
						Colonia: ".$f['domicilio_colonia']." C.P. ".$f['domicilio_cp']." Ciudad: ".$f['domicilio_ciudad']." '>";
						echo "</div>";
						echo "</span>";
					echo "</div>";

			

				echo "</div>";

			}else{
				echo "<div id='generales' class='pesta invisible'></div>";
			}
		}

		

		if (isset($_GET['pes'])) {
			if ($_GET['pes']=='lab'){
				echo "<div id='laborales' class='pesta visible'>";	

			echo "<form action='empleado_edit_valida2_lab.php'  method='POST' enctype='multipart/form-data'>";
			echo "<input type='hidden' value='".$nitavu."' name='quien'>";
			echo "<input type='hidden' value='".$_GET['n']."' name='no'>";

				echo "<div>";
				echo "<label for='direccion'>Direccion: ".$f['direccion'];
				echo "<select name='direccion'>";
				
					$sql = "SELECT * FROM cat_gerarquia where nivel='dir' ORDER by nombre ASC";
					$r = $conexion -> query($sql);
					while($f2 = $r -> fetch_array())
						{ // resultado de la busqueda.................
							if ($f['direccion']==$f2['id']){
								echo "<option selected='selected' value='".$f2['id']."'>".$f2['nombre']. " </option>";							
							} else {
								echo "<option value='".$f2['id']."'>".$f2['nombre']. " </option>";						
							}
						}
						
				echo "</select>";
				echo "</label>";
				echo "</div>";

				echo "<div>";
				echo "<label for='departamento'>Departamento: ID";
				echo "<select name='dpto' >";
				
					$sql = "SELECT * FROM cat_gerarquia order by nombre";
					$r = $conexion -> query($sql);
					$t="";
					while($f3 = $r -> fetch_array())
						{ // resultado de la busqueda.................
							echo "<option  value='".$f3['id']."'>".$f3['nombre']. " </option>";		
							if ($f['dpto']==$f3['id']){$t=$f3['nombre'];}						
						}
							echo "<option selected='selected'  value='".$f['dpto']."'>".$t. " </option>";								
				
				echo "</select>";
				echo "</label>";
				echo "</div>";

				echo "<div>";
				echo "<label for='departamento'>Titular de:";
				echo "<select name='titular' >";
				
					$sql = "SELECT * FROM cat_gerarquia where titular='' or titular='".$f['nitavu']."'";
					// echo $sql;
					$r = $conexion -> query($sql);
					$t2="";
					while($f3 = $r -> fetch_array())
						{ // resultado de la busqueda.................
							echo "<option  value='".$f3['id']."'>".$f3['nombre']. " </option>";		
							if ($f['nitavu']==$f3['id']){$t2=$f3['nombre'];}						
						
						
						}
						$sql = "SELECT * FROM cat_gerarquia WHERE titular='".$_GET['n']."'";
						$rc= $conexion -> query($sql);
						if($fs = $rc -> fetch_array())
						{
							echo "<option selected='selected'  value='".$fs['id']."'>".$fs['nombre']. " </option>";
						}
						else {						
							echo "<option selected='selected'  value=''>Personal Operativo</option>";								
						}
						
						echo "<option value=''>Personal Operativo o Vacante</option>";
				echo "</select>";
				echo "</label>";
				echo "</div>";
				
				echo "<div>";
				echo "<label for='puesto'>Puesto:";
				echo "<input type='text' name='puesto' value='".$f['puesto']."' >";
				echo "</label>";
				echo "</div>";

				echo "<div>";
				echo "<label for='nivel' required='required'>Nivel:</label>";
				echo "<input type='text' name='nivel' id='nivel' value='".$f['nivel']."'>";
				echo "</div>";
				

				echo "<div>";
				echo "<label for='secc'>SECC:</label>";
				echo "<input type='text' name='secc' id='secc' value=".$f['secc'].">";
				echo "</div>";


				echo "<div>";
				echo "<label for='sap'>Numero SAPP:</label>";
				echo "<input type='text' name='sap' id='sap' value=".$f['sap'].">";
				echo "</div>";
			


				echo "<div>";
				echo "<label for='telefono'>Telefono de Oficina:</label>";
				echo "<input type='tel' name='telefono' id='telefono' value='".$f['telefono']."'>";
				echo "</div>";

				echo "<div>";
				echo "<label for='telefono_extension'>Extension de telefono:</label>";
				echo "<input type='text' name='telefono_extension' id='telefono' value='".$f['telefono_extension']."'>";
				echo "</div>";

				echo "<div>";
					echo "<div>";
					echo "<label for='profesion_abr'>Profesion abreviatura:</label>";
					echo "<input type='text' name='profesion_abr' id='profesion_abr' value='".$f['profesion_abr']."'>";
					echo "</div>";

					echo "<div>";
					echo "<label for='profesion'>Profesion:</label>";
					echo "<input type='text' name='profesion' id='telefono' value='".$f['profesion']."'>";
					echo "</div>";

				echo "</div>";

				//AGREGANDO SUELDO Y COMPE
				echo "<div>";
					echo "<label for='sueldo'>Sueldo:</label>";
					echo "<input type='text' name='sueldo' id='sueldo' value='".$f['sueldo']."'>";
				echo "</div>";

				// echo "<div>";
				// 	echo "<label for='sueldo'>Compensación:</label>";
					echo "<input type='hidden' name='compe' id='compe' value='".$f['compensacion']."'>";
				// echo "</div>";




				echo "<div>";
				echo ponerfoto("firmas/".$f['nitavu'].".jpg",'icono_usuario');
				echo "<label for='firma_file'>Archivo de la rubrica de la firma:</label>";
				echo "<input type='file' name='firma_file' id='firma_file'>";
				echo "</div>";


				echo "<span>";
				echo "<label class='alerta'>Utilize esta opcion para darlo de baja o suspencion temporal <b class='ejecutandose'>* NO TENDRA ACCESO A LA PLATAFORMA</b></label>";

				echo "<select name='estado'>";


				echo "<option value=''>Activo</option>";
				echo "<option value='Baja permanente'>Baja permanente</option>";
				echo "<option value='Baja temporal'>Baja temporal</option>";
				echo "<option value='comisionado'>comisionado</option>";
				//echo "<option value='Bloqueado'>Bloquear acceso a la plataforma</option>";

				echo "<option value='".$f['estado']."' selected='selected'>".$f['estado']."</option>";
				echo "</select>";
				echo "</span>";



				echo "<hr>";


				echo "<div class='alerta'>";
				echo "<label for='comida'>Tiempo autorizado para comida:</label>";
				
				echo "<select name='comida' id='comida'>";
				if ($f['comida'] == '00:30:00'){
					echo "<option value='00:30:00' selected>30min</option>";					
				}

				if ($f['comida'] == '01:00:00'){
					echo "<option value='01:00:00' selected>1hr</option>";					
				}

				if ($f['comida'] == '01:30:00'){
					echo "<option value='01:30:00' selected>1hr 30min</option>";					
				}

				if ($f['comida'] == '02:00:00'){
					echo "<option value='02:00:00' selected>2hr</option>";					
				}
				if ($f['comida'] == '03:00:00'){
					echo "<option value='03:00:00' selected>3hr</option>";					
				}

				if ($f['comida'] == '03:30:00'){
					echo "<option value='00:30:00' selected>3hr 30min</option>";					
				}

				if ($f['comida'] == '04:00:00'){
					echo "<option value='04:00:00' selected>4hr</option>";					
				}

				echo "<option value='00:30:00'>30min</option>";
				echo "<option value='01:00:00'>1hr</option>";
				echo "<option value='01:30:00'>1hr 30min</option>";
				echo "<option value='02:00:00'>2hr</option>";
				echo "<option value='02:30:00'>2hr 30min</option>";
				echo "<option value='03:00:00'>3hr</option>";
				echo "<option value='03:30:00'>3hr 30min</option>";
				echo "<option value='04:00:00'>4hr</option>";
				
				echo "</select>";
				
				echo "</div>";

				echo "<hr>";
				echo "<h1>COMIDA</h1>";
				echo "<div>";
				echo "<label for='horario_entrada'>Entrada:</label>";
				echo "<input type='time' name='horario_entrada' id='horario_entrada' value='".$f['horario_entrada']."'>";
				echo "</div>";

				echo "<div>";
				echo "<label for='horario_salida'>Salida:</label>";
				echo "<input type='time' name='horario_salida' id='horario_salida' value='".$f['horario_salida']."'>";
				echo "</div>";

				echo "<hr>";

				echo "<span>";
				echo sugerencia("No utilice apostrofes o comillas, afecta a la integredad de los datos.");
				echo "<div>";

				echo "<input type='submit' value='Actualizar Datos' class='btn btn-default'>";
				echo "</div></div></span>";



				echo "</form>";

			}else{
				echo "<div id='lab' class='pesta invisible'></div>";
			}
		}
	}
		
	}


}
else{
	mensaje("No tiene acceso a esta aplicacion","");
}





?>




<br>
<?php
include ("unica/body_footer.php");
?>