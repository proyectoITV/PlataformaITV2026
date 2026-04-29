<?php
//Depuracio de XML Nomina


function XML_FechadeNomina($xmlCont){    
    // $RE_fecha='.*?((?:2|1)\d{3}(?:-|\/)(?:(?:0[1-9])|(?:1[0-2]))(?:-|\/)(?:(?:0[1-9])|(?:[1-2][0-9])|(?:3[0-1]))(?:T|\s)(?:(?:[0-1][0-9])|(?:2[0-3])):(?:[0-5][0-9]):(?:[0-5][0-9]))';
    // preg_match_all("/".$RE_fecha."/is",$xmlCont, $matches);
    // $fechaxmlorig=$matches[1][0];
    // $FechaNomina = substr($fechaxmlorig, 0, 10);
    // return $FechaNomina;
    // unset($matches);


    $RE='<.*?FechaPago="(.*?)".*?>';
    preg_match_all('/'.$RE.'/is',$xmlCont, $matches);
    $FechaPago=implode(", ",$matches[1])."";// Numero de empleado
    //$HoraI = substr($FechaI, 11, 9);    
    return $FechaPago;
    unset($matches);

}

function XML_periodicidad($xmlCont){
$RE='<.*?PeriodicidadPago="(.*?)".*?>';
preg_match_all('/'.$RE.'/is',$xmlCont, $matches);
$Periodicidad=implode(", ",$matches[1])."";// Numero de empleado
//if ($TipoJornada=='01'){$TipoJornada_descripcion=$TipoJornada." Diurna";}
//$HoraI = substr($FechaI, 11, 9);    
return $Periodicidad." Quincenal ";
unset($matches);
}

function XML_Percepciones_Total($xmlCont){
    $RE='<.*?TotalPercepciones="(.*?)".*?>';
    preg_match_all('/'.$RE.'/is',$xmlCont, $matches);
    $TotalPercepciones=implode(", ",$matches[1])."";// Numero de empleado
    //var_dump($TipoDeduccion);
    //if ($TipoJornada=='01'){$TipoJornada_descripcion=$TipoJornada." Diurna";}
    //$HoraI = substr($FechaI, 11, 9);    
    return $TotalPercepciones;
    unset($matches);
}


function XML_SelloSAT($xmlCont){
    $RE='<.*?SelloSAT="(.*?)".*?>';
    preg_match_all('/'.$RE.'/is',$xmlCont, $matches);
    $SelloSAT=implode(", ",$matches[1])."";// Numero de empleado
    //var_dump($TipoDeduccion);
    //if ($TipoJornada=='01'){$TipoJornada_descripcion=$TipoJornada." Diurna";}
    //$HoraI = substr($FechaI, 11, 9);    
    return $SelloSAT;
    unset($matches);
}
function XML_ImpuestosRetenidos_Total($xmlCont){
    $RE='<.*?TotalImpuestosRetenidos="(.*?)".*?>';
    preg_match_all('/'.$RE.'/is',$xmlCont, $matches);
    $TotalImpuestosRetenidos=implode(", ",$matches[1])."";// Numero de empleado
    //var_dump($TipoDeduccion);
    //if ($TipoJornada=='01'){$TipoJornada_descripcion=$TipoJornada." Diurna";}
    //$HoraI = substr($FechaI, 11, 9);    
    unset($matches);
    return $TotalImpuestosRetenidos;
}

function XML_Deducciones_Total($xmlCont){
    $RE='<.*?TotalDeducciones="(.*?)".*?>';
    preg_match_all('/'.$RE.'/is',$xmlCont, $matches);
    $TotalDeducciones=implode(", ",$matches[1])."";// Numero de empleado
    //var_dump($TipoDeduccion);
    //if ($TipoJornada=='01'){$TipoJornada_descripcion=$TipoJornada." Diurna";}
    //$HoraI = substr($FechaI, 11, 9);    
    unset($matches);
    return $TotalDeducciones;
}



