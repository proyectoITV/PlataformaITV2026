<?php
include ("lib/body_head.php");
?>

<?php
    require("plantilla-core.php");
$id_aplicacion ="ap113"; 
$nivel = aplicacion_nivel($id_aplicacion, $nitavu);

if (sanpedro($id_aplicacion, $nitavu)==TRUE){
    echo "<div id='AppDetalle'>".app_detalle($id_aplicacion, $nitavu)."</div>";        
    xd_update($id_aplicacion,$nitavu); historia($nitavu, $id_aplicacion." | Entro a contratación");
    echo "<br><br>";

    if(isset($_GET['delegacion']) and isset($_GET['programa']) and isset($_GET['folio'])){
        $IdDelegacion = $_GET['delegacion'];
        $IdPrograma = $_GET['programa'];
        $Folio = $_GET['folio'];
        $nitavu = $_GET['nitavu'];
        $del =  midelegacion_id($nitavu); //ojo  aqui deberia de ser de la solcitud

        if (postBlock($_POST['postID'])) {
            // No existe doble post
            // Procesamos la informaciÃ³n
        } else {
            // Doble post, no procesamos el form
            mensaje('No es posible enviar la información nuevamente','contratarCredito.php?_folio='.$Folio.'&programa='.$IdPrograma.'&delegaciones='.$IdDelegacion);        
            return;
        }
      
       //VARIABLES

       //Fonhapo
        $AportacionFonhapo = $_POST['aportacion'];
        $SubsidioFonhapo = $_POST['subsidiofonhapo'];
        $GtsAdmonFonhapo = $_POST['gastosadmonfonhapo'];
        $ncertificadofonhapo=$_POST['ncertificado'];

        //itavu
        $AportacionItavu = $_POST['aportacionitavu'];
        $SubsidioItavu = $_POST['subsidioitavu'];
        $GtsAdmonItavu = $_POST['gastosadmonitavu'];
        $ncertificadoitavu=$_POST['ncertificadoitavu'];

        //beneficiario
        $AportacionB = $_POST['aportacionbeneficiario'];
        $FechaInicio = $_POST['fechainicio'];

        //DatosDelCredito
        $IdTipoMoneda = $_POST['idtipomoneda'];
        $MontoCredito = $_POST['montocredito'];
        $IdPagoInicial = $_POST['idtipopagoinicial'];
        $MontoPagoInicial =  $_POST['montopagoinicial'];
        $AplicaGtsAdmon =  $_POST['aplicagtsadmon'];
        $GtsAdmon =  $_POST['gtsadmon'];
        $GtsAdmonC =  $_POST['gtsadmonc'];
        $GtsEscrituracion = $_POST['gtsescrituracion'];
        $Subsidio = $_POST['subsidio'];
        $TotalAFinanciar = $_POST['totalfinanciar'];

        //DatosDelPago
        $TipoPago = $_POST['tipopago'];
        $NumMensualidades = $_POST['totalpagos'];
        $MontoPago = $_POST['montopago'];
        $MontoUltimoPago = $_POST['ultimopago'];
        $GtsAdmonPago =  $_POST['gtsadmonpago'];
        $SeguroVida =  $_POST['segurovida'];
        $OtroCargo =  $_POST['otrocargo'];
        $ConceptoCargo =  $_POST['conceptocargo'];
        $TotalMontoPago =  $_POST['totalmontopago'];
       
        //Intereses
        $TasaAnualFin = $_POST['tasaanual'];
        $TipoIntMoratorio = $_POST['tipoInteres'];
        $TasaIntMora = $_POST['tasaintmora'];
        $PeriodoMora = $_POST['periodomora'];

        //MinistracionCredito
        $Ministracion1 = $_POST['ministracion1'];
        $Ministracion2 = $_POST['ministracion2'];
        $Ministracion3 = $_POST['ministracion3'];

        $DocumentoMaestro = $_POST['documentomaestro'];
        $CertificadoSubsidio = $_POST['certificadosubsidio'];
        
        //DATOS DEL AVAL
        $NombreAval = $_POST['NombreAval'];
        $CalleAval = $_POST['CalleAval'];
        $EntreCalleAval = $_POST['EntreCalleAval'];
        $EntreCalleAval2 = $_POST['EntreCalleAval2'];
        $MunicipioAval = $_POST['MunicipioAval'];
        $ColoniaAval = $_POST['ColoniaAval'];
        $CPAval = $_POST['CPAval'];
        $TelCasaAval = $_POST['TelCasaAval'];
        $TelTrabajoAval  = $_POST['TelTabajoAval'];
        $LugarTrabajoAval = $_POST['LugarTrabajoAval'];
        $DomicilioTrabajoAval = $_POST['DomicilioTrabajoAval'];

        
        //DATOS DEL VALE---¿DONDE SE GUARDANNNNNN???
     /*   $CasaComercial= $_POST['casacomercial'];
        $ImporteVale= $_POST['ImporteVale'];
        $MontoTope= $_POST['MontoTope'];
        $Bloquera= $_POST['bloquera'];
        $FechaEntrega= $_POST['fechaemision'];*/
       
        $varDebioAhorrar = MontoAhorroSolicitud($IdDelegacion, $IdPrograma, $Folio);
        $TiempodeAhorrar = TiempoAhorroDatosEvaluacion($IdDelegacion, $IdPrograma, $Folio);
        $varCantidadAhorrada = ObtenerTotalAbonadoPorSolicitud($IdDelegacion, $IdPrograma, $Folio);
       
        $Tipomov=1;
        $vSaldoCapCor=0;
        $montoautorizadoantes=0;        
        //VERIFICAMOS SI EL ORIGIN DATA. SI PERTENCE A ALGUIEN DE OFICINAS CENTRALES ENTONCES OBTENEMOS EL VALOR SELECCIONADO
        // if($del==0)
        // {
        //     if( isset($_POST['delegacionDondeTrabajar']))
        //     {
        //         $del=$_POST['delegacionDondeTrabajar'];
                
        //     }
        // }


        //revisa si hay ahorro
        if (($varCantidadAhorrada < $varDebioAhorrar)) 
        {   $SeguirAdelante = "NO";                           
            mensaje('No se ha cumplido con el ahorro previo.<br> Cantidad Ahorrada:  <b>$'.number_format($varCantidadAhorrada, 2).' </b> de  <b>$'.number_format($varDebioAhorrar, 2) .' </b> pactados en la solicitud de la persona.','contratarCredito.php?_folio='.$Folio.'&programa='.$IdPrograma.'&delegaciones='.$IdDelegacion);
        } 

        //se verifica si tiene ahorro registrado en la tabla de pagos
        //checa_pagos
        $VengodeGrabaCredito = True;
        $SeguirAdelante = "SI";
    
        if ($SubsidioItavu > 0  )
        { 
            if ($ncertificadoitavu !='' AND $ncertificadoitavu!='0')
            {
                $SeguirAdelante = "SI";
            }  
            else
            {
                $SeguirAdelante = "NO";            
                mensaje('Existe un subsidio de ITAVU, sin número de Certificado.<br> Imposible Continuar, debes darlo de alta.','contratarCredito.php?_folio='.$Folio.'&programa='.$IdPrograma.'&delegaciones='.$IdDelegacion); 
            }

           
        }
        else
        {      
           
            if ($ncertificadoitavu!= '' AND $ncertificadoitavu!='0' )
            {
                $SeguirAdelante = "NO";
                mensaje('Existe un número de Certificado de Subsidio de ITAVU, pero no se ha dado de alta el monto del subsidio.<br> Imposible Continuar, debes dar de alta el monto.','contratarCredito.php?_folio='.$Folio.'&programa='.$IdPrograma.'&delegaciones='.$IdDelegacion); 
            }
        }
        
      
       
   

    if($SeguirAdelante == "SI")
    {
        
       /* $IdPagoInicial=TipoPagoInicialDatosEvaluacion($IdDelegacion,$IdPrograma,$Folio);
        $IdTipoMoneda=TipoMonedaDatosEvaluacion($IdDelegacion, $IdPrograma, $Folio);
        $TipoPago=TipoPagoInicialDatosEvaluacion($IdDelegacion,$IdPrograma,$Folio);
        $MontoCredito=MontoCreditoDatosEvaluacion($IdDelegacion,$IdPrograma,$Folio);
        $MontoPago=MensualidadDatosEvaluacion($IdDelegacion,$IdPrograma,$Folio);
        $MontoPagoInicial=MontoAhorroDatosEvaluacion($IdDelegacion,$IdPrograma,$Folio);
        $MontoUltimoPago=MontoUltimoPagoDatosEvaluacion($IdDelegacion,$IdPrograma,$Folio);
        $PeriodoMora=PeriodoMoraDatosEvaluacion($IdDelegacion,$IdPrograma,$Folio);
        $TasaAnualFin=asaAnualFinDatosEvaluacion($IdDelegacion,$IdPrograma,$Folio);
        $TasaIntMora=TasaIntMoraDatosEvaluacion($IdDelegacion,$IdPrograma,$Folio);
        $TipoIntMoratorio=TipoIntMoratorioDatosEvaluacion($IdDelegacion,$IdPrograma,$Folio);
        $NumMensualidades=TotalPagosDatosEvaluacion($IdDelegacion,$IdPrograma,$Folio);
        $ncertificadofonhapo=NCertSubsidioF($IdDelegacion, $IdPrograma, $Folio);
        $ncertificadoitavu= NCertSubsidioI($IdDelegacion, $IdPrograma, $Folio);
        $Ministracion1=Ministracion1DatosEvaluacion($IdDelegacion,$IdPrograma,$Folio);
        $Ministracion2=Ministracion2DatosEvaluacion($IdDelegacion,$IdPrograma,$Folio);
        $Ministracion3=Ministracion3DatosEvaluacion($IdDelegacion,$IdPrograma,$Folio);*/
      
        $FechaEmision = $fecha;        
        $NumContrato = GenerarNumContrato($IdDelegacion,$IdPrograma,'',$nitavu);
      
      // echo "Numero de contrato ".$NumContrato."<br>";
      $sql = "CALL registrarContrato('$NumContrato',
      '',
      '$NombreAval',
      '$CalleAval',
      '$DomicilioTrabajoAval',
      '$EntreCalleAval',
      '$ColoniaAval',
      '$LugarTrabajoAval',
      '$TelCasaAval',
      '$TelTrabajoAval',
      '$EntreCalleAval2',
       0,
       '',
       '',
       '',
       '',
       '',
       '',
       '',
       '',
       '$fecha',
        '',
          '',
          '',
          '',
          '',
          '',
          '',
          '',
          '$FechaEmision',
          '',
          '',
      '',
      '',
      '',
      '',
      '$Folio',
      '',
      '',
      '',
      '',
      '$IdDelegacion',
      '$nitavu',
      '',
      '',
      '$IdPagoInicial',
      '$IdPrograma',
      '',
      '$IdTipoMoneda',
      '$TipoPago',
      '$Ministracion1',
      '$Ministracion2',
      '$Ministracion3',
      '$MontoCredito',
      '',
      '$MontoPago',
      '$MontoPagoInicial', 
      '$MontoUltimoPago',
      '$ncertificadofonhapo',
      '$ncertificadoitavu',
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
      '$PeriodoMora',
      '',
      '',
      '',
      '',
      '',
      '$SubsidioFonhapo',
      '$SubsidioItavu',
      '$TasaAnualFin',
      '$TasaIntMora',
      '$TipoIntMoratorio', 
      '$NumMensualidades',
      '',
      '',
      '0',
      '0',
      '0',
      '',
      '',
      '0',
      '0',
      '$DocumentoMaestro',
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
      '',
      '',
      '',
      '',
      '',
      '',
      '$IdDelegacion')";
        //echo $sql;
        $montoautorizadoantes=MontoAutorizadoMetas($IdDelegacion,$IdPrograma);
         //Actualiza datos evaluacion--where are this??
         if ($Vivienda->query($sql) == TRUE){
          //  echo 'Registro contrato<br>';
            $factorconversion = obtenerfactorconversion($IdTipoMoneda, $FechaInicio);
            $fechaCorte = ObtenerFechaCorteContrato();

            //OBTENGO EL MONTOAUTORIZADO ANTES DEL UPDATE POR SI OCURRE UN ERROR TOMAR EL VALOR QUE ESTABA ANTES.
           
            //METAS ES LO DEL TECHO FINANCIERO 
            //ESTO ES REPETITIVO, NO TIENE SENTIDO
            $MontoCreditoContrato= $MontoCredito;
            
            $DifMontoAutCont = $MontoCredito - $MontoCreditoContrato;
            if( $MontoCredito <> $MontoCreditoContrato){
                $sql = "Update Metas Set MontoAutorizado= (MontoAutorizado) - (".$DifMontoAutCont.") Where IdDelegacion='".$IdDelegacion."' and IdPrograma='".$IdPrograma."'";
                if ($Vivienda->query($sql1) == TRUE){
                    echo 'Actualice metas<br>';
                }else {
                        $sqlDelete=" DELETE  from contratos WHERE NumContrato=".$NumContrato;
                          echo $sqlDelete;
                        if ($Vivienda->query($sqlDelete) == TRUE){
                            historia($nitavu, 'Se elimino con éxito el registro del contrato por que ocurrio un error al momento de actualizar la tabla metas');
                        }else{
                            historia($nitavu, 'ERROR: Al eliminar el registros del contrato por que ocurrio un error al momento de actualizar la tabla metas');
                        }
                        mensaje('ERROR: Al acutalizar las metas.',' contratarCredito.php?_folio='.$Folio.'&programa='.$IdPrograma.'&delegaciones='.$IdDelegacion);
                       return;
                    }
                }
               
          



           $Ultimo=$fechaCorte;
            //Insert into controlcontratos
            //nota: Aqui deberia de iniciar la cuenta en 2 y no en 10, ya que la cuenta ya se esta inicializanda. 
            if($IdPrograma == 271){
                $Primer = ObtenerPrimerDiaMes();
                $Ultimo = ObtenerUltimoDiaMes();
                $sql1 = "Insert into controlcontratos (numcontrato,  fechaproximocorte, estatuscuenta) values 
                ('".$NumContrato."',  '" .$Ultimo."' , 10)";
            }else{
                $sql1 = "Insert into controlcontratos (numcontrato,  estatuscuenta) values 
                ('".$NumContrato."',  10)";
            }
            //echo $sql1."<br>";
            if ($Vivienda->query($sql1) == TRUE){
                //ACTUALIZAMOS EL APROBADOCONTRATAR PARA QUE SE QUITE DE LOS PDTES POR CONTRATAR
                actualizarAprobadoContratar($IdDelegacion, $IdPrograma, $Folio);
                //echo 'Registro controlcontratos<br>';
                $nummov = 1;
                $saldo_nuevo = $MontoCredito;
                 //se agrega un registro en historialpagos 
                $sql3 = "CALL registrarHistoricoPagos('$NumContrato','".$nummov."','',$FechaInicio,'$fechaCorte','','','0','','',
                '','','','','','','','','','',
                '','','','','','','','','',
                '','','','','".$MontoCredito."','','','','".$MontoCredito."',
                'PIC','$Tipomov','','','$nitavu','',NOW(),'','','','','',
                '','','','','','','','',0,'','$IdDelegacion')";
                //echo $sql3.'<br>';
                if ($Vivienda->query($sql3) == TRUE){
                  //  echo 'Registro HistoricoPago Sql3<br>';
                  
                    if($GtsAdmonC > 0){
                      //  echo 'entro GastosAdminC<br>';
                        $nummov = $nummov + 1;
                        $saldo_nuevo = $saldo_nuevo + $GtsAdmonC;
                        $sql4 = "CALL registrarHistoricoPagos('$NumContrato','".$nummov."','',$FechaInicio,'$fechaCorte','','','0','','',
                        '','','','','','','','','','',
                        '','','','','','','','','',
                        '','','','','".$GtsAdmonC."','','','','".$saldo_nuevo."',
                        'PIC','2','','','$nitavu','',NOW(),'','','','','',
                        '','','','','','','','',0,'','$IdDelegacion')";
                        if ($Vivienda->query($sql4) == TRUE){
                         // echo 'Registro HistoricoPago Sql4<br>';
                        }else // ERROR AL INSERTAR GASTOS ADMINISTRATIVOS. 
                        {
                            $sqlDelete4="CALL sp_EliminarRegistrosContratoMetasHp('$NumContrato', '$IdDelegacion', '$IdPrograma','$Folio','$nitavu','$montoautorizadoantes')";
                            echo $sqlDelete4;
                          if ($Vivienda->query($sqlDelete4) == TRUE){
                              historia($nitavu, 'Se elimino con éxito el contrato y demas tablas por que ocurrio un error al momento de insertar GtsAdmon en la tabla HistoricoPagos');
                          }else{
                              historia($nitavu, 'ERROR: Al eliminar el registros del contrato por que ocurrio un error al momento de insertar GtsAdmon en la tabla HistoricoPagos');
                          }
                          mensaje('ERROR: Al insertar GtsAdmon en tabla HistoricoPagos.',' contratarCredito.php?_folio='.$Folio.'&programa='.$IdPrograma.'&delegaciones='.$IdDelegacion);
                         return;

                        }
                    }
                   
                    if($GtsEscrituracion > 0){
                       // echo 'entro GastosEscrituracion<br>';
                        $nummov = $nummov + 1;
                        $saldo_nuevo = $saldo_nuevo + $GtsEscrituracion;
                        $sql5 = "CALL registrarHistoricoPagos('$NumContrato','".$nummov."','',$FechaInicio,'$fechaCorte','','','0','','',
                        '','','','','','','','','','',
                        '','','','','','','','','',
                        '','','','','".$GtsEscrituracion."','','','','".$saldo_nuevo."',
                        'PIC','10','','','$nitavu','',NOW(),'','','','','',
                        '','','','','','','','',0,'','$IdDelegacion')";
                        if ($Vivienda->query($sql5) == TRUE){
                           // echo 'Registro HistoricoPago Sql5<br>';
                            echo $sql5.'<br>';
                        }                        
                        else // ERROR AL INSERTAR GASTOS DE ESCRITURACION. 
                        {
                            $sqlDelete5="CALL sp_EliminarRegistrosContratoMetasHp('$NumContrato', '$IdDelegacion', '$IdPrograma','$Folio','$nitavu','$montoautorizadoantes')";
                            echo $sqlDelete5;
                          if ($Vivienda->query($sqlDelete5) == TRUE){
                              historia($nitavu, 'Se elimino con éxito el contrato y demas tablas por que ocurrio un error al momento de insertar GtsEscrituracion en la tabla HistoricoPagos');
                          }else{
                              historia($nitavu, 'ERROR: Al eliminar el registros del contrato por que ocurrio un error al momento de insertar GtsEscrituracion en la tabla HistoricoPagos');
                          }
                          mensaje('ERROR: Al insertar GtsEscrituracion en tabla HistoricoPagos.',' contratarCredito.php?_folio='.$Folio.'&programa='.$IdPrograma.'&delegaciones='.$IdDelegacion);
                         return;

                        }
                        
                    }

                        
                    //si existiese un subsidio federal
                   // if($SubsidioFonhapo > 0 and  $ncertificadofonhapo > 0 and $IdPrograma < 251){
                    if($SubsidioFonhapo > 0 and  $ncertificadofonhapo > 0 ){
                       // echo 'Existe subsidio federal<br>';
                        //se agrega un registro en pagosparciales por el monto del subsidio federal
                       // $nummov = $nummov + 1;
                       /* $sql6 = "Insert into pagosparciales (numcontrato, fechaoperacion, fechacaptura, importepago, importeenpesos, identificadorcajera, idLugarOperacion, foliorecibo, NumMov, IngresoVia, FactorConversion, origen, cancelado ) values 
                            ('".$NumContrato."',  '".$FechaInicio."', '', ".$SubsidioFonhapo.", ".$SubsidioFonhapo * $factorconversion.", ".$nitavu.", ".$IdDelegacion.", ". $ncertificadofonhapo.", ".$nummov.", '6' ,".$factorconversion.", 'PIC', 0 )";
                        echo $sql6.'<br>';
                        if ($Vivienda->query($sql6) == TRUE){
                            echo 'Registro pagosparciales sql6<br>';*/
                            $nummov = $nummov + 1;
                            $saldo_nuevo = $saldo_nuevo - $SubsidioFonhapo;
                            $sql7 = "CALL registrarHistoricoPagos('$NumContrato','".$nummov."','".$SubsidioFonhapo."','".$FechaInicio."','$fechaCorte','','','0','','',
                            '','','','','','','','','','',
                            '','','','','','','','','',
                            '','','','','".$SubsidioFonhapo."','','','','".$saldo_nuevo."',
                            'PIC','9','','','$nitavu','',NOW(),'','','','','',
                            '','','','','','','','',0,'','$IdDelegacion')";
                            if ($Vivienda->query($sql7) == TRUE){
                             //   echo 'Registro HistoricoPago Sql7<br>';
                                //echo $sql7.'<br>';
                            }
                            else // ERROR AL INSERTAR SUBSIDIO FEDERAL. 
                            {
                                $sqlDelete6="CALL sp_EliminarRegistrosContratoMetasHp('$NumContrato', '$IdDelegacion', '$IdPrograma','$Folio','$nitavu','$montoautorizadoantes')";
                                echo $sqlDelete6;
                              if ($Vivienda->query($sqlDelete6) == TRUE){
                                  historia($nitavu, 'Se elimino con éxito el contrato y demas tablas por que ocurrio un error al momento de insertar el subsido federal en la tabla HistoricoPagos');
                              }else{
                                  historia($nitavu, 'ERROR: Al eliminar el registros del contrato por que ocurrio un error al momento de insertar el subsido federal en la tabla HistoricoPagos');
                              }
                              mensaje('ERROR: Al insertar el Subsido Federal en tabla HistoricoPagos.',' contratarCredito.php?_folio='.$Folio.'&programa='.$IdPrograma.'&delegaciones='.$IdDelegacion);
                             return;    
                            }
                        //}
                       
                    }

                    //subsidio estatal
                   // if($SubsidioItavu > 0 and $ncertificadoitavu > 0 and $IdPrograma < 251){
                    if($SubsidioItavu > 0 and $ncertificadoitavu > 0  ){
                      //  echo 'entro subsidio estatal<br>';
                        //se agrega un registro en pagosparciales por el monto del subsidio estatal
                        //$nummov = $nummov + 1 ;
                      /*  $sql8 = "Insert into pagosparciales (numcontrato, fechaoperacion, fechacaptura, importepago, importeenpesos, identificadorcajera, idLugarOperacion, foliorecibo, NumMov, IngresoVia, FactorConversion, origen, cancelado ) values 
                        ('".$NumContrato."',  '".$FechaInicio."',  '', ".$SubsidioItavu.", " .$SubsidioItavu * $factorconversion.", ".$nitavu.", ".$IdDelegacion.", ".$ncertificadoitavu.", ".$nummov.", '6' ,".$factorconversion.", 'PIC', 0 )";
                        if ($Vivienda->query($sql8) == TRUE){ */
                            //echo 'Registro pagosparciales Sql8<br>';
                            //se agrega un registro en historialpagos para reducir el saldo en base al monto del subsidio estatal
                            $nummov = $nummov + 1;
                            $saldo_nuevo = $saldo_nuevo - $SubsidioItavu;
                            $sql9 = "CALL registrarHistoricoPagos('$NumContrato','".$nummov."','".$SubsidioItavu."','".$FechaInicio."','$fechaCorte','','','0','','',
                            '','','','','','','','','','',
                            '','','','','','','','','',
                            '','','','','".$SubsidioItavu."','','','','".$saldo_nuevo."',
                            'PIC','7','','','$nitavu','',NOW(),'','','','','',
                            '','','','','','','','',0,'','$IdDelegacion')";
                            if ($Vivienda->query($sql9) == TRUE){ 
                                //echo 'Registro HistoricoPago Sql9<br>';
                            }
                             else // ERROR AL INSERTAR SUBSIDIO ESTATAL. 
                            {
                                $sqlDelete7="CALL sp_EliminarRegistrosContratoMetasHp('$NumContrato', '$IdDelegacion', '$IdPrograma','$Folio','$nitavu','$montoautorizadoantes')";
                                echo $sqlDelete7;
                              if ($Vivienda->query($sqlDelete7) == TRUE){
                                  historia($nitavu, 'Se elimino con éxito el contrato y demas tablas por que ocurrio un error al momento de insertar el subsido estatal en la tabla HistoricoPagos');
                              }else{
                                  historia($nitavu, 'ERROR: Al eliminar el registros del contrato por que ocurrio un error al momento de insertar el subsido estatal en la tabla HistoricoPagos');
                              }
                              mensaje('ERROR: Al insertar el Subsidio Estatal en tabla HistoricoPagos.',' contratarCredito.php?_folio='.$Folio.'&programa='.$IdPrograma.'&delegaciones='.$IdDelegacion);
                             return;    
                            }
                        //}
                    }   
                    
                 
                    //GENERA CARGO DE AHORRO A DEVOLVER
                    
                    if($IdPrograma == 186){
                        $nummov = $nummov + 1;
                        $saldo_nuevo = $MontoCredito + 2085;
                        $sql10 = "CALL registrarHistoricoPagos('$NumContrato','".$nummov."','".$SubsidioItavu."','".$FechaInicio."','$fechaCorte','','','0','','',
                        '','','','','','','','','','',
                        '','','','','','','','','',
                        '','','','','2085','','','','".$saldo_nuevo."',
                        'PIC','59','','','$nitavu','',NOW(),'','','','','',
                        '','','','','','','','',0,'','$IdDelegacion')";
                        if ($Vivienda->query($sql10) == TRUE){ 
                            //echo 'Registro HistoricoPago Sql10<br>';
                        }
                         else // ERROR AL INSERTAR EL AHORRO A DEVOLVER. 
                        {
                            $sqlDelete8="CALL sp_EliminarRegistrosContratoMetasHp('$NumContrato', '$IdDelegacion', '$IdPrograma','$Folio','$nitavu','$montoautorizadoantes')";
                            echo $sqlDelete8;
                          if ($Vivienda->query($sqlDelete8) == TRUE){
                              historia($nitavu, 'Se elimino con éxito el contrato y demas tablas por que ocurrio un error al momento de insertar el Ahorro a Devolver en la tabla HistoricoPagos');
                          }else{
                              historia($nitavu, 'ERROR: Al eliminar el registros del contrato por que ocurrio un error al momento de insertar el Ahorro a Devolver en la tabla HistoricoPagos');
                          }
                          mensaje('ERROR: Al insertar el Ahorro a Devolver en tabla HistoricoPagos.',' contratarCredito.php?_folio='.$Folio.'&programa='.$IdPrograma.'&delegaciones='.$IdDelegacion);
                         return;    
                        }
                    } 
                  

                    /* CREO QUE NUNCA VA ENTRAR AQUI DATO QUE EL MONTOCREDITO VIENE DE DATOSEVALUACION  Y ES EL QUE SE GUARDA EN CONTRATOS.*/
                   //REVISAR LOS QUE SE ACTUALIZAN
                    if( $MontoCredito > $MontoCreditoContrato){
                        $sql = "Update DatosEvaluacion Set MontoCredito='".$MontoCreditoContrato."' , NCertSubsidioF='".$ncertificadofonhapo."' Where IdDelegacion='".$IdDelegacion."' and IdPrograma='".$IdPrograma."' and Folio=0".$Folio."'";
                        if ($Vivienda->query($sql1) == TRUE){
                            echo 'Actualice DatosEvaluacion <br>';
                        }
                        else // ERROR AL ACTAULIZAR EL MONTO CREDITO EN DATOS EVALUACION 
                        {
                            $sqlDelete8="CALL sp_EliminarRegistrosContratoMetasHp('$NumContrato', '$IdDelegacion', '$IdPrograma','$Folio','$nitavu','$montoautorizadoantes')";
                         //echo $sqlDelete8;
                          if ($Vivienda->query($sqlDelete8) == TRUE){
                              historia($nitavu, 'Se elimino con éxito el contrato y demas tablas por que ocurrio un error al momento de actualizar el monto credito en la Tabla DatosEvaluacion');
                          }else{
                              historia($nitavu, 'ERROR: Al eliminar el registros del contrato por que ocurrio un error al momento de actualizar el monto credito en la Tabla DatosEvaluacion');
                          }
                          mensaje('ERROR: Al actualizar el Monto del Credito en DatosEvaluacion.',' contratarCredito.php?_folio='.$Folio.'&programa='.$IdPrograma.'&delegaciones='.$IdDelegacion);
                         return;    
                        }

                    }

                    




                    //traslada_pagos_a_cuenta_nuevas_tablas();
                    if ($IdPrograma < 251 ){
                        if($GtsAdmonC > 0){
                            $saldo_nuevo = $saldo_nuevo + $GtsAdmonC;
                        }
                        if($GtsEscrituracion > 0 ){
                            $saldo_nuevo = $saldo_nuevo + $GtsEscrituracion;
                        }
                        if($SubsidioFonhapo > 0 and $ncertificadofonhapo > 0 ){
                            $saldo_nuevo = $saldo_nuevo - $SubsidioFonhapo;
                        }
                        if($SubsidioItavu > 0 and $ncertificadoitavu > 0){
                            $saldo_nuevo = $saldo_nuevo - $SubsidioItavu;
                        }
                    }


                      /******************************************************************************************************/
                        /*CODIGO DE LA VENTANA CONTRATO FACHADA*/         
                            //es necesario definir la fecha del primer vencimiento y cambiar el estatus de la cuenta  
                            //definiendo la fecha de corte y el estatus de la cuenta
                            $fechaCorte1=date("Y-m-d H:i:s");   
                            $varFechaVencimiento = "";
                            $vFechaVenUltimoPago= ""; //Ponemos vacio por que en vivienda revisa en la tabla cargos y nosotros no llenamos esta tabla
                            $EstatusCuenta = ObtenerIdEstatusCuenta($NumContrato);
                            if($EstatusCuenta==10)
                            {
                                if($IdPrograma!=3 and $IdPrograma!=5)
                                {
                               
                                     $varFechaVencimiento=FechaVencimientoContrato($NumContrato);                                    
                                    if ($varFechaVencimiento!="")
                                    {
                                        $str_sql = "Update controlcontratos Set EstatusCuenta=2, FechaProximoCorte='".$fechaCorte."' Where NumContrato='".$NumContrato."'";
                                        //echo $sql1.'<br>';                                        
                                    }
                                    else
                                    {
                                        //-V- OJO
                                        //Nunca entraria a esta opcion dado que se consulta la fecha de vencimiento del contrato y esa ya tiene valor.
                                        $fechaActual = date('d-m-Y H:i:s');
                                        // //no fue posible determinar la primer fecha de corte, se actualiza el estatus del registro de control y se añade una fecha de corte basado en la fecha del dia de hoy
                                        $str_sql = "Update controlcontratos set  EstatusCuenta = 2, FechaProximoCorte = '" .SiguienteFecha2($fechaActual,$NumContrato)."' where numcontrato = '" .$NumContrato. "' ";
                                        
                                        //se comento por que no se hace ningun cambio a la instrucion de arriba!! 
                                        // if ($IdPrograma == 221 )
                                        // {
                                        //     $str_sql = "Update controlcontratos set  EstatusCuenta = 2, FechaProximoCorte = '" .SiguienteFecha2($fechaActual,$NumContrato). "' where numcontrato = '" .$NumContrato. "' "  ;     
                                        // }
                                    
                                    }
                              
                                    if ($Vivienda->query($str_sql) == TRUE){
                                           //echo 'Actualice controlcontratos<br>';
                                        }else
                                        {
                                           //   echo 'ERROR AL ACTUALIZAR<br>'; 
                                        }
    
                                }
                           }
                            

                           
                           
                           
                            if($IdPrograma==251 or ($IdPrograma>=255 and $IdPrograma<=269))
                            {
                                //  agregarPagosdeAhorro($Folio, $IdPrograma, $IdDelegacion, $NumContrato, $nitavu);
                                $vMontoExento = $SubsidioFonhapo + $SubsidioItavu;
                                $vSaldoCapCor = $MontoCredito - $vMontoExento;
                                cambiaCreditoPorSolucion($NumContrato);
                                RegistraMontoExento($NumContrato, $vMontoExento);
                                AcomodaSaldoAhorros($NumContrato,$MontoCredito, $vMontoExento);
                            }
                           
                            if($IdPrograma==252 or $IdPrograma==253)
                            {  
                                //agregarPagosdeAhorro($Folio, $IdPrograma, $IdDelegacion, $NumContrato, $nitavu);                   
                                //subsidio provivah                     
                                $vMontoEnOperacion = 3800;
                                $vTipoMovimiento =31;
                                $maximomov= NumMov($NumContrato);                                     
                                $nummov = $maximomov + 1;
                                $saldo_nuevo = $saldo_nuevo - $vMontoEnOperacion;
                                $sqlUltimo = " SELECT * from historicopagos WHERE (NumContrato = '" .$NumContrato. "')  AND (NumMov = " .$maximomov. ") ";
                                // echo $sql11.'<br>';
                                    $r = $Vivienda -> query($sqlUltimo); 
                                    $r_count = $r -> num_rows;
                                    if($r_count>0){
                                        while($f = $r -> fetch_array()){
                                       $sql16 = "CALL registrarHistoricoPagos('$NumContrato','".$nummov."','".$vMontoEnOperacion."','".$FechaInicio."','$fechaCorte','','','".$f['NuevoRezGts']."','','',
                                        '','','".$f['NuevoRezSeg']."','','','','','".$f['NuevoRezOtrosGts']."','','',
                                        '','','".$f['NuevoRezMoratorios']."','','','".$f['NuevoRezFinanc']."','','','',
                                        '','','".$f['NuevoRezCapital']."','','','','','0','".$saldo_nuevo."',
                                        'PIC','".$vTipoMovimiento."','','','$nitavu','',NOW(),'','','','','',
                                        '','','','','','','','',0,'','$IdDelegacion')";
                                        if ($Vivienda->query($sql16) == TRUE){
                                        //   echo 'Registro HistoricoPago Sql7<br>';
                                        
                                        }
                                        else // ERROR AL AL INSERTAR EL SUBSIDIO PROVIVAH 
                                        {
                                            $sqlDelete9="CALL sp_EliminarRegistrosContratoMetasHp('$NumContrato', '$IdDelegacion', '$IdPrograma','$Folio','$nitavu','$montoautorizadoantes')";
                                         //echo $sqlDelete9;
                                          if ($Vivienda->query($sqlDelete9) == TRUE){
                                              historia($nitavu, 'Se elimino con éxito el contrato y demas tablas por que ocurrio un error al momento de insertar el susbsidio Provivah en la tabla HistorioPagos');
                                          }else{
                                              historia($nitavu, 'ERROR: Al eliminar el registros del contrato por que ocurrio un error al momento de  insertar el susbsidio Provivah en la tabla HistorioPagos');
                                          }
                                          mensaje('ERROR: Al insertar el susbsidio Provivah en la tabla HistorioPagos.',' contratarCredito.php?_folio='.$Folio.'&programa='.$IdPrograma.'&delegaciones='.$IdDelegacion);
                                         return;    
                                        }

                                       
                                     }
                                }
                                cambiaCreditoPorSolucion($NumContrato);
                            }
            
                            if($IdPrograma==252)
                            {
                                //Subsidio Estatal al Ahorro Previo                                        
                                 $vMontoEnOperacion =10600;
                                 $vTipoMovimiento =111;
                                 $maximomov= NumMov($NumContrato);                                     
                                 $nummov = $maximomov + 1;
                                 $saldo_nuevo = $saldo_nuevo - $vMontoEnOperacion;
                                 $sqlUltimo = " SELECT * from historicopagos WHERE (NumContrato = '" .$NumContrato. "')  AND (NumMov = " .$maximomov. ") ";
                                 // echo $sql11.'<br>';
                                     $r = $Vivienda -> query($sqlUltimo); 
                                     $r_count = $r -> num_rows;
                                     if($r_count>0){
                                         while($f = $r -> fetch_array()){
                                        $sql18 = "CALL registrarHistoricoPagos('$NumContrato','".$nummov."','".$vMontoEnOperacion."','".$FechaInicio."','$fechaCorte','','','".$f['NuevoRezGts']."','','',
                                        '','','".$f['NuevoRezSeg']."','','','','','".$f['NuevoRezOtrosGts']."','','',
                                        '','','".$f['NuevoRezMoratorios']."','','','".$f['NuevoRezFinanc']."','','','',
                                        '','','".$f['NuevoRezCapital']."','','','','','0','".$saldo_nuevo."',
                                        'PIC','".$vTipoMovimiento."','','','$nitavu','',NOW(),'','','','','',
                                        '','','','','','','','',0,'','$IdDelegacion')";
                                        if ($Vivienda->query($sql18) == TRUE){
                                        //   echo 'Registro HistoricoPago Sql7<br>';
                                        // echo $sql7.'<br>';
                                          }
                                          else // ERROR AL AL INSERTAR EL SUBSIDIO ESTATAL AL AHORRO PREVIO 
                                          {
                                            $sqlDelete10="CALL sp_EliminarRegistrosContratoMetasHp('$NumContrato', '$IdDelegacion', '$IdPrograma','$Folio','$nitavu','$montoautorizadoantes')";
                                            echo $sqlDelete10;
                                            if ($Vivienda->query($sqlDelete10) == TRUE){
                                                historia($nitavu, 'Se elimino con éxito el contrato y demas tablas por que ocurrio un error al momento de insertar el susbsidio estatal al ahorro previo en la tabla HistorioPagos');
                                            }else{
                                                historia($nitavu, 'ERROR: Al eliminar el registros del contrato por que ocurrio un error al momento de  insertar el susbsidio estatal al ahorro previo  en la tabla HistorioPagos');
                                            }
                                            mensaje('ERROR: Al insertar el susbsidio estatal al ahorro previo en la tabla HistorioPagos.',' contratarCredito.php?_folio='.$Folio.'&programa='.$IdPrograma.'&delegaciones='.$IdDelegacion);
                                           return;    
                                          }
                                        }
                                      }
                            }
            
                            if($IdPrograma==253)
                            {        //Subsidio Estatal al Ahorro Previo                                        
                                     $vMontoEnOperacion =4100;
                                     $vTipoMovimiento =111;
                                     $maximomov= NumMov($NumContrato);                                     
                                     $nummov = $maximomov + 1;
                                     $saldo_nuevo = $saldo_nuevo - $vMontoEnOperacion;
                                     $sqlUltimo = " SELECT * from historicopagos WHERE (NumContrato = '" .$NumContrato. "')  AND (NumMov = " .$maximomov. ") ";
                                     // echo $sql11.'<br>';
                                         $r = $Vivienda -> query($sqlUltimo); 
                                         $r_count = $r -> num_rows;
                                         if($r_count>0){
                                             while($f = $r -> fetch_array()){
                                            $sql20 = "CALL registrarHistoricoPagos('$NumContrato','".$nummov."','".$vMontoEnOperacion."','".$FechaInicio."','$fechaCorte','','','".$f['NuevoRezGts']."','','',
                                            '','','".$f['NuevoRezSeg']."','','','','','".$f['NuevoRezOtrosGts']."','','',
                                            '','','".$f['NuevoRezMoratorios']."','','','".$f['NuevoRezFinanc']."','','','',
                                            '','','".$f['NuevoRezCapital']."','','','','','0','".$saldo_nuevo."',
                                            'PIC','".$vTipoMovimiento."','','','$nitavu','',NOW(),'','','','','',
                                            '','','','','','','','',0,'','$IdDelegacion')";
                                            if ($Vivienda->query($sql20) == TRUE){
                                            //   echo 'Registro HistoricoPago Sql7<br>';
                                            // echo $sql7.'<br>';                              
                                            }
                                             else // ERROR AL AL INSERTAR EL SUBSIDIO ESTATAL AL AHORRO PREVIO 
                                            {
                                            $sqlDelete14="CALL sp_EliminarRegistrosContratoMetasHp('$NumContrato', '$IdDelegacion', '$IdPrograma','$Folio','$nitavu','$montoautorizadoantes')";
                                            echo $sqlDelete14;
                                            if ($Vivienda->query($sqlDelete14) == TRUE){
                                                historia($nitavu, 'Se elimino con éxito el contrato y demas tablas por que ocurrio un error al momento de insertar el susbsidio estatal al ahorro previo en la tabla HistorioPagos');
                                            }else{
                                                historia($nitavu, 'ERROR: Al eliminar el registros del contrato por que ocurrio un error al momento de  insertar el susbsidio estatal al ahorro previo  en la tabla HistorioPagos');
                                            }
                                            mensaje('ERROR: Al insertar el susbsidio estatal al ahorro previo en la tabla HistorioPagos.',' contratarCredito.php?_folio='.$Folio.'&programa='.$IdPrograma.'&delegaciones='.$IdDelegacion);
                                            return;    
                                            }
                                        }
                                     }
                            }    
                            
                          /*  if($IdPrograma==270 or $IdPrograma==277 or $IdPrograma==278)
                            {   //NOTA:
                                 //SE COMENTA EL CODIGO ,YA QUE EN EL CODIGO DE ARRIBA YA SE INSERTA EL SUBSIDIO DE ITAVU
                                 //Y ESOS VALORES YA VIENEN DESDE LA PANTALLA ANTERIOR FIJOS
                                
                                $sql1 = "Delete  from historicopagos  Where NumContrato='".$NumContrato."' and TipoMov=7";
                                echo $sql1.'<br>';
                                if ($Vivienda->query($sql1) == TRUE){
                                //   echo 'Actualice ControlContrtos<br>';
                                }

                                //pinturas
                                //agregarPagosdeAhorro($Folio, $IdPrograma, $IdDelegacion, $NumContrato, $nitavu);
                                    $vMontoEnOperacion =$MontoCredito;
                                     $vTipoMovimiento =7;
                                     $maximomov= NumMov($NumContrato);                                     
                                     $nummov = $maximomov + 1;
                                     $saldo_nuevo = $saldo_nuevo - $vMontoEnOperacion;
                                     $sqlUltimo = " SELECT * from historicopagos WHERE (NumContrato = '" .$NumContrato. "')  AND (NumMov = " .$maximomov. ") ";
                                     // echo $sql11.'<br>';
                                         $r = $Vivienda -> query($sqlUltimo); 
                                         $r_count = $r -> num_rows;
                                         if($r_count>0){
                                             while($f = $r -> fetch_array()){
                                            $sql21 = "CALL registrarHistoricoPagos('$NumContrato','".$nummov."','".$vMontoEnOperacion."','".$FechaInicio."','$fechaCorte','','','".$f['NuevoRezGts']."','','',
                                            '','','".$f['NuevoRezSeg']."','','','','','".$f['NuevoRezOtrosGts']."','','',
                                            '','','".$f['NuevoRezMoratorios']."','','','".$f['NuevoRezFinanc']."','','','',
                                            '','','".$f['NuevoRezCapital']."','','','','','0','".$saldo_nuevo."',
                                            'PIC','".$vTipoMovimiento."','','','$nitavu','',NOW(),'','','','','',
                                            '','','','','','','','',0,'','$IdDelegacion')";
                                            if ($Vivienda->query($sql21) == TRUE){
                                            //   echo 'Registro HistoricoPago Sql7<br>';
                                            // echo $sql7.'<br>';                                        
                                           }else{ echo $sql21.'<br> Error21: Subsidio Estatal al Ahorro Previo   ';}
                                        }
                                    }
                            } */
                            
                            
                            if($IdPrograma==271 Or $IdPrograma== 273 Or $IdPrograma== 274 Or $IdPrograma=== 275 Or $IdPrograma== 280)
                            {   // leer tabla de evaluacionporcoonceptos
                                // aplicar conceptos                                
                                // revisa subsidios para contemplar el saldo exento
                               $vMontoExento= RevisaMontoSubsidios($IdDelegacion,$IdPrograma,$Folio);

                                 //select from pagos
                                $sql11 = "SELECT * FROM EvaluacionPorConceptos WHERE  IdDelegacion='".$IdDelegacion."' AND IdPrograma='".$IdPrograma."' AND Folio='".$Folio."'";
                                //echo $sql11.'<br>';
                                $r = $Vivienda -> query($sql11); 
                                $r_count = $r -> num_rows;
                                if($r_count>0){
                                    while($ff = $r -> fetch_array()){
                                        if($ff['IdTipoMov']==1 or $ff['IdTipoMov']==112 or $ff['IdTipoMov']==35)
                                        {
                                            /*DELEETE FROM HISTORICO PAGOS*/
                                            $sql22 = "Delete from historicopagos where NumContrato='" . $NumContrato . "' and nummov=1";
                                            echo $sql22.'<br>';
                                            if ($Vivienda->query($sql22) == TRUE){
                                                 //   echo 'Registro HistoricoPago Sql7<br>';                                                                                     
                                            }else // ERROR AL ELIMINAR DE HISTORICO PAGOS
                                            {
                                             $sqlDelete12="CALL sp_EliminarRegistrosContratoMetasHp('$NumContrato', '$IdDelegacion', '$IdPrograma','$Folio','$nitavu','$montoautorizadoantes')";
                                             echo $sqlDelete12;
                                             if ($Vivienda->query($sqlDelete12) == TRUE){
                                                 historia($nitavu, 'Se elimino con éxito el contrato y demas tablas por que ocurrio un error al momento de eliminar moviemiento 1 en tabla HistorioPagos');
                                             }else{
                                                 historia($nitavu, 'ERROR: Al eliminar el registros del contrato por que ocurrio un error al momento dede eliminar moviemiento 1 en la tabla HistorioPagos');
                                             }
                                             mensaje('ERROR: En la tabla HistorioPagos.',' contratarCredito.php?_folio='.$Folio.'&programa='.$IdPrograma.'&delegaciones='.$IdDelegacion);
                                            return;    
                                            }

                                            $vTipoMovimiento = $ff['IdTipoMov'];
                                            $vMontoEnOperacion = $ff['Monto'];
                                            $vSaldoCapCor = ($ff['Monto']-$vMontoExento);

                                            /*INSERTA MOVIEMIENTO DE APERTURA*/                                           
                                            $sql23 = "CALL registrarHistoricoPagos('$NumContrato','1','".$vMontoEnOperacion."','".$FechaInicio."','$fechaCorte','','','0','0','0',
                                            '0','0','0','0','0','0','0','0','0','0',
                                            '0','0','0','0','0','0','0','0','0',
                                            '0','0','0','0','".$vMontoEnOperacion."','0','0','0','".$vSaldoCapCor."',
                                            'PIC','".$vTipoMovimiento."','','','$nitavu','',NOW(),'','','". $vMontoExento."','','',
                                            '','','','','','','','',0,'','$IdDelegacion')"; 
                                            //echo 'ok'.$sql23;                                 
                                            if ($Vivienda->query($sql23) == TRUE){
                                                
                                            //   echo 'Registro HistoricoPago Sql7<br>';
                                            // echo $sql7.'<br>';                                        
                                           }
                                           else // ERROR AL AL INSERTAR EL MOVIMIENTO DE APERTURA (CONCEPTOS) 
                                          {
                                           $sqlDelete13="CALL sp_EliminarRegistrosContratoMetasHp('$NumContrato', '$IdDelegacion', '$IdPrograma','$Folio','$nitavu','$montoautorizadoantes')";
                                          // echo $sqlDelete13;
                                           if ($Vivienda->query($sqlDelete13) == TRUE){
                                               historia($nitavu, 'Se elimino con éxito el contrato y demas tablas por que ocurrio un error al momento de insertar el moviemiento de apertura en la tabla HistorioPagos');
                                           }else{
                                               historia($nitavu, 'ERROR: Al eliminar el registros del contrato por que ocurrio un error al momento de  insertar el moviemiento de apertura en la tabla HistorioPagos');
                                           }
                                           mensaje('ERROR: Al insertar en la tabla HistorioPagos1.',' contratarCredito.php?_folio='.$Folio.'&programa='.$IdPrograma.'&delegaciones='.$IdDelegacion);
                                           return;    
                                          }
                                        

                                        $vAhorros = 0;
                                        AcomodaSaldoAhorros($NumContrato,$MontoCredito, $vMontoExento);
                                        $vSaldoCapCor = $vMontoEnOperacion - $vMontoExento - $vAhorros;
                                        RegistraMontoExento($NumContrato, $vMontoExento);
                                        }
                                        
                                        if($ff['IdTipoMov']==7 or $ff['IdTipoMov']==9 or $ff['IdTipoMov']==31 or $ff['IdTipoMov']==32 or  $ff['IdTipoMov']==55)
                                        {
                                           
                                                $vTipoMovimiento = $ff['IdTipoMov'];
                                                $vMontoEnOperacion =  $ff['Monto'];
                                                $vSaldoCapCor = $vSaldoCapCor;
                                                $vMontoExento = $vMontoExento -$ff['Monto'];
                                                $vFolioRecibo = $ff['NoCertificado'];
                                                InsertaMovimientoExento($NumContrato,$vMontoEnOperacion,$vTipoMovimiento,$vFolioRecibo, $vSaldoCapCor,$vMontoExento,$nitavu,$IdDelegacion,$IdPrograma,$Folio);
                                        }
                                        if($ff['IdTipoMov']==111 )
                                        {
                                           
                                                $vTipoMovimiento = $ff['IdTipoMov'];
                                                $vMontoEnOperacion =  $ff['Monto'];
                                                $vSaldoCapCor = $vSaldoCapCor - $ff['Monto'];
                                                $vMontoExento = $vMontoExento;
                                                $vFolioRecibo = $ff['NoCertificado'];
                                                $vObservacion="";
                                               InsertaMovimientoHP2($NumContrato,$vMontoEnOperacion,$vTipoMovimiento,$vObservacion, $vSaldoCapCor,$vMontoExento,$nitavu,$IdDelegacion,$IdPrograma,$Folio);
                                        }
                                    }
                                
                                }
                            }
                            
                            if($IdPrograma==279)
                            {  
                                /*NOTA:
                                 SE COMENTA EL CODIGO ,YA QUE EN EL CODIGO DE ARRIBA YA SE INSERTA EL SUBSIDIO DE ITAVU
                                 Y ESOS VALORES YA VIENEN DESDE LA PANTALLA ANTERIOR FIJOS
                                */
                                
                                //agregarPagosdeAhorro($Folio, $IdPrograma, $IdDelegacion, $NumContrato, $nitavu);                   
                                                 
                               /* $vMontoEnOperacion = $MontoCredito;
                                $vTipoMovimiento=7;
                                $maximomov= NumMov($NumContrato);                                     
                                $nummov = $maximomov + 1;
                                $saldo_nuevo = $saldo_nuevo - $vMontoEnOperacion;
                                $sqlUltimo = " SELECT * from historicopagos WHERE (NumContrato = '" .$NumContrato. "')  AND (NumMov = " .$maximomov. ") ";
                                // echo $sql11.'<br>';
                                    $r = $Vivienda -> query($sqlUltimo); 
                                    $r_count = $r -> num_rows;
                                    if($r_count>0){
                                        while($f = $r -> fetch_array()){
                                       $sql16 = "CALL registrarHistoricoPagos('$NumContrato','".$nummov."','".$vMontoEnOperacion."','".$FechaInicio."','$fechaCorte','','','".$f['NuevoRezGts']."','','',
                                        '','','".$f['NuevoRezSeg']."','','','','','".$f['NuevoRezOtrosGts']."','','',
                                        '','','".$f['NuevoRezMoratorios']."','','','".$f['NuevoRezFinanc']."','','','',
                                        '','','".$f['NuevoRezCapital']."','','','','','0','".$saldo_nuevo."',
                                        'PIC','".$vTipoMovimiento."','','','$nitavu','',NOW(),'','','','','',
                                        '','','','','','','','',0,'','$IdDelegacion')";
                                        if ($Vivienda->query($sql16) == TRUE){
                                        //   echo 'Registro HistoricoPago Sql7<br>';
                                        
                                        }else{ echo $sql16.'<br> Error 16: Al Insertar en Susbidio Proviva';}
                                       
                                     }
                                }*/
                                cambiaCreditoPorSolucion($NumContrato);
                            }
                            
                            if($IdPrograma==281)
                            {   
                             /*NOTA:
                                SE COMENTA EL CODIGO, YA QUE EN EL CODIGO DE ARRIBA YA SE INSERTA EL SUBSIDIO DE FONHAPO 
                                Y ESOS VALORES YA VIENEN DESDE LA PANTALLA ANTERIOR FIJOS
                             */

                            //agregarPagosdeAhorro($Folio, $IdPrograma, $IdDelegacion, $NumContrato, $nitavu);                                        
                            /*     $vMontoEnOperacion = $MontoCredito;
                                $vTipoMovimiento=9;
                                $maximomov= NumMov($NumContrato);                                     
                                $nummov = $maximomov + 1;
                                $saldo_nuevo = $saldo_nuevo - $vMontoEnOperacion;
                                $sqlUltimo = " SELECT * from historicopagos WHERE (NumContrato = '" .$NumContrato. "')  AND (NumMov = " .$maximomov. ") ";
                                // echo $sql11.'<br>';
                                    $r = $Vivienda -> query($sqlUltimo); 
                                    $r_count = $r -> num_rows;
                                    if($r_count>0){
                                        while($f = $r -> fetch_array()){
                                       $sql16 = "CALL registrarHistoricoPagos('$NumContrato','".$nummov."','".$vMontoEnOperacion."','".$FechaInicio."','$fechaCorte','','','".$f['NuevoRezGts']."','','',
                                        '','','".$f['NuevoRezSeg']."','','','','','".$f['NuevoRezOtrosGts']."','','',
                                        '','','".$f['NuevoRezMoratorios']."','','','".$f['NuevoRezFinanc']."','','','',
                                        '','','".$f['NuevoRezCapital']."','','','','','0','".$saldo_nuevo."',
                                        'PIC','".$vTipoMovimiento."','','','$nitavu','',NOW(),'','','','','',
                                        '','','','','','','','',0,'','$IdDelegacion')";
                                        if ($Vivienda->query($sql16) == TRUE){
                                        //   echo 'Registro HistoricoPago Sql7<br>';
                                        
                                        }else{ echo $sql16.'<br> Error 16: Al Insertar en Susbidio Proviva';}
                                       
                                     }
                                } */
                                cambiaCreditoPorSolucion($NumContrato);
                            }
                        
                        /*****************************************************************************************************/
                
                        /*  graba un registro en ministracioncreditos   */
                        /*if( TipoImpVale($IdPrograma)==3)
                        {

                            if(FechaMinistracion($NumContrato)=="")
                            {
                                $sqlMinistracion="INSERT INTO ministracioncredito  (NumContrato,NumMinistracion ,Cancelado ,Enviar,FechaCaptura  ,
                                FechaEmision ,FechaEntrega ,FechaEnvio  , FechaUltimaMod  ,Folio ,IdCasaComercial ,IdDelegacion ,IdEmpCrea  ,
                                IdEmpModifica,IdPrograma ,IdTipoMinistracion,Monto ,CasaComercial ,FechaImpProv,FechaSolicImp ,
                                FechaImpDupli,Observaciones ,idbloquera,LLegoValeFisico,Oficio,FechaOficio ,OrigenDeEnvio)
                                VALUES ('".$NumContrato."',1,0,1,NOW(),".$FechaEntrega.",NOW(),NULL,NULL,".$Folio.",0,".$IdDelegacion.",".
                                $nitavu.",NULL,".$IdPrograma.",NULL".$MontoCredito.",'".$CasaComercial."',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,".$IdDelegacion.")";
                                if ($Vivienda->query($sqlMinistracion) == TRUE){                                   
                                    $sql14 = "UPDATE contratos SET FechaMin1 ='".$FechaEntrega."' WHERE NumContrato='".$NumContrato."'";
                                    echo $sql14.'<br>';
                                        if ($Vivienda->query($sql14) == TRUE){
                                            echo 'Actualize fechaMin1 en contratos<br>';                                            
                                        }else 
                                        { 
                                            echo "hubo un error actualizar la FechaMin1 en Contratos";                                            
                                        }
                                    }
                                    else // ERROR AL AL INSERTAR EL SUBSIDIO ESTATAL AL AHORRO PREVIO 
                                    {
                                        $sqlDelete10="CALL sp_EliminarRegistrosContratoMetasHp('$NumContrato', '$IdDelegacion', '$IdPrograma','$Folio','$nitavu','$montoautorizadoantes')";
                                        echo $sqlDelete10;
                                        if ($Vivienda->query($sqlDelete10) == TRUE){
                                            historia($nitavu, 'Se elimino con éxito el contrato y demas tablas por que ocurrio un error al momento de  insertar la ministracion del credito  en la tabla Ministracion Credito');
                                        }else{
                                            historia($nitavu, 'ERROR: Al eliminar el registros del contrato por que ocurrio un error al momento de  insertar la ministracion del credito  en la tabla Ministracion Credito');
                                        }
                                        mensaje('ERROR: Al insertar la ministracion del credito en la tabla MinistracionCredito.','contratarCredito.php?_folio='.$Folio.'&programa='.$IdPrograma.'&delegaciones='.$IdDelegacion);
                                    return;    
                                    }
                            }
                            else 
                            {
                                mensaje('Ya hay una fecha de vale impreso, imposible continuar...','contratarCredito.php?_folio='.$Folio.'&programa='.$IdPrograma.'&delegaciones='.$IdDelegacion);
                                return;    
                            }
                        }*/



                        //select from pagos
                        $sql11 = "SELECT * FROM pagos WHERE Cancelado=0 AND IdDelegacion='".$IdDelegacion."' AND IdPrograma='".$IdPrograma."' AND Folio='".$Folio."' ORDER BY NumPago";
                       // echo $sql11.'<br>';
                        $r = $Vivienda -> query($sql11); 
                        $r_count = $r -> num_rows;
                        if($r_count>0){
                            while($fx = $r -> fetch_array()){
                            /*$nummov = $nummov + 1;
                            $viadeingreso = 3;
                            $sql12 = "Insert into pagosparciales (numcontrato, fechaoperacion, fechacaptura, importepago, importeenpesos, identificadorcajera, idLugarOperacion, foliorecibo, NumMov, IngresoVia, FactorConversion, origen, cancelado ) values 
                            ('".$NumContrato."',  '".$f['Fecha']."',  '".$f['FechaCaptura']."', ".$f['Importe'].", ".$f['Importe'].", ".$f['IdEmpCrea'].",".$f['IdDelegacion'].", ".$f['FolioRec'].", ".$nummov.", ".$viadeingreso.", '1', 'PIC', '0')";
                            echo $sql12.'<br>';
                            if ($Vivienda->query($sql12) == TRUE){  
                                echo 'Registro PagosParciles Sql12<br>'; */
                                if ($IdPrograma == 186){
                                    $saldo_nuevo = 4000;
                                }else{
                                    $saldo_nuevo = $saldo_nuevo - $fx['Importe'];
                                }

                                $sql = "select ifnull(max(nummov),0) as maximo from historicopagos where numcontrato='" .$NumContrato. "'";
                                $rc= $Vivienda -> query($sql);
                                if($f = $rc -> fetch_array()){
                                    $nummov= $f['maximo'];
                                }else{
                                    $nummov= '0';
                                }
                                $nummov=$nummov+1;
                              
                                // if(is_null($fx['idTipoMov'])){
                                //     $Tipomov = 13 ;
                                  
                                // }else{
                                //     $Tipomov = $fx['idTipoMov'];
                                    
                                // }

                                 if($fx['idTipoMov']=="19"){
                                     $Tipomov = 19 ;                                                                
                                 }else{
                                     $Tipomov = 13;
                                                                    
                                  }

                                $sql13 = "CALL registrarHistoricoPagos('$NumContrato','".$nummov."','".$fx['Importe']."','".$fx['Fecha']."','$fechaCorte','','','0','','',
                                '','','','','','','','','','',
                                '','','','','','','','','',
                                '','','','','".$fx['Importe']."','','','','".$saldo_nuevo."',
                                'PIC','".$Tipomov."','','','$nitavu','',NOW(),'','','','','',
                                '','','','','','','','',0,'','$IdDelegacion')";
                                echo $sql13.'<br>';
                                if ($Vivienda->query($sql13) == TRUE){   
                                  //  echo 'Registro HistoricoPago Sql13<br>';
                                    //se marcan en pagos como cancelados
                                    $sql14 = "UPDATE pagos SET Cancelado = 1 WHERE Cancelado=0 AND IdDelegacion='".$IdDelegacion."' AND IdPrograma='".$IdPrograma."' AND Folio='".$Folio."' ORDER BY NumPago";
                                    echo $sql14.'<br>';
                                    if ($Vivienda->query($sql14) == TRUE){
                                     
                                        //seleccionar la plantilla a mostrar la obtenemos del programa
                                        $IdPlantilla = plantillaPrograma($IdPrograma);
                                    
                                        echo "<script>
                                        NPush('Contrato registrado con éxito.','Plataforma ITAVU')
                                        </script>";
                                        //ESTA OPCION IMPRIME PLANTILLA Y NNOO VALE POR QUE EL programa NO TIENE VALE
                                        
                                        // echo "<div style='width: 100%; height: 100%;'><iframe id='CartaAsignacion' name='CartaAsignacion' style='width: 100%; height: 100%;' src='carga_contrato.php?IdPlantilla=3&lote=".$lote."&manzana=".$manzana."&nomcolonia=".$nomcolonia."&superficie=".$superficie."&colindancia1=".$colindancia1."&colindancia2=".$colindancia2."&colindancia3=".$colindancia3."&colindancia4=".$colindancia4."&beneficiario=".$beneficiario."'>Tu navegador no soporta iframes...</iframe></div>";
                                        //CREAMOS PLANTILLA
                                        if($IdPlantilla!=0){
                                            echo "<center><h1>Asignación de crédito</h1></center>";
                                            //CREAMOS PLANTILLA
                                            crearPlantilla($IdPlantilla, $NumContrato, $TotalAFinanciar, $nitavu);
                                          
                                            }else{
                                                mensaje('Aviso: No se puede imprimir el contrato, no existe una plantilla.','contratar.php?_folio='.$Folio.'&programa='.$IdPrograma.'&delegaciones='.$IdDelegacion.'&idlote='.$idlote.'&ediar=');
                                            }
                                        
                                        
                                      
                                      
                                        
                                    }else // ERROR AL MARCAR COMO CANCELADO LOS PAGOS 
                                    {
                                      $sqlDelete10="CALL sp_EliminarRegistrosContratoMetasHp('$NumContrato', '$IdDelegacion', '$IdPrograma','$Folio','$nitavu','$montoautorizadoantes')";
                                      echo $sqlDelete10;
                                      if ($Vivienda->query($sqlDelete10) == TRUE){
                                          historia($nitavu, 'Se elimino con éxito el contrato y demas tablas por que ocurrio un error al momento de marcar como cancelado los pagos.');
                                      }else{
                                          historia($nitavu, 'ERROR: Al eliminar el registros del contrato por que ocurrio un error  al momento de marcar como cancelado los pagos.');
                                      }
                                      mensaje('ERROR: Al momento de marcar como cancelado los pagos.','contratarCredito.php?_folio='.$Folio.'&programa='.$IdPrograma.'&delegaciones='.$IdDelegacion);
                                     return;    
                                    }

                                }
                                else // ERROR AL MARCAR DE INSERTAR EN HISTORICO PAGOS
                                    {
                                      $sqlDelete11="CALL sp_EliminarRegistrosContratoMetasHp('$NumContrato', '$IdDelegacion', '$IdPrograma','$Folio','$nitavu','$montoautorizadoantes')";
                                      echo $sqlDelete11;
                                      if ($Vivienda->query($sqlDelete11) == TRUE){
                                          historia($nitavu, 'Se elimino con éxito el contrato y demas tablas por que ocurrio un error al momento de insertar en historico pagos.');
                                      }else{
                                          historia($nitavu, 'ERROR: Al eliminar el registros del contrato por que ocurrio un error  al momento de insertar en historico pagos.');
                                      }
                                      mensaje('ERROR: Al momento de insertar en historico pagos.','contratarCredito.php?_folio='.$Folio.'&programa='.$IdPrograma.'&delegaciones='.$IdDelegacion);
                                     return;    
                                    }                          
                        }

                        

                    }else{
                       
                     
                        //seleccionar la plantilla a mostrar la obtenemos del programa
                        $IdPlantilla = plantillaPrograma($IdPrograma);
                  
                        
                        // echo "<div style='width: 100%; height: 100%;'><iframe id='CartaAsignacion' name='CartaAsignacion' style='width: 100%; height: 100%;' src='carga_contrato.php?IdPlantilla=3&lote=".$lote."&manzana=".$manzana."&nomcolonia=".$nomcolonia."&superficie=".$superficie."&colindancia1=".$colindancia1."&colindancia2=".$colindancia2."&colindancia3=".$colindancia3."&colindancia4=".$colindancia4."&beneficiario=".$beneficiario."'>Tu navegador no soporta iframes...</iframe></div>";

                        if($IdPlantilla!=0){
                            echo "<center><h1>Asignación de crédito</h1></center>";
                            //CREAMOS PLANTILLA
                            crearPlantilla($IdPlantilla, $NumContrato, $TotalAFinanciar, $nitavu);
                          
                            }else{
                                mensaje('Aviso: No se puede imprimir el contrato, No existe una plantilla.','contratar.php?_folio='.$Folio.'&programa='.$IdPrograma.'&delegaciones='.$IdDelegacion.'&idlote&ediar=');
                            }
                        
                  
                    }

                }else //CIERRE DEl INSERT DEL CREDITO EN HISTORICOPAGOS
                {
                    $sqlDelete3="CALL sp_EliminarRegistrosContratoMetasHp('$NumContrato', '$IdDelegacion', '$IdPrograma','$Folio','$nitavu','$montoautorizadoantes')";
                    //echo $sqlDelete3;
                  if ($Vivienda->query($sqlDelete3) == TRUE){
                      historia($nitavu, 'Se elimino con éxito el contrato y demas tablas por que ocurrio un error al momento de insertar en la tabla HistoricoPagos');
                  }else{
                      historia($nitavu, 'ERROR: Al eliminar el registros del contrato por que ocurrio un error al momento de insertar en la tabla HistoricoPagos');
                  }
                  mensaje('ERROR: Al insertar en tabla HistoricoPagos.',' contratarCredito.php?_folio='.$Folio.'&programa='.$IdPrograma.'&delegaciones='.$IdDelegacion);
                 }

                

            }//CIERRE DE CONTROLCONTRATOS
            else {
                $sqlDelete2="CALL sp_EliminarRegistrosContratoMetas('$NumContrato', '$IdDelegacion', '$IdPrograma','$Folio','$nitavu','$montoautorizadoantes')";
                  //echo $sqlDelete2;
                if ($Vivienda->query($sqlDelete2) == TRUE){
                    historia($nitavu, 'Se elimino con éxito el contrato y demas tablas por que ocurrio un error al momento de insertar en la tabla controlcontratos');
                }else{
                    historia($nitavu, 'ERROR: Al eliminar el registros del contrato por que ocurrio un error al momento de insertar en la tabla controlcontratos');
                }
                mensaje('ERROR: Al insertar en tabla Control Contratos.',' contratarCredito.php?_folio='.$Folio.'&programa='.$IdPrograma.'&delegaciones='.$IdDelegacion);
               }
        
          
        }else{ //ERROR EN CONTRATO SOLO MANDA MENSAJE
            echo 'Error: Al momento de registrar el contrato';            
             mensaje("ERROR: Al momento de registrar el contrato, favor de intentarlo de nuevo.",' contratarCredito.php?_folio='.$Folio.'&programa='.$IdPrograma.'&delegaciones='.$IdDelegacion);
             echo "Falló CALL: (" . $Vivienda->errno . ") " . $Vivienda->error;
        }

    } // CIERRE DEL ADELANTE


     
    }else{
        mensaje("ERROR: no se recibio la información aedcuadamente, favor de intentarlo de nuevo.",' contratarCredito.php?_folio='.$Folio.'&programa='.$IdPrograma.'&delegaciones='.$IdDelegacion);
    }
}else{
    mensaje("ERROR: no tienes acceso a este modulo","");
}



?>
<script>

</script>
<?php include ("lib/body_footer.php"); ?>