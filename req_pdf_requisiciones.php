<?php
require("config.php");
require_once('seguridad.php');
require_once('lib/funciones.php');
require_once('pdf/tcpdf.php');
require('lib/flor_funciones.php');
require('lib/yes_funciones.php');


$id_aplicacion ="ap49";
$nivel =aplicacion_nivel($id_aplicacion, $nitavu);

//echo $nivel;
if (sanpedro($id_aplicacion, $nitavu)==TRUE)
{


if (isset($_GET['search'])) {
    
    $search=$_GET['search'];
}
    

$tablaDatos='<BR><BR>
 <table style="vertical-align:middle;">
    <tr>
    <td align="center"><B>LISTADO DE REQUISICIONES</B></td></tr>   
    <tr><td align="right" style=" font-size: 9px;">';
    $tablaDatos=$tablaDatos."Impreso: ".fecha_larga($fecha).", ".hora12($hora)." por ".nitavu_nombre($nitavu);	
        
    $tablaDatos=$tablaDatos.'</td></tr>    
</table>
<br><br>'; 

    $tabla_contenido2='<center><table style="width:100%; border: 0.3px solid black;">                            
    <tr style=" text-align: center; background-color:#BDBDBD;  font-weight:bold;">
        <td  style="width:5%; text-align: center;  border: 0.3px solid black;">#</td>				
        <td  style="width:5%;vertical-align:middle; border: 0.3px solid black;">ID REQ</td>
        <td  style="width:30%;vertical-align:middle; border: 0.3px solid black;">DIRECCION</td>
        <td  style="width:20%;vertical-align:middle; border: 0.3px solid black;">DEPARTAMENTO</td>
        <td  style="width:20%;vertical-align:middle; border: 0.3px solid black;">TIPO REQUISICION</td>
        <td  style="width:10%;vertical-align:middle; border: 0.3px solid black;">ESTATUS</td>
        <td  style="width:10%;vertical-align:middle; border: 0.3px solid black;">FECHA CREA</td>
    </tr>';
 

//consulta sin LIMIT
if ($nivel == 1)
{
		$sql = " -- req 

		SELECT rq.IdRequisicion,
		CASE cg.nivel WHEN  'Dir.' THEN (select UPPER(nombre)from cat_gerarquia where id=  cg.id)
		WHEN  '-'   THEN UPPER(cg.nombre)
        ELSE 
          case cgg.nivel     
          when'Dpto.' then (select UPPER(nombre)from cat_gerarquia where id= (select dependencia from cat_gerarquia where id= cgg.id ))
          when 'Sub.' then (select UPPER(nombre)from cat_gerarquia where id= (select dependencia from cat_gerarquia where id= cgg.id )) 
          when 'CONSEJO' then UPPER(cg.nombre)  ELSE UPPER(cgg.nombre)
        END END AS Direccion,
		UPPER(cg.nombre) as Departamento, 
		tr.Requisicion, er.DesEstatus, rq.FechaCrea FROM req_requisiciones AS rq 
		INNER JOIN req_detallerequisicion AS dr on rq.IdRequisicion=dr.IdRequisicion
		INNER JOIN req_estatusreq AS er ON rq.IdEstatus=er.IdEstatus

		INNER JOIN req_tiporequisicion tr ON tr.IdTipoRequisicion=rq.IdTipoRequisicion 
		INNER JOIN cat_gerarquia AS cg ON cg.id=dr.IdDepartamento 
		LEFT JOIN cat_gerarquia AS cgg ON cgg.id=cg.dependencia ";	
		$sql = $sql."WHERE ";
		$sql = $sql."rq.IdEstatus <> 6 AND ";
		$sql = $sql."((cg.nombre LIKE '%".$search."%') OR ";
		//$sql = $sql."(cgg.nombre LIKE '%".$search."%') OR ";
		$sql = $sql."(er.DesEstatus LIKE '%".$search."%') ) ";
		$sql = $sql."GROUP BY rq.IdRequisicion ORDER BY rq.IdRequisicion DESC";
}
else
{   $sql = " -- req 

		SELECT rq.IdRequisicion, 
		CASE cg.nivel WHEN  'Dir.' THEN (select UPPER(nombre)from cat_gerarquia where id=  cg.id)
		WHEN  '-'   THEN UPPER(cg.nombre)
        ELSE 
          case cgg.nivel     
          when'Dpto.' then (select UPPER(nombre)from cat_gerarquia where id= (select dependencia from cat_gerarquia where id= cgg.id ))
          when 'Sub.' then (select UPPER(nombre)from cat_gerarquia where id= (select dependencia from cat_gerarquia where id= cgg.id )) 
          when 'CONSEJO' then UPPER(cg.nombre)  ELSE UPPER(cgg.nombre)
        END END AS Direccion,
		UPPER(cg.nombre) as Departamento, 
		tr.Requisicion, er.DesEstatus, rq.FechaCrea FROM req_requisiciones AS rq 
		INNER JOIN req_detallerequisicion AS dr on rq.IdRequisicion=dr.IdRequisicion
		INNER JOIN req_estatusreq AS er ON rq.IdEstatus=er.IdEstatus

		INNER JOIN req_tiporequisicion tr ON tr.IdTipoRequisicion=rq.IdTipoRequisicion 
		INNER JOIN cat_gerarquia AS cg ON cg.id=dr.IdDepartamento 
		LEFT JOIN cat_gerarquia AS cgg ON cgg.id=cg.dependencia ";	
		$sql = $sql."WHERE ";
		$sql = $sql."rq.IdEstatus <> 6 AND ";
		$sql = $sql."(((cg.nombre LIKE '%".$search."%') OR ";
		//$sql = $sql."(cgg.nombre LIKE '%".$search."%') OR ";
		$sql = $sql."(er.DesEstatus LIKE '%".$search."%') )AND  ";
		$sql = $sql."(rq.IdDepartamento=".nitavu_dpto ($nitavu).")) ";
		$sql = $sql."GROUP BY rq.IdRequisicion ORDER BY rq.IdRequisicion DESC";

}


                   
    $rc= $conexion -> query($sql);               
    $cont=0;
                            
    while($cat = $rc -> fetch_array())
        {
				$cont=$cont+1;
                $tabla_contenido2= $tabla_contenido2.'<tr ><td style="width:5%; text-align: center; border: 0.3px solid black; ">'.$cont.'</td>';
                $tabla_contenido2= $tabla_contenido2.'<td style="width:5%; border: 0.3px solid black;">'.$cat['IdRequisicion'].'</td>';
                $tabla_contenido2= $tabla_contenido2.'<td style="width:30%; border: 0.3px solid black;">'.$cat['Direccion'].'</td>';
                $tabla_contenido2= $tabla_contenido2.'<td style="width:20%; border: 0.3px solid black;">'.$cat['Departamento'].'</td>'; 
                $tabla_contenido2= $tabla_contenido2.'<td style="width:20%; border: 0.3px solid black;">'.$cat['Requisicion'].'</td>';                
                $tabla_contenido2= $tabla_contenido2.'<td style="width:10%; border: 0.3px solid black;">'. $cat['DesEstatus'].'</td>'; 
                $tabla_contenido2= $tabla_contenido2.'<td style="width:10%; border: 0.3px solid black;">'.date_format( date_create($cat['FechaCrea']), 'd/m/Y').'</td></tr>';         
        }                
							
                      
                        

    $tabla_contenido2=$tabla_contenido2."</table></center><br><br><br><br>";

    $html= $tablaDatos.$tabla_contenido2;

//echo $html;

    $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
    // set document information
    $pdf->SetCreator(PDF_CREATOR);
    $pdf->SetTitle('REQUISICIONES');
    $pdf->SetKeywords('Reporte ITAVU');
    //$pdf->SetHeaderData('pdf_logo.jpg', '40','', '');
    $pdf->SetHeaderData('pdf_logo.jpg', '40', 'DIRECCIÓN DE ADMINISTRACION Y FINANZAS', 'DEPARTAMENTO DE ADQUISICIONES');
    //$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, '', '');
    //$link = "http://".$urlnueva[0]."/md_lista.php";
    
    //$img = file_get_contents('C:\pdz-server\htdocs\img\regreso.png');
    $img = file_get_contents('img/regreso.png');
    
    // set header and footer fonts
    $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', 9));
    //$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
    $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
    // set default monospaced font
    $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
    // set margins
    $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
    $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
    $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
   // $pdf->SetFooterData("Impreso: ".fecha_larga($fecha).", ".hora12($hora)." por ".nitavu_nombre($nitavu),array(0, 30, 0),array(0, 30, 20));

    $pdf->setPrintFooter(TRUE);
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
    $pdf->SetFont('helvetica', '', 9);
    // add a page
    $pdf->AddPage('L', 'A4'); //en la tabla de reporte L o P
    //$html = $tabla;
    //echo $html; aqui escribe el contenido de la consulta
    $pdf->Image('@' . $img, 300, 0, '', '', '', $link, 'rigth', false, 0, '', false, false, 0, false, false, false);
    
    $pdf->writeHTML($html, true, false, true, false, '');

    // reset pointer to the last page
    $pdf->lastPage();
    //Close and output PDF document}
    ob_end_clean();
    $pdf->Output('reporte.pdf', 'I');
}
else{echo "	<br><br>";echo "No tiene acceso a ".$id_aplicacion;}
?>