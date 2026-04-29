<?php include ("./lib/body_head.php"); include ("./lib/body_menu.php"); 
require_once("config.php");
//include("./lib/laura.css");
?>
<!-- editable -->
<!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<script type="text/javascript" src="dist/jquery.tabledit.js"></script>
<script type="text/javascript" src="custom_table_edit.js"></script> -->


<?php
$id_aplicacion ="ap117"; //tabla aplicaciones
$nivel = aplicacion_nivel($id_aplicacion, $nitavu); //tabla aplicaciones permisos


//Niveles
// 1 = Crear y Editar
// 2 = Consulta

//Ajusta esta variable para ver el comportamiento
//$nivel=1;

//echo "<script>$('body').css('background-color','rgb(108, 116, 119)');</script>";



if (sanpedro($id_aplicacion, $nitavu)==TRUE){
   
    if(isset($_GET['convenio'])){
        



        $IdConvenio = VarClean($_GET['convenio']);
        
        echo "<div style='
        background: rgb(33,116,166);
        background: linear-gradient(180deg, rgba(33,116,166,1) 0%, rgba(33,116,166,1) 14%, rgba(108,116,119,1) 71%); 
        margin-top:-8px;
        padding:10px;        
        '
     
        >";
            echo "<table width=100%>";
            echo "<tr>";
            echo "<td style='text-align-last: left';><h3 style='color:white;'>Convenio Num.".$IdConvenio."</h3></td>";
            echo "<td align=right>";
            echo "<a  class='btn btn-primary' href='?='>Regresar</a>";
            echo "</td>";
            echo "</tr>";
            echo "</table>";
        echo "</div>";

        echo "<div id='Form' class='container' style='background-color: #fff;
        border-radius: 5px;
        padding: 15px;
        margin-top:20px;
        '>";
        
       $sql="Select Folio, IdDelegacion, IdPrograma, DATE_FORMAT(FechaConvenio, '%d-%m-%Y') as FechaConvenio, PlazoConvenio, TotalLotes, MontoConvenio,
       (select catdesarrolladores.Nombre from catdesarrolladores where catdesarrolladores.IdDesarrollador = convdesarrollador.IdDesarrollador) AS Nombre,
       AnticipoGlobal,SubsidioLote,case when Completo= 1 then 'Completo' else 'incompleto' end AS Completo
       from convdesarrollador where  Folio=".$IdConvenio." Order By Folio" ;
        
        //echo $sql;
        $rc= $Vivienda -> query($sql);
        if($f = $rc -> fetch_array())
            {
                                           
                echo "<div style='margin-left: 25px'>";
                    echo "<table width=100%><tr>";                      

                        echo "<td valign=top >";
                        echo "<h3>Cobranza de convenios-Desarrolladores</h3>";
                        echo "<label>Desarrollador        :       ".$f['Nombre']."</label><br>";
                        echo "<label>Numero de Convenio   :       </label><label id='folioconv'>".$f['Folio']."</label><br>";
                        echo "<label>Fecha de Convenio    :       ".$f['FechaConvenio']."</label><br>";   
                        FormElement_input("Plazo Convenio",$f['PlazoConvenio'],"", "","number","PlazoConvenio", TRUE);
                        FormElement_input("Monto del Convenio",Pesos($f['MontoConvenio']),"", "","text","MontoConvenio", TRUE);                        
                        FormElement_input("Total Lotes",$f['TotalLotes'],"", "","number","TotalLotes", TRUE);                
                        echo "</td></tr>";
                        echo "</table>"; 
                        echo "<table width='95%'>";
                        echo "<tr><td>";                             
                         echo "<br></td>
                            </tr>";
                        echo "</table>";
               echo "</div>";  

               $sumadeuda=0;                 

               echo "<div class='card-body'>";                        
               echo "<div class='container' >";
                    echo '<div class="card " style="text-align: justify; width: 100%;">
                    <h1 class="card-header h5" style="text-transform: uppercase;font-size: 10pt;">Datos del Pago</h1>';     
                        echo '<center>';          
                        echo '<div class="row" >';  
                            //col-lg-3 margin: 0px;"
                            echo ' <div  style="width:90%;" >';
                           // class=”col-lg-3 col-md-2 col-sm-1 col-xs-1″
                            //class="col-xs-6 col-md-4" style="text-align: justify; margin: 0px;">'; 
                            echo '<br>';  
                            //echo '<h6 class="card-title">Tasa de Financiamiento</h6>';                               
                                        echo "<table style='width:90%; margin-left: 20px; font-size: 10pt;' >";
                                        echo "<tr><td>";
                                        echo "<label for='FechaPago'>Fecha Pago</label><br>";
                                        echo "<input type='date' id='FechaPago'  value='".$fecha."' style='width: 140px; border-radius: 5px;' disabled>";
                                        echo "</td></tr>";
                                        
                                            echo "<tr >";
                                        // echo "<td style='width:50%'><span class='normal'>Fecha Pago</span></td>";                           
                                            echo "<td style='padding: 15px;'><span>";
                                            //<input  type='text' style='width:130px'  class='textfinanc' name='TasaAnualFin' id='TasaAnualFin' value='0'>%</span></td>";
                                            echo '<label for="TipoPago" style="font-size:10pt;  color:blue; ">Seleccione el Tipo de Pago</label>';
                                            echo "<select id='TipoPago' class='form-control'  style='font-size:9pt;  '>";                                                                             
                                            $rx= $Vivienda -> query("select * from catformapago WHERE IdFormaPago in (1,2,3,4)");                
                                            while($fx = $rx -> fetch_array()) {    
                                                    echo "<option value='".$fx['IdFormaPago']."' >".$fx['FormaPago']."</option>";
                                                    $IdMunicipio=$fx['IdFormaPago'];                                                
                                            }                       
                                            
                                            unset($rx, $fx);
                                            echo "</select></span></td>";
                                            echo "<td ><span>";  
                                                echo "<label for='Referencia'>Referencia del pago</label>";
                                                echo "<input type='text' id='Referencia'  style='border-radius: 5px;' >";
                                            echo "</span></td>";
                                            echo "<td><span>";  
                                                echo "<label for='MontoPago' >Monto del Pago</label>";
                                                echo "<input type='number' min=0 id='MontoPago' value='0.00' onchange='revisadeuda();' style='border-radius: 5px;text-align: right;'>";
                                            echo "</span></td></tr>  
                                            <tr><td colspan='3'><span>";  
                                                echo "<label for='Concepto'>Concepto del pago</label>";
                                                echo "<input type='text' id='Concepto'  style='border-radius: 5px;' placeholder='Breve explicación del pago'>";
                                                    
                                            echo "</span></td>";       
                                            echo "</tr>";  
                                            echo "<tr>";   
                                            echo "<td  colspan='3'><span>";  
                                              
                                                echo '<div class="accordion" id="accordionExample">
                                                        <div class="accordion-item">
                                                            <h2 class="accordion-header" id="headingOne">
                                                                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne"  style="height: 15px;">
                                                                 <h6 class="card-title" style="font-size: 12px;">¿Es un pago histórico? Click aquí</h6>
                                                                </button>
                                                            </h2>
                                                            <div id="collapseOne" class="collapse" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                                                                <div class="accordion-body">
                                                                    <label for="FechaPagoHis">Fecha Pago Historico</label><br>
                                                                    <input type="date" id="FechaPagoHis"  value="'.$fecha.'" style="width: 140px; border-radius: 5px;">

                                                                    <label for="NumRec">Número de Recibo</label>
                                                                    <input type="text" id="NumRec"  style="border-radius: 5px; width:300px">
                                                                </div>
                                                            </div>
                                                        </div>';
                                                        //class="accordion-collapse collapse show"
                                                echo "<span></td></tr>";   
                                                
                                                echo "<tr><td>";
                                                echo '<div>';
                                                echo '  <div class="form-check form-check-inline">
                                                            <br>
                                                            <input  type="radio" name="opciondesg" id="inlineCheckbox1" value="1">
                                                            Igual cantidad en cada lote
                                                        </div>
                                                        
                                                        <td>
                                                        <div class="form-check form-check-inline">
                                                            <br>
                                                            <input  type="radio" name="opciondesg" id="inlineCheckbox2" value="2">
                                                            Liquidar lotes sin orden
                                                        </div>
                                                        </td><td>
                                                        <div class="form-check form-check-inline">
                                                            <br>
                                                            <input  type="radio" name="opciondesg" id="inlineCheckbox3" value="3" >
                                                            Seleccionar lotes a pagar
                                                        </div>';
                                                echo '</div>';    
                                                echo"</td></tr>";
                                                echo "<tr><td colspan=3 align='right'><span>";              
                                                   // echo "<button  type='submit' id='RegPago'  class='btn btn-primary' style='font-size:13px;' disabled>Registrar Pago</button>"; 
                                                  // window.open('http://www.youtube.com','_blank');
                                                  
                                                   //echo "<button  type='submit' id='prueba' name='prueba' onclick='prueba();'  class='btn btn-primary' style='font-size:13px;'  >ABRE NUEVO</button>";    
                                                    echo "<button  type='submit' id='RegPago' name='RegPago' onclick='registra();' class='btn btn-primary' style='font-size:13px;' disabled >Registrar Pago</button>";    
                                                    echo "<button  type='submit' id='ImprimeRecibo' name='ImprimeRecibo' onclick='ImprimeRec(".$f['IdDelegacion'].",".$f['IdPrograma'].",".$f['Folio'].");' class='btn btn-primary' style='font-size:13px; margin-inline: 5px; display: none;'  >Imprime Recibo</button>";    
                                                    echo "<input type='text' id='newrecibo' hidden>";
                                                echo "<span></td></tr>"; 
                                                echo "</table>";    
//display:none
                                                echo"<br><div id='mensajes' name='mensajes' style='background:skyblue; ' ></div>";
                                            //    echo"<br><div id='mensajes2' name='mensajes2' style='background:skyblue; ' ></div>";
                                                echo '<div id="infoOpciones" style="display:none;" class="container">';
                                                    echo '<div name="IgualCantidad"  id="IgualCantidad" style="display:none;" >';
                                                        echo '<label style="";>Se dividió el pago global entre cada lote con deuda</label>';
                                                    echo '</div>';    
                                                    echo "<div name='LiquidarLotes'  id='LiquidarLotes' style='display:none;'>";
                                                        echo '<h3>El pago se abonó a lotes para cubrir su saldo</h3>';
                                                    echo '</div>';    
                                                    echo "<div name='SeleccionLotes' id='SeleccionLotes' style='display:none;'>";
                                                        echo '<h4>Escriba el monto correspodiente a cada lote</h4>';
                                                    echo '</div>';    
                                                echo '</div>';
                                                echo '<div id="tablalotes" style="display:none;">
                                                        <table id="data_table" class="table table-striped" style="font-size: 13px;">
                                                        <thead>
                                                        <tr>
                                                        <th>IdLote</th>
                                                        <th>NumContrato</th>
                                                        <th>Colonia</th>
                                                        <th>Manzana</th>
                                                        <th>Lote</th>
                                                        <th>Precio</th>
                                                        <th>Actualización</th>
                                                        <th>Pagado</th>
                                                        <th>Por Pagar</th>
                                                        <th>Pago</th>                     
                                                        </tr>
                                                        </thead>
                                                        <tbody>';           
                                                        
                                                        $sql="SELECT NumContrato,idLote,
                                                        ( select colonia from catcolonia where catcolonia.IdColonia=contratos.IdColoniaL and catcolonia.IdMunicipio=contratos.IdMunicipioL
                                                         ) as colonia, manzana, lote, MontoCredito,
                                                         IFNULL((select SUM(MontoPagoRecibido) from  historicopagos WHERE contratos.NumContrato=historicopagos.NumContrato and cancelado=0
                                                          ),0) as pagado,  
                                                            (  select MontoCredito- SUM(MontoPagoRecibido)  as cant from  historicopagos WHERE contratos.NumContrato=historicopagos.NumContrato and cancelado=0
                                                          ) as porpagar,
                                                            (Select sum(CapitalPeriodo)  from historicopagos where contratos.NumContrato=historicopagos.NumContrato and TipoMov in (Select idTipoMov from descripcionmovimiento where IdTipoCuenta in( 1,4))
                                                            ) as sumcargostot,
                                                            
                                                            IFNULL((Select sum(CapitalPeriodo)  from historicopagos where contratos.NumContrato=historicopagos.NumContrato and TipoMov in (Select idTipoMov from descripcionmovimiento where IdTipoCuenta in( 4))
                                                            ),0) as sumcargos,	
                                                         0 as pago 
                                                         FROM `contratos` where IdPrograma=165 and folio=".$IdConvenio;
                                                         
                                                        $lotesconsaldo=0;        
                                                        $menorsaldo=0;
                                                        $mayorsaldo=0;
                                                        $primvalor=0;
                                                        $lotconv= $Vivienda -> query($sql);
                                                    while($lotes = $lotconv -> fetch_array()){                                                    
                                                        if ($lotes ['porpagar']>0){ 
                                                        echo "<tr id=".$lotes ['idLote']." value=".$lotes ['porpagar'].">";                      
                                                        echo "<td>".$lotes ['idLote']." </td>";
                                                        echo "<td>".$lotes ['NumContrato']." </td>";
                                                        echo "<td>".$lotes ['colonia']." </td>";
                                                        echo "<td>".$lotes ['manzana']." </td>";
                                                        echo "<td>".$lotes ['lote']." </td>";
                                                        echo "<td style='text-align:right;'>".$lotes ['MontoCredito']." </td>";
                                                        echo "<td style='text-align:right;'>".$lotes ['sumcargos']." </td>";
                                                        echo "<td style='text-align:right;'>".$lotes ['pagado']." </td>";                                                        
                                                        echo "<td style='text-align:right;' class='pp'>".$lotes ['porpagar']." </td>";
                                                            //if ($lotes ['porpagar']>0){                                                            
                                                                echo "<td><div id='pagodiv' ><input type='number' id='pago".$lotes ['NumContrato']."' name='pago".$lotes ['NumContrato']."' class='random' value='0.00' min=0 style='text-align:right; width: 150px;' disabled ></div></td>";                                                                
                                                                $lotesconsaldo=$lotesconsaldo+1;
                                                                $sumadeuda=$sumadeuda+$lotes ['porpagar'];
                                                                if($primvalor==0){
                                                                    $primvalor=1;
                                                                    $menorsaldo=$lotes ['porpagar'];                                                                     
                                                                }elseif($lotes ['porpagar'] <$menorsaldo){
                                                                    $menorsaldo=$lotes ['porpagar'];
                                                                };                                                              

                                                                if ($lotes ['porpagar']>$mayorsaldo){
                                                                    $mayorsaldo=$lotes ['porpagar'];     
                                                                };
                                                            

                                                            //}else{
                                                            //    "<td><div><label>Liquidado</label></div></td>";
                                                            //}    
                                                        echo '</tr>';               
                                                        //ag
                                                        }                                          
                                                      } 
                                                      echo '<tr>
                                                      
                                                      <td colspan=9 style="text-align:right;">Total</td><td>';
                                                            
                                                            echo "<input type='txt' id='total'  value='0' style='width: 140px; border-radius: 5px; text-align:right;' disabled >";                
                                                        echo '</td></tr>';
                                                    echo ' </tbody>
                                                        </table>              ';
                                               echo ' </div>';

                                            echo "<div>" ;            
                                            echo "<input type='number' id='menor'  value='".$menorsaldo."' style='width: 140px; border-radius: 5px;' hidden >";
                                            echo "<input type='number' id='mayor'  value='".$mayorsaldo."' style='width: 140px; border-radius: 5px;' hidden >";
                                            echo "<input type='number' id='lotesconsaldo'  value='".$lotesconsaldo."' style='width: 140px; border-radius: 5px;' hidden>";
                                            echo "<label for='deuda'>Deuda de Convenio</label>";
                                            echo "<input type='number' id='deuda'  value='".$sumadeuda."' style='width: 140px; border-radius: 5px; text-align:right; height: 20px;'   disabled>";
                                            echo "</div>" ;  
                                echo "<br>";
                            echo "</div> ";      
                        echo "</div> ";     
                            
                        echo '</center>';                                  
                    echo "</div> ";                                                              
               echo "</div> "; 
                       
               echo "</div>";          
            } 
    }else if(isset($_GET['DatosRecibo']))
          {
           
         $IdDelegacion = $_GET['IdDelegacion'];
         $IdPrograma = $_GET['IdPrograma'];
         $Folio = $_GET['Folio'];
             echo "<div id='contenedorRecibo'  style='margin-top: 50px;'>";  			
            echo "<div>";
                echo "<iframe id='framerecibo' name='framerecibo' src='desarr_recibo.php?DatosRecibo=".$_GET['DatosRecibo']."&IdDelegacion=".$IdDelegacion."&IdPrograma=".$IdPrograma."&Folio=".$Folio."' style='width:100%; height:100%; border:0; border:none;'>Tu navegador no soporta iframes...</iframe>";
            //    echo "<iframe id='framerecibo' name='framerecibo' src='desarr_recibo.php?DatosRecibo=180774&IdDelegacion=3&IdPrograma=165&Folio=102' style='width:100%; height:100%; border:0; border:none;'>Tu navegador no soporta iframes...</iframe>";
                //echo "<iframe id='framerecibo' name='framerecibo' src='formatoRecibo2.php?DatosRecibo=".$_GET['DatosRecibo']."&IdDelegacion=".$IdDelegacion."&IdPrograma=".$IdPrograma."&Folio=".$Folio."' style='width:100%; height:100%; border:0; border:none;'>Tu navegador no soporta iframes...</iframe>";
            echo "</div>";
            echo "</div>";  
          
    }else{   
            echo "<div id='AppDetalle'>".app_detalle($id_aplicacion, $nitavu)."</div>";
            echo "<script>$('#AppDetalle').css('background-color','rgba(2, 2, 2, 0.41)');</script>";

            //carga listado de desarrolladores
            echo "<div style='
            background: rgb(33,116,166);
            background: linear-gradient(180deg, rgba(33,116,166,1) 0%, rgba(33,116,166,1) 14%, rgba(108,116,119,1) 71%); 
            margin-top:-8px;
            padding:10px;
            
            '>";
                echo "<table width=100%>";
                echo "<tr>";
                echo "<td align=center><h3 style='color:white;'></h3></td>";
                echo "<td align=right>";
                //echo "<a  class='btn btn-primary' href='?new='>Nuevo</a>";
                echo "</td>";
                echo "</tr>";
                echo "</table>";
            
            echo "</div>";

            echo "<div id='Resultado' class='container' style='background-color: #fff;
            border-radius: 5px;
            padding: 15px;
            margin-top:20px;
            '></div>";
    }    

}

