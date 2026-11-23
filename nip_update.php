<?php
include("./lib/body_head.php");
include("./lib/body_menu.php");

$id_aplicacion = "ap01";

if (empty($_SESSION['csrf_nip_update'])) {
    $_SESSION['csrf_nip_update'] = bin2hex(random_bytes(32));
}
$csrfToken = $_SESSION['csrf_nip_update'];
$maxLen = function_exists('itavu_nip_max_len') ? itavu_nip_max_len($conexion) : 20;

// Revisar si la contraseña actual ya cumple con el nuevo esquema de seguridad
$nipActualActualizado = true;
if (function_exists('nitavu_nip') && function_exists('itavu_validar_password_segura')) {
    $nipEnBd = (string)nitavu_nip($nitavu);
    if ($nipEnBd !== '') {
        $evalActual = itavu_validar_password_segura($nipEnBd, $nitavu, $maxLen);
        $nipActualActualizado = !empty($evalActual['valida']);
    }
}

echo "<div id='AppDetalle'>" . app_detalle($id_aplicacion, $nitavu) . "</div>";
?>

<style>
    body {
        background-color: #f1f5f9 !important;
    }

    #AppDetalle {
        background-color: rgba(107, 15, 26, 0.92) !important;
        border-bottom: 3px solid #bc955c;
    }

    .nip-wrapper {
        max-width: 1040px;
        margin: 78px auto 48px;
        padding: 0 20px;
        font-family: 'Segoe UI', Arial, sans-serif;
        text-align: left;
    }

    .nip-wrapper * {
        box-sizing: border-box;
    }

    /* Neutralizar estilos legados de lib/css_estructura.css sobre form, div, span e input */
    #formNipUpdate {
        text-align: left !important;
        padding: 0 !important;
        margin: 0 !important;
        width: 100% !important;
    }

    #formNipUpdate div {
        width: auto;
        display: block;
        margin: 0;
        vertical-align: baseline;
        text-align: left;
    }

    #formNipUpdate span {
        width: auto !important;
        text-align: left !important;
    }

    .nip-alert-banner {
        background: linear-gradient(135deg, #6b0f1a 0%, #8a1520 100%);
        color: #fff;
        border-radius: 14px;
        border-left: 5px solid #bc955c;
        padding: 14px 18px;
        margin-bottom: 22px;
        display: flex;
        align-items: center;
        gap: 12px;
        box-shadow: 0 8px 20px rgba(107, 15, 26, 0.16);
        font-size: 13.5px;
        line-height: 1.5;
    }

    .nip-alert-banner i {
        color: #e3c28d;
        font-size: 20px;
        flex-shrink: 0;
    }

    .nip-grid {
        display: grid;
        grid-template-columns: minmax(0, 1.25fr) minmax(0, 0.85fr);
        gap: 26px;
        align-items: start;
    }

    .nip-card {
        background: #ffffff;
        border-radius: 18px;
        border: 1px solid #e2e8f0;
        box-shadow: 0 12px 32px rgba(15, 23, 42, 0.06);
        overflow: hidden;
    }

    .nip-card-header {
        background: linear-gradient(135deg, #6b0f1a 0%, #990000 100%);
        color: #ffffff;
        padding: 22px 26px;
        border-bottom: 3px solid #bc955c;
        text-align: left;
    }

    .nip-card-tag {
        display: inline-block;
        background: rgba(188, 149, 92, 0.22);
        border: 1px solid rgba(227, 194, 141, 0.45);
        color: #f3dfb8;
        font-size: 10.5px;
        font-weight: 700;
        letter-spacing: 0.08em;
        padding: 3px 10px;
        border-radius: 50px;
        margin-bottom: 8px;
        text-transform: uppercase;
    }

    .nip-card-title {
        font-size: 20px !important;
        font-weight: 700 !important;
        color: #ffffff !important;
        margin: 0 !important;
        line-height: 1.3 !important;
        text-align: left !important;
        letter-spacing: normal !important;
    }

    .nip-card-sub {
        font-size: 13px;
        color: rgba(255, 255, 255, 0.85);
        margin-top: 5px;
    }

    .nip-card-body {
        padding: 26px;
    }

    #formNipUpdate .nip-field {
        display: block !important;
        width: 100% !important;
        margin-bottom: 18px !important;
    }

    #formNipUpdate .nip-field label {
        display: block !important;
        width: 100% !important;
        font-size: 11.5px;
        font-weight: 700;
        color: #475569;
        text-transform: uppercase;
        letter-spacing: 0.04em;
        margin-bottom: 6px;
        text-align: left !important;
    }

    #formNipUpdate div.nip-input-wrap {
        display: flex !important;
        flex-direction: row !important;
        flex-wrap: nowrap !important;
        align-items: center !important;
        width: 100% !important;
        background: #f8fafc;
        border: 1.5px solid #cbd5e1;
        border-radius: 10px;
        padding: 0 12px !important;
        transition: border-color 0.2s, background 0.2s, box-shadow 0.2s;
    }

    #formNipUpdate .nip-input-wrap:focus-within {
        border-color: #990000;
        background: #ffffff;
        box-shadow: 0 0 0 3px rgba(153, 0, 0, 0.08);
    }

    #formNipUpdate .nip-input-wrap.is-valid {
        border-color: #16a34a;
    }

    #formNipUpdate .nip-input-wrap.is-invalid {
        border-color: #dc2626;
    }

    #formNipUpdate .nip-input-icon {
        display: inline-flex !important;
        align-items: center !important;
        justify-content: center !important;
        width: auto !important;
        color: #94a3b8;
        margin-right: 10px;
        font-size: 14px;
        flex-shrink: 0;
    }

    #formNipUpdate .nip-input-wrap input {
        flex: 1 1 auto !important;
        width: 100% !important;
        min-width: 0 !important;
        height: 42px !important;
        border: none !important;
        background: transparent !important;
        padding: 0 6px 0 0 !important;
        margin: 0 !important;
        font-family: 'Segoe UI', Arial, sans-serif !important;
        font-size: 14px !important;
        color: #0f172a !important;
        outline: none !important;
        box-shadow: none !important;
    }

    #formNipUpdate .nip-eye-btn {
        background: none !important;
        border: none !important;
        width: auto !important;
        height: auto !important;
        color: #94a3b8;
        cursor: pointer;
        padding: 6px;
        display: inline-flex !important;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        transition: color 0.2s;
    }

    #formNipUpdate .nip-eye-btn:hover {
        color: #7c121d;
    }

    /* Medidor de fortaleza */
    #formNipUpdate .strength-box {
        display: block !important;
        width: 100% !important;
        margin-top: 9px !important;
    }

    #formNipUpdate div.strength-bar-bg {
        display: block !important;
        width: 100% !important;
        height: 7px;
        border-radius: 99px;
        background: #e2e8f0;
        overflow: hidden;
    }

    #formNipUpdate div.strength-bar-fill {
        display: block !important;
        height: 100%;
        width: 0%;
        border-radius: 99px;
        background: #dc2626;
        transition: width 0.25s ease, background-color 0.25s ease;
    }

    #formNipUpdate div.strength-meta {
        display: flex !important;
        flex-direction: row !important;
        flex-wrap: nowrap !important;
        width: 100% !important;
        justify-content: space-between !important;
        align-items: center !important;
        margin-top: 6px !important;
        font-size: 12px;
        color: #64748b;
    }

    #formNipUpdate .strength-label {
        font-weight: 700;
    }

    /* Checklist interactivo */
    #formNipUpdate .req-box {
        display: block !important;
        width: 100% !important;
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        padding: 15px 18px !important;
        margin-bottom: 18px !important;
    }

    #formNipUpdate .req-box-title {
        display: block !important;
        width: 100% !important;
        font-size: 11.5px;
        font-weight: 700;
        color: #334155;
        text-transform: uppercase;
        letter-spacing: 0.04em;
        margin-bottom: 10px !important;
    }

    .req-list {
        list-style: none;
        padding: 0;
        margin: 0;
        display: flex;
        flex-direction: column;
        gap: 8px;
    }

    .req-item {
        display: flex;
        align-items: center;
        gap: 9px;
        font-size: 13px;
        color: #64748b;
        line-height: 1.4;
        transition: color 0.2s;
    }

    #formNipUpdate .req-item .req-icon {
        width: 19px !important;
        height: 19px !important;
        border-radius: 50%;
        background: #e2e8f0;
        color: #64748b;
        display: inline-flex !important;
        align-items: center;
        justify-content: center;
        text-align: center !important;
        font-size: 10.5px;
        font-weight: 700;
        flex-shrink: 0;
        transition: background-color 0.2s, color 0.2s;
    }

    .req-item.ok {
        color: #15803d;
        font-weight: 600;
    }

    #formNipUpdate .req-item.ok .req-icon {
        background: #16a34a;
        color: #ffffff;
    }

    #formNipUpdate .req-code,
    .req-code {
        display: inline-block !important;
        width: auto !important;
        background: #e2e8f0;
        color: #334155;
        padding: 1px 6px;
        border-radius: 4px;
        font-family: Consolas, monospace;
        font-size: 11.5px;
    }

    #formNipUpdate .req-item.ok .req-code {
        background: #dcfce7;
        color: #166534;
    }

    /* Mensajes */
    #formNipUpdate .nip-feedback {
        display: none !important;
        width: 100% !important;
        border-radius: 10px;
        padding: 12px 14px !important;
        margin-bottom: 16px !important;
        font-size: 13px;
        line-height: 1.45;
    }

    #formNipUpdate .nip-feedback.error {
        display: block !important;
        background: #fef2f2;
        border: 1px solid #fecaca;
        color: #991b1b;
    }

    #formNipUpdate .nip-feedback.success {
        display: block !important;
        background: #f0fdf4;
        border: 1px solid #bbf7d0;
        color: #166534;
    }

    .nip-feedback ul {
        margin: 6px 0 0 18px;
        padding: 0;
    }

    .nip-btn-submit {
        width: 100%;
        background: #990000;
        color: #ffffff;
        border: none;
        border-radius: 10px;
        padding: 13px 18px;
        font-size: 14.5px;
        font-weight: 600;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        transition: background-color 0.2s, transform 0.1s, opacity 0.2s;
    }

    .nip-btn-submit:hover:not(:disabled) {
        background: #7a0000;
    }

    .nip-btn-submit:active:not(:disabled) {
        transform: scale(0.99);
    }

    .nip-btn-submit:disabled {
        opacity: 0.55;
        cursor: not-allowed;
    }

    #formNipUpdate .nip-back-wrap {
        display: block !important;
        width: 100% !important;
        text-align: center !important;
        margin-top: 14px !important;
    }

    /* Panel derecho de recomendaciones */
    .tips-card {
        background: #ffffff;
        border-radius: 18px;
        border: 1px solid #e2e8f0;
        border-top: 4px solid #bc955c;
        box-shadow: 0 12px 32px rgba(15, 23, 42, 0.05);
        padding: 24px;
        text-align: left;
    }

    .tips-title {
        font-size: 15.5px;
        font-weight: 700;
        color: #0f172a;
        display: flex;
        align-items: center;
        gap: 8px;
        margin-bottom: 16px;
    }

    .tips-title i {
        color: #7c121d;
    }

    .tips-list {
        list-style: none;
        padding: 0;
        margin: 0 0 18px 0;
        display: flex;
        flex-direction: column;
        gap: 13px;
    }

    .tips-list li {
        display: flex;
        align-items: flex-start;
        gap: 10px;
        font-size: 13px;
        color: #475569;
        line-height: 1.55;
    }

    .tips-bullet {
        width: 24px;
        height: 24px;
        border-radius: 7px;
        background: #fef2f2;
        color: #990000;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 11px;
        flex-shrink: 0;
        margin-top: 1px;
    }

    .tips-support {
        background: #fdf8f3;
        border: 1px solid #e8d5bc;
        border-left: 4px solid #bc955c;
        border-radius: 10px;
        padding: 13px 15px;
        font-size: 12.5px;
        color: #4a3728;
        line-height: 1.55;
    }

    .tips-support b {
        color: #6b0f1a;
    }

    .nip-back-link {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        color: #7c121d;
        font-size: 13px;
        font-weight: 600;
        text-decoration: none;
    }

    .nip-back-link:hover {
        text-decoration: underline;
    }

    @media (max-width: 860px) {
        .nip-grid {
            grid-template-columns: 1fr;
        }
    }