function XML_Deducciones_TotalOtrasDeducciones($xmlCont){
    $RE='<.*?TotalOtrasDeducciones="(.*?)".*?>';
    preg_match_all('/'.$RE.'/is',$xmlCont, $matches);
    $TotalDeducciones=implode(", ",$matches[1])."";// Numero de empleado
    //var_dump($TipoDeduccion);
    //if ($TipoJornada=='01'){$TipoJornada_descripcion=$TipoJornada." Diurna";}
    //$HoraI = substr($FechaI, 11, 9);    
    unset($matches);
    return $TotalDeducciones;
}


function XML_SalarioBase($xmlCont){
    
    $RE='<.*?SalarioBaseCotApor="(.*?)".*?>'; //VARIABLE NUEVA, se obtiene del xml de la bd
    preg_match_all('/'.$RE.'/is',$xmlCont, $matches);
    $SalarioBaseCotApor=implode(", ",$matches[1])."";// Numero de empleado
    //var_dump($TipoDeduccion);
    //if ($TipoJornada=='01'){$TipoJornada_descripcion=$TipoJornada." Diurna";}
    //$HoraI = substr($FechaI, 11, 9);    
    unset($matches);
    return $SalarioBaseCotApor;
}
function XML_Departamento($xmlCont){
    $RE='<.*?Departamento="(.*?)".*?>';
    preg_match_all('/'.$RE.'/is',$xmlCont, $matches);
    $Departamento=implode(", ",$matches[1])."";// Numero de empleado
    //if ($TipoJornada=='01'){$TipoJornada_descripcion=$TipoJornada." Diurna";}
    //$HoraI = substr($FechaI, 11, 9);    
    return $Departamento;
    unset($matches);
}

function XML_FechaEmision($xmlCont){        
    // $RE_fecha='.*?((?:2|1)\d{3}(?:-|\/)(?:(?:0[1-9])|(?:1[0-2]))(?:-|\/)(?:(?:0[1-9])|(?:[1-2][0-9])|(?:3[0-1]))(?:T|\s)(?:(?:[0-1][0-9])|(?:2[0-3])):(?:[0-5][0-9]):(?:[0-5][0-9]))';
   $RE_fecha='.*?((?:2|1)\d{3}(?:-|\/)(?:(?:0[1-9])|(?:1[0-2]))(?:-|\/)(?:(?:0[1-9])|(?:[1-2][0-9])|(?:3[0-1]))(?:T|\s)(?:(?:[0-1][0-9])|(?:2[0-3])):(?:[0-5][0-9]):(?:[0-5][0-9]))';
    preg_match_all("/".$RE_fecha."/is",$xmlCont, $matches);
    $fechaxmlorig=$matches[1][0];
    $FechaNomina = substr($fechaxmlorig, 0, 10);
    return $FechaNomina;
    unset($matches);

    
}

function XML_RegimenFiscal($xmlCont){
    $RE_RFiscal='<.*?RegimenFiscal="(.*?)".*?>';
    preg_match_all('/'.$RE_RFiscal.'/is',$xmlCont, $matches);
    // var_dump($matches);
    $RegimenFiscal=implode(", ",$matches[1]). "603 - Personas Morales con Fines no Lucrativos"; //para otros, catalago de regimenes fiscales, ya que solo sa el ID en este caso 603
    return  $RegimenFiscal;
    unset($matches);
}

function XML_FechayLugarEmision($xmlCont){
    $RE='<.*?LugarExpedicion="(.*?)".*?>';
    preg_match_all('/'.$RE.'/is',$xmlCont, $matches);
    $LugarExpedicion=implode(", ",$matches[1])." CIUDAD VICTORIA";//da el CP; para otros poner lista de CP
    unset($matches);




    return $LugarExpedicion." - ".XML_FechaEmision($xmlCont);

}
function XML_DiasDePago($xmlCont){
    $RE='<.*?NumDiasPagados="(.*?)".*?>';
    preg_match_all('/'.$RE.'/is',$xmlCont, $matches);
    $DiasdePago=implode(", ",$matches[1])."";// Numero de empleado
    //if ($TipoJornada=='01'){$TipoJornada_descripcion=$TipoJornada." Diurna";}
    //$HoraI = substr($FechaI, 11, 9);    
    return $DiasdePago;
    unset($matches);
}

