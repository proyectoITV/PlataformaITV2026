<?php
require ("unica/config.php");

if(isset($_GET['id'])){
$id = $_GET['id'];
$idmunicipio = $_GET['idmunicipio'];
$idmandante = $_GET['idmandante'];

$sql = "SELECT Mandante FROM cat_mandantes WHERE IdColonia = ".$id." and IdMunicipio=".$idmunicipio."  and IdMandante=".$idmandante." ORDER BY Mandante ASC";
$r = $conexion -> query($sql);
echo "<label for='mandantes'>Seleccione un apoderado:";
    echo "<select id='mandantes' name='mandantes' onchange='mostrarOpciones()'>";
    echo "<option>Seleccione un apoderado...</option>";
        
        while($f = $r -> fetch_array()){ // resultado de la busqueda.................
            echo "<option value='".$f['IdMandante']."'>".$f['Mandante']."</option>";
        }
    
    echo "</select>";
echo "</label>";

    }

?>