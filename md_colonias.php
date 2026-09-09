<?php
require ("config.php");

if(isset($_GET['id'])){
    $id = $_GET['id'];

    $sql = "SELECT * FROM cat_colonias WHERE IdMunicipio = ".$id." ORDER BY colonia ASC";
    $r = $conexion -> query($sql);

    echo "<label for='colonia' class='cd-form-label'><i class='fa-solid fa-map-location-dot' style='color:var(--cd-gold-dark);'></i> Seleccione una colonia:</label>";
    echo "<select id='colonia' name='colonia' class='cd-form-control' onchange='mostrarMandantes()'>";
    echo "<option value=''>Seleccione una colonia...</option>";
    while($f = $r -> fetch_array()){
        echo "<option value='".$f['idcolonia']."'>".htmlspecialchars($f['colonia'])."</option>";
    }
    echo "</select>";
}
?>
