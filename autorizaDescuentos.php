<?php
    include ("lib/body_head.php");
    // include ("lib/body_menu.php");
    //No tiene menu vertical
?>

<?php
$id_aplicacion ="ap115"; $nivel = aplicacion_nivel($id_aplicacion, $nitavu);
$nivel =aplicacion_nivel($id_aplicacion, $nitavu);

if (sanpedro($id_aplicacion, $nitavu)==TRUE){
    echo "<div id='AppDetalle'>".app_detalle($id_aplicacion, $nitavu)."</div>";        
    xd_update($id_aplicacion,$nitavu); historia($nitavu, $id_aplicacion." | Entro a Autorizar Descuentos");

    if(midelegacionconid($nitavu)== 'OFICINAS CENTRALES'){
        $IdDelg  = '00';
    }else{
        $IdDelg  = midelegacionconid($nitavu);
    }
    if(RevisaCampaña() <> 'FALSE'){
        $campaña = RevisaCampaña();
        $justificacion ='';
        $justificacion =  RevisaCampañaDescripcion()."-".RevisaCampañaOficioDeAutorizacion();
        //echo $justificacion .'JUSTIFI';
        //variables
        $HastaDescEscritura=0;
        $PorPagarEsc=0;
        $TieneEscritura='false';
        $SaldoCapita=0;
        //BARRA DE BUSQUEDA
        echo "<div style='
        background-color:#e6e3e1; width: 100%; padding-top: 50px; padding-bottom: 13px; margin-top: 30px;'>
        <form action='autorizaDescuentos.php' method='GET'><table width=100%><tr><td width=90%>";
        echo "<input style=' height: 65px; border-radius: 5px; font-size: 18pt; font-family: Light; margin-left: 12px; padding: 10px; margin-right: 20px;
        'type='text' name='search' id='search' placeholder='Ingrese número de contrato' id='txtBeneficiario'>";
        echo "</td><td>
        <button type='submit' class='Mbtn btn-Success' id='indicaciones2' style='font-size: 8pt; width: 100%; height: 60px; margin-top: 0px;' onclick='v001.php'>    <img src='icon/buscar2.png' style='width:40px;'>
        </button></td></tr></table></form>
        </div>"; 

        if(isset($_GET['search'])){
            $Search = $_GET['search'];
            // echo "Search = ".$Search." y nitavu = ".$nitavu;
            $sql="select * from busqueda_vivienda_solicitudes  
            WHERE NumContrato = '".$Search."'";

            // $sql = "select * from busqueda_vivienda_solicitudes limit 10";
            //echo $sql;
            $r= $Vivienda -> query($sql);
            $r_count = $r -> num_rows;
            if($r_count>0){
                while($f = $r -> fetch_array()) {

                    $IdDelegacion = $f['IdDelegacion'];
                    $IdPrograma = $f['IdPrograma'];
                    $OriginData = $f['OriginData'];
                    $NumContrato = $f['NumContrato'];
                    $Folio = $f['Folio'];
                    echo "<center>";

                    echo '<div    class="row" style="width:100%; ">';
                    echo "<br>";               
                        echo '<div    style="width:90%;height:100%;">'; 
                        datosBeneficiarioenFormatoCorto($IdPrograma, $IdDelegacion, $Folio, $NumContrato);                  
                        echo '</div>';
    
                        echo '<div style="width:10%; height:auto;">';  
                        echo "<a id='NuevoLote' href='v002_init.php?numcontrato=".$NumContrato."&origindata=".$IdDelegacion."&ContratoConsultar=Consultar' class='btn btn-primary' title='Estado de cuenta'> 
                            <table  width='100%'><tr><td valign='middle' align='center'>
                           </td> 
                            <td valign='middle' align='center' style='color:white;' class='pc'>Estado de Cuenta</td></tr></table> </a>";
                        echo '</div>';              
                    echo '</div>';    

                    //EMPEZAMOS A RECIBIR VARIABLES PARA GUARDAR EL DESCUENTO 
                    if(isset($_POST['btnGuardar'])){

                        //variables que se reciben si es por escritura
                        if(isset($_POST['descuentoEscritura'])){
                            $descuento = $_POST['descuentoEscritura'];
                            $montoADescontar = $_POST['MontoADescontarEsc'];
                            //mov 126 por que es descuento de escritura del catalolgo descripcion movimiento
                            $tipoDescuento = 126;
                        }

                        //variables que se reciben si es por edscuento moratorios
                        if(isset($_POST['CantidadAbonar'])){
                            $minimoAAbonar = $_POST['CantidadAbonar'];
                            $montoDescuento = $_POST['MontoDescuento'];
                            //mov 125 por que es descuento de escritura del catalolgo descripcion movimiento
                            $tipoDescuento = 125;
                        }
                        
                        
                        $jusificacion = $_POST['justificacion'];
                        $BIdMandante = $_POST['bidmandante'];
                        $capital = $_POST['capitalperiodo'];
                        $saldomoratorio = $_POST['saldomoratorio'];
                        //acciones que estan en el boton de la escritura
                        if((isset($descuento) and $descuento > 0 ) || (isset($minimoAAbonar) and $minimoAAbonar > 1)){
                            if((isset($descuento) and $descuento <= $montoADescontar) || (isset($montoDescuento) and $montoDescuento <= $saldomoratorio)){
                                if ($BIdMandante > 0){
                                    mensaje("Movimiento no permitido por ser un terreno con clasificacion MANDANTES, cualquier duda o aclaración favor de comunicarse al Depto de Crédito.", "autorizaDescuentos.php");
                                }

                                $IdDescuentoSig = siguienteIdAutorizaDescuentos();
                                if(isset($descuento)){
                                    $minimoRquiereAbonar = $capital - $descuento;
                                }else{
                                    $minimoRquiereAbonar = $minimoAAbonar;

                                }
                               
                                $sustento = nitavu_nombre($nitavu).'autoriza.-'.$justificacion;
                                $fechaTerminoCampaña = RevisaCampañaFechaTermino();
                                if($campaña <> 'FALSE'){
                                    $vigencia = date_format(date_create(date("d-m-Y",strtotime($fechaTerminoCampaña."- 1 days"))),"Y/m/d H:i:s");
                                }else{
                                    $vigencia = date_format(date_create(date("d-m-Y",strtotime($fecha."+ 1 month"))),"Y/m/d H:i:s");
                                }


                                //Buscamos descuentos anteriores para actualizarlos a falso
                                $sql="UPDATE autorizaciondescuentos SET activo=0,enviar=1,idempmodifica=".$nitavu." , fechaultimamod=now() WHERE NumContrato='".$NumContrato."'";
                                //echo $sql;
                                if ($Vivienda->query($sql) == TRUE){  
                                    //AGREGAMOS EL NUEVO REGISTRO DEL DESCUENTO DE ESCRITURA 
                                    if(isset($descuento)){
                                        $sql2="INSERT INTO  autorizaciondescuentos (NumContrato, FechaCaptura, IdEmpAutoriza, MontoDescuento, MinimoRequiereAbonar, SustentoAutorizacion, Vigencia, FechaAplicacion, Activo, 
                                        TipoDescuento, Enviar, IdEmpCrea, IdEmpModifica, FechaUltimaMod, FechaEnvio, IdMovDesc, OrigenDeEnvio)
                                        VALUES ('".$NumContrato."', now(), ".$nitavu.", ".$descuento.", ".$minimoRquiereAbonar.", '".$sustento."', '".$vigencia."', '', 1, '".$tipoDescuento."', 
                                        1, ".$nitavu.", '', '', '', ".$IdDescuentoSig.",'')";
                                    }else{
                                        $sql2="INSERT INTO  autorizaciondescuentos (NumContrato, FechaCaptura, IdEmpAutoriza, MontoDescuento, MinimoRequiereAbonar, SustentoAutorizacion, Vigencia, FechaAplicacion, Activo, 
                                        TipoDescuento, Enviar, IdEmpCrea, IdEmpModifica, FechaUltimaMod, FechaEnvio, IdMovDesc, OrigenDeEnvio)
                                        VALUES ('".$NumContrato."', now(), ".$nitavu.", ".$montoDescuento.", ".$minimoRquiereAbonar.", '".$sustento."', '".$vigencia."', '', 1, '".$tipoDescuento."', 
                                        1, ".$nitavu.", '', '', '', ".$IdDescuentoSig.",'')";
                                    }
                                    //echo $sql2;
                                    if ($Vivienda->query($sql2) == TRUE){ 
                                        mensaje('Se ha guardado el descuento con éxito','autorizaDescuentos.php');
                                    }else{
                                        mensaje('Ocurrio un error al intentar guardar el descuento, favor de intentarlo nuevamente.','autorizaDescuentos.php');
                                    }
                                }else{
                                    return FALSE;
                                }
                            }else{
                                if(isset($descuento)){
                                    mensaje('El descuento especificado no puede ser mayor a la deuda de escritura','autorizaDescuentos.php?search='.$NumContrato.'');
                                }else{
                                    mensaje('El descuento especificado no puede ser mayor a la deuda de moratorios','autorizaDescuentos.php?search='.$NumContrato.'');

                                }
                            }  
                        }else{
                            if(isset($minimoAAbonar)){
                                mensaje('Debe especificar una cantidad minima a abonar por el beneficicario.','autorizaDescuentos.php?search='.$NumContrato.'');
                            }else{
                                mensaje('No especificó ninguna cantidad para el descuento.','autorizaDescuentos.php?search='.$NumContrato.'');
                            }
                        }


                        //-----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
                    }else{//proceso normal cuando aun no se guarda nada

                        $estatus = EstatusCuenta($NumContrato);
                        //echo 'Estatus '.$estatus;
                        if($estatus <> 'SALDADA' and $estatus <> 'CON SALDO' and $estatus <> 'NOMINA'){
                            mensaje("Esta cuenta presenta el estatus : ".$estatus." para realizar algún movimiento a la cuenta es necesaria su activación", "autorizaDescuentos.php");
                        }
        
                        $TotDesc = totalDescuentos($NumContrato);
                        if($TotDesc > 1){
                            $BAplicoCamp = 1;
                            mensaje("A esta cuenta ya se le aplicaron 2 o más descuentos de Moratorio en la campaña vigente. No es posible acceder a un tercero , a EXCEPCION de que se vaya a realizar una liquidación de cuenta o que vaya a realizar un Descuento de Escrituración", "autorizaDescuentos.php");
                            ///     Frame7.Enabled = True
                             //    Frame4.Enabled = True
                        }else{
                            $BAplicoCamp = 0;
                            //echo '<label><input type="checkbox" name="liquidaCuenta" id="liquidaCuenta" value="first_checkbox">Liquidar cuenta</label>'; 
                        }
        
                        //incluimos los querys de analiza campaña
                        include("./analizaCampaña.php");
                        
                        echo "<br>";  
                        echo "<form action='autorizaDescuentos.php?search=".$NumContrato."' method='POST'>";      
                        echo "<input type='hidden' name='bidmandante' id='bidmandante' value='".$BIdMandante."'>"; 
                        echo "<input type='hidden' name='capitalperiodo' id='capitalperiodo' value='".$capitalPeriodo."'>"; 
                        echo "<input type='hidden' name='saldomoratorio' id='saldomoratorio' value='".$SaldoMoratorios7."'>"; 

                        //saldos cuenta
                        echo '<div style="background:#fff; width:50%;">';
                            echo "<br>";                    
                            echo "<center>";           
                                echo "<table style='width:90%'>";
                                echo "<tr>";
                                echo "<td colspan='2' style='text-align: center;'><b>RESUMEN DE LA CUENTA</b></td>";
                                echo "</tr>";
                                echo "<tr>";
                                echo "<td><span class='etiqueta-etiqueta principal normal'>Saldo</span></td>";
                                echo "<td style='text-align: right;'>$ ".$Saldo."</td>";
                                echo "</tr>";
                                echo "<tr>";
                                echo "<td><span class='etiqueta-etiqueta principal normal'>Saldo que debe cubrir</span></td>";
                                echo "<td style='text-align: right;'>$ ".$SaldoACubrir."</td>";
                                echo "</tr>";
                                echo "<tr>";
                                echo "<td><span class='etiqueta-etiqueta principal normal'>Saldo corriente</span></td>";
                                echo "<td style='text-align: right;'>$ ".  $SaldoCorriente."</td>";
                                echo "</tr>";                   
                                echo "<tr>";
                                echo "<td><span class='etiqueta-etiqueta principal normal'>Saldo Moratorios</span></td>";
                                echo "<td style='text-align: right;'>$ " .$SaldoMoratorios7. "</td>";
                                echo "</tr>";
                                echo "<tr>";
                                echo "<td><span class='etiqueta-etiqueta principal normal'>Saldo  Capital</span></td>";
                                echo "<td style='text-align: right;'>$ "  .$SaldoCapita."</td>";
                                echo "</tr>";
                                echo "<tr>";
                                echo "<td></td>";
                                echo "<td style='text-align: right;'></td>";
                                echo "</tr>";
                                echo "<tr>";
                                echo "<td colspan='2' align='center'>";
                                echo "<label class='etiqueta-etiqueta principal normal'>Justificación</label>";
                                echo "<input  type='text' name='justificacion' id='justificacion' value='".$justificacion."' readonly>";
                                echo "</td>";
                                echo "</tr>";
                                echo "</table>";
                            
                            echo "<br>";
                            echo "</center>";
                            echo '</div>';
                            echo "<br>";  



                            //DESCUENTOS
                            echo '<div style="background:#fff; width:50%;">';
                            echo "<br>";                    
                            echo "<center>";           
                                echo "<table style='width:90%' >";
                                echo "<tr>";
                                echo "<td style='text-align: center;'><b>DESCUENTOS A LOS QUE PUEDE ACCEDER ESTA CUENTA</b></td>";
                                echo "</tr>";
                                echo "<tr>";
                                echo "<td><span class='etiqueta-etiqueta principal normal'>*  Si paga su escritura hasta <b>$ ".$HastaDescEscritura."</b> de su adeudo.</span></b></td>";
                             
                                echo "</tr>";
                                echo "<tr>";
                                echo "<td><span class='etiqueta-etiqueta principal normal'>*  Si liquida su cuenta hasta <b>$ ".$vMontoDescuentoCapital."</b> de capital.</span></td>";
                               
                                echo "</tr>";                   
                                echo "<tr>";
                                echo "<td><span class='etiqueta-etiqueta principal normal'>*  Moratorios <b>".$vPorcMoraDesc." % </span></td>";
                              
                                echo "</tr>";
                                
                                echo "<tr>";
                                echo "<td></td>";
                                echo "<td style='text-align: right;'></td>";
                                echo "</tr>";
                                echo "</table>";
                            echo "</center>";
                            echo '</div>';
                            
                        if($TieneEscritura=='false')
                        {     
                            echo "<br>";   
                            //INTERES MORATORIO
                            echo '<div style="background:#fff; width:50%;">';
                            echo "<br>";                    
                                echo "<center>";           
                                    echo "<table style='width:90%'  >";
                                    echo "<tr>";
                                    echo "<td colspan='3' style='text-align: center;'><b>INTERES MORATORIO</b></td>";
                                    echo "</tr>";
                                    if($BAplicoCamp==0)
                                    {
                                    echo "<tr>";
                                    echo "<td ><b><label  class='etiqueta-etiqueta principal normal'><input  type='checkbox' name='liquidaCuenta' id='liquidaCuenta' onClick='HabilitarCampos();'> Liquidar cuenta</label></b></td>";
                                    echo "<td><span class='etiqueta-etiqueta principal normal' style='display:none;' id='DescuentoCapitalLiq' name='DescuentoCapitalLiq' >Descuento a capital</span></td>";
                                    echo "<td style='text-align: right;'><span id='saldoLiq' style='display:none;' name='saldoLiq'>$ "  .$vMontoDescuentoCapital."</span></td>";
                                    echo "</tr>";
                                    }
                                    echo "</table>";
                                    echo "<div style='width:100%' >";
                                    echo "<table style='width:90%' id='tablaDesc' name='tablaDesc'>";
                                    echo "<tr>";
                                    echo "<td style='width:50%'><span class='etiqueta-etiqueta principal normal'>Interes moratorio</span></b></td>";
                                    echo "<td style='text-align: right;' colspan='2'><input  type='text'  name='InteresMoratorio' id='InteresMoratorio' disabled value='".$SaldoMoratorios7."'></td>";
                                    echo "</tr>";                   
                                    echo "<tr>";
                                    echo "<td><b><span class='etiqueta-etiqueta principal normal'>Descuento %</span></b></td>";
                                    echo "<td style='text-align: right;'><input  type='text'  style='margin-left: 7px;'  name='Descuento' id='Descuento' onkeyup='onkeyupDescuento()' ></td>";
                                    echo "<td style='text-align: right;'><input  type='text'  name='MontoDescuento' id='MontoDescuento' readonly ></td>";
                                    echo "</tr>";
                                    echo "<tr>";
                                    echo "<td style='width:50%'><span class='etiqueta-etiqueta principal normal'>Cantidad que debe abonar para recibir el descuento (menos descuento de capital en caso de liquidación)</span></td>";
                                    echo "<td style='text-align: right;' colspan='2'><input  type='text'  name='CantidadAbonar' id='CantidadAbonar' ></td>";
                                    echo "</tr>";                          
        
                                    echo "<tr><td colspan='3'><br><b><span style='display:none; color:crimson;' id='etiquetamsg' name='etiquetamsg'  class='etiqueta-etiqueta principal'>** Esta cuenta no tiene permitido más del ".$vPorcMoraDesc. " % de descuento **</span></b></td></tr>"; 
        
                                          
                                    echo "</table>";
                                    echo "<br>";           
                                    echo "</div>";            
                                echo "</center>";
                            echo '</div>';
                            }
                            //ESCRITURA
                            echo "<br>";   
                            if( $TieneEscritura=='true' and ($PorPagarEsc>0 or $HastaDescEscritura>0))
                            {                   
                            echo '<div style="background:#fff; width:50%;">';
                                echo "<br>";                    
                                echo "<center>";           
                                    echo "<table style='width:90%' >";
                                    echo "<tr>";
                                    echo "<td colspan='3' style='text-align: center;'><b>ESCRITURA</b></td>";
                                    echo "</tr>";
                                    echo "<tr>";
                                    echo "<td style='width:50%'><span class='etiqueta-etiqueta principal normal'>Monto Disponible a descontar</span></b></td>";
                                    echo "<td style='text-align: right;' ><input  type='text'  name='MontoADescontarEsc' id='MontoADescontarEsc' value='".$PorPagarEsc."' readonly ></td>";
                                    echo "</tr>";                   
                                    echo "<tr>";
                                    echo "<td><b><span class='etiqueta-etiqueta principal normal'>Descuento (En Pesos)</span></b></td>";
                                    echo "<td style='text-align: right;'><input  type='text'  name='descuentoEscritura' id='descuentoEscritura' onkeyup='onkeyupDescuentoEscritura()' ></td>";           
                                    echo "</tr>";  
                                    echo "<tr><td colspan='3'><br><b><span style='display:none; color:crimson;' id='etiquetamsgEsc' name='etiquetamsgEsc'  class='etiqueta-etiqueta principal'></span></b></td></tr>";                                  
                                    echo "</table>"; 
                                    echo "<br>";
                                    if($BIdMandante>0)
                                    { 
                                    echo sugerencia("Este descuento no aplica a este contrato. Motivo : Mandante. (IdMandante:".$BIdMandante.")");
                                    }
                                               
                                    echo "<br>"; 
                                  
                                    echo "</center>";                    
                            echo '</div>';
                            }
                            echo "<br>";  
                            echo '<button type="submit"  name="btnGuardar" id="btnGuardar" class="btn btn-primary">Aplicar Descuento</button>';
                            echo "<br>";  
                            echo "<br>";  
                         echo '</div>';
                        echo "</form>";               
                        echo "</center>";
                    }
                }
            
            }else{
                mensaje('No ha sido posible localizar el contrato, favor de realizar una búsqueda nuevamente.', 'autorizaDescuentos.php');
            }
        }
            
    }else{
        mensaje("No se encontró Campaña de Descuento Activa en este período de tiempo, imposible continuar","index.php");
    }
    
}else{mensaje("ERROR: no tienes acceso a este modulo","");}

