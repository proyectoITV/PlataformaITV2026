<?php
    include ("lib/body_head.php");
    //No tiene menu vertical
?>


<?php
set_time_limit(72000) ;
error_reporting(0); //<-- para simular produccion
require_once("var_clean.php");
$id_aplicacion ="ap122"; $nivel = aplicacion_nivel($id_aplicacion, $nitavu);
$nivel =aplicacion_nivel($id_aplicacion, $nitavu);
echo "<script>$('body').css('background-color','rgb(255, 255, 255)');</script>";
// echo "<script>$('body').css('background-image','url(img/wall_ayuda3.jpg)');</script>";
// echo "<script>$('body').css('background-position','top');</script>";

if (sanpedro($id_aplicacion, $nitavu)==TRUE){
    echo "<div id='AppDetalle'>".app_detalle($id_aplicacion, $nitavu)."</div>";      
    echo "<br><br><br><br><center><div style ='background:#fff; width:80%;'>";

    //OPCIONES DE ACCION
    echo '<form action="ajuste_historico1.php">';
        echo "<h3>Seleccione una opción</h3>";
        echo '<input type="radio" id="html" name="opcion" value="1">';
        echo '<label for="html">Registro de Cargos de Servicios  Especial (+)</label><br>';

        echo '<input type="radio" id="css" name="opcion" value="2">';
        echo '<label for="css">Registro de Cargos y Abonos  Administrativos Especial (-)</label><br>';

        echo '<input type="radio" id="javascript" name="opcion" value="3">';
        echo '<label for="javascript">Registro de Pagos Histórico</label><br>';

        echo '<input type="radio" id="javascript" name="opcion" value="4">';
        echo '<label for="javascript">Registro de Subsidios Federal</label><br>';

        echo '<input type="radio" id="javascript" name="opcion" value="5">';
        echo '<label for="javascript">Registro de Subsidios (Estatal ,Municipal, Mano de Obra)</label><br>';

        echo '<input type="radio" id="javascript" name="opcion" value="6">';
        echo '<label for="javascript">Registro de Reintegros del Instituto</label><br>';

        echo '<input type="radio" id="javascript" name="opcion" value="7">';
        echo '<label for="javascript">Registro de Búsqueda de Documentos </label><br><br><br><br>';

        echo '<input type="submit" value="Seleccionar" class="Mbtn btn-primary" style="width:20%;">';
    echo '</form>';
    echo "</div></center>";


} else {mensaje("ERROR: no tienes acceso a este modulo","");}


?>

<?php include ("lib/body_footer.php"); ?>

