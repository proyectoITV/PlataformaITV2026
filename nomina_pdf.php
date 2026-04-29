<?php 	require("config.php");
include (".//seguridad.php");

if (isset($_GET['id']) ){//si se cumplen estas variables ejecutar el reporte
    
        //historia($_GET['nuc'],"Vio Ticket de la guia ".$_GET['guia']);
        XML_nomina($_GET['id']);
        
    
   
}
else{mensaje("Error al iniciar el reporte", 'nomina_pdf.php');}













function XML_nomina($id){    
require("config.php");
$sql = "SELECT * FROM nominas WHERE id='".$id."'";
$rc= $conexion -> query($sql);
$msg="";
if($f = $rc -> fetch_array())
{
	$xmlCont  = $f['xmlCont'];
    
    //calculo de las variables
    $RE_receptor_n='<.*?Receptor.*?Nombre="(.*?)"';
    $RE_receptor='<.*?Receptor.*?"(.*?)"';
    $RE_emisor_n='<.*?Emisor.*?Nombre="(.*?)"';
    $RE_emisor='<.*?Rfc.*?"(.*?)"';
    $RE_fecha='.*?((?:2|1)\d{3}(?:-|\/)(?:(?:0[1-9])|(?:1[0-2]))(?:-|\/)(?:(?:0[1-9])|(?:[1-2][0-9])|(?:3[0-1]))(?:T|\s)(?:(?:[0-1][0-9])|(?:2[0-3])):(?:[0-5][0-9]):(?:[0-5][0-9]))';
    $RE_concepto='<.*?Concepto.*?descripcion="(.*?)".*?>';

    preg_match_all("/".$RE_fecha."/is",$xmlCont, $matches);
    $fechaxmlorig=$matches[1][0];
    unset($matches);
    
    //Extraer rfc del receptor
    preg_match_all('/'.$RE_receptor.'/is',$xmlCont, $matches);
    $rfcxmlre=$matches[1][0]; // RFC del receptor
    unset($matches);
    
    preg_match_all('/'.$RE_receptor_n.'/is',$xmlCont, $matches);
    $nombrexmlre=$matches[1][0]; // Nombre del receptor
    unset($matches);

    //Extraer datos  del emisor
    preg_match_all('/'.$RE_emisor_n.'/is',$xmlCont, $matches);
    $nombrexmlem=$matches[1][0]; //  Nombre del emisor
    unset($matches);
    preg_match_all('/'.$RE_emisor.'/is',$xmlCont, $matches);
    $rfcxmlem=$matches[1][0]; // RFC del receptor
    unset($matches);

    //Extraer descripcion
    preg_match_all('/'.$RE_concepto.'/is',$xmlCont, $matches);
    $desxml=implode(", ",$matches[1]); // Descripciones de los conceptos separadas por comas
    unset($matches);

    $RE_RFiscal='<.*?RegimenFiscal="(.*?)".*?>';
    preg_match_all('/'.$RE_RFiscal.'/is',$xmlCont, $matches);
    $RegimenFiscal=implode(", ",$matches[1]). " Personas Morales con Fines no Lucrativos"; //para otros, catalago de regimenes fiscales, ya que solo sa el ID en este caso 603
    unset($matches);

    $RE='<.*?LugarExpedicion="(.*?)".*?>';
    preg_match_all('/'.$RE.'/is',$xmlCont, $matches);
    $LugarExpedicion=implode(", ",$matches[1])." CIUDAD VICTORIA";//da el CP; para otros poner lista de CP
    unset($matches);

    $RE='<.*?Fecha="(.*?)".*?>';
    preg_match_all('/'.$RE.'/is',$xmlCont, $matches);
    $FechaI=implode(", ",$matches[1])."";//Fecha del Movimiento
    $HoraI = substr($FechaI, 11, 9);
    $FechaI = substr($FechaI, 0, 10);
    unset($matches);

    $RE='<.*?NumEmpleado="(.*?)".*?>';
    preg_match_all('/'.$RE.'/is',$xmlCont, $matches);
    $NEmpleado=implode(", ",$matches[1])."";// Numero de empleado
    //$HoraI = substr($FechaI, 11, 9);    
    unset($matches);

    $RE='<.*?TotalOtrosPagos="(.*?)".*?>';
    preg_match_all('/'.$RE.'/is',$xmlCont, $matches);
    $TotalOtrosPagos=implode(", ",$matches[1])."";// Numero de empleado
    //$HoraI = substr($FechaI, 11, 9);    
    unset($matches);

    $RE='<.*?Curp="(.*?)".*?>';
    preg_match_all('/'.$RE.'/is',$xmlCont, $matches);
    $Curp=implode(", ",$matches[1])."";// Numero de empleado
    //$HoraI = substr($FechaI, 11, 9);    
    unset($matches);

    $RE='<.*?FechaPago="(.*?)".*?>';
    preg_match_all('/'.$RE.'/is',$xmlCont, $matches);
    $FechaPago=implode(", ",$matches[1])."";// Numero de empleado
    //$HoraI = substr($FechaI, 11, 9);    
    unset($matches);

    $RE='<.*?FechaInicialPago="(.*?)".*?>';
    preg_match_all('/'.$RE.'/is',$xmlCont, $matches);
    $FechaInicialPago=implode(", ",$matches[1])."";// 
    //$HoraI = substr($FechaI, 11, 9);    
    unset($matches);

    $RE='<.*?FechaFinalPago="(.*?)".*?>';
    preg_match_all('/'.$RE.'/is',$xmlCont, $matches);
    $FechaFinalPago=implode(", ",$matches[1])."";// 
    //$HoraI = substr($FechaI, 11, 9);    
    unset($matches);

    $RE='<.*?TipoJornada="(.*?)".*?>';
    preg_match_all('/'.$RE.'/is',$xmlCont, $matches);
    $TipoJornada=implode(", ",$matches[1])."";// Numero de empleado
    if ($TipoJornada=='01'){$TipoJornada_descripcion=$TipoJornada." Diurna";}
    //$HoraI = substr($FechaI, 11, 9);    
    unset($matches);

    
    $RE='<.*?PeriodicidadPago="(.*?)".*?>';
    preg_match_all('/'.$RE.'/is',$xmlCont, $matches);
    $Periodicidad=implode(", ",$matches[1])."";// Numero de empleado
    //if ($TipoJornada=='01'){$TipoJornada_descripcion=$TipoJornada." Diurna";}
    //$HoraI = substr($FechaI, 11, 9);    
    unset($matches);

    $RE='<.*?NumDiasPagados="(.*?)".*?>';
    preg_match_all('/'.$RE.'/is',$xmlCont, $matches);
    $DiasdePago=implode(", ",$matches[1])."";// Numero de empleado
    //if ($TipoJornada=='01'){$TipoJornada_descripcion=$TipoJornada." Diurna";}
    //$HoraI = substr($FechaI, 11, 9);    
    unset($matches);

    $RE='<.*?Puesto="(.*?)".*?>';
    preg_match_all('/'.$RE.'/is',$xmlCont, $matches);
    $Puesto=implode(", ",$matches[1])."";// Numero de empleado
    //if ($TipoJornada=='01'){$TipoJornada_descripcion=$TipoJornada." Diurna";}
    //$HoraI = substr($FechaI, 11, 9);    
    unset($matches);

    $RE='<.*?Departamento="(.*?)".*?>';
    preg_match_all('/'.$RE.'/is',$xmlCont, $matches);
    $Departamento=implode(", ",$matches[1])."";// Numero de empleado
    //if ($TipoJornada=='01'){$TipoJornada_descripcion=$TipoJornada." Diurna";}
    //$HoraI = substr($FechaI, 11, 9);    
    unset($matches);

    $RE='<.*?CuentaBancaria="(.*?)".*?>';
    preg_match_all('/'.$RE.'/is',$xmlCont, $matches);
    $CuentaBancaria=implode(", ",$matches[1])."";// Numero de empleado
    //if ($TipoJornada=='01'){$TipoJornada_descripcion=$TipoJornada." Diurna";}
    //$HoraI = substr($FechaI, 11, 9);    
    unset($matches);

    $RE='<.*?Banco="(.*?)".*?>';
    preg_match_all('/'.$RE.'/is',$xmlCont, $matches);
    $Banco=implode(", ",$matches[1])."";// Numero de empleado
    //if ($TipoJornada=='01'){$TipoJornada_descripcion=$TipoJornada." Diurna";}
    //$HoraI = substr($FechaI, 11, 9);    
    unset($matches);

    $RE='<.*?Sindicalizado="(.*?)".*?>';
    preg_match_all('/'.$RE.'/is',$xmlCont, $matches);
    $Sindicalizado=implode(", ",$matches[1])."";// Numero de empleado
    //if ($TipoJornada=='01'){$TipoJornada_descripcion=$TipoJornada." Diurna";}
    //$HoraI = substr($FechaI, 11, 9);    
    unset($matches);

    $RE='<.*?TipoRegimen="(.*?)".*?>';
    preg_match_all('/'.$RE.'/is',$xmlCont, $matches);
    $Regimen=implode(", ",$matches[1])."";// Numero de empleado
    //if ($TipoJornada=='01'){$TipoJornada_descripcion=$TipoJornada." Diurna";}
    //$HoraI = substr($FechaI, 11, 9);    
    unset($matches);
    
    $RE='<.*?TotalSueldos="(.*?)".*?>';
    preg_match_all('/'.$RE.'/is',$xmlCont, $matches);
    $Sueldo=implode(", ",$matches[1])."";// Numero de empleado
    //if ($TipoJornada=='01'){$TipoJornada_descripcion=$TipoJornada." Diurna";}
    //$HoraI = substr($FechaI, 11, 9);    
    unset($matches);

    $RE='<.*?TipoDeduccion="(.*?)".*?>';
    preg_match_all('/'.$RE.'/is',$xmlCont, $TipoDeduccion);
    // $TipoDeduccion=implode(", ",$matches[1])."";// Numero de empleado
    //var_dump($TipoDeduccion);
    //if ($TipoJornada=='01'){$TipoJornada_descripcion=$TipoJornada." Diurna";}
    //$HoraI = substr($FechaI, 11, 9);    
    unset($matches);

    $RE='<.*?TipoDeduccion.*?Clave="(.*?)".*?>';
    preg_match_all('/'.$RE.'/is',$xmlCont, $TipoDeduccion_clave);
    // $TipoDeduccion=implode(", ",$matches[1])."";// Numero de empleado
    //var_dump($TipoDeduccion);
    //if ($TipoJornada=='01'){$TipoJornada_descripcion=$TipoJornada." Diurna";}
    //$HoraI = substr($FechaI, 11, 9);    
    unset($matches);

    $RE='<.*?TipoDeduccion.*?Concepto="(.*?)".*?>';
    preg_match_all('/'.$RE.'/is',$xmlCont, $TipoDeduccion_concepto);
    // $TipoDeduccion=implode(", ",$matches[1])."";// Numero de empleado
    //var_dump($TipoDeduccion);
    //if ($TipoJornada=='01'){$TipoJornada_descripcion=$TipoJornada." Diurna";}
    //$HoraI = substr($FechaI, 11, 9);    
    unset($matches);

    
    
    $RE='<.*?TipoDeduccion.*?Importe="(.*?)".*?>';
    preg_match_all('/'.$RE.'/is',$xmlCont, $TipoDeduccion_importe);
    // $TipoDeduccion=implode(", ",$matches[1])."";// Numero de empleado
    //var_dump($TipoDeduccion);
    //if ($TipoJornada=='01'){$TipoJornada_descripcion=$TipoJornada." Diurna";}
    //$HoraI = substr($FechaI, 11, 9);    
    unset($matches);




    
    $RE='<.*?TipoPercepcion="(.*?)".*?>';
    preg_match_all('/'.$RE.'/is',$xmlCont, $TipoPercepcion);
    // $TipoDeduccion=implode(", ",$matches[1])."";// Numero de empleado
    //var_dump($TipoDeduccion);
    //if ($TipoJornada=='01'){$TipoJornada_descripcion=$TipoJornada." Diurna";}
    //$HoraI = substr($FechaI, 11, 9);    
    unset($matches);

    $RE='<.*?TipoPercepcion.*?Clave="(.*?)".*?>';
    preg_match_all('/'.$RE.'/is',$xmlCont, $TipoPercepcion_clave);
    // $TipoDeduccion=implode(", ",$matches[1])."";// Numero de empleado
    //var_dump($TipoDeduccion);
    //if ($TipoJornada=='01'){$TipoJornada_descripcion=$TipoJornada." Diurna";}
    //$HoraI = substr($FechaI, 11, 9);    
    unset($matches);

    $RE='<.*?TipoPercepcion.*?Concepto="(.*?)".*?>';
    preg_match_all('/'.$RE.'/is',$xmlCont, $TipoPercepcion_concepto);
    // $TipoDeduccion=implode(", ",$matches[1])."";// Numero de empleado
    //var_dump($TipoDeduccion);
    //if ($TipoJornada=='01'){$TipoJornada_descripcion=$TipoJornada." Diurna";}
    //$HoraI = substr($FechaI, 11, 9);    
    unset($matches);

    
    $RE='<.*?TipoPercepcion.*?ImporteGravado="(.*?)".*?>';
    preg_match_all('/'.$RE.'/is',$xmlCont, $TipoPercepcion_importe);
    // $TipoDeduccion=implode(", ",$matches[1])."";// Numero de empleado
    //var_dump($TipoDeduccion);
    //if ($TipoJornada=='01'){$TipoJornada_descripcion=$TipoJornada." Diurna";}
    //$HoraI = substr($FechaI, 11, 9);    
    unset($matches);


    $RE='<.*?TipoPercepcion.*?ImporteExento="(.*?)".*?>';
    preg_match_all('/'.$RE.'/is',$xmlCont, $TipoPercepcion_importe_excento);
    // $TipoDeduccion=implode(", ",$matches[1])."";// Numero de empleado
    //var_dump($TipoDeduccion);
    //if ($TipoJornada=='01'){$TipoJornada_descripcion=$TipoJornada." Diurna";}
    //$HoraI = substr($FechaI, 11, 9);    
    unset($matches);


    $RE='<.*?Descuento.*?Total="(.*?)".*?>';
    preg_match_all('/'.$RE.'/is',$xmlCont, $matches);
    $GranTotal=implode(", ",$matches[1])."";// Numero de empleado
    //var_dump($TipoDeduccion);
    //if ($TipoJornada=='01'){$TipoJornada_descripcion=$TipoJornada." Diurna";}
    //$HoraI = substr($FechaI, 11, 9);    
    unset($matches);

    $RE='<.*?TotalDeducciones="(.*?)".*?>';
    preg_match_all('/'.$RE.'/is',$xmlCont, $matches);
    $TotalDeducciones=implode(", ",$matches[1])."";// Numero de empleado
    //var_dump($TipoDeduccion);
    //if ($TipoJornada=='01'){$TipoJornada_descripcion=$TipoJornada." Diurna";}
    //$HoraI = substr($FechaI, 11, 9);    
    unset($matches);

    $RE='<.*?TotalPercepciones="(.*?)".*?>';
    preg_match_all('/'.$RE.'/is',$xmlCont, $matches);
    $TotalPercepciones=implode(", ",$matches[1])."";// Numero de empleado
    //var_dump($TipoDeduccion);
    //if ($TipoJornada=='01'){$TipoJornada_descripcion=$TipoJornada." Diurna";}
    //$HoraI = substr($FechaI, 11, 9);    
    unset($matches);

     $RE='<.*?TotalImpuestosRetenidos="(.*?)".*?>';
    preg_match_all('/'.$RE.'/is',$xmlCont, $matches);
    $TotalImpuestosRetenidos=implode(", ",$matches[1])."";// Numero de empleado
    //var_dump($TipoDeduccion);
    //if ($TipoJornada=='01'){$TipoJornada_descripcion=$TipoJornada." Diurna";}
    //$HoraI = substr($FechaI, 11, 9);    
    unset($matches);


     $RE='<.*?Sello="(.*?)".*?>';
    preg_match_all('/'.$RE.'/is',$xmlCont, $matches);
    $Sello=implode(", ",$matches[1])."";// Numero de empleado
    //var_dump($TipoDeduccion);
    //if ($TipoJornada=='01'){$TipoJornada_descripcion=$TipoJornada." Diurna";}
    //$HoraI = substr($FechaI, 11, 9);    
    unset($matches);

     $RE='<.*?SelloSAT="(.*?)".*?>';
    preg_match_all('/'.$RE.'/is',$xmlCont, $matches);
    $SelloSAT=implode(", ",$matches[1])."";// Numero de empleado
    //var_dump($TipoDeduccion);
    //if ($TipoJornada=='01'){$TipoJornada_descripcion=$TipoJornada." Diurna";}
    //$HoraI = substr($FechaI, 11, 9);    
    unset($matches);

    $RE='<.*?UUID="(.*?)".*?>';
    preg_match_all('/'.$RE.'/is',$xmlCont, $matches);
    $UUID=implode(", ",$matches[1])."";// Numero de empleado
    //var_dump($TipoDeduccion);
    //if ($TipoJornada=='01'){$TipoJornada_descripcion=$TipoJornada." Diurna";}
    //$HoraI = substr($FechaI, 11, 9);    
    unset($matches);

    $RE='<.*?FechaTimbrado="(.*?)".*?>';
    preg_match_all('/'.$RE.'/is',$xmlCont, $matches);
    $FechaTimbrado=implode(", ",$matches[1])."";// Numero de empleado
    //var_dump($TipoDeduccion);
    //if ($TipoJornada=='01'){$TipoJornada_descripcion=$TipoJornada." Diurna";}
    //$HoraI = substr($FechaI, 11, 9);    
    unset($matches);


    //DATOS NECESARIOS PARA GENERAR EL LINK DE AUTENCIDAD
    
    $RE='<.*?TimbreFiscalDigitalv11.*?Version="(.*?)".*?>';
    preg_match_all('/'.$RE.'/is',$xmlCont, $matches);
    $LVersion=implode(", ",$matches[1])."";// Numero de empleado
    //var_dump($TipoDeduccion);
    //if ($TipoJornada=='01'){$TipoJornada_descripcion=$TipoJornada." Diurna";}
    //$HoraI = substr($FechaI, 11, 9);    
    unset($matches);

    $RE='<.*?RfcProvCertif="(.*?)".*?>';
    preg_match_all('/'.$RE.'/is',$xmlCont, $matches);
    $RfcProvCertif=implode(", ",$matches[1])."";// Numero de empleado
    //var_dump($TipoDeduccion);
    //if ($TipoJornada=='01'){$TipoJornada_descripcion=$TipoJornada." Diurna";}
    //$HoraI = substr($FechaI, 11, 9);    
    unset($matches);

    $RE='<.*?NoCertificadoSAT="(.*?)".*?>';
    preg_match_all('/'.$RE.'/is',$xmlCont, $matches);
    $NoCertificadoSAT=implode(", ",$matches[1])."";// Numero de empleado
    //var_dump($TipoDeduccion);
    //if ($TipoJornada=='01'){$TipoJornada_descripcion=$TipoJornada." Diurna";}
    //$HoraI = substr($FechaI, 11, 9);    
    unset($matches);


    

    $RE='<.*?SalarioBaseCotApor="(.*?)".*?>'; //VARIABLE NUEVA, se obtiene del xml de la bd
    preg_match_all('/'.$RE.'/is',$xmlCont, $matches);
    $SalarioBaseCotApor=implode(", ",$matches[1])."";// Numero de empleado
    //var_dump($TipoDeduccion);
    //if ($TipoJornada=='01'){$TipoJornada_descripcion=$TipoJornada." Diurna";}
    //$HoraI = substr($FechaI, 11, 9);    
    unset($matches);
    
    


        $indice=0;
        reset($TipoDeduccion);  //Agrupado por el SAT
        foreach ($TipoDeduccion[1] as $key => $value) 
            { 
                //echo strval($key)."=".strval($value)."<br>";
                $Deducciones[$indice][0] = $value;
                $indice = $indice +1;
            }

        //echo "Con clave: <br>";
        $indice= 0;
        reset($TipoDeduccion_clave); //con CLAVE
        foreach ($TipoDeduccion_clave[1] as $key => $value) 
            { 
            // echo strval($key)."=".strval($value)."<br>";
                $Deducciones[$indice][1] = $value;
                $indice = $indice +1;
            }    

        //echo "Con concepto: <br>";
        $indice = 0;
        reset($TipoDeduccion_concepto); //con CLAVE
        foreach ($TipoDeduccion_concepto[1] as $key => $value) 
            { 
                //echo strval($key)."=".strval($value)."<br>";
                $Deducciones[$indice][2] = $value;
                $indice = $indice +1;
            }    

        $indice = 0;
        reset($TipoDeduccion_importe); //con CLAVE
        foreach ($TipoDeduccion_importe[1] as $key => $value) 
            { 
                //echo strval($key)."=".strval($value)."<br>";
                $Deducciones[$indice][3] = $value;
                $indice = $indice +1;
            }   
        $TotalN_deducciones = $indice;
        $style1='style="right:0;  background-color:white; ';
        $style2='style="right:0; background-color:#EAEAEA;';
        $TblDeducciones=""; $Tmp=0;
        for ($i = 0; $i <= $TotalN_deducciones-1; $i++) {
            //echo $Deducciones[$i][0]."|".$Deducciones[$i][1]."|".$Deducciones[$i][2]."|".$Deducciones[$i][3]."<br>";
             if ($i==0){
                    $TblDeducciones = $TblDeducciones.'<h3 style="text-align:center;">Deducciones</h3><table style="width:100%;" ><tr>
            <td  '.$style2.' width:16%;">SAT</td>
            <td  '.$style2.' width:14%;">No</td>
            <td  '.$style2.' width:50%;">Nombre</td>
            <td '.$style2.'width:20%; text-align: left;">             Importe</td>
            </tr>';
                }
            
             if($i%2==0){

                $TblDeducciones = $TblDeducciones.'<tr >';    
                $TblDeducciones = $TblDeducciones.'<td '.$style1.' width:16%;">'.$Deducciones[$i][0]."</td>";
                $TblDeducciones = $TblDeducciones.'<td '.$style1.' width:14%;">'.$Deducciones[$i][1]."</td>";
                $TblDeducciones = $TblDeducciones.'<td '.$style1.' width:50%;">'.$Deducciones[$i][2].'</td>';
                $Tmp = $Deducciones[$i][3]; $Tmp = number_format($Tmp, 2, '.', ',');
                
                $TblDeducciones = $TblDeducciones.'<td '.$style1.' width:20%; text-align: left;">$ '.$Tmp.'</td>';
                $TblDeducciones = $TblDeducciones."</tr>";
            }
            else {
                $TblDeducciones = $TblDeducciones.'<tr >';    
                $TblDeducciones = $TblDeducciones.'<td '.$style2.' width:16%;">'.$Deducciones[$i][0]."</td>";
                $TblDeducciones = $TblDeducciones.'<td '.$style2.' width:14%;">'.$Deducciones[$i][1]."</td>";
                $TblDeducciones = $TblDeducciones.'<td '.$style2.' width:50%;">'.$Deducciones[$i][2].'</td>';
                 $Tmp = $Deducciones[$i][3]; $Tmp = number_format($Tmp, 2, '.', ',');
                $TblDeducciones = $TblDeducciones.'<td '.$style2.' width:20%; text-align: left;">$ '.$Tmp.'</td>';
                $TblDeducciones = $TblDeducciones."</tr>";

            }

        }
        
        $TblDeducciones = $TblDeducciones."</table>";
        //echo $TblPercepcion;

        //$TblPercepcion = "<table><tr><td>2</td><td>2</td></tr></table>";
        $Ctotal2 = number_format($TotalDeducciones, 2, '.', ',');

        //$TblPercepcion = $TblPercepcion."<p style='font-size:14pt;   ' class='TChico'>Total Percepciones mas otros Pagos (".$TotalOtrosPagos.")  ";
        $TblDeducciones = $TblDeducciones."<p style='font-size:14pt;   ' class='TChico'>Total Percepciones mas otros Pagos:  ";
        $TblDeducciones = $TblDeducciones."<b class='Tmediano'>$".$Ctotal2."<b></p>";

        //echo "<b class='Tmediano'>$".number_format($TotalDeducciones, 2, '.', ',')."</b>";

$indice=0;
reset($TipoPercepcion);  //Agrupado por el SAT
foreach ($TipoPercepcion[1] as $key => $value) 
    { 
        //echo strval($key)."=".strval($value)."<br>";
        $Percepciones[$indice][0] = $value;
        $indice = $indice +1;
    }

//echo "Con clave: <br>";
$indice= 0;
reset($TipoPercepcion_clave); //con CLAVE
foreach ($TipoPercepcion_clave[1] as $key => $value) 
    { 
       // echo strval($key)."=".strval($value)."<br>";
        $Percepciones[$indice][1] = $value;
        $indice = $indice +1;
    }    

//echo "Con concepto: <br>";
$indice = 0;
reset($TipoPercepcion_concepto); //con CLAVE
foreach ($TipoPercepcion_concepto[1] as $key => $value) 
    { 
        //echo strval($key)."=".strval($value)."<br>";
        $Percepciones[$indice][2] = $value;
        $indice = $indice +1;
    }    

$indice = 0;
reset($TipoPercepcion_importe); //con CLAVE
foreach ($TipoPercepcion_importe[1] as $key => $value) 
    { 
        //echo strval($key)."=".strval($value)."<br>";
        $Percepciones[$indice][3] = $value;
        $indice = $indice +1;
    }   

    
$indice = 0;
reset($TipoPercepcion_importe_excento); //con CLAVE
foreach ($TipoPercepcion_importe_excento[1] as $key => $value) 
    { 
        //echo strval($key)."=".strval($value)."<br>";
        $Percepciones[$indice][4] = $value;
        $indice = $indice +1;
    }   

$TotalN_percepciones = $indice;
$Tmp=0;
$TblPercepcion =  "";
$style1='style="right:0;  background-color:white; ';
$style2='style="right:0; background-color:#EAEAEA;';

for ($i = 0; $i <= $TotalN_percepciones-1; $i++) {
    if ($i==0){
        $TblPercepcion = $TblPercepcion.'<h3 style="text-align:center;">Percepciones</h3><table style="width:100%;" ><tr>
<td  '.$style2.' width:16%;">SAT</td>
<td  '.$style2.' width:14%;">No</td>
<td  '.$style2.' width:50%;">Nombre</td>
<td '.$style2.'width:20%; text-align: left;">             Importe</td>
</tr>';
    }
    $Percepcion_real = 0; 
    if ($Percepciones[$i][3]=='0.00'){
        $Percepcion_real = $Percepciones[$i][4];
    } else {
        $Percepcion_real = $Percepciones[$i][3];
    }
    //echo $Percepciones[$i][0]."|".$Percepciones[$i][1]."|".$Percepciones[$i][2]."|".$Percepcion_real."<br>";
    $par = $TotalN_percepciones%2==0;
     if($i%2==0){

        $TblPercepcion = $TblPercepcion.'<tr >';    
        
        $TblPercepcion = $TblPercepcion.'<td '.$style1.' width:16%;">'.$Percepciones[$i][0]."</td>";
        $TblPercepcion = $TblPercepcion.'<td '.$style1.' width:14%;">'.$Percepciones[$i][1]."</td>";
        $TblPercepcion = $TblPercepcion.'<td '.$style1.' width:50%;">'.$Percepciones[$i][2].'</td>';
        $Tmp = $Percepciones[$i][0]; $Tmp = number_format($Percepcion_real, 2, '.', ',');
        $TblPercepcion = $TblPercepcion.'<td '.$style1.' width:20%; text-align: left;">$ '.$Tmp.'</td>';
        $TblPercepcion = $TblPercepcion."</tr>";
    }
    else {
         $TblPercepcion = $TblPercepcion.'<tr >';    
         //$TblPercepcion = $TblPercepcion.'<td '.$style1.'>('.$par.')'.$Percepciones[$i][0]."</td>";
        $TblPercepcion = $TblPercepcion.'<td '.$style2.' width:16%;">'.$Percepciones[$i][0]."</td>";
        $TblPercepcion = $TblPercepcion.'<td '.$style2.' width:14%;">'.$Percepciones[$i][1]."</td>";
        $TblPercepcion = $TblPercepcion.'<td '.$style2.' width:50%;">'.$Percepciones[$i][2].'</td>';
        $Tmp = $Percepciones[$i][0]; $Tmp = number_format($Percepcion_real, 2, '.', ',');
        $TblPercepcion = $TblPercepcion.'<td '.$style2.' width:20%; text-align: left;">$ '.$Tmp.'</td>';
        
        $TblPercepcion = $TblPercepcion."</tr>";

    }

     
}
$TblPercepcion = $TblPercepcion."</table>";
//echo $TblPercepcion;

//$TblPercepcion = "<table><tr><td>2</td><td>2</td></tr></table>";
$Ctotal = number_format($TotalPercepciones, 2, '.', ',');

//$TblPercepcion = $TblPercepcion."<p style='font-size:14pt;   ' class='TChico'>Total Percepciones mas otros Pagos (".$TotalOtrosPagos.")  ";
$TblPercepcion = $TblPercepcion."<p style='font-size:14pt;   ' class='TChico'>Total Percepciones mas otros Pagos:  ";
$TblPercepcion = $TblPercepcion."<b class='Tmediano'>$".$Ctotal."<b></p>";



// $TblPercepcion = $TblPercepcion."</td>";


// echo "<td valign=top>";
// echo "<table class='tbl_dir'>";
// echo "<tr>";
//     echo "<td align=right>SUBTOTAL:</td><td align=left>"."<b class='TMediano'>$".number_format($TotalPercepciones, 2, '.', ',')."</b>";"</td>";    
// echo "</tr>";

// echo "<tr>";
//     echo "<td align=right>DESCUENTOS:</td><td align=left>"."<b class='TMediano'>$".number_format($TotalDeducciones, 2, '.', ',')."</b>";"</td>";    
// echo "</tr>";

// echo "<tr>";
//     echo "<td align=right>RETENCIONES:</td><td align=left>"."<b class='TMediano'>$".number_format($TotalImpuestosRetenidos, 2, '.', ',')."</b>";"</td>";    
// echo "</tr>";

// echo "<tr>";
//     echo "<td align=right>TOTAL:</td><td align=left>"."<b class='TMediano'>$".number_format($GranTotal, 2, '.', ',')."</b>";"</td>";    
// echo "</tr>";

// echo "<tr>";
// if (is_numeric($TotalOtrosPagos)){
//     echo "<td align=right>Neto del recibo:</td><td align=left>"."<b class='TGrande'>$".number_format($GranTotal + $TotalOtrosPagos, 2, '.', ',')."</b>";"</td>";    
// } else {
//     echo "<td align=right>Neto del recibo:</td><td align=left>"."<b class='TGrande'>$".number_format($GranTotal , 2, '.', ',')."</b>";"</td>";    
// }
    
// echo "</tr>";

// echo "</table>";
// echo "<label>".numtoletras($GranTotal)."</label>";
// echo "</td>";

$Letra = numtoletras($GranTotal);
// echo "</tr>";
// echo "<tr >";
// echo "<td colspan=5 >";

// echo "Sello digital del CFDI: ".$Sello."<br>";
// //echo "Sello SAT: ".$SelloSAT."<br>";
// echo "Version: ".$LVersion."<br>";
// echo "UUID: ".$UUID."<br>";
// echo "Fecha Timbrado: ".$FechaTimbrado."<br>";
// echo "RfcProvCertif: ".$RfcProvCertif."<br>";
// echo "NoCertificadoSAT: ".$NoCertificadoSAT."<br>";

$CadenaOrginal = "||".$LVersion."|".$UUID.$FechaTimbrado."|".$RfcProvCertif."|".$Sello."|".$NoCertificadoSAT."||";
//echo "Cadena Original del complemento del certifición digital del SAT: ".$CadenaOrginal."||";
$rellono_izq= str_pad($GranTotal, 18, "0", STR_PAD_LEFT); 
$GranTotal_vinculo = $rellono_izq."0000";
$ultimos8Sello=  strtoupper(substr($Sello, -8));
//echo "<BR>Ultimos 4 dig del Sello: ".$ultimos8Sello."<br>";

 $QR_link = "https://verificacfdi.facturaelectronica.sat.gob.mx/default.aspx?id=".$UUID."&re=".$rfcxmlem."&rr=".$rfcxmlre."&tt=".$GranTotal_vinculo."&fe=".$ultimos8Sello;
// echo "<a href='".$QR_link."' target=_blank> Validar </a>";

    reporte_pdf($_GET['id'], $rfcxmlem," ".$RegimenFiscal, $LugarExpedicion, $FechaI,$HoraI, $NEmpleado." - ".$nombrexmlre, $rfcxmlre, $Curp, $TipoJornada_descripcion, $f['periodo']." ".$Periodicidad, $DiasdePago, $FechaInicialPago, $FechaFinalPago, $FechaPago, $Puesto, $Departamento, $SalarioBaseCotApor, $CadenaOrginal, $Sello, $SelloSAT, $QR_link, $NoCertificadoSAT, $UUID, $FechaTimbrado, $TblPercepcion, $TblDeducciones, $Letra, $GranTotal ); // llamamos al reporte pdf

}else {
    echo "Sin datos";
}


}




