?>
<?php include ("lib/body_footer.php"); ?>
<script>

document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('input[type=text]').forEach( node => node.addEventListener('keypress', e => {
    if(e.keyCode == 13) {
        e.preventDefault();
    }
    }))
});




function HabilitarCampos(){

   
    document.getElementById("Descuento").value="";
    document.getElementById("MontoDescuento").value="";
    document.getElementById("CantidadAbonar").value="";
    nom= document.getElementById('liquidaCuenta');

   if (nom.checked == true){
        document.getElementById("CantidadAbonar").disabled=true;
        $("#DescuentoCapitalLiq").css({'display':'inline-block'}); 
        $("#saldoLiq").css({'display':'inline-block'}); 
        document.getElementById("Descuento").value="0";
       
        document.getElementById("CantidadAbonar").value=<?php echo $Saldo; ?>; 
        
	}else{

        document.getElementById("CantidadAbonar").disabled=false;
        $("#DescuentoCapitalLiq").css({'display':'none'}); 
        $("#saldoLiq").css({'display':'none'}); 
    }
 }



// $('input').keydown( function( event ) {
//     if ( event.which === 13 ) {
   

//         porcentajeDesc=<?php echo $vPorcMoraDesc; ?>;
//        // porcentajeDesc=50;
//         descuento= document.getElementById("Descuento").value;  
//         interesMora= document.getElementById("InteresMoratorio").value;      
//         if(descuento>0 && descuento <=100)
//         {
//             if(descuento > porcentajeDesc )
//             {  $("#etiquetamsg").css({'display':'inline-block'});  
//             document.getElementById("CantidadAbonar").disabled=true;
//             document.getElementById("CantidadAbonar").disabled=true;//btn
                 
