<?php include ("./lib/body_head.php"); include ("./lib/body_menu.php"); ?>


<?php
require("config.php");
$id_aplicacion = 'ap101';
//xd_update('ap101',$nitavu);//guarda la experiencia del usuario
echo "<div id='AppDetalle'>".app_detalle($id_aplicacion, $nitavu)."</div>";
//PROCESO PARA TOCAR LA PUERTA DE SAN PEDRO
$nivel =aplicacion_nivel($id_aplicacion, $nitavu);

if (sanpedro($id_aplicacion, $nitavu)==TRUE){

echo "<input type='hidden' id='nitavu' name='nitavu' value=".$nitavu.">";

//CREAR SOLICITUD POR PRIMERA VEZ
if (isset($_POST['programas2']) and isset($_POST['delegaciones2']) and isset($_POST['nombre'])){

    $idPrograma = $_POST['programas2'];
    $delegacion = $_POST['delegaciones2'];
    $nombre = $_POST['nombre'];
    $ap =$_POST['ap'];
    $am =$_POST['am'];
    $sexo1 = $_POST['sexo'];
    $fechan = $_POST['fechan']; 
    $nacionalidad =  $_POST['nacionalidad'];
    $entidad=$_POST['entidad'];
    $status =$_POST['status'];
    $CURP = $_POST['_curp'];
    $IdDpto=nitavu_dpto($nitavu);
    $Nombre = $nombre.' '.$ap.' '.$am;
    $sexo = "";
    if($sexo1 == 'M'){
        $sexo = 1;
    }else if($sexo1 == 'H'){
        $sexo = 2;
    }else{
        $sexo = '';
    }

    //validamos que no haya una solicitud de esta persona en proceso, si no la hay continua el proceso 
    //Ya no nos i nteresa saber si tiene en proceso, debido a que si se cancela puede volver a crear una nueva
    //if(SolicitudValidarContinuidad($CURP, $idPrograma, $delegacion)=='' or SolicitudValidarContinuidad($CURP, $idPrograma, $delegacion)==5){
        //VALIDAMOS SI ES UN programa CON PRE-SOLICITUD y SI AUN NO EXISTE EN SOLICITUDES 
        if(tienePreSolicitud($idPrograma)<> '0' and existeSolicitud($CURP, $idPrograma, $delegacion)==''){
            if(estadoPreSolicitud($CURP,$idPrograma, $delegacion)==''){
                $link = '<a href="tramites.php" class="stretched-link">Presolicitudes</a>';
                mensaje('Este programa requiere PreSolicitud, favor de realizarlo en la aplicación de PreSolicitudes.<br>'.$link.'','v003.php');
            }else if(estadoPreSolicitud($CURP,$idPrograma, $delegacion)=='0'){
                $folio = folioDelTramite($CURP, $idPrograma, $delegacion);
                //$link = '<a href="tr_iniciar.php?edit='.$folio.'" class="stretched-link">Presolicitud de '.$CURP.' </a>';
                $link = '<a href="tramites.php" class="stretched-link">Presolicitudes</a>';
                mensaje('Este programa requiere PreSolicitud. El Curp: '.$CURP.' ya cuenta con presolicitud iniciada.<br>'.$link.'','v003.php');
            }else if(estadoPreSolicitud($CURP,$idPrograma, $delegacion)=='1'){
                mensaje('Este programa requiere PreSolicitud. El Curp: '.$CURP.' ya cuenta con presolicitud iniciada esta en fase de aprobación.','v003.php');
            }else if(estadoPreSolicitud($CURP, $idPrograma, $delegacion)=='2'){
                mensaje('Este programa requiere PreSolicitud. El Curp: '.$CURP.' ya cuenta con presolicitud y ya ha sido aprobada, debe encontrarse en la lista de solicitudes pendientes para continuar con el proceso.','v003.php');
            }else if(estadoPreSolicitud($CURP, $idPrograma, $delegacion)=='3'){
                mensaje('Este programa requiere PreSolicitud. El Curp: '.$CURP.' ya cuenta con presolicitud que ha sido rechazada.','v003.php');
            }else if(estadoPreSolicitud($CURP, $idPrograma, $delegacion)=='4'){
                mensaje('Este programa requiere PreSolicitud. El Curp: '.$CURP.' ya cuenta con presolicitud iniciada esta en fase de devolución.','v003.php');
            }
            
        }elseif(tienePreSolicitud($idPrograma)<> '' and existeSolicitud($CURP, $idPrograma, $delegacion)<>''){
            //echo 'entro aqui';
            $sql ='select IdTipoSolicitud from programa where IdPrograma = '.$idPrograma.'';
            //echo $sql;
            $r= $Vivienda -> query($sql);
            echo "<br>";
            echo "<div id='SolicitudDeDatos'>";
            $FolioTramite = folioDeLaSolicitud($CURP, $idPrograma, $delegacion);
            echo "<input type='hidden' id='FolioTramite' name='FolioTramite' value=".$FolioTramite.">";
            echo '<table class=""><tbody><tr style="background-color:white;">
                <td align="center" valign="middle" width="50%" style="background-color:white;"><img src="img/logo_copia.jpg" style="width:70%;"></td><td>
                </td><td valign="middle">    
                <b style="font-weight: bold;
                font-size: 22pt;    
                color: #337db2;"><b style="font-size:18pt;">'.NombrePrograma($idPrograma).'</b><br><label style="font-size:8pt;">'.DescripcionPrograma($idPrograma).'</label><br>
                
                <b style="font-size:12pt; font-color:orange; font-weight:bold;">Folio de Tramite: '.$FolioTramite.' </b>
            </b></td></tr></tbody></table>';
            //<b style="font-size:10pt;">'.DescripcionPrograma($idPrograma).'</b>
            while($f = $r -> fetch_array()) {
                $idTipoSolicitud = $f['IdTipoSolicitud'];
                echo '<form action="v003.php" method="POST" enctype="multipart/form-data">';
                echo "<input type='hidden' name='IdTipoSolicitud' id='IdTipoSolicitud' value='".$idTipoSolicitud."'>";
                echo "<input type='hidden' name='IdPrograma' id='IdPrograma' value='".$idPrograma."'>";
                    echo construirFormulario($idTipoSolicitud,$FolioTramite,$nitavu,1,$idPrograma);
                    echo "<div style='width:95%;'>";
                    echo "<input type='hidden' name='FolioTramite' id='FolioTramite'>";
                    echo "<input type='submit' name='Guardar' id='Guardar' value='Guardar' class='Mbtn btn-default'>";
                    echo "</div>";
                echo "</form>";
            }
            echo "</div>";
            HistoriaTramite($CURP, $idPrograma, $delegacion);
        }else{

            //VALIDAMOS QUE NO EXISTA EN VIVIENDA UNA SOLICITUD CON ESTOS DATOS
            //buscarIdSolicitante($IdPrograma, $IdDelegacion, $Folio);
            //nombreBeneficiarioVivienda($IdSolicitante);
            //creamos el id para compararlo con alguno existente en vivienda
            
            $idsolicitante = crearIdSolicitante($ap,$am,$nombre, $fechan, $sexo1, $entidad);
            //echo "idsolicitnte ".$idsolicitante;
           /* $existe = existeIdSolicitante($idsolicitante, $idPrograma, $delegacion);
            $existe2= existeCurpSolicitante($CURP, $idPrograma, $delegacion);
            $aprobado = aprobadoIdSolicitante($idsolicitante, $idPrograma, $delegacion);
            $aprobado2 = aprobadoCurpSolicitante($CURP, $idPrograma, $delegacion);
            $total = totalSolicitudesporIdSolicitante($idsolicitante, $idPrograma, $delegacion);
            $total1 = totalSolicitudesporCurpSolicitante($CURP, $idPrograma, $delegacion);
            $sumTotalSolciitudes = $total +$total1;
            $numSolciitudesAprobadas = NSAporprogrma($idPrograma);*/
            //buscamos el numero de solicitudes que tiene en un programa en especifico
            //|| NSAporprogrma($IdPrograma)<
               //aprobadoIdSolicitante($idsolicitante, $IdPrograma, $IdDelegacion)<>'' and aprobadoCurpSolicitante($curp, $IdPrograma, $IdDelegacion)<>''
            
          /*  echo $existe.'existe<br>';
            echo $existe2.'existe2<br>';
            echo $aprobado.'aprobado<br>';
            echo $aprobado2.'aprobado2<br>';
            echo $total.'total<br>';
            echo $numSolciitudesAprobadas.'numsol<br>';*/
           // if((($existe == '' or $existe2 == '') and ($sumTotalSolciitudes < $numSolciitudesAprobadas)) or (($aprobado <>'' or $aprobado2 <> '')  and ($sumTotalSolciitudes < $numSolciitudesAprobadas))){
                                
                $sql ='select IdTipoSolicitud from programa where IdPrograma = '.$idPrograma.'';
                //echo $sql;
                $r= $Vivienda -> query($sql);
                echo "<br>";
                echo "<div id='SolicitudDeDatos'>";
                $FolioTramite = nsolicitud(TRUE);  
                echo "<input type='hidden' id='FolioTramite' name='FolioTramite' value=".$FolioTramite.">";
                echo '<table class=""><tbody><tr style="background-color:white;">
                    <td align="center" valign="middle" width="50%" style="background-color:white;"><img src="img/logo_copia.jpg" style="width:70%;"></td><td>
                    </td><td valign="middle">    
                    <b style="font-weight: bold;
                    font-size: 22pt;    
                    color: #337db2;"><b style="font-size:18pt;">'.NombrePrograma($idPrograma).'</b><br><label style="font-size:8pt;">'.DescripcionPrograma($idPrograma).'</label><br>
                    
                    <b style="font-size:12pt; font-color:orange; font-weight:bold;">Folio de Tramite: '.$FolioTramite.' </b>
                </b></td></tr></tbody></table>';
                //<b style="font-size:10pt;">'.DescripcionPrograma($idPrograma).'</b>
                while($f = $r -> fetch_array()) {
                    $idTipoSolicitud = $f['IdTipoSolicitud'];
                    echo '<form action="v003.php" method="POST" enctype="multipart/form-data">';
                    echo "<input type='hidden' name='IdTipoSolicitud' id='IdTipoSolicitud' value='".$idTipoSolicitud."'>";
                    echo "<input type='hidden' name='IdPrograma' id='IdPrograma' value='".$idPrograma."'>";

                        $sql = "INSERT INTO solicitudestemp(IdSolicitud, IdTipoSolicitud, Curp, NitavuCaptura,Fecha,Hora, DptoCaptura, NombreBeneficiario, IdPrograma, IdDelegacion) 
                        VALUES ('".$FolioTramite."', '".$idTipoSolicitud."', '".$CURP."','".$nitavu."', '".$fecha."','".$hora."', '".$IdDpto."', '".$Nombre."', ".$idPrograma.", ".$delegacion.")";
                        //echo $sql;
                        if ($conexion->query($sql) == TRUE){
                            historia($nitavu,"solicitudes: Guardo la solicitud con Folio " . $FolioTramite."");
                            nsolicitud(FALSE);  
                            //echo "<script>NPush('Se ha Iniciado la Solicitud ' + '".$FolioTramite."', 'Plataforma ITAVU')</script>";
                                                    //Guardamos los datos principales
                            if (GuardarSolicitudDato($FolioTramite, 0, $CURP, "text", $nitavu, 1,1) == FALSE) {echo "<script>console.log('Error al guadar Folio: ".$FolioTramite.", IdRequisito: CURP');</script>"; }
                            if (GuardarSolicitudDato($FolioTramite, 1, $nombre, "text", $nitavu, 1,1) == FALSE) {echo "<script>console.log('Error al guadar Folio: ".$FolioTramite.", IdRequisito: Nombres');</script>"; }
                            if (GuardarSolicitudDato($FolioTramite, 2, $ap, "text", $nitavu, 1,1) == FALSE) {echo "<script>console.log('Error al guadar Folio: ".$FolioTramite.", IdRequisito:Apellido1');</script>"; }
                            if (GuardarSolicitudDato($FolioTramite, 3, $am, "text", $nitavu, 1,1) == FALSE) {echo "<script>console.log('Error al guadar Folio: ".$FolioTramite.", IdRequisito: Apellido2');</script>"; }
                            if (GuardarSolicitudDato($FolioTramite, 4, $sexo, "text", $nitavu, 1,1) == FALSE) {echo "<script>console.log('Error al guadar Folio: ".$FolioTramite.", IdRequisito: sexo');</script>"; }
                            if (GuardarSolicitudDato($FolioTramite, 5, $fechan, "date", $nitavu, 1,1) == FALSE) {echo "<script>console.log('Error al guadar Folio: ".$FolioTramite.", IdRequisito: FechaNacimiento');</script>"; }
                            if (GuardarSolicitudDato($FolioTramite, 8, $status, "text", $nitavu, 1,1) == FALSE) {echo "<script>console.log('Error al guadar Folio: ".$FolioTramite.", IdRequisito: StatusCURP');</script>"; }

                            if (GuardarSolicitudDato($FolioTramite, 6, $nacionalidad, "text", $nitavu, 1,1) == FALSE) {echo "<script>console.log('Error al guadar Folio: ".$FolioTramite.", IdRequisito: Nacionalidad');</script>"; }
                            if (GuardarSolicitudDato($FolioTramite, 7, $entidad, "text", $nitavu, 1,1) == FALSE) {echo "<script>console.log('Error al guadar Folio: ".$FolioTramite.", IdRequisito: Entidad de Nacimiento');</script>"; }

                            echo '<script> NPush("Se ha Iniciado la Solicitud para:'.$CURP.'-'.$Nombre.'", "PLataforma ITAVU")</script>';
                        }
                        else {
                            echo '<script> NPush("ERROR: No se pudo crear la solicitud para:'.$CURP.'-'.$Nombre.'", "PLataforma ITAVU")</script>';
                        }
                        
                        echo construirFormulario($idTipoSolicitud,$FolioTramite,$nitavu,1, $idPrograma);
                        echo "<div style='width:95%;'>";
                        echo "<input type='hidden' name='FolioTramite' id='FolioTramite'>";
                        echo "<input type='submit' name='Guardar' id='Guardar' value='Guardar' class='Mbtn btn-default'>";
                        echo "</div>";
                    echo "</form>";
                }
                echo "</div>";
                HistoriaTramite($CURP, $idPrograma, $delegacion);
         /*   }else{
                mensaje('No es posible continuar, el solicitante ya cuenta con un beneficio de este programa.','v003.php');
            }*/
        }
  /*  }else{
        mensaje('No es posible continuar, ya esta iniciada una solicitud para este beneficiario en este mismo programa.','v003.php');
    }*/
    ///DIBUJAR PARA SEGUIR EDITANDO LA SOLICITUD
}else if(isset($_POST['_id'])){
    $FolioTramite = $_POST['_id'];
    $idPrograma = $_POST['programa'];
    $delegacion = $_POST['delegacion'];
    $CURP = SolicitudCURP($FolioTramite);
    echo "<input type='hidden' id='FolioTramite' name='FolioTramite' value=".$FolioTramite.">";
    $sql ='select IdTipoSolicitud from programa where IdPrograma = '.$idPrograma.'';
    //echo $sql;
    $r= $Vivienda -> query($sql);
    echo "<br>";
    echo "<div id='SolicitudDeDatos'>";
    echo '<table class=""><tbody><tr style="background-color:white;">
        <td align="center" valign="middle" width="50%" style="background-color:white;"><img src="img/logo_copia.jpg" style="width:70%;"></td><td>
        </td><td valign="middle">    
        <b style="font-weight: bold;
        font-size: 22pt;    
        color: #337db2;"><b style="font-size:18pt;">'.NombrePrograma($idPrograma).'</b><br><label style="font-size:8pt;">'.DescripcionPrograma($idPrograma).'</label><br>
        
        <b style="font-size:12pt; font-color:orange; font-weight:bold;">Folio de Tramite: '.$FolioTramite.' </b>
    </b></td></tr></tbody></table>';
    //<b style="font-size:10pt;">'.DescripcionPrograma($idPrograma).'</b>
    while($f = $r -> fetch_array()) {
        $idTipoSolicitud = $f['IdTipoSolicitud'];
        //echo '<form action="v003.php" method="POST" enctype="multipart/form-data">';
        echo construirFormulario($idTipoSolicitud,$FolioTramite,$nitavu,1,$idPrograma);
            echo "<div style='width:95%;'><center>";
            echo "<input type='hidden' name='FolioTramite' id='FolioTramite'>";
            echo "<button name='Guardar' onclick='guardarDatos(".$FolioTramite.");' id='Guardar' class='Mbtn btn-default'>Guardar</button>";
            echo "</center></div>";
        //echo "</form>";
    }
    echo "</div>";
    HistoriaTramite($CURP, $idPrograma, $delegacion);

}else{
    mensaje('No se recibieron los datos adecuadamente, primero debe de buscar el CURP solicitado. Favor de intentarlo nuevamente.','v003.php');
}


}else{
    mensaje("No tiene acceso a ".$id_aplicacion,'');
}

?>
<script>


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
    $('#Guardar').prop('disabled',true);
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