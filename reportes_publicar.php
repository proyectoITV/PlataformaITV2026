<?php include ("./lib/body_head.php"); include ("./lib/body_menu.php");  ?>
<script languaje="javascript"> 
function popup(){ 
  document.getElementById("modalModificar").style.visibility="visible";  
} 
function cerrar(){
  document.getElementById("modalModificar").style.visibility="hidden";
}
</script> 
<?php
require("config.php");
$id_aplicacion = 'ap50';
echo "<div id='AppDetalle'>".app_detalle($id_aplicacion, $nitavu)."</div>";
//PROCESO PARA TOCAR LA PUERTA DE SAN PEDRO
$id_aplicacion ="ap50"; //ap07=Permisos de Aplicacion
$nivel =aplicacion_nivel($id_aplicacion, $nitavu);

$id = $_GET['id'];
$nitavu = $_GET['nitavu'];

reporteshistoria($nitavu, $id);

  /*-------------MODAL PARA COMENTARIOS DE MODIFICAR---------*/
  echo "<div id='ventanaModificar' class='MyModal'>";
  echo "<form action='reporteador.php' method='POST'>";
  echo "<h3 style='color:#575A5D'>Modificar Reporte</h3>";
  echo "<br>";
  echo "<label>Describe la razón para modificar el reporte:</label>";
  echo "<textarea name='comentariosModificar' style=' height:20%;' ></textarea>";
  echo "<br><br><br>";
  echo "<input type='hidden' value='".$id."' name='MR1'>";
  echo "<input class='Mbtn btn-default' id='boton' type='submit' value='Enviar'>";
  echo "</form>";
  echo "</div>";


echo "<table style='width:100%; height: 100%;'>";
echo "<tr>";
echo "<td id='tdRep1'>";
echo "<div id='divpublicarrep2'>";

