<?php


ob_start();
require("config.php");
require_once('seguridad.php');
require_once('lib/funciones.php');
require_once('pdf/tcpdf.php');
require('lib/flor_funciones.php');
require('lib/yes_funciones.php');

//echo 'algo';
$NumContrato = $_GET['NumContrato'];
$NumMinistracion =  $_GET['NumMinistracion'];
$Monto = $_GET['Monto'];
$cantidad = number_format((float)$Monto,2,'.',',');
$MontoLetra = number_words($Monto,"pesos","y","centavos");//MONTO DEL CREDITO LETRA 
$IdDelegacion = $_GET['IdDelegacion'];
$IdPrograma = $_GET['IdPrograma'];
$Folio = $_GET['Folio'];
$Digito=$_GET['qr'];
$FechaEmision = $_GET['FechaEmision'];
$CasaComercial = $_GET['CasaComercial'];
$PaqueteMat  = $_GET['PaqueteMat'];
$NomProveedor = $_GET['NomProveedor'];
$firmaDirector = $_GET['firmaDire'];
$IdSolicitante = buscarIdSolicitante($IdPrograma, $IdDelegacion, $Folio);
$NombreBeneficiario = nombreBeneficiarioVivienda($IdSolicitante);

echo 'NumContrato'.$NumContrato.'<br>';
echo $NumMinistracion.'<br>';
echo $Monto.'<br>';
echo $cantidad.'<br>';
echo $MontoLetra.'<br>';
echo $IdDelegacion.'<br>';
echo $IdPrograma.'<br>';
echo $Folio.'<br>';
echo $Digito.'<br>';
echo $FechaEmision.'<br>';
echo $CasaComercial.'<br>';
echo 'FirmaDirector. '.$firmaDirector.'<br>';
echo 'proveedor '.$NomProveedor.'<br>';
$DateTime = new DateTime($FechaEmision);
$Fecha = $DateTime->format('d/m/Y');


//Firmas
if($firmaDirector  == 1 ){
    $Puesto = "DIRECCION GENERAL";
    $Quien = "LIC. DANIEL SAMPAYO SANCHEZ";
}else{
    $Puesto = "DELEGACION ".nombreDelegacionVivienda($IdDelegacion);
    $Quien = Delegado($IdDelegacion);
}

$dias = array("Domingo","Lunes","Martes","Miercoles","Jueves","Viernes","Sábado");
$meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
 
$codigoQR=GenerarQR($Digito);
 //SE GENERA EL CODIGO QR
$codesDir = "tmp/CodigosQR/"; //Carpeta donde se almacenaran los QR  

