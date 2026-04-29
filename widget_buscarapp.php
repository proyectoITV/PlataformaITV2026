<?php


//WIDGET PROTOTIPO


$Widget_nombre="Buscar Mis Aplicaciones";
$Widget_contenido="";
$empleados_sindpto_quienes="";
//require("config.php");

$Widget_contenido = $Widget_contenido."<form action=index.php method=get>";
$Widget_contenido = $Widget_contenido."<table border=0 width=100%><tr>";
$Widget_contenido = $Widget_contenido."<td align=center valign=center><input list='misapps' required='required' type='text'  name='busqueda' placeholder='escriba nombre o descrip...' style='border-radius:4px; height:50px; widht:100%;'></td>";
$Widget_contenido = $Widget_contenido."<td align=left valign=center width='15px'>";

$Widget_contenido = $Widget_contenido.'  <datalist id="misapps">';
$sql = "SELECT * FROM aplicaciones WHERE idapcat='8' or  idapcat='2' AND  version >'0'";
$r2 = $conexion -> query($sql); while($f = $r2 -> fetch_array())
{
	$Widget_contenido = $Widget_contenido.'<option value="'.$f['nombre'].'">';
    

}
$Widget_contenido = $Widget_contenido.'</datalist>';
$Widget_contenido = $Widget_contenido."<button style='background-color:#E3D79F; border-radius:5px; height:48px;' id='beta_buscar_boton'><img  src='icon/buscar.png'></button></td>";
$Widget_contenido = $Widget_contenido."</tr></table>";

$Widget_contenido = $Widget_contenido."</form>";

		


$tmp="";
$tmp = $tmp."<section id='aplicaciones' class='widget'>";
$tmp = $tmp. "<label>".$Widget_nombre."</label>";
$tmp = $tmp."<article >";
//$tmp = $tmp. "<a href=''>";
$tmp = $tmp. "<table border='0' width=100%><tr><td>";
$tmp = $tmp.$Widget_contenido."<br>";
$tmp = $tmp. "</td></tr></table></article>";

echo $tmp."</section>";
//echo $tmp."</section>";
?>

