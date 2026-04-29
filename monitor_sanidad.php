<?php
include("lib/body_head.php");
include("lib/body_menu.php");
$id_aplicacion ="msan"; //Id de la aplicacion a cargar
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
    
    echo "<th>";
    echo "<a title='Haz clic para Traer los Datos de este tema de todas las delegaciones' style='display:block;cursor:pointer;' 
    onclick='TodoCTD();'>Cantidad Total de Contratos de la Delegacion (CTD)</a>";    
    echo "</th>";


    echo "<th>";
    echo "<a title='Haz clic para Traer los Datos de este tema de todas las delegaciones' style='display:block;cursor:pointer;' 
    onclick='TodoCFD();'>Contratos Foraneos de la Delegacion (CFD)</a>";    
    echo "</th>";

    
    echo "<th>";
    echo "<a title='Haz clic para Traer los Datos de este tema de todas las delegaciones' style='display:block;cursor:pointer;' 
    onclick='TodoCED();'>Contratos con Errores de la Delegacion (CED)</a>";    
    echo "</th>";


        
    echo "<th>";
    echo "<a title='Haz clic para Traer los Datos de este tema de todas las delegaciones' style='display:block;cursor:pointer;' 
    onclick='TodoCEF();'>Contratos con Errores Foraneos  (CEF)</a>";    
    echo "</th>";


    echo "<th>";
    echo "<a title='Haz clic para Traer los Datos de este tema de todas las delegaciones' style='display:block;cursor:pointer;' 
    onclick='TodoCEC();'>Contratos con Errores Cancelados  (CEC)</a>";    
    echo "</th>";

    
    echo "<th style='background-color:#a2b3a4;'>";
    echo "<a title='Haz clic para Traer los Datos de este tema de todas las delegaciones' style='display:block;cursor:pointer;' 
    onclick='TodoCEI();'>Contratos sin Errores Identificados (CEI)</a>";    
    echo "</th>";

    echo "<th style='background-color:#a2b3a4;'>";
    echo "<a title='Haz clic para Traer los Datos de este tema de todas las delegaciones' style='display:block;cursor:pointer;' 
    onclick='TodoCIS();'>Contratos Identificados Saneados (CIS)</a>";    
    echo "</th>";

    echo "<th style='background-color:#a2b3a4;'>";
    echo "<a title='Haz clic para Traer los Datos de este tema de todas las delegaciones' style='display:block;cursor:pointer;' 
    onclick='TodoSCEI();'>SaldoNeto CEI (SCEI)</a>";    
    echo "</th>";

    echo "<th style='background-color:#9f99a8;'>";
    echo "<a title='Haz clic para Traer los Datos de este tema de todas las delegaciones' style='display:block;cursor:pointer;' 
    onclick='TodoMCEI();'>Moratorio CEI (MCEI)</a>";    
    echo "</th>";

    while($f = $r -> fetch_array()) {
        $IdDelegacion = $f['IdDelegacion']; $Delegacion = $f['nombre'];
        echo "<tr>";
        
        echo "<td>";
        echo "<a title='Haz clic para Traer los Datos desde esta delegacion' style='display:block;cursor:pointer;' onclick='TodoDelegacion(".$IdDelegacion.");'>".$Delegacion."</a>";
        echo "</td>";


        echo "<td>";
            echo "<div id='Div".$IdDelegacion."_CTD'>0</div>";      
        echo "</td>";

        echo "<td>";
            echo "<div id='Div".$IdDelegacion."_CFD'>0</div>";      
        echo "</td>";

        echo "<td>";
            echo "<div id='Div".$IdDelegacion."_CED'>0</div>";      
        echo "</td>";


        echo "<td>";
            echo "<div id='Div".$IdDelegacion."_CEF'>0</div>";      
        echo "</td>";

        echo "<td>";
            echo "<div id='Div".$IdDelegacion."_CEC'>0</div>";      
        echo "</td>";

        echo "<td style='background-color:d0f0d4;'>";
            echo "<div id='Div".$IdDelegacion."_CEI'>0</div>";      
        echo "</td>";

        echo "<td style='background-color:#abeea7;'>";
            echo "<div id='Div".$IdDelegacion."_CIS'>0</div>";      
        echo "</td>";

        echo "<td style='background-color:#d0f0d4;'>";
            echo "<div id='Div".$IdDelegacion."_SCEI'>0</div>";      
            echo "<div id='Div".$IdDelegacion."_SCEIval' style='display:none;'>0</div>";      
        echo "</td>";


        echo "<td style='background-color:#f0e8f4;'>";
            echo "<div id='Div".$IdDelegacion."_MCEI'>0</div>";      
            echo "<div id='Div".$IdDelegacion."_MCEIval' style='display:none;'>0</div>";      
        echo "</td>";



        echo "</tr>";

    }

    echo "<tr style='background-color:#2f2e2e; font-weight: bold;

    '>";
        
    echo "<td>";
    echo "<b style='display:block; cursor:pointer;' title='Haz clic para Calcular' onclick='CalculaTotales(".$IdDelegacion.");'>TOTAL</a>";
    echo "</td>";


    echo "<td>";
        echo "<div id='CTD_total'></div>";
  
    echo "</td>";

    echo "<td>";
        echo "<div id='CFD_total'></div>";
    echo "</td>";

    echo "<td>";
        echo "<div id='CED_total'></div>";
    echo "</td>";

    echo "<td>";
        echo "<div id='CEF_total'></div>";
    echo "</td>";

    echo "<td>";
        echo "<div id='CEC_total'></div>";
    echo "</td>";

    echo "<td style='background-color:#d0f0d4;'>";
        echo "<div id='CEI_total'></div>";
    echo "</td>";

    echo "<td style='background-color:#d0f0d8;'>";
        echo "<div id='CIS_total'></div>";
    echo "</td>";   

    echo "<td style='background-color:#d0f0d8;'>";
        echo "<div id='SCEI_total'></div>";
        echo "<div id='SCEI_totalval' style='display:none;'></div>";
    echo "</td>";   


    echo "<td style='background-color:#9f99a8;'>";
        echo "<div id='MCEI_total'></div>";
        echo "<div id='MCEI_totalval' style='display:none;'></div>";
    echo "</td>";   

    echo "</tr>";


    echo "</table>";
    echo "<label>*Recuerde actualizar los totales, antes de tomar un decicion <br>
    * Los ceros de color rojo suponen una falta de conección con el servidor de donde se obtienen los datos, en esos casos vuelva a intentarlo para obtener el mejor resultado</label>";
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
    var CTD_total = parseInt($("#Div12_CTD").text())  + parseInt($("#Div11_CTD").text())  + parseInt($("#Div7_CTD").text())  + parseInt($("#Div19_CTD").text())  + parseInt($("#Div68_CTD").text())  
    + parseInt($("#Div13_CTD").text())  + parseInt($("#Div17_CTD").text())  + parseInt($("#Div14_CTD").text())  + parseInt($("#Div18_CTD").text())  + parseInt($("#Div20_CTD").text())  
    + parseInt($("#Div1_CTD").text())  + parseInt($("#Div8_CTD").text())  + parseInt($("#Div2_CTD").text())  + parseInt($("#Div3_CTD").text())  + parseInt($("#Div9_CTD").text()) 
    + parseInt($("#Div4_CTD").text())  + parseInt($("#Div15_CTD").text())  + parseInt($("#Div5_CTD").text())  + parseInt($("#Div66_CTD").text())  + parseInt($("#Div10_CTD").text()) 
    + parseInt($("#Div6_CTD").text())  + parseInt($("#Div67_CTD").text())  + parseInt($("#Div65_CTD").text()) ;

    $("#CTD_total").text(CTD_total);
    //alert(CTD_total);


    var CFD_total = parseInt($("#Div12_CFD").text())  + parseInt($("#Div11_CFD").text())  + parseInt($("#Div7_CFD").text())  + parseInt($("#Div19_CFD").text())  + parseInt($("#Div68_CFD").text())  
    + parseInt($("#Div13_CFD").text())  + parseInt($("#Div17_CFD").text())  + parseInt($("#Div14_CFD").text())  + parseInt($("#Div18_CFD").text())  + parseInt($("#Div20_CFD").text())  
    + parseInt($("#Div1_CFD").text())  + parseInt($("#Div8_CFD").text())  + parseInt($("#Div2_CFD").text())  + parseInt($("#Div3_CFD").text())  + parseInt($("#Div9_CFD").text()) 
    + parseInt($("#Div4_CFD").text())  + parseInt($("#Div15_CFD").text())  + parseInt($("#Div5_CFD").text())  + parseInt($("#Div66_CFD").text())  + parseInt($("#Div10_CFD").text()) 
    + parseInt($("#Div6_CFD").text())  + parseInt($("#Div67_CFD").text())  + parseInt($("#Div65_CFD").text()) ;

    $("#CFD_total").text(CFD_total);


    var CED_total = parseInt($("#Div12_CED").text())  + parseInt($("#Div11_CED").text())  + parseInt($("#Div7_CED").text())  + parseInt($("#Div19_CED").text())  + parseInt($("#Div68_CED").text())  
    + parseInt($("#Div13_CED").text())  + parseInt($("#Div17_CED").text())  + parseInt($("#Div14_CED").text())  + parseInt($("#Div18_CED").text())  + parseInt($("#Div20_CED").text())  
    + parseInt($("#Div1_CED").text())  + parseInt($("#Div8_CED").text())  + parseInt($("#Div2_CED").text())  + parseInt($("#Div3_CED").text())  + parseInt($("#Div9_CED").text()) 
    + parseInt($("#Div4_CED").text())  + parseInt($("#Div15_CED").text())  + parseInt($("#Div5_CED").text())  + parseInt($("#Div66_CED").text())  + parseInt($("#Div10_CED").text()) 
    + parseInt($("#Div6_CED").text())  + parseInt($("#Div67_CED").text())  + parseInt($("#Div65_CED").text()) ;

    $("#CED_total").text(CED_total);

    var CEF_total = parseInt($("#Div12_CEF").text())  + parseInt($("#Div11_CEF").text())  + parseInt($("#Div7_CEF").text())  + parseInt($("#Div19_CEF").text())  + parseInt($("#Div68_CEF").text())  
    + parseInt($("#Div13_CEF").text())  + parseInt($("#Div17_CEF").text())  + parseInt($("#Div14_CEF").text())  + parseInt($("#Div18_CEF").text())  + parseInt($("#Div20_CEF").text())  
    + parseInt($("#Div1_CEF").text())  + parseInt($("#Div8_CEF").text())  + parseInt($("#Div2_CEF").text())  + parseInt($("#Div3_CEF").text())  + parseInt($("#Div9_CEF").text()) 
    + parseInt($("#Div4_CEF").text())  + parseInt($("#Div15_CEF").text())  + parseInt($("#Div5_CEF").text())  + parseInt($("#Div66_CEF").text())  + parseInt($("#Div10_CEF").text()) 
    + parseInt($("#Div6_CEF").text())  + parseInt($("#Div67_CEF").text())  + parseInt($("#Div65_CEF").text()) ;

    $("#CEF_total").text(CEF_total);

    var CEC_total = parseInt($("#Div12_CEC").text())  + parseInt($("#Div11_CEC").text())  + parseInt($("#Div7_CEC").text())  + parseInt($("#Div19_CEC").text())  + parseInt($("#Div68_CEC").text())  
    + parseInt($("#Div13_CEC").text())  + parseInt($("#Div17_CEC").text())  + parseInt($("#Div14_CEC").text())  + parseInt($("#Div18_CEC").text())  + parseInt($("#Div20_CEC").text())  
    + parseInt($("#Div1_CEC").text())  + parseInt($("#Div8_CEC").text())  + parseInt($("#Div2_CEC").text())  + parseInt($("#Div3_CEC").text())  + parseInt($("#Div9_CEC").text()) 
    + parseInt($("#Div4_CEC").text())  + parseInt($("#Div15_CEC").text())  + parseInt($("#Div5_CEC").text())  + parseInt($("#Div66_CEC").text())  + parseInt($("#Div10_CEC").text()) 
    + parseInt($("#Div6_CEC").text())  + parseInt($("#Div67_CEC").text())  + parseInt($("#Div65_CEC").text()) ;

    $("#CEC_total").text(CEC_total);


    var CEI_total = parseInt($("#Div12_CEI").text())  + parseInt($("#Div11_CEI").text())  + parseInt($("#Div7_CEI").text())  + parseInt($("#Div19_CEI").text())  + parseInt($("#Div68_CEI").text())  
    + parseInt($("#Div13_CEI").text())  + parseInt($("#Div17_CEI").text())  + parseInt($("#Div14_CEI").text())  + parseInt($("#Div18_CEI").text())  + parseInt($("#Div20_CEI").text())  
    + parseInt($("#Div1_CEI").text())  + parseInt($("#Div8_CEI").text())  + parseInt($("#Div2_CEI").text())  + parseInt($("#Div3_CEI").text())  + parseInt($("#Div9_CEI").text()) 
    + parseInt($("#Div4_CEI").text())  + parseInt($("#Div15_CEI").text())  + parseInt($("#Div5_CEI").text())  + parseInt($("#Div66_CEI").text())  + parseInt($("#Div10_CEI").text()) 
    + parseInt($("#Div6_CEI").text())  + parseInt($("#Div67_CEI").text())  + parseInt($("#Div65_CEI").text()) ;

    $("#CEI_total").text(CEI_total);


    var CIS_total = parseInt($("#Div12_CIS").text())  + parseInt($("#Div11_CIS").text())  + parseInt($("#Div7_CIS").text())  + parseInt($("#Div19_CIS").text())  + parseInt($("#Div68_CIS").text())  
    + parseInt($("#Div13_CIS").text())  + parseInt($("#Div17_CIS").text())  + parseInt($("#Div14_CIS").text())  + parseInt($("#Div18_CIS").text())  + parseInt($("#Div20_CIS").text())  
    + parseInt($("#Div1_CIS").text())  + parseInt($("#Div8_CIS").text())  + parseInt($("#Div2_CIS").text())  + parseInt($("#Div3_CIS").text())  + parseInt($("#Div9_CIS").text()) 
    + parseInt($("#Div4_CIS").text())  + parseInt($("#Div15_CIS").text())  + parseInt($("#Div5_CIS").text())  + parseInt($("#Div66_CIS").text())  + parseInt($("#Div10_CIS").text()) 
    + parseInt($("#Div6_CIS").text())  + parseInt($("#Div67_CIS").text())  + parseInt($("#Div65_CIS").text()) ;

    $("#CIS_total").text(CIS_total);


    
    var SCEI_total = parseInt($("#Div12_SCEIval").text())  + parseInt($("#Div11_SCEIval").text())  + parseInt($("#Div7_SCEIval").text())  + parseInt($("#Div19_SCEIval").text())  + parseInt($("#Div68_SCEIval").text())  
    + parseInt($("#Div13_SCEIval").text())  + parseInt($("#Div17_SCEIval").text())  + parseInt($("#Div14_SCEIval").text())  + parseInt($("#Div18_SCEIval").text())  + parseInt($("#Div20_SCEIval").text())  
    + parseInt($("#Div1_SCEIval").text())  + parseInt($("#Div8_SCEIval").text())  + parseInt($("#Div2_SCEIval").text())  + parseInt($("#Div3_SCEIval").text())  + parseInt($("#Div9_SCEIval").text()) 
    + parseInt($("#Div4_SCEIval").text())  + parseInt($("#Div15_SCEIval").text())  + parseInt($("#Div5_SCEIval").text())  + parseInt($("#Div66_SCEIval").text())  + parseInt($("#Div10_SCEIval").text()) 
    + parseInt($("#Div6_SCEIval").text())  + parseInt($("#Div67_SCEIval").text())  + parseInt($("#Div65_SCEIval").text()) ;

    $("#SCEI_totalval").text(SCEI_total);
    Pesos($("#SCEI_totalval").text(),"SCEI_total")



    var MCEI_total = parseInt($("#Div12_MCEIval").text())  + parseInt($("#Div11_MCEIval").text())  + parseInt($("#Div7_MCEIval").text())  + parseInt($("#Div19_MCEIval").text())  + parseInt($("#Div68_MCEIval").text())  
    + parseInt($("#Div13_MCEIval").text())  + parseInt($("#Div17_MCEIval").text())  + parseInt($("#Div14_MCEIval").text())  + parseInt($("#Div18_MCEIval").text())  + parseInt($("#Div20_MCEIval").text())  
    + parseInt($("#Div1_MCEIval").text())  + parseInt($("#Div8_MCEIval").text())  + parseInt($("#Div2_MCEIval").text())  + parseInt($("#Div3_MCEIval").text())  + parseInt($("#Div9_MCEIval").text()) 
    + parseInt($("#Div4_MCEIval").text())  + parseInt($("#Div15_MCEIval").text())  + parseInt($("#Div5_MCEIval").text())  + parseInt($("#Div66_MCEIval").text())  + parseInt($("#Div10_MCEIval").text()) 
    + parseInt($("#Div6_MCEIval").text())  + parseInt($("#Div67_MCEIval").text())  + parseInt($("#Div65_MCEIval").text()) ;

    $("#MCEI_totalval").text(MCEI_total);
    Pesos($("#MCEI_totalval").text(), "MCEI_total");
    
    


}



