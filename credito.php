
<?php
require_once("config.php");
require_once("lib/funciones.php");
require_once("lib/flor_funciones.php");
require_once("lib/yes_funciones.php");



$id_aplicacion ="ap113"; 
 if(isset($_POST['IdMunicipio']) and isset($_POST['IdColonia']) 
 and isset($_POST['Seccion']) and isset($_POST['Fila']) and isset($_POST['Manzana']) 
 and isset($_POST['Lote'])
 and isset($_POST['Del']) and isset($_POST['Programa']) and isset($_POST['Folio'])){


    $idmun = $_POST['IdMunicipio'];
    $idcol = $_POST['IdColonia'];
    $sec = $_POST['Seccion'];
    $fila = $_POST['Fila'];
    $man = $_POST['Manzana'];
    $lote = $_POST['Lote'];

    $iddelegacion = $_POST['Del'];
    $idprograma = $_POST['Programa'];
    $folio = $_POST['Folio'];
    $nitavu = $_POST['nitavu'];
    $nombeneficiario = $_POST['nombeneficiario'];
   

   if (isset($_POST['Idlote'])){ 
       $idLote = $_POST['Idlote']; 
    }else{ 
        $idLote = '';    
    }
   
    if($idLote=='')
    {
        $sql = "select * FROM lotes
        WHERE IdMunicipio = ".$idmun."  AND IdColonia = ".$idcol." AND IFNULL(seccion, '') = '".$sec."' AND  IFNULL(fila, '')  = '".$fila."'
        AND manzana = '".$man."' AND lote = '".$lote."' and (Cancelado!=1)";
    }
    else
    {
        $sql = "select * FROM lotes WHERE idLote = ".$idLote." and (Cancelado!=1)";
    }
    
    //echo $sql;
    $r = $Vivienda -> query($sql);
    if ($r -> num_rows >0){
        while($f = $r -> fetch_array()){

            echo "<div id='AquiVaMiPlantilla'>
            </div>";

            $idLote=$f['idLote'];

            //VALIDA SI EL LOTE NO ESTA CONTRATADO...
          
           // $NumContrato= buscarSiYaTieneContrato($iddelegacion, $idprograma, $folio);
            $NumContrato = buscarSiYaTieneContratoActivoOno($iddelegacion, $idprograma, $folio); 
            if($NumContrato=='')
            {
                if( ValidarLoteContratado($f['idLote'])=='TRUE'  ) 
                {  
                      
                    if ($NumContrato=='' )
                    {
                    echo "<h3 style='color: red; font-size:9pt;' id='EtiquetaContratado' name='EtiquetaContratado'>No es posible asignar el lote, el lote se encuentra en estatus de contratado!!</h3>";   
                    echo "<script> $('#formdatos').css({'display':'none'}); console.log('Contratado');</script>";
                    }
                    
                }else{
    
                                  
                    if(LibreParaAsignacion($f['idLote']) != 0 ){
                        echo "<h3 style='color: red; font-size:9pt;' id='EtiquetaContratado' name='EtiquetaContratado'>No es posible asignar el lote, debido a que se encuentra en un estatus diferente al de asignación!!</h3>";   
                        echo "<script> $('#formdatos').css({'display':'none'}); console.log('IdloteDiferente de 0');</script>";
                    }
    
                }
            }
            
           
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

            echo "<form id='formdatos' action='generarContrato.php?delegacion=".$iddelegacion."&programa=".$idprograma."&folio=".$folio."&nitavu=".$nitavu."' method='POST'>";
                echo "<input type='hidden' name='postID' ";
                echo "value='".md5(uniqid(rand(), true))."'>";
                echo "<input type='hidden' name='idlote' id='idlote' value='".$f['idLote']."'>";
                echo "<input type='hidden' id='municipio' name='municipio' value='".$f['IdMunicipio']."'>";
                echo "<input type='hidden' id='colonia' name='colonia' value='".$f['IdColonia']."'>";
                echo "<input type='hidden' id='seccion' name='seccion'  value='".$f['seccion']."'>";
                echo "<input type='hidden' id='fila' name='fila' value='".$f['fila']."'>";
                echo "<input type='hidden' id='manzana' name='manzana'  value='".$f['manzana']."'>";  
                echo "<input type='hidden' id='lote' name='lote'  value='".$f['lote']."'>";
                echo "<input type='hidden' id='superficie' name='superficie' value='".$f['superficie']."'>";
                echo "<input type='hidden' id='nomcolonia' name='nomcolonia' value='".NombreColoniaVivienda($f['IdMunicipio'],$f['IdColonia'])."'>";
                echo "<input type='hidden' id='beneficiario' name='beneficiario' value='".$nombeneficiario."'>";
               //*********************** DIV OTROS DATOS **************************************       
               echo "<div style='width:100%' id=divDatos>";
               echo '<div class="card" style="text-align: justify; width: 100%;">
                       <h1 class="card-header h5" style="text-transform: uppercase;font-size: 10pt;">Medidas y Colindancias</h1>';
                       echo '<div class="card-body" style="font-size: 10pt; width: 100%;">'; 
                            /* **************************** MEDIDAS Y COLINDANCIAS ***************************** */
                            echo MuestraMedidaColindanciasLote($f['idLote'],'width: 90%;font-size: 10pt;');        
                       echo '</div>';
               echo '</div>';
           echo '</div>'; 
           echo '<br>'; 
           echo '<br>'; 
           
          
            if((LibreParaAsignacion($f['idLote']) != 0) or ($f['localiza'] == 1) or ($f['NumContrato'] != '' OR $f['NumContrato']!=NULL)){
                //NO EDITAS DATOS

                echo '<div class="card " style="text-align: justify; width: 100%;">
                        <h1 class="card-header h5" style="text-transform: uppercase;font-size: 10pt;">Datos del Crédito</h1>';     
                        echo '<center>';          
                        echo '<div class="row" style="width:98%; margin: 0px;">';                           
                            //*** CREDITO */
                            echo ' <div class="col-xs-6 col-md-4" style="text-align: justify; margin: 0px;">';
                            echo '<br>'; 
                                echo '<h6 class="card-title">Crédito</h6>';                                
                                echo "<table style='width:90%; margin-left: 20px; font-size: 10pt;'>
                                <tr>
                                    <td><span class='normal'>Tipo de Moneda</span></td>
                                    <td><span>".TipoMoneda(TipoMonedaDatosEvaluacion($iddelegacion,$idprograma,$folio))."</span>
                                    <input  type='hidden'   name='IdTipoMoneda' id='IdTipoMoneda' value='".TipoMonedaDatosEvaluacion($iddelegacion,$idprograma,$folio)."'></td>
                                </tr>
                                <tr>
                                    <td><span class='normal'>Monto Del Credito</span></td>
                                    <td><span> $ ".trim($f['precio']) ."</span>
                                    <input  type='hidden'   name='precio' id='precio' value='".trim($f['precio'])."'>
                                    </td>
                                </tr>
                                <tr>
                                    <td><span class='normal'>Tipo de Pago Inicial</span></td>
                                    <td><span>".TipoPagoInicial(TipoPagoInicialDatosEvaluacion($iddelegacion,$idprograma,$folio))."</span>
                                    <input  type='hidden'   name='IdPagoInicial' id='IdPagoInicial' value='".TipoPagoInicialDatosEvaluacion($iddelegacion,$idprograma,$folio)."'></td>
                                </tr>
                                <tr>
                                    <td><span class='normal'>Monto Pago Inicial</span></td>
                                    <td><span> $ ".trim($f['MontoPagoInicial'])."</span>
                                    <input  type='hidden'   name='MontoPagoInicial' id='MontoPagoInicial' value='".trim($f['MontoPagoInicial'])."'></td>
                                </tr>";
                                // <tr>
                                //     <td><span class='normal'>Aplica Gastos de Admon</span></td>
                                //     <td><span>".TipoAplicaGtsAdmon(AplicaGastosAdmonDatosEvaluacion($iddelegacion,$idprograma,$folio))."</span></td>
                                // </tr>
                                // <tr>
                                //     <td><span class='normal '>Gastos de Admon</span></td>
                                //     <td> </td>
                                // </tr>
                                // <tr>
                                //     <td><span class='normal'>Gastos de Escrituracion</span></td>
                                //     <td> </td>
                                // </tr>
                                echo "<tr>";
                                    $subsidio= SubsidioFederalLotes($f['idLote']) + SubsidioEstatalLotes($f['idLote']) ;
                                    echo "<td><span class='normal'>Subsidio</span></td>
                                    <td><span>$ 0</span></td>
                                </tr>";
                                echo "<tr>
                                <td><span class='normal'>Total a Financiar</span></td>";                              
                                $totalafinaciar=$f['precio']-$f['MontoPagoInicial']-$subsidio;  
                                $totalafinaciar= number_format((float)$totalafinaciar, 2, '.', ''); 
                                echo "<td><span>$ ".$totalafinaciar."</span><input type='hidden' value='".$totalafinaciar."' name='totalafinanciar' id='totalafinanciar'>
                                </tr>";                                            
                                echo "</table>";
                            echo '</div>';

                                    //*** FORMA DE PAPGO */
                            echo ' <div class="col-xs-6 col-md-4" style="text-align: justify; margin: 0px;">'; 
                            echo '<br>';     
                                echo '<h6 class="card-title">Forma de Pago</h6>';   
                                echo "<table style='width:90%; margin-left: 20px; font-size: 10pt;'>
                                    <tr>
                                        <td><span class='normal'>Tipo de Pago</span></td>
                                        <td><span>".TipoPago($f['TipoPago'])."</span>
                                        <input  type='hidden'   name='TipoPago' id='TipoPago' value='".$f['TipoPago']."'></td>
                                    </tr>
                                    <tr>
                                        <td><span class='normal'>N° de Mensualidades</span></td>
                                        <td><span>".$f['TotalPagos']."</span>
                                        <input  type='hidden'   name='TotalPagos' id='TotalPagos' value='".$f['TotalPagos']."'></td>
                                    </tr>
                                    <tr>
                                        <td><span class='normal'>Monto de Menusalidad</span></td>
                                        <td><span>$ ".$f['MontoPago']."</span>
                                        <input  type='hidden'   name='MontoPago' id='MontoPago' value='".$f['MontoPago']."'></td>
                                    </tr>
                                    <tr>
                                        <td><span class='normal'>Monto Ultimo Pago</span></td>
                                        <td><span> $".$f['MontoUltimoPago']."</span>
                                        <input  type='hidden'   name='MontoUltimoPago' id='MontoUltimoPago' value='".$f['MontoUltimoPago']."'></td>
                                    </tr>";
                                    /*
                                    echo "<tr>
                                        <td><span class='normal'>Gastos Admon</span></td>
                                        <td> </td>
                                    </tr>
                                    <tr>
                                        <td><span class='normal '>Segurdo de Vida</span></td>
                                        <td> </td>
                                    </tr>
                                    <tr>
                                        <td><span class='normal'>Otros Cargos</span></td>
                                        <td> </td>
                                    </tr>";  */                   
                                                                           
                                echo "</table>";
                                echo '<br>';  
                                echo '<h6 class="card-title">Beneficiario</h6>';                               
                                echo "<table style='width:90%; margin-left: 20px; font-size: 10pt;' >";
                                
                                echo "<tr>";
                                    echo "<td><span class='normal'>Aportación</span></td>";                           
                                    echo "<td><span>$ ".ObtenerTotalAbonadoPorSolicitud($iddelegacion,$idprograma,$folio)."</span>
                                    <input  type='hidden'   name='TotalAbonado' id='TotalAbonado' value='".ObtenerTotalAbonadoPorSolicitud($iddelegacion,$idprograma,$folio)."'>
                                    </td>";
                                echo "</tr>";                   
                                    
                                echo "</table>";                               
                            echo '</div>';

                            //*** INTERES MORATORIO */     
                            echo ' <div class="col-xs-6 col-md-4" style="text-align: justify; margin: 0px;">'; 
                                echo '<br>';  
                                echo '<h6 class="card-title">Tasa de Financiamiento</h6>';                               
                                echo "<table style='width:90%; margin-left: 20px; font-size: 10pt;' >";
                                
                                echo "<tr>";
                                    echo "<td><span class='normal'>Tasa Anual</span></td>";                           
                                    echo "<td><span>".$f['TasaAnualFin']."</span>
                                    <input  type='hidden'   name='TasaAnualFin' id='TasaAnualFin' value='".$f['TasaAnualFin']."'></td>";
                                echo "</tr>";                   
                                    
                                echo "</table>";
                                echo "<br>";

                                echo '<h6 class="card-title">Interes Moratorio</h6>';                               
                                echo "<table style='width:90%; margin-left: 20px; font-size: 10pt;'>
                                    <tr>
                                        <td><span class='normal'>Tipo de Interes</span></td>
                                        <td><span>".TipoInteresMoratorio(TipoIntMoratorioDatosEvaluacion($iddelegacion,$idprograma,$folio))."</span>
                                        <input  type='hidden' name='TipoIntMoratorio' id='TipoIntMoratorio' value='".TipoIntMoratorioDatosEvaluacion($iddelegacion,$idprograma,$folio)."'></td>
                                    </tr>
                                    <tr>
                                        <td><span class='normal'>Tasa de Interes Moratorio</span></td>
                                        <td><span>".$f['TasaIntMora']."</span>
                                        <input  type='hidden' name='TasaIntMora' id='TasaIntMora' value='".$f['TasaIntMora']."'></td>                                     
                                        </tr>";
                                // echo "<tr>
                                //         <td><span class='normal'>Monto de Interes Moratorio</span></td>
                                //         <td> </td>
                                //     </tr>
                                //     <tr>
                                //         <td><span class='normal'>Dias de Gracia</span></td>
                                //         <td></td>
                                // </tr>";
                                echo "<tr>
                                        <td><span class='normal'>Periodo de Moratorio</span></td>
                                        <td><span>".PeriodoMoraDatosEvaluacion($iddelegacion,$idprograma,$folio)."</span>
                                        <input  type='hidden'   name='PeriodoMora' id='PeriodoMora' value='".PeriodoMoraDatosEvaluacion($iddelegacion,$idprograma,$folio)."'></td>
                                    </tr>";                                                        
                                echo "</table>";
                            echo '</div>';                           
                         echo '</div>';
                         echo '</center>';    
            echo '</div>';


               
  
            }else{
                //EDITAS DATOS DEL LOTE
                echo '<div class="card " style="text-align: justify; width: 100%;">
                <h1 class="card-header h5" style="text-transform: uppercase;font-size: 10pt;">Datos del Crédito</h1>';    
                echo '<center>';           
                echo '<div class="row" style="width:98%;margin:0px;">';              
                   
                //*** DATOS DEL CREDITO */
                echo ' <div class="col-xs-6 col-md-4" style="text-align: justify; margin: 0px;">';
                echo '<br>'; 
                    echo '<h6 class="card-title">Crédito</h6>';                                
                    echo "<table style='width:90%; margin-left: 20px; font-size: 10pt;'>";
                    echo"<tr>";
                        echo "<td width=45%><span class='normal'>Tipo de Moneda</span></td>";                         
                        echo "<td valign='middle' align='center'  colspan='3'>";
                            echo "<div'><table width=100% class='menu_font_n10'><tr><td>";
                            echo "<select  id='IdTipoMoneda' onchange='GuardarDatoEnDatosEvaluacion(".$iddelegacion.",".$idprograma.",".$folio.", this.id,\"".$nitavu."\",this.value)'  name='IdTipoMoneda' >";
                                $sql2="select * from tipomoneda"; 
                                $r2 = $Vivienda -> query($sql2); 
                                while($valor = $r2 -> fetch_array())
                                {
                                    if (TipoMonedaDatosEvaluacion($iddelegacion,$idprograma,$folio)==$valor['IdTipoMoneda'])
                                    {
                                    echo "<option value='".$valor['IdTipoMoneda']."' selected>".$valor['TipoMoneda']."</option>";
                                    }
                                    else
                                    {
                                        echo "<option value='".$valor['IdTipoMoneda']."'>".$valor['TipoMoneda']."</option>";
                                    }
                                }                           
                            echo "</select></td><td width=13px><div style='display:none;' id='LoaderIdTipoMoneda'><img src='img/loader_bar.gif' style='width:13px;'></div>
                            <div style='display:none;' id='LoaderOKIdTipoMoneda'> <img src='icon/ok.png' style='width:13px;'></div></td></tr></table>";	
                            echo "</div>";
                        echo "</td>";
                    echo "</tr>";

                    echo "<tr>";
                        echo "<td><span class='normal'>Monto Del Credito</span></td>";                           
                        echo" <td colspan='3'>";                           
                            echo "<div><table width=100% class='menu_font_n10'><tr><td >";
                            echo "<tr><td><input  type='text' onkeyup='GuardarDatoEnLotes(".$iddelegacion.",".$idprograma.",".$folio.",".$f['idLote'].", this.id,\"".$nitavu."\",this.value)'   mayus(this);'  name='precio' id='precio' value='".trim($f['precio'])."'>
                                
                            </td>";
                            echo "<td width=13px><div style='display:none;' id='Loaderprecio'><img src='img/loader_bar.gif' style='width:13px;'></div>";
                            echo "<div style='display:none;' id='Rprecio'><img src='icon/ok.png' style='width:13px;'></div></td></tr></table></div>"; 
                        echo "</td>";
                    echo "</tr>";

                    echo "<tr>";
                        echo"<td><span class='normal'>Tipo de Pago Inicial</span></td>";
                        echo "<td colspan='3'>";                          
                            echo "<div'><table width=100% class='menu_font_n10'><tr><td>";
                            echo "<select  id='IdPagoInicial' onchange='GuardarDatoEnDatosEvaluacion(".$iddelegacion.",".$idprograma.",".$folio.", this.id,\"".$nitavu."\",this.value)'  name='IdPagoInicial' >";
                            $sql2="select * from tipopagoinicial";
                                $r2 = $Vivienda -> query($sql2); 
                                while($valor = $r2 -> fetch_array())
                                {
                                    if (TipoPagoInicialDatosEvaluacion($iddelegacion,$idprograma,$folio)==$valor['IdPagoInicial'])
                                    {
                                    echo "<option value='".$valor['IdPagoInicial']."' selected>".$valor['PagoInicial']."</option>";
                                    }
                                    else
                                    {
                                        echo "<option value='".$valor['IdPagoInicial']."'>".$valor['PagoInicial']."</option>";
                                    }
                                }                           
                            echo "</select></td><td width=13px><div style='display:none;' id='LoaderIdPagoIncial'><img src='img/loader_bar.gif' style='width:13px;'></div>
                            <div style='display:none;' id='LoaderOKIdPagoIncial'> <img src='icon/ok.png' style='width:13px;'></div></td></tr></table>";	
                            echo "</div>";
                        echo " </td>";
                    echo "</tr>";

                    echo "<tr>";
                        echo "<td><span class='normal'>Monto Pago Inicial</span></td>";                                                                              
                        echo" <td colspan='3'>";                                                 
                        if(TipoPagoInicialDatosEvaluacion($iddelegacion,$idprograma,$folio)==1 
                        or TipoPagoInicialDatosEvaluacion($iddelegacion,$idprograma,$folio)==3
                        or TipoPagoInicialDatosEvaluacion($iddelegacion,$idprograma,$folio)==10)
                        {
                            echo "<div><table width=100% class='menu_font_n10'><tr><td >";
                            echo "<tr><td><input  type='text' onkeyup='GuardarDatoEnLotes(".$iddelegacion.",".$idprograma.",".$folio.",".$f['idLote'].", this.id,\"".$nitavu."\",this.value)'   mayus(this);'  name='MontoPagoInicial' id='MontoPagoInicial' value='".trim($f['MontoPagoInicial'])."'></td>";
                            echo "<td width=13px><div style='display:none;' id='LoaderMontoPagoInicial'><img src='img/loader_bar.gif' style='width:13px;'></div>";
                            echo "<div style='display:none;' id='RMontoPagoInicial'><img src='icon/ok.png' style='width:13px;'></div></td></tr></table></div>";
                        }
                        else
                        {
                            echo "<div><table width=100% class='menu_font_n10'><tr><td >";
                            echo "<tr><td><input disaled type='text' onkeyup='GuardarDatoEnLotes(".$iddelegacion.",".$idprograma.",".$folio.",".$f['idLote'].", this.id,\"".$nitavu."\",this.value)'   mayus(this);'  name='MontoPagoInicial' id='MontoPagoInicial' value='0'></td>";
                            echo "<td width=13px><div style='display:none;' id='LoaderMontoPagoInicial'><img src='img/loader_bar.gif' style='width:13px;'></div>";
                            echo "<div style='display:none;' id='RMontoPagoInicial'><img src='icon/ok.png' style='width:13px;'></div></td></tr></table></div>";
                        }  
                        echo "</td>";
                    echo "</tr>";
                    /*
                    echo"<tr>";
                        echo "<td><span class='normal'>Aplica Gastos de Admon</span></td>";
                        echo "<td colspan='3'>";                           
                        echo "<div'><table width=100% class='menu_font_n10'><tr><td>";
                        echo "<select  id='AplicaGtsAdmon' name='AplicaGtsAdmon' onchange='GuardarDatoEnDatosEvaluacion(".$iddelegacion.",".$idprograma.",".$folio.", this.id,\"".$nitavu."\",this.value)'   >";
                        $sql2="select * from tipoaplicagtsadmon";
                            $r2 = $Vivienda -> query($sql2); 
                            while($valor = $r2 -> fetch_array())
                            {
                                if (AplicaGastosAdmonDatosEvaluacion($iddelegacion,$idprograma,$folio)==$valor['IdTipoAplicaGtsAdmon'])
                                    {
                                       echo "<option value='".$valor['IdTipoAplicaGtsAdmon']."' selected>".$valor['TipoAplicaGtsAdmon']."</option>";
                                    }
                                    else
                                    {
                                            echo "<option value='".$valor['IdTipoAplicaGtsAdmon']."'>".$valor['TipoAplicaGtsAdmon']."</option>";
                                    }
                            }                           
                        echo "</select></td><td width=13px><div style='display:none;' id='LoaderAplicaGtsAdmon'><img src='img/loader_bar.gif' style='width:13px;'></div>
                        <div style='display:none;' id='LoaderOKAplicaGtsAdmon'> <img src='icon/ok.png' style='width:13px;'></div></td></tr></table>";	
                        echo "</div>";
                    echo " </td>";
                    echo "</tr>";
                    
                    echo "<tr>";
                        echo "<td><span class='normal'>Gastos de Admon</span></td>";                                                                              
                        echo" <td>";                           
                        echo "<div><table width=100% class='menu_font_n10'><tr><td >";
                        echo "<tr><td><input name='GtsAdmon' id='GtsAdmon' type='text' onkeyup='GuardarDatoEnLotes(".$iddelegacion.",".$idprograma.",".$folio.",".$f['idLote'].", this.id,\"".$nitavu."\",this.value)'   mayus(this);'  value='".GastosAdmonDatosEvaluacion($iddelegacion,$idprograma,$folio)."'></td>";
                        echo "<td width=13px><div style='display:none;' id='LoaderGtsAdmon'><img src='img/loader_bar.gif' style='width:13px;'></div>";
                        echo "<div style='display:none;' id='RGtsAdmon'><img src='icon/ok.png' style='width:13px;'></div></td></tr></table></div>"; 
                        echo "</td>";

                        echo "<td align='center'><span class='normal'>%</span></td>"; 
                        echo" <td>"; 
                        echo tipoPrograma($idprograma);
                        switch (AplicaGastosAdmonDatosEvaluacion($iddelegacion,$idprograma,$folio)) {
                            case 0:
                                echo" <td>";                           
                                echo "<div><table width=100% class='menu_font_n10'><tr><td >";
                                echo "<tr><td><input disabled name='GtsAdmon' id='GtsAdmon' type='text' onkeyup='GuardarDatoEnLotes(".$iddelegacion.",".$idprograma.",".$folio.",".$f['idLote'].", this.id,\"".$nitavu."\",this.value)'   mayus(this);'  value='0'></td>";
                                echo "<td width=13px><div style='display:none;' id='LoaderGtsAdmon'><img src='img/loader_bar.gif' style='width:13px;'></div>";
                                echo "<div style='display:none;' id='RGtsAdmon'><img src='icon/ok.png' style='width:13px;'></div></td></tr></table></div>"; 
                                echo "</td>";
                                break;
                            case 1:
                                 $gtsAdmon= $f['precio'] * (GastosAdmonDatosEvaluacion($iddelegacion,$idprograma,$folio)/ 100);
                                echo" <td>";                           
                                echo "<div><table width=100% class='menu_font_n10'><tr><td >";
                                echo "<tr><td><input name='GtsAdmon' id='GtsAdmon' type='text' onkeyup='GuardarDatoEnLotes(".$iddelegacion.",".$idprograma.",".$folio.",".$f['idLote'].", this.id,\"".$nitavu."\",this.value)'   mayus(this);'  value='".$gtsAdmon."'></td>";
                                echo "<td width=13px><div style='display:none;' id='LoaderGtsAdmon'><img src='img/loader_bar.gif' style='width:13px;'></div>";
                                echo "<div style='display:none;' id='RGtsAdmon'><img src='icon/ok.png' style='width:13px;'></div></td></tr></table></div>"; 
                                echo "</td>";
                                break;
                            case 2:
                                 $gtsAdmon= $f['precio'] * (GastosAdmonDatosEvaluacion($iddelegacion,$idprograma,$folio)/ 100);
                                // (Val(DCboMontoCredito.text) - (pagoinicial)) *  (GastosAdmonDatosEvaluacion($iddelegacion,$idprograma,$folio)/ 100)
                                echo" <td>";                           
                                echo "<div><table width=100% class='menu_font_n10'><tr><td >";
                                echo "<tr><td><input name='GtsAdmon' id='GtsAdmon' type='text' onkeyup='GuardarDatoEnLotes(".$iddelegacion.",".$idprograma.",".$folio.",".$f['idLote'].", this.id,\"".$nitavu."\",this.value)'   mayus(this);'  value='".$gtsAdmon."'></td>";
                                echo "<td width=13px><div style='display:none;' id='LoaderGtsAdmon'><img src='img/loader_bar.gif' style='width:13px;'></div>";
                                echo "<div style='display:none;' id='RGtsAdmon'><img src='icon/ok.png' style='width:13px;'></div></td></tr></table></div>"; 
                                echo "</td>";
                                break;
                            case 3:
                                 $gtsAdmon= $f['precio'] * (GastosAdmonDatosEvaluacion($iddelegacion,$idprograma,$folio)/ 100);
                                echo" <td>";                           
                                echo "<div><table width=100% class='menu_font_n10'><tr><td >";
                                echo "<tr><td><input name='GtsAdmon' id='GtsAdmon' type='text' onkeyup='GuardarDatoEnLotes(".$iddelegacion.",".$idprograma.",".$folio.",".$f['idLote'].", this.id,\"".$nitavu."\",this.value)'   mayus(this);'  value='".$gtsAdmon."'></td>";
                                echo "<td width=13px><div style='display:none;' id='LoaderGtsAdmon'><img src='img/loader_bar.gif' style='width:13px;'></div>";
                                echo "<div style='display:none;' id='RGtsAdmon'><img src='icon/ok.png' style='width:13px;'></div></td></tr></table></div>"; 
                                echo "</td>";
                                break;
                            case 4:
                                 $gtsAdmon= $f['precio'] * (GastosAdmonDatosEvaluacion($iddelegacion,$idprograma,$folio)/ 100);
                                echo" <td>";                           
                                echo "<div><table width=100% class='menu_font_n10'><tr><td >";
                                echo "<tr><td><input name='GtsAdmon' id='GtsAdmon' type='text' onkeyup='GuardarDatoEnLotes(".$iddelegacion.",".$idprograma.",".$folio.",".$f['idLote'].", this.id,\"".$nitavu."\",this.value)'   mayus(this);'  value='".$gtsAdmon."'></td>";
                                echo "<td width=13px><div style='display:none;' id='LoaderGtsAdmon'><img src='img/loader_bar.gif' style='width:13px;'></div>";
                                echo "<div style='display:none;' id='RGtsAdmon'><img src='icon/ok.png' style='width:13px;'></div></td></tr></table></div>"; 
                                echo "</td>";
                                break;
                            }
                        echo "</td>";
                    echo "</tr>";

                    echo "<tr>";
                        echo "<td><span class='normal'>Gastos de Escrituracion</span></td>";                           
                        echo" <td colspan='3'>";                           
                            echo "<div><table width=100% class='menu_font_n10'><tr><td >";
                            echo "<tr><td><input  type='text' onkeyup='GuardarDatoEnLotes(".$iddelegacion.",".$idprograma.",".$folio.",".$f['idLote'].", this.id,\"".$nitavu."\",this.value)' mayus(this);'  name='gastosEscritura' id='gastosEscritura' ></td>";
                            echo "<td width=13px><div style='display:none;' id='Loaderprecio'><img src='img/loader_bar.gif' style='width:13px;'></div>";
                            echo "<div style='display:none;' id='Rprecio'><img src='icon/ok.png' style='width:13px;'></div></td></tr></table></div>"; 
                        echo "</td>";
                    echo "</tr>";
                    */
                    echo "<tr  style='height: 40px;'>";
                        $subsidio= SubsidioFederalLotes($f['idLote']) + SubsidioEstatalLotes($f['idLote']) ;
                        echo "<td><span class='normal'>Subsidio</span></td>";                           
                        echo" <td colspan='3'>";
                        echo "<span>$ ".$subsidio."</span>";                     
                        echo "</td>";
                    echo "</tr>";

                    echo "<tr  style='height: 40px;'>";
                                         
                        echo "<td><span class='normal'>Total a Financiar</span></td>";                           
                        echo" <td colspan='3'>";  
                        $totalafinaciar=$f['MontoCredito']-$f['MontoPagoInicial']-$subsidio; 
                        $totalafinaciar= number_format((float)$totalafinaciar, 2, '.', '');
                        echo "<span id='TotalAFinanciar' name='TotalAFinanciar'>".$totalafinaciar."</span><input type='hidden' value='".$totalafinaciar."' name='totalafinanciar' id='totalafinanciar'>";
                    echo "</tr>";  

                    echo "</table>";
                 echo '</div>';

               

                            //************** FORMA DE PAGO *********************/
                    echo ' <div class="col-xs-6 col-md-4" style="text-align: justify; margin: 0px;">'; 
                    echo '<br>';     
                        echo '<h6 class="card-title">Forma de Pago</h6>';   
                        echo "<table style='width:90%; margin-left: 20px; font-size: 10pt;'>";
                            
                        echo "<tr>";
                                echo "<td><span class='normal'>Tipo de Pago</span></td>
                                <td colspan='3'>"; 
                                echo "<div'><table width=100% class='menu_font_n10'><tr><td>";
                                echo "<select  id='TipoPago' name='TipoPago' onchange='GuardarDatoEnLotes(".$iddelegacion.",".$idprograma.",".$folio.",".$f['idLote'].", this.id,\"".$nitavu."\",this.value)'     >";
                                $sql2="select * from tipopago";
                                    $r2 = $Vivienda -> query($sql2); 
                                    while($valor = $r2 -> fetch_array())
                                    {
                                        if ($f['TipoPago']==$valor['IdTipoPago'])
                                            {
                                                echo "<option value='".$valor['IdTipoPago']."' selected>".$valor['TipoPago']."</option>";
                                            }
                                            else
                                            {
                                                echo "<option value='".$valor['IdTipoPago']."'>".$valor['TipoPago']."</option>";
                                            }
                                    }                           
                                echo "</select></td><td width=13px><div style='display:none;' id='LoaderTipoPago'><img src='img/loader_bar.gif' style='width:13px;'></div>
                                <div style='display:none;' id='LoaderOKTipoPago'> <img src='icon/ok.png' style='width:13px;'></div></td></tr></table>";	
                                echo "</div>";                          
                                echo " </td>";
                        echo "</tr>";

                        echo "<tr>";
                        echo "<td><span class='normal'>N° de Mensualidades</span></td>";                           
                        echo" <td colspan='3'>";                           
                            echo "<div><table width=100% class='menu_font_n10'><tr><td >";
                            echo "<tr><td><input  type='text' onkeyup='GuardarDatoEnLotes(".$iddelegacion.",".$idprograma.",".$folio.",".$f['idLote'].", this.id,\"".$nitavu."\",this.value)' mayus(this);'  name='TotalPagos' id='TotalPagos' value='".$f['TotalPagos']."'></td>";
                            echo "<td width=13px><div style='display:none;' id='LoaderTotalPagos'><img src='img/loader_bar.gif' style='width:13px;'></div>";
                            echo "<div style='display:none;' id='RTotalPagos'><img src='icon/ok.png' style='width:13px;'></div></td></tr></table></div>"; 
                        echo "</td>";
                     echo "</tr>";

                        echo "<tr>";
                            echo "<td><span class='normal'>Monto de Menusalidad</span></td>";                           
                            echo" <td colspan='3'>";                           
                                echo "<div><table width=100% class='menu_font_n10'><tr><td >";
                                echo "<tr><td><input  type='text' onkeyup='GuardarDatoEnLotes(".$iddelegacion.",".$idprograma.",".$folio.",".$f['idLote'].", this.id,\"".$nitavu."\",this.value)' mayus(this);'  name='MontoPago' id='MontoPago' value='".$f['MontoPago']."'></td>";
                                echo "<td width=13px><div style='display:none;' id='LoaderMontoPago'><img src='img/loader_bar.gif' style='width:13px;'></div>";
                                echo "<div style='display:none;' id='RMontoPago'><img src='icon/ok.png' style='width:13px;'></div></td></tr></table></div>"; 
                            echo "</td>";
                        echo "</tr>";

                         
                        echo "<tr>";
                            echo "<td><span class='normal'>Monto Ultimo Pago</span></td>";                           
                            echo" <td colspan='3'>";                           
                                echo "<div><table width=100% class='menu_font_n10'><tr><td >";
                                echo "<tr><td><input  type='text' onkeyup='GuardarDatoEnLotes(".$iddelegacion.",".$idprograma.",".$folio.",".$f['idLote'].", this.id,\"".$nitavu."\",this.value)' mayus(this);'  name='MontoUltimoPago' id='MontoUltimoPago' value='".$f['MontoUltimoPago']."'></td>";
                                echo "<td width=13px><div style='display:none;' id='LoaderMontoUltimoPago'><img src='img/loader_bar.gif' style='width:13px;'></div>";
                                echo "<div style='display:none;' id='RMontoUltimoPago'><img src='icon/ok.png' style='width:13px;'></div></td></tr></table></div>"; 
                            echo "</td>";
                        echo "</tr>";
                        /*                
                        echo" <tr>
                                <td><span class='normal'>Gastos Admon</span></td>
                                <td><input  type='text'  name='tipoMoneda' id='tipoMoneda' > </td>
                            </tr>
                            <tr>
                                <td><span class='normal '>Segurdo de Vida</span></td>
                                <td><input  type='text'  name='tipoMoneda' id='tipoMoneda' > </td>
                            </tr>
                            <tr>
                                <td><span class='normal'>Otros Cargos</span></td>
                                <td><input  type='text'  name='tipoMoneda' id='tipoMoneda' > </td>
                            </tr> ";                   
                        */                                            
                        echo "</table>";

                        echo '<br>';  
                        echo '<h6 class="card-title">Beneficiario</h6>';                               
                        echo "<table style='width:90%; margin-left: 20px; font-size: 10pt;' >";
                        
                        echo "<tr>";
                            echo "<td><span class='normal'>Aportación</span></td>";                           
                            echo "<td><span>$ ".ObtenerTotalAbonadoPorSolicitud($iddelegacion,$idprograma,$folio)."</span></td>";
                        echo "</tr>";                   
                            
                        echo "</table>"; 
                    echo '</div>';

                    //*** INTERES MORATORIO */     
                    echo ' <div class="col-xs-6 col-md-4" style="text-align: justify; margin: 0px;">'; 
                    echo '<br>';                         
                        echo '<h6 class="card-title">Tasa de Financiamiento</h6>';                               
                        echo "<table style='width:90%; margin-left: 20px; font-size: 10pt;' >";
                        
                        echo "<tr>";
                            echo "<td><span class='normal'>Tasa Anual</span></td>";                           
                            echo" <td colspan='3'>";                           
                                echo "<div><table width=100% class='menu_font_n10'><tr><td >";
                                echo "<tr><td><input  type='text' onkeyup='GuardarDatoEnLotes(".$iddelegacion.",".$idprograma.",".$folio.",".$f['idLote'].", this.id,\"".$nitavu."\",this.value)' mayus(this);'  name='TasaAnualFin' id='TasaAnualFin' value='".$f['TasaAnualFin']."'></td>";
                                echo "<td width=13px><div style='display:none;' id='LoaderTasaAnualFin'><img src='img/loader_bar.gif' style='width:13px;'></div>";
                                echo "<div style='display:none;' id='RTasaAnualFin'><img src='icon/ok.png' style='width:13px;'></div></td></tr></table></div>"; 
                            echo "</td>";
                        echo "</tr>";                   
                            
                        echo "</table>";
                        echo "<br>";
                        echo '<h6 class="card-title">Interes Moratorio</h6>';                               
                        echo "<table style='width:90%; margin-left: 20px; font-size: 10pt;' >";                    
                        
                               echo "<td><span class='normal'>Tipo de Interes</span></td>";
                            echo "<td colspan='3'>"; 
                                echo "<div'><table width=100% class='menu_font_n10'><tr><td>";
                                echo "<select  id='TipoIntMoratorio' name='TipoIntMoratorio' onchange='GuardarDatoEnDatosEvaluacion(".$iddelegacion.",".$idprograma.",".$folio.", this.id,\"".$nitavu."\",this.value)'     >";
                                $sql2="select * from cattipointeres";
                                        $r2 = $Vivienda -> query($sql2); 
                                        while($valor = $r2 -> fetch_array())
                                        {
                                            if (TipoIntMoratorioDatosEvaluacion($iddelegacion,$idprograma,$folio)==$valor['IdTipoInteres'])
                                                {
                                                    echo "<option value='".$valor['IdTipoInteres']."' selected>".$valor['TipoInteres']."</option>";
                                                }
                                                else
                                                {
                                                    echo "<option value='".$valor['IdTipoInteres']."'>".$valor['TipoInteres']."</option>";
                                                }
                                        }                           
                                echo "</select></td><td width=13px><div style='display:none;' id='LoaderTipoIntMoratorio'><img src='img/loader_bar.gif' style='width:13px;'></div>
                                <div style='display:none;' id='LoaderOKTipoIntMoratorio'> <img src='icon/ok.png' style='width:13px;'></div></td></tr></table>";	
                                echo "</div>";                          
                            echo " </td>";
                        echo "</tr>";

                        echo "<tr>";
                            echo "<td><span class='normal'>Tasa de Interes Moratorio</span></td>";                           
                            echo" <td colspan='3'>";                           
                                echo "<div><table width=100% class='menu_font_n10'><tr><td >";
                                echo "<tr><td><input  type='text' onkeyup='GuardarDatoEnLotes(".$iddelegacion.",".$idprograma.",".$folio.",".$f['idLote'].", this.id,\"".$nitavu."\",this.value)' mayus(this);'  name='TasaIntMora' id='TasaIntMora' value='".$f['TasaIntMora']."'></td>";
                                echo "<td width=13px><div style='display:none;' id='LoaderTasaIntMora'><img src='img/loader_bar.gif' style='width:13px;'></div>";
                                echo "<div style='display:none;' id='RTasaIntMora'><img src='icon/ok.png' style='width:13px;'></div></td></tr></table></div>"; 
                            echo "</td>";
                        echo "</tr>";  
                            /*
                            echo "<tr>
                                <td><span class='normal'>Monto de Interes Moratorio</span></td>
                                <td><input  type='text'  name='tipoMoneda' id='tipoMoneda' > </td>
                            </tr>
                            <tr>
                                <td><span class='normal'>Dias de Gracia</span></td>
                                <td><input  type='text'  name='tipoMoneda' id='tipoMoneda' > </td>
                            </tr>";
                            */
                        echo "<tr>";
                            echo "<td><span class='normal'>Periodo de Moratorio</span></td>";                           
                            echo" <td colspan='3'>";                           
                                echo "<div><table width=100% class='menu_font_n10'><tr><td >";
                                echo "<tr><td><input  type='text' onkeyup='GuardarDatoEnDatosEvaluacion(".$iddelegacion.",".$idprograma.",".$folio.", this.id,\"".$nitavu."\",this.value)' mayus(this);'  name='PeriodoMora' id='PeriodoMora' value='".PeriodoMoraDatosEvaluacion($iddelegacion,$idprograma,$folio)."'></td>";
                                echo "<td width=13px><div style='display:none;' id='LoaderPeriodoMora'><img src='img/loader_bar.gif' style='width:13px;'></div>";
                                echo "<div style='display:none;' id='RPeriodoMora'><img src='icon/ok.png' style='width:13px;'></div></td></tr></table></div>"; 
                            echo "</td>";
                        echo "</tr>";                                               
                                                                    
                        echo "</table>";
                    echo '</div>';                  
                 echo '</div>';
            echo '</center>'; 
    echo '</div>';
               
            }
            echo "<br>"; 
          /*  $tipoPrograma = tipoPrograma($idprograma);
            $required = '';
            if($tipoPrograma == 5){
                $required = 'required';
            }*/

            //VALIDACIOON LOTE
         /*   $requiredLote='';
            if($idLote > 0){
                $requiredLote = 'required';
            }*/

            echo '<div class="card " style="text-align: justify; width: 100%;">';
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
                 WHERE (((catdelmun.IDDELEGACION)=".$iddelegacion.")) OR (((catdelmun.IDDELEGACION)=0) 
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
            echo '</div>';
            
            

            //*********************** DIV OTROS DATOS **************************************
           // $NumContrato = buscarSiYaTieneContrato($iddelegacion, $idprograma, $folio); 
            $NumContrato = buscarSiYaTieneContratoActivoOno($iddelegacion, $idprograma, $folio);        
            if($NumContrato =='' and LibreParaAsignacion($idLote) == 0){
               //echo "<form action='generarContrato.php?delegacion=".$iddelegacion."&programa=".$idprograma."&folio=".$folio." method='POST'>";
                echo "<div style='width:100%' id=divDatos>";
                    echo '<div class="card" style="text-align: justify; width:100%;">
                            <h1 class="card-header h5" style="text-transform: uppercase;font-size: 10pt;" >Datos</h1>';
                            echo '<div class="card-body" style="width:100%;">'; 
                             
                                    echo "<label>Oficio de autorización</label>";
                                    echo "<input id='oficioAutorizacion' name='oficioAutorizacion' required>";
                                    $idarchivo=1;
                                    echo InputSubirArchivo('Oficio de Autorización', $iddelegacion, $idprograma, $folio,$idarchivo,$id_aplicacion);
                                    echo "<table style='width:100%;'><tr><td style='text-align: center; width:65%;'>";
                                    echo "<label>En caso de fallecimiento del titular. El titular será</label>";
                                    echo "<input id='fallecimiento' name='fallecimiento' required>";
                                    echo "</td><td style='text-align: center; width:35%;'>";
                                    echo "<label>Parentesco (Conyuge, Hijo, Hija, etc)</label>";
                                    echo "<input id='parentesco' name='parentesco' required>";
                                    echo "</td></tr>";
                                    echo "</table>";          
                            echo '</div>';
                    echo '</div>';
                echo '</div>';  

               
                echo "<br>";
                //onclick='generarcontrato();'
                //onclick ='getPlantillaContrato(3);'
                echo "<button type='submit' class='btn btn-info'  title='Generar Contrato'> <center>
                <table><tr><td valign='middle' align='center'>
                <img src='icon/page.png'> 
                </td>
                <td valign='middle' align='center' style='color:white;' >
                Generar Contrato
                </td></tr></table>  </center> 
                </button>"; 
               
                echo "</center>";
            }else{
                echo "<div style='width:100%' id=divDatos>";
                    echo '<div class="card" style="text-align: justify; width:100%;">
                            <h1 class="card-header h5" style="text-transform: uppercase;font-size: 10pt;" >Datos</h1>';
                            echo '<div class="card-body" style="width:100%;">'; 
                             
                                    echo "<label>Oficio de autorización</label><br>";
                                    echo "<input id='oficioAutorizacion' name='oficioAutorizacion' value='".oficiodeAutorizacionContrato($NumContrato)."' readonly style='width:95%;'>";
                                    $idarchivo=1; 
                                    $identificador=obtenerNumArchivoVigente($iddelegacion, $idprograma, $folio,$idarchivo);
                                   
                                    if($identificador!='')
                                    {
                                        echo "<a name='".$identificador."' id='".$identificador."' style='display:inline-block;'  href='md_descargar.php?nombre=DocumentosFiles/".$identificador.".pdf' target='_self'  onclick =''  title='Haga click aqui para descargar'><img src='icon/pdf.png' style='width:36px;'></a>";
                                    }else
                                    {
                                        echo "<a name='".$identificador."' id='".$identificador."' style='display:none;'  href='md_descargar.php?nombre=DocumentosFiles/".$identificador.".pdf' target='_self'  onclick =''  title='Haga click aqui para descargar'><img src='icon/pdf.png' style='width:36px;'></a>";
                                    }
                                    
                                    echo "<table style='width:100%;'>
                                    <tr><td style='text-align: center; width:50%;'>";
                                    echo "<label>En caso de fallecimiento del titular. El titular será</label>";
                                    echo "<input id='fallecimiento' name='fallecimiento' value='".sucesorporFallecimientoContrato($NumContrato)."' readonly >";
                                    echo "</td><td style='text-align: center; width:35%;'>";
                                    echo "<label>Parentesco (Conyuge, Hijo, Hija, etc)</label>";
                                    echo "<input id='parentesco' name='parentesco' value='".sucesorParentescoContrato($NumContrato)."' readonly >";
                                    echo "</td></tr>";
                                    echo "</table>";          
                            echo '</div>';
                    echo '</div>';
                echo '</div>';  
            }
            if($NumContrato !='')
            {
                echo "<script> $('#EtiquetaContratado').css({'display':'none'});
                  $('#formdatos').css({'display':'block'});
                  console.log('entro2');</script>";
            }           
        
            echo "</form>";
        }
    }else{
        echo "No existe un lote con esos datos.";

    }
    
    


       

}else{
    echo 'ERROR: al recibir la información, favor de intentarlo de nuevo.';
}

    ?>
<script>
 // ******************************************************************** */


function GuardarDatoEnDatosEvaluacion(iddel,idprograma,folio, campo, nitavu,valor){            
   $("#Loader" + campo ).show();
    $.ajax({
    url: "credito_db.php",
    type: "post",        
    data: {IdDelegacion:iddel, IdPrograma:idprograma, Folio:folio, Campo:campo, Valor:valor, NitavuMod:nitavu,IdLote:''},
    success: function(data){     
         console.log(data);                         
        $("#" + campo).html(data+"\n");  
          if(data.includes('FALSE')==true)                            
            {             
               $("#" + campo).css("border-color", "red");              
              // $("#msgdatosrequeridos").css({'display':'inline-block'});  
            }
            else
            { 
               $("#" + campo).css("border-color", "#CCCCCC");
               /*$("#msgdatosrequeridos").css({'display':'none'});*/
            }
        // console.log("Guardando " + IdRequisito + "_" + IdCategoria + ":" + data);
        $("#Loader" + campo).hide();  
    }
    });

}


//******************************************************************** */
function GuardarDatoEnLotes(iddel,idprograma,folio,idlote, campo, nitavu,valor){    
     

   $("#Loader" + campo ).show();
    $.ajax({
    url: "credito_db.php",
    type: "post",        
    data: {IdDelegacion:iddel, IdPrograma:idprograma, Folio:folio, Campo:campo, Valor:valor, NitavuMod:nitavu, IdLote:idlote},
    success: function(data){     
         console.log(data);                         
        $("#" + campo).html(data+"\n");  
          if(data.includes('FALSE')==true)                            
            {             
               $("#" + campo).css("border-color", "red");              
              // $("#msgdatosrequeridos").css({'display':'inline-block'});  
            }
            else
            { 
               $("#" + campo).css("border-color", "#CCCCCC");
                if( (campo=="MontoPagoInicial"|| campo=="MontoCredito" || campo=="precio" )) {  
                    calcularFinanciamiento();
                } 
            }
        // console.log("Guardando " + IdRequisito + "_" + IdCategoria + ":" + data);
        $("#Loader" + campo).hide();  
    }
    });

}

function calcularFinanciamiento()
{   
    console.log("entro");
  var precio=document.getElementById("precio").value;  
  var enganche=document.getElementById("MontoPagoInicial").value; 
  var Subsidio=<?php echo $subsidio; ?>;
  var monto=precio-enganche-Subsidio; 
  
  monto=Number.parseFloat(monto).toFixed(2);
  $('#TotalAFinanciar').html(monto+"\n");
 
}

/*function getPlantillaContrato(IdPlantilla){        
    alert('entro');
    $("#AquiVaMiPlantilla").html("<br><br><br>Cargando <img src='img/loader_bar.gif'>")
    var lote = document.getElementById('lote').value;
    var manzana = document.getElementById('manzana').value;
    var nomcolonia = document.getElementById('nomcolonia').value;
    var superficie = document.getElementById('superficie').value;
    var colindancia1 = document.getElementById('colindancia1').value;
    var colindancia2 = document.getElementById('colindancia2').value;
    var colindancia3 = document.getElementById('colindancia3').value;
    var colindancia4 = document.getElementById('colindancia4').value;
    var beneficiario = document.getElementById('beneficiario').value;
    $.ajax({
        url: "carga_contrato.php",
        type: "post",   
        data: {IdPlantilla: IdPlantilla, lote: lote, manzana:manzana, nomcolonia: nomcolonia, superficie:superficie, colindancia1:colindancia1, colindancia2: colindancia2, colindancia3: colindancia3, colindancia4: colindancia4, beneficiario: beneficiario},
        success: function(data){            
            $('#AquiVaMiPlantilla').html(data);
            // $("#preloader").hide();   
      }
   });
   
}*/


</script>                    
 