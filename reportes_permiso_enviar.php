<?php include ("./lib/body_head.php"); include ("./lib/body_menu.php");  ?>
<?php
require("config.php");
$id_aplicacion = 'ap50';
echo "<div id='AppDetalle'>".app_detalle($id_aplicacion, $nitavu)."</div>";
//PROCESO PARA TOCAR LA PUERTA DE SAN PEDRO
$id_aplicacion ="ap50"; //ap07=Permisos de Aplicacion
$nivel =aplicacion_nivel($id_aplicacion, $nitavu);

if (isset($_GET['id']) and isset($_GET['solicita']) ){
	$id = $_GET['id'];
	$solicita = $_GET['solicita'];
 

echo "<table style='width:100%; height: 100%;' >";
echo "<td id='tdRep1'>";
echo "<div id='divpublicarrep2'>";

//PEDIR PERMISO A LOS RESPONSABLES DE LA INFORMACION DEL REPORTE
echo "<form action='reportes_permiso_enviar.php' method='POST'>";
$sql = "select 
id, titular as Titular, nombre as Dpto,
(select nombre from empleados where nitavu=Titular) as Empleado
from cat_gerarquia where id<>0 and Titular <>''";

echo "<label>Titulares de las diferentes areas del Instituto:</label><select name='empleados'>";
$r2 = $conexion -> query($sql); while($f = $r2 -> fetch_array())
{	
	echo "<option value='".$f['Titular']."'>".$f['Empleado'].", ".$f['Dpto']."</option>";
}
echo "</select>";
echo "<br><br>";
echo "<input type='hidden' name='id' value='".$id."'>";
echo "<input type='hidden' name='solicita' value='".$solicita."'>";

echo "<input name='submit__agregar' type='submit' value='Enviar a Aprobación' class='Mbtn btn-default'>";
echo "</form><br><br>";


$archivo = "fotos/".$solicita.".jpg";
echo "<span style=' width:50%; font-size:12pt;'><br><br> Solicitante: <br> ".ponerfoto($archivo,'foto')."<p style='font-size:10px'><b>".nitavu_nombre($solicita)."</b> de ".nitavu_dpto_nombre($solicita);
echo "<br><br>Ext. <b>".nitavu_tel_ext($solicita)."</b><BR><BR>";

echo "Solicita información sobre: ";
	$sql = "SELECT * FROM reportes WHERE id_rep_consulta='".$id."'";
    $rc= $conexion -> query($sql);
    if($f = $rc -> fetch_array()){
		echo  $f['nombre'].":".$f['descripcion']."<br>";
		//echo  "<label> solicitado".$f['nombre'].":".$f['descripcion']."</label>";
		//pendiente fecha
		
    }else{
    }

echo "</span>";

echo "<br>";
echo "<br><br><br><br>";
echo "</div>";
echo "</td>";
echo "<td id='tdRep2'>";
echo "<div id='divpublicarrep1'>";
echo "<iframe id='frame' name='frame' src='reporte.php?id=".$id."&nitavu=".$nitavu."&previsualizar='1'' style='width:100%;height:100%;border:0; border:none;'>Tu navegador no soporta iframes...</iframe>";
echo "</div>";
echo "</td>";
echo "</table>";

}