//GENERAMOS NOTRAS DEPENDIENDO DEL PROGRAMA
$Notas = "";
if($IdPrograma == 248){
    $Notas ='<table align="left" style="font-size:9px;" width="100%">
    <tr >
        <td width="520">
            <table><tr><td>NOTA 1: VIGENCIA 15 DÍAS</td>
            </tr>
            <tr>
                <td>NOTA 2 : EL BENEFICIARIO ACORDARÁ CON EL PROVEEDOR AUTORIZADO, LOS MATERIALES, LA ENTREGA DE LOS MISMOS. LA ENTREGA DE LOS MATERIALES PUEDE SER AL MOMENTO O BIEN ACORDAR SU ENVÍO A DOMICILIO.</td>
            </tr>
            <tr>
                <td>NOTA 3 : PARA HACER EFECTIVO ESTE VALE ES REQUISITO INDISPENSABLE QUE ESTÉ ACOMPAÑADO CON COPIA DE IDENTIFICACIÓN OFICIAL CON FOTOGRAFIA DEL BENEFICIARIO Y DE LA PERSONA AUTORIZADA A RECIBIR EL MATERIAL EN CASO DE QUE SEA DISTINTA DEL BENEFICIARIO.</td>
            </tr></table>
        </td>';
        if($IdPrograma != 249){
            $Notas = $Notas.'<td width="100"> <img  src="'.$codesDir.$codigoQR.'" /></td>';
        }
        $Notas = $Notas.'</tr>
</table>';

}else if($IdPrograma == 249){
    $Notas ='<table align="left" style="font-size:9px;" width="100%">
    <tr >
        <td width="520">
            <table><tr><td>NOTA 1: VIGENCIA 15 DÍAS</td>
            </tr>
            <tr>
                <td></td>
            </tr>
            <tr>
                <td>NOTA 2 : PARA HACER EFECTIVO ESTE VALE ES REQUISITO INDISPENSABLE QUE ESTÉ ACOMPAÑADO CON COPIA DE IDENTIFICACIÓN OFICIAL CON FOTOGRAFIA DEL BENEFICIARIO Y DE LA PERSONA AUTORIZADA A RECIBIR EL MATERIAL EN CASO DE QUE SEA DISTINTA DEL BENEFICIARIO.</td>
            </tr></table>
        </td>';
        if($IdPrograma != 249){
            $Notas = $Notas.'<td width="100"> <img  src="'.$codesDir.$codigoQR.'" /></td>';
        }
        $Notas = $Notas.'</tr>
</table>';
}else if($IdPrograma == 250){
    $Notas ='<table align="left" style="font-size:9px;" width="100%">
    <tr >
        <td width="520">
            <table><tr><td></td>
            </tr>
            <tr>
                <td></td>
            </tr>
            <tr>
                <td>NOTA  : PARA HACER EFECTIVO ESTE VALE ES REQUISITO INDISPENSABLE QUE ESTÉ ACOMPAÑADO CON COPIA DE IDENTIFICACIÓN OFICIAL CON FOTOGRAFIA DEL BENEFICIARIO Y DE LA PERSONA AUTORIZADA A RECIBIR EL APOYO EN CASO DE QUE SEA DISTINTA DEL BENEFICIARIO.</td>
            </tr></table>
        </td>';
        if($IdPrograma != 249){
            $Notas = $Notas.'<td width="100"> <img  src="'.$codesDir.$codigoQR.'" /></td>';
        }
        $Notas = $Notas.'</tr>
</table>';
}else{
    $Notas ='<table align="left" style="font-size:9px;" width="100%">
    <tr >
        <td width="520">
            <table><tr><td>NOTA 1: LA FECHA LIMITE PARA CANJEAR ESTE VALE SERA EL '.$fecha.'</td>
            </tr>
            <tr>
                <td>NOTA 2: EL BENEFICIARI ACORDARÁ CON EL PROVEEDOR DE SU ELECCIÓN (SOLO PROVEEDORES AUTORIZADOS), LOS MATERIALES, ASÍ COMO LAS MEJORES CONDICIONES DE PRECIO Y ENTREGA DE LOS MISMOS. LA ENTREGA DE LOS MATERIALES PUEDE SER AL MOMENTO O BIEN ACORDAR SU ENVIO A DOMICILIO.</td>
            </tr>
            <tr>
                <td>NOTA 3: PARA HACER EFECTIVO ESTE VALE ES REQUISITO INDISPENSABLEQUE ESTÉ ACOMPAÑADO CON COPIA DE IDENTIFICACION OFICIAL CON FOTOGRAFÍA DEL BENEFICIARIO Y DE LA PERSONA AUTORIZADA A RECIBIR EL MATERIAL EN CASO DE QUE SEA DISTINTA DEL BENEFICIARIO.</td>
            </tr></table>
        </td>';
        if($IdPrograma != 249){
            $Notas = $Notas.'<td width="100"> <img  src="'.$codesDir.$codigoQR.'" /></td>';
        }
        $Notas = $Notas.'</tr>
</table>';
}
$t = "";
$t = $t.'<table width="100%">';
    $t = $t."<tr>";
    ///COLUMNA VOLTEADA
        $t = $t.'<td width="40" >';
            $t = $t.'<img src="img/textoRotado.jpg" width="40" height="350"/>';
            //$t = $t.'<p  style="writing-mode: vertical-lr; transform: rotate(180deg);">ESTE DOCUMENTO SOLO SE ENTREGARÁ AL PROVEEDOR AL MOMENTO DE RECIBIR EL MATERIAL</p>';
        $t = $t."</td>";

        //SEGUNDA COLUMNA
        $t = $t.'<td width="600" align="center">';
            $t = $t.'<table>';
                $t = $t.'<tr>';
                    //SEGUNDA COLUMNA
                    $t = $t.'<td width="400" align="center">';
                        $t = $t."<b>INSTITUTO TAMAULIPECO DE VIVIENDA Y URBANISMO</b>".'<br>';
                        $t = $t."S148 PROGRAMA DE VIVIENDA".'<br>';
                        $t = $t.nombreProgramaVivienda($IdPrograma).'<br>';
                        $t = $t."<table>";
                            $t = $t."<tr>";
                                $t = $t."<td>";
                                    $t  = $t.'-'.$NumMinistracion.'-';
                                $t = $t."</td>";
                                $t = $t."<td>";
                                    $t  = $t.'<p style="font-size:10px;"><b>VALE NORMATIVO DE MATERIALES</b></p>';
                                $t = $t."</td>";
                                $t = $t."<td>";
                                    $t  = $t.'<p style="font-size:8px;"><b>ORIGINAL BENEFICIARIO</b></p>';
                                $t = $t."</td>";
                            $t = $t."</tr>";
                            $t = $t."<tr>";
                                $t = $t."<td>";
                                    $t  = $t.'No. de contrato ';
                                $t = $t."</td>";
                                $t = $t."<td>";
                                    $t  = $t.$NumContrato;
                                $t = $t."</td>";
                                $t = $t."<td>";
                                    //$t  = $t.'codigo de barras';
                                $t = $t."</td>";
                            $t = $t."</tr>";
                        $t = $t."</table>";
                        $t = $t."<table>";
                            $t = $t."<tr>";
                                $t = $t."<td>";
                                    $t  = $t.'Entreguese por este vale a el(la) beneficiario(a):';
                                $t = $t."</td>";
                                $t = $t."<td>";
                                    $t  = $t.$NombreBeneficiario;
                                $t = $t."</td>";
                            $t = $t."</tr>";
                            $t = $t."<tr>";
                                $t = $t.'<td colspan="2">';
                                   // $t = $t.'<img src="img/duplicado.jpg" width="250" height="30"/>';
                                $t = $t."</td>";
                            $t = $t."</tr>";
                            $t = $t."<tr>";
                                $t = $t.'<td>';
                                    if($IdPrograma == 249){
                                        $t  = $t.'<b>'.$PaqueteMat.'</b>';
                                    }else{
                                        $t  = $t.'<b>'.strtoupper($MontoLetra).' 00/100 M. N.</b>';
                                    }
                                $t = $t."</td>";
                                $t = $t."<td></td>";
                            $t = $t."</tr>";
                            $t = $t."<tr>";
                                $t = $t.'<td colspan="2">';
                                    
                                $t = $t."</td>";
                            $t = $t."</tr>";
                            $t = $t."<tr>";
                                $t = $t.'<td style="font-size:8px;">';
                                    $t  = $t.'EL MATERIAL SERÁ DEFINIDO POR EL BENEFICIARIO APEGANDOSE A LA LISTA AUTORIZADA';
                                $t = $t."</td>";
                                $t = $t."<td></td>";
                            $t = $t."</tr>";
                            $t = $t."<tr>";
                                $t = $t.'<td colspan="2">';
                                    $t  = $t.'ENTREGO MATERIAL:';
                                $t = $t."</td>";
                            $t = $t."</tr>";
                            $t = $t."<tr>";
                                $t = $t.'<td colspan="2">';
                                    
                                $t = $t."</td>";
                            $t = $t."</tr>";
                            $t = $t."<tr>";
                                $t = $t.'<td colspan="2">';
                                if($NomProveedor == 1){
                                    $t  = $t.$CasaComercial;
                                }
                                $t = $t."</td>";
                            $t = $t."</tr>";
                            $t = $t."<tr>";
                                $t = $t.'<td colspan="2">';
                                    
                                $t = $t."</td>";
                            $t = $t."</tr>";
                            $t = $t."<tr>";
                                $t = $t.'<td colspan="2">';
                                    $t  = $t.'Nombre del empleado y sello de la empresa.';
                                $t = $t."</td>";
                            $t = $t."</tr>";
                        $t = $t."</table>";
                    $t = $t."</td>";


                    //TERCER COLUMNA
                    $t = $t.'<td width="200">';
                        
                        $t = $t."<table>";
                            $t = $t."<tr>";
                                $t = $t.'<td align="right">';
                                    $t = $t.'<img src="img/logo_small.jpg" width="150" height="30"/>';
                                $t = $t."</td>";
                            $t = $t."</tr>";
                            $t = $t."<tr>";
                                $t = $t.'<td>';
                                $t = $t."</td>";
                            $t = $t."</tr>";
                            $t = $t."<tr>";
                                $t = $t.'<td align="right">';
                                    $t  = $t.'IVU-RP-PO-05-RE-06';
                                $t = $t."</td>";
                            $t = $t."</tr>";
                            $t = $t."<tr>";
                                $t = $t."<td>";
                                    $t  = $t.'LUGAR Y FECHA DE EXPEDICION';
                                $t = $t."</td>";
                            $t = $t."</tr>";
                        
                    
                            $t = $t."<tr>";
                                $t = $t.'<td align="center">';
                                    $t  = $t.'CD. '.nombreDelegacionVivienda($IdDelegacion).', A  '.$Fecha;
                                $t = $t."</td>";
                            $t = $t."</tr>";
                            $t = $t."<tr>";
                                $t = $t."<td>";
                                    if($IdPrograma != 249){
                                        $t  = $t.'Material por la cantidad de: $<b>'.$cantidad.'</b>';
                                    }
                                $t = $t."</td>";
                            $t = $t."</tr>";
                            $t = $t."<tr>";
                                $t = $t.'<td >';
                                    $t  = $t.'AUTORIZO';
                                $t = $t."</td>";
                            $t = $t."</tr>";
                            $t = $t."<tr>";
                                $t = $t.'<td>';
                                $t = $t."</td>";
                            $t = $t."</tr>";
                            $t = $t."<tr>";
                                $t = $t.'<td style="border-bottom: 0.2px solid #000;">';
                                $t = $t."</td>";
                            $t = $t."</tr>";
                            $t = $t."<tr>";
                                $t = $t.'<td >';
                                    $t  = $t.strtoupper($Quien).'<BR>';
                                    $t  = $t.strtoupper($Puesto);
                                $t = $t."</td>";
                            $t = $t."</tr>";
                            $t = $t."<tr>";
                                $t = $t.'<td >';
                                $t = $t."</td>";
                            $t = $t."</tr>";
                            $t = $t."<tr>";
                                $t = $t.'<td border = "1" >';
                                    $t = $t.'<table align="center" style="font-size:8px;">
                                        <tr>
                                            <td >RECIBI MATERIAL COMPLETO Y A MI ENTERA SATISFACCION</td>
                                        </tr>
                                        <tr>
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <td>NOMBRE Y FIRMA DEL BENEFICIARIO O PERSONA AUTORIZADA</td>
                                        </tr>
                                        <tr>
                                            <td align="left">FECHA DE ENTREGA:</td>
                                        </tr>
                                </table>';
                                $t = $t."</td>";
                            $t = $t."</tr>";
                        $t = $t."</table>";
                    $t = $t."</td>";
                $t = $t."</tr>";
            $t = $t."</table><br><br>";
           $t = $t.$Notas;
        $t = $t.'</td>';
    $t = $t."</tr>";
    $t = $t."<tr>";
        $t = $t.'<td colspan="2">';
        $t = $t."</td>";
    $t = $t."</tr>";
    $t = $t."<tr>";
        $t = $t.'<td colspan="2">';
           
            $t = $t.'<br>';
            $t = $t.'<table style="font-size:7px; border-bottom: 0.2px solid #000;" align="center">
                <tr>
                    <td>Este programa es de carácter público, no es patrocinado ni promovido por partido político alguno y sus recursos provienen de los impuestos que pagan todos los contribuyentes. Está prohibido el uso de éste programa con fines políticos, electorales, de lucro y otros distintos a los establecidos. Quien haga uso indebido de los recursos de éste programa deberá ser denunciado y sancionado de acuerdo con la ley aplicable y ante la autoridad competente.</td>
                </tr>
            </table>';
        $t = $t."</td>";
    $t = $t."</tr>";
