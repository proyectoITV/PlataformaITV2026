<?php
// require("seguridad.php"); 
require_once("config.php");
require_once("lib/funciones.php");
require_once("lib/flor_funciones.php");

error_reporting(0); //<-- para simular produccion


$IdDelegacion = $_GET['IdDelegacion'];
$Delegacion = $_GET['Delegacion'];
$Series="";
$Labels="";
$data = "['Task', 'Hours per Day'],";

    $MSSQL = "
    SELECT 
	IdPrograma,
	REPLACE( 
        REPLACE( Programa, CHAR(34), CHAR(32)), CHAR(39),CHAR(34) 
        ) AS Programa
        ,( SELECT COUNT ( * ) FROM busqueda_vivienda_informacionfinanciera WHERE IdPrograma = programa.IdPrograma ) AS n 
FROM
	programa

ORDER BY
    IdPrograma
    

    ";
    // $MSSQL = "SELECT @@VERSION";
    // echo $MSSQL."<br>";
    
    $ConsultaDATA = DatosViviendaLarge($IdDelegacion, "WSContratos", "Test", $MSSQL);
    // echo $ConsultaDATA;
    // var_dump($ConsultaDATA);
    // echo "<hr>";

    $array = json_decode($ConsultaDATA, true); $error = 0;
    
    // var_dump($array);

    if(is_array($array)){            
        foreach ($array as $value) {
            if (isset($value['r'])){// si hay un error
                echo "*Error: ".$value['r'];
                $error = $value['r'];
            } else {//si no hay errores escribimos
                // $Series = $Series."".$value['n'].",";
                // $Labels = $Labels."'".addslashes($value['IdPrograma'])."',";
                $Programa = addcslashes($value['Programa']);
                
                $data = $data."['".$value['Programa']."',".$value['n']."],";
            }


            
        }
    }



$Labels = substr($Labels, 0, -1);
$Series = substr($Series, 0, -1);
$data = substr($data, 0, -1);

// echo "Series = >".$Labels."|".$Series;
echo $data;

$grafica = '

<script type="text/javascript">
google.charts.load("current", {packages:["corechart"]});
google.charts.setOnLoadCallback(drawChart);
function drawChart() {
var data = google.visualization.arrayToDataTable([
'.$data.'

]);

var options = {
pieHole: 0.4, legend:"none",
title:"Cantidad de Contratos por Programa - '.$Delegacion.'",
is3D: false



};

var chart = new google.visualization.PieChart(document.getElementById("GraficaPrgR"));
chart.draw(data, options);
}
</script>';

echo $grafica;







?>

