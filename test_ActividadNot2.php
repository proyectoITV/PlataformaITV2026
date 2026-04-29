<?php
//include ("./lib/seguridad.php"); 
include ("./lib/body_head.php");
include ("./lib/body_menu.php");

// contenido:
?>
<div id="infomaps">
<?php

$id_aplicacion ="ap29"; //Id de la aplicacion a cargar
$nivel = aplicacion_nivel($id_aplicacion, $nitavu);
// historia($nitavu,"Vio una geolocalizacion de ".$_GET['title']."<br>".$_GET['div']);

//Vairables de Test
$Lat = "23.7462006";
$Lon = "-99.1103095";
$Titulo = "El Titulo";
$Div="<h1>titulo</h1>";
// $Div = "

// <h1>Manzana 6 Lote 47</h1>
// <div>Beneficiario: ANGELINA MONTALVO VAZQUEZ<br> Col. 
// <br>Contrato: 06781302299<br><br>Visita hecha por <b>Victor Manuel Rodriguez Arellano</b> a las 12:03:42 de 2017-11-23 y 
// Verificada (Vo.Bo.) Vo.Bo. por <b> Ing.. Carlos Aguilar Garcia</b>

// <div><img width=400px src=notificadores/06781302299_2017-11-23_lote.jpg><br> Clasificada como Habitado

// ";

?>

<?php 
    echo '
    <script src="https://maps.googleapis.com/maps/api/js?key='.$key_geo.'&callback=initMap"
    async defer></script>';
?>

<!-- <script src="javascripts/jquery.js"></script> -->
<!-- <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=YOUR-API-KEY"></script> -->
<!-- <script src="mapas/jquery.maps.js"></script> -->
<script src="https://cdn.jsdelivr.net/gmap3/7.2.0/gmap3.min.js">
<script>
     $('.elmapa')
      .gmap3({
        center:[48.8620722, 2.352047],
        zoom:4
      })
      .marker([
        {position:[48.8620722, 2.352047]},
        {address:"86000 Poitiers, France"},
        {address:"66000 Perpignan, France", icon: "https://maps.google.com/mapfiles/marker_grey.png"}
      ])
      .on('click', function (marker) {
        marker.setIcon('https://maps.google.com/mapfiles/marker_green.png');
      });


</script>


<div id='mapax' class='elmapa'>

</div>

<?php
    include ("./lib/body_footer.php");
?>