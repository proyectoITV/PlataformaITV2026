<?php
/**
 * Componente: Aviso Institucional y Modal de Suspensión de Servicio
 * Plataforma ITAVU 2026
 * 
 * Programado para el Viernes 25 de Septiembre de 2026
 */

// Ventana de visualización del aviso: Desde el 23 de septiembre hasta el final del 25 de septiembre
$fecha_aviso_inicio = strtotime('2026-09-23 00:00:00');
$fecha_aviso_fin = strtotime('2026-09-26 00:00:00');
$ahora_aviso = time();

// Si estamos fuera del rango de la campaña de aviso, no renderizar
if ($ahora_aviso < $fecha_aviso_inicio || $ahora_aviso >= $fecha_aviso_fin) {
    return;
}
?>

<!-- ==========================================
     ESTILOS INSTITUCIONALES PRO DEL AVISO
     ========================================== -->
<style>
    /* --- Barra Superior de Aviso Institucional --- */
    .itavu-aviso-banner-bar {
        background: linear-gradient(90deg, #3d050b 0%, #7c121d 40%, #8a1520 60%, #3d050b 100%);
        color: #ffffff;
        border-bottom: 2px solid #bc955c;
        padding: 10px 20px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 12px;
        position: relative;
        z-index: 100;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.15);
        font-family: 'Open Sans', 'Segoe UI', -apple-system, sans-serif;
        animation: itavuBannerFadeIn 0.5s ease-out;
    }

    @keyframes itavuBannerFadeIn {
        from {
            opacity: 0;
            transform: translateY(-10px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .itavu-aviso-banner-left {
        display: flex;
        align-items: center;
        gap: 12px;
        flex: 1;
        min-width: 280px;
    }

    .itavu-aviso-icon-badge {
        width: 34px;
        height: 34px;
        border-radius: 10px;
        background: rgba(188, 149, 92, 0.2);
        border: 1px solid #bc955c;
        color: #e5c07b;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 16px;
        flex-shrink: 0;
        animation: itavuPulseIcon 2s infinite ease-in-out;
    }

    @keyframes itavuPulseIcon {

        0%,
        100% {
            transform: scale(1);
            box-shadow: 0 0 0 0 rgba(188, 149, 92, 0.4);
        }

        50% {
            transform: scale(1.08);
            box-shadow: 0 0 10px 2px rgba(188, 149, 92, 0.6);
        }
    }

    .itavu-aviso-banner-text {
        font-size: 13px;
        line-height: 1.45;
        color: #fce7e7;
    }

    .itavu-aviso-banner-text strong {
        color: #ffffff;
        font-weight: 700;
    }

    .itavu-aviso-date-tag {
        display: inline-block;
        background: rgba(0, 0, 0, 0.35);
        border: 1px solid rgba(220, 201, 163, 0.4);
        color: #ddc9a3;
        padding: 2px 8px;
        border-radius: 5px;
        font-weight: 700;
        font-size: 12px;
        letter-spacing: 0.02em;
        margin: 0 4px;
    }

    .itavu-aviso-btn-open {
        background: linear-gradient(135deg, #bc955c 0%, #a47c43 100%);
        color: #1a1005 !important;
        border: none;
        outline: none;
        padding: 7px 16px;
        border-radius: 8px;
        font-size: 12.5px;
        font-weight: 700;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 7px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.25);
        transition: all 0.25s ease;
        text-decoration: none !important;
        white-space: nowrap;
    }

    .itavu-aviso-btn-open:hover {
        background: linear-gradient(135deg, #d4ae73 0%, #bc955c 100%);
        transform: translateY(-1px);
        box-shadow: 0 4px 14px rgba(188, 149, 92, 0.4);
        color: #000000 !important;
    }

    /* --- Backdrop y Overlay del Modal --- */
    .itavu-modal-backdrop {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(15, 23, 42, 0.75);
        backdrop-filter: blur(8px);
        -webkit-backdrop-filter: blur(8px);
        z-index: 999999;
        display: none;
        align-items: center;
        justify-content: center;
        padding: 20px;
        box-sizing: border-box;
        opacity: 0;
        transition: opacity 0.3s cubic-bezier(0.16, 1, 0.3, 1);
    }

    .itavu-modal-backdrop.show {
        display: flex;
        opacity: 1;
    }

    /* --- Tarjeta Contenedora del Modal --- */
    .itavu-modal-card {
        background: #ffffff;
        width: 100%;
        max-width: 650px;
        max-height: 90vh;
        border-radius: 20px;
        overflow: hidden;
        box-shadow: 0 25px 60px -15px rgba(0, 0, 0, 0.5), 0 0 0 1px rgba(188, 149, 92, 0.25);
        display: flex;
        flex-direction: column;
        transform: scale(0.92) translateY(20px);
        transition: transform 0.35s cubic-bezier(0.16, 1, 0.3, 1);
        font-family: 'Open Sans', 'Segoe UI', -apple-system, sans-serif;
        position: relative;
    }

    .itavu-modal-backdrop.show .itavu-modal-card {
        transform: scale(1) translateY(0);
    }

    /* --- Header Ejecutivo del Modal --- */
    .itavu-modal-header {
        background: linear-gradient(135deg, #600812 0%, #7c121d 50%, #400308 100%);
        padding: 24px 28px 20px;
        position: relative;
        border-bottom: 3px solid #bc955c;
        color: #ffffff;
    }

    .itavu-modal-header-top {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 14px;
    }

    .itavu-modal-brand-capsule {
        background: rgba(255, 255, 255, 0.96);
        padding: 6px 14px;
        border-radius: 10px;
        display: inline-flex;
        align-items: center;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.25);
    }

    .itavu-modal-brand-capsule img {
        height: 28px;
        width: auto;
        object-fit: contain;
    }

    .itavu-modal-chip-status {
        background: rgba(255, 255, 255, 0.12);
        border: 1px solid rgba(220, 201, 163, 0.4);
        padding: 4px 12px;
        border-radius: 50px;
        font-size: 11px;
        font-weight: 700;
        color: #f7e6ca;
        letter-spacing: 0.05em;
        text-transform: uppercase;
        display: inline-flex;
        align-items: center;
        gap: 7px;
    }

    .itavu-modal-pulse-dot {
        width: 8px;
        height: 8px;
        background: #ef4444;
        border-radius: 50%;
        display: inline-block;
        box-shadow: 0 0 8px #ef4444;
        animation: itavuPulseDot 1.4s infinite ease-in-out;
    }

    @keyframes itavuPulseDot {

        0%,
        100% {
            transform: scale(1);
            opacity: 1;
        }

        50% {
            transform: scale(1.4);
            opacity: 0.5;
        }
    }

    .itavu-modal-close-btn {
        position: absolute;
        top: 20px;
        right: 22px;
        width: 32px;
        height: 32px;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.15);
        border: none;
        color: #ffffff;
        font-size: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.2s ease;
    }

    .itavu-modal-close-btn:hover {
        background: rgba(255, 255, 255, 0.3);
        transform: rotate(90deg);
    }

    .itavu-modal-title {
        font-size: 21px;
        font-weight: 800;
        color: #ffffff;
        margin: 0 0 6px 0;
        letter-spacing: -0.01em;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .itavu-modal-title i {
        color: #e5c07b;
        font-size: 22px;
    }

    .itavu-modal-subtitle {
        font-size: 12.5px;
        color: #f1d3d6;
        margin: 0;
        font-weight: 500;
        line-height: 1.4;
    }

    /* --- Cuerpo con Scroll Elegante --- */
    .itavu-modal-body {
        padding: 24px 28px;
        overflow-y: auto;
        max-height: calc(90vh - 220px);
        color: #334155;
        background: #fcfdfd;
    }

    .itavu-modal-body::-webkit-scrollbar {
        width: 6px;
    }

    .itavu-modal-body::-webkit-scrollbar-track {
        background: #f1f5f9;
    }

    .itavu-modal-body::-webkit-scrollbar-thumb {
        background: #cbd5e1;
        border-radius: 10px;
    }

    /* --- Tarjeta Destacada de Fecha y Horario --- */
    .itavu-date-hero-card {
        background: linear-gradient(135deg, #fffbf0 0%, #fff7e6 100%);
        border: 1.5px solid #e8cb9b;
        border-radius: 14px;
        padding: 16px 20px;
        display: flex;
        align-items: center;
        gap: 18px;
        margin-bottom: 20px;
        box-shadow: 0 4px 12px rgba(188, 149, 92, 0.1);
    }

    .itavu-date-hero-icon {
        width: 52px;
        height: 52px;
        border-radius: 12px;
        background: #7c121d;
        color: #ffffff;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        box-shadow: 0 4px 10px rgba(124, 18, 29, 0.3);
    }

    .itavu-date-hero-icon .day {
        font-size: 20px;
        font-weight: 800;
        line-height: 1;
    }

    .itavu-date-hero-icon .month {
        font-size: 9px;
        font-weight: 700;
        letter-spacing: 0.08em;
        text-transform: uppercase;
        color: #ddc9a3;
        margin-top: 2px;
    }

    .itavu-date-hero-details h4 {
        margin: 0 0 4px 0;
        font-size: 15.5px;
        font-weight: 700;
        color: #7c121d;
    }

    .itavu-date-hero-details p {
        margin: 0;
        font-size: 12.5px;
        color: #64748b;
        line-height: 1.4;
    }

    .itavu-date-hero-details p strong {
        color: #1e293b;
    }

    /* --- Mensaje Contextual --- */
    .itavu-modal-statement {
        font-size: 13.5px;
        line-height: 1.6;
        color: #475569;
        margin-bottom: 20px;
        background: #ffffff;
        border-left: 4px solid #7c121d;
        padding: 12px 16px;
        border-radius: 0 10px 10px 0;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.03);
    }

    /* --- Grid de Medidas Preventivas --- */
    .itavu-section-title {
        font-size: 12.5px;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 0.06em;
        color: #7c121d;
        margin-bottom: 12px;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .itavu-section-title::after {
        content: '';
        flex: 1;
        height: 1px;
        background: #e2e8f0;
    }

    .itavu-preventive-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 12px;
        margin-bottom: 16px;
    }

    .itavu-preventive-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        padding: 14px;
        display: flex;
        align-items: flex-start;
        gap: 12px;
        transition: all 0.2s ease;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.02);
    }

    .itavu-preventive-card:hover {
        border-color: #bc955c;
        box-shadow: 0 6px 16px rgba(188, 149, 92, 0.12);
        transform: translateY(-2px);
    }

    .itavu-card-icon {
        width: 34px;
        height: 34px;
        border-radius: 8px;
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 14px;
        color: #7c121d;
        flex-shrink: 0;
        transition: all 0.2s ease;
    }

    .itavu-preventive-card:hover .itavu-card-icon {
        background: #7c121d;
        color: #ffffff;
        border-color: #7c121d;
    }

    .itavu-card-text {
        flex: 1;
    }

    .itavu-card-text h5 {
        margin: 0 0 3px 0;
        font-size: 13px;
        font-weight: 700;
        color: #0f172a;
    }

    .itavu-card-text p {
        margin: 0;
        font-size: 11.5px;
        color: #64748b;
        line-height: 1.4;
    }

    /* --- Footer del Modal --- */
    .itavu-modal-footer {
        padding: 16px 28px;
        background: #f8fafc;
        border-top: 1px solid #e2e8f0;
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 12px;
    }

    .itavu-modal-remember {
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 12.5px;
        color: #64748b;
        cursor: pointer;
        user-select: none;
    }

    .itavu-modal-remember input[type="checkbox"] {
        width: 16px;
        height: 16px;
        accent-color: #7c121d;
        cursor: pointer;
    }

    .itavu-modal-action-btn {
        background: linear-gradient(135deg, #7c121d 0%, #990000 100%);
        color: #ffffff !important;
        border: none;
        outline: none;
        padding: 10px 22px;
        border-radius: 10px;
        font-size: 13.5px;
        font-weight: 700;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        box-shadow: 0 4px 14px rgba(124, 18, 29, 0.3);
        transition: all 0.25s ease;
        text-decoration: none !important;
    }

    .itavu-modal-action-btn:hover {
        background: linear-gradient(135deg, #990000 0%, #b31b1b 100%);
        transform: translateY(-1px);
        box-shadow: 0 6px 18px rgba(124, 18, 29, 0.45);
        color: #ffffff !important;
    }

    /* --- Responsive --- */
    @media (max-width: 640px) {
        .itavu-preventive-grid {
            grid-template-columns: 1fr;
        }

        .itavu-modal-header {
            padding: 20px 20px 16px;
        }

        .itavu-modal-body {
            padding: 18px 20px;
        }

        .itavu-modal-footer {
            padding: 14px 20px;
            flex-direction: column;
            align-items: stretch;
        }

        .itavu-modal-action-btn {
            justify-content: center;
        }
    }
</style>

<!-- ==========================================
     BARRA DE AVISO SUPERIOR EN INDEX.PHP
     ========================================== -->
<div id="itavuAvisoBannerBar" class="itavu-aviso-banner-bar">
    <div class="itavu-aviso-banner-left">
        <div class="itavu-aviso-icon-badge">
            <i class="fa-solid fa-triangle-exclamation"></i>
        </div>
        <div class="itavu-aviso-banner-text">
            <strong>AVISO IMPORTANTE:</strong> Se suspenderá temporalmente el servicio de la plataforma el
            <span class="itavu-aviso-date-tag"><i class="fa-regular fa-calendar-xmark"></i> Viernes 25 de Septiembre de
                2026</span>
            por mantenimiento técnico preventivo.
        </div>
    </div>
    <div class="itavu-aviso-banner-right">
        <button type="button" class="itavu-aviso-btn-open" onclick="abrirModalAvisoMantenimiento();">
            <i class="fa-solid fa-circle-info"></i> Ver Comunicado y Medidas
        </button>
    </div>
</div>

<!-- ==========================================
     MODAL INSTITUCIONAL PRO
     ========================================== -->
<div id="itavuModalAvisoMantenimiento" class="itavu-modal-backdrop" onclick="clickFondoModalAviso(event);">
    <div class="itavu-modal-card" role="dialog" aria-modal="true" aria-labelledby="itavuModalAvisoTitulo">

        <!-- Header -->
        <div class="itavu-modal-header">
            <!-- <div class="itavu-modal-header-top">
                <div class="itavu-modal-brand-capsule">
                    <img src="img/LogotipoOficial.jpg" alt="ITAVU Tamaulipas" onerror="this.src='img/itavuLogo.png';">
                </div>
                <div class="itavu-modal-chip-status">
                    <span class="itavu-modal-pulse-dot"></span> Mantenimiento Programado
                </div>
            </div> -->

            <button type="button" class="itavu-modal-close-btn" onclick="cerrarModalAvisoMantenimiento();"
                title="Cerrar aviso" aria-label="Cerrar">
                <i class="fa-solid fa-xmark"></i>
            </button>

            <h3 id="itavuModalAvisoTitulo" class="itavu-modal-title">
                <i class="fa-solid fa-bullhorn"></i> Suspensión Temporal de Servicio
            </h3>
            <p class="itavu-modal-subtitle">
                Aviso a todos los colaboradores y delegaciones sobre labores técnicas en servidores centrales.
            </p>
        </div>

        <!-- Body -->
        <div class="itavu-modal-body">

            <!-- Hero Card con Fecha -->
            <div class="itavu-date-hero-card">
                <div class="itavu-date-hero-icon">
                    <span class="day">25</span>
                    <span class="month">SEP</span>
                </div>
                <div class="itavu-date-hero-details">
                    <h4>Viernes 25 de Septiembre de 2026</h4>
                    <p>
                        <b>Horario de corte:</b> A partir de las <b>00:00 hrs</b> y durante toda la
                        jornada.
                    </p>
                </div>
            </div>

            <!-- Exposición de Motivos -->
            <div class="itavu-modal-statement">
                Como parte de las acciones permanentes de optimización de infraestructura tecnológica,
                mantenimiento preventivo y aseguramiento de servidores centrales de <b>ITAVU</b>, el acceso a
                la <b>Plataforma Institucional estará fuera de servicio</b> en la fecha indicada.
            </div>

            <!-- Título de Medidas -->
            <div class="itavu-section-title">
                <i class="fa-solid fa-list-check"></i> Medidas Preventivas Recomendadas
            </div>

            <!-- Grid de Recomendaciones -->
            <div class="itavu-preventive-grid">

                <div class="itavu-preventive-card">
                    <div class="itavu-card-icon">
                        <i class="fa-solid fa-floppy-disk"></i>
                    </div>
                    <div class="itavu-card-text">
                        <p>Revisar y gestionar el estatus de todos los pendientes en estatus ABIERTO, programando su
                            resolución y seguimiento previo al cierre.</p>
                    </div>
                </div>

                <div class="itavu-preventive-card">
                    <div class="itavu-card-icon">
                        <i class="fa-solid fa-file-arrow-down"></i>
                    </div>
                    <div class="itavu-card-text">
                        <p>Descargue con anticipación formatos o reportes necesarios para su jornada laboral.</p>
                    </div>
                </div>

                <div class="itavu-preventive-card">
                    <div class="itavu-card-icon">
                        <i class="fa-solid fa-lock"></i>
                    </div>
                    <div class="itavu-card-text">
                        <p>Los Ticket de servicio, Encuestas de satisfacción, Requisiciones, etc. permanecerán
                            inaccesibles durante la ventana técnica.</p>
                    </div>
                </div>

                <div class="itavu-preventive-card">
                    <div class="itavu-card-icon">
                        <i class="fa-solid fa-arrows-rotate"></i>
                    </div>
                    <div class="itavu-card-text">
                        <p>El sistema se restablecerá de manera habitual al concluir satisfactoriamente las
                            actualizaciones técnicas.</p>
                    </div>
                </div>

            </div>

        </div>

        <!-- Footer -->
        <div class="itavu-modal-footer">
            <label class="itavu-modal-remember">
                <input type="checkbox" id="chkNoVolverAMostrarAviso">
                <span>No volver a mostrar automáticamente hoy</span>
            </label>
            <button type="button" class="itavu-modal-action-btn" onclick="cerrarModalAvisoMantenimiento();">
                <i class="fa-solid fa-circle-check"></i> Entendido, tomaré precauciones
            </button>
        </div>

    </div>
</div>

<!-- ==========================================
     LÓGICA JAVASCRIPT DEL MODAL
     ========================================== -->
<script>
    (function () {
        var MODAL_STORAGE_KEY = 'itavu_aviso_mant_20260925_dismissed';

        window.abrirModalAvisoMantenimiento = function () {
            var modal = document.getElementById('itavuModalAvisoMantenimiento');
            if (modal) {
                modal.style.display = 'flex';
                setTimeout(function () {
                    modal.classList.add('show');
                }, 10);
                document.body.style.overflow = 'hidden';
            }
        };

        window.cerrarModalAvisoMantenimiento = function () {
            var modal = document.getElementById('itavuModalAvisoMantenimiento');
            if (modal) {
                modal.classList.remove('show');
                setTimeout(function () {
                    modal.style.display = 'none';
                    document.body.style.overflow = '';
                }, 300);

                var chk = document.getElementById('chkNoVolverAMostrarAviso');
                if (chk && chk.checked) {
                    // Guarda la fecha de hoy para no volver a mostrar en el día
                    try {
                        localStorage.setItem(MODAL_STORAGE_KEY, new Date().toISOString().slice(0, 10));
                    } catch (e) { }
                } else {
                    // Si no marcó el checkbox, solo recordar en la sesión actual
                    try {
                        sessionStorage.setItem(MODAL_STORAGE_KEY, '1');
                    } catch (e) { }
                }
            }
        };

        window.clickFondoModalAviso = function (e) {
            if (e.target && e.target.id === 'itavuModalAvisoMantenimiento') {
                cerrarModalAvisoMantenimiento();
            }
        };

        // Cerrar con tecla Escape
        document.addEventListener('keydown', function (e) {
            if (e.key === 'Escape' || e.keyCode === 27) {
                var modal = document.getElementById('itavuModalAvisoMantenimiento');
                if (modal && modal.classList.contains('show')) {
                    cerrarModalAvisoMantenimiento();
                }
            }
        });

        // Verificación automática al autenticarse / cargar index.php
        function verificarAperturaAutomatica() {
            try {
                var hoy = new Date().toISOString().slice(0, 10);
                var dismissDate = localStorage.getItem(MODAL_STORAGE_KEY);
                var dismissSession = sessionStorage.getItem(MODAL_STORAGE_KEY);

                // Si no ha sido descartado hoy ni en la sesión actual, desplegar automáticamente
                if (dismissDate !== hoy && dismissSession !== '1') {
                    setTimeout(function () {
                        abrirModalAvisoMantenimiento();
                    }, 400); // Breve retardo para que la interfaz cargue limpiamente
                }
            } catch (e) {
                abrirModalAvisoMantenimiento();
            }
        }

        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', verificarAperturaAutomatica);
        } else {
            verificarAperturaAutomatica();
        }
    })();
</script>