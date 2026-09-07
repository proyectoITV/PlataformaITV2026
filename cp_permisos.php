<?php
include("./lib/body_head.php");
include("./lib/body_menu.php");

$id_aplicacion = "ap66"; // ap66 = Control Documental / Correspondencia
if (sanpedro($id_aplicacion, $nitavu) == TRUE) {
	echo "<div id='AppDetalle'>" . app_detalle($id_aplicacion, $nitavu) . "</div>";

	xd_update($id_aplicacion, $nitavu); // Guarda la experiencia del usuario
	historia($nitavu, "Entro a la aplicacion, para dar permisos de nivel 2 de la aplicacion Control Correspondencia");

	// PROCESAR ALTA DE PERMISO
	if (isset($_POST['submit_todos'])) {
		$sql = "INSERT INTO aplicaciones_permisos (nitavu, idapp, nivel, quien_autorizo, fecha_autorizacion) VALUES ('" . $_POST['empleado'] . "', 'ap66', " . $_POST['nivel'] . ", '" . $nitavu . "', '" . $fecha . "')";
		if ($conexion->query($sql) == TRUE) {
			historia($nitavu, "Dio permiso a control correspondencia a " . $_POST['empleado'] . ", " . nitavu_nombre($_POST['empleado']));
			notificacion_add($_POST['empleado'], 'Acceso a Control Correspondencia', $fecha, $nitavu, "Le he otorgado permisos en la aplicación Control Documental para que usted pueda colaborar.");
			mensaje("Permiso otorgado correctamente", 'cp_permisos.php');
		} else {
			historia($nitavu, "ERROR al dar permiso a control correspondencia " . $sql);
			mensaje("Ha ocurrido un error al otorgar el permiso", 'cp_permisos.php');
		}
	}

	// PROCESAR ELIMINACIÓN DE PERMISO
	if (isset($_GET['eliminar'])) {
		$sql = "DELETE FROM aplicaciones_permisos WHERE nitavu='" . $_GET['eliminar'] . "' and idapp='ap66'";
		if ($conexion->query($sql) == TRUE) {
			historia($nitavu, "REVOCO el permiso a " . $_GET['eliminar'] . ", " . nitavu_nombre($_GET['eliminar']) . " de control correspondencia.");
			notificacion_add($_GET['eliminar'], 'Permiso REVOCADO', $fecha, $nitavu, "Le he REVOCADO el permiso para usar la aplicación Control Documental.");
			mensaje("Permiso revocando correctamente", 'cp_permisos.php');
		} else {
			historia($nitavu, "ERROR al REVOCAR permiso: " . $sql);
			mensaje("Ha ocurrido un error al revocar el permiso", 'cp_permisos.php');
		}
	}
	?>

	<div class="cd-wrapper">
		<!-- Hero Header -->
		<div class="cd-hero">
			<div>
				<h1 class="cd-hero-title">
					<i class="fa-solid fa-user-shield"></i> Permisos de Colaboradores
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

		<!-- Form Card: Otorgar Permiso -->
		<div class="cd-card-section">
			<div class="cd-card-header cd-card-header-gold">
				<h3 class="cd-card-title">
					<i class="fa-solid fa-user-plus" style="color:var(--cd-gold-dark);"></i> Otorgar Nuevo Permiso de Acceso
				</h3>
			</div>
			<div class="cd-card-body">
				<form action="cp_permisos.php" method="POST">
					<input type="hidden" name="nitavu_" value="<?php echo $nitavu; ?>">
					
					<div class="cd-form-grid">
						<div class="cd-form-group">
							<label class="cd-form-label"><i class="fa-solid fa-user"></i> Seleccione Empleado:</label>
							<select name="empleado" class="cd-form-select" required>
								<option value="" disabled selected>Seleccionar empleado de su departamento...</option>
								<?php
								$sql = "SELECT * FROM empleados WHERE nitavu NOT IN (SELECT nitavu FROM aplicaciones_permisos WHERE idapp='ap66') AND empleados.nitavu <> " . $nitavu . " AND empleados.dpto = " . nitavu_dpto($nitavu) . " AND empleados.estado ='' ORDER BY nombre ASC";
								$r = $conexion->query($sql);
								while ($f = $r->fetch_array()) {
									if ($nitavu != $f['nitavu']) {
										echo "<option value='" . $f['nitavu'] . "'>" . htmlspecialchars($f['nombre']) . " (" . htmlspecialchars($f['puesto']) . ")</option>";
									}
								}
								?>
							</select>
						</div>

						<div class="cd-form-group">
							<label class="cd-form-label"><i class="fa-solid fa-key"></i> Nivel de Permiso:</label>
							<select name="nivel" class="cd-form-select" required>
								<option value="2" selected>Colaborador (Nivel 2) - Comenta, sube archivos y anexa</option>
								<option value="3">Administrador (Nivel 3) - Turna, finaliza y gestiona</option>
								<option value="1">Super Usuario (Nivel 1) - Todos los permisos</option>
							</select>
						</div>
					</div>

					<div style="margin-top:16px; display:flex; justify-content:flex-end;">
						<button type="submit" class="cd-btn cd-btn-primary" name="submit_todos">
							<i class="fa-solid fa-user-check"></i> Otorgar Permiso
						</button>
					</div>
				</form>
			</div>
		</div>

		<!-- Table Card: Empleados con Permisos -->
		<div class="cd-card-section">
			<div class="cd-card-header cd-card-header-primary">
				<h3 class="cd-card-title">
					<i class="fa-solid fa-users"></i> Empleados con Permisos Activos
				</h3>
			</div>
			<div class="cd-card-body" style="padding:0;">
				<div class="cd-table-container">
					<table class="cd-table">
						<thead>
							<tr>
								<th>Empleado</th>
								<th style="width: 140px; text-align: center;">Nivel</th>
								<th>Puesto & Departamento</th>
								<th>Autorización</th>
								<th style="width: 90px; text-align: center;">Acciones</th>
							</tr>
						</thead>
						<tbody>
							<?php
							$sql = "SELECT * FROM aplicaciones_permisos WHERE idapp='ap66'";
							$r2 = $conexion->query($sql);
							$hasPerms = false;
							while ($f = $r2->fetch_array()) {
								if (nitavu_dpto($nitavu) == nitavu_dpto($f['nitavu'])) {
									$hasPerms = true;
									echo "<tr>";
									echo "<td><b style='color:var(--cd-dark);'>" . htmlspecialchars(nitavu_nombre($f['nitavu'])) . "</b></td>";
									
									// Badge por Nivel
									echo "<td style='text-align: center;'>";
									if ($f['nivel'] == 1) {
										echo "<span class='cd-badge cd-badge-danger'><i class='fa-solid fa-shield-halved'></i> Super Usuario</span>";
									} else if ($f['nivel'] == 3) {
										echo "<span class='cd-badge cd-badge-warning'><i class='fa-solid fa-user-gear'></i> Administrador</span>";
									} else {
										echo "<span class='cd-badge cd-badge-info'><i class='fa-solid fa-user-pen'></i> Colaborador</span>";
									}
									echo "</td>";

									echo "<td><span style='font-size:0.85rem; color:var(--cd-gray-dark);'>" . htmlspecialchars(nitavu_puesto($f['nitavu'])) . "</span><br><span style='font-size:0.78rem; color:var(--cd-gray-mid);'>" . htmlspecialchars(nitavu_dpto_nombre($f['nitavu'])) . "</span></td>";
									echo "<td><span style='font-size:0.85rem; color:var(--cd-dark);'>" . htmlspecialchars(nitavu_nombre($f['quien_autorizo'])) . "</span><br><span style='font-size:0.78rem; color:var(--cd-gray-mid);'><i class='fa-regular fa-calendar'></i> " . fecha_corta($f['fecha_autorizacion']) . "</span></td>";
									
									echo "<td style='text-align: center;'>
										<a href='?eliminar=" . $f['nitavu'] . "' class='cd-icon-btn delete' title='Revocar Permiso' onclick=\"return confirm('¿Está seguro de revocar el permiso a este empleado?');\">
											<i class='fa-solid fa-trash-can'></i>
										</a>
									</td>";
									echo "</tr>";
								}
							}
							if (!$hasPerms) {
								echo "<tr><td colspan='5' style='text-align:center; padding:20px; color:var(--cd-gray-mid);'>No hay empleados secundarios con permisos asignados en este departamento.</td></tr>";
							}
							?>
						</tbody>
					</table>
				</div>
			</div>
		</div>

		<div class="cd-suggestion-box">
			<p><strong><i class="fa-solid fa-circle-info"></i> Nota sobre permisos:</strong> Los empleados asignados con Nivel 2 o Nivel 3 podrán acceder al listado de correspondencia de su departamento para dar seguimiento, adjuntar respuestas y turnar casos.</p>
		</div>
	</div>

	<br><br>
	<?php
	include("./lib/body_footer.php");
} else {
	mensaje("ERROR no tiene permisos para usar esta aplicacion", './index.php?home=');
}
?>