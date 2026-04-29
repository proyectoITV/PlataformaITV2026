<?php
include ("./lib/body_head.php");
include ("./lib/body_menu.php");
?>
<?php
$id_aplicacion ="ap49";
$nivel =aplicacion_nivel($id_aplicacion, $nitavu);

if (sanpedro($id_aplicacion, $nitavu)==TRUE)
{
		echo "<div id='AppDetalle'>".app_detalle($id_aplicacion, $nitavu)."</div>";
		
		include("req_menu.php");



$id = $_GET['d'];
echo "<br>";
echo "<br>";
$estatusReq="";
$estatusReqAnt="";
$sql =" -- req 
				SELECT rq.IdRequisicion,-- UPPER(cgg.nombre) as Direccion,
				CASE cg.nivel WHEN  'Dir.' THEN (select UPPER(nombre)from cat_gerarquia where id=  cg.id)
				ELSE 
				  case cgg.nivel     
				  when'Dpto.' then (select UPPER(nombre)from cat_gerarquia where id= (select dependencia from cat_gerarquia where id= cgg.id ))
				  when 'Sub.' then (select UPPER(nombre)from cat_gerarquia where id= (select dependencia from cat_gerarquia where id= cgg.id )) 
				  when 'CONSEJO' then UPPER(cg.nombre)  ELSE UPPER(cgg.nombre)
				END END AS Direccion,
				UPPER(cg.nombre) as Departamento, dr.IdDepartamento, tr.Requisicion,er.DesEstatus 
				FROM req_detallerequisicion as dr inner join req_conceptos  as rc on dr.IdConcepto=rc.IdConcepto
				INNER JOIN  req_requisiciones as rq on rq.IdRequisicion=dr.IdRequisicion INNER JOIN req_tiporequisicion tr ON tr.IdTipoRequisicion=rq.IdTipoRequisicion INNER JOIN cat_gerarquia AS cg ON cg.id=dr.IdDepartamento 	LEFT JOIN cat_gerarquia AS cgg ON cgg.id=cg.dependencia 
				INNER JOIN req_estatusreq AS er ON rq.IdEstatus=er.IdEstatus
				 where dr.Cancelado=0  and dr.IdRequisicion='".$id."' GROUP BY dr.IdRequisicion";

				$rc= $conexion -> query($sql);
				$row_cnt = $rc->num_rows;
				$cont=0;
			if($row_cnt>0)
			{
				  while($cat = $rc -> fetch_array())
				  {
					echo "<form  action='req_accciones_reqAdm.php' method='POST' >";
					
					echo "<section id='aplicacionesReq'><label>Información General de la Requisición</label><br>";
					echo "<b class='normal menu_font_n'>FOLIO:</b> <cite class='tenue menu_font_d'>".$cat['IdRequisicion']."</cite><br>";
					

						
					echo "<article><table border='0'><tbody><tr>";			
						if(strpos($cat['Departamento'], 'DELEGACION') !== false or strpos($cat['Departamento'], 'COORDINACION') !==FALSE) 
					{ 
						echo "<td><b class='normal menu_font_n'>DIRECCIÓN:</b> <cite class='tenue menu_font_d '>".$cat['Departamento']."</cite></td>
						<td width='10px'></td>";
    					
					}
					else
					{
						echo "<td><b class='normal menu_font_n'>DIRECCIÓN:</b> <cite class='tenue menu_font_d'>".$cat['Direccion']."</cite></td>
						<td width='10px'></td>";
					}


					echo"<td style='display:none'>  <input type='number' name='idRequisicion' value=".$cat['IdRequisicion']." class='centrar'></td>
					</tr></tbody></table></article>

					<article><table border='0'><tbody><tr><td></td>
					<td><b class='normal menu_font_n'>DEPARTAMENTO:</b> <cite class='tenue menu_font_d '>".$cat['Departamento']."</cite></td><td width='10px'></td>
					<td style='display:none'> <input type='hidden' name='IdDepartamento' value=".$cat['IdDepartamento']." >  </td>
					</tr></tbody></table></article>

					<article><table border='0'><tbody><tr><td></td>
					<td><b class='normal menu_font_n'>TIPO DE REQUISICIÓN:</b> <cite class='tenue menu_font_d '>".$cat['Requisicion']."</cite></td><td width='10px'></td>
					</tr></tbody></table></article>

					<article><table border='0'><tbody><tr><td></td>
					<td><b class='normal menu_font_n'>ESTATUS:</b> <cite class='tenue menu_font_d '>". $cat['DesEstatus']."</cite></td><td width='10px'></td>
					</tr></tbody></table></article>

					<article><table border='0'><tbody><tr><td></td>
					<td><b class='normal menu_font_n'></b> <cite class='tenue menu_font_d pc'></cite></td><td width='10px'></td>
					</tr></tbody></table></article>
					</section>";
					$no = $_GET['d'];
					$estatusReq=$cat['DesEstatus'];
					
					
   				if ($nivel==1)
			 	   {
			 	   	echo "<section id='aplicacionesReq'><label>Opciones</label>	<br>";	
			 	   	echo"				
					
					
					    <button type='submit' class='Mbtn btn_menu' name='btnImprimir' id='btnImprimir'>											
						<table border='0'><tbody><tr>
							<td width='30px'>
								<img src='icon/imprimir.png' class='' style='width: 30px; height: 30px;'>
							</td>
							<td>
									<cite class='tenue menu_font_d'>Imprimir Requisición</cite>
							</td>
							</tr></tbody></table>
						</button>			
					";

						if ($estatusReq==='DETENIDA')
					{
								$sql = " -- req 
								SELECT rq.IdRequisicion,er.DesEstatus ,rs.IdSeguimientoReq,rs.IdSeguimiento FROM 
								req_requisiciones as rq 			
								inner join req_seguimiento as rs on rs.IdRequisicion=rq.IdRequisicion
								INNER JOIN req_estatusreq AS er ON rs.IdEstatus=er.IdEstatus
								and rq.IdRequisicion=".$id." and IdSeguimientoReq=((select max(rs.IdSeguimientoReq) from req_seguimiento as rs where rs.IdRequisicion=".$id." and rs.IdEstatus=7)-1)";	

							$rc= $conexion -> query($sql);
							$msg="";
							if($f = $rc -> fetch_array())
							{
								
								 
								$estatusReqAnt= $f['DesEstatus'];
								$estatusReq=$estatusReqAnt;
							}


							
					}
					if ($estatusReq==='RECHAZADA')
					{
						echo"			
				
				
					    <button type='submit' class='Mbtn btn_menu' name='btnReactivar' id='btnReactivar' >											
						<table border='0'><tbody><tr><td width='30px'><img src='icon/reveri.png' style='width: 30px; height: 30px;'></td>
						<td ><b class='normal menu_font_n'></b> <cite class='tenue menu_font_d'>Reactivar Requisición</cite></td><td></td></tr></tbody></table>
						</button>";	
						

		

						
							
					}


							
					
				

						if (($estatusReq==='EVALUACIÓN'|| $estatusReq==='RECIBIDA') && $cat['DesEstatus']!='DETENIDA' )
					{
					echo"
					
					    <button type='submit' class='Mbtn btn_menu' name='btnCotizar' id='btnCotizar' >											
						<table border='0'><tbody><tr><td width='30px'><img src='icon/pesos.png' style='width: 30px; height: 30px;'></td>
						<td ><b class='normal menu_font_n'></b> <cite class='tenue menu_font_d'>Cotizar Requisición</cite></td><td></td></tr></tbody></table>
						</button>";			
					
					
						
						
					
					echo "
						<button type='submit' class='Mbtn btn_menu'  name='btnRechazar' id='btnRechazar' >					
						<table border='0'><tbody><tr><td width='30px'> <img src='icon/rechazar.png' style='width: 30px; height: 30px;'></td>
						<td ><b class='normal menu_font_n'></b> <cite class='tenue menu_font_d' >Rechazar Requisición</cite></td><td></td></tr></tbody></table>
						</button>";			
					

					if($cat['DesEstatus']!='DETENIDA')
					{
						echo"<button type='submit' class='Mbtn btn_menu'  name='btnDetener' id='btnDetener' >					
						<table border='0'><tbody><tr><td width='30px'><img src='icon/detener.png' style='width: 30px; height: 30px;'></td>
						<td><b class='normal menu_font_n'></b> <cite class='tenue menu_font_d'>Detener Requisición</cite></td><td></td></tr></tbody></table>
						</button>			
					</article>";
					}


					}
						if (($estatusReq==='EVALUACIÓN'|| $estatusReq==='RECIBIDA')&& $cat['DesEstatus']=='DETENIDA')
					{
					echo"
					
					     <button type='submit' class='Mbtn btn_menu' name='btnCotizar' id='btnCotizar' >											
						<table border='0'><tbody><tr><td width='30px'><img src='icon/pesos.png' style='width: 30px; height: 30px;'></td>
						<td ><b class='normal menu_font_n'></b> <cite class='tenue menu_font_d'>Cotizar Requisición</cite></td><td></td></tr></tbody></table>
						</button>			
					
					
						<button type='submit' class='Mbtn btn_menu'  name='btnRechazar' id='btnRechazar' >					
						<table border='0'><tbody><tr><td width='30px'> <img src='icon/rechazar.png' style='width: 30px; height: 30px;'></td>
						<td ><b class='normal menu_font_n'></b> <cite class='tenue menu_font_d' >Rechazar Requisición</cite></td><td></td></tr></tbody></table>
						</button>				
					";

					



					}
					else if ($estatusReq==='COTIZANDO')
									{
									echo"	
									
									    <button type='submit' class='Mbtn btn_menu' name='btnVoBo' id='btnVoBo'>											
										<table border='0'><tbody><tr><td width='30px'><img src='icon/autorizar.png' style='width: 30px; height: 30px;'></td>
										<td ><b class='normal menu_font_n'></b> <cite class='tenue menu_font_d'>Autorizar Requisición</cite></td><td></td></tr></tbody></table>
										</button>			
								
													
						
										<button type='submit' class='Mbtn btn_menu'  name='btnRechazar' id='btnRechazar' >					
										<table border='0'><tbody><tr><td width='30px'><img src='icon/rechazar.png' style='width: 30px; height: 30px;'></td>
										<td ><b class='normal menu_font_n'></b> <cite class='tenue menu_font_d'>Rechazar Requisición</cite></td><td></td></tr></tbody></table>
										</button>			
									";
									if($cat['DesEstatus']!='DETENIDA')
									{
										echo"<button type='submit' class='Mbtn btn_menu'  name='btnDetener' id='btnDetener' >					
										<table border='0'><tbody><tr><td width='30px'><img src='icon/detener.png' style='width: 30px; height: 30px;'></td>
										<td><b class='normal menu_font_n'></b> <cite class='tenue menu_font_d'>Detener Requisición</cite></td><td></td></tr></tbody></table>
										</button>			
									</article>";
									}

									}


					else if ($estatusReq==='AUTORIZADA')
					{
					echo"
					
					    <button type='submit' class='Mbtn btn_menu' name='btnArmado' id='btnArmado'>											
						<table border='0'><tbody><tr><td width='30px'><img src='icon/armar.png' style='width: 30px; height: 30px;'></td>
						<td ><b class='normal menu_font_n'></b> <cite class='tenue menu_font_d'>Armando Requisición</cite></td><td ></td></tr></tbody></table>
						</button>			
					
							
					
						<button type='submit' class='Mbtn btn_menu' name='btnRechazar' id='btnRechazar' >					
						<table border='0'><tbody><tr><td width='30px'><img src='icon/rechazar.png' style='width: 30px; height: 30px;'></td>
						<td ><b class='normal menu_font_n'></b> <cite class='tenue menu_font_d'>Rechazar Requisición</cite></td><td ></td></tr></tbody></table>
						</button>			
					";
					if($cat['DesEstatus']!='DETENIDA')
					{
						echo"<button type='submit' class='Mbtn btn_menu'  name='btnDetener' id='btnDetener' >					
						<table border='0'><tbody><tr><td width='30px'><img src='icon/detener.png' style='width: 30px; height: 30px;'></td>
						<td><b class='normal menu_font_n'></b> <cite class='tenue menu_font_d'>Detener Requisición</cite></td><td></td></tr></tbody></table>
						</button>			
					</article>";
					}
					}
					
				else if ($estatusReq==='EN ARMADO')
					{
					echo"
						<button type='submit' class='Mbtn btn_menu' name='btnEntregar' id='btnEntregar' >					
						<table border='0'><tbody><tr><td width='30px'><img src='icon/entregar.png' style='width: 30px; height: 30px;'></td>
						<td ><b class='normal menu_font_n'></b> <cite class='tenue menu_font_d'>Entregar Requisición</cite></td><td ></td></tr></tbody></table>
						</button>			

								
		
						<button type='submit' class='Mbtn btn_menu'  name='btnRechazar' id='btnRechazar' >					
						<table border='0'><tbody><tr><td width='30px'><img src='icon/rechazar.png' style='width: 30px; height: 30px;'></td>
						<td ><b class='normal menu_font_n'></b> <cite class='tenue menu_font_d'>Rechazar Requisición</cite></td><td></td></tr></tbody></table>
						</button>";	
						if($cat['DesEstatus']!='DETENIDA')
					{
						echo"<button type='submit' class='Mbtn btn_menu'  name='btnDetener' id='btnDetener' >					
						<table border='0'><tbody><tr><td width='30px'><img src='icon/detener.png' style='width: 30px; height: 30px;'></td>
						<td><b class='normal menu_font_n'></b> <cite class='tenue menu_font_d'>Detener Requisición</cite></td><td></td></tr></tbody></table>
						</button>			
					</article>";
					}
				
					}
				
					
					echo"<a class='Mbtn btn_menu' href='plantilla.php?n=".$id."'   name='btnExportar' id='btnExportar'
					style='
							width: 120px;
							height: 50px;
							display: inline-block;							
							background: #E5E5E5;
							text-decoration: none;
							margin-top: -22px;
							vertical-align: middle;'
					>	
									
						<table border='0'><tbody><tr><td width='30px'><img src='icon/icon-excel.png' style='width: 30px; height: 30px;'></td>
						<td><b class='normal menu_font_n'></b> <cite class='tenue menu_font_d'>Exportar Requisición</cite></td><td></td></tr></tbody></table>
						</a>	";
					echo "</section>";
					
				
				echo "</form>";

			

				}

					}
		}


			/*$sql = " -- req 
			SELECT req_detallerequisicion.IdDetalle,req_detallerequisicion.IdConcepto,
			 req_detallerequisicion.IdDepartamento,req_conceptos.Concepto,SUM(req_detallerequisicion.Cantidad) AS Cantidad,
			  req_detallerequisicion.Justificacion FROM req_detallerequisicion inner join 
			  req_conceptos on req_detallerequisicion.IdConcepto=req_conceptos.IdConcepto  
			  where req_detallerequisicion.Cancelado=0  and req_detallerequisicion.IdRequisicion='".$id."' GROUP BY req_detallerequisicion.IdConcepto";*/

			  	$sql = " -- req 
			SELECT req_detallerequisicion.IdDetalle,req_detallerequisicion.IdConcepto,
			 req_detallerequisicion.IdDepartamento,req_conceptos.Concepto,req_detallerequisicion.Cantidad,
			  req_detallerequisicion.Justificacion FROM req_detallerequisicion inner join 
			  req_conceptos on req_detallerequisicion.IdConcepto=req_conceptos.IdConcepto  
			  where req_detallerequisicion.Cancelado=0  and req_detallerequisicion.IdRequisicion='".$id."' GROUP BY  req_conceptos.Concepto";

				$rc= $conexion -> query($sql);
			 	$row_cnt = $rc->num_rows;
			 	$cont=0;

			 if($row_cnt>0)
			 {			
			 	
				echo "<br>";
				echo "<br>";
				echo "<div class='centrar'>";
			    echo"<table class='bordered'>";
			    echo"<thead>
			    <tr>
			    <th class='pc'>#</th>        
			    <th style='display:none'></th>
				<th></th>
			    <th>CONCEPTO</th>
			    <th>CANTIDAD</th>
			    <th class='pc'>JUSTIFICACIÓN</th>";
			/* if ($nivel==1 && ($estatusReq != 'AUTORIZADA' && $estatusReq != 'EN ARMADO' && $estatusReq != 'ENTREGADA'))
			    {
			   		echo" <th> ACCIONES</th>";
				}*/
			    echo"</tr>";
			   	echo" </thead>
			    <tbody><tr>";
		        while($cat = $rc -> fetch_array())
						{ // resultado de la busqueda.................
							echo "<form  action='req_acciones_req_bd.php' method='POST' >";	
							echo "<tr>";
							echo "<td  class='centrar pc tenue'>". $cont=$cont+1;  "</td>";		
							echo "<td style='display:none'> <input type='hidden' name='IdDetalle' value=".$cat['IdDetalle']." >  </td>";

							echo "<td  class='centrar' width='100px'>";        
							echo "<div>";               
							echo ponericono("fotos_concepto/".$cat['IdConcepto'].".jpg",'icono_menu'); 
							echo "</div>" ;              
							echo "</td>";	
							echo "<td  class='tenue'> ".$cat['Concepto']." </td>";
							 //if ($nivel==1 )
							 if ($nivel==1 && ($estatusReq != 'AUTORIZADA' && $estatusReq != 'EN ARMADO' && $estatusReq != 'ENTREGADA'))
			   				 {
								echo"<td  class='centrar' width='150px' > ";
								echo "<div style='width:100%;display:inline-block; padding:5px;' id='req_contenedor'>";
								echo "<input type='number' name='cant' value=".$cat['Cantidad']." min='0'  class='centrar' style='width:50%; height:35px; margin-right:5px;''  >";
								echo "<button type='submit'  name='btnLogA' id='btnLogA' class='Mbtn btn-celesteTam ' title='Actualizar'>";
								echo "<img src='icon/actualizar.png'  style='width: 25px;height: 14px; padding: 0px;'>";
								echo "</button>";
								echo "</div>";
								echo "</td>";	
							} else
							{
								echo"<td class='centrar tenue' width='10px'>". $cat['Cantidad']."</td>";	
							}
						/*	echo "<td style='display:none'>  <input type='number' name='Justificacion' value=".$cat['Justificacion']."  class='centrar'></td>";*/
							echo"<td class='pc tenue'>" .$cat['Justificacion']."</td>";	

							/* if ($nivel==1 && ($estatusReq != 'AUTORIZADA' && $estatusReq != 'EN ARMADO' && $estatusReq != 'ENTREGADA'))
			   				 {		 	
								echo "<td  class='centrar'> 										
			  							</button> <button type='submit' name='btnLogE' id='btnLogE'  class='Mbtn btn-cancel ' title='Eliminar'>  <img src='icon/papelera.png' style='width: 25px;height: 14px; padding: -5px;'>   </button></td>";	
							 }*/
							echo "</form>";
							echo "</tr>";
										
						}
				echo" </tr> </tbody></table>";
				echo"</div>";		

				
									
			}
			else
			{
			    echo "<div class='alert alert-danger'>";
			    echo "<strong>No se han encontrado productos</strong> !";
			    echo "</div>";
			}
			echo "<br>";
			echo "<br>";
				}
else{echo "	<br><br>";echo "No tiene acceso a ".$id_aplicacion;}
?>
<br><br><br><br><br><br><br><br><br><br>
<?php
include ("./lib/body_footer.php");
?>