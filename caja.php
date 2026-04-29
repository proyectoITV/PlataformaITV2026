<?php
    include ("lib/body_head.php");
    // include ("lib/body_menu.php");
    //No tiene menu vertical
?>
<script>

</script>

<?php
set_time_limit(72000) ;
error_reporting(0); //<-- para simular produccion
require_once("var_clean.php");
$id_aplicacion ="caja"; $nivel = aplicacion_nivel($id_aplicacion, $nitavu);
$nivel =aplicacion_nivel($id_aplicacion, $nitavu);

if (sanpedro($id_aplicacion, $nitavu)==TRUE){

 
    echo "<div id='AppDetalle'>".app_detalle($id_aplicacion, $nitavu)."</div>";        
    echo "<input type='hidden' id='nitavu' name='nitavu' value='".$nitavu."'>";

    if(isset($_GET['NumContrato']) and isset($_GET['OriginData']))
    // if(isset($IdDelegacion) and isset($IdPrograma) and isset($_GET['OriginData']) and isset($_GET['NumContrato']) and isset($Folio))
    {
      /******************************************************************************/
      //variables Necesarias
      $NumContrato = VarClean($_GET['NumContrato']); //
      $OriginData = VarClean($_GET['OriginData']); //      

      //Calcular en base a las Variables
      $IdDelegacion = NumContrato_IdDelegacion($NumContrato, $OriginData);
      $IdPrograma = NumContrato_IdPrograma($NumContrato, $OriginData);
      $Folio = NumContrato_Folio($NumContrato, $OriginData);
      
      // echo "IdDelegacion: ".$IdDelegacion."<br>";
      // echo "IdPrograma: ".$IdPrograma."<br>";
      // echo "Folio: ".$Folio."<br>";

      if($NumContrato<>''){
        echo "<input type='hidden' id='Tipo' name='Tipo' value='2'>";
      }else{
        echo "<input type='hidden' id='Tipo' name='Tipo' value='1'>";
      }

      $montoDesc=0;
      $minimo=0;
      $descipcionMov=0;
      $campaña = RevisaCampaña();
      
      $entro="FALSE";
      $opcion=1;
      $cuentaAlCorreiente='FALSE' ;
      $solicitudEvaluada=0;
      echo "<input type='hidden' id='IdPrograma' name='IdPrograma' value='".$IdPrograma."'>";
      echo "<input type='hidden' id='NumContrato' name='NumContrato' value='".$NumContrato."'>";
      echo "<input type='hidden' id='campaña' name='campaña' value='".$campaña."'>";
      
      $BhayDescuento=0;
      /******************************************************************************/

      $ContratoCancelado = ContratoCancelado($NumContrato, $IdDelegacion,$IdDelegacion);
      // var_dump($ContratoCancelado);

      if(ContratoCancelado($NumContrato, $IdDelegacion,$IdDelegacion)==1)
        {
          
          mensaje( "Imposible continuar el contrato esta marcado como cancelado.","caja.php");
        }
        else
        {  
          $solicitudEvaluada=estatusEvaluaciondeSolicitud($IdPrograma, $IdDelegacion, $Folio);
         

          if($solicitudEvaluada!=1)
          {
            mensaje('Imposible continuar la solcicitud no esta evaluada.','caja.php');
            return;
          }
          $IdSolicitante = buscarIdSolicitante($IdPrograma, $IdDelegacion, $Folio);
          $ahorroPrevio = totalAbonadoenAhorroPrevio($IdDelegacion, $IdPrograma, $Folio);
          $saldo = saldoCuenta($IdDelegacion, $IdPrograma, $Folio);
          if($NumContrato != ''){
            $MontoPago=MontoPagoNumContrato($NumContrato);
          }else{
            $MontoPago=0;
          }
          //$saldoContrato = UltimoSaldoDelContrato($NumContrato);

          /*******************DATOS RECIBO***********************************/

          if(isset($_GET['DatosRecibo']))
          {
            echo "<div id='contenedorRecibo'  style='margin-top: 50px;'>";  			
              echo "<div>";
                echo "<iframe id='framerecibo' name='framerecibo' src='formatoRecibo2.php?DatosRecibo=".$_GET['DatosRecibo']."&IdDelegacion=".$IdDelegacion."&IdPrograma=".$IdPrograma."&Folio=".$Folio."' style='width:100%; height:100%; border:0; border:none;'>Tu navegador no soporta iframes...</iframe>";
              echo "</div>";
            echo "</div>";  
             /*******************************************************************/
          }
          else 
          {
            echo '<div class="container-fluid" style="margin-top: 50px;">'; //CONETENDOR PRINCIPAL
              echo '<div id="respuesta"></div>';
              echo '<div class="row" id="row1">';

                echo '<div  id="DatosBeneficiario" style="background:#898888; width:30%; height:200px; text-align:center;">';                   
                  echo "<center>";
                    echo "<table style='color: white; width:80%; margin-top: 30px;'>";                   
                      echo '<tr><td><span class="font-weight-bold" data-toggle="tooltip" data-placement="top" title="Nombre del beneficiario">'.nombreBeneficiarioVivienda($IdSolicitante).'</span></td></tr>';
                      echo "<tr><td><span class='font-weight-bold' data-toggle='tooltip' data-placement='top'  title='CURP del Beneficiario'>".curpBeneficiarioVivienda($IdSolicitante)."</span></td></tr>";
                      echo "<tr><td><span class='font-weight-bold' data-toggle='tooltip' data-placement='top'  title='Domicilio del Beneficiario'>".domicilioINEVivienda($IdDelegacion,$IdPrograma,$Folio)."</span></td></tr>";
                      echo "<tr><td><span class='font-weight-bold' data-toggle='tooltip' data-placement='top'  title='Teléfono del Beneficiario'>".telefonoBeneficiarioVivienda($IdDelegacion,$IdPrograma,$Folio)."</span></td></tr>";
                    echo "</table>";
                  echo "</center>";                    
                echo '</div>';  //CIERRE DATOS BENEFICIARIO

                echo '<div id="DatosCuentaSuperior" style="background:#fff; width:70%; height:200px;">';
                echo "<center>";
                    echo '<b><p class="h1" style="color:#484848; padding: 0px; margin-top: 30px;">Programa: '.nombreProgramaVivienda($IdPrograma).'</p>';
                    echo '<p class="h5" style="color:#484848; padding: 0px;">Folio: '.$Folio.'</p>';
                    if($NumContrato!='')
                    {
                     echo '<p class="h5" style="color:#484848; padding: 0px;">Contrato: '.$NumContrato.'</p></b>';
                    }
                echo "</center>";
                echo '</div>'; //CIERRE DATOS CUENTA SUPERIOR
                
                ///echo '<div class="row" id=row2>';
                /************************RESUMEN DE LE CUENTA*********************************/
                  echo '<div style="background:#fff; width:30%;">'; 
                    echo "<br>";                    
                      echo "<center>";           
                        echo "<table style='width:90%'>";
                        echo "<tr>";
                        echo "<td colspan='2' style='text-align: center;'><b>RESUMEN DE LA CUENTA</b></td>";
                        echo "</tr>";
                        echo "<tr>";
                        echo "<td><b><span class='etiqueta-etiqueta principal normal'>Monto de Ahorro</span></b></td>";
                        echo "<td style='text-align: right;'>$ ".number_format(MontoAhorroDatosEvaluacion($IdDelegacion,$IdPrograma,$Folio), 2)."</td>";
                        echo "</tr>";
                        echo "<tr>";
                        echo "<td><b><span class='etiqueta-etiqueta principal normal'>Tiempo de Ahorro</span></b></td>";
                        echo "<td style='text-align: right;'>".TiempoAhorroDatosEvaluacion($IdDelegacion,$IdPrograma,$Folio)."</td>";
                        echo "</tr>";                   
                        echo "<tr>";
                        echo "<td><b><span class='etiqueta-etiqueta principal normal'>Mensualidad</span></b></td>";
                        echo "<td style='text-align: right;'>$ " . number_format(MensualidadDatosEvaluacion($IdDelegacion,$IdPrograma,$Folio), 2)."</td>";
                        echo "</tr>";
                        echo "<tr>";
                        echo "<td><b><span class='etiqueta-etiqueta principal normal'>N° de Pagos</span></b></td>";
                        echo "<td style='text-align: right;'> " .TotalPagosDatosEvaluacion($IdDelegacion,$IdPrograma,$Folio)."</td>";
                        echo "</tr>";
                        echo "<tr>";
                        echo "<td></td>";
                        echo "<td style='text-align: right;'></td>";
                        echo "</tr>";
                        echo "</table>";
                      echo "</center>";
                  echo '</div>';
                  /************************ FIN RESUMEN DE LE CUENTA*********************************/
                  $RezGts = 0;
                    $Rezago_seguros = 0;
                    $Rezago_otros_conceptos = 0;
                    $RezMoratorios = 0;
                    $RezFinanc = 0;
                    $RezCapital = 0;
                    $SaldoCapitalCorrienteAnt = 0;
                    $fecha_abono_ant = 0;
                    $SaldoExentoAnt = 0;
                    $fecha_corte_sig = 0;
                    $factormoneda=0;  
                    $MontoSaldar=0;
                    $minimoacubrir=0;
                  if($NumContrato!='')               
                  {                    
                    include("./determinamontos.php");
                    //incluimos los querys de analiza campaña
                    include("./analizaCampaña.php");
  
                    if((string)$minimoacubrir>0)
                    {
                      $cuentaAlCorreiente='FALSE' ;
                    }else{
                      $cuentaAlCorreiente='TRUE' ;
                    }

                   

                     // valida fecha actual y fecha proximo corte
                    $fechaActual = date("Y-m-d");                  
                    if(($fechaActual>isset($fecha_corte_sig)) &&  $NumContrato!='')
                      {
                        mensaje('No puede tratar de ingresar un pago con fecha posterior a la del proximo corte','caja.php');
                      }else if(($fechaActual<isset($fecha_abono_ant)) and $NumContrato!='')
                      {
                        mensaje('No puede tratar de ingresar un pago con fecha anterior a la del ultimo abono registrado','caja.php');
                      }
                      else
                      {                 
                        //Busca si existe un descuento en la cuetna
                        $datosdes = buscaDescuento($NumContrato,$nitavu); 
                        $DescuentoAutorizado=0;  
                        $TipoDescuento =0;             
                        if($datosdes!='FALSE' AND !isset($_GET['m']))
                          {                        
                            $datosdes = explode("_", $datosdes);     
                            $DescuentoAutorizado=$datosdes[0];
                            $minimo=$datosdes[1];
                            $TipoDescuento = $datosdes[2];
                            $descipcionMov=$datosdes[3];
                            $BhayDescuento = 1;

                            mensaje("El contrato tiene autorizado(a) un(a) :<b>".TipoMovimiento($descipcionMov)."</b>".
                            "<br>*La cajera debera introducir : $ " .($DescuentoAutorizado + $minimo). "<br>* El(la)" .TipoMovimiento($descipcionMov). " será de : $ ".$DescuentoAutorizado.  "<br>* La persona pagara : $ " . $minimo. " <br>*** En caso de liquidación aún falta restar el descuento de capital.***",$_SERVER["REQUEST_URI"]."&m=1");

                          }
                          echo "<input type='hidden' name='DescuentoAutorizado' id='DescuentoAutorizado' value='".$DescuentoAutorizado."'>";
                          echo "<input type='hidden' name='TipoDescuento' id='TipoDescuento' value='".$TipoDescuento."'>";
                      }
           
                  }

                  // MOSTRAMOS SI ESTA SALDADA LA CUENTA
                 // echo 'MONTO RESTANTE----'.$MontoSaldar;
                 if($NumContrato!='')
                 {  
                  if($MontoSaldar <= 0  ){
                    echo '<div id="modal_oscuro">';
                        echo '<div id="mensaje">';
                        echo '<p>Esta cuenta esta liquidada.</p>';
                            echo "<center><table><td>";
                                echo '<a class="Mbtn btn-default" href="caja.php">Aceptar</a>';
                            echo "</td>";
                            echo "</table></center>";
                        echo '</div>';
                    echo '</div>';
                  }
                }

                  echo '<div style="width:70%; height:100%;">';                    
                    echo '<center>';
                      if(($cuentaAlCorreiente=='TRUE' and $NumContrato!='') and !isset($_GET['m']) and $DescuentoAutorizado==0) 
                      {
                        $entro="true";
                        /*DIV DE BOTONES */
                        echo '<div id="divOpciones" style=" width:100%; height:100%; padding:10px;">'; 
                        echo '<br>';                 
                        echo "<table  style='width:100%; text-align:center;' >";
                        echo "<tr>";
                        echo "<td>";
                        echo "<button type='button' id='pagoNormal' name='pagar' class='btn btn-primary' style='width:65%' 
                            onclick='MuestaDatosPagoNormal()'  >Pagar</button>";
                        echo "</td>";
                        echo "</tr>";
                        echo "<tr>";
                        echo "<td>";
                        echo "<button type='adelantaMenusalidad' id='pagar' name='adelantaMenusalidad' class='btn btn-primary' style='width:65%' 
                              onclick='AdelantarPagos()'  >Adelantar Mensualidad</button>";
                        echo "</td>";
                        echo "</tr>";
                        // echo "<tr>";
                        // echo "<td>";
                        // echo "<button type='button' id='abonarCapital' name='abonarCapital' class='btn btn-primary' style='width:65%' 
                        //        onclick='AbonarACapital()'  >Abonar a Capital</button>";
                        // echo "</td>";
                        // echo "</tr>";
                        echo "</table>"; 
                        echo '</BR>';                                     
                        echo '</div>';
                      }
                    
                     
                      echo  '<div id="DatosPagoNormal" style="inline-block; width:100%; ">';
                      /*DIV IZQUIERDO MUESTRA LA INFORMACION FINANCIERA DE LA CUENTA */
                      if($NumContrato!='')
                      {  
                        echo '<div style="display:inline-block; width:40%; height:100%; padding:10px;">';  
                        echo "<table class='tabla'  style='font-size:10pt; margin-top: 40px; border: 1px dashed #d9d9d9;'>";
                        echo "<tr>"; 
                        echo "<td colspan='2' align='center'><b>INFORMACIÓN FINANCIERA DE LA CUENTA</b></td>"; 
                        echo "</tr>"; 
                        echo "<tr>"; 
                        echo "<td>Recepción de pagos</td>";               
                        echo "<td>".date_format( date_create($fecha_corte_ant), 'd/m/Y')."  -  ".date_format( date_create($fecha_corte_sig), 'd/m/Y')."</td>";
                        echo "</tr>";
                        echo "<tr>"; 
                        echo "<td>Ultimo pago</td>";               
                        echo "<td>".date_format( date_create($fecha_abono_ant), 'd/m/Y')."</td>";
                        echo "</tr>";
                        /*  echo "<tr>"; 
                        echo "<td>IdLote</td>";               
                        echo "<td></td>";
                        echo "</tr>";
                        echo "<tr>";
                        echo "<td>IdMandanante</td>";               
                        echo "<td></td>";
                        echo "</tr>"; */
                        echo "</table>";                 
                        
                        echo "<table class='tabla_punteada tabla'  style='font-size:10pt; margin-top: 40px; border: 1px dashed #d9d9d9;'>";
                        echo "<tr>"; 
                        echo "<td>Rezago de periodos previos</td>";               
                        echo "<td>".$rezagootrosperiodos."</td>";
                        echo "</tr>"; 
                        echo "<tr>";               
                        echo "<td>Cargos del periodo actual</td>"; 
                        echo "<td>".$CargosPeriodo."</td>"; 
                        echo "</tr>";
                        echo "<tr>";               
                        echo "<td>Abonado en periodo actual</td>"; 
                        echo "<td>".$AbonosPeriodo."</td>"; 
                        echo "</tr>";
                        echo "<tr>";               
                        echo "<td>Monto por cubrir del periodo</td>"; 
                        echo "<td>".$MontoRestante."</td>"; 
                        echo "</tr>";
                        echo "<tr>";               
                        echo "<td>MONTO EN PESOS</td>"; 
                        echo "<td>".$MontoRestantePesos."</td>"; 
                        echo "</tr>";
                        echo "<tr>";               
                        echo "<td>Minimo para evitar Mora</td>"; 
                        echo "<td>".$minimoacubrir."</td>"; 
                        echo "</tr>";
                        echo "<tr>";               
                        echo "<td>MONTO EN PESOS</td>"; 
                        echo "<td>".$minimoacubrirpesos."</td>"; 
                        echo "</tr>";
                        echo "<tr>";               
                        echo "<td>Monto para cubrir saldo total</td>"; 
                        echo "<td>".$MontoSaldar."</td>"; 
                        echo "</tr>";
                        echo "<tr>";               
                        echo "<td>MONTO EN PESOS</td>"; 
                        echo "<td><input type='hidden' name='MontoSaldarPesos' id='MontoSaldarPesos' value='".$MontoSaldarPesos."'>".$MontoSaldarPesos."</td>"; 
                        echo "</tr>";
                        echo "</table>"; 
                        echo '</div>';
                      }

                       /*DIV DERECHO MUESTRA LOS DATOS PARA RECIBIR EL PAGO */
                      echo '<div style="display:inline-block; width:60%; height:100%; padding:10px;">'; 
                        echo '<center>';
                          echo "<table  class='tablacaja'>";
                          echo "<tr>";
                          echo "<td colspan='2' style='text-align: center;'><b>";
                          $diassemana = array("Domingo","Lunes","Martes","Miercoles","Jueves","Viernes","Sábado");
                          $meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
                          echo strtoupper($diassemana[date('w')]." ".date('d')." de ".$meses[date('n')-1]. " del ".date('Y')) ;
                          echo "</b></td>";
                          echo "</tr>";

                          if($NumContrato!='')                
                          {  
                          if($estatusCuenta==3  and $nivel=='2') {
                            echo "<tr>";
                              echo "<td></td>";
                              echo "<td><input type='date' name='fecha' id='fecha'><div id='resp'></div></td>";
                              echo "<td style='width:200px; text-align: center;'>";
                              echo "<button class='btn btn-info' onclick='cerrarPeriodo(".$IdDelegacion.", ".$IdPrograma.", ".$Folio.",\"".$NumContrato."\")' >Cerrar periodo</button>";
                              echo "</td>";
                            echo "</tr>";                            
                          }                            
  
                            echo "<tr>";
                            echo "<td><span class='etiqueta-etiqueta principal normal'><b>Concepto a cobrar:</b></span></td>";
                            echo "<td style='text-align: left;'>";                         
                            echo "<div id='colonia' name='colonia' style='width:100%;' >";
                            echo "<select id='cboxcargos' name='cboxcargos'  style='margin-left: 0px;'  >";
                            echo MuestraCargos($NumContrato);
                            echo "</select>";
                            echo "</td>";
                            echo "</tr>";

                          
                          }
                            /*PERIODOS ADELENTAR*/
                            echo "<tr style='visibility: hidden' id='trPeriodos'>";
                            echo "<td><b><span class='etiqueta-etiqueta principal normal'>Periodos a adelantar:</span></b></td>";
                            echo "<td style='text-align: right;'>";                          
                            echo "<input name='txtPeriodos' id='txtPeriodos' onkeyup='adelantarPeriodos()' type='number' placeholder='0'  class='form-control'>";                          
                            echo "</td>";
                           
                            echo "</tr>";

                         
                            echo "<tr>";
                            echo "<td></td>";
                            echo "<td>";                                             
                            echo "</td>";
                            echo "</tr>";
  
                          
  
                          echo "<tr>";
                          echo "<td><b><span class='etiqueta-etiqueta principal normal'>Cantidad a pagar:</span></b></td>";
                          echo "<td style='text-align: right;'>";
                          // onkeypress='validacionesAntesdePagar();' 
                          if($NumContrato != ''){
                            echo "<input id='cantidad' name='cantidad'  onkeypress='LostFocusImporte();' onchange='MASK(this,this.value,\"$##,###,##0.00\",1);'  class='form-control' style='text-align: right; FONT-WEIGHT: bold;' placeholder='0.00'>"; 
                          }else{
                            echo "<input id='cantidad' name='cantidad'  onchange='MASK(this,this.value,\"$##,###,##0.00\",1);'  class='form-control' style='text-align: right; FONT-WEIGHT: bold;' placeholder='0.00'>"; 

                          }
                          echo "</td>";
                          echo "</tr>";
                          echo "<tr>";
                          echo "<td><b><span class='etiqueta-etiqueta principal normal'>Forma de pago:</span></b></td>";
                          echo "<td style='text-align: right;'>";                  
                          echo "<select  class='form-control' name='formapago' id='formapago'>"; 
                          
                          $sql  = "Select * From catformapago where IdFormaPago>0";
                          $rc = $Vivienda -> query($sql);
                          while($f = $rc -> fetch_array())
                          {
                              echo "<option value=".$f['IdFormaPago'].">".$f['FormaPago']."</option>";
                          }
                          echo "</select>";
                          echo "</td>";
                          echo "</tr>";                   
                          echo "<tr>";
                          echo "<td><b><span class='etiqueta-etiqueta principal normal'>Referencia de pago:</span></b></td>";
                          echo "<td style='text-align: right;'>";                          
                          echo "<input name='referencia' id='referencia' type='text' placeholder='...'  class='form-control'>";                          
                          echo "</td>";
                          echo "</tr>";
                       
                          //if($NumContrato!='')
                          //{
                          //if( $MontoSaldarPesos > 0)
                        // if(isset($MontoSaldarPesos)<=0)
                         // {
                          echo "<tr>";
                         
                            echo "<td colspan='2'  style='text-align: right;'><button type='button' id='pagar' name='pagar' class='btn btn-primary' style='width:65%' 
                            onclick='ingresaPago(".$IdDelegacion.", ".$IdPrograma.", ".$Folio.",\"".$NumContrato."\")'  >Pagar</button></td>";               
                            echo "</tr>";
                          
                        //  }
                        //}
  
                        
                        /* if($saldo <> 0 and  $NumContrato==''){
                              echo "<tr>";
                              echo "<td style='text-align: right;'>";
                              echo '<div class="form-check">
                                  <input type="checkbox" class="form-check-input" id="check" name="check" onclick="activarInputs();">
                                  <label style="margin-top: 0px;" class="form-check-label" for="materialUnchecked">Abonar</label>
                              </div>';
                              echo "</td>";
                              echo '<td  style="text-align: right;">';
                              echo "<span class='font-weight-light'>NOTA: Esta cuenta ya cumplió con su ahorro.</span>";
                              
                              echo '</td>';               
                              echo "</tr>";
                          }else {
                              echo "<tr>";
                              echo "<td>";
                              echo "</td>";
                              echo '<td  style="text-align: center;">';
                              echo "<span class='font-weight-light'>NOTA: Esta cuenta esta liquidada.</span>";
                              echo '</td>';               
                              echo "</tr>";
                          }*/
                            
                          echo "</table>";                           
                        echo '</center>';                                     
                       echo '</div>';
                       

                        /*DIV INFERIOR MUESTRA EL PAGO Y EL DESCUENTO */
                       if($NumContrato!='')                
                       {                         
                          echo '<div id="descuentosAut" style="width:100%;" >';
                            echo "<div id='sinCalculos' style='display:inline-block; width:100%'>";
                              echo '<center>';  
                              echo "<table style='width:100%; font-weight: bolder;'>"; 
                              echo "<tr>";      
                              echo "<td align='center'>"; 
                              echo "<label>Su pago</label>";
                              echo "<br><label style='font-weight: bolder;' class='h5' id='lblPago' name='lblPago' >0</label>";
                              echo "</td>"; 
          
                              echo "<td align='center'>";   
                              echo "<label>Descuento</label>";
                              echo "<br><label  style='font-weight: bolder;' class='h5' id='lblDescuento' name='lblDescuento' >0</label>";
                              echo '</td>'; 
                              
                              echo "<td align='center'>";  
                              echo "<label>Total</label>";
                              echo "<br><label style='font-weight: bolder;' class='h5' id='lblTotal' name='lblTotal' >0</label>"; 
                              echo "</td>";       
                              echo "</tr>";
                              echo "</table>"; 
                              echo '</center>'; 
                            echo "</div>"; 
                          echo '</div>';  
                       } 
                       if($entro=="true")
                       {
                        echo "<script>$('#DatosPagoNormal').css({'display':'none'});</script>";
                    
                       }
                      echo '</div>';

                      if($NumContrato != ''){

                      //PROGRAMACION DE LA VALIDACION AL MOMENTO DEL IMPORTE.
                      $TipoPago_1Liq_2Desc_3MensFree=0;
                      $EstatusCuenta = ObtenerIdEstatusCuenta($NumContrato);
                      $vMontoAhorrado=0;
                      $AhorroPorCubrir=0;
                      echo "<input type='hidden' name='EstatusCuenta' id='EstatusCuenta' value='".$EstatusCuenta."'>";

                      $saldoMoratorio = Saldo_MoratorioViviendaIF($NumContrato);
                      $saldo = SaldoViviendaIF($NumContrato) ;
                      echo "<input  type='hidden' name='haydescuento' id='haydescuento' value='".$BhayDescuento."'>";
                      $sql = "SELECT IdPagoInicial, MontoPagoInicial from datosevaluacion where iddelegacion=".$IdDelegacion." and idprograma<>46 and idprograma=".$IdPrograma." and Folio=" .$Folio."";
                      $r= $Vivienda -> query($sql);
                      while($f = $r -> fetch_array()){
                        if($f['IdPagoInicial'] == 10){
                          //reviso si hay un pago ya en la cuenta y si ya esta pagado}
                          $sql ="SELECT sum(montopagorecibido) as ahorropagado from historicopagos where  TipoMov in (13,19) AND  cancelado=0 and  HISTORICOPAGOS.NumContrato='".$NumContrato."'";
                          $r= $Vivienda -> query($sql);
                          while($f = $r -> fetch_array()){
                            if(is_null($f['ahorropagado'])){
                              $vMontoAhorrado = 0;
                            }else{
                              $vMontoAhorrado = $f['ahorropagado'];   
                            }
                            $vMontoMinimo = $f['MontoPagoInicial'] - 24750;
                            if($f['MontoPagoInicial'] > $vMontoAhorrado){
                              $BanMuestraConceptoAhorro = 1;
                              $AhorroPorCubrir = $f['MontoPagoInicial'] - $vMontoAhorrado;
                            }else{
                              $BanMuestraConceptoAhorro = 0;
                            }
                          }
                        }
                      } 
                     
                      echo "<input type='hidden' name='vMontoAhorrado' id='vMontoAhorrado' value='".$vMontoAhorrado."'>";
                      echo "<input type='hidden' name='AhorroPorCubrir' id='AhorroPorCubrir' value='".$AhorroPorCubrir."'>";
                      echo "<input type='hidden' id='TipoPago_1Liq' name='TipoPago_1Liq' >";                       
                      echo "<input type='hidden' id='BCampActiva' name='BCampActiva' >"; 
                      
                    }
                    
                    echo '</center>';
                  echo '</div>';

                //echo '</div>'; //CIERRE ROW2

              echo '</div>'; //CIERRE ROW
            echo '</div>'; //CIERRE CONTENEDOR PRINCIPAL             
            
          }
        }   
    }
    else
    {
         //BARRA DE BUSQUEDA
         echo "<div style='
         background-color:#e6e3e1; width: 100%; padding-top: 50px; padding-bottom: 13px; margin-top: 30px;'>
         <form action='v001.php' method='GET'><table width=100%><tr><td width=90%>";
         echo "<input style=' height: 65px; border-radius: 5px; font-size: 18pt; font-family: Light; margin-left: 12px; padding: 10px; margin-right: 20px;
         'type='text' name='search' id='search' placeholder='Ingrese nombre del beneficiario o número de contrato' id='txtBeneficiario'>";
         echo "</td><td>
         <button type='submit' class='Mbtn btn-Success' id='indicaciones2' style='font-size: 8pt; width: 100%; height: 60px; margin-top: 0px;' onclick='v001.php'>    <img src='icon/buscar2.png' style='width:40px;'>
         </button></td></tr></table></form>
         </div>"; 
    }
} else {mensaje("ERROR: no tienes acceso a este modulo","");}


