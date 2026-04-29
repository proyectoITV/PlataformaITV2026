<?php
include ("lib/body_head.php");// Estructura de Plataforma
include ("lib/body_menu.php"); //interfaz de menus
require("lib/curp_fun.php");
require("lib/graficas_fun.php");


$id_aplicacion ="curp"; 

    //Codigo de la Aplicacion

    echo "<div id='_curps' style='
    background-color:white;
    width:40%; height:400px;
    display:inline-block;
    border-radius:5px;
    margin:5px;padding:10px;
    '>";
    echo "<h4>Gestion de Tabla _curps</h4>";

    echo "<table class='tabla'><tr style='font-size:12pt;'>";
    echo "<td>";
        echo "Total: <b>".VCurps_total()."</b><br>";
        
    echo "</td>";
    

    echo "<td>";
    echo "<div id='CurpsConsultados' style=''>Consultados: <b>".VCurps_checks()."</b><br></div>";
    
    echo "</tr>";

    // $QueryG = "
    // select DISTINCT Departamento
    // ,(select count(*) from DashBoard_problemas where Departamento = a.Departamento and status=0 and fecha=curdate()) as Actividad
    // from DashBoard_problemas a where fecha=curdate() 

    // ";
    // $rF= $conexion -> query($QueryG);    
    // $Datas = 0; $Labels="";
    // while($Fr = $rF -> fetch_array()) {   
    //     $Datas.= $Fr['Actividad'].", ";
    //     $Labels.="'".$Fr['Departamento']."',";
    // }
    // unset($rf);unset($Fr);
    // $Datas = substr($Datas, 0, -1); //quita la ultima coma.
    // $Labels = substr($Labels, 0, -1); //quita la ultima coma.

    echo "</td><td>";
    echo "<div id='LaGrafica' style='width:200px; height:200px; display:inline-block;'>";
    $TotaldeCurps = VCurps_total();
    $TotalChecado = VCurps_checks();
    
    $Restantes = $TotaldeCurps - $TotalChecado;

    $Labels="'Por Verificar','Verificados'";
    $Datas="".$Restantes.",".$TotalChecado;

    echo '<div style="width:200px; height:200px;" class="Graficas" >';    
    GraficaPie($Labels, $Datas, "Concentracion");
    echo '</div>';

    echo '</div>';
    echo "</td><td align=center>";

    echo "<button id='btnVerificar' class='btn btn-primary' onclick='Verificar();'>Verificacion</button><br>";
    // echo "<button id='btnCancelar' class='btn btn-danger' onclick='Cancel();'>Detener Verificacion</button>";

    echo "<div id='Limites' style='margin-top:50px; font-size:14pt;'></div>";
    echo "</td></tr></table>";

    echo "</div>";
    


    
    

?>
<script>
function CurpR1(){		                    
    $('#progressbar').show();
    LoaderDiv('btnVerificar');
    $.ajax({
    url: "curp_data2.php",
    type: "post",        
    data: {},
    success: function(data){                
        $("#CurpsConsultados").html(data+"");     
        $("#btnVerificar").html("Verificar");    
        $('#progressbar').hide();
    }
    });

            
}


function CurpR2(){		                    
    $('#progressbar').show();
    LoaderDiv('btnVerificar');
    $.ajax({
    url: "curp_data1.php",
    type: "post",        
    data: {},
    success: function(data){                
        $("#LaGrafica").html(data+"");     
        $("#btnVerificar").html("Verificar");    
        $("#progressbar").hide();
    }
    });

            
}

function Reload(){
    CurpR1();
    CurpR2();

}

function CurpGo(){		                    
    $('#progressbar').show();
    LoaderDiv('btnVerificar');
    $.ajax({
    url: "curp_data_go.php",
    type: "post",        
    data: {},
    success: function(data){                
        $("#R").html(data+"");     
        $("#btnVerificar").html("Verificar");    
        $("#progressbar").hide();

        Verificar();
    }
    });

            
}

function Cancel(){		                    
    $.ajax.abort();
    $("#btnVerificar").html("Verificar");   
    alert('Proceso Cancelado');
    
}
function Verificar(){
    CurpGo();
}

</script>
<?php
include ("./lib/body_footer.php"); //Cierre de Estructura de la Plaforma
?>