<?PHP

$vPorcMoraDesc=0;
$ultimoMov = obtenerMaximoMovCuenta($NumContrato);


//Busca si existe un descuento en la cuetna
$datosdes = buscaDescuento($NumContrato,$nitavu); 
$DescuentoAutorizado=0;  
            
if($datosdes!='FALSE' )
  {                        
    $datosdes = explode("_", $datosdes);     
    $DescuentoAutorizado=$datosdes[0];
    $minimo=$datosdes[1];
    $TipoDescuento = $datosdes[2];
    $descipcionMov=$datosdes[3];
    $BhayDescuento = 1;
  }


$sql2 = " select * from historicopagos where NumContrato='".$NumContrato."' and Cancelado=0 and NumMov = ".$ultimoMov."";
//echo $sql2;
$r2= $Vivienda -> query($sql2);
$r_count2 = $r2 -> num_rows;
if($r_count2>0){
    while($f2 = $r2 -> fetch_array()) {

        $capitalPeriodo = $f2['CapitalPeriodo'];

        if ($f2['TipoMov'] == 34 or $f2['TipoMov'] == 110){
            $Actualizacion7 = $f2['CapitalPeriodo'];
            //trae informacion de moratorios de la vista
            $moratorios = $f2['NuevoRezMoratorios'];
            
        }else{
            $Actualizacion7 = 0;
        }
    }
}else{
    $Actualizacion7 = 0;
    
}

$sql3 = "SELECT vivienda_datosgenerales.NombreCompleto, IFNULL(0,busqueda_vivienda_informacionfinanciera.Saldo_VencidoSinMoratorios) AS Saldo_VencidoSinMoratorios, busqueda_vivienda_informacionfinanciera.Saldo_Corriente, busqueda_vivienda_informacionfinanciera.Saldo_Moratorio , busqueda_vivienda_informacionfinanciera.NumContrato, busqueda_vivienda_informacionfinanciera.saldo ,busqueda_vivienda_informacionfinanciera.idprograma,busqueda_vivienda_informacionfinanciera.folio 
FROM  busqueda_vivienda_informacionfinanciera 
LEFT OUTER JOIN vivienda_datosgenerales ON busqueda_vivienda_informacionfinanciera.NumContrato = vivienda_datosgenerales.NumContrato  WHERE     (busqueda_vivienda_informacionfinanciera.NumContrato = ".$NumContrato.")";
//echo $sql3;
$r3 = $Vivienda -> query($sql3);
while($f3 = $r3 -> fetch_array()) {
    $SaldoACubrir = $f3['Saldo_VencidoSinMoratorios'];
    $SaldoCorriente = $f3['Saldo_Corriente'];
    $SaldoMoratorios7= $f3['Saldo_Moratorio'];
    $Saldo = $f3['saldo'];
    //$DesctoCapital = $f3['vMontoDescuentoCapital'];
    $InteresMorat7 = $f3['Saldo_Moratorio'];
}



//revisa si hay un tramite de escritura
$sql4 = " SELECT     NumContrato, NumMov,TipoMov, CapitalPeriodo, Cancelado from historicopagos
WHERE  (NumContrato = ".$NumContrato.") AND (TipoMov = 10) and Cancelado=0";
$r4 = $Vivienda -> query($sql4);
while($f4 = $r4 -> fetch_array()) {   
    if($f4['CapitalPeriodo'] <= 517.11 or $f4['CapitalPeriodo'] <= 1860.83 or $f4['CapitalPeriodo'] <= 578.75 or $f4['CapitalPeriodo'] <= 2082.67){
        $TieneEscritura='true';
        $sql5 =  "SELECT NumContrato, SUM( montopagorecibido)as MontoPagoRecibido from historicopagos
        WHERE     (NumContrato = '".$NumContrato."') AND (TipoMov in (3,40,124,117,58))and cancelado=0 and NumMov>".$f4['NumMov']." group by numcontrato";
        $r5 = $Vivienda -> query($sql5);                        
        $r_count5 = $r5 -> num_rows;
        if($r_count5 > 0){
        
            while($f5 = $r5 -> fetch_array()) {        
                $PorPagarEsc = ($f4['CapitalPeriodo']) - $f5['MontoPagoRecibido'];
                if($PorPagarEsc > ($f4['CapitalPeriodo'] / 2)) {
                    $HastaDescEscritura = ($f4['CapitalPeriodo'] / 2);
                }else{
                    $HastaDescEscritura = $f4['CapitalPeriodo'] - $f5['MontoPagoRecibido'];
                }
            }
        }else{
            $PorPagarEsc = $f4['CapitalPeriodo'] / 2;
        }
                
        $HastaDescEscritura = $PorPagarEsc;  
    }
}



