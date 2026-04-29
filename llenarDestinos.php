<?php
require ("config.php");

if(isset($_GET['idorigen'])){
$origen = $_GET['idorigen'];


$sql = "SELECT * FROM cat_recorridosviaticos WHERE origen = '".$origen."' and origen != ''   ORDER BY destino ASC";
echo $sql;
$r = $conexion -> query($sql);

    
        echo "<select id='destino' name='destino' style='margin-left: 0px;'  >"; 
        echo '<option value="0">SELECCIONE UNA OPCION...</option>';      
        while($f = $r -> fetch_array()){ 
            echo "<option value='".$f['idrecorrido']."'>".$f['destino']."</option>";
        }
      echo "</select>";

}

if(isset($_GET['idrecorrido'])){
    $idrecorrido = $_GET['idrecorrido'];
    
    
    $sql = "SELECT * FROM cat_recorridosviaticos WHERE idrecorrido = ".$idrecorrido;
    //echo $sql;
    $r = $conexion -> query($sql);
    
            while($f = $r -> fetch_array()){ 
                echo $f['distancia'];
            }
          
        
       
        
      
    
    
    }
    


?>