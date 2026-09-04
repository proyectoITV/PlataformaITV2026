<?php
require("config.php");
require("components.php");

$nitavu = VarClean($_POST['nitavu']);
$busqueda = VarClean($_POST['busqueda']);
$mode = VarClean($_POST['mode']);

if ($mode == 0) {
	$sql = "select a.nitavu,
    e.nombre as Nombre,
    count(*) as Pendientes
    from ticketpendientes a
    left join empleados e on e.nitavu = a.nitavu
    where  a.dpto = " . nitavu_dpto($nitavu) . " and a.estado=0
    group by a.nitavu, e.nombre";

	$r = $conexion->query($sql);
	?>
	<div class="cd-card-section">
		<div class="cd-card-header cd-card-header-primary">
			<h3 class="cd-card-title">
				<i class="fa-solid fa-users-gear"></i> Resumen de Colaboraciones Activas por Personal
			</h3>
		</div>
		<div class="cd-card-body" style="padding:0;">
			<div class="cd-table-container">
				<table class="cd-table">
					<thead>
						<tr>
							<th>Colaborador</th>
							<th style="width:180px; text-align:center;">Casos Pendientes</th>
							<th style="width:120px; text-align:center;">Detalles</th>
						</tr>
					</thead>
					<tbody>
						<?php
						$hasRows = false;
						while ($f = $r->fetch_array()) {
							$hasRows = true;
							echo "<tr>";
							echo "<td><b style='color:var(--cd-dark); font-size:0.95rem;'><i class='fa-solid fa-user-tie' style='color:var(--cd-primary); margin-right:6px;'></i> " . htmlspecialchars($f['Nombre']) . "</b></td>";
							echo "<td style='text-align:center;'><span class='cd-badge cd-badge-warning' style='font-size:0.85rem; padding:4px 12px;'><i class='fa-solid fa-folder-open'></i> " . $f['Pendientes'] . " Casos</span></td>";
							echo "<td style='text-align:center;'>
								<a href='#modal" . $f['nitavu'] . "' rel='MyModal:open' class='cd-btn cd-btn-gold' style='padding:4px 10px; font-size:0.8rem;'>
									<i class='fa-solid fa-eye'></i> Ver Casos
								</a>
							</td>";
							echo "</tr>";

							// Modal por Colaborador
							echo "<div id='modal" . $f['nitavu'] . "' class='MyModal'>";
							echo "<h3><i class='fa-solid fa-folder-tree'></i> Casos Activos de: " . htmlspecialchars($f['Nombre']) . "</h3>";
							echo "<div class='cd-table-container'>";
							echo "<table class='cd-table'>";
							echo "<thead><tr><th style='width:80px; text-align:center;'>ID</th><th>Asunto</th><th style='width:90px; text-align:center;'>Abrir</th></tr></thead><tbody>";

							$sqlR = "SELECT a.*, b.asunto as Asunto, b.estado as Estado FROM cp_colaboradores a LEFT JOIN cp_nuevosdocumentos b on b.id = a.numcaso WHERE a.nitavu = " . $f['nitavu'] . " and a.activo = 0";
							$rx = $conexion->query($sqlR);
							while ($fx = $rx->fetch_array()) {
								if ($fx['Estado'] == 0) {
									echo "<tr>";
									echo "<td style='text-align:center;'><span class='cd-badge-id'>" . $fx['numcaso'] . "</span></td>";
									echo "<td><b style='color:var(--cd-primary); text-transform:uppercase;'>" . mb_strtoupper(htmlspecialchars($fx['Asunto']), 'UTF-8') . "</b></td>";
									echo "<td style='text-align:center;'>
										<a href='cp_nuevos_oficios.php?id=" . $fx['numcaso'] . "&txtplus=1&pv=1' class='cd-icon-btn view' title='Abrir Caso'>
											<i class='fa-solid fa-arrow-right-to-bracket'></i>
										</a>
									</td>";
									echo "</tr>";
								}
							}
							echo "</tbody></table></div></div>";
						}
						if (!$hasRows) {
							echo "<tr><td colspan='3' style='text-align:center; padding:24px; color:var(--cd-gray-mid);'>No hay colaboraciones pendientes actualmente en su departamento.</td></tr>";
						}
						?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
	<?php
}

if ($mode == 1) { // Búsqueda de tickets
	if (sanpedro("ap66", $nitavu) == TRUE) {
		$sql = "select * from busquedas_tickets WHERE Descripcion like '%" . $busqueda . "%' or Asunto like '%" . $busqueda . "%'";
		$r = $conexion->query($sql);
		?>
		<div class="cd-card-section">
			<div class="cd-card-header cd-card-header-gold">
				<h3 class="cd-card-title">
					<i class="fa-solid fa-magnifying-glass-chart"></i> Resultados de Búsqueda para "<?php echo htmlspecialchars($busqueda); ?>"
				</h3>
			</div>
			<div class="cd-card-body" style="padding:0;">
				<div class="cd-table-container">
					<table class="cd-table">
						<thead>
							<tr>
								<th>Asunto / Ticket</th>
								<th>Descripción</th>
								<th style="width:90px; text-align:center;">Acción</th>
							</tr>
						</thead>
						<tbody>
							<?php
							$found = false;
							while ($fap = $r->fetch_array()) {
								$found = true;
								echo "<tr>";
								echo "<td><b style='color:var(--cd-primary);'><i class='fa-solid fa-file-lines' style='margin-right:6px;'></i> " . htmlspecialchars($fap['Asunto']) . "</b></td>";
								echo "<td><span style='font-size:0.85rem; color:var(--cd-gray-dark);'>" . htmlspecialchars($fap['Descripcion']) . "</span></td>";
								echo "<td style='text-align:center;'>
									<a href='" . htmlspecialchars($fap['URL']) . "' class='cd-icon-btn view' title='Abrir Ticket'>
										<i class='fa-solid fa-arrow-right-to-bracket'></i>
									</a>
								</td>";
								echo "</tr>";
							}
							if (!$found) {
								echo "<tr><td colspan='3' style='text-align:center; padding:24px; color:var(--cd-gray-mid);'>No se encontraron tickets con el término ingresado.</td></tr>";
							}
							?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
		<?php
	} else {
		echo "<div class='cd-suggestion-box' style='background:#fee2e2; border-color:#fca5a5; color:#991b1b;'><i class='fa-solid fa-triangle-exclamation'></i> Sin permiso para buscar en esta sección.</div>";
	}
}
?>