<?php
require_once("config.php");
require_once("lib/funciones.php");
require_once("lib/flor_funciones.php");

//RECIBIR DATOS PARA CANCELAR LA MODIFICACION
if(isset($_POST['FolioTramite'])){
    //ELIMINAMOS LOS TEMPORALES DE TODAS LAS TABLAS 
    $FolioTramite = $_POST['FolioTramite'];
    $sql = 'DELETE from solicitudestemp WHERE IdSolicitud='.$FolioTramite.'';
    //echo $sql;
    if ($conexion->query($sql) == TRUE){
        $sql = 'DELETE from solicitudesinformacion WHERE IdSolicitud='.$FolioTramite.'';
        //echo $sql;
        if ($conexion->query($sql) == TRUE){
            echo "Se cancelo la modificación con éxito";
        }else{
            echo "ERROR al cancelar la modificación";
        }
    }else{
        echo "ERROR al cancelar la modificación";
    }
}else{
    echo 'No se recibieron datos';
}
?>