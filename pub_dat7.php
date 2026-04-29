<?php

require("seguridad.php"); 
// require_once("config.php");
// require_once("lib/funciones.php");
// require_once("lib/flor_funciones.php");

error_reporting(0); //<-- para simular produccion

//CONTRATOS SANOS saldo

$nitavu = $_POST['nitavu'];
$IdDelegacion = $_POST['IdDelegacion'];
$Desde = $_POST['Desde'];
$Hasta = $_POST['Hasta'];
$consulta = "


select 
YEAR(FechaContrato) as Anio, FechaContrato,
Programa,
Delegacion, 
NombreCompleto,
NumContrato,  IdDelegacion, NumContrato
from busqueda_vivienda_informacioncontratos a
WHERE FechaContrato >= '2016-10-01 00:00:00.000' and FechaContrato <= '2022-10-01 00:00:00.000' 
and IdPrograma NOT IN ( 240, 241 ) and IdDelegacion=".$IdDelegacion."
";

$consulta="

SELECT
	* 
FROM
	(
		select *, 
		ROW_NUMBER () OVER (ORDER BY NumContrato) AS row  
		from BeneficiariosTAM Where IdDelegacion=".$IdDelegacion."
	
	) a 
	
	WHERE row > ".$Desde."
	AND row <= ".$Hasta."
ORDER BY
	row
	
";
// echo $consulta;
$ConsultaDATA = DatosViviendaLarge(0, $nitavu, "PUB", $consulta);
// var_dump($ConsultaDATA);
$array = json_decode($ConsultaDATA, true);
echo "<h1>".DelegacionNombre($IdDelegacion)."</h1>";


if(is_array($array)){
    $ExcelTabla = '
    <table border="1" cellpadding="2" cellspacing="0" width="100%"> 
    <caption> Lista de Beneficiarios de ITAVU de esta Administracion(1/oct/2016 a la fecha) de la Delegacion '.DelegacionNombre($IdDelegacion).'</caption> ';

     echo "<table class='tabla' width='100%;'>";
     echo "
     <th>N</th>
     <th>Año</th>
     <th>Programa</th>
     
     <th>Nombre del Beneficiario</th>
    
     


     ";
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
     $GranMontoCredito = 0;
     $GranBeneficiarios = 0;
     foreach ($array as $value) {
        if (isset($value['r'])){// si hay un error
            echo "Error: ".$value['r'];

        } else {
            // $IdMunicipio =  MunicipioDelegacion1($IdDelegacion);
            $div = "Div".$value['IdPrograma'];
            echo "<tr>";
            echo "<td>".$value['row']."</td>";
            echo "<td><b style='font-size:12pt;'>".$value['Anio']."</b><br><label style='font-size:8pt;'>".$value['FechaContrato']."</label></td>";
            echo "<td>".$value['Programa']."</td>";
            
            echo "<td><b style='font-size:9pt;'>".$value['NombreCompleto']."</b>";
            echo "<hr>CURP: <b>".$value['CURP'];echo "</b><br>IFE: <b>".$value['IFE']."</b>";
            echo "<br>Fecha Nacimiento: ".$value['FechaNacimiento'];
            echo "<br>Telefonos: <b>".$value['Telefono'].",".$value['TelCelular']."</b>";

            echo "<br>Domicilio: ".$value['Domicilio_CalleNum'].", (".$value['Domicilio_entre'].") ".$value['Domicilio_localidad']."".$value['Domicilio_Colotra']."";

            echo "</td>" ;
            // echo "<td><b style='font-size:10pt;'>".Pesos($value['MontoCredito'])."<br><label style='font-size:7pt;'><a target=_blank title='Haga clic para ver el contrato' href='estadodecuenta.php?contrato=".$value['NumContrato']."&del=".$value['IdDelegacion']."'>".$value['NumContrato']."</a></b></label></td>";


            // $strA = $strA."['".$value['Programa']."',     ".$value['Beneficiarios']."],";

            $GranBeneficiarios = $GranBeneficiarios + $value['Beneficiarios'];
            $GranMontoCredito = $GranMontoCredito + $value['MontoCredito'];
           
            $ExcelTabla = $ExcelTabla ."<tr>";
            $ExcelTabla = $ExcelTabla ."<td>".$value['CURP']."</td>";
            $ExcelTabla = $ExcelTabla ."<td>".$value['NombreCompleto']."</td>";
            $ExcelTabla = $ExcelTabla ."<td>".$value['NumContrato']."</td>";
            $ExcelTabla = $ExcelTabla ."<td>".$value['FechaContrato']."</td>";
            $ExcelTabla = $ExcelTabla ."<td>".$value['IdPrograma']."</td>";
            $ExcelTabla = $ExcelTabla ."<td>".$value['Programa']."</td>";
            $ExcelTabla = $ExcelTabla ."<td>".$value['Delegacion']."</td>";
            $ExcelTabla = $ExcelTabla ."<td>".$value['FechaNacimiento']."</td>";
            $ExcelTabla = $ExcelTabla ."<td>".$value['Telefono']."</td>";
            $ExcelTabla = $ExcelTabla ."<td>".$value['TelCelular']."</td>";
            $ExcelTabla = $ExcelTabla ."<td>".$value['Domicilio_CalleNum']."</td>";
            $ExcelTabla = $ExcelTabla ."<td>".$value['Domicilio_entre']."</td>";
            $ExcelTabla = $ExcelTabla ."<td>".$value['Domicilio_localidad']."</td>";
            $ExcelTabla = $ExcelTabla ."<td>".$value['Domicilio_Colotra']."</td>";
            $ExcelTabla = $ExcelTabla ."<td>".$value['Delegacion']."</td>";
            
            $ExcelTabla = $ExcelTabla ."<td>".$value['Domicilio_cp']."</td>";



            
            $ExcelTabla = $ExcelTabla ."</tr>";
        }
    }
    $ExcelTabla = $ExcelTabla ."</table>";
        $strA = substr($strA, 0, -1); //quita la ultima coma.
        
    //     echo "<script>
    //         google.charts.load('current', {packages:['corechart']});
    //         google.charts.setOnLoadCallback(drawChart);
    //         function drawChart() {
    //         var data = google.visualization.arrayToDataTable([
    //             ['Programa', 'Beneficiarios'],
    //            ".$strA."
                    
    //         ]);

    //         var options = {
    //             title: 'Resumen Por Programa',
    //             pieHole: 0.4,
                
    //             legend: {position: 'none'}
    //         };

    //         var chart = new google.visualization.PieChart(document.getElementById('GraficaProgramas'));
    //         chart.draw(data, options);
    //         }
        
    //  </script>";


    }

    echo "</td>";
    echo "</tr>";

    echo "<tr><td>";
    $htmlTB =  "".$GranBeneficiarios."<br><label>Beneficiarios apoyados</label><hr>";
    $htmlTMC =  "".Pesos($GranMontoCredito)."<br><label>pesos en apoyos</label>";
    
    $html = $htmlTB."<br>".$htmlTMC;
    
    // echo "
    // <script>
    // $('#Totales').html('".$html."');
    // console.log('".$html."');
    
    // </script>
    // ";
    
    
    

    echo "</td>";
    echo "</tr>";

    
    echo "</table>
    <button class='Mbtn btn-default' onclick='PorPrograma(".$IdDelegacion.");'>Mas...</button>
    ";
    ExportarExcel($ExcelTabla, "BeneficiariosTamPorDelegacion".DelegacionNombre($IdDelegacion), $nitavu);

    //TOTAL
    
    
?>

