<?php


//WIDGET PROTOTIPO


$Widget_nombre="Tiempo de comida de hoy";
$Widget_contenido="";
$empleados_sindpto_quienes="";
//require("config.php");require("lib/funciones.php");



$sql = "select nitavu, nombre, puesto, dpto, comida from empleados where empleados.comida = 0 AND nitavu='".$nitavu."'";
//echo $sql;
$rc= $conexion -> query($sql);
if($f = $rc -> fetch_array())
{
	$Widget_contenido = $Widget_contenido."<table border=0 width=100%><tr><td align=center colspan=2><b class='alerta' sytle='width:100%; text-align:center;'>Hay un problema con tu tiempo de comida; Comunicate con el Dpto. de Rec. Humanos para solucionarlo.</b></td></tr>";
	$Widget_contenido = $Widget_contenido."<tr><td align=right valign=center><a href='directorio.php?nombre=humanos'><img src='icon/dirtel.png' style='width:32px; height:32px;'></a></td><td align=left><a href='directorio.php?nombre=humanos'>Directorio</a></td></tr></table>";
	
}

else {

 

$Widget_contenido = $Widget_contenido."<table border=0 width='100%' s><tr>";
$salida = comida_salida($nitavu);

if ($salida==FALSE){
	
	$Widget_contenido = $Widget_contenido.'<td>';
	$Widget_contenido = $Widget_contenido.'<label>A que hora saldras a comer?</label>';
	$Widget_contenido = $Widget_contenido."<input type='text' name='oficial_hr_salida' id='oficial_hr_salida' onchange='tiempo()'   value='".$hora."' required='required' placeholder='HH:MM:SS' ></td>";
	$Widget_contenido = $Widget_contenido.'<td valign=center><label>Espere autorizacion</label><br><button  onclick=SolicitaPase("'.$nitavu.'","COMIDA"); class="btn-identidad-color1">Solicitar</button></td>';
	$Widget_contenido = $Widget_contenido.'';

	

} else {
//$Widget_contenido = $Widget_contenido.'Salio: '.hora12($salida);
$pase_estado = comida_estado($nitavu);
if ($pase_estado==TRUE){	
	$trestante = comida_trestante($nitavu);	
	//echo $trestante;
	if (substr($trestante, 0,1)=='-'){//se retraso
		$Widget_contenido = $Widget_contenido. "<td  width=12% rowspan=3 align=center valign=center><img src='icon/emo_triste.gif' style='width:50px; height:50px;'></td>";

		$Widget_contenido = $Widget_contenido."<td align=left class='tenue' style='font-size: 7pt;'> <span >Tiempo autorizado para comida ".comida_aut($nitavu)."</span></td>";
		$Widget_contenido = $Widget_contenido."</tr>";
		$Widget_contenido = $Widget_contenido."<tr><td align=left valign=center style='font-size: 10pt;'>Se ha retrasado <b class='alerta'>".$trestante."m</b>.</td></tr>";
	}
	else {
		
		if (substr($trestante, 0,1)=='+'){//PASE REALIZADO
		$Widget_contenido = $Widget_contenido. "<td  width=12% rowspan=2 align=center valign=center><img src='icon/emo_cafe.gif' style='width:50px; height:50px;'></td>";

		$Widget_contenido = $Widget_contenido."<td align=left class='tenue' style='font-size: 7pt;'> <span >PASE REALIZADO<br></span></td>";
		$Widget_contenido = $Widget_contenido."</tr>";
		$Widget_contenido = $Widget_contenido."<tr><td align=left valign=center style='font-size: 10pt;'><b class=''>".$trestante."</b>.</td></tr>";
		}
	
		if (substr($trestante, 0,1)=='*'){//PASE REALIZADO
		$Widget_contenido = $Widget_contenido. "<td  width=12% rowspan=2 align=center valign=center><img src='icon/emo_cafe.gif' style='width:50px; height:50px;'></td>";

		$Widget_contenido = $Widget_contenido."<td align=left class='tenue' style='font-size: 7pt;'> <span >Tiempo autorizado para comida ".comida_aut($nitavu).".<br></span></td>";
		$Widget_contenido = $Widget_contenido."</tr>";
		$Widget_contenido = $Widget_contenido."<tr><td align=left valign=center style='font-size: 10pt;'><b class=''>".$pase_estado."</b></td></tr>";
		}

		if (substr($trestante, 0,1)=='0'){//PASE REALIZADO
		$Widget_contenido = $Widget_contenido. "<td  width=12% rowspan=3 align=center valign=center><img src='icon/emo_cafe.gif' style='width:50px; height:50px;'></td>";

		$Widget_contenido = $Widget_contenido."<td align=left class='tenue' style='font-size: 7pt;'> <span >Tiempo autorizado para comida ".comida_aut($nitavu)."</span></td>";
		$Widget_contenido = $Widget_contenido."</tr>";
		$Widget_contenido = $Widget_contenido."<tr><td align=left valign=center style='font-size: 10pt;'>Le quedan  <b class='normal'>".$trestante."m</b> Buen Provecho!.</td></tr>";
		}

	}
}
else {
	$Widget_contenido = $Widget_contenido." <label>".$pase_estado."</label>";
}

}
$Widget_contenido = $Widget_contenido. "<tr><td class='tchico' align=right>
<a href=''></a></td></tr></table>";




}



