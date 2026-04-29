<?php
require("config.php");
//require_once('/seguridad.php');
require_once('lib/funciones.php');
require_once('pdf/tcpdf.php');
require('lib/flor_funciones.php');
require('lib/yes_funciones.php');
require("viaticos_fun.php");

//$FolioTramite = $_GET['folio'];


$IdViatico = $_GET['id'];

// <p align = "right"  style="text-align:center; font-size:16px;">
// <b>OFICIO DE COMISIÓN</b><br><br><br>
  // <b style="text-align:center; font-size:14px;">Oficio N°'.viaticos_Oficio($IdViatico).'</b>
    // <br>'.fechaSinDia($fecha).'</p>   ';
   
    $t1 = '<BR>
    <BR>
    <BR>
    


    <table style="padding:2px; font-size:11px; " >   
    <tr>
    <td><img  src="img/pdf_logo1.jpg" style="width:250px; height:50px" /></td> 
    <td><p align = "right"  style="text-align:center; font-size:16px;">
    <b>OFICIO DE COMISIÓN</b><br><br><br>
 
   
    <b style="text-align:center; font-size:14px;">Oficio N°'.viaticos_Oficio($IdViatico).'</b>
    <br>'.fechaSinDia($fecha).'</p>
  
    
    </td> 
    
    </tr>
    <tr>
    <td>
    </td>    
    <td style="width:50%; ">
    <br>
    <br>
    <table style="padding:2px; font-size:7.5px;width:125%;" >   
    <tr>
    <td colspan="2" style="font-size:8px;"><b>DATOS PARA FACTURACION CFDI 4.0</b></td> 
    <td ></td> 
    </tr>   
    <tr>
    <td style="width:20%">CODIGO POSTAL</td> 
    <td>87020</td> 
    </tr>
    <tr>
    <td style="width:20%">REGIMEN FISCAL</td> 
    <td>603 - Personas Morales con Fines no Lucrativos</td> 
    </tr>
    <tr>
    <td style="width:20%">USO DE CFDI</td> 
    <td>G03 Gastos en General</td> 
    </tr>
    <tr>
    <td style="width:20%">CORREO ELECTRONICO</td> 
    <td>'.nitavu_correo(viaticos_NEmpleado($IdViatico)).'</td> 
    </tr>
</table>
    </td>
    </tr>    
    </table>';



 
   
  
 

   // historia($nitavu, 'Veo el reporte de la lista de mandantes con los montos por pagar, y todos los saldos.');
   
    $t1 = $t1.'
    <BR>
    <BR>
    <p align = "left"  style="font-size:14px;"><br>C. '.strtoupper(nitavu_nombre(viaticos_NEmpleado($IdViatico))).'<br>Presente.<br>
        </p>
    
    <p style="text-align: justify; font-size:14px;">Sírvase presentarse de '.LugarComision($IdViatico).' los días del '.viaticos_SalidaDiaFecha($IdViatico) .
    ' al '.viaticos_RegresoDiaFecha($IdViatico).' de '. viaticos_RegresoMesFecha($IdViatico).' para llevar a cabo la siguiente comisión: '.viaticos_Comision($IdViatico).', 
   debiendo partir el día '.  date_format( date_create(viaticos_SalidaFecha($IdViatico)), 'd/m/Y') .' a las '.date("H:i" , strtotime(viaticos_SalidaHora($IdViatico))).
   ' hrs. y retornar el día ' .date_format( date_create(viaticos_RegresoFecha($IdViatico)), 'd/m/Y').' a las'. date("H:i" , strtotime(viaticos_RegresoHora($IdViatico))).' hrs. </p>

    <p align = "Justify"  style="text-align:center; font-size:14px;">Como Servidor Público tendrá la obligación de salvaguardar la legalidad, honradez, lealtad, imparcialidad y eficiencia en el desempeño de su comisión,
    cuyo incumplimiento dará lugar al procedimiento y a las sanciones que corresponda, según la naturaleza de la infracción en que se incurra, segun lo establece
    el titulo tercero de la Ley de Responsabilidades de Servidores Públicos. Al regreso de la comisión deberá presentar este oficio sellado y firmado por la autoridad correspondiente en el lugar donde efectuó la comisión.</p>';
 
   
    
    //echo $t1;
    $orientacion='P';
    $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
    $pdf->SetCreator(PDF_CREATOR);
    $pdf->SetKeywords('Reporte ITAVU');
    $pdf->SetHeaderData('', '40','');

   
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


$pdf->writeHTML($html, true, false, true, false, '');

$pdf->SetFont('helvetica', 'B', 8); 
$rfcitavu='https://siat.sat.gob.mx/app/qr/faces/pages/mobile/validadorqr.jsf?D1=10&D2=1&D3=15050316977_ITV820513L21';
$pdf->Text(170,80, 'ITV820513L21'); 
$pdf->write2DBarcode($rfcitavu, 'QRCODE,M', 168.5, 56, 24, 24, $styleqr, 'N'); 
$pdf->SetXY(25,170);
$pdf->Cell(60,10,strtoupper(nitavu_nombre(viaticos_NEmpleado($IdViatico))), 0,0,'C',0);
$pdf->SetXY(25,175);
$pdf->Cell(60,10,"__________________________________________",0 ,0,'C',0);
$pdf->SetXY(25,180);
$pdf->Cell(60,10,"COMISIONADO", 0,0,'C',0);

$pdf->SetXY(130,170);
$pdf->Cell(60,10,strtoupper(nitavu_nombre(titular(quienEsmiDireccion(nitavu_dpto(viaticos_NEmpleado($IdViatico)))))), 0,0,'C',0);
$pdf->SetXY(130,175);
$pdf->Cell(60,10,"__________________________________________",0 ,0,'C',0);
$pdf->SetXY(130,180);
$pdf->Cell(60,10,"DIRECTOR DE AREA", 0,0,'C',0);


$pdf->SetXY(25,215);
//$pdf->Cell(60,10,strtoupper(nitavu_nombre(quienesmijefe(viaticos_NEmpleado($IdViatico)))), 0,0,'C',0);
$pdf->Cell(60,10,strtoupper(viaticos_JefeInmediato($IdViatico)), 0,0,'C',0);
$pdf->SetXY(25,220);
$pdf->Cell(60,10,"__________________________________________",0 ,0,'C',0);
$pdf->SetXY(25,225);
$pdf->Cell(60,10,"SUPERIOR INMEDIATO", 0,0,'C',0);

$pdf->SetXY(130,215);

$pdf->Cell(60,10,strtoupper(Preference("Comisario","","")), 0,0,'C',0);
$pdf->SetXY(130,220);
$pdf->Cell(60,10,"__________________________________________",0 ,0,'C',0);
$pdf->SetXY(130,225);
$pdf->Cell(60,10,"ORGANO DE CONTROL", 0,0,'C',0);
  
$pdf->SetFont('helvetica', '', 8);
$pdf->SetXY(10,264);
$pdf->Cell(40,10,"C.C.P. Dpto. Rec. Financieros", 0,0,'L',0);
$pdf->SetXY(10,267);
$pdf->Cell(40,10,"C.C.P. Comisario", 0,0,'L',0);
    $pdf->lastPage();
    //Close and output PDF document}
    ob_end_clean();
    //echo $html;
    $pdf->Output('OficioComsion.pdf', 'I');

?>