<?php
require("config.php");
require_once('lib/funciones.php');
require_once('pdf/tcpdf.php');
require_once('lib/flor_funciones.php');

$CURP = $_GET['CURP'];
if(isset($_GET['NumContrato'])){
    $NumContrato = $_GET['NumContrato'];
}

if(isset($_GET['Delegacion'])){
    $Delegacion = $_GET['Delegacion'];
}
if(isset($_GET['Programa'])){
    $Programa = $_GET['Programa'];
}
if(isset($_GET['Folio'])){
    $Folio = $_GET['Folio'];
}


    //historia($nitavu, 'Abro la encuesta satisfactoria de '.$Nombre.', curp: '.$CURP.' y NumContrato: '.$NumContrato.'.');
   
   
   
    $sql = "SELECT * FROM encuesta_satisfactoria WHERE CURP='".$CURP."' AND NumContrato ='".$NumContrato."'";
    $cuerpo ='';
    $r= $conexion -> query($sql);
    if ($r->num_rows>0){
        while($f = $r -> fetch_array()){
          /*  $cuerpo = '<table>
                <tr><td width="80%;">1.-El trato que recibió por parte de los servidores públicos que la atendieron fue:</td><td width="150px"><b>'.sino($f['1_InformacionClara']).'</b></td></tr>
                <tr><td width="80%;">2.-¿Le pidieron algo a cambio de otorgarle la información o el apoyo?</td><td width="150px"><b>'.sino($f['2_PidieronAlgoaCambio']).'</b></td></tr>
                <tr><td width="80%;">3.-¿Que le pidieron a cambio de otorgarle la información o el apoyo?</td><td width="150px"><b>'.RespuestaPidieronAlgo($f['3_QuePidieron']).'</b></td></tr>
                <tr><td width="80%;">4.-¿Existe claridad en los requisitos de los servicios que ofrece el ITAVU?</td><td width="150px"><b>'.sino($f['4_ClaridadenServicios']).'</b></td></tr>
                <tr><td width="80%;">5.-Califique los aspectos del servidor público que lo atendió</td><td width="150px"></td></tr>
                <tr><td width="80%;">Amabilidad</td><td width="150px"><b>'.RespuestaBuenoRegularMalo($f['5_AspectosAmabilidad']).'</b></td></tr>
                <tr><td width="80%;">Actitud de Servicio</td><td width="150px"><b>'.RespuestaBuenoRegularMalo($f['5_AspectosActitudServicio']).'</b></td></tr>
                <tr><td width="80%;">Lenguaje claro y sencillo</td><td width="150px"><b>'.RespuestaBuenoRegularMalo($f['5_AspectosLenguajeClaro']).'</b></td></tr>
                <tr><td width="80%;">6.-En general, califique el servicio recibido el día de hoy</td><td width="150px"><b>'.RespuestaBuenoRegularMalo($f['6_ServicioRecibido']).'</b></td></tr>
                <tr><td colspan="2">7.-¿Qué cree que deba mejorarse para brindarle una mejor atención?</td></tr>
                <tr><td colspan="2" ><b>'.$f['7_DebeMejorarseelServicio'].'</b></td></tr>
                <tr><td colspan="2"></td></tr>
                <tr><td colspan="2"></td></tr>
                <tr><td colspan="2"></td></tr>
                <tr><td colspan="2" width="100%;"><span style="font-size:9px; text-align: justify;">
                <b>*Aviso de Privacidad*</b><br>
                El titular de los datos personales podrá ejercer en todo momento su derecho de acceso, rectificación, cancelación y oposición de datos personales que proporcione, pudiendo ejercer en todo momento su derecho, físicamente en las oficinas del sujeto obligado ante quien se tramitó la solicitud en su domicilio oficial, o solicitarlo en la sección de transparencia de este mismo sitio
                web en la liga: http://www.sisaitamaulipas.org/sisaiTamaulipas/ o bien a través de la Plataforma Nacional de Transparencia (http://www.plataformadetransparencia.org.mx/).<br>
                    Lo anterior en cumplimiento a lo dispuesto en los artículos 1, 2, 3 fracción XII y XVIII, de la Ley de Transparencia y Acceso a la Información Pública del Estado de Tamaulipas; 3 fracción II, 27 y 28 de la Ley General de Protección de Datos Personales en Posesión de los Sujetos Obligado.
            </span></td></tr>

            </table>';*/

            if($f['Genero']=='M'){
                $genero = 'FEMENINO';
            }else{
                $genero = 'MASCULINO';
            }

            $titulosyfecha='
    
            <table>
                <tr>
                    <td bgcolor="#E7E7E7" colspan="2" align="center">
                    <b>ENCUESTA DE SATISFACCIÓN CIUDADANA A TRÁMITES Y SERVICIOS 2021.<br>
                    </b>
                    </td>
                </tr>
                <tr>
                    <td colspan="2" >
                    </td>
                </tr>
                <tr bgcolor="#E7E7E7">
                    <td >
                        Encuestado: <b>'.$f['NombreBeneficiario'].'</b>
                    </td>';

                    if($f['NumContrato']<>''){
                    $titulosyfecha= $titulosyfecha.'
                        <td>
                            NumContrato: <b>'.$f['NumContrato'].'</b>
                        </td>
                        </tr>';

                    }else{
                        $titulosyfecha= $titulosyfecha.'
                        <td>
                            Delegación: <b>'.nombreDelegacionVivienda($f['Delegacion']).'</b>
                        </td>   
                    </tr>
                    <tr bgcolor="#E7E7E7">
                        <td>  Programa: <b>'.nombreProgramaVivienda($f['Programa']).'</b></td>
                        <td>  Folio: <b>'.$f['Folio'].'</b></td>
                    </tr>';
                    }

                $titulosyfecha= $titulosyfecha.'   
                
                <tr bgcolor="#E7E7E7">
                    <td >
                        Genero: <b>'.$genero.'</b>
                    </td>
                    <td>
                        Edad: <b>'.$f['Edad'].' años</b>
                    </td>
                </tr>
                <tr bgcolor="#E7E7E7">
                    <td  colspan="2">
                    Fecha: <b>'.$f['Fecha'].'</b>
                    </td>
                </tr>
                <tr bgcolor="#E7E7E7">
                    <td colspan="2" >
                    </td>
                </tr>
                <tr bgcolor="#E7E7E7">
                    <td colspan="2" >
                        Para elever la calidad de neustros servicios y atenderle mejor, le pedimos colaborar con nosotros, contestando <b>libremente la atención recibida</b>.
                    </td>
                </tr>
                <tr bgcolor="#E7E7E7">
                    <td colspan="2" >
                    </td>
                </tr>
                <tr bgcolor="#E7E7E7">
                    <td colspan="2" >
                        <b>Nombre del trámite o servicio:</b> '.$f['Tramite'].'
                    </td>
                </tr>
                <tr bgcolor="#E7E7E7">
                    <td colspan="2" >
                    </td>
                </tr>
            </table>
            <br><br><br><br>
            ';          
                
            $cuerpo = '<table>
                <tr><td width="80%;">1.-El trato que recibió por parte de los servidores públicos que la atendieron fue:</td><td width="150px"><b>'.RespuestaBuenoRegularMalo($f['P1_TratoRecibido']).'</b></td></tr>
                <tr><td width="80%;">2.-La información para realizar este trámite fue:</td><td width="150px"><b>'.RespuestaBuenoRegularMalo($f['P2_Informacion']).'</b></td></tr>
                <tr><td width="80%;">3.-Las instalaciones o medios donde le atendieron son:</td><td width="150px"><b>'.RespuestaBuenoRegularMalo($f['P3_Instalaciones']).'</b></td></tr>
                <tr><td width="80%;">4.-¿Está satisfecho con el servicio recibido al realizar el trámite?</td><td width="150px"><b>'.sino($f['P4_SatisfechoconelServicio']).'</b></td></tr>
                <tr><td width="80%;">5.-¿Observó que algún servidor público indebidamente solicitó a un ciudadano dinero o dádivas?</td><td width="150px"><b>'.sino($f['P5_SolicitaronDinero']).'</b></td></tr>
                <tr><td width="80%;">6.-¿Al realizar el trámite, sintió discriminación en algún momento?</td><td width="150px"><b>'.sino($f['P6_Discriminacion']).'</b></td></tr>
                <tr><td width="80%;" colspan="2">En caso de contestar afirmativamente la pregunta anterior, por favor señale la probable causa de tal situación:</td></tr>
                <tr><td>Por ser una persona adulta mayor</td><td width="20px" border="1" align="center">'.marcarconX($f['P6_AdultoMayor']).'</td><td width="300px">   Por ser una persona con discapacidad</td><td width="20px" border="1" align="center">'.marcarconX($f['P6_Discapacidad']).'</td></tr>
                <tr><td>Por ser afrodescendiente</td><td width="20px" border="1" align="center">'.marcarconX($f['P6_Afrodescendiente']).'</td><td width="300px">  Por ser una persona que vive con VIH o SIDA</td><td width="20px" border="1" align="center">'.marcarconX($f['P6_VIH']).'</td></tr>
                <tr><td>Por mis creencias religiosas</td><td width="20px" border="1" align="center">'.marcarconX($f['P6_CreenciasReligiosas']).'</td><td width="300px">   Por mi preferencia sexual</td><td width="20px" border="1" align="center">'.marcarconX($f['P6_PreferenciaSexual']).'</td></tr>
                <tr><td>Por ser migrante</td><td width="20px" border="1" align="center">'.marcarconX($f['P6_Migrante']).'</td><td width="300px">  Por ser joven</td><td width="20px" border="1" align="center">'.marcarconX($f['P6_Joven']).'</td></tr>
                <tr><td>Por ser hombre</td><td width="20px" border="1" align="center">'.marcarconX($f['P6_Hombre']).'</td><td width="300px">  Por ser una persona trabajadora del hogar</td><td width="20px" border="1" align="center">'.marcarconX($f['P6_TrabajadoraHogar']).'</td></tr>
                <tr><td>Por ser mujer</td><td width="20px" border="1" align="center">'.marcarconX($f['P6_Mujer']).'</td><td width="300px">    Por mis ideas políticas</td><td width="20px" border="1" align="center">'.marcarconX($f['P6_IdeasPoliticas']).'</td></tr>
                <tr><td><b>Otra, indicar cual:</b></td><td>'.$f['P6_Otro'].'</td></tr>

                <tr><td></td><td></td></tr>
                <tr><td colspan="2">7.-¿Qué sugiere para mejorar el servicio?</td></tr>
                <tr><td>Que no se tarden tanto tiempo</td><td width="20px" border="1" align="center">'.marcarconX($f['P7_Tiempo']).'</td><td width="300px">   Que alguien solucione las quejas</td><td width="20px" border="1" align="center">'.marcarconX($f['P7_SolucionQuejas']).'</td></tr>
                <tr><td>Ampliar los horarios de servicios</td><td width="20px" border="1" align="center">'.marcarconX($f['P7_Ampliarhorarios']).'</td><td width="300px">  Personal más amable</td><td width="20px" border="1" align="center">'.marcarconX($f['P7_PersonalAmable']).'</td></tr>
                <tr><td>No pidan tantos requisitos</td><td width="20px" border="1" align="center">'.marcarconX($f['P7_NoTantosRequisitos']).'</td><td width="300px">   Que la información sea consistente</td><td width="20px" border="1" align="center">'.marcarconX($f['P7_InformacionConsistente']).'</td></tr>
                <tr><td>Que el trámite se realice por internet</td><td width="20px" border="1" align="center">'.marcarconX($f['P7_TramiteporInternet']).'</td><td width="300px">  (ventanilla, portal, tríptico)</td><td width="20px"  align="center"></td></tr>
                <tr><td>Que una sola persona me atienda y resuelva</td><td width="20px" border="1" align="center">'.marcarconX($f['P7_UnaSolaPersona']).'</td><td width="300px">  Que los formatos sean sencillos</td><td width="20px" border="1" align="center">'.marcarconX($f['P7_FormatosSencillos']).'</td></tr>
                <tr><td>Que capaciten al personal para eliminar los errores</td><td width="20px" border="1" align="center">'.marcarconX($f['P7_CapacitacionPersonal']).'</td><td width="300px">    </td><td width="20px" align="center"></td></tr>
                <tr><td><b>Otra, Especifique:</b></td><td>'.$f['P7_Otra'].'</td></tr>
                <tr><td colspan="2" ><b></b></td></tr>
                <tr><td colspan="2"></td></tr>
                <tr><td colspan="2"><b>Ocupación:</b>   '.$f['Ocupacion'].'</td></tr>
                <tr><td colspan="2"></td></tr>

            </table>';
        }
    }
    
    
    /* <tr><td colspan="2" width="100%;"><span style="font-size:9px; text-align: justify;">
                <b>*Aviso de Privacidad*</b><br>
                El titular de los datos personales podrá ejercer en todo momento su derecho de acceso, rectificación, cancelación y oposición de datos personales que proporcione, pudiendo ejercer en todo momento su derecho, físicamente en las oficinas del sujeto obligado ante quien se tramitó la solicitud en su domicilio oficial, o solicitarlo en la sección de transparencia de este mismo sitio
                web en la liga: http://www.sisaitamaulipas.org/sisaiTamaulipas/ o bien a través de la Plataforma Nacional de Transparencia (http://www.plataformadetransparencia.org.mx/).<br>
                    Lo anterior en cumplimiento a lo dispuesto en los artículos 1, 2, 3 fracción XII y XVIII, de la Ley de Transparencia y Acceso a la Información Pública del Estado de Tamaulipas; 3 fracción II, 27 y 28 de la Ley General de Protección de Datos Personales en Posesión de los Sujetos Obligado.
            </span></td></tr>*/
  /*  $firmas='
    <br><br><br><br><br><br>
    
    <table align = "center">
        <tr>
            <td ></td>
            <td>FIRMA</td>
            <td ></td>
        </tr>
        <tr>
            <td ></td>
            <td ></td>
            <td ></td>
        </tr>
        <tr>
            <td ></td>
            <td ></td>
            <td ></td>
        </tr>
        <tr>
            <td ></td>
            <td style="border-top: 1px solid #000"> '.$Nombre.'</td>
            <td ></td>
        </tr>
    </table>
    
    ';*/

    $tabla=$titulosyfecha.$cuerpo;
    //echo $tabla;
    $orientacion='P';
    $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
    // set document information
    $pdf->SetCreator(PDF_CREATOR);
    $pdf->SetKeywords('Reporte ITAVU');
    //$link = "www.localhost:81\mandantes_pago.php?idmandante=".$idmandante."&idcolonia=".$idcolonia."&idmunicipio=".$idmunicipio."";
    $pdf->SetHeaderData('pdf_logo.jpg', '40','');
  
    //$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, '', '');
    // set header and footer fonts
    $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
    $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
    // set default monospaced font
    $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
    // set margins
    $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
    $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
    $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
    //$pdf->SetFooterData("Impreso: ".fecha_larga($fecha).", ".hora12($hora)." por ".nitavu_nombre($nitavu),array(0, 64, 0),array(0, 64, 128));
    $pdf->SetFooterData('c', 0, 'xd', 'hola');
    // set auto page breaks
    $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
    // set image scale factor
    $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
    // set some language-dependent strings (optional)
    if (@file_exists(dirname(__FILE__).'pdf/lang/eng.php')) {
        require_once(dirname(__FILE__).'pdf/lang/eng.php');
        $pdf->setLanguageArray($l);
    }
    // set font
    $pdf->SetFont('helvetica', '', 10);
    // add a page
    $pdf->AddPage($orientacion); //en la tabla de reporte L o P
    
    $html = $tabla;
    $pdf->writeHTML($html, true, false, true, false, '');
    
    /////////// Informacion de quien imprimio el formato

    //echo $tabla;
    
    // reset pointer to the last page
    $pdf->lastPage();
    //Close and output PDF document}
    ob_end_clean();
    $pdf->Output('reporte.pdf', 'I');
    

   



?>
