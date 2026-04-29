<?php
require ("config.php");

if(isset($_GET['municipio'])){
$id = $_GET['municipio'];

$sql = "SELECT * FROM cat_colonias WHERE IdMunicipio = ".$id." ORDER BY colonia ASC";

$r = $conexion -> query($sql);

    echo "<option>Seleccione una colonia...</option>";
        
        while($f = $r -> fetch_array()){ // resultado de la busqueda.................
            echo "<option value='".$f['idcolonia']."'>".$f['colonia']."</option>";
        }
    
 


}




?>
