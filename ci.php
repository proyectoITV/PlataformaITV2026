<link href="css/style.css" rel="stylesheet">
<link href="css/slick.css" rel="stylesheet">
<link href="css/responsive.css" rel="stylesheet">

<?php
    include ("./lib/body_head.php"); include ("./lib/body_menu.php");
    //echo "<script>$('body').css('background-color','rgb(255, 255, 255)');</script>";
    ////echo "<script>$('body').css('background-image','url(img/wall_ayuda3.jpg)');</script>";
    //echo "<script>$('body').css('background-position','top');</script>";
    //echo "<script>$('body').css('background-size','130%');</script>";
    //echo "<script>$('body').css('background-blend-mode','luminosity ');</script>";
    //echo "<script>$('tr').css('background-color','transparent');</script>";
    //echo "<script>$('td').css('background-color','transparent');</script>";

    $id_aplicacion ="ci";
    if (sanpedro($id_aplicacion, $nitavu)==TRUE)
    {
        echo "<div id='AppDetalle'>".app_detalle($id_aplicacion, $nitavu)."</div>";

        echo "
        <section class='page-title' style='background-image:url(img/controlinterno.jpg); '>
            <div class='auto-container'>
                <h2>Departamento de Control Interno</h2>
            </div>
        </section>
        ";

        echo "
        <section class='contact-location-section'>
            <div class='auto-container'>
                <div class='row clearfix'>
                    
                    <div class='info-column col-lg-4 col-md-6 col-sm-12'>
                        <div class='column-inner'>
                            <div class='image'> <img src='icon/integrantes.png' alt='' /></div>
                            <h3>Integrantes</h3>
                            <ul>
                                <li>C.P. Dennise Betsabe Reyes Garza</li>
                                <li>Lic. Edgar Eliud Acevedo Medrano</li>
                            </ul>
                        </div>
                    </div>
                    
                    <div class='info-column col-lg-4 col-md-6 col-sm-12'>
                        <div class='column-inner'>
                            <div class='image'>
                                <img src='icon/correo.png' alt='' />
                            </div>
                            <h3>Correo Electrónico</h3>
                            <ul>
                                <li style='color: black;'>itavu.controlinterno@tamaulipas.gob.mx</li>
                            </ul>
                        </div>
                    </div>
                    
                    <div class='info-column col-lg-4 col-md-6 col-sm-12'>
                        <div class='column-inner'>
                            <div class='image'> <img src='icon/phone.png' alt='' /></div>
                            <h3>Teléfono de atención</h3>
                            <ul>
                                <li>(834) 31 55 06 Extensión 46556</li>
                            </ul>
                        </div>
                    </div>
                    
                </div>
            </div>
        </section>
        ";
            
        echo "<div id='DivCompus' class='container' style='background-color: #ddddddb0; padding: 20px; border-radius: 10px; margin-top: 30px; '></div>";
    }
    else
    {
        mensaje("ERROR: Sin autorizacion para esta aplicacion",'./index.php?home=');
    }
?>


<style>
/* Modern Elegant Modal for PDF and MP4 Viewer */
.ci-modal-overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100vw;
    height: 100vh;
    background: rgba(15, 23, 42, 0.65); /* Elegant Slate-900 transparent */
    backdrop-filter: blur(12px);
    -webkit-backdrop-filter: blur(12px);
    z-index: 1050;
    display: none;
    align-items: center;
    justify-content: center;
    opacity: 0;
    transition: opacity 0.35s cubic-bezier(0.16, 1, 0.3, 1);
}
.ci-modal-overlay.active {
    opacity: 1;
}
.ci-modal-wrapper {
    background: #ffffff;
    border: 1px solid rgba(255, 255, 255, 0.25);
    border-radius: 16px;
    box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.3);
    width: 92%;
    max-width: 1100px;
    height: 85%;
    max-height: 850px;
    display: flex;
    flex-direction: column;
    transform: scale(0.92) translateY(20px);
    transition: transform 0.35s cubic-bezier(0.34, 1.56, 0.64, 1);
    overflow: hidden;
}
.ci-modal-overlay.active .ci-modal-wrapper {
    transform: scale(1) translateY(0);
}
.ci-modal-header {
    padding: 16px 24px;
    border-bottom: 1px solid rgba(0, 0, 0, 0.08);
    display: flex;
    align-items: center;
    justify-content: space-between;
    background: #ffffff;
}
.ci-modal-title {
    margin: 0;
    font-size: 1.15rem;
    font-weight: 600;
    color: #0f172a;
    font-family: inherit;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
    max-width: calc(100% - 50px);
}
.ci-modal-close-btn {
    background: #f1f5f9;
    border: none;
    border-radius: 50%;
    width: 36px;
    height: 36px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #64748b;
    cursor: pointer;
    transition: all 0.2s ease-in-out;
    padding: 0;
}
.ci-modal-close-btn:hover {
    background: #cbd5e1;
    color: #0f172a;
    transform: rotate(90deg);
}
.ci-modal-body {
    flex: 1;
    padding: 0;
    background: #f8fafc;
    position: relative;
    overflow: hidden;
    display: flex;
    align-items: center;
    justify-content: center;
}
.ci-modal-iframe {
    width: 100%;
    height: 100%;
    border: none;
    background: #ffffff;
}
.ci-modal-video {
    width: 100%;
    height: 100%;
    object-fit: contain;
    background: #000000;
}
</style>

