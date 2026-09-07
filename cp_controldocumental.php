<?php include("./lib/body_head.php");
include("./lib/body_menu.php");

// require ("./lib/flor_funciones.php");
?>
<link rel="stylesheet" href="lib/laura.css" />
<link rel="stylesheet" href="lib/plataforma_modern.css" />
<?php

$idDepartamento = nitavu_dpto($nitavu);
$id_aplicacion = "ap66";
$nivel = aplicacion_nivel($id_aplicacion, $nitavu);

if (sanpedro($id_aplicacion, $nitavu) == TRUE) {

	//PARA DAR ACCESO CUANDO ESTE REGISTRADA
	//historia($nitavu,'Req_ Entró a la aplicacion requisiciones'); 

	echo "<div id='AppDetalle'>" . app_detalle($id_aplicacion, $nitavu) . "</div>";

	echo '
		<script>
		function myFunction(){
			var publico = document.getElementById("publico");
			var baja = document.getElementById("baja");
			var media = document.getElementById("media");
			var alta = document.getElementById("alta");
			if (publico.checked == true){
			 //delegacion.checked == false;
			 document.getElementById("ofnumero").value=' . numeroOficioPublico(TRUE) . ';
			}else{
			 document.getElementById("ofnumero").value="";
			}
			if(baja.checked == true){
				media.checked = false;
				alta.checked = false;
			}else if(media.checked == true){
				baja.checked = false;
				alta.checked = false;
			}else if(alta.checked == true){
				baja.checked = false;
				media.checked = false;
			}
		}
		function deshabilitar(){
		}
		</script>
	';
	//Obtencion de datos para turnar caso.
	if (isset($_POST['idCaso']) and isset($_POST['numeroSeleccionado']) and isset($_POST['departamento'])) {

		$idDocumento = $_POST['idCaso'];
		$compartir = $_POST['compartir'];
		historia($nitavu, 'cp_Turno el caso número: ' . $idDocumento);
		if ($idDocumento != "") {
			$idDocumento = $_POST['idCaso'];
			$num = $_POST['numeroSeleccionado'];
			$dptoEnviar = $_POST['departamento'];
			if ($dptoEnviar == 1000) {
				mensaje("Favor de seleccionar un departamento a enviar", 'cp_controldocumental.php');
			} else {
				if (!empty($_FILES['contestacion']['name']) != null) {
					$numDocumento = numdeDocumento(TRUE);
					$doc = $_FILES["contestacion"]["name"];
					$tmp = $_FILES["contestacion"]["tmp_name"];
					$fecha = $_POST['fechaOficio'];
					//Consulta para saber a quien se enviará
					//$dptoEnviar = departamentoEnviar($num);
					$midpto = nitavu_dpto($nitavu);
					$archivo1 = "peticiones/" . $numDocumento . '_' . $idDocumento . '_' . $doc . "";
					$subida1 = FTP_subir($tmp, $archivo1);
					if ($subida1 == "TRUE") {
						$sql = "INSERT INTO cp_historialdocumentos(idInc,idDoc, NumCaso, archivo, fecha, nitavuSube, dptoSube, dptoEnviar, numOficio,hora) 
						VALUES (NULL,'$numDocumento', '$idDocumento', '$doc', '$fecha', '$nitavu', '$midpto','$dptoEnviar','$num','$hora')";
						if ($conexion->query($sql) == TRUE) {
							$sql2 = "UPDATE cp_nuevosdocumentos SET Turnadoa=" . $dptoEnviar . " WHERE id=" . $idDocumento . "";
							echo $sql2;
							if ($conexion->query($sql2) == TRUE) {
								//$sql3 = "UPDATE cp_controlcorrespondencia SET utilizado=1 WHERE numdocumento='".$num."'";
								//if ($conexion->query($sql3) == TRUE){
								numdeDocumento(FALSE);
								$turnara = aQuienSeTurnara($dptoEnviar, $idDocumento);
								for ($i = 0; $i < sizeof($turnara); $i++) {
									if ($turnara[$i] <> null || $turnara[$i] <> "") {
										notificacion_add($turnara[$i], 'Nuevo caso: ' . $idDocumento . '', $fecha, $nitavu, 'Buen día. <br> Turno esta petición ' . $idDocumento . ' con asunto:<b>' . asuntoCaso($idDocumento) . '</b> a su departamento debido a que compete a su área el requerimiento.');

									}
								}

								if ($nivel == 3 || $nivel == 1) {

									$sql = "UPDATE cp_colaboradores SET activo=1 WHERE nitavu=" . $nitavu . " and numcaso=" . $idDocumento;
									if ($conexion->query($sql) == TRUE) {
										historia($nitavu, 'Cambio de estatus del colaborador en el caso: ' . $idDocumento . ' a ' . nitavu_nombre($nitavu) . 'debido a que tengo nivel 3.');
									}

								}
								quitarVistoBueno($idDocumento);
								if (!isset($_POST['compartir'])) {
									eliminarColaboraciones($idDocumento);
								}
								mensaje('Se ha turnado el caso con éxito.', 'cp_controldocumental.php');
								//agregarSeguimiento($idDocumento, $num, $numDocumento ,$dptoEnviar, $fecha);
								//}else{
								//mensaje('Hubo un error al momento de turnar el caso, por favor vuelva a intentarlo.','cp_nuevos_oficios.php?id='.$idDocumento.'');
								//}	 
							} else {
								mensaje('Hubo un error al momento de turnar el caso, por favor vuelva a intentarlo.', 'cp_nuevos_oficios.php?id=' . $idDocumento . '');
							}
						} else {
							mensaje('Hubo un error al momento de turnar el caso, por favor vuelva a intentarlo.', 'cp_nuevos_oficios.php?id=' . $idDocumento . '');
						}
					} else {
						mensaje('Hubo un error al momento de intentar subir el archivo.', 'cp_nuevos_oficios.php?id=' . $idDocumento . '');
					}
				} else {
					//EN CASO DE QUE AL TURNAR NO HAYA SUBIDO UN ARCHIVO
					//Consulta para saber a quien se enviará
					//$dptoEnviar = departamentoEnviar($num);

					$midpto = nitavu_dpto($nitavu);
					$sql = "INSERT INTO cp_historialdocumentos(idInc,idDoc, NumCaso, archivo, fecha, nitavuSube, dptoSube, dptoEnviar, numOficio,hora) 
						VALUES (NULL,NULL, '$idDocumento', '', '$fecha', '$nitavu', '$midpto','$dptoEnviar','$num','$hora')";
					echo $sql;
					if ($conexion->query($sql) == TRUE) {
						$sql2 = "UPDATE cp_nuevosdocumentos SET Turnadoa=" . $dptoEnviar . " WHERE id=" . $idDocumento . "";
						echo $sql2;
						if ($conexion->query($sql2) == TRUE) {
							//$sql3 = "UPDATE cp_controlcorrespondencia SET utilizado=1 WHERE numdocumento='".$num."'";
							//if ($conexion->query($sql3) == TRUE){
							numdeDocumento(FALSE);
							$turnara = aQuienSeTurnara($dptoEnviar, $idDocumento);

							for ($i = 0; $i < sizeof($turnara); $i++) {
								if ($turnara[$i] <> null || $turnara[$i] <> "") {
									notificacion_add($turnara[$i], 'Nuevo caso: ' . $idDocumento . '', $fecha, $nitavu, 'Buen día. <br> Turno esta petición ' . $idDocumento . ' con asunto:<b>' . asuntoCaso($idDocumento) . '</b> a su departamento debido a que compete a su área el requerimiento.');

								}
							}
							if ($nivel == 3 || $nivel == 1) {

								$sql = "UPDATE cp_colaboradores SET activo=1 WHERE nitavu=" . $nitavu . " and numcaso=" . $idDocumento;
								if ($conexion->query($sql) == TRUE) {
									historia($nitavu, 'Cambio de estatus del colaborador en el caso: ' . $idDocumento . ' a ' . nitavu_nombre($nitavu) . 'debido a que tengo nivel 3.');
								}

							}
							quitarVistoBueno($idDocumento);
							if (!isset($_POST['compartir'])) {
								eliminarColaboraciones($idDocumento);
							}
							mensaje('Se ha turnado el caso con éxito.', 'cp_controldocumental.php');
							//agregarSeguimiento($idDocumento, $num, $numDocumento ,$dptoEnviar, $fecha);
							//}else{
							//mensaje('Hubo un error al momento de turnar el caso, por favor vuelva a intentarlo.','cp_nuevos_oficios.php?id='.$idDocumento.'');
							//}	 	 
						} else {
							mensaje('Hubo un error al momento de turnar el caso, por favor vuelva a intentarlo.', 'cp_nuevos_oficios.php?id=' . $idDocumento . '');
						}
					} else {
						mensaje('Hubo un error al momento de turnar el caso, por favor vuelva a intentarlo.', 'cp_nuevos_oficios.php?id=' . $idDocumento . '');
					}
					//mensaje('No ha seleccionado ningun archivo.','cp_nuevos_oficios.php?id='.$idDocumento.'');
				}
			}

		} else {
			return mensaje('No ha seleccionado el número con el que se turnará', 'cp_controldocumental.php');
		}

	}
	//OBTENER DATOS PARA FINALIZAR EL CASO 
	if (isset($_POST['comSolucionar'])) {
		$id = $_POST['id'];
		historia($nitavu, 'cp_Finalizo el caso: ' . $id . ' quien: ' . $nitavu);
		//$desc = $_POST['desc'];
		$nuevades = strtoupper($_POST['comSolucionar']);
		//$desJuntas = $desc.'. '.$nuevades;
		//$sql = "UPDATE cp_nuevosdocumentos SET descripcion='".$desJuntas."', estado=1 WHERE id=".$id."";

		//* se registra el comentario final como un nuevo comentario
		$sql = "";
		//$sql = "INSERT INTO cp_comentarios (CasoId, Comentario,  Nuser, Fecha, Hora) 
		//    VALUES ('".$id."', '".$_POST['comentario']."', '".$nitavu."', '".$fecha."', '".$hora."')";
		$sql = "INSERT INTO cp_comentarios (CasoId, Comentario,  Nuser, Fecha, Hora) 
			VALUES ('" . $id . "', 'COMENTARIO FINAL-" . $nuevades . "', '" . $nitavu . "', '" . $fecha . "', '" . $hora . "')";
		if ($conexion->query($sql) == TRUE) {
			historia($nitavu, 'cp_Comentar caso: ' . $id . ' Agrego el comentario: ' . $nuevades . ' ');
			notificarParticipantes($id, $nitavu, 'Se agrego un nuevo comentario al caso ' . $id . '', 'Nuevos comentarios al caso ' . $id);
			// mensaje('Comentario Guardado correctamente','cp_nuevos_oficios.php?id="'.$_GET['id']);
			unset($_POST['comentario'], $_POST['Comentar']);
			//*	
			//el estado en 1 nos dice que el caso ha sido terminado 		
			//registro terminado el caso
			$sql = "UPDATE cp_nuevosdocumentos SET estado=1, fecha_termino='" . $fecha . "' WHERE id=" . $id . "";
			if ($conexion->query($sql) == TRUE) {

				$empleados = participantesDelCaso($id);
				for ($i = 0; $i < sizeof($empleados); $i++) {
					if ($empleados[$i] <> null || $empleados[$i] <> "") {
						if ($nitavu <> $empleados[$i]) {

							notificacion_add($empleados[$i], 'Caso finalizado' . $id . '', $fecha, $nitavu, 'Buen día. <br> Se le informa que la petición número ' . $id . ' ha finalizado. <br>De asunto:<b>' . asuntoCaso($id) . '</b> <br>Para más información consultar en la aplicación Control Documental.');
							return mensaje('Se ha guardado la información correctamente. El caso ha sido terminado.', 'cp_controldocumental.php');
						}

					}
				}
				return mensaje('Se ha guardado la información correctamente. El caso ha sido terminado.', 'cp_controldocumental.php');
			} else {
				return mensaje('Ocurrio un error al momento de guardar la información, por favor vuelva a intentarlo.', 'cp_controldocumental.php');
			}


			//*	
		} else {
			mensaje('ERROR al guardar el comentario final', 'cp_nuevos_oficios.php?id="' . $_GET['id']);
		}

	}
	// echo"<h1>Control Documental De: <span style='color:#0064A7'>".nitavu_dpto_nombre($nitavu)." <span></h1>";
	// echo "<br>";
	//-----------------------------------------------------

	//Obtencion de datos para modificar informacion de un oficio 
	if (isset($_GET['editar'])) {
		$numcaso = $_GET['editar'];
		$fechaoficio = $_POST['fechaOficio'];
		$fecha = $_POST['fecha'];
		$fechaTermino = $_POST['fechaTermino'];
		if (isset($_POST['fechaTermino'])) {
			$fechaTermino = $_POST['fechaTermino'];
		} else {
			$fechaTermino = '';
		}
		$fechaTerminoSql = ($fechaTermino !== '') ? '"' . $fechaTermino . '"' : '"0000-00-00"';
		$ofnumero = $_POST['ofnumero'];
		//$prioridad = $_POST['prioridad'];
		$remite = $_POST['remite'];
		$puesto = $_POST['puesto'];
		$dependencia = $_POST['dependencia'];
		$asunto = $_POST['asunto'];
		$descripcion = $_POST['descripcion'];


		$sql = 'UPDATE cp_nuevosdocumentos SET fechaOficio="' . $fechaoficio . '", fecha="' . $fecha . '", oficioNumero="' . $ofnumero . '",
		remite="' . $remite . '", puesto="' . $puesto . '", dependencia="' . $dependencia . '", asunto="' . $asunto . '", descripcion="' . $descripcion . '", fecha_termino = ' . $fechaTerminoSql . '
		 WHERE id=' . $numcaso . ' ';
		//echo $sql;
		if ($conexion->query($sql) == TRUE) {
			historia($nitavu, 'Modifico la información del caso: ' . $numcaso . ' sql_' . $sql);
			mensaje('Se modifico la información correctamente.', 'cp_controldocumental.php');
		} else {
			mensaje('Ocurrio un error, favor de volver a intentarlo.', 'cp_controldocumental.php');

		}
	}


	//ELIMINAR UN CASO 
	if (isset($_POST['darBaja'])) {
		$numcaso = $_POST['darBaja'];

		$sql = 'UPDATE cp_nuevosdocumentos SET baja=1 WHERE id=' . $numcaso . '';
		//echo $sql;
		if ($conexion->query($sql) == TRUE) {
			historia($nitavu, 'Se ha eliminado el caso: ' . $numcaso . '');
			mensaje('Se ha eliminado correctamente el caso.', 'cp_controldocumental.php');
		} else {
			mensaje('Ocurrio un error, favor de volver a intentarlo.', 'cp_controldocumental.php');
		}
	}

	$dpto = nitavu_dpto($nitavu);

	// Consultas dinámicas para tarjetas KPI
	$q_pend = $conexion->query("SELECT count(*) as n FROM cp_nuevosdocumentos WHERE turnadoa=" . $dpto . " and estado=0 and baja=0");
	$count_pend = ($f_p = $q_pend->fetch_array()) ? $f_p['n'] : 0;

	$q_proc = $conexion->query("SELECT count(*) as n FROM cp_nuevosdocumentos WHERE turnadoa=" . $dpto . " and estado=2 and baja=0");
	$count_proc = ($f_pr = $q_proc->fetch_array()) ? $f_pr['n'] : 0;

	$q_colab = $conexion->query("SELECT count(*) as n FROM cp_nuevosdocumentos inner join cp_colaboradores on cp_colaboradores.numcaso=cp_nuevosdocumentos.id WHERE cp_nuevosdocumentos.estado=0 and cp_nuevosdocumentos.baja=0 and cp_colaboradores.activo=0 and cp_colaboradores.nitavu=" . $nitavu);
	$count_colab = ($f_co = $q_colab->fetch_array()) ? $f_co['n'] : 0;

	$q_atraso = $conexion->query("SELECT count(*) as n FROM cp_nuevosdocumentos WHERE turnadoa=" . $dpto . " and estado=0 and baja=0 and DATEDIFF(CURDATE(), fecha) >= 5");
	$count_atraso = ($f_at = $q_atraso->fetch_array()) ? $f_at['n'] : 0;
	?>

	<div class="cd-wrapper">
		<!-- Hero Header -->
		<div class="cd-hero">
			<div>
				<h1 class="cd-hero-title">
					<i class="fa-solid fa-folder-tree"></i> Control Documental
				</h1>
				<div class="cd-hero-dept">
					<i class="fa-solid fa-building-columns"></i> Departamento:
					<span><?php echo nitavu_dpto_nombre($nitavu); ?></span>
				</div>
			</div>
			<div class="cd-top-links">
				<a href="cp_miactividad.php?pes=finalizados" class="cd-top-link-btn">
					<i class="fa-solid fa-clock-rotate-left"></i> Historial Finalizados
				</a>
				<a href="tickets.php" class="cd-top-link-btn">
					<i class="fa-solid fa-ticket"></i> Colaboraciones Activas
				</a>
			</div>
		</div>

		<!-- KPI Statistics Grid -->
		<div class="cd-kpi-grid">
			<div class="cd-kpi-card">
				<div class="cd-kpi-icon primary">
					<i class="fa-solid fa-inbox"></i>
				</div>
				<div class="cd-kpi-details">
					<span class="cd-kpi-num"><?php echo $count_pend; ?></span>
					<span class="cd-kpi-label">Nuevos / Pendientes</span>
				</div>
			</div>
			<div class="cd-kpi-card">
				<div class="cd-kpi-icon info">
					<i class="fa-solid fa-spinner"></i>
				</div>
				<div class="cd-kpi-details">
					<span class="cd-kpi-num"><?php echo $count_proc; ?></span>
					<span class="cd-kpi-label">En Atención</span>
				</div>
			</div>
			<div class="cd-kpi-card">
				<div class="cd-kpi-icon gold">
					<i class="fa-solid fa-users-gear"></i>
				</div>
				<div class="cd-kpi-details">
					<span class="cd-kpi-num"><?php echo $count_colab; ?></span>
					<span class="cd-kpi-label">Mis Colaboraciones</span>
				</div>
			</div>
			<div class="cd-kpi-card">
				<div class="cd-kpi-icon warning">
					<i class="fa-solid fa-triangle-exclamation"></i>
				</div>
				<div class="cd-kpi-details">
					<span class="cd-kpi-num"><?php echo $count_atraso; ?></span>
					<span class="cd-kpi-label">Con Atraso (≥ 5 días)</span>
				</div>
			</div>
		</div>

		<!-- Main Toolbar Actions -->
		<div class="cd-toolbar-card">
			<div class="cd-toolbar-group">
				<?php if ($nivel == 1 || soytitular($nitavu) != 'FALSE'): ?>
					<a href="#documentoNew" rel="MyModal:open" class="cd-btn cd-btn-primary" title="Crear Nuevo Caso u Oficio">
						<i class="fa-solid fa-file-circle-plus"></i> Nuevo TICKET
					</a>
				<?php endif; ?>

				<?php if ($nivel == 1 || soytitular($nitavu) <> 'FALSE'): ?>
					<a href="cp_permisos.php" class="cd-btn cd-btn-gold" title="Asignar permisos a colaboradores">
						<i class="fa-solid fa-user-shield"></i> Asignar Permisos
					</a>
				<?php endif; ?>
			</div>

			<div class="cd-toolbar-group">
				<?php
				$arr = revisarMisColaboraciones($nitavu);
				if ($nivel == 1 || soytitular($nitavu) != 'FALSE' || soyColaborador($nitavu) == 'TRUE'):
					?>
					<a href="#docuementosRecientes" rel="MyModal:open" class="cd-btn cd-btn-outline-gold"
						title="Documentos Recientes">
						<i class="fa-solid fa-folder-open"></i> Documentos Recientes
					</a>
				<?php endif; ?>
			</div>
		</div>
		<?php

		echo "<div  style='width=90%; margin-top:15px;'>";
		if (isset($_GET['busqueda'])) {
			$search = $_GET['busqueda'];
		} else {
			// echo "<label></label>";
			// buscar("cp_controldocumental.php","Buscar documento",'');
		}
		if (isset($_GET['busqueda'])) {

			// ,case WHEN (dptoSube=".nitavu_dpto($nitavu).") THEN
			// 1
			// ELSE
			// 0
			// END AS 	ver
			// $sql = " -- cp 
			// SELECT distinct 
			// hd.nitavuSube Usuario,
			// (select nombre from empleados where nitavu=Usuario) as Nombre,
			// hd.numOficio AS NumEntrante, nvdoc.remite as Remitente,nvdoc.asunto as EAsunto,nvdoc.descripcion, nvdoc.fechaOficio,hd.NumCaso
			// FROM cp_nuevosdocumentos as nvdoc inner join cp_historialdocumentos as hd on nvdoc.id=hd.NumCaso and nvdoc.baja = 0
			// WHERE (nvdoc.asunto like '%".$search."%' or nvdoc.descripcion like '%".$search."%'  or  hd.numOficio  like '%".$search."%' or hd.NumCaso like '%".$search."%') group by hd.NumCaso";
	
			$sql = "		
				select * from tickets 
				WHERE descripcion like '%" . $search . "%' or EAsunto like '%" . $search . "%' or NumCaso like '%" . $search . "%'
			";

			historia($nitavu, "Busco " . $search . " en Control Documental o Ticket");
			// echo $sql;
// echo "<br><br>";
	
			$r = $conexion->query($sql);
			$r_count = $r->num_rows;
			if ($r_count <= 0) {
				historia($nitavu, 'cp_Busqueda fallida de ' . $search);
				$msg = "Lo sentimos no se han encontrado resultados sobre <b>" . $search . "</b>";
				$msg = $msg . " Vuelva a intentarlo utilizando otras palabras de busqueda";
				mensaje($msg, "cp_controldocumental.php");
			} else {
				/// PARA PAGINAR
				//Comprueba si está seteado el GET de HTTP
				if (isset($_GET["p"])) {
					//Si el GET de HTTP SÍ es una string / cadena, procede
					if (is_string($_GET["p"])) {
						//Si la string es numérica, define la variable 'pagina'
						if (is_numeric($_GET["p"])) {
							//Si la petición desde la paginación es la página uno
							//en lugar de ir a 'index.php?pagina=1' se iría directamente a 'index.php'
							$pagina = $_GET["p"];

						} else { //Si la string no es numérica, redirige al index (por ejemplo: index.php?pagina=AAA)
							header("Location: ./index.php");
							die();
						}
						;
					}
					;
				} else { //Si el GET de HTTP no está seteado, lleva a la primera página (puede ser cambiado al index.php o lo que sea)
					$pagina = 1;
				}
				;
				//Define el número 0 para empezar a paginar multiplicado por la cantidad de resultados por página
				$empezar_desde = ($pagina - 1) * $paginacion;
				// agregamos limite a la consulta
				$sql = $sql . " LIMIT " . $empezar_desde . ", " . $paginacion;
				// echo $sql;
				$r = $conexion->query($sql);
				echo "<h4>Resultados " . $r_count . " sobre <b>[ " . $search . " ]</b>, agrupados de " . $paginacion . " </h4>";
				$paginas = intval(($r_count / $paginacion));
				historia($nitavu, 'cp_Busqueda de ' . $search);

				echo "<center><div id='peticiones' style='border: 0px; width:90%;'>";
				$cont = 0;
				while ($f = $r->fetch_array()) { // resultado de la busqueda.................
					$cont = $cont + 1;
					echo "<div id='resultado_elemento'  >";
					echo "<table border='0'>";
					echo "<tr>";

					// DATOS OFICIO ENTRANTE
					echo "<td style=' width:10px; text-align: left;' class='tipo_menu'>";
					echo "" . $f['NumCaso'];
					echo " </td>";
					echo "<td width='90%' class='tipo_nitavu'>";
					echo "<table border='0'>";
					echo "<tr>";
					echo "<td>";
					echo "<span class='normal tmediano'>" . $f['NumEntrante'] . "</span> por " . $f['Nombre'];
					echo "<span class='pc tchico'><br>Remitente: " . $f['Remitente'] . "    " . date_format(date_create($f['fechaOficio']), 'd/m/Y') . " </span>";
					echo "<span class='pc tchico'><br>Descripción: " . $f['descripcion'] . "</span>";

					echo "</td>";
					echo "</tr>";
					echo "</table>";

					echo "</td>";
					echo "<td style='text-align: right; width='10px;'  class='tipo_menu'>";

					//$arr = participoenElCasoYNivelUno($f['NumCaso']);
					$participeCaso = participeEnElCaso($nitavu, $f['NumCaso']);
					$dptoParticipo = soyDeUnDepartamentoQueParticipo($nitavu, $f['NumCaso']);


					$flag = 0;
					//for ($i=0; $i < count($arr) ; $i++) {
					//echo $arr[$i];
					//if(soyColaborador_caso($f['NumCaso'],$nitavu)!='FALSE' || $nivel==1 || soytitular($nitavu)!='FALSE' ){
					//if( ($par =='TRUE' and $flag == 0) || (yoLoInicie($f['NumCaso'])==$nitavu and $flag == 0) || (soyColaborador_caso($f['NumCaso'],$nitavu)!='FALSE' and $flag == 0 )|| ($nivel == 1 and estaTurnadoami($f['NumCaso'])==nitavu_dpto($nitavu) and $flag == 0) || ($arr[$i]!=null and $arr[$i]==$nitavu and $flag == 0)){
					if (($dptoParticipo == 'TRUE' and $flag == 0 and $nivel == 1) || (yoLoInicie($f['NumCaso']) == $nitavu and $flag == 0) || (soyColaborador_caso($f['NumCaso'], $nitavu) != 'FALSE' and $flag == 0) || ($nivel == 1 and estaTurnadoami($f['NumCaso']) == nitavu_dpto($nitavu) and $flag == 0) || ($participeCaso == 'TRUE' and $flag == 0)) {
						//if( ($dptoParticipo =='TRUE' and $flag == 0) ){
	
						//echo $f['NumCaso'];
						//echo estaTurnadoami($f['NumCaso']);
						$flag = 1;

						echo "<a href='cp_nuevos_oficios.php?id=" . $f['NumCaso'] . "'><img src='icon/entrar.png' class='icono' title='Ver Historial'></a>";


					}
					echo "<td style='text-align: right; width='10px;'  class='tipo_menu'>";
					echo "<img src='img/regreso.png' class='icono'>";
					echo " </td>";

					//}
					//}
	

					echo " </td>";
					echo "</tr></table>";
					echo "</div>";
				}

				echo "</div>";

				if ($r_count >= $paginacion) {
					echo "<div id='barra_paginacion'>";
					echo "Paginas: ";
					//Crea un bucle donde $i es igual 1, y hasta que $i sea menor o igual a X, a sumar (1, 2, 3, etc.)
					//Nota: X = $total_paginas
					for ($i = 1; $i <= $paginas + 1; $i++) {
						//En el bucle, muestra la paginación
						if ($pagina == $i) {
							echo "<span id='pagina_actual'>" . $pagina . "</span>"; //para el CSS span = a pagina actual
						} else {
							//	echo "<span id='pagina_proxima'><a href='?search=".$search."&p=".$i."'>".$i."</a></span>"; //CSS span a = link a paginas
							echo "<span id='pagina_proxima'><a href='?busqueda=" . $search . "&p=" . $i . "'>" . $i . "</a></span>"; //CSS span a = link a paginas
						}
					}
					echo "</div></center>";
				}
			}
		}
		// echo "<br><br>";
		//***Agrego form de busqueda moderna
		?>
		<div class="cd-search-card">
			<form action="cp_nuevos_oficios.php" method="GET" class="cd-search-form">
				<div class="cd-search-label">
					<i class="fa-solid fa-magnifying-glass-chart" style="color: var(--cd-gold-dark);"></i>
					<span>Consulta directa por número de correspondencia:</span>
				</div>
				<div class="cd-input-group">
					<input type="text" name="id" id="id" class="cd-input"
						placeholder="Ingrese el número de correspondencia..."
						onChange="this.value=validar_numeros(this.value)" required>
					<button type="submit" class="cd-btn cd-btn-primary">
						<i class="fa-solid fa-arrow-right-to-bracket"></i> Abrir Caso
					</button>
				</div>
			</form>
		</div>
		<?php

		echo "<br><br>";

		//---------------------------------------------------------
		//DIV DE PETICIONES PENDIENTES	
	
		echo "<div id='peticiones'>";

		$dpto = nitavu_dpto($nitavu);
		// echo "<br><br>";
		if (soytitular($nitavu) != 'FALSE' || $nivel == 1) {
			// $query = "SELECT * FROM cp_nuevosdocumentos WHERE turnadoa=".$dpto." and estado=0 and baja=0 ORDER BY prioridad DESC";
	
			$query = "SELECT count(*) as n FROM cp_nuevosdocumentos WHERE turnadoa=" . $dpto . " and estado=0 and baja=0";
			//echo $query;
			$rc2 = $conexion->query($query);
			//Notice: Trying to get property 'num_rows' of non-object 
			if ($f = $rc2->fetch_array()) {
				$count = $f['n'];
			}

			if ($count > 0) {

				//*************aqui empieza a mostrar el listado de pantalla
				// $query = "SELECT 
				// fecha as FechaDesde,
				//  (SELECT DATEDIFF(CURDATE(),FechaDesde)) as Retraso,
				//  cp_nuevosdocumentos.* 
				//  FROM cp_nuevosdocumentos WHERE turnadoa=".$dpto." and estado=0 and baja=0 ORDER BY id ASC";
				//  echo $query;	
				$sql = "SELECT 
			fecha as FechaDesde,
			 (SELECT DATEDIFF(CURDATE(),FechaDesde)) as Retraso,
			 cp_nuevosdocumentos.* 
			 FROM cp_nuevosdocumentos WHERE turnadoa=" . $dpto . " and estado=0 and baja=0 ORDER BY id DESC";
				//$rc= $conexion -> query($query);
				// Usamos el COUNT ya calculado para evitar una consulta completa extra sin LIMIT.
				$r_count = (int) $count;


				// PARA PAGINAR
				//Comprueba si está seteado el GET de HTTP
				if (isset($_GET["p"])) {
					//Si el GET de HTTP SÍ es una string / cadena, procede
					if (is_string($_GET["p"])) {
						//Si la string es numérica, define la variable 'pagina'
						if (is_numeric($_GET["p"])) {
							//Si la petición desde la paginación es la página uno
							//en lugar de ir a 'index.php?pagina=1' se iría directamente a 'index.php'
							$pagina = $_GET["p"];

						} else { //Si la string no es numérica, redirige al index (por ejemplo: index.php?pagina=AAA)
							header("Location: ./index.php");
							die();
						}
						;
					}
					;
				} else { //Si el GET de HTTP no está seteado, lleva a la primera página (puede ser cambiado al index.php o lo que sea)
					$pagina = 1;
				}
				;
				//Define el número 0 para empezar a paginar multiplicado por la cantidad de resultados por página
				$empezar_desde = ($pagina - 1) * $paginacion;
				// agregamos limite a la consulta
				$sql = $sql . " LIMIT " . $empezar_desde . ", " . $paginacion;
				// echo $sql;
	
				$paginas = intval(($r_count / $paginacion)) + 1;
				// echo $paginas;
				// echo $r_count;
	



				echo "<table width=100%><tr><td>";
				echo "<center>";
				// echo "<h2 style='color: darkred; font-size: 18px;'>CASOS NUEVOS Y PENDIENTES EN MI DEPARTAMENTO</h>";
	
				?>
				<div class="cd-card-section">
					<div class="cd-card-header cd-card-header-primary">
						<h3 class="cd-card-title">
							<i class="fa-solid fa-inbox"></i> Casos Nuevos y Pendientes de Mi Departamento
						</h3>
						<span class="cd-badge cd-badge-info"><?php echo $r_count; ?> Casos</span>
					</div>
					<div class="cd-card-body" style="padding:0;">
						<div class="cd-table-container">
							<table class="cd-table">
								<thead>
									<tr>
										<th style="width: 75px; text-align: center;">ID</th>
										<th style="width: 175px;">Fecha / Atraso</th>
										<th style="width: 130px;">No. Oficio</th>
										<th>Asunto & Descripción</th>
										<th style="width: 120px; text-align: center;">Acciones</th>
										<?php if (soytitular($nitavu) != 'FALSE'): ?>
											<th style="width: 80px; text-align: center;">VoBo</th>
											<th style="width: 80px; text-align: center;">Actividad</th>
										<?php endif; ?>
									</tr>
								</thead>
								<tbody>
									<?php
									$rc = $conexion->query($sql);
									while ($r = $rc->fetch_array()) {
										$marcado = casoCompartidoCon($r['id']);
										echo "<tr>";

										// ID Column
										if (casoIsTurnado($r['id']) == TRUE) {
											echo "<td style='text-align: center;'><span class='cd-badge-id'>" . $r['id'] . "</span></td>";
										} else {
											echo "<td style='text-align: center;' title='Aún no se ha turnado a un departamento'><span class='cd-badge-id unturned'>" . $r['id'] . "</span></td>";
										}

										// Fecha & Retraso Column
										echo "<td><span style='font-weight:600; color:var(--cd-dark);'>" . fecha_corta($r['fecha']) . "</span><br>";
										if ($r['Retraso'] >= 0) {
											if ($r['Retraso'] >= 5 and $r['Retraso'] <= 30) {
												echo " <span class='cd-badge cd-badge-warning'><i class='fa-solid fa-clock'></i> " . $r['Retraso'] . " días de atraso</span>";
											}
											if ($r['Retraso'] >= 31) {
												echo " <span class='cd-badge cd-badge-danger'><i class='fa-solid fa-triangle-exclamation'></i> " . $r['Retraso'] . " días de atraso</span>";
											}
										}
										echo "</td>";

										// Oficio Column
										echo "<td><b>" . htmlspecialchars($r['oficioNumero']) . "</b></td>";

										// Asunto Column
										echo "<td><div><b style='text-transform: uppercase; color:var(--cd-dark);'>" . mb_strtoupper(htmlspecialchars($r['asunto']), 'UTF-8') . "</b><br><span style='font-size:0.82rem; color:var(--cd-gray-dark);'>" . htmlspecialchars($r['descripcion']) . "</span><br>";
										echo "<span style='font-size:0.78rem; color:#991b1b;'><i class='fa-solid fa-building-user'></i> Creado por: " . nombreDepartamento($r['idDptoCrea']) . "</span><br>";

										$fech = marcadaconVistoBueno($r['id'], $nitavu);
										$tit = titular(nitavu_dpto($nitavu));
										$vo = miTitularDioVistobueno($r['id'], $tit);

										if (($fech <> "" || $vo <> "") && $tit <> "") {
											$quien = quienDioVistoBueno($r['id'], $tit);
											echo "<span class='cd-badge cd-badge-success' style='margin-top:4px;'><i class='fa-solid fa-check'></i> VoBo por " . nitavu_nombre($quien) . "</span> ";
										}

										$personas = casoCompartidoCon($r['id']);
										if ($personas > 0) {
											echo "<div style='font-size:0.78rem; color:var(--cd-gray-mid); margin-top:4px;'><i class='fa-solid fa-share-nodes'></i> Compartido con: ";
											for ($k = 0; $k < sizeof($personas); $k++) {
												if ($personas[$k] <> "") {
													echo nitavu_nombre($personas[$k]);
													if (subioArchivos($r['id'], $personas[$k]) == 'TRUE') {
														echo " <i class='fa-solid fa-paperclip' style='color:#16a34a;'></i>";
													}
													if ($k < sizeof($personas) - 1)
														echo ", ";
												}
											}
											echo "</div>";
										}
										echo "</div>";
										// Modal Editar Caso
										echo "<div id='modalEditarCaso" . $r['id'] . "' class='MyModal'><h3><i class='fa-solid fa-pen-to-square'></i> Modificar Información del Oficio</h3>";
										echo "<form action='cp_controldocumental.php?editar=" . $r['id'] . "' method='POST' enctype='multipart/form-data'>";
										$res4 = $r;

										echo '<div class="cd-form-grid-3">
						<div class="cd-form-group"><label class="cd-form-label"><i class="fa-regular fa-calendar"></i> Fecha Captura</label><input type="date" class="cd-form-control" style="background:#f1f5f9;" id="fecha" name="fecha" value="' . $res4['fecha'] . '" required readonly></div>
						<div class="cd-form-group"><label class="cd-form-label"><i class="fa-solid fa-calendar-day" style="color:var(--cd-primary);"></i> *Fecha del Oficio</label><input type="date" class="cd-form-control" id="fechaOficio" name="fechaOficio" value="' . $res4['fechaOficio'] . '" required></div>
						<div class="cd-form-group"><label class="cd-form-label"><i class="fa-solid fa-hashtag" style="color:var(--cd-gold-dark);"></i> No. Oficio / Ref.</label><input class="cd-form-control" id="ofnumero" name="ofnumero" value="' . htmlspecialchars($res4['oficioNumero']) . '"/></div>
					</div>';

										echo '<div class="cd-form-grid-3">
						<div class="cd-form-group"><label class="cd-form-label"><i class="fa-solid fa-user"></i> Remite</label><input class="cd-form-control" id="remite" name="remite" value="' . htmlspecialchars($res4['remite']) . '"></div>
						<div class="cd-form-group"><label class="cd-form-label"><i class="fa-solid fa-id-card"></i> Puesto</label><input class="cd-form-control" id="puesto" name="puesto" value="' . htmlspecialchars($res4['puesto']) . '"></div>
						<div class="cd-form-group"><label class="cd-form-label"><i class="fa-solid fa-building"></i> Dependencia</label><input class="cd-form-control" id="dependencia" name="dependencia" value="' . htmlspecialchars($res4['dependencia']) . '"></div>
					</div>';

										echo '<div class="cd-form-grid">
						<div class="cd-form-group"><label class="cd-form-label"><i class="fa-solid fa-pen-nib" style="color:var(--cd-primary);"></i> *Asunto Principal</label><input class="cd-form-control" name="asunto" value="' . htmlspecialchars($res4['asunto']) . '" required></div>
						<div class="cd-form-group"><label class="cd-form-label"><i class="fa-solid fa-align-left"></i> Descripción Extendida</label><textarea class="cd-form-control" style="height:42px; min-height:42px; resize:vertical;" name="descripcion">' . htmlspecialchars($res4['descripcion']) . '</textarea></div>
					</div>';

										echo '<div style="margin-top:10px; display:flex; justify-content:space-between; align-items:center; border-top:1px solid var(--cd-border); padding-top:10px;">';
										if ($res4['fecha_termino'] != '0000-00-00') {
											echo '<label class="cd-form-label" style="margin:0;"><input type="checkbox" id="fechaTer' . $r['id'] . '" name="fechaTer' . $r['id'] . '" value="fechaTer' . $r['id'] . '" onClick="quitarFechaTermino(' . $r['id'] . ')" checked> Fecha término</label>';
											echo "<div id='divfechaTermino" . $r['id'] . "' class='cd-form-group' style='margin:0;'><input type='date' class='cd-form-control' id='fechaTermino" . $r['id'] . "' name='fechaTermino' value='" . $res4['fecha_termino'] . "'></div>";
										} else {
											echo '<label class="cd-form-label" style="margin:0;"><input type="checkbox" id="fechaTer' . $r['id'] . '" name="fechaTer' . $r['id'] . '" value="fechaTer' . $r['id'] . '" onClick="mostrarFechaTerminoModal(' . $r['id'] . ')"> Fecha término</label>';
											echo "<div id='divfechaTermino" . $r['id'] . "' class='cd-form-group' style='display:none; margin:0;'><input type='date' class='cd-form-control' id='fechaTermino' name='fechaTermino'></div>";
										}
										echo '<button type="submit" class="cd-btn cd-btn-primary" style="margin-left:auto;"><i class="fa-solid fa-floppy-disk"></i> Guardar Cambios</button>';
										echo '</div>';
										echo "</form></div>";

										echo "</td>"; // Fin celda de asunto/detalles
						
										// Columna de Acciones
										echo "<td style='text-align:center;'><div class='cd-action-group'>";
										echo "<form action='cp_nuevos_oficios.php' method='GET' style='margin:0; display:inline;'><input type='hidden' value='" . $r['id'] . "' name='id'><input type='hidden' name='txtplus' value='1'><input type='hidden' name='pv' value='1'><button type='submit' class='cd-icon-btn view' title='Ver Historial del Caso'><i class='fa-solid fa-eye'></i></button></form>";
										if ($r['nitavuCaptura'] == $nitavu) {
											echo "<form action='cp_controldocumental.php' method='POST' style='margin:0; display:inline;'><input type='hidden' value='" . $r['id'] . "' id='darBaja' name='darBaja'><button type='submit' class='cd-icon-btn delete' title='Eliminar Caso'><i class='fa-solid fa-trash-can'></i></button></form>";
											echo "<a href='#modalEditarCaso" . $r['id'] . "' rel='MyModal:open' class='cd-icon-btn edit' title='Modificar información'><i class='fa-solid fa-pen-to-square'></i></a>";
										}
										echo "</div></td>";

										// Columna de VoBo y Actividad (titulares)
										if (soytitular($nitavu) != 'FALSE') {
											if ($fech == "" && $vo == "") {
												echo "<td style='text-align:center;'><form action='cp_controldocumental.php' method='GET' style='margin:0;'><input type='hidden' value='" . $r['id'] . "' name='vobo1'><button type='submit' class='cd-icon-btn check' title='Dar Visto Bueno'><i class='fa-solid fa-circle-check'></i></button></form></td>";
											} else {
												echo "<td style='text-align:center;'><span class='cd-badge cd-badge-success'><i class='fa-solid fa-circle-check'></i></span></td>";
											}
											echo "<td style='text-align:center;'><span class='cd-badge cd-badge-info'>" . actividaddelCaso($r['id']) . "</span></td>";
										}

										echo "</tr>";
									} // fin while
									?>
								</tbody>
							</table>
						</div>
					</div>
				</div>

				<?php
				if ($r_count >= $paginacion) {
					echo "<div class='cd-pagination'>";
					for ($i = 1; $i <= $paginas; $i++) {
						if ($pagina == $i) {
							echo "<span class='active'>" . $pagina . "</span>";
						} else {
							echo "<a href='?p=" . $i . "'>" . $i . "</a>";
						}
					}
					echo "</div>";
				}
			} // fin count > 0
	
			/******empiezan los en proceso de atención*/
			$query = "SELECT 
			fecha as FechaDesde,
			 (SELECT DATEDIFF(CURDATE(),FechaDesde)) as Retraso,
			 cp_nuevosdocumentos.* 
			 FROM cp_nuevosdocumentos WHERE turnadoa=" . $dpto . " and estado=2 and baja=0 ORDER BY id DESC";
			$rca = $conexion->query($query);
			$count_proc_rows = $rca->num_rows;
			if ($count_proc_rows > 0) {
				?>
				<div class="cd-card-section">
					<div class="cd-card-header cd-card-header-info">
						<h3 class="cd-card-title">
							<i class="fa-solid fa-spinner" style="color:var(--cd-gold-dark);"></i> Casos En Proceso de Atención
						</h3>
						<span class="cd-badge cd-badge-info"><?php echo $count_proc_rows; ?> Casos</span>
					</div>
					<div class="cd-card-body" style="padding:0;">
						<div class="cd-table-container">
							<table class="cd-table">
								<thead>
									<tr>
										<th style="width: 75px; text-align: center;">ID</th>
										<th style="width: 175px;">Fecha / Atraso</th>
										<th style="width: 130px;">No. Oficio</th>
										<th>Asunto & Descripción</th>
										<th style="width: 120px; text-align: center;">Acciones</th>
										<?php if (soytitular($nitavu) != 'FALSE'): ?>
											<th style="width: 80px; text-align: center;">VoBo</th>
											<th style="width: 80px; text-align: center;">Actividad</th>
										<?php endif; ?>
									</tr>
								</thead>
								<tbody>
									<?php
									while ($ra = $rca->fetch_array()) {
										echo "<tr>";
										if (casoIsTurnado($ra['id']) == TRUE) {
											echo "<td style='text-align: center;'><span class='cd-badge-id'>" . $ra['id'] . "</span></td>";
										} else {
											echo "<td style='text-align: center;'><span class='cd-badge-id unturned'>" . $ra['id'] . "</span></td>";
										}
										echo "<td><span style='font-weight:600; color:var(--cd-dark);'>" . fecha_corta($ra['fecha']) . "</span><br>";
										if ($ra['Retraso'] >= 0) {
											if ($ra['Retraso'] >= 5 and $ra['Retraso'] <= 30) {
												echo " <span class='cd-badge cd-badge-warning'><i class='fa-solid fa-clock'></i> " . $ra['Retraso'] . " días de atraso</span>";
											}
											if ($ra['Retraso'] >= 31) {
												echo " <span class='cd-badge cd-badge-danger'><i class='fa-solid fa-triangle-exclamation'></i> " . $ra['Retraso'] . " días de atraso</span>";
											}
										}
										echo "</td>";
										echo "<td><b>" . htmlspecialchars($ra['oficioNumero']) . "</b></td>";
										echo "<td><div><b style='text-transform: uppercase; color:var(--cd-dark);'>" . mb_strtoupper(htmlspecialchars($ra['asunto']), 'UTF-8') . "</b><br><span style='font-size:0.82rem; color:var(--cd-gray-dark);'>" . htmlspecialchars($ra['descripcion']) . "</span><br>";
										echo "<span style='font-size:0.78rem; color:var(--cd-gold-dark);'><i class='fa-solid fa-building-user'></i> Creado por: " . nombreDepartamento($ra['idDptoCrea']) . "</span><br>";

										$fech = marcadaconVistoBueno($ra['id'], $nitavu);
										$tit = titular(nitavu_dpto($nitavu));
										$vo = miTitularDioVistobueno($ra['id'], $tit);
										if (($fech <> "" || $vo <> "") && $tit <> "") {
											$quien = quienDioVistoBueno($ra['id'], $tit);
											echo "<span class='cd-badge cd-badge-success' style='margin-top:4px;'><i class='fa-solid fa-check'></i> VoBo por " . nitavu_nombre($quien) . "</span> ";
										}
										$personas = casoCompartidoCon($ra['id']);
										if ($personas > 0) {
											echo "<div style='font-size:0.78rem; color:var(--cd-gray-mid); margin-top:4px;'><i class='fa-solid fa-share-nodes'></i> Compartido con: ";
											for ($k = 0; $k < sizeof($personas); $k++) {
												if ($personas[$k] <> "") {
													echo nitavu_nombre($personas[$k]);
													if (subioArchivos($ra['id'], $personas[$k]) == 'TRUE') {
														echo " <i class='fa-solid fa-paperclip' style='color:#16a34a;'></i>";
													}
													if ($k < sizeof($personas) - 1)
														echo ", ";
												}
											}
											echo "</div>";
										}
										echo "</div>";

										// Modal editar caso para en proceso
										echo "<div id='modalEditarCaso" . $ra['id'] . "' class='MyModal'><h3><i class='fa-solid fa-pen-to-square'></i> Modificar Información del Oficio</h3>";
										echo "<form action='cp_controldocumental.php?editar=" . $ra['id'] . "' method='POST' enctype='multipart/form-data'>";
										$res4 = $ra;

										echo '<div class="cd-form-grid-3">
						<div class="cd-form-group"><label class="cd-form-label"><i class="fa-regular fa-calendar"></i> Fecha Captura</label><input type="date" class="cd-form-control" style="background:#f1f5f9;" id="fecha" name="fecha" value="' . $res4['fecha'] . '" required readonly></div>
						<div class="cd-form-group"><label class="cd-form-label"><i class="fa-solid fa-calendar-day" style="color:var(--cd-primary);"></i> *Fecha del Oficio</label><input type="date" class="cd-form-control" id="fechaOficio" name="fechaOficio" value="' . $res4['fechaOficio'] . '" required></div>
						<div class="cd-form-group"><label class="cd-form-label"><i class="fa-solid fa-hashtag" style="color:var(--cd-gold-dark);"></i> No. Oficio / Ref.</label><input class="cd-form-control" id="ofnumero" name="ofnumero" value="' . htmlspecialchars($res4['oficioNumero']) . '"/></div>
					</div>';

										echo '<div class="cd-form-grid-3">
						<div class="cd-form-group"><label class="cd-form-label"><i class="fa-solid fa-user"></i> Remite</label><input class="cd-form-control" id="remite" name="remite" value="' . htmlspecialchars($res4['remite']) . '"></div>
						<div class="cd-form-group"><label class="cd-form-label"><i class="fa-solid fa-id-card"></i> Puesto</label><input class="cd-form-control" id="puesto" name="puesto" value="' . htmlspecialchars($res4['puesto']) . '"></div>
						<div class="cd-form-group"><label class="cd-form-label"><i class="fa-solid fa-building"></i> Dependencia</label><input class="cd-form-control" id="dependencia" name="dependencia" value="' . htmlspecialchars($res4['dependencia']) . '"></div>
					</div>';

										echo '<div class="cd-form-grid">
						<div class="cd-form-group"><label class="cd-form-label"><i class="fa-solid fa-pen-nib" style="color:var(--cd-primary);"></i> *Asunto Principal</label><input class="cd-form-control" name="asunto" value="' . htmlspecialchars($res4['asunto']) . '" required></div>
						<div class="cd-form-group"><label class="cd-form-label"><i class="fa-solid fa-align-left"></i> Descripción Extendida</label><textarea class="cd-form-control" style="height:42px; min-height:42px; resize:vertical;" name="descripcion">' . htmlspecialchars($res4['descripcion']) . '</textarea></div>
					</div>';

										echo '<div style="margin-top:10px; display:flex; justify-content:space-between; align-items:center; border-top:1px solid var(--cd-border); padding-top:10px;">';
										if ($res4['fecha_termino'] != '0000-00-00') {
											echo '<label class="cd-form-label" style="margin:0;"><input type="checkbox" id="fechaTer' . $ra['id'] . '" name="fechaTer' . $ra['id'] . '" value="fechaTer' . $ra['id'] . '" onClick="quitarFechaTermino(' . $ra['id'] . ')" checked> Fecha término</label>';
											echo "<div id='divfechaTermino" . $ra['id'] . "' class='cd-form-group' style='margin:0;'><input type='date' class='cd-form-control' id='fechaTermino" . $ra['id'] . "' name='fechaTermino' value='" . $res4['fecha_termino'] . "'></div>";
										} else {
											echo '<label class="cd-form-label" style="margin:0;"><input type="checkbox" id="fechaTer' . $ra['id'] . '" name="fechaTer' . $ra['id'] . '" value="fechaTer' . $ra['id'] . '" onClick="mostrarFechaTerminoModal(' . $ra['id'] . ')"> Fecha término</label>';
											echo "<div id='divfechaTermino" . $ra['id'] . "' class='cd-form-group' style='display:none; margin:0;'><input type='date' class='cd-form-control' id='fechaTermino' name='fechaTermino'></div>";
										}
										echo '<button type="submit" class="cd-btn cd-btn-primary" style="margin-left:auto;"><i class="fa-solid fa-floppy-disk"></i> Guardar Cambios</button>';
										echo '</div>';
										echo "</form></div>";

										echo "</td>"; // Fin celda de asunto/detalles
						
										// Actions
										echo "<td style='text-align:center;'><div class='cd-action-group'>";
										echo "<form action='cp_nuevos_oficios.php' method='GET' style='margin:0; display:inline;'><input type='hidden' value='" . $ra['id'] . "' name='id'><input type='hidden' name='txtplus' value='1'><input type='hidden' name='pv' value='1'><button type='submit' class='cd-icon-btn view' title='Ver Historial del Caso'><i class='fa-solid fa-eye'></i></button></form>";
										if ($ra['nitavuCaptura'] == $nitavu) {
											echo "<form action='cp_controldocumental.php' method='POST' style='margin:0; display:inline;'><input type='hidden' value='" . $ra['id'] . "' id='darBaja' name='darBaja'><button type='submit' class='cd-icon-btn delete' title='Eliminar Caso'><i class='fa-solid fa-trash-can'></i></button></form>";
											echo "<a href='#modalEditarCaso" . $ra['id'] . "' rel='MyModal:open' class='cd-icon-btn edit' title='Modificar información'><i class='fa-solid fa-pen-to-square'></i></a>";
										}
										echo "</div></td>";

										// VoBo y Actividad (titulares)
										if (soytitular($nitavu) != 'FALSE') {
											if ($fech == "" && $vo == "") {
												echo "<td style='text-align:center;'><form action='cp_controldocumental.php' method='GET' style='margin:0;'><input type='hidden' value='" . $ra['id'] . "' name='vobo1'><button type='submit' class='cd-icon-btn check' title='Dar Visto Bueno'><i class='fa-solid fa-circle-check'></i></button></form></td>";
											} else {
												echo "<td style='text-align:center;'><span class='cd-badge cd-badge-success'><i class='fa-solid fa-circle-check'></i></span></td>";
											}
											echo "<td style='text-align:center;'><span class='cd-badge cd-badge-info'>" . actividaddelCaso($ra['id']) . "</span></td>";
										}
										echo "</tr>";
									} // fin while
									?>
								</tbody>
							</table>
						</div>
					</div>
				</div>
				<?php
			} // fin count_proc_rows
		} // fin titular / nivel 1 check
		echo "</div>";

		//---------------------------------------------------
		//DIV DE CASOS EN LOS QUE SOY COLABORADOR	
		$dpto = nitavu_dpto($nitavu);
		$query = "SELECT 
		cp_nuevosdocumentos.id,cp_nuevosdocumentos.fechaoficio,cp_nuevosdocumentos.fecha,cp_nuevosdocumentos.oficionumero,cp_nuevosdocumentos.asunto,cp_nuevosdocumentos.descripcion, cp_nuevosdocumentos.idDptoCrea
		 FROM cp_nuevosdocumentos inner join cp_colaboradores on cp_colaboradores.numcaso=cp_nuevosdocumentos.id WHERE
		 cp_nuevosdocumentos.estado=0 and cp_nuevosdocumentos.baja=0 and cp_colaboradores.activo=0 and cp_colaboradores.nitavu=" . $nitavu . " ORDER BY id DESC";

		$rc = $conexion->query($query);
		if ($rc->num_rows > 0) {
			?>
			<div class="cd-card-section">
				<div class="cd-card-header cd-card-header-gold">
					<h3 class="cd-card-title">
						<i class="fa-solid fa-handshake" style="color:var(--cd-gold-dark);"></i> Mis Colaboraciones
					</h3>
					<span class="cd-badge cd-badge-warning"><?php echo $rc->num_rows; ?> Casos</span>
				</div>
				<div class="cd-card-body" style="padding:0;">
					<div class="cd-table-container">
						<table class="cd-table">
							<thead>
								<tr>
									<th style="width: 75px; text-align: center;">ID</th>
									<th style="width: 130px;">Fecha</th>
									<th>Asunto & Descripción</th>
									<th style="width: 90px; text-align: center;">Acciones</th>
								</tr>
							</thead>
							<tbody>
								<?php
								while ($r = $rc->fetch_array()) {
									echo "<tr>";
									echo "<td style='text-align: center;'><span class='cd-badge-id'>" . $r['id'] . "</span></td>";
									echo "<td><span style='font-weight:600; color:var(--cd-dark);'>" . fecha_corta($r['fecha']) . "</span></td>";
									echo "<td><div><b style='color:var(--cd-primary); text-transform: uppercase;'>" . mb_strtoupper(htmlspecialchars($r['asunto']), 'UTF-8') . "</b><br><span style='font-size:0.82rem; color:var(--cd-gray-dark);'>" . htmlspecialchars($r['descripcion']) . "</span><br>";
									echo "<span style='font-size:0.78rem; color:var(--cd-gray-mid);'><i class='fa-solid fa-building-user'></i> Creado por: " . nombreDepartamento($r['idDptoCrea']) . "</span></div></td>";
									echo "<td style='text-align:center;'><form action='cp_nuevos_oficios.php' method='GET' style='margin:0;'><input type='hidden' value='" . $r['id'] . "' name='id'><input type='hidden' name='txtplus' value='1'><input type='hidden' name='pv' value='1'><button type='submit' class='cd-icon-btn view' title='Ver Historial del Caso'><i class='fa-solid fa-eye'></i></button></form></td>";
									echo "</tr>";
								}
								?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
			<?php
		}

		// SECCION DE ANALITICA Y GRAFICAS GOOGLE
		?>
		<div class="cd-analytics-grid">
			<div class="cd-analytics-card">
				<h4><i class="fa-solid fa-chart-pie" style="color:var(--cd-primary);"></i> Actividad de Colaboración</h4>
				<div id="GraficaColaboradores6" style="width:100%; height:230px;"></div>
			</div>

			<div class="cd-analytics-card">
				<h4><i class="fa-solid fa-chart-pie" style="color:var(--cd-gold-dark);"></i> Días de Atraso en el
					Departamento</h4>
				<div id="GraficaColaboradores2" style="width:100%; height:230px;"></div>
			</div>

			<div class="cd-analytics-card">
				<h4><i class="fa-solid fa-chart-column" style="color:var(--cd-primary);"></i> Casos Abiertos por Departamento</h4>
				<div id="GraficaColaboradores3" style="width:100%; height:230px;"></div>
			</div>
		</div>

		<?php
		// Script de carga de gráficas
		$sql = "SELECT * from ticketcolaboradores WHERE IdDpto=" . nitavu_dpto($nitavu);
		$r6 = $conexion->query($sql);
		$data6 = "";
		while ($f6 = $r6->fetch_array()) {
			$data6 .= "['" . $f6['Nombre'] . "'," . $f6['CasosActivos'] . "],";
		}
		$data6 = rtrim($data6, ",");

		$sql2 = "SELECT fecha as FechaDesde, (SELECT DATEDIFF(CURDATE(),FechaDesde)) as Retraso, id, asunto FROM cp_nuevosdocumentos WHERE estado = 0 AND baja = 0 AND turnadoa = " . nitavu_dpto($nitavu) . " order by fecha DESC";
		$r2 = $conexion->query($sql2);
		$data2 = "";
		while ($f2 = $r2->fetch_array()) {
			$data2 .= "['ID: " . $f2['id'] . "'," . $f2['Retraso'] . "],";
		}
		$data2 = rtrim($data2, ",");

		$sql3 = "SELECT DISTINCT idDptoCrea, (select nombre from cat_gerarquia where id = a.IdDptoCrea) as Departamento, (select count(*) from cp_nuevosdocumentos WHERE turnadoa=" . nitavu_dpto($nitavu) . " and estado=0 and baja = 0 and idDptoCrea = a.idDptoCrea) as Casos FROM cp_nuevosdocumentos a WHERE turnadoa =" . nitavu_dpto($nitavu) . " AND estado = 0 AND baja = 0";
		$r3 = $conexion->query($sql3);
		$data3 = "";
		while ($f3 = $r3->fetch_array()) {
			$data3 .= "['" . $f3['Departamento'] . "'," . $f3['Casos'] . "],";
		}
		$data3 = rtrim($data3, ",");
		?>

		<script>
			if (typeof google !== 'undefined' && google.charts) {
				google.charts.load('current', { 'packages': ['corechart'] });
				google.charts.setOnLoadCallback(drawChartsCD);
			}

			function drawChartsCD() {
				var el1 = document.getElementById('GraficaColaboradores6');
				if (el1 && typeof google !== 'undefined' && google.visualization) {
					var data1 = google.visualization.arrayToDataTable([['Colaborador', 'Casos Activos'], <?php echo $data6 ? $data6 : "['Sin datos', 0]"; ?>]);
					var options1 = { pieHole: 0.4, chartArea: { width: '90%', height: '80%' }, legend: { position: 'bottom', textStyle: { fontSize: 10 } } };
					var chart1 = new google.visualization.PieChart(el1);
					chart1.draw(data1, options1);
				}

				var el2 = document.getElementById('GraficaColaboradores2');
				if (el2 && typeof google !== 'undefined' && google.visualization) {
					var data2 = google.visualization.arrayToDataTable([['Caso', 'Días Atraso'], <?php echo $data2 ? $data2 : "['Sin atrasos', 0]"; ?>]);
					var options2 = { pieHole: 0.4, colors: ['#dc2626', '#d97706', '#bc955c', '#990000'], chartArea: { width: '90%', height: '80%' }, legend: { position: 'bottom', textStyle: { fontSize: 10 } } };
					var chart2 = new google.visualization.PieChart(el2);
					chart2.draw(data2, options2);
				}

				var el3 = document.getElementById('GraficaColaboradores3');
				if (el3 && typeof google !== 'undefined' && google.visualization) {
					var data3 = google.visualization.arrayToDataTable([['Departamento', 'Casos'], <?php echo $data3 ? $data3 : "['Sin casos', 0]"; ?>]);
					var options3 = { chartArea: { width: '85%', height: '75%' }, hAxis: { textStyle: { fontSize: 9 } }, vAxis: { minValue: 0 }, legend: { position: 'none' } };
					var chart3 = new google.visualization.ColumnChart(el3);
					chart3.draw(data3, options3);
				}
			}
		</script>

		<div class="cd-suggestion-box">
			<p><strong><i class="fa-solid fa-lightbulb"></i> Recomendación Institucional:</strong> Se le sugiere fundamentar
				adecuadamente cada caso anexando la documentación de respaldo. Esto agilizará la atención y resolución por
				parte del departamento responsable.</p>
		</div>

		<div id="documentoNew" class="MyModal">
			<h3 style="margin-bottom:14px;"><i class="fa-solid fa-file-circle-plus"></i> Registrar y Turnar Nuevo Caso /
				Oficio</h3>
			<form action="cp_controldocumental.php" method="POST" enctype="multipart/form-data">

				<!-- Fila 1: Fechas y Referencia (3 Columnas) -->
				<div class="cd-form-grid-3">
					<div class="cd-form-group">
						<label class="cd-form-label"><i class="fa-regular fa-calendar"
								style="color:var(--cd-gray-mid);"></i> Fecha Registro</label>
						<input type="date" id="fecha" name="fecha" value="<?php echo $fecha; ?>" class="cd-form-control"
							style="background:#f1f5f9;" required readonly>
					</div>
					<div class="cd-form-group">
						<label class="cd-form-label"><i class="fa-solid fa-calendar-day"
								style="color:var(--cd-primary);"></i> *Fecha del Oficio</label>
						<input type="date" id="fechaOficio" name="fechaOficio" class="cd-form-control" required>
					</div>
					<div class="cd-form-group">
						<label class="cd-form-label"><i class="fa-solid fa-hashtag" style="color:var(--cd-gold-dark);"></i>
							No. Oficio / Ref.</label>
						<input id="ofnumero" name="ofnumero" class="cd-form-control" placeholder="Ej. DG/DI/123/2026">
					</div>
				</div>

				<!-- Fila 2: Datos de Origen y Remitente (3 Columnas) -->
				<div class="cd-form-grid-3">
					<div class="cd-form-group">
						<label class="cd-form-label"><i class="fa-solid fa-user" style="color:var(--cd-gray-dark);"></i>
							Remite (Persona)</label>
						<input id="remite" name="remite" class="cd-form-control" placeholder="Nombre de quien envía...">
					</div>
					<div class="cd-form-group">
						<label class="cd-form-label"><i class="fa-solid fa-id-card" style="color:var(--cd-gray-dark);"></i>
							Puesto</label>
						<input id="puesto" name="puesto" class="cd-form-control" placeholder="Cargo o puesto...">
					</div>
					<div class="cd-form-group">
						<label class="cd-form-label"><i class="fa-solid fa-building" style="color:var(--cd-gray-dark);"></i>
							Dependencia</label>
						<input id="dependencia" name="dependencia" class="cd-form-control"
							placeholder="Dirección / Institución...">
					</div>
				</div>

				<!-- Fila 3: Asunto y Departamento Destino (2 Columnas - Lo más importante) -->
				<div class="cd-form-grid">
					<div class="cd-form-group">
						<label class="cd-form-label"><i class="fa-solid fa-pen-nib" style="color:var(--cd-primary);"></i>
							*Asunto Principal</label>
						<input name="asunto" class="cd-form-control" placeholder="Resumen breve del caso..." required>
					</div>
					<div class="cd-form-group">
						<label class="cd-form-label"><i class="fa-solid fa-share-nodes"
								style="color:var(--cd-primary);"></i> *Turnar a Departamento:</label>
						<select name="departamento" id="departamento" class="cd-form-select" required>
							<option value="0" selected="selected">Seleccione departamento destino...</option>
							<option value="100">Fuera del Instituto</option>
							<?php
							$sql = "SELECT cat_gerarquia.id, cat_gerarquia.nombre FROM cat_gerarquia ORDER BY cat_gerarquia.nombre";
							$rDptos = $conexion->query($sql);
							while ($f = $rDptos->fetch_array()) {
								echo "<option value='" . $f['id'] . "'>" . htmlspecialchars($f['nombre']) . "</option>";
							}
							?>
						</select>
					</div>
				</div>

				<!-- Fila 4: Descripción y Archivo PDF Adjunto (2 Columnas) -->
				<div class="cd-form-grid">
					<div class="cd-form-group">
						<label class="cd-form-label"><i class="fa-solid fa-align-left"
								style="color:var(--cd-gray-dark);"></i> Descripción Extendida</label>
						<textarea name="descripcion" class="cd-form-control"
							style="height:42px; min-height:42px; resize:vertical;"
							placeholder="Detalles adicionales o antecedentes del asunto..."></textarea>
					</div>
					<div class="cd-form-group">
						<label class="cd-form-label"><i class="fa-solid fa-file-pdf" style="color:#dc2626;"></i> Archivo PDF
							Adjunto</label>
						<input id="myFile" name="myFile" type="file" accept=".pdf" class="cd-form-control"
							style="padding:6px 10px; height:42px;">
					</div>
				</div>

				<!-- Opcional Fecha término y Botón Guardar -->
				<div style="margin-top:16px; display:flex; justify-content:space-between; align-items:center; border-top:1px solid #cbd5e1; padding-top:14px; width:100%;">
					<div id="divfechaTermino" style="display:none; align-items:center; gap:8px;">
						<label class="cd-form-label" style="margin:0;"><i class="fa-solid fa-calendar-check"
								style="color:#16a34a;"></i> Fecha término:</label>
						<input type="date" id="fechaTermino" name="fechaTermino" class="cd-form-control"
							style="width:160px; height:36px;">
					</div>
					<div style="margin-left:auto; display:flex; gap:12px; align-items:center;">
						<input type="hidden" name="turnar" value="turnar">
						<button type="submit" class="cd-btn cd-btn-primary" style="padding:10px 26px; font-size:0.95rem; font-weight:600; white-space:nowrap;">
							<i class="fa-solid fa-paper-plane"></i> Registrar y Turnar
						</button>
					</div>
				</div>
			</form>
		</div>
		<?php
		//Cuando se registra un nuevo caso
	
		if (isset($_POST['departamento']) && isset($_POST['turnar'])) {


			if (empty($_POST['departamento'])) {
				mensaje('Debe Seleccionar un departamento', 'cp_controldocumental.php');
			} else {

				if (isset($_POST['ofnumero']) and isset($_POST['asunto']) and isset($_POST['descripcion'])) {
					//SI EXISTE UN DEPARTAMENTO AL CUAL TURNAR
					if (!empty($_FILES['myFile']['name']) != null) {
						//$prioridad = $_POST['prioridad'];
						$fechaOficio = $_POST['fechaOficio'];
						$fecha = $_POST['fecha'];
						if (isset($_POST['fechaTermino']) && $_POST['fechaTermino'] !== '') {
							$fechaTermino = $_POST['fechaTermino'];
						} else {
							$fechaTermino = '';
						}
						$fechaTerminoSql = ($fechaTermino !== '') ? "'" . $fechaTermino . "'" : "'0000-00-00'";
						$ofnumero = $_POST['ofnumero'];
						//$remite = strtoupper($_POST['remite']);
						$remite = $_POST['remite'];
						$puesto = $_POST['puesto'];
						$dependencia = $_POST['dependencia'];
						$asunto = $_POST['asunto'];
						//$descripcion = strtoupper($_POST['descripcion']);
						$descripcion = $_POST['descripcion'];
						$myFile = $_FILES['myFile']['name'];
						$temp = $_FILES['myFile']['tmp_name'];
						$dpto = nitavu_dpto($nitavu);
						$dptoTurnar = $_POST['departamento'];
						$idDocumento = idDocumento(TRUE);
						$numDocumento = numdeDocumento(TRUE);
						$archivo = "peticiones/" . $numDocumento . '_' . $idDocumento . '_' . $myFile . "";
						$subida = FTP_subir($temp, $archivo);
						//$empleadoseturna=$_POST['empleadoseturna'];
						if ($subida == "TRUE") {
							$sql = "INSERT INTO cp_nuevosdocumentos(idauto, id, fechaoficio, fecha, oficionumero, remite, puesto, dependencia,asunto, descripcion, nitavucaptura, iddptocrea,turnadoa,estado,baja, vobo, fecha_termino) 
						VALUES (NULL, '$idDocumento','$fechaOficio', '$fecha', '$ofnumero', '$remite', '$puesto', '$dependencia','$asunto','$descripcion','$nitavu','$dpto','$dptoTurnar',0,0,'',$fechaTerminoSql)";
							if ($conexion->query($sql) == TRUE) {
								if ($ofnumero == numeroOficioPublico(TRUE)) {
									numeroOficioPublico(FALSE);
								}
								idDocumento(FALSE);
								$sql2 = "INSERT INTO cp_historialdocumentos(idinc, iddoc, numcaso, archivo, fecha, nitavusube, dptosube, dptoenviar, numoficio, activo, tipo,hora) 
							VALUES (NULL, '$numDocumento', '$idDocumento', '$myFile', '$fecha', '$nitavu', '$dpto','$dptoTurnar','$ofnumero',0,0,'$hora')";
								if ($conexion->query($sql2) == TRUE) {
									numdeDocumento(FALSE);
									historia($nitavu, 'cp_Agregó un nuevo caso llamado: ' . $ofnumero . ' con Id: ' . $idDocumento);
									historia($nitavu, 'cp_Agregó un nuevo caso  Id: ' . $idDocumento . ' Archivo: ' . $myFile);

									mensaje('1.Se ha registrado con éxito el nuevo documento.' . $idDocumento, 'cp_controldocumental.php');
									//agregarSeguimiento($idDocumento, $ofnumero, $numDocumento, $dpto, $fecha);
								} else {
									mensaje('Ocurrio un error al momento de guardar la información. Por favor vuelva a intentarlo.', 'cp_controldocumental.php');
								}
							} else {
								mensaje('Ocurrio un error al momento de guardar la información. Por favor vuelva a intentarlo.', 'cp_controldocumental.php');
							}
						} else {
							mensaje('No ha seleccionado ningun archivo.', 'cp_controldocumental.php');
						}
					} else {
						//$prioridad = $_POST['prioridad'];
						$fechaOficio = $_POST['fechaOficio'];
						$fecha = $_POST['fecha'];
						if (isset($_POST['fechaTermino']) && $_POST['fechaTermino'] !== '') {
							$fechaTermino = $_POST['fechaTermino'];
						} else {
							$fechaTermino = '';
						}
						$fechaTerminoSql = ($fechaTermino !== '') ? "'" . $fechaTermino . "'" : "'0000-00-00'";
						$ofnumero = $_POST['ofnumero'];
						$remite = $_POST['remite'];
						$puesto = $_POST['puesto'];
						$dependencia = $_POST['dependencia'];
						$asunto = $_POST['asunto'];
						//$descripcion = strtoupper($_POST['descripcion']);
						$descripcion = $_POST['descripcion'];
						$myFile = $_FILES['myFile']['name'];
						$dpto = nitavu_dpto($nitavu);
						$dptoTurnar = $_POST['departamento'];
						$idDocumento = idDocumento(TRUE);
						$numDocumento = numdeDocumento(TRUE);
						//$empleadoseturna=$_POST['empleadoseturna'];
						$sql = "INSERT INTO cp_nuevosdocumentos(idauto, id, fechaoficio, fecha, oficionumero, remite, puesto, dependencia,asunto, descripcion, nitavucaptura, iddptocrea, turnadoa, estado, baja, vobo, fecha_termino) 
						VALUES (NULL, '$idDocumento','$fechaOficio', '$fecha', '$ofnumero', '$remite', '$puesto', '$dependencia',
						'$asunto','$descripcion','$nitavu','$dpto','$dptoTurnar',0,0,'',$fechaTerminoSql)";

						if ($conexion->query($sql) == TRUE) {
							// if($ofnumero==numeroOficioPublico(TRUE)){
							// 	numeroOficioPublico(FALSE);
							// }
							idDocumento(FALSE);
							$sql2 = "INSERT INTO cp_historialdocumentos(idinc, iddoc, numcaso, archivo, fecha, nitavusube, dptosube, dptoenviar, numoficio, activo, tipo,hora) 
							VALUES (NULL, '$numDocumento', '$idDocumento', '$myFile', '$fecha', '$nitavu', '$dpto','$dptoTurnar','$ofnumero',0,0,'$hora')";
							if ($conexion->query($sql2) == TRUE) {
								numdeDocumento(FALSE);
								historia($nitavu, 'cp_Agregó un nuevo caso llamado: ' . $ofnumero . ' con Id: ' . $idDocumento . 'Archivo: ' . $myFile);
								mensaje('2.Se ha registrado con éxito el nuevo documento. ' . $idDocumento, 'cp_controldocumental.php');
								//agregarSeguimiento($idDocumento, $ofnumero, $numDocumento, $dpto, $fecha);
							} else {
								mensaje('Ocurrio un error al momento de guardar la información. Por favor vuelva a intentarlo.', 'cp_controldocumental.php');
							}
						} else {
							mensaje('Ocurrio un error al momento de guardar la información. Por favor vuelva a intentarlo.', 'cp_controldocumental.php');
						}
					}
				}
			}
		} else {


			if (isset($_POST['ofnumero']) and isset($_POST['asunto']) and isset($_POST['descripcion']) and !isset($_GET['editar'])) {
				if (!empty($_FILES['myFile']['name']) != null) {

					//$prioridad = $_POST['prioridad'];
					$fechaOficio = $_POST['fechaOficio'];
					$fecha = $_POST['fecha'];
					if (isset($_POST['fechaTermino']) && $_POST['fechaTermino'] !== '') {
						$fechaTermino = $_POST['fechaTermino'];
					} else {
						$fechaTermino = '';
					}
					$fechaTerminoSql = ($fechaTermino !== '') ? "'" . $fechaTermino . "'" : "'0000-00-00'";
					$ofnumero = $_POST['ofnumero'];
					$remite = $_POST['remite'];
					$puesto = $_POST['puesto'];
					$dependencia = $_POST['dependencia'];
					$asunto = $_POST['asunto'];
					//$descripcion = strtoupper($_POST['descripcion']);
					$descripcion = $_POST['descripcion'];
					$myFile = $_FILES['myFile']['name'];
					$temp = $_FILES['myFile']['tmp_name'];
					$dpto = nitavu_dpto($nitavu);
					$idDocumento = idDocumento(TRUE);
					$numDocumento = numdeDocumento(TRUE);
					$archivo = "peticiones/" . $numDocumento . '_' . $idDocumento . '_' . $myFile . "";
					$subida = FTP_subir($temp, $archivo);
					$dptoTurnar = $_POST['departamento'];
					//$empleadoseturna=$_POST['empleadoseturna'];
					if ($subida == "TRUE") {
						$sql = "INSERT INTO cp_nuevosdocumentos(idauto, id, fechaoficio, fecha, oficionumero, remite, puesto, dependencia,asunto, descripcion, nitavucaptura, iddptocrea,turnadoa,estado,baja, vobo, fecha_termino) 
					VALUES (NULL, '$idDocumento','$fechaOficio', '$fecha', '$ofnumero', '$remite', '$puesto', '$dependencia','$asunto','$descripcion','$nitavu','$dpto','$dptoTurnar',0,0,'',$fechaTerminoSql)";
						if ($conexion->query($sql) == TRUE) {
							if ($ofnumero == numeroOficioPublico(TRUE)) {
								numeroOficioPublico(FALSE);
							}
							idDocumento(FALSE);
							$sql2 = "INSERT INTO cp_historialdocumentos(idinc, iddoc, numcaso, archivo, fecha, nitavusube, dptosube, dptoenviar, numoficio, activo, tipo,hora) 
						VALUES (NULL, '$numDocumento', '$idDocumento', '$myFile', '$fecha', '$nitavu', '$dpto','$dptoTurnar','$ofnumero',0,0,'$hora')";
							if ($conexion->query($sql2) == TRUE) {
								numdeDocumento(FALSE);
								historia($nitavu, 'cp_Agregó un nuevo caso llamado: ' . $ofnumero . ' con Id: ' . $idDocumento);
								historia($nitavu, 'cp_Agregó un nuevo caso  Id: ' . $idDocumento . ' Archivo: ' . $myFile);

								mensaje('3.Se ha registrado con éxito el nuevo documento. ' . $idDocumento, 'cp_controldocumental.php');
								//agregarSeguimiento($idDocumento, $ofnumero, $numDocumento, $dpto, $fecha);
							} else {
								mensaje('Ocurrio un error al momento de guardar la información. Por favor vuelva a intentarlo.', 'cp_controldocumental.php');
							}
						} else {
							mensaje('Ocurrio un error al momento de guardar la información. Por favor vuelva a intentarlo.', 'cp_controldocumental.php');
						}
					} else {
						mensaje('No ha seleccionado ningun archivo.', 'cp_controldocumental.php');
					}
				} else {
					//$prioridad = $_POST['prioridad'];
					$fechaOficio = $_POST['fechaOficio'];
					$fecha = $_POST['fecha'];
					// !empty() verifica que la variable exista y que tenga un valor real (no vacío)
					if (isset($_POST['fechaTermino']) && $_POST['fechaTermino'] !== '') {
						$fechaTermino = $_POST['fechaTermino'];
					} else {
						$fechaTermino = '';
					}
					$fechaTerminoSql = ($fechaTermino !== '') ? "'" . $fechaTermino . "'" : "'0000-00-00'";
					$ofnumero = $_POST['ofnumero'];
					$remite = $_POST['remite'];
					$puesto = $_POST['puesto'];
					$dependencia = $_POST['dependencia'];
					$asunto = $_POST['asunto'];
					//$descripcion = strtoupper($_POST['descripcion']);
					$descripcion = $_POST['descripcion'];
					$myFile = $_FILES['myFile']['name'];
					$dpto = nitavu_dpto($nitavu);
					$idDocumento = idDocumento(TRUE);
					$numDocumento = numdeDocumento(TRUE);
					$dptoTurnar = $_POST['departamento'];
					//$empleadoseturna= $_POST['empleadoseturna'];
					$sql = "INSERT INTO cp_nuevosdocumentos(idauto, id, fechaoficio, fecha, oficionumero, remite, puesto, dependencia,asunto, descripcion, nitavucaptura, iddptocrea, turnadoa, estado, baja, vobo, fecha_termino) 
					VALUES (NULL, '$idDocumento','$fechaOficio', '$fecha', '$ofnumero', '$remite', '$puesto', '$dependencia',
					'$asunto','$descripcion','$nitavu','$dpto','$dptoTurnar',0,0,'',$fechaTerminoSql)";
					if ($conexion->query($sql) == TRUE) {
						/*if($ofnumero==numeroOficioPublico(TRUE)){
							numeroOficioPublico(FALSE);
						}*/
						idDocumento(FALSE);
						$sql2 = "INSERT INTO cp_historialdocumentos(idinc, iddoc, numcaso, archivo, fecha, nitavusube, dptosube, dptoenviar, numoficio, activo, tipo,hora) 
						VALUES (NULL, '$numDocumento', '$idDocumento', '$myFile', '$fecha', '$nitavu', '$dpto','$dptoTurnar','$ofnumero',0,0,'$hora')";
						if ($conexion->query($sql2) == TRUE) {
							numdeDocumento(FALSE);
							historia($nitavu, 'cp_Agregó un nuevo caso llamado: ' . $ofnumero . ' con Id: ' . $idDocumento . 'Archivo: ' . $myFile);
							mensaje('4. Se ha registrado con éxito el nuevo documento. ' . $idDocumento, 'cp_controldocumental.php');
							//agregarSeguimiento($idDocumento, $ofnumero, $numDocumento, $dpto, $fecha);
						} else {
							mensaje('Ocurrio un error al momento de guardar la información. Por favor vuelva a intentarlo.' . $sql2, 'cp_controldocumental.php');
						}
					} else {
						mensaje('Ocurrio un error al momento de guardar la información. Por favor vuelva a intentarlo.', 'cp_controldocumental.php');
					}
				}
			}
		}



		//Si le han dado clic a Visto Bueno
		if (isset($_GET['vobo1'])) {
			$num = $_GET['vobo1'];
			if (actualizarVistoBueno($num, $nitavu) == TRUE) {
				mensaje('Esta petición se ha marcado con Visto Bueno.', 'cp_controldocumental.php');
			} else {
				mensaje('Ocurrio un error, por favor intentelo nuevamente.', 'cp_controldocumental.php');
			}
		}
		if (isset($_GET['vobo2'])) {
			$num = $_GET['vobo2'];
			if (actualizarVistoBueno($num, $nitavu) == TRUE) {
				mensaje('Esta petición se ha marcado con Visto Bueno.', 'cp_controldocumental.php');
			} else {
				mensaje('Ocurrio un error, por favor intentelo nuevamente.', 'cp_controldocumental.php');
			}
		}
		if (isset($_GET['vobo3'])) {
			$num = $_GET['vobo3'];
			if (actualizarVistoBueno($num, $nitavu) == TRUE) {
				mensaje('Esta petición se ha marcado con Visto Bueno.', 'cp_controldocumental.php');
			} else {
				mensaje('Ocurrio un error, por favor intentelo nuevamente.', 'cp_controldocumental.php');
			}
		}
		//MODAL DE DOCUMENTOS RECIENTES
//--------------------------------------------------------- 
		// MODAL DE DOCUMENTOS RECIENTES
		echo "<div id='docuementosRecientes' class='MyModal'>";
		echo "<h3><i class='fa-solid fa-folder-open'></i> Lista de Documentos Recientes</h3>";
		echo "<div class='cd-table-container' style='max-height:300px; overflow-y:auto; margin-bottom:20px;'>";
		echo "<table class='cd-table'>";
		echo "<thead><tr>";
		echo "<th>No. Oficio & Destinatario</th>";
		echo "<th>Asunto</th>";
		echo "<th>Creado por</th>";
		echo "<th style='text-align:center;'>Acciones</th>";
		echo "</tr></thead><tbody>";

		$sql = " -- cp
	select cc.Numero,cc.Destinatario, IFNULL(cg.nombre,'Fuera del Instituto') as departamento,cc.Asunto,cc.Observaciones,cc.Autorizado,cc.FechaCrea, ct.TipoDocumento, cc.Id,cc.IdDptoCrea ,cgg.nombre as dptocrea,cc.NumDocumento
	,case WHEN  cc.NitavuCrea=" . $nitavu . " then 1 ELSE 0 END   AS 	cancelar
	,empleados.nombre
	from cp_controlcorrespondencia as cc left join cat_gerarquia as cg on cc.IdDptoEnvia=cg.id 
	inner join cat_gerarquia as cgg on cgg.id=cc.IdDptoCrea  
	inner join cat_tipo_documento as ct on 
	ct.IdTipoDocumento=cc.IdTipoDocumento
	inner join empleados on empleados.nitavu=cc.NitavuCrea
	where (cc.Utilizado=0 )	 and cc.IdDptoCrea= " . nitavu_dpto($nitavu) . " order by cc.Id desc ";

		$rc = $conexion->query($sql);
		while ($co = $rc->fetch_array()) {
			echo "<tr>";
			echo "<form action='cp_acciones_bd.php' method='POST'>";
			echo "<input type='hidden' name='IdControl' value='" . $co['Id'] . "'>";
			echo "<input type='hidden' name='IdDptoCrea' value='" . $co['IdDptoCrea'] . "'>";

			echo "<td><b style='color:var(--cd-dark);'>" . htmlspecialchars($co['NumDocumento']) . "</b><br>";
			echo "<span style='font-size:0.8rem; color:var(--cd-gray-dark);'>" . htmlspecialchars($co['departamento']) . "</span><br>";
			echo "<span style='font-size:0.75rem; color:var(--cd-gray-mid);'><i class='fa-regular fa-calendar-days'></i> " . date_format(date_create($co['FechaCrea']), 'd/m/Y') . "</span></td>";

			echo "<td><span style='font-size:0.85rem; color:var(--cd-dark);'>" . htmlspecialchars($co['Asunto']) . "</span></td>";

			echo "<td><b style='font-size:0.82rem; color:var(--cd-dark);'>" . htmlspecialchars($co['dptocrea']) . "</b><br>";
			echo "<span style='font-size:0.78rem; color:var(--cd-gray-dark);'>" . htmlspecialchars($co['nombre']) . "</span></td>";

			echo "<td style='text-align:center;'>";
			if ($co['cancelar'] == 1 && $co['Autorizado'] != "0") {
				echo "<div class='cd-action-group'>";
				echo "<button type='submit' name='btnCancelar' id='btnCancelar' class='cd-icon-btn delete' title='Cancelar Oficio'><i class='fa-solid fa-xmark'></i></button>";
				echo "<a href='?DocId=" . $co['Id'] . "' title='Indicar que ya se usó este oficio' class='cd-icon-btn check'><i class='fa-solid fa-check-double'></i></a>";
				echo "</div>";
			}
			echo "</td>";
			echo "</form>";
			echo "</tr>";
		}
		echo "</tbody></table></div>";

		echo "<div class='cd-suggestion-box' style='display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:12px;'>";
		echo "<div>";
		echo "<p style='margin:0 0 4px 0;'><strong><i class='fa-brands fa-google-drive' style='color:#1a73e8;'></i> Plantilla de Google Docs:</strong></p>";
		echo "<p style='margin:0; font-size:0.8rem; color:var(--cd-gray-dark);'>El número de oficio tiene un máximo de 5 días de uso. Transcurrido ese tiempo deberá generar uno nuevo.</p>";
		echo "</div>";
		echo "<a href='cp_controldocumental.php?plantilla=" . $nitavu . "' class='cd-btn cd-btn-gold' style='font-size:0.82rem;'><i class='fa-solid fa-file-export'></i> Solicitar Plantilla</a>";
		echo "</div></div>";

		if (isset($_GET['DocId'])) {
			$sql = "UPDATE cp_controlcorrespondencia SET Utilizado='1' WHERE Id='" . $_GET['DocId'] . "'";
			if ($conexion->query($sql) == TRUE) {
				historia($nitavu, "Marco el documento con Id " . $_GET['IdDoc'] . " como utilizado");
				mensaje("Documento marcado como utilizado", 'cp_controldocumental.php');
			} else {
				mensaje("ERROR al intentar marcar el documento como utilizado " . $sql, "cp_controldocumental.php");
			}
		}

		if (isset($_GET['plantilla'])) {
			$informatica = buscarInformatica();
			$empl = explode('/', $informatica);
			for ($i = 0; $i < sizeof($empl); $i++) {
				$msgNoti = 'Buen día. <br> Necesito se me de acceso a la plantilla de oficios a ' . nombreDepartamento(nitavu_dpto($nitavu));
				notificacion_add($empl[$i], 'Solicitud de acceso a plantilla', date('Y-m-d'), $nitavu, $msgNoti);
			}
		}

		// MODAL SOLICITAR NUEVO NÚMERO DE DOCUMENTO
		echo "<div id='myModalaAgregar' class='MyModal'>";
		echo "<h3><i class='fa-solid fa-hashtag'></i> Generar Nuevo Número de Correspondencia</h3>";
		echo "<form action='cp_numNuevoDocumento_db.php' method='POST'>";

		echo "<div class='cd-form-grid'>";
		echo "<div class='cd-form-group'>";
		echo "<label class='cd-form-label'>Tipo de Documento</label>";
		echo "<select name='tipoDocumento' class='cd-form-select' required>";
		echo "<option value='0' selected='selected'>Seleccione tipo...</option>";
		$sql = "select * from cat_tipo_documento";
		$r = $conexion->query($sql);
		while ($f = $r->fetch_array()) {
			echo "<option value='" . $f['IdTipoDocumento'] . "'>" . htmlspecialchars($f['TipoDocumento']) . "</option>";
		}
		echo "</select>";
		echo "</div>";

		echo "<div class='cd-form-group'>";
		echo "<label class='cd-form-label'>Departamento Destino</label>";
		echo "<select name='departamento' id='departamento' class='cd-form-select' required>";
		echo "<option value='0' selected='selected'>Seleccione departamento...</option>";
		echo "<option value='100'>Fuera del Instituto</option>";
		$sql = "SELECT cat_gerarquia.id, cat_gerarquia.titular, cat_gerarquia.nombre, cat_gerarquia.dependencia FROM cat_gerarquia where (id <>" . nitavu_dpto($nitavu) . ") ORDER BY cat_gerarquia.nombre";
		$r = $conexion->query($sql);
		while ($f = $r->fetch_array()) {
			echo "<option value='" . $f['id'] . "'>" . htmlspecialchars($f['nombre']) . "</option>";
		}
		echo "</select>";
		echo "</div>";
		echo "</div>";

		echo "<div id='spanDestinatario' class='cd-form-grid'>";
		echo "<div class='cd-form-group'>";
		echo "<label class='cd-form-label'>Destinatario</label>";
		echo "<input type='text' id='destinatario' name='destinatario' class='cd-form-control' placeholder='A quien va dirigido...' required>";
		echo "</div>";
		echo "<div class='cd-form-group'>";
		echo "<label class='cd-form-label'>Puesto</label>";
		echo "<input type='text' id='puesto' name='puesto' class='cd-form-control' placeholder='Puesto del destinatario...' required>";
		echo "</div>";
		echo "</div>";

		echo "<div class='cd-form-group'>";
		echo "<label class='cd-form-label'>Asunto</label>";
		echo "<input type='text' id='asunto' name='asunto' class='cd-form-control' placeholder='Asunto del documento...' required>";
		echo "</div>";

		echo "<div class='cd-form-group'>";
		echo "<label class='cd-form-label'>Observaciones</label>";
		echo "<textarea name='observaciones' class='cd-form-control' placeholder='Observaciones adicionales...'></textarea>";
		echo "</div>";

		echo "<div style='margin-top:20px; display:flex; justify-content:flex-end;'>";
		echo "<button type='submit' class='cd-btn cd-btn-primary' name='btnSolicitar'><i class='fa-solid fa-paper-plane'></i> Solicitar Número</button>";
		echo "</div>";

		echo "</form>";
		echo "</div>";
		echo "</div>"; // Fin cd-wrapper
} else {
	mensaje("ERROR: no tiene acceso a esta aplicacion", './index.php?home=');
}

