<?php
// require("seguridad.php"); 
require_once("config.php");
require_once("lib/funciones.php");
require_once("lib/flor_funciones.php");

error_reporting(0); //<-- para simular produccion

$IdPrograma = "";
if (isset($_GET['IdPrg'])){
    $IdPrograma = $_GET['IdPrg'];
    $sql="select * from cat_delegaciones WHERE dpto_id <> ''";
    $r= $conexion -> query($sql);
    // var_dump($_GET['ConSaldo']);
    if ($_GET['ConSaldo']==0){
        echo "<h1>Resumen sin Saldo </h1>";
     
    }
    else {
        echo "<h1>Resumen con Saldo </h1>";
     
    }
    echo "<table class='tabla'>";
    $TotalSaldo = 0; $TotalMoratorio=0; $c = 0;
    echo "<th>Delegacion</th><th>Contratos<br> con Saldo</th><th>Saldo</th><th>Morat</th>";
    while($f = $r -> fetch_array()) {
       
       
        
        
        if ($_GET['ConSaldo']==0){
     
            $sqlMS="SELECT (SELECT COUNT (*) FROM busqueda_vivienda_informacionfinanciera WHERE saldo<= 0 AND IdPrograma=".$IdPrograma.") AS Total,(SELECT COUNT (*) FROM busqueda_vivienda_informacionfinanciera WHERE saldo<= 0 AND IdPrograma=".$IdPrograma." AND IdDelegacion=".$f['id'].") AS DelegacionN,(SELECT SUM (Saldo) FROM busqueda_vivienda_informacionfinanciera WHERE saldo<= 0 AND IdPrograma=".$IdPrograma." AND IdDelegacion=".$f['id'].") AS SaldoDelegacion,(SELECT SUM (Saldo_Moratorio) FROM busqueda_vivienda_informacionfinanciera WHERE saldo<= 0 AND IdPrograma=".$IdPrograma." AND IdDelegacion=".$f['id'].") AS Moratorio";
        }
        else {
     
            $sqlMS="SELECT (SELECT COUNT (*) FROM busqueda_vivienda_informacionfinanciera WHERE saldo> 0 AND IdPrograma=".$IdPrograma.") AS Total,(SELECT COUNT (*) FROM busqueda_vivienda_informacionfinanciera WHERE saldo> 0 AND IdPrograma=".$IdPrograma." AND IdDelegacion=".$f['id'].") AS DelegacionN,(SELECT SUM (Saldo) FROM busqueda_vivienda_informacionfinanciera WHERE saldo> 0 AND IdPrograma=".$IdPrograma." AND IdDelegacion=".$f['id'].") AS SaldoDelegacion,(SELECT SUM (Saldo_Moratorio) FROM busqueda_vivienda_informacionfinanciera WHERE saldo> 0 AND IdPrograma=".$IdPrograma." AND IdDelegacion=".$f['id'].") AS Moratorio";
        }
        // echo $sqlMS."<hr>";
        

        $sqlData = DatosVivienda("0", "MONITOR", "PingDB", $sqlMS);
        if ($sqlData == FALSE){
            echo ":( sin datos del servidor";
        } else {
            $array = json_decode(stripslashes($sqlData), true);                
            if(is_array($array)){           
                
                foreach ($array as $value) {             
                    if ($_GET['ConSaldo']==0) {
                        if ($value['SaldoDelegacion'] <= 0){
                        // for( $i = 1; $i >= 0; $i-- ){
                            if ($value['DelegacionN']>0){
                                if ($value['SaldoDelegacion'] < 0 ){
                                    echo "<tr style='background-color:#D24DFF;'>";
                                }else {
                                    echo "<tr>";
                                }
                                echo "<td>".$f['nombre']."</td>";
                                echo "<td>".$value['DelegacionN']."</td>";                
                                echo "<td>$".number_format($value['SaldoDelegacion'], 2, ".", ",")."</td>";                
                                echo "<td>$".number_format($value['Moratorio'], 2, ".", ",")."</td>";      
                                echo "</tr>";
                                $TotalSaldo = $TotalSaldo +  $value['SaldoDelegacion'];
                                $TotalMoratorio = $TotalMoratorio +    $value['Moratorio'];
                                $c = $c + $value['DelegacionN'];
                            }
                        // }
                        }
                    } else {
                        if ($value['SaldoDelegacion'] > 0){
                            // for( $i = 1; $i >= 0; $i-- ){
                            if ($value['DelegacionN']>0){
                                echo "<tr>";
                                echo "<td>".$f['nombre']."</td>";
                                echo "<td>".$value['DelegacionN']."</td>";                
                                echo "<td>$".number_format($value['SaldoDelegacion'], 2, ".", ",")."</td>";                
                                echo "<td>$".number_format($value['Moratorio'], 2, ".", ",")."</td>";      
                                echo "</tr>";
                                $TotalSaldo = $TotalSaldo +  $value['SaldoDelegacion'];
                                $TotalMoratorio = $TotalMoratorio +    $value['Moratorio'];
                                $c = $c + $value['DelegacionN'];
                            // }
                            }
                        }
                    }


                }
               
            } else { echo ":( error"; }
               
        }


        
        
    } 
        
        echo "<tr style='background-color: orange;'><td>TOTALES</td>";
        echo "<td>".$c."</td>";                
        echo "<td><b>$".number_format($TotalSaldo, 2, ".", ",")."</b></td>";                
        echo "<td><b>$".number_format($TotalMoratorio, 2, ".", ",")."</b></td></tr>";   
    echo "</table>";
    echo "<label style='font-size:6pt;'>* informacion obtenida de la BD Estatal.</label>";

}



















?>

