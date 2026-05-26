<?php
require("seguridad.php");
require("components.php");

$IdEmpleado = "";
if ($_GET['id']){
    $IdEmpleado = VarClean($_GET['id']);
}

$FechaNomina = "";
if ($_GET['f']){
    $FechaNomina = VarClean($_GET['f']);
}


$FechaNominaString = str_replace("-", "", $FechaNomina);
$Empleado = str_replace(" ", "", nitavu_nombre($IdEmpleado)); 

    $sql = "SELECT * FROM nominas  WHERE nitavu='".$IdEmpleado."' and FechaNomina='".$FechaNomina."'";	
    // echo $sql;


   
$r= $conexion -> query($sql);if($f = $r -> fetch_array()){	
        $archivoxml = $host.$f['File'];        
        $host = "192.168.159.15/";
        $msg = "";
        $nuevo_nombre = $FechaNominaString.'_MiNomina.'.strtolower($FileType); //asignamos nuevo nombre
            $archivo_descarga = curl_init(); //inicializamos el curl
        curl_setopt($archivo_descarga, CURLOPT_URL, $archivohost); //ponemos lo que queremos descargar
        //curl_setopt($archivo_descarga, CURLOPT_HEADER, true);
        curl_setopt($archivo_descarga, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($archivo_descarga, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($archivo_descarga, CURLOPT_AUTOREFERER, true);
        $resultado_descarga = curl_exec($archivo_descarga); //realizamos la descarga
        if(!curl_errno($archivo_descarga)) // si no hay error hacemos la descarga
        {
        ob_end_clean();
        header('Content-type:aplication/'.strtolower($FileType)); //Acá le cambias el tipo de archivo (MimeType) por lo que quieras
        header('Content-Disposition: attachment; filename ="'.$nuevo_nombre.'"'); //renombramos la descarga
        echo($resultado_descarga);
        exit();
        }else
        {
            echo(curl_error($archivo_descarga)); // Si hay error lo mostramos
        }
 

} else {
    echo "No disponible";
}             
?>