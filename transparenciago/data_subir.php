<?php
// include ("./unica/body_head.php");
// include ("./unica/body_menu.php");
// $nitavu = $_POST['nitavu'];
require_once("config.php");
require_once("funciones.php");

$nitavu = $_POST['nitavu'];
$FileDescripcion =$_POST['FileDescripcion'];
$IdApp = 'ap105';
$NFile = NFile($IdApp);
$FileNombre = $_POST['FileNombre'];

// echo $NFile;
if ( 0 < $_FILES['archivo']['error'] ) {
    // echo ': ' . $_FILES['archivo']['error'] . '<br>';
}
else {

    $tipo_archivo = $_FILES['archivo']['type'];


    //$archivofinal = 'files/'.$NFile.".zip";

    

    $pos = strpos($tipo_archivo, '/');
    $extension=substr($tipo_archivo,$pos+1,strlen($tipo_archivo));
    $archivofinal='files/'.$NFile.".". $extension;
    
    ///echo "<script>Console.log(".$tipo_archivo.$archivofinal2.");</script>";
     if (!strpos($tipo_archivo, "pdf") ) {
        $msg="Tipo de archivo no permitido";
        toast($msg,1,"");
        
     } else {
        // move_uploaded_file($_FILES['file']['tmp_name'], 'wowslider/' . $_FILES['file']['name']);


   
        
       // move_uploaded_file($_FILES['archivo']['tmp_name'], $archivofinal);
        if(  move_uploaded_file($_FILES['archivo']['tmp_name'], $archivofinal))
				{  $msg =  "Archivo subido con exito ".move_uploaded_file($_FILES['archivo']['tmp_name'], $archivofinal);
            //agregar el registro
            $sql = "INSERT INTO TransparenciaGo(IdFile, FileNombre, IdUser, fecha, hora, FileDescripcion)
            VALUES ('".$NFile."', '".$FileNombre."', '".$nitavu."', '".$fecha."','".$hora."', '".$FileDescripcion."')";
            // echo $sql;
            if ($conexion->query($sql) == TRUE){
                  $msg = $msg." y guardado.</b>";
                  // mensaje($msg,"atencionp.php?sl=");
            }

				} else{
				//$msgE= "No se actualizo ".$nombredelcontrol.", ";
				$msg= "Error al intentar subir el archivo ". $_FILES['archivo']['tmp_name'].$archivofinal;


                switch ($_FILES[0]['error']) {
                    case 1:
                       $html_body .= 'El archivo es más grande de lo que permite esta instalación de PHP';
                       break;
                    case 2:
                       $html_body .= 'El archivo supera el tamaño permitido por el formulario';
                       break;
                    case 3:
                       $html_body .= 'Se subió solo una parte del archivo';
                       break;
                    case 4:
                       $html_body .= 'No se subió ningún archivo';
                       break;
                    default:
                       $html_body .= 'Error desconocido';
                    } 
                  $msg=$html_body;
                    echo "<script>Console.log(".$msg.$html_body.");</script>";
				}
                
              
            
      

        historia($nitavu,'TransparenciaGo, subio el archivo '.$FileNombre." con IdFile ".$NFile.InfoEquipo().'');		
        toast($msg,1,"");
    }

    

}

?>