$vTiempo=0;
$sql6 = "SELECT busqueda_vivienda_informacionfinanciera.IdDelegacion, busqueda_vivienda_informacionfinanciera.IdPrograma, busqueda_vivienda_informacionfinanciera.Folio, busqueda_vivienda_informacionfinanciera.NumContrato, busqueda_vivienda_informacionfinanciera.TasaAnualFin, busqueda_vivienda_informacionfinanciera.TasaIntMora, busqueda_vivienda_informacionfinanciera.MontoCredito, busqueda_vivienda_informacionfinanciera.MontoPago, Actualizacion, 
Cargo_MontoCredito, Cargo_OtrosGastos, Cargo_ComisionesFinancSegVida, Cargo_Moratorios, Abonos_Ahorros, Abonos_Subsidios, Abonos_PagosRecibidos, Abonos_Descuentos, Abonado_SoloCapital, Saldo_VencidoSinMoratorios , Saldo_Corriente, Saldo_Moratorio, saldo, MesesDeAtraso, FechaPrimerPAGO, FechaUltimoPAGO, contratos.FechaEmision
FROM  busqueda_vivienda_informacionfinanciera 
LEFT OUTER JOIN contratos ON busqueda_vivienda_informacionfinanciera.NumContrato = contratos.NumContrato 
WHERE (busqueda_vivienda_informacionfinanciera.NumContrato = ".$NumContrato.")";
    $r6 = $Vivienda -> query($sql6);
    while($f6 = $r6 -> fetch_array()) {   
    //revisa ultimo pago
    if(is_null($f6['FechaUltimoPAGO'])){
        $date1 = new DateTime($f6['FechaEmision']);
        $date2 = new DateTime(getdate());
        $interval = $date1->diff($date2);
        // $interval->m." months "; 
        $vTiempo=$interval->format("%m");

        //$vTiempo = DateDiff("m", $f6['FechaEmision'], );
    }else{
        $date1 = new DateTime($f6['FechaUltimoPAGO']);
        $hoy = getdate();                    
        $date2 = new DateTime($fecha);
        $interval = $date1->diff($date2);
        //echo $interval->m." months "; 
        $vTiempo=$interval->format("%m");
        //$vTiempo = DateDiff("m", $f6['fechaultimopago'], now());
    }
    }

     /*
    if ($vTiempo > 120 )
    {  $vPorcMoraDesc = 50;

    }else if($vTiempo <= 120)
    {
    $vPorcMoraDesc = 100;
    }*/


    if ($DescuentoAutorizado > 0 And $Tipo_descuento == 125 ) 
    {
        $vTiempo = 1000;
    }
    if ($DescuentoAutorizado > 0 And $Tipo_descuento == 126 ) 
    {
        $vTiempo = 2000;
    }

    echo "<input type='hidden' name='vTiempo' id='vTiempo' value='".$vTiempo."'>";
    //Rem revision de cumplimiento en el año
    $BSinAtrasoAnual = sumaMoratorios2018($NumContrato);
    echo "<input type='hidden' name='BSinAtrasoAnual' id='BSinAtrasoAnual' value='".$BSinAtrasoAnual."'>";


//revisa cuanto se descuenta de capital si liquida
    $vNumMov = obtenerMaximoMovCuenta($NumContrato);

    $BIdMandante = idMandanteLoteporNumContrato($NumContrato);
    echo "<input type='hidden' name='BIdMandante' id='BIdMandante' value='".$BIdMandante."'>";

    $sql7 = "select * from historicopagos where numcontrato='".$NumContrato."' and cancelado=0  and nummov=".$vNumMov."";
    //echo $sql7;
   $r7 = $Vivienda -> query($sql7);
	$r_count7 = $r7-> num_rows;
	if($r_count7 > 0)
	{
        while($f7 = $r7 -> fetch_array())
		{
            if ($BIdMandante > 0 ){
                $vMontoDescuentoCapital = 0;
            }else{
                $vMontoDescuentoCapital = ($f7['NuevoRezCapital'] + $f7['SaldoCapitalCorriente']) * 0.1;
            }
        }
      
    }else
    {
        $vMontoDescuentoCapital = 0;
    }

    echo "<input type='hidden' name='vMontoDescuentoCapital' id='vMontoDescuentoCapital' value='".$vMontoDescuentoCapital."'>";
?>