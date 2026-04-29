<?php
require("config.php");
require("seguridad.php");
require("var_clean.php");
require("lib/funciones.php");



$sql = "select * from dashboard_delegaciones";
$r= $conexion -> query($sql);   
echo "<h6 style='width: 100%;
text-align: center;
color: #eee;
font-size: 9pt;
margin-top: -5px;'>DELEGACIONES:</h6>";
echo "<table class=''>";
while($f = $r -> fetch_array()) {
    echo "<tr>";
    if ($f['problemas']>0){
        echo "<td title='problemas = ".$f['problemas']."' style='cursor:pointer;'>"."<img src='icon/act_stop.png' style='width:10px;'>"."</td>";
    } else {
        echo "<td>"."<img src='icon/act_off.png' style='width:10px;'>"."</td>";
    }
    if ($f['Actividad']>0){        
        echo "<td style='color:#02d902;' title=''>".$f['Delegacion']."</td>";
    } else {
        echo "<td>".$f['Delegacion']."</td>";
    }
    echo "</tr>";

}
echo "</table>";
    
unset($sql, $r, $f);

?>