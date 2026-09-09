<?php
include ("./lib/body_head.php"); 
include ("./lib/body_menu.php"); 
?>
<link rel="stylesheet" href="lib/laura.css" />
<link rel="stylesheet" href="lib/plataforma_modern.css" />
<?php
$id_aplicacion = 'ap70';
xd_update('ap70',$nitavu);//guarda la experiencia del usuario
echo "<div id='AppDetalle'>".app_detalle($id_aplicacion, $nitavu)."</div>";
//PROCESO PARA TOCAR LA PUERTA DE SAN PEDRO
$nivel = aplicacion_nivel($id_aplicacion, $nitavu);

if (sanpedro($id_aplicacion, $nitavu) == TRUE){
?>

<div class="cd-wrapper">
    <!-- Hero Banner -->
    <div class="cd-hero">
        <div>
            <h1 class="cd-hero-title">
                <i class="fa-solid fa-file-signature"></i> Generación de Oficio de Pago a Mandantes
            </h1>
            <div class="cd-hero-dept">
                <i class="fa-solid fa-building-columns"></i> Control Financiero ITAVU 2026
            </div>
        </div>
        <div class="cd-top-links">
            <a href="mandantes_pago.php" class="cd-top-link-btn" title="Regresar al módulo principal">
                <i class="fa-solid fa-arrow-left"></i> Regresar a Pago a Mandantes
            </a>
        </div>
    </div>

    <!-- Formulario para crear oficio -->
    <div class="cd-card-section" style="margin-bottom: 24px;">
        <div class="cd-card-header cd-card-header-primary">
            <h3 class="cd-card-title">
                <i class="fa-solid fa-file-invoice"></i> Datos Requeridos para el Oficio
            </h3>
        </div>
        <div class="cd-card-body">
            <form action="md_pagomandantes.php" method="GET">
                <div class="cd-form-grid-3">
                    <div class="cd-form-group">
                        <label for="numOficio" class="cd-form-label"><i class="fa-solid fa-hashtag" style="color:var(--cd-gold-dark);"></i> Número de Oficio / Ref.</label>
                        <input id="numOficio" name="numOficio" class="cd-form-control" placeholder="Ej. ITAVU/DG/123/2026" value="<?php echo isset($_GET['numOficio']) ? htmlspecialchars($_GET['numOficio']) : ''; ?>" required>
                    </div>
                    <div class="cd-form-group">
                        <label for="fechainicio" class="cd-form-label"><i class="fa-regular fa-calendar"></i> Fecha Inicio</label>
                        <input type="date" id="fechainicio" name="fechainicio" class="cd-form-control" value="<?php echo isset($_GET['fechainicio']) ? htmlspecialchars($_GET['fechainicio']) : ''; ?>" required>
                    </div>
                    <div class="cd-form-group">
                        <label for="fechafin" class="cd-form-label"><i class="fa-regular fa-calendar-check"></i> Fecha Fin</label>
                        <input type="date" id="fechafin" name="fechafin" class="cd-form-control" value="<?php echo isset($_GET['fechafin']) ? htmlspecialchars($_GET['fechafin']) : ''; ?>" required>
                    </div>
                </div>

                <div style="margin-top:15px; text-align:right;">
                    <button type="submit" class="cd-btn cd-btn-primary">
                        <i class="fa-solid fa-gears"></i> Generar Oficio de Pago
                    </button>
                </div>
            </form>
        </div>
    </div>

    <?php
    if(isset($_GET['numOficio']) || isset($_GET['fechainicio'])){
        $numoficio = $_GET['numOficio'];
        $fechainicio = $_GET['fechainicio'];
        $fechafin = $_GET['fechafin'];
    ?>
        <!-- Vista Previa del Documento Generado -->
        <div class="cd-card-section">
            <div class="cd-card-header cd-card-header-gold">
                <h3 class="cd-card-title">
                    <i class="fa-solid fa-file-pdf"></i> Vista Previa del Oficio Generado
                </h3>
            </div>
            <div class="cd-card-body" style="padding:0;">
                <iframe src="md_reportePago1.php?numoficio=<?php echo urlencode($numoficio); ?>&fechainicio=<?php echo urlencode($fechainicio); ?>&fechafin=<?php echo urlencode($fechafin); ?>" 
                style="width:100%; height:750px; border:none; border-radius: 0 0 var(--cd-radius-md) var(--cd-radius-md);"></iframe>
            </div>
        </div>
    <?php
    }
    ?>
</div>

<?php 
} else {
    mensaje("No tiene acceso a ".$id_aplicacion,'');
}
include ("./lib/body_footer.php"); 
?>