</style>

<div class="nip-wrapper">
    <?php if (!$nipActualActualizado): ?>
        <div class="nip-alert-banner">
            <i class="fa-solid fa-shield-halved"></i>
            <div>
                <b>Actualización recomendada:</b> Tu contraseña actual aún no cumple con el nuevo esquema de seguridad institucional. Te recomendamos actualizarla ahora mismo para proteger tu cuenta.
            </div>
        </div>
    <?php endif; ?>

    <div class="nip-grid">
        <!-- FORMULARIO -->
        <div class="nip-card">
            <div class="nip-card-header">
                <div class="nip-card-tag">Nuevo Esquema de Seguridad</div>
                <h2 class="nip-card-title">Actualizar Contraseña (NIP)</h2>
                <div class="nip-card-sub">
                    Usuario: <b><?php echo htmlspecialchars((string)$nitavu, ENT_QUOTES, 'UTF-8'); ?></b> · <?php echo htmlspecialchars((string)nitavu_nombre($nitavu), ENT_QUOTES, 'UTF-8'); ?>
                </div>
            </div>

            <div class="nip-card-body">
                <form id="formNipUpdate" autocomplete="off" onsubmit="event.preventDefault(); NipUpdate();">
                    <input type="hidden" id="csrfToken" value="<?php echo htmlspecialchars($csrfToken, ENT_QUOTES, 'UTF-8'); ?>">

                    <div id="nipFeedback" class="nip-feedback" role="alert"></div>

                    <div class="nip-field">
                        <label for="NipActual">Contraseña actual</label>
                        <div class="nip-input-wrap" id="wrapNipActual">
                            <span class="nip-input-icon"><i class="fa-solid fa-lock"></i></span>
                            <input type="password" id="NipActual" name="NipActual" placeholder="Ingresa tu contraseña actual" autocomplete="current-password" required>
                            <button type="button" class="nip-eye-btn" onclick="toggleCampoNip('NipActual', this)" title="Mostrar u ocultar">
                                <i class="fa-regular fa-eye"></i>
                            </button>
                        </div>
                    </div>

                    <div class="nip-field">
                        <label for="NipNuevo1">Contraseña nueva</label>
                        <div class="nip-input-wrap" id="wrapNipNuevo1">
                            <span class="nip-input-icon"><i class="fa-solid fa-key"></i></span>
                            <input type="password" id="NipNuevo1" name="NipNuevo1" maxlength="<?php echo (int)$maxLen; ?>" placeholder="Crea una contraseña segura" autocomplete="new-password" required>
                            <button type="button" class="nip-eye-btn" onclick="toggleCampoNip('NipNuevo1', this)" title="Mostrar u ocultar">
                                <i class="fa-regular fa-eye"></i>
                            </button>
                        </div>

                        <div class="strength-box">
                            <div class="strength-bar-bg">
                                <div class="strength-bar-fill" id="strengthFill"></div>
                            </div>
                            <div class="strength-meta">
                                <span>Nivel de seguridad: <span class="strength-label" id="strengthLabel">Sin evaluar</span></span>
                                <span id="charCount">0 / <?php echo (int)$maxLen; ?></span>
                            </div>
                        </div>
                    </div>

                    <div class="req-box">
                        <div class="req-box-title">Requisitos obligatorios de la nueva contraseña</div>
                        <ul class="req-list">
                            <li class="req-item" id="reqLen"><span class="req-icon">•</span><span>Longitud mínima de <b>8 caracteres</b> (máx. <?php echo (int)$maxLen; ?>)</span></li>
                            <li class="req-item" id="reqUpper"><span class="req-icon">•</span><span>Mínimo <b>1 letra mayúscula</b> <span class="req-code">A-Z</span></span></li>
                            <li class="req-item" id="reqLower"><span class="req-icon">•</span><span>Mínimo <b>1 letra minúscula</b> <span class="req-code">a-z</span></span></li>
                            <li class="req-item" id="reqDigit"><span class="req-icon">•</span><span>Mínimo <b>1 dígito</b> <span class="req-code">0-9</span></span></li>
                            <li class="req-item" id="reqSymbol"><span class="req-icon">•</span><span>Mínimo <b>1 símbolo</b> <span class="req-code">! @ # $ % &amp; * _ -</span></span></li>
                            <li class="req-item" id="reqNoSpace"><span class="req-icon">•</span><span>Sin espacios en blanco y distinta a tu No. de empleado</span></li>
                            <li class="req-item" id="reqMatch"><span class="req-icon">•</span><span>Coincide con la confirmación de contraseña</span></li>
                        </ul>
                    </div>

                    <div class="nip-field">
                        <label for="NipNuevo2">Confirme contraseña nueva</label>
                        <div class="nip-input-wrap" id="wrapNipNuevo2">
                            <span class="nip-input-icon"><i class="fa-solid fa-check-double"></i></span>
                            <input type="password" id="NipNuevo2" name="NipNuevo2" maxlength="<?php echo (int)$maxLen; ?>" placeholder="Vuelve a escribir la nueva contraseña" autocomplete="new-password" required>
                            <button type="button" class="nip-eye-btn" onclick="toggleCampoNip('NipNuevo2', this)" title="Mostrar u ocultar">
                                <i class="fa-regular fa-eye"></i>
                            </button>
                        </div>
                    </div>

                    <button type="submit" class="nip-btn-submit" id="btnActualizar" disabled>
                        <i class="fa-solid fa-shield-check"></i>
                        <span id="btnActualizarTexto">Actualizar contraseña ahora</span>
                    </button>

                    <div class="nip-back-wrap">
                        <a href="index.php" class="nip-back-link">
                            <i class="fa-solid fa-arrow-left"></i> Volver al menú principal
                        </a>
                    </div>
                </form>
            </div>
        </div>

        <!-- PANEL DE CONSEJOS Y SOPORTE -->
        <div class="tips-card">
            <div class="tips-title">
                <i class="fa-solid fa-shield-halved"></i>
                <span>Recomendaciones de Seguridad</span>
            </div>

            <ul class="tips-list">
                <li>
                    <span class="tips-bullet"><i class="fa-solid fa-user-lock"></i></span>
                    <span>Tu contraseña es <b>personal e intransferible</b>. No la compartas con nadie ni utilices claves que uses en correos o redes sociales.</span>
                </li>
                <li>
                    <span class="tips-bullet"><i class="fa-solid fa-calendar-xmark"></i></span>
                    <span>Evita datos fáciles de adivinar como fechas de nacimiento, aniversarios, tu número de empleado o secuencias simples (<span class="req-code">123456</span>).</span>
                </li>
                <li>
                    <span class="tips-bullet"><i class="fa-solid fa-laptop"></i></span>
                    <span>No guardes tu contraseña en el navegador si utilizas un equipo compartido y cierra siempre tu sesión al terminar.</span>
                </li>
                <li>
                    <span class="tips-bullet"><i class="fa-solid fa-clipboard-check"></i></span>
                    <span><b>Importante:</b> Todas las operaciones realizadas en la plataforma con tu usuario quedan registradas bajo tu responsabilidad.</span>
                </li>
            </ul>

            <div class="tips-support">
                <b>¿Necesitas apoyo con tu contraseña?</b><br>
                Comunícate al <b>Departamento de Informática</b>:<br>
                Tel. <b>(834) 318 55 16</b> · Exts. <b>46580</b>, <b>46530</b> y <b>46524</b>
            </div>
        </div>
    </div>
