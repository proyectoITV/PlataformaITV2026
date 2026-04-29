<?php
require_once("config.php");
require_once("lib/funciones.php");
require_once("lib/flor_funciones.php");
require_once("lib/yes_funciones.php");

$NumContrato = $_POST['NumContrato'];
$IdDelegacion = $_POST['IdDelegacion'];
$RezGts = (float)$_POST['RezGts'];
$Rezago_seguros = (float)$_POST['Rezago_seguros'];
$Rezago_otros_conceptos = (float)$_POST['Rezago_otros_conceptos'];
$RezMoratorios = (float)$_POST['RezMoratorios'];
$RezFinanc = (float)$_POST['RezFinanc'];
$RezCapital = (float)$_POST['RezCapital'];
$nitavu = $_POST['nitavu'];
$IdPrograma = $_POST['IdPrograma'];
$Folio = $_POST['Folio'];
//$fechaSuperior =  $_POST['fecha'];
$fechaSuperior = FechaProximoCorteControlContratos($NumContrato);
$ultimoMov = obtenerMovimientoConsecutivo($NumContrato);

$nuevoMov = $ultimoMov + 1;

$date=date_create($fechaSuperior);
$fecha_inferior= $fechaSuperior;

$fechaSuperior = SiguienteFecha($NumContrato,$fechaSuperior);

//echo 'Fecha Superior'.$fechaSuperior;
//echo 'Fecha Inferior'.$fecha_inferior;
if($fechaSuperior == 'FALSE'){
    mensaje('Imposible continuar, esta cuenta no tiene una fecha emisión de su contrato','caja.php?IdDelegacion=6&IdPrograma=78&NumContrato=06784106047&Folio=16539&OriginData=6');
}

$fechaSuperiorCamp = $fechaSuperior;
//echo $fechaSuperior;

$SaldoCapitalCorrienteAnt = (float)UltimoSaldoDelContrato($NumContrato);
//echo $SaldoCapitalCorrienteAnt;

