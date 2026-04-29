<?php
require("config.php");
//require_once('/seguridad.php');
require_once('lib/funciones.php');
require_once('pdf/tcpdf.php');
require('lib/flor_funciones.php');


$FolioTramite = $_GET['folio'];
//$FolioTramite = 124;

$Nombres = TramiteNombres($FolioTramite);
$Apellido1 = TramiteApellido1($FolioTramite);
$Apellido2= TramiteApellido2($FolioTramite);
$quienCaptura = QuiencapturoTramite($FolioTramite);
//$numOficio=0;
//echo 'Numero: '.numeroAutorizarFolio($FolioTramite);
if(numeroAutorizarFolio($FolioTramite)==0 || numeroAutorizarFolio($FolioTramite)==FALSE){
    $numOficio = nautorizarfolio(TRUE);
    actualizarNumeroAutorizarFolio($FolioTramite, $numOficio);
}else{
    $numOficio =numeroAutorizarFolio($FolioTramite);
}
    $t1 = '
    <p align = "right"  style="text-align:center; font-size:12px;">
    <b>INSTITUTO TAMAULIPECO DE VIVIENDA Y URBANISMO</b><br>
    DIRECCIÓN DE PROGRAMAS DE SUELO Y VIVIENDA<br>
    <b><i>SUBDIRECCIÓN DE PROGRAMAS DE SUELO</i></b><br>
    Departamento de Programas de Ofertas de Suelo<br>
    <b>Tarjeta Autorización-XXX/'.$numOficio.'</b></p>
    ';

   // historia($nitavu, 'Veo el reporte de la lista de mandantes con los montos por pagar, y todos los saldos.');
   
    $t1 = $t1.'
    <BR>
    <BR>
    <BR>
    <p align = "left"  style="text-align:center; font-size:12px;">
    '.fechaSinDia($fecha).'<br><br>
    De: '.nitavu_nombre(DirectordeSuelos()).' <br>
    <b>Director de Programas de Suelo y Vivienda</b>
    </p>
    
    <p style="text-align: justify;">En atención al oficio (Número de oficio enviado por la delegación) enviado por '.nitavu_dpto_nombre($quienCaptura).', 
    se solicita <b>AUTORIZACIÓN</b> para asignar <b>NUEVO FOLIO</b> a la siguiente persona que cumple con todos los requisitos establecidos 
    en el programa <i>Suelo Legal, Patrimonio Seguro: </i>';
 
    if(TramiteAhorroPrevio($FolioTramite)<>0 and TramiteTiempoAhorro($FolioTramite)<>0 ){
        $t1 = $t1.'con ahorro previo de  $'.number_format(TramiteAhorroPrevio($FolioTramite),2,'.',',').' MXN en un tiempo de '.TramiteTiempoAhorro($FolioTramite).' meses. </p>';
    }else{
        $t1 = $t1.' </p>';
    }
    $t1 = $t1.'
    <br>
    <br>
    <br>
    <br>
    <BR>
    <BR>
    
    <table style="HEIGHT:100%;WIDTH:100%;">
        <tr align="center" bottom="middle">
        <td border="0" style="width:110px;"></td>
            <td border="1" bgcolor="#dddddd" style="width:200px;"><b>Nombre</b></td>
            <td border="1" bgcolor="#dddddd" style="width:200px;"><b>Firma de autorización<br>
            '.nitavu_nombre(CATgerarquia_director()).'</b>
            </td>
        <td border="0" style="width:110px;"></td>
        </tr>
        <tr align="center" bottom="middle">
        <td border="0" style="width:110px;"></td>
            <td border="1" bgcolor="#FFF" style="width:200px; height:150px;"> <BR>'.$Nombres.' '.$Apellido1.' '.$Apellido2.'</td>
            <td border="1" bgcolor="#FFF" style="width:200px; height:150px;"></td>
        <td border="0" style="width:110px;"></td>
        </tr>
    </table>
    <BR>
    <BR>
    <BR>

    <p style="text-align: justify;">
    Sin otro particular por el momento.<br>
    </p>
   
    <table height="240">
    <tr>
        <td height="240"></td>
    </tr>
    </table>
    <p align ="right">
        <img src="icon/piepagina.png" height="70" width="300">
    <p>

    ';



    
    //echo $t1;
    $orientacion='P';
    $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
    $pdf->SetCreator(PDF_CREATOR);
    $pdf->SetKeywords('Reporte ITAVU');
    $pdf->SetHeaderData('pdf_logo.jpg', '40','');

   
    $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
    $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
  
    $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
    // set margins
    $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
    $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
    //$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

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
    $pdf->SetFont('helvetica', '', 9);
    // add a page
    $pdf->AddPage('P'); //en la tabla de reporte L o P
    
    $html = $t1;
    //echo $html;
    $pdf->writeHTML($html, true, false, true, false, '');
  
    $pdf->lastPage();
    //Close and output PDF document}
    ob_end_clean();
    $pdf->Output('TarjetaAutorizacion.pdf', 'I');

?>