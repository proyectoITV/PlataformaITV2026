<?php
    // echo "Imprimiendo: ".$_GET['print'];

    require("seguridad.php");
    require("config.php");
    require("lib/flor_funciones.php");
    require("lib/funciones.php");

    $sql = "SELECT
    IdMunicipio as IdMun,
    (select cat_municipios.Municipio from cat_municipios where IdMunicipio = IdMun) as Municipio,
    (select cat_municipios.del from cat_municipios where IdMunicipio = IdMun) as IdDel,
    (select cat_delegaciones.nombre from cat_delegaciones WHERE cat_delegaciones.id= IdDel) as Delegacion,
    nfer_concepto as IdConcepto,
    (select cat_fer.fer_descripcion from cat_fer where cat_fer.fer_IdCon = IdConcepto) as Concepto,
    ejercicio as Ejer,
    (select sustento from fer_fondos where ejercicio = Ejer) as Sustento,
    fer.*
    FROM
    fer 
    WHERE
    nfer_id = '".$_GET['print']."' 
    AND estado = 0 and ejercicio=".$_GET['ejerciciocert'];
//ejercicio=2025
    $rc= $conexion -> query($sql);
    if($f = $rc -> fetch_array())
        {
            historia($nitavu,"vio el Cerficiado FER ".$_GET['print']." en su version PDF");

            require('pdf/tcpdf.php');    
            $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
            $pdf->setPrintHeader(false);
            $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
            $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
            if (@file_exists(dirname(__FILE__).'pdf/lang/eng.php')) {require_once(dirname(__FILE__).'pdf/lang/eng.php');$pdf->setLanguageArray($l);}
            $pdf->SetFont('dejavusans', '', 7); $pdf->AddPage('P'); //en la tabla de reporte L o P
    
            //VARIABLES DE ESTILOS                   
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
            $pdf->Image('img/LogotipoOficial.jpg', '5', '5', 100, 15, '', '', 'T', false, 00, '', false, false, 0, false, false, false);    

            $pdf->SetFont('', 'R', 11, '', 'false');
            // $pdf->Text(125, 20, "Fecha: ".$f['autorizo_fecha']);
            //$pdf->Text(125, 20, "Fecha: ".$fecha);

            $pdf->Text(125, 20, "Fecha: ".$f['autorizo_fecha']);
            
            $pdf->SetFont('', 'R', 11, '', 'false');
            $pdf->Text(125, 25, "Delegación: ".$f['Delegacion']);
            
            $pdf->SetFont('', 'R', 11, '', 'false');
            $pdf->Text(125, 30, "Número de contrato: ".$f['contrato']);

            $parrafo1 = "<p align=justify style=''>
            El Gobierno del Estado de Tamaulipas, por conducto del <b> Instituto Tamaulipeco de Vivienda y Urbanismo</b>, a través de la
            Delegación de este municipio y dentro del programa de apoyo a las personas que en virtud de que les es imposible finiquitar el adeudo
            por cuestiones diversas, las cuales van desde desempleo hasta gastos no contemplados en dichas familias, como enfermedad o muerte de algún 
            familiar, para ello se ha creado un <b>Fondo Económico de Reserva</b>.
            </p>";
            $pdf->SetFont('', 'R', 10, '', 'false');
            $pdf->writeHTMLCell(175, 10, 20, 70, $parrafo1, 0, 0, 0, '', 'J', '');

            $parrafo2 = "<p align=justify style=''>            
            Otorga el presente subsidio con número: ".$f['numcertificado']." </p>";

            //Otorga el presente subsidio con número: ".$f['nfer_id']." </p>";
            
            $pdf->SetFont('', 'R', 10, '', 'false');
            $pdf->writeHTMLCell(175, 20, 20, 100, $parrafo2, 0, 0, 0, true, 'C', '');

            $parrafo2 = "<p align=justify style=''>   
            ".$f['Concepto'].", que asciende a la cantidad de <b> $".number_format($f['cantidad'],2,'.',',')."</b> (".numtoletras($f['cantidad']).")";
            // ".\n    

            $pdf->SetFont('', 'R', 10, '', 'false');
            $pdf->writeHTMLCell(175, 20, 20, 110, $parrafo2, 0, 0, 0, true, 'C', '');

            // $parrafo3 = "<p>".numtoletras($f['cantidad'])."</p>";     
            // $pdf->SetFont('', 'R', 10, '', 'false');
            // $pdf->writeHTMLCell(175, 00, 20, 140, $parrafo3, 0, 0, 0, '', 'C', '');
            
            $parrafo5 = "<p>C. ".$f['nombre']."</p>";     
            $pdf->SetFont('', 'B', 14, '', 'false');
            $pdf->writeHTMLCell(175, 10, 20, 129, $parrafo5, 0, 0, 0, true, 'C', '');

            $pdf->SetFont('', 'R', 10, '', 'false');
            $parrafo4 = "<p>".$f['Sustento']."</p>";     
            $pdf->writeHTMLCell(175, 50, 20, 150, $parrafo4, 0, 0, 0, true, 'J', '');

            $pdf->SetFont('', 'R', 10, '', 'false');
            $parrafo5 = "<p>".$f['parrafo_opcional']."</p>";     
            $pdf->writeHTMLCell(175, 50, 20, 164, $parrafo5, 0, 0, 0, true, 'J', '');

            $pdf->Text(65, 222, "_________________________________________________");
            $pdf->SetFont('', 'B', 11, '', 'false');
            $pdf->Text(67, 228, 'Arq. '.nitavu_nombre(CATgerarquia_director()));

            $pdf->SetFont('', 'R', 10, '', 'false');
            $pdf->Text(95, 234, "Director General");

            $pdf->SetFont('', 'B', 16, '', 'false');
            $pdf->Text(50, 50, "CERTIFICADO DE SUBSIDIO ESTATAL");

            //$url = $urlsite.'/fer_valida.php?id='.$_GET['print'];
            $url = 'http://192.168.159.5/fer_valida.php?id='.$_GET['print'];
            $pdf->write2DBarcode($url, 'QRCODE,M', 170, 238, 50, 50, $styleqr, 'N'); 
            $pdf->SetFont('', 'R', 6, '', 'false');
            $pdf->Text(170, 268.5, 'CODIGO DE CERTIFICADO');

            ob_end_clean();
            $pdf->lastPage();
            $pdf->Output('reporte.pdf', 'I');
        }
    else 
        {
            mensaje ("ERROR: certificado no valido".$sql,'fer.php');
        }
?>