else {MsgBox_Lite("No tiene permiso para ver esta aplicacion",'');}	 


?>
<script>
function VReload(){		            
        search = $('#search').val();
        $('#progressbar').show();
            $.ajax({
                url: "desarroll_buscarDesarrConvs.php",
            type: "post",        
            data: {search:search},
            success: function(data){                
                $("#Resultado").html(data+"");                    
                $('#progressbar').hide();
            }
            }); 
            
}


VReload();

$("input[name=opciondesg]").change(function () {	   
   // limpiarDatos();   
   // alert('responde');
   var totalpago=$("#MontoPago").val();
   if(parseFloat(totalpago)<1){
        //console.log('aqui'+totalpago);
        alert('No registró un monto válido, imposible continuar');
        $('#MontoPago').val(0);
        //$('input:radio[name=opciondesg]:checked').val(0)
        unselect();
    }else{

        $("#infoOpciones").css({'display':'inline-block',});
        $("#tablalotes").css({'display':'inline-block',});
    

        //alert($('input:radio[name=opciones]:checked').val());
        if(($('input:radio[name=opciondesg]:checked').val()=='1')){
            $("#IgualCantidad").css({'display':'inline-block',});
            $("#IgualCantidad").css({'color':'red',});
            $("#LiquidarLotes").css({'display':'none',});
            $("#SeleccionLotes").css({'display':'none',});
            $('[class="random"]').attr('disabled',true);
            //$("#pago").prop( "disabled", true );
            
            $("#tablalotes").css({'display':'inline-block',});
        // $('[name="pago"]:disabled').map(function()  {} ;
            //alert('1');

            //var totalpago=$("#MontoPago").val();
            var totallotes=$("#TotalLotes").val();
            var menorsaldo=$("#menor").val();
            var mayorsaldo=$("#mayor").val();
            var lotesactivos=$("#lotesconsaldo").val();
            
            montopago=parseFloat(totalpago)/lotesactivos;
            montopago=montopago.toFixed(2);      

            //console.log('totalpago'+totalpago);
            //console.log('lotesact'+lotesactivos);
            //console.log('pagodiv'+montopago);
            
            if (parseFloat(montopago)>parseFloat(menorsaldo) || parseFloat(montopago)>parseFloat(mayorsaldo)){
                    alert('El monto sobrepasa la deuda de un lote listado, elija otra opción para el desglose');
                    $('[id="pago"]').val('0.00');
                    $("#total").val('0.00');
                    $('[class="random"]').val('0.00');
                    $("#RegPago").attr('disabled',true);
            } else {
                    $("#total").val(totalpago);
                    //$('[id="pago"]').val(montopago);
                    $('[class="random"]').val(montopago);
                   $("#RegPago").attr('disabled',false); 
            }    ;      
            
        }else if(($('input:radio[name=opciondesg]:checked').val()=='2')){
            $("#IgualCantidad").css({'display':'none',});
            $("#LiquidarLotes").css({'display':'inline-block',});
            $("#SeleccionLotes").css({'display':'none',});           
            $("#tablalotes").css({'display':'inline-block',});
            $('[class="random"]').attr('disabled',true);
            var pagado=0;
            var saldo=totalpago;
            var liquidar=document.getElementById('data_table').rows;
            //var liquidar = document.getElementsByClassName("random");
                for(var i=1; i<liquidar.length-1; i++) {
                    var porpagar= document.getElementById("data_table").rows[i].cells[8].innerText 
                    var contrato= document.getElementById("data_table").rows[i].cells[1].innerText                
                    var cuadro=document.getElementById("data_table").rows[i].cells[9];
                    //console.log('porpagar'+porpagar);
                
                    if (parseFloat(porpagar)>0 ){
                        if (parseFloat(porpagar)<saldo){                        
                            saldo=saldo-parseFloat(porpagar);
                            pagado=pagado+parseFloat(porpagar);                         
                            // document.getElementById("data_table").rows[i].cells[9].innerText=porpagar;                      
                        nombrecampo='pago'+contrato;                       
                        $("#"+nombrecampo).val(porpagar);   
                            document.getElementById("data_table").rows[i].cells[9].style.textAlign="right";

                        }else{
                            paguito=parseFloat(saldo);                        
                            //document.getElementById("data_table").rows[i].cells[9];
                            nombrecampo='pago'+contrato;
                            $("#"+nombrecampo).val(paguito.toFixed(2));
                            document.getElementById("data_table").rows[i].cells[9].style.textAlign="right";
                            saldo=0;
                            pagado=pagado+parseFloat(paguito); 
                        }
                    }                
                }
                $("#total").val(pagado.toFixed(2));
                if ((totalpago-pagado)<1){
                    $("#RegPago").attr('disabled',false);
                }
        

        }else if(($('input:radio[name=opciondesg]:checked').val()=='3')){
            $("#IgualCantidad").css({'display':'none',});
            $("#LiquidarLotes").css({'display':'none',});               
            $("#SeleccionLotes").css({'display':'inline-block',});
            //$('[id="pago"]').attr( "style", 'color:blue;text-align:right;' );
            //$("div").attr("style", "display:block; color:red")
            
            $("#total").val('0.00');
            $('[class="random"]').val('0.00');
            $('[class="random"]').attr('disabled',false);
            $("#RegPago").attr('disabled',true);

            //var checked = $(".form-check-input:checked").length;
            //var checkedelemids = $('input[type=checkbox]:checked').map(function(){
            //var checkedelemids = $('.form-check-input:Checked').map(function(){                  
                //  $('[name="pago"]:disabled').map(function()    
        // var checkedelemids = $('[class="random"]:checked').map(function(){      
            //}
        }else{
            alert('no entre a nada');
        }
    }
   
});

