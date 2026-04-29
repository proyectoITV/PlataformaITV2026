<?php
function Problema_create($TAG, $Descripcion, $IdEmpleado = "", $IdApp = ""){
require("config.php");
$sql = "
    INSERT INTO problemas
        (TAG, Descripcion, IdEmpleado, IdApp, fecha, hora)
    VALUES 
        ('".$TAG."', '".$Descripcion."', '".$IdEmpleado."', '".$IdApp."','".$fecha."', '".$hora."')
    
    ";
    if ($conexion->query($sql) == TRUE){                   	        
        return TRUE;
	} else {
		return FALSE;
	}


unset($sql);
}



function Problema_set_atentido($IdProblema, $IdUsuario){
    require("config.php");
    $sql = "
    UPDATE problemas SET status='1', atendido = '".$IdUsuario."'
	WHERE IdProblema ='".$IdProblema."'";
    
        if ($conexion->query($sql) == TRUE){                   	        
            return TRUE;
        } else {
            return FALSE;
        }
    
    
    unset($sql);
}
    
function Problema_set_status($IdProblema, $IdUsuario, $IdStatus){
    require("config.php");
    $sql = "
    UPDATE problemas SET status='".$IdStatus."', atendido = '".$IdUsuario."'
	WHERE IdProblema ='".$IdProblema."'";
    
        if ($conexion->query($sql) == TRUE){                   	        
            return TRUE;
        } else {
            return FALSE;
        }
    
    
    unset($sql);
}

function Problema($IdEmpleado){
require("config.php");
$sql = "select * from problemas	WHERE IdProblema='".$IdProblema."'";	    
$r= $conexion -> query($sql);						
if($f = $r -> fetch_array())
{
    return strtoupper($f['TAG'])." ".$f['Descripcion'].". por ".$f['IdEmpleado']."  el ".$f['fecha']." a las ".$f['hora'];
} else {
    return "Problema no encontrado";
}
unset($sql, $f, $r);
}




function problemas($IdEmpleado, $TAG, $LaFecha = ""){
    require("config.php");
    if ($LaFecha == "") {$LaFecha = $fecha;}
    $sql = "select count(*) as n from problemas	WHERE IdEmpleado='".$IdEmpleado."' and TAG='".$TAG."' and fecha='".$LaFecha."' and status='0'";	    
    echo $sql;
    $r= $conexion -> query($sql);						
    if($f = $r -> fetch_array())
    {
        return $f['n'];
    } else {
        return 0;
    }
    unset($sql, $f, $r);
}
    
  

// ======= BLOQUEOS MAESTROS =========
function bloqueomaestro_create($IdEmpleado, $Motivo, $Autorizo){
    require("config.php");
    if (bloqueomaestro_($IdEmpleado) == FALSE){
        $sql = "
        INSERT INTO bloqueomaestro
            (Nitavu, Fecha, Hora, Autorizo, Comentario, status)
        VALUES 
            ('".$IdEmpleado."', '".$fecha."', '".$hora."', '".$Autorizo."','".$Motivo."','1')

        ";
        if ($conexion->query($sql) == TRUE){                   	        
            return TRUE;
        } else {
            return FALSE;
        }
        unset($sql);
    }  else {
        $sql = "
        UPDATE bloqueomaestro
        SET   Fecha='".$fecha."', Hora='".$Hora."', Autorizo='".$Autorizo."', Comentario='".$Motivo."', status='1'
        WHERE Nitavu='".$IdEmpleado."'
        ";
        if ($conexion->query($sql) == TRUE){                   	        
            return TRUE;
        } else {
            return FALSE;
        }
        unset($sql);
    }
    
    
}

function bloqueomaestro_delete($IdEmpleado){
    require("config.php");
    
        $sql = "
        UPDATE bloqueomaestro
        SET   Fecha='".$fecha."', Hora='".$Hora."', status='0'
        WHERE Nitavu='".$IdEmpleado."'
        ";
        if ($conexion->query($sql) == TRUE){                   	        
            return TRUE;
        } else {
            return FALSE;
        }
        unset($sql);
    
    
    
}

function bloqueomaestro($IdEmpleado){
    require("config.php");
    $sql = "select * from bloqueomaestro WHERE Nitavu='".$IdEmpleado."'";	    
    $r= $conexion -> query($sql);						
    if($f = $r -> fetch_array())
    {
        if ($f['status']=='0'){
            return FALSE;
        } else {
            return TRUE;
        }
    } else {
        return FALSE;
    }
    unset($sql, $f, $r);
}

function bloqueomaestroFull($IdEmpleado){
    require("config.php");
    $sql = "select * from bloqueomaestro WHERE Nitavu='".$IdEmpleado."'";	    
    $r= $conexion -> query($sql);						
    if($f = $r -> fetch_array())
    {
        if ($f['status']=='0'){
            return "";
        } else {
            return "<b>".$f['Comentario']."</b> ".$f['Fecha'].":".$f['Hora'].", creado por ".$f['Autorizo'];
        }
    } else {
        return "";
    }
    unset($sql, $f, $r);
} 

function bloqueomaestro_($IdEmpleado){
    require("config.php");
    $sql = "select * from bloqueomaestro WHERE Nitavu='".$IdEmpleado."'";	    
    $r= $conexion -> query($sql);						
    if($f = $r -> fetch_array())
    {
        return TRUE;
    } else {
        return FALSE;
    }
    unset($sql, $f, $r);
}

?>