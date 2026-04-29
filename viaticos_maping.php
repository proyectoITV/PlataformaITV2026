<?php
require("config.php");
require("seguridad.php");
require("var_clean.php");
require("lib/funciones.php");
require("lib/flor_funciones.php");
require("viaticos_fun.php");
// require_once("lib/flor_funciones.php");
if ($ServiciosGoogle == TRUE){
$IdViatico = VarClean($_POST['IdViatico']);
$NEmpleado = VarClean($_POST['NEmpleado']);
$sql = "select * from viaticosrecorridos WHERE IdViatico = '".$IdViatico."' order by IdRecorrido ASC";

echo "<script>

var map = new google.maps.Map(document.getElementById('gmap'), {	
        zoom: 5,
        center: {lat: 41.876, lng: -87.624
        }
    });
";
$r= $conexion -> query($sql);   
while($V = $r -> fetch_array())
{
    $Token = MiToken_generate();
    echo "
            OrigenLat".$Token." = '".$V['Origen_lat']."';
            OrigenLon".$Token." = '".$V['Origen_lon']."';
            DestinoLat".$Token." = '".$V['Destino_lat']."';
            DestinoLon".$Token." ='".$V['Destino_lon']."';
        ";

    

            //echo "console.log('".$V['Origen']." - ".$V['Destino']."OrigenLat = ' + OrigenLat".$V['IdRecorrido'].");";
            //echo "console.log('".$V['Origen']." - ".$V['Destino']."OrigenLon = ' + OrigenLon".$V['IdRecorrido'].");";
            //echo "console.log('".$V['Origen']." - ".$V['Destino']."DestinoLat = ' + DestinoLat".$V['IdRecorrido'].");";
            //echo "console.log('".$V['Origen']." - ".$V['Destino']."DestinoLon = ' + DestinoLon".$V['IdRecorrido'].");";
    echo "
    const directionsService".$Token." = new google.maps.DirectionsService();
    const directionsRenderer".$Token." = new google.maps.DirectionsRenderer();
    directionsRenderer".$Token.".setMap(map);
    const request".$Token." = {
            origin: new google.maps.LatLng(OrigenLat".$Token.", OrigenLon".$Token."),
            destination: new google.maps.LatLng(DestinoLat".$Token.", DestinoLon".$Token."),
            travelMode: 'DRIVING',
            drivingOptions: {
                departureTime: new Date(Date.now()),  // for the time N milliseconds from now.
                trafficModel: 'optimistic'
              }
        };

    directionsService".$Token.".route(request".$Token.", response => {
        directionsRenderer".$Token.".setDirections(response);
    });

";

}

unset($V, $r, $sql);
echo "</script>";
}

?>