function CTD(IdDelegacion){
    $("#Div" + IdDelegacion + "_CTD").html("<img src=img/loader_bar.gif  style=width:12px> ");
    $.ajax({
        url: "monitor_sanidad_dat1.php",
        type: "post",                                
        data: {IdDel: IdDelegacion, Nitavu: <?php echo $nitavu; ?>},
        success: function(data){                                    
        $("#Div"+IdDelegacion+"_CTD").html(data);                                    
        }
});
    
}

function CFD(IdDelegacion){
    $("#Div" + IdDelegacion + "_CFD").html("<img src=img/loader_bar.gif  style=width:12px> ");
    $.ajax({
        url: "monitor_sanidad_dat2.php",
        type: "post",                                
        data: {IdDel: IdDelegacion, Nitavu: <?php echo $nitavu; ?>},
        success: function(data){                                    
        $("#Div"+IdDelegacion+"_CFD").html(data);                                    
        }
});
}

function CED(IdDelegacion){
    $("#Div" + IdDelegacion + "_CED").html("<img src=img/loader_bar.gif  style=width:12px> ");
    $.ajax({
        url: "monitor_sanidad_dat3.php",
        type: "post",                                
        data: {IdDel: IdDelegacion, Nitavu: <?php echo $nitavu; ?>},
        success: function(data){                                    
        $("#Div"+IdDelegacion+"_CED").html(data);                                    
        }
});
}