///------- funcion para generar el reporte de guia -------------------------
function reporte_pdf($id, $ITAVUrfc, $ITAVUregimen, $LugarExpedicion, $Fecha, $Hora, $Empleado, $RfcEmpleado, $CurpEmpleado, $Jornada, $Periodo, $DiasdePago, $FechaInicialPago, $FechaFinalPago, $FechaPago, $Puesto, $Departamento, $SalarioBaseCotApor, $CadenaOrginal, $Sello, $SelloSAT, $QR, $NoCertificadoSAT, $UUID, $FechaTimbrado, $TblPercepcion, $TblDeducciones, $Letra, $GranTotal){
require('config.php');


    require_once('pdf/tcpdf.php');    
    $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
    
    $pdf->setPrintHeader(false);
    $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
    $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
    if (@file_exists(dirname(__FILE__).'pdf/lang/eng.php')) {require_once(dirname(__FILE__).'pdf/lang/eng.php');$pdf->setLanguageArray($l);}
    $pdf->SetFont('dejavusans', '', 7); $pdf->AddPage('P'); //en la tabla de reporte L o P

   

    //VARIABLES DE ESTILOS
    $recuadro = "border: 2px #000000 solid; border-radius:5px; font-size: 28pt; font-weight:bold; padding:10px; width:50%;";
    $recuadro2 = "border: 0px #000000 solid; border-radius:5px; font-size: 14pt; font-weight:bold; padding:10px; width:100%;";
    $recuadro3 = "border: 0px #000000 solid; border-radius:5px; font-size: 12pt;  padding:10px; width:100%;";
    $recuadro4 = "border: 0px #000000 solid; border-radius:5px; font-size: 8pt;  padding:10px; width:100%;";
    $stylebar = array(
        'position' => '',
        'align' => 'C',
        'stretch' => false,
        'fitwidth' => true,
        'cellfitalign' => '',
        'border' => false,
        'hpadding' => 'auto',
        'vpadding' => 'auto',
        'fgcolor' => array(0,0,0),
        'bgcolor' => false, //array(255,255,255),
        'text' => true,
        'font' => 'helvetica',
        'fontsize' => 8,
        'stretchtext' => 40
    );
    $styleqr = array(
        'border' => false,
        'vpadding' => 'auto',
        'hpadding' => 'auto',
        'fgcolor' => array(0,0,0),
        //'bgcolor' => false, //array(255,255,255)
        'bgcolor' => false, //array(255,255,255)
        'module_width' => 1, // width of a single module in points
        'module_height' => 1 // height of a single module in points
    );




    $instrucciones = "
   
    ";
    $url="";
    
        $pdf->SetXY(3, 3);
        //$pdf->Image('img/nomina.jpg', '', '', 308, 400, '', '', 'T', false, 300, '', false, false, 0, false, false, false);    
        $pdf->Image('img/pdf_logo.jpg','5','5','70','15');
        
        

        
        $pdf->SetFont('', 'R', 6, '', 'false');
        $pdf->SetTextColor(103,103,107);
        $pdf->Text(70, 2, 'C o m p r o b a n t e   F i s c a l   D i g i t a l   p o r    I n t e r n e t'); 

        $pdf->SetFont('', 'R', 7, '', 'false');
        $pdf->SetTextColor(103,103,107);
        $pdf->Text(5, 22, 'RFC: '.$ITAVUrfc."   Reg. Fiscal: ".$ITAVUregimen."    Lugar de Expedicion: ".$LugarExpedicion); 

        $pdf->SetFont('', 'R', 7, '', 'false');
        $pdf->SetTextColor(103,103,107);
        $pdf->Text(155, 5, 'Fecha: '.fecha_larga($Fecha)); 
        
        $pdf->SetFont('', 'R', 7, '', 'false');
        $pdf->SetTextColor(103,103,107);
        $pdf->Text(155, 8, 'Hora: '.date("g:ia",strtotime($Hora))); 
        
        $pdf->Image('img/tbl_media.jpg','5','27','200','20');
        $pdf->SetFont('', 'B', 9, '', 'false');
        $pdf->SetTextColor(103,103,107);
        $pdf->Text(5, 29, $Empleado);

        $pdf->SetFont('', 'R', 7, '', 'false');
        $pdf->SetTextColor(103,103,107);
        $pdf->Text(5, 33, "RFC: ".$RfcEmpleado."  CURP: ".$CurpEmpleado);

        $pdf->SetFont('', 'R', 7, '', 'false');
        $pdf->SetTextColor(103,103,107);
        $pdf->Text(5, 36, "Jornada: ".$Jornada);

        $pdf->SetFont('', 'R', 7, '', 'false');
        $pdf->SetTextColor(103,103,107);
        $pdf->Text(5, 40, "Puesto: ".$Puesto);

        $pdf->SetFont('', 'R', 7, '', 'false');
        $pdf->SetTextColor(103,103,107);
        $pdf->Text(5, 43, "Dpto: ".$Departamento);

        $pdf->SetFont('', 'B', 8, '', 'false');
        $pdf->SetTextColor(103,103,107);
        $pdf->Text(103, 29, "Periodo: ".$Periodo." Quincenal". "                    ".$FechaInicialPago. " a ".$FechaFinalPago);

        $pdf->SetFont('', 'R', 7, '', 'false');
        $pdf->SetTextColor(103,103,107);
        $pdf->Text(103, 33, "Días de Pago: ".$DiasdePago);

        
        $pdf->SetFont('', 'R', 7, '', 'false');
        $pdf->SetTextColor(103,103,107);
        $pdf->Text(103, 36, "Fecha de Pago: ".$FechaPago);

        
        
        $pdf->SetFont('', 'R', 7, '', 'false');
        $pdf->SetTextColor(103,103,107);
        $pdf->Text(103, 39, "Salario Base: ".$SalarioBaseCotApor);


        $pdf->SetFont('', 'R', 12, '', 'false');
        $pdf->SetTextColor(103,103,107);
        //$pdf->Text(5, 39, "Importe: $".$GranTotal);
        $GranTotal = number_format($GranTotal, 2, '.', ',');
        $pdf->writeHTMLCell(190, '', '', 210, "Importe $ ".$GranTotal, 0, 0, 0, true, 'C', true);
        
        $pdf->SetFont('', 'I', 9, '', 'false');
        $pdf->SetTextColor(103,103,107);
        //$pdf->Text(5, 39, "Importe: $".$GranTotal);
        $pdf->writeHTMLCell(190, '', '', 215, "(".$Letra.")", 0, 0, 0, true, 'C', true);


          



        $pdf->Image('img/tbl_footer.jpg','5','225','200','50');
          
        
        $pdf->SetFont('', 'R', 7, '', 'false');
        $pdf->SetTextColor(103,103,107);
        $pdf->Text(5, 236, "Sello Digital del CFDI ");

        $pdf->SetFont('', 'R', 6, '', 'false');
        $pdf->SetTextColor(103,103,107); $pdf->SetXY(0, 264);         
        //$pdf->writeHTML(''.$CadenaOrginal, false, false, false, false, 'J');
        $pdf->writeHTMLCell(100, '', '', 240, $Sello, 1, 0, 1, true, 'J', true);

        $pdf->SetFont('', 'R', 7, '', 'false');
        $pdf->SetTextColor(103,103,107);
        $pdf->Text(5, 251, "Sello del SAT: ");

        $pdf->SetFont('', 'R', 6, '', 'false');
        $pdf->SetTextColor(103,103,107); $pdf->SetXY(0, 264);         
        //$pdf->writeHTML(''.$CadenaOrginal, false, false, false, false, 'J');
        $pdf->writeHTMLCell(100, '', '', 256, $SelloSAT, 1, 0, 1, true, 'J', true);


        
        $pdf->SetFont('', 'R', 7, '', 'false');
        $pdf->SetTextColor(103,103,107);
        $pdf->Text(5, 271.6, "Cadena Original del complemento del certificado digital del SAT: ");

        $pdf->SetFont('', 'R', 6, '', 'false');
        $pdf->SetTextColor(103,103,107); //$pdf->SetXY(5, 264);         
        $pdf->writeHTML(''.$CadenaOrginal, false, false, false, false, 'J');


        
        $pdf->write2DBarcode($QR, 'QRCODE,M', 115, 234, 38, 38, $styleqr, 'N'); 
        

                

        $pdf->SetFont('', 'R', 5, '', 'false');
        $pdf->SetTextColor(0,0,0); //$pdf->SetXY(5, 264);         
        $pdf->Text(151, 236.5, "Este documento es una representacion impresa de un CFDI");


        $pdf->SetFont('', 'R', 7, '', 'false');
        $pdf->SetTextColor(103,103,107); //$pdf->SetXY(5, 264);         
        $pdf->Text(156, 239.2, "PUE - Pago en una sola exhibición");
        

        $pdf->SetFont('', 'B', 7, '', 'false');
        $pdf->SetTextColor(103,103,107); //$pdf->SetXY(5, 264);         
        $pdf->Text(152, 242, "Emitido desde CONTPAQi® Nominas");

        $pdf->SetFont('', 'R', 6, '', 'false');
        $pdf->SetTextColor(103,103,107); //$pdf->SetXY(5, 264);         
        $pdf->Text(151.5, 247, "Serie del Certificado del emisor: ");
        $pdf->SetFont('', 'R', 6, '', 'false');
        $pdf->Text(154, 250, $NoCertificadoSAT);

        $pdf->SetFont('', 'R', 6, '', 'false');
        $pdf->SetTextColor(103,103,107); //$pdf->SetXY(5, 264);         
        $pdf->Text(151.5, 253, "Folio Fiscal UUID: ");
        $pdf->SetFont('', 'R', 6, '', 'false');
        $pdf->Text(154, 255.5, $UUID);

        $pdf->SetFont('', 'R', 6, '', 'false');
        $pdf->SetTextColor(103,103,107); //$pdf->SetXY(5, 264);         
        $pdf->Text(151.5, 259, "No. de serie del Certificado del SAT: ");
        $pdf->SetFont('', 'R', 6, '', 'false');
        $pdf->Text(154, 261.5, $NoCertificadoSAT);


        $pdf->SetFont('', 'R', 6, '', 'false');
        $pdf->SetTextColor(103,103,107); //$pdf->SetXY(5, 264);         
        $pdf->Text(151.5, 265, "Fecha y hora de certificación: ");
        $pdf->SetFont('', 'R', 6, '', 'false');
        $pdf->Text(154, 267.5, $FechaTimbrado);


        $pdf->SetFont('', 'I', 7, '', 'false');
        $pdf->SetTextColor(103,103,107); //$pdf->SetXY(5, 264);         
        //$pdf->Text(5, 200, "Fecha y hora de certificación: ");
        $reso ="Se puso a mi disposicion el archivo XML y PDF correspondiente y recibi de la empresa arriba antes mencionada la cantidad neta a qu este documento se refiere, estando conforme con las percepciones y deducciones que en él aparecen especificadas.";
        $pdf->writeHTMLCell(190, '', '', 227, $reso, 1, 0, 1, true, 'C', true);

        $pdf->SetFont('', 'R', 7, '', 'false');
        $pdf->SetTextColor(103,103,107); 
        $pdf->SetXY(10, 50);        
        //$TblPercepcion = "<b style='color:red'>X</b>";
        //$pdf->writeHTMLCell(100, 0, '', '', $TblPercepcion, 1, 1, 1, true, 'L', true); 
      
        
       $pdf->SetFont('', 'R', 8, '', 'false');
        //$pdf->writeHTMLCell($w=0, $h=0, $x='', $y='', $TblPercepcion, $border=0, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);
        $pdf->SetLineStyle(array('width' => 0.1, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(205, 205, 205)));
        $pdf->writeHTMLCell(97, 155, 5, 48, $TblPercepcion, true, 0, 0, false, 'L', true);
        $pdf->writeHTMLCell(102, 155, 103, 48, $TblDeducciones, true, 0, 0, false, 'L', true);
        //$pdf->writeHTML($TblPercepcion, true, false, true, false, '');
        //$pdf->writeHTML(''.$TblPercepcion, true, true, true, true, 'J');
        //$pdf->Text(5, 150, $TblPercepcion);


        

 ///

        
        //date("g:ia",strtotime($hora_));
        
        $pdf->SetXY(0, 40); //codigo de barras  7 digitos EAN8
        //$pdf->write1DBarcode($guia, 'EAN8', '', '', '', 28, 1.1, $stylebar, 'N');
        
        $pdf->SetXY(0, 42); //codigo de barras  7 digitos EAN8
        //  $pdf->write1DBarcode($guia, 'S25+', '', '', '', 24, 0.7, $stylebar, 'N');
        //$pdf->write1DBarcode($guia, 'C39', '', '', '', 24, 0.7, $stylebar, 'N');
        //$pdf->write1DBarcode($guia, 'C93', '', '', '', 24, 0.7, $stylebar, 'N');
        //$pdf->write1DBarcode($guia, 'C128', '', '', '', 24, 0.7, $stylebar, 'N');       
        
        //$pdf->SetFont('', '', 8, '', 'false'); $pdf->Text(10, 40, 'Type Code Bar'. 'C128'); 

        

        

        // if (isset($_GET['notoken'])){

        // }else{
        // $url = $urlsite.'embarques.php?recibir='.$f['guia'].'&guia='.$f['guia'].'&token='.$f['token'].'&descripcion=Registro por codigo QR';
        // $pdf->write2DBarcode($url, 'QRCODE,M', 150, 25, 50, 50, $styleqr, 'N'); 
        // $pdf->Text(150, 20, 'CODIGO DE ENVIO: '.$f['token']);
        // }

        //====== CIUDAD DE ORIGEN ========
        // $origen_ciudad = "Ciudad Victoria, Tam."; //ciudad por default
        // if ($f['origen_tipo']=='del'){//si es del, ponemos la bd
        //     $origen_ciudad = $f['origen_ciudad'];}
        // $pdf->SetFont('', 'B', 12, '', 'false');
        // $pdf->Text(48, 97, ''.$origen_ciudad); 


        
        


        // if ($f['recibido']<>''){
            
        //     $pdf->StartTransform();
        //     $pdf->Rotate(-50);
        //     $pdf->SetTextColor(255,0,0);            
        //     $pdf->SetFont('', 'B', 48, '', 'false');
        //     $pdf->Text(30, 180,'RECIBIDO'); 

        //     $pdf->SetFont('', 'B', 10, '', 'false');            
        //     $pdf->Text(30, 200,$f['recibio_fecha']." ".$f['recibio_hora']." | Empleado No. ".$f['recibido']); 
            
            
        //     //$pdf->Cell(120,10,'RECIBIDO',1,1,'L',0,'');
        //     $pdf->StopTransform();
        // }




    

// PRINT VARIOUS 1D BARCODES

// CODE 39 - ANSI MH10.8M-1983 - USD-3 - 3 of 9.




//$pdf->Text(1, 1, '1,85');

$pdf->lastPage();
$pdf->Output('reporte.pdf', 'I');
}







