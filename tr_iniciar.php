<?php include ("./lib/body_head.php");
include ("./lib/body_menu.php"); 
?>
<br><br>
<?php
echo '<div id ="respuesta" style="display:none;">';
echo '</div>';


error_reporting(0); //<-- para simular produccion
$idDepartamento=nitavu_dpto($nitavu);
$id_aplicacion ="ap87";
$nivel =aplicacion_nivel($id_aplicacion, $nitavu);

if (sanpedro($id_aplicacion, $nitavu)==TRUE){
    echo "<div id='AppDetalle'>".app_detalle($id_aplicacion, $nitavu)."</div>";	
    echo "<input type='hidden' value='".$nitavu."' id='_itavu' name='_itavu'>";
    if ( isset($_GET['edit']) ){ ///<--- si es una edicion-------------------------------------------------
        if ($_GET['edit']==''){ 
            historia($nitavu, "abrio para editar el tramite con folio ".$_GET['edit']);
            mensaje("ERROR: no se especifico un folio para editar","tramites.php");
        } else {
          
            if (TramiteIdTipoTramite($_GET['edit']) <> FALSE ){ //<-- validamos que exista el tramite

                //Variables necesarias para validar su continuidad (Esta esla misma validacion del select de tramite)
                $FolioTramite = $_GET['edit']; if (ValidaVAR($FolioTramite)==TRUE){$FolioTramite = LimpiarVAR($FolioTramite);} else {$FolioTramite = "";}
                $CURP =  TramiteCURP($FolioTramite);   
                $IdTipoTramite = TramiteIdTipoTramite($FolioTramite);  
                $IdPrograma = TramiteIdPrograma($FolioTramite);          
                $IdDelegacion = obtenerDelegacionTramite($FolioTramite);

                if ( TramiteValidarContinuidad($CURP, $IdTipoTramite,$IdPrograma, $IdDelegacion) == TRUE ) {// Se valida si puede iniciarlo en funcion de su dependencia o si es el primero
                    echo "<div id='SolicitudDeDatos'>";
                    $Formulario = FormularioTramite($FolioTramite,'', '','', '', '','', '', '', $nitavu,$nivel, '', '','',$IdDelegacion, $IdPrograma); //<--- Inserta el formulario para editar
                     //$Formulario = $Formulario."<label>* Fecha: ".fecha_larga($fecha).", Empleado que atendio: ".nitavu_nombre($nitavu).", en ".nitavu_dpto_nombre($nitavu)."</label>";
                    ///pendiente: historial de cambio
                    $Estado = TramiteEstado($CURP, $IdPrograma, $IdDelegacion);
                   // echo "*Estado = ".$Estado;
                    echo $Formulario;
                   
               
    
                    echo "</div>";          
                   $IdPrograma = TramiteIdPrograma($FolioTramite);    
                 //$IdPrograma = 78;
                    // echo "**</form>";
                   HistoriaTramite($CURP, $IdPrograma, $IdDelegacion);

                    
                              
                                
                                

                } else {mensaje("ERROR: Este tramite no puede continuar, ya que el primero aun no concluye o fue rechazado","tramites.php");}
            } else { mensaje("ERROR: Tramite ".$_GET['edit']." no valido","tramites.php"); }
        
        } 

    } else {
    //Variables

    if (isset($_POST['txtCurp']) AND isset($_POST['programa']) and !empty($_POST['programa']) 
    AND isset($_POST['delegacion']) and !empty($_POST['delegacion'])){
        
        $CURPSolicitado = $_POST['txtCurp'];   //<-- variables del form inicial
        $IdDelegacion = $_POST['delegacion'];
        $IdPrograma = $_POST['programa'];
        $FolioTramite = folioDelTramite($CURPSolicitado, $IdPrograma, $IdDelegacion);
        $IdTipoTramite = idTipoTramitePorPrograma($IdPrograma);//ponemos un 1 por default por que sabemos que es una presolicitud

        //echo "curp". $CURPSolicitado.'-'.$IdDelegacion.'-'.$IdPrograma.'-'.$IdTipoTramite;

        //Limpiamos las Variables
        if (ValidaVAR($CURPSolicitado)==TRUE){$CURPSolicitado = LimpiarVAR($CURPSolicitado);} else {$CURPSolicitado = "";}
        if (ValidaVAR($IdTipoTramite)==TRUE){$IdTipoTramite = LimpiarVAR($IdTipoTramite);} else {$IdTipoTramite = "";}

        if ( TramiteValidarContinuidad($CURPSolicitado, $IdTipoTramite,$IdPrograma, $IdDelegacion) == TRUE ) {//<-- Validacion si continuidad

                    //Validamos que ya no tenga un tramite
                    $sql = 'SELECT count(*) as n from tramites WHERE IdDelegacion = '.$IdDelegacion.' and IdPrograma = '.$IdPrograma.' and Curp = "'.$CURPSolicitado.'"';	
                    //echo $sql;
                   
                    // select NombreTramite as Valor from tramitestipo where IdTipoTramite;
                    $rc= $conexion -> query($sql);        
                    if($f = $rc -> fetch_array()){
                        if ( $f['n'] == 0 ) { //ya tiene un Tramite
                            
                        // si no tiene tramites iniciados, le creamos y solicitamos datos
                            
                            //Consultamos el CURP
                            $ResultadoDelCURP = CURP($CURPSolicitado, $nitavu); //<-- se entrega en formato JSON
                            //var_dump($ResultadoDelCURP);
                            $c = 1;  $array = json_decode($ResultadoDelCURP, true);
                            //var_dump($array);
                            if(is_array($array)){                    
                                foreach ($array as $value) {
                                    if ($c==1){

                                        if ($value==1){
                                            $exito = TRUE;
                                            
                                        }
                                        $c=$c+1;
                                    } else {
                                        
                                        if ($exito == TRUE){
                                   
                                  //  if ($c==2){
                                        $Nombres = $value['nombres']; $Apellido1 = $value['apellido1']; $Apellido2 = $value['apellido2'];
                                        $Sexo = $value['sexo']; $FechaNacimiento = $value['fechNac'];
                                        $StatusCurp = $value['statusCurp'];
                                        $Nacionalidad = $value['nacionalidad'];
                                        $EntidadDeNacimiento = $value['nombreEntidadNac'];
                                        $numEntidadNacimiento = $value['numEntidadReg'];


                                         //Validamos el Estado del CURP
                            $ErrorDelCurp = "";
                            switch ($StatusCurp) {
                                case "BD": $ErrorDelCurp = "Baja por Defuncion"; break;
                                case "BDA":$ErrorDelCurp = "Baja por duplicidad";break;
                                case "BCC":$ErrorDelCurp = "Baja por Cambio en CURP"; break;
                                case "BCN":$ErrorDelCurp = "Baja no afectando a CURP"; break;
                                default: $ErrorDelCurp = "";
                            }
                            if ($ErrorDelCurp == ''){ // si no teiene errores el CURP continuamos
                               // echo 'no tiene error el curp';
                                //VALIDAMOS QUE NO EXISTA EN VIVIENDA UNA SOLICITUD CON ESTOS DATOS
                                //buscarIdSolicitante($IdPrograma, $IdDelegacion, $Folio);
                                //nombreBeneficiarioVivienda($IdSolicitante);
                                //creamos el id para compararlo con alguno existente en vivienda
                                $idsolicitante = crearIdSolicitante($Apellido1,$Apellido2,$Nombres, $FechaNacimiento, $Sexo, $EntidadDeNacimiento);
                                //echo "idsolicitnte ".$idsolicitante;
                                $existe = existeIdSolicitante($idsolicitante, $IdPrograma, $IdDelegacion);
                                $existe2= existeCurpSolicitante($CURPSolicitado, $IdPrograma, $IdDelegacion);
                                $aprobado = aprobadoIdSolicitante($idsolicitante, $IdPrograma, $IdDelegacion);
                                $aprobado2 = aprobadoCurpSolicitante($CURPSolicitado, $IdPrograma, $IdDelegacion);
                                $total = totalSolicitudesporIdSolicitante($idsolicitante, $IdPrograma, $IdDelegacion);
                                $total1 = totalSolicitudesporCurpSolicitante($CURPSolicitado, $IdPrograma, $IdDelegacion);
                                $sumTotalSolciitudes = $total +$total1;
                                $numSolciitudesAprobadas = NSAporprogrma($IdPrograma);
                                //buscamos el numero de solicitudes que tiene en un programa en especifico
                                //|| NSAporprogrma($IdPrograma)<
                                   //aprobadoIdSolicitante($idsolicitante, $IdPrograma, $IdDelegacion)<>'' and aprobadoCurpSolicitante($curp, $IdPrograma, $IdDelegacion)<>''
                                if((($existe == '' and $existe2 == '') and ($sumTotalSolciitudes < $numSolciitudesAprobadas)) or (($aprobado <>'' or $aprobado2 <> '')  and ($sumTotalSolciitudes < $numSolciitudesAprobadas))){
                                    //Construimos el Formularios
                                    echo "<div id='SolicitudDeDatos'>";
                                    $Formulario = FormularioTramite('',$CURPSolicitado, $IdTipoTramite, $Nombres, $Apellido1, $Apellido2, $Sexo, $FechaNacimiento, $StatusCurp, $nitavu,$nivel, $Nacionalidad, $EntidadDeNacimiento, $numEntidadNacimiento, $IdDelegacion, $IdPrograma);
                                        // $Formulario = $Formulario."<label>* Fecha: ".fecha_larga($fecha).", Empleado que atendio: ".nitavu_nombre($nitavu).", en ".nitavu_dpto_nombre($nitavu)."</label>";
                                        //$Estado = TramiteEstado($CURPSolicitado, $IdPrograma, $IdDelegacion);
                                    echo $Formulario;
                                    //$FolioTramite = folioDelTramite($CURPSolicitado, $IdPrograma, $IdDelegacion);
                                    echo "<hr>".TramiteLeyendaInferior($FolioTramite);
                                    echo "</div>";
                                    
                                    //$IdPrograma = TramiteIdPrograma($FolioTramite);   
                                   HistoriaTramite($CURPSolicitado, $IdPrograma, $IdDelegacion);
                                    // echo "<button onclick='ImprimirSolicitud();'>Imprimir</button>";
                                }else{
                                    mensaje('No es posible continuar, el solicitante ya cuenta con un beneficio de este programa.','tramites.php');
                                }

                            } 
                            else 
                            { 
                                Sentimental("Hubo un problema al validar el CURP ".$CURPSolicitado.":  <b>".$ErrorDelCurp.", Estado del CURP: ".$StatusCurp."</b>; comlibte con el Dpto de Informatica");    
                                historia($nitavu, "Hubo un problema al validar el CURP ".$CURPSolicitado.":  <b>".$ErrorDelCurp."</b>; al realizar el tramite con Id ".$IdTipoTramite);
                             }
                                    
                                    //}$c= $c +1;
                        }else 
                        {
                           // mensaje('entro','tramites.php');
                            Sentimental("Favor de verificar el CURP, no se encontraron resultados.");
                        }
                    }
               }
            }  
            else
            { 
                Sentimental("Hubo un problema al obtener el CURP; comlibte con el Dpto de Informatica");
            }

            } else {
                mensaje("El CURP solicitado ya cuenta con un tramite iniciado","tramites.php");
            }
        }
        else { Sentimental("Hubo un problema; comlibte con el Dpto de Informatica");}
        } else {mensaje("ERROR: Este tramite no puede continuar, ya que el primero aun no concluye o fue rechazado","tramites.php");}

    } else {
        Sentimental("Parametros Incorrectos");
    }
}
  
}else{
    mensaje('No tiene permiso para esta aplicación','index.php');
}