?>
<script type="text/javascript">

// $(document).ready( function() {

// 	$('body').keydown( function(e) {
//     switch(e.which){
//       case 13:	// Enter, use of Function in button
//         $(':focus')[0].name == 'cantidad' ? validacionesAntesdePagar() : ''
//       break;
//       default:
//       break;
//     }
//   });	

/*
  valor = obtenerValorParametro("NumContrato");  

  if (valor){
      $("#DatosPagoNormal").css({'display':'inline-block'});
      if(obtenerValorParametro("m"))
      {
         $("#divOpciones").css({'display':'none'});
      }
     
  }*/
 /* $("#cantidad").keypress(function(){
    validacionesAntesdePagar();
  });*/
  
//});

function LostFocusImporte(){
  var IdPrograma = document.getElementById('IdPrograma').value;
  var Importe = document.getElementById('cantidad').value;
  var Cargo = document.getElementById('cboxcargos').value;
  var MontoSaldarPesos = document.getElementById('MontoSaldarPesos').value;
  var nitavu = document.getElementById('nitavu').value;
  var NumContrato = document.getElementById('NumContrato').value;
  var campaña = document.getElementById('campaña').value;
  var BHayDescuento = document.getElementById('haydescuento').value;
  var TipoPago_1Liq_2Desc_3MensFree = 0;
  var DescuentoAutorizado = document.getElementById('DescuentoAutorizado').value;
  var vMontoDescuentoCapital = document.getElementById('vMontoDescuentoCapital').value;
  var BIdMandante = document.getElementById('BIdMandante').value;
  var vTiempo = document.getElementById('vTiempo').value;
  var BSinAtrasoAnual = document.getElementById('BSinAtrasoAnual').value;
  var Tipo_descuento = document.getElementById('TipoDescuento').value;
  var vMontoAhorrado = document.getElementById('vMontoAhorrado').value;
  var AhorroPorCubrir = document.getElementById('AhorroPorCubrir').value;
  var EstatusCuenta = document.getElementById('EstatusCuenta').value;

  if(campaña != 'FALSE'){
    var BCampActiva = 1;
  }else{
    var  BCampActiva = 0;
  }

  var Desc = 0;
  var txtDescuento = 0;
  var txtTotal = 0 ;
  //ACCIONES QUE ESTABAN EN EL LOST FOCUS DE IMPROTE
  //si esta en algun cargo de esos  no puede cobrar como si fuera campaña, debe ser un pago normal
  if(IdPrograma == 240 || Cargo == 50 || Cargo == 51 || Cargo == 53 || Cargo == 48 || Cargo == 49 || Cargo == 53 || Cargo == 92 || Cargo == 94 || Cargo == 96 || Cargo == 71 || Cargo == 36 || Cargo == 53 || Cargo == 49 || Cargo == 38){
    BCampActiva = 0;
      
  }

  if(BCampActiva ==1){
    //revisa que descuento obtiene con la cantidad registr
    if(Importe >= MontoSaldarPesos && Cargo != 10){
    // nuevo periodo de campaña, liquidación autorizada por delegados
    // revisar si hay un descuento autorizado por delegado
           
    
      if (BhayDescuento == 1){
        TipoPago_1Liq_2Desc_3MensFree = 1;
        vMontoARecibirCaja = saldo - (DescuentoAutorizado + vMontoDescuentoCapital);
        if (BIdMandante > 0){
          Npush("Con esta cantidad podra liquidar su cuenta con los siguientes beneficios * Descuento de moratorios AUTORIZADO : $ " + DescuentoAutorizado + "* Una BONIFICACION  de : $ " + vMontoDescuentoCapital + " (No Aplica. MANDANTES) * La persona pagara : $ " + vMontoARecibirCaja + "" , 'Plataforma ITAVU' );
        }else{
          Npush("Con esta cantidad podra liquidar su cuenta con los siguientes beneficios * Descuento de moratorios AUTORIZADO : $ " + DescuentoAutorizado + "* Una BONIFICACION  de : $ " + vMontoDescuentoCapital + " * La persona pagara : $ " + vMontoARecibirCaja + "", "Plataforma ITAVU");
        }
        Desc = vMontoDescuentoCapital + DescuentoAutorizado;
        txtDescuento = vMontoDescuentoCapital + DescuentoAutorizado;
        txtTotal = Importe - txtDescuento;
      }else{
        // revisa si es mandante y no tiene moratorios no envia mensaje 
        if (saldoMoratorio > 0){        
          Npush("Se detectó que intenta liquidar esta cuenta, Es necesario que el deudor se presente ante el Delegado para un posible beneficio", "Plataforma ITAVU");
          TipoPago_1Liq_2Desc_3MensFree = 0;
        }else{
          //Se revisa que no sea de mandante para aplicacion del 10% de capital a cuentas sin mandante
          if (BIdMandante == 0){
            Npush("Se detectó que intenta liquidar esta cuenta. Es necesario que el deudor se presente ante el Delegado para un posible beneficio" , "Plataforma ITAVU");
            TipoPago_1Liq_2Desc_3MensFree = 0; 
          }else{
            BCampActiva = 0;
          }
        }
      }
    }else{
      //meses
      if(vTiempo > 120 && vTiempo < 1000 ){
        TipoPago_1Liq_2Desc_3MensFree = 2;
        vPorcMoraDesc = 50;
        vMontoDescuentoMoratorio = saldoMoratorio / 2;
        txtDescuento = vMontoDescuentoMoratorio;
        vMontoDescuentoMora = vMontoDescuentoMoratorio;
        Importe = Importe + vMontoDescuentoMoratorio;
        Npush("AVISO AL BENEFICIARIO. Comunicarle a la persona que le aplicara un descuento del 50% de Moratorios " + vMontoDescuentoMoratorio + "","Plataforma ITAVU");
      }else{
        if(vTiempo > 0 && vTiempo <= 120 && BSinAtrasoAnual == 0 && Cargo != 10 && vTiempo == 8000 ){
          TipoPago_1Liq_2Desc_3MensFree = 2;
          vPorcMoraDesc = 100;
          vMontoDescuentoMoratorio = saldoMoratorio;
          vMontoDescuentoMora = vMontoDescuentoMoratorio;
          txtDescuento = vMontoDescuentoMoratorio;
          Importe = Importe + vMontoDescuentoMoratorio;
          Npush("AVISO AL BENEFICIARIO. Comunicarle a la persona que le aplicara un descuento del 100% de Moratorios " + vMontoDescuentoMoratorio + "", "Plataforma ITAVU");
        }else{
          if(vTiempo == 1000 && BSinAtrasoAnual == 0 && Cargo != 10 && Tipo_descuento == 125){
            TipoPago_1Liq_2Desc_3MensFree = 2;
            vMontoDescuentoMora = DescuentoAutorizado;
            // mismo procedimiento que tiempo regular
            if(DescuentoAutorizado > 0){
              if(Importe > (MinimoRequiereAbonar + DescuentoAutorizado)){
                txtDescuento = DescuentoAutorizado;
                BandAplicaDesc = 1;
              }else{
                cDiferencia = (Importe - (MinimoRequiereAbonar + DescuentoAutorizado));
                if(cDiferencia > -1 && cDiferencia < 1){
                  txtDescuento = DescuentoAutorizado;
                  BandAplicaDesc = 1;
                }else{
                  suma = MinimoRequiereAbonar + DescuentoAutorizado;
                  Npush("Hay un descuento autorizado por " + DescuentoAutorizado + ", pero se requiere un pago de por lo menos " + suma + " para activarlo", "Plataforma ITAVU");
                  txtDescuento = 0;
                  BandAplicaDesc = 0;
                }
              }
            }else{
              txtDescuento = 0;
            }
            txtTotal = Importe - txtDescuento;  
          }else{                  
            if(BSinAtrasoAnual == 1 && Cargo != 10){
              TipoPago_1Liq_2Desc_3MensFree = 3;
            }else{
              if(vTiempo == 2000 && Cargo == 10){
                TipoPago_1Liq_2Desc_3MensFree = 4;
                //mismo procedimiento que tiempo regular
                if(DescuentoAutorizado > 0){
                  if(Importe > (MinimoRequiereAbonar + DescuentoAutorizado)){
                    txtDescuento = DescuentoAutorizado;
                    BandAplicaDesc = 1;
                  }else{
                    cDiferencia = (Importe - (MinimoRequiereAbonar + DescuentoAutorizado));
                    if(cDiferencia > -1 && cDiferencia < 1){
                      txtDescuento = DescuentoAutorizado;
                      BandAplicaDesc = 1;
                    }else{
                      suma = MinimoRequiereAbonar + DescuentoAutorizado;
                      Npush("Hay un descuento autorizado por " + DescuentoAutorizado + ", pero se requiere un pago de por lo menos " + suma + " para activarlo", "Plataforma ITAVU");
                      txtDescuento = 0;
                      BandAplicaDesc = 0;
                    }
                  }
                }else{
                  txtDescuento = 0;
                }
                txtTotal = Importe - txtDescuento;
              }else{
                BCampActiva = 0;
              }                 
            }           
          }      
        }
      }
    }
  }else{
    if(DescuentoAutorizado > 0){
      if(Importe > (MinimoRequiereAbonar + DescuentoAutorizado)){
        txtDescuento = DescuentoAutorizado;
        BandAplicaDesc = 1;
      }else{
        cDiferencia = (Importe - (MinimoRequiereAbonar + DescuentoAutorizado));
        if(cDiferencia > -1 && cDiferencia < 1){
          txtDescuento = DescuentoAutorizado;
          BandAplicaDesc = 1;
        }else{
          suma = MinimoRequiereAbonar + DescuentoAutorizado;
          NPush("Hay un descuento autorizado por " + DescuentoAutorizado + ", pero se requiere un pago de por lo menos " + suma + " para activarlo", "Plataforma ITAVU");

          txtDescuento = 0;
          BandAplicaDesc = 0;
        }
      }
    }else{
      txtDescuento = 0;
    }
    txtTotal = Importe - txtDescuento;
  }

  if(Importe > 0){
    if(IdPrograma == 271 && Cargo == 13 && Importe > AhorroPorCubrir && EstatusCuenta == 10){
    
      NPush("Esta intentando pagar una cantidad mayor a la esperada como pago inicial", "Plataforma ITAVU");
                            
    }else{
      if(IdPrograma == 271 && Cargo == 13 && Importe < vMontoAhorrado + Importe && EstatusCuenta == 10){

        NPush("Esta intentando pagar una cantidad mayor a la esperada como pago inicial", "Plataforma ITAVU");
          
      }else{
            
        if(IdPrograma == 271 && Cargo == 13 && vMontoAhorrado == 0 && Importe < vMontoMinimo && EstatusCuenta == 10){

          NPush("Esta intentando pagar una cantidad menor a la esperada como pago inicial", "Plataforma ITAVU");     
        }
      }
    }
  }

  $('#lblPago').val(Importe);
  $('#lblDescuento').val(txtDescuento);
  $('#lblTotal').val(txtTotal);
  $('#TipoPago_1Liq').val(TipoPago_1Liq_2Desc_3MensFree);
  $('#vMontoDescuentoCapital').val(vMontoDescuentoCapital);
  $('#BCampActiva').val(BCampActiva);

}


