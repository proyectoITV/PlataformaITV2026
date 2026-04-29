<?php // ENCABEZADO (NO MOVER)
include ("./unica/body_head.php");
include ("./unica/body_menu.php");
?>





<?php

//PROCESO PARA TOCAR LA PUERTA DE SAN PEDRO
$id_aplicacion ="ap33"; //Id de la aplicacion a cargar
if (sanpedro($id_aplicacion, $nitavu)==TRUE){
	echo "<h5>".app_detalle($id_aplicacion)."</h5>";
	

} else {mensaje("ERROR: no tiene acceso a esta aplicacion",'');}
include ("./unica/body_footer.php");
?>