<?php
    require("config.php");
    require_once('lib/flor_funciones.php');
    //require_once('lib/funciones.php');
    require_once('pdf/tcpdf.php');


    error_reporting(0); //<-- para simular produccion
  // Extend the TCPDF class to create custom Header and Footer
  class MYPDF1 extends TCPDF {

    //Page header
    public function Header() {
      // Logo
      $image_file = K_PATH_IMAGES.'pagoMandantes.jpg';
     // $this->Image($image_file, 10, 10, 45, 12, 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);
      $this->Image($image_file, 0, 0, 220, 28, 'JPG', '', 'T', false, 300, '', false, false, 0, false, false, false);

    }
    // Page footer
    public function Footer() {
        // Position at 15 mm from bottom
        //$this->SetY(-25);
        //$this->SetY(-15);
        // Set font
        //$this->SetFont('helvetica', 'I', 8);
        // Page number
        //$this->Cell(0, 10, 'Page '.$this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');

        // writeHTMLCell (w, h, x, y, html = '', border = 0, ln = 0, fill = 0, reseth = true, align = '', autopadding = true) 
       // $this->writeHTMLCell(80, 20, 120, -25, '<img src="img/logoCredito2.png" />',0,0,0, true, 'R', false);
        //$image_file = K_PATH_IMAGES.'logoCredito2.jpg';
        $image_file = K_PATH_IMAGES.'pagoMandantesPie.jpg';
        //Imagen (archivo, x = '', y = '', w = 0, h = 0, type = '', link = nil, align = '', resize = false, dpi = 300, palign = '', ismask = false, imgmask = false, border = 0, fitbox = false, hidden = false, fitonpage = false)
        $this->Image($image_file, 130, 255, 80, 20, 'JPG', '', 'T', false, 300, '', false, false, 0, false, false, false);

        
        // Set font
        // $this->SetFont('helvetica', 'I', 8);
        // Page number
        //$this->Cell(0, 10, 'Page '.$this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
    }
  }


    $numoficio = $_GET['numoficio'];
    $fechainicio = $_GET['fechainicio'];
    $fechafin = $_GET['fechafin'];

   // $numoficio = 'MEMORÁNDUM DAF/DC/0043/2020.';
    //$fechainicio = '20200901';
    //$fechafin = '20201031';

    $anio = date("Y", strtotime($fechainicio));
    $mes = date("m", strtotime($fechainicio));
    $mesFin = date("m", strtotime($fechafin));

    

    $meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
    $fechaComoEntero = date('d').' de '.$meses[date('n')-1].' del '.date('Y');
    $fecha =$meses[$mes-1];
    $fecha2 =$meses[$mesFin-1];

    //echo $mes; echo $mesFin;
    //$pagina_anterior="mandantes_pago.php?idmandante=".$idmandante."&idcolonia=".$idcolonia."&idmunicipio=".$idmunicipio;


  

 
    $orientacion='P';

//$html = $tabla;
//echo $html;
//echo $firma;
//php tcpdf_addfont.php i- [your-font.ttf]ob_end_clean();
//header('Content-type: application/vnd.ms-word;charset=iso-8859-15');
//header('Content-Disposition: attachment; filename=ejemplo.doc');

// create new PDF document
$pdf = new MYPDF1(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Nicola Asuni');
$pdf->SetTitle('TCPDF Example 003');
$pdf->SetSubject('TCPDF Tutorial');
$pdf->SetKeywords('TCPDF, PDF, example, test, guide');

// set default header data
$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);

// set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
//$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
$pdf->SetMargins(15, 25, 15);

// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, 28);


// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// set some language-dependent strings (optional)
if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
    require_once(dirname(__FILE__).'/lang/eng.php');
    $pdf->setLanguageArray($l);
}

// Add first page of the PDF

$pdf->AddPage($orientacion,'LETTER');
// ---------------------------------------------------------
//CAMBIO DE FUENTES
// set font
$tabla3="";
$tabla3 = $tabla3.'<table>';
$tabla3 = $tabla3.'<tr><td align="right">'.$numoficio.'.</td></tr>';
$tabla3 = $tabla3.'<tr><td align="right">Ciudad Victoria, Tam., a '.$fechaComoEntero.'.</td></tr>';
$tabla3 = $tabla3.'<tr><td ></td></tr></table>';
//$pdf->SetFont('helveticaneueltstd-lt', '', 10);
$pdf->AddFont('helveticaneueltstd-lt', '', '' . "'helveticaneueltstd-lt'.php");
// set font
$pdf->SetFont('helveticaneueltstd-lt', '', 11,'',true);
$pdf->writeHTML($tabla3, true, false, true, false, '');

