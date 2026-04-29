<?php
include ("lib/body_head.php");
include ("lib/body_menu.php");

?>

<!--  -->

<nav class="navbar navbar-expand-md navbar-light " style="background-color:<?php echo Preference("ColorPrincipal","",""); ?>">
  <a class="navbar-brand" href="index.php"><img src="img/Logo.png" style="width:100px;"></a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">
 
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        
        <?php echo ponerfoto("fotos/".$nitavu.".jpg",'fotoMenu'); ?>          
        
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
        <a class="dropdown-item" href="perfil.php">Perfil</a>
         
        <div class="dropdown-divider"></div>
          <a class="dropdown-item" href="logout.php">Cerrar Cesion</a>
        </div>
      </li>
     
    </ul>
    <div class="form-inline my-2 my-lg-0">
      <input style="
          height: 44px;
          border-radius: 5px;
      "class="form-control mr-sm-2" id="InputBusqueda" type="search" placeholder="Busqueda..." aria-label="Busqueda">
      <button  class="Mbtn btn-Success"  style="
    background-color:  <?php echo Preference("ColorResaltado", "", ""); ?>;
    box-shadow: 0 3px  #4d4c49; 
    "
    onclick='BuscarApps(1);'
    > 
    <img id='PreloaderBuscando' src='img/loader_bar.gif' style='display:none; '>
    <img id='IconBusqueda' src='icon/busqueda.png' style='width:24px;' ></button>
</div>
  </div>
</nav>

<?php

?>
<div id='minMenu' style='width: 100%;
text-align: right; padding-top:5px;'>
<button class='Mbtn btn-Gray' onclick='BuscarApps(4);' title='MisFavoritos'><img src='icon/favorite1.png' style='width:18px'></button>
<button class='Mbtn btn-Gray' onclick='BuscarApps(0);' title='Vista por Categorias'><img src='icon/view_1.png' style='width:18px'></button>
<button class='Mbtn btn-Gray' onclick='BuscarApps(2);' title='Vista por Iconos'><img src='icon/view_2.png' style='width:18px'></button>
<button class='Mbtn btn-Gray' onclick='BuscarApps(3);' title='Vista por DataTable'><img src='icon/view_3.png' style='width:18px'></button>

</div>
<div id='AppResultado' style="
margin-top: 19px;
text-align:center;

">

</div>
<?php

//-------  AREA DE WIDGETS INFERIOR, estos aparecen al final de las aplicaciones segun tengan acceso	
//el acceso a estos sera como ser aplicaciones
echo "<div id='app_contenedor' >";
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



echo "<div id='aplicaciones'>";
echo "<h4 style='font-size:12pt;'>Documentacion sobre Control Interno</h4>";
echo "<table class='tabla'>";

echo "<tr>";
echo "<td width=50px><img src='icon/pdf.png' class='icono'></td><td>";
echo "<a href='ci/00-OrdendeLectura.pdf' target=_blank title='Haga clic aqui para ver el archivo'>
00 - Orden de Lectura.pdf
</a>
";
echo "</td>";
echo "</tr>";



echo "<tr>";
echo "<td width=30px><img src='icon/pdf.png' class='icono'></td><td>";
echo "<a href='ci/01-ITAVU.pdf' target=_blank title='Haga clic aqui para ver el archivo'>
01 - ITAVU.pdf
</a>
";
echo "</td>";
echo "</tr>";


echo "<tr>";
echo "<td width=30px><img src='icon/pdf.png' class='icono'></td><td>";
echo "<a href='ci/02-ManualdeOrganizacionyEstatutoOrgánico.pdf' target=_blank title='Haga clic aqui para ver el archivo'>
02 - Manual de Organización y Estatuto Orgánico.pdf
</a>
";
echo "</td>";
echo "</tr>";




echo "<tr>";
echo "<td width=30px><img src='icon/pdf.png' class='icono'></td><td>";
echo "<a href='ci/03-ManualdeProcedimientos(Ejemplo).pdf' target=_blank title='Haga clic aqui para ver el archivo'>
03 - Manual de Procedimientos (Ejemplo).pdf
</a>
";
echo "</td>";
echo "</tr>";


echo "<tr>";
echo "<td width=30px><img src='icon/pdf.png' class='icono'></td><td>";
echo "<a href='ci/04-MarcoJuridico.pdf' target=_blank title='Haga clic aqui para ver el archivo'>
04 - Marco Juridico.pdf
</a>
";
echo "</td>";
echo "</tr>";



echo "<tr>";
echo "<td width=30px><img src='icon/pdf.png' class='icono'></td><td>";
echo "<a href='ci/05-CodigoEticaTamaulipas2018.pdf' target=_blank title='Haga clic aqui para ver el archivo'>
05 - Código Ética Tamaulipas 2018.pdf
</a>
";
echo "</td>";
echo "</tr>";


echo "<tr>";
echo "<td width=50px><img src='icon/pdf.png' class='icono'></td><td>";
echo "<a href='ci/06-CodigodeConducta.pdf' target=_blank title='Haga clic aqui para ver el archivo'>
06 - Codigo de Conducta.pdf
</a>
";
echo "</td>";
echo "</tr>";



echo "<tr>";
echo "<td width=50px><img src='icon/pdf.png' class='icono'></td><td>";
echo "<a href='ci/07-CartaCompromiso.pdf' target=_blank title='Haga clic aqui para ver el archivo'>
07 - Carta Compromiso.pdf
</a>
";
echo "</td>";
echo "</tr>";









echo "</table>";
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
    $('#PreloaderBuscando').show();
    $('#IconBusqueda').hide();
    busqueda = $('#InputBusqueda').val();
    console.log('Buscando ' + busqueda);
        $.ajax({
            url: 'menu_search.php',
            type: 'post',			
            data: {nitavu: '".$nitavu."', busqueda:busqueda, mode:mode },
            success: function(data){
            $('#AppResultado').html(data);
            $('#PreloaderBuscando').hide();
            $('#IconBusqueda').show();
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
</script>
    ";
?>
<?php
include ("lib/body_footer.php");


?>
