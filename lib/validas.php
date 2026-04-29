<?php 	require("../lib/funciones.php"); ?>
<?php 	require("../config.php"); ?>

<link rel="stylesheet" href="../lib/css_estructura.css" /> 
<link rel="stylesheet" href="../lib/css_color.css" /> 
<style>

		body {
			background-color: #003359;
			background-image: url("../img/validas_fondo.png");
			margin-top: 0px;
			color: white;
			font-size: 14pt;
		}
		h1 {
			background-color: #E3D79F;
			color: white;
			padding: 10px;
			margin-top: 0px;
			border-bottom-color: white;
			border-bottom-width: 2px;
			border-bottom-style: solid;
		}
		.centrar_hijo {
			background-color: white;
			padding: 5px;
			border-radius: 5px;
			width: 300px;
		}
		#instrucciones {
			width: 90%;
			text-align: center;
			
			margin: 10px;
				margin-right: 20px;
		}
		#instrucciones a:hover {
		color:#E3D79F;
		}
		#instrucciones a{
		color: #00477B;
		}
		#instrucciones img:hover {
			opacity: 0.5;
		}
		#instrucciones table {
			width: 100%;
			text-align: center;
		}
		#instrucciones img {
			width: 50%;
		}

</style>

<?php
set_time_limit(3000); // aumenta el tiempo ejecucion del script 3min
?>