$('[class="random"]').change(function () {
 var suma = 0;
            $('.random').each(function(){
            suma += parseFloat($(this).val());
            console.log(suma);
         }); 
         $("#total").val(suma);
         var totalpago2=$("#MontoPago").val();

    //     console.log('resta',(totalpago2-suma));

         if (suma>totalpago2){
             alert('Ha sobrepasado el monto del pago imposible registrar')
             $("#total").attr('disabled', true);
         }else if((totalpago2-suma)<8){
            $("#RegPago").attr('disabled', false);
         }else{
                $("#RegPago").attr('disabled',true);
            }


});

function revisadeuda(){
    var sumadeuda=$('#deuda').val();	
    var montopago=$("#MontoPago").val();	
    if(parseFloat(montopago)>sumadeuda){
        alert('el monto del pago es mayor que la deuda del convenio $'+sumadeuda+ ' imposible continuar');
        $('#MontoPago').val(0);
        //$('input:radio[name=opciondesg]:checked').val(0)
        unselect();
    }
}    

function unselect() {
        document.querySelectorAll('[name=opciondesg]').forEach((x) => x.checked = false);
        $("#tablalotes").css({'display':'none',});
        $("#infoOpciones").css({'display':'none',});
        $("#RegPago").attr('disabled',true);
}

