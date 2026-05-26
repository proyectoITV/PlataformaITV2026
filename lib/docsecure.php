<?php
//               _____                    _____                          
//               |  __ \                  / ____|                         
//               | |  | | ___   ___ _____| (___   ___  ___ _   _ _ __ ___ 
//               | |  | |/ _ \ / __|______\___ \ / _ \/ __| | | | '__/ _ \
//               | |__| | (_) | (__       ____) |  __/ (__| |_| | | |  __/
//               |_____/ \___/ \___|     |_____/ \___|\___|\__,_|_|  \___|
//
// Doc-Secure.php
//
// Por JJPedraza => github.com/prymecode      
//-----------------------------------------------------------------------------                                          


//Variables del FTP, donde almanenaras de manera segura tus archivos:
define("SFTP_SERVER", "192.168.159.15"); 
define("SFTP_PORT", 21); 
define("SFTP_USER", "desarrollo3");
define("SFTP_PASSWORD", "3LS4NT0*");
define("SFTP_DIR", "/home/usuario/public_html/"); 
define("STAG","docsecure/");

//BD de Control
define("DS_dbhost",'192.168.159.15');	
define("DS_dbuser",'wbproduction1');
define("DS_dbpass",'4Dm1NPr0');
define("DS_dbname",'itavu');

//Usuario de Control
// session_start();
if (isset($_SESSION['nitavu'])){
	define("IdUser",$_SESSION['nitavu']);
} else {
	define("IdUser","");
}




//Funciones Especificas:    
function DocSecure_upload_post($ArchivoOrigen, $Descripcion="", $Tag=""){	
	$IdUser = IdUser;
	if ($IdUser == ""){$IdUser = "system";}
	$Extensionando = explode(".", $_FILES[$ArchivoOrigen]['name'] ); $Extension = end($Extensionando);
	
	$Tag = str_replace(' ', '', $Tag);	
	$ArchivoDestino =  STAG."".date('Ymd').date("His").$IdUser."".$Tag."".StringGenerate("",6).".".$Extension;
	
	$ExtensionesPermitidas = array('jpg','pdf');
	if( ! in_array( $Extension, $ExtensionesPermitidas ) ) {
		return FALSE;
	} else {
	
		$id_ftp=SFTP_conectar(); 			
		if (ftp_put($id_ftp,$ArchivoDestino,$_FILES[$ArchivoOrigen]['tmp_name'],FTP_BINARY)){
	
			if (DocSecure_save($ArchivoDestino, $Extension, $IdUser, $Descripcion, $Tag,$_FILES[$ArchivoOrigen]['name'] ) == TRUE) {
				return TRUE;
			} else {
				return FALSE;
			}
	
			
			
		} else {
			return FALSE;
		}	
		ftp_quit($id_ftp);

	}
	

	
}

function DocSecure_upload($ArchivoOrigen, $Descripcion="", $Tag=""){	
	$IdUser = IdUser;
	// echo "IdUser=".IdUser;	
	
	// if ($IdUser == ""){$IdUser = "system";}
	$FileInfo = new SplFileInfo($ArchivoOrigen); $Extension = $FileInfo->getExtension();
	$Tag = str_replace(' ', '', $Tag);
	
	$ArchivoDestino =  STAG."".date('Ymd').date("His").$IdUser."".$Tag."".StringGenerate("",6).".".$Extension;

	$ExtensionesPermitidas = array('jpg','pdf', 'png');
	if( ! in_array( $Extension, $ExtensionesPermitidas ) ) {
		return FALSE;
	} else {
	
	
		$id_ftp=SFTP_conectar(); 	
		
		if (ftp_put($id_ftp,$ArchivoDestino,$ArchivoOrigen,FTP_BINARY))	{

	

			if (DocSecure_save($ArchivoDestino, $Extension,$Descripcion, $Tag,$ArchivoOrigen ) == TRUE) {
				return TRUE;
			} else {
				return FALSE;
			}


			
		} else {
			return FALSE;
		}

		
		ftp_quit($id_ftp);
	}
}


