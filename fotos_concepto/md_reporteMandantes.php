<?php
require("unica/config.php");
require_once('unica/seguridad.php');
require_once('unica/funciones.php');
require_once('pdf/tcpdf.php');
require('unica/flor_funciones.php');

$nitavu = $_GET['nitavu'];
$HayToken = MiToken($nitavu, 'xxxxx'); // Token disponible por usuario

// lo da en blanco cuando hubo algun problema, validarlo siempre
if ($HayToken == '') {
    

    echo "<div id='master' style='width:100%; height:100%; margin:0px; text-align:center;'>
		
		<center><form action='md_lista.php' method='POST'
		style='
		background-color:#A3C30F;
		width: 80%; border-radius:5px;
		display:inline-block;
		padding: 10px;'><h3 style='color:#FFF; margin:0px;' >ERROR: el enlace caduco, intentalo nuevamente</h3>";
		echo '<div ><input type="submit" 
        style="
        
            background-color: #005BA0; 
            color: white; 
            border: none;
            cursor: pointer;
            display: inline-block;
            outline: none;
            position: relative;
            -webkit-transition: all 0.3s;
            -moz-transition: all 0.3s;
            transition: all 0.3s;
            -webkit-transition: none;
            -moz-transition: none;
            transition: none;
            border-radius: 4px;
            padding-right: 10px;
            padding-left: 10px;
            padding-top: 10px;
            padding-bottom: 10px;
            margin-top: 5px;
            font-family: verdana; 
            font-weight: bold; 
            text-shadow: 0 1px black; 
            box-shadow: 0 3px #A2C30D; 
            font-size: 10pt;"
    value="Aceptar"></div>';
        //style='font-family:Verdana; font-size:12pt; with: 50%; padding:5px; '
        echo "</form><center>";
        
}else{
    historia($nitavu, 'Veo el reporte de la lista de mandantes con los montos por pagar, y todos los saldos.');

    $tabla = "";
    $sqlMandantes = "SELECT  mu.Municipio as MUN, co.Colonia as COL , ma.Mandante as MAN, ma.IdMandante as IdMAN, 
    ma.IdColonia as IdCOL, ma.IdMunicipio as IdMUN, ma.idTipoMandato as tipMan, ma.IdEstatus as estatus, 
    (mcar.lotes_contratadosLotes + mcar.lotes_contratadosSuelo)  as LotesContratados, (mcar.lotes_sincontratoLotes + mcar.lotes_sincontratoSuelo) as LotesSinContrato, SUM(mc.monto_pagado) as montoPagado, 
    mcar.monto_pagar as PagarContrato, (mcar.monto_pagar - SUM(mc.monto_pagado)) as resta,  ma.comentario as comentario
FROM cat_mandantes AS ma
INNER JOIN cat_colonias AS co ON ma.IdColonia = co.IdColonia and ma.IdMunicipio = co.IdMunicipio 
INNER JOIN cat_municipios AS mu ON ma.IdMunicipio = mu.IdMunicipio and ma.IdMunicipio = co.IdMunicipio 
LEFT JOIN mandantes_abonos as mc ON mc.idmandante = ma.IdMandante and mc.idcolonia = ma.IdColonia and mc.idmunicipio = ma.IdMunicipio and mc.cancelado = 0
LEFT JOIN  mandantes_cargos as mcar  ON mcar.idmandante = ma.IdMandante and mcar.idcolonia = ma.IdColonia and mcar.idmunicipio = ma.IdMunicipio and mcar.id=(select MAX(mcar.id) from mandantes_cargos as mcar where mcar.idmandante = ma.idmandante and mcar.idcolonia = ma.idcolonia and mcar.idmunicipio = ma.IdMunicipio)
    GROUP BY ma.IdMandante, ma.IdColonia, ma.IdMunicipio ORDER BY mu.Municipio, co.colonia ASC" ;
    //echo $sqlMandantes;
    $rc = $conexion -> query($sqlMandantes);
    $montoporpagar = 0;
    $montopagado = 0;
    $saldo = 0;
    $vuelta = 0;
    if ($rc->num_rows>0){
        
        $tabla = $tabla.'<table border="1" align = "center">';
        $tabla = $tabla.'<tr bgcolor="#C0BDBD">';
        $tabla = $tabla.'<th style="width:23px;"><b>NO.</b></th>';
        $tabla = $tabla.'<th style="width:100px;"><b>DELEGACIÓN</b></th>';
        $tabla = $tabla."<th><b>COLONIA</b></th>";
        $tabla = $tabla.'<th style="width:20%;"><b>MANDANTE</b></th>';
        $tabla = $tabla."<th><b>TIPO</b></th>";
        $tabla = $tabla.'<th style="width:4%;"><b>LOTES CONTRATADOS</b></th>';
        $tabla = $tabla.'<th style="width:4%;"><b>LOTES SIN CONTRATAR</b></th>';
        $tabla = $tabla."<th><b>MONTO POR PAGAR DE ACUERDO AL CONTRATO</b></th>";
        $tabla = $tabla."<th><b>MONTO PAGADO</b></th>";
        $tabla = $tabla."<th><b>SALDO POR PAGAR</b></th>";
        $tabla = $tabla."<th><b>ESTATUS</b></th>";
        $tabla = $tabla.'<th style="width:150px;"><b>OBSERVACIONES</b></th>';
        $tabla = $tabla."</tr>";
        while($r1 = $rc -> fetch_array()){
            $vuelta++;
            $tabla = $tabla."<tr>";
                $tabla = $tabla.'<td style="width:23px;">'.$vuelta.'</td>';
                $tabla = $tabla.'<td style="width:100px;">'.$r1['MUN'].'</td>';
                $tabla = $tabla."<td>".$r1['COL']."</td>";
                $tabla = $tabla.'<td style="width:20%;">'.$r1['MAN'].'</td>';
                $tabla = $tabla."<td>";                                    
                        if($r1['tipMan']!= 0){
                            $tipo = buscartipoMandante($r1['tipMan']);
                            $tabla = $tabla.strtoupper($tipo);
                        }else{
                            $tabla = $tabla."PDTE.";
                        }
                $tabla = $tabla."</td>";
                $tabla = $tabla."<td>".$r1['LotesContratados']."</td>";
                $tabla = $tabla."<td>".$r1['LotesSinContrato']."</td>";
                $montoporpagar = $montoporpagar + $r1['PagarContrato'];
                $montopagado = $montopagado + $r1['montoPagado'];
                $saldo = $saldo + $r1['resta'];
                $tabla = $tabla."<td>$".number_format($r1['PagarContrato'], 2, '.', ',')."</td>";
                $tabla = $tabla."<td>$".number_format($r1['montoPagado'], 2, '.', ',')."</td>";
                $tabla = $tabla."<td>$".number_format($r1['resta'], 2, '.', ',')."</td>";
                $tabla = $tabla."<td>";
                        if($r1['estatus']!= 0){
                            $estatus = buscarEstatusMandante($r1['estatus']);
                            $tabla = $tabla.strtoupper($estatus);
                        }else{
                            $tabla = $tabla."PDTE.";
                        }
                $tabla = $tabla."</td>";   
                $tabla = $tabla.'<td style="width:150px;"><font size="7">'.$r1['comentario'].'</font></td>';  
            $tabla = $tabla."</tr>";       
        }
        $tabla = $tabla."</table>";
    }

    $tabla = $tabla.'<br><br><table align = "center" bgcolor="#E4E0E0">
                        <tr>
                            <td border="0" bgcolor="#FFF" style="width:23px;"></td>
                            <td border="0" bgcolor="#FFF" style="width:100px;"></td>
                            <td border="0" bgcolor="#FFF"></td>
                            
                            <td border="1"  colspan="4" style="width:412px;">TOTALES</td>
                            <td border="1">$'.number_format($montoporpagar, 2, '.', ',').'</td>
                            <td border="1">$'.number_format($montopagado, 2, '.', ',').'</td>
                            <td border="1">$'.number_format($saldo, 2, '.', ',').'</td>

                            <td border="0" bgcolor="#FFF" style="width:150px;"></td>
                        </tr>
                    </table>
    ';

    $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
    // set document information
    $pdf->SetCreator(PDF_CREATOR);
    $pdf->SetTitle('LISTADO MANDANTES');
    $pdf->SetKeywords('Reporte ITAVU');
    //$pdf->SetHeaderData('pdf_logo.jpg', '40','', '');
    $pdf->SetHeaderData('pdf_logo.jpg', '40', 'LISTADO MANDANTES', "Impreso: ".fecha_larga($fecha).", ".hora12($hora)." por ".nitavu_nombre($nitavu));
    //$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, '', '');
    $link = "https://plataformaitavu.tamaulipas.gob.mx/itavu/md_lista.php";
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
    //$pdf->SetFooterData("Impreso: ".fecha_larga($fecha).", ".hora12($hora)." por ".nitavu_nombre($nitavu),array(0, 64, 0),array(0, 64, 128));

    $pdf->setPrintFooter(true);
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
    $pdf->AddPage('L', 'LEGAL'); //en la tabla de reporte L o P
    $html = $tabla;
    //echo $html; aqui escribe el contenido de la consulta
    $pdf->Image('@' . $img, 300, 0, '', '', '', $link, 'rigth', false, 0, '', false, false, 0, false, false, false);
    
    $pdf->writeHTML($html, true, false, true, false, '');

    // reset pointer to the last page
    $pdf->lastPage();
    //Close and output PDF document}
    //ob_end_clean();
    $pdf->Output('reporte.pdf', 'I');
        //else ok
    MiToken_Close($nitavu, $HayToken); //Cierro el Token

}
?>