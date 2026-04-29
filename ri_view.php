<?php
include("./lib/body_head.php");
include("./lib/body_menu.php"); 

$id_aplicacion ="ap50"; 
$nivel =aplicacion_nivel($id_aplicacion, $nitavu);
if (sanpedro($id_aplicacion, $nitavu)==TRUE){   
    echo "<div id='AppDetalle'>".app_detalle($id_aplicacion, $nitavu)."</div>";
    
    // echo "<div id='LoaderR' style='
    // width: 84%;    
    // background-color: white;
    // height: 100%;
    // position: absolute;
    // opacity: 0.7;
    // padding: 100px;
    // display:none;
    // '>";
    // // echo "Calculando....";
    // echo "</div>";

    $id_rep = $_GET['id_rep']; if (ValidaVAR($id_rep)==TRUE){$id_rep = LimpiarVAR($id_rep);} else {$id_rep = "";}    
    if (isset($_GET['id_rep']) AND isset($_GET['token'])){
            
            // echo "<iframe src='r2_view2.php?id_rep=".$id_rep."&nitavu=".$nitavu."&info=".$MyIp."&token=".$_GET['token']."&info=".$MyIp."' 
            // style='width:100%; height:98%; border: 0px solid black; margin-top: 10px;' border=0></iframe>";
            // echo "<script>
            // $('#grancontenido').css({'background-color':'#4d4d4d'});
            // $('body').css({'background-color':'#4d4d4d'});
            // </script>";
            echo "<div id='RContent' style='width:100%; height:100%;
            background-image: url(img/Reportes.jpg); background-size: cover;


            '>";
            $Interactivo = Reporteador_Interactivo($id_rep);        
            echo "<div id='info' style='            
            position: absolute;
            top: 10%;
            left: 10%; right:18%;
            background-color: rgba(255, 255, 255, 0.2);
            padding: 18px;
            border-radius: 17px;
            '>";
            echo Reporteador_Estadistica_html($id_rep);
            if ($Interactivo == TRUE){ 
               
                if (isset($_POST['var1']) or isset($_POST['var2']) or isset($_POST['var3']) ){ //si ya tengo las variables, ya no poner el form y poder invocar el reporte
                    echo "<button class='Mbtn btn-Secondary' onclick='Reporte();'>Consultar Reporte #".$id_rep."</button>";
                } else {
                    RI_Form($id_rep,$nitavu);
                }
            } else {
                echo "<button class='Mbtn btn-Secondary' onclick='Reporte();'>Consultar Reporte #".$id_rep."</button>";
            }

            if (nitavu_dpto($nitavu) == 55){
                echo "<br><a class='Mbtn btn-Warning'  title='Este apartado libmente para informatica' href='#Visitas' rel='MyModal:open'>Ultimos 100 movimientos</a>  ";
                $sqlVisitas = "select 
                a.fecha, a.hora,
                (select nombre from empleados where nitavu = a.nitavu_visitante) as Visito,
                -- a.nitavu_visitante, 
                a.info
                
                from reporteador_Visitas a where id_rep='".$id_rep."' order by fecha DESC limit 100";
                echo "<div id='Visitas' class='MyModal'>";
                echo "<h1>Ultimos 100 movientos del reporte ".$id_rep."</h1>";		
                TablaDinamica_MySQL("",$sqlVisitas, "Visitas", "TblVisitas", "", 2); //0 = Basica, 1 = ScrollVertical, 2 = Scroll Horizontal
                echo "</div>";


                echo "<a class='Mbtn btn-Warning' title='Este apartado libmente para informatica' href='#Accesos' rel='MyModal:open'>Usuarios con Permiso para ver este reporte</a>";
                $sqlPermisos = "select 
                a.fecha,
                --  a.hora,
                a.IdEmpleado,
                (select nombre from empleados where nitavu = a.IdEmpleado) as Empleado,
                a.Autorizo
                
                
                
                
                
                from reporteador_permisos a where id_rep='".$id_rep."' ";
                // echo $sqlPermisos;
                echo "<div id='Accesos' class='MyModal'>";
                echo "<h1>Ultimos 100 movientos del reporte ".$id_rep."</h1>";		
                TablaDinamica_MySQL("",$sqlPermisos, "DivPermisos", "TblPermisos", "", 2); //0 = Basica, 1 = ScrollVertical, 2 = Scroll Horizontal
                echo "</div>";



            }
           
            echo "</div>";

            
            echo "</div>";
            

            $ValidaToken = MiToken_valida($nitavu, $_GET['token']);            
            if ($ValidaToken == TRUE){ //soy el mismo usuario que le dio clic
                if ($Interactivo == TRUE){ //Solicitar formulario
                    //Construir las Variables
                   
                    if (isset($_POST['var1']) ){
                        $var1 = $_POST['var1']; if (ValidaVAR($var1)==TRUE){$var1 = LimpiarVAR($var1);} else {$var1 = "";}
                    } else {$var1 = "";}
            
                    if (isset($_POST['var2']) ){
                        $var2 = $_POST['var2']; if (ValidaVAR($var2)==TRUE){$var2 = LimpiarVAR($var2);} else {$var2 = "";}
                    } else {$var2 = "";}
            
                    if (isset($_POST['var3']) ){
                        $var3 = $_POST['var3']; if (ValidaVAR($var3)==TRUE){$var3 = LimpiarVAR($var3);} else {$var3 = "";}
                    } else {$var3 = "";}
                
                        //Script para cargar el PDF
                        echo '
                        <script>
                        function Reporte(){     
                            $("#preloader").show();                                             
                            token = "'.$_GET['token'].'";
                            id_rep = "'.$id_rep.'";
                            nitavu = "'.$nitavu.'";
                            var1 = "'.$var1.'";
                            var2 = "'.$var2.'";
                            var3 = "'.$var3.'";
                            $.ajax({
                                url: "ri_execute.php",
                                type: "post",    
                                data: {token:token, id_rep:id_rep,nitavu:nitavu, var1:var1, var2:var2, var3:var3},
                                success: function(data){        
                                    $("#RContent").html(data+"\n");
                                    $("#preloader").hide();                                

                            }
                            });
                            

                        }
                        </script>';
                    

                


                } else {//Cargar directamente
                          
                    //Script para cargar el PDF
                    echo '
                    <script>
                    function Reporte(){     
                        $("#preloader").show();                                             
                        token = "'.$_GET['token'].'";
                        id_rep = "'.$id_rep.'";
                        nitavu = "'.$nitavu.'";
                        $.ajax({
                            url: "ri_execute.php",
                            type: "post",    
                            data: {token:token, id_rep:id_rep,nitavu:nitavu},
                            success: function(data){        
                                $("#RContent").html(data+"\n");
                                $("#preloader").hide();                                

                        }
                        });
                        

                    }
                    </script>';
                }

                
            } else {toast("Error, token invalido",2,"");
                LocationFull("ri.php");
            }
      
    } else {
        Toast("Parametros Incorrectos",2,"");
    }

    
    // xd_update('ap18',$nitavu);//guarda la experiencia del usuario
    // historia($nitavu, "Entro a la aplicacion [ap18], Para ver el Directorio ");
     
} else {mensaje("Error: No esta autorizado para ver Estados de Cuenta.","index.php");}


?>
<script>
function getParameterByName(name) {
    name = name.replace(/[\[]/, "\\[").replace(/[\]]/, "\\]");
    var regex = new RegExp("[\\?&]" + name + "=([^&#]*)"),
    results = regex.exec(location.search);
    return results === null ? "" : decodeURIComponent(results[1].replace(/\+/g, " "));
}
</script>
<?php include ("./lib/body_footer.php"); ?>
