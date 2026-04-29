<?php
require_once("config.php");
require_once("lib/funciones.php");
require_once("lib/flor_funciones.php");

error_reporting(0); //<-- para simular produccion
$id_rep = $_POST['id_rep']; if (ValidaVAR($id_rep)==TRUE){$id_rep = LimpiarVAR($id_rep);} else {$id_rep = "";}
$token = $_POST['token']; if (ValidaVAR($token)==TRUE){$token = LimpiarVAR($token);} else {$token = "";}
$nitavu = $_POST['nitavu']; if (ValidaVAR($nitavu)==TRUE){$nitavu = LimpiarVAR($nitavu);} else {$nitavu = "";}


$ValidaToken = MiToken_valida($nitavu, $token);            
if ($ValidaToken == TRUE){ //soy el mismo usuario que le dio clic
    $Interactivo = Reporteador_Interactivo($id_rep);                        
    if ($Interactivo==TRUE){ //Solicitar formulario                    
           //Se estan recibiendo por POST = var1, var2, var3 -> enviadas por el AutoForm
        
        //Limpiamos las Variables
        if (isset($_POST['var1']) ){
            $var1 = $_POST['var1']; if (ValidaVAR($var1)==TRUE){$var1 = LimpiarVAR($var1);} else {$var1 = "";}
        } else {$var1 = "";}

        if (isset($_POST['var2']) ){
            $var2 = $_POST['var2']; if (ValidaVAR($var2)==TRUE){$var2 = LimpiarVAR($var2);} else {$var2 = "";}
        } else {$var2 = "";}

        if (isset($_POST['var3']) ){
            $var3 = $_POST['var3']; if (ValidaVAR($var3)==TRUE){$var3 = LimpiarVAR($var3);} else {$var3 = "";}
        } else {$var3 = "";}

        // var_dump($_POST['var1']);
        // var_dump($_POST['var2']);
        // var_dump($_POST['var3']);

        //Construimos
           $t1 = RI_SQL1_interactive($id_rep, $var1, $var2, $var3);
           $t2 = RI_SQL2($id_rep); // estas no utilizan aun varX
           $t3 = RI_SQL3($id_rep); // estas no utilizan aun varX
        //    GenerarGrafica($nitavu, $id_rep,$token);        
           MiToken_Close($nitavu,$token); //Cierro el token        
           $info_leyenda = "Consultado el ".fecha_larga($fecha).":".hora12($hora)." | ".$nitavu." - ".nitavu_nombre($nitavu)." - ".nitavu_dpto_nombre($nitavu)." | ".$info." | ".InfoEquipo()." Token: ".$token;
           reporteador_Visitas($id_rep, $nitavu, $info."(".$var1.", ".$var2.",".$var3.")");       
           
           switch (RI_out_type($id_rep)) {
            case 0:
                ImprimirReporte($id_rep, $nitavu, $t1, $t2, $t3,$info_leyenda, $token);
                break;
            case 1:
                //Excel
                
                    $Contenido = '

                    <html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:w="urn:schemas-microsoft-com:office:word" xmlns="http://www.w3.org/TR/REC-html40">
                    <head><title>Ejemplo Microsoft Office HTML</title></head>
                    <body>'.$t1.'<br>'.$t2.'<br>'.$t3.'

                    </body>
                    </html>

                ';
                    echo "<form id='FormExcel' method='POST' action='excel.php' style=''>";
                    echo "<input type='hidden' name='Tabla' value='".$Contenido."'>";
                    echo "<input type='hidden' name='nitavu' value='".$nitavu."'>";
                    echo "<input type='hidden' name='Archivo' value='Reporte_".$id_rep."'>";
                    echo "<intpu type='submit' value='Enviar'>";
                    echo "</form>";

                    echo "<br><br><br><br><br><label style='font-size:14pt;'>Su reporte esta listo!</label><br><button onclick='Excel_go()' class='Mbtn btn-Primary'>Exportar a Excel</button>";
                    echo "<script>
                    function Excel_go(){
                        document.FormExcel.submit();
                    }
                    </script>
                    ";

        


                break;
            case 2:
                //Pantalla
                echo "<div id='infoReporte' class='tabla'
                style='
                background-color:white;
                width:97%;
                margin:6px;
                font-size:8pt;
                display: inline-block;
                margin-top: 14px;
                '
                
                >".$t1."<hr>".$t2."<hr>".$t3."</div>";
                break;
            default:
                ImprimirReporte($id_rep, $nitavu, $t1, $t2, $t3,$info_leyenda, $token);
        }

          
           
            

    } else {//Cargar directamente
        // $("#preloader").show()

        
        $t1 = RI_SQL1($id_rep);
        $t2 = RI_SQL2($id_rep);
        $t3 = RI_SQL3($id_rep);
        // GenerarGrafica($nitavu, $id_rep,$token);        
        MiToken_Close($nitavu,$token); //Cierro el token        
        $info_leyenda = "Consultado el ".fecha_larga($fecha).":".hora12($hora)." | ".$nitavu." - ".nitavu_nombre($nitavu)." - ".nitavu_dpto_nombre($nitavu)." | ".$info." | ".InfoEquipo()." Token: ".$token;
        reporteador_Visitas($id_rep, $nitavu, $info."(".$var1.", ".$var2.",".$var3.")");            
       
        switch (RI_out_type($id_rep)) {
            case 0:
                ImprimirReporte($id_rep, $nitavu, $t1, $t2, $t3,$info_leyenda, $token);
                break;
            case 1:
                //Excel
                
                    $Contenido = '

                    <html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:w="urn:schemas-microsoft-com:office:word" xmlns="http://www.w3.org/TR/REC-html40">
                    <head><title>Ejemplo Microsoft Office HTML</title></head>
                    <body>'.$t1.'<br>'.$t2.'<br>'.$t3.'

                    </body>
                    </html>

                ';
                    echo "<form id='FormExcel' method='POST' action='excel.php' style=''>";
                    echo "<input type='hidden' name='Tabla' value='".$Contenido."'>";
                    echo "<input type='hidden' name='nitavu' value='".$nitavu."'>";
                    echo "<input type='hidden' name='Archivo' value='Reporte_".$id_rep."'>";
                    echo "<intpu type='submit' value='Enviar'>";
                    echo "</form>";

                    echo "<br><br><br><br><br><label style='font-size:14pt;'>Su reporte esta listo!</label><br><button onclick='Excel_go()' class='Mbtn btn-Primary'>Exportar a Excel</button>";
                    echo "<script>
                    function Excel_go(){
                        document.FormExcel.submit();
                    }
                    </script>
                    ";

        


                break;
            case 2:
                //Pantalla
                echo "<div id='infoReporte' class='tabla'
                style='
                background-color:white;
                width:97%;
                margin:6px;
                font-size:8pt;
                display: inline-block;
                margin-top: 14px;
                '
                
                >".$t1."<hr>".$t2."<hr>".$t3."</div>";
                break;
            default:
                ImprimirReporte($id_rep, $nitavu, $t1, $t2, $t3,$info_leyenda, $token);
        }
        
    }

} else {
    echo "Token no valido: ".$_GET['token'];
    LocationFull("ri.php");
}
?>