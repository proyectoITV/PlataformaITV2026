<?php
require_once("config.php");
require_once("lib/funciones.php");
require_once("lib/flor_funciones.php");
require_once("lib/yes_funciones.php");

//$fechaRecibo=date("Y-m-d H:i:s", $time);
$BAplicoCamp = 0;
$FolioRecibo = IdSiguienteFolioRecibo();
$vUltimoMovCta = NumMov($NumContrato);
$NumeroMovimiento = $vUltimoMovCta+1;

echo 'entro a cobraza';
//$FolioRecibo = //IdSiguienteFolioRecibo();// Call ObtieneFolioDeRecibos ya Lo traemos

//$LugarExpedicion = $IdDelegacion;
//$OrigenDeEnvio=$IdDelegacion;
$IngresoVia = 6;

$contador_puntos=0; // no se utiliza. 

$distribuye_pago='FALSE';
$pagos_parciales='FALSE';
$cobranzaCampaña='FALSE'; //almacenar si hubo un error
$pago_capital='FALSE';
$MontoRealPago=0;

$DescuentoAutorizado=0;
//Busca si existe un descuento en la cuetna
$datosdes = buscaDescuento($NumContrato,$nitavu);                
if($datosdes!='FALSE'){                        
  $datosdes = explode("_", $datosdes);     
  $DescuentoAutorizado=$datosdes[0];
  $MinimoRequiereAbonar=$datosdes[1];
  $Tipo_descuento=$datosdes[2];
  $BhayDescuento = 1;
  
}
$IdTipoTramite=tipoTramitePrograma($IdPrograma);
/*EVALUAMOS A QUE TIPO DE DESCUENTO TIENE ACCESO*/

