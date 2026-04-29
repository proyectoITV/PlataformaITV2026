<?php
require("config.php");
require_once('seguridad.php');
require_once('lib/funciones.php');
require_once('pdf/tcpdf.php');
require_once('lib/flor_funciones.php');
require_once('lib/yes_funciones.php');
//error_reporting(0);

$id = $_GET['id'];
$idmandante = $_GET['idmandante'];
$idcolonia = $_GET['idcolonia'];
$idmunicipio = $_GET['idmunicipio'];

$url = $_POST['url1'];
//echo "URL:".$url;
$comentarios='';


$date = $_GET['fecha'];

//obtener fecha
$sql = "Select periodopago, periodopago2 from mandantes_abonos where id= ".$id."";
//echo $sql;
$rc = $conexion -> query($sql);
while($f = $rc -> fetch_array())
{
    $fecha = $f['periodopago'];
    $fecha2 = $f['periodopago2'];
}
//echo $fecha.'-'.$fecha2;
if($fecha2 == $fecha){
//echo 'ENTRO AQUI';
    $fechaComoEntero = strtotime($fecha);
    $monthNum  = date("n", $fechaComoEntero);
    $meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
    $fecha = strtoupper($meses[$monthNum-1]).'-'.date('Y', $fechaComoEntero);
    $fecha2 = "";
    
}else{
    $fechaComoEntero = strtotime($fecha);
    $monthNum  = date("n", $fechaComoEntero);
    $meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
    $fecha = date('d',$fechaComoEntero).'-'.strtoupper($meses[$monthNum-1]).'-'.date('Y', $fechaComoEntero);

    $fechaComoEntero2 = strtotime($fecha2);
    $monthNum2  = date("n", $fechaComoEntero2);
    $meses2 = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
    $fecha2 = date('d',$fechaComoEntero2).'-'.strtoupper($meses2[$monthNum2-1]).'-'.date('Y', $fechaComoEntero2);
}
//echo '<script>history.pushState(null, "", "mandantes_pago.php?idmandante='.$idmandante.'&idcolonia='.$idcolonia.'&idmunicipio='.$idmunicipio.'");</script>';

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
        
            background-color: #484848; 
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
            box-shadow: 0 3px #E3D79F; 
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
    DEPARTAMENTO DE CRÉDITO';
    if($fecha2<>""){
        
        $titulosyfecha=$titulosyfecha.'<BR><BR>RELACIÓN CORRESPONDIENTE DEL <b>'.$fecha.'</b> AL <b>'.$fecha2.'</b>';
    }else{
        $titulosyfecha=$titulosyfecha.'<BR><BR>RELACIÓN CORRESPONDIENTE AL MES DE <b>'.$fecha.'</b>';
    }
    $titulosyfecha=$titulosyfecha.'<BR><B>PROGRAMA '.buscarProgramaMandante($idmandante, $idcolonia, $idmunicipio).'</B>
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
   // echo $sql;
    $suma=0;
    $suma1 = 0;
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
                            $comentarios=$f['numero_oficio'];
                            $recuperacion = $recuperacion.'</td>
                        <td style="width:65%;">';
                        if($fecha2 <> ""){
                            $recuperacion = $recuperacion.'Recuperación correspondiente al '.$fecha.' al '.$fecha2.' emitidos por el sistema';
                        }else{
                            $recuperacion = $recuperacion.'Recuperación correspondiente al mes de '.$fecha.' emitidos por el sistema';
                        }
                        $recuperacion = $recuperacion.'</td>
                        <td style="width:15%" align="rigth">$
                            '.number_format($f['recuperacion_sistema'], 2, '.', ',').'
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
                                    '.number_format($f['descuento_nomina'], 2, '.', ',').'
                        </td>
                    </tr>';
                    if(ExisteAbonoExtraMandante($id)=='TRUE')
                    {
                        $sql = "select * from mandantes_abonosext inner join cat_conceptos_mandabonos on cat_conceptos_mandabonos.Id= mandantes_abonosext.idconcepto where idabono=$id and idconcepto=1";
                        //echo $sql.'<br>';
                        $rr= $conexion -> query($sql);
                        if ($rr->num_rows>0){
                            while($ff = $rr -> fetch_array()){
                    $recuperacion = $recuperacion.'  <tr>
                    <td style="width:20%;" align="center">';
                        if($ff['mas_menos']==1){
                        $recuperacion = $recuperacion.'(más)';
                        $suma= $suma + $ff['importe'];
                        }else{
                            $recuperacion = $recuperacion.'(menos)'; 
                            $suma= $suma - $ff['importe'];
                        }
                    $recuperacion = $recuperacion.'</td>
                    <td style="width:65%;">
                        Recuperación de Descuento por nómina
                    </td>
                    <td style="width:15%" align="rigth">$
                                '.number_format($ff['importe'], 2, '.', ',').'
                    </td>
                </tr>';
                    }
                    }
                    }
                    $recuperacion=$recuperacion.'<tr>
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
                                    '.number_format($f['enganche_ahorro'], 2, '.', ',').'
                        </td>
                    </tr>';
                    if(ExisteAbonoExtraMandante($id)=='TRUE')
                    {
                        $sql = "select * from mandantes_abonosext inner join cat_conceptos_mandabonos on cat_conceptos_mandabonos.Id= mandantes_abonosext.idconcepto where idabono=$id and idconcepto=2";
                        //echo $sql.'<br>';
                        $rr= $conexion -> query($sql);
                        if ($rr->num_rows>0){
                            while($ff = $rr -> fetch_array()){
                    $recuperacion = $recuperacion.'  <tr>
                    <td style="width:20%;" align="center">';
                        if($ff['mas_menos']==1){
                        $recuperacion = $recuperacion.'(más)';
                        $suma= $suma + $ff['importe'];
                        }else{
                            $recuperacion = $recuperacion.'(menos)'; 
                            $suma= $suma - $ff['importe'];
                        }
                    $recuperacion = $recuperacion.'</td>
                    <td style="width:65%;">
                    Recuperación por enganche de ahorro
                    </td>
                    <td style="width:15%" align="rigth">$
                                '.number_format($ff['importe'], 2, '.', ',').'
                    </td>
                </tr>';
                    }
                    }
                    }
                    $recuperacion = $recuperacion.'<tr>
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
                                    '.number_format($f['transferencia'], 2, '.', ',').'
                        </td>
                    </tr>';
                    if(ExisteAbonoExtraMandante($id)=='TRUE')
                    {
                        $sql = "select * from mandantes_abonosext inner join cat_conceptos_mandabonos on cat_conceptos_mandabonos.Id= mandantes_abonosext.idconcepto where idabono=$id and idconcepto=3";
                        //echo $sql.'<br>';
                        $rr= $conexion -> query($sql);
                        if ($rr->num_rows>0){
                            while($ff = $rr -> fetch_array()){
                    $recuperacion = $recuperacion.'  <tr>
                    <td style="width:20%;" align="center">';
                        if($ff['mas_menos']==1){
                        $recuperacion = $recuperacion.'(más)';
                        $suma= $suma + $ff['importe'];
                        }else{
                            $recuperacion = $recuperacion.'(menos)'; 
                            $suma= $suma - $ff['importe'];
                        }
                    $recuperacion = $recuperacion.'</td>
                    <td style="width:65%;">
                    Recuperación por transferencia
                    </td>
                    <td style="width:15%" align="rigth">$
                                '.number_format($ff['importe'], 2, '.', ',').'
                    </td>
                </tr>';
                    }
                    }
                    }
                    $recuperacion = $recuperacion.'<tr>
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
                                    '.number_format($f['pagos_universales'], 2, '.', ',').'
                        </td>
                    </tr>';
                    if(ExisteAbonoExtraMandante($id)=='TRUE')
                    {
                        $sql = "select * from mandantes_abonosext inner join cat_conceptos_mandabonos on cat_conceptos_mandabonos.Id= mandantes_abonosext.idconcepto where idabono=$id and idconcepto=4";
                       // echo $sql.'<br>';
                        $rr= $conexion -> query($sql);
                        if ($rr->num_rows>0){
                            while($ff = $rr -> fetch_array()){
                    $recuperacion = $recuperacion.'  <tr>
                    <td style="width:20%;" align="center">';
                        if($ff['mas_menos']==1){
                        $recuperacion = $recuperacion.'(más)';
                        $suma= $suma + $ff['importe'];
                        }else{
                            $recuperacion = $recuperacion.'(menos)'; 
                            $suma= $suma - $ff['importe'];
                        }
                    $recuperacion = $recuperacion.'</td>
                    <td style="width:65%;">
                    Recuperación por pagos universales
                    </td>
                    <td style="width:15%" align="rigth">$
                                '.number_format($ff['importe'], 2, '.', ',').'
                    </td>
                </tr>';
                    }
                    }
                    }
                    $recuperacion = $recuperacion.' <tr>
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
                                    '.number_format($f['escritura'], 2, '.', ',').'
                        </td>
                    </tr>';
                    if(ExisteAbonoExtraMandante($id)=='TRUE')
                    {
                        $sql = "select * from mandantes_abonosext inner join cat_conceptos_mandabonos on cat_conceptos_mandabonos.Id= mandantes_abonosext.idconcepto where idabono=$id and idconcepto=5";
                        //echo $sql.'<br>';
                        $rr= $conexion -> query($sql);
                        if ($rr->num_rows>0){
                            while($ff = $rr -> fetch_array()){
                    $recuperacion = $recuperacion.'  <tr>
                    <td style="width:20%;" align="center">';
                        if($ff['mas_menos']==1){
                        $recuperacion = $recuperacion.'(más)';
                        $suma= $suma + $ff['importe'];
                        }else{
                            $recuperacion = $recuperacion.'(menos)'; 
                            $suma= $suma - $ff['importe'];
                        }
                    $recuperacion = $recuperacion.'</td>
                    <td style="width:65%;">
                    Recuperación por concepto de escritura
                    </td>
                    <td style="width:15%" align="rigth">$
                                '.number_format($ff['importe'], 2, '.', ',').'
                    </td>
                </tr>';
                    }
                    }
                    }
                    $recuperacion = $recuperacion.'<tr>
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
                                    '.number_format($f['derechos'], 2, '.', ',').'
                        </td>
                    </tr>';
                    if(ExisteAbonoExtraMandante($id)=='TRUE')
                    {
                        $sql = "select * from mandantes_abonosext inner join cat_conceptos_mandabonos on cat_conceptos_mandabonos.Id= mandantes_abonosext.idconcepto where idabono=$id and idconcepto=6";
                        //echo $sql.'<br>';
                        $rr= $conexion -> query($sql);
                        if ($rr->num_rows>0){
                            while($ff = $rr -> fetch_array()){
                    $recuperacion = $recuperacion.'  <tr>
                    <td style="width:20%;" align="center">';
                        if($ff['mas_menos']==1){
                        $recuperacion = $recuperacion.'(más)';
                        $suma= $suma + $ff['importe'];
                        }else{
                            $recuperacion = $recuperacion.'(menos)'; 
                            $suma= $suma - $ff['importe'];
                        }
                    $recuperacion = $recuperacion.'</td>
                    <td style="width:65%;">
                    Recuperación por concepto de cesión de derechos
                    </td>
                    <td style="width:15%" align="rigth">$
                                '.number_format($ff['importe'], 2, '.', ',').'
                    </td>
                </tr>';
                    }
                    }
                    }
                    $recuperacion = $recuperacion.'<tr>
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
                                    '.number_format($f['pago_derechos'], 2, '.', ',').'
                        </td>
                    </tr>';
                    if(ExisteAbonoExtraMandante($id)=='TRUE')
                    {
                        $sql = "select * from mandantes_abonosext inner join cat_conceptos_mandabonos on cat_conceptos_mandabonos.Id= mandantes_abonosext.idconcepto where idabono=$id and idconcepto=7";
                        //echo $sql.'<br>';
                        $rr= $conexion -> query($sql);
                        //echo $rr->num_rows;
                        if ($rr->num_rows>0){
                            while($ff = $rr -> fetch_array()){
                               // echo 'entro';
                    $recuperacion = $recuperacion.'  <tr>
                    <td style="width:20%;" align="center">';
                        if($ff['mas_menos']==1){
                        $recuperacion = $recuperacion.'(más)';
                        $suma= $suma + $ff['importe'];
                        }else{
                            $recuperacion = $recuperacion.'(menos)'; 
                            $suma= $suma - $ff['importe'];
                        }
                    $recuperacion = $recuperacion.'</td>
                    <td style="width:65%;">
                    Recuperación por pago de derechos
                    </td>
                    <td style="width:15%" align="rigth">$
                                '.number_format($ff['importe'], 2, '.', ',').'
                    </td>
                </tr>';
                    }
                    }
                   
                    }
                    $recuperacion = $recuperacion.'<tr>
                    <td style="width:20%;" align="center">';
                        if($f['signo8']==1){
                            $recuperacion = $recuperacion.'(más)';
                            $suma= $suma + $f['oxxo'];
                        }else{
                            $recuperacion = $recuperacion.'(menos)'; 
                            $suma= $suma - $f['oxxo'];
                        }
