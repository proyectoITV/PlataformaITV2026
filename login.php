<?php
require_once("config.php");
require_once("preference_config.php");
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
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            min-height: 100vh;
            background: #6b0f1a;
            display: flex;
            flex-direction: column;
            font-family: 'Segoe UI', Arial, sans-serif;
            position: relative;
            overflow-x: hidden;
            overflow-y: auto;
        }

        .bg-shape {
            position: fixed;
            bottom: -60px;
            left: -80px;
            width: 620px;
            height: 420px;
            background: #8a1520;
            border-radius: 60% 40% 50% 50% / 40% 50% 50% 60%;
            opacity: .5;
            pointer-events: none;
        }

        .bg-shape2 {
            position: fixed;
            top: -80px;
            right: -60px;
            width: 380px;
            height: 300px;
            background: #500a12;
            border-radius: 50% 60% 40% 50% / 60% 40% 60% 40%;
            opacity: .4;
            pointer-events: none;
        }

        /* ===== BANNER MANTENIMIENTO ===== */
        .banner-mant {
            position: relative;
            z-index: 10;
            background: #3d0000;
            border-bottom: 3px solid #bc955c;
            padding: 10px 24px;
            display: flex;
            align-items: center;
            gap: 12px;
            width: 100%;
        }

        .banner-icon {
            width: 18px;
            height: 18px;
            flex-shrink: 0;
            background: #bc955c;
            clip-path: polygon(50% 0%, 0% 100%, 100% 100%);
        }

        .banner-inner {
            display: flex;
            align-items: baseline;
            gap: 8px;
            flex-wrap: wrap;
        }

        .banner-title {
            color: #bc955c;
            font-size: 11px;
            font-weight: 700;
            letter-spacing: .06em;
        }

        .banner-msg {
            color: #f0dfc0;
            font-size: 11px;
            line-height: 1.5;
        }

        .banner-msg b {
            color: #fff;
            font-weight: 600;
        }

        /* ===== LAYOUT ===== */
        .content {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 32px 24px;
            position: relative;
            z-index: 5;
            gap: 44px;
            width: 100%;
            max-width: 980px;
            margin: 0 auto;
        }

        /* ===== BRANDING Y SEGURIDAD IZQUIERDA ===== */
        .left-brand {
            display: flex;
            flex-direction: column;
            gap: 12px;
            max-width: 430px;
            flex: 1;
        }

        .brand-logo {
            width: 170px;
            height: 74px;
            background: rgba(255, 255, 255, 0.95);
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 8px 14px;
            border: 1px solid rgba(255, 255, 255, 0.3);
        }

        .brand-logo img {
            width: 100%;
            height: 100%;
            object-fit: contain;
        }

        .brand-name {
            color: white;
            font-size: 24px;
            font-weight: 700;
            line-height: 1.2;
        }

        .brand-sub {
            color: rgba(255, 255, 255, 0.65);
            font-size: 12.5px;
            line-height: 1.55;
        }

        .brand-stats {
            margin-top: 2px;
            display: flex;
            flex-direction: column;
            gap: 6px;
        }

        .stat-row {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .stat-dot {
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background: #bc955c;
            flex-shrink: 0;
        }

        .stat-text {
            color: rgba(255, 255, 255, 0.6);
            font-size: 11.5px;
        }

        /* ===== APARTADO DE SEGURIDAD ===== */
        .security-notice {
            margin-top: 10px;
            background: rgba(45, 5, 10, 0.72);
            border: 1px solid rgba(188, 149, 92, 0.42);
            border-left: 4px solid #bc955c;
            border-radius: 14px;
            padding: 16px 18px;
            color: #f8ede3;
            box-shadow: 0 12px 30px rgba(0, 0, 0, 0.25);
        }

        .sec-header {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 8px;
        }

        .sec-shield {
            width: 26px;
            height: 26px;
            border-radius: 8px;
            background: rgba(188, 149, 92, 0.2);
            color: #e3c28d;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .sec-title {
            color: #e3c28d;
            font-size: 11.5px;
            font-weight: 700;
            letter-spacing: .06em;
            text-transform: uppercase;
            line-height: 1.3;
        }

        .sec-desc {
            font-size: 12px;
            line-height: 1.55;
            color: rgba(255, 255, 255, 0.85);
            margin-bottom: 10px;
        }

        .sec-list {
            list-style: none;
            display: flex;
            flex-direction: column;
            gap: 5px;
            margin-bottom: 12px;
        }

        .sec-list li {
            display: flex;
            align-items: flex-start;
            gap: 7px;
            font-size: 11.5px;
            line-height: 1.4;
            color: #fff;
        }

        .sec-check {
            color: #bc955c;
            font-weight: 700;
            flex-shrink: 0;
            margin-top: 1px;
        }

        .sec-code {
            display: inline-block;
            background: rgba(255, 255, 255, 0.12);
            border: 1px solid rgba(255, 255, 255, 0.16);
            border-radius: 4px;
            padding: 0 5px;
            font-family: Consolas, monospace;
            font-size: 10.5px;
            color: #f3dfb8;
        }

        .sec-support {
            background: rgba(188, 149, 92, 0.14);
            border: 1px solid rgba(188, 149, 92, 0.3);
            border-radius: 9px;
            padding: 9px 11px;
            font-size: 11.2px;
            line-height: 1.48;
            color: #f5e6cc;
        }

        .sec-support b {
            color: #fff;
        }

        /* ===== CARD LOGIN ===== */
        .card {
            width: 375px;
            flex-shrink: 0;
            background: white;
            border-radius: 20px;
            padding: 30px 28px 24px;
            box-shadow: 0 24px 64px rgba(0, 0, 0, 0.4);
        }

        .card-tag {
            display: inline-block;
            background: #fff0f0;
            color: #990000;
            font-size: 10px;
            font-weight: 700;
            letter-spacing: .08em;
            padding: 3px 10px;
            border-radius: 50px;
            margin-bottom: 8px;
            border: 1px solid #ffd0d0;
        }

        .card-title {
            color: #1a1a1a;
            font-size: 20px;
            font-weight: 700;
            margin-bottom: 4px;
        }

        .card-sub {
            color: #888;
            font-size: 12px;
            margin-bottom: 20px;
        }

        /* ===== CAMPOS ===== */
        .field {
            margin-bottom: 14px;
        }

        .field label {
            display: block;
            font-size: 10px;
            font-weight: 700;
            color: #666;
            margin-bottom: 5px;
            letter-spacing: .05em;
            text-transform: uppercase;
        }

        .field-wrap {
            display: flex;
            align-items: center;
            background: #f8f8f8;
            border: 1.5px solid #eee;
            border-radius: 10px;
            padding: 0 12px;
            transition: border-color .2s, background .2s;
        }

        .field-wrap:focus-within {
            border-color: #990000;
            background: #fff;
        }

        .field-icon {
            color: #bbb;
            display: flex;
            align-items: center;
            margin-right: 8px;
            flex-shrink: 0;
        }

        .field-wrap input {
            border: none;
            background: transparent;
            font-size: 14px;
            color: #222;
            padding: 10px 0;
            width: 100%;
            outline: none;
            font-family: inherit;
        }

        .field-wrap input::placeholder {
            color: #bbb;
        }

        .toggle-pass {
            background: none;
            border: none;
            cursor: pointer;
            color: #bbb;
            display: flex;
            align-items: center;
            padding: 0;
            transition: color .2s;
        }

        .toggle-pass:hover {
            color: #990000;
        }

        /* ===== CAPTCHA ===== */
        .captcha-row {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 8px;
        }

        .captcha-box {
            flex: 1;
            height: 46px;
            border-radius: 9px;
            border: 1.5px solid #eadcd6;
            background: #fdf8f6;
            overflow: hidden;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .captcha-box img {
            width: 100%;
            height: 100%;
            object-fit: contain;
            display: block;
        }

        .btn-captcha-refresh {
            width: 42px;
            height: 46px;
            border-radius: 9px;
            border: 1.5px solid #eadcd6;
            background: #faf6f4;
            color: #7c121d;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            transition: background .2s, border-color .2s, transform .15s;
        }

        .btn-captcha-refresh:hover {
            background: #fff0f0;
            border-color: #990000;
        }

        .btn-captcha-refresh:active {
            transform: scale(0.95);
        }

        #CaptchaInput {
            text-transform: uppercase;
            letter-spacing: 0.18em;
            font-weight: 600;
        }

        /* ===== ESTADO GPS ===== */
        .gps-bar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 8px;
            background: #f9fafb;
            border: 1px solid #ececec;
            border-radius: 8px;
            padding: 7px 10px;
            margin-bottom: 10px;
            font-size: 11px;
            color: #666;
        }

        .gps-left {
            display: flex;
            align-items: center;
            gap: 6px;
            min-width: 0;
        }

        .gps-dot {
            width: 7px;
            height: 7px;
            border-radius: 50%;
            background: #bc955c;
            flex-shrink: 0;
        }

        .gps-dot.ok {
            background: #16a34a;
        }

        .gps-dot.warn {
            background: #d97706;
        }

        .gps-retry {
            background: none;
            border: none;
            color: #990000;
            font-size: 10.5px;
            font-weight: 600;
            cursor: pointer;
            padding: 0;
            white-space: nowrap;
            display: none;
        }

        .gps-retry:hover {
            text-decoration: underline;
        }

        .gps-help {
            display: none;
            background: #fffbeb;
            border: 1px solid #fde68a;
            border-left: 3px solid #d97706;
            border-radius: 8px;
            padding: 8px 10px;
            margin-bottom: 10px;
            font-size: 10.8px;
            line-height: 1.45;
            color: #78350f;
            text-align: left;
        }

        .gps-help b {
            color: #6b0f1a;
        }

        .gps-help ol {
            margin: 4px 0 0 15px;
            padding: 0;
        }

        .gps-help li {
            margin-bottom: 2px;
        }

        /* ===== BOTÓN ===== */
        .btn-login {
            width: 100%;
            background: #990000;
            color: white;
            border: none;
            border-radius: 10px;
            padding: 12px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            margin-top: 6px;
            letter-spacing: .03em;
            font-family: inherit;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            transition: background .2s, transform .1s;
        }

        .btn-login:hover {
            background: #7a0000;
        }

        .btn-login:active {
            transform: scale(0.98);
        }

        .btn-login:disabled {
            opacity: .7;
            cursor: not-allowed;
        }

        .btn-arrow {
            width: 20px;
            height: 20px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 13px;
            line-height: 1;
        }

        /* ===== MENSAJES ===== */
        #R_login {
            margin-top: 8px;
            font-size: 12px;
            text-align: center;
            min-height: 16px;
        }

        #Intentos {
            color: orange;
            font-size: 11px;
            text-align: center;
            margin-top: 4px;
        }

        /* ===== FOOTER CARD ===== */
        .card-footer {
            margin-top: 16px;
            padding-top: 14px;
            border-top: 1px solid #f0f0f0;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .footer-brand {
            color: #b8b8b8;
            font-size: 10px;
            font-weight: 600;
            letter-spacing: .06em;
        }

        .footer-link {
            color: #990000;
            font-size: 11px;
            cursor: pointer;
            background: none;
            border: none;
            font-family: inherit;
            text-decoration: none;
        }

        .footer-link:hover {
            text-decoration: underline;
        }

        /* ===== SPINNER ===== */
        .spinner {
            display: none;
            width: 16px;
            height: 16px;
            border: 2px solid rgba(255, 255, 255, 0.3);
            border-top-color: white;
            border-radius: 50%;
            animation: spin .7s linear infinite;
        }

        @keyframes spin {
            to {
                transform: rotate(360deg);
            }
        }

        /* ===== RESPONSIVE ===== */
        @media (max-width: 860px) {
            .content {
                flex-direction: column;
                padding: 24px 16px;
                gap: 22px;
            }

            .card {
                order: 1;
                width: 100%;
                max-width: 410px;
            }

            .left-brand {
                order: 2;
                width: 100%;
                max-width: 410px;
            }

            .brand-stats {
                display: none;
            }
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
    // ===== BANNER HORARIO DE ACCESO (7:00 AM a 7:00 PM) =====
    $enHorarioAcceso = !function_exists('itavu_en_horario_acceso') || itavu_en_horario_acceso();
    $hayExentosHorario = isset($HorarioAccesoExentos) && is_array($HorarioAccesoExentos) && count($HorarioAccesoExentos) > 0;
    $bloquearBotonHorario = (!$enHorarioAcceso && !$hayExentosHorario);
    $cerradoPorHorario = isset($_GET['fuera_horario']);

    if ($cerradoPorHorario || !$enHorarioAcceso):
        ?>
        <div class="banner-mant">
            <div class="banner-icon"></div>
            <div class="banner-inner">
                <span class="banner-title">
                    <?php echo $cerradoPorHorario ? 'SESIÓN CERRADA POR HORARIO' : 'FUERA DE HORARIO DE SERVICIO'; ?>
                </span>
                <span class="banner-msg">
                    <?php if ($cerradoPorHorario): ?>
                        Tu sesión fue cerrada automáticamente porque el acceso a la plataforma <b>ITAVU</b> está permitido únicamente de <b>7:00 AM a 7:00 PM</b>.
                    <?php else: ?>
                        El acceso a la plataforma <b>ITAVU</b> está habilitado únicamente en horario de <b>7:00 AM a 7:00 PM</b>. Intenta nuevamente dentro del horario permitido.
                    <?php endif; ?>
                </span>
            </div>
        </div>
    <?php endif; ?>

    <?php if (isset($_GET['cuenta_baja'])): ?>
        <div class="banner-mant">
            <div class="banner-icon"></div>
            <div class="banner-inner">
                <span class="banner-title">ACCESO RESTRINGIDO</span>
                <span class="banner-msg">
                    Tu cuenta se encuentra registrada como <b>inactiva / Baja permanente</b> y no tiene autorización para ingresar a la Plataforma <b>ITAVU</b>.
                </span>
            </div>
        </div>
    <?php endif; ?>

    <?php if (isset($_GET['inactividad'])): ?>
        <div class="banner-mant">
            <div class="banner-icon"></div>
            <div class="banner-inner">
                <span class="banner-title">SESIÓN CERRADA POR INACTIVIDAD</span>
                <span class="banner-msg">
                    Por tu seguridad, tu sesión se cerró automáticamente tras <b><?php echo isset($SessionInactividadMin) ? (int)$SessionInactividadMin : 15; ?> minutos</b> sin actividad. Inicia sesión nuevamente para continuar.
                </span>
            </div>
        </div>
    <?php endif; ?>

    <?php if (isset($_GET['sesion_duplicada'])): ?>
        <div class="banner-mant">
            <div class="banner-icon"></div>
            <div class="banner-inner">
                <span class="banner-title">SESIÓN CERRADA EN ESTE EQUIPO</span>
                <span class="banner-msg">
                    Se inició sesión con tu cuenta en <b>otro dispositivo o navegador</b>. Por seguridad, solo se permite una sesión activa a la vez.
                </span>
            </div>
        </div>
    <?php endif; ?>

    <?php
    // ===== BANNER MANTENIMIENTO =====
    $mant_inicio = strtotime('2026-04-28 00:00:00');
    $mant_fin = strtotime('2026-04-29 00:00:00');
    $aviso_desde = strtotime('2026-04-27 00:00:00');
    $ahora = time();

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
                        La plataforma estará fuera de servicio hasta el <b>29 de abril a las 12:00 AM</b>. No es posible iniciar
                        sesión en este momento.
                    <?php else: ?>
                        La plataforma <b>ITAVU</b> estará <b>fuera de servicio el martes 28 de abril</b> (todo el día) por
                        mantenimiento del sistema.
                    <?php endif; ?>
                </span>
            </div>
        </div>
    <?php endif; ?>

    <!-- ALERTAS BD (localhost) -->
    <?php
    if ($dbhost == "localhost")
        echo '<div class="alert alert-danger" role="alert" style="position:relative;z-index:10;">La conexión a la base de datos (produccion_itavu) está en localhost</div>';
    if ($Vdbhost == "localhost")
        echo '<div class="alert alert-danger" role="alert" style="position:relative;z-index:10;">La conexión a la base de datos (produccion_vivienda) está en localhost</div>';
    if ($Pdbhost == "localhost")
        echo '<div class="alert alert-danger" role="alert" style="position:relative;z-index:10;">La conexión a la base preference está en localhost</div>';
    ?>

    <div class="content">

        <!-- BRANDING Y APARTADO DE SEGURIDAD -->
        <div class="left-brand">
            <div class="brand-logo">
                <img src="img/logoitavu.jpg" alt="ITAVU">
            </div>
            <div class="brand-name">Plataforma ITAVU</div>
            <div class="brand-sub">Sistema de gestión integral para el Instituto Tamaulipeco de Vivienda y Urbanismo.
            </div>

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
                    <span class="stat-text">Acceso protegido con verificación y bitácora de seguridad</span>
                </div>
                <div class="stat-row">
                    <div class="stat-dot"></div>
                    <span class="stat-text">Horario de acceso habilitado: 7:00 AM a 7:00 PM</span>
                </div>
            </div>

            <!-- APARTADO DE SEGURIDAD DE CREDENCIALES -->
            <div class="security-notice">
                <div class="sec-header">
                    <div class="sec-shield">
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2.2">
                            <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z" />
                            <path d="M9 12l2 2 4-4" />
                        </svg>
                    </div>
                    <div class="sec-title">Esquema de Seguridad · Una contraseña segura debe incluir lo siguiente</div>
                </div>

                <p class="sec-desc">
                    Protege tu cuenta y la información institucional. Tu contraseña es personal e intransferible: no la
                    compartas con nadie ni utilices claves que uses en otros sitios.
                    deberá cumplir con los siguientes requisitos:
                </p>

                <ul class="sec-list">
                    <li><span class="sec-check">✓</span><span>Longitud mínima de <b>8 caracteres</b></span></li>
                    <li><span class="sec-check">✓</span><span>Mínimo <b>1 letra mayúscula</b> <span
                                class="sec-code">A-Z</span></span></li>
                    <li><span class="sec-check">✓</span><span>Mínimo <b>1 letra minúscula</b> <span
                                class="sec-code">a-z</span></span></li>
                    <li><span class="sec-check">✓</span><span>Mínimo <b>1 dígito</b> <span
                                class="sec-code">0-9</span></span></li>
                    <li><span class="sec-check">✓</span><span>Mínimo <b>1 símbolo</b> <span class="sec-code">! @ # $ %
                                &amp; * _ -</span></span></li>
                </ul>

                <div class="sec-support">
                    <b>¿Su contraseña aún no cumple con estos requisitos?</b><br>
                    Comuníquese al <b>Departamento de Informática</b> para apoyarle:<br>
                    Tel. <b>(834) 318 55 16</b> · Exts. <b>46580</b>, <b>46530</b> y <b>46524</b>
                </div>
            </div>
        </div>

        <!-- CARD LOGIN -->
        <div class="card">
            <div class="card-tag">ACCESO SEGURO</div>
            <div class="card-title">Iniciar sesión</div>
            <div class="card-sub">Ingresa tus credenciales de empleado</div>

            <div class="field">
                <label for="NEmpleado">Número de empleado</label>
                <div class="field-wrap" id="wrapUsuario">
                    <span class="field-icon">
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2">
                            <circle cx="12" cy="8" r="4" />
                            <path d="M4 20c0-4 3.6-7 8-7s8 3 8 7" />
                        </svg>
                    </span>
                    <input id="NEmpleado" type="text" placeholder="Ej. 00000" autocomplete="username">
                </div>
            </div>

            <div class="field">
                <label for="EmpleadoNIP">Contraseña (NIP)</label>
                <div class="field-wrap" id="wrapPassword">
                    <span class="field-icon">
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2">
                            <rect x="3" y="11" width="18" height="11" rx="2" />
                            <path d="M7 11V7a5 5 0 0 1 10 0v4" />
                        </svg>
                    </span>
                    <input id="EmpleadoNIP" type="password" placeholder="Tu contraseña" autocomplete="current-password">
                    <button class="toggle-pass" type="button" onclick="togglePass()" title="Mostrar/ocultar contraseña">
                        <svg id="eye-icon" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2">
                            <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z" />
                            <circle cx="12" cy="12" r="3" />
                        </svg>
                    </button>
                </div>
            </div>

            <div class="field">
                <label for="CaptchaInput">Verificación de seguridad (CAPTCHA), válido 5 min</label>
                <div class="captcha-row">
                    <div class="captcha-box">
                        <img id="captchaImg" src="login_captcha.php?t=<?php echo time(); ?>"
                            alt="Código de verificación">
                    </div>
                    <button type="button" class="btn-captcha-refresh" onclick="recargarCaptcha()"
                        title="Generar nuevo código">
                        <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2.2">
                            <polyline points="23 4 23 10 17 10" />
                            <path d="M20.49 15a9 9 0 1 1-2.12-9.36L23 10" />
                        </svg>
                    </button>
                </div>
                <div class="field-wrap" id="wrapCaptcha">
                    <span class="field-icon">
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2">
                            <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z" />
                        </svg>
                    </span>
                    <input id="CaptchaInput" type="text" maxlength="5" placeholder="Escribe el código"
                        autocomplete="off">
                </div>
            </div>

            <div class="gps-bar" id="gpsBar"
                title="La ubicación GPS se registra en el historial de acceso por seguridad">
                <div class="gps-left">
                    <span class="gps-dot" id="gpsDot"></span>
                    <span id="gpsText">Verificando ubicación GPS...</span>
                </div>
                <button type="button" class="gps-retry" id="btnGpsRetry" onclick="solicitarGPS()">Reintentar</button>
            </div>

            <div class="gps-help" id="gpsHelp">
                <b>¿No te aparece el aviso de Permitir?</b>
                <ol>
                    <li>Haz clic en el <b>ícono junto a la dirección web</b> (arriba a la izquierda) y cambia <b>Ubicación</b> a <b>Permitir</b>.</li>
                    <li>Si sigue bloqueado, en Windows ve a <b>Configuración → Privacidad → Ubicación</b> y actívala.</li>
                    <li>Pulsa <b>Reintentar</b> o recarga la página (<b>F5</b>).</li>
                </ol>
            </div>

            <div id="R_login"></div>
            <div id="Intentos"></div>

            <button id="btnEntrar" class="btn-login" onclick="ValidarAcceso()" <?php echo $bloquearBotonHorario ? 'disabled' : ''; ?>>
                <span id="btnEntrar_texto"><?php echo $bloquearBotonHorario ? 'Fuera de horario (7:00 AM - 7:00 PM)' : 'Entrar'; ?></span>
                <div class="spinner" id="btnEntrar_loader"></div>
                <div class="btn-arrow" id="btn-arrow" <?php echo $bloquearBotonHorario ? 'style="display:none;"' : ''; ?>>›</div>
            </button>

            <div class="card-footer">
                <span class="footer-brand">ITAVU · Tamaulipas</span>
                <button class="footer-link" type="button" onclick="RecoveryNIP()">¿Olvidé mi NIP?</button>
            </div>
        </div>

    </div>

    <div id="R" style="display:none;"></div>

    <script>
        var gpsState = {
            lat: '',
            lon: '',
            accuracy: '',
            status: 'PENDING'
        };

        function actualizarUIEstadoGPS(claseDot, texto, mostrarReintentar, tooltip, mostrarAyuda) {
            var dot = document.getElementById('gpsDot');
            var txt = document.getElementById('gpsText');
            var btn = document.getElementById('btnGpsRetry');
            var bar = document.getElementById('gpsBar');
            var help = document.getElementById('gpsHelp');
            dot.className = 'gps-dot' + (claseDot ? ' ' + claseDot : '');
            txt.textContent = texto;
            btn.style.display = mostrarReintentar ? 'inline-block' : 'none';
            if (help) {
                help.style.display = mostrarAyuda ? 'block' : 'none';
            }
            if (tooltip) {
                bar.title = tooltip;
            }
        }

        function solicitarGPS(usarAltaPrecision) {
            if (typeof usarAltaPrecision === 'undefined') {
                usarAltaPrecision = true;
            }

            if (!('geolocation' in navigator)) {
                gpsState.status = 'UNSUPPORTED';
                actualizarUIEstadoGPS('warn', 'Navegador sin soporte GPS', false, '', true);
                return;
            }

            if (window.isSecureContext === false && location.hostname !== 'localhost' && location.hostname !== '127.0.0.1') {
                gpsState.status = 'INSECURE_ORIGIN';
                actualizarUIEstadoGPS('warn', 'GPS requiere conexión segura (HTTPS)', false, '', false);
                return;
            }

            gpsState.status = 'PENDING';
            actualizarUIEstadoGPS('', 'Verificando ubicación GPS...', false, '', false);

            navigator.geolocation.getCurrentPosition(
                function (pos) {
                    gpsState.lat = pos.coords.latitude.toFixed(7);
                    gpsState.lon = pos.coords.longitude.toFixed(7);
                    gpsState.accuracy = pos.coords.accuracy ? pos.coords.accuracy.toFixed(2) : '';
                    gpsState.status = 'OK';
                    $('#gpsBar').css('border-color', '#ececec');
                    actualizarUIEstadoGPS(
                        'ok',
                        'Ubicación GPS registrada',
                        false,
                        'Coordenadas listas: ' + gpsState.lat + ', ' + gpsState.lon,
                        false
                    );
                },
                function (err) {
                    // Si falla en PC de escritorio con alta precisión, reintentar automáticamente por red (baja precisión)
                    if (usarAltaPrecision && (err.code === err.POSITION_UNAVAILABLE || err.code === err.TIMEOUT)) {
                        solicitarGPS(false);
                        return;
                    }

                    if (err.code === err.PERMISSION_DENIED) {
                        gpsState.status = 'DENIED';
                        actualizarUIEstadoGPS('warn', 'Permiso de ubicación denegado', true, '', true);
                    } else if (err.code === err.POSITION_UNAVAILABLE) {
                        gpsState.status = 'UNAVAILABLE';
                        actualizarUIEstadoGPS('warn', 'Ubicación GPS no disponible', true, '', true);
                    } else if (err.code === err.TIMEOUT) {
                        gpsState.status = 'TIMEOUT';
                        actualizarUIEstadoGPS('warn', 'Tiempo de espera GPS agotado', true, '', true);
                    } else {
                        gpsState.status = 'ERROR';
                        actualizarUIEstadoGPS('warn', 'No se pudo obtener ubicación GPS', true, '', true);
                    }
                },
                {
                    enableHighAccuracy: usarAltaPrecision,
                    timeout: usarAltaPrecision ? 7000 : 15000,
                    maximumAge: 60000
                }
            );
        }

        // Detectar automáticamente cuando el usuario cambia el permiso en el candado del navegador
        if (navigator.permissions && typeof navigator.permissions.query === 'function') {
            navigator.permissions.query({ name: 'geolocation' }).then(function (perm) {
                perm.onchange = function () {
                    if (perm.state === 'granted' || perm.state === 'prompt') {
                        solicitarGPS(true);
                    } else if (perm.state === 'denied') {
                        gpsState.status = 'DENIED';
                        actualizarUIEstadoGPS('warn', 'Permiso de ubicación denegado', true, '', true);
                    }
                };
            }).catch(function () { });
        }

        var CAPTCHA_TTL_MS = 295000; // 4 min 55 seg (margen de 5 seg antes del vencimiento de 5 min en servidor)
        var captchaGeneradoEn = Date.now();
        var captchaAutoTimer = null;
        var captchaCargando = false;

        function programarAutoRecargaCaptcha() {
            if (captchaAutoTimer) {
                clearTimeout(captchaAutoTimer);
                captchaAutoTimer = null;
            }
            var transcurrido = Date.now() - captchaGeneradoEn;
            var restante = Math.max(1000, CAPTCHA_TTL_MS - transcurrido);
            captchaAutoTimer = setTimeout(function () {
                if (!document.hidden) {
                    recargarCaptcha(true);
                }
            }, restante);
        }

        function verificarExpiracionCaptcha() {
            if (!document.hidden && !captchaCargando && (Date.now() - captchaGeneradoEn) >= CAPTCHA_TTL_MS) {
                recargarCaptcha(true);
            }
        }

        function recargarCaptcha(esAutomatico) {
            var img = document.getElementById('captchaImg');
            if (img) {
                captchaCargando = true;
                captchaGeneradoEn = Date.now();
                img.src = 'login_captcha.php?t=' + captchaGeneradoEn;
            }
            var inp = document.getElementById('CaptchaInput');
            if (inp) {
                inp.value = '';
            }
            if (esAutomatico) {
                $('#wrapCaptcha').css('border-color', '#eee');
            }
            programarAutoRecargaCaptcha();
        }

        (function initCaptchaAutoRefresh() {
            var img = document.getElementById('captchaImg');
            if (img) {
                img.addEventListener('load', function () {
                    captchaCargando = false;
                    captchaGeneradoEn = Date.now();
                    programarAutoRecargaCaptcha();
                });
                img.addEventListener('error', function () {
                    captchaCargando = false;
                    programarAutoRecargaCaptcha();
                });
            }
            document.addEventListener('visibilitychange', verificarExpiracionCaptcha);
            window.addEventListener('focus', verificarExpiracionCaptcha);
            programarAutoRecargaCaptcha();
        })();

        function togglePass() {
            var inp = document.getElementById('EmpleadoNIP');
            inp.type = (inp.type === 'password') ? 'text' : 'password';
        }

        var fueraDeHorarioBloqueado = <?php echo $bloquearBotonHorario ? 'true' : 'false'; ?>;
        var exigirGpsLogin = <?php echo !empty($EXIGIR_geo_ini) ? 'true' : 'false'; ?>;

        function btnBusy(busy) {
            if (fueraDeHorarioBloqueado) {
                document.getElementById('btnEntrar_texto').style.display = '';
                document.getElementById('btn-arrow').style.display = 'none';
                document.getElementById('btnEntrar_loader').style.display = 'none';
                document.getElementById('btnEntrar').disabled = true;
                return;
            }
            document.getElementById('btnEntrar_texto').style.display = busy ? 'none' : '';
            document.getElementById('btn-arrow').style.display = busy ? 'none' : '';
            document.getElementById('btnEntrar_loader').style.display = busy ? 'block' : 'none';
            document.getElementById('btnEntrar').disabled = !!busy;
        }
        btnBusy(0);
        solicitarGPS();

        function ValidarAcceso() {
            if (fueraDeHorarioBloqueado) {
                $('#R_login').html('<span style="color:#990000;font-weight:600;">Acceso restringido: el horario de servicio es de 7:00 AM a 7:00 PM.</span>');
                return;
            }
            var Usuario = $('#NEmpleado').val().trim();
            var NIP = $('#EmpleadoNIP').val();
            var Captcha = $('#CaptchaInput').val().trim();

            $('#R_login').html('');

            if (Usuario === '') {
                $('#wrapUsuario').css('border-color', '#e67e22');
                $('#R_login').html('<span style="color:#b45309;">Escribe tu número de empleado.</span>');
                $('#NEmpleado').focus();
                return;
            }
            if (NIP === '') {
                $('#wrapPassword').css('border-color', '#e67e22');
                $('#R_login').html('<span style="color:#b45309;">Escribe tu contraseña (NIP).</span>');
                $('#EmpleadoNIP').focus();
                return;
            }
            if (Captcha === '') {
                $('#wrapCaptcha').css('border-color', '#e67e22');
                $('#R_login').html('<span style="color:#b45309;">Escribe el código de verificación (CAPTCHA).</span>');
                $('#CaptchaInput').focus();
                return;
            }
            if (exigirGpsLogin && (gpsState.status !== 'OK' || gpsState.lat === '' || gpsState.lon === '')) {
                $('#gpsBar').css('border-color', '#c0392b');
                if (gpsState.status === 'PENDING') {
                    $('#R_login').html('<span style="color:#990000;font-weight:600;">Acepta el permiso de ubicación GPS en tu navegador para poder ingresar.</span>');
                } else if (gpsState.status === 'INSECURE_ORIGIN') {
                    $('#R_login').html('<span style="color:#990000;font-weight:600;">Se requiere conexión segura (HTTPS) para obtener tu ubicación GPS obligatoria.</span>');
                } else {
                    $('#R_login').html('<span style="color:#990000;font-weight:600;">Por seguridad es obligatorio permitir tu ubicación GPS. Habilita el permiso en el navegador y pulsa "Reintentar".</span>');
                    solicitarGPS();
                }
                return;
            }
            $('#gpsBar').css('border-color', '#ececec');

            btnBusy(1);
            $.ajax({
                url: "login_toctoc.php",
                type: "post",
                timeout: 30000,
                data: {
                    Usuario: Usuario,
                    NIP: NIP,
                    Captcha: Captcha,
                    Lat: gpsState.lat,
                    Lon: gpsState.lon,
                    Precision: gpsState.accuracy,
                    GpsStatus: gpsState.status
                },
                success: function (data) {
                    $("#R").html(data);
                },
                error: function (xhr, status) {
                    if (status === 'timeout') {
                        $('#R_login').html('No se pudo validar tu acceso: tiempo de espera agotado.');
                    } else {
                        $('#R_login').html('No se pudo validar tu acceso. Intenta de nuevo.');
                    }
                    recargarCaptcha();
                },
                complete: function () {
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
                success: function (data) {
                    $("#R").html(data);
                },
                error: function (xhr, status) {
                    if (status === 'timeout') {
                        $('#R_login').html('No se pudo procesar la recuperación: tiempo de espera agotado.');
                    } else {
                        $('#R_login').html('No se pudo procesar la recuperación. Intenta de nuevo.');
                    }
                },
                complete: function () {
                    btnBusy(0);
                }
            });
        }

        // Navegación con tecla Enter
        document.getElementById('NEmpleado').addEventListener('keypress', function (e) {
            if (e.key === 'Enter') document.getElementById('EmpleadoNIP').focus();
        });
        document.getElementById('EmpleadoNIP').addEventListener('keypress', function (e) {
            if (e.key === 'Enter') document.getElementById('CaptchaInput').focus();
        });
        document.getElementById('CaptchaInput').addEventListener('keypress', function (e) {
            if (e.key === 'Enter') ValidarAcceso();
        });
    </script>

</body>

</html>