function XML_Jornada($xmlCont){
    $RE='<.*?TipoJornada="(.*?)".*?>';
    preg_match_all('/'.$RE.'/is',$xmlCont, $matches);
    $TipoJornada=implode(", ",$matches[1])."";// Numero de empleado
    if ($TipoJornada=='01'){$TipoJornada_descripcion=$TipoJornada." Diurna";} else {
        $TipoJornada_descripcion="Nocturna";
    }
    //$HoraI = substr($FechaI, 11, 9);    
    return $TipoJornada."".$TipoJornada_descripcion;
    unset($matches);
}


function XML_Percepciones($xmlCont){
    
    $RE='<.*?TipoPercepcion.*?Clave="(.*?)".*?>';
    preg_match_all('/'.$RE.'/is',$xmlCont, $TipoPercepcion_clave);
    // $TipoDeduccion=implode(", ",$matches[1])."";// Numero de empleado
    //var_dump($TipoDeduccion);
    //if ($TipoJornada=='01'){$TipoJornada_descripcion=$TipoJornada." Diurna";}
    //$HoraI = substr($FechaI, 11, 9);    
    unset($matches);


    $RE='<.*?TipoPercepcion.*?Concepto="(.*?)".*?>';
    preg_match_all('/'.$RE.'/is',$xmlCont, $Conceptos);
    unset($matches);

    $RE='<.*?TipoPercepcion.*?ImporteGravado="(.*?)".*?>';
    preg_match_all('/'.$RE.'/is',$xmlCont, $Importes);
    unset($matches);

    $RE='<.*?TipoPercepcion.*?ImporteExento="(.*?)".*?>';
    preg_match_all('/'.$RE.'/is',$xmlCont, $ImportesExento);
    unset($matches);




    // var_dump($Importes);

    $RE='<.*?TipoPercepcion.*?="(.*?)".*?>';
    preg_match_all('/'.$RE.'/is',$xmlCont, $RTipos);    
    unset($matches);
    // var_dump($Resultado);


        // var_dump($TipoPercepcion_clave);
        $tblPercepciones='<table border=0 width="100%" >';
        $tblPercepciones.='<tr bgcolor="#015CA2" style="color:#FFFFFF; font-size:6pt;"><td >Clave:</td><td>Tipo</td><td>Concepto</td><td>Importe</td><td>Excento</td></tr>';
        $array = $TipoPercepcion_clave;
        reset($array); //con CLAVE
        $Indice=0;
        foreach ($array[1] as $key => $value) 
        { 
                // echo strval($key)."=".strval($value)."<br>";
                // echo "<br>{$key} => {$value}";
                
                if ($Indice%2==0){
                    $tblPercepciones.='<tr><td bgcolor="#E8F2F4" style="color:#111111; font-size:6pt; text-align:left;">'.$value.'</td>';
                } else {
                    $tblPercepciones.='<tr><td bgcolor="#DCECEF" style="color:#111111; font-size:6pt; text-align:left;">'.$value.'</td>';

                }

                foreach ($RTipos[1] as $keyTipos => $valueTipos) 
                { 
                        // echo strval($key)."=".strval($value)."<br>";
                        // echo "<br>{$key} => {$value}";
                        // $td_Tipos.='<td>'.$value.'</td>';
                        if ($keyTipos == $Indice){
                            if ($Indice%2==0){
                                $tblPercepciones.='<td  bgcolor="#E8F2F4" style="color:#111111; font-size:6pt; text-align:left;">'.$valueTipos.'</td>';
                            } else {
                                $tblPercepciones.='<td  bgcolor="#DCECEF" style="color:#111111; font-size:6pt; text-align:left;">'.$valueTipos.'</td>';

                            }
                        }
                }

                foreach ($Conceptos[1] as $KeyConcepto => $Concepto) 
                { 
                        // echo strval($key)."=".strval($value)."<br>";
                        // echo "<br>{$key} => {$value}";
                        // $td_Tipos.='<td>'.$value.'</td>';
                        if ($KeyConcepto == $Indice){
                            if ($Indice%2==0){
                                $tblPercepciones.='<td bgcolor="#E8F2F4" style="color:#111111; font-size:6pt; text-align:left;">'.$Concepto.'</td>';
                            } else {
                                $tblPercepciones.='<td bgcolor="#DCECEF" style="color:#111111; font-size:6pt; text-align:left;">'.$Concepto.'</td>';

                            }
                        }
                }


                foreach ($Importes[1] as $KeyI => $Importe) 
                { 
                        // echo strval($key)."=".strval($value)."<br>";
                        // echo "<br>{$key} => {$value}";
                        // $td_Tipos.='<td>'.$value.'</td>';
                        if ($KeyI == $Indice){
                            if ($Indice%2==0){
                                $tblPercepciones.='<td bgcolor="#E8F2F4" style="color:#111111; font-size:6pt; text-align:right;">'.Pesos($Importe).'</td>';
                            } else {
                                $tblPercepciones.='<td bgcolor="#DCECEF" style="color:#111111; font-size:6pt; text-align:right;">'.Pesos($Importe).'</td>';
                            }
                        }
                }

                foreach ($ImportesExento[1] as $KeyIe => $Importee) 
                { 
                        // echo strval($key)."=".strval($value)."<br>";
                        // echo "<br>{$key} => {$value}";
                        // $td_Tipos.='<td>'.$value.'</td>';
                        if ($KeyIe == $Indice){
                            
                            if ($Indice%2==0){
                                $tblPercepciones.='<td bgcolor="#E8F2F4" style="color:#111111; font-size:6pt; text-align:right;">'.Pesos($Importee).'</td></tr>';
                            } else {
                                $tblPercepciones.='<td bgcolor="#DCECEF" style="color:#111111; font-size:6pt; text-align:right;">'.Pesos($Importee).'</td></tr>';
                            }
                            
                            
                        }
                }
                


               
               
        $Indice = $Indice +1;
        } 
        $tblPercepciones.='</table><br>';
        $Total=XML_Percepciones_Total($xmlCont);
        
        $tblPercepciones.='<table border=0 width="100%" >';
        $tblPercepciones.='<tr bgcolor="#015CA2" style="color:#FFFFFF; font-size:8pt;"><td >Total de percepciones, mas otros pagos:</td><td>'.Pesos($Total).'</td></tr></table>';
        
        
        unset($array,$key,$value);
        

        // echo $tblPercepciones;
        return $tblPercepciones;



        
}



