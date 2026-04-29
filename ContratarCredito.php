<?php
include ("lib/body_head.php");
require("plantilla-core.php");
?>





<?php
    
$id_aplicacion ="ap113"; 
$nivel = aplicacion_nivel($id_aplicacion, $nitavu);

if (sanpedro($id_aplicacion, $nitavu)==TRUE){
    echo "<div id='AppDetalle'>".app_detalle($id_aplicacion, $nitavu)."</div>";        
    xd_update($id_aplicacion,$nitavu); historia($nitavu, $id_aplicacion." | Entro a contratación de un credito");
    echo "<br><br>";


if(isset($_GET['delegaciones']) and isset($_GET['programa']) and isset($_GET['_folio'])){
       
        //variables
        $IdDelegacion = $_GET['delegaciones'];
        $IdPrograma = $_GET['programa'];
        $Folio = $_GET['_folio'];
        $tipoPrograma = tipoTramitePrograma($IdPrograma);       
       //$NumContrato = buscarSiYaTieneContrato($IdDelegacion, $IdPrograma, $Folio);
        $NumContrato = buscarSiYaTieneContratoActivoOno($IdDelegacion, $IdPrograma, $Folio);
        $montocredito=0;
        $aplicagtsadmon=0;
        $fechainiciocuentaenable="disabled";
        $ritavu= 0;
        $subsidioitavu = 0;   
        $subsidiofonhapo=0;    
        $ministracion1 =0;
        $idpagoinicial = 0;
        $montopagoinicial = 0;
        $montopago = 0;
        $montoultimopago=0;
        $rbeneficiario= 0;                                                  
        $tasaanualfin = 0;
        $tipointeres=0;
        $tasaintmora = 0;
        $periodomora = 0;
        $ministracion1= 0;
        $ministracion2=0;
        $ministracion3=0;
        $contratomaestro = "";
        $montocreditoenabled = "disabled";
        $aportacionfonhapo=0;
        $gastosadmonfonhapo=0;
        $ncertificadofonhapo="";        
        $aportacionitavu=0;
        $gastosadmonitavu=0;
        $ncertificadoitavu="";
        $aportacionbeneficiario=0;
        
        $gtsescrituracion=0;
        $ultimopago=0;
        $segurovida=0;
        $totalpagos=0;
        $otrocargo=0;
        $gtsadmonpago=0;
        $diasgracia=0;
        $idtipopago=0;
        $idpaq=0;
        $idconceptocargo=0;
        $subsidio=0;
        $totalmontopago=0;


        //Agregue estas por que no las encontraba si no entran a un if no existen--Flor
        $gtsadmon=0;
        $totalfinanciar=0;
        $acumulado="";  
        $fijo="";
       
        $contratocancelado=ContratoCancelado($NumContrato, $IdDelegacion, $IdDelegacion);

        //echo $NumContrato."fsf";
        
    /***CODIGO QUE SIRVE PARA IDENTIFICAR QUE BOTON PRESIONO Y QUE DOCUEMNTO DEBE MOSTRAR EN PANTALLA ****/
     if($NumContrato <>'' AND ($contratocancelado=='' OR $contratocancelado==0))
        {
           
            if (isset($_GET['op']))
            {
                $TotalAFinanciar=TotalAFinanciar($NumContrato) ;
                if($_GET['op']==1 )
                {           
                $IdPlantilla = plantillaPrograma($IdPrograma);                          
                echo "<center><h1>Asignación de crédito</h1></center>";       
                }

                else if($_GET['op']==2)
                {           
                $IdPlantilla = 3  ; //PLANTILLA DE ASIGACION GENERAL                           
                echo "<center><h1>Carta de Asignación</h1></center>";          
                }
                else if($_GET['op']==3){
                    echo "<center><h1>Corrida Financiera</h1></center>";
                    $IdPlantilla = 36;
                }
                
                //CREAMOS PLANTILLA
                crearPlantilla($IdPlantilla, $NumContrato, $TotalAFinanciar, $nitavu);      
                
            }
        }

      
            if($NumContrato <> '' and !isset($_GET['NumContrato'] )and   !isset($_GET['op']) and  ($contratocancelado=='' OR $contratocancelado==0)){
                mensaje('No es posible contratar, el folio ya se encuentra en estatus de contratado!!','ContratarCredito.php?delegaciones='.$IdDelegacion.'&programa='.$IdPrograma.'&_folio='.$Folio.'&NumContrato='.$NumContrato.'');
               
            }else {
            

            //BUSCAMOS SI EXISTE LA SOLICITUD
            if(buscaSolicitud($IdPrograma, $IdDelegacion, $Folio)==0 ){
                mensaje('No existe una solicitud con esos datos','contratacion.php');
            }else{
                //BUSCAMOS QUE NO ESTE CANCELADA
                if(solicitudCancelada($IdPrograma, $IdDelegacion, $Folio)==1 and ($NumContrato <> '' and ($contratocancelado=='' OR $contratocancelado==0))){
                    mensaje('Esta solicitud esta cancelada.','contratacion.php');
                }else{
                    //ESXISTE UN CONTRATO Y ESTA CANCELADO
                 if(isset($_GET['m2']) and (($NumContrato <>'') and ($contratocancelado==1)))
                 {
                     echo "<h3 style='color: #d5303e; font-size:12pt; font-weight:bold' id='EtiquetaCancelado' name='EtiquetaCancelado'>CONTRATO CANCELADO!!</h3>";   
                 } 
                   
                    //DIBUJAMOS LOS DATOS DEL BENEFICIARIO EN PANTALLA
                    $IdSolicitante = buscarIdSolicitante($IdPrograma, $IdDelegacion, $Folio);
                    echo "<br>";
                    echo "<center>";
                        datosBeneficiarioenFormatoCorto($IdPrograma, $IdDelegacion, $Folio, $NumContrato);
                    echo "</center>";
                    echo '<br>'; 
                    
                    //BOTONES IMPRESION DE DOCUMENTOS CONTRATO
                    if($NumContrato!="" and ($contratocancelado=='' OR $contratocancelado==0))
                     {  
                    echo '<center>';
                        echo "<br><section  style='margin-top:5px; width:80%;'>";               
                         echo "<a id='contratos' href='ContratarCredito.php?_folio=".$Folio."&programa=".$IdPrograma."&delegaciones=".$IdDelegacion."&op=1'  class='btn btn-primary'  title='Contrato' style='margin: 20px;'> 
                        <table  width='100%'><tr><td valign='middle' align='center'>
                        <img src='icon/autorizaDescuentos.png'> 
                        </td>
                        <td valign='middle' align='center' style='color:white;' class='pc'>
                        Contrato
                        </td></tr></table>   
                        </a>";
                       /* if ($IdPrograma==78)
                        {
                        echo "<a id='asignaciongral' href='ContratarCredito.php?_folio=".$Folio."&programa=".$IdPrograma."&delegaciones=".$IdDelegacion."&op=2'  class='btn btn-primary'  title='Asigmacion General' style='margin: 20px;'> 
                        <table  width='100%'><tr><td valign='middle' align='center'>
                        <img src='icon/min_noti.png'> 
                        </td>
                        <td valign='middle' align='center' style='color:white;' class='pc'>
                        Asignación General
                        </td></tr></table>   
                        </a>";
                        }

                        echo "<a id='corrida' href='ContratarCredito.php?_folio=".$Folio."&programa=".$IdPrograma."&delegaciones=".$IdDelegacion."&op=3'  class='btn btn-primary'  title='Corrida Financiera' style='margin: 20px;'> 
                        <table  width='100%'><tr><td valign='middle' align='center'>
                        <img src='icon/embarques_print2.png'> 
                        </td>
                        <td valign='middle' align='center' style='color:white;' class='pc'>
                        Corrida Financiera
                        </td></tr></table>   
                        </a>";*/

                        
                        echo "</section>";
                    echo "</center>";
                    }

                    echo '<br>'; 
                    echo '<center>';
    
                    //NIVELES DELEGACION O SUELO O DEPENDIENDO DEPTO QUE EJECUTE LA CONTRATACION                  

                    if(IdPaqueteMaterialEstFonhapo($IdDelegacion,$IdPrograma,$Folio)!=0 OR ( fechaEmisionContrato($NumContrato)==''))
                    {
                        if(IdEmpEvaluadorDatosEvaluacion($IdDelegacion,$IdPrograma,$Folio)>0 AND fechaEvaluaciondeSolicitud($IdPrograma, $IdDelegacion, $Folio)!='')
                            {
                                // REVISAMOS SI LA SOLICITUD ESTA APROBADA
                                if(aprobadaEnEvaluacion($IdDelegacion, $IdPrograma, $Folio) == 1)
                                {
                                    
                                    // EXISTE UN CONTRATO  
                                    if($NumContrato!="")
                                    {                                      
                                        //REVISAR IS EXISTE CARGOS
                                        if (InicializaCargos($NumContrato, '000', 1)== true){                                            
                                            $FechadelCargo = fechaEmisionCargos($NumContrato, '000', 1);
                                            $TCambioContrato = 'cCancela';
                                            //Calcula Saldo
                                            $GeneraSaldo = 1;
                                            $IniciaCuenta = 1;
                                            $IniciaCuenta = 0;
                                        }else{                                            
                                            //EXISTE UN CONTRATO PERO NO HAY CARGOS                                           
                                        }                                        
                                    }
                                    else
                                    {                                       
                                        // NO EXISTE CONTRATO PERO
                                        // HAY UN CREDITO AUTORIZADO
                                        $TCambioContrato = "cNuevo";
                                    }
                                        //if(TipoAsignacionPrograma ($IdPrograma)==0)
                                        // {

                                            //echo 'Entro aqui';
                                            /*if(($IdPrograma==218 ) AND  ciudadViviendaConstruccion($IdDelegacion,$IdPrograma,$Folio)==14)
                                            {
                                                if(IdPaqueteMaterialEstFonhapo ($IdDelegacion,$IdPrograma,$Folio)==18)
                                                {
                                                    $montocredito = 1000;
                                                    $ritavu= 1000;
                                                    $subsidioitavu = 1000;                                                    
                                                    $ministracion1 = 1000;                                               
                                                    $montocreditoenabled = "disabled"; 

                                                }
                                                 if(IdPaqueteMaterialEstFonhapo ($IdDelegacion,$IdPrograma,$Folio)==20)
                                                {
                                                    $montocredito = 1100;
                                                    $ritavu= 1100;
                                                    $subsidioitavu = 1100;                                                    
                                                    $ministracion1 = 1100;                                                 
                                                    $montocreditoenabled = "disabled"; 
                                                }
                                                if(IdPaqueteMaterialEstFonhapo ($IdDelegacion,$IdPrograma,$Folio)==48)
                                                {
                                                    $montocredito = 1200;
                                                    $ritavu= 1200;
                                                    $subsidioitavu = 1200;                                                    
                                                    $ministracion1 = 1200;                                                 
                                                    $montocreditoenabled = "disabled";  
                                                }
                                            }
                                            else 
                                            {      //cambia el monto de paquetes tinaco y sanitario cuando el municipio de la solicitud sea guerrero del programa 225 (año 2015)
                                                //ya que para este municipio variaron los costos
                                                if(($IdPrograma==225 ) AND  ciudadViviendaConstruccion($IdDelegacion,$IdPrograma,$Folio)==14)
                                                {
                                                    if(IdPaqueteMaterialEstFonhapo ($IdDelegacion,$IdPrograma,$Folio)==3)
                                                    {
                                                        $montocredito = 1250;
                                                        $ritavu= 1250;
                                                        $subsidioitavu = 1250;                                                    
                                                        $ministracion1 = 1250;                                               
                                                        $montocreditoenabled = "disabled";   
    
                                                    }
                                                     if(IdPaqueteMaterialEstFonhapo ($IdDelegacion,$IdPrograma,$Folio)==48)
                                                    {
                                                        $montocredito = 975;
                                                        $ritavu= 975;
                                                        $subsidioitavu = 975;                                                    
                                                        $ministracion1 = 975;                                                 
                                                        $montocreditoenabled = "disabled";
                                                    }
                                                    if(IdPaqueteMaterialEstFonhapo ($IdDelegacion,$IdPrograma,$Folio)==49)
                                                    {
                                                        $montocredito = 900;
                                                        $ritavu= 900;
                                                        $subsidioitavu = 900;                                                    
                                                        $ministracion1 = 900;                                                 
                                                        $ministracion1 = 900; 
                                                        $montocreditoenabled = "disabled"; 
                                                    }if(IdPaqueteMaterialEstFonhapo ($IdDelegacion,$IdPrograma,$Folio)==1)
                                                    {
                                                        $montocredito = 1800;
                                                        $ritavu= 1800;
                                                        $subsidioitavu = 1800;                                                    
                                                        $ministracion1 = 1800;                                                 
                                                        $ministracion1 = 1800; 
                                                        $montocreditoenabled = "disabled"; 
                                                    }
                                                } // fin del programa 225 Municipio Guerrero
                                                else
                                                { 
                                                    $montocreditoenabled = "";
                                                    $idpaq=IdPaqueteMaterialEstFonhapo ($IdDelegacion,$IdPrograma,$Folio);
                                                    //codigo original
                                                }
                                              } // fin del programa 218 Municipio Guerrero
    
                                                */
                              
                                            
                                            // TRAE LOS DATOS DEL CREDITO
                                            // DEL TABLA DE CREDITOS
                                        // }
                                        // else 
                                        //{
                                            
                                            // TRAE LOS DATOS DEL CREDITO
                                            // DE LA TABLA DE EVALUACION
                                                 
                                                //FONHAPO
                                                $aportacionfonhapo=RFonhapoDatosEvaluacion($IdDelegacion,$IdPrograma,$Folio);
                                                $subsidiofonhapo= SubsidioFonhapo($IdDelegacion, $IdPrograma, $Folio); 
                                                $gastosadmonfonhapo=F_GtsAdmonFonhapoDatosEvaluacion($IdDelegacion, $IdPrograma, $Folio);
                                                $ncertificadofonhapo=NCertSubsidioF($IdDelegacion, $IdPrograma, $Folio);

                                                 //ITAVU
                                                $aportacionitavu=RItavuDatosEvaluacion($IdDelegacion,$IdPrograma,$Folio);
                                                $subsidioitavu= SubsidioItavu($IdDelegacion, $IdPrograma, $Folio);
                                                $gastosadmonitavu=I_GtsAdmonDatosEvaluacion($IdDelegacion, $IdPrograma, $Folio);
                                                $ncertificadoitavu= NCertSubsidioI($IdDelegacion, $IdPrograma, $Folio);

                                                //BENEFICIARIO
                                                $aportacionbeneficiario=RBeneficiarioDatosEvaluacion($IdDelegacion, $IdPrograma, $Folio);

                                                //DATOS DEL CREDITO
                                                $TipoMoneda=TipoMonedaDatosEvaluacion($IdDelegacion, $IdPrograma, $Folio);
                                                $montocredito=MontoCreditoDatosEvaluacion($IdDelegacion,$IdPrograma,$Folio);
                                                $idpagoinicial=TipoPagoInicialDatosEvaluacion($IdDelegacion,$IdPrograma,$Folio);
                                                $montopagoinicial=MontoAhorroDatosEvaluacion($IdDelegacion,$IdPrograma,$Folio);
                                                $aplicaGtsAdmon=AplicaGastosAdmonDatosEvaluacion($IdDelegacion,$IdPrograma,$Folio);         
                                                $subsidio= number_format((float)($subsidioitavu + $subsidiofonhapo), 2, '.', ''); 
                                                                                      
                                                $gtsadmon= GtsAdmonDatosEvaluacion($IdDelegacion,$IdPrograma,$Folio);
                                                $gtsescrituracion=GtsEscrituracionDatosEvaluacion($IdDelegacion,$IdPrograma,$Folio);
                                             

                                                //DATOS DEL PAGO                                            
                                                $idtipopago=IdTipoPagoDatosEvaluacion($IdDelegacion,$IdPrograma,$Folio);
                                                $totalpagos=TotalPagosDatosEvaluacion($IdDelegacion,$IdPrograma,$Folio);
                                             
                                                $montopago= MensualidadDatosEvaluacion($IdDelegacion,$IdPrograma,$Folio);
                                                $montoultimopago=MontoUltimoPagoDatosEvaluacion($IdDelegacion,$IdPrograma,$Folio);
                                                $gtsadmonpago=PGtsAdmonDatosEvaluacion($IdDelegacion,$IdPrograma,$Folio);
                                                $segurovida=SegurodeVidaDatosEvaluacion($IdDelegacion,$IdPrograma,$Folio);
                                                $otrocargo=OtroCargoDatosEvaluacion($IdDelegacion,$IdPrograma,$Folio);
                                                $idconceptocargo=IdConceptoCargoDatosEvaluacion($IdDelegacion,$IdPrograma,$Folio);  
                                             
                                                
                                                //INTERESES
                                                $tasaanualfin= TasaAnualFinDatosEvaluacion($IdDelegacion,$IdPrograma,$Folio);
                                                $tipointeres=TipoIntMoratorioDatosEvaluacion($IdDelegacion,$IdPrograma,$Folio);
                                                $tasaintmora= TasaIntMoraDatosEvaluacion($IdDelegacion,$IdPrograma,$Folio);
                                                $diasgracia=DiasdeGraciaDatosEvaluacion($IdDelegacion,$IdPrograma,$Folio);
                                                $periodomora= PeriodoMoraDatosEvaluacion($IdDelegacion,$IdPrograma,$Folio);
                                                $ministracion1=Ministracion1DatosEvaluacion($IdDelegacion,$IdPrograma,$Folio);
                                                $ministracion2=Ministracion2DatosEvaluacion($IdDelegacion,$IdPrograma,$Folio);
                                                $ministracion3=Ministracion3DatosEvaluacion($IdDelegacion,$IdPrograma,$Folio);
                                                
                                                //$totalfinanciar=(($montocredito + $gtsescrituracion + $gtsadmonc) -$subsidio - $montopagoinicial);
                                                $totalfinanciar=0;
                                                if($tipointeres==1){  
                                                   $acumulado="checked";
                                                   $fijo="";
                                                }
                                                else {
                                                    $fijo="checked";  
                                                    $acumulado="";                                                  
                                                }
                                                if(TipoAsignacionPrograma ($IdPrograma)==0)
                                                {
                                                    $fechaInicioCuentaEnable="";
                                                }  
                                            //}

                                           
                                            //DATOS FIJOS 
                                            if($IdPrograma == 252)
                                            { 
                                              $subsidiofonhapo=63600;
                                              $subsidioitavu=63600;
                                            }
                                            if($IdPrograma == 253)
                                            {
                                              $subsidiofonhapo=63600;
                                              $subsidioitavu=70100;
                                            }
                                            if($IdPrograma == 259)
                                            {
                                                $subsidioitavu=916.42;
                                            }
                                            if($IdPrograma == 270 OR $IdPrograma == 277 OR $IdPrograma == 278 OR $IdPrograma == 279)
                                            {
                                              $subsidioitavu=$montocredito;
                                            }

                                            if ($IdPrograma == 209 And $IdDelegacion==1 )
                                            {
                                                $totalpagos=109;
                                                $montopago=109;
                                                $montoultimopago=661;                                              
                                       
                                            }

                                            if($IdPrograma==281)
                                            {   $subsidiofonhapo=$montocredito;
                                            }                                        
                                    //}
                                    
                                    domicilioDondeReside($IdDelegacion,$IdPrograma,$Folio);

                                    domiciliodeConstruccion($IdDelegacion,$IdPrograma,$Folio);
                            
                                    datosDeLaPropiedad($IdDelegacion,$IdPrograma,$Folio); 



                                    if($NumContrato!='')
                                    {  
                                        
                                        $AvalContrato=AvalContrato($NumContrato);
                                        $AvalCalleyNum=AvalCalleyNum($NumContrato);
                                        $AvalDomTrabajo=AvalDomTrabajo($NumContrato);
                                        $AvalEntreCalle=AvalEntreCalle($NumContrato);
                                        $AvalLugTrabajo=AvalLugTrabajo($NumContrato);
                                        $AvalTelTrabajo=AvalTelTrabajo($NumContrato);
                                        $AvalTelCasa=AvalTelCasa($NumContrato);
                                        $Aval_YCalle=Aval_YCalle($NumContrato);
                                        $Aval_Colonia=ColoniaAvalColonias(IdColoniaAvalContrato($NumContrato));
                                    }else
                                    {
                                        $AvalContrato="";
                                        $AvalCalleyNum="";
                                        $AvalDomTrabajo="";
                                        $AvalEntreCalle="";
                                        $AvalLugTrabajo="";
                                        $AvalTelTrabajo="";
                                        $AvalTelCasa="";
                                        $Aval_YCalle="";
                                        $Aval_Colonia="";
                                    }

                                    echo '<br>';
                                    echo '<br>';

                                 

                                  
                                    echo "<form action='contratarCredito_bd.php?delegacion=".$IdDelegacion."&programa=".$IdPrograma."&folio=".$Folio."&nitavu=".$nitavu."' method='POST'>";
                                    echo '<section>';
                                    echo '<center>';
                                    echo '<div class="card " style="text-align: justify; width: 90%;">
                                    <h1 class="card-header h5" style="text-transform: uppercase;font-size: 10pt;">Datos del Crédito</h1>';    
                                    echo "<input type='hidden' name='postID' ";
                                    echo "value='".md5(uniqid(rand(), true))."'>";
                                    echo '<div class="row" style="width:98%;margin:0px;">';
                                        //*** RECURSOS FONHAPO*/
                                        echo ' <div class="col-xs-6 col-md-4" style="text-align: justify; padding: 2px; margin-right: 0px; padding: 10px;">';
                                        echo '<br>'; 
                                            echo '<h6 class="card-title">RECURSOS FONHAPO</h6>';                                
                                            echo "<table style='width:90%; margin-left: 20px; font-size: 10pt;'>";
                
                                            echo "<tr>";
                                                echo "<td><span class='normal'>Aportacion</span></td>";                           
                                                echo" <td colspan='3'><input  type='text'    name='aportacion' id='Aportacion' value='".number_format((float)($aportacionfonhapo), 2, '.', '')."'></td>";                          
                                            echo "</tr>"; 
                
                                            echo "<tr>";
                                                echo "<td><span class='normal'>Subsidio</span></td>";                           
                                                echo" <td colspan='3'><input  type='text'    name='subsidiofonhapo'  onkeyup='CalcularSubsidio();'  id='subsidiofonhapo' value='".number_format((float)($subsidiofonhapo), 2, '.', '')."'></td>";                          
                                            echo "</tr>"; 
                
                                            echo "<tr>";
                                                echo "<td><span class='normal'>Gastos Admon</span></td>";                           
                                                echo" <td colspan='3'><input  type='text'    name='gastosadmonfonhapo' id='gastosadmonfonhapo' value='".number_format((float)($gastosadmonfonhapo), 2, '.', '')."'></td>";                          
                                            echo "</tr>";  
                
                                            echo "<tr>";
                                                echo "<td><span class='normal'>N°  de Certificado</span></td>";                           
                                                echo" <td colspan='3'><input  type='text'    name='ncertificado' id='ncertificado' value='".$ncertificadofonhapo."'></td>";                          
                                            echo "</tr>";
                
                                            echo "</table>";                         
                                            echo '</div>';
                                            
                                            //*** RECURSOS ITAVU*/
                                            echo ' <div class="col-xs-6 col-md-4" style="text-align: justify; padding: 2px; margin-right: 0px;" >';
                                            echo '<br>'; 
                                                echo '<h6 class="card-title">RECURSOS ITAVU</h6>';                                
                                                echo "<table style='width:90%; margin-left: 20px; font-size: 10pt;'>";
                    
                                                echo "<tr>";
                                                    echo "<td><span class='normal'>Aportacion</span></td>";                           
                                                    echo" <td colspan='3'><input  type='text'    name='aportacionitavu' id='aportacionitavu' value='".number_format((float)($aportacionitavu), 2, '.', '')."'></td>";                          
                                                echo "</tr>"; 
                    
                                                echo "<tr>";
                                                    echo "<td><span class='normal'>Subsidio</span></td>";                           
                                                    echo" <td colspan='3'><input  type='text'    onkeyup='CalcularSubsidio();' name='subsidioitavu' id='subsidioitavu' value='".number_format((float)($subsidioitavu), 2, '.', '')."'></td>";                          
                                                echo "</tr>"; 
                    
                                                echo "<tr>";
                                                    echo "<td><span class='normal'>Gastos Admon</span></td>";                           
                                                    echo" <td colspan='3'><input  type='text'    name='gastosadmonitavu' id='gastosadmonitavu' value='".number_format((float)($gastosadmonitavu), 2, '.', '')."'></td>";                          
                                                echo "</tr>";  
                    
                                                echo "<tr>";
                                                    echo "<td><span class='normal'>N°  de Certificado</span></td>";                           
                                                    echo" <td colspan='3'><input  type='text'    name='ncertificadoitavu' id='ncetificadoritavu' value='".$ncertificadoitavu."'></td>";                          
                                                echo "</tr>";
                    
                                                echo "</table>";                           
                                            echo '</div>';
                    
                                            //*** R. BENEFICIARIO*/
                                            echo ' <div class="col-xs-6 col-md-4" style="text-align: justify; padding: 2px; margin-right: 0px;">';
                                            echo '<br>'; 
                                                echo '<h6 class="card-title"> R. BENEFICIARIO</h6>';                                
                                                echo "<table style='width:90%; margin-left: 20px; font-size: 10pt;'>";
                    
                                                echo "<tr>";
                                                    echo "<td><span class='normal'>Aportacion</span></td>";                           
                                                    echo" <td colspan='3'><input  type='text'    name='aportacionbeneficiario' id='aportacionbeneficiario' value='".$aportacionbeneficiario."'></td>";                          
                                                echo "</tr>"; 
                    
                                                echo "<tr>";
                                                    echo "<td><span class='normal'>Fecha de Inicio</span></td>";  
                                                   $fechaActual= date('Y-m-d');   
                                                   //".$fechainiciocuentaenable."                      
                                                    echo" <td colspan='3'><input  type='date'  name='fechainicio' id='fechainicio' value='".$fechaActual."'></td>";                          
                                                echo "</tr>";  
                                            
                                            
                    
                                        echo "</table>";                         
                                        echo '</div>';                     
                                        //*** DATOS DEL CREDITO */
                                        echo ' <div class="col-xs-6 col-md-4" style="text-align: justify; margin: 0px;">';
                                        echo '<br>'; 
                                            echo '<h6 class="card-title">DATOS DEL CREDITO</h6>';                                
                                            echo "<table style='width:90%; margin-left: 20px; font-size: 10pt;'>";
                                            
                                            echo "<tr>";                       
                                                echo "<td><span class='normal'>Tipo Moneada</span></td>";                           
                                                echo" <td colspan='3'>";                           
                                                echo "<select  id='idtipomoneda'  name='idtipomoneda' >";
                                                $sql2="select * from tipomoneda"; 
                                                $r2 = $Vivienda -> query($sql2); 
                                                while($valor = $r2 -> fetch_array())
                                                {
                                                    if (TipoMonedaDatosEvaluacion($IdDelegacion,$IdPrograma,$Folio)==$valor['IdTipoMoneda'])
                                                    {
                                                    echo "<option value='".$valor['IdTipoMoneda']."' selected>".$valor['TipoMoneda']."</option>";
                                                    }
                                                    else
                                                    {
                                                        echo "<option value='".$valor['IdTipoMoneda']."'>".$valor['TipoMoneda']."</option>";
                                                    }
                                                }                           
                                                echo "</select>";
                                                echo "</td>";
                                            echo "</tr>";  
                                            
                                            if($montocreditoenabled=="disabled")
                                            {   
                                                echo "<tr>";
                                                    echo "<td><span class='normal'>Monto del Credito</span></td>";                           
                                                    echo" <td colspan='3'><input  type='text'    name='montocredito' id='montocredito' onkeyup='CalcularFinanciamiento();' value='".number_format((float)($montocredito), 2, '.', '')."'></td>";                          
                                                echo "</tr>";                                                        
                                            }
                                            else
                                            {
                                                echo "<tr>";                       
                                                echo "<td><span class='normal'>Monto del Credito</span></td>";                           
                                                echo" <td colspan='3'>";                           
                                                echo "<select  id='montocredito'  name='montocredito' >";

                                                // $idpaq=20;876
                                                // $IdDelegacion=14;
                                                // $IdPrograma=218;
                                                // $montocredito="1470.0000";
                                                $sqlCredito="SELECT *  from creditos  
                                                WHERE MontoCredito<=".$montocredito." and IdDelegacion=".$IdDelegacion." AND IdPrograma=".$IdPrograma;
                                                if($idpaq>0)
                                                {  $sqlCredito= $sqlCredito +" AND  (POSITION( ".$paq.",IdPaquetes )>0))";

                                                }                                        
                                               $r2 = $Vivienda -> query($sqlCredito); 
                                                while($valor = $r2 -> fetch_array())
                                                {
                                                    if (TipoMonedaDatosEvaluacion($IdDelegacion,$IdPrograma,$Folio)==$valor['IdTipoMoneda'])
                                                    {
                                                    echo "<option value='".$valor['MontoCredito']."' selected>".$valor['MontoCredito']."</option>";
                                                    }
                                                    else
                                                    {
                                                        echo "<option value='".$valor['MontoCredito']."'>".$valor['MontoCredito']."</option>";
                                                    }
                                                }                           
                                                echo "</select>";
                                                echo "</td>";
                                            echo "</tr>";   
                                            }
                                                                                       
                    
                                            echo "<tr>";                       
                                                echo "<td><span class='normal'>Tipo Pago Inicial</span></td>";                           
                                                echo" <td colspan='3'>";                           
                                                echo "<select  id='idtipopagoinicial'  name='idtipopagoinicial' onchange='CalculaGtsInd();'>";
                                                $sql2="select * from tipopagoinicial"; 
                                                $r2 = $Vivienda -> query($sql2); 
                                                while($valor = $r2 -> fetch_array())
                                                {
                                                    if ($idpagoinicial==$valor['IdPagoInicial'])
                                                    {
                                                    echo "<option value='".$valor['IdPagoInicial']."' selected>".$valor['PagoInicial']."</option>";
                                                    }
                                                    else
                                                    {
                                                        echo "<option value='".$valor['IdPagoInicial']."'>".$valor['PagoInicial']."</option>";
                                                    }
                                                }                           
                                                echo "</select>";
                                                echo "</td>";
                                            echo "</tr>";
                    
                                            echo "<tr>";
                                                    echo "<td><span class='normal'>Monto Pago Inicial</span></td>";                           
                                                    echo" <td colspan='3'><input  type='text'    name='montopagoinicial' id='montopagoinicial'  onkeyup='CalcularFinanciamiento();'  value='".number_format((float)($montopagoinicial), 2, '.', '')."'></td>";                          
                                            echo "</tr>";
                                            
                                        
                                            echo "<tr>";                       
                                                echo "<td><span class='normal'>Aplica Gastos Admon</span></td>";                           
                                                echo" <td colspan='3'>";                           
                                                echo "<select  id='aplicagtsadmon'  name='aplicagtsadmon' onchange='AplicaGastos();'>";
                                                $sql2="select IdTipoAplicaGtsAdmon,upper(TipoAplicaGtsAdmon) as TipoAplicaGtsAdmon  from tipoaplicagtsadmon"; 
                                                $r2 = $Vivienda -> query($sql2); 
                                                while($valor = $r2 -> fetch_array())
                                                {
                                                    if ($aplicaGtsAdmon==$valor['IdTipoAplicaGtsAdmon'])
                                                    {
                                                    echo "<option value='".$valor['IdTipoAplicaGtsAdmon']."' selected>".$valor['TipoAplicaGtsAdmon']."</option>";
                                                    }
                                                    else
                                                    {
                                                        echo "<option value='".$valor['IdTipoAplicaGtsAdmon']."'>".$valor['TipoAplicaGtsAdmon']."</option>";
                                                    }
                                                }                           
                                                echo "</select>";
                                                echo "</td>";
                                            echo "</tr>";                      
                                                                
                                            echo "<tr>";
                                                echo "<td><span class='normal'>Gastos Administrativos</span></td>";                           
                                                echo" <td><input  type='text'    name='gtsadmon' id='gtsadmon' onkeyup='AplicaGastos();'  value='".number_format((float)($gtsadmon), 2, '.', '')."'></td>"; 
                                                echo "<td><span class='normal'>%</span></td>";      
                                                echo" <td><input  type='text'  style='width:96%;'  name='gtsadmonc' id='gtsadmonc'  ></td>";                         
                                            echo "</tr>";        
                    
                                            echo "<tr>";
                                                echo "<td><span class='normal'>Gastos Escrituracion</span></td>";                           
                                                echo" <td colspan='3'><input  type='text'    name='gtsescrituracion' id='gtsescrituracion' onkeyup='CalcularFinanciamiento();' value='".number_format((float)($gtsescrituracion), 2, '.', '')."'></td>";                          
                                            echo "</tr>";
                    
                                            echo "<tr>";                                               
                                                echo "<td><span class='normal'>Subsidio</span></td>";                           
                                                echo" <td colspan='3'><input  type='text'    name='subsidio' id='subsidio'  readonly value='".number_format((float)($subsidio), 2, '.', '')."'></td>";                          
                                            echo "</tr>";
                    
                                            echo "<tr>";
                                                echo "<td><span class='normal'>Total a Financiar</span></td>";                           
                                                echo" <td colspan='3'><input  type='text'    name='totalfinanciar' id='totalfinanciar' readonly  value='".number_format((float)($totalfinanciar), 2, '.', '')."'></td>";                          
                                            echo "</tr>";
                    
                                            echo "</table>";
                                        echo '</div>';
                    
                                            //*** DATOS DEL PAGO */
                                        echo ' <div class="col-xs-6 col-md-4" style="text-align: justify; margin: 0px;">';
                                            echo '<br>'; 
                                            echo '<h6 class="card-title">DATOS DEL PAGO</h6>';                                
                                            echo "<table style='width:90%; margin-left: 20px; font-size: 10pt;'>";
                                                echo "<tr>";                       
                                                    echo "<td><span class='normal'>TipoPago</span></td>";                           
                                                    echo" <td colspan='3'>";                                                                             
                                                    echo "<select  id='tipopago'  name='tipopago' >";
                                                    $sql2="select * from tipopago"; 
                                                    $r2 = $Vivienda -> query($sql2); 
                                                    while($valor = $r2 -> fetch_array())
                                                    { 
                                                        if ($idtipopago==$valor['IdTipoPago'])
                                                        {
                                                         echo "<option value='".$valor['IdTipoPago']."' selected>".$valor['TipoPago']."</option>";
                                                        }
                                                        else
                                                        {
                                                            echo "<option value='".$valor['IdTipoPago']."'>".$valor['TipoPago']."</option>";
                                                        }
                                                    }                           
                                                    echo "</select>";
                                                    echo "</td>";
                                                echo "</tr>";         
                        
                                                echo "<tr>";
                                                    echo "<td><span class='normal'>Total de Pagos</span></td>";                           
                                                    echo" <td colspan='3'><input  type='text'    name='totalpagos' id='totalpagos' value='".$totalpagos."'></td>";                          
                                                echo "</tr>";        
                    
                                                echo "<tr>";
                                                    echo "<td><span class='normal'>Pago</span></td>";                           
                                                    echo" <td colspan='3'><input  type='text'    name='montopago' id='montopago'  onkeyup='CalcularMontoPago();'  value='".number_format((float)($montopago), 2, '.', '')."'></td>";                          
                                                echo "</tr>"; 
                    
                                                echo "<tr>";
                                                    echo "<td><span class='normal'>Ultimo Pago</span></td>";                           
                                                    echo" <td colspan='3'><input  type='text'    name='ultimopago' id='ultimopago' value='".number_format((float)($ultimopago), 2, '.', '')."'></td>";                          
                                                echo "</tr>"; 
                    
                                                echo "<tr>";
                                                    echo "<td><span class='normal'>Gastos Administrativos</span></td>";                           
                                                    echo" <td colspan='3'><input  type='text'    name='gtsadmonpago' id='gtsadmonpago' onkeyup='CalcularMontoPago();' value='".number_format((float)($gtsadmonpago), 2, '.', '')."'></td>";                          
                                                echo "</tr>"; 
                    
                                                echo "<tr>";
                                                    echo "<td><span class='normal'>Seguro de Vida</span></td>";                           
                                                    echo" <td colspan='3'><input  type='text'    name='segurovida' id='segurovida' onkeyup='CalcularMontoPago();' value='".number_format((float)($segurovida), 2, '.', '')."'></td>";                          
                                                echo "</tr>"; 
                    
                                                echo "<tr>";
                                                    echo "<td><span class='normal'>OtroCargo</span></td>";                           
                                                    echo" <td colspan='3'><input  type='text'    name='otrocargo' id='otrocargo' onkeyup='CalcularMontoPago();' value='".number_format((float)($otrocargo), 2, '.', '')."'></td>";                          
                                                echo "</tr>"; 
                    
                                                echo "<tr>";                       
                                                    echo "<td><span class='normal'>Especifique</span></td>";                           
                                                    echo" <td colspan='3'>";                           
                                                    echo "<select  id='conceptocargo'  name='conceptocargo' >";
                                                    $sql2="select * from catconceptocargo"; 
                                                    $r2 = $Vivienda -> query($sql2); 
                                                    while($valor = $r2 -> fetch_array())
                                                {
                                                        if ($idconceptocargo==$valor['IdConceptoCargo'])
                                                        {
                                                        echo "<option value='".$valor['IdConceptoCargo']."' selected>".$valor['ConceptoCargo']."</option>";
                                                        }
                                                        else
                                                        {
                                                            echo "<option value='".$valor['IdConceptoCargo']."'>".$valor['ConceptoCargo']."</option>";
                                                        }
                                                    }                           
                                                    echo "</select>";
                                                    echo "</td>";
                                                echo "</tr>"; 
                                
                                                echo "<tr>";
                                                    echo "<td><span class='normal'>Total Monto Pago</span></td>";                           
                                                    echo" <td colspan='3'><input  type='text'    name='totalmontopago' id='totalmontopago' readonly value='".number_format((float)($totalmontopago), 2, '.', '')."'></td>";                          
                                                echo "</tr>"; 
                                                
                        
                                                echo "</table>";
                                            echo '</div>';
                        
                                            //*** INTERESES */
                                            echo ' <div class="col-xs-6 col-md-4" style="text-align: justify; margin: 0px;">';
                                                echo '<br>'; 
                                                echo '<h6 class="card-title">INTERESES</h6>';                                
                                                echo "<table style='width:90%; margin-left: 20px; font-size: 10pt;'>";
                                                    
                                                echo "<tr>";
                                                    echo "<td><span class='normal'>Tasa Anual</span></td>";                           
                                                    echo" <td colspan='3'><input  type='text'    name='tasaanual' id='tasaanual' value='".number_format((float)($tasaanualfin), 2, '.', '')."'></td>";                          
                                                    echo "<td><span class='normal'>%</span></td>";    
                                                echo "</tr>"; 
                    
                                                echo "<tr>";
                                                  
                                                    echo "<td><span class='normal'>Tipo Intereses</span></td>";                           
                                                    echo" <td colspan='3'>";                                
                                                    echo '<div class="form-check form-check-inline" >
                                                    <input class="form-check-input" type="radio" name="tipoInteres" id="tipoInteres" checked  style="width: 15px;height: 15px;" value="0" '.$acumulado.'>
                                                    <label  for="inlineRadio1">Acumulado</label>
                                                    </div>
                                                    <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="tipoInteres" id="tipoInteres" value="1" style="width: 15px;height: 15px;" '.$fijo.'>
                                                    <label  for="inlineRadio2">Cuota Fija</label>
                                                    </div>';                            
                                                    echo "</td>";                          
                                                echo "</tr>"; 
                    
                                                echo "<tr>";
                                                    echo "<td><span class='normal'>Tasa Interes Mora</span></td>";                           
                                                    echo" <td colspan='3'><input  type='text'    name='tasaintmora' id='tasaintmora' value='".number_format((float)($tasaintmora), 2, '.', '')."'></td>";                          
                                                    echo "<td><span class='normal'>%</span></td>";    
                                                echo "</tr>"; 
                    
                                                echo "<tr>";
                                                    echo "<td><span class='normal'>Dias de Gracia</span></td>";                           
                                                    echo" <td colspan='3'><input  type='text'    name='diasgracia' id='diasgracia' value='".$diasgracia."'></td>";                          
                                                echo "</tr>"; 
                    
                                                echo "<tr>";
                                                    echo "<td><span class='normal'>Periodo Mora</span></td>";                           
                                                    echo" <td colspan='3'><input  type='text'    name='periodomora' id='periodomora' value='".$periodomora."'></td>";                          
                                                echo "</tr>";                                
                                                echo "</table>";
                    
                    
                                                    //***MINISTRACION CREDITO */
                                                    echo ' <div style="text-align: justify; margin: 0px;">';
                                                                echo '<br>'; 
                                                                echo '<h6 class="card-title">MINISTRACION CREDITO</h6>';                                
                                                                echo "<table style='width:90%; margin-left: 20px; font-size: 10pt;'>";                                
                                                                    echo "<tr>";
                                                                        echo "<td><span class='normal'>Ministracion 1</span></td>";                           
                                                                        echo" <td colspan='3'><input  type='text'    name='ministracion1' id='ministracion1' value='".number_format((float)($ministracion1), 2, '.', '')."'></td>";                          
                                                                    echo "</tr>";
                    
                                                                    echo "<tr>";
                                                                        echo "<td><span class='normal'>Ministracion 2</span></td>";                           
                                                                        echo" <td colspan='3'><input  type='text'    name='ministracion2' id='ministracion2' value='".number_format((float)($ministracion2), 2, '.', '')."'></td>";                          
                                                                    echo "</tr>";
                    
                                                                    echo "<tr>";
                                                                        echo "<td><span class='normal'>Ministracion 3</span></td>";                           
                                                                        echo" <td colspan='3'><input  type='text'    name='ministracion3' id='ministracion3' value='".number_format((float)($ministracion3), 2, '.', '')."'></td>";                          
                                                                    echo "</tr>";
                    
                                                            echo "</table>";
                                                        echo '</div>';
                                                echo '</div>';
                                                echo ' <div style="text-align: left; padding: 10px; width:49%">';
                                                    echo '<h6 class="card-title">DOCUMENTO MAESTRO</h6>';
                                                    echo "<input  type='text' name='documentomaestro' id='documentomaestro'> ";
                                                echo '</div>';

                                                echo ' <div style="text-align: left; padding: 10px; width:49%">';
                                                    echo '<h6 class="card-title">CERTIFICADO DE SUBSIDIO FEDERAL</h6>';
                                                    echo "<input  type='text' name='certificadosubsidio' id='certificadosubsidio'> ";
                                                echo '</div>';
                                            
                                        echo '</div>';                                    
                                        echo '</div>';
                                        
                                        echo '</br>';
                                      
                                        echo '<div class="card " style="text-align: justify; width: 90%;">';
                                        echo '<h1 class="card-header h5" style="text-transform: uppercase;font-size: 10pt;">Datos del Aval</h1>'; 
                                        
                                        echo '<div style="text-align: left; padding: 10px; width:90%">';
                                                    echo '<h6 class="card-title">NOMBRE AVAL</h6>';
                                                    echo "<input  type='text' name='NombreAval' id='NombreAval' value='".$AvalContrato."'> ";
                                        echo '</div>';
                                                                       
                                        echo '<div class="row" style="width:98%;margin:0px;">';                                    
                                        echo '<div class="col-md-6" style="text-align: justify; padding: 2px; margin-right: 0px; padding: 10px;">';
                                        echo '<br>';  
                                        echo '<h6 class="card-title">DOMICILIO</h6>';  
                                        echo "<table style='width:80%; margin-left: 20px; font-size: 10pt;  '>";
                                        echo "<tr>";
                                            echo "<td><span class='normal'>Calle</span></td>";                           
                                            echo" <td colspan='4'><input  type='text'    name='CalleAval' id='CalleAval'  value='".$AvalCalleyNum."'></td>";                          
                                        echo "</tr>"; 
                            
                                        echo "<tr>";
                                            echo "<td><span class='normal'>Entre Calle</span></td>";                           
                                            echo" <td colspan='3'><input  type='text'    name='EntreCalleAval' id='EntreCalleAval'  value='".$AvalEntreCalle."'></td>";                          
                                        echo "</tr>"; 
                            
                                        echo "<tr>";
                                            echo "<td><span class='normal'>Y Entre Calle</span></td>";                           
                                            echo" <td colspan='3'><input  type='text'    name='EntreCalleAval2'  id='EntreCalleAval2'   value='".$Aval_YCalle."' ></td>";                          
                                        echo "</tr>";                
                            
                                        echo "<tr>";                       
                                            echo "<td><span class='normal'>Municipio</span></td>";                           
                                            echo" <td colspan='3'>";                           
                                             echo "<select  id='MunicipioAval'  name='MunicipioAval'  onchange='LlenarColonias(0)'>";
                                             $sql2="SELECT municipios.Municipio, catdelmun.IdDelegacion, catdelmun.IdMunicipio  
                                             FROM municipios INNER JOIN catdelmun ON municipios.IDMUNICIPIO = catdelmun.IDMUNICIPIO 
                                             WHERE (((catdelmun.IDDELEGACION)=".$IdDelegacion.")) OR (((catdelmun.IDDELEGACION)=0) 
                                             AND ((catdelmun.IDMUNICIPIO)=0)) ORDER BY municipios.MUNICIPIO"; 
                                            //echo $sql2;
                                            $r2 = $Vivienda -> query($sql2); 
                                            while($valor = $r2 -> fetch_array())
                                            {
                                                
                                                $IdMunicipioAval=IdMunicipioAvalColonias(IdColoniaAvalContrato($NumContrato));
                                                if ($IdMunicipioAval==$valor['IdMunicipio'])
                                                {
                                                echo "<option value='".$valor['IdMunicipio']."' selected>".$valor['Municipio']."</option>";
                                                }
                                                else
                                                {
                                                    echo "<option value='".$valor['IdMunicipio']."'>".$valor['Municipio']."</option>";
                                                }
                                            }                           
                                            echo "</select>";
                                            echo "</td>";
                                        echo "</tr>" ;
                            
                                        echo "<tr>";
                                             echo "<td><span class='normal'>Colonia</span></td>";                           
                                             echo" <td colspan='3'><div name='IdColoniaAval'    id='IdColoniaAval' style='width: 100%;'>
                                             <select id='ColoniaAval' name='ColoniaAval'></select>
                                             </div></td>";                          
                                        echo "</tr>"; 
                            
                                        echo "<tr>";
                                             echo "<td><span class='normal'>Codigo Postal</span></td>";                           
                                             echo" <td colspan='3'><input  type='text'    name='CPAval'    id='CPAval' ></td>";                          
                                        echo "</tr>";
                                        
                                        echo "<tr>";
                                             echo "<td><span class='normal'>Telefono de Casa </span></td>";                           
                                             echo" <td colspan='3'><input  type='text'    name='TelCasaAval'  id='TelCasaAval' value='".$AvalTelCasa."'></td>";                          
                                        echo "</tr>"; 
                                        echo "</table>";     
                            
                                         echo '</div>';
                            
                                        echo '<div class="col-md-6" style="text-align: justify; padding: 2px; margin-right: 0px; padding: 10px;">';
                                        echo '<br>'; 
                                        echo '<h6 class="card-title">DATOS DEL TRABAJO</h6>';   
                            
                                        echo "<table style='width:80%; margin-left: 20px; font-size: 10pt; '>";
                                        echo "<tr>";
                                             echo "<td><span class='normal'>Telefono de Trabajo</span></td>";                           
                                             echo" <td colspan='3'><input  type='text'    name='TelTabajoAval'    id='TelTabajoAval'  value='".$AvalTelTrabajo."'></td>";                          
                                        echo "</tr>"; 
                            
                                        echo "<tr>";
                                             echo "<td><span class='normal'>Lugar de Trabajo</span></td>";                           
                                             echo" <td colspan='3'><input  type='text'    name='LugarTrabajoAval'    id='LugarTrabajoAval'  value='".$AvalLugTrabajo."' ></td>";                          
                                        echo "</tr>"; 
                            
                                        echo "<tr>";
                                             echo "<td><span class='normal'>Domicilio del Trabajo</span></td>";                           
                                             echo" <td colspan='3'><input  type='text'    name='DomicilioTrabajoAval'    id='DomicilioTrabajoAval' value='".$AvalContrato."'></td>";                          
                                        echo "</tr>"; 
                                       echo "</table>"; 
                                        echo '</div>';
                                         echo '</div>';
                                        echo '</div>';
                                        echo "<br>";
                                        

                                        //se comento lo del vale por que se metera en una app aparte
                                    /*    if( TipoImpVale($IdPrograma)!="3")
                                        {
                                        echo '<div class="card " style="text-align: justify; width: 90%;">';
                                        echo '<h1 class="card-header h5" style="text-transform: uppercase;font-size: 10pt;">VALE</h1>'; 
                                        
                                        echo "<br>";

                                        echo "<table style='width:80%; margin-left: 20px; font-size: 10pt;' >";
                                        echo "<tr>";                       
                                        echo "<td><span class='normal'>Casa comercial</span></td>";                           
                                            echo" <td colspan='3'>";                           
                                            echo "<select  id='casacomercial'  name='casacomercial' >";
                                            $IdMunicipio = IdCiudadVivienda($IdDelegacion,$IdPrograma,$Folio);
                                           // $sql2="select * from  casascomerciales where Cancelado=0"; 
                                            $sql2="SELECT casascomerciales.IdComercial, casascomerciales.CasaComercial 
                                            from catccmun INNER JOIN casascomerciales ON catccmun.idreemplazo = casascomerciales.IDcomercial  
                                            WHERE (catccmun.IdMunicipioSurte =".$IdMunicipio." OR casascomerciales.IDCOMERCIAL=0 ) AND (casascomerciales.CANCELADO<>1) 
                                            ORDER BY casascomerciales.CASACOMERCIAL"; 
                                            echo $sql2;

                                            $r2 = $Vivienda -> query($sql2); 
                                            while($valor = $r2 -> fetch_array())
                                            {
                                                if ($idcasacomercial==$valor['IdComercial'])
                                                {
                                                echo "<option value='".$valor['IdComercial']."' selected>".$valor['CasaComercial']."</option>";
                                                }
                                                else
                                                {
                                                    echo "<option value='".$valor['IdComercial']."'>".$valor['CasaComercial']."</option>";
                                                }
                                            }                           
                                            echo "</select>";
                                            echo "</td>";
                                        echo "</tr>";  

                                            echo "<tr>";
                                                 echo "<td><span class='normal'>Importe</span></td>";                           
                                                 echo" <td colspan='3'><input  type='text'    name='ImporteVale'    id='ImporteVale' ></td>";                          
                                            echo "</tr>";
                                            
                                            echo "<tr>";
                                                echo "<td><span class='normal'>Monto tope del beneficio</span></td>";                           
                                                echo" <td colspan='3'><input  type='text'    name='MontoTope'    id='MontoTope' ></td>";                          
                                            echo "</tr>"; 

                                            echo "<tr>";
                                                 echo "<td><span class='normal'>Fecha Emision</span></td>";                           
                                                 echo" <td colspan='3'><input  type='date'  name='fechaemision' id='fechaemision' value='".$fechaActual."'></td>";                                                    
                                            echo "</tr>"; 

                                            echo "<tr>";                       
                                                echo "<td><span class='normal'>Bloquera para producir</span></td>";                           
                                                echo" <td colspan='3'>";                           
                                                echo "<select  id='bloquera'  name='bloquera' >";
                                                $sql2="Select idbloquera, iddelegacion, CONCAT(nombre,' - ',Ubicacion,' - ' ,TipoCPA) as descripcion  from catbloqueras 
                                                where iddelegacion=".$IdDelegacion." and (cancelada=0 or Cancelada is null)"; 
                                                $r2 = $Vivienda -> query($sql2); 
                                                while($valor = $r2 -> fetch_array())
                                                {
                                                    if ($idbloquera==$valor['idbloquera'])
                                                    {
                                                    echo "<option value='".$valor['idbloquera']."' selected>".$valor['descripcion']."</option>";
                                                    }
                                                    else
                                                    {
                                                        echo "<option value='".$valor['idbloquera']."'>".$valor['descripcion']."</option>";
                                                    }
                                                }                           
                                                echo "</select>";
                                                echo "</td>";
                                            echo "</tr>";                                           
                                            echo "</table>";  
                                            echo "<br>"; 
                                        echo '</div>';
                                        }    */
                                        echo '</center>';                                          
                                        echo '</section>';

                                          if($NumContrato == '')
                                            {                             
                                                echo "<button type='submit' class='btn btn-primary'>Generar Contrato</button>";
                                            }
                                        echo '</form>';                         
                                    }else{
                                    mensaje('Esta solicitud no ha sido APROBADA/EVALUADA, favor de aprobarla en el módulo evaluación.','contratacion.php'); 
                                          }
                       
                                }// fin de if IDEMPLEADOEVALUADOR
                                else {
                                        mensaje('La solicitud a un no esta autorizada....','contratacion.php');
                                }
                   
                    }// fin de if idpaqueteMaterial
                    else {
                        mensaje('La solicitud no tiene paquete registrado.','contratacion.php');
                    }                  
                    echo '</center>'; 


                    if ($NumContrato!='' AND ($contratocancelado==0 OR $contratocancelado=="") )
                    {
                        //echo 'contrato activo';
                    }
                    else
                    {
                        
                        if($NumContrato!='' AND ($contratocancelado==1))
                        {
                        $url =  $_SERVER['REQUEST_URI'].'&m2';
                        if( !isset($_GET['m2']))
                        { 
                            mensaje('El contrato se encuentra cancelado!.',$url);
                        } 
                        }
                       
        
                    }   
                    
                }// CIERRA SI NO ETA CANCELADA
               
            }// CIERRA CUANDO SI ENCUENTRA UNA SOLICITUD
        }//CIERRE DONDE SE VALIDA SI YA EXISTE UN CONTRATO PARA ESA SOLICITUD

    }else{
        mensaje('No se recibieron correctamente los datos, intentelo de nuevo.','contratacion.php');
    }
    
}else{
    mensaje("ERROR: no tienes acceso a este modulo","");
}

