<?php
include ("lib/body_head.php");
include ("lib/body_menu.php");
if (isset($_GET['msg'])){
  Toast($_GET['msg'],0,"");
}

// if (CheckServiciosGoogle()==FALSE) {
//   Toast("No se ha podido conectar a los servicios de Google",2,"");
// }
?>

<nav style="background-color:<?php echo Preference("ColorPrincipal","",""); ?>; padding:10px;">
<table width=100% border=0><tr><td width=150px>  
    <a  href="index.php"><img src="img/logo_white.png" style="width:262px;"</a>
</td><td>

</td><td width=50px align=right>
        
         
</td><td width=50px align=right>
<a style="opacity:0.8;" href="logout.php" title="Salir"><img src="icon/logout.png" style="width:50px;"></a>
</td></tr></table>
</nav>

<?php

?>




<?php
//Busqueda solo disponible | por el momento para Informatica

$dpto = nitavu_dpto($nitavu);

if ($dpto == 55) {
echo "<div id='SuperBusqueda_Div'>";

echo "
<div id='minMenu' style='
width: 100%;
text-align: right;
background-color: transparent;
padding: 10px;


'>
<table width=100%>
<tr><td align=right width=40%>
<b style='font-family: Compacta;
color: #4f4f4f;'></b>
<button class='Mbtn btn-Gray' onclick='BuscarApps(4);' title='MisFavoritos'><img src='icon/favorite1.png' style='width:18px'></button>
<button class='Mbtn btn-Gray' onclick='BuscarApps(0);' title='Vista por Categorias'><img src='icon/view_1.png' style='width:18px'></button>
<button class='Mbtn btn-Gray' onclick='BuscarApps(2);' title='Vista por Iconos'><img src='icon/view_2.png' style='width:18px'></button>
<button class='Mbtn btn-Gray' onclick='BuscarApps(3);' title='Vista por DataTable'><img src='icon/view_3.png' style='width:18px'></button>
</tr></tr></table>
</div>
";

echo "<div id='SuperBusqueda_Form'>";
  echo "<table width=100%><tr><td>";
    echo "<input type='text' id='busqueda' name='busqueda' style='border-color: white;'>";
    echo "</td><td width=30px>";
    echo "<img src='icon/buscar.png' style='width:32px; cursor:pointer;' title='Haga clic aqui para iniciar la SuperBusqueda' onclick='SuperBusqueda();'>";
  echo "</td></tr></table>";
echo "</div>";



echo "</div>";


}





?>


<div id='AppResultado' style="
margin-top: 19px;
text-align:center;

">

</div>






















<?php

//-------  AREA DE WIDGETS INFERIOR, estos aparecen al final de las aplicaciones segun tengan acceso	
//el acceso a estos sera como ser aplicaciones
echo "<div id='app_contenedor' style='background-color: #ccc;'>";
    echo "<div id='aplicaciones'><center>";	
    if ($nitavu <> '2772'){
      // echo "<div id='salidas' style='background-color:white; border-radius:10px; width:90%;'>";
      echo "<table width=100%><tr>";
      echo "<td>";
      include("widget_salidas.php");
      echo "</td></tr></table></center>";
    }
    echo "</div>";

  // if (sanpedro('atencionw', $nitavu)==TRUE){
  //   echo ""; include("atencion_widget.php");echo "";
  // } else {
  //   // include("widget_tiempo.php");//<-- solo victoria por ahora
  //   // include("widget_cumples.php");
    echo "<div id='aplicaciones'>";	
      if ($nitavu <> '2772'){
        include("widget_cumples.php");
      }
    // }  
    echo "</div>";
// if (sanpedro('w5', $nitavu)==TRUE){echo ""; include("widget_req.php");echo "";}
// if (sanpedro('w4', $nitavu)==TRUE){echo ""; include("widget_actividad.php");echo "";}




//-----------------------------------	









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
            url: 'menu_search2.php',
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

<script src="lib/fluid/responsive_waterfall.js"></script>
<script src="lib/fluid/app.js"></script>