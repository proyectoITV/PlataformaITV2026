<?php
include ("lib/body_head.php");
require("plantilla-core.php");
?>
<script>

// VERIFICAMOS AL CARGAR LA PAGINA SI EXISTE UN IDLOTE EN LA URL. PARA ASI MOSTRAR LOS DATOS DEL LOTE YA CARGADOS. 
$( document ).ready(function() {    
    
    idlote = obtenerValorParametro('idlote');  
     
    if (idlote!='' &&  idlote!=null &&  idlote!='0')
    { mostrarDatosCreditoPorIdlote(idlote); 
       
    }	
});


$(document).on("change", "#municipio", function(event) {
     mostrarColonias($("#municipio option:selected").val());
});  


// FUNCION QUE MUESTRA A LAS COLONIAS A PARTIR DEL MUNICIPIO QUE SE SELECCIONÓ
function mostrarColonias(municipio){
      
    $.ajax({
        url: "cont_colonias.php",
        type: "get",
        data: {municipio: municipio},
        success: function(data){
            $('#colonia').html(data+"\n");
        }
    });

               
}

// FUNCION QUE MUESTRA LA INFORMACIÓN DEL CREDITO EN BASE AL IDLOTE QUE ESTA EN LA URL
function mostrarDatosCreditoPorIdlote(idlote)
{ 
   
    $("#preloader").css({'display':'inline-block'});
    //alert("entrar");
    var idmunicipio = "";
    var idcolonia = "";
    var seccion = "";
    var fila = "";
    var manzana= "";    
    var lote="";

    del = obtenerValorParametro("delegaciones");
    programa = obtenerValorParametro("programa");
    folio = obtenerValorParametro("_folio");
    nombeneficiario = document.getElementById('nombeneficiario').value;
    $.ajax({
        url: "credito.php",
        type: "post",
        data: {IdMunicipio: idmunicipio, IdColonia: idcolonia, Seccion:seccion,Fila:fila,Manzana:manzana,Lote:lote ,Idlote:idlote,Del:del, Programa:programa, Folio:folio, nitavu: <?php echo $nitavu; ?>, nombeneficiario: nombeneficiario},
        success: function(data){        
          
            $("#divCredito").html(data+"\n");  
            $("#preloader").css({'display':'none'});
        }
    });
}




// // FUNCION QUE MUESTRA LA INFORMACIÓN DEL CREDITO EN BASE AL IDLOTE QUE ESTA EN LA URL
// function mostrarDatosCreditoPorIdlote()
// {
//     //alert('entrar');
//     var idmunicipio = ''
//     var idcolonia = '';
//     var seccion = '' ;
//     var fila = ''; 
//     var manzana= '';    
//     var lote='';
//     idlote = obtenerValorParametro('idlote');
//     del = obtenerValorParametro('delegaciones');
//     programa = obtenerValorParametro('programa');
//     folio = obtenerValorParametro('_folio');
//     nombeneficiario = document.getElementById('nombeneficiario').value;
//     $.ajax({
//             url: "credito.php",
//             type: "post",
//             data: {IdMunicipio: idmunicipio, IdColonia: idcolonia, Seccion:seccion,Fila:fila,Manzana:manzana,Lote:lote ,Idlote:idlote,Del:del, Programa:programa, Folio:folio, nitavu: <?php echo $nitavu; ?>, nombeneficiario: nombeneficiario},
//             success: function(data){        
           
//              $('#divCredito').html(data+"\n");  
                
//             }
//         });
//  }
      
// FUNCION QUE MUESTRA LA INFORMACIÓN DEL CREDITO CUANDO SE INTRODUCEN LOS DATOS DE LOTE
function habilitarinputs(){
                                
    $("#folioLote").prop("disabled", false);
    $("#aprobar").prop("disabled", false);
    

}

