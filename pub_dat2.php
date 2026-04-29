<?php

require("seguridad.php"); 
// require_once("config.php");
// require_once("lib/funciones.php");
// require_once("lib/flor_funciones.php");

error_reporting(0); //<-- para simular produccion

//CONTRATOS SANOS saldo

$nitavu = $_POST['nitavu'];

     
$consulta2 = "
SELECT 

(
    SELECT		
        count(*)
    FROM
        busqueda_vivienda_informacioncontratos 
    WHERE
        FechaContrato >= '2016-10-01 00:00:00.000' 
        AND FechaContrato <= '2022-10-01 00:00:00.000' 	
        AND YEAR ( FechaContrato ) = '2016'
        -- AND IdPrograma = 271 
) as '2016',

(
    SELECT		
    count(*)
    FROM
        busqueda_vivienda_informacioncontratos 
    WHERE
        FechaContrato >= '2016-10-01 00:00:00.000' 
        AND FechaContrato <= '2022-10-01 00:00:00.000' 	
        AND YEAR ( FechaContrato ) = '2017'
        -- AND IdPrograma = 271 
) as '2017',

(
    SELECT		
    count(*)
    FROM
        busqueda_vivienda_informacioncontratos 
    WHERE
        FechaContrato >= '2016-10-01 00:00:00.000' 
        AND FechaContrato <= '2022-10-01 00:00:00.000' 	
        AND YEAR ( FechaContrato ) = '2018' 
        -- AND IdPrograma = 271 
) as '2018',

(
    SELECT		
    count(*)
    FROM
        busqueda_vivienda_informacioncontratos 
    WHERE
        FechaContrato >= '2016-10-01 00:00:00.000' 
        AND FechaContrato <= '2022-10-01 00:00:00.000' 	
        AND YEAR ( FechaContrato ) = '2019'
        -- AND IdPrograma = 271 
) as '2019'
";

// echo $consulta;
$ConsultaDATA2 = DatosViviendaLarge(0, $nitavu, "PUB2", $consulta2);
// var_dump($ConsultaDATA2);
$array2 = json_decode($ConsultaDATA2, true);



if(is_array($array2)){
    
    echo "<table class='tabla' width='100%;'>";
    echo "<th>Progama</th><th>Beneficiarios</th>";
    
    foreach ($array2 as $value2) {
        if (isset($value2['r'])){// si hay un error
            echo "Error: ".$value2['r'];

        } else {
            // $IdMunicipio =  MunicipioDelegacion1($IdDelegacion);
            $div = "Div".$value2['IdPrograma'];
            echo "<tr>";
                echo "<td >2016</td>";
                echo "<td >".$value2['2016']."</td>";
            echo "</tr>";

            echo "<tr>";
                echo "<td >2017</td>";
                echo "<td >".$value2['2017']."</td>";
            echo "</tr>";

            echo "<tr>";
                echo "<td >2018</td>";
                echo "<td >".$value2['2018']."</td>";
            echo "</tr>";

            echo "<tr>";
                echo "<td >2019</td>";
                echo "<td >".$value2['2019']."</td>";
            echo "</tr>";


            $strx = $strx."['2016',     ".$value2['2016']."],";
            $strx = $strx."['2017',     ".$value2['2017']."],";
            $strx = $strx."['2018',     ".$value2['2018']."],";
            $strx = $strx."['2019',     ".$value2['2019']."]";
        }
    }
        // $strx = substr($strx, 0, -1); //quita la ultima coma.


    
    echo "</table>


    ";

   
        echo "
        <script>
        google.charts.load('current', {'packages':['corechart']});
        google.charts.setOnLoadCallback(drawChart);

        function drawChart() {
        var data = google.visualization.arrayToDataTable([
            ['Año', 'Beneficiarios'],
            ".$strx."
            
            
        ]);

        var options = {
            title: 'Estadistica por Año',
            hAxis: {title: 'Año',  titleTextStyle: {color: '#333'}},
            vAxis: {minValue: 0},
             
            legend: {position: 'none'}
        };

        var chart = new google.visualization.AreaChart(document.getElementById('GraficaPorAnio'));
        chart.draw(data, options);
        }
    
    </script>";
 
} else {

}


?>

