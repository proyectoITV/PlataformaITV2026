<?php include ("./lib/body_head.php"); include ("./lib/body_menu.php"); ?>
<?php
//PROCESO PARA INICIAR UNA APP 
// * ANTES registrarla en la tabla aplicaciones, y generarse un permiso para usarla
$id_aplicacion ="ap52"; //ap07=Permisos de Aplicacion
$nivel = aplicacion_nivel($id_aplicacion, $nitavu);
$nivel = 3; //Puedes alterar aqui el nivel para las pruebas
if (sanpedro($id_aplicacion, $nitavu)==TRUE){
echo "<div id='AppDetalle'>".app_detalle($id_aplicacion, $nitavu)."</div>";
echo "<div id='mandantes'>";

if(isset($_GET['idmandante']) and isset($_GET['idcolonia']) and isset($_GET['idmunicipio'])){
    $idmunicipio = $_GET['idmunicipio'];
    $idcolonia = $_GET['idcolonia'];
    $idmandante = $_GET['idmandante'];
    echo "<br>";
    echo "<br>";
    echo "<br>";
    echo "<br>";
    echo "<center>";
    echo "<div id='modificarMandantes' style='width:80%;'>";
    echo "<br>";
    echo "<h1>Modificar datos mandante</h1>";
    echo "<br>";
    echo "<span class='normal tmediano' style='text-align: left;'>Municipio: <b>".strtoupper(nombreMunicipio($idmunicipio))."</b></span><br>";
    echo "<span class='normal tmediano' style='text-align: left;'>Colonia: <b>". strtoupper(nombreColonia($idmunicipio,$idcolonia))."</b></span>";
        echo "<form action='mandantes.php' method='POST'>";

       echo "<input type='hidden' id='idmandante' name='idmandante' value='".$idmandante."' class='Mbtn btn-default'>";
       echo "<input type='hidden' id='idcolonia' name='idcolonia' value='".$idcolonia."' class='Mbtn btn-default'>";
       echo "<input type='hidden' id='idmunicipio' name='idmunicipio' value='".$idmunicipio."' class='Mbtn btn-default'>";
        
       echo "<label>Mandante (s):</label>";
        echo "<input id='mandante' name='mandante' value='".strtoupper(nombreMandante($idmunicipio,$idcolonia,$idmandante))."'>";
        
        echo "<label>Representante Legal:</label>";
        echo "<input id='representante' name='representante' value='".strtoupper(mostrarApoderadoMandante($idmunicipio,$idcolonia,$idmandante))."'>";

        echo "<label>Propietario (s):</label>";
        echo "<input id='propietario' name='propietario' value='".strtoupper(propietarioMandante($idmandante,$idcolonia,$idmunicipio))."'>";
        echo "<br>";
        echo "<input type='submit' value='Guardar' class='Mbtn btn-default' style='width:20%;'>";
        echo "</form>";
    echo "<br><br>";
    echo "</div>";
    echo "</center>";
}

}else{
  mensaje("No tiene permiso para ver esta aplicacion",'');
}	 
?>
<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>


<?php include ("./lib/body_footer.php"); ?>