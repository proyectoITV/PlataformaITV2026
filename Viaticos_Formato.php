<?php
ob_start();
require("config.php");
require_once('seguridad.php');
require_once('lib/funciones.php');
require_once('pdf/tcpdf.php');
require('lib/flor_funciones.php');
require("var_clean.php");
require("viaticos_fun.php");
require('lib/yes_funciones.php');

require_once("vehiculos_fun.php");
$styleqr = array(
    'border' => false,
    'vpadding' => 'auto',
    'hpadding' => 'auto',
    'fgcolor' => array(10,7,0),
    
    'module_width' => 2, // width of a single module in points
    'module_height' => 2 // height of a single module in points
);

//VARIABLES QUE RECIBE
$oficio = "";
$direccion = "";
$departamento = "";
$clavedepto = "";
$adscripcion = "";
$secretaria = "";
$cheque = "";
$defecha = "";
$cantidad = "";
$letracantidad = "";
$cargobanco = "";
$nombre = "";
$numempleado = "";
$rfc = "";
$nivel = "";
$fechaSalida = "";
$fechaRetorno = "";
$lugarComision = "";
$especifiqueComision = "";

$OK = FALSE;
$IdViatico = VarClean($_GET['id']);
//$rfcitavu='ITV820513L21';
$sql = "select * from viaticosfull WHERE IdViatico='".$IdViatico."'";	
// echo $sql;
$r= $conexion -> query($sql);					
if($f = $r -> fetch_array())
{
    // if ($f['Activa']==0){
        $oficio = $f['NOficio'];
        $direccion = nitavu_direccion($f['NEmpleado']);
        $departamento =nitavu_dpto_nombre($f['NEmpleado']);
        $clavedepto = "";
        $adscripcion = nitavu_adscripcion($f['NEmpleado']);
        $secretaria = "INSTITUTO TAMAULIPECO DE VIVIENDA Y URBANISMO";
        $cheque = "";
        $defecha = $f['CapturaFecha'];
        $cantidad = Pesos(viaticos_Total($IdViatico));
        $letracantidad = numtoletras(viaticos_Total($IdViatico));
        $cargobanco = "";
        $nombre = nitavu_nombre($f['NEmpleado']);
        $numempleado = $f['NEmpleado'];
        $rfc = nitavu_rfc($f['NEmpleado']);
        $nivel = nitavu_nivel($f['NEmpleado']);
        $fechaSalida = $f['SalidaFecha'];
        $fechaRetorno = $f['RegresoFecha'];
        $lugarComision =$f['LugarComision'];
        $especifiqueComision = $f['Comision'];
        $NEmpleado = $f['NEmpleado'];
        $txtQR =  $f['Estado']." | IdViatico=".$IdViatico." | ";
        $txtQR .= "FechaSalida=".$f['SalidaFecha']." | ";
        $txtQR .= "NEmpleado=".$f['NEmpleado']." | ";
        $txtQR .= "Lugar=".$f['LugarComision']." | ";
        $txtQR .= "Comision=".$f['Comision']." | ";
        $txtQR .= "Cantidad=".$cantidad." | ";
        $txtQR .= "User=".$nitavu." | ";
        $txtQR .= "Fecha=".$fecha." | ";
        $txtQR .= "Hora=".$hora." | ";
        $Estado = $f['Estado'];


        
        $OK = TRUE;
   
}  else {
    $oficio = "## ERROR # # # # # # ";
    $OK = FALSE;

}



$Himporte1=0;
$Himporte2=530;
$Himporte3=0;
$Hsubtotal=530;

//alimentacion
$Aimporte1=0;
$Aimporte2=460;
$Aimporte3=0;
$Asubtotal=460;

//dias
$dias1=0;
$dias2=2;
$dias3=0;

//totales
$totales1=0;
$totales2=990;
$totales3=0;
$totalesFinal=990;

//transportacion
$transportacion='1';



