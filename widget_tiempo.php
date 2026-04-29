<?php


//WIDGET PROTOTIPO


$Widget_nombre="Clima:";
$wc="";
$empleados_sindpto_quienes="";
//require("config.php");

//$wc = $wc.'<section name="promos" id="promos2">';
$wc = $wc.'';
$sql = "select * from cat_gerarquia where id=45";
//echo $sql;
$r = $conexion -> query($sql);

while($f = $r -> fetch_array()){
	// $fecha_cumple = date('Y').substr($f['fecha_nacimiento'], 4);

	
		
        $wc = $wc. "<table border=0  width=100%><tr><td>";
        $wc = $wc.$f['clima'];
		$wc = $wc.'</td>';
		$wc = $wc. "</tr></table>";
		$wc = $wc.'';
	
}

	
$wc = $wc.'';

	   


$tmp="";
$tmp = $tmp."<section id='aplicaciones' class='widget'>";
$tmp = $tmp. "<label>".$Widget_nombre."</label>";
$tmp = $tmp."<article >";
//$tmp = $tmp. "<a href=''>";
$tmp = $tmp. "<table border='0' width=100%><tr><td>";
$tmp = $tmp.$wc."<br>";
$tmp = $tmp. "</td></tr></table></article>";

echo $tmp."</section>";
//echo $tmp."</section>";
?>

