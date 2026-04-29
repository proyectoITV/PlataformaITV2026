<?php
require("seguridad.php"); 
require_once("config.php");
require_once("lib/funciones.php");
require_once("lib/flor_funciones.php");

if (isset($_POST['programa']) and isset($_POST['delegacion'])){

    $idPrograma = $_POST['programa'];
    $sql ='select idTipoSolicitud from cat_programa where IdPrograma = '.$idPrograma.'';
    echo $sql;
    $r= $conexion -> query($sql);
    while($f = $r -> fetch_array()) {
        $idTipoSolicitud = $f['idTipoSolicitud'];
        echo constriurFormulario($idTipoSolicitud);

    }
}

?>