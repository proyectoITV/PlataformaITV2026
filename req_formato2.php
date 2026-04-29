<?php

require("config.php");
require_once('seguridad.php');
require_once('pdf/tcpdf.php');
//$nitavu="2809";
$idRequisicion = $_GET['n'];

error_reporting(0);
$sql = " -- req
SELECT rq.IdRequisicion -- UPPER(cgg.nombre) as Direccion
,UPPER(cg.nombre) as Departamento,cg.nivel, cgg.nivel,cgg.id,
CASE cg.nivel WHEN   UPPER('dir') THEN (select UPPER(nombre)from cat_gerarquia where id=  cg.id)
WHEN  '-'   THEN UPPER(cg.nombre)
ELSE 
  case cgg.nivel     
  when UPPER('dpto') then (select UPPER(nombre)from cat_gerarquia where id= (select dependencia from cat_gerarquia where id= cgg.id ))
  when  UPPER('sub') then (select UPPER(nombre)from cat_gerarquia where id= (select dependencia from cat_gerarquia where id= cgg.id )) 
  when  UPPER('CONSEJO') then UPPER(cg.nombre)  ELSE UPPER(cgg.nombre)
END END AS Direccion,
CASE  cg.nivel WHEN  UPPER('dir') THEN (CONCAT(ifnull(UPPER(emj.profesion_abr),''),' ',UPPER(emj.nombre)))
WHEN  '-'   THEN UPPER(cg.nombre)
ELSE 
  case cgg.nivel     
  when  UPPER('dpto') then   (select CONCAT(ifnull(UPPER(empleados.profesion_abr),''),' ', UPPER(empleados.nombre) )from cat_gerarquia INNER JOIN empleados on cat_gerarquia.titular=empleados.nitavu  where cat_gerarquia.titular=(select titular from cat_gerarquia where  id= (select dependencia from cat_gerarquia where id=  cgg.id )))  when 'Sub.' then  (select CONCAT(ifnull(UPPER(empleados.profesion_abr),''),' ', UPPER(empleados.nombre) )from cat_gerarquia INNER JOIN empleados on cat_gerarquia.titular=empleados.nitavu  where cat_gerarquia.titular=(select titular from cat_gerarquia where  id= (select dependencia from cat_gerarquia where id=  cgg.id ))) when 'CONSEJO.' then  (select CONCAT(ifnull(UPPER(empleados.profesion_abr),''),' ', UPPER(empleados.nombre) )from cat_gerarquia INNER JOIN empleados on cat_gerarquia.titular=empleados.nitavu  where cat_gerarquia.titular=(select titular from cat_gerarquia where  id= (select dependencia from cat_gerarquia where id=  cgg.id )))
  when  UPPER('sub') then   (select CONCAT(ifnull(UPPER(empleados.profesion_abr),''),' ', UPPER(empleados.nombre) )from cat_gerarquia INNER JOIN empleados on cat_gerarquia.titular=empleados.nitavu  where cat_gerarquia.titular=(select titular from cat_gerarquia where  id= (select dependencia from cat_gerarquia where id=  cgg.id )))  when 'Sub.' then  (select CONCAT(ifnull(UPPER(empleados.profesion_abr),''),' ', UPPER(empleados.nombre) )from cat_gerarquia INNER JOIN empleados on cat_gerarquia.titular=empleados.nitavu  where cat_gerarquia.titular=(select titular from cat_gerarquia where  id= (select dependencia from cat_gerarquia where id=  cgg.id ))) when 'CONSEJO.' then  (select CONCAT(ifnull(UPPER(empleados.profesion_abr),''),' ', UPPER(empleados.nombre) )from cat_gerarquia INNER JOIN empleados on cat_gerarquia.titular=empleados.nitavu  where cat_gerarquia.titular=(select titular from cat_gerarquia where  id= (select dependencia from cat_gerarquia where id=  cgg.id ))) 
  when  UPPER('CONSEJO') then CONCAT(ifnull(UPPER(em.profesion_abr),''),' ',UPPER(em.nombre))
            else   CONCAT(ifnull(UPPER(em.profesion_abr),''),' ',UPPER(em.nombre))
