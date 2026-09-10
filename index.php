<?php
require_once("config.php");
if ($ModoMantenimiento == TRUE) {
  echo '		
	  <script type="text/javascript">
	  window.location.href = "mantenimiento/index.php";
	  </script>';
}

include("lib/body_head.php");
include("lib/body_menu.php");

if (isset($_GET['msg'])) {
  Toast($_GET['msg'], 0, "");
}

// if (CheckServiciosGoogle()==FALSE) {
//   Toast("No se ha podido conectar a los servicios de Google",2,"");
// }
?>

<nav class="cd-main-navbar">
  <a href="index.php">
    <img src="img/LogotipoOficial.jpg" class="cd-logo-img" alt="ITAVU Tamaulipas">
  </a>
  <div class="cd-nav-actions">
    <div class="cd-nav-user-welcome">
      <div class="cd-user-name">
        <span class="cd-user-leading" aria-hidden="true">
          <i class="fa-solid fa-circle-user cd-user-icon-inline"></i>
          <!-- <span class="cd-online-dot-sm" title="Sesión activa"></span> -->
        </span>
        <span class="cd-user-text-block">
          <b class="cd-user-fullname"><?php echo nitavu_nombre($nitavu); ?></b>
          <span class="cd-user-puesto">
            <?php echo nitavu_puesto($nitavu) ? nitavu_puesto($nitavu) : nitavu_dpto_nombre(nitavu_dpto($nitavu)); ?>
          </span>
        </span>
      </div>

    </div>
    <?php
    $notis = CuantasNotificaciones($nitavu);
    if ($notis > 0) {
      echo "<a class='cd-nav-btn' title='Tienes " . $notis . " notificaciones' href='notificaciones.php'>
                <i class='fa-solid fa-bell' style='color:#7c121d; font-size:18px;'></i>
                <span class='cd-noti-badge'>" . $notis . "</span>
              </a>";
    } else {
      echo "<a class='cd-nav-btn' title='Sin Notificaciones' href='notificaciones.php'>
                <i class='fa-regular fa-bell' style='color:#64748b; font-size:18px;'></i>
              </a>";
    }
    ?>
    <a class="cd-nav-btn" href="logout.php" title="Cerrar Sesión">
      <i class="fa-solid fa-right-from-bracket" style="color:#7c121d; font-size:18px;"></i>
    </a>
  </div>
</nav>

<?php
$nip = nitavu_nip($nitavu);
if ($nip == $nitavu) {
  echo "<div id='avisos' style='background: linear-gradient(135deg, #7c121d 0%, #990000 100%); color: white; padding: 10px 24px; text-align: center; border-bottom: 3px solid #bc955c; font-size: 13px; font-weight: 600;'>";
  echo "<i class='fa-solid fa-triangle-exclamation' style='color:#bc955c; margin-right:8px;'></i> Por seguridad debes cambiar tu NIP ya que es igual a tu No. de Empleado. Cámbialo <a style='color:#ddc9a3; text-decoration:underline;' href='nip_update.php'>aquí</a>.";
  echo "</div>";
}
?>

<?php
$dpto = nitavu_dpto($nitavu);
//------------------- Inicia carrusel  -------------------//
$script = "select * from ControlDeCarrusel where IdEstatus = 0 and archivophp = 'index.php' order by OrdenVisual DESC";
$result = $conexion->query($script);
$row_cnt = ($result) ? $result->num_rows : 0;

