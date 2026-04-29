<?php
//include (".//seguridad.php"); 
include ("./lib/body_head.php");
include ("./lib/body_menu.php");

?>


<?php
$id_aplicacion ="ap49";
$nivel =aplicacion_nivel($id_aplicacion, $nitavu);

if (sanpedro($id_aplicacion, $nitavu)==TRUE)
{
echo "<div id='req_contenedor'>";
echo "<div id='AppDetalle'>".app_detalle($id_aplicacion, $nitavu)."</div>";
		
		include("req_menu.php"); 
		
$id = $_GET['d'];

echo "";
echo "<br>";
echo "<br>";

			$sql = " -- req 
					SELECT req_estatusreq.DesEstatus,req_estatusreq.Imagen,req_seguimiento.Observaciones,req_seguimiento.FechaCrea, CONCAT(UPPER(ifnull(empleados.profesion_abr,'')),' ',UPPER(empleados.nombre)) as nombre ,req_seguimiento.IdEstatus, req_seguimiento.Cancelado FROM req_seguimiento
					INNER JOIN req_estatusreq ON req_seguimiento.IdEstatus = req_estatusreq.IdEstatus
					INNER JOIN empleados on empleados.nitavu=req_seguimiento.Nitavu_crea
					WHERE req_seguimiento.IdRequisicion='".$id."'";

				$rc= $conexion -> query($sql);
				$row_cnt = $rc->num_rows;
 				$cont=0;
			if($row_cnt>0)
			{			 
				echo "<div class='centrar'>";
	    		echo"<table class='bordered'>";
	     		echo"<thead>
			      	<tr>
				         <th>#</th>        
				         <th class='centrar pc'>ETAPA</th>
						 <th>ESTADO</th>
				         <th>FECHA</th>
				         <th>OBSERVACIONES</th>
						 <th> USUARIO</th>
						 <th> ESTATUS</th>
			    	</tr>";
			   echo" </thead>
		   				 <tbody><tr>";
		        while($cat = $rc -> fetch_array())
						{ // resultado de la busqueda.................
							 if ($cat['Cancelado']=='1')
							{				
								
							echo "<tr style='color: #b30000; '>";
							echo "<td class='centrar'>". $cont=$cont+1;  "</td>";													
							echo "<td class='centrar pc'>";                       
							echo ponericono("icon/".$cat['Imagen']."",'icono_menu'); 
							echo "</td>";
							echo "<td class='centrar'>".$cat['DesEstatus']."</td>";	

							
							echo "<td class='centrar'>".date_format( date_create($cat['FechaCrea']), 'd/m/Y H:i:s')."</td>";	
						    echo "<td >".$cat['Observaciones']."</td>";	
							echo "<td >".$cat['nombre']."</td>";							
							echo "<td class='centrar'>CANCELADO</td>";	
							echo "</tr>";
							}else
							{
								echo "<tr >";
							echo "<td class='centrar'>". $cont=$cont+1;  "</td>";													
							echo "<td class='centrar pc'>";                       
							echo ponericono("icon/".$cat['Imagen']."",'icono_menu'); 
							echo "</td>";
							echo "<td class='centrar'>".$cat['DesEstatus']."</td>";	

							
							echo "<td class='centrar'>".date_format( date_create($cat['FechaCrea']), 'd/m/Y H:i:s')."</td>";	
						    echo "<td >".$cat['Observaciones']."</td>";	
							echo "<td >".$cat['nombre']."</td>";							
							echo "<td></td>";	
							echo "</tr>";

							}
							echo "</tr>";
										
						}
		   		echo" </tr>
				</tbody></table>";
				 echo"</div>";	
				  echo "<br>";		
				   echo "<br>";									
			}
			else
			{
			    echo "<div class='alert alert-danger'>";
			    echo "<strong>No se han encontrado productos</strong> !";
			    echo "</div>";
			    echo "<br>";
			    echo "<br>";

			}echo '</div>';	
						}
else{echo "	<br><br>";echo "No tiene acceso a ".$id_aplicacion;}

?>


<br><br><br><br><br><br>
	<br><br><br><br><br><br>
	<br><br><br><br><br><br>
	<br><br><br><br><br><br>
	<br><br><br><br><br><br>


<?php
include ("./lib/body_footer.php");
?>