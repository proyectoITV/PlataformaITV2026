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
			//  echo $sql;
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
			SELECT count(*) as cantidad,req_conceptos.Concepto FROM req_detallerequisicion INNER JOIN req_conceptos on req_detallerequisicion.IdConcepto=req_conceptos.IdConcepto  WHERE req_detallerequisicion.Cancelado=0 AND req_conceptos.Cancelado=0 and req_detallerequisicion.IdDepartamento=".$idDepartamento."  AND (req_detallerequisicion.IdRequisicion IS NULL or req_detallerequisicion.IdRequisicion=0) AND  req_conceptos.IdConcepto=".$idConcepto;
			$rc= $conexion -> query($sql);			
			$msg="";
			if($f = $rc -> fetch_array())
				{
					if ($f['cantidad']>0)
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
	SELECT * FROM Solicitantes WHERE IdSolicitante='".$id."'";
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
	$sql = "SELECT * FROM TramitesOpcionesRequisitos WHERE idOpcion='".$IdOpcion."'";
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
		$sql = "select * from TramitesEstadoDeCaptura WHERE IdTramite = ".$FolioTramite;				
		// echo $sql;
		$vacios =0;
		$llenos = 0;
		$porcentaje=0;
		$msg = "";
		$rc= $conexion -> query($sql);
		if($f = $rc -> fetch_array()){				
			$total = $f['RequisitosRequeridos'];
			$llenos = $f['RequisitosRequeridosLlenos'];					
			$porcentaje=(($llenos*100)/$total);
				// return $porcentaje;
			return number_format($porcentaje,0);;
		}else{
			return FALSE;
		}
		
	}
	function TramiteAcuse1Name($IdTipoTramite){	
		require("config.php");
			$sql = "select Acuse1 as Valor from TramitesTipo where IdTipoTramite='".$IdTipoTramite."'";	
		
			$rc= $conexion -> query($sql);
			if($f = $rc -> fetch_array())
				{				
					return $f['Valor'];
				}
			 else {return FALSE;}
	}
	function TramiteEdoCivil($id){	
		require("config.php");
			$sql = "select Dato as Valor from TramitesInformacion where IdTramite='".$id."' AND IdRequisito=36";	//4 = Sexo
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
			$sql = "select NitavuCaptura as Valor from Tramites where IdTramite='".$id."'";	
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
		$sql = "select count(*) as Valor from TramitesInformacion where IdRequisito=0 and IdTramite=".$idTramite." and Dato='".$dato."'";	
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
	SELECT max(IdColonia) as IdColonia FROM CatColonia where IdMunicipio=$idmunicipio" ;
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
	$sql = "select ".$Campo." from CatColonia WHERE IdMunicipio=".$IdMunicipio." and IdColonia=".$IdColonia." and Cancelado=0";
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
	$sql = "UPDATE CatColonia SET	".$Campo." = '".$Dato."', FechaUltimaMod=NOW(), IdEmpModifica='".$nitavuMod."'	WHERE IdMunicipio = ".$IdMunicipio ." and IdColonia=".$IdColonia." and Cancelado=0";
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
	$sql = "select * from CatColonia where IdMunicipio=".$idmunicipio." and IdColonia= ".$idcolonia;
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
		
			
			$sql = "SELECT * FROM CatColonia WHERE IdMunicipio=".$idmunicipio." and IdColonia= ".$idcolonia." 		
			and LENGTH(Colonia)  >=2 and LENGTH(Colonia) >=3
			and LENGTH(NOMBRE_OFICIAL)  >=2 and LENGTH(NOMBRE_OFICIAL) >=3
			and IdTipoAdquisicionCol  >0 ";
			
		
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
	$sql = "select ".$Campo." from CatColonia WHERE IdMunicipio = ".$IdMunicipio ." and IdColonia=".$IdColonia." and Cancelado=0";
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
			else if(($Campo=='IdTipoAdquisicionCol') and ( $f[$Campo]==0))
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
	$sql = "select * from TipoAdquisicionCol where IdTipoAdquisicionCol=".$id;
	//echo $sql;
	$rc= $Vivienda -> query($sql);
	if($f = $rc -> fetch_array())
		{				
			return $f['TipoAdquisicionCol'];
		}
	 else {return FALSE;}

}

