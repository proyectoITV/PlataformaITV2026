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
<table width=100% border=0><tr><td width=150px>  
    <a  href="index.php"><img src="img/LogotipoOficial.jpg" style="width:262px;"</a>
</td><td>

</td><td width=50px align=right>
        
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

    //------------------- Carrusel  -------------------//
    echo "
      <div id='ControlDeCarrusel'>
        <div id='carouselExampleCaptions' class='carousel slide' data-bs-ride='carousel'>
          <div class='carousel-indicators'>
              <button type='button' data-bs-target='#carouselExampleCaptions' data-bs-slide-to='0' class='active' aria-current='true' aria-label='Slide 0'></button>
              <button type='button' data-bs-target='#carouselExampleCaptions' data-bs-slide-to='1' aria-label='Slide 1'></button>
              <button type='button' data-bs-target='#carouselExampleCaptions' data-bs-slide-to='2' aria-label='Slide 2'></button>
              <button type='button' data-bs-target='#carouselExampleCaptions' data-bs-slide-to='3' aria-label='Slide 3'></button>
              <button type='button' data-bs-target='#carouselExampleCaptions' data-bs-slide-to='4' aria-label='Slide 4'></button>
              <button type='button' data-bs-target='#carouselExampleCaptions' data-bs-slide-to='5' aria-label='Slide 5'></button>
          </div>
          <div class='carousel-inner'> 
              <div class='carousel-item active'><img src='img/carouseles/1500escrituras.jpg' class='d-block w-100' alt='...'> <div class='carousel-caption d-none d-md-block'> <p>ENTREGA DE 1500 ESCRITURAS</p> </div> </div>
              <div class='carousel-item'> <img src='img/carouseles/1.png' class='d-block w-100' alt='...'> <div class='carousel-caption d-none d-md-block'> <p>DEPARTAMENTO DE CONTROL DE INTERNO</p> </div> </div>
              <div class='carousel-item'> <img src='img/carouseles/2.png' class='d-block w-100' alt='...'> <div class='carousel-caption d-none d-md-block'> <p>DEPARTAMENTO DE CONTROL DE INTERNO</p> </div> </div>
              <div class='carousel-item'> <img src='img/carouseles/3.png' class='d-block w-100' alt='...'> <div class='carousel-caption d-none d-md-block'> <p>DEPARTAMENTO DE CONTROL DE INTERNO</p> </div> </div>
              <div class='carousel-item'> <img src='img/carouseles/ps_imagen8.jpg' class='d-block w-100' alt='...'> <div class='carousel-caption d-none d-md-block'> <p>ENTREGA DE 1500 ESCRITURAS</p> </div> </div>
              <div class='carousel-item'> <img src='img/carouseles/encuestadesatisfaccion.jpg' class='d-block w-100' alt='...'> <div class='carousel-caption d-none d-md-block'> <p>ENCUESTA DE SATISFACCION DE TRAMITES Y SERVICIOS</p> </div> </div>
          </div>
          <button class='carousel-control-prev' type='button' data-bs-target='#carouselExampleCaptions' data-bs-slide='prev'> <span class='carousel-control-prev-icon' aria-hidden='true'></span> <span class='visually-hidden'>Previous</span> </button>
          <button class='carousel-control-next' type='button' data-bs-target='#carouselExampleCaptions' data-bs-slide='next'> <span class='carousel-control-next-icon' aria-hidden='true'></span> <span class='visually-hidden'>Next</span> </button>
      </div>
    </div>
    ";

  //------------------- Menu  -------------------//
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
