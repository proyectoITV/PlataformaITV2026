<?php


//WIDGET PROTOTIPO


$Widget_nombre="APP moviles";
$Widget_contenido="";
$empleados_sindpto_quienes="";
//require("config.php");



$tmp="";
$tmp = $tmp."<section id='aplicaciones' class='widget'>";
$tmp = $tmp. "<label>".$Widget_nombre."</label>";
$tmp = $tmp."<article >";
$tmp = $tmp. "<a href='app/itavu103.apk' download='itavu103.apk'>";
$tmp = $tmp. "<table border='0'><tr><td>";
$tmp = $tmp."<img src='icon/android.png' class='icono' >ITAVUmov beta1";
$tmp = $tmp. "</td></tr></table></a></article>";

echo $tmp."</section>";
//echo $tmp."</section>";
?>

