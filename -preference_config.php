<?php
    $Pdbhost = '192.168.159.15';	
    $Pdbuser = 'root';
    $Pdbpass = '3L54NT0**'; 
    $Pdbname = 'produccion_itavu';
    $Pdbpuerto = 3306;

if (function_exists('mysqli_connect')) {		
    if (!isset($GLOBALS['dbP']) || !($GLOBALS['dbP'] instanceof mysqli)) {
        $GLOBALS['dbP'] = new mysqli($Pdbhost,$Pdbuser,$Pdbpass,$Pdbname,$Pdbpuerto);
        $GLOBALS['dbP']->query("SET NAMES 'utf8'"); // para los acentos
    }
    $dbP = $GLOBALS['dbP'];
    }else{			
        die ("Error en la conexion a la base de datos principal de RINTERA");
    }

    // var_dump($dbP);    

?>