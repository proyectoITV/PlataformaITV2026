<?php
require_once("config.php");
require_once("lib/funciones.php");
require_once("lib/flor_funciones.php");
require_once("lib/yes_funciones.php");

                    $CargosPeriodo = "";
                    $AbonosPeriodo = "";
                    $MontoRestantePesos = "";
                    $minimoacubrirpesos = "";
                    $MontoSaldarPesos = "";
                    $rezagootrosperiodos = "";
                    $MontoRestante = "";
                    $minimoacubirir = "";
                    $MontoSaldar = "";
                    $estatusCuenta = "";
                    

                    $NumeroMovimiento=NumMov($NumContrato);
                    //CONTROL CONTRATOS
                    $sql = "Select * from controlcontratos where NumContrato = '".$NumContrato."'";
                    ////echo $sql;
                    $rc = $Vivienda -> query($sql);
                    
                    $r_count = $rc -> num_rows;
                    if($r_count > 0){
                      while($f = $rc -> fetch_array()){

                        if(is_null($f['FechaCorteAnterior'])){
                          //echo 'Entro';
                          $prox_Corte = strtotime($f['FechaProximoCorte']);
                          $fecha_corte_ant = date("Y-m-d", strtotime("-1 month", $prox_Corte));
                          //echo $fecha_corte_ant;
                        }else{
                          //echo 'no entro';
                          $fecha_corte_ant = $f['FechaCorteAnterior'];
                        }

                        $fecha_corte_sig = $f['FechaProximoCorte'];
                      
                        $estatusCuenta=$f['EstatusCuenta'];
                        if($f['EstatusCuenta'] > 3 and $f['EstatusCuenta'] <> 9 and $IdPrograma <> 271){
                            mensaje("ERROR. La cuenta esta bloqueada no se puede recibir pago de momento, el estatus de la cuenta. <b>".obtenerEstatusCuenta($f['EstatusCuenta'])."</b>.","caja.php");
                        }else{

                          if($f['EstatusCuenta'] == 1){
                            MsgBox_Lite("Esta cuenta YA ESTA SALDADA, no hay pagos pendientes por recibir.","caja.php");
                          }else{                            
                            $factormoneda = obtenerfactorconversion(TipoMonedaPorNumContrato($NumContrato), $fecha_corte_sig);
                         
                            if(is_null($f['FechaCorteAnterior'])){
                              $sqlHP = "Select * from historicopagos where Cancelado = 0 And NumContrato = '".$NumContrato."' and FechaOperacion<='".$fecha_corte_sig."' order by NumMov DESC, FechaOperacion limit 1";
                            }else{
                              $sqlHP = "Select * from historicopagos where Cancelado = 0 And NumContrato = '".$NumContrato."'  and FechaCorte>'".$fecha_corte_ant."' and FechaOperacion<='".$fecha_corte_sig."' order by NumMov DESC, FechaOperacion limit 1";

                            }

                           
                           //echo $sqlHP;
                            $rc1 = $Vivienda -> query($sqlHP);
                            $r_count1 = $rc1 -> num_rows;
                            if($r_count1 > 0){
                              while($f1 = $rc1 -> fetch_array()){

                               // echo  $f1['NumMov']."<br>";
                                $RezGts = $f1['NuevoRezGts'];
                                $Rezago_seguros = $f1['NuevoRezSeg'];
                                $Rezago_otros_conceptos = $f1['NuevoRezOtrosGts'];
                                $RezMoratorios = $f1['NuevoRezMoratorios'];
                                $RezFinanc = $f1['NuevoRezFinanc'];
                                $RezCapital = $f1['NuevoRezCapital'];
                                $SaldoCapitalCorrienteAnt = $f1['SaldoCapitalCorriente'];
                                $fecha_abono_ant = $f1['FechaOperacion'];
                                $SaldoExentoAnt = $f1['saldoexento'];
                                //lblfechaultimaoperacion = Format(fecha_abono_ant, "dd/mm/yyyy")
                                if($f1['TipoMov'] == 11 or $f1['TipoMov'] == 12){
                                  mensaje("Es necesario verificar el desglose de la cuenta... ","caja.php");
                                }


                              }
                            }//cierra r_count1
                            else{
                              //si no existe                    
                            
                              if(is_null($f['FechaCorteAnterior'])){
                                //fallo el intento de localizar un registro del corte anterior
                                mensaje("Ocurrio un problema al tratar de localizar el registro historico del movimiento previo",'caja.php');
                              }else{    
                                //determinar la existencia de un registro del periodo previo tomando en cuenta la fecha del vencimiento anterior
                                $sqlHP1 = "Select * from historicopagos where Cancelado = 0 And numcontrato = '".$NumContrato."'  and FechaOperacion <= '".$fecha_corte_ant."' order by nummov DESC, fechaoperacion limit 1";
                              }
                              //echo $sqlHP1;
                              $rc2 = $Vivienda -> query($sqlHP1);
                              $r_count2 = $rc2 -> num_rows;
                              //tomar datos del registro de apertura del periodo actual
                              if($r_count2 > 0){
                                while($f2 = $rc2 -> fetch_array()){

                                  //$date1=date_create($f2['FechaOperacion']);
                                  //$date2=date_create($fecha_corte_ant);
                                  $date1 = new DateTime($f2['FechaOperacion']);
                                  $date2 = new DateTime($fecha_corte_ant);
                                  $diff = $date1->diff($date2);
                                  // will output 2 days
                                  //echo $diff->m . ' months ';
                                  if( ($diff->m)  <= 2){
                                    $RezGts = $f2['NuevoRezGts'];
                                    $Rezago_seguros = $f2['NuevoRezSeg'];
                                    $Rezago_otros_conceptos = $f2['NuevoRezOtrosGts'];
                                    $RezMoratorios = $f2['NuevoRezMoratorios'];
                                    $RezFinanc = $f2['NuevoRezFinanc'];
                                    $RezCapital = $f2['NuevoRezCapital'];
                                    $SaldoCapitalCorrienteAnt = $f2['SaldoCapitalCorriente'];
                                    $fecha_abono_ant = $f2['FechaOperacion'];
                                    $SaldoExentoAnt = $f2['saldoexento'];
                                    //lblfechaultimaoperacion = Format(fecha_abono_ant, "dd/mm/yyyy")
                                    if($f2['TipoMov'] == 11 or $f2['TipoMov'] == 12){
                                      mensaje("Es necesario verificar el desglose de la cuenta... ", "caja.php");
                                    }
                                  }else{
                                    //fallo el intento de localizar un registro del corte anterior
                                    mensaje("Ocurrio un problema al tratar de localizar el registro historico del movimiento previo",'caja.php');
                                  }

                                }
                              }                        

                            }//cierra el si no existe
                            //obtener la suma de los cargos y abonos aplicados durante el periodo actual
                            if (is_null($f['FechaCorteAnterior'])){
                              //fallo el intento de localizar un registro del corte anterior
                              $sql3 = "Select sum(aplicadoexcedente) as adelantocapital, sum(MontoPagoRecibido) as sumaabonos, sum(GtsPeriodo + SegPeriodo + OtrosGtsPeriodo + MoratoriosPeriodo  + FinancPeriodo + CapitalPeriodo) as sumacargos from historicopagos where historicopagos.Cancelado = 0 And historicopagos.numcontrato = '".$NumContrato."' and FechaOperacion <= '".$fecha_corte_sig."'";
                                
                            }else{
                              //determinar la existencia de un registro del periodo previo
                              $sql3 = "Select sum(aplicadoexcedente) as adelantocapital, sum(MontoPagoRecibido) as sumaabonos, sum(GtsPeriodo + SegPeriodo + OtrosGtsPeriodo + MoratoriosPeriodo  + FinancPeriodo + CapitalPeriodo) as sumacargos from historicopagos where historicopagos.Cancelado = 0 And historicopagos.numcontrato = '".$NumContrato."' and FechaCorte > '".$fecha_corte_ant."' and FechaOperacion <= '".$fecha_corte_sig."'";
                            }
                            //echo $sql3;
                            $rc3 = $Vivienda -> query($sql3);
                            $r_count3 = $rc3 -> num_rows;
                            if($r_count3 > 0){
                              while($f3 = $rc3 -> fetch_array()){

                                if(is_null($f3['sumaabonos'])){
                                  $AbonosPeriodo = 0;
                                  
                                }else{  
                                  $AbonosPeriodo = $f3['sumaabonos'];
                                }
                                if(is_null($f3['sumacargos'])){
                                  $CargosPeriodo = 0;
                                }else{
                                  $CargosPeriodo = $f3['sumacargos'];
                                }
                                if(is_null($f3['adelantocapital'])){
                                  $AplicadoExcedente = 0;
                                }else{
                                
                                  
                                  $AplicadoExcedente = $f3['adelantocapital'];
                                }
                              }
                            }else{
                              $CargosPeriodo = 0;
                              $AbonosPeriodo = 0;
                              $AplicadoExcedente = 0;
                            }

                            //determinar: diferencia entre los cargos - la suma de abonos
                            $MontoRestante = $CargosPeriodo - $AbonosPeriodo;
                            if($MontoRestante < 0 ){
                              $MontoRestante = 0;
                            } 
                            //el monto del pago para cubrir los saldos y cerrar la cuenta
                            $MontoSaldar = $SaldoCapitalCorrienteAnt + $SaldoExentoAnt + $RezGts + $Rezago_seguros + $Rezago_otros_conceptos + $RezMoratorios + $RezFinanc + $RezCapital;
                                
                            if($AbonosPeriodo + ($RezGts + $Rezago_seguros + $Rezago_otros_conceptos + $RezMoratorios + $RezFinanc + $RezCapital - $AplicadoExcedente) == 0 ){
                              $rezagootrosperiodos = 0;
                            }else{
                              $rezagootrosperiodos = ($AbonosPeriodo + ($RezGts + $Rezago_seguros + $Rezago_otros_conceptos + $RezMoratorios + $RezFinanc + $RezCapital - $AplicadoExcedente) - $CargosPeriodo);
                            }
                                
                            $minimoacubrir = ($RezGts + $Rezago_seguros + $Rezago_otros_conceptos + $RezMoratorios + $RezFinanc + $RezCapital);
                            
                            if($minimoacubrir < 0){
                              $minimoacubrir = 0;
                            } 
                            
                            if($minimoacubrir == 0){
                                //si la cuenta ha cubierto el adeudo hasta el perido actual
                                //puede ingresar pagos de periodos por adelantado
                                //txtPeriodos.Visible = True
                                //lblPeriodos.Visible = True
                                //lblPeriodos.Caption = "Meses por adelantar de"
                                //Me.lblObservaciones.Visible = True
                            }else{
                              $Periodos = 0;//"Mensualidades de";
                            }

                            if(TipoMonedaPorNumContrato($NumContrato) <> 1 ){
                              //es necesario mostrar la info de montos pero expresado en pesos al tipo de cambio que aplique dependiendo de la fecha
                              
                              $MontoRestantePesos = $MontoRestante * $factormoneda;
                              $MontoSaldarPesos = $MontoSaldar * $factormoneda;
                              $minimoacubrirpesos = $minimoacubirir * $factormoneda;
                            }else{
                              
                              $MontoRestantePesos = $MontoRestante;
                              $MontoSaldarPesos = $MontoSaldar;
                              $minimoacubrirpesos = $minimoacubirir;
                            }
                          }//estatus cuenta 1
                        }//ciera si no esta bloqueada
                      }//cierra while
                    }else{//count de control contratos
                      mensaje('Ocurrio un problema al tratar de localizar el registro de control del contrato','caja.php');
                  }
                  

                                  
                  $datosdes = buscaDescuento($NumContrato,$nitavu);
                  if($datosdes!='FALSE')
                  {     
                  
                  $datosdes = explode("_", $datosdes);     
                  $DescuentoAutorizado=$datosdes[0];
                  $minimo=$datosdes[1];
                  $Tipo_descuento=$datosdes[2];
                  $IdMovDesc=$datosdes[3];;
                  $sustento=$datosdes[4];
                  $BandAplicaDesc=1;
                  
                  }else 
                  {
                  $DescuentoAutorizado=0;
                  $minimo=0;
                  $Tipo_descuento=0;
                  $IdMovDesc=0;
                  $Observaciones='';
                  
                  }

?>