$t = $t."</table>";

//SEGUNDA TABLA
$t = $t."<BR><BR>";
$t = $t.'<table width="100%">';
    $t = $t."<tr>";
    ///COLUMNA VOLTEADA
        $t = $t.'<td width="40" >';
           // $t = $t.'<p  style="writing-mode: vertical-lr; transform: rotate(180deg);">ESTE DOCUMENTO SOLO SE ENTREGARÁ AL PROVEEDOR AL MOMENTO DE RECIBIR EL MATERIAL</p>';
        $t = $t."</td>";

        //SEGUNDA COLUMNA
        $t = $t.'<td width="600" align="center">';
            $t = $t.'<table>';
                $t = $t.'<tr>';
                    //SEGUNDA COLUMNA
                    $t = $t.'<td width="400" align="center">';
                        $t = $t."<b>INSTITUTO TAMAULIPECO DE VIVIENDA Y URBANISMO</b>".'<br>';
                        //$t = $t."S148 PROGRAMA DE VIVIENDA".'<br>';
                        $t = $t.nombreProgramaVivienda($IdPrograma).'<br>';
                        $t = $t."<table>";
                            $t = $t."<tr>";
                                $t = $t."<td>";
                                    $t  = $t.'-'.$NumMinistracion.'-';
                                $t = $t."</td>";
                                $t = $t."<td>";
                                    $t  = $t.'<p style="font-size:10px;"><b>VALE NORMATIVO DE MATERIALES</b></p>';
                                $t = $t."</td>";
                                $t = $t."<td>";
                                    $t  = $t.'<p style="font-size:8px;"><b>ORIGINAL BENEFICIARIO</b></p>';
                                $t = $t."</td>";
                            $t = $t."</tr>";
                            $t = $t."<tr>";
                                $t = $t."<td>";
                                    $t  = $t.'No. de contrato ';
                                $t = $t."</td>";
                                $t = $t."<td>";
                                    $t  = $t.$NumContrato;
                                $t = $t."</td>";
                                $t = $t."<td>";
                                   // $t  = $t.'codigo de barras';
                                $t = $t."</td>";
                            $t = $t."</tr>";
                        $t = $t."</table>";
                        $t = $t."<table>";
                            $t = $t."<tr>";
                                $t = $t."<td>";
                                    $t  = $t.'Entreguese por este vale a el(la) beneficiario(a):';
                                $t = $t."</td>";
                                $t = $t."<td>";
                                    $t  = $t.$NombreBeneficiario;
                                $t = $t."</td>";
                            $t = $t."</tr>";
                            $t = $t."<tr>";
                                $t = $t.'<td colspan="2">';
                                    //$t = $t.'<img src="img/duplicado.jpg" width="250" height="30"/>';
                                $t = $t."</td>";
                            $t = $t."</tr>";
                            $t = $t."<tr>";
                                $t = $t.'<td >';
                                if($IdPrograma == 249){
                                    $t  = $t.'<b>'.$PaqueteMat.'</b>';
                                }else{
                                    $t  = $t.'<b>'.strtoupper($MontoLetra).' 00/100 M. N.</b>';
                                }
                                $t = $t."</td>";
                                $t = $t."<td></td>";
                            $t = $t."</tr>";
                            $t = $t."<tr>";
                                $t = $t.'<td colspan="2">';
                                    
                                $t = $t."</td>";
                            $t = $t."</tr>";
                            $t = $t."<tr>";
                                $t = $t.'<td  style="font-size:8px;">';
                                    $t  = $t.'EL MATERIAL SERÁ DEFINIDO POR EL BENEFICIARIO APEGANDOSE A LA LISTA AUTORIZADA';
                                $t = $t."</td>";
                                $t = $t."<td></td>";
                            $t = $t."</tr>";
                            $t = $t."<tr>";
                                $t = $t.'<td colspan="2">';
                                    $t  = $t.'ENTREGO MATERIAL:';
                                $t = $t."</td>";
                            $t = $t."</tr>";
                            $t = $t."<tr>";
                                $t = $t.'<td colspan="2">';
                                    
                                $t = $t."</td>";
                            $t = $t."</tr>";
                            $t = $t."<tr>";
                                $t = $t.'<td colspan="2">';
                                if($NomProveedor == 1){
                                    $t  = $t.$CasaComercial;
                                }
                                $t = $t."</td>";
                            $t = $t."</tr>";
                            $t = $t."<tr>";
                                $t = $t.'<td colspan="2">';
                                    
                                $t = $t."</td>";
                            $t = $t."</tr>";
                            $t = $t."<tr>";
                                $t = $t.'<td colspan="2">';
                                    $t  = $t.'Nombre del empleado y sello de la empresa.';
                                $t = $t."</td>";
                            $t = $t."</tr>";
                        $t = $t."</table>";
                    $t = $t."</td>";


                    //TERCER COLUMNA
                    $t = $t.'<td width="200">';
                        $t = $t."<table>";
                            $t = $t."<tr>";
                                $t = $t.'<td align="right">';
                                    $t = $t.'<img src="img/logo_small.jpg" width="150" height="30"/>';
                                $t = $t."</td>";
                            $t = $t."</tr>";
                            $t = $t."<tr>";
                                $t = $t.'<td>';
                                $t = $t."</td>";
                            $t = $t."</tr>";
                            $t = $t."<tr>";
                                $t = $t.'<td align="right">';
                                    $t  = $t.'IVU-RP-PO-05-RE-06';
                                $t = $t."</td>";
                            $t = $t."</tr>";
                            $t = $t."<tr>";
                                $t = $t."<td>";
                                    $t  = $t.'LUGAR Y FECHA DE EXPEDICION';
                                $t = $t."</td>";
                            $t = $t."</tr>";
                        
                    
                            $t = $t."<tr>";
                                $t = $t.'<td align="center">';
                                    $t  = $t.'CD. '.nombreDelegacionVivienda($IdDelegacion).' A  '.$Fecha;
                                $t = $t."</td>";
                            $t = $t."</tr>";
                            $t = $t."<tr>";
                                $t = $t."<td>";
                                if($IdPrograma != 249){
                                    $t  = $t.'Material por la cantidad de: $<b>'.$cantidad.'</b>';
                                }
                                $t = $t."</td>";
                            $t = $t."</tr>";
                            $t = $t."<tr>";
                                $t = $t.'<td >';
                                    $t  = $t.'AUTORIZO';
                                $t = $t."</td>";
                            $t = $t."</tr>";
                            $t = $t."<tr>";
                                $t = $t.'<td style="border-bottom: 0.2px solid #000;">';
                                    
                                $t = $t."</td>";
                            $t = $t."</tr>";
                            $t = $t."<tr>";
                                $t = $t.'<td >';
                                    $t  = $t.strtoupper($Quien).'<BR>';
                                    $t  = $t.strtoupper($Puesto);
                                $t = $t."</td>";
                            $t = $t."</tr>";
                            $t = $t."<tr>";
                                $t = $t.'<td >';
                                $t = $t."</td>";
                            $t = $t."</tr>";
                            $t = $t."<tr>";
                                $t = $t.'<td border = "1" >';
                                    $t = $t.'<table align="center" style="font-size:8px;">
                                        <tr>
                                            <td >RECIBI MATERIAL COMPLETO Y A MI ENTERA SATISFACCION</td>
                                        </tr>
                                        <tr>
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <td>NOMBRE Y FIRMA DEL BENEFICIARIO O PERSONA AUTORIZADA</td>
                                        </tr>
                                        <tr>
                                            <td align="left">FECHA DE ENTREGA:</td>
                                        </tr>
                                </table>';
                                $t = $t."</td>";
                            $t = $t."</tr>";
                        $t = $t."</table>";
                    $t = $t."</td>";
                $t = $t."</tr>";
            $t = $t."</table><br><br>";
            $t = $t.$Notas;
        $t = $t.'</td>';
    $t = $t."</tr>";
    $t = $t."<tr>";
        $t = $t.'<td colspan="2">';
        $t = $t."</td>";
    $t = $t."</tr>";
    $t = $t."<tr>";
        $t = $t.'<td colspan="2">';
           
            $t = $t.'<br>';
            $t = $t.'<table style="font-size:7px; border-bottom: 0.2px solid #000;" align="center">
                <tr>
                    <td>Este programa es de carácter público, no es patrocinado ni promovido por partido político alguno y sus recursos provienen de los impuestos que pagan todos los contribuyentes. Está prohibido el uso de éste programa con fines políticos, electorales, de lucro y otros distintos a los establecidos. Quien haga uso indebido de los recursos de éste programa deberá ser denunciado y sancionado de acuerdo con la ley aplicable y ante la autoridad competente.</td>
                </tr>
            </table>';
        $t = $t."</td>";
    $t = $t."</tr>";
