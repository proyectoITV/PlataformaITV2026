<?php

require("config.php");
require_once('seguridad.php');
require_once('pdf/tcpdf.php');
//$nitavu="2809";
$idRequisicion = $_GET['n'];

error_reporting(0);
//hospedaje
$Himporte1=0;
$Himporte2=530;
$Himporte3=0;
$Hsubtotal=530;

//alimentacion
$Aimporte1=0;
$Aimporte2=460;
$Aimporte3=0;
$Asubtotal=460;

//dias
$dias1=0;
$dias2=2;
$dias3=0;

//totales
$totales1=0;
$totales2=990;
$totales3=0;
$totalesFinal=990;

//transportacion
$terrestre='X';
$tconrecorrido='0';
$tarea='0';


//datosvehiculo
$nvehiculo='0';
$autobus='X';
$particular='0';
$marca='0';
$modelo='0';


$tipo='0';
$placas='0';
$cilindraje='0';

$kmsrecorridos='646';
$kmsrecorridointerno='0';
$kms='646';

$a='';
$b='';
$c='';
$d='';

$totalRecorrido='';

$preciocombustible='0';

$autobuspeaje='961.00';

$xpu='0';

$cil='9';
$totalTransportacion='961.00';

$empleado='ANGEL ISRAEL ROSAS MORALES';
$fechaletra='3 DE JUNIO DEL 2021';


$director='SALVADOR GONZALEZ GARZA';
$dirAdmon='EDGAR ELIUD ACEVEDO MEDRANO';
$organoControl='ESTANISLAO HERVERT BAUTISTA';

