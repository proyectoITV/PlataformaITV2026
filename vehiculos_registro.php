<?php include ("./lib/body_head.php"); include ("./lib/body_menu.php");?>
<?php
$id_aplicacion ="ap88";
$nivel =aplicacion_nivel($id_aplicacion, $nitavu);

if (sanpedro($id_aplicacion, $nitavu)==TRUE)
{
    echo "<div id='AppDetalle'>".app_detalle($id_aplicacion, $nitavu)."</div>";



    echo "hola vehiculos";













}
else{mensaje("No tiene acceso a esta aplicacion",'');}
?>

    <br><br><br>
<br>
<br>
<br><br><br>
<br>
<br>
<br><br><br>
<br>
<br>
<br><br><br>
<br>
<br>
<?php include ("./lib/body_footer.php"); ?>