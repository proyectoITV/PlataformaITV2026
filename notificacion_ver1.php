<?php
include('/seguridad.php');
require('config.php');
require('lib/funciones.php');

define('FPDF_FONTPATH','fpdf/font');
require('fpdf/html2pdf.php');


//$pdf = new PDF();
$pdf = new PDF_HTML();
$pdf->AliasNbPages();
$pdf->AddPage('P','A4');
$pdf->SetFont('Helvetica','',11);

//ENCABEZADO
    $pdf->Image('img/logo_copia.png',10,6,80); 
    
//PIE
    $pdf->SetFont('Helvetica','I',9);
    $pdf->SetTextColor('103','103','107');

    $pdf->SetXY(10,256);
    $pdf->Cell(0,10,$pyme_name);
    
    $pdf->SetXY(10,261);
    $pdf->Cell(0,10,utf8_decode($pyme_direccion));
    
    $pdf->SetXY(10,266);
    $pdf->Cell(0,10,utf8_decode($pyme_direccion2));
    
    $pdf->SetXY(160,256);
    $pdf->Cell(0,10,utf8_decode($pyme_tels));
    
    $pdf->SetXY(160,260);
    $pdf->Cell(0,10,utf8_decode($pyme_tels2));

    $pdf->Image('img/firma_raya.png',150,256,0.35); 

    $pdf->SetXY(10,250);
    $pdf->Cell(0,10,utf8_decode('* Documento Electronico desde la Plataforma ITAVU |'.$fecha.' | '.$hora));


// cargar los datos desde el no. de oficio solicitante _?\\|\zz
$docdigital = $_GET['n'];
$pdf->SetFont('Helvetica','',9);
$pdf->SetTextColor('0','0','0');

$sql = "SELECT * FROM notificaciones WHERE (no_oficio='".$docdigital."' AND nitavu='".$nitavu."')";
    $rc= $conexion -> query($sql);
    $msg="";
//echo $sql;
if($f = $rc -> fetch_array())
{
    historia($nitavu, "Vio Notificacion con Id No. ".$f['no_oficio']." sobre ".$f['asunto']." de ".nitavu_nombre($f['nitavu_manda']));
    $vista=notificaciones_ver($f['no_oficio'],$nitavu);


    $pdf->SetXY(110,25);
    //$pdf->Cell(0,0, "OFICIO NO.:".$docdigital,0,1,1);
    $pdf->WriteHTML("Oficio No.:<b>".$docdigital."</b>");
    
    $pdf->SetXY(110,28);
    //$pdf->Cell(0,0, "Asunto:".$f['asunto'],0,1,1);
    $pdf->WriteHTML("Asunto: <b>".$f['asunto']."</b>");

    $pdf->SetXY(110,34);
    $pdf->Cell(0,0, "".dedondeeres($f['nitavu_manda'])." a ".$f['entregar_fecha'],0,1,1);



    $pdf->SetXY(10,40);
    //$pdf->Cell(0,0, "".nitavu_nombre($f['nitavu']),0,1,1);
    $nombre = utf8_decode(nitavu_nombre($f['nitavu']));
    $pdf->WriteHTML("<b>".$nombre."</b>");

    $pdf->SetXY(10,46);
    $pdf->Cell(0,0, "".nitavu_puesto($f['nitavu'])." de ".nitavu_dpto_nombre($f['nitavu']),0,1,1);

    $pdf->SetXY(10,49);
    $pdf->Cell(0,0, "".nitavu_direccion($f['nitavu']),0,1,1);

    $pdf->SetY(55);
    //$pdf->Cell(0,0, "".$f['contenido'],0,1,1);    
    $pdf->WriteHTML(utf8_decode($f['contenido']));



    $firma="firmas/".$f['nitavu_manda'].".jpg";
    if (file_exists($firma))
    {
        
        $pdf->Image($firma,70,205,80); 
        //$pdf->WriteHTML("<img src=".$firma." >x");
    }
    
    $pdf->SetXY(90,210);
    $pdf->WriteHTML("<center>A T E N T A M E N T E</center>");

    $pdf->SetXY(70,230);
    $pdf->WriteHTML("<b>".nitavu_nombre($f['nitavu_manda'])."</b>");
    
    $pdf->SetXY(70,235);
    $d = nitavu_dpto_nombre($f['nitavu_manda']);
    $pdf->WriteHTML("".nitavu_puesto($f['nitavu_manda'])." de ".$d);
    
    $pdf->SetXY(70,240);
    $pdf->WriteHTML("".nitavu_direccion($f['nitavu_manda'])."");


}


$pdf->Output();
?>