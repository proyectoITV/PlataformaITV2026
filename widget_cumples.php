<?php
$Widget_nombre = "<img src='icon/cumples.png' style='width:23px;'><b class='pc' style='color:#990000'> Cumpleaños de esta semana</b><b class='movil'>Cumples</b>";
$wc = "";
$empleados_sindpto_quienes = "";

//Obtiene el primer dia de la semana en curso y se proyectan los siguientes 7 dias
$r = $conexion->query('SELECT DATE(DATE_ADD(NOW(), INTERVAL - WEEKDAY(NOW()) DAY)) primerdia;');
while ($f = $r->fetch_array()) {
	$dia1 = strtotime($f['primerdia']);
	$dia2 = strtotime('+1 day', strtotime($f['primerdia']));
	$dia3 = strtotime('+2 day', strtotime($f['primerdia']));
	$dia4 = strtotime('+3 day', strtotime($f['primerdia']));
	$dia5 = strtotime('+4 day', strtotime($f['primerdia']));
	$dia6 = strtotime('+5 day', strtotime($f['primerdia']));
	$dia7 = strtotime('+6 day', strtotime($f['primerdia']));
}

$wc = $wc . '<style>
	@keyframes glow-border {
	  0% { border-color: rgba(0, 180, 216, 0.6); box-shadow: 0 0 5px rgba(0, 180, 216, 0.3); }
	  50% { border-color: #bc955c; box-shadow: 0 0 15px rgba(188, 149, 92, 0.8); }
	  100% { border-color: rgba(0, 180, 216, 0.6); box-shadow: 0 0 5px rgba(0, 180, 216, 0.3); }
	}

	@keyframes shimmer-sweep {
	  0% { left: -150%; }
	  50% { left: -150%; }
	  100% { left: 150%; }
	}

	@keyframes sparkle-float-1 {
	  0% { transform: translate(0, 0) scale(0) rotate(0deg); opacity: 0; }
	  50% { opacity: 1; }
	  100% { transform: translate(-20px, -30px) scale(1) rotate(180deg); opacity: 0; }
	}

	@keyframes sparkle-float-2 {
	  0% { transform: translate(0, 0) scale(0) rotate(0deg); opacity: 0; }
	  50% { opacity: 1; }
	  100% { transform: translate(20px, -25px) scale(1.1) rotate(-180deg); opacity: 0; }
	}

	@keyframes cake-bounce {
	  0%, 100% { transform: translateY(0) scale(1); }
	  50% { transform: translateY(-5px) scale(1.08); }
	}

	.cumples-informatica {
	  position: relative !important;
	  overflow: hidden !important;
	  border: 2px solid rgba(0, 180, 216, 0.6) !important;
	  border-radius: 8px !important;
	  background: linear-gradient(135deg, #ffffff 0%, #f0faff 100%) !important;
	  animation: glow-border 4s infinite ease-in-out !important;
	  padding: 10px !important;
	  margin-bottom: 12px !important;
	  transition: all 0.3s ease !important;
	}

	.cumples-informatica.parpadear {
	  background: linear-gradient(135deg, #e6fccf 0%, #c4f7b2 100%) !important;
	}

	.cumples-informatica::after {
	  content: "" !important;
	  position: absolute !important;
	  top: 0 !important;
	  height: 100% !important;
	  width: 50% !important;
	  background: linear-gradient(to right, rgba(255,255,255,0) 0%, rgba(255,255,255,0.7) 50%, rgba(255,255,255,0) 100%) !important;
	  transform: skewX(-25deg) !important;
	  animation: shimmer-sweep 3.5s infinite ease-in-out !important;
	  pointer-events: none !important;
	}

	.sparkle-container {
	  position: absolute !important;
	  top: 0 !important;
	  left: 0 !important;
	  width: 100% !important;
	  height: 100% !important;
	  pointer-events: none !important;
	  overflow: hidden !important;
	  background: transparent !important;
	}

	.sparkle {
	  position: absolute !important;
	  font-size: 13px !important;
	  color: #ffd700 !important;
	  opacity: 0 !important;
	  background: transparent !important;
	  text-shadow: 0 0 3px rgba(255, 215, 0, 0.7) !important;
	}

	.sparkle.s1 { top: 15%; left: 8%; animation: sparkle-float-1 2.5s infinite ease-in-out !important; }
	.sparkle.s2 { top: 65%; left: 82%; animation: sparkle-float-2 3s infinite ease-in-out 0.8s !important; }
	.sparkle.s3 { top: 10%; left: 78%; animation: sparkle-float-1 3.5s infinite ease-in-out 0.4s !important; }
	.sparkle.s4 { top: 75%; left: 12%; animation: sparkle-float-2 2.8s infinite ease-in-out 1.2s !important; }

	.animated-cake {
	  animation: cake-bounce 2.2s infinite ease-in-out !important;
	  filter: drop-shadow(0 2px 3px rgba(0,0,0,0.12)) !important;
	}

	.code-backdrop {
	  position: absolute !important;
	  font-family: Consolas, Monaco, monospace !important;
	  font-size: 8px !important;
	  color: rgba(0, 180, 216, 0.15) !important;
	  background: transparent !important;
	  bottom: 6px !important;
	  right: 8px !important;
	  pointer-events: none !important;
	  user-select: none !important;
	  text-align: right !important;
	  line-height: 1.1 !important;
	}
	</style>';

$wc = $wc . '<div id="slider_wid" >';

$sql = "
	SELECT * from empleados where estado = '' and 
	(
		month(fecha_nacimiento) = '" . date("m", $dia1) . "' and day(fecha_nacimiento) = '" . date("d", $dia1) . "'
		or 
		month(fecha_nacimiento) = '" . date("m", $dia2) . "' and day(fecha_nacimiento) = '" . date("d", $dia2) . "'
		or 
		month(fecha_nacimiento) = '" . date("m", $dia3) . "' and day(fecha_nacimiento) = '" . date("d", $dia3) . "'
		or 
		month(fecha_nacimiento) = '" . date("m", $dia4) . "' and day(fecha_nacimiento) = '" . date("d", $dia4) . "'
		or 
		month(fecha_nacimiento) = '" . date("m", $dia5) . "' and day(fecha_nacimiento) = '" . date("d", $dia5) . "'
		or 
		month(fecha_nacimiento) = '" . date("m", $dia6) . "' and day(fecha_nacimiento) = '" . date("d", $dia6) . "'
		or 
		month(fecha_nacimiento) = '" . date("m", $dia7) . "' and day(fecha_nacimiento) = '" . date("d", $dia7) . "'
	)
	ORDER BY  month(fecha_nacimiento), day(fecha_nacimiento), nombre
	";

$r = $conexion->query($sql);

while ($f = $r->fetch_array()) {
	$fecha_cumple = date('Y') . substr($f['fecha_nacimiento'], 4);

	if ($fecha_cumple >= $fecha) {
		$dep_name = isset($f['departamento']) ? $f['departamento'] : '';
		$dep_clean = str_replace(
			array('á', 'é', 'í', 'ó', 'ú', 'Á', 'É', 'Í', 'Ó', 'Ú'),
			array('a', 'e', 'i', 'o', 'u', 'a', 'e', 'i', 'o', 'u'),
			strtolower($dep_name)
		);
		$es_informatica = (
			in_array($f['nitavu'], [1308, 1733, 1739, 2269, 2330, 2933]) ||
			(strpos($dep_clean, 'informatica') !== false) ||
			(isset($f['dpto']) && $f['dpto'] == 55)
		);

		if ($fecha_cumple == $fecha) {
			if ($es_informatica) {
				$wc = $wc . '<div id="cumples" class="parpadear cumples-informatica" style="background-color:#E6FCCF;">';
			} else {
				$wc = $wc . '<div id="cumples" class="parpadear" style="background-color:#E6FCCF;">';
			}
		} else {
			if ($es_informatica) {
				$wc = $wc . '<div id="cumples" class="cumples-informatica">';
			} else {
				$wc = $wc . '<div id="cumples">';
			}
		}

		if ($es_informatica) {
			$wc = $wc . '<div class="sparkle-container">
					<span class="sparkle s1">✨</span>
					<span class="sparkle s2">✦</span>
					<span class="sparkle s3">✨</span>
					<span class="sparkle s4">✦</span>
				</div>';
			$wc = $wc . '<div class="code-backdrop">&lt;code&gt;<br>Happy_Bday();<br>&lt;/code&gt;</div>';
		}

		$wc = $wc . "<table border=0  width=100%><tr>";
		$wc = $wc . '<td width="50px">' . ponerfoto("fotos/" . $f['nitavu'] . ".jpg", 'cumples_img') . '</td>';
		$wc = $wc . '<td>';
		//$wc = $wc."<b class='tmediano normal'>".nombre_corto($f['nitavu'],0)."</b> ".nombre_corto($f['nitavu'],1)."<br>";
		$wc = $wc . "<b style='font-size:10pt;color:black'>" . strtoupper($f['nombre']) . "<br>";
		//$wc = $wc."<span class='tenue' style='font-size:8pt;'> ".$f['puesto']." de ".$f['departamento']."</span><br class='movil'>";	
		$wc = $wc . "<span style='font-size:9pt;color:#606060'> " . $f['departamento'] . "</span><br class='movil'><br>";
		//$wc = $wc."<span class='normal' style='font-size:10pt;'> ".fecha_larga($fecha_cumple)."</span><br>";
		$wc = $wc . "<span style='font-size:9pt;color:#606060''> " . fecha_larga($fecha_cumple) . "</span><br>";
		if ($es_informatica) {
			$wc = $wc . "
				<table border=0 style='margin-top: 5px; background: transparent;'>
					<tbody>
				  		<tr>
							<td valign='middle' style='padding-right: 8px;'><img class='animated-cake' src='icon/pastel.png' width='45' height='45' /></td>
							<td>
								<span style='font-size:9.5pt; color:#ab0033; font-weight: bold;'>¡Muchas FELICIDADES!</span><br>
								<span style='font-size:8.5pt; color:#333; line-height: 1.3;'>Que pases un excelente día. Te mandamos un fuerte abrazo de parte de tus compañeros y amigos del Departamento de Informática. 💻✨</span><br>
								<span style='font-size:8.5pt; color:#555; font-weight: bold; font-family: monospace;'>#TeamDevs</span>
							</td>
				  		</tr>
					</tbody>
			  	</table>";
		}
		$wc = $wc . '</td>';
		$wc = $wc . "</tr></table>";
		$wc = $wc . '</div>';
	}
}

$wc = $wc . '</div>';

$tmp = "";
$tmp = $tmp . "<section id='aplicaciones' class='widget'>";
$tmp = $tmp . "<label>" . $Widget_nombre . "</label>";
$tmp = $tmp . "<article >";
//$tmp = $tmp. "<a href=''>";
$tmp = $tmp . "<table border='0' width=100%><tr><td>";
$tmp = $tmp . $wc . "<br>";
$tmp = $tmp . "</td></tr></table></article>";

echo $tmp . "</section>";
?>