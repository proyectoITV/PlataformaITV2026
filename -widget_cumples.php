<?php
	$Widget_nombre="<img src='icon/cumples.png' style='width:23px;'><b class='pc' style='color:#990000'> Cumpleaños de esta semana</b><b class='movil'>Cumples</b>";
	$wc="";
	$empleados_sindpto_quienes="";

	$wc = $wc.'<div id="slider_wid" >';
	//$sql = "select * from empleados where WEEKOFYEAR(fecha_nacimiento) = WEEKOFYEAR(NOW()) And estado = '' order by date_format(fecha_nacimiento, '%d')";
	$sql = "
	SELECT * from empleados where estado = '' and 
	(
		month(fecha_nacimiento) = Month(DATE(DATE_ADD(DATE(NOW()), INTERVAL - WEEKDAY(NOW()) DAY)+0)) and day(fecha_nacimiento) = day(DATE(DATE_ADD(DATE(NOW()), INTERVAL - WEEKDAY(NOW()) DAY)+0))
		or 
		month(fecha_nacimiento) = Month(DATE(DATE_ADD(DATE(NOW()), INTERVAL - WEEKDAY(NOW()) DAY)+1)) and day(fecha_nacimiento) = day(DATE(DATE_ADD(DATE(NOW()), INTERVAL - WEEKDAY(NOW()) DAY)+1))
		or 
		month(fecha_nacimiento) = Month(DATE(DATE_ADD(DATE(NOW()), INTERVAL - WEEKDAY(NOW()) DAY)+2)) and day(fecha_nacimiento) = day(DATE(DATE_ADD(DATE(NOW()), INTERVAL - WEEKDAY(NOW()) DAY)+2))
		or 
		month(fecha_nacimiento) = Month(DATE(DATE_ADD(DATE(NOW()), INTERVAL - WEEKDAY(NOW()) DAY)+3)) and day(fecha_nacimiento) = day(DATE(DATE_ADD(DATE(NOW()), INTERVAL - WEEKDAY(NOW()) DAY)+3))
		or 
		month(fecha_nacimiento) = Month(DATE(DATE_ADD(DATE(NOW()), INTERVAL - WEEKDAY(NOW()) DAY)+4)) and day(fecha_nacimiento) = day(DATE(DATE_ADD(DATE(NOW()), INTERVAL - WEEKDAY(NOW()) DAY)+4))
		or 
		month(fecha_nacimiento) = Month(DATE(DATE_ADD(DATE(NOW()), INTERVAL - WEEKDAY(NOW()) DAY)+5)) and day(fecha_nacimiento) = day(DATE(DATE_ADD(DATE(NOW()), INTERVAL - WEEKDAY(NOW()) DAY)+5))
		or 
		month(fecha_nacimiento) = Month(DATE(DATE_ADD(DATE(NOW()), INTERVAL - WEEKDAY(NOW()) DAY)+6)) and day(fecha_nacimiento) = day(DATE(DATE_ADD(DATE(NOW()), INTERVAL - WEEKDAY(NOW()) DAY)+6))
	)
	ORDER BY  month(fecha_nacimiento), day(fecha_nacimiento), nombre
	";
	$r = $conexion -> query($sql);

	while($f = $r -> fetch_array()){
		$fecha_cumple = date('Y').substr($f['fecha_nacimiento'], 4);

		if ($fecha_cumple >= $fecha){
			if ($fecha_cumple == $fecha){$wc = $wc.'<div id="cumples" class="parpadear" style="background-color:#E6FCCF;">';} else {$wc = $wc.'<div id="cumples">';}
			$wc = $wc. "<table border=0  width=100%><tr>";
			$wc = $wc.'<td width="50px">'.ponerfoto("fotos/".$f['nitavu'].".jpg",'cumples_img').'</td>';
			$wc = $wc.'<td>';
			//$wc = $wc."<b class='tmediano normal'>".nombre_corto($f['nitavu'],0)."</b> ".nombre_corto($f['nitavu'],1)."<br>";
			$wc = $wc."<b style='font-size:10pt;color:black'>".strtoupper($f['nombre'])."<br>";
			//$wc = $wc."<span class='tenue' style='font-size:8pt;'> ".$f['puesto']." de ".$f['departamento']."</span><br class='movil'>";	
			$wc = $wc."<span style='font-size:9pt;color:#606060'> ".$f['departamento']."</span><br class='movil'><br>";	
			//$wc = $wc."<span class='normal' style='font-size:10pt;'> ".fecha_larga($fecha_cumple)."</span><br>";
			$wc = $wc."<span style='font-size:9pt;color:#606060''> ".fecha_larga($fecha_cumple)."</span><br>";
			if ($f['nitavu'] == 1308 or $f['nitavu'] == 1733 or $f['nitavu'] == 1739 or $f['nitavu'] == 2269 or $f['nitavu'] == 2330 or $f['nitavu'] == 2933 ){
				$wc = $wc."
				<table>
					<tbody>
				  		<tr>
							<td><img src='icon/pastel.png' width='40' height='40' /></td>
							<td><span class='tenue' style='font-size:9pt;color:#ab0033'>Muchas ¡FELICIDADES! de parte de tus compañeros y amigos del Departamento de Informática.</span></td>
				  		</tr>
					</tbody>
			  	</table>";
			}
			$wc = $wc.'</td>';
			$wc = $wc. "</tr></table>";
			$wc = $wc.'</div>';
		}
	}
	
	$wc = $wc.'</div>';

	$tmp="";
	$tmp = $tmp."<section id='aplicaciones' class='widget'>";
	$tmp = $tmp. "<label>".$Widget_nombre."</label>";
	$tmp = $tmp."<article >";
	//$tmp = $tmp. "<a href=''>";
	$tmp = $tmp. "<table border='0' width=100%><tr><td>";
	$tmp = $tmp.$wc."<br>";
	$tmp = $tmp. "</td></tr></table></article>";

	echo $tmp."</section>";
?>

