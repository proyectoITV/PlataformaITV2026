<?php
include("./lib/body_head.php");
include("./lib/body_menu.php");

$idDepartamento = nitavu_dpto($nitavu);
$id_aplicacion = "ap66";
$nivel = aplicacion_nivel($id_aplicacion, $nitavu);

if (sanpedro($id_aplicacion, $nitavu) == TRUE) {
	echo "<div id='AppDetalle'>" . app_detalle($id_aplicacion, $nitavu) . "</div>";
	?>

	<div class="cd-wrapper">
		<!-- Hero Header -->
		<div class="cd-hero">
			<div>
				<h1 class="cd-hero-title">
					<i class="fa-solid fa-ticket"></i> Colaboraciones Activas
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

		<!-- Search & Direct Lookup Card -->
		<div class="cd-search-card">
			<div class="cd-search-form">
				<div class="cd-search-label">
					<i class="fa-solid fa-magnifying-glass" style="color:var(--cd-gold-dark);"></i>
					<span>Buscar en Colaboraciones:</span>
				</div>
				<div class="cd-input-group">
					<input class="cd-input" id="InputBusqueda" type="search" placeholder="Buscar por asunto, descripción o caso..." aria-label="Busqueda">
					<button class="cd-btn cd-btn-primary" onclick="BuscarTicket(1);">
						<i class="fa-solid fa-magnifying-glass"></i> Buscar
					</button>
				</div>
			</div>

			<hr style="border:0; border-top:1px solid var(--cd-border); margin:16px 0;">

			<form action="cp_nuevos_oficios.php" method="GET" class="cd-search-form">
				<div class="cd-search-label">
					<i class="fa-solid fa-hashtag" style="color:var(--cd-primary);"></i>
					<span>Directo por No. Correspondencia:</span>
				</div>
				<div class="cd-input-group">
					<input type="text" class="cd-input" name="id" id="id" placeholder="Número de correspondencia..." required>
					<button type="submit" class="cd-btn cd-btn-gold">
						<i class="fa-solid fa-folder-open"></i> Abrir Caso
					</button>
				</div>
			</form>
		</div>

		<div id="PreLoader_buscando" style="display:none; text-align:center; padding:15px;">
			<i class="fa-solid fa-circle-notch fa-spin" style="font-size:1.8rem; color:var(--cd-primary);"></i>
			<span style="display:block; margin-top:6px; font-size:0.85rem; color:var(--cd-gray-mid);">Cargando colaboraciones...</span>
		</div>

		<!-- Dynamic Results Container -->
		<div id="DivResultado"></div>
	</div>

	<script>
		function BuscarTicket(mode) {
			$('#PreLoader_buscando').show();
			busqueda = $('#InputBusqueda').val();
			$.ajax({
				url: 'tickets_data.php',
				type: 'post',
				data: { nitavu: '<?php echo $nitavu; ?>', busqueda: busqueda, mode: mode },
				success: function (data) {
					$('#DivResultado').html(data);
					$('#PreLoader_buscando').hide();
				}
			});
		}
		BuscarTicket(0);
	</script>

	<br><br>
	<?php
	include("./lib/body_footer.php");
} else {
	mensaje("ERROR: no tiene acceso a esta aplicacion", './index.php?home=');
}
?>