/*$tabla1="";
$tabla1 = $tabla1.'<table><tr><td align="left"><b>C.P. DENNISE BETSABE REYES GARZA</b></td></tr></table>';
$tabla1 = $tabla1.'<span align="left"><b></b></span>';

$pdf->AddFont('novecentowide-bold', '', '' . "'novecentowide-bold'.php");
// set font
$pdf->SetFont('novecentowide-bold', '', 11,'',true);
// add a page
$pdf->writeHTML($tabla1, true, false, true, false, '');*/


$tabla="";

$tabla = $tabla.'<table><tr><td align="left"><b>C.P. DENNISE BETSABE REYES GARZA</b></td></tr><tr><td align="left">ENCARGADA DEL DEPARTAMENTO DE CONTABILIDAD</td></tr>';
$tabla = $tabla.'<tr><td align="left">Y CONTROL PRESUPUESTAL. </td></tr>';
//$tabla = $tabla.'<tr><td align="left">DEPARTAMENTO DE CONTABILIDAD Y CONTROL PRESUPUESTAL</td></tr>';
$tabla = $tabla.'<tr><td align="left">PRESENTE.</td></tr>';
$tabla = $tabla.'<tr><td ></td></tr>';
$tabla = $tabla.'<tr><td ></td></tr>';
$tabla = $tabla."</table>";

$resta = $mesFin - $mes;

//<td style="text-align: justify;">
//style="text-align: justify;"
/*$tabla = $tabla.'<p align="justify">Anexo recuperaciones de ingresos por abono a lotes correspondiente';

if($resta == 0){
  $tabla = $tabla.' al mes de &nbsp; ';
}else if($resta == 1){
  $tabla = $tabla.' a los meses de &nbsp; ';
}else{
  $tabla = $tabla.' a los meses de &nbsp; ';
}*/

$tabla = $tabla.'<table align="justify"><tr><td>Anexo recuperaciones de ingresos por abono a lotes correspondiente';



if($resta == 0){
  $tabla = $tabla.' al mes de '.$fecha.' de '.$anio.' ';
}else if($resta == 1){
  $tabla = $tabla.' a los meses de '.$fecha.' y '.$fecha2.' de '.$anio.' ';
}else{
  $tabla = $tabla.' a los meses de '.$fecha.' a '.$fecha2.' de '.$anio.' ';
}

$tabla = $tabla.'relacionado a las colonias con contrato de mandato para su revisión, registro y trámite correspondiente. Así como también para que identifique de la cuenta de ahorro previo y se traspase a la cuenta del mandante. <br>Es importante que una vez realizados los pagos, se informe al Dpto. de Crédito enviando reporte y oficio de transferencia correspondiente.</td></tr></table><br><br><br><br><br><br>';

$pdf->AddFont('helveticaneueltstd-lt', '', '' . "'helveticaneueltstd-lt'.php");
$pdf->SetFont('helveticaneueltstd-lt', '', 12,'',true);
$pdf->writeHTML($tabla, true, false, true, false, '');
$espacios = "";

$espacios = $espacios."<br><br><br><br><br><br><br><br><br><br><br><br><br><br>";
$pdf->writeHTML($espacios, true, false, true, false, '');

