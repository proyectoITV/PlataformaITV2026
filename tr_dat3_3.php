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
    $NombreDelArchivoDeValidacion = TramiteValidacionName($idTipoTramite);
    
    if((ProcentajeTramite($idTramite,$idTipoTramite)) == 100 )
    {
     
        $Continuo = 'TRUE';
        if ($NombreDelArchivoDeValidacion <> '' ){
            include($NombreDelArchivoDeValidacion); //<-- Este archivo hara las validaciones necesarias, y cambiara $Continuo a FALSE si lo requiere
        } else {
            $Continuo = 'TRUE'; //<-- Si no tiene definido un archivo de prevalidacion no la necesita
        }

       if ($Continuo == 'TRUE')
        {
            

        }else{
            
            //echo "No puedes realizar la impresión del acuse, no cumple con los requisitos.";
        }
    }
   else{
        echo "No puedes realizar la impresión del acuse, no esta completo el trámite.";
    }
    
    


?>
