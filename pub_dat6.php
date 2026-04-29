<?php

require("seguridad.php"); 
// require_once("config.php");
// require_once("lib/funciones.php");
// require_once("lib/flor_funciones.php");

error_reporting(0); //<-- para simular produccion

//CONTRATOS SANOS saldo

$nitavu = $_POST['nitavu'];
$IdPrograma = $_POST['IdPrograma'];
     
$consulta2 = "



select 
DISTINCT Delegacion,
(SELECT count(*) from busqueda_vivienda_informacioncontratos WHERE FechaContrato >= '2016-10-01 00:00:00.000' and FechaContrato <= '2022-10-01 00:00:00.000' and IdPrograma NOT IN ( 240, 241 ) and IdPrograma=".$IdPrograma." and IdDelegacion=a.IdDelegacion) as beneficiarios

from busqueda_vivienda_informacioncontratos a
WHERE FechaContrato >= '2016-10-01 00:00:00.000' and FechaContrato <= '2022-10-01 00:00:00.000' 
and IdPrograma NOT IN ( 240, 241 ) and IdPrograma=".$IdPrograma."
";

echo $consulta;
$ConsultaDATA2 = DatosViviendaLarge(0, $nitavu, "PUBx2", $consulta2);
// var_dump($ConsultaDATA2);
$array2 = json_decode($ConsultaDATA2, true);

$GranBeneficiarios = 0 ;

if(is_array($array2)){
    
    echo "<table class='tabla' width='100%;'>";
    echo "<th>Delegacion</th><th>Beneficiarios</th>";
    
    foreach ($array2 as $value2) {
        if (isset($value2['r'])){// si hay un error
            echo "Error: ".$value2['r'];

        } else {
            // $IdMunicipio =  MunicipioDelegacion1($IdDelegacion);
            $div = "Div".$value2['IdPrograma'];
            echo "<tr>";
                echo "<td >".$value2['Delegacion']."</td>";
                echo "<td >".$value2['beneficiarios']."</td>";
            echo "</tr>";
            $GranBeneficiarios = $GranBeneficiarios+$value2['beneficiarios'];

          

            $strx = $strx."['".$value2['Delegacion']."',     ".$value2['beneficiarios']."],";
          
        }
    }
        $strx = substr($strx, 0, -1); //quita la ultima coma.


    echo "<tr>";
                echo "<td colspan='2' style='background-color:#67B7E3; color:white; font-size:10pt;'>Total  = ".$GranBeneficiarios."</td>";
               
            echo "</tr>";
    echo "</table>


    ";

   
        echo "
        <script>
        google.charts.load('current', {packages:['corechart']});
        google.charts.setOnLoadCallback(drawChart);
        function drawChart() {
            var data = google.visualization.arrayToDataTable([
            ['Delegacion', 'Beneficiario'],
           ".$strx."
            ]);

            var options = {
            title: 'Por Delegacion del Presente Programa',legend: {position: 'none'},
            is3D: true,
            };

            var chart = new google.visualization.PieChart(document.getElementById('GraficaPorAnio'));
            chart.draw(data, options);
        }
        
    
    </script>";
 
} else {

}


?>

