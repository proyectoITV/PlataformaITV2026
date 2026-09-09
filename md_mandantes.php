<?php
require ("config.php");

if(isset($_GET['id'])){
    $id = $_GET['id'];
    $idmunicipio = $_GET['idmunicipio'];

    $sql = "SELECT * FROM cat_mandantes WHERE IdColonia = ".$id." and IdMunicipio=".$idmunicipio." and Cancelado = 0 ORDER BY Mandante ASC";
    $r = $conexion -> query($sql);

    echo "<label for='mandantes' class='cd-form-label'><i class='fa-solid fa-user-tie' style='color:var(--cd-primary);'></i> Seleccione un mandante:</label>";
    echo "<select id='mandantes' name='mandantes' class='cd-form-control' onchange='mostrarApoderado()'>";
    echo "<option value=''>Seleccione un mandante...</option>";
    while($f = $r -> fetch_array()){
        echo "<option value='".$f['IdMandante']."'>".htmlspecialchars($f['Propietarios'])."</option>";
    }
    echo "</select>";
}
?>