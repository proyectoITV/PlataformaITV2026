
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



</body>

</html>