function XML_Deducciones($xmlCont){
    
    $RE='<.*?TipoDeduccion.*?Clave="(.*?)".*?>';
    preg_match_all('/'.$RE.'/is',$xmlCont, $TipoPercepcion_clave);
    // $TipoDeduccion=implode(", ",$matches[1])."";// Numero de empleado
    //var_dump($TipoDeduccion);
    //if ($TipoJornada=='01'){$TipoJornada_descripcion=$TipoJornada." Diurna";}
    //$HoraI = substr($FechaI, 11, 9);    
    unset($matches);


    $RE='<.*?TipoDeduccion.*?Concepto="(.*?)".*?>';
    preg_match_all('/'.$RE.'/is',$xmlCont, $Conceptos);
    unset($matches);

    $RE='<.*?TipoDeduccion.*?Importe="(.*?)".*?>';
    preg_match_all('/'.$RE.'/is',$xmlCont, $Importes);
    unset($matches);

  



    // var_dump($Importes);

    $RE='<.*?TipoDeduccion.*?="(.*?)".*?>';
    preg_match_all('/'.$RE.'/is',$xmlCont, $RTipos);    
    unset($matches);
    // var_dump($Resultado);


        // var_dump($TipoPercepcion_clave);
        $tblPercepciones='<table border=0 width="100%" >';
        $tblPercepciones.='<tr bgcolor="#D96D00" style="color:#FFFFFF; font-size:6pt;"><td >Clave:</td><td>Tipo</td><td>Concepto</td><td>Importe</td></tr>';
        $array = $TipoPercepcion_clave;
        reset($array); //con CLAVE
        $Indice=0;
        foreach ($array[1] as $key => $value) 
        { 
                // echo strval($key)."=".strval($value)."<br>";
                // echo "<br>{$key} => {$value}";
                
                if ($Indice%2==0){
                    $tblPercepciones.='<tr><td bgcolor="#FFF8E1" style="color:#111111; font-size:6pt; text-align:center;">'.$value.'</td>';
                } else {
                    $tblPercepciones.='<tr><td bgcolor="#FFE3B9" style="color:#111111; font-size:6pt; text-align:center;">'.$value.'</td>';

                }

                foreach ($RTipos[1] as $keyTipos => $valueTipos) 
                { 
                        // echo strval($key)."=".strval($value)."<br>";
                        // echo "<br>{$key} => {$value}";
                        // $td_Tipos.='<td>'.$value.'</td>';
                        if ($keyTipos == $Indice){
                            if ($Indice%2==0){
                                $tblPercepciones.='<td  bgcolor="#FFF8E1" style="color:#111111; font-size:6pt; text-align:left;">'.$valueTipos.'</td>';
                            } else {
                                $tblPercepciones.='<td  bgcolor="#FFE3B9" style="color:#111111; font-size:6pt; text-align:left;">'.$valueTipos.'</td>';

                            }
                        }
                }

                foreach ($Conceptos[1] as $KeyConcepto => $Concepto) 
                { 
                        // echo strval($key)."=".strval($value)."<br>";
                        // echo "<br>{$key} => {$value}";
                        // $td_Tipos.='<td>'.$value.'</td>';
                        if ($KeyConcepto == $Indice){
                            if ($Indice%2==0){
                                $tblPercepciones.='<td bgcolor="#FFF8E1" style="color:#111111; font-size:6pt; text-align:left;">'.$Concepto.'</td>';
                            } else {
                                $tblPercepciones.='<td bgcolor="#FFE3B9" style="color:#111111; font-size:6pt; text-align:left;">'.$Concepto.'</td>';

                            }
                        }
                }


                foreach ($Importes[1] as $KeyI => $Importe) 
                { 
                        // echo strval($key)."=".strval($value)."<br>";
                        // echo "<br>{$key} => {$value}";
                        // $td_Tipos.='<td>'.$value.'</td>';
                        if ($KeyI == $Indice){
                            if ($Indice%2==0){
                                $tblPercepciones.='<td bgcolor="#FFF8E1" style="color:#111111; font-size:6pt; text-align:right;">'.Pesos($Importe).'</td></tr>';
                            } else {
                                $tblPercepciones.='<td bgcolor="#FFE3B9" style="color:#111111; font-size:6pt; text-align:right;">'.Pesos($Importe).'</td></tr>';
                            }
                        }
                }

               
                


               
               
        $Indice = $Indice +1;
        } 
        $tblPercepciones.='</table><br>';
        
        
        $tblPercepciones.='<table border=0 width="100%" >';
        $tblPercepciones.='<tr bgcolor="#D96D00" style="color:#FFFFFF; font-size:8pt;"><td >Total de las deducciones:</td><td>'.Pesos(XML_Deducciones_TotalOtrasDeducciones($xmlCont)).'</td></tr></table>';
        
        
        unset($array,$key,$value);
        

        // echo $tblPercepciones;
        return $tblPercepciones;



        
}

