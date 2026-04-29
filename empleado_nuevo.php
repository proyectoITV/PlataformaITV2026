<?php
//include (".//seguridad.php"); 
include ("./lib/body_head.php");
include ("./lib/body_menu.php");

// contenido:
?>


<?php
//PROCESO PARA TOCAR LA PUERTA DE SAN PEDRO
$id_aplicacion ="ap07"; //ap07=Permisos de Aplicacion
if (sanpedro($id_aplicacion, $nitavu)==TRUE){
	echo "<div id='AppDetalle'>".app_detalle($id_aplicacion, $nitavu)."</div>";

	echo "<form action='empleado_nuevo_validar.php'  method='POST' enctype='multipart/form-data'>";

	echo "<input type='hidden' value='".$nitavu."' name='quien'>";

	echo "<div>";
	echo "<label for='no'>Numero de ITAVU:</label>";
	echo "<input type='text' name='no' id='no'>";
	echo "</div>";
	
	

	// echo "<div>";
	// echo "<label for='sap'>Numero SAPP:</label>";
	// echo "<input type='text' name='sap' id='sap'>";
	// echo "</div>";
	

	// echo "<div>";
	// echo "<label for='secc'>SECC:</label>";
	// echo "<input type='text' name='secc' id='secc'>";
	// echo "</div>";

	
	// echo "<div>";
	// 			echo "<label for='direccion'>Direccion: ";
	// 			echo "<select name='direccion'>";
				
	// 				$sql = "SELECT * FROM cat_gerarquia where nivel='dir' ORDER by nombre ASC";
	// 				$r = $conexion -> query($sql);
	// 				while($f2 = $r -> fetch_array())
	// 					{ // resultado de la busqueda.................
	// 						if ($f['direccion']==$f2['id']){
	// 							echo "<option selected='selected' value='".$f2['id']."'>".$f2['nombre']. " </option>";							
	// 						} else {
	// 							echo "<option value='".$f2['id']."'>".$f2['nombre']. " </option>";						
	// 						}
	// 					}
						
	// 			echo "</select>";
	// 			echo "</label>";
	// 			echo "</div>";




	echo "<div>";
	echo "<label for='nombre'>Nombre completo (escriba primero nombre y despues apellidos, respetando mayusculas y minusculas):</label>";
	echo "<input type='text' name='nombre_' id='nombre_' required='required'>";
	echo "</div>";



	echo "<div>";
				echo "<label for='departamento'>Departamento: ID";
				echo "<select name='dpto' class='form-control' >";
				
					$sql = "SELECT * FROM cat_gerarquia order by nombre";
					$r = $conexion -> query($sql);
					$t="";
					while($f3 = $r -> fetch_array())
						{ // resultado de la busqueda.................
							echo "<option  value='".$f3['id']."'>".$f3['nombre']. " </option>";		
							// if ($f3['dpto']==$f3['id']){$t=$f3['nombre'];}						
						}
							echo "<option selected='selected'  value='".$f['dpto']."'>".$t. " </option>";								
				
				echo "</select>";
				echo "</label>";
				echo "</div>";


	echo "<label for='puesto'>Puesto:";
	echo "<input type='text' name='puesto' required='required'>";
	
		// $sql = "SELECT * FROM puestos ORDER by descripcion ASC";
		// $r = $conexion -> query($sql);
		// while($f = $r -> fetch_array())
		// 	{ // resultado de la busqueda.................
		// 		echo "<option value='".$f['descripcion']."'>".$f['descripcion']. " </option>";
		// 	}
	
	// echo "</select>";
	echo "</label>";
	echo "</div>";



	// echo "<div>";
	// echo "<label for='nivel' required='required'>Nivel:</label>";
	// echo "<input type='text' name='nivel' id='nivel'>";
	// echo "</div>";
	

	// echo "<div>";
	// echo "<label for='correoelectronico'>Correo electronico:</label>";
	// echo "<input type='email' name='correoelectronico' id='correoelectronico'>";
	// echo "</div>";


	// echo "<div>";
	// echo "<label for='telefono'>Telefono:</label>";
	// echo "<input type='text' name='telefono' id='telefono'>";
	// echo "</div>";


	// echo "<div>";
	// 	echo "<label for='telefono2'>Telefono 2:</label>";
	// 	echo "<input type='tel' name='telefono2' id='telefono' value=''>";
	// 	echo "</div>";

	// 	echo "<div>";
	// 	echo "<label for='telefono_extension'>Telefono Extension:</label>";
	// 	echo "<input type='text' name='telefono_extension' id='telefono' value=''>";
	// 	echo "</div>";

	// 	echo "<div>";
	// 		echo "<div>";
	// 		echo "<label for='profesion_abr'>Profesion Abr:</label>";
	// 		echo "<input type='text' name='profesion_abr' id='profesion_abr' value=''>";
	// 		echo "</div>";

	// 		echo "<div>";
	// 		echo "<label for='profesion'>Profesion:</label>";
	// 		echo "<input type='text' name='profesion' id='telefono' value=''>";
	// 		echo "</div>";

	// 	echo "</div>";


	// echo "<div>";
	// echo "<label for='telefono_movil'>Telefono Movil:</label>";
	// echo "<input type='text' name='telefono_movil' id='telefono_movil'>";
	// echo "</div>";


	// echo "<div>";
	// echo "<label for='foto_file'>Archivo de la foto:</label>";
	// echo "<input type='file' name='foto_file' id='foto_file' >";
	// echo "</div>";


	// echo "<div>";
	// echo "<label for='firma_file'>Archivo de la rubrica de la firma:</label>";
	// echo "<input type='file' name='firma_file' id='firma_file'>";
	// echo "</div>";



	// echo "<div>";
	// echo "<label for='fecha_nacimiento'>Fecha de Nacimiento:</label>";
	// echo "<input type='date' name='fecha_nacimiento' id='fecha_nacimiento' required='required' placeholder='AAAA-MM-DD'>";
	// echo "</div>";


	echo "<span>";
	echo sugerencia("Es importante, que edite posteriormente al empleado para llenar los datos restantes");
	echo "<div>";

	echo "<input type='submit' value='Agregar' class='Mbtn btn-default'>";
	echo "</div></div></span>";



	echo "</form>";



}
else{echo "No tiene acceso a ".$id_aplicacion;}











?>




<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
<?php
include ("./lib/body_footer.php");
?>