<?php
require("config.php");
//require_once('/seguridad.php');
require_once('lib/funciones.php');
require_once('pdf/tcpdf.php');
require('lib/flor_funciones.php');
require('lib/yes_funciones.php');

$FolioTramite = $_GET['folio'];
$nitavu = $_GET['nitavu'];
//$FolioTramite = 124;

$Nombres = TramiteNombres($FolioTramite);
$Apellido1 = TramiteApellido1($FolioTramite);
$Apellido2= TramiteApellido2($FolioTramite);
$quienCaptura = QuiencapturoTramite($FolioTramite);


$IdTipoTramite = TramiteIdTipoTramite($FolioTramite);
$NombreDelTramite = TramiteNombre($IdTipoTramite);
 $DescripcionDelTramite = TramiteDescripcion($IdTipoTramite);

 

    




//    // historia($nitavu, 'Veo el reporte de la lista de mandantes con los montos por pagar, y todos los saldos.');
   


//   $tablaDatos='<BR><BR>

//  <table>
//  <tr>
//  <td style="width:30%;"><img src="img/pdf_logo.png" height="35"  ></td>
//  <td style="width:70%; font-size:12px; vertical-align:middle;">INSTITUTO TAMAULIPECO DE VIVIENDA Y URBANISMO</td>
//  </tr>
//  </table> ';

  $tablaDatos='<BR><BR><BR>

 <table>
     <tr STYLE="vertical-align:middle;" bottom="middle" >
         <td style="width:70%;">
         <table>            
            <tr><td style="font-size:18px; font-weight: bold;"></td></tr>
            <tr><td style="font-size:17px; font-weight: bold;">'.strtoupper($NombreDelTramite).'</td></tr>
            <tr><td style="font-size:10px; font-style: italic; ">'.$DescripcionDelTramite.'</td></tr>
            <tr><td style="font-size:11px;">'.TramiteProgramaNombre($IdTipoTramite).'</td></tr>
		</table>
     </td>
     <td style="width:30%;">
     <table  cellspacing="2" cellpadding="3">             
             <tr><td colspan="2"  ><b></b></td></tr>
             <tr style="font-size:15px; font-weight:bold;"><td>FOLIO:</td><td>'.$FolioTramite.'</td></tr>           	            
             <tr><td><b>FECHA:</b></td><td>'.date_format( date_create($fecha), 'd/m/Y').'</td></tr>            
             
         </table>
     </td>
        
         
     </tr>
     
     
     
 </table><br><br><br>';

// set font

$tGenelares='<p><b>DATOS DEL SOLICITANTE</b></p><br><br>
<table>
<tr><td style="width:20%;"><b>CURP:</b></td><td>'.TramiteCURP($FolioTramite).'</td></tr>
<tr><td style="width:20%;"><b>Nombre:</b></td><td>'. TramiteNombres($FolioTramite).' '.TramiteApellido1($FolioTramite).' '.TramiteApellido2($FolioTramite).'</td></tr>
<tr><td style="width:20%;"><b>Fecha de Nacimiento:</b></td><td>'.date_format( date_create(TramiteFechaNacimiento($FolioTramite)), 'd/m/Y') .'</td></tr>';
if(TramiteSexo($FolioTramite)=='M'){
    $tGenelares=$tGenelares.'<tr><td><b>Sexo:</b></td><td>MUJER</td></tr>';
}else{
    $tGenelares=$tGenelares.'<tr><td><b>Sexo:</b></td><td>HOMBRE</td></tr>';
}

if(TramiteEdoCivil($FolioTramite)=='1'){
    $tGenelares=$tGenelares.'<tr><td><b>Estado Civil:</b></td><td>CASADO(A)</td></tr>';
}
else{
    $tGenelares=$tGenelares.'<tr><td><b>Estado Civil:</b></td><td>SOLTERO(A)</td></tr>';
}

$tGenelares=$tGenelares.'</table><BR><BR><BR>';                    
               

            
                 
//   $tabla_contenido1= $tabla_contenido1.'<tr ><td style="width:50%; text-align: left; vertical-align:middle; "><b>'.$cat['NombreRequisito'].' </b></td>';
// $tabla_contenido1= $tabla_contenido1.'<td style="width:50%; text-align: left; vertical-align:middle;">'.$cat['Dato'].'</td></tr>';
/// $tabla_contenido1= $tabla_contenido1.'<td style="width:95%; text-align: left; vertical-align:middle;">'.$cat['NombreRequisito'].'</td></tr>';               
//  $tGenelares=$tGenelares.$tabla_contenido1;
// $tGenelares=$tGenelares."</table><br><br><br><br>";
            


$t='<p><b>DOCUMENTOS ENTREGADOS</b></p><br><br><table style="height:90%;">';
 
