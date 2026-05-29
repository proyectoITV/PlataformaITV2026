<?php  
require_once ("config.php");
require_once ("preference_config.php");
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="4t.ico" />
    <title>Login · ITAVU</title>
    <?php include("body_head_libs.php"); ?>
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            min-height: 100vh;
            background: #6b0f1a;
            display: flex;
            flex-direction: column;
            font-family: 'Segoe UI', Arial, sans-serif;
            position: relative;
            overflow: hidden;
        }

        .bg-shape {
            position: fixed;
            bottom: -60px; left: -80px;
            width: 620px; height: 420px;
            background: #8a1520;
            border-radius: 60% 40% 50% 50% / 40% 50% 50% 60%;
            opacity: .5;
            pointer-events: none;
        }
        .bg-shape2 {
            position: fixed;
            top: -80px; right: -60px;
            width: 380px; height: 300px;
            background: #500a12;
            border-radius: 50% 60% 40% 50% / 60% 40% 60% 40%;
            opacity: .4;
            pointer-events: none;
        }

        /* ===== BANNER MANTENIMIENTO ===== */
        .banner-mant {
            position: relative; z-index: 10;
            background: #3d0000;
            border-bottom: 3px solid #bc955c;
            padding: 10px 24px;
            display: flex; align-items: center; gap: 12px;
            width: 100%;
        }
        .banner-icon {
            width: 18px; height: 18px; flex-shrink: 0;
            background: #bc955c;
            clip-path: polygon(50% 0%, 0% 100%, 100% 100%);
        }
        .banner-inner { display: flex; align-items: baseline; gap: 8px; flex-wrap: wrap; }
        .banner-title { color: #bc955c; font-size: 11px; font-weight: 700; letter-spacing: .06em; }
        .banner-msg   { color: #f0dfc0; font-size: 11px; line-height: 1.5; }
        .banner-msg b { color: #fff; font-weight: 600; }

        /* ===== LAYOUT ===== */
        .content {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 40px 20px;
            position: relative; z-index: 5;
            gap: 48px;
        }

        /* ===== BRANDING IZQUIERDA ===== */
        .left-brand {
            display: flex;
            flex-direction: column;
            gap: 12px;
            max-width: 280px;
        }
        .brand-logo {
            width: 180px;
            height: 80px;
            background: rgba(255,255,255,0.95);
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 10px 16px;
            border: 1px solid rgba(255,255,255,0.3);
        }
        .brand-logo img {
            width: 100%;
            height: 100%;
            object-fit: contain;
        }
        .brand-name { color: white; font-size: 24px; font-weight: 700; line-height: 1.2; }
        .brand-sub  { color: rgba(255,255,255,0.5); font-size: 12px; line-height: 1.7; }
        .brand-stats { margin-top: 12px; display: flex; flex-direction: column; gap: 8px; }
        .stat-row   { display: flex; align-items: center; gap: 8px; }
        .stat-dot   { width: 6px; height: 6px; border-radius: 50%; background: #bc955c; flex-shrink: 0; }
        .stat-text  { color: rgba(255,255,255,0.45); font-size: 11px; }

        /* ===== CARD LOGIN ===== */
        .card {
            width: 340px;
            background: white;
            border-radius: 20px;
            padding: 36px 32px 28px;
            box-shadow: 0 24px 64px rgba(0,0,0,0.4);
        }
        .card-tag {
            display: inline-block;
            background: #fff0f0;
            color: #990000;
            font-size: 10px; font-weight: 700;
            letter-spacing: .08em;
            padding: 3px 10px;
            border-radius: 50px;
            margin-bottom: 10px;
            border: 1px solid #ffd0d0;
        }
        .card-title { color: #1a1a1a; font-size: 20px; font-weight: 700; margin-bottom: 4px; }
        .card-sub   { color: #999; font-size: 12px; margin-bottom: 28px; }

        /* ===== CAMPOS ===== */
        .field { margin-bottom: 16px; }
        .field label {
            display: block;
            font-size: 10px; font-weight: 700;
            color: #666; margin-bottom: 6px;
            letter-spacing: .05em; text-transform: uppercase;
        }
        .field-wrap {
            display: flex; align-items: center;
            background: #f8f8f8;
            border: 1.5px solid #eee;
            border-radius: 10px;
            padding: 0 12px;
            transition: border-color .2s, background .2s;
        }
        .field-wrap:focus-within { border-color: #990000; background: #fff; }
        .field-icon { color: #bbb; display: flex; align-items: center; margin-right: 8px; flex-shrink: 0; }
        .field-wrap input {
            border: none; background: transparent;
            font-size: 14px; color: #222;
            padding: 11px 0; width: 100%;
            outline: none; font-family: inherit;
        }
        .field-wrap input::placeholder { color: #ccc; }
        .toggle-pass {
            background: none; border: none; cursor: pointer;
            color: #bbb; display: flex; align-items: center;
            padding: 0; transition: color .2s;
        }
        .toggle-pass:hover { color: #990000; }

        /* ===== BOTÓN ===== */
        .btn-login {
            width: 100%;
            background: #990000;
            color: white;
            border: none;
            border-radius: 10px;
            padding: 13px;
            font-size: 14px; font-weight: 600;
            cursor: pointer; margin-top: 8px;
            letter-spacing: .03em;
            font-family: inherit;
            display: flex; align-items: center; justify-content: center; gap: 8px;
            transition: background .2s, transform .1s;
        }
        .btn-login:hover   { background: #7a0000; }
        .btn-login:active  { transform: scale(0.98); }
        .btn-login:disabled { opacity: .7; cursor: not-allowed; }
        .btn-arrow {
            width: 20px; height: 20px;
            background: rgba(255,255,255,0.2);
            border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            font-size: 13px; line-height: 1;
        }

        /* ===== MENSAJES ===== */
        #R_login { margin-top: 10px; font-size: 12px; text-align: center; }
        #Intentos { color: orange; font-size: 11px; text-align: center; margin-top: 4px; }

        /* ===== FOOTER CARD ===== */
        .card-footer {
            margin-top: 20px;
            padding-top: 16px;
            border-top: 1px solid #f0f0f0;
            display: flex; align-items: center; justify-content: space-between;
        }
        .footer-brand { color: #ccc; font-size: 10px; font-weight: 600; letter-spacing: .06em; }
        .footer-link  {
            color: #990000; font-size: 11px;
            cursor: pointer; background: none; border: none;
            font-family: inherit; text-decoration: none;
        }
        .footer-link:hover { text-decoration: underline; }

        /* ===== SPINNER ===== */
        .spinner {
            display: none;
            width: 16px; height: 16px;
            border: 2px solid rgba(255,255,255,0.3);
            border-top-color: white;
            border-radius: 50%;
            animation: spin .7s linear infinite;
        }
        @keyframes spin { to { transform: rotate(360deg); } }

        /* ===== RESPONSIVE ===== */
        @media (max-width: 680px) {
            .left-brand { display: none; }
            .content { padding: 24px 16px; }
            .card { width: 100%; max-width: 360px; }
        }
    </style>
</head>
<body>

<div class="bg-shape"></div>
<div class="bg-shape2"></div>

<audio id="AudioBoop" style="display:none;">
    <source src="audios/boop.mp3">
</audio>

<?php
// ===== BANNER MANTENIMIENTO =====
$mant_inicio = strtotime('2026-04-28 00:00:00');
$mant_fin    = strtotime('2026-04-29 00:00:00');
$aviso_desde = strtotime('2026-04-27 00:00:00');
$ahora       = time();

if ($ahora >= $aviso_desde && $ahora < $mant_fin):
?>
<div class="banner-mant">
    <div class="banner-icon"></div>
    <div class="banner-inner">
        <span class="banner-title">
            <?php echo ($ahora >= $mant_inicio) ? 'SISTEMA EN MANTENIMIENTO' : 'AVISO DE MANTENIMIENTO PROGRAMADO'; ?>
        </span>
        <span class="banner-msg">
            <?php if ($ahora >= $mant_inicio): ?>
                La plataforma estará fuera de servicio hasta el <b>29 de abril a las 12:00 AM</b>. No es posible iniciar sesión en este momento.
            <?php else: ?>
                La plataforma <b>ITAVU</b> estará <b>fuera de servicio el martes 28 de abril</b> (todo el día) por mantenimiento del sistema.
            <?php endif; ?>
        </span>
    </div>
</div>
<?php endif; ?>

<!-- ALERTAS BD (localhost) -->
<?php
if ($dbhost == "localhost") echo '<div class="alert alert-danger" role="alert" style="position:relative;z-index:10;">La conexión a la base de datos (produccion_itavu) está en localhost</div>';
if ($Vdbhost == "localhost") echo '<div class="alert alert-danger" role="alert" style="position:relative;z-index:10;">La conexión a la base de datos (produccion_vivienda) está en localhost</div>';
if ($Pdbhost == "localhost") echo '<div class="alert alert-danger" role="alert" style="position:relative;z-index:10;">La conexión a la base preference está en localhost</div>';
?>

<div class="content">

    <!-- BRANDING IZQUIERDA -->
    <div class="left-brand">
        <div class="brand-logo">
            <img src="img/logoitavu.jpg" alt="ITAVU">
        </div>
        <div class="brand-name">Plataforma TAVU</div>
        <div class="brand-sub">Sistema de gestión integral para el Instituto Tamaulipeco de Vivienda y Urbanismo.</div>
        <div class="brand-stats">
            <?php
            $info = InfoLogin();   // tu función existente
            $hojas = ceropapel(); // tu función existente
            ?>
            <div class="stat-row">
                <div class="stat-dot"></div>
                <span class="stat-text">Hemos ahorrado <?php echo number_format($hojas); ?> hojas de papel</span>
            </div>
            <div class="stat-row">
                <div class="stat-dot"></div>
                <span class="stat-text">Acceso seguro con NIP personal</span>
            </div>
            <div class="stat-row">
                <div class="stat-dot"></div>
                <span class="stat-text">Disponible en red interna 24/7</span>
            </div>
        </div>
    </div>

    <!-- CARD LOGIN -->
    <div class="card">
        <div class="card-tag">ACCESO SEGURO</div>
        <div class="card-title">Iniciar sesión</div>
        <div class="card-sub">Ingresa tus credenciales de empleado</div>

        <div class="field">
            <label>Número de empleado</label>
            <div class="field-wrap">
                <span class="field-icon">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="8" r="4"/><path d="M4 20c0-4 3.6-7 8-7s8 3 8 7"/></svg>
                </span>
                <input id="NEmpleado" type="text" placeholder="Ej. 1733" autocomplete="username">
            </div>
        </div>

        <div class="field">
            <label>Contraseña (NIP)</label>
            <div class="field-wrap">
                <span class="field-icon">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="11" width="18" height="11" rx="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                </span>
                <input id="EmpleadoNIP" type="password" placeholder="Tu NIP" autocomplete="current-password">
                <button class="toggle-pass" type="button" onclick="togglePass()" title="Mostrar/ocultar contraseña">
                    <svg id="eye-icon" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                </button>
            </div>
        </div>

        <div id="R_login"></div>
        <div id="Intentos"></div>

        <button id="btnEntrar" class="btn-login" onclick="ValidarAcceso()">
            <span id="btnEntrar_texto">Entrar</span>
            <div class="spinner" id="btnEntrar_loader"></div>
            <div class="btn-arrow" id="btn-arrow">›</div>
        </button>

        <div class="card-footer">
            <span class="footer-brand">ITAVU · Tamaulipas</span>
            <button class="footer-link" onclick="RecoveryNIP()">¿Olvidé mi NIP?</button>
        </div>
    </div>

</div>

<div id="R" style="display:none;"></div>

<script>
function togglePass() {
    var inp = document.getElementById('EmpleadoNIP');
    inp.type = (inp.type === 'password') ? 'text' : 'password';
}

function btnBusy(busy) {
    document.getElementById('btnEntrar_texto').style.display = busy ? 'none' : '';
    document.getElementById('btn-arrow').style.display       = busy ? 'none' : '';
    document.getElementById('btnEntrar_loader').style.display = busy ? 'block' : 'none';
    document.getElementById('btnEntrar').disabled = !!busy;
}
btnBusy(0);

function ValidarAcceso() {
    var Usuario = $('#NEmpleado').val();
    var NIP     = $('#EmpleadoNIP').val();
    btnBusy(1);
    $.ajax({
        url: "login_toctoc.php",
        type: "post",
        timeout: 30000,
        data: { Usuario: Usuario, NIP: NIP },
        success: function(data) {
            $("#R").html(data);
        },
        error: function(xhr, status) {
            if (status === 'timeout') {
                $('#R_login').html('No se pudo validar tu acceso: tiempo de espera agotado.');
            } else {
                $('#R_login').html('No se pudo validar tu acceso. Intenta de nuevo.');
            }
        },
        complete: function() {
            btnBusy(0);
        }
    });
}

function RecoveryNIP() {
    var Usuario = $('#NEmpleado').val();
    btnBusy(1);
    $.ajax({
        url: "login_recovery.php",
        type: "post",
        timeout: 30000,
        data: { Usuario: Usuario },
        success: function(data) {
            $("#R").html(data);
        },
        error: function(xhr, status) {
            if (status === 'timeout') {
                $('#R_login').html('No se pudo procesar la recuperación: tiempo de espera agotado.');
            } else {
                $('#R_login').html('No se pudo procesar la recuperación. Intenta de nuevo.');
            }
        },
        complete: function() {
            btnBusy(0);
        }
    });
}

// Enter para login
document.getElementById('EmpleadoNIP').addEventListener('keypress', function(e) {
    if (e.key === 'Enter') ValidarAcceso();
});
document.getElementById('NEmpleado').addEventListener('keypress', function(e) {
    if (e.key === 'Enter') document.getElementById('EmpleadoNIP').focus();
});
</script>

</body>
</html>