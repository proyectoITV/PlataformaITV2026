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
    echo "<table class='tabla'>";
    $TotalSaldo = 0; $TotalMoratorio=0; $c = 0;
    echo "<th>N</th><th>Beneficiario</th><th>Contrato</th><th>Saldo</th>";
    // while($f = $r -> fetch_array()) {
        echo "<tr>";
       
        
        if ($_GET['ConSaldo']==0){
            echo "<h1>Contratos sin Saldo </h1>";
            historia($nitavu, "Entro a la aplicacion Explorador Financiero, buscando contratos sin Saldo del Programa ".$Programa);
            $sqlMS="SELECT*FROM (SELECT*,(SELECT NombreCompleto FROM busqueda_vivienda_informacioncontratos WHERE NumContrato=busqueda_vivienda_informacionfinanciera.NumContrato) AS Nombre,(SELECT delegaciones.Delegacion FROM delegaciones WHERE IdDelegacion=busqueda_vivienda_informacionfinanciera.IdDelegacion) AS Delegacion,ROW_NUMBER () OVER (ORDER BY NumContrato) AS row FROM busqueda_vivienda_informacionfinanciera WHERE saldo<= 0 AND IdPrograma=".$IdPrograma.") a WHERE row> ".$_GET['Desde']." AND row<=".$_GET['Hasta']." order by row";
        }
        else {
            historia($nitavu, "Entro a la aplicacion Explorador Financiero, buscando contratos con Saldo del Programa ".$Programa);
            echo "<h1>Contratos con Saldo </h1>";
            $sqlMS="SELECT*FROM (SELECT*,(SELECT NombreCompleto FROM busqueda_vivienda_informacioncontratos WHERE NumContrato=busqueda_vivienda_informacionfinanciera.NumContrato) AS Nombre,(SELECT delegaciones.Delegacion FROM delegaciones WHERE IdDelegacion=busqueda_vivienda_informacionfinanciera.IdDelegacion) AS Delegacion,ROW_NUMBER () OVER (ORDER BY NumContrato) AS row FROM busqueda_vivienda_informacionfinanciera WHERE saldo> 0 AND IdPrograma=".$IdPrograma.") a WHERE row> ".$_GET['Desde']." AND row<=".$_GET['Hasta']." order by row";
        }
        // echo $sqlMS;
        $sqlData = DatosVivienda("0", "MONITOR", "PingDB", $sqlMS);
        // echo $sqlData;
        if ($sqlData == FALSE){
            echo ":( sin datos del servidor";
        } else {
            $array = json_decode(stripslashes($sqlData), true);     
            // var_dump($array);
            if(is_array($array)){           
                
                foreach ($array as $value) {             
                if ($value['Saldo_Moratorio']>0){
                    echo "<tr style='background-color:red;'>";
                }
                else {
                    if ($value['Saldo'] < 0  or $value['Nombre']==""){
                        echo "<tr style='background-color:#D24DFF;'>";
                    }else {
                        echo "<tr>";
                    }
                    
                }
                    // for( $i = 1; $i >= 0; $i-- ){
                        echo "<td>".$value['row']."</td><td title=''><b style='font-size:10pt;'>".$value['Nombre']."</b><br>".$value['Delegacion']."</td>";
                        echo "<td title='IdDelegacion: ".$value['IdDelegacion'].", Folio: ".$value['Folio'].", IdPrograma: ".$value['IdPrograma']."'>".$value['NumContrato']."</td>";
                        if ($value['MesesDeAtraso'] <0 ){
                            $MesesDeAtraso = 0;
                        } else  {
                            $MesesDeAtraso = $value['MesesDeAtraso'];
                        }
                        echo "<td><b title='".$value['Saldo']."' style='font-size:9pt;'>$".number_format($value['Saldo'], 2, ".", ",")."</b><br>
                        <label>(Moratorio $ ".number_format($value['Saldo_Moratorio'], 2, ".", ",").", Meses de atraso: ".round($MesesDeAtraso).")</label></td></tr>";
                        

                        // echo "<td>$".number_format($value['SaldoDelegacion'], 2, ".", ",")."</td>";                
                        
                    // }
        
                }
               
            } else { echo ":( error"; }
               
        }


        
        
    // } 
       
    echo "</table>";
    echo "<label style='font-size:6pt;'>* informacion obtenida de la BD Estatal.</label>";

}



















?>

