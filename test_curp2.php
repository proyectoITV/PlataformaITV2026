<?php 
error_reporting(E_ALL);
ini_set('display_errors', '1');

include ("lib/body_head.php");
include ("lib/body_menu.php");
docdigital_no(FALSE, 2);
$ResultadoDelCURP = CURP("PEPJ810213HTSDRN032", $nitavu); //<-- se entrega en formato JSON
$c = 1;

$array = json_decode($ResultadoDelCURP, true);
if(is_array($array)){
    
    foreach ($array as $value) {
        if ($c==2){

        echo "CURP: ".$value['CURP']."<br>";
        echo "Nombre: ".$value['nombres']."<br>";
        echo "Apellido Paterno: ".$value['apellido1']."<br>";
        echo "Apellido Materno: ".$value['apellido2']."<br>";
        echo "Sexo: ".$value['sexo']."<br>";
        echo "Fecha de Nacimiento: ".$value['fechNac']."<br>";
        echo "Nacionalidad: ".$value['nacionalidad']."<br>";
        echo "Documento Probatorio: ".$value['docProbatorio']."<br>";
        echo "Numero de Acta: ".$value['numActa']."<br>";
        echo "CRIP: ".$value['CRIP']."<br>";
        echo "Numero de Entidad Registrante ".$value['numEntidadReg']."<br>";
        echo "Clave de Municipio Registrante: ".$value['cveMunicipioReg']."<br>";
        // echo "Num. de Registro para Extranjeros: ".$value['NumRegExtranjeros']."<br>";
        echo "Estado del CURP: ".$value['statusCurp']."<br>";
        // echo "Entidad de Nacimiento: ".$value['nombreEntidadNac']."<br>";
        // echo "Entidad Registrante: ".$value['nombreEntidadReg']."<br>";
        // echo "Municipio Registrante ".$value['nombreMunicipioReg']."<br>";
        }

        echo "<hr>";
        $c= $c +1;
    }
} else {
    echo "No es un array";
}






include ("lib/body_footer.php"); ?>