function XML_FechaInicioLaboral($xmlCont){
    // FechaInicioRelLaboral
    $RE='<.*? FechaInicioRelLaboral="(.*?)".*?>';
    preg_match_all('/'.$RE.'/is',$xmlCont, $matches);
    $IL=implode(", ",$matches[1])."";// Numero de empleado
    //$HoraI = substr($FechaI, 11, 9);    
    return $IL;
    unset($matches);
}

function XML_CurpEmpleado($xmlCont){
    $RE='<.*?Curp="(.*?)".*?>';
    preg_match_all('/'.$RE.'/is',$xmlCont, $matches);
    $Curp=implode(", ",$matches[1])."";// Numero de empleado
    //$HoraI = substr($FechaI, 11, 9);    
    return $Curp;
    unset($matches);
}

function XML_Sello($xmlCont){
    $RE='<.*?Sello="(.*?)".*?>';
    preg_match_all('/'.$RE.'/is',$xmlCont, $matches);
    $Sello=implode(", ",$matches[1])."";// Numero de empleado
    return $Sello;
}

function XML_GranTotal($xmlCont){
    
    $RE='<.*?Descuento.*?Total="(.*?)".*?>';
    preg_match_all('/'.$RE.'/is',$xmlCont, $matches);
    $GranTotal=implode(", ",$matches[1])."";// Numero de empleado
    return $GranTotal;
}
function XML_RFCEmpleado($xmlCont){
    // $RE_receptor='<.*?Receptor.*?"(.*?)"';
    $RE_receptor='<.*?Receptor.*?Rfc="(.*?)"';
    preg_match_all('/'.$RE_receptor.'/is',$xmlCont, $matches);
    $rfcxmlre=$matches[1][0]; // RFC del receptor
    return $rfcxmlre;
    unset($matches);

}

