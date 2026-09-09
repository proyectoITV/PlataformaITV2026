<?php
require ("config.php");

if(isset($_GET['id'])){
    $id = $_GET['id'];
    $idmunicipio = $_GET['idmunicipio'];
    $idmandante = $_GET['idmandante'];

    $sql = "SELECT RepresentanteLegal FROM cat_mandantes WHERE IdColonia = ".$id." and IdMunicipio=".$idmunicipio." and IdMandante=".$idmandante." and Cancelado = 0 ORDER BY Mandante ASC";
    $r = $conexion -> query($sql);

    echo "<label for='mandantes' class='cd-form-label'><i class='fa-solid fa-user-shield' style='color:var(--cd-gold-dark);'></i> Seleccione un apoderado:</label>";
    echo "<select id='mandantes' name='mandantes' class='cd-form-control' onchange='mostrarOpciones()'>";
    echo "<option value=''>Seleccione un apoderado...</option>";
    while($f = $r -> fetch_array()){
        echo "<option value='".$f['RepresentanteLegal']."' selected>".htmlspecialchars($f['RepresentanteLegal'])."</option>";
    }
    echo "</select>";
}
?>