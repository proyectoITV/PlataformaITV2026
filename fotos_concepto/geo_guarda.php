
<?php 
include ("./unica/body_head.php");
include ("./unica/seguridad.php"); 
//require("../unica/funciones.php");
//require("../unica/config.php");



if (isset($_GET["lat"])){
 $lat = $_GET["lat"];
 $lon = $_GET["lon"]; 
 //$nitavu = $_GET["nitavu"];
 $descripcion = "usando la plataforma";
 //echo "Lat: ".$miLatitud."<br>";
 //echo "Lon: ".$miLongitud."<br>";


	//geo_guarda($nitavu, $miLatitud, $miLongitud, 'Inicio de Sesion');
	$sql = "INSERT INTO empleados_geo
		(nitavu, lat, lon, fecha, hora, descripcion)
		VALUES
		('$nitavu', '$lat', '$lon', '$fecha', '$hora','$descripcion')";
		if ($conexion->query($sql) == TRUE)
		{
			//return TRUE;
			header('location:../index.php');	
			//echo "ok";
		}
		else
		{
			//return FALSE;
			header('location:../index.php');	
		}

	
	
}

?>