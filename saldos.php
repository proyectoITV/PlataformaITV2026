<?php
include("lib/body_head.php");
include("lib/body_menu.php");
$id_aplicacion ="ap92"; //Id de la aplicacion a cargar
docdigital_no(FALSE, 1); //ahorra 1 hoja
xd_update('monitor',$nitavu);//guarda la experiencia del usuario


if (sanpedro($id_aplicacion, $nitavu)==TRUE){
    // $MisDepartamentos = misdptos($nitavu);
    echo "<div id='AppDetalle'>".app_detalle($id_aplicacion, $nitavu)."</div>";
    


    $sql="select id as IdDelegacion, cat_delegaciones.* from cat_delegaciones where dpto_id<>'' order by nombre";
    $r= $conexion -> query($sql);
    
    echo "<div id='MonitorDiv'>";
    echo "<table class='tabla'>";
    echo "<th>";
    echo "<a title='Haz clic para Traer Todos los Datos desde todas las Delegaciones' style='display:block;cursor:pointer;' 
    onclick='Todo();'>Delegaciones</a>";    
    echo "</th>";
    
    echo "<th>"; ///*
    echo "<a title='Haz clic para Traer los Datos de este tema de todas las delegaciones' style='display:block;cursor:pointer;' 
    onclick='TodoSTD();'>Saldo de Contratos Totales de la Delegacion(STD)</a>";    
    echo "</th>";

   
    echo "<th style='background-color:#a2b3a4;'>";
    echo "<a title='Haz clic para Traer los Datos de este tema de todas las delegaciones' style='display:block;cursor:pointer;' 
    onclick='TodoSCEI();'>Saldo Sin Contratos con Errores Identificados (SCEI)</a>";    
    echo "</th>";

    echo "<th>"; ///*
    echo "<a title='Haz clic para Traer los Datos de este tema de todas las delegaciones' style='display:block;cursor:pointer;' 
    onclick='TodoMTD();'>Moratorio de Contratos Totales de la Delegacion(MTD)</a>";    
    echo "</th>";


    echo "<th style='background-color:#9f99a8;'>";
    echo "<a title='Haz clic para Traer los Datos de este tema de todas las delegaciones' style='display:block;cursor:pointer;' 
    onclick='TodoMCEI();'>Moratorio Sin Contratos con Errores Identificados (MCEI)</a>";    
    echo "</th>";


    echo "<th rowspan='26' width=40% style='background-color:white;'>";
    echo "<h1 id='titleg'>Graficas</h1>";
    echo "<div id='GraficaSaldos' style='
    width:100%;
    border-radius:9px;
    '></div>";
    echo "<hr>";
    echo "<div id='GraficaMoratorios' style='
    width:100%;
    border-radius:9px;
    '></div>";

    echo "<br><label style='font-size:7pt; color:gray;'>* La gráfica se crea al dar clic en Totales</label>";
    echo "</th>"; // Area de Graficas
    

    while($f = $r -> fetch_array()) {
        $IdDelegacion = $f['IdDelegacion']; $Delegacion = $f['nombre'];
        echo "<tr>";
        
        echo "<td>";
        echo "<a title='Haz clic para Traer los Datos desde esta delegacion' style='display:block;cursor:pointer;' onclick='TodoDelegacion(".$IdDelegacion.");'>".$Delegacion."</a>";
        echo "</td>";


   

        echo "<td>";
            echo "<div id='Div".$IdDelegacion."_STD'>0</div>";      
            echo "<div id='Div".$IdDelegacion."_STDval' style='display:none;'>0</div>";      
        echo "</td>";

    

        echo "<td style='background-color:#d0f0d4;'>";
            echo "<div id='Div".$IdDelegacion."_SCEI'>0</div>";      
            echo "<div id='Div".$IdDelegacion."_SCEIval' style='display:none;'>0</div>";      
        echo "</td>";

        echo "<td>";
            echo "<div id='Div".$IdDelegacion."_MTD'>0</div>";      
            echo "<div id='Div".$IdDelegacion."_MTDval' style='display:none;'>0</div>";      
        echo "</td>";

    


        echo "<td style='background-color:#f0e8f4;'>";
            echo "<div id='Div".$IdDelegacion."_MCEI'>0</div>";      
            echo "<div id='Div".$IdDelegacion."_MCEIval' style='display:none;'>0</div>";      
        echo "</td>";

        // echo "<td></td>";// Area de Grafica


        echo "</tr>";

    }

    echo "<tr style='background-color:#2f2e2e; font-weight: bold;

    '>";
        
    echo "<td>";
    echo "<b style='display:block; cursor:pointer;' title='Haz clic para Calcular' onclick='CalculaTotales(".$IdDelegacion.");'>TOTAL</a>";
    echo "</td>";

    echo "<td style='background-color:#d0f0d8;'>";
        echo "<div id='STD_total'></div>";
        echo "<div id='STD_totalval' style='display:none;'>0</div>";
    echo "</td>";   


    echo "<td style='background-color:#d0f0d8;'>";
        echo "<div id='SCEI_total'></div>";
        echo "<div id='SCEI_totalval' style='display:none;'>0</div>";
    echo "</td>";   

    echo "<td style='background-color:#d0f0d8;'>";
        echo "<div id='MTD_total'></div>";
        echo "<div id='MTD_totalval' style='display:none;'>0</div>";
    echo "</td>";   


    echo "<td style='background-color:#9f99a8;'>";
        echo "<div id='MCEI_total'></div>";
        echo "<div id='MCEI_totalval' style='display:none;'>0</div>";
    echo "</td>";   

    echo "</tr>";


    echo "</table>";
    echo "<div style='
    background-color: #fdfce8;
    padding:10px;
    text-align:left;
    border: 1px solid #ffe67f;
    margin: 10px;
    '><label>
    * Recuerde actualizar los totales, antes de tomar un decicion <br>
    * Los ceros de color rojo suponen una falta de conección con el servidor de donde se obtienen los datos, en esos casos vuelva a intentarlo para obtener el mejor resultado<br>
    * El saldo y moratorios en este reporte está en funcion de la disponibilidad de el acceso a los servidores en cada delegacion <br>
    * Los resultados son a la fecha ".$fecha.".<br>
    </label></div>";

    echo "</div>";






   
} else {
    mensaje("ERROR: No tiene acceso a esta aplicacion","");
}
?>


