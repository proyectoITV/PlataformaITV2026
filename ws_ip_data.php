<?php
require("src/config.php"); require("src/funciones.php"); 
// require("src/flor_funciones.php");

// error_reporting(E_ALL);
// ini_set('display_errors', '1');


$nitavu = $_POST['nitavu']; if (ValidaVAR($nitavu)==TRUE){$nitavu = LimpiarVAR($nitavu);} else {$nitavu = "";}
$token = $_POST['token']; if (ValidaVAR($token)==TRUE){$token = LimpiarVAR($token);} else {$token = "";}
$ip = $_POST['ip']; if (ValidaVAR($ip)==TRUE){$ip = LimpiarVAR($ip);} else {$ip = "";}


$sql = "INSERT INTO ips
		(nitavu, fecha, hora, ip_local, token, info)
		VALUES
		('".$nitavu."', '".$fecha."', '".$hora."', '".$ip."', '".$token."','".InfoEquipo()."')";
		if ($conexion->query($sql) == TRUE)
		{
			echo "TRUE";
			
		}
		else
		{
			echo "FALSE";
		}



        function InfoEquipo()
        {
            $browser=array("IE","OPERA","MOZILLA","NETSCAPE","FIREFOX","SAFARI","CHROME");
            $os=array("WIN","MAC","LINUX");
            # definimos unos valores por defecto para el navegador y el sistema operativo
            $info['browser'] = "OTHER";
            $info['os'] = "OTHER";
            # buscamos el navegador con su sistema operativo
            foreach($browser as $parent)
            {
            $s = strpos(strtoupper($_SERVER['HTTP_USER_AGENT']), $parent);
            $f = $s + strlen($parent);
            $version = substr($_SERVER['HTTP_USER_AGENT'], $f, 15);
            $version = preg_replace('/[^0-9,.]/','',$version);
            if ($s)
            {
            $info['browser'] = $parent;
            $info['version'] = $version;
            
            }
            }
            # obtenemos el sistema operativo
            foreach($os as $val)
            {
            if (strpos(strtoupper($_SERVER['HTTP_USER_AGENT']),$val)!==false)
            $info['os'] = $val;
            }
            # devolvemos el array de valores
            if (getenv('HTTP_CLIENT_IP')) {
                $ip = getenv('HTTP_CLIENT_IP');
              } elseif (getenv('HTTP_X_FORWARDED_FOR')) {
                $ip = getenv('HTTP_X_FORWARDED_FOR');
              } elseif (getenv('HTTP_X_FORWARDED')) {
                $ip = getenv('HTTP_X_FORWARDED');
              } elseif (getenv('HTTP_FORWARDED_FOR')) {
                $ip = getenv('HTTP_FORWARDED_FOR');
              } elseif (getenv('HTTP_FORWARDED')) {
                $ip = getenv('HTTP_FORWARDED');
              } else {
                // Método por defecto de obtener la IP del usuario
                // Si se utiliza un proxy, esto nos daría la IP del proxy
                // y no la IP real del usuario.
                $ip = $_SERVER['REMOTE_ADDR'];
              }
            //echo getenv('HTTP_CLIENT_IP');
            //echo getenv('HTTP_X_FORWADED_FOR');
            //echo getenv('REMOTE_ADDR');
            $infofull="";
            //$infofull = $infofull. "Usuario: ".gethostname()."<br>";
            $infofull = $infofull. "".$info['os'].",";
            $infofull = $infofull. "".$info['browser'].",";
            $infofull = $infofull. "".$info['version'].",";
            $infofull = $infofull. "".$_SERVER['HTTP_USER_AGENT']."<br>";
            
            $infofull = $infofull. "NET( ".getenv('HTTP_CLIENT_IP').",";
            $infofull = $infofull. "- ".getenv('HTTP_X_FORWADED_FOR').",";
            $infofull = $infofull. "- ".getenv('REMOTE_ADDR')." - ".$ip.")";
            
            
            
            
            return $infofull;
        }


?>