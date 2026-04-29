<?php
require ("seguridad.php");
require ("lib/funciones.php");
require ("lib/flor_funciones.php");
ob_end_clean();
$IdFile = $_GET['id'];

$Archivo = "digitalfiles/".$IdFile.".pdf";
$ArchivoFinal =  DigitalFile_nombre($IdFile);

historia($nitavu, "Descargo el Archivo Id.".$IdFile." (".DigitalFile_nombre($IdFile).")");
if (DigitalFile_view($IdFile, $nitavu) == TRUE){
    header('Content-Disposition: attachment; filename="' . $ArchivoFinal .'"'); 
            //header("Content-disposition: attachment; filename=$file");
    header("Content-type: application/octet-stream");
    readfile($Archivo);
}
