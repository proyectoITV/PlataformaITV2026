<?php
require("seguridad.php"); 
require_once("config.php");
require_once("lib/funciones.php");
require_once("lib/flor_funciones.php");

error_reporting(0); //<-- para simular produccion


 //Parametros
 if ( isset($_GET['IdDelegacion']) and isset($_GET['IdPrograma']) ){
    $IdDelegacion = $_GET['IdDelegacion'];
    if ($IdDelegacion == 0) {
        $Delegacion = "";
    } else {
        $Delegacion = $_GET['Delegacion'];
    }
    
    $IdPrograma = $_GET['IdPrograma'];
    // echo "IdDelegacion=".$IdDelegacion;

    if ($IdDelegacion == 0){ //------------------------
        //construimos con los puntos guardados
    $data = "";
    
    $data2 = "";
    $tb = "<table class='tabla'>";

                    $sql = '
                    SELECT DISTINCT
                    fecha AS LaFecha,
                    IFNULL( ( SELECT Moratorio FROM seguimientomoratorio WHERE IdDelegacion = 1 AND fecha = LaFecha limit 1 ), "0" ) AS MATAMOROS,
                    IFNULL( ( SELECT Moratorio FROM seguimientomoratorio WHERE IdDelegacion = 2 AND fecha = LaFecha   limit 1), "0" ) AS "NUEVO LAREDO",
                    IFNULL( ( SELECT Moratorio FROM seguimientomoratorio WHERE IdDelegacion = 3 AND fecha = LaFecha  limit 1), "0" ) AS REYNOSA,
                    IFNULL( ( SELECT Moratorio FROM seguimientomoratorio WHERE IdDelegacion = 4 AND fecha = LaFecha  limit 1), "0" ) AS "SAN FERNANDO",
                    IFNULL( ( SELECT Moratorio FROM seguimientomoratorio WHERE IdDelegacion = 5 AND fecha = LaFecha  limit 1), "0" ) AS TAMPICO,
                    IFNULL( ( SELECT Moratorio FROM seguimientomoratorio WHERE IdDelegacion = 6 AND fecha = LaFecha  limit 1), "0" ) AS VICTORIA,
                    IFNULL( ( SELECT Moratorio FROM seguimientomoratorio WHERE IdDelegacion = 7 AND fecha = LaFecha  limit 1), "0" ) AS ALTAMIRA,
                    IFNULL( ( SELECT Moratorio FROM seguimientomoratorio WHERE IdDelegacion = 8 AND fecha = LaFecha  limit 1), "0" ) AS "MIGUEL ALEMAN",
                    IFNULL( ( SELECT Moratorio FROM seguimientomoratorio WHERE IdDelegacion = 9 AND fecha = LaFecha  limit 1), "0" ) AS "RIO BRAVO",
                    IFNULL( ( SELECT Moratorio FROM seguimientomoratorio WHERE IdDelegacion = 10 AND fecha = LaFecha  limit 1), "0" ) AS "VALLE HERMOSO",
                    IFNULL( ( SELECT Moratorio FROM seguimientomoratorio WHERE IdDelegacion = 11 AND fecha = LaFecha  limit 1), "0" ) AS "ALDAMA",
                    IFNULL( ( SELECT Moratorio FROM seguimientomoratorio WHERE IdDelegacion = 12 AND fecha = LaFecha  limit 1 ), "0" ) AS "ABASOLO",
                    IFNULL( ( SELECT Moratorio FROM seguimientomoratorio WHERE IdDelegacion = 13 AND fecha = LaFecha  limit 1), "0" ) AS "EL MANTE",
                    IFNULL( ( SELECT Moratorio FROM seguimientomoratorio WHERE IdDelegacion = 14 AND fecha = LaFecha limit 1 ), "0" ) AS "JIMENEZ",
                    IFNULL( ( SELECT Moratorio FROM seguimientomoratorio WHERE IdDelegacion = 15 AND fecha = LaFecha  limit 1), "0" ) AS "SOTO LA MARINA",
                    IFNULL( ( SELECT Moratorio FROM seguimientomoratorio WHERE IdDelegacion = 17 AND fecha = LaFecha  limit 1), "0" ) AS "GONZALEZ",
                    IFNULL( ( SELECT Moratorio FROM seguimientomoratorio WHERE IdDelegacion = 18 AND fecha = LaFecha  limit 1), "0" ) AS LLERA,
                    IFNULL( ( SELECT Moratorio FROM seguimientomoratorio WHERE IdDelegacion = 19 AND fecha = LaFecha  limit 1), "0" ) AS CAMARGO,
                    IFNULL( ( SELECT Moratorio FROM seguimientomoratorio WHERE IdDelegacion = 20 AND fecha = LaFecha  limit 1), "0" ) AS MADERO,
                    IFNULL( ( SELECT Moratorio FROM seguimientomoratorio WHERE IdDelegacion = 65 AND fecha = LaFecha  limit 1), "0" ) AS XICOTENCATL,
                    IFNULL( ( SELECT Moratorio FROM seguimientomoratorio WHERE IdDelegacion = 66 AND fecha = LaFecha  limit 1), "0" ) AS TULA,
                    IFNULL( ( SELECT Moratorio FROM seguimientomoratorio WHERE IdDelegacion = 67 AND fecha = LaFecha  limit 1), "0" ) AS "VILLA DE CASAS",
                    IFNULL( ( SELECT Moratorio FROM seguimientomoratorio WHERE IdDelegacion = 68 AND fecha = LaFecha limit 1 ), "0" ) AS "DIAZ ORDAZ" 
                FROM
                    seguimientomoratorio
                    
                    ';
                    $data = "['Fecha','MATAMOROS', 'NUEVO LAREDO', 'REYNOSA', 'SAN FERNANDO', 'TAMPICO', 'VICTORIA', 'ALTAMIRA', 'MIGUEL ALEMAN', 'RIO BRAVO', 'VALLE HERMOSO', 'ALDAMA', 'ABASOLO', 'EL MANTE', 'JIMENEZ', 'SOTO LA MARINA', 'GONZALEZ', 'LLERA', 'CAMARGO', 'MADERO', 'XICOTENCANTL', 'TULA', 'VILLA DE CASAS', 'DIAZ ORDAZ'], ";
                    // echo $data;
                    $rsv= $conexion -> query($sql);
                    // echo $sql;
                    while($fsv = $rsv -> fetch_array()) {
                       
                        $tb = $tb."<tr>";
                        $tb = $tb."<td>"."</td>";
                        
                        $str="Seguimiento por ".nitavu_nombre($fsv['nitavu'])." a el ".fecha_larga($fsv['fecha'])." a las ".hora12($fsv['hora'])." con la cantidad de ".$fsv['Moratorio']."";
                        $tb = $tb."<td title='".$str."'>".fecha_larga($fsv['fecha'])." | ".hora12($fsv['fecha'])."</td>";
                        $tb = $tb."<td title='".$fsv['Moratorio']." en ".$fsv['Contratos']."'>";
                        
                        $tb = $tb. "$ ".number_format($fsv['Moratorio'],2,'.',',');
                        $tb = $tb. "</td>";
                        
                        $tb = $tb."</tr>";
                        // $data2 = $data2."['".$fsv['fecha']." (".$str.")',".$fsv['Moratorio']."],";
                        $Moratorio = $fsv['Moratorio'];
                        // $data2 = $data2."['".$fsv['fecha']." (".$str.")',".$Moratorio.",";
                        $data = $data."['".$fsv['LaFecha']." ',".$fsv['MATAMOROS'].", ".$fsv['NUEVO LAREDO'].", ".$fsv['REYNOSA'].", ".$fsv['SAN FERNANDO'].", ".$fsv['TAMPICO'].", ".$fsv['VICTORIA'].", ".$fsv['ALTAMIRA'].", ".$fsv['MIGUEL ALEMAN'].", ".$fsv['RIO BRAVO'].", ".$fsv['VALLE HERMOSO'].", ".$fsv['ALDAMA'].", ".$fsv['ABASOLO'].", ".$fsv['EL MANTE'].", ".$fsv['JIMENEZ'].", ".$fsv['SOTO LA MARINA'].", ".$fsv['GONZALEZ'].", ".$fsv['LLERA'].", ".$fsv['CAMARGO'].", ".$fsv['MADERO'].", ".$fsv['XICOTENCATL'].", ".$fsv['TULA'].", ".$fsv['VILLA DE CASAS'].", ".$fsv['DIAZ ORDAZ']."],";    
                        
                       
                        
                        
                        
                    }
                    

                    // $data2 = $data2."['"."',";
            


      



            // $data = $data."],";
            $data = substr($data, 0, -1);
            // echo $data;

            echo "

            <script type='text/javascript'>
            //GRAFICA DE COLONIAS DE LA DELEGACION
            google.charts.load('current', {'packages':['corechart']});
            google.charts.setOnLoadCallback(drawChart);

            function drawChart() {
                var data = google.visualization.arrayToDataTable([
                    ".$data."
                ]);

                var options = {
                title: 'Moratorio por Seguimiento en las Delegaciones',
                hAxis: {title: 'Año',  titleTextStyle: {color: '#333'}},
                vAxis: {minValue: 0},   legend: { position: 'top', alignment: 'start' }
                };

                var chart = new google.visualization.AreaChart(document.getElementById('ContratosResumenGrafica'));
                chart.draw(data, options);
            }
            </script>

        ";
        $tb = $tb."</table>";
        echo $tb;
        
        // echo $data;

            
    

    } else {
            $MSSQL = "
            SELECT 
                SUM(Saldo_Moratorio) AS Moratorio,
                count(*) as Contratos
                from busqueda_vivienda_informacionfinanciera
                WHERE IdDelegacion = ".$IdDelegacion." and Saldo_Moratorio>0
            ";
            
            // echo $MSSQL."<hr>";
            
            // $MSSQL = "SELECT @@VERSION";
            
            $tb = $tb."<table class='tabla'><th>Colonia</th><th>Moratorio</th>";
            
            
            // echo $tb;
            $ConsultaDATA = DatosViviendaLarge($IdDelegacion, "WSContratos", "Test", $MSSQL);
            $array = json_decode($ConsultaDATA, true);
            $error = 0;
            // var_dump($ConsultaDATA);
            
            $GLabels = "";
            $GValores = "";
            $GValores2 = "";
            
            $data = "['Fecha','Moratorio'],";
            $datafinal = "";
            // echo var_dump($ConsultaDATA)."<hr>";

            $TotalSaldo = 0; $TotalMoratorio=0;
            $PuntoActual="";
            if(is_array($array)){            
                foreach ($array as $value) {
                    if (isset($value['r'])){// si hay un error
                        echo "*Error: ".$value['r'];
                        $error = $value['r'];
                    } else {//si no hay errores escribimos
                        $tb = $tb."<tr style='background-color:#484848; color:white;'>";
                        
                        $tb = $tb."<td>".fecha_larga($fecha)." | ".hora12($hora)."</td>";
                        $tb = $tb."<td title='".$value['Moratorio']." en ".$value['Contratos']."'>";
                    
                        $tb = $tb. "$ ".number_format($value['Moratorio'],2,'.',',');
                        $tb = $tb. "</td>";
                        $tb = $tb."</tr>";

                        if (seguimientomoratorio_add($IdDelegacion, $nitavu, $value['Moratorio'],$value['Contratos'])==TRUE){
                            echo "<script>
                            NPush('Se ha marcado seguimiento de esta Delegacion.','Plataforma ITAVU')
                            </script>";
                        }

                        
                        $TotalMoratorio = $TotalMoratorio + $value['Moratorio'];

                        //almacenamos

                        $GValores2 = $GValores2."'".$value['Moratorio']."',";
                        
                        $datafinal = $datafinal."['".$fecha."',".$value['Moratorio']."],";

                    }


                    
                }
                //agremaos totales
                // $tb = $tb."<tr style='background-color:black;color:black;font-size:12pt;'>";        
                // $tb = $tb."<td style='background-color:#E3D79F; opacity:1;' >TOTAL</td>";
                // $tb = $tb."<td style='background-color:#484848; opacity:1; color:white;' title='".$TotalMoratorio."'>$ ".number_format($TotalMoratorio,2,'.',',')."</td>";
                // $tb = $tb."</tr>";

                //quitamos la ultima coma
                $GLabels = substr($GLabels, 0, -1);
                $GValores = substr($GValores, 0, -1);
                $GValores2 = substr($GValores2, 0, -1);
                

                $sql = "Select * from seguimientomoratorio WHERE IdDelegacion=".$IdDelegacion;
                $rs= $conexion -> query($sql);
                while($fs = $rs -> fetch_array()) {
                    $tb = $tb."<tr>";
                    $str="Seguimiento por ".nitavu_nombre($fs['nitavu'])." a el ".fecha_larga($fs['fecha'])." a las ".hora12($fs['hora'])." con la cantidad de ".$fs['Moratorio']."";
                    $tb = $tb."<td title='".$str."'>".fecha_larga($fs['fecha'])." | ".hora12($fs['fecha'])."</td>";
                    $tb = $tb."<td title='".$fs['Moratorio']." en ".$fs['Contratos']."'>";
                    
                    $tb = $tb. "$ ".number_format($fs['Moratorio'],2,'.',',');
                    $tb = $tb. "</td>";
                    
                    $tb = $tb."</tr>";
                    $data = $data."['".$fs['fecha']." (".$str.")',".$fs['Moratorio']."],";

                }
                $data = $data.$datafinal;
                $data = substr($data, 0, -1);

                //escribimos la grafica
                // echo "
                // <script>
                // new Chartist.Bar('#ContratosResumenGrafica', {
                //     labels: [".$GLabels."],
                //     series: [
                //       [".$GValores."],
                //       [".$GValores2."]
                    
                //     ]
                //   }, {
                //     stackBars: true,
                //     axisY: {
                //       labelInterpolationFnc: function(value) {
                //         return (value / 1000) + 'k';
                //       }
                //     }
                //   }).on('draw', function(data) {
                //     if(data.type === 'bar') {
                //       data.element.attr({
                //         style: 'stroke-width: 30px'
                //       });
                //     }
                //   });
                //   </script>
                // ";
                
                // echo $data."<hr>";
                echo "

                    <script type='text/javascript'>
                    //GRAFICA DE COLONIAS DE LA DELEGACION
                    google.charts.load('current', {'packages':['corechart']});
                    google.charts.setOnLoadCallback(drawChart);

                    function drawChart() {
                        var data = google.visualization.arrayToDataTable([
                            ".$data."
                        ]);

                        var options = {
                        title: 'Moratorio por Seguimiento en  ".$Delegacion."',
                        hAxis: {title: 'Año',  titleTextStyle: {color: '#333'}},
                        vAxis: {minValue: 0}, legend:'none',
                        };

                        var chart = new google.visualization.AreaChart(document.getElementById('ContratosResumenGrafica'));
                        chart.draw(data, options);
                    }
                    </script>

                ";
                $tb = $tb."</table>";
                echo $tb;
                
            } else {
                Sentimental("No se han podido obtener los datos, intentelo mas tarde.");
            }

        }

    //Contruccion 


} else {
    echo "ERROR: faltan parametros!";
}


                   














?>