//datosvehiculo
$nvehiculo='';
$autobus='X';
$particular='';
$marca='';
$modelo='';


$tipo='';
$placas='';
$cilindraje='0';

$kmsrecorridos='646';
$kmsrecorridointerno='0';
$kms='646';

$cuota='A';


$totalRecorrido='';

$preciocombustible='0';

$autobuspeaje='961.00';

$xpu='0';

$cil='9';
$totalTransportacion='961.00';

// $empleado='ANGEL ISRAEL ROSAS MORALES';
$fechaletra='3 DE JUNIO DEL 2021';


$director='SALVADOR GONZALEZ GARZA';
$dirAdmon='EDGAR ELIUD ACEVEDO MEDRANO';
$organoControl='ESTANISLAO HERVERT BAUTISTA';

$t1 = '';$t2 = '';$t3 = '';$t4 = '';

$t1 = $t1. '<table>

   ';
//border="0.2" style="padding:5px;"
$t2 = $t2. '<br><br><br><table border="0.2" style="padding:7px;" ><tr><td>
    <table style="padding:1px;">
        <tr>
            <td width="108px;">OFICIO, COMISION</td>
            <td width="110px;" style="border-bottom: 0.3px solid #000;"><b>'.$oficio.'</b></td>
            <td width="74px;">DIRECCION</td>
            <td width="354px;" style="border-bottom: 0.3px solid #000;"><b>'.$direccion.'</b></td>
        </tr>
        <tr>
            <td width="108px;">DEPARTAMENTO</td>
            <td width="250px;" style="border-bottom: 0.3px solid #000;"><b>'.$departamento.'</b></td>
            <td width="150px;">LUGAR DE ADSCRIPCION</td>
            <td width="138px;" style="border-bottom: 0.3px solid #000;"><b>'.$adscripcion.'</b></td>
        </tr>
      
    </table>
</td></tr></table><br><br>';
//border="0.2" style="padding:5px;"
$t3 = '<table style="border: 0.3px solid black; padding:7px;" ><tr><td>';

$t3.='<table style="padding:1px;">
        <tr>
            <td style="font-size:11px;">
            RECIBI DE <b style="text-decoration:underline;">'.$secretaria.'</b><br>
            DE FECHA <b style="text-decoration:underline;">'.$fecha.'</b> LA CANTIDAD DE <b style="text-decoration:underline;">'.$cantidad.'</b><br>
            <b style="text-decoration:underline;">'.$letracantidad.'</b><br>
            </td>
            <td>
            <table style="padding:2px; font-size:7.5px;width:125%;" >   
    <tr>
    <td colspan="2" style="font-size:8px;"><b>DATOS PARA FACTURACION CFDI 4.0</b></td> 
    <td ></td> 
    </tr>   
    <tr>
    <td style="width:20%">CODIGO POSTAL</td> 
    <td>87020</td> 
    </tr>
    <tr>
    <td style="width:20%">REGIMEN FISCAL</td> 
    <td>603 - Personas Morales con Fines no Lucrativos</td> 
    </tr>
    <tr>
    <td style="width:20%">USO DE CFDI</td> 
    <td>G03 Gastos en General</td> 
    </tr>
    <tr>
    <td style="width:20%">CORREO ELECTRONICO</td> 
    <td>'.nitavu_correo($numempleado).'</td> 
    </tr>
</table>
            </td>
        </tr>
        
    </table>';


    $t3.='<table style="padding:1px;">
        <tr>
            <td style="font-size:11px;">
            EMPLEADO: <b style="text-decoration:underline;">'.nitavu_nombre($f['NEmpleado']).'</b> No. Empleado: <b style="text-decoration:underline;">'.$f['NEmpleado'].'</B><br>
            RFC: <b style="text-decoration:underline;">'.$rfc.'</b> NIVEL <b style="text-decoration:underline;">'.$nivel.'</b><br>
            
            
            </td>
        </tr>
        
    </table>';

$t3.= '
</td></tr></table><br><br>';



