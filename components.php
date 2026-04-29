<?php
require("config.php");
require("var_clean.php");
require("preference.php");
require_once("lib/funciones.php");
require_once("lib/cano_funciones.php"); 
require_once("lib/laura_funciones.php");
require_once("lib/yes_funciones.php"); 
require_once("lib/flor_funciones.php"); 
require("xmlfun_nominas.php");
require("componentsreportes.php");

//creada para correr reportes
/* function ReporteR($id_rep, $Tipo, $ClaseDiv, $ClaseTabla, $IdUser ){
    require("config.php");	
    $ClaseTabla = "tabla table-striped table-hover";
    $IdCon = IdConReporteR($id_rep);
    $ConType = ConType($IdCon);

    // echo "Tipo = ".$Tipo;
    // echo "ConType=".$ConType;
    //Validaciones


    // $Tipo = 1; // 0 = html, 1= DataTable, 2 = PDF, 3 = Excel, 4 = Word
    $Data = "";
        switch ($ConType) {
            case 0:  //rintera
                $Data = DataFromMySQL($ClaseDiv,$ClaseTabla, $Tipo, $IdUser, $id_rep);
                break;

            case 1:  //MySQL        
                $Data = DataFromMySQL($ClaseDiv,$ClaseTabla, $Tipo, $IdUser,$id_rep);
                break;

            case 2:  //MSQLSERVERTOJSON      
                
                // $Data =  DataFromSQLSERVERTOJSON($IdCon, $Tipo,$ClaseTabla,$ClaseDiv, $IdUser);
                $Data =  DataFromSQLSERVERTOJSON($id_rep, $Tipo, $ClaseTabla, $ClaseDiv, $IdUser );
                break;
            
        }


        return $Data;


}

function IdConReporteR($id_rep){
    require("config.php");   
    // var_dump($dbUser);
    $sql = "select * from reportes WHERE id_rep ='".$id_rep."'";        
    
    $r= $conexion -> query($sql);
    if($f = $r -> fetch_array())
    {
        return $f['IdCon'];
    } else {
        return "FALSE";
    }
        
}

function ConType($IdCon){
    require("config.php");   
    
    $sql = "select * from dbs WHERE Idcon='".$IdCon."'";
    $rc= $conexion -> query($sql);
    if($f = $rc -> fetch_array())
    {
        return $f['ConType'];
    } else{
        return "";
    }
        
} */

?>