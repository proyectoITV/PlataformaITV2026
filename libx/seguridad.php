<?php
require("config.php");
if ($session_auto_start == 0){
	session_name($SesionName);
	session_start();
}

if (isset($_SESSION['nitavu'])){
	// echo "Si hay session ".$_SESSION['RinteraUser'];
	session_regenerate_id();
	$nitavu = $_SESSION['nitavu'];
					
	
} else {

	if (isset($_GET['location'])){
        $location = $_GET['location'];
	} else {$location = "";}
	
	if ($location <> ''){
		echo '<script>window.location.replace("login.php?location='.$location.'")</script>'; 
	} else {
		echo '<script>window.location.replace("login.php")</script>'; 
	}
}

?>