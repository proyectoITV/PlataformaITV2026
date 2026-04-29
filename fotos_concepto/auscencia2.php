<?php
//include ("./unica/seguridad.php");
include ("./unica/body_head.php");
include ("./unica/body_menu.php");
// contenido:
?>
<?php
//PROCESO PARA TOCAR LA PUERTA DE SAN PEDRO
$id_aplicacion = 'ap04';
mensaje_mantenimiento($nitavu, 'index.php');
echo "<h5>".app_detalle($id_aplicacion)."</h5>";

echo "<div id='pesta_elementos'>";
$mas="";
if (isset($_GET['n'])){
		$mas="&n=";
}
if (isset($_GET['pes'])) {
		if ($_GET['pes']=='comida'){
			echo "<a class='seleccionada' href='?pes=comida".$mas."'>COMIDA</a>";	
			echo "<a class='sinseleccion' href='?pes=otro".$mas."'>Otro Asunto</a>";	
			echo "<a class='sinseleccion' href='?pes=oficial".$mas."'>OFICIAL</a>";	
		}	
	}

if (isset($_GET['pes'])) {
		if ($_GET['pes']=='otro'){
			echo "<a class='sinseleccion' href='?pes=comida".$mas."'>COMIDA</a>";	
			echo "<a class='seleccionada' href='?pes=otro".$mas."'>Otro Asunto</a>";	
			echo "<a class='sinseleccion' href='?pes=oficial".$mas."'>OFICIAL</a>";	
		}	
	}


if (isset($_GET['pes'])) {
		if ($_GET['pes']=='oficial'){
			echo "<a class='sinseleccion' href='?pes=comida".$mas."'>COMIDA</a>";	
			echo "<a class='sinseleccion' href='?pes=otro".$mas."'>Otro Asunto</a>";	
			echo "<a class='seleccionada' href='?pes=oficial".$mas."'>OFICIAL</a>";	
		}	
	}



echo "</div>";


$nivel = aplicacion_nivel('ap12', $nitavu);	
$botontext ="";
$entec = "";
if ($nivel=='1' OR $nivel=='2' OR $nivel=='3'){
		$entec = $entec. "<input type='hidden' name='jefe' value='".$nitavu."'>";
		$entec = $entec. "<input type='hidden' name='jefe_nivel' value='".$nivel."'>";
		$botontext = " y aprobar";
}

		if (isset($_GET['n']) ){
			$nivel = aplicacion_nivel('ap12', $nitavu);
			//$entec = "";
			$entec = $entec. "<span>";
			$entec = $entec. "<label for='empleado'>Empleado:";
			$entec = $entec. "<select name='empleado'>";

			$sql = "SELECT * FROM empleados WHERE nitavu='".$nitavu."' ORDER by nombre ASC";
	
			if ($nivel == '3') {// si es jefe que salgan solo sus empleados
				$sql = "SELECT * FROM empleados WHERE departamento='".nitavu_dpto($nitavu)."' ORDER by nombre ASC";
			}

			if ($nivel == '1' OR $nivel =='2') {
				$sql = "SELECT * FROM empleados ORDER by nombre ASC";
			}

				$r = $conexion -> query($sql);
				$mas2="";
				while($f = $r -> fetch_array())
					{ // resultado de la busqueda.................
						
						if ($f['nitavu']==$nitavu){$mas2="selected='selected'";}else {$mas2="";}						
						$entec = $entec. "<option ".$mas2." value='".$f['nitavu']."'>".$f['nombre']." (".$f['puesto']." de ".$f['departamento'].")</option>";
		
						
					}
			
			$entec = $entec. "</select>";
			$entec = $entec. "</label>";
			$entec = $entec. "</span>";

			
				}
		if ($nivel=='1' OR $nivel=='2' OR $nivel=='3'){}else{
		$entec =  "<input type='hidden' name='empleado' value='".$nitavu."' readonly='readonly'>";
		
		}







