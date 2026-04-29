<?php

//WIDGET PROTOTIPO

$nitavu = $_POST['nitavu'];
$admin = $_POST['admin'];
require_once("unica/config.php");
require_once("unica/funciones.php");
//mi turno actual
if ($admin == ""){
    $DelegacionID = nitavu_dpto($nitavu);
} else {$DelegacionID = $admin;}

$sql = "
SELECT 
Turno, Area as AreaId,
(select CatAreas.Nombre from CatAreas WHERE CatAreas.IdArea = AreaId) as Area,
fecha, hora
from Turnos 

WHERE Estado = 1 and DelegacionId='".$DelegacionID."' and fecha=curdate()
ORDER BY Turno limit 7
";
// echo $sql;
echo "<table class='tabla' height=100%><th>Turno</th><th>Modulo</th>";
$r= $conexion -> query($sql);
while($f = $r -> fetch_array()) {
// echo "<div id='TurnoM'>";
echo "<tr style='font-size:14pt; background-color:white;'>";
    echo "<td align=center><b style='font-family:ExtraBold;font-size:18pt;'>".$f['Turno']."</b></td><td>".$f['Area']."</td>";
echo "</tr>";
// echo "</div>";

}
echo "</table>";



//echo $tmp."</section>";
?>

