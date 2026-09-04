<?php
  require_once("config.php");
  if ($ModoMantenimiento == TRUE){
	  echo '		
	  <script type="text/javascript">
	  window.location.href = "mantenimiento/index.php";
	  </script>';
  }
  
  include ("lib/body_head.php");
  include ("lib/body_menu.php");

  if (isset($_GET['msg'])){
    Toast($_GET['msg'],0,"");
  }

  // if (CheckServiciosGoogle()==FALSE) {
  //   Toast("No se ha podido conectar a los servicios de Google",2,"");
  // }
?>

<nav style="background-color:white; padding:10px;">
<table width=100% border=0><tr>
    <td width=150px>  
      <a  href="index.php"><img src="img/LogotipoOficial.jpg" style="width:262px;"></a>
    </td>
    <td>
      <!-- <img src="img/moñonegro.png" style="width: 50px; height: 50px;"> -->
    </td>
    <td width=50px align=right>
        
<?php
  // require("lib/funciones.php");
  $notis = CuantasNotificaciones($nitavu);
  $msg="";
  if ($notis >0){
    $msg = $msg."<td class='pc' width=50px align=left><a title='Tienes ".$notis." notificaciones' href='notificaciones.php'>
    <img id='IconoDeAyuda' src='icon/notificacion_icon2.png' 
    style='
    
    ';
    >
    </a></span></td>";
  } else {
    $msg = $msg."<td class='pc' width=50px align=left><a title='Sin Notificaciones' href='notificaciones.php'>
    <img id='IconoDeAyuda' src='icon/notificacion_icon.png' 
    style='

    ';
    ></a></span></td>";
  }
  echo $msg;
?>

</td><td width=50px align=right>
<a style="opacity:0.8;" href="logout.php" title="Salir"><img src="icon/logout.png" style="width:50px;"></a>
</td></tr></table>
</nav>

<?php
  echo "<div id='avisos' style='background-color: #990000;'>";
  $nip =nitavu_nip($nitavu);
  if ($nip == $nitavu){
    echo "<li style='color:white; border-bottom:7px solid #bc955c;'> Por seguridad debes cambiar tu nip; ya que es igual que no. de empleado. Cambialo <a style='color:#bc955c;' href='nip_update.php' >aqui</a>"."</li>";
  }else {
    echo "<li style='color:white; border-bottom:7px solid #bc955c;'> Imagenes destacadas</li>";
  }
  echo "</div>";
?>

<?php
    $dpto = nitavu_dpto($nitavu);
    //------------------- Inicia carrusel  -------------------//
    $script = "select * from ControlDeCarrusel where IdEstatus = 0 and archivophp = 'index.php' order by OrdenVisual DESC";
    $result = $conexion->query($script);
    $row_cnt = $result->num_rows;

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
        $carouselinner .= "<img src='" . $rutaArchivo . "' class='d-block w-100' alt='" . htmlspecialchars($pieFoto) . "' onerror=\"this.style.display='none'; this.nextElementSibling.style.display='flex';\" />";
        $carouselinner .= "<div class='cd-carousel-fallback' style='display:none;'>";
        $carouselinner .= "<i class='fa-solid fa-building-columns cd-carousel-fallback-icon'></i>";
        $carouselinner .= "<h2 class='cd-carousel-fallback-title'>" . htmlspecialchars($pieFoto) . "</h2>";
        $carouselinner .= "<p class='cd-carousel-fallback-subtitle'><i class='fa-solid fa-bullhorn' style='color:var(--cd-gold);'></i> Información Destacada Plataforma ITAVU 2026</p>";
        $carouselinner .= "</div>";
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
    }
    //------------------- Termina carrusel  -------------------///


    //--------------------- Inicia menu ----------------------//
    echo "
    <div id='minMenu' style='width: 100%; text-align: right; background-color: transparent; padding: 10px;'>
      <table width=100%>
        <tr>
          <td align=right  width=80%>  
          </td>
          <td align=right width=20%>
            <b style='font-family: Compacta; color: #4f4f4f;'>Formas de vistas</b>
            <button class='btn-identidad-color1' onclick='BuscarApps(4);' title='MisFavoritos'><img src='icon/favorite1.png' style='width:18px'></button>
            <button class='btn-identidad-color1' onclick='BuscarApps(0);' title='Vista por Categorias'><img src='icon/view_1.png' style='width:18px'></button>
            <button class='btn-identidad-color1' onclick='BuscarApps(2);' title='Vista por Iconos'><img src='icon/view_2.png' style='width:18px'></button>
            <button class='btn-identidad-color1' onclick='BuscarApps(3);' title='Vista por DataTable'><img src='icon/view_3.png' style='width:18px'></button>
          </td>
        </tr>
      </table>
    </div>
    ";
    //--------------------- Termina Menu ----------------------//
?>

<div id='AppResultado' style="margin-top: 19px; text-align:center;"></div>

