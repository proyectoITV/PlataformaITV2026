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

 	

    <!-- <script type="text/javascript" src="https://maps.google.com/maps/api/js?sensor=true"></script> -->
    <script type="text/javascript">
    function initMap() {

        var myLatlng = new google.maps.LatLng(<?php echo $Lat ?>, <?php echo $Lon; ?>);
        var map = new google.maps.Map(document.getElementById('mapax'), {
		  zoom: 10,
		  center: myLatlng,
		  mapTypeId: 'satellite',
     	  center: {lat: <?php echo $Lat;?>, lng: <?php echo $Lon; ?>},
        });





            <?php
            $sql = "select * from notificaciones_vivienda where latitud <> ''and longitud <> '' order by fecha limit 100";
            $r= $conexion -> query($sql);
            $c = 1;
            while($f = $r -> fetch_array()) {
            $info = "<div><h1>".$f['nombre']."</h1>Contrato: ".$f['numcontrato'].", IdLote: ".$f['idlote']."<br>Delegacion: ".$f['delegacion']."<br>Fecha de Entrega: ".$f['fecha_entrega']."<br>Comentarios: ".$f['comentarios']."</div>";
            // $info = "Test";
            echo "
                var marker".$c." = new google.maps.Marker({ position: new google.maps.LatLng(".$f['latitud'].", ".$f['longitud']."), map: map, });   
                var infowindow".$c." = new google.maps.InfoWindow({ content: '".$info."' });   
                google.maps.event.addListener(marker".$c.", 'click', function() {   
                infowindow".$c.".open(map, marker".$c."); }); 
            
            ";

        


            $c = $c+1;
            }
            
            ?>




      }



    </script>

    <?php 
    echo '
    <script src="https://maps.googleapis.com/maps/api/js?key='.$key_geo.'&callback=initMap"
    async defer></script>';


    ?>
<div id='mapax'>

</div>

<?php
    include ("./lib/body_footer.php");
?>