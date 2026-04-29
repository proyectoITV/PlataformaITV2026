<?php
require ("rintera-config.php");
require ("components.php");
// include("seguridad.php");   
echo "=>". $_POST['Token']."|";


$ElToken = VarClean($_POST['Token']);
$IdUser = VarClean($_POST['IdUser']);
$UsuariosForaneos = VarClean($_POST['UsuariosForaneos']);
$UsuariosForaneosQuery = VarClean($_POST['UsuariosForaneosQuery']);
$UsuariosForaneosIdCon = VarClean($_POST['UsuariosForaneosIdCon']);


$save="";
if (MiToken_valida($ElToken, $IdUser, "custom")==TRUE) { //Token Valido
 
    $Preference = "UsuariosForaneos"; $Value = $UsuariosForaneos; $GroupA = ""; $GroupB="";
    if (PreferenceEdit($Preference, $GroupA, $GroupB, $Value)==TRUE){
        $save = $save."UsuariosForaneos, ";        
        historia_rintera($IdUser,"Configuraciones",  "UsuariosForaneos= ".$UsuariosForaneos);        
    } 

    $Preference = "UsuariosForaneosQuery"; $Value = $UsuariosForaneosQuery; $GroupA = ""; $GroupB="";
    if (PreferenceEdit($Preference, $GroupA, $GroupB, $Value)==TRUE){
        $save = $save."UsuariosForaneosQuery, ";        
        historia_rintera($IdUser,"Configuraciones",  "UsuariosForaneosQuery= ".$UsuariosForaneosQuery);        
    } 

    $Preference = "UsuariosForaneosIdCon"; $Value = $UsuariosForaneosIdCon; $GroupA = ""; $GroupB="";
    if (PreferenceEdit($Preference, $GroupA, $GroupB, $Value)==TRUE){
        $save = $save."UsuariosForaneosIdCon, ";        
        historia_rintera($IdUser,"Configuraciones",  "UsuariosForaneosIdCon= ".$UsuariosForaneosIdCon);        
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