END END AS Titular
,tr.Requisicion, DATE_FORMAT(rq.FechaCrea, '%Y-%m-%d') AS FechaCrea 
,(select CONCAT(ifnull(UPPER(empleados.profesion_abr),''),' ', UPPER(empleados.nombre) )from cat_gerarquia INNER JOIN empleados on cat_gerarquia.titular=empleados.nitavu  where cat_gerarquia.nombre like '%Adquicisiones%') as TitularAdquisiciones
,(select CONCAT(ifnull(UPPER(empleados.profesion_abr),''),' ', UPPER(empleados.nombre)) from cat_gerarquia INNER JOIN empleados on cat_gerarquia.titular=empleados.nitavu  where cat_gerarquia.nombre like '% Administracion y Finanzas%') as TitularFinanzas,
rq.Justificacion, cg.nivel,
CONCAT(ifnull(UPPER(emj.profesion_abr),''),' ',UPPER(emj.nombre)) AS TitularJefeDpto

FROM req_requisiciones AS rq
INNER JOIN req_detallerequisicion AS dr on rq.IdRequisicion=dr.IdRequisicion
INNER JOIN req_tiporequisicion tr ON tr.IdTipoRequisicion=rq.IdTipoRequisicion
INNER JOIN cat_gerarquia AS cg ON cg.id=dr.IdDepartamento
LEFT JOIN cat_gerarquia AS cgg ON cgg.id=cg.dependencia
LEFT JOIN empleados as em on cgg.titular=em.nitavu
LEFT JOIN empleados as emj on cg.titular=emj.nitavu
WHERE rq.IdRequisicion = ".$idRequisicion."  GROUP BY rq.IdRequisicion";


$rc= $conexion -> query($sql);
$msg="";

if($f = $rc -> fetch_array())
{

    $TitularAdquisiciones=$f['TitularAdquisiciones'];
    $TitularFinanzas=$f['TitularFinanzas'];
    $Departamento=$f['Departamento'];
    $Direccion=$f['Direccion'];
    $FechaCrea=$f['FechaCrea'];
    $TipoRequisicion=$f['Requisicion'];
    $Titular=$f['Titular'];// ERA JEFE DE DEPTO Y SE CAMBIO A DIRECTOR
    $Justificacion=$f['Justificacion'];
    $nivel=$f['nivel'];
    $TitularJ=$f['TitularJefeDpto'];
     $dir=$f['id'];
   
}
  
 if($nivel=='Dir.' or strpos($Departamento, 'COORDINACION') !== false) 
 {  
     $Direccion=$Departamento;
     $Titular=$TitularJ;
  }

 

$tablaDatos='<BR><BR>
<table >
    <tr>
        <td style="width:70%;">
		<table  cellspacing="2" cellpadding="3">
			<tr><td style="width:30%;"><b>AREA SOLICITANTE:</b></td><td style="width:70%;">'.$Direccion.'</td></tr>
			<tr><td style="width:30%;"><b>PARA UTILIZARSE EN:</b></td><td style="width:70%;">'. $Departamento.'</td></tr>
			<tr><td style="width:30%;"><b>CON CARGO A </b></td><td style="width:70%;">'. $Direccion.'</td></tr>
			<tr><td style="width:30%;" ><b>FECHA ELABORACIÓN: </b></td><td style="width:70%;">'.date_format( date_create($FechaCrea), 'd/m/Y').'</td></tr>
		</table>
	</td>
	<td style="width:30%;">
    <table  cellspacing="2" cellpadding="3">
            
            <tr><td colspan="2"  ><b>REQUISICIÓN DE '.$TipoRequisicion.'</b></td></tr>
            <tr style="font-size:18px; font-weight:bold;"><td>FOLIO:</td><td>'.$idRequisicion.'</td></tr>           	            
            <tr><td><b>FECHA DE IMPRESIÓN:</b></td><td>'.date_format( date_create($fecha), 'd/m/Y').'</td></tr>
           
			
		</table>
	</td>
       
        
    </tr>
    
    
    
