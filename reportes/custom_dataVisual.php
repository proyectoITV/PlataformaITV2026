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

$SearchVisualList = VarClean($_POST['SearchVisualList']);
$SearchVisualList_value = "";
if ($SearchVisualList == 1){
    $SearchVisualList_value = "TRUE";
} else {
    $SearchVisualList_value = "FALSE";
}

$ColorPrincipal = VarClean($_POST['ColorPrincipal']);
$ColorSecundario = VarClean($_POST['ColorSecundario']);
$ColorResaltado = VarClean($_POST['ColorResaltado']);
$ColorDeFondo = VarClean($_POST['ColorDeFondo']);

$save="";
if (MiToken_valida($ElToken, $IdUser, "custom")==TRUE) { //Token Valido
    $Preference = "VisualLogo"; $Value = $VisualLogoCheck_value; $GroupA = ""; $GroupB="";
    if (PreferenceEdit($Preference, $GroupA, $GroupB, $Value)==TRUE){
        $save = $save."Logo, ";        
        historia_rintera($IdUser,"Configuraciones",  "Cambio el ajuste de Visualizacion del Logotipo a ".$VisualLogoCheck);        
    } 

    $Preference = "SearchVisualList"; $Value = $SearchVisualList_value; $GroupA = ""; $GroupB="";
    if (PreferenceEdit($Preference, $GroupA, $GroupB, $Value)==TRUE){
        $save = $save."Modo busqueda, ";        
        historia_rintera($IdUser,"Configuraciones",  "Cambio modo de visualizacion de resutlados a ".$SearchVisualList_value);        
    } 

    $Preference = "ColorPrincipal"; $Value = $ColorPrincipal; $GroupA = ""; $GroupB="";
    if (PreferenceEdit($Preference, $GroupA, $GroupB, $Value)==TRUE){
        $save = $save."ColorPrincipal, ";        
        historia_rintera($IdUser,"Configuraciones",  "Color Principal a ".$ColorPrincipal);        
    } 

    $Preference = "ColorSecundario"; $Value = $ColorSecundario; $GroupA = ""; $GroupB="";
    if (PreferenceEdit($Preference, $GroupA, $GroupB, $Value)==TRUE){
        $save = $save."ColorSecundario, ";        
        historia_rintera($IdUser,"Configuraciones",  " ColorSecundario a ".$ColorSecundario);        
    } 

    $Preference = "ColorResaltado"; $Value = $ColorResaltado; $GroupA = ""; $GroupB="";
    if (PreferenceEdit($Preference, $GroupA, $GroupB, $Value)==TRUE){
        $save = $save."ColorResaltado, ";        
        historia_rintera($IdUser,"Configuraciones",  "ColorResaltado a ".$ColorResaltado);        
    } 

    $Preference = "ColorDeFondo"; $Value = $ColorDeFondo; $GroupA = ""; $GroupB="";
    if (PreferenceEdit($Preference, $GroupA, $GroupB, $Value)==TRUE){
        $save = $save."ColorDeFondo, ";        
        historia_rintera($IdUser,"Configuraciones",  "ColorDeFondo a ",$ColorDeFondo);        
    } 
    
    if ($save <> ''){
        Toast("Se Guardo correctamente ".$save,1,"");
    } else {
        Toast("Error al guardar ".$save,2,"");
    }
} else {
    echo "Token Invalido";
}

?>