function mostrarDatosCredito()
{ 
    $("#preloader").css({'display':'inline-block'});
    var idmunicipio =   document.getElementById("municipio").value;
    var idcolonia =   document.getElementById("colonia").value;
    var seccion = document.getElementById('seccion').value; ;
    var fila =  document.getElementById('fila').value; 
    var manzana=  document.getElementById('manzana').value;    
    var lote= document.getElementById('lote').value;
      
    del = obtenerValorParametro('delegaciones');
    programa = obtenerValorParametro('programa');
    folio = obtenerValorParametro('_folio');
    nombeneficiario = document.getElementById('nombeneficiario').value;

$.ajax({
        url: "credito.php",
        type: "post",
        data: {IdMunicipio: idmunicipio, IdColonia: idcolonia, Seccion:seccion,Fila:fila,Manzana:manzana,Lote:lote,Del:del, Programa:programa, Folio:folio, nitavu: <?php echo $nitavu; ?>, nombeneficiario: nombeneficiario},
        success: function(data){          
           
            $('#divCredito').html(data+"\n");  
            $("#preloader").css({'display':'none'});
        }
    });
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

</script>


<?php
    
$id_aplicacion ="ap113"; 
$nivel = aplicacion_nivel($id_aplicacion, $nitavu);

if (sanpedro($id_aplicacion, $nitavu)==TRUE){
    echo "<div id='AppDetalle'>".app_detalle($id_aplicacion, $nitavu)."</div>";        
    xd_update($id_aplicacion,$nitavu); historia($nitavu, $id_aplicacion." | Entro a contratación");
    echo "<br><br>";


if(isset($_GET['delegaciones']) and isset($_GET['programa']) and isset($_GET['_folio']) ){
        $IdDelegacion = $_GET['delegaciones'];
        $IdPrograma = $_GET['programa'];
        $Folio = $_GET['_folio'];
        $tipoPrograma = tipoTramitePrograma($IdPrograma);
        if($tipoPrograma!=2)
        {
            echo '<script type="text/javascript">
            window.location.assign("ContratarCredito.php?delegaciones='.$IdDelegacion.'&programa='.$IdPrograma.'&_folio='.$Folio.'");
            </script>';
        }
        echo '<script type="text/javascript">
      console.log("entro");
        </script>';   
          
        $NumContrato = buscarSiYaTieneContratoActivoOno($IdDelegacion, $IdPrograma, $Folio);

        $contratocancelado=ContratoCancelado($NumContrato, $IdDelegacion, $IdDelegacion);

        $Idlote='';
        //IDENTIFICAMOS SI EXTISTE UN IDLOTE ASIGNADO
        if(isset($_GET['idlote']) )        
        {  $Idlote = $_GET['idlote']; }

        if($NumContrato <>'' ){
            $Idlote = numContratoLote($NumContrato);
            echo "<input type='hidden' name='idlote' id='idlote' value=".$Idlote.">";
        } 
            
       /***CODIGO QUE SIRVE PARA IDENTIFICAR QUE BOTON PRESIONO Y QUE DOCUEMNTO DEBE MOSTRAR EN PANTALLA ****/ 
        if($NumContrato <>'' AND ($contratocancelado=='' OR $contratocancelado==0))
        {
            $TotalAFinanciar=TotalAFinanciar($NumContrato) ;          
            if (isset($_GET['op']))
            {
              
                if($_GET['op']==1 )
                {           
                $IdPlantilla=IdPlantilla(nombrePlantilla($Idlote));                      
                echo "<center><h1>Contrato</h1></center>";                 
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
                  
                if($IdPlantilla!=0){  
                    crearPlantilla($IdPlantilla, $NumContrato, $TotalAFinanciar, $nitavu); 
                }else{                 
                    echo modalSinRedirigir("Aviso: No se puede imprimir el contrato, no tiene una plantilla registrada.");
                }
                
            }
       }

        

        //SI EXISTE EL BOTON APROBAR HACEMOS EL PROCEDIMIENTO PARA APORBAR UNA CONTRATACION 
        if(isset($_GET['aprobar'])){
            //si asigno un lote
            if(isset($_GET['folioLote'])){
                if(empty($_GET['folioLote'])){
                    //SI NO ME DA UNA CLAVE LOTE, NECESITO ACTUALIZAR QUE EL FOLIO ESTA AUTORIZADO PARA APROBAR
                    if(actualizaraAprobadoContratar($IdDelegacion, $IdPrograma, $Folio, $nitavu)==TRUE){
                        mensaje('Se ha aprobado para contratar con éxito.','contratacion.php');
                    }else{
                        mensaje('Error al aprobar, favor de intentarlo de nuevo.','contratar.php?delegaciones='.$IdDelegacion.'&programa='.$IdPrograma.'&_folio='.$Folio.'');
                    }
                }else{
                    $claveLote = $_GET['folioLote'];
                    //buscamos que el idLote exista y este libre
                    if(existeClaveLote($claveLote) == $claveLote ){
                        if(loteEstatus($claveLote)==0){
                            if(loteNumContrato($claveLote)=='' || loteNumContrato($claveLote)==null ){
                                //Ahora en solicutdes llenar la clave lote preasignada y en lotes actualizar el idEstatus

                                if(actualizarIdLoteenSolicitudes($claveLote, $IdDelegacion, $IdPrograma, $Folio, $nitavu)==TRUE){
                                    if(actualizarIdEstatusenLotes($claveLote, $IdDelegacion, $IdPrograma, $Folio)==TRUE){
                                        mensaje('Se ha aprobado para contratar con éxito.','contratacion.php');
                                    }else{
                                        mensaje('Error al actualizar el estatus del lote, favor de intentarlo de nuevo.','contratar.php?delegaciones='.$IdDelegacion.'&programa='.$IdPrograma.'&_folio='.$Folio.'');
                                    }
                                }else{
                                    mensaje('Error al actualizar la clave del lote en solicitudes, favor de intentarlo de nuevo.','contratar.php?delegaciones='.$IdDelegacion.'&programa='.$IdPrograma.'&_folio='.$Folio.'');
                                }
                            }else{
                                mensaje('Ya existe un contrato ligado a este Lote, favor de revisarlo. NumContrato: '.loteNumContrato($claveLote).'.','contratar.php?delegaciones='.$IdDelegacion.'&programa='.$IdPrograma.'&_folio='.$Folio.'');
                            }
                        }else{
                            mensaje('Este lote no esta libre para asignar.','contratar.php?delegaciones='.$IdDelegacion.'&programa='.$IdPrograma.'&_folio='.$Folio.'');
                        }
                    }else{
                        mensaje('La Clave Lote especificada no existe, favor de intentarlo de nuevo.','contratar.php?delegaciones='.$IdDelegacion.'&programa='.$IdPrograma.'&_folio='.$Folio.'');
                    }
                }
            }
        }


         //BUSCAMOS SI EXISTE LA SOLICITUD
        if(buscaSolicitud($IdPrograma, $IdDelegacion, $Folio)==0){
            mensaje('No existe una solicitud con esos datos','contratacion.php');
        }else{
          
            //SI EXISTE UNA SOLICITUD
             //VERIFICAMOS QUE NO EXISTA UN CONTRATO, Y QUE ESTE UNA SOLICITUD ACTIVA
            if($NumContrato=="" and ($contratocancelado==0 or $contratocancelado='')){
                //BUSCAMOS QUE NO ESTE CANCELADA
                if(solicitudCancelada($IdPrograma, $IdDelegacion, $Folio)==1){
                    mensaje('Esta solicitud esta cancelada.','contratacion.php');
                 }

                //NIVELES DELEGACION O SUELO O DEPENDIENDO DEPTO QUE EJECUTE LA CONTRATACION                
                //REVISAMOS SI LA SOLICITUD ESTA APROBADA
                if(aprobadaEnEvaluacion($IdDelegacion, $IdPrograma, $Folio) == 1){
                    //REVISAMOS SI LA SOLICITUD NO TIENE UN TRAMITE DE DEVOLUCION ACTIVO
                    if(ExisteTramiteDeDevolucionActivo($IdDelegacion,$IdPrograma,$Folio)=='FALSE')
                    {
                        if($nivel == 1){
                            if($NumContrato <> ''){
                                echo "<h3 style='color: red; font-size:9pt;' id='EtiquetaContratado' name='EtiquetaContratado'>No es posible aprobar para contratar, el folio ya se encuentra en estatus de contratado!!</h3>";   
                            }
                            else
                            {
                                //VIENDOLO POR DIR. SUELOS VOY A APROBAR LA CONTRATACION DE UN LOTE
                                echo '<div class="card" style="text-align: justify; width:70%;">
                                <h1 class="card-header h5">Aprobar para Contratación</h1>';
                                    echo '<div class="card-body">';  
                                        echo "<form action='contratar.php' method='GET'>";
                                        echo "<input type='hidden' name='_folio' id='_folio' value=".$Folio.">";
                                        echo "<input type='hidden' name='programa' id='programa' value=".$IdPrograma.">";
                                        echo "<input type='hidden' name='delegaciones' id='delegaciones' value=".$IdDelegacion.">";
                                        echo '<a href="lot_capturalotes.php?m=41" style="float: right;" class="badge badge-info">Ir a Lotes</a>';
                                        echo "<center>";
                                        

                                        if(estaAprobadoContratar($IdDelegacion, $IdPrograma, $Folio) == 1){
                                            echo "<label>*NOTA: Esta solicitud ya cuenta con un lote pre-asignado, clave del lote ".idLotePreAsignado($IdDelegacion, $IdPrograma, $Folio).".</label> <a onclick='habilitarinputs();' class='badge badge-pill badge-light'>Cambiar</a> ";
                                            echo "<br><label>Clave del Lote a Pre-Asignar en este Folio (Opcional)</label>";
                                            echo "<input id='folioLote' name='folioLote' disabled>";
                                            echo '<button type="submit" name="aprobar" id="aprobar" class="btn btn-primary btn-lg" disabled>Aprobar</button>';
                                        }else{
                                            echo "<label>Clave del Lote a Pre-Asignar en este Folio (Opcional)</label>";
                                            echo "<input id='folioLote' name='folioLote'>";
                                            echo '<button type="submit" name="aprobar" id="aprobar" class="btn btn-primary btn-lg">Aprobar</button>';
                                        }
                                        echo "</center>";
                                        echo "</form>";
                                    echo "</div>";
                                echo "</div>";
                                echo "</div>";
                            }
                        }
                        else{
                            /**********************************************************************/
                             // SOY DELEGACION A EJECUTAR LO DEL CONTRATACION
                            /**********************************************************************/

                             //VALIDAMOS EL TIPO programa PARA SABER QUE MOSTRAR 
                             $IdPagoInicial=TipoPagoInicialDatosEvaluacion($IdDelegacion, $IdPrograma, $Folio);   
                            
                             if($tipoPrograma ==  2){
                                 // EL TRAMITE A REALIZAR ES UNA ASIGNACION DE LOTE
                                  
                                 if($NumContrato=='')
                                    {
                                        $varDebioAhorrar = MontoAhorroSolicitud($IdDelegacion, $IdPrograma, $Folio);
                                        $TiempodeAhorrar = TiempoAhorroDatosEvaluacion($IdDelegacion, $IdPrograma, $Folio);
                                        $varCantidadAhorrada = ObtenerTotalAbonadoPorSolicitud($IdDelegacion, $IdPrograma, $Folio);
                                        //echo 'Pago inicial '.$IdPagoInicial ;
                                        if(($IdPagoInicial != 0 and $IdPagoInicial != 10))
                                        {                                     
                                            
                                            if (($varCantidadAhorrada >= $varDebioAhorrar)) 
                                            {
                                                // VALIDAR QUE CUMPLA CON EL periodo EN QUE DEBIO DE AHORRAR 
                                                $MontoPagoInicial=MontoAhorroDatosEvaluacion($IdDelegacion, $IdPrograma, $Folio);  
                                                if ($MontoPagoInicial <> 0 )  
                                                {        
                                                    $fechaPrimerPago=FechaPrimerPagoSolicitud($IdDelegacion, $IdPrograma, $Folio);
                                                    $fechaUltimoPago=FechaUltimoPagoSolicitud($IdDelegacion, $IdPrograma, $Folio);
                                                    if($fechaPrimerPago!='FALSE') 
                                                    {
                                                        $mesesAhorrados=CalculoDeMesesTranscurridos($fechaPrimerPago,$fechaUltimoPago);
                                                        
                                                        if($mesesAhorrados>=$TiempodeAhorrar)
                                                        {
                                                            $url =  $_SERVER['REQUEST_URI'].'&m1';
                                                            if( !isset($_GET['m1']))
                                                            {
                                                                mensaje('Felicidades has cumplido con los tramites para que se te asigne un lote...!.',$url);
                                                            } 
                                                        
                                                        }
                                                        else{
                                                                mensaje('La asignación no procede aun, se ha cumplido con el ahorro, pero no con el tiempo en que debio de ahorrar.<br> Debera esperara que se cumplan los <b>'.$TiempodeAhorrar.' meses </b> establecidos.','contratacion.php');
                                                            }
                                                    }
                                                    else{
                                            
                                                        mensaje('Asignación no procede aun, no se ha detectado ningun pago inicial!..','contratacion.php');
                                                    } 
                                                }
                                                else{
                                            
                                                    mensaje('Revise la evaluación se epecificó un tipo de pago inicial pero no el monto!..','contratacion.php');
                                                } 
                                            }
                                            else{
                                            
                                                mensaje('No se ha cumplido con el ahorro previo.<br> Cantidad Ahorrada:  <b>$'.number_format($varCantidadAhorrada, 2).' </b> de  <b>$'.number_format($varDebioAhorrar, 2) .' </b> pactados en la solicitud de la persona.','contratacion.php');
                                            } 
                                        }
                                        else
                                        {
                                            $url =  $_SERVER['REQUEST_URI'].'&m';
                                            if( !isset($_GET['m']))
                                            {
                                                mensaje('Para esta solicitud autorizada no se especifico un ahorro previo. Si es correcto el dato puede continuar de lo contrario verifique la evaluación!.',$url);
                                            } 
                                           // echo modalSinRedirigir("Para esta solicitud autorizada no se especifico un ahorro previo. Si es correcto el dato puede continuar de lo contrario verifique la evaluación!");
                                    
                                        }

                                    }    
                                
                                
                                   
                             
                             
                                

                             }
                             else
                             {
                                   // EL TRAMITE A REALIZAR ES UN programa DE MATERIAL
                                if( $IdPagoInicial != 0 And $IdPagoInicial != 10 )
                                {
                                   mensaje('Debe usar el modulo de enganches para realizar el pago inicial..','index.php');
                                   
                                }else{

                                    if($NumContrato=='')
                                    {
                                        mensaje('Primero debe inicializar la cuenta en cobranza antes de proseguir','index.php');
                                    }
                                    //Verifica si la asignacion del credito es por tabla o es manual
                                    if(TipoAsignacion($IdPrograma)==0)
                                    {
                                        //muestra Datoa
                                    }
                                    else
                                    {
                                        //trae la informacion de la evaluacion y se prepara
                                        //Rem SE PREPARA PARA LA CONTRATACION
                                    }
    
                                   
                                }

                             }
                            
                        }

                    }
                    else
                    {
                        mensaje('Existe un trámite de devolución, imposible continuar!!.','contratacion.php');
                    }

                }else{
                    mensaje('Esta solicitud no ha sido APROBADA/EVALUADA, favor de aprobarla en el módulo evaluación.','contratacion.php');
                }


                  
            }
            else{               

                //ESXISTE UN CONTRATO Y ESTA CANCELADO
                 if(isset($_GET['m2']) and (($NumContrato <>'') and ($contratocancelado==1)))
                {
                    echo "<h3 style='color: #d5303e; font-size:12pt; font-weight:bold' id='EtiquetaCancelado' name='EtiquetaCancelado'>CONTRATO CANCELADO!!</h3>";   
                } 
               } //CIERRE DE QUE SI EXISTE UN CONTRATO
                 //DIBUJAMOS LOS DATOS DEL BENEFICIARIO EN PANTALLA
                 $IdSolicitante = buscarIdSolicitante($IdPrograma, $IdDelegacion, $Folio);
                 echo "<br>";
                 echo "<center>";
                     datosBeneficiarioenFormatoCorto($IdPrograma, $IdDelegacion, $Folio, $NumContrato);
                 echo "</center>";
                 echo '<br>';
 
                 //BOTONES IMPRESION DE DOCUMENTOS CONTRATO
                 if($NumContrato!="" AND ($contratocancelado=='' OR $contratocancelado==0))
                 {  
                 echo '<center>';
                     echo "<br><section  style='margin-top:5px; width:80%;'>";                  
                     echo "<a id='contratos' href='contratar.php?_folio=".$Folio."&programa=".$IdPrograma."&delegaciones=".$IdDelegacion."&op=1'  class='btn btn-primary'  title='Contrato' style='margin: 20px;'> 
                     <table  width='100%'><tr><td valign='middle' align='center'>
                     <img src='icon/autorizaDescuentos.png'> 
                     </td>
                     <td valign='middle' align='center' style='color:white;' class='pc'>
                     Contrato
                     </td></tr></table>   
                     </a>";
                     if ($IdPrograma==78)
                     {
                     echo "<a id='asignaciongral' href='contratar.php?_folio=".$Folio."&programa=".$IdPrograma."&delegaciones=".$IdDelegacion."&op=2'  class='btn btn-primary'  title='Asigmacion General' style='margin: 20px;'> 
                     <table  width='100%'><tr><td valign='middle' align='center'>
                     <img src='icon/min_noti.png'> 
                     </td>
                     <td valign='middle' align='center' style='color:white;' class='pc'>
                     Asignación General
                     </td></tr></table>   
                     </a>";
                     }
 
                     echo "<a id='corrida' href='contratar.php?_folio=".$Folio."&programa=".$IdPrograma."&delegaciones=".$IdDelegacion."&op=3'  class='btn btn-primary'  title='Corrida Financiera' style='margin: 20px;'> 
                     <table  width='100%'><tr><td valign='middle' align='center'>
                     <img src='icon/embarques_print2.png'> 
                     </td>
                     <td valign='middle' align='center' style='color:white;' class='pc'>
                     Corrida Financiera
                     </td></tr></table>   
                     </a>";
                     echo "</section>";
                 echo "</center>";
                 } 
                 echo '<center>';

                       


            // MUESTRA LOS DATOS
            echo '<br>';
            //*********************** DIV DEL TERRENO ************************************** 
            echo "<div style='width:90%' id=divTerreno>";
                echo '<div class="card" style="text-align: justify">
                        <h1 class="card-header h5" style="text-transform: uppercase;font-size: 10pt;">Datos del Terreno</h1>';
                        echo '<div class="card-body" style="font-size: 10pt">';                                                 
                        
                            if(($Idlote !='' and  $Idlote !='0' ) OR ($NumContrato !='' AND $NumContrato !=NULL)) 
                            {   //$Idlote = numContratoLote($NumContrato);                                                     
                                echo MuestraUbicacionLote($Idlote,'width: 90%;font-size: 10pt;');
                                echo "<script>mostrarDatosCreditoPorIdlote(".$Idlote.");</script>";
                                
                            } else
                            {  
                                echo "<table style='width:100%;'>";
                                echo "<tr><td colspan='2'>";
                                echo "<center><label for='municipio'>Seleccione un Municipio:";
                                echo "<select name='municipio' id='municipio'>";
                                //id='programas'
                                $sql = "SELECT * FROM municipios ORDER by IdMunicipio ASC";
                                    $r = $Vivienda -> query($sql);
                                    while($f = $r -> fetch_array())
                                    { // resultado de la busqueda.................
                                        echo "<option value='".$f['IdMunicipio']."'>".$f['Municipio']. "</option>";
                                    }
                            
                                echo "</select></center>";
                                echo "</td>";                
                                echo "<td colspan='2'>";
                                echo "<center>";
                                echo "<label for='colonia'>Seleccione una colonia:";
                                echo "<select id='colonia' name='colonia'>";   
                                echo  "<option>Seleccione un municipio antes para cargar colonias...</option>";                
                                echo "</select>";
                                echo "</label>";
                                echo "</center>";
                                echo "</td>";
                                echo "</tr>";
                                echo "<tr><td style='text-align: center;'>";
                                echo "<label>Sección</label>";
                                echo "<input id='seccion' name='seccion'>";
                                echo "</td><td style='text-align: center;'>";
                                echo "<label>Fila</label>";
                                echo "<input id='fila' name='fila'>";
                                echo "</td><td style='text-align: center;'>";
                                echo "<label>Manzana</label>";
                                echo "<input id='manzana' name='manzana'>";
                                echo "</td><td style='text-align: center;'>";
                                echo "<label>Lote</label>";
                                echo "<input id='lote' name='lote'>";
                                echo "</td></tr>";
                                echo "</table>"; 
                                echo "<center>";
                                //<button style='width:20%;' class='btn btn-info' onclick='mostrarDatosCredito();'>Buscar</button>
                                echo "<button  onclick='mostrarDatosCredito();'  class='btn btn-info' title='Buscar' > <center>
                                <table><tr><td valign='middle' align='center'>
                                <img src='icon/buscar2.png'> 
                                </td>
                                <td valign='middle' align='center' style='color:white;' >
                                Buscar
                                </td></tr></table>  </center> 
                                </button>"; 
                                echo "</center>";
                            }                          
                        echo '</div>';
                echo '</div>';
            echo '</div>';           
            echo '<br>';            

            echo '<div id="preloader" style="background-color:white; color:#4E4E4E; opacity: 0.9; display: none;">
                <div id="loader">
                        
                        <img src="img/loader.gif" class="cargando_img"><br>
                        <span sytle="color:#4E4E4E;">Espere por favor</span>
                </div>
            </div>';
                        
            //*********************** DIV DEL CREDITO **************************************
            echo "<div style='width:90%' id='divCredito' name='divCredito'>";                       
            echo "</div>";    
            echo "<br>";                           
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



      
           
        }// CIERRA CUANDO SI ENCUENTRA UNA SOLICITUD

    }else{
        mensaje('No se recibieron correctamente los datos, intentelo de nuevo.','contratacion.php');
    }

    
}else{
    mensaje("ERROR: no tienes acceso a este modulo","");
}


?>



<?php include ("lib/body_footer.php"); ?>
<script>
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
function cerrarModal(e){
  	$('#modal_oscuro').hide();
	//document.getElementById('modal_oscuro')						this.close(); //Cierra la notificación
						
}
</script>
