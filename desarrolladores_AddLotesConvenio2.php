<?php
require("config.php");
require("seguridad.php");
require("var_clean.php");
require("lib/funciones.php");
require("lib/yes_funciones.php");
require("lib/laura_funciones.php");

//$IdLote=VarClean($_POST['idlote']);
$NC=VarClean($_POST['nc']);
$completo=VarClean($_POST['completo']);
$listalotessel=$_POST['listalotes'];


foreach(explode(",",$listalotessel) as $IdLote){


    $sqlLote='SELECT * FROM lotes WHERE idLote='.$IdLote;
    $rc1= $Vivienda -> query($sqlLote);
    var_dump ($rc1);
    var_dump ($Vivienda);

    //echo $sqlLote;
    if($g = $rc1 -> fetch_array())
    {
                //$f['MontoConvenio']
                    //   $monto=number_format($f['MontoConvenio'], 2, '.', '');
                    //   $subsidiolote=$f['SubsidioLote'];
                    //   $totallotes=$f['TotalLotes'];
                    //   $iddelegacion=$f['IdDelegacion']; 
                    //   $idprograma=$f['IdPrograma'];
        
        if ($NC == ''){
            //Toast("Error, No se identificó el número de convenio",2,"");
        } 
        else
        {
                $sqlNC="Select * from convdesarrollador where Folio=".$NC;
                $rc2= $Vivienda -> query($sqlNC);   
                if($f = $rc2 -> fetch_array()) 
                {                   
                    if ($f['AnticipoGlobal']>0){
                        $montopagoinicial=$f['AnticipoGlobal']/$f['TotalLotes'];                   
                    }else{
                        $montopagoinicial=0;
                    }
                    $montopago=($g['precio']-$montopagoinicial-$f['SubsidioLote'])/$f['PlazoConvenio'];
                    $certsubITV='';
                    if ($f['SubsidioLote']>0){
                        $certsubITV=substr(str_repeat(0, 3).$f['IdPrograma'], - 3).substr(str_repeat(0, 2).$f['IdMunicipio'], - 2).substr(str_repeat(0, 5).$NC, - 5);
                    } 
                        //ObtenerIdMunicipioDeDelegacion
                        // UpdateEnFolioContrato($iddelegacion,$idprograma,$maxfolio,$nitavu)
                        // ObtenerMaxFolioContratos($iddelegacion,$idprograma)
                    $Numcontrato=GenerarNumContrato($f['IdDelegacion'],$f['IdPrograma'],$f['IdMunicipio'],$nitavu);
                    $sql="
                            INSERT INTO contratos
                            (NumContrato, FechaCaptura,FechaEmision,IdDelegacion, IdPrograma, Folio,IdEmpCrea,IdTipoMoneda, IdTipoPago,
                            MontoCredito, MontoPago, MontoPagoInicial, MontoUltimoPago,ObservaContrato,PeriodoMora,RItavu,
                            SubsidioFonhapo,SubsidioItavu,NCertSubsidioI,TasaAnualFin, TasaIntMora,TotalPagos,IdLote, IdMunicipioL,IdColoniaL,
                            Seccion, Fila, Manzana, Lote )
                            values(
                                '".$Numcontrato."',
                                '".$fecha."',
                                '".$fecha."',
                                '".$f['IdDelegacion']."',
                                '".$f['IdPrograma']."',
                                '".$NC."',
                                '".$nitavu."',
                                1,
                                '".$g['TipoPago']."',
                                '".$g['precio']."',
                                '".$montopago."',
                                '".$montopagoinicial."',
                                0,
                                'Convenio Desarrolladores',
                                30,
                                '".$g['precio']."','".$g['SubsidioFederal']."','".$f['SubsidioLote']."','".$certsubITV."','".$g['TasaAnualFin']."','".$g['TasaIntMora']."',
                                '".$f['PlazoConvenio']."','".$IdLote."','".$g['IdMunicipio']."','".$g['IdColonia']."', '".$g['seccion']."','".$g['fila']."','".$g['manzana']."','".$g['lote']."'  )            
                            ";
                            if ($Vivienda->query($sql) == TRUE) {
                                //****modificar lotes
                                        $sqlactl ="UPDATE lotes SET IdDelegacion = ".$f['IdDelegacion'].", IdPrograma = ".$f['IdPrograma'].", Folio = ".$NC.", NumContrato = '".$Numcontrato."', contratado = 1, FechaUltimaMod = NOW(), IdEmpModifica=".$nitavu.", IdEstatus = 2 WHERE idLote= ".$IdLote;                
                                        if ($Vivienda->query($sqlactl) == TRUE){   
                                            // historia($nitavu, "SE INSERTO REGISTRO EN HISTORICO PAGOS PARA CANCELAR EL CONTRATO ".$NumContrato." POR EL VALOR DEL CREDITO");  
                                            //  $res = 'TRUE';
                                            $IdDelegacion=$f['IdDelegacion'];
                                            $IdPrograma=$f['IdPrograma'];
                        
                                            //*****apertura de credito en historicopagos                                   
                                            $fechaCorte=date("Y-m-d",strtotime($f['FechaConvenio']."+".$f['PlazoConvenio']." month")); 
                                            $nummov = 1;
                                            $Tipomov=1;
                                            $saldo_nuevo = $g['precio'];
                                            //se agrega un registro en historialpagos                                     
                                            $sql3 = "CALL registrarHistoricoPagos('$Numcontrato','".$nummov."','','".$fecha."','".$fechaCorte."','','','0','','',
                                                    '','','','','','','','','','',
                                                    '','','','','','','','','',
                                                    '','','','','".$g['precio']."','','','','".$g['precio']."',
                                                    'PIC','$Tipomov','','','$nitavu','',NOW(),'','','','','',
                                                    '','','','','','','','',0,'','".$f['IdDelegacion']."')";
                                                    //echo $sql3.'<br>';
                                                if ($Vivienda->query($sql3) == TRUE){
                                                    //*****crear controlcontratos
                                                    $sqlCC = "INSERT INTO controlcontratos (NumContrato, FechaProximoCorte, EstatusCuenta) 
                                                        VALUES ('".$Numcontrato."','".$fechaCorte."',2)";
                                                    if ($Vivienda->query($sqlCC) == TRUE){                                                  
                                                            if($f['SubsidioLote']> 0 ){                        
                                                                //se agrega un registro en pagosparciales por el monto del subsidio estatal
                                                                /*  $sql8 = "Insert into pagosparciales (numcontrato, fechaoperacion, fechacaptura, importepago, importeenpesos, identificadorcajera, idLugarOperacion, foliorecibo, NumMov, IngresoVia, FactorConversion, origen, cancelado ) values 
                                                                    ('".$NumContrato."',  '".$FechaInicio."',  '', ".$SubsidioItavu.", " .$SubsidioItavu * $factorconversion.", ".$nitavu.", ".$IdDelegacion.", ".$ncertificadoitavu.", ".$nummov.", '6' ,".$factorconversion.", 'PIC', 0 )";
                                                                    if ($Vivienda->query($sql8) == TRUE){ */
                                                                        //echo 'Registro pagosparciales Sql8<br>';
                                                                        //se agrega un registro en historialpagos para reducir el saldo en base al monto del subsidio estatal
                                                                    $nummov = $nummov + 1;
                                                                    $saldo_nuevo = $saldo_nuevo - $f['SubsidioLote'];
                                                                    $sql9 = "CALL registrarHistoricoPagos('$Numcontrato','".$nummov."','".$f['SubsidioLote']."','".$fecha."','".$fechaCorte."','','','0','','',
                                                                        '','','','','','','','','','',
                                                                        '','','','','','','','','',
                                                                        '','','','','','".$f['SubsidioLote']."','','','".$saldo_nuevo."',
                                                                        'PIC','7','','','$nitavu','',NOW(),'','','','','',
                                                                        '','','','','','','','',0,'','".$f['IdDelegacion']."')";
                                                                if ($Vivienda->query($sql9) == TRUE){                                                             
                                                                }
                                                                else // ERROR AL INSERTAR SUBSIDIO ESTATAL. 
                                                                {
                                                                    $sqlDelete7="CALL sp_EliminarRegistrosContratoMetasHp('$Numcontrato', '$IdDelegacion', '$IdPrograma','$NC','$nitavu',0)";
                                                                    echo $sqlDelete7;
                                                                        if ($Vivienda->query($sqlDelete7) == TRUE){
                                                                            historia($nitavu, 'Se elimino con éxito el contrato y demas tablas por que ocurrio un error al momento de insertar el subsido estatal en la tabla HistoricoPagos');
                                                                        }else{
                                                                            historia($nitavu, 'ERROR: Al eliminar el registros del contrato por que ocurrio un error al momento de insertar el subsido estatal en la tabla HistoricoPagos');
                                                                        }
                                                                            mensaje('ERROR: Al insertar el Subsidio Estatal en tabla HistoricoPagos.',' contratarCredito.php?_folio='.$Folio.'&programa='.$IdPrograma.'&delegaciones='.$IdDelegacion);
                                                                        return;    
                                                                }                                                     
                                                            }                                                                //Toast("Guardado con exito CONTRATO del lote  ".$IdLote."con número de contrato  ".$Numcontrato."",1,"");
                                                                
                                                                //verificar que la colonia no este ya listada
                                                            //     $sqlcolonia="SELECT 1 as col, IdColonia FROM convdesarrollador WHERE IdPrograma=165 AND Folio=".$NC." AND FIND_IN_SET(".$g['IdColonia'].", IdColonia)";                                                                
                                                            //     $rr2=$Vivienda->query($sqlcolonia);
                                                            //    if ($col = $rr2 -> fetch_array()){
                                                                if(RevisaColenLista($NC,$g['IdColonia'],165)<>1){
                                                                //if($col['col']<>1){
                                                                        if($f['IdColonia']==''){
                                                                            $idcolonia=$g['IdColonia'];
                                                                        }else{                                                                
                                                                            $idcolonia=$f['IdColonia'].",".$g['IdColonia'];
                                                                        }
                                                                } else{
                                                                        $idcolonia=$f['IdColonia'];                                                          
                                                                }                                                   
                                                                
                                                                
                                                                //Revision de convenio terminado
                                                            
                                                                    if (strlen($f['ListaLotes'])>0){
                                                                        $listacontratos=$f['ListaContratos'].",".$Numcontrato;
                                                                        $listalotes=$f['ListaLotes'].",".$IdLote;
                                                                    }else{
                                                                        $listacontratos=$Numcontrato;
                                                                        $listalotes=$IdLote;
                                                            
                                                                    }
                                                                    $sqlfin="UPDATE convdesarrollador SET Completo=".$completo.",FechaUltimamod='".$fecha."', ListaLotes='".$listalotes."', ListaContratos='".$listacontratos."', IdColonia='".$idcolonia."' WHERE IdPrograma=165 AND Folio=".$NC;
                                                                    //$sqlfin="UPDATE convdesarrollador SET Completo=".$completo.",FechaUltimamod='".$fecha."', ListaLotes='".$listalotes."', ListaContratos='".$listacontratos."', IdColonia='".$idcolonia."' WHERE IdPrograma=165 AND Folio=".$NC;
                                                                    if ($Vivienda->query($sqlfin) == TRUE){
                                                                        
                                                                       // echo $completo;
                                                                        echo "<script>$('#RV').val('".$completo."');</script>";
                                                                        //Toast("Convenio ".$NC." actualizado con éxito",1,"");
                                                                        //Toast("Guardado con exito CONTRATO del lote  ".$IdLote."con número de contrato  ".$Numcontrato."",1,"");
                                                                    }else{
                                                                        //Toast("Error al actualizar el convenio ".$NC."",1,"");
                                                                    }

                                                    }else{
                                                            // Toast("Error al crear controlcontratos para  ".$Numcontrato."",2,"");                    
                                                                $sqlDelete7="CALL sp_EliminarRegistrosContratoMetasHp('$Numcontrato', '$IdDelegacion', '$IdPrograma','$NC','$nitavu',0)";
                                                                echo $sqlDelete7;
                                                                if ($Vivienda->query($sqlDelete7) == TRUE){
                                                                    historia($nitavu, 'Se elimino con éxito el contrato y demas tablas por que ocurrio un error al momento de insertar el subsido estatal en la tabla HistoricoPagos');
                                                                }else{
                                                                    historia($nitavu, 'ERROR: Al eliminar el registros del contrato por que ocurrio un error al momento de insertar el subsido estatal en la tabla HistoricoPagos');
                                                                }
                                                                    mensaje('ERROR: Al insertar el Subsidio Estatal en tabla HistoricoPagos.',' contratarCredito.php?_folio='.$Folio.'&programa='.$IdPrograma.'&delegaciones='.$IdDelegacion);
                                                                return;    
                                                    }
                                                }

                                            //aqui empieza else de guardar datos al lote    
                                        }else
                                        {
                                                //Toast("Error al actualizar el Lote ".$IdLote."",2,"");                                    
                                                $sqlDelete7="CALL sp_EliminarRegistrosContratoMetasHp('$Numcontrato', '$IdDelegacion', '$IdPrograma','$NC','$nitavu',0)";
                                                                echo $sqlDelete7;
                                                    if ($Vivienda->query($sqlDelete7) == TRUE){
                                                        historia($nitavu, 'Se elimino con éxito el contrato y demas tablas por que ocurrio un error al momento de insertar el subsido estatal en la tabla HistoricoPagos');
                                                    }else{
                                                        historia($nitavu, 'ERROR: Al eliminar el registros del contrato por que ocurrio un error al momento de insertar el subsido estatal en la tabla HistoricoPagos');
                                                    }
                                                    mensaje('ERROR: Al insertar el Subsidio Estatal en tabla HistoricoPagos.',' contratarCredito.php?_folio='.$Folio.'&programa='.$IdPrograma.'&delegaciones='.$IdDelegacion);
                                                    return;    
                                        }
                                        
                            }        
                            else{
                            // Toast("_Error al guardar contrato");
                            }  //graba contrato  
                }else {
                    //Toast("No se abrio el registro del convenio");
                }   //fecha_array selec numconvenio                
        }    //NC
        
    unset($sql,$sqlLote,$sqlNC,$sqlactl,$sqlCC,$sql9,$sqlDelete7,$rc1);   
    }    //fech_array idlote
}
echo $completo;
?>