<?php
include ("lib/body_head.php");// Estructura de Plataforma
include ("lib/body_menu.php"); //interfaz de menus



$id_aplicacion ="indicadores"; 
$nivel = aplicacion_nivel($id_aplicacion, $nitavu);
// $nivel = 1; //<--- Administrador completo
// $nivel = 2; //<--- Delegacion (Delegado)
// $nivel = 3; //<--- Oficinas Centrales
// $nivel = 4; //<-- Capturista

$Mi_IdDelegacion = midelegacion_id($nitavu);
// echo "Mi IdDelegacion= ".$Mi_IdDelegacion;
if (isset($_GET['IdDelegacion'])){
    $IdDelegacion = VarClean($_GET['IdDelegacion']);


} else {
    $IdDelegacion = "";
}


if (sanpedro($id_aplicacion, $nitavu)==TRUE){
    echo "<div id='AppDetalle'>".app_detalle($id_aplicacion, $nitavu)."</div>";      
    echo "<script>$('body').css('background-color','rgb(0, 85, 142)');</script>";
    echo "<div id='menuTopDiv' style='
    width: 100%;
    background-color: #03416a;
    height: 37px;
    margin-top: -10px;
    '>";
    echo '
    <nav id="menuTop">
    <ul>
      <li>';
      if (isset($_GET['captura'])){
        echo '<a href="?captura=" class="active" style="background-color:orange;">Captura</a>';
      } else {
        echo '<a href="?captura=">Captura</a>';
      }
      

      echo '</li>
      <li><a href="?indicadores=">Resultados</a>
           
      </li>
      <li>';
      
      if (isset($_GET['permisos'])){
        echo '<a href="?permisos=" class="active" style="background-color:orange;">Permisos</a>';
      } else {
        echo '<a href="?permisos=">Permisos</a>';
      }
      

      echo '
       
      </li>
      

    </ul>
    </nav>
    ';
    echo "</div>";

	

    ///PERMISOS////////////////
    if ($nivel == 2 and (isset($_GET['permisos']))){//Soy Delegacion
        $sql =  "select IdEmpleado, CONCAT(Nombre,'<br><cite>',Permiso,'</cite>') as Nombre, Boton from indicadorescapturistas where dpto=".nitavu_dpto($nitavu)." and IdEmpleado<>".$nitavu;
        // echo $sql;
        echo "<div id='Capturistas' style='
            background-color:white;
            height:100%;
        
        '>";
        echo "<br><h3 style='color:green;'>Capturistas a cargo de <b> ".nitavu_nombre($nitavu)."</b></h3><br><br><br>";
        TablaDinamica_MySQL("",$sql, "MiIdDivTabla2", "IdTabla2", "container bg-white", 2); //0 = Basica, 1 = ScrollVertical, 2 = Scroll Horizontal
        echo "</div>";
    }


    if (($nivel == 1 OR $nivel==3 )and (isset($_GET['permisos']))){//Soy Delegacion
        $sql =  "select IdEmpleado, CONCAT(Nombre,'<br><cite>',Permiso,'</cite>') as Nombre, Boton from indicadorescapturistas where  IdEmpleado<>".$nitavu;
        // echo $sql;
        echo "<div id='Capturistas' style='
            background-color:white;
            height:100%;
        
        '>";
        echo "<br><h3 style='color:green;'>Adminsitrar Permisos de Capturistas</h3><br><br><br>";
        TablaDinamica_MySQL("",$sql, "MiIdDivTabla2", "IdTabla2", "container bg-white", 2); //0 = Basica, 1 = ScrollVertical, 2 = Scroll Horizontal
        echo "</div>";
    }
    


    
    
    ///////CAPTURA////////////////
    if (isset($_GET['captura'])){//Soy Delegacion

      
        
            echo "<div id='Trimestres' class='row'
            style='
                
            '
            >";
                echo "<div class='col-2' style='
                    font-size: 20pt;
                    color: white;
                    text-align: center;
                    background-color: orange;
                    border-radius: 5px;
                    height: 59px;
                    margin-top: 6px;
                    margin-left: 23px;
                    font-weight: bold;
                '>";
                $GranAnio = date("Y");
                echo "<a href='?captura=' style='
                    display: block;
                    padding-top: 5px;
                
                '>".$GranAnio."</a>";
                echo "</div>";

            
                if ($nivel==2){

                    if ($IdDelegacion == $Mi_IdDelegacion){
                        $sql = "SELECT * FROM indicadorestrimestrales_trimestres";	
                        $rc= $conexion -> query($sql);
                        while($f = $rc -> fetch_array()) {
        
                            $DatosExtras="";
                            $sqlValue = "select * from indicadorestrimestrales_avances where Anio=".$GranAnio." and IdTrimestre=".$f['IdTrimestre']." and IdDelegacion=".$IdDelegacion."";	                
                            // echo $sqlValue;
                            $TotalCaptura = 0;
                            if ( $conexion -> query($sqlValue) ==TRUE){
                                $re= $conexion -> query($sqlValue);
                                while($fE = $re -> fetch_array()) {
                                    $DatosExtras.="Capturados ".$fE['TotalCapturado']." de ".$fE['Meta'];
                                    $TotalCaptura = $fE['TotalCapturado'];
        
                                }
                            unset($re, $fE);
                            }
        
        
                            if ($TotalCaptura == 15 ){ //Total Capturado
                                echo "<button title='".$DatosExtras."' id='btn_".$f['IdTrimestre']."' class='btn btn-success col-2' style='margin-left:10px; font-size:10pt;'
                                onclick='Captura(".$f['IdTrimestre'].");'
                                >";
                                echo $f['Trimestre'];
                                echo "</button>";
                            } else {
                                if ($TotalCaptura == 0 ){ //Total Capturado
                                    echo "<button title='Sin Capturas".$DatosExtras."' id='btn_".$f['IdTrimestre']."' class='btn btn-secondary col-2' style='margin-left:10px; font-size:10pt;'
                                    onclick='Captura(".$f['IdTrimestre'].");'
                                    >";
                                    echo $f['Trimestre'];
                                    echo "</button>";
                                } else {
                                    echo "<button title='".$DatosExtras."' id='btn_".$f['IdTrimestre']."' class='btn btn-primary col-2' style='margin-left:10px; font-size:10pt;'
                                    onclick='Captura(".$f['IdTrimestre'].");'
                                    >";
                                    echo $f['Trimestre'];
                                    echo "</button>";
                                }
                            }
                        
                        }

                    
                    }
                } else {
                    $sql = "SELECT * FROM indicadorestrimestrales_trimestres";	
                    $rc= $conexion -> query($sql);
                    while($f = $rc -> fetch_array()) {
    
                        $DatosExtras="";
                        $sqlValue = "select * from indicadorestrimestrales_avances where Anio=".$GranAnio." and IdTrimestre=".$f['IdTrimestre']." and IdDelegacion=".$IdDelegacion."";	                
                        // echo $sqlValue;
                        $TotalCaptura = 0;
                        if ( $conexion -> query($sqlValue) ==TRUE){
                            $re= $conexion -> query($sqlValue);
                            while($fE = $re -> fetch_array()) {
                                $DatosExtras.="Capturados ".$fE['TotalCapturado']." de ".$fE['Meta'];
                                $TotalCaptura = $fE['TotalCapturado'];
    
                            }
                        unset($re, $fE);
                        }
    
    
                        if ($TotalCaptura == 15 ){ //Total Capturado
                            echo "<button title='".$DatosExtras."' id='btn_".$f['IdTrimestre']."' class='btn btn-success col-2' style='margin-left:10px; font-size:10pt;'
                            onclick='Captura(".$f['IdTrimestre'].");'
                            >";
                            echo $f['Trimestre'];
                            echo "</button>";
                        } else {
                            if ($TotalCaptura == 0 ){ //Total Capturado
                                echo "<button title='Sin Capturas".$DatosExtras."' id='btn_".$f['IdTrimestre']."' class='btn btn-secondary col-2' style='margin-left:10px; font-size:10pt;'
                                onclick='Captura(".$f['IdTrimestre'].");'
                                >";
                                echo $f['Trimestre'];
                                echo "</button>";
                            } else {
                                echo "<button title='".$DatosExtras."' id='btn_".$f['IdTrimestre']."' class='btn btn-primary col-2' style='margin-left:10px; font-size:10pt;'
                                onclick='Captura(".$f['IdTrimestre'].");'
                                >";
                                echo $f['Trimestre'];
                                echo "</button>";
                            }
                        }
                    
                    }


                }
        echo "</div>";

  

        echo '<div class="row bg-white" style="
        padding: 15px;            
        border-radius: 5px;
        margin: 10px;
        "
        id="Formas"
        >';

                echo '<div class="col-3 bg-white" style="
                        padding: 15px;            
                        border-radius: 5px;
                        margin: 10px;
                        "
                        id="Delegaciones"
                        >';

                      
                        
                            $sql = "select 
                            id as IdDelegacion,
                            nombre as Delegacion
                            from cat_delegaciones
                            where domicilio<> '' and id <> 0";
                        
                        $rDel= $conexion -> query($sql);           
                        
                        while($Del = $rDel -> fetch_array()) {
                            if ($Mi_IdDelegacion == ''){
                                if ($IdDelegacion==$Del['IdDelegacion']){
                                    echo "<a style='font-size:10pt; width:80%; border-radius:2px; padding-left:3px; padding-right:3px; display:inline-block;' class='bg-warning text-white' href='?captura=&IdDelegacion=".$Del['IdDelegacion']."'>".$Del['Delegacion']."</a><br>";
                                } else {
                                    echo "<a style='font-size:10pt; width:80%; border-radius:2px; padding-left:3px; padding-right:3px; display:inline-block;' class='text-secondary' href='?captura=&IdDelegacion=".$Del['IdDelegacion']."'>".$Del['Delegacion']."</a><br>";
                                }
                            } else {       
                                if ($Mi_IdDelegacion == $Del['IdDelegacion']){                       
                                    if ($IdDelegacion==$Del['IdDelegacion']){
                                        echo "<b><a style='font-size:10pt; width:80%; border-radius:2px; padding-left:3px; padding-right:3px; display:inline-block;' class='bg-warning text-white' href='?captura=&IdDelegacion=".$Del['IdDelegacion']."'>".$Del['Delegacion']."</a></b><br>";
                                    } else {
                                        echo "<b><a style='font-size:10pt; width:80%; border-radius:2px; padding-left:3px; padding-right:3px; display:inline-block;' class='text-secondary' href='?captura=&IdDelegacion=".$Del['IdDelegacion']."'>".$Del['Delegacion']."</a></b><br>";
                                    }
                                } else {
                                    echo "<span style='font-size:10pt; width:80%; border-radius:2px; padding-left:3px; padding-right:3px; display:inline-block;' class='text-secondary' href='?captura=&IdDelegacion=".$Del['IdDelegacion']."'>".$Del['Delegacion']."</span><br>";
                                }


                            }
                         
                        }
                        

            echo "</div>";
                

                        
                echo '<div class="row col-8 bg-white" style="
                padding: 15px;            
                border-radius: 5px;
                margin: 10px;
                "
                id="CapturaForm"
                >';


                if ($IdDelegacion<>""){
                    // echo "Grafica de Avance por Delegacion";
                } else {
                    // echo "Grafica de Avance de todas las delegaciones";
                }

                echo "</div>";
        


        echo "</div>";
           
    
    if ($nivel==2) {
        if ($IdDelegacion == $Mi_IdDelegacion){


        } else {
            $Mensaje = "No puedes capturar en este IdDelegacion ".$IdDelegacion;

            echo "<div id='Error'

            style='
            background-color:red;
            color:white;
            width:90%;
            display:inline-block;
            border-radius:10px;
            margin:20px;
            padding:20px;
            '
            ><table width=100%><tr><td
            style='color:white;'
            >".$Mensaje."</td><td width=50px><a href='indicadores.php' class='btn btn-Warning'>Reintentar</a></td></tr></table></div>";
            
        }
    }



      



        //ejemplo boton de progreso
        // echo '<a id="btnProgreso" href="#" class="progress-button">Boton con Progreso</a>';        
        // echo '
        // <script>
        // $(document).ready(function () {
        //     $("#btnProgreso").progressSet(80);
        // })
        // </script>
        // ';
     

     
        echo '<script>';
        echo '
            function Captura(IdTrimestre){             
                Anio = '.$GranAnio.';
                IdDelegacion = "'.$IdDelegacion.'";
                $("#btn_123").addClass("btn-primary");       $("#btn_123").removeClass("btn-warning");
                $("#btn_456").addClass("btn-primary");       $("#btn_456").removeClass("btn-warning");
                $("#btn_789").addClass("btn-primary");       $("#btn_789").removeClass("btn-warning");
                $("#btn_101112").addClass("btn-primary");    $("#btn_101112").removeClass("btn-warning");

                $("#btn_" + IdTrimestre).addClass("btn-warning");
                $("#btn_" + IdTrimestre).removeClass("btn-primary");
                $( "#progressbar").show();
                $.ajax({
                    url: "indicadores_data.php",
                   type: "post",                
                   data: {IdTrimestre: IdTrimestre, Anio:Anio, IdDelegacion: IdDelegacion},
                   success: function(data){
                    $("#CapturaForm").html(data+"\n");                    
                    $( "#progressbar").hide();
                   }
                });
                
            }
        
        ';

        
        echo '
        function Save(Campo, IdTrimestre, Anio){
            Valor = $("#" + Campo).val();
            IdDelegacion = "'.$IdDelegacion.'";
            $( "#progressbar").show();
            $.ajax({
                url: "indicadores_data2.php",
               type: "post",                
               data: {IdTrimestre: IdTrimestre, Anio:Anio, Campo:Campo, Valor:Valor, IdDelegacion:IdDelegacion},
               success: function(data){
                $("#R").html(data+"\n");                    
                $( "#progressbar").hide();
               }
            });
        }
        ';
        echo '</script>';


     

      
    }








   ///FORMATOS DE RESULTADOS////////////////
   if (isset($_GET['indicadores'])){//Soy Delegacion
    
    if ($nivel == 3){


        echo "<div id='Trimestres' class='row'
        style='
            
        '
        >";
            echo "<div class='col-2' style='
                font-size: 20pt;
                color: white;
                text-align: center;
                background-color: orange;
                border-radius: 5px;
                height: 59px;
                margin-top: 6px;
                margin-left: 23px;
                font-weight: bold;
            '>";
            $GranAnio = date("Y");
            echo "<a href='?captura=' style='
                display: block;
                padding-top: 5px;
            
            '>".$GranAnio."</a>";
            echo "</div>";
            $sql = "SELECT * FROM indicadorestrimestrales_trimestres";	
		    $rc= $conexion -> query($sql);
		    while($f = $rc -> fetch_array()) {

                $DatosExtras="";
                $sqlValue = "select * from indicadorestrimestrales_avances where Anio=".$GranAnio." and IdTrimestre=".$f['IdTrimestre']." and IdDelegacion=".$IdDelegacion."";	                
                // echo $sqlValue;
                $TotalCaptura = 0;
                if ( $conexion -> query($sqlValue) ==TRUE){
                    $re= $conexion -> query($sqlValue);
                    while($fE = $re -> fetch_array()) {
                        $DatosExtras.="Capturados ".$fE['TotalCapturado']." de ".$fE['Meta'];
                        $TotalCaptura = $fE['TotalCapturado'];

                    }
                unset($re, $fE);
                }


                if ($TotalCaptura == 15 ){ //Total Capturado
                    echo "<button title='".$DatosExtras."' id='btn_".$f['IdTrimestre']."' class='btn btn-success col-2' style='margin-left:10px; font-size:10pt;'
                    onclick='getCapturas(".$f['IdTrimestre'].",0);'
                    >";
                    echo $f['Trimestre'];
                    echo "</button>";
                } else {
                    if ($TotalCaptura == 0 ){ //Total Capturado
                        echo "<button title='Sin Capturas".$DatosExtras."' id='btn_".$f['IdTrimestre']."' class='btn btn-secondary col-2' style='margin-left:10px; font-size:10pt;'
                        onclick='getCapturas(".$f['IdTrimestre'].",0);'
                        >";
                        echo $f['Trimestre'];
                        echo "</button>";
                    } else {
                        echo "<button title='".$DatosExtras."' id='btn_".$f['IdTrimestre']."' class='btn btn-primary col-2' style='margin-left:10px; font-size:10pt;'
                        onclick='getCapturas(".$f['IdTrimestre'].",0);'
                        >";
                        echo $f['Trimestre'];
                        echo "</button>";
                    }
                }
               
            }
        echo "</div>";

        echo "<div id='AquiVaMiPlantilla' style='
        
                    width: 95%;
            background-color: white;
            display: inline-block;
            margin: 2%;
            padding: 12px;
            border-radius: 12px;
        '>";
        echo "</div>";


        echo '                
        <script>
        function getCapturas(IdTrimestre,Formato){                 
            Anio=2021;

            $( "#progressbar").show();
            $.ajax({
                url: "indicadores_formatos.php",
                type: "post",   
                data: {IdTrimestre:IdTrimestre, Anio:Anio, Formato:Formato},
                success: function(data){            
                    $("#AquiVaMiPlantilla").html(data);
                    $( "#progressbar").hide();
            }
        });
        
        }
        </script>';


       

    } else {
        // Toast("No tienes acceso para ver estos formatos".$nivel,2,"");    
        mensaje("ERROR no tiene acceso a este modulo","indicadores.php");
    }
}





    echo '
    <div class="alert alert-warning movil" role="alert">
        Esta aplicacion esta optimizada para usarse en computadora. Por favor no la use en movil;
    </div>
    ';
    
    echo '                
    <script>
    function Permiso(IdEmpleado){                 
        $( "#progressbar").show();
        $.ajax({
            url: "indicadores_dataPermisos.php",
            type: "post",   
            data: {IdEmpleado:IdEmpleado},
            success: function(data){            
                $("#RV").html(data);
                $( "#progressbar").hide();
        }
    });
    
    }
    </script>';


} else {mensaje("ERROR: no tienes acceso","");}
?>


<?php
include ("./lib/body_footer.php"); //Cierre de Estructura de la Plaforma
?>