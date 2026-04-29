<?php
require ("unica/config.php");

if(isset($_GET['id'])){
$id = $_GET['id'];

$sql = "SELECT * FROM cat_colonias WHERE IdMunicipio = ".$id." ORDER BY colonia ASC";

$r = $conexion -> query($sql);

echo "<label for='colonia'>Seleccione una colonia:";
    echo "<select id='colonia' name='colonia' onchange='mostrarMandantes()'>";
    echo "<option>Seleccione una colonia...</option>";
        
        while($f = $r -> fetch_array()){ // resultado de la busqueda.................
            echo "<option value='".$f['idcolonia']."'>".$f['colonia']."</option>";
        }
    
    echo "</select>";
echo "</label>";

}




?>
