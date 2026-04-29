<?php
include ("./lib/body_head.php");
?>

<?php
$id_aplicacion ="ap49";
$nivel =aplicacion_nivel($id_aplicacion, $nitavu);

if (sanpedro($id_aplicacion, $nitavu)==TRUE and $nivel==1)
{

// $no = $_POST['no'];
// if (isset($no)) 
// {
	$concepto = $_POST['concepto'];
	$idTipoRequisicion = $_POST['tipoRequisicion'];
	$quien = $nitavu;
	//$id=$no.".jpg";
	$no=siguienteIdConcepto();
	$id=siguienteIdConcepto().".jpg";
	$costoProducto = $_POST['costoProducto'];

	if($idTipoRequisicion==0)
	{
		$msg='No ha especificado el Tipo de Requisición';
	
		mensaje($msg,'req_concepto_nuevo.php');

 }
else
{

	$sql = " -- req 
	INSERT INTO req_conceptos(Concepto, IdTipoRequisicion, Cancelado,Imagen,NItavu_crea,FechaCrea) 
	VALUES (UPPER('$concepto'),'$idTipoRequisicion', '0','$id','$quien',NOW())";
	if ($conexion->query($sql) == TRUE) 
			{

				$sql3 =" -- req
				INSERT INTO  req_concepto_costo(IdConcepto,Costo,FechaInicio,Activo)values($no,'$costoProducto',NOW(),1)";
				echo $sql3;
	
	
			if ($conexion->query($sql3) == TRUE) 
			  {

				
				$msg="";
				$archivo = 'fotos_concepto/'.$no.'';

				if(!empty($_FILES['foto_file']['name']) != null) 
				{
					$msg= $msg.subir('foto_file', $archivo, 'jpg');
					historia($quien,'Req_Alta de concepto "'.$concepto.'"');		
					mensaje($msg,'req.php');
				} 
				else
				{
					$ok= copiar_img($_POST['imagen_ejemplo'], $archivo.'.jpg'); 
					if ($ok=='TRUE')
						{
						 	mensaje("Alta de producto con exito!!",'../req.php');							
							historia($quien,'Req_Alta de concepto "'.$concepto.'"');		
					
						}
						else
						{
							mensaje("No se ha podido dar de alta el producto!!",'../req.php');
						}
						
				}
			
				
				}else
				{
					mensaje("No se ha podido dar de alta el costo del producto!!",'../req.php');
				}


			
			
			
			} 
		else 
			{
			$msg="Error inesperado ".$sql; //<-- Descripcion de error
			echo $sql;
			} 
	}
/*}
else 
{
	echo "	<br><br>";
	echo "algo anda mal";
}*/
	}
else
{
	echo "	<br><br>";
echo "No tiene acceso a ".$id_aplicacion;}
?>