function CEF(IdDelegacion){
    $("#Div" + IdDelegacion + "_CEF").html("<img src=img/loader_bar.gif  style=width:12px> ");
    $.ajax({
        url: "monitor_sanidad_dat4.php",
        type: "post",                                
        data: {IdDel: IdDelegacion, Nitavu: <?php echo $nitavu; ?>},
        success: function(data){                                    
        $("#Div"+IdDelegacion+"_CEF").html(data);                                    
        }
});
}

function CEC(IdDelegacion){
    $("#Div" + IdDelegacion + "_CEC").html("<img src=img/loader_bar.gif  style=width:12px> ");
    $.ajax({
        url: "monitor_sanidad_dat5.php",
        type: "post",                                
        data: {IdDel: IdDelegacion, Nitavu: <?php echo $nitavu; ?>},
        success: function(data){                                    
        $("#Div"+IdDelegacion+"_CEC").html(data);                                    
        }
});
}

function CEI(IdDelegacion){
    $("#Div" + IdDelegacion + "_CEI").html("<img src=img/loader_bar.gif  style=width:12px> ");
    $.ajax({
        url: "monitor_sanidad_dat6.php",
        type: "post",                                
        data: {IdDel: IdDelegacion, Nitavu: <?php echo $nitavu; ?>},
        success: function(data){                                    
        $("#Div"+IdDelegacion+"_CEI").html(data);                                    
        }
});
}

