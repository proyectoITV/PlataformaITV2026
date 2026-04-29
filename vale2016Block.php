<?php

require("config.php");
require_once('seguridad.php');
require_once('pdf/tcpdf.php');
//$nitavu="2809";
require('lib/yes_funciones.php');

error_reporting(0);

$credito=0;
$beneficiario="beneficiario";
$fecha="fecha";
$lugar="lugar";
$canitdad="00";
$numVale="0";
$numcontrato="067841050265";

// style="border:1px solid black;
$Vale1='<table width="115%"   style="border:1px solid black; padding: 2px;">
<tr>
    <td width="8%" rowspan="18" style="border:1px solid black;"><br><br><br><br><br><img src="img/textoVale.jpg" style="width:200px; height:900px; "/></td>
    <td rowspan="3"><img src="img/logotam.jpg" style="width:120px; Height:30px;" /></td>
    <td colspan="3"><p style="text-align: center;vertical-align:middle; font-weight:bold;  font-size:10pt;">INSTITUTO TAMAULIPECO DE VIVIENDA Y URBANISMO</p></td>
</tr>
<tr>
    <td colspan="3"><p style="text-align: center;vertical-align:middle; ">MEJOR VIVIENDA 2005</p></td>
</tr>
<tr>
    <td width="40%"><p style="text-align: center;vertical-align:middle; font-weight:bold;">ORIGINAL BENEFICIARIO</p></td>
    <td width="10%"><p>Londres</p></td>
    <td width="10%"><p>Londres</p></td>
</tr>
<tr>
    <td><p>'.$numVale.'</p></td>
    <td width="40%"><p style="text-align: center;vertical-align:middle; font-weight:bold; font-size:11pt;">VALE NOMINATIVO DE MATERIALES</p></td>
    <td colspan="2" ><p>IVU-RP-PO-05-RE-06</p></td>
</tr>
<tr>
    <td width="10%"><p style="text-align: center;vertical-align:middle; font-weight:bold;">N° de Credito</p></td>
    <td width="10%"><p>'.$credito.'</p></td>
    <td width="30%"><p style="text-align: center;vertical-align:middle; font-weight:bold;"></p></td>
    <td width="30%"><p style="text-align: center;vertical-align:middle;">LUGAR Y FECHA DE EXPEDICIÓN</p></td>
</tr>
<tr>
    <td colspan="2" width="50%"><p style="text-align: center;vertical-align:middle; font-weight:bold; "></p></td>
    <td width="15%"><p style="text-align: center;vertical-align:middle; font-weight:bold;">'.$fecha.'</p></td>
    <td width="15%"><p style="text-align: center;vertical-align:middle; font-weight:bold;">'.$lugar.'</p></td>
</tr>
<tr>
    <td width="20%"><p style="text-align: center;vertical-align:middle; ">Entreguese por este vale a el(la) beneficiario(a)</p></td>
    <td width="25%"><p>'.$beneficiario.'</p></td>
    <td width="20%"><p style="text-align: center;vertical-align:middle;">Material por la cantidad de:</p></td>
    <td width="15%"><p style="text-align: center;vertical-align:middle;">'.$canitdad.'</p></td>
</tr>

<tr>
    <td width="40%"><p style="text-align: center;vertical-align:middle;">Text 11</p></td>
    <td width="40%"><p style="text-align: center;vertical-align:middle;">AUTORIZÓ</p></td>
</tr>
<tr>
    <td width="40%"><p style="text-align:justify ;vertical-align:middle;">EL MATERIAL SERÁ DEFINIDO POR EL BENEFICIARIO APEGANDOSE A LA LISTA AUTORIZADA</p></td>
    <td width="40%" ><p style="text-align: center;vertical-align:middle;"></p></td>
</tr>

<tr>
    <td width="26%"><p style="text-align:justify ;vertical-align:middle;">Domicilio</p></td>
    <td width="10%"><p style="text-align:justify ;vertical-align:middle;"></p></td>
    <td width="44%"><p style="text-align: center;vertical-align:middle;">LABEL43</p></td>
</tr>
<tr>
    <td width="40%"><p style="text-align:justify ;vertical-align:middle;"></p></td>
    <td width="40%"><p style="text-align: center;vertical-align:middle;">LABEL41</p></td>
