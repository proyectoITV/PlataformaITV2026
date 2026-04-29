<?php
require("seguridad.php");
require_once("config.php");
require_once("lib/funciones.php");
$Descripcion = $_POST['Descripcion'];
$Tags = $_POST['Tags'];
$NFile = NFile("DigitalFile");

// echo $NFile;
if ( 0 < $_FILES['archivo']['error'] ) {
    echo 'Error: ' . $_FILES['archivo']['error'] . '<br>';
}
else {
    $archivofinal = 'digitalfiles/'.$NFile.".pdf";
    // move_uploaded_file($_FILES['file']['tmp_name'], 'wowslider/' . $_FILES['file']['name']);
    if (move_uploaded_file($_FILES['archivo']['tmp_name'], $archivofinal)){
        Toast("Se ha guardado correctamente",4,"");
    } else {
        Toast("Hubo un error al guardar el archivo ",2,"");
        
    }
    
    

    //agregar el registro
    $sql = "INSERT INTO digitalfiles(IdFile, FileName, FileExtension, Descripcion, fecha, hora, Propietario, Tags )
    VALUES ('".$NFile."', '".$_FILES['archivo']['name'] ."', 'pdf', '".$Descripcion."','".$fecha."', '".$hora."', '".$nitavu."','".$Tags."')";
    // echo $sql;
    if ($conexion->query($sql) == TRUE){       
        mensaje("Archivo guardado con exito","DigitalFile.php");
    } else {
        mensaje("ERROR al guardar el archivo ".$sql,"DigitalFile.php");
    }

    echo "<script>$('#DigitalFileForm').hide();</script>";
}

?>