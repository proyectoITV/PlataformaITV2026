<?php include("head.php"); ?>


<?php

    $MiToken = MiToken($nitavu, "Search");
    if ($MiToken == '') {
        $MiToken = MiToken_Init($nitavu, "Search");
    }

// echo "Token: ".$MiToken."";
?>





<?php
include("header.php");
?>

<section id='Busqueda' style='
background-color: <?php echo Preference("ColorPrincipal", "", ""); ?>;
'>

<table width=100%><tr><td>
    <?php

    if (isset($_GET['q'])) {

        echo '
    <input id="InputBusqueda" list="busquedas"     data-min-length="1"
    style="

        background-color: '.Preference("ColorPrincipal", "", "").';
        

    "
    class="InputBusqueda flexdatalist" type="text" placeholder="¿Que Información necesitas?"  value="' . VarClean($_GET['q']) . '">
    ';
    } else {
        echo '
    <input id="InputBusqueda" list="busquedas"  data-min-length="1"
    style="

        background-color: '.Preference("ColorPrincipal", "", "").';
       

    "
    class="InputBusqueda flexdatalist" type="text" placeholder="¿Que Información necesitas?" >
    ';
    }

    if (isset($_GET['i1'])) {
        Toast("Guardado correctamente " . VarClean($_GET['q']), 1, "");
    }
    if (isset($_GET['e1'])) {
        Toast("ERROR:Al localizar el Reporte " . VarClean($_GET['e1']), 2, "");
    }
    // Toast("No se ha localizado tu Reporte ".$IdRep,2,"");


    ?>

</section>
</td><td width=50px align=right valign=middle 
style='
background-color: <?php echo Preference("ColorPrincipal", "", ""); ?>;
'
>
<button  class="Mbtn btn-Success"  onclick="Search();" style="
background-color:  <?php echo Preference("ColorResaltado", "", ""); ?>;
box-shadow: 0 3px  #4d4c49; margin:10px;

"> 
<img src='icons/busqueda.png' style='width:50px;'></button>

</td></table>
<div style='
background-color: <?php echo Preference("ColorPrincipal", "", ""); ?>;
text-align: center;
color: white;
font-size: 10pt;  height:22px;

-webkit-box-shadow: 1px 5px 5px -3px rgba(0,0,0,0.75);
-moz-box-shadow: 1px 5px 5px -3px rgba(0,0,0,0.75);
box-shadow: 1px 5px 5px -3px rgba(0,0,0,0.75);
margin-top:  -21px;
'>
    <div id='PreloaderBuscando' style='display:none;'>
        Buscando <img src='img/loader_bar.gif'>
    </div>
</div>

<?php
if (Preference("MostrarApps", "", "")=='TRUE'){
    echo '
    <div class="row">
    <section id="Resultados" class="col-sm">
    

    </section>

    <section id="MisApp" class="col-sm">
    ';
    echo '<div style="" class="Graficas">';
        $Labels = "'L1', 'L2','L3','L4','L5','L6','L7','L8','L9','L10','L11','L12','L13','L14' ";
        $Datas = "1,2,3,4,5,6,7,8,9,10,11,12,13,14";    
        GraficaBar($Labels,$Datas,"Grafica de Test");
    echo '</div>';


    echo '<div style="" class="Graficas">';
        $Labels = "'L1', 'L2','L3','L4','L5','L6','L7','L8','L9','L10','L11','L12','L13','L14' ";
        $Datas = "1,2,3,4,5,6,7,8,9,10,11,12,13,14";    
        $Fill = 0; // 0=no 1=si
        GraficaBarLine($Labels,$Datas,"Grafica de Test",$Fill);
    echo '</div>';


    echo '<div style="" class="Graficas">';
        $Labels = "'L1', 'L2','L3','L4','L5','L6','L7','L8','L9','L10','L11','L12','L13','L14' ";
        $Datas = "1,2,3,4,5,6,7,8,9,10,11,12,13,14";    
        GraficaBarHorizontal($Labels,$Datas,"Grafica de Test");
    echo '</div>';



    echo '<div style="" class="Graficas">';
        $Labels = "'L1', 'L2','L3','L4','L5','L6','L7','L8','L9','L10','L11','L12','L13','L14' ";
        $Datas = "1,2,3,4,5,6,7,8,9,10,11,12,13,14";    
        GraficaPie($Labels,$Datas,"Grafica de Test");
    echo '</div>';

    echo '<div style="" class="Graficas">';
        $Labels = "'L1', 'L2','L3','L4','L5','L6','L7','L8','L9','L10','L11','L12','L13','L14' ";
        $Datas = "1,2,3,4,5,6,7,8,9,10,11,12,13,14";    
        GraficaDona($Labels,$Datas,"Grafica de Test");
    echo '</div>';    


    echo '<div style="" class="Graficas">';
        $Labels = "'L1', 'L2','L3','L4','L5','L6','L7','L8','L9','L10','L11','L12','L13','L14' ";
        $Datas = "1,2,3,4,5,6,7,8,9,10,11,12,13,14"; 
        $Fill = 1; // 0=no 1=si
        GraficaBarLine($Labels,$Datas,"Grafica de Test",$Fill);
    echo '</div>'; 

    echo '

    </section>
    </div>
    ';
} else {
    echo '
    
    <section id="Resultados">    

    </section>

    
    ';
}
?>


<?php

if (UserAdmin($nitavu) == TRUE) {
    if (Preference("NuevosReportes", "", "")=='TRUE'){
    echo "<div class='btnMas' title='Haz clic aquí para crear un nuevo reporte'>
    <a href='nuevo.php' > <img src='src/mas.png' style='width:100%;'>
    </a>
    </div>";
    }

}
?>




<?php
echo "
<script> 
$('.InputBusqueda').css('background-color','".Preference("ColorPrincipal", "", "")."');
$('.InputBusqueda').css('color','white');
</script>
";
echo "
    <script>
    function Search(){
        var busqueda = $('#InputBusqueda').val();
         $('#PreloaderBuscando').show();                
            $.ajax({
                url: 'search.php',
                type: 'post',        
                data: {IdUser:'" . $nitavu . "', Token: '" . $MiToken . "',
                    busqueda:busqueda

                },
            success: function(data){
                $('#Resultados').html(data);
                $('#PreloaderBuscando').hide();
            }
            });
        
       


            
    }
    // Search();
    </script>

";?>



<?php



include ("footer.php");
?>
