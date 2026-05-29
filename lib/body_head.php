<?php require("seguridad.php");?>
<!DOCTYPE html>
<html>
	<head>
		<!-- <title>Plataforma ITAVU</title> -->
		<?php		
		// if ($dbhost =='localhost'){
			echo "<title>".$nitavu." |  Plataforma | ".$dbhost."-".$Vdbhost."</title>";
		// } else {
		// 	echo "<title>".$nitavu." |  Plataforma </title>";
		// }
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
		<link rel="stylesheet" href="lib/css_color.css?d=<?php echo rand();?>"/>
		<link rel="stylesheet" href="lib/cano.css" />
		<link rel="stylesheet" href="lib/laura.css" />
		<link rel="stylesheet" href="lib/yes.css" />
		<link rel="stylesheet" href="lib/flor.css" />
		<link rel="stylesheet" href="lib/slider.css">
		<link rel="stylesheet" href="lib/buscar.css">
		<link rel="stylesheet" href="lib/flow.css">
		<link rel="shortcut icon" href="4t.ico" />


		<head>
  <!-- load all Font Awesome v6 styles -->
  <link href="fontawesome/css/all.css" rel="stylesheet" />

  <!-- support v4 icon references/syntax -->
  <link href="fontawesome/css/v4-shims.css" rel="stylesheet" />
</head>

		<script src="lib/pdz_functions.js"></script>
		<script type="text/javascript" src="lib/google_charts_loader.js"></script> <!--offline graficos de google -->
		<script src="lib/gauge.min.js"></script>
		<script src="lib/sweetalert2@9"></script>
	
	<!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css" integrity="sha384-rwoIResjU2yc3z8GV/NPeZWAv56rSmLldC3R/AZzGRnGxQQKnKkoFVhFQhNUwEyJ" crossorigin="anonymous"> -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">

    <!-- Begin emoji-picker Stylesheets -->
    <link href="./lib/css/emoji.css" rel="stylesheet">
    <!-- End emoji-picker Stylesheets -->

  

		     <!-- fluid -->
		<link rel="stylesheet" href="lib/fluid/fluid.css">
		
<?php
		
		echo '<link rel="stylesheet" href="lib/css_estructura.css?d='.rand().'" />';
		echo '<link rel="stylesheet" href="lib/animated.css" />';
		echo '<link rel="stylesheet" href="lib/FormElement.css" />';
		// echo '<link rel="stylesheet" href="lib/btnprogress/css/style.css" />';

		


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
<div id="progressbar" style="

height: 7px;
z-index: 9000000;
position: fixed;
top: -4px;
width: 100%;
"></div>
<script>
	$( "#progressbar" ).progressbar({value: false});
	$( "#progressbar" ).css("height","7px");
	$( "#progressbar" ).hide();


	function LoaderDiv(IdDiv){
    	$('#'+IdDiv).html('<div class="text-center"><div class="spinner-border" role="status"><span class="sr-only">Loading...</span></div></div>')
	}
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
<audio id="AudioBoop" style="display:none;">
    <source src="audios/boop.mp3">
</audio>

<audio id="AudioBoop2" style="display:none;">
    <source src="audios/mensaje.wav">
</audio>

<audio id="AudioError" style="display:none;">
    <source src="audios/error.mp3">
</audio>

<audio id="AudioSuccess" style="display:none;">
    <source src="audios/success.mp3">
</audio>

<script src="https://code.jquery.com/jquery-1.11.3.min.js"></script>

<!-- Begin emoji-picker JavaScript -->
<script src="./lib/js/config.min.js"></script>
<script src="./lib/js/util.min.js"></script>
<script src="./lib/js/jquery.emojiarea.min.js"></script>
<script src="./lib/js/emoji-picker.min.js"></script>
<!-- End emoji-picker JavaScript -->

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
    <script type="text/javascript" src="./lib/js/jquery.toast.js"></script>
	<link rel="stylesheet" href="./lib/css/jquery.toast.css">

