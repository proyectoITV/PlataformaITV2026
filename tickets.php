<?php
include ("./lib/body_head.php");
include ("./lib/body_menu.php"); 

$idDepartamento=nitavu_dpto($nitavu);
$id_aplicacion ="ap66";
$nivel =aplicacion_nivel($id_aplicacion, $nitavu);
if (sanpedro($id_aplicacion, $nitavu)==TRUE){
    echo "<div id='AppDetalle'>".app_detalle($id_aplicacion, $nitavu)."</div>";	
    echo '
    <div id="DivBuscar" style="padding: 10px;">
    <input style="width:80%; height:50px; vertical-align: top; display:inline-block;" class="form-control mr-sm-2" id="InputBusqueda" type="search" placeholder="Busqueda..." aria-label="Busqueda">
    <button class="btn-identidad-color1" style="width:15%; height:41px; vertical-align:top;" onclick="BuscarTicket(1);">Buscar</button>
    
        <div id="PreLoader_buscando" style="
            position: absolute;
            right: 26px;
            margin-top: -24px;
            display:none;
        ">
            <img src="img/loader_bar.gif" style="">

        </div>

    </div>
    ';

    echo "<div id='DivResultado'>";
    echo "</div>";

    
    
    echo "<form action='cp_nuevos_oficios.php' method='GET' style='
        padding: 10px;
        
        background-color: #ddc9a3;
        margin: 10px;
        margin-top:20px;
        border-radius: 5px;
    '>";
    echo "Si conoces el número de correspondencia<br> ";
    echo "<input type='text' class='' name='id' id='id' placeholder='Número de correspondencia'  style='width:40%; height:40px;' required>";
    echo "<input type='submit' class='btn-identidad-color1' value='Abrir' style='width:20%; margin-top: 2px; margin-left: 10px;
    vertical-align: top;'>";
    echo "</form>";
    

    echo "
    <script>
    function BuscarTicket(mode){   
        $('#PreLoader_buscando').show();
        $('#IconBusqueda').hide();
        busqueda = $('#InputBusqueda').val();
        console.log('Buscando ' + busqueda);
            $.ajax({
                url: 'tickets_data.php',
                type: 'post',			
                data: {nitavu: '".$nitavu."', busqueda:busqueda, mode:mode },
                success: function(data){
                $('#DivResultado').html(data);
                $('#PreLoader_buscando').hide();
                
                }
            });
                
    }
    BuscarTicket(0);
    </script>
        ";

} else {
    mensaje("ERROR: no tiene acceso a esta aplicacion",'./index.php?home=');
}



include ("./lib/body_footer.php");

?>