//             }else
//             {
//                 $("#etiquetamsg").css({'display':'none'}); 
//                 document.getElementById("CantidadAbonar").disabled=false;
//             }

//             document.getElementById("MontoDescuento").value =  interesMora * (descuento / 100);
//         }else
//         {
//             document.getElementById("CantidadAbonar").value =0;  
//            // $('#etiquetamsg').html("* Porcentaje no permitido!! *"+"\n");
//             //$("#etiquetamsg").css({'display':'inline-block'});   
//         }
//     }

//     if(document.getElementById('liquidaCuenta').checked == true)
//     {              
//        document.getElementById("CantidadAbonar").disabled=true;   
       
//     }
// });

function OnBlurDescuento()
{   
  
        porcentajeDesc=<?php echo $vPorcMoraDesc; ?>;
        descuento= document.getElementById("Descuento").value;  
        interesMora= document.getElementById("InteresMoratorio").value;      
        if(descuento>0 && descuento <=100)
        {
            if(  descuento > porcentajeDesc )
            {  $("#etiquetamsg").css({'display':'inline-block'});  
            document.getElementById("CantidadAbonar").disabled=true;
                 
            }else
            {
                $("#etiquetamsg").css({'display':'none'}); 
                document.getElementById("CantidadAbonar").disabled=false;
            }

            document.getElementById("MontoDescuento").value =  interesMora * (descuento / 100);
            // if(LblPorcentajeMor7 50
            // {
            //     vTipoDescuento = 120
            // }
            // else
            // {
            //     vTipoDescuento = 121
            // }

        }else
        {
            if(descuento>100)
            {
                $('#etiquetamsg').html("* Porcentaje no permitido!! *"+"\n");
                $("#etiquetamsg").css({'display':'inline-block'});
                document.getElementById("btnGuardar").disabled=true;    
            }else
            {
                document.getElementById("btnGuardar").disabled=false; 
            }
            //document.getElementById("CantidadAbonar").value =0;     
        }
        if(document.getElementById('liquidaCuenta').checked == true)
    {              
       document.getElementById("CantidadAbonar").disabled=true;      
    }

    }





    function onkeyupDescuento()
    {
        x= document.getElementById('Descuento').value;    
        if( x.length  == 0)
        {   document.getElementById("MontoDescuento").value='';    
            document.getElementById("CantidadAbonar").value ='';          
        }
        else
        {
            document.getElementById("btnGuardar").disabled=false; 
            porcentajeDesc=<?php echo $vPorcMoraDesc; ?>;
            descuento= document.getElementById("Descuento").value;  
            interesMora= document.getElementById("InteresMoratorio").value;      
            if(descuento>0 && descuento <=100)
            {
                if(  descuento > porcentajeDesc )
                {  $("#etiquetamsg").css({'display':'inline-block'});  
                document.getElementById("CantidadAbonar").disabled=true;
                    
                }else
                {
                    $("#etiquetamsg").css({'display':'none'}); 
                    document.getElementById("CantidadAbonar").disabled=false;
                }

                document.getElementById("MontoDescuento").value =  interesMora * (descuento / 100);
                // if(LblPorcentajeMor7 50
                // {
                //     vTipoDescuento = 120
                // }
                // else
                // {
                //     vTipoDescuento = 121
                // }

            }else
            {
                if(descuento>100)
                {
                    $('#etiquetamsg').html("* Porcentaje no permitido!! *"+"\n");
                    $("#etiquetamsg").css({'display':'inline-block'});
                    document.getElementById("btnGuardar").disabled=true;    
                }else
                {
                    document.getElementById("btnGuardar").disabled=false; 
                }
                //document.getElementById("CantidadAbonar").value =0;     
            }

            

            if(document.getElementById('liquidaCuenta').checked == true)
            {   
                saldo=<?php echo $Saldo; ?>;     
            montodescuento= document.getElementById("MontoDescuento").value;            
            document.getElementById("CantidadAbonar").value=saldo-montodescuento;    
            document.getElementById("CantidadAbonar").disabled=true;    
          
            }
            if(document.getElementById('liquidaCuenta').checked == true)
            {              
                document.getElementById("CantidadAbonar").disabled=true;      
            }
        }
        
    }
    
    // function OnChangeDescuento(saldo)
    //     {  
    //     if(document.getElementById('liquidaCuenta').checked == true)
    //         {        
    //         montodescuento= document.getElementById("MontoDescuento").value;            
    //         document.getElementById("CantidadAbonar").value=saldo-montodescuento;    
    //         document.getElementById("CantidadAbonar").disabled=true;    
          
    //         }
    //     }   

 
    function onkeyupDescuentoEscritura()
    {
        descuentoPermitido= document.getElementById('MontoADescontarEsc').value; 
        descuento= document.getElementById('descuentoEscritura').value; 
        console.log(descuentoPermitido);
        console.log(descuento);
        
        if(parseFloat(descuento)>parseFloat(descuentoPermitido))
        {
             $('#etiquetamsgEsc').html("** El descuento no puede ser mayor  al monto disponible a descontar **");
             $("#etiquetamsgEsc").css({'display':'inline-block'});   
            document.getElementById("btnGuardar").disabled=true;   
        }else{
            document.getElementById("btnGuardar").disabled=false;  
            $("#etiquetamsgEsc").css({'display':'none'}); 
            console.log('menor'); 
        }


       
        
    }
</script>