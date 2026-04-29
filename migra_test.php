<?php
include("validas_config.php");










$sql = "SELECT * FROM notificaciones_old order by manzana_lote ASC";
$r2 = $conexionmigra -> query($sql);
$tmp="";
while($f = $r2 -> fetch_array())
	{//Categorias de Aplicaciones
	
		echo $f['contrato']." ".$f['manzana_lote']."<br>";
		
		
	
	}












?>

