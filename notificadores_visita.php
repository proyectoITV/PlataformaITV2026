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
echo "<div id='AppDetalle'>".app_detalle($id_aplicacion, $nitavu)."</div>";
if (sanpedro($id_aplicacion, $nitavu)==TRUE){
	// 1 Super Administrador, 2 Administrador 3 Operador
	// el Operador podra capturar y ver una lista de lo que le falte
	if ($nivel==3){// SOLO LOS QUE TIENEN NIVEL DE OPERADOR PUEDEN CAPTURAR
		// lista de notificaciones disponibles
		historia($nitavu,'Consultando notificaciones');

			buscar("notificadores_visita.php","BUSCAR CONTRATO  o con parte del mismo",$_GET['brig']);

			echo "<table  class='modulo' border='0' width='100%' align='center'><tr>";
			echo "<td></td>";
			echo "<td width='30%' align='center' class='tchico'>". "Autorizado para las solicitudes en ".misdelegaciones($nitavu)."</td>";
			echo "<td width='30%' align='center'>"."<a  class='btn ' href='notificadores_visita.php?brig=1&busqueda=*'>Regresar </a>    "."</td>";
			echo "<td width='30%' align='center'>"."<h4 class='tenue'>Bienvenido Notificador <h4 >";
			//echo misdelegaciones($nitavu);
			if (isset($_GET['brig'])){
			echo "PENDIENTES: ".notificadores_pendientes($nitavu, $_GET['brig']);
			}

			echo "</td>";
			echo "</tr>";
			echo "<tr><td colspan='4' align='center'>Brigadas: ";				
			$sql = "SELECT * FROM brigadas order by id ASC";
			$r2 = $conexion -> query($sql);
			while($f = $r2 -> fetch_array())
			{
				
					if ($_GET['brig']==$f['id']){
						echo "<a class='ejecutandose' href='notificadores_visita.php?brig=".$f['id']."'>".$f['nombre']."</a> | ";
					}
					else{
						echo "<a class='normal' href='notificadores_visita.php?brig=".$f['id']."'>".$f['nombre']."</a> | ";	

					}
				
				
			}
			echo "</td></td>";
			echo "</table>";


			//
			$sqlmc="SELECT DISTINCT	colonia_asignada FROM notificaciones_old WHERE (folio <> 'X') ORDER BY  colonia_asignada";
			$rmc = $conexionmigra -> query($sqlmc);

			while($mc = $rmc -> fetch_array())
			{
			echo "<div id='colonias' >";
			echo "<h1> COLONIA ".$mc['colonia_asignada'].":</h1>";

				echo "<div id='manzanas'>";
				$sqlm="SELECT DISTINCT	manzana, colonia_asignada FROM notificaciones_old WHERE (folio <> 'X' AND colonia_asignada='".$mc['colonia_asignada']."') ORDER BY LENGTH(manzana), manzana";
				//echo $sqlm;
				$rm = $conexionmigra -> query($sqlm);
				echo "<div id='manzanas'>";
				while($m = $rm -> fetch_array())
				{
					
					echo "<a href='notificadores_visita.php?brig=1&busqueda=".$m['manzana']."&col=".$m['colonia_asignada']."'>".$m['manzana']."</a>";
					
				}
				echo "</div>";
			echo "</div>";				
			}



		if (isset($_GET['f'])){//capturar visita////////////////////////////////////////////
			//include ("lib/geo.php");

			//titulo("CAPTURA DE VISITA: Brigada ".brigada($_GET['brig']).":");

			echo "<form action='notificadores_visita_valida.php' method='post' enctype='multipart/form-data'>";
			
			//echo "<b id='etiqueta_ubicame' class='invisible'></b>";
			
			echo "<div>";
			echo "<table width='100%' ><tr>";
			echo "<td valign='top'>";
					echo "<div>";
					echo "<label>Latitud: </label>";
					echo "<input type='text' name='lat' id='lat' readonly='readonly'>";
					echo "</div>";

					echo "<div>";
					echo "<label>Longitud: </label>";
					echo "<input type='text' name='lon' id='lon' readonly='readonly'>";
					echo "</div>";
			

					//echo "<div>";
					//echo "<label>Exactitud: </label>";
					echo "<input type='hidden' name='acu' id='acu' readonly='readonly'>";
					//echo "</div>";

					echo "</td>";
					echo "<td width='300px'>";
				
					echo "<div>";		
					echo "<label>Croquis de Localizacion</label>";
					echo '<img class="img_map" id="img_map" name="img_map" src="" width="600"  >';
					echo "</div>";
			
			echo "</td>";
			echo "</tr>";
			echo "</table>";
			echo "</div>";
			
			echo "<input type='hidden' value='".$nitavu."' name='notificador_nitavu' id='notificador_nitavu'>";
			
			echo "<input type='hidden' value='".$_GET['brig']."' name='brigada' id='brigada'>";
				
			
			if (isset($_GET['c'])){//validamos para usar consultas y no se caiga 

				$sql = "SELECT * FROM notificaciones_old WHERE (contrato='".$_GET['c']."' AND fecha_corte='".$_GET['date']."')";					
				$old = $conexionmigra -> query($sql);
				//echo $sql;
				if($nt = $old -> fetch_array())
					{					
					echo "<input type='hidden' value='".$nt['id_delegacion']."' name='delegacion' id='delegacion'>";
					
					echo "<input type='hidden' value='".$nt['id_solicitante']."' name='id_solicitante' id='id_solicitante'>";
			
					
					echo "<div class='cuadro_ '>";
					echo "<span>";
						echo "<div>";
						echo "<label>Contrato: </label>";
						echo "<input type='text' id='contrato' name='contrato' readonly='readonly' value='".$nt['contrato']."'>";
						echo "</div>";

						echo "<div>";
						echo "<label>Manzana y Lote: </label>";
						echo "<input type='text' id='manzana' name='manzana' readonly='readonly' value='M:".$nt['manzana'].", L:".$nt['lote']."'>";
						echo "</div>";


						echo "<div>";
						$fecha_corte = substr($nt['fecha_corte'], 0, 10);

						echo "<input type='hidden' id='fecha_corte' name='fecha_corte' value='".$nt['fecha_corte']."'>";
						echo "<input type='hidden' id='fecha_corte2' name='fecha_corte2' value='".$fecha_corte."'>";

						$dias_retraso = tiempo_restar_fecha($fecha_corte, $fecha);
						echo "<label>Disponible desde hace ".fecha_larga($fecha_corte)." ".$dias_retraso." dias: </label>";
						echo "<input type='text' readonly='readonly' value='".fecha_larga($fecha_corte)."'>";
						echo "</div>";



					echo "</span>";

					echo "<span>";
					echo "<label>Colonia: </label>";
					echo "<input type='text' id='colonia' name='colonia' readonly='readonly' value='".$nt['colonia_asignada']."'>";
					echo "</span>";
					echo "</div>";
					
					echo "<hr>";
					//echo sugerencia("Lee cuidadosamente los datos; de no estar correctos por favor actualizalos. Asegurate de validar su nombre con algun documento, como su credencial de elector");



					$sql = "SELECT * FROM beneficiarios_old WHERE (id_solicitante='".$nt['id_solicitante']."')";				
					$old2 = $conexionmigra -> query($sql);
					//echo $sql;
					if($nt_bene = $old2 -> fetch_array())
							{
							echo "<div class='cuadro_ fondo_tenue_map'>";
							echo "Datos del Beneficiario:<br>";
							echo "<div>";
							echo "<label>CURP: </label>";
							echo "<input type='text' id='curp' name='curp' value='".$nt_bene['curp']."'>";
							echo "</div>";	

							echo "<div>";
							echo "<label>IFE: </label>";
							echo "<input type='text' id='ife' name='ife' value='".$nt_bene['curp']."'>";
							echo "</div>";

							echo "<div>";
							echo "<label>NOMBRE: </label>";
							echo "<input type='text' id='nombre_' name='nombre_' readonly='readonly' value='".$nt_bene['nombre']."'>";
							echo "</div>";	

							echo "<div>";
							echo "<label>APELLIDO PATERNO: </label>";
							echo "<input type='text' id='paterno'  readonly='readonly' name='paterno' value='".$nt_bene['paterno']."'>";
							echo "</div>";	

							echo "<div>";
							echo "<label>APELLIDO MATERNO: </label>";
							echo "<input type='text' id='materno'  readonly='readonly' name='materno' value='".$nt_bene['materno']."'>";
							echo "</div>";	

							echo "<div>";
							echo "<label>Fecha de Nacimiento: </label>";
							echo "<input type='date' id='nacimiento' name='nacimiento' value='".substr($nt_bene['nacimiento'], 0, 10)."'>";
							echo "</div>";	

							echo "<div>";
							echo "<label>DOMICILIO PARTICULAR: </label>";
							echo "<input type='text' id='domicilio' name='domicilio' value='".$nt['manzana_lote_calles']." ".$nt['manzana_lote'].", ".$nt['colonia'].", ". $nt['municipio']."'>";
							echo "</div>";	

							echo "<div>";
							echo "<label>SEXO: </label>";
							echo "<select name='sexo' id='sexo'>";
								echo "<option value='0'>Sin dato</option>";
								echo "<option value='1'>Femenino</option>";
								echo "<option value='2'>Masculino</option>";
								if ($nt_bene['sexo']='0'){echo "<option value='0' selected='selected'>Sin dato</option>";}
								if ($nt_bene['sexo']='1'){echo "<option value='1' selected='selected'>Femenino</option>";}
								if ($nt_bene['sexo']='2'){echo "<option value='2' selected='selected'>Masculino</option>";}

							echo "</select>";
							echo "</div>";		
							echo "</div>";
						    }
					else {// sino esta en la bd de beneficiario pedir los mismos datos

							echo "<div>";
							echo "<label>CURP: </label>";
							echo "<input type='text' id='curp' name='curp' value=''>";
							echo "</div>";	

							echo "<div>";
							echo "<label>IFE: </label>";
							echo "<input type='text' id='ife' name='ife' value=''>";
							echo "</div>";

							echo "<div>";
							echo "<label>NOMBRE: </label>";
							echo "<input type='text' id='nombre_'  readonly='readonly' name='nombre_' value=''>";
							echo "</div>";	

							echo "<div>";
							echo "<label>APELLIDO PATERNO: </label>";
							echo "<input type='text' id='paterno'  readonly='readonly' name='paterno' value=''>";
							echo "</div>";	

							echo "<div>";
							echo "<label>APELLIDO MATERNO: </label>";
							echo "<input type='text' id='materno'  readonly='readonly' name='materno' value=''>";
							echo "</div>";	

							echo "<div>";
							echo "<label>Fecha de Nacimiento: </label>";
							echo "<input type='date' id='nacimiento' name='nacimiento' value=''>";
							echo "</div>";	

							echo "<div>";
							echo "<label>DOMICILIO: </label>";
							echo "<input type='text' id='domicilio' name='domicilio' value=''>";
							echo "</div>";	

							echo "<div>";
							echo "<label>SEXO: </label>";
							echo "<select name='sexo' id='sexo'>";
								echo "<option value='0'>Sin dato</option>";
								echo "<option value='1'>Femenino</option>";
								echo "<option value='2'>Masculino</option>";
								if ($nt_bene['sexo']='0'){echo "<option value='0' selected='selected'>Sin dato</option>";}
							

							echo "</select>";
							echo "</div>";	



					}

					// sin importar que este o no en l bd old pedir:

						echo "<div class='cuadro_ fondo_tenue_verde'>";
						echo "Datos para contacto:<br>";
							echo "<div>";
							echo "<label>Telefono Casa: </label>";
							echo "<input type='text' id='telefono_casa' name='telefono_casa' value=''>";
							echo "</div>";	

							echo "<div>";
							echo "<label>Telefono Trabajo: </label>";
							echo "<input type='text' id='telefono_trabajo' name='telefono_trabajo' value=''>";
							echo "</div>";	

							echo "<div>";
							echo "<label>Telefono Movil: </label>";
							echo "<input type='text' id='telefono_movil' name='telefono_movil' value=''>";
							echo "</div>";	

							echo "<div>";
							echo "<label>Correo electronico: </label>";
							echo "<input type='text' id='correo' name='correo' value=''>";
							echo "</div>";	

							echo "<div>";
							echo "<label>Facebook: </label>";
							echo "<input type='text' id='facebook' name='facebook' value=''>";
							echo "</div>";	

							echo "<div>";
							echo "<label>Twitter: </label>";
							echo "<input type='text' id='twitter' name='twitter' value=''>";
							echo "</div>";	

						echo "</div>";



							echo "<br><hr>";			
							echo "<h4 class='normal'>FOTOS:</h4>";
							echo "<div>";
							echo "<label>Foto del Lote: </label>";
							echo "<input type='file' id='fotolote' name='fotolote' value=''>";
							echo "</div>";	

							// echo "<div>";
							// echo "<label>Foto de algun detalle: (explicarlo en las observaciones) </label>";
							// echo "<input type='file' id='fotolote2' name='fotolote2' value=''>";
							// echo "</div>";	


							// echo "<div>";
							// echo "<label>Foto de la Credencial de Elector (frente): </label>";
							// echo "<input type='file' id='ife_frente' name='ife_frente' value=''>";
							// echo "</div>";	

							// echo "<div>";
							// echo "<label>Foto de la Credencial de Elector (atras): </label>";
							// echo "<input type='file' id='ife_atras' name='ife_atras' value=''>";
							// echo "</div>";	


							echo "<br><hr>";			
							echo "<h4 class='normal'>ESTADO DEL LOTE:</h4>";
							
							echo "<div>";
								echo "<div>";
								echo "<label>¿Lote baldio?</label>";
								echo "<select name='edolote_baldio' id='edolote_baldio'>";
										echo "<option value='0'></option>";
										echo "<option value='1'>SI</option>";
										echo "<option value='2'  selected='selected'>NO</option>";									
								echo "</select>";
								echo "</div>";

								echo "<div>";
								echo "<label>¿Lote habitado?</label>";
								echo "<select name='edolote_habitado' id='edolote_habitado'>";
										echo "<option value='0'></option>";
										echo "<option value='1'>SI</option>";
										echo "<option value='2'  selected='selected'>NO</option>";										
								echo "</select>";
								echo "</div>";
							echo "</div>";


							echo "<div>";
								echo "<div>";
								echo "<label>¿Lote en construccion?</label>";
								echo "<select name='edolote_construccion' id='edolote_construccion'>";
										echo "<option value='0'></option>";
										echo "<option value='1'>SI</option>";
										echo "<option value='2'  selected='selected'>NO</option>";									
										echo "</select>";
								echo "</div>";

								echo "<div>";

								echo "<label>¿Lote Rentado?</label>";
								echo "<select name='edolote_rentado' id='edolot_rentado'>";


										echo "<option value='0'></option>";
										echo "<option value='1'>SI</option>";
										echo "<option value='2'  selected='selected'>NO</option>";						


								echo "</select>";
								echo "</div>";
							echo "</div>";							


							echo "<div>";
								echo "<div>";
								echo "<label>¿U.B.V Habitada?</label>";
								echo "<select name='ubv_habitada' id='ubv_habitada'>";
										echo "<option value='0'></option>";
										echo "<option value='1'>SI</option>";
										echo "<option value='2'  selected='selected'>NO</option>";										
								echo "</select>";
								echo "</div>";

								echo "<div>";
								echo "<label>¿U.B.V. rentada?</label>";
								echo "<select name='ubv_rentada' id='ubv_rentada'>";
										echo "<option value='0'></option>";
										echo "<option value='1'>SI</option>";
										echo "<option value='2'  selected='selected'>NO</option>";										
								echo "</select>";
								echo "</div>";
							echo "</div>";

							echo "<div>";
								echo "<div>";
								echo "<label>¿U.B.V vacia en buen estado?</label>";
								echo "<select name='ubv_vacia_buen' id='ubv_vacia_buen'>";
										echo "<option value='0'></option>";
										echo "<option value='1'>SI</option>";
										echo "<option value='2'  selected='selected'>NO</option>";	;									
								echo "</select>";
								echo "</div>";

								echo "<div>";
								echo "<label>¿U.B.V. vacia vandalizada?</label>";
								echo "<select name='ubv_vacia_banda' id='ubv_vacia_banda'>";
										echo "<option value='0'></option>";
										echo "<option value='1'>SI</option>";
										echo "<option value='2'  selected='selected'>NO</option>";										
								echo "</select>";
								echo "</div>";
							echo "</div>";

							echo "<span>";
							echo "<label>Observaciones y Comentarios:</label>";
							echo "<textarea name='observaciones' id='observaciones'></textarea>";
							echo "</span>";

							echo "<div>";
							echo "<input value='Guardar Visita' class='Mbtn btn-default' type='submit'>";
							echo "</div>";



					}

				else
				{
					mensaje ("No se encontro el contrato",'');
				}



			}



			//echo "</div>";


			echo "</form>";

		}//////// fin de captura///////////////////////////////////////////////
		else 
			{ //sino esta presente la var f


		echo "<section class='modulo'>";
			$tmp="";
			$tmp2="";
			
			$tmp1="
			<table class='tabla' ><tr >
				<th >Manzana y Lote </th>
				<th >Colonia </th>
				<th class='pc'>Contrato </th>
				
				<th ></th> 

			</tr>
			";
			
			$midelegacion = midelegacion($nitavu); 
				$p2 = explode(" ",$midelegacion); 
				$midelegacion_lugar =  $p2[1]; // esto muestra la primera palabra 
			if ($midelegacion_lugar=='Coordinacion'){}
			else{$midelegacion_id = busca_id_delegacion($midelegacion_lugar);}
	
		
			//echo $midelegacion_id;

			$titulo ="";
			$id_delegacion=""; //para las consultas
			$delegaciones_aut="";
			$cuantos=0;
			$llevan=0;

			if (isset($_GET['busqueda'])){
					$id_delegacion = busca_id_delegacion($_GET['busqueda']);				
					$sql = "SELECT * FROM notificaciones_old WHERE (";
					$sql = $sql." contrato LIKE'%".$_GET['busqueda']."%' ";
					//$sql = $sql." lote LIKE'%".$_GET['busqueda']."%' OR";
					//$sql = $sql." colonia_asignada LIKE'%".$_GET['busqueda']."%' ";
					
					if (isset($_GET['col'])){
							$sql = "SELECT * FROM notificaciones_old WHERE (manzana='".$_GET['busqueda']."' AND  colonia_asignada ='".$_GET['col']."' ";	
					}

					
					//$sql = $sql." nombre LIKE'%".$_GET['busqueda']."%' OR";
					//$sql = $sql." id_delegacion LIKE'%".$midelegacion_id."%' OR"; //busca en las deleg. auts
					//$sql = $sql." contrato LIKE'%".$_GET['busqueda']."%' )  AND (id_delegacion='".$midelegacion_id."')";	
					$sql = $sql.") order by manzana ASC";
					$titulo = "Resultados de <span class='ejecutandose'>".$_GET['busqueda']."</span> ";
				}
				else 
				{
					$sql = "SELECT * FROM notificaciones_old WHERE (id_delegacion='".$midelegacion_id."') ORDER by manzana_lote ASC";	
					$titulo = "NOTIFICACIONES pendientes de entregar ";
				}

			//echo $sql;
				$sincurp_c=0;
				$sincurp_d ="";
				$cuantos=0;
				$r2 = $conexionmigra -> query($sql);
				while($f = $r2 -> fetch_array())
					{
						if ($f['folio']=='X'){
								$llevan = $llevan + 1;
							}
							else
							{
					
							$tmp2 = $tmp2."<tr>";
							$tmp2 = $tmp2."<td> M:".$f['manzana'].", L:".$f['lote']."</td>";
							$tmp2 = $tmp2."<td>".$f['colonia_asignada'].", ".delegacion_id($f['id_delegacion'])."</td>";
							$tmp2 = $tmp2."<td class='pc'>".$f['contrato']."</td>";
							//$tmp2 = $tmp2."<td class='pc'>".$f['nombre']." ".$f['paterno']." ".$f['materno']."</td>";
							$tmp2 = $tmp2."<td><a class='btn normal' href='notificadores_visita.php?f=&c=".$f['contrato']."&date=".$f['fecha_corte']."&brig=".$_GET['brig']."'>Capturar</a></td>";
							$tmp2 = $tmp2."</tr>";
							$cuantos = $cuantos +1;


					}
						
					
			}



			//seguimos buscando ahora en las delegaciones autorizadas extras
			$sql2="SELECT * FROM notificaciones_config WHERE id='".$nitavu."' ";
			$r2 = $conexion -> query($sql2);
			//echo $sql2;
			while($df = $r2 -> fetch_array())
			{//$df recorre la lista de las delegaciones autorizadas extras
				$delegaciones_aut = $delegaciones_aut.delegacion_id($df['delegacion_id']).", ";
				//echo $delegaciones_aut;
					if (isset($_GET['busqueda'])){
					$id_delegacion = busca_id_delegacion($_GET['busqueda']);				
					$id_delegacion = busca_id_delegacion($_GET['busqueda']);				
					$sql = "SELECT * FROM notificaciones_old WHERE (";
					$sql = $sql." manzana_lote LIKE'%".$_GET['busqueda']."%' OR";
					$sql = $sql." colonia LIKE'%".$_GET['busqueda']."%' OR";
					$sql = $sql." nombre LIKE'%".$_GET['busqueda']."%' OR";
					//$sql = $sql." id_delegacion LIKE'%".$df['delegacion_id']."%'OR"; //busca en las deleg. auts
					$sql = $sql." contrato LIKE'%".$_GET['busqueda']."%' ) AND (id_delegacion='".$df['delegacion_id']."')";	
					$sql = $sql." order by manzana_lote ASC";
					

					$titulo = "Resultados de <span class='ejecutandose'>".$_GET['busqueda']."</span> ";
					}
					else 
					{
						$sql = "SELECT * FROM notificaciones_old WHERE (id_delegacion='".$df['delegacion_id']."') ORDER by manzana_lote ASC";	
						$titulo = "Notificaciones pendientes de entregar ";
					}
					//echo $sql."<br>";
					$rmigra = $conexionmigra -> query($sql);
					//$cuantos = 0;
					//$llevan = 0;

					while($f = $rmigra -> fetch_array())
						{
							if ($f['folio']=='X'){
								$llevan = $llevan + 1;
							}
							else
							{
							$tmp2 = $tmp2."<tr>";
							$tmp2 = $tmp2."<td>".$f['manzana_lote']."</td>";
							$tmp2 = $tmp2."<td>".$f['colonia'].", ".delegacion_id($f['id_delegacion'])."</td>";
							$tmp2 = $tmp2."<td class='pc'>".$f['contrato']."</td>";
							$tmp2 = $tmp2."<td class='pc'>".$f['nombre']." ".$f['paterno']." ".$f['materno']."</td>";
							$tmp2 = $tmp2."<td><a class='btn normal' href='notificadores_visita.php?f=&c=".$f['contrato']."&date=".$f['fecha_corte']."&brig=".$_GET['brig']."'>Capturar</a></td>";
							}
						
						

							$tmp2 = $tmp2."</tr>";
							$cuantos = $cuantos +1;			
						}

			}
			$delegaciones_aut = $delegaciones_aut.$midelegacion_lugar.", ";




			
			$delegaciones_aut = substr($delegaciones_aut, 0, -2); //quita la ultima coma.

			//DESPLIEGUE DE LA INFORMACION
				//echo "<div class='mayus normal tmediano'>Autorizado para: ".strtoupper($delegaciones_aut)."</div>";
				echo "<h3 class='normal'>".$titulo.": ".($cuantos-$llevan)." <span class='tenue'>(".$llevan." / ".$cuantos.") </span></h3>";




				echo "<div class='separador_modular_100'>";
					echo $tmp1;
					echo $tmp2."</table>";									
				echo "</div>";



				
				
		






		echo "</section>";
		}



			

	}

	if ($nivel==2){//si son jefes de departamento pueden ver lista de avance con mapa de geolocalizaciones
	// mostramos un lista de los que faltan con tiempo de dias entre la generacion y la visita
	// PARA DELEGADOS O ENCARGADOS DE CHECAR LAS VISITAS

	
			
			buscar("notificadores_visita.php","Manzana, Lote, Col...",$_GET['brig']);
			echo "<table  class='modulo' border='0' width='100%' align='center'><tr>";
			echo "<td></td>";
			
			echo "<td width='30%' align='center' class='tchico'>". "Autorizado para las solicitudes en ".misdelegaciones($nitavu)."</td>";
			echo "<td width='30%' align='center'>"."<a  class='Mbtn btn-secundario' href='notificadores_visita.php?brig=1&busqueda=*'>Regresar </a>    "."</td>";
			echo "<td width='30%' align='center'>"."<h4 class='tenue'>Bienvenido Administrador <h4 >"."</td>";
			
			echo "</tr>";
			echo "<tr><td colspan='4' align='center'>Brigadas: ";				
			$sql = "SELECT * FROM brigadas order by id ASC";
			$r2 = $conexion -> query($sql);
			while($f = $r2 -> fetch_array())
			{
				
					if ($_GET['brig']==$f['id']){
						echo "<a class='ejecutandose' href='notificadores_visita.php?brig=".$f['id']."'>".$f['nombre']."</a> | ";
					}
					else{
						echo "<a class='normal' href='notificadores_visita.php?brig=".$f['id']."'>".$f['nombre']."</a> | ";	

					}
				
				
			}
			echo "</td></td>";
			echo "</table>";

		$tmp1="";
		$tmp2="";

		$sqlX="SELECT * FROM notificaciones_config WHERE id='".$nitavu."' order by nombre";
		$r2x = $conexion -> query($sqlX);
		while($deles = $r2x -> fetch_array())
		{//$df recorre la lista de las delegaciones autorizadas extras
		//$delegaciones_aut = $delegaciones_aut.delegacion_id($deles['delegacion_id']).", ";			
			//echo $sql;
			if (isset($_GET['busqueda'])){
				
					$id_delegacion = busca_id_delegacion($_GET['busqueda']);				
					$sql = "SELECT * FROM notificaciones_old WHERE (";
					$sql = $sql." manzana_lote LIKE'%".$_GET['busqueda']."%' OR";
					$sql = $sql." colonia LIKE'%".$_GET['busqueda']."%' OR";
					$sql = $sql." nombre LIKE'%".$_GET['busqueda']."%' OR";
					$sql = $sql." id_delegacion LIKE'%".$deles['delegacion_id']."%' OR"; //busca en las deleg. auts
					$sql = $sql." contrato LIKE'%".$_GET['busqueda']."%' ) AND folio='X' ";	
					$sql = $sql." order by manzana_lote ASC";
					$titulo = "Resultados de <span class='ejecutandose'>".$_GET['busqueda']."</span> ";
			}

				$sincurp_c=0;
				$sincurp_d ="";

					$tmp1="
					<table class='tabla' ><tr >
						<th >Manzana y Lote </th>
						<th >Colonia </th>
						<th class='pc'>Contrato </th>
						<th class='pc'>Beneficiario</th> 
						<th ></th> 

					</tr>
					";
				$r2 = $conexionmigra -> query($sql);
				$r_count = $r2 -> num_rows;
				if ($r_count>0) {
				$tmp2= "";
				$cuantos= 0;
				//echo $r_count;
				//echo ":".$sql;
				
					while($f = $r2 -> fetch_array())
						{
							if ($f['folio']=='X'){
								$tmp2 = $tmp2."<tr class=''>";
							}
							else{
								$tmp2 = $tmp2."<tr class='tenue'>";
								}
								$tmp2 = $tmp2."<td>".$f['manzana']." L".$f['lote']."</td>";
								$tmp2 = $tmp2."<td>".$f['colonia_asignada'].", ".delegacion_id($f['id_delegacion'])."</td>";
								$tmp2 = $tmp2."<td class='pc'>".$f['contrato']."</td>";
								$tmp2 = $tmp2."<td class='pc'>".$f['nombre']." ".$f['paterno']." ".$f['materno']."</td>";
								$tmp2 = $tmp2."<td>";
								if ($f['folio']=='X'){
								$tmp2 = $tmp2."<a class='btn normal' href='notificadores_visita.php?v=&c=".$f['contrato']."&date=".$f['fecha_corte']."&brig=".$_GET['brig']."&busqueda=".$_GET['busqueda']."''>ver</a>";
							
								}
								$tmp2 = $tmp2. "</td>";
								$tmp2 = $tmp2."</tr>";
								$cuantos = $cuantos +1;


						
						}	

				}else
				{
				if ($_GET['busqueda']<>'*'){
					echo "<span class='ejecutandose'>Sin resultados de ".$_GET['busqueda']."</span><br>";				
								$tmp2 = $tmp2."<tr class='ejecutandose'>";								
								$tmp2 = $tmp2."<td>SIN RESULTADOS EN ".$deles['delegacion_des']." con <b>".$_GET['busqueda']."</b></td>";
								$tmp2 = $tmp2."<td></td>";
								$tmp2 = $tmp2."<td class='pc'></td>";
								$tmp2 = $tmp2."<td class='pc'></td>";
								$tmp2 = $tmp2."<td>";													
								$tmp2 = $tmp2. "</td>";
								$tmp2 = $tmp2."</tr>";
								

					}
				}

			
		}// fin delegaciones autorizadas


				if ($_GET['busqueda']<>'*'){
				echo "<div class='separador_modular_100'>";
				echo "<b class='normal'>Resultados de la busqueda </b><span class='ejecutandose'> ".$_GET['busqueda'].":</span>";
					echo $tmp1;
					echo $tmp2."";									
					echo "</table>";
				echo "</div>";
				}



			// SI LE DIO CLIC A VER
			$tmpv= "";
			if (isset($_GET['v'])){
				$sql = "SELECT * FROM notificadores_visitas WHERE (contrato='".$_GET['c']."' AND fecha='".substr($_GET['date'], 0, 10)."')";
				//echo $sql;
				$rc= $conexion -> query($sql);
				$msg="";
				if($f = $rc -> fetch_array())
				{
					$tmpv= $tmpv."<form action 'notificadores_visita_admin_valida.php' method='post'>";
					$tmpv= $tmpv."<div>";
					$tmpv= $tmpv."<label>Contrato:</label>";
					$tmpv= $tmpv."<input type='text' name='contrato' id='contrato' readonly='readonly' value='".$f['contrato']."'>";							
					$tmpv= $tmpv."</div>";
					

					$tmpv= $tmpv."<div>";
					$tmpv= $tmpv."<label>Nombre del Beneficiario:</label>";
					$tmpv= $tmpv."<input type='text' name='beneficiario' id='beneficiario' readonly='readonly' value='".beneficiario_nombre_curp($f['act_curp'])."'>";							
					$tmpv= $tmpv."</div>";


					$tmpv= $tmpv."<span>";
					$tmpv= $tmpv."<label>Colonia ".$f['colonia'].", ".delegacion_id($f['delegacion'])."</label>";
					$tmpv= $tmpv."";							
					$tmpv= $tmpv."</span>";
					$tmpv= $tmpv."</form>";

					$tmpv= $tmpv. "<div>";		
					$tmpv= $tmpv. "<label>Croquis de Localizacion</label>";
					$url_geo = "https://maps.googleapis.com/maps/api/staticmap?autoscale=1&size=900x400&maptype=roadmap&format=jpg&visual_refresh=true&markers=size:mid%7Ccolor:0xff0000%7Clabel:1%7C";
					$url_geo = $url_geo.$f['visita_lat'].",+".$f['visita_lon']."&key=".$key_map_static;
					$tmpv= $tmpv. '<img class="img_map2" id="img_map2" name="img_map2" src="'.$url_geo.'"  >';
					$tmpv= $tmpv. "</div>";


					$tmpv= $tmpv."<div>";
					$tmpv= $tmpv."<label>FOTOS DEL LOTE:</label>";
					$url_foto = "notificadores/".$f['contrato']."_".$f['visita_fecha']."_lote.jpg";
					//$tmpv= $tmpv."<a href=".$url_foto." target='_blank'><img src=".$url_foto." class='foto'></a>";							
					$tmpv= $tmpv.ponerfoto($url_foto,'foto');							
					
					$url_foto = "notificadores/".$f['contrato']."_".$f['visita_fecha']."_lote2.jpg";
					//$tmpv= $tmpv."<a href=".$url_foto." target='_blank'><img src=".$url_foto." class='foto'></a>";							
					//$tmpv= $tmpv.ponerfoto($url_foto,'foto');							
					


					$tmpv= $tmpv."</div>";


					$tmpv= $tmpv."<div>";
					$tmpv= $tmpv."<label>Notificador:</label>";
					$tmpv= $tmpv."<input type='text' readonly='readonly' value='".nitavu_nombre($f['notificador_nitavu']).", ".nitavu_puesto($f['notificador_nitavu'])." de ".nitavu_dpto($f['notificador_nitavu'])."'>";							
					$tmpv= $tmpv."</div>";

					$tmpv= $tmpv."<div>";
					$tmpv= $tmpv."<label>Visita:</label>";
					$tmpv= $tmpv."<input type='text' readonly='readonly' value='Se visito el ".fecha_larga($f['visita_fecha'])." a las ".$f['visita_hora']."'>";							
					$tmpv= $tmpv."</div>";




					$tmpv= $tmpv."<div>";

					$tmpv= $tmpv."<label>ESTADO DEL LOTE:</label>";
						
						if ($f['estado_lotebaldio']=='1'){
								$tmpv= $tmpv."<input type='text' readonly='readonly' value='"."¿Lote Baldio?=SI'>";						
						}
						if ($f['estado_lotebaldio']=='2'){
								$tmpv= $tmpv."<input type='text' readonly='readonly' value='"."¿Lote Baldio?=NO.'>";						
						}

						if ($f['estado_lotehabitado']=='1'){
								$tmpv= $tmpv."<input type='text' readonly='readonly' value='"."¿Lote habitado?=SI'>";						
						}
						if ($f['estado_lotehabitado']=='2'){
								$tmpv= $tmpv."<input type='text' readonly='readonly' value='"."¿Lote habitado?=NO.'>";						
						}


						if ($f['estado_loteenconstruccion']=='1'){
								$tmpv= $tmpv."<input type='text' readonly='readonly' value='"."¿Lote en construccion?=SI'>";						
						}
						if ($f['estado_loteenconstruccion']=='2'){
								$tmpv= $tmpv."<input type='text' readonly='readonly' value='"."¿Lote en construccion?=NO.'>";						
						}


						if ($f['estado_loterentado']=='1'){
								$tmpv= $tmpv."<input type='text' readonly='readonly' value='"."¿Lote rentado?=SI'>";						
						}
						if ($f['estado_loterentado']=='2'){
								$tmpv= $tmpv."<input type='text' readonly='readonly' value='"."¿Lote rentado?=NO.'>";						
						}



						if ($f['estado_ubvhabitada']=='1'){
								$tmpv= $tmpv."<input type='text' readonly='readonly' value='"."¿UBV habitada?=SI'>";						
						}
						if ($f['estado_ubvhabitada']=='2'){
								$tmpv= $tmpv."<input type='text' readonly='readonly' value='"."¿UBV habitada?=NO.'>";						
						}



						if ($f['estado_ubvvaciaenbuenestado']=='1'){
								$tmpv= $tmpv."<input type='text' readonly='readonly' value='"."¿UBV vacia en buen estado?=SI'>";						
						}
						if ($f['estado_ubvvaciaenbuenestado']=='2'){
								$tmpv= $tmpv."<input type='text' readonly='readonly' value='"."¿UBV vacia en buen estado?=NO.'>";						
						}



						if ($f['estado_ubvvaciavandalizada']=='1'){
								$tmpv= $tmpv."<input type='text' readonly='readonly' value='"."¿UBV vacia vandalizada?=SI'>";						
						}
						if ($f['estado_ubvvaciavandalizada']=='2'){
								$tmpv= $tmpv."<input type='text' readonly='readonly' value='"."¿UBV vacia vandalizada?=NO.'>";						
						}

						if ($f['estado_ubvrentada']=='1'){
								$tmpv= $tmpv."<input type='text' readonly='readonly' value='"."¿UBV rentada?=SI'>";						
						}
						if ($f['estado_ubvrentada']=='2'){
								$tmpv= $tmpv."<input type='text' readonly='readonly' value='"."¿UBV rentada?=NO.'>";						
						}

						
					
					$tmpv= $tmpv."</div>";

						
				}
				else
				{// sin resultado
				
				}
			
			echo "<div class='separador_modular_50'><h3 class='normal_gri'><b>VISITA:</b></h3>".$tmpv."</div>"; // LISTA DE DELEGACIONES



			}

			// FIN DE VER



			// LISTADO DE DELEGACIONES

			//$sql = "SELECT * FROM cat_delegaciones order by nombre ASC";
			$sql = "SELECT * FROM notificaciones_config WHERE id='".$nitavu."' order by nombre ASC";
			$r2 = $conexion -> query($sql);
			$tmpa="
			<h3 class='normal_gri'><b>AVANCE DE NOTIFICACIONES:</b></h3>
			<table class='tabla'>
			<tr>
				<th>Delegacion</th>
				<th>Disponibles</th>
				<th>Entregadas </th>
				<th>%</th>
			</tr>
			";
			$cuantas_disponibles=0;
			$cuantas_entregadas=0;
			$porcenta = 0;
			$porcenta_total = 0;
			while($f = $r2 -> fetch_array())
			{//Categorias de Aplicaciones
				//echo $sql;
				$disponibles = notificaciones_disponibles($f['delegacion_id'],$_GET['brig']);
				if ($disponibles<=0){
					$tmpa = $tmpa."<tr class='tenue'>";					
				}
				else
				{
					$tmpa = $tmpa."<tr>";				
				}
				
				//$tmpa = $tmpa."<td>".$f['nombre']."</td>";
				
				//$tmpa = $tmpa."<td></td>";
				$tmpa = $tmpa."<td>".$f['nombre']."</td>";			
				
				
				$tmpa = $tmpa."<td>".$disponibles."</td>";
				$entregadas = notificaciones_entregadas($f['delegacion_id'],$_GET['brig']);
				$tmpa = $tmpa."<td>".$entregadas."</td>";

				if ($disponibles<>0){
				$porcenta = ($entregadas * 100) /$disponibles;
				}
				if ($porcenta<= 20){
						$tmpa = $tmpa."<td class='alterta'>".number_format($porcenta, 2, '.', '')."%</td>";
				}
				else {
					if ($porcenta>= 90){
							$tmpa = $tmpa."<td class='ejecutandose'>".number_format($porcenta, 2, '.', '')."%</td>";
					}
					else
					{
							$tmpa = $tmpa."<td class='normal'>".number_format($porcenta, 2, '.', '')."%</td>";
					}
				}


				$tmpa = $tmpa."</tr>";				
				$cuantas_disponibles = $cuantas_disponibles +$disponibles;
				$cuantas_entregadas = $cuantas_entregadas + $entregadas;
	
				$porcenta = 0;

			}

			// LISTAMOS TAMBIEN EN LA QUE ESTA INSCRITO
			$midelegacion =  midelegacion($nitavu);
			$p2 = explode(" ",$midelegacion);
				$midelegacion_lugar =  strtoupper($p2[1]); // esto muestra la primera palabra

			$id_delegacion = busca_id_delegacion($midelegacion_lugar);
			//echo $midelegacion.":".$id_delegacion;

			$disponibles = notificaciones_disponibles($id_delegacion,$_GET['brig']);
				if ($disponibles<=0){
					$tmpa = $tmpa."<tr class='tenue'>";					
				}
				else
				{
					$tmpa = $tmpa."<tr>";				
				}				
				$tmpa = $tmpa."<td>".$midelegacion_lugar."</td>";				
				$tmpa = $tmpa."<td>".$disponibles."</td>";
				$entregadas = notificaciones_entregadas($id_delegacion,$_GET['brig']);
				$tmpa = $tmpa."<td>".$entregadas."</td>";

				if ($disponibles<>0){
				$porcenta = ($entregadas * 100) /$disponibles;
				}
				if ($porcenta<= 20){
						$tmpa = $tmpa."<td class='alterta'>".number_format($porcenta, 2, '.', '')."%</td>";
				}
				else {
					if ($porcenta>= 90){
							$tmpa = $tmpa."<td class='ejecutandose'>".number_format($porcenta, 2, '.', '')."%</td>";
					}
					else
					{
							$tmpa = $tmpa."<td class='normal'>".number_format($porcenta, 2, '.', '')."%</td>";
					}
				}


				$tmpa = $tmpa."</tr>";				
				$cuantas_disponibles = $cuantas_disponibles +$disponibles;
				$cuantas_entregadas = $cuantas_entregadas + $entregadas;
	
				$porcenta = 0;

				$tmpa = $tmpa."<tr>";				
				$tmpa = $tmpa."<td class='normal'>TOTAL DISPONIBLES</td>";
				$tmpa = $tmpa."<td class='normal|'>".$cuantas_disponibles."</td>";
				$tmpa = $tmpa."<td class='normal|'>".$cuantas_entregadas."</td>";



				if ($cuantas_disponibles<>0){
				$porcenta_total = ($cuantas_entregadas * 100) /$cuantas_disponibles;
				}
				if ($porcenta_total<= 20){
						$tmpa = $tmpa."<td class='alerta'>".number_format($porcenta_total, 2, '.', '')."%</td>";
				}
				else {
					if ($porcenta_total>= 90){
							$tmpa = $tmpa."<td class='ejecutandose'>".number_format($porcenta_total, 2, '.', '')."%</td>";
					}
					else
					{
							$tmpa = $tmpa."<td class='normal'>".number_format($porcenta_total, 2, '.', '')."%</td>";
					}
				}


				
			$tmpa = $tmpa."</tr>";	
			$tmpa=$tmpa."</table>"; 



			echo "<div class='separador_modular_50'>".$tmpa."</div>"; // LISTA DE DELEGACIONES







	}


	if ($nivel==1){//sin especificaciones aun
		



			
			buscar("notificadores_visita.php","Manzana, Lote, Col, ...",$_GET['brig']);
			echo "<table  class='modulo' border='0' width='100%' align='center'><tr>";			echo "<td></td>";
			
			echo "<td width='30%' align='center' class='tchico'>autorizado para Ver todas las delegaciones</td>";
			echo "<td width='30%' align='center'>"."<a  class='btn' href='notificadores_visita.php'>Regresar </a>    "."</td>";
			echo "<td width='30%' align='center'>"."<h4 class='tenue'>Bienvenido Super Administrador <h4 >"."</td>";
			
			echo "</tr>";
			echo "<tr><td colspan='4' align='center'>Brigadas: ";				
			$sql = "SELECT * FROM brigadas order by id ASC";
			$r2 = $conexion -> query($sql);
			while($f = $r2 -> fetch_array())
			{
				
					if ($_GET['brig']==$f['id']){
						echo "<a class='ejecutandose' href='notificadores_visita.php?brig=".$f['id']."'>".$f['nombre']."</a> | ";
					}
					else{
						echo "<a class='normal' href='notificadores_visita.php?brig=".$f['id']."'>".$f['nombre']."</a> | ";	

					}
				
				
			}
			echo "</td></td>";
			echo "</table>";



		$sqlX="SELECT * FROM cat_delegaciones WHERE id='".$nitavu."' order by nombre";
		$r2x = $conexion -> query($sqlX);
		while($deles = $r2x -> fetch_array())
		$tmp1="";
		$tmp2="";
		{//$df recorre la lista de las delegaciones autorizadas extras
		//$delegaciones_aut = $delegaciones_aut.delegacion_id($deles['delegacion_id']).", ";			
			//echo $sql;
			if (isset($_GET['busqueda'])){
				
					$id_delegacion = busca_id_delegacion($_GET['busqueda']);				
					$sql = "SELECT * FROM notificaciones_old WHERE (";
					$sql = $sql." manzana_lote LIKE'%".$_GET['busqueda']."%' OR";
					$sql = $sql." colonia LIKE'%".$_GET['busqueda']."%' OR";
					$sql = $sql." nombre LIKE'%".$_GET['busqueda']."%' OR";
					//$sql = $sql." id_delegacion LIKE'%".$deles['delegacion_id']."%' OR"; //busca en las deleg. auts
					$sql = $sql." contrato LIKE'%".$_GET['busqueda']."%' ) AND (folio='X') ";	
					$sql = $sql." order by manzana_lote ASC";
					$titulo = "Resultados de <span class='ejecutandose'>".$_GET['busqueda']."</span> ";
			}

				$sincurp_c=0;
				$sincurp_d ="";

					$tmp1="
					<table class='tabla' ><tr >
						<th >Manzana y Lote </th>
						<th >Colonia </th>
						<th class='pc'>Contrato </th>
						<th class='pc'>Beneficiario</th> 
						<th ></th> 

					</tr>
					";
				$r2 = $conexionmigra -> query($sql);
				$r_count = $r2 -> num_rows;
				if ($r_count>0) {
				
				$cuantos= 0;
				//echo $r_count;
				//echo ":".$sql;
				
					while($f = $r2 -> fetch_array())
						{
							if ($f['folio']=='X'){
								$tmp2 = $tmp2."<tr class=''>";
							}
							else{
								$tmp2 = $tmp2."<tr class='tenue'>";
								}
								$tmp2 = $tmp2."<td> M".$f['manzana']." L".$f['lote']."</td>";
								$tmp2 = $tmp2."<td>".$f['colonia'].", ".delegacion_id($f['id_delegacion'])."</td>";
								$tmp2 = $tmp2."<td class='pc'>".$f['contrato']."</td>";
								$tmp2 = $tmp2."<td class='pc'>".beneficiario_idsol($f['id_solicitante'])."</td>";
								$tmp2 = $tmp2."<td>";
								if ($f['folio']=='X'){
								$tmp2 = $tmp2."<a class='btn normal' href='notificadores_visita.php?v=&c=".$f['contrato']."&date=".$f['fecha_corte']."&brig=".$_GET['brig']."&busqueda=".$_GET['busqueda']."''>ver</a>";
							
								}
								$tmp2 = $tmp2. "</td>";
								$tmp2 = $tmp2."</tr>";
								$cuantos = $cuantos +1;


						
						}	

				}else
				{
				if ($_GET['busqueda']<>'*'){
					echo "<span class='ejecutandose'>Sin resultados de ".$_GET['busqueda']."</span><br>";				
								// $tmp2 = $tmp2."<tr class='ejecutandose'>";								
								// $tmp2 = $tmp2."<td>SIN RESULTADOS EN ".$deles['delegacion_des']." con <b>".$_GET['busqueda']."</b></td>";
								// $tmp2 = $tmp2."<td></td>";
								// $tmp2 = $tmp2."<td class='pc'></td>";
								// $tmp2 = $tmp2."<td class='pc'></td>";
								// $tmp2 = $tmp2."<td>";													
								// $tmp2 = $tmp2. "</td>";
								// $tmp2 = $tmp2."</tr>";
								

					}
				}

			
		}// fin delegaciones autorizadas


				if ($_GET['busqueda']<>'*'){
				echo "<div class='separador_modular_100'>";
				echo "<b class='normal'>Resultados de la busqueda </b><span class='ejecutandose'> ".$_GET['busqueda'].":</span>";
					echo $tmp1;
					echo $tmp2."</table>";									
				echo "</div>";
				}



			// SI LE DIO CLIC A VER
			$tmpv= "";
			if (isset($_GET['v'])){
				$sql = "SELECT * FROM notificadores_visitas WHERE (contrato='".$_GET['c']."' AND fecha='".substr($_GET['date'], 0, 10)."')";
				//echo $sql;
				$rc= $conexion -> query($sql);
				$msg="";
				if($f = $rc -> fetch_array())
				{
					$tmpv= $tmpv."<form action 'notificadores_visita_admin_valida.php' method='post'>";
					$tmpv= $tmpv."<div>";
					$tmpv= $tmpv."<label>Contrato:</label>";
					$tmpv= $tmpv."<input type='text' name='contrato' id='contrato' readonly='readonly' value='".$f['contrato']."'>";							
					$tmpv= $tmpv."</div>";
					

					$tmpv= $tmpv."<div>";
					$tmpv= $tmpv."<label>Nombre del Beneficiario:</label>";
					$tmpv= $tmpv."<input type='text' name='beneficiario' id='beneficiario' readonly='readonly' value='".beneficiario_nombre_curp($f['act_curp'])."'>";							
					$tmpv= $tmpv."</div>";


					$tmpv= $tmpv."<span>";
					$tmpv= $tmpv."<label>Colonia ".$f['colonia'].", ".delegacion_id($f['delegacion'])."</label>";
					$tmpv= $tmpv."";							
					$tmpv= $tmpv."</span>";
					$tmpv= $tmpv."</form>";

					$tmpv= $tmpv. "<div>";		
					$tmpv= $tmpv. "<label>Croquis de Localizacion</label>";
					//$url_geo = "https://maps.googleapis.com/maps/api/staticmap?autoscale=1&size=900x400&maptype=roadmap&format=jpg&visual_refresh=true&markers=size:mid%7Ccolor:0xff0000%7Clabel:1%7C";
					
					//$url_geo = $url_geo.$f['visita_lat'].",+".$f['visita_lon']."&key=".$key_map_static;



			$info= "['".beneficiario_nombre_curp($f['act_curp']).", Contrato: ".$f['contrato']."',".$f['visita_lat'].",".$f['visita_lon']."]";


					//$tmpv= $tmpv. '<img class="img_map2" id="img_map2" name="img_map2" src="'.$url_geo.'"  >';
					$tmpv= $tmpv. '<div class="img_map2" id="mapa" name="mapa"   ></div>';
					

					$tmpv= $tmpv. "</div>";


					$tmpv= $tmpv."<div>";
					$tmpv= $tmpv."<label>FOTOS DEL LOTE:</label>";
					$url_foto = "notificadores/".$f['contrato']."_".$f['visita_fecha']."_lote.jpg";
					//$tmpv= $tmpv."<a href=".$url_foto." target='_blank'><img src=".$url_foto." class='foto'></a>";							
					$tmpv= $tmpv.ponerfoto($url_foto,'foto');							
					
					$url_foto = "notificadores/".$f['contrato']."_".$f['visita_fecha']."_lote2.jpg";
					//$tmpv= $tmpv."<a href=".$url_foto." target='_blank'><img src=".$url_foto." class='foto'></a>";							
					//$tmpv= $tmpv.ponerfoto($url_foto,'foto');							
					


					$tmpv= $tmpv."</div>";


					$tmpv= $tmpv."<div>";
					$tmpv= $tmpv."<label>Notificador:</label>";
					$tmpv= $tmpv."<input type='text' readonly='readonly' value='".nitavu_nombre($f['notificador_nitavu']).", ".nitavu_puesto($f['notificador_nitavu'])." de ".nitavu_dpto($f['notificador_nitavu'])."'>";							
					$tmpv= $tmpv."</div>";

					$tmpv= $tmpv."<div>";
					$tmpv= $tmpv."<label>Visita:</label>";
					$tmpv= $tmpv."<input type='text' readonly='readonly' value='Se visito el ".fecha_larga($f['visita_fecha'])." a las ".$f['visita_hora']."'>";							
					$tmpv= $tmpv."</div>";




					$tmpv= $tmpv."<div>";

					$tmpv= $tmpv."<label>ESTADO DEL LOTE:</label>";
						
						if ($f['estado_lotebaldio']=='1'){
								$tmpv= $tmpv."<input type='text' readonly='readonly' value='"."¿Lote Baldio?=SI'>";						
						}
						if ($f['estado_lotebaldio']=='2'){
								$tmpv= $tmpv."<input type='text' readonly='readonly' value='"."¿Lote Baldio?=NO.'>";						
						}

						if ($f['estado_lotehabitado']=='1'){
								$tmpv= $tmpv."<input type='text' readonly='readonly' value='"."¿Lote habitado?=SI'>";						
						}
						if ($f['estado_lotehabitado']=='2'){
								$tmpv= $tmpv."<input type='text' readonly='readonly' value='"."¿Lote habitado?=NO.'>";						
						}


						if ($f['estado_loteenconstruccion']=='1'){
								$tmpv= $tmpv."<input type='text' readonly='readonly' value='"."¿Lote en construccion?=SI'>";						
						}
						if ($f['estado_loteenconstruccion']=='2'){
								$tmpv= $tmpv."<input type='text' readonly='readonly' value='"."¿Lote en construccion?=NO.'>";						
						}


						if ($f['estado_loterentado']=='1'){
								$tmpv= $tmpv."<input type='text' readonly='readonly' value='"."¿Lote rentado?=SI'>";						
						}
						if ($f['estado_loterentado']=='2'){
								$tmpv= $tmpv."<input type='text' readonly='readonly' value='"."¿Lote rentado?=NO.'>";						
						}



						if ($f['estado_ubvhabitada']=='1'){
								$tmpv= $tmpv."<input type='text' readonly='readonly' value='"."¿UBV habitada?=SI'>";						
						}
						if ($f['estado_ubvhabitada']=='2'){
								$tmpv= $tmpv."<input type='text' readonly='readonly' value='"."¿UBV habitada?=NO.'>";						
						}



						if ($f['estado_ubvvaciaenbuenestado']=='1'){
								$tmpv= $tmpv."<input type='text' readonly='readonly' value='"."¿UBV vacia en buen estado?=SI'>";						
						}
						if ($f['estado_ubvvaciaenbuenestado']=='2'){
								$tmpv= $tmpv."<input type='text' readonly='readonly' value='"."¿UBV vacia en buen estado?=NO.'>";						
						}



						if ($f['estado_ubvvaciavandalizada']=='1'){
								$tmpv= $tmpv."<input type='text' readonly='readonly' value='"."¿UBV vacia vandalizada?=SI'>";						
						}
						if ($f['estado_ubvvaciavandalizada']=='2'){
								$tmpv= $tmpv."<input type='text' readonly='readonly' value='"."¿UBV vacia vandalizada?=NO.'>";						
						}

						if ($f['estado_ubvrentada']=='1'){
								$tmpv= $tmpv."<input type='text' readonly='readonly' value='"."¿UBV rentada?=SI'>";						
						}
						if ($f['estado_ubvrentada']=='2'){
								$tmpv= $tmpv."<input type='text' readonly='readonly' value='"."¿UBV rentada?=NO.'>";						
						}

						
					
					$tmpv= $tmpv."</div>";

						
				}
				else
				{// sin resultado
				
				}
			
			echo "<div class='separador_modular_50'><h3 class='normal_gri'><b>VISITA:</b></h3>".$tmpv."</div>"; // LISTA DE DELEGACIONES



			}

			// FIN DE VER



			// LISTADO DE DELEGACIONES

			//$sql = "SELECT * FROM cat_delegaciones order by nombre ASC";
			$sql = "SELECT * FROM cat_delegaciones order by nombre ASC";
			$r2 = $conexion -> query($sql);
			//echo $sql;
			$tmpa="
			<h3 class='normal_gri'><b>AVANCE DE NOTIFICACIONES:</b></h3>
			<table class='tabla'>
			<tr>
				<th>Delegacion</th>
				<th>Disponibles</th>
				<th>Entregadas </th>
				<th>%</th>
			</tr>
			";
			$cuantas_disponibles=0;
			$cuantas_entregadas=0;
			$porcenta = 0;
			$porcenta_total = 0;
			while($f = $r2 -> fetch_array())
			{//Categorias de Aplicaciones
				//echo $sql;
				$disponibles = notificaciones_disponibles($f['id'],$_GET['brig']);
				if ($disponibles<=0){
					$tmpa = $tmpa."<tr class='tenue'>";					
				}
				else
				{
					$tmpa = $tmpa."<tr>";				
				}
				
				//$tmpa = $tmpa."<td>".$f['nombre']."</td>";
				
				//$tmpa = $tmpa."<td></td>";
				$tmpa = $tmpa."<td>".$f['nombre']."</td>";			
				
				
				$tmpa = $tmpa."<td>".$disponibles."</td>";
				$entregadas = notificaciones_entregadas($f['id'],$_GET['brig']);
				$tmpa = $tmpa."<td>".$entregadas."</td>";

				if ($disponibles<>0){
				$porcenta = ($entregadas * 100) /$disponibles;
				}
				if ($porcenta<= 20){
						$tmpa = $tmpa."<td class='alterta'>".number_format($porcenta, 2, '.', '')."%</td>";
				}
				else {
					if ($porcenta>= 90){
							$tmpa = $tmpa."<td class='ejecutandose'>".number_format($porcenta, 2, '.', '')."%</td>";
					}
					else
					{
							$tmpa = $tmpa."<td class='normal'>".number_format($porcenta, 2, '.', '')."%</td>";
					}
				}


				$tmpa = $tmpa."</tr>";				
				$cuantas_disponibles = $cuantas_disponibles +$disponibles;
				$cuantas_entregadas = $cuantas_entregadas + $entregadas;
	
				$porcenta = 0;

			}

			// LISTAMOS TAMBIEN EN LA QUE ESTA INSCRITO
			// $midelegacion =  midelegacion($nitavu);
			// $p2 = explode(" ",$midelegacion);
			// 	$midelegacion_lugar =  strtoupper($p2[1]); // esto muestra la primera palabra

			// $id_delegacion = busca_id_delegacion($midelegacion_lugar);
			// //echo $midelegacion.":".$id_delegacion;

			// $disponibles = notificaciones_disponibles($id_delegacion,$_GET['brig']);
			// 	if ($disponibles<=0){
			// 		$tmpa = $tmpa."<tr class='tenue'>";					
			// 	}
			// 	else
			// 	{
			// 		$tmpa = $tmpa."<tr>";				
			// 	}				
			// 	$tmpa = $tmpa."<td>".$midelegacion_lugar."</td>";				
			// 	$tmpa = $tmpa."<td>".$disponibles."</td>";
			// 	$entregadas = notificaciones_entregadas($id_delegacion,$_GET['brig']);
			// 	$tmpa = $tmpa."<td>".$entregadas."</td>";

			// 	if ($disponibles<>0){
			// 	$porcenta = ($entregadas * 100) /$disponibles;
			// 	}
			// 	if ($porcenta<= 20){
			// 			$tmpa = $tmpa."<td class='alterta'>".number_format($porcenta, 2, '.', '')."%</td>";
			// 	}
			// 	else {
			// 		if ($porcenta>= 90){
			// 				$tmpa = $tmpa."<td class='ejecutandose'>".number_format($porcenta, 2, '.', '')."%</td>";
			// 		}
			// 		else
			// 		{
			// 				$tmpa = $tmpa."<td class='normal'>".number_format($porcenta, 2, '.', '')."%</td>";
			// 		}
			// 	}


			// 	$tmpa = $tmpa."</tr>";				
			// 	$cuantas_disponibles = $cuantas_disponibles +$disponibles;
			// 	$cuantas_entregadas = $cuantas_entregadas + $entregadas;
	
			// 	$porcenta = 0;

				$tmpa = $tmpa."<tr>";				
				$tmpa = $tmpa."<td class='normal'>TOTAL DISPONIBLES</td>";
				$tmpa = $tmpa."<td class='normal|'>".$cuantas_disponibles."</td>";
				$tmpa = $tmpa."<td class='normal|'>".$cuantas_entregadas."</td>";



				if ($cuantas_disponibles<>0){
				$porcenta_total = ($cuantas_entregadas * 100) /$cuantas_disponibles;
				}
				if ($porcenta_total<= 20){
						$tmpa = $tmpa."<td class='alerta'>".number_format($porcenta_total, 2, '.', '')."%</td>";
				}
				else {
					if ($porcenta_total>= 90){
							$tmpa = $tmpa."<td class='ejecutandose'>".number_format($porcenta_total, 2, '.', '')."%</td>";
					}
					else
					{
							$tmpa = $tmpa."<td class='normal'>".number_format($porcenta_total, 2, '.', '')."%</td>";
					}
				}


				
			$tmpa = $tmpa."</tr>";	
			$tmpa=$tmpa."</table>"; 



			echo "<div class='separador_modular_50'>".$tmpa."</div>"; // LISTA DE DELEGACIONES



	
	}





}

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
    <script src="https://maps.googleapis.com/maps/api/js?key=".$key_mapkmz."&callback=initMap"
    async defer></script>





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
var key = "&key="+ <?php echo $key_map_static; ?>;
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
			

<?php
include ("./lib/body_footer.php");
?>