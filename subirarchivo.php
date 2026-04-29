<?php 
 require("seguridad.php"); 
 require_once("config.php");
 require_once("lib/funciones.php");
 require_once("lib/flor_funciones.php");
 require_once("lib/yes_funciones.php");
//  ob_end_clean();
?>

<?php


//if (sanpedro($id_aplicacion, $nitavu)==TRUE){  	    
    $IdDelegacion = $_POST['IdDelegacion']; if (ValidaVAR($IdDelegacion)==TRUE){$IdDelegacion = LimpiarVAR($IdDelegacion);} else {$IdDelegacion = "";}
    $IdPrograma = $_POST['IdPrograma']; if (ValidaVAR($IdPrograma)==TRUE){$IdPrograma = LimpiarVAR($IdPrograma);} else {$IdPrograma = "";}
    $Folio = $_POST['Folio']; if (ValidaVAR($Folio)==TRUE){$Folio = LimpiarVAR($Folio);} else {$Folio = "";}
    $IdArchivo = $_POST['IdArchivo']; if (ValidaVAR($IdArchivo)==TRUE){$IdArchivo = LimpiarVAR($IdArchivo);} else {$IdArchivo = "";}
    $IdArchivo = $_POST['IdApp']; if (ValidaVAR($IdApp)==TRUE){$IdApp = LimpiarVAR($IdApp);} else {$IdApp = "";}
    $Usuario = $nitavu;

    if($_FILES["Documento"]["name"]){
        $doc = $_FILES["Documento"]["name"]; //Obtenemos el nombre original del archivo
        $tmp = $_FILES["Documento"]["tmp_name"]; //Obtenemos un nombre temporal del archivo
        $num = ndocumento(TRUE);
         $ruta = 'DocumentosFiles/';
        $NombreDelArchivo = $ruta."/".$num.".pdf";
        //$directorio = 'docs/'; //Declaramos un  variable con la ruta donde guardaremos los archivos
        $archivo = $ruta.$num.".pdf";//."_".$doc."";
        $subida = FTP_subir($tmp,$archivo);
        
       
        if ($subida == "TRUE"){
          $identificador=obtenerNumArchivoVigente($IdDelegacion,$IdPrograma,$Folio,$IdArchivo); 
        //IDENTIFICAMOS SI EXISTE YA UN ARCHVIO, SI YA EXSITE CANCELAMOS EL QUE TIENE
             if($identificador!='')
                {
                        $sql = "Update relacion_documentos set cancelado=1 where n_archivo=".$identificador;
                        //echo $sql;
                        if ($conexion->query($sql) == TRUE)
                        { 
                           // echo 'Se cancelo el documento previo';                    
                        }
                        else
                        {                      
                            echo 'No se pudo cancelar el documento previo';
                }      

             }
            //<--- GUARDAMOS EL ARCHIVO
            documento_add($num, $doc, $nitavu,$IdApp);
            $sql = "INSERT INTO relacion_documentos(iddelegacion, idprograma, folio, n_archivo,idarchivo) 
            VALUES  ('$IdDelegacion','$IdPrograma','$Folio','$num', '$IdArchivo')";
            if ($conexion->query($sql) == TRUE){ 
             ndocumento(FALSE);
                          
             //entregar hipervinculo al archivo
            echo "<a  href='md_descargar.php?nombre=".$archivo."' target='_self'  onclick =''  title='Haga click aqui para descargar'>
            <img src='icon/pdf.png' style='width:36px;'></a>";
            echo "<script> document.getElementById('Documento').required=false; </script>"; 
                        
            historia($nitavu,'Subi un documento con los siguientes datos: IdDelegacion:'.$IdDelegacion.', IdPrograma:'.$IdPrograma.',Folio:'.$Folio.',  NumArchivo: '.$doc);
                       //echo 'Se ha subido el archivo con éxito';
          }else{
          
            historia($nitavu,'No se pudo guardar la inforrmacion del archivo con los siguientes datos : IdDelegacion:'.$IdDelegacion.', IdPrograma:'.$IdPrograma.',Folio:'.$Folio.',  NumArchivo: '.$doc);
            echo 'No se pudo guardar la informacion del archivo';
          }      
        }else{   
            echo "<b style='color:red;' >ERROR: al subir el archivo, intentelo nuevamente.</b>"; 
         
        }
      }
  
// }else{
//     // mensaje('No tiene permiso para esta aplicación','index.php');
// }





?>

