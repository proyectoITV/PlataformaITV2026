<?php include ("./lib/body_head.php"); include ("./lib/body_menu.php"); ?>


<?php
require("config.php");
$id_aplicacion = 'ap106';
xd_update('ap106',$nitavu);//guarda la experiencia del usuario
echo "<div id='AppDetalle'>".app_detalle($id_aplicacion, $nitavu)."</div>";
//PROCESO PARA TOCAR LA PUERTA DE SAN PEDRO
$nivel =aplicacion_nivel($id_aplicacion, $nitavu);

if (sanpedro($id_aplicacion, $nitavu)==TRUE){
historia ($nitavu,"Entre a aprobar o desaprobar una solicitud con la evaluación");

echo "<input type='hidden' id='nitavu' name='nitavu' value=".$nitavu.">";


if(isset($_GET['IdPrograma']) and isset($_GET['IdDelegacion']) and isset($_GET['Folio'])){
    $IdPrograma = $_GET['IdPrograma'];
    $IdDelegacion = $_GET['IdDelegacion'];
    $Folio = $_GET['Folio'];

    if(buscaSolicitud($IdPrograma, $IdDelegacion, $Folio)==0){
        mensaje('No existe una solicitud con esos datos','v004.php');
    }else{
        if(solicitudCancelada($IdPrograma, $IdDelegacion, $Folio)==0){
            if(isset($_GET['_id'])){
                $FolioTramite = $_GET['_id'];
            }else{
                //ANTES DE HACER CUALQUIER MOVIMIENTO BUSCAR SI YA ESTA EVALUADA
                //BUSCAMOS EN LA BD SI TIENE FECHAEVALUACION CON ESO SABREMOS SI ESTA DISPONIBLE O NO
                $fechaEvaluacion = fechaEvaluaciondeSolicitud($IdPrograma, $IdDelegacion, $Folio);
                if($fechaEvaluacion == "" or $fechaEvaluacion == null or $fechaEvaluacion == '0000-00-00 00:00:00'){
                    $FolioTramite = "";
                    $FolioTramite = crearFolioTramite($FolioTramite,$IdPrograma, $IdDelegacion, $Folio, $nitavu);
                    crearCorridaFinanciera($FolioTramite, $IdPrograma, $IdDelegacion, $Folio, $nitavu);
                }else if(!isset($_GET['Mod'])){
                    $estatus = estatusEvaluaciondeSolicitud($IdPrograma, $IdDelegacion, $Folio);
                    if($estatus == 0 and $fechaEvaluacion == '' or $fechaEvaluacion == '0000-00-00 00:00:00') {
                        $estatus = "AUN NO SE APRUEBA ESTA SOLICITUD";
                    }else if($estatus == 1){
                      //  if($fechaEvaluacion <> '' and )
                        $estatus = "APROBADO";
                    }else{
                        $estatus = "RECHAZADO";
                    }
                    mensajeModificar('Esta solicitud ya ha sido evaluada. En esta fecha: '.date("d/m/Y", strtotime($fechaEvaluacion)).' con un estatus de: '.$estatus.'!','v004.php', 'v004_iniciar.php?IdPrograma='.$IdPrograma.'&IdDelegacion='.$IdDelegacion.'&Folio='.$Folio.'&Mod=1');
                }else{
                    //busca el folio del tramite en plataforma
                    $FolioTramite = folioTramiteDeLaSolicitud($Folio, $IdPrograma, $IdDelegacion);

                }
            
            }
        }
        
            echo "<center>";
            echo "<br>";
            if(solicitudCancelada($IdPrograma, $IdDelegacion, $Folio)==0){
                echo "<div id='req_menu'>"; 
                    echo "<a  href='#aprobar' rel='MyModal:open' class='Mbtn btn-default' title='Clic para modificar los datos de la solicitud'>";
                        echo "<table  width='100%'><tr><td valign='middle' align='center'>";
                        echo "<img src='icon/ok2.png' style='width:25px; height:25px;'>";
                        echo "</td>";
                        echo "<td valign='middle' align='center' style='color:white;' class='pc'>";
                        echo "Aprobar";
                        echo "</td></tr></table>";
                    echo "</a>";	

                    echo "<a href='#noAprobar' rel='MyModal:open' class='Mbtn btn-default' title='Clic para cancelar la solicitud' >";
                        echo "<table  width='100%'><tr><td valign='middle' align='center'>";
                        echo "<img src='icon/x.png' style='width:25px; height:25px;'>";
                        echo "</td>";
                        echo "<td valign='middle' align='center' style='color:white;' class='pc'>";
                        echo "No aprobar";
                        echo "</td></tr></table>";
                    echo "</a>";		
                echo "</div>";
            }
            datosBeneficiarioenFormato($IdPrograma, $IdDelegacion, $Folio);
        echo "</center>";
    
    
    
    
        echo "<div id='aprobar' class='MyModal'>";
            echo "<input type='hidden' id='FolioTramite' name='FolioTramite' value=".$FolioTramite.">";
            $idTipoEvaluacion = buscarTipoEvaluacion($IdPrograma);
        
            //echo $sql;
            echo "<center>";
            echo "<div>";
            echo '<h2>Crédito autorizado</h2>';
            //<b style="font-size:10pt;">'.DescripcionPrograma($idPrograma).'</b>
                //echo '<form action="v003.php" method="POST" enctype="multipart/form-data">';
                echo construirEvaluacion($idTipoEvaluacion,$FolioTramite,$nitavu, $IdPrograma,2);
                    echo "<div style='width:95%;'>";
                    echo "<input type='hidden' name='FolioTramite' id='FolioTramite'>";
                    echo "<button name='Guardar' onclick='guardarEvaluacion(".$FolioTramite.", ".$IdPrograma.", ".$IdDelegacion.", ".$Folio.");' id='Guardar' class='Mbtn btn-default'>Guardar</button>";
                    echo "</div>";
                //echo "</form>";
            
            echo "</div>";
            echo "</center>";
        echo "</div>";

        echo "<div id='noAprobar' class='MyModal'>";
            echo "<center>";
            echo "<form action='v004.php' method='post'>";
            echo "<input type='hidden' id='FolioTramite' name='FolioTramite' value=".$FolioTramite.">";
            echo "<input type='hidden' id='IdPrograma' name='IdPrograma' value=".$IdPrograma.">";
            echo "<input type='hidden' id='IdDelegacion' name='IdDelegacion' value=".$IdDelegacion.">";
            echo "<input type='hidden' id='Folio' name='Folio' value=".$Folio.">";
            echo '<h2>Razón por la cual no se aprobará el crédito</h2>';
            echo "<textarea id='observacion' name='observacion'></textarea>";
            echo "<input type='submit' name='_guardar' id='_guardar' value='Guardar' class='Mbtn btn-default'>";
            echo "</form>";
            echo "</center>";
        echo "</div>";

        
    }

}else{
    mensaje('No se recibieron los datos adecuadamente. Favor de intentarlo nuevamente.','v004.php');
}


}else{
    mensaje("No tiene acceso a ".$id_aplicacion,'');
}

?>
<script>

function mayus(e) {
   e.value = e.value.toUpperCase();
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
   data: {Folio:FolioTramite, IdRequisito:IdRequisito, value:Valor, IdCategoria:IdCategoria, nitavu:nitavu, municipio:municipio, tipoInfo:tipoInfo},
   success: function(data){                                
       $("#" + IdRequisito + "_" + IdCategoria).html(data+"\n");   
       console.log("Guardando " + IdRequisito + "_" + IdCategoria + ":" + data);
       $("#Loader" + IdRequisito + "_" + IdCategoria).hide();  
   }
   });

}

function guardarEvaluacion(FolioTramite, IdPrograma, IdDelegacion, Folio){
    var nitavu =  document.getElementById("nitavu").value;

    $.ajax({
   url: "v004_guardarEvaluacion.php",
   type: "post",        
   data: {FolioTramite:FolioTramite, nitavu: nitavu, IdPrograma: IdPrograma, IdDelegacion: IdDelegacion, Folio: Folio},
   success: function(data){   
        console.log(data);      
       if(data.includes('Se actualizaron los datos con éxito')==true){
            NPush(data,'Plataforma ITAVU'); 
            window.location.href = "v004.php";  
       }else{
            NPush(data,'Plataforma ITAVU');  
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