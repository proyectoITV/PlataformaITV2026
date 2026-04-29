<?php 

require_once("config.php");
require("seguridad.php"); 
 require_once("config.php");
 require_once("lib/funciones.php");
 require_once("lib/flor_funciones.php");
 //ob_end_clean();
?>

<?php
        
        $FolioTramite = $_POST['Folio']; 
        $TipoTramite = $_POST['Tipo']; 
        $CampoFile = $_POST['campo']; 
       

        $Usuario = $nitavu;
       // echo 'folio'.$FolioTramite;

            // $ruta = 'tramitesFiles';
            // $NombreDelArchivo = $ruta."/AcuseFinal".$FolioTramite.".pdf";

            // $ArchivoTmp = $_FILES["FileAcuseFinal"]['tmp_name'];
            // if ($_FILES["FileAcuseFinal"]['error'] !== 0) {
            //         //return 'Error al subir el archivo (¿demasiado grande?)';
            // } else {
            //     if ( mime_content_type($_FILES["FileAcuseFinal"]['tmp_name']) == 'application/pdf')
            //     {
            //         if (move_uploaded_file($ArchivoTmp, $NombreDelArchivo)) { //se subio correctamente
            //             //Guardar Dato
                        
            //            echo "<a href='".$NombreDelArchivo."' download='AcuseFinal".$FolioTramite.".pdf' target=_blank><img src='icon/pdf.png' style='width:36px;'></a>";
            //           /// echo"<a class='Mbtn btn-azulTam' onclick='AprobarTramite(".$FolioTramite.",".$TipoTramite.")' title='Clic para aprobar'><img src='icon/ok.png' style='width:20px; height:20px;'></a>";
    
                    
            //         } else {
            //             echo "<b style='color:red;' >ERROR: al subir el archivo, intentelo nuevamente.</b>";
            //         }
            //     } else {
            //         echo "<b style='color:red;' >ERROR: no es un archivo valido</b>";
            //     }
            // }


             $ruta = 'tramitesFiles';
            $NombreDelArchivo = $ruta."/".$CampoFile.$FolioTramite.".pdf";

            $ArchivoTmp = $_FILES[$CampoFile.$FolioTramite]['tmp_name'];
            if ($_FILES[$CampoFile.$FolioTramite]['error'] !== 0) {
                    //return 'Error al subir el archivo (¿demasiado grande?)';
            } else {
                if ( mime_content_type($_FILES[$CampoFile.$FolioTramite]['tmp_name']) == 'application/pdf')
                {
                    if (move_uploaded_file($ArchivoTmp, $NombreDelArchivo)) { //se subio correctamente
                        //Guardar Dato
                        
                       echo "<a href='".$NombreDelArchivo."' download='".$CampoFile.$FolioTramite.".pdf' target=_blank><img src='icon/pdf.png' style='width:36px;'></a>";
                      /// echo"<a class='Mbtn btn-azulTam' onclick='AprobarTramite(".$FolioTramite.",".$TipoTramite.")' title='Clic para aprobar'><img src='icon/ok.png' style='width:20px; height:20px;'></a>";
    
                    
                    } else {
                        echo "<b style='color:red;' >ERROR: al subir el archivo, intentelo nuevamente.</b>";
                    }
                } else {
                    echo "<b style='color:red;' >ERROR: no es un archivo valido</b>";
                }
            }
            
?>