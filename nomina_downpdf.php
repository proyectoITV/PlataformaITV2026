<?php
require("seguridad.php");
// require_once("config.php");
// require_once("lib/funciones.php");
require("components.php");



// error_reporting(0); //<-- para simular produccion
$IdEmpleado = "";
if ($_GET['id']){
    $IdEmpleado = VarClean($_GET['id']);
}

$FechaNomina = "";
if ($_GET['f']){
    $FechaNomina = VarClean($_GET['f']);
}


$FechaNominaString = str_replace("-", "", $FechaNomina);
$Empleado = str_replace(" ", "", nitavu_nombre($IdEmpleado)); 
$nuevo_nombre = $FechaNominaString.'_MiNomina_'.$Empleado.'.pdf'; //asignamos nuevo nombre
    $sql = "SELECT * FROM nominas  WHERE nitavu='".$IdEmpleado."' and FechaNomina='".$FechaNomina."'";	
    // echo $sql;


    $host = "192.168.159.5/";
    $msg = "";
    $r= $conexion -> query($sql);if($f = $r -> fetch_array()){	
        // $archivo_xml = $host.$f['File'];        
        $archivo_xml = $f['File'];
        // echo $archivo_xml;      
        // $xml = simplexml_load_file($archivo_xml); 
        // $ns = $xml->getNamespaces(true);
        $xmlCont = file_get_contents($archivo_xml);

        // var_dump($xmlCont);
        //Crear los campos:
        // XML_Percepciones($xmlCont);

        
        
        //Nomina PDF=
        require_once('pdf/tcpdf.php');   
        ob_end_clean();
        class PDFEDOCUENTA extends TCPDF {
            public $str;
            public $Delegacion;
            public $RegFiscal;
            public $FechaContrato;
            public $Beneficiario;
    
            public function Header() {
                // Logo
                $image_file = K_PATH_IMAGES.'pdf_logo.jpg';
                $icono = K_PATH_IMAGES.'user.png';
                
                $this->Image($image_file, 15, 5, 60, '', 'JPG', '', 'T', false, 300, '', false, false, 0, false, false, false);
    
                // $this->Image($icono, 15, 19, 5, '', 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);
                // Set font
                $this->SetFont('helvetica', 'B', 10);
                // Title
             //    $this->Cell(0, 10, 'INSTITUTO TAMAULIPECO DE VIVIENDA Y URBANISMO', 0, false, 'C', 0, '', 0, false, 'M', 'M');
             // $this->Text(100,5, 'INSTITUTO TAMAULIPECO DE VIVIENDA Y URBANISMO'); 
             $this->Text(90,5, 'INSTITUTO TAMAULIPECO DE VIVIENDA Y URBANISMO'); 
             $this->SetFont('helvetica', 'r', 8);
             $this->Text(120,9, 'RFC: ITV820513L21'); 
    
             $this->SetFont('courier', 'R', 7); $this->Text(85,12, ''); $this->SetFont('courier', 'R', 7); $this->Text(90,12, 'Reg. Fiscal:'.$this->RegFiscal); 
             $this->SetFont('courier', 'R', 6); $this->Text(85,15, ''); $this->SetFont('courier', 'B', 6); $this->Text(100,15, 'Lugar y fecha: '.$this->FechaContrato); 
    
             $this->SetFont('helvetica', 'B', 12);
            //  $this->SetTextColor(0,91,160);
             $this->SetTextColor(0,0,0);
             $this->Image($icono, 15, 19, 5, '', 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);
             $this->Text(20,19, '  '.$this->Beneficiario); 
            //  $this->Cell(0, 0, $this->Beneficiario, 1, 1, 'C');
            //  $this->MultiCell(0, 0,  $this->Beneficiario , 1, 'C', false, 1);
    
            }
        
            public function Footer() {
                // Position at 15 mm from bottom
                $this->SetY(-15);
                // Set font
             //    $line_width = (0.85 / $this->k);
             //    $this->Ln(1);
             $this->SetFont('helvetica', 'I', 6);
             //    $pdf->SetXY(0, 100);                   
             $this->SetTextColor(0,0,0);
                // Page number
                $linea= "______________________________________________________________________________________________________________________________________________________________";
             //    $this->Cell(0, 0, $linea, 0, false, 'L', 0, '', 0, false, 'T', 'M');
             //    $this->Cell(0, 20, $this->str.' | Pag. '.$this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, false, 'L', 0, '', 0, false, 'T', 'M');
             // $str = $this->str." |  Pag. ".$this->getAliasNumPage().'/'.$this->getAliasNbPages();
             $paginas = "Pag. ".$this->getAliasNumPage().'/'.$this->getAliasNbPages();
             // $this->SetTextColor(205,205,205);
             $this->Text(15,263, $linea); 
             // $this->SetTextColor(129,129,129);
             $this->SetFont('helvetica', 'B', 9); $this->Text(15,266, $paginas); 
             // $this->SetTextColor(165,165,165);
             $this->SetFont('helvetica', 'R', 7); 
             $this->Text(32,266, substr($this->str,0,140)); 
             $this->Text(32,269, substr($this->str,140,)); 
             // $this->Cell(0, 20, $this->str.'. Pag. '.$this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, false, 'L', 0, '', 0, false, 'T', 'M');
            }
        }
    
         $pdf = new PDFEDOCUENTA(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
         $pdf->SetCreator(PDF_CREATOR);
         $pdf->SetKeywords('Reporte ITAVU');
         //$pdf->SetHeaderData('pdf_logo.jpg', '40','');
         $pdf->SetHeaderData('', '10', '', 'ITAVU  '.'Mi Nomina');
         //$pdf->setFooterData(array(0, 64, 0), array(0, 64, 128));
         $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
         $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
         
         // $pdf->setFooterData('', '10', '', 'ITAVU  '.$string);
         $pdf->str =  "Impreso: ".fecha_larga($fecha).":".hora12($hora);
         $pdf->RegFiscal = XML_RegimenFiscal($xmlCont);
         $pdf->FechaContrato = XML_FechayLugarEmision($xmlCont);
        
        //  $pdf->FechaContrato =XML_FechaEmision($xmlCont);
         
         $pdf->Beneficiario = "(".$f['nitavu'].") ".nitavu_nombre($f['nitavu']);

         $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
         
         // set margins
         $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
         $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
         $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
         #Establecemos los márgenes izquierda, arriba y derecha:
         $pdf->SetMargins(15, 25 , 15);
    
         #Establecemos el margen inferior:
         // $pdf->SetAutoPageBreak(true,25);  
         
         // set auto page breaks
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
         
         // set image scale factor
         $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
         
         // set some language-dependent strings (optional)
         if (@file_exists(dirname(__FILE__).'pdf/lang/eng.php')) {
             require(dirname(__FILE__).'pdf/lang/eng.php');
             $pdf->setLanguageArray($l);
         }
         // set font
         $pdf->SetFont('helvetica', '', 9);
         // add a page
         $pages = $pdf->getNumPages();
         
         $pdf->AddPage('P', 'LETTER'); //en la tabla de reporte L o P
         
       
         $pag = $pdf->PageNo();
        //echo $cancelado;
        //  if($cancelado == TRUE){
        // 	 $pdf->Image('icon/cancelado.png', 18, 70,180, 100, '', '', '', false, 300, '', false, false, 0);
        //  }
        // $pdf->text
        $style = array(
            'border' => true,
            'padding' => 5,
            'fgcolor' => array(0,0,0),
            'bgcolor' => false
        );

        $UUID = XML_UUID($xmlCont);
        $RFCEmpleado = XML_RFCEmpleado($xmlCont);
        $GranTotal = XML_GranTotal($xmlCont);
        $rellono_izq= str_pad($GranTotal, 18, "0", STR_PAD_LEFT); 
        $GranTotal_vinculo = $rellono_izq."0000";
        $Sello = XML_Sello($xmlCont);
        $ultimos8Sello=  strtoupper(substr($Sello, -8));

        $styleqr = array(
            'border' => false,
            'vpadding' => 'auto',
            'hpadding' => 'auto',
            'fgcolor' => array(1,92,162),
            //'bgcolor' => false, //array(255,255,255)
            'bgcolor' => false, //array(255,255,255)
            'module_width' => 1, // width of a single module in points
            'module_height' => 1 // height of a single module in points
        );

        $QR_link = "https://verificacfdi.facturaelectronica.sat.gob.mx/default.aspx?id=".$UUID."&re="."ITV820513L21"."&rr=".$RFCEmpleado."&tt=".$GranTotal_vinculo."&fe=".$ultimos8Sello;
        $pdf->write2DBarcode($QR_link, 'QRCODE,M', 160, 20, 60, 60, $styleqr, 'N'); 
        
        $pdf->SetFont('', 'B', 9, '', 'false');
        $pdf->Text(15, 30, ''.nitavu_nivel($IdEmpleado)." - ".nitavu_puesto($IdEmpleado)." - ".nitavu_dpto_nombre($IdEmpleado)); 
        // $pdf->Text(15, 30, ''."  ".nitavu_puesto($IdEmpleado)." - ".nitavu_dpto_nombre($IdEmpleado)); 
        $pdf->SetFont('', 'R', 9, '', 'false');
        $pdf->Text(15, 35, 'RFC:'.$RFCEmpleado); 

        $CurpEmpleado = XML_CurpEmpleado($xmlCont);
        $pdf->Text(15, 40, 'CURP:'.$CurpEmpleado); 

        $InicioLaboral = XML_FechaInicioLaboral($xmlCont);
        $pdf->Text(15, 45, 'Fecha Ini. Relacion Laboral: '.$InicioLaboral); 

        $Jornada = XML_Jornada($xmlCont);
        $pdf->Text(15, 50, 'Jornada: '.$Jornada); 

        
        
        
        $html = "";
        $html.="<table>";

        $html.='<tr >';
            $html.='<td bgcolor="#E6E6E6" style="color:#333333">
                <b>Tipo de Salario</b>: Fijo<br>
                <b>Periodo: </b>'.XML_periodicidad($xmlCont).' - '.$f['FechaPagoInicial'].' - '.$f['FechaPagoFinal'].'<br>
                <b>Dpto: </b>'. XML_Departamento($xmlCont).'
                
            </td>';             

            $DiasDePago = XML_DiasDePago($xmlCont);
            $html.='<td bgcolor="#015CA2" style="color:#ffffff">
            Dias de Pago: 15<br>'.
            ' Fecha de Pago: '.XML_FechadeNomina($xmlCont).'<br>'.
            ' SBC: '.Pesos(XML_SalarioBase($xmlCont)).'<br>'
            
                
                .'</td>'; 

        $html.='</tr>';

        $html.='<tr  ><td></td><td></td></tr>';         
        
        $html.='<tr>';
        $html.='<td bgcolor="#DCECEF" style="text-align:center; color:#000000;"><br>PERCEPCIONES';

            $html.='<br><br>'.XML_Percepciones($xmlCont).'';

        $html.='</td>';
        $html.='<td bgcolor="#FFF8E1" style="text-align:center;color:#333333">DEDUCCIONES';
            $html.='<br><br>'.XML_Deducciones($xmlCont).'';
        $html.='</td>';

        $html.="</tr>";



              
        $html.='<tr>';
        $html.='<td bgcolor="" style="text-align:center; color:#000000;">';
        $html.='</td>';
        $html.='<td bgcolor="" style="text-align:center;color:#333333">';            
        $html.='</td>';
        $html.="</tr>";


               
        $html.='<tr>';
        $html.='<td bgcolor="#E0FBC6" style="text-align:center; color:#000000;">';

        $html.='<table>';
        $Subtotal=XML_Percepciones_Total($xmlCont);
        $Descuentos = XML_Deducciones_TotalOtrasDeducciones($xmlCont);
        $Retenidos = XML_ImpuestosRetenidos_Total($xmlCont);
        $GranTotalito = $Subtotal - ($Descuentos + $Retenidos);
        $html.='<tr><td style="font-size:7pt; text-align:right;">Subtotal:</td><td style="font-size:9pt; text-align:left; padding-left: 5;">  '.Pesos($Subtotal).'</td></tr>';
        $html.='<tr><td style="font-size:7pt; text-align:right;">Descuentos:</td><td style="font-size:9pt; text-align:left; padding-left: 5;">  '.Pesos($Descuentos).'</td></tr>';
        $html.='<tr><td style="font-size:7pt; text-align:right;">Retenciones:</td><td  style="font-size:9pt; text-align:left; padding-left: 5;">  '.Pesos($Retenidos).'</td></tr>';
        $html.='<tr><td bgcolor="#A1C30D" style="color:#FFFFFF; font-size:10pt; text-align:right;">Total:</td><td bgcolor="#A1C30D"  style="font-size:12pt; color:#FFFFFF; text-align:left; padding-left: 5; font-weight:bolde;">  '.Pesos($GranTotalito).'</td >  </tr>';
        $html.='<tr><td style="font-size:7pt; text-align:right;">Neto del Recibo:</td >  <td style="font-size:9pt; text-align:left; padding-left: 5;">  '.Pesos($GranTotalito).'</td></tr>';
        $html.='<tr><td style="font-size:7pt; text-align:right;"></td >  <td style="font-size:9pt; text-align:left; padding-left: 5;">  '.''.'</td></tr>';
        
        $html.='</table>';

        $html.='<br/><b>Importe con letra:</b><br><cite>'.numtoletras($GranTotalito)."</cite>";

        $html.='</td>';
        $html.='<td bgcolor="" style="text-align:center;color:#333333">
        
        
        <p>Este documento es una representacion impresa de un CFDI. <br>
        PUE - Pago en una sola exhibicion.
        </p>

        <p style="font-size:7pt;">Se puso a mi disposición el archivo XML correspondiente y recibi de la empresa arriba mencionada la cantidad neta 
        a que este documento se refiere estando conforme con las percepciones y deducciones que en él aparecen especificados.</p>
        ';
            // $html.='<br><br>'.XML_Deducciones($xmlCont).'';
        $html.='</td>';

        $html.="</tr>";


        $html.='<tr>';
        $html.='<td bgcolor="" style="text-align:left; color:#000000;">';
        $html.='<br><p style="font-size:6pt; ">
        <b>Serie del Certificado del emisor: </b>'. XML_NoCer($xmlCont).'<br>
        <b>Folio Fiscal UUID: </b>'.XML_UUID($xmlCont).'<br>
        <b>No. de serie del Cerficiado del SAT: </b>'.XML_Cer($xmlCont).'<br>
        <b>Fecha y hora de certificacion: </b>'.XML_FechaTimbrado($xmlCont).'<br>
        </p>
        ';
        $html.='</td>';
        $html.='<td bgcolor="" style="text-align:center;color:#333333">';            
        $html.='</td>';
        $html.="</tr>";


        $html.='<tr>';
        $html.='<td bgcolor="" style="text-align:center; color:#000000;">';
        $html.='</td>';
        $html.='<td bgcolor="" style="text-align:center;color:#333333">';            
        $html.='</td>';
        $html.="</tr>";

        

        $html.='</table>
        <p style="font-size:6pt;">
        <b>Sello digital CFDI: </b> '.XML_Sello($xmlCont).'<br><br>
        <b>Sello del SAT: </b> '.XML_SelloSAT($xmlCont).'<br><br>
        <b>Cadena original del complemento del certificado digital del SAT: </b>'. XML_Cadena($xmlCont).'<br>
        </p>
        ';
        $pdf->SetXY(15, 60);
        $pdf->writeHTML($html, true, false, true, false, '');// Print text using writeHTMLCell()
        
        
        //  ob_end_clean();
        $pdf->Output($nuevo_nombre, 'I');
























      
    } else {
        echo "No disponible";
    }






?>