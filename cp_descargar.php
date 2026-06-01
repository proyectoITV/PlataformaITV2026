<?php
require("config.php");
require ("lib/funciones.php");
require ("lib/flor_funciones.php");
if (!defined('FTP_PORT')) {
    define('FTP_PORT', 21);
}
// ob_end_clean();
if (isset($_GET['nombre'])){
    $archivo = $_GET['nombre'];
    if (FTP_existe_archivo($archivo)=="TRUE"){
        if (FTP_descargar($archivo)=="TRUE"){
            
           $nombre = basename($archivo);
           $file = "tmp/".$archivo;
            if (ob_get_length()) {
                ob_clean();
            }
            header('Content-Disposition: attachment; filename="' . $nombre .'"'); 
            //header("Content-disposition: attachment; filename=$file");
            header("Content-type: application/octet-stream");
            header("Content-Length: " . filesize($file));
            readfile($file);
            exit;
        }else{
            echo "No lo puede descargar";
        }
    }else{				
        echo "No existe el archivo";//archivo
    }
}
?>