?>

<?php include ("lib/body_footer.php"); ?>

<script>
function CalculaGtsInd()
{
    pagoinicial = 0
    var idpagoInicial = document.getElementById("idtipopagoinicial").value;

    if (idpagoInicial== 1 || idpagoInicial == 3 || idpagoInicial== 10 )
    {
        //el pago inicial es un ahorro o un enganche
        pagoinicial = document.getElementById("montopagoinicial").value;
    }
    else
    {
        //no hay pago inicial o es una amortizacion
        pagoinicial = 0;
    } 
}

function AplicaGastos()
{
  
    var aplicagtsadmon = document.getElementById("aplicagtsadmon").value;
    var gtsadmon=document.getElementById("gtsadmon").value;
    var montocredito = document.getElementById("montocredito").value;
    var subsidioitavu = document.getElementById("subsidioitavu").value;
    var subsidiofonhapo=document.getElementById("subsidiofonhapo").value; 
    var pagoincial = document.getElementById("montopagoinicial").value;
    console.log(aplicagtsadmon);
    switch (aplicagtsadmon) {
        case '0':  //no aplica
            document.getElementById("gtsadmonc").value = 0;
            document.getElementById("gtsadmon").value=0;
            break;
        case '1':  //aplica sobre credito
            document.getElementById("gtsadmonc").value = (parseFloat(montocredito) * (parseFloat(gtsadmon) / 100)).toFixed(2); ;
            break;
        case '2': //aplica sobre credito - pagoinicial (ya sea enganche o ahorro voluntario)
            document.getElementById("gtsadmonc").value= ((parseFloat(montocredito) - parseFloat(pagoinicial)) * (parseFloat(gtsadmon) / 100)).toFixed(2); ;
            break;
        ///revisar esta ultima operacion
        case '3': //aplica sobre credito  - subsidio
            document.getElementById("gtsadmonc").value = ((parseFloat(montocredito) - parseFloat(subsidioitavu) - parseFloat(subsidiofonhapo)) * parseFloat((gtsadmon) / 100)).toFixed(2); ;
            break;
        case '4': //aplica sobre credito  - pago inicial (ya sea enganche o ahorro voluntario) - subsidio
            document.getElementById("gtsadmonc").value = ((parseFloat(montocredito) - parseFloat(pagoinicial) - parseFloat(subsidioitavu) - parseFloat(subsidiofonhapo)) * (parseFloat(gtsadmon) / 100)).toFixed(2);
            break;
       
    }

    CalcularFinanciamiento();
  
}

       
function CalcularSubsidio()
{  
    var subsidioitavu = document.getElementById("subsidioitavu").value;
    var subsidiofonhapo=document.getElementById("subsidiofonhapo").value;        
    document.getElementById("subsidio").value =(parseFloat(subsidioitavu) + parseFloat(subsidiofonhapo)).toFixed(2); 
}

