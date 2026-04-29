<?php
$archivo = $_GET['ruta'];
 $file = "tmp/peticiones/1_1_clase con todo.txt";
header("Content-disposition: attachment; filename=$file");
header("Content-type: application/octet-stream");
readfile($file);
 
?>