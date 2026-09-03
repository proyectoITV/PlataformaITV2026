<?php
// WIDGET PROTOTIPO - TIEMPO DE COMIDA

$Widget_nombre = "Tiempo de comida de hoy";
$Widget_contenido = "";

// Check for configuration issue (comida == 0)
$sql = "select nitavu, nombre, puesto, dpto, comida from empleados where empleados.comida = 0 AND nitavu='" . $nitavu . "'";
$rc = $conexion->query($sql);
if ($f = $rc->fetch_array()) {
    $Widget_contenido = $Widget_contenido . "<div class='widget-comida-error'>";
    $Widget_contenido = $Widget_contenido . "<i class='fa-solid fa-circle-exclamation'></i>";
    $Widget_contenido = $Widget_contenido . "<span class='widget-comida-error-text'>Hay un problema con tu tiempo de comida asignado. Por favor, comunícate con el Dpto. de Recursos Humanos para solucionarlo.</span>";
    $Widget_contenido = $Widget_contenido . "<a href='directorio.php?nombre=humanos' class='widget-comida-error-btn'><i class='fa-solid fa-address-book'></i> Directorio</a>";
    $Widget_contenido = $Widget_contenido . "</div>";
} else {
    $salida = comida_salida($nitavu);

    if ($salida == FALSE) {
        // Not left for lunch yet
        $Widget_contenido = $Widget_contenido . "<div class='widget-comida-form'>";
        $Widget_contenido = $Widget_contenido . "<div class='widget-comida-info-box'>";
        $Widget_contenido = $Widget_contenido . "<i class='fa-solid fa-circle-info'></i>";
        $Widget_contenido = $Widget_contenido . "<span><strong>Instrucciones:</strong> Registra tu hora de salida a comer. Al solicitar, tu jefe directo recibirá una notificación para autorizar tu pase de forma rápida y digital.</span>";
        $Widget_contenido = $Widget_contenido . "</div>";
        $Widget_contenido = $Widget_contenido . "<div class='widget-comida-input-group'>";
        $Widget_contenido = $Widget_contenido . "<label class='widget-comida-label'>¿A qué hora saldrás a comer?</label>";
        $Widget_contenido = $Widget_contenido . "<div class='widget-comida-input-wrapper'>";
        $Widget_contenido = $Widget_contenido . "<i class='fa-regular fa-clock'></i>";
        $Widget_contenido = $Widget_contenido . "<input type='time' name='oficial_hr_salida' id='oficial_hr_salida' value='" . date('H:i:s', strtotime($hora)) . "' step='1' required class='widget-comida-input' />";
        $Widget_contenido = $Widget_contenido . "</div>";
        $Widget_contenido = $Widget_contenido . "</div>";
        $Widget_contenido = $Widget_contenido . "<div class='widget-comida-action-group'>";
        $Widget_contenido = $Widget_contenido . "<span class='widget-comida-help'>Espere autorización</span>";
        $Widget_contenido = $Widget_contenido . "<button onclick='SolicitaPase(\"" . $nitavu . "\",\"COMIDA\");' class='widget-comida-btn'><i class='fa-solid fa-paper-plane'></i> Solicitar</button>";
        $Widget_contenido = $Widget_contenido . "</div>";
        $Widget_contenido = $Widget_contenido . "</div>";
        $Widget_contenido = $Widget_contenido . "<div class='widget-comida-footer'>";
        $Widget_contenido = $Widget_contenido . "<a href='auscencia4.php' class='widget-comida-link'>Personalizar pase de salida <i class='fa-solid fa-arrow-right-long'></i></a>";
        $Widget_contenido = $Widget_contenido . "</div>";
    } else {
        // Already left
        $pase_estado = comida_estado($nitavu);
        if ($pase_estado == TRUE) {
            $trestante = comida_trestante($nitavu);
            $Widget_contenido = $Widget_contenido . "<div class='widget-comida-status'>";

            if (substr($trestante, 0, 1) == '-') { // Delayed / Late
                $Widget_contenido = $Widget_contenido . "<div class='widget-comida-status-header'>";
                $Widget_contenido = $Widget_contenido . "<img src='icon/emo_triste.gif' class='widget-comida-emoji' />";
                $Widget_contenido = $Widget_contenido . "<div class='widget-comida-status-info'>";
                $Widget_contenido = $Widget_contenido . "<span class='widget-comida-status-tag red'>Retraso Detectado</span>";
                $Widget_contenido = $Widget_contenido . "<span class='widget-comida-status-text'>Te has retrasado <strong>" . abs(intval($trestante)) . " min</strong></span>";
                $Widget_contenido = $Widget_contenido . "</div>";
                $Widget_contenido = $Widget_contenido . "</div>";
            } else {
                $Widget_contenido = $Widget_contenido . "<div class='widget-comida-status-header'>";
                $Widget_contenido = $Widget_contenido . "<img src='icon/emo_cafe.gif' class='widget-comida-emoji' />";
                $Widget_contenido = $Widget_contenido . "<div class='widget-comida-status-info'>";

                if (substr($trestante, 0, 1) == '+') {
                    $Widget_contenido = $Widget_contenido . "<span class='widget-comida-status-tag green'>Pase Completado</span>";
                    $Widget_contenido = $Widget_contenido . "<span class='widget-comida-status-text'>Retorno registrado con éxito.</span>";
                } else if (substr($trestante, 0, 1) == '*') {
                    if (strpos($pase_estado, 'Esperando') !== false) {
                        $Widget_contenido = $Widget_contenido . "<span class='widget-comida-status-tag orange'>Pendiente de Autorizar</span>";
                    } else {
                        $Widget_contenido = $Widget_contenido . "<span class='widget-comida-status-tag green'>Disponible en Caseta</span>";
                    }
                    $Widget_contenido = $Widget_contenido . "<span class='widget-comida-status-text'>" . $pase_estado . "</span>";
                } else { // active lunch with minutes left
                    $Widget_contenido = $Widget_contenido . "<span class='widget-comida-status-tag blue'>En Almuerzo</span>";
                    $Widget_contenido = $Widget_contenido . "<span class='widget-comida-status-text'>Te quedan <strong>" . $trestante . "m</strong> de comida. Buen provecho!</span>";
                }

                $Widget_contenido = $Widget_contenido . "</div>";
                $Widget_contenido = $Widget_contenido . "</div>";
            }

            $Widget_contenido = $Widget_contenido . "<div class='widget-comida-status-footer-info'>";
            $Widget_contenido = $Widget_contenido . "<span>Tiempo autorizado: <strong>" . comida_aut($nitavu) . "</strong></span>";
            $Widget_contenido = $Widget_contenido . "</div>";
            $Widget_contenido = $Widget_contenido . "</div>";
            $Widget_contenido = $Widget_contenido . "<div class='widget-comida-footer'>";
            $Widget_contenido = $Widget_contenido . "<a href='auscencia4.php' class='widget-comida-link'>Personalizar pase de salida <i class='fa-solid fa-arrow-right-long'></i></a>";
            $Widget_contenido = $Widget_contenido . "</div>";
        } else {
            $Widget_contenido = $Widget_contenido . "<div class='widget-comida-status'>";
            $Widget_contenido = $Widget_contenido . "<div class='widget-comida-status-header'>";
            $Widget_contenido = $Widget_contenido . "<div class='widget-comida-status-info'>";
            $Widget_contenido = $Widget_contenido . "<span class='widget-comida-status-tag gray'>Estado</span>";
            $Widget_contenido = $Widget_contenido . "<span class='widget-comida-status-text'>" . $pase_estado . "</span>";
            $Widget_contenido = $Widget_contenido . "</div>";
            $Widget_contenido = $Widget_contenido . "</div>";
            $Widget_contenido = $Widget_contenido . "</div>";
            $Widget_contenido = $Widget_contenido . "<div class='widget-comida-footer'>";
            $Widget_contenido = $Widget_contenido . "<a href='auscencia4.php' class='widget-comida-link'>Personalizar pase de salida <i class='fa-solid fa-arrow-right-long'></i></a>";
            $Widget_contenido = $Widget_contenido . "</div>";
        }
    }
}
?>