$t4 = '<table style="border: 0.3px solid black; padding:7px;" ><tr><td>';
// $Obs=  strtotime($f['SalidaHora']); 
// $Hsalida = gmdate("H:i:s ",$Obs);  
// $Obr=  strtotime($f['RegresoHora']); 
// $Hregreso = gmdate("h:i:s a",$f['RegresoHora']);  

$fecha = date("Y-m-d H:i:s");
//echo $fecha;
$t4.='<table style="padding:1px;">

    <tr>
        <td style="font-size:11px; text-align:center;">Fecha de Salida: <b>'.fecha_larga($fechaSalida)." ".'</b></td>
        <td style="font-size:11px; text-align:center;">Fecha de Regreso:<b>'.fecha_larga($fechaRetorno)." " . '</b></td>
    </tr>
    <tr>
            <td style="font-size:11px; text-align:center;">Tiempo: <b>'.$f['ViaticoDias'].' dias</b></td>
            <td style="font-size:11px; text-align:center;">Lugar:<b>'.$f['LugarComision'].'</b></td>
    </tr>
        
    <tr style="background-color:#bc955c; color:white;">
            <td style="font-size:11px; text-align:center;" colspan="3"><b>'.$f['Comision'].'</b></td>
            
    </tr>
        
    </table>';


   

$t4 .= '
</td></tr></table><br><br>';


$tablaviaticos = '<table style="border: 0px solid black; padding:2px; margin:2px;">';

$tablaviaticos.='<table style="padding:1px;border: 0.3px solid black;">
    <tr  style="font-size:8px; font-weight:bold; background-color:#ab0033;color:white;">
        <td style="width:10%; text-align:center;  text-align: center;">FECHA</td>
        <td style="width:20%; vertical-align:middle;  text-align: center;">TIPO</td>
        <td style="width:20%; vertical-align:middle;  text-align: center;">CANTIDAD</td>
        <td style="width:50%; vertical-align:middle;  text-align: center;">DESCRIPCION</td>        
    </tr>

';
$sqlX = "
select * from viaticosgastosfull where IdViatico='".$IdViatico."' order by Tipo, Fecha ASC
";
$c = 0;
$rX= $conexion -> query($sqlX);
while($fX = $rX -> fetch_array()) {
    if ($c%2==0){
        $tablaviaticos.=' <tr style="background-color:#e7e7e7">';
    }
    else{
        $tablaviaticos.=' <tr style="background-color:white">';
    }
    
    $tablaviaticos.='<td style="width:10%; font-size:7pt; text-align:center;  text-align: center;">'.$fX['Fecha'].'</td>';
    $tablaviaticos.='<td style="width:20%; font-size:7pt; vertical-align:middle;  text-align: center;">'.$fX['Tipo'].'</td>';
    $tablaviaticos.='<td style="width:20%; font-size:7pt; vertical-align:middle;  text-align: center;">'.Pesos($fX['Cantidad']).'</td>';
    $tablaviaticos.='<td style="width:50%; font-size:7pt; vertical-align:middle;  text-align: center;">'.$fX['Descripcion'].'</td>';
    $tablaviaticos.='</tr>';

    $c = $c + 1;
}
unset($sqlX, $rX, $fX);
$tablaviaticos.='</table>';





$tablaviaticos.='<table style="padding:1px;border: 0.3px solid black;">
   
';
$sqlX = "
select * from viaticosgastosfull_resumen where IdViatico='".$IdViatico."' 
";
$c = 0;
$rX= $conexion -> query($sqlX);
$Total = 0;
$txtResumen= "";
while($fX = $rX -> fetch_array()) {

    $txtResumen.='<b>'.$fX['Tipo'].'</b>: '.Pesos($fX['SubTotal']).'<br>';
    // $tablaviaticos.='</tr>';
    $Total = $Total + $fX['SubTotal'];
    $c = $c + 1;
}
unset($sqlX, $rX, $fX);
    $tablaviaticos.='<tr style="background-color:#ab0033;color:white;">';
    $tablaviaticos.='<td style="font-size:10px; text-align:right;">'.$txtResumen.'</td>';
    $tablaviaticos.='<td style="vertical-align:middle; font-size:15px; text-align:center; vertical-align:middle"><br><br>'.Pesos($Total).'<br></td>';

    $tablaviaticos.='</tr>';