</tr>
<tr>
    <td width="36%"><p style="text-align:center ;vertical-align:middle;">ENTREGO MATERIAL</p></td>
    <td width="44%"  style="border-left: 1px solid black; border-top: 1px solid black;"><p style="text-align: center;vertical-align:middle;">RECIBI MATERIAL COMPLETO Y A MI ENTERA SATISFACCIÓN</p></td>
</tr>
<tr>
    <td width="36%"><p style="text-align:center ;vertical-align:middle;">LABEL 12</p></td>
    <td width="44%"  style="border-left: 1px solid black;"><p style="text-align: center;vertical-align:middle; "></p></td>
</tr>
<tr>
    <td width="26%"><p style="text-align:justify ;vertical-align:middle;">Telefono</p></td>    
    <td width="10%"><p style="text-align:justify ;vertical-align:middle;"></p></td>
    <td width="44%"  style="border-left: 1px solid black;" ><p style="text-align: center;vertical-align:middle;"></p></td>
</tr>
<tr>
    <td width="26%"><p style="text-align:justify ;vertical-align:middle;"></p></td>    
    <td width="10%"><p style="text-align:justify ;vertical-align:middle;"></p></td>
    <td width="44%" style="border-left: 1px solid black;"><p style="text-align: center;vertical-align:middle;">NOMBRE Y FIRMA DEL BENEFICIARIO O PERSONA QUE AUTORIZA</p></td>
</tr>
<tr>
    <td width="10%"><p style="text-align:justify ;vertical-align:middle; font-weight:bold;">Tipo de Mejora</p></td> 
    <td width="26%"><p style="text-align:justify ;vertical-align:middle;">Nombe del empleado y sello de la empresa</p></td>      
    <td width="14%" style="border-bottom: 1px solid black; border-left: 1px solid black;" ><p style="text-align:justify ;vertical-align:middle;">FECHA DE ENTREGA</p></td>
    <td width="30%" style="border-bottom: 1px solid black;"><p style="text-align: center;vertical-align:middle;"></p></td>
</tr>
<tr>
    <td width="70%"><p style="text-align:justify ;vertical-align:middle;  font-size:7pt;">NOTA 1 : PARA HACER EFECTIVO ESTE VALE ES REQUISITO INDISPENSABLE QUE ESTÉ ACOMPAÑADO CON COPIA DE IDENTIFICACIÓN OFICIAL CON FOTOGRAFIA DEL BENEFICIARIO Y DE LA PERSONA AUTORIZADA A RECIBIR EL MATERIAL EN CASO DE QUE SEA DISTINTA DEL BENEFICIARIO.</p></td>
    <td width="10%" rowspan="2" style="text-align:justify ;vertical-align:middle;">';
   	
		//  //SE GENERA EL CODIGO QR	
		 $codesDir = "tmp/CodigosQR/"; //Carpeta donde se almacenaran los QR  
         $contenido=$numcontrato.$numVale;
         $codigoQR=GenerarQR($contenido);  
       
       $Vale1=$Vale1.'<img  src="'.$codesDir.$codigoQR.'"/></td>        
</tr>
<tr>
    <td width="70%"><p style="text-align:justify ;vertical-align:middle; font-size:6pt;">Este programa es de carácter público, no es patrocinado ni promovido por partido político alguno y sus recursos provienen de los impuestos que pagan todos los contribuyentes. Está prohibido el uso de éste programa con fines políticos, electorales, de lucro y otros distintos a los establecidos. Quien haga uso indebido de los recursos de éste programa deberá ser denunciado y sancionado de acuerdo con la ley aplicable y ante la autoridad competente.</p></td>       
    </tr>
</table><br><br>';

$Vale2='<table width="115%"   style=" border:1px solid blac; padding: 2px;">
<tr>
    <td width="8%" rowspan="18" style="border:1px solid black;"><br><br><br><br><br><img src="img/textoVale.jpg" style="width:200px; height:900px; "/></td>
    <td rowspan="3"><img src="img/logotam.jpg" style="width:120px; Height:30px;" /></td>
    <td colspan="3"><p style="text-align: center;vertical-align:middle; font-weight:bold;  font-size:10pt;">INSTITUTO TAMAULIPECO DE VIVIENDA Y URBANISMO</p></td>
</tr>
<tr>
    <td colspan="3"><p style="text-align: center;vertical-align:middle; ">MEJOR VIVIENDA 2005</p></td>
</tr>
<tr>
    <td width="40%"><p style="text-align: center;vertical-align:middle; font-weight:bold;">ORIGINAL BENEFICIARIO</p></td>
    <td width="10%"><p>Londres</p></td>
    <td width="10%"><p>Londres</p></td>