function revisamontoxx(montopago){	
        var menorsaldo=$("#menor").val();
        var mayorsaldo=$("#mayor").val();	
        //console.log('montopago'+montopago);           
        //console.log('menorsaldo'+menorsaldo);           
        //console.log('mayorsaldo'+mayorsaldo);           
        //alert(menorsaldo);
        //alert(mayorsaldo);
        resta=menorsaldo-montopago;
        //alert('resta'+resta);
        //resta=number(resta);        
        //if (montopago>menorsaldo || montopago>mayorsaldo ){
    if (parseFloat(montopago)>parseFloat(menorsaldo) || parseFloat(montopago)>parseFloat(mayorsaldo)){
                alert('El monto sobrepasa la deuda de un lote listado, elija otra opción para el desglose');
                $('[id="pago"]').val('0.00');
                alert('resta mayor que cero');
                return false;
    }else {        
                $("#total").val(totalpago);
                $('[id="pago"]').val(montopago);
                alert('resta mayor que cero');
                return true;
    }    ;     
       
}

function cuantosconpago(){
cuantoscontratos=0;
cualescontratos='';
var tabla2=document.getElementById('data_table').rows;
  
        for(var x=1; x<tabla2.length-1; x++) {

            var contrato= document.getElementById("data_table").rows[x].cells[1].innerText;  
            nombrecampo='pago'+contrato;      

                var pago=$("#"+nombrecampo).val();
                    
                   //console.log('CONTRATO'+contrato);
                    //console.log('por pagar'+porpagar);
                    //console.log('pago='+pago);

                    if (parseFloat(pago)>0){                        
                        cuantoscontratos++;
                        cualescontratos=cualescontratos+','+contrato;
                    }    

        }
       // console.log('totcont'+cuantoscontratos);
       // console.log('listacont'+cualescontratos);
        return cuantoscontratos, cualescontratos;

}

