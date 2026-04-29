<?php
// include ("./unica/body_head.php");
// include ("./unica/body_menu.php");
// $nitavu = $_POST['nitavu'];
require_once("unica/config.php");
require_once("unica/funciones.php");
$IdApp = $_POST['IdApp'];
$nitavu = $_POST['nitavu'];
$titulo =$_POST['titulo'];
$NFile = NFile($IdApp);

// echo $NFile;
if ( 0 < $_FILES['archivo']['error'] ) {
    echo 'Error: ' . $_FILES['archivo']['error'] . '<br>';
}
else {
    $archivofinal = 'wowslider/'.$IdApp.$NFile.".jpg";
    // move_uploaded_file($_FILES['file']['tmp_name'], 'wowslider/' . $_FILES['file']['name']);
    move_uploaded_file($_FILES['archivo']['tmp_name'], $archivofinal);
    
    $msg =  "<b><img src='icon/ok.png' style='width:20px;'>Archivo subido con exito ";

    //agregar el registro
    $sql = "INSERT INTO WOWSlider(titulo, idapp, src, nitavu, fecha, hora, IdFile)
    VALUES ('".$titulo."', '".$IdApp."', '".$archivofinal."', '".$nitavu."','".$fecha."', '".$hora."', '".$NFile."')";
    // echo $sql;
    if ($conexion->query($sql) == TRUE){
        $msg = $msg." y guardado.</b>";
        mensaje($msg,"atencionp.php?sl=");
    }

}

?>