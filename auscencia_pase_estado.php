<?php
//include (".//seguridad.php"); 
include ("./lib/body_head.php");
include ("./lib/body_menu.php");

// contenido:
?>

<?php
//PROCESO PARA TOCAR LA PUERTA DE SAN PEDRO
$id_aplicacion ="ap24"; //ap06=Permisos de Aplicacion
if (sanpedro($id_aplicacion, $nitavu)==TRUE){
	echo "<div id='AppDetalle'>".app_detalle($id_aplicacion, $nitavu)."</div>";
	
	echo "<form action='' method=GET>";
			$nivel = aplicacion_nivel('ap12', $nitavu);

			echo "<span>";
			echo "<label for='empleado'>Seleccione a quien le enviara un documento:";
			echo "<select name='empleado'>";
	
				$sql = "SELECT * FROM empleados ORDER by nombre ASC";
				$r = $conexion -> query($sql);
				while($f = $r -> fetch_array())
					{ // resultado de la busqueda.................
						if (isset($_GET['empleado'])){
							if ($_GET['empleado']==$f['nitavu']){
							echo "<option selected='selected' value='".$f['nitavu']."'>".$f['nombre']. " (".$f['puesto']." de ".$f['departamento'].")</option>";
							historia ($nitavu,"Vio estado de pases de ".$_GET['empleado']);
							}
							else
							{
								echo "<option value='".$f['nitavu']."'>".$f['nombre']. " (".$f['puesto']." de ".$f['departamento'].")</option>";		
							}	
						}
						else
						{
							echo "<option value='".$f['nitavu']."'>".$f['nombre']. " (".$f['puesto']." de ".$f['departamento'].")</option>";
							historia ($nitavu,"Vio estado de pases de todos");
						}
					
					
					}		
					echo "<option value='todos' selected='selected'>TODOS</option>";	
			echo "</select>";
			echo "</label>";
			echo "</span>";
			
		
				echo "<div>";
				echo "<div>";
				echo "<label>Desde:</label>";
				echo "<input type='date' name='desde' value='".$fecha."'>";
				echo "</div>";


				echo "<div>";
				echo "<label>Hasta:</label>";
				echo "<input type='date' name='hasta' value='".$fecha."'>";
				echo "</div>";		

		echo "</div>";
		

		echo "<div>";
		echo "<label>Haga clic aqui</label>";
		echo "<input type='submit' name='' value='Consultar' class='Mbtn btn-default'>";
		echo "</div>";
		




	
	echo "</form>";
	
	
	if (isset($_GET['empleado'])){

		if ($_GET['empleado']=='todos'){				
			echo pase_estado($nitavu, $_GET['desde'],$_GET['hasta'], "TRUE");
		}else
		{
		echo pase_estado($_GET['empleado'], $_GET['desde'], $_GET['hasta'], "FALSE");
		}
	}


	echo "</div>";
}
else{echo "No tiene acceso a ".$id_aplicacion;}











?>




<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
<?php
include ("./lib/body_footer.php");
?>