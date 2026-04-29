<?php
//include (".//seguridad.php");
include ("./lib/body_head.php");
include ("./lib/body_menu.php");
// contenido:
?>
<div id="documentar">
	<?php
	//PROCESO PARA TOCAR LA PUERTA DE SAN PEDRO
	$id_aplicacion ="ap28"; //Id de la aplicacion a cargar
	if (sanpedro($id_aplicacion, $nitavu)==TRUE){
		echo "<div id='AppDetalle'>".app_detalle($id_aplicacion, $nitavu)."</div>";

		if (isset($_POST['empleado'])){ // si esta presente en post empleado grabamos
				//echo "OK";
				$id = $_POST['empleado'];
				$id_delegacion = $_POST['delegacion'];
				$sql = "INSERT INTO notificaciones_config
						(id, delegacion_id, nombre)
						VALUES
						('$id','$id_delegacion', '".delegacion_id($id_delegacion)."')";
						if ($conexion->query($sql) == TRUE)
						{
							//mensaje("Se guardo correctamente",'notificadores_config.php');
						}
						else
						{
							mensaje("Ha habido un error: ".$sql,'notificadores_config.php');
							//echo $sql;
						}
			}


		if (isset($_GET['xid']) AND isset($_GET['xdel'])){ // si estan presentes en xid y xdel, le dio clic a eliminar
			//echo "LISTO PARA ELIMINAR";


				$id = $_GET['xid'];
				$id_delegacion = $_GET['xdel'];
				$sql = "DELETE FROM notificaciones_config WHERE (id='$id' AND delegacion_id='$id_delegacion')";
						if ($conexion->query($sql) == TRUE)
						{
							//mensaje("Se le ha retirado correctamente la asignacion",'notificadores_config.php');
						}
						else
						{
							mensaje("Ha habido un error",'notificadores_config.php');
							//echo $sql;
						}


		}



		// span ocupa 100% y Div 50%;
		echo "<form action='notificadores_config.php' method='POST'>";
		echo "<input type='hidden' name='nitavu_' value='".$nitavu."'>";

			
			
			
			
			echo "<div>";
				echo "<label for='empleado'>Seleccione a un empleado de las delegaciones:";
					echo "<select name='empleado'>";


							$sql = "SELECT * FROM empleados WHERE  (departamento like '%Delegacion%') ORDER by nombre ASC";
							$r = $conexion -> query($sql);
							while($f = $r -> fetch_array())
								{ // resultado de la busqueda.................
									$p = explode(" ",$f['departamento']); 
									$n =  $p[0]; // esto muestra la primera palabra 
									if ($n=='Coordinacion'){
											//echo "........";
									}
									else{
									echo "<option value='".$f['nitavu']."' >".$f['nombre']. " (".$f['departamento'].")</option> ";
									}
								}
						
					echo "</select>";
				echo "</label>";
			echo "</div>";




			echo "<div>";
			echo "<label for='delegacion'>Seleccione la delegacion para asignarle:";
			echo "<select name='delegacion'>";

			$sql ="SELECT DISTINCT departamento FROM empleados WHERE  (departamento like '%Delegacion%') order by departamento ASC";
			$r2 = $conexion -> query($sql);
			while($f = $r2 -> fetch_array())
				{//Categorias de Aplicaciones

					$p = explode(" ",$f['departamento']); 
					$n =  $p[0]; // esto muestra la primera palabra 

					$p2 = explode(" ",$f['departamento']); 
					$lugar =  $p[1]; // esto muestra la primera palabra 

					//echo $n."==<br>";
					if ($n=='Coordinacion'){
						//echo "........";
					}
					else{
					$ido = busca_id_delegacion($lugar);
					echo "<option value='".$ido."'>".$f['departamento']." </option>";
				
					}
				
				}				
			echo "</select>";
			echo "</label>";
			echo "</div>";



			echo "<div>";
			echo "<input type='submit' value='Asignar' class='Mbtn btn-default'>";
			echo "</div>";


		//echo sugerencia("asdkasd");
			echo "<hr>";


			$sql ="SELECT * FROM notificaciones_config order by id ASC";
			$r2 = $conexion -> query($sql);
			$c = 0;
			$tmp="
			<table class='tabla'>
			<tr>
				<th>Nombre</th>
				<th>Delegacion Asignada</th>
				<th></th>

			</tr>
			";
			$tmp2="";
			while($f = $r2 -> fetch_array())
				{//Categorias de Aplicaciones

					$tmp2 =  $tmp2. "<tr>";
					$tmp2 =  $tmp2. "<td>".nitavu_nombre($f['id'])." de ".midelegacion($f['id'])."</td>";
					$tmp2 =  $tmp2. "<td>".delegacion_id($f['delegacion_id'])."</td>";
					$tmp2 =  $tmp2. "<td>"."<a class='alerta' href='notificadores_config.php?xid=".$f['id']."&xdel=".$f['delegacion_id']."'>Eliminar</a></td>";
				
					$tmp2 =  $tmp2. "</tr>";
				
				$c=$c+1;
				}		
			if ($c<=0){
				echo "<h3>Actualmente no hay ningun empleado con asignaciones extra </h3>";

			}else{
				echo "<h3>Actualmente hay ".$c." empleados con asignaciones extra </h3>";
				echo $tmp.$tmp2."</table>";

			}


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