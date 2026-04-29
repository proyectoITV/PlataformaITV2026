<?php
include ("lib/body_head.php");// Estructura de Plataforma
include ("lib/body_menu.php"); //interfaz de menus
?>


<button id='btnPlantilla' class='btn btn-primary' onclick='getPlantillaContrato();'
    style='
        z-index:10;
    '
>Cargar Plantilla</button>

<div id='AquiVaMiPlantilla' style='
    width: 100%;
    height: 100%;
    background-color: #d9dbdb;
    text-align: center;
    position: fixed;
    top: 0px;
    z-index:0px;
'>
</div>


<script>
function getPlantillaContrato(){     
    IdPlantilla = 1;     
    $("#AquiVaMiPlantilla").html("<br><br><br>Cargando <img src='img/loader_bar.gif'>")
    $.ajax({
        url: "test_plantilla-controller.php",
        type: "post",   
        data: {IdPlantilla: IdPlantilla},
        success: function(data){            
            $('#AquiVaMiPlantilla').html(data);
            // $("#preloader").hide();   
      }
   });
   
}
</script>

<?php
include ("./lib/body_footer.php"); 
?>