function guia_proveedor($id){
require("config.php");
$sql = "SELECT * FROM embarques_guias WHERE guia='".$id."'";
$rc= $conexion -> query($sql);
if($f = $rc -> fetch_array())
	{ return $f['paqueteria_id'];} else {return "";}
}




//FUNCIO COMPLEMENTARIA PARA MENSAJE
function mensaje($mensaje, $link){
if ($link=="") {$link = "../index.php";}
$tipo = substr($mensaje, 0,5);    // devuelve "ef"

	

//echo '<div class="padre">';
//echo '<span class="hijo">';
$style_msg = "color: black;
                                                                                                    text-align: center;
                                                                                                    border-radius: 10px;
                                                                                                    border: 2px solid white;
                                                                                                    background-color: white;
                                                                                                    width: 90%;
                                                                                                    position: absolute;
                                                                                                    top: 0%;
                                                                                                    left: 2%;
                                                                                                    right: 0%;
                                                                                                    z-index: 2010;
                                                                                                    opacity: 1;
                                                                                                    padding: 10px;
                                                                                                    margin: 10px;
                                                                                                    margin-top: 100px;
                                                                                                    transition: all 5s cubic-bezier(.46, .03, .52, .96)";
$style_msg_error = "    color: red;
                                                                                                    text-align: center;
                                                                                                    border-radius: 10px;
                                                                                                    border: 2px solid red;
                                                                                                    background-color: white;
                                                                                                    width: 90%;
                                                                                                    position: absolute;
                                                                                                    top: 0%;
                                                                                                    left: 2%;
                                                                                                    right: 0%;
                                                                                                    z-index: 2010;
                                                                                                    opacity: 1;
                                                                                                    padding: 10px;
                                                                                                    margin: 10px;
                                                                                                    margin-top: 100px;
                                                                                                    transition: all 5s cubic-bezier(.46, .03, .52, .96)";
                                                                                                    
		if ($tipo=='ERROR'){echo '<div id="msg_error" style="'.$style_msg_error.'">';}
		else{echo '<div id="mensaje" style="'.$style_msg.'">';}
		echo '<p>'.$mensaje.'</p>';
		echo '<a class="Mbtn btn-default" href="'.$link.'">Aceptar</a>  ';
		//echo '<a class="Mbtn btn-cancel" href="'.$link.'">Cerrar</a>';
		//habla($mensaje);
		echo '</div>';
		
//echo '</span>';
//echo '</div>';

}


