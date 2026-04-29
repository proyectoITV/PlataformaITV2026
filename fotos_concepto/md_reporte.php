<?php
ob_start();

require("unica/config.php");
require_once('unica/seguridad.php');
require_once('unica/funciones.php');
require_once('pdf/tcpdf.php');
require('unica/flor_funciones.php');

$idmandante = $_GET['id'];
$idcolonia = $_GET['idcolonia'];
$idmunicipio = $_GET['idmunicipio'];

$HayToken = MiToken($nitavu, 'xxxxx'); // Token disponible por usuario

// lo da en blanco cuando hubo algun problema, validarlo siempre
if ($HayToken == '') {
    

    echo "<div id='master' style='width:100%; height:100%; margin:0px; text-align:center;'>
		
		<center><form action='mandantes_pago.php?idmandante=".$idmandante."&idcolonia=".$idcolonia."&idmunicipio=".$idmunicipio."' method='POST'
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





historia($nitavu, 'Veo el reporte del id mandante '.$idmandante.', id colonia: '.$idcolonia.' y el id municipio: '.$idmunicipio.' .');
$titulosyfecha='

<p style="text-align:center; font-size:16px;">
<B>ESTADO DE CUENTA DE MANDATO</B>
</p>
<label style="text-align:right;">Cd. Victoria, Tam., a '.fechaSinDia($fecha).'</label>
';

 $id = estatusMandato($idmandante, $idcolonia, $idmunicipio);
 $status = "";
if($id != ''){
    $status =buscarEstatusMandante($id);
}
//'. strtoupper(apoderadoLegalMandante($idmunicipio,$idcolonia,$idmandante)).'
// <tr><td style="width:25%;">MANDANTE: </td><td><b>'. strtoupper(nombreMandante($idmunicipio,$idcolonia,$idmandante)).'</b></td></tr>
$dias = array("Domingo","Lunes","Martes","Miercoles","Jueves","Viernes","Sábado");
$meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
 


$tablaDatos='<BR>
<table >
    <tr>
        <td style="width:100%;">
            <table>
                
                <tr><td style="width:25%;">ESTATUS:</td><td><b>'.strtoupper($status).'</b></td></tr>
                <tr><td style="width:25%;">MUNICIPIO:</td><td><b>'.strtoupper(nombreMunicipio($idmunicipio)).'</b></td></tr>
                <tr><td style="width:25%;">COLONIA:</td><td><b>'. strtoupper(nombreColonia($idmunicipio,$idcolonia)).'</b></td></tr>
               
                <tr><td style="width:25%;">MANDANTE: </td><td><b>'. strtoupper(propietarioMandante($idmandante, $idcolonia, $idmunicipio)).'</b></td></tr>
                <tr><td style="width:25%;">APODERADO LEGAL: </td><td><b>'. strtoupper(nombreMandante($idmunicipio,$idcolonia,$idmandante)).'</b></td></tr>
            </table>
        </td>
    </tr>
    <tr>
        <td style="width:100%;">
        <table>';

    $query = "SELECT * FROM mandantes_cargos WHERE idmandante = ".$idmandante." and idcolonia = ".$idcolonia." and idmunicipio = ".$idmunicipio." ORDER BY id DESC LIMIT 1";
    $r= $conexion -> query($query);
    //echo $query;
    $tm = tipoMandante($idmandante, $idcolonia, $idmunicipio); 
 
    $totalapagar=0;
if ($r->num_rows>0){
    while($f = $r -> fetch_array()){
        $totalapagar= $f['monto_pagar'];
        $arr = exsiteOtroMandato($idmandante, $idcolonia, $idmunicipio);
        //echo $arr;
        $vuelta=0;
        $numMan=0;$numAde=0;
        if($arr){
            for($i=0; $i<sizeof($arr); $i++){
                $arr1= explode('*',$arr[$i]);
                
                for($j=0; $j<sizeof($arr1); $j++){
                    $vuelta++;
                    if($arr1[$j]!=null ){
                        if($arr1[$j]==1){
                            
                            if($arr1[$j+1]!=1 and $arr1[$j+1]!=null){
                                $numMan++;
                                $tablaDatos = $tablaDatos."<tr><td style='width:25%;'>FECHA MANDATO ".($numMan).": </td><td style='width:25%;'>".$arr1[$j+1]."</td><td></td><td></td></tr>";
                            }
                        }else{
                            if($arr1[$j+1]!=2 and $arr1[$j+1]!=null  ){
                                $numAde++;
                                $tablaDatos = $tablaDatos."<tr><td style='width:25%;'>FECHA ADENDUM ".($numAde).": </td><td style='width:25%;'>".$arr1[$j+1]."</td><td></td><td></td></tr>";

                            }

                        }
                    }
                }
                
                
            }  
            
        }
                
        if($f['tipo']==1){
            $tablaDatos = $tablaDatos."<tr><td style='width:25%;'>FECHA MANDATO ACTUAL: </td><td style='width:25%;'>".$f['fecha_mandato']."</td><td></td><td></td></tr>";
            
        }else{
            $tablaDatos = $tablaDatos."<tr><td style='width:25%;'>FECHA ADENDUM ACTUAL: </td><td style='width:25%;'>".$f['fecha_adendum']."</td><td>FECHA ADENDUM FINIQUITO:</td><td>".$f['fecha_adendumfiniquito']."</td></tr>";

        }    
        
              
        $tablaDatos = $tablaDatos."<tr><td style='width:25%;'>% MANDANTE:</td><td style='width:25%;'>".$f['porcentaje_mandante']."%</td><td> % ITAVU (GTS. DE ADMINISTRACIÓN): </td><td>".$f['porcentaje_itavu']."%</td></tr>";
        $tablaDatos = $tablaDatos."<tr><td style='width:25%;'>COSTO LOTE</td><td style='width:25%;'>$".number_format($f['costo_lotes'], 2, '.', ',')."</td><td>COSTO LOTE POR M2</td><td>$".number_format($f['costo_pormetro'], 2, '.', ',')."</td></tr>";
        $tablaDatos = $tablaDatos."<tr><td style='width:25%;'>SUPERFICIE TOTAL:</td><td style='width:25%;'>".$f['superficie']."</td><td>SUPERFICIE PARA COMERCIALIZAR </td><td>".$f['superficie_comercializar']."</td></tr>";
        $tablaDatos = $tablaDatos."<tr><td style='width:25%;'>PAGO TOTAL AL MANDANTE (DE ACUERDO AL CONTRATO): </td><td style='width:25%;'>$".number_format($f['monto_pagar'], 2, '.', ',')."</td><td>PAGO TOTAL AL MANDANTE (DE ACUERDO A LA TABLA DE COMERCIALIZACION)</td><td>$".number_format($f['monto_pagarcomercializacion'], 2, '.', ',')."</td></tr>";
        $tablaDatos = $tablaDatos."<tr><td style='width:25%;'>PLAZO DE CRÉDITO</td><td style='width:25%;'>".$f['plazo_credito']." Mensualidades</td><td></td><td></td></tr>";
        $tablaDatos = $tablaDatos."<tr><td style='width:25%;'>TIPO MANDATO: </td><td>".buscartipoMandante($tm)."</td><td style='width:25%;'></td><td></td></tr>";
        $tablaDatos = $tablaDatos.'<tr border="1" bgcolor="#E3E1E1"><td style="width:25%;"></td><td style="width:25%;">TOTAL LOTES</td><td>LOTES CONTRATADOS</td><td>LOTES SIN CONTRATO</td></tr>';
        $tablaDatos = $tablaDatos."<tr><td style='width:25%;'>PROGRAMA LOTES </td><td style='width:25%;'>".$f['total_lotesLotes']."</td><td>".$f['lotes_contratadosLotes']."</td><td>".$f['lotes_sincontratoLotes']."</td></tr>";
        $tablaDatos = $tablaDatos."<tr><td style='width:25%;'>PROGRAMA SUELO LEGAL</td><td style='width:25%;'>".$f['total_lotesSuelo']."</td><td>".$f['lotes_contratadosSuelo']."</td><td>".$f['lotes_sincontratoSuelo']."</td></tr>";
        $tablaDatos = $tablaDatos.'<tr border="1" bgcolor="#E3E1E1"><td style="width:25%;"></td><td style="width:25%;">LOTES ÁREA VERDE</td><td>LOTES EQUIPAMIENTO URBANO</td><td>LOTES RESERVA DEL MANDANTE</td></tr>';
        $tablaDatos = $tablaDatos."<tr><td style='width:25%;'> </td><td style='width:25%;'>".$f['area_verde']."</td><td>".$f['equi_urbano']."</td><td>".$f['reserva_mandante']."</td></tr>";
    }
}else{
     
     
    $tablaDatos = $tablaDatos."<tr><td style='width:25%;'>% MANDANTE:</td><td style='width:25%;'>PDTE</td><td> % ITAVU (GTS. DE ADMINISTRACIÓN): </td><td>PDTE</td></tr>";
    $tablaDatos = $tablaDatos."<tr><td>COSTO LOTE</td><td>PDTE</td><td>COSTO LOTE POR M2</td><td>PDTE</td></tr>";
    $tablaDatos = $tablaDatos."<tr><td style='width:25%;'>SUPERFICIE PARA COMERCIALIZAR </td><td style='width:25%;'>PDTE</td><td>PLAZO DE CRÉDITO</td><td>PDTE</td></tr>";
    $tablaDatos = $tablaDatos."<tr><td style='width:25%;'>PAGO TOTAL AL MANDANTE (DE ACUERDO AL CONTRATO): </td><td style='width:25%;'>PDTE</td><td>PAGO TOTAL AL MANDANTE (DE ACUERDO A LA TABLA DE COMERCIALIZACION)</td><td>PDTE</td></tr>";
    $tablaDatos = $tablaDatos."<tr><td style='width:25%;'>TIPO MANDATO: </td><td style='width:25%;'>PDTE</td><td></td><td></td></tr>";
    $tablaDatos = $tablaDatos.'<tr border="1" bgcolor="#E3E1E1"><td style="width:25%;"></td><td style="width:25%;">TOTAL LOTES</td><td>LOTES CONTRATADOS</td><td>LOTES SIN CONTRATO</td></tr>';
    $tablaDatos = $tablaDatos."<tr><td style='width:25%;'>PROGRAMA LOTES </td><td>PDTE</td><td>PDTE</td><td>PDTE</td></tr>";
    $tablaDatos = $tablaDatos."<tr><td style='width:25%;'>PROGRAMA SUELO LEGAL</td><td>PDTE</td><td>PDTE</td><td>PDTE</td></tr>";
    $tablaDatos = $tablaDatos.'<tr border="1" bgcolor="#E3E1E1"><td style="width:25%;"></td><td style="width:25%;">LOTES ÁREA VERDE</td><td>LOTES EQUIPAMIENTO URBANO</td><td>LOTES RESERVA DEL MANDANTE</td></tr>';
        $tablaDatos = $tablaDatos."<tr><td style='width:25%;'> </td><td style='width:25%;'>PDTE</td><td>PDTE</td><td>PDTE</td></tr>";

}

$tablaDatos = $tablaDatos.'
		    </table>
	    </td> 
    </tr>  
</table>';

/* <tr>
            <td colspan="9" align="center">Pago inicial (anticipo) de acuerdo a contrato de mandato de fecha '.$fechaMandato.'</td>
            <td>$'.number_format($anticipo, 2, '.', ',').'</td>
            <td>$'.number_format($anticipo, 2, '.', ',').'</td>
            <td>$'.number_format($saldoDespuesAnticipo, 2, '.', ',').'</td>
        </tr> */
$t='<br><br><table border="1" align = "right">                            
        <tr bgcolor="#C0BDBD">
            <th style="width:20px;" align="center" >No.</th>  
            <th style="width:200px;" align="center"><b>CONCEPTO DE PAGO</b></th>
            <th align="center"><b>RECUPERACIÓN</b></th>
            <th align="center"><b>GASTOS DE ADMON.</b></th>
            <th align="center"><b>MONTO POR PAGAR</b></th>
            <th align="center"><b>DEVOLS</b></th>
            <th align="center"><b>AMORTIZACION DE ANTICIPO</b></th>
            <th align="center"><b>MONTO PAGADO</b></th>
            <th align="center"><b>MONTO ACUMULADO</b></th>
            <th align="center"><b>SALDO</b></th>
        </tr>
        ';
 
$tabla_contenido2='';
                $sql = "SELECT * FROM mandantes_abonos WHERE idmandante = ".$idmandante." and idcolonia = ".$idcolonia." and idmunicipio = ".$idmunicipio." and cancelado=0 ORDER BY id ASC";
                 
                $rc= $conexion -> query($sql);               
                $cont=0;
                $recu = 0;
                $gastos = 0;
                $monPagar = 0;
                $devols = 0;
                $amorAnticipo = 0;
                $montoPagado = 0;
                $vuelta = 0;
            
                while($r = $rc -> fetch_array()){
                    $vuelta++;
                    $cont=$cont+1;
                    $recu+=$r['recuperacion'];
                    $gastos+=$r['gastos']; 
                    $monPagar+=$r['montopagar'];
                    $devols+=$r['devols'];
                    $amorAnticipo+=$r['amortizacion_anticipo'];
                    $montoPagado+=$r['monto_pagado'];
                    $fech = strtotime($r['periodopago']);
                    $tabla_contenido2= $tabla_contenido2.'<tr><td style="width:20px;" align="center">'.$vuelta.'</td>';
                    if($r['tipoMov']==3){
                        if($r['periodopago']==$r['periodopago2']){
                            //echo $dias[date('w')]." ".date('d')." de ".$meses[date('n')-1]. " del ".date('Y') ;
                            //$inicio = strftime("%A, %d de %B del %Y", strtotime($fecha));
                            $tabla_contenido2= $tabla_contenido2.'<td style="width:200px;" align="center">'.fechaesp($r['periodopago']).'</td>';
                        }else{
                            $fech = strtotime($r['periodopago']);
                            $fech2 = strtotime($r['periodopago2']);
                            $tabla_contenido2= $tabla_contenido2.'<td style="width:200px;" align="center">'.fechaesp($r['periodopago'])." A ".fechaesp($r['periodopago2']).'</td>';
                        }
                       
                    }else{
                         $tabla_contenido2= $tabla_contenido2.'<td style="font-size:8px; width:200px;" align="center">'.tipoMovMandante($r['tipoMov']).' CON FECHA '.fechaespcompleta($r['periodopago']).' '.strtoupper($r['numero_oficio']).'</td>';
                    }
                    
                    //$tabla_contenido2= $tabla_contenido2.'<td align="center">'.date("M",$fech).'-'.date("y",$fech).'</td>';
                    $tabla_contenido2= $tabla_contenido2."<td>$".number_format($r['recuperacion'], 2, '.', ',')."</td>";
                    $tabla_contenido2= $tabla_contenido2."<td>$".number_format($r['gastos'], 2, '.', ',')."</td>";
                    $tabla_contenido2= $tabla_contenido2."<td>$".number_format($r['montopagar'], 2, '.', ',')."</td>";
                    $tabla_contenido2= $tabla_contenido2."<td>$".number_format($r['devols'], 2, '.', ',')."</td>";
                    $tabla_contenido2= $tabla_contenido2."<td>$".number_format($r['amortizacion_anticipo'], 2, '.', ',')."</td>";
                    $tabla_contenido2= $tabla_contenido2."<td>$".number_format($r['monto_pagado'], 2, '.', ',')."</td>";
                    $tabla_contenido2= $tabla_contenido2."<td>$".number_format($r['monto_acumulado'], 2, '.', ',')."</td>";
                    $tabla_contenido2= $tabla_contenido2."<td>$".number_format($r['saldo'], 2, '.', ',')."</td></tr>";
                }

                $tabla_contenido2 = $tabla_contenido2. '<tr bgcolor="#E3E1E1">
                        <td></td>
                        <td style="width:200px;" align="center">TOTALES</td>
                        <td>$'.number_format($recu, 2, '.', ',').'</td>
                        <td>$'.number_format($gastos, 2, '.', ',').'</td>
                        <td>$'.number_format($monPagar, 2, '.', ',').'</td>
                        <td>$'.number_format($devols, 2, '.', ',').'</td>
                        <td>$'.number_format($amorAnticipo, 2, '.', ',').'</td>
                        <td>$'.number_format($montoPagado, 2, '.', ',').'</td>
                        <td></td>
                        <td></td>
                    </tr>';
$tabla_contenido2=$tabla_contenido2."</table>";
$resta=0;
if($totalapagar > 0){
    $resta = $totalapagar - $montoPagado;
}else{
    $resta = 0;
}

$tablaultima = '<br><br><table align = "left" bgcolor="#E4E0E0">
                    <tr>
                        <td style="width:20px;" border="0" bgcolor="#FFF"></td>
                        <td style="width:200px;" border="0" bgcolor="#FFF"></td>
                        <td border="1" colspan="5">
                        MONTO PAGADO AL MANDANTE
                        </td>
                        <td border="1" align = "right" >
                        $'.number_format($montoPagado, 2, '.', ',').'
                        </td>
                        <td border="0" bgcolor="#FFF"></td>
                        <td border="0" bgcolor="#FFF"></td>
                    </tr>
                    <tr>
                        <td style="width:20px;" border="0" bgcolor="#FFF"></td>
                        <td style="width:200px;" border="0" bgcolor="#FFF"></td>
                        <td border="1" colspan="5">
                        IMPORTE PENDIENTE DE PAGO AL MANDANTE 
                        </td>
                        <td border="1" align = "right" >
                        $'.number_format($resta, 2, '.', ',').'
                        </td>
                        <td border="0" bgcolor="#FFF"></td>
                        <td border="0" bgcolor="#FFF"></td>

                    </tr>
                    
                    </table>
                    <br><br><br>
                    
                    
                    ';


if(observacionesMandante($idmandante, $idcolonia, $idmunicipio)<>''){
    $tablaultima = $tablaultima.'<label FONT SIZE=1>Observaciones: '.observacionesMandante($idmandante, $idcolonia, $idmunicipio).'</label>';
}

$t=$t.$tabla_contenido2;
$t=$t.$tablaultima;


$tabla=$titulosyfecha.$tablaDatos.$t;
//echo $tabla;

$orientacion='L';
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetKeywords('Reporte ITAVU');
$pdf->SetHeaderData('pdf_logo.jpg', '40','', '');
$link = "https://plataformaitavu.tamaulipas.gob.mx/itavu/mandantes_pago.php?idmandante=".$idmandante."&idcolonia=".$idcolonia."&idmunicipio=".$idmunicipio."";
//$link = "www.localhost:81\mandantes_pago.php?idmandante=".$idmandante."&idcolonia=".$idcolonia."&idmunicipio=".$idmunicipio."";

//$img = file_get_contents('C:\pdz-server\htdocs\img\regreso.png');
$img = file_get_contents('img/regreso.png');
//$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, '', '');
// set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
// set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
//$pdf->SetFooterData("Impreso: ".fecha_larga($fecha).", ".hora12($hora)." por ".nitavu_nombre($nitavu),array(0, 64, 0),array(0, 64, 128));
$pdf->SetFooterData('c', 0, 'xd', 'hola');
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
$pdf->AddPage('L', 'LEGAL');
//$pdf->Cell(0, 0, 'A4 LANDSCAPE', 1, 1, 'C');
//$pdf->AddPage($orientacion); //en la tabla de reporte L o P
$html = $tabla;
//echo $html; aqui escribe el contenido de la consulta
$pdf->Image('@' . $img, 300, 0, '', '', '', $link, 'rigth', false, 0, '', false, false, 0, false, false, false);
    
$pdf->writeHTML($html, true, false, true, false, '');

// reset pointer to the last page
$pdf->lastPage();
//Close and output PDF document}
ob_end_clean();
$pdf->Output('reporte.pdf', 'I');
MiToken_Close($nitavu, $HayToken); //Cierro el Token

}

?>