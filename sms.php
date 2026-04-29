

<?php 
include ("./lib/body_head.php");
include ("./lib/body_menu.php");
?>



<?php

$id_aplicacion ="ap64"; //Id de la aplicacion a cargar
$nivel = aplicacion_nivel('ap64', $nitavu); $nivel=1;


if (sanpedro($id_aplicacion, $nitavu)==TRUE){echo "<div id='AppDetalle'>".app_detalle($id_aplicacion, $nitavu)."</div>";
    

} else {mensaje("ERROR: no autorizado","");}
include ("./lib/body_footer.php");

?>                                  

