<?php
require("seguridad.php");
require("components.php");
require_once("config.php");
require_once("lib/funciones.php");

// error_reporting(0); //<-- para simular produccion
if (isset($_POST['FechaReview'])){
    $FechaReview = VarClean($_POST['FechaReview']);
    if ($FechaReview == ''){
        $FechaReview = $fecha;
    }
} else {
    $FechaReview = $fecha;
}
$sql = "

select  
e.nitavu as IdEmpleado,
CONCAT('<b>',e.nombre,' </b><br><cite> ',e.puesto, ' ', (select nombre from cat_gerarquia where id = e.dpto),'</cite>') as Empleado,

ifnull(
(select CONCAT('<a href=nomina_downpdf.php?id=',nitavu,'&f=',FechaNomina,'  download>PDF</a>')
from nominas where nitavu = e.nitavu and FechaNomina = '".$FechaReview."'),'?'
) as PDF,


ifnull(
(select CONCAT('<a href=nomina_downxml.php?id=',nitavu,'&f=',FechaNomina,'  download>XML</a>')
from nominas where nitavu = e.nitavu and FechaNomina = '".$FechaReview."'),'?'
) as XML,


ifnull((select  download from nominas where nitavu = e.nitavu and FechaNomina ='".$FechaReview."' ),'?') as Download,
ifnull((select  Vio from nominas where nitavu = e.nitavu and FechaNomina = '".$FechaReview."'),'?') as Vio,

ifnull((select 
CONCAT('Subido por ',iduser, ' el ',fecha, ' a ',hora)
from nominas where nitavu = e.nitavu and FechaNomina = '".$FechaReview."' ),'?') as Info



from empleados e where estado not like '%aja%' order by nombre


";

$r1= $conexion -> query($sql);   
echo "<br><div style='
color: #3a991f;
border-radius: 5px;
width: 100%;
display: inline-block;
text-align: center;
font-family: Bold;

'>Nomina del ".fecha_larga($FechaReview).":</div>";
echo "<table class='tabla'>";
echo "<th>IdEmpleado</th>";
echo "<th>Empleado</th>";
echo "<th>PDF</th>";
echo "<th>XML</th>";
echo "<th >Descargado</th>";
echo "<th>Vista</th>";
echo "<th></th>";

while($Emp = $r1 -> fetch_array()) {
    if ($Emp['XML'] == '?'){
        echo "<tr style='background-color:red'>";
    } else {
        echo "<tr style='background-color:green' title='".$Emp['Info']."'>";
    }
    
    echo "<td>".$Emp['IdEmpleado'];
   
    echo "</td>";
    echo "<td>".$Emp['Empleado']." ";
    
    echo "</td>";
    echo "<td>".$Emp['PDF']."</td>";
    echo "<td>".$Emp['XML']."</td>";
    echo "<td>".$Emp['Download']."</td>";
    echo "<td>".$Emp['Vio']."</td>";

    echo "</td>";
    echo "<td> ";
    if ($Emp['XML'] == '?'){
        echo "<button title='Dar de baja a este empleado' style='
     
        
        'onclick='baja(".$Emp['IdEmpleado'].");' class='btn btn-danger'>Baja</button>";
    }
    echo "</td>";
    echo "</tr>";
   
}
echo "</table>";

unset($r1,$Emp);

SonidoBoop();
?>