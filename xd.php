<?php include ("./lib/body_head.php"); include ("./lib/body_menu.php"); ?>

<?php
// require("reportes/components.php");

$id_aplicacion = "problemas";
echo "<script>$('body').css('background-color','#34352F');</script>";
// echo "<script>$('body').css('background-image','url(img/wall_ayuda3.jpg)');</script>";
echo "<script>$('body').css('background-position','top');</script>";
echo "<script>$('body').css('background-size','120%');</script>";

echo "<div id='AppDetalle'>".app_detalle($id_aplicacion, $nitavu)."</div>";
echo "<script>$('#AppDetalle').css('background-color','rgba(2, 2, 2, 0.41)');</script>";    

echo "<div id='Contenedorproblemas'>";

        echo "<div id='ContenedorListas'>";
            
            echo "<div id='LActividad'>";
                echo "Lista de Actividades";
            echo "</div>";

        echo "</div>";
        
        echo "<div id='LAplicaciones'>";
        echo "Lista de Aplicaciones";
        echo "</div>";

        echo "<div id='ContenedorIndicadores'>";
                echo "<div id='LDelegaciones'>";
                echo "Lista de Delegaciones";
                echo "</div>";
        
                echo "<div id='LEmpleados'>";
                echo "Lista de Usuarios";
                echo "</div>";

               

        echo "</div>";

echo "</div>";















echo "<script>$('tr').css('background-color','transparent');</script>";
echo "<script>$('td').css('background-color','transparent');</script>";

?>

<script>	
function DelegacionesReload(){		                    
    $('#progressbar').show();
    LoaderDiv('LDelegaciones');
    $.ajax({
    url: "problemas_dat_delegaciones.php",
    type: "post",        
    data: {},
    success: function(data){                
        $("#LDelegaciones").html(data+"");     
        console.log('Delegaciones...');
        $('#progressbar').hide();
    }
    });

            
}
DelegacionesReload();
setInterval(DelegacionesReload, 30000);



function EmpleadosReload(){		                    
    $('#progressbar').show();
    LoaderDiv('LEmpleados');
    $.ajax({
    url: "problemas_dat_usuarios.php",
    type: "post",        
    data: {},
    success: function(data){                
        $("#LEmpleados").html(data+"");     
        console.log('Usuarios...');
        $('#progressbar').hide();
    }
    });

            
}
EmpleadosReload();
setInterval(EmpleadosReload, 50000);



function AppsReload(){		                    
    $('#progressbar').show();
    LoaderDiv('LAplicaciones');
    $.ajax({
    url: "problemas_dat_apps.php",
    type: "post",        
    data: {},
    success: function(data){                
        $("#LAplicaciones").html(data+"");     
        console.log('Usuarios...');
        $('#progressbar').hide();
    }
    });

            
}
AppsReload();
setInterval(AppsReload, 20000);






function HistoriaReload(){		                    
    $('#progressbar').show();
    Id = '<?php if (isset($_GET['id'])){echo $_GET['id'];} ?>';
    
    LoaderDiv('LActividad');
    $.ajax({
    url: "problemas_dat_happs.php",
    type: "post",        
    data: { Id:Id},
    success: function(data){                
        $("#LActividad").html(data+"");     
        console.log('Historia...');
        $('#progressbar').hide();
    }
    });

            
}
HistoriaReload();
setInterval(HistoriaReload, 120000);




function Status(IdProblema, IdStatus){		                    
    $('#progressbar').show();
    
    // LoaderDiv('Lproblemas');
    $.ajax({
    url: "problemas_dat_status.php",
    type: "post",        
    data: {IdStatus:IdStatus, IdProblema:IdProblema},
    success: function(data){                
        $("#R").html(data+"");     
        console.log('Status...');
        $('#progressbar').hide();
    }
    });

            
}



</script>


</div>
<?php include ("./lib/body_footer.php"); ?>