function IdentificacionLote($idTipoLote){
	require("config.php");	
	$sql="select * from CatTipoLote where IdTipoLote=".$idTipoLote;
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
	$sql = "select count(idLote) as Total from Lotes where IdMunicipio=".$idmun." and IdColonia=".$idcol;
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
	$sql = "select count(idLote) as Total from Lotes where IdMunicipio=".$idmun." and IdColonia=".$idcol ." and  IdEstatus=2";
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
	$sql = "select count(idLote) as Total from Lotes where IdMunicipio=".$idmun." and IdColonia=".$idcol ." and  IdEstatus not in(2,4,17,23)";
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
$sql = "select IdColonia from CatColonia where Colonia like '%".$dato."%' and IdMunicipio=".$m;	
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
	SELECT max(IdLote) as IdLote FROM Lotes" ;
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
	$sql = "select ".$Campo." from Lotes WHERE idLote=".$Idlote;
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
	$sql = "UPDATE Lotes SET	".$Campo." = '".$Dato."', FechaUltimaMod=NOW(), IdEmpModifica='".$nitavuMod."'	WHERE idLote = ".$Idlote;
	//echo $sql; 
	// echo "<script> console.log('".$sql."');</script>";
	if ($Vivienda->query($sql) == TRUE){
		historia($nitavuMod,"Lotes: Actualizo el lote con Id " . $Idlote." el campo ".$Campo." de ".$DatoActual." a <b> ".$Dato."</b>");
		return TRUE;	
	}
	else {
		return FALSE;
	}

}




