 <?php
 include ("./unica/body_head.php"); include ("./unica/body_menu.php");
 $id_aplicacion = 'ap70';
xd_update('ap70',$nitavu);//guarda la experiencia del usuario
echo "<h5>".app_detalle($id_aplicacion)."</h5>";
//PROCESO PARA TOCAR LA PUERTA DE SAN PEDRO
$nivel =aplicacion_nivel($id_aplicacion, $nitavu);

if (sanpedro($id_aplicacion, $nitavu)==TRUE){
historia($nitavu, 'Entre a ver la lista de mandantes con los montos por pagar, y todos los saldos pendientes.');
 echo "<br><br>";
 echo "<div id='ReporteMandantes'>"; 
    echo "<a  href='md_reporteMandantes.php?nitavu=".$nitavu."' title='Clic para registar pago'>";
        echo "<img src='icon/pdf.png' style='width:40px; height:40px;'>";
    echo "</a>";	
echo "</div>";
MiToken_Init($nitavu, 'PAGO A MANDANTES-LISTA DE MANDANTES'); // inicializamos seguridad del Token (no necesitamos saberlo)
 echo "<div id='listaMandantes'>"; 
          /*  $sqlMandantes = "SELECT  mu.Municipio as MUN, co.Colonia as COL , ma.Mandante as MAN, ma.IdMandante as IdMAN, 
            ma.IdColonia as IdCOL, ma.IdMunicipio as IdMUN, ma.idTipoMandato as tipMan, ma.IdEstatus as estatus, 
            mcar.total_lotesLotes as TotalLotes, mcar.total_lotesSuelo as LotesSuelo, SUM(mc.monto_pagado) as montoPagado, 
            mcar.monto_pagar as PagarContrato, (mcar.monto_pagar - SUM(mc.monto_pagado)) as resta
    FROM cat_mandantes AS ma
    INNER JOIN cat_colonias AS co ON ma.IdColonia = co.IdColonia and ma.IdMunicipio = co.IdMunicipio 
    INNER JOIN cat_municipios AS mu ON ma.IdMunicipio = mu.IdMunicipio and ma.IdMunicipio = co.IdMunicipio 
		LEFT JOIN mandantes_abonos as mc ON mc.idmandante = ma.IdMandante and mc.idcolonia = ma.IdColonia and mc.idmunicipio = ma.IdMunicipio and mc.cancelado = 0
		LEFT JOIN  mandantes_cargos as mcar  ON mcar.idmandante = ma.IdMandante and mcar.idcolonia = ma.IdColonia and mcar.idmunicipio = ma.IdMunicipio and mcar.id=(select MAX(mcar.id) from mandantes_cargos as mcar where mcar.idmandante = ma.idmandante and mcar.idcolonia = ma.idcolonia and mcar.idmunicipio = ma.IdMunicipio)
            GROUP BY ma.IdMandante, ma.IdColonia, ma.IdMunicipio ORDER BY mu.Municipio, co.colonia ASC" ;*/
            
            $sqlMandantes = "SELECT  mu.Municipio as MUN, co.Colonia as COL , ma.Mandante as MAN, ma.IdMandante as IdMAN, 
            ma.IdColonia as IdCOL, ma.IdMunicipio as IdMUN, ma.idTipoMandato as tipMan, ma.IdEstatus as estatus, 
            (mcar.lotes_contratadosLotes + mcar.lotes_contratadosSuelo)  as LotesContratados, (mcar.lotes_sincontratoLotes + mcar.lotes_sincontratoSuelo) as LotesSinContrato, SUM(mc.monto_pagado) as montoPagado, 
            mcar.monto_pagar as PagarContrato, (mcar.monto_pagar - SUM(mc.monto_pagado)) as resta
    FROM cat_mandantes AS ma
    INNER JOIN cat_colonias AS co ON ma.IdColonia = co.IdColonia and ma.IdMunicipio = co.IdMunicipio 
    INNER JOIN cat_municipios AS mu ON ma.IdMunicipio = mu.IdMunicipio and ma.IdMunicipio = co.IdMunicipio 
		LEFT JOIN mandantes_abonos as mc ON mc.idmandante = ma.IdMandante and mc.idcolonia = ma.IdColonia and mc.idmunicipio = ma.IdMunicipio and mc.cancelado = 0
		LEFT JOIN  mandantes_cargos as mcar  ON mcar.idmandante = ma.IdMandante and mcar.idcolonia = ma.IdColonia and mcar.idmunicipio = ma.IdMunicipio and mcar.id=(select MAX(mcar.id) from mandantes_cargos as mcar where mcar.idmandante = ma.idmandante and mcar.idcolonia = ma.idcolonia and mcar.idmunicipio = ma.IdMunicipio)
			GROUP BY ma.IdMandante, ma.IdColonia, ma.IdMunicipio ORDER BY mu.Municipio, co.colonia ASC";
            $rc = $conexion -> query($sqlMandantes);

            if ($rc->num_rows>0){
            
                echo "<table class='tabla'>";
                    echo "<th>Delegación</th>";
                    echo "<th>Colonia</th>";
                    echo "<th style='width:20%'>Mandante</th>";
                    echo "<th>Tipo</th>";
                    echo "<th>Lotes contratados</th>";
                    echo "<th>Lotes sin contratar</th>";
                    echo "<th>Monto por pagar de acuerdo al contrato</th>";
                    echo "<th>Monto pagado</th>";
                    echo "<th>Saldo por pagar</th>";
                    echo "<th>Estatus</th>";
                    echo "<th>Comentarios</th>";

                    while($r1 = $rc -> fetch_array()){
                        echo "<tr>";
                            echo "<td>".$r1['MUN']."</td>";
                            echo "<td>".$r1['COL']."</td>";
                            echo "<td>".$r1['MAN']."</td>";
                            echo "<td>";
                                echo "<table>";
                                    
                                        if($r1['tipMan']!= 0){
                                            //$tipo = buscartipoMandante($r1['tipMan']);
                                            // echo $tipo;
                                            echo "<td>";
                                                echo "<form action='md_lista.php' method='POST'>";
                                                    $sqlTipo = "SELECT * FROM cat_tipomandato";
                                                    $r = $conexion -> query($sqlTipo);
                                                    echo "<select id='tipoman1' name='tipoman1'>";
                                                    while($f = $r -> fetch_array()){ // resultado de la busqueda.................
                                                        if ($r1['tipMan']==$f['id']){
                                                            echo "<option value='".$f['id']."' selected>".$f['tipo']."</option>";
                                                        }else{
                                                            echo "<option value='".$f['id']."'>".$f['tipo']."</option>";
                                                        } 
                                                    }
                                                    echo "</select>";
                                            echo "</td>";
                                            echo "<td>";
                                                echo "<input type='hidden' name='IdMAN1' id='IdMAN1' value='".$r1['IdMAN']."'>";
                                                echo "<input type='hidden' name='IdCOL1' id='IdCOL1' value='".$r1['IdCOL']."'>";
                                                echo "<input type='hidden' name='IdMUN1' id='IdMUN1' value='".$r1['IdMUN']."'>";
                                                echo "<button type='submit' style='background-color: transparent; border-width: 0px;
                    margin-left: 0px;' title='Guardar nombre'> <img src='icon/mod.png' style='width:20px; '> </button>";
                                            echo "</form>";  
                                            echo "</td>";
                                        }else{
                                            echo "<td>";
                                            echo "<form action='md_lista.php' method='POST'>";
                                                $sqlTipo = "SELECT * FROM cat_tipomandato";
                                                $r = $conexion -> query($sqlTipo);
                                                    echo "<select id='tipoman' name='tipoman'>";
                                                        echo "<option>Seleccione un tipo...</option>";
                                                        while($f = $r -> fetch_array()){ // resultado de la busqueda.................
                                                            
                                                            echo "<option value='".$f['id']."'>".$f['tipo']."</option>";
                                                            
                                                        }
                                                    
                                                    echo "</select>";
                                            echo "</td>";
                                            echo "<td>";
                                                echo "<input type='hidden' name='IdMAN' id='IdMAN' value='".$r1['IdMAN']."'>";
                                                echo "<input type='hidden' name='IdCOL' id='IdCOL' value='".$r1['IdCOL']."'>";
                                                echo "<input type='hidden' name='IdMUN' id='IdMUN' value='".$r1['IdMUN']."'>";
                                                echo "<button type='submit' style='background-color: transparent; border-width: 0px;
                    margin-left: 0px;' title='Guardar nombre'> <img src='icon/bien.png' style='width:20px; '> </button>";
                                            echo "</form>";
                                            echo "</td>";
                                        }
                                    
                                    
                                echo "</table>";
                            
                            echo "</td>";
                            echo "<td>".$r1['LotesContratados']."</td>";
                            echo "<td>".$r1['LotesSinContrato']."</td>";
                            echo "<td>$".number_format($r1['PagarContrato'], 2, '.', ',')."</td>";
                            echo "<td>$".number_format($r1['montoPagado'], 2, '.', ',')."</td>";
                            echo "<td>$".number_format($r1['resta'], 2, '.', ',')."</td>";

                            echo "<td>";
                            
                            echo "<table>";
                                    
                                    if($r1['estatus']!= 0){
                                        //$estatus = buscarEstatusMandante($r1['estatus']);
                                        //echo $estatus;
                                        echo "<td>";
                                            echo "<form action='md_lista.php' method='POST'>";
                                                $sqlEstatus = "SELECT * FROM cat_estatusmandato";
                                                $r = $conexion -> query($sqlEstatus);
                                                echo "<select id='estatusman1' name='estatusman1'>";
                                                    while($f = $r -> fetch_array()){ // resultado de la busqueda.................
                                                        if ($r1['estatus']==$f['id']){
                                                            echo "<option value='".$f['id']."' selected>".$f['estatus_mandato']."</option>";
                                                        }else{
                                                            echo "<option value='".$f['id']."'>".$f['estatus_mandato']."</option>";
                                                        } 
                                                    }
                                                echo "</select>";
                                        echo "</td>";
                                        echo "<td>";
                                            echo "<input type='hidden' name='IdMAN1' id='IdMAN1' value='".$r1['IdMAN']."'>";
                                            echo "<input type='hidden' name='IdCOL1' id='IdCOL1' value='".$r1['IdCOL']."'>";
                                            echo "<input type='hidden' name='IdMUN1' id='IdMUN1' value='".$r1['IdMUN']."'>";
                                            echo "<button type='submit' style='background-color: transparent; border-width: 0px;
                margin-left: 0px;' title='Guardar nombre'> <img src='icon/mod.png' style='width:20px; '> </button>";
                                            echo "</form>";  
                                        echo "</td>";
                                    }else{
                                        echo "<td>";
                                        echo "<form action='md_lista.php' method='POST'>";
                                            $sqlEstatus = "SELECT * FROM cat_estatusmandato";
                                            $r = $conexion -> query($sqlEstatus);
                                                echo "<select id='estatusman' name='estatusman'>";
                                                    echo "<option>Seleccione un estatus...</option>";
                                                    while($f = $r -> fetch_array()){ // resultado de la busqueda.................
                                                        
                                                        echo "<option value='".$f['id']."'>".$f['estatus_mandato']."</option>";
                                                        
                                                    }
                                                
                                                echo "</select>";
                                            
                                        echo "</td>";
                                        echo "<td>";
                                            echo "<input type='hidden' name='IdMAN' id='IdMAN' value='".$r1['IdMAN']."'>";
                                            echo "<input type='hidden' name='IdCOL' id='IdCOL' value='".$r1['IdCOL']."'>";
                                            echo "<input type='hidden' name='IdMUN' id='IdMUN' value='".$r1['IdMUN']."'>";
                                            echo "<button type='submit' style='background-color: transparent; border-width: 0px;
                margin-left: 0px;' title='Guardar nombre'> <img src='icon/bien.png' style='width:20px; '> </button>";
                                        echo "</form>";
                                        echo "</td>";
                                    }
                                    
                                echo "</table>";
                            
                            echo "</td>";

                            echo "<td align=center>";
                            echo "<a href='#AgregarObservaciones' rel='modal:open' title='Agregar un comentario' class='btn-comentario'><img src='icon/bcomentario.png' style='width:40px;'></a>";
                                echo "<div id='AgregarObservaciones' class='modal'>";
                                echo "<form action='md_lista.php?idmandante=".$r1['IdMAN']."&idcolonia=".$r1['IdCOL']."&idmunicipio=".$r1['IdMUN']."' method='POST'  enctype='multipart/form-data'>";
                                echo "<label>Comentario:</label>";  
                                
                                if(comentariosMandante($r1['IdMAN'], $r1['IdCOL'], $r1['IdMUN']) != 'FALSE'){
                                    echo "<textarea name='comentario'>".comentariosMandante($r1['IdMAN'], $r1['IdCOL'], $r1['IdMUN'])."</textarea>"; 
                                }else{
                                    echo "<textarea name='comentario'></textarea>";  
                                }
                                   
                                echo "<button type='submit' name='Comentar' class='btn btn-default' title='Haga clic aqui para comentar'> Guardar </button>";
                                echo "</form>"; 
                                echo "</div>";
                               
                            echo "</td>";
                        echo "</tr>";
                    }
                echo "</table>";
            }
            
        echo "</div>";

    if(isset($_POST['tipoman'], $_POST['IdMAN'],$_POST['IdCOL'],$_POST['IdMUN'])){
        echo $tipoman = $_POST['tipoman'];
        echo $idman = $_POST['IdMAN'];
        echo  $idcol = $_POST['IdCOL'];
        echo $idmun = $_POST['IdMUN'];
        $res = agregarTipoMandante($idman, $idcol, $idmun, $tipoman);
        if($res == TRUE){
            historia($nitavu, 'Cambie el tipo de mandante al mandante: idmadante='.$idman.' idcolonia='.$idcol.' idmunicipio='.$idmun.' tipo:'.$tipoman.'');
            mensaje('Se ha registrado el nuevo tipo de mandato.','md_lista.php');
        }else{
            historia($nitavu, ' No se puede cambiar el tipo mandante al mandante: idmadante='.$idman.' idcolonia='.$idcol.' idmunicipio='.$idmun.' tipo:'.$tipoman.'');
            mensaje('Ocurrio un error al momento de guardar la información, por favor vuelva a intentarlo.','md_lista.php');
        }
    }

    if(isset($_POST['tipoman1'], $_POST['IdMAN1'],$_POST['IdCOL1'],$_POST['IdMUN1'])){
        echo $tipoman = $_POST['tipoman1'];
        echo $idman = $_POST['IdMAN1'];
        echo  $idcol = $_POST['IdCOL1'];
        echo $idmun = $_POST['IdMUN1'];
        $res = agregarTipoMandante($idman, $idcol, $idmun, $tipoman);
        if($res == TRUE){
             historia($nitavu, 'Cambie el tipo de mandante al mandante: idmadante='.$idman.' idcolonia='.$idcol.' idmunicipio='.$idmun.' tipo:'.$tipoman.'');
            mensaje('Se ha registrado el nuevo tipo de mandato.','md_lista.php');
        }else{
            historia($nitavu, ' No se puede cambiar el tipo mandante al mandante: idmadante='.$idman.' idcolonia='.$idcol.' idmunicipio='.$idmun.' tipo:'.$tipoman.'');
            mensaje('Ocurrio un error al momento de guardar la información, por favor vuelva a intentarlo.','md_lista.php');
        }
    }


    if(isset($_POST['estatusman'], $_POST['IdMAN'],$_POST['IdCOL'],$_POST['IdMUN'])){
        echo $estatusman = $_POST['estatusman'];
        echo $idman = $_POST['IdMAN'];
        echo  $idcol = $_POST['IdCOL'];
        echo $idmun = $_POST['IdMUN'];
        $res = agregarEstatusMandante($idman, $idcol, $idmun, $estatusman);
        if($res == TRUE){
            historia($nitavu, 'Cambie el estatus de mandante al mandante: idmadante='.$idman.' idcolonia='.$idcol.' idmunicipio='.$idmun.' estatus:'.$estatusman.'');
            mensaje('Se ha registrado el nuevo tipo de mandato.','md_lista.php');
        }else{
            historia($nitavu, 'No se puede cambiar el tipo mandante al mandante: idmadante='.$idman.' idcolonia='.$idcol.' idmunicipio='.$idmun.' estatus:'.$estatusman.'');
            mensaje('Ocurrio un error al momento de guardar la información, por favor vuelva a intentarlo.','md_lista.php');
        }
    }

    if(isset($_POST['estatusman1'], $_POST['IdMAN1'],$_POST['IdCOL1'],$_POST['IdMUN1'])){
        echo $estatusman = $_POST['estatusman1'];
        echo $idman = $_POST['IdMAN1'];
        echo  $idcol = $_POST['IdCOL1'];
        echo $idmun = $_POST['IdMUN1'];
        $res = agregarEstatusMandante($idman, $idcol, $idmun, $estatusman);
        if($res == TRUE){
            historia($nitavu, 'Cambie el estatus de mandante al mandante: idmadante='.$idman.' idcolonia='.$idcol.' idmunicipio='.$idmun.' estatus:'.$estatusman.'');
            mensaje('Se ha registrado el nuevo tipo de mandato.','md_lista.php');
        }else{
            historia($nitavu, 'No se puede cambiar el tipo mandante al mandante: idmadante='.$idman.' idcolonia='.$idcol.' idmunicipio='.$idmun.' estatus:'.$estatusman.'');
            mensaje('Ocurrio un error al momento de guardar la información, por favor vuelva a intentarlo.','md_lista.php');
        }
    }

    if (isset($_POST['Comentar'])){
        $idmandante = $_GET['idmandante'];
        $idcolonia = $_GET['idcolonia'];
        $idmunicipio = $_GET['idmunicipio'];
        $comentario = $_POST['comentario'];
        $sql = "UPDATE cat_mandantes SET comentario = '".$comentario."' WHERE IdMandante = ".$idmandante."  and IdColonia= ".$idcolonia." and IdMunicipio= ".$idmunicipio."";
        echo $sql;
        if ($conexion->query($sql) == TRUE){
            historia($nitavu,'cat_mandantes-Edite el comentario al mandante: idmandante: '.$idmandante.' idcolonia: '.$idcolonia.' idmunicipio: '.$idmunicipio.' comentario: '.$comentario.'');
            mensaje('Información guardada correctamente','md_lista.php');
        }else{
            mensaje('ERROR al guardar el comentario','md_lista.php');
        }
    }
}
else{
    mensaje("No tiene acceso a ".$id_aplicacion,'');
}

?>

<br><br><br>
<br>
<br>
<br><br><br>
<br>
<br>
<br><br><br>
<br>
<br>
<br><br><br>
<br>
<br>
<?php include ("./unica/body_footer.php"); ?>