<?php 
require("config.php"); require("lib/funciones.php"); 

if (isset($_GET['user_origen']) & isset($_GET['user_destino']) & isset($_GET['asunto']) & isset($_GET['msj'])){

    notificacion_add($_GET['user_destino'], $_GET['asunto'], $fecha, $_GET['user_origen'], $_GET['msj']);
    echo ":)";


} else {
    echo ":(";
}




?>