?>
<script>
function ImprimirSolicitud(){
    
    $('#SolicitudDeDatos').printThis({
    importCSS: true,
    printContainer: true,   
    importStyle: true 

});
}



function ValidarTramite(FolioTramite, IdTipoTramite){
var folio=0;
//$("#Loader" + IdRequisito).show();
$.ajax({
idfolio: FolioTramite,
url: "tr_dat3_3.php",
type: "get",        
data: {Folio:FolioTramite, IdTipoTramite:IdTipoTramite},
success: function(data){   
    folio=this.idfolio;
   $('#respuesta').html(data);   
   var res=data.trim();
   console.log(res);
    if(res.includes('TRUE')==true){
        NPush(data,'Plataforma ITAVU');
        location.href="tr_solicitud.php?folio="+folio;
    }else{
      NPush(data,'Plataforma ITAVU');
    }

      
}
}); 
}



 function GuardarDato(FolioTramite, IdRequisito, IdClase){
     //alert('entro funcion guardar dato');
     var Valor = $("#" + IdRequisito + "_" + IdClase).val();
     $("#Loader" + IdRequisito + "_" + IdClase).show();
     $.ajax({
        url: "tr_dat1.php",
        type: "get",        
        data: {Folio:FolioTramite, IdRequisito:IdRequisito, value:Valor, IdClase:IdClase},
        success: function(data){                                
            $("#" + IdRequisito + "_" + IdClase).html(data+"\n");   
            // console.log("Guardando " + IdRequisito + "_" + IdClase + ":" + data);
            $("#Loader" + IdRequisito + "_" + IdClase).hide();  
        }
     });
 
    }
 

    function buscarDependencias(IdRequisito, IdClase, FolioTramite){
       
       var nitavu = $("#_itavu").val();
       //alert(nitavu);
       var IdOpcion = $("#"+IdRequisito+"_"+IdClase+" option:selected").val();
       var cade="";
       $.ajax({
           url: "tr_buscarOpciones.php",
           type: "post",
           data: {IdRequisito:IdRequisito, IdOpcion: IdOpcion, Caso: 1, FolioTramite: FolioTramite, nitavu: nitavu},
           success: function(data){
               var res=data.trim();
               if(res!=''){
                   cade = res.slice(0, -1);
                   //alert ('contenido cadena'+cade);
                   var array = cade.split("-"); 
                   //alert(array.length);
                   
                   for(var i = 0; i < array.length; i++) {
                       var counter;
                       $('#'+array[i]+"_"+IdClase).html("");
                       $.ajax({
                           ajaxcounter: i,
                           url: "tr_buscarOpciones.php",
                           type: "post",
                           data: {IdReq:array[i], IdClase: IdClase, IdRequisito:IdRequisito, IdOpcion: IdOpcion, Caso: 2, FolioTramite:FolioTramite, nitavu: nitavu},
                           success: function(data){
                               //alert(data);
                               counter = this.ajaxcounter;  
                               $('#'+array[counter]+"_"+IdClase).html(data+"\n");
                           }
                       });
                   }
                   
               }
           }
       });
   }


