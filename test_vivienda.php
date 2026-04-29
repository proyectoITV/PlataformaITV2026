<?php
require("config.php"); require("lib/funciones.php"); require("lib/flor_funciones.php");

//$consulta = "SELECT NombreCompleto, Programa, Municipio, Colonia, manzana, lote, NumContrato FROM Vivienda_InformacionContratos WHERE (IdMunicipio = 2) AND (IdColonia = 31) AND (manzana = 1) AND (lote = 2)";
//$consulta = "select * from MUNICIPIOS";
$consulta="select * from prueba1";

$ConsultaDATA = DatosVivienda(0, "WS", "Test", $consulta);
$array = json_decode($ConsultaDATA, true);



if(is_array($array)){
    

     foreach ($array as $value) {
        if (isset($value['r'])){// si hay un error
            echo "Error: ".$value['r'];

        } else {
            
            //echo "".$value['Municipio']."<br>";
            echo "".$value['Dependencia']." - ".$value['NumContrato']."<br>";
        }
           
     }
} else {
    echo "ERROR: No es un array";
}




?>