<?php

require("seguridad.php"); 
// require_once("config.php");
// require_once("lib/funciones.php");
// require_once("lib/flor_funciones.php");

error_reporting(0); //<-- para simular produccion

//CONTRATOS SANOS saldo

$nitavu = $_POST['nitavu'];

$consulta = "
select * from PadronDeBeneficiariosTAM_porDelegacion order by Delegacion
";

// echo $consulta;
$ConsultaDATA = DatosViviendaLarge(0, $nitavu, "PUB", $consulta);
// var_dump($ConsultaDATA);
$array = json_decode($ConsultaDATA, true);



if(is_array($array)){
        $ExcelTabla = '
    <table border="1" cellpadding="2" cellspacing="0" width="100%"> 
<caption>Beneficiarios de ITAVU de esta Administracion(1/oct/2016 a la fecha) Por Delegacion</caption> ';
$ExcelTabla = $ExcelTabla .  "
     <th>CURP</th>
     <th>Nombre</th>
     <th>NumContrato</th>
     <th>Fecha del Contrato</th>     
     <th>IdPrograma</th>
     <th>Programa</th>
     <th>Delegacion</th>
     <th>Fecha de Nacimiento</th>
     <th>Telefono</th>
     <th>Celular</th>
     <th>Domicilio Calle</th>
     <th>Domicilio entre que calles</th>
     <th>Domicilio Localidad</th>
     <th>Domicilio Colonia</th>
     <th>Domicilio Municipio</th>
     <th>Domicilio CP</th>
     
    
     


     ";
     echo "<table class='tabla' width='100%;'>";
     echo "<th>Delegacion</th><th>Beneficiarios</th><th>Credito</th>";
     $ExcelTabla = $ExcelTabla . "<th>Delegacion</th><th>Beneficiarios</th><th>Credito</th>";
     foreach ($array as $value) {
        if (isset($value['r'])){// si hay un error
            echo "Error: ".$value['r'];

        } else {
            // $IdMunicipio =  MunicipioDelegacion1($IdDelegacion);
            $div = "Div".$value['IdPrograma'];
            echo "<tr>";
            echo "<td title='".$value['IdDelegacion']."'><a style='display:block;' title='Haga clic aqui para ver mas sobre la Delegacion' href='pubDel.php?IdDelegacion=".$value['IdDelegacion']."'>".$value['Delegacion']."</a></td>";
            echo "<td><b style='font-size:10pt;'>".$value['Beneficiarios']."</b></td>";
            echo "<td>".Pesos($value['MontoCredito'])."</td>";

            $strA = $strA."['".$value['Delegacion']."',     ".$value['Beneficiarios']."],";

            
            echo "</tr>";
            $ExcelTabla = $ExcelTabla ."<tr>";
            $ExcelTabla = $ExcelTabla ."<td>".$value['Delegacion']."</td>";
            $ExcelTabla = $ExcelTabla ."<td>".$value['Beneficiarios']."</td>";
            $ExcelTabla = $ExcelTabla ."<td>".$value['MontoCredito']."</td>";
            
            $ExcelTabla = $ExcelTabla ."</tr>";
            
        }
    }
    echo "</table>";
    ExportarExcel($ExcelTabla, "BeneficiariosTamPorDelegacion", $nitavu);

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
                title: 'Resumen de Beneficiarios Por Delegacion',
                pieHole: 0.4,
                
                legend: {position: 'none'}
            };

            var chart = new google.visualization.PieChart(document.getElementById('GraficaProgramas'));
            chart.draw(data, options);
            }
        
     </script>";

}

?>

