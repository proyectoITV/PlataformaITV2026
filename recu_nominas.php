<?php
require("seguridad.php");
require("components.php");
require_once("config.php");
require_once("xmlfun_nominas.php");
require_once("lib/funciones.php");

//ACTUALIZACION DE DATOS DE EMPLEADOS DESDE NOMINAS

$sql="select * from nominas order by FechaNomina DESC limit 400";
$r = $conexion -> query($sql);
while($f = $r -> fetch_array())
{

    $archivo_xml = $f['File'];    
    $xmlCont = file_get_contents($archivo_xml);

    //Extraccio de datos:    
    $Curp = XML_CurpEmpleado($xmlCont);
    $RFC =  XML_RFCEmpleado($xmlCont);
    if (CurpUpdate($f['nitavu'], $Curp)==TRUE) {
        echo $f['nitavu']." - Curp = OK <br>";
    } else {
        echo $f['nitavu']." - Curp = X <br>";
    }

    if (RFCUpdate($f['nitavu'], $RFC)==TRUE) {
        echo $f['nitavu']." - RFC = OK <br>";
    } else {
        echo $f['nitavu']." - RFC = X <br>";
    }

}


?>