<?php
require ("../rintera-config.php");
require ("../components.php");

// FORMATO DE PERMISO PARA REPORTES

include("../seguridad.php");   
MiToken_CloseALL($nitavu);

$id_rep = VarClean($_GET['id']);

$Titulo = TituloReporte($id_rep);
$Descripcion = DescripcionReporte($id_rep);     
$IdCon = IdConReporte($id_rep);
$Base = IdConInfo($IdCon);

require_once('../lib/pdf/tcpdf.php');    

$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
$pdf->setPrintHeader(false);
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
if (@file_exists(dirname(__FILE__).'pdf/lang/eng.php')) {require_once(dirname(__FILE__).'pdf/lang/eng.php');$pdf->setLanguageArray($l);}
$pdf->SetFont('dejavusans', '', 7); $pdf->AddPage('P'); //en la tabla de reporte L o P

//VARIABLES DE ESTILOS
$recuadro = "border: 2px #000000 solid; border-radius:5px; font-size: 28pt; font-weight:bold; padding:10px; width:50%;";
$recuadro2 = "border: 0px #000000 solid; border-radius:5px; font-size: 14pt; font-weight:bold; padding:10px; width:100%;";
$recuadro3 = "border: 0px #000000 solid; border-radius:5px; font-size: 12pt;  padding:10px; width:100%;";
$recuadro4 = "border: 0px #000000 solid; border-radius:5px; font-size: 8pt;  padding:10px; width:100%;";
$stylebar = array(
    'position' => '',
    'align' => 'C',
    'stretch' => false,
    'fitwidth' => true,
    'cellfitalign' => '',
    'border' => false,
    'hpadding' => 'auto',
    'vpadding' => 'auto',
    'fgcolor' => array(0,0,0),
    'bgcolor' => false, //array(255,255,255),
    'text' => true,
    'font' => 'helvetica',
    'fontsize' => 8,
    'stretchtext' => 40
);
$styleqr = array(
    'border' => true,
    'vpadding' => 'auto',
    'hpadding' => 'auto',
    'fgcolor' => array(0,0,0),
    'bgcolor' => false, //array(255,255,255)
    'module_width' => 1, // width of a single module in points
    'module_height' => 1 // height of a single module in points
);



    $pdf->SetXY(0, 0);
    $pdf->Image('img/afimex_plantilla.jpg', '', '', 270, 350, '', '', 'T', false, 300, '', false, false, 0, false, false, false);    
    
    
    // //$pdf->SetFont('times', 'BI', 20, '', 'false');
    // $pdf->SetFont('', 'B', 15, '', 'false');
    // $pdf->Text(78, 16, ''.'Ejempl'); 
    
    

    $pdf->SetFont('', 'R', 9, '', 'false');
    $pdf->Text(80, 20, ''.'Asunto: Acceso a Reporte #'.$id_rep.' de la Plataforma'); 


    $Director = Preference("Director","","");
    $pdf->SetFont('', '', 10, '', 'false');
    $pdf->Text(10, 40, ''.''.$Director); 

    $pdf->SetFont('', 'B', 10, '', 'false');
    $pdf->Text(10, 45, ''.'Director General'); 


    
    $pdf->SetFont('', '', 10, '', 'false');
    $pdf->Text(70, 50, ''.'ATN: '.Preference("JefeInformatica","","")); 
    $pdf->SetFont('', 'B', 10, '', 'false');
    $pdf->Text(70, 55, ''.'Jefe del Dpto. de Informática'); 

    $pdf->SetFont('', '', 10, '', 'false');
    $pdf->Text(20, 70, ''.'Por medio de la presente solicito acceso al reporte identficado con el ID='.$id_rep.''); 
    $pdf->Text(10, 78, ''.'del modulo de reportes de la Plataforma de ITAVU, denominado Rintera.'); 


    $pdf->SetFont('', 'B', 10, '', 'false');
    $pdf->Text(10, 90, ''.'Titulo: '.$Titulo); 
    $pdf->Text(10, 98, ''.'Descripcion: '.$Descripcion); 
    $pdf->Text(10, 106, ''.'Base de Datos: '.$Base); 
    
    $pdf->SetFont('', 'B', 10, '', 'false');
    $pdf->Text(10, 115, ''.'Requerimientos adicionales u observaciones:'); 

    $pdf->SetFont('', '', 10, '', 'false');
    $pdf->Text(50, 195, ''.'Cd. _____________________________ a '.fecha_larga($fecha)); 


    $pdf->SetFont('', '', 10, '', 'false');
    $pdf->Text(18, 244, 'C. '.UserName($nitavu)); 
    $pdf->SetFont('', 'I', 10, '', 'false');
    $pdf->Text(18, 251, 'Puesto:________________________'); 


    $pdf->Text(110, 244, 'C. ____________________________________ '); 
    $pdf->SetFont('', 'I', 12, '', 'false');
    $pdf->Text(110, 251, 'Puesto:________________________'); 


    $pdf->SetFont('', 'I', 8, '', 'false');
    $pdf->Text(140, 220, 'Autoriza: (Jefe Inmediato o superior)'); 
    

    $pdf->SetFont('', 'I', 8, '', 'false');
    $pdf->Text(50, 220, 'Solicita'); 
    

    $pdf->SetFont('', '', 7, '', 'false');
    $pdf->Text(100, 210, 'f i r m a s :'); 
    
    $pdf->SetFont('', '', 7, '', 'false');
    $pdf->Text(18, 238, '_____________________________________________________'); 
    $pdf->Text(110, 238, '_______________________________________________________________________'); 
    


    $pdf->StopTransform();
    

    //Finalizamos el reporte
    $pdf->lastPage();	  

    $pdf->Output("solicitud.pdf", 'I');   


?>