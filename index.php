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
    $result = $conexion -> query($script);
    $row_cnt = $result->num_rows;

    $secuencia = 0;
    $carouselindicators = "";
    $carouselinner = "";

    if ($row_cnt>0) {
      while($valor = $result -> fetch_array()){
        if ($secuencia == 0) {
          $carouselindicators = $carouselindicators."<button type='button' data-bs-target='#carouselExampleCaptions' data-bs-slide-to='".$secuencia."' class='active' aria-current='true' aria-label='Slide ".$secuencia."'></button>";
          $carouselinner = $carouselinner."<div class='carousel-item active'> <img src='".$valor["rutadelarchivo"]."' class='d-block w-100' style='height:450px;'> <div class='carousel-caption d-none d-md-block'> <p style='color: ".$valor["colordetexto"].";'>".strtoupper($valor["comentariopiedefoto"])." | PUBLICADO ".date("d/m/Y H:i:s", strtotime($valor["ultimoacceso"]))."</p></div> </div>";
        }
        else {
          $carouselindicators = $carouselindicators."<button type='button' data-bs-target='#carouselExampleCaptions' data-bs-slide-to='".$secuencia."' aria-label='Slide ".$secuencia."'></button>";
          $carouselinner = $carouselinner."<div class='carousel-item'> <img src='".$valor["rutadelarchivo"]."' class='d-block w-100' style='height:450px;'> <div class='carousel-caption d-none d-md-block'> <b><p style='color: ".$valor["colordetexto"].";'>".strtoupper($valor["comentariopiedefoto"])." | PUBLICADO ".date("d/m/Y H:i:s", strtotime($valor["ultimoacceso"]))."</p></b></div> </div>";
        }
        $secuencia = $secuencia + 1;
      }
      echo "
        <div id='ControlDeCarrusel'>
          <div id='carouselExampleCaptions' class='carousel slide' data-bs-ride='carousel'>
            <div class='carousel-indicators'>".$carouselindicators."</div>
            <div class='carousel-inner'> ".$carouselinner."</div>
            <button class='carousel-control-prev' type='button' data-bs-target='#carouselExampleCaptions' data-bs-slide='prev'> <span class='carousel-control-prev-icon' aria-hidden='true'></span> <span class='visually-hidden'>Previous</span> </button>
            <button class='carousel-control-next' type='button' data-bs-target='#carouselExampleCaptions' data-bs-slide='next'> <span class='carousel-control-next-icon' aria-hidden='true'></span> <span class='visually-hidden'>Next</span> </button>
          </div>
        </div>
      ";
    }
    //------------------- Termina carrusel  -------------------//


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
    echo "<div id='aplicaciones'><center>";	
      echo "<table width=100%><tr>";
      echo "<td>";
      include("widget_salidas.php");
      echo "</td></tr></table></center>";
    echo "</div>";

    echo "<div id='aplicaciones'>";	
        include("widget_cumples.php");
    echo "</div>";

    echo "<div id='aplicaciones'>";	
      $total_space_bytes = disk_total_space("/"); // "/" refers to the root directory
      $free_space_bytes = disk_free_space("/");
      
      $total_space_gb = round($total_space_bytes / (1024 * 1024 * 1024), 2);
      $free_space_gb = round($free_space_bytes / (1024 * 1024 * 1024), 2);
      $used_space_gb = round($total_space_gb - $free_space_gb, 2);
      $used_percentage = round(($used_space_gb / $total_space_gb) * 100, 2);

      echo "<div id='disk_space_info' style='border-radius: 2px; background-color: white; border: 1px #ddd solid; vertical-align: top; overflow: hidden; margin: 10px; border-radius: 4px; -webkit-box-shadow: 0px 3px 6px 0px rgba(0, 0, 0, 0.25); -moz-box-shadow: 0px 3px 6px 0px rgba(0, 0, 0, 0.25); box-shadow: 0px 3px 6px 0px rgba(0, 0, 0, 0.25); width:345px; padding: 15px; display: inline-block; /* To allow it to sit next to other widgets */ text-align: left; '>";
        echo "<h4 style='color: #4f4f4f; margin-top: 0;'>Capacidad de HDD</h4>";
        echo "<p style='margin-bottom: 5px;'>Espacio Total: <b>".$total_space_gb." GB</b></p>";
        echo "<p style='margin-bottom: 5px;'>Espacio Usado: <b>".$used_space_gb." GB</b> (".$used_percentage."%)</p>";
        echo "<p style='margin-bottom: 15px;'>Espacio Disponible: <b>".$free_space_gb." GB</b> (".(100-$used_percentage)." %) </p>";
        echo "<div style='width: 100%; background-color: #f3f3f3; border-radius: 5px; overflow: hidden; height: 20px; /* Height of the progress bar */  '>";
          if ($used_percentage>80) {
            echo "<div style='width: ".(100-$used_percentage)."%; background-color: red; height: 100%; border-radius: 5px; text-align: center; color: white; line-height: 20px; font-size: 12px; '>";
              echo "<p style='padding: 1px;'>Depurar</p>";
            echo "</div>";
          } else {
            echo "<div style='width: ".(100-$used_percentage)."%; background-color: #4CAF50; height: 100%; border-radius: 5px; text-align: center; color: white; line-height: 20px; font-size: 12px; '>";
            echo "<p style='padding: 1px;'>".(100-$used_percentage)." % Libre</p>";
            echo "</div>";
          }
        echo "</div>";
      echo "</div>";
    echo "</div>";

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