</tr>
<tr>
    <td><p>'.$numVale.'</p></td>
    <td width="40%"><p style="text-align: center;vertical-align:middle; font-weight:bold; font-size:11pt;">VALE NOMINATIVO DE MATERIALES</p></td>
    <td colspan="2" ><p>IVU-RP-PO-05-RE-06</p></td>
</tr>
<tr>
    <td width="10%"><p style="text-align: center;vertical-align:middle; font-weight:bold;">N° de Credito</p></td>
    <td width="10%"><p>'.$credito.'</p></td>
    <td width="30%"><p style="text-align: center;vertical-align:middle; font-weight:bold;"></p></td>
    <td width="30%"><p style="text-align: center;vertical-align:middle;">LUGAR Y FECHA DE EXPEDICIÓN</p></td>
</tr>
<tr>
    <td colspan="2" width="50%"><p style="text-align: center;vertical-align:middle; font-weight:bold; "></p></td>
    <td width="15%"><p style="text-align: center;vertical-align:middle; font-weight:bold;">'.$fecha.'</p></td>
    <td width="15%"><p style="text-align: center;vertical-align:middle; font-weight:bold;">'.$lugar.'</p></td>
</tr>
<tr>
    <td width="20%"><p style="text-align: center;vertical-align:middle; ">Entreguese por este vale a el(la) beneficiario(a)</p></td>
    <td width="25%"><p>'.$beneficiario.'</p></td>
    <td width="20%"><p style="text-align: center;vertical-align:middle;">Material por la cantidad de:</p></td>
    <td width="15%"><p style="text-align: center;vertical-align:middle;">'.$canitdad.'</p></td>
</tr>

<tr>
    <td width="40%"><p style="text-align: center;vertical-align:middle;">Text 11</p></td>
    <td width="40%"><p style="text-align: center;vertical-align:middle;">AUTORIZÓ</p></td>
</tr>
<tr>
    <td width="40%"><p style="text-align:justify ;vertical-align:middle;">EL MATERIAL SERÁ DEFINIDO POR EL BENEFICIARIO APEGANDOSE A LA LISTA AUTORIZADA</p></td>
    <td width="40%" ><p style="text-align: center;vertical-align:middle;"></p></td>
</tr>

<tr>
    <td width="26%"><p style="text-align:justify ;vertical-align:middle;">Domicilio</p></td>
    <td width="10%"><p style="text-align:justify ;vertical-align:middle;"></p></td>
    <td width="44%"><p style="text-align: center;vertical-align:middle;">LABEL43</p></td>
</tr>
<tr>
    <td width="40%"><p style="text-align:justify ;vertical-align:middle;"></p></td>
    <td width="40%"><p style="text-align: center;vertical-align:middle;">LABEL41</p></td>
</tr>
<tr>
    <td width="36%"><p style="text-align:center ;vertical-align:middle;">ENTREGO MATERIAL</p></td>
    <td width="44%"  style="border-left: 1px solid black; border-top: 1px solid black;"><p style="text-align: center;vertical-align:middle;">RECIBI MATERIAL COMPLETO Y A MI ENTERA SATISFACCIÓN</p></td>
</tr>
<tr>
    <td width="36%"><p style="text-align:center ;vertical-align:middle;">LABEL 12</p></td>
    <td width="44%"  style="border-left: 1px solid black;"><p style="text-align: center;vertical-align:middle; "></p></td>
</tr>
<tr>
    <td width="26%"><p style="text-align:justify ;vertical-align:middle;">Telefono</p></td>    
    <td width="10%"><p style="text-align:justify ;vertical-align:middle;"></p></td>
    <td width="44%"  style="border-left: 1px solid black;" ><p style="text-align: center;vertical-align:middle;"></p></td>
</tr>
<tr>
    <td width="26%"><p style="text-align:justify ;vertical-align:middle;"></p></td>    
    <td width="10%"><p style="text-align:justify ;vertical-align:middle;"></p></td>
    <td width="44%" style="border-left: 1px solid black;"><p style="text-align: center;vertical-align:middle;">NOMBRE Y FIRMA DEL BENEFICIARIO O PERSONA QUE AUTORIZA</p></td>