/*$tabla6="";
//$tabla6=$tabla6.'<span align="justify">';
if($resta == 0){
  $tabla6 = $tabla6.' '.$fecha.' de '.$anio.'&nbsp; ';
}else if($resta == 1){
  $tabla6 = $tabla6.' '.$fecha.' y '.$fecha2.' de '.$anio.'&nbsp; ';
}else{
  $tabla6 = $tabla6.' '.$fecha.' a '.$fecha2.' de '.$anio.'&nbsp; ';
}
//$tabla6 = $tabla6."</span>";
$pdf->AddFont('helveticaneueltstd-bd', '', '' . "'helveticaneueltstd-bd'.php");
if($resta==0){

  $pdf->SetFont('helveticaneueltstd-bd', '', 11,'',true);
  $pdf->writeHTML($tabla6, false, false, true, false, '');
}else{

  $pdf->SetFont('helveticaneueltstd-bd', '', 11,'',true);
  $pdf->writeHTML($tabla6, false, false, true, false, '');
}

$tabla7 = "";
//  ESTAS CONDICIONES SON POR QUE NO SE PUEDE JUSTIFICAR CUANDO ES SOLO UN MES, ASI QUE SOLO AGREGO EL TEXTO
if($resta==0){
 // $tabla7 = $tabla7.'<span align="justify">';
  $tabla7 = $tabla7.'relacionado a las colonias con contrato de mandato para su revisión, registro y trámite correspondiente. Así como también para que identifique de la cuenta de ahorro previo y se traspase a la cuenta del mandante. <br>Es importante que una vez realizados los pagos, se informe al Dpto. de Crédito enviando reporte de transferencia correspondiente.</p>';
 // $tabla7 = $tabla7."</span>";
  
}else{
  //SI ES POR periodo AGREGO EL TEXTO EN UNA TABLA Y SE JUSTIFICA SIN PROBLEMA
  //$tabla7 = $tabla7.'<table><td style="text-align: justify;">';
  $tabla7 = $tabla7.'relacionado a las colonias con contrato de mandato para su revisión, registro y trámite correspondiente. Así como también para que identifique de la cuenta de ahorro previo y se traspase a la cuenta del mandante. <br>Es importante que una vez realizados los pagos, se informe al Dpto. de Crédito enviando reporte de transferencia correspondiente.</p>';
 // $tabla7 = $tabla7."</td></table>";
}
$pdf->AddFont('helveticaneueltstd-lt', '', '' . "'helveticaneueltstd-lt'.php");
  $pdf->SetFont('helveticaneueltstd-lt', '', 11,'',true);
 $pdf->writeHTML($tabla7, false, false, true, false, '');
*/
$tabla2="";
$tabla2 = $tabla2."<br><br>";
$sql = 'SELECT * FROM mandantes_abonos WHERE periodopago BETWEEN "'.$fechainicio.'" AND "'.$fechafin.'" and cancelado = 0';

$r = $conexion -> query($sql); 
$r_count = $r -> num_rows;
$tabla2 = $tabla2.'<div style="margin-bottom:0px;"><span><table align="center" cellpadding="5px" border = "1" style="font-size:11px; margin-bottom: 0;">';
$tabla2 = $tabla2.'<tr bgcolor="#C0BDBD">';
$tabla2 = $tabla2.'<td width = "70px;" style="font-size:9px;"><b>Delegación</b></td>';
$tabla2 = $tabla2.'<td style="font-size:9px;"><b>Colonia</b></td>';
$tabla2 = $tabla2.'<td width = "80px;" style="font-size:9px;"><b>Mandante</b></td>';
$tabla2 = $tabla2.'<td style="font-size:9px;"><b>Enganche de ahorro por identificar y traspasar</b></td>';
$tabla2 = $tabla2.'<td width = "70px;" style="font-size:9px;"><b>Recuperación</b></td>';
$tabla2 = $tabla2.'<td width = "60px;" style="font-size:9px;"><b>Gts. de Admón.</b></td>';
$tabla2 = $tabla2.'<td width = "55px;" style="font-size:9px;"><b>Amort. Anticipo</b></td>';
$tabla2 = $tabla2.'<td width = "70px;" style="font-size:9px;"><b>Devoluciones</b></td>';
$tabla2 = $tabla2.'<td width = "80px;" style="font-size:9px;"><b>Importe Neto</b></td>';
$tabla2 = $tabla2.'<td width = "75px;" style="font-size:9px;"><b>Observaciones</b></td>';
$tabla2 = $tabla2."</tr>";
$tabla2 = $tabla2."</table></span></div>";

$pdf->SetY(100);
$pdf->AddFont('helveticaneueltstd-bd', '', '' . "'helveticaneueltstd-bd'.php");
$pdf->SetFont('helveticaneueltstd-bd', '', 10,'',true);
$pdf->writeHTML($tabla2, true, false, true, false, '');
//$pdf->writeHTMLCell(0, '', 12, 90, $tabla2,0,0,0, true, 'C', true);

$tabla5="";
$pdf->SetY(127);
$tabla5 = $tabla5.'<div><span><table align="center" cellpadding="5px" style="font-size:12px;">';

