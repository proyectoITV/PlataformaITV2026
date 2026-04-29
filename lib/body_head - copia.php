</!DOCTYPE html>
<?php 	require("seguridad.php"); ?>
<?php 	require("funciones.php"); ?>
<?php 	require("cano_funciones.php"); ?>
<?php 	require("laura_funciones.php"); ?>
<?php 	require("yes_funciones.php"); ?>
<?php 	require("flor_funciones.php"); ?>
<?php 	require("config.php"); ?>
<?php // error_reporting(E_ALL ^ E_NOTICE);
?>
<html>
	<head>
		<title>PLATAFORMA DE ADMINISTRACION ITAVU</title>
		
		<?php
		//esta variable se configura en el link de la aplicacion, para refresh
		if (isset($_GET['r'])) 
			{$r = $_GET['r'];
			echo '<meta http-equiv="refresh" content="'.$r.'" />';		
		}
		else{// sino esta configurada NO SE ACTUALIZA LA PAGINA CADA DETERMINADO TIEMPO
			//$r= 900;
		}
		
		//INFORMACION A COMPLETAR DE USUARIO
		if (completar1($nitavu)==''){}else{header('location:completar1.php?id='.$nitavu);}
		
		?>
		
		<meta charset="utf-8" />		
		<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=yes">
		<meta name="description" content="Bienvenido la Plataforma de Administracion de ITAVU Tamaulipas">
		<meta name="keywords" content="Gobierno de Tamaulipas, Gobierno, Tamaulipas, Gobernador García Cabeza de Vaca, Cabeza de Vaca, Tamps, Tam, ">
		<meta name="robots" content="index,follow">
		<meta name="googlebot" content="index,follow">
		<meta name="geo.region" content="MX-TAM">
		<meta name="geo.placename" content="Ciudad Victoria">
		<meta name="geo.position" content="23.730969;-99.151375">
		<meta name="ICBM" content="23.730969, -99.151375">
		<link rel="author" href="">
		<link rel="publisher" href="">
		<link rel="stylesheet" href="lib/css_color.css?<?php echo $hora; ?>" />
		<link rel="stylesheet" href="lib/cano.css" />
		<link rel="stylesheet" href="lib/laura.css" />
		<link rel="stylesheet" href="lib/yes.css" />
		<link rel="stylesheet" href="lib/flor.css" />
		<link rel="stylesheet" href="lib/slider.css">
		<link rel="stylesheet" href="lib/buscar.css">
		<link rel="stylesheet" href="lib/flow.css">
		<link rel="shortcut icon" href="tam.ico" />
		
		<?php		
		echo '<link rel="stylesheet" href="lib/css_estructura.css?'.$hora.'" />';//modo normal
		echo '<link rel="stylesheet" href="lib/animated.css?'.$hora.'" />';//modo normal
		
		$dispositivo = "pc";
		//modificamos el css de acuerdo al dispositivo
		if( strstr( $_SERVER[ 'HTTP_USER_AGENT' ], 'iPhone' ) ) {
			echo '<link rel="stylesheet" href="lib/css_estructura_iphone.css?'.$hora.'" />';
			$dispositivo='iPhone';
		} 
		
		if( strstr( $_SERVER[ 'HTTP_USER_AGENT' ], 'iPad' ) ) {
			echo '<link rel="stylesheet" href="lib/css_estructura_ipad.css?'.$hora.'" />';
			$dispositivo = 'iPad';
		} 		
		?>
		

		
		
		<script type="text/javascript" src="lib/gstatic_loader.js"></script>    
    	<!-- <script type="text/javascript" src="lib/google_charts_loader.js"></script>  -->
		
		<!-- <script language="javascript" src="lib/aslider.js" type="text/javascript"></script> -->
		
		<script src="lib/jquery-3.3.1.min.js"></script>		
		  <script>
		  	$( function() {
	    		$( "#organigrama_flow" ).draggable();
	  		} );
	  	 </script>

		<!-- Relog -->
		<!-- <link href="lib/timedropper.css" rel="stylesheet" type="text/css">  -->


		<!-- <script src="lib/push.js"></script>
		<script src="lib/push.min.js"></script> -->
		<script src="lib/pdz_functions.js"></script>

		<script>
		function NotiEmergente(str) {

			var xmlhttp;
			var contenidosRecibidos = new Array();
			var nodoMostrarResultados = document.getElementById('notasEmergentes');
			var audio = new Audio();
			audio.src = 'notificacion.mp3';
			if (str.length==0) {
				document.getElementById("notasEmergentes").innerHTML=""; 
				nodoMostrarResultados.innerHTML = ''; 
				return; 
			}
			
			xmlhttp=new XMLHttpRequest();
			xmlhttp.onreadystatechange = function() {
				if (xmlhttp.readyState==4 && xmlhttp.status==200) {
					contenidosRecibidos = xmlhttp.responseText.split(",");
					
					for (var i=0; i<contenidosRecibidos.length-1;i++) {
						if(contenidosRecibidos[i] != ''){
							
							Push.create('Notificaciones ITAVU', { //Titulo de la notificación
								body: contenidosRecibidos[i].substring(0, 100), //Texto del cuerpo de la notificación
								icon: './icon/alertaNoti1.png', //Icono de la notificación
								timeout: 5000, //Tiempo de duración de la notificación
								onClick: function () {//Función que se cumple al realizar clic cobre la notificación
									
									this.close(); //Cierra la notificación
								}
							});	
							//Reproducir audio
							audio.play();
						}	
					}
						
				}		
					
			}
			xmlhttp.open("GET","notiEmergente.php?user="+str,true);
			xmlhttp.send(); 

		}
		//Para solicitar permisos de mostrar notificación.
		
		<?php
		echo "setInterval('NotiEmergente(".$nitavu.")',1000);";
		?>
		</script>

		<script>
		//PEDIR PERMISOS AL USUARIO

		//Permiso para Mensajes
		Notification.requestPermission().then(function(result) {
			console.log(result);
		});

		</script>


		<script type="text/javascript">
		// SLIDER DE PORTADA
			$(function(){
				$('#slider_ecologico div:gt(0)').hide();
				setInterval(function(){
				$('#slider_ecologico div:first-child')
					.next('div').fadeIn(1000)
					.end().appendTo('#slider_ecologico');}, 10000);
			});
			//]]>
		</script>
		
	
		<script type="text/javascript">//<![CDATA[
		// SLIDER DE REQUISICIONES
		$(function(){
		    $('#slider_widReq div:gt(0)').hide();
		    setInterval(function(){
		      $('#slider_widReq div:first-child')
		         .next('div').fadeIn(1000)
		         .end().appendTo('#slider_widReq');}, 5000);
		});
		//]]>
		</script>


	<script type="text/javascript">//<![CDATA[
			// SLIDER DE PORTADA WIDGET
		$(function(){
		    $('#slider_wid div:gt(0)').hide();
		    setInterval(function(){
		      $('#slider_wid div:first-child')
		         .next('div').fadeIn(1000)
		         .end().appendTo('#slider_wid');}, 4000);
		});
		//]]>
	</script>


