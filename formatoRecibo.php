<?php
require("config.php");
//require_once('/seguridad.php');
require_once('lib/funciones.php');
require_once('pdf/tcpdf.php');
require('lib/flor_funciones.php');
require('lib/yes_funciones.php');


// Create new PDF
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);


//$nitavu='2269';
$orientacion='P';
 $autor="INSTITUTO TAMAULIPECO DE VIVIENDA Y URBANISMO";
 $titulo="INSTITUTO TAMAULIPECO DE VIVIENDA Y URBANISMO";
 $descripcion='                                     Recibo de Pago';




// create new PDF document
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor($autor);
$pdf->SetTitle(strtoupper($titulo));
$pdf->SetSubject(strtoupper($descripcion));
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
define ('PDF_MARGIN_TOP', 19);
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
$pdf->setHeaderFont(array('dejavusans', '', 10));
$pdf->SetHeaderData('pdf_logo.jpg', '50',strtoupper($titulo).'', strtoupper($descripcion));
$pdf->setFooterFont(array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
// $pdf->SetHeaderMargin(1.0);
// $pdf->SetFooterMargin(0.7);
 $pdf->setPrintHeader(true);
 $pdf->setPrintFooter(false);
$pdf->SetFont('dejavusans', '', 7);

// add a page
$pdf->AddPage($orientacion); //en la tabla de reporte L o P
 

//$folioRecibo=$_GET['FolioRecibo'];

if (isset($_GET['DatosRecibo'])) {
    /* Deshacemos el trabajo hecho por base64_encode */
    $datos = base64_decode($_GET['DatosRecibo']);
    /* Deshacemos el trabajo hecho por 'serialize' */
    $datos = unserialize($datos);
    // El contenido del error está en el índice 'error'
	//die($error['error']);
	
	$iddelegacion=$datos['iddelegacion'];
	$idprograma=$datos['idprograma'];
	$folio=$datos['folio'];
	$numcontrato=$datos['numcontrato'];
	$cantidad=$datos['cantidad'];
	$formapago=$datos['formapago'];
	$referencia=$datos['referencia'];
	$fecharecibo=$datos['fecharecibo'];
	$nitavurecibo=$datos['nitavu'];
	$foliorecibo=$datos['foliorecibo'];
	$numpago=$datos['numpago'];
	$tipopago=$datos['idtipopago'];
	$descuento=$datos['descuento'];
	$codigoqr=$datos['codigoqr'];

}

$notas='Para su mayor comidad ponemos a su disposición una TARJETA para pagos en tiendas OXXO. Tramitela en la delegación más cercana.';

// create some HTML content
$html =   formatoRecibo($iddelegacion,$idprograma,$folio,$numcontrato,$cantidad,$formapago,$referencia,$fecharecibo,$nitavurecibo,$foliorecibo,$numpago,$tipopago,$notas,$codigoqr,$descuento);

// Output the HTML content
$pdf->writeHTML($html, true, false, true, false, '');
 
$pdf->lastPage();
ob_end_clean();
$pdf->Output('recibo', 'I');
?>