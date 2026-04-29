<?php
// error_reporting(E_ALL);
//--
//session_start();
//require("config.php");
//--
if (session_status() == PHP_SESSION_NONE) {
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
	session_regenerate_id();
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