$tablaviaticos.='</table>';


$tablaviaticos.='</table><br>';


$tVehiculo = '<br><table style="border: 0.3px solid black; padding:7px;" ><tr><td>';

$tVehiculo.='<table style="padding:1px;">
    <tr>
        <td style="font-size:10px; background-color:#ab0033;color:white;text-align:center;">Tipo de Transporte: <b>'.$f['TipoTransporte'];
        $tVehiculo.='</b></td>';       

        $tVehiculo.='<td style="font-size:10px; background-color:#bc955c;color:white;text-align:center;">Recorrido:';
        $tVehiculo.='</td>';
        $tVehiculo.='</tr>';
      

        $tVehiculo.='<tr>';
        $tVehiculo.='<td>';
        if ($f['TipoTransporte']=='OFICIAL') {
            // $tVehiculo.='-'.$f['IdVehiculoOficial'];
            $tVehiculo.='<br>'. Vehiculo_table($f['IdVehiculoOficial']);
        } else{
            if ($f['TipoTransporte']=='PARTICULAR'){
                $t='<table style="padding:1px; font-size:9px; font-weight: normal;">';
                $t.='<tr><td style="text-align:right; background-color:#E5E5E5;">Marca:</td><td style="text-align:left; background-color:#E5E5E5;">'.$f['Particular_Marca'].'</td></tr>';		
                $t.='<tr><td style="text-align:right;">Placas:</td><td style="text-align:left;">'.$f['Particular_Placas'].'</td></tr>';
                $t.='<tr><td style="text-align:right; background-color:#E5E5E5;">Modelo:</td><td style="text-align:left; background-color:#E5E5E5;">'.$f['Particular_Modelo'].'</td></tr>';
                $t.='<tr><td style="text-align:right;">Tipo:</td><td style="text-align:left;">'.$f['Particular_Tipo'].'</td></tr>';
                $t.='<tr><td style="text-align:right; background-color:#E5E5E5;">Cilindraje:</td><td style="text-align:left; background-color:#E5E5E5;">'.$f['Particular_Cilindros'].'cil</td></tr>';                
                $t.='</table>';
                $tVehiculo.=$t;
            } else {
                $t='<table style="padding:1px; font-size:9px; font-weight: normal;">';
                $t.='<tr><td style="text-align:right; background-color:#E5E5E5;">Trasporte:</td><td style="text-align:left; background-color:#E5E5E5;">'.$f['Veh_Transporte'].'</td></tr>';		
                $t.='<tr><td style="text-align:right;">Cantidad:</td><td style="text-align:left;">'.Pesos($f['Veh_TransporteGasto']).'</td></tr>';
                $t.='</table>';
                $tVehiculo.=$t;

            }
        }
        $tVehiculo.='</td>';
        
        $tVehiculo.='<td>';

        $sqlX ="select CONCAT(Origen,' a ', Destino) as Lugar, Distancia from viaticosrecorridos where IdViatico='".$IdViatico."' order by IdRecorrido ASC";
        $rX= $conexion -> query($sqlX);
        $t='<table style="padding:1px; font-size:9px; font-weight: normal;">';
        $c=0;
        while($fX = $rX -> fetch_array()) {
            if ($c%2==0){
                $t.=' <tr style="background-color:#F5FCE4">';
            }
            else{
                $t.=' <tr style="background-color:#E9F7C4">';
            }
    
            $t.='<td style="text-align:right; ">'.$fX['Lugar'].'</td><td style="text-align:left; ">'.$fX['Distancia'].'km</td>
            </tr>';		
            $c = $c + 1;
        
        }
        $t.='</table>';

        $tVehiculo.=$t;
        $tVehiculo.='</td>';
      

        $tVehiculo.='</tr>';

        
        $tVehiculo.='<tr>';   
        // $tVehiculo.='<td>';   
        // $tVehiculo.='</td>';    
        $tVehiculo.='<td  style=" vertical-align: text-bottom; font-size:9px; text-align:justify;"><u><b><br>Recorrido Excedente:</b></u></td>';
        $tVehiculo.='</tr>';

        $tVehiculo.='<tr style="background-color:white;">';    
        // $tVehiculo.='<td>';   
        // $tVehiculo.='</td>';
        $tVehiculo.='<td style="font-size:9px; text-align:justify; font-weight:normal; " colspan="2">'.viaticos_RecorridoExcedente($IdViatico).'</td>';

        $tVehiculo.='</tr>';
        

        $tVehiculo.='
        
    </table>';