function validacionesAntesdePagar(){
  //alert('entro');
  var IdPrograma = document.getElementById('IdPrograma').value;
  var Importe = document.getElementById('cantidad').value;
  var Cargo = document.getElementById('cboxcargos').value;
  var MontoSaldarPesos = document.getElementById('MontoSaldarPesos').value;
  var nitavu = document.getElementById('nitavu').value;
  var NumContrato = document.getElementById('NumContrato').value;
  var campaña = document.getElementById('campaña').value;
  $('#preloader').show();
  $.ajax({
    url: "val_caja.php",
    type: "post",
    data: {IdPrograma:IdPrograma, Importe:Importe, Cargo: Cargo, MontoSaldarPesos:MontoSaldarPesos, nitavu:nitavu, NumContrato:NumContrato, campaña:campaña},
    success: function(data){     
      //alert(data);     
    //  $("#sinCalculos").css({'display':'none',});
      $("#descuentosAut").html(data+"\n");  
      $('#preloader').hide();    
          
    }
  
  });
  
 
}

function adelantarPeriodos()
{
  
    var importe_periodo =<?php echo $MontoPago; ?>;
    var txtPeriodos = document.getElementById('txtPeriodos').value;
    var MontoSaldarPesos = document.getElementById('MontoSaldarPesos').value;
   
    descuento= $("#lblDescuento").text();
    if (txtPeriodos==0)
    {
       document.getElementById("cantidad").value=MASK('', 0,'$##,###,##0.00',1)  ;
          $("#lblPago").html(MASK('',(0),'$##,###,##0.00',1)+"\n");        
          $("#lblTotal").html(MASK('',(0),'$##,###,##0.00',1)+"\n");  
          LostFocusImporte();
    }


    

    if ((txtPeriodos * importe_periodo) > MontoSaldarPesos)
    {
    
    txtPeriodos.value = (MontoSaldarPesos/importe_periodo);
      
    cantidad=txtPeriodos *  importe_periodo;
    document.getElementById("cantidad").value=MASK('', (cantidad),'$##,###,##0.00',1)  ;
    $("#lblPago").html(MASK('',(txtPeriodos *  importe_periodo),'$##,###,##0.00',1)+"\n");        
    $("#lblTotal").html(MASK('',(cantidad-descuento),'$##,###,##0.00',1)+"\n");
   
    NPush('El importe del pago excede el monto restante a pagar.','Plataforma ITAVU');
      
       
    }
    else
    { 
        if( txtPeriodos != 0)
        {
          cantidad=txtPeriodos *  importe_periodo;
          document.getElementById("cantidad").value=MASK('', (cantidad),'$##,###,##0.00',1)  ;
          $("#lblPago").html(MASK('',(txtPeriodos *  importe_periodo),'$##,###,##0.00',1)+"\n");        
          $("#lblTotal").html(MASK('',(cantidad-descuento),'$##,###,##0.00',1)+"\n");  
        }
      

    }
}



