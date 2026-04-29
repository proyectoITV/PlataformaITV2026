<?php
require ("rintera-config.php");
require ("components.php");
// include("seguridad.php");   
echo "=>". $_POST['Token']."|";


$ElToken = VarClean($_POST['Token']);
$IdUser = VarClean($_POST['IdUser']);
$VisualLogoCheck = VarClean($_POST['VisualLogoCheck']);
$VisualLogoCheck_value = "";
if ($VisualLogoCheck == 1){
    $VisualLogoCheck_value = "TRUE";
} else {
    $VisualLogoCheck_value = "FALSE";
}

if (MiToken_valida($ElToken, $IdUser, "custom")==TRUE) { //Token Valido
    $Preference = "VisualLogo"; $Value = $VisualLogoCheck_value; $GroupA = ""; $GroupB="";
    if (PreferenceEdit($Preference, $GroupA, $GroupB, $Value)==TRUE){
        Toast("Se Guardo Correctamente. Recarga tu pagina para ver el cambio",0,"");
        historia_rintera($IdUser,"Configuraciones",  "Cambio el ajuste de Visualizacion del Logotipo a ",$VisualLogoCheck);        
    } else {
        Toast("ERROR al guardar",3,"");
    }
    
    
} else {
    echo "Token Invalido";
}

?>