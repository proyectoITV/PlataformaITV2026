

<?php
include ("./lib/body_head.php");
?>

<?php

$id_aplicacion ="ap49";
$nivel =aplicacion_nivel($id_aplicacion, $nitavu);

if (sanpedro($id_aplicacion, $nitavu)==TRUE)
{




if (isset($_POST['btnAgrupar'])) 
{
 if (!empty($_POST['idrequisiciones']) && is_array($_POST['idrequisiciones']))

{
 
 	 $selected = '';
         $idrequisiciones = array_map('intval', $_POST['idrequisiciones']);
         $idrequisiciones = array_filter($idrequisiciones, function ($id) {
          	return $id > 0;
         });

         if (empty($idrequisiciones)) {
         	mensaje('Debe seleccionar al menos una requisicion valida','req_solicitar_req.php');
         	exit;
         }

         $num_countries = count($idrequisiciones);
         $current = 0;
         foreach ($idrequisiciones as $key => $value) 
         {
             if ($current != $num_countries-1)
                 $selected .=  "(^".$value."$)|";
             else
                 $selected .= "(^".$value."$)";
           $current++;
       }
 

$sql ="CALL sp_agruparRequisiciones(".$nitavu.",'".$selected."')";

try {
	$resultado = $conexion->query($sql);

	if ($resultado instanceof mysqli_result) {
		$resultado->free();
	}

	while ($conexion->more_results() && $conexion->next_result()) {
		$resultadoExtra = $conexion->store_result();
		if ($resultadoExtra instanceof mysqli_result) {
			$resultadoExtra->free();
		}
	}

	$msg="";
	historia($nitavu,'Req_Se han agrupado las requisiciones de los siguientes Dptos:'.$selected);
	$msg = $msg."Se han agrupado las requisiciones seleccionadas";
	mensaje($msg,'req.php');
	//header('location:../index.php');
} catch (Throwable $e) {
	while ($conexion->more_results() && $conexion->next_result()) {
		$resultadoExtra = $conexion->store_result();
		if ($resultadoExtra instanceof mysqli_result) {
			$resultadoExtra->free();
		}
	}

	$msg = 'ERROR: Fallo al agrupar requisiciones. ' . $e->getMessage();
	mensaje($msg,'req_solicitar_req.php');
}

 }

 else
 {
 	 $selected = 'Debe seleccionar al menos una requisición';
 	 mensaje($selected,'req_solicitar_req.php');
 }



   
}  



			}
else{echo "<br><br>";echo "No tiene acceso a ".$id_aplicacion;}
?>