function CalcularMontoPago()
{   
    var segurovida=document.getElementById("segurovida").value;
    var otrocargo=document.getElementById("otrocargo").value;
    var gtsadmonpago=document.getElementById("gtsadmonpago").value;
    var montopago=document.getElementById("montopago").value;
    document.getElementById("totalmontopago").value  = (parseFloat(montopago) + (parseFloat(montopago) * (parseFloat(gtsadmonpago) / 100)) + parseFloat(segurovida) + parseFloat(otrocargo)).toFixed(2);
}

function CalcularFinanciamiento()
{   document.getElementById("totalfinanciar").value =0;
    pagoinicial = 0
    var idpagoInicial = document.getElementById("idtipopagoinicial").value;   
    var montocredito = document.getElementById("montocredito").value;
    var escrituracion=document.getElementById("gtsescrituracion").value;   
    var subsidio= document.getElementById("subsidio").value; 
    var gtsadmonc= document.getElementById("gtsadmonc").value;
    var pagoincial = document.getElementById("montopagoinicial").value;
    
    if(idpagoInicial==4)
    {
        pagoincial=0;
    }

    document.getElementById("totalfinanciar").value  =((((parseFloat(montocredito)) + parseFloat(escrituracion) + parseFloat(gtsadmonc)) - parseFloat(subsidio)) - parseFloat(pagoincial)).toFixed(2);
}     


$( document ).ready(function() {
    
    AplicaGastos();
    CalculaGtsInd();
    CalcularSubsidio();
    CalcularMontoPago();
    CalcularFinanciamiento();
});

function LlenarColonias()
{
    var id = document.getElementById("MunicipioAval").value;
        $.ajax({
            url: "cboxColoniasDom.php",
            type: "get",
            data: {idmun: id},
            success: function(data){              
                $('#IdColoniaAval').html(data+"\n");
            }
        });
  
}

function Plantillas(id)
{
  

        $.ajax({
            url: "ContararCreito.php",
            type: "get",
            data: {id: id},idcol:idcol,
            success: function(data){              
                $('#colonia').html(data+"\n");
            }
        });

       
}
</script>