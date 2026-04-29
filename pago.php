
<?php
require_once("config.php");
require_once("lib/funciones.php");
require_once("lib/flor_funciones.php");
require_once("lib/yes_funciones.php");
if(isset($_POST['Cantidad']) and isset($_POST['FormaPago']) and isset($_POST['Referencia']) and isset($_POST['IdDelegacion']) and isset($_POST['IdPrograma']) and isset($_POST['Folio'])){
    $ProcedimientoCorrecto='FALSE';
    $Cantidad1= substr( $_POST['Cantidad'] , 1, strlen($_POST['Cantidad'])) ; //QUITO EL SIGNO DE PESOS ($) DE LA CANTIDAD.
    $Cantidad1=str_replace(',','',$Cantidad1); // SE QUITA LA COMA DE LA CANTIDAD PARA QUE PUEDA ALMACENARSE EN LA BASE DE DATOS.

    if($Cantidad1 <> 0){
        
        $FolioReciboUltimo = IdSiguienteFolioRecibo();
        /* VARIABLES*/
        //********************************************************************************************** */

        
        $Cantidad = $Cantidad1;
        $FormaPago = $_POST['FormaPago'];
        $Referencia = $_POST['Referencia'];
        $IdDelegacion = $_POST['IdDelegacion'];
        $IdPrograma = $_POST['IdPrograma'];
        $Folio = $_POST['Folio'];
        $NumContrato = $_POST['NumContrato'];
        $nitavu = $_POST['nitavu'];
        
        $OrigenDeEnvio=$IdDelegacion;
        $LugarExpedicion = $IdDelegacion;

        if(isset($_POST['Campaña'])){
            $BCampActiva = $_POST['Campaña'];
        }

     
     
        if(isset($_POST['CveCargo'])){
            $CveCargo = $_POST['CveCargo'];
        }else{
            $CveCargo=0;
        }
        $CveAbono=0;
                 
        if(isset($_POST['txtPeriodos'])){
            $txtPeriodos = $_POST['txtPeriodos'];
        }

       
        if(isset($_POST['TipoPago_1Liq'])){
            $TipoPago_1Liq_2Desc_3MensFree = $_POST['TipoPago_1Liq'];
        }

        if(isset($_POST['DescuentoCapital'])){
            $vMontoDescuentoCapital = $_POST['DescuentoCapital'];
        }
        $NumeroCuentaAntes = NumMov($NumContrato);  
        
        
        $Descuento=0;
        $IngresoVia = 3;
        $pago_normal="FALSE";
        $pago_exento="FALSE";

        if(isset($_POST['Descuento'])){
           $Descuento = $_POST['Descuento'];
           $Descuento= substr( $_POST['Descuento'] , 1, strlen($_POST['Descuento'])) ; //QUITO EL SIGNO DE PESOS ($) DEL DESCUENTO.
           $Descuento=str_replace(',','',$Descuento); // SE QUITA LA COMA PARA QUE PUEDA ALMACENARSE EN LA BASE DE DATOS.
        }
       
        if(isset($_POST['Total'])){
            $Importe = $_POST['Total'];
            $Importe= substr( $_POST['Total'] , 1, strlen($_POST['Total'])) ; //QUITO EL SIGNO DE PESOS ($) DEL TOTAL.
            $Importe=str_replace(',','',$Importe); // SE QUITA LA COMA DE LA CANTIDAD PARA QUE PUEDA ALMACENARSE EN LA BASE DE DATOS.
         }
        
        //NOS SERVIRA PARA SABER QUE OPERACION HAY QUE REALIZAR
        $Tipo = $_POST['Tipo'];

        
        if(isset($_POST['SaldoExentoAnt'])){
            $SaldoExentoAnt = $_POST['SaldoExentoAnt'];
        }

        if(isset($_POST['RezGts'])){
            $RezGts = $_POST['RezGts'];
        }
        if(isset($_POST['RezMoratorios'])){
            $RezMoratorios = $_POST['RezMoratorios'];
        }

        if(isset($_POST['RezFinanc'])){
            $RezFinanc = $_POST['RezFinanc'];
        }

        if(isset($_POST['RezCapital'])){
            $RezCapital = $_POST['RezCapital'];
        }

        if(isset($_POST['Rezago_seguros'])){
            $Rezago_seguros = $_POST['Rezago_seguros'];
        }

        if(isset($_POST['Rezago_otros_conceptos'])){
            $Rezago_otros_conceptos = $_POST['Rezago_otros_conceptos'];
        }

        if(isset($_POST['IdTipoMov'])){
            $IdTipoMov = $_POST['IdTipoMov'];
        }
        
        if(isset($_POST['MontoSaldarPesos'])){
            $MontoSaldarPesos = $_POST['MontoSaldarPesos'];
        }

        if(isset($_POST['factormoneda'])){
            $factormoneda = $_POST['factormoneda'];
        }
        
        if(isset($_POST['Tipo_descuento'])){
            $Tipo_descuento = $_POST['Tipo_descuento'];
        }else{
            $Tipo_descuento=0;
        }

        $CveAbono=0;
        
        $NumPago = NumeroDePago($IdDelegacion, $IdPrograma, $Folio);


      
        
        $time = time();
        $fechaRecibo=date("Y-m-d H:i:s", $time);

      
        
     
       
       /***********************OPERACIONES ***************************************************** */
               
        if($Tipo == 1){
          
            $FolioRecibo = IdSiguienteFolioRecibo();
            $IdTipoPago=3; // NOS SERVIRA PARA SABER QUE ES LO QUE ESTA PAGANDO (EN ESTE CASO ES SOLO PAGO(13).. POR QUE ES ENGANCHE_AHORRO)
            $consulta = "INSERT INTO pagos (IdDelegacion, IdPrograma, Folio, FolioRec, Cancelado, Fecha, FechaCaptura, IdEmpCrea, Importe, 
            NumPago, idTipoMov, IdFormaPago, ReferenciaPago)
            VALUES (".$IdDelegacion.", ".$IdPrograma.", ".$Folio.",".$FolioRecibo.",0,'".$fechaRecibo."', '".$fechaRecibo."', ".$nitavu.", '".$Cantidad."',
            ".$NumPago.", ".$IdTipoPago.", ".$FormaPago.", '".$Referencia."')";
            
            //ESTO SE PUEDE SACAR DE AQUI Y PONERLO COMO GLOBAL, SOLO CAMBIARIAN LAS CONSULTAS, PERO POR EL MOMENTO COMO NO HAY MAS ACCIONES LO DEJAREMOS AQUI.
            //echo $consulta;
            //$rc= $Vivienda -> query($consulta);
            if ($Vivienda->query($consulta) == TRUE){
                historia($nitavu,''.$consulta);
                historia($nitavu,'Guarde un nuevo pago para el beneficiario IdDelegacion ='.$IdDelegacion.', IdPrograma = '.$IdPrograma.', Folio='.$Folio.', FolioRecibo='.$FolioRecibo.'');
                //una vez utilizado el folio se actualiza con el numero actual 
              
            // echo "Información guardada con éxito"."_".$datosRecibo;
               
                 $NumContrato=0;

                $reciboG=GuardaDatosRecibo($IdDelegacion ,$IdPrograma ,$Folio ,$NumContrato  ,$Cantidad,$FormaPago ,$Referencia ,$fechaRecibo ,$nitavu, $FolioRecibo ,$NumPago, $IdTipoPago ,0);
					if ($reciboG="TRUE")					
					{	 	
						actualizarFolioRecibo($FolioRecibo);
                        echo "|";
                        echo modalSinRedirigir(  "Pago registrado satisfactoriamente con el número de folio " .$FolioRecibo); 
                        echo "|".$FolioReciboUltimo;
					}
            
            }else{
                historia($nitavu,'ERROR al guardar el pago '.$consulta);
                echo "|";
                modalSinRedirigir( "ERROR: Existio un error al momento de guardar la información, por favor intentelo nuevamente.");
            }
        }
        else if($Tipo==2)
        {
           // include("./determinamontos.php");
            $NumDeRepeticionesActual = 1;
            $TotDeRepeticiones = 1;
           
          
            if($txtPeriodos==0)
            {
                $TotDeRepeticiones=1;
            }
            else
            {
                $TotDeRepeticiones=$txtPeriodos;
            }
            /***************************************************************************************/
        
            if ($txtPeriodos > 0 ){
                if (( MontoPagoNumContrato($NumContrato) * $txtPeriodos) <> $Cantidad)
                {
                    echo "|";
                    //Me.txtImporte.text = Val(Replace(Replace(lblTotalMensual.Caption, "$", ""), ",", "")) * txtPeriodos.Valor;
                    modalSinRedirigir("Al parecer algo esta mal. Esta intentando adelantar " .$txtPeriodos.  " mensualidades por un monto de $ " . MontoPagoNumContrato($NumContrato) * $txtPeriodos. " y USTED intenta cobrar la cantidad de $ " .$Cantidad." El sistema solo acepta mensualidades completas (en pagos adelantados), no permite parcialidades");
                    return;
                }
            }  
            $IdTipoPago=$CveCargo;
            //AQUI IRIAN LAS DEMAS CONSULTAS SI ES NECESARIO HACER OTRO TIPO DE OPERACIONES PARA OTRO TIPO DE PAGOS
            
            $importeConvertido=$Cantidad / $factormoneda;
         
          
            if ($BCampActiva == 1 And $CveCargo <> 13 And $CveCargo <> 69 and $Descuento>0 )
            {
                
                
                if ($txtPeriodos > 0 ){
                    if (( MontoPagoNumContrato($NumContrato) * $txtPeriodos) <> $Cantidad)
                    {
                        //Me.txtImporte.text = Val(Replace(Replace(lblTotalMensual.Caption, "$", ""), ",", "")) * txtPeriodos.Valor;
                        echo "|";
                        modalSinRedirigir( "Al parecer algo esta mal. Esta intentando adelantar " .$txtPeriodos.  " mensualidades por un monto de $ " . MontoPagoNumContrato($NumContrato) * $txtPeriodos. " y USTED intenta cobrar la cantidad de $ " .$Cantidad." El sistema solo acepta mensualidades completas (en pagos adelantados), no permite parcialidades");
                        //echo "&";
                        
                    }
                }               
            
                for ($NumDeRepeticionesActual=1 ; $NumDeRepeticionesActual <= $TotDeRepeticiones; $NumDeRepeticionesActual++) 
                {
                    //incluimos la info de cobranza campaña en campaña es donde se distribuye el pago del descuento y del pago final. 
                echo "|";
                include("./CobranzaCamp.php");
                if( $ProcedimientoCorrecto=='TRUE');
                {
                    $reciboG=GuardaDatosRecibo($IdDelegacion ,$IdPrograma ,$Folio ,$NumContrato  ,$Cantidad,$FormaPago ,$Referencia ,$fechaRecibo ,$nitavu, $FolioRecibo ,$NumeroMovimiento,$CveCargo  ,$DescuentoAutorizado);
					if ($reciboG="TRUE")					
					{	 	
						actualizarFolioRecibo($FolioRecibo);
					}
                }              
                }
                echo "|".$FolioReciboUltimo;         
                return;         
            
        }          
 
    $Observacion2='';
    
    
    $FolioRecibo = IdSiguienteFolioRecibo();
    /* NOTA:
     & sirve para indicar que el resultado va divivo en dos partes.. el Mesaje y el recibo... sirve como separador para posteriormente obtener ambos datos*/
    if ($CveCargo  == 48 )
    {
        $CveAbono = 76;
    
        $pago_exento=RegistraPagoExento($NumContrato,$FolioRecibo,$fechaRecibo,$Cantidad,$nitavu,$CveCargo,$FormaPago,$IdDelegacion,$Referencia ,$Observacion2,$CveAbono,$IngresoVia,$factormoneda) ;
        echo $pago_exento;
        if($pago_exento=='FALSE')
            { $ProcedimientoCorrecto='FALSE';
                echo "|";
               modalSinRedirigir( "Al parecer algo esta mal, No fue posible registrar el pago");

            }
            else {
                $ProcedimientoCorrecto='TRUE';
                echo "|";
                echo modalSinRedirigir(  "Pago registrado satisfactoriamente con el número de folio " .$FolioRecibo); 
                echo "|".$FolioReciboUltimo;

            }
           
    }
    else
    {
        if ($CveCargo  == 51 )
        {
            $CveAbono = 77;
            $pago_exento=RegistraPagoExento($NumContrato,$FolioRecibo,$fechaRecibo,$Cantidad,$nitavu,$CveCargo,$FormaPago,$IdDelegacion,$Referencia ,$Observacion2,$CveAbono,$IngresoVia,$factormoneda) ;
            if($pago_exento=='FALSE')
            {
                $ProcedimientoCorrecto='FALSE';
                echo "|";
                modalSinRedirigir( "Al parecer algo esta mal, No fue posible registrar el pago");
                
            }else {
                $ProcedimientoCorrecto='TRUE';
                echo "|";
                echo modalSinRedirigir(  "Pago registrado satisfactoriamente con el número de folio " .$FolioRecibo); 
                echo "|".$FolioReciboUltimo;

            }
        }
        else
        {
            if ($CveCargo  ==  50 )
            {
                $CveAbono = 75;
                $pago_exento=RegistraPagoExento($NumContrato,$FolioRecibo,$fechaRecibo,$Cantidad,$nitavu,$CveCargo,$FormaPago,$IdDelegacion,$Referencia ,$Observacion2,$CveAbono,$IngresoVia,$factormoneda) ;
                if($pago_exento=='FALSE')
                {
                    $ProcedimientoCorrecto='FALSE';
                    echo "|";
                    modalSinRedirigir( "Al parecer algo esta mal, No fue posible registrar el pago");
                    
                }else {
                    $ProcedimientoCorrecto='TRUE';
                    echo "|";
                    echo modalSinRedirigir(  "Pago registrado satisfactoriamente con el número de folio " .$FolioRecibo); 
                    echo "|".$FolioReciboUltimo;

                }
            }
            else
            {
                if($CveCargo  ==  65 )
                {
                    $CveAbono = 74;
                    $pago_exento=RegistraPagoExento($NumContrato,$FolioRecibo,$fechaRecibo,$Cantidad,$nitavu,$CveCargo,$FormaPago,$IdDelegacion,$Referencia ,$Observacion2,$CveAbono,$IngresoVia,$factormoneda) ;
                    if($pago_exento=='FALSE')
                    {
                        $ProcedimientoCorrecto='FALSE';
                        echo "|";
                        modalSinRedirigir( "Al parecer algo esta mal, No fue posible registrar el pago");
                        
                    }else {
                        $ProcedimientoCorrecto='TRUE';
                        echo "|";
                        echo modalSinRedirigir(  "Pago registrado satisfactoriamente con el número de folio " .$FolioRecibo); 
                        echo "|".$FolioReciboUltimo;

                    }
                   
                 }
                else
                {
                    if  ($CveCargo  == 13)
                    {
                        $CveAbono = 13;
                        $pago_exento=RegistraPagoExento($NumContrato,$FolioRecibo,$fechaRecibo,$Cantidad,$nitavu,$CveCargo,$FormaPago,$IdDelegacion,$Referencia ,$Observacion2,$CveAbono,$IngresoVia,$factormoneda) ;
                        if($pago_exento=='FALSE')
                        {
                            $ProcedimientoCorrecto='FALSE';
                            echo "|";
                            modalSinRedirigir( "Al parecer algo esta mal, No fue posible registrar el pago");
                            
                        }else {
                            $ProcedimientoCorrecto='TRUE';
                            echo "|";
                            echo modalSinRedirigir(  "Pago registrado satisfactoriamente con el número de folio " .$FolioRecibo); 
                            echo "|".$FolioReciboUltimo;
                        }
                        
                    }
                    else
                    {
                        if ($CveCargo  == 92 )
                        {
                            $CveAbono = 93;
                            $pago_exento=RegistraPagoExento($NumContrato,$FolioRecibo,$fechaRecibo,$Cantidad,$nitavu,$CveCargo,$FormaPago,$IdDelegacion,$Referencia ,$Observacion2,$CveAbono,$IngresoVia,$factormoneda) ;
                            if($pago_exento=='FALSE')
                            {
                                $ProcedimientoCorrecto='FALSE';
                                echo "|";
                                modalSinRedirigir( "Al parecer algo esta mal, No fue posible registrar el pago");
                                
                            }else {
                                $ProcedimientoCorrecto='TRUE';
                                echo "|";
                                echo modalSinRedirigir(  "Pago registrado satisfactoriamente con el número de folio " .$FolioRecibo); 
                                echo "|".$FolioReciboUltimo;
                            }
                        }
                        else
                        {
                            if ($CveCargo == 71 )
                            {
                                $CveAbono = 127;
                                $pago_exento=RegistraPagoExento($NumContrato,$FolioRecibo,$fechaRecibo,$Cantidad,$nitavu,$CveCargo,$FormaPago,$IdDelegacion,$Referencia ,$Observacion2,$CveAbono,$IngresoVia,$factormoneda) ;
                                if($pago_exento=='FALSE')
                                {
                                    $ProcedimientoCorrecto='FALSE';
                                    echo "|";
                                    modalSinRedirigir( "Al parecer algo esta mal, No fue posible registrar el pago");
                                    
                                }else {
                                    $ProcedimientoCorrecto='TRUE';
                                    echo "|";
                                    echo modalSinRedirigir(  "Pago registrado satisfactoriamente con el número de folio " .$FolioRecibo); 
                                    echo "|".$FolioReciboUltimo;
                                }
                            }
                            else
                            {
                                
                                if ($Tipo_descuento > 0 )
                                {
                                    if ($Tipo_descuento == 72 )
                                    {
                                        // bonificacion, abono directo a saldocapitalcorriente
                                        $CveAbono = $Tipo_descuento;
                                        $pago_exento=RegistraPagoExento($NumContrato,$FolioRecibo,$fechaRecibo,$Cantidad,$nitavu,$CveCargo,$FormaPago,$IdDelegacion,$Referencia ,$Observacion2,$CveAbono,$IngresoVia,$factormoneda) ;
                                        if($pago_exento=='FALSE')
                                        {
                                            $ProcedimientoCorrecto='FALSE';
                                            echo "|";
                                            modalSinRedirigir( "Al parecer algo esta mal, No fue posible registrar el pago");                                          
                                           
                                            
                                        }else {
                                            $ProcedimientoCorrecto='TRUE';
                                            echo "|";
                                            echo modalSinRedirigir(  "Pago registrado satisfactoriamente con el número de folio " .$FolioRecibo);
                                            echo "|".$FolioReciboUltimo;
                                        }
                                    }
                                    else
                                    {
                                        $pago_normal= PagoNormal($NumContrato,$txtPeriodos,$fechaRecibo,$Cantidad,$nitavu,$CveCargo,$FormaPago,$OrigenDeEnvio,$FolioRecibo,$IngresoVia,$factormoneda,$Referencia);
                                        if($pago_normal=='FALSE')
                                        {   $ProcedimientoCorrecto='FALSE';
                                            echo "|";
                                            echo modalSinRedirigir( "Al parecer algo esta mal, No fue posible registrar el pago");
                                            
                                            
                                        }else {
                                            $ProcedimientoCorrecto='TRUE';
                                            echo "|";
                                            echo  modalSinRedirigir(  "Pago registrado satisfactoriamente con el número de folio " .$FolioRecibo);  
                                            echo "|".$FolioReciboUltimo;
                                        }
                                    }
                                }    
                                else
                                {
                                    $pago_normal= PagoNormal($NumContrato,$txtPeriodos,$fechaRecibo,$Cantidad,$nitavu,$CveCargo,$FormaPago,$OrigenDeEnvio,$FolioRecibo,$IngresoVia,$factormoneda,$Referencia);
                                    if($pago_normal=='FALSE')
                                    { $ProcedimientoCorrecto='FALSE';
                                        echo "|";
                                        echo modalSinRedirigir( "Al parecer algo esta mal, No fue posible registrar el pago");
                                    
                                    }else { $ProcedimientoCorrecto='';
                                        echo "|";
                                        echo modalSinRedirigir(  "Pago registrado satisfactoriamente con el número de folio " .$FolioRecibo);
                                        echo "|".$FolioReciboUltimo;
                                        
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
    }

            
    }
        
        // //SE GENERA EL CODIGO QR
        // $codigoQR=GenerarQRrecibo($FolioRecibo,$Cantidad,$fechaRecibo,$nitavu);

       
        // //CODIGO YESIII--------------------------------------------------------------------------- 
        // // SE HACE UN ARREGLO CON TODAS LAS VARIABLES QUE SE NECESITAN PARA GENERAR EL RECIBO       
        // $datosRecibo = [ 'iddelegacion' => $IdDelegacion,'idprograma' => $IdPrograma,'folio' => $Folio
        // ,'numcontrato' => $NumContrato,'cantidad' => $Cantidad,'formapago' => $FormaPago,'referencia' => $Referencia,
        // 'fecharecibo' => $fechaRecibo,'nitavu' => $nitavu,'foliorecibo' => $FolioRecibo,
        // 'numpago' => $NumPago,'idtipopago' => $IdTipoPago,'descuento' => $Descuento, 'codigoqr' => $codigoQR ];

        // $datosRecibo = serialize($datosRecibo);
        // $datosRecibo = base64_encode($datosRecibo);
        // $datosRecibo = urlencode($datosRecibo);  
      
        
        // if( $ProcedimientoCorrecto=='FALSE')
        // { $datosRecibo="";

        // }
        // echo $datosRecibo;
     
        
    }else{
        echo 'ERROR: No se puede recibir un pago por 0 pesos.';
    }

}else{
    echo 'ERROR: al recibir la información, favor de intentarlo de nuevo.';
}

   

?>
