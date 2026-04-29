<?php
require("config.php");
require("lib/funciones.php");


$sql = "
select * from ColoresParaGraficas
";

$r= $conexion -> query($sql);
$CadenaDeColores = "";
while($f = $r -> fetch_array()) {
    echo "<b style='color:".$f['hex']."'>".$f['IdColor']." - ".$f['ColorName']."</b><br>";
    $CadenaDeColores = $CadenaDeColores."'".$f['hex']."',";
}

echo "<hr>Cadena de colores: ".$CadenaDeColores;
?>