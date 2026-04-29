<?php
//include (".//seguridad.php");
include ("./lib/body_head.php");
include ("./lib/body_menu.php");
// contenido:
?>

	<?php
	//PROCESO PARA TOCAR LA PUERTA DE SAN PEDRO
	$id_aplicacion ="ap18"; //Id de la aplicacion a cargar
if (sanpedro($id_aplicacion, $nitavu)==TRUE){
		echo "<div id='AppDetalle'>".app_detalle($id_aplicacion, $nitavu)."</div>";
			xd_update('ap18',$nitavu);//guarda la experiencia del usuario
			historia($nitavu, "Entro a la aplicacion [ap18], Para ver el Directorio ");


		//echo "<span class='movil'>Da clic sobre el numero de telefono para marcar</span>";
				echo "<div id='directorio_m'>";
				echo "<div id='directorio'>";
	
	
	echo "<div id='botones-sup'>";
		buscar('directorio.php', '¿A quien buscas?','');
	echo "</div>";
	echo "<table class='tabla'>";
	if (isset($_GET['busqueda'])){// si busco a alguien
		//$sql = "SELECT * FROM empleados WHERE (nombre LIKE'%".$_GET['busqueda']."%' or puesto LIKE'%".$_GET['busqueda']."%' or departamento LIKE'%".$_GET['busqueda']."%' or direccion LIKE'%".$_GET['busqueda']."%') AND estado='' ORDER by NOMBRE ASC";
		$sql = "SELECT nitavu, empleados.nombre,puesto,departamento,telefono,telefono_extension,
		cat_gerarquia.nombre as departamento2 
		FROM empleados inner join cat_gerarquia on  empleados.dpto=cat_gerarquia.id
		WHERE (empleados.nombre LIKE'%".$_GET['busqueda']."%' or empleados.puesto 
		LIKE'%".$_GET['busqueda']."%' or cat_gerarquia.nombre  LIKE'%".$_GET['busqueda']."%') AND empleados.estado='' ORDER by NOMBRE ASC";
		historia($nitavu, "Uso la aplicacion [ap18], DIRECTORIO; buscando a ".$_GET['busqueda']);

	}
	else
	{
		$sql="SELECT nitavu, empleados.nombre,puesto,departamento,telefono,telefono_extension,
		cat_gerarquia.nombre as departamento2 FROM empleados inner join cat_gerarquia on  empleados.dpto=cat_gerarquia.id
		WHERE (empleados.telefono<>'' and empleados.estado='') ORDER by empleados.NOMBRE ASC";
	
		//$sql = "SELECT * FROM empleados WHERE (telefono<>'' and estado='') ORDER by NOMBRE ASC";
	}
	//echo $sql;
					$c=0;
						$r = $conexion -> query($sql);
						while($f = $r -> fetch_array())
							{ // resultado de la busqueda.................
								$c=$c+1;
								echo "<tr class='tabla_tr'>";
									echo "<td class='pc' width='20px'>";
										echo ponerfoto("fotos/".$f['nitavu'].".jpg",'foto_redonda2');
									echo "</td>";
									echo "<td align='left' width='30%'>";
										
									echo "<span class='movil'>".ponerfoto("fotos/".$f['nitavu'].".jpg",'foto_redonda2')."</span><br>";
									echo "<span class='movil'><b class='grande'>".$f['nombre']." "."</b></span>";


									echo "<span class='pc'><b class='grande'>".$f['nombre']."</b></span>";


									echo "<span class='pc'> <span class='tenue'>".$f['puesto']." de ".$f['departamento2']."</span></span>";
									echo "</td>";
									echo "<td >";

									echo "<table class='tabla_limpia'>";
									echo "<tr><td class='tabla_limpia'>";
												echo "<img src='icon/tel.png' class='icono_dir'>";
									echo "</td><td class='tabla_limpia'>";
											echo "<a class='grande' href='tel:".limpiar_tel($f['telefono'])."'>".$f['telefono']." Ext. "."".$f['telefono_extension']."</a>";
									echo "</td>";
									echo "</tr>";

										
								

									if (soytitular($nitavu)=='FALSE'){
										
									}
									else
										 {
										 	if ($f['telefono2']<>''){								

												echo "<tr><td class='tabla_limpia'>";
															echo "<img src='icon/tel.png' class='icono_dir'>";
												echo "</td><td class='tabla_limpia'>";
														echo "<a class='grande' href='tel:".limpiar_tel($f['telefono2'])."'>".$f['telefono2']."</a>";
												echo "</td>";
												echo "</tr>";
											}

												if ($f['telefono_movil']<>''){
												echo "<tr><td class='tabla_limpia'>";
															echo "<img src='icon/movil.png' class='icono_dir'>";
												echo "</td><td class='tabla_limpia'>";
														echo "<a class='grande' href='tel:".limpiar_tel($f['telefono_movil'])."'>".$f['telefono_movil']."</a>";
												echo "</td>";
												echo "</tr>";
											}

										 }
									



									echo "</table>";
									
									

									echo "</td>";
								echo "</tr>";
							
								
							}
				echo "</table>";
				echo "<label>* para ver el Celular, se require ser titular de dpto, dir o del.</label>";
				if ($c<=0){
					historia($nitavu, "Uso la aplicacion [ap18], DIRECTORIO; buscando a ".$_GET['nombre']." sin encontrar resultados");
					mensaje("No se encontraron resultados sobre lo que buscabas. Puedes intentarlo nuevamente, usando el segundo nombre ó apellido",'directorio.php');
				}
			echo "</div>";echo "</div>";
			historia($nitavu, "Utilizo el Directorio ");
		} else {
			mensaje("ERROR: sin acceso a esta aplicacion","");
		}
	?>

<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
<?php
include ("./lib/body_footer.php");
?>