<?php 
require("seguridad.php"); 
require_once("config.php");
require_once("lib/funciones.php");
require_once("lib/flor_funciones.php");
require_once("lib/yes_funciones.php");
?>

<?php
    $idTramite = $_GET['Folio'];
    $idTipoTramite = $_GET['IdTipoTramite'];
    // $FechaNacimiento = TramiteFechaNacimiento($idTramite);
    // $edad = CalcularEdad($FechaNacimiento);
    // $acta = TramiteActaHijos($idTramite);
    //echo 'acta. '.$acta;
    //echo $idTramite;
    //echo $idTipoTramite;
    

    
if(ProcentajeTramite($idTramite,$idTipoTramite) >= 100 ){ 
    
    $NombreDelArchivoDeValidacion = TramiteValidacionName($idTipoTramite);
    $Continuo = 'TRUE';

    if($idTipoTramite <> 2){
        if ($NombreDelArchivoDeValidacion <> '' ){
            include($NombreDelArchivoDeValidacion); //<-- Este archivo hara las validaciones necesarias, y cambiara $Continuo a FALSE si lo requiere
    
        } else {
            $Continuo = 'TRUE'; //<-- Si no tiene definido un archivo de prevalidacion no la necesita
        }
    
    }
    


    if($Continuo == 'TRUE')
    {
        /*if(($idTipoTramite == 2 and TramiteFolioVivienda($idTramite)==0) or ($idTipoTramite == 2 and TramiteFolioVivienda($idTramite)=='')){
            echo 'ERROR: No puedes enviar el trámite sin antes finalizarlo.';
         }else{*/
            $sql = "UPDATE tramites SET Estado=1 WHERE IdTramite=".$idTramite ."";
            if ($conexion->query($sql) == TRUE) {
                historia($nitavu, "Envie el tramite ".$idTramite." para aprobación");
                echo 'Se ha enviado el tramite';  
            }   
            else {
                echo 'ERROR: No se ha podido actulizar el trámite a enviado.';
            }
        //}
       
    }
    
}else{
    echo "ERROR: No puedes continuar con la solicitud , no esta completo el trámite.";

} 


?>
