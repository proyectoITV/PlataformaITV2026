
</!DOCTYPE html>
<html>

		
		<?php
		
		echo '<link rel="stylesheet" href="lib/css_estructura.css" />';
		// echo '<link rel="stylesheet" href="lib/animated.css" />';
		
		$dispositivo = "pc";
		//modificamos el css de acuerdo al dispositivo
		if( strstr( $_SERVER[ 'HTTP_USER_AGENT' ], 'iPhone' ) ) {
			//echo "<script>alert('Soy un iPhone');</script>";
		  //header( 'Location: http://iphone.mysite.com' );
			echo '<link rel="stylesheet" href="lib/css_estructura_iphone.css?'.$hora.'" />';
			$dispositivo='iPhone';
			//mensaje("es un mac",'');
		  	//exit();
		} 
		
		if( strstr( $_SERVER[ 'HTTP_USER_AGENT' ], 'iPad' ) ) {
		  //header( 'Location: http://iphone.mysite.com' );
			echo '<link rel="stylesheet" href="lib/css_estructura_ipad.css?'.$hora.'" />';
			$dispositivo = 'iPad';
		  	//exit();
		} 
		
		?>
		

		
		
		<!-- <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script> -->
    	<script type="text/javascript" src="lib/google_charts_loader.js"></script> 
		
		
		<!-- <script language="javascript" src="lib/aslider.js" type="text/javascript"></script> 		 -->
		
		<script src="lib/jquery-3.3.1.js"></script> 
		<!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script> -->

  		<!-- offline jquery 1 <script src="lib/jquery-1.12.4.js"></script> <script src="https://code.jquery.com/jquery-1.12.4.js"></script> -->
		<!-- offline jquery ui <script src="lib/jquery-ui.js"></script> <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script> -->
	

		<!-- PARA EL RELOJ DEL PASE -->
 		<link href="lib/timedropper.css" rel="stylesheet" type="text/css"> 

		
		<script src="lib/push.js"></script>
		<script src="lib/push.min.js"></script>
		

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
					$.toast(contenidosRecibidos[i].substring(0, 100));
					Push.create('Notificaciones ITAVU', { //Titulo de la notificación
						body: contenidosRecibidos[i].substring(0, 100), //Texto del cuerpo de la notificación
						icon: './icon/alertaNoti1.png', //Icono de la notificación
						timeout: 2000, //Tiempo de duración de la notificación
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
Notification.requestPermission().then(function(result) {
  console.log(result);
});
<?php
//echo "setInterval('NotiEmergente(".$nitavu.")',1000);";
?>
</script>

	
	<script type="text/javascript">
		$(function(){
		    $('#slider_widReq div:gt(0)').hide();
		    setInterval(function(){
		      $('#slider_widReq div:first-child').fadeOut(0)
		         .next('div').fadeIn(1000)
		         .end().appendTo('#slider_widReq');}, 5000);
		});
		
	</script>
	<script type="text/javascript">
		$(function(){
		    $('#slider_wid div:gt(0)').hide();
		    setInterval(function(){
		      $('#slider_wid div:first-child').fadeOut(0)
		         .next('div').fadeIn(1000)
		         .end().appendTo('#slider_wid');}, 4000);
		});
		
	</script>

	
<script type="text/javascript">
		$(function(){
		    $('#SliderIndex div:gt(0)').hide();
		    setInterval(function(){
		      $('#SliderIndex div:first-child').fadeOut(0)
		         .next('div').fadeIn(1000)
		         .end().appendTo('#SliderIndex');}, 8000);
		});
		
	</script>
	

	<script src="lib/jquery.modalpdz.js"></script> <link rel="stylesheet" href="lib/jquery.modalcsspdz.css" />



	<script src="lib/pdz_functions.js"></script>
	<script src='lib/pdz_sintetizadodevoz.js'></script>
	<script>
		function habla(quedigo){
			// alert(quedigo);
			// responsiveVoice.speak(quedigo); 
			responsiveVoice.speak(quedigo, 'Spanish Latin American Female', {volume: 100});
		}
			
	</script>


	<?php
	if (isset($_GET['app'])=="atencion"){
		echo '<link rel="stylesheet" href="lib/css/jkeyboard.css">';
	}

	if (isset($_GET['sl'])){ //si se necesita un slider, cargar libreria WOW
		echo '
		<link rel="stylesheet" type="text/css" href="lib/slider/engine1/style.css" />
		<script type="text/javascript" src="lib/slider/engine1/jquery.js"></script>
		';
	}

	if (isset($_GET['rjs'])){//libreria para ReactJS
	echo '		
		<script src="lib/react.development.js"></script>
		<script src="lib/react-dom.development.js"></script>
		<script src="lib/babel.min.js"></script>
	';
	}
	?>

	<script src="lib/graficas/chartist.js"></script> 
	<link rel="stylesheet" href="lib/graficas/chartist.min.css">
	<script type="text/javascript" src="lib/jquery.number.js"></script>
	<script type="text/javascript" src="lib/printThis.js"></script>
	
	<link rel="stylesheet" href="lib/jquery.toast.min.css">
	<script type="text/javascript" src="lib/jquery.toast.min.js"></script>

	<link rel="stylesheet" type="text/css" href="lib/datatables.min.css"/> 
	<script type="text/javascript" src="lib/datatables.min.js"></script>


	<script src="lib/gauge.min.js"></script>
	<!-- <script src="lib/jcanvas.min.js"></script> -->
	<!-- <script src="lib/apexcharts.min.js"></script> -->
	

	

	

</head>
<!-- <script>
	function r2_logout(){
		$.ajax({
			url: "r2_logout.php", type: "post",	
			data: {},
			success: function(data){
				$('#R').html(data+"\n");		
			}
		});
	}
</script> -->
<body >
<?php 
// include ("./lib/body_head.php"); 
// include ("./lib/body_menu.php"); 







$FileWeb="var ctaLayer = new google.maps.KmlLayer({url:'https://plataformaitavu.tamaulipas.gob.mx/kmz_go/https://plataformaitavu.tamaulipas.gob.mx/kmz/41.kmz',map: map});";
			
			echo "<div id='mapa_kmz'></div>";	
						echo "

						<script>
						function initMap() {
						var map = new google.maps.Map(document.getElementById('mapa_kmz'), {	
							zoom: 11,
			
							center: {lat: 41.876, lng: -87.624 }
						});
						
						var ctaLayer = new google.maps.KmlLayer({url:'https://plataformaitavu.tamaulipas.gob.mx/kmz/41.kmz',map: map});
						
						
						console.log(ctaLayer);
						}
						</script>
			
						<script src='https://maps.googleapis.com/maps/api/js?key=AIzaSyDFrRZEYqnAuGMggPnDdD2qEm-bOpDdoNA&callback=initMap'
						async defer></script>
				

				
						
						
						";

// include ("lib/body_footer.php"); ?>



</body>
</html>
