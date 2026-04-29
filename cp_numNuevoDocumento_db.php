<?php
include ("./lib/body_head.php");
?>

<?php
$id_aplicacion ="ap66";
$tipodocumento="numOficio";
$nivel =aplicacion_nivel($id_aplicacion, $nitavu);
$anterior= $_SERVER['HTTP_REFERER'];


	$idDepartamento = $_POST['departamento'];
	$destinatario= $_POST['destinatario'];
	$puestoDestinatario = $_POST['puesto'];
    $asunto = $_POST['asunto'];       
    $idtipoDocumento = $_POST['tipoDocumento'];
    $observaciones = $_POST['observaciones']; 
	$quien = $nitavu;
	$numeroCompleto=NULL;	
	
//valido que haya seleccionado un departamento	de lo contrario manda mensaje
if(empty($idDepartamento))
	{
		
		
		$msg='¡No ha especificado el departamento!';		
			mensaje($msg,$anterior);		
}else
{
	
	
	
 //valido que haya seleccionado un tipo de documento (oficio, Memo , circular o tarjeta)
if(empty($idtipoDocumento))
{
	
		$msg='¡No ha especificado el tipo de documento!';	
		mensaje($msg,$anterior);
 
}
else
{
	$tipodocumento=consultaIdTipoDocumento($idtipoDocumento,FALSE);// consulto que tipo de documento es en base al id
		// Identificó si soy Direecion,  Si no soy Direccion verifico si el Dpto que solicite es una direccion , si es este el caso necesito pedir autorización
	    // a la Direccíon a la que pertenesco , una vez autorizado se genera el numeró de documento
	
	// 	// if (soyDireccion(nitavu_dpto($nitavu))==FALSE)
	// // 	{		
				
	// 		if(($idDepartamento==1) ||($idDepartamento==6)||($idDepartamento==10)||($idDepartamento==19)||($idDepartamento==46)||($idDepartamento==54))
	// 		{
	// 			//hola
	// 			$numero=-1;				
	// 			$msg='¡Se ha solicitado autorización a su Dirección, una vez autorizado, se le notificará el número que le fue asignado.!';

	// 			historia ($nitavu,"cp_Solicita autorización para un nuevo numeró de documento") ;	

	// 				$sql=" -- cp
	// 				SELECT  empleados.nitavu, empleados.correoelectronico,empleados.nombre
	// 				,(select empleados.nitavu from empleados where nitavu= ".$nitavu.") as nitavuenvia
	// 				,(select empleados.correoelectronico from empleados where nitavu= ".$nitavu.") as correoelectronicoenvia
	// 				,(select empleados.nombre from empleados where nitavu= ".$nitavu.") as nombreenvia
	// 				from aplicaciones_permisos	INNER JOIN empleados on aplicaciones_permisos.nitavu=empleados.nitavu
	// 				where empleados.dpto=".quienEsmiDireccion(nitavu_dpto($nitavu))." and aplicaciones_permisos.idapp='ap66'"; 
													
	// 				$msgNoti ="<br> Buen dia, El <b>". nombreDepartamento(nitavu_dpto($nitavu)) ." </b> ha solicitado la asignación de un nuevó numero de documento..<br>				
	// 				Para más información favor de revisar la lista de documentos recientes.
	// 				<br>";
					

	// 				$r2 = $conexion -> query($sql);
							                                 										 
	// 				 while($fx = $r2 -> fetch_array())
	// 					{
	// 					notificacion_add ($fx['nitavu'], 'Solicitud de un número de documento', date('Y-m-d'), $nitavu,$msgNoti);	
	// 					//correo( $fx['correoelectronicoenvia'], $fx['nombreenvia'],$fx['correoelectronico'], nitavu_nombre($fx['nitavu']),$asunto ,$msgNoti, $fx['nitavu']);			
	// 					}
									



				
	// 		}// si no soy Direccion y no solicite enviar a una Direccion automaticamente se genera el numero de Documento
	// 		else
	// 		{
				
				$numero=ndocumentoCorrespondencia(true,nitavu_dpto($nitavu),$tipodocumento);//obtengo el ultimo número de documento segun el tipo y el Dpto	
				$numeroCompleto= $tipodocumento.' No. '.consultaInicialesJerarquia(nitavu_dpto($nitavu)).($numero+1).'/'.date_format( date_create($fecha), 'Y'); // Armó el número de documento completo con fecha e iniciales del dpto.		
				$msg="¡Se ha generado el N° <b>".($numeroCompleto)."<b>!";	
				
				historia ($nitavu,"cp_Generó el numeró de documento ".$numeroCompleto." para el Dpto. ".nombreDepartamento(nitavu_dpto($nitavu))) ;
				
			}
		// }
		// // Si Soy Dirección, automaticamente se genera el número de Documento no es necesario pedir autorización.
		// else
		// {
			
			
		// 		$numero=ndocumentoCorrespondencia(true,nitavu_dpto($nitavu),$tipodocumento); //obtengo el ultimo número de documento segun el tipo y el Dpto	
		// 		$numeroCompleto= $tipodocumento.' No. '.consultaInicialesJerarquia(nitavu_dpto($nitavu)).($numero+1).'/'.date_format( date_create($fecha), 'Y');// Armó el número de documento completo con fecha e iniciales del dpto.	
		// 		$msg="¡Se ha generado el N° <b>".($numeroCompleto)."<b>!";	

		// 		historia ($nitavu,"cp_Generó el numeró de documento ".$numeroCompleto." para el Dpto. ".nombreDepartamento(nitavu_dpto($nitavu))) ;
			
			
		// }
//	}
}




		$numero=$numero+1;	
		//guardo en la base de datos el registro con todos los datos referentes al documento que desea enviar 
		 $sql = " -- cp 
		 	INSERT INTO cp_controlcorrespondencia(numero,nitavuCrea,iddptoenvia,destinatario,puestodestinatario,asunto,observaciones,idtipodocumento,fechacrea,iddptocrea,autorizado,numdocumento,iddptofirma) 
		 	VALUES ('".$numero."','".$quien."',".$idDepartamento.",'".$destinatario."','".$puestoDestinatario."','".$asunto."','".$observaciones."',".$idtipoDocumento.",NOW(),".nitavu_dpto ($nitavu).",null,'$numeroCompleto',".nitavu_dpto($nitavu).")";
	
		 	if ($conexion->query($sql) == TRUE) 
		 			{
						//una vez almacenado el registro en la tabla cotrol-correspondencia , entonces si actualizo el numero de docuemento en cat_gerarquia 
		 			ndocumentoCorrespondencia(false,nitavu_dpto($nitavu),$tipodocumento);
		 			mensaje($msg,$anterior);
		 			} 
				else 
		 			{
						 
			 		$msg="¡Error inesperado, no se ha podido generar un nuevo número de docuemento!".$sql; //<-- Descripcion de error
					mensaje($msg,$anterior);	 
						} 
			
			
	 

?>