$tVehiculo.= '
</td></tr></table><br><br>';




$tFirmas='
<table style="border: 0.3px solid black;">
<table style="padding:2px; font-size:11px;k" >   
    <tr>
    <td colspan="11" style=" text-align:center; font-size:9px;">Firmas (Nombre y Firma):</td> 
    </tr>
    <tr>
    <td colspan="11" style="height:10px;"></td> 
    </tr>
    <tr>
        <td></td> 
        <td colspan="4" style="text-align: center;vertical-align:middle; font-weight: bold;">'.nitavu_nombre(titular(quienEsmiDireccion(nitavu_dpto(viaticos_NEmpleado($IdViatico))))).'</td> 
        <td style="whidth:2%"></td>    
        <td colspan="4" style="text-align: center;vertical-align:middle; font-weight: bold;">'.Preference("Comisario","","").'</td>  
        <td></td>  
    </tr>
    <tr>
        <td></td>  
        <td colspan="4" style="text-align: center; font-size:9px; vertical-align:middle;">Director Area</td> 
        <td style="whidth:2%"></td>    
        <td colspan="4" style="text-align: center;vertical-align:middle; font-size:9px;">Organo de Control</td> 
        <td></td>            
    </tr>
    

    <tr>
    <td colspan="11" style="height:25px;"></td> 
    </tr>

   
    <tr>
        <td></td>  
        <td colspan="4" style="text-align: center;vertical-align:middle; font-weight: bold;">'.Preference("DirectorAdministrativo","","").'</td> 
        <td style="whidth:2%"></td>    
        <td colspan="4" style="text-align: center;vertical-align:middle; font-weight: bold;">'.$nombre.'</td>    
        <td></td>  
    </tr>
    <tr>
        <td></td>  
        <td colspan="4" style="text-align: center;vertical-align:middle;font-size:9px; ">Director Administrativo</td> 
        <td style="whidth:2%"></td>    
        <td colspan="4" style="text-align: center;vertical-align:middle;font-size:9px;" >Recibe</td>  
        <td></td>           
    </tr>
    
    
</table></table>';


$trfc='

<table style="padding:2px; font-size:11px;k" >   
    <tr>
    <td colspan="2">DATOS PARA FACTURACION CFDI 4.0</td> 
    <td></td> 
    </tr>
    <tr>
    <td>RFC</td> 
    <td></td> 
    </tr>
    <tr>
    <td>CODIGO POSTAL</td> 
    <td></td> 
    </tr>
    <tr>
    <td>REGIMEN FISCAL</td> 
    <td></td> 
    </tr>
    <tr>
    <td>USO DE CFDI</td> 
    <td></td> 
    </tr>
    <tr>
    <td>CORREO ELECTRONICO</td> 
    <td></td> 
    </tr>
</table>';

$tabla=$t1.$t2.$t3.$t4.$tablaviaticos.$tVehiculo.$tFirmas;
//echo $tabla;