function prueba(){
    //window.open('http://www.youtube.com','_blank');

    //window.open('http://localhost:8080/plataforma/Desarrollo/desarr_recibo.php','_blank');
    // si window.open('http://localhost:8080/plataforma/Desarrollo/desarroll_cob_1.php?DatosRecibo=180820&IdDelegacion=3&IdPrograma=165&Folio=103','_blank');
    window.open('desarroll_cob_1.php?DatosRecibo=180820&IdDelegacion=3&IdPrograma=165&Folio=103','_blank');
   // document.location.href="
    
}

function registra(){    
    cuantosconpago();
    //console.log(cuantoscontratos);
    //console.log(cualescontratos); 
    var liquidar=document.getElementById('data_table').rows;
    var TipoPago=$("#TipoPago").val();
    var Referencia=$("#Referencia").val();
    var Concepto=$('#Concepto').val();
    var FechaPagoHis=$('#FechaPagoHis').val();
    var NumRec=$('#NumRec').val();
    var MontoPago=$('#MontoPago').val();
    var folio=$('#folioconv').text();
    
    if (NumRec!=''){
        FechaOperacion=FechaPagoHis;
        console.log('va a tomar la fecha historica'+ FechaPagoHis)
    }else{
        FechaOperacion=$('#FechaPago').val();
        console.log('va a tomar la de hoy'+ FechaPagoHis)
    }


    var promise = $.ajax({
                             url: 'desarroll_cob_2.php',
                                                 type: 'post',			
                                                 data: { folio:folio,
                                                         cuantoscontratos:cuantoscontratos,
                                                         cualescontratos:cualescontratos,
                                                         TipoPago:TipoPago,
                                                         Referencia:Referencia,
                                                         Concepto:Concepto,
                                                         FechaPagoHis:FechaPagoHis,
                                                         NumRec:NumRec,
                                                         MontoPago:MontoPago,
                                                         },
                             success: function(data){                                
                                
                              //console.log('regrese');
                              //console.log(data);
                              
                                datosdes = data.split(',');     
                                resp=datosdes[0];
                                numrecibo=datosdes[1];
                                console.log(resp);
                                console.log('numrecibo'+numrecibo);

                                if(datosdes[0].trim()=='TRUE'){                                         
                                    $("#mensajes").append("");
                                    $('#mensajes').html('Se registro pago global');
                                    document.getElementById("newrecibo").value=numrecibo;    
                                    
                                    for(var i=1; i<liquidar.length-1; i++) {
                                      
                                      var porpagar= document.getElementById("data_table").rows[i].cells[8].innerText ;
                                      var contrato= document.getElementById("data_table").rows[i].cells[1].innerText;  
                                                                  
                                          nombrecampo='pago'+contrato;                       
                                          var pago=$("#"+nombrecampo).val();                                              
                          
                                              if (parseFloat(pago)>0){
                                                  //console.log('si hay pago '+i); 
                                                  
                                                  $.ajax({
                                                       url: 'desarroll_cob_3.php',
                                                                           type: 'post',			
                                                                           data: { contrato:contrato,
                                                                                   pago:pago,                                                                                   
                                                                                   FechaOperacion:FechaOperacion,                                                                                    
                                                                                   numrecibo:numrecibo,  
                                                                                   TipoPago:TipoPago,
                                                                                   Referencia:Referencia,
                                                                                   Concepto:Concepto,                                                                              
                                                                                   folio:folio
                                                                                   },
                                                       success: function(data){ 
                                                        console.log('regrese del pago indiv');                                                          
                                                        console.log('que trajo data individual x1x2'+data);   

                                                         //regresa data
                                                            datoscont = data.split(',');     
                                                            respuesta=datoscont[0];
                                                            numcontratoi=datoscont[1];
                                                            console.log(respuesta);
                                                            console.log("NUMCONTRATO I"+numcontratoi);   

                                                        //if(datosdes[0].trim()=='TRUE'){                                                           
                                                        if(datoscont[0].trim()=='EXITO'){   
                                                            $("#mensajes").css('background-color', '#87CEEB')   
                                                            $("#mensajes").append();                                                            
                                                            $('#mensajes').html('Se registro pago CONTRATO:'+numcontratoi);
                                                            $('#ImprimeRecibo').show();                                    
                                                            console.log('entre a true individual');                                                          
                                                        }else{                                                            
                                                            console.log('entre al negativo individual');                                                            
                                                           $("#mensajes").css('background-color', '#F25F54')    
                                                            $("#mensajes").append();                                                   
                                                            $('#mensajes').html('Error al registrar el pago de contratos. Se canceló la operación');
                                                            console.log('entre a false individual');   
                                                            $('#ImprimeRecibo').hide();      

                                                        }
                                                       } 
                                                   });
                                              }   
                                     }  
                                     
                                    /** */

                                }else{
                                    console.log('no se registro pago global');
                                    $("#mensajes").append(data+"");
                                    $('#mensajes').html('ERROR: No se pudo registrar el pago global');
                                }

                             } ,                             
                                error: function (request, status, error) {
                                    console.log('error');
                                  
                                alert('Error al intentar guardar pago global');
                                }
                            } );       
       
}

function ImprimeRec(deleg,programa,folio){
    var recibo =  document.getElementById("newrecibo").value;
    //misma pagina correcto document.location.href="desarroll_cob_1.php?DatosRecibo="+recibo+"&IdDelegacion="+deleg+"&IdPrograma="+programa+"&Folio="+folio; 
    

   // window.open('desarroll_cob_1.php?DatosRecibo=180820&IdDelegacion=3&IdPrograma=165&Folio=103','_blank');
    window.open('desarroll_cob_1.php?DatosRecibo='+recibo+'&IdDelegacion='+deleg+'&IdPrograma='+programa+'&Folio='+folio,'_blank');
    //$('#ImprimeRecibo').hide();        
}

</script>
 <?php include ("./lib/body_footer.php"); ?>