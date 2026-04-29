<?php
require('config.php');
require('lib/funciones.php');

if (isset($_POST['nitavu']) and isset($_POST['Tabla']) and isset($_POST['Archivo'])){
    $nitavu = $_POST['nitavu']; $Tabla = $_POST['Tabla']; $Archivo = $_POST['Archivo'];
    historia($nitavu, "Exporte ".$Tabla." al archivo ".$Archivo);

    header('Content-type: application/vnd.ms-excel;charset=UTF-8*');
    header('Content-Disposition: attachment; filename='.$Archivo.'.xls');
    echo $Tabla;



} else {
    
}





?>