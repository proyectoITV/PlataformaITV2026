<?php
require_once("config.php");
require_once("lib/funciones.php");
require_once("lib/flor_funciones.php");

//RECIBIR DATOS PARA ACTUALIZAR
if(isset($_POST['FolioTramite'])){
    $nitavu = $_POST['nitavu'];
    $FolioTramite = $_POST['FolioTramite'];
    $IdPrograma = $_POST['IdPrograma'];
    $IdDelegacion = $_POST['IdDelegacion'];
    $Folio = $_POST['Folio'];
    $IdSolicitante = $_POST['IdSolicitante'];
    $origendeEnvio = $_POST['origendeEnvio'];
    $respuesta = enviarDatosaVivienda($FolioTramite, $IdPrograma, $IdDelegacion, $Folio, $IdSolicitante, $origendeEnvio,1,$nitavu,2,'');
    
    if($respuesta == TRUE){
        historia($nitavu,'Actualice los datos de la solicitud : IdPrograma '.$IdPrograma.', IdDelegacion '. $IdDelegacion.', Folio '.$Folio.'');
       
        //ELIMINO TEMPORALES 
        $sql = 'DELETE from solicitudestemp WHERE IdSolicitud='.$FolioTramite.'';
        //echo $sql;
        if ($conexion->query($sql) == TRUE){
            $sql = 'DELETE from solicitudesinformacion WHERE IdSolicitud='.$FolioTramite.'';
            if ($conexion->query($sql) == TRUE){
                echo 'ACTUALICE LOS DATOS DE LA SOLICITUD CON ÉXITO!!';
               // echo "Se eliminaron temporales con éxito.";
            }else{
                notificacion_add ('2850', 'Temporales', $fecha, $nitavu , 'No se eliminaron temporales del Folio: '.$FolioTramite.'');
            }
        }else{
            notificacion_add ('2850', 'Temporales', $fecha, $nitavu , 'No se eliminaron temporales del Folio: '.$FolioTramite.'');
        }
    }else{
        historia($nitavu,'Existio un error al momento de actulizar los datos de la solicitud : IdPrograma '.$IdPrograma.', IdDelegacion '. $IdDelegacion.', Folio '.$Folio.'');
        echo 'ERROR: Existio un error al momento de actulizar los datos, intentelo de nuevo';
    }
}else{
    echo 'No se recibieron datos';
}
?>