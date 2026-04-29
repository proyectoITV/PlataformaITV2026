<?php

function CurpEstatus($Curp) {
    require("config.php");
    require_once("password_fun.php");
    $sql="select * from _curps where Curp='".$Curp."' and Curp_Data<>'' ";
    
    $r= $Vivienda -> query($sql);	
    
    if($f = $r -> fetch_array())
    {
        // var_dump($f);			
        // echo $f['Curp_Status'];
        return $f['Curp_Status'];
    } else {
        return '';
    }
    unset($sql, $f, $r);
}

function Curp_Fallecido($Curp){
    $Estatus = CurpEstatus($Curp);
    // echo $Estatus;
    if ($Estatus=='BD'){
        // $R = "Baja por Defuncion";
        return TRUE;
    } else {
        return FALSE;
    }
}

function Curp_FNacimiento($Curp) {
    require("config.php");
    require_once("password_fun.php");
    $sql="select * from _curps where Curp='".$Curp."' and Curp_Data<>'' ";
    $r= $Vivienda -> query($sql);						
    if($f = $r -> fetch_array())
    {
        return $f['Curp_FechaNacimiento'];
    } else {
        return '';
    }
    unset($sql, $f, $r);
}


function CurpLimite(){
require("config.php");    
    $sql="select count(*) as n from curp_consultas where fecha=curdate()";
    $r= $conexion -> query($sql);						
    if($f = $r -> fetch_array())
    {
        return $f['n'];
    } else {
        return 0;
    }
    unset($sql, $f, $r);
}
function VCurps_total() {
    require("config.php");
    $sql="select count(*) as n from _curps where Curp<>'' and LENGTH(Curp)=18";
    $r= $Vivienda -> query($sql);						
    if($f = $r -> fetch_array())
    {
        return $f['n'];
    } else {
        return 0;
    }
    unset($sql, $f, $r);
}

function VCurps_checks() {
    require("config.php");
    require_once("password_fun.php");
    $sql="select count(*) as n from _curps where Curp<>'' and Curp_Data<>'' ";
    $r= $Vivienda -> query($sql);						
    if($f = $r -> fetch_array())
    {
        return $f['n'];
    } else {
        return 0;
    }
    unset($sql, $f, $r);
}

function VCurps_get() {
    require("config.php");
    $LimiteCurp = CurpLimite() + 0;
    // del 27 Octubre al 12 de noviembre = 10000; despues 1000
    if ($LimiteCurp == 250) {
        $CorreoDestino = $CorreoDeLaPlataforma;
        $Contenido = "Alerta de la Plataforma, superamos las consultas de CURP de 250".$LimiteCurp;
        if (EnviarCorreo("Alerta de 250 consultas", $Contenido, $CorreoDestino, "Alerta de CURP ".$LimiteCurp) == TRUE){
            Toast("Se ha enviado un corre a ".$CorreoDestino." con Alerta de Curp ".$LimiteCurp,2,"");
        } else {
            Toast("ERROR al enviar un corre a ".$CorreoDestino." con Alerta de Limite de Curp",2,"");
        }
    }

    // if ($LimiteCurp == 500) {
    //     $CorreoDestino = $CorreoDeLaPlataforma;
    //     $Contenido = "Alerta de la Plataforma, superamos las consultas de CURP de 500".$LimiteCurp;
    //     if (EnviarCorreo("Alerta de 500 consultas", $Contenido, $CorreoDestino, "Alerta de CURP ".$LimiteCurp) == TRUE){
    //         Toast("Se ha enviado un corre a ".$CorreoDestino." con Alerta de Curp ".$LimiteCurp,2,"");
    //     } else {
    //         Toast("ERROR al enviar un corre a ".$CorreoDestino." con Alerta de Limite de Curp",2,"");
    //     }
    // }


    // if ($LimiteCurp == 1000) {
    //     $CorreoDestino = $CorreoDeLaPlataforma;
    //     $Contenido = "Alerta de la Plataforma, superamos las consultas de CURP de 1000".$LimiteCurp;
    //     if (EnviarCorreo("Alerta de 1000 consultas", $Contenido, $CorreoDestino, "Alerta de CURP ".$LimiteCurp) == TRUE){
    //         Toast("Se ha enviado un corre a ".$CorreoDestino." con Alerta de Curp ".$LimiteCurp,2,"");
    //     } else {
    //         Toast("ERROR al enviar un corre a ".$CorreoDestino." con Alerta de Limite de Curp",2,"");
    //     }
    // }


    // if ($LimiteCurp == 5000) {
    //     $CorreoDestino = $CorreoDeLaPlataforma;
    //     $Contenido = "Alerta de la Plataforma, superamos las consultas de CURP de 5000".$LimiteCurp;
    //     if (EnviarCorreo("Alerta de 5000 consultas", $Contenido, $CorreoDestino, "Alerta de CURP ".$LimiteCurp) == TRUE){
    //         Toast("Se ha enviado un corre a ".$CorreoDestino." con Alerta de Curp ".$LimiteCurp,2,"");
    //     } else {
    //         Toast("ERROR al enviar un corre a ".$CorreoDestino." con Alerta de Limite de Curp",2,"");
    //     }
    // }
    

    //Restringimos si se supera el limite
    if ($LimiteCurp >= 9000) {
        $CorreoDestino = $CorreoDeLaPlataforma;
        $Contenido = "Alerta de la Plataforma, se ha superado el limite de CURPS para hoy ".$LimiteCurp;
        if (EnviarCorreo("Se supero el Limite de CURPS Consultados", $Contenido, $CorreoDestino, "Alerta de CURP ".$LimiteCurp) == TRUE){
            Toast("Se ha enviado un corre a ".$CorreoDestino." con Alerta de Curp ".$LimiteCurp,2,"");
        } else {
            Toast("ERROR al enviar un corre a ".$CorreoDestino." con Alerta de Limite de Curp",2,"");
        }
        return "";
    } else { //Seleccionamos un curp, en caso contrario no
        $sql="select DISTINCT Curp as Curp from _curps where Curp<>''  and Curp_Data=''  and LENGTH(Curp)=18 limit 1";
        // echo $sql;
        $r= $Vivienda -> query($sql);						
        if($f = $r -> fetch_array())
        {
            return $f['Curp'];
        } else {
            return "";
        }
        unset($sql, $f, $r);
    }
}


function VCurps_savedata($Curp, $Data, $Status, $CurpNombre, $CurpFechaNacimiento) {
    require("config.php");    


    $sql = 
    "   UPDATE _curps SET 
        Curp_Data = '".LimpiarComillas($Data)."', 
        Curp_Status = '".$Status."', 
        Curp_Nombre = '".LimpiarComillas($CurpNombre)."', 
        Curp_FechaNacimiento = '".$CurpFechaNacimiento."'        
	    WHERE Curp ='".$Curp."'
    ";
    echo $sql;
	
    if ($Vivienda->query($sql) == TRUE){                 
		return TRUE;
	} else {
		return FALSE;
	}
}

function VCurps_Go() {
    require("config.php");
    $Curp = VCurps_get();

    if (VCurps_savedata($Curp, $Data, $Status, $CurpNombre, $CurpFechaNacimiento)==TRUE){

    } else {

    }

    
}


?>