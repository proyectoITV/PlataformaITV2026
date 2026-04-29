<?php


//WIDGET PROTOTIPO


$Widget_nombre="* EN CONTRUCCION...";
$Widget_contenido="";
$empleados_sindpto_quienes="";
//require("config.php");

$Widget_contenido = $Widget_contenido."<form action= method=get>";
$Widget_contenido = $Widget_contenido."<table border=0 width=100%><tr>";
$Widget_contenido = $Widget_contenido."<td align=center valign=center>";

$Widget_contenido = $Widget_contenido."<td align=left valign=center >";
$Widget_contenido = $Widget_contenido."<button style='background-color:#E3D79F; border-radius:5px; height:48px;'><img  src='icon/redactar.png' style='width:32px; height;32px;'></button></td>";

$Widget_contenido = $Widget_contenido."<td align=left valign=center Width='15px'>";
$Widget_contenido = $Widget_contenido."<button style='background-color:#E3D79F; border-radius:5px; height:48px;'><img style='width:32px; height;32px;'  src='icon/mensaje.png'></button></td>";
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

