<?php
// require("seguridad.php"); 
require_once("config.php");
require_once("lib/funciones.php");
require_once("lib/flor_funciones.php");

error_reporting(0); //<-- para simular produccion

$IdPrograma = "";
if (isset($_GET['IdDelegacion'])){
    $IdDelegacion = $_GET['IdDelegacion'];   
    // echo "<h4>GET IdDelegacion: ".$_GET['IdDelegacion']."</h4>";   
     
    // echo "<h4>$ IdDelegacion: ".$IdDelegacion."</h4>";
    $Delegacion = DelegacionNombre($IdDelegacion);
} else {
    $IdDelegacion = 0;
    $Delegacion = "";
}
if (isset($_GET['IdPrg'])){
    $IdPrograma = $_GET['IdPrg'];
    if ($IdDelegacion == 0 ){
        $sqlMS="SELECT  ISNULL((SELECT COUNT (*) FROM busqueda_vivienda_informacionfinanciera WHERE IdPrograma=".$IdPrograma." AND Saldo<=0),0) AS ContratosSaldados, ISNULL((SELECT COUNT (*) FROM busqueda_vivienda_informacionfinanciera WHERE IdPrograma=".$IdPrograma." AND Saldo> 0),0) AS ContratosconSaldo, ISNULL((SELECT SUM (Saldo_Moratorio) FROM busqueda_vivienda_informacionfinanciera WHERE IdPrograma=".$IdPrograma." AND Saldo> 0),0) AS Saldo_Moratorio, ISNULL((SELECT SUM (Saldo) FROM busqueda_vivienda_informacionfinanciera WHERE IdPrograma=".$IdPrograma." AND Saldo> 0),0) AS Saldo";
    } else {
        $sqlMS="SELECT ISNULL((SELECT COUNT (*) FROM busqueda_vivienda_informacionfinanciera WHERE IdPrograma=".$IdPrograma." AND Saldo<=0 AND IdDelegacion=".$IdDelegacion."),0) AS ContratosSaldados, ISNULL((SELECT COUNT (*) FROM busqueda_vivienda_informacionfinanciera WHERE IdPrograma=".$IdPrograma." AND Saldo> 0 AND IdDelegacion=".$IdDelegacion."),0) AS ContratosconSaldo, ISNULL((SELECT SUM (Saldo_Moratorio) FROM busqueda_vivienda_informacionfinanciera WHERE IdPrograma=".$IdPrograma." AND Saldo> 0 AND IdDelegacion=".$IdDelegacion."),0) AS Saldo_Moratorio, ISNULL((SELECT SUM (Saldo) FROM busqueda_vivienda_informacionfinanciera WHERE IdPrograma=".$IdPrograma." AND Saldo> 0 AND IdDelegacion=".$IdDelegacion."),0) AS Saldo";

    }
    // echo "IdDel=".$IdDelegacion." - ".$Delegacion."--><br>".$sqlMS."<hr>";
        

    
        $sqlData = DatosViviendaLarge("0", "MONITOR", "PingDB", $sqlMS);
        // var_dump($sqlData);
        if ($sqlData == FALSE){
            echo "Error al obtener datos";
        } else {
            $array = json_decode(stripslashes($sqlData), true);                
            if(is_array($array)){           
                foreach ($array as $value) {                                
                    // for( $i = 1; $i >= 0; $i-- ){
                        echo "<div id='grafica".$IdPrograma."' style='width:100%; height:200px;'></div>";
                        if ($value['Saldo']>0){
                            $GranTotal_Saldados = $value['ContratosSaldados'];
                            $GranTotal_ConSaldo = $value['ContratosconSaldo'];
                            $GranTotal  = $GranTotal_Saldados + $GranTotal_ConSaldo;
                            $GranSaldo = $value['Saldo'];
                          
        

                            echo "
                            <script>
                            var animals = ['(".$value['ContratosSaldados'].")','(".$value['ContratosconSaldo'].")'];
                            
                            var data = {
                            
                            series: [".$value['ContratosSaldados'].", ".$value['ContratosconSaldo']."]
                            
                            };

                            var sum = function(a, b) { return a + b };

                            new Chartist.Pie('#grafica".$IdPrograma."', data, {
                            labelInterpolationFnc: function(value, idx) {
                                var percentage = Math.round(value / data.series.reduce(sum) * 100) + '%';
                                return animals[idx] + ' ' + percentage;
                            }
                            });
                            </script>
                         
                            ";
                        }
                        if ($value['Saldo']>0){
                            echo "<table  class='tabla' style='background-color: #f4ddc8;border-radius: 5px;         
                            padding: 4px;'>";
                        }
                        else {
                            echo "<table class='tabla' style='background-color: #f4f4f4;;border-radius: 5px;         
                            padding: 4px;'>";
                        }
                            // CnT=0 -> Contratos Saldados
                            // CnT=1 -> Contratos con Saldo
                            
                            echo "<tr><td>Contratos sin Saldo</td><td> 
                            <a href='?IdPrg=".$IdPrograma."&CnT=0&AllDel=0' style='color: #000;text-decoration: underline;' title='Ver información de estos Contratos, desde la BD Estatal'>
                            ".$value['ContratosSaldados']."</a>
                            </td></tr>";
                            echo "<tr><td>Contratos con Saldo</td><td>
                            <a style='color: #000;text-decoration: underline;' href='?IdPrg=".$IdPrograma."&CnT=1&AllDel=0' title='Ver información de estos Contratos, desde la BD Estatal'>
                            ".$value['ContratosconSaldo']."</a></td></tr>";
                            // echo "<tr><td>";

                            if ($value['Saldo']>0){
                                echo "<tr><td>Saldo</td><td width=70%> <span style='font-size:11pt;'
                                >$ ".number_format($value['Saldo'], 2, ".", ",")."</span></td></tr>";
                            }
                            else {
                                echo "<tr><td>Saldo</td><td width=50%><img src='icon/ok.png' style='width:16px;'></td></tr>";
                            }
                            
                            // echo "</td><td></td></tr>";
                            if ($value['SaldoMoratorio']>=0){
                                echo "<tr><td>Moratorio</td><td width=70%> <span style='font-size:11pt; color:red;'
                                >$ ".number_format($value['Saldo_Moratorio'], 2, ".", ",")."</span></td></tr>";
                            }
                            else {
                                echo "<tr><td>Moratorio</td><td width=50%></td></tr>";
                            }


                            
                            echo "</table>";
                            echo "<label style='font-size:6pt;'>* informacion obtenida de la BD Estatal.</label>";
                        
                    // }
                }
            } else { echo ":( error"; }
               
        }

}



















?>

