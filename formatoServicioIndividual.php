<?php

require("config.php");
require_once('seguridad.php');
require_once('pdf/tcpdf.php');
//$nitavu="2809";
$clave_servicio = $_GET['clave_servicio'];
$IdVehiculo=$_GET['id'];
error_reporting(0);




$tTitulo='
<div style="text-align:center"><br>
<H2>CONTROL DE MANTEMIENTO PREVENTIVO Y COERRECTIVO</H2>
</div>';

$sqlV="select * from vehiculos_  where Num_economico='$IdVehiculo'";
// echo $sqlB;
$r2= $conexion -> query($sqlV);
while($f2 = $r2 -> fetch_array()) {


$tVehiculo='

<div>
<span style="font-style: italic;font-weight:bold; font-size:9pt;">DATOS DEL VEHICULO</span><br><hr><br>

<table style="padding:2px; font-size:9pt;">
    <tr>        
        <td style="width:15%; font-weight:bold;">N° Econimico</td>
        <td style="">'.$f2['NEconomico'].'</td>
    </tr>
    <tr>       
        <td style="width:15%; font-weight:bold;">Marca</td>
        <td>'.$f2['Marca'].'</td>     
    </tr>
    <tr>        
        <td style="width:15%; font-weight:bold;">Tipo</td>
        <td style="">'.$f2['Tipo'].'</td>
    </tr>
    <tr>       
        <td style=" width:15%; font-weight:bold;">Color</td>
        <td>'.$f2['Color'].'</td>     
    </tr>    
    <tr>       
        <td style="width:15%; font-weight:bold;">Modelo</td>
        <td>'.$f2['Modelo'].'</td>     
    </tr>
    <tr>       
        <td style="width:15%; font-weight:bold;">Placas</td>
        <td>'.$f2['Placas'].'</td>     
    </tr>
    <tr>       
        <td style="width:15%; font-weight:bold;">Serie</td>
        <td>'.$f2['Serie'].'</td>     
    </tr>
    <tr>       
        <td style="width:15%; font-weight:bold;">Adscripción</td>
        <td>'.$f2['Adscripcion'].'</td>     
    </tr>
</table></div><br><br>';
}

$sqlB="
select 
vb.*,
IFNULL((select cat_tiposdemantenimiento.Tipo_Mantenimiento from cat_tiposdemantenimiento where clave_tipo_mant = vb.clave_tipo_mant),'Correctivo') as TipoServicio,
ifnull((select cat_proveedoresvehiculos.Nombre_proveedor from cat_proveedoresvehiculos where clave_proveedor = vb.clave_proveedor),'') as Proveedor
from vehiculos_bitacora vb where Clave_servicio=".$clave_servicio;

