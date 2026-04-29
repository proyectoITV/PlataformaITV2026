<?php include ("./lib/body_head.php");
include ("./lib/body_menu.php"); ?>
<?php
//$id_aplicacion ="ap10"; //Este es con el que se registre


$idDepartamento=nitavu_dpto($nitavu);

$id_aplicacion ="ap49";
$nivel =aplicacion_nivel($id_aplicacion, $nitavu);

if (sanpedro($id_aplicacion, $nitavu)==TRUE)
{ //PARA DAR ACCESO CUANDO ESTE REGISTRADA
		historia($nitavu,'Req_ Entró a la aplicacion requisiciones'); 
		echo "<div id='AppDetalle'>".app_detalle($id_aplicacion, $nitavu)."</div>";	
		echo "<div id=req_contenedor>";			
		include("req_menu.php");
		AhorrePapel(FALSE,1);


//echo "<br>";

	//Buscar en Catalago



	if (isset($_GET['m'])){

	} else	{

	echo "<div id='req_catalago_etiquetas'>";
	if (isset($_GET['c'])) { } 
		else
		 {

		if (isset($_GET['busqueda']))
		{ 
	
		} 
		else 
		{
			echo "<div class='centrar_padre' >"."<div class='centrar_hijo'>";	
		}
		
		echo "<label></label>";
		buscar("req.php","Buscar un articulo",'');
		}
	
			$sql=" -- req 
			SELECT DISTINCT
			req_conceptos.IdTipoRequisicion,
			(
				SELECT
					req_tiporequisicion.Requisicion
				FROM
					req_tiporequisicion
				WHERE
					req_tiporequisicion.IdTipoRequisicion = req_conceptos.IdTipoRequisicion
			) AS Categoria
			FROM
				req_conceptos
			WHERE
				req_conceptos.Cancelado = 0
			"; 
			$rc= $conexion -> query($sql);
			$row_cnt = $rc->num_rows;
			if ($row_cnt>0)

			{
				echo "<div class='labels'>";
				while($cat = $rc -> fetch_array())		
				{
					echo "<a href='req.php?busqueda=&c=".$cat['IdTipoRequisicion']."' title='Haga clic aqui para ver los productos de ".$cat['Categoria']."'>";
					
					if (isset($_GET['c'])){
						if ($_GET['c']==$cat['IdTipoRequisicion']){
						echo "<b>".$cat['Categoria']."</b>";
						} else {echo $cat['Categoria'];}
					} else {echo $cat['Categoria'];}
					echo "</a>";
				}
				echo "</div>";

			}

		if (isset($_GET['busqueda'])){

		} else {			
		echo "</div>";
		echo "</div>";
		}
	echo "</div>";
 	echo "<div id='grafica' class='pc'>";		
if ($nivel==1)
	{

					
					echo "<section id='aplicacionesReqGrafica2' style='width:100%;' class='pc'>
					<article style='margin:10px; width:28%; display:inline-block; text-align:center; padding:10px; background-color:white;'>";								
 						include('req_graficaProductosComprados.php');				
					echo "</article>";
					
					
					
					echo " <article style='margin:10px; width:28%; display:inline-block; text-align:center;padding:10px; background-color:white;'>";								
 					include('req_graficaProductos.php');				
				 echo "</article>
				 </section>";


}
   echo "</div>";
	}


if (isset($_GET['busqueda']))
{// si en la url esta busqueda, mostrar catalago
	//Catalago: iria sin importar si es administrador o no

	echo "<script type='text/javascript'>
document.getElementById('grafica').style.display = 'none';
</script>";
	echo "<section id='req_catalago'>";
		//if (nitavu_dpto($nitavu)==;
		

    //VALIDA SI ES ADMINISTRADOR O NO
	if ($nivel==1) 
			{
				$search=$_GET['busqueda'];

				if (isset($_GET['c']))
				{// SI SELECCIONO UNA CATEGORIA:
					$sql = " -- req 
					SELECT req_conceptos.IdConcepto, req_conceptos.Concepto FROM req_conceptos
					WHERE  req_conceptos.Cancelado=0 and IdTipoRequisicion='".$_GET['c']."' ORDER BY req_conceptos.Concepto";	
					if($_GET['c']==1)
					{
						historia($nitavu,'Req_Realizó busqueda por la categoría "Papelería"');

					}else if($_GET['c']==2)
					{
						historia($nitavu,'Req_Realizó busqueda por la categoría "Material de Limpieza"');
					}
					else if($_GET['c']==3)
					{
						historia($nitavu,'Req_Realizó busqueda por la categoría "Electrónica"');
					}
				}
				else 
				{


					$sql = " -- req 
					SELECT req_conceptos.IdConcepto, req_conceptos.Concepto FROM req_conceptos
					WHERE  req_conceptos.Concepto LIKE'%".$_GET['busqueda']."%' and req_conceptos.Cancelado=0 ORDER BY req_conceptos.Concepto";
				}


				
			}
			else
			{	$dpto=	nitavu_dpto($nitavu);
				$sql =  " -- req 
											SELECT req_conceptos.IdConcepto, req_conceptos.Concepto FROM req_conceptos
											WHERE  req_conceptos.Concepto LIKE'%".$_GET['busqueda']."%' and req_conceptos.Cancelado=0 and req_conceptos.IdTipoRequisicion in (1) ORDER BY req_conceptos.Concepto";

				//IDENTIFICA SI ES DE UNA DELEGACION O PERTENCE A OFICINAS CENTRALES
				if (midelegacion($nitavu)=='OFICINAS CENTRALES')
						{		
							
						 
						 	//echo $_GET['c']." dpto=".$dpto;
						     //DETERMINA  SI EL USUARIO ES DEL DEPARTAMENTO DE SOPORTE O DE INFORMATICA	
							if ($dpto==4 || $dpto==55 ) 						
								{
									if (isset($_GET['c'])){// SI SELECCIONO UNA CATEGORIA:
									
										if ($_GET['c']=='1')
										{
											$sql = " -- req 
											SELECT req_conceptos.IdConcepto, req_conceptos.Concepto FROM req_conceptos
											WHERE  req_conceptos.Cancelado=0 and req_conceptos.IdTipoRequisicion in (1) ORDER BY req_conceptos.Concepto";
											historia($nitavu,'Req_Realizó busqueda por la categoría "Papelería"');

										} else if(  $_GET['c']=='3')
										{
											$sql = " -- req 
											SELECT req_conceptos.IdConcepto, req_conceptos.Concepto FROM req_conceptos
											WHERE  req_conceptos.Cancelado=0 and req_conceptos.IdTipoRequisicion in (3) ORDER BY req_conceptos.Concepto";
											historia($nitavu,'Req_Realizó busqueda por la categoría "Electrónica"');

										}
										else {
											mensaje ("Categoria no Autorizada",'req.php');
										}
									} else {
										$sql = " -- req 
										SELECT req_conceptos.IdConcepto, req_conceptos.Concepto FROM req_conceptos
											WHERE  req_conceptos.Concepto LIKE'%".$_GET['busqueda']."%' and req_conceptos.Cancelado=0 and req_conceptos.IdTipoRequisicion in (1,3) ORDER BY req_conceptos.Concepto";
									}
								}

								  //DETERMINA  SI EL USUARIO ES DEL DEPARTAMENTO DE ADQUISICIONES Y O RECURSOS MATERIALES	
								else if ($dpto==59 ||  $dpto==61 ) 						
								{
									if (isset($_GET['c'])){// SI SELECCIONO UNA CATEGORIA:
										if ($_GET['c']=='1' )
										{
											$sql = " -- req 
											SELECT req_conceptos.IdConcepto, req_conceptos.Concepto FROM req_conceptos
											WHERE  req_conceptos.Cancelado=0 and req_conceptos.IdTipoRequisicion in (1) ORDER BY req_conceptos.Concepto";
											historia($nitavu,'Req_Realizó busqueda por la categoría "Papelería"');
										}else if ( $_GET['c']=='2')
										{
											$sql = " -- req 
											SELECT req_conceptos.IdConcepto, req_conceptos.Concepto FROM req_conceptos
											WHERE  req_conceptos.Cancelado=0 and req_conceptos.IdTipoRequisicion in (2) ORDER BY req_conceptos.Concepto";
											historia($nitavu,'Req_Realizó busqueda por la categoría "Material de Limpieza"');
										}
										 else {mensaje ("Categoria no Autorizada",'req.php');}
									} 
									else 
									{
										$sql = " -- req 
										SELECT req_conceptos.IdConcepto, req_conceptos.Concepto FROM req_conceptos
											WHERE  req_conceptos.Concepto LIKE'%".$_GET['busqueda']."%' and req_conceptos.Cancelado=0 and req_conceptos.IdTipoRequisicion in (1,2) ORDER BY req_conceptos.Concepto";
									}
								}
								else
								{	
									if (isset($_GET['c']))
									{// SI SELECCIONO UNA CATEGORIA:
										if ($_GET['c']=='1' )
										{
											$sql =  " -- req 
											SELECT req_conceptos.IdConcepto, req_conceptos.Concepto FROM req_conceptos
											WHERE  req_conceptos.Concepto LIKE'%".$_GET['busqueda']."%' and req_conceptos.Cancelado=0 and req_conceptos.IdTipoRequisicion in (1) ORDER BY req_conceptos.Concepto";
											historia($nitavu,'Req_Realizó busqueda por la categoría "Papelería"');
											//cambio yesica
										}
										else 
										{
											mensaje ("Categoria no Autorizada",'req.php');
										}
									}
									 else 
									 {
										$sql = " -- req
										SELECT req_conceptos.IdConcepto, req_conceptos.Concepto FROM req_conceptos
											WHERE  req_conceptos.Concepto LIKE'%".$_GET['busqueda']."%' and req_conceptos.Cancelado=0 and req_conceptos.IdTipoRequisicion in (1) ORDER BY req_conceptos.Concepto";
									}
								}
							
						}
						else
						{
							
											
											
							if (isset($_GET['c']))
							{// SI SELECCIONO UNA CATEGORIA:
								 if ($dpto==45  ) 						
								{
									if (isset($_GET['c']))
									{// SI SELECCIONO UNA CATEGORIA:
										if ($_GET['c']=='1' )
										{
											$sql = " -- req 
											SELECT req_conceptos.IdConcepto, req_conceptos.Concepto FROM req_conceptos
											WHERE  req_conceptos.Cancelado=0 and req_conceptos.IdTipoRequisicion in (1) ORDER BY req_conceptos.Concepto";
										}
										 else {mensaje ("Categoria no Autorizada",'req.php');}
									} 
								}
								else
								{ 
									if ($_GET['c']=='1' )
									{
										
										$sql = " -- req
										SELECT req_conceptos.IdConcepto, req_conceptos.Concepto FROM req_conceptos
										WHERE req_conceptos.Cancelado=0  and req_conceptos.IdTipoRequisicion in (1) ORDER BY req_conceptos.Concepto";
									} else if ($_GET['c']=='2')
									{
										$sql = " -- req
										SELECT req_conceptos.IdConcepto, req_conceptos.Concepto FROM req_conceptos
										WHERE req_conceptos.Cancelado=0  and req_conceptos.IdTipoRequisicion in (2) ORDER BY req_conceptos.Concepto";
									} 
									else {mensaje("Categoria no Autorizada",'req.php');}
									
								}
							}
							 else
							  {
							 	if ($dpto==45  ) 						
								{
									
											$sql = " -- req 
											SELECT req_conceptos.IdConcepto, req_conceptos.Concepto FROM req_conceptos
											WHERE  req_conceptos.Cancelado=0 and req_conceptos.IdTipoRequisicion in (1) ORDER BY req_conceptos.Concepto";
										
									
								}
								else
								{
									$sql = " -- req 
									SELECT req_conceptos.IdConcepto, req_conceptos.Concepto FROM req_conceptos
									WHERE  req_conceptos.Concepto LIKE'%".$_GET['busqueda']."%' and req_conceptos.Cancelado=0  and req_conceptos.IdTipoRequisicion in (1,2) ORDER BY req_conceptos.Concepto";	
								}
							}
						}
				

			}


		$rc= $conexion -> query($sql);
		$row_cnt = $rc->num_rows;
		
		if ($row_cnt>0)
		{			
		//	if($f = $rc -> fetch_array())
		//	{
					if (isset($_GET['busqueda']))
					{

  					  if (!empty(trim($_GET['busqueda'])))
								{
									historia($nitavu,'Req_Busqueda de '.$_GET['busqueda']);
								}
    				}

					
				
			
			while($cat = $rc -> fetch_array())		
			{
					if ($nivel==1)
						{
							echo "<article>";
							//foto
							echo $cat['IdConcepto'];
							echo ponerfoto("fotos_concepto/".$cat['IdConcepto'].".jpg",'req_catalago_foto');
							echo "<div class='req_catalago_descripcion'>".$cat['Concepto']."</div>";
							//echo "<br>";
							echo "<div class='req_catalago_botones'>";					
							echo validaProductoAgregado($cat['IdConcepto'],$idDepartamento,$_GET['busqueda']);
							
									if ($nivel==1)
											{					


												echo "<a class='btn2 btn-celesteTam' href='req_concepto_edit.php?n=".$cat['IdConcepto']."''  title='Editar'>
													<img src='icon/pluma.png' style='width: 20px;height: 12px;padding: 0px;margin: 0px;'>
													</a>";

												echo "<a class='btn2 btn-azulTam'    href='req.php?d=".$cat['IdConcepto']."'' title='Eliminar'>
													<img src='icon/papelera.png'   style='width: 20px;height: 12px;padding: 0px;margin: 0px;'>
													</a>";							
											}
							echo "</div>";
							echo "</article>";
						}

					if ($nivel==3)
						{
							//$archivo = "fotos_concepto/".$cat['IdConcepto'].".jpg";
						//	if (file_exists($archivo))
						//	{
								echo "<article>";
								//foto
								echo ponerfoto("fotos_concepto/".$cat['IdConcepto'].".jpg",'req_catalago_foto');
								echo "<div class='req_catalago_descripcion'>".$cat['Concepto']."</div>";			
								echo "<div class='req_catalago_botones'>";					
								echo validaProductoAgregado($cat['IdConcepto'],$idDepartamento,$_GET['busqueda']);
								
										if ($nivel==1)
												{			
												echo "<a class='btn2 btn-celesteTam'  href='req_concepto_edit.php?n=".$cat['IdConcepto']."''  title='Editar'>
													<img src='icon/pluma.png'  style='width: 20px;height: 12px;padding: 0px;margin: 0px;'>
													</a>";
													echo "<a class='Mbtn btn-azulTam btn_cat'   href='req.php?d=".$cat['IdConcepto']."''  title='Eliminar'>
													<img src='icon/papelera.png' class='btn_cat_img' >
													</a>";	

												}
								echo "</div>";

								echo "</article>";
							//}
						// else
						// 	{//si no hay archivo y no eres admin
						// 			//echo "sin foto";

						// 			req_alertas($nitavu, $cat['IdConcepto']); //graba que productos pudieron haberse visto si tuvieran foto
						// 	}
					  }



			//}
		}



		}
		else
		{
			historia($nitavu,'Req_Busqueda fallida de '.$_GET['busqueda']);
			req_sugerencia($nitavu, $_GET['busqueda']);
			echo "No hay productos encontrados.";
		}
	echo "</section>";

	
}






//  Agregar un producto a la requisicion.
if (isset($_GET['a']) )
	{
		


		if (isset($_GET['justificacion']) )
		{//AGREGAR SOLO SI HAY JUSTIFICACION, YA VIENE VALIDADA DEL FORM
		 $vjustificacion= trim($_GET['justificacion'],'&nbsp; ');
		$variableBusqueda=$_GET['bq'];
		$id = $_GET['a'];
		$cantidad=1;
		$idUnidad=1;
		if( empty($vjustificacion) )
			{	
				$msg='No ha especificado la justificación del producto';
				mensaje($msg,'req.php');
				

			}
		else
		{
			
			if(strlen($vjustificacion)<5)
			{
				$msg='La justificación es demasiado corta, favor de hacer una descripción mas detallada.';
				mensaje($msg,'req.php');

			}
			else
			{

				if(requisicionIdConcepto_add($id, $cantidad, $idUnidad,$idDepartamento,$nitavu, $vjustificacion)==TRUE)
				{
					historia ($nitavu,"Req_Agregó el concepto ".nombreIdConcepto($id)." a la requisicion del  ". nitavu_dpto_nombre($nitavu));
					mensaje("Producto agregado","req.php?brig=&busqueda=".$variableBusqueda);
					
				
				}
				else
				{
					$msg="Error inesperado "; //<-- Descripcion de error
				}
			}
		}
	} 
	else
		{
			echo '<div id="modal"></div>';
			echo "<div id='req_captura'>";
			echo "<form action='req.php' method='get'>";
			echo "<input type='hidden' name='a' value='".$_GET['a']."'>";
			echo "<input type='hidden' name='bq' value='".$_GET['bq']."'>";

			echo "<span>";
			echo "<label>Justificacion de <b class='normal'>".nombreIdConcepto($_GET['a'])."</b>:";
			echo "<textarea name='justificacion' ></textarea>";
			echo "</span>";

			echo "<label class='alerta'>* Es un requisito la justificacion </label>";
			echo '<label class="alerta"> AVISO: No se aceptará como justificación "Para uso de la Delegación" o "Para uso del Dpto."<br>Favor de ser más específico, de lo contrario su requisición podría ser rechazada. </label>';
			echo "<div><input type='submit' value='Agregar' class='Mbtn btn-danger' required></div>";
			echo "<div><input type='submit' name='salir'   value='Cancelar' class='Mbtn btn-danger' onClick=\" location.href=' req.php'\"></div>";

			echo "</form>";
			echo "</div>";

		}

	}


// si esta presente en la var m en la url, Mostrar lista de los productos de mis requisicion que esta activa	
if (isset($_GET['m']))
	{
		
	
/*		$sql = " -- req 
		SELECT req_detallerequisicion.IdDetalle,req_detallerequisicion.IdConcepto, req_conceptos.Concepto,SUM(req_detallerequisicion.Cantidad) AS Cantidad ,req_detallerequisicion.Justificacion,req_conceptos.IdTipoRequisicion, empleados.nombre FROM req_detallerequisicion inner join req_conceptos on req_detallerequisicion.IdConcepto=req_conceptos.IdConcepto inner join empleados on empleados.nitavu=req_detallerequisicion.Nitavu_crea where req_detallerequisicion.Cancelado=0 and ( req_detallerequisicion.IdRequisicion is null or req_detallerequisicion.IdRequisicion=0) and req_conceptos.Cancelado=0 and req_detallerequisicion.IdDepartamento='".nitavu_dpto($nitavu)."' GROUP BY req_detallerequisicion.IdConcepto";
*/
		$sql = " -- req 
		SELECT req_detallerequisicion.IdDetalle,req_detallerequisicion.IdConcepto, req_conceptos.Concepto,
		req_detallerequisicion.Cantidad ,
		req_detallerequisicion.Justificacion,req_conceptos.IdTipoRequisicion,
		 empleados.nombre FROM req_detallerequisicion inner join req_conceptos on req_detallerequisicion.IdConcepto=req_conceptos.IdConcepto 
		 inner join empleados on empleados.nitavu=req_detallerequisicion.Nitavu_crea where req_detallerequisicion.Cancelado=0
		  and ( req_detallerequisicion.IdRequisicion is null or req_detallerequisicion.IdRequisicion=0) and req_conceptos.Cancelado=0
		   and req_detallerequisicion.IdDepartamento='".nitavu_dpto($nitavu)."'  and  req_detallerequisicion.Estatus<>'OK' GROUP BY req_detallerequisicion.IdConcepto";
		
			$rc= $conexion -> query($sql);
			$row_cnt = $rc->num_rows;
			$cont=0;
			if($row_cnt>0)
			{
				echo "<script>
				var div = document.getElementById('enviar');
				console.log('entrp');
				div.style.display = 'inline-block';
				</script>";

				echo "<br>";
				ECHO "<h1  style='text-transform: uppercase;font-size: 14pt;'>Mi Requisición</h1><br>";	
				
					echo "<div class='centrar'>";
					echo"<table class='bordered'>";
						echo"<thead>
							<tr>
								<th class='pc'>#</th>
								<th style='display:none'></th>
								<th></th>
								<th>CONCEPTO</th>
								<th>CANTIDAD</th>
								<th class='pc'>JUSTIFICACIÓN</th>
								<th class='pc'>SOLICITANTE</th>
								<th> ACCIONES</th>
							</tr>";
						echo" </thead>
						<tbody><tr>";
							while($cat = $rc -> fetch_array())
							{ // resultado de la busqueda.................
							echo "<form  action='req_acciones_req_bd.php' method='POST' >";
								echo "<tr>";
									echo "<td class='centrar pc'>". $cont=$cont+1;  "</td>";
									echo "<td style='display:none'>  <input type='number' name='IdDetalle' value=".$cat['IdDetalle']."  class='centrar'></td>";
									echo "<td style='display:none'> ".$cat['IdTipoRequisicion']." </td>";
									echo "<td  class='centrar'>";
										echo "<div >";
											echo ponerfoto("fotos_concepto/".$cat['IdConcepto'].".jpg",'icono');
										echo "</div>" ;
									echo "</td>";
									echo "<td class='tchico tenue' > ".$cat['Concepto']." </td>";
									echo"<td  class='centrar' width='150px'> ";
								echo "<div style='width:100%;display:inline-block; padding:5px;' id='req_contenedor'>";
								echo "<input type='number' name='cant' value=".$cat['Cantidad']." min='1'  class='centrar' style='width:50%; height:35px; margin-right:5px;''  >";
								echo "<button type='submit'  name='btnLogA' id='btnLogA' class='Mbtn btn-celesteTam ' title='Actualizar'>";
								echo "<img src='icon/actualizar.png'  style='width: 25px;height: 14px; padding: 0px;'>";
								echo "</button>";
								echo "</div>";
								echo "</td>";	
									//echo"<td width=''  class='centrar tenue'>"; 
									/*echo "<div style='width:100%;display:inline-block; padding:5px;' id='req_contenedor'>";
									echo "<input type='number' name='cant' value=".$cat['Cantidad']." min='1'  style='width:50px;' required='required'>	
									";
									echo "<div class='movil' style='width:100%; margin-bottom:10px;'></div>";

									echo "
									<button type='submit'  name='btnLogA' id='btnLogA' class='Mbtn btn-celesteTam  ' title='Actualizar'>
										<img src='icon/actualizar.png' class='btn_cat_img'>
									</button></div>*/
									 //</td>";
									echo"<td class='pc tenue' >";
									echo "".$cat['Justificacion']."";
									echo "</td>";
									echo"<td class='pc tenue'>".$cat['nombre']."</td>";
									echo "<td  class='centrar' >
								

									<button type='submit' name='btnLogE' id='btnLogE'  class='Mbtn btn-cancel' title='Eliminar'>  <img src='icon/papelera.png' class='btn_cat_img' style='width: 25px;height: 14px;padding: 0px;'> </button></td>";
									
									
							echo "</form>";
							echo "</tr>";
							
							}
						echo "</tr>
					</tbody></table>";
					
				echo"</div>";
				echo"<br>";
				echo"<br>";
				echo"<br>";
				echo"<br>";	

				echo '<div class="normal">';
	$msg="
	<lu style='font-size:8pt;'>
		<li> Se recomienda ser más específico al momento de ingresar la justificación del producto solicitado.</li><br>
		<li> Solo se tomarán en cuenta aquellos productos que tengan capturada una justificación. </li>
		
	</lu>";


	echo sugerencia($msg,'');

	
	if (isset($_GET['m'])){
		echo "<br><div >"."<div>";
		echo "<label>Puedes buscar por nombre o parte de la descripcion</label>";
		buscar("req.php","Buscar un articulo",'');
		echo "</div>";
		echo "</div>";
	}	


	echo "</div>";					
			}
			else
			{
				
				echo "<div class='alert alert-danger'>";
				echo "<strong>No se han encontrado productos</strong> !";
				echo "</div>";
			}
	}
	
	// si esta presente en la var env en la url, marcar la requisción como enviada
if (isset($_GET['env']))
{

$sql=" -- req 
UPDATE req_detallerequisicion as dr	RIGHT JOIN req_conceptos AS rc on dr.IdConcepto=rc.IdConcepto 
			LEFT JOIN req_requisiciones AS rq on rq.IdRequisicion=dr.IdRequisicion		
			SET dr.Estatus='OK'	, dr.FechaEnvio=NOW(), dr.Nitavu_Mod=".$nitavu."				
			WHERE dr.Cancelado=0 AND -- rq.IdRequisicionGlobal IS NULL
			(dr.IdRequisicion is null or dr.IdRequisicion=0)
		 	AND rc.Cancelado=0  AND  dr.IdDepartamento=".nitavu_dpto($nitavu)." and dr.Justificacion is not null";

			$resultado = $conexion -> query($sql);
			if ($conexion->query($sql) == TRUE)
			{
				//historia ($nitavu,"Req_Eliminó del cátalogo de conceptos ".nombreIdConcepto($id));				
				mensaje ("La requisicíon se marcó con estatus enviada!!!!",'req.php');
			}
			else
			{
				$msg="Error inesperado ".$sql; //<-- Descripcion de error
			}
}


//  eliminar un producto del catalgo.
	if (isset($_GET['d']))
		{
		$sql = " -- req 
		SELECT * FROM req_conceptos where IdConcepto =".$_GET['d'];
		$rc= $conexion -> query($sql);
		while($cat = $rc -> fetch_array())
		{
			mensaje("¿Esta seguro de eliminar el concepto: ".$cat['Concepto']."?","req_concepto_delete_bd.php?d=".$cat['IdConcepto'],$cat['IdConcepto']);
		}
		echo "</section>";
	}
	echo "</div>";
	}




else{echo "<br><br>";
	mensaje("No tiene acceso al Modulo para Requisiciones (".$id_aplicacion.")", "index.php");}
		
?>
<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>

<?php include ("./lib/body_footer.php"); ?>