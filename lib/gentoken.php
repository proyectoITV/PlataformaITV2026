<?php


// PreToken = PreToken & "|" & My.User.Name
// PreToken = PreToken & "|" & Generator.Next(0, 1000)
// PreToken = PreToken & "|" & red
// PreToken = PreToken & "|" & My.Computer.Info.OSFullName & " - " & My.Computer.Info.OSPlatform & " Ver. " & My.Computer.Info.OSVersion
// PreToken = PreToken & "|" & My.Computer.Name
// PreToken = PreToken & "|" & Equipo
// PreToken = PreToken & "|" & My.Application.Info.Version.ToString
// PreToken = PreToken & "|" & Generator.Next(0, 1000)

// 'date('Y-m-d')

// PreToken = PreToken & "|" & Today.Day.ToString
// PreToken = PreToken & "|" & Today.Date


function GenToken_($TokenInput){
    $Token =  base64_decode($TokenInput);
    list($User, $Bloque1, $Red, $SO, $Computer, $Equipo, $TokenVersion, $Bloque2, $Dia, $Fecha) = explode("|",$Token);
    $User = str_replace("\\", "/", $User);
    // //Validar la Version del Token
    // $VersionDelToken_Esperada = Preference("TokenVersion","","");
    // if ($VersionDelToken == $VersionDelToken_Esperada){

    // } else {
    //     return "Version del Token Desactualizada, Actualice por favor La Aplicacion de GenToken en su computadora";
    // }

    
    return $Token;
}

function GenToken_Check($TokenInput){
    if (GenToken_CheckFecha($TokenInput) == TRUE){
        if (GenToken_CheckVersion($TokenInput) == TRUE){
            if (GenToken_CheckEquipo($TokenInput) == TRUE){
                return TRUE;
            } else {
                return FALSE;
            }
            
        } else {
            return FALSE;
        }
    } else {
        return FALSE;
    }

}

function GenToken_CheckVersion($TokenInput){
    $Token =  base64_decode($TokenInput);
    list($Bloque0, $User, $Bloque1, $Red, $SO, $Computer, $Equipo, $TokenVersion, $Bloque2, $Dia, $Fecha) = explode("|",$Token);
    $User = str_replace("\\", "/", $User);
    // //Validar la Version del Token
    $VersionDelToken_Esperada = Preference("VersionToken","","");
    if ($TokenVersion == $VersionDelToken_Esperada){
        return TRUE;
    } else {        
        Toast("Version del Token Desactualizada (".$TokenVersion."), Actualice por favor La Aplicacion de GenToken en su computadora (".$VersionDelToken_Esperada.")",2,"");
        return FALSE;
    }
}


function GenToken_CheckFecha($TokenInput){
    // Token=|DESKTOP-SQQTDSR\ITV-OC-246|40|fe80::545d:d63d:cc58:b542%4, 192.168.159.179, |Microsoft Windows 10 Pro - Win32NT Ver. 6.2.9200.0|DESKTOP-SQQTDSR|DESKTOP-SQQTDSR|1.0.3.0|878|17|17/09/2021
// Fecha = 17
// Fecha Del Token = 1969-12-31
    $Token =  base64_decode($TokenInput);
    echo $Token;
    list($Bloque0, $User, $Bloque1, $Red, $SO, $Computer, $Equipo, $TokenVersion, $Bloque2, $Dia, $Fecha) = explode("|",$Token);

    $User = str_replace("\\", "/", $User);
    $Hoy = date('d/m/Y');
    if ($Fecha == $Hoy){
        return TRUE;
    } else {
        Toast("Token Caducado Fecha=".$Fecha."".$Token,2,"");
        return FALSE;
      
    }
    // echo "Token=".$Token."<br>";
    // echo "<br>Fecha = ".$Fecha."<br>";
    // $FechaDelToken = date("Y-m-d", strtotime($Fecha));

    // echo "Fecha Del Token = ".$FechaDelToken."<br>";
    // echo "Hoy = ".$Hoy."";
    
}


function GenToken_UserName($TokenInput){
    $Token =  base64_decode($TokenInput);
    list($Bloque0, $User, $Bloque1, $Red, $SO, $Computer, $Equipo, $TokenVersion, $Bloque2, $Dia, $Fecha) = explode("|",$Token);
    $User = str_replace("\\", "/", $User);
    // //Validar la Version del Token
    $VersionDelToken_Esperada = Preference("VersionToken","","");
    return $User;
}


