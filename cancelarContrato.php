<?php
include ("lib/body_head.php");
?>
<script>


function myFunction() {
  var x = document.getElementById("beta_buscar_input").value;
    if(x.length<=3){     
        $("#info").css({'display':'none'});  
        $("#infoBeneficiario").css({'display':'none'});  
    }
}


$( document ).ready(function() {  
    $("#delegaciones").css("border-color", "#e8ecdf");
    $("#programa").css("border-color", "#e8ecdf");

    //alert($('input:radio[name=opciones]:checked').val());
    if(($('input:radio[name=opciones]:checked').val()=='1')){
        $("#infoOpciones").css({'display':'inline-block',});
        $("#devolucion").css({'display':'inline-block',});
        $("#MotivoCancelacion").css({'display':'inline-block',});
        $("#trasnferenciaFolio").css({'display':'none',});
        $("#divObservaciones").css({'display':'inline-block',});  
        $("#divLote").css({'display':'inline-block',});  
        $("#divBotonCancelar").css({'display':'inline-block',});      
       
        
	}else if(($('input:radio[name=opciones]:checked').val()=='2')){
        $("#infoOpciones").css({'display':'inline-block',});
        $("#devolucion").css({'display':'none',});
        $("#MotivoCancelacion").css({'display':'inline-block',});
        $("#trasnferenciaFolio").css({'display':'inline-block',});
        $("#divObservaciones").css({'display':'inline-block',});  
        $("#divLote").css({'display':'inline-block',});  
        $("#divBotonCancelar").css({'display':'none',});   
       

	}else if(($('input:radio[name=opciones]:checked').val()=='3')){
        $("#infoOpciones").css({'display':'inline-block',});
        $("#devolucion").css({'display':'none',});
        $("#MotivoCancelacion").css({'display':'none',});
        $("#trasnferenciaFolio").css({'display':'none',});
        $("#divObservaciones").css({'display':'inline-block',});  
        $("#divLote").css({'display':'inline-block',});
        $("#divBotonCancelar").css({'display':'inline-block',});    
    }
    else if (($('input:radio[name=opciones]:checked').val()=='4')){
        $("#devolucion").css({'display':'none',});
        $("#MotivoCancelacion").css({'display':'inline-block',});
        $("#trasnferenciaFolio").css({'display':'none',});
        $("#divObservaciones").css({'display':'inline-block',});  
        $("#divLote").css({'display':'inline-block',});  
        $("#divBotonCancelar").css({'display':'inline-block',});    
 
	}
});




 
</script>

<?php
    
$id_aplicacion ="ap114"; 
$nivel = aplicacion_nivel($id_aplicacion, $nitavu);

