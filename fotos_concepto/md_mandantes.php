<?php
require ("unica/config.php");

if(isset($_GET['id'])){
$id = $_GET['id'];
$idmunicipio = $_GET['idmunicipio'];

$sql = "SELECT * FROM cat_mandantes WHERE IdColonia = ".$id." and IdMunicipio=".$idmunicipio." ORDER BY Mandante ASC";
$r = $conexion -> query($sql);
echo "<label for='mandantes'>Seleccione un mandante:";
    echo "<select id='mandantes' name='mandantes' onchange='mostrarApoderado()'>";
    echo "<option>Seleccione un mandante...</option>";
        
        while($f = $r -> fetch_array()){ // resultado de la busqueda.................
            echo "<option value='".$f['IdMandante']."'>".$f['Propietarios']."</option>";
        }
    
    echo "</select>";
echo "</label>";

    }

?>