if($SaldoCapitalCorrienteAnt > 0){
    $OrigenDeEnvio = $IdDelegacion;
   
    //CALCULO DE FINANCIAMIENTO
    $tasaAnualFin = TasaAnualFinContrato($NumContrato); 
    if( $tasaAnualFin <> 0 ){
        $Tasa_financiamiento = $tasaAnualFin / 100 / varPeriodosXAño($NumContrato);  // 10% anual = 0.83% mensual
        $NuevoFinancPeriodo = $SaldoCapitalCorrienteAnt * $Tasa_financiamiento;
        $$NuevoFinancPeriodo = number_format($NuevoFinancPeriodo,"2",".",",");
    }
    //CALCULAR CAPITAL DEL PROXIMO periodo
    $MontoPago = MontoPagoContratos($NumContrato);
    if($MontoPago > $SaldoCapitalCorrienteAnt + $NuevoFinancPeriodo ){
        $NuevoCapitalPeriodo = $SaldoCapitalCorrienteAnt;
        $NuevoCapitalPeriodo = number_format($NuevoCapitalPeriodo,"2",".",",");
    }else{
        $NuevoCapitalPeriodo = $MontoPago - $NuevoFinancPeriodo;
        $NuevoCapitalPeriodo = number_format($NuevoCapitalPeriodo,"2",".",",");
    }

    //CALCULO DE GASTOS DE ADMINISTRACION
    $PGtsAdmon = PGtsAdmonContratos($NumContrato);
    $NuevoGtsPeriodo = (($PGtsAdmon / 100) * $MontoPago);  // monto de los gastos y comisiones extras del periodo
    $NuevoGtsPeriodo = number_format($NuevoGtsPeriodo,"2",".",",");
    $factormoneda = obtenerfactorconversion(TipoMonedaPorNumContrato($NumContrato), $fechaSuperior);
    $NuevoSegPeriodo = (SegurodeVidaContratos($NumContrato) / $factormoneda);
    $NuevoSegPeriodo = number_format($NuevoSegPeriodo,"2",".",",");
    $NuevoOtrosGtsPeriodo = (OtroCargoContratos($NumContrato) / $factormoneda);
    $NuevoOtrosGtsPeriodo = number_format($NuevoOtrosGtsPeriodo,"2",".",",");

    //damos formato a la fecha superior para poder ingresarlo ala bd
    $fechaSuperior = date_format(date_create($fechaSuperior),"Y-m-d H:i:s");

  
    //DECLARAMOS UN ARRAY PARA GUARDAR LOS NUMEROS DE MOVIMIENTO QUE SE HAYAN GUARDADO A PARTIR DE INICIAR ESTE PROCESO
    $articulos = array();
    //SE GENERAN LOS CARGOS CORRESPONDIENTES AL PROXIMO periodo//
    if($SaldoCapitalCorrienteAnt >= 0 ){
        
        $Excedente_capital = 0;
            
        //el monto del pago recibido es cero porque se trata de un registro de apertura de periodo
        $Pago_recibido_periodo = 0;
        if ($fecha_inferior == ""){
            $FechaOperacion = Null;
        }else{
            $FechaOperacion = date_format(date_create($fecha_inferior),"Y-m-d H:i:s");
            //$FechaOperacion = $fecha_inferior; // fecha de arranque del periodo
        }
            
        /*echo 'rezcapital '.$RezCapital;
        echo 'nuevocapitalperiodo '.$NuevoCapitalPeriodo;
        echo 'saldocapitalcorriente '.$SaldoCapitalCorrienteAnt ;
        echo '<br> '.$RezGts;
        echo '<br> '.$Rezago_seguros ;
        echo '<br> '.$Rezago_otros_conceptos ;
        echo '<br> '.$RezMoratorios;
        echo '<br> '.$RezFinanc ;
        echo '<br> '.$RezCapital;
        echo 'nuevo capital periodo'. $NuevoCapitalPeriodo;*/
        
        

       //*/*/*/*/*/*/*/*/*/*/*//
       //*/*/  C A P I T A L *//
       //*/*/*/*/*/*/*/*/*/*/*//
       if ($NuevoCapitalPeriodo > 0){
       
           $RezCapitalmasNuevoCapital = (float)$RezCapital + (float)$NuevoCapitalPeriodo;
           $SaldoCapitalCorrientemenosNuevoCapital = (float)$SaldoCapitalCorrienteAnt - (float)$NuevoCapitalPeriodo;
           //prepararse para grabar la info del registro de historico de pagos
           $sql="INSERT INTO  historicopagos 
           ( NumContrato 
           , NumMov 
           , MontoPagoRecibido 
           , FechaOperacion 
           , FechaCorte 
           , FechaInicia 
           , FechaTermina 
           , RezGts 
           , RezGtsCubierto 
           , GtsPeriodo 
           , GtsPeriodoCubiertos 
           , NuevoRezGts 
           , RezSeg 
           , RezSegCubierto 
           , SegPeriodo 
           , SegPeriodoCubierto 
           , NuevoRezSeg 
           , RezOtrosGts 
           , RezOtrosGtsCubierto 
           , OtrosGtsPeriodo 
           , OtrosGtsPeriodoCubierto 
           , NuevoRezOtrosGts 
           , RezMoratorios 
           , RezMoratoriosCubierto 
           , MoratoriosPeriodo 
           , NuevoRezMoratorios 
           , RezFinanc 
           , RezFinancCubierto 
           , FinancPeriodo 
           , FinancPeriodoCubierto 
           , NuevoRezFinanc 
           , RezCapital 
           , RezCapitalCubierto 
           , CapitalPeriodo 
           , CapitalPeriodoCubierto 
           , NuevoRezCapital 
           , AplicadoExcedente 
           , SaldoCapitalCorriente 
           , Origen 
           , TipoMov 
           , Enviar 
           , FechaCaptura 
           , FechaEnvio 
           , FechaUltimaMod 
           , IdEmpCrea 
           , IdEmpModifica 
           , Observaciones 
           , saldoexento 
           , IdMovDesc 
           , ReferenciaOpd 
           , RefBancariaOpd 
           , Observacion2 
           , IdFormaPago 
           , IdSupervisor 
           , ImpSF002 
           , FechaImpSF002 
           , FechaReimSF002 
           , OrigenDeEnvio 
           , Cancelado 
           , NumMovErroneo
           , OriginData )
   VALUES
           (".$NumContrato."
           , ".$nuevoMov."
           , 0 
           , '".$FechaOperacion."'
           , '".$fechaSuperior."'
           , ''
           , ''
           , ".$RezGts."
           , 0
           , 0
           , 0
           , ".$RezGts."
           , ".$Rezago_seguros."
           , 0
           , 0
           , 0
           , ".$Rezago_seguros."
           , ".$Rezago_otros_conceptos."
           , 0
           , 0
           , 0
           , ".$Rezago_otros_conceptos."
           , ".$RezMoratorios."
           , 0
           , 0
           , ".$RezMoratorios."
           , ".$RezFinanc."
           , 0
           , 0
           , 0
           , ".$RezFinanc."
           , ".$RezCapital."
           , 0
           , ".$NuevoCapitalPeriodo."
           , 0 
           , (".$RezCapitalmasNuevoCapital.")
           , 0
           , (".$SaldoCapitalCorrientemenosNuevoCapital.")
           , 'PCU'
           , 14
           , 1
           , ''
           , ''
           , NOW()
           , ".$nitavu."
           , ''
           , ''
           , ''
           , ''
           , '' 
           , ''
           , '' 
           , ''
           , ''
           , ''
           , ''
           , ''
           , ".$OrigenDeEnvio."
           , 0
           , ''
           ,".$OrigenDeEnvio.")";

          
           // echo $sql;
           if ($Vivienda->query($sql) == TRUE){   
               //SI SE GUARDO ESTE INSERT GUARDAMOS EL NUMERO DE MOVIMIENTO CON EL CUAL SE CREO EN EL ARRAY 
               $articulos[] = $nuevoMov;
               $res = 'TRUE';
               $nuevoMov = $nuevoMov + 1;
           }else{
               
                $res = 'FALSE';
                //mensaje('1.Ocurrio un error, favor de intentarlo nuevamente.','caja.php?IdDelegacion='.$IdDelegacion.'&IdPrograma='.$IdPrograma.'&NumContrato='.$NumContrato.'&Folio='.$Folio.'&OriginData='.$IdDelegacion.'');
            }
                               

       
       }

       
       //*/*/*/*/*/*/*/*/*/*/*/
       //*/*/  FINANCIAMIENTO*/
       //*/*/*/*/*/*/*/*/*/*/*/
   
       if($NuevoFinancPeriodo > 0){
        $RezFinancmasNuevoFinancPeriodo = (float)$RezFinanc + (float)$NuevoFinancPeriodo;
        $RezCapitalmasNuevoCapitalPeriodo = (float)$RezCapital + (float)$NuevoCapitalPeriodo;
        $RezCapitalmasNuevoCapitalPeriodo = (float)$RezCapital + (float)$NuevoCapitalPeriodo;
        $SaldoCapitalCorrienteAntmenosNuevoCapitalPeriodo = (float)$SaldoCapitalCorrienteAnt - (float)$NuevoCapitalPeriodo;
           //prepararse para grabar la info del registro de historico de pagos
           $sql="INSERT INTO  historicopagos 
           ( NumContrato 
           , NumMov 
           , MontoPagoRecibido 
           , FechaOperacion 
           , FechaCorte 
           , FechaInicia 
           , FechaTermina 
           , RezGts 
           , RezGtsCubierto 
           , GtsPeriodo 
           , GtsPeriodoCubiertos 
           , NuevoRezGts 
           , RezSeg 
           , RezSegCubierto 
           , SegPeriodo 
           , SegPeriodoCubierto 
           , NuevoRezSeg 
           , RezOtrosGts 
           , RezOtrosGtsCubierto 
           , OtrosGtsPeriodo 
           , OtrosGtsPeriodoCubierto 
           , NuevoRezOtrosGts 
           , RezMoratorios 
           , RezMoratoriosCubierto 
           , MoratoriosPeriodo 
           , NuevoRezMoratorios 
           , RezFinanc 
           , RezFinancCubierto 
           , FinancPeriodo 
           , FinancPeriodoCubierto 
           , NuevoRezFinanc 
           , RezCapital 
           , RezCapitalCubierto 
           , CapitalPeriodo 
           , CapitalPeriodoCubierto 
           , NuevoRezCapital 
           , AplicadoExcedente 
           , SaldoCapitalCorriente 
           , Origen 
           , TipoMov 
           , Enviar 
           , FechaCaptura 
           , FechaEnvio 
           , FechaUltimaMod 
           , IdEmpCrea 
           , IdEmpModifica 
           , Observaciones 
           , saldoexento 
           , IdMovDesc 
           , ReferenciaOpd 
           , RefBancariaOpd 
           , Observacion2 
           , IdFormaPago 
           , IdSupervisor 
           , ImpSF002 
           , FechaImpSF002 
           , FechaReimSF002 
           , OrigenDeEnvio 
           , Cancelado 
           , NumMovErroneo
           , OriginData )
   VALUES
           ('".$NumContrato."'
           , ".$nuevoMov."
           , 0
           , '".$FechaOperacion."'
           , '".$fechaSuperior."'
           , ''
           , ''
           , ".$RezGts."
           , 0
           , 0
           , 0
           , ".$RezGts."
           , ".$Rezago_seguros."
           , 0
           , 0
           , 0
           , ".$Rezago_seguros."
           , ".$Rezago_otros_conceptos."
           , 0
           , 0
           , 0
           , ".$Rezago_otros_conceptos."
           , ".$RezMoratorios."
           , 0
           , 0
           , ".$RezMoratorios."
           , ".$RezFinanc."
           , 0
           , ".$NuevoFinancPeriodo."
           , 0
           , (".$RezFinancmasNuevoFinancPeriodo.")
           , (".$RezCapitalmasNuevoCapitalPeriodo.")
           , 0
           , 0
           , 0
           , (".$RezCapitalmasNuevoCapitalPeriodo.")
           , 0
           , (".$SaldoCapitalCorrienteAntmenosNuevoCapitalPeriodo.")
           , 'PCU'
           , 6
           , 1
           , ''
           , ''
           , NOW()
           , ".$nitavu."
           , ''
           , ''
           , ''
           , ''
           , ''
           , ''
           , '' 
           , ''
           , ''
           , ''
           , ''
           , ''
           , ".$OrigenDeEnvio." 
           , 0
           , ''
           ,".$OrigenDeEnvio.")";
       
           //echo $sql;
           if ($Vivienda->query($sql) == TRUE){   
                //SI SE GUARDO ESTE INSERT GUARDAMOS EL NUMERO DE MOVIMIENTO CON EL CUAL SE CREO EN EL ARRAY 
                $articulos[] = $nuevoMov;   
                $res = 'TRUE';
               $nuevoMov = $nuevoMov + 1;
           }else
           {
                $res = 'FALSE';    
                //mensaje('2.Ocurrio un error, favor de intentarlo nuevamente.','caja.php?IdDelegacion='.$IdDelegacion.'&IdPrograma='.$IdPrograma.'&NumContrato='.$NumContrato.'&Folio='.$Folio.'&OriginData='.$IdDelegacion.'');

           }
       
       }


       //*/*/*/*/*/*/*/*/*/*/*/
       //*/*/  COMISIONES    */
       //*/*/*/*/*/*/*/*/*/*/*/
   
       if($NuevoGtsPeriodo > 0 ){
        $RezGtsmasNuevoGtsPeriodo = (float)$RezGts + (float)$NuevoGtsPeriodo;
        $RezFinancmasNuevoFinancPeriodo = (float)$RezFinanc + (float)$NuevoFinancPeriodo;
        $RezCapitalmasNuevoCapitalPeriodo = (float)$RezCapital + (float)$NuevoCapitalPeriodo;
        $SaldoCapitalCorrienteAntmenosNuevoCapitalPeriodo = (float)$SaldoCapitalCorrienteAnt - (float)$NuevoCapitalPeriodo;
       
           //prepararse para grabar la info del registro de historico de pagos
           $sql="INSERT INTO  historicopagos 
           ( NumContrato 
           , NumMov 
           , MontoPagoRecibido 
           , FechaOperacion 
           , FechaCorte 
           , FechaInicia 
           , FechaTermina 
           , RezGts 
           , RezGtsCubierto 
           , GtsPeriodo 
           , GtsPeriodoCubiertos 
           , NuevoRezGts 
           , RezSeg 
           , RezSegCubierto 
           , SegPeriodo 
           , SegPeriodoCubierto 
           , NuevoRezSeg 
           , RezOtrosGts 
           , RezOtrosGtsCubierto 
           , OtrosGtsPeriodo 
           , OtrosGtsPeriodoCubierto 
           , NuevoRezOtrosGts 
           , RezMoratorios 
           , RezMoratoriosCubierto 
           , MoratoriosPeriodo 
           , NuevoRezMoratorios 
           , RezFinanc 
           , RezFinancCubierto 
           , FinancPeriodo 
           , FinancPeriodoCubierto 
           , NuevoRezFinanc 
           , RezCapital 
           , RezCapitalCubierto 
           , CapitalPeriodo 
           , CapitalPeriodoCubierto 
           , NuevoRezCapital 
           , AplicadoExcedente 
           , SaldoCapitalCorriente 
           , Origen 
           , TipoMov 
           , Enviar 
           , FechaCaptura 
           , FechaEnvio 
           , FechaUltimaMod 
           , IdEmpCrea 
           , IdEmpModifica 
           , Observaciones 
           , saldoexento 
           , IdMovDesc 
           , ReferenciaOpd 
           , RefBancariaOpd 
           , Observacion2 
           , IdFormaPago 
           , IdSupervisor 
           , ImpSF002 
           , FechaImpSF002 
           , FechaReimSF002 
           , OrigenDeEnvio 
           , Cancelado 
           , NumMovErroneo
           , OriginData )
   VALUES
           (".$NumContrato."
           , ".$nuevoMov."
           , 0
           , '".$FechaOperacion."'
           , '".$fechaSuperior."'
           , ''
           , ''
           , ".$RezGts."
           , 0
           , ".$NuevoGtsPeriodo."
           , 0
           , (".$RezGtsmasNuevoGtsPeriodo.")
           , ".$Rezago_seguros."
           , 0
           , 0
           , 0
           , ".$Rezago_seguros."
           , ".$Rezago_otros_conceptos."
           , 0
           , 0
           , 0
           , ".$Rezago_otros_conceptos."
           , ".$RezMoratorios."
           , 0
           , 0
           , ".$RezMoratorios."
           , (".$RezFinancmasNuevoFinancPeriodo.")
           , 0
           , 0
           , 0
           , (".$RezFinancmasNuevoFinancPeriodo.")
           , (".$RezCapitalmasNuevoCapitalPeriodo.")
           , 0
           , 0
           , 0
           , (".$RezCapitalmasNuevoCapitalPeriodo.")
           , 0
           , (".$SaldoCapitalCorrienteAntmenosNuevoCapitalPeriodo.")
           , 'PCU'
           , 15
           , 1
           , ''
           , ''
           , NOW()
           , ".$nitavu."
           , ''
           , ''
           , ''
           , ''
           , ''
           , ''
           , '' 
           , ''
           , ''
           , ''
           , ''
           , ''
           , ".$OrigenDeEnvio." 
           , 0
           , ''
           ,".$OrigenDeEnvio.")";
           //echo $sql;

           
           if ($Vivienda->query($sql) == TRUE){   
               //SI SE GUARDO ESTE INSERT GUARDAMOS EL NUMERO DE MOVIMIENTO CON EL CUAL SE CREO EN EL ARRAY 
               $articulos[] = $nuevoMov;
               $res = 'TRUE';
               $nuevoMov = $nuevoMov + 1;
           }else
           {
                $res = 'FALSE';
                //mensaje('3.Ocurrio un error, favor de intentarlo nuevamente.','caja.php?IdDelegacion='.$IdDelegacion.'&IdPrograma='.$IdPrograma.'&NumContrato='.$NumContrato.'&Folio='.$Folio.'&OriginData='.$IdDelegacion.'');

           }
       
       }

       //*/*/*/*/*/*/*/*/*/*/*/
       //*/*/  SEGUROS       */
       //*/*/*/*/*/*/*/*/*/*/*/
       if($NuevoSegPeriodo > 0){
        $RezGtsmasNuevoGtsPeriodo = (float)$RezGts + (float)$NuevoGtsPeriodo;
        $Rezago_segurosmasNuevoSegPeriodo = (float)$Rezago_seguros + (float)$NuevoSegPeriodo;
        $RezFinancmasNuevoFinancPeriodo = (float)$RezFinanc + (float)$NuevoFinancPeriodo;
        $RezCapitalmasNuevoCapitalPeriodo = (float)$RezCapital + (float)$NuevoCapitalPeriodo;
        $SaldoCapitalCorrienteAntmenosNuevoCapitalPeriodo = (float)$SaldoCapitalCorrienteAnt - (float)$NuevoCapitalPeriodo;
           //prepararse para grabar la info del registro de historico de pagos
           $sql = "INSERT INTO  historicopagos 
           ( NumContrato 
           , NumMov 
           , MontoPagoRecibido 
           , FechaOperacion 
           , FechaCorte 
           , FechaInicia 
           , FechaTermina 
           , RezGts 
           , RezGtsCubierto 
           , GtsPeriodo 
           , GtsPeriodoCubiertos 
           , NuevoRezGts 
           , RezSeg 
           , RezSegCubierto 
           , SegPeriodo 
           , SegPeriodoCubierto 
           , NuevoRezSeg 
           , RezOtrosGts 
           , RezOtrosGtsCubierto 
           , OtrosGtsPeriodo 
           , OtrosGtsPeriodoCubierto 
           , NuevoRezOtrosGts 
           , RezMoratorios 
           , RezMoratoriosCubierto 
           , MoratoriosPeriodo 
           , NuevoRezMoratorios 
           , RezFinanc 
           , RezFinancCubierto 
           , FinancPeriodo 
           , FinancPeriodoCubierto 
           , NuevoRezFinanc 
           , RezCapital 
           , RezCapitalCubierto 
           , CapitalPeriodo 
           , CapitalPeriodoCubierto 
           , NuevoRezCapital 
           , AplicadoExcedente 
           , SaldoCapitalCorriente 
           , Origen 
           , TipoMov 
           , Enviar 
           , FechaCaptura 
           , FechaEnvio 
           , FechaUltimaMod 
           , IdEmpCrea 
           , IdEmpModifica 
           , Observaciones 
           , saldoexento 
           , IdMovDesc 
           , ReferenciaOpd 
           , RefBancariaOpd 
           , Observacion2 
           , IdFormaPago 
           , IdSupervisor 
           , ImpSF002 
           , FechaImpSF002 
           , FechaReimSF002 
           , OrigenDeEnvio 
           , Cancelado 
           , NumMovErroneo
           , OriginData )
   VALUES
           (".$NumContrato."
           , ".$nuevoMov."
           , 0 
           , '".$FechaOperacion."'
           , '".$fechaSuperior."'
           , ''
           , ''
           , (".$RezGtsmasNuevoGtsPeriodo.")
           , 0
           , 0
           , 0
           , (".$RezGtsmasNuevoGtsPeriodo.")
           , ".$Rezago_seguros."
           , 0
           , ".$NuevoSegPeriodo."
           , 0
           , (".$Rezago_segurosmasNuevoSegPeriodo.")
           , ".$Rezago_otros_conceptos."
           , 0
           , 0
           , 0
           , ".$Rezago_otros_conceptos."
           , ".$RezMoratorios."
           , 0
           , 0
           , ".$RezMoratorios."
           , (".$RezFinancmasNuevoFinancPeriodo.")
           , 0
           , 0
           , 0
           , (".$RezFinancmasNuevoFinancPeriodo.")
           , (".$RezCapitalmasNuevoCapitalPeriodo.")
           , 0
           , 0
           , 0
           , (".$RezCapitalmasNuevoCapitalPeriodo.")
           , 0
           , (".$SaldoCapitalCorrienteAntmenosNuevoCapitalPeriodo.")
           , 'PCU'
           , 16
           , 1
           , ''
           , ''
           , NOW()
           , ".$nitavu."
           , ''
           , ''
           , ''
           , ''
           , ''
           , ''
           , '' 
           , ''
           , ''
           , ''
           , ''
           , ''
           , ".$OrigenDeEnvio."
           , 0
           , ''
           ,".$OrigenDeEnvio.")";
           //echo $sql;

           
           if ($Vivienda->query($sql) == TRUE){   
                //SI SE GUARDO ESTE INSERT GUARDAMOS EL NUMERO DE MOVIMIENTO CON EL CUAL SE CREO EN EL ARRAY 
                $articulos[] = $nuevoMov;   
                $res = 'TRUE';
               $nuevoMov = $nuevoMov + 1;
           }else
           {
                $res = 'FALSE';
                //mensaje('4.Ocurrio un error, favor de intentarlo nuevamente.','caja.php?IdDelegacion='.$IdDelegacion.'&IdPrograma='.$IdPrograma.'&NumContrato='.$NumContrato.'&Folio='.$Folio.'&OriginData='.$IdDelegacion.'');
            }
                       
       }

       //*/*/*/*/*/*/*/*/*/*/*/
       //*/*/  OTROS_GASTOS  */
       //*/*/*/*/*/*/*/*/*/*/*/
                   
       if($NuevoOtrosGtsPeriodo > 0){
        $RezGtsmasNuevoGtsPeriodo = (float)$RezGts + (float)$NuevoGtsPeriodo;
        $Rezago_segurosmasNuevoSegPeriodo = (float)$Rezago_seguros + (float)$NuevoSegPeriodo;
        $Rezago_otros_conceptosmasNuevoOtrosGtsPeriodo = (float)$Rezago_otros_conceptos + (float)$NuevoOtrosGtsPeriodo;
        $RezFinancmasNuevoFinancPeriodo = (float)$RezFinanc + (float)$NuevoFinancPeriodo;
        $RezCapitalmasNuevoCapitalPeriodo = (float)$RezCapital + (float)$NuevoCapitalPeriodo;
        $SaldoCapitalCorrienteAntmenosNuevoCapitalPeriodo = (float)$SaldoCapitalCorrienteAnt - (float)$NuevoCapitalPeriodo;
           //prepararse para grabar la info del registro de historico de pagos
           $sql = "INSERT INTO  historicopagos 
           ( NumContrato 
           , NumMov 
           , MontoPagoRecibido 
           , FechaOperacion 
           , FechaCorte 
           , FechaInicia 
           , FechaTermina 
           , RezGts 
           , RezGtsCubierto 
           , GtsPeriodo 
           , GtsPeriodoCubiertos 
           , NuevoRezGts 
           , RezSeg 
           , RezSegCubierto 
           , SegPeriodo 
           , SegPeriodoCubierto 
           , NuevoRezSeg 
           , RezOtrosGts 
           , RezOtrosGtsCubierto 
           , OtrosGtsPeriodo 
           , OtrosGtsPeriodoCubierto 
           , NuevoRezOtrosGts 
           , RezMoratorios 
           , RezMoratoriosCubierto 
           , MoratoriosPeriodo 
           , NuevoRezMoratorios 
           , RezFinanc 
           , RezFinancCubierto 
           , FinancPeriodo 
           , FinancPeriodoCubierto 
           , NuevoRezFinanc 
           , RezCapital 
           , RezCapitalCubierto 
           , CapitalPeriodo 
           , CapitalPeriodoCubierto 
           , NuevoRezCapital 
           , AplicadoExcedente 
           , SaldoCapitalCorriente 
           , Origen 
           , TipoMov 
           , Enviar 
           , FechaCaptura 
           , FechaEnvio 
           , FechaUltimaMod 
           , IdEmpCrea 
           , IdEmpModifica 
           , Observaciones 
           , saldoexento 
           , IdMovDesc 
           , ReferenciaOpd 
           , RefBancariaOpd 
           , Observacion2 
           , IdFormaPago 
           , IdSupervisor 
           , ImpSF002 
           , FechaImpSF002 
           , FechaReimSF002 
           , OrigenDeEnvio 
           , Cancelado 
           , NumMovErroneo
           , OriginData )
   VALUES
           (".$NumContrato."
           , ".$nuevoMov."
           , 0 
           , '".$FechaOperacion."'
           , '".$fechaSuperior."'
           , ''
           , ''
           , (".$RezGtsmasNuevoGtsPeriodo.")
           , 0
           , 0
           , 0
           , (".$RezGtsmasNuevoGtsPeriodo.")
           , (".$Rezago_segurosmasNuevoSegPeriodo.")
           , 0
           , 0
           , 0
           , (".$Rezago_segurosmasNuevoSegPeriodo.")
           , ".$Rezago_otros_conceptos."
           , 0
           , ".$NuevoOtrosGtsPeriodo."
           , 0
           , (".$Rezago_otros_conceptosmasNuevoOtrosGtsPeriodo.")
           , ".$RezMoratorios."
           , 0
           , 0
           , ".$RezMoratorios."
           , (".$RezFinancmasNuevoFinancPeriodo.")
           , 0
           , 0
           , 0
           , (".$RezFinancmasNuevoFinancPeriodo.")
           , (".$RezCapitalmasNuevoCapitalPeriodo.")
           , 0
           , 0
           , 0 
           , (".$RezCapitalmasNuevoCapitalPeriodo.")
           , 0
           , (".$SaldoCapitalCorrienteAntmenosNuevoCapitalPeriodo.")
           , 'PCU'
           , 17
           , 1
           , ''
           , ''
           , NOW()
           , ".$nitavu."
           , ''
           , ''
           , ''
           , ''
           , ''
           , ''
           , '' 
           , ''
           , ''
           , ''
           , ''
           , ''
           , ".$OrigenDeEnvio." 
           , 0
           , ''
           ,".$OrigenDeEnvio." )";
       //echo $sql;

           
       if ($Vivienda->query($sql) == TRUE){   
           //SI SE GUARDO ESTE INSERT GUARDAMOS EL NUMERO DE MOVIMIENTO CON EL CUAL SE CREO EN EL ARRAY 
           $articulos[] = $nuevoMov;
            $res = 'TRUE';
           $nuevoMov = $nuevoMov + 1;
       }else
       {
            $res = 'FALSE';
           //mensaje('5.Ocurrio un error, favor de intentarlo nuevamente.','caja.php?IdDelegacion='.$IdDelegacion.'&IdPrograma='.$IdPrograma.'&NumContrato='.$NumContrato.'&Folio='.$Folio.'&OriginData='.$IdDelegacion.'');

       }
       
       }
   }

    if($res == 'TRUE'){

        //Actualizar la informacion en controlcontratos respecto a las fechas de corte          
        $sql = 'UPDATE controlcontratos SET enviar = 1, FechaCorteAnterior = "'.$fecha_inferior.'", FechaProximoCorte ="'.$fechaSuperior.'", idempmodifica = "'.$nitavu.'", fechaultimamod = NOW() where NumContrato = "'.$NumContrato. '" ';
        //echo 'actualiza'.$sql;
        if ($Vivienda->query($sql) == TRUE){   
            mensaje('Se ha cerrado el periodo con éxito.','caja.php?IdDelegacion='.$IdDelegacion.'&IdPrograma='.$IdPrograma.'&NumContrato='.$NumContrato.'&Folio='.$Folio.'&OriginData='.$IdDelegacion.'');
        }else{
             //SI EXISTIO UN ERROR AL ACTUALIZAR LA TABLA CONTROL CONTRATOS, VAMOS A ELIMINAR TODOS LOS REGISTROS QUE SE INSERTARON EN LA TABLA HISTORICO PAGOS EN LOS QUE NO HUBO ERROR PARA NO GUARDAR BASURA
            for($i = 0; $i < sizeof($articulos);$i++)
            {
                $sql = 'DELETE * from historicopagos WHERE NumContrato = '.$NumContrato.' AND NumMov='.$articulos[$i].'';
                echo $sql;
                if ($Vivienda->query($sql) == TRUE){   
                    $res1 = 'TRUE';
                }else{
                    $res1 = 'FALSE';                
                }
            }
            if($res1 == 'TRUE'){
                mensaje('Ocurrio un error en el proceso, favor de intentarlo nuevamente.','caja.php?IdDelegacion='.$IdDelegacion.'&IdPrograma='.$IdPrograma.'&NumContrato='.$NumContrato.'&Folio='.$Folio.'&OriginData='.$IdDelegacion.'');
            }else{
                mensaje('Ocurrio un error en el proceso, favor de intentarlo nuevamente.','caja.php?IdDelegacion='.$IdDelegacion.'&IdPrograma='.$IdPrograma.'&NumContrato='.$NumContrato.'&Folio='.$Folio.'&OriginData='.$IdDelegacion.'');
            }
        }
          
    }else{
        //SI EXISTIO UN ERROR AL TRATAR DE INGRESAR UN REGISTRO A HSITORICO PAGOS, VAMOS A ELIMINAR TODOS EN LOS QUE NO HUBO ERROR PARA NO GUARDAR BASURA

        for($i = 0; $i < sizeof($articulos);$i++)
        {
            
            $sql = 'DELETE * from historicopagos WHERE NumContrato = '.$NumContrato.' AND NumMov='.$articulos[$i].'';
            echo $sql;
            if ($Vivienda->query($sql) == TRUE){   
                $res1 = 'TRUE';
            }else{
                $res1 = 'FALSE';                
            }
        }

        if($res1 == 'TRUE'){
            mensaje('Ocurrio un error en el proceso, favor de intentarlo nuevamente.','caja.php?IdDelegacion='.$IdDelegacion.'&IdPrograma='.$IdPrograma.'&NumContrato='.$NumContrato.'&Folio='.$Folio.'&OriginData='.$IdDelegacion.'');
        }else{
            mensaje('Ocurrio un error en el proceso, favor de intentarlo nuevamente.','caja.php?IdDelegacion='.$IdDelegacion.'&IdPrograma='.$IdPrograma.'&NumContrato='.$NumContrato.'&Folio='.$Folio.'&OriginData='.$IdDelegacion.'');
        }
    }
}

?>
