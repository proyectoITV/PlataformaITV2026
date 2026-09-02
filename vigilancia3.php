<?php
include ("./lib/body_head.php");
include ("./lib/body_menu.php");
?>

<style>
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap');

    .vigi-body {
        font-family: 'Inter', sans-serif !important;
        background-color: #f8fafc !important;
        padding: 24px !important;
        box-sizing: border-box !important;
        width: 100% !important;
        min-height: 100vh !important;
    }

    /* Dashboard Header */
    .vigi-dashboard-header {
        display: flex !important;
        justify-content: space-between !important;
        align-items: center !important;
        background: linear-gradient(135deg, #7c121d 0%, #4a070f 100%) !important;
        border-radius: 16px !important;
        padding: 20px 28px !important;
        color: #ffffff !important;
        margin-bottom: 28px !important;
        box-shadow: 0 10px 25px -5px rgba(124, 18, 29, 0.15) !important;
        flex-wrap: wrap !important;
        gap: 16px !important;
    }
    .vigi-header-left {
        display: flex !important;
        flex-direction: column !important;
        gap: 4px !important;
    }
    .vigi-subtitle {
        font-size: 11px !important;
        text-transform: uppercase !important;
        letter-spacing: 1px !important;
        color: #fca5a5 !important;
        font-weight: 600 !important;
    }
    .vigi-title {
        font-size: 20px !important;
        font-weight: 700 !important;
        color: #ffffff !important;
        margin: 0 !important;
    }
    
    /* Digital Clock Widget */
    .vigi-clock-card {
        display: flex !important;
        align-items: center !important;
        background-color: rgba(255, 255, 255, 0.1) !important;
        backdrop-filter: blur(10px) !important;
        padding: 10px 20px !important;
        border-radius: 12px !important;
        border: 1px solid rgba(255, 255, 255, 0.15) !important;
        gap: 12px !important;
    }
    .vigi-clock-time {
        font-size: 28px !important;
        font-weight: 700 !important;
        letter-spacing: 1.5px !important;
        color: #ffffff !important;
        display: flex !important;
        align-items: center !important;
        font-family: monospace !important;
    }
    .vigi-clock-sep {
        animation: vigi-pulse 1s infinite !important;
        padding: 0 2px !important;
        color: #fca5a5 !important;
    }
    @keyframes vigi-pulse {
        0%, 100% { opacity: 1; }
        50% { opacity: 0.3; }
    }
    .vigi-clock-ampm {
        background-color: #ffffff !important;
        color: #7c121d !important;
        padding: 4px 8px !important;
        border-radius: 6px !important;
        font-size: 12px !important;
        font-weight: 700 !important;
        font-family: 'Inter', sans-serif !important;
    }

    /* Main Grid Layout */
    .vigi-layout-grid {
        display: grid !important;
        grid-template-columns: 1fr 1fr !important;
        gap: 28px !important;
        width: 100% !important;
        box-sizing: border-box !important;
        margin-bottom: 36px !important;
    }
    @media (max-width: 1024px) {
        .vigi-layout-grid {
            grid-template-columns: 1fr !important;
        }
    }

    /* Column Styles */
    .vigi-column {
        display: flex !important;
        flex-direction: column !important;
        gap: 20px !important;
    }
    .vigi-column-title {
        font-size: 14px !important;
        font-weight: 700 !important;
        color: #0f172a !important;
        margin: 0 !important;
        display: flex !important;
        align-items: center !important;
        gap: 8px !important;
        text-transform: uppercase !important;
        letter-spacing: 0.5px !important;
    }
    .vigi-column-title.inside::before {
        content: "" !important;
        display: inline-block !important;
        width: 4px !important;
        height: 16px !important;
        background-color: #10b981 !important; /* Emerald */
        border-radius: 2px !important;
    }
    .vigi-column-title.outside::before {
        content: "" !important;
        display: inline-block !important;
        width: 4px !important;
        height: 16px !important;
        background-color: #ef4444 !important; /* Red */
        border-radius: 2px !important;
    }

    /* Card List Container */
    .vigi-card-list {
        background-color: #ffffff !important;
        border-radius: 16px !important;
        border: 1px solid #e2e8f0 !important;
        padding: 20px !important;
        display: flex !important;
        flex-direction: column !important;
        gap: 12px !important;
        min-height: 200px !important;
        box-shadow: 0 4px 6px -1px rgba(0,0,0,0.03) !important;
        box-sizing: border-box !important;
    }
    
    .vigi-card-list-header {
        font-size: 11px !important;
        font-weight: 700 !important;
        color: #64748b !important;
        border-bottom: 1.5px solid #f1f5f9 !important;
        padding-bottom: 8px !important;
        margin-bottom: 4px !important;
        text-transform: uppercase !important;
        letter-spacing: 0.5px !important;
    }

    /* Employee Card style */
    .vigi-card {
        display: flex !important;
        align-items: center !important;
        justify-content: space-between !important;
        background-color: #f8fafc !important;
        border-radius: 12px !important;
        border: 1.5px solid #e2e8f0 !important;
        padding: 12px 14px !important;
        gap: 12px !important;
        transition: all 0.2s ease !important;
        text-decoration: none !important;
        box-sizing: border-box !important;
        width: 100% !important;
    }
    .vigi-card:hover {
        transform: translateY(-1px) !important;
        background-color: #ffffff !important;
    }
    .vigi-card.inside {
        border-left: 4px solid #10b981 !important;
    }
    .vigi-card.inside:hover {
        border-color: #10b981 !important;
        box-shadow: 0 4px 12px rgba(16, 185, 129, 0.08) !important;
    }
    .vigi-card.outside {
        border-left: 4px solid #ef4444 !important;
    }
    .vigi-card.outside:hover {
        border-color: #ef4444 !important;
        box-shadow: 0 4px 12px rgba(239, 68, 68, 0.08) !important;
    }

    .vigi-card-left {
        display: flex !important;
        align-items: center !important;
        gap: 12px !important;
        flex-grow: 1 !important;
    }
    
    .vigi-photo {
        width: 44px !important;
        height: 44px !important;
        border-radius: 50% !important;
        object-fit: cover !important;
        border: 1.5px solid #e2e8f0 !important;
        flex-shrink: 0 !important;
    }

    .vigi-info {
        display: flex !important;
        flex-direction: column !important;
        gap: 2px !important;
    }
    
    .vigi-name {
        font-size: 13px !important;
        font-weight: 700 !important;
        color: #0f172a !important;
    }
    
    .vigi-meta {
        font-size: 11px !important;
        color: #64748b !important;
        font-weight: 500 !important;
    }
    
    .vigi-tag {
        display: inline-block !important;
        font-size: 9px !important;
        font-weight: 700 !important;
        text-transform: uppercase !important;
        padding: 2px 6px !important;
        border-radius: 4px !important;
        margin-top: 4px !important;
        width: max-content !important;
    }
    .vigi-tag.comida {
        background-color: #ffe4e6 !important;
        color: #e11d48 !important;
    }
    .vigi-tag.personal {
        background-color: #fef3c7 !important;
        color: #d97706 !important;
    }
    .vigi-tag.oficial {
        background-color: #e0f2fe !important;
        color: #0369a1 !important;
    }

    /* Action Icon / Button inside card */
    .vigi-action-icon {
        width: 32px !important;
        height: 32px !important;
        border-radius: 50% !important;
        display: flex !important;
        align-items: center !important;
        justify-content: center !important;
        font-size: 14px !important;
        transition: all 0.2s ease !important;
        flex-shrink: 0 !important;
    }
    .vigi-card.inside .vigi-action-icon {
        background-color: #fce8e6 !important;
        color: #c5221f !important;
    }
    .vigi-card.inside:hover .vigi-action-icon {
        background-color: #c5221f !important;
        color: #ffffff !important;
    }
    .vigi-card.outside .vigi-action-icon {
        background-color: #e6f4ea !important;
        color: #137333 !important;
    }
    .vigi-card.outside:hover .vigi-action-icon {
        background-color: #137333 !important;
        color: #ffffff !important;
    }
    
    .vigi-hidden {
        display: none !important;
    }

    /* Empty state */
    .vigi-empty {
        display: flex !important;
        flex-direction: column !important;
        align-items: center !important;
        justify-content: center !important;
        gap: 8px !important;
        color: #94a3b8 !important;
        padding: 40px 0 !important;
        flex-grow: 1 !important;
    }
    .vigi-empty i {
        font-size: 24px !important;
        color: #cbd5e1 !important;
    }
    .vigi-empty span {
        font-size: 12px !important;
        font-weight: 500 !important;
    }

    /* Attendance Section Title */
    .vigi-section-divider {
        margin: 40px 0 20px 0 !important;
        font-size: 15px !important;
        font-weight: 700 !important;
        color: #0f172a !important;
        display: flex !important;
        align-items: center !important;
        gap: 10px !important;
        text-transform: uppercase !important;
        letter-spacing: 0.5px !important;
    }
    .vigi-section-divider::after {
        content: "" !important;
        flex-grow: 1 !important;
        height: 1.5px !important;
        background-color: #e2e8f0 !important;
    }

    /* Filter styling */
    .vigi-column-header {
        display: flex !important;
        justify-content: space-between !important;
        align-items: center !important;
        flex-wrap: wrap !important;
        gap: 12px !important;
        width: 100% !important;
    }
    
    .vigi-filter-container {
        display: flex !important;
        align-items: center !important;
        gap: 8px !important;
        background-color: #ffffff !important;
        border: 1.5px solid #cbd5e1 !important;
        padding: 4px 10px !important;
        border-radius: 8px !important;
        box-shadow: 0 1px 2px rgba(0,0,0,0.05) !important;
        transition: all 0.2s ease !important;
    }
    .vigi-filter-container:focus-within {
        border-color: #7c121d !important;
        box-shadow: 0 0 0 2px rgba(124, 18, 29, 0.1) !important;
    }
    
    .vigi-filter-label {
        font-size: 11px !important;
        font-weight: 600 !important;
        color: #64748b !important;
        margin: 0 !important;
        white-space: nowrap !important;
    }
    
    .vigi-filter-input {
        border: none !important;
        outline: none !important;
        font-size: 11px !important;
        color: #334155 !important;
        width: 140px !important;
        background: transparent !important;
        font-family: 'Inter', sans-serif !important;
    }
</style>

<script>
function tiempo(){
    var fecha = new Date();
    var horas = fecha.getHours();
    var minutos = fecha.getMinutes();
    var segundos = fecha.getSeconds();
    var dn = "AM";

    if (horas > 12){
        dn = "PM";
        horas = horas - 12;
    } else if (horas === 0) {
        horas = 12;
    }
    
    if (horas < 10) horas = "0" + horas;
    if (minutos < 10) minutos = "0" + minutos;
    if (segundos < 10) segundos = "0" + segundos;

    var elHora = document.getElementById('vigi_hora');
    var elMin = document.getElementById('vigi_min');
    var elSeg = document.getElementById('vigi_seg');
    var elDn = document.getElementById('vigi_dn');

    if (elHora) elHora.innerHTML = horas;
    if (elMin) elMin.innerHTML = minutos;
    if (elSeg) elSeg.innerHTML = segundos;
    if (elDn) elDn.innerHTML = dn;

    setTimeout(tiempo, 1000);
}
window.onload = function() {
    tiempo();
};

function vigiFiltrarColumn(listId, query) {
    query = query.toLowerCase().trim();
    var list = document.getElementById(listId);
    if (!list) return;
    var cards = list.getElementsByClassName('vigi-card');
    
    for (var i = 0; i < cards.length; i++) {
        var card = cards[i];
        var searchVal = card.getAttribute('data-search') || '';
        if (query === '' || searchVal.toLowerCase().indexOf(query) !== -1) {
            card.classList.remove('vigi-hidden');
        } else {
            card.classList.add('vigi-hidden');
        }
    }
}
</script>

<?php
$id_aplicacion ="ap13";
$nivel = aplicacion_nivel($id_aplicacion, $nitavu);

if (sanpedro($id_aplicacion, $nitavu) == TRUE) {
	$delegacion = midelegacion($nitavu);
	historia($nitavu, "usando la aplicacion [ap13], de vigilancia");	

    // Process Out/In actions first
    if (isset($_GET['comida_sale'])){
        if (comida_salio($_GET['comida_sale'], $nitavu, $_GET['quien']) == TRUE) {
            mensaje("Pase marcado para salida correctamente", "vigilancia3.php");
            exit;
        }
    }
    if (isset($_GET['comida_entra'])){
        if (comida_entro($_GET['comida_entra'], $nitavu, $_GET['quien']) == TRUE) {
            mensaje("Pase de comida - Retorno registrado con éxito", "vigilancia3.php");
            exit;
        }
    }
    if (isset($_GET['nocomida_sale'])){
        if (nocomida_salio($_GET['nocomida_sale'], $nitavu, $_GET['quien']) == TRUE) {
            mensaje("Pase marcado para salida correctamente", "vigilancia3.php");
            exit;
        }
    }
    if (isset($_GET['nocomida_entra'])){
        if (nocomida_entro($_GET['nocomida_entra'], $nitavu, $_GET['quien']) == TRUE) {
            mensaje("Pase - Retorno registrado con éxito", "vigilancia3.php");
            exit;
        }
    }

	echo "<div id='AppDetalle'>" . app_detalle($id_aplicacion, $nitavu) . "</div>";
    
    echo "<div class='vigi-body'>";
    
    // Live Dashboard Header
    echo "<div class='vigi-dashboard-header'>";
    echo "<div class='vigi-header-left'>";
    echo "<span class='vigi-subtitle'>Caseta de Seguridad</span>";
    echo "<h2 class='vigi-title'>" . $delegacion . "</h2>";
    echo "</div>";
    echo "<div class='vigi-clock-card'>";
    echo "<div class='vigi-clock-time'>";
    echo "<span id='vigi_hora'>--</span>";
    echo "<span class='vigi-clock-sep'>:</span>";
    echo "<span id='vigi_min'>--</span>";
    echo "<span class='vigi-clock-sep'>:</span>";
    echo "<span id='vigi_seg'>--</span>";
    echo "</div>";
    echo "<span id='vigi_dn' class='vigi-clock-ampm'>--</span>";
    echo "</div>";
    echo "</div>"; // .vigi-dashboard-header

    // Fetch and group lunch/comida passes
    $comida_dentro = [];
    $comida_fuera = [];
    $midpto = nitavu_dpto($nitavu);

    if ($delegacion == "OFICINAS CENTRALES"){
        $sql = "SELECT empleados_salidas_temporal.*, empleados_salidas_temporal.dpto as qdpto, 
                       (select cat_gerarquia.nombre from cat_gerarquia where id = qdpto) as qdpton,
                       (select cat_gerarquia.nivel from cat_gerarquia where id = qdpto) as qnivel
                FROM empleados_salidas_temporal
                WHERE (fecha = '".$fecha."' AND registro_entrada = '00:00:00' AND asunto = 'COMIDA' AND autorizo_nitavu <> '')
                ORDER BY registro_salida DESC";		
    } else {
        $sql = "SELECT empleados_salidas_temporal.*, empleados_salidas_temporal.dpto as qdpto, 
                       (select cat_gerarquia.nombre from cat_gerarquia where id = qdpto) as qdpton,
                       (select cat_gerarquia.nivel from cat_gerarquia where id = qdpto) as qnivel
                FROM empleados_salidas_temporal
                WHERE (fecha = '".$fecha."' AND registro_entrada = '00:00:00' AND asunto = 'COMIDA' AND autorizo_nitavu <> '' AND dpto = '".$midpto."')
                ORDER BY registro_salida DESC";		
    }
    
    $rc = $conexion->query($sql);
    while($f = $rc->fetch_array()) {
        $show = false;
        if ($delegacion == "OFICINAS CENTRALES") {
            if ($f['qdpto'] == '45') {
                $show = true;
            } else if ($f['qnivel'] <> 'del') {
                $show = true;
            }
        } else {
            if ($f['qdpto'] == $midpto) {
                $show = true;
            }
        }
        
        if ($show) {
            if ($f['registro_salida'] == '00:00:00') {
                $comida_dentro[] = $f;
            } else if ($f['registro_entrada'] == '00:00:00') {
                $comida_fuera[] = $f;
            }
        }
    }

    // Fetch and group official/personal passes
    $oficial_dentro = [];
    $oficial_fuera = [];

    if ($delegacion == "OFICINAS CENTRALES"){
        $sql = "SELECT empleados_salidas_temporal.*, empleados_salidas_temporal.dpto as qdpto, 
                       (select cat_gerarquia.nombre from cat_gerarquia where id = qdpto) as qdpton,
                       (select cat_gerarquia.nivel from cat_gerarquia where id = qdpto) as qnivel
                FROM empleados_salidas_temporal
                WHERE (fecha = '".$fecha."' AND registro_entrada = '00:00:00' AND asunto <> 'COMIDA' AND autorizo_nitavu <> '')
                ORDER BY registro_salida DESC";		
    } else {
        $sql = "SELECT empleados_salidas_temporal.*, empleados_salidas_temporal.dpto as qdpto, 
                       (select cat_gerarquia.nombre from cat_gerarquia where id = qdpto) as qdpton,
                       (select cat_gerarquia.nivel from cat_gerarquia where id = qdpto) as qnivel
                FROM empleados_salidas_temporal
                WHERE (fecha = '".$fecha."' AND registro_entrada = '00:00:00' AND asunto <> 'COMIDA' AND autorizo_nitavu <> '' AND dpto = '".$midpto."')
                ORDER BY registro_salida DESC";		
    }
    
    $rc = $conexion->query($sql);
    while($f = $rc->fetch_array()) {
        $show = false;
        if ($delegacion == "OFICINAS CENTRALES") {
            if ($f['qdpto'] == '45') {
                $show = true;
            } else if ($f['qnivel'] <> 'del') {
                $show = true;
            }
        } else {
            $show = true; // DB query filters by dpto in delegation
        }
        
        if ($show) {
            if ($f['registro_salida'] == '00:00:00') {
                $oficial_dentro[] = $f;
            } else if ($f['registro_entrada'] == '00:00:00') {
                $oficial_fuera[] = $f;
            }
        }
    }

    // RENDER: VALES DE SALIDA
    echo "<div class='vigi-section-divider'>Vales de Salida</div>";
    echo "<div class='vigi-layout-grid'>";
    
    // Left Column: Dentro (Pendientes de Salir)
    echo "<div class='vigi-column'>";
    echo "<div class='vigi-column-header'>";
    echo "<h3 class='vigi-column-title inside'><i class='fa-solid fa-house-user'></i> Dentro del Instituto (Pendientes de Salir)</h3>";
    echo "<div class='vigi-filter-container'>";
    echo "<label class='vigi-filter-label'>Filtrar:</label>";
    echo "<input type='text' class='vigi-filter-input' placeholder='Número o Nombre...' onkeyup=\"vigiFiltrarColumn('vigi-inside-list', this.value)\">";
    echo "</div>";
    echo "</div>"; // .vigi-column-header
    
    echo "<div class='vigi-card-list' id='vigi-inside-list'>";
    echo "<div class='vigi-card-list-header'>Pases de Comida</div>";
    if (empty($comida_dentro)) {
        echo "<div class='vigi-empty'><i class='fa-solid fa-mug-saucer'></i><span>No hay pases de comida pendientes</span></div>";
    } else {
        foreach ($comida_dentro as $f) {
            $searchMeta = $f['nitavu'] . " " . strtolower(nitavu_nombre($f['nitavu'])) . " comida";
            echo "<a class='vigi-card inside' data-search='".htmlspecialchars($searchMeta, ENT_QUOTES)."' href='vigilancia3.php?comida_sale=".$f['id']."&quien=".$f['nitavu']."' title='Registrar Salida de ".nitavu_nombre($f['nitavu'])."'>";
            echo "<div class='vigi-card-left'>";
            echo ponerfoto("fotos/".$f['nitavu'].".jpg", 'vigi-photo');
            echo "<div class='vigi-info'>";
            echo "<span class='vigi-name'>".nitavu_nombre($f['nitavu'])."</span>";
            echo "<span class='vigi-meta'>NITAVU: <strong>".$f['nitavu']."</strong> | ID: #".$f['id']." | Hora: <strong>".hora12($f['hora_desde'])."</strong></span>";
            echo "<span class='vigi-tag comida'>Comida</span>";
            echo "</div>";
            echo "</div>";
            echo "<div class='vigi-action-icon'><i class='fa-solid fa-right-from-bracket'></i></div>";
            echo "</a>";
        }
    }
    
    echo "<div class='vigi-card-list-header' style='margin-top: 12px;'>Salidas Oficiales y Personales</div>";
    if (empty($oficial_dentro)) {
        echo "<div class='vigi-empty'><i class='fa-solid fa-briefcase'></i><span>No hay salidas oficiales pendientes</span></div>";
    } else {
        foreach ($oficial_dentro as $f) {
            $searchMeta = $f['nitavu'] . " " . strtolower(nitavu_nombre($f['nitavu'])) . " " . strtolower($f['asunto']);
            echo "<a class='vigi-card inside' data-search='".htmlspecialchars($searchMeta, ENT_QUOTES)."' href='vigilancia3.php?nocomida_sale=".$f['id']."&quien=".$f['nitavu']."' title='Registrar Salida de ".nitavu_nombre($f['nitavu'])."'>";
            echo "<div class='vigi-card-left'>";
            echo ponerfoto("fotos/".$f['nitavu'].".jpg", 'vigi-photo');
            echo "<div class='vigi-info'>";
            echo "<span class='vigi-name'>".nitavu_nombre($f['nitavu'])."</span>";
            echo "<span class='vigi-meta'>NITAVU: <strong>".$f['nitavu']."</strong> | ID: #".$f['id']." | Hora: <strong>".hora12($f['hora_desde'])."</strong></span>";
            $tagClass = (strtoupper($f['asunto']) == 'OFICIAL') ? 'oficial' : 'personal';
            echo "<span class='vigi-tag ".$tagClass."'>".$f['asunto']."</span>";
            echo "</div>";
            echo "</div>";
            echo "<div class='vigi-action-icon'><i class='fa-solid fa-right-from-bracket'></i></div>";
            echo "</a>";
        }
    }
    echo "</div>"; // .vigi-card-list
    echo "</div>"; // .vigi-column
    
    // Right Column: Fuera (Activos)
    echo "<div class='vigi-column'>";
    echo "<div class='vigi-column-header'>";
    echo "<h3 class='vigi-column-title outside'><i class='fa-solid fa-person-walking-arrow-right'></i> Fuera del Instituto (Pases Activos)</h3>";
    echo "<div class='vigi-filter-container'>";
    echo "<label class='vigi-filter-label'>Filtrar:</label>";
    echo "<input type='text' class='vigi-filter-input' placeholder='Número o Nombre...' onkeyup=\"vigiFiltrarColumn('vigi-outside-list', this.value)\">";
    echo "</div>";
    echo "</div>"; // .vigi-column-header
    
    echo "<div class='vigi-card-list' id='vigi-outside-list'>";
    echo "<div class='vigi-card-list-header'>Pases de Comida</div>";
    if (empty($comida_fuera)) {
        echo "<div class='vigi-empty'><i class='fa-solid fa-check-double'></i><span>Nadie fuera a comer</span></div>";
    } else {
        foreach ($comida_fuera as $f) {
            $searchMeta = $f['nitavu'] . " " . strtolower(nitavu_nombre($f['nitavu'])) . " comida";
            echo "<a class='vigi-card outside' data-search='".htmlspecialchars($searchMeta, ENT_QUOTES)."' href='vigilancia3.php?comida_entra=".$f['id']."&quien=".$f['nitavu']."' title='Registrar Entrada de ".nitavu_nombre($f['nitavu'])."'>";
            echo "<div class='vigi-card-left'>";
            echo ponerfoto("fotos/".$f['nitavu'].".jpg", 'vigi-photo');
            echo "<div class='vigi-info'>";
            echo "<span class='vigi-name'>".nitavu_nombre($f['nitavu'])."</span>";
            echo "<span class='vigi-meta'>NITAVU: <strong>".$f['nitavu']."</strong> | ID: #".$f['id']." | Salió a las: <strong>".hora12($f['registro_salida'])."</strong></span>";
            echo "<span class='vigi-tag comida'>Comida</span>";
            echo "</div>";
            echo "</div>";
            echo "<div class='vigi-action-icon'><i class='fa-solid fa-right-to-bracket fa-rotate-180'></i></div>";
            echo "</a>";
        }
    }
    
    echo "<div class='vigi-card-list-header' style='margin-top: 12px;'>Salidas Oficiales y Personales</div>";
    if (empty($oficial_fuera)) {
        echo "<div class='vigi-empty'><i class='fa-solid fa-check-double'></i><span>Nadie fuera por comisión</span></div>";
    } else {
        foreach ($oficial_fuera as $f) {
            $searchMeta = $f['nitavu'] . " " . strtolower(nitavu_nombre($f['nitavu'])) . " " . strtolower($f['asunto']);
            echo "<a class='vigi-card outside' data-search='".htmlspecialchars($searchMeta, ENT_QUOTES)."' href='vigilancia3.php?nocomida_entra=".$f['id']."&quien=".$f['nitavu']."' title='Registrar Entrada de ".nitavu_nombre($f['nitavu'])."'>";
            echo "<div class='vigi-card-left'>";
            echo ponerfoto("fotos/".$f['nitavu'].".jpg", 'vigi-photo');
            echo "<div class='vigi-info'>";
            echo "<span class='vigi-name'>".nitavu_nombre($f['nitavu'])."</span>";
            echo "<span class='vigi-meta'>NITAVU: <strong>".$f['nitavu']."</strong> | ID: #".$f['id']." | Salió a las: <strong>".hora12($f['registro_salida'])."</strong></span>";
            $tagClass = (strtoupper($f['asunto']) == 'OFICIAL') ? 'oficial' : 'personal';
            echo "<span class='vigi-tag ".$tagClass."'>".$f['asunto']."</span>";
            echo "</div>";
            echo "</div>";
            echo "<div class='vigi-action-icon'><i class='fa-solid fa-right-to-bracket fa-rotate-180'></i></div>";
            echo "</a>";
        }
    }
    echo "</div>"; // .vigi-card-list
    echo "</div>"; // .vigi-column
    echo "</div>"; // .vigi-layout-grid


    /*
    // RENDER: CONTROL DE ASISTENCIA DIARIO
    echo "<div class='vigi-section-divider'>Control de Asistencia Diario</div>";
    
    // Fetch and group daily attendance
    if ($delegacion == "OFICINAS CENTRALES"){
        $sql = "SELECT dpto AS Qdpto, ( SELECT nivel FROM cat_gerarquia WHERE id = Qdpto ) AS qnivel, empleados.* 
                FROM empleados 
                WHERE ( control_asistencia = 'TRUE' ) and estado not like '%BAJA%'";
    } else {
        $sql = "SELECT dpto AS Qdpto, ( SELECT nivel FROM cat_gerarquia WHERE id = Qdpto ) AS qnivel, empleados.* 
                FROM empleados 
                WHERE control_asistencia = 'TRUE' AND dpto='".$midpto."'";
    }
    
    $rc = $conexion->query($sql);
    $asistencia_dentro = [];
    $asistencia_fuera = [];
    
    while($fa = $rc->fetch_array()) {
        $show = false;
        if ($delegacion == "OFICINAS CENTRALES") {
            if ($fa['dpto'] == '45') {
                $show = true;
            } else if ($fa['qnivel'] <> 'del') {
                $show = true;
            }
        } else {
            $show = true;
        }
        
        if ($show) {
            $dentro = false;
            $salida_val = asistencia_salida($fa['nitavu']);
            $entrada_val = asistencia_entrada($fa['nitavu']);
            
            if ($salida_val == '') {
                if ($entrada_val <> '') {
                    $dentro = true;
                }
            } else if ($salida_val == '00:00:00') {
                $dentro = true;
            }
            
            if ($dentro) {
                $asistencia_dentro[] = $fa;
            } else {
                // Show if they haven't finished shift
                if ($salida_val == '' || $salida_val == '00:00:00') {
                    $asistencia_fuera[] = $fa;
                }
            }
        }
    }
    
    echo "<div class='vigi-layout-grid'>";
    
    // Left Column: Pendientes de Entrada
    echo "<div class='vigi-column'>";
    echo "<div class='vigi-column-header'>";
    echo "<h3 class='vigi-column-title outside'><i class='fa-solid fa-door-closed'></i> Pendientes de Entrada (Jornada Diaria)</h3>";
    echo "<div class='vigi-filter-container'>";
    echo "<label class='vigi-filter-label'>Filtrar:</label>";
    echo "<input type='text' class='vigi-filter-input' placeholder='Número o Nombre...' onkeyup=\"vigiFiltrarColumn('vigi-attendance-outside-list', this.value)\">";
    echo "</div>";
    echo "</div>"; // .vigi-column-header
    
    echo "<div class='vigi-card-list' id='vigi-attendance-outside-list'>";
    if (empty($asistencia_fuera)) {
        echo "<div class='vigi-empty'><i class='fa-solid fa-users'></i><span>Todos los empleados registraron su entrada</span></div>";
    } else {
        foreach ($asistencia_fuera as $fa) {
            $searchMeta = $fa['nitavu'] . " " . strtolower(nombre_corto($fa['nitavu'], 0));
            echo "<a class='vigi-card outside' data-search='".htmlspecialchars($searchMeta, ENT_QUOTES)."' href='asistencia_entro.php?id=".$fa['nitavu']."' title='Registrar Entrada Diaria'>";
            echo "<div class='vigi-card-left'>";
            echo ponerfoto("fotos/".$fa['nitavu'].".jpg", 'vigi-photo');
            echo "<div class='vigi-info'>";
            echo "<span class='vigi-name'>".nombre_corto($fa['nitavu'], 0)."</span>";
            echo "<span class='vigi-meta'>NITAVU: ".$fa['nitavu']." | Pendiente de Ingreso</span>";
            echo "</div>";
            echo "</div>";
            echo "<div class='vigi-action-icon'><i class='fa-solid fa-right-to-bracket'></i></div>";
            echo "</a>";
        }
    }
    echo "</div>"; // .vigi-card-list
    echo "</div>"; // .vigi-column

    // Right Column: Dentro (Trabajando)
    echo "<div class='vigi-column'>";
    echo "<div class='vigi-column-header'>";
    echo "<h3 class='vigi-column-title inside'><i class='fa-solid fa-user-tie'></i> Trabajando (Dentro del Instituto)</h3>";
    echo "<div class='vigi-filter-container'>";
    echo "<label class='vigi-filter-label'>Filtrar:</label>";
    echo "<input type='text' class='vigi-filter-input' placeholder='Número o Nombre...' onkeyup=\"vigiFiltrarColumn('vigi-attendance-inside-list', this.value)\">";
    echo "</div>";
    echo "</div>"; // .vigi-column-header
    
    echo "<div class='vigi-card-list' id='vigi-attendance-inside-list'>";
    if (empty($asistencia_dentro)) {
        echo "<div class='vigi-empty'><i class='fa-solid fa-circle-minus'></i><span>No hay empleados trabajando actualmente</span></div>";
    } else {
        foreach ($asistencia_dentro as $fa) {
            $searchMeta = $fa['nitavu'] . " " . strtolower(nombre_corto($fa['nitavu'], 0));
            echo "<a class='vigi-card inside' data-search='".htmlspecialchars($searchMeta, ENT_QUOTES)."' href='asistencia_salio.php?id=".$fa['nitavu']."' title='Registrar Salida Diaria'>";
            echo "<div class='vigi-card-left'>";
            echo ponerfoto("fotos/".$fa['nitavu'].".jpg", 'vigi-photo');
            echo "<div class='vigi-info'>";
            echo "<span class='vigi-name'>".nombre_corto($fa['nitavu'], 0)."</span>";
            echo "<span class='vigi-meta'>NITAVU: ".$fa['nitavu']." | Entró a las: <strong>".asistencia_entrada($fa['nitavu'])."</strong></span>";
            echo "</div>";
            echo "</div>";
            echo "<div class='vigi-action-icon'><i class='fa-solid fa-right-from-bracket'></i></div>";
            echo "</a>";
        }
    }
    echo "</div>"; // .vigi-card-list
    echo "</div>"; // .vigi-column
    
    echo "</div>"; // .vigi-layout-grid
    */

    echo "</div>"; // .vigi-body
}
else {
    echo "<div class='vigi-body'>";
    echo "<div class='vigi-card-result-error'><i class='fa-solid fa-circle-xmark'></i> No tiene acceso a la aplicación ".$id_aplicacion."</div>";
    echo "</div>";
}

include ("./lib/body_footer.php");
?>