function XML_Cadena($xmlCont){
    $RE='<.*?TimbreFiscalDigitalv11.*?Version="(.*?)".*?>';
    preg_match_all('/'.$RE.'/is',$xmlCont, $matches);
    $LVersion=implode(", ",$matches[1])."";// Numero de empleado
    //var_dump($TipoDeduccion);
    //if ($TipoJornada=='01'){$TipoJornada_descripcion=$TipoJornada." Diurna";}
    //$HoraI = substr($FechaI, 11, 9);    
    unset($matches);

    $UUID = XML_UUID($xmlCont);
    $FechaTimbrado = XML_FechaTimbrado($xmlCont);


    $RE='<.*?RfcProvCertif="(.*?)".*?>';
    preg_match_all('/'.$RE.'/is',$xmlCont, $matches);
    $RfcProvCertif=implode(", ",$matches[1])."";// Numero de empleado
    //var_dump($TipoDeduccion);
    //if ($TipoJornada=='01'){$TipoJornada_descripcion=$TipoJornada." Diurna";}
    //$HoraI = substr($FechaI, 11, 9);    
    unset($matches);

    $Sello = XML_Sello($xmlCont);

    $RE='<.*?NoCertificadoSAT="(.*?)".*?>';
    preg_match_all('/'.$RE.'/is',$xmlCont, $matches);
    $NoCertificadoSAT=implode(", ",$matches[1])."";// Numero de empleado
    //var_dump($TipoDeduccion);
    //if ($TipoJornada=='01'){$TipoJornada_descripcion=$TipoJornada." Diurna";}
    //$HoraI = substr($FechaI, 11, 9);    
    unset($matches);

    
    $CadenaOrginal = "||".$LVersion."|".$UUID.$FechaTimbrado."|".$RfcProvCertif."|".$Sello."|".$NoCertificadoSAT;

    return $CadenaOrginal;
}
function XML_FechaTimbrado($xmlCont){
    $RE='<.*?FechaTimbrado="(.*?)".*?>';
    preg_match_all('/'.$RE.'/is',$xmlCont, $matches);
    $FechaTimbrado=implode(", ",$matches[1])."";// Numero de empleado
    //var_dump($TipoDeduccion);
    //if ($TipoJornada=='01'){$TipoJornada_descripcion=$TipoJornada." Diurna";}
    //$HoraI = substr($FechaI, 11, 9);   
    return  $FechaTimbrado; 
    unset($matches);

}
function XML_NoCer($xmlCont){
    $RE='<.*?NoCertificado="(.*?)".*?>';
    preg_match_all('/'.$RE.'/is',$xmlCont, $matches);
    $NoCertificadoSAT=implode(", ",$matches[1])."";// Numero de empleado
    //var_dump($TipoDeduccion);
    //if ($TipoJornada=='01'){$TipoJornada_descripcion=$TipoJornada." Diurna";}
    //$HoraI = substr($FechaI, 11, 9);    
    return $NoCertificadoSAT;
    unset($matches);
}
function XML_Cer($xmlCont){
    $RE='<.*?NoCertificadoSAT="(.*?)".*?>';
    preg_match_all('/'.$RE.'/is',$xmlCont, $matches);
    $NoCertificadoSAT=implode(", ",$matches[1])."";// Numero de empleado
    //var_dump($TipoDeduccion);
    //if ($TipoJornada=='01'){$TipoJornada_descripcion=$TipoJornada." Diurna";}
    //$HoraI = substr($FechaI, 11, 9);    
    return $NoCertificadoSAT;
    unset($matches);
}
function XML_UUID($xmlCont){
    $RE='<.*?UUID="(.*?)".*?>';
    preg_match_all('/'.$RE.'/is',$xmlCont, $matches);
    $UUID=implode(", ",$matches[1])."";// Numero de empleado
    return $UUID;
    //var_dump($TipoDeduccion);
    //if ($TipoJornada=='01'){$TipoJornada_descripcion=$TipoJornada." Diurna";}
    //$HoraI = substr($FechaI, 11, 9);    
    unset($matches);
}
function XML_FechaInicial($xmlCont){
    $RE='<.*?FechaInicialPago="(.*?)".*?>';
    preg_match_all('/'.$RE.'/is',$xmlCont, $matches);
    $FechaInicialPago=implode(", ",$matches[1])."";// 
    //$HoraI = substr($FechaI, 11, 9);    
    return $FechaInicialPago;
    unset($matches);

}