include("./lib/body_footer.php");
?>


	<script>
		var id = 0;
		function ModalSolicitar() {
			// Obtenemos el modal 
			modal = document.getElementById("myModalaAgregar");

			//Agregamos al divconetenedor el un input que almacena el Id que seleccionó
			// document.getElementById("contenedor").innerHTML = ["<input type=hidden id=idconcepto   name=idconcepto value="+id+">"]; 

			// Get the <span> element that closes the modal  
			span = document.getElementsByClassName("close")[0];


			//Hacer visible el modal
			modal.style.display = "block";

			// When the user clicks on <span> (x), close the modal
			span.onclick = function () {

				modal.style.display = "none";
			}
		}
		$(document).on("change", "#departamento", function (event) {

			//alert($("#departamento option:selected").val());
			ShowDestinatario($("#departamento option:selected").val());
		});

		function ShowDestinatario(id) {

			if (id == "") {
				document.getElementById("spanDestinatario").innerHTML = "";
				return;
			}
			if (window.XMLHttpRequest) {
				// code for IE7+, Firefox, Chrome, Opera, Safari
				xmlhttp = new XMLHttpRequest();
			} else { // code for IE6, IE5
				xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
			}
			xmlhttp.onreadystatechange = function () {
				if (this.readyState == 4 && this.status == 200) {
					document.getElementById("spanDestinatario").innerHTML = this.responseText;

				}
			}
			xmlhttp.open("GET", "cp_consultaDestinatario.php?id=" + id, true);
			xmlhttp.send();
		}

		function mostrarDepartamento() {
			if (turnar.checked == true) {
				$("#turnarDpto").css({ 'display': 'inline-block', });
			} else {
				$("#turnarDpto").css({ 'display': 'none', });
			}

		}

		function mostrarFechaTermino() {

			if (fechaTer.checked == true) {
				$("#divfechaTermino").css({ 'display': 'inline-block', });
			} else {
				$("#divfechaTermino").css({ 'display': 'none', });
			}

		}

		function mostrarFechaTerminoModal(id) {

			nom = document.getElementById('fechaTer' + id);
			if (nom.checked == true) {
				$("#divfechaTermino" + id).css({ 'display': 'inline-block', });
			} else {
				$("#divfechaTermino" + id).css({ 'display': 'none', });
			}

		}

		function quitarFechaTermino(id) {

			nom = document.getElementById('fechaTer' + id);
			if (nom.checked == true) {

				$("#divfechaTermino" + id).css({ 'display': 'none', });
				document.getElementById("fechaTermino" + id).value = "";

			} else {
				$("#divfechaTermino" + id).css({ 'display': 'inline-block', });
			}


		}

		//***aqui para validar campos */
		function validar_numeros(string) {
			for (var i = 0, output = '', validos = "1234567890"; i < string.length; i++)
				if (validos.indexOf(string.charAt(i)) != -1)
					output += string.charAt(i)
			return output;
		}

	</script>