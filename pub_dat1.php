<?php

require("seguridad.php"); 
// require_once("config.php");
// require_once("lib/funciones.php");
// require_once("lib/flor_funciones.php");

error_reporting(0); //<-- para simular produccion

//CONTRATOS SANOS saldo

$nitavu = $_POST['nitavu'];

$consulta = "
select * from PadronDeBeneficiariosTAM_porPrograma order by Programa
";

// echo $consulta;
$ConsultaDATA = DatosViviendaLarge(0, $nitavu, "PUB", $consulta);
// var_dump($ConsultaDATA);
$array = json_decode($ConsultaDATA, true);


$ExcelTabla = '
<table border="1" cellpadding="2" cellspacing="0" width="100%"> 
<caption>Beneficiarios de ITAVU de esta Administracion(1/oct/2016 a la fecha), Por programa</caption> ';


if(is_array($array)){
    
     echo "<table class='tabla' width='100%;'>";
     echo "<th>Progama</th><th>Beneficiarios</th><th>Credito</th>";
     $ExcelTabla= $ExcelTabla.'<th>IdPrograma</th><th>Progama</th><th>Beneficiarios</th><th>Credito</th>';
     $GranMontoCredito = 0;
     $GranBeneficiarios = 0;
     foreach ($array as $value) {
        if (isset($value['r'])){// si hay un error
            echo "Error: ".$value['r'];

        } else {
            // $IdMunicipio =  MunicipioDelegacion1($IdDelegacion);
            $div = "Div".$value['IdPrograma'];
            echo "<tr>";
            echo "<td title='".$value['IdPrograma']."' style='cursor:pointer;'><a title='Haga clic aqui para saber mas del programa' style='display:block;' href='pubProg.php?IdPrograma=".$value['IdPrograma']."'>".$value['Programa']."</a></td>";
            echo "<td><b style='font-size:9pt;'>".$value['Beneficiarios']."</b></td>";
            echo "<td>".Pesos($value['MontoCredito'])."</td>";

            
            $ExcelTabla= $ExcelTabla.'<tr>';
            $ExcelTabla= $ExcelTabla.'<td>'.$value['IdPrograma'].'</td>';
            $ExcelTabla= $ExcelTabla.'<td>'.$value['Programa'].'</td>';
            $ExcelTabla= $ExcelTabla.'<td>'.$value['Beneficiarios'].'</td>';
            $ExcelTabla= $ExcelTabla.'<td>'.$value['MontoCredito'].'</td>';
            $ExcelTabla= $ExcelTabla.'</tr>';

            

            $strA = $strA."['".$value['Programa']."',     ".$value['Beneficiarios']."],";

            $GranBeneficiarios = $GranBeneficiarios + $value['Beneficiarios'];
            $GranMontoCredito = $GranMontoCredito + $value['MontoCredito'];
           
            
        }
    }
    $ExcelTabla= $ExcelTabla.'</table>';
    
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
                title: 'Resumen Por Programa',
                pieHole: 0.4,
                
                legend: {position: 'none'}
            };

            var chart = new google.visualization.PieChart(document.getElementById('GraficaProgramas'));
            chart.draw(data, options);
            }
        
     </script>";


    }

    echo "</td>";
    echo "</tr>";

    echo "<tr><td>";
    $htmlTB =  "".$GranBeneficiarios."<br><label>Beneficiarios apoyados</label><hr>";
    $htmlTMC =  "".Pesos($GranMontoCredito)."<br><label>pesos en apoyos</label>";
    
    $html = $htmlTB."<br>".$htmlTMC;
    
    echo "
    <script>
    $('#Totales').html('".$html."');
    console.log('".$html."');
    
    </script>
    ";
    
    
    

    echo "</td>";
    echo "</tr>";

    
    echo "</table>";

    ExportarExcel($ExcelTabla, "BeneficiariosTamPorPrograma", $nitavu);

    //TOTAL
    
    
?>

