<?php
require_once("config.php");
require_once("lib/funciones.php");
require_once("lib/flor_funciones.php");
require_once("lib/yes_funciones.php");

    //OBTENEMOS DATOS PARA REACTIVAR

    $NumContrato = $_POST['numcontrato'];
    $nitavu = $_POST['nitavu'];
    $iddelegacion = $_POST['iddelegacion'];
    $idprograma = $_POST['idprograma'];
    $folio = $_POST['folio'];
    $observaciones = $_POST['observaciones'];
    $tipoPrograma =  tipoTramitePrograma($idprograma);
    if($tipoPrograma == 2){
    $IdLote = IdLoteNumContrato($NumContrato);
    }

    //OBTENER ULTIMO MOVIMIENTO DE LA CUENTA ANTES DE ELIMINAR PARA SABER HASTA CUAL ELIMINAR
    $ultimoMov = ultimoMovimientoAntesdeCancelar($NumContrato);
    if($ultimoMov <> ''){
        $movimientoCancelacion = $ultimoMov + 1;

        $tipoCancelacion = tipoCancelacion($NumContrato);

        $maxMov = obtenerMovimientoConsecutivo($NumContrato);
        $nuevoMov = $maxMov + 1;
        $saldoCapitalCorriente = sumasaldoCapitalCorriente($NumContrato, $maxMov);
        $saldoExento = obtenerSaldoExcentoUltimoMovCuenta($NumContrato,$maxMov);
    
      

        $observacionesAntiguas = observacionesAntiguas($NumContrato);

        $observacionesReactivacion = $observacionesAntiguas.' - '.$observaciones;
            //caso devolucion y trasnferencia
            //Actualizamos movimientos a cancelado en 1 y el ultimo que tiene tipo mov 141 queda activo
            $sql = 'UPDATE historicopagos SET Cancelado = 1 WHERE NumContrato = "'.$NumContrato.'" and NumMov > '.$ultimoMov.' and TipoMov NOT IN(141,142)';
            //echo $sql;
            if ($Vivienda->query($sql) == TRUE){   
                $res = 'TRUE';
            }else{
                $res = 'FALSE';
            }
            //se corre saldos para ingresar moratorios en historico pagos
            //funcion para correr saldos queda pendiente... 
        
            if($tipoCancelacion == 1){
                //insertar registro en historico pagos para reactivar nummov 142
                $sql = "INSERT INTO historicopagos (numcontrato, nummov, montopagorecibido,fechaoperacion, SaldoCapitalCorriente, origen,tipomov,enviar, 
                fechacaptura, idempcrea, Observaciones, saldoexento,cancelado,origindata) values ('".$NumContrato."',".$nuevoMov.", 0, NOW(), ".$saldoCapitalCorriente.",'CAN', 142, 1, now(),
                ".$nitavu.",'".$observaciones."',".$saldoExento.",0,".$iddelegacion.")";
                //echo $sql;
                if ($Vivienda->query($sql) == TRUE){   
                // historia($nitavu, "SE INSERTO REGISTRO EN HISTORICO PAGOS PARA CANCELAR EL CONTRATO ".$NumContrato." POR FINANCIAMIENTO IMPROCEDENTE"); 
                    $res = 'TRUE';
                    $nuevoMov = $nuevoMov + 1;
                }else{
                    $res = 'FALSE';
                }
            }

                
            //CASO TRANSFERENCIA
        if($tipoCancelacion == 2){
            //buscar el folio al que se transfirio en la tabla datoscancelacion
            $FolioDestino = FolioDestinoCancelacion($NumContrato);
            $IdProgramaDestino = IdProgramaDestinoCancelacion($NumContrato);
            $IdDelegacionDestino = IdDelegacionDestinoCancelacion($NumContrato);
            $FolioRec = $IdProgramaDestino . str_pad($folio, 5, "0", STR_PAD_LEFT);
            
            $maxpagonvofolio=NumeroDePago($IdDelegacionDestino, $IdProgramaDestino, $FolioDestino);

            $Importe = ImportePagoporTransferencia($FolioDestino, $IdProgramaDestino, $IdDelegacionDestino, $FolioRec);
            
            //Insertamos pagos por la msima cantidad pero en negativo
            $sql = "insert into pagos (iddelegacion,idprograma,folio,foliorec,cancelado,enviar,fechacaptura,idempcrea,importe,numpago,fecha,observaciones,idtipomov) 
            values ('".$IdDelegacionDestino."','".$IdProgramaDestino."','".$FolioDestino."','".$FolioRec."1', 0, 1, now(),'".$nitavu."',".$Importe."*-1, '".$maxpagonvofolio."',now(),'SE INGRESA ESTE REGISTRO POR REACTIVACION', 19)";
            //echo $sql;
            if ($Vivienda->query($sql) == TRUE){   
                $res = 'TRUE';
            }else{
                $res = 'FALSE';
            }

        
            //bajarian los datos del ultimo pago? o que onda que pasaria??


            //insertamos en historico pagos el registro que se metio en pagos cuidar las fechas
            $sql = "insert into historicopagos (numcontrato,nummov,montopagorecibido,fechaoperacion,saldocapitalcorriente,origen,tipomov,enviar, 
            fechacaptura,idempcrea,capitalperiodo,saldoexento,cancelado,origindata,Observaciones) 
            values ( '".$NumContrato."','".$nuevoMov."', '".$Importe."', now(),'".$saldoCapitalCorriente."','PCA', 19, 1, now(),'".$nitavu."','".$Importe."','".$saldoExento."',0,'".$iddelegacion."','".$observaciones."')";
            //echo $sql;
            if ($Vivienda->query($sql) == TRUE){   
                // historia($nitavu, "SE INSERTO REGISTRO EN HISTORICO PAGOS PARA CANCELAR EL CONTRATO ".$NumContrato." POR EL VALOR DEL CREDITO");  
                $res = 'TRUE';
                $nuevoMov = $nuevoMov + 1;  
            }else{
                $res = 'FALSE';
            }
        }
        

    


        //actualizamos lotes, sacamos IdLote de contratos y se pasan los datos de IdPrograma, IdDelegacion y Folio
        //UPDATE lotes SET IdDelegacion=NULL, IdPrograma=NULL, Folio=NULL, NumContrato=NULL,contratado=0,FechaUltimaMod=NOW(),IdEmpModifica='".$nitavu."' ,IdEstatus='".$opCancelacionLote."' WHERE idLote=".$idlote
        if($tipoPrograma == 2){
            $sql ='UPDATE lotes SET IdDelegacion = '.$iddelegacion.', IdPrograma = '.$idprograma.', Folio = '.$folio.', NumContrato = '.$NumContrato.', contratado = 1, FechaUltimaMod = NOW(), IdEmpModifica='.$nitavu.', IdEstatus = 2 WHERE idLote= '.$IdLote.'';
            //echo $sql;
            if ($Vivienda->query($sql) == TRUE){   
                // historia($nitavu, "SE INSERTO REGISTRO EN HISTORICO PAGOS PARA CANCELAR EL CONTRATO ".$NumContrato." POR EL VALOR DEL CREDITO");  
                $res = 'TRUE';
            }else{
                $res = 'FALSE';
            }
        }else{
            
            //actualizamos ministracion credito
            //update ministracioncredito set Cancelado=1,FechaUltimaMod=NOW(), Enviar=1, IdEmpModifica=" .$nitavu. " where NumContrato='" .$NumContrato. "' and Cancelado=0
            $sql = 'UPDATE ministracioncredito SET Cancelado = 0, FechaUltimaMod = NOW(), Enviar = 1, IdEmpModifica='.$nitavu.' WHERE NumContrato = '.$NumContrato.'';
            //echo $sql;
            if ($Vivienda->query($sql) == TRUE){   
                // historia($nitavu, "SE INSERTO REGISTRO EN HISTORICO PAGOS PARA CANCELAR EL CONTRATO ".$NumContrato." POR EL VALOR DEL CREDITO");  
                $res = 'TRUE';
            }else{
                $res = 'FALSE';
            }

        }


        //actualizamos controlcontratos
        //update controlcontratos set estatuscuenta=6,fechaultimamod=NOW(), enviar=1,IDEMPMODIFICA=" .$nitavu. " where numcontrato='".$NumContrato."'
        $sql = 'UPDATE controlcontratos SET estatuscuenta=2, FechaUltimaMod = NOW(), Enviar = 1, IdEmpModifica='.$nitavu.' WHERE NumContrato = '.$NumContrato.'';
        //echo $sql;
        if ($Vivienda->query($sql) == TRUE){   
            // historia($nitavu, "SE INSERTO REGISTRO EN HISTORICO PAGOS PARA CANCELAR EL CONTRATO ".$NumContrato." POR EL VALOR DEL CREDITO");  
            $res = 'TRUE';
        }else{
            $res = 'FALSE';
        }


        //actualizamos soliciud  que habiamos cancealdo al cancelar el contrato
       
        $sql = 'UPDATE solicitudes SET Cancelado=0 WHERE IdDelegacion = '.$iddelegacion.' and IdPrograma = '.$idprograma.' and Folio = '.$folio;
        //echo $sql;
        if ($Vivienda->query($sql) == TRUE){  
           
            $res = 'TRUE';
        }else{
            $res = 'FALSE';
        }

        if($tipoCancelacion <> 3){
            //actualizamoc contratos
            //UPDATE contratos SET enviar=1, idempmodifica=" .$nitavu.",fechaultimamod=now(),fechacancelacion=NOW(),CANCELADO=1, Observaciones='".$observacionesCancelacion."' WHERE NumContrato = '" .$NumContrato. "'";
            $sql = "UPDATE contratos SET enviar=1, idempmodifica=" .$nitavu.",fechaultimamod=now(), Cancelado = 0, Observaciones='".$observacionesReactivacion."' WHERE NumContrato = '" .$NumContrato. "'";
            //echo $sql;
            if ($Vivienda->query($sql) == TRUE){   
                // historia($nitavu, "SE INSERTO REGISTRO EN HISTORICO PAGOS PARA CANCELAR EL CONTRATO ".$NumContrato." POR EL VALOR DEL CREDITO");  
                $res = 'TRUE';
            }else{
                $res = 'FALSE';
            }
        }

        //CANCELAR LA ULTIMA CANCELACION ACTIVA DE ESTE CONTRATO
        $ultimaCancelacion = fechaUltimaCancelacion($NumContrato);
        $sql = 'UPDATE datoscancelacion SET Cancelado = 1 WHERE NumContrato = "'.$NumContrato.'" and FechaCancelacion = "'.$ultimaCancelacion.'"';
        //echo $sql;
        if ($Vivienda->query($sql) == TRUE){   
            // historia($nitavu, "SE INSERTO REGISTRO EN HISTORICO PAGOS PARA CANCELAR EL CONTRATO ".$NumContrato." POR EL VALOR DEL CREDITO");  
            $res = 'TRUE';
        }else{
            $res = 'FALSE';
        }

        
        if($res == 'TRUE'){
            mensaje('Se ha reactivado el contrato con éxito', 'cancelarContrato.php');
        }else{
            mensaje('Hubo un error al momento de reactivar el contrato, favor de intentarlo de nuevo.', 'cancelarContrato.php');
        }
    }else{


      
    echo "No hace nada";
        //SI NO ES POR PLATAFORMA Y ES ANTERIOR
        //COMO DEBERIA DE SER???

        //Si fuese devolucion como lo sé?
        
        //se borra historico pagos, pero como sé cual era su movimiento antes de insertar devolucion

        //Si fue transferencia hay en pagos, pero no tengo el registro del nuevo folio al que se fue
        //Si fue defuncion 
       

        
    }

    //como saber que tipo de cancelación fue??
    //DEVOLUCION 
    //HISTORICOSPAGOS
    //LOTES
    //ESCRITURAS
    //MINISTRACION CREDITO

    //TRASNFERENCIA
    //historico pagos
    //pagos hay registro si fue por transferencia
    //obtener el lote 
    //escritura
    //ministracion credito
    
    //DEFUNCION 
    //historico pagos

    //TODOS
    //control contratos
    //contratos
               


?>
