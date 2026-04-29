<?php
require_once('pdf/tcpdf.php');
require("config.php");
require_once('/seguridad.php');
require_once('lib/funciones.php');
require('lib/flor_funciones.php');



$contrato = $_GET['contrato'];
$IdDelegacion = $_GET['del'];


$cancelado=0;



$t1 = "";

    historia($nitavu, 'Consulto el estado de cuenta con numero de contrato'.$contrato);

   $sql = "SELECT IdDelegacion,  Delegacion, IdPrograma, Programa, Folio, NumContrato, IdSolicitante, Paterno, Materno, Nombre,
   NombreCompleto, EstadoCivil, SectorCateg, IdMunicipio, Municipio, IdColonia, Colonia,
   seccion, fila, manzana, lote, superficie, eMail, OficioAutorizacion, Facebook,
   Twitter, IdMandante, convert(varchar, FechaContrato, 103) as FechaContrato, NombreDelDesarrollador, IdLote, NumEscritura, Cancelado
   FROM busqueda_vivienda_informacioncontratos WHERE numcontrato = '".$contrato."'";

    //echo $sql;
    $ConsultaDATA = DatosViviendaLarge($IdDelegacion, "WSContratos", "Test", $sql);
    $array = json_decode($ConsultaDATA, true);
    //<td border="1" bgcolor="#E3D79F" align="right" >Fecha de contrato: </td>                      
    //<td bgcolor="#ffffff"><b>'.$value['FechaContrato'].'</b></td>
    if(is_array($array)){            
        foreach ($array as $value) {
            if (isset($value['r'])){// si hay un error
                $t1 = $t1."*Error: ".$value['r'];
                $error = $value['r'];

                echo "<center>";
                echo "<div style='width: 40%; border: 2px solid #FFFF0F; display: inline-block; background-color: #FFFFBF; border-radius: 10px; margin: 10px; padding: 10px;'>";
                    echo "<table border='0'>";
                    echo "<tr>";
                    echo "<td width='50px' align='left' valign='middle'><img src='icon/404.png'></td>";
                    echo "<td align='center'  valign='middle' style=' color: #FF9900;  font-family: Verdana;'>No se ha encontrado información sobre este contrato: ".$contrato."</td>";
                    echo "</tr>";
                    echo "</table>";
                echo "</div>";
                echo "</center>";
            } else {//si no hay errores escribimos
                $cancelado = $value['Cancelado'];
                $t1 = '
                <p align = "center"  style="text-align:center; font-size:12px;">
                <b>INSTITUTO TAMAULIPECO DE VIVIENDA Y URBANISMO</b><br>
                ESTADO DE CUENTA<br>
                </p>
                ';
                $t1 = $t1.'
                <table frame="above">
                    <tr>
                        <td>
                        </td>
                        <td>
                        </td>
                        <td>
                            <table>
                                <tr>
                                    <td bgcolor="#E3D79F" align="right">Delegación:</td>
                                    <td bgcolor="#ffffff"><b>   '.$value['Delegacion'].'</b></td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td>
                        </td>
                        <td>
                        </td>
                        <td>
                            <table>
                                <tr>
                                <td bgcolor="#E3D79F" align="right">Número contrato: </td>
                                <td bgcolor="#ffffff"><b>   '.$contrato.'</b></td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
                    
    
                <table>
                    <tr>
                        <td border="1" bgcolor="#484848" style="color:white; height:5px; border-top-right-radius:10px; border-top-left-radius: 10px;">
                            
                                  DATOS DEL BENEFICIARIO
                            
                        </td>
                        <td border="0"></td>

                        <td>
                            <table frame="below">
                                <tr>
                                <td bgcolor="#E3D79F" align="right" >Fecha de contrato: </td>
                                <td bgcolor="#ffffff"><b>   '.$value['FechaContrato'].                              
                                
                                '</b></td>
                                </tr>
                            </table>
                        </td>
                                       
                        
                    </tr>
                    <tr border="1">
                        <td border="1" colspan="3" > Nombre: '.$value['NombreCompleto'].'';
                        
                        /*$sql2 = "SELECT isnull(Calle1,'') as Calle1, isnull(Calle2,'') as Calle2, isnull(CalleyNum,'') as CalleyNum, isnull(IdColonia,'') as IdColonia FROM datosdomicilio
                        WHERE (IdDelegacion = ".$value['IdDelegacion'].") AND (IdPrograma = ".$value['IdPrograma'].") AND (Folio = ".$value['Folio'].")";*/
                        $sql2 = "SELECT isnull(datosdomicilio.Calle1,'') as Calle1, isnull(datosdomicilio.Calle2,'') as Calle2,
                        isnull(datosdomicilio.CalleyNum,'') as CalleyNum,
                        isnull(datosdomicilio.IdColonia,'') as IdColonia, isnull(colonias.colonia,'') as Colonia
                        FROM datosdomicilio 
                        inner join colonias on colonias.IdColonia=datosdomicilio.IdColonia
                        WHERE (IdDelegacion = ".$value['IdDelegacion'].") AND (IdPrograma = ".$value['IdPrograma'].") AND (Folio = ".$value['Folio'].")";
                       // echo $sql2.'<br>';
                         $ConsultaDATA = DatosViviendaLarge($IdDelegacion, "WSContratos", "Test", $sql2);
                         $array = json_decode($ConsultaDATA, true);
                     
                         if(is_array($array)){            
                             foreach ($array as $value) {
                                 if (isset($value['r'])){// si hay un error
                                     $t1 = $t1."*Error: ".$value['r'];
                                     $error = $value['r'];
                                 } else {//si no hay errores escribimos
                                    $t1= $t1.'<br> Domicilio: '.$value['CalleyNum'].' '.$value['Calle1'].' '.$value['Calle2'].'  
                                    <br> Colonia: '.$value['Colonia'].'<br> </td> </tr>
                                    </table>
                                       ';
                                 }
                            }
                        }

                        $t1=$t1.'
                        <table>
                            <tr>
                                <td border="1" bgcolor="#484848" style="color:white; height:5px; border-top-right-radius:10px; border-top-left-radius: 10px;">  DATOS DEL CONTRATO </td>
                                <td></td>
                                <td></td>
                            </tr>
                            <tr>
                            <td colspan="3" border="1">  
                           ';
                $sql3 = "SELECT IdDelegacion, Delegacion, IdPrograma,  Programa,  Folio, NumContrato, IdSolicitante, Paterno, Materno, Nombre,
                NombreCompleto, EstadoCivil, SectorCateg, IdMunicipio,  Municipio, IdColonia, Colonia,
                seccion, fila, manzana, lote, superficie, eMail, OficioAutorizacion, Facebook,
                Twitter, IdMandante, FechaContrato,  NombreDelDesarrollador, IdLote,  NumEscritura
                FROM busqueda_vivienda_informacioncontratos WHERE numcontrato = '".$contrato."'";
                //echo $sql3.'<br>';
                $ConsultaDATA = DatosViviendaLarge($IdDelegacion, "WSContratos", "Test", $sql3);
                $array = json_decode($ConsultaDATA, true);

               
                        //echo $ConsultaDATA;
                if(is_array($array)){            
                    foreach ($array as $value1) {
                        if (isset($value1['r'])){// si hay un error
                            $t1 = $t1."*Error: ".$value1['r'];
                            $error = $value1['r'];
                        } else {//si no hay errores escribimos
                                   
                          
                           $t1=$t1.' Programa: <b>('.$value1['IdPrograma'].') '.$value1['Programa'].'</b>                Folio: <b> '.$value1['Folio'].'</b> ';
                    
                    
                        }
                    }
                }
            
            
                $sql4 = "SELECT ISNULL(Folio,'') AS Folio, ISNULL(MontoCredito,'') AS MontoCredito, ISNULL(MontoIntMora,'') AS MontoIntMora, ISNULL(MontoPago,'') AS MontoPago, ISNULL(MontoPagoInicial,'') AS MontoPagoInicial, ISNULL(MontoUltimoPago,'') AS MontoUltimoPago, ISNULL(TasaAnualFin,'') AS TasaAnualFin, ISNULL(TasaIntMora,'') AS TasaIntMora, ISNULL(TipoIntMoratorio,'') AS TipoIntMoratorio, ISNULL(TotalPagos,'') AS TotalPagos, ISNULL(IdLote,'') AS IdLote, ISNULL(IdMunicipioL,'') AS IdMunicipioL, ISNULL(IdColoniaL,'') AS IdColoniaL, isnull(seccion,'') as seccion, isnull(fila,'') as fila, 
                ISNULL(Manzana,'') AS Manzana, ISNULL(Lote,'') AS Lote
                from contratos
                WHERE  NumContrato = '".$contrato."'";
                //echo $sql4.'<br>';
                $ConsultaDATA = DatosViviendaLarge($IdDelegacion, "WSContratos", "Test", $sql4);
                $array = json_decode($ConsultaDATA, true);
            
                if(is_array($array)){            
                    foreach ($array as $value) {
                        if (isset($value['r'])){// si hay un error
                            $t1 = $t1."*Error: ".$value['r'];
                            $error = $value['r'];
                        } else {//si no hay errores escribimos
                            $t1 = $t1.'Monto del crédito: <b>$'.number_format($value['MontoCredito'], 2, '.', ',').'</b> <br>
                                                Financiamiento: <b> '.$value['TasaAnualFin'].' </b>% Anual    Moratorios <b> '.$value['TasaIntMora'].'</b>% Mensual  Enganche: <b>$'.number_format($value['MontoPagoInicial'], 2, '.', ',').'</b> Mensualidad: <b>$'.number_format($value['MontoPago'], 2, '.', ',').'</b> Núm. pagos:<b>'.$value['TotalPagos'].'</b> <br>';
                                            
                        }
                    }
            
                }
            
                $sql5 = "SELECT ISNULL(idLote,'') AS idLote, ISNULL(IdDelegacion,'') AS IdDelegacion, ISNULL(IdPrograma,'') AS IdPrograma, ISNULL(Folio,'') AS Folio, ISNULL(NumContrato,'') AS NumContrato, ISNULL(solicitud,'') AS solicitud, ISNULL(IdMunicipio,'') AS IdMunicipio, ISNULL(IdColonia,'') AS IdColonia, ISNULL(seccion, '') AS seccion, ISNULL(fila, '') AS fila, ISNULL(manzana,'') AS manzana, ISNULL(lote,'') AS lote, ISNULL(calle,'') AS calle, ISNULL(colonia,'') AS colonia, ISNULL(superficie,'') AS superficie, ISNULL(precio,'') AS precio, ISNULL(IdMandante,'') AS IdMandante
                FROM  lotes
                WHERE NumContrato = '".$contrato."'";
               // echo $sql5.'<br>';
                $ConsultaDATA = DatosViviendaLarge($IdDelegacion, "WSContratos", "Test", $sql5);
                $array = json_decode($ConsultaDATA, true);
                if(is_array($array)){            
                    foreach ($array as $value) {
                        if (isset($value['r'])){// si hay un error
                            $t1 = $t1.'    Detalles: ';
                            $error = $value['r'];
                        } else {//si no hay errores escribimos
                            $t1 = $t1.'     Detalles: TERRENO: (ID '.$value['idLote'].')  Sección: '.$value['seccion'].'   Fila: '.$value['fila'].'  Manzana:  '.$value['manzana'].'  Lote: '.$value['lote'].'   Superficie: '.$value['superficie'].' m2 <br>
                            COLONIA: '.$value['colonia'].' - Mandante: ';
                            
                            $sql6 = "SELECT ISNULL(Mandante,'') AS Mandante
                             from catalogodemandantes WHERE IdMandante = ".$value['IdMandante']."";
                             //ECHO $sql6.'<br>';
        
                            $ConsultaDATA = DatosViviendaLarge(0, "WSContratos", "Test", $sql6);
                            $array = json_decode($ConsultaDATA, true);
                            if(is_array($array)){            
                                foreach ($array as $value) {
                                    if (isset($value['r'])){// si hay un error
                                        $t1 = $t1."*Error: ".$value['r'];
                                        $error = $value['r'];
                                    } else {//si no hay errores escribimos
                                        $t1 = $t1.''.$value['Mandante'].'';
                                          
                                    }
                                }
                            }
                            
                            
                        }
                    }
            
                }
            
                $t1 = $t1.' </td>
                </tr>
                </table>';

                $t1 = $t1.'<div style="width:100%; height:500px; background:url(icon/cancelado.png)"><table style="width:100%;"><tbody background="icon/cancelado.png"><tbody>';
                $sql7 = "SELECT cancelado from contratos WHERE numcontrato = '".$contrato."'";
                //echo $sql7.'<br>';

               $ConsultaDATA = DatosViviendaLarge(0, "WSContratos", "Test", $sql7);
               $array = json_decode($ConsultaDATA, true);
               if(is_array($array)){            
                   foreach ($array as $value) {
                       if (isset($value['r'])){// si hay un error
                           $t1 = $t1."*Error: ".$value['r'];
                           $error = $value['r'];
                       } else {
                           if($value['cancelado']==1){
                          //  $t1 = $t1.'<tbody background="icon/cancelado.jpg">';
                           }else{
                            //$t1 = $t1.'<tbody>';
                           }

                       }
                    }
                }
                
                 $t1 = $t1.' <tr border="1" bgcolor="#484848" style="font-size:6.5pt;">
                        <td align="center" style="width:25px; color:#ffffff; ">No.</td>
                        <td align="left" style="width:50px; color:#ffffff; ">Emp. Creo <br> Emp. Mod <br> Emp. Creo</td>
                        <td align="left" style="width:108px; color:#ffffff; ">Fecha Pago <br> Fecha Mod <br> Fecha de captura</td>
                        <td align="left" style="width:70px; color:#ffffff; ">Núm. Recibo <br> Refen OPD <br> Cve. Interna</td>
                        <td align="left" style="width:190px; color:#ffffff; ">Concepto <br> Observaciones <br> Aclaraciones financieras</td>
                        <td align="center" style="width:70px; color:#ffffff; ">Cargos</td>
                        <td align="center" style="width:70px; color:#ffffff; ">Abonos</td>
                        <td align="center" style="width:75px; color:#ffffff; ">Saldo</td>
                    </tr>
                ';
                $sql7 = "SELECT	cat_tipo_movimiento.desc_movimiento,	historicopagos.NumMov AS Secuencia,
                historicopagos.NumContrato,	0 AS referencia,	ISNULL(pagosparciales.FolioRecibo,'') AS numrecibo,	historicopagos.NumMov AS numpago,
                ISNULL(	CONVERT ( VARCHAR ( MAX ), conceptopago.Descripcion, 103 ),
                CONVERT ( VARCHAR ( MAX ), DescripcionMovimiento.DescripcionMovimiento, 103 )) AS descripcion,
            CASE	WHEN ( cat_tipo_movimiento.id_tipo_movimiento= 2 OR cat_tipo_movimiento.id_tipo_movimiento= 3 ) THEN
                    historicopagos.MontoPagoRecibido ELSE ''
                END AS abonos,
            CASE	WHEN ( cat_tipo_movimiento.id_tipo_movimiento= 1 OR cat_tipo_movimiento.id_tipo_movimiento= 3 ) THEN
                    historicopagos.capitalperiodo + historicopagos.GtsPeriodo + historicopagos.SegPeriodo + historicopagos.OtrosGtsPeriodo + historicopagos.FinancPeriodo + historicopagos.MoratoriosPeriodo ELSE ''
                END AS cargos,
            CASE WHEN historicopagos.SaldoCapitalCorriente + historicopagos.Saldoexento + historicopagos.NuevoRezCapital + historicopagos.NuevoRezFinanc + historicopagos.NuevoRezMoratorios + historicopagos.NuevoRezOtrosGts + historicopagos.NuevoRezSeg + historicopagos.NuevoRezGts = 0 THEN ''
                ELSE historicopagos.SaldoCapitalCorriente + historicopagos.Saldoexento + historicopagos.NuevoRezCapital + historicopagos.NuevoRezFinanc + historicopagos.NuevoRezMoratorios + historicopagos.NuevoRezOtrosGts + historicopagos.NuevoRezSeg + historicopagos.NuevoRezGts 
                END AS Saldo,
                ISNULL(historicopagos.FechaCorte,0) AS vencimiento,
                historicopagos.FechaOperacion AS fechapago,
                ((
                    CASE WHEN historicopagos.observaciones IS NULL THEN
                            '' ELSE CONVERT ( VARCHAR ( MAX ), historicopagos.observaciones, 103 ) 
                        END 
                            ) + ( CASE WHEN historicopagos.observacion2 IS NULL THEN '' ELSE CONVERT ( VARCHAR ( MAX ), historicopagos.observacion2, 103 ) END ) 
                        ) AS observaciones,
                        ISNULL (historicopagos.IdEmpCrea,'') AS IdEmpCrea,
                        ISNULL (historicopagos.IdEmpModifica,'') AS IdEmpModifica,
                        ISNULL (historicopagos.FechaUltimaMod,'') AS FechaUltimaMod,
                        ISNULL (historicopagos.ReferenciaOPD,'') AS ReferenciaOPD,
                        descripcionmovimiento.idTipoMov,
                        ISNULL((
                        SELECT IdEmpCrea FROM aclaracionesfinancieras AS AF 
                        WHERE	(AF.NumContrato COLLATE Latin1_General_CI_AS = historicopagos.NumContrato) AND ( AF.Cancelado = 1 ) AND ( AF.NumMov = historicopagos.NumMov )),'') AS Aclaraciones_IdEmpCrea,
                        ISNULL((SELECT FechaCaptura FROM aclaracionesfinancieras AS AF 
                        WHERE	(AF.NumContrato COLLATE Latin1_General_CI_AS = historicopagos.NumContrato) AND (AF.Cancelado = 1) AND (AF.NumMov = historicopagos.NumMov)),'') AS Aclaraciones_FechaCaptura,
                        ISNULL((SELECT Id FROM aclaracionesfinancieras AS AF WHERE
                            ( AF.NumContrato COLLATE Latin1_General_CI_AS = historicopagos.NumContrato ) AND ( AF.Cancelado = 1 ) AND ( AF.NumMov = historicopagos.NumMov )),'') AS Aclaraciones_ID,
                        ISNULL((SELECT Observaciones FROM	aclaracionesfinancieras AS AF WHERE
                            ( AF.NumContrato COLLATE Latin1_General_CI_AS = historicopagos.NumContrato ) AND ( AF.Cancelado = 1 ) AND ( AF.NumMov = historicopagos.NumMov )),'') AS Aclaraciones 
                    FROM
                        historicopagos
                        LEFT OUTER JOIN descripcionmovimiento
                        LEFT OUTER JOIN cat_tipo_movimiento ON descripcionmovimiento.id_tipo_movimiento = cat_tipo_movimiento.id_tipo_movimiento ON historicopagos.TipoMov = DescripcionMovimiento.idTipoMov
                        LEFT OUTER JOIN CONCEPTOPAGO
                        RIGHT OUTER JOIN formasingreso
                        RIGHT OUTER JOIN pagosparciales ON formasingreso.IngresoVia = pagosparciales.IngresoVia ON CONCEPTOPAGO.IdConceptoPago = pagosparciales.IdConceptoPago ON CONVERT ( CHAR ( 10 ), historicopagos.FechaOperacion, 111 ) = CONVERT ( CHAR ( 10 ), pagosparciales.FechaOperacion, 111) AND historicopagos.NumContrato COLLATE Latin1_General_CI_AS = pagosparciales.NumContrato AND historicopagos.MontoPagoRecibido = pagosparciales.ImportePago 
                        AND historicopagos.NumMov = pagosparciales.NumMov 
                    WHERE	(historicopagos.NumContrato = '".$contrato."') AND historicopagos.tipomov <> 14 AND historicopagos.cancelado= 0 
                ORDER BY	historicopagos.NumMov";
                //echo $sql7.'<br>';
                $ConsultaDATA = DatosViviendaLarge($IdDelegacion, "WSContratos", "Test", $sql7);
                $array = json_decode($ConsultaDATA, true);
                $error = 0;
                $c=1;
                if(is_array($array)){            
                    foreach ($array as $value) {
                        if (isset($value['r'])){// si hay un error
                            $t1 = $t1.'<tr bgcolor="#ffffff" style="font-size:8pt;"><td colspan="8" align="center">Sin Movimientos....</td></tr>
                            <tr bgcolor="#ffffff" style="font-size:8pt;"><td colspan="8" align="center"></td></tr>';
                            $error = $value['r'];
                        } else {//si no hay errores escribimos
                            if ($c%2==0){
                                $t1 = $t1.'<tr bgcolor="#C9DEB4" style="font-size:8pt;">';
                            }else{
                                $t1 = $t1.'<tr bgcolor="#ffffff"  style="font-size:8pt;">';
                            }
                            
                            $t1 = $t1."<td>".$value['Secuencia']."</td>";
                            $t1 = $t1."<td>";
                                    if($value['IdEmpCrea']<>0){
                                        $t1 = $t1."".$value['IdEmpCrea'];
                                    }
                                    if($value['IdEmpModifica']<>0){
                                        $t1 = $t1."".$value['IdEmpModifica'];
                                    }
                                $t1 = $t1."</td>";
            
                                $t1 = $t1.'<td style="font-size:7pt;">';
                                    //$t1 = $t1.$value['fechapago'].'<br>';
                                    //$t1 = $t1.$value['FechaUltimaMod'];
                                    if($value['fechapago'] <> '01/01/1900'){
                                        $t1 = $t1."".$value['fechapago'].'<br>';
                                        
                                    }
                                    if($value['FechaUltimaMod'] <> '01/01/1900'){
                                        
                                        $t1 = $t1."".$value['FechaUltimaMod'].'<br>';
                                    }
                                $t1 = $t1."</td>";
            
                                $t1 = $t1.'<td style="font-size:7pt;">';
                                    if($value['numrecibo']<>''){
                                        $t1 = $t1."".$value['numrecibo']."<br>";
                                    }
                                    if($value['ReferenciaOPD']<>''){
                                        $t1 = $t1."".$value['ReferenciaOPD']."<br>";
                                    }
                                    if($value['Aclaraciones']<>''){
                                        $t1 = $t1."".$value['Aclaraciones'];
                                    }
                                $t1 = $t1."</td>";
            
                                $t1 = $t1."<td>";
                                        $t1 = $t1."".$value['descripcion'].'<br>';
                                    if($value['observaciones']<>"" ){
                                        $t1 = $t1."".$value['observaciones']."<br>";
                                    }
                                    if($value['Aclaraciones']<>''){
                                        $t1 = $t1."".$value['Aclaraciones'];
                                    }
                                $t1 = $t1."</td>";
            
                                $t1 = $t1.'<td align = "right">';
                                    if($value['cargos']<>0){
                                        $t1 = $t1."".number_format($value['cargos'], 2, '.', ',');
                                    }
                                $t1 = $t1."</td>";
            
                                $t1 = $t1.'<td align = "right">';
                                    if($value['abonos']<>0){
                                        $t1 = $t1."".number_format($value['abonos'], 2, '.', ',');
                                    }
                                $t1 = $t1."</td>";
            
                                $t1 = $t1.'<td align = "right">';
                                    if($value['Saldo']<>0){
                                        $t1 = $t1."".number_format($value['Saldo'], 2, '.', ',');
                                    }
                                $t1 = $t1."</td>";
                            $t1 = $t1."</tr>";
                            
                        }
                        $c++;
                    }
            
                }
                
                $t1 = $t1.'<tr><td colspan="8" bgcolor="#484848" align="center" border="1" style="color:white;" >Resumen de Movimientos</td></tr>';
                $t1 = $t1."</tbody>";
                $t1 = $t1."</table></div>";
                $t1 = $t1."<br><br>";
                $t1 = $t1."<table>";
                $t1 = $t1."<tr>";
                    $t1 = $t1.'<td bgcolor="#484848" align="center" border="1" style="color:white; width:215px;"> Cargos</td>';
                    $t1 = $t1.'<td style="width:7px;"></td>';
                    $t1 = $t1.'<td bgcolor="#484848" align="center" border="1" style="color:white; width:215px;"> Abonos</td>';
                    $t1 = $t1.'<td style="width:7px;"></td>';
                    $t1 = $t1.'<td bgcolor="#484848" align="center" border="1" style="color:white; width:215px;"> Saldo</td>';
                $t1 = $t1."</tr>";
            
                $sql8 ="SELECT ISNULL(IdDelegacion,'') AS IdDelegacion, ISNULL(IdPrograma,'') AS IdPrograma, ISNULL(Folio,'') AS Folio, ISNULL(NumContrato, '') AS NumContrato, ISNULL(TasaAnualFin,'') AS TasaAnualFin, ISNULL(TasaIntMora,'') AS TasaIntMora, ISNULL(MontoCredito,'') AS MontoCredito, ISNULL(MontoPago,'') AS MontoPago,
                ISNULL(Actualizacion,'') AS Actualizacion, ISNULL(Cargo_MontoCredito,'') AS Cargo_MontoCredito, ISNULL(Cargo_OtrosGastos,'') AS Cargo_OtrosGastos, ISNULL(Cargo_ComisionesFinancSegVida,'') AS Cargo_ComisionesFinancSegVida, ISNULL(Cargo_Moratorios,'') AS Cargo_Moratorios, ISNULL(Abonos_Ahorros,'') AS Abonos_Ahorros,
                ISNULL(Abonos_Subsidios,'') AS Abonos_Subsidios, ISNULL(Abonos_PagosRecibidos,'') AS Abonos_PagosRecibidos, ISNULL(Abonos_Descuentos,'') AS Abonos_Descuentos, ISNULL(Abonado_SoloCapital,'') AS Abonado_SoloCapital, ISNULL(Saldo_VencidoSinMoratorios,'') AS Saldo_VencidoSinMoratorios, ISNULL(Saldo_Corriente,'') AS Saldo_Corriente,
                ISNULL(Saldo_Moratorio,'') AS Saldo_Moratorio, ISNULL(SaldoExento,'') AS SaldoExento, ISNULL(Saldo,'') AS Saldo, ISNULL(MesesDeAtraso,'') AS MesesDeAtraso, ISNULL(FechaPrimerPAGO,'') AS FechaPrimerPAGO, ISNULL(FechaUltimoPAGO,'') AS FechaUltimoPAGO, ISNULL(PuntosAcumulados,'') AS PuntosAcumulados, ISNULL(TotalPeriodosPagados,'') AS TotalPeriodosPagados, ISNULL(TotalPeriodosVencidos,'') AS TotalPeriodosVencidos
                FROM busqueda_vivienda_informacionfinanciera WHERE numcontrato = '".$contrato."'";
                //echo $sql8.'<br>';
                $ConsultaDATA = DatosViviendaLarge($IdDelegacion, "WSContratos", "Test", $sql8);
                $array = json_decode($ConsultaDATA, true);
                $error = 0;    
                if(is_array($array)){            
                    foreach ($array as $value) {
                        if (isset($value['r'])){// si hay un error
                            $t1 = $t1."*Error: ".$value['r'];
                            $error = $value['r'];
                        } else {//si no hay errores escribimos
            
                            
                            $t1 = $t1.'<tr style="font-size:7pt;">';
                            $cargos = $value['Cargo_MontoCredito'] + $value['Cargo_OtrosGastos'] + $value['Cargo_ComisionesFinancSegVida'] + $value['Cargo_Moratorios'];
                                $t1 = $t1.'<td style="width:215px;" border="1">
                                    <table>
                                    <tr>
                                        <td style="width:160px;">MONTO DEL CREDITO </td><td style="width:40px;" align="right">'.number_format($value['Cargo_MontoCredito'], 2, '.', ',').'</td>
                                    </tr>
                                    <tr>
                                        <td style="width:160px;">GASTOS Y COMISIONES APERTURA</td><td style="width:40px;" align="right">'.number_format($value['Cargo_OtrosGastos'], 2, '.', ',').'</td>
                                    </tr>
                                    <tr>
                                        <td style="width:160px;">FINANC, SEGUROS, GASTOS</td><td style="width:40px;" align="right">'.number_format($value['Cargo_ComisionesFinancSegVida'], 2, '.', ',').'</td>
                                    </tr>
                                    <tr>
                                        <td style="width:160px;">MORATORIOS GENERADOS</td><td style="width:40px;" align="right">'.number_format($value['Cargo_Moratorios'], 2, '.', ',').'</td>
                                    </tr>
                                    </table>
                                </td>';
                                $t1 = $t1.'<td style="width:7px;"></td>';
                                $abonos = $value['Abonos_Ahorros'] + $value['Abonos_Subsidios'] + $value['Abonos_PagosRecibidos'] + $value['Abonos_Descuentos'];
                                $t1 = $t1.'<td style="width:215px;" border="1">
                                    <table>
                                    <tr>
                                        <td style="width:160px;">ENGANCHE_AHORRO </td><td style="width:40px;" align="right">  '.number_format($value['Abonos_Ahorros'], 2, '.', ',').'</td>
                                    </tr>
                                    <tr>
                                        <td style="width:160px;">SUBSIDIADO</td><td style="width:40px;" align="right">'.number_format($value['Abonos_Subsidios'], 2, '.', ',').'</td>
                                    </tr>
                                    <tr>
                                        <td style="width:160px;">PAGOS RECIBIDOS </td><td style="width:40px;" align="right"> '.number_format($value['Abonos_PagosRecibidos'], 2, '.', ',').'</td>
                                    </tr>
                                    <tr>
                                        <td style="width:160px;">DESCUENTOS, BONIFICACIONES</td><td style="width:40px;" align="right">'.number_format($value['Abonos_Descuentos'], 2, '.', ',').'</td>
                                    </tr>
                                    </table>
                                </td>';
                                $t1 = $t1.'<td style="width:7px;"></td>';
                                $t1 = $t1.'<td style="width:215px;" border="1"> 
                                    <table>
                                    <tr>
                                        <td style="width:160px;">SALDO SE DEBE CUBRIR </td><td style="width:40px;" align="right">  '.number_format($value['Saldo_VencidoSinMoratorios'], 2, '.', ',').'</td>
                                    </tr>
                                    <tr>
                                        <td style="width:160px;">SALDO CORRIENTE</td><td style="width:40px;" align="right">'.number_format($value['Saldo_Corriente'], 2, '.', ',').'</td>
                                    </tr>
                                    <tr>
                                        <td style="width:160px;">SALDO DE MORATORIOS </td><td style="width:40px;" align="right"> '.number_format($value['Saldo_Moratorio'], 2, '.', ',').'</td>
                                    </tr>
                                    <tr>
                                        <td style="width:160px;">SALDO TOTAL A LA FECHA:</td><td style="width:40px;" align="right">'.number_format($value['Saldo'], 2, '.', ',').'</td>
                                    </tr>
                                    </table>
                                </td>';
                            $t1 = $t1."</tr>";
                            $t1 = $t1.'<tr style="font-size:8pt;">';
                                $t1 = $t1.'<td style="width:215px;" align="right" >Total Cargo(s) <b> '.number_format($cargos, 2, '.', ',').' </b></td>';
                                $t1 = $t1.'<td style="width:7px;"></td>';
                                $t1 = $t1.'<td style="width:215px;" align="right">Total Abono(s) <b>'.number_format($abonos, 2, '.', ',').'</b> </td>';
                                $t1 = $t1.'<td style="width:7px;"></td>';
                                $saldo = $cargos - $abonos;
                                $t1 = $t1.'<td style="width:215px;" align="right">Total Saldo <b>'.number_format($saldo, 2, '.', ',').'</b></td>';
                            $t1 = $t1."</tr>";
                        $t1 = $t1."</table>";
                        $t1 = $t1."<BR><BR>";
                        $t1 = $t1."<table>";
                            $t1 = $t1."<tr>";
                                $t1 = $t1.'<td style="font-size:8pt;"> Total de periodos pagados <b>'.$value['TotalPeriodosPagados'].'</b></td>';
                                $t1 = $t1.'<td style="font-size:8pt;"> Total de periodos por pagar</td>';
                                $t1 = $t1.'<td style="font-size:8pt;"> Total de periodos vencidos <b>'.$value['TotalPeriodosVencidos'].'</b></td>';
                                $t1 = $t1.'<td style="font-size:8pt;"> Total de puntos acumulados <b>'.$value['PuntosAcumulados'].'</b></td>';
                            $t1 = $t1."</tr>";
                            $t1 = $t1.'<tr><td colspan="4" style="font-size:8pt;">Recibos de pagos CANCELADOS</td></tr>';
                            
                        $t1 = $t1."</table>";
                        
                        }
                    }
                }
            
                //echo $t1;
            $orientacion='P';
            //$medidas = array(200, 600); // Ajustar aqui segun los milimetros necesarios;
            //$pdf = new TCPDF('P', 'mm', $medidas, true, 'UTF-8', false); 

            $sql9 = "select CONNECTIONPROPERTY('local_net_address') AS IP, BaseDeDatos, EstacionDeTrabajo from busqueda_vivienda_informacionfinanciera where NumContrato = '".$contrato."'";
            //echo $sql9.'<br>';
                $ConsultaDATA = DatosViviendaLarge($IdDelegacion, "WSContratos", "Test", $sql9);
                $array = json_decode($ConsultaDATA, true);
                $string="";
                if(is_array($array)){            
                    foreach ($array as $value) {
                        if (isset($value['r'])){// si hay un error
                            $t1 = $t1."*Error: ".$value['r'];
                            $error = $value['r'];
                        } else {//si no hay errores escribimos
                            $ip = substr($value['IP'], 0, 7);
                        $string = "                                       Impreso: ".fecha_larga($fecha).", ".hora12($hora)." por ".nitavu_nombre($nitavu)."(".$nitavu.") \n                                                                                SRV ".$ip."***********, BD ".$value['BaseDeDatos']."; PC ".$value['EstacionDeTrabajo'].".";
                        }
                }
            }

            // Extend the TCPDF class to create custom Header and Footer
            class MYPDF extends TCPDF {
                //Page header
                public function Header() {
                    if ($this->header_xobjid === false) {
                        // start a new XObject Template
                        $this->header_xobjid = $this->startTemplate($this->w, $this->tMargin);
                        $headerfont = $this->getHeaderFont();
                        $headerdata = $this->getHeaderData();
                        $this->y = $this->header_margin;
                        if ($this->rtl) {
                            $this->x = $this->w - $this->original_rMargin;
                        } else {
                            $this->x = $this->original_lMargin;
                        }
                        if (($headerdata['logo']) AND ($headerdata['logo'] != K_BLANK_IMAGE)) {
                            $imgtype = TCPDF_IMAGES::getImageFileType(K_PATH_IMAGES.$headerdata['logo']);
                            if (($imgtype == 'eps') OR ($imgtype == 'ai')) {
                                $this->ImageEps(K_PATH_IMAGES.$headerdata['logo'], '', '', $headerdata['logo_width']);
                            } elseif ($imgtype == 'svg') {
                                $this->ImageSVG(K_PATH_IMAGES.$headerdata['logo'], '', '', $headerdata['logo_width']);
                            } else {
                                $this->Image(K_PATH_IMAGES.$headerdata['logo'], '', '', $headerdata['logo_width']);
                            }
                            $imgy = $this->getImageRBY();
                        } else {
                            $imgy = $this->y;
                        }
                        $cell_height = $this->getCellHeight($headerfont[2] / $this->k);
                        // set starting margin for text data cell
                        if ($this->getRTL()) {
                            $header_x = $this->original_rMargin + ($headerdata['logo_width'] * 1.1);
                        } else {
                            $header_x = $this->original_lMargin + ($headerdata['logo_width'] * 1.1);
                        }
                        $cw = $this->w - $this->original_lMargin - $this->original_rMargin - ($headerdata['logo_width'] * 1.1);
                        $this->SetTextColorArray($this->header_text_color);
                        // header title
                        $this->SetFont($headerfont[0], 'B', $headerfont[2] + 1);
                        $this->SetX($header_x);
                        $this->Cell($cw, $cell_height, $headerdata['title'], 0, 1, '', 0, '', 0);
                        // header string
                        $this->SetFont($headerfont[0], $headerfont[1], $headerfont[2]);
                        $this->SetX($header_x);
                        $this->MultiCell($cw, $cell_height, $headerdata['string'], 0, '', 0, 1, '', '', true, 0, false, true, 0, 'T', false);
                        // print an ending header line
                        $this->SetLineStyle(array('width' => 0.85 / $this->k, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => $headerdata['line_color']));
                        $this->SetY((2.835 / $this->k) + max($imgy, $this->y));
                        if ($this->rtl) {
                            $this->SetX($this->original_rMargin);
                        } else {
                            $this->SetX($this->original_lMargin);
                        }
                        $this->Cell(($this->w - $this->original_lMargin - $this->original_rMargin), 0, '', 'T', 0, 'C');
                        $this->endTemplate();
                    }
                    // print header template
                    $x = 0;
                    $dx = 0;
                    if (!$this->header_xobj_autoreset AND $this->booklet AND (($this->page % 2) == 0)) {
                        // adjust margins for booklet mode
                        $dx = ($this->original_lMargin - $this->original_rMargin);
                    }
                    if ($this->rtl) {
                        $x = $this->w + $dx;
                    } else {
                        $x = 0 + $dx;
                    }
                    $this->printTemplate($this->header_xobjid, $x, 0, 0, 0, '', '', false);
                    if ($this->header_xobj_autoreset) {
                        // reset header xobject template at each page
                        $this->header_xobjid = false;
                    }
                    // get the current page break margin
                    $bMargin = $this->getBreakMargin();
                    // get current auto-page-break mode
                    $auto_page_break = $this->AutoPageBreak;
                    // disable auto-page-break
                    $this->SetAutoPageBreak(false, 0);
                    // set bacground image
                   
                        $this->Image('icon/cancelado.png', 18, 70,180, 100, '', '', '', true, 300, '', false, false, 0);
                    
                    // restore auto-page-break status
                    $this->SetAutoPageBreak($auto_page_break, $bMargin);
                    // set the starting point for the page content
                    $this->setPageMark();
                }
            }
            // create new PDF document
            $pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

            $pdf->SetCreator(PDF_CREATOR);
            $pdf->SetKeywords('Reporte ITAVU');
            //$pdf->SetHeaderData('pdf_logo.jpg', '40','');
            $pdf->SetHeaderData('pdf_logo.jpg', '45', '', $string);
            //$pdf->setFooterData(array(0, 64, 0), array(0, 64, 128));
            $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
            $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
            $pdf->setFooterData(array(0,64,0), array(0,64,128));
            $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
            // set margins
            $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
            $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
            $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
            
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

            $pdf->AddPage('P', 'LETTER'); //en la tabla de reporte L o P
            $html = $t1;
            // Print a text

            $pdf->writeHTML($html, true, false, true, false, '');

            // -- set new background ---

            // get the current page break margin
            $bMargin = $pdf->getBreakMargin();
            // get current auto-page-break mode
            $auto_page_break = $pdf->getAutoPageBreak();
            // disable auto-page-break
            $pdf->SetAutoPageBreak(false, 0);
            // set bacground image
           
            if($cancelado==True){
                $pdf->Image('icon/cancelado.png', 18, 70,180, 100, '', '', '', true, 300, '', false, false, 0);
            }
            // restore auto-page-break status
            $pdf->SetAutoPageBreak($auto_page_break, $bMargin);
            // set the starting point for the page content
            $pdf->setPageMark();

            //Close and output PDF document
            $pdf->Output('example_051.pdf', 'I');
        }
        
}

}else{
echo "<center>";
    echo "<div style='width: 40%; border: 2px solid #FFFF0F; display: inline-block; background-color: #FFFFBF; border-radius: 10px; margin: 10px; padding: 10px;'>";
        echo "<table border='0'>";
        echo "<tr>";
        echo "<td width='50px' align='left' valign='middle'><img src='icon/404.png'></td>";
        echo "<td align='center'  valign='middle' style=' color: #FF9900;  font-family: Verdana;'>Ocurrio un error al momento de recibir la información de Vivienda, Favor de comlibrse con el dpto. de informática.</td>";
        echo "</tr>";
        echo "</table>";
    echo "</div>";
echo "</center>";
}
