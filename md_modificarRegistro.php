<?php 
include ("./lib/body_head.php"); 
include ("./lib/body_menu.php"); 
?>
<link rel="stylesheet" href="lib/laura.css" />
<link rel="stylesheet" href="lib/plataforma_modern.css" />
<script>
function mostrarFechados(){
    if (fechados.checked == true){
        $("#fech2").css({'display':'flex'});
        periodo2.value="";
    }else{
        $("#fech2").css({'display':'none'});
    }
}

function quitarFechados(){
    if (quitardos.checked == true){
        $("#quit2").css({'display':'none'});
        periodo2.value="";
    }else{
        $("#quit2").css({'display':'flex'});
    }
}
</script>

<?php
require("./config.php");
$id_aplicacion = 'ap70';
xd_update('ap70',$nitavu);//guarda la experiencia del usuario
echo "<div id='AppDetalle'>".app_detalle($id_aplicacion, $nitavu)."</div>";
//PROCESO PARA TOCAR LA PUERTA DE SAN PEDRO
$nivel = aplicacion_nivel($id_aplicacion, $nitavu);

if (sanpedro($id_aplicacion, $nitavu) == TRUE){
    historia($nitavu, 'Entre a modificar la información de un pago');

    if(isset($_GET['id'])){
        $idpago = $_GET['id'];
        $idmandante = $_GET['idmandante'];
        $idcolonia = $_GET['idcolonia'];
        $idmunicipio = $_GET['idmunicipio'];
?>

<div class="cd-wrapper">
    <!-- Hero Banner -->
    <div class="cd-hero">
        <div>
            <h1 class="cd-hero-title">
                <i class="fa-solid fa-pen-to-square"></i> Modificar Registro de Pago #<?php echo $idpago; ?>
            </h1>
            <div class="cd-hero-dept">
                <i class="fa-solid fa-building-columns"></i> Control Financiero ITAVU 2026
            </div>
        </div>
        <div class="cd-top-links">
            <a href="mandantes_pago.php?idmandante=<?php echo $idmandante; ?>&idcolonia=<?php echo $idcolonia; ?>&idmunicipio=<?php echo $idmunicipio; ?>" class="cd-top-link-btn" title="Regresar al módulo de pago">
                <i class="fa-solid fa-arrow-left"></i> Regresar a Pago
            </a>
        </div>
    </div>

    <div class="cd-card-section">
        <div class="cd-card-header cd-card-header-primary">
            <h3 class="cd-card-title">
                <i class="fa-solid fa-file-signature"></i> Editar Datos Financieros del Pago
            </h3>
        </div>
        <div class="cd-card-body">
            <?php
            $sql = "SELECT * FROM mandantes_abonos WHERE id= ".$idpago."";
            $rc = $conexion->query($sql);
            if ($rc && $rc->num_rows > 0){
                while($r = $rc->fetch_array()){
                    if($r['tipoMov'] == 3){
            ?>
                        <form name="formulario" id="formulario" method="post" action="mandantes_pago.php?idmandante=<?php echo $r["idmandante"]; ?>&idcolonia=<?php echo $r['idcolonia']; ?>&idmunicipio=<?php echo $r['idmunicipio']; ?>&idpago=<?php echo $r['id']; ?>">
                            
                            <div class="cd-card-section" style="padding:15px; margin-bottom:18px;">
                                <div class="cd-form-grid">
                                    <?php if($r['periodopago'] == $r['periodopago2']): ?>
                                        <div class="cd-form-group">
                                            <label class="cd-form-label"><input type="checkbox" id="fechados" name="fechados" onClick="mostrarFechados()"> Habilitar Rango Periodo</label>
                                            <label class="cd-form-label"><i class="fa-regular fa-calendar"></i> Fecha 1</label>
                                            <input type="date" name="fecha" id="fecha" value="<?php echo $r['periodopago']; ?>" class="cd-form-control" required>
                                        </div>
                                        <div class="cd-form-group" id="fech2" style="display:none;">
                                            <label class="cd-form-label"><i class="fa-regular fa-calendar-check"></i> Fecha 2</label>
                                            <input type="date" name="periodo2" id="periodo2" value="<?php echo $r['periodopago2']; ?>" class="cd-form-control">
                                        </div>
                                    <?php else: ?>
                                        <div class="cd-form-group">
                                            <label class="cd-form-label"><input type="checkbox" id="quitardos" name="quitardos" onClick="quitarFechados()" checked> Rango Periodo Activo</label>
                                            <label class="cd-form-label"><i class="fa-regular fa-calendar"></i> Fecha 1</label>
                                            <input type="date" name="fecha" id="fecha" value="<?php echo $r['periodopago']; ?>" class="cd-form-control" required>
                                        </div>
                                        <div class="cd-form-group" id="quit2">
                                            <label class="cd-form-label"><i class="fa-regular fa-calendar-check"></i> Fecha 2</label>
                                            <input type="date" name="periodo2" id="periodo2" value="<?php echo $r['periodopago2']; ?>" class="cd-form-control">
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>

                            <div class="cd-form-grid-3">
                                <div class="cd-form-group">
                                    <label class="cd-form-label"><i class="fa-solid fa-dollar-sign"></i> Recuperación</label>
                                    <input type="number" step="any" placeholder="$0.00" value="<?php echo $r['recuperacion']; ?>" name="recuperacion" id="recuperacion" class="cd-form-control" required>
                                </div>
                                <div class="cd-form-group">
                                    <label class="cd-form-label"><i class="fa-solid fa-percent"></i> % Amort. Anticipo</label>
                                    <input type="number" step="any" placeholder="%" name="pamorAnt" id="pamorAnt" value="<?php echo $r['pamorAnt']; ?>" class="cd-form-control" required>
                                </div>
                                <div class="cd-form-group">
                                    <label class="cd-form-label"><i class="fa-solid fa-hand-holding-dollar"></i> Amortización Anticipo</label>
                                    <input type="number" step="any" placeholder="$0.00" name="amorAnticipo" id="amorAnticipo" value="<?php echo $r['amortizacion_anticipo']; ?>" class="cd-form-control" required>
                                </div>
                            </div>

                            <div class="cd-form-grid-3">
                                <div class="cd-form-group">
                                    <label class="cd-form-label"><i class="fa-solid fa-money-bill-wave"></i> Monto por Pagar</label>
                                    <input type="number" step="any" placeholder="$0.00" name="montopagar" id="montopagar" value="<?php echo $r['montopagar']; ?>" class="cd-form-control" required>
                                </div>
                                <div class="cd-form-group">
                                    <label class="cd-form-label"><i class="fa-solid fa-percent"></i> % Gastos Admon</label>
                                    <input type="number" step="any" placeholder="%" name="pgastos" id="pgastos" value="<?php echo $r['pgastos']; ?>" class="cd-form-control" required>
                                </div>
                                <div class="cd-form-group">
                                    <label class="cd-form-label"><i class="fa-solid fa-file-invoice"></i> Gastos Admon.</label>
                                    <input type="number" step="any" placeholder="$0.00" name="gastos" id="gastos" value="<?php echo $r['gastos']; ?>" class="cd-form-control" required>
                                </div>
                            </div>

                            <div class="cd-form-grid-3">
                                <div class="cd-form-group">
                                    <label class="cd-form-label"><i class="fa-solid fa-percent"></i> % Gastos Escrituración</label>
                                    <input type="number" step="any" placeholder="%" name="pgastosesc" id="pgastosesc" value="<?php echo $r['pgastosesc']; ?>" class="cd-form-control" required>
                                </div>
                                <div class="cd-form-group">
                                    <label class="cd-form-label"><i class="fa-solid fa-file-signature"></i> Gastos Escrituración</label>
                                    <input type="number" step="any" placeholder="$0.00" name="gastosesc" id="gastosesc" value="<?php echo $r['gastosesc']; ?>" class="cd-form-control" required>
                                </div>
                                <div class="cd-form-group">
                                    <label class="cd-form-label"><i class="fa-solid fa-arrow-rotate-left"></i> Devoluciones</label>
                                    <input type="number" step="any" placeholder="$0.00" name="devols" id="devols" value="<?php echo $r['devols']; ?>" class="cd-form-control">
                                </div>
                            </div>

                            <div class="cd-form-grid-3">
                                <div class="cd-form-group">
                                    <label class="cd-form-label"><i class="fa-solid fa-tags"></i> Otros Descuentos</label>
                                    <input type="number" step="any" placeholder="$0.00" name="otrosdesc" id="otrosdesc" value="<?php echo $r['otrosdesc']; ?>" class="cd-form-control">
                                </div>
                                <div class="cd-form-group">
                                    <label class="cd-form-label" style="color:var(--cd-primary); font-weight:700;"><i class="fa-solid fa-circle-check"></i> Monto Pagado</label>
                                    <input type="number" step="any" placeholder="$0.00" name="montoPagado" id="montoPagado" value="<?php echo $r['monto_pagado']; ?>" class="cd-form-control" style="border-color:var(--cd-primary); font-weight:700;" required>
                                </div>
                                <div class="cd-form-group">
                                    <label class="cd-form-label"><i class="fa-solid fa-desktop"></i> Recup. por Sistema</label>
                                    <input type="number" step="any" placeholder="$0.00" name="sistema" id="sistema" value="<?php echo $r['recuperacion_sistema']; ?>" class="cd-form-control" required>
                                </div>
                            </div>

                            <div class="cd-form-grid" style="background:#f8fafc; padding:12px; border-radius:var(--cd-radius-sm); margin-bottom:15px;">
                                <div class="cd-form-group">
                                    <label class="cd-form-label"><i class="fa-solid fa-layer-group"></i> Monto Acumulado</label>
                                    <input type="number" step="any" placeholder="$0.00" name="montoAcumulado" id="montoAcumulado" value="<?php echo $r['monto_acumulado']; ?>" class="cd-form-control" required>
                                </div>
                                <div class="cd-form-group">
                                    <label class="cd-form-label"><i class="fa-solid fa-wallet"></i> Saldo Actual</label>
                                    <input type="number" step="any" placeholder="$0.00" name="saldo" id="saldo" value="<?php echo $r['saldo']; ?>" class="cd-form-control" required>
                                </div>
                            </div>

                            <h4 style="font-size:0.95rem; font-weight:700; color:var(--cd-dark); margin:15px 0 10px 0; border-bottom:2px solid var(--cd-gold-light); padding-bottom:4px;">
                                <i class="fa-solid fa-sliders"></i> Ajustes Adicionales (+/-)
                            </h4>

                            <div class="cd-form-grid">
                                <div class="cd-form-group">
                                    <label class="cd-form-label">Enganche ahorro por identificar y traspasar</label>
                                    <div style="display:flex; gap:8px;">
                                        <select id="mas_menos2" name="mas_menos2" class="cd-form-control" style="width:90px;">
                                            <option value="1" <?php echo ('1' == $r['signo2']) ? 'selected' : ''; ?>>más (+)</option>
                                            <option value="2" <?php echo ('2' == $r['signo2']) ? 'selected' : ''; ?>>menos (-)</option>
                                        </select>
                                        <input type="number" step="any" placeholder="$0.00" name="engancheAhorro" id="engancheAhorro" value="<?php echo $r['enganche_ahorro']; ?>" class="cd-form-control">
                                    </div>
                                </div>

                                <div class="cd-form-group">
                                    <label class="cd-form-label">Descuento por nómina</label>
                                    <div style="display:flex; gap:8px;">
                                        <select id="mas_menos1" name="mas_menos1" class="cd-form-control" style="width:90px;">
                                            <option value="1" <?php echo ('1' == $r['signo1']) ? 'selected' : ''; ?>>más (+)</option>
                                            <option value="2" <?php echo ('2' == $r['signo1']) ? 'selected' : ''; ?>>menos (-)</option>
                                        </select>
                                        <input type="number" step="any" placeholder="$0.00" name="desNomina" id="desNomina" value="<?php echo $r['descuento_nomina']; ?>" class="cd-form-control">
                                    </div>
                                </div>
                            </div>

                            <div class="cd-form-grid">
                                <div class="cd-form-group">
                                    <label class="cd-form-label">Por transferencia</label>
                                    <div style="display:flex; gap:8px;">
                                        <select id="mas_menos3" name="mas_menos3" class="cd-form-control" style="width:90px;">
                                            <option value="1" <?php echo ('1' == $r['signo3']) ? 'selected' : ''; ?>>más (+)</option>
                                            <option value="2" <?php echo ('2' == $r['signo3']) ? 'selected' : ''; ?>>menos (-)</option>
                                        </select>
                                        <input type="number" step="any" placeholder="$0.00" name="transferencia" id="transferencia" value="<?php echo $r['transferencia']; ?>" class="cd-form-control">
                                    </div>
                                </div>

                                <div class="cd-form-group">
                                    <label class="cd-form-label">Por pagos universales</label>
                                    <div style="display:flex; gap:8px;">
                                        <select id="mas_menos4" name="mas_menos4" class="cd-form-control" style="width:90px;">
                                            <option value="1" <?php echo ('1' == $r['signo4']) ? 'selected' : ''; ?>>más (+)</option>
                                            <option value="2" <?php echo ('2' == $r['signo4']) ? 'selected' : ''; ?>>menos (-)</option>
                                        </select>
                                        <input type="number" step="any" placeholder="$0.00" name="pagosUniversales" id="pagosUniversales" value="<?php echo $r['pagos_universales']; ?>" class="cd-form-control">
                                    </div>
                                </div>
                            </div>

                            <div class="cd-form-grid">
                                <div class="cd-form-group">
                                    <label class="cd-form-label">Por concepto de escritura</label>
                                    <div style="display:flex; gap:8px;">
                                        <select id="mas_menos5" name="mas_menos5" class="cd-form-control" style="width:90px;">
                                            <option value="1" <?php echo ('1' == $r['signo5']) ? 'selected' : ''; ?>>más (+)</option>
                                            <option value="2" <?php echo ('2' == $r['signo5']) ? 'selected' : ''; ?>>menos (-)</option>
                                        </select>
                                        <input type="number" step="any" placeholder="$0.00" name="escritura" id="escritura" value="<?php echo $r['escritura']; ?>" class="cd-form-control">
                                    </div>
                                </div>

                                <div class="cd-form-group">
                                    <label class="cd-form-label">Por cesión de derechos</label>
                                    <div style="display:flex; gap:8px;">
                                        <select id="mas_menos6" name="mas_menos6" class="cd-form-control" style="width:90px;">
                                            <option value="1" <?php echo ('1' == $r['signo6']) ? 'selected' : ''; ?>>más (+)</option>
                                            <option value="2" <?php echo ('2' == $r['signo6']) ? 'selected' : ''; ?>>menos (-)</option>
                                        </select>
                                        <input type="number" step="any" placeholder="$0.00" name="derechos" id="derechos" value="<?php echo $r['derechos']; ?>" class="cd-form-control">
                                    </div>
                                </div>
                            </div>

                            <div class="cd-form-grid">
                                <div class="cd-form-group">
                                    <label class="cd-form-label">Por pago de derechos</label>
                                    <div style="display:flex; gap:8px;">
                                        <select id="mas_menos7" name="mas_menos7" class="cd-form-control" style="width:90px;">
                                            <option value="1" <?php echo ('1' == $r['signo7']) ? 'selected' : ''; ?>>más (+)</option>
                                            <option value="2" <?php echo ('2' == $r['signo7']) ? 'selected' : ''; ?>>menos (-)</option>
                                        </select>
                                        <input type="number" step="any" placeholder="$0.00" name="pagoDerechos" id="pagoDerechos" value="<?php echo $r['pago_derechos']; ?>" class="cd-form-control">
                                    </div>
                                </div>

                                <div class="cd-form-group">
                                    <label class="cd-form-label">Por pago en OXXO</label>
                                    <div style="display:flex; gap:8px;">
                                        <select id="mas_menos8" name="mas_menos8" class="cd-form-control" style="width:90px;">
                                            <option value="1" <?php echo ('1' == $r['signo8']) ? 'selected' : ''; ?>>más (+)</option>
                                            <option value="2" <?php echo ('2' == $r['signo8']) ? 'selected' : ''; ?>>menos (-)</option>
                                        </select>
                                        <input type="number" step="any" placeholder="$0.00" name="pagooxxo" id="pagooxxo" value="<?php echo $r['oxxo']; ?>" class="cd-form-control">
                                    </div>
                                </div>
                            </div>

                            <div class="cd-form-grid">
                                <div class="cd-form-group">
                                    <label class="cd-form-label">Otros Pagos</label>
                                    <div style="display:flex; gap:8px;">
                                        <select id="mas_menos9" name="mas_menos9" class="cd-form-control" style="width:90px;">
                                            <option value="1" <?php echo ('1' == $r['signo9']) ? 'selected' : ''; ?>>más (+)</option>
                                            <option value="2" <?php echo ('2' == $r['signo9']) ? 'selected' : ''; ?>>menos (-)</option>
                                        </select>
                                        <input type="number" step="any" placeholder="$0.00" name="pagootros" id="pagootros" value="<?php echo $r['pagootros']; ?>" class="cd-form-control">
                                    </div>
                                </div>

                                <div class="cd-form-group">
                                    <label class="cd-form-label"><i class="fa-solid fa-building-columns"></i> Datos Bancarios</label>
                                    <input type="text" placeholder="Datos bancarios" name="datos_bancarios" id="datos_bancarios" value="<?php echo htmlspecialchars($r['datos_bancarios']); ?>" class="cd-form-control">
                                </div>
                            </div>

                            <div class="cd-form-grid">
                                <div class="cd-form-group">
                                    <label class="cd-form-label"><i class="fa-solid fa-comment-dots"></i> Comentario</label>
                                    <textarea name="comentario" id="comentario" class="cd-form-control" style="min-height:70px;"><?php echo htmlspecialchars($r['numero_oficio']); ?></textarea>
                                </div>
                                <div class="cd-form-group">
                                    <label class="cd-form-label"><i class="fa-solid fa-pen-to-square"></i> Observación para pago</label>
                                    <textarea name="observacionPago" id="observacionPago" class="cd-form-control" style="min-height:70px;"><?php echo htmlspecialchars($r['observacionPago']); ?></textarea>
                                </div>
                            </div>

                            <div style="margin-top:20px; text-align:right;">
                                <button type="submit" class="cd-btn cd-btn-primary" id="guardar">
                                    <i class="fa-solid fa-floppy-disk"></i> Guardar Cambios
                                </button>
                            </div>
                        </form>
            <?php
                    } else {
            ?>
                        <form name="formulario" id="formulario" method="post" action="mandantes_pago.php?idmandante=<?php echo $r["idmandante"]; ?>&idcolonia=<?php echo $r['idcolonia']; ?>&idmunicipio=<?php echo $r['idmunicipio']; ?>&idpago=<?php echo $r['id']; ?>">
                            <div class="cd-form-grid">
                                <div class="cd-form-group">
                                    <label class="cd-form-label"><i class="fa-regular fa-calendar"></i> Fecha de Pago</label>
                                    <input type="date" name="fecha2" id="fecha2" value="<?php echo $r['periodopago']; ?>" class="cd-form-control" required>
                                </div>
                                <div class="cd-form-group">
                                    <label class="cd-form-label"><i class="fa-solid fa-dollar-sign"></i> Monto Pagado</label>
                                    <input type="number" step="any" placeholder="$0.00" name="montoPagado2" id="montoPagado2" value="<?php echo $r['monto_pagado']; ?>" class="cd-form-control" required>
                                </div>
                            </div>

                            <div class="cd-form-grid">
                                <div class="cd-form-group">
                                    <label class="cd-form-label"><i class="fa-solid fa-layer-group"></i> Monto Acumulado</label>
                                    <input type="number" step="any" placeholder="$0.00" name="montoAcumulado2" id="montoAcumulado2" value="<?php echo $r['monto_acumulado']; ?>" class="cd-form-control" required>
                                </div>
                                <div class="cd-form-group">
                                    <label class="cd-form-label"><i class="fa-solid fa-wallet"></i> Saldo Actual</label>
                                    <input type="number" step="any" placeholder="$0.00" name="saldo2" id="saldo2" value="<?php echo $r['saldo']; ?>" class="cd-form-control" required>
                                </div>
                            </div>

                            <div class="cd-form-grid">
                                <div class="cd-form-group">
                                    <label class="cd-form-label"><i class="fa-solid fa-comment-dots"></i> Comentario</label>
                                    <input type="text" placeholder="Comentario..." name="comentario" id="comentario" value="<?php echo htmlspecialchars($r['numero_oficio']); ?>" class="cd-form-control" required>
                                </div>
                                <div class="cd-form-group">
                                    <label class="cd-form-label"><i class="fa-solid fa-building-columns"></i> Datos Bancarios</label>
                                    <input type="text" placeholder="Datos Bancarios" name="datos_bancarios" id="datos_bancarios" value="<?php echo htmlspecialchars($r['datos_bancarios']); ?>" class="cd-form-control" required>
                                </div>
                            </div>

                            <div style="margin-top:20px; text-align:right;">
                                <button type="submit" class="cd-btn cd-btn-primary" id="guardar">
                                    <i class="fa-solid fa-floppy-disk"></i> Guardar Cambios
                                </button>
                            </div>
                        </form>
            <?php
                    }
                }
            }
            ?>
        </div>
    </div>
</div>

<?php
    }
} else {
    mensaje("No tiene acceso a ".$id_aplicacion,'');
}
include ("./lib/body_footer.php"); 
?>