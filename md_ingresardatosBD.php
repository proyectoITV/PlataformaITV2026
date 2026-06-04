<?php
require ("config.php");
require ("lib/funciones.php");
// include ("./lib/body_head.php"); include ("./lib/body_menu.php"); 

if(isset($_POST['fecha2']) and isset($_POST['montoPagado2'])){
    $idmandante = $_POST['idmandante'];
    $idcolonia = $_POST['idcolonia'];
    $idmunicipio = $_POST['idmunicipio'];
    $fecha = $_POST['fecha2'];
    $montoPagado = $_POST['montoPagado2'];
    $montoAcumulado = $_POST['montoAcumulado2'];
    $saldo = $_POST['saldo2'];
    $idTipoMov = $_POST['idTipoMov'];
    $comentario = $_POST['comentario'];
    $datosbancarios = $_POST['datosbancarios'];
    $nitavu = $_POST['nitavu1']; 

    $sql = "INSERT INTO mandantes_abonos( idmandante, idcolonia, idmunicipio, periodopago, recuperacion, gastos, montopagar, devols, amortizacion_anticipo, monto_pagado, monto_acumulado, saldo, descuento_nomina, enganche_ahorro, transferencia, pagos_universales, escritura, derechos, pago_derechos, numero_oficio, tipoMov, periodopago2,datos_bancarios)
    VALUES ('$idmandante', '$idcolonia', '$idmunicipio', '$fecha', '', '','', '','','$montoPagado','$montoAcumulado','$saldo','','','','','','','','$comentario','$idTipoMov','$fecha','$datosbancarios')";
    //echo $sql;
    if ($conexion->query($sql) == TRUE){
        echo '<p>Se ha registrado con éxito la información.</p>';
        historia($nitavu, 'Ingrese un nuevo abono para el mandante '.$idmandante.', con id colonia: '.$idcolonia.' y el id municipio: '.$idmunicipio.' .');
        
    }else{
        echo "<p>Ocurrio un problema, favor de intentarlo de nuevo.</p>";
    }

}else{
    $idmandante = $_POST['idmandante'];
    $idcolonia = $_POST['idcolonia'];
    $idmunicipio = $_POST['idmunicipio'];
    $fecha = $_POST['fecha'];
    if(isset($_POST['periodo2']) and $_POST['periodo2']<>""){
        $fecha2 = $_POST['periodo2'];
    }else{
        $fecha2 = $fecha;
    }
   
    $recuperacion = $_POST['recuperacion'];
    $pgastos = $_POST['pgastos']; 
    $gastos = $_POST['gastos']; 
    $montopagar = $_POST['montopagar'];
    $pdevols = $_POST['pdevols'];
    $devols = $_POST['devols'];
    $otrosdesc = $_POST['otrosdesc'];
    $pamorAnt = $_POST['pamorAnt'];
    $amorAnticipo = $_POST['amorAnticipo'];
    $montoPagado = $_POST['montoPagado'];
    $montoAcumulado = $_POST['montoAcumulado'];
    $saldo = $_POST['saldo'];
    // Verificamos si existe y si NO está vacío
    if (isset($_POST['sistema']) && $_POST['sistema'] !== '') {
        $sistema = $_POST['sistema'];
    } else {
        // Si está vacío o no se envió, se le asigna 0
        $sistema = 0;
    }
   
    //$engancheTraspaso = $_POST['engancheTraspaso'];
    $signo1 = $_POST['signo1'];
   
  // Verificamos si existe y si NO está vacío
    if (isset($_POST['desNomina']) && $_POST['desNomina'] !== '') {
        $desNomina = $_POST['desNomina'];
    } else {
        // Si está vacío o no se envió, se le asigna 0
        $desNomina = 0;
    }
    $signo2 = $_POST['signo2'];
     // Verificamos si existe y si NO está vacío
    if (isset($_POST['engancheAhorro']) && $_POST['engancheAhorro'] !== '') {
        $engancheAhorro = $_POST['engancheAhorro'];
    } else {
        // Si está vacío o no se envió, se le asigna 0
        $engancheAhorro = 0;
    }

    $signo3 = $_POST['signo3'];
   
   
     if (isset($_POST['transferencia']) && $_POST['transferencia'] !== '') {
        $transferencia = $_POST['transferencia'];
    } else {
        // Si está vacío o no se envió, se le asigna 0
        $transferencia = 0;
    }
    
    $signo4 = $_POST['signo4']; 
    if (isset($_POST['pagosUniversales']) && $_POST['pagosUniversales'] !== '') {
        $pagosUniversales = $_POST['pagosUniversales'];
    } else {
        // Si está vacío o no se envió, se le asigna 0
        $pagosUniversales = 0;
    }

    $signo5 = $_POST['signo5'];   
    if (isset($_POST['escritura']) && $_POST['escritura'] !== '') {
        $escritura = $_POST['escritura'];
    } else {
        // Si está vacío o no se envió, se le asigna 0
        $escritura = 0;
    }
    $signo6 = $_POST['signo6'];
   

    if (isset($_POST['derechos']) && $_POST['derechos'] !== '') {
        $derechos = $_POST['derechos'];
    } else {
        // Si está vacío o no se envió, se le asigna 0
        $derechos = 0;
    }

    $signo7 = $_POST['signo7'];    
     if (isset($_POST['pagoDerechos']) && $_POST['pagoDerechos'] !== '') {
        $pagoDerechos = $_POST['pagoDerechos'];
    } else {
        // Si está vacío o no se envió, se le asigna 0
        $pagoDerechos = 0;
    }

    $signo8 = $_POST['signo8'];    
    if (isset($_POST['pagooxxo']) && $_POST['pagooxxo'] !== '') {
        $pagooxxo = $_POST['pagooxxo'];
    } else {
        // Si está vacío o no se envió, se le asigna 0
        $pagooxxo = 0;
    }

    $signo9 = $_POST['signo9'];    
     if (isset($_POST['pagootros']) && $_POST['pagootros'] !== '') {
        $pagootros = $_POST['pagootros'];
    } else {
        // Si está vacío o no se envió, se le asigna 0
        $pagootros = 0;
    }
    $centavo = $_POST['centavo'];
    $idTipoMov = $_POST['idTipoMov'];
    $comentario = $_POST['comentario'];
    $observacionPago = $_POST['observacionPago'];
    $datosbancarios = $_POST['datosbancarios'];
    $pgastosesc = $_POST['pgastosesc']; 
    $gastosesc = $_POST['gastosesc']; 
    $nitavu = $_POST['nitavu1']; 
    $sql = "INSERT INTO mandantes_abonos( idmandante, idcolonia, idmunicipio, periodopago, recuperacion, pgastos, gastos, montopagar, pdevols, devols, pamorAnt, amortizacion_anticipo, monto_pagado, monto_acumulado, saldo, recuperacion_sistema, signo1, descuento_nomina, signo2, enganche_ahorro, signo3, transferencia, signo4, pagos_universales, signo5, escritura, signo6, derechos, signo7, pago_derechos, centavo, numero_oficio, tipoMov, periodopago2, observacionPago, signo8, oxxo,datos_bancarios,signo9, pagootros,pgastosesc, gastosesc,otrosdesc)
    VALUES ('$idmandante', '$idcolonia', '$idmunicipio', '$fecha', '$recuperacion', '$pgastos', '$gastos','$montopagar', '$pdevols','$devols','$pamorAnt', '$amorAnticipo','$montoPagado','$montoAcumulado','$saldo','$sistema', '$signo1', '$desNomina','$signo2','$engancheAhorro','$signo3','$transferencia','$signo4','$pagosUniversales','$signo5','$escritura','$signo6','$derechos','$signo7','$pagoDerechos','$centavo','$comentario','$idTipoMov','$fecha2', '$observacionPago', '$signo8', '$pagooxxo','$datosbancarios','$signo9', '$pagootros','$pgastosesc', '$gastosesc','$otrosdesc')";
  // echo $sql;

    if ($conexion->query($sql) == TRUE){
        echo '<p>Se ha registrado con éxito la información.</p>';
        historia($nitavu, 'Ingrese un nuevo abono para el mandante '.$idmandante.', con id colonia: '.$idcolonia.' y el id municipio: '.$idmunicipio.' .');
     
    }else{
        echo "<p>Ocurrio un problema, favor de intentarlo de nuevo.</p>";
    }
}


    
?>
