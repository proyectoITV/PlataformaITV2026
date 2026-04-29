<?php
require("../config.php");


//FUNCIONES:

function reporte_sql($id){
require("../config.php");
$sql = "SELECT * FROM reportes WHERE id_rep='".$id."'";
//echo $sql;
$rc= $conexion -> query($sql);
if($f = $rc -> fetch_array())
	{ return $f['sql'];} else {return "";}
}

function reporte_titulo($id){
require("../config.php");
$sql = "SELECT * FROM reportes WHERE id_rep='".$id."'";
$rc= $conexion -> query($sql);
if($f = $rc -> fetch_array())
	{ return "".$f['nombre']." [".$f['id_rep']."]";} else {return "";}
}

function reporte_descripcion($id){
require("../config.php");
$sql = "SELECT * FROM reportes WHERE id_rep='".$id."'";
$rc= $conexion -> query($sql);
if($f = $rc -> fetch_array())
	{ return $f['descripcion'];} else {return "";}
}



function reporte_tabla($id){
require("../config.php");
$sql = reporte_sql($id);
$cuantas_columnas=0;
$tabla_titulos = "";
$r2 = $conexion -> query($sql); while($finfo = $r2->fetch_field())
{//OBTENER LAS COLUMNAS

        /* obtener posición del puntero de campo */
        $currentfield = $r2->current_field;       
       	$tabla_titulos=$tabla_titulos."<th>".$finfo->name."</th>";
       	$cuantas_columnas = $cuantas_columnas + 1;        
}

$tabla_contenido=""; $cuantas_filas=0;
$r = $conexion -> query($sql); while($f = $r-> fetch_row())
{//LISTAR COLUMNAS

    $tabla_contenido = $tabla_contenido."<tr>";        
    for ($i = 1; $i <= $cuantas_columnas; $i++) {      
        $tabla_contenido = $tabla_contenido."<td>".$f[$i-1]."</td>";       
        }

    $tabla_contenido = $tabla_contenido."</tr>";
    $cuantas_filas = $cuantas_filas + 1;        
}


$t = "<h3>".reporte_titulo($id)."</h3>";
$t = $t."<label class='reporte_descripcion'
>".reporte_descripcion($id)."</label>";

$t = $t."<table class='tabla'>".$tabla_titulos.$tabla_contenido."</table>";
return $t;

}





function reporte_tabla2($id){
require("../config.php");
$sql = reporte_sql($id);
$cuantas_columnas=0;
$tabla_titulos = "<tr>";
$r2 = $conexion -> query($sql); while($finfo = $r2->fetch_field())
{//OBTENER LAS COLUMNAS

        /* obtener posición del puntero de campo */
        $currentfield = $r2->current_field;       
       	$tabla_titulos=$tabla_titulos.'<td style="background-color:black; color:white;">'.$finfo->name."</td>";
       	$cuantas_columnas = $cuantas_columnas + 1;        
}
$tabla_titulos = $tabla_titulos."</tr>";
$tabla_contenido=""; $cuantas_filas=0;
$r = $conexion -> query($sql); while($f = $r-> fetch_row())
{//LISTAR COLUMNAS

    $tabla_contenido = $tabla_contenido."<tr>";        
    for ($i = 1; $i <= $cuantas_columnas; $i++) {      
        $tabla_contenido = $tabla_contenido."<td>".$f[$i-1]."</td>";       
        }

    $tabla_contenido = $tabla_contenido."</tr>";
    $cuantas_filas = $cuantas_filas + 1;        
}


$t = '<h5 style="text-align:center">'.reporte_titulo($id)."</div>";
$t = $t.'<div style="font-size: xx-small;">'.reporte_descripcion($id)."</div>";

$t = $t.'<table border="1" style="font-size: xx-small;">'.$tabla_titulos.$tabla_contenido."</table>";
return $t;

}








//============================================================+
// File name   : example_006.php
// Begin       : 2008-03-04
// Last Update : 2013-05-14
//
// Description : Example 006 for TCPDF class
//               WriteHTML and RTL support
//
// Author: Nicola Asuni
//
// (c) Copyright:
//               Nicola Asuni
//               Tecnick.com LTD
//               www.tecnick.com
//               info@tecnick.com
//============================================================+

/**
 * Creates an example PDF TEST document using TCPDF
 * @package com.tecnick.tcpdf
 * @abstract TCPDF - Example: WriteHTML and RTL support
 * @author Nicola Asuni
 * @since 2008-03-04
 */

// Include the main TCPDF library (search for installation path).
require_once('tcpdf_include.php');

// create new PDF document
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Nicola Asuni');
$pdf->SetTitle('TCPDF Example 006');
$pdf->SetSubject('TCPDF Tutorial');
$pdf->SetKeywords('TCPDF, PDF, example, test, guide');

// set default header data
$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE.' 006', PDF_HEADER_STRING);

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























































//$html = reporte_tabla2('1');
//$html="Hola mundo";

$html=$_POST['html'];

//echo $html;
$pdf->writeHTML($html, true, false, true, false, '');




// reset pointer to the last page
$pdf->lastPage();


//Close and output PDF document

$pdf->Output('pdf/example_006.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+
