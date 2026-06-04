<?php
/*FUNCIONES PERSONALIZADAS */
/*eJEMPLO */
function mifunciony($variable){
require("config.php"); /*No mover*/
$sql = " -- req 
SELECT * FROM empleados WHERE nitavu='".$variable."'";
$rc= $conexion -> query($sql);
	if($f = $rc -> fetch_array())
	{
		return $f['nombre'];
							
	}
	else
	{
		return FALSE;
	}
}
function siguienteIdConcepto()
{
	require("config.php"); /*No mover*/
	$sql = " -- req 
	SELECT max(IdConcepto) as IdConcepto FROM req_conceptos" ;
	$rc= $conexion -> query($sql);
	if($f = $rc -> fetch_array())
	{
		return $f['IdConcepto']+1;
							
	}
	else
	{
		return FALSE;
	}
}
function nombreIdConcepto($id)
{
		require("config.php");
		$sql = " -- req 
		SELECT * FROM req_conceptos WHERE IdConcepto='".$id."'";
		$rc= $conexion -> query($sql);
		if($f = $rc -> fetch_array())
		{
			return $f['Concepto'];					
		}
		else
		{
			return FALSE;
		}
}
function numProductosReq($id)
{
		require("config.php");
		$sql=" -- req 
			SELECT IFNULL(SUM(req_detallerequisicion.Cantidad),0) as numProductos 
			FROM req_detallerequisicion inner join req_conceptos on req_detallerequisicion.IdConcepto
			=req_conceptos.IdConcepto where req_detallerequisicion.Cancelado=0  and req_conceptos.Cancelado=0 
			and (req_detallerequisicion.IdRequisicion is null or req_detallerequisicion.IdRequisicion=0) 
			and req_detallerequisicion.IdDepartamento='".$id."'";
			  echo $sql;
		$rc= $conexion -> query($sql);
		if($f = $rc -> fetch_array())
		{
			return $f['numProductos'];					
		}
		else
		{
			return FALSE;
		}
}
function numProductosReq2($id){
    require("config.php");
   
    $cant = 0;
   $sql = " -- req 
		SELECT req_detallerequisicion.IdDetalle,req_detallerequisicion.IdConcepto, req_conceptos.Concepto,
		req_detallerequisicion.Cantidad ,
		req_detallerequisicion.Justificacion,req_conceptos.IdTipoRequisicion,
		 empleados.nombre FROM req_detallerequisicion inner join req_conceptos on req_detallerequisicion.IdConcepto=req_conceptos.IdConcepto 
		 inner join empleados on empleados.nitavu=req_detallerequisicion.Nitavu_crea where req_detallerequisicion.Cancelado=0
		  and ( req_detallerequisicion.IdRequisicion is null or req_detallerequisicion.IdRequisicion=0) and req_conceptos.Cancelado=0
		   and req_detallerequisicion.IdDepartamento='".$id."' and req_detallerequisicion.Estatus<>'OK' GROUP BY req_detallerequisicion.IdConcepto";
    $r = $conexion -> query($sql); 
    while($f = $r -> fetch_array()){
        $cant = $cant+$f['Cantidad'];
    }    
    
    return $cant;
}
	function requisicionIdConcepto_add($idConcepto, $cantidad, $idUnidad,$idDepartamento,$quien, $justificacion){
	require("config.php");
		$sql = " -- req 
		INSERT INTO req_detallerequisicion
			(IdConcepto, Cantidad, IdUnidad, IdDepartamento,Cancelado,Nitavu_crea,FechaCrea, Justificacion)
				VALUES
					( '$idConcepto', '$cantidad', '$idUnidad', $idDepartamento,'0','$quien',NOW(), '$justificacion')";
					// echo $sql;
							
							if ($conexion->query($sql) == TRUE)
								{
									return TRUE;
										//header('location:../index.php');
								}
								else
								{
									return FALSE;
									//echo $sql;
								}
						}
function requisicionIdConcepto_baja($idDetalle,$quien)
{
	require("config.php");
		$sql = " -- req 
		UPDATE req_detallerequisicion SET Cancelado=1 ,Nitavu_mod='".$quien."',FechaMod=NOW() WHERE IdDetalle=".$idDetalle;
		if ($conexion->query($sql) == TRUE)
		{
			return TRUE;
			//header('location:../index.php');
		}
		else
		{
			return FALSE;
			//echo $sql;
		}
}

function requisicionIdConcepto_actualiza($idDetalle,$quien,$cantidad)
{
	require("config.php");
		$sql = " -- req
		UPDATE req_detallerequisicion SET Cantidad=".$cantidad. ", Nitavu_mod='".$quien."',FechaMod=NOW() WHERE IdDetalle=".$idDetalle;
					
	if ($conexion->query($sql) == TRUE)
	{
		return TRUE;
										//header('location:../index.php');
	}
	else
	{
		return FALSE;
	}
									
}

function validaProductoAgregado($idConcepto,$idDepartamento,$busqueda)
	{
		require("config.php");
			$sql = " -- req
			SELECT count(*) as cantidad,req_conceptos.Concepto FROM req_detallerequisicion 
			INNER JOIN req_conceptos on req_detallerequisicion.IdConcepto=req_conceptos.IdConcepto  
			WHERE req_detallerequisicion.Cancelado=0 AND req_conceptos.Cancelado=0 
			AND (req_detallerequisicion.FechaEnvio IS NULL)
			and req_detallerequisicion.IdDepartamento=".$idDepartamento."  AND (req_detallerequisicion.IdRequisicion IS NULL or req_detallerequisicion.IdRequisicion=0) AND  req_conceptos.IdConcepto=".$idConcepto;
			//echo $sql;
			$rc= $conexion -> query($sql);			
			$msg="";
			
			if($f = $rc -> fetch_array())
				{
					//echo 'canntidad'.$f['cantidad'];
					if ($f['cantidad']>=1)
					{
					echo "<a class='btn2 btn-grisTam'  title='Ya esta agregado'>
						<img src='icon/cesta.png' style='width: 20px;height: 14px; padding: 0px;'>
						</a>";
					}
				
					else
					{
							echo "<a class='btn2 btn-verdeTam ' href='req.php?a=".$idConcepto."&bq=".$busqueda."'''  title='Solicitar'>
								<img src='icon/check.png' style='width: 25px;height: 14px; padding: -5px;'>
							</a>";
						
					}
				}
				else
				{ 
					
					return FALSE;
				}
	
	}

function InsertSeguimiento($idRequisicion,$quien,$observaciones,$idestatus)
	{
	require("config.php");
		
		$sql = " -- req 
		INSERT INTO req_seguimiento
			(IdRequisicion, Nitavu_crea,FechaCrea, Observaciones,IdEstatus, IdSeguimientoReq)
				VALUES
					( '$idRequisicion', '$quien',NOW(),'$observaciones','$idestatus',(select max(rs.IdSeguimientoReq) from req_seguimiento as rs where rs.IdRequisicion=".$idRequisicion.")+1)";
	
				if ($conexion->query($sql) == TRUE)
				{								
					return TRUE;
					//header('location:../index.php');
				}
				else
				{
					return FALSE;
					//echo $sql;
				}
}
function mensaje1($mensaje, $link,$id){
	if ($link=="") {$link = "../index.php";}
	echo '<div id="modal"></div>';
		echo "<div id='req_captura'>";
		echo '<form action="req_accciones_reqAdm_bd.php" method="POST">';
		echo "<span>";	
		echo '<input type="hidden" name="idRequisicion" value="'.$id.'" > '; 		
		
  		echo '<label for="mensaje">'.$mensaje.' </label>';
   		echo '<input type="hidden" name="mensaje" id="mensaje" value="'.$mensaje.'"></input>';
 	    echo '<input type="hidden" name="inputObservaciones" id="inputObservaciones" > ';	
		echo '</span>';
		echo '<div><input type="submit" name="Grabar" id="Grabar" value="Aceptar" class="Mbtn btn-default"></div>';
	   	echo '<div><input type="submit" name="salir"   value="Cancelar" class="Mbtn btn-default"></div>';
		echo '</form>';
		echo '</div>';
	}
	function mensaje2($mensaje, $link,$id){
		if ($link=="") {$link = "../index.php";}
	
		echo '<div id="modal"></div>';
			echo "<div id='req_captura'>";
			echo '<form action="req_accciones_reqAdm_bd.php" method="POST">';
			echo "<span>";	
			echo '<input type="hidden" name="idRequisicion" value="'.$id.'" > '; 		
			
			  echo '<label for="mensaje">'.$mensaje.' </label>';
			   echo '<input type="hidden" name="mensaje" id="mensaje" value="'.$mensaje.'"></input>';
			//echo '<textarea  name="inputObservaciones" id="inputObservaciones" ></textarea> ';	
			 echo '<input type="text"  name="inputObservaciones" id="inputObservaciones" > ';
			echo '</span>';
			echo '<div><input type="submit" name="Grabar" id="Grabar" value="Aceptar" class="Mbtn btn-default"></div>';
			   echo '<div><input type="submit" name="salir"   value="Cancelar" class="Mbtn btn-default"></div>';
			echo '</form>';
			echo '</div>';
		}
	
	
function titularDpto($dpto)
{
	require("config.php");
	$sql = " -- req 
	SELECT rq.IdRequisicion,rq.IdDepartamento, em.nitavu
	FROM req_requisiciones AS rq INNER JOIN req_detallerequisicion AS dr on rq.IdRequisicion=dr.IdRequisicion  
	INNER JOIN cat_gerarquia AS cg ON cg.id=dr.IdDepartamento LEFT JOIN cat_gerarquia AS cgg ON cgg.id=cg.dependencia
	INNER JOIN empleados as em on cg.titular=em.nitavu WHERE rq.IdDepartamento ='".$dpto."'"." GROUP BY IdRequisicion";
	$rc= $conexion -> query($sql);
	$msg="";
	if($f = $rc -> fetch_array())
	{
		return $f['nitavu'];
	}
	else
	{ 	
		return 'FALSE';}
}

function DptoIdRequisicion($id){
	require("config.php");
	$sql = " -- req 
	SELECT rq.IdRequisicion,rq.IdDepartamento, em.nitavu
	FROM req_requisiciones AS rq INNER JOIN req_detallerequisicion AS dr on rq.IdRequisicion=dr.IdRequisicion  
	INNER JOIN cat_gerarquia AS cg ON cg.id=dr.IdDepartamento LEFT JOIN cat_gerarquia AS cgg ON cgg.id=cg.dependencia
	INNER JOIN empleados as em on cg.titular=em.nitavu WHERE rq.IdRequisicion ='".$id."'"." GROUP BY rq.IdRequisicion";
	$rc= $conexion -> query($sql);
	$msg="";
	if($f = $rc -> fetch_array())
	{
		return $f['IdDepartamento'];
	}
	else
	{ return 'FALSE';}
}

function persona_nombre($id)
{	
	require("config.php");
	$sql = "-- per 
	SELECT * FROM solicitantes WHERE IdSolicitante='".$id."'";
	$rc= $conexion -> query($sql);
	$msg="";
	if($f = $rc -> fetch_array())
	{					
		return $f['Nombre'].". ".$f['Paterno'].". ".$f['Materno'];
	}					
	else
	{ 
		return FALSE;
	}

}

function ndocumento($consulta){
	require("config.php");
		$sql = "SELECT * FROM contadores WHERE id='0'";					
		$rc= $conexion -> query($sql);
			if($f = $rc -> fetch_array())
				{
					if ($consulta==TRUE)
					{
						return $f['ndocumento'];
					}
					else
						{ // sino es consulta entonces aumentarle y aumentar el contador de ceropapel
						// la diferencia entre ceropapel y este, es que cero papel se multiplica
						// por las copias que se entregan o con copia, para estadistica de cuanto se ha ahorrado
							$n2 = $f['ndocumento'] + 1;
							$sql="UPDATE contadores SET ndocumento='".$n2."' WHERE id='0'";
							$resultado = $conexion -> query($sql);
								if ($conexion->query($sql) == TRUE) 
								{
									return $f['ndocumento'];
								}
								else {
									return  FALSE;}
								}
							}
							else
							{
								 return FALSE;
							}
}
					
function documento_add ($ndoc, $nombre, $itavu)
{
	require("config.php");
	$sql = "INSERT INTO documentos
		(ndocumento, nombre, fecha, nitavusube, cancelado,fechaultimamod)
	VALUES
		('$ndoc', '$nombre', now(),'$itavu', 0, NULL)";
	if ($conexion->query($sql) == TRUE)
	{
		// historia($nitavu,'Subi el archivo: "'. $nombre);
		return  "TRUE";
	}
	else
	{
		return  "FALSE";
	}
}

function listar_archivos($carpeta, $usuario){
    if(is_dir($carpeta)){//comprueba que $carpeta sea un directorio
        if($dir = opendir($carpeta)){//abre el directrio
            //recorre el directorio mientras haya archivos
            while(($archivo = readdir($dir)) !== false){
                //el if compara que no sea elementos . .. o htaccess
                if($archivo != '.' && $archivo != '..' && $archivo != '.htaccess'){
                    //creamos nuestro elemento comparativo
                    //por medio de una funcion de cadena
                    $comparacion = substr($archivo, 0, 9);
                    //comparamos el elemento con nuestro patron
                    //y si se cumple mostramos el elemento
                    if ($usuario == $comparacion){
                        echo '<a target="_blank" href="'.$carpeta.'/'.$archivo.'">'.$archivo.'</a><br>';
                    }
                }
            }
            closedir($dir);
        }
    }
}
function RezagadosPorEstatus($idEstatus)
{
require("config.php"); /*No mover*/
	$sql = "-- req 
	select IdEstatus, COUNT(IdEstatus) as Rezagados ,Dias,Fecha, Hoy from   (SELECT  rq.IdEstatus, rq.IdRequisicion,
    DATEDIFF(CURDATE(),(select FechaCrea from req_seguimiento where IdEstatus =".$idEstatus. " and IdRequisicion=rq.IdRequisicion ORDER BY IdSeguimientoReq desc limit 1)) as Dias,
	(select FechaCrea from req_seguimiento where IdEstatus =".$idEstatus. " and IdRequisicion=rq.IdRequisicion ORDER BY IdSeguimientoReq desc limit 1) as  Fecha,
	CURRENT_TIMESTAMP() as Hoy
	from req_seguimiento as rs inner join req_requisiciones  as rq on rs.IdRequisicion=rq.IdRequisicion
   left join req_estatusreq on req_estatusreq.IdEstatus=rq.IdEstatus
   where rq.IdEstatus=".$idEstatus. " and  DATEDIFF(CURDATE(),(select FechaCrea from req_seguimiento where IdEstatus =".$idEstatus. " and IdRequisicion=rq.IdRequisicion ORDER BY IdSeguimientoReq desc limit 1))>".$req_rezagoMax." 
   and rq.IdEstatus not in (5,2)
   GROUP BY rq.IdRequisicion) as tabla
   GROUP BY IdEstatus";
   $rc= $conexion -> query($sql);
	if($f = $rc -> fetch_array())
	{
		return array($f['Rezagados'],$f['Fecha'],$f['Hoy']);
							
	}
	else
	{
		return FALSE;
	}
	}
	function tiempoTranscurridoFechas($fechaInicio,$fechaFin)
	{
		$fecha1 = new DateTime($fechaInicio);
		$fecha2 = new DateTime($fechaFin);
		$fecha = $fecha1->diff($fecha2);
		$tiempo = "";
			 
		//años
		if($fecha->y > 0)
		{
			$tiempo .= $fecha->y;
				 
			if($fecha->y == 1)
				$tiempo .= " año, ";
			else
				$tiempo .= " años, ";
		}
			 
		//meses
		if($fecha->m > 0)
		{
			$tiempo .= $fecha->m;
				 
			if($fecha->m == 1)
				$tiempo .= " mes ";
			else
				$tiempo .= " meses ";
		}
			 
		//dias
		if($fecha->d > 0)
		{
			$tiempo .= $fecha->d;
				 
			if($fecha->d == 1)
				$tiempo .= " día ";
			else
				$tiempo .= " días ";
		}
			 
		//horas
		if($fecha->h > 0)
		{
			$tiempo .= $fecha->h;
				 
			if($fecha->h == 1)
				$tiempo .= " hora ";
			else
				$tiempo .= " horas ";
		}
			 
		// //minutos
		// if($fecha->i > 0)
		// {
		// 	$tiempo .= $fecha->i;
				 
		// 	if($fecha->i == 1)
		// 		$tiempo .= " minuto";
		// 	else
		// 		$tiempo .= " minutos";
		// }
		// else if($fecha->i == 0) //segundos
		// 	$tiempo .= $fecha->s." segundos";
			 
		return $tiempo;
	}
	
 function ndocumentoCorrespondencia($consulta, $idDepartamento,$tipoDoc)
 {
		require("config.php");
		$sql = "SELECT * FROM cat_gerarquia WHERE id='".$idDepartamento."'";
		$rc= $conexion -> query($sql);
		if($f = $rc -> fetch_array())
		{
			if ($consulta==TRUE) 
			{
				return $f[$tipoDoc];
			
			}
			else
			{ // sino es consulta entonces aumentarle y aumentar el contador de ceropapel
			// la diferencia entre ceropapel y este, es que cero papel se multiplica
			// por las copias que se entregan o con copia, para estadistica de cuanto se ha ahorrado
				$n2 = $f[$tipoDoc] + 1;
				$sql="UPDATE cat_gerarquia SET ". $tipoDoc."='".$n2."' WHERE  id='".$idDepartamento."'";
					
					$resultado = $conexion -> query($sql);
					if ($conexion->query($sql) == TRUE) 
					{ 
						return $f[$tipoDoc];
					}
					else 
					{
						return  FALSE;}
					}
		}
		else
		{ 
			return FALSE;
		}
	} 


	function soyDireccion($id)
	{
		require("config.php");		
		$sql = "SELECT * FROM cat_gerarquia WHERE (id='".$id."')";	
		$rc= $conexion -> query($sql);
		if($f = $rc -> fetch_array())
		{ 
			if(strtoupper($f['nivel'])=='DIR'  )
			{
				return $f['id'];				
				
			}
			else
			{ 
						
			return FALSE;
			}
		}
		else
		{
			return '';
		}
	}
		
		
	
		function consultaIdTipoDocumento($id,$consulta)
 {
		 require("config.php");
		 if($consulta==TRUE)
		 {
		 $sql=" -- cp 		
		 SELECT * from cp_controlcorrespondencia where id=".$id;
		 }else
		 {
			$sql=" -- cp 		
			SELECT * from cat_tipo_documento where IdTipoDocumento=".$id;
		 }
		 $rc= $conexion -> query($sql);
		 if($f = $rc -> fetch_array())
		 {
			 
			if( $f['IdTipoDocumento']==1)
			{
				$tipodocumento="Oficio";
			}
			else if($f['IdTipoDocumento']==2)
			{
				$tipodocumento="Memo";		
			}
			else if( $f['IdTipoDocumento']==3)
			{
				$tipodocumento="Circular";		
			} else
			{
				$tipodocumento="Tarjeta";	
			}
			 return $tipodocumento;					
		 }
		 else
		 {
			 return FALSE;
		 }
 }
	
 function consultaIniciales($id)
 {
		 require("config.php");
		 $sql=" -- cp 
		 SELECT * from cat_gerarquia where id=".$id;
		 $rc= $conexion -> query($sql);
		 if($f = $rc -> fetch_array())
		 {
			 return $f['nomenclatura'];					
		 }
		 else
		 {
			 return FALSE;
		 }
 }
 	
 function quienEsmiDireccion($id)
 {
require("config.php");
$idDir='';
$entrar=true;
while ($entrar==true)
{
   
	$sql = "SELECT * FROM cat_gerarquia WHERE id='".$id."'";
	//echo $sql;
	if ($conexion->query($sql) == TRUE)
	{	
		$rc= $conexion -> query($sql);
		if($f = $rc -> fetch_array())
		{
		   
			 if( soyDireccion($id)==FALSE && $id<>'0')
			 { 
				
				$idDir=$f['id'];		
			   
				if($f['dependencia']<>''&& $f['id']<>'0')
					{					
						$id=$f['dependencia'];
					}
			   
				  
		   }
		   else{
			   $idDir=$f['id']	;
			   $entrar=false;
		   } 
		}	
   }	 
}

return $idDir;
   
}
	
  function consultaInicialesJerarquia($id)
  {
require("config.php");
$iniciales='';
$entrar=true;
while ($entrar==true)
{
	
 	$sql = "SELECT * FROM cat_gerarquia WHERE id='".$id."'";
 
 	if ($conexion->query($sql) == TRUE)
 	{	
		 $rc= $conexion -> query($sql);
 		if($f = $rc -> fetch_array())
 		{
			
 			 if( soyDireccion($id)==FALSE && $id<>'0')
 			 { 
				 
				  $iniciales=$f['nomenclatura']."/". $iniciales;		
				
				 if($f['dependencia']<>''&& $f['id']<>'0')
				 	{					
				 		$id=$f['dependencia'];
				 	}               
			}
			else{
				$iniciales=$f['nomenclatura']."/". $iniciales;	
				$entrar=false;
			} 
		 }	
	}	 
}
 
 return $iniciales;
	
}
function submenu_add2($url, $icono, $texto1, $texto2){
	echo "<article style='width:auto'>";
	echo "<a href='$url' rel='MyModal:open'>";
	echo "<table width=100%><tr><td width=30%>";		
	echo "<img src='icon/$icono' style='width:30px'></td>";
	echo "<td width=50% class='pc'><a href='$url'>$texto1<br><b> $texto2</b></a></td>";
	echo "</tr></table></a>";
	echo "</article>";
}
function ColaboradoresyParticipantes($numcaso,$id){
    require("config.php");
    $info = "";
    $sql = "select cp_colaboradores.nitavu, cp_colaboradores.numcaso from cp_colaboradores
	where cp_colaboradores.numcaso=".$numcaso ." and cp_colaboradores.nitavu<>".$id." and activo=0";
	//echo $sql;
	$r = $conexion -> query($sql);
	 while($f = $r -> fetch_array())
	 {
        $info = $info.$f['nitavu'].'/';
    }
    return $info;
}
function notificarParticipantes ($numcaso,$id,$msgNoti,$asunto)
{
	$colaboradores = ColaboradoresyParticipantes($numcaso,$id);
	$empl = explode('/',$colaboradores);
	for($i=0; $i < sizeof($empl); $i++)
	{
	
		if($empl[$i]!=null || $empl[$i]!= ""){
			notificacion_add ($empl[$i], $asunto, date('Y-m-d'),$id, $msgNoti);
		}
	
	}
}
function soyColaborador_caso($numcaso,$id){
	require("config.php");
	$sql = "SELECT * FROM cp_colaboradores WHERE nitavu='".$id."' and activo=0 and numcaso=".$numcaso;
	$rc= $conexion -> query($sql);
	$msg="";
	if($f = $rc -> fetch_array())
	{
	return $f['nitavu'];
	}
	else{ 
		return 'FALSE';}
	}
	
function obtenerextarchivo($archivo){
	$numero= explode('.',$archivo);											
	
	return $numero;
}
function obtenertipo($idmunicipio, $idcolonia, $idmandante, $iddesarrollador,$idprograma)
{
	
	// Identificamos si es una colonia, un mandante, un programa, etc
    if($idmunicipio==0& $idcolonia==0&& $idmandante==0 && $iddesarrollador==0 && $idprograma<>0)     
    {
       $tipo='P';
    }
    else if($idmunicipio<>0& $idcolonia<>0&& $idmandante== 0 && $iddesarrollador<>0 && $idprograma==0)
    {
       $tipo='D';
    }
     else if($idmunicipio<>0& $idcolonia<>0&& $idmandante<> 0 && $iddesarrollador==0 && $idprograma==0)
     {
        $tipo='M';
     }
     else if($idmunicipio<>0 && $idcolonia<>0 && $idmandante==0 && $iddesarrollador==0 && $idprograma==0)
     {
      $tipo='C';
	 }
	 return $tipo;
}
function obtenerultimodoc($idpestaña,$idmunicipio, $idcolonia, $idmandante, $iddesarrollador,$idprograma,$tipo){
    
    require("config.php");
    
        $sql = "-- mt 
        select  mt_documentos.*, documentos.nombre  from mt_documentos inner join documentos
	 on mt_documentos.ndocumento=documentos.ndocumento where documentos.cancelado=0 and pestaña=".$idpestaña.
        " and idmunicipio=".$idmunicipio." and idcolonia=".$idcolonia.
        " and idmandante=".$idmandante." and iddesarrollador=".$iddesarrollador." and idprograma=".$idprograma .
        " order by idinc desc limit 1";    
		// echo $sql;
         $rc= $conexion -> query($sql);
         if($f = $rc -> fetch_array())
         {
                                                        
            //  $res=obtenerextarchivo($f['archivo']);
            // return $res[0]."_".$tipo.$idpestaña."-".$f['iddoc'].'.'.$res[1];
             //$archivo1 = "documentos/".$res[0]."_".$tipo.$idpestaña."-".$numdocumento.".".$res[1];                    
             return  "documentos/".$f['ndocumento'].'_'.$tipo.$idpestaña.'-'.$f['nombre'];
            
            }
         else
         {
             return false;
         }
}
function obtenerdatoconsultado($idmunicipio, $idcolonia, $idmandante, $iddesarrollador,$idprograma,$tipo){
    
    require("config.php");
    
    // verificamos si es una colonia
    
    if ($tipo=='C')
    {
        $sql = "-- mt
        select cat_colonias.idmunicipio, cat_colonias.idcolonia, cat_municipios.municipio, cat_colonias.colonia, 'colonias' as tipo
                from         cat_colonias left outer join
                 cat_municipios on cat_colonias.idmunicipio = cat_municipios.idmunicipio
                 where cat_colonias.idmunicipio=".$idmunicipio." and cat_colonias.idcolonia=".$idcolonia ;  
    }
    // verificamos si es un programa
    else if ($tipo=='P')
    {
        $sql = "-- mt
        select IdPrograma , Programa, 'programas' as tipo from cat_programa where cat_programa.IdPrograma=".$idprograma; 
    }
    // verificamos si es un mandante
    else if ($tipo=='M')
    {
        $sql = "-- mt
        select  cat_mandantes.mandante ,  cat_colonias.idmunicipio as idmunicipio, cat_municipios.municipio  
                as municipio, 
                cat_colonias.idcolonia as idcolonia,   cat_colonias.colonia, 
                'mandantes' as tipo, cat_mandantes.idmandante                       
                from         cat_municipios right outer join
                cat_colonias on cat_municipios.idmunicipio = cat_colonias.idmunicipio right outer join
                cat_mandantes on cat_colonias.idmunicipio = cat_mandantes.idmunicipio and 
                cat_colonias.idcolonia = cat_mandantes.idcolonia
                where cat_mandantes.idmunicipio=".$idmunicipio." and cat_mandantes.idcolonia=".$idcolonia." and cat_mandantes.idmandante=".$idmandante;  
                //order by mandante,municipio,colonia";
                
    }
    // verificamos si es un desarrollador
    else if ($tipo=='D')
    {
        $sql = "-- mt
        select     convdesarrollador.folio as idconvenio,convdesarrollador.idprograma,convdesarrollador.iddesarrollador,convdesarrollador.iddelegacion, cat_desarrolladores.nombre, 
                convdesarrollador.montoconvenio, convdesarrollador.plazoconvenio, convdesarrollador.totallotes,  convdesarrollador.fechaconvenio,
                convdesarrollador.idcolonia,convdesarrollador.completo, convdesarrollador.addendumal as aladdendum, convdesarrollador.addendum,
                convdesarrollador.idmunicipio , cat_municipios.municipio, convdesarrollador.fechaultimamod, 
                convdesarrollador.fechacaptura,
                convdesarrollador.subsidiolote*convdesarrollador.totallotes as subsidio 
                from  cat_desarrolladores inner join convdesarrollador on cat_desarrolladores.iddesarrollador = convdesarrollador.iddesarrollador inner join 
                cat_municipios on convdesarrollador.idmunicipio = cat_municipios.idmunicipio 
                where cat_municipios.idmunicipio=".$idmunicipio." and convdesarrollador.iddesarrollador=".$iddesarrollador; 
                //order by  cat_desarrolladores.nombre
                 
    }
   
		// echo $sql;
         $rc= $conexion -> query($sql);
         if($f = $rc -> fetch_array())
         {
                                                        
            //  $res=obtenerextarchivo($f['archivo']);
            // return $res[0]."_".$tipo.$idpestaña."-".$f['iddoc'].'.'.$res[1];
             //$archivo1 = "documentos/".$res[0]."_".$tipo.$idpestaña."-".$numdocumento.".".$res[1];
             if ($tipo=='C')
                {                   
             return  $f['municipio']."_". $f['colonia'];
                }
                else if ($tipo=='P')
                {                   
             return  $f['IdPrograma']."_". $f['Programa'];
                }
                else if ($tipo=='M')
                {                   
                    return   $f['mandante']."_". $f['municipio']."_". $f['colonia'];
                }
                else if ($tipo=='D')
                {                   
                return   $f['nombre']."_". $f['municipio']."_". $f['idconvenio'];
                }
            
            }
         else
         {
             return false;
         }
}
 
function obtenerultimafotonot($contrato,$campaña){
    
    require("config.php");
    
		$sql = "-- not
		select * from  not_documentos where tipo=1 and contrato='".$contrato."' and idcam=".$campaña."  ORDER BY id DESC LIMIT 1";      
        
		
         $rc= $conexion -> query($sql);
         if($f = $rc -> fetch_array())
         {                                                        
            //  $res=obtenerextarchivo($f['archivo']);
            // return $res[0]."_".$tipo.$idpestaña."-".$f['iddoc'].'.'.$res[1];
             //$archivo1 = "documentos/".$res[0]."_".$tipo.$idpestaña."-".$numdocumento.".".$res[1];                    
             return  "Notificadores/".$f['doc'].'_'.$f['nombre'];
            
            }
         else
         {
             return "Notificadores/sinfoto.jpg";
		 }
		 
}
/*-------------------------FUNCTIONES TRAMITES-------------------------------*/
function ntramite($consulta){
	require("config.php");
	$sql = "SELECT * FROM contadores WHERE id='0'";
	$rc= $conexion -> query($sql);
	if($f = $rc -> fetch_array())
	{
		if ($consulta==TRUE) {
		return $f['ntramite'];
	}
	else
	{ // sino es consulta entonces aumentarle y aumentar el contador de ceropapel
	// la diferencia entre ceropapel y este, es que cero papel se multiplica
	// por las copias que se entregan o con copia, para estadistica de cuanto se ha ahorrado
		$n2 = $f['ntramite'] + 1;
		$sql="UPDATE contadores SET ntramite='".$n2."' WHERE id='0'";
		$resultado = $conexion -> query($sql);
		if ($conexion->query($sql) == TRUE) {
		return $f['ntramite'];
		}
		else {return  FALSE;}
		}
		}
		else
		{ return FALSE;}
}
function ndoctramite($consulta){
	require("config.php");
	$sql = "SELECT * FROM contadores WHERE id='0'";
	$rc= $conexion -> query($sql);
	if($f = $rc -> fetch_array())
	{
		if ($consulta==TRUE) {
		return $f['ndoctramite'];
	}
	else
	{ // sino es consulta entonces aumentarle y aumentar el contador de ceropapel
	// la diferencia entre ceropapel y este, es que cero papel se multiplica
	// por las copias que se entregan o con copia, para estadistica de cuanto se ha ahorrado
		$n2 = $f['ndoctramite'] + 1;
		$sql="UPDATE contadores SET ndoctramite='".$n2."' WHERE id='0'";
		$resultado = $conexion -> query($sql);
		if ($conexion->query($sql) == TRUE) {
		return $f['ndoctramite'];
		}
		else {return  FALSE;}
		}
		}
		else
		{ return FALSE;
	}
}
function ConsultarDatoCombo($IdOpcion){
	require("config.php");
	$sql = "SELECT * FROM tramitesopcionesrequisitos WHERE idOpcion='".$IdOpcion."'";
	$rc= $conexion -> query($sql);
	
	if($f = $rc -> fetch_array())
	{
	return $f['Opcion'];
	}
	else{ 
		return 'FALSE';}
	}
	//Obtiene el numero total de requisitos que tiene el tipo de trámite.
	function ProcentajeTramite($FolioTramite,$IdTipoTramite){	
		require("config.php");
		$sql = "select * from tramitesestadodecaptura WHERE IdTramite = ".$FolioTramite;				
		//echo $sql;
		$vacios =0;
		$llenos = 0;
		$porcentaje=0;
		$msg = "";
		$rc= $conexion -> query($sql);
		if($f = $rc -> fetch_array()){				
			$total = $f['RequisitosRequeridos'];
			$llenos = $f['RequisitosRequeridosLlenos'];					
			$porcentaje=(($llenos*100)/$total);
			echo 'total '.$total.'<br>';
			echo 'llenos '.$llenos;
			return number_format($porcentaje,0);;
		}else{
			return FALSE;
		}
		
	}
	function TramiteAcuse1Name($IdTipoTramite){	
		require("config.php");
			$sql = "select Acuse1 as Valor from tramitestipo where IdTipoTramite='".$IdTipoTramite."'";	
		
			$rc= $conexion -> query($sql);
			if($f = $rc -> fetch_array())
				{				
					return $f['Valor'];
				}
			 else {return FALSE;}
	}
	function TramiteEdoCivil($id){	
		require("config.php");
			$sql = "select Dato as Valor from tramitesinformacion where IdTramite='".$id."' AND IdRequisito=36";	//4 = Sexo
			// echo $sql;
			$rc= $conexion -> query($sql);
			if($f = $rc -> fetch_array())
				{				
					return $f['Valor'];
				}
			 else {return FALSE;}
	}
	
	function TramiteNitavuCaptura($id){	
		require("config.php");
			$sql = "select NitavuCaptura as Valor from tramites where IdTramite='".$id."'";	
			// //echo $sql;
			$rc= $conexion -> query($sql);
			if($f = $rc -> fetch_array())
				{				
					return $f['Valor'];
				}
			 else {return FALSE;}
	}
	
	

	function validarCurpUtilizado($idTramite,$dato)
	{
		require("config.php");
		$sql = "select count(*) as Valor from tramitesinformacion where IdRequisito=0 and IdTramite=".$idTramite." and Dato='".$dato."'";	
		// echo $sql;
		$rc= $conexion -> query($sql);
		if($f = $rc -> fetch_array())
			{		
						
				return $f['Valor'];
			}
		 else {return FALSE;}
	}
	
	
///  Funciones lotes y colonias

function siguienteIdColonia($idmunicipio)
{
	require("config.php"); /*No mover*/
	$sql = " -- lot 
	SELECT max(IdColonia) as IdColonia from catcolonia where IdMunicipio=$idmunicipio" ;
	$rc= $Vivienda -> query($sql);
	
	if($f = $rc -> fetch_array())
	{
		return $f['IdColonia']+1;
							
	}
	else
	{
		return FALSE;
	}
}

function ColoniaDatoActual($IdMunicipio, $IdColonia, $Campo){
	require("config.php");	
	$sql = "select ".$Campo." from catcolonia WHERE IdMunicipio=".$IdMunicipio." and IdColonia=".$IdColonia." and Cancelado=0";
  //echo $sql;
	$rc= $Vivienda -> query($sql);
	if($f = $rc -> fetch_array())
		{				
			return $f[$Campo];
		}
	 else {return FALSE;}

}

