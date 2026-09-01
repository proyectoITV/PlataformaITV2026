<?php
$Widget_nombre = "Cumpleaños de esta semana";
$wc = "";
$empleados_sindpto_quienes = "";

// Obtiene el primer dia de la semana en curso y se proyectan los siguientes 7 dias
$r = $conexion->query('SELECT DATE(DATE_ADD(NOW(), INTERVAL - WEEKDAY(NOW()) DAY)) primerdia;');
while ($f = $r->fetch_array()) {
    $dia1 = strtotime($f['primerdia']);
    $dia2 = strtotime('+1 day', strtotime($f['primerdia']));
    $dia3 = strtotime('+2 day', strtotime($f['primerdia']));
    $dia4 = strtotime('+3 day', strtotime($f['primerdia']));
    $dia5 = strtotime('+4 day', strtotime($f['primerdia']));
    $dia6 = strtotime('+5 day', strtotime($f['primerdia']));
    $dia7 = strtotime('+6 day', strtotime($f['primerdia']));
}

$sql = "
    SELECT * from empleados where estado = '' and 
    (
        month(fecha_nacimiento) = '" . date("m", $dia1) . "' and day(fecha_nacimiento) = '" . date("d", $dia1) . "'
        or 
        month(fecha_nacimiento) = '" . date("m", $dia2) . "' and day(fecha_nacimiento) = '" . date("d", $dia2) . "'
        or 
        month(fecha_nacimiento) = '" . date("m", $dia3) . "' and day(fecha_nacimiento) = '" . date("d", $dia3) . "'
        or 
        month(fecha_nacimiento) = '" . date("m", $dia4) . "' and day(fecha_nacimiento) = '" . date("d", $dia4) . "'
        or 
        month(fecha_nacimiento) = '" . date("m", $dia5) . "' and day(fecha_nacimiento) = '" . date("d", $dia5) . "'
        or 
        month(fecha_nacimiento) = '" . date("m", $dia6) . "' and day(fecha_nacimiento) = '" . date("d", $dia6) . "'
        or 
        month(fecha_nacimiento) = '" . date("m", $dia7) . "' and day(fecha_nacimiento) = '" . date("d", $dia7) . "'
    )
    ORDER BY  month(fecha_nacimiento), day(fecha_nacimiento), nombre
    ";

$r = $conexion->query($sql);
$has_cumples = false;

while ($f = $r->fetch_array()) {
    $has_cumples = true;
    $fecha_cumple = date('Y') . substr($f['fecha_nacimiento'], 4);

    if ($fecha_cumple >= $fecha) {
        $dep_name = isset($f['departamento']) ? $f['departamento'] : '';
        $dep_clean = str_replace(
            array('á', 'é', 'í', 'ó', 'ú', 'Á', 'É', 'Í', 'Ó', 'Ú'),
            array('a', 'e', 'i', 'o', 'u', 'a', 'e', 'i', 'o', 'u'),
            strtolower($dep_name)
        );
        $es_informatica = (
            in_array($f['nitavu'], [1308, 1733, 1739, 2269, 2330, 2933]) ||
            (strpos($dep_clean, 'informatica') !== false) ||
            (isset($f['dpto']) && $f['dpto'] == 55)
        );

        $is_today = ($fecha_cumple == $fecha);
        $row_class = "widget-cumples-row";
        if ($is_today) {
            $row_class .= " today";
        }
        if ($es_informatica) {
            $row_class .= " cumples-informatica";
        }

        $wc = $wc . '<div class="' . $row_class . '">';

        if ($es_informatica) {
            $wc = $wc . '<div class="sparkle-container">
                    <span class="sparkle s1">✨</span>
                    <span class="sparkle s2">✦</span>
                    <span class="sparkle s3">✨</span>
                    <span class="sparkle s4">✦</span>
                </div>';
            $wc = $wc . '<div class="code-backdrop">&lt;code&gt;<br>Happy_Bday();<br>&lt;/code&gt;</div>';
        }

        $photo_url = "fotos/" . $f['nitavu'] . ".jpg";
        $photo_html = ponerfoto($photo_url, 'widget-cumples-photo');

        $wc = $wc . "<div class='widget-cumples-row-content'>";
        $wc = $wc . "<div class='widget-cumples-photo-wrapper'>" . $photo_html . "</div>";
        $wc = $wc . "<div class='widget-cumples-info'>";
        $wc = $wc . "<span class='widget-cumples-name'>" . strtoupper($f['nombre']) . "</span>";
        $wc = $wc . "<span class='widget-cumples-dept'>" . $f['departamento'] . "</span>";
        $wc = $wc . "<span class='widget-cumples-date'><i class='fa-regular fa-calendar'></i> " . fecha_larga($fecha_cumple) . "</span>";

        if ($es_informatica) {
            $wc = $wc . "
                <div class='widget-cumples-congrats'>
                    <img class='animated-cake' src='icon/pastel.png' width='36' height='36' />
                    <div class='widget-cumples-congrats-text'>
                        <span class='widget-cumples-congrats-title'>¡Muchas FELICIDADES!</span>
                        <span class='widget-cumples-congrats-desc'>Que pases un excelente día. Un fuerte abrazo del equipo de Informática. 💻✨</span>
                    </div>
                </div>";
        }
        $wc = $wc . '</div>'; // .widget-cumples-info
        $wc = $wc . '</div>'; // .widget-cumples-row-content
        $wc = $wc . '</div>'; // .widget-cumples-row
    }
}

