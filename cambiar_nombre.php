<?php

include ("lib/body_head.php");
    
$id_aplicacion ="ap120"; 
$nivel = aplicacion_nivel($id_aplicacion, $nitavu);

if (sanpedro($id_aplicacion, $nitavu)==TRUE){
    echo "<div id='AppDetalle'>".app_detalle($id_aplicacion, $nitavu)."</div>";        
    xd_update($id_aplicacion,$nitavu); historia($nitavu, $id_aplicacion." | Entro a cambio de nombre");
    echo "<br><br>";

    //PRIMERA VALIDACION SERIA VER SI ES POR PROGRAMAS TIPO TERRENO O CUALQUIER OTRO 

    //NIVELES


    //SI ES NECESARIO BUSCARLO ANTES
    //LO PRIMERO SERIA ESCOGER DELEGACION, programa SOCIAL, NUMERO DE FOLIO
    echo "<center>";
    echo "<div style='width:80%; padding-top: 30px;  padding-bottom: 30px;'>";
    echo "<form id='formularioContrato' action='cambiar_nombre.php' method='GET' style='border: 1px #C0C5BE solid; padding-top: 20px;
    padding-right: 10px;
    padding-bottom: 20px;
    padding-left: 10px;'>";
    echo "<center><table style='width:100%;'><tr><td style='width:20%;'>";
    
    echo "<center><label for='delegaciones'>Seleccione una delegación:";
    echo "<select name='delegaciones' id='delegaciones' required>";
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
    echo "<select name='programa' id='programa'  required>";
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
    echo "<input id='_folio' name='_folio' value=''   placeholder='Folio del solicitante' required>";
    echo "</center></td></tr>";
    echo "<tr><td colspan=3 style='width:30%;'><center>";    
    echo "<button type='submit'  class='btn btn-info' title='Buscar' > <center>
    <table><tr><td valign='middle' align='center'>
    <img src='icon/buscar2.png'> 
    </td>
    <td valign='middle' align='center' style='color:white;' >
    Buscar
    </td></tr></table>  </center> 
    </button>";  

    echo "</center></td></tr></table></center>";
    echo "</form>";   
    echo "</div>";

    
    echo "<center>";

   
    if(isset($_GET['delegaciones']) and isset($_GET['programa']) and isset($_GET['_folio']) ){
        $IdDelegacion = $_GET['delegaciones'];
        $IdPrograma = $_GET['programa'];
        $Folio = $_GET['_folio'];
        $tipoPrograma = tipoTramitePrograma($IdPrograma);
          
          
        $NumContrato = buscarSiYaTieneContratoActivoOno($IdDelegacion, $IdPrograma, $Folio);

        $contratocancelado=ContratoCancelado($NumContrato, $IdDelegacion, $IdDelegacion);

         //BUSCAMOS SI EXISTE LA SOLICITUD
        if(buscaSolicitud($IdPrograma, $IdDelegacion, $Folio)==0){
            mensaje('No existe una solicitud con esos datos','cambiar_nombre.php');
        }else{            
            //BUSCAMOS QUE NO ESTE CANCELADA
            if(solicitudCancelada($IdPrograma, $IdDelegacion, $Folio)==1){
                mensaje('Esta solicitud esta cancelada.','cambiar_nombre.php');
            }


             //DIBUJAMOS LOS DATOS DEL BENEFICIARIO EN PANTALLA
             $IdSolicitante = buscarIdSolicitante($IdPrograma, $IdDelegacion, $Folio);
             echo "<br>";
             echo "<center>";
                 datosBeneficiarioenFormatoCorto($IdPrograma, $IdDelegacion, $Folio, $NumContrato);
             echo "</center>";
             echo '<br>';

             echo "<h4>Para el cambio de nombre es necesario contar con el CURP de la persona...</h4>";
        
            // ---------------------BUSCAR NUEVO NOMBRE POR MEDIO DE CURP**************
            echo "<div id='iniciarTramite' style='width:80%;'>";
            echo "<form action='guardar_cambionom.php' method='POST'>";
            echo "<center>
            <label>Favor de introducir el CURP y dar clic en el botón de búsqueda</label>
            <table width=60%><tr><td valign=top>";
            echo "<input type='hidden' name='_folio' id='_folio' value=".$Folio.">";
            echo "<input type='hidden' name='programa' id='programa' value=".$IdPrograma.">";
            echo "<input type='hidden' name='delegaciones' id='delegaciones' value=".$IdDelegacion.">";
            echo "<input required ='required' type='text' style='height:55px; margin:0px; font-size:19pt;' id='_curp' name='_curp' value='' maxlength='18' onkeyup='mayus(this); PortCurp();' placeholder='CURP del Solicitante' required></td>";
            echo "<td valign=top><a onclick='CURP_persona();' style='margin:0px;' class='Mbtn btn-CelesteTam' title='Buscar Datos del CURP'>
            <img src='icon/busqueda.png' style='width:30px' id='flecha'>
            <img src='img/loader_bar.gif' style='width:30px; display:none;' id='LoaderCurp'>
                </a></td>";
            echo "</tr></table></center>";
            echo "<div id='Persona' style='width:100%'>";
            echo "</div>";      
            echo "<center><input type='submit' style='width:20%' value='Guardar' class='Mbtn btn-default'></center>";
            echo "</form>";
            echo "</div>";
        
        
            //hacer el update al folio anterior en nombre
            $sql = "UPDATE solicitantes
            SET Nombre='secundaria' WHERE curso='primaria'";
        
        
        
        
        
        
        }

              

                  
          

      
           
    }// CIERRA CUANDO SI ENCUENTRA UNA SOLICITUD




}else{
    mensaje("ERROR: no tienes acceso a este modulo","");
}


?>
<script>
function CURP_persona(){
var curp = $('#_curp').val();

var Len = $("#_curp").val().length;
    //console.log("Tamaño del CURP: " + Len);
    $('#txtCurp').val(curp);
    console.log(curp);
    if (Len == 18){
        $("#flecha").hide();
        $("#LoaderCurp").show();
        $.ajax({
            url: "v003curp.php",
            type: "get",        
            data: {curp:curp},
            success: function(data){   
            $('#Persona').html(data);
                $("#flecha").show();
                $("#LoaderCurp").hide();
            }
        }); 
    }else{
        NPush('Hacen falta caracteres en el CURP para poder buscarlo.','Plataforma ITAVU');
    }

}
</script>

<?php include ("lib/body_footer.php"); ?>

