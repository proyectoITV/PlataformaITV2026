<?php
//include (".//seguridad.php");
include ("./lib/body_head.php");
include ("./lib/body_menu.php");
// contenido:
?>
<?php
//PROCESO PARA TOCAR LA PUERTA DE SAN PEDRO
$id_aplicacion = 'ap04';
$nivel = aplicacion_nivel($id_aplicacion, $nitavu);	
echo "<div id='AppDetalle'>".app_detalle($id_aplicacion, $nitavu)."</div>";
//echo "Nivel: ".$nivel;
// ------------------------------------------------
//  Pueden generar pases dependiendo el nivel
//  1 - SuperAdmin =  Todos
//	2 -	Administrador =  Dependan de el (nivel titulares)
// 	3 - Operador =  Dpto
//-------------------------------------------------


	echo "<form action='auscencia3.php' method='POST' enctype='multipart/form-data' >";
	$nivel=2;
	$yo = '2772';
	$yo = $nitavu;
	if ($nivel==3){
			echo  "<div>";
			echo  "<label for='empleado'>Empleado de tu Dpto:</label>";
			echo  "<select name='empleado'>";
			$sql = "SELECT * FROM empleados WHERE dpto='".nitavu_dpto($yo)."' ORDER by nombre ASC";

			$r = $conexion -> query($sql); while($f = $r -> fetch_array()){
				if ($f['nitavu']<>$yo){echo  "<option value='".$f['nitavu']."'>".$f['nombre']."</option>";	}
						
			}
			echo "</select></div>";		
		}
	else {

		if ($nivel==2){
			echo  "<div>";
			echo  "<label for='empleado'>Empleado: Tiulares que dependen de ti</label>";
			echo  "<select name='empleado'>";
			//titulares:
				$sql = "SELECT * FROM cat_gerarquia WHERE dependencia='".nitavu_dpto($yo)."' ORDER by nombre ASC";
				$r = $conexion -> query($sql); while($f = $r -> fetch_array()){
					if ($f['titular']<>$yo){echo  "<option value='".$f['titular']."'>".nitavu_nombre($f['titular'])."</option>";}						
				}

				//dependientes de su dpto:
				$sql = "SELECT * FROM empleados WHERE dpto='".nitavu_dpto($yo)."' ORDER by nombre ASC";
				$r = $conexion -> query($sql); while($f = $r -> fetch_array()){
					if ($f['nitavu']<>$yo){echo  "<option value='".$f['nitavu']."'>".$f['nombre']."</option>";}
				}
			echo "</select></div>";		
		}

		else{
			if ($nivel==1){
			echo  "<div>";
			echo  "<label for='empleado'>Empleado de tu Dpto:</label>";
			echo  "<select name='empleado'>";
			$sql = "SELECT * FROM empleados ORDER by nombre ASC";

			$r = $conexion -> query($sql); while($f = $r -> fetch_array()){
				if ($f['nitavu']<>$yo){echo  "<option value='".$f['nitavu']."'>".$f['nombre']."</option>";	}
						
			}
			echo "</select></div>";		
			}


		}
	










		echo "<input name='empleados' value='' type='hidden'>";
}







	echo "</form>";


















?>

		<script src="http://code.jquery.com/jquery-1.12.1.min.js"></script>
		<script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>
		<script src="lib/timedropper.js"></script>
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
include ("./lib/body_footer.php");
?>