<?php
//include (".//seguridad.php"); 
include ("./lib/body_head.php");
include ("./lib/body_menu.php");

// contenido:
?>






<?php
//PROCESO PARA TOCAR LA PUERTA DE SAN PEDRO
$id_aplicacion ="ap54"; //ap07=Permisos de Aplicacion
if (sanpedro($id_aplicacion, $nitavu)==TRUE)
{
	echo "<div id='AppDetalle'>".app_detalle($id_aplicacion, $nitavu)."</div>";
$curp='';
	$n=$_GET['n'];//var con la que nos manda la busqueda y nos indica que numero de itavu tiene

	$sql = "-- per 
	SELECT * FROM solicitantes WHERE IdSolicitante='".$n."'";
	$reg='0';
	$rc= $conexion -> query($sql);
	if($fx = $rc -> fetch_array())
	{
		historia($nitavu,'Per_Vio perfil de '.persona_nombre($fx['IdSolicitante']));
		echo "<div id='pesta_elementos'>";
			$mas="";
			if (isset($_GET['n']))
			{
					$mas="&n=".$_GET['n'];
			}
			if (isset($_GET['pes'])) 
			{
				if ($_GET['pes']=='gral')
				{
						echo "<a class='seleccionada' href='?pes=gral".$mas."'>GENERALES</a>";	
						//echo "<a class='sinseleccion' href='?pes=lab".$mas."'>LABORALES</a>";	
						echo "<a class='sinseleccion' href='?pes=doc".$mas."'>DOCUMENTOS</a>";	
				}	
			}

			// if (isset($_GET['pes'])) {
			// 		if ($_GET['pes']=='lab'){
			// 			echo "<a class='sinseleccion' href='?pes=gral".$mas."'>GENERALES</a>";	
			// 			echo "<a class='seleccionada' href='?pes=lab".$mas."'>LABORALES</a>";	
			// 			echo "<a class='sinseleccion' href='?pes=doc".$mas."'>DOCUMENTOS</a>";	
			// 		}	
			// 	}

			if (isset($_GET['pes'])) 
			{
				if ($_GET['pes']=='doc')
				{
					echo "<a class='sinseleccion' href='?pes=gral".$mas."'>GENERALES</a>";	
					//echo "<a class='sinseleccion' href='?pes=lab".$mas."'>LABORALES</a>";	
					echo "<a class='seleccionada' href='?pes=doc".$mas."'>DOCUMENTOS</a>";	
				}	
			}
		echo "</div>";
		if (isset($_GET['pes'])) 
		{
			if ($_GET['pes']=='gral')
			{
				echo "<div id='generales' class='pesta visible'>";	
				echo "<div id='AppDetalle'>GENERALES:</div>";
				echo "<form action='per_registrar_persona_bd.php'   method='POST' enctype='multipart/form-data'>";

				if($fx['Registrado']=='1')
				{
					$reg='1';
					$sql = "-- per 
					SELECT * FROM personas WHERE IdSolicitante='".$n."'";			
					echo "<input type='hidden' name='reg' id='reg' value='1'>";
					
				}
				else
				{
					$reg='0';
					$sql = "-- per 
					SELECT * FROM solicitantes  WHERE solicitantes.IdSolicitante='".$n."'";		
					echo "<input type='hidden' name='reg' id='reg' value='0'>";
					
				}
				$rc= $conexion -> query($sql);
				if($f = $rc -> fetch_array())
				{
					echo "<input type='hidden' value='".$f['Curp']."' name='curp'>";
					

					echo "<input type='hidden' name='idsolicitante'  value='".$n."'>";			
					
					echo "<div >";
					
					echo ponerfoto("fotos_personas/".$f['Curp'],'foto');
					echo "<label for='foto_file'>Para actualizar la foto, seleccione un archivo:</label>";
					echo "<input type='file' name='foto_file' id='foto_file'>";
					echo "</div>";
					echo "<br>";
					echo "<br>";

					echo "<div  >";
					echo "<label for='nombre'>Nombre:</label>";
					echo "<input type='text' name='nombre'  value='".$f['Nombre']."'>";
					echo "</div>";


					echo "<div >";
					echo "<label for='paterno'>Apellido Paterno:</label>";
					echo "<input type='text' name='paterno' id='paterno'  value='".$f['Paterno']."'>";
					echo "</div>";

					echo "<div >";
					echo "<label for='materno'>Apellido Materno:</label>";
					echo "<input type='text' name='materno' id='materno'  value='".$f['Materno']."'>";
					echo "</div>";		
						
					$fnac= date("Y-m-d",strtotime($f['FNacimiento']));
					echo "<div >";
					echo "<label for='fecha_nacimiento'>Fecha de Nacimiento:</label>";
					echo "<input type='date' name='fecha_nacimiento' id='fecha_nacimiento' required='required' placeholder='AAAA-MM-DD' 
					value='".$fnac."'>";
					echo "</div>";

					echo "<div >";
					echo "<label for='lugarNac'>Lugar Nacimiento:</label>";
					echo "<input type='text' name='lugarNac' id='lugarNac' value='".$f['LugarNacSol']."'>";
					echo "</div>";


					echo '
					<div >
					<label>Estado</label>
					<select name="estadocivil" id="estadocivil">';
					$sql = "-- per 
					SELECT * FROM estados ";
					$tmp="";
					$r2 = $conexion -> query($sql);
					while($fx = $r2 -> fetch_array())
						{//Categorias de Aplicaciones
						echo '<option value="'.$fx['IdEstado'].'">'.$fx['Estado'].'</option>';
							if ($f['IdEstadoNac']==$fx['IdEstado'])
							{
								$tmp=$fx['Estado'];
							}
						}

					if ($tmp=='')
					{
						echo '<option value="0" selected="selected">NINGUNO</option>';	
					}
					else
					{
							echo '<option value="'.$f['IdEstadoNac'].'" selected="selected">'.$tmp.'</option>';	
					}


					echo '
					</select>
					</div>';

					

					echo "<div >";
					echo "<label for='rfc'>RFC:</label>";
					echo "<input type='text' name='rfc' id='rfc' value='".$f['RFC']."' >";
					echo "</div>";


					if($reg=='1')			
					{		
						//echo "<input type='hidden' name='curp' id='curp' value='".$f['Curp']."'>";	
						echo "<div >";
						echo "<label for='curp'>CURP:</label>";
						echo "<input type='text' required name='curp' readonly id='curp' value='".$f['Curp']."'>";
						echo "</div>";	
						
						echo "<div >";
						echo "<label for='telefono2'>Telefono Personal:</label>";
						echo "<input type='tel' name='telefono' id='telefono' pattern='\([0-9]{1,3}\)[ -][0-9]{3}[ -][0-9]{4}'  placeholder='(LADA)-000-0000' value='".$f['TelefonoFijo']."'>";
						echo "</div>";

						echo "<div >";
						echo "<label for='telefono_movil'>Telefono Movil:</label>";
						echo "<input type='tel' name='telefono_movil' id='telefono_movil'  pattern='\([0-9]{1,3}\)[ -][0-9]{3}[ -][0-9]{4}' placeholder='(LADA)-000-0000'  value='".$f['TelefonoMovil']."'>";
						echo "</div>";

						echo "<div >";
						echo "<label for='correoelectronico'>Correo electronico:</label>";
						echo "<input type='email' name='correoelectronico' id='correoelectronico' value='".$f['CorreoElectronico']."'>";
						echo "</div>";

						echo"<div >";
						echo "<label for='facebook'>Facebook:</label>";
						echo "<input type='text' name='facebook' id='facebook' value='".$f['Facebook']."'>";
						echo "</div>";

						echo"<div >";
						echo "<label for='twitter'>Twitter:</label>";
						echo "<input type='text' name='twitter' id='twitter' value='".$f['Twitter']."'>";
						echo "</div>";

						echo "<span>";
						echo sugerencia("No utilice apostrofes o comillas, afecta a la integredad de los datos.");
						echo "<div class='divChico'>";

						echo "<input type='submit' value='Actualizar Datos' class='Mbtn btn-default'>";
						echo "</div></div></span>";
					
					}
					else
					{
						echo "<div >";
						echo "<label for='curp'>CURP:</label>";
						echo "<input type='text' name='curp' required id='curp' value='".$f['Curp']."'>";
						echo "</div>";

						
						echo "<div >";
						echo "<label for='telefono'>Telefono Personal:</label>";
						echo "<input type='tel' name='telefono' id='telefono'   pattern='\([0-9]{1,3}\)[ -][0-9]{3}[ -][0-9]{4}' placeholder='(LADA)-000-0000' value=''>";
						echo "</div>";

						echo "<div >";
						echo "<label for='telefono_movil'>Telefono Movil:</label>";
						echo "<input type='tel' name='telefono_movil' id='telefono_movil'  pattern='\([0-9]{1,3}\)[ -][0-9]{3}[ -][0-9]{4}' placeholder='(LADA)-000-0000'  value=''>";
						echo "</div>";

						echo"<div >";
						echo "<label for='correoelectronico'>Correo electronico:</label>";
						echo "<input type='email' name='correoelectronico' id='correoelectronico' value=''>";
						echo "</div>";

						echo"<div >";
						echo "<label for='facebook'>Facebook:</label>";
						echo "<input type='text' name='facebook' id='facebook' value=''>";
						echo "</div>";

						echo"<div >";
						echo "<label for='twitter'>Twitter:</label>";
						echo "<input type='text' name='twitter' id='twitter' value=''>";
						echo "</div>";

						echo "<span>";
						echo sugerencia("No utilice apostrofes o comillas, afecta a la integredad de los datos.");
						echo "<div>";

						echo "<input type='submit' value='Registrar Datos' class='Mbtn btn-default'>";
						echo "</div></div></span>";
					}
				}
			
		echo "</form>";
		echo "</div>";
		}
		else
		{
			echo "<div id='generales' class='pesta invisible'></div>";}
		}
		if (isset($_GET['pes'])) 
		{
			if ($_GET['pes']=='doc')
			{
				echo "<div id='doc' class='pesta visible'>";	
				echo "<div id='AppDetalle'>DOCUMENTOS:</div>";
			//	listar_archivos('docs_personas/','MAPT600805MVZRNR09_curp');

				echo "<form action='per_persona_edit_doc_bd.php' method='POST' enctype='multipart/form-data'>";		

					
			
					$sql = "-- per 
					SELECT * FROM personas  WHERE IdSolicitante='".$n."'";
				
				
	
				$rc= $conexion -> query($sql);
				if($f = $rc -> fetch_array())
					{
												
						echo "<input type='hidden' value='".$f['Curp']."' name='curp'>";

						echo "<article>";
						echo "CURP:<br>";
						echo ponerfoto("docs_personas/".$f['Curp']."_curp",'foto');	
						echo "<label for='curp'> Seleccione un archivo (.JPG) para actualizar </label>";
						echo "<div class='fileUpload Mbtn btn-secundario'>";				
						echo "Seleccionar";
						echo "<input type='file' name='curp' class='upload'>";	
						echo "</div>";
						echo "</article>";



						echo "<article>";
						echo "ACTA DE NACIMIENTO:<br>";
						echo ponerfoto("docs_personas/".$f['Curp']."_acta",'foto');	
						echo "<label for='acta'> Seleccione un archivo (.JPG) para actualizar </label>";
						echo "<div class='fileUpload Mbtn btn-secundario'>";				
						echo "Seleccionar";
						echo "<input type='file' name='acta' class='upload'>";	
						echo "</div>";
						echo "</article>";

			
						echo "<article>";
						echo "IFE: credencial de elector<br>";
						echo ponerfoto("docs_personas/".$f['Curp']."_ife",'foto');	
						echo "<label for='ife'> Seleccione un archivo (.JPG) para actualizar </label>";
						echo "<div class='fileUpload Mbtn btn-secundario'>";				
						echo "Seleccionar";
						echo "<input type='file' name='ife' class='upload'>";	
						echo "</div>";
						echo "</article>";


						echo "<article>";
						echo "<input type='submit' class='Mbtn btn-default' value='Guardar Documentos'>";
						echo "</<article>";
						}
				echo "</form>";
				echo "</div>";
			
			}
			else
			{
				echo "<div id='doc' class='pesta invisible'></div>";
			}
		}

		
	}	
}
else
{
echo "<br><br>";
	mensaje("No tiene acceso al modúlo de personas beneficiadas (".$id_aplicacion.")", "index.php");
}



?>
<script>
var telefono = document.getElementById("telefono");

telefono.addEventListener("keyup", function (event) {
  if (telefono.validity.patternMismatch) {
    telefono.setCustomValidity("¡Por favor introduzca un número de telefono con un formato valido. (LADA)-000-0000!");
  } else {
    telefono.setCustomValidity("");
  }
});


var telefono2 = document.getElementById("telefono_movil");

telefono2.addEventListener("keyup", function (event) {
  if (telefono2.validity.patternMismatch) {
    telefono2.setCustomValidity("¡Por favor introduzca un número de telefono con un formato valido. (LADA)-000-0000!");
  } else {
    telefono2.setCustomValidity("");
  }
});

</script>

	<br><br><br><br><br><br>
	<br><br><br><br><br><br>
	<br><br><br><br><br><br>
	<br><br><br><br><br><br>
	<br><br><br><br><br><br>
	<?php
	include ("./lib/body_footer.php");
	?>