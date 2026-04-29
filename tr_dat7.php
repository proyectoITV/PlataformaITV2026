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
    $obs = $_GET['obs'];
             
    $sql = "UPDATE tramites SET Estado=4 WHERE IdTramite=".$idTramite ."";
       
    if ($conexion->query($sql) == TRUE) {      
       $sql1 = "INSERT INTO tramitesObservaciones(Id, IdTramite, Fecha, Hora, NitavuCaptura, Observacion, Cancelado,Estado) 
       VALUES ( '', '$idTramite', '$fecha','$hora','$nitavu','$obs', 0,4)";        
       if ($conexion->query($sql1) == TRUE){
           historia($nitavu, "Marque como devuelto el tramite ".$idTramite." y puse esta observación ".$obs."");

           $idTipoTramite=TramiteIdTipoTramite($idTramite);
           //$idPrograma=TramiteIdPrograma($idTipoTramite);
           $nombrePrograma=TramiteProgramaNombre($idTipoTramite);
           $nombreTramite=TramiteNombre($idTipoTramite);
           $nitavuCaptura=TramiteNitavuCaptura($idTramite);
           $msgNoti=''.$nombreTramite.' con  <B>Folio'.$idTramite.'</B> del programa '.$nombrePrograma.
           ' fue <B>DEVUELTO</B>, con las siguientes observaciones:<br>'.$obs.
           '.<br><BR>Si desea obtener más información, favor de buscar el tramite en la seccion tramites de la plataforma.<BR><BR><b>Atentamente:</b><br>'.nitavu_nombre($nitavu);
   
   
           notificacion_add ($nitavuCaptura, 'El tramite '.$nombreTramite.' folio '.$idTramite.' fue DEVUELTO', date('Y-m-d'),$nitavu, $msgNoti);   
           echo 'TRUE';  
       }else{
           echo 'FALSE';
       }
       
    
    }else {
        echo 'FALSE';
        
    }
   



    


?>