if (!$has_cumples) {
    $wc = $wc . "<div class='widget-cumples-empty'>";
    $wc = $wc . "<i class='fa-solid fa-cake-candles'></i>";
    $wc = $wc . "<span>No hay cumpleaños programados para esta semana.</span>";
    $wc = $wc . "</div>";
}
?>

<style>
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap');

    .widget-cumples-section {
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
    .widget-cumples-header {
        padding: 18px 20px !important;
        border-bottom: 1.5px solid #f1f5f9 !important;
        background-color: #ffffff !important;
    }
    .widget-cumples-title {
        font-size: 15px !important;
        font-weight: 700 !important;
        color: #0f172a !important;
        display: flex !important;
        align-items: center !important;
        gap: 8px !important;
    }
    .widget-cumples-title i {
        color: #7c121d !important;
        font-size: 16px !important;
    }
    .widget-cumples-body {
        padding: 12px 20px !important;
        box-sizing: border-box !important;
        width: 100% !important;
        max-height: 480px !important;
        overflow-y: auto !important;
    }
    
    /* Birthday Rows */
    .widget-cumples-row {
        position: relative !important;
        padding: 16px 0 !important;
        border-bottom: 1px solid #f1f5f9 !important;
        box-sizing: border-box !important;
        width: 100% !important;
    }
    .widget-cumples-row:last-child {
        border-bottom: none !important;
    }
    .widget-cumples-row-content {
        display: flex !important;
        align-items: flex-start !important;
        gap: 14px !important;
        width: 100% !important;
    }
    .widget-cumples-photo-wrapper {
        flex-shrink: 0 !important;
    }
    .widget-cumples-photo {
        width: 48px !important;
        height: 48px !important;
        border-radius: 50% !important;
        object-fit: cover !important;
        border: 2px solid #e2e8f0 !important;
        box-shadow: 0 2px 5px rgba(0,0,0,0.05) !important;
    }
    .widget-cumples-info {
        display: flex !important;
        flex-direction: column !important;
        gap: 4px !important;
        flex-grow: 1 !important;
    }
    .widget-cumples-name {
        font-size: 13px !important;
        font-weight: 700 !important;
        color: #0f172a !important;
        line-height: 1.3 !important;
    }
    .widget-cumples-dept {
        font-size: 11.5px !important;
        color: #64748b !important;
        line-height: 1.3 !important;
    }
    .widget-cumples-date {
        font-size: 11px !important;
        color: #7c121d !important;
        font-weight: 600 !important;
        display: flex !important;
        align-items: center !important;
        gap: 4px !important;
        margin-top: 2px !important;
    }
    .widget-cumples-date i {
        font-size: 12px !important;
    }

    /* Today highlight */
    .widget-cumples-row.today {
        background-color: #fdf2f2 !important;
        border-radius: 8px !important;
        padding: 12px !important;
        margin: 6px 0 !important;
        border-left: 4px solid #7c121d !important;
        border-bottom: none !important;
    }
    .widget-cumples-row.today .widget-cumples-photo {
        border-color: #7c121d !important;
    }

    /* Informatica Special styling */
    .cumples-informatica {
        position: relative !important;
        overflow: hidden !important;
        border: 2.5px solid rgba(0, 180, 216, 0.4) !important;
        border-radius: 12px !important;
        background: linear-gradient(135deg, #ffffff 0%, #f0faff 100%) !important;
        padding: 14px !important;
        margin: 8px 0 !important;
        animation: glow-border 4s infinite ease-in-out !important;
    }
    .cumples-informatica.parpadear {
        background: linear-gradient(135deg, #e6fccf 0%, #c4f7b2 100%) !important;
    }
    .cumples-informatica::after {
        content: "" !important;
        position: absolute !important;
        top: 0 !important;
        height: 100% !important;
        width: 50% !important;
        background: linear-gradient(to right, rgba(255,255,255,0) 0%, rgba(255,255,255,0.7) 50%, rgba(255,255,255,0) 100%) !important;
        transform: skewX(-25deg) !important;
        animation: shimmer-sweep 3.5s infinite ease-in-out !important;
        pointer-events: none !important;
    }
    .widget-cumples-congrats {
        display: flex !important;
        align-items: flex-start !important;
        gap: 8px !important;
        margin-top: 8px !important;
        border-top: 1px dashed rgba(0, 180, 216, 0.2) !important;
        padding-top: 8px !important;
    }
    .widget-cumples-congrats-text {
        display: flex !important;
        flex-direction: column !important;
        gap: 2px !important;
    }
    .widget-cumples-congrats-title {
        font-size: 11px !important;
        font-weight: 700 !important;
        color: #0284c7 !important;
    }
    .widget-cumples-congrats-desc {
        font-size: 10.5px !important;
        color: #334155 !important;
        line-height: 1.4 !important;
    }

    /* Empty state styling */
    .widget-cumples-empty {
        display: flex !important;
        flex-direction: column !important;
        align-items: center !important;
        text-align: center !important;
        gap: 12px !important;
        padding: 24px 0 !important;
    }
    .widget-cumples-empty i {
        font-size: 28px !important;
        color: #94a3b8 !important;
    }
    .widget-cumples-empty span {
        font-size: 13px !important;
        color: #64748b !important;
    }
</style>

<section class="widget-cumples-section">
    <div class="widget-cumples-header">
        <span class="widget-cumples-title">
            <i class="fa-solid fa-cake-candles"></i> <?php echo $Widget_nombre; ?>
        </span>
    </div>
    <div class="widget-cumples-body">
        <?php echo $wc; ?>
    </div>
</section>