</tr>
<tr>
    <td width="10%"><p style="text-align:justify ;vertical-align:middle; font-weight:bold;">Tipo de Mejora</p></td> 
    <td width="26%"><p style="text-align:justify ;vertical-align:middle;">Nombe del empleado y sello de la empresa</p></td>      
    <td width="14%" style="border-bottom: 1px solid black; border-left: 1px solid black;" ><p style="text-align:justify ;vertical-align:middle;">FECHA DE ENTREGA</p></td>
    <td width="30%" style="border-bottom: 1px solid black;"><p style="text-align: center;vertical-align:middle;"></p></td>
</tr>
<tr>
    <td width="70%"><p style="text-align:justify ;vertical-align:middle;  font-size:7pt;">NOTA 1 : PARA HACER EFECTIVO ESTE VALE ES REQUISITO INDISPENSABLE QUE ESTÉ ACOMPAÑADO CON COPIA DE IDENTIFICACIÓN OFICIAL CON FOTOGRAFIA DEL BENEFICIARIO Y DE LA PERSONA AUTORIZADA A RECIBIR EL MATERIAL EN CASO DE QUE SEA DISTINTA DEL BENEFICIARIO.</p></td>
    <td width="10%" rowspan="2" style="text-align:justify ;vertical-align:middle;">';
   	
		//  //SE GENERA EL CODIGO QR	
		// $codesDir = "tmp/CodigosQR/"; //Carpeta donde se almacenaran los QR  
        // $contenido=$numcontrato.$numVale;
         //$codigoQR=GenerarQR($contenido);  
       
       $Vale2=$Vale2.'<img  src="'.$codesDir.$codigoQR.'"/></td>        
</tr>
<tr>
    <td width="70%"><p style="text-align:justify ;vertical-align:middle; font-size:6pt;">Este programa es de carácter público, no es patrocinado ni promovido por partido político alguno y sus recursos provienen de los impuestos que pagan todos los contribuyentes. Está prohibido el uso de éste programa con fines políticos, electorales, de lucro y otros distintos a los establecidos. Quien haga uso indebido de los recursos de éste programa deberá ser denunciado y sancionado de acuerdo con la ley aplicable y ante la autoridad competente.</p></td>       
    </tr>
</table>';


$Vale3='<BR><BR><table  width="115%" style="border:1px solid black;">
<tr>
    <td width="20%" rowspan="3"><br><br><img src="img/logotam.jpg" style="width:130px; Height:40px; margin-left:30px;" /></td>
    <td width="48%" colspan="3"><p style="text-align: center;vertical-align:middle; font-weight:bold; font-size:10pt;">INSTITUTO TAMAULIPECO DE VIVIENDA Y URBANISMO</p></td>
    <td width="20%" rowspan="3"><br><br><img src="img/itavuLogo.png" style="width:130px; Height:40px;" /></td>
</tr>
<tr>
    <td colspan="3"><p style="text-align: center;vertical-align:middle; ">MEJOR VIVIENDA 2005</p></td>
</tr>
<tr>
    <td colspan="3"><p style="text-align: center;vertical-align:middle; font-weight:bold; font-size:10pt;">FORMATO DE RECEPCION DE BLOCK</p></td>
</tr>
<tr>
    <td  width="10%"><p style="vertical-align:middle; font-weight:bold;">Contrato</p></td>
    <td  width="20%"><p style="vertical-align:middle; font-weight:bold;"></p></td>
    <td  width="58%"><p style="vertical-align:middle; font-weight:bold;"></p></td>
</tr>
<tr>
    <td  width="10%"><p style="vertical-align:middle; font-weight:bold;">Solicitud</p></td>
    <td  width="20%"><p style="vertical-align:middle; font-weight:bold;"></p></td>
    <td  width="58%"><p style="vertical-align:middle; font-weight:bold;"></p></td>
</tr>
<tr>
    <td  width="10%"><p style="vertical-align:middle; font-weight:bold;">Se entregan</p></td>
    <td  width="20%"><p style="vertical-align:middle; font-weight:bold;"></p></td>
    <td  width="58%"><p style="vertical-align:middle; font-weight:bold;"> a el(la) C.</p></td>
</tr><br>
<tr>
    <td colspan="3"><p style="text-align: center; vertical-align:middle; font-weight:bold;">EL CUAL DEBERÁ SER RETIRADO DE LA BLOQUERA DENTRO DE 5 A 7 DIAS SIGUIENTES A LA FECHA DE PRODUCCION</p></td>  
</tr><br>
<tr>
    <td  width="44%"><p style="text-align: center; vertical-align:middle; font-weight:bold;">Persona que Entrega</p></td> 
    <td  width="44%"><p style="text-align: center; vertical-align:middle; font-weight:bold;">Recibi Block</p></td>   
