<?php 

error_reporting(E_ALL);
ini_set('display_errors', '1');
require("config.php");
require("lib/funciones.php");
// include ("lib/body_head.php");
// include ("lib/body_menu.php");

$CURP = $_GET['curp'];
$nitavu = $_GET['nuser'];

docdigital_no(FALSE, 2);

// "PEPJ810213HTSDRN032"
$ResultadoDelCURP = CURP($CURP, $nitavu); 
echo $ResultadoDelCURP;

// $c = 1;
// $exito = FALSE;
// $array = json_decode($ResultadoDelCURP, true);
// if(is_array($array)){    
//     foreach ($array as $value) {
//         if ($c==1){
//             if ($value['exito']=='true'){$exito = TRUE;} else {}
//         } else {
//             if ($exito == TRUE){
//                 echo "CURP: ".$value['CURP']."<br>";
//                 echo "Nombre: ".$value['nombres']."<br>";
//                 echo "Apellido Paterno: ".$value['apellido1']."<br>";
//                 echo "Apellido Materno: ".$value['apellido2']."<br>";
//                 echo "Sexo: ".$value['sexo']."<br>";
//                 echo "Fecha de Nacimiento: ".$value['fechNac']."<br>";
//                 echo "Nacionalidad: ".$value['nacionalidad']."<br>";
//                 echo "Documento Probatorio: ".$value['docProbatorio']."<br>";
//                 echo "Numero de Acta: ".$value['numActa']."<br>";
//                 echo "CRIP: ".$value['CRIP']."<br>";
//                 echo "Numero de Entidad Registrante ".$value['numEntidadReg']."<br>";
//                 echo "Clave de Municipio Registrante: ".$value['cveMunicipioReg']."<br>";
//                 // echo "Num. de Registro para Extranjeros: ".$value['NumRegExtranjeros']."<br>";
//                 echo "Estado del CURP: ".$value['statusCurp']."<br>";
//                 // echo "Entidad de Nacimiento: ".$value['nombreEntidadNac']."<br>";
//                 // echo "Entidad Registrante: ".$value['nombreEntidadReg']."<br>";
//                 // echo "Municipio Registrante ".$value['nombreMunicipioReg']."<br>";
//             }
        
//         }   

//     $c= $c +1;    
// }

// } else {
//     echo "ERROR: No es un array";
// }




