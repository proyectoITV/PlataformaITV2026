<?php
//include (".//seguridad.php"); 
include ("./lib/body_head.php"); include ("./lib/body_menu.php");


?>
<?php
$id_aplicacion ="ap109"; //Id de la aplicacion a cargar
$nivel = aplicacion_nivel($id_aplicacion, $nitavu);

$direccion=quienEsmiDireccion(nitavu_dpto($nitavu));
$anterior= $_SERVER['HTTP_REFERER'];
if (sanpedro($id_aplicacion, $nitavu)==TRUE){
    echo "<div id='AppDetalle'>".app_detalle($id_aplicacion, $nitavu)."</div>";
    xd_update('ap109',$nitavu);//guarda la experiencia del usuario
    historia($nitavu, "Entro a la aplicacion [ap109], para consultar las escrituras.");


    /* VALIDAMOS QUE EXISTAN LAS VARIBALES Y SI ES ASI LAS ASIGANAMOS A OTRA VARIABLE QUE PODAMOS USAR*/   
    if (isset($_POST['idlote']))
    {
      $idlote = $_POST['idlote']; 
    }   

    
    /* REALIZA LAS OPERACIONES EN LA BASE DE DATOS SEGUN LA ACCION */
    /******************************* RECEPCION TRAMITE **************************************/
    if ($_GET['Accion']==0) 
    {     
      $accion=67;
      $numescritura=$_POST['numescritura'];
      $soporte='';
      $observaciones=strtoupper ($_POST['ObservacionesRecepcion']);     
      
      $asunto="Tramite de escritura se recibio en oficinas centrales";
      $msg="El tramite de escritura con número:  ".$numescritura." fue recibido en oficinas centales";
      if(InsertSeguimientoEscritura($numescritura,$accion,$nitavu,$soporte,$observaciones)=='TRUE')
        { 
          historia($nitavu,'Esc_'.$msg);
          mensaje($msg ,$anterior);         
        }
        else
        {
          echo 'no entro a recepcion de trámite';
        }
    }
  
  

    
    /******************************* APROBAR TRAMITE **************************************/
  if (isset($_GET['Accion'])) 
  {  
    //ACCION 1 ES APROBAR TRAMITE
    if($_GET['Accion']==1)
    {
          $accion=ObtenerIdAccionSeguimiento($direccion,$_GET['Accion']); 
          $campo= ObtenerCampomovescrituras ($direccion,$_GET['Accion']); 
          $numescritura=$_POST['numescritura'];
          $soporte=NULL;
          $observaciones=strtoupper ($_POST['ObservacionesAprobar']);

          $asunto="Tramite de escritura Aprobado";
          $msg="El tramite de escritura con número:  ".$numescritura." fue APROBADO";
          $ulimaAccion=UltimaAccionSeguimientoPorTramite($numescritura);  
          $campo3=Obetnernotificacionseguimiento($numescritura);
          if(InsertSeguimientoEscritura($numescritura,$accion,$nitavu,$soporte,$observaciones)=='TRUE')
            {           
               
            $accionDetener=ObtenerIdAccionSeguimiento($direccion,2) ;

            //VALIDAMOS SI LA ULTIMA ACCION FUE UNA DETENCION POR LA MISMA DIRECCION QUE QUIERE APROBAR 
            // EN CASO DE SER ASI. SE QUITARIA LA NOTIFICACIÒN
            echo  $ulimaAccion.'----'.$accionDetener;
              if($ulimaAccion==$accionDetener)
              { 
                //obtenemos el campo al cual se va notificado , para quitar la notificacion.             
              //  echo 'campo'.$campo3;
                $sql=" -- esc 
                UPDATE movescrituras SET FechaUltimaMod=NOW(), IdEmpModifica=".$nitavu.", ".$campo."=1 , ".$campo3."=1 WHERE NumEscritura='".$numescritura."'";

              }else {
                $sql=" -- esc 
                UPDATE movescrituras SET FechaUltimaMod=NOW(), IdEmpModifica=".$nitavu.", ".$campo."=1 WHERE NumEscritura='".$numescritura."'";
              }
            
              //echo $sql;
              if ($Vivienda->query($sql) == TRUE)
              {
                historia($nitavu,'Esc_'.$msg);
                mensaje($msg ,$anterior);
              }
        
              else
              {
                $msg="Error inesperado ".$sql; //<-- Descripcion de error
              }
            }else{echo 'no entro a aprobar trámite';}
      }
      
    /******************************* PAUSAR TRAMITE **************************************/
        if ($_GET['Accion']==2) 
        {     
          $accion=ObtenerIdAccionSeguimiento($direccion,$_GET['Accion']); 
          $campo= ObtenerCampomovescrituras ($direccion,$_GET['Accion']); 
          $numescritura=$_POST['numescritura'];
        
          $observaciones=strtoupper ($_POST['ObservacionesNva']);
          if (isset($_POST['area']))
          {
            $area=$_POST['area'];
            $soporte='NOTIFICACION: '.$_POST['textoArea'];
          }

          
          $asunto="Tramite de escritura puesto en PAUSA";
          $msg="El tramite de escritura con número:  ".$numescritura." fue puesto en PAUSA";
          if(InsertSeguimientoEscritura($numescritura,$accion,$nitavu,$soporte,$observaciones)=='TRUE')
            { 
              if($area!=0)
              {
                $campo2= ObtenerCampomovescrituras ($area,$_GET['Accion']); 
                $sql=" -- esc 
                UPDATE movescrituras SET FechaUltimaMod=NOW(), IdEmpModifica=".$nitavu.", ".$campo."=2 , ".$campo2."=3 WHERE NumEscritura='".$numescritura."' and Cancelado=0";
              
              }else {
                $sql=" -- esc 
                UPDATE movescrituras SET FechaUltimaMod=NOW(), IdEmpModifica=".$nitavu.", ".$campo."=2 WHERE NumEscritura='".$numescritura."' and Cancelado=0";      
              }
              
              //echo $sql;
              if ($Vivienda->query($sql) == TRUE)
              {
                historia($nitavu,'Esc_'.$msg);
                mensaje($msg ,$anterior);
              }
        
              else
              {
                $msg="Error inesperado ".$sql; //<-- Descripcion de error
              }
            }else{echo 'no entro a pausar trámite';}
        }
      
      

    /******************************* CAPTURAR FINCA **************************************/
    if ($_GET['Accion']==3) 
    {
      if (isset($_POST['idlote']))
      {
        $idlote=$_POST['idlote'];
      }
      $accion=ObtenerIdAccionSeguimiento($direccion,$_GET['Accion']);     
      $numescritura=$_POST['numescritura'];
      $soporte=$_POST['finca'];
      $observaciones=$_POST['clavecatastral']; 
      
      $asunto="Se agrego al tramite de escritura finca y/o clave catastral";
      $msg="Al tramite de escritura con número:  ".$numescritura." se le agrego FINCA:".$soporte." y CLAVE CATASTRAL:".$observaciones;
      if(InsertSeguimientoEscritura($numescritura,$accion,$nitavu,"FINCA:".$soporte,"CLAVE CATASTRAL:". $observaciones)=='TRUE')
        { 
        
            $sql=" -- esc 
            UPDATE lotes  SET FechaUltimaMod=NOW(), IdEmpModifica=".$nitavu.", FINCA='".$soporte."', CVE_CATASTRAL='".$observaciones."' WHERE idlote=".$idlote;      
              
          //echo $sql;
          if ($Vivienda->query($sql) == TRUE)
          {
            historia($nitavu,'Esc_'.$msg);
            mensaje($msg ,$anterior);
          }
    
          else
          {
            $msg="Error inesperado ".$sql; //<-- Descripcion de error
          }
        }else{echo 'no entro a capturar finca';}   
    }

      /******************************* COMENTARIO DEL TRAMITE **************************************/ 
    if($_GET['Accion']==6)
    {
          $accion=0;          
          $numescritura=$_POST['numescritura'];
          $soporte=NULL;
          $observaciones=strtoupper ($_POST['ObservacionesComentario']);

          $asunto="Agrego comentario a tramite de escritura";
          $msg="Al tramite de escritura con número:  ".$numescritura." se le agregó el siguiente comentario:".$observaciones;
         
          if(InsertSeguimientoEscritura($numescritura,$accion,$nitavu,$soporte,$observaciones)=='TRUE')
            {          
              historia($nitavu,'Esc_'.$msg);
              mensaje('Se registró  con exito el comentario' ,$anterior);          
            }
            else
            {
              echo 'no entro a comentario';
            }
      }



  }
} 
else {mensaje("No tiene acceso a esta aplicacion",'');}

?>



<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>


<?php include ("./lib/body_footer.php"); ?>