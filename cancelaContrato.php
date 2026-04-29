<?php
require_once("config.php");
require_once("lib/funciones.php");
require_once("lib/flor_funciones.php");
require_once("lib/yes_funciones.php");

//OBTENEMOS DATOS PARA CANCELAR


        /**********VARIABLE QUE OCUAPREMOS MAS ADELANTE*****************/
        $NumContrato = $_POST['numcontrato'];
        $nitavu = $_POST['nitavu'];
        $numcancelacion=  SigNumCancelacion($NumContrato);
        $idlote='';
        if(isset($_POST['idlote'])){
            $idlote = $_POST['idlote'];
        }
        
        
        /* ***********DATOS FOLIO ACTUAL********** */  
        //obtenemos el IdDelegacion del Folio actual
        if(isset($_POST['iddelegacion'])){
            $iddelegacion = $_POST['iddelegacion'];
        }      

        //obtenemos el IdPrograma del Folio Actual
        if(isset($_POST['idprograma'])){
            $idprograma = $_POST['idprograma'];
        }       
         //obtenemos el Folio Actual
         if(isset($_POST['folio'])){
            $folio = $_POST['folio'];
        }



        $tipoPrograma =  tipoTramitePrograma($idprograma);
     
        $iddelegacionnvo=0; 
        $idprogramanvo=0;
        $folionvo=0;

        //************DATOS FOLIO NUEVO**********        
        //obtenemos el IdDelegacion del Folio Nuevo
        if (isset($_POST['delegaciones'])) {
            if (!empty($_POST['delegaciones'])) {
                $iddelegacionnvo = $_POST['delegaciones'];
            }
        }

            //obtenemos el IdPrograma del Folio Nuevo
        if (isset($_POST['programa'])){
            if (!empty($_POST['programa'])) {
                $idprogramanvo = $_POST['programa'];
            }
        }

        //obtenemos el IdDelegacion del Folio Nuevo
        if (isset($_POST['_folio'])) {
            if (!empty($_POST['_folio'])) {
                $folionvo = $_POST['_folio'];
            }
        }


        $observacionesCancelacion='';
        $opCancelacionLote='';
        if($tipoPrograma==2){
            if (!empty(isset($_POST['cancelacion']))){
                $opCancelacionLote = $_POST['cancelacion'];           

            }else if(!empty(isset($_POST['observaciones']))){
                $observacionesCancelacion = $_POST['observaciones']; 
            }else{
                mensaje('Es necesario que proporcione el motivo de la cancelacion','cancelarContrato.php?q='.$NumContrato.'');
                return;

            }  
        }else{
            if(isset($_POST['observaciones'])){
                $observacionesCancelacion = $_POST['observaciones'];
            } 
        }

        
        $numCheque=''; $fechaCheque='';

        $opcion = $_POST['opciones'];

        if($opcion == '1'){
            $numCheque = $_POST['folioCheque'];
            $fechaCheque = $_POST['fechaCheque'];
            if($_POST['folioCheque']=='' or $_POST['fechaCheque'] == ''){
                mensaje('Es necesario que proporcione los datos completos del cheque','cancelarContrato.php?q='.$NumContrato.'');
                return;
            }
        }
        
       
     

        $res ='';
        $aplicaGastos=0;
        if(isset($_POST['gridCheck'])){
            $aplicaGastos = $_POST['gridCheck'];
        }

        $aplicaGastosT=0;
        if(isset($_POST['gridCheckT'])){
            $aplicaGastosT = $_POST['gridCheckT'];
        }

        
        $cargoAdmin = 0;
        if(isset($_POST['cargoAdmin'])){
            $cargoAdmin = $_POST['cargoAdmin'];
        }
        
        //obtenemos las observaciones de la cancelacion
     /*   $observacionesCancelacion='';
        if(isset($_POST['observaciones'])){
            $observacionesCancelacion = $_POST['observaciones'];
        }      */ 

       
        $maxMov = obtenerMaximoMovCuenta($NumContrato);
        
        $saldoCapitalCorriente = 0;
        $saldoCapitalCorriente = sumasaldoCapitalCorriente($NumContrato, $maxMov);
        //echo $saldoCapitalCorriente;

        $saldoExento=0;
        $saldoExento = obtenerSaldoExcentoUltimoMovCuenta($NumContrato,$maxMov);
        
        $consecutivo = obtenerMovimientoConsecutivo($NumContrato);
        $nuevoMov = $consecutivo + 1;

        /***********************************************************************************************************************************/
        //LIQUIDAR CONCEPTOS
        $CapitalPeriodoCubiertoNuevo=0;  	
        $CapitalPeriodoNuevo=0;  	
        $FinancPeriodoCubiertoNuevo=0;  	
        $FinancPeriodoNuevo=0;  	
        $MontoPagoRecibido=0;        	
        $MoratoriosPeriodoNuevo=0;  	
        $NuevoRezCapitalNuevo=0; 	
        $NuevoRezFinancNuevo=0;   	
        $NuevoRezGtsNuevo=0;	
        $NuevoRezMoratoriosNuevo=0; 	
        $NuevoRezMoratoriosNuevo=0; 	
        $NuevoRezOtrosGtsNuevo=0;   	
        $OtrosGtsPeriodoCubiertoNuevo=0;                	
        $RezCapitalCubiertoNuevo=0;  	
        $RezFinancCubiertoNuevo=0;  	
        $RezMoratoriosCubiertoNuevo=0;  	
        $RezOtrosGtsCubiertoNuevo=0;	
        $SaldoCapitalCorrienteNuevo=0;   	
        $SaldoExentoNuevo=0;  
        $NuevoRezSegNuevo=0;
                       	

           /*// 29 marzo 2021 -modificacion a los conceptos sin efecto de liquidacion se incluyen 130,133(canc escritura), se eliminan las cesiones
          where numcontrato= '" & TxtContrato.text & "' and not tipomov in (1,3,5,6,13,14,19,35,37,58,62,66,67,20,45,18,15,24,25,63,78,79,136)" ' quite el 4 descuento administrativo*/
        $sqlConceptos="SELECT    historicopagos.TipoMov, descripcionmovimiento.DescripcionMovimiento, nummov
        FROM    historicopagos LEFT OUTER JOIN  descripcionmovimiento ON   historicopagos.TipoMov = descripcionmovimiento.idTipoMov    
        where numcontrato= '". $NumContrato. "' and not tipomov in (1,3,5,6,13,14,19,35,37,58,66,67,20,45,18,15,24,25,63,78,79,130,133,136)
        AND   historicopagos.Origen<>'CAN' and cancelado=0 order by   historicopagos.TipoMov desc";
       // echo $sqlConceptos;
        $r = $Vivienda -> query($sqlConceptos); 
        $r_count = $r -> num_rows;
        if($r_count>0)
        {
            while($sqlConceptos = $r -> fetch_array()){ 
            // se saca la información del movimiento a cancelar               
            $sql2 = " Select * from   historicopagos where numcontrato= '" . $NumContrato . "' and  nummov=".$sqlConceptos['nummov'];
           // echo "<br>". $sql2;
            $r2 = $Vivienda -> query($sql2); 
            $r_count2 = $r2 -> num_rows;
            if($r_count2>0)
            {
                while($flocaliza = $r2 -> fetch_array())
                {  
                    //uLTIMO MOVIMIENTO DE LA CUENTA
                    $sql3 = " Select * from   historicopagos where numcontrato= '" . $NumContrato . "' and  nummov=".$maxMov;
                    //echo "<br>".$sql3;
                    $r3 = $Vivienda -> query($sql3); 
                    $r_count3 = $r3 -> num_rows;
                    if($r_count3>0)
                    {
                        while($fultimo = $r3 -> fetch_array())
                        {          

                        
                // REVISA LOS VALORE QUE SE VAN CAMBIAR EN EL REGISTRO

            //    // RezGtsCubierto                
                if( $flocaliza['RezGtsCubierto']<>0)
                {
                    $RezGtsCubiertoNuevo= $flocaliza['RezGtsCubierto']*(-1);
                    $NuevoRezGtsNuevo =  $fultimo['NuevoRezGts'] - ($flocaliza['RezGtsCubierto'] * (-1));
                }
                else
                {
                    $RezGtsCubiertoNuevo=0;
                }
                //************************************************************************************ */
                // GtsPeriodo                              
                if($flocaliza['GtsPeriodo']<>0)
                {
                    $GtsPeriodoNuevo= $flocaliza['GtsPeriodo'] * (-1);
                    $NuevoRezGtsNuevo =  $fultimo['NuevoRezGts'] + ($flocaliza['GtsPeriodo'] * (-1));
                }
                else
                {
                    $GtsPeriodoNuevo=0;
                }
                //************************************************************************************ */
                // GtsPeriodoCubiertos                              
                if( $flocaliza['GtsPeriodoCubiertos']<>0)
                {
                    $GtsPeriodoCubiertosNuevo= $flocaliza['GtsPeriodoCubiertos'] * (-1);
                    $NuevoRezGtsNuevo =  $fultimo['NuevoRezGts'] - ($flocaliza['GtsPeriodoCubiertos'] * (-1));
                }
                else
                {
                    $GtsPeriodoCubiertosNuevo=0;
                }                
                //************************************************************************************ */
                // RezSegCubierto               
                if( $flocaliza['RezSegCubierto']<>0)
                {
                    $RezSegCubiertoNuevo= $flocaliza['RezSegCubierto'] * (-1);
                    $NuevoRezSegNuevo = $fultimo['NuevoRezSeg'] - ($flocaliza['RezSegCubierto'] * (-1));
                }
                else
                {
                    $RezSegCubiertoNuevo=0;
                } 
                //************************************************************************************ */
                // Segperiodo                              
                if ($flocaliza['SegPeriodo'] <> 0 )
                {
                     $SegPeriodoNuevo = $flocaliza['SegPeriodo'] * (-1);           
                     $NuevoRezSegNuevo = $fultimo['NuevoRezSeg'] + ($flocaliza['SegPeriodo'] * (-1));
                }
                else
                {
                    $SegPeriodoNuevo=0;
                } 
                //************************************************************************************ */ 
                //segPeriodoCubierto                          
                if ($flocaliza['SegPeriodoCubierto'] <> 0 ) 
                {           
                    $SegPeriodoCubiertoNuevo = $flocaliza['SegPeriodoCubierto'] * (-1);
                    $NuevoRezSegNuevo = $fultimo['NuevoRezGts'] - ($flocaliza['SegPeriodoCubierto'] * (-1));
                }
                else
                {
                    $SegPeriodoCubiertoNuevo=0;
                }                 
                //************************************************************************************ */ 
                // RezotrosGtsCubierto                
                if ($flocaliza['RezOtrosGtsCubierto'] <> 0 ) 
                {           
                    $RezOtrosGtsCubiertoNuevo = $flocaliza['RezOtrosGtsCubierto'] * (-1);
                    $NuevoRezOtrosGtsNuevo= $fultimo['NuevoRezOtrosGts'] - ($flocaliza['RezOtrosGtsCubierto'] * (-1));
                } 
                else
                {
                    $RezOtrosGtsCubiertoNuevo=0;
                } 
                //************************************************************************************ */ 
                //otrosGtsPeriodo
                $OtrosGtsPeriodoNuevo=0;                
                $NuevoRezGtsNuevo=0;
                if ($flocaliza['OtrosGtsPeriodo'] <> 0 ) 
                {           
                    $OtrosGtsPeriodoNuevo = $flocaliza['OtrosGtsPeriodo'] * (-1);
                    $NuevoRezGtsNuevo= $fultimo['NuevoRezGts'] + ($flocaliza['OtrosGtsPeriodo'] * (-1));
                }
                else
                {
                    $OtrosGtsPeriodoNuevo=0;
                }
                //************************************************************************************ */ 
                //otrosGtsPeriodoCubierto               
                if ($flocaliza['OtrosGtsPeriodoCubierto'] <> 0 ) 
                {           
                    $OtrosGtsPeriodoCubiertoNuevo = $flocaliza['OtrosGtsPeriodoCubierto'] * (-1);
                    $NuevoRezGtsNuevo= $fultimo['NuevoRezGts'] - ($flocaliza['OtrosGtsPeriodoCubierto'] * (-1));
                }
                else
                {
                    $OtrosGtsPeriodoCubiertoNuevo=0;
                }

                //************************************************************************************ */ 
                //RezMoratoriosCubierto                            
                if ($flocaliza['RezMoratoriosCubierto'] <> 0 ) 
                {           
                    $RezMoratoriosCubiertoNuevo = $flocaliza['RezMoratoriosCubierto'] * (-1);
                    $NuevoRezMoratoriosNuevo= $fultimo['NuevoRezMoratorios'] - ($flocaliza['RezMoratoriosCubierto'] * (-1));
                }else
                {
                    $RezMoratoriosCubiertoNuevo=0;
                }

                //************************************************************************************ */ 
                //MoratoriosPeriodo                          
                if ($flocaliza['MoratoriosPeriodo'] <> 0 ) 
                {           
                    $MoratoriosPeriodoNuevo = $flocaliza['MoratoriosPeriodo'] * (-1);
                    $NuevoRezMoratoriosNuevo= $fultimo['NuevoRezMoratorios'] + ($flocaliza['MoratoriosPeriodo'] * (-1));
                }
                else
                {
                    $MoratoriosPeriodoNuevo=0;
                }
                //************************************************************************************ */ 
                //RezFinancCubierto
                if ($flocaliza['RezFinancCubierto'] <> 0 ) 
                {           
                    $RezFinancCubiertoNuevo = $flocaliza['RezFinancCubierto'] * (-1);
                    $NuevoRezFinancNuevo= $fultimo['NuevoRezFinanc'] - ($flocaliza['RezFinancCubierto'] * (-1));
                }
                else
                {
                    $RezFinancCubiertoNuevo=0;
                }
                
                 //************************************************************************************ */ 
                //FinancPeriodo
                if ($flocaliza['FinancPeriodo'] <> 0 ) 
                {           
                    $FinancPeriodoNuevo = $flocaliza['FinancPeriodo'] * (-1);
                    $NuevoRezFinancNuevo= $fultimo['NuevoRezFinanc'] + ($flocaliza['FinancPeriodo'] * (-1));
                } else
                {
                    $FinancPeriodoNuevo=0;
                }

                //************************************************************************************ */ 
                //FinancPeriodoCubierto                           
                if ($flocaliza['FinancPeriodoCubierto'] <> 0 ) 
                {           
                    $FinancPeriodoCubiertoNuevo = $flocaliza['FinancPeriodoCubierto'] * (-1);
                    $NuevoRezFinancNuevo= $fultimo['NuevoRezFinanc'] - ($flocaliza['FinancPeriodoCubierto'] * (-1));
                }
                else
                {
                    $FinancPeriodoCubiertoNuevo=0;
                }

                 //************************************************************************************ */ 
                 //RezCapitalCubierto            
                if ($flocaliza['RezCapitalCubierto'] <> 0 ) 
                {           
                    $FinancPeriodoNuevo = $flocaliza['RezCapitalCubierto'] * (-1);
                    $NuevoRezCapitalNuevo= $fultimo['NuevoRezCapital'] + ($flocaliza['RezCapitalCubierto'] * (-1));
                }
                else
                {
                    $RezCapitalCubiertoNuevo=0;
                }

                //************************************************************************************ */ 
                //CapitalPeriodo
                                           
               
                if ($flocaliza['CapitalPeriodo'] <> 0 ) 
                {           
                    $CapitalPeriodoNuevo = $flocaliza['CapitalPeriodo'] * (-1);
                    if($flocaliza['TipoMov']==34)
                    {
                        $NuevoRezCapitalNuevo=0;
                        $RezCapitalNuevo=0;
                        $SaldoCapitalCorrienteNuevo=0;
                    }else
                    {
                        $NuevoRezCapitalNuevo= $fultimo['NuevoRezCapital'] + ($flocaliza['CapitalPeriodo'] * (-1));
                    }
                
                }else
                {
                    $CapitalPeriodoNuevo=0;          
                }
                
                //************************************************************************************ */ 
                 //CapitalPeriodoCubierto                             
                 if ($flocaliza['CapitalPeriodoCubierto'] <> 0 ) 
                 {           
                    $CapitalPeriodoCubiertoNuevo = $flocaliza['CapitalPeriodoCubierto'] * (-1);
                    if($flocaliza['TipoMov'] <>7 and $flocaliza['TipoMov']<>9)
                    {
                        $NuevoRezCapitalNuevo= $fultimo['NuevoRezCapital'] - ($flocaliza['CapitalPeriodoCubierto'] * (-1));
                    }
                    $SaldoCapitalCorrienteNuevo = $fultimo['SaldoCapitalCorriente'] - $CapitalPeriodoCubiertoNuevo;
                }else
                { 
                    $CapitalPeriodoCubiertoNuevo=0;
                }
 
                 //************************************************************************************ */ 
                //saldoexento
                if ($flocaliza['saldoexento'] <> 0 ) 
                 {  if ($fultimo['saldoexento'] <> 0 ) 
                    {      
                        $SaldoExentoNuevo=0;         
                    }             
                 }else
                 {
                    $SaldoExentoNuevo=0;
                 }

                 //************************************************************************************ */ 
                if ($flocaliza['MontoPagoRecibido'] <> 0 ) 
                {  
                    $MontoPagoRecibidoNuevo=$flocaliza['MontoPagoRecibido'] *(-1);      
                } else
                {
                    $MontoPagoRecibidoNuevo=0;
                }              
                //************************************************************************************ */ 
                
               if ($flocaliza['AplicadoExcedente'] <> 0 ) 
               {  
                    $AplicadoExcedenteNuevo=0;  
                    $SaldoCapitalCorrienteNuevo = $fultimo['SaldoCapitalCorriente'] + ($flocaliza['AplicadoExcedente']) ;   
               }else
               {
                $AplicadoExcedenteNuevo=0;
               }           
               //************************************************************************************ */ 
              $fechaCorteNuevo=$fultimo['FechaCorte'] ;
              $TipomovNuevo=$flocaliza['TipoMov'] ;
              $RezGtsNuevo = $fultimo['NuevoRezGts'];
              $RezSegNuevo = $fultimo['NuevoRezSeg'];
              $RezOtrosGtsNuevo = $fultimo['NuevoRezOtrosGts'];
              $RezMoratoriosNuevo = $fultimo['NuevoRezMoratorios'];
              $RezFinancNuevo = $fultimo['NuevoRezFinanc'];
              $RezCapitalNuevo = $fultimo['NuevoRezCapital'];
                
            $sql = " INSERT INTO   historicopagos(NumContrato	,NumMov	,MontoPagoRecibido,FechaOperacion,
            FechaCorte,FechaInicia,FechaTermina,  RezGts,RezGtsCubierto,GtsPeriodo,GtsPeriodoCubiertos,
            NuevoRezGts,RezSeg	,RezSegCubierto, SegPeriodo,SegPeriodoCubierto,NuevoRezSeg,RezOtrosGts,
            RezOtrosGtsCubierto	,OtrosGtsPeriodo,OtrosGtsPeriodoCubierto,NuevoRezOtrosGts	,
            RezMoratorios,RezMoratoriosCubierto,MoratoriosPeriodo,NuevoRezMoratorios,RezFinanc,
            RezFinancCubierto,FinancPeriodo,FinancPeriodoCubierto,NuevoRezFinanc,RezCapital	,
            RezCapitalCubierto,CapitalPeriodo
            ,CapitalPeriodoCubierto	,NuevoRezCapital,AplicadoExcedente,SaldoCapitalCorriente,
            Origen	,TipoMov,Observaciones	,Enviar	,IdEmpCrea	,IdEmpModifica,FechaCaptura	,
            FechaUltimaMod,FechaEnvio,saldoexento,ImpSF002	,FechaImpSF002,FechaReimSF002
            ,ReferenciaOpd,RefBancariaOpd	,IdMovDesc,Observacion2	,IdFormaPago,IdSupervisor	,
            OrigenDeEnvio,Cancelado	,NumMovErroneo, OriginData) 
           
          
           VALUES ('".$fultimo['NumContrato']."',".$nuevoMov.",'".$MontoPagoRecibidoNuevo."',now(),'".
            $fechaCorteNuevo."','".$fultimo['FechaInicia']."','".$fultimo['FechaTermina']."','".$RezGtsNuevo."','".$RezGtsCubiertoNuevo."','". $GtsPeriodoNuevo."','". $GtsPeriodoCubiertosNuevo."','".
            $NuevoRezGtsNuevo."','".$RezSegNuevo."','".$RezSegCubiertoNuevo."','".$SegPeriodoNuevo."','".$SegPeriodoCubiertoNuevo."','".$NuevoRezSegNuevo."','".$RezOtrosGtsNuevo."','".
            $RezOtrosGtsCubiertoNuevo."','". $OtrosGtsPeriodoNuevo."','".$OtrosGtsPeriodoCubiertoNuevo."','".$NuevoRezOtrosGtsNuevo."','".
            $RezMoratoriosNuevo."','".$RezMoratoriosCubiertoNuevo."','".$MoratoriosPeriodoNuevo."','". $NuevoRezMoratoriosNuevo."','".$RezFinancNuevo."','".
            $RezFinancCubiertoNuevo."','".$FinancPeriodoNuevo."','".$FinancPeriodoCubiertoNuevo."','".$NuevoRezFinancNuevo."','".  $RezCapitalNuevo."','".
            $RezCapitalCubiertoNuevo."','".$CapitalPeriodoNuevo."','".
            $CapitalPeriodoCubiertoNuevo."','".$NuevoRezCapitalNuevo."','".$AplicadoExcedenteNuevo."','".$SaldoCapitalCorrienteNuevo."','".
            $fultimo['Origen']."','".$TipomovNuevo."','".$fultimo['Observaciones']."','".
            $fultimo['Enviar']."','".$nitavu."','0',now(),'0','".
            $fultimo['FechaEnvio']."','".$SaldoExentoNuevo."','".$fultimo['ImpSF002']."','".$fultimo['FechaImpSF002']."','".$fultimo['FechaReimSF002']."','".
            $fultimo['ReferenciaOpd']."','".$fultimo['RefBancariaOpd']."','".$fultimo['IdMovDesc']."','".$fultimo['Observacion2']."','".
            $fultimo['IdFormaPago']."','".$fultimo['IdSupervisor']."','".$fultimo['OrigenDeEnvio']."','".$fultimo['Cancelado']."','".$fultimo['NumMovErroneo']."','".$iddelegacion."')";
           
           // echo "<br>".$sql;            
                if ($Vivienda->query($sql) == TRUE){   
                     
                            $res = 'TRUE';
                            $nuevoMov = $nuevoMov + 1;
                }else{                       
                           
                            mensaje('62. Ocurrio un error, favor de intentarlo nuevamente.','cancelarContrato.php');
                            //echo "1. Ocurrio un error, favor de intentarlo nuevamente.";
                            $res = 'FALSE';
                            return true;
                } 

                    }
                    }
                }
                 
            }
            else
            {
                //echo "No hay datos";
            }
        
        }
             
        }
        else
        {
            //echo "No hay conceptos que liquidar";
        }
    
  /***********************************************************************************************************************************/
        if($opcion == '1' or $opcion == '2' ){
            
            //resmoratoriocubierto
            $DescuentoMorat = 0;
            if(rezMoratoriosCubiertos($NumContrato)=='' or isnull(rezMoratoriosCubiertos($NumContrato))){
                $DescuentoMorat = 0;
            }else{
                $DescuentoMorat = rezMoratoriosCubiertos($NumContrato);
            }

            $capital = capitalPeriodo($NumContrato);
            //echo $capital;
          
            $Financiamiento = Financiamiento($NumContrato);
            //echo $Financiamiento;

            $financiamientoNoProcedente = financiamientoNoProcedente($NumContrato);

            $moratorios = Moratorios($NumContrato);

            $moratorioNoProcedente = MoratoriosNoProcedente($NumContrato);
            $Pagos = Pagos($NumContrato);

            $rsttipomov=RstTipomovCredito($NumContrato);
            $rstcapitalperiodo=RstCapitalperiodo($NumContrato);

            //subsidios 
            $subsidios = Subsidios($NumContrato);


            //DATOS NECESARIOS PARA INSERTAR EL REGISTRO DE CANCELACION DE CONTRATO
            $nuevoRezMoratoriosUltimoMovCuenta=0;
            $nuevoRezFinancUltimoMovCuenta=0;
            $nuevoRezCapitalUltimoMovCuenta=0;
            $saldoCapitalCorrienteUltimoMovCuenta=0;
                
            $nuevoRezMoratoriosUltimoMovCuenta=obtenerNuevoRezMoratoriosUltimoMovCuenta($NumContrato,$maxMov);
            $nuevoRezFinancUltimoMovCuenta=obtenerNuevoRezFinancUltimoMovCuenta($NumContrato,$maxMov);
            $nuevoRezCapitalUltimoMovCuenta=obtenerNuevoRezCapitalUltimoMovCuenta($NumContrato,$maxMov);
            $saldoCapitalCorrienteUltimoMovCuenta = obtenerSaldoCapitalCorrienteUltimoMovCuenta($NumContrato,$maxMov);
            $fechaCorteUltimoMovCuenta=obtenerFechaCorteUltimoMovCuenta($NumContrato,$maxMov);


            //NUEVO REGISTRO QUE CONTIENE LOS DATOS DE EL OFICIO POR EL QUE SE CANCELO EL CONTRATO
            $sql = "insert into   historicopagos (numcontrato,nummov,montopagorecibido,fechaoperacion,saldocapitalcorriente,origen,tipomov,enviar, 
            fechacaptura,idempcrea,saldoexento,cancelado,origindata,Observaciones,IdSupervisor,RezMoratorios,NuevoRezMoratorios,RezFinanc,NuevoRezFinanc,RezCapital,NuevoRezCapital,FechaCorte) 
            values ( '".$NumContrato."','".$nuevoMov."', 0,  now(),'".$saldoCapitalCorrienteUltimoMovCuenta."','CAN',141 , 1, now(),'".$nitavu."','".$saldoExento."',0,'".$iddelegacion."','". $observacionesCancelacion."','".$maxMov."',
            '".$nuevoRezMoratoriosUltimoMovCuenta."','".$nuevoRezMoratoriosUltimoMovCuenta."','".$nuevoRezFinancUltimoMovCuenta."','".$nuevoRezFinancUltimoMovCuenta."','".$nuevoRezCapitalUltimoMovCuenta."','".$nuevoRezCapitalUltimoMovCuenta."','".$fechaCorteUltimoMovCuenta."')";
            echo "<br>".$sql;            
                if ($Vivienda->query($sql) == TRUE){   
                        // historia($nitavu, "SE INSERTO REGISTRO EN HISTORICO PAGOS PARA CANCELAR EL CONTRATO ".$NumContrato." POR FINANCIAMIENTO "); 
                            $res = 'TRUE';
                            $nuevoMov = $nuevoMov + 1;
                }else{                       
                            //historia($nitavu, "SE ELIMINARON REGISTROS DE HISTORICO PAGOS QUE SE INSERTARON AL MOMENTO DE TRATAR DE CANCELAR, DEL NUMCONTRATO ".$NumContrato); 
                            mensaje('1. Ocurrio un error, favor de intentarlo nuevamente.','cancelarContrato.php');
                            //echo "1. Ocurrio un error, favor de intentarlo nuevamente.";
                            return true;
                } 

          
            
            // primero financiamiento aplicado-devuelto
                if($Financiamiento > 0 ){
                    $saldoCapitalCorriente = (float)$saldoCapitalCorriente - (float)$Financiamiento;

                    $sql = "insert into   historicopagos (numcontrato,nummov, montopagorecibido,fechaoperacion,SaldoCapitalCorriente, 
                    origen, Tipomov, Enviar, fechacaptura,idempcrea,financperiodo,saldoexento,cancelado,origindata,FechaCorte) values ('$NumContrato', '$nuevoMov', 0, now(),
                    '$saldoCapitalCorriente','CAN',6,1, now(), '$nitavu', ($Financiamiento * -1), ".$saldoExento.",0,".$iddelegacion.", '".$fechaCorteUltimoMovCuenta."')";
                     //echo $sql;
                    if ($Vivienda->query($sql) == TRUE){   
                        historia($nitavu, "SE INSERTO REGISTRO EN HISTORICO PAGOS PARA INDICAR LA OBSERVACION DE LA CANCELACION DEL CONTRATO ".$NumContrato."". $sql);  
                        $res = 'TRUE';
                        $nuevoMov = $nuevoMov + 1;  
                    }else{
                        $sql = 'CALL sp_EliminarRegistrosHPcancelacion("'.$NumContrato.'", "'.$maxMov.'")';
                        if ($Vivienda->query($sql) == TRUE){  
                           // historia($nitavu, "SE ELIMINARON REGISTROS DE HISTORICO PAGOS QUE SE INSERTARON AL MOMENTO DE TRATAR DE CANCELAR, DEL NUMCONTRATO ".$NumContrato); 
                            mensaje('63. Ocurrio un error, favor de intentarlo nuevamente.','cancelarContrato.php');
                            return true;
                        }else{
                            //historia($nitavu, "OCURRIO UN ERROR AL TRATAR DE ELIMINAR REGISTROS DE HISTORICO PAGOS QUE SE INSERTARON AL MOMENTO DE TRATAR DE CANCELAR DEL NUMCONTRATO ".$NumContrato); 
                            mensaje('64. Ocurrio un error, favor de intentarlo nuevamente.','cancelarContrato.php');
                            return true; 
                        }
                    }  
                }     

                  /*
                    if ($Vivienda->query($sql) == TRUE){   
                       // historia($nitavu, "SE INSERTO REGISTRO EN HISTORICO PAGOS PARA CANCELAR EL CONTRATO ".$NumContrato." POR FINANCIAMIENTO "); 
                        $res = 'TRUE';
                        $nuevoMov = $nuevoMov + 1;
                    }else{
                       
                        //historia($nitavu, "SE ELIMINARON REGISTROS DE HISTORICO PAGOS QUE SE INSERTARON AL MOMENTO DE TRATAR DE CANCELAR, DEL NUMCONTRATO ".$NumContrato); 
                        mensaje('1. Ocurrio un error, favor de intentarlo nuevamente.','cancelarContrato.php');
                        //echo "1. Ocurrio un error, favor de intentarlo nuevamente.";
                        return true;
                    } */
                

            //financiamiento improcedente
            //echo 'Maximo Movimiento'.$maxMov;
            if ($maxMov > 1){
                
                //echo 'Financiemianto'.$financiamientoNoProcedente;
                if( $financiamientoNoProcedente > 0 ){
                    $saldoCapitalCorriente = (float)$saldoCapitalCorriente - (float)$financiamientoNoProcedente;                  
                    
                    $sql = "INSERT INTO   historicopagos (numcontrato, nummov, montopagorecibido,fechaoperacion, SaldoCapitalCorriente, origen,tipomov,enviar, 
                    fechacaptura,idempcrea,financperiodo,saldoexento,cancelado,origindata,FechaCorte) values ('".$NumContrato."',".$nuevoMov.", 0, NOW(), ".$saldoCapitalCorriente.",'CAN', 20, 1, now(),
                    ".$nitavu.",".$financiamientoNoProcedente." * -1 ,".$saldoExento.",0,".$iddelegacion.", '".$fechaCorteUltimoMovCuenta."')";
                   
                    //echo $sql;
                    if ($Vivienda->query($sql) == TRUE){   
                       // historia($nitavu, "SE INSERTO REGISTRO EN HISTORICO PAGOS PARA CANCELAR EL CONTRATO ".$NumContrato." POR FINANCIAMIENTO IMPROCEDENTE"); 
                        $res = 'TRUE';
                        $nuevoMov = $nuevoMov + 1;
                    }else{
                        $sql = 'CALL sp_EliminarRegistrosHPcancelacion("'.$NumContrato.'", "'.$maxMov.'")';
                        //echo $sql;
                        if ($Vivienda->query($sql) == TRUE){  
                            //historia($nitavu, "SE ELIMINARON REGISTROS DE HISTORICO PAGOS QUE SE INSERTARON AL MOMENTO DE TRATAR DE CANCELAR, DEL NUMCONTRATO ".$NumContrato); 
                            mensaje('2. Ocurrio un error, favor de intentarlo nuevamente.','cancelarContrato.php');
                            //echo '2. Ocurrio un error, favor de intentarlo nuevamente.';
                            return true;
                        }else{
                           // historia($nitavu, "OCURRIO UN ERROR AL TRATAR DE ELIMINAR REGISTROS DE HISTORICO PAGOS QUE SE INSERTARON AL MOMENTO DE TRATAR DE CANCELAR DEL NUMCONTRATO ".$NumContrato); 
                            mensaje('3. Ocurrio un error, favor de intentarlo nuevamente.','cancelarContrato.php');
                            //echo  '3. Ocurrio un error, favor de intentarlo nuevamente.';
                           return true;
                        }
                   }
                    
                    
                }

            }

            //echo "<hr>";
            //moratorios            
            if($moratorios > 0) {

                $saldoCapitalCorriente = (float)$saldoCapitalCorriente - (float)$moratorios;
                
                $sql = "insert into   historicopagos (numcontrato,nummov, montopagorecibido,fechaoperacion,saldocapitalcorriente,origen,tipomov,enviar, 
                fechacaptura,idempcrea,moratoriosperiodo,saldoexento,cancelado,origindata,FechaCorte)values ( '".$NumContrato."',".$nuevoMov.", 0, now(), ".$saldoCapitalCorriente.",'CAN', 5, 1, now(),".$nitavu.", (".$moratorios." * -1),".$saldoExento.",0,".$iddelegacion.", '".$fechaCorteUltimoMovCuenta."')";
                
                //echo $sql;
                if ($Vivienda->query($sql) == TRUE){   
                    //historia($nitavu, "SE INSERTO REGISTRO EN HISTORICO PAGOS PARA CANCELAR EL CONTRATO ".$NumContrato." POR MORATORIOS"); 
                    $res = 'TRUE';
                    $nuevoMov = $nuevoMov + 1;
                }else{
                    $sql = 'CALL sp_EliminarRegistrosHPcancelacion("'.$NumContrato.'", "'.$maxMov.'")';
                    //echo $sql;
                    if ($Vivienda->query($sql) == TRUE){  
                       // historia($nitavu, "SE ELIMINARON REGISTROS DE HISTORICO PAGOS QUE SE INSERTARON AL MOMENTO DE TRATAR DE CANCELAR, DEL NUMCONTRATO ".$NumContrato); 
                        mensaje('4. Ocurrio un error, favor de intentarlo nuevamente.','cancelarContrato.php');
                        //echo  '4. Ocurrio un error, favor de intentarlo nuevamente.';
                        return true;
                    }else{
                       // historia($nitavu, "OCURRIO UN ERROR AL TRATAR DE ELIMINAR REGISTROS DE HISTORICO PAGOS QUE SE INSERTARON AL MOMENTO DE TRATAR DE CANCELAR DEL NUMCONTRATO ".$NumContrato); 
                        mensaje('5. Ocurrio un error, favor de intentarlo nuevamente.','cancelarContrato.php');
                        //echo  '5. Ocurrio un error, favor de intentarlo nuevamente.';
                        return true;
                    }
                }


               
            }

            //echo "<hr>";
            // Moratorio Improcedente
            if($maxMov > 1){
                
                if( $moratorioNoProcedente > 0 ){
                    $sumMora = (float)$moratorioNoProcedente + (float)$DescuentoMorat;
                    $saldoCapitalCorriente = (float)$saldoCapitalCorriente - ((float)$sumMora);

                    $sql = "Insert into   historicopagos (numcontrato,nummov,montopagorecibido,fechaoperacion,saldocapitalcorriente,origen,tipomov,enviar,
                    fechacaptura,idempcrea,moratoriosperiodo,saldoexento,cancelado,origindata,FechaCorte) values ( '".$NumContrato."',".$nuevoMov.", 0, now(), ".$saldoCapitalCorriente.",'CAN', 45, 1, now(),".$nitavu.",(".$sumMora.") * -1,".$saldoExento.",0,".$iddelegacion.", '".$fechaCorteUltimoMovCuenta."')";
                                       
                    //echo $sql;
                    if ($Vivienda->query($sql) == TRUE){   
                       // historia($nitavu, "SE INSERTO REGISTRO EN HISTORICO PAGOS PARA CANCELAR EL CONTRATO ".$NumContrato." POR MORATORIOS IMPORCEDENTE"); 
                        $res = 'TRUE';
                        $nuevoMov = $nuevoMov + 1;
                    }else{
                        $sql = 'CALL sp_EliminarRegistrosHPcancelacion("'.$NumContrato.'", "'.$maxMov.'")';
                        if ($Vivienda->query($sql) == TRUE){  
                          //  historia($nitavu, "SE ELIMINARON REGISTROS DE HISTORICO PAGOS QUE SE INSERTARON AL MOMENTO DE TRATAR DE CANCELAR, DEL NUMCONTRATO ".$NumContrato); 
                            mensaje('6. Ocurrio un error, favor de intentarlo nuevamente.','cancelarContrato.php');
                           // echo  '6. Ocurrio un error, favor de intentarlo nuevamente.';
                            return true; 
                        }else{
                           // historia($nitavu, "OCURRIO UN ERROR AL TRATAR DE ELIMINAR REGISTROS DE HISTORICO PAGOS QUE SE INSERTARON AL MOMENTO DE TRATAR DE CANCELAR DEL NUMCONTRATO ".$NumContrato); 
                            mensaje('7. Ocurrio un error, favor de intentarlo nuevamente.','cancelarContrato.php');
                            //echo  '7. Ocurrio un error, favor de intentarlo nuevamente.';
                            return true;
                        }
                    }
                    
                }
                
            }

            //echo "<hr>";
            //echo "subsidio ".$subsidios;
            //subsidio
            if($subsidios > 0 ){
                (float)$saldoCapitalCorriente = (float)$saldoCapitalCorriente + (float)$subsidios;
                
                $sql = "insert into   historicopagos (numcontrato,nummov, montopagorecibido,fechaoperacion,saldocapitalcorriente,origen,tipomov,enviar, fechacaptura,idempcrea,capitalperiodocubierto,origindata,cancelado,FechaCorte)
                values ( '".$NumContrato."',".$nuevoMov.",".$subsidios." * -1, now(), ".$saldoCapitalCorriente.",'PCA', 26, 1, now(),".$nitavu.",".$subsidios." * -1,".$iddelegacion.",0, '".$fechaCorteUltimoMovCuenta."')";
                
                if ($Vivienda->query($sql) == TRUE){  
                    //historia($nitavu, "SE INSERTO REGISTRO EN HISTORICO PAGOS PARA CANCELAR  EL CONTRATO ".$NumContrato." POR SUBSIDIO". $sql);  
                    $res = 'TRUE';
                    $nuevoMov = $nuevoMov + 1;
                }else{
                    $sql = 'CALL sp_EliminarRegistrosHPcancelacion("'.$NumContrato.'", "'.$maxMov.'")';
                    if ($Vivienda->query($sql) == TRUE){  
                       // historia($nitavu, "SE ELIMINARON REGISTROS DE HISTORICO PAGOS QUE SE INSERTARON AL MOMENTO DE TRATAR DE CANCELAR, DEL NUMCONTRATO ".$NumContrato); 
                        mensaje('8. Ocurrio un error, favor de intentarlo nuevamente.','cancelarContrato.php');
                        //echo  '8. Ocurrio un error, favor de intentarlo nuevamente.';
                        return true;
                    }else{
                       // historia($nitavu, "OCURRIO UN ERROR AL TRATAR DE ELIMINAR REGISTROS DE HISTORICO PAGOS QUE SE INSERTARON AL MOMENTO DE TRATAR DE CANCELAR DEL NUMCONTRATO ".$NumContrato); 
                        mensaje('9. Ocurrio un error, favor de intentarlo nuevamente.','cancelarContrato.php');
                        //echo  '9. Ocurrio un error, favor de intentarlo nuevamente.';
                        return true;
                    }
               }
                
                
            }


            //switch opciones
            $ATransferir = 0;                   

            //echo 'Pagos'.$Pagos;
            if($Pagos > 0){
            
                $saldoCapitalCorriente = (float)$saldoCapitalCorriente + (float)$Pagos;
                   //*************************************************************************************************** *
                //CASO DEVOLUCIÓN
                if($opcion == '1' ){
                    //echo "entro opcion 1";
                    //SI ESTA CLICKEADO CARGA GASTOS ADMIN
                    //echo "<hr>";
                    if ($aplicaGastos == 1){
                        $saldoCapitalCorriente = (float)$saldoCapitalCorriente - (float)$Pagos;   
                        $saldoCapitalCorriente = (float)$saldoCapitalCorriente + (float)$cargoAdmin;
                        $sql = "insert into   historicopagos (numcontrato,nummov, montopagorecibido,fechaoperacion,saldocapitalcorriente,origen,tipomov,enviar, 
                        fechacaptura,idempcrea,GtsPeriodo,observaciones,GtsPeriodoCubiertos,saldoexento, cancelado,origindata,FechaCorte) values ( '".$NumContrato."',".$nuevoMov.",
                        0 , now(), ".$saldoCapitalCorriente.",'CAN', 15, 1, now() ,".$nitavu.",".$cargoAdmin.",'CARGO POR TRAMITE',".$cargoAdmin.",".$saldoExento.",0,".$iddelegacion.", '".$fechaCorteUltimoMovCuenta."')";
                        

                        //echo $sql;
                        if ($Vivienda->query($sql) == TRUE){   
                           // historia($nitavu, "SE INSERTO REGISTRO EN HISTORICO PAGOS PARA CANCELAR EL CONTRATO ".$NumContrato." POR CARGO PARA DEVOLUCION"); 
                            $res = 'TRUE';
                            $nuevoMov = $nuevoMov + 1;
                        }else{
                            $sql = 'CALL sp_EliminarRegistrosHPcancelacion("'.$NumContrato.'", "'.$maxMov.'")';
                            //echo $sql;
                            if ($Vivienda->query($sql) == TRUE){  
                               // historia($nitavu, "SE ELIMINARON REGISTROS DE HISTORICO PAGOS QUE SE INSERTARON AL MOMENTO DE TRATAR DE CANCELAR, DEL NUMCONTRATO ".$NumContrato); 
                                mensaje('10. Ocurrio un error, favor de intentarlo nuevamente.','cancelarContrato.php');
                                //echo  '10. Ocurrio un error, favor de intentarlo nuevamente.';
                                return true;
                            }else{
                               // historia($nitavu, "OCURRIO UN ERROR AL TRATAR DE ELIMINAR REGISTROS DE HISTORICO PAGOS QUE SE INSERTARON AL MOMENTO DE TRATAR DE CANCELAR DEL NUMCONTRATO ".$NumContrato); 
                                mensaje('11.Ocurrio un error, favor de intentarlo nuevamente.','cancelarContrato.php');
                                //echo  '11. Ocurrio un error, favor de intentarlo nuevamente.';
                                return true;
                            }
                        }
                         

                         $observa1 = "cheque ".$numCheque.", de fecha ".$fechaCheque;
                  
                         $saldoCapitalCorriente=$saldoCapitalCorriente+(((((float)$Pagos - (float)$cargoAdmin)- (float)$DescuentoMorat) * -1)*-1); 
                         $sql = "Insert Into   historicopagos (numcontrato, nummov, montopagorecibido,fechaoperacion,saldocapitalcorriente,origen,tipomov,enviar, 
                                 fechacaptura,idempcrea, capitalperiodocubierto, observaciones, saldoexento,cancelado,origindata,FechaCorte) values ( '".$NumContrato."',".$nuevoMov.",(((".$Pagos." - ".$cargoAdmin.") - ".$DescuentoMorat.") * -1), now(), ".$saldoCapitalCorriente.",
                                 'CAN', 18, 1, now(),".$nitavu.", (((".$Pagos." - ".$cargoAdmin.") - ".$DescuentoMorat.") * -1), '".$observa1."',".$saldoExento.",0,".$iddelegacion.", '".$fechaCorteUltimoMovCuenta."')";
                        
                                 //echo $sql;
                         if ($Vivienda->query($sql) == TRUE){   
                           // historia($nitavu, "SE INSERTO REGISTRO EN HISTORICO PAGOS PARA CANCELAR  EL CONTRATO ".$NumContrato." POR CARGO PARA DEVOLUCION"); 
                             $res = 'TRUE';
                             $nuevoMov = $nuevoMov + 1;
                         }else{
                            $sql = 'CALL sp_EliminarRegistrosHPcancelacion("'.$NumContrato.'", "'.$maxMov.'")';
                            if ($Vivienda->query($sql) == TRUE){  
                                //historia($nitavu, "SE ELIMINARON REGISTROS DE HISTORICO PAGOS QUE SE INSERTARON AL MOMENTO DE TRATAR DE CANCELAR, DEL NUMCONTRATO ".$NumContrato); 
                                mensaje('12. Ocurrio un error, favor de intentarlo nuevamente.','cancelarContrato.php');
                                //echo  '12. Ocurrio un error, favor de intentarlo nuevamente.';
                                return true;
                            }else{
                               // historia($nitavu, "OCURRIO UN ERROR AL TRATAR DE ELIMINAR REGISTROS DE HISTORICO PAGOS QUE SE INSERTARON AL MOMENTO DE TRATAR DE CANCELAR DEL NUMCONTRATO ".$NumContrato); 
                                mensaje('13. Ocurrio un error, favor de intentarlo nuevamente.','cancelarContrato.php');
                                //echo  '13. Ocurrio un error, favor de intentarlo nuevamente.';
                                return true;
                            }
                         }
     
                         $ATransferir = (((float)$Pagos - (float)$cargoAdmin) - (float)$DescuentoMorat);
                         
                     
                    }else {
                        $observa1 = "cheque ".$numCheque.", de fecha ".$fechaCheque;                 
                        
                        $sql = "Insert Into   historicopagos (numcontrato, nummov, montopagorecibido,fechaoperacion,saldocapitalcorriente,origen,tipomov,enviar, 
                        fechacaptura,idempcrea, capitalperiodocubierto, observaciones, saldoexento,cancelado,origindata,FechaCorte) values ( '".$NumContrato."',".$nuevoMov.",(((".$Pagos." - ".$cargoAdmin.") - ".$DescuentoMorat.") * -1), now(), ".$saldoCapitalCorriente.",
                        'CAN', 18, 1, now(),".$nitavu.", (((".$Pagos." - ".$cargoAdmin.") - ".$DescuentoMorat.") * -1), '".$observa1."',".$saldoExento.",0,".$iddelegacion.", '".$fechaCorteUltimoMovCuenta."')";
                
                        //echo $sql;
                        if ($Vivienda->query($sql) == TRUE){   
                            //historia($nitavu, "SE INSERTO REGISTRO EN HISTORICO PAGOS PARA CANCELAR EL CONTRATO ".$NumContrato." POR DEVOLUCION"); 
                            $res = 'TRUE';
                            $nuevoMov = $nuevoMov + 1;
                        }else{
                            $sql = 'CALL sp_EliminarRegistrosHPcancelacion("'.$NumContrato.'", "'.$maxMov.'")';
                            if ($Vivienda->query($sql) == TRUE){  
                               // historia($nitavu, "SE ELIMINARON REGISTROS DE HISTORICO PAGOS QUE SE INSERTARON AL MOMENTO DE TRATAR DE CANCELAR, DEL NUMCONTRATO ".$NumContrato); 
                                mensaje('14. Ocurrio un error, favor de intentarlo nuevamente.','cancelarContrato.php');
                                //echo  '14. Ocurrio un error, favor de intentarlo nuevamente.';
                                return true;
                            }else{
                               // historia($nitavu, "OCURRIO UN ERROR AL TRATAR DE ELIMINAR REGISTROS DE HISTORICO PAGOS QUE SE INSERTARON AL MOMENTO DE TRATAR DE CANCELAR DEL NUMCONTRATO ".$NumContrato); 
                                mensaje('15. Ocurrio un error, favor de intentarlo nuevamente.','cancelarContrato.php');
                                //echo  '15. Ocurrio un error, favor de intentarlo nuevamente.';
                                return true;
                            }
                        }
    
                        $ATransferir = (((float)$Pagos - (float)$cargoAdmin) - (float)$DescuentoMorat);
                        
                    
                    }                                  
                
                }// CIERRE DE LA OPCION 1 (DEVOLUCION)
                //*************************************************************************************************** 
                //CASO TRANSFERENCIA
                else if($opcion == '2')
                {  

                   $maxpagonvofolio=NumeroDePago($iddelegacionnvo,$idprogramanvo,$folionvo);
                 
                   
                    $observacion1="A " .NombrePrograma($idprogramanvo). " " .$folionvo;
                    $observacion2="DE  CONTRATO ".$NumContrato;

                    $foliorec1 =$idprograma . str_pad($folio, 5, "0", STR_PAD_LEFT);
                    //echo '<br>'.$foliorec1.'folio<br>';
                    $foliorec2 =$idprogramanvo . str_pad($folionvo, 5, "0", STR_PAD_LEFT);

                    $cargoAdmin=0;
                 

                    
                  //********************************************************                

                     //otenenemos la cantidad de gastos Administrativos
                     if(isset($_POST['cargoAdminT'])){
                        $cargoAdmin = $_POST['cargoAdminT'];
                    }
                       
                  

                    if(RstTotalRegCredito($NumContrato)==0)
                    {
                        $saldoCapitalCorriente =0;    
                    }

                    //SI ESTA CLICKEADO CARGA GASTOS ADMIN
                    //transferencia con cargo
                    if ($aplicaGastosT==1){ 

                        
                        $saldoCapitalCorriente = ((float)$saldoCapitalCorriente) - ((float)$Pagos);   
                        $saldoCapitalCorriente = (((float)$saldoCapitalCorriente) + ((float)$cargoAdmin)); 
                        //echo '<br>saldoCapitalCorriente'.$saldoCapitalCorriente ;           
                        $sql = "Insert into   historicopagos (numcontrato,nummov, montopagorecibido,fechaoperacion,saldocapitalcorriente,origen,tipomov,enviar,
                           fechacaptura,idempcrea,GtsPeriodo,observaciones,GtsPeriodoCubiertos,saldoexento,cancelado,origindata,FechaCorte)                      
                            values ( '".$NumContrato."',".$nuevoMov.", 0, now(), ".$saldoCapitalCorriente.",'CAN', 15, 1, now(),".$nitavu.",".$cargoAdmin.",'CARGO POR TRAMITE',".$cargoAdmin.",".$saldoExento.",0,".$iddelegacion.", '".$fechaCorteUltimoMovCuenta."')";
                        
                       // echo $sql;
                        if ($Vivienda->query($sql) == TRUE){   
                           // historia($nitavu, "SE INSERTO REGISTRO EN HISTORICO PAGOS PARA CANCELAR  EL CONTRATO ".$NumContrato." POR CARGO PARA TRANSFERENCIA"); 
                            $res = 'TRUE';
                            $nuevoMov = $nuevoMov + 1;
                        }else{
                            $sql = 'CALL sp_EliminarRegistrosHPcancelacion("'.$NumContrato.'", "'.$maxMov.'")';
                            if ($Vivienda->query($sql) == TRUE){  
                               // historia($nitavu, "SE ELIMINARON REGISTROS DE HISTORICO PAGOS QUE SE INSERTARON AL MOMENTO DE TRATAR DE CANCELAR, DEL NUMCONTRATO ".$NumContrato); 
                                mensaje('16. Ocurrio un error, favor de intentarlo nuevamente.','cancelarContrato.php');
                                //echo  '16. Ocurrio un error, favor de intentarlo nuevamente.';
                                return true;
                            }else{
                               // historia($nitavu, "OCURRIO UN ERROR AL TRATAR DE ELIMINAR REGISTROS DE HISTORICO PAGOS QUE SE INSERTARON AL MOMENTO DE TRATAR DE CANCELAR DEL NUMCONTRATO ".$NumContrato); 
                                mensaje('17. Ocurrio un error, favor de intentarlo nuevamente.','cancelarContrato.php');
                                //echo  '17. Ocurrio un error, favor de intentarlo nuevamente.';
                                return true;
                            }
                        }
                        

                        //INSERTAMOS LA CANTIDAD DE LA TRANSFERENCIA EN LA TABLA  HISTORICOPAGOS                       
                        $montoPagoRecibido=(((float)$Pagos - (float)$cargoAdmin) - (float)$DescuentoMorat) * -1  ; 
                        $saldoCapitalCorriente=(float)$saldoCapitalCorriente + ((float)$montoPagoRecibido*-1);   
                         
                        $sql = "Insert into  historicopagos (numcontrato,nummov, montopagorecibido,fechaoperacion,saldocapitalcorriente,origen,tipomov,enviar, 
                        fechacaptura,idempcrea,capitalperiodocubierto,OBSERVACIONES,NuevoRezCapital,saldoexento,cancelado,origindata,FechaCorte)                      
                        values ( '".$NumContrato."',".$nuevoMov.", ".$montoPagoRecibido.",  now(),".$saldoCapitalCorriente.",'CAN', 19, 1, now(),".$nitavu.",".$montoPagoRecibido.",'".$observacion1."',0,".$saldoExento.",0,".$iddelegacion.", '".$fechaCorteUltimoMovCuenta."')";
                        
                        //echo $sql;
                        if ($Vivienda->query($sql) == TRUE){ 
                            //historia($nitavu, "SE INSERTO REGISTRO EN HISTORICO PAGOS PARA CANCELAR  EL CONTRATO ".$NumContrato." PARA TRANSFERENCIA");   
                            $res = 'TRUE';
                            $nuevoMov = $nuevoMov + 1; 
                        }else{
                            $sql = 'CALL sp_EliminarRegistrosHPcancelacion("'.$NumContrato.'", "'.$maxMov.'")';
                            if ($Vivienda->query($sql) == TRUE){  
                               // historia($nitavu, "SE ELIMINARON REGISTROS DE HISTORICO PAGOS QUE SE INSERTARON AL MOMENTO DE TRATAR DE CANCELAR, DEL NUMCONTRATO ".$NumContrato); 
                                mensaje('18. Ocurrio un error, favor de intentarlo nuevamente.','cancelarContrato.php');
                                //echo  '18. Ocurrio un error, favor de intentarlo nuevamente.';
                                return true;
                            }else{
                               // historia($nitavu, "OCURRIO UN ERROR AL TRATAR DE ELIMINAR REGISTROS DE HISTORICO PAGOS QUE SE INSERTARON AL MOMENTO DE TRATAR DE CANCELAR DEL NUMCONTRATO ".$NumContrato); 
                                mensaje('19. Ocurrio un error, favor de intentarlo nuevamente.','cancelarContrato.php');
                                //echo  '19. Ocurrio un error, favor de intentarlo nuevamente.';
                                return true;
                            }
                        }                     
                            
                       
                       
                    }
                    else
                    {                                       
                        // //INSERTAMOS LA CANTIDAD DE LA TRANSFERENCIA EN LA TABLA  HISTORICOPAGOS                       
                        $montoPagoRecibido=(((float)$Pagos - (float)$cargoAdmin) - (float)$DescuentoMorat) * -1  ;                                   
                        
                        $sql = "Insert into  historicopagos (numcontrato,nummov, montopagorecibido,fechaoperacion,saldocapitalcorriente,origen,tipomov,enviar, 
                        fechacaptura,idempcrea,capitalperiodocubierto,OBSERVACIONES,NuevoRezCapital,saldoexento,cancelado,origindata,FechaCorte)                      
                        values ( '".$NumContrato."',".$nuevoMov.", ".$montoPagoRecibido.",  now(),".$saldoCapitalCorriente.",'CAN', 19, 1, now(),".$nitavu.",".$montoPagoRecibido.",'".$observacion1."',0,".$saldoExento.",0,".$iddelegacion.", '".$fechaCorteUltimoMovCuenta."')";
                        
                        //echo $sql;
                        if ($Vivienda->query($sql) == TRUE){  
                           // historia($nitavu, "SE INSERTO REGISTRO EN HISTORICO PAGOS PARA CANCELAR  EL CONTRATO ".$NumContrato." POR TRANSFERENCIA");  
                            $res = 'TRUE';
                            $nuevoMov = $nuevoMov + 1;   
                        }else{
                            $sql = 'CALL sp_EliminarRegistrosHPcancelacion("'.$NumContrato.'", "'.$maxMov.'")';
                            if ($Vivienda->query($sql) == TRUE){  
                             //   historia($nitavu, "SE ELIMINARON REGISTROS DE HISTORICO PAGOS QUE SE INSERTARON AL MOMENTO DE TRATAR DE CANCELAR, DEL NUMCONTRATO ".$NumContrato); 
                                mensaje('20. Ocurrio un error, favor de intentarlo nuevamente.','cancelarContrato.php');
                                //echo  '20. Ocurrio un error, favor de intentarlo nuevamente.';
                                return true;
                            }else{
                              //  historia($nitavu, "OCURRIO UN ERROR AL TRATAR DE ELIMINAR REGISTROS DE HISTORICO PAGOS QUE SE INSERTARON AL MOMENTO DE TRATAR DE CANCELAR DEL NUMCONTRATO ".$NumContrato); 
                                mensaje('21. Ocurrio un error, favor de intentarlo nuevamente.','cancelarContrato.php');
                                //echo  '21. Ocurrio un error, favor de intentarlo nuevamente.';
                                return true;
                            }
                        }                     
                        
                    }
       
                      
                            
                //COMO SERIA EL ELIMINADO DE PAGOS 
                    //Insertamos en el registro en el nuevo foio.(TABLA PAGOS)
                    $ATransferir = (((float)$Pagos - (float)$cargoAdmin) - (float)$DescuentoMorat);                 
                    if($idprograma ==165 )
                    {
                        $foliorec1 = "165".substr( $NumContrato , 8 ,5 );
                    }
                    $sql = "insert into pagos (iddelegacion,idprograma,folio,foliorec,cancelado,enviar,fechacaptura,idempcrea,importe,numpago,fecha,observaciones,idtipomov) 
                    values ('".$iddelegacionnvo."','".$idprogramanvo."','".$folionvo."','".$foliorec1."', 0, 1, now(),'".$nitavu."','".$ATransferir."', '".$maxpagonvofolio."',now(),'" .$observacion2. "', 19)";
                    //echo $sql;
                    if ($Vivienda->query($sql) == TRUE){   
                        $res = 'TRUE';
                    }else{
                        $sql = 'CALL sp_EliminarRegistrosHPcancelacion("'.$NumContrato.'", "'.$maxMov.'")';
                        if ($Vivienda->query($sql) == TRUE){  
                          //  historia($nitavu, "SE ELIMINARON REGISTROS DE HISTORICO PAGOS QUE SE INSERTARON AL MOMENTO DE TRATAR DE CANCELAR, DEL NUMCONTRATO ".$NumContrato); 
                            mensaje('22. Ocurrio un error, favor de intentarlo nuevamente.','cancelarContrato.php');
                            //echo  '22. Ocurrio un error, favor de intentarlo nuevamente.';
                            return true;
                        }else{
                          //  historia($nitavu, "OCURRIO UN ERROR AL TRATAR DE ELIMINAR REGISTROS DE HISTORICO PAGOS QUE SE INSERTARON AL MOMENTO DE TRATAR DE CANCELAR DEL NUMCONTRATO ".$NumContrato); 
                            mensaje('23. Ocurrio un error, favor de intentarlo nuevamente.','cancelarContrato.php');
                            //echo  '23. Ocurrio un error, favor de intentarlo nuevamente.';
                            return true;
                        }
                        
                    }
                    

                
               

                } // CIERRE OPCION 2(TRANSFERENCIA)
                
            }  //CIERRE DE IF PAGOS

            
                //***************** C R E D I T O ******************************
            
                if(RstTotalRegCredito($NumContrato)== 0 )
                {
                    $saldoCapitalCorriente =$saldoCapitalCorriente-0;  
                }  
                else {
                    $saldoCapitalCorriente =(float)$saldoCapitalCorriente - (float)$rstcapitalperiodo;  
                } 

               
                if(RstTotalRegCredito($NumContrato)> 0 ) 
                {                       
                    $sql = "insert into  historicopagos (numcontrato,nummov,montopagorecibido,fechaoperacion,saldocapitalcorriente,origen,tipomov,enviar, 
                    fechacaptura,idempcrea,capitalperiodo,saldoexento,cancelado,origindata,FechaCorte) 
                    values ( '".$NumContrato."',".$nuevoMov.", 0,  now(),".$saldoCapitalCorriente.",'CAN',".$rsttipomov." , 1, now(),".$nitavu.",".($rstcapitalperiodo*-1).",".$saldoExento.",0,".$iddelegacion.", '".$fechaCorteUltimoMovCuenta."')";
                                      
                    echo $sql;
                    if ($Vivienda->query($sql) == TRUE){   
                       // historia($nitavu, "SE INSERTO REGISTRO EN HISTORICO PAGOS PARA CANCELAR EL CONTRATO ".$NumContrato." POR EL VALOR DEL CREDITO");  
                        $res = 'TRUE';
                        $nuevoMov = $nuevoMov + 1;  
                    }else{
                        $sql = 'CALL sp_EliminarRegistrosHPcancelacion("'.$NumContrato.'", "'.$maxMov.'")';
                        if ($Vivienda->query($sql) == TRUE){  
                         //   historia($nitavu, "SE ELIMINARON REGISTROS DE HISTORICO PAGOS QUE SE INSERTARON AL MOMENTO DE TRATAR DE CANCELAR, DEL NUMCONTRATO ".$NumContrato); 
                            mensaje('24. Ocurrio un error, favor de intentarlo nuevamente.','cancelarContrato.php');
                            //echo  '24. Ocurrio un error, favor de intentarlo nuevamente.';
                            return true;
                        }else{
                          //  historia($nitavu, "OCURRIO UN ERROR AL TRATAR DE ELIMINAR REGISTROS DE HISTORICO PAGOS QUE SE INSERTARON AL MOMENTO DE TRATAR DE CANCELAR DEL NUMCONTRATO ".$NumContrato); 
                            mensaje('25. Ocurrio un error, favor de intentarlo nuevamente.','cancelarContrato.php');
                            //echo  '25. Ocurrio un error, favor de intentarlo nuevamente.';
                            return true;
                        }
                    }
                    
                }

                 // CUANDO NO TIENE PAGOS SE INSERTA UN NUEVO REGISTRO CON LA OBSERVACION DEL NUMERO DE OFICIO CON EL QUE SE ESTA CANCELANDO EL CONTRATO.
                //if(Pagos($NumContrato)<= 0 ) 
               // {      
                      
                    // $nuevoRezMoratoriosUltimoMovCuenta=0;
                    // $nuevoRezFinancUltimoMovCuenta=0;
                    // $nuevoRezCapitalUltimoMovCuenta=0;
                    // $saldoCapitalCorrienteUltimoMovCuenta=0;
                
                    // $nuevoRezMoratoriosUltimoMovCuenta=obtenerNuevoRezMoratoriosUltimoMovCuenta($NumContrato,$maxMov);
                    // $nuevoRezFinancUltimoMovCuenta=obtenerNuevoRezFinancUltimoMovCuenta($NumContrato,$maxMov);
                    // $nuevoRezCapitalUltimoMovCuenta=obtenerNuevoRezCapitalUltimoMovCuenta($NumContrato,$maxMov);
                    // $saldoCapitalCorrienteUltimoMovCuenta = obtenerSaldoCapitalCorrienteUltimoMovCuenta($NumContrato,$maxMov);
                    // $sql = "insert into  historicopagos (numcontrato,nummov,montopagorecibido,fechaoperacion,saldocapitalcorriente,origen,tipomov,enviar, 
                    // fechacaptura,idempcrea,saldoexento,cancelado,origindata,Observaciones,IdSupervisor,RezMoratorios,NuevoRezMoratorios,RezFinanc,NuevoRezFinanc,RezCapital,NuevoRezCapital,FechaCorte=) 
                    // values ( '".$NumContrato."',".$nuevoMov.", 0,  now(),".$saldoCapitalCorrienteUltimoMovCuenta.",'CAN',141 , 1, now(),".$nitavu.",".$saldoExento.",0,".$iddelegacion.",'". $observacionesCancelacion."','".$maxMov
                    // ."',".$nuevoRezMoratoriosUltimoMovCuenta.",".$nuevoRezMoratoriosUltimoMovCuenta.",".$nuevoRezFinancUltimoMovCuenta.",".$nuevoRezFinancUltimoMovCuenta.",".
                    // $nuevoRezCapitalUltimoMovCuenta.",".$nuevoRezCapitalUltimoMovCuenta.",'".$fechaCorteUltimoMovCuenta."')";
                    // //echo $sql;
                    // if ($Vivienda->query($sql) == TRUE){   
                    //     historia($nitavu, "SE INSERTO REGISTRO EN HISTORICO PAGOS PARA INDICAR LA OBSERVACION DE LA CANCELACION DEL CONTRATO ".$NumContrato."". $sql);  
                    //     $res = 'TRUE';
                    //     $nuevoMov = $nuevoMov + 1;  
                    // }else{                     
                    //     $sql = 'CALL sp_EliminarRegistrosHPcancelacion("'.$NumContrato.'", "'.$maxMov.'")';
                    //     if ($Vivienda->query($sql) == TRUE){  
                    //        // historia($nitavu, "SE ELIMINARON REGISTROS DE HISTORICO PAGOS QUE SE INSERTARON AL MOMENTO DE TRATAR DE CANCELAR, DEL NUMCONTRATO ".$NumContrato); 
                    //         mensaje('24. Ocurrio un error, favor de intentarlo nuevamente.','cancelarContrato.php');
                    //         return true;
                    //     }else{
                    //         //historia($nitavu, "OCURRIO UN ERROR AL TRATAR DE ELIMINAR REGISTROS DE HISTORICO PAGOS QUE SE INSERTARON AL MOMENTO DE TRATAR DE CANCELAR DEL NUMCONTRATO ".$NumContrato); 
                    //         mensaje('25. Ocurrio un error, favor de intentarlo nuevamente.','cancelarContrato.php');
                    //         return true; 
                    //     }
                       
                    // }
          
                 
                   

                //}



                // CANCELACION DEL LOTE
                //$tipoPrograma =  tipoTramitePrograma($idprograma);
                if($tipoPrograma==2)
                {
                    $idlote='';
                    if(isset($_POST['idlote'])){
                        $idlote = $_POST['idlote'];
                    }
                    
                    //* ACTUALIZAMOS LOTES
                    //HACEMOS UN SELECT PARA OBTENER LOS DATOS DE LOS CAMPOS QUE SE ACTUALIZARAN, ESTO POR SI EN CASO DE QUE MARQUE ERROR PODER REGRESARLOS A COMO ESTABAN
                    $sql = 'Select * FROM lotes WHERE idLote='.$idlote.'';
                    $r = $Vivienda -> query($sql); 
                    $IdDelegacionlote = "";
                    $IdProgramalote = "";
                    $Foliolote = "";
                    $NumContratolote = "";
                    $Contratadolote = "";
                    $FechaUltimaModlote = "";
                    $IdEmpModificalote = "";
                    $IdEstatuslote = "";

                    while($f = $r -> fetch_array()) {    
                        $IdDelegacionlote = $f['IdDelegacion'];
                        $IdProgramalote = $f['IdPrograma'];
                        $Foliolote = $f['Folio'];
                        $NumContratolote = $f['NumContrato'];
                        $Contratadolote = $f['contratado'];
                        $FechaUltimaModlote = $f['FechaUltimaMod'];
                        $IdEmpModificalote = $f['IdEmpModifica'];
                        $IdEstatuslote = $f['IdEstatus'];
                    }

                    $sql = "UPDATE lotes SET IdDelegacion=NULL, IdPrograma=NULL, Folio=NULL, NumContrato=NULL,contratado=0,FechaUltimaMod=NOW(),IdEmpModifica='".$nitavu."'  
                    ,IdEstatus='".$opCancelacionLote."' WHERE idLote=".$idlote;
                    //echo $sql;
                    if ($Vivienda->query($sql) == TRUE){   
                        $res = 'TRUE';
                    }else{
                        $sql = 'CALL sp_EliminarRegistrosHPcancelacion("'.$NumContrato.'", "'.$maxMov.'")';
                        if ($Vivienda->query($sql) == TRUE){  
                          //  historia($nitavu, "SE ELIMINARON REGISTROS DE HISTORICO PAGOS QUE SE INSERTARON AL MOMENTO DE TRATAR DE CANCELAR, DEL NUMCONTRATO ".$NumContrato); 
                            mensaje('26. Ocurrio un error, favor de intentarlo nuevamente.','cancelarContrato.php');
                           // echo  '26. Ocurrio un error, favor de intentarlo nuevamente.';
                            return true;
                        }else{
                           // historia($nitavu, "OCURRIO UN ERROR AL TRATAR DE ELIMINAR REGISTROS DE HISTORICO PAGOS QUE SE INSERTARON AL MOMENTO DE TRATAR DE CANCELAR DEL NUMCONTRATO ".$NumContrato); 
                            mensaje('27. Ocurrio un error, favor de intentarlo nuevamente.','cancelarContrato.php');
                            //echo  '27. Ocurrio un error, favor de intentarlo nuevamente.';
                            return true;
                        }
                    }
                   
                   
                  /*  $numescritura=ObtenerNumEscrituraConContrato($NumContrato);
                    if($numescritura!='FALSE')
                    {
                        if(ExisteTramiteEscritura($numescritura)=='Activo')
                        {
                            if(CancelarRegistroMovEscritura($numescritura,$nitavu,'Se canceló el contrato '.$NumContrato,1)=="TRUE")
                            {
                                $res = 'TRUE';
                            }else 
                            {
                                //$res = 'HUBO UN ERROR AL INTENTAR CANCELAR EL REGISTRO DE ESCRITURA';
                                if($opcion == '2'){
                                    $sql = 'CALL sp_EliminarRegistrosHpLotesPagos("'.$NumContrato.'", "'.$maxMov.'", "'.$IdDelegacionlote.'",
                                    "'.$IdProgramalote.'", "'.$Foliolote.'", "'.$NumContratolote.'", "'.$Contratadolote.'", "'.$FechaUltimaModlote.'", "'.$IdEmpModificalote.'", "'.$IdEstatuslote.'", "'.$idlote.'", "'.$iddelegacionnvo.'", "'.$idprogramanvo.'", "'.$folionvo.'", "'.$foliorec1.'")';
                                }else{
                                    $sql = 'CALL sp_EliminarRegistrosHpLotes("'.$NumContrato.'", "'.$maxMov.'","'.$IdDelegacionlote.'",
                                    "'.$IdProgramalote.'", "'.$Foliolote.'",  "'.$NumContratolote.'", "'.$Contratadolote.'", "'.$FechaUltimaModlote.'", "'.$IdEmpModificalote.'", "'.$IdEstatuslote.'", "'.$idlote.'")';
                                }
                               
                                //echo $sql;
                                if ($Vivienda->query($sql) == TRUE){  
                                  //  historia($nitavu, "SE ELIMINARON REGISTROS DE HISTORICO PAGOS QUE SE INSERTARON AL MOMENTO DE TRATAR DE CANCELAR, DEL NUMCONTRATO ".$NumContrato); 
                                    mensaje('28. Ocurrio un error, favor de intentarlo nuevamente.','cancelarContrato.php');
                                    //echo  '28. Ocurrio un error, favor de intentarlo nuevamente.';
                                    return true;
                                }else{
                                  //  historia($nitavu, "OCURRIO UN ERROR AL TRATAR DE ELIMINAR REGISTROS DE HISTORICO PAGOS QUE SE INSERTARON AL MOMENTO DE TRATAR DE CANCELAR DEL NUMCONTRATO ".$NumContrato); 
                                    mensaje('29. Ocurrio un error, favor de intentarlo nuevamente.','cancelarContrato.php');
                                    //echo  '29. Ocurrio un error, favor de intentarlo nuevamente.';
                                    return true;
                                }
                           }
                            
                        }
                    } */

                }
                // CREDITO
                // CANCELACION DE LOS VALES   
                else {
                    //echo 'entro a ministracion';
                    //OBTENEMOS LOS DATOS QUE TIENE LA TABLA CONTRATOS PARA EN CASO DE QUE HAYA ERROR REGRESAR A LOS MISMOS VALORES
                    $sql = "SELECT * FROM ministracioncredito WHERE NumContrato = " .$NumContrato. " and Cancelado=0";
                    $r = $Vivienda -> query($sql); 
                    //echo  $sql;
                    $CANCELADOMinistracion = "";
                    $fechaultimamodMinistracion = "";
                    $enviarMinistracion = "";
                    $idempmodificaMinistracion = "";

                    while($f = $r -> fetch_array()) {    
                        $CANCELADOMinistracion = $f['Cancelado'];
                        $fechaultimamodMinistracion = $f['FechaUltimaMod'];
                        $enviarMinistracion = $f['Enviar'];
                        $idempmodificaMinistracion = $f['IdEmpModifica'];
                    }

                    $sql = "update ministracioncredito set Cancelado=1,FechaUltimaMod=NOW(), Enviar=1, IdEmpModifica=" .$nitavu. " where NumContrato='" .$NumContrato. "' and Cancelado=0";
                    //echo $sql;
                    if ($Vivienda->query($sql) == TRUE){   
                        $res = 'TRUE';
                    }else{
                        //$res = 'FALSE';
                        if($opcion == "2"){
                            $sql = 'CALL sp_EliminarRegistrosHpPagos("'.$NumContrato.'", "'.$maxMov.'", "'.$iddelegacionnvo.'", "'.$idprogramanvo.'", "'.$folionvo.'", "'.$foliorec1.'",  
                            "'.$CANCELADOMinistracion.'", "'.$fechaultimamodMinistracion.'", "'.$enviarMinistracion.'", "'.$idempmodificaMinistracion.'")';
                        }else{
                            $sql = 'CALL sp_EliminarRegistrosHPcancelacion("'.$NumContrato.'", "'.$maxMov.'")';
                        }
                        //echo $sql;
                        if ($Vivienda->query($sql) == TRUE){  
                           // historia($nitavu, "SE ELIMINARON REGISTROS DE HISTORICO PAGOS QUE SE INSERTARON AL MOMENTO DE TRATAR DE CANCELAR, DEL NUMCONTRATO ".$NumContrato); 
                            mensaje('30. Ocurrio un error, favor de intentarlo nuevamente.','cancelarContrato.php');
                            //echo  '30. Ocurrio un error, favor de intentarlo nuevamente.';
                            return true;
                        }else{
                          //  historia($nitavu, "OCURRIO UN ERROR AL TRATAR DE ELIMINAR REGISTROS DE HISTORICO PAGOS QUE SE INSERTARON AL MOMENTO DE TRATAR DE CANCELAR DEL NUMCONTRATO ".$NumContrato); 
                            mensaje('31. Ocurrio un error, favor de intentarlo nuevamente.','cancelarContrato.php');
                            //echo  '31. Ocurrio un error, favor de intentarlo nuevamente.';
                            return true;
                        }
                    }
                    
                }

                echo "entro";
               //OBTENEMOS LOS DATOS QUE TIENE LA TABLA CONTRATOS PARA EN CASO DE QUE HAYA ERROR REGRESAR A LOS MISMOS VALORES
                $sql = "SELECT * from contratos WHERE NumContrato = " .$NumContrato. "";
                $r = $Vivienda -> query($sql); 
                $enviarContrato = "";
                $idempmodificaContrato = "";
                $fechaultimamodContrato = "";
                $fechacancelacionContrato = "";
                $CANCELADOContrato = "";
                $ObservacionesContrato = "";

                while($f = $r -> fetch_array()) {    
                    $enviarContrato = $f['Enviar'];
                    $idempmodificaContrato = $f['IdEmpModifica'];
                    $fechaultimamodContrato = $f['FechaUltimaMod'];
                    $fechacancelacionContrato = $f['fechacancelacion'];
                    $CANCELADOContrato = $f['Cancelado'];
                    $ObservacionesContrato = $f['Observaciones'];
                }
                 //CANCELEAMOS EL CONTRATO EN TABLA CONTRATOS. 
                $sql = "update contratos SET enviar=1, idempmodifica=" .$nitavu.",fechaultimamod=now(),fechacancelacion=NOW(),CANCELADO=1, Observaciones='".$observacionesCancelacion."' WHERE NumContrato = '" .$NumContrato. "'";
                echo $sql;
                if ($Vivienda->query($sql) == TRUE){   
                    $res = 'TRUE';
                }else{
                    //$res = 'FALSE';
                    if($opcion == '2'){
                        if($tipoPrograma==2){
                            $sql = 'CALL sp_EliminarRegistrosHpLotesPagos("'.$NumContrato.'", "'.$maxMov.'","'.$IdDelegacionlote.'",
                            "'.$IdProgramalote.'", "'.$Foliolote.'",  "'.$NumContratolote.'", "'.$Contratadolote.'", "'.$FechaUltimaModlote.'", "'.$IdEmpModificalote.'", "'.$IdEstatuslote.'", "'.$idlote.'", "'.$iddelegacionnvo.'", "'.$idprogramanvo.'", "'.$folionvo.'", "'.$foliorec1.'")';

                        }else{
                            $sql = 'CALL sp_EliminarRegistrosHpPagosMinistracion("'.$NumContrato.'", "'.$maxMov.'","'.$iddelegacionnvo.'", "'.$idprogramanvo.'", "'.$folionvo.'", "'.$foliorec1.'", "'.$CANCELADOMinistracion.'", "'.$fechaultimamodMinistracion.'", "'.$enviarMinistracion.'", "'.$idempmodificaMinistracion.'" )';
                        }
                    }else{
                        if($tipoPrograma==2){
                            $sql = 'CALL sp_EliminarRegistrosHpLotes("'.$NumContrato.'", "'.$maxMov.'","'.$IdDelegacionlote.'",
                            "'.$IdProgramalote.'", "'.$Foliolote.'",  "'.$NumContratolote.'", "'.$Contratadolote.'", "'.$FechaUltimaModlote.'", "'.$IdEmpModificalote.'", "'.$IdEstatuslote.'", "'.$idlote.'" )';
                        }else{
                            $sql = 'CALL sp_EliminarRegistrosHPcancelacionMinistracion("'.$NumContrato.'", "'.$maxMov.'", "'.$CANCELADOMinistracion.'", "'.$fechaultimamodMinistracion.'", "'.$enviarMinistracion.'", "'.$idempmodificaMinistracion.'" )';
                        }
                    }
                    //echo $sql;
                    if ($Vivienda->query($sql) == TRUE){  
                       // historia($nitavu, "SE ELIMINARON REGISTROS DE HISTORICO PAGOS QUE SE INSERTARON AL MOMENTO DE TRATAR DE CANCELAR, DEL NUMCONTRATO ".$NumContrato); 
                        mensaje('32. Ocurrio un error, favor de intentarlo nuevamente.','cancelarContrato.php');
                        //echo  '32. Ocurrio un error, favor de intentarlo nuevamente.';
                        return true;
                    }else{
                       // historia($nitavu, "OCURRIO UN ERROR AL TRATAR DE ELIMINAR REGISTROS DE HISTORICO PAGOS QUE SE INSERTARON AL MOMENTO DE TRATAR DE CANCELAR DEL NUMCONTRATO ".$NumContrato); 
                        mensaje('33. Ocurrio un error, favor de intentarlo nuevamente.','cancelarContrato.php');
                        //echo  '33. Ocurrio un error, favor de intentarlo nuevamente.';
                        return true;
                    }
                }


                //OBTENEMOS LOS DATOS QUE TIENE LA TABLA CONTROLCONTRATOS PARA EN CASO DE QUE HAYA ERROR REGRESAR A LOS MISMOS VALORES
               $sql = "SELECT * from controlcontratos WHERE NumContrato = " .$NumContrato. "";
               $r = $Vivienda -> query($sql); 
              
               $estatausCuentaControlContratos = "";
               $idempmodificaControlContrato = "";
               $fechaultimamodControlContrato = "";               

               while($f = $r -> fetch_array()) {                      
                   $estatausCuentaControlContratos = $f['EstatusCuenta'];
                   $idempmodificaControlContrato = $f['IdEmpModifica'];
                   $fechaultimamodControlContrato = $f['FechaUltimaMod'];                   

               }          
               
                // //* ACTUALIZMOS CONTROL CONTRATOS
                $sql = " controlcontratos set estatuscuenta=6,fechaultimamod=NOW(), enviar=1,IDEMPMODIFICA=" .$nitavu. " where numcontrato='".$NumContrato."'";;
                echo $sql;
                if ($Vivienda->query($sql) == TRUE){   
                    $res = 'TRUE';
                }else{
                    //SI MARCO ERROR DEBEMOS ELIMINAR TODOS LOS REGISTROS INSERTADOS EN LAS TABLAS ANTERIORES
                   
                    //SI FUE UNA TRANSFERENCIA ENTRA A ELIMINAR A ESTAS TABLAS
                    if($opcion == '2'){
                        //SI FUE POR UN LOTE
                        if($tipoPrograma==2){
                            $sql = 'CALL sp_EliminarRegistrosHpLotesPagosContratos("'.$NumContrato.'", "'.$maxMov.'","'.$IdDelegacionlote.'", "'.$IdProgramalote.'", "'.$Foliolote.'",  "'.$NumContratolote.'", "'.$Contratadolote.'", "'.$FechaUltimaModlote.'", "'.$IdEmpModificalote.'", "'.$IdEstatuslote.'", "'.$idlote.'", "'.$iddelegacionnvo.'", "'.$idprogramanvo.'", "'.$folionvo.'", "'.$foliorec1.'", "'.$enviarContrato.'", "'.$idempmodificaContrato.'", "'.$fechaultimamodContrato.'", "'.$fechacancelacionContrato.'", "'.$CANCELADOContrato.'", "'.$ObservacionesContrato.'")';

                        //SI FUE POR UN CREDITO
                        }else{
                            $sql = 'CALL sp_EliminarRegistrosHpPagosContratosMinistracion("'.$NumContrato.'", "'.$maxMov.'","'.$iddelegacionnvo.'", "'.$idprogramanvo.'", "'.$folionvo.'", "'.$foliorec1.'", "'.$enviarContrato.'", "'.$idempmodificaContrato.'", "'.$fechaultimamodContrato.'", "'.$fechacancelacionContrato.'", "'.$CANCELADOContrato.'", "'.$ObservacionesContrato.'", "'.$CANCELADOMinistracion.'", "'.$fechaultimamodMinistracion.'", "'.$enviarMinistracion.'", "'.$idempmodificaMinistracion.'")';

                        }
                        //SI NO ES TRANSFERENCIA ENTRA AQUI
                    }else{
                        //SI FUE POR UN LOTE
                        if($tipoPrograma==2){
                            $sql = 'CALL sp_EliminarRegistrosHpLotesContratos("'.$NumContrato.'", "'.$maxMov.'","'.$IdDelegacionlote.'",
                            "'.$IdProgramalote.'", "'.$Foliolote.'",  "'.$NumContratolote.'", "'.$Contratadolote.'", "'.$FechaUltimaModlote.'", "'.$IdEmpModificalote.'", "'.$IdEstatuslote.'", "'.$idlote.'",
                            "'.$enviarContrato.'", "'.$idempmodificaContrato.'", "'.$fechaultimamodContrato.'", "'.$fechacancelacionContrato.'", "'.$CANCELADOContrato.'", "'.$ObservacionesContrato.'" )';
                        //SI FUE POR UN CREDITO
                        }else{
                            $sql = 'CALL sp_EliminarRegistrosHPcancelacionContratosMinistracion("'.$NumContrato.'", "'.$maxMov.'",
                            "'.$enviarContrato.'", "'.$idempmodificaContrato.'", "'.$fechaultimamodContrato.'", "'.$fechacancelacionContrato.'", "'.$CANCELADOContrato.'", "'.$ObservacionesContrato.'",
                            "'.$CANCELADOMinistracion.'", "'.$fechaultimamodMinistracion.'", "'.$enviarMinistracion.'", "'.$idempmodificaMinistracion.'")';    
                        }
                    }
                    //echo $sql;
                    if ($Vivienda->query($sql) == TRUE){  
                       // historia($nitavu, "SE ELIMINARON REGISTROS DE HISTORICO PAGOS QUE SE INSERTARON AL MOMENTO DE TRATAR DE CANCELAR, DEL NUMCONTRATO ".$NumContrato); 
                        mensaje('34. Ocurrio un error, favor de intentarlo nuevamente.','cancelarContrato.php');
                        //echo  '34. Ocurrio un error, favor de intentarlo nuevamente.';
                        return true;
                    }else{
                      //  historia($nitavu, "OCURRIO UN ERROR AL TRATAR DE ELIMINAR REGISTROS DE HISTORICO PAGOS QUE SE INSERTARON AL MOMENTO DE TRATAR DE CANCELAR DEL NUMCONTRATO ".$NumContrato); 
                        mensaje('35. Ocurrio un error, favor de intentarlo nuevamente.','cancelarContrato.php');
                        //echo  '35. Ocurrio un error, favor de intentarlo nuevamente.';
                        return true;
                    }
                }

                // INSERTAMOS EN DATOSCANCELACION
                $sql = "Insert into datoscancelacion(NumContrato,TipoCancelacion,FolioDestino,IdProgramaDestino,IdDelegacionDestino,NumCancelacion,FechaCancelacion)
                Values ('".$NumContrato."','".$opcion."','".$folionvo."','".$idprogramanvo."','".$iddelegacionnvo."','".$numcancelacion."',now())";
                echo $sql;
                if ($Vivienda->query($sql) == TRUE){   
                    $res = 'TRUE';
                }else{

                  //SI MARCO ERROR DEBEMOS ELIMINAR TODOS LOS REGISTROS INSERTADOS EN LAS TABLAS ANTERIORES
                   
                    //SI FUE UNA TRANSFERENCIA ENTRA A ELIMINAR A ESTAS TABLAS
                    if($opcion == '2'){
                        //SI FUE POR UN LOTE
                        if($tipoPrograma==2){
                            $sql = 'CALL sp_EliminarRegistrosHpLotesPagosContratosControlContratos("'.$NumContrato.'", "'.$maxMov.'","'.$IdDelegacionlote.'", "'.$IdProgramalote.'", "'.
                            $Foliolote.'",  "'.$NumContratolote.'", "'.$Contratadolote.'", "'.$FechaUltimaModlote.'", "'.$IdEmpModificalote.'", "'.$IdEstatuslote.'", "'.$idlote.'", "'.$iddelegacionnvo.'", "'
                            .$idprogramanvo.'", "'.$folionvo.'", "'.$foliorec1.'", "'.$enviarContrato.'", "'.$idempmodificaContrato.'", "'.$fechaultimamodContrato.'", "'.
                            $fechacancelacionContrato.'", "'.$CANCELADOContrato.'", "'.$ObservacionesContrato.'","'.$estatausCuentaControlContratos.'","'.$fechaultimamodControlContrato.'","'.$idempmodificaControlContrato.'")';

                        //SI FUE POR UN CREDITO
                        }else{
                            $sql = 'CALL sp_EliminarRegistrosHpPagosContratosMinistracionControlContratos("'.$NumContrato.'", "'.$maxMov.'","'.$iddelegacionnvo.'", "'.$idprogramanvo.'", "'.$folionvo.'", "'.$foliorec1.'", "'.$enviarContrato.
                            '", "'.$idempmodificaContrato.'", "'.$fechaultimamodContrato.'", "'.$fechacancelacionContrato.'", "'.$CANCELADOContrato.'", "'.$ObservacionesContrato.'", "'.$CANCELADOMinistracion.'", "'.$fechaultimamodMinistracion.
                            '", "'.$enviarMinistracion.'", "'.$idempmodificaMinistracion.'","'.$estatausCuentaControlContratos.'","'.$fechaultimamodControlContrato.'","'.$idempmodificaControlContrato.'")';

                        }
                        //SI NO ES TRANSFERENCIA ENTRA AQUI
                    }else{
                        //SI FUE POR UN LOTE
                        if($tipoPrograma==2){
                            $sql = 'CALL sp_EliminarRegistrosHpLotesContratosControlContratos("'.$NumContrato.'", "'.$maxMov.'","'.$IdDelegacionlote.'",
                            "'.$IdProgramalote.'", "'.$Foliolote.'",  "'.$NumContratolote.'", "'.$Contratadolote.'", "'.$FechaUltimaModlote.'", "'.$IdEmpModificalote.'", "'.$IdEstatuslote.'", "'.$idlote.'",
                            "'.$enviarContrato.'", "'.$idempmodificaContrato.'", "'.$fechaultimamodContrato.'", "'.$fechacancelacionContrato.'", "'.
                            $CANCELADOContrato.'", "'.$ObservacionesContrato.'","'.$estatausCuentaControlContratos.'","'.$fechaultimamodControlContrato.'","'.$idempmodificaControlContrato.'")';
                           
                            
                        //SI FUE POR UN CREDITO
                        }else{
                            $sql = 'CALL sp_EliminarRegistrosHPcancelacionContratosMinistracionCtrlCont("'.$NumContrato.'", "'.$maxMov.'",
                            "'.$enviarContrato.'", "'.$idempmodificaContrato.'", "'.$fechaultimamodContrato.'", "'.$fechacancelacionContrato.'", "'.$CANCELADOContrato.'", "'.$ObservacionesContrato.'",
                            "'.$CANCELADOMinistracion.'", "'.$fechaultimamodMinistracion.'", "'.$enviarMinistracion.'", "'.$idempmodificaMinistracion
                            .'","'.$estatausCuentaControlContratos.'","'.$fechaultimamodControlContrato.'","'.$idempmodificaControlContrato.'")';
                        }
                    }
                    //echo $sql;
                    if ($Vivienda->query($sql) == TRUE){  
                       // historia($nitavu, "SE ELIMINARON REGISTROS DE HISTORICO PAGOS QUE SE INSERTARON AL MOMENTO DE TRATAR DE CANCELAR, DEL NUMCONTRATO ".$NumContrato); 
                        mensaje('36. Ocurrio un error, favor de intentarlo nuevamente.','cancelarContrato.php');
                        //echo  '34. Ocurrio un error, favor de intentarlo nuevamente.';
                        return true;
                    }else{
                      //  historia($nitavu, "OCURRIO UN ERROR AL TRATAR DE ELIMINAR REGISTROS DE HISTORICO PAGOS QUE SE INSERTARON AL MOMENTO DE TRATAR DE CANCELAR DEL NUMCONTRATO ".$NumContrato); 
                        mensaje('37. Ocurrio un error, favor de intentarlo nuevamente.','cancelarContrato.php');
                        //echo  '35. Ocurrio un error, favor de intentarlo nuevamente.';
                        return true;
                    }

               
                }
             //}

            //SE CANCELA EN SOLICITUDES  
            $cancelado = cancelarSolicitud($idprograma,$iddelegacion,$folio,$observacionesCancelacion,$nitavu);                 
            if($cancelado==TRUE){
               
                // //BUSCAMOS DATOS EVALUACION
                $sql3 = 'SELECT * FROM datosevaluacion WHERE IdDelegacion='.$iddelegacion.' AND IdPrograma='.$idprograma.' AND  Folio='.$folio.'';
                //echo $sql3;
                $r3 = $Vivienda -> query($sql3);               
                $r_count3 = $r3 -> num_rows;
                if($r_count3 > 0){
                    while($f3 = $r3 -> fetch_array()) {
                        if ($f3['Aprobado'] = -1 And $f3['IdEmpEvaluador'] <> 0 And $f3['FechaEvaluacion'] <> ''){
                            $sql4 = "Update metas Set MontoAutorizado= (MontoAutorizado) - (".$f3['MontoCredito']."), AccionesAutorizadas= (AccionesAutorizadas) - (1) Where IdDelegacion=".$iddelegacion." and IdPrograma=".$idprograma."";
                           // echo $sql4;
                            if ($Vivienda->query($sql4) == TRUE){
                                $res = 'TRUE';
                            }else{
                                $res = 'FALSE';
                               //SI FUE UNA TRANSFERENCIA ENTRA A ELIMINAR A ESTAS TABLAS
                                if($opcion == '2'){
                                    //SI FUE POR UN LOTE
                                    if($tipoPrograma==2){
                                        $sql = 'CALL sp_EliminarRegistrosHpLotesPagosContratosControlContratosCanSol("'.$NumContrato.'", "'.$maxMov.'","'.$IdDelegacionlote.'", "'.$IdProgramalote.'", "'.
                                        $Foliolote.'",  "'.$NumContratolote.'", "'.$Contratadolote.'", "'.$FechaUltimaModlote.'", "'.$IdEmpModificalote.'", "'.$IdEstatuslote.'", "'.$idlote.'", "'.$iddelegacionnvo.'", "'
                                        .$idprogramanvo.'", "'.$folionvo.'", "'.$foliorec1.'", "'.$enviarContrato.'", "'.$idempmodificaContrato.'", "'.$fechaultimamodContrato.'", "'.
                                        $fechacancelacionContrato.'", "'.$CANCELADOContrato.'", "'.$ObservacionesContrato.'","'.$estatausCuentaControlContratos.'","'.$fechaultimamodControlContrato.'","'.$idempmodificaControlContrato.'")';

                                    //SI FUE POR UN CREDITO
                                    }else{
                                        $sql = 'CALL sp_EliminarRegistrosHpPagosContratosMinControlContratosCanSol("'.$NumContrato.'", "'.$maxMov.'","'.$iddelegacionnvo.'", "'.$idprogramanvo.'", "'.$folionvo.'", "'.$foliorec1.'", "'.$enviarContrato.
                                        '", "'.$idempmodificaContrato.'", "'.$fechaultimamodContrato.'", "'.$fechacancelacionContrato.'", "'.$CANCELADOContrato.'", "'.$ObservacionesContrato.'", "'.$CANCELADOMinistracion.'", "'.$fechaultimamodMinistracion.
                                        '", "'.$enviarMinistracion.'", "'.$idempmodificaMinistracion.'","'.$estatausCuentaControlContratos.'","'.$fechaultimamodControlContrato.'","'.$idempmodificaControlContrato.'","'.$iddelegacion.'",
                                        "'.$idprograma.'", "'.$folio.'")';

                                    }
                                    //SI NO ES TRANSFERENCIA ENTRA AQUI
                                }else{
                                    //SI FUE POR UN LOTE
                                    if($tipoPrograma==2){
                                        $sql = 'CALL sp_EliminarRegistrosHpLotesContratosControlContratosCanSol("'.$NumContrato.'", "'.$maxMov.'","'.$IdDelegacionlote.'",
                                        "'.$IdProgramalote.'", "'.$Foliolote.'",  "'.$NumContratolote.'", "'.$Contratadolote.'", "'.$FechaUltimaModlote.'", "'.$IdEmpModificalote.'", "'.$IdEstatuslote.'", "'.$idlote.'",
                                        "'.$enviarContrato.'", "'.$idempmodificaContrato.'", "'.$fechaultimamodContrato.'", "'.$fechacancelacionContrato.'", "'.
                                        $CANCELADOContrato.'", "'.$ObservacionesContrato.'","'.$estatausCuentaControlContratos.'","'.$fechaultimamodControlContrato.'","'.$idempmodificaControlContrato.'")';
                                    
                                        
                                    //SI FUE POR UN CREDITO
                                    }else{
                                        $sql = 'CALL sp_EliminarRegistrosHPcancelacionContratosMinCtrlContCan("'.$NumContrato.'", "'.$maxMov.'",
                                        "'.$enviarContrato.'", "'.$idempmodificaContrato.'", "'.$fechaultimamodContrato.'", "'.$fechacancelacionContrato.'", "'.$CANCELADOContrato.'", "'.$ObservacionesContrato.'",
                                        "'.$CANCELADOMinistracion.'", "'.$fechaultimamodMinistracion.'", "'.$enviarMinistracion.'", "'.$idempmodificaMinistracion
                                        .'","'.$estatausCuentaControlContratos.'","'.$fechaultimamodControlContrato.'","'.$idempmodificaControlContrato.'","'.$iddelegacion.'",
                                        "'.$idprograma.'", "'.$folio.'")';
                                    }
                                }
                              echo $sql;
                                if ($Vivienda->query($sql) == TRUE){  
                                // historia($nitavu, "SE ELIMINARON REGISTROS DE HISTORICO PAGOS QUE SE INSERTARON AL MOMENTO DE TRATAR DE CANCELAR, DEL NUMCONTRATO ".$NumContrato); 
                                    mensaje('38. Ocurrio un error, favor de intentarlo nuevamente.','cancelarContrato.php');                                       
                                // return false;
                                }else{                       
                                //  historia($nitavu, "OCURRIO UN ERROR AL TRATAR DE ELIMINAR REGISTROS DE HISTORICO PAGOS QUE SE INSERTARON AL MOMENTO DE TRATAR DE CANCELAR DEL NUMCONTRATO ".$NumContrato); 
                                    mensaje('39. Ocurrio un error, favor de intentarlo nuevamente.','cancelarContrato.php');                       
                                    //return false;
                                }
                             } 

                        }
                    }

                }
            }else //SI MARCA ERROR DESHACEMOS TODOS LO RESGISTROS QUE SE HAYAN INSERTARDO O MODIFICADO 
            {                               
                    //SI FUE UNA TRANSFERENCIA ENTRA A ELIMINAR A ESTAS TABLAS
                    if($opcion == '2'){
                        //SI FUE POR UN LOTE
                        if($tipoPrograma==2){
                            $sql = 'CALL sp_EliminarRegistrosHpLotesPagosContratosControlContratosCan("'.$NumContrato.'", "'.$maxMov.'","'.$IdDelegacionlote.'", "'.$IdProgramalote.'", "'.
                            $Foliolote.'",  "'.$NumContratolote.'", "'.$Contratadolote.'", "'.$FechaUltimaModlote.'", "'.$IdEmpModificalote.'", "'.$IdEstatuslote.'", "'.$idlote.'", "'.$iddelegacionnvo.'", "'
                            .$idprogramanvo.'", "'.$folionvo.'", "'.$foliorec1.'", "'.$enviarContrato.'", "'.$idempmodificaContrato.'", "'.$fechaultimamodContrato.'", "'.
                            $fechacancelacionContrato.'", "'.$CANCELADOContrato.'", "'.$ObservacionesContrato.'","'.$estatausCuentaControlContratos.'","'.$fechaultimamodControlContrato.'","'.$idempmodificaControlContrato.'")';

                        //SI FUE POR UN CREDITO
                        }else{
                            $sql = 'CALL sp_EliminarRegistrosHpPagosContratosMinControlContratosCan("'.$NumContrato.'", "'.$maxMov.'","'.$iddelegacionnvo.'", "'.$idprogramanvo.'", "'.$folionvo.'", "'.$foliorec1.'", "'.$enviarContrato.
                            '", "'.$idempmodificaContrato.'", "'.$fechaultimamodContrato.'", "'.$fechacancelacionContrato.'", "'.$CANCELADOContrato.'", "'.$ObservacionesContrato.'", "'.$CANCELADOMinistracion.'", "'.$fechaultimamodMinistracion.
                            '", "'.$enviarMinistracion.'", "'.$idempmodificaMinistracion.'","'.$estatausCuentaControlContratos.'","'.$fechaultimamodControlContrato.'","'.$idempmodificaControlContrato.'")';

                        }
                        //SI NO ES TRANSFERENCIA ENTRA AQUI
                    }else{
                        //SI FUE POR UN LOTE
                        if($tipoPrograma==2){
                            $sql = 'CALL sp_EliminarRegistrosHpLotesContratosControlContratosCan("'.$NumContrato.'", "'.$maxMov.'","'.$IdDelegacionlote.'",
                            "'.$IdProgramalote.'", "'.$Foliolote.'",  "'.$NumContratolote.'", "'.$Contratadolote.'", "'.$FechaUltimaModlote.'", "'.$IdEmpModificalote.'", "'.$IdEstatuslote.'", "'.$idlote.'",
                            "'.$enviarContrato.'", "'.$idempmodificaContrato.'", "'.$fechaultimamodContrato.'", "'.$fechacancelacionContrato.'", "'.
                            $CANCELADOContrato.'", "'.$ObservacionesContrato.'","'.$estatausCuentaControlContratos.'","'.$fechaultimamodControlContrato.'","'.$idempmodificaControlContrato.'")';
                           
                            
                        //SI FUE POR UN CREDITO
                        }else{
                            $sql = 'CALL sp_EliminarRegistrosHPcancelacionContratosMinCtrlContCan("'.$NumContrato.'", "'.$maxMov.'",
                            "'.$enviarContrato.'", "'.$idempmodificaContrato.'", "'.$fechaultimamodContrato.'", "'.$fechacancelacionContrato.'", "'.$CANCELADOContrato.'", "'.$ObservacionesContrato.'",
                            "'.$CANCELADOMinistracion.'", "'.$fechaultimamodMinistracion.'", "'.$enviarMinistracion.'", "'.$idempmodificaMinistracion
                            .'","'.$estatausCuentaControlContratos.'","'.$fechaultimamodControlContrato.'","'.$idempmodificaControlContrato.'")';
                        }
                    }
                  
                    if ($Vivienda->query($sql) == TRUE){  
                       // historia($nitavu, "SE ELIMINARON REGISTROS DE HISTORICO PAGOS QUE SE INSERTARON AL MOMENTO DE TRATAR DE CANCELAR, DEL NUMCONTRATO ".$NumContrato); 
                         mensaje('40. Ocurrio un error, favor de intentarlo nuevamente.','cancelarContrato.php');                                       
                       // return false;
                    }else{                       
                      //  historia($nitavu, "OCURRIO UN ERROR AL TRATAR DE ELIMINAR REGISTROS DE HISTORICO PAGOS QUE SE INSERTARON AL MOMENTO DE TRATAR DE CANCELAR DEL NUMCONTRATO ".$NumContrato); 
                        mensaje('41. Ocurrio un error, favor de intentarlo nuevamente.','cancelarContrato.php');                       
                        //return false;
                    }


            }


        } //CIERRE DEL IF opcion 1 o 2
        
        if($opcion == '3'){
            $sql = "INSERT INTO  historicopagos (numcontrato,nummov, montopagorecibido,fechaoperacion,saldocapitalcorriente,origen,tipomov,enviar, 
            fechacaptura,idempcrea,capitalperiodocubierto,OriginData) values ('".$NumContrato."',".$nuevoMov.", ".$saldoCapitalCorriente.",now(), 0,'PCA', 27, 1, now(), ".$nitavu.",".$saldoCapitalCorriente.",".$iddelegacion.")";
           // echo $sql;
            if ($Vivienda->query($sql) == TRUE){   
               // historia($nitavu, "SE INSERTO REGISTRO EN HISTORICO PAGOS PARA CANCELAR  EL CONTRATO ".$NumContrato." POR CANCELACION POR DEFUNCION");  
                $res = 'TRUE';
                $nuevoMov = $nuevoMov + 1;
            }else{
                mensaje('42. Ocurrio un error, favor de intentarlo nuevamente.','cancelarContrato.php');
                //echo  '37. Ocurrio un error, favor de intentarlo nuevamente.';
                return false;
            }

            
            //OBTENEMOS LOS DATOS QUE TIENE LA TABLA CONTROLCONTRATOS PARA EN CASO DE QUE HAYA ERROR REGRESAR A LOS MISMOS VALORES
            $sql = "SELECT * from controlcontratos WHERE NumContrato = " .$NumContrato. "";
            $r = $Vivienda -> query($sql); 
           
            $estatausCuentaControlContratos = "";
            $idempmodificaControlContrato = "";
            $fechaultimamodControlContrato = "";               

            while($f = $r -> fetch_array()) {                      
                $estatausCuentaControlContratos = $f['EstatusCuenta'];
                $idempmodificaControlContrato = $f['IdEmpModifica'];
                $fechaultimamodControlContrato = $f['FechaUltimaMod'];                   

            }  


             // ACTUALIZMOS CONTROL CONTRATOS
            $sql = "update controlcontratos set estatuscuenta=1,fechaultimamod=NOW(), enviar=1,IDEMPMODIFICA=" .$nitavu. " where numcontrato='".$NumContrato."'";;
             //echo $sql;
             if ($Vivienda->query($sql) == TRUE){   
                 $res = 'TRUE';
             }else{
                $sql1 = "DELETE from  historicopagos WHERE NumContrato = ".$NumContrato." and NumMov > ".$maxMov."";
                if ($Vivienda->query($sql1) == TRUE){  
                   // historia($nitavu, "SE ELIMINARON REGISTROS DE HISTORICO PAGOS QUE SE INSERTARON AL MOMENTO DE TRATAR DE CANCELAR, DEL NUMCONTRATO ".$NumContrato); 
                    mensaje('43. Ocurrio un error, favor de intentarlo nuevamente.','cancelarContrato.php');
                    //echo  '37. Ocurrio un error, favor de intentarlo nuevamente.';
                    return false;
                }else{
                   // historia($nitavu, "OCURRIO UN ERROR AL TRATAR DE ELIMINAR REGISTROS DE HISTORICO PAGOS QUE SE INSERTARON AL MOMENTO DE TRATAR DE CANCELAR DEL NUMCONTRATO ".$NumContrato); 
                    mensaje('44. Ocurrio un error, favor de intentarlo nuevamente.','cancelarContrato.php');
                    //echo  '38. Ocurrio un error, favor de intentarlo nuevamente.';
                    return false;
                }
            }
                
                  // INSERTAMOS EN DATOSCANCELACION
                  $sql = "Insert into datoscancelacion(NumContrato,TipoCancelacion,FolioDestino,IdProgramaDestino,IdDelegacionDestino,NumCancelacion,FechaCancelacion)
                  Values ('".$NumContrato."','".$opcion."','".$folionvo."','".$idprogramanvo."','".$iddelegacionnvo."','".$numcancelacion."',now())";
                  //echo $sql;
                  if ($Vivienda->query($sql) == TRUE){   
                      $res = 'TRUE';
                  }else{
                    $sql1 = 'CALL sp_EliminarRegistrosHPControlContratos("'.$NumContrato.'", "'.$maxMov.'", "'.$estatausCuentaControlContratos.'","'.$fechaultimamodControlContrato.'","'.$idempmodificaControlContrato.'")';
                    
                     if ($Vivienda->query($sql1) == TRUE){  
                        // historia($nitavu, "SE ELIMINARON REGISTROS DE HISTORICO PAGOS QUE SE INSERTARON AL MOMENTO DE TRATAR DE CANCELAR, DEL NUMCONTRATO ".$NumContrato); 
                         mensaje('45. Ocurrio un error, favor de intentarlo nuevamente.','cancelarContrato.php');
                         //echo  '41. Ocurrio un error, favor de intentarlo nuevamente.';
                         return false;
                     }else{
                        // historia($nitavu, "OCURRIO UN ERROR AL TRATAR DE ELIMINAR REGISTROS DE HISTORICO PAGOS QUE SE INSERTARON AL MOMENTO DE TRATAR DE CANCELAR DEL NUMCONTRATO ".$NumContrato); 
                         mensaje('46. Ocurrio un error, favor de intentarlo nuevamente.','cancelarContrato.php');
                         //echo  '42. Ocurrio un error, favor de intentarlo nuevamente.';
                         return false;
                     }
                 }

                 //SE CANCELA EN SOLICITUDES  
            $cancelado = cancelarSolicitud($idprograma,$iddelegacion,$folio,$observacionesCancelacion,$nitavu);
            //$cancelado=FALSE;
            if($cancelado==TRUE){
               
                // //BUSCAMOS DATOS EVALUACION
                $sql3 = 'SELECT * FROM datosevaluacion WHERE IdDelegacion='.$iddelegacion.' AND IdPrograma='.$idprograma.' AND  Folio='.$folio.'';
                //echo $sql3;
                $r3 = $Vivienda -> query($sql3);               
                $r_count3 = $r3 -> num_rows;
                if($r_count3 > 0){
                    while($f3 = $r3 -> fetch_array()) {
                        if ($f3['Aprobado'] = -1 And $f3['IdEmpEvaluador'] <> 0 And $f3['FechaEvaluacion'] <> ''){
                            $sql4 = "Update metas Set MontoAutorizado= (MontoAutorizado) - (".$f3['MontoCredito']."), AccionesAutorizadas= (AccionesAutorizadas) - (1) Where IdDelegacion=".$iddelegacion." and IdPrograma=".$idprograma."";
                            //echo $sql4;
                            if ($Vivienda->query($sql4) == TRUE){
                                $res = 'TRUE';                                                            
                            }else{
                                                               
                                    $sql1 = 'CALL sp_EliminarRegistrosHPControlContratosDatosCancelacionSolicitud("'.$NumContrato.'", "'.$maxMov.'", "'.$estatausCuentaControlContratos.'","'.$fechaultimamodControlContrato.'","'.$idempmodificaControlContrato.'","'.$iddelegacion.'","'.$idprograma.'","'.$folio.'")';
                                        echo $sql1;
                                    if ($Vivienda->query($sql1) == TRUE){  
                                    // historia($nitavu, "SE ELIMINARON REGISTROS DE HISTORICO PAGOS QUE SE INSERTARON AL MOMENTO DE TRATAR DE CANCELAR, DEL NUMCONTRATO ".$NumContrato); 
                                        mensaje('47. Ocurrio un error, favor de intentarlo nuevamente.','cancelarContrato.php');
                                        echo "<script>Console.log('Error 57');</script>";
                                        $res = 'FALSE';
                                     
                                    }else{
                                    // historia($nitavu, "OCURRIO UN ERROR AL TRATAR DE ELIMINAR REGISTROS DE HISTORICO PAGOS QUE SE INSERTARON AL MOMENTO DE TRATAR DE CANCELAR DEL NUMCONTRATO ".$NumContrato); 
                                        mensaje('48. Ocurrio un error, favor de intentarlo nuevamente.','cancelarContrato.php');
                                        echo "<script>Console.log('Error 58');</script>";
                                        $res = 'FALSE';
                                       
                                    }
    
                                                       
                            } 

                        }
                    }

                }
            }else //SI MARCA ERROR DESHACEMOS TODOS LO RESGISTROS QUE SE HAYAN INSERTARDO O MODIFICADO 
            {
                $sql1 = 'CALL sp_EliminarRegistrosHPControlContratosDatosCancelacion("'.$NumContrato.'", "'.$maxMov.'", "'.$estatausCuentaControlContratos.'","'.$fechaultimamodControlContrato.'","'.$idempmodificaControlContrato.'")';
                    
                if ($Vivienda->query($sql1) == TRUE){  
                   // historia($nitavu, "SE ELIMINARON REGISTROS DE HISTORICO PAGOS QUE SE INSERTARON AL MOMENTO DE TRATAR DE CANCELAR, DEL NUMCONTRATO ".$NumContrato); 
                    mensaje('49. Ocurrio un error, favor de intentarlo nuevamente.','cancelarContrato.php');
                    //echo  '41. Ocurrio un error, favor de intentarlo nuevamente.';
                    $res = 'FALSE';
                    //return false;
                }else{
                   // historia($nitavu, "OCURRIO UN ERROR AL TRATAR DE ELIMINAR REGISTROS DE HISTORICO PAGOS QUE SE INSERTARON AL MOMENTO DE TRATAR DE CANCELAR DEL NUMCONTRATO ".$NumContrato); 
                    mensaje('50. Ocurrio un error, favor de intentarlo nuevamente.','cancelarContrato.php');
                    //echo  '42. Ocurrio un error, favor de intentarlo nuevamente.';
                    $res = 'FALSE';
                    //return false;
                }
            }
    
    

        }
        ///****************************************************************************/¨
        if($opcion == '4'){

            //DATOS NECESARIOS PARA INSERTAR EL REGISTRO DE CANCELACION DE CONTRATO
            $nuevoRezMoratoriosUltimoMovCuenta=0;
            $nuevoRezFinancUltimoMovCuenta=0;
            $nuevoRezCapitalUltimoMovCuenta=0;
            $saldoCapitalCorrienteUltimoMovCuenta=0;
                
            $nuevoRezMoratoriosUltimoMovCuenta=obtenerNuevoRezMoratoriosUltimoMovCuenta($NumContrato,$maxMov);
            $nuevoRezFinancUltimoMovCuenta=obtenerNuevoRezFinancUltimoMovCuenta($NumContrato,$maxMov);
            $nuevoRezCapitalUltimoMovCuenta=obtenerNuevoRezCapitalUltimoMovCuenta($NumContrato,$maxMov);
            $saldoCapitalCorrienteUltimoMovCuenta = obtenerSaldoCapitalCorrienteUltimoMovCuenta($NumContrato,$maxMov);
            $fechaCorteUltimoMovCuenta=obtenerFechaCorteUltimoMovCuenta($NumContrato,$maxMov);


            //NUEVO REGISTRO QUE CONTIENE LOS DATOS DE EL OFICIO POR EL QUE SE CANCELO EL CONTRATO
            $sql = "insert into  historicopagos (numcontrato,nummov,montopagorecibido,fechaoperacion,saldocapitalcorriente,origen,tipomov,enviar, 
            fechacaptura,idempcrea,saldoexento,cancelado,origindata,Observaciones,IdSupervisor,RezMoratorios,NuevoRezMoratorios,RezFinanc,NuevoRezFinanc,RezCapital,NuevoRezCapital,FechaCorte) 
            values ( '".$NumContrato."','".$nuevoMov."', 0,  now(),'".$saldoCapitalCorrienteUltimoMovCuenta."','CAN',141 , 1, now(),'".$nitavu."','".$saldoExento."',0,'".$iddelegacion."','". $observacionesCancelacion."','".$maxMov."',
            '".$nuevoRezMoratoriosUltimoMovCuenta."','".$nuevoRezMoratoriosUltimoMovCuenta."','".$nuevoRezFinancUltimoMovCuenta."','".$nuevoRezFinancUltimoMovCuenta."','".$nuevoRezCapitalUltimoMovCuenta."','".$nuevoRezCapitalUltimoMovCuenta."','".$fechaCorteUltimoMovCuenta."')";
           // echo "<br>".$sql;            
                if ($Vivienda->query($sql) == TRUE){   
                        // historia($nitavu, "SE INSERTO REGISTRO EN HISTORICO PAGOS PARA CANCELAR EL CONTRATO ".$NumContrato." POR FINANCIAMIENTO "); 
                            $res = 'TRUE';
                            $nuevoMov = $nuevoMov + 1;
                }else{                       
                            //historia($nitavu, "SE ELIMINARON REGISTROS DE HISTORICO PAGOS QUE SE INSERTARON AL MOMENTO DE TRATAR DE CANCELAR, DEL NUMCONTRATO ".$NumContrato); 
                            mensaje('51. Ocurrio un error, favor de intentarlo nuevamente.','cancelarContrato.php');
                            //echo "1. Ocurrio un error, favor de intentarlo nuevamente.";
                            return true;
                } 


        //    // ECHO " ENTRO";
        //     $sql = "INSERT INTO  historicopagos (numcontrato,nummov, montopagorecibido,fechaoperacion,saldocapitalcorriente,origen,tipomov,enviar, 
        //     fechacaptura,idempcrea,capitalperiodocubierto,OriginData) values ('".$NumContrato."',".$nuevoMov.", ".$saldoCapitalCorriente.",now(), 0,'PCA', 27, 1, now(), ".$nitavu.",".$saldoCapitalCorriente.",".$iddelegacion.")";
        //     echo $sql;
        //     if ($Vivienda->query($sql) == TRUE){   
        //        // historia($nitavu, "SE INSERTO REGISTRO EN HISTORICO PAGOS PARA CANCELAR  EL CONTRATO ".$NumContrato." POR CANCELACION POR DEFUNCION");  
        //         $res = 'TRUE';
        //         $nuevoMov = $nuevoMov + 1;
        //     }else{
        //         mensaje('36. Ocurrio un error, favor de intentarlo nuevamente.','cancelarContrato.php');
        //         //echo  '36. Ocurrio un error, favor de intentarlo nuevamente.';
        //         return false;
        //     }



          
               //OBTENEMOS LOS DATOS QUE TIENE LA TABLA CONTRATOS PARA EN CASO DE QUE HAYA ERROR REGRESAR A LOS MISMOS VALORES
                $sql = "SELECT * from contratos WHERE NumContrato = " .$NumContrato. "";
                $r = $Vivienda -> query($sql); 
                $enviarContrato = "";
                $idempmodificaContrato = "";
                $fechaultimamodContrato = "";
                $fechacancelacionContrato = "";
                $CANCELADOContrato = "";
                $ObservacionesContrato = "";

                while($f = $r -> fetch_array()) {    
                    $enviarContrato = $f['Enviar'];
                    $idempmodificaContrato = $f['IdEmpModifica'];
                    $fechaultimamodContrato = $f['FechaUltimaMod'];
                    $fechacancelacionContrato = $f['fechacancelacion'];
                    $CANCELADOContrato = $f['Cancelado'];
                    $ObservacionesContrato = $f['Observaciones'];
                }
                 //CANCELEAMOS EL CONTRATO EN TABLA CONTRATOS. 
                $sql = "update contratos SET enviar=1, idempmodifica=" .$nitavu.",fechaultimamod=now(),fechacancelacion=NOW(),CANCELADO=1, Observaciones='".$observacionesCancelacion."' WHERE NumContrato = '" .$NumContrato. "'";
                //echo $sql;
                if ($Vivienda->query($sql) == TRUE){   
                    $res = 'TRUE';
                }else{
                    $res = 'FALSE';   
                    $sql = 'CALL sp_EliminarRegistrosHPcancelacion("'.$NumContrato.'", "'.$maxMov.'")';
                        if ($Vivienda->query($sql) == TRUE){  
                           // historia($nitavu, "SE ELIMINARON REGISTROS DE HISTORICO PAGOS QUE SE INSERTARON AL MOMENTO DE TRATAR DE CANCELAR, DEL NUMCONTRATO ".$NumContrato); 
                            mensaje('52. Ocurrio un error, favor de intentarlo nuevamente.','cancelarContrato.php');
                            return true;
                        }else{
                            //historia($nitavu, "OCURRIO UN ERROR AL TRATAR DE ELIMINAR REGISTROS DE HISTORICO PAGOS QUE SE INSERTARON AL MOMENTO DE TRATAR DE CANCELAR DEL NUMCONTRATO ".$NumContrato); 
                            mensaje('53. Ocurrio un error, favor de intentarlo nuevamente.','cancelarContrato.php');
                            return true; 
                        }
                   
                }
            
            //OBTENEMOS LOS DATOS QUE TIENE LA TABLA CONTROLCONTRATOS PARA EN CASO DE QUE HAYA ERROR REGRESAR A LOS MISMOS VALORES
            $sql = "SELECT * from controlcontratos WHERE NumContrato = " .$NumContrato. "";
            $r = $Vivienda -> query($sql); 
           
            $estatausCuentaControlContratos = "";
            $idempmodificaControlContrato = "";
            $fechaultimamodControlContrato = "";               

            while($f = $r -> fetch_array()) {                      
                $estatausCuentaControlContratos = $f['EstatusCuenta'];
                $idempmodificaControlContrato = $f['IdEmpModifica'];
                $fechaultimamodControlContrato = $f['FechaUltimaMod'];                   

            }  


             // ACTUALIZMOS CONTROL CONTRATOS
            $sql = "update controlcontratos set estatuscuenta=6,fechaultimamod=NOW(), enviar=1,IDEMPMODIFICA=" .$nitavu. " where numcontrato='".$NumContrato."'";;
            //echo $sql;
             if ($Vivienda->query($sql) == TRUE){   
                 $res = 'TRUE';
             }else{
                $sql1 = "DELETE from  historicopagos WHERE NumContrato = ".$NumContrato." and NumMov > ".$maxMov."";
                if ($Vivienda->query($sql1) == TRUE){  
                   // historia($nitavu, "SE ELIMINARON REGISTROS DE HISTORICO PAGOS QUE SE INSERTARON AL MOMENTO DE TRATAR DE CANCELAR, DEL NUMCONTRATO ".$NumContrato); 
                    mensaje('54. Ocurrio un error, favor de intentarlo nuevamente.','cancelarContrato.php');
                    //echo  '37. Ocurrio un error, favor de intentarlo nuevamente.';
                    return false;
                }else{
                   // historia($nitavu, "OCURRIO UN ERROR AL TRATAR DE ELIMINAR REGISTROS DE HISTORICO PAGOS QUE SE INSERTARON AL MOMENTO DE TRATAR DE CANCELAR DEL NUMCONTRATO ".$NumContrato); 
                    mensaje('55. Ocurrio un error, favor de intentarlo nuevamente.','cancelarContrato.php');
                    //echo  '38. Ocurrio un error, favor de intentarlo nuevamente.';
                    return false;
                }
            }
                
                  // INSERTAMOS EN DATOSCANCELACION
                  $sql = "Insert into datoscancelacion(NumContrato,TipoCancelacion,FolioDestino,IdProgramaDestino,IdDelegacionDestino,NumCancelacion,FechaCancelacion)
                  Values ('".$NumContrato."','".$opcion."','".$folionvo."','".$idprogramanvo."','".$iddelegacionnvo."','".$numcancelacion."',now())";
                  //echo $sql;
                  if ($Vivienda->query($sql) == TRUE){   
                      $res = 'TRUE';
                  }else{
                    $sql1 = 'CALL sp_EliminarRegistrosHPControlContratos("'.$NumContrato.'", "'.$maxMov.'", "'.$estatausCuentaControlContratos.'","'.$fechaultimamodControlContrato.'","'.$idempmodificaControlContrato.'")';
                    
                     if ($Vivienda->query($sql1) == TRUE){  
                        // historia($nitavu, "SE ELIMINARON REGISTROS DE HISTORICO PAGOS QUE SE INSERTARON AL MOMENTO DE TRATAR DE CANCELAR, DEL NUMCONTRATO ".$NumContrato); 
                         mensaje('56. Ocurrio un error, favor de intentarlo nuevamente.','cancelarContrato.php');
                         //echo  '41. Ocurrio un error, favor de intentarlo nuevamente.';
                         return false;
                     }else{
                        // historia($nitavu, "OCURRIO UN ERROR AL TRATAR DE ELIMINAR REGISTROS DE HISTORICO PAGOS QUE SE INSERTARON AL MOMENTO DE TRATAR DE CANCELAR DEL NUMCONTRATO ".$NumContrato); 
                         mensaje('57. Ocurrio un error, favor de intentarlo nuevamente.','cancelarContrato.php');
                         //echo  '42. Ocurrio un error, favor de intentarlo nuevamente.';
                         return false;
                     }
                 }

                 //SE CANCELA EN SOLICITUDES  
            $cancelado = cancelarSolicitud($idprograma,$iddelegacion,$folio,$observacionesCancelacion,$nitavu);
            //$cancelado=FALSE;
            if($cancelado==TRUE){
               
                // //BUSCAMOS DATOS EVALUACION
                $sql3 = 'SELECT * FROM datosevaluacion WHERE IdDelegacion='.$iddelegacion.' AND IdPrograma='.$idprograma.' AND  Folio='.$folio.'';
                //echo $sql3;
                $r3 = $Vivienda -> query($sql3);               
                $r_count3 = $r3 -> num_rows;
                if($r_count3 > 0){
                    while($f3 = $r3 -> fetch_array()) {
                        if ($f3['Aprobado'] = -1 And $f3['IdEmpEvaluador'] <> 0 And $f3['FechaEvaluacion'] <> ''){
                            $sql4 = "Update metas Set MontoAutorizado= (MontoAutorizado) - (".$f3['MontoCredito']."), AccionesAutorizadas= (AccionesAutorizadas) - (1) Where IdDelegacion=".$iddelegacion." and IdPrograma=".$idprograma."";
                            //echo $sql4;
                            if ($Vivienda->query($sql4) == TRUE){
                                $res = 'TRUE';                                                            
                            }else{                               
                                $sql1 = 'CALL sp_EliminarRegistrosHPControlContratosDatosCancelacionSolicitud("'.$NumContrato.'", "'.$maxMov.'", "'.$estatausCuentaControlContratos.'","'.$fechaultimamodControlContrato.'","'.$idempmodificaControlContrato.'","'.$iddelegacion.'","'.$idprograma.'","'.$folio.'")';
                            
                                if ($Vivienda->query($sql1) == TRUE){  
                                // historia($nitavu, "SE ELIMINARON REGISTROS DE HISTORICO PAGOS QUE SE INSERTARON AL MOMENTO DE TRATAR DE CANCELAR, DEL NUMCONTRATO ".$NumContrato); 
                                    mensaje('58. Ocurrio un error, favor de intentarlo nuevamente.','cancelarContrato.php');
                                    //echo  '52. Ocurrio un error, favor de intentarlo nuevamente.';
                                    $res = 'FALSE';
                                 
                                }else{
                                // historia($nitavu, "OCURRIO UN ERROR AL TRATAR DE ELIMINAR REGISTROS DE HISTORICO PAGOS QUE SE INSERTARON AL MOMENTO DE TRATAR DE CANCELAR DEL NUMCONTRATO ".$NumContrato); 
                                    mensaje('59. Ocurrio un error, favor de intentarlo nuevamente.','cancelarContrato.php');
                                  
                                    $res = 'FALSE';
                                   
                                }

                            }
                    }

                }
            }
            }else //SI MARCA ERROR DESHACEMOS TODOS LO RESGISTROS QUE SE HAYAN INSERTARDO O MODIFICADO 
            {
                $sql1 = 'CALL sp_EliminarRegistrosHPControlContratosDatosCancelacion("'.$NumContrato.'", "'.$maxMov.'", "'.$estatausCuentaControlContratos.'","'.$fechaultimamodControlContrato.'","'.$idempmodificaControlContrato.'")';
                    
                if ($Vivienda->query($sql1) == TRUE){  
                   // historia($nitavu, "SE ELIMINARON REGISTROS DE HISTORICO PAGOS QUE SE INSERTARON AL MOMENTO DE TRATAR DE CANCELAR, DEL NUMCONTRATO ".$NumContrato); 
                    mensaje('60. Ocurrio un error, favor de intentarlo nuevamente.','cancelarContrato.php');
                    //echo  '41. Ocurrio un error, favor de intentarlo nuevamente.';
                    $res = 'FALSE';
                    //return false;
                }else{
                   // historia($nitavu, "OCURRIO UN ERROR AL TRATAR DE ELIMINAR REGISTROS DE HISTORICO PAGOS QUE SE INSERTARON AL MOMENTO DE TRATAR DE CANCELAR DEL NUMCONTRATO ".$NumContrato); 
                    mensaje('61. Ocurrio un error, favor de intentarlo nuevamente.','cancelarContrato.php');
                    //echo  '42. Ocurrio un error, favor de intentarlo nuevamente.';
                    $res = 'FALSE';
                    //return false;
                }
            }
    
    

        }
        
        

        if($res == 'TRUE'){
            mensaje('Se ha cancelado el contrato con éxito', 'cancelarContrato.php');
        }else{
            mensaje('Hubo un error al momento de cancelar el contrato, favor de intentarlo de nuevo.', 'cancelarContrato.php');
            //echo '39. Ocurrio un error, favor de intentarlo nuevamente.';
        }
        
        //EXACRTAMENTE NO SE DONDE SE USE, NO HAY OPCION 4 SEGUN YO.
        /*if($opcion == '4'){
            $ATransferir = (($Pagos - $cargoAdmin) - $DescuentoMorat);
            if(rstAlContratoSaldo($NumContrato) > $ATransferir){
                $vContrato = $NumContrato;
                $Vfecha = now();
                $vCveCargo = 19
            }else{
                echo 'No existe saldo suficiente en la cuenta para tranferir el monto del contrato a cancelar';
            }
        }*/


       


?>
