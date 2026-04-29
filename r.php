<?php
    include ("head.php");
    include ("header.php");
    //include("components.php")
?>

<script>
    function CargaReporte(Post,id_rep){
        if (Post=1){
            
            var1_str = $('#var1_str').val();
            var2_str = $('#var2_str').val();
            var3_str = $('#var3_str').val();

            $('#PreLoader').show();
                    $.ajax({
                        url: 'r_data.php',
                        type: 'post',
                        data: {
                            var1_str:var1_str,
                            var2_str:var2_str,
                            var3_str:var3_str,
                            id_rep:id_rep,
                            Post:Post
                            
                        },
                        success: function(data) {
                            $('#DivReporte').html(data);
                            $('#PreLoader').hide();
                            $('#FormVar').hide();
                            $('#DivReporte').show();
                        }
                    });
        }
        else {
            $('#PreLoader').show();
                    $.ajax({
                        url: 'r_data.php',
                        type: 'post',
                        data: {                    
                            id_rep:id_rep,
                            Post:Post
                            
                        },
                        
                        success: function(data) {
                            console.log("Respuesta del servidor (data):", data);
                            $('#DivReporte').html(data);
                            $('#PreLoader').hide();
                            $('#FormVar').hide();
                            $('#DivReporte').show();
                        }
                    });
        }
    }
</script>


<?php
//*$id_rep = VarClean($_GET['id']);
//*$Tipo = ReporteTipo($id_rep); // $Tipo = 1; // 0 = html, 1= DataTable, 2 = PDF, 3 = Excel, 4 = Word
$id_rep = $_GET['id'];
$Tipo = ReporteTipo2($id_rep); // $Tipo = 1; // 0 = html, 1= DataTable, 2 = PDF, 3 = Excel, 4 = Word
// var_dump($Tipo);
//$nitavu=1308;
if (PermisoReporte_Ver2($nitavu,$id_rep)==TRUE){
    //*if (PermisoReporte_Ver($nitavu,$id_rep)==TRUE){

echo '<div class="row" style="margin:0px;">';
$ClaseDiv  = "ContenedorDeReporte"; $ClaseTabla = "";
    echo "<div id='C' style='
    width:100%;
    text-align:center;
    
    ' class='col-12'

    >";
    echo "<div id='DivReporte' 
    style='
    
    margin: 0px;
    text-align: center;
    width:100%;
    ' 

    ></div>";
    //1 detectar si hay interaccion de variables
    $sql = "select * from reportes where id_rep='".$id_rep."'";    
    //*$Reportes = $db0->query($sql);    
    $Reportes = $conexion->query($sql);    
    if ($conexion->query($sql) == TRUE){
    //*if ($db0->query($sql) == TRUE){    
        if($Rep = $Reportes -> fetch_array())
        {
            if ($Rep['var1'] == 1 || $Rep['var2'] == 1  || $Rep['var2'] == 1     ) {
               
               
                echo "<form id='FormVar' action='r.php?id=".$id_rep."' method='POST' style='
                width: 100%;
                padding: 10px;
                background-color: #ffffff5c;
                margin: 7px;
                border-radius: 8px;

                '>";
                echo "<h3>".$Rep['rep_name']."</h3>";
                echo "<cite>".$Rep['rep_description']."</cite>";
                echo "<p style='
                font-size: 10pt;
                font-weight: bold;
                text-align: left;
                '>Este Reporte Requiere los siguientes datos:</p>";


                


                if ($Rep['var1']==1){
                    echo "<div class='Elemento'>";                   
                    echo "<label>".$Rep['var1_label']."</label>";
                    if ($Rep['var1_type']=="option"){
                        echo "<select name='var1_str'  id='var1_str' class='form-control' required>";
                        echo var_select($id_rep,1);                        
                        echo "</select>";
                    } else {
                        echo "<input class='form-control' type='".$Rep['var1_type']."' value='' id='var1_str' name='var1_str' required>";
                    }
                    echo "</div>";
                }
                
                if ($Rep['var2']==1){
                    echo "<div class='Elemento'>";                   
                    echo "<label>".$Rep['var2_label']."</label>";
                    if ($Rep['var2_type']=="option"){
                        echo "<select name='var2_str'  id='var2_str' class='form-control' required>";
                        echo var_select($id_rep,2);                        
                        echo "</select>";
                    } else {
                        echo "<input class='form-control' type='".$Rep['var2_type']."' value='' name='var2_str' id='var2_str' required>";
                    }
                    echo "</div>";
                }

                if ($Rep['var3']==1){
                    echo "<div class='Elemento'>";                   
                    echo "<label>".$Rep['var3_label']."</label>";
                    if ($Rep['var3_type']=="option"){
                        echo "<select name='var3_str'  id='var3_str' class='form-control' required>";
                        echo var_select($id_rep,2);                        
                        echo "</select>";
                    } else {
                        echo "<input class='form-control' type='".$Rep['var3_type']."' value='' id='var3_str' name='var3_str' required>";
                    }
                    echo "</div>";
                }


                echo "<br><br><buttom 'Preparar Reporte' class=' btn btn-success' name='btnReporte' onclick='CargaReporte(1,".$id_rep.");'>Preparar Reporte<buttom>";
                

                echo "</form>";

                if (isset($_POST['btnReporte'])){
                    // echo "<script>CargaReporte(Post)</;
                    // $Data =  Reporte($id_rep, $Tipo, $ClaseDiv, $ClaseTabla, $nitavu );
                    // historia_rintera($nitavu, "VIO", "".$id_rep."");
                    // echo $Data;
                }
            } else { // Sin Variables
                // $Data =  Reporte($id_rep, $Tipo, $ClaseDiv, $ClaseTabla, $nitavu );
                // historia_rintera($nitavu, "VIO", "".$id_rep."");
                // echo $Data;
                echo "<script>CargaReporte(0,".$id_rep.");</script>";
            }

        } else {
            Error("No se encontro información el reporte ".$id_rep);
            $Parametros = "";
            if (isset($_POST['var1_str'])){$Parametros.= "".$_POST['var1_str'];}
            if (isset($_POST['var2_str'])){$Parametros.= ", ".$_POST['var2_str'];}
            if (isset($_POST['var3_str'])){$Parametros.= ", ".$_POST['var3_str'];}

            if (isset($_GET['var1_str'])){$Parametros.= "".$_GET['var1_str'];}
            if (isset($_GET['var2_str'])){$Parametros.= ", ".$_GET['var2_str'];}
            if (isset($_GET['var3_str'])){$Parametros.= ", ".$_GET['var3_str'];}


            if ($Parametros == ''){
                historia_rintera($nitavu, "Reporte", "No encontro informacion del reporte ".$id_rep."");
            } else {
                historia_rintera($nitavu, "Reporte", "No encontro informacion del reporte ".$id_rep." con los parametros: ".$Parametros);
            }
        }
        

    } else {
        Error("No se encontro el reporte ".$id_rep);
        //historia_rintera($nitavu, "Reporte", "No encontro el reporte ".$id_rep."");
    }

    


   
    echo "</div>";



// echo "<div class='col-3'>";
//     UltimasBusquedas($nitavu);
// echo "</div>";

UltimasBusquedas_buble2($nitavu);

echo "</div>";

} else {
    Error("No tienes acceso a este Reporte");
}?>

<?php
include ("footer.php");
?>