function GenToken_EquipoSave($TokenInput, $idapp){
    require("config.php");
    // require_once("seguridad.php");
    // session_start();
    $nitavu = $_SESSION['nitavu'];
    $IdEquipo = NIdEquipo(FALSE);
    // Token=|DESKTOP-SQQTDSR\ITV-OC-246|40|fe80::545d:d63d:cc58:b542%4, 192.168.159.179, |Microsoft Windows 10 Pro - Win32NT Ver. 6.2.9200.0|DESKTOP-SQQTDSR|DESKTOP-SQQTDSR|1.0.3.0|878|17|17/09/2021
// Fecha = 17
// Fecha Del Token = 1969-12-31
    $Token =  base64_decode($TokenInput);
    list($Bloque0, $User, $Bloque1, $Red, $SO, $Computer, $Equipo, $TokenVersion, $Bloque2, $Dia, $Fecha) = explode("|",$Token);
    $User = str_replace("\\", "/", $User);
    $sqlInsert = "
    INSERT INTO usuarios_de_red
        (UserName, NEmpleado, Estatus, act_user, act_fecha, act_hora, Red, Computer, SO, act_idapp, TokenInput,URL, IdEquipo)
    VALUES
        ('".$User."','".$nitavu."','0','".$nitavu."','".$fecha."','".$hora."','".$Red."','".$Computer."','".$SO."','".$idapp."','".$TokenInput."','".URLActual()."','".$IdEquipo."');                            
    ";

    
    if ($conexion->query($sqlInsert) == TRUE)   {
        return TRUE;
    } else {
        return FALSE;

    }
    
}


function GenToken_Save($TokenInput){
    require("config.php");
    // require_once("seguridad.php");
    // session_start();
    $nitavu = $_SESSION['nitavu'];
    // Token=|DESKTOP-SQQTDSR\ITV-OC-246|40|fe80::545d:d63d:cc58:b542%4, 192.168.159.179, |Microsoft Windows 10 Pro - Win32NT Ver. 6.2.9200.0|DESKTOP-SQQTDSR|DESKTOP-SQQTDSR|1.0.3.0|878|17|17/09/2021
// Fecha = 17
// Fecha Del Token = 1969-12-31
    $Token =  base64_decode($TokenInput);
    list($Bloque0, $User, $Bloque1, $Red, $SO, $Computer, $Equipo, $TokenVersion, $Bloque2, $Dia, $Fecha) = explode("|",$Token);
    $User = str_replace("\\", "/", $User);
    $sqlInsert = "
    INSERT INTO gentoken
        (TokenInput, fecha, hora, IdEmpleado, URL)
    VALUES
        (
            '".$TokenInput."',
            '".$fecha."',
            '".$hora."',
            '".$nitavu."',
            '".URLActual()."'
        )
    ";

    // echo $sqlInsert;
    if ($conexion->query($sqlInsert) == TRUE)   {
        return TRUE;
    } else {
        return FALSE;

    }
    
}

function GenToken_CheckEquipo($TokenInput){
    $Token =  base64_decode($TokenInput);
    list($Bloque0, $User, $Bloque1, $Red, $SO, $Computer, $Equipo, $TokenVersion, $Bloque2, $Dia, $Fecha) = explode("|",$Token);    
    $User = str_replace("\\", "/", $User);
    require("config.php");
    $sql = "SELECT * FROM usuarios_de_red WHERE UserName='".$User."' and Red='".$Red."' and Estatus='1'" ;
	$rc= $conexion -> query($sql);	
	if($f = $rc -> fetch_array())
	{
        return TRUE;
    }
	else
	{ 
        Toast("Equipo no Autorizado; favor de comunicarse con el Dpto. de Informatica",2,"");
        return FALSE;
    }
}

function GenToken_CheckEquipoEstatus($IdEquipo){
    // $Token =  base64_decode($TokenInput);
    // // list($Bloque0, $User, $Bloque1, $Red, $SO, $Computer, $Equipo, $TokenVersion, $Bloque2, $Dia, $Fecha) = explode("|",$Token);    
    // $User = str_replace("\\", "/", $User);
    require("config.php");
    $sql = "SELECT * FROM usuarios_de_red WHERE IdEquipo='".$IdEquipo."'";
	$rc= $conexion -> query($sql);	
	if($f = $rc -> fetch_array())
	{
        return $f['Estatus'];
    }
	else
	{ 
        // Toast("Equipo no Autorizado; favor de comunicarse con el Dpto. de Soporte Tecnico",2,"");
        return "";
    }
}


