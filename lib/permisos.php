<?php

require("config.php");
require("funciones.php");

$search="jefe";
$sql = "SELECT * FROM empleados WHERE ";
$sql = $sql."(puesto LIKE '%jefe%') OR";
$sql = $sql."(puesto LIKE '%director%') OR";
$sql = $sql."(puesto LIKE '%subdirector%') OR";
$sql = $sql."(puesto LIKE '%delegado%') OR";
$sql = $sql."(puesto LIKE '%particular%') OR";
$sql = $sql."(puesto LIKE '%coor%')";


$r2 = $conexion -> query($sql);
$tmp="";
while($f = $r2 -> fetch_array())
	{//Categorias de Aplicaciones
	
	$n= $f['nitavu'];	
    // ap12, ap09, ap15, ap03
	$sql = "INSERT INTO aplicaciones_permisos
		(nitavu, idapp, nivel, quien_autorizo)
		VALUES
		('$n', 'ap12', '3', 'admin')";
		if ($conexion->query($sql) == TRUE)
		{
			echo user_legend($f['nitavu'])." OK <br>";
		}
		else
		{
			echo user_legend($f['nitavu'])." X (".$sql.")<br>";
		}

	
		
	
	}


?>