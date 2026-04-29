<?php
//include (".//seguridad.php"); 
include ("./lib/body_head.php");
include ("./lib/body_menu.php");

// contenido:
?>



<?php








?>






<?php
//PROCESO PARA TOCAR LA PUERTA DE SAN PEDRO
$id_aplicacion ="ap02"; //ap07=Permisos de Aplicacion
if (sanpedro($id_aplicacion, $nitavu)==TRUE){
	echo "<div id='AppDetalle'>".app_detalle($id_aplicacion, $nitavu)."</div>";

	$n=$_GET['n'];//var con la que nos manda la busqueda y nos indica que numero de itavu tiene

	$sql = "SELECT * FROM empleados WHERE nitavu='".$n."'";
	$rc= $conexion -> query($sql);
	if($f = $rc -> fetch_array()){

		historia($nitavu,'Vio perfil de '.nitavu_nombre($f['nitavu']));
		echo "<div id='pesta_elementos'>";
		$mas="";
		if (isset($_GET['n'])){
				$mas="&n=".$_GET['n'];
		}
		if (isset($_GET['pes'])) {
				if ($_GET['pes']=='gral'){
					echo "<a class='seleccionada' href='?pes=gral".$mas."'>GENERALES</a>";	
					echo "<a class='sinseleccion' href='?pes=lab".$mas."'>LABORALES</a>";	
					echo "<a class='sinseleccion' href='?pes=doc".$mas."'>DOCUMENTOS</a>";	
				}	
			}

		if (isset($_GET['pes'])) {
				if ($_GET['pes']=='lab'){
					echo "<a class='sinseleccion' href='?pes=gral".$mas."'>GENERALES</a>";	
					echo "<a class='seleccionada' href='?pes=lab".$mas."'>LABORALES</a>";	
					echo "<a class='sinseleccion' href='?pes=doc".$mas."'>DOCUMENTOS</a>";	
				}	
			}

		if (isset($_GET['pes'])) {
				if ($_GET['pes']=='doc'){
					echo "<a class='sinseleccion' href='?pes=gral".$mas."'>GENERALES</a>";	
					echo "<a class='sinseleccion' href='?pes=lab".$mas."'>LABORALES</a>";	
					echo "<a class='seleccionada' href='?pes=doc".$mas."'>DOCUMENTOS</a>";	
				}	
			}

		echo "</div>";







	



		if (isset($_GET['pes'])) {
			if ($_GET['pes']=='gral'){echo "<div id='generales' class='pesta visible'>";	
			//echo "<div id='AppDetalle'>GENERALES:</div>";

			echo "<form action='empleado_edit_valida2_gral.php'  method='POST' enctype='multipart/form-data'>";
			echo "<input type='hidden' value='".$nitavu."' name='quien'>";
			
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
			echo "<label for='sap'>Numero SAPP:</label>";
			echo "<input type='text' name='sap' id='sap' value=".$f['sap'].">";
			echo "</div>";
			

		


			echo "<div>";
			echo "<label for='correoelectronico'>Correo electronico:</label>";
			echo "<input type='email' name='correoelectronico' id='correoelectronico' value='".$f['correoelectronico']."'>";
			echo "</div>";

			echo "<div>";
			echo "<label for='telefono2'>Telefono 2:</label>";
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





			echo "<span>";
			echo sugerencia("No utilice apostrofes o comillas, afecta a la integredad de los datos.");
			echo "<div>";

			echo "<input type='submit' value='Actualizar Datos' class='Mbtn btn-default'>";
			echo "</div></div></span>";



			echo "</form>";







			echo "</div>";
			}
			else
			{echo "<div id='generales' class='pesta invisible'></div>";}
			}

		

		if (isset($_GET['pes'])) {
			if ($_GET['pes']=='lab'){
				echo "<div id='laborales' class='pesta visible'>";	

			echo "<form action='empleado_edit_valida2_lab.php'  method='POST' enctype='multipart/form-data'>";
			echo "<input type='hidden' value='".$nitavu."' name='quien'>";

				echo "<div>";
				echo "<label for='direccion'>Direccion: ".$f['direccion'];
				echo "<select name='direccion'>";
				
					$sql = "SELECT * FROM direcciones ORDER by descripcion ASC";
					$r = $conexion -> query($sql);
					while($f2 = $r -> fetch_array())
						{ // resultado de la busqueda.................
						echo "<option value='".$f2['descripcion']."'>".$f2['descripcion']. " </option>";						
						}
						echo "<option selected='selected' value='".$f['direccion']."'>".$f['direccion']. " </option>";							
				echo "</select>";
				echo "</label>";
				echo "</div>";


				echo "<div>";
				echo "<label for='departamento'>Departamento:".$f['departamento'];
				echo "<select name='departamento' required='required'>";
				
					$sql = "SELECT * FROM departamentos ORDER by descripcion ASC";
					$r = $conexion -> query($sql);
					while($f3 = $r -> fetch_array())
						{ // resultado de la busqueda.................
							echo "<option  value='".$f['departamento']."'>".$f3['descripcion']. " </option>";								
						}
							echo "<option selected='selected'  value='".$f['departamento']."'>".$f['departamento']. " </option>";								
				
				echo "</select>";
				echo "</label>";
				echo "</div>";


				
				echo "<div>";
				echo "<label for='puesto'>Puesto: (Este dato se cambia desde la opcion cambio de puesto)";
				echo "<input type='text' name='direccio' value='".$f['puesto']."' >";
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
				echo "<label for='telefono'>Telefono:</label>";
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






				echo "<div>";
				echo ponerfoto("firmas/".$f['nitavu'].".jpg",'icono_usuario');
				echo "<label for='firma_file'>Archivo de la rubrica de la firma:</label>";
				echo "<input type='file' name='firma_file' id='firma_file'>";
				echo "</div>";






				echo "<span>";
				echo sugerencia("No utilice apostrofes o comillas, afecta a la integredad de los datos.");
				echo "<div>";

				echo "<input type='submit' value='Actualizar Datos' class='Mbtn btn-default'>";
				echo "</div></div></span>";



				echo "</form>";

			echo "</div>";


			}
			else
			{echo "<div id='lab' class='pesta invisible'></div>";}
		}



		if (isset($_GET['pes'])) {
			if ($_GET['pes']=='doc'){echo "<div id='doc' class='pesta visible'>";	}
			else
			{echo "<div id='doc' class='pesta invisible'>";}
		}
		echo "<div id='AppDetalle'>DOCUMENTOS:</div>";
		echo "</div>";


































































	
		// echo "<div>";
		// echo "<label for='direccion'>Direccion: (Este dato se cambia mediante el apartado de cambio de departamento)";
		// echo "<input type='text' name='direccio' value='".$f['direccion']."' readonly='readonly'>";
		// echo "</label>";
		// echo "Haga clic <a href='empleado_departamento_update.php'>aqui</a> para actualizar este dato";
		// echo "</div>";


	




		




	}


}
else{
	mensaje("No tiene acceso a esta aplicacion","");
}











?>




<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
<?php
include ("./lib/body_footer.php");
?>