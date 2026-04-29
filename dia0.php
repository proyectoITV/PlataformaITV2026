<?php include ("lib/body_head.php");include ("./lib/body_menu.php");?>



<?php 
$id_aplicacion ="ap83";
$nivel = aplicacion_nivel($id_aplicacion, $nitavu);

if (sanpedro($id_aplicacion, $nitavu)==TRUE){
    echo "<div id='AppDetalle'>".app_detalle($id_aplicacion, $nitavu)."</div>";	

    // xd_update($id_aplicacion,$nitavu);//guarda la experiencia del usuario
	// historia($nitavu, "Entro a la aplicacion, para dar permisos de acceso a Bloqueo Maestro");

	echo "<table width=100%>";
	echo "<tr>";
	echo "<td>";
	$sql="select 
	* 
	from diasinhabiles_Full ";
	TablaDinamica_MySQL("",$sql, "MiIdDivTabla2", "IdTabla2", "", 2); //0 = Basica, 1 = ScrollVertical, 2 = Scroll Horizontal

	echo "</td>";

	echo "<td width=30%>";
	
		echo "<div style='margin-top: 50px;' ></div> ";

		echo "<div id='req_mod' style='width:97%;' >";
		// echo "<div id='AppDetalle'><b>Otorgar permiso para usar Requisiciones</b></h>";

		echo "<form action='dia0.php' method='POST'>";
		
		echo "<div><label>Seleccione el dia inabil</label>";
		echo "<input type='date' name='dia0' value='".$fecha."'  class='form-control'></div>";

		echo "<br><span><label>Comentario o Justificación</label>";
		echo "<textarea  class='form-control' name='comentario' style='height:100px;'></textarea></span>";

		echo "<span><label>* Las aplicaciones en la plataforma reaccionaran a las fechas capturadas</label>";
		echo "<input type='submit' value='Crear dia inábil' class='Mbtn btn-default' name='BtnDia0'>";
		echo "</span>";
		echo "</form><br><br>";
		echo "</div>";
	echo "</td>";
	echo "</tr>";
	echo "</table>";





			

	if (isset($_POST['BtnDia0'])){
        $dia0 = $_POST['dia0'];
        $comentario = $_POST['comentario'];

		$sql = "INSERT INTO diasinhabiles (dia0, Autorizo, Fecha, Hora, Comentario) VALUES('$dia0','$nitavu','$fecha','$hora','$comentario')";
		if ($conexion->query($sql) == TRUE)
			{	historia($nitavu, "Agrego el dia inabil ".$_POST['dia0']." - ".$comentario);				
				mensaje("Dia inabil, guardado correctamente. El  ".fecha_larga($dia0)." ",'dia0.php');			}
		else {
		
			mensaje("ERROR: Ha ocurrido un error".$sql,'');
		}
		


	}

	if (isset($_GET['del'])){
		
		$sql = "DELETE FROM diasinhabiles WHERE Dia0='".$_GET['del']."'";
		if ($conexion->query($sql) == TRUE)
			{	historia($nitavu, "RETIRO el dia inabil de la plataforma a ".$_GET['del']);				
				mensaje("Fecha eliminada correctamente",'dia0.php');
			}
		else {
			
			mensaje("ERROR: Ha ocurrido un error".$sql,'dia0.php');
		}
	}


} else {Mensaje("ERROR: no tienes acceso a esta aplicacion","");}







?>

<?php 
docdigital_no(FALSE, 1); //ahorra 1 hoja
include ("lib/body_footer.php"); ?>