if (isset($_GET['pes'])) {
	if ($_GET['pes']=='comida'){echo "<div id='pesta_comida' class='pesta visible'>";	}
	else
	{echo "<div id='pesta_comida' class='pesta invisible'>";}
}


	
	echo "<form action='auscencia_comida_valida.php' method='post' name='auscencia_temporal' enctype='multipart/form-data' >";
		//echo $nivel;
		
		echo $entec;
		
		echo "<div>";
				echo "<label>Cuanto tiempo tomara:</label>";
				echo "<select name='fecha_' readonly='readonly'>";
					echo "<option value='".$fecha."' selected='selected'>".fecha_larga($fecha)."</option>";
				echo "</select>";
		
		echo "</div>";


		
		echo "<div>";
				echo "<label>A que hora saldra:</label>";
				$horasalida = date('H:i:s',strtotime ( '+60 minute' , strtotime ( $hora ) )) ;
				echo "<input class='ejecutanse' type='text' name='hr_salida' id='hr_salida' onchange='tiempo()' value='".$horasalida."'>";
               // echo "<input type='text' name='hr_salida' id='alarm'>";
                                 //step='3600' brinca cada hora
		echo "</div>";

		

		echo "<div>";
				echo "<label>Cuanto tiempo tomara:</label>";
				echo "<select name='tiempo'>";
					echo "<option value='00:30:00' selected='selected'>30 min</option>";
					echo "<option value='01:00:00' >1 hr</option>";
					echo "<option value='01:30:00' >1 30hr</option>";
					echo "<option value='02:00:00' >2 hr</option>";
					echo "<option value='02:30:00' >2 30 hr</option>";
					echo "<option value='03:00:00' >3 hr</option>";
				echo "</select>";
		
		echo "</div>";

		echo "<div>";
				echo "<label>Tipo de asunto:</label>";
				echo "
				<select name='asunto' readonly='readonly'>
					<option value='COMIDA' selected='selected'>PARA COMIDA O ALMUERZO</option>					
				</select>";

		echo "</div>";
		

				echo "<div>";
					echo "<label for='submit'>";
					echo "Solicitar tambien para el proximo:";
					
					$fecha1 = strtotime ( '+1 day' , strtotime ( $fecha ) ) ;
					$fecha1 = date('Y-m-d',$fecha1);
					$dia1 = dia_semana2($fecha1);
					
					$fecha2 = strtotime ( '+2 day' , strtotime ( $fecha ) ) ;
					$fecha2 = date('Y-m-d',$fecha2);
					//$dia2 = date('l', strtotime($fecha2));
					$dia2 = dia_semana2($fecha2);
					
					$fecha3 = strtotime ( '+3 day' , strtotime ( $fecha ) ) ;
					$fecha3 = date('Y-m-d',$fecha3);
					$dia3 = dia_semana2($fecha3);
					
					$fecha4 = strtotime ( '+4 day' , strtotime ( $fecha ) ) ;
					$fecha4 = date('Y-m-d',$fecha4);
					$dia4 = dia_semana2($fecha4);
					
					$fecha5 = strtotime ( '+5 day' , strtotime ( $fecha ) ) ;
					$fecha5 = date('Y-m-d',$fecha5);
					$dia5 = dia_semana2($fecha5);
					
					echo "<table><tr>";

					if (($dia1=="Sab") OR ($dia1=="Dom")){
					echo '<td valing="top"><input type="checkbox" name="dia1" value="" readonly="readonly"></td><td valing="top" class="alerta">'.$dia1."</td>";
						}
					else {
					echo '<td valing="top"><input type="checkbox" name="dia1" value="'.$fecha1.'"></td><td valing="top" class="normal"> '.$dia1."</td>";}


					if (($dia2=="Sab") OR ($dia2=="Dom")){
					echo '<td valing="top"><input type="checkbox" name="dia2" value="" readonly="readonly"></td><td valing="top" class="alerta">'.$dia2."</td>";
						}
					else {
					echo '<td valing="top"><input type="checkbox" name="dia2" value="'.$fecha2.'"></td><td valing="top" class="normal"> '.$dia2."</td>";}

					if (($dia3=="Sab") OR ($dia3=="Dom")){
					echo '<td valing="top"><input type="checkbox" name="dia3" value="" readonly="readonly"></td><td valing="top" class="alerta">'.$dia3."</td>";
						}
					else {
					echo '<td valing="top"><input type="checkbox" name="dia3" value="'.$fecha3.'"></td><td valing="top" class="normal"> '.$dia3."</td>";}

					if (($dia4=="Sab") OR ($dia4=="Dom")){
					echo '<td valing="top"><input type="checkbox" name="dia4" value="" readonly="readonly"></td><td valing="top" class="alerta">'.$dia4."</td>";
						}
					else {
					echo '<td valing="top"><input type="checkbox" name="dia4" value="'.$fecha4.'"></td><td valing="top" class="normal"> '.$dia4."</td>";}															


					if (($dia5=="Sab") OR ($dia5=="Dom")){
					echo '<td valing="top"><input type="checkbox" name="dia5" value="" readonly="readonly"></td><td valing="top" class="alerta">'.$dia5."</td>";
						}
					else {
					echo '<td valing="top"><input type="checkbox" name="dia5" value="'.$fecha5.'"></td><td valing="top" class="normal"> '.$dia5."</td>";}



					echo "</tr></td></table>";
					echo "</label>";
					echo "<input type='submit' name='submit' value='Solicitar ".$botontext."' class='btn btn-default' >";
					echo "</div>";

	
			echo "<div>";
		echo "<a href='img/como_reloj.jpg'><img src='img/como_reloj.jpg' class='foto'></a>";
		echo "</div>";
		echo "</div>";
	echo "</form>";


echo "</div>"; //pestaña de la comida fin



if (isset($_GET['pes'])) {
	if ($_GET['pes']=='otro'){echo "<div id='pesta_otro' class='pesta visible'>";	}
	else
	{echo "<div id='pesta_otro' class='pesta invisible'>";}
}