$t = $t."</table>";

//TERCERA TABLA
$t = $t.'<table width="100%" align="center" cellpadding="2px">';
    $t = $t."<tr>";
        $t = $t.'<td align="right">';
            $t = $t.'<img src="img/logo_small.jpg" width="150" height="30"/>';
        $t = $t."</td>";
    $t = $t."</tr>";
    $t = $t."<tr>";
        $t = $t.'<td >';
        $t = $t.'<p><b> El Gobierno del Estado de Tamaulipas</b></p>';
        $t = $t."</td>";
    $t = $t."</tr>";
    $t = $t."<tr>";
        $t = $t.'<td >';
            $t = $t.'<b>Otorga el presente</b>';
        $t = $t."</td>";
    $t = $t."</tr>";
    $t = $t."<tr>";
        $t = $t."<td>";
            $t = $t.'<b>CERTIFICADO DE SUBSIDIO DE LA LINEA DE APOYO</b>';
        $t = $t."</td>";
    $t = $t."</tr>"; 
    $t = $t."<tr>";
        $t = $t.'<td >';
           // $t = $t."S148 PROGRAMA DE VIVIENDA".'<br>';
        $t = $t."</td>";
    $t = $t."</tr>";
    $t = $t."<tr>";
        $t = $t."<td>";
            $t = $t.'<b>'.nombreProgramaVivienda($IdPrograma).'</b>';
        $t = $t."</td>";
    $t = $t."</tr>"; 
    $t = $t."<tr>";
        $t = $t."<td>";
            $t = $t.'<b>'.$NombreBeneficiario.'</b>';
        $t = $t."</td>";
    $t = $t."</tr>"; 
    $t = $t."<tr>";
        $t = $t."<td>";
            if($IdPrograma != 249){
                $t = $t.'<b>Por el importe de $'.$cantidad.' ('.strtoupper($MontoLetra).')</b>';
            }
        $t = $t."</td>";
    $t = $t."</tr>"; 
    $t = $t."<tr>";
        $t = $t."<td>";
            if($IdPrograma == 250){
                $t = $t."Válido por la aplicación de pintura";
            }else{
                $t = $t.'Válido por un paquete de material de construcción, para ser aplicado <BR> en su vivienda, en el municipio de '.nombreDelegacionVivienda($IdDelegacion).', Tamaulipas';
            }
        $t = $t."</td>";
    $t = $t."</tr>"; 
    $t = $t."<tr>";
        $t = $t."<td>";

        $t = $t."</td>";
    $t = $t."</tr>"; 
    $t = $t."<tr>";
        $t = $t."<td>";
            $t = $t.'<table style=" border-bottom: 0.2px solid #000;">';
                $t = $t."<tr>";
                    $t = $t.'<td >';
                        $t = $t.'Fecha emisión: '.$fecha;
                    $t = $t."</td>";
                    $t = $t.'<td >';
                        if($IdPrograma == 248){
                            $t = $t."Vigencia:15 días";
                        }else{
                            $t = $t.'vigencia: 30 días';
                        }
                    $t = $t."</td>";
                    $t = $t.'<td>';
                        $t = $t.'SUBSIDIO No.'.$NumContrato;
                    $t = $t."</td>";
                $t = $t."</tr>";   
            $t = $t.'</table>'; 
        $t = $t."</td>";
    $t = $t."</tr>"; 
