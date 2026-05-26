<?php

	// === MANTENIMIENTO PROGRAMADO ===
	// Fecha de inicio: 28 de abril 2026 a las 00:00:00
	// Duración: 24 horas
	$mantenimiento_inicio = strtotime('2026-04-28 00:00:00');
	$mantenimiento_fin    = strtotime('2026-04-29 00:00:00'); // 24 horas después
	$ahora = time();

	// Se activa solo si la hora actual está dentro del rango
	$ModoMantenimiento = ($ahora >= $mantenimiento_inicio && $ahora < $mantenimiento_fin);


	//PARAMETROS INICIALES
	$pyme_name ="INSTITUTO TAMAULIPECO DE VIVIENDA Y URBANISMO";
	$pyme_text="ITAVU";
	$pyme_tels="(834) 3185506";
	$pyme_tels2 = "EXT.: 46506";
	$pyme_email="";
	$pyme_direccion="CALLE PINO SUÁREZ 2210 NTE. COLONIA DR. NORBERTO TREVIÑO ZAPATA";
	$pyme_direccion2="CIUDAD VICTORIA, TAMAULIPAS, MÉXICO, C.P. 87020";
	$pyme_colonia="DR. NORBERTO TREVIÑO ZAPATA";
	$pyme_domicilio="CALLE PINO SUÁREZ 2210 NTE";
	$pyme_cp = "87020";
	$pyme_ciudad = "CIUDAD VICTORIA";
	$versiondeplataforma ="1.4";
	global $pyme_name, $pyme_direction, $pyme_tels;
	$paginacion= 20;

	//configuraciones del sistema
	date_default_timezone_set('Mexico/General');
	$urlsite = 'https://plataformaitavu.tamaulipas.gob.mx'; global $urlsite;
	$produccion=FALSE; 
	global $produccion; // vpn

	//Credenciales para la base de datos de Plataforma
	$dbhost = '192.168.159.15';
	$dbuser = 'root';
	$dbpass = '3L54NT0**'; 
	$dbname = 'produccion_itavu';

	if (function_exists('mysqli_connect')) {
		$conexion = new mysqli($dbhost,$dbuser,$dbpass,$dbname);
		$acentos = $conexion->query("SET NAMES 'utf8'"); // para los acentos
		global $conexion;
		}else{
			mensaje("ERROR: Hay un problema con la coneccion",'');
		}

	//Credenciales para la base de datos de Vivienda
	$Vdbhost = $dbhost;	
	$Vdbuser = $dbuser;	
	$Vdbpass = $dbpass; 
	$Vdbname = 'produccion_vivienda';

	if (function_exists('mysqli_connect')) {
			$Vivienda = new mysqli($Vdbhost,$Vdbuser,$Vdbpass,$Vdbname);
			$acentos = $Vivienda->query("SET NAMES 'utf8'"); // para los acentos
			global $Vivienda;
	}else{ mensaje("ERROR: Hay un problema con la coneccion a BD vivienda",'');}

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
	

	//----------API KEY DE SERVICIOS GOOGLE CLOUD PLATAFORM---------
	$ServiciosGoogle = FALSE;  
	$key_geo="";
	$key_map_static="";
	$key_mapkmz = "";
	$key_directions = "";
	$key_map = "";
	//----------------------------------------------------------------

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
		
		$SessionTiempo = "60:00";
		$SessionTiempoRound = 6000;
		$AccessIP = FALSE; // si esta en TRUE no deja entrar si no es detectada una IP por el navegador, no deja entrar si no se detecta una ip
		$AdmisionIP = FALSE; // si esta en TRUE no deja entrar si no esta en una lista de IP del instituto (solo los titulares podran acceder desde cualquier IP)

		ini_set('max_execution_time', 0);
		
		if (date("l") == "Sunday"){$Domingo=TRUE;} else {$Domingo=FALSE;}

		$URLwebserviceVivienda = "http://192.168.159.179";
		$URLplataforma = "http://192.168.159.5";
		
		$CorreoDeLaPlataforma = "plataforma.itavu@gmail.com";
		$CorreoPass="Testing22";
		
		$CURP_limite = 9000;
		$session_auto_start =0;
		$SesionName="PlataformaITAVU";

		$CorreoFooter='
		<br><br>
		<hr><p style=color:gray; font-family:Verdana, Geneva, sans-serif; font-size:10pt;> 
			Este correo electronico es enviado de manera automatizada mediante la Plataforma Informatica de ITAVU.<br>	
			
			Cualquier duda, estamos a tus ordenes en el Dpto de Informática:
			Tel. 318-5516 Ext.: <b>46612</b>, <b>46524</b>, <b>46580</b>,  <b>46530</b>, <b>46516</b> y <b>46543</b>
		</p>

		';

	$PasswordCrypted = FALSE; //Usa la Colmuna hash en vez le nip
	$ModoProduccion = TRUE; ///Ponerlo en FALSE, para que no guarde Historial de test

?>