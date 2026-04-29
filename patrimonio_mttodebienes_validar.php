<?php
include ("./lib/body_head.php");
?>

<?php
	$numinvoficial = $_POST['numinvoficial'];
	if (isset($numinvoficial)) 
	{
		$numinvanterior = $_POST['numinvanterior'];
		$numinvgobierno = $_POST['numinvgobierno'];
		$descripciondelbien = $_POST['descripciondelbien'];
		$listademarcas = $_POST['listademarcas'];
		$modelo = $_POST['txtmodelobien'];
		$serie = $_POST['txtseriebien'];
		$fechafac = $_POST['fecha_factura'];
		$num_factura  = $_POST['txtnumerofactura'];	
		$costo_articulo  = $_POST['txtcostoarticulo'];	
		$cboclascontraloria = $_POST['cboclascontraloria'];
		$listadeproveedores = $_POST['listadeproveedores'];

		$fecha_actual = date("Y-m-d");

		$sql = "INSERT INTO patrimonio_bienesactivos(fechaderegistro, numinvoficial, numinvgobierno, numinvanterior, nombredelbien, idmarca, modelo, serie, fechafactura, numerofactura, costodelarticulo, id_contraloria, id_proveedor) 
		VALUES ('$fecha_actual', '$numinvoficial', '$numinvgobierno', '$numinvanterior', '$descripciondelbien', '$listademarcas', '$modelo', '$serie', '$fechafac', '$num_factura', '$costo_articulo', '$cboclascontraloria', '$listadeproveedores')";

		if ($conexion->query($sql) == TRUE) 
			{
				$msg="Se ha hecho la ALTA con exito";
				mensaje($msg,'');
				historia($nitavu,'Alta de empleado con No.  '.$numinvoficial);
			} 
		else 
			{
				$msg="Error inesperado ".$sql; 
				mensaje($msg,'');
			} 
	}
else
	{
		echo "algo anda mal";
	}
?>