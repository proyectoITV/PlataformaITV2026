<?php
require ("unica/config.php");
require ("unica/funciones.php");
require ("unica/flor_funciones.php");
$nitavu = $_GET['nitavu'];
$caso = $_GET['caso'];
$id_aplicacion ="ap66";
$nivel =aplicacion_nivel($id_aplicacion, $nitavu);

if(isset($_GET['dpto'])){
    $dpto = $_GET['dpto'];
    
    if($caso==1){
        if ($nivel==1 || soytitular($nitavu)!='FALSE'){
            $query = "select * from (SELECT DISTINCT * FROM cp_nuevosdocumentos 
        WHERE (nitavuCaptura = ".$nitavu." OR idDptoCrea = ".$dpto."  OR id IN (SELECT numcaso FROM cp_colaboradores WHERE nitavu=".$nitavu.") OR id IN (SELECT NumCaso FROM cp_historialdocumentos WHERE nitavuSube=".$nitavu.") OR turnadoa = ".$dpto." OR id IN (SELECT CasoId FROM cp_comentarios WHERE Nuser = ".$nitavu."))
        AND estado = 1) as t1 where turnadoa = ".$dpto."";
        }else{
            $query = "select * from (SELECT DISTINCT * FROM cp_nuevosdocumentos 
        WHERE (nitavuCaptura = ".$nitavu." OR id IN (SELECT numcaso FROM cp_colaboradores WHERE nitavu=".$nitavu.") OR id IN (SELECT NumCaso FROM cp_historialdocumentos WHERE nitavuSube=".$nitavu.") OR id IN (SELECT CasoId FROM cp_comentarios WHERE Nuser = ".$nitavu."))
        AND estado = 1) as t1 where  turnadoa = ".$dpto."";    
        }
    }else{
        if ($nivel==1 || soytitular($nitavu)!='FALSE'){
            $query = "select * from (SELECT DISTINCT * FROM cp_nuevosdocumentos 
        WHERE (nitavuCaptura = ".$nitavu." OR idDptoCrea = ".nitavu_dpto($nitavu)."  OR id IN (SELECT numcaso FROM cp_colaboradores WHERE nitavu=".$nitavu.") OR id IN (SELECT NumCaso FROM cp_historialdocumentos WHERE nitavuSube=".$nitavu.") OR turnadoa = ".nitavu_dpto($nitavu)." OR id IN (SELECT CasoId FROM cp_comentarios WHERE Nuser = ".$nitavu."))
        AND estado = 0) as t1 where  turnadoa = ".$dpto."";
      
        }else{
            $query = "select * from (SELECT DISTINCT * FROM cp_nuevosdocumentos 
        WHERE (nitavuCaptura = ".$nitavu." OR id IN (SELECT numcaso FROM cp_colaboradores WHERE nitavu=".$nitavu.") OR id IN (SELECT NumCaso FROM cp_historialdocumentos WHERE nitavuSube=".$nitavu.") OR id IN (SELECT CasoId FROM cp_comentarios WHERE Nuser = ".$nitavu."))
        AND estado = 0) as t1 where turnadoa = ".$dpto."";
     
        }
    }
    
    //echo $query;

        $r= $conexion -> query($query); 
        $r_count = $r -> num_rows;
        echo "<div style='height:100%; overflow: scroll;' >";
        if ($r_count>0){ 
                 
        $cont=0;
             
            echo "<table class='tabla' style='width:100%;'>";
            echo "<th width='10%' COLSPAN='2'>Fecha</th>"; 
            echo "<th width='70%'>Asunto</th>";
            echo "<th >Ver</th>";
            
            while($f = $r -> fetch_array()){

                echo "<tr>";
                    echo "<td  style='text-align: center;'><span style='background-color:gray; color:white;padding:5px; border-radius:50%;font-size:10pt'>".$f['id']."</span></td>";
                    echo "<td  style='text-align: center;'>".fecha_larga($f['fecha'])."</td>";              
                    echo "<td><div style='width:100%;'><b>".$f['asunto']."</b><span style='font-size:7pt'><br>".$f['descripcion']."</span><br>
                    <span style='color:blue;'>Creado por: ".nombreDepartamento($f['idDptoCrea'])."<br>";
                    
                    if(ultimoColaborador($f['id']) != 'FALSE'){
                        echo '<b style="color: #000; font-size:8pt;">Ultimo colaborador: '.nitavu_nombre(ultimoColaborador($f['id'])).'</b>';
                      }else{
                        if(personasConNivelUno($f['id']) != 'FALSE'){
                          echo '<b style="color: #000; font-size:8pt;">Ultimo colaborador: '.nitavu_nombre(personasConNivelUno($f['id'])).'</b>';
                        }else{
                          if(buscoalTitulardelCaso($f['id']) != 'FALSE'){
                            echo '<b style="color: #000; font-size:8pt;">Ultimo colaborador: '.nitavu_nombre(buscoalTitulardelCaso($f['id'])).'</b>';
                          }else{
                            echo '<b style="color: #000; font-size:8pt;">No definido</b>';
                          }
                        }
                      }

                    echo "</span></div>";
    
    
                    echo "</td>";
                    echo "<td>";
                    echo '<center><div id="cont2">
                        <div id="contenidos2">
                            <center>
                            <div id="colum1">';
                                echo "<form action='cp_nuevos_oficios.php' method='GET'>";
                                echo "<input type='hidden' value=".$f['id']." name='id'>";
                                echo "<input type='hidden' name='txtplus' value=1>";
                                echo "<input type='hidden' name='pv' value=1>";
                                echo "<button type='submit' class='btn btn-default' title='Haga clic para ver el historial del archivo' onclick=''> <img src='icon/ojo1.png' style='width:20px; height:20px;'> </button>"; 
                                echo "</form>";
                            echo '</div>';
                        echo '</center>
                        </div>
                        </div>
                        </center>
                    </td>';
                echo "</tr>";
               
            } 
            echo "</table>";
            
        }else{
            echo "<label>Nada por el momento...</label>";
        }

    echo "</div>";
    
}


?>