function GuardarColoniaDato($IdMunicipio, $IdColonia, $Campo, $Dato,$nitavuMod ){	

	require("config.php");
	//Obtener el valor actual
	$DatoActual = ColoniaDatoActual($IdMunicipio, $IdColonia, $Campo );
	$sql = "UPDATE catcolonia SET	".$Campo." = '".$Dato."', FechaUltimaMod=NOW(), IdEmpModifica='".$nitavuMod."'	WHERE IdMunicipio = ".$IdMunicipio ." and IdColonia=".$IdColonia." and Cancelado=0";
	 //echo $sql; 
	 echo "<script> console.log('".$sql."');</script>";
	if ($Vivienda->query($sql) == TRUE){
		historia($nitavuMod,"Lotes: Actualizo la Colonia con IdMunicipio " . $IdMunicipio." and IdColonia=.".$IdColonia.", el campo ".$Campo." de ".$DatoActual." a <b> ".$Dato."</b>");
		return TRUE;	
	}
	else {
		return FALSE;
	}

}
function NombreColoniaVivienda($idmunicipio, $idcolonia){
	require("config.php");	
	$sql = "select * from catcolonia where IdMunicipio=".$idmunicipio." and IdColonia= ".$idcolonia;
	//echo $sql;
	$rc= $Vivienda -> query($sql);
	if($f = $rc -> fetch_array())
		{				
			return $f['Colonia'];
		}
	 else {return FALSE;}

}


function ValidarColoniaCompleto($idmunicipio, $idcolonia){
	require("config.php");
		
			
			$sql = "SELECT * from catcolonia WHERE IdMunicipio=".$idmunicipio." and IdColonia= ".$idcolonia." 		
			and LENGTH(Colonia)  >=2 and LENGTH(Colonia) >=3
			and LENGTH(NOMBRE_OFICIAL)  >=2 and LENGTH(NOMBRE_OFICIAL) >=3
			and Idtipoadquisicioncol  >0 ";
			
		
			//echo $sql;
			$r = $Vivienda -> query($sql);         
			if($f = $r -> fetch_array()){

				return 'TRUE';
			}else{
				return 'FALSE';
			}
	
		}

function ValidarDatoActualColonia($IdMunicipio, $IdColonia, $Campo){
	require("config.php");		
	$sql = "select ".$Campo." from catcolonia WHERE IdMunicipio = ".$IdMunicipio ." and IdColonia=".$IdColonia." and Cancelado=0";
//	echo $sql;
	$rc= $Vivienda -> query($sql);
	if($f = $rc -> fetch_array())
		{		
			if(($Campo=='Colonia'  ) and ( $f[$Campo]=='' ||  strlen($f[$Campo])<3) )
			{			
				return 'FALSE';
			}
			if(($Campo=='NOMBRE_OFICIAL'  ) and ( $f[$Campo]=='' ||  strlen($f[$Campo])<3  ||($f[$Campo]=='SIN_NOMBRE_OFICIAL' )))
			{			
				return 'FALSE';
			}
			else if(($Campo=='Idtipoadquisicioncol') and ( $f[$Campo]==0))
			{
				return 'FALSE';
			}
			else 
			{
				return 'TRUE';
			}
			
			
		}
	 else {return 'FALSE1';}

	

}

function NombreTipoAdquiscion($id){
	require("config.php");	
	$sql = "select * from tipoadquisicioncol where Idtipoadquisicioncol=".$id;
	//echo $sql;
	$rc= $Vivienda -> query($sql);
	if($f = $rc -> fetch_array())
		{				
			return $f['tipoadquisicioncol'];
		}
	 else {return FALSE;}

}

function IdentificacionLote($idTipoLote){
	require("config.php");	
	$sql="select * from cattipolote where IdTipoLote=".$idTipoLote;
	//echo $sql;
	$rc= $Vivienda -> query($sql);
	if($f = $rc -> fetch_array())
		{				
			return $f['TipoLote'];
		}
	 else {return FALSE;}


   } 

function CantidadLotesPorColonia($idmun,$idcol){
	require("config.php");	
	$sql = "select count(idLote) as Total FROM lotes where IdMunicipio=".$idmun." and IdColonia=".$idcol;
	//echo $sql;
	$rc= $Vivienda -> query($sql);
	if($f = $rc -> fetch_array())
		{				
			return $f['Total'];
		}
	 else {return '0';}

}

function CantidadLotesPorColoniaContratados($idmun,$idcol){
	require("config.php");	
	$sql = "select count(idLote) as Total FROM lotes where IdMunicipio=".$idmun." and IdColonia=".$idcol ." and  IdEstatus=2";
	//echo $sql;
	$rc= $Vivienda -> query($sql);
	if($f = $rc -> fetch_array())
		{				
			return $f['Total'];
		}
	 else {return '0';}

}

function CantidadLotesPorColoniaLibres($idmun,$idcol){
	require("config.php");	
	$sql = "select count(idLote) as Total FROM lotes where IdMunicipio=".$idmun." and IdColonia=".$idcol ." and  IdEstatus not in(2,4,17,23)";
	//echo $sql;
	$rc= $Vivienda -> query($sql);
	if($f = $rc -> fetch_array())
		{				
			return $f['Total'];
		}
	 else {return '0';}

}

function IdColoniasPorNombre($dato,$m){
require("config.php");
$sql = "select IdColonia from catcolonia where Colonia like '%".$dato."%' and IdMunicipio=".$m;	
//echo $sql;
$coloniasid='';

$rc= $Vivienda -> query($sql);
while($f = $rc -> fetch_array()) {	
	$coloniasid = $coloniasid.$f['IdColonia'].", ";
}
return substr($coloniasid, 0, -2);

}

function siguienteIdLote()
{
	require("config.php"); /*No mover*/
	$sql = " -- lot 
	SELECT max(IdLote) as IdLote FROM lotes" ;
	$rc= $Vivienda -> query($sql);
	
	if($f = $rc -> fetch_array())
	{
		return $f['IdLote']+1;
							
	}
	else
	{
		return FALSE;
	}
}

function LotesDatoActual($Idlote, $Campo){
	require("config.php");	
	$sql = "select ".$Campo." FROM lotes WHERE idLote=".$Idlote;
	//echo $sql;
	$rc= $Vivienda -> query($sql);
	if($f = $rc -> fetch_array())
		{				
			return $f[$Campo];
		}
	 else {return FALSE;}

}


function GuardarLotesDato($Idlote, $Campo, $Dato,$nitavuMod ){	

	require("config.php");
	//Obtener el valor actual
	$DatoActual = LotesDatoActual($Idlote, $Campo );
	$sql = "UPDATE lotes SET	".$Campo." = '".$Dato."', FechaUltimaMod=NOW(), IdEmpModifica='".$nitavuMod."'	WHERE idLote = ".$Idlote;
	//echo $sql; 
	// echo "<script> console.log('".$sql."');</script>";
	if ($Vivienda->query($sql) == TRUE){
		historia($nitavuMod,"lotes: Actualizo el lote con Id " . $Idlote." el campo ".$Campo." de ".$DatoActual." a <b> ".$Dato."</b>");
		return TRUE;	
	}
	else {
		return FALSE;
	}

}




function ValidarDatoActualLote($Idlote, $Campo){
	require("config.php");
		 if(trim($Campo) != 'IdColonia1' and  trim($Campo) != 'MontoFinanciar' ){
		
	$sql = "select ".$Campo." FROM lotes WHERE idLote=".$Idlote;
	//echo $sql;
	$rc= $Vivienda -> query($sql);
	if($f = $rc -> fetch_array())
		{
				
		

			if(($Campo=='superficie') and ( $f[$Campo]=='0' or $f[$Campo]==''))
			{
				return 'FALSE';
			}
			else if(($Campo=='IdEstatus') and ( $f[$Campo]==100))
			{
				return 'FALSE';
			}
			else if(($Campo=='ContratoMaestro') and ( $f[$Campo]=='SELECCIONE UNA OPCION...' or $f[$Campo]=='NULL'  or $f[$Campo]==''))
			{
				return 'FALSE';
			}
			else if(($Campo=='IdTipoLote') and ( $f[$Campo]==0))
			{
				return 'FALSE';
			}
			else if(($Campo=='IdConceptoCargo') and ( $f[$Campo]==0))
			{
				return 'FALSE';
			}			
			else if (($Campo=='precio') and ($f[$Campo] == 0.0000))
			{
				return 'FALSE';
			}
			else if (($Campo=='MontoPagoInicial') and ($f[$Campo] == 0.0000))
			{
				return 'FALSE';
			}
			
			else if (($Campo=='MontoPago') and ($f[$Campo] == 0.0000))
			{
				return 'FALSE';
			}
			else if (($Campo=='MontoUltimoPago') and ($f[$Campo] == 0.0000))
			{
				return 'FALSE';
			}
			else if ($Campo=='TasaAnualFin'   and ( $f[$Campo]==0)){
				return 'FALSE';
			}
			else if ($Campo=='TasaIntMora'  and ( $f[$Campo]==0) ){
				return 'FALSE';
			}
			
			else if( strlen($f[$Campo])<'3'  and ($Campo!='IdTipoLote' and $Campo!='IdEstatus'
			 and $Campo!='superficie' and $Campo!='IdConceptoCargo' and  $Campo!='FINCA' and  $Campo!='CVE_CATASTRAL' 
			 and $Campo!='SubsidioEstatal' and  $Campo!='SubsidioFederal'  and $Campo!='TasaIntMora' and $Campo!='TasaAnualFin'))
			{
				return 'FALSE';
			}

			else {
				
				return 'TRUE';
			}
		
			
		}
	 else {return 'FALSE1';}
	}else{
		echo 'ss'.$Campo;
	}

}






	function NombreMunicipioVivienda($idmunicipio){
		require("config.php");	
		$sql = "select * from municipios where IdMunicipio=".$idmunicipio;
		//echo $sql;
		$rc= $Vivienda -> query($sql);
		if($f = $rc -> fetch_array())
			{				
				return $f['Municipio'];
			}
		 else {return FALSE;}
	
	}

	
			
	function EstatusLote($idestatus){
		require("config.php");	
		$sql = "select * from catcstatuslote where IdEstatus=".$idestatus;
		//echo $sql;
		$rc= $Vivienda -> query($sql);
		if($f = $rc -> fetch_array())
			{				
				return $f['EstatusLote'];
			}
		 else {return FALSE;}
	
	}
	



	function ValidarLoteCompleto($idlote){
		require("config.php");
			 if (ValidarTramiteSoloEscritura($idlote)=='FALSE')
			 {
				
				$sql = "SELECT * FROM lotes WHERE idLote=".$idlote." 
				and MontoPago>0 and precio>0 and MontoPagoInicial>0 
				and MontoUltimoPago>0 
				and localiza=1
				and TotalPagos>0 and plazos>0 
				and superficie  >0 
				and LENGTH(colin1)  >=2 and LENGTH(con_quien1) >=3
				and LENGTH(colin2)  >=2 and LENGTH(con_quien2) >=3
				and LENGTH(colin3)  >=2 and LENGTH(con_quien3) >=3
				and LENGTH(colin4)  >=2 and LENGTH(con_quien4) >=3
				and (ContratoMaestro is not null  or ContratoMaestro !='' or   ContratoMaestro !='SELECCIONE UNA OPCION...') ";
				//echo $sql;
				$r = $Vivienda -> query($sql);         
				if($f = $r -> fetch_array()){

					return 'TRUE';
				}else{
					return 'FALSE';
				}
			}else{
				return 'TRUE';
			}	
			
	}


	function ValidarTramiteSoloEscritura($idlote){
		require("config.php");
			 
			$sql = "SELECT * FROM lotes WHERE idLote=".$idlote."
			and precio=0 
			and localiza=1
			and TipoPago =3
			and plazos=1 
			and ExigirSaldoTerreno = 1 
			and IdConceptoCargo=35 
			and superficie  >0 
			and LENGTH(colin1)  >=2 and LENGTH(con_quien1) >=3
			and LENGTH(colin2)  >=2 and LENGTH(con_quien2) >=3
			and LENGTH(colin3)  >=2 and LENGTH(con_quien3) >=3
			and LENGTH(colin4)  >=2 and LENGTH(con_quien4) >=3";
			
	
			//echo $sql;
			$r = $Vivienda -> query($sql);         
			if($f = $r -> fetch_array()){
				
				return 'TRUE';
			}else{
				return 'FALSE';
				
			}
			
	}

	function idPlantillaContrato($plantilla){
		require("config.php");	
		$sql = "SELECT* FROM cat_plantillas WHERE Archivo='".$plantilla."'";
		//echo $sql;
		$rc= $Vivienda -> query($sql);
		if($f = $rc -> fetch_array())
			{				
				return $f['Id'];
			}
		 else {return FALSE;}
	
	}

	function DescripcionPlantillaContrato($idplantilla){
		require("config.php");	
		$sql = "SELECT* FROM cat_plantillas WHERE Id='".$idplantilla."'";
		//echo $sql;
		$rc= $Vivienda -> query($sql);
		if($f = $rc -> fetch_array())
			{				
				return $f['Descripcion'];
			}
		 else {return FALSE;}
	
	}

	function TablaDinamica_MySQLVivienda($tbCont, $sql, $IdDiv, $IdTabla, $Clase, $Tipo){
		require("config.php");
		
		if ($tbCont == '') {
			$r= $Vivienda -> query($sql);
			//echo $sql;
			$tbCont = '<div id="'.$IdDiv.'" class="'.$Clase.'" style="width:100%">
			<table id="'.$IdTabla.'" class="display" style="width:100%" class="tabla" style="font-size:8pt;">';
			$tabla_titulos = ""; $cuantas_columnas = 0;
			$r2 = $Vivienda -> query($sql); while($finfo = $r2->fetch_field())
			{//OBTENER LAS COLUMNAS
	
					/* obtener posición del puntero de campo */
					$currentfield = $r2->current_field;       
					$tabla_titulos=$tabla_titulos."<th style='text-transform:uppercase; font-size:9pt;'>".$finfo->name."</th>";
					$cuantas_columnas = $cuantas_columnas + 1;        
			}
	
			$tbCont = $tbCont."  
			<thead>
			<tr>
				".$tabla_titulos."  
			</tr>
			</thead>"; //Encabezados
			$tbCont = $tbCont."<tbody class='tabla'>";
			$cuantas_filas=0;
			$r = $Vivienda -> query($sql);
			 while($f = $r-> fetch_row())
			{//LISTAR COLUMNAS
	
				$tbCont = $tbCont."<tr>";     
				// 
				$flag = 1;   
				for ($i = 1; $i <= $cuantas_columnas; $i++) {   
					
					if($flag == 1){
						$tbCont = $tbCont."<td style='font-size:10pt;'><input type='checkbox' id='op[]' name='op[]' value='".$f[1]."'></td>"; 
					}else{
						$tbCont = $tbCont."<td style='font-size:10pt;'>".$f[$i-1]."</td>";    
					}
					$flag = 0;
					   
				}
	
				$tbCont = $tbCont."</tr>";
				$cuantas_filas = $cuantas_filas + 1;        
			}
	
			$tbCont = $tbCont."</tbody>"; 
			$tbCont = $tbCont."</table></div>";
		} else {
			
		}
		echo  $tbCont;
			switch ($Tipo) {
				case 1: //Scroll Vertical
						echo '<script>
						$(document).ready(function() {
							$("#'.$IdTabla.'").DataTable( {
								"scrollY":        "200px",
								"scrollCollapse": true,
								"paging":         false,
								"language": {
									"decimal": ",",
									"thousands": "."
								}
							} );
						} );
						</script>';
					break;
	
				case 2: //Scroll Horizontal
						echo '<script>
						$(document).ready(function() {
							$("#'.$IdTabla.'").DataTable( {
								"scrollX": true,
								"scrollCollapse": true,
								"paging":         true,
								"language": {
									"decimal": ",",
									"thousands": "."
								}
							} );
						} );
						</script>';
					break;
				
				default:
					echo '<script>
					$(document).ready(function() {
						$("#'.$IdTabla.'").DataTable( {
							"language": {
								"decimal": ",",
								"thousands": "."
							}
						} );
					} );
					</script>';
			}
		   
	
	}

	

		function mensajeAdvertencia($mensaje, $linkaccion,$linkCancelar,$id){
			if ($linkaccion=="") {$linkaccion = "../index.php";}
			echo '<div id="modal" name="modal"></div>';
				echo "<div id='req_captura' name='req_captura'>";
				echo '<form action="'.$linkaccion.'" method="POST">';
				echo "<span>";	
				echo '<input type="hidden" name="id" value="'.$id.'" > '; 	
				echo '<label for="mensaje">'.$mensaje.' </label>';	
				echo '<input type="hidden" name="mensaje" id="mensaje" value="'.$mensaje.'"></input>';			
				echo '</span>';
				echo '<div><a class="btn btn-primary" href="'.$linkaccion.'">Aceptar</a></div>';				
				echo '<div><a id="linkcancelar" name="linkcancelar"  class="btn btn-secondary" href="'.$linkCancelar.'">Cancelar</a></div>';
				echo '</form>';
				echo '</div>';
			}


			function mensajeObservaciones($mensaje, $linkaccion,$linkCancelar,$id){
				if ($linkaccion=="") {$linkaccion = "../index.php";}
				echo '<div id="modal" name="modal"></div>';
					echo "<div id='req_captura' name='req_captura'>";
					echo '<form action="'.$linkaccion.'" method="POST">';
					echo "<span>";	
					echo '<input type="hidden" name="id" value="'.$id.'" > '; 	
					echo '<label for="mensaje">'.$mensaje.' </label>';	
					echo '<input type="hidden" name="mensaje" id="mensaje" value="'.$mensaje.'"></input>';			
					echo '</span>';
					echo '<div><a class="btn btn-primary" href="'.$linkaccion.'">Aceptar</a></div>';				
					echo '<div><a id="linkcancelar" name="linkcancelar"  class="btn btn-secondary" href="'.$linkCancelar.'">Cancelar</a></div>';
					echo '</form>';
					echo '</div>';
				}

/********************************ESCRITURACION*********************************/

function IdDelegacionVivivienda($nombreDel){
	require("config.php");
	$var=explode("Delegación", $nombreDel);		
	$sql="Select IdDelegacion from delegaciones where Delegacion like '" . trim($var[1]). "' and Delegacion not like '%PRES.%'";

    $rc= $Vivienda -> query($sql);
    if($f = $rc -> fetch_array()){
        return $f['IdDelegacion'];
    }else{
        return 'FALSE';
    }
}


function DireccionParticipaEnEscritura($direccion)
{  

	if($direccion == "19" or $direccion == "54" or $direccion == "46" or $direccion == "10")
	{
		return 	$direccion;
	}
	else	
	{
		return 'NO PARTICIPA';
	}

  
}
 function TienePermisoParaAccion($accion, $nitavu,$idapp){
	require("config.php");
		
	$sql="select * from permisos_acciones where nitavu='".$nitavu."' and idaccion=".$accion." and idapp='".$idapp."' and cancelado=0";
	//echo $sql;
    $rc= $conexion -> query($sql);
    if($f = $rc -> fetch_array()){
        return $f['idaccion'];
    }else{
        return 'FALSE';
    }
} 


	
	function permisos_acciones($idapp,$nitavu){
	require("config.php");
	

	$msg="";
	$sql = "SELECT * FROM permisos_acciones left join cat_acciones on permisos_acciones.idaccion=cat_acciones.idaccion  WHERE 
	permisos_acciones.cancelado=0 and cat_acciones.cancelado=0 and idapp='".$idapp."' and nitavu=".$nitavu .' and idaccion not in(1,2)' ;
	$r= $conexion -> query($sql);
	//echo $sql;
    while($f = $r -> fetch_array()) {
		
		if($f['tipo']=='button')
		{
 			 $msg = $msg."<button type='submit' class='Mbtn btn_menu' name='btn".$f['nombre']. "' id='btn".$f['nombre']."'>											
	 		<table border='0'><tbody><tr><td width='30px'><img src='icon/".$f['icono']."' class=''></td>
			<td><cite class='tenue menu_font_d2'>".$f['accion']."</cite></td></tr></tbody></table>
			</button>";	 
		}else
		{
			$msg = $msg."<a href='#".$f['nombre']."' rel='MyModal:open' title='".$f['accion']."'>
			<button class='Mbtn btn_menu'>											
			 <table border='0'><tbody><tr><td width='30px'><img src='icon/".$f['icono']."' class=''></td>
			<td><cite class='tenue menu_font_d2'>".$f['accion']."</cite></td></tr></tbody></table>
			</button>
			</a>"; 

		}
	

							
							
	}
	if ($msg == ''){
	
		return "";
	}
	else {return $msg;} 
}




function ObtenerPaso($iddireccion,$idaccion){
	require("config.php");		
	$sql="select CampoMovEscrituras from esc_confseguimiento  where Orden!=0 and IdDireccion=".$iddireccion." and idaccion=".$idaccion." ORDER BY Orden asc";
	//echo $sql;
    $rc= $Vivienda -> query($sql);
    if($f = $rc -> fetch_array()){
        return $f['CampoMovEscrituras'];
    }else{
        return 'FALSE';
    }
}

function ObtenerQueCamposDeberiaEstarLlenos($paso,$op){
	    require("config.php");
    $info = "";
    $sql = "select CampoMovEscrituras
	from esc_confseguimiento  where Orden!=0 and Orden<( Select Orden  from esc_confseguimiento where  CampoMovEscrituras='".$paso."' and orden is not null limit 1) and Campomovescrituras is not null GROUP BY CampoMovEscrituras ORDER BY Orden asc";
	
	echo $sql;
	$r = $Vivienda -> query($sql);

	$paq='';
	if($op=='enviar'){
		$paq=0;
	}else{
		$paq=1;
	}

	$vuelta = 1;
	$rows = $r -> num_rows;
	//echo 'registros '.$rows;
	if($rows>0){
		while($f = $r -> fetch_array())
		{
			echo $vuelta.'<br>';
			echo $rows.'<br>';
			echo $paso.'<br>';
			if($vuelta == $rows){
				if($f['CampoMovEscrituras'] == 'EnvioDelg' || $paso == 'RecDelg'){
					$info = $info.'movescrituras.'.$f['CampoMovEscrituras'].'=1 and movescrituras.Cancelado=0 and contratos.Cancelado = 0 and movescrituras.paqEnv = '.$paq.'';

				}else{
					$info = $info.'movescrituras.'.$f['CampoMovEscrituras'].'=1 and movescrituras.Cancelado=0 and contratos.Cancelado = 0 and movescrituras.paqEnv = '.$paq.' and movescrituras.'.$paso.' = 0';
				}
			}else{
				$info = $info.'movescrituras.'.$f['CampoMovEscrituras'].'=1 and ';
			}
			echo $info.'<br>';
			$vuelta ++;
		}	
	}

	//echo $info;
    return $info;
}






function TotaltramitesPendientes($iddireccion,$opcion){
	require("config.php");
		
	$paso = ObtenerPaso($iddireccion,$opcion);
	$llenos= ObtenerQueCamposDeberiaEstarLlenos($paso);	
	if($iddireccion==10)
	{$llenos=null;}

    if($llenos!=null){
        $sql="select count(*) as Total from vivienda_tramitesdeescritura where ".$paso. "=0 and ". $llenos. "Cancelado=0";

    }else{
        $sql="select count(*) as Total from vivienda_tramitesdeescritura where ".$paso. "=0 and Cancelado=0";
    }
    
	//echo $sql; 
    $rc= $Vivienda -> query($sql);
    if($f = $rc -> fetch_array()){
        return $f['Total'];
    }else{
        return 'FALSE';
    }
}

function TotaltramitesPorAprobarJuridico($iddireccion,$opcion){
	require("config.php");
		
	$paso = ObtenerPaso($iddireccion,$opcion);
    $llenos= ObtenerQueCamposDeberiaEstarLlenos($paso);


    if($llenos!=null){
        $sql="select count(*) as Total from vivienda_tramitesdeescritura where ".$paso. "=0 and ". $llenos. "Cancelado=0";

    }else{
        $sql="select count(*) as Total from vivienda_tramitesdeescritura where ".$paso. "=0 and Cancelado=0";
    }
        //echo $sql; 
    $rc= $Vivienda -> query($sql);
    if($f = $rc -> fetch_array()){
        return $f['Total'];
    }else{
        return 'FALSE';
	}
	}


function TotaltramitesDevueltos($iddireccion,$opcion){
	require("config.php");
		
	$paso = ObtenerPaso($iddireccion,$opcion);
    $llenos= ObtenerQueCamposDeberiaEstarLlenos($paso);   
    $sql="select count(*) as Total from vivienda_tramitesdeescritura where ".$paso. "=3 and Cancelado=0";
  
        //echo $sql; 
    $rc= $Vivienda -> query($sql);
    if($f = $rc -> fetch_array()){
        return $f['Total'];
    }else{
        return 'FALSE';
    }
}

function TotaltramitesPausa($iddireccion,$opcion){
	require("config.php");
		
	$paso = ObtenerPaso($iddireccion,$opcion);
    $llenos= ObtenerQueCamposDeberiaEstarLlenos($paso);   
    $sql="select count(*) as Total from vivienda_tramitesdeescritura where ".$paso. "=2 and Cancelado=0 ";
  
        //echo $sql; 
    $rc= $Vivienda -> query($sql);
    if($f = $rc -> fetch_array()){
        return $f['Total'];
    }else{
        return 'FALSE';
    }
}

