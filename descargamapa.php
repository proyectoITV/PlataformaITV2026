<?php
require ("lib/funciones.php");
require ("lib/flor_funciones.php");
ob_end_clean();

if (isset($_GET['nombre'])){
   
    $archivo = $_GET['nombre'];
   
    if (FTP_existe_archivo($archivo)=="TRUE"){
        
        if (FTP_descargar($archivo)=="TRUE"){
           echo  $archivo;         

        }else{
           // echo "No lo puede descargar";
            echo "Notificadores/sinfoto.jpg";
        }
    }else{				
       // echo "No existe el archivo";//archivo
       echo  "Notificadores/sinfoto.jpg";
    }
}
?>