$tablaviaticos='<BR><BR>
<div style="border: 0.3px solid black;">
<table style="padding:1px;">
    <tr  style="font-weight:bold;">
        <td style="width:11%; text-align:center;  text-align: center;">VIATICOS</td>
        <td style="width:15%; vertical-align:middle;  text-align: center;">HOSPEDAJE</td>
        <td style="width:11%; vertical-align:middle;  text-align: center;">IMPORTE</td>
        <td style="width:15%; vertical-align:middle;  text-align: center;">ALIMENTACION</td>
        <td style="width:11%; vertical-align:middle;  text-align: center;">IMPORTE</td>
        <td style="width:15%; vertical-align:middle;  text-align: center;">DIAS</td>
        <td style="width:11%; vertical-align:middle;  text-align: center;"></td>
        <td style="width:11%; vertical-align:middle;  text-align: center;">TOTALES</td>    
    </tr>
    <tr>
        <td style="width:11%; text-align: center;">Sencillo</td>
        <td style="width:15%; text-align: center; vertical-align:middle; ">CUOATA DIARA(I) $</td>
        <td style="width:11%; text-align: center; vertical-align:middle; border-bottom:  0.3px solid black;">'.$Himporte1.'</td>       
        <td style="width:15%; text-align: center; vertical-align:middle; ">CUOATA DIARA(I) $</td>
        <td style="width:11%; text-align: center; vertical-align:middle; border-bottom:  0.3px solid black;">'.$Aimporte1.'</td>   
        <td style="width:15%; text-align: center; vertical-align:middle;">NUMERO DE DIAS</td>
        <td style="width:10%; text-align: center; vertical-align:middle; border-bottom:  0.3px solid black;">'.$dias1.'</td>  
        <td style="width:1%;  text-align: center; vertical-align:middle;" ></td> 
        <td style="width:10%; text-align: center; vertical-align:middle; border-bottom:  0.3px solid black;">'.$totales1.'</td>   
    </tr>
    <tr>
        <td style="width:11%; text-align: center;"></td>
        <td style="width:15%; text-align: center; vertical-align:middle;">CUOATA DIARA(II) $</td>
        <td style="width:11%; text-align: center; vertical-align:middle; border-bottom:  0.3px solid black;">'.$Himporte2.'</td>  
        <td style="width:15%; text-align: center; vertical-align:middle;">CUOATA DIARA(II) $</td>
        <td style="width:11%; text-align: center; vertical-align:middle; border-bottom:  0.3px solid black;">'.$Aimporte2.'</td>
        <td style="width:15%; text-align: center; vertical-align:middle;">NUMERO DE DIAS</td>
        <td style="width:10%; text-align: center; vertical-align:middle; border-bottom:  0.3px solid black;">'.$dias2.'</td> 
        <td style="width:1%;  text-align: center; vertical-align:middle;"></td>
        <td style="width:10%; text-align: center; vertical-align:middle; border-bottom:  0.3px solid black;">'.$totales2.'</td>   
    </tr>
    <tr>
        <td style="width:11%; text-align: center;"></td>
        <td style="width:15%; text-align: center; vertical-align:middle;">CUOATA DIARA(III) $</td>
        <td style="width:11%; text-align: center; vertical-align:middle; border-bottom:  0.3px solid black;">'.$Himporte3.'</td> 
        <td style="width:15%; text-align: center; vertical-align:middle;">CUOATA DIARA(III) $</td>
        <td style="width:11%; text-align: center; vertical-align:middle; border-bottom:  0.3px solid black;">'.$Aimporte3.'</td>
        <td style="width:15%; text-align: center; vertical-align:middle;">NUMERO DE DIAS</td>
        <td style="width:10%; text-align: center; vertical-align:middle; border-bottom:  0.3px solid black;">'.$dias3.'</td>  
        <td style="width:1%;  text-align: center; vertical-align:middle;"></td> 
        <td style="width:10%; text-align: center; vertical-align:middle; border-bottom:  0.3px solid black;">'.$totales3.'</td>  
    </tr>
    <tr>
        <td style="width:11%; text-align: center;"></td>
        <td style="width:15%; text-align: center; vertical-align:middle;">SUBTOTAL $</td>
        <td style="width:11%; text-align: center; vertical-align:middle; border-bottom:  0.3px solid black;">'.$Hsubtotal.'</td> 
        <td style="width:15%; text-align: center; vertical-align:middle;">SUBTOTAL $</td>
        <td style="width:11%; text-align: center; vertical-align:middle; border-bottom:  0.3px solid black;">'.$Asubtotal.'</td> 
        <td style="width:15%; text-align: center; vertical-align:middle;"></td>
        <td style="width:10%; text-align: center; vertical-align:middle;">TOTAL</td>  
        <td style="width:1%;  text-align: center; vertical-align:middle;"></td>
        <td style="width:10%; text-align: center; vertical-align:middle; vertical-align:middle; border-bottom:  0.3px solid black;">'.$totalesFinal.'</td>   
    </tr>
  
    <tr>
        <td Colspan="2" style="vertical-align:middle;">TRANSPORTACION</td>   
        <td Colspan="2" style="vertical-align:middle;">TERRESTRE ( '.$terrestre.' )</td>
        <td Colspan="2" style="vertical-align:middle;">CON RECORRIDO ( '.$tconrecorrido.' )</td>
        <td Colspan="2" style="vertical-align:middle;">AREA ( '.$tarea.' )</td>       
    </tr>
<tr>
    <td Colspan="3" style="vertical-align:middle;">ESPECIFIQUE RECORRIDO INTERNO</td>   
    <td Colspan="5" style="vertical-align:middle; border-bottom:  0.3px solid black;"></td>    
</tr>
    
</table></div>';