</div>

<script>
(function () {
    var NITAVU_ACTUAL = <?php echo json_encode((string)$nitavu); ?>;
    var MAX_LEN = <?php echo (int)$maxLen; ?>;

    window.toggleCampoNip = function (inputId, btn) {
        var inp = document.getElementById(inputId);
        if (!inp) return;
        var mostrar = (inp.type === 'password');
        inp.type = mostrar ? 'text' : 'password';
        var ico = btn ? btn.querySelector('i') : null;
        if (ico) {
            ico.className = mostrar ? 'fa-regular fa-eye-slash' : 'fa-regular fa-eye';
        }
    };

    function setReqState(id, ok) {
        var el = document.getElementById(id);
        if (!el) return;
        el.classList.toggle('ok', !!ok);
        var ico = el.querySelector('.req-icon');
        if (ico) {
            ico.textContent = ok ? '✓' : '•';
        }
    }

    function mostrarFeedback(tipo, mensaje, listaErrores) {
        var box = document.getElementById('nipFeedback');
        if (!box) return;
        box.className = 'nip-feedback ' + tipo;
        var html = '<strong>' + $('<div>').text(mensaje).html() + '</strong>';
        if (Array.isArray(listaErrores) && listaErrores.length > 0) {
            html += '<ul>';
            listaErrores.forEach(function (err) {
                html += '<li>' + $('<div>').text(err).html() + '</li>';
            });
            html += '</ul>';
        }
        box.innerHTML = html;
    }

    function ocultarFeedback() {
        var box = document.getElementById('nipFeedback');
        if (box) {
            box.className = 'nip-feedback';
            box.innerHTML = '';
        }
    }

    function evaluarFormulario() {
        var actual = $('#NipActual').val() || '';
        var nueva1 = $('#NipNuevo1').val() || '';
        var nueva2 = $('#NipNuevo2').val() || '';

        $('#charCount').text(nueva1.length + ' / ' + MAX_LEN);

        var okLen = nueva1.length >= 8 && nueva1.length <= MAX_LEN;
        var okUpper = /[A-Z]/.test(nueva1);
        var okLower = /[a-z]/.test(nueva1);
        var okDigit = /[0-9]/.test(nueva1);
        var okSymbol = /[^A-Za-z0-9\s]/.test(nueva1);
        var okNoSpace = nueva1.length > 0 && !/\s/.test(nueva1) && nueva1.toLowerCase() !== NITAVU_ACTUAL.toLowerCase();
        var okMatch = nueva1.length > 0 && nueva1 === nueva2;

        setReqState('reqLen', okLen);
        setReqState('reqUpper', okUpper);
        setReqState('reqLower', okLower);
        setReqState('reqDigit', okDigit);
        setReqState('reqSymbol', okSymbol);
        setReqState('reqNoSpace', okNoSpace);
        setReqState('reqMatch', okMatch);

        var puntos = 0;
        if (okLen) puntos++;
        if (okUpper) puntos++;
        if (okLower) puntos++;
        if (okDigit) puntos++;
        if (okSymbol) puntos++;
        if (nueva1.length >= 12) puntos++;

        var fill = document.getElementById('strengthFill');
        var label = document.getElementById('strengthLabel');
        if (nueva1.length === 0) {
            fill.style.width = '0%';
            fill.style.backgroundColor = '#cbd5e1';
            label.textContent = 'Sin evaluar';
            label.style.color = '#64748b';
        } else if (puntos <= 2) {
            fill.style.width = '30%';
            fill.style.backgroundColor = '#dc2626';
            label.textContent = 'Débil';
            label.style.color = '#dc2626';
        } else if (puntos <= 4) {
            fill.style.width = '65%';
            fill.style.backgroundColor = '#d97706';
            label.textContent = 'Media';
            label.style.color = '#d97706';
        } else if (puntos === 5) {
            fill.style.width = '88%';
            fill.style.backgroundColor = '#16a34a';
            label.textContent = 'Fuerte';
            label.style.color = '#16a34a';
        } else {
            fill.style.width = '100%';
            fill.style.backgroundColor = '#15803d';
            label.textContent = 'Muy segura';
            label.style.color = '#15803d';
        }

        $('#wrapNipNuevo1').toggleClass('is-valid', okLen && okUpper && okLower && okDigit && okSymbol && okNoSpace);
        $('#wrapNipNuevo1').toggleClass('is-invalid', nueva1.length > 0 && !(okLen && okUpper && okLower && okDigit && okSymbol && okNoSpace));
        $('#wrapNipNuevo2').toggleClass('is-valid', okMatch);
        $('#wrapNipNuevo2').toggleClass('is-invalid', nueva2.length > 0 && !okMatch);

        var listo = actual.length > 0 && okLen && okUpper && okLower && okDigit && okSymbol && okNoSpace && okMatch;
        $('#btnActualizar').prop('disabled', !listo);
        return listo;
    }

    $('#NipActual, #NipNuevo1, #NipNuevo2').on('input', function () {
        ocultarFeedback();
        evaluarFormulario();
    });

    window.NipUpdate = function () {
        if (!evaluarFormulario()) {
            mostrarFeedback('error', 'Completa todos los campos y cumple todos los requisitos de seguridad antes de guardar.');
            return;
        }

        var btn = $('#btnActualizar');
        var btnTxt = $('#btnActualizarTexto');
        btn.prop('disabled', true);
        btnTxt.text('Actualizando contraseña...');
        $('#progressbar').show();

        $.ajax({
            url: 'nip_update_dat_save.php',
            type: 'POST',
            dataType: 'json',
            timeout: 30000,
            data: {
                csrf_token: $('#csrfToken').val(),
                NipActual: $('#NipActual').val(),
                NipNuevo1: $('#NipNuevo1').val(),
                NipNuevo2: $('#NipNuevo2').val()
            },
            success: function (resp) {
                if (resp && resp.csrf_token) {
                    $('#csrfToken').val(resp.csrf_token);
                }

                if (resp && resp.ok) {
                    mostrarFeedback('success', resp.message || 'Contraseña actualizada correctamente.');
                    if (typeof $.toast === 'function') {
                        $.toast({
                            heading: 'Seguridad',
                            text: resp.message || 'Contraseña actualizada correctamente.',
                            showHideTransition: 'slide',
                            icon: 'success'
                        });
                    }
                    $('#NipActual, #NipNuevo1, #NipNuevo2').val('');
                    $('.nip-alert-banner').slideUp('fast');
                    evaluarFormulario();
                } else {
                    var msgErr = (resp && resp.message) ? resp.message : 'No se pudo actualizar la contraseña.';
                    var lista = (resp && resp.errors) ? resp.errors : [];
                    mostrarFeedback('error', msgErr, lista);
                    if (typeof $.toast === 'function') {
                        $.toast({
                            heading: 'Error',
                            text: msgErr,
                            showHideTransition: 'slide',
                            icon: 'error'
                        });
                    }
                    evaluarFormulario();
                }
            },
            error: function () {
                mostrarFeedback('error', 'No se pudo completar la solicitud. Verifica tu conexión o recarga la página.');
                evaluarFormulario();
            },
            complete: function () {
                $('#progressbar').hide();
                btnTxt.text('Actualizar contraseña ahora');
            }
        });
    };

    evaluarFormulario();
})();
</script>

<?php include("./lib/body_footer.php"); ?>
