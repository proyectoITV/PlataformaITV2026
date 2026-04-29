<?php
// ██████╗ ██████╗ ███████╗███████╗███████╗██████╗ ███████╗███╗   ██╗ ██████╗███████╗
// ██╔══██╗██╔══██╗██╔════╝██╔════╝██╔════╝██╔══██╗██╔════╝████╗  ██║██╔════╝██╔════╝
// ██████╔╝██████╔╝█████╗  █████╗  █████╗  ██████╔╝█████╗  ██╔██╗ ██║██║     █████╗  
// ██╔═══╝ ██╔══██╗██╔══╝  ██╔══╝  ██╔══╝  ██╔══██╗██╔══╝  ██║╚██╗██║██║     ██╔══╝  
// ██║     ██║  ██║███████╗██║     ███████╗██║  ██║███████╗██║ ╚████║╚██████╗███████╗
// ╚═╝     ╚═╝  ╚═╝╚══════╝╚═╝     ╚══════╝╚═╝  ╚═╝╚══════╝╚═╝  ╚═══╝ ╚═════╝╚══════╝
//            A d m i n i s t r a d o r    d  e   P r e f e r e n c i a  s
//                      by JPedraza | printepolis@gmail.com
// 
// Utilize GroupA y B para orgnizar caracteristicas
// especiales agrupadas
//
// 
//----------------------------------------------


//Conección a la base datos, se requite tabla preferences:

//DDL:
// CREATE TABLE `preferences` (
//     `Preference` varchar(200) NOT NULL,
//     `Value` varchar(255) NOT NULL,
//     `GroupA` varchar(255) NOT NULL COMMENT 'Agrupacion para organizar 1',
//     `GroupB` varchar(255) NOT NULL COMMENT 'Agrupacion para organizar 2',
//     PRIMARY KEY (`Preference`)
//   ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

//CONEXION DE LA BASE DE DATOS DE RINTERA	
// $db0_host = 'localhost';	
// $db0_user = 'c1551508_rintera';
// $db0_pass = 'renine01PO'; 
// // $db0_pass = ''; 


// $db0_host = 'localhost';	
// $db0_user = 'root';
// $db0_pass = '3l-1t4vu'; 
// // $db0_pass = ''; 
// $db0_name = 'rintera_procimart';

// $Pdbhost = "localhost";
// $Pdbuser  = "root";
// $Pdbpass = "";
// $Pdbname = "rintera";

$Pdbhost = '192.168.159.5';	
$Pdbuser = 'wbproduction1';
$Pdbpass = '4Dm1NPr0'; 
$Pdbname = 'itavu';


if (function_exists('mysqli_connect')) {		
    $dbP = new mysqli($Pdbhost,$Pdbuser,$Pdbpass,$Pdbname);    
    $acentos = $dbP->query("SET NAMES 'utf8'"); // para los acentos
    
    // global $dbP;
    
    }else{			
        die ("Error en la conexion a la base de datos principal de RINTERA");
    }

    // var_dump($dbP);    

?>