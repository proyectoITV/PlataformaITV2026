<?php
// require_once("preference.php");
if (isset($Con_IdCon)){
require_once("rintera-config.php");   

$Con_Val = FALSE;
$Con_Msg = "";
// $Con_IdCon = 1;
$Con_Tsql = "select * from dbs where IdCon='".$Con_IdCon."' AND Active=1 AND ConType <=1";
// echo $Con_Tsql;

$RCon= $db0 -> query($Con_Tsql);
// var_dump($RCon);
if($RConF = $RCon -> fetch_array())
{
    // var_dump($RConF);
    // var_dump($RConF);
    // 1. Validacion de Datos necesarios
    if ($RConF['dbhost'] <>'' &&  $RConF['dbname']<>'' && $RConF['dbuser']<>'' && $RConF['dbpassword']<>'')    {
        $Con_host = $RConF['dbhost'];
        $Con_user = $RConF['dbuser'];
        $Con_pass = $RConF['dbpassword'];
        $Con_name = $RConF['dbname'];
        
        $LaConeccion = new mysqli($Con_host,$Con_user,$Con_pass,$Con_name);
                if ($LaConeccion->connect_error) {         
                    $Con_Msg = $Con_Msg.""."Error al conectarse, revise los datos. ".$LaConeccion->connect_error.". ";                               
                }

                //Ping
                $ConSql = "select @@version as Version";
                $ConPing= $LaConeccion -> query($ConSql);
                if($FPing = $ConPing -> fetch_array()){
                    $Con_Val = TRUE;
                    // echo "OK";
                } else {
                    $Con_Msg = $Con_Msg.""."Error de conección. ";       
                }

    } else {
        $Con_Msg = $Con_Msg."Datos insuficientes para la conección. ";
    }    
   
} else {
    $Con_Msg = $Con_Msg."Coneccion no valida. ";
}
}

?>