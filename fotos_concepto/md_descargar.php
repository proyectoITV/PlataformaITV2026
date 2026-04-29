<?php
require ("unica/funciones.php");
require ("unica/flor_funciones.php");
if (isset($_GET['nombre'])){
    $archivo = $_GET['nombre'];
    if (FTP_existe_archivo($archivo)=="TRUE"){
        if (FTP_descargar($archivo)=="TRUE"){
            $file = "tmp/".$archivo;
            header('Content-Disposition: attachment; filename="' . $file .'"'); 
            //header("Content-disposition: attachment; filename=$file");
            header("Content-type: application/octet-stream");
            readfile($file);
        }else{
            return "No lo puede descargar";
        }
    }else{				
        return "No existe el archivo";//archivo
    }
}
?>