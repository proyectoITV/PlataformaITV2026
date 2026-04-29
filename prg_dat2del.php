<?php
// require("seguridad.php"); 
require_once("config.php");
require_once("lib/funciones.php");
require_once("lib/flor_funciones.php");

error_reporting(0); //<-- para simular produccion

$IdPrograma = "";
if (isset($_GET['IdPrg'])){
    $IdPrograma = $_GET['IdPrg'];
    // $sql="select * from cat_delegaciones WHERE dpto_id <> ''";
    // $r= $conexion -> query($sql);
    // var_dump($_GET['ConSaldo']);
    if ($_GET['ConSaldo']==0){
        // echo "<h1>Resumen sin Saldo </h1>";
     
    }
    else {
        // echo "<h1>Resumen con Saldo </h1>";
     
    }
    // echo "<table id='InfoDelegaciones' class='tabla'>";
    $TotalSaldo = 0; $TotalMoratorio=0; $c = 0;
    // echo "<th>Delegacion</th><th>Contratos<br> con Saldo</th><th>Saldo</th><th>Morat</th>";
    // while($f = $r -> fetch_array()) {
       $IdDelegacion = $_GET['IdDel'];
       
       $Delegacion = DelegacionNombre($IdDelegacion);
       
    //    if (isset($_GET['ReIntento'])){
    //        if ( $_GET['ReIntento'] == 1){
    //             echo "<script>$('#LoaderDel".$IdDelegacion."').show();</script>";
    //        }
    //    }
        
        
      
      $sqlMS="SELECT (SELECT COUNT (*) FROM busqueda_vivienda_informacionfinanciera WHERE saldo<=0 AND IdPrograma=".$IdPrograma.") AS Total,(SELECT COUNT (*) FROM busqueda_vivienda_informacionfinanciera WHERE saldo<=0 AND IdPrograma=".$IdPrograma." AND IdDelegacion=".$IdDelegacion.") AS DelegacionNSinSaldo,(SELECT COUNT (*) FROM busqueda_vivienda_informacionfinanciera WHERE saldo> 0 AND IdPrograma=".$IdPrograma." AND IdDelegacion=".$IdDelegacion.") AS DelegacionNConSaldo,(SELECT SUM (Saldo) FROM busqueda_vivienda_informacionfinanciera WHERE saldo>0 AND IdPrograma=".$IdPrograma." AND IdDelegacion=".$IdDelegacion.") AS SaldoDelegacion,(SELECT SUM (Saldo_Moratorio) FROM busqueda_vivienda_informacionfinanciera WHERE Saldo_Moratorio>0 AND IdPrograma=".$IdPrograma." AND IdDelegacion=".$IdDelegacion.") AS Moratorio,(SELECT COUNT (*) FROM busqueda_vivienda_informacionfinanciera WHERE IdPrograma=".$IdPrograma." AND IdDelegacion<> ".$IdDelegacion.") AS DelegacionNOT";
        
        
        // echo $sqlMS."<hr>";

        $sqlData = DatosVivienda($IdDelegacion, "EF", "PingDB", $sqlMS);
        // var_dump($sqlData);
        if ($sqlData == FALSE){
            // echo ":( sin datos del servidor";
            echo "<tr style='background-color:red;'>
            <td> ";
            if ( $_GET['ReIntento'] == 1){
                echo "* ".$Delegacion."";
            }
            else {
                echo "".$Delegacion."";
            }
                
             echo " <button      style='padding:1px; margin:0px; border-radius:50%;' class='Mbtn btn-azulTam'                         ";
                
                echo 'onclick="ContratosResumenDelegaciones('.$IdDelegacion.', 0, 1);" ';
                echo ">
                <img src='icon/actualizar.png' style='width:11px;'>";

                echo " </button>
                
            </td>   <td class='pc'></td>   <td class='pc'></td>   <td></td>   <td></td>   <td class='pc'></td></tr>";
            
        } else {
            $array = json_decode(stripslashes($sqlData), true);                
            $TotalNConSaldo = 0;
            $TotalNSinSaldo = 0;
            if(is_array($array)){           
                
                foreach ($array as $value) {             
                            
                               if ($value['SaldoDelegacion'] < 0 ){
                                    echo "<tr style='background-color:#D24DFF;' id='RowID".$IdDelegacion."'>";
                                }else {
                                    echo "<tr id='RowID".$IdDelegacion."'>";
                                }
                                if ( $_GET['ReIntento'] == 1){
                                    echo "<td title='IdDelegacion: ".$IdDelegacion.", SQL=".$sqlMS."'>*".$Delegacion."</td>";
                                } else {
                                    echo "<td title='IdDelegacion: ".$IdDelegacion.", SQL=".$sqlMS."'>".$Delegacion."</td>";

                                }
                                echo "<td class='pc'>".$value['DelegacionNConSaldo']."</td>";                
                                $TotalNConSaldo = $value['DelegacionNConSaldo'];

                                echo "<td class='pc'>";
                                echo "<a target=_blank href='contratos.php?IdDelegacion=".$IdDelegacion."&IdPrograma=".$IdPrograma."&Saldo=0&Moratorios=0&Fora=0' title='Haga clic aqui para ver Todos los Contratos sin Saldo'>";
                                echo $value['DelegacionNSinSaldo']."</a></td>";    
                                $TotalNSinSaldo = $value['DelegacionNSinSaldo']; 
                                
                                echo "<td title='".$value['SaldoDelegacion']."'>";
                                echo "<a target=_blank href='contratos.php?IdDelegacion=".$IdDelegacion."&IdPrograma=".$IdPrograma."&Saldo=1&Moratorios=0&Fora=0' title='Haga clic aqui para ver Todos los Contratos con Saldo'>";
                                echo "$ ".number_format($value['SaldoDelegacion'], 2, ".", ",")."</a></td>";                
                                
                                echo "<td title='".$value['Moratorio']."'>";
                                echo "<a target=_blank href='contratos.php?IdDelegacion=".$IdDelegacion."&IdPrograma=".$IdPrograma."&Saldo=1&Moratorios=1&Fora=0' title='Haga clic aqui para ver Todos los Contratos con Moratorio'>";
                                echo "$ ".number_format($value['Moratorio'], 2, ".", ",")."</a></td>";     
                                if ($value['DelegacionNOT'] > 0 ){
                                    echo "<td style='color:gray; background-color:pink; class='pc'>";
                                    echo "<a target=_blank href='contratos.php?IdDelegacion=".$IdDelegacion."&IdPrograma=".$IdPrograma."&Saldo=1&Moratorios=0&Fora=1' title='Haga clic aqui para ver Todos los Contratos Foraneos'>";
                                    echo "$ ".$value['DelegacionNOT']."</a></td>";       
                                } else {
                                    echo "<td style='color:gray;' class='pc'>".$value['DelegacionNOT']."</td>";       
                                }
                                echo "</tr>";

                                $TotalSaldo = $TotalSaldo +  $value['SaldoDelegacion'];
                                $TotalMoratorio = $TotalMoratorio +    $value['Moratorio'];
                                
                                
                            
                    
                    }
                    sleep(4);
                    echo "
                    <script>
                    ActualizarTotal(".$TotalNSinSaldo.", ".$TotalNConSaldo.", ".$TotalSaldo.", ".$TotalMoratorio.");
                    console.log('Actualizando Saldos de la Delegacion ".$Delegacion." => ".$TotalNSinSaldo.", ".$TotalNConSaldo.", ".$TotalSaldo.", ".$TotalMoratorio."');
                    
                    </script>
                    ";
                    // if (isset($_GET['ReIntento'])){
                    //     if ( $_GET['ReIntento'] == 1){
                    //         echo "<script>$('#LoaderDel".$IdDelegacion."').hide();</script>";
                    //     }
                    // }

                
                
               
            } else { echo ":( error"; }
               
        }

        if ($IdDelegacion == 65){ // si es la ultima delegacion, quita el loader
            echo '<script>$("#prgInfoDelegacionesLoader").hide();</script>';
        }
      

        
        
    // } 
        
    //     echo "<tr style='background-color: orange;'><td>TOTALES</td>";
    //     echo "<td>".$c."</td>";                
    //     echo "<td><b>$".number_format($TotalSaldo, 2, ".", ",")."</b></td>";                
    //     echo "<td><b>$".number_format($TotalMoratorio, 2, ".", ",")."</b></td></tr>";   
    // // echo "</table>";
    // echo "<label style='font-size:6pt;'>* informacion obtenida del las delegaciones...</label>";

}



















?>