echo 'caso'.$TipoPago_1Liq_2Desc_3MensFree;
switch ($TipoPago_1Liq_2Desc_3MensFree) {
    case 1:    
        /*============================================================================== */
                                        //DESCUENTO A MORATORIOS
        /*============================================================================== */ 
        $cant=(string)$Cantidad;
        $msp=(string)$MontoSaldarPesos;
     
       if( $cant>= $msp) 
        {             
            $vMontoDescuentoMora = $DescuentoAutorizado;
            $IngresoVia = 6;
            
            if($vMontoDescuentoMora > 0 )
            {   
               //SE REGISTRA EL MONTO DE DESCUENTO A MORATORIO AL LIQUIDAR EN HISTORICOPAGOS         
              $distribuye_pago = distribuye_pago($NumContrato,$fechaRecibo,0,$vMontoDescuentoMora,$nitavu,$CveCargo,$FormaPago,$OrigenDeEnvio);
               if  ($distribuye_pago =='TRUE')
                {         
                    //ALMACENAMOS EN LA TABLA PAGOS PARCIALES LOS DATOS DEL PAGO Y RECIBO QUE ACABAMOS DE INSERTAR EN HISTORICOPAGOS   
                  //  $pagos_parciales=Registra_PagosParciales($vMontoDescuentoMora ,$vMontoDescuentoMora,$NumContrato,$fechaRecibo,NULL,$FolioRecibo,
                  //  $LugarExpedicion,$NumeroMovimiento,$IngresoVia,$factormoneda,$nitavu,$contador_puntos);
                    //if( $pagos_parciales=='TRUE')
                    //{
                        /*============================================================================== */
                        //ACTUALIZAMOS EL TIPO MOVIMIENTO DEL REGISTRO INSERTADO EN HISTORICOPAGOS
                        $sql = "UPDATE historicopagos Set TipoMov = 125, origen='DSC'  where NumContrato='".$NumContrato."'  and MontoPagoRecibido = ROUND(" .$vMontoDescuentoMora. ",2) and NumMov = ".$NumeroMovimiento;
                        //echo $sql;
                        if ($Vivienda->query($sql) == TRUE){   
                            $res = 'TRUE';   

                                // /*============================================================================== */
                                // //ACTUALIZAMOS EL TIPO MOVIMIENTO DEL REGISTRO INSERTADO EN  PAGOS PARCIALES
                                // $sql1 = "UPDATE pagosparciales Set origen='DSC' where NumContrato='".$NumContrato."'  and importepago = '".$vMontoDescuentoMora. "' and NumMov = " . $NumeroMovimiento;
                                // //echo $sql1;
                                // if ($Vivienda->query($sql1) == TRUE){   
                                //         $res = 'TRUE';
                                // }
                                // else
                                // {
                                //         echo  '1. Ocurrio un error, favor de intentarlo nuevamente. (pagos Parciales)';
                                // }
                        }
                        else
                        {   echo  '2. Ocurrio un error, favor de intentarlo nuevamente. (historicopagos)';
                        }    

                    /*============================================================================== */
                        //Rem se agrega cancelacion del descuento autorizado por delegado
                        // Rem se cambia estatus del descuento 
                    /*============================================================================== */     
                    ActivarODesactivarDescuento(0,$nitavu,$NumContrato,125); //ACTIVAR DESCUENTO


                    if( $vMontoDescuentoCapital > 0 )
                    {  
                         $IdTipoMov =122;
                        $pago_capital=PagoACapital($vMontoDescuentoCapital, $IdTipoMov,$NumContrato,$OrigenDeEnvio,$FormaPago,$fechaRecibo ,$nitavu,$FolioRecibo,$IngresoVia,$factormoneda,$fecha_corte_sig) ;
                        if($pago_capital=='TRUE')
                        {
                        historia($nitavu, "Registro de bonificacion de capital 10%, campaña de descuentos 2018 por : " .$vMontoDescuentoCapital. " al contrato='".$NumContrato."' Folio Recibo".$FolioRecibo); 
                                       
                        $NumeroMovimiento = NumMov($NumContrato);   
                        
                        //ACTUALIZAMOS EL TIPO MOVIMIENTO DEL REGISTRO INSERTADO EN HISTORICOPAGOS
                        $sql2 = "UPDATE  historicopagos Set TipoMov = 122,origen='DSC' where NumContrato = '" .$NumContrato."' and MontoPagoRecibido = " .$vMontoDescuentoCapital. " and NumMov = " . $NumeroMovimiento;
                        //echo $sql2;
                        if ($Vivienda->query($sql2) == TRUE){   
                            $res = 'TRUE';
                        }
                        else
                        {
                           echo  '5. Ocurrio un error, favor de intentarlo nuevamente';
                        }
                        }else {
                            Destruye_HistoricoPagos($NumContrato, $NumeroCuentaAntes,1) ; //TODOS()
                            ActivarODesactivarDescuento(1,$nitavu,$NumContrato,125); //ACTIVAR DESCUENTO
                            //Destruye_PagosParciales($NumContrato, $NumeroCuentaAntes,1) ;
                            $ProcedimientoCorrecto='FALSE';
                            echo modalSinRedirigir("Ocurrio un error al querer insertar el pago a capital.");
                            return;
                        }
                    }

                    $vMontoRealPago = ($Cantidad - (($vMontoDescuentoCapital)+ $vMontoDescuentoMora));
                             
                    $IngresoVia = 3;
                    
                    if ($IdTipoTramite == 2 )
                    {
                        $CveAbono = 79;
                    }
                    else 
                    {
                        $CveAbono = 78;
                    }  
        
                   // $DescuentoAutorizado = 0;            
                    $distribuye_pago = distribuye_pago($NumContrato,$fechaRecibo,0,$vMontoRealPago,$nitavu,$CveCargo,$FormaPago,$OrigenDeEnvio);
                    
                    if  ($distribuye_pago =='TRUE')
                    {
                        $NumeroMovimiento = NumMov($NumContrato);
                        // $pagos_parciales=Registra_PagosParciales($vMontoRealPago ,$vMontoRealPago,$NumContrato,$fechaRecibo,NULL,$FolioRecibo,
                        // $LugarExpedicion,$NumeroMovimiento,$IngresoVia,$factormoneda,$nitavu,$contador_puntos);          
                      
                        //if( $pagos_parciales=='TRUE')
                       // { 
                            historia($nitavu, "Liquidacion de cuenta, campaña de descuentos 2018, contrato='".$NumContrato."' Folio Recibo".$FolioRecibo);                 
                            $ProcedimientoCorrecto='TRUE';
                           // actualizarFolioRecibo($FolioRecibo);
                            historia($nitavu,'Registro de Descuento de moratorios al liquidar, campaña.(TablaPagosParciales; NumContrato: '.$NumContrato.", FolioRec:".$FolioRecibo.")");
                            echo modalSinRedirigir( "Pago registrado satisfactoriamente con el número de folio " .$FolioRecibo); echo  "Pago registrado satisfactoriamente con el número de folio " .$FolioRecibo. "&";
                           
                        // }else
                        // {   
                        // echo  '6. Ocurrio un error, favor de intentarlo nuevamente. (pagos Parciales)';
                        // Destruye_HistoricoPagos($NumContrato, $NumeroCuentaAntes,1) ; //TODOS()
                        // ActivarODesactivarDescuento(1,$nitavu,$NumContrato,125); //ACTIVAR DESCUENTO
                        // Destruye_PagosParciales($NumContrato, $NumeroCuentaAntes,1) ;
                        // $ProcedimientoCorrecto='FALSE';
                        // echo modalSinRedirigir("Al parecer ha ocurrido un problema en el almacenamiento total, marco error la sección de PAGOS PARCIALES");
                        //}
                    }
                    else
                    {
                        //Eliminamos de HistoricoPagos
                        Destruye_HistoricoPagos($NumContrato, $NumeroCuentaAntes,1) ; //TODOS()
                        ActivarODesactivarDescuento(1,$nitavu,$NumContrato,125); //ACTIVAR DESCUENTO
                       // Destruye_PagosParciales($NumContrato, $NumeroCuentaAntes,1) ;
                        $ProcedimientoCorrecto='FALSE';
                        echo modalSinRedirigir("Al parecer ha ocurrido un problema en el almacenamiento total, marco error la sección de HISTORICOPAGOS");
                    }
                      
                    // }
                    // else
                    // {  //Eliminamos de HistoricoPagos EL PRIMER INSERT
                    //     Destruye_HistoricoPagos($NumContrato, $NumeroMovimiento,0) ;
                    //     echo modalSinRedirigir("Al parecer ha ocurrido un problema en el almacenamiento del descuento de moratorios, marco error la sección de PAGOS PARCIALES");
                    //     $ProcedimientoCorrecto='FALSE';
                    // }
                }else
                {   $ProcedimientoCorrecto='FALSE';
                    echo modalSinRedirigir("Al parecer ha ocurrido un problema en el almacenamiento del descuento de moratorios, marco error la sección de HISTORICOPAGOS");
                }
            
            
            }
            else 
            {
                /*============================================================================== */
                    //Rem se cancela el descuento
                    //Rem se agrega cancelacion del descuento autorizado por delegado
                    //Rem se cambia estatus del descuento
                /*============================================================================== */
                $sql1 = "Select *  from autorizaciondescuentos  Where NumContrato = '". $NumContrato . "' and TipoDescuento=125 And Activo = 1";
                $rc1 = $Vivienda -> query($sql1);
                $r_count1 = $rc1 -> num_rows;
                if($r_count1 > 0){
                while($f1 = $rc1 -> fetch_array()){
                        $sql2 = "UPDATE autorizaciondescuentos Set Activo=0,Enviar = 1 ,IdEmpModifica='".$nitavu."',FechaAplicacion=NOW(), FechaUltimaMod=NOW() where NumContrato='".$NumContrato . "' and TipoDescuento=125 And Activo = 1";
                    //echo $sql2;
                    if ($Vivienda->query($sql2) == TRUE){   
                            $res = 'TRUE';
                    }
                    else
                    {
                            echo  '4. Ocurrio un error, favor de intentarlo nuevamente';
                    }

                    }
                }
            }      
    
        }        
        break;

    case 2:  
        /*============================================================================== */
                                        //DESCUENTO A MORATORIOS
        /*============================================================================== */

        $IngresoVia = 6;
        $vMontoDescuentoMora = $DescuentoAutorizado;
         //SE REGISTRA EL MONTO DE DESCUENTO A MORATORIO AL LIQUIDAR EN HISTORICOPAGOS         
        $distribuye_pago = distribuye_pago($NumContrato,$fechaRecibo,0,$vMontoDescuentoMora,$nitavu,$CveCargo,$FormaPago,$OrigenDeEnvio);
       
        if  ($distribuye_pago =='TRUE')
        {         
            $NumeroMovimiento = NumMov($NumContrato);          
            /********************************************************************* */        
            //ALMACENAMOS EN LA TABLA PAGOS PARCIALES LOS DATOS DEL PAGO Y RECIBO QUE ACABAMOS DE INSERTAR EN HISTORICOPAGOS   
            // $pagos_parciales=Registra_PagosParciales($vMontoDescuentoMora ,$vMontoDescuentoMora,$NumContrato,$fechaRecibo,NULL,$FolioRecibo,
            // $LugarExpedicion,$NumeroMovimiento,$IngresoVia,$factormoneda,$nitavu,$contador_puntos);
            
            
            // if( $pagos_parciales=='TRUE')
            // {
                 //ACTUALIZAMOS EL TIPO MOVIMIENTO DEL REGISTRO INSERTADO EN HISTORICO PAGOS
                $sql = "UPDATE historicopagos Set TipoMov = 125, origen='DSC'  where NumContrato='".$NumContrato."'  and MontoPagoRecibido = " .$vMontoDescuentoMora. " and NumMov = ".$NumeroMovimiento;
                //echo $sql;
                if ($Vivienda->query($sql) == TRUE){   
                    $res = 'TRUE';          
                }
                else
                {   
                    echo  '2. Ocurrio un error, favor de intentarlo nuevamente. (historicopagos)';
                } 
                
                /********************************************************************* */
                // Rem se cambia estatus del descuento Y obtenemos el sustento  
                $sustentoautorizacion='';   
                $sql2 = "Select *  from autorizaciondescuentos  Where NumContrato = '". $NumContrato . "' and TipoDescuento=125 And Activo = 1";
                $rc2 = $Vivienda -> query($sql2);
                $r_count2 = $rc2 -> num_rows;
                if($r_count2 > 0){
                while($f2 = $rc2 -> fetch_array()){

                $sustentoautorizacion = $f2['SustentoAutorizacion'];
                ActivarODesactivarDescuento(0,$nitavu,$NumContrato,125) ;//ACTIVAR DESCUENTO
                $NumeroMovimiento = NumMov($NumContrato);  
                /* ACTUALIZAMOS LA OBSERVACION EL REGISTRO QUE ACABAMOS DE INSERTAR*/ 
                $sql2 = "UPDATE  historicopagos set observaciones='" .$sustentoautorizacion. "'  where numcontrato='" .$NumContrato."' and nummov=" .$NumeroMovimiento;
                //echo $sql;
                    if ($Vivienda->query($sql2) == TRUE){   
                        $res = 'TRUE';
                    }
                    else
                    {
                                echo  '5. Ocurrio un error, favor de intentarlo nuevamente';
                    }     
                 }
                }

                $vMontoRealPago = ($Cantidad- $vMontoDescuentoMora);       
                historia($nitavu, "Registro de Descuento de moratorio, campaña de descuentos 2018, contrato='".$NumContrato."' Folio Recibo".$FolioRecibo);    
                $IngresoVia = 3;

                if(  tipoTramitePrograma($IdPrograma) == 2 )
                {
                    $CveAbono = 79;  
                }else {
                    $CveAbono = 78; 
                    
                }
                
                /*============================================================================== */
                                //INSERTA EL REGISTRO POR EL TOTAL (IMPORTE MENOS EL DESCUENTO)
                /*============================================================================== */
                $distribuye_pago = distribuye_pago($NumContrato,$fechaRecibo,0,$vMontoRealPago,$nitavu,$CveCargo,$FormaPago,$OrigenDeEnvio);
                if  ($distribuye_pago =='TRUE')
                {                
                    //ACTUALIZAMOS EL TIPO MOVIMIENTO DEL REGISTRO INSERTADO
                    $sql = "UPDATE historicopagos Set TipoMov = ".$CveAbono ."   where NumContrato='".$NumContrato."'  and MontoPagoRecibido = " .$MontoRealPago. " and NumMov = ".$NumeroMovimiento;
                    //echo $sql;
                    if ($Vivienda->query($sql) == TRUE){   
                            $res = 'TRUE';        
                            
                    }
                    else
                    {  
                         echo  '2. Ocurrio un error, favor de intentarlo nuevamente. (historicopagos)';
                    }  
                    $NumeroMovimiento = NumMov($NumContrato); 
                    //ALMACENAMOS EN LA TABLA PAGOS PARCIALES LOS DATOS DEL PAGO Y RECIBO QUE ACABAMOS DE INSERTAR EN HISTORICOPAGOS   
                    // $pagos_parciales=Registra_PagosParciales($vMontoRealPago ,$vMontoRealPago,$NumContrato,$fechaRecibo,NULL,$FolioRecibo,
                    // $LugarExpedicion,$NumeroMovimiento,$IngresoVia,$factormoneda,$nitavu,$contador_puntos);
                    //if( $pagos_parciales=='TRUE')
                   // {
                            historia($nitavu, "Liquidacion de cuenta, campaña de descuentos 2018, contrato='".$NumContrato."' Folio Recibo".$FolioRecibo);  
                            historia($nitavu,'Registro de Descuento de moratorios al liquidar, campaña.(TablaPagosParciales; NumContrato: '.$NumContrato.", FolioRec:".$FolioRecibo.")");
                           echo modalSinRedirigir(  "Pago registrado satisfactoriamente con el número de folio " .$FolioRecibo); 
                           $ProcedimientoCorrecto='TRUE';
                          
                    // }else
                    // {    
                        // //Eliminamos de HistoricoPagos
                        // Destruye_HistoricoPagos($NumContrato,  $NumeroCuentaAntes,1) ;//(TODOS)
                        // ActivarODesactivarDescuento(1,$nitavu,$NumContrato,125) ;//ACTIVAR DESCUENTO
                        // Destruye_PagosParciales($NumContrato,$NumeroCuentaAntes,1) ;
                        // $ProcedimientoCorrecto='FALSE';
                        // echo modalSinRedirigir("Ocurrio un error al querer insertar en pagos parciales el pago del total ( importe menos el descuento).");
                    //}



                     
                }else
                {  //Eliminamos de HistoricoPagos
                    Destruye_HistoricoPagos($NumContrato, $NumeroCuentaAntes,1) ;//(TODOS)
                    ActivarODesactivarDescuento(1,$nitavu,$NumContrato,125); //ACTIVAR DESCUENTO
                    //Destruye_PagosParciales($NumContrato, $NumeroCuentaAntes,1) ;
                    $ProcedimientoCorrecto='FALSE';
                    echo modalSinRedirigir("Ocurrio un error al querer insertar en historico pagos el registro del total (importe menos el descuento).");
                    
                }

        // }
        // else
        // {     
        //     $NumeroMovimiento = NumMov($NumContrato); 
        //     Destruye_HistoricoPagos($NumContrato, $NumeroMovimiento,0) ; //ELIMINA EL PRIMER INSERT          
        //     $ProcedimientoCorrecto='FALSE'; 
        //     echo modalSinRedirigir( "Al parecer ha ocurrido un problema en el almacenamiento del descuento, marco error la sección de PAGOSPARCIALES.");
        // }
              
        }
        else
        {  $ProcedimientoCorrecto='FALSE';
           echo  modalSinRedirigir( "Al parecer ha ocurrido un problema en el almacenamiento del descuento, marco error la sección de HISTORICOPAGOS.");
        }
            
       
        //$BhayDescuento = 0;
        //$DescuentoAutorizado = 0;       

        break;
        
    case 3:
        
        //  OJO NO SE UTILIZA POR QUE SOLO E APLICABA PARA EL 2018
         //mensualidad gratis por cumplimiento   
        // revisar no aplicar de nuevo

        $BAplicoGratis = 0;
        $sql = "select * from historicopagos where tipomov in (123) and cancelado=0 and numcontrato='" .$NumContrato. "'";      
        if($r_count2 > 0){
            $BAplicoGratis = 1;  //ya existe un registro de una bonificacion
            }
        else
        {
            $BAplicoGratis = 0; //'no existe un registro de una bonificacion
        }

        $BAplicoGratis = 1 ;      //Esto es para que no entre la bonificacion gratis

        if ($BAplicoGratis = 1 and $txtPeriodos  > 0 )
        {
                $time = time();
                $fechaRecibo=date("Y-m-d H:i:s", $time);              
                //Rem carga control contratos de nuevo
                include("./determinamontos.php"); 
                //Call cerrar_periodo-- Lo esta haciendo flor
                include("./cerrar_periodo.php");
                $lblfechasuperior.= $fecha_superiorCamp;
        }
        
           /// $IngresoVia = ProcedureIngresoVia; falta  hacer
            
            if  (tipoTramitePrograma($IdPrograma) ==2) 
            {
                $CveAbono = 79;
            }
               
            else
            {
                $CveAbono = 78;
            }
                           
            
           
                if($txtPeriodos > 0)
                {
                    ($Cantidad /$txtPeriodos);
                    $distribuye_pago = distribuye_pago($NumContrato,$fechaRecibo,0,  ($Cantidad /$txtPeriodos),$nitavu,$CveCargo,$FormaPago,$OrigenDeEnvio);

                   // $pagos_parciales=Registra_PagosParciales( ($Cantidad /$txtPeriodos) , ($Cantidad /$txtPeriodos),$NumContrato,$fechaRecibo,NULL,$FolioRecibo,$LugarExpedicion,$NumeroMovimiento,$IngresoVia,$factormoneda,$nitavu,$contador_puntos);
        
                }else{
                    $Cantidad;
                    $distribuye_pago = distribuye_pago($NumContrato,$fechaRecibo,0,$Cantidad,$nitavu,$CveCargo,$FormaPago,$OrigenDeEnvio);

                    //$pagos_parciales=Registra_PagosParciales($Cantidad ,$Cantidad,$NumContrato,$fechaRecibo,NULL,$FolioRecibo,$LugarExpedicion,$NumeroMovimiento,$IngresoVia,$factormoneda,$nitavu,$contador_puntos);
        
                }

                historia($nitavu, "Folio del recibo " .$FolioRecibo. " por ".$Cantidad);    

               
               

                if ($BAplicoGratis == 0 )
                {
                    $ActivaSegundoRecibo = True;
                    $mensaje1= "El BENEFICIARIO se ha hecho acreedor a una mensualidad gratis por su puntualidad de pago en el año próximo pasado, esto debido a una campaña de descuentos vigente";
                
                    //txtFecha.text = fechaRecibo revisar
                    //Call cerrar_periodo //FLOR. 
                    include("./cerrar_periodo.php"); 
                    $Descuento = "0";
                    $Cantidad=  MontoPagoNumContrato($NumContrato);
                    include("./determinamontos.php");                      
                    
                     $IngresoVia = 6;
                        if ($MontoSaldarPesos <  $Cantidad )
                        {
                            $Cantidad = $MontoSaldarPesos;
                                                       
                            $distribuye_pago = distribuye_pago($NumContrato,$fechaRecibo,0,$MontoSaldarPesos,$nitavu,$CveCargo,$FormaPago,$OrigenDeEnvio);
                
                            $sql = "UPDATE historicopagos Set TipoMov = 123 ,origen='DSC'   where NumContrato='".$NumContrato."'  and MontoPagoRecibido = " .$MontoRealPago. " and NumMov = ".$NumeroMovimiento;
                            //echo $sql;
                            if ($Vivienda->query($sql) == TRUE){   
                                $res = 'TRUE';        
                                
                            }
                            else
                            {   echo  '2. Ocurrio un error, favor de intentarlo nuevamente. (HistoricoPagos)';
                            }     
                                                       
                            //$pagos_parciales=Registra_PagosParciales($Cantidad ,$Cantidad,$NumContrato,$fechaRecibo,NULL,$FolioRecibo,$LugarExpedicion,$NumeroMovimiento,$IngresoVia,$factormoneda,$nitavu,$contador_puntos);
                            //Call imp_recibo_laser
                            //Call imp_recibo_laser

                        }
                        
                    else
                    {
                       
                        $distribuye_pago = distribuye_pago($NumContrato,$fechaRecibo,0,$Cantidad,$nitavu,$CveCargo,$FormaPago,$OrigenDeEnvio);                                  
                        
                        $sql = "UPDATE historicopagos Set TipoMov = 123 ,origen='DSC'  where NumContrato='".$NumContrato."'  and MontoPagoRecibido = " .$MontoRealPago. " and NumMov = ".$NumeroMovimiento;
                            //echo $sql;
                            if ($Vivienda->query($sql) == TRUE){   
                                $res = 'TRUE';        
                                
                            }
                            else
                            {   echo  '2. Ocurrio un error, favor de intentarlo nuevamente. (HistoricoPagos)';
                            }     

                           // $pagos_parciales=Registra_PagosParciales($Cantidad ,$Cantidad,$NumContrato,$fechaRecibo,NULL,$FolioRecibo,$LugarExpedicion,$NumeroMovimiento,$IngresoVia,$factormoneda,$nitavu,$contador_puntos);
                       
                       
                    }

                }              
                
            echo "Pago registrado satisfactoriamente con el número de folio " .$FolioRecibo. ". para cualquier duda o aclaración puedes consulta el estado de cuenta del beneficiario";
     
        break;

    case 4:    

            /*============================================================================== */
                                        //APLICA DESCUENTO DE ESCRITURA
            /*============================================================================== */

            $IngresoVia = 6;           
            $distribuye_pago= distribuye_pago($NumContrato,$fechaRecibo,0,$Descuento,$nitavu,$CveCargo,$FormaPago,$OrigenDeEnvio);    
                     
            if  ($distribuye_pago =='TRUE')
            {             
            
                // //INSERTA EN PAGOS PARCIALES 
                // $pagos_parciales=Registra_PagosParciales($Cantidad ,$Descuento,$NumContrato,$fechaRecibo,NULL,$FolioRecibo,$LugarExpedicion,$NumeroMovimiento,$IngresoVia,$factormoneda,$nitavu,$contador_puntos);
                // if( $pagos_parciales=='TRUE')
                // {

                /********************************************************************* */
                //CAMBIA EL TIPO MOVIMIENTO EN HISTORICOPAGOS
                $sql = "UPDATE historicopagos Set TipoMov = 126 ,origen='DSC'    where NumContrato='".$NumContrato."'  and MontoPagoRecibido = " .$Descuento. " and NumMov = ".$NumeroMovimiento;
                //ECHO "<BR>";
                //echo 'SQL 42 '.$sql;
                if ($Vivienda->query($sql) == TRUE){   
                    $res = 'TRUE';      
                }
                else
                {   
                    echo  '2. Ocurrio un error, favor de intentarlo nuevamente. (HistoricoPagos)';
                }  

                /********************************************************************* */
                //ACTUALIZA EL STATUS DEL DESCUENTO 
                ActivarODesactivarDescuento(0,$nitavu,$NumContrato,126);//DESACTIVAR DESCUENTO         

                /********************************************************************* */           

                historia($nitavu, "Descuento de escritura, campaña de descuentos por  " .$Descuento. "NumContrato". $NumContrato);    

                /*============================================================================== */
                                //INSERTA EL REGISTRO POR EL TOTAL ( IMPORTE MENOS EL DESCUENTO)
                /*============================================================================== */
                $IngresoVia = 3;                 
                $distribuye_pago=distribuye_pago($NumContrato,$fechaRecibo,0,$Importe,$nitavu,$CveCargo,$FormaPago,$OrigenDeEnvio);    
                if  ($distribuye_pago =='TRUE')
                {             
                $NumeroMovimiento = NumMov($NumContrato);
                //INSERTA EN PAGOS PARCIALES
                    // $pagos_parciales=Registra_PagosParciales($Importe ,$Importe,$NumContrato,$fechaRecibo,NULL,$FolioRecibo,$LugarExpedicion,$NumeroMovimiento,$IngresoVia,$factormoneda,$nitavu,$contador_puntos);
                    // if( $pagos_parciales=='TRUE')
                    // {
                        /********************************************************************* */
                        //CAMBIA EL TIPO MOVIMIENTO EN HISTORICOPAGOS
                        $sql = "UPDATE historicopagos Set TipoMov = 58    where NumContrato='".$NumContrato."'  and MontoPagoRecibido = " .$Importe. " and NumMov = ".$NumeroMovimiento;
                        // echo 'SQL 43 '.$sql;
                        if ($Vivienda->query($sql) == TRUE){   
                            $res = 'TRUE';     
                        }
                        else
                        {  
                            echo  '3. Ocurrio un error, favor de intentarlo nuevamente. (HistoricoPagos)';
                        }   
                        $CveAbono = 58;
                        historia($nitavu, "pago de escritura 50% descto, campaña de descuentos 2018; FolioRecibo  " .$FolioRecibo. "NumContrato". $NumContrato);         //$BhayDescuento = 0;
                        //$DescuentoAutorizado = 0;
                        echo modalSinRedirigir(  "Pago registrado satisfactoriamente con el número de folio " .$FolioRecibo); 
                        $ProcedimientoCorrecto='TRUE';
                        //actualizarFolioRecibo($FolioRecibo);
                    // }
                    // else
                    // {
                    //     Destruye_HistoricoPagos($NumContrato,$NumeroCuentaAntes,1) ; 
                    //     ActivarODesactivarDescuento(1,$nitavu,$NumContrato,126);//ACTIVAR DESCUENTO   
                    //     Destruye_PagosParciales($NumContrato, $NumeroCuentaAntes,1) ;
                    //     $ProcedimientoCorrecto='FALSE';      
                    //     echo modalSinRedirigir( "Al parecer ha ocurrido un problema en el almacenamiento del total (importe menos el descuento), marco error la sección de PAGOSPARCIALES");
                    //     //ELIMINAR PAGOS PARCIALES       
                    // }
                }
                else        
                {
                    Destruye_HistoricoPagos($NumContrato,$NumeroCuentaAntes,1) ;
                    ActivarODesactivarDescuento(1,$nitavu,$NumContrato,126); //ACTIVAR DESCUENTO
                    //Destruye_PagosParciales($NumContrato, $NumeroCuentaAntes,1) ;
                    $ProcedimientoCorrecto='FALSE';
                    echo modalSinRedirigir( "Al parecer ha ocurrido un problema en el almacenamiento del total (importe menos el descuento), marco error la sección de HISTORICOPAGOS.");
                }   
            //}
            // else 
            // {  //DESTRUYE EL PRIMER INSERT EN HISTORICOPAGOS EL DEL DESCUENTO
            //    Destruye_HistoricoPagos($NumContrato, $NumeroMovimiento,0) ;
            //    $ProcedimientoCorrecto='FALSE';
            //    echo modalSinRedirigir( "Al parecer ha ocurrido un problema en el almacenamiento del descuento, marco error la sección de PAGOSPARCIALES.");
            // }                   
        }else
        {   $ProcedimientoCorrecto='FALSE';
            echo modalSinRedirigir( "Al parecer ha ocurrido un problema en el almacenamiento del descuento, marco error la sección de HISTORICOPAGOS. ");
        }
        break;
}
?>