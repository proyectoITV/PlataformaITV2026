<?php 
require_once("config.php");
require_once("lib/funciones.php");
require_once("lib/flor_funciones.php");


 if(isset($_POST['IdMunicipio'])){
    $IdMunicipio = $_POST['IdMunicipio'];

    $sql = "SELECT * FROM localidad WHERE IdMunicipio = ".$IdMunicipio."";
    $r2x = $Vivienda -> query($sql);
    echo  '<option value="9999">SELECCIONE UNA OPCION...</option>';
    while($fxx = $r2x -> fetch_array())
    {
        echo  '<option value="'.$fxx['IdLocalidad'].'">'.$fxx['Nombre_Localidad'].'</option>';	
    }
 
 }

?>