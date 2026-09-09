<?php 
include ("./lib/body_head.php"); 
include ("./lib/body_menu.php"); 
?>
<link rel="stylesheet" href="lib/laura.css" />
<link rel="stylesheet" href="lib/plataforma_modern.css" />
<script>
$(document).on("change", "#cargo", function(event) {
    if($("#cargo").val() == 1){
        $("#mandato").css({'display':'block'});
        $("#adendum").css({'display':'none'});
    } else {
        $("#adendum").css({'display':'block'});
        $("#mandato").css({'display':'none'});
    }
});
</script>

<?php
require("config.php");
$id_aplicacion = 'ap70';
xd_update('ap70',$nitavu);//guarda la experiencia del usuario
echo "<div id='AppDetalle'>".app_detalle($id_aplicacion, $nitavu)."</div>";
//PROCESO PARA TOCAR LA PUERTA DE SAN PEDRO
$nivel = aplicacion_nivel($id_aplicacion, $nitavu);

if (sanpedro($id_aplicacion, $nitavu) == TRUE){

    if(isset($_GET['id']) and isset($_GET['idcolonia']) and isset($_GET['idmunicipio'])){
        $idmandante = $_GET['id'];
        $idcolonia = $_GET['idcolonia'];
        $idmunicipio = $_GET['idmunicipio'];

        // ELIMINAR UN CARGO
        if(isset($_POST['eliminarCargo'])){
            $id = $_POST['eliminarCargo'];
            $sql = 'UPDATE mandantes_cargos SET Cancelado = 1 WHERE id = '.$id.'';
            if($conexion->query($sql) == TRUE){  
                mensaje('Se elimino correctamente el registro.', 'md_nuevoCargo.php?id='.$idmandante.'&idcolonia='.$idcolonia.'&idmunicipio='.$idmunicipio.'');
            }else{
                mensaje('Hubo un error, favor de intentarlo nuevamente.', 'md_nuevoCargo.php?id='.$idmandante.'&idcolonia='.$idcolonia.'&idmunicipio='.$idmunicipio.'');
            }
        }

        historia($nitavu,'Entre a capturar un nuevo cargo para el mandante: idmandante: '.$idmandante.' idcolonia: '.$idcolonia.' idmunicipio:'.$idmunicipio.'');
?>

<div class="cd-wrapper">
    <!-- Hero Banner -->
    <div class="cd-hero">
        <div>
            <h1 class="cd-hero-title">
                <i class="fa-solid fa-file-invoice-dollar"></i> Registro y Edición de Cargos del Mandato
            </h1>
            <div class="cd-hero-dept">
                <i class="fa-solid fa-city"></i> <?php echo strtoupper(nombreMunicipio($idmunicipio)); ?> | <i class="fa-solid fa-map-location-dot"></i> <?php echo strtoupper(nombreColonia($idmunicipio,$idcolonia)); ?> | <i class="fa-solid fa-user-tie"></i> <?php echo strtoupper(nombreMandante($idmunicipio,$idcolonia,$idmandante)); ?>
            </div>
        </div>
        <div class="cd-top-links">
            <a href="mandantes_pago.php?idmandante=<?php echo $idmandante; ?>&idcolonia=<?php echo $idcolonia; ?>&idmunicipio=<?php echo $idmunicipio; ?>" class="cd-top-link-btn" title="Regresar a pago">
                <i class="fa-solid fa-arrow-left"></i> Regresar a Pago
            </a>
        </div>
    </div>

    <!-- Toolbar Registrar Nuevo Cargo -->
    <div class="cd-toolbar-card" style="margin-bottom:20px;">
        <div class="cd-toolbar-group">
            <a href="md_nuevoCargo.php?id=<?php echo $idmandante; ?>&idcolonia=<?php echo $idcolonia; ?>&idmunicipio=<?php echo $idmunicipio; ?>&nuevo=1" class="cd-btn cd-btn-primary" title="Registrar un nuevo cargo o adendum">
                <i class="fa-solid fa-circle-plus"></i> Registrar Nuevo Cargo / Mandato
            </a>
        </div>
    </div>

    <!-- Lista de Cargos Registrados -->
    <form action="md_nuevoCargo.php?id=<?php echo $idmandante; ?>&idcolonia=<?php echo $idcolonia; ?>&idmunicipio=<?php echo $idmunicipio; ?>" method="POST">
        <div class="cd-card-section" style="margin-bottom:24px;">
            <div class="cd-card-header cd-card-header-gold">
                <h3 class="cd-card-title">
                    <i class="fa-solid fa-list"></i> Cargos Registrados del Mandante
                </h3>
            </div>
            <div class="cd-card-body" style="padding:0;">
                <div class="cd-table-container">
                    <?php
                    $sql1 = "SELECT * FROM mandantes_cargos WHERE idmandante = ".$idmandante." and idcolonia =".$idcolonia." and idmunicipio=".$idmunicipio." and Cancelado = 0";
                    $rc = $conexion->query($sql1);

                    if ($rc && $rc->num_rows > 0){
                        echo "<table class='cd-table'>";
                        echo "<thead><tr>";
                        echo "<th>Tipo</th>";
                        echo "<th>Fecha Mandato</th>";
                        echo "<th>Fecha Adendum</th>";
                        echo "<th>Plazo Crédito</th>";
                        echo "<th>Observaciones</th>";
                        echo "<th style='width:70px; text-align:center;'>Editar</th>";
                        echo "<th style='width:70px; text-align:center;'>Eliminar</th>";
                        echo "</tr></thead><tbody>";

                        while($r1 = $rc->fetch_array()){
                            echo "<tr>";
                            echo "<td><span class='cd-badge ".($r1['tipo']==1 ? 'cd-badge-info' : 'cd-badge-warning')."'>".($r1['tipo']==1 ? 'MANDATO' : 'ADENDUM')."</span></td>";
                            echo "<td>".htmlspecialchars($r1['fecha_mandato'])."</td>";
                            echo "<td>".htmlspecialchars($r1['fecha_adendum'])."</td>";
                            echo "<td>".htmlspecialchars($r1['plazo_credito'])."</td>";
                            echo "<td>".htmlspecialchars($r1['observaciones'])."</td>";
                            echo "<td style='text-align:center;'><button type='submit' name='editar' value='".$r1['id']."' class='cd-icon-btn edit' title='Modificar Cargo'><i class='fa-solid fa-pen-to-square'></i></button></td>";
                            echo "<td style='text-align:center;'><button type='submit' name='eliminarCargo' value='".$r1['id']."' onclick=\"return confirm('¿Desea eliminar este cargo?');\" class='cd-icon-btn delete' title='Eliminar Cargo'><i class='fa-solid fa-trash-can'></i></button></td>";
                            echo "</tr>";
                        }
                        echo "</tbody></table>";
                    } else {
                        echo "<div style='padding:30px; text-align:center;'><p style='color:var(--cd-gray-dark); font-weight:600; margin:0;'>No hay cargos registrados aún para este mandante.</p></div>";
                    }
                    ?>
                </div>
            </div>
        </div>
    </form>

    <?php
    // EDITAR CARGO EXISTENTE
    if(isset($_POST['editar'])){
        $id = $_POST['editar'];
        $sql = "SELECT * FROM mandantes_cargos WHERE id= ".$id." ";
        $rc = $conexion->query($sql);
        if ($rc && $rc->num_rows > 0){
            while($r = $rc->fetch_array()){
                $tipo = $r['tipo'];
    ?>
                <div class="cd-card-section">
                    <div class="cd-card-header cd-card-header-primary">
                        <h3 class="cd-card-title">
                            <i class="fa-solid fa-pen-to-square"></i> Modificar <?php echo ($tipo == 1) ? 'Mandato' : 'Adendum'; ?>
                        </h3>
                    </div>
                    <div class="cd-card-body">
                        <?php if($tipo == 1): ?>
                            <form id="mandato" action="mandantes_pago.php?idmandante=<?php echo $idmandante; ?>&idcolonia=<?php echo $idcolonia; ?>&idmunicipio=<?php echo $idmunicipio; ?>" method="POST">
                                <input type="hidden" name="id" value="<?php echo $r['id']; ?>">
                                <input type="hidden" name="editar" value="1">
                                
                                <div class="cd-form-grid-3">
                                    <div class="cd-form-group">
                                        <label class="cd-form-label"><i class="fa-regular fa-calendar"></i> Fecha del Mandato</label>
                                        <input type="date" name="fechaMan" value="<?php echo $r['fecha_mandato']; ?>" class="cd-form-control" required>
                                    </div>
                                    <div class="cd-form-group">
                                        <label class="cd-form-label"><i class="fa-solid fa-clock"></i> Plazo de Crédito</label>
                                        <input type="text" placeholder="Mensualidades" name="plazoCredito" value="<?php echo htmlspecialchars($r['plazo_credito']); ?>" class="cd-form-control">
                                    </div>
                                    <div class="cd-form-group">
                                        <label class="cd-form-label"><i class="fa-solid fa-dollar-sign"></i> Costo Lotes</label>
                                        <input type="number" step="any" placeholder="$" name="costoLotes" value="<?php echo $r['costo_lotes']; ?>" class="cd-form-control">
                                    </div>
                                </div>

                                <div class="cd-form-grid-3">
                                    <div class="cd-form-group">
                                        <label class="cd-form-label"><i class="fa-solid fa-ruler-combined"></i> Costo m²</label>
                                        <input type="number" step="any" placeholder="$ X m²" name="LoteM2" value="<?php echo $r['costo_pormetro']; ?>" class="cd-form-control">
                                    </div>
                                    <div class="cd-form-group">
                                        <label class="cd-form-label"><i class="fa-solid fa-chart-area"></i> Superficie Total (m²)</label>
                                        <input type="text" placeholder="m²" name="superficie" value="<?php echo htmlspecialchars($r['superficie']); ?>" class="cd-form-control">
                                    </div>
                                    <div class="cd-form-group">
                                        <label class="cd-form-label"><i class="fa-solid fa-store"></i> Superficie Comercializar</label>
                                        <input type="text" placeholder="m²" name="supComercializar" value="<?php echo htmlspecialchars($r['superficie_comercializar']); ?>" class="cd-form-control">
                                    </div>
                                </div>

                                <div class="cd-form-grid-3">
                                    <div class="cd-form-group">
                                        <label class="cd-form-label"><i class="fa-solid fa-percent"></i> % Mandante</label>
                                        <input type="number" step="any" placeholder="%" name="porMan" value="<?php echo $r['porcentaje_mandante']; ?>" class="cd-form-control">
                                    </div>
                                    <div class="cd-form-group">
                                        <label class="cd-form-label"><i class="fa-solid fa-percent"></i> % ITAVU</label>
                                        <input type="number" step="any" placeholder="%" name="porItavu" value="<?php echo $r['porcentaje_itavu']; ?>" class="cd-form-control">
                                    </div>
                                    <div class="cd-form-group">
                                        <label class="cd-form-label"><i class="fa-solid fa-percent"></i> % Escrituración</label>
                                        <input type="number" step="any" placeholder="%" name="porEsc" value="<?php echo $r['porcentaje_escrituracion']; ?>" class="cd-form-control">
                                    </div>
                                </div>

                                <div class="cd-form-grid">
                                    <div class="cd-form-group">
                                        <label class="cd-form-label"><i class="fa-solid fa-hand-holding-dollar"></i> Amortización Anticipo</label>
                                        <input type="text" name="porAmorAnt" value="<?php echo htmlspecialchars($r['amortizacion_anticipo']); ?>" class="cd-form-control">
                                    </div>
                                    <div class="cd-form-group">
                                        <label class="cd-form-label"><i class="fa-solid fa-money-bill-wave"></i> Pago Total Contrato</label>
                                        <input type="number" step="any" placeholder="$0.00" name="monpagar" value="<?php echo $r['monto_pagar']; ?>" class="cd-form-control">
                                    </div>
                                </div>

                                <div class="cd-form-group">
                                    <label class="cd-form-label"><i class="fa-solid fa-chart-line"></i> Recuperación Tabla Comercialización</label>
                                    <input type="number" step="any" placeholder="$0.00" name="monpagarComer" value="<?php echo $r['monto_pagarcomercializacion']; ?>" class="cd-form-control">
                                </div>

                                <div class="cd-form-grid-3">
                                    <div class="cd-form-group">
                                        <label class="cd-form-label">Lotes Donación</label>
                                        <input type="number" step="any" name="lotesdonacion" value="<?php echo $r['donacion']; ?>" class="cd-form-control">
                                    </div>
                                    <div class="cd-form-group">
                                        <label class="cd-form-label">Lotes Área Verde</label>
                                        <input type="number" step="any" name="lotesareav" value="<?php echo $r['area_verde']; ?>" class="cd-form-control">
                                    </div>
                                    <div class="cd-form-group">
                                        <label class="cd-form-label">Lotes Eq. Urbano</label>
                                        <input type="number" step="any" name="loteseq" value="<?php echo $r['equi_urbano']; ?>" class="cd-form-control">
                                    </div>
                                </div>

                                <div class="cd-form-group">
                                    <label class="cd-form-label">Lotes Reserva Mandante</label>
                                    <input type="number" step="any" name="lotesreserva" value="<?php echo $r['reserva_mandante']; ?>" class="cd-form-control">
                                </div>

                                <!-- Programa Lotes / Suelo Legal -->
                                <div class="cd-form-grid" style="background:#f8fafc; padding:15px; border-radius:var(--cd-radius-sm); margin-bottom:15px;">
                                    <div>
                                        <h4 style="margin:0 0 10px 0; font-size:0.9rem; font-weight:700; color:var(--cd-primary);">Programa Lotes</h4>
                                        <div class="cd-form-group"><label class="cd-form-label">Total</label><input type="number" name="totLotesL" value="<?php echo $r['total_lotesLotes']; ?>" class="cd-form-control"></div>
                                        <div class="cd-form-group"><label class="cd-form-label">Para Comercializar</label><input type="number" name="lotesXComercialzarL" value="<?php echo $r['lotes_porcomercializarLotes']; ?>" class="cd-form-control"></div>
                                        <div class="cd-form-group"><label class="cd-form-label">Contratados</label><input type="number" name="lotesConL" value="<?php echo $r['lotes_contratadosLotes']; ?>" class="cd-form-control"></div>
                                        <div class="cd-form-group"><label class="cd-form-label">Sin Contrato</label><input type="number" name="lotesSinConL" value="<?php echo $r['lotes_sincontratoLotes']; ?>" class="cd-form-control"></div>
                                    </div>

                                    <div>
                                        <h4 style="margin:0 0 10px 0; font-size:0.9rem; font-weight:700; color:var(--cd-gold-dark);">Programa Suelo Legal</h4>
                                        <div class="cd-form-group"><label class="cd-form-label">Total</label><input type="number" name="totLotesS" value="<?php echo $r['total_lotesSuelo']; ?>" class="cd-form-control"></div>
                                        <div class="cd-form-group"><label class="cd-form-label">Para Comercializar</label><input type="number" name="lotesXComercialzarS" value="<?php echo $r['lotes_porcomercializarSuelo']; ?>" class="cd-form-control"></div>
                                        <div class="cd-form-group"><label class="cd-form-label">Contratados</label><input type="number" name="lotesConS" value="<?php echo $r['lotes_contratadosSuelo']; ?>" class="cd-form-control"></div>
                                        <div class="cd-form-group"><label class="cd-form-label">Sin Contrato</label><input type="number" name="lotesSinConS" value="<?php echo $r['lotes_sincontratoSuelo']; ?>" class="cd-form-control"></div>
                                    </div>
                                </div>

                                <div class="cd-form-group">
                                    <label class="cd-form-label"><i class="fa-solid fa-comment"></i> Observaciones</label>
                                    <textarea name="observaciones" class="cd-form-control" style="min-height:80px;"><?php echo htmlspecialchars($r['observaciones']); ?></textarea>
                                </div>

                                <div style="margin-top:20px; text-align:right;">
                                    <button type="submit" class="cd-btn cd-btn-primary"><i class="fa-solid fa-floppy-disk"></i> Guardar Mandato</button>
                                </div>
                            </form>
                        <?php else: ?>
                            <form id="adendum" action="mandantes_pago.php?idmandante=<?php echo $idmandante; ?>&idcolonia=<?php echo $idcolonia; ?>&idmunicipio=<?php echo $idmunicipio; ?>" method="POST">
                                <input type="hidden" name="id" value="<?php echo $r['id']; ?>">
                                <input type="hidden" name="editar" value="1">

                                <div class="cd-form-grid-3">
                                    <div class="cd-form-group">
                                        <label class="cd-form-label"><i class="fa-regular fa-calendar"></i> Fecha Adendum</label>
                                        <input type="date" name="fechaAdendum" value="<?php echo $r['fecha_adendum']; ?>" class="cd-form-control" required>
                                    </div>
                                    <div class="cd-form-group">
                                        <label class="cd-form-label"><i class="fa-regular fa-calendar-check"></i> Fecha Adendum Finiquito</label>
                                        <input type="date" name="fechaAdendumFiniquito" value="<?php echo $r['fecha_adendumfiniquito']; ?>" class="cd-form-control">
                                    </div>
                                    <div class="cd-form-group">
                                        <label class="cd-form-label"><i class="fa-solid fa-clock"></i> Plazo de Crédito</label>
                                        <input type="text" placeholder="Mensualidades" name="plazoCredito" value="<?php echo htmlspecialchars($r['plazo_credito']); ?>" class="cd-form-control">
                                    </div>
                                </div>

                                <div class="cd-form-grid-3">
                                    <div class="cd-form-group">
                                        <label class="cd-form-label"><i class="fa-solid fa-dollar-sign"></i> Costo Lotes</label>
                                        <input type="number" step="any" placeholder="$" name="costoLotes" value="<?php echo $r['costo_lotes']; ?>" class="cd-form-control">
                                    </div>
                                    <div class="cd-form-group">
                                        <label class="cd-form-label"><i class="fa-solid fa-ruler-combined"></i> Costo m²</label>
                                        <input type="number" step="any" placeholder="$ X m²" name="LoteM2" value="<?php echo $r['costo_pormetro']; ?>" class="cd-form-control">
                                    </div>
                                    <div class="cd-form-group">
                                        <label class="cd-form-label"><i class="fa-solid fa-chart-area"></i> Superficie Total (m²)</label>
                                        <input type="text" placeholder="m²" name="superficie" value="<?php echo htmlspecialchars($r['superficie']); ?>" class="cd-form-control">
                                    </div>
                                </div>

                                <div class="cd-form-grid-3">
                                    <div class="cd-form-group">
                                        <label class="cd-form-label"><i class="fa-solid fa-store"></i> Superficie Comercializar</label>
                                        <input type="text" placeholder="m²" name="supComercializar" value="<?php echo htmlspecialchars($r['superficie_comercializar']); ?>" class="cd-form-control">
                                    </div>
                                    <div class="cd-form-group">
                                        <label class="cd-form-label"><i class="fa-solid fa-percent"></i> % Mandante</label>
                                        <input type="number" step="any" placeholder="%" name="porMan" value="<?php echo $r['porcentaje_mandante']; ?>" class="cd-form-control">
                                    </div>
                                    <div class="cd-form-group">
                                        <label class="cd-form-label"><i class="fa-solid fa-percent"></i> % ITAVU</label>
                                        <input type="number" step="any" placeholder="%" name="porItavu" value="<?php echo $r['porcentaje_itavu']; ?>" class="cd-form-control">
                                    </div>
                                </div>

                                <div class="cd-form-grid">
                                    <div class="cd-form-group">
                                        <label class="cd-form-label"><i class="fa-solid fa-percent"></i> % Escrituración</label>
                                        <input type="number" step="any" placeholder="%" name="porEsc" value="<?php echo $r['porcentaje_escrituracion']; ?>" class="cd-form-control">
                                    </div>
                                    <div class="cd-form-group">
                                        <label class="cd-form-label"><i class="fa-solid fa-hand-holding-dollar"></i> Amortización Anticipo</label>
                                        <input type="text" name="porAmorAnt" value="<?php echo htmlspecialchars($r['amortizacion_anticipo']); ?>" class="cd-form-control">
                                    </div>
                                </div>

                                <div class="cd-form-grid">
                                    <div class="cd-form-group">
                                        <label class="cd-form-label"><i class="fa-solid fa-money-bill-wave"></i> Pago Total Contrato</label>
                                        <input type="number" step="any" placeholder="$0.00" name="monpagar" value="<?php echo $r['monto_pagar']; ?>" class="cd-form-control">
                                    </div>
                                    <div class="cd-form-group">
                                        <label class="cd-form-label"><i class="fa-solid fa-chart-line"></i> Recuperación Tabla Comercialización</label>
                                        <input type="number" step="any" placeholder="$0.00" name="monpagarComer" value="<?php echo $r['monto_pagarcomercializacion']; ?>" class="cd-form-control">
                                    </div>
                                </div>

                                <div class="cd-form-grid-3">
                                    <div class="cd-form-group"><label class="cd-form-label">Lotes Donación</label><input type="number" step="any" name="lotesdonacion" value="<?php echo $r['donacion']; ?>" class="cd-form-control"></div>
                                    <div class="cd-form-group"><label class="cd-form-label">Lotes Área Verde</label><input type="number" step="any" name="lotesareav" value="<?php echo $r['area_verde']; ?>" class="cd-form-control"></div>
                                    <div class="cd-form-group"><label class="cd-form-label">Lotes Eq. Urbano</label><input type="number" step="any" name="loteseq" value="<?php echo $r['equi_urbano']; ?>" class="cd-form-control"></div>
                                </div>

                                <div class="cd-form-group">
                                    <label class="cd-form-label">Lotes Reserva Mandante</label>
                                    <input type="number" step="any" name="lotesreserva" value="<?php echo $r['reserva_mandante']; ?>" class="cd-form-control">
                                </div>

                                <!-- Programa Lotes / Suelo Legal -->
                                <div class="cd-form-grid" style="background:#f8fafc; padding:15px; border-radius:var(--cd-radius-sm); margin-bottom:15px;">
                                    <div>
                                        <h4 style="margin:0 0 10px 0; font-size:0.9rem; font-weight:700; color:var(--cd-primary);">Programa Lotes</h4>
                                        <div class="cd-form-group"><label class="cd-form-label">Total</label><input type="number" name="totLotesL" value="<?php echo $r['total_lotesLotes']; ?>" class="cd-form-control"></div>
                                        <div class="cd-form-group"><label class="cd-form-label">Para Comercializar</label><input type="number" name="lotesXComercialzarL" value="<?php echo $r['lotes_porcomercializarLotes']; ?>" class="cd-form-control"></div>
                                        <div class="cd-form-group"><label class="cd-form-label">Contratados</label><input type="number" name="lotesConL" value="<?php echo $r['lotes_contratadosLotes']; ?>" class="cd-form-control"></div>
                                        <div class="cd-form-group"><label class="cd-form-label">Sin Contrato</label><input type="number" name="lotesSinConL" value="<?php echo $r['lotes_sincontratoLotes']; ?>" class="cd-form-control"></div>
                                    </div>

                                    <div>
                                        <h4 style="margin:0 0 10px 0; font-size:0.9rem; font-weight:700; color:var(--cd-gold-dark);">Programa Suelo Legal</h4>
                                        <div class="cd-form-group"><label class="cd-form-label">Total</label><input type="number" name="totLotesS" value="<?php echo $r['total_lotesSuelo']; ?>" class="cd-form-control"></div>
                                        <div class="cd-form-group"><label class="cd-form-label">Para Comercializar</label><input type="number" name="lotesXComercialzarS" value="<?php echo $r['lotes_porcomercializarSuelo']; ?>" class="cd-form-control"></div>
                                        <div class="cd-form-group"><label class="cd-form-label">Contratados</label><input type="number" name="lotesConS" value="<?php echo $r['lotes_contratadosSuelo']; ?>" class="cd-form-control"></div>
                                        <div class="cd-form-group"><label class="cd-form-label">Sin Contrato</label><input type="number" name="lotesSinConS" value="<?php echo $r['lotes_sincontratoSuelo']; ?>" class="cd-form-control"></div>
                                    </div>
                                </div>

                                <div class="cd-form-group">
                                    <label class="cd-form-label"><i class="fa-solid fa-comment"></i> Observaciones</label>
                                    <textarea name="observaciones" class="cd-form-control" style="min-height:80px;"><?php echo htmlspecialchars($r['observaciones']); ?></textarea>
                                </div>

                                <div style="margin-top:20px; text-align:right;">
                                    <button type="submit" class="cd-btn cd-btn-primary"><i class="fa-solid fa-floppy-disk"></i> Guardar Adendum</button>
                                </div>
                            </form>
                        <?php endif; ?>
                    </div>
                </div>
    <?php
            }
        }
    }

    // REGISTRAR NUEVO CARGO O ADENDUM
    if(isset($_GET['nuevo'])){
    ?>
        <div class="cd-card-section">
            <div class="cd-card-header cd-card-header-primary">
                <h3 class="cd-card-title">
                    <i class="fa-solid fa-plus-circle"></i> Registrar Nuevo Cargo o Adendum
                </h3>
            </div>
            <div class="cd-card-body">
                <div class="cd-form-group" style="margin-bottom:20px;">
                    <label for="cargo" class="cd-form-label"><i class="fa-solid fa-list-check" style="color:var(--cd-primary);"></i> Seleccione Tipo de Cargo:</label>
                    <select id="cargo" name="cargo" class="cd-form-control">
                        <option value="">Seleccione una opción...</option>
                        <option value="1">MANDATO</option>
                        <option value="2">ADENDUM</option>
                    </select>
                </div>

                <!-- FORM MANDATO -->
                <form id="mandato" style="display:none;" action="mandantes_pago.php?idmandante=<?php echo $idmandante; ?>&idcolonia=<?php echo $idcolonia; ?>&idmunicipio=<?php echo $idmunicipio; ?>" method="POST">
                    <input type="hidden" name="guardar" value="1">
                    
                    <div class="cd-form-grid-3">
                        <div class="cd-form-group">
                            <label class="cd-form-label"><i class="fa-regular fa-calendar"></i> Fecha del Mandato</label>
                            <input type="date" name="fechaMan" class="cd-form-control" required>
                        </div>
                        <div class="cd-form-group">
                            <label class="cd-form-label"><i class="fa-solid fa-clock"></i> Plazo de Crédito</label>
                            <input type="text" placeholder="Mensualidades" name="plazoCredito" class="cd-form-control" required>
                        </div>
                        <div class="cd-form-group">
                            <label class="cd-form-label"><i class="fa-solid fa-dollar-sign"></i> Costo Lotes</label>
                            <input type="number" step="any" placeholder="$" name="costoLotes" class="cd-form-control" required>
                        </div>
                    </div>

                    <div class="cd-form-grid-3">
                        <div class="cd-form-group">
                            <label class="cd-form-label"><i class="fa-solid fa-ruler-combined"></i> Costo m²</label>
                            <input type="number" step="any" placeholder="$ X m²" name="LoteM2" class="cd-form-control" required>
                        </div>
                        <div class="cd-form-group">
                            <label class="cd-form-label"><i class="fa-solid fa-chart-area"></i> Superficie Total (m²)</label>
                            <input type="text" placeholder="m²" name="superficie" class="cd-form-control" required>
                        </div>
                        <div class="cd-form-group">
                            <label class="cd-form-label"><i class="fa-solid fa-store"></i> Superficie Comercializar</label>
                            <input type="text" placeholder="m²" name="supComercializar" class="cd-form-control" required>
                        </div>
                    </div>

                    <div class="cd-form-grid-3">
                        <div class="cd-form-group">
                            <label class="cd-form-label"><i class="fa-solid fa-percent"></i> % Mandante</label>
                            <input type="number" step="any" placeholder="%" name="porMan" class="cd-form-control" required>
                        </div>
                        <div class="cd-form-group">
                            <label class="cd-form-label"><i class="fa-solid fa-percent"></i> % ITAVU</label>
                            <input type="number" step="any" placeholder="%" name="porItavu" class="cd-form-control" required>
                        </div>
                        <div class="cd-form-group">
                            <label class="cd-form-label"><i class="fa-solid fa-percent"></i> % Escrituración</label>
                            <input type="number" step="any" placeholder="%" name="porEsc" class="cd-form-control" required>
                        </div>
                    </div>

                    <div class="cd-form-grid">
                        <div class="cd-form-group">
                            <label class="cd-form-label"><i class="fa-solid fa-hand-holding-dollar"></i> Amortización Anticipo</label>
                            <input type="text" name="porAmorAnt" class="cd-form-control" required>
                        </div>
                        <div class="cd-form-group">
                            <label class="cd-form-label"><i class="fa-solid fa-money-bill-wave"></i> Pago Total Contrato</label>
                            <input type="number" step="any" placeholder="$0.00" name="monpagar" class="cd-form-control" required>
                        </div>
                    </div>

                    <div class="cd-form-group">
                        <label class="cd-form-label"><i class="fa-solid fa-chart-line"></i> Recuperación Tabla Comercialización</label>
                        <input type="number" step="any" placeholder="$0.00" name="monpagarComer" class="cd-form-control" required>
                    </div>

                    <div class="cd-form-grid-3">
                        <div class="cd-form-group"><label class="cd-form-label">Lotes Donación</label><input type="number" step="any" name="lotesdonacion" class="cd-form-control"></div>
                        <div class="cd-form-group"><label class="cd-form-label">Lotes Área Verde</label><input type="number" step="any" name="lotesareav" class="cd-form-control"></div>
                        <div class="cd-form-group"><label class="cd-form-label">Lotes Eq. Urbano</label><input type="number" step="any" name="loteseq" class="cd-form-control"></div>
                    </div>

                    <div class="cd-form-group">
                        <label class="cd-form-label">Lotes Reserva Mandante</label>
                        <input type="number" step="any" name="lotesreserva" class="cd-form-control">
                    </div>

                    <div class="cd-form-grid" style="background:#f8fafc; padding:15px; border-radius:var(--cd-radius-sm); margin-bottom:15px;">
                        <div>
                            <h4 style="margin:0 0 10px 0; font-size:0.9rem; font-weight:700; color:var(--cd-primary);">Programa Lotes</h4>
                            <div class="cd-form-group"><label class="cd-form-label">Total</label><input type="number" name="totLotesL" class="cd-form-control"></div>
                            <div class="cd-form-group"><label class="cd-form-label">Para Comercializar</label><input type="number" name="lotesXComercialzarL" class="cd-form-control"></div>
                            <div class="cd-form-group"><label class="cd-form-label">Contratados</label><input type="number" name="lotesConL" class="cd-form-control"></div>
                            <div class="cd-form-group"><label class="cd-form-label">Sin Contrato</label><input type="number" name="lotesSinConL" class="cd-form-control"></div>
                        </div>

                        <div>
                            <h4 style="margin:0 0 10px 0; font-size:0.9rem; font-weight:700; color:var(--cd-gold-dark);">Programa Suelo Legal</h4>
                            <div class="cd-form-group"><label class="cd-form-label">Total</label><input type="number" name="totLotesS" class="cd-form-control"></div>
                            <div class="cd-form-group"><label class="cd-form-label">Para Comercializar</label><input type="number" name="lotesXComercialzarS" class="cd-form-control"></div>
                            <div class="cd-form-group"><label class="cd-form-label">Contratados</label><input type="number" name="lotesConS" class="cd-form-control"></div>
                            <div class="cd-form-group"><label class="cd-form-label">Sin Contrato</label><input type="number" name="lotesSinConS" class="cd-form-control"></div>
                        </div>
                    </div>

                    <div class="cd-form-group">
                        <label class="cd-form-label"><i class="fa-solid fa-comment"></i> Observaciones</label>
                        <textarea name="observaciones" class="cd-form-control" style="min-height:80px;"></textarea>
                    </div>

                    <div style="margin-top:20px; text-align:right;">
                        <button type="submit" class="cd-btn cd-btn-primary"><i class="fa-solid fa-floppy-disk"></i> Guardar Mandato</button>
                    </div>
                </form>

                <!-- FORM ADENDUM -->
                <form id="adendum" style="display:none;" action="mandantes_pago.php?idmandante=<?php echo $idmandante; ?>&idcolonia=<?php echo $idcolonia; ?>&idmunicipio=<?php echo $idmunicipio; ?>" method="POST">
                    <input type="hidden" name="guardar" value="1">
                    
                    <div class="cd-form-grid-3">
                        <div class="cd-form-group">
                            <label class="cd-form-label"><i class="fa-regular fa-calendar"></i> Fecha Adendum</label>
                            <input type="date" name="fechaAdendum" class="cd-form-control" required>
                        </div>
                        <div class="cd-form-group">
                            <label class="cd-form-label"><i class="fa-regular fa-calendar-check"></i> Fecha Adendum Finiquito</label>
                            <input type="date" name="fechaAdendumFiniquito" class="cd-form-control">
                        </div>
                        <div class="cd-form-group">
                            <label class="cd-form-label"><i class="fa-solid fa-clock"></i> Plazo de Crédito</label>
                            <input type="text" placeholder="Mensualidades" name="plazoCredito" class="cd-form-control" required>
                        </div>
                    </div>

                    <div class="cd-form-grid-3">
                        <div class="cd-form-group">
                            <label class="cd-form-label"><i class="fa-solid fa-dollar-sign"></i> Costo Lotes</label>
                            <input type="number" step="any" placeholder="$" name="costoLotes" class="cd-form-control" required>
                        </div>
                        <div class="cd-form-group">
                            <label class="cd-form-label"><i class="fa-solid fa-ruler-combined"></i> Costo m²</label>
                            <input type="number" step="any" placeholder="$ X m²" name="LoteM2" class="cd-form-control" required>
                        </div>
                        <div class="cd-form-group">
                            <label class="cd-form-label"><i class="fa-solid fa-chart-area"></i> Superficie Total (m²)</label>
                            <input type="text" placeholder="m²" name="superficie" class="cd-form-control" required>
                        </div>
                    </div>

                    <div class="cd-form-grid-3">
                        <div class="cd-form-group">
                            <label class="cd-form-label"><i class="fa-solid fa-store"></i> Superficie Comercializar</label>
                            <input type="text" placeholder="m²" name="supComercializar" class="cd-form-control" required>
                        </div>
                        <div class="cd-form-group">
                            <label class="cd-form-label"><i class="fa-solid fa-percent"></i> % Mandante</label>
                            <input type="number" step="any" placeholder="%" name="porMan" class="cd-form-control" required>
                        </div>
                        <div class="cd-form-group">
                            <label class="cd-form-label"><i class="fa-solid fa-percent"></i> % ITAVU</label>
                            <input type="number" step="any" placeholder="%" name="porItavu" class="cd-form-control" required>
                        </div>
                    </div>

                    <div class="cd-form-grid">
                        <div class="cd-form-group">
                            <label class="cd-form-label"><i class="fa-solid fa-percent"></i> % Escrituración</label>
                            <input type="number" step="any" placeholder="%" name="porEsc" class="cd-form-control" required>
                        </div>
                        <div class="cd-form-group">
                            <label class="cd-form-label"><i class="fa-solid fa-hand-holding-dollar"></i> Amortización Anticipo</label>
                            <input type="text" name="porAmorAnt" class="cd-form-control" required>
                        </div>
                    </div>

                    <div class="cd-form-grid">
                        <div class="cd-form-group">
                            <label class="cd-form-label"><i class="fa-solid fa-money-bill-wave"></i> Pago Total Contrato</label>
                            <input type="number" step="any" placeholder="$0.00" name="monpagar" class="cd-form-control" required>
                        </div>
                        <div class="cd-form-group">
                            <label class="cd-form-label"><i class="fa-solid fa-chart-line"></i> Recuperación Tabla Comercialización</label>
                            <input type="number" step="any" placeholder="$0.00" name="monpagarComer" class="cd-form-control" required>
                        </div>
                    </div>

                    <div class="cd-form-grid-3">
                        <div class="cd-form-group"><label class="cd-form-label">Lotes Donación</label><input type="number" step="any" name="lotesdonacion" class="cd-form-control"></div>
                        <div class="cd-form-group"><label class="cd-form-label">Lotes Área Verde</label><input type="number" step="any" name="lotesareav" class="cd-form-control"></div>
                        <div class="cd-form-group"><label class="cd-form-label">Lotes Eq. Urbano</label><input type="number" step="any" name="loteseq" class="cd-form-control"></div>
                    </div>

                    <div class="cd-form-group">
                        <label class="cd-form-label">Lotes Reserva Mandante</label>
                        <input type="number" step="any" name="lotesreserva" class="cd-form-control">
                    </div>

                    <div class="cd-form-grid" style="background:#f8fafc; padding:15px; border-radius:var(--cd-radius-sm); margin-bottom:15px;">
                        <div>
                            <h4 style="margin:0 0 10px 0; font-size:0.9rem; font-weight:700; color:var(--cd-primary);">Programa Lotes</h4>
                            <div class="cd-form-group"><label class="cd-form-label">Total</label><input type="number" name="totLotesL" class="cd-form-control"></div>
                            <div class="cd-form-group"><label class="cd-form-label">Para Comercializar</label><input type="number" name="lotesXComercialzarL" class="cd-form-control"></div>
                            <div class="cd-form-group"><label class="cd-form-label">Contratados</label><input type="number" name="lotesConL" class="cd-form-control"></div>
                            <div class="cd-form-group"><label class="cd-form-label">Sin Contrato</label><input type="number" name="lotesSinConL" class="cd-form-control"></div>
                        </div>

                        <div>
                            <h4 style="margin:0 0 10px 0; font-size:0.9rem; font-weight:700; color:var(--cd-gold-dark);">Programa Suelo Legal</h4>
                            <div class="cd-form-group"><label class="cd-form-label">Total</label><input type="number" name="totLotesS" class="cd-form-control"></div>
                            <div class="cd-form-group"><label class="cd-form-label">Para Comercializar</label><input type="number" name="lotesXComercialzarS" class="cd-form-control"></div>
                            <div class="cd-form-group"><label class="cd-form-label">Contratados</label><input type="number" name="lotesConS" class="cd-form-control"></div>
                            <div class="cd-form-group"><label class="cd-form-label">Sin Contrato</label><input type="number" name="lotesSinConS" class="cd-form-control"></div>
                        </div>
                    </div>

                    <div class="cd-form-group">
                        <label class="cd-form-label"><i class="fa-solid fa-comment"></i> Observaciones</label>
                        <textarea name="observaciones" class="cd-form-control" style="min-height:80px;"></textarea>
                    </div>

                    <div style="margin-top:20px; text-align:right;">
                        <button type="submit" class="cd-btn cd-btn-primary"><i class="fa-solid fa-floppy-disk"></i> Guardar Adendum</button>
                    </div>
                </form>
            </div>
        </div>
    <?php
    }
    ?>
</div>

<?php
    }
} else {
    mensaje("No tiene acceso a ".$id_aplicacion,'');
}
include ("./lib/body_footer.php"); 
?>