<?php
//include (".//seguridad.php"); 
include ("./lib/body_head.php");
include ("./lib/body_menu.php");

// contenido:
?>
<div id="documentar">

<?php

//PROCESO PARA TOCAR LA PUERTA DE SAN PEDRO
$id_aplicacion ="ap15"; //Id de la aplicacion a cargar
//if (sanpedro($id_aplicacion, $nitavu)==TRUE){
	echo "<div id='AppDetalle'>".app_detalle($id_aplicacion, $nitavu)."</div>";
	// span ocupa 100% y Div 50%;

	$nivel = aplicacion_nivel($id_aplicacion, $nitavu);


	echo "<form action='visitas_registro_valida.php' method='POST'>";
	echo "<input type='hidden' name='nitavu_' value='".$nitavu."'>";
	
	echo "<div>";
			echo "<label>Nombre de la Visita</label>";
			echo "<input name='visita_nombre' type='text'>";
	echo "</div>";

	if ($nivel==3){
			echo sugerencia("Coteje y verifique el nombre con la identificacion");

			echo "<span>";
				echo "<label>asunto:</label>";
				echo "<input name='visita_asunto' type='text'>";
			echo "</span>";
	}
	else {
			echo "<div>";
				echo "<label>asunto:</label>";
				echo "<input name='visita_asunto' type='text'>";
			echo "</div>";

	}
			
	echo "<span>";
	echo "<label for='empleado'>Personal al que visita:";
	echo "<select name='personal'>";
	
		$sql = "SELECT * FROM empleados ORDER by nombre ASC";
		$r = $conexion -> query($sql);
		while($f = $r -> fetch_array())
			{ // resultado de la busqueda.................
				if ($f['nitavu']==$nitavu){
				echo "<option selected='selected' value='".$f['nitavu']."'>".$f['nombre']. " (".$f['puesto']." de ".$f['departamento'].")</option>";
				}
				else {
				echo "<option value='".$f['nitavu']."'>".$f['nombre']. " (".$f['puesto']." de ".$f['departamento'].")</option>";	
				}
				
			}
				
	echo "</select>";
	echo "</label>";
	echo "</span>";


		echo "<div>";
			echo "<div>";
			echo "<label>Fecha</label>";
			echo "<input name='visita_fecha' type='date' value='".$fecha."'>";
			echo "</div>";

			echo "<div>";
			echo "<label>Hora</label>";
			echo "<input name='visita_hr' type='time' value='".$hora."'>";
			echo "</div>";

	echo "</div>";


	echo "<div>";
			echo "<label>De clic en registrar y espere la autorizacion.</label>";
			echo "<input  type='submit' value='Registrar' class='Mbtn btn-default'>";
	echo "</div>";

	echo "</form>";

	if ($nivel==1){
	echo "<span class='panel_administrador'>";
	echo "<div id='AppDetalle'>Super Administrador: <cite>Puede aprobar cualquier visita</cite></div>";
		echo "<div id='r'>";
		$sql = "SELECT * FROM visitas WHERE (autorizo_nitavu='') ORDER by fecha, hora ASC";
		$r = $conexion -> query($sql);
		while($f = $r -> fetch_array())
			{ // resultado de la busqueda.................
				echo "<div id='resultado_elemento'>";
				echo "<table border='0'><tr>";
						echo "<td><b>".$f['nombre']."</b></td>";
						echo "<td>".$f['asunto']."</td>";
						$tmp = "";
						if ($f['fecha']==$fecha) {
								echo "<td>Nos visita hoy mismo a las ".$f['hora']."</td>";	
						}
						else
						{
							echo "<td>Nos visita ".$f['fecha']." a ".$f['hora']."</td>";
						}
					echo "<td> Visita a ".user_legend($f['nitavu_quienvisita'])."";
						
							echo "<br><br><b> Permiso solicitado </b>por ".user_legend($f['solicita_nitavu'])." a las ".$f['solicita_fecha']." el ".$f['solicita_fecha']."</td>";


						
						echo "<td width='10px'>";
							echo "<button class='Mbtn btn-default' onclick=location.href='visita_autoriza_ok.php?id=".$f['id']."'>";
							echo "<img src='icon/ok.png' class='mini_icono'>";		
							echo "</button><br><br>";


							echo "<button class='Mbtn btn-cancel' onclick=location.href='visita_autoriza_x.php?id=".$f['id']."'>"; 
							echo "<img src='icon/cancel.png' class='mini_icono'>";		
							echo "</button>";							

						echo "</td>";
				echo "</tr></table>";
				echo "</div>";
			}
		echo "</div>";
	echo "</span>";
	}



	if ($nivel==2){
		echo "<span class='panel_administrador'>";
		echo "<div id='AppDetalle'>Administrador: <cite>Puede aprobar visitas de su departamento</cite></div>";
		echo "<div id='r'>";
		$dpto = nitavu_dpto($nitavu);
		$sql = "SELECT * FROM visitas WHERE (autorizo_nitavu='' AND dpto='$dpto') ORDER by fecha, hora ASC";
		$r = $conexion -> query($sql);
		while($f = $r -> fetch_array())
			{ // resultado de la busqueda.................
				echo "<div id='resultado_elemento'>";
				echo "<table border='0'><tr>";
						echo "<td><b>".$f['nombre']."</b></td>";
						echo "<td>".$f['asunto']."</td>";
						$tmp = "";
						if ($f['fecha']==$fecha) {
								echo "<td>Nos visita hoy mismo a las ".$f['hora']."</td>";	
						}
						else
						{
							echo "<td>Nos visita ".$f['fecha']." a ".$f['hora']."</td>";
						}
						echo "<td> Visita a ".user_legend($f['nitavu_quienvisita'])."";
						
							echo "<br><br><b> Permiso solicitado </b>por ".user_legend($f['solicita_nitavu'])." a las ".$f['solicita_fecha']." el ".$f['solicita_fecha']."</td>";



						echo "<td width='10px'>";
						echo "<button class='Mbtn btn-default' onclick=location.href='visita_autoriza_ok.php?id=".$f['id']."'>";
							echo "<img src='icon/ok.png' class='mini_icono'>";		
							echo "</button><br><br>";


							echo "<button class='Mbtn btn-cancel' onclick=location.href='visita_autoriza_x.php?id=".$f['id']."'>"; 
							echo "<img src='icon/cancel.png' class='mini_icono'>";		
							echo "</button>";							

						echo "</td>";
				echo "</tr></table>";
				echo "</div>";
			}
		echo "</div>";
		echo "</span>";
		}

//}
//else
//{
//		mensaje("No tiene acceso a esta aplicacion ".$id_aplicacion,'');
//}



		
?>
</div>
<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
<?php
include ("./lib/body_footer.php");
?>