// if (isset($_GET['busqueda'])){
// 		echo "<div id='pendientes_nuevo_se' >";
// 		echo "<form action='reportes_permiso_enviar.php' method='GET'>";
// 		/*$sql = "SELECT * FROM empleados INNER JOIN cat_gerarquia WHERE (empleados.nitavu='".$_GET['busqueda']."' and empleados.nitavu = cat_gerarquia.titular or empleados.nombre like'%".$_GET['busqueda']."%' and empleados.nitavu = cat_gerarquia.titular
// 		or empleados.departamento like'%".$_GET['busqueda']."%' and empleados.nitavu = cat_gerarquia.titular) limit 0,10";*/
// 		$sql = "SELECT * FROM empleados INNER JOIN cat_gerarquia WHERE (empleados.nitavu='".$_GET['busqueda']."' and empleados.nitavu = cat_gerarquia.titular and estado = \"\" or empleados.nombre like'%".$_GET['busqueda']."%' and empleados.nitavu = cat_gerarquia.titular and estado = \"\" or empleados.departamento like'%".$_GET['busqueda']."%' and empleados.nitavu = cat_gerarquia.titular and estado = \"\") limit 0,10";
// 		//echo $sql;
// 		echo "<span style='font-size:10pt; color: black; padding: 3px;'>Resultados de <b>".$_GET['busqueda']."</span></<br><br>";
// 		$r2 = $conexion -> query($sql); while($f = $r2 -> fetch_array())
// 			{	
// 				$archivo = 'fotos/'.$f['nitavu'].".jpg";
// 				echo "<article>";
// 				echo "<table width=100%><tr>";
// 				echo "<td style='background-color: #E3E2E2;' class='pc' width=30%>".ponerfoto($archivo, 'pendientes_foto1')."</td>";
// 				echo '<td><input type="checkbox" name="empleados[]" value="'.$f['nitavu'].'">'."</td>"; 
// 				echo "<td class=''><b style='font-size:8pt;'>".nitavu_nombre($f['nitavu'])."</b><label style='font-size:7pt;' class='pc'>".nitavu_puesto($f['nitavu'])." de ".nitavu_dpto_nombre($f['nitavu'])."</label></td>";
// 				echo "</tr>";
// 				echo "</table>";
// 				echo "</article>";
// 			}
// 		echo "<input type='hidden' value='".$id."' name='id'>";	
// 		echo "<input type='hidden' value='".$solicita."' name='solicita'>";	
// 		echo "<br><a href='reportes_permiso_enviar.php?id=".$id."&solicita=".$solicita."'>Buscar nuevamente </a>";
// 		echo "</div>";

// 		echo "<div id='pendientes_nuevo_te'>";
// 		echo "<b style='font-size:10pt;'>Solicitar permiso de publicar reporte a:</b>";		
// 		//echo "<label style='margin-top: -17px;' class='pc'>De clic en la <X> para eliminar la participacion</label>";
// 		$sql = "SELECT * FROM reportes_autoriza WHERE idRep='".$id."'";		
// 		echo "<table class=tabla width=100%>";
// 		$r2 = $conexion -> query($sql); while($f = $r2 -> fetch_array())		
// 			{	echo "<tr>";
// 				$archivo = 'fotos/'.$f['autoriza'].".jpg";				
// 				echo "<td>".ponerfoto($archivo, 'pendientes_foto1')."</td>";
// 				echo "<td class='pc'>".nitavu_nombre($f['autoriza']);
// 				echo "<label class='pc' style='font-size:8pt; margin-top:-2px;'>".nitavu_puesto($f['autoriza'])." de ".nitavu_dpto_nombre($f['autoriza'])."<br>Agregado el ".fecha_larga($f['fecha'])."</label>";
// 				echo "</td>";				
// 				echo "<td>";
// 				echo "<a href='reportes_permiso_enviar.php?eliminar=".$f['autoriza']."&id=".$id."&solicita=".$solicita."'><img src='icon/cancel.png' style='width:18px; height: 18px'></a>";
// 				echo "</td>";
// 				echo "</tr>";	
// 			}
// 		echo "</table>";

// 		echo "<input type='submit' name='submit__agregar' class='Mbtn btn-default' value='Enviar notificación'>";
// 		echo "</form>";
// 		echo "</div>";
// 	} else {
//         echo "<h3>Solicitar permiso a: </h3>";
// 		echo '<div id="beta_buscar">';
//         echo '<form action="reportes_permiso_enviar.php?id='.$id.'&solicita='.$solicita.'" method="get">';
// 		echo '<table broder="1" width="100%"><tr>';
// 			echo '<td>                    <input required="required" type="text" id="beta_buscar_input" name="busqueda" placeholder="Nombre del empleado (Titulares)" /></td>';
// 			echo '<td align="right" width="15px">                    
// 			<button id="beta_buscar_boton">
// 			<img  src="icon/buscar.png"></button>
// 			</td>';
// 		echo '</tr></table>';
// 		echo "<input type='hidden' value='".$id."' name='id'>";	
// 		echo "<input type='hidden' value='".$solicita."' name='solicita'>";	
// 		echo '</form>';
// 		echo '</div>';


