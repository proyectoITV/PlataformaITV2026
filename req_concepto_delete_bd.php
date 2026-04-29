<?php
include ("./lib/body_head.php");
?>
<?php
$id_aplicacion ="ap49";
$nivel =aplicacion_nivel($id_aplicacion, $nitavu);

if (sanpedro($id_aplicacion, $nitavu)==TRUE and $nivel==1)
{
$id = $_GET['d'];
$sql=" -- req 
UPDATE req_conceptos SET  Cancelado='1' ,FechaMod=NOW(), Nitavu_Mod=".$nitavu ." WHERE IdConcepto=".$id;
//echo $sql;
	
			$resultado = $conexion -> query($sql);
			if ($conexion->query($sql) == TRUE)
			{
				historia ($nitavu,"Req_Eliminó del cátalogo de conceptos ".nombreIdConcepto($id));				
				mensaje ("Concepto eliminado correctamente!!!!",'req.php');
			}
			else
			{
				$msg="Error inesperado ".$sql; //<-- Descripcion de error
			}
			
	}
else{echo "	<br><br>";echo "No tiene acceso a ".$id_aplicacion;}
	
?>