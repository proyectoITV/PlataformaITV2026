<?php
require("config.php");
require("seguridad.php");
require("var_clean.php");
require("lib/funciones.php");
require("lib/graficas_fun.php");
$Id = VarClean($_POST['Id']);
if ($Id <> ""){
    $sql = "select * from actividad where fecha=curdate() and NEmpleado ='".$Id."' order by Identificador DESC";
} else {
    $sql = "select * from actividad where fecha=curdate() order by Identificador DESC";
}
// echo $sql;
$r= $conexion -> query($sql);   
echo "<h6 style='width: 100%;
text-align: center;
color: #eee;
font-size: 9pt; 
margin-top: 10px;'>HISTORIA  DETECTADA  ".fecha_larga($fecha).":</h6>";


echo "<div id='Historia' style='
overflow: auto;
height:800px;

'>";
echo "<table class='tabla_dark'>";
echo "<th>IdHistoria</th>";
echo "<th>Que?</th>";
echo "<th>Cuando?</th>";
echo "<th>Quien?</th>";
echo "<th>Donde?</th>";

while($f = $r -> fetch_array()) {
    echo "<tr>";
    echo "<td><b style='color:#b8860b'>".$f['Identificador']."</b>: "."</td>";
    echo "<td>".$f['Descripcion']."</td>";
    echo "<td><b>".hora12($f['hora'])."</b>: ".$f['fecha']."</td>";
    echo "<td>".$f['NEmpleado'].": ".$f['Nombre']."|".$f['Puesto'].""."</td>";
    echo "<td>".$f['Departamento']."</td>";


    echo "</tr>";

}

echo "</table>";
unset($sql, $r, $f);


echo "</div>";



?>
 