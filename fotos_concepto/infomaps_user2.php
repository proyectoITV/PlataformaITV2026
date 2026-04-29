<?php
//include ("./unica/seguridad.php"); 
include ("./unica/body_head.php");
include ("./unica/body_menu.php");

// contenido:
?>
<div id="infomaps">
<?php

//PROCESO PARA TOCAR LA PUERTA DE SAN PEDRO
$id_aplicacion ="ap21"; //Id de la aplicacion a cargar
if (sanpedro($id_aplicacion, $nitavu)==TRUE){
	echo "<h5>".app_detalle($id_aplicacion)."</h5>";
	// span ocupa 100% y Div 50%;

		$sql = "SELECT * FROM empleados_geo WHERE (fecha='".$fecha."') ORDER by nitavu ASC";
		$r = $conexion -> query($sql);
		$info="";
		$lat = 0;
		$lon=0;
		$cuantos = 0;
		$usuarios ="";
		while($f = $r -> fetch_array())
			{ // resultado de la busqueda.................
				    //['Salamanca', 40.963, -5.669],
				$info = $info. "['".nitavu_nombre($f['nitavu'])."',".$f['lat'].",".$f['lon']."],";
				$lat = $lat + $f['lat'];
				$lon = $lon + $f['lon'];
				$cuantos = $cuantos + 1;

				$usuarios = $usuarios."
				<lu>".
				"<li><b>".nitavu_nombre($f['nitavu'])."</b><br><small>".
				nitavu_puesto($f['nitavu'])." de ".nitavu_dpto($f['nitavu'])."</small><br>".
				"<img src='icon/reloj.png' class='mini_icono'>".$f['hora']."</li>".
				"</lu>";
			
			}
			if ($cuantos>0){
			$lat = $lat / $cuantos;
			$lon = $lon /$cuantos;
			echo '
		<div id="mapa"></div>';
		echo '<div id="infomaps_info">';
		echo "<h5>Se registro  ".$cuantos." accesos a la plataforma.</h5>";

		echo '<iframe id="infomaps_frame" src="contenido.php?info='.$usuarios.'">';
		echo "</div>";



	echo "</iframe>";
   
		    }
			$info = substr($info, 0, -1);

			


		



		
}
else
{
	mensaje ("No tiene el permiso para usar esta aplicacion",'');
}		

?>

 	

    <script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=true"></script>
    <script type="text/javascript">
    function initialize() {
       var marcadores = [
 		<?php 
 		echo $info;

 		?>      

       ];


      var map = new google.maps.Map(document.getElementById('mapa'), {
        zoom: 8,

        center: new google.maps.LatLng(23.448379,-98.3077288),	
        mapTypeId: google.maps.MapTypeId.ROADMAP
      });
      var infowindow = new google.maps.InfoWindow();
      var marker, i;
      for (i = 0; i < marcadores.length; i++) {  
        marker = new google.maps.Marker({
          position: new google.maps.LatLng(marcadores[i][1], marcadores[i][2]),
          map: map
        });
        google.maps.event.addListener(marker, 'click', (function(marker, i) {
          return function() {
            infowindow.setContent(marcadores[i][0]);
            infowindow.open(map, marker);

            
          }
        })(marker, i));
      }
    }
    google.maps.event.addDomListener(window, 'load', initialize);
    </script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBCwwoSmsFVZ7zLa5IjrUm_NlvVH3MKAyU&callback=initMap"
    async defer></script>

<?php

 // la terminacion del while
?>
</div>
<?php
include ("./unica/body_footer.php");
?>