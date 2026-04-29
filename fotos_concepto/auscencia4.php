<?php
//include ("./unica/seguridad.php");
include ("./unica/body_head.php");
include ("./unica/body_menu.php");
// contenido:
?>


<?php 

$id_aplicacion = 'ap04';
$nivel = aplicacion_nivel($id_aplicacion, $nitavu);	
//mensaje_mantenimiento($nitavu, 'index.php');

	echo "<h5>".app_detalle($id_aplicacion)."</h5>";
	xd_update('ap04',$nitavu);//guarda la experiencia del usuario
	historia($nitavu, "Entro a la aplicacion para pedir un permiso de auscencia [ap04]");




?>



<form id="form1" name="form1" method="post" action="auscencia4.php" id="asucencia4" >
<table width="100%" border="0" style='font-size: 11pt; color:gray;'>
  <tr>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td width="30%" align=right valign=center style='background-color: #E1E1E1; color:#474749'>
    	<span class='pc'>Seleccione la fecha para su permiso</span>
    	<span class='movil'>Fecha</span>
    </td>

	<?php
		$varfecha = $fecha;
		if (isset($_GET['fecha2'])){//si hay una fecha en la url
			$varfecha = $_GET['fecha2'];
		} 
	?>

    <td width="50%"><input type='date' name='fecha' id='fecha' value='<?php echo $varfecha;?>' onchange='auscencia_fecha()' /></td>
  </tr>
  <tr>
    <td  align=right valign=center style='background-color: #B8D8C7; color:#474749'>
		<span class='pc'>Seleccione la hora de salida </span>
    	<span class='movil'>Hora </span>

	</td>
    <td>
    	<?php
    	$horasalida = date('H:i:s',strtotime ( '+60 minute' , strtotime ( $hora ) )) ;

		?>
		<input type='text' name='oficial_hr_salida' id='oficial_hr_salida' onchange='tiempo()' value='".$horasalida."' required='required' placeholder='HH:MM:SS' >




    </td>
  </tr>
  <tr>
    <td align=right valign=center style='background-color: #E1E1E1; color:#474749' >Tipo de Permiso</td>
    <td align=center valign=center style='font-size: 10pt; color:gray;'>
    	<table width=80% style='font-size: 10pt; color:gray;'<tr>
    	<td>
    	<?php
		// si no se cambia por uso de la url, se usara la actual

		$p = comida_salida2($nitavu, $varfecha);
		if ($p==FALSE){
			echo 'Comida <input type="radio" id="comida" name="tipopase" value="COMIDA" checked>';
		}
		else{
			echo '<b class=alerta>Ya has usado tu pase de Comida para '.fecha_larga($varfecha).'</b>';	
		}
    	?>
    		

    	</td>

    	<td>Oficial <input type="radio" id="oficial"  name="tipopase" value="OFICIAL" 
    	<?php 
    	if ($p<>FALSE){ echo 'checked>';}
    	?>
    	</td>
    	<td>Personal	<input type="radio" id="personal"   name="tipopase" value="OTRO"></td>
    	</table></tr>
    

   </td>
  </tr>
  <tr>
    <td  align=right valign=center style='background-color: #EBF3EF; color:#474749' >Justificacion</td>
    <td ><input type=text' name='justificacion'></td>
  </tr>
  <tr>
    <td align="center"><?php echo "<span class='pc'>".sugerencia("Recuerde, su tiempo autorizado de comida es de ".comida_aut($nitavu))."</span>"; ?></td>
    <td><input type='submit' name='submit_pases' class='btn btn-default' value='Solicitar'></td>
  </tr>
</table>
 </form>



<?php
echo pase_estado($nitavu, $fecha, $fecha, "FALSE");


//GUARDAR----

if (isset($_POST['submit_pases'])){
//GUARDAR solicitud de salida oficial

$fecha_ = $_POST['fecha'];
$hr_salida = date("H:i:s" , strtotime($_POST['oficial_hr_salida']));
//$hr_regreso = date("H:i:s" , strtotime($_POST['oficial_hr_regreso']));
//$hr_regreso = tiempo_sumar_hr($hr_salida,$_POST['tiempo']);
$npase = npase(FALSE);
//$asunto = $_POST['asunto'];
$justificacion = $_POST['justificacion'];
$dpto = nitavu_dpto($nitavu);
//$archivo = archivo_pases($nitavu,$fecha_,$hr_salida); //nombre del archivo
$empleado = $nitavu; $msg= ""; $resumen="";

$asunto = $_POST['tipopase'];

$sql = "INSERT INTO empleados_salidas_temporal
		(id, nitavu, hora_desde, justificacion,  asunto, fecha, dpto)
		VALUES
		('$npase','$empleado', '$hr_salida',  '$justificacion', '$asunto', '$fecha_','$dpto');";

if ($conexion->query($sql) == TRUE)
	{
			$msg =$msg. "Pase Guardado con exito; Espere autorizacion.";
			//subir($npase, 'jpg');
			$m='<p>'.nitavu_nombre($empleado).' solicita usar el pase para '.$justificacion.' de '.$asunto.' para las '.$hora.' de '.fecha_larga($fecha).'</p><br><br><br> <P style=color:gray>Para aprobar entre a la plataforma, en la seccion: APROBAR SALIDAS.</P>
			<a  style=background-color:#66FFFF;color:#006699;width:100%;padding:10px;border-style:solid;border-color:#006699;font-size:14pt;border-radius:5px;   href=http://plataformaitavu.tamaulipas.gob.mx/auscencia_temporal_autoriza3.php target=_blank>Ir a APROBAR SALIDAS</a>
			';
			
			notificacion_add (titular(nitavu_dpto($nitavu)), 'Pase para de '.$asunto.' de '.$fecha, $fecha, $nitavu, $m);
			
			mensaje ("Pase solicitado con exito, espere la notificación de aprobación.", 'auscencia4.php');
			//header('location:../index.php');	
			$h="".nitavu_nombre($nitavu)." (".$nitavu.") ha solicitado un pase de salida para <span class='tenue'>".$justificacion."</span>";
			$h = $h."para el dia ".$fecha_.". <img src='".$archivo."'>";
			historia($nitavu, $h);
	}
else
	{
			
			historia($nitavu, "ERROR | (".$sql.") al intentar guardar pase de salida");
			mensaje ("Error :".$sql,'');
	}



}/// fin de guardar oficial






 	echo "<div class='informativa'>";

 	
	
	$desde = strtotime ( '-1 day' , strtotime ( $fecha ) ) ;
	$desde = date ( 'Y-m-j' , $desde );

	$hasta = strtotime ( '+3 day' , strtotime ( $fecha ) ) ;
	$hasta = date ( 'Y-m-j' , $hasta );
	//echo $desde;
	
	//COLOCAR LISTA DE PASES Y SITUACION

	// echo pase_estado($nitavu, $desde, $hasta, "FALSE");
	


	echo "</div>";
		
	
?>

		<script src="http://code.jquery.com/jquery-1.12.1.min.js"></script>
		<script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>
		<script src="unica/timedropper.js"></script>
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
		
		  document.getElementById('foto_comision').addEventListener('change', archivo, false);
		</script>
    


<script>

function auscencia_fecha(){ //funcion para actualizar la fecha de la pagina para seleccionar el vale de comida
	fechavar = document.getElementById("fecha").value;
	window.location.href = "auscencia4.php?pes=comida&n=&fecha2="+fechavar;

}
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
<br><br>
<?php
include ("./unica/body_footer.php");
?>