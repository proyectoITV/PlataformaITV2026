<?php
include('/seguridad.php');
define('FPDF_FONTPATH','fpdf/font');

//require('fpdf/fpdf.php');
require_once('tcpdf/tcpdf_include.php');

require('config.php');
require('lib/funciones.php');

class PDF extends FPDF
{
// Page header
function Header()
{
    // Logo el numero final es el tamaño
    $this->Image('img/logo.png',10,6,80); 
    // Arial bold 15
    $this->SetFont('Helvetica','B',12);
    // Move to the right
    $this->Cell(80);
    // Title
    //$this->Cell(30,10,'Title',1,0,'C');
    // Line break
    $this->Ln(20);
}

// Page footer
function Footer()
{
    require('config.php');

    // Position at 1.5 cm from bottom
    $this->SetY(-35);



    // Arial italic 8
    $this->SetFont('Helvetica','I',9);
    $this->SetTextColor('103','103','107');

    $this->Ln(12);
    $this->Cell(0,10,$pyme_name);
    
    $this->Ln(4);
    $this->Cell(0,10,utf8_decode($pyme_direccion));
    
    $this->Ln(4);
    $this->Cell(0,10,utf8_decode($pyme_direccion2));
    
    $this->SetXY(160,256);
    $this->Cell(0,10,utf8_decode($pyme_tels));
    
    $this->SetXY(160,260);
    $this->Cell(0,10,utf8_decode($pyme_tels2));

    $this->Image('img/firma_raya.png',150,256,0.35); 
    
    
    
    // Page number    
    //$this->Cell(0,10,"Itavu".$this->PageNo().'/{nb}',0,0,'C');
}
}

// Instanciation of inherited class
$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->AddPage('P','Letter');
$pdf->SetFont('Helvetica','',11);
//for($i=1;$i<=40;$i++)
    //$pdf->Cell(0,10,'Printing line number '.$i,0,1);


// cargar los datos desde el no. de oficio solicitante _?\\|\zz
$docdigital = $_GET['n'];

$sql = "SELECT * FROM notificaciones WHERE no_oficio='".$docdigital."'";
    $rc= $conexion -> query($sql);
    $msg="";
//echo $sql;
if($f = $rc -> fetch_array())
{
    $pdf->SetXY(110,25);
    $pdf->Cell(0,0, "OFICIO NO.:".$docdigital,0,1,1);
    
    $pdf->SetXY(110,30);
    $pdf->Cell(0,0, "Asunto:".$f['asunto'],0,1,1);

    $pdf->SetXY(110,35);
    $pdf->Cell(0,0, "".dedondeeres($f['nitavu_manda'])." a ".$f['entregar_fecha'],0,1,1);



    $pdf->SetXY(10,45);
    $pdf->Cell(0,0, "".nitavu_nombre($f['nitavu']),0,1,1);

    $pdf->SetXY(10,50);
    $pdf->Cell(0,0, "".nitavu_puesto($f['nitavu'])." de ".nitavu_dpto($f['nitavu']),0,1,1);

    $pdf->SetXY(10,55);
    $pdf->Cell(0,0, "".nitavu_direccion($f['nitavu']),0,1,1);

    $pdf->SetY(55);
    $pdf->writeHTML($f['contenido'], true, false, true, false, '');


    
}


$pdf->Output();
?>