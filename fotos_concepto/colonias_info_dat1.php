<?php
require("unica/seguridad.php"); 
require_once("unica/config.php");
require_once("unica/funciones.php");
require_once("unica/flor_funciones.php");

error_reporting(0); //<-- para simular produccion


 //Parametros
 if ( isset($_GET['IdDelegacion']) and isset($_GET['Hasta']) and isset($_GET['Desde']) and isset($_GET['Col']) ){
    $IdDelegacion = $_GET['IdDelegacion'];
    $Delegacion = DelegacionNombre($IdDelegacion);
    $Desde = $_GET['Desde'];
    $Hasta = $_GET['Hasta'];
    $Col = $_GET['Col'];
    $OpcionDeEstadistica = $_GET['sel'];
    $IdPrograma = $_GET['IdPrograma'];
    

    if ($Hasta == 0){
        $Hasta = 1000000000; // si va 0 en desde y hasta, mostrar todo, ponemos un numero como limite grande
    }
















    $tb= "";
    $TituloDeLaTabla="";
    switch ($OpcionDeEstadistica):
      case "sindeuda":
          $TituloDeLaTabla = "Contratos sin deuda.";
          $MSSQL = "
          SELECT
              * 
          FROM
              (
              
              SELECT
                  Vivienda_InformacionContratos .*,            
                  ROW_NUMBER ( ) OVER ( ORDER BY Vivienda_InformacionContratos.NumContrato ) AS row 
              FROM
                  Vivienda_InformacionContratos 
              WHERE
                
                  IdDelegacion = ".$IdDelegacion."
                  AND ( Colonia COLLATE Latin1_General_CI_AS = '".$Col."' OR DomicilioColonia COLLATE Latin1_General_CI_AS = '".$Col."')
                  AND Saldo <= 0
            
              
              ) a 
          WHERE
              row > ".$Desde."
              AND row <= ".$Hasta."
              
              
          ORDER BY
              row, NombreCompleto
          
          ";



          break;
      case "condeuda":   
        $TituloDeLaTabla = "Contratos con deuda.";
        $MSSQL = "
        SELECT
            * 
        FROM
            (
            
            SELECT
                Vivienda_InformacionContratos .*,            
                ROW_NUMBER ( ) OVER ( ORDER BY Vivienda_InformacionContratos.NumContrato ) AS row 
            FROM
                Vivienda_InformacionContratos 
            WHERE
              
                IdDelegacion = ".$IdDelegacion."
                AND ( Colonia COLLATE Latin1_General_CI_AS = '".$Col."' OR DomicilioColonia COLLATE Latin1_General_CI_AS = '".$Col."')
                AND Saldo > 0
          
            
            ) a 
        WHERE
            row > ".$Desde."
            AND row <= ".$Hasta."
            
            
        ORDER BY
            row, NombreCompleto
        
        ";
        break;
    case "conerrores":   
            $TituloDeLaTabla = "Contratos con errores detectados.";
            $MSSQL = "
            SELECT
                * 
            FROM
                (
                
                SELECT
                    Vivienda_InformacionContratos .*,            
                    ROW_NUMBER ( ) OVER ( ORDER BY Vivienda_InformacionContratos.NumContrato ) AS row 
                FROM
                    Vivienda_InformacionContratos 
                WHERE
                  
                    IdDelegacion = ".$IdDelegacion."
                    AND ( Colonia COLLATE Latin1_General_CI_AS = '".$Col."' OR DomicilioColonia COLLATE Latin1_General_CI_AS = '".$Col."')
                    AND Errores > 0
              
                
                ) a 
            WHERE
                row > ".$Desde."
                AND row <= ".$Hasta."
                
                
            ORDER BY
                row, NombreCompleto
            
            ";
                break;

          case "conmoratorio":   
                $TituloDeLaTabla = "Contratos con Saldo Moratorio";
                $MSSQL = "
                SELECT
                    * 
                FROM
                    (
                    
                    SELECT
                        Vivienda_InformacionContratos .*,            
                        ROW_NUMBER ( ) OVER ( ORDER BY Vivienda_InformacionContratos.NumContrato ) AS row 
                    FROM
                        Vivienda_InformacionContratos 
                    WHERE
                      
                        IdDelegacion = ".$IdDelegacion."
                        AND ( Colonia COLLATE Latin1_General_CI_AS = '".$Col."' OR DomicilioColonia COLLATE Latin1_General_CI_AS = '".$Col."')
                        AND Saldo_Moratorio > 0
                  
                    
                    ) a 
                WHERE
                    row > ".$Desde."
                    AND row <= ".$Hasta."
                    
                    
                ORDER BY
                    row, NombreCompleto
                
                ";
                break;

      case "":
          $MSSQL = "
          SELECT
              * 
          FROM
              (
              
              SELECT
                  Vivienda_InformacionContratos .*,            
                  ROW_NUMBER ( ) OVER ( ORDER BY Vivienda_InformacionContratos.NumContrato ) AS row 
              FROM
                  Vivienda_InformacionContratos 
              WHERE
                
                  IdDelegacion = ".$IdDelegacion."
                  AND ( Colonia COLLATE Latin1_General_CI_AS = '".$Col."' OR DomicilioColonia COLLATE Latin1_General_CI_AS = '".$Col."')
            
              
              ) a 
          WHERE
              row > ".$Desde."
              AND row <= ".$Hasta."
              
              
          ORDER BY
              row, NombreCompleto
          
          ";
          break;
      default:
          $MSSQL = "
          SELECT
              * 
          FROM
              (
              
              SELECT
                  Vivienda_InformacionContratos .*,            
                  ROW_NUMBER ( ) OVER ( ORDER BY Vivienda_InformacionContratos.NumContrato ) AS row 
              FROM
                  Vivienda_InformacionContratos 
              WHERE
                
                  IdDelegacion = ".$IdDelegacion."
                  AND ( Colonia COLLATE Latin1_General_CI_AS = '".$Col."' OR DomicilioColonia COLLATE Latin1_General_CI_AS = '".$Col."')
            
              
              ) a 
          WHERE
              row > ".$Desde."
              AND row <= ".$Hasta."
              
              
          ORDER BY
              row, NombreCompleto
          
          ";
  endswitch;

  if ($IdPrograma <> ''){
    $TituloDeLaTabla = "Contratos del Programa ".ProgramaNombre($IdPrograma)." de esta colonia";
    $MSSQL = "
    SELECT
        * 
    FROM
        (
        
        SELECT
            Vivienda_InformacionContratos .*,            
            ROW_NUMBER ( ) OVER ( ORDER BY Vivienda_InformacionContratos.NumContrato ) AS row 
        FROM
            Vivienda_InformacionContratos 
        WHERE
          
            IdDelegacion = ".$IdDelegacion."
            AND ( Colonia COLLATE Latin1_General_CI_AS = '".$Col."' OR DomicilioColonia COLLATE Latin1_General_CI_AS = '".$Col."')
            AND IdPrograma = ".$IdPrograma."
        
        ) a 
    WHERE
        row > ".$Desde."
        AND row <= ".$Hasta."
        
        
    ORDER BY
        row, NombreCompleto
    
    ";

  }
    
    // echo "<br><br><br><hr>".$MSSQL."<hr>";

    $tb = $tb. "<h4>".$TituloDeLaTabla."</h4><table class='tabla'>";
    $tb = $tb."<th>N</th><th>Beneficiario</th><th>Contrato</th><th
    >Saldo</th><th>Moratorios</th>";
    $ConsultaDATA = DatosVivienda($IdDelegacion, "WSContratos", "Test", $MSSQL);
    
    $array = json_decode($ConsultaDATA, true);
    // var_dump($array);
    $error = 0;
    if(is_array($array)){            
        foreach ($array as $value) {
            if (isset($value['r'])){// si hay un error
                echo "*Error: ".$value['r'];
                $error = $value['r'];
            } else {//si no hay errores escribimos
                if (    $value['Errores'] >0 ){
                    $tb = $tb."<tr style='background-color:#f280db;'>";
                } else {
                    $tb = $tb."<tr>";
                }
                
                $tb = $tb."<td title='Errores: ".$value['Errores']."'>".$value['row']."</td>";
                $tb = $tb."<td>";
                    $tb = $tb."<a title='Haz clic aquí para buscar a esta persona en la base de datos' style='display:block;' href='beneficiarios.php?search=".$value['NombreCompleto']."&unlimited' target=_blank><b style='font-size:14pt;'>".$value['NombreCompleto']."</b></a>";
                    $tb = $tb."<span style='font-size:8pt;'><b>CURP:  </b>".$value['CURP']."</span> ";
                    $tb = $tb."<span style='font-size:8pt;'><b>Telefono:  </b>".$value['Telefono']."</span><br>";
                    $tb = $tb."<span style='font-size:8pt;'><b>Colonia:  </b>".$value['Colonia'].", ".$value['DomicilioColonia']."</span><br>";
                    $tb = $tb."<span style='font-size:8pt;'><b>Delegacion:  </b>".$value['Delegacion']."</span><br>";
                    $tb = $tb."<span style='font-size:9pt;'><b>Programa:  </b>".$value['Programa']."</span><br>";

                $tb = $tb."</td>";

                $tb = $tb."<td>";
                    $tb = $tb."<b style='font-size:10pt;'>";
                    $tb = $tb."<a title='Haz clic aqui para ver el Estado de Cuenta' target=_blank href='estadodecuenta.php?contrato=".$value['NumContrato']."&del=".$IdDelegacion."'>";
                    $tb = $tb."".$value['NumContrato']."</a></b><br>";
                    $tb = $tb."<span style='font-size:8pt;'><b>Tasa Anual de Financiamiento:  </b>".$value['TasaAnualFin']."%</span><br>";
                    $tb = $tb."<span style='font-size:8pt;'><b>Tasa Int. Moratorio:  </b>".$value['TasaIntMora']."%</span><br>";
                $tb = $tb."</td>";

                $tb = $tb."<td>";
                    $tb = $tb."<b style='font-size:10pt;' title='".$value['Saldo']."'>$ ".number_format($value['Saldo'],2,'.',',')."</b><br>";
                    $tb = $tb."<span style='font-size:8pt;' title='".$value['FechaUltimoPago']."'><b>Ultimo Pago:  </b> ".$value['FechaUltimoPAGO']."</span><br>";
                    
                $tb = $tb."</td>";

                $tb = $tb."<td>";
                    $tb = $tb."<b style='font-size:10pt;' title='".$value['Saldo_Moratorio']."'>$ ".number_format($value['Saldo_Moratorio'],2,'.',',')."</b><br>";
                    $tb = $tb."<span style='font-size:8pt;' title='".$value['MesesDeAtraso']."'><b>Meses de Atraso:  </b>".round($value['MesesDeAtraso'])."</span><br>";
                    
                $tb = $tb."</td>";

                $tb = $tb."</tr>";
            }
            
        }
        $tb = $tb."</table>";
        $tb = $tb. "<div id='Botones' style='
        background-color: #ececec;
        text-align: center;
        border-radius: 5px;
        width: 98%;
        display: inline-block;
        margin-left: 10px;
        padding-bottom: 12px;
        '>
        <button title='Haga clic aqui para mostrar todos los contratos' style = 'padding: 3px;' class='btn btn-tercero' id='btntodos' onclick='Contratos(3);'><img src='icon/reportes.png' style='padding: 3px; width:30px; height:30px;'></button> ";
        $tb = $tb. "<button title='Haga clic aqui para regresar 10 contratos atras' style = 'padding: 3px;' class='btn btn-secundario' id='btnleft' onclick='Contratos(2);'><img src='icon/btn_izquierda.png' style='padding: 3px; width:30px; height:30px;'></button> ";
        $tb = $tb. "<button title='Haga clic aqui para avanzar viendo los contratos' style = 'padding: 3px;' class='btn btn-secundario' id='btnright' onclick='Contratos(1);'><img src='icon/btn_derecha.png' style='padding: 3px; width:30px;'height:30px;></button> ";
        // $tb = $tb. "<hr style='border: 1px dashed; opacity:0.2;'>";
        $tb = $tb. "</div>
       
        ";
$tb = $tb. "<label>* Informacion obtenida desde la delegacion.</label>";
        
      
        
        //Estadistica de Colonia
        $MSSQLestadistica = "
        SELECT
        ISNULL(( SELECT COUNT ( * ) FROM Vivienda_InformacionContratos WHERE IdDelegacion = 6 AND ( Colonia = '".$Col."' OR DomicilioColonia = '".$Col."'  ) ),0) AS TotalDeContratos,
        ISNULL(( SELECT COUNT ( * ) FROM Vivienda_InformacionContratos WHERE IdDelegacion = 6 AND ( Colonia = '".$Col."'  OR DomicilioColonia = '".$Col."'  ) AND Saldo > 0 ),0) AS Deudores,
        ISNULL(( SELECT COUNT ( * ) FROM Vivienda_InformacionContratos WHERE IdDelegacion = 6 AND ( Colonia = '".$Col."'  OR DomicilioColonia = '".$Col."'  ) AND Saldo <= 0 ),0) AS SinDeuda,
        ISNULL(( SELECT COUNT ( * ) FROM Vivienda_InformacionContratos WHERE IdDelegacion = 6 AND ( Colonia = '".$Col."'  OR DomicilioColonia = '".$Col."'  ) AND Errores > 0 ) ,0) AS Errores,
        ISNULL(( SELECT SUM ( Saldo ) FROM Vivienda_InformacionContratos WHERE IdDelegacion = 6 AND ( Colonia = '".$Col."'  OR DomicilioColonia = '".$Col."'  ) AND Saldo > 0 ),0) AS Saldo_deSaldomayorquecero,
        ISNULL(( SELECT SUM ( Saldo ) FROM Vivienda_InformacionContratos WHERE IdDelegacion = 6 AND ( Colonia = '".$Col."'  OR DomicilioColonia = '".$Col."'  ) ),0) AS Saldo_todo,
        ISNULL(( SELECT SUM ( Saldo ) FROM Vivienda_InformacionContratos WHERE IdDelegacion = 6 AND ( Colonia = '".$Col."'  OR DomicilioColonia = '".$Col."' ) AND errores <= 0 ),0) AS Saldo_sano,
        ISNULL(( SELECT SUM ( Saldo_Moratorio ) FROM Vivienda_InformacionContratos WHERE IdDelegacion = 6 AND ( Colonia = '".$Col."'  OR DomicilioColonia = '".$Col."'  ) ),0) AS Moratorio_todo,
        ISNULL(( SELECT SUM ( Saldo_Moratorio ) FROM Vivienda_InformacionContratos WHERE IdDelegacion = 6 AND ( Colonia = '".$Col."'  OR DomicilioColonia = '".$Col."'  ) AND errores <= 0 ),0) AS Moratorio_sano



        ";
        // echo $MSSQLestadistica;
        $tbEstadistica = "";
        $ConsultaEstadistica = DatosViviendaLarge($IdDelegacion, $nitavu, "Colonias Estadistica", $MSSQLestadistica);
        // var_dump($ConsultaEstadistica);
        $array2 = json_decode($ConsultaEstadistica, true);
        // var_dump($array2);
        $error = 0;
        if(is_array($array2)){            
            foreach ($array2 as $vE) {
                if (isset($vE['r'])){// si hay un error
                    echo "*Error: [Estadistica Colonia] ".$vE['r'];
                    $error = $value['r'];
                } else {//si no hay errores escribimos
                    
                    $TotalDeContratos = $vE['TotalDeContratos'];
                    $ContratosDeudores = $vE['Deudores']; $ContratosSinDeuda = $vE['SinDeuda'];
                    
                    $URLActual = "colonias_info.php?IdDelegacion=".$_GET['IdDelegacion']."&Col=".$_GET['Col']."&m=".$_GET['m'];

                    $tbEstadistica = $tbEstadistica."<table class='tabla'><tr><td>Contratos con Deuda</td><td><a href='".$URLActual."&sel=condeuda' title='Haga clic para mostrar estos contratos'>".$ContratosDeudores."</a></td></tr>";
                    $tbEstadistica = $tbEstadistica."<td>Contratos sin Deuda</td><td><a href='".$URLActual."&sel=sindeuda' title='Haga clic para mostrar estos contratos'>".$ContratosSinDeuda."</a></td></tr>";
                    $tbEstadistica = $tbEstadistica."<td>Total de Contratos</td><td>".$TotalDeContratos."</td></tr></table><br>
                    <div id='GraficaCol1' style=''></div>";

                    $tbEstadistica = $tbEstadistica."
                    <script type='text/javascript'>
                    google.charts.load('current', {'packages':['corechart']});
                    google.charts.setOnLoadCallback(drawChart);
              
                    function drawChart() {
              
                      var data = google.visualization.arrayToDataTable([
                        ['Concepto', 'Contratos'],
                        ['Contratos con Deuda',     ".$ContratosDeudores."],
                        ['Contratos sin Deuda',      ".$ContratosSinDeuda."]
                      ]);
              
                      var options = {
                        title: 'Porcentaje de Deudores en la Colonia ".$Col."'
                      };
              
                      var chart = new google.visualization.PieChart(document.getElementById('GraficaCol1'));
              
                      chart.draw(data, options);
                    }
                  </script>
                 
                    ";

                    $Errores = $vE['Errores'];
                    $ContratosSinErrores = $TotalDeContratos - $Errores;
                    $tbEstadistica = $tbEstadistica."<hr><table class='tabla'><tr><td>Contratos con Errores</td><td><a href='".$URLActual."&sel=conerrores' title='Haga clic para mostrar estos contratos'>".$Errores."</a></td></tr>";                    
                    $tbEstadistica = $tbEstadistica."<tr><td>Total de Contratos</td><td>".$TotalDeContratos."</td></tr></table><br>
                    <div id='GraficaCol2' style=''></div>";

                    $tbEstadistica = $tbEstadistica."
                    <script type='text/javascript'>
                    google.charts.load('current', {'packages':['corechart']});
                    google.charts.setOnLoadCallback(drawChart);
              
                    function drawChart() {
              
                      var data = google.visualization.arrayToDataTable([
                        ['Concepto', 'Contratos'],
                        ['Contratos Errores',     ".$Errores."],
                        ['Contratos sin Errores',      ".$ContratosSinErrores."]
                      ]);
              
                      var options = {
                        title: 'Sanidad de la Informacion de la Colonia ".$Col."',
                        pieHole: 0.4,
                      };
              
                      var chart = new google.visualization.PieChart(document.getElementById('GraficaCol2'));
              
                      chart.draw(data, options);
                    }
                  </script>
                 
                    ";

                    $SaldoTotal = $vE['Saldo_todo'];
                    $SaldoSano = $vE['Saldo_sano'];
                    $tbEstadistica = $tbEstadistica."<hr><table class='tabla'><tr><td>Saldo Total</td><td>".Pesos($SaldoTotal)."</td></tr>";                    
                    $tbEstadistica = $tbEstadistica."<tr><td>Saldo (sin Errores)</td><td>".Pesos($SaldoSano)."</td></tr></table><br>
                    <div id='GraficaCol3' style=''></div>";
                    $tbEstadistica = $tbEstadistica."
                    <script type='text/javascript'>
                    google.charts.load('current', {'packages':['corechart']});
                    google.charts.setOnLoadCallback(drawChart);
              
                    function drawChart() {
              
                      var data = google.visualization.arrayToDataTable([
                        ['Concepto', 'Contratos'],
                        ['Saldo Total',     ".$SaldoTotal."],
                        ['Saldo Sano (sin errores)',      ".$SaldoSano."]
                      ]);
              
                      var options = {
                        title: 'Saldos de la Colonia ".$Col."',
                        pieHole: 0.7
                        
                       
                      };
              
                      var chart = new google.visualization.PieChart(document.getElementById('GraficaCol3'));
              
                      chart.draw(data, options);
                    }
                  </script>
                 
                    ";
                    
                    $TotalMoratorio = $vE['Moratorio_todo']; //<-- moratorio
                    $MoratorioSano = $vE['Moratorio_sano'];
                    $tbEstadistica = $tbEstadistica."<hr><table class='tabla'><tr><td>Moratorio Total</td><td><a href='".$URLActual."&sel=conmoratorio' title='Haga clic para mostrar estos contratos'>".Pesos($TotalMoratorio)."</a></td></tr>";                    
                    $tbEstadistica = $tbEstadistica."<tr><td>Moratorio (sin Errores)</td><td>".Pesos($MoratorioSano)."</td></tr></table><br>
                    <div id='GraficaCol4' style=''></div>";
                    $tbEstadistica = $tbEstadistica."
                    <script type='text/javascript'>
                    google.charts.load('current', {'packages':['corechart']});
                    google.charts.setOnLoadCallback(drawChart);
              
                    function drawChart() {
              
                      var data = google.visualization.arrayToDataTable([
                        ['Concepto', 'Contratos'],
                        ['Moratorio Total',     ".$TotalMoratorio."],
                        ['Moratorio Sano (sin errores)',      ".$MoratorioSano."]
                      ]);
              
                      var options = {
                        title: 'Moratorio de la Colonia ".$Col."',
                        pieHole: 0.7
                        
                       
                      };
              
                      var chart = new google.visualization.PieChart(document.getElementById('GraficaCol4'));
              
                      chart.draw(data, options);
                    }
                  </script>
                 
                    ";

                }
            }
        } else {
            echo "ERROR: [Estadistica Colonia 2]".$ConsultaEstadistica."<hr>".$MSSQLestadistica;
        }


       



        
        echo "<table width=100%><tr><td valign=top width=80%>".$tb."<hr>".$tbProgramas."</td><td valign=top><h4>Estadistica de Colonia </h4>".$tbEstadistica."<hr>".$tbProgramas."</td></tr></table>";



        
    } else {
        echo "ERROR: [Colonias]: No es un array ".$MSSQL."<hr>".$ConsultaDATA;
    }



    //Contruccion 


} else {
    echo "ERROR: faltan parametros!";
}
















?>

