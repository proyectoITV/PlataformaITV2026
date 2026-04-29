<?php

include ("./lib/body_head.php"); include ("./lib/body_menu.php");
require_once('seguridad.php');
require_once('pdf/tcpdf.php');
//$nitavu="2809";
require_once("config.php");
require_once("lib/funciones.php");
require_once("lib/flor_funciones.php");
require_once("lib/yes_funciones.php");
error_reporting(0);


if (isset($_GET['NumContrato'])) {  
  
  

    $idtipousosuelo=$_POST['usodesuelo'];
    $costoescritura=$_POST['costoescritura'];
    $observaciones=$_POST['observaciones'];
    $causahabientemenor=$_POST['causahabientemenor'];
    $causahabiente=$_POST['causahabiente'];
    $numcontrato=$_GET['NumContrato']; 
    $descuentoesc=$_POST['descuentoescritura']; 
    $saldoesc=  $_POST['saldoescritura']; 
    $numescritura="";
    $nombre="";;
    $lugarnacsol="";
    $FNacimiento="";
    $domicilio="";
    $ocupacion="";
    $sexo="";
    $seccion="";
    $fila="";
    $manzana="";
    $lote="";
    $superficie="";
    $col1="";
    $conquien1="";
    $col2="";
    $conquien2="";
    $col3="";
    $conquien3="";
    $col4="";
    $conquien4="";
    $estadocivil="";
    $municipio="";
    $colonia="";        
    $nombreconyuge="";   
    $ocupacionconyuge="";   
    $idlote="";
    $directoradmon="";
    $directorsuelo="";
    $delegado="";
    $correccion_saldo_negativo=0;


    
    $nummov=0;    
    $idempmodificaContrato="";
    $fechaultimamodContrato="";
    $fechaultimamodControlContrato="";
    $idempmodificaControlContrato="";
    $estatausCuentaControlContratos = "";
    

    $sql="Select * from vivienda_informacioncontratos where numcontrato='".$numcontrato."'";

    $rc= $Vivienda -> query($sql);
    $row_cnt = $rc->num_rows;
        
        if($row_cnt>0)
        {
          while($datos = $rc -> fetch_array())
          {
            
            $numescritura=strtoupper($datos['NumEscritura']);
            $nombre=strtoupper($datos['NombreCompleto']);
            $lugarnacsol=strtoupper($datos['LugarNac']);
            $FNacimiento=strtoupper($datos['FNacimiento']);
            $domicilio=strtoupper($datos['Domicilio_Calle']);
            $ocupacion=strtoupper($datos['ocupacion']);
            $sexo=strtoupper($datos['sexo']);
            $seccion=strtoupper($datos['seccion']);
            $fila=strtoupper($datos['fila']);
            $manzana=strtoupper($datos['manzana']);
            $lote=strtoupper($datos['lote']);
            $superficie=strtoupper($datos['superficie']);
            $col1=strtoupper($datos['colin1']);
            $conquien1=strtoupper($datos['con_quien1']);
            $col2=strtoupper($datos['colin2']);
            $conquien2=strtoupper($datos['con_quien2']);
            $col3=strtoupper($datos['colin3']);
            $conquien3=strtoupper($datos['con_quien3']);
            $col4=strtoupper($datos['colin4']);
            $conquien4=strtoupper($datos['con_quien4']);
            $estadocivil=strtoupper($datos['estadocivil']);
            $municipio=strtoupper($datos['MunicipioL']);
            $colonia=strtoupper($datos['ColoniaL']);           
            $nombreconyuge=strtoupper($datos['conyuge']);     
            $ocupacionconyuge=strtoupper($datos['ocupacioncon']);      
            $idlote=$datos['IdLote'];
          }   
       
        }
        $usodesuelo=UsoDeSuelo($idtipousosuelo);
        $preciolote=PrecioLotes($idlote);  
        $costoescritura1=str_replace(',','',$costoescritura); // SE QUITA LA COMA DE LA CANTIDAD PARA QUE PUEDA ALMACENARSE EN LA BASE DE DATOS.  
        $sql="Select * from version";
        $rc= $Vivienda -> query($sql);
        $row_cnt = $rc->num_rows;
            
            if($row_cnt>0)
            {
              while($datos = $rc -> fetch_array())
              {
                
                $directoradmon=strtoupper($datos['DirectorDeAdministracionyFinanzas']);
                $directorsuelo=strtoupper($datos['DirectorDeProgramasySuelo']);

            }
            }


          $iddelegacion=IdDelegacionNumContrato($numcontrato);
          $idprograma=IdProgramaNumContrato($numcontrato);
          $sql="Select * from delegaciones where iddelegacion=".$iddelegacion;
          $rc= $Vivienda -> query($sql);
          $row_cnt = $rc->num_rows;
              
              if($row_cnt>0)
              {
                while($datos = $rc -> fetch_array())
                {
                  $delegado=strtoupper($datos['NombreDel']).' '.strtoupper($datos['paternoDel']).' '.strtoupper($datos['MaternoDel'] );
                  $resAreaTecDel=strtoupper($datos['ResponsableAreaTecnica']);
                  $resAreaAdmonDel=strtoupper($datos['ResponsableAreaAdmon']);
              }
            }




  /***************************** GRABAR INFORMACION DEL LOTE  *******************************/
  $iddelegacion=str_pad($iddelegacion, 2, "0", STR_PAD_LEFT);
  $iddelegacion1=str_pad($iddelegacion, 2, "0", STR_PAD_LEFT);
  $idprograma=str_pad($idprograma, 2, "0", STR_PAD_LEFT);
  $versionplano=ObtenerVersionPlanoLotes($idlote);
  $versionplano=str_pad($versionplano, 2, "0", STR_PAD_LEFT);
  $numescritura= $iddelegacion.  $idprograma.$idlote.$versionplano;
  $sqllote="Update lotes set NumEscritura='".$numescritura."' , IdUsoDeSuelo=".$idtipousosuelo.", CVE_CATASTRAL='".$clave_catastral."', FechaUltimaMod=now() where IdLote='".$idlote."'";
   //echo $sqllote;
    if ($Vivienda->query($sqllote) == TRUE){
    
      /********************* GRABAR INFORMACION EN TABLA CONTRATOS  *****************************/       
      $exigirSaldoTerreno=ExigirSaldoTerreno($idlote);       
        if($exigirSaldoTerreno==0)
        {   $costoescritura1=str_replace(',','',$costoescritura);   }
        else
        {   $costoescritura1=0;}
      
          //OBTENEMOS LOS DATOS QUE TIENE LA TABLA CONTRATOS PARA EN CASO DE QUE HAYA ERROR REGRESAR A LOS MISMOS VALORES
          $sqlcontratosant = "SELECT * from contratos WHERE NumContrato = '" .$numcontrato. "'";         
          $r = $Vivienda -> query( $sqlcontratosant);        
              

          while($fx = $r -> fetch_array()) {  
              $idempmodificaContrato = $fx['IdEmpModifica'];
              $fechaultimamodContrato = $fx['FechaUltimaMod'];
           
             
          }
          
          $sqlcontrato="Update contratos set MontoEscrituracion='".$costoescritura1."', FechaUltimaMod=now() where NumContrato='".$numcontrato."'";
          
            if ($Vivienda->query($sqlcontrato) == TRUE){
             
                                   
                //historia($nitavu, 'se actualizó de manera correcta los datos de la solicitud en la tabla contratos');
               
                /********************* GRABAR INFORMACION EN TABLA MOVESCRITURAS  *****************************/            
                  $sqlmov="Insert into movescrituras set NumEscritura='".$numescritura."' , IdDelegacion='".$iddelegacion."', IdPrograma='".$idprograma." ', Idlote='".$idlote."',FechaEmision=now() ,
                  Persona1='".$causahabiente."', Persona2='".$causahabientemenor."' ,NomDirectorTecnico='".$directorsuelo."', ResponsableTecnico='".$resAreaTecDel."', NomDirectorFinanzas='".$directoradmon."',
                  ResponsableFinanzas='".$resAreaAdmonDel."', AtendidoPor='".$nitavu."',AprobadoPor='".$delegado."', FechaCaptura=now(), MontoEscrituracion='".$costoescritura1."', Observaciones='".$observaciones."',
                  Cancelado=0, FechaUltimaMod=now(), IdEmpModifica='".$nitavu."', Plazos=1";
                  // echo $sqlmov;
                    if ($Vivienda->query($sqlmov) == TRUE){                  
                    
                         /********************* GRABAR INFORMACION EN TABLA SEGUIMIENTO  *****************************/    
                         $idconsecutivo= CalculaMaximo("seguimiento", "IdConsecutivo", " And IdElemento = '" .$numescritura. "'", "", "");
                          $consecutivo= CalculaMaximo("seguimiento", "Consecutivo", "", "", "");
                          $sqlseg="Insert into seguimiento(IdElemento, Origen, IdConsecutivo, Consecutivo, IdDelegacion, IdAccion, IdOperador, FechaOperacion, FechaRegistro, Observaciones, Estatus, Enviar, FechaUltimaMod)
                          values('$numescritura', 'D','$idconsecutivo','$consecutivo','$iddelegacion',0,'$nitavu',NOW(),NOW(),'Creación de solicitud de escritura','A',1,NOW())";
                           //echo $sqlseg;
                            if ($Vivienda->query($sqlseg) == TRUE){  
                            
                              /********************* GRABAR INFORMACION EN TABLA HISTORIAL MOVESCRITURAS  *****************************/   
                              $idconsecutivomov= CalculaMaximo("historialmovescrituras", "IdConsecutivo", " And NumEscritura = '" .$numescritura. "'", "", "");
                              $sqlhist=" INSERT INTO historialmovescrituras (NumEscritura  ,IdConsecutivo ,Estatus   ,IdDelegacion  ,IdPrograma  ,idlote   ,FechaEmision ,MontoEscrituracion  ,Plazos ,AtendidoPor ,Cancelado ,Enviar ,FechaCaptura ,
                              Persona1 ,Persona2,NomDirectorTecnico,ResponsableTecnico ,NomDirectorFinanzas ,ResponsableFinanzas,AprobadoPor,Observaciones , FechaInsert)
                              SELECT NumEscritura  ,'$idconsecutivomov' ,'A'   ,IdDelegacion  ,IdPrograma  ,idlote   ,FechaEmision ,MontoEscrituracion  ,Plazos ,AtendidoPor ,Cancelado ,Enviar ,FechaCaptura ,
                              Persona1 ,Persona2,NomDirectorTecnico,ResponsableTecnico ,NomDirectorFinanzas ,ResponsableFinanzas,AprobadoPor,Observaciones , NOW() FROM movescrituras where NumEscritura='".$numescritura."'";                            
                              //echo  '<br>'.$sqlhist;
                                if ($Vivienda->query($sqlhist) == TRUE){ 
                                /********************* GRABAR INFORMACION EN TABLA CONTROL CONTRATOS  *****************************/  
                                
                                
                                   //OBTENEMOS LOS DATOS QUE TIENE LA TABLA CONTROLCONTRATOS PARA EN CASO DE QUE HAYA ERROR REGRESAR A LOS MISMOS VALORES
                                  $sql = "SELECT * from controlcontratos WHERE NumContrato = '" .$numcontrato. "'";
                                  $r = $Vivienda -> query($sql); 
                                  echo $sql;
                                         

                                  while($f = $r -> fetch_array()) {                      
                                      $estatausCuentaControlContratos = $f['EstatusCuenta'];
                                      $idempmodificaControlContrato = $f['IdEmpModifica'];
                                      $fechaultimamodControlContrato = $f['FechaUltimaMod'];                   

                                  }        
               

                                //Se actualiza control contratos para poner la cuenta como con saldo  
                                $fechaProximoCorteAnterior=FechaProximoCorteControlContratos($numcontrato) ;                       
                                $sqlctrl="UPDATE controlcontratos set EstatusCuenta=2, FechaProximoCorte=DATE_ADD(CURDATE() ,INTERVAL 30 DAY) where NumContrato='".$numcontrato."'";                            
                                //echo  '<br>'. $sqlctrl;                             
                                  if ($Vivienda->query($sqlctrl) == TRUE){  
                                      /********************* GRABAR INFORMACION EN TABLA HISTORICOPAGOS *****************************/                                                                                                
                                    $saldo=0;//VerificarSaldoNegativo($numcontrato);    
                                    $nummov=NumMov($numcontrato); 
                                    $sql = "SELECT  * from historicopagos  WHERE NumContrato = '" . $numcontrato . "'  AND NumMov = " . $nummov . " ";		
                                    //echo  $sql;
                                    $r = $Vivienda -> query($sql); 
                                    while($f = $r -> fetch_array()) {   
                                      
                                        $RezGts=$f['NuevoRezGts'];
                                        $RezGtsCubierto= 0;
                                        $GtsPeriodo= 0;
                                        $GtsPeriodoCubiertos= 0;
                                        $RezSeg=$f['NuevoRezSeg'];
                                        $RezSegCubierto= 0;
                                        $SegPeriodo= 0;
                                        $SegPeriodoCubierto= 0;
                                        $RezOtrosGts= $f['NuevoRezOtrosGts'];
                                        $RezOtrosGtsCubierto= 0;
                                        $OtrosGtsPeriodo= 0;
                                        $OtrosGtsPeriodoCubierto= 0;
                                        $RezMoratorios=  $f['NuevoRezMoratorios'];
                                        $RezMoratoriosCubierto= 0;
                                        $MoratoriosPeriodo= 0;
                                        $RezFinanc=  $f['NuevoRezFinanc'];
                                        $RezFinancCubierto= 0;
                                        $FinancPeriodo= 0;
                                        $FinancPeriodoCubierto= 0;
                                        $RezCapital=  $f['NuevoRezCapital'];
                                        $RezCapitalCubierto= 0;
                                        $CapitalPeriodoCubierto= 0;
                                        $AplicadoExcedente= 0;
                                        //$saldoexento=  parseFloat($f['saldoexento'])+parseFloat($costoescritura1);
                                        $SaldoCapitalCorriente=  $f['SaldoCapitalCorriente'];
                                        $FechaCorte=  $f['FechaCorte'];
                                    
                                        $NuevoRezGts=$f['NuevoRezGts'];
                                        $NuevoRezSeg=$f['NuevoRezSeg'];
                                        $NuevoRezMoratorios=$f['NuevoRezMoratorios'];
                                        $NuevoRezFinanc=$f['NuevoRezFinanc'];
                                        $NuevoRezCapital=$f['NuevoRezCapital'];
                                        $NuevoRezOtrosGts=$f['NuevoRezOtrosGts'];
                                        //$CapitalPeriodo=$costoescritura1;
                                        $TipoMov=10;
                                        $Origen=$f['Origen'];
                                        $OriginData=$f['OriginData'];
                                     
                                  //'se verifica si el saldo de la cuenta es negativo para aplicar (en caso de que proceda) las correcciones sobre los montos de los descuentos mas adelante
                                   if(((float)$NuevoRezFinanc+(float)$NuevoRezCapital+(float)$NuevoRezOtrosGts+(float)$NuevoRezGts+(float)$NuevoRezSeg+(float)$NuevoRezMoratorios+(float)$Saldocapitalcorriente+(float)$SaldoExento)<0)
                                  {
                                    $correccion_saldo_negativo=((float)$NuevoRezFinanc+(float)$NuevoRezCapital+(float)$NuevoRezOtrosGts+(float)$NuevoRezGts+(float)$NuevoRezSeg+(float)$NuevoRezMoratorios+(float)$Saldocapitalcorriente+(float)$SaldoExento);
                                  }else
                                  {
                                    $correccion_saldo_negativo=0;
                                  }
                                    
                                  //si el cargo y el descuento son iguales
                                 //entonces se inserta cargo CERO a la escritura
                                  if(($costoescritura1>0) and ($descuentoesc>0) and $costoescritura1==$descuentoesc)
                                  {
                                    $CapitalPeriodo=0;
                                    $saldoexento=$f['saldoexento'];

                                  }else
                                  {  if($costoescritura1 >= 0)
                                    {
                                      $CapitalPeriodo=$costoescritura1;
                                      $saldoexento= (float)$f['saldoexento']+(float)$costoescritura1;
                                     
                                    }

                                  }

                                }
                               
                                      $sqlhistpgs="INSERT INTO historicopagos (NumContrato	,NumMov	,MontoPagoRecibido	,FechaOperacion	,FechaCorte	,FechaInicia	,FechaTermina	,RezGts	,RezGtsCubierto	,GtsPeriodo	,GtsPeriodoCubiertos	,NuevoRezGts	,RezSeg	,RezSegCubierto	,SegPeriodo	,SegPeriodoCubierto	,NuevoRezSeg	,RezOtrosGts	,
                                      RezOtrosGtsCubierto	,OtrosGtsPeriodo	,OtrosGtsPeriodoCubierto	,NuevoRezOtrosGts	,RezMoratorios	,RezMoratoriosCubierto	,MoratoriosPeriodo	,NuevoRezMoratorios	,RezFinanc	,RezFinancCubierto	,FinancPeriodo	,FinancPeriodoCubierto	,NuevoRezFinanc	,RezCapital	,RezCapitalCubierto	,CapitalPeriodo
                                      ,CapitalPeriodoCubierto	,NuevoRezCapital	,AplicadoExcedente	,SaldoCapitalCorriente	,Origen	,TipoMov	,Observaciones	,Enviar	,IdEmpCrea	,IdEmpModifica	,FechaCaptura	,FechaUltimaMod	,FechaEnvio	,saldoexento	,ImpSF002	,FechaImpSF002	,FechaReimSF002
                                      ,ReferenciaOpd	,RefBancariaOpd	,IdMovDesc	,Observacion2	,IdFormaPago	,IdSupervisor	,OrigenDeEnvio	,Cancelado	,NumMovErroneo, OriginData)
                                      
                                      VALUES ('".$numcontrato."',".($nummov+1).",'0' ,NOW(),'".$FechaCorte."',0,0,'".$RezGts."','". $RezGtsCubierto.
                                            "','".$GtsPeriodo."','".$GtsPeriodoCubiertos."','".$NuevoRezGts."','".$RezSeg."','".$RezSegCubierto."','".$SegPeriodo."','".$SegPeriodoCubierto."','".$NuevoRezSeg."','".
                                            $RezOtrosGts."','".$RezOtrosGtsCubierto."','".$OtrosGtsPeriodo."','".$OtrosGtsPeriodoCubierto."','".$NuevoRezOtrosGts."','".$RezMoratorios."','".$RezMoratoriosCubierto.
                                            "','".$MoratoriosPeriodo."','".$NuevoRezMoratorios."','".$RezFinanc."','".$RezFinancCubierto."','".$FinancPeriodo."','".$FinancPeriodoCubierto."','".$NuevoRezFinanc."','".
                                            $RezCapital."','".$RezCapitalCubierto."','".$CapitalPeriodo."','".$CapitalPeriodoCubierto."','".$NuevoRezCapital."','".$AplicadoExcedente."','".$SaldoCapitalCorriente."',
                                            '".$Origen."',10,'0',1,'".$nitavu."',0,NOW()	,0,0,'".$saldoexento
                                            ."',0,0,0,0,0,0,'',0,0,".$iddelegacion.",0,0,".$iddelegacion.")";                                  
                                   // echo $sqlhistpgs;                          
                                  
                                   if ($Vivienda->query($sqlhistpgs) == TRUE)
                                   {        
                                    
                                    //Si el cargo de la escritura tiene derecho a un descuento pero el descuento no cubre el total del cargo de la escritura,
                                    // se anexa la autorizacion del descuento para que dicho descuento se aplique al recibir el pago de la escritura
                                    if((float)$costoescritura1>0 and (float)$descuentoesc>0 and (float)$costoescritura1>(float)$descuentoesc)
                                    {
                                      // se calcula el consecutivo siguiente de descuento para guardar
                                      $IdDescuentoSig = siguienteIdAutorizaDescuentos();
                                      //Buscamos descuentos anteriores para actualizarlos a falso
                                      $sql="UPDATE autorizaciondescuentos SET activo=0,enviar=1,idempmodifica=".$nitavu." , fechaultimamod=now() WHERE NumContrato='".$numcontrato."'";
                                      echo $sql;
                                      if ($Vivienda->query($sql) == TRUE){ 
                                         $sql3="INSERT INTO  autorizaciondescuentos (NumContrato, FechaCaptura, IdEmpAutoriza, MontoDescuento, MinimoRequiereAbonar, SustentoAutorizacion, Vigencia, FechaAplicacion, Activo, 
                                         TipoDescuento, Enviar, IdEmpCrea, IdEmpModifica, FechaUltimaMod, FechaEnvio, IdMovDesc, OrigenDeEnvio)
                                         VALUES ('".$numcontrato."', now(), '".$nitavu."', '".$descuentoesc."', '".((float)($saldoesc)+(float)($correccion_saldo_negativo))."', 'Descuento autorizado sobre costo de escritura', '".$vigencia."', '', 1, '40', 1, '".$nitavu."', '', '', '', '".$IdDescuentoSig."','')";
                                         // echo $sql3;
                                          if ($Vivienda->query($sql3) == TRUE){                                          
                                            //historia($nitavu, 'Se ha guardado el descuento con éxito','autorizaDescuento');
                                             
                                          }else{
                                            
                                         //historia($nitavu, 'Ocurrio un error al intentar guardar el descuentos');
                                         $sqlEliminar="CALL sp_EliminarRegistrosEscrituracion('$numcontrato','$numescritura','$nummov','$idlote','$idempmodificaContrato','$fechaultimamodContrato','$fechaultimamodControlContrato','$idempmodificaControlContrato','$idconsecutivo','$consecutivo','$idconsecutivomov');";
                                         if ($Vivienda->query($sqlEliminar) == TRUE){  
                                         
                                           // historia($nitavu, 'ERROR: al actualizar la informacion de la solicitud en la tabla lotes');
                                             mensaje("ERROR 8: al guardar la solicictud de escritura","esc.php?NumContrato=".$numcontrato);
                                           
                                         }else{
                                         //historia($nitavu, 'ERROR: al actualizar la informacion de la solicitud en la tabla lotes');
                                           mensaje("ERROR 8: al guardar la solicictud de escritura","esc.php?NumContrato=".$numcontrato);
                                       }
                                            
                                          }
                                      }
                                    }  
                                      historia($nitavu, 'Se ha guardado el tramite de escritura con exito con éxito','autorizaDescuento'); 
                                      mensaje("Solicitud guardad con exito","esc.php?NumContrato=".$numcontrato);                        
                                      echo "<script> window.open('formatoSolicitudEscritura.php?NumContrato=".$numcontrato."&sol'); </script>";
                                    }else
                                    {
                                     
                                      //historia($nitavu, 'ERROR: al actualizar la informacion de la solicitud en la tabla HistoricoPagos');
                                        $sqlEliminar="CALL sp_EliminarRegistrosEscrituracion('$numcontrato','$numescritura','$nummov','$idlote','$idempmodificaContrato','$fechaultimamodContrato','$fechaultimamodControlContrato','$idempmodificaControlContrato','$idconsecutivo','$consecutivo','$idconsecutivomov');";
                                       
                                        if ($Vivienda->query($sqlEliminar) == TRUE){  
                                      
                                        // historia($nitavu, 'ERROR: al actualizar la informacion de la solicitud en la tabla lotes');
                                          mensaje("ERROR 7: al guardar la solicictud de escritura","esc.php?NumContrato=".$numcontrato);
                                        
                                      }else{
                                      //historia($nitavu, 'ERROR: al actualizar la informacion de la solicitud en la tabla lotes');
                                        mensaje("ERROR 7: al guardar la solicictud de escritura","esc.php?NumContrato=".$numcontrato);
                                    }
                                    }                                   
                                    
                                  }else
                                  {
                                    //historia($nitavu, 'ERROR: al actualizar la informacion de la solicitud en la tabla ControlContatos');
                                      $sqlEliminar="CALL sp_EliminarRegistrosEscrituracion('$numcontrato','$numescritura','$nummov','$idlote','$idempmodificaContrato','$fechaultimamodContrato','$fechaultimamodControlContrato','$idempmodificaControlContrato','$idconsecutivo','$consecutivo','$idconsecutivomov');";
                                    if ($Vivienda->query($sqlEliminar) == TRUE){  
                                    
                                      // historia($nitavu, 'ERROR: al actualizar la informacion de la solicitud en la tabla lotes');
                                        mensaje("ERROR 6: al guardar la solicictud de escritura","esc.php?NumContrato=".$numcontrato);
                                      
                                    }else{
                                    //historia($nitavu, 'ERROR: al actualizar la informacion de la solicitud en la tabla lotes');
                                      mensaje("ERROR 6: al guardar la solicictud de escritura","esc.php?NumContrato=".$numcontrato);
                                  }
                                  }   
                                 }
                               else
                                {
                                  //historia($nitavu, 'ERROR: al actualizar la informacion de la solicitud en la tabla HistorialMovEscrituras');
                                    $sqlEliminar="CALL sp_EliminarRegistrosEscrituracion('$numcontrato','$numescritura','$nummov','$idlote','$idempmodificaContrato','$fechaultimamodContrato','$fechaultimamodControlContrato','$idempmodificaControlContrato','$idconsecutivo','$consecutivo','$idconsecutivomov');";
                                  if ($Vivienda->query($sqlEliminar) == TRUE){  
                                  
                                    // historia($nitavu, 'ERROR: al actualizar la informacion de la solicitud en la tabla lotes');
                                      mensaje("ERROR 5: al guardar la solicictud de escritura","esc.php?NumContrato=".$numcontrato);
                                    
                                  }else{
                                  //historia($nitavu, 'ERROR: al actualizar la informacion de la solicitud en la tabla lotes');
                                    mensaje("ERROR 5: al guardar la solicictud de escritura","esc.php?NumContrato=".$numcontrato);
                                }
                                }

                            }else
                            {
                              //historia($nitavu, 'ERROR: al actualizar la informacion de la solicitud en la tabla Seguimiento');
                                $sqlEliminar="CALL sp_EliminarRegistrosEscrituracion('$numcontrato','$numescritura','$nummov','$idlote','$idempmodificaContrato','$fechaultimamodContrato','$fechaultimamodControlContrato','$idempmodificaControlContrato','$idconsecutivo','$consecutivo','$idconsecutivomov');";
                                if ($Vivienda->query($sqlEliminar) == TRUE){  
                              
                                // historia($nitavu, 'ERROR: al actualizar la informacion de la solicitud en la tabla lotes');
                                  mensaje("ERROR 4: al guardar la solicictud de escritura","esc.php?NumContrato=".$numcontrato);
                                
                              }else{
                              //historia($nitavu, 'ERROR: al actualizar la informacion de la solicitud en la tabla lotes');
                                mensaje("ERROR 4: al guardar la solicictud de escritura","esc.php?NumContrato=".$numcontrato);
                            }
                            }

                    }else{
                        //historia($nitavu, 'ERROR: al actualizar la informacion de la solicitud en la tabla MovEscrituras');
                        //mensaje("ERROR: al guardar la solicictud de escritura","esc.php?NumContrato=".$numcontrato);
                          $sqlEliminar="CALL sp_EliminarRegistrosEscrituracion('$numcontrato','$numescritura','$nummov','$idlote','$idempmodificaContrato','$fechaultimamodContrato','$fechaultimamodControlContrato','$idempmodificaControlContrato','$idconsecutivo','$consecutivo','$idconsecutivomov');";
                          echo  $sqlEliminar;
                          if ($Vivienda->query($sqlEliminar) == TRUE){  
                      
                        // historia($nitavu, 'ERROR: al actualizar la informacion de la solicitud en la tabla lotes');
                          mensaje("ERROR 3: al guardar la solicictud de escritura","esc.php?NumContrato=".$numcontrato);
                        
                      }else{
                      //historia($nitavu, 'ERROR: al actualizar la informacion de la solicitud en la tabla lotes');
                        mensaje("ERROR 3: al guardar la solicictud de escritura","esc.php?NumContrato=".$numcontrato);
                    }
                    }

            }else{
             
                //historia($nitavu, 'ERROR: al actualizar la informacion de la solicitud en la tabla contratos');
              // mensaje("ERROR: al guardar la solicictud de escritura","esc.php?NumContrato=".$numcontrato);
              $sqlEliminar="CALL sp_EliminarRegistrosEscrituracion('$numcontrato','$numescritura','$nummov','$idlote','$idempmodificaContrato','$fechaultimamodContrato','$fechaultimamodControlContrato','$idempmodificaControlContrato','$idconsecutivo','$consecutivo','$idconsecutivomov');";
            
              if ($Vivienda->query($sqlEliminar) == TRUE){  
                 // historia($nitavu, 'ERROR: al actualizar la informacion de la solicitud en la tabla lotes');
                   mensaje("ERROR 2: al guardar la solicictud de escritura","esc.php?NumContrato=".$numcontrato);
                 
              }else{
               //historia($nitavu, 'ERROR: al actualizar la informacion de la solicitud en la tabla lotes');
                mensaje("ERROR 2: al guardar la solicictud de escritura","esc.php?NumContrato=".$numcontrato);
            }
          }
       
    }else{
        $sqlEliminar="CALL sp_EliminarRegistrosEscrituracion('$numcontrato','$numescritura','$nummov','$idlote','$idempmodificaContrato','$fechaultimamodContrato','$fechaultimamodControlContrato','$idempmodificaControlContrato','$idconsecutivo','$consecutivo','$idconsecutivomov');";
      if ($Vivienda->query($sqlEliminar) == TRUE){ 
      // historia($nitavu, 'ERROR: al actualizar la informacion de la solicitud en la tabla lotes');
      mensaje("ERROR 1: al guardar la solicictud de escritura","esc.php?NumContrato=".$numcontrato);

      }else{
      //historia($nitavu, 'ERROR: al actualizar la informacion de la solicitud en la tabla lotes');
      mensaje("ERROR 1: al guardar la solicictud de escritura","esc.php?NumContrato=".$numcontrato);

      }
    
    
}


  


}else{
  $tabla="No existe informacion";
}



?>