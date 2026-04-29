<?php 
require("seguridad.php"); 
require_once("config.php");
require_once("lib/funciones.php");
require_once("lib/flor_funciones.php");

?>
<br><br>
<?php

$idDepartamento=nitavu_dpto($nitavu);
$id_aplicacion ="ap87";
$nivel =aplicacion_nivel($id_aplicacion, $nitavu);

if (sanpedro($id_aplicacion, $nitavu)==TRUE){
    // echo "<div id='AppDetalle'>".app_detalle($id_aplicacion, $nitavu)."</div>";	    
    $CURP = $_GET['CURP']; if (ValidaVAR($CURP)==TRUE){$CURP = LimpiarVAR($CURP);} else {$CURP = "";}
    $IdTipoTramite = $_GET['Folio']; if (ValidaVAR($IdTipoTramite)==TRUE){$IdTipoTramite = LimpiarVAR($IdTipoTramite);} else {$IdTipoTramite = "";}
    
    if (TramiteValidarContinuidad($CURP, $IdTipoTramite,$IdPrograma, $IdDelegacion) == TRUE){
        //sin mensaje
        echo '<script>
        $("#BtnSolicitar").show();
        // NPush("Puedes Seleccionar este Tramite","tramites ITAVU");</script>';
    } else {
        echo '<script>
        $("#BtnSolicitar").hide();
        NPush("No puedes continuar tramite, ya que aun no concluye el primero.","tramites ITAVU");</script>';
    }
  
}else{
    // mensaje('No tiene permiso para esta aplicación','index.php');
}





?>



<?php include ("./lib/body_footer.php"); ?>
