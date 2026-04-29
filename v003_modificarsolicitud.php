<?php include ("./lib/body_head.php"); include ("./lib/body_menu.php"); ?>


<?php
require("config.php");
$id_aplicacion = 'ap101';
xd_update('ap101',$nitavu);//guarda la experiencia del usuario
echo "<div id='AppDetalle'>".app_detalle($id_aplicacion, $nitavu)."</div>";
//PROCESO PARA TOCAR LA PUERTA DE SAN PEDRO
$nivel =aplicacion_nivel($id_aplicacion, $nitavu);

if (sanpedro($id_aplicacion, $nitavu)==TRUE){

    if(isset($_GET['idprog']) and isset($_GET['iddeleg']) and isset($_GET['folio'])){

        echo '<input type="hidden" id="nitavu" name="nitavu" value="'.$nitavu.'">';
        $IdPrograma = $_GET['idprog'];
        $IdDelegacion = $_GET['iddeleg'];
        $Folio = $_GET['folio'];
        $IdSolicitante = buscarIdSolicitante($IdPrograma, $IdDelegacion, $Folio);
        $origendeEnvio = obtenerOrigenDeEnvio($IdPrograma, $IdDelegacion, $Folio);
        echo "<input type='hidden' id='nitavu' name='nitavu' value=".$nitavu.">";
        //TRAER TODOS LOS DATOS Y ACOMODARLOS EN EL REQUISITO CORRESPONDIENTE 
        echo "<script> $('#preloaderbloque').css({'display':'inline-block'});</script>";
        $FolioTramite = vaciarDatosenEstructuraPlataforma($IdPrograma, $IdDelegacion, $Folio, $nitavu,1);
        echo "<script> $('#preloaderbloque').css({'display':'none'});</script>";
        $idTipoSolicitud = TipoSolicitud($IdPrograma);
        //CREAMOS EL FORMULARIO
        echo "<div id='SolicitudDeDatos'>";
        echo '<table class=""><tbody><tr style="background-color:white;">
            <td align="center" valign="middle" width="50%" style="background-color:white;"><img src="img/logo_copia.jpg" style="width:70%;"></td><td>
            </td><td valign="middle">    
            <b style="font-weight: bold;
            font-size: 22pt;    
            color: #337db2;"><b style="font-size:18pt;">'.NombrePrograma($IdPrograma).'</b><br><label style="font-size:8pt;">'.DescripcionPrograma($IdPrograma).'</label><br>
            
            <b style="font-size:12pt; font-color:orange; font-weight:bold;">Folio de Tramite: '.$FolioTramite.' </b>
        </b></td></tr></tbody></table>';
       // echo '<form action="v003.php" method="POST" enctype="multipart/form-data">';
        //echo "<input type='hidden' name='IdTipoSolicitud' id='IdTipoSolicitud' value='".$idTipoSolicitud."'>";
        //echo "<input type='hidden' name='IdPrograma' id='IdPrograma' value='".$idPrograma."'>";
            echo construirFormulario($idTipoSolicitud,$FolioTramite,$nitavu,1,$IdPrograma);
            echo "<div style='width:95%;'>";
            echo "<input type='hidden' name='FolioTramite' id='FolioTramite'>";
            echo "<center><table><td>";
            echo "<button name='Cancelar' id='Cancelar' class='Mbtn btn-default' onclick='borrarSolicitudDeTemporales(".$FolioTramite.");'>Cancelar</button></td>";
            echo '<td><button name="Guardar" id="Guardar" class="Mbtn btn-default" onclick="actualizarDatosVivienda('.$FolioTramite.', '.$IdPrograma.', '.$IdDelegacion.', '.$Folio.', \''.$IdSolicitante.'\', '.$origendeEnvio.');">Guardar</button>';
            echo "</td></table></center>";
            echo "</div>";
        //echo "</form>";
        echo "</div>";
      
    }else{
        mensaje('Ocurrio un error al momento de recibir los datos','v003.php');
    }
}else{
    mensaje("No tiene acceso a ".$id_aplicacion,'');
}

?>
<script type="text/javascript">
function borrarSolicitudDeTemporales(FolioTramite){
    var nitavu =  document.getElementById("nitavu").value;
    $.ajax({
       url: "v003_cancelarMod.php",
      type: "post",
      data: {FolioTramite: FolioTramite, nitavu: nitavu },
      success: function(data){      
        console.log(data);     
        NPush(data,'Plataforma ITAVU');        
        window.location.href = "v003.php";
      }
   });

  
}
 