function SubirArchivo(FolioTramite, IdRequisito, IdClase){
$("#Loader" + IdRequisito + "_" + IdClase).show();			
var inputFileImage = document.getElementById(""+IdRequisito + "_" + IdClase);
var file = inputFileImage.files[0];
var data = new FormData();
data.append(''+IdRequisito,file);
data.append('Folio',FolioTramite);
data.append('IdRequisito',IdRequisito);
data.append('IdClase',IdClase);

$.ajax({
        url: "tr_dat2.php",        
        type: "POST",             
        data: data, 			  
        contentType: false,       
        cache: false,             
        processData:false,        
        success: function(data)   
        {
            console.log(data);
            $('#PDF' + IdRequisito + "_" + IdClase).html(data);
            $("#Loader" + IdRequisito + "_" + IdClase).hide(); 
        }
    });
    

}     

function BuscaCURP(IdRequisito, IdClase, FolioTramite){
    var div = IdRequisito + "_" + IdClase;    
    var txtCURP = $("#"+div).val().toUpperCase();;
    $("#"+div).val(txtCURP);
    var Len = $("#"+div).val().length;
    console.log("Tamaño del CURP: " + Len);

    
    if (Len == 18){
        $("#Loader" + IdRequisito + "_" + IdClase).show();
        $.ajax({
            url: "tr_datCURP.php",
            type: "POST",        
            data: {IdClase:IdClase, IdRequisito:IdRequisito, txtCURP: txtCURP, FolioTramite: FolioTramite},
            success: function(data){  
                console.log(data);                                    
                $("#R" + IdRequisito + "_" + IdClase).html(data+"\n");   
                
                $("#Loader" + IdRequisito + "_" + IdClase).hide();  


                //$('#' + IdRequisito + '_' + IdClase).hide();
                location.href="tr_iniciar.php?edit="+FolioTramite;
                //location.reload();

                //Agregar require al resto de los input


            }
         });
 
    }

    console.log("->" + txtCURP);

}


function mayus(e) {
    e.value = e.value.toUpperCase();
}



</script>


<?php include ("./lib/body_footer.php"); ?>