<?php
  echo "<div id='app_contenedor' style='background-color: #ccc;'>";
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
            echo "<div class='widget-hdd-row'><span>Espacio Total:</span><b>".$total_space_gb." GB</b></div>";
            echo "<div class='widget-hdd-row'><span>Espacio Usado:</span><b>".$used_space_gb." GB (".$used_percentage."%)</b></div>";
            echo "<div class='widget-hdd-row'><span>Espacio Disponible:</span><b>".$free_space_gb." GB (".$free_percentage."%)</b></div>";
            
            echo "<div class='widget-hdd-progress-container'>";
              if ($used_percentage > 80) {
                echo "<div class='widget-hdd-progress-bar'><div class='widget-hdd-progress-fill red' style='width: ".$free_percentage."%;'></div></div>";
                echo "<span class='widget-hdd-progress-text' style='color: #ef4444;'>¡Atención! Depurar espacio (".$free_percentage."% Libre)</span>";
              } else {
                echo "<div class='widget-hdd-progress-bar'><div class='widget-hdd-progress-fill green' style='width: ".$free_percentage."%;'></div></div>";
                echo "<span class='widget-hdd-progress-text'>".$free_percentage."% Libre</span>";
              }
            echo "</div>";
          echo "</div>";
        echo "</section>";
    }

    //Mes de octubre - Halloween
    //if (date("m")==10) {
    //  echo "<div id='videos' style = 'border-radius: 2px; background-color: black; background-color: rgb(0, 0, 0); border: 1px #000 solid; vertical-align: top; overflow: hidden; margin: 10px; border-radius: 4px; -webkit-box-shadow: 0px 3px 6px 0px rgba(0, 0, 0, 0.75); -moz-box-shadow: 0px 3px 6px 0px rgba(0, 0, 0, 0.75); box-shadow: 0px 3px 6px 0px rgba(0, 0, 0, 0.75); width:600px;'>";	
    //    echo "<video width='600' height='360' controls> <source src='videos/halloween.mp4' type='video/mp4'> Your browser does not support the video tag. </video>";
    //  echo "</div>";
    //}
    //if (date("m")==11) {
    //  echo "<div id='videos' style = 'border-radius: 2px; background-color: black; background-color: rgb(0, 0, 0); border: 1px #000 solid; vertical-align: top; overflow: hidden; margin: 10px; border-radius: 4px; -webkit-box-shadow: 0px 3px 6px 0px rgba(0, 0, 0, 0.75); -moz-box-shadow: 0px 3px 6px 0px rgba(0, 0, 0, 0.75); box-shadow: 0px 3px 6px 0px rgba(0, 0, 0, 0.75); width:600px;'>";	
    //    echo "<video width='600' height='360' controls> <source src='videos/diademuertos.mp4' type='video/mp4'> Your browser does not support the video tag. </video>";
    // echo "</div>";
    //}



?>



<?php
$VistaUser = Preference('VistaMenu', $nitavu, '');
// var_dump($VistaUser);
if ($VistaUser == 'NoR') {
  $VistaUser = 0;
} 
echo "
<script>
function BuscarApps(mode){   
  $('#progressbar').show();  
  
    busqueda = $('#InputBusqueda').val();
    console.log('Buscando ' + busqueda);
        $.ajax({
            url: 'menu_search.php',
            type: 'post',			
            data: {nitavu: '".$nitavu."', busqueda:busqueda, mode:mode },
            success: function(data){
            $('#AppResultado').html(data);
            $('#progressbar').hide();
            
            }
        });
			
}
BuscarApps(".$VistaUser.");


function Favorite(IdApp){   
  console.log('ElApp es: ' +  IdApp);
  $('#progressbar').show();  
  busqueda = $('#InputBusqueda').val();
  console.log('Buscando ' + busqueda);
      $.ajax({
          url: 'preference_appsfavorite.php',
          type: 'post',			
          data: {nitavu: '".$nitavu."', IdApp:IdApp },
          success: function(data){
          $('#R').html(data);          
          $('#progressbar').hide();
          
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
      data: {nitavu: '".$nitavu."', busqueda:busqueda, mode:mode },
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
include ("lib/body_footer.php");


?>
</div>
<div id='MenuFooter' style='
    
'>
<table width=100%></tr><td width=50px>
  <a href="perfil.php" id="FotoFooter" class="pc">          
  
    <?php 
    echo ponerfoto("fotos/".$nitavu.".jpg",'fotoMenu'); 
    ?> 
  
  </a>
</td><td valign=top align=center>
    <article class='movil'>
      <table><tr><td valign=midle align=center width=20px>
      <img src='icon/tr_o_verde.png' style='width:12px;'>
      </td><td>
      <a class='btn-Link' style='color:white; font-size:9pt; text-decoration:none;' href='perfil.php'>
      Mi Perfil
      </a>
    </td></tr></table>
    </article>


<article>
  <table><tr><td valign=midle align=center width=20px>
  <img src='icon/tr_o_verde.png' style='width:12px;'>
  </td><td>
  <a class='btn-Link' style='color:white; font-size:9pt; text-decoration:none;' href='SETUP_TokenPlataforma.zip' download>   
  Instalacion del TOKEN
  </a>
</td></tr></table>
</article>


<article>
  <table><tr><td valign=midle align=center width=20px>
  <img src='icon/tr_o_verde.png' style='width:12px;'>
  </td><td>
  <a class='btn-Link' style='color:white; font-size:9pt; text-decoration:none;' href='#Acuerdo' rel=MyModal:open>
   Acuerdo de Confidencialidad
  </a>
</td></tr></table>
</article>



</td></tr></table>
</div>