if ($row_cnt > 0) {
  $secuencia = 0;
  $carouselindicators = "";
  $carouselinner = "";

  while ($valor = $result->fetch_array()) {
    $activeClass = ($secuencia == 0) ? "active" : "";
    $ariaCurrent = ($secuencia == 0) ? "aria-current='true'" : "";
    $pieFoto = !empty($valor["comentariopiedefoto"]) ? mb_strtoupper($valor["comentariopiedefoto"], 'UTF-8') : "COMUNICACIÓN INSTITUCIONAL";
    $fechaPub = date("d/m/Y H:i", strtotime($valor["ultimoacceso"]));
    $rutaArchivo = htmlspecialchars($valor["rutadelarchivo"]);

    $carouselindicators .= "<button type='button' data-bs-target='#carouselExampleCaptions' data-bs-slide-to='" . $secuencia . "' class='" . $activeClass . "' " . $ariaCurrent . " aria-label='Diapositiva " . ($secuencia + 1) . "'></button>";

    $carouselinner .= "<div class='carousel-item " . $activeClass . "'>";
    $carouselinner .= "<img src='" . $rutaArchivo . "' class='d-block w-100' alt='" . htmlspecialchars($pieFoto) . "' onerror=\"this.onerror=null; this.src='img/itavu_hero_banner.png';\" />";
    $carouselinner .= "<div class='cd-carousel-badge'><i class='fa-regular fa-clock'></i> " . $fechaPub . "</div>";
    $carouselinner .= "</div>";

    $secuencia++;
  }

  echo "<div id='ControlDeCarrusel' class='cd-carousel-container'>";
  echo "<div id='carouselExampleCaptions' class='carousel slide' data-bs-ride='carousel' data-bs-interval='5000'>";
  echo "<div class='carousel-indicators'>" . $carouselindicators . "</div>";
  echo "<div class='carousel-inner'>" . $carouselinner . "</div>";
  echo "<button class='carousel-control-prev' type='button' data-bs-target='#carouselExampleCaptions' data-bs-slide='prev'>";
  echo "<span class='carousel-control-prev-icon' aria-hidden='true'></span><span class='visually-hidden'>Anterior</span>";
  echo "</button>";
  echo "<button class='carousel-control-next' type='button' data-bs-target='#carouselExampleCaptions' data-bs-slide='next'>";
  echo "<span class='carousel-control-next-icon' aria-hidden='true'></span><span class='visually-hidden'>Siguiente</span>";
  echo "</button>";
  echo "</div>";
  echo "</div>";
} else {
  // Default Executive Hero Banner when DB table is empty
  echo "<div id='ControlDeCarrusel' class='cd-carousel-container'>";
  echo "<div id='carouselExampleCaptions' class='carousel slide' data-bs-ride='carousel'>";
  echo "<div class='carousel-inner'>";
  echo "<div class='carousel-item active'>";
  echo "<img src='img/itavu_hero_banner.png' class='d-block w-100' alt='Plataforma ITAVU 2026' />";
  echo "<div class='cd-carousel-badge'><i class='fa-regular fa-clock'></i> " . date("d/m/Y H:i") . "</div>";
  echo "</div>";
  echo "</div>";
  echo "</div>";
  echo "</div>";
}
//------------------- Termina carrusel  -------------------///


//--------------------- Inicia menu ----------------------//
$VistaUser = Preference('VistaMenu', $nitavu, '');
if ($VistaUser == 'NoR' || $VistaUser == '') {
  $VistaUser = 0;
}

echo "
    <div class='cd-view-mode-bar'>
      <span class='cd-view-mode-title'>
        <i class='fa-solid fa-shapes'></i> Modalidad de Vista
      </span>
      <div class='cd-segmented-pills'>
        <button class='cd-pill-btn " . ($VistaUser == 4 ? "active" : "") . " ' onclick='BuscarApps(4); selectPill(this);' title='Mis Favoritos'>
          <i class='fa-solid fa-star' style='color:#f59e0b;'></i> Favoritos
        </button>
        <button class='cd-pill-btn " . ($VistaUser == 0 ? "active" : "") . " ' onclick='BuscarApps(0); selectPill(this);' title='Vista por Categorías'>
          <i class='fa-solid fa-layer-group'></i> Categorías
        </button>
        <button class='cd-pill-btn " . ($VistaUser == 2 ? "active" : "") . " ' onclick='BuscarApps(2); selectPill(this);' title='Vista por Iconos'>
          <i class='fa-solid fa-grip-vertical'></i> Iconos
        </button>
        <button class='cd-pill-btn " . ($VistaUser == 3 ? "active" : "") . " ' onclick='BuscarApps(3); selectPill(this);' title='Vista por Tabla'>
          <i class='fa-solid fa-table-list'></i> Tabla
        </button>
      </div>
    </div>
    <script>
      function selectPill(btn) {
        $('.cd-pill-btn').removeClass('active');
        $(btn).addClass('active');
      }
    </script>
    ";
