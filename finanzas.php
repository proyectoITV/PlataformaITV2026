<?php
// include ("seguridad.php"); 
include ("lib/body_head.php");
include ("lib/body_menu.php");


$id_aplicacion ="fin"; //tabla aplicaciones
$nivel = aplicacion_nivel($id_aplicacion, $nitavu); //tabla aplicaciones permisos
xd_update($id_aplicacion,$nitavu);//guarda la experiencia del usuario
historia($nitavu, "Entro a la aplicacion Explorador Financiero [v003]");
// insertar_mapa();
if (isset($_GET['m'])){
    if ($_GET['m']==''){
        $IdDelegacionSeleccionada = 0;
        $DelegacionSeleccionada = "CENTRAL";
    } else {
        $IdDelegacionSeleccionada = DelegacionDelMunicipio($_GET['m']);
        $DelegacionSeleccionada = "".DelegacionNombre($IdDelegacionSeleccionada);
        
    }

} else  {
    $IdDelegacionSeleccionada = 0;
    $DelegacionSeleccionada = "CENTRAL";
}




if (sanpedro($id_aplicacion, $nitavu)==TRUE){
echo "<div id='AppDetalle'>".app_detalle($id_aplicacion, $nitavu)."</div>";
   echo "<div id='indicadores'>";
   echo "</div>";
   insertar_mapa();
    


} else{mensaje("ERROR: no tiene acceso a esta aplicación","");}









include ("./lib/body_footer.php");
?>