<!-- Modern elegant modal window for PDF/MP4 files -->
<div id="ci-modal" class="ci-modal-overlay">
    <div class="ci-modal-wrapper">
        <div class="ci-modal-header">
            <h3 id="ci-modal-title" class="ci-modal-title">Visualizador de Documentos</h3>
            <button id="ci-modal-close" class="ci-modal-close-btn" aria-label="Cerrar">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="18" y1="6" x2="6" y2="18"></line>
                    <line x1="6" y1="6" x2="18" y2="18"></line>
                </svg>
            </button>
        </div>
        <div id="ci-modal-body" class="ci-modal-body">
            <!-- Dynamic content will be loaded here -->
        </div>
    </div>
</div>

<script>
    function Reload(){		                    
        // $('#progressbar').show();
        $('#preloader').show();
            $.ajax({
                url: "ci_dat.php",
            type: "post",        
            data: {},
            success: function(data){                
                $("#DivCompus").html(data+"");                    
                // $('#progressbar').hide();
                $('#preloader').hide();
            }
            });
    }

    function Ver(id){		                    
        $('#preloader').show();
        $.ajax({
            url: "ci_download.php",
            type: "get",        
            data: {id: id},
            dataType: "json",
            success: function(response){                
                $('#preloader').hide();
                if (response.success) {
                    // Set title of the document/video
                    $('#ci-modal-title').text(response.nombre);
                    
                    var bodyHtml = '';
                    if (response.isVideo) {
                        bodyHtml = '<video class="ci-modal-video" controls autoplay>' +
                                   '<source src="' + response.link + '" type="video/mp4">' +
                                   'Su navegador no soporta vídeos HTML5.' +
                                   '</video>';
                    } else {
                        // Embed the PDF with toolbar disabled for elegance, height 100%
                        bodyHtml = '<iframe class="ci-modal-iframe" src="' + response.link + '#toolbar=0"></iframe>';
                    }
                    
                    $('#ci-modal-body').html(bodyHtml);
                    
                    // Show modal with animation
                    $('#ci-modal').css('display', 'flex');
                    setTimeout(function() {
                        $('#ci-modal').addClass('active');
                    }, 10);
                } else {
                    alert(response.message || 'Error al obtener el archivo.');
                }
            },
            error: function(){
                $('#preloader').hide();
                alert('Ocurrió un error al cargar el archivo.');
            }
        });
    }

    function CerrarModal() {
        $('#ci-modal').removeClass('active');
        setTimeout(function() {
            $('#ci-modal-body').html('');
            $('#ci-modal').hide();
        }, 350); // Matches the CSS transition duration
    }

    $(document).ready(function() {
        // Close modal when clicking close button
        $('#ci-modal-close').on('click', function() {
            CerrarModal();
        });

        // Close modal when clicking overlay background
        $('#ci-modal').on('click', function(e) {
            if ($(e.target).hasClass('ci-modal-overlay')) {
                CerrarModal();
            }
        });

        // Close modal on Escape key press
        $(document).on('keydown', function(e) {
            if (e.key === 'Escape' && $('#ci-modal').hasClass('active')) {
                CerrarModal();
            }
        });
    });

    Reload();
</script>

<?php include ("./lib/body_footer.php"); ?>