//echo $sqlB;
$r2= $conexion -> query($sqlB);
$r_count = $r2 -> num_rows;
if($r_count > 0){
while($f2 = $r2 -> fetch_array()) {
$tServicio='
<div>
<span style="font-style: italic;font-weight:bold; font-size:9pt;">DATOS DEL SERVICIO</span><br><hr><br>
<table style="padding:3px; font-size:9pt; width:140%; ">
    <tr>        
        <td style="width:20%; font-weight:bold;">Fecha de Solicitud</td>
        <td style="">'.date_format( date_create($f2['Fecha_solicitud']), 'd-m-Y').'</td>
    </tr>
    <tr>       
        <td style="width:20%; font-weight:bold;">Fecha de Ejecución</td>
        <td>'.date_format( date_create($f2['Fecha_ejecucion']), 'd-m-Y').'</td>     
    </tr>
    <tr>        
        <td style="width:20%; font-weight:bold;">Tipo de Mantenimiento</td>
        <td style="">'.$f2['TipoServicio'].'</td>
    </tr>
    <tr>       
        <td style=" width:20%; font-weight:bold;">Km Programado</td>
        <td>'.$f2['Km_prog'].'</td>     
    </tr>    
    <tr>       
        <td style="width:20%; font-weight:bold;">Km Real</td>
        <td>'.$f2['Km_real'].'</td>     
    </tr>
    <tr>       
        <td style="width:20%; font-weight:bold;">N° de Solicitud</td>
        <td>'.$f2['num_solicitud'].'</td>     
    </tr>
    <tr>       
        <td style="width:20%; font-weight:bold;">Proveedor</td>
        <td>'.$f2['Proveedor'].'</td>     
    </tr>
    <tr>       
    <td style="width:20%; font-weight:bold;">Descripcion</td>
    <td>'.$f2['Descripcion'].'</td>     
    </tr>
    <tr>       
        <td style="width:20%; font-weight:bold;">Costo Mano de Obra</td>
        <td>$ '.$f2['Costo_mano_obra'].'</td>     
    </tr>
    <tr>       
    <td style="width:20%; font-weight:bold;">Costo Mano de Refacción</td>
    <td>$ '.$f2['Costo_refaccion'].'</td>     
    </tr>
    <tr>       
    

</table></div>';
}
}else
{
    $tServicio='
<div>
<span style="font-style: italic;font-weight:bold; font-size:9pt;">DATOS DEL SERVICIO</span><br><hr><br>
<table style="padding:3px; font-size:9pt; width:140%; ">
    <tr>        
        <td style="width:20%; font-weight:bold;">Fecha de Solicitud</td>
        <td style=""></td>
    </tr>
    <tr>       
        <td style="width:20%; font-weight:bold;">Fecha de Ejecución</td>
        <td></td>     
    </tr>
    <tr>        
        <td style="width:20%; font-weight:bold;">Tipo de Mantenimiento</td>
        <td style=""></td>
    </tr>
    <tr>       
        <td style=" width:20%; font-weight:bold;">Km Programado</td>
        <td></td>     
    </tr>    
    <tr>       
        <td style="width:20%; font-weight:bold;">Km Real</td>
        <td></td>     
    </tr>
    <tr>       
        <td style="width:20%; font-weight:bold;">N° de Solicitud</td>
        <td></td>     
    </tr>
    <tr>       
        <td style="width:20%; font-weight:bold;">Proveedor</td>
        <td></td>     
    </tr>
    <tr>       
    <td style="width:20%; font-weight:bold;">Descripcion</td>
    <td></td>     
    </tr>
    <tr>       
        <td style="width:20%; font-weight:bold;">Costo Mano de Obra</td>
        <td></td>     
    </tr>
    <tr>       
    <td style="width:20%; font-weight:bold;">Costo Mano de Refacción</td>
    <td></td>     
    </tr>
    <tr>       
    

</table></div>';
}






$tabla=$tTitulo.$tVehiculo.$tServicio;


//echo $tabla;
$orientacion='P';
 $autor="Instituto Tamualipeco de Vivienda y Urbanismo";
 $titulo="Direccion de Administracion y Finanzas";

 $descripcion="Departamento de Recursos Materiales Y Servicios Generales";




// create new PDF document
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
  ob_end_clean();   
// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor($autor);
$pdf->SetTitle(strtoupper($titulo));
$pdf->SetSubject($descripcion);
$pdf->SetKeywords('SERVICIO');



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

//echo $html; //aqui escribe el contenido de la consulta


$pdf->writeHTML($html, true, false, true, false, '');

$pdf->SetXY(25,235);
$pdf->Cell(60,10,"__________________________________________",0 ,0,'C',0);
$pdf->SetXY(25,240);
$pdf->SetFont('Helvetica','B',8); 
$pdf->Cell(60,10,"VoBo PARA PROXIMO SERVICIO",0 ,0,'C',0);
$pdf->SetFont('Helvetica','',8);
$pdf->SetXY(25,245);
$pdf->Cell(60,10,"LIC. OSCAR ALBERTO BAEZA FRANCO", 0,0,'C',0);
$pdf->SetXY(25,250);
$pdf->Cell(60,10,"JEFE DPTO. DE REC. MAT. Y SERV. GRALES.", 0,0,'C',0);


$pdf->SetXY(130,235);
$pdf->Cell(60,10,"__________________________________________",0 ,0,'C',0);
$pdf->SetXY(130,240);
$pdf->SetFont('Helvetica','B',8); 
$pdf->Cell(60,10,"ELABORA BITACORA",0 ,0,'C',0);
$pdf->SetFont('Helvetica','',8); 
$pdf->SetXY(130,245);
$pdf->Cell(60,10,"C. FLORENTINO CHAVEZ LEAL", 0,0,'C',0);
$pdf->SetXY(130,250);
$pdf->Cell(60,10,"ENCARGADO DE MANTENIMIENTO VEHICULAR", 0,0,'C',0);






 /////////// Informacion de quien imprimio el formato
$pdf->SetFont('Helvetica','',8);   
$pdf->Text(20, 276, 'Impreso por :'.$nitavu); 
        


ob_end_clean();
 if($orientacion == 'P'){

  
	// reset pointer to the last page
	$pdf->lastPage();
	//Close and output PDF document}
 
	$pdf->Output('reporte.pdf', 'I');
}
?>