<script>
function Pesos(Valor,IdDivDestino){
    $.ajax({
        url: "cast.php",
        type: "get",                                
        data: {tipo: "pesos", valor: Valor},
        success: function(data){                                                
            $("#"+IdDivDestino).text(data);

        }
    });        
}


function CalculaTotales(){
    var STD_total = parseInt($("#Div12_STDval").text())  + parseInt($("#Div11_STDval").text())  + parseInt($("#Div7_STDval").text())  + parseInt($("#Div19_STDval").text())  + parseInt($("#Div68_STDval").text())  
    + parseInt($("#Div13_STDval").text())  + parseInt($("#Div17_STDval").text())  + parseInt($("#Div14_STDval").text())  + parseInt($("#Div18_STDval").text())  + parseInt($("#Div20_STDval").text())  
    + parseInt($("#Div1_STDval").text())  + parseInt($("#Div8_STDval").text())  + parseInt($("#Div2_STDval").text())  + parseInt($("#Div3_STDval").text())  + parseInt($("#Div9_STDval").text()) 
    + parseInt($("#Div4_STDval").text())  + parseInt($("#Div15_STDval").text())  + parseInt($("#Div5_STDval").text())  + parseInt($("#Div66_STDval").text())  + parseInt($("#Div10_STDval").text()) 
    + parseInt($("#Div6_STDval").text())  + parseInt($("#Div67_STDval").text())  + parseInt($("#Div65_STDval").text()) ;

    $("#STD_totalval").text(STD_total);
    Pesos($("#STD_totalval").text(),"STD_total");

    
    var SCEI_total = parseInt($("#Div12_SCEIval").text())  + parseInt($("#Div11_SCEIval").text())  + parseInt($("#Div7_SCEIval").text())  + parseInt($("#Div19_SCEIval").text())  + parseInt($("#Div68_SCEIval").text())  
    + parseInt($("#Div13_SCEIval").text())  + parseInt($("#Div17_SCEIval").text())  + parseInt($("#Div14_SCEIval").text())  + parseInt($("#Div18_SCEIval").text())  + parseInt($("#Div20_SCEIval").text())  
    + parseInt($("#Div1_SCEIval").text())  + parseInt($("#Div8_SCEIval").text())  + parseInt($("#Div2_SCEIval").text())  + parseInt($("#Div3_SCEIval").text())  + parseInt($("#Div9_SCEIval").text()) 
    + parseInt($("#Div4_SCEIval").text())  + parseInt($("#Div15_SCEIval").text())  + parseInt($("#Div5_SCEIval").text())  + parseInt($("#Div66_SCEIval").text())  + parseInt($("#Div10_SCEIval").text()) 
    + parseInt($("#Div6_SCEIval").text())  + parseInt($("#Div67_SCEIval").text())  + parseInt($("#Div65_SCEIval").text()) ;


    $("#SCEI_totalval").text(SCEI_total);
    Pesos($("#SCEI_totalval").text(),"SCEI_total");


    var MTD_total = parseInt($("#Div12_MTDval").text())  + parseInt($("#Div11_MTDval").text())  + parseInt($("#Div7_MTDval").text())  + parseInt($("#Div19_MTDval").text())  + parseInt($("#Div68_MTDval").text())  
    + parseInt($("#Div13_MTDval").text())  + parseInt($("#Div17_MTDval").text())  + parseInt($("#Div14_MTDval").text())  + parseInt($("#Div18_MTDval").text())  + parseInt($("#Div20_MTDval").text())  
    + parseInt($("#Div1_MTDval").text())  + parseInt($("#Div8_MTDval").text())  + parseInt($("#Div2_MTDval").text())  + parseInt($("#Div3_MTDval").text())  + parseInt($("#Div9_MTDval").text()) 
    + parseInt($("#Div4_MTDval").text())  + parseInt($("#Div15_MTDval").text())  + parseInt($("#Div5_MTDval").text())  + parseInt($("#Div66_MTDval").text())  + parseInt($("#Div10_MTDval").text()) 
    + parseInt($("#Div6_MTDval").text())  + parseInt($("#Div67_MTDval").text())  + parseInt($("#Div65_MTDval").text()) ;

    $("#MTD_totalval").text(MTD_total);
    Pesos($("#MTD_totalval").text(), "MTD_total");
    



    var MCEI_total = parseInt($("#Div12_MCEIval").text())  + parseInt($("#Div11_MCEIval").text())  + parseInt($("#Div7_MCEIval").text())  + parseInt($("#Div19_MCEIval").text())  + parseInt($("#Div68_MCEIval").text())  
    + parseInt($("#Div13_MCEIval").text())  + parseInt($("#Div17_MCEIval").text())  + parseInt($("#Div14_MCEIval").text())  + parseInt($("#Div18_MCEIval").text())  + parseInt($("#Div20_MCEIval").text())  
    + parseInt($("#Div1_MCEIval").text())  + parseInt($("#Div8_MCEIval").text())  + parseInt($("#Div2_MCEIval").text())  + parseInt($("#Div3_MCEIval").text())  + parseInt($("#Div9_MCEIval").text()) 
    + parseInt($("#Div4_MCEIval").text())  + parseInt($("#Div15_MCEIval").text())  + parseInt($("#Div5_MCEIval").text())  + parseInt($("#Div66_MCEIval").text())  + parseInt($("#Div10_MCEIval").text()) 
    + parseInt($("#Div6_MCEIval").text())  + parseInt($("#Div67_MCEIval").text())  + parseInt($("#Div65_MCEIval").text()) ;

    $("#MCEI_totalval").text(MCEI_total);
    Pesos($("#MCEI_totalval").text(), "MCEI_total");
    
    

    GraficaSaldos(STD_total,SCEI_total);
    GraficaMoratorios(MTD_total,MCEI_total);
    $('#titleg').hide();
    
    $.toast({
        heading: 'Success',
        text: 'Tenga en cuenta que si hay ceros rojos, ha faltado información de una delegación. La Gráfica y los Totales no estan completos',
        showHideTransition: 'slide',
        icon: 'success'
    })


}

