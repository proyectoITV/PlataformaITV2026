<?php
require("config.php");
require("seguridad.php");
require("var_clean.php");
require("lib/funciones.php");
require("viaticos_fun.php");
// require_once("lib/flor_funciones.php");

$IdViatico = VarClean($_POST['IdViatico']);

$sql="select Fecha, Tipo, Cantidad, Descripcion  from viaticosgastosfull where IdViatico='".$IdViatico."' order by Tipo, Fecha";
//echo $sql;

$r2 = $conexion -> query($sql);
echo "<table class='tabla'>";
echo "<th style = 'background-color: #ddc9a3; color: black; width: 12%; height: 20px;'>Fecha</th>";
echo "<th style = 'background-color: #ddc9a3; color: black; width: 10%'>Cantidad</th>";
echo "<th style = 'background-color: #ddc9a3; color: black; width: 78%'>Descripcion</th>";
$Total = 0;
while($f = $r2 -> fetch_array()){
    echo "<tr>";
    echo "<td width=12% title='".fecha_larga($f['Fecha'])."'>".$f['Fecha']."</td>";
    
    echo "<td width=10%><b>".Pesos($f['Cantidad'])."</b></td>";
    $Total = $Total + $f['Cantidad'];
    echo "<td width=78% style='font-size:8pt;'><b>".$f['Tipo'].'</b> - '.$f['Descripcion']."</td>";
    echo "</tr>";
}
echo "<tr>";
echo "<td colspan='4' align=right ><b style='font-size: 16pt; color: black;'><i class='fa-solid fa-sack-dollar'></i>   TOTAL: ".Pesos($Total)."</b><br><cite style='font-size:9pt;'>".numtoletras($Total)."</cite></td>";
echo "</tr>";
echo "</table>";
unset($f, $r2);


?>