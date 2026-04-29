<script type="text/javascript" charset="utf-8" >
if (typeof navigator.geolocation == 'object'){
    navigator.geolocation.getCurrentPosition(mostrar_ubicacion);
}

function mostrar_ubicacion(p)
{
    global="lat="+p.coords.latitude+'&lon='+p.coords.longitude;
	var urlDestino = "geo_ini.php?"+global;
	//alert(global);

	window.open(urlDestino, '_self');
}

     
</script>



<?php 
include ("./unica/body_head.php");
//include ("./unica/seguridad.php"); 

if (isset($_GET["lat"])){
 $lat = $_GET["lat"];
 $lon = $_GET["lon"]; 
 $descripcion = "INICIO";
 $info = detectar();
$sql = "INSERT INTO empleados_geo (nitavu, lat, lon, fecha, hora, descripcion, info)
		VALUES	('$nitavu', '$lat', '$lon', '$fecha', '$hora','$descripcion','$info')";
		if ($conexion->query($sql) == TRUE)
		{ header('location:../index.php');
			//echo "ok";
		}
		else
		{
			header('location:../index.php');
		}

	
	
}
else
{
	header('location:../index.php');
}

?>