<style>
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap');

    .widget-comida-section {
        font-family: 'Inter', sans-serif !important;
        background: #ffffff !important;
        border-radius: 16px !important;
        border: 1.5px solid #bc955c !important;
        box-shadow: 0 10px 25px -5px rgba(188, 149, 92, 0.05) !important;
        width: 345px !important;
        box-sizing: border-box !important;
        margin: 10px !important;
        display: inline-block !important;
        vertical-align: top !important;
        text-align: left !important;
        overflow: hidden !important;
    }

    .widget-comida-header {
        padding: 18px 20px !important;
        border-bottom: 1.5px solid #f1f5f9 !important;
        background-color: #ffffff !important;
    }

    .widget-comida-title {
        font-size: 15px !important;
        font-weight: 700 !important;
        color: #0f172a !important;
        display: flex !important;
        align-items: center !important;
        gap: 8px !important;
    }

    .widget-comida-title i {
        color: #7c121d !important;
        font-size: 16px !important;
    }

    .widget-comida-body {
        padding: 20px !important;
        box-sizing: border-box !important;
        width: 100% !important;
    }

    .widget-comida-body-alt {
        padding: 0 20px 20px 20px !important;
        box-sizing: border-box !important;
        width: 100% !important;
    }

    .widget-comida-preloader {
        padding: 20px !important;
        text-align: center !important;
        width: 100% !important;
        box-sizing: border-box !important;
    }

    .widget-comida-preloader img {
        width: 48px !important;
        height: auto !important;
    }

    /* Form Styles */
    .widget-comida-form {
        display: flex !important;
        flex-direction: column !important;
        gap: 16px !important;
        width: 100% !important;
        box-sizing: border-box !important;
    }

    .widget-comida-input-group {
        display: flex !important;
        flex-direction: column !important;
        gap: 8px !important;
        width: 100% !important;
    }

    .widget-comida-label {
        font-size: 13px !important;
        font-weight: 600 !important;
        color: #475569 !important;
        margin: 0 !important;
    }

    .widget-comida-input-wrapper {
        position: relative !important;
        display: flex !important;
        align-items: center !important;
        width: 100% !important;
    }

    .widget-comida-input-wrapper i {
        position: absolute !important;
        left: 12px !important;
        color: #94a3b8 !important;
        font-size: 14px !important;
        pointer-events: none !important;
    }

    .widget-comida-input {
        width: 100% !important;
        padding: 10px 12px 10px 36px !important;
        border: 1.5px solid #cbd5e1 !important;
        border-radius: 8px !important;
        font-size: 14px !important;
        color: #334155 !important;
        background-color: #f8fafc !important;
        outline: none !important;
        transition: all 0.2s ease !important;
        box-sizing: border-box !important;
        display: block !important;
        font-family: 'Inter', sans-serif !important;
    }

    .widget-comida-input:focus {
        border-color: #7c121d !important;
        background-color: #ffffff !important;
        box-shadow: 0 0 0 3px rgba(124, 18, 29, 0.1) !important;
    }

    .widget-comida-action-group {
        display: flex !important;
        align-items: center !important;
        justify-content: space-between !important;
        gap: 12px !important;
        width: 100% !important;
    }

    .widget-comida-help {
        font-size: 12px !important;
        color: #64748b !important;
        font-weight: 500 !important;
    }

    .widget-comida-btn {
        display: inline-flex !important;
        align-items: center !important;
        justify-content: center !important;
        gap: 6px !important;
        padding: 10px 16px !important;
        background: linear-gradient(135deg, #7c121d 0%, #a21a24 100%) !important;
        color: #ffffff !important;
        border: none !important;
        border-radius: 8px !important;
        font-size: 13px !important;
        font-weight: 600 !important;
        cursor: pointer !important;
        box-shadow: 0 2px 8px rgba(124, 18, 29, 0.25) !important;
        transition: all 0.2s ease !important;
        font-family: 'Inter', sans-serif !important;
    }

    .widget-comida-btn:hover {
        transform: translateY(-1px) !important;
        box-shadow: 0 4px 12px rgba(124, 18, 29, 0.35) !important;
        background: linear-gradient(135deg, #8c1924 0%, #b22631 100%) !important;
    }

    .widget-comida-btn:active {
        transform: translateY(0) !important;
    }

    /* Footer styling */
    .widget-comida-footer {
        margin-top: 16px !important;
        border-top: 1.5px dashed #e2e8f0 !important;
        padding-top: 12px !important;
        text-align: right !important;
        width: 100% !important;
    }

    .widget-comida-link {
        font-size: 12.5px !important;
        color: #7c121d !important;
        text-decoration: none !important;
        font-weight: 600 !important;
        display: inline-flex !important;
        align-items: center !important;
        gap: 6px !important;
        padding: 6px 12px !important;
        border-radius: 8px !important;
        transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1) !important;
    }

    .widget-comida-link:hover {
        color: #7c121d !important;
        background-color: rgba(124, 18, 29, 0.06) !important;
    }

    .widget-comida-link i {
        font-size: 11px !important;
        transition: transform 0.2s ease !important;
    }

    .widget-comida-link:hover i {
        transform: translateX(4px) !important;
    }

    /* Status Layout */
    .widget-comida-status {
        display: flex !important;
        flex-direction: column !important;
        gap: 14px !important;
        width: 100% !important;
        box-sizing: border-box !important;
    }

    .widget-comida-status-header {
        display: flex !important;
        align-items: center !important;
        gap: 14px !important;
        width: 100% !important;
    }

    .widget-comida-emoji {
        width: 42px !important;
        height: 42px !important;
        border-radius: 50% !important;
        object-fit: cover !important;
        flex-shrink: 0 !important;
    }

    .widget-comida-status-info {
        display: flex !important;
        flex-direction: column !important;
        gap: 4px !important;
        flex-grow: 1 !important;
    }

    .widget-comida-status-tag {
        font-size: 10px !important;
        font-weight: 700 !important;
        text-transform: uppercase !important;
        letter-spacing: 0.5px !important;
        padding: 2px 6px !important;
        border-radius: 4px !important;
        width: max-content !important;
    }

    .widget-comida-status-tag.red {
        background-color: #fee2e2 !important;
        color: #ef4444 !important;
    }

    .widget-comida-status-tag.green {
        background-color: #dcfce7 !important;
        color: #22c55e !important;
    }

    .widget-comida-status-tag.blue {
        background-color: #e0f2fe !important;
        color: #0284c7 !important;
    }

    .widget-comida-status-tag.orange {
        background-color: #ffedd5 !important;
        color: #ea580c !important;
    }

    .widget-comida-status-tag.gray {
        background-color: #f1f5f9 !important;
        color: #64748b !important;
    }

    .widget-comida-status-text {
        font-size: 13px !important;
        color: #334155 !important;
        line-height: 1.4 !important;
    }

    .widget-comida-status-text strong {
        color: #0f172a !important;
        font-weight: 700 !important;
    }

    .widget-comida-status-footer-info {
        font-size: 12px !important;
        color: #64748b !important;
        background-color: #f8fafc !important;
        padding: 8px 12px !important;
        border-radius: 6px !important;
        border-left: 3.5px solid #cbd5e1 !important;
    }

    .widget-comida-status-footer-info strong {
        color: #334155 !important;
        font-weight: 600 !important;
    }

    /* Error Layout */
    .widget-comida-error {
        display: flex !important;
        flex-direction: column !important;
        align-items: center !important;
        text-align: center !important;
        gap: 12px !important;
        padding: 8px 0 !important;
    }

    .widget-comida-error i {
        font-size: 28px !important;
        color: #ef4444 !important;
    }

    .widget-comida-error-text {
        font-size: 12.5px !important;
        color: #475569 !important;
        line-height: 1.5 !important;
    }

    .widget-comida-error-btn {
        display: inline-flex !important;
        align-items: center !important;
        justify-content: center !important;
        gap: 6px !important;
        padding: 8px 14px !important;
        background-color: #fee2e2 !important;
        color: #ef4444 !important;
        border-radius: 6px !important;
        font-size: 12px !important;
        font-weight: 600 !important;
        text-decoration: none !important;
        transition: all 0.2s ease !important;
    }

    .widget-comida-error-btn:hover {
        background-color: #fecaca !important;
        color: #dc2626 !important;
    }

    .widget-comida-info-box {
        display: flex !important;
        align-items: flex-start !important;
        gap: 8px !important;
        background-color: #fdf2f2 !important;
        border: 1px solid #fecaca !important;
        border-radius: 8px !important;
        padding: 10px 12px !important;
        margin-bottom: 8px !important;
    }

    .widget-comida-info-box i {
        color: #7c121d !important;
        font-size: 14px !important;
        margin-top: 2px !important;
        flex-shrink: 0 !important;
    }

    .widget-comida-info-box span {
        font-size: 11.5px !important;
        color: #7c121d !important;
        line-height: 1.4 !important;
    }
</style>

<section class="widget-comida-section">
    <div class="widget-comida-header">
        <span class="widget-comida-title">
            <i class="fa-solid fa-utensils"></i> <?php echo $Widget_nombre; ?>
        </span>
    </div>

    <div id="preloader_comida" class="widget-comida-preloader" style="display:none;">
        <img src="img/cargando4.gif" alt="Cargando..." />
    </div>

    <div id="pase" class="widget-comida-body">
        <div id="datapase"></div>
        <?php echo $Widget_contenido; ?>
    </div>

    <div id="pase2" class="widget-comida-body-alt" style="display:none;"></div>
</section>

<script>
    function SolicitaPase(Nitavu, Asunto) {
        var Horadepase = $("#oficial_hr_salida").val();
        $("#preloader_comida").css('display', 'block');
        $("#pase").css('display', 'none');
        $.ajax({
            url: "solicitapase.php",
            type: "post",
            data: { asunto: Asunto, usuario: Nitavu, Horadepase: Horadepase },
            success: function (data) {
                $("#pase").css('display', 'block');
                $('#datapase').html(data + "\n");
                SolicitaPase2(Nitavu);
                $("#preloader_comida").css('display', 'none');
            }
        });
    }

    function SolicitaPase2(Nitavu) {
        $("#preloader_comida").css('display', 'block');
        $("#pase").css('display', 'none');
        $.ajax({
            url: "solicitapase2.php",
            type: "post",
            data: { usuario: Nitavu },
            success: function (data) {
                $("#pase").css('display', 'none');
                $("#pase2").css('display', 'block');
                $('#pase2').html(data + "\n");
                $("#preloader_comida").css('display', 'none');
            }
        });
    }
</script>