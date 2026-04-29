<?php
require_once("config.php");
require_once("lib/funciones.php");
require_once("lib/flor_funciones.php");
require_once("lib/yes_funciones.php");

$NumContrato = $_POST['NumContrato'];
// $OriginData = $_POST['OriginData'];


    $IdPrograma = $_POST['IdPrograma'];
    $Importe = $_POST['Importe'];
    $cargo = $_POST['Cargo'];
    $MontoSaldarPesos = $_POST['MontoSaldarPesos'];
    $nitavu = $_POST['nitavu'];
    $campaña = $_POST['campaña'];
    
    $TipoPago_1Liq_2Desc_3MensFree=0;

    $EstatusCuenta = ObtenerIdEstatusCuenta($NumContrato);
    $DescuentoAutorizado=0;
    $BhayDescuento = 0;
    //Busca si existe un descuento en la cuetna
    $datosdes = buscaDescuento($NumContrato,$nitavu);                
    if($datosdes!='FALSE'){                        
      $datosdes = explode("_", $datosdes);     
      $DescuentoAutorizado=$datosdes[0];
      $MinimoRequiereAbonar=$datosdes[1];
      $Tipo_descuento=$datosdes[2];
      $BhayDescuento = 1;
      
    }

   //incluimos los querys de analiza campaña
   include("./analizaCampaña.php");
  
    //echo 'CAMPAÑA'. $campaña;
    if($campaña <> 'FALSE'){
        $BCampActiva = 1;
    }else{
        $BCampActiva = 0;
    }

    //echo 'campaña activa'.$BCampActiva;
    $txtDescuento = 0;
    $txtTotal = 0;
    //CODIGO PARA AFECTAR LOS ELEMENTOS UNA VEZ INTRODUCIDO EL IMPORTE
    /*echo '<div id="modal_oscuro">';
        echo '<div id="mensaje">';
        echo "<p>1888.-PRUEBA</p>";
        echo '<a class="Mbtn btn-default" onclick="cerrarModal();">Aceptar</a>  ';
        echo "</div>";
    echo '</div>';*/
    //ACCIONES QUE ESTABAN EN EL LOST FOCUS DE IMPROTE
    //si esta en algun cargo de esos  no puede cobrar como si fuera campaña, debe ser un pago normal
    if($IdPrograma == 240 || $cargo == 50 || $cargo == 51 || $cargo == 53 || $cargo == 48 || $cargo == 49 || $cargo == 53 || $cargo == 92 || $cargo == 94 || $cargo == 96 || $cargo == 71 || $cargo == 36 || $cargo == 53 || $cargo == 49 || $cargo == 38){
        $BCampActiva = 0;
       
    } 
    $saldoMoratorio = Saldo_MoratorioViviendaIF($NumContrato);
    $saldo = SaldoViviendaIF($NumContrato) ;
    
    //modalSinRedirigir("PRUEBA");
    if($BCampActiva ==1)
    {
    //revisa que descuento obtiene con la cantidad registr
    
    if($Importe >= $MontoSaldarPesos And $cargo <> 10){
    // nuevo periodo de campaña, liquidación autorizada por delegados
    // revisar si hay un descuento autorizado por delegado
           
    
        if ($BhayDescuento == 1){
            $TipoPago_1Liq_2Desc_3MensFree = 1;
            $vMontoARecibirCaja = $saldo - ($DescuentoAutorizado + $vMontoDescuentoCapital);
            if ($BIdMandante > 0){
                /*echo '<div id="modal_oscuro">';
                    echo '<div id="mensaje">';
                    echo "<p>1.-Con esta cantidad podra liquidar su cuenta con los siguientes beneficios * Descuento de moratorios AUTORIZADO : $ ".$DescuentoAutorizado. "* Una BONIFICACION  de : $ ".$vMontoDescuentoCapital." (No Aplica. MANDANTES) * La persona pagara : $ ".$vMontoARecibirCaja." Leido las instrucciones, presione boton Aceptar para continuar</p>";
                    echo '<a class="Mbtn btn-default" onclick="cerrarModal();">Aceptar</a>  ';
                    echo "</div>";
                echo '</div>';*/
                modalSinRedirigir("Con esta cantidad podra liquidar su cuenta con los siguientes beneficios * Descuento de moratorios AUTORIZADO : $ ".$DescuentoAutorizado. "* Una BONIFICACION  de : $ ".$vMontoDescuentoCapital." (No Aplica. MANDANTES) * La persona pagara : $ ".$vMontoARecibirCaja." Leido las instrucciones, presione boton Aceptar para continuar");
            }else{
                /*echo '<div id="modal_oscuro">';
                    echo '<div id="mensaje">';
                    echo "<p>2.-Con esta cantidad podra liquidar su cuenta con los siguientes beneficios * Descuento de moratorios AUTORIZADO : $ ".$DescuentoAutorizado."* Una BONIFICACION  de : $ ".$vMontoDescuentoCapital." * La persona pagara : $ ".$vMontoARecibirCaja." Leido las instrucciones, presione boton Aceptar para continuar</p>";
                    echo '<a class="Mbtn btn-default" onclick="cerrarModal();">Aceptar</a>  ';
                    echo "</div>";
                echo '</div>';*/
                modalSinRedirigir("Con esta cantidad podra liquidar su cuenta con los siguientes beneficios * Descuento de moratorios AUTORIZADO : $ ".$DescuentoAutorizado."* Una BONIFICACION  de : $ ".$vMontoDescuentoCapital." * La persona pagara : $ ".$vMontoARecibirCaja." Leido las instrucciones, presione boton Aceptar para continuar");
            }
            $Desc = $vMontoDescuentoCapital + $DescuentoAutorizado;
            $txtDescuento = $vMontoDescuentoCapital + $DescuentoAutorizado;
            $txtTotal = (float)$Importe - (float)$txtDescuento;
        }else{
                // revisa si es mandante y no tiene moratorios no envia mensaje
                
            if ($saldoMoratorio > 0){
                /*echo '<div id="modal_oscuro">';
                    echo '<div id="mensaje">';
                    echo "<p>3.-Se detectó que intenta liquidar esta cuenta, Es necesario que el deudor se presente ante el Delegado para un posible beneficio</p>";
                    echo '<a class="Mbtn btn-default" onclick="cerrarModal();">Aceptar</a>  ';
                    echo "</div>";
                echo '</div>';       */         
                modalSinRedirigir("Se detectó que intenta liquidar esta cuenta, Es necesario que el deudor se presente ante el Delegado para un posible beneficio");
                $TipoPago_1Liq_2Desc_3MensFree = 0;
                
            }else{
                //Se revisa que no sea de mandante para aplicacion del 10% de capital a cuentas sin mandante
                if ($BIdMandante == 0){
                    /*echo '<div id="modal_oscuro">';
                        echo '<div id="mensaje">';
                        echo "<p>4.-Se detectó que intenta liquidar esta cuenta. Es necesario que el deudor se presente ante el Delegado para un posible beneficio</p>";
                        echo '<a class="Mbtn btn-default" onclick="cerrarModal();">Aceptar</a>  ';
                        echo "</div>";
                    echo '</div>'; */
                    modalSinRedirigir("Se detectó que intenta liquidar esta cuenta. Es necesario que el deudor se presente ante el Delegado para un posible beneficio");
                    $TipoPago_1Liq_2Desc_3MensFree = 0;
                    
                }else{
                    $BCampActiva = 0;
                }
            }
        }
    }else{
        //meses
        if($vTiempo > 120 and $vTiempo < 1000 ){
            $TipoPago_1Liq_2Desc_3MensFree = 2;
            $vPorcMoraDesc = 50;
            $vMontoDescuentoMoratorio = $saldoMoratorio / 2;
            $txtDescuento = $vMontoDescuentoMoratorio;
            $vMontoDescuentoMora = $vMontoDescuentoMoratorio;
            $Importe = $Importe + $vMontoDescuentoMoratorio;
            /*echo '<div id="modal_oscuro">';
                echo '<div id="mensaje">';
                echo "<p>5.-AVISO AL BENEFICIARIO. Comunicarle a la persona que le aplicara un descuento del 50% de Moratorios ".$vMontoDescuentoMoratorio."</p>";
                echo '<a class="Mbtn btn-default" onclick="cerrarModal();">Aceptar</a>  ';
                echo "</div>";
            echo '</div>'; */
            modalSinRedirigir("AVISO AL BENEFICIARIO. Comunicarle a la persona que le aplicara un descuento del 50% de Moratorios ".$vMontoDescuentoMoratorio."");
        }else{
            if($vTiempo > 0 and $vTiempo <= 120 and $BSinAtrasoAnual == 0 and $cargo <> 10 and $vTiempo == 8000 ){
                $TipoPago_1Liq_2Desc_3MensFree = 2;
                $vPorcMoraDesc = 100;
                $vMontoDescuentoMoratorio = $saldoMoratorio;
                $vMontoDescuentoMora = $vMontoDescuentoMoratorio;
                $txtDescuento = $vMontoDescuentoMoratorio;
                $Importe = (float)$Importe + $vMontoDescuentoMoratorio;
                /*echo '<div id="modal_oscuro">';
                    echo '<div id="mensaje">';
                    echo "<p>6.-AVISO AL BENEFICIARIO. Comunicarle a la persona que le aplicara un descuento del 100% de Moratorios ".$vMontoDescuentoMoratorio."</p>";
                    echo '<a class="Mbtn btn-default" onclick="cerrarModal();">Aceptar</a>  ';
                    echo "</div>";
                echo '</div>'; */
                modalSinRedirigir("AVISO AL BENEFICIARIO. Comunicarle a la persona que le aplicara un descuento del 100% de Moratorios ".$vMontoDescuentoMoratorio."");
            }else{
                if($vTiempo == 1000 and $BSinAtrasoAnual == 0 and $cargo <> 10 and $Tipo_descuento == 125){
                    $TipoPago_1Liq_2Desc_3MensFree = 2;
                    $vMontoDescuentoMora = $DescuentoAutorizado;
                    // mismo procedimiento que tiempo regular
                    if($DescuentoAutorizado > 0){
                        if($Importe > ($MinimoRequiereAbonar + $DescuentoAutorizado)){
                            $txtDescuento = $DescuentoAutorizado;
                            $BandAplicaDesc = 1;
                        }else{
                            $cDiferencia = ((float)$Importe - ($MinimoRequiereAbonar + $DescuentoAutorizado));
                            if($cDiferencia > -1 and $cDiferencia < 1){
                                $txtDescuento = $DescuentoAutorizado;
                                $BandAplicaDesc = 1;
                            }else{
                                $suma = $MinimoRequiereAbonar + $DescuentoAutorizado;
                                /*echo '<div id="modal_oscuro">';
                                    echo '<div id="mensaje">';
                                    echo "<p>7.-Hay un descuento autorizado por ".$DescuentoAutorizado.", pero se requiere un pago de por lo menos ".$suma." para activarlo</p>";
                                    echo '<a class="Mbtn btn-default" onclick="cerrarModal();">Aceptar</a>  ';
                                    echo "</div>";
                                echo '</div>'; */
                                modalSinRedirigir("Hay un descuento autorizado por ".$DescuentoAutorizado.", pero se requiere un pago de por lo menos ".$suma." para activarlo");
                                $txtDescuento = 0;
                                $BandAplicaDesc = 0;
                            }
                        }
                    }else{
                        $txtDescuento = 0;
                    }
                    $txtTotal = (float)$Importe - (float)$txtDescuento;  
                }else{                  
                    if($BSinAtrasoAnual == 1 and $cargo <> 10){
                        $TipoPago_1Liq_2Desc_3MensFree = 3;
                    }else{
                        if($vTiempo == 2000 and $cargo == 10){
                            $TipoPago_1Liq_2Desc_3MensFree = 4;
                            //mismo procedimiento que tiempo regular
                            if($DescuentoAutorizado > 0){
                                if($Importe > ($MinimoRequiereAbonar + $DescuentoAutorizado)){
                                    $txtDescuento = $DescuentoAutorizado;
                                    $BandAplicaDesc = 1;
                                }else{
                                    $cDiferencia = ((int)$Importe - ((int)$MinimoRequiereAbonar + (int)$DescuentoAutorizado));
                                    if ($cDiferencia > -1 and $cDiferencia < 1){
                                        $txtDescuento = $DescuentoAutorizado;
                                        $BandAplicaDesc = 1;
                                    }else{
                                        $suma = $MinimoRequiereAbonar + $DescuentoAutorizado;
                                        /*echo '<div id="modal_oscuro">';
                                            echo '<div id="mensaje">';
                                            echo "<p>8.-Hay un descuento autorizado por ".$DescuentoAutorizado.", pero se requiere un pago de por lo menos ".$suma." para activarlo</p>";
                                            echo '<a class="Mbtn btn-default" onclick="cerrarModal();">Aceptar</a>  ';
                                            echo "</div>";
                                        echo '</div>'; */
                                        modalSinRedirigir("Hay un descuento autorizado por ".$DescuentoAutorizado.", pero se requiere un pago de por lo menos ".$suma." para activarlo");
                                        $txtDescuento = 0;
                                        $BandAplicaDesc = 0;
                                    }
                                }
                            }else{
                                $txtDescuento = 0;
                            }
                            $txtTotal = (float)$Importe - (float)$txtDescuento;
                    
                        }else{
                            $BCampActiva = 0;
                        }
                                
                    }
                        
                }
                
            }

        }
    }
}

    
    if($BCampActiva == 0){
        if($DescuentoAutorizado > 0){
            if($Importe > ($MinimoRequiereAbonar + $DescuentoAutorizado)){
                $txtDescuento = $DescuentoAutorizado;
                $BandAplicaDesc = 1;
            }else{
                $cDiferencia = ((float)$Importe - ((float)$MinimoRequiereAbonar + (float)$DescuentoAutorizado));
            if($cDiferencia > -1 and $cDiferencia < 1){
                $txtDescuento = $DescuentoAutorizado;
                $BandAplicaDesc = 1;
            }else{
                $suma = (float)$MinimoRequiereAbonar + (float)$DescuentoAutorizado;
                /*echo '<div id="modal_oscuro">';
                    echo '<div id="mensaje">';
                    echo "<p>9.-Hay un descuento autorizado por ".(float)$DescuentoAutorizado.", pero se requiere un pago de por lo menos ".$suma." para activarlo</p>";
                    echo '<a class="Mbtn btn-default" onclick="cerrarModal();">Aceptar</a>  ';
                    echo "</div>";
                echo '</div>';*/
                modalSinRedirigir("Hay un descuento autorizado por ".(float)$DescuentoAutorizado.", pero se requiere un pago de por lo menos ".$suma." para activarlo");

                $txtDescuento = 0;
                $BandAplicaDesc = 0;
            }
            }
        }else{
            $txtDescuento = 0;
        }
        $txtTotal = (float)$Importe - (float)$txtDescuento;
    }

    if($Importe > 0){
        if($IdPrograma == 271 and $cargo == 13 and $Importe > $AhorroPorCubrir and $EstatusCuenta == 10){
            /*echo '<div id="modal_oscuro">';
                echo '<div id="mensaje">';
                echo "<p>10.-Esta intentando pagar una cantidad mayor a la esperada como pago inicial</p>";
                echo '<a class="Mbtn btn-default" onclick="cerrarModal();">Aceptar</a>  ';
                echo "</div>";
            echo '</div>';*/
            modalSinRedirigir("Esta intentando pagar una cantidad mayor a la esperada como pago inicial");
                                
        }else{
            if($IdPrograma == 271 and $cargo == 13 and $Importe < $vMontoAhorrado + $Importe and $EstatusCuenta == 10){
                /*echo '<div id="modal_oscuro">';
                    echo '<div id="mensaje">';
                    echo "<p>11.-Esta intentando pagar una cantidad mayor a la esperada como pago inicial</p>";
                    echo '<a class="Mbtn btn-default" onclick="cerrarModal();">Aceptar</a>  ';
                    echo "</div>";
                echo '</div>';*/
                modalSinRedirigir("Esta intentando pagar una cantidad mayor a la esperada como pago inicial");
                
                
            }else{
                
                if($IdPrograma == 271 and $cargo == 13 and $vMontoAhorrado = 0 and $Importe < $vMontoMinimo and $EstatusCuenta == 10){
                    /*echo '<div id="modal_oscuro">';
                        echo '<div id="mensaje">';
                        echo "<p>12.-Esta intentando pagar una cantidad menor a la esperada como pago inicial</p>";
                        echo '<a class="Mbtn btn-default" onclick="cerrarModal();">Aceptar</a>  ';
                        echo "</div>";
                    echo '</div>';*/
                    modalSinRedirigir("Esta intentando pagar una cantidad menor a la esperada como pago inicial");
                        
                }else{
                    
                }
            
            }
        }
    }


    echo "<div>";
        echo '<center>';  
        echo "<table style='width:100%; font-weight: bolder;'>"; 
        echo "<tr>";      
        echo "<td align='center'>"; 
        echo "<label>Su pago</label>";
        $Importe = (float)$Importe;
        echo "<br><label style='font-weight: bolder;' class='h5' id='lblPago' name='lblPago' >$".number_format($Importe,2,'.',',')."</label>";
        echo "</td>"; 

        echo "<td align='center'>";   
        echo "<label>Descuento</label>";
        echo "<br><label  style='font-weight: bolder;' class='h5' id='lblDescuento' name='lblDescuento' >$".number_format($txtDescuento,2,'.',',')."</label>";
        echo '</td>'; 
        
        echo "<td align='center'>";  
        echo "<label>Total</label>";
        echo "<br><label style='font-weight: bolder;' class='h5' id='lblTotal' name='lblTotal' >$".number_format($txtTotal,2,'.',',')."</label>"; 
        echo "</td>";       
        echo "</tr>";
        echo "<td><input type='text' id='TipoPago_1Liq' name='TipoPago_1Liq' value='".$TipoPago_1Liq_2Desc_3MensFree."'></td>"; 
        echo "<td><input type='text' id='vMontoDescuentoCapital' name='vMontoDescuentoCapital' value='".$vMontoDescuentoCapital."'></td>";      
        echo "</tr>";
        echo "</table>"; 
        echo '</center>'; 
    echo "</div>"; 
    echo "<script>$('#campaña').val('".$BCampActiva."');</script>"
?>
<script>
function cerrarModal(e){
  	$('#modal_oscuro').hide();
	//document.getElementById('modal_oscuro')						this.close(); //Cierra la notificación
						
}
</script>