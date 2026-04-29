<?php require("seguridad.php");?>
</!DOCTYPE html>
<html>
	<head>
		<title>Plataforma ITAVU</title>
		<?php		
			// echo "<title>ITAVU | ".$nitavu." | ".nitavu_nombre($nitavu)." | Plataforma</title>";
		?>
		
		<?php
		if (isset($_GET['r'])) { // si esta la var get R refrescar
			$r = $_GET['r'];
			echo '<meta http-equiv="refresh" content="'.$r.'" />';		
		}
		
		
		?>		
		<meta charset="utf-8" />		
		<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=yes">
		<meta name="description" content="Bienvenido la Plataforma de Sistemas de ITAVU Tamaulipas">
		<meta name="keywords" content="Gobierno de Tamaulipas, Gobierno, Tamaulipas, Gobernador García Cabeza de Vaca, Cabeza de Vaca, Tamps, Tam, ">
		<meta name="robots" content="index,follow">
		<meta name="googlebot" content="index,follow">
		<meta name="geo.region" content="MX-TAM">
		<meta name="geo.placename" content="Ciudad Victoria">
		<meta name="geo.position" content="23.730969;-99.151375">
		<meta name="ICBM" content="23.730969, -99.151375">
		<link rel="author" href="">
		<link rel="publisher" href="">
		<link rel="stylesheet" href="lib/css_color.css"/>
		<link rel="stylesheet" href="lib/cano.css" />
		<link rel="stylesheet" href="lib/laura.css" />
		<link rel="stylesheet" href="lib/yes.css" />
		<link rel="stylesheet" href="lib/flor.css" />
		<link rel="stylesheet" href="lib/slider.css">
		<link rel="stylesheet" href="lib/buscar.css">
		<link rel="stylesheet" href="lib/flow.css">
		<link rel="shortcut icon" href="tam.ico" />

		<script src="lib/pdz_functions.js"></script>
		
<?php
		
		echo '<link rel="stylesheet" href="lib/css_estructura.css" />';
		echo '<link rel="stylesheet" href="lib/animated.css" />';
		include("body_head_libs.php");
		
?>

<style>
	#progressbar .ui-progressbar-value {
		
		z-index:10000;

		height: 8px;
		border: 0px aliceblue;
		padding: 0px;
		background-color: #97c93c;
	}
	</style>
	

</head>
<body style="background-color:<?php echo Preference("ColorDeFondo","",""); ?>;" >
<div id="progressbar"></div>
<script>
	$( "#progressbar" ).progressbar({value: false});
	$( "#progressbar" ).css("height","7px");
	$( "#progressbar" ).hide();
</script>
<div id="preloader" style='background-color:<?php echo Preference("BackgroundPreloader","",""); ?>; color:#4E4E4E; opacity: 0.9;'>
	<div id="loader" style='
		position: fixed;
		top: 30%;
		left: 40%;
		width: 200px;
		text-align: center;
		color:white;
		
		'>			
			Cargando
    		<img src="img/loader_bar.gif" style=''><br>
   			
    </div>
</div>
