<?php
include ("./lib/body_head.php"); include ("./lib/body_menu.php");
echo "<script>$('body').css('background-color','rgb(0, 100, 167)');</script>";
echo "<script>$('body').css('background-image','url(img/wall_ayuda3.jpg)');</script>";
echo "<script>$('body').css('background-position','top');</script>";
echo "<script>$('body').css('background-size','130%');</script>";
echo "<script>$('body').css('background-blend-mode','luminosity ');</script>";
echo "<script>$('tr').css('background-color','transparent');</script>";
echo "<script>$('td').css('background-color','transparent');</script>";

?>

<?php
//PROCESO PARA TOCAR LA PUERTA DE SAN PEDRO
$id_aplicacion ="ci"; //Id de la aplicacion a cargar
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