function DocSecure_save($FileName, $FileExtension, $Descripcion, $Tag, $ArchivoOrigen){
$IdUser = IdUser; $fecha = date('Y-m-d'); $hora =  date ("H:i:s");
if (function_exists('mysqli_connect')) {
    $dscon = new mysqli(DS_dbhost,DS_dbuser,DS_dbpass,DS_dbname); $acentos = $dscon->query("SET NAMES 'utf8'"); // para los acentos
	$IdDocSecure_Next = IdDocSecure_next();
    $sql = "
    INSERT INTO docsecure (IdDocSecure, FileName, FileExtension, Fecha, Hora, IdUser, Description,Tag,FileName_original, url, dispositivo)
    VALUES('".$IdDocSecure_Next."','".$FileName."', '".$FileExtension."', CURDATE(), CURTIME(),'".$IdUser."', 'x".$Descripcion."', '".$Tag."','".$ArchivoOrigen."','".URL_actual()."','".getInfoUser()."' )
    ";
	echo $sql;
    if ($dscon->query($sql) == TRUE)
    {   
		
        return $IdDocSecure_Next;
    }
    else {
        return FALSE;
    }




} else {
    // echo "ERROR: Hay un problema con la coneccion";
    return FALSE;
}
}


function DocSecure_History($IdDocSecure, $Referencia){
	$IdUser = IdUser; $fecha = date('Y-m-d'); $hora =  date ("H:i:s");
	if (function_exists('mysqli_connect')) {
		$dscon = new mysqli(DS_dbhost,DS_dbuser,DS_dbpass,DS_dbname); $acentos = $dscon->query("SET NAMES 'utf8'"); // para los acentos
		$IdDocSecure_Next = IdDocSecure_next();
		$Dispositivo = getInfoUser();
		$sql = "
		INSERT INTO docsecure_history (IdDocSecure, Fecha, Hora, url, referencia, dispositivo)
		VALUES('".$IdDocSecuret."',CURDATE(), CURTIME(),'".URL_actual()."', '".$Referencia."', '".$Dispositivo."')
		";
		if ($dscon->query($sql) == TRUE)
		{   
			return $IdDocSecure_Next;
		}
		else {
			return FALSE;
		}
	
	
	
	
	} else {
		// echo "ERROR: Hay un problema con la coneccion";
		return FALSE;
	}
	}

function IdDocSecure_next(){
	$sql = "SELECT	max(IdDocSecure) + 1 as IdDocSecure_Next from docsecure";
	$fecha = date('Y-m-d'); $hora =  date ("H:i:s");
	if (function_exists('mysqli_connect')) {
		$dscon = new mysqli(DS_dbhost,DS_dbuser,DS_dbpass,DS_dbname); $acentos = $dscon->query("SET NAMES 'utf8'"); // para los acentos
		$rc= $dscon -> query($sql); if($f = $rc -> fetch_array())
		{
			return $f['IdDocSecure_Next'];
		}
		else {
			return 0;
		}

	} else {
		return 0;
	}
}

function IdDocSecure_FileName($IdDocSecure){
	$sql = "SELECT	*  from docsecure where IdDocSecure='".$IdDocSecure."'";
	$fecha = date('Y-m-d'); $hora =  date ("H:i:s");
	if (function_exists('mysqli_connect')) {
		$dscon = new mysqli(DS_dbhost,DS_dbuser,DS_dbpass,DS_dbname); $acentos = $dscon->query("SET NAMES 'utf8'"); // para los acentos
		$rc= $dscon -> query($sql); if($f = $rc -> fetch_array())
		{
			return $f['FileName'];
		}
		else {
			return 0;
		}

	} else {
		return 0;
	}
}

function DocSecure_download($IdDocSecure, $Destino){
	// $IdUser = $_SESSION['nitavu'];
	$fecha = date('Y-m-d'); $hora =  date ("H:i:s");
	if (function_exists('mysqli_connect')) {
		$dscon = new mysqli(DS_dbhost,DS_dbuser,DS_dbpass,DS_dbname); $acentos = $dscon->query("SET NAMES 'utf8'"); // para los acentos
		
		$sql = "select * from docsecure where IdDocSecure ='".$IdDocSecure."'";
		$rc= $dscon -> query($sql); if($f = $rc -> fetch_array())
		{
			$Archivo = $f['FileName'];
			//Lo descargamos del FTP
			$id_ftp=SFTP_conectar();
			ftp_pasv($id_ftp, true);
			if (ftp_get($id_ftp, $Destino, $Archivo, FTP_BINARY)) {					
				DocSecure_History($IdDocSecure, $IdUser,"Descargo el archivo");	
				return TRUE;

			} else {
					return FALSE;
			}
			ftp_quit($id_ftp);

		}
		else {
			return FALSE;
		}
	
	
	
	} else {
		// echo "ERROR: Hay un problema con la coneccion";
		return FALSE;
	}
	}
	

