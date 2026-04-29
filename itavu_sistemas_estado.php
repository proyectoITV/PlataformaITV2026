<?php // ENCABEZADO (NO MOVER)
include ("./lib/body_head.php");
include ("./lib/body_menu.php");
?>





<?php

//PROCESO PARA TOCAR LA PUERTA DE SAN PEDRO
$id_aplicacion ="ap33"; //Id de la aplicacion a cargar
if (sanpedro($id_aplicacion, $nitavu)==TRUE){
	echo "<div id='AppDetalle'>".app_detalle($id_aplicacion, $nitavu)."</div>";
	






	
}
else {	mensaje ("ERROR: No tiene acceso a esta aplicacion",''); }




?>




<?php // PIE DE PAGINA (NO MOVER)
include ("./lib/body_footer.php");
?>