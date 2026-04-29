<?php include ("./unica/body_head.php"); include ("./unica/body_menu.php"); ?>
<?php
$idapp="";
$idapp_nombre="Digitalizacion";
//historia($nitavu, "Vio ".$idapp_nombre);
//$nivel=2;

?>

<?php
$id_aplicacion ="ap40"; //Id de la aplicacion a cargar
$nivel = aplicacion_nivel($id_aplicacion, $nitavu);
$ok_folio="";
$ok_programa="";
$ok_delegacion="";
$ok="";

$sec_itavu="";
if (sanpedro($id_aplicacion, $nitavu)==TRUE){
echo "<h5>".app_detalle($id_aplicacion)."</h5>";
	xd_update('ap40',$nitavu);//guarda la experiencia del usuario
	historia($nitavu, "Entro a la aplicacion [ap40], para digitalizar documentos");

	echo "<div id='pesta_elementos'>";
		$mas="";

		if (isset($_GET['pes'])) {
			if ($_GET['pes']=='itavu'){
					echo "<a class='seleccionada' href='?pes=itavu".$mas."'>ITAVU</a>";	
					echo "<a class='sinseleccion' href='?pes=personales".$mas."'>PERSONALES</a>";						
					echo "<a class='sinseleccion' href='?pes=ayuda".$mas."'>AYUDA</a>";						
			}	
		}

		if (isset($_GET['pes'])) {
			if ($_GET['pes']=='personales'){
				echo "<a class='sinseleccion' href='?pes=itavu".$mas."'>ITAVU</a>";	
				echo "<a class='seleccionada' href='?pes=personales".$mas."'>PERSONALES</a>";	
				echo "<a class='sinseleccion' href='?pes=ayuda".$mas."'>AYUDA</a>";						
				
			}
		}

		if (isset($_GET['pes'])) {
			if ($_GET['pes']=='ayuda'){
				echo "<a class='sinseleccion' href='?pes=itavu".$mas."'>ITAVU</a>";	
				echo "<a class='sinseleccion' href='?pes=personales".$mas."'>PERSONALES</a>";
				echo "<a class='seleccionada' href='?pes=ayuda".$mas."'>AYUDA</a>";							
				
			}
		}
	echo "</div>";



		if (isset($_GET['pes'])) {
			if ($_GET['pes']=='itavu')
			{echo "<div id='itavu' class='pesta visible'>";

				echo "<section id='digital_sec_itavu'>"; 
				echo "<table border='0' width='100%' class='pc' ><tr>";	///version pc	 			
				echo ""."<form action='digital.php' method='get'  enctype='multipart/form-data'>";
				echo "<input type='hidden' name='pes' value='itavu'>";

				echo "<td>";
				echo "<div><label>Folio</label>";
				if (isset($_GET['folio'])){
							echo "<input type='text' name='folio' required='required' value='".$_GET['folio']."' accept='.pdf'></div>";
				} else {echo "<input type='text' name='folio' required='required'></div>";}
				echo "</td><td>";
	
				
				echo "<div><label>Delegacion</label><select name='del' >";		
				$sql = "SELECT * FROM cat_delegaciones ORDER by nombre ASC";
				$r = $conexion -> query($sql);	while($f = $r -> fetch_array())
				{ 
					if (isset($_GET['del'])){
						if ($_GET['del']==$f['id']){
							echo "<option value='".$f['id']."' selected='selected'>".$f['nombre']."</option>";		
						}else {echo "<option value='".$f['id']."'>".$f['nombre']."</option>";}
					} 
					else {echo "<option value='".$f['id']."'>".$f['nombre']."</option>";}
				}echo "</select></div>";
				echo "</td>";

				echo "<td>";
				echo "<div><label>Seleccione el Programa</label><select name='prog' >";		
				$sql = "SELECT * FROM cat_programa  ORDER by Programa ASC";
				$r = $conexion -> query($sql);	while($f = $r -> fetch_array()){ 
					if (isset($_GET['prog'])){
						if ($_GET['prog']==$f['IdPrograma']){
						echo "<option value='".$f['IdPrograma']."' selected='selected'>".$f['Programa']."</option>";		
						}else {echo "<option value='".$f['IdPrograma']."'>".$f['Programa']."</option>";}
			
				} else {echo "<option value='".$f['IdPrograma']."'>".$f['Programa']."</option>";}
				}echo "</select></div>";
				echo "</td>";
				echo "<td valign='bottom'>";
				echo "<input type='submit' value='Seleccionar' class='btn btn-default'></form>";

				echo "</td></tr></table>";



				//--------------------------------------------------------------------------------------
				echo "<table border='0' width='100%' class='movil' ><tr>";	///version movil
				echo ""."<form action='digital.php' method='get'  enctype='multipart/form-data'>";
				echo "<input type='hidden' name='pes' value='itavu'>";

				echo "<td>";
				echo "<div><label>Folio</label>";
				if (isset($_GET['folio'])){
							echo "<input type='text' name='folio' required='required' value='".$_GET['folio']."' accept='.pdf'></div>";
				} else {echo "<input type='text' name='folio' required='required'></div>";}
				echo "</td><td>";
	
				echo "</tr><tr><td>";
				echo "<div><label>Delegacion</label><select name='del' >";		
				$sql = "SELECT * FROM cat_delegaciones ORDER by nombre ASC";
				$r = $conexion -> query($sql);	while($f = $r -> fetch_array())
				{ 
					if (isset($_GET['del'])){
						if ($_GET['del']==$f['id']){
							echo "<option value='".$f['id']."' selected='selected'>".$f['nombre']."</option>";		
						}else {echo "<option value='".$f['id']."'>".$f['nombre']."</option>";}
					} 
					else {echo "<option value='".$f['id']."'>".$f['nombre']."</option>";}
				}echo "</select></div>";
				echo "</td>";
				echo "</tr><tr>";
				echo "<td>";
				echo "<div><label>Seleccione el Programa</label><select name='prog' >";		
				$sql = "SELECT * FROM cat_programa  ORDER by Programa ASC";
				$r = $conexion -> query($sql);	while($f = $r -> fetch_array()){ 
					if (isset($_GET['prog'])){
						if ($_GET['prog']==$f['IdPrograma']){
						echo "<option value='".$f['IdPrograma']."' selected='selected'>".$f['Programa']."</option>";		
						}else {echo "<option value='".$f['IdPrograma']."'>".$f['Programa']."</option>";}
			
				} else {echo "<option value='".$f['IdPrograma']."'>".$f['Programa']."</option>";}
				}echo "</select></div>";
				echo "</td>";
				echo "</tr><tr>";
				echo "<td valign='bottom'>";
				echo "<input type='submit' value='Seleccionar' class='btn btn-default'></form>";

				echo "</td></tr></table>";



				$datos="";
				//SI DETECTAMOS LAS 3 VAR QUE OCUPAMOS, HACEMOS LA CONSULTA Y VEMOS QUE DOCS TIENE YA
				if (isset($_GET['folio']) and isset($_GET['prog']) and isset($_GET['del']))
				{
				
					$sql = "
					SELECT
						solicitudes.IdSolicitante,
						solicitantes.Nombre,
						solicitantes.Paterno,
						solicitantes.Materno,
						solicitantes.Curp,
						solicitudes.IdDelegacion,
						solicitudes.IdPrograma,
						solicitudes.Folio,
						contratos.NumContrato
					FROM
						solicitudes
					LEFT OUTER JOIN contratos ON solicitudes.IdDelegacion = contratos.IdDelegacion
					AND solicitudes.IdPrograma = contratos.IdPrograma
					AND solicitudes.Folio = contratos.Folio
					LEFT OUTER JOIN solicitantes ON solicitudes.IdSolicitante = solicitantes.IdSolicitante
					WHERE
						(solicitudes.IdDelegacion = ".$_GET['del'].")
					AND (solicitudes.IdPrograma = ".$_GET['prog'].")
					AND (solicitudes.Folio = ".$_GET['folio'].")
					";
					$rc= $conexion -> query($sql);
					if($f = $rc -> fetch_array())
					{
						$datos = "Se encontro a nombre de: ".$f['Nombre']." ".$f['Paterno']." ".$f['Materno'];
						if ($f['NumContrato']=="") {
							$datos = $datos."<br>No se encontro un contrato. <b class='alerta'>Revise por favor</b><br>";

						} else {$datos = $datos." con Num. de Contrato ".$f['NumContrato'];}

						$ok_folio=$f['Folio'];
						$ok_programa=$f['IdPrograma'];
						$ok_delegacion=$f['IdDelegacion'];
						$ok_curp = $f['Curp'];
						$ok_idsolicitante = $f['IdSolicitante'];
						$ok_beneficiario = $f['Nombre']." ".$f['Paterno']." ".$f['Materno'];
						$ok_contrato = $f['NumContrato'];

						$ok="SI";
					 	echo "<span class='msg ejecutandose'>".$datos."</span>";




					
						echo "<form action='digital_valida.php' method='post'  enctype='multipart/form-data'>";
						$sql = "SELECT * FROM cat_documentos WHERE tipo='ITAVU-LOTES' ORDER by nombre ASC";
						echo "<input type='hidden' name='ok_folio' value='$ok_folio'>";
						echo "<input type='hidden' name='ok_programa' value='$ok_programa'>";
						echo "<input type='hidden' name='ok_delegacion' value='$ok_delegacion'>";
						echo "<input type='hidden' name='ok_curp' value='$ok_curp'>";
						echo "<input type='hidden' name='ok_idsolicitante' value='$ok_idsolicitante'>";
						echo "<input type='hidden' name='ok_beneficiario' value='$ok_beneficiario'>";
						echo "<input type='hidden' name='ok_contrato' value='$ok_contrato'>";
						echo "<input type='hidden' name='nitavu' value='$nitavu'>";

						echo "<table class='tabla'><th width='40px'>Estado</th><th>Documento</th>";
						if ($nivel<=2){// si es admin o superadmin
							echo "<th>Seleccione el Archivo a Subir</th>";}
						$r = $conexion -> query($sql);	while($doc = $r -> fetch_array())
						{
							echo "<tr>";
							$archivo = "digitales/".$ok_delegacion."_".$ok_programa."_".$ok_folio."_".$doc['id'].".pdf";			
							$d="";
							if (FTP_existe_archivo($archivo)=="TRUE"){		
							//COPIARLO A tmp PARA QUE PUEDAN VERSE
								if (FTP_descargar($archivo)=="TRUE"){
									$archivo = "/tmp/".$archivo;
									echo "<td><img src='icon/ok.png' class='digital_icono'></td>";//icono				
									$d = $doc['nombre']."_".$ok_delegacion."_".$ok_programa."_".$ok_folio."_".$doc['id'].".pdf";
									$historia = doc_historia($doc['id'], $ok_programa, $ok_folio, $ok_delegacion);			
									$link= "<a  download='".$archivo."' href='$archivo' target='_blank' class='digitalizados_vinculos' title='Haga click aqui para descargar'>".$doc['nombre']."</a>";
								echo "<td>".$link."</td>";//archivo
								} else {echo "<td></td><td></td>";}

								if ($nivel<=2){// si es admin o superadmin
									echo "<td><input accept='.pdf' type='file' name='".$doc['id']."' class='input_act' ></td>";}

							} else {				
								echo "<td></td>";//icono
								echo "<td>".$doc['nombre']."</td>";//archivo
					
								if ($nivel<=2){// si es admin o superadmin			
									echo "<td><input accept='.pdf' type='file' name='".$doc['id']."' class='input_new'></td>";}
				
							}
							echo "</tr>";
			
						} //bd doc
						echo "</table><br>";

						if ($nivel<=2){// si es admin o superadmin		
						echo "<div><label>De clic en este boton para subir los que haya seleccionado</label><input type='submit' name='submit_subir' value='SUBIR' class='btn btn-default'></div></form>";
						}


		


	



















					} else { 
						echo ""."<span class='msg alerta'>No se ha encontrado ningun registro con el folio ".$_GET['folio']." del programa y delegacion seleccionada</span>";
					}
				
				
				}
				


















			echo "</div>";} echo "<div id='itavu' class='pesta invisible'></div>";

			/////////////////////////////////////////////////////////////////////////////////////////
			if ($_GET['pes']=='personales')
			{echo "<div id='personales' class='pesta visible'>";

			
			echo "EN CONSTRUCCION...";















			echo "</div>";
			} echo "<div id='personales' class='pesta invisible'></div>";


			///////////////////////////////////////////////////////////////////////////////////////
			if ($_GET['pes']=='ayuda')
			{echo "<div id='ayuda' class='pesta visible'>";

			echo "<video controls zoom width='100%'><source src='media/".$id_aplicacion.".mp4' type='video/mp4'></video> ";










			echo "</div>";
			} echo "<div id='ayuda' class='pesta invisible'></div>";

		} else {mensaje("Bienvenido a la aplicacion para digitalizar",'digital.php?pes=itavu');}//sin pestañas



} else { mensaje("No tiene acceso a esta aplicacion",'');}


?>


<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>


<?php include ("./unica/body_footer.php"); ?>