//  Funciones asociadas:
function SFTP_conectar(){
    $id_ftp=ftp_connect(SFTP_SERVER,SFTP_PORT); //Obtiene un manejador del Servidor FTP
    //$id_ftp=ftp_ssl_connect(SFTP_SERVER,SFTP_PORT); //Obtiene un manejador del Servidor FTP
    ftp_login($id_ftp,SFTP_USER,SFTP_PASSWORD); //Se loguea al Servidor FTP
    ftp_pasv($id_ftp, TRUE); //Establece el modo de conexión
    return $id_ftp; //Devuelve el manejador a la función
}
    


function SFTP_isfile($archivo){
	$id_ftp=SFTP_conectar(); //Obtiene un manejador y se conecta al Servidor FTP
	$fileSize = ftp_size($id_ftp, FTP_ruta().$archivo);
	if ($fileSize != -1) {return "TRUE";} else {return "FALSE";}
}

function SFTP_descargar($archivo){
	$lista="";
	$id_ftp=SFTP_conectar(); //Obtiene un manejador y se conecta al Servidor FTP
	ftp_pasv($id_ftp, true);
	//echo $archivo;
	
	// intenta descargar $server_file y guardarlo en $local_file
	if (ftp_get($id_ftp, "tmp/".$archivo, "".$archivo, FTP_BINARY)) {
    		//return "Se ha guardado satisfactoriamente en $archivo\n";
			return "TRUE";
	} else {
		    return "FALSE";
	}

	 
}

function SFTP_descargar_doc($archivo){
	$lista="";
	$id_ftp=SFTP_conectar();
	ftp_pasv($id_ftp, true);
	if (ftp_get($id_ftp, "tmp/".$archivo, "".$archivo, FTP_BINARY)) {
    		//return "Se ha guardado satisfactoriamente en $archivo\n";
			return "TRUE";
	} else {
		    return "FALSE";
	}

	 
}

function ftp_mode($file)
{    
    $path_parts = pathinfo($file);
    
    if (!isset($path_parts['extension'])) return FTP_BINARY;
    switch (strtolower($path_parts['extension'])) {
        case 'am':case 'asp':case 'bat':case 'c':case 'cfm':case 'cgi':case 'conf':
        case 'cpp':case 'css':case 'dhtml':case 'diz':case 'h':case 'hpp':case 'htm':
        case 'html':case 'in':case 'inc':case 'js':case 'm4':case 'mak':case 'nfs':
        case 'nsi':case 'pas':case 'patch':case 'php':case 'php3':case 'php4':case 'php5':
        case 'phtml':case 'pl':case 'po':case 'py':case 'qmail':case 'sh':case 'shtml':
        case 'sql':case 'tcl':case 'tpl':case 'txt':case 'vbs':case 'xml':case 'xrc':
            return FTP_ASCII;
    }
    return FTP_BINARY;
}

function SFTP_lista(){
	$lista="";
	$id_ftp=SFTP_conectar(); //Obtiene un manejador y se conecta al Servidor FTP
	$files = ftp_nlist($id_ftp, '.');
	foreach ($files as $file) {

	$lista = $lista.FTP_ruta().$file . "<br>";
	}
	return $lista;
}

function SFTP_leer($archivo_nombre){
$ftp_url="ftp://".SFTP_USER.":".SFTP_PASSWORD."@".SFTP_SERVER.SFTP_DIR.$archivo_nombre;
//ftp://desarrollo2:jpedraza@ftp.172.16.90.3/home/desarrollo2/public_html/tam.png

echo $ftp_url;
$archivo = fopen ($ftp_url, "r");
if (!$archivo) {
		return "ERROR";
		
}else {return $archivo;}

}