function cerrarModal(e){
  	$('#modal_oscuro').hide();
	//document.getElementById('modal_oscuro')						this.close(); //Cierra la notificación
						
}

// funcion para obtener url
function obtenerValorParametro(sParametroNombre) {
var sPaginaURL = window.location.search.substring(1);
 var sURLVariables = sPaginaURL.split('&');
  for (var i = 0; i < sURLVariables.length; i++) {
    var sParametro = sURLVariables[i].split('=');
    if (sParametro[0] == sParametroNombre) {
      return sParametro[1];
    }
  }
 return null;
}



function ChangeImporte()
{
  var cantidad =  document.getElementById("cantidad").value;
  cantidad=cantidad.substr(cantidad.indexOf("$")+1, cantidad.length);
  if(cantidad>0)
  {
    $("pagar").prop('disabled', true);
  
  }

  descuento= $("#lblDescuento").text();

  
 
  /*if( numcontrato != "" && factormoneda != 0 )
  { 
    cantidad=cantidad.substr(cantidad.indexOf("$")+1, cantidad.length);
    total=(cantidad-descuento);
    $("#lblTotal").html(MASK('',total,'$##,###,##0.00',1)+"\n");  
  }*/
   $("#lblPago").html(MASK('',cantidad,'$##,###,##0.00',1)+"\n");  


}

