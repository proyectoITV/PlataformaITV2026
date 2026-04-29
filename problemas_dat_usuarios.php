<?php
require("config.php");
require("seguridad.php");
require("var_clean.php");
require("lib/funciones.php");



$sql = "select * from dashboard_empleados where IdEmpleado<>'' order by Empleado";
$r= $conexion -> query($sql);   
echo "<h6 style='width: 100%;
text-align: center;
color: #eee;
font-size: 9pt;
margin-top: -5px;'>Empleados activos hoy</h6>";
// echo "<table class=''>";
while($f = $r -> fetch_array()) {
    // echo "<tr>";
    // echo "<td>".$f['Empleado']."</td>";
    // echo "</tr>";
    $foto= ponerfoto("fotos/".$f['IdEmpleado'].".jpg",'icono'); 
    echo "<article><a href='h.php?id=".$f['IdEmpleado']."' title='[".$f['IdEmpleado']."] ".$f['Empleado']." uso=".$f['Apps']."'>";
    echo $foto;
    echo "</a></article>";

}
// echo "</table>";
    
unset($sql, $r, $f);

?>