<?php
//include (".//seguridad.php");
include ("./lib/body_head.php");
include ("./lib/body_menu.php");
// contenido:
?>
<div id="documentar"><br>
	<?php
	//PROCESO PARA TOCAR LA PUERTA DE SAN PEDRO
	$id_aplicacion ="ap17"; //Id de la aplicacion a cargar
	if (sanpedro($id_aplicacion, $nitavu)==TRUE){
		echo "<div id='AppDetalle'>".app_detalle($id_aplicacion, $nitavu)."</div><br>";
		// span ocupa 100% y Div 50%;
		echo "<form action='soporte_ext_valida.php' method='POST'>";
			echo "<input type='hidden' name='nitavu_' value='".$nitavu."'>";
			
			
			if (isset($_GET['n'])) {
				$nitavu_ = $_GET['n'];
			}
			else
			{
				$nitavu_="";
			}
			echo "<span>";
				echo "<label for='empleado'>Responsable de la Extension:";
					echo "<select name='empleado'>";
						
							$sql = "SELECT * FROM empleados  where estado='' ORDER by nombre ASC";
							
							$r = $conexion -> query($sql);
							while($f = $r -> fetch_array())
								{ // resultado de la busqueda.................
									
									if ($f['telefono_extension']==''){
										if ($f['nitavu']==$nitavu_){
												echo "<option value='".$f['nitavu']."' selected='selected'>".$f['nombre']. "</option> ";
											}
										else
											{
												echo "<option value='".$f['nitavu']."'>".$f['nombre']. "</option>";
											}
									}
									else
									{
										if ($f['nitavu']==$nitavu_){
											echo "<option value='".$f['nitavu']."' selected='selected'>".$f['nombre']." (".$f['telefono']." ext ".$f['telefono_extension'].")"."</option>";
											}
										else
											{
											echo "<option value='".$f['nitavu']."'>".$f['nombre']." (".$f['telefono']." ext ".$f['telefono_extension'].")"."</option>";
											}
									}
									
								}
						
					echo "</select>";
				echo "</label>";
			echo "</span>";
			echo "<div>";
					echo "<div>";
						echo "<label for='telefono'>Telefono:</label>";
						echo "<input type='tel' name='telefono' id='telefono' value='".nitavu_tel($nitavu_)."'>";
					echo "</div>";
				
					echo "<div>";
						echo "<label for='telefono'>Extension de telefono:</label>";
						echo "<input type='tel' name='telefono_ext' id='telefono_extension' value='".nitavu_tel_ext($nitavu_)."'>";
					echo "</div>";
			echo "</div>";
			echo "<div>";
					echo "<label> </label>";
					echo "<div><input type='submit' value='Guardar' class='Mbtn btn-default'></div>";
			echo "</div>";
			echo '
				<div id="sugerencias">
					<table border="0"><tr>
						<td><img src="./icon/sugerencia.png" class="icono"></td>
						<td>
								<b>Tip:</b>De clic sobre el nombre de la lista del directorio actual, para seleccionar.
						</td></tr></table>
					</div>
				';
				
				echo "<div id='directorio'>";
					echo "<div id='AppDetalle' style='position:initial;margin-bottom:0px;'>Directorio Actual:</div>";					
					echo "<table class='tabla'><tr class='tabla_titulo'>";
						echo "<td>Nombre</td>";
						echo "<td>Telefono</td>";
						echo "<td>Extension</td>";
					echo "</tr>";
						$sql = "SELECT * FROM empleados WHERE (telefono_extension<>'' AND estado='') ORDER by telefono_extension ASC";
						//echo $sql;
						$r = $conexion -> query($sql);
						while($f = $r -> fetch_array())
							{ // resultado de la busqueda.................
								echo "<tr class='tabla_tr'>";
									echo "<td ><a href='soporte_ext.php?n=".$f['nitavu']."'>".$f['nombre']."</a></td>";
									echo "<td >".$f['telefono']."</td>";
									echo "<td >".$f['telefono_extension']."</td>";
								echo "</tr>";
							
								
							}
				echo "</table>";
			echo "</div>";
		}
		else{
			mensaje("Sin autorizacion para este apartado",'');
		}

	?>
</div>
<br><br><br><br><br>
<?php
include ("./lib/body_footer.php");
?>