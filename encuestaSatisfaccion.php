<?php
    include ("lib/body_head.php");
    require_once('lib/laura_funciones.php');
    require_once('lib/funciones.php');
    // include ("lib/body_menu.php");
    //No tiene menu vertical
?>
<script>
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

//***aqui para validar campos */
function validar_numeros(string) {
    for (var i=0, output='', validos="1234567890"; i<string.length; i++)
       if (validos.indexOf(string.charAt(i)) != -1)
          output += string.charAt(i)
    return output;
} 
function validar_letras(string) {
    for (var i=0, output='', validos="1234567890"; i<string.length; i++)
       if (validos.indexOf(string.charAt(i)) != -1)
          output += string.charAt(i)
    return output;
} 

function validar_letrasynumeros(string) {
    for (var i=0, output='', validos="1234567890"; i<string.length; i++)
       if (validos.indexOf(string.charAt(i)) != -1)
          output += string.charAt(i)
    return output;
} 

function validar_letrasynumyespeciales(string) {
    for (var i=0, output='', validos="1234567890abcdefghijklmnñopqrstuvwxyzABCDEFGHIJKLMNÑOPQRSTUVWXYZ-/ "; i<string.length; i++)
       if (validos.indexOf(string.charAt(i)) != -1)
          output += string.charAt(i)
    return output;
} 

//onChange="this.value=validar_letrasynumyespeciales(this.value)"
/** */

