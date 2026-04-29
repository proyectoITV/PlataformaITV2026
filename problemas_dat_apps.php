<?php
require("config.php");
require("seguridad.php");
require("var_clean.php");
require("lib/funciones.php");



$sql = "select *  from dashboard_apps";
$r= $conexion -> query($sql);   
// echo "<h6 style='width: 100%;
// text-align: center;
// color: #eee;
// font-size: 9pt;
// margin-top: -5px;'>Empleados activos hoy</h6>";
// echo "<table class=''>";

echo "<article style='background-color:#97ff007d;' >";
echo "<a href='h.php' >";
echo "<img src='icon/h.png' style='width:23px;' title='Historia Actual de la Plataforma'>";
echo "</a>";
echo "</article>";


while($f = $r -> fetch_array()) {
    // echo "<tr>";
    // echo "<td>".$f['Empleado']."</td>";
    // echo "</tr>";
    if ($f['problemas']>0){
        echo "<article style='background-color:#ff00007d;' title='Haga clic aqui para ver los problemas' >";
        echo "<a href='problemas.php' ><img src='icon/".$f['icono']."' style='width:23px;'
        title='[".$f['IdApp']."]".$f['Aplicacion']."'></a>";
        echo "</article>";
    } else {
        echo "<article>";
        echo "<a href='xd.php?id=".$f['IdApp']."'><img src='icon/".$f['icono']."' style='width:23px;'
        title='[".$f['IdApp']."]".$f['Aplicacion']."'></a>";
        echo "</article>";
    }
    

}
echo "<article style='background-color:#97ff007d;' >";
echo "<a href='xd.php' >";
echo "<img src='icon/all.png' style='width:23px;' title='Historia Actual de la Plataforma'>";
echo "</a>";
echo "</article>";
// echo "</table>";
    
unset($sql, $r, $f);

?>