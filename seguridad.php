<?php
// error_reporting(E_ALL);
//--
//session_start();
//require("config.php");
//--
if (session_status() == PHP_SESSION_NONE) {
    $isHttps = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') || 
               (isset($_SERVER['SERVER_PORT']) && $_SERVER['SERVER_PORT'] == 443) ||
               (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] === 'https');

    session_set_cookie_params([
        'lifetime' => 0,
        'path'     => '/',
        'domain'   => '',
        'secure'   => $isHttps,
        'httponly' => true,
        'samesite' => 'Lax'
    ]);

    session_start();
}
//session_start();
require("config.php");
ob_start();

// if ($session_auto_start == 0){
	
// 	session_name($SesionName);
	
// }




if (isset($_SESSION['nitavu'])){
	// echo "Si hay session ".$_SESSION['RinteraUser'];
	// session_regenerate_id(); // Evita desincronización de sesión en subpeticiones del visor PDF
	$nitavu = $_SESSION['nitavu'];
					
	$MyIp = '';
} 
else {

	if (isset($_GET['location'])){
        $location = $_GET['location'];
	} else {$location = "";}
	
	
	if ($location <> ''){
		echo '<script>window.location.replace("login.php?location='.$location.'")</script>'; 
	} else {
		echo '<script>window.location.replace("login.php?nos=")</script>'; 
	}

}

?>