function ObtenerNumEscrituraConContrato($numcontrato){
	require("config.php");		
	  
    $sql=" select    NumEscritura	from    vivienda_tramitesdeescritura	WHERE NumContrato like '%".$numcontrato."%'";
  
    $rc= $Vivienda -> query($sql);
    if($f = $rc -> fetch_array()){
        return $f['NumEscritura'];
    }else{
        return '';
	}

	}

	function DivDatosTramiteEscritura($numcontrato,$direccion){
		require("config.php");
		$res="";
		if ($numcontrato=="") {$res = "";}
		else
		{
			$sql =" -- esc
			select    NumContrato,   Delegacion,   IdMunicipio,   Municipio,   Colonia,   Seccion,   Fila,   Manzana,   Lote,   NombreBeneficiario,	idLote, NumEscritura
			from    vivienda_tramitesdeescritura
			WHERE NumContrato like '%".$numcontrato."%'";
		   // echo $sql;
		 
			 $rc= $Vivienda -> query($sql);
			 $row_cnt = $rc->num_rows;
				 $cont=0;
				 if($row_cnt>0)
				 {
				   while($valor = $rc -> fetch_array())
				   {	
					$res ="<div style='width:100%;'>";	
					$res=$res."<center>";
					$res=$res."<table style='width: 90%;'  >";
					$res=$res."<tr>";      
					$res=$res."<td valign='middle'><b class='normal menu_font_d2'>NumContrato:</b></td>";
					$res=$res."<td valign='middle'>";
					$res=$res."<span class='tenue menu_font_d2' >".$valor['NumContrato']."</span>";
					$res=$res."</td>";
					$res=$res."<td valign='middle' align='center' ></td>";
					$res=$res."<td valign='middle' align='center' ></td>"; 
					$res=$res."</tr>";

					$res=$res."<tr>";      
					$res=$res."<td valign='middle'><b class='normal menu_font_d2'>Municipio</b></td>";
					$res=$res."<td valign='middle'  colspan='3'>";
					$res=$res."<span class='tenue menu_font_d2' >".$valor['Municipio']."</span>";
					$res=$res."</td>";
					$res=$res."</tr>";

					$res=$res."<tr>";      
					$res=$res."<td valign='middle'><b class='normal menu_font_d2'>Colonia</b>";
					$res=$res."<td valign='middle' colspan='3'>";
					$res=$res."<span class='tenue menu_font_d2' >".$valor['Colonia']."</span>";
					$res=$res."</td>";
					$res=$res."</tr>";  
						
					$res=$res."<tr>";      
					$res=$res."<td valign='middle'><b class='normal menu_font_d2'>Seccion</b>";
					$res=$res."<td valign='middle' >";
					$res=$res."<span class='tenue normal menu_font_d2'>".trim($valor['Seccion'])."</span>";
					$res=$res."</td>";
					$res=$res."<td valign='middle'><b class='normal menu_font_d2'>Fila</b>";
					$res=$res."<td valign='middle'>";
					$res=$res."<span class='tenue menu_font_d2'>".$valor['Fila']."</span>";
					$res=$res."</td>";
					$res=$res."</tr>";  

					$res=$res."<tr>";      
					$res=$res."<td valign='middle'><b class='normal menu_font_d2'>Manzana</b>";
					$res=$res."<td valign='middle'>";
					$res=$res."<span class='tenue normal menu_font_d2'>".trim($valor['Manzana'])."</span>";
					$res=$res."</td>";
					$res=$res."<td valign='middle'><b class='normal menu_font_d2'>Lote</b>";
					$res=$res."<td valign='middle'>";
					$res=$res."<span class='tenue menu_font_d2'>".$valor['Lote']."</span>";
					$res=$res."</td>";
					$res=$res."</tr>";

					$res=$res."<tr>";      
					$res=$res."<td valign='middle'><b class='normal menu_font_d2'>Beneficiario</b></td>";
					$res=$res."<td valign='middle'  colspan='3'>";
					$res=$res."<span class='tenue menu_font_d2' >".$valor['NombreBeneficiario']."</span>";
					$res=$res."</td>";
					$res=$res."</tr>";
					
					
					$estatus=ObtenerEstatusTramiteEscritura($direccion,$valor['NumEscritura']);
					$res=$res."<tr>";      
					$res=$res."<td valign='middle'><b class='normal menu_font_d2'>Estatus</b></td>";
					$res=$res."<td valign='middle'  colspan='3'>";
					$res=$res."<span class='tenue menu_font_d2' ><b>".$estatus."</b></span>";
					$res=$res."</td>";
					$res=$res."</tr>";
					

					$res=$res."</table> "; 
					$res=$res."<center>";
					$res=$res. '</div>';
				   }
				}
			}
		return $res;
		}
			
		

	function ObtenerOrigen($nitavu)
	{	
		require("config.php");
		$origen=midelegacion($nitavu);
		if($origen=='OFICINAS CENTRALES')
			{
				$origen='E';
			}
			else
			{
				$origen='D';
			}
		return $origen;
	}	

	function ObtenerConsecutivo($iddel)
	{	
		require("config.php");
		$sql="select IFNULL(max(Consecutivo),0) + 1 as Consecutivo from seguimiento where  IdDelegacion=".$iddel;
		//echo $sql; 
		$rc= $Vivienda -> query($sql);
		if($f = $rc -> fetch_array()){
			return $f['Consecutivo'];
		}else{
			return 'FALSE';
		}
	
	}	

	function ObtenerIdConsecutivo($numescritura,$origen)
	{	
		require("config.php");
		$sql="select IFNULL(max(IdConsecutivo),0) + 1 as IdConsecutivo from seguimiento where IdElemento= '". $numescritura . "' and Origen='" . $origen . "'";
		//echo $sql; 
		$rc= $Vivienda -> query($sql);
		if($f = $rc -> fetch_array()){
			return $f['IdConsecutivo'];
		}else{
			return 'FALSE';
		}
    
	}


	function ObtenerIdAccionSeguimiento($direccion,$idaccion)
	{	
		require("config.php");
		$sql="select IdActividad from esc_confseguimiento where idaccion=".$idaccion." and IdDireccion LIKE '%".$direccion."%'";
	//	echo $sql; 
		$rc= $Vivienda -> query($sql);
		if($f = $rc -> fetch_array()){
			return $f['IdActividad'];
		}else{
			return 'FALSE';
		}
    
	}

	function ObtenerCampomovescrituras($direccion,$idaccion)
	{	
		require("config.php");
		$sql="select Campomovescrituras from esc_confseguimiento where idaccion=".$idaccion." and IdDireccion LIKE '%".$direccion."%'";
		//echo $sql; 
		$rc= $Vivienda -> query($sql);
		if($f = $rc -> fetch_array()){
			return $f['Campomovescrituras'];
		}else{
			return 'FALSE';
		}
    
	}



	function InsertSeguimientoEscritura($numescritura,$accion,$nitavu,$soporte,$observaciones)
	{
		require("config.php");
		$origen=ObtenerOrigen($nitavu);
		$iddel=substr($numescritura, 0, 2);
		$consecutivo=ObtenerConsecutivo($iddel);
		$idconsecutivo=ObtenerIdConsecutivo($numescritura,$origen);
		
		$sql = " 
		INSERT INTO seguimiento
		(IdElemento
		,Origen
		,IdConsecutivo
		,Consecutivo
		,IdDelegacion
		,IdAccion
		,IdOperador
		,FechaOperacion
		,FechaRegistro
		,CantidadOperacion
		,Soporte_Sustento
		,Observaciones
		,Estatus
		,Enviar
		,FechaUltimaMod
		,IdEmpModifica
		,FechaEnvio
		,OrigenDeEnvio)
  		VALUES
		('".$numescritura."','".$origen."',".$idconsecutivo.",".$consecutivo.",".$iddel.",".$accion.
		",".$nitavu.",NOW(),NOW(),0,'".$soporte."','".$observaciones."','A',1,NULL,NULL,NULL,".$iddel.")";
	
		//echo $sql;
		if ($Vivienda->query($sql) == TRUE)
		{
			return 'TRUE';
		}
		else
		{
			return 'FALSE';
		//echo $sql;
		}
}




function ExisteTramiteEscritura($numescritura)
{
	//if(TramiteDato($FolioTramite, 91, 0) == '')
	//Verificamos si existe un trámite de escritura	
		require("config.php");	
		$sql = "select count(*) as Existe from movescrituras WHERE NumEscritura='".$numescritura."'";
		//echo $sql;
		$rc= $Vivienda -> query($sql);
		if($f = $rc -> fetch_array())
			{	
					
				if($f['Existe']>0)
				{
					//Si existe un trámite verificamos que este activo		
					$sql = "select count(*) As Activo from movescrituras WHERE NumEscritura='".$numescritura."' and Cancelado=0";
					//echo $sql;
					$rc= $Vivienda -> query($sql);
					if($fx = $rc -> fetch_array())
						{	
							if($fx['Activo']>0)
							{		
								return 'Activo';
							}
							else {
								return 'Cancelado';
							}
							
						}
						else 
						{
							return 'Cancelado';
						}
				}
				else
				{
					return 'No Existe';
				}
				
	
			}
		 else {return 'No Existe';}
	
	
}

function TramiteEscrituradoFinalizado($numescritura){
	require("config.php");	
	$sql = "select IFNULL(IRPP, 0) as IRPP from movescrituras where NumEscritura='".$numescritura."' and  Cancelado=0";
	//echo $sql;
	$rc= $Vivienda -> query($sql);
	if($f = $rc -> fetch_array())
		{	
			return $f['IRPP'];
			
		}
	 else {return 'FALSE';}
	}

function ObtenerEstatusTramiteEscritura($direccion,$numescritura)
	{	
		require("config.php");
		$campo='';
		
		if (ExisteTramiteEscritura($numescritura)=='Activo')
		{
			if(TramiteEscrituradoFinalizado($numescritura)==1)
			{
				return 'FINALIZADO';
			}
			else
			{

				if(DireccionParticipaEnEscritura($direccion)=='NO PARTICIPA')
				{
					return 'EN TRAMITE';
				}
				else
				{	
									
					if($direccion==19)	{	$campo="aprobDel";		}
					if($direccion==46)	{	$campo="aprobTec";		}
					if($direccion==54)	{	$campo="aprobFin";		}
					if($direccion==10)	{	$campo="aprobJur";		}
					

					$sql="select IFNULL(".$campo.",'0') as valor from movescrituras where NumEscritura='".$numescritura."' and Cancelado=0";
					// $sql;
					$rc= $Vivienda -> query($sql);
					if($f = $rc -> fetch_array())
					{
						if($f['valor']=='0')
						{						
							return 'PENDIENTE';
						}
						else if($f['valor']=='1')
						{
							return 'APROBADO';
						}
						else if($f['valor']=='2')
						{
							return'EN PAUSA';
						}
						else if($f['valor']=='3')
						{
							return 'DEVUELTO / PARA REVISION';
						}

					}
					else				
					{
						return 'false';
					}
				}
			}
			

		}
		else
		{
			return 'CANCELADO';
		}

		
    
	}

	function SePuedeAprobarTramite($direccion,$accion, $numescritura)
	{
		require("config.php");
		$paso = ObtenerPaso($direccion,$accion);
	    $llenos= ObtenerQueCamposDeberiaEstarLlenos($paso);
	
		// primero Obtenemos el estatus	
		$sql="select IFNULL(".$paso.",'0') as valor from movescrituras where NumEscritura='".$numescritura."' and Cancelado=0";
		//echo $sql;


		//echo $paso."paso" ;
		$rc= $Vivienda -> query($sql);
		if($f = $rc -> fetch_array())
		{
			//SI EL VALOR ES 0 (PENDIENTE) VEMOS SI ES POSIBLE APROBARLO, ES DECIR CUMPLE CON LOS PARAMETROS PAR PODERSE APROBAR
			if($f['valor']=='0')
			{
				if($llenos!='')
				{
				$sql="select count(*) as Total from  movescrituras where NumEscritura='".$numescritura."' and (IFNULL(".$paso. ",0)=0 or ".$paso. "=2) and ". substr($llenos,0,  strrpos($llenos, "and"));		
				}
				else
				{
					$sql="select count(*) as Total from  movescrituras where NumEscritura='".$numescritura."' and (IFNULL(".$paso. ",0)=0 or ".$paso. "=2)";
			    }
				//echo $sql; 
				 $rc= $Vivienda -> query($sql);
				 if($f = $rc -> fetch_array()){
					 return $f['Total'];
				 }else{
					 return 'FALSE';
				 }
			}//SI SE DETECTA QUE EL ESTATUS ES UN 1(APROBADO) , NO SE PUEDE APROBAR YA
			else if($f['valor']=='1')
			{
				return '0';
			}//SI SE DETECTA QUE EL ESTATUS ES UN 2 (DETENIDO) , SI LO PUEDE APROBAR
			else if($f['valor']=='2')
			{
				return '1';
			}//SI SE DETECTA QUE EL ESTATUS ES UN 3 (DEVUELTO) , SI LO PUEDE APROBAR
			else if($f['valor']=='3')
			{
				return '1';
			}
		}
	}
		
	function UltimaAccionSeguimientoPorTramite($numescritura){
		require("config.php");	
		$sql = "select IFNULL(IdAccion,'PRIMERA') as ultimaaccion from seguimiento where IdElemento='".$numescritura."' and  Estatus!='C' and IdAccion not in(67,0) ORDER BY FechaOperacion DESC LIMIT 1";
		//echo $sql;
		$rc= $Vivienda -> query($sql);
		if($f = $rc -> fetch_array())
			{	
				return $f['ultimaaccion'];
				
			}
		 else {return 'FALSE';}
		}

		function Obetnernotificacionseguimiento($numescritura){
			require("config.php");	
			$sql = "select soporte_sustento from seguimiento where IdElemento='".$numescritura."' and IdAccion in (71,72,73,74) and  Estatus!='C' ORDER BY FechaOperacion DESC LIMIT 1";
			//echo $sql;
			$rc= $Vivienda -> query($sql);
			if($f = $rc -> fetch_array())
				{	
					if( $f['soporte_sustento']=='NOTIFICACION: DELEGACION'  OR $f['soporte_sustento']=='NOTIFICACION: Delegación'){
						return 'aprobDel';
						}
					else if( $f['soporte_sustento']=='NOTIFICACION: FINANZAS' OR $f['soporte_sustento']=='NOTIFICACION: Direccion de Administracion y Finanzas'){
						return 'aprobFin';
						}
					else if( $f['soporte_sustento']=='NOTIFICACION: TECNICA'  OR $f['soporte_sustento']=='NOTIFICACION: Dir. de Programas de Suelo y Vivienda'){
							return 'aprobTec';
						}
					else if( $f['soporte_sustento']=='NOTIFICACION: JURIDICO'  OR $f['soporte_sustento']=='NOTIFICACION: Dir. Jurídica y Seguridad Patrimonial'){
						return 'aprobJur';
						}
				} else {return 'FALSE';}		
							
			
			}

		/* CANCELAR TRAMITE DE ESCRITURA*/
		function CancelarRegistroMovEscritura($numescritura,$nitavu,$observaciones,$tipoCancelacion)
		{
			require("config.php");
			
			$sql="Update movescrituras set FechaUltimaMod=NOW(), enviar=1, 
			IdEmpModifica= '" .$nitavu. "' ,FechaDeCancelacion=NOW(), Cancelado=1, NumEmpCancelo= '" .$nitavu. "', MotivoDeCancelacion= '" .$observaciones. "', SecuenciaDeCancelacion=(select MAX(isnull(SecuenciaDeCancelacion,0))+1 from movescrituras where NumEscritura='" .$numescritura. "') , TipoCancelacion=".$tipoCancelacion. " where Cancelado=0 and NumEscritura= '" .$numescritura. "' ";
			//echo $sql;
			if ($Vivienda->query($sql) == TRUE)
			{
				return 'TRUE';
			}
			else
			{
				return 'FALSE';
			//echo $sql;
			}
	}		
/********************************CAJA*********************************/



/*Esta funcion nos ayuda a obtener el monto de  ahorro de una solicitud*/
function  MontoAhorroSolicitud($iddelegacion,$idprograma,$folio){
	require("config.php");	
	$sql="Select Ahorro  from solicitudes where  IdDelegacion=".$iddelegacion." and IdPrograma=".$idprograma ." and Folio='".$folio."'";
    $rc= $Vivienda -> query($sql);
    if($f = $rc -> fetch_array()){
        return $f['Ahorro'];
    }else{
        return 'FALSE';
    }

}



/* funcion que permite obtener la forma de pago apartir de su Id*/
function FormaDePago($idFormaPago){
	require("config.php");	
	$sql="Select * From catformapago where IdFormaPago=".$idFormaPago;
    $rc= $Vivienda -> query($sql);
    if($f = $rc -> fetch_array()){
        return $f['FormaPago'];
    }else{
        return 'FALSE';
    }
}

/* funcion que permite obtener el concepto del pago con solo el el IdTipoMovimiento*/
function TipoPago_Concepto($idtipo){
	require("config.php");	
	$sql="Select * From descripcionmovimiento where idTipoMov=".$idtipo;
	//echo $sql;

	$rc= $Vivienda -> query($sql);
	if($f = $rc -> fetch_array()){
        return $f['DescripcionMovimiento'];
    }else{
        return 'FALSE';
    }
}





   /*Esta funcion nos ayuda a obtener la fecha del primer pago de una solicitud (TABLA PAGOS)*/
function  FechaPrimerPagoSolicitud($iddelegacion,$idprograma,$folio){
	require("config.php");	
	$sql=" SELECT Min(Fecha) as FechaPrimerPAGO  FROM pagos  where  IdDelegacion=".$iddelegacion." and IdPrograma=".$idprograma ." and Folio='".$folio."'";
    $rc= $Vivienda -> query($sql);
    if($f = $rc -> fetch_array()){
        return $f['FechaPrimerPAGO'];
    }else{
        return 'FALSE';
    }

}

 /*Esta funcion nos ayuda a obtener la fecha del ultimo pago de una solicitud (TABLA PAGOS)*/
 function  FechaUltimoPagoSolicitud($iddelegacion,$idprograma,$folio){
	require("config.php");	
	$sql=" SELECT Max(Fecha)  as FechaUltimoPAGO  FROM pagos   where  IdDelegacion=".$iddelegacion." and IdPrograma=".$idprograma ." and Folio='".$folio."'";
	$rc= $Vivienda -> query($sql);
    if($f = $rc -> fetch_array()){
        return $f['FechaUltimoPAGO'];
    }else{
        return 'FALSE';
    }

}

function  CalculoDeMesesTranscurridos($fecha1,$fecha2){
		$date1 = new DateTime($fecha1);                           
        $date2 = new DateTime($fecha2);
        $interval = $date1->diff($date2);
        //echo $interval->m." months "; 
        $vTiempo=$interval->format("%m");
		return $vTiempo;
}

/*Esta funcion que gera el  recibo que se emitirá en caja*/
function formatoRecibo($iddelegacion,$idprograma,$folio,$numcontrato,$cantidad,$idformapago,$referencia,$fecharecibo,$nitavu,$folioRecibo,$numPago,$idtipopago,$notas,$codigoQR,$descuento){
require_once('lib/flor_funciones.php');
require('config.php');
$IdSolicitante = buscarIdSolicitante($idprograma, $iddelegacion, $folio);
$res= '<br><br><table   style="width:100%" border=1  id="'.$folioRecibo.'">
	<tr>
		<td style="width:65%" border=1><div>
			<table>
			<tr>
			<td><b>DATOS DE IDENTICACIÓN</b></td> 		
			</tr>
			<tr>
			<td></td>  
			</tr>
			<tr>
				<td><div>
				<table style="width:100%" border=1>
				<tr>
				<td><span style="font-weight: bold; font-size:13px;">'.nombreBeneficiarioVivienda($IdSolicitante).'</span></td>
				<td><span></span></td> 								 		
				</tr>
				<tr>
				<td style="width:20%"><span>programa:</span></td>
				<td style="width:80%"><span>'.nombreProgramaVivienda($idprograma).'</span></td> 				 		
				</tr>
				<tr>
				<td style="width:20%"><span>FOLIO:</span></td>
				<td style="width:80%"><span>'.$folio.'</span></td> 				 		
				</tr>';
				if($numcontrato !=='')
				{
					$res =$res. '<tr>
					<td style="width:20%"><span>CONTRATO:</span></td>
					<td style="width:80%"><span>'.$numcontrato.'</span></td> 				 		
					</tr>';
				}
				$res =$res.'</table></div>
				</td>								 
			</tr>
			</table>
		</div></td>

		<td  style="width:35%" border=1><div>
			<table boder=1>
			<tr>
			<td><b>DATOS TRANSACCIÓN</b></td>  
			</tr>
			<tr>
			<td></td>  
			</tr>
			<tr>			 
			<td><div>
				<table>
				<tr>
				<td><span>N° RECIBO:</span></td>
				<td><span>'.SerieDelegacion($iddelegacion).$folioRecibo.'</span></td> 								 		
				</tr>
				<tr>
				<td><span>FECHA:</span></td>
				<td><span>'.$fecharecibo.'</span></td> 				 		
				</tr>
				<tr>
				<td><span>DELEGACION:</span></td>
				<td><span>'.nombreDelegacionVivienda($iddelegacion).'</span></td> 				 		
				</tr>
				<tr>
				<td><span>FORMA DE PAGO:</span></td>
				<td><span>'.FormaDePago($idformapago).'</span></td> 				 		
				</tr>	
				<tr>
				<td><span>REFERENCIA:</span></td>
				<td><span>'.$referencia.'</span></td> 				 		
				</tr>	
				<tr>
				<td><span>OPERADOR:</span></td>
				<td><span>'.$nitavu.'</span></td> 				 		
				</tr>				
				</table></div>
				</td>					 
			</tr>
			</table></div>
		</td>    
	</tr>		
	<tr>    
	<td style="width:100%">	
	<div>	
	 	
	</div>  
	</td>    
	</tr>
	<tr >
		<td style="width:60%"><div>
			<table>
			<tr>			  
			</tr>
			<tr>
				<td>
					<div>
						<table style="width:100%" border=1>
							<tr>';
								if($numcontrato =='')
								{
									$res=$res.'<th style="width:20%;"><b>N° PAGO</b></th>';
								}								
								$res=$res.'<th style="width:60%;"><b>CONCEPTO</b></th>
								<th style="width:20%;"><b>IMPORTE</b></th>';
								if($descuento>0)
								{
									$res=$res.'<th style="width:20%;"><b>DESCUENTO</b></th>';
								}
								$res=$res.'<th style="width:20%;"><b>TOTAL</b></th>
								
								</tr>				
							<tr>';
								if($numcontrato =='')
								{
									$res=$res.'<td style="width:20%;"><span>'.$numPago.'</span></td>';
								}								
								$res=$res.'<td style="width:60%;"><span>'.strtoupper( TipoPago_Concepto($idtipopago)).'</span></td>
								<td style="width:20%;"><span>$'.$cantidad.'</span></td>';
								(string)$total=(string)$cantidad;
								if($descuento>0)
								{
									$total=(string)$cantidad-(string)$descuento;
									$res=$res.'<td style="width:20%;"><span>$'.$descuento.'</span></td>';
								}
								$res=$res.'<td style="width:20%;"><span>$'.$total.'</span></td>
								
							</tr>
							
							<tr>
								<td colspan="4"><b><br><br>IMPORTE CON LETRA:</b> '. strtoupper(numtoletras($total)).'</td>	
							</tr>					
						</table>
					</div>
				</td>											 
			</tr>
			</table>
		</div></td>
		<td  style="width:40%; text-align:right;" border=1>
		<div>';	
		 //SE GENERA EL CODIGO QR
		//$codigoQR=GenerarQRrecibo($folioRecibo,$cantidad,$fecharecibo,$nitavu);
		$codesDir = "tmp/CodigosQR/"; //Carpeta donde se almacenaran los QR  

		$res=$res.'<img  src="'.$codesDir.$codigoQR.'" />
		</div>
		</td>    
	</tr>
	<tr>    
	<td style="width:100%">	
	<div>	
	<hr style="border-top: 5px solid"/> 	
	</div>  
	</td>    
	</tr>
	<tr><td style="width:100%"><b>AVISO IMPORTANTE:</b></td>
	</tr>	
	<tr><td style="width:100%">'.$notas.'</td>		
	</tr>
	
  </table>';	
return $res;
}




function SerieDelegacion($iddelegacion){
	require("config.php");	
	$sql = "select * from delegaciones where IdDelegacion=".$iddelegacion;
	//echo $sql;
	$rc= $Vivienda -> query($sql);
	if($f = $rc -> fetch_array())
		{				
			return $f['Serie'];
		}
	 else {return FALSE;}

}

/*Esta funcion que gera el codigo QR del recibo*/
function GenerarQRrecibo($folioRecibo,$cantidad,$fecharecibo,$nitavu)
{
	
		//include_once($_SERVER['DOCUMENT_ROOT'].'/Plataforma/Desarrollo/phpqrcode/qrlib.php');
		include_once(dirname(__DIR__, 1).'/phpqrcode/qrlib.php');

		// Ingresamos el contenido de nuestro Código QR
		
		$contenido = $folioRecibo.' '.$cantidad.' '.date_format( date_create($fecharecibo), 'dmY').' '.$nitavu.' ';			
//echo $contenido;
		/*L = Baja
		M = Mediana
		Q = Alta
		H= Máxima*/
		
		$tamaño = 3; //Tamaño de Pixel
		$level = 'Q'; //Precisión Alta
		$framSize = 2; //Tamaño en blanco
		$codesDir =dirname(__DIR__, 1)."/tmp/CodigosQR/"; //Carpeta donde se almacenaran los QR  
		$codeFile = $contenido.date('d-m-Y-h-i-s').'.png';
		QRcode::png($contenido, $codesDir.$codeFile, $level,$tamaño,$framSize);
	//	return $codesDir.$codeFile;
		return $codeFile;
}


/*Esta funcion que gera el codigo QR del recibo*/
function GenerarQR($contenido)
{    
		include_once(dirname(__DIR__, 1).'/phpqrcode/qrlib.php');		
		// Ingresamos el contenido de nuestro Código QR
		
		$tamaño = 3; //Tamaño de Pixel
		$level = 'Q'; //Precisión Alta
		$framSize = 2; //Tamaño en blanco
		$codesDir =dirname(__DIR__, 1)."/tmp/CodigosQR/"; //Carpeta donde se almacenaran los QR  
		$codeFile = $contenido.date('d-m-Y-h-i-s').'.png';
		QRcode::png($contenido, $codesDir.$codeFile, $level,$tamaño,$framSize);
	//	return $codesDir.$codeFile;
		return $codeFile;
}

/**==========================**/
/*Función que nos permite obtener el idmandante de un lote  */
function ObtenerIdMandanteLotes($idlote){
	require("config.php");
	
	$sql = "Select IdLote, IdMandante FROM lotes WHERE IdLote = " . $idlote;
	//echo $sql;
	$rc = $Vivienda -> query($sql);
	while($f = $rc -> fetch_array())
	{
	return $f['IdMandante'];
	}
	
}




/*Función que nos ayuda a obtener el IdPrograma a partir de un Numero de Contrato.  */
function IdProgramaNumContrato($NumContrato){
	require("config.php");
	
	$sql = "Select * from contratos where NumContrato='" .$NumContrato. "'";
   // echo $sql;
    $rc = $Vivienda -> query($sql);
	while($f = $rc -> fetch_array())
	{
		return $f['IdPrograma'];
	}
	
}

/*Función que nos ayuda a obtener el IdDelegacion a partir de un Numero de Contrato.  */
function IdDelegacionNumContrato($NumContrato){
	require("config.php");
	
	$sql = "Select * from contratos where NumContrato='" .$NumContrato. "'";
   // echo $sql;
    $rc = $Vivienda -> query($sql);
	while($f = $rc -> fetch_array())
	{
		return $f['IdDelegacion'];
	}
	
}
/*Función que nos ayuda a obtener el IdDelegacion a partir de un Numero de Contrato.  */
function FolioNumContrato($NumContrato){
	require("config.php");
	
	$sql = "Select * from contratos where NumContrato='" .$NumContrato. "'";
   // echo $sql;
    $rc = $Vivienda -> query($sql);
	while($f = $rc -> fetch_array())
	{
		return $f['Folio'];
	}
	
}
function  MontoPagoNumContrato($NumContrato){
	require("config.php");	
	$sql = "Select * from contratos where NumContrato='" .$NumContrato. "'";
   // echo $sql;
    $rc = $Vivienda -> query($sql);
	while($f = $rc -> fetch_array())
	{
		return $f['MontoPago'];
	}
	
}


/*Función que nos ayuda a obtener el tipomovimiento  */
function TipoMovimiento($idtipomov){
	require("config.php");
	
	$sql = "select * from descripcionmovimiento where idTipoMov=" .$idtipomov ;
    echo $sql;
    $rc = $Vivienda -> query($sql);
	while($f = $rc -> fetch_array())
	{
		return $f['DescripcionMovimiento'];
	}
	
}

/*Función que nos ayuda a obtener el tipomovimiento  */
function TipoMovimientoHP($NumContrato,$NumMov){
	require("config.php");
	
	$sql = "select  TipoMov from historicopagos where NumContrato='" . $NumContrato . "' and nummov=" .$NumMov;
    //echo $sql;
    $rc = $Vivienda -> query($sql);
	while($f = $rc -> fetch_array())
	{
		return $f['TipoMov'];
	}
	
}

/*Esta funcion nos permite consultar si tiene un descuento la cuenta */
function buscaDescuento($NumContrato,$nitavu){
	require("config.php");
	
	$sql = " Select * from autorizaciondescuentos Where NumContrato = '" . $NumContrato . "'	 And Activo = 1 order by FechaCaptura Desc Limit 1";
	$existeDesc='FALSE';
	//echo $sql;
	$rc= $Vivienda -> query($sql);
	if($f = $rc -> fetch_array()){

		$fecha_actual = strtotime(date("d-m-Y H:i:00",time()));
		$fecha_entrada = strtotime($f['Vigencia']);
		//si se encuentra algun registro activo, se verifica que no haya caducado.
		
		if($fecha_actual >  $fecha_entrada)
		{ //si ya cadudo, se cambia el estatus a inactivo	
			$sqlUpdate = "UPDATE autorizaciondescuentos SET Activo = '0', Enviar='1' , IdEmpModifica='".$nitavu."', FechaUltimaMod=NOW() WHERE NumContrato = '".$NumContrato."'";
			//echo $sqlUpdate;
			if ($Vivienda->query($sqlUpdate) == TRUE){   
				$existeDesc='TRUE';
			}else{
				$existeDesc='FALSE';
			}

			$existeDesc='FALSE';
		
		}
		else
		{
			
			$existeDesc=$f['MontoDescuento']."_".$f['MinimoRequiereAbonar']."_".$f['TipoDescuento']."_".$f['IdMovDesc']."_".$f['SustentoAutorizacion'];			
			
		}

	}
	else
	{	
		$existeDesc='FALSE';
		
	}
	return $existeDesc;
																												
}

/*
function RetornaValorImporte($NumContrato,$banMuestraConceptoAhorro=0,$cargo){
	{
		//se revisa si el ultimo movimiento registrado es una actualización por reestructuración 
		/para registrar el pago inicial 110 por actualización por reestructuración
		$valor=0;
		$ultimomov = NumMov($NumContrato);			
        $TipoUltimoMov = TipoMovimientoHP($NumContrato, $ultimomov - 1);
        if ($TipoUltimoMov == 110)         
        {			
			$valor=0;			
		}
	
		if ($banMuestraConceptoAhorro == 1)
		{
            $valor=0;         
	 	}
		 $return 
	}*/

	


	
/*EsTa funcion nos ayuda a conocer si el contrato cumple con el requisito de no presentar atraso en los ultimos 12 meses */
function CumplimientoEnElAño($NumContrato){
	require("config.php");
	
	if(IdProgramaNumContrato($NumContrato)==125)
	{
		return '0';
	}
	else{
			
		$sql = "SELECT  IFNULL(SUM(historicopagos.nuevoRezmoratorios),0), count(nummov)as movims 
		from historicopagos  WHERE     Cancelado = 0 AND NumContrato='".$NumContrato."' AND year(FechaOperacion) = 2018 AND TipoMov not in (13)";
       //echo $sql;
		$rc= $Vivienda -> query($sql);
		if($f = $rc -> fetch_array()){			
			if($f['rezago']=0 AND $f['movims']=12 )
			{
				return '1';
			}
			else
			{
				return '0';
			}
			
		}else{
			return 'FALSE';
		}
	}
}




/*FUNCION QUE PERMITE MOSTRAR LOS CARGOS QUE PUEDE PAGAR  */

function MuestraCargos($NumContrato,$banMuestraConceptoAhorro=0){
	require("config.php");
	$idprogramacontrato=IdProgramaNumContrato($NumContrato);
	$ti = '';
		if($idprogramacontrato == '240'  or $idprogramacontrato == '241')
		{
			if($idprogramacontrato == '240')
			{
				$sql = "select * from descripcionmovimiento where idTipoMov in (69,70,91,137,140)";
			}
			else  if($idprogramacontrato == '241')
			{
				$sql = "select * from descripcionmovimiento where idTipoMov in (51)";
			}

					
		}		
		else
		{
	// 		if (($lblMontoSaldarPesos == 500 or $lblMontoSaldarPesos == 517.11 or $lblMontoSaldarPesos== 578.75) and $idprogramacontrato==125) 
	// 	{
    //          $sql=" select idTipoMov, DescripcionMovimiento from descripcionmovimiento where idTipoMov in (1, 10,50,48)";		
	// 	}
        
		/*	$sql= " select idTipoMov, DescripcionMovimiento from descripcionmovimiento where idTipoMov in
			( select tipomov from historicopagos where NumContrato = '".$NumContrato."' and MontoPagoRecibido = 0 and CapitalPeriodo > 0 
			and TipoMov not in (2, 14, 25, 34,99,108,110,112,120,121,122,123,124,125,126) and cancelado=0 )
			order by DescripcionMovimiento";*/
			
			
			$sql= "select idTipoMov, DescripcionMovimiento from descripcionmovimiento as dm inner join historicopagos as hp
			on dm.idTipoMov=hp.TipoMov where NumContrato = '".$NumContrato."' and MontoPagoRecibido = 0 and CapitalPeriodo> 0 
		   and TipoMov not in (2, 14, 25, 34,99,108,110,112,120,121,122,123,124,125,126) and cancelado=0 
			order by hp.FechaOperacion desc";
			}

		/* se revisa si el ultimo movimiento registrado es una actualización por reestructuración 
		para registrar el pago inicial 110 por actualización por reestructuración*/
		
		$ultimomov = NumMov($NumContrato);			
        $TipoUltimoMov = TipoMovimientoHP($NumContrato, $ultimomov - 1);
        if ($TipoUltimoMov == 110)         
        {
			$sql= "select idTipoMov, DescripcionMovimiento from descripcionmovimiento where idTipoMov in (109)";
		}
	
		if ($banMuestraConceptoAhorro == 1)
		{
          	$sql="select idTipoMov, DescripcionMovimiento from descripcionmovimiento where idTipoMov in (13)";			
		}
		
		echo $sql;
		 $r2x = $Vivienda -> query($sql);	
		 $r_count = $r2x -> num_rows;
		if($r_count > 0)
		{			
		 while($fxx = $r2x -> fetch_array())
		 {
			 
				 $ti = $ti. '<option value="'.$fxx['idTipoMov'].'">'.$fxx['DescripcionMovimiento'].'</option>';		 
		 }
		}else
		{
          	$sql="select idTipoMov, DescripcionMovimiento from descripcionmovimiento where idTipoMov in (1)";
		
			echo $sql;
			$r2x = $Vivienda -> query($sql);
			while($fxx = $r2x -> fetch_array())
			{
				
					$ti = $ti. '<option value="'.$fxx['idTipoMov'].'">'.$fxx['DescripcionMovimiento'].'</option>';		 
			}			
	            
	 	}

		
		return $ti;

	}
	

	/*EsTa funcion nos ayuda a conocer si hay una campaña activa o no*/
function RevisaCampaña(){
	require("config.php");
	$sql = "SELECT Id, FechaInicio, FechaTermino, Descripcion, OficioDeAutorizacion From campanas Where (FechaInicio < now()) And (FechaTermino > now())";
	$rc= $Vivienda -> query($sql);
    if($f = $rc -> fetch_array()){
        return $f['Id'];
    }else{
        return 'FALSE';
    }
}

function RevisaCampañaDescripcion(){
	require("config.php");
	$sql = "SELECT Descripcion From campanas Where (FechaInicio < now()) And (FechaTermino > now())";
	$rc= $Vivienda -> query($sql);
    if($f = $rc -> fetch_array()){
        return $f['Descripcion'];
    }else{
        return '';
    }
}

function RevisaCampañaOficioDeAutorizacion(){
	require("config.php");
	$sql = "SELECT OficioDeAutorizacion From campanas Where (FechaInicio < now()) And (FechaTermino > now())";
	$rc= $Vivienda -> query($sql);
    if($f = $rc -> fetch_array()){
        return $f['OficioDeAutorizacion'];
    }else{
        return '';
    }
}

function RevisaCampañaFechaTermino(){
	require("config.php");
	$sql = "SELECT FechaTermino From campanas Where (FechaInicio < now()) And (FechaTermino > now())";
	$rc= $Vivienda -> query($sql);
    if($f = $rc -> fetch_array()){
        return $f['FechaTermino'];
    }else{
        return 'FALSE';
    }
}
/* //EsTa funcion nos ayuda a conocer el saldo de Vivienda Informacion Financiera*/
function SaldoViviendaIF($NumContrato){
	require("config.php");
	$sql = "SELECT Saldo
    FROM busqueda_vivienda_informacionfinanciera
   	WHERE     (NumContrato = '" . $NumContrato."')";

	$rc= $Vivienda -> query($sql);
    if($f = $rc -> fetch_array()){
        return $f['Saldo'];
    }else{
        return 'FALSE';
    }
}
 
function Saldo_MoratorioViviendaIF($NumContrato){
	require("config.php");

	$sql = "SELECT Saldo_Moratorio
    FROM busqueda_vivienda_informacionfinanciera
   	WHERE     (NumContrato = '" . $NumContrato."')";

	$rc= $Vivienda -> query($sql);
    if($f = $rc -> fetch_array()){
        return $f['Saldo_Moratorio'];
    }else{
        return 'FALSE';
    }
}
 

/*EsTa funcion sirve para obtener el descuento a capital si liquida */
function ObtenerDescuentoDeCapitalLiquida($NumContrato,$NumMov,$idmandante){
    require("config.php");
    $sql = "Select IFNULL(NuevoRezCapital,0) AS NuevoRezCapital ,IFNULL(SaldoCapitalCorriente,0) AS SaldoCapitalCorriente from historicopagos where NumContrato='".$NumContrato. "' and cancelado=0  and nummov=" . $NumMov;
    //echo $sql;
	$rc= $Vivienda -> query($sql);
		if($f = $rc -> fetch_array()){
			if($idmandante==NULL OR $idmandante==0)
			{
				return  ((float)($f['NuevoRezCapital']) + (float)($f['SaldoCapitalCorriente'])) * 0.1;
			}
			else {
				return '0';	
			}		
		}
		else{
			return '0';
		}

	}
	

	/*EsTa funcion nos ayuda a conocer si el contrato cumple con el requisito de no presentar atraso en los ultimos 12 meses */
	function BuscaBono($NumContrato){
    require("config.php");
	$sql = "Select COUNT(*) AS TOTAL from historicopagos  Where NumContrato = '" .$NumContrato . "' And origen = 'BON' and tipomov = 42 And Cancelado=0 ";
	//echo $sql;
	$rc= $Vivienda -> query($sql);
	if($f = $rc -> fetch_array()){
        return $f['TOTAL'];
    }else{
        return 'FALSE';
    }

	}
	
	function TiempoTranscurridoUltimpPago($NumContrato)
	{ 
		$vTiempo=0;
		require("config.php");
		$sql = "  SELECT    IdDelegacion, IdPrograma, Folio, NumContrato, TasaAnualFin, TasaIntMora, MontoCredito, MontoPago, Actualizacion, 
		Cargo_MontoCredito, Cargo_OtrosGastos, 
		Cargo_ComisionesFinancSegVida, Cargo_Moratorios, Abonos_Ahorros, Abonos_Subsidios, Abonos_PagosRecibidos, Abonos_Descuentos, 
		Abonado_SoloCapital,   Saldo_VencidoSinMoratorios , Saldo_Corriente, Saldo_Moratorio, saldo, MesesDeAtraso, FechaPrimerPAGO, fechaultimopago 
		from busqueda_vivienda_informacionfinanciera    WHERE     (NumContrato = '" .$NumContrato . "')";
		$rc = $Vivienda -> query($sql);
		//echo $sql;
						
		$r_count = $rc -> num_rows;
		if($r_count > 0)
		{
			while($f = $rc -> fetch_array()){				
				//# obtenemos la diferencia entre las dos fechas
				if(is_null($f6['FechaUltimoPAGO'])){
					$date1 = new DateTime($f6['FechaEmision']);
					$date2 = new DateTime(getdate());
					$diff = $date1->diff($date2);              
					// //# obtenemos la diferencia en meses
					$vTiempo=$diff->format("%m");
				}else{
					$date1 = new DateTime($f6['FechaUltimoPAGO']);
					$hoy = getdate();                    
					$date2 = new DateTime($fecha);
					$diff = $date1->diff($date2);              
				// //# obtenemos la diferencia en meses
					$vTiempo=$diff->format("%m");
				}
			}

		}
		return $vTiempo;
	}
	
	
	function Registra_PagosParciales($varImporteConvertido , $varImporte,$NumContrato,$fecharecibo, $fechaAplicacion,
	 $FolioRec,$LugarExpedicion,$NumeroMovimiento,$IngresoVia,$factormoneda,$nitavu,$contador_puntos)
	{
		require("config.php");			
		//,
		$sql="Insert into pagosparciales (numcontrato, fechaoperacion, fechacaptura, fechaAplicacion, importepago, importeenpesos, identificadorcajera,
		idLugarOperacion, foliorecibo, NumMov, IngresoVia, FactorConversion, origen, cancelado, enviar, idempcrea, fechaultimamod , puntos_por_pago,OrigenDeEnvio ) 
		values 	('" . $NumContrato ."',  '" .$fecharecibo. "',  NOW(), '".$fechaAplicacion."'," . $varImporteConvertido 
		. ", " . $varImporte . ", " .$nitavu. ", ".$LugarExpedicion . ",'" . $FolioRec ."', " . $NumeroMovimiento .
		 ", " . $IngresoVia .", " . $factormoneda . ", 'CNE', 0, 1, " .$nitavu.", NOW(), " . $contador_puntos . ",".$LugarExpedicion.")";
		//echo $sql;
		$dato=$Vivienda->query($sql) ;		
		if ($dato == TRUE)
			{
				return 'TRUE';
			}
			else
			{
				return 'FALSE';
			}
	}
	
	function ActivarODesactivarDescuento($activar,$nitavu,$NumContrato,$Tipo_descuento)
   {
	   require("config.php");			
		//activo=1 
		//desactivar=0

		//se verifica si se va activar o desactivar el descuento 
		if($activar==0)
		{		
			$sql3 = "UPDATE autorizaciondescuentos Set Activo=0 ,Enviar = 1 ,IdEmpModifica='".$nitavu."',FechaAplicacion=NOW(), FechaUltimaMod=NOW() where Vigencia >= NOW() AND  NumContrato='".$NumContrato . "' And Activo = 1";
		}
		else
		{
			$sql3 = "UPDATE autorizaciondescuentos Set Activo=1,Enviar = 1 ,IdEmpModifica='".$nitavu."',FechaAplicacion=NOW(), FechaUltimaMod=NOW() where Vigencia >= NOW() AND  NumContrato='".$NumContrato  . "'  And Activo =0";
		}   

		if($Tipo_descuento>0)
		{
				$sql3 = $sql3 ." and tipodescuento=".$Tipo_descuento;
		}

        
		//echo 'SQL 43 '.$sql3;
        if ($Vivienda->query($sql3) == TRUE){   
                        $res = 'TRUE';
          }
                else
        {       
             echo  '3. Ocurrio un error, favor de intentarlo nuevamente';
        }      
               
   }
   

	function Destruye_HistoricoPagos($NumContrato, $Secuencia, $varios) 
	{  
		require("config.php");
		if($varios==0)
		{
			$sql="Update historicopagos Set FechaUltimaMod = NOW(), 
			Observaciones = 'Al realizar un cobro, solo se grabo en historicopagos y fallo pagosparciales', Cancelado = 1 where Numcontrato = '" . $NumContrato ."' and NumMov = " . $Secuencia;
		}
		else 
		{  $sql="Update historicopagos Set FechaUltimaMod = NOW(), 
			Observaciones = 'Al realizar un cobro, solo se grabo en historicopagos y fallo pagosparciales', Cancelado = 1 where Numcontrato = '" . $NumContrato ."' and NumMov > " . $Secuencia;
		
		}
		//echo $sql;
		
			if ($Vivienda->query($sql) == TRUE){   
				$res = 'TRUE';
			}
			else
			{
					echo  "Ocurrio un error al querer actualizar el movimiento=".$Secuencia."en historicoPagos";
			}
	}

	function Destruye_PagosParciales($NumContrato, $Secuencia, $varios) 
	{  
		require("config.php");
		if($varios==0)
		{
			$sql="Update pagosparciales Set FechaUltimaMod = NOW(), 
			MotivoDeCancelacion = 'Al realizar un cobro, solo se grabo en historicopagos ,  pagosparciales y fallo', Cancelado = 1 where Numcontrato = '" . $NumContrato ."' and NumMov = " . $Secuencia;
		}
		else 
		{  $sql="Update pagosparciales Set FechaUltimaMod =NOW(), 
			MotivoDeCancelacion = 'Al realizar un cobro, solo se grabo en historicopagos ,  pagosparciales y fallo', Cancelado = 1 where Numcontrato = '" . $NumContrato ."' and NumMov > " . $Secuencia;
		
		}
		//echo $sql;
		
			if ($Vivienda->query($sql) == TRUE){   
				$res = 'TRUE';
			}
			else
			{
					echo  "Ocurrio un error al querer actualizar el movimiento=".$Secuencia."en pagosparciales";
			}
	}



	 function DescuentoAMoratorio($NumContrato,$FolioRec,$distribuyePago,$Registra_PagosParciales,$Secuencia,$nitavu)
	 {
		 if($distribuyePago=='TRUE')
		 {
			// if($Registra_PagosParciales=='TRUE')
			// {
				historia($nitavu,'Registro de Descuento de moratorios al liquidar, campaña.(TablaPagosParciales; NumContrato: '.$NumContrato.", FolioRec:".$FolioRec.")");
			// }else
			// {  //Eliminamos de historicopagos
			// 	Destruye_HistoricoPagos($NumContrato, $Secuencia) ;
			// }
		}else
		{
			echo "Al parecer ha ocurrido un problema en el almacenamiento del recibo, marco error la sección de HISTORICOPAGOS, la sección de PAGOSPARCIALES queda inhabilitada. Favor de comunicarse al Depto. de Informática para el análisis de la cuenta";
		}

	 }


 
 

	function PagoACapital($Monto, $IdTipoMov,$NumContrato,$OrigenDeEnvio,$FormaPago,$fechaRecibo ,$nitavu,$FolioRec,$IngresoVia,$factormoneda,$lblfechasuperior) 
	{
		require("config.php");
		$res='FALSE';
		// localiza nuevamente ultimo para actualizar los saldos
		$maximomovimiento = NumMov($NumContrato);
		
		// //OBTENEMOS LOS DATOS QUE TIENE EL ULTIMO REGISTRO 
	
		$sql = "SELECT  * from historicopagos  WHERE NumContrato = '" . $NumContrato . "'  AND NumMov = " . $maximomovimiento . " ";	
		//echo $sql;
		$r = $Vivienda -> query($sql); 

		$RezGts = NULL;
		$RezSeg = NULL;
		$RezOtrosGts = NULL;
		$RezMoratorios = NULL;
		$RezFinanc = NULL;
		$RezCapital = NULL;

		$RezMoratoriosCubierto=0;
		$RezFinancCubierto = 0;
		$RezCapitalCubierto = 0;
        $CapitalPeriodoCubierto = 0;
		$AplicadoExcedente = 0;
		
		$CapitalPeriodoCubierto=NULL;
		$NuevoRezCapital=NULL;
		$SaldoCapitalCorriente =NULL;

		$RezCapitalUltimo =NULL;
		$SaldoCapitalCorrienteUltimo=NULL;
		$NuevoRezCapitalUltimo=NULL;
		$RezCapitalUltimo=NULL;
		$FechaCorte=NULL;
		$IdDelegacion=$OrigenDeEnvio;

		while($f = $r -> fetch_array()) {    
			$RezGts = $f['NuevoRezGts'];
			$RezSeg = $f['NuevoRezSeg'];
			$RezOtrosGts = $f['NuevoRezOtrosGts'];
			$RezMoratorios = $f['NuevoRezMoratorios'];
			$RezFinanc = $f['NuevoRezFinanc'];
			
			
			$RezCapitalUltimo = $f['NuevoRezCapital'];
			$SaldoCapitalCorrienteUltimo= $f['SaldoCapitalCorriente'];
			$NuevoRezCapitalUltimo=$f['NuevoRezCapital'];
			$RezCapitalUltimo = $f['NuevoRezCapital'];
			$FechaCorte = $f['FechaCorte'];


			$FechaInicia = $f['FechaInicia'];
			$FechaTermina = $f['FechaTermina'];			
			$RezGtsCubierto = $f['RezGtsCubierto'];			
			$NuevoRezGts = $f['NuevoRezGts'];
			$RezSegCubierto = $f['RezSegCubierto'];
			$SegPeriodoCubierto = $f['SegPeriodoCubierto'];
			$NuevoRezSeg= $f['NuevoRezSeg'];
			$RezOtrosGtsCubierto= $f['RezOtrosGtsCubierto'];
			$OtrosGtsPeriodoCubierto= $f['OtrosGtsPeriodoCubierto'];
			$NuevoRezOtrosGts= $f['NuevoRezOtrosGts'];
			$NuevoRezMoratorios= $f['NuevoRezMoratorios'];
			$FinancPeriodoCubierto= $f['FinancPeriodoCubierto'];
			$NuevoRezFinanc= $f['NuevoRezFinanc'];
			$NuevoRezCapital= $f['NuevoRezCapital'];
			$Origen= $f['Origen'];
			$saldoexento= $f['saldoexento'];
			$SaldoCapitalCorriente=$SaldoCapitalCorrienteUltimo;
			$RezCapitalCubierto=$f['RezCapitalCubierto'];
			$RezCapital=$f['RezCapital'];
			$Observaciones=$f['Observaciones'];
			$IdMovDesc=$f['IdMovDesc'];
		
		}

		if ($NuevoRezCapitalUltimo >= $Monto )
		{
			$CapitalPeriodoCubierto = $Monto;
			$NuevoRezCapital = $NuevoRezCapitalUltimo - $Monto;
		}
		else
		{
			if ($NuevoRezCapitalUltimo == 0 )
			{			
                $CapitalPeriodoCubierto = 0;
                $RezCapital = 0;
                $AplicadoExcedente = $Monto;
				$SaldoCapitalCorriente = $SaldoCapitalCorrienteUltimo - $Monto;
			}
			else
			{
				if( $Monto >= $NuevoRezCapitalUltimo)
				{
                    $CapitalPeriodoCubierto = $NuevoRezCapitalUltimo;
                	$NuevoRezCapital = 0;
					//'rst_Nuevo!RezCapital = 0
					if ($Monto > $NuevoRezCapitalUltimo)
					{
					$AplicadoExcedente = ($Monto - $NuevoRezCapitalUltimo ) ;
					$SaldoCapitalCorriente = ($SaldoCapitalCorrienteUltimo - $AplicadoExcedente);
					}
					else
					{
						$AplicadoExcedente = 0;
						$SaldoCapitalCorriente = $SaldoCapitalCorrienteUltimo;
					}
				}
				else
				{
					
                    $CapitalPeriodoCubierto = $Monto;
                    $RezCapital = 0;
                    $SaldoCapitalCorriente = $SaldoCapitalCorrienteUltimo - ($Monto - $RezCapitalUltimo);
                  
				}

			}

		}

		$sql=" INSERT INTO historicopagos (NumContrato	,NumMov	,MontoPagoRecibido	,FechaOperacion	,FechaCorte	,FechaInicia	,FechaTermina	,RezGts	,RezGtsCubierto	,GtsPeriodo	,GtsPeriodoCubiertos	,NuevoRezGts	,RezSeg	,RezSegCubierto	,SegPeriodo	,SegPeriodoCubierto	,NuevoRezSeg	,RezOtrosGts	,
		RezOtrosGtsCubierto	,OtrosGtsPeriodo	,OtrosGtsPeriodoCubierto	,NuevoRezOtrosGts	,RezMoratorios	,RezMoratoriosCubierto	,MoratoriosPeriodo	,NuevoRezMoratorios	,RezFinanc	,RezFinancCubierto	,FinancPeriodo	,FinancPeriodoCubierto	,NuevoRezFinanc	,RezCapital	,RezCapitalCubierto	,CapitalPeriodo
		,CapitalPeriodoCubierto	,NuevoRezCapital	,AplicadoExcedente	,SaldoCapitalCorriente	,Origen	,TipoMov	,Observaciones	,Enviar	,IdEmpCrea	,IdEmpModifica	,FechaCaptura	,FechaUltimaMod	,FechaEnvio	,saldoexento	,ImpSF002	,FechaImpSF002	,FechaReimSF002
		,ReferenciaOpd	,RefBancariaOpd	,IdMovDesc	,Observacion2	,IdFormaPago	,IdSupervisor	,OrigenDeEnvio	,Cancelado	,NumMovErroneo, OriginData)
		values
		('".$NumContrato."',".($maximomovimiento + 1)."	,'".$Monto."'	,'".$fechaRecibo."'	,'".$FechaCorte."' ,'".$FechaInicia."','".$FechaTermina."',".$RezGts.",".$RezGtsCubierto."	,0	,0	,".$NuevoRezGts.",".$RezSeg.",".$RezSegCubierto.",0	,".$SegPeriodoCubierto.",".$NuevoRezSeg.",".$RezOtrosGts."	,
		".$RezOtrosGtsCubierto.",0,".$OtrosGtsPeriodoCubierto.",".$NuevoRezOtrosGts.",".$RezMoratorios."	,".$RezMoratoriosCubierto.",0,".$NuevoRezMoratorios.",".$RezFinanc.",".$RezFinancCubierto."	,0,".$FinancPeriodoCubierto.",".$NuevoRezFinanc.",". $RezCapital.",".$RezCapitalCubierto.",0
		,".$CapitalPeriodoCubierto.",".$NuevoRezCapital."	,".$AplicadoExcedente."	,".$SaldoCapitalCorriente.",'".$Origen."',".$IdTipoMov.",'".$Observaciones."',1	,".$nitavu."	,0	,NOW()	,0	,0	,".$saldoexento.",0	,0	,0
		,''	,''	,0	,''	,".$FormaPago."	,0	,".$IdDelegacion."	,0	,0,".$OrigenDeEnvio.")";
	
		//echo $sql;
		if ($Vivienda->query($sql) == TRUE){

			// $pagos_parciales=Registra_PagosParciales($Monto , $Monto,$NumContrato,$fechaRecibo,$lblfechasuperior,$FolioRec,$IdDelegacion,($maximomovimiento + 1),$IngresoVia,$factormoneda,$nitavu,0);
			// if( $pagos_parciales=='TRUE')
			// {
			 	$res = 'TRUE';
			// }
			// else
			// {
			// 	Destruye_HistoricoPagos($NumContrato,($maximomovimiento + 1),0) ; 
			// }
			
		}else
		{$res = 'FALSE';
			echo  '1. Ocurrio un error, favor de intentarlo nuevamente.';
		}

		
	return $res;


	}