//Dar permisos DE VER REPORTE
if (isset($_GET['busqueda'])){
		echo "<div id='pendientes_nuevo_se' >";
		echo "<form action='reportes_publicar.php?flag='TRUE'' method='GET'>";
		$sql = "SELECT * FROM empleados WHERE (nitavu='".$_GET['busqueda']."' or nombre like'%".$_GET['busqueda']."%'
		or departamento like'%".$_GET['busqueda']."%') limit 0,10";
		//echo $sql;
		echo "<span style='font-size:10pt; color: black; padding: 3px;'>Resultados de <b>".$_GET['busqueda']."</span></<br><br>";
		$r2 = $conexion -> query($sql); while($f = $r2 -> fetch_array())
			{	
				$archivo = 'fotos/'.$f['nitavu'].".jpg";
				echo "<article>";
				echo "<table width=100%><tr>";
				echo "<td style='background-color: #E3E2E2;' class='pc' width=30%>".ponerfoto($archivo, 'pendientes_foto1')."</td>";
				echo '<td><input type="checkbox" name="empleados[]" value="'.$f['nitavu'].'">'."</td>"; 
				echo "<td class=''><b style='font-size:8pt;'>".nitavu_nombre($f['nitavu'])."</b><label style='font-size:7pt;' class='pc'>".nitavu_puesto($f['nitavu'])." de ".nitavu_dpto_nombre($f['nitavu'])."</label></td>";
				echo "</tr>";
				echo "</table>";
				echo "</article>";
			}
		echo "<input type='hidden' value='".$id."' name='id'>";	
		echo "<input type='hidden' value='".$nitavu."' name='nitavu'>";	
		echo "<br><a href='reportes_publicar.php?id=".$id."&nitavu=".$nitavu."'>Buscar nuevamente </a>";
		echo "</div>";

		echo "<div id='pendientes_nuevo_te'>";
		echo "<b style='font-size:10pt;'>Actualmente ellos pueden ver este reporte:</b>";		
		//echo "<label style='margin-top: -17px;' class='pc'>De clic en la <X> para eliminar la participacion</label>";
		$sql = "SELECT * FROM reportes_eq WHERE nombre='".$id."'";		
		echo "<table class=tabla width=100%>";
		$r2 = $conexion -> query($sql); while($f = $r2 -> fetch_array())		
			{	echo "<tr>";
				$archivo = 'fotos/'.$f['integrante'].".jpg";				
				echo "<td>".ponerfoto($archivo, 'pendientes_foto1')."</td>";
				echo "<td class='pc'>".nitavu_nombre($f['integrante']);
				echo "<label class='pc' style='font-size:8pt; margin-top:-2px;'>".nitavu_puesto($f['integrante'])." de ".nitavu_dpto_nombre($f['integrante'])."<br>Agregado el ".fecha_larga($f['fecha'])."</label>";
				echo "</td>";				
				echo "<td>";
				echo "<a href='reportes_publicar.php?eliminar=".$f['integrante']."&id=".$id."&nitavu=".$nitavu."'><img src='icon/cancel.png' style='width:18px; height: 18px'></a>";
				echo "</td>";
				echo "</tr>";
			}
		echo "</table>";
		echo "<input type='submit' name='submit__agregar' class='Mbtn btn-default' value='Agregar seleccionados'>";
		echo "</form>";
		echo "</div>";
	} else {
        echo "<h3>Comparte este reporte y Despues haz clic en <b>Recibir Reporte</b> </h3>";
		echo '<div id="beta_buscar">';
        echo '<form action="reportes_publicar.php?id='.$id.'&nitavu='.$nitavu.'" method="get">';
		echo '<table broder="1" width="100%"><tr>';
			echo '<td>                    <input required="required" type="text" id="beta_buscar_input" name="busqueda" placeholder="Nombre del empleado" /></td>';
			echo '<td align="right" width="15px">                    
			<button id="beta_buscar_boton">
			<img  src="icon/buscar.png"></button>
			</td>';
		echo '</tr></table>';
		echo "<input type='hidden' value='".$id."' name='id'>";	
		echo "<input type='hidden' value='".$nitavu."' name='nitavu'>";	
		echo '</form>';
		echo '</div>';
		echo "<div style='display: inline-block; width: 40%; vertical-align:top;'>";
		echo "</div>";
		//Para agregar a un miembro y pueda ver un reporte.
		if (isset($_GET['submit__agregar'])){
			$empleados = $_GET['empleados']; $msg="";$contenido="";
			foreach($empleados as $empleado){ //solo trae los seleccionados
			    $sql = "INSERT INTO reportes_eq (integrante, nombre, fecha, hora, autorizo)
				VALUES ('$empleado', '".$id."', '$fecha', '$hora', '$nitavu')";
				//echo $sql; //comprobamos la sintaxis query
				
				if ($conexion->query($sql) == TRUE){
					historia($nitavu, 'Compartio el reporte con "'.nitavu_nombre($empleado).'"');
					$contenido = "Buen día <br><p>Te informamos que el <b>".nitavu_nombre($nitavu)."</b>, ".nitavu_puesto($nitavu)." de ".nitavu_dpto_nombre($nitavu).", ha compartido contigo
					un reporte llamado ".reporte_nombre($id).".</p><p>Apartir de ahora podrás visualizarlo en la sección reportes de la Plataforma";
					notificacion_add($empleado,'Nuevo Reporte para visualizar: '.reporte_nombre($id).'', $fecha, $nitavu, $contenido);
					$msg = $msg.nitavu_nombre($empleado).", "; //actualizamos el mensaje

					$sql2 = "SELECT * FROM reportespermisos WHERE solicita =".$empleado." and idRepSolicitado = ".$id."";
					//echo $sql2;
					$permiso="";
					if ($rc= $conexion -> query($sql2)); while($f = $rc -> fetch_array()){
						$permiso = $f['solicita'].'/';              
					}
					$per = explode('/',$permiso);
					for ($i=0; $i < count($per) ; $i++) { 
						if($empleado == $per[$i]){
						//CUANDO CAMBIA EN 1 ES QUE YA TIENE LOS PERMISOS 
							$sql1 = "UPDATE reportespermisos SET estado=1 WHERE idRepSolicitado='".$id."'";
							if($conexion->query($sql1)==TRUE){
								return mensaje('Se autorizo con éxito. ','reporteador.php');
							}
					   }
					
					}
					
				} else{ 
					historia($nitavu, "ERROR al agregar a ".nitavu_nombre($empleado)." a visualizar el reporte llamado ".reporte_nombre($id).", SQL: ".$sql);
					$msg = $msg."Hubo un error al agregar a ".nitavu_nombre($empleado).", "; //acualizamos el mensaje
				}
			} mensaje("Se han agregado ".$msg." con éxito.","reportes_publicar.php?id=".$id."&nitavu=".$nitavu."");
		}

		//Para eliminar un empleado.
		if (isset($_GET['eliminar'])){
			$sql = "DELETE FROM reportes_eq WHERE integrante='".$_GET['eliminar']."' and nombre='".$_GET['id']."'";
				//echo $sql; //comprobamos la sintaxis query
			if ($conexion->query($sql) == TRUE){
				historia($nitavu, "Elimino a ".nitavu_nombre($_GET['eliminar'])."");
				$contenido = "Lamentamos informarte que <br><p><b>".nitavu_nombre($nitavu)."</b>, ".nitavu_puesto($nitavu)." de ".nitavu_dpto_nombre($nitavu).", te ha eliminado de la lista
				de participantes y ahora no podrás visualizar el reporte en el que estabas incluido.";
				notificacion_add($_GET['eliminar'],'Eliminado de vizualizar reporte: '.reporte_nombre($_GET['id']).'', $fecha, $nitavu, $contenido);
			} else{ 
				historia($nitavu, "ERROR al agregar a ".nitavu_nombre($_GET['eliminar']).", SQL: ".$sql);
			}
			mensaje("Eliminado ".nitavu_nombre($_GET['eliminar'])." con éxito","reportes_publicar.php?id=".$id."&nitavu=".$nitavu."");
		}
    }
