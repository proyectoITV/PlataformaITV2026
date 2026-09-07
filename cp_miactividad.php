<?php
include("./lib/body_head.php");
include("./lib/body_menu.php");

$idDepartamento = nitavu_dpto($nitavu);
$id_aplicacion = "ap66";
$nivel = aplicacion_nivel($id_aplicacion, $nitavu);

if (sanpedro($id_aplicacion, $nitavu) == TRUE) {
	echo "<div id='AppDetalle'>" . app_detalle($id_aplicacion, $nitavu) . "</div>";

	$pes = isset($_GET['pes']) ? $_GET['pes'] : 'finalizados';
	$mas = isset($_GET['n']) ? "&n=" : "";
	?>

	<div class="cd-wrapper">
		<!-- Hero Header -->
		<div class="cd-hero">
			<div>
				<h1 class="cd-hero-title">
					<i class="fa-solid fa-clock-rotate-left"></i> Historial de Actividad
				</h1>
				<div class="cd-hero-dept">
					<i class="fa-solid fa-building-columns"></i> Departamento:
					<span><?php echo nitavu_dpto_nombre($nitavu); ?></span>
				</div>
			</div>
			<div class="cd-top-links">
				<a href="cp_controldocumental.php" class="cd-top-link-btn">
					<i class="fa-solid fa-arrow-left"></i> Volver a Control Documental
				</a>
			</div>
		</div>

		<!-- Tab Navigation Toolbar -->
		<div class="cd-toolbar-card">
			<div class="cd-toolbar-group">
				<a href="?pes=finalizados<?php echo $mas; ?>" class="cd-btn <?php echo ($pes == 'finalizados') ? 'cd-btn-primary' : 'cd-btn-light'; ?>">
					<i class="fa-solid fa-circle-check"></i> Finalizados
				</a>
				<a href="?pes=creados<?php echo $mas; ?>" class="cd-btn <?php echo ($pes == 'creados') ? 'cd-btn-primary' : 'cd-btn-light'; ?>">
					<i class="fa-solid fa-user-pen"></i> Creados por Mí
				</a>
				<a href="?pes=participe<?php echo $mas; ?>" class="cd-btn <?php echo ($pes == 'participe') ? 'cd-btn-primary' : 'cd-btn-light'; ?>">
					<i class="fa-solid fa-handshake"></i> Participé
				</a>
			</div>
		</div>

		<?php
		// =========================================================================
		// TAB 1: CASOS FINALIZADOS
		// =========================================================================
		if ($pes == 'finalizados') {
			$dpto = nitavu_dpto($nitavu);

			if ($nivel == 1 || soytitular($nitavu) != 'FALSE') {
				$query = "SELECT DISTINCT * FROM cp_nuevosdocumentos 
				WHERE (nitavuCaptura = " . $nitavu . " OR idDptoCrea = " . nitavu_dpto($nitavu) . " OR id IN (SELECT numcaso FROM cp_colaboradores WHERE nitavu=" . $nitavu . ") OR id IN (SELECT NumCaso FROM cp_historialdocumentos WHERE nitavuSube=" . $nitavu . ") OR turnadoa = " . nitavu_dpto($nitavu) . " OR id IN (SELECT CasoId FROM cp_comentarios WHERE Nuser = " . $nitavu . "))
				AND estado = 1 AND YEAR(fecha)>=2023 ORDER BY id DESC";
			} else {
				$query = "SELECT DISTINCT * FROM cp_nuevosdocumentos 
				WHERE (nitavuCaptura = " . $nitavu . " OR id IN (SELECT numcaso FROM cp_colaboradores WHERE nitavu=" . $nitavu . ") OR id IN (SELECT NumCaso FROM cp_historialdocumentos WHERE nitavuSube=" . $nitavu . ") OR id IN (SELECT CasoId FROM cp_comentarios WHERE Nuser = " . $nitavu . "))
				AND estado = 1 AND YEAR(fecha)>=2023 ORDER BY id DESC";
			}

			// Hidden print div
			echo "<div id='imprimir1' style='display:none;'>";
			echo "<h1>Casos Finalizados en los que participé:</h1>";
			echo "<table class='tabla'><tr><th width='20%' COLSPAN='2'>Fecha</th><th width='70%'>Asunto</th></tr>";
			$r_print = $conexion->query($query);
			while ($f_p = $r_print->fetch_array()) {
				echo "<tr><td>" . $f_p['id'] . "</td><td>" . fecha_larga($f_p['fecha']) . "</td><td><b>" . htmlspecialchars($f_p['asunto']) . "</b><br>" . htmlspecialchars($f_p['descripcion']) . "</td></tr>";
			}
			echo "</table></div>";

			$r = $conexion->query($query);
			$r_count = $r ? $r->num_rows : 0;
			?>

			<!-- Filter toolbar card -->
			<div class="cd-search-card" style="margin-bottom:20px;">
				<div class="cd-search-form">
					<div class="cd-search-label">
						<i class="fa-solid fa-filter" style="color:var(--cd-gold-dark);"></i>
						<span>Filtrar por Departamento (Quien los tiene):</span>
					</div>
					<div class="cd-input-group">
						<select id="dptos" name="dptos" class="cd-form-select" onchange="filtroDpto(<?php echo $nitavu; ?>, 1);">
							<option value="1000" selected>Todos los Departamentos</option>
							<?php
							$sqlD = "SELECT * FROM cat_gerarquia ORDER BY nombre";
							$rD = $conexion->query($sqlD);
							while ($fD = $rD->fetch_array()) {
								echo "<option value='" . $fD['id'] . "'>" . htmlspecialchars($fD['nombre']) . "</option>";
							}
							?>
						</select>
						<button type="button" onclick="printDiv(1)" class="cd-btn cd-btn-gold">
							<i class="fa-solid fa-file-pdf"></i> Exportar PDF
						</button>
					</div>
				</div>
			</div>

			<div id="resconsulta" style="width:100%; display:none;"></div>

			<div id="primeraFinalizados" class="cd-card-section">
				<div class="cd-card-header cd-card-header-primary">
					<h3 class="cd-card-title">
						<i class="fa-solid fa-circle-check"></i> Casos Finalizados en los que Participé
					</h3>
					<span class="cd-badge cd-badge-info"><?php echo $r_count; ?> Registros</span>
				</div>
				<div class="cd-card-body" style="padding:0;">
					<?php if ($r_count > 0): 
						$pagina = (isset($_GET["p"]) && is_numeric($_GET["p"])) ? (int)$_GET["p"] : 1;
						$empezar_desde = ($pagina - 1) * $paginacion;
						$query_lim = $query . " LIMIT " . $empezar_desde . ", " . $paginacion;
						$r_lim = $conexion->query($query_lim);
						$paginas = ceil(($r_count / $paginacion));
					?>
						<div class="cd-table-container">
							<table class="cd-table">
								<thead>
									<tr>
										<th style="width:75px; text-align:center;">ID</th>
										<th style="width:140px;">Fecha</th>
										<th>Asunto & Descripción</th>
										<th>Último Colaborador</th>
										<th style="width:90px; text-align:center;">Acciones</th>
									</tr>
								</thead>
								<tbody>
									<?php while ($f = $r_lim->fetch_array()): ?>
										<tr>
											<td style="text-align:center;"><span class="cd-badge-id"><?php echo $f['id']; ?></span></td>
											<td><span style="font-weight:600; color:var(--cd-dark);"><?php echo fecha_corta($f['fecha']); ?></span></td>
											<td>
												<div>
													<b style="color:var(--cd-primary); text-transform:uppercase;"><?php echo mb_strtoupper(htmlspecialchars($f['asunto']), 'UTF-8'); ?></b><br>
													<span style="font-size:0.82rem; color:var(--cd-gray-dark);"><?php echo htmlspecialchars($f['descripcion']); ?></span><br>
													<span style="font-size:0.78rem; color:var(--cd-gray-mid);"><i class="fa-solid fa-building-user"></i> Creado por: <?php echo nombreDepartamento($f['idDptoCrea']); ?></span>
												</div>
											</td>
											<td>
												<?php
												$ultColab = ultimoColaborador($f['id']);
												if ($ultColab != 'FALSE') {
													echo "<b style='font-size:0.82rem; color:var(--cd-dark);'>" . htmlspecialchars(nitavu_nombre($ultColab)) . "</b>";
												} else if (personasConNivelUno($f['id']) != 'FALSE') {
													echo "<b style='font-size:0.82rem; color:var(--cd-dark);'>" . htmlspecialchars(nitavu_nombre(personasConNivelUno($f['id']))) . "</b>";
												} else if (buscoalTitulardelCaso($f['id']) != 'FALSE') {
													echo "<b style='font-size:0.82rem; color:var(--cd-dark);'>" . htmlspecialchars(nitavu_nombre(buscoalTitulardelCaso($f['id']))) . "</b>";
												} else {
													echo "<span style='font-size:0.82rem; color:var(--cd-gray-mid);'>No definido</span>";
												}
												?>
											</td>
											<td style="text-align:center;">
												<form action="cp_nuevos_oficios.php" method="GET" style="margin:0;">
													<input type="hidden" value="<?php echo $f['id']; ?>" name="id">
													<input type="hidden" name="txtplus" value="1">
													<input type="hidden" name="pv" value="1">
													<button type="submit" class="cd-icon-btn view" title="Ver Historial del Caso">
														<i class="fa-solid fa-eye"></i>
													</button>
												</form>
											</td>
										</tr>
									<?php endwhile; ?>
								</tbody>
							</table>
						</div>

						<?php if ($r_count >= $paginacion): ?>
							<div class="cd-pagination">
								<?php for ($i = 1; $i <= $paginas; $i++): ?>
									<?php if ($pagina == $i): ?>
										<span class="active"><?php echo $i; ?></span>
									<?php else: ?>
										<a href="?p=<?php echo $i; ?>&pes=finalizados"><?php echo $i; ?></a>
									<?php endif; ?>
								<?php endfor; ?>
							</div>
						<?php endif; ?>

					<?php else: ?>
						<div style="padding:30px; text-align:center; color:var(--cd-gray-mid);">
							<i class="fa-solid fa-folder-open" style="font-size:2rem; margin-bottom:10px;"></i>
							<p>No existen registros de casos finalizados en esta sección.</p>
						</div>
					<?php endif; ?>
				</div>
			</div>
		<?php } ?>

		<?php
		// =========================================================================
		// TAB 2: CASOS CREADOS POR MÍ
		// =========================================================================
		if ($pes == 'creados') {
			$pags = 20;
			$query1 = "SELECT DISTINCT * FROM cp_nuevosdocumentos WHERE nitavuCaptura = " . $nitavu . " ORDER BY id DESC";

			echo "<div id='imprimir2' style='display:none;'>";
			echo "<h1>Casos que registré:</h1>";
			echo "<table class='tabla'><tr><th width='20%' COLSPAN='2'>Fecha</th><th width='70%'>Asunto</th></tr>";
			$r_print2 = $conexion->query($query1);
			while ($f_p2 = $r_print2->fetch_array()) {
				echo "<tr><td>" . $f_p2['id'] . "</td><td>" . fecha_larga($f_p2['fecha']) . "</td><td><b>" . htmlspecialchars($f_p2['asunto']) . "</b><br>" . htmlspecialchars($f_p2['descripcion']) . "</td></tr>";
			}
			echo "</table></div>";

			$r1 = $conexion->query($query1);
			$r_count1 = $r1 ? $r1->num_rows : 0;
			?>

			<div class="cd-card-section">
				<div class="cd-card-header cd-card-header-gold">
					<h3 class="cd-card-title">
						<i class="fa-solid fa-user-pen" style="color:var(--cd-gold-dark);"></i> Casos Creados por Mí
					</h3>
					<div style="display:flex; align-items:center; gap:10px;">
						<span class="cd-badge cd-badge-warning"><?php echo $r_count1; ?> Registros</span>
						<button type="button" onclick="printDiv(2)" class="cd-btn cd-btn-gold" style="padding:6px 12px; font-size:0.82rem;">
							<i class="fa-solid fa-file-pdf"></i> PDF
						</button>
					</div>
				</div>
				<div class="cd-card-body" style="padding:0;">
					<?php if ($r_count1 > 0): 
						$pagina1 = (isset($_GET["p1"]) && is_numeric($_GET["p1"])) ? (int)$_GET["p1"] : 1;
						$empezar_desde1 = ($pagina1 - 1) * $pags;
						$query1_lim = $query1 . " LIMIT " . $empezar_desde1 . ", " . $pags;
						$r1_lim = $conexion->query($query1_lim);
						$paginas1 = ceil(($r_count1 / $pags));
					?>
						<div class="cd-table-container">
							<table class="cd-table">
								<thead>
									<tr>
										<th style="width:75px; text-align:center;">ID</th>
										<th style="width:140px;">Fecha</th>
										<th>Asunto & Descripción</th>
										<th>Último Colaborador</th>
										<th style="width:90px; text-align:center;">Acciones</th>
									</tr>
								</thead>
								<tbody>
									<?php while ($f1 = $r1_lim->fetch_array()): ?>
										<tr>
											<td style="text-align:center;"><span class="cd-badge-id"><?php echo $f1['id']; ?></span></td>
											<td><span style="font-weight:600; color:var(--cd-dark);"><?php echo fecha_corta($f1['fecha']); ?></span></td>
											<td>
												<div>
													<b style="color:var(--cd-primary); text-transform:uppercase;"><?php echo mb_strtoupper(htmlspecialchars($f1['asunto']), 'UTF-8'); ?></b><br>
													<span style="font-size:0.82rem; color:var(--cd-gray-dark);"><?php echo htmlspecialchars($f1['descripcion']); ?></span><br>
													<span style="font-size:0.78rem; color:var(--cd-gray-mid);"><i class="fa-solid fa-building-user"></i> Creado por: <?php echo nombreDepartamento($f1['idDptoCrea']); ?></span>
												</div>
											</td>
											<td>
												<?php
												$ultColab = ultimoColaborador($f1['id']);
												if ($ultColab != 'FALSE') {
													echo "<b style='font-size:0.82rem; color:var(--cd-dark);'>" . htmlspecialchars(nitavu_nombre($ultColab)) . "</b>";
												} else if (personasConNivelUno($f1['id']) != 'FALSE') {
													echo "<b style='font-size:0.82rem; color:var(--cd-dark);'>" . htmlspecialchars(nitavu_nombre(personasConNivelUno($f1['id']))) . "</b>";
												} else if (buscoalTitulardelCaso($f1['id']) != 'FALSE') {
													echo "<b style='font-size:0.82rem; color:var(--cd-dark);'>" . htmlspecialchars(nitavu_nombre(buscoalTitulardelCaso($f1['id']))) . "</b>";
												} else {
													echo "<span style='font-size:0.82rem; color:var(--cd-gray-mid);'>No definido</span>";
												}
												?>
											</td>
											<td style="text-align:center;">
												<form action="cp_nuevos_oficios.php" method="GET" style="margin:0;">
													<input type="hidden" value="<?php echo $f1['id']; ?>" name="id">
													<input type="hidden" name="txtplus" value="1">
													<input type="hidden" name="pv" value="1">
													<button type="submit" class="cd-icon-btn view" title="Ver Historial del Caso">
														<i class="fa-solid fa-eye"></i>
													</button>
												</form>
											</td>
										</tr>
									<?php endwhile; ?>
								</tbody>
							</table>
						</div>

						<?php if ($r_count1 >= $pags): ?>
							<div class="cd-pagination">
								<?php for ($i1 = 1; $i1 <= $paginas1; $i1++): ?>
									<?php if ($pagina1 == $i1): ?>
										<span class="active"><?php echo $i1; ?></span>
									<?php else: ?>
										<a href="?p1=<?php echo $i1; ?>&pes=creados"><?php echo $i1; ?></a>
									<?php endif; ?>
								<?php endfor; ?>
							</div>
						<?php endif; ?>

					<?php else: ?>
						<div style="padding:30px; text-align:center; color:var(--cd-gray-mid);">
							<i class="fa-solid fa-folder-open" style="font-size:2rem; margin-bottom:10px;"></i>
							<p>No ha registrado documentos aún.</p>
						</div>
					<?php endif; ?>
				</div>
			</div>
		<?php } ?>

		<?php
		// =========================================================================
		// TAB 3: CASOS EN LOS QUE PARTICIPÉ (ACTIVOS)
		// =========================================================================
		if ($pes == 'participe') {
			$dpto = nitavu_dpto($nitavu);

			if ($nivel == 1 || soytitular($nitavu) != 'FALSE') {
				$query = "SELECT DISTINCT * FROM cp_nuevosdocumentos 
				WHERE (nitavuCaptura = " . $nitavu . " OR idDptoCrea = " . nitavu_dpto($nitavu) . " OR id IN (SELECT numcaso FROM cp_colaboradores WHERE nitavu=" . $nitavu . ") OR id IN (SELECT NumCaso FROM cp_historialdocumentos WHERE nitavuSube=" . $nitavu . ") OR turnadoa = " . nitavu_dpto($nitavu) . " OR id IN (SELECT CasoId FROM cp_comentarios WHERE Nuser = " . $nitavu . "))
				AND estado = 0 ORDER BY id DESC";
			} else {
				$query = "SELECT DISTINCT * FROM cp_nuevosdocumentos 
				WHERE (nitavuCaptura = " . $nitavu . " OR id IN (SELECT numcaso FROM cp_colaboradores WHERE nitavu=" . $nitavu . ") OR id IN (SELECT NumCaso FROM cp_historialdocumentos WHERE nitavuSube=" . $nitavu . ") OR id IN (SELECT CasoId FROM cp_comentarios WHERE Nuser = " . $nitavu . "))
				AND estado = 0 ORDER BY id DESC";
			}

			echo "<div id='imprimir3' style='display:none;'>";
			echo "<h1>Casos en los que participé (Activos):</h1>";
			echo "<table class='tabla'><tr><th width='20%' COLSPAN='2'>Fecha</th><th width='70%'>Asunto</th></tr>";
			$r_print3 = $conexion->query($query);
			while ($f_p3 = $r_print3->fetch_array()) {
				echo "<tr><td>" . $f_p3['id'] . "</td><td>" . fecha_larga($f_p3['fecha']) . "</td><td><b>" . htmlspecialchars($f_p3['asunto']) . "</b><br>" . htmlspecialchars($f_p3['descripcion']) . "</td></tr>";
			}
			echo "</table></div>";

			$r = $conexion->query($query);
			$r_count = $r ? $r->num_rows : 0;
			?>

			<!-- Filter toolbar card -->
			<div class="cd-search-card" style="margin-bottom:20px;">
				<div class="cd-search-form">
					<div class="cd-search-label">
						<i class="fa-solid fa-filter" style="color:var(--cd-gold-dark);"></i>
						<span>Filtrar por Departamento (Quien los tiene):</span>
					</div>
					<div class="cd-input-group">
						<select id="dptos1" name="dptos1" class="cd-form-select" onchange="filtroDpto1(<?php echo $nitavu; ?>, 2);">
							<option value="1000" selected>Todos los Departamentos</option>
							<?php
							$sqlD = "SELECT * FROM cat_gerarquia ORDER BY nombre";
							$rD = $conexion->query($sqlD);
							while ($fD = $rD->fetch_array()) {
								echo "<option value='" . $fD['id'] . "'>" . htmlspecialchars($fD['nombre']) . "</option>";
							}
							?>
						</select>
						<button type="button" onclick="printDiv(3)" class="cd-btn cd-btn-gold">
							<i class="fa-solid fa-file-pdf"></i> Exportar PDF
						</button>
					</div>
				</div>
			</div>

			<div id="resconsulta1" style="width:100%; display:none;"></div>

			<div id="primeraParticipe" class="cd-card-section">
				<div class="cd-card-header cd-card-header-info">
					<h3 class="cd-card-title">
						<i class="fa-solid fa-handshake" style="color:#2563eb;"></i> Casos en los que Participé (Activos)
					</h3>
					<span class="cd-badge cd-badge-info"><?php echo $r_count; ?> Registros</span>
				</div>
				<div class="cd-card-body" style="padding:0;">
					<?php if ($r_count > 0): 
						$pagina = (isset($_GET["p"]) && is_numeric($_GET["p"])) ? (int)$_GET["p"] : 1;
						$empezar_desde = ($pagina - 1) * $paginacion;
						$query_lim = $query . " LIMIT " . $empezar_desde . ", " . $paginacion;
						$r_lim = $conexion->query($query_lim);
						$paginas = ceil(($r_count / $paginacion));
					?>
						<div class="cd-table-container">
							<table class="cd-table">
								<thead>
									<tr>
										<th style="width:75px; text-align:center;">ID</th>
										<th style="width:140px;">Fecha</th>
										<th>Asunto & Descripción</th>
										<th>Último Colaborador</th>
										<th style="width:90px; text-align:center;">Acciones</th>
									</tr>
								</thead>
								<tbody>
									<?php while ($f = $r_lim->fetch_array()): ?>
										<tr>
											<td style="text-align:center;"><span class="cd-badge-id"><?php echo $f['id']; ?></span></td>
											<td><span style="font-weight:600; color:var(--cd-dark);"><?php echo fecha_corta($f['fecha']); ?></span></td>
											<td>
												<div>
													<b style="color:var(--cd-primary); text-transform:uppercase;"><?php echo mb_strtoupper(htmlspecialchars($f['asunto']), 'UTF-8'); ?></b><br>
													<span style="font-size:0.82rem; color:var(--cd-gray-dark);"><?php echo htmlspecialchars($f['descripcion']); ?></span><br>
													<span style="font-size:0.78rem; color:var(--cd-gray-mid);"><i class="fa-solid fa-building-user"></i> Creado por: <?php echo nombreDepartamento($f['idDptoCrea']); ?></span>
												</div>
											</td>
											<td>
												<?php
												$ultColab = ultimoColaborador($f['id']);
												if ($ultColab != 'FALSE') {
													echo "<b style='font-size:0.82rem; color:var(--cd-dark);'>" . htmlspecialchars(nitavu_nombre($ultColab)) . "</b>";
												} else if (personasConNivelUno($f['id']) != 'FALSE') {
													echo "<b style='font-size:0.82rem; color:var(--cd-dark);'>" . htmlspecialchars(nitavu_nombre(personasConNivelUno($f['id']))) . "</b>";
												} else if (buscoalTitulardelCaso($f['id']) != 'FALSE') {
													echo "<b style='font-size:0.82rem; color:var(--cd-dark);'>" . htmlspecialchars(nitavu_nombre(buscoalTitulardelCaso($f['id']))) . "</b>";
												} else {
													echo "<span style='font-size:0.82rem; color:var(--cd-gray-mid);'>No definido</span>";
												}
												?>
											</td>
											<td style="text-align:center;">
												<form action="cp_nuevos_oficios.php" method="GET" style="margin:0;">
													<input type="hidden" value="<?php echo $f['id']; ?>" name="id">
													<input type="hidden" name="txtplus" value="1">
													<input type="hidden" name="pv" value="1">
													<button type="submit" class="cd-icon-btn view" title="Ver Historial del Caso">
														<i class="fa-solid fa-eye"></i>
													</button>
												</form>
											</td>
										</tr>
									<?php endwhile; ?>
								</tbody>
							</table>
						</div>

						<?php if ($r_count >= $paginacion): ?>
							<div class="cd-pagination">
								<?php for ($i = 1; $i <= $paginas; $i++): ?>
									<?php if ($pagina == $i): ?>
										<span class="active"><?php echo $i; ?></span>
									<?php else: ?>
										<a href="?p=<?php echo $i; ?>&pes=participe"><?php echo $i; ?></a>
									<?php endif; ?>
								<?php endfor; ?>
							</div>
						<?php endif; ?>

					<?php else: ?>
						<div style="padding:30px; text-align:center; color:var(--cd-gray-mid);">
							<i class="fa-solid fa-folder-open" style="font-size:2rem; margin-bottom:10px;"></i>
							<p>No participa en casos activos actualmente.</p>
						</div>
					<?php endif; ?>
				</div>
			</div>
		<?php } ?>
	</div>

	<script>
		function filtroDpto(nitavu, caso) {
			var dpto = $("#dptos option:selected").val();
			if (dpto == 1000) {
				$("#resconsulta").css({ 'display': 'none' });
				$("#primeraFinalizados").css({ 'display': 'block' });
			} else {
				$.ajax({
					url: "cp_consultapordpto.php",
					type: "get",
					data: { dpto: dpto, nitavu: nitavu, caso: caso },
					success: function (data) {
						$("#primeraFinalizados").css({ 'display': 'none' });
						$('#resconsulta').html(data + "\n").css({ 'display': 'block' });
					}
				});
			}
		}

		function filtroDpto1(nitavu, caso) {
			var dpto = $("#dptos1 option:selected").val();
			if (dpto == 1000) {
				$("#resconsulta1").css({ 'display': 'none' });
				$("#primeraParticipe").css({ 'display': 'block' });
			} else {
				$.ajax({
					url: "cp_consultapordpto.php",
					type: "get",
					data: { dpto: dpto, nitavu: nitavu, caso: caso },
					success: function (data) {
						$("#primeraParticipe").css({ 'display': 'none' });
						$('#resconsulta1').html(data + "\n").css({ 'display': 'block' });
					}
				});
			}
		}

		function printDiv(id) {
			var divToPrint = document.getElementById('imprimir' + id);
			var newWin = window.open('', 'Print-Window');
			newWin.document.open();
			newWin.document.write('<html><body onload="window.print()">' + divToPrint.innerHTML + '</body></html>');
			newWin.document.close();
			setTimeout(function () { newWin.close(); }, 10);
		}
	</script>

	<br><br>
	<?php
	include("./lib/body_footer.php");
} else {
	mensaje("ERROR: no tiene acceso a esta aplicacion", './index.php?home=');
}
?>