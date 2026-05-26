<?php


//            .-::///////:`                           
//     .:+shhhhhhhhhhhhhh+                           
//  -+yhhyshhhhhs/-```.`                             
// -so/. `yhhh/`          -sss-                      
//      .yhho--:://::.   -hhhh`.`                    
//     `yhho:/:.``.:-.  .hhyhohhh-     `.         .` 
//     ohh//:`   -//.  .hh+:+yhhho  -+yhhs      -sh- 
//    .hh+//.  `://:  `yo/:- +hhhy/yhyhhho   -+yh/`  
//    /hh///:-:/://:-.////.  -hhhhho..hhho+shhs:     
//    shy .:::-` `-::/+ss`    ohho.  +hhhhs+:`       
//    sh+             .-       .`     --`            
//    oh:                                            
//     .  .....

//PARAMETROS INICIALES
$pyme_name ="INSTITUTO TAMAULIPECO DE VIVIENDA Y URBANISMO";
$pyme_text="ITAVU";
$pyme_tels="(834) 3185506";
$pyme_tels2 = "EXT.: 46506";
$pyme_email="";
$pyme_direccion="CALLE PINO SUÁREZ 2210 NTE. COLONIA DR. NORBERTO TREVIÑO ZAPATA";
$pyme_direccion2="CIUDAD VICTORIA, TAMAULIPAS, MÉXICO, C.P. 87020";
$pyme_cp = "87020";
$versiondeplataforma ="1.4";
global $pyme_name, $pyme_direction, $pyme_tels;
$paginacion= 20;
//configuraciones del sistema
	date_default_timezone_set('Mexico/General');
	if (function_exists('mb_internal_encoding')) { mb_internal_encoding('UTF-8'); }
	if (function_exists('mb_http_output')) { mb_http_output('UTF-8'); }
	if (function_exists('mysqli_report')) { mysqli_report(MYSQLI_REPORT_OFF); }
	//--$urlsite = 'https://plataformaitavu.tamaulipas.gob.mx'; global $urlsite;
	//$urlsite = 'http://172.16.91.131/itavu/'; global $urlsite;
	$produccion=FALSE; global $produccion; // vpn


	//produccion --> kno
	$dbhost = '192.168.159.15';	
	$dbuser = 'root';
	$dbpass = '3L54NT0**'; 
	$dbname = 'itavu';

	//test
	// $dbhost = '172.16.91.5';	
	// $dbuser = 'userBeta';
	// $dbpass = 'BDb3t4'; 
	// $dbname = 'itavu_test';

	
	// //test
	// $dbhost = '172.16.91.5';	
	// $dbuser = 'root';
	// $dbpass = '3LS4NT0**';
	// $dbname = 'itavu_TestFire';


	if (function_exists('mysqli_connect')) {
	//mysqli está instalado
		$conexion = @new mysqli($dbhost,$dbuser,$dbpass,$dbname);
		if ($conexion && !$conexion->connect_errno) {
			$conexion->set_charset('utf8');
			global $conexion;
		} else {
			http_response_code(503);
			die("<h3 style='font-family:Arial;'>Error de conexion a base de datos principal.</h3>");
		}
		}else{
			http_response_code(500);
			die("<h3 style='font-family:Arial;'>La extension MySQLi no esta habilitada.</h3>");


			// echo phpinfo();
			// echo "<h1 style='background-color:red;color:white;'>Hay un error al conectar con la base de datos (MySQLi)".var_dump(function_exists('mysqli_connect'))."</h1>";
		}



	//USUARIO PARA BD VIVIENDA
	$Vdbhost = '192.168.159.15';	
	$Vdbuser = 'root';
	$Vdbpass = '3L54NT0**'; 
	$Vdbname = 'produccion_vivienda';
	if (function_exists('mysqli_connect')) {
			$Vivienda = @new mysqli($Vdbhost,$Vdbuser,$Vdbpass,$Vdbname);
			if ($Vivienda && !$Vivienda->connect_errno) {
				$Vivienda->set_charset('utf8');
				global $Vivienda;
			} else {
				$Vivienda = null;
			}
	}else{
		$Vivienda = null;
	}







	// $conexion_central = new mysqli($central_dbhost,$central_dbuser,$central_dbpass,$central_dbname);
	// $acentos = $conexion_central->query("SET NAMES 'utf8'"); // para los acentos
	// global $conexion_central;
	// $conexionmigra = new mysqli($itop_dbhost,$itop_dbuser,$itop_dbpass,$itop_dbname);
	// $acentos = $conexionmigra->query("SET NAMES 'utf8'"); // para los acentos
	// global $conexionmigra;
//PARAMETROS DE PREFERENCIA
	$req_rezagoMax = 30;
 	$moneda = 'MXN';
 	$moneda_sufijo ='MXN';
 	global $moneda, $moneda_sufijo;
 	$fecha = date('Y-m-d');
	$hora =  date ("H:i:s");
	$tolerancia = "00:10:00";
	global $fecha, $hora, $tolerancia;
	$API_geo = TRUE; // usar Georeferencia
	$API_msg = TRUE; // usar api de notificacines
	$EXIGIR_geo_ini = FALSE; // no se puede accesar a la plataforma sino se aceptan los permisos de geo
	$EXIGIR_geo_mod = TRUE; // no se puede utilizar modulos con geo sino se aceptan los permisos de geo
	
//KEYS GOOGLE
	$key_geo="AIzaSyDFrRZEYqnAuGMggPnDdD2qEm-bOpDdoNA";
	$key_map_static="AIzaSyCc2fdtBRrEiHBG4mEAIrFZ6kUrFbw3VL8";
	$completar1_fecha = "2017-08-03";
// CONFIGURACION DEL CORREO
	$correo_limite=1500; global $correo_limite;
// SERVIDOR PARA DATOS SENSIBLES
	$app_reso = "<p>
		
		</p>
		<p>
		 Al ser usuario del sistema se le hacen las siguientes recomendaciones y aclaraciones:
		<lu>
		<li>El acceso y contraseña que le será otorgado son exclusivos para su uso personal. <li>
		<li> No deberá proporcionar estos datos a ninguna otra persona.</li>
		<li> En caso de uso indebido del sistema, usted responderá a los movimientos realizados con su usuario, ya
		que se registran sus datos durante la operación del mismo.</li>
		<li>Cada vez que deje de utilizar el sistema se recomienda asegurarse cerrar su sesión, ya que en caso de
		dejarla abierta, cualquier persona podrá hacer uso de él con su cuenta.</li>
		<lu>
		</p>";
		global $app_reso;
		$CorreoPass="plataforma";
		
		$SessionTiempo = "60:00";
		$SessionTiempoRound = 6000;
		$AccessIP = FALSE; // si esta en TRUE no deja entrar si no es detectada una IP por el navegador, no deja entrar si no se detecta una ip
		$AdmisionIP = FALSE; // si esta en TRUE no deja entrar si no esta en una lista de IP del instituto (solo los titulares podran acceder desde cualquier IP)

		ini_set('max_execution_time', 0);
		
		if (date("l") == "Sunday"){$Domingo=TRUE;} else {$Domingo=FALSE;}


		$URLwebserviceVivienda = "http://172.16.91.3";
		$CURP_limite = 500;

		
$PasswordCrypted = FALSE; //Usa la Colmuna hast en vez le nip
?>