$tVehiculo='
<div style="border: 0.3px solid black;">
<table style="padding:1px;">
    <tr>
        <td style="width:0.5%;"></td>  
        <td style="width:17%">VEHICULO OFICIAL N°</td>
        <td style="width:9% vertical-align:middle;  text-align: center; border-bottom:  0.3px solid black;">'.$nvehiculo.'</td>
        <td style="width:9% vertical-align:middle;  text-align: center;">AUTOBUS</td>
        <td style="width:9% vertical-align:middle;  text-align: center;  border-bottom:  0.3px solid black;">'.$autobus.'</td>
        <td style="width:10% vertical-align:middle;  text-align: center;">PARTICULAR</td>
        <td style="width:9% vertical-align:middle;  text-align: center;  border-bottom:  0.3px solid black;">'.$particular.'</td>
        <td style="width:9% vertical-align:middle;  text-align: center;">MARCA</td>
        <td style="width:9% vertical-align:middle;  text-align: center;  border-bottom:  0.3px solid black;">'.$marca.'</td>
        <td style="width:9% vertical-align:middle;  text-align: center;">MODELO</td>
        <td style="width:9% vertical-align:middle;  text-align: center;  border-bottom:  0.3px solid black;">'.$modelo.'</td>
        <td></td>   
    </tr>
    <tr>
        <td></td> 
        <td colspan="2" style="width:17%;  vertical-align:middle;">TIPO</td>
        <td style="width:17%; text-align: center; vertical-align:middle; border-bottom:  0.3px solid black;">'.$tipo.'</td>
        <td colspan="2" style="width:17%;  text-align: center; vertical-align:middle; ">PLACAS</td>
        <td style="width:16%;  text-align: center; vertical-align:middle; border-bottom:  0.3px solid black;">'.$placas.'</td>
        <td colspan="2" style=" width:17%;  text-align: center; vertical-align:middle;">CILINDRAJE</td>
        <td style="width:15%; text-align: center;vertical-align:middle; border-bottom:  0.3px solid black;">'.$cilindraje.'</td>       
        <td></td> 
    </tr>
    
    <tr>
        <td></td> 
        <td colspan="2" style=" width:17%;  vertical-align:middle;">KMS. RECORRIDOS</td>
        <td style="width:17%; text-align: center;vertical-align:middle; border-bottom:  0.3px solid black;">'.$kmsrecorridos.'</td>
        <td style="width:17%; text-align: center;  vertical-align:middle;">CUOTA</td>
        <td colspan="2"  style="  width:17%;text-align: center; vertical-align:middle;">(  '.$a.'  )A (  '.$a.'  )B (  '.$a.'  )C (  '.$a.'  )D</td>
        <td colspan="2" style=" width:16%; text-align: center; vertical-align:middle;">TOTAL DE RECORRIDO</td>
        <td style="  width:15%;text-align: center; vertical-align:middle; border-bottom:  0.3px solid black;">'.$kms.'</td>          
        <td></td> 
    </tr>
    <tr>
        <td></td> 
        <td colspan="2" style="width:21%; vertical-align:middle; " >KMS. RECORRIDO INTERNO</td>
        <td style="width:13%; text-align: center;vertical-align:middle; border-bottom:  0.3px solid black;">'.$kmsrecorridointerno.'</td>
        <td colspan="2" style="width:20%; text-align: center; vertical-align:middle;">PRECIO COMBUSTIBE</td>
        <td style="width:13%; text-align: center;vertical-align:middle; border-bottom:  0.3px solid black;">'.$preciocombustible.'</td>
        <td colspan="2" style="width:20% text-align: center; vertical-align:middle;">AUTOBUS/PEAJE/TAXI</td>
        <td style="width:12%;  text-align: center;vertical-align:middle; border-bottom:  0.3px solid black;">'.$autobuspeaje.'</td>
        <td></td>        
    </tr>
    <tr> 
        <td></td>      
        <td style="width:10%;">KMS.</td>      
        <td style="width:10%;text-align: center;vertical-align:middle; border-bottom:  0.3px solid black;">'.$kms.'</td>  
        <td style="width:10%; text-align: center; ">(X) P/U</td>      
        <td style="width:10%;text-align: center;vertical-align:middle; border-bottom:  0.3px solid black;">'.$xpu.'</td> 
        <td style="width:10%; text-align: center; ">(/)CIL</td>      
        <td style="width:10%;text-align: center;vertical-align:middle; border-bottom:  0.3px solid black;">'.$cil.'</td>   
        <td colspan="2" style="width:30%; text-align: center; ">TOTAL DE TRANSPORTACION</td>      
        <td style="width:9%; text-align: center;vertical-align:middle; border-bottom:  0.3px solid black;">'.$totalTransportacion.'</td>
        <td></td>       
    </tr>
    <tr>
        <td></td> 
        <td Colspan="4" style="text-align: center;vertical-align:middle; border-bottom:  0.3px solid black;">'.$empleado.'</td> 
        <td  style="whidth:2%"></td>    
        <td Colspan="4" style="text-align: center;vertical-align:middle; border-bottom:  0.3px solid black;">'.$fechaletra.'</td>  
        <td></td>   
    </tr>
    <tr>
        <td></td> 
        <td Colspan="4" style="text-align: center;vertical-align:middle;">COMSIONADO</td> 
        <td  style="whidth:2%"></td>    
        <td Colspan="4" style="text-align: center;vertical-align:middle;"></td>    
        <td></td> 
    </tr>