function SFTP_subir_post($archivo_local,$archivo_remoto){
//if (isset($_FILES[$archivo_local])){	
	//Sube archivo de la maquina Cliente al Servidor (Comando PUT)
	$id_ftp=SFTP_conectar(); //Obtiene un manejador y se conecta al Servidor FTP

	if (ftp_put($id_ftp,FTP_ruta().$archivo_remoto,$_FILES[$archivo_local]['tmp_name'],FTP_BINARY)){
		return "TRUE";} else {return "FALSE";}
	//Sube un archivo al Servidor FTP en modo Binario
	ftp_quit($id_ftp); //Cierra la conexion FTP
//} else {return "FALSE";}
}

function SFTP_subir($archivo_local,$archivo_remoto){
	//Sube archivo de la maquina Cliente al Servidor (Comando PUT)
	$id_ftp=SFTP_conectar(); //Obtiene un manejador y se conecta al Servidor FTP
	//echo "REMOTO:".$id_ftp,FTP_ruta().$archivo_remoto."\n";
	//echo  "LOCAL:".$archivo_local;
	if (ftp_put($id_ftp,SFTP_ruta().$archivo_remoto,$archivo_local,FTP_BINARY)){
		return "TRUE";} else {return "FALSE";}
	//Sube un archivo al Servidor FTP en modo Binario
	ftp_quit($id_ftp); //Cierra la conexion FTP
}

function SFTP_ruta(){
	//Obriene ruta del directorio del Servidor FTP (Comando PWD)
	$id_ftp=SFTP_conectar(); //Obtiene un manejador y se conecta al Servidor FTP
	$Directorio=ftp_pwd($id_ftp); //Devuelve ruta actual p.e. "/home/willy"
	ftp_quit($id_ftp); //Cierra la conexion FTP
return $Directorio."/"; //Devuelve la ruta a la función
}


function StringGenerate($LoPrimero="",$Lon=16){
    $permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    return $LoPrimero.''.substr(str_shuffle($permitted_chars), 0, $Lon).'';
}

function URL_actual(){
	if(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') {
	  $url = "https://"; 
	}else{
	  $url = "http://"; 
	}
	return $url . $_SERVER['HTTP_HOST'] .  $_SERVER['REQUEST_URI'];
}

function URL_uri(){
	if(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') {
	  $url = "https://"; 
	}else{
	  $url = "http://"; 
	}
	return $_SERVER['REQUEST_URI'];
}

function getInfoUser(){
	return getPlatform()." ".getIP()."";
}
function getIP() {

    foreach ( [ 'HTTP_CLIENT_IP', 'HTTP_X_FORWARDED_FOR', 'HTTP_X_FORWARDED', 'HTTP_X_CLUSTER_CLIENT_IP', 'HTTP_FORWARDED_FOR', 'HTTP_FORWARDED', 'REMOTE_ADDR' ] as $key ) {

        // Comprobamos si existe la clave solicitada en el array de la variable $_SERVER 
        if ( array_key_exists( $key, $_SERVER ) ) {

            // Eliminamos los espacios blancos del inicio y final para cada clave que existe en la variable $_SERVER 
            foreach ( array_map( 'trim', explode( ',', $_SERVER[ $key ] ) ) as $ip ) {

                // Filtramos* la variable y retorna el primero que pase el filtro
                if ( filter_var( $ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE ) !== false ) {
                    return $ip;
                }
            }
        }
    }

    return ''; // Retornamos '?' si no hay ninguna IP o no pase el filtro
} 




function getPlatform() {
	$user_agent = $_SERVER['HTTP_USER_AGENT'];
   $plataformas = array(
      'Windows 10' => 'Windows NT 10.0+',
      'Windows 8.1' => 'Windows NT 6.3+',
      'Windows 8' => 'Windows NT 6.2+',
      'Windows 7' => 'Windows NT 6.1+',
      'Windows Vista' => 'Windows NT 6.0+',
      'Windows XP' => 'Windows NT 5.1+',
      'Windows 2003' => 'Windows NT 5.2+',
      'Windows' => 'Windows otros',
      'iPhone' => 'iPhone',
      'iPad' => 'iPad',
      'Mac OS X' => '(Mac OS X+)|(CFNetwork+)',
      'Mac otros' => 'Macintosh',
      'Android' => 'Android',
      'BlackBerry' => 'BlackBerry',
      'Linux' => 'Linux',
   );
   foreach($plataformas as $plataforma=>$pattern){
      if (preg_match('/(?i)'.$pattern.'/', $user_agent))
         return $plataforma;
   }
   return 'Otras';
}

?>