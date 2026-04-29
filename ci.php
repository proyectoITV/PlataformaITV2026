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
        // $('#progressbar').show();
        $('#preloader').show();
            $.ajax({
                url: "ci_download.php",
            type: "get",        
            data: {id:id},
            success: function(data){                
                $("#DivCompus").html(data+"");                    
                // $('#progressbar').hide();
                $('#preloader').hide();
            }
            });
    }
    Reload();
</script>

<?php include ("./lib/body_footer.php"); ?>