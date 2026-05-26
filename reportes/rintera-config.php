<?php
// require_once("components.php");

$fecha = date('Y-m-d');
$hora =  date ("H:i:s");
$SesionName="R1nT3r4";

require_once("preference.php");
// require_once("components.php");
//CONEXION DE LA BASE DE DATOS DE RINTERA	
$db0_host = 'localhost';	
$db0_user = 'root';
$db0_pass = ''; 
// $db0_pass = ''; 
$db0_name = 'itavu';

$db0_host = '192.168.159.15';	
$db0_user = 'wbproduction1';
$db0_pass = '4Dm1NPr0'; 
$db0_name = 'itavu';


// Usuario c1551508_rintera
// Clave: renine01PO
// Base de datos: c1551508_rintera
// Servidor: localhost


// $db0_host = 'localhost';	
// $db0_user = 'c1551508_rintera';
// $db0_pass = 'renine01PO'; 
// // $db0_pass = ''; 
// $db0_name = 'c1551508_rintera';

if (function_exists('mysqli_connect')) {		
    $db0 = new mysqli($db0_host,$db0_user,$db0_pass,$db0_name);
	$acentos = $db0->query("SET NAMES 'utf8'"); // para los acentos
	// var_dump($db0);
        // global $db0;
        
    }else{			
        die ("Error en la conexion a la base de datos principal de RINTERA");
}






$UsuariosForaneaos = Preference("UsuariosForaneos", "", ""); 
$QueryUsuariosForaneos = Preference("UsuariosForaneosQuery", "", "");  //"select * from UsuariosRintera where RinteraLevel>0"; 
$UsuariosForaneosIdCon = Preference("UsuariosForaneosIdCon", "", ""); 

$UsuariosForaneosIdConType = "";
$sql = "select * from dbs WHERE Idcon='".$UsuariosForaneosIdCon."'";
$rc= $db0 -> query($sql);
// var_dump($db0);
if($f = $rc -> fetch_array())
{
	$UsuariosForaneosIdConType =  $f['ConType'];
}

$Error="";
// echo $UsuariosForaneaos;
// var_dump($UsuariosForaneosIdCon);
if ($UsuariosForaneaos == "TRUE") {
    if 	($UsuariosForaneosIdCon <> "" ){
        // var_dump($UsuariosForaneosIdConType);
        if ($UsuariosForaneosIdConType  <=1) {

                  
                if ($QueryUsuariosForaneos <> '') {
                    $sql = "select * from dbs where IdCon='".$UsuariosForaneosIdCon."'";    
                    // echo $sql;    
                    $r= $db0 -> query($sql);    
                    if($Fdb = $r -> fetch_array())
                    {    
                        if ($Fdb['dbhost']<>'' &&  $Fdb['dbname']<>'' && $Fdb['dbuser']<>'' && $Fdb['dbpassword']<>'')    {
                            $dbUser_host = $Fdb['dbhost'];
                            $dbUser_user = $Fdb['dbuser'];
                            $dbUser_pass = $Fdb['dbpassword'];
                            $dbUser_name = $Fdb['dbname'];
                            // echo "dbname=".$dbUser_name;

                            // echo "OK";
                            if (function_exists('mysqli_connect')) {		
                                $dbUser = new mysqli($dbUser_host,$dbUser_user,$dbUser_pass,$dbUser_name);
                                $acentos = $dbUser->query("SET NAMES 'utf8'"); // para los acentos                            
                                // var_dump($dbUser);

                                
                                // echo "Exito";p
                            }else{
                                $Error = $Error."No esta activado MySQLi";    
                            }

                        } else {
                            $Error = $Error."Parametros insuficientes para conección." .$dbUser_host;    
                        }

                    } else {
                        $Error = $Error."No se localizo el registro de la conección ".$UsuariosForaneosIdCon.".";    
                    }           

                } else {
                    $Error = $Error."Sin Query para Foraneos";
                }
              
        } else {
            $Error = $Error."No es un tipo de Conección Permitida ConType=0,1. ";
        }
    } else {
        $Error = $Error."IdCon para Foraneos Vacia ";
    }



		
           
                

} else {
                // Conección a la base Local de rintera
                    $dbUser = $db0;
                    // $sql = "select * from users";
                    // $RUser= $dbUser -> query($sql);
                    // if($FUser = $RUser -> fetch_array()){
                    //     // var_dump($FUser);
                        
                        
                    // } else {
                        
                    //     $Error = $Error."Fallo de conección al Consultar los Usuarios";
                    // }


}


// var_dump($dbUser);
// if (isset($dbUser)) {
//     $sql = $QueryUsuariosForaneos;
//     $RUser= $dbUser -> query($sql);
    
//     if ($dbUser->query($sql) == TRUE) {
//         // echo "OK USERS";
        
//         // if($FUser = $RUser -> fetch_array()){
//         //     var_dump($FUser);                
            
//         // } else {
            
            
//         // }
//         // } else {
//         //     $Error = $Error."Fallo de conección";
//         // }

//         } else {
//             $Error = $Error."Fallo de conección al Consultar los Usuarios.!";
//         }
//     }

$StringFecha = date('Ymd')."_".  date("His");

if ($Error ==''){

} else {
    
    echo "<div id='Error'

    style='
    background-color:red;
    color:white;
    width:90%;
    display:inline-block;
    border-radius:10px;
    margin:20px;
    padding:20px;
    '
    ><table width=100%><tr><td
    style='color:white;'
    >".$Error."</td><td width=50px><a href='index.php' class='btn btn-Warning'>Reintentar</a></td></tr></table></div>";

    // $CorreoDestino = "printepolis@gmail.com";
    // $Asunto = "Error: ".$fecha;
    // $ContenidoDelCorreo = "<p>".$fecha.":".$hora.". Rintera: Ha habido un error <b>".$Error."</b> </p>";
    // EnviarCorreo($CorreoDestino, $Asunto, $ContenidoDelCorreo);




    //session.auto_start = 0 o 1;  si esta en 1, da error 
    //Warning: session_name(): Cannot change session name when session is active, al utilizar session_name(); ya que agrega    session_start(); al automaticamente
    

}



$session_auto_start = 1;
?>