</script>
<?php

    
$id_aplicacion ="ap116"; $nivel = aplicacion_nivel($id_aplicacion, $nitavu);
$nivel =aplicacion_nivel($id_aplicacion, $nitavu);

 if (sanpedro($id_aplicacion, $nitavu)==TRUE){
    echo "<div id='AppDetalle'>".app_detalle($id_aplicacion, $nitavu)."</div>";        
    xd_update($id_aplicacion,$nitavu); historia($nitavu, $id_aplicacion." | Entro a la CAJA");
    //echo "<input type='hidden' name='nitavu' id='nitavu' value='".$nitavu."'>";

    //para guardar y mostrar pdf para impresion y firma
    if(isset($_POST['guardar'])){
        if(isset($_POST['CURP'])){
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
                    /*$preg6_2 = $_POST['preg6_2'];
                    $preg6_3 = $_POST['preg6_3'];
                    $preg6_4 = $_POST['preg6_4'];
                    $preg6_5 = $_POST['preg6_5'];
                    $preg6_6 = $_POST['preg6_6'];
                    $preg6_7 = $_POST['preg6_7'];
                    $preg6_8 = $_POST['preg6_8'];
                    $preg6_9 = $_POST['preg6_9'];
                    $preg6_10 = $_POST['preg6_10'];
                    $preg6_11 = $_POST['preg6_11'];
                    $preg6_12 = $_POST['preg6_12'];*/
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

                    /*$preg7_2 = $_POST['preg7_2'];
                    $preg7_3 = $_POST['preg7_3'];
                    $preg7_4 = $_POST['preg7_4'];
                    $preg7_5 = $_POST['preg7_5'];
                    $preg7_6 = $_POST['preg7_6'];
                    $preg7_7 = $_POST['preg7_7'];
                    $preg7_8 = $_POST['preg7_8'];
                    $preg7_9 = $_POST['preg7_9'];
                    $preg7_10 = $_POST['preg7_10'];*/
                    $otra7 = $_POST['otra7'];

                    $ocupacion = $_POST['ocupacion'];
                    $genero = $_POST['Genero'];
                    $edad = $_POST['Edad'];
                    $fechaNacimiento = $_POST['FechaNacimiento'];
        
                    
                    //COMPROBAMOS QUE NO HAYA RELIZADO UNA ENCUESTA DE ESTE NUM CONTRATO 
                  /*  if(siExisteEncuestaRealizada($CURP, $NumContrato) == TRUE){
                        mensaje("Anteriormente se ha contestado una encuesta de satisfacción para este contrato ".$NumContrato.", por lo tanto ya no es necesario realizarla.","encuestaSatisfaccion.php"); 
            
                    }else{*/
            
                        $DelgCaptura = midelegacion_id($nitavu);
                        //UNA VEZ RECIBIDAS LAS VARIABLES DE RESPUESTAS VAMOS A GUARDAR
                        $sql = 'INSERT INTO encuesta_satisfactoria (CURP, NumContrato,  Telefono, Dependencia, Tramite, P1_TratoRecibido, P2_Informacion, P3_Instalaciones, P4_SatisfechoconelServicio, P5_SolicitaronDinero, P6_Discriminacion, P6_AdultoMayor, P6_Afrodescendiente, P6_CreenciasReligiosas, P6_Migrante, P6_Hombre, P6_Mujer, P6_Discapacidad, P6_VIH, P6_PreferenciaSexual, P6_Joven, P6_TrabajadoraHogar, P6_IdeasPoliticas, P6_Otro, P7_Timpo, P7_Ampliarhorarios, P7_NoTantosRequisitos, P7_TramiteporInternet, P7_UnaSolaPersona, P7_CapacitacionPersonal, P7_SolucionQuejas, P7_PersonalAmable, P7_InformacionConsistente, P7_FormatosSencillos, P7_Otra, Ocupacion, Fecha, NombreBeneficiario, Capturista, Genero, Edad, FechaNacimiento, Delegacion, Programa, Folio, DelegCaptura) VALUES ("'.$CURP.'","'.$NumContrato.'", "'.$telefono.'", "'.$entidad.'", "'.$tramite.'", "'.$preg1.'", "'.$preg2.'", "'.$preg3.'", "'.$preg4.'", "'.$preg5.'", "'.$preg6.'", "'.$preg6_1.'", "'.$preg6_2.'", "'.$preg6_3.'", "'.$preg6_4.'", "'.$preg6_5.'", "'.$preg6_6.'", "'.$preg6_7.'", "'.$preg6_8.'", "'.$preg6_9.'", "'.$preg6_10.'", "'.$preg6_11.'", "'.$preg6_12.'","'.$otra6.'", "'.$preg7_1.'", "'.$preg7_2.'", "'.$preg7_3.'", "'.$preg7_4.'", "'.$preg7_5.'", "'.$preg7_6.'", "'.$preg7_7.'", "'.$preg7_8.'", "'.$preg7_9.'", "'.$preg7_10.'", "'.$otra7.'", "'.$ocupacion.'",NOW(), "'.$Nombre.'", "'.$nitavu.'", "'.$genero.'", "'.$edad.'", "'.$fechaNacimiento.'", "'.$Delegacion.'", "'.$Programa.'", "'.$Folio.'", "'.$DelgCaptura.'")';

/* $sql = 'INSERT INTO encuesta_satisfactoria (CURP, NumContrato,  Telefono, Dependencia, Tramite, P1_TratoRecibido, P2_Informacion, P3_Instalaciones, P4_SatisfechoconelServicio, P5_SolicitaronDinero, P6_Discriminacion, P6_AdultoMayor, P6_Afrodescendiente, P6_CreenciasReligiosas, P6_Migrante, P6_Hombre, P6_Mujer, P6_Discapacidad, P6_VIH, P6_PreferenciaSexual, P6_Joven, P6_TrabajadoraHogar, P6_IdeasPoliticas, P6_Otro, P7_Timpo, P7_Ampliarhorarios, P7_NoTantosRequisitos, P7_TramiteporInternet, P7_UnaSolaPersona, P7_CapacitacionPersonal, P7_SolucionQuejas, P7_PersonalAmable, P7_InformacionConsistente, P7_FormatosSencillos,
P7_Otra, Ocupacion, Fecha, NombreBeneficiario, Capturista, Genero, Edad, FechaNacimiento, Delegacion, Programa, Folio, DelegCaptura)
VALUES ("'.$CURP.'","'.$NumContrato.'", "'.$telefono.'", "'.$entidad.'", "'.$tramite.'", "'.$preg1.'", "'.$preg2.'", "'.$preg3.'", "'.$preg4.'", "'.$preg5.'", "'.$preg6.'", "'.$preg6_1.'", "'.$preg6_2.'", "'.$preg6_3.'", "'.$preg6_4.'", "'.$preg6_5.'", "'.$preg6_6.'", "'.$preg6_7.'", "'.$preg6_8.'", "'.$preg6_9.'", "'.$preg6_10.'", "'.$preg6_11.'", "'.$preg6_12.'","'.$otra6.'", "'.$preg7_1.'", "'.$preg7_2.'", "'.$preg7_3.'", "'.$preg7_4.'", "'.$preg7_5.'", "'.$preg7_6.'", "'.$preg7_7.'", "'.$preg7_8.'", "'.$preg7_9.'", "'.$preg7_10.'", "'.$otra7.'", "'.$ocupacion.'",NOW(), "'.$Nombre.'", "'.$nitavu.'", "'.$genero.'", "'.$edad.'", "'.$fechaNacimiento.'", "'.$Delegacion.'", "'.$Programa.'", "'.$Folio.'", "'.$DelgCaptura.'")';
 */
                       // echo $sql;
                        if ($conexion->query($sql) == TRUE){
                            /*echo "<iframe src='en_pdf.php?CURP=".$CURP."&NumContrato=".$NumContrato."&Nombre=".$Nombre."&nitavu=".$nitavu."&telefono=".$telefono."&fecha=".$fecha."&municipio=".$municipio."' 
                        style='width:100%; height:150%; border: 0px solid black;' border=0></iframe>";
                            Toast("Se ha guardado la información correctamente",0,""); */
                            mensaje("Se ha guardado la información correctamente.","encuestaSatisfaccion.php");
                            //mensaje("Se ha guardado la información correctamente.".$sql,"encuestaSatisfaccion.php");
                        }else{
                            //mensaje("Ocurrio un error, favor de intentarlo nuevamente".$sql,"encuestaSatisfaccion.php"); 
                            mensaje("Ocurrio un error, favor de intentarlo nuevamente","encuestaSatisfaccion.php"); 
                        }
                  //  }

                }else{
                    
                    mensaje('Debe llenar el NumContrato o Folio de la solicitud.', 'encuestaSatisfaccion.php');
                }


               /* $Nombre = $_POST['Nombre'];
                $NumContrato = $_POST['NumContrato'];
                $telefono = $_POST['telefono'];
                $municipio = $_POST['municipio'];
                $localidad = $_POST['localidad'];
                
                $preg1 = $_POST['preg1'];
                
                if(isset($_POST['preg2'])){
                    $preg2 = $_POST['preg2'];
                }else{
                    $preg2 = "";
                }
                $preg3 = $_POST['preg3'];
                if(isset($_POST['preg4'])){
                    $preg4 = $_POST['preg4'];
                }else{
                    $preg4 = "";
                }
                
                $preg5_1 = $_POST['preg5_1'];
                $preg5_2 = $_POST['preg5_2'];
                $preg5_3 = $_POST['preg5_3'];
                $preg6 = $_POST['preg6'];
                $preg7 = $_POST['preg7'];
                
                //COMPROBAMOS QUE NO HAYA RELIZADO UNA ENCUESTA DE ESTE NUM CONTRATO 
                if(siExisteEncuestaRealizada($CURP, $NumContrato) == TRUE){
                    mensaje("Anteriormente se ha contestado una encuesta de satisfacción para este contrato ".$NumContrato.", por lo tanto ya no es necesario realizarla.","encuestaSatisfaccion.php"); 
        
                }else{
        
                    //UNA VEZ RECIBIDAS LAS VARIABLES DE RESPUESTAS VAMOS A GUARDAR
                    $sql = 'INSERT INTO encuesta_satisfactoria (CURP, NumContrato, 1_InformacionClara, 2_PidieronAlgoaCambio, 3_QuePidieron, 4_ClaridadenServicios,
                    5_AspectosAmabilidad, 5_AspectosActitudServicio, 5_AspectosLenguajeClaro, 6_ServicioRecibido, 7_DebeMejorarseelServicio, Fecha, NombreBeneficiario, Capturista, Telefono, IdMunicipio, Localidad)
                    VALUES ("'.$CURP.'","'.$NumContrato.'", "'.$preg1.'", "'.$preg2.'", "'.$preg3.'", "'.$preg4.'", "'.$preg5_1.'", "'.$preg5_2.'", "'.$preg5_3.'", "'.$preg6.'", "'.$preg7.'", NOW(), "'.$Nombre.'", "'.$nitavu.'", "'.$telefono.'", "'.$municipio.'", "'.$localidad.'")';
                    
                    //echo $sql;
                    if ($conexion->query($sql) == TRUE){
                        echo "<iframe src='en_pdf.php?CURP=".$CURP."&NumContrato=".$NumContrato."&Nombre=".$Nombre."&nitavu=".$nitavu."&telefono=".$telefono."&fecha=".$fecha."&municipio=".$municipio."' 
                    style='width:100%; height:150%; border: 0px solid black;' border=0></iframe>";
                        Toast("Se ha guardado la información correctamente",0,""); 
                    }else{
                        mensaje("Ocurrio un error, favor de intentarlo nuevamente","encuestaSatisfaccion.php"); 
                    }
                }*/
            }else{
                mensaje('ERROR: No se recibio información del NOMBRE correctamente, intentelo de nuevo.','encuestaSatisfaccion.php');
            }
        }else{
            mensaje('ERROR: No se recibio información del CURP correctamente, intentelo de nuevo.','encuestaSatisfaccion.php');
        }


       

    }else{
        
        echo "<center><div style='width:80%;'>";
       
        //echo "<h3>ENCUESTA DE SATISFACCION</h3>";
        echo '<div class="card" style="text-align: justify; width:100%;">
        <h1 class="card-header h5">Encuesta de Satisfacción</h1>';
       
            echo '<div class="card-body" style="width:100%;">';  
        //**boton regresa
        //$aniox=date("Y",$fecha);
        $aniox=2025;
        //$sqlreporte="Select  nombre,Fecha, CURP, NombreBeneficiario,Tramite,NumContrato,Delegacion,Programa, Folio, Capturista FROM encuesta_satisfactoria INNER JOIN   cat_delegaciones  ON encuesta_satisfactoria.Delegacion = cat_delegaciones.id where YEAR(Fecha)=".$aniox." and Delegacion=".midelegacion_id($nitavu)." ORDER BY fecha DESC";
        //$sqlreporte="SELECT nombre as Delegacion, Fecha, CURP, NombreBeneficiario, Tramite, NumContrato, cat_programa.programa, Folio, Capturista FROM encuesta_satisfactoria INNER JOIN cat_delegaciones ON encuesta_satisfactoria.Delegacion = cat_delegaciones.id INNER JOIN cat_programa ON encuesta_satisfactoria.Programa = cat_programa.IdPrograma WHERE YEAR(Fecha) = 2023 AND Delegacion =".midelegviviendaid($nitavu)." ORDER BY fecha DESC"
        $sqlreporte="SELECT	nombre AS Delegacion, Fecha, CURP, NombreBeneficiario, Tramite, NumContrato, cat_programa.Programa, Folio, Capturista FROM	encuesta_satisfactoria	LEFT JOIN	cat_delegaciones	ON 		encuesta_satisfactoria.Delegacion = cat_delegaciones.id	LEFT JOIN	cat_programa	ON 		encuesta_satisfactoria.Programa = cat_programa.IdPrograma WHERE	YEAR(Fecha) =".$aniox." AND	Delegacion =".midelegviviendaid($nitavu)." ORDER BY	fecha DESC";
        //guardareporte(2,$sqlreporte,$nitavu, "", "",$aniox ,"","produccion_itavu" );
        guardareporte(4,$sqlreporte,$nitavu, "", "",$aniox ,"","produccion_itavu" );


        echo "<table width=100%>";
        echo "<tr>";
        echo "<td style='text-align-last: left';></td>";
        echo "<td align=right>";

        echo "<a  class='btn btn-danger' href='excel_export.php?n=4'>Reporte</a>";
        echo "</td>";
        echo "</tr>";
        echo "</table>";

        //** */
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
                <input type="text" name="telefono" id="telefono" maxlength="10" class="form-control" onChange="this.value=validar_numeros(this.value)" placeholder="Tel. fijo o celular, solo números" aria-label="Número de contrato del beneficiario" aria-describedby="basic-addon1" required>
            </div>';
            echo "</td>";   
            echo "<td style='padding: 10px; width:40%;'>";
                echo "<label>NumContrato</label>";
                echo '<div class="input-group mb-3">
                <input type="text" name="NumContrato" id="NumContrato" class="form-control" onChange="this.value=validar_numeros(this.value)" placeholder="Número de contrato del beneficiario, solo números" aria-label="Número de contrato del beneficiario" aria-describedby="basic-addon1">
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
                <input type="text" name="folio" id="folio"  class="form-control" onChange="this.value=validar_numeros(this.value)" placeholder="Folio" aria-label="Número de contrato del beneficiario" aria-describedby="basic-addon1">
            </div>';
            echo "</td></tr></table>";
            echo "</td>";
        echo "</tr>";
       
      /*  echo "<tr>";
            echo "<td style='padding: 10px;'>";
                echo "<label>Municipio</label>";
                echo ' <select class="form-control" name="municipio" id="municipio" required>';
                $sql = "SELECT * FROM cat_municipios";
                $r = $conexion -> query($sql);
                echo "<option value=''>Seleccione una opcion</option>";
                while($f = $r -> fetch_array())
                { // resultado de la busqueda.................
                    echo "<option value='".$f['IdMunicipio']."'>".$f['municipio']. "</option>";
                }
                echo ' </select>';
            echo "</td>";
            echo "<td style='padding: 10px;'>";
                // echo "<label>Localidad</label>";
                //echo ' <select class="form-control" name="localidad" id="localidad">';
                //onkeypress="mostrarLocalidades(id)"
                //echo ' </select>';
                echo '<label for="localidad">Localidad</label>';
                echo '<input list="localidades"  name="localidad" id="localidad" required>';
            echo "</td>";
        echo "</tr>";

        echo "<tr>";
            echo "<td style='padding: 10px;'>";
                
                echo '<label for="preg1">1.-¿Le brindaron información clara y entendible?</label>';
                echo "<br>";
                echo '<div class="form-check form-check-inline">
                <label class="radio-inline">
                <input type="radio" name="preg1" value="1" required>Si
                </label>
                <label class="radio-inline">
                <input type="radio" name="preg1" value="0" required>No
                </label>';

            echo "</td>";
            echo "<td style='padding: 10px;'>";
                echo "";
                echo '<label for="preg2">2.-¿Le pidieron algo a cambio de otorgarle la información o el apoyo?</label>';
                echo '<div class="form-check form-check-inline">
                <label class="radio-inline">
                <input type="radio" name="preg2" value="1" required>Si (Ir a la pregunta 3)
                </label>
                <label class="radio-inline">
                <input type="radio" name="preg2" value="0" required>No (Ir a la pregunta 4)
                </label>';
            echo "</td>";
        echo "</tr>";
        echo "<tr>";
            echo "<td style='padding: 10px;'>";
                echo "<label>3.-¿Que le pidieron a cambio de otorgarle la información o el apoyo?</label>";
                echo ' <select class="form-control" id="exampleFormControlSelect1" name="preg3" id="preg3">';
                $sql = "SELECT * FROM cat_encuesta";
                $r = $conexion -> query($sql);
                echo "<option value=''>Seleccione una opcion</option>";
                while($f = $r -> fetch_array())
                { // resultado de la busqueda.................
                    echo "<option value='".$f['IdOpcion']."'>".$f['Opcion']. "</option>";
                }
                echo ' </select>';
            echo "</td>";
            echo "<td style='padding: 10px;'>";
            echo '<label for="preg4">4.-¿Existe claridad en los requisitos de los servicios que ofrece el ITAVU?</label><br>';
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
            echo '<td colspan="2" style="padding: 10px;">';
                echo "<label>5.-Califique los aspectos del servidor público que lo atendió</label>";
                echo "<table style='width:100%'><tr><td>";
                    echo "<label>Amabilidad</label>";
                    echo ' <select class="form-control" id="exampleFormControlSelect1" name="preg5_1" id="preg5_1" required>';
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
                    echo "<label>Actitud de Servicio</label>";
                    echo ' <select class="form-control" id="exampleFormControlSelect1" name="preg5_2" id="preg5_2" required>';
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
                    echo "<label>Lenguaje claro y sencillo</label>";
                    echo ' <select class="form-control" id="exampleFormControlSelect1" name="preg5_3" id="preg5_3" required>';
                    $sql = "SELECT * FROM cat_encuestaaspectos";
                    $r = $conexion -> query($sql);
                    echo "<option value='99'>Seleccione una opcion</option>";
                    while($f = $r -> fetch_array())
                    { // resultado de la busqueda.................
                        echo "<option value='".$f['IdOpcion']."'>".$f['Opcion']. "</option>";
                    }
                    echo ' </select>';
                echo "</td>";
                echo "</tr></table>";
            echo "</td>";
            
        echo "</tr>";
        echo "<tr>";
            echo "<td style='padding: 10px;'>";
                    echo "<label>6.-En general, califique el servicio recibido el día de hoy</label>";
                    echo ' <select class="form-control" id="exampleFormControlSelect1" name="preg6" id="preg6" required>';
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
            // echo "<label>7.-¿Qué cree que deba mejorarse para brindarle una mejor atención?</label>";
                echo '<div class="form-group">
                <label for="exampleFormControlTextarea2">7.-¿Qué cree que deba mejorarse para brindarle una mejor atención?</label>
                <textarea class="form-control rounded-0" id="exampleFormControlTextarea2" rows="3" name="preg7" required></textarea>
            </div>';
            echo "</td>";
            
        echo "</tr>";
        echo "<tr>";
            echo '<td colspan="2" style="padding: 10px;">';
            
                echo '<label>
                <b>*Aviso de Privacidad*</b><br>
                El titular de los datos personales podrá ejercer en todo momento su derecho de acceso, rectificación, cancelación y oposición de datos personales que proporcione, pudiendo ejercer en todo momento su derecho, físicamente en las oficinas del sujeto obligado ante quien se tramitó la solicitud en su domicilio oficial, o solicitarlo en la sección de transparencia de este mismo sitio
                web en la liga: http://www.sisaitamaulipas.org/sisaiTamaulipas/ o bien a través de la Plataforma Nacional de Transparencia (http://www.plataformadetransparencia.org.mx/).<br>
                    Lo anterior en cumplimiento a lo dispuesto en los artículos 1, 2, 3 fracción XII y XVIII, de la Ley de Transparencia y Acceso a la Información Pública del Estado de Tamaulipas; 3 fracción II, 27 y 28 de la Ley General de Protección de Datos Personales en Posesión de los Sujetos Obligado.
            </label>';
            echo "</td>";
            
        echo "</tr>";*/
        echo "<tr>";
        
        echo "<td style='padding: 10px;' colspan='2'>";
            echo "<label>Dependencia / Entidad</label>";
            echo '<div class="input-group mb-3">
            <input type="text" name="entidad" id="entidad" onChange="this.value=validar_letrasynumyespeciales(this.value)" maxlength="20" class="form-control" placeholder="Entidad" aria-label="Número de contrato del beneficiario" aria-describedby="basic-addon1" required>
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
        echo '<tr><td colspan="2"><label>Nombre del trámite o servicio:</label><input name="tramite" id="tramite" onChange="this.value=validar_letrasynumyespeciales(this.value)" placeholder="Escriba solo letras y números"></td>';
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
                            <label class="form-check-label" for="preg6_1" style="display: block;">
                                Por ser una persona adulta mayor
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="1" id="preg6_2" name="preg6_2">
                            <label class="form-check-label" for="preg6_2" style="display: block;">
                                Por ser afrodescendiente
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="1" id="preg6_3" name="preg6_3" >
                            <label class="form-check-label" for="preg6_3" style="display: block;">
                                Por mis creencias religosas
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="1" id="preg6_4" name="preg6_4" >
                            <label class="form-check-label" for="preg6_4" style="display: block;">
                                Por ser migrante
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="1" id="preg6_5" name="preg6_5" >
                            <label class="form-check-label" for="preg6_5" style="display: block;">
                                Por ser hombre
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="1" id="preg6_6" name="preg6_6">
                            <label class="form-check-label" for="preg6_6" style="display: block;">
                                Por ser mujer
                            </label>
                        </div>
                        ';
                    echo "</td>";
                    echo "<td>";
                    echo '<div class="form-check">
                    <input class="form-check-input" type="checkbox" value="1" id="preg6_7" name="preg6_7">
                    <label class="form-check-label" for="preg6_7" style="display: block;">
                        Por ser una persona con discapacidad
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="1" id="preg6_8" name="preg6_8">
                    <label class="form-check-label" for="preg6_8" style="display: block;">
                        Por ser una persona que vive con VIH o SIDA
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="1" id="preg6_9" name="preg6_9">
                    <label class="form-check-label" for="preg6_9" style="display: block;">
                        Por mi preferencia sexual
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="1" id="preg6_10"  name="preg6_10">
                    <label class="form-check-label" for="preg6_10" style="display: block;">
                        Por ser joven
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="1" id="preg6_11" name="preg6_11">
                    <label class="form-check-label" for="preg6_11" style="display: block;">
                        Por ser una persona trabajadora del hogar
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="1" id="preg6_12" name="preg6_12" >
                    <label class="form-check-label" for="preg6_12" style="display: block;">
                        Por mis ideas políticas
                    </label>
                </div>
                ';
                echo "</td></tr></table>";
                echo "<label>Otra indicar cual:</label> <input type='text' name='otra6' id='otra6' onChange='this.value=validar_letrasynumyespeciales(this.value)' placeholder='Escriba solo letras y números' >";
            echo "</td>";
           

        echo "</tr>";

        echo "<tr>";

        echo "<td style='padding: 10px;' colspan='2'>";
        echo '<label for="preg7">7. ¿Qué sugiere para mejorar el servicio?</label>';
        echo "<table width='80%'><tr><td>";
                echo '<div class="form-check">
                        <input class="form-check-input" type="checkbox" value="1" id="preg7_1" name="preg7_1">
                        <label class="form-check-label" for="preg7_1 style="display: block;"">
                            Que no se tarden tanto tiempo
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="1" id="preg7_2" name="preg7_2">
                        <label class="form-check-label" for="preg7_2" style="display: block;">
                            Ampliar los horarios de servicios
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="1" id="preg7_3" name="preg7_3" >
                        <label class="form-check-label" for="preg7_3" style="display: block;">
                            No pidan tantos requisitos
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="1" id="preg7_4"name="preg7_4"  >
                        <label class="form-check-label" for="preg7_4" style="display: block;">
                            Que el trámite se realice por internet
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="1" id="preg7_5" name="preg7_5" >
                        <label class="form-check-label" for="preg7_5" style="display: block;">
                            Que una sola persona me atienda y resuelva 
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="1" id="preg7_6" name="preg7_6">
                        <label class="form-check-label" for="preg7_6" style="display: block;">
                            Que capaciten al personal para eliminar los errores
                        </label>
                    </div>
                    ';
                echo "</td>";
                echo "<td>";
                echo '<div class="form-check">
                <input class="form-check-input" type="checkbox" value="1" id="preg7_7" name="preg7_7">
                <label class="form-check-label" for="preg7_7" style="display: block;">
                    Que alguien solucione las quejas
                </label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" value="1" id="preg7_8" name="preg7_8" >
                <label class="form-check-label" for="preg7_8" style="display: block;">
                    Personal más amable
                </label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" value="1" id="preg7_9" name="preg7_9">
                <label class="form-check-label" for="preg7_9" style="display: block;">
                    Que la información sea consistente (ventanilla, portal, tríptico)
                </label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" value="1" id="preg7_10"  name="preg7_10">
                <label class="form-check-label" for="preg7_10" style="display: block;">
                    Que los formatos sean sencillos
                </label>
            </div>
            
            ';
            echo "</td></tr></table>";
            echo "<label>Otra. Especifique:</label> <input type='text' name='otra7' id='otra7' onChange='this.value=validar_letrasynumyespeciales(this.value)' placeholder='Escriba solo letras y números'>";

        echo "</td>";          
        echo "</tr>";

        echo "<tr>";
            echo '<td style="padding: 10px;" colspan="2">';
                echo '<label>Información opcional-Ocupación:</label>';
                echo '<input type="text" name="ocupacion" id="ocupacion" onChange="this.value=validar_letrasynumyespeciales(this.value)"  placeholder="Escriba solo letras y números">';
            echo "</td>";
        echo "</tr>";

        

        echo '<tr><td colspan="2" style="text-align:center;"><input style="width:30%;" class="btn-identidad-color1" name="guardar" type="submit" value="Guardar"></td></tr>';
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

//$('.input-number').on('input', function () { 

//$('input[name=tramite]').change(function() { 
//$('#tramite').change(function(){
//document.getElementById("tramite").onChange = function()  {  
    $('#tramite').on('input', function () {     
	console.log ("entro");
	if ($("#tramite").text!='"'){
		console.log ("mal caracter");
	}else{
        console.log ("comillas");
    }
    //document.getElementById("TasaIntMora").select();    
   
   });
</script>

<?php include ("lib/body_footer.php"); ?>

