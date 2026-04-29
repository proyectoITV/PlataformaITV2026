<?php
include ("./lib/body_head.php"); include ("./lib/body_menu.php");
echo "<script>$('body').css('background-color','rgb(0, 100, 167)');</script>";
echo "<script>$('body').css('background-image','url(https://source.unsplash.com/random/1920x1080/?computer)');</script>";
echo "<script>$('body').css('background-position','top');</script>";
echo "<script>$('body').css('background-size','150%');</script>";
echo "<script>$('body').css('background-blend-mode','luminosity ');</script>";
echo "<script>$('tr').css('background-color','transparent');</script>";
echo "<script>$('td').css('background-color','transparent');</script>";

?>

<?php
//PROCESO PARA TOCAR LA PUERTA DE SAN PEDRO
$id_aplicacion ="ap80"; //Id de la aplicacion a cargar
if (sanpedro($id_aplicacion, $nitavu)==TRUE){
    echo "<div id='AppDetalle'>".app_detalle($id_aplicacion, $nitavu)."</div>";




    echo "<div id='DivCompus' class='container' style='
    background-color: #ffffffb0;
    padding: 20px;
    border-radius: 10px;
    margin-top: 30px;
    
    '>";

    echo "</div>";
    


}else{mensaje("ERROR: Sin autorizacion para esta aplicacion",'./index.php?home=');}

?>
<script>
function Reload(){		                    
        // $('#progressbar').show();
        $('#preloader').show();
            $.ajax({
                url: "ipinfo_dat.php",
            type: "post",        
            data: {},
            success: function(data){                
                $("#DivCompus").html(data+"");                    
                // $('#progressbar').hide();
                $('#preloader').hide();
            }
            });

            
}
Reload();


function Activar(IdEquipo){		                    
        // $('#progressbar').show();
        $('#preloader').show();
            $.ajax({
                url: "ipinfo_dat2.php",
            type: "post",        
            data: {IdEquipo:IdEquipo},
            success: function(data){                
                $("#R").html(data+"");                    
                // $('#progressbar').hide();
                $('#preloader').hide();
            }
            });

            
}
</script>
<?php include ("./lib/body_footer.php"); ?>