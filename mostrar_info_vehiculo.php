<?php
require ("config.php");

if(isset($_GET['placas'])){
$placas = $_GET['placas'];


$sql =  $sql = "select * from vehiculos_ WHERE Placas='".$placas."'";
//echo $sql;
$r = $conexion -> query($sql);
    
            while($f = $r -> fetch_array()){ 
               echo  "  Marca ".$f['Marca']." ".$f['Tipo'].", Núm. económico ".$f['Num_economico'].", Serie ".$f['Serie'].", Cil=".$f['Cilindros'];
            }
          

    
        

}