//if($r_count > 6){
  //$vuelta = 0;
  //$flag=0;
  while($f = $r -> fetch_array()){
   // $vuelta ++;
    //if($vuelta <= 6){
      $tabla5 = $tabla5.'<tr border="1" >';
      $tabla5 = $tabla5.'<td  border="1" width = "70px;" style="font-size:9px;" >'.strtoupper(nombreMunicipio($f['idmunicipio'])).'</td>';
      $tabla5 = $tabla5.'<td border="1" style="font-size:9px;">'.nombreColonia($f['idmunicipio'], $f['idcolonia']).'</td>';
      $tabla5 = $tabla5.'<td border="1" width = "80px;" style="font-size:9px;">'.nombreMandante($f['idmunicipio'], $f['idcolonia'], $f['idmandante']).'</td>';
      $tabla5 = $tabla5.'<td border="1" style="font-size:9px;">$'.number_format($f['enganche_ahorro'], 2, '.', ',').'</td>';
      $tabla5 = $tabla5.'<td border="1" width = "70px;" style="font-size:9px;">$'.number_format($f['recuperacion'], 2, '.', ',').'</td>';
      $tabla5 = $tabla5.'<td border="1" width = "60px;" style="font-size:9px;">$'.number_format($f['gastos'], 2, '.', ',').'</td>';
      $tabla5 = $tabla5.'<td border="1" width = "55px;" style="font-size:9px;">$'.number_format($f['amortizacion_anticipo'], 2, '.', ',').'</td>';
      $tabla5 = $tabla5.'<td border="1" width = "70px;" style="font-size:9px;">$'.number_format($f['devols'], 2, '.', ',').'</td>';
      $tabla5 = $tabla5.'<td border="1" width = "80px;" style="font-size:9px;">$'.number_format($f['monto_pagado'], 2, '.', ',').'</td>';
      $tabla5 = $tabla5.'<td border="1" width = "75px;" style="font-size:9px;">'.$f['observacionPago'].'</td>';
      $tabla5 = $tabla5."</tr>";

   //   $tabla5 = $tabla5."<br><br><br>";

   // }else{
      
      //$pdf->AddPage();
      //$pdf->setPage($pdf->getPage());  
    /*  if($flag==0){
        $tabla5 = $tabla5.'<tr border="0px">';
          $tabla5 = $tabla5.'<td style="border-right: none; border-left: none;"  height="100px;" colspan="10"></td>';
        $tabla5 = $tabla5."</tr>";
        $flag=1;
      }

      $tabla5 = $tabla5.'<tr border="1" >';
      $tabla5 = $tabla5.'<td border="1"  width = "60px;" style="font-size:9px;" >'.nombreMunicipio($f['idmunicipio']).'</td>';
      $tabla5 = $tabla5.'<td border="1"  >'.nombreColonia($f['idmunicipio'], $f['idcolonia']).'</td>';
      $tabla5 = $tabla5.'<td border="1"  width = "80px;" style="font-size:8px;">'.nombreMandante($f['idmunicipio'], $f['idcolonia'], $f['idmandante']).'</td>';
      $tabla5 = $tabla5.'<td border="1" >$'.number_format($f['enganche_ahorro'], 2, '.', ',').'</td>';
      $tabla5 = $tabla5.'<td border="1" width = "80px;">$'.number_format($f['recuperacion'], 2, '.', ',').'</td>';
      $tabla5 = $tabla5.'<td border="1"  width = "60px;">$'.number_format($f['gastos'], 2, '.', ',').'</td>';
      $tabla5 = $tabla5.'<td border="1"  width = "55px;">$'.number_format($f['amortizacion_anticipo'], 2, '.', ',').'</td>';
      $tabla5 = $tabla5.'<td border="1" >$'.number_format($f['devols'], 2, '.', ',').'</td>';
      $tabla5 = $tabla5.'<td border="1" width = "80px;" >$'.number_format($f['monto_pagado'], 2, '.', ',').'</td>';
      $tabla5 = $tabla5.'<td border="1" width = "70px;" style="font-size:8px;">'.$f['observacionPago'].'</td>';
      $tabla5 = $tabla5."</tr>";
      
    }*/
  }
  $tabla5 = $tabla5."</table></span>";
  $tabla5 = $tabla5 ."<table><tr><td><br><br><br></td></tr></table></div>";
  $pdf->AddFont('helveticaneueltstd-lt', '', '' . "'helveticaneueltstd-lt'.php");
  $pdf->SetFont('helveticaneueltstd-lt', '', 10,'',true);
  $pdf->writeHTML($tabla5, true, false, true, false, 'C');
  // set font

 
  //$pdf->writeHTMLCell(0, '', 12, 120, $tabla5,0,0,0, true, 'C', true);


