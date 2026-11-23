
<script type="text/javascript"> // Desaparece el preloader
	
	$('#preloader').fadeOut('fast');
	$('body').css({'overflow':'visible'});
	$('#preloader').hide();


function SubirDocumento(IdDelegacion,IdPrograma,Folio,idarchivo){
$("#LoaderDoc").show();         
var inputFileImage = document.getElementById("Documento");
var file = inputFileImage.files[0];
var data = new FormData();
data.append("Documento",file);
data.append('Folio',Folio);
data.append('IdPrograma',IdPrograma);
data.append('IdDelegacion',IdDelegacion);
data.append('IdArchivo',idarchivo);
$.ajax({
        url: "subirarchivo.php",        
        type: "POST",             
        data: data,               
        contentType: false,       
        cache: false,             
        processData:false,        
        success: function(data)   
        {
            console.log(data);
			$('#PDFDoc').html(data);
			$("#PDFDoc").show();  
			document.getElementById("Documento").value='';
            $("#LoaderDoc").hide(); 
        }
    });
    

}   


</script> 






<?php 
if(isset($_GET['unlimited'])){
	echo '
	<script>
	NPush("Ha entrado en modo de session ilimitada","Notificacion de la Plataforma ITAVU");
	</script>
	';
} 
//------------ Libreria WOW para Slider

// if (isset($_GET['sl'])){ //si se necesita un slider, cargar libreria WOW
// 	echo '
	
	
// 	<script type="text/javascript" src="lib/slider/engine1/wowslider.js"></script>
// 	<script type="text/javascript" src="lib/slider/engine1/script.js"></script>

// 	';
// }
//.................


$Token = MiToken_generate();
// $url = "https://plataformaitavu.tamaulipas.gob.mx/ws/ws_ip.php?nitavu=".$nitavu."&token=".$Token."";
// echo "<iframe src='".$url."' style='display:none;'></iframe>";

// Recuperar la IP
// $MyIp = RecuperarIPLocal($nitavu);
// echo "Tu Ip es: ".$MyIp;


?>

<script>
var acc = document.getElementsByClassName("accordion");
var i;

for (i = 0; i < acc.length; i++) {
  acc[i].addEventListener("click", function() {
    /* Toggle between adding and removing the "active" class,
    to highlight the button that controls the panel */
    this.classList.toggle("active");

    /* Toggle between hiding and showing the active panel */
    var panel = this.nextElementSibling;
    if (panel.style.display === "block") {
      panel.style.display = "none";
    } else {
      panel.style.display = "block";
    }
  });
}
</script>

<div id='R' style='display:none;'></div>
<div id='RV' style='width:100%; padding:5px; font-family:Compacta; font-size:8pt; color:gray;'></div>

<?php
include("body_footer_acuerdo.php");

?>
	<script src="lib/btnprogress/js/script.js"></script>




</div>


<script>
// Navegación con la tecla ENTER entre campos de formulario (salvo textareas y submit)
document.addEventListener('keydown', function(e) {
	if (e.key === 'Enter') {
		var target = e.target;
		if (!target || !target.tagName) return;
		var tagName = target.tagName.toLowerCase();
		if (tagName === 'textarea' || (tagName === 'button' && target.type === 'submit')) {
			return;
		}
		if (tagName === 'input' || tagName === 'select') {
			if (target.type === 'submit' || target.type === 'button') return;
			
			e.preventDefault();
			var form = target.form;
			if (!form) return;
			
			var focusable = Array.from(form.querySelectorAll('input:not([type="hidden"]):not([disabled]), select:not([disabled]), textarea:not([disabled]), button[type="submit"]'));
			var index = focusable.indexOf(target);
			
			if (index > -1 && index < focusable.length - 1) {
				focusable[index + 1].focus();
				if (typeof focusable[index + 1].select === 'function' && focusable[index + 1].tagName.toLowerCase() === 'input' && focusable[index + 1].type !== 'date' && focusable[index + 1].type !== 'file') {
					focusable[index + 1].select();
				}
			}
		}
	}
});
</script>

<?php
if (!empty($HorarioAccesoActivo) && isset($nitavu) && function_exists('itavu_en_horario_acceso')) {
	$exentos = (isset($HorarioAccesoExentos) && is_array($HorarioAccesoExentos)) ? array_map('strval', $HorarioAccesoExentos) : [];
	if (!in_array((string)$nitavu, $exentos, true)) {
		$finTs = strtotime(date('Y-m-d') . ' ' . $HorarioAccesoFin);
		$restantesMs = max(0, ($finTs - time()) * 1000);
		$logoutHorarioUrl = file_exists('logout.php') ? 'logout.php?fuera_horario=1' : '../logout.php?fuera_horario=1';
		echo '<script>
		(function() {
			var cierreEn = Date.now() + ' . (int)$restantesMs . ';
			var urlCierre = ' . json_encode($logoutHorarioUrl) . ';
			function verificarCierreHorario() {
				if (Date.now() >= cierreEn) {
					top.location.replace(urlCierre);
				}
			}
			if (' . (int)$restantesMs . ' <= 0) {
				top.location.replace(urlCierre);
			} else {
				setTimeout(verificarCierreHorario, Math.min(' . (int)$restantesMs . ' + 1000, 2147483000));
				setInterval(verificarCierreHorario, 60000);
			}
		})();
		</script>';
	}
}

// Control automático de cierre por inactividad en cliente (sincronizado con $SessionInactividadMin)
if (isset($nitavu) && isset($SessionInactividadMin) && (int)$SessionInactividadMin > 0) {
	$limiteInactMs = (int)$SessionInactividadMin * 60 * 1000;
	$logoutInactUrl = file_exists('logout.php') ? 'logout.php?inactividad=1' : '../logout.php?inactividad=1';
	echo '<script>
	(function() {
		var limiteMs = ' . $limiteInactMs . ';
		var avisoMs = Math.max(0, limiteMs - 60000);
		var urlInact = ' . json_encode($logoutInactUrl) . ';
		var ultimaActividad = Date.now();
		var avisoMostrado = false;
		var ultimoRegistro = 0;

		function registrarActividad() {
			var ahora = Date.now();
			if (ahora - ultimoRegistro < 3000) return;
			ultimoRegistro = ahora;
			ultimaActividad = ahora;
			avisoMostrado = false;
		}

		["mousemove", "mousedown", "keydown", "scroll", "touchstart", "click"].forEach(function(evt) {
			document.addEventListener(evt, registrarActividad, { passive: true });
		});

		setInterval(function() {
			var inactivo = Date.now() - ultimaActividad;
			if (inactivo >= limiteMs) {
				top.location.replace(urlInact);
			} else if (!avisoMostrado && avisoMs > 0 && inactivo >= avisoMs) {
				avisoMostrado = true;
				if (typeof $.toast === "function") {
					$.toast({
						heading: "Aviso de inactividad",
						text: "Tu sesión se cerrará automáticamente en 1 minuto si no hay actividad.",
						showHideTransition: "slide",
						icon: "warning",
						hideAfter: 10000
					});
				}
			}
		}, 15000);
	})();
	</script>';
}
?>

</body>

</html>