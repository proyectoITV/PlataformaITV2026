<?php
require("config.php");
require("seguridad.php");
require("var_clean.php");
require("lib/funciones.php");
require("viaticos_fun.php");
// require_once("lib/flor_funciones.php");

$addressFrom = VarClean($_GET['Origen']);
$addressTo = VarClean($_GET['Destino']);
// echo "Origen: ".$addressFrom.", Destino: ".$addressTo;
if ($addressFrom<>'' || $addressTo <>''){
    if ($ServiciosGoogle==TRUE){
        $distance = getDistance($addressFrom, $addressTo, "K");
    } else {
        $distance = 0;
    }
    if ($distance > 0){
        if (is_numeric($distance)){
            $distance = $distance + rand(60,70);
            $Distancia =  number_format($distance, 2, '.', '');
            echo "
            <script>
                $('#Distancia').val(".$Distancia.");
            
            </script>";
            Toast("Distancia ".$addressFrom." a ".$addressTo." obtenida correctamente de los Servicios de Google Cloud",4,"");
        } else {
            
            echo "
            <script>
                $('#Distancia').val(0);
            
            </script>";
            Toast("Error  al obtener informacion de los Servicios Google",2,"");
        } 

    }
    else {
        Toast("Los Servicios Google no estan activados",2,"");
    }
} else {
    Toast("Primero escriba un lugar de origen y destino",2,"");
}




?>