</tr><br>

<tr>
    <td  width="44%"><p style="text-align: center; vertical-align:middle; font-weight:bold;">___________________________________________________</p></td> 
    <td  width="44%"><p style="text-align: center; vertical-align:middle; font-weight:bold;">___________________________________________________</p></td>   
</tr>
<tr>
<td></td>
</tr>
</table>';

// style="border:1px solid black;
$Vale4='<BR><BR><table width="115%" style="border:1px solid black;">
<tr>
    <td width="20%" rowspan="3"><br><br><img src="img/logotam.jpg" style="width:130px; Height:40px; margin-left:30px;" /></td>
    <td width="48%" colspan="3"><p style="text-align: center;vertical-align:middle; font-weight:bold; font-size:10pt;">INSTITUTO TAMAULIPECO DE VIVIENDA Y URBANISMO</p></td>
    <td width="20%" rowspan="3"><br><br><img src="img/itavuLogo.png" style="width:130px; Height:40px;" /></td>
</tr>
<tr>
    <td colspan="3"><p style="text-align: center;vertical-align:middle; ">MEJOR VIVIENDA 2005</p></td>
</tr>
<tr>
    <td colspan="3"><p style="text-align: center;vertical-align:middle; font-weight:bold; font-size:10pt;">FORMATO DE RECEPCION DE VALE</p></td>
</tr>
<tr>
    <td  width="10%"><p style="vertical-align:middle; font-weight:bold;">Contrato</p></td>
    <td  width="20%"><p style="vertical-align:middle; font-weight:bold;"></p></td>
    <td  width="58%"><p style="vertical-align:middle; font-weight:bold;"></p></td>
</tr>
<tr>
    <td  width="10%"><p style="vertical-align:middle; font-weight:bold;">Solicitud</p></td>
    <td  width="20%"><p style="vertical-align:middle; font-weight:bold;"></p></td>
    <td  width="58%"><p style="vertical-align:middle; font-weight:bold;"></p></td>
</tr>
<tr>
    <td  width="30%"><p style="vertical-align:middle; ">Se entrega vale de material a nombre de el(la)</p></td>   
    <td  width="58%"><p style="vertical-align:middle; font-weight:bold;"></p></td>
</tr>
<tr>
    <td  width="20%"><p style="vertical-align:middle; ">Por la cantidad de</p></td>   
    <td  width="24%"><p style="vertical-align:middle; font-weight:bold;"></p></td>
    <td  width="44%"><p style="vertical-align:middle; font-weight:bold;"></p></td>
</tr>
<tr>
    <td  width="44%"><p style="text-align: center; vertical-align:middle; font-weight:bold;">Fecha de entrega del vale</p></td> 
    <td  width="44%"><p style="text-align: center; vertical-align:middle; font-weight:bold;">Recibi Vale</p></td>   
</tr><br>

<tr>
    <td  width="44%"><p style="text-align: center; vertical-align:middle; font-weight:bold;">___________________________________________________</p></td> 
    <td  width="44%"><p style="text-align: center; vertical-align:middle; font-weight:bold;">___________________________________________________</p></td>   
</tr>
<tr>
<td></td>
</tr>
</table>';



$tabla=$Vale1.$Vale2.$Vale3.$Vale4;





//echo $tabla;
$orientacion='P';
$autor="Instituto Tamualipeco de Vivienda y Urbanismo";
$titulo="Direccion de Administracion y Finanzas";
$descripcion="Departamento de Adquisiciones";




// create new PDF document
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, 'LEGAL', true, 'UTF-8', false);
  ob_end_clean();   
// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor($autor);
$pdf->SetTitle(strtoupper($titulo));
$pdf->SetSubject($descripcion);
$pdf->SetKeywords('REQUISICION DE PAPELERIA');



$pdf->SetHeaderData('pdf_logo.jpg', '20',strtoupper($titulo).'', strtoupper($descripcion));

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
$pdf->SetFont('helvetica', '', 8);
// add a page
$pdf->AddPage($orientacion); //en la tabla de reporte L o P
$html = $tabla;
//echo $html; 
//aqui escribe el contenido de la consulta


$pdf->writeHTML($html, true, false, true, false, '');

ob_end_clean();
 if($orientacion == 'P'){

	$pdf->lastPage();
	//Close and output PDF document}
	$pdf->Output('reporte.pdf', 'I');
}
?>