function MuestaDatosPagoNormal()
{
   $("#DatosPagoNormal").css({'display':'inline-block'});
  $("#divOpciones").css({'display':'none'});
  $("#trPeriodos").css({'visibility': 'hidden'});
}

function AdelantarPagos()
{
  
   $("#trPeriodos").css({'visibility': 'visible'});
   $("#DatosPagoNormal").css({'display':'inline-block'});
   $("#divOpciones").css({'display':'none'}); 
}

function AbonarACapital()
{  
   $("#trPeriodos").css({'visibility': 'hidden'});
   $("#DatosPagoNormal").css({'display':'inline-block'});
   $("#divOpciones").css({'display':'none'}); 
}

function ingresaPago(IdDelegacion, IdPrograma, Folio, NumContrato){
  //alert('entro');
    $('#preloader').show(); 
    var cantidad =  document.getElementById("cantidad").value;
    var formapago =document.getElementById("formapago").value;
    var referencia = document.getElementById("referencia").value;
    var nitavu = document.getElementById("nitavu").value;
    var Tipo = document.getElementById("Tipo").value;
    var campaña;   
    var Cargo;
    var IdTipoMov;
    var MontoSaldarPesos;
    var Descuento;
    var Total;
    var txtPeriodos;
    var TipoPago_1Liq;
    var descuentoCapital;


    var SaldoExentoAnt;
    var MontoSaldar=0;
    var RezGts;
    var RezMoratorios;
    var RezFinanc;
    var RezCapital;
    var Rezago_seguros;
    var Rezago_otros_conceptos;
    var fecha_corte_sig;   
    var factormoneda;
    var Tipo_descuento;

    //IDENTIFICAMOS SI EXISTE NUMERO DE CONRTATO SERA DE TIPO 2 SI NO EXISTE 
    // DEFINIREMOS TIPO 1 POR DEFAULT PARA PODER INGRESAR EL PAGO
    if(NumContrato!=""){
      Tipo = 2; 
      //campaña = document.getElementById('campaña').value;   
      Cargo = document.getElementById('cboxcargos').value;
      IdTipoMov=0;
      MontoSaldarPesos = document.getElementById('MontoSaldarPesos').value;
      Descuento = document.getElementById("lblDescuento").innerHTML;
      Total = document.getElementById("lblTotal").innerHTML;
      txtPeriodos = document.getElementById("txtPeriodos").value;
      TipoPago_1Liq =document.getElementById("TipoPago_1Liq").value;
      descuentoCapital =document.getElementById("vMontoDescuentoCapital").value;
      Tipo_descuento = document.getElementById('TipoDescuento').value;
      campaña = document.getElementById('BCampActiva').value;
   
      SaldoExentoAnt= <?php echo $SaldoExentoAnt ; ?>;
      MontoSaldar=<?php echo $MontoSaldar ; ?>;
      RezGts=<?php echo $RezGts  ; ?>;
      RezMoratorios=<?php echo $RezMoratorios; ?>;
      RezFinanc=<?php echo $RezFinanc; ?>;
      RezCapital=<?php echo $RezCapital ; ?>;
      Rezago_seguros=<?php echo $Rezago_seguros    ; ?>;
      Rezago_otros_conceptos=<?php echo $Rezago_otros_conceptos; ?>;
      fecha_corte_sig='<?php echo $fecha_corte_sig; ?>';    
      factormoneda= <?php echo $factormoneda; ?>;
    }
    else{
      Tipo = 1; 
    }
    
    //VALIDAMOS QUE HAYA SELECCIONADO UNA FORMA DE PAGO. SI NO MANDA UN MENSAJE. 
    if(formapago==0)
    {
        NPush('No ha especificado un forma de pago.','Plataforma ITAVU');
        $('#preloader').hide();        
        return;
    }

    //datos del pago
  
   


   $.ajax({
        url: "pago.php",
        type: "post",
        data: {
          Cantidad:cantidad,FormaPago:formapago,Referencia:referencia,
          IdDelegacion: IdDelegacion, IdPrograma: IdPrograma, Folio:Folio,
          NumContrato: NumContrato, nitavu:nitavu, Tipo:Tipo, Campaña:campaña,   
          CveCargo:Cargo,IdTipoMov:IdTipoMov,         
          Descuento:Descuento, Total:Total,txtPeriodos:txtPeriodos,
          TipoPago_1Liq:TipoPago_1Liq,DescuentoCapital:descuentoCapital,

          RezMoratorios:RezMoratorios,RezFinanc:RezFinanc,RezCapital:RezCapital,
          Rezago_seguros:Rezago_seguros,Rezago_otros_conceptos:Rezago_otros_conceptos,
          SaldoExentoAnt: SaldoExentoAnt,RezGts:RezGts, 
          fecha_corte_sig:fecha_corte_sig,MontoSaldarPesos:MontoSaldarPesos, 
          factormoneda:factormoneda,
          factormoneda:factormoneda
          }, 
        success: function(data){     
           var res=data.trim();//quitos los espacios          
            mensaje=res.split('|')[1];           
            datosRecibo=res.split('|')[2];//separo para obtener los datos del recibo y enviarlos al iframe     
           // console.log(res.split('|')[0]);
           // console.log('mensaje'+mensaje);     
           // console.log('datos'+datosRecibo);
             //console.log('datos'+data);      
            $("#descuentosAut").html( data+"\n");

            if (datosRecibo === undefined) {
              // se ejecutan estas instrucciones
            }
            else { 
              window.location.href = window.location.href + "&DatosRecibo="+datosRecibo; 
            }               
            
            $('#preloader').hide();           
            //NPush(res.split('_')[0],'Plataforma ITAVU');// obtengo el mensaje que aparecerá en el npush
            document.getElementById("cantidad").value='';
            document.getElementById("formapago").value='';
            document.getElementById("referencia").value='';

            
        }
    });
 }
        


