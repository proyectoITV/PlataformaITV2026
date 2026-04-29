<?php
include ("./lib/body_head.php");
?>
<?php

$id_aplicacion ="ap49";
$justificacion="";
$nivel =aplicacion_nivel($id_aplicacion, $nitavu);

  $anterior= $_SERVER['HTTP_REFERER'];

if (sanpedro($id_aplicacion, $nitavu)==TRUE and $nivel==1)
{
 $idReq = $_POST['idRequisicion'];
 $observaciones = $_POST['inputObservaciones'];
 $mensaje = $_POST['mensaje'];

 
$autorizar = strpos($mensaje, 'autorizada'); 
$cotizar = strpos($mensaje, 'cotización');
$detener = strpos($mensaje, 'detenida');
$rechazar=strpos($mensaje, 'rechazada');
$entregar=strpos($mensaje, 'entregada');   
$armado = strpos($mensaje, 'armado');   
$justificacion=strpos($mensaje,'justificación');
$reactivar=strpos($mensaje,'reactivar');
$idestatus=0;



 if (isset($_POST['salir'])) 
 	{
 	 echo '<script type="text/javascript"> window.location.assign("req_detalles.php?d='. $idReq.'");</script>';
	}
 else
 	{		


		if($justificacion !== false ) 
		{	
		
				
			if( empty(trim($observaciones) ))
			{	
				$msg='No ha especificado la justificación de la requisición';
				mensaje($msg,'req_detalles.php?d='. $idReq);
			}
			else
			{
			
				if(strlen(trim($observaciones))<10)
				{
					$msg='La justificación es demasiado corta, favor de hacer una descripción mas detallada.';
					mensaje($msg,'req_detalles.php?d='. $idReq);

				}
				else
				{
					$msg="Se agregó justificación a la requisición n° ".$idReq." con exito.";
					$sql=" -- req 
					UPDATE req_requisiciones SET  Justificacion=UPPER('".$observaciones."'),FechaMod=NOW(), Nitavu_Mod=".$nitavu ." WHERE IdRequisicion=".$idReq;
				
			
					$resultado = $conexion -> query($sql);
					
					if ($conexion->query($sql) == TRUE)
					{

						historia ($nitavu,"Req_Agregó justificación global a la requisición n° ".$idReq);				
						mensaje ($msg,'req_detalles.php?d='. $idReq);
					}
					else
					{
						$msg="Error inesperado ".$sql; //<-- Descripcion de error
					}				
				}
			}
		}
	
		else
		{
		

			if($rechazar !== false ) 
			{
				$idestatus=2;
				$asunto="Requisicion rechazada";
				$msg="La Requisición n° ".$idReq." fue marcada como rechazada";
			}
			if($autorizar !== false  ) 
			{		
				$idestatus=3;	
				$asunto="Requisicion autorizada";
				$msg="La Requisición n° ".$idReq." fue marcada como autorizada";	
			}

			if($armado !== false ) 
			{	
				$asunto="Requisicion en proceso armado";
				$msg="La Requisición n° ".$idReq." fue marcada que se encuentra en el proceso de armado";
				$idestatus=4;
			}

			if($entregar !== false ) 
			{	$asunto="Requisicion entregada";
				$msg="La Requisición n° ".$idReq." fue marcada  como entregada";
				$idestatus=5;
			}
			if($detener !== false ) 
			{	$asunto="Requisicion detanida";
				$idestatus=7;
				$msg="La Requisición n° ".$idReq." fue marcada  como detenida";
			}

			if($cotizar !== false ) 
			{	$asunto="Requisicion en proceso de cotización";
				$msg="La Requisición n° ".$idReq." fue marcada que se encuentra el proceso de cotización";
				$idestatus=9;
			}
			if($reactivar !== false ) 
			{		$asunto="Reactivación de la requisición";
					$msg="La Requisición n° ".$idReq." fue reactivada y continuará con el proceso correspondiente.";
					$idestatus=0;
			
				echo $idestatus;
					 $sql=" -- req 
					 UPDATE req_seguimiento SET  Cancelado='1',FechaMod=NOW(), Nitavu_Mod=".$nitavu.
					" WHERE IdRequisicion=".$idReq." and IdSeguimientoReq=(select * from (select max(rs.IdSeguimientoReq) from req_seguimiento as rs where rs.IdRequisicion=".$idReq." and rs.IdEstatus=2 and Cancelado=0)as tabla)";
					 if ($conexion->query($sql) == TRUE)
					 {
						historia($nitavu,'Req_Reactivó La Requisición n° '.$idReq.' y continuará con el proceso correspondiente.');
								 
						 
					 }
		 
					 else
					 {
						 $msg="Error inesperado ".$sql; //<-- Descripcion de error
					 }
			
			}


			
			
			
			
			if($idestatus==7 || $idestatus==2 || $idestatus==5)
	 			{	

				$vobservaciones=trim($observaciones,'&nbsp; ');
				

			        if(empty(trim($vobservaciones) ))
					{	
							$msg='No ha ingresado la información que se le pide.';
							mensaje($msg,'req_detalles.php?d='. $idReq);
					}
					else
					{
						if(strlen(trim($vobservaciones))<5 )
						{
							$msg='El texto que ha introducido es demasido corto, favor de ser más específico.';
							mensaje($msg,'req_detalles.php?d='. $idReq);

						}
						else
						{
						//mensaje(empty(trim($observaciones) ),'req_detalles.php?d='. $idReq);
						    if(InsertSeguimiento($idReq,$nitavu,$vobservaciones,$idestatus )==TRUE)
							{
												
									historia($nitavu,'Req_'.$msg.' IdRequisicion'.$idReq);	
									//header('location:../req_detalles.php?d='.$idReq);					
									$msgNoti ="<br><br> Por medio de la presente se le informa que "."<b>". $msg ." </b>.<br><br>				
									Para más información favor de revisar el seguimiento de dicha requisición, o ponerse en contacto con el Departamento de Adquisiciones.
									<br><br>";

										

									$sql=" -- req 
									SELECT  empleados.nitavu, empleados.correoelectronico,empleados.nombre 
									,(select empleados.nitavu from cat_gerarquia INNER JOIN empleados on cat_gerarquia.titular=empleados.nitavu  where cat_gerarquia.nombre like '%Adquicisiones%') as nitavuenvia
 									,(select empleados.correoelectronico  from cat_gerarquia INNER JOIN empleados on cat_gerarquia.titular=empleados.nitavu  where cat_gerarquia.nombre like '%Adquicisiones%') as correoelectronicoenvia
									,(select  empleados.nombre from cat_gerarquia INNER JOIN empleados on cat_gerarquia.titular=empleados.nitavu  where cat_gerarquia.nombre like '%Adquicisiones%') as nombreenvia
									from aplicaciones_permisos
       								INNER JOIN empleados on aplicaciones_permisos.nitavu=empleados.nitavu where empleados.dpto=".DptoIdRequisicion($idReq)." and aplicaciones_permisos.idapp='ap49'
									and aplicaciones_permisos.nivel=3 and empleados.nitavu NOT IN (select titular  from cat_gerarquia where id=".DptoIdRequisicion($idReq).") GROUP BY empleados.nitavu
									UNION
									SELECT  empleados.nitavu, empleados.correoelectronico,empleados.nombre 
									,(select empleados.nitavu from cat_gerarquia INNER JOIN empleados on cat_gerarquia.titular=empleados.nitavu  where cat_gerarquia.nombre like '%Adquicisiones%') as nitavuenvia
 									,(select empleados.correoelectronico  from cat_gerarquia INNER JOIN empleados on cat_gerarquia.titular=empleados.nitavu  where cat_gerarquia.nombre like '%Adquicisiones%') as correoelectronicoenvia
									,(select  empleados.nombre from cat_gerarquia INNER JOIN empleados on cat_gerarquia.titular=empleados.nitavu  where cat_gerarquia.nombre like '%Adquicisiones%') as nombreenvia
									from cat_gerarquia INNER JOIN empleados on cat_gerarquia.titular=empleados.nitavu where empleados.dpto=".DptoIdRequisicion($idReq)." GROUP BY empleados.nitavu";
								
									$tmp="";
									$r2 = $conexion -> query($sql);
																					 
										 while($fx = $r2 -> fetch_array())
										{										  
											notificacion_add ($fx['nitavu'], $asunto." #".$idReq, date('Y-m-d'), titularDpto(nitavu_dpto($nitavu)),$msgNoti);	
										//correo($fx['correoelectronico'], nitavu_nombre($fx['nitavu']), $fx['correoelectronicoenvia'], $fx['nombreenvia'],$asunto." #".$idReq , "<p  style=color:#666; font-family:Verdana, Geneva, sans-serif;>".$msgNoti."</p>", $fx['nitavu']);	
															
										}
									mensaje($msg ." con exito.",'req_detalles.php?d='.$idReq);	

							}
							else
							{
									$msg="Error inesperado "; //<-- Descripcion de error
							}
						}
					}
			}
			else if ($idestatus==0)
			{
				
					
									
								//historia($nitavu,'Req_'.$msg.' IdRequisicion '.$idReq);	
								//header('location:../req_detalles.php?d='.$idReq);					
								$msgNoti ="<br><br> Por medio de la presente se le informa que "."<b>". $msg ." </b>.<br><br>				
								 Para más información favor de revisar el seguimiento de dicha requisición, o ponerse en contacto con el Departamento de Adquisiciones.
								 <br><br>";
								$sql=" -- req 
									SELECT  empleados.nitavu, empleados.correoelectronico,empleados.nombre 
									,(select empleados.nitavu from cat_gerarquia INNER JOIN empleados on cat_gerarquia.titular=empleados.nitavu  where cat_gerarquia.nombre like '%Adquicisiones%') as nitavuenvia
 									,(select empleados.correoelectronico  from cat_gerarquia INNER JOIN empleados on cat_gerarquia.titular=empleados.nitavu  where cat_gerarquia.nombre like '%Adquicisiones%') as correoelectronicoenvia
									,(select  empleados.nombre from cat_gerarquia INNER JOIN empleados on cat_gerarquia.titular=empleados.nitavu  where cat_gerarquia.nombre like '%Adquicisiones%') as nombreenvia
									from aplicaciones_permisos
       								INNER JOIN empleados on aplicaciones_permisos.nitavu=empleados.nitavu where empleados.dpto=".DptoIdRequisicion($idReq)." and aplicaciones_permisos.idapp='ap49'
									and aplicaciones_permisos.nivel=3 and empleados.nitavu NOT IN (select titular  from cat_gerarquia where id=".DptoIdRequisicion($idReq).") GROUP BY empleados.nitavu
									UNION
									SELECT  empleados.nitavu, empleados.correoelectronico,empleados.nombre 
									,(select empleados.nitavu from cat_gerarquia INNER JOIN empleados on cat_gerarquia.titular=empleados.nitavu  where cat_gerarquia.nombre like '%Adquicisiones%') as nitavuenvia
 									,(select empleados.correoelectronico  from cat_gerarquia INNER JOIN empleados on cat_gerarquia.titular=empleados.nitavu  where cat_gerarquia.nombre like '%Adquicisiones%') as correoelectronicoenvia
									,(select  empleados.nombre from cat_gerarquia INNER JOIN empleados on cat_gerarquia.titular=empleados.nitavu  where cat_gerarquia.nombre like '%Adquicisiones%') as nombreenvia
									from cat_gerarquia INNER JOIN empleados on cat_gerarquia.titular=empleados.nitavu where empleados.dpto=".DptoIdRequisicion($idReq)." GROUP BY empleados.nitavu";
													
								
									$tmp="";
									$r2 = $conexion -> query($sql);
							                                 										 
										 while($fx = $r2 -> fetch_array())
										{
										notificacion_add ($fx['nitavu'], $asunto." #".$idReq, date('Y-m-d'), titularDpto(nitavu_dpto($nitavu)),$msgNoti);	
										//correo($fx['correoelectronico'], nitavu_nombre($fx['nitavu']), $fx['correoelectronicoenvia'], $fx['nombreenvia'],$asunto." #".$idReq , "<p  style=color:#666; font-family:Verdana, Geneva, sans-serif;>".$msgNoti."</p>", $fx['nitavu']);				
										}
										mensaje($msg ,'req_detalles.php?d='.$idReq);
										

						

			}	

			else
			{
				
					if(InsertSeguimiento($idReq,$nitavu,$observaciones,$idestatus )==TRUE)
						{
									
								historia($nitavu,'Req_'.$msg.' IdRequisicion '.$idReq);	
								//header('location:../req_detalles.php?d='.$idReq);					
								$msgNoti ="<br><br> Por medio de la presente se le informa que "."<b>". $msg ." </b>.<br><br>				
								 Para más información favor de revisar el seguimiento de dicha requisición, o ponerse en contacto con el Departamento de Adquisiciones.
								 <br><br>";
								$sql=" -- req 
									SELECT  empleados.nitavu, empleados.correoelectronico,empleados.nombre 
									,(select empleados.nitavu from cat_gerarquia INNER JOIN empleados on cat_gerarquia.titular=empleados.nitavu  where cat_gerarquia.nombre like '%Adquicisiones%') as nitavuenvia
 									,(select empleados.correoelectronico  from cat_gerarquia INNER JOIN empleados on cat_gerarquia.titular=empleados.nitavu  where cat_gerarquia.nombre like '%Adquicisiones%') as correoelectronicoenvia
									,(select  empleados.nombre from cat_gerarquia INNER JOIN empleados on cat_gerarquia.titular=empleados.nitavu  where cat_gerarquia.nombre like '%Adquicisiones%') as nombreenvia
									from aplicaciones_permisos
       								INNER JOIN empleados on aplicaciones_permisos.nitavu=empleados.nitavu where empleados.dpto=".DptoIdRequisicion($idReq)." and aplicaciones_permisos.idapp='ap49'
									and aplicaciones_permisos.nivel=3 and empleados.nitavu NOT IN (select titular  from cat_gerarquia where id=".DptoIdRequisicion($idReq).") GROUP BY empleados.nitavu
									UNION
									SELECT  empleados.nitavu, empleados.correoelectronico,empleados.nombre 
									,(select empleados.nitavu from cat_gerarquia INNER JOIN empleados on cat_gerarquia.titular=empleados.nitavu  where cat_gerarquia.nombre like '%Adquicisiones%') as nitavuenvia
 									,(select empleados.correoelectronico  from cat_gerarquia INNER JOIN empleados on cat_gerarquia.titular=empleados.nitavu  where cat_gerarquia.nombre like '%Adquicisiones%') as correoelectronicoenvia
									,(select  empleados.nombre from cat_gerarquia INNER JOIN empleados on cat_gerarquia.titular=empleados.nitavu  where cat_gerarquia.nombre like '%Adquicisiones%') as nombreenvia
									from cat_gerarquia INNER JOIN empleados on cat_gerarquia.titular=empleados.nitavu where empleados.dpto=".DptoIdRequisicion($idReq)." GROUP BY empleados.nitavu";
													
								
									$tmp="";
									$r2 = $conexion -> query($sql);
							                                 										 
										 while($fx = $r2 -> fetch_array())
										{
										notificacion_add ($fx['nitavu'], $asunto." #".$idReq, date('Y-m-d'), titularDpto(nitavu_dpto($nitavu)),$msgNoti);	
										//correo($fx['correoelectronico'], nitavu_nombre($fx['nitavu']), $fx['correoelectronicoenvia'], $fx['nombreenvia'],$asunto." #".$idReq , "<p  style=color:#666; font-family:Verdana, Geneva, sans-serif;>".$msgNoti."</p>", $fx['nitavu']);				
										}
										mensaje($msg ." con exito.",'req_detalles.php?d='.$idReq);	

						}
						else
						{
								$msg="Error inesperado "; //<-- Descripcion de error
						}

			}	
		}					
	}
}	
			    
else
{
	echo "	<br><br>";
	echo "No tiene acceso a ".$id_aplicacion;
}

          

     
    ?>