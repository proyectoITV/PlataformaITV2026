<?php
    require_once('tcpdf/examples/tcpdf_include.php');
    include "lib/variables.php";

    $var_referencia = $_GET['referencia'];
    $var_numcontrato = $_GET['numcontrato'];
    $var_nummov = $_GET['nummov'];

    $ch = curl_init();
    $peticion="http://".$nomservidor."/".$nomwebservice."?method=GET&token=".$token."&sql=select%20*%20from%20Vivienda_Ws_PagosOXXO%20where%20numcontrato=%27".$var_numcontrato."%27%20and%20nummov%20=%20".$var_nummov."";
    $array_options = array(CURLOPT_URL=>$peticion, CURLOPT_RETURNTRANSFER=>true,   );
    curl_setopt_array($ch,$array_options);
    $resp = curl_exec($ch);
    $final_decoded_data = json_decode($resp,true);
    $beneficiario = '';

    if(is_array($final_decoded_data)){
        foreach ($final_decoded_data as $value) {
            if (empty($value['NumMov'])==0){
                $var_comprobante_Tienda = $value['Tienda'];
                $var_comprobante_numcontrato = $value['NumContrato'];
                $var_comprobante_nummov = $value['NumMov'];
                $var_comprobante_beneficiario = $value['Beneficiario'];
                $var_comprobante_fechaoperacion = $value['FechaOperacion'];

                $var_comprobante_controlinterno = $value['ControlInterno'];
                $var_comprobante_importe = $value['Importe'];
            }
            else {
                echo "<H3> <font color='#ca1c1c'>Sin coincidencias, con los datos proporcionados. Vuelva a intentar</font></H3>";
                echo "<br>";
            }
        }
        
    }
    else {
        echo "<script>location.href ='error_token.html';</script>";
    }
    curl_close($ch);    

    // create new PDF document
    $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

    // set document information
    $pdf->SetCreator(PDF_CREATOR);
    $pdf->SetAuthor('');
    $pdf->SetTitle('');
    $pdf->SetSubject('');
    $pdf->SetKeywords('');

    // set default header data
    $pdf->SetHeaderData(PDF_HEADER_LOGO, 40, PDF_HEADER_TITLE, PDF_HEADER_STRING, array(0,0,0), array(0,0,0));
    $pdf->setFooterData(array(0,0,0), array(0,0,0));

    // set header and footer fonts
    $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
    $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

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
if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
    require_once(dirname(__FILE__).'/lang/eng.php');
    $pdf->setLanguageArray($l);
}

// ---------------------------------------------------------

// set font
$pdf->SetFont('dejavusans', '', 10);

// add a page
$pdf->AddPage();

// create some HTML content
$html = '
    <div>
        <table style="text-align:center;">
        <tr><td><img src="lib/itavu.jpg" width="80px" height="80px" /></td></tr>    
        </table>
        <br>
        <H3>COMPROBANTE DE PAGO</H3>
        <table border="1" style="height: 300px; width: 100%; border-collapse: collapse; border-color: #E0E0E0;">
            <tbody>
                <tr>
                    <td style="width: 35%; height: 18px;"> Lugar de operación <br> </td>
                    <td style="width: 65%; height: 18px;"> '.$var_comprobante_Tienda.' <br> </td>
                </tr>
                <tr>
                    <td style="width: 35%; height: 18px;"> Número de contrato <br> </td>
                    <td style="width: 65%; height: 18px;"> '.$var_comprobante_numcontrato.' <br> </td>
                </tr>
                <tr>
                    <td style="width: 35%; height: 18px;"> Número de movimiento <br> </td>
                    <td style="width: 65%; height: 18px;"> '.$var_comprobante_nummov.' </td>
                </tr>
                <tr>
                    <td style="width: 35%; height: 18px;"> Nombre <br> </td>
                    <td style="width: 65%; height: 18px;"> '.$var_comprobante_beneficiario.' <br> </td>
                </tr>
                <tr>
                    <td style="width: 35%; height: 18px;"> Fecha de pago <br> </td>
                    <td style="width: 65%; height: 18px;"> '.$var_comprobante_fechaoperacion.' <br></td>
                </tr>
                <tr>
                    <td style="width: 35%; height: 18px;"> Fecha de impresi&oacute;n <br> </td>
                    <td style="width: 65%; height: 18px;"> '.date("Y-m-d H:i:s").' <br> </td>
                </tr>
                <tr>
                    <td style="width: 35%; height: 18px;"> Control interno * <br> </td>
                    <td style="width: 65%; height: 18px;"> '.$var_comprobante_controlinterno.' </td>
                </tr>
                <tr>
                    <td style="width: 35%; height: 18px;"> Concepto <br> </td>
                    <td style="width: 65%; height: 18px;"> PAGO <br> </td>
                </tr>
                <tr>
                    <td style="width: 35%; height: 18px;"> Total pagado <br> </td>
                    <td style="width: 65%; height: 18px;"> $'.number_format($var_comprobante_importe, 2, '.', '').' MN <br> </td>
                </tr>
            </tbody>
        </table>
        <p>Su pago se encuentra debidamente integrado en su cuenta.</p>
        <p>La reproducción <b>NO AUTORIZADA</b> de este COMPROBANTE DE PAGO constituye un delito.</p>
    </div>
    
';

// output the HTML content
$pdf->writeHTML($html, true, false, true, false, '');

// set style for barcode
$style = array(
    'border' => 1,
    'vpadding' => 'auto',
    'hpadding' => 'auto',
    'fgcolor' => array(0,0,0),
    'bgcolor' => false, //array(255,255,255)
    'module_width' => 1, // width of a single module in points
    'module_height' => 1 // height of a single module in points
);

// QRCODE,H : QR-CODE Best error correction
$pdf->write2DBarcode($var_comprobante_controlinterno, 'QRCODE,H', 15, 180, 50, 50, $style, 'N');
$pdf->Text(15, 233, '* C. I. : '.$var_comprobante_controlinterno);

// reset pointer to the last page
$pdf->lastPage();

//Close and output PDF document
$pdf->Output($var_comprobante_numcontrato.'_'.$var_comprobante_nummov, 'I');

include "conexionbd.php";    
$consulta = "Insert into comprobantesoxxo_peticiones (referencia, numcontrato, nummov) values ('$var_referencia', '$var_numcontrato', '$var_nummov')";
$resultado = mysqli_query($conexion, $consulta);

if ($resultado) {
}
else {
    
}
?>