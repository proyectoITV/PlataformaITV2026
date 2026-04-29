<?php
require("config.php");
require("seguridad.php");
require("var_clean.php");
require("lib/funciones.php");
require("viaticos_fun.php");
// require_once("lib/flor_funciones.php");

function CheckServiciosGoogle(){

    $addressFrom = "Victoria, Tamaulipas";
    $addressTo = "Tampico, Tamaulipas";
    // echo "Origen: ".$addressFrom.", Destino: ".$addressTo;
    
        $distance = getDistance($addressFrom, $addressTo, "K");
        if (is_numeric($distance)){
            $distance = $distance + rand(60,70);
            $Distancia =  number_format($distance, 2, '.', '');        
            // Toast("Distancia ".$addressFrom." a ".$addressTo." obtenida correctamente de los Servicios de Google Cloud",4,"");
        } else {        
            
            // Toast("Error  al obtener informacion de los Servicios Google",2,"");
            MsgBox_Lite("ERROR al obtener los Servicios de Google","");
        }
    
    
}



?>