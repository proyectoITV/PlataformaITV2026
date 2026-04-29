<?php
require ("config.php");
if(isset($_POST['lat'])){
    $id = $_POST['id'];
    $lat = $_POST['lat'];
    $longitud = $_POST['long'];
    $exactitud = $_POST['exa'];

    $sql = "INSERT INTO ws_geo (id, latitud, longitud, exactitud) VALUES (".$id.",".$lat.", ".$longitud.", ".$exactitud.")";
     echo $sql;
   
    
        if ($conexion->query($sql) == TRUE){
        
        }else{
           
        }
        

        /*
	if($f = $rc -> fetch_array())
		{
        if ($f['n']>=1){
            return TRUE;
        } else{
            return FALSE;
        }
        */
   /* $Nodo = new stdClass;
    $Nodo ->Longitud = $longitud;
    $Nodo ->Latitud = $lat;
    $Nodo ->Exactitud = $exactitud;
    $elJSON = json_encode($Nodo);
    echo $elJSON;*/

   //echo "<input type='text' id='respuesta' name='respuesta' value=".$elJSON.">";
   /* $cadena = '{"Latitud":'."$lat".',"Longitud":'.$longitud.',"Exactitud":'.$exactitud.'}';
    echo $cadena;
    echo $json = json_encode($cadena);*/
    
}

?>
