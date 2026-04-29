<?php
//include ("./unica/seguridad.php");
include ("./unica/body_head.php");
include ("./unica/body_menu.php");
// contenido:
?>



<?php

$id_aplicacion ="ap68"; //ap06=Permisos de Aplicacion
if (sanpedro($id_aplicacion, $nitavu)==TRUE){
	// xd_update('ap26',$nitavu);//guarda la experiencia del usuario
	// historia($nitavu, "Entro a la aplicacion para Configurar la asistencia y ver el reporte [ap26]");
	echo "<h5>".app_detalle($id_aplicacion)."</h5>";

	echo "<br>";
	echo buscar("censos.php","Que censo buscaras?","");

	echo "<div id='censo_mapa'>";
	insertar_mapa();
	echo "</div>";
	echo "<a id='censo_nuevo' href='#form1' rel='modal:open' title='Crear un nuevo censo'>+ </a>  ";
	// echo "<button id='censo_nuevo'>";
	
	// echo "</button>";
	
	echo "<form id='form1' action='' class='modal'>";
	echo "<h1>Nuevo Censo</h1>";
	
	echo "<div>";
	
		echo "<span id='ListaDeMunicipios'></span>";
		echo "<span id='ListaDeColonias'></span>";
		echo "<span id='ListaDeManzanas'></span>";
		echo "<span id='ListaDeLotes'></span>";

	
	echo "</div>";
	
	
	echo "<br><br><br><br><br>";

	echo "</form>";



} else {mensaje ("ERROR: No tiene acceso",'');}


?>

<br><br>

<script>	
function CargaMunicipios(){   
	$("#preloader").show();
	$('#ListaDeColonias select').html("");
		// al seleccionar el municipios se cargan las colonias y tengo que borrar las manzanas   
	console.log("cargando...");
	Seleccionado = LeerGET('m')	
   $.ajax({
	   url: "run_municipios.php",
	  type: "post",   
	  data: {mSel: Seleccionado},
	  success: function(data){	   
		
	   $('#ListaDeMunicipios').html(data+"\n");	   
	   
	   $("#preloader").hide();  
	   
	  }
   });
  
}




function CargaColonias(){
	$("#preloader").show();
	$('#ListadeManzanas select').html("");
	MunSeleccionado = $("#municipio").val();
	$.ajax({
	   	url: "run_colonias.php",
	  	type: "post",   
	  	data: {mSel: MunSeleccionado},
	  	success: function(data){	   
			$('#ListaDeColonias').html(data+"\n");	   
			
	   	$("#preloader").hide();  
	  }
   });
}



function CargaManzanas(){
	$("#preloader").show();
	MunSeleccionado = $("#municipio").val();
	ColSeleccionada = $("#colonia").val();
	$.ajax({
	   	url: "run_manzanas.php",
	  	type: "post",   
	  	data: {Mun: MunSeleccionado, Col: ColSeleccionada},
	  	success: function(data){	   
	   	$('#ListaDeManzanas').html(data+"\n");	   
	   	$("#preloader").hide();  
	  }
   });
}


// $( "#censu_nuevo tbody tr" ).on( "click", function() {
$( "#censo_nuevo" ).on( "click", function() { 
  	CargaMunicipios();
});



// setInterval(CargaMunicipios,1000);

</script>


<?php include ("./unica/body_footer.php"); ?>