</table><br><br>';


$t='<table cellpadding="4" style="border: 0.3px solid black; height:90%;">                            
<tr  style=" text-align: center; background-color:#BDBDBD;  font-weight:bold;">
	<td  style="width:5%; height:15px;  border: 0.3px solid black;">#</td>								
   
	<td  style="width:10%; vertical-align:middle;   border: 0.3px solid black;">CANTIDAD</td>
	<td  style="width:15%; vertical-align:middle;  border: 0.3px solid black;">UNIDAD</td>
	<td  style="width:30%;vertical-align:middle;   border: 0.3px solid black;">CONCEPTO</td>
	<td  style="width:40%;  vertical-align:middle; border: 0.3px solid black;">JUSTIFICACIÓN</td>
 </tr>';
 

$tabla_contenido2='';

                        $sql = " -- req 
                        SELECT req_detallerequisicion.IdDetalle,req_detallerequisicion.IdConcepto,req_detallerequisicion.Cantidad,
                         req_unidades.Unidad , req_conceptos.Concepto,UPPER(req_detallerequisicion.Justificacion) AS Justificacion FROM req_detallerequisicion inner join req_conceptos on req_detallerequisicion.IdConcepto=req_conceptos.IdConcepto
                         inner join req_unidades on req_unidades.IdUnidad = req_detallerequisicion.IdUnidad where req_detallerequisicion.Cancelado=0  
                         and req_detallerequisicion.IdRequisicion='".$idRequisicion."' 
                         GROUP BY req_detallerequisicion.IdConcepto HAVING SUM(req_detallerequisicion.Cantidad) > 0  Order By req_conceptos.Concepto";
                   
                $rc= $conexion -> query($sql);               
                $cont=0;
                       
            
                    while($cat = $rc -> fetch_array())
             {
				$cont=$cont+1;
                $tabla_contenido2= $tabla_contenido2.'<tr ><td style="width:5%; text-align: center; border: 0.3px solid black; ">'.$cont.'</td>';
                 $tabla_contenido2= $tabla_contenido2.'<td style="width:10%; text-align: center;border: 0.3px solid black;">'.$cat['Cantidad'].'</td>';
                 $tabla_contenido2= $tabla_contenido2.'<td style="width:15%; text-align: center; border: 0.3px solid black;">'.$cat['Unidad'].'</td>';
                 $tabla_contenido2= $tabla_contenido2.'<td style="width:30%;  border: 0.3px solid black;">'.$cat['Concepto'].'</td>'; 
                //  $tabla_contenido2= $tabla_contenido2.'<td style="width:40%; font-size:12pt;">'..'</td></tr>'; 
                
                   $tabla_contenido2= $tabla_contenido2.'<td style="width:40%; text-transform: uppercase; border: 0.3px solid black;">'. strip_tags($cat['Justificacion'],'').'<br></td></tr>'; 
                          
               
            
            }
                   /*  $tabla_contenido2= $tabla_contenido2.'<tr>';
                                  $tabla_contenido2= $tabla_contenido2.'<td style="width:30%; text-align: center;border: 0.3px solid black;">'.$TitularAdquisiciones.'</td>';
                                  $tabla_contenido2= $tabla_contenido2.'<td style="width:40%; text-align: center; border: 0.3px solid black;">'.$Titular.'</td>';
                                  $tabla_contenido2= $tabla_contenido2.'<td style="width:30%;  border: 0.3px solid black;">'.$TitularFinanzas.'</td>'; 

                                  $tabla_contenido2= $tabla_contenido2.'</tr>'; */ 
							
                      
                        
                            $t=$t.$tabla_contenido2;
$t=$t."</table><br><br><br><br><br><br>";

$tabla=$tablaDatos.$t;


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