function GraficaSaldos(SaldoTotal, SaldoSeguro){
      google.charts.load("current", {packages:["corechart"]});
      google.charts.setOnLoadCallback(drawChart);
      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['Concepto', 'Cantidad'],
          ['Saldo Total',     SaldoTotal],
          ['Saldo Sano o Seguro',      SaldoSeguro]          
        ]);

        var options = {
          title: 'Grafica de Saldos',
          pieHole: 0.4,
          legend: {position: 'bottom',textStyle: {color: 'gray', fontSize: 8}}
        };

        var chart = new google.visualization.PieChart(document.getElementById('GraficaSaldos'));
        chart.draw(data, options);
      }
}


function GraficaMoratorios(MoratorioTotal, MoratorioSeguro){
      google.charts.load("current", {packages:["corechart"]});
      google.charts.setOnLoadCallback(drawChart);
      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['Concepto', 'Cantidad'],
          ['Moratorio Total',     MoratorioTotal],
          ['Moratorio Sano o Seguro',      MoratorioSeguro]          
        ]);

        var options = {
          title: 'Grafica de Moratorios',
          pieHole: 0.4,
          legend: {position: 'bottom',textStyle: {color: 'gray', fontSize: 8}}
        };

        var chart = new google.visualization.PieChart(document.getElementById('GraficaMoratorios'));
        chart.draw(data, options);
      }
}


