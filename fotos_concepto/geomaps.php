<?php
require('unica/funciones.php');
$WebService_Geo_URL = "https://plataformaitavu.tamaulipas.gob.mx/ws/geo.php";


// $DataWb = file_get_contents($WebService_Geo_URL);

$DataWb = getPage($WebService_Geo_URL);
//echo $DataWb;

$array = json_decode($DataWb, true);
var_dump($array);

if(is_array($array)){
    foreach ($array as $value) {
        
        echo "Latitud: ".$value['lat']."<br>";
        echo "Longitud: ".$value['lang']."<br>";
        echo "Exactitud: ".$value['ac']."<br>";
        
        echo "<hr>";
    }
} else {
    echo "No es un array";
}





?>




