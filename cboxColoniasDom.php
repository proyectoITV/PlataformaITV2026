<?php
require ("config.php");

if(isset($_GET['idmun'])){
$id = $_GET['idmun'];


$sql = "SELECT * FROM colonias WHERE IdMunicipio = ".$id." and colonia != ''   ORDER BY Colonia ASC";
//echo $sql;
$r = $Vivienda -> query($sql);

    
        echo "<select id='ColoniaAval' name='ColoniaAval' style='margin-left: 0px;'  onchange='validarCampos()' >"; 
        echo '<option value="0">SELECCIONE UNA OPCION...</option>';      
        while($f = $r -> fetch_array()){ 
            echo "<option value='".$f['IdColonia']."'>".$f['Colonia']."</option>";
        }
      echo "</select>";
    
   
    
  


}




?>