function CIS(IdDelegacion){
    $("#Div" + IdDelegacion + "_CIS").html("<img src=img/loader_bar.gif  style=width:12px> ");
    $.ajax({
        url: "monitor_sanidad_dat7.php",
        type: "post",                                
        data: {IdDel: IdDelegacion, Nitavu: <?php echo $nitavu; ?>},
        success: function(data){                                    
        $("#Div"+IdDelegacion+"_CIS").html(data);                                    
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
    CTD(IdDelegacion);
    CFD(IdDelegacion);
    CED(IdDelegacion);
    CEF(IdDelegacion);
    CEC(IdDelegacion);
    CEI(IdDelegacion);
    CIS(IdDelegacion);
    SCEI(IdDelegacion);
    MCEI(IdDelegacion);
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


function TodoCIS(){
       
       CIS(12);
       CIS(11);
       CIS(7);
       CIS(19);
       CIS(68);
       CIS(13);
       CIS(17);
       CIS(14);
       CIS(18);
       CIS(20);
       CIS(1);
       CIS(8);
       CIS(2);
       CIS(3);
       CIS(9);
       CIS(4);
       CIS(15);
       CIS(5);
       CIS(66);
       CIS(10);
       CIS(6);
       CIS(67);
       CIS(65);
   
   }


function TodoCEI(){
       
       CEI(12);
       CEI(11);
       CEI(7);
       CEI(19);
       CEI(68);
       CEI(13);
       CEI(17);
       CEI(14);
       CEI(18);
       CEI(20);
       CEI(1);
       CEI(8);
       CEI(2);
       CEI(3);
       CEI(9);
       CEI(4);
       CEI(15);
       CEI(5);
       CEI(66);
       CEI(10);
       CEI(6);
       CEI(67);
       CEI(65);
   
   }



function TodoCEC(){
       
       CEC(12);
       CEC(11);
       CEC(7);
       CEC(19);
       CEC(68);
       CEC(13);
       CEC(17);
       CEC(14);
       CEC(18);
       CEC(20);
       CEC(1);
       CEC(8);
       CEC(2);
       CEC(3);
       CEC(9);
       CEC(4);
       CEC(15);
       CEC(5);
       CEC(66);
       CEC(10);
       CEC(6);
       CEC(67);
       CEC(65);
   
   }


function TodoCEF(){
       
       CEF(12);
       CEF(11);
       CEF(7);
       CEF(19);
       CEF(68);
       CEF(13);
       CEF(17);
       CEF(14);
       CEF(18);
       CEF(20);
       CEF(1);
       CEF(8);
       CEF(2);
       CEF(3);
       CEF(9);
       CEF(4);
       CEF(15);
       CEF(5);
       CEF(66);
       CEF(10);
       CEF(6);
       CEF(67);
       CEF(65);
   
   }



function TodoCED(){
       
       CED(12);
       CED(11);
       CED(7);
       CED(19);
       CED(68);
       CED(13);
       CED(17);
       CED(14);
       CED(18);
       CED(20);
       CED(1);
       CED(8);
       CED(2);
       CED(3);
       CED(9);
       CED(4);
       CED(15);
       CED(5);
       CED(66);
       CED(10);
       CED(6);
       CED(67);
       CED(65);
   
   }


function TodoCTD(){
       
    CTD(12);
    CTD(11);
    CTD(7);
    CTD(19);
    CTD(68);
    CTD(13);
    CTD(17);
    CTD(14);
    CTD(18);
    CTD(20);
    CTD(1);
    CTD(8);
    CTD(2);
    CTD(3);
    CTD(9);
    CTD(4);
    CTD(15);
    CTD(5);
    CTD(66);
    CTD(10);
    CTD(6);
    CTD(67);
    CTD(65);

}

function TodoCFD(){
       
       CFD(12);
       CFD(11);
       CFD(7);
       CFD(19);
       CFD(68);
       CFD(13);
       CFD(17);
       CFD(14);
       CFD(18);
       CFD(20);
       CFD(1);
       CFD(8);
       CFD(2);
       CFD(3);
       CFD(9);
       CFD(4);
       CFD(15);
       CFD(5);
       CFD(66);
       CFD(10);
       CFD(6);
       CFD(67);
       CFD(65);
   
   }
   

function Todo(){
    NPush('Este proceso puede tardar...','Plataforma ITAVU');
    TodoCFD();
    TodoCTD();
    TodoCED();
    TodoCEF();
    TodoCEC();
    TodoCEI();
    TodoCIS();
    TodoSCEI();
    TodoMCEI();

}

</script>

<?php
include("lib/body_footer.php");
?>