$recuperacion = $recuperacion.'
                    </td>
                    <td style="width:65%;">
                        Recuperación por pago en oxxo
                    </td>
                    <td style="width:15%" align="rigth">$
                                '.number_format($f['oxxo'], 2, '.', ',').'
                    </td>
                </tr>';
                if(ExisteAbonoExtraMandante($id)=='TRUE')
                {
                    $sql = "select * from mandantes_abonosext inner join cat_conceptos_mandabonos on cat_conceptos_mandabonos.Id= mandantes_abonosext.idconcepto where idabono=$id and idconcepto=8";
                    //echo $sql.'<br>';
                    $rr= $conexion -> query($sql);
                    if ($rr->num_rows>0){
                        while($ff = $rr -> fetch_array()){
                $recuperacion = $recuperacion.'  <tr style=" border: 1px solid black;">
                <td style="width:20%;" align="center">';
                    if($ff['mas_menos']==1){
                    $recuperacion = $recuperacion.'(más)';
                    $suma= $suma + $ff['importe'];
                    }else{
                        $recuperacion = $recuperacion.'(menos)'; 
                        $suma= $suma - $ff['importe'];
                    }
                $recuperacion = $recuperacion.'</td>
                <td style="width:65%;">
                Recuperación por pago en oxxo
                </td>
                <td style="width:15%" align="rigth">$
                            '.number_format($ff['importe'], 2, '.', ',').'
                </td>
            </tr>';
                }
                }
                }

                $recuperacion = $recuperacion.'<tr>
                <td style="width:20%;" align="center">';
                    if($f['signo9']==1){
                        $recuperacion = $recuperacion.'(más)';
                        $suma= $suma + $f['pagootros'];
                    }else{
                        $recuperacion = $recuperacion.'(menos)'; 
                        $suma= $suma - $f['pagootros'];
                    }

                    //echo $f['pagootros'];