function actualizarDatosVivienda(FolioTramite, IdPrograma, IdDelegacion, Folio, IdSolicitante, origendeEnvio){
   
    var nitavu =  document.getElementById("nitavu").value;
    $.ajax({
        url: "v003_actualizarDatos.php",
      type: "post",
      data: {FolioTramite: FolioTramite, IdPrograma: IdPrograma, IdDelegacion: IdDelegacion, Folio: Folio, IdSolicitante: IdSolicitante, origendeEnvio: origendeEnvio, nitavu: nitavu},
      success: function(data){      
        console.log(data);     
        NPush(data,'Plataforma ITAVU');        
      
       if(data.includes('ACTUALICE LOS DATOS DE LA SOLICITUD CON ÉXITO!!')==true)                            
        {		
            window.location.href = "v003.php";
        }
      }
   });

}



function calcularIngresoMensualFamiliar(FolioTramite, IdRequisito, IdCategoria){
    
    var nitavu =  document.getElementById("nitavu").value;
     $.ajax({
         url: "v003_calcularIngresoMen.php",
         type: "post",        
         data: {FolioTramite: FolioTramite, nitavu:nitavu},
         success: function(data){   
          
             $("#76_10").val(data);
         }
     });
 }
 
 function calcularIngresoNeto(FolioTramite, IdRequisito, IdCategoria){
     //alert('entro');
     var nitavu =  document.getElementById("nitavu").value;
     $.ajax({
         url: "v003_calcularIngresoNeto.php",
         type: "post",        
         data: {FolioTramite: FolioTramite, nitavu:nitavu},
         success: function(data){   
          
             $("#85_10").val(data);
         }
     });
 }
 
 function calcularEgresoMensual(FolioTramite, IdRequisito, IdCategoria){
     var nitavu =  document.getElementById("nitavu").value;
     $.ajax({
         url: "v003_calcularEgresoMen.php",
         type: "post",        
         data: {FolioTramite: FolioTramite, nitavu:nitavu},
         success: function(data){   
          
             $("#77_10").val(data);
         }
     });
 }
 
 function BuscaCURP(IdRequisito, IdCat, FolioTramite, tipo, IdTipoSolicitud){
    
    var nitavu =  document.getElementById("nitavu").value;
    if(tipo==2){
        var div = IdRequisito + "_curp" + IdCat; 
         
        console.log(div);   
        var txtCURP = $("#"+div).val().toUpperCase();
    }else{
        var div = IdRequisito + "_" + IdCat;    
        var txtCURP = $("#"+div).val().toUpperCase();
    }
    
    //alert(txtCURP);
 
    //$("#"+div).val(txtCURP);
    var Len = $("#"+div).val().length;
    //console.log("Tamaño del CURP: " + Len);
 
    
    if (Len == 18){
        $("#Loader" + IdRequisito + "_" + IdCat).show();
        $.ajax({
            url: "sol_curp.php",
            type: "POST",        
            data: {IdCat:IdCat, IdRequisito:IdRequisito, txtCURP: txtCURP, nitavu:nitavu},
            success: function(data){  
                console.log(data);   
 
                if(data.includes('Error')!=true)                            
                {
                    //console.log('entro');
                    var cadena = data;
                    var variables = cadena.split(",");
                    var Nombre = "";
                if(tipo ==1){
                        for (var i = 0; i < variables.length; i++) {
                       
                            if(i==4){
                                //console.log(i);
                            // $("#"+ i + "_" + IdCat).val(variables[i]);
                                if(variables[i]=='M'){
                                    $("#"+ i + "_" + IdCat+" option[value=1]").attr("selected",true);
                                    
                                }else{
                                    $("#"+ i + "_" + IdCat+" option[value=2]").attr("selected",true);
                                }
                                $("#"+i + "_" + IdCat).attr("readonly","readonly");
                                $("#"+ i + "_" + IdCat+" option:not(:selected)").attr('disabled',true);
                                //console.log(i + IdCat+variables[i]);
                            }else if(i==5){
                                var fecha = variables[i].split("/");
                                var fechanueva = fecha[2]+'-'+fecha[1]+'-'+fecha[0];
                                $("#"+ i + "_" + IdCat).val(fechanueva);
                                $("#"+i + "_" + IdCat).attr("readonly","readonly");
                            }else if(i==7){
                               
                                $("#"+ i + "_" + IdCat+" option[value="+variables[i]+"]").attr("selected",true);
                                $("#"+i + "_" + IdCat).attr("readonly","readonly");
                                $("#"+ i + "_" + IdCat+" option:not(:selected)").attr('disabled',true);
                            }else{
                                console.log(i);
                                $("#"+ i + "_" + IdCat).val(variables[i]);
                                $("#"+i + "_" + IdCat).attr("readonly","readonly");
                                console.log(i + IdCat+variables[i]);
                                if(i==1){
                                    Nombre = variables[i];
                                }else if(i==2){
                                    Nombre = Nombre+' '+variables[i];
                                }else if(i==3){
                                    Nombre = Nombre+' '+variables[i];
                                }
 
                            }
                        $("#Loader" + IdRequisito + "_" + IdCat).hide(); 
                    }
                    //GUARDAR LAS VARIABLES DEL CURP EN EL FOLIO CORRESPONDIENTE
                    
                     $.ajax({
                         url: "v003_dat3.php",
                         type: "POST",        
                         data: {IdCat:IdCat, IdRequisito:IdRequisito, txtCURP: txtCURP, nitavu:nitavu,FolioTramite:FolioTramite, variables: variables ,IdTipoSolicitud:IdTipoSolicitud, Nombre: Nombre},
                         success: function(data){  
                             document.getElementById('respuestaa').innerHTML = data;
                             NPush(data, 'Plataforma ITAVU');
                         }
                     });
                   
                    
                    
               }else{
                    console.log('entro al 2');
                    for (var i = 0; i < variables.length; i++) {
                            
                        
                            if(i==1){
                                $("#"+ i + "_nombre"  + IdCat).val(variables[i]);
                                $("#"+i + "_nombre"  + IdCat).attr("readonly","readonly");
                                console.log(i + '_nombre'  + IdCat);
                            }else if(i==2){
                                $("#"+ i + "_ap" + IdCat).val(variables[i]);
                                $("#"+i + "_ap" + IdCat).attr("readonly","readonly");
                                console.log(i + '_ap'  + IdCat);
                            }else if(i==3){
                                $("#"+ i + "_am" + IdCat).val(variables[i]);
                                $("#"+i + "_am" + IdCat).attr("readonly","readonly");
                            }else if(i==4){
                                //console.log(i);
                            // $("#"+ i + "_" + IdCat).val(variables[i]);
                                if(variables[i]=='M'){
                                    $("#"+ i + "_sexo" + IdCat +" option[value=1]").attr("selected",true);
                                    
                                }else{
                                    $("#"+ i + "_sexo" + IdCat+" option[value=2]").attr("selected",true);
                                }
                                $("#"+i + "_sexo" + IdCat).attr("readonly","readonly");
                                $("#"+ i + "_sexo" + IdCat+" option:not(:selected)").attr('disabled',true);
                                //console.log(i + IdCat+variables[i]);
                            }else if(i==5){
                                var fecha = variables[i].split("/");
                                var fechanueva = fecha[2]+'-'+fecha[1]+'-'+fecha[0];
                                $("#"+ i + "_fechan" + IdCat).val(fechanueva);
                                $("#"+i + "_fechan" + IdCat).attr("readonly","readonly");
                            }else if(i==6){
                                //console.log(i);
                                $("#"+ i + "_nacionalidad" + IdCat).val(variables[i]);
                                $("#"+i + "_nacionalidad" + IdCat).attr("readonly","readonly");
                                //console.log(i + IdCat+variables[i]);
                            }else if(i==7){
                                $("#"+ i + "_entidadf" + IdCat).val(variables[i]);
                                $("#"+i + "_entidadf" + IdCat).attr("readonly","readonly");
                            }else if(i==8){
                                $("#"+ i + "_status" + IdCat).val(variables[i]);
                                $("#"+i + "_status" + IdCat).attr("readonly","readonly");
                                
                            }
                        }   
                    }            
                    
                }else{
                    NPush('ERROR al obtener el datos del CURP solicitado. '+data, 'Plataforma ITAVU');
                }
            }
         });
 
    }
 
    console.log("->" + txtCURP);
 
 }
 
 var x = 0;
 //$('#btn-Add').click(function() {
 function agregarDependiente(IdTipoSolicitud,FolioTramite){
    x = x+1;
    $.ajax({
        url: "v003_agregarDependientes.php",
        type: "POST",        
        data: {x:x, FolioTramite:FolioTramite,IdTipoSolicitud:IdTipoSolicitud},
        success: function(data){  
           // console.log(data);   
            $('#Categoria30').append(data);
            var acc = document.getElementsByClassName("accordion1");
            var i;
 
            for (i = 0; i < acc.length; i++) {
                acc[i].addEventListener("click", function() {
                    /* Toggle between adding and removing the "active" class,
                    to highlight the button that controls the panel */
                    this.classList.toggle("active");
 
                    /* Toggle between hiding and showing the active panel */
                    var panel = this.nextElementSibling;
                    if (panel.style.display === "block") {
                        panel.style.display = "none";
                    } else {
                        panel.style.display = "block";
                    }
                });
            }
           
        }
    });
 }
 
 
 
 function mayus(e) {
    e.value = e.value.toUpperCase();
 }
 
 
 function CargaLocalidad(cat){
    var IdMunicipio =  document.getElementById("39_"+cat).value;
    $.ajax({
        url: "sol_localidades.php",
        type: "POST",        
        data: {IdMunicipio: IdMunicipio},
        success: function(data){  
            document.getElementById('40_'+cat).options.length = 0;
            $("#40_"+cat).append(data);
            
        }
    });
 
 }
 
 function CargaColonia(cat){
    var IdMunicipio =  document.getElementById("39_"+cat).value;
    $.ajax({
        url: "sol_colonias.php",
        type: "POST",        
        data: {IdMunicipio: IdMunicipio},
        success: function(data){  
            document.getElementById('41_'+cat).options.length = 0;
            $("#41_"+cat).append(data);
            
        }
    });
 
 }
 
 function agregarApoyoSolicitado(IdTipoSolicitud,FolioTramite){
    x = x+1;
    $.ajax({
        url: "v003_agregarApoyoSolicitado.php",
        type: "POST",        
        data: {x:x, FolioTramite:FolioTramite,IdTipoSolicitud:IdTipoSolicitud},
        success: function(data){  
           // console.log(data);   
            $('#Categoria34').append(data);
            var acc = document.getElementsByClassName("accordion1");
            var i;
 
            for (i = 0; i < acc.length; i++) {
                acc[i].addEventListener("click", function() {
                    /* Toggle between adding and removing the "active" class,
                    to highlight the button that controls the panel */
                    this.classList.toggle("active");
 
                    /* Toggle between hiding and showing the active panel */
                    var panel = this.nextElementSibling;
                    if (panel.style.display === "block") {
                        panel.style.display = "none";
                    } else {
                        panel.style.display = "block";
                    }
                });
            }
           
        }
    });
 }
 
 function SubirArchivo(FolioTramite, IdRequisito, IdCategoria, tipoInfo){
     var nitavu =  document.getElementById("nitavu").value;
     $("#Loader" + IdRequisito + "_" + IdCategoria).show();			
     var inputFileImage = document.getElementById(""+IdRequisito + "_" + IdCategoria);
     var file = inputFileImage.files[0];
     var data = new FormData();
     data.append(''+IdRequisito,file);
     data.append('Folio',FolioTramite);
     data.append('IdRequisito',IdRequisito);
     data.append('IdCategoria',IdCategoria);
     data.append('nitavu',nitavu);
     data.append('tipoInfo',tipoInfo);
 
     $.ajax({
         url: "v003_dat2.php",        
         type: "POST",             
         data: data, 			  
         contentType: false,       
         cache: false,             
         processData:false,        
         success: function(data)   
         {
             console.log(data);
             $('#PDF' + IdRequisito + "_" + IdCategoria).html(data);
             $("#Loader" + IdRequisito + "_" + IdCategoria).hide(); 
         }
    });
    
 
 } 
 
 
 function GuardarDato(FolioTramite, IdRequisito, IdCategoria, tipoInfo){
    //alert('entro funcion guardar dato');
     var nitavu =  document.getElementById("nitavu").value;
     var municipio ='';
     if(IdCategoria == 5 || IdCategoria == 23){
         municipio = document.getElementById("39_"+IdCategoria).value;
     }
     
 //alert(municipio);
     var input = $("#" + IdRequisito + "_" + IdCategoria + ":input");
     var type = input.attr('type');
     if(type == 'checkbox'){
         var Valor = $("#" + IdRequisito + "_" + IdCategoria).prop('checked');
     }else{
         var Valor = $("#" + IdRequisito + "_" + IdCategoria).val();
     }
   
    
  
    $("#Loader" + IdRequisito + "_" + IdCategoria).show();
    $.ajax({
    url: "v003_dat1.php",
    type: "get",        
    data: {Folio:FolioTramite, IdRequisito:IdRequisito, value:Valor, IdCategoria:IdCategoria, nitavu:nitavu, municipio:municipio, tipoInfo: tipoInfo},
    success: function(data){                                
        $("#" + IdRequisito + "_" + IdCategoria).html(data+"\n");   
        console.log("Guardando " + IdRequisito + "_" + IdCategoria + ":" + data);
        $("#Loader" + IdRequisito + "_" + IdCategoria).hide();  
    }
    });
 
 }
 
 function guardarDatos(FolioTramite){
     var nitavu =  document.getElementById("nitavu").value;
 
     //alert('entro');
     $.ajax({
    url: "v003_dat4.php",
    type: "post",        
    data: {Folio:FolioTramite, nitavu: nitavu},
    success: function(data){   
         console.log(data);      
         NPush(data,'Plataforma ITAVU');        
        //$("#" + IdRequisito + "_" + IdCategoria).html(data+"\n");   
        if(data.includes('Informacion guardada con éxito en vivienda')==true){
             window.location.href = "v003.php";
        }
    }
    });
 
 }
</script>
<br><br><br>
<br>
<br>
<br><br><br>
<br>
<br>
<br><br><br>
<br>
<br>
<br><br><br>
<br>
<br>
<?php include ("./lib/body_footer.php"); ?>