function  RegistraPagoExento($NumContrato,$FolioRecibo,$fechaRecibo,$MontoPagoRecibido,$nitavu,$CveCargo,$IdFormaPago,$OrigenDeEnvio,$Observacion1,$Observacion2,$CveAbono,$IngresoVia,$factormoneda) 
{
	
	require("config.php"); 
	$res='FALSE';
	// localiza nuevamente ultimo para actualizar los saldos
	$maximomovimiento = NumMov($NumContrato);
	$NumeroCuentaAntes=$maximomovimiento;	

	$IdDelegacion=$OrigenDeEnvio;
	$IdPrograma=IdProgramaNumContrato($NumContrato);
	$Folio= FolioNumContrato($NumContrato);


	// //OBTENEMOS LOS DATOS QUE TIENE EL ULTIMO REGISTRO 

	$sql = "SELECT  * from historicopagos  WHERE NumContrato = '" . $NumContrato . "'  AND NumMov = " . $maximomovimiento . " ";	
	
	$r = $Vivienda -> query($sql); 
	while($f = $r -> fetch_array()) {    
		
		$RezGts=$f['NuevoRezGts'];
		$RezGtsCubierto= 0;
		$GtsPeriodo= 0;
		$GtsPeriodoCubiertos= 0;
		$RezSeg=$f['NuevoRezSeg'];
		$RezSegCubierto= 0;
		$SegPeriodo= 0;
		$SegPeriodoCubierto= 0;
		$RezOtrosGts= $f['NuevoRezOtrosGts'];
	    $RezOtrosGtsCubierto= 0;
	    $OtrosGtsPeriodo= 0;
	    $OtrosGtsPeriodoCubierto= 0;
	    $RezMoratorios=  $f['NuevoRezMoratorios'];
	    $RezMoratoriosCubierto= 0;
	    $MoratoriosPeriodo= 0;
	    $RezFinanc=  $f['NuevoRezFinanc'];
	    $RezFinancCubierto= 0;
	    $FinancPeriodo= 0;
	    $FinancPeriodoCubierto= 0;
	    $RezCapital=  $f['NuevoRezCapital'];
	    $RezCapitalCubierto= 0;
	    $CapitalPeriodoCubierto= 0;
	    $AplicadoExcedente= 0;
		$saldoexento=  $f['saldoexento'];
		$SaldoCapitalCorriente=  $f['SaldoCapitalCorriente'];
		$FechaCorte=  $f['FechaCorte'];

		$NuevoRezGts=$f['NuevoRezGts'];
		$NuevoRezSeg=$f['NuevoRezSeg'];
		$NuevoRezMoratorios=$f['NuevoRezMoratorios'];
		$NuevoRezFinanc=$f['NuevoRezFinanc'];
		$NuevoRezCapital=$f['NuevoRezCapital'];
		$NuevoRezOtrosGts=$f['NuevoRezOtrosGts'];
		$CapitalPeriodo=$f['CapitalPeriodo'];
		$TipoMov=$f['TipoMov'];
		$Origen=$f['Origen'];
	   
	}

	$IdEmpCrea = $nitavu;
	//$FechaCaptura =NoW();
	$Enviar = 1;
	$IdEmpModifica=0;
	$FechaUltimaMod=0;
	$FechaEnvio=0;
	$Cancelado=0;
	
	$IdMovDesc=0;
	$Observaciones = "";
	$contador_puntos=0;

		$datosdes = buscaDescuento($NumContrato,$nitavu);
		if($datosdes!='FALSE')
		{     
		
		$datosdes = explode("_", $datosdes);     
		$DescuentoAutorizado=$datosdes[0];
		$minimo=$datosdes[1];
		$Tipo_descuento=$datosdes[2];
		$IdMovDesc=$datosdes[3];;
		$sustento=$datosdes[4];
		$BandAplicaDesc=1;
		
		}else 
		{
		$DescuentoAutorizado=0;
		$minimo=0;
		$Tipo_descuento=0;
		$IdMovDesc=0;
		$Observaciones = "";
		
		}
		
	 switch ($CveCargo) {

                case 48:
                   $CapitalPeriodo = 0;
                   $AplicadoExcedente =$MontoPagoRecibido;
                   $TipoMov = 76;
                   $CveAbono = 76;
                   $saldoExento =(float)$saldoexento - (float)$MontoPagoRecibido;
                   $Saldocapitalcorriente =$SaldoCapitalCorriente;
                   $Observaciones = $Observacion1. " " . $Observacion2;
				   break;
                case 51:
                   $CapitalPeriodo = 0;
                   $AplicadoExcedente = $MontoPagoRecibido;
                   $TipoMov = 77;
                   $CveAbono = 77;
                   $saldoExento = (float)$saldoexento - (float)$MontoPagoRecibido;
                   $Saldocapitalcorriente =$SaldoCapitalCorriente;
                   $Observaciones = $Observacion1. " " . $Observacion2;
				   break;
                case 65:
                   $CapitalPeriodo = 0;
                   $AplicadoExcedente =$MontoPagoRecibido;
                   $TipoMov = 74;
                   $CveAbono = 74;
                   $saldoExento = (float)$saldoexento - (float)$MontoPagoRecibido;
                   $Saldocapitalcorriente =$SaldoCapitalCorriente;
                   $Observaciones =  $Observacion1. " " . $Observacion2;
				   break;
                case 50:
                   $CapitalPeriodo = 0;
                   $AplicadoExcedente = $MontoPagoRecibido;
                   $TipoMov = 75;
                   $CveAbono = 75;
                   $saldoExento =(float)$saldoexento - (floaT)$MontoPagoRecibido;
                   $Saldocapitalcorriente =$SaldoCapitalCorriente;
                   $Observaciones = $Observacion1. " " . $Observacion2;
				   break;
                case 13:
                   $CapitalPeriodo = $MontoPagoRecibido;
                   $AplicadoExcedente = 0;
                   $TipoMov = 13;
                   $CveAbono = 13;
                   $Saldocapitalcorriente =(float)$saldoexento - (floaT)$MontoPagoRecibido;
                   $Observaciones = "";
				   break;
                case 92:
                   $CapitalPeriodo = 0;
                   $AplicadoExcedente =$MontoPagoRecibido;
                   $TipoMov = 93;
                   $CveAbono = 93;
                   $saldoExento =(float)$saldoexento - (floaT)$MontoPagoRecibido;
                   $Saldocapitalcorriente =$SaldoCapitalCorriente;
                   $Observaciones = $Observacion1. " " . $Observacion2;
				   break;
                case 71:
                   $CapitalPeriodo = 0;
                   $AplicadoExcedente = 0;
                   $TipoMov = $CveAbono;
                   $saldoExento = (float)$saldoexento - (floaT)$MontoPagoRecibido;
                   $Saldocapitalcorriente =$SaldoCapitalCorriente;
                   $Observaciones = "";
				   break;
					}
              
				if ($CveAbono == 72) 
				{
                   $TipoMov = 72;
                   $AplicadoExcedente = $DescuentoAutorizado;
                   $Saldocapitalcorriente =$SaldoCapitalCorriente - $DescuentoAutorizado;
                   $Observaciones =$sustento;
				}
               
               
               $FechaCorte =$FechaCorte;
               
               $Observacion2 = $Observacion1. " " . $Observacion2;

		$sql=" INSERT INTO historicopagos (NumContrato	,NumMov	,MontoPagoRecibido	,FechaOperacion	,FechaCorte	,FechaInicia	,FechaTermina	,RezGts	,RezGtsCubierto	,GtsPeriodo	,GtsPeriodoCubiertos	,NuevoRezGts	,RezSeg	,RezSegCubierto	,SegPeriodo	,SegPeriodoCubierto	,NuevoRezSeg	,RezOtrosGts	,
		RezOtrosGtsCubierto	,OtrosGtsPeriodo	,OtrosGtsPeriodoCubierto	,NuevoRezOtrosGts	,RezMoratorios	,RezMoratoriosCubierto	,MoratoriosPeriodo	,NuevoRezMoratorios	,RezFinanc	,RezFinancCubierto	,FinancPeriodo	,FinancPeriodoCubierto	,NuevoRezFinanc	,RezCapital	,RezCapitalCubierto	,CapitalPeriodo
		,CapitalPeriodoCubierto	,NuevoRezCapital	,AplicadoExcedente	,SaldoCapitalCorriente	,Origen	,TipoMov	,Observaciones	,Enviar	,IdEmpCrea	,IdEmpModifica	,FechaCaptura	,FechaUltimaMod	,FechaEnvio	,saldoexento	,ImpSF002	,FechaImpSF002	,FechaReimSF002
		,ReferenciaOpd	,RefBancariaOpd	,IdMovDesc	,Observacion2	,IdFormaPago	,IdSupervisor	,OrigenDeEnvio	,Cancelado	,NumMovErroneo, OriginData)
		
		VALUES ('".$NumContrato."',".($maximomovimiento+1).",'".$MontoPagoRecibido."' ,'".$fechaRecibo."','".$FechaCorte."',0,0,'".$RezGts."','". $RezGtsCubierto.
		"','".$GtsPeriodo."','".$GtsPeriodoCubiertos."','".$NuevoRezGts."','".$RezSeg."','".$RezSegCubierto."','".$SegPeriodo."','".$SegPeriodoCubierto."','".$NuevoRezSeg."','".
		$RezOtrosGts."','".$RezOtrosGtsCubierto."','".$OtrosGtsPeriodo."','".$OtrosGtsPeriodoCubierto."','".$NuevoRezOtrosGts."','".$RezMoratorios."','".$RezMoratoriosCubierto.
		"','".$MoratoriosPeriodo."','".$NuevoRezMoratorios."','".$RezFinanc."','".$RezFinancCubierto."','".$FinancPeriodo."','".$FinancPeriodoCubierto."','".$NuevoRezFinanc."','".
		$RezCapital."','".$RezCapitalCubierto."','".$CapitalPeriodo."','".$CapitalPeriodoCubierto."','".$NuevoRezCapital."','".$AplicadoExcedente."','".$SaldoCapitalCorriente."',
		'".$Origen."',".$TipoMov.",'".$Observaciones."',".$Enviar.",'".$IdEmpCrea."',".$IdEmpModifica.",NOW()	,".$FechaUltimaMod.",".$FechaEnvio.",'".$saldoexento
		."',0,0,0,0,0,".$IdMovDesc.",'".$Observacion2."',".$IdFormaPago.",0	,".$OrigenDeEnvio.",0,0,".$OrigenDeEnvio.")";

		//echo $sql;
		if ($Vivienda->query($sql) == TRUE){  	

			// $pagos_parciales=Registra_PagosParciales($MontoPagoRecibido ,$MontoPagoRecibido,$NumContrato,$fechaRecibo,NULL,$FolioRecibo,
			// $OrigenDeEnvio,($maximomovimiento+1),$IngresoVia,$factormoneda,$nitavu,$contador_puntos);  
			
			$DescripcionCargo= TipoPago_Concepto($CveCargo);	  
			// if( $pagos_parciales=='TRUE')
			// { 
				
				$reciboG=GuardaDatosRecibo($IdDelegacion ,$IdPrograma ,$Folio ,$NumContrato  ,$MontoPagoRecibido,$FormaPago ,$Observacion1 ,$fechaRecibo ,$nitavu, $FolioRecibo ,($maximomovimiento+1),$CveCargo  ,$DescuentoAutorizado);
				if ($reciboG="TRUE")					
				{	
					$res = 'TRUE';
					historia($nitavu, "Registro de pago exento concepto  " .$DescripcionCargo.", contrato='".$NumContrato."' Folio Recibo".$FolioRecibo);  	
					actualizarFolioRecibo($FolioRecibo);


					// MODIFICAMOS EL STATUS DEL DESCUENTO. 
					if( $CveAbono==72)
					{
						$sql2 = "UPDATE autorizaciondescuentos Set Activo=0,Enviar = 1 ,IdEmpModifica='".$nitavu."',FechaAplicacion=NOW(), FechaUltimaMod=NOW() where NumContrato='".$NumContrato . "' And Activo = 1";
						echo $sql2;
						if ($Vivienda->query($sql2) == TRUE){   
								$res = 'TRUE';
								
						}
						else
						{	Destruye_HistoricoPagos($NumContrato,$NumeroCuentaAntes,1) ; 
							ActivarODesactivarDescuento(1,$nitavu,$NumContrato,0);//ACTIVAR DESCUENTO   
					  	//	Destruye_PagosParciales($NumContrato, $NumeroCuentaAntes,1) ;
							$res = 'FALSE';
							//echo  '3. Ocurrio un error al querer actualizar el descuento, favor de intentarlo nuevamente';
						}
					}
				}			
			
			
			

			//}else
			//{	Destruye_HistoricoPagos($NumContrato,$NumeroCuentaAntes,1) ; 
			//	$res = 'FALSE';
				//echo  '2. Ocurrio un error, favor de intentarlo nuevamente. (pagos Parciales)';
			//}
		  

		}else
		{	$res = 'FALSE';
			echo  '1. Ocurrio un error, favor de intentarlo nuevamente.';
		}
	return $res;

}