function historia($nitavu_, $descripcion){
require("config.php");
//funcion que otorga acceso a las aplicaciones
$sql = "INSERT INTO historia
(nitavu, fecha, hora, descripcion)
VALUES
('$nitavu_', '$fecha', '$hora','$descripcion')";
if ($conexion->query($sql) == TRUE)
{	//echo "ok";
	return 'TRUE';
}
	else
{	//echo $sql;
	return 'FALSE';
}
}


function fecha_larga($fecha_){
//return  dia_semana($fecha_)." ".date('d/m/Y', strtotime($fecha_));
$mes = date('m', strtotime($fecha_));
$mes = (int)$mes -1;
$meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
$mes_largo = $meses[$mes];
$fecha_salida = dia_semana($fecha_)." ".date('d', strtotime($fecha_))." de ".$mes_largo." de ".date('Y', strtotime($fecha_));;

return $fecha_salida;
}
  
function dia_semana($fecha_){
$dias = array('Lunes','Martes','Miercoles','Jueves','Viernes','Sabado','Domingo');
$n= date('N', strtotime($fecha_));
$fecha = $dias[$n-1];
return $fecha;
//return $fecha_;
//return date('N', strtotime($fecha_));
}

function numtoletras($xcifra)
{
    $xarray = array(0 => "Cero",
        1 => "UN", "DOS", "TRES", "CUATRO", "CINCO", "SEIS", "SIETE", "OCHO", "NUEVE",
        "DIEZ", "ONCE", "DOCE", "TRECE", "CATORCE", "QUINCE", "DIECISEIS", "DIECISIETE", "DIECIOCHO", "DIECINUEVE",
        "VEINTI", 30 => "TREINTA", 40 => "CUARENTA", 50 => "CINCUENTA", 60 => "SESENTA", 70 => "SETENTA", 80 => "OCHENTA", 90 => "NOVENTA",
        100 => "CIENTO", 200 => "DOSCIENTOS", 300 => "TRESCIENTOS", 400 => "CUATROCIENTOS", 500 => "QUINIENTOS", 600 => "SEISCIENTOS", 700 => "SETECIENTOS", 800 => "OCHOCIENTOS", 900 => "NOVECIENTOS"
    );
//
    $xcifra = trim($xcifra);
    $xlength = strlen($xcifra);
    $xpos_punto = strpos($xcifra, ".");
    $xaux_int = $xcifra;
    $xdecimales = "00";
    if (!($xpos_punto === false)) {
        if ($xpos_punto == 0) {
            $xcifra = "0" . $xcifra;
            $xpos_punto = strpos($xcifra, ".");
        }
        $xaux_int = substr($xcifra, 0, $xpos_punto); // obtengo el entero de la cifra a covertir
        $xdecimales = substr($xcifra . "00", $xpos_punto + 1, 2); // obtengo los valores decimales
    }

    $XAUX = str_pad($xaux_int, 18, " ", STR_PAD_LEFT); // ajusto la longitud de la cifra, para que sea divisible por centenas de miles (grupos de 6)
    $xcadena = "";
    for ($xz = 0; $xz < 3; $xz++) {
        $xaux = substr($XAUX, $xz * 6, 6);
        $xi = 0;
        $xlimite = 6; // inicializo el contador de centenas xi y establezco el límite a 6 dígitos en la parte entera
        $xexit = true; // bandera para controlar el ciclo del While
        while ($xexit) {
            if ($xi == $xlimite) { // si ya llegó al límite máximo de enteros
                break; // termina el ciclo
            }

            $x3digitos = ($xlimite - $xi) * -1; // comienzo con los tres primeros digitos de la cifra, comenzando por la izquierda
            $xaux = substr($xaux, $x3digitos, abs($x3digitos)); // obtengo la centena (los tres dígitos)
            for ($xy = 1; $xy < 4; $xy++) { // ciclo para revisar centenas, decenas y unidades, en ese orden
                switch ($xy) {
                    case 1: // checa las centenas
                        if (substr($xaux, 0, 3) < 100) { // si el grupo de tres dígitos es menor a una centena ( < 99) no hace nada y pasa a revisar las decenas
                            
                        } else {
                            $key = (int) substr($xaux, 0, 3);
                            if (TRUE === array_key_exists($key, $xarray)){  // busco si la centena es número redondo (100, 200, 300, 400, etc..)
                                $xseek = $xarray[$key];
                                $xsub = subfijo($xaux); // devuelve el subfijo correspondiente (Millón, Millones, Mil o nada)
                                if (substr($xaux, 0, 3) == 100)
                                    $xcadena = " " . $xcadena . " CIEN " . $xsub;
                                else
                                    $xcadena = " " . $xcadena . " " . $xseek . " " . $xsub;
                                $xy = 3; // la centena fue redonda, entonces termino el ciclo del for y ya no reviso decenas ni unidades
                            }
                            else { // entra aquí si la centena no fue numero redondo (101, 253, 120, 980, etc.)
                                $key = (int) substr($xaux, 0, 1) * 100;
                                $xseek = $xarray[$key]; // toma el primer caracter de la centena y lo multiplica por cien y lo busca en el arreglo (para que busque 100,200,300, etc)
                                $xcadena = " " . $xcadena . " " . $xseek;
                            } // ENDIF ($xseek)
                        } // ENDIF (substr($xaux, 0, 3) < 100)
                        break;
                    case 2: // checa las decenas (con la misma lógica que las centenas)
                        if (substr($xaux, 1, 2) < 10) {
                            
                        } else {
                            $key = (int) substr($xaux, 1, 2);
                            if (TRUE === array_key_exists($key, $xarray)) {
                                $xseek = $xarray[$key];
                                $xsub = subfijo($xaux);
                                if (substr($xaux, 1, 2) == 20)
                                    $xcadena = " " . $xcadena . " VEINTE " . $xsub;
                                else
                                    $xcadena = " " . $xcadena . " " . $xseek . " " . $xsub;
                                $xy = 3;
                            }
                            else {
                                $key = (int) substr($xaux, 1, 1) * 10;
                                $xseek = $xarray[$key];
                                if (20 == substr($xaux, 1, 1) * 10)
                                    $xcadena = " " . $xcadena . " " . $xseek;
                                else
                                    $xcadena = " " . $xcadena . " " . $xseek . " Y ";
                            } // ENDIF ($xseek)
                        } // ENDIF (substr($xaux, 1, 2) < 10)
                        break;
                    case 3: // checa las unidades
                        if (substr($xaux, 2, 1) < 1) { // si la unidad es cero, ya no hace nada
                            
                        } else {
                            $key = (int) substr($xaux, 2, 1);
                            $xseek = $xarray[$key]; // obtengo directamente el valor de la unidad (del uno al nueve)
                            $xsub = subfijo($xaux);
                            $xcadena = " " . $xcadena . " " . $xseek . " " . $xsub;
                        } // ENDIF (substr($xaux, 2, 1) < 1)
                        break;
                } // END SWITCH
            } // END FOR
            $xi = $xi + 3;
        } // ENDDO

        if (substr(trim($xcadena), -5, 5) == "ILLON") // si la cadena obtenida termina en MILLON o BILLON, entonces le agrega al final la conjuncion DE
            $xcadena.= " DE";

        if (substr(trim($xcadena), -7, 7) == "ILLONES") // si la cadena obtenida en MILLONES o BILLONES, entoncea le agrega al final la conjuncion DE
            $xcadena.= " DE";

        // ----------- esta línea la puedes cambiar de acuerdo a tus necesidades o a tu país -------
        if (trim($xaux) != "") {
            switch ($xz) {
                case 0:
                    if (trim(substr($XAUX, $xz * 6, 6)) == "1")
                        $xcadena.= "UN BILLON ";
                    else
                        $xcadena.= " BILLONES ";
                    break;
                case 1:
                    if (trim(substr($XAUX, $xz * 6, 6)) == "1")
                        $xcadena.= "UN MILLON ";
                    else
                        $xcadena.= " MILLONES ";
                    break;
                case 2:
                    if ($xcifra < 1) {
                        $xcadena = "CERO PESOS $xdecimales/100 M.N.";
                    }
                    if ($xcifra >= 1 && $xcifra < 2) {
                        $xcadena = "UN PESO $xdecimales/100 M.N. ";
                    }
                    if ($xcifra >= 2) {
                        $xcadena.= " PESOS $xdecimales/100 M.N. "; //
                    }
                    break;
            } // endswitch ($xz)
        } // ENDIF (trim($xaux) != "")
        // ------------------      en este caso, para México se usa esta leyenda     ----------------
        $xcadena = str_replace("VEINTI ", "VEINTI", $xcadena); // quito el espacio para el VEINTI, para que quede: VEINTICUATRO, VEINTIUN, VEINTIDOS, etc
        $xcadena = str_replace("  ", " ", $xcadena); // quito espacios dobles
        $xcadena = str_replace("UN UN", "UN", $xcadena); // quito la duplicidad
        $xcadena = str_replace("  ", " ", $xcadena); // quito espacios dobles
        $xcadena = str_replace("BILLON DE MILLONES", "BILLON DE", $xcadena); // corrigo la leyenda
        $xcadena = str_replace("BILLONES DE MILLONES", "BILLONES DE", $xcadena); // corrigo la leyenda
        $xcadena = str_replace("DE UN", "UN", $xcadena); // corrigo la leyenda
    } // ENDFOR ($xz)
    return trim($xcadena);
}

// END FUNCTION

function subfijo($xx)
{ // esta función regresa un subfijo para la cifra
    $xx = trim($xx);
    $xstrlen = strlen($xx);
    if ($xstrlen == 1 || $xstrlen == 2 || $xstrlen == 3)
        $xsub = "";
    //
    if ($xstrlen == 4 || $xstrlen == 5 || $xstrlen == 6)
        $xsub = "MIL";
    //
    return $xsub;
}

?>