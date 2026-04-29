<?php
    include ("lib/body_head.php");
    require_once('lib/laura_funciones.php');
    require_once('lib/funciones.php');
    // include ("lib/body_menu.php");
    //No tiene menu vertical
?>
<!-- <script>
$(document).on("change", "#municipio", function(event) {
    mostrarLocalidades($("#municipio option:selected").val()); 
});              
function mostrarLocalidades(id){
   //alert('entro');
    $("#preloader").css({'display':'inline-block',});
    $.ajax({
        url: "en_localidad.php",
        type: "get",
        data: {id: id},
        success: function(data){
            
            $("#preloader").css({'display':'none',});
            $('#localidad').html(data+"\n");
        }
    });
}
</script> -->
<?php

    
$id_aplicacion ="ap116"; $nivel = aplicacion_nivel($id_aplicacion, $nitavu);
$nivel =aplicacion_nivel($id_aplicacion, $nitavu);

if (sanpedro($id_aplicacion, $nitavu)==TRUE){
    echo "<div id='AppDetalle'>".app_detalle($id_aplicacion, $nitavu)."</div>";        
    xd_update($id_aplicacion,$nitavu); historia($nitavu, $id_aplicacion." | Entro a la CAJA");
    //echo "<input type='hidden' name='nitavu' id='nitavu' value='".$nitavu."'>";
   /*  if(isset($_POST['GuardaD'])){
        $sql='INSERT INTO encuesta_satisfactoria (CURP, NumContrato, Telefono, Dependencia, Tramite, P1_TratoRecibido, P2_Informacion, P3_Instalaciones, P4_SatisfechoconelServicio, P5_SolicitaronDinero, P6_Discriminacion, P6_AdultoMayor, P6_Afrodescendiente, P6_CreenciasReligiosas, P6_Migrante, P6_Hombre, P6_Mujer, P6_Discapacidad, P6_VIH, P6_PreferenciaSexual, P6_Joven, P6_TrabajadoraHogar, P6_IdeasPoliticas, P6_Otro, P7_Timpo, P7_Ampliarhorarios, P7_NoTantosRequisitos, P7_TramiteporInternet, P7_UnaSolaPersona, P7_CapacitacionPersonal, P7_SolucionQuejas, P7_PersonalAmable, P7_InformacionConsistente, P7_FormatosSencillos, P7_Otra, Ocupacion, Fecha, NombreBeneficiario, Capturista, Genero, Edad, FechaNacimiento, Delegacion, Programa, Folio, DelegCaptura) VALUES ("COAA630614MTSNLL02","06784101253", "8344264960", "itavu", "xxx", "5", "4", "4", "1", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0","", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "", "xxx",NOW(), "ALMA LETICIA CONTRERAS ALVAREZ", "1308", "M", "60", "1963-06-14", "2", "124", "123", "2")';
        if ($conexion->query($sql) == TRUE){
            echo $sql;
            Toast("Se ha guardado la información correctamente TTT",0,""); 
           // mensaje("Se ha guardado la información correctamente TTT.","encuestaSatisfaccion2.php");
        }else{
            echo $sql;
            mensaje("Ocurrio un error, favor de intentarlo nuevamente TTT ". $sql,"encuestaSatisfaccion2.php"); 
        }

    } */

    $sql='INSERT INTO encuesta_satisfactoria (CURP, NumContrato, Telefono, Dependencia, Tramite, P1_TratoRecibido, P2_Informacion, P3_Instalaciones, P4_SatisfechoconelServicio, P5_SolicitaronDinero, P6_Discriminacion, P6_AdultoMayor, P6_Afrodescendiente, P6_CreenciasReligiosas, P6_Migrante, P6_Hombre, P6_Mujer, P6_Discapacidad, P6_VIH, P6_PreferenciaSexual, P6_Joven, P6_TrabajadoraHogar, P6_IdeasPoliticas, P6_Otro, P7_Timpo, P7_Ampliarhorarios, P7_NoTantosRequisitos, P7_TramiteporInternet, P7_UnaSolaPersona, P7_CapacitacionPersonal, P7_SolucionQuejas, P7_PersonalAmable, P7_InformacionConsistente, P7_FormatosSencillos, P7_Otra, Ocupacion, Fecha, NombreBeneficiario, Capturista, Genero, Edad, FechaNacimiento, Delegacion, Programa, Folio, DelegCaptura) VALUES ("COAA630614MTSNLL02","06784101253", "8344264960", "itavu", "xxx", "5", "4", "4", "1", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0","", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "", "xxx",NOW(), "ALMA LETICIA CONTRERAS ALVAREZ", "1308", "M", "60", "1963-06-14", "8", "124", "123", "8")';
    $conexion->query($sql) ;
        echo $sql;
        Toast("Se ha guardado la información correctamente TTT",0,""); 

    //para guardar y mostrar pdf para impresion y firma
    if(isset($_POST['guardar'])){
        $sql='INSERT INTO encuesta_satisfactoria (CURP, NumContrato, Telefono, Dependencia, Tramite, P1_TratoRecibido, P2_Informacion, P3_Instalaciones, P4_SatisfechoconelServicio, P5_SolicitaronDinero, P6_Discriminacion, P6_AdultoMayor, P6_Afrodescendiente, P6_CreenciasReligiosas, P6_Migrante, P6_Hombre, P6_Mujer, P6_Discapacidad, P6_VIH, P6_PreferenciaSexual, P6_Joven, P6_TrabajadoraHogar, P6_IdeasPoliticas, P6_Otro, P7_Timpo, P7_Ampliarhorarios, P7_NoTantosRequisitos, P7_TramiteporInternet, P7_UnaSolaPersona, P7_CapacitacionPersonal, P7_SolucionQuejas, P7_PersonalAmable, P7_InformacionConsistente, P7_FormatosSencillos, P7_Otra, Ocupacion, Fecha, NombreBeneficiario, Capturista, Genero, Edad, FechaNacimiento, Delegacion, Programa, Folio, DelegCaptura) VALUES ("COAA630614MTSNLL02","06784101253", "8344264960", "itavu", "xxx", "5", "4", "4", "1", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0","", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "", "xxx",NOW(), "ALMA LETICIA CONTRERAS ALVAREZ", "1308", "M", "60", "1963-06-14", "8", "124", "123", "8")';
        if ($conexion->query($sql) == TRUE){
            echo $sql;
            Toast("Se ha guardado la información correctamente TTT",0,""); 
           // mensaje("Se ha guardado la información correctamente TTT.","encuestaSatisfaccion2.php");
        }else{
            echo $sql;
            mensaje("Ocurrio un error, favor de intentarlo nuevamente TTT ". $sql,"encuestaSatisfaccion2.php"); 
        }

      /*   if(isset($_POST['CURP'])){
            $CURP = $_POST['CURP'];
            if(isset($_POST['Nombre'])){

                $Nombre = $_POST['Nombre'];
                $NumContrato = '';
                if(isset($_POST['NumContrato'])){
                    $NumContrato = $_POST['NumContrato'];
                }
                $Delegacion = "";
                if(isset($_POST['delegacion'])){
                    $Delegacion = $_POST['delegacion'];
                }
                $Programa = "";
                if(isset($_POST['programa'])){
                    $Programa = $_POST['programa'];
                }
                $Folio = "";
                if(isset($_POST['folio'])){
                    $Folio = $_POST['folio'];
                }

                //VALIDAMOS QUE ESTE LLENO EL NUM CONTRATO O EL FOLIO 
                if((empty($Folio) and $NumContrato <> "") or (empty($NumContrato) and $Folio <> "") or ($NumContrato<>"" and $Folio<>"")){
                    $telefono = $_POST['telefono'];
                    $entidad = $_POST['entidad'];
                    $tramite = $_POST['tramite'];
                    $preg1 = $_POST['preg1'];
                    $preg2 = $_POST['preg2'];
                    $preg3 = $_POST['preg3'];
                    $preg4 = $_POST['preg4'];
                    $preg5 = $_POST['preg5'];
                    $preg6 = $_POST['preg6'];

                    if(isset($_POST['preg6_1'])) { $preg6_1 = $_POST['preg6_1']; }else{ $preg6_1 = 0;}
                    if(isset($_POST['preg6_2'])) { $preg6_2 = $_POST['preg6_2']; }else{ $preg6_2 = 0;}
                    if(isset($_POST['preg6_3'])) { $preg6_3 = $_POST['preg6_3']; }else{ $preg6_3 = 0;}
                    if(isset($_POST['preg6_4'])) { $preg6_4 = $_POST['preg6_4']; }else{ $preg6_4 = 0;}
                    if(isset($_POST['preg6_5'])) { $preg6_5 = $_POST['preg6_5']; }else{ $preg6_5 = 0;}
                    if(isset($_POST['preg6_6'])) { $preg6_6 = $_POST['preg6_6']; }else{ $preg6_6 = 0;}
                    if(isset($_POST['preg6_7'])) { $preg6_7 = $_POST['preg6_7']; }else{ $preg6_7 = 0;}
                    if(isset($_POST['preg6_8'])) { $preg6_8 = $_POST['preg6_8']; }else{ $preg6_8 = 0;}
                    if(isset($_POST['preg6_9'])) { $preg6_9 = $_POST['preg6_9']; }else{ $preg6_9 = 0;}
                    if(isset($_POST['preg6_10'])) { $preg6_10 = $_POST['preg6_10']; }else{ $preg6_10 = 0;}
                    if(isset($_POST['preg6_11'])) { $preg6_11 = $_POST['preg6_11']; }else{ $preg6_11 = 0;}
                    if(isset($_POST['preg6_12'])) { $preg6_12 = $_POST['preg6_12']; }else{ $preg6_12 = 0;}
               
                    $otra6 = $_POST['otra6'];

                    if(isset($_POST['preg7_1'])) { $preg7_1 = $_POST['preg7_1']; }else{ $preg7_1 = 0;}
                    if(isset($_POST['preg7_2'])) { $preg7_2 = $_POST['preg7_2']; }else{ $preg7_2 = 0;}
                    if(isset($_POST['preg7_3'])) { $preg7_3 = $_POST['preg7_3']; }else{ $preg7_3 = 0;}
                    if(isset($_POST['preg7_4'])) { $preg7_4 = $_POST['preg7_4']; }else{ $preg7_4 = 0;}
                    if(isset($_POST['preg7_5'])) { $preg7_5 = $_POST['preg7_5']; }else{ $preg7_5 = 0;}
                    if(isset($_POST['preg7_6'])) { $preg7_6 = $_POST['preg7_6']; }else{ $preg7_6 = 0;}
                    if(isset($_POST['preg7_7'])) { $preg7_7 = $_POST['preg7_7']; }else{ $preg7_7 = 0;}
                    if(isset($_POST['preg7_8'])) { $preg7_8 = $_POST['preg7_8']; }else{ $preg7_8 = 0;}
                    if(isset($_POST['preg7_9'])) { $preg7_9 = $_POST['preg7_9']; }else{ $preg7_9 = 0;}
                    if(isset($_POST['preg7_10'])) { $preg7_10 = $_POST['preg7_10']; }else{ $preg7_10 = 0;}

               
                    $otra7 = $_POST['otra7'];

                    $ocupacion = $_POST['ocupacion'];
                    $genero = $_POST['Genero'];
                    $edad = $_POST['Edad'];
                    $fechaNacimiento = $_POST['FechaNacimiento'];
        
                    
               
            
                        $DelgCaptura = midelegacion_id($nitavu);
                        //UNA VEZ RECIBIDAS LAS VARIABLES DE RESPUESTAS VAMOS A GUARDAR
                        $sql = 'INSERT INTO encuesta_satisfactoria (CURP, NumContrato,  Telefono, Dependencia, Tramite, P1_TratoRecibido, P2_Informacion, P3_Instalaciones, P4_SatisfechoconelServicio, P5_SolicitaronDinero,
                        P6_Discriminacion, P6_AdultoMayor, P6_Afrodescendiente, P6_CreenciasReligiosas, P6_Migrante, P6_Hombre, P6_Mujer, P6_Discapacidad, P6_VIH, P6_PreferenciaSexual, P6_Joven, P6_TrabajadoraHogar, P6_IdeasPoliticas,
                        P6_Otro, P7_Timpo, P7_Ampliarhorarios, P7_NoTantosRequisitos, P7_TramiteporInternet, P7_UnaSolaPersona, P7_CapacitacionPersonal, P7_SolucionQuejas, P7_PersonalAmable, P7_InformacionConsistente, P7_FormatosSencillos,
                        P7_Otra, Ocupacion, Fecha, NombreBeneficiario, Capturista, Genero, Edad, FechaNacimiento, Delegacion, Programa, Folio, DelegCaptura)
                        VALUES ("'.$CURP.'","'.$NumContrato.'", "'.$telefono.'", "'.$entidad.'", "'.$tramite.'", "'.$preg1.'", "'.$preg2.'", "'.$preg3.'", "'.$preg4.'", "'.$preg5.'", 
                        "'.$preg6.'", "'.$preg6_1.'", "'.$preg6_2.'", "'.$preg6_3.'", "'.$preg6_4.'", "'.$preg6_5.'", "'.$preg6_6.'", "'.$preg6_7.'", "'.$preg6_8.'", "'.$preg6_9.'", "'.$preg6_10.'", "'.$preg6_11.'", "'.$preg6_12.'", 
                        "'.$otra6.'", "'.$preg7_1.'", "'.$preg7_2.'", "'.$preg7_3.'", "'.$preg7_4.'", "'.$preg7_5.'", "'.$preg7_6.'", "'.$preg7_7.'", "'.$preg7_8.'", "'.$preg7_9.'", "'.$preg7_10.'", "'.$otra7.'", "'.$ocupacion.'",NOW(), "'.$Nombre.'", "'.$nitavu.'", "'.$genero.'", "'.$edad.'", "'.$fechaNacimiento.'", "'.$Delegacion.'", "'.$Programa.'", "'.$Folio.'", "'.$DelgCaptura.'")';
                        //echo $sql;
                        if ($conexion->query($sql) == TRUE){
                            echo $sql;
                            //Toast("Se ha guardado la información correctamente TTT",0,""); 
                            mensaje("Se ha guardado la información correctamente TTT.","encuestaSatisfaccion2.php");
                        }else{
                            echo $sql;
                            mensaje("Ocurrio un error, favor de intentarlo nuevamente TTT ". $sql,"encuestaSatisfaccion2.php"); 
                        }
                  //  }

                }else{
                    
                    mensaje('Debe llenar el NumContrato o Folio de la solicitud.', 'encuestaSatisfaccion.php');
                }


               
            }else{
                mensaje('ERROR: No se recibio información del NOMBRE correctamente, intentelo de nuevo.','encuestaSatisfaccion.php');
            }
        }else{
            mensaje('ERROR: No se recibio información del CURP correctamente, intentelo de nuevo.','encuestaSatisfaccion.php');
        } */


       

    }else{
        
        echo "<center><div style='width:80%;'>";
       
        //echo "<h3>ENCUESTA DE SATISFACCION</h3>";
        echo '<div class="card" style="text-align: justify; width:100%;">
        <h1 class="card-header h5" style="color: chocolate;">Encuesta de Satisfacción TTT</h1>';
       
            echo '<div class="card-body" style="width:100%;">';  

            


     /*        echo "<table width=100%>";
        echo "<tr>";
        echo "<td style='text-align-last: left';></td>";
        echo "<td align=right>";
     
       echo '<input style="width:30%;" class="btn-identidad-color1" name="GuardaD" type="submit" value="GuardaD">';
     
        echo "</td>";
        echo "</tr>";
        echo "</table>";
 */



        echo "<table width=100%>
        <tr>";
        echo "<td width=50%>";
        echo "<table width=100%><tr><td valign=top>";
            echo "<input required ='required'type='text' style='height:55px; margin:0px; font-size:19pt;' id='_curp' name='_curp' value='' maxlength='18' onkeyup='mayus(this);' placeholder='CURP del Solicitante' required></td>";
            echo "<td valign=top><button onclick='CURP_persona(".$nitavu.");' style='height:50px; margin:0px;' title='Clic para buscar los datos de la persona' class='btn-identidad-color1'>
            <img src='icon/btn_derecha.png' style='width:30px' id='flecha'>
            <img src='img/loader_bar.gif' style='width:30px; display:none;' id='LoaderCurp'></button></td></tr></table>";
        echo "</td>";
        echo "<td width=50%>";
        echo "<form action='encuestaSatisfaccion.php' method='POST'>";
        echo "<div id='Persona'  style='width: 100%;'>";
        echo "</div>";
        echo "</td>";
        echo "</tr>";
        echo "<tr>";
        echo "<td style='padding: 10px;'>";
                echo "<label>Teléfono</label>";
                echo '<div class="input-group mb-3">
                <input type="text" name="telefono" id="telefono" maxlength="10" class="form-control" placeholder="Tel. fijo o celular" aria-label="Número de contrato del beneficiario" aria-describedby="basic-addon1" required>
            </div>';
            echo "</td>";   
            echo "<td style='padding: 10px; width:40%;'>";
                echo "<label>NumContrato</label>";
                echo '<div class="input-group mb-3">
                <input type="text" name="NumContrato" id="NumContrato" class="form-control" placeholder="Número de contrato del beneficiario" aria-label="Número de contrato del beneficiario" aria-describedby="basic-addon1">
            </div>';
            echo "</td>";         
        echo "</tr>";

        echo "<tr>";
            
            echo "<td colspan='2' style='padding: 10px; width:60%; text-align:center'>";
            echo "<label>En caso de no contrar con un Número de contrato, favor de llenar el número de folio de la solicitud de este beneficiario.</label>";
            echo "<table><tr><td style='padding: 10px; width:40%;'>";
                echo "<label>Delegación</label>";
                echo ' <select class="form-control" name="delegacion" id="delegacion" >';
                $sql = "SELECT * FROM delegaciones WHERE Tipo = 0 ORDER BY Delegacion ASC";
                $r = $Vivienda -> query($sql);
                echo "<option value=''>Seleccione una opcion</option>";
                while($f = $r -> fetch_array())
                { // resultado de la busqueda.................
                    echo "<option value='".$f['IdDelegacion']."'>".$f['Delegacion']. "</option>";
                }
                //$iddepa=nitavu_dpto($nitavu);
                //$mideleg=midelegacionconid($nitavu);                
                //$depa=nitavu_dpto_nombre( $nitavu);

                $midelegid=midelegviviendaid($nitavu);
                //$midelegnom=midelegviviendanombre($nitavu);               
                //if(midelegacionconid($nitavu)!= 'OFICINAS CENTRALES'){
                if(midelegviviendaid($nitavu)!= 'OFICINAS CENTRALES'){
                    echo "<option value='".$midelegid."' selected>".buscaidconceptocxviv('Delegacion', 'delegaciones','IdDelegacion', $midelegid  )."</option>";
                }
                // $campo, $tabla,$campoigual, $idconcepto
                
                echo ' </select>';
            echo "</td>";
            echo "<td style='padding: 10px; width:40%;'>";
                echo "<label>Programa</label>";
                echo ' <select class="form-control" name="programa" id="programa" >';
                $sql = "SELECT * FROM programa ORDER BY Programa ASC";
                $r = $Vivienda -> query($sql);
                echo "<option value=''>Seleccione una opcion</option>";
                while($f = $r -> fetch_array())
                { // resultado de la busqueda.................
                    echo "<option value='".$f['IdPrograma']."'>".$f['Programa']. "</option>";
                }
                echo ' </select>';
            echo "</td>";
            echo "<td style='padding: 10px; width:20%;'>";
                echo "<label>Folio</label>";
                echo '<div class="input-group mb-3">
                <input type="text" name="folio" id="folio"  class="form-control" placeholder="Folio" aria-label="Número de contrato del beneficiario" aria-describedby="basic-addon1">
            </div>';
            echo "</td></tr></table>";
            echo "</td>";
        echo "</tr>";
       
      
        echo "<tr>";
        
        echo "<td style='padding: 10px;' colspan='2'>";
            echo "<label>Dependencia / Entidad</label>";
            echo '<div class="input-group mb-3">
            <input type="text" name="entidad" id="entidad" maxlength="10" class="form-control" placeholder="Entidad" aria-label="Número de contrato del beneficiario" aria-describedby="basic-addon1" required>
        </div>';
        echo "</td>";
    echo "</tr>";

        echo '<tr><td colspan="2" style="text-align:center; font-size:20px; background-color: #990000; color: white; padding: 20px;" >';
                    echo "<b>ENCUESTA DE SATISFACCIÓN CIUDADANA A TRÁMITES Y SERVICIOS 2023.</b>";
                    
        echo "<td></tr>";
        echo "<tr><td colspan='2'></td></tr>";
        echo '<tr><td colspan="2" style="text-align:center;">';
                    echo "<label>Para elevar la calidad de nuestros servicios y atenderle mejor, le pedimos colaborar con nosotros, contestando <b>libremente la atención recibida.</b></label>";
        echo "<td></tr>";
        echo '<tr><td colspan="2"><label>Nombre del trámite o servicio:</label><input name="tramite" id="tramite"></td>';
        echo "</tr>";

        echo "<tr>";
            echo "<td style='padding: 10px;'>";
                
                echo '<label>1. El trato que recibió por parte de los servidores públicos que la atendieron fue:</label>';
                    echo ' <select class="form-control" id="exampleFormControlSelect1" name="preg1" id="preg1" required>';
                    $sql = "SELECT * FROM cat_encuestaaspectos";
                    $r = $conexion -> query($sql);
                    echo "<option value='99'>Seleccione una opcion</option>";
                    while($f = $r -> fetch_array())
                    { // resultado de la busqueda.................
                        echo "<option value='".$f['IdOpcion']."'>".$f['Opcion']. "</option>";
                    }
                    echo ' </select>';

            echo "</td>";
            echo "<td style='padding: 10px;'>";
                echo "";
                echo '<label >2. La información para realizar este trámite fue:</label>';
                echo ' <select class="form-control" id="exampleFormControlSelect1" name="preg2" id="preg2" required>';
                    $sql = "SELECT * FROM cat_encuestaaspectos";
                    $r = $conexion -> query($sql);
                    echo "<option value='99'>Seleccione una opcion</option>";
                    while($f = $r -> fetch_array())
                    { // resultado de la busqueda.................
                        echo "<option value='".$f['IdOpcion']."'>".$f['Opcion']. "</option>";
                    }
                    echo ' </select>';
            echo "</td>";
        echo "</tr>";

        echo "<tr>";
            echo "<td style='padding: 10px;'>";
                
                echo '<label>3. Las instalaciones o medios donde le atendieron son:</label>';
                    echo ' <select class="form-control" id="exampleFormControlSelect1" name="preg3" id="preg3" required>';
                    $sql = "SELECT * FROM cat_encuestaaspectos";
                    $r = $conexion -> query($sql);
                    echo "<option value='99'>Seleccione una opcion</option>";
                    while($f = $r -> fetch_array())
                    { // resultado de la busqueda.................
                        echo "<option value='".$f['IdOpcion']."'>".$f['Opcion']. "</option>";
                    }
                    echo ' </select>';

            echo "</td>";
            echo "<td style='padding: 10px;'>";
                echo "";
                echo '<label for="preg4">4.¿Está satisfecho con el servicio recibido al realizar el trámite?</label>';
                echo "<br>";
                echo '<div class="form-check form-check-inline">
                    <label class="radio-inline">
                    <input type="radio" name="preg4" value="1">Si
                    </label>
                    <label class="radio-inline">
                    <input type="radio" name="preg4" value="0">No
                    </label>';
            echo "</td>";
            
        echo "</tr>";

     
        echo "<tr>";
            echo "<td style='padding: 10px;'>";
                echo "";
                echo '<label for="preg5">5.¿Observó que algún servidor público indebidamente solicitó a un ciudadano dinero o dádivas?</label>';
                echo "<br>";
                echo '<div class="form-check form-check-inline">
                    <label class="radio-inline">
                    <input type="radio" name="preg5" value="1">Si
                    </label>
                    <label class="radio-inline">
                    <input type="radio" name="preg5" value="0">No
                    </label>';
            echo "</td>";
            echo "<td style='padding: 10px;'>";
                echo "";
                echo '<label for="preg6">6.¿Al realizar el trámite, sintió discriminación en algún momento?</label>';
                echo "<br>";
                echo '<div class="form-check form-check-inline">
                    <label class="radio-inline">
                    <input type="radio" name="preg6" value="1">Si
                    </label>
                    <label class="radio-inline">
                    <input type="radio" name="preg6" value="0">No
                    </label>';
            echo "</td>";            
        echo "</tr>";

        echo "<tr>";
            echo "<td style='padding: 10px;' colspan='2'>";
            echo '<label for="preg6_1">En caso de contestar afirmativamente la pregunta anterior, por favor señale la probable causa de tal situación:</label>';
            echo "<table><tr><td>";
                    echo '<div class="form-check">
                            <input class="form-check-input" type="checkbox" value="1" id="preg6_1" name="preg6_1">
                            <label class="form-check-label" for="preg6_1">
                                Por ser una persona adulta mayor
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="1" id="preg6_2" name="preg6_2">
                            <label class="form-check-label" for="preg6_2">
                                Por ser afrodescendiente
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="1" id="preg6_3" name="preg6_3" >
                            <label class="form-check-label" for="preg6_3">
                                Por mis creencias religosas
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="1" id="preg6_4" name="preg6_4" >
                            <label class="form-check-label" for="preg6_4">
                                Por ser migrante
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="1" id="preg6_5" name="preg6_5" >
                            <label class="form-check-label" for="preg6_5">
                                Por ser hombre
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="1" id="preg6_6" name="preg6_6">
                            <label class="form-check-label" for="preg6_6">
                                Por ser mujer
                            </label>
                        </div>
                        ';
                    echo "</td>";
                    echo "<td>";
                    echo '<div class="form-check">
                    <input class="form-check-input" type="checkbox" value="1" id="preg6_7" name="preg6_7">
                    <label class="form-check-label" for="preg6_7">
                        Por ser una persona con discapacidad
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="1" id="preg6_8" name="preg6_8">
                    <label class="form-check-label" for="preg6_8">
                        Por ser una persona que vive con VIH o SIDA
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="1" id="preg6_9" name="preg6_9">
                    <label class="form-check-label" for="preg6_9">
                        Por mi preferencia sexual
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="1" id="preg6_10"  name="preg6_10">
                    <label class="form-check-label" for="preg6_10">
                        Por ser joven
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="1" id="preg6_11" name="preg6_11">
                    <label class="form-check-label" for="preg6_11">
                        Por ser una persona trabajadora del hogar
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="1" id="preg6_12" name="preg6_12" >
                    <label class="form-check-label" for="preg6_12">
                        Por mis ideas políticas
                    </label>
                </div>
                ';
                echo "</td></tr></table>";
                echo "<label>Otra indicar cual:</label> <input type='text' name='otra6' id='otra6' >";
            echo "</td>";
           

        echo "</tr>";

        echo "<tr>";

        echo "<td style='padding: 10px;' colspan='2'>";
        echo '<label for="preg7">7. ¿Qué sugiere para mejorar el servicio?</label>';
        echo "<table><tr><td>";
                echo '<div class="form-check">
                        <input class="form-check-input" type="checkbox" value="1" id="preg7_1" name="preg7_1">
                        <label class="form-check-label" for="preg7_1">
                            Que no se tarden tanto tiempo
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="1" id="preg7_2" name="preg7_2">
                        <label class="form-check-label" for="preg7_2">
                            Ampliar los horarios de servicios
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="1" id="preg7_3" name="preg7_3" >
                        <label class="form-check-label" for="preg7_3">
                            No pidan tantos requisitos
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="1" id="preg7_4"name="preg7_4"  >
                        <label class="form-check-label" for="preg7_4">
                            Que el trámite se realice por internet
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="1" id="preg7_5" name="preg7_5" >
                        <label class="form-check-label" for="preg7_5">
                            Que una sola persona me atienda y resuelva 
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="1" id="preg7_6" name="preg7_6">
                        <label class="form-check-label" for="preg7_6">
                            Que capaciten al personal para eliminar los errores
                        </label>
                    </div>
                    ';
                echo "</td>";
                echo "<td>";
                echo '<div class="form-check">
                <input class="form-check-input" type="checkbox" value="1" id="preg7_7" name="preg7_7">
                <label class="form-check-label" for="preg7_7">
                    Que alguien solucione las quejas
                </label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" value="1" id="preg7_8" name="preg7_8" >
                <label class="form-check-label" for="preg7_8">
                    Personal más amable
                </label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" value="1" id="preg7_9" name="preg7_9">
                <label class="form-check-label" for="preg7_9">
                    Que la información sea consistente (ventanilla, portal, tríptico)
                </label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" value="1" id="preg7_10"  name="preg7_10">
                <label class="form-check-label" for="preg7_10">
                    Que los formatos sean sencillos
                </label>
            </div>
            
            ';
            echo "</td></tr></table>";
            echo "<label>Otra. Especifique:</label> <input type='text' name='otra7' id='otra7'>";

        echo "</td>";          
        echo "</tr>";

        echo "<tr>";
            echo '<td style="padding: 10px;" colspan="2">';
                echo '<label>Información opcional-Ocupación:</label>';
                echo '<input type="text" name="ocupacion" id="ocupacion">';
            echo "</td>";
        echo "</tr>";

        

       // echo '<tr><td colspan="2" style="text-align:center;"><input style="width:30%;" class="btn-identidad-color1" name="guardar" type="submit" value="Guardar"></td></tr>';
        echo '<tr><td colspan="2" style="text-align:center;"><input style="width:30%;" class="btn-identidad-color1" name="guardar" type="submit" value="guardar"></td></tr>';
       
        
        echo "</table>";
        echo "</form>";
        echo "</div></div>";
        
        echo "</div></center>";

    
    }

} else {mensaje("ERROR: no tienes acceso a este modulo","");}


?>

<script>
function CURP_persona(nitavu){
var curp = $('#_curp').val();

$('#txtCurp').val(curp);
console.log(curp);
len =  $('#_curp').val().length;
if(len == 18 ){
    $("#flecha").hide();
    $("#LoaderCurp").show();

    $.ajax({
    url: "en_datosCurp.php",
    type: "get",        
    data: {curp:curp,nitavu:nitavu},
    success: function(data){   
    $('#Persona').html(data);
    
        $("#flecha").show();
        $("#LoaderCurp").hide();

    
        
    }
    }); 
}else{
    NPush('Faltan carácteres para ser una CURP válida.', 'Plataforma ITAVU');
}
}

function mayus(e) {
    e.value = e.value.toUpperCase();
}

</script>

<?php include ("lib/body_footer.php"); ?>