</table></div>';


$tFirmas='
<div style="border: 0.3px solid black;">
<table style="padding:2px;">   
    <tr >
        <td></td> 
        <td colspan="4" style="text-align: center;vertical-align:middle; border-bottom:  0.3px solid black;">'.$director.'</td> 
        <td style="whidth:2%"></td>    
        <td colspan="4" style="text-align: center;vertical-align:middle; border-bottom:  0.3px solid black;">'.$organoControl.'</td>  
        <td></td>  
    </tr>
    <tr>
        <td></td>  
        <td colspan="4" style="text-align: center;vertical-align:middle;">DIRECTOR GENERAL</td> 
        <td style="whidth:2%"></td>    
        <td colspan="4" style="text-align: center;vertical-align:middle;">ORGANO DE CONTROL</td> 
        <td></td>            
    </tr>
    <tr>
        <td></td>  
        <td colspan="4" style="text-align: center;vertical-align:middle; ">(NOMBRE Y FIRMA)</td> 
        <td cstyle="whidth:2%"></td>    
        <td colspan="4" style="text-align: center;vertical-align:middle; ">(NOMBRE Y FIRMA)</td> 
        <td></td>           
    </tr>
    

    <tr>
        <td style="height:20%;"></td>   
    </tr>
    <tr>
        <td></td>  
        <td colspan="4" style="text-align: center;vertical-align:middle; border-bottom:  0.3px solid black;">'.$dirAdmon.'</td> 
        <td style="whidth:2%"></td>    
        <td colspan="4" style="text-align: center;vertical-align:middle; border-bottom:  0.3px solid black;">'.$empleado.'</td>    
        <td></td>  
    </tr>
    <tr>
        <td></td>  
        <td colspan="4" style="text-align: center;vertical-align:middle; ">DIRECTOR ADMINISTRATIVO</td> 
        <td style="whidth:2%"></td>    
        <td colspan="4" style="text-align: center;vertical-align:middle;" >RECIBE Y CHEQUE</td>  
        <td></td>           
    </tr>
    <tr>
        <td></td>  
        <td colspan="4" style="text-align: center;vertical-align:middle; ">(NOMBRE Y FIRMA)</td> 
        <td style="whidth:2%"></td>    
        <td colspan="4" style="text-align: center;vertical-align:middle; ">(NOMBRE Y FIRMA)</td> 
        <td></td>           
    </tr>
    
</table></div> <br><br>';
$tabla=$tablaviaticos.$tVehiculo.$tFirmas;


//echo $tabla;
$orientacion='P';
 $autor="Instituto Tamualipeco de Vivienda y Urbanismo";
 $titulo="Direccion de Administracion y Finanzas";

 $descripcion="Departamento de Adquisiciones";




// create new PDF document
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
  ob_end_clean();   
// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor($autor);
$pdf->SetTitle(strtoupper($titulo));
$pdf->SetSubject($descripcion);
$pdf->SetKeywords('REQUISICION DE PAPELERIA');



$pdf->SetHeaderData('pdf_logo.jpg', '40',strtoupper($titulo).'', strtoupper($descripcion));

// set default header data
//$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, strtoupper($titulo).'', strtoupper($descripcion));
// set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));

$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
// set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);

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
$pdf->SetFont('helvetica', '', 7);
// add a page
$pdf->AddPage($orientacion); //en la tabla de reporte L o P
$html = $tabla;

//echo $html; aqui escribe el contenido de la consulta


$pdf->writeHTML($html, true, false, true, false, '');



$pdf->SetFont('Helvetica','B',7); 
$pdf->SetXY(10,253);
$pdf->Cell(60,10,"REVISÓ",0 ,0,'C',0);
$pdf->SetXY(10,265);
$pdf->SetFont('Helvetica','',7); 
$pdf->Cell(60,10,$TitularAdquisiciones, 0,0,'C',0);

