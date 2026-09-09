<?php
include ("./lib/body_head.php"); 
include ("./lib/body_menu.php"); 
?>
<link rel="stylesheet" href="lib/laura.css" />
<link rel="stylesheet" href="lib/plataforma_modern.css" />
<?php
$id_aplicacion = 'ap70';
xd_update('ap70',$nitavu);//guarda la experiencia del usuario
echo "<div id='AppDetalle'>".app_detalle($id_aplicacion, $nitavu)."</div>";
//PROCESO PARA TOCAR LA PUERTA DE SAN PEDRO
$nivel = aplicacion_nivel($id_aplicacion, $nitavu);

if (sanpedro($id_aplicacion, $nitavu) == TRUE){
    historia($nitavu, 'Entre a ver la lista de mandantes con los montos por pagar, y todos los saldos pendientes.');
    MiToken_Init($nitavu, 'PAGO A MANDANTES-LISTA DE MANDANTES');
?>

<div class="cd-wrapper">
    <!-- Hero Banner -->
    <div class="cd-hero">
        <div>
            <h1 class="cd-hero-title">
                <i class="fa-solid fa-list-check"></i> Lista General de Mandantes y Saldos
            </h1>
            <div class="cd-hero-dept">
                <i class="fa-solid fa-building-columns"></i> Control Financiero ITAVU 2026
            </div>
        </div>
        <div class="cd-top-links">
            <a href="mandantes_pago.php" class="cd-top-link-btn" title="Regresar al módulo de pago">
                <i class="fa-solid fa-arrow-left"></i> Regresar a Pago a Mandantes
            </a>
        </div>
    </div>

    <!-- Toolbar Exportar Reporte -->
    <div class="cd-toolbar-card" style="margin-bottom:20px;">
        <div class="cd-toolbar-group">
            <form action="md_reporteMandantes.php?nitavu=<?php echo $nitavu; ?>" method="POST" style="margin:0;">
                <input type="hidden" id="url" name="url">
                <button type="submit" class="cd-btn cd-btn-gold" title="Exportar reporte completo en PDF">
                    <i class="fa-solid fa-file-pdf"></i> Exportar Reporte General PDF
                </button>
            </form>
        </div>
    </div>

    <!-- Tabla Principal de Mandantes -->
    <div class="cd-card-section">
        <div class="cd-card-header cd-card-header-primary">
            <h3 class="cd-card-title">
                <i class="fa-solid fa-table"></i> Resumen General de Mandantes y Contratos
            </h3>
        </div>
        <div class="cd-card-body" style="padding:0;">
            <div class="cd-table-container">
                <?php
                $sqlMandantes = "SELECT mu.Municipio as MUN, co.Colonia as COL , ma.Mandante as MAN, ma.IdMandante as IdMAN, 
                ma.IdColonia as IdCOL, ma.IdMunicipio as IdMUN, ma.idTipoMandato as tipMan, ma.IdEstatus as estatus, 
                (mcar.lotes_contratadosLotes + mcar.lotes_contratadosSuelo) as LotesContratados, (mcar.lotes_sincontratoLotes + mcar.lotes_sincontratoSuelo) as LotesSinContrato, SUM(mc.monto_pagado) as montoPagado, 
                (select SUM(mc.monto_pagado) as montoPagado from mandantes_abonos as mc where mc.idmandante = ma.IdMandante and mc.idcolonia = ma.IdColonia and mc.idmunicipio = ma.IdMunicipio and mc.cancelado = 0 and mc.tipoMov=1) as TotalAnticipo,		
                SUM(mc.amortizacion_anticipo) as totalAmortizacion,
                ((select SUM(mc.monto_pagado) as montoPagado from mandantes_abonos as mc where mc.idmandante = ma.IdMandante and mc.idcolonia = ma.IdColonia and mc.idmunicipio = ma.IdMunicipio and mc.cancelado = 0 and mc.tipoMov=1)-SUM(mc.amortizacion_anticipo)) as saldoaPAmortizar,  
                mcar.monto_pagar as PagarContrato, (mcar.monto_pagar - SUM(mc.monto_pagado)) as resta
                FROM cat_mandantes AS ma
                INNER JOIN cat_colonias AS co ON ma.IdColonia = co.IdColonia and ma.IdMunicipio = co.IdMunicipio 
                INNER JOIN cat_municipios AS mu ON ma.IdMunicipio = mu.IdMunicipio and ma.IdMunicipio = co.IdMunicipio 
                LEFT JOIN mandantes_abonos as mc ON mc.idmandante = ma.IdMandante and mc.idcolonia = ma.IdColonia and mc.idmunicipio = ma.IdMunicipio and mc.cancelado = 0
                LEFT JOIN mandantes_cargos as mcar ON mcar.idmandante = ma.IdMandante and mcar.idcolonia = ma.IdColonia and mcar.idmunicipio = ma.IdMunicipio and mcar.id=(select MAX(mcar.id) from mandantes_cargos as mcar where mcar.idmandante = ma.idmandante and mcar.idcolonia = ma.idcolonia and mcar.idmunicipio = ma.IdMunicipio)
                WHERE ma.Cancelado = 0 GROUP BY ma.IdMandante, ma.IdColonia, ma.IdMunicipio ORDER BY mu.Municipio, co.colonia ASC";

                $rc = $conexion->query($sqlMandantes);

                if ($rc && $rc->num_rows > 0){
                    echo "<table class='cd-table'>";
                    echo "<thead><tr>";
                    echo "<th>Delegación</th>";
                    echo "<th>Colonia</th>";
                    echo "<th>Mandante</th>";
                    echo "<th>Tipo Mandato</th>";
                    echo "<th style='text-align:center;'>Lotes Contratados</th>";
                    echo "<th style='text-align:center;'>Lotes sin Contrato</th>";
                    echo "<th style='text-align:right;'>Monto Contrato</th>";
                    echo "<th style='text-align:right;'>Monto Pagado</th>";
                    echo "<th style='text-align:right;'>Saldo por Pagar</th>";
                    echo "<th style='text-align:right;'>Total Anticipos</th>";
                    echo "<th style='text-align:right;'>Total Amortizado</th>";
                    echo "<th style='text-align:right;'>Pendiente Amortizar</th>";
                    echo "<th>Estatus</th>";
                    echo "<th style='text-align:center;'>Comentarios</th>";
                    echo "</tr></thead><tbody>";

                    while($r1 = $rc->fetch_array()){
                        echo "<tr>";
                        echo "<td style='font-weight:600;'>".htmlspecialchars($r1['MUN'])."</td>";
                        echo "<td>".htmlspecialchars($r1['COL'])."</td>";
                        echo "<td style='font-weight:600; color:var(--cd-dark);'>".htmlspecialchars($r1['MAN'])."</td>";
                        
                        // Tipo Mandato
                        echo "<td>";
                        if($r1['tipMan'] != 0){
                            echo "<form action='md_lista.php' method='POST' style='display:flex; align-items:center; gap:4px; margin:0;'>";
                            $sqlTipo = "SELECT * FROM cat_tipomandato";
                            $r = $conexion->query($sqlTipo);
                            echo "<select id='tipoman1' name='tipoman1' class='cd-form-control' style='font-size:0.8rem; padding:4px 8px; width:auto;'>";
                            while($f = $r->fetch_array()){
                                $sel = ($r1['tipMan'] == $f['id']) ? 'selected' : '';
                                echo "<option value='".$f['id']."' ".$sel.">".htmlspecialchars($f['tipo'])."</option>";
                            }
                            echo "</select>";
                            echo "<input type='hidden' name='IdMAN1' value='".$r1['IdMAN']."'>";
                            echo "<input type='hidden' name='IdCOL1' value='".$r1['IdCOL']."'>";
                            echo "<input type='hidden' name='IdMUN1' value='".$r1['IdMUN']."'>";
                            echo "<button type='submit' class='cd-icon-btn edit' title='Guardar cambio de tipo'><i class='fa-solid fa-floppy-disk'></i></button>";
                            echo "</form>";
                        } else {
                            echo "<form action='md_lista.php' method='POST' style='display:flex; align-items:center; gap:4px; margin:0;'>";
                            $sqlTipo = "SELECT * FROM cat_tipomandato";
                            $r = $conexion->query($sqlTipo);
                            echo "<select id='tipoman' name='tipoman' class='cd-form-control' style='font-size:0.8rem; padding:4px 8px; width:auto;'>";
                            echo "<option value=''>Seleccione...</option>";
                            while($f = $r->fetch_array()){
                                echo "<option value='".$f['id']."'>".htmlspecialchars($f['tipo'])."</option>";
                            }
                            echo "</select>";
                            echo "<input type='hidden' name='IdMAN' value='".$r1['IdMAN']."'>";
                            echo "<input type='hidden' name='IdCOL' value='".$r1['IdCOL']."'>";
                            echo "<input type='hidden' name='IdMUN' value='".$r1['IdMUN']."'>";
                            echo "<button type='submit' class='cd-icon-btn check' title='Guardar tipo'><i class='fa-solid fa-floppy-disk'></i></button>";
                            echo "</form>";
                        }
                        echo "</td>";

                        echo "<td style='text-align:center;'>".$r1['LotesContratados']."</td>";
                        echo "<td style='text-align:center;'>".$r1['LotesSinContrato']."</td>";
                        echo "<td style='text-align:right;'>$".number_format((float)$r1['PagarContrato'], 2, '.', ',')."</td>";
                        echo "<td style='text-align:right; font-weight:700; color:var(--cd-primary);'>$".number_format((float)$r1['montoPagado'], 2, '.', ',')."</td>";
                        echo "<td style='text-align:right; font-weight:700;'>$".number_format((float)$r1['resta'], 2, '.', ',')."</td>";
                        echo "<td style='text-align:right;'>$".number_format((float)$r1['TotalAnticipo'], 2, '.', ',')."</td>";
                        echo "<td style='text-align:right;'>$".number_format((float)$r1['totalAmortizacion'], 2, '.', ',')."</td>";
                        echo "<td style='text-align:right;'>$".number_format((float)$r1['saldoaPAmortizar'], 2, '.', ',')."</td>";

                        // Estatus Mandato
                        echo "<td>";
                        if($r1['estatus'] != 0){
                            echo "<form action='md_lista.php' method='POST' style='display:flex; align-items:center; gap:4px; margin:0;'>";
                            $sqlEstatus = "SELECT * FROM cat_estatusmandato";
                            $r = $conexion->query($sqlEstatus);
                            echo "<select id='estatusman1' name='estatusman1' class='cd-form-control' style='font-size:0.8rem; padding:4px 8px; width:auto;'>";
                            while($f = $r->fetch_array()){
                                $sel = ($r1['estatus'] == $f['id']) ? 'selected' : '';
                                echo "<option value='".$f['id']."' ".$sel.">".htmlspecialchars($f['estatus_mandato'])."</option>";
                            }
                            echo "</select>";
                            echo "<input type='hidden' name='IdMAN1' value='".$r1['IdMAN']."'>";
                            echo "<input type='hidden' name='IdCOL1' value='".$r1['IdCOL']."'>";
                            echo "<input type='hidden' name='IdMUN1' value='".$r1['IdMUN']."'>";
                            echo "<button type='submit' class='cd-icon-btn edit' title='Guardar estatus'><i class='fa-solid fa-floppy-disk'></i></button>";
                            echo "</form>";
                        } else {
                            echo "<form action='md_lista.php' method='POST' style='display:flex; align-items:center; gap:4px; margin:0;'>";
                            $sqlEstatus = "SELECT * FROM cat_estatusmandato";
                            $r = $conexion->query($sqlEstatus);
                            echo "<select id='estatusman' name='estatusman' class='cd-form-control' style='font-size:0.8rem; padding:4px 8px; width:auto;'>";
                            echo "<option value=''>Seleccione...</option>";
                            while($f = $r->fetch_array()){
                                echo "<option value='".$f['id']."'>".htmlspecialchars($f['estatus_mandato'])."</option>";
                            }
                            echo "</select>";
                            echo "<input type='hidden' name='IdMAN' value='".$r1['IdMAN']."'>";
                            echo "<input type='hidden' name='IdCOL' value='".$r1['IdCOL']."'>";
                            echo "<input type='hidden' name='IdMUN' value='".$r1['IdMUN']."'>";
                            echo "<button type='submit' class='cd-icon-btn check' title='Guardar estatus'><i class='fa-solid fa-floppy-disk'></i></button>";
                            echo "</form>";
                        }
                        echo "</td>";

                        // Comentarios Button & Modal
                        echo "<td style='text-align:center;'>";
                        echo "<a href='#AgregarObservaciones_".$r1['IdMAN']."_".$r1['IdCOL']."_".$r1['IdMUN']."' rel='MyModal:open' title='Agregar u observad comentario' class='cd-icon-btn view'><i class='fa-solid fa-comment-dots'></i></a>";
                        
                        echo "<div id='AgregarObservaciones_".$r1['IdMAN']."_".$r1['IdCOL']."_".$r1['IdMUN']."' class='MyModal'>";
                        echo "<h3><i class='fa-solid fa-comment-dots'></i> Observaciones del Mandante</h3>";
                        echo "<form action='md_lista.php?idmandante=".$r1['IdMAN']."&idcolonia=".$r1['IdCOL']."&idmunicipio=".$r1['IdMUN']."' method='POST' enctype='multipart/form-data'>";
                        echo "<div class='cd-form-group'>";
                        echo "<label class='cd-form-label'>Comentario u observaciones:</label>";  
                        $com_existing = comentariosMandante($r1['IdMAN'], $r1['IdCOL'], $r1['IdMUN']);
                        $val_com = ($com_existing != 'FALSE') ? $com_existing : '';
                        echo "<textarea name='comentario' class='cd-form-control' style='min-height:100px;'>".htmlspecialchars($val_com)."</textarea>"; 
                        echo "</div>";
                        echo "<div style='margin-top:15px; text-align:right;'>";
                        echo "<button type='submit' name='Comentar' class='cd-btn cd-btn-primary'><i class='fa-solid fa-floppy-disk'></i> Guardar Comentario</button>";
                        echo "</div>";
                        echo "</form>"; 
                        echo "</div>";
                        echo "</td>";

                        echo "</tr>";
                    }
                    echo "</tbody></table>";
                }
                ?>
            </div>
        </div>
    </div>
</div>

<?php
    // Procesamiento POST de tipos de mandato
    if(isset($_POST['tipoman'], $_POST['IdMAN'],$_POST['IdCOL'],$_POST['IdMUN'])){
        $tipoman = $_POST['tipoman'];
        $idman = $_POST['IdMAN'];
        $idcol = $_POST['IdCOL'];
        $idmun = $_POST['IdMUN'];
        $res = agregarTipoMandante($idman, $idcol, $idmun, $tipoman);
        if($res == TRUE){
            historia($nitavu, 'Cambie el tipo de mandante al mandante: idmadante='.$idman.' idcolonia='.$idcol.' idmunicipio='.$idmun.' tipo:'.$tipoman.'');
            mensaje('Se ha registrado el nuevo tipo de mandato.','md_lista.php');
        }else{
            historia($nitavu, ' No se puede cambiar el tipo mandante al mandante');
            mensaje('Ocurrio un error al momento de guardar la información, por favor vuelva a intentarlo.','md_lista.php');
        }
    }

    if(isset($_POST['tipoman1'], $_POST['IdMAN1'],$_POST['IdCOL1'],$_POST['IdMUN1'])){
        $tipoman = $_POST['tipoman1'];
        $idman = $_POST['IdMAN1'];
        $idcol = $_POST['IdCOL1'];
        $idmun = $_POST['IdMUN1'];
        $res = agregarTipoMandante($idman, $idcol, $idmun, $tipoman);
        if($res == TRUE){
            historia($nitavu, 'Cambie el tipo de mandante al mandante: idmadante='.$idman.' idcolonia='.$idcol.' idmunicipio='.$idmun.' tipo:'.$tipoman.'');
            mensaje('Se ha registrado el nuevo tipo de mandato.','md_lista.php');
        }else{
            historia($nitavu, ' No se puede cambiar el tipo mandante');
            mensaje('Ocurrio un error al momento de guardar la información, por favor vuelva a intentarlo.','md_lista.php');
        }
    }

    if(isset($_POST['estatusman'], $_POST['IdMAN'],$_POST['IdCOL'],$_POST['IdMUN'])){
        $estatusman = $_POST['estatusman'];
        $idman = $_POST['IdMAN'];
        $idcol = $_POST['IdCOL'];
        $idmun = $_POST['IdMUN'];
        $res = agregarEstatusMandante($idman, $idcol, $idmun, $estatusman);
        if($res == TRUE){
            historia($nitavu, 'Cambie el estatus de mandante al mandante');
            mensaje('Se ha registrado el nuevo estatus de mandato.','md_lista.php');
        }else{
            historia($nitavu, 'No se puede cambiar el estatus mandante');
            mensaje('Ocurrio un error al momento de guardar la información, por favor vuelva a intentarlo.','md_lista.php');
        }
    }

    if(isset($_POST['estatusman1'], $_POST['IdMAN1'],$_POST['IdCOL1'],$_POST['IdMUN1'])){
        $estatusman = $_POST['estatusman1'];
        $idman = $_POST['IdMAN1'];
        $idcol = $_POST['IdCOL1'];
        $idmun = $_POST['IdMUN1'];
        $res = agregarEstatusMandante($idman, $idcol, $idmun, $estatusman);
        if($res == TRUE){
            historia($nitavu, 'Cambie el estatus de mandante');
            mensaje('Se ha registrado el nuevo estatus de mandato.','md_lista.php');
        }else{
            historia($nitavu, 'No se puede cambiar el estatus mandante');
            mensaje('Ocurrio un error al momento de guardar la información, por favor vuelva a intentarlo.','md_lista.php');
        }
    }

    if (isset($_POST['Comentar'])){
        $idmandante = $_GET['idmandante'];
        $idcolonia = $_GET['idcolonia'];
        $idmunicipio = $_GET['idmunicipio'];
        $comentario = $_POST['comentario'];
        $sql = "UPDATE cat_mandantes SET comentario = '".$comentario."' WHERE IdMandante = ".$idmandante." and IdColonia= ".$idcolonia." and IdMunicipio= ".$idmunicipio."";
        if ($conexion->query($sql) == TRUE){
            historia($nitavu,'cat_mandantes-Edite el comentario al mandante');
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

<script type="text/javascript">
$(document).ready(function() {
    var URLactual = window.location;    
    if(document.getElementById('url')) {
        document.getElementById('url').value = URLactual;
    }
});
</script>

<?php include ("./lib/body_footer.php"); ?>