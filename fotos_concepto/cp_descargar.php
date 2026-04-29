<?php
require ("unica/funciones.php");
require ("unica/flor_funciones.php");
ob_end_clean();
if (isset($_GET['nombre'])){
    $archivo = $_GET['nombre'];
    if (FTP_existe_archivo($archivo)=="TRUE"){
        if (FTP_descargar($archivo)=="TRUE"){
            
           $nombre= substr($archivo, strripos($archivo, '/'),  strlen($archivo) );
           $file = "tmp/".$archivo;//nombre;
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
<script>
console.log('<?php echo "nombre".$nombre; ?>');

</script>