$pdf->SetXY(10,260);
$pdf->SetFont('Helvetica','B',7); 
$pdf->Cell(60,10,"DPTO. DE ADQUISICIONES", 0,0,'C',0);


$pdf->SetXY(75,253);
$pdf->SetFont('Helvetica','B',7);  
$pdf->Cell(60,10,"SOLICITANTE", 0,0,'C',0);
$pdf->SetXY(75,265);
$pdf->SetFont('Helvetica','',7);
//////////////BORRARR
// if($Direccion=='DIRECCION DE ADMINISTRACION Y FINANZAS') 
//  {
//     $Titular='MARIA KURI SÁNCHEZ';
//     $Direccion='ENCARGADA DE LA DIRECCIÓN DE ADMINISTRACIÓN Y FINANZAS ';
//  }

 /////////////////////// IF QUE SERVIA PARA PONER EL  JEFE DE DPTO  EN LUGAR DEL DIRECTOR SOLO AREA ADMINISTRATIVA
 //if ($dir==54)
//{
//$pdf->Cell(60,10,$TitularJ, 0,0,'C',0);
//}
//else
// {
  
$pdf->Cell(60,10,$Titular, 0,0,'C',0);
//}

 

$pdf->SetXY(75,263);
$y = $pdf->GetY();
$pdf->SetFont('Helvetica','B',7); 
// if ($dir==54) IF QUE SERVIA PARA PONER EL  DPTO  EN LUGAR DEL DIRECCION SOLO AREA ADMINISTRATIVA
// {
// $pdf->MultiCell(60,4,$Departamento,0,'C'); 
// }
// else
//  {
  
$pdf->MultiCell(60,4,$Direccion,0,'C'); 
//}

$pdf->SetXY(75,$y);

$pdf->SetXY(140,253);
$pdf->SetFont('Helvetica','B',7);  
$pdf->Cell(60,10,"VoBo", 0,0,'C',0);
$pdf->SetXY(140,265);
$pdf->SetFont('Helvetica','',7); 
//$TitularFinanzas='ARQ. SALVADOR GONZALEZ GARZA';
$pdf->Cell(60,10,$TitularFinanzas, 0,0,'C',0);
$pdf->SetXY(140,260);
$pdf->SetFont('Helvetica','B',7); 


//$pdf->Cell(60,10,"DIRECTOR GENERAL", 0,0,'C',0);// BORRAR
//$pdf->SetXY(140,263);// BORRRAR
//$pdf->Cell(60,10," DE ADMINISTRACIÓN Y FINANZAS ", 0,0,'C',0);// BORRAR
$pdf->Cell(60,10,"DIR. DE ADMINISTRACIÓN Y FINANZAS", 0,0,'C',0);



 /////////// Informacion de quien imprimio el formato
$pdf->SetFont('Helvetica','',6);   
$pdf->Text(20, 276, 'Impreso por :'.$nitavu); 
        
//$pdf->Cell(50,10,"Empleado No.:".$nitavu, 0,0,'C',0);
// $pdf->SetXY(160,275);
// $pdf->Cell(50,10,$nitavu, 0,0,'C',0);

ob_end_clean();
 if($orientacion == 'P'){
	//echo $orientacion;
	// if(isset($t2) or isset($t3)){
	// $pdf->AddPage($orientacion); //en la tabla de reporte L o P
	// //$pdf->writeHTMLCell(100, '', 60,$y, $t3, 0, 0, 0, true, 'J', true);
	// }
	// $y = $pdf->getY();
	// // writeHTMLCell($w, $h, $x, $y, $html='', $border=0, $ln=0, $fill=0, $reseth=true, $align='', $autopadding=true)
	// if(isset($t2)){
	// 	$pdf->writeHTMLCell(100, '', '', $y, $t2, 0, 0, 0, false, 'J', true);
	// }
	// if (isset($t3)){
	// 	$pdf->writeHTMLCell(100, '', '', '', $t3, 0, 0, 0, true, 'J', true);
    // }
    
  
	// reset pointer to the last page
	$pdf->lastPage();
	//Close and output PDF document}
	$pdf->Output('reporte.pdf', 'I');
}
?>