/*}else{
  
  while($f = $r -> fetch_array()){
    $tabla5 = $tabla5.'<tr border="1">';
    $tabla5 = $tabla5.'<td border="1" width = "60px;" >'.nombreMunicipio($f['idmunicipio']).'</td>';
    $tabla5 = $tabla5.'<td border="1">'.nombreColonia($f['idmunicipio'], $f['idcolonia']).'</td>';
    $tabla5 = $tabla5.'<td border="1" width = "80px;" style="font-size:8px;">'.nombreMandante($f['idmunicipio'], $f['idcolonia'], $f['idmandante']).'</td>';
    $tabla5 = $tabla5.'<td border="1">$'.number_format($f['enganche_ahorro'], 2, '.', ',').'</td>';
    $tabla5 = $tabla5.'<td border="1" width = "80px;">$'.number_format($f['recuperacion'], 2, '.', ',').'</td>';
    $tabla5 = $tabla5.'<td border="1" width = "60px;">$'.number_format($f['gastos'], 2, '.', ',').'</td>';
    $tabla5 = $tabla5.'<td border="1" width = "55px;">$'.number_format($f['amortizacion_anticipo'], 2, '.', ',').'</td>';
    $tabla5 = $tabla5.'<td border="1">$'.number_format($f['devols'], 2, '.', ',').'</td>';
    $tabla5 = $tabla5.'<td border="1" width = "80px;">$'.number_format($f['monto_pagado'], 2, '.', ',').'</td>';
    $tabla5 = $tabla5.'<td border="1" width = "70px;" style="font-size:8px;">'.$f['observacionPago'].'</td>';
    $tabla5 = $tabla5."</tr>";
  }
 
  $tabla5 = $tabla5."</table></span>";
  $tabla5 = $tabla5 ."<table><tr><td><br><br><br></td></tr></table></div>";
  $pdf->AddFont('helveticaneueltstd-lt', '', '' . "'helveticaneueltstd-lt'.php");
  $pdf->SetFont('helveticaneueltstd-lt', '', 10,'',true);
  $pdf->writeHTML($tabla5, true, false, true, false, 'C');
}*/




$pdf->writeHTML('<br><br><br>', true, false, true, false, '');
$pdf->writeHTML('<br><br><br>', true, false, true, false, '');


$tabla4 = "";
$tabla4 = $tabla4.'<table align="center">';
$tabla4 = $tabla4."<tr><td><p>Atentamente</p></td></tr>";
$tabla4 = $tabla4.'<tr><td></td></tr>';
$tabla4 = $tabla4.'<tr><td></td></tr></table>';
// set font
$pdf->AddFont('helveticaneueltstd-lt', '', '' . "'helveticaneueltstd-lt'.php");
$pdf->SetFont('helveticaneueltstd-lt', '', 11,'',true);
$pdf->writeHTMLCell(0, '', 10, 185, $tabla4,0,0,0, true, 'C', true);

$firma1 = "";
$firma1 = $firma1."<table><tr><td><p><B>LIC. HUMBERTO ALEJANDRO APARICIO GALLEGOS</B></p></td></tr>";

// set font
$pdf->AddFont('novecentowide-bold', '', '' . "'novecentowide-bold'.php");
$pdf->SetFont('novecentowide-bold', '', 11,'',true);
// add a page
//$pdf->writeHTML($firma1, true, false, true, false, '');
$pdf->writeHTMLCell(0, '', 10, 215, $firma1,0,0,0, true, 'C', true);


$firma="";
$firma = $firma."<table><tr><td><p>Director de Administración y Finanzas</p></td></tr>";
$firma = $firma."<tr><td></td></tr>";
$firma = $firma."<tr><td></td></tr>";
$firma = $firma.'<tr><td align="left" style="font-size:7px;">c.c.p.-Lic. Manuel Aguiñaga Alejo.-Jefe del Departamento de Recursos Financieros y Gestiones.</td></tr>';
$firma = $firma.'<tr><td align="left" style="font-size:7px;">c.c.p.-Lic. Perla Denisse González Robles.-Encargada del Departamento de Crédito del ITAVU.</td></tr>';
$firma = $firma.'<tr><td align="left" style="font-size:7px;">c.c.p.-Archivo.-</td></tr>';
$firma = $firma.'<tr><td align="left" style="font-size:7px;">c.c.p.-LIC.HAAG/LIC.PGR/mtbv.-</td></tr>';
$firma = $firma.'</table>';
$pdf->AddFont('helveticaneueltstd-lt', '', '' . "'helveticaneueltstd-lt'.php");
$pdf->SetFont('helveticaneueltstd-lt', '', 11,'',true);
//$pdf->writeHTML($firma, true, false, true, false, '');

// print a block of text using Write()
//$pdf->Write(0, $html, '', 0, 'C', true, 0, false, false, 0);

$pdf->writeHTMLCell(0, '', 10, 220, $firma,0,0,0, true, 'C', true);


ob_end_clean();
$todo = $tabla3.$tabla.$tabla2.$tabla5.$tabla4.$firma1.$firma;
//Close and output PDF document
$pdf->Output('example_003.pdf', 'I');



?>
