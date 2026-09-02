<?php
//include (".//seguridad.php");
include("./lib/body_head.php");
include("./lib/body_menu.php");
// contenido:
$id_aplicacion = 'ap04';
?>

<style>
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap');

    /* Global Container Setup */
    .ausencia-container {
        font-family: 'Inter', sans-serif;
        width: 100%;
        max-width: 960px;
        margin: 0 auto;
        padding: 20px 15px 40px 15px;
        color: #1e293b;
        box-sizing: border-box;
    }

    /* Hero Welcome Card */
    .ausencia-hero-card {
        background: #ffffff;
        border-radius: 16px;
        border: 1px solid rgba(226, 232, 240, 0.8);
        box-shadow: 0 10px 30px -5px rgba(0, 0, 0, 0.05);
        padding: 32px;
        margin-bottom: 30px;
        display: flex;
        align-items: center;
        gap: 32px;
        box-sizing: border-box;
        width: 100%;
    }

    @media (max-width: 768px) {
        .ausencia-hero-card {
            flex-direction: column-reverse;
            gap: 24px;
            padding: 24px;
        }
    }

    .ausencia-hero-text {
        flex: 1;
        display: flex;
        flex-direction: column;
    }

    .ausencia-hero-title {
        font-size: 24px;
        font-weight: 700;
        color: #0f172a;
        margin: 0 0 12px 0;
        letter-spacing: -0.5px;
    }

    .ausencia-hero-description {
        font-size: 14.5px;
        color: #475569;
        line-height: 1.6;
        margin: 0 0 20px 0;
    }

    .ausencia-steps {
        display: flex;
        flex-direction: column;
        gap: 10px;
    }

    .ausencia-step-item {
        display: flex;
        align-items: center;
        gap: 10px;
        font-size: 13.5px;
        color: #334155;
        font-weight: 500;
    }

    .ausencia-step-number {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 22px;
        height: 22px;
        border-radius: 50%;
        background-color: #fdf2f2;
        color: #7c121d;
        font-size: 11px;
        font-weight: 700;
        flex-shrink: 0;
    }

    .ausencia-hero-image {
        width: 240px;
        flex-shrink: 0;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    @media (max-width: 768px) {
        .ausencia-hero-image {
            width: 100%;
            max-width: 280px;
        }
    }

    .ausencia-hero-image img {
        width: 100%;
        height: auto;
        border-radius: 12px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
        object-fit: cover;
    }

    /* Form Card styling */
    .ausencia-form-card {
        background: #ffffff;
        border-radius: 16px;
        border: 1px solid rgba(226, 232, 240, 0.8);
        box-shadow: 0 10px 30px -5px rgba(0, 0, 0, 0.05), 0 8px 15px -6px rgba(0, 0, 0, 0.05);
        padding: 32px;
        margin-bottom: 30px;
        box-sizing: border-box;
        width: 100%;
    }

    .ausencia-form-card-title {
        font-size: 19px;
        font-weight: 700;
        color: #0f172a;
        margin-bottom: 24px;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .ausencia-form-card-title i {
        color: #7c121d;
    }

    /* Grid Row */
    .ausencia-form-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 20px;
        margin-bottom: 24px;
        width: 100%;
        box-sizing: border-box;
    }

    @media (max-width: 640px) {
        .ausencia-form-row {
            grid-template-columns: 1fr;
            gap: 16px;
        }
    }

    /* Input Styling - prefixed to prevent FormElement.css collision */
    .ausencia-form-group {
        display: flex !important;
        flex-direction: column !important;
        gap: 8px !important;
        width: 100% !important;
        box-sizing: border-box !important;
        padding: 0 !important;
    }

    .ausencia-form-group label {
        font-size: 14px;
        font-weight: 600;
        color: #475569;
        margin: 0;
    }

    .ausencia-input-wrapper {
        position: relative;
        display: flex;
        align-items: center;
        width: 100%;
        box-sizing: border-box;
    }

    .ausencia-input-wrapper i {
        position: absolute;
        left: 14px;
        color: #94a3b8;
        font-size: 16px;
        pointer-events: none;
    }

    .ausencia-input-wrapper input[type="date"],
    .ausencia-input-wrapper input[type="time"],
    .ausencia-input-wrapper input[type="text"] {
        width: 100% !important;
        padding: 12px 14px 12px 42px !important;
        border: 1.5px solid #cbd5e1 !important;
        border-radius: 10px !important;
        font-size: 15px !important;
        color: #334155 !important;
        background-color: #f8fafc !important;
        outline: none !important;
        transition: all 0.2s ease !important;
        box-sizing: border-box !important;
        display: block !important;
    }

    .ausencia-input-wrapper input:focus,
    .ausencia-textarea-wrapper textarea:focus {
        border-color: #7c121d !important;
        background-color: #ffffff !important;
        box-shadow: 0 0 0 4px rgba(124, 18, 29, 0.1) !important;
    }

    /* Textarea Styling */
    .ausencia-textarea-wrapper {
        position: relative;
        width: 100%;
        box-sizing: border-box;
    }

    .ausencia-textarea-wrapper i {
        position: absolute;
        left: 14px;
        top: 14px;
        color: #94a3b8;
        font-size: 16px;
        pointer-events: none;
    }

    .ausencia-textarea-wrapper textarea {
        width: 100% !important;
        height: 144px;
        min-height: 144px;
        padding: 12px 14px 12px 42px !important;
        border: 1.5px solid #cbd5e1 !important;
        border-radius: 10px !important;
        font-size: 15px !important;
        color: #334155 !important;
        background-color: #f8fafc !important;
        outline: none !important;
        resize: vertical !important;
        transition: all 0.2s ease !important;
        box-sizing: border-box !important;
        display: block !important;
    }

    /* Card Selectors for Permit Types */
    .ausencia-permit-label {
        font-size: 14px;
        font-weight: 600;
        color: #475569;
        margin-bottom: 12px;
        display: block;
    }

    .ausencia-permit-cards-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
        gap: 16px;
        margin-bottom: 24px;
        width: 100%;
        box-sizing: border-box;
    }

    .ausencia-permit-card {
        position: relative;
        display: block;
        cursor: pointer;
        border: 2px solid #e2e8f0;
        border-radius: 12px;
        padding: 16px;
        background: #f8fafc;
        transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
        user-select: none;
        box-sizing: border-box;
    }

    .ausencia-permit-card:hover:not(.disabled) {
        border-color: #cbd5e1;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
    }

    .ausencia-permit-card input[type="radio"] {
        position: absolute;
        opacity: 0;
        width: 0;
        height: 0;
    }

    .ausencia-permit-card:has(input[type="radio"]:checked) {
        border-color: #7c121d;
        background-color: #fdf2f2;
        box-shadow: 0 0 0 1px #7c121d;
    }

    .ausencia-card-content {
        display: flex;
        align-items: center;
        gap: 14px;
        width: 100%;
    }

    .ausencia-icon-wrapper {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 42px;
        height: 42px;
        border-radius: 10px;
        background-color: #e2e8f0;
        color: #475569;
        font-size: 18px;
        transition: all 0.2s ease;
        flex-shrink: 0;
    }

    .ausencia-permit-card:has(input[type="radio"]:checked) .ausencia-icon-wrapper {
        background-color: #7c121d;
        color: #ffffff;
    }

    .ausencia-card-info {
        display: flex;
        flex-direction: column;
        flex-grow: 1;
    }

    .ausencia-card-title {
        font-weight: 600;
        font-size: 14.5px;
        color: #1e293b;
    }

    .ausencia-card-desc {
        font-size: 12px;
        color: #64748b;
        margin-top: 2px;
    }

    /* Disabled permit card state */
    .ausencia-permit-card.disabled {
        opacity: 0.6;
        cursor: not-allowed;
        background-color: #f1f5f9;
        border-color: #e2e8f0;
    }

    .ausencia-badge-used {
        background-color: #fee2e2;
        color: #ef4444;
        font-size: 11px;
        font-weight: 600;
        padding: 4px 8px;
        border-radius: 20px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        flex-shrink: 0;
    }

    /* Tip Alert Box */
    .ausencia-tip-box {
        display: flex;
        align-items: center;
        gap: 12px;
        background-color: #fffbeb;
        border-left: 4px solid #f59e0b;
        padding: 14px 16px;
        border-radius: 0 10px 10px 0;
        margin-bottom: 24px;
        font-size: 13.5px;
        color: #b45309;
        line-height: 1.5;
        box-sizing: border-box;
        width: 100%;
    }

    .ausencia-tip-box i {
        font-size: 18px;
        color: #f59e0b;
        flex-shrink: 0;
    }

    /* Submit Button styling */
    .ausencia-btn-submit {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        width: 100%;
        padding: 14px;
        background: linear-gradient(135deg, #7c121d 0%, #a21a24 100%);
        color: #ffffff;
        border: none;
        border-radius: 10px;
        font-size: 16px;
        font-weight: 600;
        cursor: pointer;
        box-shadow: 0 4px 14px rgba(124, 18, 29, 0.35);
        transition: all 0.25s ease;
    }

    .ausencia-btn-submit:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(124, 18, 29, 0.45);
        background: linear-gradient(135deg, #8c1924 0%, #b22631 100%);
    }

    .ausencia-btn-submit:active {
        transform: translateY(0);
    }

    /* History Card & Table Styling */
    .ausencia-history-card {
        background: #ffffff;
        border-radius: 16px;
        border: 1px solid rgba(226, 232, 240, 0.8);
        box-shadow: 0 10px 30px -5px rgba(0, 0, 0, 0.05);
        padding: 32px;
        margin-top: 30px;
        width: 100%;
        box-sizing: border-box;
    }

    .ausencia-history-card-title {
        font-size: 18px;
        font-weight: 700;
        color: #0f172a;
        margin-bottom: 20px;
        display: flex;
        align-items: center;
        gap: 8px;
        border-bottom: 2px solid #f1f5f9;
        padding-bottom: 14px;
    }

    .ausencia-history-card-title i {
        color: #7c121d;
    }

    /* Styles overlaying the table generated by pase_estado */
    .ausencia-history-card .normal.bold.grande {
        font-size: 14px !important;
        font-weight: 600 !important;
        color: #475569 !important;
        margin-bottom: 16px !important;
    }

    .ausencia-history-card .tabla {
        width: 100% !important;
        border-collapse: separate !important;
        border-spacing: 0 !important;
        margin-top: 10px !important;
        border-radius: 10px !important;
        overflow: hidden !important;
        border: 1px solid #e2e8f0 !important;
    }

    .ausencia-history-card .tabla_titulo {
        background-color: #f8fafc !important;
    }

    .ausencia-history-card .tabla_titulo td {
        padding: 14px 16px !important;
        font-weight: 600 !important;
        color: #475569 !important;
        font-size: 12px !important;
        text-transform: uppercase !important;
        letter-spacing: 0.5px !important;
        border-bottom: 2px solid #e2e8f0 !important;
    }

    .ausencia-history-card .tabla_tr {
        border-bottom: 1px solid #e2e8f0 !important;
        transition: background-color 0.2s ease !important;
    }

    .ausencia-history-card .tabla_tr td {
        padding: 16px !important;
        color: #334155 !important;
        font-size: 13.5px !important;
        line-height: 1.5 !important;
        vertical-align: top !important;
        border-bottom: 1px solid #f1f5f9 !important;
    }

    .ausencia-history-card .tabla_tr:last-child td {
        border-bottom: none !important;
    }

    .ausencia-history-card .tabla_tr:hover {
        background-color: #f8fafc !important;
    }

    /* Override inline styles on rows */
    .ausencia-history-card .tabla_tr[style*="background-color:red"] {
        background-color: #fef2f2 !important;
        border-left: 4px solid #ef4444 !important;
    }

    .ausencia-history-card .tabla_tr[style*="background-color:cyan"] {
        background-color: #ecfeff !important;
        border-left: 4px solid #06b6d4 !important;
    }

    .ausencia-history-card .tabla_tr:not([style]) {
        border-left: 4px solid #e2e8f0 !important;
    }

    .ausencia-history-card b {
        color: #0f172a !important;
        font-weight: 600 !important;
    }

    .ausencia-history-card hr {
        border: none !important;
        border-top: 1px solid #e2e8f0 !important;
        margin: 8px 0 !important;
    }

    .ausencia-history-card .alerta.bold {
        color: #ef4444 !important;
        background-color: #fee2e2 !important;
        padding: 3px 8px !important;
        border-radius: 6px !important;
        font-size: 11px !important;
        font-weight: 700 !important;
        text-transform: uppercase !important;
        display: inline-block !important;
        margin-bottom: 4px !important;
    }

    .ausencia-history-card .normal.bold {
        color: #475569 !important;
        font-weight: 600 !important;
    }
</style>

<!-- Header Banner: Placed OUTSIDE container to preserve default platform styling and position -->
<div id='AppDetalle'>
    <?php echo app_detalle($id_aplicacion, $nitavu); ?>
</div>

<div class="ausencia-container">

    <!-- Welcome Hero Card with Illustration -->
    <div class="ausencia-hero-card">
        <div class="ausencia-hero-text">
            <h1 class="ausencia-hero-title">Permisos de Ausencia Temporal</h1>
            <p class="ausencia-hero-description">
                Esta herramienta permite al personal solicitar y registrar sus pases de salida temporal (comida, asuntos
                oficiales o personales) de manera digital. Al enviar la solicitud, tu jefe directo recibirá una
                notificación para autorizar tu pase de forma rápida y sencilla.
            </p>
            <div class="ausencia-steps">
                <div class="ausencia-step-item">
                    <span class="ausencia-step-number">1</span>
                    <span>Selecciona la fecha y hora de salida.</span>
                </div>
                <div class="ausencia-step-item">
                    <span class="ausencia-step-number">2</span>
                    <span>Elige tu tipo de permiso.</span>
                </div>
                <div class="ausencia-step-item">
                    <span class="ausencia-step-number">3</span>
                    <span>Justifica detalladamente y envía tu solicitud.</span>
                </div>
            </div>
        </div>
        <div class="ausencia-hero-image">
            <img src="img/banner_ausencia.png" alt="Gestión de Salidas" />
        </div>
    </div>

    <!-- Form Section -->
    <div class="ausencia-form-card">
        <h1 class="ausencia-hero-title">Nueva Solicitud de Pase de Salida</h1>

        <form id="form_ausencia" name="form1" method="post" action="auscencia4.php">

            <?php
            $varfecha = $fecha;
            if (isset($_GET['fecha2'])) {
                $varfecha = $_GET['fecha2'];
            }
            ?>

            <div class="ausencia-form-row">
                <!-- Date Picker -->
                <div class="ausencia-form-group">
                    <label for="fecha">Fecha del Permiso</label>
                    <div class="ausencia-input-wrapper">
                        <i class="fa-regular fa-calendar"></i>
                        <input type="date" name="fecha" id="fecha" value="<?php echo $varfecha; ?>"
                            onchange="auscencia_fecha()" required />
                    </div>
                </div>

                <!-- Time Picker -->
                <div class="ausencia-form-group">
                    <label for="oficial_hr_salida">Hora de Salida</label>
                    <div class="ausencia-input-wrapper">
                        <i class="fa-regular fa-clock"></i>
                        <?php
                        $horasalida = date('H:i:s', strtotime('+60 minute', strtotime($hora)));
                        ?>
                        <input type="time" name="oficial_hr_salida" id="oficial_hr_salida"
                            value="<?php echo $horasalida; ?>" step="1" required />
                    </div>
                </div>
            </div>

            <!-- Permit Types selection -->
            <span class="ausencia-permit-label">Seleccione el Tipo de Permiso</span>
            <div class="ausencia-permit-cards-grid">
                <?php
                $p = comida_salida2($nitavu, $varfecha);
                ?>

                <!-- Lunch option -->
                <label class="ausencia-permit-card <?php echo ($p != FALSE) ? 'disabled' : ''; ?>" for="comida">
                    <input type="radio" id="comida" name="tipopase" value="COMIDA" <?php echo ($p == FALSE) ? 'checked' : 'disabled'; ?> />
                    <div class="ausencia-card-content">
                        <div class="ausencia-icon-wrapper">
                            <i class="fa-solid fa-utensils"></i>
                        </div>
                        <div class="ausencia-card-info">
                            <span class="ausencia-card-title">Almuerzo / Comida</span>
                            <span class="ausencia-card-desc">Tiempo de comida asignado</span>
                        </div>
                        <?php if ($p != FALSE) { ?>
                            <span class="ausencia-badge-used">Ya usado</span>
                        <?php } ?>
                    </div>
                </label>

                <!-- Official Business option -->
                <label class="ausencia-permit-card" for="oficial">
                    <input type="radio" id="oficial" name="tipopase" value="OFICIAL" <?php echo ($p != FALSE) ? 'checked' : ''; ?> />
                    <div class="ausencia-card-content">
                        <div class="ausencia-icon-wrapper">
                            <i class="fa-solid fa-briefcase"></i>
                        </div>
                        <div class="ausencia-card-info">
                            <span class="ausencia-card-title">Comisión Oficial</span>
                            <span class="ausencia-card-desc">Asuntos externos de trabajo</span>
                        </div>
                    </div>
                </label>

                <!-- Personal option -->
                <label class="ausencia-permit-card" for="personal">
                    <input type="radio" id="personal" name="tipopase" value="OTRO" />
                    <div class="ausencia-card-content">
                        <div class="ausencia-icon-wrapper">
                            <i class="fa-solid fa-user"></i>
                        </div>
                        <div class="ausencia-card-info">
                            <span class="ausencia-card-title">Asunto Personal</span>
                            <span class="ausencia-card-desc">Asuntos particulares</span>
                        </div>
                    </div>
                </label>
            </div>

            <!-- Justification -->
            <div class="ausencia-form-group" style="margin-bottom: 24px;">
                <label for="justificacion">Justificación o Motivo</label>
                <div class="ausencia-textarea-wrapper">
                    <i class="fa-regular fa-pen-to-square"></i>
                    <textarea name="justificacion" id="justificacion"
                        placeholder="Describa el motivo detallado de su salida..." required></textarea>
                </div>
            </div>

            <!-- Tips & Authorized Time Info Box -->
            <div class="ausencia-tip-box">
                <i class="fa-solid fa-circle-info"></i>
                <span>Recuerde: su tiempo autorizado de comida es de
                    <strong><?php echo comida_aut($nitavu); ?></strong>. Por favor, realice su trámite con anticipación
                    para su oportuna revisión.</span>
            </div>

            <!-- Submit Button -->
            <button type="submit" name="submit_pases" class="ausencia-btn-submit">
                <i class="fa-solid fa-paper-plane"></i> Enviar Solicitud de Pase
            </button>
        </form>
    </div>

    <!-- History / Status section -->
    <div class="ausencia-history-card">
        <h2 class="ausencia-history-card-title">
            <i class="fa-solid fa-clock-rotate-left"></i> Estado de Solicitudes Recientes
        </h2>
        <?php
        echo pase_estado($nitavu, $varfecha, $varfecha, "FALSE");
        ?>
    </div>
</div>

<?php
//GUARDAR----
if (isset($_POST['submit_pases'])) {
    //GUARDAR solicitud de salida oficial
    $fecha_ = $_POST['fecha'];
    $hr_salida = date("H:i:s", strtotime($_POST['oficial_hr_salida']));
    $npase = npase(FALSE);
    $justificacion = $_POST['justificacion'];
    $dpto = nitavu_dpto($nitavu);
    $empleado = $nitavu;
    $msg = "";
    $resumen = "";

    $asunto = $_POST['tipopase'];

    $sql = "INSERT INTO empleados_salidas_temporal
            (id, nitavu, hora_desde, justificacion, asunto, fecha, dpto)
            VALUES
            ('$npase','$empleado', '$hr_salida', '$justificacion', '$asunto', '$fecha_','$dpto');";

    if ($conexion->query($sql) == TRUE) {
        $msg = $msg . "Pase Guardado con exito; Espere autorizacion.";
        $m = '<p>' . nitavu_nombre($empleado) . ' solicita usar el pase para ' . $justificacion . ' de ' . $asunto . ' para las ' . $hora . ' de ' . fecha_larga($fecha) . '</p><br><br><br> <P style=color:gray>Para aprobar entre a la plataforma, en la seccion: APROBAR SALIDAS.</P>
        <a style=background-color:#66FFFF;color:#006699;width:100%;padding:10px;border-style:solid;border-color:#006699;font-size:14pt;border-radius:5px; href=http://plataformaitavu.tamaulipas.gob.mx/auscencia_temporal_autoriza3.php target=_blank>Ir a APROBAR SALIDAS</a>';

        mensaje("Pase solicitado con exito, espere la notificación de aprobación.", 'auscencia4.php');
        $h = "" . nitavu_nombre($nitavu) . " (" . $nitavu . ") ha solicitado un pase de salida para <span class='tenue'>" . $justificacion . "</span>";
        $h = $h . "para el dia " . $fecha_ . ". <img src='" . $archivo . "'>";
        historia($nitavu, $h);
    } else {
        historia($nitavu, "ERROR | (" . $sql . ") al intentar guardar pase de salida");
        mensaje("Error :" . $sql, '');
    }
}
?>

<script>
    function auscencia_fecha() {
        var fechavar = document.getElementById("fecha").value;
        window.location.href = "auscencia4.php?pes=comida&n=&fecha2=" + fechavar;
    }
</script>

<?php
include("./lib/body_footer.php");
?>