// 		echo "<div style='display: inline-block; width: 40%; vertical-align:top;'>";
	
// 		echo "</div>";
		//Para agregar a un miembro y pueda ver un reporte.
		if (isset($_POST['submit__agregar'])){
			$empleado = $_POST['empleados']; $msg="";$contenido="";
			$solicita = $_POST['solicita']; $id=$_POST['id'];
			// foreach($empleados as $empleado){ //solo trae los seleccionados
			    $sql = "INSERT INTO reportes_autoriza (id, idRep, autoriza, estado, fecha, hora)
				VALUES ('','".$id."', '$empleado','0','$fecha', '$hora')";
				//echo $sql; //comprobamos la sintaxis query
				if ($conexion->query($sql) == TRUE){
					historia($nitavu, 'Se le solicita permiso a "'.nitavu_nombre($empleado).'" para autorizar un reporte.');
					$contenido = 'Buen día <br><p>Te informamos que <b>'.nitavu_nombre($solicita).'</b>, '.nitavu_puesto($solicita).' de '.nitavu_dpto_nombre($solicita).', solicito un reporte llamado '.reporte_nombre($id).'.</p><p>Esta notificación se hace debido a que la información contenida en dicho reporte, corresponde a su área administrativa.<br> Usted puede aceptar o declinar la publicación de este reporte. 
					Para ello de clic en el siguiente enlace:<br> <a href="reportes_aprobar.php?id='.$id.'&solicita='.$solicita.'">Enlace para aprobar Reporte.</a>';
					notificacion_add($empleado, 'Solicitud de publicar Reporte '.reporte_nombre($id), $fecha, $solicita, $contenido);	
					$msg = $msg.nitavu_nombre($empleado).", "; //actualizamos el mensaje	
					//AGREGAMOS LA CATEGORIA AL REPORTE
					$cat = nitavu_dpto($empleado);
					$sql1 = "UPDATE reportes SET categoria=".$cat." WHERE id_rep_consulta=".$id."";
					if ($conexion->query($sql1) == TRUE) {
						historia($empleado, 'La categoria del reporte será de mi departamento.');
					}else{
						historia($empleado, 'ERROR al agregar la categoria del reporte.'.reporte_nombre($id));
					}
					
				} else{ 
					historia($nitavu, "ERROR al agregar a ".nitavu_nombre($empleado)." a visualizar el reporte llamado ".reporte_nombre($id).", SQL: ".$sql);
					$msg = $msg."Hubo un error al agregar a ".nitavu_nombre($empleado).", "; //acualizamos el mensaje
				}
			// }
			 mensaje("Se ha enviado la notificación con éxito.","reporteador.php?notificacion=1&id=".$id."");
		}

		//Para eliminar un empleado.
		if (isset($_GET['eliminar'])){
			$sql = "DELETE FROM reportes_autoriza WHERE autoriza='".$_GET['eliminar']."' and idRep='".$_GET['id']."'";
				//echo $sql; //comprobamos la sintaxis query
				if ($conexion->query($sql) == TRUE){
					historia($nitavu, "Elimino a ".nitavu_nombre($_GET['eliminar'])."");
					$contenido = "Lamentamos informarte que <br><p><b>".nitavu_nombre($nitavu)."</b>, ".nitavu_puesto($nitavu)." de ".nitavu_dpto_nombre($nitavu).", te ha eliminado de la lista
					de participantes y ahora no podrás visualizar el reporte en el que estabas incluido.";
					notificacion_add($_GET['eliminar'],'Eliminado de visualizar reporte: '.reporte_nombre($_GET['id']).'', $fecha, $nitavu, $contenido);
					
				} else{ 
					historia($nitavu, "ERROR al agregar a ".nitavu_nombre($_GET['eliminar']).", SQL: ".$sql);
					
				}
				mensaje("Eliminado ".nitavu_nombre($_GET['eliminar'])." con éxito","reportes_permiso_enviar.php?id=".$id."&solicita=".$solicita."");
		}
    




?>

<?php include ("./lib/body_footer.php"); ?>