$tabla_contenido2='';

                        $sql = " SELECT tramitesrequisitos.IdRequisito, tramitesrequisitos.NombreRequisito,tramitesrequisitos.TipoRequisito,tramitesrequisitos.IdCatRequisitos,
                        tramitesrequisitoscat.Nombre, tramiteslistarequisitos.Opcional,tramitesrequisitos.Descripcion
                        ,(SELECT tramitesinformacion.Dato FROM tramitesinformacion WHERE tramitesinformacion.IdTramite=tramites.IdTramite 
                        AND tramitesinformacion.IdRequisito=tramitesrequisitos.IdRequisito AND tramitesinformacion.Cancelado=0 ) AS Dato
                        FROM tramitestipo
                        INNER JOIN tramites ON tramitestipo.IdTipoTramite=tramitestipo.IdTipoTramite
                        LEFT JOIN tramiteslistarequisitos ON tramiteslistarequisitos.IdTipoTramite=tramitestipo.IdTipoTramite
                        INNER JOIN tramitesrequisitos ON tramitesrequisitos.IdRequisito=tramiteslistarequisitos.IdRequisito
                    
                        INNER JOIN tramitesrequisitoscat ON tramitesrequisitoscat.IdCatRequisitos=tramitesrequisitos.IdCatRequisitos
                        WHERE  tramitestipo.IdTipoTramite=".$IdTipoTramite." AND tramites.IdTramite=".$FolioTramite." and tramitesrequisitos.Cancelado=0
                        and tramitesrequisitos.TipoRequisito='file'
                        order by tramitesrequisitoscat.IdCatRequisitos,tramitesrequisitos.IdRequisito asc";
                
                $rc= $conexion -> query($sql);               
               
                       
            
                    while($cat = $rc -> fetch_array())
             {
                
                if ($cat['Dato']<>'' OR $cat['Dato']<>NULL ) {
                    $tabla_contenido2= $tabla_contenido2.'<tr ><td style="width:5%; text-align: center;  vertical-align:middle;"> <img src="icon/reveri.png" height="15" width="15"></td>';
                }else
                {
                    $tabla_contenido2= $tabla_contenido2.'<tr ><td style="width:5%; text-align: center; vertical-align:middle; "> </td>';
                }
   
                 $tabla_contenido2= $tabla_contenido2.'<td style="width:95%; text-align: left; vertical-align:middle;">'.$cat['NombreRequisito'].'</td></tr>';
                
                
                
                          
               
            
            }

            $t=$t.$tabla_contenido2;
           $t=$t."</table><br><br><br><br>";
            
         


            $tabla=$tablaDatos.$tGenelares.$t;
    




//echo $tabla;
$orientacion='P';
 $autor="INSTITUTO TAMAULIPECO DE VIVIENDA Y URBANISMO";
 $titulo="INSTITUTO TAMAULIPECO DE VIVIENDA Y URBANISMO";

 $descripcion=nitavu_dpto_nombre($nitavu);




// create new PDF document
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor($autor);
$pdf->SetTitle(strtoupper($titulo));
$pdf->SetSubject($descripcion);
$pdf->SetKeywords(strtoupper($NombreDelTramite));



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
$pdf->SetFont('helvetica', '', 8);
// add a page
$pdf->AddPage($orientacion); //en la tabla de reporte L o P
$html = $tabla;

//echo $html; //aqui escribe el contenido de la consulta

//echo $tabla;
$pdf->writeHTML($html, true, false, true, false, '');




$linea='_________________________________';
$pdf->SetFont('Helvetica','B',7); 
$pdf->SetXY(10,243);
$pdf->Cell(60,10,"ATENDIDO POR",0 ,0,'C',0);
$pdf->SetXY(10,255);
$pdf->SetFont('Helvetica','',7); 
$pdf->Cell(60,10,strtoupper(nitavu_nombre($nitavu)), 0,0,'C',0);
$pdf->SetXY(10,250);
$pdf->SetFont('Helvetica','B',7); 
$pdf->Cell(60,10,$linea, 0,0,'C',0);


// $pdf->SetXY(75,253);
// $pdf->SetFont('Helvetica','B',7);  
// $pdf->Cell(60,10,"SOLICITANTE", 0,0,'C',0);
// $pdf->SetXY(75,265);
// $pdf->SetFont('Helvetica','',7);  
// $pdf->Cell(60,10,$Titular, 0,0,'C',0);


 

 $pdf->SetXY(75,263);
 $y = $pdf->GetY();
// $pdf->SetFont('Helvetica','B',7);   
// $pdf->MultiCell(60,4,$linea,0,'C');

$pdf->SetXY(75,$y);
$pdf->SetXY(140,243);
$pdf->SetFont('Helvetica','B',7);  
$pdf->Cell(60,10,"SOLICITANTE", 0,0,'C',0);
$pdf->SetXY(140,255);
$pdf->SetFont('Helvetica','',7); 
$pdf->Cell(60,10,'C. '.$Nombres.' '.$Apellido1.' '.$Apellido2, 0,0,'C',0);
$pdf->SetXY(140,250);
$pdf->SetFont('Helvetica','B',7); 


//$pdf->Cell(60,10,"DIRECTOR GENERAL", 0,0,'C',0);// BORRAR
//$pdf->SetXY(140,263);// BORRRAR
//$pdf->Cell(60,10," DE ADMINISTRACIÓN Y FINANZAS ", 0,0,'C',0);// BORRAR
$pdf->Cell(60,10,$linea, 0,0,'C',0);


/////////// Informacion de quien imprimio el formato
// $pdf->SetFont('Helvetica','',6);   
// $pdf->Text(20, 276, 'Impreso por :'.$nitavu); 
       



if($orientacion == 'P'){
 
   // reset pointer to the last page
   $pdf->lastPage();
   //Close and output PDF document}
   ob_end_clean();
   $pdf->Output('AcuseSolicitud.pdf', 'I');
}
?>