function STD(IdDelegacion){
    $("#Div" + IdDelegacion + "_STD").html("<img src=img/loader_bar.gif  style=width:12px> ");
    $.ajax({
        url: "saldos_dat1.php",
        type: "post",                                
        data: {IdDel: IdDelegacion, Nitavu: <?php echo $nitavu; ?>},
        success: function(data){                                    
        $("#Div"+IdDelegacion+"_STD").html(data);                                    
        }
});
}



function SCEI(IdDelegacion){
    $("#Div" + IdDelegacion + "_SCEI").html("<img src=img/loader_bar.gif  style=width:12px> ");
    $.ajax({
        url: "monitor_sanidad_dat8.php",
        type: "post",                                
        data: {IdDel: IdDelegacion, Nitavu: <?php echo $nitavu; ?>},
        success: function(data){                                    
        $("#Div"+IdDelegacion+"_SCEI").html(data);                                    
        }
});
}

function MTD(IdDelegacion){
    $("#Div" + IdDelegacion + "_MTD").html("<img src=img/loader_bar.gif  style=width:12px> ");
    $.ajax({
        url: "saldos_dat2.php",
        type: "post",                                
        data: {IdDel: IdDelegacion, Nitavu: <?php echo $nitavu; ?>},
        success: function(data){                                    
        $("#Div"+IdDelegacion+"_MTD").html(data);                                    
        }
});
}

function MCEI(IdDelegacion){
    $("#Div" + IdDelegacion + "_MCEI").html("<img src=img/loader_bar.gif  style=width:12px> ");
    $.ajax({
        url: "monitor_sanidad_dat9.php",
        type: "post",                                
        data: {IdDel: IdDelegacion, Nitavu: <?php echo $nitavu; ?>},
        success: function(data){                                    
        $("#Div"+IdDelegacion+"_MCEI").html(data);                                    
        }
});
}


function TodoDelegacion(IdDelegacion){
    STD(IdDelegacion);
    SCEI(IdDelegacion);
    MTD(IdDelegacion);
    MCEI(IdDelegacion);
}

function TodoSTD(){
       
       STD(12);
       STD(11);
       STD(7);
       STD(19);
       STD(68);
       STD(13);
       STD(17);
       STD(14);
       STD(18);
       STD(20);
       STD(1);
       STD(8);
       STD(2);
       STD(3);
       STD(9);
       STD(4);
       STD(15);
       STD(5);
       STD(66);
       STD(10);
       STD(6);
       STD(67);
       STD(65);
   
   }



function TodoSCEI(){
       
       SCEI(12);
       SCEI(11);
       SCEI(7);
       SCEI(19);
       SCEI(68);
       SCEI(13);
       SCEI(17);
       SCEI(14);
       SCEI(18);
       SCEI(20);
       SCEI(1);
       SCEI(8);
       SCEI(2);
       SCEI(3);
       SCEI(9);
       SCEI(4);
       SCEI(15);
       SCEI(5);
       SCEI(66);
       SCEI(10);
       SCEI(6);
       SCEI(67);
       SCEI(65);
   
   }

   
function TodoMTD(){
       
       MTD(12);
       MTD(11);
       MTD(7);
       MTD(19);
       MTD(68);
       MTD(13);
       MTD(17);
       MTD(14);
       MTD(18);
       MTD(20);
       MTD(1);
       MTD(8);
       MTD(2);
       MTD(3);
       MTD(9);
       MTD(4);
       MTD(15);
       MTD(5);
       MTD(66);
       MTD(10);
       MTD(6);
       MTD(67);
       MTD(65);
   
   }


   
function TodoMCEI(){
       
       MCEI(12);
       MCEI(11);
       MCEI(7);
       MCEI(19);
       MCEI(68);
       MCEI(13);
       MCEI(17);
       MCEI(14);
       MCEI(18);
       MCEI(20);
       MCEI(1);
       MCEI(8);
       MCEI(2);
       MCEI(3);
       MCEI(9);
       MCEI(4);
       MCEI(15);
       MCEI(5);
       MCEI(66);
       MCEI(10);
       MCEI(6);
       MCEI(67);
       MCEI(65);
   
   }

   

function Todo(){
    NPush('Este proceso puede tardar...','Plataforma ITAVU');
    TodoSTD();
    TodoSCEI();
    TodoMTD();
    TodoMCEI();

}

</script>

<?php
include("lib/body_footer.php");
?>