<!-- <link href="http://www.jqueryscript.net/css/jquerysctipttop.css" rel="stylesheet" type="text/css"> -->
<!-- <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script> -->

<?php
// solo si esta &txtplus= en la url, aparecen los text area con texto enriquecido
	if(isset($_GET['txtplus'])){
		$txtplus=$_GET['txtplus'];
		if(!$txtplus){
			// echo ' <script src="lib/txt_plusJJ.js" type="text/javascript"></script>';
		}
	}
?>


<script src="lib/jquery.modalpdz.js"></script> <link rel="stylesheet" href="lib/jquery.modalcsspdz.css" />

<script src='lib/vozhumana.js'></script>
<script>
	function habla(quedigo){
		// alert(quedigo);
		// responsiveVoice.speak(quedigo); 
		responsiveVoice.speak(quedigo, 'Spanish Latin American Female', {volume: 100});
	}
		
</script>


	
<script>
function recibirQS(parametros){
	var urlPag = window.location.search.substring(1);
	var urlVars = urlPag.split('&');
	for (var i = 0; i < urlVars.length; i++){
		var nombreParam = urlVars[i].split('=');
			if(nombreParam[0] == parametros){
			return nombreParam[1];
			}
	}
}

function LeerGET(Variable){
	var nombre = recibirQS(Variable);
	if(nombre != undefined){
		// alert("existe variable  nombre")
		return nombre;
	}else{
		// alert("NO existe variable  nombre")
		return "";

	}

}
	</script>

</head>


<body>