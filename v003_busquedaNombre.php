<?php 
require_once("seguridad.php"); 
require_once("config.php");
require_once("lib/funciones.php");
require_once("lib/flor_funciones.php");
require_once("lib/yes_funciones.php");
?>

<?php
      
  
      //BUSQUEDA POR NOMBRE
if(isset($_POST['nom'])){
    $nombres = $_POST['nom'];
    $apaterno = $_POST['apaterno'];
    $amaterno = $_POST['amaterno'];
    $link = $_POST['link'];
  
    busquedaPorNombre($nombres, $apaterno, $amaterno, $link);
}else{
    echo "Parametros incorrectos";
}

?>