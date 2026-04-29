<?php
require("config.php");
require("seguridad.php");
require("var_clean.php");
require("lib/funciones.php");
require("vehiculos_fun.php");
// require_once("lib/flor_funciones.php");

if (isset($_GET['id'])){
    $id = $_GET['id'];

    $sql = "SELECT * FROM ci WHERE IdCi='".$id."'";
    // echo $sql;
	$rc= $conexion -> query($sql);
	
	if($f = $rc -> fetch_array())	
    {
    echo "<a  class='btn btn-danger' href='?='>Regresar</a>";
    echo "<br>";
    echo "<br>";
    if ($f['icon']=='video.png'){
            
            echo "<iframe src='components_video.php?src=ci/".$f['Link']."' style='width:100%; height:80%;'>";

            echo "</iframe>";
        } else {        
            echo "<iframe src='ci/".$f['Link']."' style='width:100%; height:80%;'>";

            echo "</iframe>";
        }

        if (ciHistory($id, $nitavu) == TRUE){
            //Toast("Se registro tu visita al Documento ".$f['Nombre'],4,"");
            
        } else {
            // Toast("hubo un problema al registrar tu visita al Documento ".$f['Nombre'],2,"");
        }
    }
	else
	{
        echo "Archivo no Disponible";
    
    }

}


?>