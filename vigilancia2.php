<?php
//include (".//seguridad.php"); 
include ("./lib/body_head.php");
include ("./lib/body_menu.php");

// contenido:
?>

<?php
//PROCESO PARA TOCAR LA PUERTA DE SAN PEDRO
$id_aplicacion ="ap13"; //ap06=Permisos de Aplicacion
if (sanpedro($id_aplicacion, $nitavu)==TRUE){
	echo "<div id='AppDetalle'>".app_detalle($id_aplicacion, $nitavu)."</div>";
	//echo "<b><br><center>PERMISOS AUTORIZADOS PARA ".$fecha.":</center></b>";
	echo "<section id='vigilancia2'>";
	
	echo "<div id='botones-sup'>";
	echo "<table><tr>";
			echo "<form action='vigilancia.php' method='GET'>";	
			echo "<td valign='bottom' align='center'>";
					echo "<input type='text' name='id' PLACEHOLDER='Escribe aqui el No. de ITAVU para buscar'>";
			echo "</td>";
			echo "<td valign='bottom' align='center'>";
			echo "<input type='submit' value='Buscar' class='Mbtn btn-default'>";
			echo "</td>";
			echo "<td valign='bottom' align='center'>";
			echo "<a href='vigilancia.php' class='Mbtn btn-secundario'>Ver Todos </a>";
			echo "</td>";
			echo "</form>";
	echo "</tr></table>";
	echo "</div>";



	if (isset($_GET['id'])){ // separar consulta por nombre
		$sql = "SELECT * FROM empleados_salidas_temporal WHERE 
		(autorizo_nitavu<>'' AND solicito_fecha='".$fecha."' AND registro_entrada='00:00:00' AND rechazada='' AND nitavu LIKE'%".$_GET['id']."%') ORDER by registro_salida DESC";
	}
	else
	{
	$sql = "SELECT * FROM empleados_salidas_temporal WHERE 
	(autorizo_nitavu<>'' AND solicito_fecha='".$fecha."' AND registro_entrada='00:00:00' AND rechazada='') ORDER by registro_salida DESC";
	}


		//echo $sql;
		$rc= $conexion -> query($sql);
		$cuantos = $rc -> num_rows;

		if ($cuantos<=0) {
			$msgx="<b>NO SE ENCONTRO RESULTADOS EN LA BUSQUEDA</B><BR>

			Razones por las que no aparece:
			<lu>
			<li> No le han autorizado el pase (aparece en rechazados) </li>
			<li> Le dio clic por error, en el boton rojo de regreso o entro.</li>
			</lu>
			";
			mensaje($msgx,'vigilancia.php');
		}
		else
		{
			echo "<h1>Hay ".$cuantos." empleados con permiso de salida </h1>";
		}


		while($f = $rc -> fetch_array()) {
				echo "<article>";
				echo "<table><tr><td align='center'>";

				echo ponerfoto("fotos/".$f['nitavu'].".jpg",'');
				//echo "<div id='nombre_sombra' class=''>".nombre_corto($f['nitavu'])."</div>";
				echo "<div id='nombre' >".nombre_corto($f['nitavu'],0)."</div>";
				echo "<div id='ide' class=''>".$f['nitavu']."</div>";
				//echo "<div id='nombre_vertical' class='texto_vertical'>".nombre_corto($f['nitavu'],1)."</div>";
				
				echo "</td>";
				
				echo "<td align='center'>";

				
				$permiso = tiempo_restar_hr($f['hora_desde'], $f['hora_hasta']);
				echo $f['asunto']."<br>";

				if ($f['registro_salida']=='00:00:00') // sino ha salido
					{
						 echo "<strong class='normal grande'>".$permiso."min</strong>";
					}
				else
					 {
					// necesitoo sumarle a la hora actual + permiso, y despues ir restandole la hora actual.
					$hora_depermiso = tiempo_sumar_hr($permiso, $f['registro_salida']);
					$tiempo_restante = tiempo_restar_hr($hora,$hora_depermiso);

					//echo "(".$permiso.") desde ".$f['registro_salida']. " hasta las ".$hora_depermiso."<br>";
					
					if ($tiempo_restante>$permiso)
						{
							$sepaso= tiempo_restar_hr($tiempo_restante,$permiso);
							$sepaso =tiempo_restar_hr($permiso, $sepaso);
							echo "<strong class='alerta '>Retraso: <b class='grande'>".$sepaso."min</b></strong>";
						}
					else
						{
							echo "<strong class='ejecutandose'>".$tiempo_restante."min</strong>";
						}

				 }

				$tmp ="<label>Autorizado de ".$f['hora_desde']." a ".$f['hora_hasta']." <label>";
				echo $tmp;

								echo "<div id='botones'>";
								if ($f['registro_salida']=='00:00:00'){
								echo "<button class='Mbtn btn-default' onclick=location.href='vigilancia_salio.php?id=".$f['id']."'>";
										echo "Salio"; 							
								echo "</button>";
								}
								else
								{
									echo "<a class='Mbtn btn-cancel' href='vigilancia_entro.php?id=".$f['id']."'> Entro </a>";
									
								
								}
								echo "</div>";

				echo "</td>";
				echo "</tr></table>";
				echo "</article>";


				}





	echo "</section>";


}
else{echo "No tiene acceso a ".$id_aplicacion;}











?>




<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
<?php
include ("./lib/body_footer.php");
?>