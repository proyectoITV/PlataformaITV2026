<?php
//include ("./unica/seguridad.php"); 
include ("./unica/body_head.php");
include ("./unica/body_menu.php");

// contenido:
?>

<?php
//PROCESO PARA TOCAR LA PUERTA DE SAN PEDRO
$id_aplicacion ="ap25"; //ap06=Permisos de Aplicacion
if (sanpedro($id_aplicacion, $nitavu)==TRUE){
	echo "<h5>".app_detalle($id_aplicacion)."</h5>";
	
	if (isset($_GET['desde']) and isset($_GET['hasta'])){
		echo pase_estado($nitavu, $_GET['desde'], $_GET['hasta'], "TRUE");
		historia ($nitavu,"Vio estado de pases, ".$_GET['desde']." a ".$_GET['hasta']);
	} else {
		echo pase_estado($nitavu, $fecha, $fecha, "TRUE");
		historia ($nitavu,"Vio estado de pases, ".$fecha.", ");
	}
	

	
}
else{echo "No tiene acceso a ".$id_aplicacion;}











?>





<?php
include ("./unica/body_footer.php");
?>