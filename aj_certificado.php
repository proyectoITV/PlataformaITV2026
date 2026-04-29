<?php
ob_start();

require("config.php");
require_once('seguridad.php');
require_once('lib/funciones.php');
require_once('pdf/tcpdf.php');
require('lib/flor_funciones.php');

$NumContrato = $_GET['NumContrato'];
$NumMov = $_GET['NumMov'];



$sql = "  SELECT Hp.FechaOperacion, Hp.NumContrato, Hp.MontoPagoRecibido, pagosparciales.foliorecibo, 
foliorecibo as Referencia, 	CONCAT('C. ', solicitantes.Paterno, ' ',solicitantes.Materno, ' ', solicitantes.Nombre) AS Beneficiario, CONCAT(delegaciones.paternoDel,' ', delegaciones.MaternoDel,' ',NombreDel) AS NomDelegado, delegaciones.Delegacion,  Hp.IdMovDesc AS NoCertificado
FROM  solicitantes 
RIGHT OUTER JOIN solicitudes 
RIGHT OUTER JOIN contratos AS Cont 
LEFT OUTER JOIN delegaciones ON Cont.IdDelegacion = delegaciones.IdDelegacion ON solicitudes.IdDelegacion = Cont.IdDelegacion AND
solicitudes.IdPrograma = Cont.IdPrograma AND solicitudes.Folio = Cont.Folio ON solicitantes.IdSolicitante = solicitudes.IdSolicitante 
RIGHT OUTER JOIN pagosparciales 
RIGHT OUTER JOIN historicopagos AS Hp ON pagosparciales.NumContrato = Hp.NumContrato AND pagosparciales.NumMov = Hp.NumMov ON
Cont.NumContrato = Hp.NumContrato
WHERE Hp.NumContrato = '".$NumContrato."' AND Hp.NumMov = ".$NumMov."";
echo $sql;

$r = $Vivienda -> query($sql);
while($f = $r -> fetch_array()) {
    $Fecha = $f['FechaOperacion'];
    $Delegacion = $f['Delegacion'];
    $Referencia= $f['Referencia'];
    $Contador = $f['NoCertificado'];
    $Beneficiario = $f['Beneficiario'];
    $NomDelegado = $f['NomDelegado'];
}

$length = 6;
$string = "".$Contador;
$Num =  str_pad($string,$length,"0", STR_PAD_LEFT);

$tabla = '<table>
    <tr><td><img src="img/logo_copia.png" border="0" height="50" width="200" /></td><td></td><td></td></tr>
    <tr><td></td>
    <td></td>
    <td style="font-size:14px;">
    Fecha: '.$Fecha.'<br>
    Delegación: '.$Delegacion.' <br>
    NumContrato: '.$NumContrato.'<br>
    Recibo: '.$Referencia.'<br>
    </td>
    </tr>
</table>
';

$tabla = $tabla.'<center><span style="font-size:18px;" align="center">
<br><br>
<B>CERTIFICADO DE SUBSIDIO ESTATAL</B>
<br><br><br>

</span>
<span style="font-size:14px;" align="center">    
El Gobierno del Estado de Tamaulipas, por conducto del <b> Instituto Tamaulipeco de Vivienda
y Urbanismo </b>, a través de la Delegación de este municipio y dentro del programa
Reconocimiento de Pagos Históricos, a los beneficiarios de los diferentes programas.

<br>
<br>

Otorga el presente subsidio estatal con número: <B> PH-'.$Num.' </B> <br>
Por <b> reconocer y registrar pagos ingresados en otras dependencias (Pagos Históricos) </b> al
<b> '.$Beneficiario.' </b>

<br>
<br>

Como apoyo autorizado en Junta de Gobierno, Acta de Sexión Ordinaria No. 62; Punto de acuerdo número 8,
con fecha 24 de abril del 2018.

<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
</span></center>';


$tabla = $tabla.'

<table style="font-size:14px;">
    <tr>
        <td></td>
        <td width="250" align="center" style="border-bottom: 0.3px solid #000;">

        </td>
        <td></td>
    </tr>
    <tr>
        <td></td>
        <td width="250" align="center">
            <b>'.$NomDelegado.'<br>
            Delegado ITAVU '.$Delegacion.'</b>
        </td>
        <td></td>
    </tr>
</table>

';




echo $tabla;

// Extend the TCPDF class to create custom Header and Footer
class MYPDF1 extends TCPDF {
    //Page header
    public function Header() {
    }
    // Page footer
    public function Footer() {
    }
}


$pdf = new MYPDF1(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetKeywords('Reporte ITAVU');

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
// set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
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
$pdf->AddPage('P', 'LETTER');

$html = $tabla;
//echo $html; aqui escribe el contenido de la consulta
    
$pdf->writeHTML($html, true, false, true, false, '');

// reset pointer to the last page
$pdf->lastPage();
//Close and output PDF document}
ob_end_clean();
$pdf->Output('reporte.pdf', 'I');


?>