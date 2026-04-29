<?php
require("config.php");
require("seguridad.php");
require("var_clean.php");
require("lib/funciones.php");
require("lib/graficas_fun.php");
$Id = VarClean($_POST['Id']);
if ($Id <> ""){
    $sql = "select * from xd_ where fecha=curdate() and id_app ='".$Id."' order by aplicacion";
} else {
    $sql = "select * from xd_ where fecha=curdate() order by aplicacion";
}
// echo $sql;
$r= $conexion -> query($sql);   
echo "<h6 style='width: 100%;
text-align: center;
color: #eee;
font-size: 9pt; 
margin-top: 10px;'>HISTORIA  DETECTADA DE APLICACIONES  ".fecha_larga($fecha).":</h6>";


echo "<div id='Historia' style='
overflow: auto;
height:800px;

'>";
echo "<table class='tabla_dark'>";

echo "<th>Que?</th>";
echo "<th>Cuando?</th>";
echo "<th>Quien?</th>";
echo "<th>Cuanto?</th>";

while($f = $r -> fetch_array()) {
    echo "<tr>";
    echo "<td>"."[".$f['id_app']."]".$f['aplicacion']."</td>";
    echo "<td>".$f['fecha']."</td>";
    echo "<td>".$f['iduser'].": ".$f['nombre']."</td>";
    echo "<td title='Total del tiempo'>".$f['cuantos']."</td>";


    echo "</tr>";

}

echo "</table>";
unset($sql, $r, $f);


echo "</div>";



?>
 