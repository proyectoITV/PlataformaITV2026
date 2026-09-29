<?php
require_once ("config.php");
require_once ("lib/flor_funciones.php");

if(isset($_GET['id']) and isset($_GET['idcolonia']) and isset($_GET['idmunicipio'])){
 
    $idmandante = $_GET['id'];
    $idcolonia = $_GET['idcolonia'];
    $idmunicipio = $_GET['idmunicipio'];
    $nitavu = $_GET['nitavu'];

    $per_page_validos = array(10, 25, 50);
    $per_page = isset($_GET['per_page']) ? (int)$_GET['per_page'] : 50;
    if(!in_array($per_page, $per_page_validos, true)){
        $per_page = 50;
    }

    $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
    if($page < 1){
        $page = 1;
    }
    
    $sql_total = "SELECT COUNT(*) AS total FROM mandantes_abonos WHERE idmandante = ".$idmandante." and idcolonia = ".$idcolonia." and idmunicipio = ".$idmunicipio." and cancelado = 0";
    $rc_total = $conexion -> query($sql_total);
    $total_rows = 0;
    if($rc_total){
        $r_total = $rc_total->fetch_array();
        $total_rows = isset($r_total['total']) ? (int)$r_total['total'] : 0;
    }

    $total_pages = $total_rows > 0 ? (int)ceil($total_rows / $per_page) : 1;
    if($page > $total_pages){
        $page = $total_pages;
    }

    $offset = ($page - 1) * $per_page;

    $sql = "SELECT * FROM mandantes_abonos WHERE idmandante = ".$idmandante." and idcolonia = ".$idcolonia." and idmunicipio = ".$idmunicipio." and cancelado = 0 ORDER BY id DESC LIMIT ".$offset.", ".$per_page;
    $rc = $conexion -> query($sql);

    $desde = $total_rows > 0 ? ($offset + 1) : 0;
    $hasta = $total_rows > 0 ? min($offset + $per_page, $total_rows) : 0;
    $base_url = "mandantes_pago.php?idmandante=".$idmandante."&idcolonia=".$idcolonia."&idmunicipio=".$idmunicipio;

    echo "<div id='tablaRegistros' style='width:100%; margin-top:20px;'>";
    if ($total_rows > 0){
?>
        <div class="cd-card-section">
            <div class="cd-card-header cd-card-header-primary">
                <h3 class="cd-card-title">
                    <i class="fa-solid fa-receipt"></i> Desglose de Pagos a Mandante
                </h3>
                <span class="cd-badge cd-badge-info"><?php echo $total_rows; ?> Registros</span>
            </div>
            <div style="display:flex; justify-content:space-between; align-items:center; gap:10px; flex-wrap:wrap; padding:12px 16px; border-bottom:1px solid var(--cd-border); background:#fff;">
                <div style="display:flex; align-items:center; gap:8px;">
                    <label for="jsRegistrosPerPage" style="font-weight:600; color:var(--cd-gray-dark); margin:0;">Registros por página:</label>
                    <select id="jsRegistrosPerPage" class="cd-form-control" style="width:90px; padding:6px 8px; height:34px;">
                        <option value="10" <?php echo $per_page === 10 ? 'selected' : ''; ?>>10</option>
                        <option value="25" <?php echo $per_page === 25 ? 'selected' : ''; ?>>25</option>
                        <option value="50" <?php echo $per_page === 50 ? 'selected' : ''; ?>>50</option>
                    </select>
                </div>
                <div style="font-weight:600; color:var(--cd-gray-dark);">Mostrando <?php echo $desde; ?> a <?php echo $hasta; ?> de <?php echo $total_rows; ?></div>
            </div>
            <div class="cd-card-body" style="padding:0;">
                <div class="cd-table-container">
                    <table class="cd-table">
                        <thead>
                            <tr>
                                <th style="text-align:center; width:50px;">ID</th>
                                <th>Periodo Pago</th>
                                <th style="text-align:right;">Recuperación</th>
                                <th style="text-align:right;">Gastos</th>
                                <th style="text-align:right;">Monto Pagar</th>
                                <th style="text-align:right;">Devols.</th>
                                <th style="text-align:right;">Otros Desc.</th>
                                <th style="text-align:right;">Amort. Ant.</th>
                                <th style="text-align:right;">Monto Pagado</th>
                                <th style="text-align:right;">Acumulado</th>
                                <th style="text-align:right;">Saldo</th>
                                <th style="text-align:center; width:280px; min-width:280px;">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                        $vuelta = 0;
                        while($r = $rc -> fetch_array()){
                            $vuelta += 1;
                            echo "<tr>";
                            echo "<td style='text-align:center;'><span class='cd-badge-id'>".$r['id']."</span></td>";
                            echo "<td style='font-weight:600;'>";
                            if($r['periodopago'] == $r['periodopago2']){
                                echo fechaesp($r['periodopago']);
                            } else {
                                echo fechaesp($r['periodopago'])." A ".fechaesp($r['periodopago2']);
                            }
                            echo "</td>";
                            echo "<td style='text-align:right;'>$".number_format((float)$r['recuperacion'], 2)."</td>";
                            echo "<td style='text-align:right;'>$".number_format((float)$r['gastos'], 2)."</td>";
                            echo "<td style='text-align:right;'>$".number_format((float)$r['montopagar'], 2)."</td>";
                            echo "<td style='text-align:right;'>$".number_format((float)$r['devols'], 2)."</td>";
                            echo "<td style='text-align:right;'>$".number_format((float)$r['otrosdesc'], 2)."</td>";
                            echo "<td style='text-align:right;'>$".number_format((float)$r['amortizacion_anticipo'], 2)."</td>";
                            echo "<td style='text-align:right; font-weight:700; color:var(--cd-primary);'>$".number_format((float)$r['monto_pagado'], 2)."</td>";
                            echo "<td style='text-align:right;'>$".number_format((float)$r['monto_acumulado'], 2)."</td>";
                            echo "<td style='text-align:right; font-weight:700;'>$".number_format((float)$r['saldo'], 2)."</td>";

                            // Column Acciones
                            echo "<td style='text-align:center; min-width:280px; white-space:nowrap;'><div class='cd-action-group' style='display:inline-flex; min-width:190px; flex-wrap:nowrap;'>";

                            // Adjuntos button & modal
                            echo "<a href='#subirAdjuntos1".$vuelta."' rel='MyModal:open' class='cd-icon-btn view' title='Documentos Adjuntos'><i class='fa-solid fa-paperclip'></i></a>";
                            
                            // Orden de Pago Form
                            MiToken_Init($nitavu, 'PAGO A MANDANTES-ORDEN DE PAGO');
                            echo "<form action='md_ordenpago.php?id=".$r['id']."&idmandante=".$idmandante."&idcolonia=".$idcolonia."&idmunicipio=".$idmunicipio."&fecha=".$r['periodopago']."' method='POST' style='margin:0; display:inline;'>";
                            echo "<input type='hidden' class='url1' name='url1'>";
                            echo "<button type='submit' class='cd-icon-btn view' title='Ver Orden de Pago PDF'><i class='fa-solid fa-file-pdf' style='color:#dc2626;'></i></button>";
                            echo "</form>";

                            // Abono Extra
                            echo "<a href='#masAbonos".$r['id']."' rel='MyModal:open' class='cd-icon-btn edit' title='Registrar Abono Extra'><i class='fa-solid fa-circle-plus'></i></a>";

                            // Editar
                            echo "<a href='md_modificarRegistro.php?id=".$r['id']."&idmandante=".$idmandante."&idcolonia=".$idcolonia."&idmunicipio=".$idmunicipio."' class='cd-icon-btn edit' title='Modificar Registro'><i class='fa-solid fa-pen-to-square'></i></a>";

                            // Eliminar
                            echo "<a href='mandantes_pago.php?ideliminar=".$r['id']."&idmandante=".$idmandante."&idcolonia=".$idcolonia."&idmunicipio=".$idmunicipio."' onclick=\"return confirm('¿Está seguro de eliminar este pago?');\" class='cd-icon-btn delete' title='Eliminar Registro'><i class='fa-solid fa-trash-can'></i></a>";

                            echo "</div>";

                            // MODAL ADJUNTOS
                            echo "<div id='subirAdjuntos1".$vuelta."' class='MyModal'>";
                            echo "<h3><i class='fa-solid fa-paperclip'></i> Documentos Adjuntos del Pago #".$r['id']."</h3>";
                            echo "<div>";
                            $adj = "SELECT idpago, ndocumento, nombre FROM documentos, mandantes_documentos WHERE mandantes_documentos.n_archivo=documentos.ndocumento and mandantes_documentos.idpago = ".$r['id']."";
                            $rc1 = $conexion -> query($adj);
                            if ($rc1 && $rc1->num_rows > 0){
                                echo "<table class='cd-table' style='margin-bottom:15px;'>";
                                echo "<thead><tr><th>Archivo</th><th style='width:120px; text-align:center;'>Acción</th></tr></thead><tbody>";
                                while($r1 = $rc1 -> fetch_array()){
                                    $archivo = "docs_mandantes/".$r1['idpago'].'_'.$r1['ndocumento'].'_'.$r1['nombre'];
                                    echo "<tr><td><i class='fa-solid fa-file-pdf' style='color:#dc2626; margin-right:8px;'></i>".htmlspecialchars($r1['nombre'])."</td>";
                                    echo "<td style='text-align:center;'><a href='md_descargar.php?nombre=".$archivo."' target='_self' class='cd-btn cd-btn-light' style='padding:4px 10px; font-size:0.8rem;'><i class='fa-solid fa-download'></i> Descargar</a></td></tr>";
                                }
                                echo "</tbody></table>";
                            } else {
                                echo "<p style='color:var(--cd-gray-dark); margin-bottom:15px;'><i class='fa-solid fa-info-circle'></i> No hay archivos adjuntos en este pago.</p>";
                            }
                            echo "</div>";

                            echo "<form action='mandantes_pago.php?idmandante=".$idmandante."&idcolonia=".$idcolonia."&idmunicipio=".$idmunicipio."' method='POST' enctype='multipart/form-data' class='cd-form-group'>";
                            echo "<label class='cd-form-label'><i class='fa-solid fa-upload'></i> Seleccione archivos anexos (PDF):</label>";
                            echo "<input type='hidden' name='comprobante' value='".$r['id']."'>";
                            echo "<input type='hidden' name='idmandante2' value='".$idmandante."'>";
                            echo "<input type='hidden' name='idcolonia2' value='".$idcolonia."'>";
                            echo "<input type='hidden' name='idmunicipio2' value='".$idmunicipio."'>";
                            echo "<input id='archivo[]' name='archivo[]' type='file' accept='.pdf' multiple class='cd-form-control' required style='margin-bottom:12px;'>";
                            echo "<button type='submit' class='cd-btn cd-btn-primary'><i class='fa-solid fa-cloud-arrow-up'></i> Subir Archivos</button>";
                            echo "</form>";
                            echo "</div>";

                            // MODAL MAS ABONOS
                            echo "<div id='masAbonos".$r['id']."' class='MyModal'>";
                            echo "<h3><i class='fa-solid fa-circle-plus'></i> Registrar Concepto Adicional - Pago #".$r['id']."</h3>";
                            echo "<form action='md_ingresa_abonoextra.php' method='POST'>";
                            echo "<input name='nitavu1' type='hidden' value='".$nitavu."'/>";
                            echo "<input name='idabono' type='hidden' value='".$r['id']."'/>";
                            echo "<div class='cd-form-grid'>";
                            echo "<div class='cd-form-group'><label class='cd-form-label'><i class='fa-solid fa-plus-minus'></i> Tipo de Ajuste</label>";
                            echo "<select id='mas_menos' name='mas_menos' class='cd-form-control'>";
                            echo "<option value='1'>Más (+)</option><option value='2'>Menos (-)</option></select></div>";

                            echo "<div class='cd-form-group'><label class='cd-form-label'><i class='fa-solid fa-list-check'></i> Concepto</label>";
                            echo "<select name='idconcepto' class='cd-form-control' id='idconcepto'>";
                            $sql_c = "SELECT * FROM cat_conceptos_mandabonos where Activo=1 ";
                            $rr = $conexion -> query($sql_c);
                            while($f = $rr -> fetch_array()){
                                echo "<option value='".$f['Id']."'>".htmlspecialchars($f['Concepto'])."</option>";
                            }
                            echo "</select></div>";
                            echo "</div>";

                            echo "<div class='cd-form-group'><label class='cd-form-label'><i class='fa-solid fa-dollar-sign'></i> Importe</label>";
                            echo "<input name='importe' id='importe' type='number' step='any' placeholder='$0.00' class='cd-form-control' required/></div>";

                            echo "<div style='margin-top:15px; text-align:right;'>";
                            echo "<button class='cd-btn cd-btn-primary' type='submit'><i class='fa-solid fa-floppy-disk'></i> Guardar Concepto</button>";
                            echo "</div>";
                            echo "</form>";
                            echo "</div>";

                            echo "</td></tr>";
                        }
                        ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <?php if($total_pages > 1){ ?>
            <div class="cd-pagination" style="justify-content:flex-end; gap:8px; padding:12px 16px; border-top:1px solid var(--cd-border); background:#fff;">
                <a href="<?php echo $base_url; ?>&page=1&per_page=<?php echo $per_page; ?>" class="cd-btn cd-btn-light js-mandantes-pagination" data-page="1" style="padding:6px 10px; height:32px;"><i class="fa-solid fa-angles-left"></i></a>
                <a href="<?php echo $base_url; ?>&page=<?php echo max(1, $page - 1); ?>&per_page=<?php echo $per_page; ?>" class="cd-btn cd-btn-light js-mandantes-pagination" data-page="<?php echo max(1, $page - 1); ?>" style="padding:6px 10px; height:32px;"><i class="fa-solid fa-angle-left"></i></a>
                <span class="cd-badge cd-badge-info" style="padding:6px 12px;">Página <?php echo $page; ?> de <?php echo $total_pages; ?></span>
                <a href="<?php echo $base_url; ?>&page=<?php echo min($total_pages, $page + 1); ?>&per_page=<?php echo $per_page; ?>" class="cd-btn cd-btn-light js-mandantes-pagination" data-page="<?php echo min($total_pages, $page + 1); ?>" style="padding:6px 10px; height:32px;"><i class="fa-solid fa-angle-right"></i></a>
                <a href="<?php echo $base_url; ?>&page=<?php echo $total_pages; ?>&per_page=<?php echo $per_page; ?>" class="cd-btn cd-btn-light js-mandantes-pagination" data-page="<?php echo $total_pages; ?>" style="padding:6px 10px; height:32px;"><i class="fa-solid fa-angles-right"></i></a>
            </div>
            <?php } ?>
        </div>
<?php
    } else {
        echo "<div class='cd-card-section' style='padding:30px; text-align:center;'><i class='fa-solid fa-folder-open' style='font-size:2.5rem; color:var(--cd-gray-mid); margin-bottom:10px;'></i><p style='font-weight:600; color:var(--cd-gray-dark); margin:0;'>No se encontraron registros de pago para este mandante.</p></div>";
    }
    echo "</div>";
}
?>
<script>
$(document).ready(function() {
    var URLactual = window.location;    
    $('.url1').val(URLactual);
});
</script>