function distribuye_pago($NumContrato,$fechaRecibo,$IdTipoMov,$ingresado_recibo,$nitavu,$CveCargo,$IdFormaPago,$OrigenDeEnvio)
{
	require("config.php");
	
	include("./determinamontos.php"); 
	////$Bandera_registro_movim = False
	$distribuye_pago = TRUE;
    //***********************
    //variables para calculos
    //***********************
    $remanenteuno =0;
    $remanentedos =0;
    $remanentetres =0;
    $remanentecuatro =0;
    $remanentecinco =0;
    $remanenteseis =0;
    $remanenteSIETE =0;
    $remanenteocho =0;
    $remanentenueve =0;
    $remanentediez =0;

    $Rezago_gastos_y_comisiones =0;
    $Rezago_gastos_y_comisiones_no_cubierto =0;
    $gastos_y_comisiones_esperado_periodo =0;
    $gastos_y_comisiones_esperado_no_cubierto =0;

    $Adeudo_Moratorio =0;
    $Adeudo_Moratorio_no_cubierto =0;
    $Moratorio =0;

    $rezago_financiamiento =0;
    $rezago_financiamiento_no_cubierto =0;
    $financiamiento_esperado_periodo =0;
    $financiamiento_esperado_no_cubierto =0;

    $Saldo_capital_corriente  =0;
    $Saldo_Capital_atrazado =0;
    $Saldo_Capital_atrazado_no_cubierto =0;
    $capital_esperado_periodo =0;
    $capital_esperado_no_cubierto =0;

    $Excedente_capital=0;

    $Rezago_seguros_no_cubierto =0;
    $seguros_esperado_no_cubierto =0;

    $Rezago_otros_conceptos_no_cubierto =0;
    $otros_conceptos_esperado_no_cubierto =0;

    $ban_ingrebono = False;
    $ban_ingrebonoextra = False;
    $montobonoregular = 0;
    $montobonoextra = 0;
    
    //Tomar la informacion de la suma de pagos previos durante el periodo actual y sumar la cantidad abonada con el pago recien recibido

	$Pago_recibido_periodo = $ingresado_recibo;
	
	//$SaldoCapitalCorrienteAnt=0;
	$idcolonia=0;
	$idmunicipio=0;
	$idlote=0;
	$Cancelado=0;
	
	$NumMov = NumMov($NumContrato);
	$TipoMov =0;

	$idprogramacontrato=IdProgramaNumContrato($NumContrato);
	$idtipoTramite=tipoTramitePrograma($idprogramacontrato);

	$DescuentoAutorizado=0;
	$minimo=0;
	$Tipo_descuento=0;
	$IdMovDesc=0;

	$IdEmpCrea = $nitavu;
	//$FechaCaptura =NoW();
	$Enviar = 1;
	$IdEmpModifica=0;
	$FechaUltimaMod=0;
	$FechaEnvio=0;
	

	$lblfechasuperior= $fecha_corte_sig ;
	
	$datosdes = buscaDescuento($NumContrato,$nitavu);
	if($datosdes!='FALSE')
	{     
	  
	$datosdes = explode("_", $datosdes);     
	$DescuentoAutorizado=$datosdes[0];
	$minimo=$datosdes[1];
	$Tipo_descuento=$datosdes[2];
	$IdMovDesc=$datosdes[3];;
	$Observaciones=$datosdes[4];
	$BandAplicaDesc=1;
	
	}else 
	{
	$DescuentoAutorizado=0;
	$minimo=0;
	$Tipo_descuento=0;
	$IdMovDesc=0;
	$Observaciones='';
	
	}

    
    
	if ($IdTipoMov > 0 )
	{  
		$sql = 'CALL sp_pag_servicio("'.$NumContrato.'", "'.$fecharecibo.'", "'.$IdTipoMov.'", "'.$ingresado_recibo.'" , "'.$nitavu.'")';
		//echo $sql;
		
		//var_dump($sql);
		if ($Vivienda->query($sql) == TRUE)
		{ 	
		
			//var_dump($Vivienda);
			$res = 'TRUE';
			//echo 'salio';
			$Vivienda->next_result();
        	//var_dump($Vivienda);
			
			//mensaje( "Se grabo correctamente...",'');
		}
		else
		{
			$res = 'FALSE';
			//mensaje( "problemas en el grabado del registro... intente de nuevo..",'');
		}
    } else {
		echo 'entro else';
    
        
			
		if( $SaldoExentoAnt < 0 And $MontoSaldar > 0 )
		{
			$Pago_recibido_periodo = $Pago_recibido_periodo - $SaldoExentoAnt;
			$SaldoExentoAnt = 0;
		}
		
		//Tomar la informacion de los conceptos que deben ser cubiertos y proceder a determinar; cuales y en que cantidad pueden cubrirse
		//se inicializan los valores de los acumuladores
			
		$Rezago_gastos_y_comisiones = $RezGts;
		$Adeudo_Moratorio = $RezMoratorios;
		$rezago_financiamiento = $RezFinanc;
		$Saldo_Capital_atrazado = $RezCapital;	
		
			
		$gastos_y_comisiones_esperado_periodo = 0;
		$seguros_esperado_periodo = 0;
		$otros_conceptos_esperado_periodo = 0;
		$financiamiento_esperado_periodo = 0;
		$capital_esperado_periodo = 0;
						
		//se inicializan los valores de los acumuladores
		$Rezago_gastos_y_comisiones_no_cubierto = $RezGts;
		$Rezago_seguros_no_cubierto = $Rezago_seguros;
		$Rezago_otros_conceptos_no_cubierto = $Rezago_otros_conceptos;
		$gastos_y_comisiones_esperado_no_cubierto = 0; //gastos_comisiones_periodo
		$seguros_esperado_no_cubierto = 0 ;//seguros_periodo
		$otros_conceptos_esperado_no_cubierto = 0; //otros_conceptos_periodo
						
		$Adeudo_Moratorio_no_cubierto = $RezMoratorios;
		$rezago_financiamiento_no_cubierto = $RezFinanc;
		$financiamiento_esperado_no_cubierto = 0; //$financiamiento_esperado_periodo
		$Saldo_Capital_atrazado_no_cubierto = $RezCapital;
		$capital_esperado_no_cubierto = 0; //$capital_esperado_periodo
		$Excedente_capital = 0;
			
		$remanenteuno = 0;
		$remanentedos = 0;
		$remanentetres = 0;
		$remanentecuatro = 0;
		$remanentecinco = 0;
		$remanenteseis = 0;
		$remanenteSIETE = 0;
		$remanenteocho = 0;
		$remanentenueve = 0;
		$remanentediez = 0;
                     
		//se verifican las condicionantes para cubrir jerarquicamente los conceptos adeudados
		if ( $Pago_recibido_periodo > $Rezago_gastos_y_comisiones) {
		$remanenteuno = $Pago_recibido_periodo - $Rezago_gastos_y_comisiones;
		$Rezago_gastos_y_comisiones_no_cubierto = 0;
		if ( $remanenteuno > $Rezago_seguros) {
			$remanentedos = $remanenteuno - $Rezago_seguros;
			$Rezago_seguros_no_cubierto = 0;
			if ( $remanentedos > $Rezago_otros_conceptos) {
				$remanentetres = $remanentedos - $Rezago_otros_conceptos;
				$Rezago_otros_conceptos_no_cubierto = 0;
					if ( $remanentetres > $gastos_y_comisiones_esperado_periodo) {
					$remanentecuatro = $remanentetres - $gastos_y_comisiones_esperado_periodo;
					$gastos_y_comisiones_esperado_no_cubierto = 0;
					if ( $remanentecuatro > $seguros_esperado_periodo) {
						$remanentecinco = $remanentecuatro - $seguros_esperado_periodo;
						$seguros_esperado_no_cubierto = 0;
						if ( $remanentecinco > $otros_conceptos_esperado_periodo) {
							$remanenteseis = $remanentecinco - $otros_conceptos_esperado_periodo;
							$otros_conceptos_esperado_no_cubierto = 0;
							if ( $remanenteseis > $Adeudo_Moratorio) {
								$remanenteSIETE = $remanenteseis - $Adeudo_Moratorio;
								$Adeudo_Moratorio_no_cubierto = 0;
								if ( $remanenteSIETE > $rezago_financiamiento) {
									$remanenteocho = $remanenteSIETE - $rezago_financiamiento;
									$rezago_financiamiento_no_cubierto = 0;
									if ( $remanenteocho > $financiamiento_esperado_periodo) {
										$remanentenueve = $remanenteocho - $financiamiento_esperado_periodo;
										$financiamiento_esperado_no_cubierto = 0;
										if ( $remanentenueve >= $Saldo_Capital_atrazado) {
											$remanentediez = $remanentenueve - $Saldo_Capital_atrazado;
											if ($Saldo_Capital_atrazado > 0 ){
												// se acaba de poner al corriente
												//se busca si hay un lote relacionado al contrato y si ese lote tiene permitida la bonificacion											 
												$idlote= IdLoteNumContrato($NumContrato);	
												$sql3 = "select IFNULL(aplicabono,0) as aplicable, idmunicipio, idcolonia FROM lotes where idlote = '".$idlote."'";
												//echo $sql;
												$r = $Vivienda -> query($sql3);
													$r_count = $r-> num_rows;
													if($r_count > 0)
													{
														while($f = $r -> fetch_array()){									   
														if($f['aplicable']>0) {
															//buscar porcentaje en cat colonia											
															$idcolonia=$f['idcolonia'];
															$idmunicipio=$f['idmunicipio'];
															//buscar porcentaje en cat colonia																																						
															$sql2 = "select porcentajebono from catcolonia where idcolonia = " . $idcolonia. " and idmunicipio = " . $idmunicipio;
															//echo $sql; 
															$r2 = $Vivienda -> query($sql2);
															$r_count2 = $r2-> num_rows;
															if($r_count2 > 0)
																{
																	while($f2 = $r2 -> fetch_array())
																	{
																		if ($f2['porcentajebono'] > 0) {
																			$ban_ingrebono = True;
																			$montobonoregular = $MontoPago * $f2['porcentajebono'] / 100;
																			}
																		else
																		{
																			//echo' la colonia no tiene un porcentaje de bono registrado';
																			// no se hace nada
																		}
																	}// cierre del while porcentaje
															}   
															else
															{
																//echo ' no se encontro el registro de la colonia relacionada a ese lote';
																// no se hace ;
															}
														}
														else
														{
															//echo ' no tiene permitida la bonificacion';
															// no se hace nada
														}
														}// cierre del while aplicable
													}
													else{
														//echo 'no se encontro un lote para el contrato';
														//'no se hace nada
													}
												}
												else
												{
													//echo 'no habia resago por lo que no acaba de ponerse al corriente';
													//echo 'asi que no aplica un bono regular';
													//echo 'aunque todavia puede calificar para un bono extra';
												}

											$Saldo_Capital_atrazado_no_cubierto = 0;
											if ($remanentediez >= $capital_esperado_periodo )
											{
												$Excedente_capital = $remanentediez - $capital_esperado_periodo;
												$capital_esperado_no_cubierto = 0;
												if ($Excedente_capital > 0) {
													//'se ha abonado un extra
													$idlote= IdLoteNumContrato($NumContrato);	
													$sql3 = "select IFNULL(aplicabono,0) as aplicable, idmunicipio, idcolonia FROM lotes where idlote = '".$idlote."'";
													//echo $sql3;
														$r3 = $Vivienda -> query($sql3);
														$r_count3 = $r3-> num_rows;
														if($r_count3 > 0)
														{
															while($f3 = $r3 -> fetch_array()){									   
															if($f3['aplicable']>0) {
																//buscar porcentaje en cat colonia											
																$idcolonia=$f3['idcolonia'];
																$idmunicipio=$f3['idmunicipio'];
																//buscar porcentaje en cat colonia																																						
																$sql4 = "select porcentajebono from catcolonia where idcolonia = " . $idcolonia. " and idmunicipio = " . $idmunicipio;
																//echo $sql4; 
																$r4 = $Vivienda -> query($sql4);
																$r_count4 = $r4-> num_rows;
																if($r_count4 > 0)
																	{
																		while($f4 = $r4 -> fetch_array())
																		{
																			if ($f4['porcentajebono'] > 0) {
																				$ban_ingrebonoextra = True;
																				$montobonoextra = $Excedente_capital * $f4['porcentajebono'] ;
																				}
																			else
																			{
																				//echo' la colonia no tiene un porcentaje de bono registrado';
																				// no se hace nada
																			}
																		}// cierre del while porcentaje
																}   
																else
																{
																	//echo ' no se encontro el registro de la colonia relacionada a ese lote';
																	// no se hace ;
																}
															}
															else
															{
																//echo ' no tiene permitida la bonificacion';
																// no se hace nada
															}
															}// cierre del while aplicable
														}
														else{
															//echo 'no se encontro un lote para el contrato';
															//'no se hace nada
														}
												}
												else
												{
													//echo 'no ha habido abono extra';
													//'no se hace nada
													
												}
											
											
											}
											else
											{
												$capital_esperado_no_cubierto = $capital_esperado_periodo - $remanentediez;
											}
																						
										} else {
											$Saldo_Capital_atrazado_no_cubierto = $Saldo_Capital_atrazado - $remanentenueve;
										}
									} else {
										$financiamiento_esperado_no_cubierto = $financiamiento_esperado_periodo - $remanenteocho;
									}
								} else {
									$rezago_financiamiento_no_cubierto = $rezago_financiamiento - $remanenteSIETE;
								}
							} else {
								$Adeudo_Moratorio_no_cubierto = $Adeudo_Moratorio - $remanenteseis;
							}
						} else {
							$otros_conceptos_esperado_no_cubierto = $otros_conceptos_esperado_periodo - $remanentecinco;
						}
					} else {
						$seguros_esperado_no_cubierto = $seguros_esperado_periodo - $remanentecuatro;
					}
				} else {
					$gastos_y_comisiones_esperado_no_cubierto = $gastos_y_comisiones_esperado_periodo - $remanentetres;
				}
			} else {
				$Rezago_otros_conceptos_no_cubierto = $Rezago_otros_conceptos - $remanentedos;
			}		  
		} else {
			$Rezago_seguros_no_cubierto = $Rezago_seguros - $remanenteuno;
		}
		} else {
		$Rezago_gastos_y_comisiones_no_cubierto = $Rezago_gastos_y_comisiones - $Pago_recibido_periodo;
		}
        
        // Calcula secuencia
		if($fecha_corte_sig!= "")
		{
			$FechaCorte=$fecha_corte_sig;
		}else
		{	$FechaCorte=NULL;

		}
        
        
        $RezGts = $Rezago_gastos_y_comisiones;
        $RezGtsCubierto = $Rezago_gastos_y_comisiones - $Rezago_gastos_y_comisiones_no_cubierto;
        $GtsPeriodo = 0;                                                                        //gastos_comisiones_periodo
        $GtsPeriodoCubiertos = 0;                                                               //gastos_comisiones_periodo - $gastos_y_comisiones_esperado_no_cubierto
        
        $RezSeg = $Rezago_seguros;
        $RezSegCubierto = $Rezago_seguros - $Rezago_seguros_no_cubierto;
        $SegPeriodo = 0;                                                                        //seguros_periodo
        $SegPeriodoCubierto = 0;                                                               //seguros_periodo -$seguros_esperado_no_cubierto
        
        $RezOtrosGts = $Rezago_otros_conceptos;
        $RezOtrosGtsCubierto = $Rezago_otros_conceptos - $Rezago_otros_conceptos_no_cubierto;
        $OtrosGtsPeriodo = 0;                                                                   //otros_conceptos_periodo
        $OtrosGtsPeriodoCubierto = 0;                                                           //otros_conceptos_periodo - otros_conceptos_esperado_no_cubierto
                                                    
        $RezFinanc = $rezago_financiamiento;
        $RezFinancCubierto = $rezago_financiamiento - $rezago_financiamiento_no_cubierto;
        $FinancPeriodo = 0 ;                                                                    //$financiamiento_esperado_periodo
        $FinancPeriodoCubierto = 0;                                                             //$financiamiento_esperado_periodo - $financiamiento_esperado_no_cubierto
                
		$RezCapital = $Saldo_Capital_atrazado;
	

        if ( $Saldo_Capital_atrazado_no_cubierto > 0 And $Saldo_Capital_atrazado_no_cubierto < 0.01) {
            $RezCapitalCubierto = $Saldo_Capital_atrazado;
            $Saldo_Capital_atrazado_no_cubierto = 0;
        } else {
            $RezCapitalCubierto = $Saldo_Capital_atrazado - $Saldo_Capital_atrazado_no_cubierto;
        }
        
        $CapitalPeriodo = 0 ;                                                                   //$capital_esperado_periodo
        $CapitalPeriodoCubierto = 0;                                                            //$capital_esperado_periodo - $capital_esperado_no_cubierto
                    
        $AplicadoExcedente = $Excedente_capital;  
		
        if ( $Excedente_capital > 0 And($SaldoCapitalCorrienteAnt <= $Excedente_capital)){

             $Excedente_capital = $Excedente_capital - ($SaldoCapitalCorrienteAnt);
             $SaldoCapitalCorrienteAnt =0 ;
             $SaldoExentoAnt = $SaldoExentoAnt - $Excedente_capital;
         } else {
             $SaldoCapitalCorrienteAnt = $SaldoCapitalCorrienteAnt - $Excedente_capital;
        }
        $NuevoRezGts = $RezGts;
        $NuevoRezSeg = $Rezago_seguros_no_cubierto +$seguros_esperado_no_cubierto;
        $NuevoRezOtrosGts = $Rezago_otros_conceptos_no_cubierto + $otros_conceptos_esperado_no_cubierto;
        $NuevoRezFinanc = $rezago_financiamiento_no_cubierto + $financiamiento_esperado_no_cubierto;
        
        $NuevoRezCapital = $Saldo_Capital_atrazado_no_cubierto + $capital_esperado_no_cubierto;
        $SaldoCapitalCorriente = $SaldoCapitalCorrienteAnt;
        $SaldoExento = $SaldoExentoAnt;
			
		

        $RezMoratorios = $RezMoratorios;
        $RezMoratoriosCubierto = $RezMoratorios - $Adeudo_Moratorio_no_cubierto;
        $NuevoRezMoratorios = $Adeudo_Moratorio_no_cubierto;
        $MoratoriosPeriodo = 0;
		$MontoPagoRecibido = $ingresado_recibo;
		$TipoMov=$IdTipoMov;
            if ( $DescuentoAutorizado > 0) {
                $TipoMov = $Tipo_descuento;
                $Origen = "CNE";
            } else {
				$Origen = "DSC";	   
			
                if ($CveCargo == 10) {                           //Cargo de Escritura
                    $TipoMov = 58 ;             //Cve Abono 58 - Pago Escritura
                } else {					
                    if ( $CveCargo == 36 Or $CveCargo == 38 Or $CveCargo == 92 Or $CveCargo == 71 Or $CveCargo == 128) {     //Cesion y Cesión de Derechos Externa
                        $TipoMov = 93;                          //62          //Cve Abono 61 - Pago de Cesion
                        if ( $CveCargo == 71) { $TipoMov = 127;}
                        if ( $CveCargo == 128) { $TipoMov = 129;}
                    } else {						
                        if ( $CveCargo == 51) {
                        // busqueda de documentos
                            $TipoMov = 77;
                        } else {							
                            if ( $CveCargo == 48) {
                            // levantamiento topográfico
                                $TipoMov = 76;
                            } else {								
                                if ( $CveCargo == 50) {
                                // liberacion de gravamen
                                    $TipoMov = 75;
                                } else {									
                                    if ( $CveCargo == 65) {
                                    // reimpresion de carta asignacion
                                        $TipoMov = 74;
                                    } else {										
                                        if ( $CveCargo == 69 Or $CveCargo == 70 Or $CveCargo == 91 Or $CveCargo == 137 Or $CveCargo== 140) {
                                            $TipoMov = 67;      // pago de reintegros
                                        } else {
                                            if ( $CveCargo == 109) {
                                                $TipoMov = 109;      // pago inicial de reestructura acta 62
                                            } else {												
                                              // if ( $CveCargo = 137 {
                                              //      $Tipomov = 138
                                              // } else {
                                                    // define nuevo registro de pago: Abono de crédito de Material o Abono de Lote
                                                    // se identifica el tipo de programa para tomar el tipo de tramite
                                                 
													if((string)$idtipoTramite=="1"){
														
                                                            $TipoMov = 78;
                                                        } else {
															if ((string)$idtipoTramite=="2") 
															{ 
                                                                $TipoMov = 79;
                                                            } else {
																
                                                                $TipoMov = 3;
                                                            }
                                                        }
                                                    
                                                //}
                                             }
                                        }
                                   }
                               }
                            }
                        }
                    }
                }
                $CveAbono = $TipoMov;
            }
            
           

			/*
            if ( cContrato.IdPrograma = 240 Or cContrato.IdPrograma = 241 {
                $Observaciones = Mid(DcReintegros.text, 1, 100)
                $ReferenciaOpd = RstReintegros!NumMov
            } else {
                $Observaciones = tXtObservacion1.text + " " + txtObservacion2.text
            }*/
            

		$sql="INSERT INTO historicopagos (NumContrato	,NumMov	,MontoPagoRecibido	,FechaOperacion	,FechaCorte	,FechaInicia	,FechaTermina	,RezGts	,RezGtsCubierto	,GtsPeriodo	,GtsPeriodoCubiertos	,NuevoRezGts	,RezSeg	,RezSegCubierto	,SegPeriodo	,SegPeriodoCubierto	,NuevoRezSeg	,RezOtrosGts	,
		RezOtrosGtsCubierto	,OtrosGtsPeriodo	,OtrosGtsPeriodoCubierto	,NuevoRezOtrosGts	,RezMoratorios	,RezMoratoriosCubierto	,MoratoriosPeriodo	,NuevoRezMoratorios	,RezFinanc	,RezFinancCubierto	,FinancPeriodo	,FinancPeriodoCubierto	,NuevoRezFinanc	,RezCapital	,RezCapitalCubierto	,CapitalPeriodo
		,CapitalPeriodoCubierto	,NuevoRezCapital	,AplicadoExcedente	,SaldoCapitalCorriente	,Origen	,TipoMov	,Observaciones	,Enviar	,IdEmpCrea	,IdEmpModifica	,FechaCaptura	,FechaUltimaMod	,FechaEnvio	,saldoexento	,ImpSF002	,FechaImpSF002	,FechaReimSF002
		,ReferenciaOpd	,RefBancariaOpd	,IdMovDesc	,Observacion2	,IdFormaPago	,IdSupervisor	,OrigenDeEnvio	,Cancelado	,NumMovErroneo,OriginData)
		VALUES ('".$NumContrato."',".($NumMov+1).",'".$MontoPagoRecibido."','".$fechaRecibo."','".$FechaCorte."',0,0,".$RezGts	.",".$RezGtsCubierto.",".$GtsPeriodo.",".
		$GtsPeriodoCubiertos.",".$NuevoRezGts.",".$RezSeg	.",".$RezSegCubierto	.",".$SegPeriodo	.",".$SegPeriodoCubierto	.",".$NuevoRezSeg	.",".$RezOtrosGts	.",".
		$RezOtrosGtsCubierto	.",".$OtrosGtsPeriodo	.",".$OtrosGtsPeriodoCubierto	.",".$NuevoRezOtrosGts	.",".$RezMoratorios	.",".$RezMoratoriosCubierto	.",".
		$MoratoriosPeriodo	.",".$NuevoRezMoratorios	.",".$RezFinanc	.",".$RezFinancCubierto	.",".$FinancPeriodo	.",".$FinancPeriodoCubierto	.",".$NuevoRezFinanc.",".
		$RezCapital	.",".$RezCapitalCubierto.",".
		$CapitalPeriodo			.",".$CapitalPeriodoCubierto	.",".$NuevoRezCapital.",".$AplicadoExcedente	.",".$SaldoCapitalCorriente	.",'".$Origen."',".$TipoMov.
		",'".$Observaciones	."',".$Enviar	.",".$IdEmpCrea	.",".$IdEmpModifica	.",NOW(),".$FechaUltimaMod	.",".$FechaEnvio.",'".$SaldoExento."',0,0,0,0	,0,'".$IdMovDesc.
		"','',".$IdFormaPago.",0,".$OrigenDeEnvio.",".$Cancelado.",0,".$OrigenDeEnvio.")";
		//echo 'SQ1---'. $sql;
		if ($Vivienda->query($sql) == TRUE){   
			$res = 'TRUE';
			$distribuye_pago='TRUE';
		}else
		{   $distribuye_pago='FALSE';
			
			echo  "SQL1".'1. Ocurrio un error, favor de intentarlo nuevamente.';
		}

		
		$nummov_bono=0;
	
		
		// INTEGRA BONOS EXTRA O DESCUENTOS
		if ( $ban_ingrebonoextra And $Tipo_descuento == 0) {
			$nummov_bono = $nummov_bono + 1;
			$NumeroMovimiento=NumMov($NumContrato);
			$NumMov = $NumeroMovimiento + $nummov_bono;
							
			if ($lblfechasuperior <> "") {
				$FechaCorte = $lblfechasuperior;
			}
						
			$RezGts = 0;
			$RezGtsCubierto = 0;
			$GtsPeriodo = 0;                                        //gastos_comisiones_periodo
			$GtsPeriodoCubiertos = 0;                               //gastos_comisiones_periodo - $gastos_y_comisiones_esperado_no_cubierto

			$RezSeg = 0;
			$RezSegCubierto = 0;
			$SegPeriodo = 0 ;                                       //seguros_periodo
			$SegPeriodoCubierto = 0;                                //seguros_periodo -$seguros_esperado_no_cubierto
			
			$RezOtrosGts = 0;
			$RezOtrosGtsCubierto = 0;
			$OtrosGtsPeriodo = 0;                                   //otros_conceptos_periodo
			$OtrosGtsPeriodoCubierto = 0 ;                          //otros_conceptos_periodo - otros_conceptos_esperado_no_cubierto
													
			$RezFinanc = 0;
			$RezFinancCubierto = 0;
			$FinancPeriodo = 0     ;                                //$financiamiento_esperado_periodo
			$FinancPeriodoCubierto = 0  ;                           //$financiamiento_esperado_periodo - $financiamiento_esperado_no_cubierto
				
			$RezCapital = 0;
			$RezCapitalCubierto = 0;
			$CapitalPeriodo = 0    ;                                //$capital_esperado_periodo
			$CapitalPeriodoCubierto = 0    ;                        //$capital_esperado_periodo - $capital_esperado_no_cubierto
								
			$AplicadoExcedente = $montobonoextra + $montobonoregular;
			
			if ( $montobonoextra + $montobonoregular > 0 And ($SaldoCapitalCorrienteAnt) <= $montobonoextra + $montobonoregular) {
				$montobonoextra = ($montobonoextra + $montobonoregular) - ($SaldoCapitalCorrienteAnt);
				$SaldoCapitalCorrienteAnt = 0;
				$SaldoExentoAnt = $SaldoExentoAnt - $montobonoextra;
			} else {
				$SaldoCapitalCorrienteAnt = $SaldoCapitalCorrienteAnt - ($montobonoextra + $montobonoregular);
			}
			
			$RezGts = 0;
			$Rezago_seguros = 0;
			$Rezago_otros_conceptos = 0;
			$RezFinanc = 0;
			$RezCapital =0 ;
			
			$NuevoRezGts = $RezGts;
			$NuevoRezSeg = $Rezago_seguros;
			$NuevoRezOtrosGts = $Rezago_otros_conceptos;
			$NuevoRezFinanc = $RezFinanc;
			$NuevoRezCapital = $RezCapital;
			$SaldoCapitalCorriente = $SaldoCapitalCorrienteAnt;
			$SaldoExento = $SaldoExentoAnt;
						
			$RezMoratorios = 0;
			$RezMoratoriosCubierto = 0;
								
			//no se calculan moratorios hasta el fin del periodo en el proceso de calculo general
			$MoratoriosPeriodo = 0;
			$NuevoRezMoratorios = 0;
				
			$MontoPagoRecibido = $montobonoextra + $montobonoregular;
			$TipoMov = 42;      //bonificacion pronto pago
			$Origen = "CNE" ;       //cobranza nuevo esquema
			
			$sql2="INSERT INTO historicopagos (NumContrato	,NumMov	,MontoPagoRecibido	,FechaOperacion	,FechaCorte	,FechaInicia	,FechaTermina	,RezGts	,RezGtsCubierto	,GtsPeriodo	,GtsPeriodoCubiertos	,NuevoRezGts	,RezSeg	,RezSegCubierto	,SegPeriodo	,SegPeriodoCubierto	,NuevoRezSeg	,RezOtrosGts	,
			RezOtrosGtsCubierto	,OtrosGtsPeriodo	,OtrosGtsPeriodoCubierto	,NuevoRezOtrosGts	,RezMoratorios	,RezMoratoriosCubierto	,MoratoriosPeriodo	,NuevoRezMoratorios	,RezFinanc	,RezFinancCubierto	,FinancPeriodo	,FinancPeriodoCubierto	,NuevoRezFinanc	,RezCapital	,RezCapitalCubierto	,CapitalPeriodo
			,CapitalPeriodoCubierto	,NuevoRezCapital	,AplicadoExcedente	,SaldoCapitalCorriente	,Origen	,TipoMov	,Observaciones	,Enviar	,IdEmpCrea	,IdEmpModifica	,FechaCaptura	,FechaUltimaMod	,FechaEnvio	,saldoexento	,ImpSF002	,FechaImpSF002	,FechaReimSF002
			,ReferenciaOpd	,RefBancariaOpd	,IdMovDesc	,Observacion2	,IdFormaPago	,IdSupervisor	,OrigenDeEnvio	,Cancelado	,NumMovErroneo,OriginData)
			VALUES ('".$NumContrato."',".($NumMov+1).",'".$MontoPagoRecibido."','".$fechaRecibo."','".$FechaCorte."',0,0,".$RezGts	.",".$RezGtsCubierto.",".$GtsPeriodo.",".
			$GtsPeriodoCubiertos.",".$NuevoRezGts.",".$RezSeg	.",".$RezSegCubierto	.",".$SegPeriodo	.",".$SegPeriodoCubierto	.",".$NuevoRezSeg	.",".$RezOtrosGts	.",".
			$RezOtrosGtsCubierto	.",".$OtrosGtsPeriodo	.",".$OtrosGtsPeriodoCubierto	.",".$NuevoRezOtrosGts	.",".$RezMoratorios	.",".$RezMoratoriosCubierto	.",".
			$MoratoriosPeriodo	.",".$NuevoRezMoratorios	.",".$RezFinanc	.",".$RezFinancCubierto	.",".$FinancPeriodo	.",".$FinancPeriodoCubierto	.",".$NuevoRezFinanc.",".
			$RezCapital	.",".$RezCapitalCubierto.",".
			$CapitalPeriodo			.",".$CapitalPeriodoCubierto	.",".$NuevoRezCapital.",".$AplicadoExcedente	.",".$SaldoCapitalCorriente	.",'".$Origen."',".$TipoMov.
			",'".$Observaciones	."',".$Enviar	.",".$IdEmpCrea	.",".$IdEmpModifica	.",NOW(),".$FechaUltimaMod	.",".$FechaEnvio.",'".$SaldoExento."',0,0,0,0	,0,'".$IdMovDesc.
			"','',".$IdFormaPago.",0,".$OrigenDeEnvio.",".$Cancelado.",0,".$OrigenDeEnvio.")";
			//echo 'SQL2---'. $sql2;
			if ($Vivienda->query($sql2) == TRUE){   
				$res = 'TRUE';
				$distribuye_pago='TRUE';
				
			}else
			{   $distribuye_pago='FALSE';			
				echo  "SQL2".'2. Ocurrio un error, favor de intentarlo nuevamente.';
			}
                    
                    
        
    	} else {
			//no califico para bonoextra pero tal vez si para bono normal
			if ( $ban_ingrebono And $Tipo_descuento == 0) {
				$nummov_bono = $nummov_bono + 1;
				$NumeroMovimiento=NumMov($NumContrato);
				$NumMov = $NumeroMovimiento + $nummov_bono;
							
				//Proceder a vaciar la info sobre la distribucion del ingreso para el periodo actual,
				//acualizar la informacion de ese registro
				
				$FechaOperacion = $fecharecibo;
				
				if ( $lblfechasuperior <> "") {
					$FechaCorte = $lblfechasuperior;
				}
				
				$RezGts = 0;
				$RezGtsCubierto = 0;
				$GtsPeriodo = 0;//gastos_comisiones_periodo
				$GtsPeriodoCubiertos = 0;               //gastos_comisiones_periodo - $gastos_y_comisiones_esperado_no_cubierto

				$RezSeg = 0;
				$RezSegCubierto = 0;
				$SegPeriodo = 0 ;                               //seguros_periodo
				$SegPeriodoCubierto = 0 ;                       //seguros_periodo -$seguros_esperado_no_cubierto
				
				$RezOtrosGts = 0;
				$RezOtrosGtsCubierto = 0;
				$OtrosGtsPeriodo = 0;                           //otros_conceptos_periodo
				$OtrosGtsPeriodoCubierto = 0;                   //otros_conceptos_periodo - otros_conceptos_esperado_no_cubierto
														
				$RezFinanc = 0;
				$RezFinancCubierto = 0;
				$FinancPeriodo = 0;                             //$financiamiento_esperado_periodo
				$FinancPeriodoCubierto = 0;                     //$financiamiento_esperado_periodo - $financiamiento_esperado_no_cubierto
					
				$RezCapital = 0;
				$RezCapitalCubierto = 0;
				$CapitalPeriodo = 0 ;                           //$capital_esperado_periodo
				$CapitalPeriodoCubierto = 0 ;                   //$capital_esperado_periodo - $capital_esperado_no_cubierto
										
				$AplicadoExcedente = $montobonoregular;
								
				if ( $montobonoregular > 0 And ($SaldoCapitalCorrienteAnt) <= $montobonoregular) {
					$montobonoregular = $montobonoregular - ($SaldoCapitalCorrienteAnt);
					$SaldoCapitalCorrienteAnt = 0;
					$SaldoExentoAnt = $SaldoExentoAnt - $montobonoregular;
				} else {
					$SaldoCapitalCorrienteAnt = $SaldoCapitalCorrienteAnt - $montobonoregular;
				}
				
				$RezGts = 0;
				$Rezago_seguros = 0;
				$Rezago_otros_conceptos = 0;
				$RezFinanc = 0;
				$RezCapital = 0;
				
				$NuevoRezGts = $RezGts;
				$NuevoRezSeg = $Rezago_seguros;
				$NuevoRezOtrosGts = $Rezago_otros_conceptos;
				$NuevoRezFinanc = $RezFinanc;
				$NuevoRezCapital = $RezCapital;
				$SaldoCapitalCorriente = $SaldoCapitalCorrienteAnt;
				$SaldoExento =  $SaldoExentoAnt;
								
				$RezMoratorios = 0;
				$RezMoratoriosCubierto = 0;
										
				//no se calculan moratorios hasta el fin del periodo en el proceso de calculo general
				$MoratoriosPeriodo = 0;
				$NuevoRezMoratorios = 0;
						
				$MontoPagoRecibido = $montobonoregular;
				$Tipomov = 42;                      // bonificacion pronto pago
				$Origen = "CNE";                  // cobranza nuevo esquema
				
				$sql3="INSERT INTO historicopagos (NumContrato	,NumMov	,MontoPagoRecibido	,FechaOperacion	,FechaCorte	,FechaInicia	,FechaTermina	,RezGts	,RezGtsCubierto	,GtsPeriodo	,GtsPeriodoCubiertos	,NuevoRezGts	,RezSeg	,RezSegCubierto	,SegPeriodo	,SegPeriodoCubierto	,NuevoRezSeg	,RezOtrosGts	,
				RezOtrosGtsCubierto	,OtrosGtsPeriodo	,OtrosGtsPeriodoCubierto	,NuevoRezOtrosGts	,RezMoratorios	,RezMoratoriosCubierto	,MoratoriosPeriodo	,NuevoRezMoratorios	,RezFinanc	,RezFinancCubierto	,FinancPeriodo	,FinancPeriodoCubierto	,NuevoRezFinanc	,RezCapital	,RezCapitalCubierto	,CapitalPeriodo
				,CapitalPeriodoCubierto	,NuevoRezCapital	,AplicadoExcedente	,SaldoCapitalCorriente	,Origen	,TipoMov	,Observaciones	,Enviar	,IdEmpCrea	,IdEmpModifica	,FechaCaptura	,FechaUltimaMod	,FechaEnvio	,saldoexento	,ImpSF002	,FechaImpSF002	,FechaReimSF002
				,ReferenciaOpd	,RefBancariaOpd	,IdMovDesc	,Observacion2	,IdFormaPago	,IdSupervisor	,OrigenDeEnvio	,Cancelado	,NumMovErroneo,OriginData)
				VALUES ('".$NumContrato."',".($NumMov+1).",'".$MontoPagoRecibido."','".$fechaRecibo."','".$FechaCorte."',0,0,".$RezGts	.",".$RezGtsCubierto.",".$GtsPeriodo.",".
				$GtsPeriodoCubiertos.",".$NuevoRezGts.",".$RezSeg	.",".$RezSegCubierto	.",".$SegPeriodo	.",".$SegPeriodoCubierto	.",".$NuevoRezSeg	.",".$RezOtrosGts	.",".
				$RezOtrosGtsCubierto	.",".$OtrosGtsPeriodo	.",".$OtrosGtsPeriodoCubierto	.",".$NuevoRezOtrosGts	.",".$RezMoratorios	.",".$RezMoratoriosCubierto	.",".
				$MoratoriosPeriodo	.",".$NuevoRezMoratorios	.",".$RezFinanc	.",".$RezFinancCubierto	.",".$FinancPeriodo	.",".$FinancPeriodoCubierto	.",".$NuevoRezFinanc.",".
				$RezCapital	.",".$RezCapitalCubierto.",".
				$CapitalPeriodo			.",".$CapitalPeriodoCubierto	.",".$NuevoRezCapital.",".$AplicadoExcedente	.",".$SaldoCapitalCorriente	.",'".$Origen."',".$TipoMov.
				",'".$Observaciones	."',".$Enviar	.",".$IdEmpCrea	.",".$IdEmpModifica	.",NOW(),".$FechaUltimaMod	.",".$FechaEnvio.",'".$SaldoExento."',0,0,0,0	,0,'".$IdMovDesc.
				"','',".$IdFormaPago.",0,".$OrigenDeEnvio.",".$Cancelado.",0,".$OrigenDeEnvio.")";
				//echo 'SQL3---'. $2;
				if ($Vivienda->query($sql3) == TRUE){   
					$res = 'TRUE';
					$distribuye_pago='TRUE';
				}else
				{   $distribuye_pago='FALSE';				
					echo  "SQL3".'3. Ocurrio un error, favor de intentarlo nuevamente.';
				}
				
			}
    	}
    
    
    
    //Call determinamontos
    
    //$Bandera_registro_movim = True;
        

	}
//Exit Function

//CapturaError:
	//distribuye_pago = False
	return 	$distribuye_pago;
}

//funcion para calcular los puntos_de_pago
function CalculaPuntos($fechavencimiento , $fechapago ) 
{require("config.php");  
    
	$fecha1 = new DateTime($fechavencimiento);
    $fecha2 = new DateTime($fechapago);
    $dias = $fecha1->diff($fecha2);
   $dias=$dias->days;


	//$diff = $fecvencimiento->diff($fechapago);                         
	//$dias=$diff->days;

	switch ($dias) 
	 {
        case ($dias > 10):
			$CalculaPuntos = 12;
			break;		
		case($dias >=6  and $dias<=10):
			$CalculaPuntos = 10;
			break;
		case($dias >=0  and $dias<=5):
			$CalculaPuntos = 8;
			break;			 
		case($dias >=(-5)  and $dias<=(-1)):
			$CalculaPuntos = 6;
			break;			 
		case($dias >=(-10)  and $dias<=(-6)):
			$CalculaPuntos = 4;
			break;			 
		case($dias >=(-15) and $dias<=(-11)):
			$CalculaPuntos = 2;
			break;			 
		case($dias >=(-20) and $dias<=(-16)):
			$CalculaPuntos = -2;
			break;	
		case($dias >=(-25)  and $dias<=(-21)):
			$CalculaPuntos = -4;
			break;		 
		case($dias >=(-30)  and $dias<=(-26)):
			$CalculaPuntos = -6;
			break;			 
		default :
			$CalculaPuntos = -8;
			break;
   }

  return $CalculaPuntos;
}

function SaldoPuntos($NumContrato ) 
{
require("config.php");
$sql = "select ifnull(sum(pu.puntos_por_pago),0) as sumpuntos from pagosparciales pu 
Where pu.cancelado=0 and pu.NumContrato='" . $NumContrato."'";

	$rc= $Vivienda -> query($sql);
    if($f = $rc -> fetch_array()){
        return $f['sumpuntos'];
    }else{
        return 'FALSE';
    }
}

function PagoNormal($NumContrato,$Periodos,$fechaRecibo,$importe,$nitavu,$CveCargo,$FormaPago,$OrigenDeEnvio,$FolioRecibo,$IngresoVia,$factormoneda,$Referencia)
{
	$RES='TRUE';
	require("config.php");
				  
    $BandYaApliqueDescuentoMora = 0;

    $NumDeRepeticionesActual = 1;
    $TotDeRepeticiones = 1;

    $ban_ingrebono = false;
    $ban_ingrebonoextra = false;
	$Bandera_registro_movim = false ;
	
	$NumeroCuentaAntes = NumMov($NumContrato);  
	$acumula_puntos = 0;
	$contador_puntos=0;
	$LugarExpedicion = $OrigenDeEnvio;
	$IdDelegacion=$OrigenDeEnvio;
	$IdPrograma=IdProgramaNumContrato($NumContrato);
	$Folio= FolioNumContrato($NumContrato);
	$datosdes = buscaDescuento($NumContrato,$nitavu);
	if($datosdes!='FALSE')
	{   
		$datosdes = explode("_", $datosdes);     
		$DescuentoAutorizado=$datosdes[0];
		$MinimoAbonar=$datosdes[1];
		$Tipo_descuento=$datosdes[2];
		$IdMovDesc=$datosdes[3];;
		$Observaciones=$datosdes[4];
		$BandAplicaDesc=1;
	
	}else 
	{
		$DescuentoAutorizado=0;
		$MinimoAbonar=0;
		$Tipo_descuento=0;
		$IdMovDesc=0;
		$Observaciones='';
		$BandAplicaDesc=0;
	}
    $EstatusCuenta = ObtenerIdEstatusCuenta($NumContrato);
	$total=$importe;// ojo hay que ver de donde viene el $total
	$MontoPago=MontoPagoNumContrato($NumContrato);
	
	if ($EstatusCuenta == 3 )
	{
        //Registro de ingreso por descuento de nomina
        $IngresoVia = 4;
     }   
	include("./determinamontos.php"); 
	//si hay un descuento autorizado, se realiza el registro del descuento en el historico de pagos
	 /*============================================================================== */
      							  //REGISTRO DEL DESCUENTO
    /*============================================================================== */    
	if( $DescuentoAutorizado > 0 And $importe >= ($MinimoAbonar - 1)) //' + DescuentoAutorizado Then
	{
        //registrar el pago que cubre el importe del descuento
		 if ($BandAplicaDesc == 1)
		 {
			  //SE REGISTRA EL PAGO EN HISTORICOPAGOS
			$NumeroMovimiento= NumMov($NumContrato);          
             $distribuye_pago = distribuye_pago($NumContrato,$fechaRecibo,0,$DescuentoAutorizado,$nitavu,$CveCargo,$FormaPago,$OrigenDeEnvio);
             if  ($distribuye_pago =='TRUE')
             {
				$NumeroMovimiento= NumMov($NumContrato);  
				// $pagos_parciales=Registra_PagosParciales($DescuentoAutorizado ,$DescuentoAutorizado,$NumContrato,$fechaRecibo,NULL,$FolioRecibo,$LugarExpedicion,$NumeroMovimiento,$IngresoVia,$factormoneda,$nitavu,$contador_puntos);
                
				// if( $pagos_parciales=='TRUE')
				// {				
					//se cambia el estado del descuento autorizado a inactivo (se haya o no utilizado el descuento)
					ActivarODesactivarDescuento(0,$nitavu,$NumContrato,0); //ACTIVAR DESCUENTO 
					$RES="TRUE";
				// }else 
				// {   $RES='FALSE';
				// 	Destruye_HistoricoPagos($NumContrato,$NumeroMovimiento,0) ;      
				// }

			 }            
			
		}

	}
		

	
	if($RES=='TRUE')
	{

	/*============================================================================== */
    		// ADELANTAR PAGOS
    /*============================================================================== */    
	if($Periodos > 0 )
	{ 
		$pagos=1;
	   		
		$respaldo_factormoneda = $factormoneda;
		$TotDeRepeticiones = $Periodos;		
		
		//se trata de un pago para aplicar a periodos por adelantado
		for ($pagos=1 ; $pagos <= $TotDeRepeticiones; $pagos++) {		 
			$NumDeRepeticionesActual = $pagos;
			$FolioRecibo = IdSiguienteFolioRecibo();
			// if ($pagos > 1 )
			// {
			// 	actualizarFolioRecibo($FolioRecibo);
			// }
			//realizar el corte sobre el periodo actual que ya esta liquidado
			include("./cerrar_periodo.php");  

            //recargar los datos de la cuenta que aplican al siguiente corte
			include("./determinamontos.php"); 
			
			/*============================================================================== */
             //registrar el pago que cubre el importe esperado para el corte que se acaba de recargar	
            /*============================================================================== */    
			$Periodos=$TotDeRepeticiones;
			
		
			if (($RezCapital - ($total / $Periodos)) / ( $MontoPago==0 ? 1 : $MontoPago) > 2) 
			{
				//tiene varios meses de pagos atrasados
				$contador_puntos = CalculaPuntos(date("d-m-Y",strtotime($fecha_corte_sig."-60 days")), $fechaRecibo);
			}
			else
			{
				if (($RezCapital - ($total / $Periodos)) / ( $MontoPago==0 ? 1 : $MontoPago) >= 1)
				{
				//tiene rezagado solo el pago anterior
				$contador_puntos = CalculaPuntos(date("d-m-Y",strtotime($fecha_corte_sig."-30 days")), $fechaRecibo);
				}
				else
				{
					//va al corriente con sus pagos
					$contador_puntos = CalculaPuntos($fecha_corte_sig, $fechaRecibo);
				}
			}
			 /*============================================================================== */

			
				// SE INSERTA EN HISTORICO PAGOS
				$NumeroMovimiento= NumMov($NumContrato);  
			  	$distribuye_pago = distribuye_pago($NumContrato,$fechaRecibo,0,($importe/$Periodos),$nitavu,$CveCargo,$FormaPago,$OrigenDeEnvio);
			  	if  ($distribuye_pago =='TRUE')
			 	 {
				$NumeroMovimiento= NumMov($NumContrato);  
				// $pagos_parciales=Registra_PagosParciales(($importe/$Periodos) ,($importe/$Periodos),$NumContrato,$fechaRecibo,NULL,$FolioRecibo,$LugarExpedicion,$NumeroMovimiento,$IngresoVia,$factormoneda,$nitavu,$contador_puntos);
                
				// if( $pagos_parciales=='TRUE')
				// {			 
					$reciboG=GuardaDatosRecibo($IdDelegacion ,$IdPrograma ,$Folio ,$NumContrato  ,($importe/$Periodos) ,$FormaPago ,$Referencia ,$fechaRecibo ,$nitavu, $FolioRecibo ,$NumeroMovimiento,$CveCargo  ,$DescuentoAutorizado);
					if ($reciboG="TRUE")					
					{	$acumula_puntos = $acumula_puntos + $contador_puntos;
						historia($nitavu, "Pago de abono de credito, al contrato='".$NumContrato."' Folio Recibo".$FolioRecibo); 	
						$RES="TRUE";
						actualizarFolioRecibo($FolioRecibo);
					}else
					{
						$RES='FALSE';
						Destruye_HistoricoPagos($NumContrato,$NumeroCuentaAntes,1) ;  
						echo "Al parecer ha ocurrido un problema en el almacenamiento del recibo, marco error la sección de datosRecibo (Adelentar pagos)";  
					}				
					

				// }else 
				// {  
				// 	$RES='FALSE';
				// 	Destruye_HistoricoPagos($NumContrato,$NumeroCuentaAntes,1) ;  
				// 	echo "Al parecer ha ocurrido un problema en el almacenamiento del recibo, marco error la sección de PAGOSPARCIALES (Adelentar pagos)";    
				// }
			  }else
			  {  $RES="FALSE";
				echo "Al parecer ha ocurrido un problema en el almacenamiento del recibo, marco error la sección de HISTORICOPAGOS (Adelentar pagos)";

			  }	
						
		} //CIERRE DEL FOR
	
	 }	else {
		 	/*============================================================================== */
             //Rem se trata de un pago normal del periodo actual
            /*============================================================================== */  
 
			if (($RezCapital - $total) /  ($MontoPago==0 ? 1 : $MontoPago)  > 2)
			{
				//tiene varios meses de pagos atrasados
				$contador_puntos = CalculaPuntos(date("d-m-Y",strtotime($fecha_corte_sig."-60 days")), $fechaRecibo);
				
			}
			    
            else
			{
				if (($RezCapital - $total) /($MontoPago==0 ? 1 : $MontoPago)  >= 1)
				{
					//tiene rezagado solo el pago anterior
					$contador_puntos = CalculaPuntos(date("d-m-Y",strtotime($fecha_corte_sig."-30 days")), $fechaRecibo);
				
				}
				else {
					//va al corriente con sus pagos					
					$contador_puntos = CalculaPuntos($fecha_corte_sig, $fechaRecibo);
					
					
				}
			}
                  
	      
			if ($contador_puntos < 0 )
			{
				$puntos_grabados = SaldoPuntos($NumContrato);
				if ($puntos_grabados + $contador_puntos < 0) 
				{
					$contador_puntos = $puntos_grabados * -1;
				}		
			}
			
			 $distribuye_pago = distribuye_pago($NumContrato,$fechaRecibo,0,$total,$nitavu,$CveCargo,$FormaPago,$OrigenDeEnvio);
			  if  ($distribuye_pago =='TRUE')
			  {
				$NumeroMovimiento= NumMov($NumContrato);  
				//$pagos_parciales=Registra_PagosParciales($total,$total,$NumContrato,$fechaRecibo,NULL,$FolioRecibo,$LugarExpedicion,$NumeroMovimiento,$IngresoVia,$factormoneda,$nitavu,$contador_puntos);
				
				// if($pagos_parciales=='TRUE')
				// {
				  	$reciboG=GuardaDatosRecibo($IdDelegacion ,$IdPrograma ,$Folio ,$NumContrato  ,($total) ,$FormaPago ,$Referencia ,$fechaRecibo ,$nitavu, $FolioRecibo ,$NumeroMovimiento,$CveCargo  ,$DescuentoAutorizado);
					if ($reciboG="TRUE")					
					{	$acumula_puntos = $acumula_puntos + $contador_puntos;
						$RES='TRUE';
						historia($nitavu, "Pago de abono de credito, al contrato='".$NumContrato."' Folio Recibo".$FolioRecibo); 	
						$RES="TRUE";
						actualizarFolioRecibo($FolioRecibo);
						                 
					
					}

					
				// }else {
					
				// 	Destruye_HistoricoPagos($NumContrato,$NumeroCuentaAntes,1) ;     
				// 	echo "Al parecer ha ocurrido un problema en el almacenamiento del recibo, marco error la sección de PAGOSPARCIALES (PAGO NORMAL)";
				// 	$RES='FALSE';
				// }
				
				}else {
					$RES='FALSE';
					echo "Al parecer ha ocurrido un problema en el almacenamiento del recibo, marco error la sección de HISTORICOPAGOS (PAGO NORMAL)";
				}

			
}

}

if($RES=='FALSE')
{   Destruye_HistoricoPagos($NumContrato,$NumeroCuentaAntes,1) ;
	
	//Destruye_PagosParciales($NumContrato, $NumeroCuentaAntes,1) ;
	if($BandAplicaDesc==1)
	{
		ActivarODesactivarDescuento(1,$nitavu,$NumContrato,0); //ACTIVAR DESCUENTO
	}
	
}else {
	actualizarFolioRecibo($FolioRecibo);  
}
	return $RES;
}




