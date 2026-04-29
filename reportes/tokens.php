<?php


//====================FUNCIONES TOKEN
function MiToken_valida($Token, $usuario, $descripcion){
    require("rintera-config.php");
    // $Token = MiToken_generate();
    $sql = "SELECT * from  tokens WHERE user='$usuario' and token='$Token' and descripcion='".$descripcion."'";    
    // echo $sql;
    $rc= $db0 -> query($sql);
    if($f = $rc -> fetch_array()){
        if ($f['activo'] == 1){ //cerrado
            return FALSE;
        } else{ //abierto
            return TRUE;
        }
        
    }
    else 
    {
        return FALSE;
    }
    
}
function MiToken($usuario, $descripcion){
    require("rintera-config.php");
    $sql = "SELECT * from tokens WHERE user='$usuario' and activo='0' and descripcion = '".$descripcion."'";
    // echo $sql."<br>";
    $rc= $db0 -> query($sql);
    if($f = $rc -> fetch_array())
	{
        return $f['token'];
    } else {
        return MiToken_Init($usuario, $descripcion);
    }
}
function MiToken_Init($usuario, $descripcion){
    require("rintera-config.php");
    $sql = "SELECT count(*) as n from tokens WHERE user='$usuario' and activo='0' and descripcion='".$descripcion."'";
    // echo $sql;
    // echo $sql."<br>";
    $rc= $db0 -> query($sql);
    if($rc){
        if($f = $rc -> fetch_array())
	    {
            //echo $f['n'];
            if ($f['n'] == 0 )   {
                // si no tiene continuamos
				$Token = MiToken_generate();
				//echo $Token;
                $sql = "INSERT INTO tokens (id, user, descripcion, token, fecha, hora, activo, cierre_fecha, cierre_hora)
                VALUES ('','$usuario', '$descripcion', '$Token','$fecha', '$hora','0','','')";
                // echo $sql."<br>";
                if ($db0->query($sql) == TRUE)
                {return $Token;} else {return '';}
      
           } else { return '';}
        } else {return '';}
    }
   
    
}

function MiToken_generate(){
    $len = 16;
    $cadena_base =  'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
    $cadena_base .= '0123456789' ;
    // $cadena_base .= '!@#%^&*()_,./<>?;:[]{}\|=+';
   
    $password = '';
    $limite = strlen($cadena_base) - 1;
   
    for ($i=0; $i < $len; $i++)
      $password .= $cadena_base[rand(0, $limite)];
   
    return $password;
}



function MiToken_Close($usuario, $Token){
    require("rintera-config.php");
    
    $sql = "UPDATE tokens
        SET activo='1',
        cierre_fecha='".$fecha."',
        cierre_hora='".$hora."'
        WHERE
            user='$usuario' and token='$Token'";
    // echo $sql;
    
    if ($db0->query($sql) == TRUE)
    {
        return TRUE;
    }

    else 
    {
        return FALSE;
    }

}




function MiToken_CloseALL($usuario){
    require("rintera-config.php");
    
    $sql = "UPDATE tokens
        SET activo='1',
        cierre_fecha='".$fecha."',
        cierre_hora='".$hora."'
        
        WHERE
            user='$usuario'";
    // echo $sql;
    
    if ($db0->query($sql) == TRUE)
    {
        return TRUE;
    }

    else 
    {
        return FALSE;
    }

}

?>