function ValidarDatoActualLote($Idlote, $Campo){
	require("config.php");
		 if(trim($Campo) != 'IdColonia1' and  trim($Campo) != 'MontoFinanciar' ){
		
	$sql = "select ".$Campo." from Lotes WHERE idLote=".$Idlote;
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
		$sql = "select * from MUNICIPIOS where IdMunicipio=".$idmunicipio;
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
		$sql = "select * from CatEstatusLote where IdEstatus=".$idestatus;
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
				
				$sql = "SELECT * FROM Lotes WHERE idLote=".$idlote." 
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
			 
			$sql = "SELECT * FROM Lotes WHERE idLote=".$idlote."
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
			$r = $Vivienda -> query($sql); while($f = $r-> fetch_row())
			{//LISTAR COLUMNAS
	
				$tbCont = $tbCont."<tr>";        
				for ($i = 1; $i <= $cuantas_columnas; $i++) {      
					$tbCont = $tbCont."<td style='font-size:10pt;'>".$f[$i-1]."</td>";       
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

/********************************ESCRITURACION*********************************/

function IdDelegacionVivivienda($nombreDel){
	require("config.php");
	$var=explode("Delegación", $nombreDel);		
	$sql="Select IdDelegacion from DELEGACIONES where Delegacion like '" . trim($var[1]). "' and Delegacion not like '%PRES.%'";

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
	echo $sql;
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

function ObtenerQueCamposDeberiaEstarLlenos($paso){
	    require("config.php");
    $info = "";
    $sql = "select CampoMovEscrituras
	from esc_confseguimiento  where Orden!=0 and Orden<( Select Orden  from esc_confseguimiento where  CampoMovEscrituras='".$paso."' and orden is not null limit 1) and CampoMovEscrituras is not null ORDER BY Orden asc";
	//echo $sql;
	$r = $Vivienda -> query($sql);
	 while($f = $r -> fetch_array())
	 {
		$info = $info.$f['CampoMovEscrituras'].'=1 and ';
		
	}	


    return $info;
}






function TotalTramitesPendientes($iddireccion,$opcion){
	require("config.php");
		
	$paso = ObtenerPaso($iddireccion,$opcion);
	$llenos= ObtenerQueCamposDeberiaEstarLlenos($paso);	
	if($iddireccion==10)
	{$llenos=null;}

    if($llenos!=null){
        $sql="select count(*) as Total from Vivienda_TramitesDeEscritura where ".$paso. "=0 and ". $llenos. "Cancelado=0";

    }else{
        $sql="select count(*) as Total from Vivienda_TramitesDeEscritura where ".$paso. "=0 and Cancelado=0";
    }
    //echo $sql; 
    $rc= $Vivienda -> query($sql);
    if($f = $rc -> fetch_array()){
        return $f['Total'];
    }else{
        return 'FALSE';
    }
}

function TotalTramitesPorAprobarJuridico($iddireccion,$opcion){
	require("config.php");
		
	$paso = ObtenerPaso($iddireccion,$opcion);
    $llenos= ObtenerQueCamposDeberiaEstarLlenos($paso);


    if($llenos!=null){
        $sql="select count(*) as Total from Vivienda_TramitesDeEscritura where ".$paso. "=0 and ". $llenos. "Cancelado=0";

    }else{
        $sql="select count(*) as Total from Vivienda_TramitesDeEscritura where ".$paso. "=0 and Cancelado=0";
    }
        //echo $sql; 
    $rc= $Vivienda -> query($sql);
    if($f = $rc -> fetch_array()){
        return $f['Total'];
    }else{
        return 'FALSE';
	}
	}


function TotalTramitesDevueltos($iddireccion,$opcion){
	require("config.php");
		
	$paso = ObtenerPaso($iddireccion,$opcion);
    $llenos= ObtenerQueCamposDeberiaEstarLlenos($paso);   
    $sql="select count(*) as Total from Vivienda_TramitesDeEscritura where ".$paso. "=3 and Cancelado=0";
  
        //echo $sql; 
    $rc= $Vivienda -> query($sql);
    if($f = $rc -> fetch_array()){
        return $f['Total'];
    }else{
        return 'FALSE';
    }
}

function TotalTramitesPausa($iddireccion,$opcion){
	require("config.php");
		
	$paso = ObtenerPaso($iddireccion,$opcion);
    $llenos= ObtenerQueCamposDeberiaEstarLlenos($paso);   
    $sql="select count(*) as Total from Vivienda_TramitesDeEscritura where ".$paso. "=2 and Cancelado=0 ";
  
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
	  
    $sql=" select    NumEscritura	from    Vivienda_TramitesDeEscritura	WHERE NumContrato like '%".$numcontrato."%'";
  
    $rc= $Vivienda -> query($sql);
    if($f = $rc -> fetch_array()){
        return $f['NumEscritura'];
    }else{
        return 'FALSE';
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
			from    Vivienda_TramitesDeEscritura
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

	function ObtenerCampoMovEscrituras($direccion,$idaccion)
	{	
		require("config.php");
		$sql="select CampoMovEscrituras from esc_confseguimiento where idaccion=".$idaccion." and IdDireccion LIKE '%".$direccion."%'";
		//echo $sql; 
		$rc= $Vivienda -> query($sql);
		if($f = $rc -> fetch_array()){
			return $f['CampoMovEscrituras'];
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
	
		echo $sql;
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
		$sql = "select count(*) as Existe from MovEscrituras WHERE NumEscritura='".$numescritura."'";
		//echo $sql;
		$rc= $Vivienda -> query($sql);
		if($f = $rc -> fetch_array())
			{	
					
				if($f['Existe']>0)
				{
					//Si existe un trámite verificamos que este activo		
					$sql = "select count(*) As Activo from MovEscrituras WHERE NumEscritura='".$numescritura."' and Cancelado=0";
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
	$sql = "select IFNULL(IRPP, 0) as IRPP from MovEscrituras where NumEscritura='".$numescritura."' and  Cancelado=0";
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
					

					$sql="select IFNULL(".$campo.",'0') as valor from MovEscrituras where NumEscritura='".$numescritura."' and Cancelado=0";
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
		$sql="select IFNULL(".$paso.",'0') as valor from MovEscrituras where NumEscritura='".$numescritura."' and Cancelado=0";
		//echo $sql;
		$rc= $Vivienda -> query($sql);
		if($f = $rc -> fetch_array())
		{
			//SI EL VALOR ES 0 (PENDIENTE) VEMOS SI ES POSIBLE APROBARLO, ES DECIR CUMPLE CON LOS PARAMETROS PAR PODERSE APROBAR
			if($f['valor']=='0')
			{
				$sql="select count(*) as Total
				from  MovEscrituras where NumEscritura='".$numescritura."' and (IFNULL(".$paso. ",0)=0 or ".$paso. "=2) and ". substr($llenos,0,  strrpos($llenos, "and"));
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

		function ObetnerNotificacionSeguimiento($numescritura){
			require("config.php");	
			$sql = "select soporte_sustento from seguimiento where IdElemento='".$numescritura."' and IdAccion in (71,72,73,74) and  Estatus!='C' ORDER BY FechaOperacion DESC LIMIT 1";
			echo $sql;
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
			
			$sql="Update MovEscrituras set FechaUltimaMod=NOW(), enviar=1, 
			IdEmpModifica= '" .$nitavu. "' ,FechaDeCancelacion=NOW(), Cancelado=1, NumEmpCancelo= '" .$nitavu. "', MotivoDeCancelacion= '" .$observaciones. "', SecuenciaDeCancelacion=(select MAX(isnull(SecuenciaDeCancelacion,0))+1 from MovEscrituras where NumEscritura='" .$numescritura. "') , TipoCancelacion=".$tipoCancelacion. " where Cancelado=0 and NumEscritura= '" .$numescritura. "' ";
			echo $sql;
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
/*Esa funcion nos ayuda a obtener el monto de la mensualidad de una solicitud*/
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
/*Esa funcion nos ayuda a obtener tiempo de ahorro de una solicitud*/
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


/*Esa funcion nos ayuda a obtener el total de pagos de una solicitud*/
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

/* funcion que permite obtener la forma de pago apartir de su Id*/
function FormaDePago($idFormaPago){
	require("config.php");	
	$sql="Select * From CatFormaPago where IdFormaPago=".$idFormaPago;
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
	$sql="Select * From DescripcionMovimiento where idTipoMov=".$idtipo;
	//echo $sql;

	$rc= $Vivienda -> query($sql);
	if($f = $rc -> fetch_array()){
        return $f['DescripcionMovimiento'];
    }else{
        return 'FALSE';
    }
}


/*Esa funcion que gera el  recibo que se emitirá en caja*/
function formatoRecibo($iddelegacion,$idprograma,$folio,$numcontrato,$cantidad,$idformapago,$referencia,$fecharecibo,$nitavu,$folioRecibo,$numPago,$idtipopago,$notas,$codigoQR){
require_once('lib/flor_funciones.php');
require('config.php');
$IdSolicitante = buscarIdSolicitante($idprograma, $iddelegacion, $folio);
$res= '<br><br><table   style="width:100%" border=1>
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
				<td style="width:20%"><span>PROGRAMA:</span></td>
				<td style="width:80%"><span>'.nombreProgramaVivienda($idprograma).'</span></td> 				 		
				</tr>
				<tr>
				<td style="width:20%"><span>FOLIO:</span></td>
				<td style="width:80%"><span>'.$folio.'</span></td> 				 		
				</tr>';
				if($numcontrato !='')
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
							<tr>
								<th style="width:20%;"><b>N° PAGO</b></th>								
								<th style="width:60%;"><b>CONCEPTO</b></th>
								<th style="width:20%;"><b>IMPORTE</b></th>
								<th style="width:20%;"><b>TOTAL</b></th>
								
								</tr>				
							<tr>
								<td style="width:20%;"><span>'.$numPago.'</span></td>								
								<td style="width:60%;"><span>'.strtoupper( TipoPago_Concepto($idtipopago)).'</span></td>
								<td style="width:20%;"><span>$'.$cantidad.'</span></td>
								<td style="width:20%;"><span>$'.$cantidad.'</span></td>
								
							</tr>
							
							<tr>
								<td colspan="4"><b><br><br>IMPORTE CON LETRA:</b> '. strtoupper(numtoletras($cantidad)).'</td>	
							</tr>					
						</table>
					</div>
				</td>											 
			</tr>
			</table>
		</div></td>
		<td  style="width:40%; text-align:right;" border=1>
		<div>';				
		$res=$res.'<img  src="'.$codigoQR.'" />
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
	$sql = "select * from DELEGACIONES where IdDelegacion=".$iddelegacion;
	//echo $sql;
	$rc= $Vivienda -> query($sql);
	if($f = $rc -> fetch_array())
		{				
			return $f['Serie'];
		}
	 else {return FALSE;}

}

/*Esa funcion que gera el codigo QR del recibo*/
function GenerarQRrecibo($folioRecibo,$cantidad,$fecharecibo,$nitavu)
{
	include('phpqrcode/qrlib.php');		
		// Ingresamos el contenido de nuestro Código QR
		
		$contenido = $folioRecibo.' '.$cantidad.' '.date_format( date_create($fecharecibo), 'dmY').' '.$nitavu;			

		/*L = Baja
		M = Mediana
		Q = Alta
		H= Máxima*/
		
		$tamaño = 3; //Tamaño de Pixel
		$level = 'Q'; //Precisión Alta
		$framSize = 2; //Tamaño en blanco

		$codesDir = "tmp/CodigosQR/"; //Carpeta donde se almacenaran los QR  
		$codeFile = $contenido.date('d-m-Y-h-i-s').'.png';
		QRcode::png($contenido, $codesDir.$codeFile, $level,$tamaño,$framSize);
		return $codesDir.$codeFile;
}

	
/********************************CREDITO*********************************/

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
/*Esa funcion nos ayuda a obtener periodo de mora que tendrá el credito, este dato es obtenido de datos evaluacion*/
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
/*Esa funcion nos ayuda a obtener interes moratorio que tendrá el credito, este dato es obtenido de datos evaluacion*/
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
/*Esa funcion nos muestra agrupados y en una tabla los datos de ubicacion de un lote*/
function MuestraUbicacionLote($idlote,$style)
{
	require("config.php");
$sql = "SELECT * FROM Lotes where idLote=".$idlote;
//echo $sql;
$l = $Vivienda -> query($sql);
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
   return $res;

}

/*Esa funcion nos muestra agrupados y en una tabla las medidas y colindancias de un lote*/
function MuestraMedidaColindanciasLote($idlote,$style)
{
	require("config.php");
$sql = "SELECT * FROM Lotes where idLote=".$idlote;
$l = $Vivienda -> query($sql);
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
	$res=$res. "<td valign='middle' >";
	$res=$res. "<span class='tenue' >".$valor['colin1']."</span>";
	$res=$res. "</td>";
	$res=$res. "<td valign='middle' colspan='3'>";
	$res=$res. "<span class='tenue' >".$valor['con_quien1']."</span>";
	$res=$res. "</td>";
	$res=$res. "</tr>";  


	$res=$res. "<tr>";      
	$res=$res. "<td valign='middle'><span class='normal'>Colindancia 2:</span>";
	$res=$res. "<td valign='middle' >";
	$res=$res. "<span class='tenue' >".$valor['colin2']."</span>";
	$res=$res. "</td>";
	$res=$res. "<td valign='middle'  colspan='3'>";
	$res=$res. "<span class='tenue' >".$valor['con_quien2']."</span>";
	$res=$res. "</td>";
	$res=$res. "</tr>";  


	$res=$res. "<tr>";      
	$res=$res. "<td valign='middle'><span class='normal'>Colindancia 3:</span>";
	$res=$res. "<td valign='middle'  >";
	$res=$res. "<span class='tenue' >".$valor['colin3']."</span>";
	$res=$res. "</td>";
	$res=$res. "<td valign='middle'  colspan='3'>";
	$res=$res. "<span class='tenue' >".$valor['con_quien3']."</span>";
	$res=$res. "</td>";
	$res=$res. "</tr>";  


	$res=$res. "<tr>";      
	$res=$res. "<td valign='middle'><span class='normal'>Colindancia 4:</span>";
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
   return $res;
}		

function GuardarDatoEnDatosEvaluacion($iddelegacion,$idprograma,$folio, $Campo, $Dato,$nitavuMod ){	

	require("config.php");
	//Obtener el valor actual
	//$DatoActual = LotesDatoActual($Idlote, $Campo );
	$sql = "UPDATE datosevaluacion SET	".$Campo." = '".$Dato."', FechaUltimaMod=NOW(), IdEmpModifica='".$nitavuMod."'
		WHERE IdDelegacion = ".$iddelegacion. " and IdPrograma=".$idprograma." and Folio=".$folio;
	 echo $sql; 
	 //echo "<script> console.log('".$sql."');</script>";
	if ($Vivienda->query($sql) == TRUE){
		//historia($nitavuMod,"Lotes: Actualizo el lote con Id " . $Idlote." el campo ".$Campo." de ".$DatoActual." a <b> ".$Dato."</b>");
		return TRUE;	
	}
	else {
		return FALSE;
	}

}

/*EsTa funcion nos ayuda a conocer la descripcion de un TipoMoneda a partir del IdTipoMoneda*/
function TipoMoneda($idtipomoneda){
	require("config.php");	
	$sql="select * from TIPOMONEDA where  IdTipoMoneda=".$idtipomoneda;
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
	$sql="select * from TIPOPAGOINICIAL where  IdPagoInicial=".$idpagoinicial;
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
	$sql="select * from TIPOAPLICAGTSADMON where  IdTipoAplicaGtsAdmon=".$idtipoaplicagtsadmon;
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
	$sql="select * from TIPOPAGO where IdTipoPago=".$idtipopago;
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
		$sql="select * from CatTipoInteres  where IdTipoInteres=".$idtipointeres;
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
	$sql="select * from Vivienda_AhorroPrevio  where IdDelegacion = ".$iddelegacion. " and IdPrograma=".$idprograma." and Folio=".$folio;
	//echo $sql;
	$rc= $Vivienda -> query($sql);
    if($f = $rc -> fetch_array()){
        return $f['Abonado'];
    }else{
        return 'FALSE';
    }
}



	
	/* FUNCION QUE OBTIENE EL SUBSIDIO FEDERAL DE UN LOTE*/ 	
	function SubsidioFederalLotes($claveLote){
		require("config.php");
		$sql = 'SELECT SubsidioFederal FROM Lotes WHERE  idLote = '.$claveLote.'';
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
		$sql = 'SELECT SubsidioEstatal FROM Lotes WHERE  idLote = '.$claveLote.'';
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
		$sql = 'SELECT precio FROM Lotes WHERE  idLote = '.$claveLote.'';
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
		$sql = 'SELECT MontoCredito FROM Lotes WHERE  idLote = '.$claveLote.'';
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
		$sql = 'SELECT MontoCredito FROM contratos WHERE NumContrato = '.$numcontrato.'';
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
		$sql = 'SELECT MontoPagoInicial FROM Lotes WHERE  idLote = '.$claveLote.'';
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
		$sql = 'SELECT MontoPago FROM Lotes WHERE  idLote = '.$claveLote.'';
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
		$sql = 'SELECT MontoUltimoPago FROM Lotes WHERE  idLote = '.$claveLote.'';
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
		
		$sql ="SELECT MAX(FOLIOCONTRATO.FOLIO) AS MAXDEFOLIO 
		FROM FOLIOCONTRATO WHERE (((FOLIOCONTRATO.IDDELEGACION)=".$iddelegacion.") 
		AND ((FOLIOCONTRATO.IDPROGRAMA)=".$idprograma."))";
		//echo $sql;
		$rc = $Vivienda -> query($sql);
		while($f = $rc -> fetch_array())
		{
			return $f['MAXDEFOLIO'];
		}
	}


	/*FUNCION PARA INSERTAR EN LA TABLA FOLIOCONTRATO*/
	function InsertarEnFolioContrato($iddelegacion,$idprograma,$maxfolio,$nitavu){
	require("config.php");
	$sql="INSERT INTO FOLIOCONTRATO(IdDelegacion ,IdPrograma ,Enviar ,FechaCaptura,FechaEnvio ,FechaUltimaMod  ,Folio,IdEmpCrea ,IdEmpModifica)
	VALUES (".$iddelegacion.",".$idprograma .",1,NOW(), NULL, NULL,".$maxfolio.",".$nitavu.",NULL)";
	//echo $sql;
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
		$sql="UPDATE FOLIOCONTRATO SET Enviar=1,FechaUltimaMod=NOW(),Folio=".$maxfolio.",IdEmpModifica=".$nitavu."
		 WHERE IdPrograma=".$idprograma." and IdPrograma=".$idprograma;
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

	function ObtenerIdMunicipioDeDelegacion($iddelegacion)
	{	require("config.php");
		$sql="SELECT  MUNICIPIOS.IdMunicipio FROM MUNICIPIOS inner JOIN CATDELMUN ON MUNICIPIOS.IdMunicipio=CATDELMUN.IdMunicipio
		INNER JOIN DELEGACIONES ON CATDELMUN.IdDelegacion=DELEGACIONES.IdDelegacion
		WHERE  DELEGACIONES.Delegacion=MUNICIPIOS.MUNICIPIO  AND DELEGACIONES.IdDelegacion=".$iddelegacion;
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
		 //echo $folio;
		
		$folionvo=$folio+1;
		if($folio==0) /*IDENTIFICAMOS SI NO EXISTE UN FOLIO PARA ESE PROGRAMA SI NO EXISTE EL PRIMERO FOLIO SERÀ 1 Y SE INSERTARÀ  EL REGISTRO*/
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
	   $sql = "SELECT * FROM Lotes WHERE idLote=".$idlote." and Cancelado=0";   
	   //echo $sql;
	   $r = $Vivienda -> query($sql);         
	   if($f = $r -> fetch_array()){
		 
			if($f['IdEstatus']==2 and $f['contratado']==1)
			{
				return 'TRUE';
			}
			else
			{	
				$sql2 = "SELECT * FROM contratos WHERE IdLote=".$idlote." and Cancelado=0";
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
		$res='FALSE';
		
		$NumMov=1;
		
		$rc= $Vivienda -> query($sql);
		$row_cnt = $rc->num_rows;
			
			echo 'hhb'.$row_cnt ;
			if($row_cnt>0)
			{
			  while($f = $rc -> fetch_array())
			  {	

				$NumMov=$NumMov+1; 
				$sql2 = "CALL spInsertarPagosParciales('".$NumContrato."','".$f['Fecha']."','".$f['FechaCaptura']."',NULL,NULL,'".$f['Importe']."', '".$f['Importe']."','".
				$f['IdEmpCrea']."',".$IdDelegacion.",".$NumMov.",3,1,'PIC',0,NULL,'".$nitavu."',NULL,NULL,NULL,'".$f['FolioRec']."',0,NULL,NULL,NULL,NULL,NULL,".
				$IdDelegacion.",NULL,0,NULL,NULL);";
				
				if ($Vivienda->query($sql2) == TRUE){
					//echo $sql2;

					$sql3="UPDATE pagos SET Cancelado=1,FechaUltimaMod=NOW(),IdEmpModifica=".$nitavu." WHERE IdDelegacion=".$IdDelegacion." and IdPrograma=".$IdPrograma." and  Folio=".$Folio." AND FolioRec=".$f['FolioRec'];
					echo $sql3;
					if ($Vivienda->query($sql3) == TRUE)
					{	echo $sql3;
					
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

	/*
	function InsertarSubsidioEnPagosParciales($IdDelegacion,$IdPrograma,$Folio,$NumContrato)
    {
		
		
			$totaldesubsidios=1; //Hacer una consulta en programas para determinar si tiene subsidios.(Nuevas caracteristicas)
			$tipoSubsidio=1;    //Obetener el tipo de subdidio en caso de tener
			$montosubsidio=0;    //Obetener el monto de subdidio en caso de tener ya se de datosevaluacion o la tabla lotes


			//QUIEN DEBERIA GUARDARSE EN IDEMPCREA EN PAGOS PARCIALES. EL QUE TRAE PAGOS? O EL QUE ESTA CONTRTANDO
			//QUIEN DEBERIA GUARDARSE EN IDENTIFICADOR DE LA CAJERA DE EN PAGOS PARCIALES. EL QUE TRAE PAGOS? O EL QUE ESTA CONTRTANDO

			//VALUES  (VVP_NumContrato,VVP_FechaOperacion, VVP_FechaAplicacion,VVP_FechaCaptura,VVP_IdConceptoPago,  VVP_ImportePago,VVP_ImporteEnPesos,
			//VVP_IdentificadorCajera,VVP_idLugarOperacion,VVP_NumMov,VVP_IngresoVia,VVP_FactorConversion,VVP_Origen,VVP_Cancelado,VVP_Enviar,
			//VVP_IdEmpCrea,VVP_IdEmpModifica,VVP_FechaUltimaMod,VVP_FechaEnvio,VVP_foliorecibo,VVP_puntos_por_pago,
			//VVP_MotivoDeCancelacion,VVP_IdUsuarioCanceloRecibo,VVP_FechaCanceloRecibo,VVP_IdUsuarioSupervisor,VVP_FechaActuoSupervisor,
			/VVP_OrigenDeEnvio,VVP_FirmaDeAutenticacion,VVP_MuestraEnMandantes,VVP_NumMovErroneo,VVP_Observaciones	); 
			 
			//$NumMov=$NumMov+1; 
			if($totaldesubsidios>0)
			{
				$sql2 = "CALL spInsertarPagosParciales('".$NumContrato."',NOW(),NOW()',NULL,NULL,'".$montosubsidio."','".$montosubsidio."','".
				$nitavu."',".$IdDelegacion.",".$NumMov.",".$tipoSubsidio.",1,".$IdDelegacion.",0,NULL,'".$nitavu."',NULL,NULL,NULL,'".$f['FolioRec']."'0,NULL,NULL,NULL,NULL,NULL".
				$IdDelegacion."NULL,0,NULL,NULL)";
				echo $sql;
				if ($Vivienda->query($sql2) == TRUE){
					return 'TRUE';

				}else{
					return 'FALSE';
				}
			}

		


	} */




	/* FUNCION QUE OBTIENE SI ESTA CANCELADO UN CONTRATO(TABLA CONTRATOS)*/ 	
	function ObtenerContratoCancelado($numcontrato){
		require("config.php");
		$sql = 'SELECT Cancelado FROM contratos WHERE  NumContrato = '.$numcontrato.'';
		//echo $sql;
		$rc = $Vivienda -> query($sql);
		while($f = $rc -> fetch_array())
		{
			return $f['Cancelado'];
		}
	}

	/* FUNCION QUE OBTIENE SI EL ESTATUS CUENTA DE UN CONTRATO(TABLA CONTROLCONTRATOS)*/ 	
	function ObtenerEstatusCuenta($numcontrato){
		require("config.php");
		$sql = 'SELECT EstatusCuenta FROM ControlContratos WHERE  NumContrato = '.$numcontrato.'';
		//echo $sql;
		$rc = $Vivienda -> query($sql);
		while($f = $rc -> fetch_array())
		{
			return $f['EstatusCuenta'];
		}
	}

	function LibreParaAsignacion($idlote)
	{
		require("config.php");
	   $sql = "SELECT idestatus FROM Lotes WHERE idLote=".$idlote." and Cancelado=0";   
	   //echo $sql;
	   $r = $Vivienda -> query($sql);         
	   if($f = $r -> fetch_array()){
		 
			return $f['idestatus'];
		
		   
	   }
   }

   /**FUNCION QUE NOS PERMITE IDENTIFICAR SI EXISTE UN TRAMITE DE DEVOLUCION EN ESE TRMAITE */
   function ExisteTramiteDeDevolucionActivo($IdDelegacion,$IdPrograma,$Folio)
   {
  
	require("config.php");
    $sql="SELECT solicitudes.Cancelado, pagos.IdDelegacion, pagos.IdPrograma, pagos.Folio  
	FROM solicitudes INNER JOIN pagos ON solicitudes.IdDelegacion = pagos.IdDelegacion 
	AND solicitudes.IdPrograma = pagos.IdPrograma AND solicitudes.Folio = pagos.Folio 
	WHERE (pagos.IdDelegacion = " . $IdDelegacion. ") AND (pagos.IdPrograma = " . $IdPrograma. ") 
	AND (pagos.Folio = " . $Folio.") 
	AND (solicitudes.Cancelado = 1) OR  (pagos.IdDelegacion = " . $IdDelegacion. ") 
	AND (pagos.IdPrograma = ". $IdPrograma. ") AND (pagos.Folio = " . $Folio. ") 
	AND (pagos.NumPago = 99)";
	$rc = $Vivienda -> query($sql);	
	if ($rc->num_rows > 0) {
		
		while($f = $rc -> fetch_array())
				{
					return $f['Cancelado'];
				}
		
	} else { 
		return "FALSE"; 
	}
}




function RstTotalRegCredito($numcontrato)
{	
	require("config.php");
	$sql="select COUNT(*) AS TOTAL from HistoricoPagos where  tipomov in (1,35,37) and NumContrato ='".$numcontrato. "'"  ;
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
	$sql="select capitalperiodo from HistoricoPagos where  tipomov in (1,35,37) and NumContrato ='".$numcontrato. "'"  ;
	  // echo $sql;
	   $r = $Vivienda -> query($sql);         
	  
	  
		   while($f = $r -> fetch_array()){
			return $f['capitalperiodo'];	
		   }
	  
}
	
function RstTipomovCredito($numcontrato)
{	
	require("config.php");
	$sql="select tipomov from HistoricoPagos where  tipomov in (1,35,37) and NumContrato ='".$numcontrato. "'"  ;
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
	//echo $sql;
	$r = $conexion -> query($sql);         
	if($f = $r -> fetch_array()){
	  
		 return $f['n_archivo'];		
		
	}
}

//FUNCION PARA OBTENER EL ULTIMO CARGO ACTIVO DE UN CONTRATO
function obtenerUltimoCargoActivo ($numcontrato)
{
$sql="select hp.FechaOperacion,hp.TipoMov,dm.DescripcionMovimiento,
ctm.id_tipo_movimiento,ctm.DESC_MOVIMIENTO from HistoricoPagos as hp
inner join DescripcionMovimiento as dm on hp.TipoMov=dm.idTipoMov
inner join cat_tipo_movimiento ctm on ctm.id_tipo_movimiento= dm.id_tipo_movimiento
where NumContrato=".$numcontrato."'
and ctm.id_tipo_movimiento=1  and hp.Cancelado=0 order by  hp.FechaOperacion ,
hp.TipoMov,dm.DescripcionMovimiento, ctm.id_tipo_movimiento ,ctm.DESC_MOVIMIENTO DESC limit 1"; 

$r = $Vivienda -> query($sql);         
if($f = $r -> fetch_array()){
  
	 return $f['DescripcionMovimiento'];		
	
}
}

//FUNCION PARA CANCELAR UN CONTRATO
function MarcarCanceladoContrato ($numcontrato,$nitavu,$obseracionesCancelacion)
{
	$sql = "update contratos SET enviar=1, idempmodifica=" .$nitavu.",fechaultimamod=now(),CANCELADO=1, Observaciones='".$obseracionesCancelacion."' WHERE numcontrato= '" .$NumContrato. "'";
	echo $sql;
	if ($Vivienda->query($sql) == TRUE){   
		echo 'TRUE';
	}else{
		echo 'FALSE';
	}
}