function GuardaDatosRecibo($IdDelegacion ,$IdPrograma ,$Folio ,$NumContrato  ,$Cantidad ,$FormaPago ,$Referencia ,$FechaRecibo ,$Nitavu, $FolioRecibo ,$NumPago,$IdTipoPago  ,$Descuento)
	{
	require("config.php");

		$codigoQR=GenerarQRrecibo($FolioRecibo,$Cantidad,$FechaRecibo,$Nitavu);

		$sql = "INSERT INTO datosrecibos
			(IdDelegacion   ,IdPrograma  ,Folio  ,NumContrato   ,Cantidad  ,FormaPago  ,Referencia  ,FechaRecibo  ,Nitavu, FolioRecibo  ,NumPago ,IdTipoPago  ,Descuento,codigoQR,Cancelado)
				VALUES
			('".$IdDelegacion."','".$IdPrograma  ."','". $Folio ."','".$NumContrato ."','".$Cantidad  ."','".$FormaPago ."','".$Referencia  ."','".$FechaRecibo  ."','".$Nitavu ."','".$FolioRecibo  ."','".($NumPago)."','".$IdTipoPago  ."','".$Descuento."','".$codigoQR."',0)";
	
			//echo $sql;
				if ($Vivienda->query($sql) == TRUE)
				{				
				
					return 'TRUE';
					//header('location:../index.php');
				}
				else
				{
					
					//echo $sql;
					Destruye_HistoricoPagos($NumContrato,$NumPago,1) ;
					if($Descuento>0)
					{
						ActivarODesactivarDescuento(1,$nitavu,$NumContrato,0); //ACTIVAR DESCUENTO
					}
					return 'FALSE';
	
				}
}

/********************************CREDITO*********************************/

/*Esta funcion nos muestra agrupados y en una tabla los datos de ubicacion de un lote*/
function MuestraUbicacionLote($idlote,$style)
{	
	require("config.php");
$sql = "SELECT * FROM lotes where idLote=".$idlote;
//echo $sql;
$l = $Vivienda -> query($sql);

if (!empty($l) && $l->num_rows > 0)
	{
while($valor = $l -> fetch_array())
   {
	$res="<table style='".$style."' >";

	$res=$res.  "<tr>";      
	$res=$res.  "<td valign='middle'><span class='normal' >IdLote:</span></td>";
	$res=$res.  "<td valign='middle'><span class='tenue normal' style='font-size:13pt;'>".$valor['idLote']."</span>";
	$res=$res.  "<input type='hidden' name='idlote' id='idlote' value=".$valor['idLote']." >" ;
	$res=$res.  "</td>";
	
	$res=$res.  "</tr>";
	
	$res=$res.  "<tr>";      
	$res=$res.  "<td valign='middle'><span class='normal'>Municipio</span></td>";
	$res=$res.  "<td valign='middle'>";
	$res=$res.  "<span class='tenue' >".NombreMunicipioVivienda($valor['IdMunicipio'])."</span>";
	$res=$res.  "</td>";
	// $res=$res.  "<td valign='middle' align='center' ><span class='normal' style='font-size:15pt;'>IdLote </span></td>";
	// $res=$res.  "<td valign='middle' align='left' ><span class='tenue' style='font-size:15pt;'>".$valor['idLote']."</span></td>"; 
	$res=$res.  "</tr>";
	
	$res=$res.  "<tr>";      
	$res=$res.  "<td valign='middle'><span class='normal '>Colonia</span>";
	$res=$res.  "<td valign='middle' colspan='3'>";
	$res=$res.  "<input type='hidden' name='IdColonia1' id='IdColonia1' value=".$valor['IdColonia'].">" ;
	$res=$res.  "<span class='tenue' >".NombreColoniaVivienda($valor['IdMunicipio'],$valor['IdColonia'])."</span>";	
	$res=$res.  "<div";
	
	
	$res=$res.  "</td>";
	$res=$res.  "</tr>";  
		
	$res=$res.  "<tr>";      
	$res=$res.  "<td valign='middle'><span class='normal '>Seccion</span>";
	$res=$res.  "<td valign='middle' >";
	$res=$res.  "<span class='tenue'>".trim($valor['seccion'])."</span>";

	$res=$res.  "</td>";
	$res=$res.  "<td valign='middle'><span class='normal '>Fila</span>";
	$res=$res.  "<td valign='middle'>";
	$res=$res.  "<span class='tenue'>".$valor['fila']."</span>";	
	$res=$res.  "</td>";
	$res=$res.  "</tr>";  
	
	$res=$res.  "<tr>";      
	$res=$res.  "<td valign='middle'><span class='normal '>Manzana</span>";
	$res=$res.  "<td valign='middle'>";
	$res=$res.  "<span class='tenue'>".trim($valor['manzana'])."</span>";	
	$res=$res.  "</td>";
	$res=$res.  "<td valign='middle'><span class='normal'>Lote</span>";
	$res=$res.  "<td valign='middle'>";
	$res=$res.  "<span class='tenue'>".$valor['lote']."</span>";	
	$res=$res.  "</td>";
	$res=$res.  "</tr>";
	
	$res=$res.  "</table> "; 
   }
}else{$res='No hay infromación sobre el lote';}
   return $res;
	
}

/*Esta funcion nos muestra agrupados y en una tabla las medidas y colindancias de un lote*/
function MuestraMedidaColindanciasLote($idlote,$style)
{
	require("config.php");
$sql = "SELECT * FROM lotes where idLote=".$idlote;
$l = $Vivienda -> query($sql);

if (!empty($l) && $l->num_rows > 0)
	{
while($valor = $l -> fetch_array())
   {
	$res="<table style='".$style."' >";

	$res=$res. "<tr>";      
	$res=$res. "<td valign='middle'><span class='normal' >Calle:</span></td>";
	$res=$res. "<td valign='middle' colspan='3'>";
	$res=$res. "<span class='tenue' >".$valor['calle']."</span>";											
	$res=$res. "</td>";
	$res=$res. "</tr>";

	$res=$res. "<tr>";      
	$res=$res. "<td valign='middle'><span class='normal ' >Superficie:</span></td>";
	$res=$res. "<td valign='middle' colspan='3' >";
	$res=$res. "<span class='tenue' >".$valor['superficie']."</span>";	
	$res=$res. "</td>";
	$res=$res. "</tr>";

	$res=$res. "<tr>";      
	$res=$res. "<td valign='middle' >";
	$res=$res. "</td>";
	$res=$res. "<td valign='middle'><span class='normal '><br>Punto Cardinal</span>";
	$res=$res. "</td>";
	$res=$res. "<td valign='middle' colspan='2' ><span class='normal'><br>Colindancia</span>";
	$res=$res. "</td>";
	$res=$res. "</tr>";  
	$res=$res. "<tr>";
	$res=$res. "<td valign='middle'>";
	$res=$res. "</td>";   
	$res=$res. "<td valign='middle'>";
	$res=$res. "</td>";  
	$res=$res. "<td valign='middle' colspan='2'>";
	$res=$res. "</td>";   
	$res=$res. "</tr>";

	$res=$res. "<tr>";      
	$res=$res. "<td valign='middle'><span class='normal '>Colindancia 1:</span>";
	$res=$res. "<input type='hidden' name='colindancia1' id='colindancia1' value='".$valor['con_quien1']."'>";
	$res=$res. "<td valign='middle' >";
	$res=$res. "<span class='tenue' >".$valor['colin1']."</span>";
	$res=$res. "</td>";
	$res=$res. "<td valign='middle' colspan='3'>";
	$res=$res. "<span class='tenue' >".$valor['con_quien1']."</span>";
	$res=$res. "</td>";
	$res=$res. "</tr>";  


	$res=$res. "<tr>";      
	$res=$res. "<td valign='middle'><span class='normal'>Colindancia 2:</span>";
	$res=$res. "<input type='hidden' name='colindancia2' id='colindancia2' value='".$valor['con_quien2']."'>";
	$res=$res. "<td valign='middle' >";
	$res=$res. "<span class='tenue' >".$valor['colin2']."</span>";
	$res=$res. "</td>";
	$res=$res. "<td valign='middle'  colspan='3'>";
	$res=$res. "<span class='tenue' >".$valor['con_quien2']."</span>";
	$res=$res. "</td>";
	$res=$res. "</tr>";  


	$res=$res. "<tr>";      
	$res=$res. "<td valign='middle'><span class='normal'>Colindancia 3:</span>";
	$res=$res. "<input type='hidden' name='colindancia3' id='colindancia3' value='".$valor['con_quien3']."'>";
	$res=$res. "<td valign='middle'  >";
	$res=$res. "<span class='tenue' >".$valor['colin3']."</span>";
	$res=$res. "</td>";
	$res=$res. "<td valign='middle'  colspan='3'>";
	$res=$res. "<span class='tenue' >".$valor['con_quien3']."</span>";
	$res=$res. "</td>";
	$res=$res. "</tr>";  


	$res=$res. "<tr>";      
	$res=$res. "<td valign='middle'><span class='normal'>Colindancia 4:</span>";
	$res=$res. "<input type='hidden' name='colindancia4' id='colindancia4' value='".$valor['con_quien4']."'>";
	$res=$res. "<td valign='middle' >";
	$res=$res. "<span class='tenue' >".$valor['colin4']."</span>";
	$res=$res. "</td>";
	$res=$res. "<td valign='middle'  colspan='3'>";
	$res=$res. "<span class='tenue' >".$valor['con_quien4']."</span>";
	$res=$res. "</td>";
	$res=$res. "</tr>";  

	$res=$res. "<tr style='height: 10px;'>";	
	$res=$res. "</tr>";
	$res=$res. "<tr>";    
	$res=$res. "<td valign='middle'><span class='normal'>Finca:</span>";
	$res=$res. "<td valign='middle'>";
	$res=$res. "<span class='tenue' >".$valor['FINCA']."</span>";
	$res=$res. "</td>";
	$res=$res. "<td valign='middle'><span class='normal'>Clave Catastral:</span>";
	$res=$res. "<td valign='middle' align='center' >";
	$res=$res. "<span class='tenue' >".$valor['CVE_CATASTRAL']."</span>";
	$res=$res. "</td>";
	$res=$res. "</tr>";

	$res=$res. "</table> "; 
   }
}else{
	$res='No hay informacion sobre las medidas';
}  
   return $res;
}		

function GuardarDatoEnDatosEvaluacion($iddelegacion,$idprograma,$folio, $Campo, $Dato,$nitavuMod ){	

	require("config.php");
	//Obtener el valor actual
	//$DatoActual = LotesDatoActual($Idlote, $Campo );
	$sql = "UPDATE datosevaluacion SET	".$Campo." = '".$Dato."', FechaUltimaMod=NOW(), IdEmpModifica='".$nitavuMod."'
		WHERE IdDelegacion = ".$iddelegacion. " and IdPrograma=".$idprograma." and Folio=".$folio;
	 //echo $sql; 
	 //echo "<script> console.log('".$sql."');</script>";
	if ($Vivienda->query($sql) == TRUE){
		//historia($nitavuMod,"lotes: Actualizo el lote con Id " . $Idlote." el campo ".$Campo." de ".$DatoActual." a <b> ".$Dato."</b>");
		return TRUE;	
	}
	else {
		return FALSE;
	}

}

/*EsTa funcion nos ayuda a conocer la descripcion de un TipoMoneda a partir del IdTipoMoneda*/
function TipoMoneda($idtipomoneda){
	require("config.php");	
	$sql="select * from tipomoneda where  IdTipoMoneda=".$idtipomoneda;
	//echo $sql;
	$rc= $Vivienda -> query($sql);
    if($f = $rc -> fetch_array()){
        return $f['TipoMoneda'];
    }else{
        return 'FALSE';
    }
}

/*EsTa funcion nos ayuda a conocer la descripcion de un TipoPagoInicial a partir de un IdTipoInicial*/
function TipoPagoInicial($idpagoinicial){
	require("config.php");	
	$sql="select * from tipopagoinicial where  IdPagoInicial=".$idpagoinicial;
	//echo $sql;
	$rc= $Vivienda -> query($sql);
    if($f = $rc -> fetch_array()){
        return $f['PagoInicial'];
    }else{
        return 'FALSE';
    }
}

/*EsTa funcion nos ayuda a conocer la descripcion del TipoAplicaGtsAdmon a partir de un IdTipoAplicaGtsAdmon*/
function TipoAplicaGtsAdmon($idtipoaplicagtsadmon){
	require("config.php");	
	$sql="select * from tipoaplicagtsadmon where  IdTipoAplicaGtsAdmon=".$idtipoaplicagtsadmon;
	//echo $sql;
	$rc= $Vivienda -> query($sql);
    if($f = $rc -> fetch_array()){
        return $f['TipoAplicaGtsAdmon'];
    }else{
        return 'FALSE';
    }
}

/*EsTa funcion nos ayuda a conocer la descricpion del TipoPago a partir del IdTipoPago */
function TipoPago($idtipopago){
	require("config.php");	
	$sql="select * from tipopago where IdTipoPago=".$idtipopago;
	//echo $sql;
	$rc= $Vivienda -> query($sql);
    if($f = $rc -> fetch_array()){
        return $f['TipoPago'];
    }else{
        return 'FALSE';
    }
}


function TipoInteresMoratorio($idtipointeres){
	require("config.php");
		
	if (!empty($idtipointeres))
	{
		$sql="select * from cattipointeres  where IdTipoInteres=".$idtipointeres;
		//echo $sql;
		$rc= $Vivienda -> query($sql);

		if($f = $rc -> fetch_array()){
			return $f['TipoInteres'];
		}else{
			return 'FALSE';
		}
	}else{ return 'SIN ESPECIFICAR';}
}

function ObtenerTotalAbonadoPorSolicitud($iddelegacion,$idprograma,$folio){
	require("config.php");	
	$sql="select * from vivienda_ahorroprevio  where IdDelegacion = ".$iddelegacion. " and IdPrograma=".$idprograma." and Folio=".$folio;
	//echo $sql;
	$rc= $Vivienda -> query($sql);
    if($f = $rc -> fetch_array()){
        return $f['Abonado'];
    }else{
        return 'FALSE';
    }
}

function TipoAsignacion($idprograma){
	require("config.php");	
	$sql="select * from Programas  where IdPrograma = ".$idprograma;
	//echo $sql;
	$rc= $Vivienda -> query($sql);
    if($f = $rc -> fetch_array()){
        return $f['TipoAsignacion'];
    }else{
        return 'FALSE';
    }
}



	
	/* FUNCION QUE OBTIENE EL SUBSIDIO FEDERAL DE UN LOTE*/ 	
	function SubsidioFederalLotes($claveLote){
		require("config.php");
		$sql = 'SELECT SubsidioFederal FROM lotes WHERE  idLote = '.$claveLote.'';
		//echo $sql;
		$rc = $Vivienda -> query($sql);
		while($f = $rc -> fetch_array())
		{
			return $f['SubsidioFederal'];
		}
	}

	/* FUNCION QUE OBTIENE EL SUBSIDIO ESTATAL DE UN LOTE*/ 	
	function SubsidioEstatalLotes($claveLote){
		require("config.php");
		$sql = 'SELECT SubsidioEstatal FROM lotes WHERE  idLote = '.$claveLote.'';
		//echo $sql;
		$rc = $Vivienda -> query($sql);
		while($f = $rc -> fetch_array())
		{
			return $f['SubsidioEstatal'];
		}
	}

	/* FUNCION QUE OBTIENE EL PRECIO DE UN LOTE*/ 	
	function PrecioLotes($claveLote){
		require("config.php");
		$sql = 'SELECT precio FROM lotes WHERE  idLote = '.$claveLote.'';
		//echo $sql;
		$rc = $Vivienda -> query($sql);
		while($f = $rc -> fetch_array())
		{
			return $f['precio'];
		}
	}

	/* FUNCION QUE OBTIENE EL MONTO CREDITO DE UN LOTE*/ 	
	function MontoCreditoLotes($claveLote){
		require("config.php");
		$sql = 'SELECT MontoCredito FROM lotes WHERE  idLote = '.$claveLote.'';
		//echo $sql;
		$rc = $Vivienda -> query($sql);
		while($f = $rc -> fetch_array())
		{
			return $f['MontoCredito'];
		}
	}

	/* FUNCION QUE OBTIENE EL MONTO CREDITO DE UN CONTRATO*/ 	
	function MontoCreditoContratos($numcontrato){
		require("config.php");
		$sql = 'SELECT MontoCredito from contratos WHERE NumContrato = '.$numcontrato.'';
		//echo $sql;
		$rc = $Vivienda -> query($sql);
		while($f = $rc -> fetch_array())
		{
			return $f['MontoCredito'];
		}
	}

/* FUNCION QUE OBTIENE EL MONTO CREDITO DE UN CONTRATO*/ 	
function MontoCreditoDatosEvaluacion($iddelegacion,$idprograma,$folio){
	require("config.php");
	$sql = "SELECT MontoCredito FROM datosevaluacion WHERE  IdDelegacion=".$iddelegacion." AND IdPrograma=".$idprograma." AND  Folio=".$folio;
	//echo $sql;
	$rc = $Vivienda -> query($sql);
	while($f = $rc -> fetch_array())
	{
		return $f['MontoCredito'];
	}
}
	/* FUNCION QUE OBTIENE EL MONTO PAGO INICIAL DE UN LOTE*/ 	
	function MontoPagoInicialLotes($claveLote){
		require("config.php");
		$sql = 'SELECT MontoPagoInicial FROM lotes WHERE  idLote = '.$claveLote.'';
		//echo $sql;
		$rc = $Vivienda -> query($sql);
		while($f = $rc -> fetch_array())
		{
			return $f['MontoPagoInicial'];
		}
	}


	/* FUNCION QUE OBTIENE EL MONTO PAGO  DE UN LOTE*/ 	
	function MontoPagoLotes($claveLote){
		require("config.php");
		$sql = 'SELECT MontoPago FROM lotes WHERE  idLote = '.$claveLote.'';
		//echo $sql;
		$rc = $Vivienda -> query($sql);
		while($f = $rc -> fetch_array())
		{
			return $f['MontoPago'];
		}
	}

	/* FUNCION QUE OBTIENE EL MONTO ULTIMO PAGO  DE UN LOTE*/ 	
	function MontoUltimoPagoLotes($claveLote){
		require("config.php");
		$sql = 'SELECT MontoUltimoPago FROM lotes WHERE  idLote = '.$claveLote.'';
		//echo $sql;
		$rc = $Vivienda -> query($sql);
		while($f = $rc -> fetch_array())
		{
			return $f['MontoUltimoPago'];
		}
	}

	/*FUNCION PARA OBTENER MAX FOLIO DE LA CONTRATOS*/
	function ObtenerMaxFolioContratos($iddelegacion,$idprograma)
	{
		require("config.php");
		// $sql =  "CALL spBuscaNuevoIdContrato(".$iddelegacion.",".$idprograma.")";
	
		// echo $sql;
		// $rc = $Vivienda -> query($sql);	
		// 	while($f = $rc -> fetch_array())
		// 	{
		// 		if($f['MAXDEFOLIO']=='')
		// 		{
		// 			return 0;
		// 		}else
		// 		{
		// 			return $f['MAXDEFOLIO'];
		// 		}
		// 	}
		
		$sql ="SELECT MAX(foliocontrato.FOLIO) AS MAXDEFOLIO 
		from foliocontrato WHERE (((foliocontrato.IDDELEGACION)=".$iddelegacion.") 
		AND ((foliocontrato.IDPROGRAMA)=".$idprograma."))";
		//echo $sql;
		$rc = $Vivienda -> query($sql);
		while($f = $rc -> fetch_array())
		{
			if($f['MAXDEFOLIO']=='')
				{
					return 0;
				}else
				{
					return $f['MAXDEFOLIO'];
				}
		}
	}


	/*FUNCION PARA INSERTAR EN LA TABLA FOLIOCONTRATO*/
	function InsertarEnFolioContrato($iddelegacion,$idprograma,$maxfolio,$nitavu){
	require("config.php");
	$sql="INSERT INTO foliocontrato(IdDelegacion ,IdPrograma ,Enviar ,FechaCaptura,FechaEnvio ,FechaUltimaMod  ,Folio,IdEmpCrea ,IdEmpModifica)
	VALUES (".$iddelegacion.",".$idprograma .",1,NOW(), NOW(), NOW(),".$maxfolio.",".$nitavu.",0)";
	//(echo $sql;
	$dato=$Vivienda->query($sql) ;		
	if ($dato == TRUE)
		{
			return TRUE;
		}
		else
		{
			return 'FALSE';
		}
	}

	/*FUNCION PARA INSERTAR EN LA TABLA FOLIOCONTRATO*/
	function UpdateEnFolioContrato($iddelegacion,$idprograma,$maxfolio,$nitavu)
	{
		require("config.php");
		$sql="UPDATE foliocontrato SET Enviar=1,FechaUltimaMod=NOW(),Folio=".$maxfolio.",IdEmpModifica=".$nitavu."
		 WHERE IdPrograma=".$idprograma." and IdDelegacion=".$iddelegacion;
		//	echo $sql;
		if ($Vivienda->query($sql) == TRUE)
			{
				return TRUE;
			}
			else
			{
				return FALSE;
			}
	}

	/*FUNCION QUE NOS PERMITE CONOCER  EL IDMUNICIPIO  A PARTIR DE EL IDDELEGACION*/
	function ObtenerIdMunicipioDeDelegacion($iddelegacion)
	{	require("config.php");
		$sql="SELECT  municipios.IdMunicipio FROM municipios inner JOIN catdelmun ON municipios.IdMunicipio=catdelmun.IdMunicipio
		INNER JOIN delegaciones ON catdelmun.IdDelegacion=delegaciones.IdDelegacion
		WHERE  delegaciones.Delegacion=municipios.MUNICIPIO  AND delegaciones.IdDelegacion=".$iddelegacion;
		//echo $sql;
		$rc = $Vivienda -> query($sql);
		while($f = $rc -> fetch_array())
		{
			return $f['IdMunicipio'];
		}
	}


	/*FUNCION PARA GENERAR EL NUMCONTRATO*/
	function GenerarNumContrato($iddelegacion,$idprograma,$idmunicipio,$nitavu)
	{   require("config.php");
		$NuevoidContrato='';	
		$folio= ObtenerMaxFolioContratos($iddelegacion,$idprograma);
		
		
		$folionvo=$folio+1;
		if($folio==0 )/*IDENTIFICAMOS SI NO EXISTE UN FOLIO PARA ESE PROGRAMA SI NO EXISTE EL PRIMERO FOLIO SERÀ 1 Y SE INSERTARÀ  EL REGISTRO*/
		{
			InsertarEnFolioContrato($iddelegacion,$idprograma,$folionvo,$nitavu);
		}
		else
		{
			/*SI YA EXISTE UNO REGISTRO PARA ESE PROGRAMA, SOLO SE ACTUALIZA EL FOLIO*/
			UpdateEnFolioContrato($iddelegacion,$idprograma,$folionvo,$nitavu);	
		}

		/*VERIFACAMOS SI EXISTE UN IDMUNICIPIO SI ESTA VACION, ENTONCES SE PONE COMO IDMUNICIPIO LA DELEGACION*/
		if($idmunicipio==0 or $idmunicipio=='')
		{
			$idmunicipio=ObtenerIdMunicipioDeDelegacion($iddelegacion);
		}
		

		/*GENERAMOS EN NUEVO ID CONTRATO*/
		if ($idprograma < 100)
		{
			// echo "delegacion ".str_pad($iddelegacion, 2, "0", STR_PAD_LEFT).'<br>';
			// echo "programa ".str_pad($idprograma, 2, "0", STR_PAD_LEFT).'<br>';
			// echo "municipio ".str_pad($idmunicipio, 2, "0", STR_PAD_LEFT).'<br>';
			// echo "folio ". str_pad($folionvo, 5, "0", STR_PAD_LEFT).'<br>';
			$NuevoidContrato = 	str_pad($iddelegacion, 2, "0", STR_PAD_LEFT).str_pad($idprograma, 2, "0", STR_PAD_LEFT).str_pad($idmunicipio, 2, "0", STR_PAD_LEFT).str_pad($folionvo, 5, "0", STR_PAD_LEFT);	
		}
		else
		{
		//	echo "delegacion ".str_pad($iddelegacion, 2, "0", STR_PAD_LEFT).'<br>';
		// 	echo "programa ".str_pad($idprograma, 2, "0", STR_PAD_LEFT).'<br>';
		// 	echo "municipio ".str_pad($idmunicipio, 2, "0", STR_PAD_LEFT).'<br>';
		// 	echo "folio ". str_pad($folionvo, 5, "0", STR_PAD_LEFT).'<br>';
			$NuevoidContrato = 	str_pad($iddelegacion, 2, "0", STR_PAD_LEFT).str_pad($idprograma, 3, "0", STR_PAD_LEFT).str_pad($idmunicipio, 2, "0", STR_PAD_LEFT).str_pad($folionvo, 4, "0", STR_PAD_LEFT);	
		}

		
		return	$NuevoidContrato;	
	}
	

	
	function ValidarLoteContratado($idlote)
	{
		require("config.php");
	   $sql = "SELECT * FROM lotes WHERE idLote=".$idlote." and Cancelado=0";   
	  // echo $sql;
	   $r = $Vivienda -> query($sql);         
	   if($f = $r -> fetch_array()){
		 
			if($f['IdEstatus']==2 and $f['contratado']==1)
			{
				return 'TRUE';
			}
			else
			{	
				$sql2 = "SELECT * from contratos WHERE IdLote=".$idlote." and Cancelado=0";
				//echo $sql2;
				$r = $Vivienda -> query($sql2);         
				if($f = $r -> fetch_array())
				{
					return 'TRUE';
				}else
				{
					return 'FALSE';
				}
				
				
			}
		   
	   }
   }
   

   function PasarPagosAPagosParciales($IdDelegacion,$IdPrograma,$Folio,$NumContrato,$nitavu)
    {require("config.php");
		
		$sql = 'SELECT * FROM pagos WHERE  IdDelegacion='.$IdDelegacion.' and IdPrograma ='.$IdPrograma.' and  Folio = '.$Folio.' order by NumPago ASC';
		//echo $sql;
		
		$res='FALSE';
		
		$NumMov=1;
		
		$rc= $Vivienda -> query($sql);
		$row_cnt = $rc->num_rows;		
			if($row_cnt>0)
			{
			  while($f = $rc -> fetch_array())
			  {	

				$NumMov=$NumMov+1; 
				$sql2 = "CALL spInsertarPagosParciales('".$NumContrato."','".$f['Fecha']."','".$f['FechaCaptura']."','".$f['FechaCaptura']."','','".$f['Importe']."', '".$f['Importe']."','".
				$f['IdEmpCrea']."',".$IdDelegacion.",".$NumMov.",3,1,'PIC',0,'','".$nitavu."','','','','".$f['FolioRec']."',0,'','','','','',".$IdDelegacion.",'',0,'','');";
				//echo $sql2;
				if ($Vivienda->query($sql2) == TRUE){
					//echo $sql2;

					$sql3="UPDATE pagos SET Cancelado=1,FechaUltimaMod=NOW(),IdEmpModifica=".$nitavu." WHERE IdDelegacion=".$IdDelegacion." and IdPrograma=".$IdPrograma." and  Folio=".$Folio." AND FolioRec=".$f['FolioRec'];
					//echo $sql3;
					if ($Vivienda->query($sql3) == TRUE)
					{	//echo $sql3;
					
						$res= 'TRUE';
						historia($nitavu,'Ingrese un pago de ahorro a pagos parciales'.$NumContrato);
					}
					else
					{   $res='FALSE';
						historia($nitavu,'ERROR: Al momento de registrar un pago de ahorro a pagos parciales'.$sql3);
						
					}

			

				}else{
					$res='FALSE';
				}

			}  
		}

		return $res;
	}
	// /* FUNCION QUE OBTIENE SI EL ESTATUS CUENTA DE UN CONTRATO(TABLA CONTROLCONTRATOS)*/ 	
	// function ObtenerIdEstatusCuenta($numcontrato){
	// 	require("config.php");
	// 	$sql = 'SELECT EstatusCuenta from controlcontratos WHERE  NumContrato = '.$numcontrato.'';
	// 	//echo $sql;
	// 	$rc = $Vivienda -> query($sql);
	// 	while($f = $rc -> fetch_array())
	// 	{
	// 		return $f['EstatusCuenta'];
	// 	}
	// }

	

	/* FUNCION QUE OBTIENE SI EL ESTATUS CUENTA DE UN CONTRATO(TABLA CONTROLCONTRATOS)*/ 	
	function ObtenerIdEstatusCuenta($numcontrato){
		require("config.php");
		$sql = 'SELECT EstatusCuenta from controlcontratos WHERE  NumContrato = '.$numcontrato.'';
		//echo $sql;
		$rc = $Vivienda -> query($sql);
		while($f = $rc -> fetch_array())
		{
			return $f['EstatusCuenta'];
		}
	}


	/* FUNCION QUE OBTIENE SI EL ESTATUS CUENTA DE UN CONTRATO(TABLA CONTROLCONTRATOS)*/ 	
	function ObtenerEstatusCuenta($estatuscuenta){
		require("config.php");
		$sql = 'SELECT Descripcion FROM estatuscuentas WHERE  idEstatusCuenta = '.$estatuscuenta.'';
		//echo $sql;
		$rc = $Vivienda -> query($sql);
		while($f = $rc -> fetch_array())
		{
			return $f['Descripcion'];
		}
	}


	function LibreParaAsignacion($idlote)
	{
		require("config.php");
	   $sql = "SELECT idestatus FROM lotes WHERE idLote=".$idlote." and Cancelado=0";   
	   //echo $sql;
	   $r = $Vivienda -> query($sql);         
	   if($f = $r -> fetch_array()){
		 
			return $f['idestatus'];
		
		   
	   }
   }

   /**FUNCION QUE NOS PERMITE IDENTIFICAR SI EXISTE UN TRAMITE DE DEVOLUCION EN ESE TRMAITE */
  



function RstTotalRegCredito($numcontrato)
{	
	require("config.php");
	$sql="select COUNT(*) AS TOTAL from historicopagos where  tipomov in (1,35,37) and NumContrato ='".$numcontrato. "'"  ;
	 //  echo $sql;
	   $r = $Vivienda -> query($sql);         
	  
	  
		   while($f = $r -> fetch_array()){
			return $f['TOTAL'];	
		   }
	   
	  
	   
}
//Capital Periodo
function RstCapitalperiodo($numcontrato)
{	
	require("config.php");
	$sql="select capitalperiodo from historicopagos where  tipomov in (1,35,37) and NumContrato ='".$numcontrato. "'"  ;
	  // echo $sql;
	   $r = $Vivienda -> query($sql);         
	  
	  
		   while($f = $r -> fetch_array()){
			return $f['capitalperiodo'];	
		   }
	  
}
	
function RstTipomovCredito($numcontrato)
{	
	require("config.php");
	$sql="select tipomov from historicopagos where  tipomov in (1,35,37) and NumContrato ='".$numcontrato. "'"  ;
	  // echo $sql;
	   $r = $Vivienda -> query($sql);         
	  
	   if ($r->num_rows>0)
	   { 
		   while($f = $r -> fetch_array()){
			return $f['tipomov'];
		   }
	   }
	   else{
		   return 0;
	   }
	   
}
function InputSubirArchivo($Descripcion,$iddelegacion,$idprograma,$folio,$idarchivo)
{	$required="required";
	$identificador=obtenerNumArchivoVigente($iddelegacion,$idprograma,$folio,$idarchivo);
	if($identificador!='')
	{
		$required="";
	}

	$res='';
 	$res=$res. "<div id='contenedor' style='width:100%'>"; 
	$res=$res. "<div id='subirarchivo' style='width:100%;display:inline-block; vertical-align: top; margin:5px; padding:10px;'>";	
	$res=$res.  "<section>";	
	$res=$res.  "<table width=100%><tr><td>";		
	$res=$res.  "<label>".$Descripcion."</label>";					
	$res=$res.  "<form method='POST' action='' enctype='multipart/form-data' id='Form' name='Form' >";
	$res=$res.  '<input '.$required.' style="width=100%;" type="file"  name="Documento" id="Documento" onchange="SubirDocumento('.$iddelegacion.','.$idprograma.','.$folio.','.$idarchivo.')";>';
	$res=$res.  "</form>";
	$res=$res.  "</td><td>";		
		
	$vinculo = "<a name='".$identificador."' id='".$identificador."'  href='md_descargar.php?nombre=DocumentosFiles/".$identificador.".pdf' target='_self'  onclick =''  title='Haga click aqui para descargar'><img src='icon/pdf.png' style='width:36px;'></a>";
	$res=$res.  "<div id='LoaderDoc' style='display:none;'><img src='img/loader_bar.gif' style='width:18px;'></div>";
	
	if($identificador!='')
	{
		$res=$res.  "<div id='PDFDoc' style='display:inline-block; margin-top: 40px;'>".$vinculo."</div></td></tr>";
	}else
	{
		$res=$res.  "<div id='PDFDoc' style='display:none; margin-top: 40px;'>".$vinculo."</div></td></tr>";
	}
	
	$res=$res.  "<tr><td><center>";
	$res=$res.  "</center></td></tr>";
	$res=$res.  "</table>";
	$res=$res.  "</section>";
	$res=$res.  "</div>"; //cierra  subir archivo
	$res=$res.  "</div>"; //cierra  subir archivo

return $res;
}

