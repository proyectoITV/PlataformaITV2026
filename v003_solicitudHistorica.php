<?php include ("./lib/body_head.php"); include ("./lib/body_menu.php"); ?>


<?php
require("config.php");
$id_aplicacion = 'ap101';
xd_update('ap101',$nitavu);//guarda la experiencia del usuario
echo "<div id='AppDetalle'>".app_detalle($id_aplicacion, $nitavu)."</div>";
//PROCESO PARA TOCAR LA PUERTA DE SAN PEDRO
$nivel =aplicacion_nivel($id_aplicacion, $nitavu);

if (sanpedro($id_aplicacion, $nitavu)==TRUE){



    //CREAR NUEVA SOLICITUD CON UN FOLIO ANTERIOR
    if(isset($_POST['IdPrograma']) and isset($_POST['IdDelegacion'])  and isset($_POST['nombreSolicitante']) and isset($_POST['apellidoMaterno']) and isset($_POST['IdDelegacion'])){
        $IdDelegacion = $_POST['IdDelegacion'];  
        $IdPrograma = $_POST['IdPrograma'];       
        $nombreSolicitante = $_POST['nombreSolicitante'];
        $apellidoPaterno = $_POST['apellidoPaterno'];
        $apellidoMaterno = $_POST['apellidoMaterno'];
        $curp = $_POST['curp'];
        // $IdSexo = $_POST['IdSexo'];
         $FechaNacimiento = $_POST['FechaNacimiento'];

        if (isset($_POST['FechaCaptura']))
        {            $FechaCaptura = $_POST['FechaCaptura'];        }else  {  $FechaCaptura = date("Y-m-d H:i:s");        }
        if (isset($_POST['IdSexo']))
        {$IdSexo = $_POST['IdSexo'];          
        }else {$IdSexo = "";}
      
        if ($IdSexo==1)
        {$sexo="M";          
        }else if ($IdSexo = "2")
        {
            $sexo="H";
        }
      
       //OBTENER FOLIO DE LA SOLICITUD EN LA BD DE ITAVU
        $Folio = IdSiguienteFolio($IdDelegacion, $IdPrograma);
      
       
        //OBTENEMOS EL IDSOLICITANTE 
        $idsolicitante = crearIdSolicitante($apellidoPaterno,$apellidoMaterno,$nombreSolicitante, $FechaNacimiento, $sexo, 28);

 //*******************************INICIO DE LLA CONSULTA PARA INSERTAR---------------------------------------------------------------------------------------------------------------------
 
$consulta = "CALL registrarSolicitud(
    '$nitavu',
    '$FechaCaptura',
    '$IdDelegacion',
    '',
    '',
    '$IdDelegacion',
    '$IdPrograma',
    '$Folio',
    '0',
    '', 
    0,
    '',
    '$idsolicitante',
    '$curp',
    '$nombreSolicitante',
    '$apellidoPaterno',
    '$apellidoMaterno',
    '$sexo',
    '$FechaNacimiento',
    '',
    '28',
    '',
    '',
    '',
    0,
    0,
    '',
    '',
    '',
    '',
    '',
    0,
    '',
    0,
    0,
    0,
    '',
    '',
    '',
    0,
    '',
    '',
    0,
    '',
    '0',
    '',
    '',
    '',
    '',
    0,
    '',
    '',
    '',
    '',
    '',
    '',
    '0',
    '0',
    '',
    '',
    '',
    '',
    '',
    '',
    '0',
    '0',
    '',
    '',
    '',
    '0',
    '',
    '',
    '0',
    '',
    '0',
    '0',
    '',
    '',
    '',
    '',
    '',
    '',
    '',
    '',
    '0',
    '0',
    '',
    '',
    '',
    '',
    '',
    '',
    '',
    '0',
    '',
    '',
    '',
    '',
    '',
    '',
    '',
    '',
    '0',
    '0',
    '0',
    '0',
    '0',
    '0',
    '0',
    '0',
    '0',
    '0',
    '0',
    '',
    '',
    '0',
    '',
    '',
    '',
    '',
    '',
    '',
    '',
    '',
    '',
    '0',
    '0',
    '0',
    '',
    '0',
    '0',
    '0',
    '',
    '0',
    '0',
    '0',
    '0',
    '0',
    '0',
    '0',
    '0',
    '0',
    '0',
    '0',
    '0',
    '0',
    '0',
    '',
    '',
    '0',
    '0',
    '0',
    '',
    '0',
    '0',
    '0',
    '0',
    '0',
    '0',
    '0',
    '0',
    '0',
    '0',
    '0',
    '0',
    '0',
    '',
    '',
    '',
    '',
    '',
    '',
    '',
    '',
    '0',
    '0',
    '0',
    '',
    '',
    '',
    '',
    '',
    '',
    '',
    '',
    '',
    '0',
    '0',
    '0',
    '',
    '',
    '',
    '',
    '',
    '0',
    '0',
    '0',
    '0',
    '0',
    '0',
    '',
    '',
    '0',
    '',
    '',
    '',
    '',
    '',
    '',
    '',
    '',
    '',
    '',
    '',
    '0',
    '0',
    '0',
    '0',
    '',
    '',
    '',
    '',
    '',
    '0',
    '0',
    '0',
    '0',
    '0',
    '0',
    '0',
    '0',
    '0',
    '0',
    '0',
    '0',
    '0',
    '0',
    '0',
    '0',
    '0',
    '0',
    '0',
    '0',
    '0',
    '0',
    '0',
    '0',
    '0',
    '0',
    '0',
    '0',
    '0',
    '0',
    '0',
    '0',
    '0',
    '0',
    '',
    '',
    '',
    '',
    '',
    '',
    '0',
    '',
    '0',
    '0',
    '0',
    '0',
    '0',
    '0',
    '0',
    '0',
    '0',
    '0',
    '',
    '0',
    '',
    '',
    '0',
    '0',
    '0',
    '',
    '0',
    '0',
    '0',
    '0',
    '0',
    '0',
    '0',
    'SOLICITUD HISTORICA',
    '0',
    '0',
    '0',
    '0',
    '0',
    '0',
    '0',
    '0',
    '0',
    '0',
    '0',
    '0',
    '0',
    @Resultado);";
    
    //echo $consulta;
       
       $rc= $Vivienda -> query($consulta);
       if($f = $rc -> fetch_array()){	

           
           if($f['Resultado']=="0"){
              // historia($nitavu, "Guarde los datos en vivienda de la solicitud ".$FolioTramite."");
             
            //    //echo $sql;
            //    if ($conexion->query($sql) == TRUE) {
            //       // historia($nitavu, " Actualice el folio de vivienda en la solicitud: ".$FolioTramite."");
            mensaje( 'Informacion guardada con éxito','v003.php');    
            //        return 'Se ha enviado el tramite';  
            //    }   
            //    else {

            //     // historia($nitavu, "No se actualizo el folio de vievienda en la solicitud ".$FolioTramite.", su folio es: ".$Folio."");
            //        return 'ERROR: No se ha podido actulizar el folio en el trámite.';
            //    }                                                                 
           }else if($f['Resultado']=="1"){
               //historia($nitavu, "No se guardaron los datos solicitante en la solicitud ".$FolioTramite."-consulta: ".$consulta."");     
               mensaje( 'ERROR: No se guardaron los datos del solicitante.','v003.php');    
                                                                           
               //$Continuo='FALSE';
           }else if($f['Resultado']=="2"){
              // historia($nitavu, "No se guardaron los datos de la solicitud en la solicitud ".$FolioTramite."-consulta: ".$consulta.""); 
              mensaje( 'ERROR: No se guardaron los datos de la solicitud.','v003.php');          
                                                   
           // $Continuo='FALSE';
           }else if($f['Resultado']=="3"){
              // historia($nitavu, "No se guardaron los datos del conyugeen en la solicitud ".$FolioTramite."-consulta: ".$consulta."");                                                                 
              mensaje( 'ERROR: No se guardaron los datos del conyuge.','v003.php');   
                                                           
               //$Continuo='FALSE';
           }else if($f['Resultado']=="4"){
               //historia($nitavu, "No se guardaron los datos empleo conyuge en la solicitud ".$FolioTramite."-consulta: ".$consulta."");                                                                 
               mensaje( 'ERROR: No se guardaron los datos empleo conyuge.','v003.php');  
                                                           
               //$Continuo='FALSE';
           }else if($f['Resultado']=="5"){
               //historia($nitavu, "No se guardaron los datos del domicilio en la solicitud ".$FolioTramite."-consulta: ".$consulta."");                                                                 
               mensaje('ERROR: No se guardaron los datos del domicilio.','v003.php');        
                                                       
               //$Continuo='FALSE';
           }else if($f['Resultado']=="6"){
               //historia($nitavu, "No se guardaron los datos del empleo solicitante en la solicitud ".$FolioTramite."-consulta: ".$consulta."");                                                                 
               mensaje('ERROR: No se guardaron los datos del empleo solicitante.','v003.php');         
                                                       
               //$Continuo='FALSE';
           }else if($f['Resultado']=="7"){
               //historia($nitavu, "No se guardaron los datos de la vivienda en la solicitud ".$FolioTramite."-consulta: ".$consulta."");                                                                 
               mensaje( 'ERROR: No se guardaron los datos de la vivienda.','v003.php');  
                                                           
               //$Continuo='FALSE';
           }else if($f['Resultado']=="8"){
               //historia($nitavu, "No se guardaron los datos estadistica fonhapoen el la solicitud ".$FolioTramite."-consulta: ".$consulta."");                                                                 
               mensaje( 'ERROR: No se guardaron los datos estadistica fonhapo.','v003.php');   
                                                           
               //$Continuo='FALSE';
           }else if($f['Resultado']=="9"){
               //historia($nitavu, "No se guardaron los datos evualuaciónen el la solicitud ".$FolioTramite."-consulta: ".$consulta."");                                                                 
               mensaje('ERROR: No se guardaron los datos evualuación.','v003.php');      
                                                       
           // $Continuo='FALSE';
           }else if($f['Resultado']=="10"){
              // historia($nitavu, "No se guardaron los datos de dependientes en la solicitud ".$FolioTramite."-consulta: ".$consulta."");                                                                 
              mensaje('ERROR: No se guardaron los datos de dependientes.','v003.php');  
                                                           
           
           }else if($f['Resultado']=="11"){
               ///historia($nitavu, " Ya existe un registro con estos datos de la solicitud ".$FolioTramite."-consulta: ".$consulta."");                                                                                                                                
               mensaje( 'ERROR: Ya existe un registro con estos datos, en este mismo programa.','v003.php');    
               
           }
       }
    




    /* 
        $sql = "-- Insert solicitudes
        INSERT INTO  solicitudes 
        (IdDelegacion, IdPrograma, Folio, Cancelado, CantidadDestinable, DomReferencia, EgresoMensual, Enviar, FechaCaptura, FechaEnvio,
        FechaModificacion, FechaUltimaMod, IdEmpCrea, IdEmpModifica, IdEstadoCivil, IdSituacionSol, IdSolicitante, IdSolicitud, NomReferencia,
        NumeroSol, OtrasPropiedades, TelReferencia, Credito_Desea, Plazo_Desea, Gts_Renta, Gts_Luz, Gts_Agua, Gts_Telefono,
        Gts_Alimentacion, Gts_Vestido, Gts_Transporte, Gts_Otros, Gts_Especifica, NIPNew, GtsEducacion, ReferenciaDos, ReferenciaDosDom,
        ReferenciaDosTel, EdadSol, IdMunSolLote, IdMunicipio, IdColonia, IdManzana, IdLote, IdUsoSuelo, NIPAnterior, Ahorro, IdRegimenSoc,
        Idtipoidentificacion, ArchivoFoto, clavebenefprog, SectorCateg, IdLiderDeColonia, eMail, OficioAutorizacion, Facebook, Twitter, OtroNumCelFamDirecto,
        IdMovRastreo, NumContratoExterno, OrigenDeEnvio, CapacidadPago,OriginData,Origen)
        VALUES ('".$IdDelegacion."','".$IdPrograma."','".$Folio."','False','','','','1',
        '".$FechaCaptura."', '','', '', '".$nitavu."', '', 0,'0','".$idsolicitante."', '','','0','','', '0', '0', 
        '0','','' '', '', '','','', '', '','', '', '', '', '', '','', '', '', '', '', '','',0,
        '', '','','','', '','', '', '', '', '', '', '',".$IdDelegacion.",'', ".$IdDelegacion.", ".$IdDelegacion.");";
            
        //echo $sql;
        //REGISTRAMOS LA SOLICITUD
        if ($Vivienda->query($sql) == TRUE){

            //REGISTRAMOS EL IDSOLICITANTE
                $sql2 = "INSERT INTO solicitantes (IdSolicitante, OrigenDeEnvio, Curp, Enviar, FechaCaptura, FechaEnvio, FechaUltimaMod, FNacimiento, IdEmpCrea, IdEmpModifica, IdOrigen, IdSexo, Materno, NCElector, Nombre, Paterno, RFC, nom, IdPersona, NIPNew, PersonaMoral, NacionalidadSol, LugarNacSol, IdTipoPersona, NipAnterior, NumeroActa, RazonSocial, NumPermiso)
                VALUES ('".$idsolicitante."',".$IdDelegacion.", '".$curp."','1','".$FechaCaptura."','','','".$FechaNacimiento."', 
                '".$nitavu."', '',28,".$IdSexo.",'".$apellidoMaterno."','','".$nombreSolicitante."', '".$apellidoPaterno."','','','','','', '','','','','','','');";

            echo $sql2;
            //REGISTRAMOS LA SOLICITUD
            if ($Vivienda->query($sql2) == TRUE){
               
                    //REGISTRAMOS DATOSEVALUACION
                        $sql3 = "INSERT INTO datosevaluacion(IdDelegacion, IdPrograma, Folio, AplicaGtsAdmon, Aprobado, CausasInaprob, ConfDependientes, ConfEmpleo, ConfEstadoConst, ConfFacultadConst, ConfIngreso, ConfOtraProp, ConfReferencia, ConfResidencia, 
                        ContratoMaestro, DiasdeGracia, Enviar, F_GtsAdmon, FechaCaptura, FechaEnvio, FechaEvaluacion, FechaUltimaMod, GtsAdmon, I_GtsAdmon, IdConceptoCargo, IdEmpCrea, IdEmpEvaluador, IdEmpModifica, IdPagoInicial, IdTipoMoneda, IdTipoPago, 
                        Ministracion1, Ministracion2, Ministracion3, MontoCredito, MontoIntMora, MontoPago, MontoPagoInicial, MontoUltimoPago, NCertSubsidioF, NCertSubsidioI, Notificada, Observaciones, OtroCargo, PeriodoMora, PGtsAdmon, RBeneficiario, RFonhapo, 
                        RItavu, SegurodeVida, SubsidioFonhapo, SubsidioItavu, TasaAnualFin, TasaIntMora, TipoIntMoratorio, TotalPagos, MontoEscrituracion, NopropiedadCon, AsignaMandato, AsignaItavu, AsignaInvasion, IngSuficiente, IdEstatusSolicitud, TiempoMinimoAhorro, 
                        IdCertificado, DocumentacionPresentada, IdMovRastreo, OrigenDeEnvio )
                        VALUES ('".$IdDelegacion."','". $IdPrograma."','".$Folio."',0, 1,'', '0','0','0','0','0','0','0','0','', 0, '1','','".
                        $FechaCaptura."', '', '".$FechaCaptura."', '', '0', '0', '', '".$nitavu."','".
                        $nitavu."', '', '0', '0', '0','0', '0', '0', '0', '0', ' ','0', ' ',0, 0, ' ','', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0,0, '','','','','',0, '','','','',".
                        $IdDelegacion.");";
        
                    //echo $sql3;                   
                    if ($Vivienda->query($sql3) == TRUE){            
                         mensaje('Solicitud Historica guardada correctamente','v003.php');
                    }
                    else
                    {
                        ////ELIMINAMOS SOLICITUD
                        $sql4 = "delete  from solicitudes where IdDelegacion=".$IdDelegacion." and IdPrograma=".$IdPrograma." and Folio=".$Folio;
                        //echo $sql4;
                         if ($Vivienda->query($sql4) == TRUE){
                                    ////ELIMINAMOS  SOLICITANTE 
                                $sql5 = "delete  from solicitantes where IdSolicitante='".$idsolicitante."'";
                                //echo $sql5;
                                if ($Vivienda->query($sql5) == TRUE){

                                }
                                else
                                {//ELIMINAMOS LA SOLCIITUD QUE ACABAMOS DE INSERTAR
                                echo "Error al eliminar al solicitante";
                                }
                            mensaje('ERROR: al momento de registrar datos evaualuacion, favor de intentarlo nuevamente.','v003.php');
                         }
                         else
                         {//ELIMINAMOS LA SOLCIITUD QUE ACABAMOS DE INSERTAR
                           echo "Error al eliminar la soliciud";
                         }
                        mensaje('ERROR: al momento de registrar datos evaualuacion, favor de intentarlo nuevamente.','v003.php');
                    }
            }else
            {
               
                $sql3 = "delete  from solicitudes where IdDelegacion=".$IdDelegacion." and IdPrograma=".$IdPrograma." and Folio=".$Folio;
                echo $sql3;
                if ($Vivienda->query($sql3) == TRUE){
                }
                else
                {//ELIMINAMOS LA SOLCIITUD QUE ACABAMOS DE INSERTAR
                  echo "Error al eliminar la soliciud";
                }
               
                mensaje('ERROR: al momento de registrar al solicitante, favor de intentarlo nuevamente.'.$Vivienda->error,'v003.php');
            }



             }else{
            
         
          
            mensaje('ERROR: al momento de registrar un solicitud, favor de intentarlo nuevamente.','v003.php');
        }
         */


        
    }else{
        mensaje("No se recibieron los datos correctamete",);
    }
    
    
    

   








}else{
    mensaje("No tiene acceso a ".$id_aplicacion,'');
}

?>

<?php include ("./lib/body_footer.php"); ?>