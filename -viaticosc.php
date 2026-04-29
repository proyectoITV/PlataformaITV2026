<?php include ("./lib/body_head.php"); include ("./lib/body_menu.php"); 
require_once("config.php");
require("viaticos_fun.php");
?>
<?php

$id_aplicacion ="viaticosC"; //tabla aplicaciones
$nivel = aplicacion_nivel($id_aplicacion, $nitavu); //tabla aplicaciones permisos

if (sanpedro($id_aplicacion, $nitavu)==TRUE){
    echo "<div id='AppDetalle'>".app_detalle($id_aplicacion, $nitavu)."</div>";


    echo "<script>$('body').css('background-color','rgb(108, 116, 119)');</script>";
    echo "<script>$('body').css('background-image','url(img/wallviaticos.png)');</script>";
    echo "<script>$('body').css('background-position','top');</script>";
    echo "<script>$('#AppDetalle').css('background-color','rgba(2, 2, 2, 0.41)');</script>";    
    // echo "<script>$('body').css('background-size','120%');</script>";

    
    $sql="select * from viaticosconsulta_html  order by IdViatico DESC";    
    echo "<div id='Ayudas' class='container' style='
    background-color: #ffffffb0;
    padding: 20px;
    border-radius: 10px;
    margin-top: 30px;

    '>";
    TablaDinamica_MySQL("",$sql, "AyudaLista", "AyudaTabla", "", 2,"AyudaTabla"); //0 = Basica, 1 = ScrollVertical, 2 = Scroll Horizontal
    echo "</div>";
    echo "<script>$('tr').css('background-color','transparent');</script>";
    echo "<script>$('td').css('background-color','transparent');</script>";
    
}
else {MsgBox_Lite("No tiene permiso para ver esta aplicacion",'');}	 


?>



<?php include ("./lib/body_footer.php"); ?>