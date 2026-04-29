<?php
include ("./lib/body_head.php");
?>

<?php
$id_aplicacion ="ap49";
$nivel =aplicacion_nivel($id_aplicacion, $nitavu);

if (sanpedro($id_aplicacion, $nitavu)==TRUE and $nivel==1)
{


$concepto = $_POST['Concepto'];
$idTipoRequisicion = $_POST['TipoRequisicion'];
$no = $_POST['IdConcepto'];
$quien = $_POST['quien'];
$historia = "Req_Conepto modificado por ".user_legend($quien)." el ".$fecha;
$id=$no.".jpg";
$anterior= $_SERVER['HTTP_REFERER'];
$costoProducto = $_POST['costoProducto'];


$sql =" -- req 
UPDATE req_conceptos SET Concepto='$concepto', IdTipoRequisicion='$idTipoRequisicion', Imagen='$id', Nitavu_Mod='$quien', fechaMod=NOW()  WHERE IdConcepto='$no'";




	if ($conexion->query($sql) == TRUE) 
			{

					$sql2 ="Update req_concepto_costo set FechaTermino=Now() , Activo=0 where Activo=1 and IdConcepto=".$no;
					echo $sql2;


				if ($conexion->query($sql2) == TRUE) 
				{
					$sql3 =" -- req
					INSERT INTO  req_concepto_costo(IdConcepto,Costo,FechaInicio,Activo)values($no,'$costoProducto',NOW(),1)";
					echo $sql3;
		
		
				if ($conexion->query($sql3) == TRUE) 
				  {
					 $msg="";
					 $archivo = 'fotos_concepto/'.$no.'';
					 $msg= $msg.subir('foto_file', $archivo, 'jpg');
										
					 if($msg=='ERROR: El archivo que intenta subir es mayor de 2mb')
						{
							$msg="La imagen no se ha actualizado:  ". $msg;
							mensaje($msg,'req_concepto_edit.php?n='.$no);
						}
						else
						{
		
						}
					 historia($quien,'Req_Actualizó datos del producto '.$no.'-'.$concepto);	
					 $msg = "Concepto actualizado con exito.";
					 mensaje($msg,'req.php?brig=&busqueda=');	
					}else
					{
						$msg="No se pudo registrar el costo del producto ".$sql2; //<-- Descripcion de error
					}

				}else
				{
					$msg="No se pudo dar de baja el costo del producto ".$sql2; //<-- Descripcion de error
				}
			
				//header('location:../index.php');	
			} 
		else 
			{
			$msg="Error inesperado ".$sql; //<-- Descripcion de error
			//creamos un historial de error extraordinario
			//header("location:../lib/error.php?er=".$msg);	
			}
		}
else{echo "	<br><br>";echo "No tiene acceso a ".$id_aplicacion;} 
?>