$iddelegacion ='';
$idprograma = '';
$folio = '';
$numcontrato = '';
$Idlote='';
if (sanpedro($id_aplicacion, $nitavu)==TRUE){
    echo "<div id='AppDetalle'>".app_detalle($id_aplicacion, $nitavu)."</div>";        
    xd_update($id_aplicacion,$nitavu); historia($nitavu, $id_aplicacion." | Entro a cancelar contrato");
    echo "<br><br>";

    echo "<input type='hidden' name='nitavu' id='nitavu' value='".$nitavu."'>";


    if(isset($_GET['reactivar'])){
       // echo 'reactivacion';
    }
    

    /******************BUSCAR CONTRATO A CANCELAR************************************************/
    echo "<div id='BuscarUnTramite' style=' padding: 6px; background-color: #eeece6;
    margin-top: 20px; margin-left: 0px; border-radius: 5px; border: 1px solid #f0e1c5; margin-right: -10px; '>";
    echo '<div id="beta_buscar" style=" ">';
    echo '<form action="" method="get">'; 
        echo '<input type="hidden" name="" id="brig" value="">';
        echo '<table broder="1" width="100%"><tr>';
        if(isset($_GET['q']))
        {
            echo '<td> <input required="required" type="text" id="beta_buscar_input" name="q" placeholder="Buscar Contrato (Número de Contrato)"  onkeyup="myFunction()" value="'.$_GET['q'].'"/></td>';
        }else{
            echo '<td> <input required="required" type="text" id="beta_buscar_input" name="q" placeholder="Buscar Contrato (Número de Contrato)"  onkeyup="myFunction()" /></td>';
        }
            
            echo '<td align="right" width="15px">                    
            <button id="beta_buscar_boton">
            <img  src="icon/buscar.png"></button>
            </td>';
        echo '</tr></table>';
    echo '</form>';
    echo '</div>';
    echo '</div>';

    echo "<div id='respuesta' name='respuesta'></div>";

    
    echo '<center>';
    if (isset($_GET['q']))
    {
        $busqueda = $_GET['q'];
        if (ValidaVAR($busqueda)==TRUE)
        {
            $busqueda = LimpiarVAR($busqueda);
        }
        else
        {
            $busqueda = "";
        }

        if(strlen ($busqueda>6))
        {
             
            $sql="  SELECT    contratos.IdDelegacion, contratos.IdPrograma, contratos.Cancelado, controlcontratos.EstatusCuenta, contratos.Folio,contratos.NumContrato
                FROM         contratos INNER JOIN      controlcontratos ON contratos.NumContrato = controlcontratos.NumContrato
                WHERE     contratos.NumContrato ='".$busqueda."'";

                //echo $sql;
               
                $r = $Vivienda -> query($sql);
               
                if ($r -> num_rows >0){
                    while($f = $r -> fetch_array()){
                        $idprograma=$f['IdPrograma'];
                        $iddelegacion=$f['IdDelegacion'];
                        $folio=$f['Folio'];
                        $numcontrato= $f['NumContrato'];
                        $contratocancelado=ContratoCancelado($numcontrato, $iddelegacion, $iddelegacion);
                    
                        if(solicitudCancelada($idprograma, $iddelegacion, $folio)==1 AND ($numcontrato=='' and ($contratocancelado=='' OR $contratocancelado==0))){
                           mensaje('La solicitud de este contrato esta cancelada.','cancelarContrato.php');
                        }else{

                           
                            $Pagos = Pagos($numcontrato);

                            $tipoPrograma = tipoTramitePrograma($idprograma);
                            if($tipoPrograma==2)
                            {
                                $Idlote = numContratoLote($numcontrato);

                            if($Idlote =="")
                            {
                                $Idlote=IdLoteNumContrato($numcontrato);
                            }
                          }
                        
                            echo '<div id="infoBeneficiario">';
                            datosBeneficiarioenFormatoCorto( $idprograma, $iddelegacion, $folio,  $numcontrato);
                            echo '</div>';
                            //echo 'estatus cuenta.'.$f['EstatusCuenta'];
                           
                            if(($f['Cancelado'] == 0 Or $f['Cancelado'] ==False or $f['Cancelado']=='')  And $f['EstatusCuenta'] <> 6 ){
                                $numescritura=ObtenerNumEscrituraConContrato($numcontrato);
                                //echo '<br>escritura '.$numescritura;
                                //echo '<br>existe '. ExisteTramiteEscritura($numescritura);
                                if($numescritura=='FALSE' ||  ExisteTramiteEscritura($numescritura)=='Cancelado'){
                                                                
                                    echo '<div class="container" id="info">';
                                    echo "<label>Seleccione una opción</label><br>";
                                //  echo '<form action="cancelarContrato.php" method="POST">';
                                        echo "<input type='hidden' name='numcontrato' id='numcontrato' value='".$numcontrato."'>";
                                        echo "<input type='hidden' name='idprograma' id='idprograma' value='".$idprograma."'>";
                                        echo "<input type='hidden' name='iddelegacion' id='iddelegacion' value='".$iddelegacion."'>";
                                        echo "<input type='hidden' name='folio' id='folio' value='".$folio."'>";
                                        $Pagos = Pagos($numcontrato);
                                        
                                        if($Pagos>0)
                                        {
                                        echo '<label class="radio-inline">';
                                        echo '<input type="radio" name="opciones" value="1">Devolución    ';
                                        echo '</label>';
                                        echo '<label class="radio-inline">';
                                        echo '<input type="radio" name="opciones" value="2">Transferencia a Folio     ';
                                        echo '</label>';
                                        echo '<label class="radio-inline">';
                                        echo '<input type="radio" name="opciones" value="3">Defunción     ';
                                        echo '</label>';
                                        echo '<label class="radio-inline">';
                                        echo '<input type="radio" name="opciones" value="4">Instruccion     ';
                                        echo '</label>';
                                        }else {
                                            echo '<label class="radio-inline">';
                                        echo '<input type="radio" name="opciones" value="4">Cancelación ';
                                        echo '</label>';                                   
                                        echo '<label class="radio-inline">';
                                        echo '<input type="radio" name="opciones" value="3">Defunción     ';
                                        echo '</label>'; 
                                        }

                                        echo '<div class="container" id="infoOpciones"  style="display:none;">';
                                        //POR DEVOLUCION
                                        echo "<div id='devolucion' name='devolucion' style='width:100%; display: none;'>";
                                            echo '<div class="card" style="text-align: justify; width:100%;">
                                                    <h1 class="card-header h5" style="text-transform: uppercase;font-size: 10pt;" >Cancelación por devolución</h1>';
                                                    echo '<div class="card-body" style="width:100%;">'; 
                                                    
                                                            echo "<label>Folio del cheque</label>";
                                                            echo "<input id='folioCheque' name='folioCheque'>";
                                                            echo "<table style='width:100%;'><tr><td style='text-align: center; width:65%;'>";
                                                            echo "<label>Fecha de emisión del cheque</label>";
                                                            echo "<input type='date' id='fechaCheque' name='fechaCheque' value='".date("Y-m-d")."'>";
                                                            echo "</td><td style='text-align: center; width:35%;'>";
                                                            echo '<input class="form-check-input" type="checkbox" id="gridCheck" name="gridCheck" style="margin-top: 12px" onclick= "HabilitarCampoCargo();" >';
                                                            echo '<label class="form-check-label" for="gridCheck">
                                                            Aplica Cargo Administrativo
                                                            </label>';
                        
                                                            echo "<input id='cargoAdmin' name='cargoAdmin' disabled type='number' step='any'>";
                                                            echo "</td></tr>";
                                                            echo "</table>";          
                                                    echo '</div>';
                                            echo '</div>';
                                        echo '</div>';  
                                        echo '<br>'; 
                                        echo '<br>';                                   
                                        //POR TRANSFERENCIA A FOLIO
                                        echo "<div id='trasnferenciaFolio' name='trasnferenciaFolio' style='width:100%; display:none;'>";
                                            echo '<div class="card" style="text-align: justify; width:100%;">
                                                    <h1 class="card-header h5" style="text-transform: uppercase;font-size: 10pt;" >Cancelación con transferencia a un folio nuevo</h1>';
                                                    echo '<div class="card-body" style="width:100%;">'; 
                                                        echo "<center><table style='width:100%;'><tr><td style='width:20%;'>";
                                                        echo "<center><label for='delegaciones'>Seleccione una delegación:";
                                                        echo "<select name='delegaciones' id='delegaciones'>";
                                                            $sql = "SELECT * FROM delegaciones where Tipo = 0 ORDER by Delegacion ASC";
                                                            echo "<option value=''>Seleccione una opción</option>";
                                                            $r = $Vivienda -> query($sql);
                                                            while($f = $r -> fetch_array())
                                                            { // resultado de la busqueda.................
                                                                echo "<option value='".$f['IdDelegacion']."'>".$f['Delegacion']. "</option>";
                                                            }
                                                        echo "</select></center>";
                                                        echo "</td>";
                                                        echo "<td style='width:50%;'>";
                                                        echo "<center><label for='programa'>Seleccione un programa:";
                                                        echo "<select name='programa' id='programa'>";
                                                        echo "<option value=''>Seleccione una opción</option>";
                                                        //id='programas'
                                                        $sql = "SELECT * FROM programa WHERE Activo=1 ORDER by Programa ASC";
                                                            $r = $Vivienda -> query($sql);
                                                            while($f = $r -> fetch_array())
                                                            { // resultado de la busqueda.................
                                                                echo "<option value='".$f['IdPrograma']."'>".$f['Programa']. "</option>";
                                                            }
                                                    
                                                        echo "</select></center>";
                                                        echo "</td>";
                                                        echo "<td style='width:20%;'>";
                                                        echo "<center><label for='_folio'>Folio";
                                                        echo "<input id='_folio' name='_folio' value=''   placeholder='Folio del solicitante'>";
                                                        echo "</center></td></tr></table>";
                                                        echo "<table style='width:100%;'><tr><td style='text-align: center; width:65%;'>";
                                                        echo "<label id='etiquetaNombre'>Nombre del beneficiario</label><br>";
                                                        echo "<b><label  id='beneficiario1' name='beneficiario1'></label></b>";
                                                        echo "</td><td style='text-align: center; width:35%;'>";
                                                        echo '<input class="form-check-input" type="checkbox" id="gridCheckT" name="gridCheckT" style="margin-top: 12px;" onclick= "HabilitarCampoCargo();">';
                                                        echo '<label class="form-check-label" for="gridCheckT" id="lblgridCheckT"> Aplica Cargo Administrativo</label>';
                                                        echo "<input id='cargoAdminT' name='cargoAdminT' type='number' disabled>";
                                                        echo "</td></tr>";
                                                        echo "</table>";          
                                                    echo '</div>';
                                            echo '</div>';
                                        echo '</div>'; 
                                        
                                        
                                        if(tipoTramitePrograma($idprograma)==2)
                                        {
                                        //DATOS DEL LOTE
                                        echo "<div style='width:100%;' id='divLote'>";
                                        echo '<div class="card" style="text-align: justify; width:100%;">
                                                <h1 class="card-header h5" style="text-transform: uppercase;font-size: 10pt;" >Datos del lote</h1>';
                                                echo '<div class="card-body" style="width:100%;">'; 
                                                    echo MuestraUbicacionLote($Idlote,'width: 90%;font-size: 10pt;');
                                                echo '</div>';
                                                echo '<div class="md-form" style="width:100%;">';                                                  
                                            echo '</div>';
                                        echo '</div>';
                                        echo '</div>';  
                                    }
                                        else
                                    {
                                        
                                            //DATOS DEL VALE
                                        echo "<div style='width:100%;' id='divVale'>";
                                        echo '<div class="card" style="text-align: justify; width:100%;">
                                                <h1 class="card-header h5" style="text-transform: uppercase;font-size: 10pt;" >DATOS DEL VALE</h1>';
                                                echo '<div class="card-body" style="width:100%;">'; 
                                            
                                                $sqlx=" SELECT ministracioncredito.NumContrato,
                                                ministracioncredito.NumMinistracion, ministracioncredito.Cancelado, ministracioncredito.Folio, 
                                                ministracioncredito.IdCasaComercial, ministracioncredito.FechaImpProv, facturasministracion.FechaFactura,
                                                facturasministracion.NoFactura, 
                                                facturasministracion.NumCheque FROM ministracioncredito LEFT OUTER JOIN 
                                                facturasministracion ON ministracioncredito.NumContrato = facturasministracion.NumContrato AND 
                                                ministracioncredito.NumMinistracion = facturasministracion.NumMinistracion 
                                                WHERE (ministracioncredito.NumContrato = '" .$numcontrato. "')";

                                                //echo $sqlx;
                                                $rc= $Vivienda -> query($sqlx);
                                                $row_cnt = $rc->num_rows;                                           
                                                if($row_cnt>0)
                                                {			 
                                                echo "<center>";
                                                echo"<table class='bordered'>";
                                                echo"<thead>
                                                <tr>                                                   
                                                    <th>NumContrato</th>
                                                    <th>NumMinistracion</th>
                                                    <th>Cancelado</th>
                                                    <th>Folio</th>
                                                    <th>IdCasaComercial</th>
                                                    <th>FechaImpProv</th>
                                                    <th>FechaFactura</th>
                                                    <th>NoFactura</th>
                                                    <th>NumCheque</th>
                                                </tr>";
                                                echo" </thead>
                                                        <tbody>";
                                                while($cat = $rc -> fetch_array())
                                                    { // resultado de la busqueda.................
                                                        echo" <tr>";
                                                        echo "<td >".$cat['NumContrato']."</td>";	
                                                        echo "<td >".$cat['NumMinistracion']."</td>";	
                                                        echo "<td >".$cat['Cancelado']."</td>";	
                                                        echo "<td >".$cat['Folio']."</td>";
                                                        echo "<td >".$cat['IdCasaComercial']."</td>";   
                                                        if($cat['FechaImpProv']!='')
                                                        {                                   
                
                                                        echo "<td class='centrar'>".date_format( date_create($cat['FechaImpProv']), 'd/m/Y  H:i:s')."</td>";
                                                        }
                                                        else{
                                                            echo "<td class='centrar'>".$cat['FechaImpProv']."</td>";
                                                        }
                                                        if($cat['FechaFactura']!='')
                                                        {                                            
                                                        echo "<td class='centrar'>fecha".$cat['FechaFactura']."-".date_format( date_create($cat['FechaFactura']), 'd/m/Y')."</td>";
                                                        }else{
                                                            echo "<td class='centrar'>".$cat['FechaFactura']."</td>";
                                                        }		
                                                        echo "<td >".$cat['NoFactura']."</td>";	
                                                        echo "<td >".$cat['NumCheque']."</td>";							
                                                        echo" </tr>";

                                                        }
                                                    
                                                    
                                                        echo "</tbody></table>";
                                                        echo"</center>";
                                                                    
                                                    }
                                            
                                            
                                                
                                            
                                                echo '</div>';                                        
                                        echo '</div>';
                                        echo '</div>';  
                                    }

                                    echo '<br>';  
                                    echo '<br>';  
                                        //OBSERVACIONES
                                        echo "<div style='width:100%;' id='divObservaciones'>";
                                            echo '<div class="card" style="text-align: justify; width:100%;">
                                                    <h1 class="card-header h5" style="text-transform: uppercase;font-size: 10pt;" >Observaciones</h1>';
                                                    echo '<div class="card-body" style="width:100%;">'; 
                                                    
                                                
                                                        echo '<label for="observaciones">Observaciones</label>';
                                                        echo '<input required="required"  id="observaciones" name="observaciones">';
                                                        $idarchivo=2;
                                                        echo InputSubirArchivo('Oficio de Autorización', $iddelegacion,$idprograma, $folio,$idarchivo,$id_aplicacion);
                                                    
                                                        if(tipoTramitePrograma($idprograma)==2)
                                                        {
                                                            
                                                            echo '<div class="well well-sm" style="width:100%;" id="MotivoCancelacion">';
                                                            echo "<center>";
                                                            echo '<label>Motivo de cancelación</label><br>';                                                
                                                            echo '<label class="radio-inline">';
                                                            echo '<input type="radio" id="MotCancelacion" name="MotCancelacion" value="0">Cancelación de Contrato   ';
                                                            echo '</label>';
                                                            echo '<label class="radio-inline">';
                                                            echo '<input type="radio" id="MotCancelacion" name="MotCancelacion" value="4">Mala condición del Predio    ';
                                                            echo '</label>';
                                                            echo '<label class="radio-inline">';
                                                            echo '<input type="radio" id="MotCancelacion" name="MotCancelacion" value="12">Eliminado del plano   ';
                                                            echo '</label>';
                                                            echo "</center>";                                           
                                                            echo '</div>';   
                                                        }  
                                                    
                                                        
                                                    echo '</div>';
                                            echo '</div>';
                                        echo '</div>';  

                                    
                                    
                                        echo '<div id="divBotonCancelar" style="display: none">';
                                        echo "<center> <button type='button' id='btnCancelar' name='btnCancelar' class='btn btn-info'  title='Cancelar Contrato' 
                                        onclick='cancelarContrato(\"".$numcontrato."\", ".$idprograma.", ".$iddelegacion.", ".$folio.");'>
                                        <table><tr><td valign='middle' align='center'>
                                        <img src='icon/page.png'> 
                                        </td>
                                        <td valign='middle' align='center' style='color:white;'>
                                        Cancelar Contrato                                        
                                        </td></tr></table>  </button></center>"; 
                                        echo '</div>';
                                    

                                    echo '</div>';
                                // echo '</form>';
                                    echo '</div>';
                                    
                                }
                                else 
                                {
                                    mensaje( "Imposible continuar con la cancelación,  el contrato tiene un trámite de escritura activo. Para continuar es necesario cancelar primero el trámite de esritura.",'cancelarContrato.php');
                                    
                                }
                    
//
                            }else if(($f['Cancelado'] == 1 Or $f['Cancelado'] == True or $f['Cancelado']=='') and isset($_GET['reactivar'])){
                               echo "<br><br>";
                                echo "<center><div style='width:80%;' id='divObservaciones'>";
                                    echo '<div class="card" style="text-align: justify; width:100%;">
                                            <h1 class="card-header h5" style="text-transform: uppercase;font-size: 10pt;" >Observaciones</h1>';
                                            echo '<div class="card-body" style="width:100%;">'; 
                                                echo '<label for="observaciones">Observaciones (*Favor de incluir número de oficio*):</label>';
                                                echo '<input required="required"  id="observaciones" name="observaciones">';
                                                //tipo archivo de reactivacion de contrato - cat_archivos
                                                $idarchivo=3;
                                                echo InputSubirArchivo('Oficio de Autorización', $iddelegacion, $idprograma, $folio, $idarchivo,$id_aplicacion);
                                            echo '</div>';
                                    echo '</div>';
                                echo '</div></center>'; 
                                
                                echo '<div id="divBotonCancelar">';
                                    echo "<center> <button type='button' id='btnReactivar' name='btnReactivar' class='btn btn-info'  title='Cancelar Contrato' 
                                    onclick='reactivarContrato(\"".$numcontrato."\", ".$idprograma.", ".$iddelegacion.", ".$folio.");'>
                                    <table><tr><td valign='middle' align='center'>
                                    <img src='icon/page.png'> 
                                    </td>
                                    <td valign='middle' align='center' style='color:white;'>
                                   Reactivar Contrato
                                    
                                    </td></tr></table>  </button></center> 
                                    "; 
                                echo '</div>';
                            
                            }else{
                                echo '<div id="modal_oscuro">';
                                    echo '<div id="mensaje">';
                                    echo '<p>Imposible continuar el contrato elegido está cancelado</p>';
                                        echo "<center><table><td>";
                                            echo '<a class="Mbtn btn-default" href="cancelarContrato.php">Aceptar</a>';
                                        echo "</td><td>";
                                            echo '<a class="Mbtn btn-cancel" href="cancelarContrato.php?q='.$numcontrato.'&reactivar=1">Reactivar</a>';
                                        echo "</td></table></center>";
                                    echo '</div>';
                                echo '</div>';
                                //mensaje( "Imposible continuar el contrato elegido está cancelado.",'cancelarContrato.php');
                            }
                        
                        /* }else{
                            mensaje( "Imposible continuar el contrato elegido no tiene pagos para devolver o hacer transferencia.",'cancelarContrato.php');

                        } */
                        }
                    }
                }else{
                    mensaje( "No se localizó el contrato ,Verifique el número de contrato.",'cancelarContrato.php');
                }
        

        //TablaDinamica_MySQLVivienda("",$sql, "tramitesBusquedaTabla", "tramitesBusquedaTablaid", "", 2); //0 = Basica, 1 = ScrollVertical, 2 = Scroll Horizontal
        }else
        {
            mensaje("El número de caracteres que introdujo en la búsqueda es muy poco, favor de ser más específico.",'cancelarContrato.php');
        }
    }

    echo '</center>';   
}else{
    mensaje("ERROR: no tienes acceso a este modulo","");
}

  