function url_origin($s, $use_forwarded_host=false) {

    $ssl = ( ! empty($s['HTTPS']) && $s['HTTPS'] == 'on' ) ? true:false;
    $sp = strtolower( $s['SERVER_PROTOCOL'] );
    $protocol = substr( $sp, 0, strpos( $sp, '/'  )) . ( ( $ssl ) ? 's' : '' );
  
    $port = $s['SERVER_PORT'];
    $port = ( ( ! $ssl && $port == '80' ) || ( $ssl && $port=='443' ) ) ? '' : ':' . $port;
    
    $host = ( $use_forwarded_host && isset( $s['HTTP_X_FORWARDED_HOST'] ) ) ? $s['HTTP_X_FORWARDED_HOST'] : ( isset( $s['HTTP_HOST'] ) ? $s['HTTP_HOST'] : null );
    $host = isset( $host ) ? $host : $s['SERVER_NAME'] . $port;
  
    return $protocol . '://' . $host;
  
  }
  
  function full_url( $s, $use_forwarded_host=false ) {
    return url_origin( $s, $use_forwarded_host ) . $s['REQUEST_URI'];
  }
  
  function URLActual(){
      
    $absolute_url = full_url( $_SERVER );
    return $absolute_url;
}

function NIdEquipo($consulta){
	require("config.php");
	$sql = "SELECT * FROM contadores WHERE id='0'";
	$rc= $conexion -> query($sql);
	if($f = $rc -> fetch_array())
					{
		if ($consulta==TRUE) {
						return $f['IdEquipo'];
		}
		else
		{ // sino es consulta entonces aumentarle y aumentar el contador de ceropapel
		// la diferencia entre ceropapel y este, es que cero papel se multiplica
		// por las copias que se entregan o con copia, para estadistica de cuanto se ha ahorrado
		$docdigital = $f['IdViatico'];
		$docdigitalnew = $docdigital + 1;
		
		
		$sql="UPDATE contadores SET IdEquipo='".$docdigitalnew."'  WHERE id='0'";
		$resultado = $conexion -> query($sql);
		if ($conexion->query($sql) == TRUE) {
			return $f['IdEquipo'];
		}
		else {return  FALSE;}
					}
	}
	else
	{ return FALSE;}
}



function GenToken_EquipoActivar($IdEquipo){
    require("config.php");
    // require_once("seguridad.php");
    // session_start();
    $nitavu = $_SESSION['nitavu'];
    // $IdEquipo = NIdEquipo(FALSE);
    // Token=|DESKTOP-SQQTDSR\ITV-OC-246|40|fe80::545d:d63d:cc58:b542%4, 192.168.159.179, |Microsoft Windows 10 Pro - Win32NT Ver. 6.2.9200.0|DESKTOP-SQQTDSR|DESKTOP-SQQTDSR|1.0.3.0|878|17|17/09/2021
// Fecha = 17
// Fecha Del Token = 1969-12-31
    // $Token =  base64_decode($TokenInput);
    // list($Bloque0, $User, $Bloque1, $Red, $SO, $Computer, $Equipo, $TokenVersion, $Bloque2, $Dia, $Fecha) = explode("|",$Token);
    // $User = str_replace("\\", "/", $User);
    $sqlInsert = "
   UPDATE usuarios_de_red SET Estatus='1'
        WHERE IdEquipo='".$IdEquipo."'
    ";

    
    if ($conexion->query($sqlInsert) == TRUE)   {
        historia($nitavu, "[gentoken] Autorizo el Equipo con Id: ".$IdEquipo);
        return TRUE;
    } else {
        return FALSE;

    }
    
}


function GenToken_EquipoDesactivar($IdEquipo){
    require("config.php");
    // require_once("seguridad.php");
    // session_start();
    $nitavu = $_SESSION['nitavu'];
    // $IdEquipo = NIdEquipo(FALSE);
    // Token=|DESKTOP-SQQTDSR\ITV-OC-246|40|fe80::545d:d63d:cc58:b542%4, 192.168.159.179, |Microsoft Windows 10 Pro - Win32NT Ver. 6.2.9200.0|DESKTOP-SQQTDSR|DESKTOP-SQQTDSR|1.0.3.0|878|17|17/09/2021
// Fecha = 17
// Fecha Del Token = 1969-12-31
    // $Token =  base64_decode($TokenInput);
    // list($Bloque0, $User, $Bloque1, $Red, $SO, $Computer, $Equipo, $TokenVersion, $Bloque2, $Dia, $Fecha) = explode("|",$Token);
    // $User = str_replace("\\", "/", $User);
    $sqlInsert = "
   UPDATE usuarios_de_red SET Estatus='0'
        WHERE IdEquipo='".$IdEquipo."'
    ";

    
    if ($conexion->query($sqlInsert) == TRUE)   {
        historia($nitavu, "[gentoken] Desactivo el Equipo con Id: ".$IdEquipo);
        return TRUE;
    } else {
        return FALSE;

    }
    
}
?>