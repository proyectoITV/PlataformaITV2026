<?php
ob_start() ;
require("config.php");
//require_once('/seguridad.php');
require_once('lib/funciones.php');
require_once('pdf/tcpdf.php');
require('lib/flor_funciones.php');
require('lib/yes_funciones.php');



// Create new PDF
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
error_reporting(0);

//$nitavu='2269';
$orientacion='p';
 $autor="INSTITUTO TAMAULIPECO DE VIVIENDA Y URBANISMO";
 $titulo="INSTITUTO TAMAULIPECO DE VIVIENDA Y URBANISMO";
 $descripcion='                       Recibo de Pago Desarrolladores';


// create new PDF document
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor($autor);
$pdf->SetTitle(strtoupper($titulo));
$pdf->SetSubject(strtoupper($descripcion));
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
//define ('PDF_MARGIN_TOP', 19);
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


 

//$folioRecibo=$_GET['FolioRecibo'];

if (isset($_GET['DatosRecibo'])) {    

    $FolioRec=$_GET['DatosRecibo'];
   // $NumContrato=$_GET['NumContrato'];
    $iddelegacion=$_GET['IdDelegacion'];
    $idprograma=$_GET['IdPrograma'];
    $folio=$_GET['Folio'];

}

$notas='';
//$notas='Para su mayor comidad ponemos a su disposición una TARJETA para pagos en tiendas OXXO. Tramitela en la delegación más cercana.';
$sql="Select * From datosrecibos WHERE IdDelegacion='".$iddelegacion."' and IdPrograma='".$idprograma."' and Folio='".$folio."' and  FolioRecibo >=".$FolioRec;
	//echo $sql;
    $rc= $Vivienda -> query($sql);
    $row_cnt = $rc->num_rows;
        
        if($row_cnt>0)
        {
          while($datos = $rc -> fetch_array())
          {
            $iddelegacion=$datos['IdDelegacion'];
            $idprograma=$datos['IdPrograma'];
            $folio=$datos['Folio'];
            $numcontrato=$datos['NumContrato'];
            $cantidad=$datos['Cantidad'];
            $formapago=$datos['FormaPago'];
            $referencia=$datos['Referencia'];
            $fecharecibo=$datos['FechaRecibo'];
            $nitavurecibo=$datos['Nitavu'];
            $foliorecibo=$datos['FolioRecibo'];
            $numpago=$datos['NumPago'];
            $tipopago=$datos['IdTipoPago'];
            $descuento=$datos['Descuento'];
            $codigoqr=$datos['codigoQR'];	       
            $pdf->AddPage($orientacion); //en la tabla de reporte L o P
            $html=formatoRecibo($iddelegacion,$idprograma,$folio,$numcontrato,$cantidad,$formapago,$referencia,$fecharecibo,$nitavurecibo,$foliorecibo,$numpago,$tipopago,$notas,$codigoqr,$descuento);
           $pdf->writeHTML($html, true, false, true, false, '');
            //echo $html;
        }        

       
       
    }else{
        //echo 'FALSE';
    }
  
////////$pdf->AddPage();
$pdf->lastPage();
ob_end_clean();
$pdf->Output('recibo', 'I');


 ?>