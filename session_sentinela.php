<?php
//AUTORIZACION PARA ADMINISTRADOR
// ini_set("session.cookie_lifetime","7200");
// ini_set("session.gc_maxlifetime","7200");
session_start();	
if (isset($_SESSION['nitavu'])){
		$nitavu = $_SESSION['nitavu'];
        
        
        require("config.php");  require("lib/funciones.php")
		$sql = "SELECT * FROM empleados WHERE nitavu='".$nitavu."'";
		$rc= $conexion -> query($sql);if($f = $rc -> fetch_array())
		{
			if ($f['estado']<>'') {// si el campo edo, tiene algo expulsar
				historia($_SESSION['nitavu'], "Se expulso de la plataforma, debio al cambio de estado laboral ".$f['estado'].") ".detectar());			
				session_destroy();
				$nitavu="";
				header("location:logout.php");		
			}else {
				//header("location:index.php");		
			}

		}
		
}
else
{	
	// include("test_session_logout.php");
	$_SESSION = array(); session_destroy();		
    echo "Sesion destruida, Loguearse!";
	// header("location:login.php");		
	
}
?>