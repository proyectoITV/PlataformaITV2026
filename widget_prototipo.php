<?php


//WIDGET PROTOTIPO


$Widget_nombre="PENDIENTES REC. HUMANOS";
$Widget_contenido="";
$empleados_sindpto_quienes="";
//require("config.php");
$sql = "SELECT * FROM empleados WHERE dpto=''";
$rc= $conexion -> query($sql);
$empleados_sindpto = $rc -> num_rows;
while($m = $rc -> fetch_array()) {
		$empleados_sindpto_quienes = $empleados_sindpto_quienes."<a href='http://localhost/empleados_edit.php?pes=lab&n=".$m['nitavu']."'>";
		$empleados_sindpto_quienes = $empleados_sindpto_quienes.$m['nitavu']."</a>, ";
}
	
$Widget_contenido= $Widget_contenido."<lu>";
$Widget_contenido= $Widget_contenido."<li>Hay ".$empleados_sindpto." empleados sin dpto:"."<br><label>
Se require actualizar el perfil del empleado y seleccionar <b>Departamento ID</b>; para realizarlo puede dar clic en la siguiente lista al que corresponda: (".$empleados_sindpto_quienes.")</label></li>";

$Widget_contenido= $Widget_contenido."</lu>";



$tmp="";
$tmp = $tmp."<section id='aplicaciones' class='widget'>";
$tmp = $tmp. "<label>".$Widget_nombre."</label>";
$tmp = $tmp."<article >";
$tmp = $tmp. "<a href=''>";
$tmp = $tmp. "<table border='0'><tr><td>";
$tmp = $tmp.$Widget_contenido;
$tmp = $tmp. "</td></tr></table></a></article>";

echo $tmp."</section>";
//echo $tmp."</section>";
?>