function num_relaciondoc ()
{
	require("config.php");
	$sql = "Select ifnull(max(id),0)+1 as idnew from relacion_documentos";
	
	$r = $conexion -> query($sql);         
	if($f = $r -> fetch_array()){
	  
		 return $f['idnew'];		
		
	}
}

//FUNCION QUE PERMITE OBTENER EL NUMERO DEL ARCHIVO MAS RECIENTE DE LA TABLA RELACION_DOCUMENTOS
function obtenerNumArchivoVigente ($iddelegacion,$idprograma,$folio,$idarchivo)
{
	require("config.php");
	$sql = "Select n_archivo from relacion_documentos  
	WHERE  iddelegacion=".$iddelegacion." and idprograma =".$idprograma." and  folio = ".$folio." and idarchivo=".$idarchivo." and cancelado=0";

	$r=$conexion->query($sql); 
	if($r){ 
	if ($r->num_rows> 0) {
		while($f = $r -> fetch_array())
		{
			return $f['n_archivo'] ;
		}
		
	}else{ 
		return "0";
	} 
	}else{ 
		return "Error in ".$sql."".$conexion->error; }
}




//FUNCION PARA CANCELAR UN CONTRATO
function MarcarCanceladoContrato ($numcontrato,$nitavu,$obseracionesCancelacion)
{ require("config.php");
	$sql = "update contratos SET enviar=1, idempmodifica=" .$nitavu.",fechaultimamod=now(),CANCELADO=1, Observaciones='".$obseracionesCancelacion."' WHERE numcontrato= '" .$NumContrato. "'";
	//echo $sql;
	if ($Vivienda->query($sql) == TRUE){   
		echo 'TRUE';
	}else{
		echo 'FALSE';
	}
}

function SigNumCancelacion($numcontrato){
    require("config.php");
    $sql = "SELECT IFNULL(Max(NumCancelacion),0) as Num from datoscancelacion WHERE NumContrato = '".$numcontrato."'";
    //echo $sql;
    $rc = $Vivienda -> query($sql);
    while($f = $rc -> fetch_array())
    {
        $nuevoNum = $f['Num']+1;
        return $nuevoNum;
    }
}


//FUNCION PARA INICIALIZAR LA ESTADISTCIA EN TABLA FONHAPO
function InicializaEstadisticaFonhapo($iddelegacion,$idprograma,$folio)
{ require("config.php");
	$sql = " SELECT * FROM estadisticafonhapo WHERE IdDelegacion=".$iddelegacion." AND IdPrograma=".$idprograma." AND  Folio=".$folio;
	//echo $sql;
	if ($Vivienda->query($sql) == TRUE){   
		echo 'TRUE';
	}else{
		echo 'FALSE';
	}
}




//FUNCION PARA DETERMINAR EL IdPaqueteMaterial de la tala Estafisticas Fonhapo
function IdPaqueteMaterialEstFonhapo($iddelegacion,$idprograma,$folio)
{
	require("config.php");
	$sql = "Select * from estadisticafonhapo WHERE  IdDelegacion=".$iddelegacion." and IdPrograma =".$idprograma." and  Folio = ".$folio."";
	//echo $sql;
	$r = $Vivienda -> query($sql);         
	if($f = $r -> fetch_array()){
	  
		 return $f['IdPaqueteMaterial'];		
		
	}
}







//FUNCION PARA DETERMINAR EL TIPO DE ASIGNACION DE UN PROGRAMA
function TipoAsignacionPrograma ($idprograma)
{
	require("config.php");
	$sql = "Select * from programa WHERE  IdPrograma =".$idprograma;
	//echo $sql;
	$r = $Vivienda -> query($sql);         
	if($f = $r -> fetch_array()){
	  
		 return $f['TipoAsignacion'];
	}
}


//FUNCION PARA DETERMINAR SI EXISTE REGISTRO EN TABLA CREDITOS
function HayMontosCreditos($iddelegacion,$idprograma,$folio, $montomaximo)
{ require("config.php");
	$sql = "SELECT IDCREDITO, MONTOCREDITO, TOTALPAGOS  from creditos  
	WHERE MontoCredito<=".$montomaximo." and IdDelegacion=".$iddelegacion." AND IdPrograma=".$idprograma;
	//echo $sql;
	if ($Vivienda->query($sql) == TRUE){   
		echo 'TRUE';
	}else{
		echo 'FALSE';
	}
}

function MontoAhorroDatosEvaluacion($iddelegacion,$idprograma,$folio){
	require("config.php");
	
	$sql="Select MontoPagoInicial  from datosevaluacion where  IdDelegacion=".$iddelegacion." and IdPrograma=".$idprograma ." and Folio='".$folio."'";
    $rc= $Vivienda -> query($sql);
    if($f = $rc -> fetch_array()){
        return $f['MontoPagoInicial'];
    }else{
        return 'FALSE';
    }
}
/*Esta funcion nos ayuda a obtener el monto de la mensualidad de una solicitud*/
function MensualidadDatosEvaluacion($iddelegacion,$idprograma,$folio){
	require("config.php");
	
	$sql="Select MontoPago  from datosevaluacion where  IdDelegacion=".$iddelegacion." and IdPrograma=".$idprograma ." and Folio='".$folio."'";
    $rc= $Vivienda -> query($sql);
    if($f = $rc -> fetch_array()){
        return $f['MontoPago'];
    }else{
        return 'FALSE';
    }
}
/*Esta funcion nos ayuda a obtener tiempo de ahorro de una solicitud*/
function TiempoAhorroDatosEvaluacion($iddelegacion,$idprograma,$folio){
	require("config.php");	
	$sql="Select TiempoMinimoAhorro  from datosevaluacion where  IdDelegacion=".$iddelegacion." and IdPrograma=".$idprograma ." and Folio='".$folio."'";
    $rc= $Vivienda -> query($sql);
    if($f = $rc -> fetch_array()){
        return $f['TiempoMinimoAhorro'];
    }else{
        return 'FALSE';
    }

}
/*EsTa funcion nos ayuda a conocer el tipo de moneda con el que se pagará un credito, este dato es obtenido de datos evaluacion*/
function TipoMonedaDatosEvaluacion($iddelegacion,$idprograma,$folio){
	require("config.php");
	
	$sql="Select IdTipoMoneda  from datosevaluacion where  IdDelegacion=".$iddelegacion." and IdPrograma=".$idprograma ." and Folio='".$folio."'";
	//echo $sql;
	$rc= $Vivienda -> query($sql);
    if($f = $rc -> fetch_array()){
        return $f['IdTipoMoneda'];
    }else{
        return 'FALSE';
    }
}

/*EsTa funcion nos ayuda a conocer el tipo de pago inicial que tendrá el credito , este dato es obtenido de datos evaluacion*/
function TipoPagoInicialDatosEvaluacion($iddelegacion,$idprograma,$folio){
	require("config.php");
	
	$sql="Select IdPagoInicial  from datosevaluacion where  IdDelegacion=".$iddelegacion." and IdPrograma=".$idprograma ." and Folio='".$folio."'";
    $rc= $Vivienda -> query($sql);
    if($f = $rc -> fetch_array()){
        return $f['IdPagoInicial'];
    }else{
        return 'FALSE';
    }
}

/*EsTa funcion nos ayuda a obtener  si aplica o no gastos admon en el credito, este dato es obtenido de datos evaluacion*/
function AplicaGastosAdmonDatosEvaluacion($iddelegacion,$idprograma,$folio){
	require("config.php");
	
	$sql="Select AplicaGtsAdmon  from datosevaluacion where  IdDelegacion=".$iddelegacion." and IdPrograma=".$idprograma ." and Folio='".$folio."'";
    $rc= $Vivienda -> query($sql);
    if($f = $rc -> fetch_array()){
        return $f['AplicaGtsAdmon'];
    }else{
        return 'FALSE';
    }
}

/*EsTa funcion obtiene el seguro de vida en credito, este dato es obtenido de datos evaluacion*/
function SegurodeVidaDatosEvaluacion($iddelegacion,$idprograma,$folio){
	require("config.php");
	
	$sql="Select SegurodeVida  from datosevaluacion where  IdDelegacion=".$iddelegacion." and IdPrograma=".$idprograma ." and Folio='".$folio."'";
    $rc= $Vivienda -> query($sql);
    if($f = $rc -> fetch_array()){
        return $f['SegurodeVida'];
    }else{
        return 'FALSE';
    }
}
/*Esta funcion nos ayuda a obtener periodo de mora que tendrá el credito, este dato es obtenido de datos evaluacion*/
function PeriodoMoraDatosEvaluacion($iddelegacion,$idprograma,$folio){
	require("config.php");
	
	$sql="Select PeriodoMora  from datosevaluacion where  IdDelegacion=".$iddelegacion." and IdPrograma=".$idprograma ." and Folio='".$folio."'";
    $rc= $Vivienda -> query($sql);
    if($f = $rc -> fetch_array()){
        return $f['PeriodoMora'];
    }else{
        return 'FALSE';
    }
}
/*Esta funcion nos ayuda a obtener interes moratorio que tendrá el credito, este dato es obtenido de datos evaluacion*/
function TipoIntMoratorioDatosEvaluacion($iddelegacion,$idprograma,$folio){
	require("config.php");
	
	$sql="Select TipoIntMoratorio  from datosevaluacion where  IdDelegacion=".$iddelegacion." and IdPrograma=".$idprograma ." and Folio='".$folio."'";
    $rc= $Vivienda -> query($sql);
    if($f = $rc -> fetch_array()){
        return $f['TipoIntMoratorio'];
    }else{
        return 'FALSE';
    }
}
/*Esta funcion nos ayuda a obtener el total de pagos de una solicitud*/
function TotalPagosDatosEvaluacion($iddelegacion,$idprograma,$folio){
	require("config.php");
	
	$sql="Select TotalPagos  from datosevaluacion where  IdDelegacion=".$iddelegacion." and IdPrograma=".$idprograma ." and Folio='".$folio."'";
    $rc= $Vivienda -> query($sql);
    if($f = $rc -> fetch_array()){
        return $f['TotalPagos'];
    }else{
        return 'FALSE';
    }
}
/*Esta funcion nos ayuda a obtener el IdEmpleado Evaluador de Datos Evaluacion*/
function  IdEmpEvaluadorDatosEvaluacion($iddelegacion,$idprograma,$folio){
	require("config.php");	
	$sql="Select IdEmpEvaluador  from datosevaluacion where  IdDelegacion='".$iddelegacion."' and IdPrograma='".$idprograma ."' and Folio='".$folio."'";
   //echo $sql;
	$rc= $Vivienda -> query($sql);
    if($f = $rc -> fetch_array()){
        return $f['IdEmpEvaluador'];
    }else{
        return '0';
    }

}
//* BENEFICIARIO *//

/*Esta funcion nos ayuda a obtener el RFonhapo de  DatosEvaluacion*/
function  RBeneficiarioDatosEvaluacion($iddelegacion,$idprograma,$folio){
	require("config.php");	
	$sql="Select RBeneficiario  from datosevaluacion where  IdDelegacion='".$iddelegacion."' and IdPrograma='".$idprograma ."' and Folio='".$folio."'";
   //echo $sql;
	$rc= $Vivienda -> query($sql);
    if($f = $rc -> fetch_array()){
        return $f['RBeneficiario'];
    }else{
        return '0';
    }

}

//* FONHAPO *//

/*Esta funcion nos ayuda a obtener el RFonhapo de  DatosEvaluacion*/
function  RFonhapoDatosEvaluacion($iddelegacion,$idprograma,$folio){
	require("config.php");	
	$sql="Select RFonhapo  from datosevaluacion where  IdDelegacion='".$iddelegacion."' and IdPrograma='".$idprograma ."' and Folio='".$folio."'";
   //echo $sql;
	$rc= $Vivienda -> query($sql);
    if($f = $rc -> fetch_array()){
        return $f['RFonhapo'];
    }else{
        return '0';
    }
}


/*EsTa funcion nos ayuda a obtener el monto de  gastos admon en el credito, este dato es obtenido de datos evaluacion*/
function GastosAdmonDatosEvaluacion($iddelegacion,$idprograma,$folio){
	require("config.php");
	
	$sql="Select GtsAdmon  from datosevaluacion where  IdDelegacion=".$iddelegacion." and IdPrograma=".$idprograma ." and Folio='".$folio."'";
    $rc= $Vivienda -> query($sql);
    if($f = $rc -> fetch_array()){
        return $f['GtsAdmon'];
    }else{
        return 'FALSE';
    }
}


/*Esta funcion nos ayuda a obtener el Gastos Administrativos de DatosEvaluacion*/
function  F_GtsAdmonFonhapoDatosEvaluacion($iddelegacion,$idprograma,$folio){
	require("config.php");	
	$sql="Select F_GtsAdmon  from datosevaluacion where  IdDelegacion='".$iddelegacion."' and IdPrograma='".$idprograma ."' and Folio='".$folio."'";
   //echo $sql;
	$rc= $Vivienda -> query($sql);
    if($f = $rc -> fetch_array()){
        return $f['F_GtsAdmon'];
    }else{
        return '0';
    }
}



//* ITAVU *//

/*Esta funcion nos ayuda a obtener el RItavu de  DatosEvaluacion*/
function RItavuDatosEvaluacion($iddelegacion,$idprograma,$folio){
	require("config.php");	
	$sql="Select RItavu from datosevaluacion where  IdDelegacion='".$iddelegacion."' and IdPrograma='".$idprograma ."' and Folio='".$folio."'";
   //echo $sql;
	$rc= $Vivienda -> query($sql);
    if($f = $rc -> fetch_array()){
        return $f['RItavu'];
    }else{
        return '0';
    }
}


/*Esta funcion nos ayuda a obtener el I_GtsAdmo de DatosEvaluacion*/
function I_GtsAdmonDatosEvaluacion($iddelegacion,$idprograma,$folio){
	require("config.php");	
	$sql="Select I_GtsAdmon  from datosevaluacion where  IdDelegacion='".$iddelegacion."' and IdPrograma='".$idprograma ."' and Folio='".$folio."'";
   //echo $sql;
	$rc= $Vivienda -> query($sql);
    if($f = $rc -> fetch_array()){
        return $f['I_GtsAdmon'];
    }else{
        return '0';
    }
}


//* CREDITO *//
/*Esta funcion nos ayuda a obtener el I_GtsAdmo de DatosEvaluacion*/
function GtsEscrituracionDatosEvaluacion($iddelegacion,$idprograma,$folio){
	require("config.php");	
	$sql="Select MontoEscrituracion  from datosevaluacion where  IdDelegacion='".$iddelegacion."' and IdPrograma='".$idprograma ."' and Folio='".$folio."'";
   //echo $sql;
	$rc= $Vivienda -> query($sql);
    if($f = $rc -> fetch_array()){
        return $f['MontoEscrituracion'];
    }else{
        return '0';
    }
}




/*Esta funcion nos ayuda a obtener el GtsAdmon de  DatosEvaluacion*/
function  GtsAdmonDatosEvaluacion($iddelegacion,$idprograma,$folio){
	require("config.php");	
	$sql="Select GtsAdmon  from datosevaluacion where  IdDelegacion='".$iddelegacion."' and IdPrograma='".$idprograma ."' and Folio='".$folio."'";
   //echo $sql;
	$rc= $Vivienda -> query($sql);
    if($f = $rc -> fetch_array()){
        return $f['GtsAdmon'];
    }else{
        return '0';
    }
}



/*Esta funcion nos ayuda a obtener el  IdTipoPago de  DatosEvaluacion*/
function  IdTipoPagoDatosEvaluacion($iddelegacion,$idprograma,$folio){
	require("config.php");	
	$sql="Select  IdTipoPago  from datosevaluacion where  IdDelegacion='".$iddelegacion."' and IdPrograma='".$idprograma ."' and Folio='".$folio."'";
   //echo $sql;
	$rc= $Vivienda -> query($sql);
    if($f = $rc -> fetch_array()){
        return $f['IdTipoPago'];
    }else{
        return '0';
    }
}

/*Esta funcion nos ayuda a obtener el  IdTipoPago de  DatosEvaluacion*/
function MontoUltimoPagoDatosEvaluacion($iddelegacion,$idprograma,$folio){
	require("config.php");
	$sql="Select  MontoUltimoPago  from datosevaluacion where  IdDelegacion='".$iddelegacion."' and IdPrograma='".$idprograma ."' and Folio='".$folio."'";
	//echo $sql;
	 $rc= $Vivienda -> query($sql);
	 if($f = $rc -> fetch_array()){
		 return $f['MontoUltimoPago'];
	 }else{
		 return '0';
	 }
 }

 /*Esta funcion nos ayuda a obtener el  PGtsAdmon de  DatosEvaluacion*/
function  PGtsAdmonDatosEvaluacion($iddelegacion,$idprograma,$folio){
	require("config.php");	
	$sql="Select PGtsAdmon  from datosevaluacion where  IdDelegacion='".$iddelegacion."' and IdPrograma='".$idprograma ."' and Folio='".$folio."'";
   //echo $sql;
	$rc= $Vivienda -> query($sql);
    if($f = $rc -> fetch_array()){
        return $f['PGtsAdmon'];
    }else{
        return '0';
    }
}

 /*Esta funcion nos ayuda a obtener el  OtroCargo de  DatosEvaluacion*/
 function  OtroCargoDatosEvaluacion($iddelegacion,$idprograma,$folio){
	require("config.php");	
	$sql="Select OtroCargo  from datosevaluacion where  IdDelegacion='".$iddelegacion."' and IdPrograma='".$idprograma ."' and Folio='".$folio."'";
   //echo $sql;
	$rc= $Vivienda -> query($sql);
    if($f = $rc -> fetch_array()){
        return $f['OtroCargo'];
    }else{
        return '0';
    }
}

 /*Esta funcion nos ayuda a obtener el  TasaAnualFin de  DatosEvaluacion*/
 function  TasaAnualFinDatosEvaluacion($iddelegacion,$idprograma,$folio){
	require("config.php");	
	$sql="Select TasaAnualFin  from datosevaluacion where  IdDelegacion='".$iddelegacion."' and IdPrograma='".$idprograma ."' and Folio='".$folio."'";
   //echo $sql;
	$rc= $Vivienda -> query($sql);
    if($f = $rc -> fetch_array()){
        return $f['TasaAnualFin'];
    }else{
        return '0';
    }
}

 /*Esta funcion nos ayuda a obtener el  TasaIntMora de  DatosEvaluacion*/
 function  TasaIntMoraDatosEvaluacion($iddelegacion,$idprograma,$folio){
	require("config.php");	
	$sql="Select TasaIntMora  from datosevaluacion where  IdDelegacion='".$iddelegacion."' and IdPrograma='".$idprograma ."' and Folio='".$folio."'";
   //echo $sql;
	$rc= $Vivienda -> query($sql);
    if($f = $rc -> fetch_array()){
        return $f['TasaIntMora'];
    }else{
        return '0';
    }
}

/*Esta funcion nos ayuda a obtener el  DiasGracia de  DatosEvaluacion*/
function  DiasdeGraciaDatosEvaluacion($iddelegacion,$idprograma,$folio){
	require("config.php");	
	$sql="Select DiasdeGracia  from datosevaluacion where  IdDelegacion='".$iddelegacion."' and IdPrograma='".$idprograma ."' and Folio='".$folio."'";
   //echo $sql;
	$rc= $Vivienda -> query($sql);
    if($f = $rc -> fetch_array()){
        return $f['DiasdeGracia'];
    }else{
        return '0';
    }
}


/*Esta funcion nos ayuda a obtener el  Ministracion1 de  DatosEvaluacion*/
function  Ministracion1DatosEvaluacion($iddelegacion,$idprograma,$folio){
	require("config.php");	
	$sql="Select Ministracion1  from datosevaluacion where  IdDelegacion='".$iddelegacion."' and IdPrograma='".$idprograma ."' and Folio='".$folio."'";
   //echo $sql;
	$rc= $Vivienda -> query($sql);
    if($f = $rc -> fetch_array()){
        return $f['Ministracion1'];
    }else{
        return '0';
    }
}

/*Esta funcion nos ayuda a obtener el  Ministracion2 de  DatosEvaluacion*/
function  Ministracion2DatosEvaluacion($iddelegacion,$idprograma,$folio){
	require("config.php");	
	$sql="Select Ministracion2  from datosevaluacion where  IdDelegacion='".$iddelegacion."' and IdPrograma='".$idprograma ."' and Folio='".$folio."'";
   //echo $sql;
	$rc= $Vivienda -> query($sql);
    if($f = $rc -> fetch_array()){
        return $f['Ministracion2'];
    }else{
        return '0';
    }
}
/*Esta funcion nos ayuda a obtener el  Ministracion2 de  DatosEvaluacion*/
function  Ministracion3DatosEvaluacion($iddelegacion,$idprograma,$folio){
	require("config.php");	
	$sql="Select Ministracion3  from datosevaluacion where  IdDelegacion='".$iddelegacion."' and IdPrograma='".$idprograma ."' and Folio='".$folio."'";
   //echo $sql;
	$rc= $Vivienda -> query($sql);
    if($f = $rc -> fetch_array()){
        return $f['Ministracion3'];
    }else{
        return '0';
    }
}

/*Esta funcion nos ayuda a obtener el  Ministracion2 de  DatosEvaluacion*/
function  IdConceptoCargoDatosEvaluacion($iddelegacion,$idprograma,$folio){
	require("config.php");	
	$sql="Select IdConceptoCargo  from datosevaluacion where  IdDelegacion='".$iddelegacion."' and IdPrograma='".$idprograma ."' and Folio='".$folio."'";
   //echo $sql;
	$rc= $Vivienda -> query($sql);
    if($f = $rc -> fetch_array()){
        return $f['IdConceptoCargo'];
    }else{
        return '0';
    }
}

/*Funcion que permite obtener el Vale de un Programa*/
function  TipoImpVale($idprograma){
	require("config.php");	
	$sql="Select TipoImpVale  from programa where   IdPrograma='".$idprograma."'";
   //echo $sql;
	$rc= $Vivienda -> query($sql);
    if($f = $rc -> fetch_array()){
        return $f['TipoImpVale'];
    }else{
        return FALSE;
    }
}


function  cambiaCreditoPorSolucion($NumContrato)
{
	require("config.php");
    $sql="update historicopagos set tipomov=112 where tipomov=1  and  numcontrato='" .$NumContrato. "'";
	echo  $sql;
		if ($Vivienda->query($sql) == TRUE){   
			$res = 'TRUE';
		}
		else
		{
			echo  "Ocurrio un error al querer actualizar el tipo movimiento en historicoPagos";
		}
}
    



function RegistraMontoExento($NumContrato, $MontoExento) 
{  
	require("config.php");
	
		$sql="Update historicopagos set saldoexento='". $MontoExento."' where  numcontrato='" .$NumContrato. "'";
	
		if ($Vivienda->query($sql) == TRUE){   
			$res = 'TRUE';
		}
		else
		{
			echo  "Ocurrio un error al querer actualizar el saldoexento en historicoPagos";
		}
}

function AcomodaSaldoAhorros($NumContrato,$MontoCredito, $MontoExento) 
{  
	require("config.php");
	
	 $saldo = $MontoCredito - $MontoExento;
		$sql="select * from  historicopagos where  numcontrato='" .$NumContrato. "'  and nummov>1 order by nummov";;
	
		$rc= $Vivienda -> query($sql);
		$row_cnt = $rc->num_rows;		
			if($row_cnt>0)
			{
			  	while($f = $rc -> fetch_array())
			  	{	

				$sql="select capitalperiodocubierto as pagos from historicopagos where cancelado=0 and numcontrato='" .$NumContrato ."' and nummov= ".$f['NumMov'] ;
				//echo $sql;
					$rc= $Vivienda -> query($sql);
					if($f2 = $rc -> fetch_array())
					{
					
						$saldo = $saldo - $f2['pagos'];
						//$f['SaldoCapitalCorriente'] = $saldo;
						$sql="Update historicopagos set SaldoCapitalCorriente='". $saldo."' where  numcontrato='" .$NumContrato."' and nummov= ".$f['NumMov'] ;
						if ($Vivienda->query($sql) == TRUE){   
							$res = 'TRUE';
						}
						else
						{
							echo  "Ocurrio un error al querer actualizar el movimiento=".$f['NumMov']."en historicoPagos";
						}
					}else{
						return FALSE;
					}
			  	}

				  
			}
}

Function RevisaMontoSubsidios($IdDelegacion,$IdPrograma,$Folio)
{
	require("config.php");
	$sql = "select ifnull( sum(monto),0) as totalSub from EvaluacionPorConceptos where cancelado=0 and  IdTipoMov in (7,9,26,31,32,55,60) 
	and iddelegacion=".$IdDelegacion. " and idprograma= " .$IdPrograma. " and folio=" .$Folio;
	//echo $sql;
		$rc= $Vivienda -> query($sql);
		if($f = $rc -> fetch_array()){
			return $f['totalSub'];
		}else{
			return 'FALSE';
		}

}


function InsertaMovimientoExento($NumContrato,$vMontoEnOperacion,$vTipoMovimiento,$vObservacion, $vSaldoCapCor,$vMontoExento, $nitavu,$IdDelegacion, $IdPrograma,$Folio)
{
	require("config.php");
       //select from pagos
	   $sql = "select ifnull(max(nummov),0) as maximo from historicopagos where numcontrato='" .$NumContrato. "'";
	   $rc= $Vivienda -> query($sql);
	   if($f = $rc -> fetch_array()){
		  $maximomovimiento= $f['maximo'];
	   }else{
		$maximomovimiento= '0';
	   }
	 
	  echo  '<br>'.$maximomovimiento.'<br>';

	      //select from pagos
		  $sql11 = "SELECT * from historicopagos WHERE (NumContrato = '" .$NumContrato. "')  AND (NumMov = " .$maximomovimiento. ") LIMIT 1";
		  //echo $sql11.'<br>';
		  $r = $Vivienda -> query($sql11); 
	     $r_count = $r -> num_rows;
		  if($r_count>0){
			  while($ff = $r -> fetch_array()){				
				$numero=intval($maximomovimiento)+1;				
				 $sql2 = "CALL registrarHistoricoPagos('".$NumContrato."' ,'".$numero."' ,'".$vMontoEnOperacion."','".$ff['FechaOperacion']."' ,'".$ff['FechaCorte']."' ,'".$ff['FechaInicia']."' ,'".$ff['FechaTermina'].
				 "','".$ff['NuevoRezGts']."','".$ff['RezGtsCubierto']."',0,0,'".$ff['NuevoRezGts']."', ".$ff['NuevoRezSeg'].",'".$ff['RezSegCubierto']."',0,'".$ff['SegPeriodoCubierto'].
				 "','".$ff['NuevoRezSeg']."','". $ff['NuevoRezOtrosGts']."','". $ff['RezOtrosGtsCubierto']."',0,'". $ff['OtrosGtsPeriodoCubierto']."','".$ff['NuevoRezOtrosGts']."','".$ff['NuevoRezMoratorios'].
				 "','".$ff['RezMoratoriosCubierto']."',0,'".$ff['NuevoRezMoratorios']."','".$ff['NuevoRezFinanc']."','".$ff['RezFinancCubierto']."',0,'". $ff['FinancPeriodoCubierto'].
				 "','".$ff['NuevoRezFinanc']."','".$ff['NuevoRezCapital']."','".$ff['RezCapitalCubierto']."',0,0,0,0, '".$vSaldoCapCor.
				 "','".$ff['Origen']."' ,".$vTipoMovimiento.",'".$vObservacion."' ,1 ,'".$nitavu."','".$ff['IdEmpModifica'].
				 "','".$ff['FechaCaptura'] ."',0,'".$ff['FechaEnvio']."','".$vMontoExento."','".$ff['ImpSF002']."','".$ff['FechaImpSF002'].
				 "','".$ff['FechaReimSF002']."','".$ff['ReferenciaOpd']."','".$ff['RefBancariaOpd']."','".$ff['IdMovDesc']."','".$ff['Observacion2'].
				 "','".$ff['IdFormaPago']."',".$ff['IdSupervisor'].",'".$IdDelegacion."',0 ,".$ff['NumMovErroneo']." ,'".$IdDelegacion."')";					
				 if ($Vivienda->query($sql2) == TRUE){
				    //echo 'Registro HistoricoPago pago exento<br>';				                                         
				}
				else // ERROR AL AL INSERTAR EN HISTORICO PAGOS
				{
					$montoautorizadoantes=MontoAutorizadoMetas($IdDelegacion,$IdPrograma);
					$sqlDelete10="CALL sp_EliminarRegistrosContratoMetasHp('$NumContrato', '$IdDelegacion', '$IdPrograma','$Folio','$nitavu','$montoautorizadoantes')";
					//echo $sqlDelete10;
					if ($Vivienda->query($sqlDelete10) == TRUE){
						historia($nitavu, 'Se elimino con éxito el contrato y demas tablas por que ocurrio un error al momento de  insertar el movimiento exento en historicopagos');
					}else{
						historia($nitavu, 'ERROR: Al eliminar el registros del contrato por que ocurrio un error al momento de  insertar el movimiento exento en historicopagos');
					}
					mensaje('ERROR: Al insertar el movimiento exento en historicopagos.','contratarCredito.php?_folio='.$Folio.'&programa='.$IdPrograma.'&delegaciones='.$IdDelegacion);
				return;    
				}
				
			  }
			  }


		
	}                    

	function InsertaMovimientoHP2($NumContrato,$vMontoEnOperacion,$vTipoMovimiento,$vObservacion, $vSaldoCapCor,$vMontoExento,$nitavu,$IdDelegacion, $IdPrograma,$Folio)
	{
	 require("config.php");
		   //select from pagos
		   $sql = "select ifnull(max(nummov),0) as maximo from historicopagos where numcontrato='" .$NumContrato. "'";
		   $rc= $Vivienda -> query($sql);
		   if($f = $rc -> fetch_array()){
			  $maximomovimiento= $f['maximo'];
		   }else{
			$maximomovimiento= '0';
		   }
	
		   $numero=0;
			  //select from pagos
			  $sql11 = "SELECT * from historicopagos WHERE (NumContrato = '" .$NumContrato. "')  AND (NumMov = " .$maximomovimiento. ") LIMIT 1";
			  //echo $sql11.'<br>';
			  $r = $Vivienda -> query($sql11); 
			  $r_count = $r -> num_rows;
			  if($r_count>0){
				  while($ff = $r -> fetch_array()){
	
					$numero=intval($maximomovimiento)+1;
	
					 $sql2 = " CALL registrarHistoricoPagos('".$NumContrato."' ,'".$numero."' ,'".$vMontoEnOperacion."','".$ff['FechaOperacion']."' ,'".$ff['FechaCorte']."' ,'".$ff['FechaInicia']."' ,'".$ff['FechaTermina'].
					 "','".$ff['NuevoRezGts']."','".$ff['RezGtsCubierto']."',0,0,'".$ff['NuevoRezGts']."', '".$ff['NuevoRezSeg']."','".$ff['RezSegCubierto']."',0,'".$ff['SegPeriodoCubierto'].
					 "','".$ff['NuevoRezSeg']."','". $ff['NuevoRezOtrosGts']."','". $ff['RezOtrosGtsCubierto']."',0,'". $ff['OtrosGtsPeriodoCubierto']."','".$ff['NuevoRezOtrosGts']."','".$ff['NuevoRezMoratorios'].
					 "','".$ff['RezMoratoriosCubierto']."',0,'".$ff['NuevoRezMoratorios']."','".$ff['NuevoRezFinanc']."','".$ff['RezFinancCubierto']."',0,'". $ff['FinancPeriodoCubierto'].
					 "','".$ff['NuevoRezFinanc']."','".$ff['NuevoRezCapital']."','".$ff['RezCapitalCubierto']."',0,'".$vMontoEnOperacion."',0,0, '".$vSaldoCapCor.
					 "','".$ff['Origen']."' ,'".$vTipoMovimiento."' ,'".$vObservacion."' ,1 ,'".$nitavu."','".$ff['IdEmpModifica'].
					 "','".$ff['FechaCaptura'] ."','".$ff['FechaUltimaMod']."','".$ff['FechaEnvio']."','".$vMontoExento."','".$ff['ImpSF002']."','".$ff['FechaImpSF002'].
					 "','".$ff['FechaReimSF002']."','".$ff['ReferenciaOpd']."','".$ff['RefBancariaOpd']."','".$ff['IdMovDesc']."','".$ff['Observacion2'].
					 "','".$ff['IdFormaPago']."','".$ff['IdSupervisor']."','".$IdDelegacion."',0 ,'".$ff['NumMovErroneo']."' ,'".$IdDelegacion."')";
					 echo $sql2.'<br>'; 
					 
					 if ($Vivienda->query($sql2) == TRUE){
					   echo 'Registro HistoricoPago Sql7<br>';
					                                   
					}
					else // ERROR AL INSERTAR EN HISTORICO PAGOS
					{
						$montoautorizadoantes=MontoAutorizadoMetas($IdDelegacion,$IdPrograma);
						$sqlDelete10="CALL sp_EliminarRegistrosContratoMetasHp('$NumContrato', '$IdDelegacion', '$IdPrograma','$Folio','$nitavu','$montoautorizadoantes')";
						//echo $sqlDelete10;
						if ($Vivienda->query($sqlDelete10) == TRUE){
							historia($nitavu, 'Se elimino con éxito el contrato y demas tablas por que ocurrio un error al momento de  insertar  en historicopagos');
						}else{
							historia($nitavu, 'ERROR: Al eliminar el registros del contrato por que ocurrio un error al momento de  insertar en historicopagos');
						}
						mensaje('ERROR: Al insertar en historicopagos. InsertaMovimientoHP2','contratarCredito.php?_folio='.$Folio.'&programa='.$IdPrograma.'&delegaciones='.$IdDelegacion);
					return;    
					} 
				
				  }
				}
	}  

// function CalularSaldo()
// {

// }

// function Busca_Factor($varIdTipoMoneda, $fecha ) 
// {
// 	if ($varIdTipoMoneda == 1 )
// 	///si el tipo de moneda es pesos
// 		$vpsFactorConversion = 1;
// 		$vpsIdFactor = 1;
// 		$Busca_Factor = True;
// 		}
// 	else
// 	{
// 		//si el tipo de moneda esta en VSM
//         // Set RstBuscaFactor = New ADODB.Recordset
//         // traeDatos "spBuscaFactoresConversion", True, RstBuscaFactor, adLockReadOnly, varIdTipoMoneda, CDate(Fecha)
//         // 'RstContrato.Open str, conConexion.conConnection, adOpenStatic, adLockOptimistic
//         if (RstBuscaFactor.RecordCount) > 0 Then
// 		{
//             vpsFactorConversion = RstBuscaFactor("FactorPeso")
//             vpsIdFactor = RstBuscaFactor!IdFactorPeso
//             Busca_Factor = True;
// 		}
//         else
// 		{
//            // MsgBox "El Factor de Conversión a Moneda no puede ser encontrado"
//             $Busca_Factor = False;
// 	    }
// 	}
// }


/*Función que nos ayuda a obtener el IdFechaBase a partir de un Numero de Contrato.  */
function IdFechaBaseContrato($NumContrato){
	require("config.php");
	
	$sql = "Select * from contratos where NumContrato='" .$NumContrato. "'";
   // echo $sql;
    $rc = $Vivienda -> query($sql);
	if($f = $rc -> fetch_array()){
        return $f['IdFechaBase'];
    }else{
        return 'FALSE';
    }
	
}

/*Función que nos ayuda a obtener el IdPrograma a partir de un Numero de Contrato.  */
function CantidadAnualContrato($NumContrato){
	require("config.php");
	
	$sql="SELECT tipopago.CantidadAnual  	from contratos INNER JOIN tipopago ON contratos.IdTipoPago = tipopago.IdTipoPago WHERE (((contratos.NumContrato)='".$NumContrato."'))";
    //echo $sql;
    $rc = $Vivienda -> query($sql);
	if($f = $rc -> fetch_array()){
        return $f['CantidadAnual'];
    }else{
        return 'FALSE';
    }
	
}

