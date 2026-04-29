<?php
//include (".//seguridad.php"); 
include ("./lib/body_head.php");
include ("./lib/body_menu.php");

// contenido:
?>
<script>
function tiempo(){

var fecha= new Date();
var horas= fecha.getHours();
var minutos = fecha.getMinutes();
var segundos = fecha.getSeconds();


if (horas>12){
dn="PM";
horas=horas-12;
} else {
	dn = "AM";
}
document.getElementById('vigi_hora').innerHTML=horas;
document.getElementById('vigi_min').innerHTML=minutos;
document.getElementById('vigi_seg').innerHTML=segundos;
document.getElementById('vigi_dn').innerHTML=dn;

setTimeout('tiempo()',1);
}
setTimeout('tiempo()',10);
</script>

<?php

$id_aplicacion ="ap54"; //ap06=Permisos de Aplicacion
$nivel = aplicacion_nivel($id_aplicacion, $nitavu);
//$nivel = 2;
if (sanpedro($id_aplicacion, $nitavu)==TRUE){

	echo "<div id='AppDetalle'>".app_detalle($id_aplicacion, $nitavu)."</div>";
	echo"<div id='pendientes'>";
	historia($nitavu, "Vio los pendientes (direccion)");	
	if (isset($_GET['equipo'])){//si se ha seleccionado un equipo
	echo "<h1>Configurando <b class='ejecutandose'>".$_GET['equipo']."</b></h1>";
	//echo "<label></label>";

	if (isset($_GET['busqueda'])){
		echo "<div id='pendientes_nuevo_se' >";
		echo "<form action='pendientes_eq_n.php?equipo=".$_GET['equipo']."' method='POST'>";
		$sql = "SELECT * FROM empleados WHERE (nitavu='".$_GET['busqueda']."' or nombre like'%".$_GET['busqueda']."%'
		or departamento like'%".$_GET['busqueda']."%') limit 0,10";
		//echo $sql;
		echo "<span style='font-size:10pt; color: black; padding: 3px;'>Resultados de <b>".$_GET['busqueda']."</span></<br><br>";
		$r2 = $conexion -> query($sql); while($f = $r2 -> fetch_array())
			{
			if (estoy_enmesadetemas($f['nitavu'],$_GET['equipo'])==FALSE)
				{
				$archivo = 'fotos/'.$f['nitavu'].".jpg";
				echo "<article>";
				echo "<table width=100%><tr>";
				echo "<td style='background-color: #E3E2E2;' class='pc' width=30%>".ponerfoto($archivo, 'pendientes_foto1')."</td>";
				echo '<td><input type="checkbox" name="empleados[]" value="'.$f['nitavu'].'">'."</td>"; 
				echo "<td class=''><b style='font-size:8pt;'>".nitavu_nombre($f['nitavu'])."</b><label style='font-size:7pt;' class='pc'>".nitavu_puesto($f['nitavu'])." de ".nitavu_dpto_nombre($f['nitavu'])."</label></td>";
				echo "</tr>";
				// echo "<tr class='movil'><td colspan=2 style='font-size:8pt;'>";
				// echo nitavu_nombre($f['nitavu'])."</b>";
				// echo "</td></tr>";
				echo "</table>";
				echo "</article>";
				}
			}
		echo "<br><a href='pendientes_eq_n.php?equipo=".$_GET['equipo']."'>Buscar nuevamente </a>";
		echo "</div>";

		echo "<div id='pendientes_nuevo_te'>";
		echo "<b style='font-size:10pt;'>Integrantes actuales:</b>";		
		//echo "<label style='margin-top: -17px;' class='pc'>De clic en la <X> para eliminar la participacion</label>";
		$sql = "SELECT * FROM pendientes_eq WHERE nombre='".$_GET['equipo']."'";		
		echo "<table class=tabla width=100%>";
		$r2 = $conexion -> query($sql); while($f = $r2 -> fetch_array())		
			{	echo "<tr>";
				$archivo = 'fotos/'.$f['integrante'].".jpg";				
				echo "<td>".ponerfoto($archivo, 'pendientes_foto1')."</td>";
				echo "<td class='pc'>".nitavu_nombre($f['integrante']);
				echo "<label class='pc' style='font-size:8pt; margin-top:-2px;'>".nitavu_puesto($f['integrante'])." de ".nitavu_dpto_nombre($f['integrante'])."<br>Agregado el ".fecha_larga($f['fecha'])."</label>";
				echo "</td>";				
				echo "<td>";
				if ($f['creador']=='0'){
				echo "<a href='pendientes_eq_n.php?eliminar=".$f['integrante']."&equipo=".$_GET['equipo']."'><img src='icon/cancel.png' style='width:18px; height: 18px'></a>";
				}
				
				echo "</td>";
				echo "</tr>";
			}
		echo "</table>";
		


		echo "<input type='submit' name='submit__agregar' class='Mbtn btn-default' value='Agregar seleccionados al equipo'>";
		echo "</form>";
		echo "</div>";
	} else {
		echo '<div id="beta_buscar">';
		echo '<form action="pendientes_eq_n.php" method="get">';
		echo '<input type="hidden" name="equipo" value="'.$_GET['equipo'].'">';
		echo '<table broder="1" width="100%"><tr>';
			echo '<td>                    <input required="required" type="text" id="beta_buscar_input" name="busqueda" placeholder="Nombre del empleado (para agregar al equipo)" /></td>';
			echo '<td align="right" width="15px">                    
			<button id="beta_buscar_boton">
			<img  src="icon/buscar.png"></button>
			</td>';
		echo '</tr></table>';
		echo '</form>';
		echo '</div>';


		echo "<div style='display: inline-block; width: 40%; vertical-align:top;'>";
		echo "<h2>Estadistica del equipo:</h2>";
		echo "<br>Temas en actividad:";
		echo "<br>Temas terminados:";
		echo "<br>Grafica:";
		echo "</div>";

		echo "<div style='display: inline-block; width: 40%; vertical-align:top;'>";
		echo "<h1>Lista de participantes:</h1>";
		echo "<label style='margin-top: -17px;' class='pc'>De clic en la <X> para eliminar la participacion</label>";
		$sql = "SELECT * FROM pendientes_eq WHERE nombre='".$_GET['equipo']."'";		
		echo "<table class=tabla width=100%>";
		$r2 = $conexion -> query($sql); while($f = $r2 -> fetch_array())		
			{	echo "<tr>";
				$archivo = 'fotos/'.$f['integrante'].".jpg";				
				echo "<td>".ponerfoto($archivo, 'pendientes_foto1')."</td>";
				echo "<td class='pc'>".nitavu_nombre($f['integrante']);
				echo "<label class='pc' style='font-size:8pt; margin-top:-2px;'>".nitavu_puesto($f['integrante'])." de ".nitavu_dpto_nombre($f['integrante'])."<br>Agregado el ".fecha_larga($f['fecha'])."</label>";
				echo "</td>";				
				echo "<td>";
				if ($f['creador']=='0'){
				echo "<a href='pendientes_eq_n.php?eliminar=".$f['integrante']."&equipo=".$_GET['equipo']."'><img src='icon/cancel.png' style='width:18px; height: 18px'></a>";
				}
				
				echo "</td>";
				echo "</tr>";
			}
		echo "</table>";
		
		echo "<br>";
		echo "<br>";
		echo "</div>";

		if (isset($_GET['eliminar'])){
			$sql = "DELETE FROM pendientes_eq WHERE integrante='".$_GET['eliminar']."' and nombre='".$_GET['equipo']."'";
				//echo $sql; //comprobamos la sintaxis query
				if ($conexion->query($sql) == TRUE){
					historia($nitavu, "Elimino a ".nitavu_nombre($_GET['eliminar'])." de su equipo de la Mesa de Temas".$_GET['equipo']);
					$contenido = "Lamentamos informarte que <br><p><b>".nitavu_nombre($nitavu)."</b>, ".nitavu_puesto($nitavu)." de ".nitavu_dpto_nombre($nitavu).", te ha eliminado
					de su equipo ".$_GET['equipo']." de la Mesa de Temas.</p><p>Apartir de este punto, dejaras de recibir avisos ya sea por correo o via notificacion de lo referente a este equipo</p>";
					notificacion_add ($_GET['eliminar'], $_GET['equipo'], $fecha, $nitavu, $contenido);
					
				} else{ 
					historia($nitavu, "ERROR al agregar a ".nitavu_nombre($_GET['eliminar'])." al su equipo ".$_GET['equipo']." de la Mesa de Temas, SQL: ".$sql);
					
				}
				mensaje("Eliminado ".nitavu_nombre($_GET['eliminar'])." con exito",'pendientes_eq_n.php?equipo='.$_GET['equipo']);
		}

		if (isset($_POST['submit__agregar'])){
			$empleados = $_POST['empleados']; $msg="";$contenido="";
			foreach($empleados as $empleado){ //solo trae los seleccionados
			    $sql = "INSERT INTO pendientes_eq (integrante, nombre, fecha, hora, autorizo)
				VALUES ('$empleado', '".$_GET['equipo']."', '$fecha', '$hora', '$nitavu')";
				//echo $sql; //comprobamos la sintaxis query
				if ($conexion->query($sql) == TRUE){
					historia($nitavu, "Agrego a ".nitavu_nombre($empleado)." al su equipo ".$_GET['equipo']." de la Mesa de Temas");
					$contenido = "Buen dia <br><p>Te informamos que el <b>".nitavu_nombre($nitavu)."</b>, ".nitavu_puesto($nitavu)." de ".nitavu_dpto_nombre($nitavu).", te ha agregado
					a su equipo ".$_GET['equipo']." de la Mesa de Temas.</p><p>Apartir de este punto, la Plataforma te estara avisando ya sea por correo o via notificacion de lo referente a este equipo</p>";
					notificacion_add ($empleado, $_GET['equipo'], $fecha, $nitavu, $contenido);
					$msg = $msg.nitavu_nombre($empleado).", "; //acualizamos el mensaje
				} else{ 
					historia($nitavu, "ERROR al agregar a ".nitavu_nombre($empleado)." al su equipo ".$_GET['equipo']." en la Mesa de Temas SQL: ".$sql);
					$msg = $msg."Hubo un error al agregar a ".nitavu_nombre($empleado).", "; //acualizamos el mensaje
				}
			} mensaje("Se han agregado ".$msg." con exito al equipo ".$_GET['equipo'],'pendientes_eq_n.php?equipo='.$_GET['equipo']);
		}

	}
	
	
	// mostrar equipos creados por ti (a ref=enviarlo por get para su seleccion)
	echo "<br><br><br><hr>";
		$sql = "SELECT DISTINCT(nombre) FROM pendientes_eq WHERE autorizo='".$nitavu."' and nombre<>'".$_GET['equipo']."'";
		
		echo "<a style=' width:200px; padding: 5px; margin: 5px; display: inline-block; background-color:#AFCB2E;  border: 1px #DEDEDE solid; border-radiud: 8px;'
			href='pendientes_eq_n.php'>";
			echo "<table width=100%><tr>";
			echo "<td><img src='icon/home.png' style='width:23px; height:23px;'></td>";
			echo "<td>Mis Equipos</td>";
			echo "</tr></table>";
			echo "</a>";

		$r2 = $conexion -> query($sql); while($f = $r2 -> fetch_array())
			

			{ echo "<a style=' width:200px; padding: 5px; margin: 5px; display: inline-block; background-color:white;  border: 1px #DEDEDE solid; border-radiud: 8px;'
			href='pendientes_eq_n.php?equipo=".$f['nombre']."'>";
			echo "<table width=100%><tr>";
			echo "<td><img src='icon/pendientes_eq.png' style='width:23px; height:23px;'></td>";
			echo "<td>".$f['nombre']."</td>";
			echo "</tr></table>";
			echo "</a>";
			

			}


	} else {


		echo "<h1>Configurando <b class='ejecutandose'>Mis Equipos</b></h1>";
		echo "<label>Haga clic sobre el nombre de su equipo para agregar miembros y ves estadistica del equipo </label>";

		//seleccionar el equipo
		// mostrar equipos creados por ti (a ref=enviarlo por get para su seleccion)
		$sql = "SELECT DISTINCT(nombre)FROM pendientes_eq WHERE autorizo='".$nitavu."'";
		$r2 = $conexion -> query($sql); while($f = $r2 -> fetch_array())
			{ echo "<a style=' width:200px; padding: 5px; margin: 5px; display: inline-block; background-color:white;  border: 1px #DEDEDE solid; border-radiud: 8px;'
			href='pendientes_eq_n.php?equipo=".$f['nombre']."'>";
			echo "<table width=100%><tr>";
			echo "<td><img src='icon/pendientes_eq.png' style='width:23px; height:23px;'></td>";
			echo "<td>".$f['nombre']."</td>";
			echo "</tr></table>";
			echo "</a>";
			

			}
		echo "</div>";




		//crear nuevo equipo contigo como unico integrante para crearlo por primera vez

		echo "<div id='pendientes_eq_box' style='width:200px; display: inline-block' >";
			echo "<label>Crear equipo nuevo: </label>";
			echo "<form action='pendientes_eq_n.php' method='POST'>";
			echo "<input type='text' name='equipo' placeholder='Nombre del equipo'>";		
			echo "<input type='submit' name='submit_eq_n' value='Hacer' class='Mbtn btn-default'>";
			echo "</form>";
		echo "</div>";

		if (isset($_POST['submit_eq_n'])){
			$sql = "INSERT INTO pendientes_eq (nombre, integrante, autorizo, hora, fecha,creador) VALUES ('".$_POST['equipo']."', '".$nitavu."', '".$nitavu."', '".$hora."', '".$fecha."', '1')";
			if ($conexion->query($sql) == TRUE)
			{	historia($nitavu, "Creo el equipo <b>".$_POST['equipo']." para la Mesa de Temas.");
				mensaje ("Equipo creado con exito",'pendientes_eq_n.php');}
			else {historia($nitavu, "ERROR: al crear el equipo <b>".$_POST['equipo']." para la Mesa de Temas.");
				mensaje ("Ha habido un error al crear el exito ".$sql,'pendientes_eq_n.php');}

		}

	}

	echo "</div>";

	


	
}
else{mensaje("No tiene acceso a esta aplicacion.",'');}

?>












<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
<?php
include ("./lib/body_footer.php");



echo "<div id='iphone' style='height:800px; width:100%;' class='movil'></div>";

?>