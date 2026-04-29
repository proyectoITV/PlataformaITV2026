
<?php
require_once("config.php");
require_once("lib/funciones.php");
require_once("lib/yes_funciones.php");
require_once("lib/flor_funciones.php");

if( isset($_POST['IdDelegacion']) and isset($_POST['IdPrograma']) and isset($_POST['Folio']))
{
   
    if(buscaSolicitud($_POST['IdPrograma'],$_POST['IdDelegacion'], $_POST['Folio'])>0 )
    {

        if( buscarSiYaTieneContrato($_POST['IdDelegacion'],$_POST['IdPrograma'], $_POST['Folio'])=='')
        {

            if(ExisteTramiteDeDevolucionActivo($_POST['IdDelegacion'],$_POST['IdPrograma'], $_POST['Folio'])=='FALSE')
            {
                $idsolicitante=buscarIdSolicitante( $_POST['IdPrograma'],$_POST['IdDelegacion'], $_POST['Folio']);
                echo  nombreBeneficiarioVivienda($idsolicitante);   
            }
            else
            {
                echo "<h3 style='color: red; font-size:9pt;'><b>La solicitud tiene un trámite de devolución, imposible proceder!!...</b></h3>";
            }
        }
        else
        {
            echo "<h3 style='color: red; font-size:9pt;'><b>El folio ya tiene un contrato!!. NumContrato:".buscarSiYaTieneContrato($_POST['IdDelegacion'],$_POST['IdPrograma'], $_POST['Folio'])."....</b></h3>";
        }
    
    }
    else
    {
        echo "<h3 style='color: red; font-size:9pt;'><b>No se localizó solicitud con ese folio, verifique los datos por favor!!...</b></h3>";
    }


   
}
 
    

    
?>