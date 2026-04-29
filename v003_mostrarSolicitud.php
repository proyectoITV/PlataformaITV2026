<?php include ("./lib/body_head.php"); include ("./lib/body_menu.php"); ?>


<?php
require("config.php");
$id_aplicacion = 'ap101';
xd_update('ap101',$nitavu);//guarda la experiencia del usuario
echo "<div id='AppDetalle'>".app_detalle($id_aplicacion, $nitavu)."</div>";
//PROCESO PARA TOCAR LA PUERTA DE SAN PEDRO
$nivel =aplicacion_nivel($id_aplicacion, $nitavu);

if (sanpedro($id_aplicacion, $nitavu)==TRUE){

    if(isset($_GET['IdPrograma']) and isset($_GET['IdDelegacion']) and isset($_GET['Folio'])){

    $IdPrograma = $_GET['IdPrograma'];
    $IdDelegacion = $_GET['IdDelegacion'];
    $Folio = $_GET['Folio'];

    
    if(buscaSolicitud($IdPrograma, $IdDelegacion, $Folio)==0){
        mensaje('No existe una solicitud con esos datos','v003.php');
    }else{

    $IdSolicitante = buscarIdSolicitante($IdPrograma, $IdDelegacion, $Folio);
    
    echo "<br><br><br>";
    
    //BOTONES
    if(solicitudCancelada($IdPrograma, $IdDelegacion, $Folio)==0){
    echo "<div id='req_menu'><center>"; 
        echo "<a href='v003_modificarsolicitud.php?idprog=".$IdPrograma."&iddeleg=".$IdDelegacion."&folio=".$Folio."' class='Mbtn btn-default' title='Clic para modificar los datos de la solicitud'>";
            echo "<table  width='100%'><tr><td valign='middle' align='center'>";
            echo "<img src='icon/modificarRep.png' style='width:20px; height:20px;'>";
            echo "</td>";
            echo "<td valign='middle' align='center' style='color:white; font-size:12pt;' class='pc'>";
            echo "Modificar Solicitud";
            echo "</td></tr></table>";
        echo "</a>";	

        echo "<a href='#cancelarSolicitud' rel='MyModal:open' class='Mbtn btn-default' title='Clic para cancelar la solicitud' >";
            echo "<table  width='100%'><tr><td valign='middle' align='center'>";
            echo "<img src='icon/eliminar.png' style='width:20px; height:20px;'>";
            echo "</td>";
            echo "<td valign='middle' align='center' style='color:white; font-size:12pt;' class='pc'>";
            echo "Cancelar Solicitud";
            echo "</td></tr></table>";
        echo "</a>";	
        
        //se agrega boton de guardar como para guardar la misma solicitud con otro programa
        echo "<a href='#crearNuevoFolio' rel='MyModal:open' class='Mbtn btn-default' title='Clic para crear nueva solicitud con otro programa' >";
            echo "<table  width='100%'><tr><td valign='middle' align='center'>";
            echo "<img src='icon/guardar_blanco.png' style='width:20px; height:20px;'>";
            echo "</td>";
            echo "<td valign='middle' align='center' style='color:white; font-size:12pt;' class='pc'>";
            echo "Guardar como";
            echo "</td></tr></table>";
        echo "</a>";	

    echo "</center></div>";
    }

//MODAL CANCELAR SOLICITUD
echo "<div id='cancelarSolicitud' class='MyModal'>";
echo "<form method='POST' action ='v003.php'>";
echo "<h2>¿Por qué motivo cancela la solicutud?</h2>";
echo "<input type='hidden' id='idprog' name='idprog' value='".$IdPrograma."'>";
echo "<input type='hidden' id='iddeleg' name='iddeleg' value='".$IdDelegacion."'>";
echo "<input type='hidden' id='folio' name='folio' value='".$Folio."'>";
echo '<div class="form-check form-check-inline">
<input class="form-check-input" style="width: 15px; height: 15px; " type="radio" name="inlineRadioOptions" id="inlineRadio1" value="18">
<label class="form-check-label" for="inlineRadio1">Por Duplicidad</label>
</div>
<div class="form-check form-check-inline">
<input class="form-check-input" style="width: 15px; height: 15px; " type="radio" name="inlineRadioOptions" id="inlineRadio2" value="19">
<label class="form-check-label" for="inlineRadio2">Cancelación de trámite</label>
</div>';
//echo "<textarea id='motivo' name='motivo'></textarea>";
echo "<input type='submit' style='width: 200px;' value='Guardar' class='Mbtn btn-default'>";
echo "</form>";
echo "</div>";

//MODAL GUARDAR COMO = CREAR NUEVA SOLICITUD CON NUEVO PRGORAMA
echo "<div id='crearNuevoFolio' class='MyModal'>";
echo "<form method='POST' action ='v003.php'>";
echo "<h2>¿Quiere guardar esta solicitud para un nuevo programa?</h2>";
echo "<input type='hidden' id='idprog1' name='idprog1' value='".$IdPrograma."'>";
echo "<input type='hidden' id='iddeleg1' name='iddeleg1' value='".$IdDelegacion."'>";
echo "<input type='hidden' id='folio1' name='folio1' value='".$Folio."'>";
echo "<div>";
echo "<label for='programanvo'>Seleccione un programa:";
echo "<select name='programanvo' id='programanvo'>";

//$sql = "SELECT * FROM delegaciones where tipo = 0 ORDER by Delegacion ASC";

    $sql = "SELECT * FROM programa WHERE Activo=1 ORDER by Programa ASC";
    $r = $Vivienda -> query($sql);
    while($f = $r -> fetch_array())
    { // resultado de la busqueda.................
        if($IdPrograma == $f['IdPrograma']){

        }else{
            echo "<option value='".$f['IdPrograma']."'>".$f['Programa']. "</option>";
        }
    }

echo "</select>";
echo "</label>";
echo "</div>";
echo "<br>";
echo "<input type='submit' style='width: 200px;' value='Guardar' class='Mbtn btn-default'>";
echo "</form>";
echo "</div>";

//FORMATO SOLICITUD- TARJETA DE PRESENTACION
echo "<br><br>";
echo "<center>";
        datosBeneficiarioenFormato($IdPrograma, $IdDelegacion, $Folio);
    
        //SI TIENE CONYUGE
      if(idEstadoCivilBeneficiarioVivienda($IdDelegacion,$IdPrograma,$Folio) == 1  || idEstadoCivilBeneficiarioVivienda($IdDelegacion,$IdPrograma,$Folio) == 5){
            echo "<a onclick=vermas('vermasdiv') class='digitalizados_vinculos'>Ver más..</a>";
            echo '<div id="vermasdiv" style="display:none">';
                datosConyugeenFormato($IdDelegacion,$IdPrograma,$Folio);
                echo "<a onclick=vermas('vermasdiv1') class='digitalizados_vinculos'>Ver más..</a>";
            echo '</div> ';
        }else{
            echo "<a onclick=vermas('vermasdiv1') class='digitalizados_vinculos'>Ver más..</a>";
        }
        
          
        echo '<div id="vermasdiv1" style="display:none"> ';
            datosDomicilioDondeResideenFormato($IdDelegacion,$IdPrograma,$Folio);
            echo "<a onclick=vermas('vermasdiv2') class='digitalizados_vinculos'>Ver más..</a>";
        echo '</div> ';

        echo '<div id="vermasdiv2" style="display:none">';
            datosReferenciasenFormato($IdDelegacion,$IdPrograma,$Folio);
            if(tieneDependientes($IdDelegacion,$IdPrograma,$Folio) > 0){
                echo "<a onclick=vermas('vermasdiv3') class='digitalizados_vinculos'>Ver más..</a>";
            }else{
                echo "<a onclick=vermas('vermasdiv4') class='digitalizados_vinculos'>Ver más..</a>";
            }
        echo '</div> ';

     echo '<div id="vermasdiv3" style="display:none">';
        datosDependientesenFormato($IdDelegacion,$IdPrograma,$Folio);
        echo "<a onclick=vermas('vermasdiv4') class='digitalizados_vinculos'>Ver más..</a>";
    echo '</div> ';
        
        
        
   echo '<div id="vermasdiv4" style="display:none">';
    datosInformacionEconomica($IdDelegacion,$IdPrograma,$Folio);
    echo '</div> ';

 
  
    echo "</center>";
    } 
    }else{
        mensaje('Ocurrio un error al momento de recibir los datos','v003.php');
    }


}else{
    mensaje("No tiene acceso a ".$id_aplicacion,'');
}

?>
<script type="text/javascript">
function vermas(nom){
    var eldiv =document.getElementById(nom);
    eldiv.style.display="block";
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