function SiguienteFecha2($fechavenant, $numcontrato)
{
	require("config.php");
// Dim Vencimiento   As String
// Dim NumMesesCompletos    As Integer
// Dim Sql_Busca As String
// Dim rst_LECTURA As ADODB.Recordset
$fechabase="";
$varidFechaBase=IdFechaBaseContrato($numcontrato);
$varPeriodosXAño= CantidadAnualContrato($numcontrato);
$fechaContrato=fechaEmisionContrato($numcontrato);
if($fechaContrato!="")
{
	
	//si ya contrato
	if($fechavenant!="")
	{
		$EsPrimerPago = "NO";
		//si ya existe una fecha de vencimiento previa
		switch ($varPeriodosXAño) {
			case 6: //pagos bimestrales
				//se agregan 2 meses a la fecha de vencimiento
                //Se verifica el dia
               if( substr($fechavenant,0, 2) == 15 )
				{
                    $vDiasdePago = "15";
					$SiguienteFecha2=  date("Y-m-d",strtotime($fechavenant."+ 1 month")); 
					$anio =date("Y",strtotime($SiguienteFecha2));	
					$mes =date("m",strtotime($SiguienteFecha2));				
					$SiguienteFecha2 = $anio."-".$mes."-".$vDiasdePago;	
					
			    }
                else
				{
                    $vDiasdePago = "30";                    
					$SiguienteFecha2=  date("Y-m-d",strtotime($fechavenant."+ 1 month"));					
					$anio =date("Y",strtotime($SiguienteFecha2));	
					$mes =date("m",strtotime($SiguienteFecha2));				
					$SiguienteFecha2 = $anio."-".$mes."-"."01";	
					$SiguienteFecha2 =date("Y-m-d",strtotime($SiguienteFecha2."- 1 days")); 
				}
				
                $varDiasXPeriodo = 60;
				break;
			case 12: //pagos mensuales
				//se agrega un mes a la fecha de vencimiento
                //Se verifica el dia
                if (substr($fechavenant,0, 2) == 15)
				{
                    $vDiasdePago = "15";
                    $SiguienteFecha2=  date("Y-m-d",strtotime($fechavenant."+ 1 month"));						
					$anio =date("Y",strtotime($SiguienteFecha2));	
					$mes =date("m",strtotime($SiguienteFecha2));
					$SiguienteFecha2 = $anio."-".$mes."-".$vDiasdePago;										
						
                  
				}
                else
				{
                    $vDiasdePago = "30";
                    $SiguienteFecha2=  date("Y-m-d",strtotime($fechavenant."+ 1 month"));				
					$anio =date("Y",strtotime($SiguienteFecha2));	
					$mes =date("m",strtotime($SiguienteFecha2));						
					$SiguienteFecha2 = $anio."-".$mes."-"."01";	
					$SiguienteFecha2 =date("Y-m-d",strtotime($SiguienteFecha2."- 1 days")); 
                }
                $varDiasXPeriodo = 30;
				break;
			case 24: //pagos quincenales
				if (substr($fechavenant,0, 2)== 15)
				{					
                    //siguiente pago es en dia ultimo
					$vDiasdePago="30";
					$SiguienteFecha2=  date("Y-m-d",strtotime($fechavenant."+ 1 month"));					
					$anio =date("Y",strtotime($SiguienteFecha2));	
					$mes =date("m",strtotime($SiguienteFecha2));
					$SiguienteFecha2 = $anio."-".$mes."-"."01";					
					$SiguienteFecha2 =date("Y-m-d",strtotime($SiguienteFecha2."- 1 days")); 
				
				}
                else
				{
                    //siguiente pago es en dia 15
					$vDiasdePago="15";
                    $SiguienteFecha2=  date("Y-m-d",strtotime($fechavenant."+ 1 month"));				
					$anio =date("Y",strtotime($SiguienteFecha2));	
					$mes =date("m",strtotime($SiguienteFecha2));
					$SiguienteFecha2 = $anio."-".$mes."-".$vDiasdePago;									
					
			    }
                $varDiasXPeriodo = 15;
				break;
			case 52: //pagos semanales
                $SiguienteFecha2 = date('Y-m-d', strtotime($fechavenant."+1 week"));
                $varDiasXPeriodo = 7;
				
		}
	}
	else
	{
		$EsPrimerPago = "SI";
		//si aun no existe una primer fecha de vencimiento
        //se determina de donde obtener la fecha base

		$sql11 = "Select nombretabla, nombrecampo from fecharefprimpago where idfechabase = " . $varidFechaBase;
		//echo $sql11.'<br>';
		$r = $Vivienda -> query($sql11); 
		$r_count = $r -> num_rows;
		if($r_count>0){
			while($f= $r -> fetch_array()){
				$fechabase = "";
				$sql12 = "Select " .$f['nombrecampo'] . "as FechaBase from  " .$f['nombretabla']  ." where cancelado<>1 and numcontrato = '" . $numcontrato . "'"
				/ $rc= $Vivienda -> query($sql12);
				if($f = $rc -> fetch_array()){
				   $$fechabase= $f['FechaBase'];
				}else{
				 $fechabase= "";
				}        

			}
		}

		if($fechabase != "" )
		{
			//la fecha base es valida
			//se determina si los dias de pago son 15 o 30
		
			if ($varDiasdePago == "15" )
			{
				//la primer fecha de vencimiento puede ser 15 o 30
				if (substr($fechavenant,0, 2)== 15)
				{
					//si la contratacion fue entre el 16 y el 30
						$vDiasdePago = "15";
						$SiguienteFecha2=  date("Y-m-d",strtotime($fechavenant."+ 1 month"));
					    $anio =date("Y",strtotime($SiguienteFecha2));	
						$mes =date("m",strtotime($SiguienteFecha2));							
						$SiguienteFecha2 = $anio."-".$mes."-".$vDiasdePago;		
						
						
				}else //'si la contratacion fue entre el 1 y el 15
				{
					$vDiasdePago = "30";
					$SiguienteFecha2=  date("Y-m-d",strtotime($fechavenant."+ 1 month")); 
					$anio =date("Y",strtotime($SiguienteFecha2));	
					$mes =date("m",strtotime($SiguienteFecha2));										
					$SiguienteFecha2 = $anio."-".$mes."-"."01";	
					$SiguienteFecha2 =date("Y-m-d",strtotime($SiguienteFecha2."- 1 days")); 
				}
			}else
			{   //la primer fecha de vencimiento solo puede ser dia ultimo
				$vDiasdePago = "30";
				$SiguienteFecha2=  date("Y-m-d",strtotime($fechavenant."+ 2 month")); 
				$anio =date("Y",strtotime($SiguienteFecha2));	
				$mes =date("m",strtotime($SiguienteFecha2));									
				$SiguienteFecha2 = $anio."-".$mes."-"."01";	
				$SiguienteFecha2 =date("Y-m-d",strtotime($SiguienteFecha2."- 1 days")); 
			}


			//se determina el numero de dias del periodo
			if ($varPeriodosXAño == 6 )
			{
				//son pagos bimestrales
				$varDiasXPeriodo = 60;
			}
			else
			{
			
				if ($varPeriodosXAño == 12) 
					//son pagos mensuales
					$varDiasXPeriodo = 30;
				else
				{
					if ($varPeriodosXAño == 52 )
					{
						//son pagos semanales
						$varDiasXPeriodo = 7;
					}
					else{
						//son pagos quincenales
						$varDiasXPeriodo = 15;
					}
				}
				
			}
	}
	else
	{
		//la fecha base no es valida
		$vEstatusCuenta = "SIN FECHA DE VENCIMIENTO VALIDA";
		$SiguienteFecha2 = $vFechaCon;
	}
	//se determina el numero de dias del periodo
	
	}
	
}
else{
	//si no ha contratado aun
	$SiguienteFecha2 = $vFechaCon;
}

return $SiguienteFecha2;
}



function FechaVencimientoContrato($NumContrato){
	require("config.php");
	
	$sql="select  max(FechaOperacion) as FechaVencimiento  from historicopagos inner join descripcionmovimiento on descripcionmovimiento.idTipoMov=historicopagos.TipoMov
	inner join cat_tipo_movimiento on DescripcionMovimiento.id_tipo_movimiento=cat_tipo_movimiento.id_tipo_movimiento
	where cat_tipo_movimiento.id_tipo_movimiento=1 and NumContrato=".$NumContrato."";
   // echo $sql;
    $rc = $Vivienda -> query($sql);
	if($f = $rc -> fetch_array()){
        return $f['FechaVencimiento'];
    }else{
        return 'FALSE';
    }
	
}

/*Funcion que permite obtener el Vale de un Programa*/
function  FechaMinistracion($NumContrato){
	require("config.php");	
	$sql="Select FechaMin1  from contratos where   NumContrato='".$NumContrato."'";
   //echo $sql;
	$rc= $Vivienda -> query($sql);
    if($f = $rc -> fetch_array()){
        return $f['FechaMin1'];
    }else{
        return FALSE;
    }
}
Function MontoAutorizadoMetas($IdDelegacion,$IdPrograma)
{
	require("config.php");
	$sql = "select  * from  metas where  IdDelegacion=".$IdDelegacion. " and IdPrograma= " .$IdPrograma;
	///echo $sql;
		$rc= $Vivienda -> query($sql);
		if($f = $rc -> fetch_array()){
			return $f['MontoAutorizado'];
		}else{
			return 'FALSE';
		}

}

function IdPlantilla($nombrePlantilla){
	require("config.php");
	$sql= 'SELECT * FROM cat_plantillas WHERE Archivo = "'.$nombrePlantilla.'"';
	//echo $sql;
	$r = $Vivienda -> query($sql);
	while($f = $r -> fetch_array()){
		return $f['IdPlantilla'];
	}  

	}

function nombrePlantilla($idlote){
	require("config.php");
	$sql= 'SELECT * FROM lotes WHERE idLote='.$idlote;
	//echo $sql;
	$r = $Vivienda -> query($sql);
	while($f = $r -> fetch_array()){
		return $f['ContratoMaestro'];
	}  

}


function IdMunicipioAvalColonias($idcolonia){
	require("config.php");
	$sql= 'SELECT * FROM colonias WHERE IdColonia="'.$idcolonia.'"';
	//echo $sql;
	$r = $Vivienda -> query($sql);
	while($f = $r -> fetch_array()){
		return $f['IdMunicipio'];
	}  

}

function IdColoniaAvalContrato($numcontrato){
	require("config.php");
	$sql= 'SELECT * from contratos WHERE NumContrato="'.$numcontrato.'"';
	//echo $sql;
	$r = $Vivienda -> query($sql);
	while($f = $r -> fetch_array()){
		return $f['Aval_IdColonia'];
	}  

}

function ColoniaAvalColonias($idcolonia){
	require("config.php");
	$sql= 'SELECT * FROM colonias WHERE IdColonia="'.$idcolonia.'"';
	//echo $sql;
	$r = $Vivienda -> query($sql);
	while($f = $r -> fetch_array()){
		return $f['Colonia'];
	}  

}

function AvalContrato($numcontrato){
	require("config.php");
	$sql= 'SELECT * from contratos WHERE NumContrato="'.$numcontrato.'"';
	//echo $sql;
	$r = $Vivienda -> query($sql);
	while($f = $r -> fetch_array()){
		return $f['Aval'];
	}  
}

function AvalCalleyNum($numcontrato){
	require("config.php");
	$sql= 'SELECT * from contratos WHERE NumContrato="'.$numcontrato.'"';
	//echo $sql;
	$r = $Vivienda -> query($sql);
	while($f = $r -> fetch_array()){
		return $f['Aval_CalleyNum'];
	} 
}

function AvalDomTrabajo($numcontrato){
	require("config.php");
	$sql= 'SELECT * from contratos WHERE NumContrato="'.$numcontrato.'"';
	//echo $sql;
	$r = $Vivienda -> query($sql);
	while($f = $r -> fetch_array()){
		return $f['Aval_DomTrabajo'];
	}  

}

function AvalEntreCalle($numcontrato){
	require("config.php");
	$sql= 'SELECT * from contratos WHERE NumContrato="'.$numcontrato.'"';
	//echo $sql;
	$r = $Vivienda -> query($sql);
	while($f = $r -> fetch_array()){
		return $f['Aval_EntreCalle'];
	} 
}

function AvalLugTrabajo($numcontrato){
	require("config.php");
	$sql= 'SELECT * from contratos WHERE NumContrato="'.$numcontrato.'"';
	//echo $sql;
	$r = $Vivienda -> query($sql);
	while($f = $r -> fetch_array()){
		return $f['Aval_LugTrabajo'];
	} 
}

function AvalTelCasa($numcontrato){
	require("config.php");
	$sql= 'SELECT * from contratos WHERE NumContrato="'.$numcontrato.'"';
	//echo $sql;
	$r = $Vivienda -> query($sql);
	while($f = $r -> fetch_array()){
		return $f['Aval_TelCasa'];
	} 
}

function AvalTelTrabajo($numcontrato){
	require("config.php");
	$sql= 'SELECT * from contratos WHERE NumContrato="'.$numcontrato.'"';
	//echo $sql;
	$r = $Vivienda -> query($sql);
	while($f = $r -> fetch_array()){
		return $f['Aval_TelTrabajo'];
	} 
}

function Aval_YCalle($numcontrato){
	require("config.php");
	$sql= 'SELECT * from contratos WHERE NumContrato="'.$numcontrato.'"';
	//echo $sql;
	$r = $Vivienda -> query($sql);
	while($f = $r -> fetch_array()){
		return $f['Aval_YCalle'];
	} 
}

function postBlock($postID) {
	//session_start();
	if(isset($_SESSION['postID'])) {
		if ($postID == $_SESSION['postID']) {
			return false;
		} else {
			$_SESSION['postID'] = $postID;
			return true;
		}
	} else {
		$_SESSION['postID'] = $postID;
		return true;
	}
}


function TotalAFinanciar($numcontrato){
	require("config.php");
	$sql= 'SELECT * from contratos 
	WHERE NumContrato="'.$numcontrato.'"';
	//echo $sql;
	$r = $Vivienda -> query($sql);
	while($f = $r -> fetch_array()){
		$totalaFinanciar =$f['MontoCredito'] + $f['MontoEscrituracion'] + $f['GtsAdmon'] - ($f['SubsidioFonhapo'] + $f['SubsidioItavu']) - $f['MontoPagoInicial'];
		return $totalaFinanciar;
	} 
}

function buscarSiYaTieneContratoActivoOno($IdDelegacion, $IdPrograma, $Folio){
    require("config.php");
    $sql = 'SELECT NumContrato from contratos WHERE  IdDelegacion ='.$IdDelegacion.' and IdPrograma='.$IdPrograma.' and Folio='.$Folio.'';
    //echo $sql;
    $rc = $Vivienda -> query($sql);
    while($f = $rc -> fetch_array())
    {
        return $f['NumContrato'];
    }
}

function SolcitantesDatoActual($IdSolicitante, $Campo){
	require("config.php");	
	$sql = "select ".$Campo." from solicitantes WHERE IdSolicitante='".$IdSolicitante."'";
	//echo $sql;
	$rc= $Vivienda -> query($sql);
	if($f = $rc -> fetch_array())
		{				
			return $f[$Campo];
		}
	 else {return FALSE;}

}
function GuardarDatoSolicitantes($IdSolicitante, $Campo, $Dato,$nitavuMod ){	

	require("config.php");
	//Obtener el valor actual
	$DatoActual = SolcitantesDatoActual($IdSolicitante, $Campo );
	$sql = "UPDATE solicitantes SET	".$Campo." = UPPER('".$Dato."'), FechaUltimaMod=NOW(), IdEmpModifica='".$nitavuMod."' WHERE IdSolicitante = '".$IdSolicitante."'";
	 echo $sql; 
	// echo "<script> console.log('".$sql."');</script>";
	if ($Vivienda->query($sql) == TRUE){
		historia($nitavuMod,"solicitantes: Actualizo el Solicitante con Id " . $IdSolicitante." el campo ".$Campo." de ".$DatoActual." a <b> ".$Dato."</b>");
		return TRUE;	
	}
	else {
		return FALSE;
	}

}

function GuardarDatoDatosDomicilio($iddelegacion, $idprograma, $folio, $Campo, $Dato,$nitavuMod ){	

	require("config.php");
	//Obtener el valor actual
	//$DatoActual = SolcitantesDatoActual($IdSolicitante, $Campo );
	$sql = "UPDATE datosdomicilio SET	".$Campo." = UPPER('".$Dato."'), FechaUltimaMod=NOW(), IdEmpModifica='".$nitavuMod."'	WHERE IdDelegacion = ".$iddelegacion. " and IdPrograma=".$idprograma." and Folio='".$folio."'";	
	 echo $sql; 
	// echo "<script> console.log('".$sql."');</script>";
	if ($Vivienda->query($sql) == TRUE){
		historia($nitavuMod,"DatosDomiclio: Actualizo  la solicitud con IdDelegacion " . $iddelegacion." IdPrograma".$idprograma." Folio ".$folio."el campo ".$Campo. " a <b> ".$Dato."</b>");
		return TRUE;	
	}
	else {
		return FALSE;
	}

}

function GuardarDatoSolicitudes($iddelegacion, $idprograma, $folio, $Campo, $Dato,$nitavuMod ){	

	require("config.php");
	//Obtener el valor actual
	//$DatoActual = SolcitantesDatoActual($IdSolicitante, $Campo );
	$sql = "UPDATE solicitudes SET	".$Campo." = UPPER('".$Dato."'), FechaUltimaMod=NOW(), IdEmpModifica='".$nitavuMod."'	WHERE IdDelegacion = ".$iddelegacion. " and IdPrograma=".$idprograma." and Folio='".$folio."'";	
	 echo $sql; 
	// echo "<script> console.log('".$sql."');</script>";
	if ($Vivienda->query($sql) == TRUE){
		historia($nitavuMod,"solicitudes: Actualizo la solicitud con IdDelegacion " . $iddelegacion." IdPrograma".$idprograma." Folio ".$folio."el campo ".$Campo. " a <b> ".$Dato."</b>");
		return TRUE;	
	}
	else {
		return FALSE;
	}

}
function GuardarDatoEmpleo($iddelegacion, $idprograma, $folio, $Campo, $Dato,$nitavuMod ){	

	require("config.php");
	//Obtener el valor actual
	//$DatoActual = SolcitantesDatoActual($IdSolicitante, $Campo );
	$sql = "UPDATE datosempleosol SET	".$Campo." = UPPER('".$Dato."'), FechaUltimaMod=NOW(), IdEmpModifica='".$nitavuMod."'	WHERE IdDelegacion = ".$iddelegacion. " and IdPrograma=".$idprograma." and Folio='".$folio."'";	
	 echo $sql; 
	// echo "<script> console.log('".$sql."');</script>";
	if ($Vivienda->query($sql) == TRUE){
		historia($nitavuMod,"DatosEmpleoSol: Actualizo la solicitud con IdDelegacion " . $iddelegacion." IdPrograma".$idprograma." Folio ".$folio."el campo ".$Campo. " a <b> ".$Dato."</b>");
		return TRUE;	
	}
	else {
		return FALSE;
	}

}


function VEdoCuentaTablaDePagosAhorro( $iddelagacion,$idprograma,$folio){	
	require("config.php");	
	$t1='';
	$t1 = $t1.'<tr border="1" bgcolor="#484848" style="font-size:6.5pt;">
	<td align="center" style="width:25px; color:#ffffff; ">No.</td>
	<td align="left" style="width:50px; color:#ffffff; ">Empleado</td>
	<td align="left" style="width:108px; color:#ffffff; ">Fecha</td>
	<td align="left" style="width:70px; color:#ffffff; ">Núm.Recibo</td>
	<td align="center" style="width:70px; color:#ffffff; ">Importe</td>
	<td align="left" style="width:165px; color:#ffffff; ">Concepto</td>
	<td align="left" style="width:165px; color:#ffffff; ">Observaciones</td>
	</tr>
	';

	$sql7 = "
	 SELECT   
	pagos.NumPago, pagos.FolioRec, pagos.Fecha, pagos.Importe, pagos.Observaciones, 	
	(SELECT DescripcionMovimiento FROM descripcionmovimiento AS Dm WHERE idTipoMov = pagos.idTipoMov) AS Concepto,  pagos.folio, pagos.IdEmpCrea As Cajero
	FROM  
	pagos 
	Where pagos.Cancelado = 0
	And   pagos.IdDelegacion = ".$iddelagacion." And   pagos.IdPrograma = ".$idprograma." And   pagos.Folio = ".$folio." ORDER BY pagos.NumPago";



	$sql7_count = "

	SELECT   count(*) as n
	FROM  
	pagos 
	Where pagos.Cancelado = 0
	And   pagos.IdDelegacion = ".$iddelagacion." And   pagos.IdPrograma = ".$idprograma." And   pagos.Folio = ".$folio." ORDER BY pagos.NumPago";
	

$GranCargo = 0; $GranAbono=0; $styleERROR ="background-color:#FFCC99;"; $Calculo_Saldo = 0;
$c=0; $Registros = 0;
$rc= $Vivienda -> query($sql7_count); if($f = $rc -> fetch_array()){$Registros = $f['n'];}

$StringStrike=""; $StringStrike2="";
// if($ContratoCancelado==1){	$StringStrike = "<strike>"; $StringStrike2="</strike>";}

if ($Registros <= 0 ){
		$t1 = $t1.'<tr bgcolor="#ffffff" style="font-size:8pt;"><td colspan="8" align="center">Sin Movimientos....</td></tr>
		<tr bgcolor="#ffffff" style="font-size:8pt;"><td colspan="8" align="center"></td></tr>';
} else {
	//echo $sql7;
	$r1= $Vivienda -> query($sql7);
	while($value = $r1 -> fetch_array()) {
	

		$Muestro = TRUE;
		$styleTD='border:1px solid white;';
	
		$t1 = $t1.'<tr bgcolor="#BFBFBF" border="1" style="font-size:8pt; border:1px solid gray;1">';
			
		$t1 = $t1.'<td align="center" valign="center"  style="'.$styleTD.'"> '.$StringStrike.($c+1).$StringStrike2."</td>";
			$t1 = $t1.'<td  style="'.$styleTD.'">'.$value['Cajero']."</td>";
				
				$t1 = $t1.'<td style="'.$styleTD.'">'.$value['Fecha']."</td>";;	
				
				$t1 = $t1.'<td  style="'.$styleTD.'">'.$value['FolioRec']."</td>";					
				
				$t1 = $t1.'<td style="'.$styleTD.'">'.Pesos($value['Importe'])."</td>";				
				
				$t1 = $t1.'<td style="'.$styleTD.'">'.$value['Concepto']."</td>";					
			
				$t1 = $t1.'<td style="'.$styleTD.'">'.$value['Observaciones']."</td>";				
			
	

				// $t1 = $t1.'<td align = "right" style="'.$styleTD.'">';
				// 	if($value['Saldo']<>0){
				// 		$t1 = $t1.$StringStrike.Pesos($value['Saldo']).$StringStrike2;
				// 	}
				// $t1 = $t1."</td>";
			$t1 = $t1."</tr>";
			$GranAbono = $GranAbono + $value['Importe'];
	
	$c = $c + 1;
}


//color="white" bgcolor="#555555">
	$t1 = $t1.'<tr ><td></td><td></td><td></td><td></td><td></td>';
	$t1 = $t1.'<td align="right"><b>Total Abonado</b></td>
	<td align="right"><b>'.Pesos($GranAbono)."</b></td></tr>";
	


}



return $t1;
}

/**==========================**/  
/*Función que nos permite obtener el idmandante de un lote  */
function ObtenerSuperficeLotes($idlote){
	require("config.php");
	
	$sql = "Select superficie FROM lotes WHERE IdLote = " . $idlote;
	//echo $sql;
	$rc = $Vivienda -> query($sql);
	// while($f = $rc -> fetch_array())
	// {
	// return $f['superficie'];
	// }
	if($f = $rc -> fetch_array())
		{				
			return $f['superficie'];
		}
	 else {return '';}
}

function IdEstatusLote($idlote){
	require("config.php");
	
	$sql = "Select IdEstatus FROM lotes WHERE IdLote = " . $idlote;
//echo $sql;
	$rc = $Vivienda -> query($sql);
	while($f = $rc -> fetch_array())
	{
	return $f['IdEstatus'];
	}
	
}

function  SaldoDeUnContrato($numcontrato){
	require("config.php");
	
	$sql = "Select Saldo From vivienda_informacionfinanciera where NumContrato = '" . $numcontrato . "'";
	//echo $sql;
	$rc = $Vivienda -> query($sql);
	while($f = $rc -> fetch_array())
	{
	return $f['Saldo'];
	}
	
}

function CostoDeLaEscritura($idusodesuelo)
{require("config.php");
	$sql = "select IdUsoDeSuelo, Descripcion, Precio, Descuento from catalogodeusodesuelo Where IdUsoDeSuelo= ".$idusodesuelo."";
	//echo $sql;
	$rc = $Vivienda -> query($sql);
	 if ($rc -> num_rows >0) {
		while($f = $rc -> fetch_array())
		{
			return $f['Precio']."|".$f['Descuento']."|".$f['Descripcion'];
			
		}
		 
	}else{
		 return "0.00|0.00|0.00";
	}
	
}

function ExigirSaldoTerreno($idlote){
	require("config.php");	
	$sql = "SELECT* FROM lotes WHERE idlote='".$idlote."'";
	//echo $sql;
	$rc= $Vivienda -> query($sql);
	if($f = $rc -> fetch_array())
		{				
			return $f['ExigirSaldoTerreno'];
		}
	 else {return FALSE;}

}


function ExigirCostoEscritura($idlote){
	require("config.php");	
	$sql = "SELECT* FROM lotes WHERE idlote='".$idlote."'";
	//echo $sql;
	$rc= $Vivienda -> query($sql);
	if($f = $rc -> fetch_array())
		{				
			return $f['ExigirCostoEscritura'];
		}
	 else {return FALSE;}

}

function UsoDeSuelo($iduso){
	require("config.php");	
	$sql = "SELECT* FROM catalogodeusodesuelo WHERE IdUsoDeSuelo='".$iduso."'";
	//echo $sql;
	$rc= $Vivienda -> query($sql);
	if($f = $rc -> fetch_array())
		{				
			return $f['Descripcion'];
		}
	 else {return FALSE;}

}

function ObtenerVersionPlanoLotes($idlote){
	require("config.php");	
	$sql = "SELECT* FROM lotes WHERE idlote='".$idlote."'";
	//echo $sql;
	$rc= $Vivienda -> query($sql);
	if($f = $rc -> fetch_array())
		{				
			return $f['Version_Plano'];
		}
	 else {return FALSE;}

}


function ObtenerClaveCatastaral($idlote){
	require("config.php");	
	$sql = "SELECT* FROM lotes WHERE idlote='".$idlote."'";
	//echo $sql;
	$rc= $Vivienda -> query($sql);
	if($f = $rc -> fetch_array())
		{				
			return $f['CVE_CATASTRAL'];
		}
	 else {return FALSE;}

}

function NombreOficialColonia($idmunicipio, $idcolonia){
	require("config.php");	
	$sql = "select * from catcolonia where IdMunicipio=".$idmunicipio." and IdColonia= ".$idcolonia;
	//echo $sql;
	$rc= $Vivienda -> query($sql);
	if($f = $rc -> fetch_array())
		{				
			return $f['NOMBRE_OFICIAL'];
		}
	 else {return FALSE;}

}

function IdUsoDeSueloLote($idlote){
	require("config.php");
	
	$sql = "Select IdUsoDeSuelo FROM lotes WHERE  idlote='".$idlote."'";
//echo $sql;
	$rc = $Vivienda -> query($sql);
	while($f = $rc -> fetch_array())
	{
	return $f['IdUsoDeSuelo'];
	}
	
}

function CalculaMaximo($NomTabla , $NomCampo , $Condicion1, $Condicion2 , $Condicion3 )
 {
	require("config.php"); 
    $sql= " Select IFNULL(Max(".$NomCampo. "),0) As Maximo From " .$NomTabla. " Where 1 = 1";
    if (strlen($Condicion1) > 0) { $sql = $sql.$Condicion1;}
    if (strlen($Condicion2) > 0) { $sql = $sql.$Condicion2;}
    if (strlen($Condicion3) > 0) { $sql = $sql.$Condicion3;}
   //echo $sql;
    $rc= $Vivienda -> query($sql);
	if($f = $rc -> fetch_array())
	{
		$CalculaMaximo =  (int)$f['Maximo']+1;		
	}
    else{
        $CalculaMaximo = 1;		
	
    }
	return $CalculaMaximo;
}


//'se verifica si el saldo de la cuenta es negativo para aplicar (en caso de que proceda) las correcciones sobre los montos de los descuentos mas adelante
function VerificarSaldoNegativo($numcontrato){
	require("config.php");
	require("flor_funciones");
	$nummov=NumMov($NumContrato);
	$sql = "select * from historicopagos where numcontrato='".$numcontrato."' and NumMov='$nummov'";
	$correccion_saldo_negativo=0;
	$rc = $Vivienda -> query($sql);
	while($f = $rc -> fetch_array())
	{
	$saldo=  parseFloat($f['NuevoRezFinanc'])+parseFloat($f['NuevoRezCapital'])	+parseFloat($f['NuevoRezOtrosGts'])+parseFloat($f['NuevoRezGts'])+parseFloat($f['NuevoRezSeg'])+parseFloat($f['NuevoRezMoratorios'])	+parseFloat($f['Saldocapitalcorriente'])+parseFloat($f['SaldoExento']);

	if($saldo<0)
	{
		$correccion_saldo_negativo = parseFloat($f["NuevoRezFinanc"]) +parseFloat($f["NuevoRezCapital"]) +parseFloat($f["NuevoRezOtrosGts"]) + parseFloat($f["NuevoRezGts"]) + parseFloat($f["NuevoRezSeg"])+parseFloat(["NuevoRezMoratorios"]) + parseFloat(["Saldocapitalcorriente"])+ parseFloat(["SaldoExento"]);
	}else{
		$correccion_saldo_negativo=0;
	}

}
	
	return $correccion_saldo_negativo;
	
}
//--Indicadores
function obtenerAvance($IdActividad){
	require("config.php");
	$sql= 'SELECT * FROM actividades_indicadores  WHERE IdActividad='.$IdActividad;
	//echo $sql;
	$r = $conexion -> query($sql);
	while($f = $r -> fetch_array()){
		return $f['Avance'];
	}  

}

function obtenerAvanceDpto($IdActividad){
	require("config.php");
	$sql= 'SELECT * FROM actividades_dpto  WHERE IdActividad='.$IdActividad;
	//echo $sql;
	$r = $conexion -> query($sql);
	while($f = $r -> fetch_array()){
		return $f['Avance'];
	}  

}


function obtenerAvanceEmpleados($IdActividad){
	require("config.php");
	$sql= 'SELECT * FROM actividades_empleados  WHERE IdActividad='.$IdActividad;
	//echo $sql;
	$r = $conexion -> query($sql);
	while($f = $r -> fetch_array()){
		return $f['Avance'];
	}  

}
function RevisaEditaActividad($IdActividad){
	require("config.php");
	$sql= 'SELECT * FROM actividades_indicadores  WHERE IdActividad='.$IdActividad;
	//echo $sql;
	$r = $conexion -> query($sql);
	if($f = $r -> fetch_array())
	{
		$Prioridad =  $f['prioridad'];		
	}
    else{
        $Prioridad ="no" ;		
	
    }
	return $Prioridad;	


	

}

function ObtenerIdCid(){
	require("config.php");
	
	$sql = "Select  IdCi FROM ci order by IdCi desc limit 1";
//echo $sql;
	$rc = $conexion -> query($sql);
	while($f = $rc -> fetch_array())
	{
	return $f['IdCi'];
	}
	
}


function EstaDadoAltaUnRecorrido($id){
	require("config.php");
	$existe="si";
	$sql = "select count(*) as existe from viaticosrecorridos where idviatico='".$id."'";
	$r = $conexion -> query($sql);
	if($f = $r -> fetch_array())
	{
		if($f['existe']>0)
		{
			$existe= "si" ;
		}		else
		{
			$existe="no" ;
		}
	}
    else{
		$existe= "no" ;		
	
    }
	return $existe;
}

function EstaDadoAltaUnPresupuesto($id){
	require("config.php");
	$existe="si";
	$sql = "select count(*) as existe from viaticosadmin where iddireccion='".$id."' and año=YEAR(NOW())";
	//echo $sql;
	//echo "<script>".$sql."</script>";
	$r = $conexion -> query($sql);
	if($f = $r -> fetch_array())
	{
		if($f['existe']>0)
		{
			$existe= "si" ;
		}		else
		{
			$existe="no";	
		}
	}
    else{
		$existe= "no";	
	
    }
	return $existe;
}
function ExistePresupuestoViatico($id){
	require("config.php");
	$existe="si";
	$sql = "select montodisponible as montodisponible from viaticosadmin where iddireccion='".$id."' and año=YEAR(NOW())";
	//echo $sql;
	$r = $conexion -> query($sql);
	while($f = $r -> fetch_array()){
		return $f['montodisponible'];
	}  
}


function nomenclaturaDir($id){
	require("config.php");
	$existe="si";
	$sql = "select nomenclatura from cat_gerarquia where id='".$id."'";
	//echo $sql;
	$r = $conexion -> query($sql);
	while($f = $r -> fetch_array()){
		return $f['nomenclatura'];
	}  
}
function viaticos_GastosFull($IdViatico){
	require("config.php");
	
	$sql = "select count(*) as Valida from viaticosgastosfull WHERE IdViatico='".$IdViatico."'";	
	 //echo $sql;
	$r= $conexion -> query($sql);					
	if($f = $r -> fetch_array())
	{
		if ($f['Valida']==0){
			return FALSE;
		} else {
			return TRUE;
		}
	}  else {
        return  FALSE;
    }

}


function totalGastosFull($IdViatico)
{
	require("config.php");
	$sqlX = "select * from viaticosgastosfull_resumen where IdViatico='".$IdViatico."' 
	";
	//$c = 0;
	//echo $sqlX;
	$rX= $conexion -> query($sqlX);
	$Total = 0;
	//$txtResumen= "";
	while($fX = $rX -> fetch_array()) {

	// $txtResumen.='<b>'.$fX['Tipo'].'</b>: '.Pesos($fX['SubTotal']).'<br>';
		// $tablaviaticos.='</tr>';
		$Total = $Total + $fX['SubTotal'];
		//$c = $c + 1;
}
return  $Total;
}
function NextIdSeguimiento($IdViatico)
{
	require("config.php");
	$sqlX = "SELECT	IdSegViatico  FROM  viaticosseguimiento where IdViatico='".$IdViatico."' ORDER BY IdSegViatico DESC limit 1 ";
//echo $sqlX;
	$rX= $conexion -> query($sqlX);
	$IdSegViatico = 0;

	while($fX = $rX -> fetch_array()) {

		$IdSegViatico= $fX['IdSegViatico'];
	
}
	return  $IdSegViatico;
}

function BorrarExrensionAnterior($telefono_ext,$telefono)
{	

	require("config.php");
	$sql="UPDATE empleados SET telefono='', telefono_extension='' WHERE telefono='$telefono' and telefono_extension='$telefono_ext'";
	//echo $sql;
	if ($conexion->query($sql) == TRUE){
		
		return TRUE;	
	}
	else {
		return FALSE;
	}

}

function ExisteAbonoExtraMandante($idabono)
{

 require("config.php");
 $sql=" select * from mandantes_abonosext where idabono=".$idabono.""; 
 //Echo $sql;
 $rc = $conexion -> query($sql);	
 if ($rc->num_rows > 0) {
	 
	 while($f = $rc -> fetch_array())
			 {
				return "TRUE"; 
			 }
	 
 } else { 
	 return "FALSE"; 
 }
}