echo "<form action='auscencia_otro_valida.php' method='post' name='auscencia_temporal' enctype='multipart/form-data'>";
		echo "";

		echo $entec;
		echo "<div>";
				echo "<label>Fecha:</label>";
				echo "<input type='date' name='fecha_' value='".$fecha."' required='required' placeholder'YYYY-MM-DD'>";
		echo "</div>";
		
		echo "<div>";
				echo "<label>Hora de salida:</label>";
				$horasalida = date('H:i:s',strtotime ( '+60 minute' , strtotime ( $hora ) )) ;
				echo "<input type='text' name='otro_hr_salida' id='otro_hr_salida' onchange='tiempo()' value='".$horasalida."' required='required' placeholder='HH:MM:SS' >";
		echo "</div>";
		
		echo "<div>";
				echo "<label>Hora de regreso:</label>";
				$hora2 = date('H:i:s',strtotime ( '+30 minute' , strtotime ( $horasalida ) )) ;
				//$hora2 =  $hora2);
				//$hora2 = $hora + 30;
				echo "<input type='text' name='otro_hr_regreso' id='otro_hr_regreso' onchange='tiempo()' value='".$hora2."' required='required' placeholder='HH:MM:SS' >";
		echo "</div>";



		echo "<div>";
				echo "<label>Tipo de asunto:</label>";
				echo "
				<select name='asunto'>
					<option value='PERSONAL' selected='selected'>Personal</option>
				</select>";

		echo "</div>";
		

		echo "<div>";
				echo "<label>Foto para justificar (receta, cita medica, etc..):</label>";
				echo "<input type='file' name='auscencia_file' value='' >";
		echo "</div>";


		echo "<div>";
				echo "<label>Justificacion o motivo:</label>";
				echo "<textarea name='justificacion' ></textarea>";
		echo "</div>";
		
		
				
				//echo sugerencia("Recuerde hacerlo con tiempo, antes de la fecha solicitada. <br> Este permiso pasa directamente al Dpto. de  Recursos Humanos.");
					
				


				echo "<div>";
					echo "<label for='submit'>";				
					echo "</label>";
					echo "<input type='submit' name='submit' value='Solicitar ".$botontext."' class='btn btn-default' >";
				echo "</div>";

		

	echo "</form>";
echo "</div>"; // pestaña otro














if (isset($_GET['pes'])) {
	if ($_GET['pes']=='oficial'){echo "<div id='pesta_oficial' class='pesta visible'>";	}
	else
	{echo "<div id='pesta_oficial' class='pesta invisible'>";}
}

echo "<form action='auscencia_oficial_valida.php' method='post' name='auscencia_temporal' enctype='multipart/form-data'>";
		echo "";

		echo $entec;
		echo "<div>";
				echo "<label>Fecha:</label>";
				echo "<input type='date' name='fecha_' value='".$fecha."' required='required' placeholder'YYYY-MM-DD'>";
		echo "</div>";
		
		echo "<div>";
				echo "<label>Hora de salida:</label>";
				$horasalida = date('H:i:s',strtotime ( '+60 minute' , strtotime ( $hora ) )) ;
				echo "<input type='text' name='oficial_hr_salida' id='oficial_hr_salida' onchange='tiempo()' value='".$horasalida."' required='required' placeholder='HH:MM:SS' >";
		echo "</div>";
		
		echo "<div>";
				echo "<label>Hora estimada de regreso:</label>";
				$hora2 = date('H:i:s',strtotime ( '+30 minute' , strtotime ( $horasalida ) )) ;
				//$hora2 =  $hora2);
				//$hora2 = $hora + 30;
				echo "<input type='text' name='oficial_hr_regreso' id='oficial_hr_regreso' onchange='tiempo()' value='".$hora2."' required='required' placeholder='HH:MM:SS' >";
		echo "</div>";



		echo "<div>";
				echo "<label>Tipo de asunto:</label>";
				echo "
				<select name='asunto'>
					<option value='OFICIAL' selected='selected'>OFICIAL</option>
				</select>";

		echo "</div>";
		

		echo "<div>";
				echo "<label>Foto para justificar (receta, cita medica, etc..):</label>";
				echo "<input type='file' name='auscencia_file' value='' >";
		echo "</div>";


		echo "<div>";
				echo "<label>Justificacion o motivo:</label>";
				echo "<textarea name='justificacion' ></textarea>";
		echo "</div>";
		
		
				
				//echo sugerencia("Recuerde hacerlo con tiempo, antes de la fecha solicitada. <br> Este permiso pasa directamente al Dpto. de  Recursos Humanos.");
					
				


				echo "<div>";
					echo "<label for='submit'>";				
					echo "</label>";
					echo "<input type='submit' name='submit' value='Solicitar ".$botontext."' class='btn btn-default' >";
				echo "</div>";

		

	echo "</form>";
echo "</div>"; // pestaña otro











 	echo "<div class='informativa'>";

 	
	
	$desde = strtotime ( '-1 day' , strtotime ( $fecha ) ) ;
	$desde = date ( 'Y-m-j' , $desde );

	$hasta = strtotime ( '+3 day' , strtotime ( $fecha ) ) ;
	$hasta = date ( 'Y-m-j' , $hasta );
	//echo $desde;
	echo pase_estado($nitavu, $desde, $hasta, "FALSE");
	


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