function MASK(form, n, mask, format) {
  if (format == "undefined") format = false;
  if (format || NUM(n)) {
    dec = 0, point = 0;
    x = mask.indexOf(".")+1;
    if (x) { dec = mask.length - x; }

    if (dec) {
      n = NUM(n, dec)+"";
      x = n.indexOf(".")+1;
      if (x) { point = n.length - x; } else { n += "."; }
    } else {
      n = NUM(n, 0)+"";
    } 
    for (var x = point; x < dec ; x++) {
      n += "0";
    }
    x = n.length, y = mask.length, XMASK = "";
    while ( x || y ) {
      if ( x ) {
        while ( y && "#0.".indexOf(mask.charAt(y-1)) == -1 ) {
          if ( n.charAt(x-1) != "-")
            XMASK = mask.charAt(y-1) + XMASK;
          y--;
        }
        XMASK = n.charAt(x-1) + XMASK, x--;
      } else if ( y && "$0".indexOf(mask.charAt(y-1))+1 ) {
        XMASK = mask.charAt(y-1) + XMASK;
      }
      if ( y ) { y-- }
    }
  } else {
     XMASK="";
  }
  if (form) { 
    form.value = XMASK;
    if (NUM(n)<0) {
      form.style.color="#FF0000";
    } else {
      form.style.color="#000000";
    }
  }
  return XMASK;
}
function NUM(s, dec) {
  for (var s = s+"", num = "", x = 0 ; x < s.length ; x++) {
    c = s.charAt(x);
    if (".-+/*".indexOf(c)+1 || c != " " && !isNaN(c)) { num+=c; }
  }
  if (isNaN(num)) { num = eval(num); }
  if (num == "")  { num=0; } else { num = parseFloat(num); }
  if (dec != undefined) {
    r=.5; if (num<0) r=-r;
    e=Math.pow(10, (dec>0) ? dec : 0 );
    return parseInt(num*e+r) / e;
  } else {
    return num;
  }
}


