<?php
//include (".//seguridad.php"); 
include ("./lib/body_head.php");
include ("./lib/body_menu.php");

// contenido:
?>

<?php
//PROCESO PARA TOCAR LA PUERTA DE SAN PEDRO
$id_aplicacion ="ap14"; //ap06=Permisos de Aplicacion
if (sanpedro($id_aplicacion, $nitavu)==TRUE){

	xd_update('ap14',$nitavu);//guarda la experiencia del usuario
	historia($nitavu, "Entro a la aplicacion consultar Alertas de auscencia y ver tiempos de retardo [ap14]");

	echo "<div id='AppDetalle'>".app_detalle($id_aplicacion, $nitavu)."</div>";
	echo "<div id='r'>";

	
	
	echo "<form action='auscencia_alertas.php' method='POST' class='cuadro'>";

	//echo "<div>";
	
		echo "<div>";
		echo "<label>Desde</label>";
		echo "<input type='date' name='fecha_desde' value='".$fecha."'>";
		echo "</div>";
		

	
		echo "<div>";
		echo "<label>Hasta</label>";
		echo "<input type='date' name='fecha_hasta' value='".$fecha."'>";
		echo "</div>";

	
	//echo "</div>";
	//echo "<div>";
		echo "<div>";
		echo "<select name='detalle'>";
		echo "<option value='FALSE' selected='selected'>Sin detalle </div>";
		echo "<option value='TRUE'>Con detalle </div>";

		echo "</select>";
		echo "</div>";
	


	
	echo "<span>";
	echo "<label for='empleado'>Seleccione un empleado:";
	echo "<select name='empleado'>";
	
		$sql = "SELECT * FROM empleados ORDER by nombre ASC";
		$r = $conexion -> query($sql);
		while($f = $r -> fetch_array())
			{ // resultado de la busqueda.................
				echo "<option value='".$f['nitavu']."'>".$f['nombre']. " (".$f['puesto']." de ".$f['departamento'].")</option>";
				if (isset($_GET['id'])){
					if ($_GET['id']==$f['nitavu']){
						echo "<option value='".$f['nitavu']."' selected='selected'>".$f['nombre']. " (".$f['puesto']." de ".$f['departamento'].")</option>";
					}
				}
			}
			echo "<option value='todos' selected='selected'>Todos</option>";
	
	echo "</select>";
	echo "</label>";
	echo "</span>";


		
		
			echo "<div>";
			echo "<label>Trabajando con tolerancia de ".$tolerancia."min</label>";
			echo "<input type='submit' value='Aceptar' class='Mbtn btn-default' >";
			echo "</div>";

	//echo "</div>";
	

	echo "</form>";


if (isset($_POST['fecha_desde'])){
	$fecha_desde = $_POST['fecha_desde'];
	$fecha_hasta = $_POST['fecha_hasta'];
	//echo  $_POST['detalle'];

	$sql = "SELECT DISTINCT nitavu FROM empleados_salidas_temporal WHERE (registro_entrada>hora_hasta) AND 
	(solicito_fecha>='".$fecha_desde."') AND (solicito_fecha<='".$fecha_hasta."') ORDER by dpto ASC";
	//echo $sql;
	$rc= $conexion -> query($sql);
	//echo "<div id='vigilancia2'>";
	while($f = $rc -> fetch_array()) {
		if ($_POST['empleado']=='todos'){

		echo "<article>";
		echo "<table width='100%'><tr class='tabla_tr'><td class='tabla_tr' align='center' width='100px'>";

		echo ponerfoto("fotos/".$f['nitavu'].".jpg",'icono');
		echo "<br><b>".nitavu_nombre($f['nitavu']).":</b>";
		echo "</td><td>";
		if (pases_desfase($f['nitavu'], $fecha_desde, $fecha_hasta, $_POST['detalle']) ==''){
			echo "Dentro de la tolerancia ".$tolerancia;
		}
		else
		{
			echo pases_desfase($f['nitavu'], $fecha_desde, $fecha_hasta, $_POST['detalle']);
		}

		
		echo "</td></tr></table>";
		echo "</article>";
		}
		else {

			if ($_POST['empleado']==$f['nitavu'])
			{
				echo "<article>";
				echo "<table width='100%'><tr class='tabla_tr'><td class='tabla_tr' align='center' width='100px'>";

				echo ponerfoto("fotos/".$f['nitavu'].".jpg",'icono');
				echo "<br><b>".nitavu_nombre($f['nitavu']).":</b>";
				echo "</td><td>";
				if (pases_desfase($f['nitavu'], $fecha_desde, $fecha_hasta, $_POST['detalle']) ==''){
					echo "Dentro de la tolerancia ".$tolerancia;
				}
				else
				{
					echo pases_desfase($f['nitavu'], $fecha_desde, $fecha_hasta, $_POST['detalle']);
				}

				
				echo "</td></tr></table>";
				echo "</article>";
			}

		}
	}
	//echo "</div>";

}





	echo "</div>";
}
else{echo "No tiene acceso a ".$id_aplicacion;}











?>




<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
<?php
include ("./lib/body_footer.php");
?>