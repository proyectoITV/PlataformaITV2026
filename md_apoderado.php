<?php
require ("config.php");

if(isset($_GET['id'])){
    $id = $_GET['id'];
    $idmunicipio = $_GET['idmunicipio'];
    $idmandante = $_GET['idmandante'];

    $sql = "SELECT RepresentanteLegal FROM cat_mandantes WHERE IdColonia = ".$id." and IdMunicipio=".$idmunicipio." and IdMandante=".$idmandante." and Cancelado = 0 ORDER BY Mandante ASC";
    $r = $conexion -> query($sql);
    $apoderados = array();
    while($f = $r -> fetch_array()){
        $nombre = trim((string)$f['RepresentanteLegal']);
        if($nombre !== ''){
            $apoderados[] = $nombre;
        }
    }

    echo "<label for='apoderado_select' class='cd-form-label'><i class='fa-solid fa-user-shield' style='color:var(--cd-gold-dark);'></i> Seleccione un apoderado:</label>";

    if(count($apoderados) > 0){
        echo "<select id='apoderado_select' name='apoderado' class='cd-form-control' onchange='mostrarOpciones()'>";
        echo "<option value=''>Seleccione un apoderado...</option>";
        foreach($apoderados as $apoderado){
            echo "<option value='".htmlspecialchars($apoderado, ENT_QUOTES, 'UTF-8')."'>".htmlspecialchars($apoderado)."</option>";
        }
        echo "</select>";
    }else{
        echo "<input type='text' class='cd-form-control' value='Sin apoderado registrado' readonly>";
    }
}
?>