function print() {
  var objFra = document.getElementById('framerecibo');
  objFra.contentWindow.focus();
  objFra.contentWindow.print();
}

function cerrarPeriodo(IdDelegacion, IdPrograma, Folio, NumContrato){ 
  
  //alert(IdDelegacion);

  var fecha =  document.getElementById("fecha").value;
  var RezGts=<?php echo $RezGts  ; ?>;
  var Rezago_seguros=<?php echo $Rezago_seguros    ; ?>;
  var Rezago_otros_conceptos=<?php echo $Rezago_otros_conceptos; ?>;
  var RezMoratorios=<?php echo $RezMoratorios; ?>;
  var RezFinanc=<?php echo $RezFinanc; ?>;
  var RezCapital=<?php echo $RezCapital ; ?>;
  var nitavu = <?php echo $nitavu ; ?>;
  var fecha_corte_sig = '<?php echo $fecha_corte_sig; ?>';
  var fecha_abono_ant = '<?php echo $fecha_abono_ant ?>';

  
  if(fecha > fecha_corte_sig){
    NPush('No puede tratar de ingresar un pago con fecha posterior a la del proximo corte...');
  }else if(fecha < fecha_abono_ant){
    NPush('"No puede tratar de ingresar un pago con fecha anterior a la del ultimo abono registrado..."');
  }else{

    $('#preloader').show();
    $.ajax({
      url: "cerrar_periodo.php",
      type: "post",
      data: {NumContrato:NumContrato, IdDelegacion : IdDelegacion, IdPrograma: IdPrograma, Folio: Folio, fecha:fecha, RezGts: RezGts, Rezago_seguros:Rezago_seguros,Rezago_otros_conceptos:Rezago_otros_conceptos,
      RezMoratorios:RezMoratorios,RezFinanc:RezFinanc, RezCapital:RezCapital,nitavu:nitavu},
      success: function(data){     
        //alert(data);     
      //  $("#sinCalculos").css({'display':'none',});
        $("#resp").html(data+"\n");  
        $('#preloader').hide();               

      }
    
    });
  }
}

</script>
<?php include ("lib/body_footer.php"); ?>

