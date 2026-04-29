<?php
//include (".//seguridad.php");
include ("./lib/body_head.php");
include ("./lib/body_menu.php");
// contenido:
?>
<?php
//PROCESO PARA TOCAR LA PUERTA DE SAN PEDRO
$id_aplicacion = 'ap04';
echo "<div id='AppDetalle'>".app_detalle($id_aplicacion, $nitavu)."</div>";
	echo "<form action='auscencia_valida.php' method='post' name='auscencia_temporal' enctype='multipart/form-data'>";
		echo "";
		//echo "<div>";
				//echo "<label>Tipo:</label>";
				echo "<input type='hidden' name='tipo' value='temporal' readonly='readonly'>";
		//echo "</div>";
		echo "<div>";
				echo "<label>Fecha:</label>";
				echo "<input type='date' name='fecha_' value='".$fecha."' required='required' placeholder'YYYY-MM-DD'>";
		echo "</div>";
		
		echo "<div>";
				echo "<label>Hora de salida:</label>";
				$horasalida = date('H:i:s',strtotime ( '+60 minute' , strtotime ( $hora ) )) ;
				echo "<input type='text' name='hr_salida' id='hr_salida' onchange='tiempo()' value='".$horasalida."' required='required' placeholder='HH:MM:SS' >";
		echo "</div>";
		
		echo "<div>";
				echo "<label>Hora de regreso:</label>";
				$hora2 = date('H:i:s',strtotime ( '+30 minute' , strtotime ( $horasalida ) )) ;
				//$hora2 =  $hora2);
				//$hora2 = $hora + 30;
				echo "<input type='text' name='hr_regreso' id='hr_regreso' onchange='tiempo()' value='".$hora2."' required='required' placeholder='HH:MM:SS' >";
		echo "</div>";

		echo "<div>";
				echo "<label>Tiempo estimado (minutos):</label>";
				echo "<input type='text' name='txt_tiempo' id='txt_tiempo' value='30' required='required' placeholder='HH:MM:SS' readonly='readonly'>";
		echo "</div>";

		echo "<div>";
				echo "<label>Tipo de asunto:</label>";
				echo "
				<select name='asunto'>
					<option value='personal' selected='selected'>Personal </option>
					<option value='OFICIAL' >Oficial </option>
				</select>";

		echo "</div>";
		

		echo "<div>";
				echo "<label>Foto para justificar (receta, cita medica, etc..):</label>";
				echo "<input type='file' name='auscencia_file' value='' >";
		echo "</div>";


		echo "<div>";
				echo "<label>Justificacion o motivo:</label>";
				echo "<textarea name='justificacion' required='required'></textarea>";
		echo "</div>";
		
		echo "<div>";

				
				echo sugerencia("Recuerde hacerlo con tiempo para que pueda ser autorizado a tiempo. Puede incluso solicitarlo a una fecha posterior");
					
				


				echo "<div>";
					echo "<label for='submit'>";
					echo "Solicitar tambien para el proximo:";
					
					$fecha1 = strtotime ( '+1 day' , strtotime ( $fecha ) ) ;
					$fecha1 = date('Y-m-d',$fecha1);
					$dia1 = dia_semana($fecha1);
					
					$fecha2 = strtotime ( '+2 day' , strtotime ( $fecha ) ) ;
					$fecha2 = date('Y-m-d',$fecha2);
					//$dia2 = date('l', strtotime($fecha2));
					$dia2 = dia_semana($fecha2);
					
					$fecha3 = strtotime ( '+3 day' , strtotime ( $fecha ) ) ;
					$fecha3 = date('Y-m-d',$fecha3);
					$dia3 = dia_semana($fecha3);
					
					$fecha4 = strtotime ( '+4 day' , strtotime ( $fecha ) ) ;
					$fecha4 = date('Y-m-d',$fecha4);
					$dia4 = dia_semana($fecha4);
					
					$fecha5 = strtotime ( '+5 day' , strtotime ( $fecha ) ) ;
					$fecha5 = date('Y-m-d',$fecha5);
					$dia5 = dia_semana($fecha5);
					
					echo "<table><tr>";

					if (($dia1=="Sabado") OR ($dia1=="Domingo")){
					echo '<td valing="top"><input type="checkbox" name="dia1" value="" readonly="readonly"></td><td valing="top" class="alerta">'.$dia1."</td>";
						}
					else {
					echo '<td valing="top"><input type="checkbox" name="dia1" value="'.$fecha1.'"></td><td valing="top" class="normal"> '.$dia1."</td>";}


					if (($dia2=="Sabado") OR ($dia2=="Domingo")){
					echo '<td valing="top"><input type="checkbox" name="dia2" value="" readonly="readonly"></td><td valing="top" class="alerta">'.$dia2."</td>";
						}
					else {
					echo '<td valing="top"><input type="checkbox" name="dia2" value="'.$fecha2.'"></td><td valing="top" class="normal"> '.$dia2."</td>";}

					if (($dia3=="Sabado") OR ($dia3=="Domingo")){
					echo '<td valing="top"><input type="checkbox" name="dia3" value="" readonly="readonly"></td><td valing="top" class="alerta">'.$dia3."</td>";
						}
					else {
					echo '<td valing="top"><input type="checkbox" name="dia3" value="'.$fecha3.'"></td><td valing="top" class="normal"> '.$dia3."</td>";}

					if (($dia4=="Sabado") OR ($dia4=="Domingo")){
					echo '<td valing="top"><input type="checkbox" name="dia4" value="" readonly="readonly"></td><td valing="top" class="alerta">'.$dia4."</td>";
						}
					else {
					echo '<td valing="top"><input type="checkbox" name="dia4" value="'.$fecha4.'"></td><td valing="top" class="normal"> '.$dia4."</td>";}															


					if (($dia5=="Sabado") OR ($dia5=="Domingo")){
					echo '<td valing="top"><input type="checkbox" name="dia5" value="" readonly="readonly"></td><td valing="top" class="alerta">'.$dia5."</td>";
						}
					else {
					echo '<td valing="top"><input type="checkbox" name="dia5" value="'.$fecha5.'"></td><td valing="top" class="normal"> '.$dia5."</td>";}



					echo "</tr></td></table>";
					echo "</label>";
					echo "<input type='submit' name='submit' value='Solicitar' class='Mbtn btn-default' >";
				echo "</div>";

		echo "</div>";

	echo "</form>";

 	echo "<span>";
 	echo "SOLICITUDES PENDIENTES QUE LE APRUEBEN:<BR>";
	
	$tmp_normales = "";

	$sql = "SELECT * FROM empleados_salidas_temporal WHERE (nitavu='".$nitavu."' AND autorizo_nitavu='') ORDER by solicito_fecha, solicito_hora ASC";
	$r = $conexion -> query($sql);
	//$r_count = $r -> num_rows;

if ($r -> num_rows >0)
		{
		
		$tmp_retraso ="";
		while($f = $r -> fetch_array())
			{ // resultado de la busqueda.................
			$lapso = tiempo_restar_hr($f['hora_desde'], $f['hora_hasta']);
			//$tiempo_derespuesta = tiempo_restar_fecha($f['fecha'], $fecha);
			$tmp_normales = $tmp_normales."<li><b>".fecha_larga($f['solicito_fecha'])."</b> de ".$lapso." a las ".$f['hora_desde']." (".$f['asunto'].")</lu>";

			}
		}
		else
		{
			echo "No tienes solicitudes pendientes";
		}
		
	
	echo "<p> ";
	echo "<lu>".$tmp_normales."</lu><br><br></p>";



	echo "</span>";
		
	
?>
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
<br><br>
<?php
include ("./lib/body_footer.php");
?>