?>
<script>

function reactivarContrato(numcontrato, idprograma, iddelegacion, folio){
    document.getElementById('btnReactivar').disabled=true;
    

    var observaciones = $("#observaciones").val();//document.getElementById('observaciones').value;
    var nitavu = $("#nitavu").val(); 
    $("#preloader").css({'display':'inline-block'});
    
    $.ajax({
        url: "reactivaContrato.php",
        type: "post",
        data: {numcontrato: numcontrato, idprograma: idprograma, iddelegacion: iddelegacion, folio: folio, observaciones:observaciones, nitavu:nitavu},
        success: function(data){
             console.log(data);
            $("#preloader").css({'display':'none'});
            $('#respuesta').append(data);
            NPush(data,'Plataforma ITAVU');

        }
   });
}

function HabilitarCampoCargo(){
    document.getElementById('cargoAdmin').value="";
    document.getElementById('cargoAdminT').value="";
    
    if($("#gridCheck").is(":checked")) {  
        document.getElementById('cargoAdmin').disabled = false; 
    }
    else{
        document.getElementById('cargoAdmin').disabled = true; 
    }

    if($("#gridCheckT").is(":checked")) { 
        document.getElementById('cargoAdminT').disabled = false;
    }
    else{    
        document.getElementById('cargoAdminT').disabled = true;
    }

}

