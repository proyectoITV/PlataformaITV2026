<?php
require("unica/config.php");
require_once('unica/seguridad.php');
require_once('unica/funciones.php');
require_once('pdf/tcpdf.php');
require('unica/flor_funciones.php');


$id = $_GET['id'];
$idmandante = $_GET['idmandante'];
$idcolonia = $_GET['idcolonia'];
$idmunicipio = $_GET['idmunicipio'];

$date = $_GET['fecha'];
$fechaComoEntero = strtotime($date);
$meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
$fecha = strtoupper($meses[date('n')-1]).'-'.date('Y', $fechaComoEntero );
echo '<script>history.pushState(null, "", "mandantes_pago.php?idmandante='.$idmandante.'&idcolonia='.$idcolonia.'&idmunicipio='.$idmunicipio.'");</script>';

//header ('Location: mandantes_pago.php?idmandante='.$idmandante.'&idcolonia='.$idcolonia.'&idmunicipio='.$idmunicipio.'');
$pagina_anterior="mandantes_pago.php?idmandante=".$idmandante."&idcolonia=".$idcolonia."&idmunicipio=".$idmunicipio;
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
    historia($nitavu, 'Veo la orden de pago del id mandante '.$idmandante.', id colonia: '.$idcolonia.' y el id municipio: '.$idmunicipio.' .');
   
    $titulosyfecha='
    <br>
    <p align = "center"  style="text-align:center; font-size:10px;">
    GOBIERNO DEL ESTADO DE TAMAULIPAS<br>
    INSTITUTO TAMAULIPECO DE VIVIENDA Y URBANISMO<br>
    DIRECCIÓN DE ADMINISTRACIÓN Y FINANZAS<br>
    DEPARTAMENTO DE CRÉDITO

    <BR><BR>RELACIÓN CORRESPONDIENTE AL MES DE <b>'.$fecha.'</b>

    <BR><B>PROGRAMA '.buscarProgramaMandante($idmandante, $idcolonia, $idmunicipio).'</B>
    </p>

    <table >
        <tr>
            <td style="width:100%;">
                <table>
                    <tr><td style="width:25%;">MUNICIPIO:</td><td><b>'.strtoupper(nombreMunicipio($idmunicipio)).'</b></td></tr>
                    <tr><td style="width:25%;">COLONIA:</td><td><b>'. strtoupper(nombreColonia($idmunicipio,$idcolonia)).'</b></td></tr>
                    <tr><td style="width:25%;">MANDANTE: </td><td><b>'. strtoupper(nombreMandante($idmunicipio,$idcolonia,$idmandante)).'</b></td></tr>
                </table>
            </td>
        </tr>
    </table>
    ';
    $recuperacion = "";
    $tablaDatos = "";
    $sql = "SELECT * FROM mandantes_abonos WHERE id=".$id."";
    $suma=0;
    $r= $conexion -> query($sql);
    if ($r->num_rows>0){
        while($f = $r -> fetch_array()){
            $recuperacion = $recuperacion.'
                <br><br>
                <table style="border-top: 2px solid #000; width:100%;" >
                    <tr>
                        <td colspan="3" align="center"><b><br>RECUPERACIÓN </b></td>
                    </tr>
                    <tr>
                        <td style="width:20%;" align="center">';
                            $suma=$f['recuperacion_sistema'];

    $recuperacion = $recuperacion.'</td>
                        <td style="width:65%;">
                            Recuperación correspondiente al mes de '.$fecha.' emitidos por el sistema
                        </td>
                        <td style="width:15%" align="rigth">$
                            '.$f['recuperacion_sistema'].'
                        </td>
                    </tr>
                    <tr>
                        <td style="width:20%;" align="center">';
                            if($f['signo1']==1){
                            $recuperacion = $recuperacion.'(más)';
                            $suma= $suma + $f['descuento_nomina'];
                            }else{
                                $recuperacion = $recuperacion.'(menos)'; 
                                $suma= $suma - $f['descuento_nomina'];
                            }
    $recuperacion = $recuperacion.'</td>
                        <td style="width:65%;">
                            Recuperación de Descuento por nómina
                        </td>
                        <td style="width:15%" align="rigth">$
                                    '.$f['descuento_nomina'].'
                        </td>
                    </tr>
                    <tr>
                        <td style="width:20%;" align="center">';
                            
                            if($f['signo2']==1){
                            $recuperacion = $recuperacion.'(más)';
                            $suma= $suma + $f['enganche_ahorro'];
                            }else{
                                $recuperacion = $recuperacion.'(menos)'; 
                                $suma= $suma - $f['enganche_ahorro'];
                            }
    $recuperacion = $recuperacion.'
                        </td>
                        <td style="width:65%;">
                            Recuperación por enganche de ahorro
                        </td>
                        <td style="width:15%" align="rigth">$
                                    '.$f['enganche_ahorro'].'
                        </td>
                    </tr>
                    <tr>
                        <td style="width:20%;" align="center">';
                            if($f['signo3']==1){
                            $recuperacion = $recuperacion.'(más)';
                            $suma= $suma + $f['transferencia'];
                            }else{
                                $recuperacion = $recuperacion.'(menos)'; 
                            $suma= $suma - $f['transferencia'];
                            }
    $recuperacion = $recuperacion.'
                        </td>
                        <td style="width:65%;">
                            Recuperación por transferencia
                        </td>
                        <td style="width:15%" align="rigth">$
                                    '.$f['transferencia'].'
                        </td>
                    </tr>
                    <tr>
                        <td style="width:20%;" align="center">';
                            if($f['signo4']==1){
                            $recuperacion = $recuperacion.'(más)';
                            $suma= $suma + $f['pagos_universales'];
                            }else{
                                $recuperacion = $recuperacion.'(menos)';
                                $suma= $suma - $f['pagos_universales']; 
                            }
    $recuperacion = $recuperacion.'
                        </td>
                        <td style="width:65%;">
                            Recuperación por pagos universales
                        </td>
                        <td style="width:15%" align="rigth">$
                                    '.$f['pagos_universales'].'
                        </td>
                    </tr>
                    <tr>
                        <td style="width:20%;" align="center">';
                            if($f['signo5']==1){
                            $recuperacion = $recuperacion.'(más)';
                            $suma= $suma + $f['escritura'];
                            }else{
                                $recuperacion = $recuperacion.'(menos)'; 
                                $suma= $suma - $f['escritura'];
                            }
    $recuperacion = $recuperacion.'
                        </td>
                        <td style="width:65%;">
                            Recuperación por concepto de escritura
                        </td>
                        <td style="width:15%" align="rigth">$
                                    '.$f['escritura'].'
                        </td>
                    </tr>
                    <tr>
                        <td style="width:20%;" align="center">';
                            if($f['signo6']==1){
                            $recuperacion = $recuperacion.'(más)';
                            $suma= $suma + $f['derechos'];
                            }else{
                                $recuperacion = $recuperacion.'(menos)';
                                $suma= $suma - $f['derechos']; 
                            }
    $recuperacion = $recuperacion.'
                        </td>
                        <td style="width:65%;">
                            Recuperación por concepto de cesión de derechos
                        </td>
                        <td style="width:15%" align="rigth">$
                                    '.$f['derechos'].'
                        </td>
                    </tr>
                    <tr>
                        <td style="width:20%;" align="center">';
                            if($f['signo7']==1){
                            $recuperacion = $recuperacion.'(más)';
                            $suma= $suma + $f['pago_derechos'];
                            }else{
                                $recuperacion = $recuperacion.'(menos)'; 
                                $suma= $suma - $f['pago_derechos'];
                            }
    $recuperacion = $recuperacion.'
                        </td>
                        <td style="width:65%;">
                            Recuperación por pago de derechos
                        </td>
                        <td style="width:15%" align="rigth">$
                                    '.$f['pago_derechos'].'
                        </td>
                    </tr>';
                    $suma= $suma + $f['centavo'];
    $recuperacion = $recuperacion.'
                    <tr>
                        <td style="width:20%;"></td>
                        <td style="width:65%;" align="right">Ajuste al centavo  </td>
                        <td style="width:15%" align="rigth">    $'.$f['centavo'].'</td>
                    </tr>    
                    <tr>
                        <td style="width:20%;"></td>
                        <td style="width:65%;" align="right"><b>Total ingresos  </b></td>
                        <td style="width:15%; background-color:#A09F9F;" align="rigth">$'.number_format($suma, 2, '.', ',').'</td>
                    </tr>';
                    if($idmunicipio == 2){
                        $suma1 = 0;
                        $incremento = $suma * 0.16;
                        $suma1 = $suma -$incremento;
    $recuperacion = $recuperacion.' 
                    <tr>
                        <td style="width:20%;" align="center">(-)16%</td>
                        <td style="width:65%;" align="right">Incremento en el precio de venta de lotes  </td>
                        <td style="width:15%; border-bottom: 1px solid #000;" align="rigth">     $'.number_format($incremento, 2, '.', ',').'</td>
                    </tr>';
                    }
                    if($suma1){
    $recuperacion = $recuperacion.' 
                    <tr>
                        <td style="width:20%;"></td>
                        <td style="width:65%;" align="right">Total recuperación (base para pago al mandante)  </td>
                        <td style="width:15%" align="rigth">    $'.number_format($suma1, 2, '.', ',').'</td>
                    </tr>
                </table>
                ';
                    }else{
                    $recuperacion = $recuperacion.' 
                    <tr>
                        <td style="width:20%;"></td>
                        <td style="width:65%;" align="right">Total recuperación (base para pago al mandante)  </td>
                        <td style="width:15%" align="rigth">    $'.number_format($suma, 2, '.', ',').'</td>
                    </tr>
                </table>

                ';  
                    }


    $tablaDatos = $tablaDatos.'
                <br><br><br><br><br><p align = "center" ><b> CÁLCULO PARA PAGO AL MANDANTE</b></p>
                <table>';
                if($suma1){
                    $res = 0;
                    $res2 = 0;
                    $res = $suma1 - $f['gastos'];
                    $res2 = $res - $f['amortizacion_anticipo'] - $f['devols'];
    $tablaDatos = $tablaDatos.'  
                    <tr>
                        <td style="width:20%;"></td>
                        <td style="width:20%;">
                        </td>
                        <td style="width:45%;" align="right">
                            <b>TOTAL INGRESOS</b>
                        </td>
                        <td style="width:15%" align="rigth">
                            $'.number_format($suma1, 2, '.', ',').'
                        </td>
                    </tr>';
                }else{
                    $res = $suma - $f['gastos'];
                    $res2 = $res - $f['amortizacion_anticipo'] - $f['devols'];
    $tablaDatos = $tablaDatos.'  
                    <tr>
                        <td style="width:20%;"></td>
                        <td style="width:20%;"></td>
                        <td style="width:45%;" align="right">
                            <b>TOTAL INGRESOS</b>
                        </td>
                        <td style="width:15%;" align="rigth">
                            $'.number_format($suma, 2, '.', ',').'
                        </td>
                    </tr>';
                }
                
    $tablaDatos = $tablaDatos.'<tr>
                        <td style="width:20%;"></td>
                        <td style="width:20%;">
                        <b>(-)  '.$f['pgastos'].'%</b>
                        </td>
                        <td style="width:45%; " align="right">
                            <b>GASTOS DE ADMINISTRACIÓN</b>
                        </td>
                        <td style="width:15%; border-bottom: 1px solid #000;" align="rigth">
                            $'.$f['gastos'].'
                        </td>
                        
                    </tr>
                    <tr>
                        
                        <td style="width:20%;"></td>
                        <td style="width:20%;">
                        </td>
                        <td style="width:45%;" align = "right">
                            <b>SUB-TOTAL</b>
                        </td>
                        <td style="width:15%;" align = "right">
                            $'.$res.'
                        </td>
                        
                    </tr>
                    <tr>
                        
                        <td style="width:20%;"></td>
                        <td style="width:20%;">
                        <b>(-)  '.$f['pamorAnt'].'%</b>
                        </td>
                        <td style="width:45%;" align = "right">
                            <b>AMORTIZACIÓN DE ANTICIPO</b>
                        </td>
                        <td style="width:15%;" align = "right">
                            $'.$f['amortizacion_anticipo'].'
                        </td>
                        
                    </tr>
                    <tr>
                        
                        <td style="width:20%;"></td>
                        <td style="width:20%;">
                        <b>(-)  '.$f['pdevols'].'%</b>
                        </td>
                        <td style="width:45%;" align = "right">
                            <b>DEVOLUCIONES</b>
                        </td>
                        <td style="width:15%;" align = "right">
                            $'.$f['devols'].'
                        </td>
                        
                    </tr>
                    <tr>
                        
                        <td style="width:20%;"></td>
                        <td style="width:20%;">
                        </td>
                        <td style="width:45%;" align = "right">
                            <b>TOTAL NETO A PAGAR</b>
                        </td>
                        <td style="width:15%; background-color:#A09F9F;" align = "right">
                            $'.number_format($res2, 2, '.', ',').'
                        </td>
                        
                    </tr>
                </table>
                ';

        }
    }else{
        $recuperacion = '
    <br><br>
    <table style="border-top: 2px solid #000; width:100%;" >
        <tr>
            <td colspan="3" align="center"><b><br>RECUPERACIÓN </b></td>
        </tr>
        <tr>
            <td style="width:15%;" align="center">
                (mas)
            </td>
            <td style="width:65%;">
                Recuperación de Descuento por nómina
            </td>
            <td style="width:15%" align="left">
                $
            </td>
        </tr>
        <tr>
            <td style="width:15%;" align="center">
                (mas)
            </td>
            <td style="width:65%;">
                Recuperación por enganche de ahorro
            </td>
            <td style="width:15%" align="left">
                $
            </td>
        </tr>
        <tr>
            <td style="width:15%;" align="center">
                (mas)
            </td>
            <td style="width:65%;">
                Recuperación por transferencia
            </td>
            <td style="width:15%" align="left">
                $
            </td>
        </tr>
        <tr>
            <td style="width:15%;" align="center">
                (mas)
            </td>
            <td style="width:65%;">
                Recuperación por pagos universales
            </td>
            <td style="width:15%" align="left">
                $
            </td>
        </tr>
        <tr>
            <td style="width:15%;" align="center">
                (menos)
            </td>
            <td style="width:65%;">
                Recuperación por concepto de escritura
            </td>
            <td style="width:15%" align="left">
                $
            </td>
        </tr>
        <tr>
            <td style="width:15%;" align="center">
                (menos)
            </td>
            <td style="width:65%;">
                Recuperación por concepto de cesión de derechos
            </td>
            <td style="width:15%" align="left">
                $
            </td>
        </tr>
        <tr>
            <td style="width:15%;" align="center">
                (menos)
            </td>
            <td style="width:65%;">
                Recuperación por pago de derechos
            </td>
            <td style="width:15%" align="left">
                $
            </td>
        </tr>
        <tr>
            <td style="width:15%;"></td>
            <td style="width:65%;" align="right">Ajuste al centavo  </td>
            <td style="width:15%" align="left">    $</td>
        </tr>
        <tr>
            <td style="width:15%;"></td>
            <td style="width:65%;" align="right"><b>Total ingresos  </b></td>
            <td style="width:15%" align="left">    $</td>
        </tr>
        <tr>
            <td style="width:15%;" align="center">(-)</td>
            <td style="width:65%;" align="right">Incremento en el precio de venta de lotes  </td>
            <td style="width:15% border-bottom: 1px solid #000;" align="left">     $</td>
        </tr>
        <tr>
            <td style="width:15%;"></td>
            <td style="width:65%;" align="right">Total recuperación (base para pago al mandante)  </td>
            <td style="width:15%" align="left">    $</td>
        </tr>
    </table>

    ';


    $tablaDatos = '
    <p align = "center" ><b> CÁLCULO PARA PAGO AL MANDANTE</b></p>
    <table>
        <tr>
            <td>
            </td>
            <td align = "right" >
                TOTAL INGRESOS
            </td>
            <td>
                $
            </td>
        </tr>
        <tr>
            <td>
            </td>
            <td align = "right">
                GASTOS DE ADMINISTRACIÓN
            </td>
            <td>
                $
            </td>
        </tr>
        <tr>
            <td>
            </td>
            <td align = "right">
                SUB-TOTAL
            </td>
            <td>
                $
            </td>
        </tr>
        <tr>
            <td>
            </td>
            <td align = "right">
                AMORTIZACIÓN DE ANTICIPO
            </td>
            <td>
                $
            </td>
        </tr>
        <tr>
            <td>
            </td>
            <td align = "right">
                DEVOLUCIONES
            </td>
            <td>
                $
            </td>
        </tr>
        <tr>
            <td>
            </td>
            <td align = "right">
                TOTAL NETO A PAGAR
            </td>
            <td>
                $
            </td>
        </tr>
    </table>
    ';

    }

    $firmas='
    <br><br><br><br><br><br>
    
    <table align = "center">
        <tr>
            <td>ELABORÓ</td>
            <td>AUTORIZÓ</td>
        </tr>
        <tr>
            <td ></td>
            <td ></td>
        </tr>
        <tr>
            <td ></td>
            <td ></td>
        </tr>
        <tr>
            
            <td style="border-top: 1px solid #000"> MARÍA TRINIDAD BALDERAS VILLANUEVA<BR>AUXILIAR ADMINISTRATIVO</td>
            <td style="width:10%;"></td>
            <td style="border-top: 1px solid #000"> LIC. PERLA DENISSE GONZÁLEZ ROBLES <BR> JEFE DEL DEPARTAMENTO DE CRÉDITO</td>
        </tr>
    </table>
    
    ';

    $tabla=$titulosyfecha.$recuperacion.$tablaDatos.'<br><br><br><br><br>'.$firmas;
    //echo $tabla;
    $orientacion='P';
    $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
    // set document information
    $pdf->SetCreator(PDF_CREATOR);
    $pdf->SetKeywords('Reporte ITAVU');
    //$link = "www.localhost:81\mandantes_pago.php?idmandante=".$idmandante."&idcolonia=".$idcolonia."&idmunicipio=".$idmunicipio."";
    $pdf->SetHeaderData('pdf_logo.jpg', '40','');
    $link = "https://plataformaitavu.tamaulipas.gob.mx/itavu/mandantes_pago.php?idmandante=".$idmandante."&idcolonia=".$idcolonia."&idmunicipio=".$idmunicipio."";

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
    $pdf->AddPage($orientacion); //en la tabla de reporte L o P
    
    $html = $tabla;
    $pdf->Image('@' . $img, 170, 0, '', '', '', $link, 'rigth', false, 0, '', false, false, 0, false, false, false);
    $pdf->writeHTML($html, true, false, true, false, '');
    
    /////////// Informacion de quien imprimio el formato

    if($orientacion == 'P'){
    
        // reset pointer to the last page
        $pdf->lastPage();
        //Close and output PDF document}
        ob_end_clean();
        $pdf->Output('reporte.pdf', 'I');
    }

    MiToken_Close($nitavu, $HayToken); //Cierro el Token

}

?>