echo "<br>";
echo "<br>";

echo "<div id='pendientes_nuevo_te'>";
		echo "<b style='font-size:10pt;'>Actualmente ellos pueden ver este reporte:</b>";		
		$sql = "SELECT * FROM reportes_eq WHERE nombre='".$id."'";		
		echo "<table class=tabla width=100%>";
		$r2 = $conexion -> query($sql); while($f = $r2 -> fetch_array())		
			{	echo "<tr>";
				$archivo = 'fotos/'.$f['integrante'].".jpg";				
				echo "<td>".ponerfoto($archivo, 'pendientes_foto1')."</td>";
				echo "<td class='pc'>".nitavu_nombre($f['integrante']);
				echo "<label class='pc' style='font-size:8pt; margin-top:-2px;'>".nitavu_puesto($f['integrante'])." de ".nitavu_dpto_nombre($f['integrante'])."<br>Agregado el ".fecha_larga($f['fecha'])."</label>";
				echo "</td>";				
				echo "<td>";
				echo "<a href='reportes_publicar.php?eliminar=".$f['integrante']."&id=".$id."&nitavu=".$nitavu."'><img src='icon/cancel.png' style='width:18px; height: 18px'></a>";
				echo "</td>";
				echo "</tr>";
				
			}
		echo "</table>";

		echo "</form>";
		echo "</div>";


echo "<div id='styleNotas'>";
echo "<p id='notasModificar' style='text-align:center;' ><b>NOTAS:</b>";
echo "<br>En caso de que el reporte no cumpla con el requisito, Notificar via Oficio al Dpto de Informática donde indique su cancelacion, el motivo y este <b class='ejecutandose'>ID: ".$_GET['id']."</b><br>";
//echo "<a id='' href='#ventanaModificar' rel='MyModal:open' type='button' class='btnmodifica' title='Haga clic aquí si es necesario modificar el reporte'> <img src='icon/redactar.png' style='width:30px; '> </a></p>";
echo "</div>";
echo "<br>";
echo "<br><br><br><br>";
echo "<div style='text-align:center'>";
echo '<form action="reporteador.php" method="get">';
echo "<input type='hidden' value='".$id."' name='PR1'>";
echo "<input class='Mbtn btn-default' type='submit' style='width:70%; text-align:center;' value='Recibir Reporte' >";
echo "</form>";
echo "</div>";
echo "</div>";
echo "</td>";
echo "<td id='tdRep2'>";
echo "<div id='divpublicarrep1'>";
echo "<iframe id='frame' name='frame' src='reporte.php?id=".$id."&nitavu=".$nitavu."&previsualizar='1'' style='width:100%;height:100%;border:0; border:none;'>Tu navegador no soporta iframes...</iframe>";
echo "</div>";
echo "</td>";
echo "</tr>";
echo "</table>";


?>
<br><br>
<?php include ("./lib/body_footer.php"); ?>