//--------------------- Termina Menu ----------------------//
?>

<div id='AppResultado' style="margin-top: 19px; text-align:center;"></div>

<?php
echo "<div id='app_contenedor' style='background: #f8fafc; border-top: 1px solid #e2e8f0; padding: 24px 10px; text-align: center;'>";
include("widget_salidas.php");
include("widget_cumples.php");

if (in_array($nitavu, [1733, 1308, 2269, 1739])) {
  echo "<style>
            .widget-hdd-section {
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
            .widget-hdd-header {
                padding: 18px 20px !important;
                border-bottom: 1.5px solid #f1f5f9 !important;
                background-color: #ffffff !important;
            }
            .widget-hdd-title {
                font-size: 15px !important;
                font-weight: 700 !important;
                color: #0f172a !important;
                display: flex !important;
                align-items: center !important;
                gap: 8px !important;
            }
            .widget-hdd-title i {
                color: #7c121d !important;
                font-size: 16px !important;
            }
            .widget-hdd-body {
                padding: 20px !important;
                box-sizing: border-box !important;
                width: 100% !important;
                display: flex !important;
                flex-direction: column !important;
                gap: 12px !important;
            }
            .widget-hdd-row {
                display: flex !important;
                justify-content: space-between !important;
                align-items: center !important;
                font-size: 13.5px !important;
                color: #475569 !important;
            }
            .widget-hdd-row b {
                color: #0f172a !important;
                font-weight: 600 !important;
            }
            .widget-hdd-progress-container {
                margin-top: 6px !important;
                display: flex !important;
                flex-direction: column !important;
                gap: 6px !important;
            }
            .widget-hdd-progress-bar {
                width: 100% !important;
                background-color: #f1f5f9 !important;
                border-radius: 9999px !important;
                overflow: hidden !important;
                height: 12px !important;
            }
            .widget-hdd-progress-fill {
                height: 100% !important;
                border-radius: 9999px !important;
                transition: width 0.5s ease-in-out !important;
            }
            .widget-hdd-progress-fill.green {
                background-color: #22c55e !important;
            }
            .widget-hdd-progress-fill.red {
                background-color: #ef4444 !important;
            }
            .widget-hdd-progress-text {
                font-size: 12px !important;
                font-weight: 600 !important;
                color: #64748b !important;
                text-align: right !important;
            }
        </style>";

  $total_space_bytes = disk_total_space("/");
  $free_space_bytes = disk_free_space("/");

  $total_space_gb = round($total_space_bytes / (1024 * 1024 * 1024), 2);
  $free_space_gb = round($free_space_bytes / (1024 * 1024 * 1024), 2);
  $used_space_gb = round($total_space_gb - $free_space_gb, 2);
  $used_percentage = round(($used_space_gb / $total_space_gb) * 100, 2);
  $free_percentage = round(100 - $used_percentage, 2);

  echo "<section class='widget-hdd-section'>";
  echo "<div class='widget-hdd-header'>";
  echo "<span class='widget-hdd-title'><i class='fa-solid fa-hard-drive'></i> Capacidad de HDD</span>";
  echo "</div>";
  echo "<div class='widget-hdd-body'>";
  echo "<div class='widget-hdd-row'><span>Espacio Total:</span><b>" . $total_space_gb . " GB</b></div>";
  echo "<div class='widget-hdd-row'><span>Espacio Usado:</span><b>" . $used_space_gb . " GB (" . $used_percentage . "%)</b></div>";
  echo "<div class='widget-hdd-row'><span>Espacio Disponible:</span><b>" . $free_space_gb . " GB (" . $free_percentage . "%)</b></div>";

  echo "<div class='widget-hdd-progress-container'>";
  if ($used_percentage > 80) {
    echo "<div class='widget-hdd-progress-bar'><div class='widget-hdd-progress-fill red' style='width: " . $free_percentage . "%;'></div></div>";
    echo "<span class='widget-hdd-progress-text' style='color: #ef4444;'>¡Atención! Depurar espacio (" . $free_percentage . "% Libre)</span>";
  } else {
    echo "<div class='widget-hdd-progress-bar'><div class='widget-hdd-progress-fill green' style='width: " . $free_percentage . "%;'></div></div>";
    echo "<span class='widget-hdd-progress-text'>" . $free_percentage . "% Libre</span>";
  }
  echo "</div>";
  echo "</div>";
  echo "</section>";
}
?>

<?php
echo "
<script>
function BuscarApps(mode){   
  $('#progressbar').show();  
  
    busqueda = $('#InputBusqueda').val();
    console.log('Buscando ' + busqueda);
        $.ajax({
            url: 'menu_search.php',
            type: 'post',			
            data: {nitavu: '" . $nitavu . "', busqueda:busqueda, mode:mode },
            success: function(data){
            $('#AppResultado').html(data);
            $('#progressbar').hide();
            
            }
        });
			
}
BuscarApps(" . $VistaUser . ");


function Favorite(IdApp){   
  console.log('ElApp es: ' +  IdApp);
  $('#progressbar').show();  
  busqueda = $('#InputBusqueda').val();
  console.log('Buscando ' + busqueda);
      $.ajax({
          url: 'preference_appsfavorite.php',
          type: 'post',			
          data: {nitavu: '" . $nitavu . "', IdApp:IdApp },
          success: function(data){
          $('#R').html(data);          
          $('#progressbar').hide();
          BuscarApps(" . $VistaUser . ");
          }
      });
    
}

function BuscarApps_lite(){   
  mode=0;
  $('#progressbar').show();  
  
    busqueda = $('#buscador').val();

    $.ajax({
      url: 'menu_search.php',
      type: 'post',			
      data: {nitavu: '" . $nitavu . "', busqueda:busqueda, mode:mode },
      success: function(data){
      $('#AppResultado').html(data);
      
      $('#progressbar').hide();
      
      }
  });
  
}
</script>
    ";
?>

<?php
include("lib/body_footer.php");
?>
</div>

<footer class="cd-executive-footer">
  <div class="cd-footer-content">
    <div class="cd-footer-user">
      <div class="cd-user-avatar-wrapper">
        <?php echo ponerfoto("fotos/" . $nitavu . ".jpg", 'cd-hero-avatar'); ?>
        <span class="cd-online-dot" title="Sesión activa"></span>
      </div>
      <div style="display:flex; flex-direction:column; text-align:left;">
        <span style="font-size:13.5px; font-weight:700; color:#ffffff;"><?php echo nitavu_nombre($nitavu); ?></span>
        <span style="font-size:11.5px; color:#94a3b8;"><?php echo nitavu_dpto_nombre(nitavu_dpto($nitavu)); ?></span>
      </div>
    </div>

    <div class="cd-footer-links">
      <a class="cd-footer-link" href="perfil.php">
        <i class="fa-solid fa-id-card" style="color:var(--cd-gold);"></i> Mi Perfil
      </a>
      <a class="cd-footer-link" href="SETUP_TokenPlataforma.zip" download>
        <i class="fa-solid fa-key" style="color:var(--cd-gold);"></i> Token Digital
      </a>
      <a class="cd-footer-link" href="#Acuerdo" rel="MyModal:open">
        <i class="fa-solid fa-file-contract" style="color:var(--cd-gold);"></i> Acuerdo de Confidencialidad
      </a>
    </div>
  </div>
</footer>