if ($OK == TRUE){
    class PDFEDOCUENTA extends TCPDF {
		public $str;
		public $Delegacion;
		public $NumContrato;
		public $FechaContrato;
		public $Beneficiario;

		public function Header() {
			// Logo
			$image_file = K_PATH_IMAGES.'pdf_logo.png';
			$icono = K_PATH_IMAGES.'user.png';
			
			$this->Image($image_file, 15, 15, 60, '', 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);
			// Set font
			$this->SetFont('helvetica', 'B', 6);
			// Title
		 //    $this->Cell(0, 10, 'INSTITUTO TAMAULIPECO DE VIVIENDA Y URBANISMO', 0, false, 'C', 0, '', 0, false, 'M', 'M');
		 // $this->Text(100,5, 'INSTITUTO TAMAULIPECO DE VIVIENDA Y URBANISMO'); 
		 $this->Text(90,14, ' I N S T I T U T O  T A M A U L I P E C O   D E   V I V I E N DA    Y  U R B A N I S M O '); 
		 $this->SetFont('helvetica', 'B', 10);
		 $this->Text(100,17, '           RECIBO DE VIATICO '); 

		 $this->SetFont('courier', 'R', 7); $this->Text(85,20, ''); $this->SetFont('courier', 'B', 8); $this->Text(110,21, 'IdViatico: '.$this->NumContrato); 
		 $this->SetFont('courier', 'R', 6); $this->Text(85,24, ''); $this->SetFont('courier', 'B', 6); $this->Text(150,25, ''.$this->FechaContrato); 

		 $this->SetFont('helvetica', 'B', 12);
		//  $this->SetTextColor(0,91,160);
		 $this->SetTextColor(0,0,0);
		//  $this->Image($icono, 15, 19, 5, '', 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);
		 $this->Text(20,19, '  '.$this->Beneficiario); 
		//  $this->Cell(0, 0, $this->Beneficiario, 1, 1, 'C');
		//  $this->MultiCell(0, 0,  $this->Beneficiario , 1, 'C', false, 1);

		}
	
		public function Footer() {
			// Position at 15 mm from bottom
			$this->SetY(-15);
			// Set font
		 //    $line_width = (0.85 / $this->k);
		 //    $this->Ln(1);
		 $this->SetFont('helvetica', 'I', 6);
		 //    $pdf->SetXY(0, 100);                   
		 $this->SetTextColor(0,0,0);
			// Page number
			$linea= "______________________________________________________________________________________________________________________________________________________________";
		 //    $this->Cell(0, 0, $linea, 0, false, 'L', 0, '', 0, false, 'T', 'M');
		 //    $this->Cell(0, 20, $this->str.' | Pag. '.$this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, false, 'L', 0, '', 0, false, 'T', 'M');
		 // $str = $this->str." |  Pag. ".$this->getAliasNumPage().'/'.$this->getAliasNbPages();
		 $paginas = "Pag. ".$this->getAliasNumPage().'/'.$this->getAliasNbPages();
		 // $this->SetTextColor(205,205,205);
		 $this->Text(15,263, $linea); 
		 // $this->SetTextColor(129,129,129);
         $this->SetFont('helvetica', 'B', 6);
         $this->Text(15,258, 'ARTÍCULO 30');
         $this->SetFont('helvetica', 'I', 7);
         $this->Text(15,260, '--* Las comprobaciones no deberán exceder más de 3 días hábiles, evite gastos administrativos --*'); 
		 $this->SetFont('helvetica', 'B', 9); 
         $this->Text(15,266, $paginas); 
		 // $this->SetTextColor(165,165,165);
		 $this->SetFont('helvetica', 'R', 7); 
		 $this->Text(32,266, substr($this->str,0,140)); 
		 $this->Text(32,269, substr($this->str,140,)); 
		 // $this->Cell(0, 20, $this->str.'. Pag. '.$this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, false, 'L', 0, '', 0, false, 'T', 'M');
		}
	}

	 $pdf = new PDFEDOCUENTA(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
     $leyenda="";
	 $pdf->SetCreator(PDF_CREATOR);
	 $pdf->SetKeywords('Reporte ITAVU');
	 //$pdf->SetHeaderData('pdf_logo.jpg', '40','');
	 $pdf->SetHeaderData('', '10', '', 'ITAVU  '.$leyenda);
	 //$pdf->setFooterData(array(0, 64, 0), array(0, 64, 128));
	 $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
	 $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
	 
	 // $pdf->setFooterData('', '10', '', 'ITAVU  '.$string);
	 $pdf->str = $leyenda;
     $EstadoFinal= $Estado;
     if ($Estado =='en Captura') {$EstadoFinal = "";}

	 $pdf->NumContrato = "".$IdViatico." | ".$oficio;//." ".$EstadoFinal."";
     





	 $pdf->FechaContrato = nitavu_adscripcion($nitavu).", ".$fecha;//.":".$hora;
	 $pdf->Beneficiario = "";
	 $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
	 
	 // set margins
	 $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
	 $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
	 $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
	 #Establecemos los márgenes izquierda, arriba y derecha:
	 $pdf->SetMargins(15, 25 , 15);

	 #Establecemos el margen inferior:
	 // $pdf->SetAutoPageBreak(true,25);  
	 
	 // set auto page breaks
	$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
	 
	 // set image scale factor
	 $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
	 
	 // set some language-dependent strings (optional)
	 if (@file_exists(dirname(__FILE__).'pdf/lang/eng.php')) {
		 require(dirname(__FILE__).'pdf/lang/eng.php');
		 $pdf->setLanguageArray($l);
	 }
	 // set font
	 $pdf->SetFont('helvetica', '', 9);
	 // add a page
	 $pages = $pdf->getNumPages();
	 
	 $pdf->AddPage('P', 'LETTER'); //en la tabla de reporte L o P
	//  $html = "".$t1."";
   
	 $pag = $pdf->PageNo();
	//echo $cancelado;
	//  if($cancelado == TRUE){
	// 	 $pdf->Image('icon/cancelado.png', 18, 70,180, 100, '', '', '', false, 300, '', false, false, 0);
	//  }
	// $pdf->text
	$style = array(
		'border' => true,
		'padding' => 5,
		'fgcolor' => array(0,0,0),
		'bgcolor' => false
	);



$html = $tabla;
//echo $html; //aqui escribe el contenido de la consulta


// $pdf->StartTransform();
// $pdf->Rotate(-50);
// $pdf->SetTextColor(255,0,0);            
// $pdf->SetFont('', 'B', 48, '', 'false');
// $pdf->Text(30, 180,$Estado);


// $pdf->StartTransform();
// $pdf->Rotate(90);
// $pdf->SetTextColor(0,0,0);            
// $pdf->SetFont('', 'R', 10, '', 'false');
// $pdf->Text(30, 180,$Estado);


$pdf->SetFont('helvetica', 'B', 8); 
$rfcitavu='https://siat.sat.gob.mx/app/qr/faces/pages/mobile/validadorqr.jsf?D1=10&D2=1&D3=15050316977_ITV820513L21';
$pdf->Text(172,75, 'ITV820513L21'); 
$pdf->write2DBarcode($rfcitavu, 'QRCODE,M', 168.5, 48, 29, 29, $styleqr, 'N'); 




// $pdf->Text(150, 20, 'CODIGO DE ENVIO: '.$f['token']);
$pdf->SetXY(13.5, 25);    
$pdf->writeHTML($html, true, false, true, false, '');

$pdf->SetXY(15, 15);    

// reset pointer to the last page
$pdf->lastPage();
//Close and output PDF document}
ob_end_clean();
$pdf->Output('ViaticosFormato.pdf', 'I');


} else {
    // echo "Estatus del Viatico no valido";
    MsgBox_Lite("Estus del Viatico no valido","index.php");
}

?>