$recuperacion = $recuperacion.'
                </td>
                <td style="width:65%;">
                Recuperación otros
                </td>
                <td style="width:15%" align="rigth">$
                            '.number_format($f['pagootros'], 2, '.', ',').'
                </td>
            </tr>';
            if(ExisteAbonoExtraMandante($id)=='TRUE')
            {
                $sql = "select * from mandantes_abonosext inner join cat_conceptos_mandabonos on cat_conceptos_mandabonos.Id= mandantes_abonosext.idconcepto where idabono=$id and idconcepto=9";
                //echo $sql.'<br>';
                $rr= $conexion -> query($sql);
                if ($rr->num_rows>0){
                    while($ff = $rr -> fetch_array()){
            $recuperacion = $recuperacion.'  <tr style=" border: 1px solid black;">
            <td style="width:20%;" align="center">';
                if($ff['mas_menos']==1){
                $recuperacion = $recuperacion.'(más)';
                $suma= $suma + $ff['importe'];
                }else{
                    $recuperacion = $recuperacion.'(menos)'; 
                    $suma= $suma - $ff['importe'];
                }
            $recuperacion = $recuperacion.'</td>
            <td style="width:65%;">
            Recuperación otros
            </td>
            <td style="width:15%" align="rigth">$
                        '.number_format($ff['importe'], 2, '.', ',').'
            </td>
        </tr>';
            }
            }
            }


                    $suma= $suma; //+ $f['centavo'];

    /*<tr>
                        <td style="width:20%;"></td>
                        <td style="width:65%;" align="right">Ajuste al centavo  </td>
                        <td style="width:15%" align="rigth">    $'.$f['centavo'].'</td>
                    </tr>  */
    $recuperacion = $recuperacion.'
                      
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
                   // $res = $suma1 - $f['gastos'];   //antes de la modificacion 
                   //$res2 = $res - $f['amortizacion_anticipo'] - $f['devols']; /antes de la modificacion
                    $res = $suma1 - $f['amortizacion_anticipo'];                  
                    $res2 = $res - $f['gastos']- $f['gastosesc']- $f['devols'];
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
                    //$res = $suma - $f['gastos'];   //antes de la modificacion
                    //$res2 = $res - $f['amortizacion_anticipo'] - $f['devols'];
                    
                    $res = $suma - $f['amortizacion_anticipo'];                     
                    $res2 = $res - $f['gastos']- $f['gastosesc']- $f['devols'];
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
                
                 //$'.number_format($res, 2, '.', ',').' total ingresos antes
    $tablaDatos = $tablaDatos.'
                    <tr>
                        
                        <td style="width:20%;"></td>
                        <td style="width:20%;">
                        <b>(-)  '.$f['pamorAnt'].'%</b>
                        </td>
                        <td style="width:45%;" align = "right">
                            <b>AMORTIZACIÓN DE ANTICIPO</b>
                        </td>
                        <td style="width:15%; border-bottom: 1px solid #000;" align = "right">
                            $'.number_format($f['amortizacion_anticipo'], 2, '.', ',').'
                        </td>
                        
                    </tr>

                    <tr>
                        
                    <td style="width:20%;"></td>
                    <td style="width:20%;">
                    </td>
                    <td style="width:45%;" align = "right">
                        <b>SUB-TOTAL</b>
                    </td>
                    <td style="width:15%;  " align = "right">
                        $'.number_format($res, 2, '.', ',').'
                    </td>
                   


                </tr>

                    <tr>
                        <td style="width:20%;"></td>
                        <td style="width:20%;">
                        <b>(-)  '.$f['pgastos'].'%</b>
                        </td>
                        <td style="width:45%; " align="right">
                            <b>GASTOS DE ADMINISTRACIÓN</b>
                        </td>
                        <td style="width:15%;" align="rigth">
                            $'.number_format($f['gastos'], 2, '.', ',').'
                        </td>
                        
                    </tr>

                      <tr>
                        <td style="width:20%;"></td>
                        <td style="width:20%;">
                        <b>(-)  '.$f['pgastosesc'].'%</b>
                        </td>
                        <td style="width:45%; " align="right">
                            <b>GASTOS DE ESCRITURACION</b>
                        </td>
                        <td style="width:15%;" align="rigth">
                            $'.number_format($f['gastosesc'], 2, '.', ',').'
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
                            $'.number_format($f['devols'], 2, '.', ',').'
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




        //         $tablaDatos = $tablaDatos.'<tr>
        //         <td style="width:20%;"></td>
        //         <td style="width:20%;">
        //         <b>(-)  '.$f['pgastos'].'%</b>
        //         </td>
        //         <td style="width:45%; " align="right">
        //             <b>GASTOS DE ADMINISTRACIÓN</b>
        //         </td>
        //         <td style="width:15%; border-bottom: 1px solid #000;" align="rigth">
        //             $'.number_format($f['gastos'], 2, '.', ',').'
        //         </td>
                
        //     </tr>
        //     <tr>
                
        //         <td style="width:20%;"></td>
        //         <td style="width:20%;">
        //         </td>
        //         <td style="width:45%;" align = "right">
        //             <b>SUB-TOTAL</b>
        //         </td>
        //         <td style="width:15%;" align = "right">
        //             $'.number_format($res, 2, '.', ',').'
        //         </td>
                
        //     </tr>
        //     <tr>
                
        //         <td style="width:20%;"></td>
        //         <td style="width:20%;">
        //         <b>(-)  '.$f['pamorAnt'].'%</b>
        //         </td>
        //         <td style="width:45%;" align = "right">
        //             <b>AMORTIZACIÓN DE ANTICIPO</b>
        //         </td>
        //         <td style="width:15%;" align = "right">
        //             $'.number_format($f['amortizacion_anticipo'], 2, '.', ',').'
        //         </td>
                
        //     </tr>
        //     <tr>
                
        //         <td style="width:20%;"></td>
        //         <td style="width:20%;">
        //         <b>(-)  '.$f['pdevols'].'%</b>
        //         </td>
        //         <td style="width:45%;" align = "right">
        //             <b>DEVOLUCIONES</b>
        //         </td>
        //         <td style="width:15%;" align = "right">
        //             $'.number_format($f['devols'], 2, '.', ',').'
        //         </td>
                
        //     </tr>
        //     <tr>
                
        //         <td style="width:20%;"></td>
        //         <td style="width:20%;">
        //         </td>
        //         <td style="width:45%;" align = "right">
        //             <b>TOTAL NETO A PAGAR</b>
        //         </td>
        //         <td style="width:15%; background-color:#A09F9F;" align = "right">
        //             $'.number_format($res2, 2, '.', ',').'
        //         </td>
                
        //     </tr>
        // </table>
        // ';
        $tablaDatos2="";
                if (strlen($comentarios)>1)
    {
                $tablaDatos2 = $tablaDatos2.'
                   <br><br><br><br><br><p align = "center" ><b>COMENTARIOS</b></p><br><p align = "center" >'.$comentarios.'</p>';}

        }
    }else{

        /*<tr>
            <td style="width:15%;"></td>
            <td style="width:65%;" align="right">Ajuste al centavo  </td>
            <td style="width:15%" align="left">    $</td>
        </tr>*/
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
            <td style="width:15%;" align="center">
                (menos)
            </td>
            <td style="width:65%;">
                Recuperación por pago en oxxo
            </td>
            <td style="width:15%" align="left">
                $
            </td>
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


    // $tablaDatos = '
    // <p align = "center" ><b> CÁLCULO PARA PAGO AL MANDANTE</b></p>
    // <table>
    //     <tr>
    //         <td>
    //         </td>
    //         <td align = "right" >
    //             TOTAL INGRESOS
    //         </td>
    //         <td>
    //             $
    //         </td>
    //     </tr>
    //     <tr>
    //         <td>
    //         </td>
    //         <td align = "right">
    //             GASTOS DE ADMINISTRACIÓN
    //         </td>
    //         <td>
    //             $
    //         </td>
    //     </tr>
    //     <tr>
    //         <td>
    //         </td>
    //         <td align = "right">
    //             SUB-TOTAL
    //         </td>
    //         <td>
    //             $
    //         </td>
    //     </tr>
    //     <tr>
    //         <td>
    //         </td>
    //         <td align = "right">
    //             AMORTIZACIÓN DE ANTICIPO
    //         </td>
    //         <td>
    //             $
    //         </td>
    //     </tr>
    //     <tr>
    //         <td>
    //         </td>
    //         <td align = "right">
    //             DEVOLUCIONES
    //         </td>
    //         <td>
    //             $
    //         </td>
    //     </tr>
    //     <tr>
    //         <td>
    //         </td>
    //         <td align = "right">
    //             TOTAL NETO A PAGAR
    //         </td>
    //         <td>
    //             $
    //         </td>
    //     </tr>
    // </table>
    // ';



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
                GASTOS DE ESCRITURACION
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

  /*  $firmas='
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
    
    ';*/

    $tabla=$titulosyfecha.$recuperacion.$tablaDatos.$tablaDatos2;;//.'<br><br><br><br><br>'.$firmas;
    //echo $tabla;
    $orientacion='P';
    $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
    // set document information
    $pdf->SetCreator(PDF_CREATOR);
    $pdf->SetKeywords('Reporte ITAVU');
    //$link = "www.localhost:81\mandantes_pago.php?idmandante=".$idmandante."&idcolonia=".$idcolonia."&idmunicipio=".$idmunicipio."";
    $pdf->SetHeaderData('pdf_logo.jpg', '40','');
    $link = "https://plataformaitavu.tamaulipas.gob.mx/itavu/mandantes_pago.php?idmandante=".$idmandante."&idcolonia=".$idcolonia."&idmunicipio=".$idmunicipio."";
    $link = $url."?idmandante=".$idmandante."&idcolonia=".$idcolonia."&idmunicipio=".$idmunicipio."";
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

   //echo $tabla;
    
        // reset pointer to the last page
     $pdf->lastPage();
     //Close and output PDF document}
    ob_end_clean();
     $pdf->Output('reporte.pdf', 'I');
    

    MiToken_Close($nitavu, $HayToken); //Cierro el Token

}

?>
