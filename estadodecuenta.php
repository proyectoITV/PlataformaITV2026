<?php
require("config.php");
require_once('seguridad.php');
require_once('lib/funciones.php');
// ob_end_clean();
require('lib/flor_funciones.php');
require_once('pdf/tcpdf.php');

$id_aplicacion ="ap90"; 
$nivel =aplicacion_nivel($id_aplicacion, $nitavu);

if (sanpedro($id_aplicacion, $nitavu)==TRUE){   

$contrato = $_GET['contrato'];
$IdDelegacion = $_GET['del'];
$cancelado=0;

   $t1 = ""; historia($nitavu, 'Consulto el estado de cuenta con numero de contrato'.$contrato);
    // echo  PingDelegacion($IdDelegacion);
   //Paso 1 = Checar disponibilidad de la Delegacion
    if ( PingDelegacion($IdDelegacion) == TRUE){
       
       $sql = "SELECT IdDelegacion,  Delegacion, IdPrograma, Programa, Folio, NumContrato, IdSolicitante, Paterno, Materno, Nombre,
        NombreCompleto, EstadoCivil, SectorCateg, IdMunicipio, Municipio, IdColonia, Colonia,
        seccion, fila, manzana, lote, superficie, eMail, OficioAutorizacion, Facebook,
        Twitter, IdMandante, convert(varchar, FechaContrato, 103) as FechaContrato, NombreDelDesarrollador, IdLote, NumEscritura, Cancelado, 	busqueda_vivienda_informacioncontratos.CURP
        FROM busqueda_vivienda_informacioncontratos WHERE numcontrato = '".$contrato."'";

    // echo $sql;
    $ConsultaDATA = DatosViviendaLarge($IdDelegacion, $nitavu, "EdoCuenta", $sql);
    $array = json_decode($ConsultaDATA, true);
    // var_dump($ConsultaDATA);
    //<td border="1" bgcolor="#E3D79F" align="right" >Fecha de contrato: </td>                      
    //<td bgcolor="#ffffff"><b>'.$value['FechaContrato'].'</b></td>
    if(is_array($array)){            
        foreach ($array as $value) {
            if (isset($value['r'])){// si hay un error
                $t1 = $t1."*Error: ".$value['r'];
                $error = $value['r'];
                sentimental("Sin informacion de este contrato ".$contrato);
            } else {//si no hay errores escribimos

                $CanceladoText = "";
                if ($value['Cancelado']=="True"){
                    $CanceladoText='<b style="font-size:10pt; color:red;">CONTRATO CANCELADO</b>';
                }
                $cancelado = $value['Cancelado'];  $t1 = '';
                $Delegacion = $value['Delegacion'];  $FechaContrato = $value['FechaContrato'];
                $Beneficiario = $value['NombreCompleto'];
                $t1 = $t1.EdoCuentaCancelado($contrato, $IdDelegacion);
                $t1 = $t1.'
                <table width="100%" border="0"  >
                
                    <tr>
                    <td colspan="5" width="44%" align="left" valign="top" style="font-size:7pt;" ><b style="font-size:10pt; color:#67B7E3;">DATOS DEL CONTRATO:</b><br>'.$CanceladoText.'<br>'.'Delegacion:<b>'.$value['Delegacion'].'('.$value['IdDelegacion'].')</b><br>Programa:<b>'.$value['Programa'].'('.$value['IdPrograma'].')</b>                  
                    
                    ';
                    $t1 = $t1."Folio:<b>".$value['Folio']."</b><br>";
                    $t1=$t1.'<br>'.EdoCuentaInfo1($contrato, $IdDelegacion);
                    $t1=$t1.'<br>'.EdoCuentaInfo2($contrato, $IdDelegacion);

                    $t1 = $t1.'</td>';




                    $t1 = $t1.'
                    <td>'.''
                   
                    .'</td>
                    <td colspan="2" width="44%" align="left" valign="top" style="font-size:7pt;" ><b style="font-size:10pt; color:#67B7E3;">DATOS DEL BENEFICIARIO:<br></b>'.
                    
                    '
                    CURP: <b>'.$value['CURP'].'</b>,<br>Municipio:<b>'.$value['Municipio'].'</b>, Colonia:<b>'.$value['Colonia'].'</b><br>Manzana:<b>'.$value['manzana'].'</b>, Lote:<b>'.$value['lote'].'</b><br>';
                    
                    $Domicilio = EdoCuentaDomicilio($contrato, $IdDelegacion, $value['IdPrograma'], $value['Folio']);


                    $t1 = $t1.''.$Domicilio.'<br>';
                    $t1 = $t1.'

                    
                    
                    '.'</td>
                    </tr>
                ';

                $t1 = $t1.'
                
                    
                    ';
                $t1 = $t1.''.EdoCuentaTablaDePagos($contrato, $IdDelegacion,'0', $value['Cancelado']).'';

                $t1 = $t1.'   
                
                <tr>
                    <td colspan="8" valign="top" align="center">';
                    
                    $t1 = $t1.'<table border="0" width=100%> ';
                    $t1 = $t1.'<tr><td valign="top" align="center"  width="32%">  ';
                    $t1 = $t1.EdoCuentaFooter1($contrato, $IdDelegacion, $value['IdPrograma'], $value['Folio']);
                    
                    $t1 = $t1.'</td> <td width="8px" > </td>';
                
                    $t1 = $t1.'<td valign="top" align="center" width="32%">';
                    $t1 = $t1.' '.EdoCuentaFooter2($contrato, $IdDelegacion, $value['IdPrograma'], $value['Folio']);
                    $t1 = $t1.'</td> <td width="8px"> </td>';
                
                    $t1 = $t1.'<td valign="top" align="center" width="34%">';
                    $t1 = $t1.' '.EdoCuentaFooter3($contrato, $IdDelegacion, $value['IdPrograma'], $value['Folio']);
                    $t1 = $t1.'</td><td width="8px"> </td> ';
                
                
                    $t1 = $t1.'</tr> ';
                    $t1 = $t1.'</table> ';
                
                    
                    $t1 = $t1.'       </td>
                
                </tr>

                <tr><td colspan="8">'.EdoCuentaFooter4($contrato, $IdDelegacion, $value['IdPrograma'], $value['Folio']).'</td>
                </tr>
                
                </table>';

                // echo $t1;
                ob_start();
                // $t1='
                
                // <table width="100%" border="1">
                
                //     <tr>
                //     <td width="44%"><p>DATOS DEL CONTRATO</p>
                //     <p>&nbsp;</p></td>
                //     <td width="*">&nbsp;</td>
                //     <td width="44%"><p>DATOS DEL BENEFICIARIO</p>
                //     <p>&nbsp;</p></td>
                //     </tr>
                //     <tr>
                //     <td colspan="3"><p>TABLA DE PAGOS</p>
                //     <p>&nbsp;</p></td>
                //     </tr>
                //     <tr>
                //     <td colspan="3">FOOTER</td>
                //     </tr>
                
                // </table>
                // ';
                $ContratoCancelado = ContratoCancelado($contrato, $IdDelegacion);
                global $string; $string  = EdoCuenta_InfoFooter($contrato, $nitavu, $IdDelegacion,$myip);
                $leyenda = $string;
                
                EdoCuentaPDF($contrato, $string, $Delegacion, $FechaContrato, $Beneficiario, $t1, $ContratoCancelado);

                //PDF<-
            }

        } 
    
    } else {sentimental("Error desde el Webservice de la Delegacion ".$contrato);}


    } else {mensaje("ERROR: Delegacion no disponible en estos momento, intentelo mas tarde. Si Persiste este error, comlibrse con el Dpto. de Informatica","index.php");}


} else {mensaje("Error: No esta autorizado para ver Estados de Cuenta.","index.php");}
?>