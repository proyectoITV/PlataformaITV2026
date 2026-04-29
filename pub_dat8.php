<?php

require("seguridad.php"); 
// require_once("config.php");
// require_once("lib/funciones.php");
// require_once("lib/flor_funciones.php");

error_reporting(0); //<-- para simular produccion

//CONTRATOS SANOS saldo

$nitavu = $_POST['nitavu'];
$IdDelegacion = $_POST['IdDelegacion'];

$consulta = "


select 
DISTINCT IdPrograma,
Programa,
(
	select count(*) from busqueda_vivienda_informacioncontratos
	WHERE FechaContrato >= '2016-10-01 00:00:00.000' and FechaContrato <= '2022-10-01 00:00:00.000' 
	and IdPrograma NOT IN ( 240, 241 ) and IdDelegacion=".$IdDelegacion." and busqueda_vivienda_informacioncontratos.IdPrograma = a.IdPrograma
) as Beneficiarios

from busqueda_vivienda_informacioncontratos a
WHERE FechaContrato >= '2016-10-01 00:00:00.000' and FechaContrato <= '2022-10-01 00:00:00.000' 
and IdPrograma NOT IN ( 240, 241 ) and IdDelegacion=".$IdDelegacion."
";

// echo $consulta;
$ConsultaDATA = DatosViviendaLarge(0, $nitavu, "PUB", $consulta);
// var_dump($ConsultaDATA);
$array = json_decode($ConsultaDATA, true);



if(is_array($array)){
    
     echo "<h4>Resumen de Beneficiarios de esta Delegacion </h4><table class='tabla' width='100%;'>";
     echo "
    
     <th>Programa</th>    
     <th>Beneficiarios</th>
    
     


     ";
     $GranMontoCredito = 0;
     $GranBeneficiarios = 0;
     foreach ($array as $value) {
        if (isset($value['r'])){// si hay un error
            echo "Error: ".$value['r'];

        } else {
            // $IdMunicipio =  MunicipioDelegacion1($IdDelegacion);
            $div = "Div".$value['IdPrograma'];
            echo "<tr>";
            echo "<td>".$value['Programa']."</td>";
            echo "<td>".$value['Beneficiarios']."</td>";
            
            // echo "<td><b style='font-size:10pt;'>".Pesos($value['MontoCredito'])."<br><label style='font-size:7pt;'><a target=_blank title='Haga clic para ver el contrato' href='estadodecuenta.php?contrato=".$value['NumContrato']."&del=".$value['IdDelegacion']."'>".$value['NumContrato']."</a></b></label></td>";


            $strA = $strA."['".$value['Programa']."',     ".$value['Beneficiarios']."],";

            $GranBeneficiarios = $GranBeneficiarios + $value['Beneficiarios'];
            
           
            
        }
    }
        $strA = substr($strA, 0, -1); //quita la ultima coma.
        
        echo "<script>
            google.charts.load('current', {packages:['corechart']});
            google.charts.setOnLoadCallback(drawChart);
            function drawChart() {
            var data = google.visualization.arrayToDataTable([
                ['Programa', 'Beneficiarios'],
               ".$strA."
                    
            ]);

            var options = {
                title: 'Resumen Por Programa de la Delegacion',
                pieHole: 0.4,
                
                legend: {position: 'none'}
            };

            var chart = new google.visualization.PieChart(document.getElementById('GraficaPorAnio'));
            chart.draw(data, options);
            }
        
     </script>";


    }

    echo "</td>";
    echo "</tr>";

    echo "<tr><td colspan='2' style='background-color:#67B7E3; color:white; font-size:11pt;'>TOTAL de Beneficiarios: ".$GranBeneficiarios."</td></tr>";
    

    echo "<tr><td>";

    
    

    echo "</td>";
    echo "</tr>";

    
    echo "</table>";


    

    //TOTAL
    
    
?>