$tmp="";
$tmp = $tmp."<section id='aplicaciones' class='widget'>";
$tmp = $tmp. "<label>".$Widget_nombre."</label>";

$tmp = $tmp. "<div id='preloader_comida' style='display:none;'><img src='img/cargando4.gif' style='width:80%;'></div>";


$tmp = $tmp. "<div id='pase'>";
$tmp = $tmp."<article >";
//$tmp = $tmp. "<a href=''>";
$tmp = $tmp. "<div id='datapase'></div><table border='0' width=100%><tr><td>";
$tmp = $tmp.$Widget_contenido."<label><a href='auscencia4.php'>Ver mas...</a>"."<br>";
$tmp = $tmp. "</td></tr></table></article></div>";

$tmp = $tmp."<div id='pase2'></div>";


echo $tmp."</section>";
//echo $tmp."</section>";




//GUARDAR----

?>



		<!-- <script src="https://code.jquery.com/jquery-1.12.1.min.js"></script> -->
		<!-- <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script> -->
		<script src="lib/jquery-ui.min.js"></script>
		<script src="lib/timedropper.js"></script>
		<script>$( "#hr_salida" ).timeDropper();</script>
		<script>$( "#hr_regreso" ).timeDropper();</script>
		<script>$( "#otro_hr_salida" ).timeDropper();</script>
		<script>$( "#otro_hr_regreso" ).timeDropper();</script>
		<script>$( "#oficial_hr_salida" ).timeDropper();</script>
		<script>$( "#oficial_hr_regreso" ).timeDropper();</script>







	<script>
		  function archivo(evt) {
			var files = evt.target.files; // FileList object
		
			// Obtenemos la imagen del campo "file".
			for (var i = 0, f; f = files[i]; i++) {
			  //Solo admitimos imágenes.
			  if (!f.type.match('image.*')) {
				continue;
			  }
		
			  var reader = new FileReader();
		
			  reader.onload = (function(theFile) {
				return function(e) {
				  // Insertamos la imagen
				 document.getElementById("list").innerHTML = ['<img class="thumb" src="', e.target.result,'" title="', escape(theFile.name), '"/>'].join('');
				};
			  })(f);
		
			  reader.readAsDataURL(f);
			}
		  }
		
		//   document.getElementById('foto_comision').addEventListener('change', archivo, false);
		</script>
    
<script>


function SolicitaPase(Nitavu, Asunto){   
//    hora = oficial_hr_salida
   Horadepase = $("#oficial_hr_salida").val();
   $("#preloader_comida").css({'display':'inline-block','color':'red'});
   $("#pase").css({'display':'none','color':'gray'});
   $.ajax({
	   url: "solicitapase.php",
	  type: "post",   
	  data: {asunto: Asunto, usuario: Nitavu, Horadepase:Horadepase },
	  success: function(data){
	   $("#pase").css({'display':'inline-block','color':'#FFBF00','background-color':' #FFFFBF'});
	   $('#datapase').html(data+"\n");
	   SolicitaPase2(Nitavu);
	   $("#preloader_comida").css({'display':'none','color':'gray'});
	  }
   });
   
}


function SolicitaPase2(Nitavu){   
//    hora = oficial_hr_salida
   Horadepase = $("#oficial_hr_salida").val();
   $("#preloader_comida").css({'display':'inline-block','color':'red'});
   $("#pase").css({'display':'none','color':'gray'});
   $.ajax({
	   url: "solicitapase2.php",
	  type: "post",   
	  data: {usuario: Nitavu},
	  success: function(data){
		$("#pase").css({'display':'none','color':'#FFBF00','background-color':' #FFFFBF'});
		$("#pase2").css({'display':'inline-block'});
	   $('#pase2').html(data+"\n");
	   $("#preloader_comida").css({'display':'none','color':'gray'});
	  }
   });
   
}

</script>

<script>
function tiempo(){
	//var txt_tiempo = document.getElementById("txt_tiempo");
	inicio = document.getElementById("hr_salida").value;
	fin = document.getElementById("hr_regreso").value;

	inicioMinutos = parseInt(inicio.substr(3,2));
	inicioHoras = parseInt(inicio.substr(0,2));

	finMinutos = parseInt(fin.substr(3,2));
	finHoras = parseInt(fin.substr(0,2));
	transcurridoMinutos = finMinutos - inicioMinutos;
	transcurridoHoras = finHoras - inicioHoras;

if (transcurridoMinutos < 0) {
	transcurridoHoras--;
	transcurridoMinutos = 60 + transcurridoMinutos;
}

horas = transcurridoHoras.toString();
minutos = transcurridoMinutos.toString();

if (horas.length < 2) {
	horas = "0"+horas;
}

if (minutos.length < 2) {
	minutos = "0"+minutos;
}


	//document.getElementById("resta").value = horas+":"+minutos;
	document.auscencia_temporal.txt_tiempo.value = horas+":"+minutos+":00" ;
}
</script>