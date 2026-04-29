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
$data = "['Años', 'Contratos'],";

    $MSSQL = "
    SELECT DISTINCT
	CONVERT(INT,Anio) AS Anio,
	(CONVERT(INT,( SELECT COUNT ( * ) FROM busqueda_vivienda_informacioncontratos WHERE YEAR ( FechaContrato ) = Anios.Anio) ) ) AS Contratos 
FROM
	busqueda_vivienda_informacioncontratos AS a,
	( SELECT DISTINCT CONVERT(INT,YEAR(FechaContrato)) AS Anio FROM busqueda_vivienda_informacioncontratos ) AS Anios 
WHERE
	Anio > 1974 
	AND Anio < 2020 
ORDER BY
	Anio
    
    ";
    
    $ConsultaDATA = DatosViviendaLarge($IdDelegacion, "WSContratos", "Test", $MSSQL);
    var_dump($ConsultaDATA);

    // echo "<hr>";

    $array = json_decode($ConsultaDATA, true); $error = 0;
    
    // var_dump($array);

    if(is_array($array)){            
        foreach ($array as $value) {
            if (isset($value['r'])){// si hay un error
                echo "*Error: ".$value['r'];
                $error = $value['r'];
            } else {//si no hay errores escribimos
                // $Series = $Series."".$value['Contratos'].",";
                // $Labels = $Labels."'".addslashes($value['Anio'])."',";
                $data = $data."['".$value['Anio']."',".$value['Contratos']."],";
                // $Programa = addcslashes($value['Contratos']);
                
                // $data = $data."['".$value['Programa']."',".$value['n']."],";
            }


            
        }
    }



$Labels = substr($Labels, 0, -1);
$Series = substr($Series, 0, -1);
$data = substr($data, 0, -1);

// echo "Series = >".$Labels."|".$Series;
echo $data;

echo "

    <script type='text/javascript'>
      google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {
        var data = google.visualization.arrayToDataTable([
            ".$data."
        ]);

        var options = {
          title: 'Contratos Otorgados por Año - ".$Delegacion."',
          hAxis: {title: 'Año',  titleTextStyle: {color: '#333'}},
          vAxis: {minValue: 0}, legend:'none',
        };

        var chart = new google.visualization.AreaChart(document.getElementById('GraficaPrgR2'));
        chart.draw(data, options);
      }
    </script>

";
// echo $grafica;







?>