function XML_FechaFinal($xmlCont){
    $RE='<.*?FechaFinalPago="(.*?)".*?>';
    preg_match_all('/'.$RE.'/is',$xmlCont, $matches);
    $FechaFinalPago=implode(", ",$matches[1])."";// 
    //$HoraI = substr($FechaI, 11, 9);    
    return $FechaFinalPago;
    unset($matches);
}


function XML_IdEmpleado($xmlCont){
    $RE='<.*?NumEmpleado="(.*?)".*?>';
    preg_match_all('/'.$RE.'/is',$xmlCont, $matches);
    $NEmpleado=implode(", ",$matches[1])."";// Numero de empleado
    //$HoraI = substr($FechaI, 11, 9);    
    $PrimerCaracter = substr($NEmpleado, 0, 1);
    $SegundoCaracter = substr($NEmpleado, 0, 2);
    $TercerCaracter = substr($NEmpleado, 0, 3);
    // echo "Primer caracter = ".$PrimerCaracter;
    $IdEmpleado = "";
    if ($PrimerCaracter == '0'){        
        $RestoDelNEmpleado = substr($NEmpleado, 1, 20);
        if ($SegundoCaracter == '0'){        
            $RestoDelNEmpleado = substr($NEmpleado, 2, 20);        
            if ($TercerCaracter == '0'){        
                $RestoDelNEmpleado = substr($NEmpleado, 3, 20);        
            }
            
        }
        
        $IdEmpleado = $RestoDelNEmpleado;
    } else {
        $IdEmpleado = $NEmpleado;
    }
    return $IdEmpleado;
    unset($matches);
}

function InicioLaboral_update($nitavu, $Dato){    
        require("config.php");
        $sql = "UPDATE empleados SET	
        iniciolaboral = '".$Dato."'	
        WHERE nitavu = '".$nitavu."'";
        
        if ($conexion->query($sql) == TRUE){        
            return TRUE;	
        }
        else {
            return FALSE;
        }
    
}

function CurpUpdate($nitavu, $Dato){    
    require("config.php");
    $sql = "UPDATE empleados SET	
    curp = '".$Dato."'	
    WHERE nitavu = '".$nitavu."'";
    
    if ($conexion->query($sql) == TRUE){        
        return TRUE;	
    }
    else {
        return FALSE;
    }

}


function RFCUpdate($nitavu, $Dato){    
    require("config.php");
    $sql = "UPDATE empleados SET	
    rfc = '".$Dato."'	
    WHERE nitavu = '".$nitavu."'";
    
    if ($conexion->query($sql) == TRUE){        
        return TRUE;	
    }
    else {
        return FALSE;
    }

}



function Sueldo_update($nitavu, $Dato){    
    require("config.php");
    $sql = "UPDATE empleados SET	
    sueldo = '".$Dato."'	
    WHERE nitavu = '".$nitavu."'";
    
    if ($conexion->query($sql) == TRUE){        
        return TRUE;	
    }
    else {
        return FALSE;
    }

}



function Deducciones_update($nitavu, $Dato){    
    require("config.php");
    $sql = "UPDATE empleados SET	
    deducciones = '".$Dato."'	
    WHERE nitavu = '".$nitavu."'";
    
    if ($conexion->query($sql) == TRUE){        
        return TRUE;	
    }
    else {
        return FALSE;
    }

}


function ImpuestosRetenidos_update($nitavu, $Dato){    
    require("config.php");
    $sql = "UPDATE empleados SET	
    impuestosretenidos = '".$Dato."'	
    WHERE nitavu = '".$nitavu."'";
    
    if ($conexion->query($sql) == TRUE){        
        return TRUE;	
    }
    else {
        return FALSE;
    }

}

?>