function limpiarDatos()
{
$("#beneficiario1").html("");                                                
$('#cargoAdminT').prop('checked',false);
$('#cargoAdmin').prop('checked',false);
$("#cargoAdminT").val(""); 
$("#observaciones").val("");   
$("#folioCheque").val(""); 
$("#fechaCheque").val(""); 
$("#cargoAdmin").val(""); 
$("#delegaciones").val('');
$("#programa").val('');  
$("#_folio").val("");                  
}

$("input[name=opciones]").change(function () {	   
    limpiarDatos();   


    $("#infoOpciones").css({'display':'inline-block',});

    //alert($('input:radio[name=opciones]:checked').val());
    if(($('input:radio[name=opciones]:checked').val()=='1')){
        $("#devolucion").css({'display':'inline-block',});
        $("#MotivoCancelacion").css({'display':'inline-block',});
        $("#trasnferenciaFolio").css({'display':'none',});
        $("#divObservaciones").css({'display':'inline-block',});  
        $("#divLote").css({'display':'inline-block',});  
        $("#divBotonCancelar").css({'display':'inline-block',});      
        
        
	}else if(($('input:radio[name=opciones]:checked').val()=='2')){
        $("#devolucion").css({'display':'none',});
        $("#MotivoCancelacion").css({'display':'inline-block',});
        $("#trasnferenciaFolio").css({'display':'inline-block',});
        $("#divObservaciones").css({'display':'inline-block',});  
        $("#divLote").css({'display':'inline-block',});  
        $("#divBotonCancelar").css({'display':'none',});   
       

	}else if(($('input:radio[name=opciones]:checked').val()=='3')){
        $("#devolucion").css({'display':'none',});
        $("#MotivoCancelacion").css({'display':'none',});
        $("#trasnferenciaFolio").css({'display':'none',});
        $("#divObservaciones").css({'display':'inline-block',});  
        $("#divLote").css({'display':'inline-block',});
        $("#divBotonCancelar").css({'display':'inline-block',});    
    }
    else if (($('input:radio[name=opciones]:checked').val()=='4')){
        $("#devolucion").css({'display':'none',});
        $("#MotivoCancelacion").css({'display':'inline-block',});
        $("#trasnferenciaFolio").css({'display':'none',});
        $("#divObservaciones").css({'display':'inline-block',});  
        $("#divLote").css({'display':'inline-block',});  
        $("#divBotonCancelar").css({'display':'inline-block',});      
        
        
	}
   
});

    
$("#_folio").keypress(function(event){     
    var keycode = (event.keyCode ? event.keyCode : event.which);      
    if(keycode == '13'){  
        event.preventDefault();
        if($("#_folio").val().length>=1){   
            var iddel =   $('#delegaciones').val();  
            var idprograma = $('#programa').val();  
            var folio=$('#_folio').val();  
                BuscarFolio(iddel,idprograma,folio);    
            }else{
            NPush('Ingrese un Folio valido.','Plataforma ITAVU');
            // $("#btnCancelar").css({'display':'none',});
        }
    }   
});

		


