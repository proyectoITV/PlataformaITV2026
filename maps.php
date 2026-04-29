
<?php
//header('Content-Type: application/json');
$contents = file_get_contents('https://plataformaitavu.tamaulipas.gob.mx/ws/geolocalizacion_ws.php'); 
//echo $contents;
$json = utf8_encode($contents);
$data = json_decode($json);

var_dump($data);



?>
