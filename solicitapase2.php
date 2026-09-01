<?php
require("config.php");
require("lib/funciones.php");

$nitavu = $_POST['usuario'];
$Widget_contenido = "";

$salida = comida_salida($nitavu);

if ($salida == FALSE) {
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
    // Status Layout
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

echo $Widget_contenido;
?>