$t = $t."</table><br>";


//CUARTA TABLA
$t = $t.'<table width="100%" align="center">';
    $t = $t."<tr>";
        $t = $t.'<td align="CENTER" width="500">';
            $t = $t.'<B>INSTITUTO TAMAULIPECO DE VIVIENDA Y URBANISMO</B>';
        $t = $t."</td>";
        $t = $t.'<td align="left" width="200">';
            $t = $t.'<img src="img/logo_small.jpg" width="150" height="30"/>';
        $t = $t."</td>";
    $t = $t."</tr>";
    $t = $t."<tr>";
        $t = $t.'<td align="CENTER" width="500">';
            $t = $t.nombreProgramaVivienda($IdPrograma);
        $t = $t."</td>";
        $t = $t.'<td>';
        $t = $t."</td>";
    $t = $t."</tr>";
    $t = $t."<tr>";
        $t = $t.'<td align="CENTER" width="500">';
            $t = $t.'<b>FORMATO DE RECEPCION DE VALE</b>';
        $t = $t."</td>";
        $t = $t.'<td>';
        $t = $t."</td>";
    $t = $t."</tr>";
    $t = $t."<tr>";
        $t = $t.'<td align="CENTER" width="500">';
        //if($IdPrograma != 249){
            $t = $t.'Se entrega vale de material a nombre de el(la) C. <b>'.$NombreBeneficiario.'</b>';
        //}else{
          //  $t = $t.'Se entrega vale de material a nombre de el(la) C.';
       // }
        $t = $t."</td>";
        $t = $t.'<td>';
        $t = $t."</td>";
    $t = $t."</tr>"; 

    $t = $t."<tr>";
        $t = $t.'<td align="CENTER" width="500">';
        if($IdPrograma != 249){
            $t = $t.'Por la cantidad de $'.$cantidad.' '.strtoupper($MontoLetra);
        }
           
        $t = $t."</td>";
        $t = $t.'<td>';
        $t = $t."</td>";
    $t = $t."</tr>";
    $t = $t."</table>";
    $t = $t.'<table width="850" align="center">';
        $t = $t."<tr>";
            $t = $t.'<td >';
                $t = $t.'Contrato: '.$NumContrato;
            $t = $t."</td>";
            $t = $t.'<td >';
                $t = $t.'Solicitud '.$Folio;
            $t = $t."</td>";
            $t = $t.'<td>';
                $t = $t.'Fecha de entraga del vale';
            $t = $t."</td>";
            $t = $t.'<td width="10">';
            $t = $t."</td>";
            $t = $t.'<td>';
                $t = $t.'Recibí Vale';
            $t = $t."</td>";
        $t = $t."</tr>";
        $t = $t."<tr>";
            $t = $t.'<td >';
            $t = $t."</td>";
            $t = $t.'<td >';
            $t = $t."</td>";
            $t = $t.'<td style=" border-bottom: 0.2px solid #000;">';
            $t = $t."</td>";
            $t = $t.'<td width="10">';
            $t = $t."</td>";
            $t = $t.'<td style=" border-bottom: 0.2px solid #000;">';
            $t = $t."</td>";
        $t = $t."</tr>";  
        $t = $t."<tr>";
            $t = $t.'<td colspan="5" style="font-size:8px;">';
                $t = $t.'NOTA: ESTE FORMATO ES PARA USO INTERNO Y EXCLUSICO DEL INSTITUTO. PARA ARCHIVAR EN EXPEDIENTE, CARECE DE VALIDEZ DE CANJE.';
            $t = $t."</td>";
        $t = $t."</tr>";   
    $t = $t.'</table>'; 
   

$tabla = $t;
echo $tabla;

// Extend the TCPDF class to create custom Header and Footer
class MYPDF1 extends TCPDF {
    //Page header
    public function Header() {
    }
    // Page footer
    public function Footer() {
    }
  }


$orientacion='L';
$pdf = new MYPDF1(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetKeywords('Reporte ITAVU');


//$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, '', '');
// set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
// set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
//$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
//$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
//$pdf->SetFooterData("Impreso: ".fecha_larga($fecha).", ".hora12($hora)." por ".nitavu_nombre($nitavu),array(0, 64, 0),array(0, 64, 128));
//$pdf->SetFooterData('c', 0, 'xd', 'hola');
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
$pdf->AddPage('P', 'LEGAL');
//$pdf->Cell(0, 0, 'A4 LANDSCAPE', 1, 1, 'C');
//$pdf->AddPage($orientacion); //en la tabla de reporte L o P
$html = $tabla;
//echo $html; //aqui escribe el contenido de la consulta

$pdf->writeHTML($html, true, false, true, false, '');

// reset pointer to the last page
$pdf->lastPage();
//Close and output PDF document}
ob_end_clean();
$pdf->Output('reporte.pdf', 'I');


?>