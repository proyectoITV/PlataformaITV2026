<?php
//include ("./unica/seguridad.php"); 
include ("./unica/body_head.php");
include ("./unica/body_menu.php");

// contenido:
?>
<div id="infomaps">
<?php

//PROCESO PARA TOCAR LA PUERTA DE SAN PEDRO
// SOLO DOS NIVELES
$id_aplicacion ="ap29"; //Id de la aplicacion a cargar
$nivel = aplicacion_nivel($id_aplicacion, $nitavu);
// if (sanpedro($id_aplicacion, $nitavu)==TRUE){
// 	//echo "<h5>".app_detalle($id_aplicacion)."</h5>";
	
	

				
// }
// else
// {
// 	mensaje ("No tiene el permiso para usar esta aplicacion",'');
// }		
historia($nitavu,"Vio una geolocalizacion de ".$_GET['title']."<br>".$_GET['div']);
?>

 	

    <script type="text/javascript" src="https://maps.google.com/maps/api/js?sensor=true"></script>
    <script type="text/javascript">
    function initMap() {
    	var myLatlng = new google.maps.LatLng(<?php echo $_GET['lat']; ?>, <?php echo $_GET['lon']; ?>);
        
        var map = new google.maps.Map(document.getElementById('mapax'), {
		  zoom: 20,
		  center: myLatlng,
		  mapTypeId: 'satellite',
     	  center: {lat: <?php echo $_GET['lat'];?>, lng: <?php echo $_GET['lon']; ?>},


        });

        var contentString = '<div>'+'<?php echo $_GET['div']; ?>'+'</div>';

        var infowindow = new google.maps.InfoWindow({
          content: contentString
        });

        var marker = new google.maps.Marker({
          position: myLatlng,
          map: map,
          title: '<?php echo $_GET['title']; ?>'
        });
        marker.addListener('click', function() {
          infowindow.open(map, marker);
        });
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
include ("./unica/body_footer.php");
?>