<?php
include ("./lib/body_head.php");
?>
<?php
$id_aplicacion ="ap49";
$nivel =aplicacion_nivel($id_aplicacion, $nitavu);

if (sanpedro($id_aplicacion, $nitavu)==TRUE)
{

 $idDetalle = $_POST['IdDetalle'];
 $cantidad = $_POST['cant'];
 //$Justificacion=$_POST['Justificacion'];


  $anterior= $_SERVER['HTTP_REFERER'];
 

      if (isset($_POST['btnLogA'])) 
      {
			// if(!empty($Justificacion))
			// { 
				if(requisicionIdConcepto_actualiza($idDetalle,$nitavu,$cantidad)==TRUE)
					{
						historia ($nitavu,"Req_Actualizó la cantidad del idDetalle ".$idDetalle." de la requisicion del ". nitavu_dpto_nombre($nitavu));
						if ( strpos($anterior, 'req_detalles.php')!== false)
						{	
							echo '<script type="text/javascript"> window.location.assign("'.$anterior.'");</script>';	
						}else
						{
							echo '<script type="text/javascript"> window.location.assign("req.php?m");</script>';
						}		
					}
					else
					{
						
						$msg="Error inesperado "; //<-- Descripcion de error
						//mensaje($msg,'req.php?m');

					}
		
			
     } 
     else if (isset($_POST['btnLogE'])) 
     {
     	
     	if(requisicionIdConcepto_baja($idDetalle,$nitavu)==TRUE)
			{
				historia ($nitavu,"Req_Eliminó el idDetalle ".$idDetalle." de la requisicion del ". nitavu_dpto_nombre($nitavu));		
				// echo '<script type="text/javascript"> window.location.assign("req.php?m");</script>';
				if ( strpos($anterior, 'req_detalles.php')!==false)
				{		
					echo '<script type="text/javascript"> window.location.assign("'.$anterior.'");</script>';	
				}else
				{
					echo '<script type="text/javascript"> window.location.assign("req.php?m");</script>';
				}				
			}
			else
			{
				$msg="Error inesperado "; //<-- Descripcion de error
			}


          

     }
     	}
else{echo "	<br><br>";echo "No tiene acceso a ".$id_aplicacion;}

    ?>