$( "select" )
  .change(function () {
    var str = "";    
    if($("#delegaciones").val()!='')
    {
        $("#delegaciones").css("border-color", "#e8ecdf");

    }
    if($("#programa").val()!='')
    {
        $("#programa").css("border-color", "#e8ecdf");

    }    
  
  })
  .change();



  

function ValidarCamposFolio(iddel,idprograma,folio)
{
    valida =true;;
    
    if( (iddel == "0" ) || (iddel==""))  {
      $("#delegaciones").css("border-color", "red");
      valida= false;
    
   }else
   {
    $("#delegaciones").css("border-color", "#e8ecdf");
    
   }

   if( (idprograma == "0" ) || (idprograma==""))  {
      $("#programa").css("border-color", "red");
      valida= false;
   }
 

   if( (folio == "0" ) || (folio==""))  {
    $("#_folio").css("border-color", "red");
      valida= false;
   }
  
  
    return valida;
}

function BuscarFolio(iddel,idprograma,folio)
{

    if(ValidarCamposFolio(iddel,idprograma,folio)==false)
    {
        NPush('Faltan algunos campos por llenar','Plataforma ITAVU');
       // $("#btnCancelar").css({'display':'none',});
    }
    else{    
        $.ajax({
        url: "gcontrato_db.php",
        type: "POST",        
        data: {IdDelegacion:iddel, IdPrograma:idprograma,Folio:folio},
            success: function(data){                                                                 
                if(data.includes('localizó')==true)
                { 
                    $("#etiquetaNombre").css({'display':'none',});
                    $("#beneficiario1").html(data+"\n");                         
                    $("#gridCheckT").css({'display':'none',}); 
                    $("#lblgridCheckT").css({'display':'none',}); 
                    $("#cargoAdminT").css({'display':'none',}); 
                    $("#btnCancelar").css({'display':'none',});
                    $("#divObservaciones").css({'display':'none',});  
                    $("#divLote").css({'display':'none',});  
                    $("#divCredito").css({'display':'none',});    
                    $("#divBotonCancelar").css({'display':'none',});                       
                    
                }
                else if(data.includes('devolución')==true)
                {
                    $("#etiquetaNombre").css({'display':'none',});
                    $("#beneficiario1").html(data+"\n");                         
                    $("#gridCheckT").css({'display':'none',}); 
                    $("#lblgridCheckT").css({'display':'none',}); 
                    $("#cargoAdminT").css({'display':'none',}); 
                    $("#btnCancelar").css({'display':'none',});
                    $("#divObservaciones").css({'display':'none',});  
                    $("#divLote").css({'display':'none',}); 
                    $("#divCredito").css({'display':'none',});    
                    $("#divBotonCancelar").css({'display':'none',});                        
                    
                }
                else if(data.includes('contrato')==true)
                {
                    $("#etiquetaNombre").css({'display':'none',});
                    $("#beneficiario1").html(data+"\n");                         
                    $("#gridCheckT").css({'display':'none',}); 
                    $("#lblgridCheckT").css({'display':'none',}); 
                    $("#cargoAdminT").css({'display':'none',}); 
                    $("#btnCancelar").css({'display':'none',});
                    $("#divObservaciones").css({'display':'none',});  
                    $("#divLote").css({'display':'none',}); 
                    $("#divCredito").css({'display':'none',});    
                    $("#divBotonCancelar").css({'display':'none',});                        
                    
                }
                else
                {
                    $("#etiquetaNombre").css({'display':'inline-block',});
                    $("#beneficiario1").html(data+"\n");  
                    $("#gridCheckT").css({'display':'inline-block',}); 
                    $("#lblgridCheckT").css({'display':'inline-block',}); 
                    $("#cargoAdminT").css({'display':'inline-block',}); 
                    $("#btnCancelar").css({'display':'inline-block',});
                    $("#divObservaciones").css({'display':'inline-block',});  
                    $("#divLote").css({'display':'inline-block',});
                    $("#divCredito").css({'display':'inline-block',});                                
                    $("#divBotonCancelar").css({'display':'inline-block',}); 
                    

                }

            }
      }); 
    }
}

  
function cancelarContrato(numcontrato, idprograma, iddelegacion, folio){

    //alert(numcontrato);
    //$('#btnCancelar').disable = true;
    document.getElementById('btnCancelar').disabled=true;
    //var numcontrato = document.getElementById('numcontrato').value;
    var idlote = $("#idlote").val(); //document.getElementById('idlote').value;
    var cancelacion =$('input:radio[name=MotCancelacion]:checked').val();//document.getElementById('cancelacion').value;
    var opciones = $('input:radio[name=opciones]:checked').val();//document.getElementById('opciones').value;
    var folioCheque = $("#folioCheque").val();//document.getElementById('folioCheque').value;
    var fechaCheque = $("#fechaCheque").val();//document.getElementById('fechaCheque').value;
    var gridCheck=0; //= $("#gridCheck").val();//document.getElementById('gridCheck').value;
    var cargoAdmin=0;//= $("#cargoAdmin").val();//document.getElementById('cargoAdmin').value;
    // var iddelegacion = document.getElementById('iddelegacion').value;
    //var idprograma = document.getElementById('idprograma').value;
    //var folio = document.getElementById('folio').value;
    var delegaciones = $("#delegaciones").val();//document.getElementById('delegaciones').value;
    var programa = $("#programa").val();//document.getElementById('programa').value;
    var _folio = $("#_folio").val();//document.getElementById('_folio').value;
    var observaciones = $("#observaciones").val();//document.getElementById('observaciones').value;
    var cargoAdminT=0;// = $("#cargoAdminT").val();//document.getElementById('cargoAdminT').value;
    var gridCheckT=0;;// = $("#gridCheckT").val();//document.getElementById('gridCheckT').value;
    var nitavu = $("#nitavu").val(); 

    if($("#gridCheck").is(":checked")) {  
        gridCheck=1;
        cargoAdmin = $("#cargoAdmin").val();
    }
    else{
        gridCheck=0;
        cargoAdmin=0;
    }

    if($("#gridCheckT").is(":checked")) { 
        gridCheckT=1;
        cargoAdminT = $("#cargoAdminT").val();
    }
    else{    
        gridCheckT=0;
        cargoAdminT = 0;
    }

   

    $("#preloader").css({'display':'inline-block'});
    
    $.ajax({
        url: "cancelaContrato.php",
        type: "post",
        data: {numcontrato: numcontrato, idlote: idlote, cancelacion: cancelacion, opciones:opciones, folioCheque:folioCheque, fechaCheque:fechaCheque, gridCheck: gridCheck, cargoAdmin:cargoAdmin, iddelegacion:iddelegacion, idprograma:idprograma, folio:folio, delegaciones:delegaciones, programa:programa, _folio: _folio, observaciones:observaciones, cargoAdminT:cargoAdminT, gridCheckT:gridCheckT, nitavu:nitavu},
        success: function(data){
            console.log(data);
            $("#preloader").css({'display':'none'});
            $('#respuesta').append(data);
            NPush(data,'Plataforma ITAVU');

        }
        
    });

}


</script>
<?php include ("lib/body_footer.php"); ?>