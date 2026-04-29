<?php
//require("config.php");
include ("./lib/body_head.php"); include ("./lib/body_menu.php");
require_once('lib/laura_funciones.php');
require_once('lib/flor_funciones.php');
?>


<?php
$id_aplicacion = 'ap132';
xd_update('ap132',$nitavu);//guarda la experiencia del usuario
$nivel =aplicacion_nivel($id_aplicacion, $nitavu);
echo "<div id='AppDetalle'>".app_detalle($id_aplicacion, $nitavu)."</div>";

if (isset($_GET['busqueda']))
    {
        
        $search = $_GET['busqueda'];
        
    }
     else {$search='';
            
    }

    echo ' <style>
  
    
    progress::-webkit-progress-bar {
        background-color: #eeeeee;
    }

    progress::-webkit-progress-value {
        background-color: #0C9D43 !important;
    }


</style>';

    echo "<div>";
    echo "<center>";
    echo "<div style='width:80%'>";
        echo "<br><br>";
    echo "<h2>HISTORIAL DE ACTIVIDADES FINALIZADAS:</h2>";
    if( ((titular(nitavu_dpto($nitavu))==$nitavu  or nitavu_dpto_nivel($nitavu)=='dir') ) or  $nivel==5){
        ECHO "<h4 class='card-header h5' style='text-transform: uppercase;font-size: 10pt; color: #ab0033;'>".nitavu_dpto_nombre($nitavu)."</h4>";
        }
        else
        {
            ECHO "<h1 class='card-header h5' style='text-transform: uppercase;font-size: 12pt; color: #ab0033;'>".nitavu_dpto_nombre($nitavu)."<br><span style='text-transform: uppercase;font-size: 10pt; color: gray;'>".nitavu_nombre($nitavu)."<span></h1>";
        }
        echo "<br><br>";
    echo "<div>";  
    echo "</center>";
    echo "<a style='right: 70px; position: absolute; top: 50px; margin-top: 10px;font-size: 12px; color: white;text-decoration: unset;' href='reporte_indicadores_empleados.php?nitavu=".$nitavu."&idrep=4&ss=".$search."' c  class='Mbtn btn-Gray' title='Imprimir actividades en pdf' class='btn btn-link'>
    Imprimir</a>";
    //echo "<a style='right: 70px; position: absolute; top: 50px; margin-top: 10px;font-size: 12px;' href='reporte_indicadores.php?nitavu=".$nitavu."' class='Mbtn btn-danger' title='Imprimir actividades en pdf' class='btn btn-link'>
    //Imprimir</a>";

if(isset($_GET['reactiva'])){  
        $idactividad = $_GET['reactiva'];           

        $sql = "Update actividades_empleados set 
            Estatus=1
            where IdActividad = ".$idactividad;
            if ($conexion->query($sql) == TRUE){ 
                mensaje('Se REACTIVO la actividad, podrá consultarla en el listado de actividades en desarrollo','indicadores_actterminadas_empleados.php');    
            }else{
                mensaje('Ocurrio un error al intentar REACTIVAR la actividad, favor de intentarlo nuevamente.','indicadores_actterminadas_empleados.php');
            }   

        
    }   
    
    
  
    $nivel=5;
  //  if (nitavu_dpto_nivel($nitavu)=='dir'){  
    if (nitavu_dpto_nivel($nitavu)=='dir' and $nivel==5)
    {
        echo "<center>"; 
        echo "<div style='width:80%;'>"; 
        buscarSinRequired('indicadores_actterminadas_empleados.php','Busqueda por Departamento, Actividad o Tema','');
        echo "</div>"; 
        echo "</center>"; 
        }


        echo "<br><br>";
    echo "<center>";
    echo "<div style='width:80%;'>";
    
    echo '<table class="table bordered" align="center" style="font-size: 14;">';
    // echo '<tr bgcolor="#991204" style="font-size:8pt;">';
     echo '<th style="width:2%; bacKground:#bc955c; color:white;" >NO</th>';
    // //echo '<th style="width:3%; bacKground:#bc955c; color:white;" rowspan="2">INF<br>GOB</th>';
    // //echo '<th style="width:3%; bacKground:#bc955c; color:white;" rowspan="2">PRIOR.</th>';
    // echo '<th style="width:13%; bacKground:#bc955c; color:white;" rowspan="2"><center>TEMA</center></th>';
    echo '<th style="width:9%; bacKground:#bc955c; color:white;" ><center>FECHA</center></th>';
     echo '<th style="width:30%; bacKground:#bc955c; color:white;" ><center>ACTIVIDAD</center></th>';
    // echo '<th style="width:4%; bacKground:#bc955c; color:white;" rowspan="2">META</th>';
    // echo '<th style="width:3%; bacKground:#bc955c; color:white;" rowspan="2"><center>OK</center></th>';   
    // echo '<th style="width:6%; bacKground:#bc955c; color:white;" rowspan="2">PROGRESO</th>'; 
    // echo '<th colspan="2" style="width:14%; bacKground:#bc955c; color:white;"><center>PROGRAMA</center></th>';
    // echo '<th colspan="2" style="width:10%; bacKground:#bc955c; color:white;">AVANCE ACUM.</th>';
    echo '<th style="width:20%; bacKground:#bc955c; color:white;" ><center>DEPARTAMENTO</center></th>'; ;
     echo '<th style="width:20%; bacKground:#bc955c; color:white;"><center>RESPONSABLE</center></th>'; ;
     echo '<th style="width:14%; bacKground:#bc955c; color:white;" ><center>OBSERVACIONES</center></th>';
     echo "<th  style='bacKground:#bc955c; color:white;'><center>REACTIVAR</center></th>";
    
     echo '</tr>';
    // echo '<tr  bgcolor="#C0BDBD"  style="font-size:7pt;">';    
    // echo '<td style="width:7%; bacKground:#bc955c; color:white;"><center><b>INICIO</b><center></td>';
    // echo '<td style="width:7%;  bacKground:#bc955c; color:white;"><center><b>TERMINO</b><center></td>';  
    // echo '<td style="width:6%; bacKground:#bc955c; color:white;"><center><b>FECHA</b><center></td>';  
    // echo '<td style="width:5%; bacKground:#bc955c; color:white;"><center>%<center></td>';       
    // echo '</tr>';



    
        //FILTRAR POR DIRECCION
        /* if(nitavu_dpto($nitavu)==1){
           
            $sql =" SELECT *, (CASE WHEN prioridad='A' THEN 0 WHEN prioridad='B' THEN 2 WHEN prioridad='M' THEN 1 END) as valorprioridad 
            FROM actividades_indicadores WHERE  Estatus=3  ORDER BY IdDireccion, valorprioridad";
        }else{
          
            $sql =" SELECT *, (CASE WHEN prioridad='A' THEN 0 WHEN prioridad='B' THEN 2 WHEN prioridad='M' THEN 1 END) as valorprioridad 
            FROM actividades_indicadores WHERE IdDireccion = ".nitavu_dpto($nitavu)."  ORDER BY IdDireccion, valorprioridad";
           
        }*/

        $direc=quienEsmiDireccion(nitavu_dpto($nitavu));
 
        if( (nitavu_dpto_nivel($nitavu)!='dir' and  $nivel==5) or titular(nitavu_dpto($nitavu))==$nitavu )
        {
           // echo "soy jefe de dpto o tengo nivel 5";
        //    $sql="Select * from actividades_empleados INNER JOIN cat_gerarquia on actividades_empleados.IdDepartamento=cat_gerarquia.id 
        //     where actividades_empleados.IdDepartamento=".nitavu_dpto($nitavu) ."  and (cat_gerarquia.nombre like '%".$search ."%' or actividades_empleados.Actividad like '%".$search."%' or actividades_empleados.Tema like'%".$search."%')  and Estatus not in (2,3) 
        //     order by actividades_empleados.IdDepartamento";

            $sql="Select * from actividades_empleados INNER JOIN cat_gerarquia on actividades_empleados.IdDepartamento=cat_gerarquia.id 
            where( actividades_empleados.IdDepartamento=".nitavu_dpto($nitavu) ." or  actividades_empleados.IdDepartamento in (select id from cat_gerarquia 
            where dependencia in(".misdptos($nitavu).") ) ) and (cat_gerarquia.nombre like '%".$search ."%' or actividades_empleados.Actividad like '%".$search."%' or actividades_empleados.Tema like'%".$search."%')  and Estatus  in (3) 
            order by actividades_empleados.IdDepartamento, actividades_empleados.nitavu";

        }
        else if (nitavu_dpto_nivel($nitavu)=='dir' or  $nivel==5){       
            $sql="Select * from actividades_empleados INNER JOIN cat_gerarquia on actividades_empleados.IdDepartamento=cat_gerarquia.id 
            where( actividades_empleados.IdDepartamento=".nitavu_dpto($nitavu) ." or  actividades_empleados.IdDepartamento in (select id from cat_gerarquia 
            where dependencia in(".misdptos($nitavu).") ) ) and (cat_gerarquia.nombre like '%".$search ."%' or actividades_empleados.Actividad like '%".$search."%' or actividades_empleados.Tema like'%".$search."%')  and Estatus  in (3) 
            order by actividades_empleados.IdDepartamento, actividades_empleados.nitavu";
            //echo "soy direccion o tengo nivel 5";

        }
        else{
            //echo "soy un emplado normal";
            $sql="Select * from  actividades_empleados where nitavu=".$nitavu." and IdDepartamento=".nitavu_dpto($nitavu) ." and Estatus  in (3)  ORDER BY IdActividad";
         
        } 

    
        //echo $sql;
        $conexion->set_charset('utf8mb4');
        $r= $conexion -> query($sql);
        while($f = $r -> fetch_array()) {
            $color = color_catjerarquia($f['IdDepartamento']);
            echo "<tr></tr>";
        
                
                echo "<td style='vertical-align: middle;color:black;'><b>".$f['IdActividad']."</b></td>";
                echo "<td style='vertical-align: middle; font-weight:bold;'>".date_format(date_create(FechaultimoavanceDpto($f['FechaInicio'])), 'd-m-y')."</td>";                          
                echo "<td style='font-size:13px;vertical-align: middle;'><b>".$f['Actividad']."</b><br>";
                echo "<a href='#modalHistorial".$f['IdActividad']."' rel='MyModal:open' style='font-size:11px;'>Historial actividades";
               
                /*MODAL   HISTORIAL*/
                /********************************************************************************************************************/
                echo "<div id='modalHistorial".$f['IdActividad']."' class='MyModal' >"; 
                echo '<h1 class="card-header h5" style="text-transform: uppercase;font-size: 10pt; color: #ab0033;">'.$f['Actividad'].'</h1><br>';
                $sql2="select * from historial_actividades_empleados  where IdActividad=".$f['IdActividad'];                 
                echo '<table class="tabla_punteada tabla"  align="center" style="font-size: 12; vertical-align: middle; ">
                <thead>
                <tr  align="center" style=" bacKground:#E75F54; color:white;">                   
                    <th style="width:10%;">Id</th>
                    <th  style=" vertical-align: middle; width:10%;">Fecha</th>
                    <th>Comentario</th>    
                    <th>Avance</th>            
                    </tr>
                </thead>
                <tbody>';

                $ll = $conexion -> query($sql2);
                while($v = $ll -> fetch_array())
                {
                    echo ' <tr>';    
                    echo ' <td><center>'.$v["Id"] .'</center></td>';                                                        
                    echo ' <td><center>'.date_format(date_create($v["Fecha"]), 'd-m-y').'</center></td>';
                    echo ' <td>'.$v["Comentario"] .'</td>';   
                    echo ' <td><center>'.$v["Avance"] .'%</center></td>';          
                
                    echo ' </tr>';
                }
                echo '</td>';
                echo '</tr>';
                
                echo '</tbody>
                </table>';
                echo "</div>";    
                /********************************************************************************************************************/     
                echo "</a>";
                echo "</td>";             
           
            $encargado = titular($f['IdActividad']);
            $nombreencargado = nitavu_nombre($nitavu);
            $nombreDpto=DptoNombre($f['IdDepartamento']);            
            echo "<td style='vertical-align: middle;'><b><center>".$nombreDpto."</center></b></td>";
            //se agrega nombre del personal
            echo "<td style='vertical-align: middle;'><b><center>".$nombreencargado."</center></b></td>";
               // echo "<td style='font-size:13px'><b>".$ultimocomentario."</b></td>";
            echo "<td style='font-size:13px'><b>".$f['Comentarios']."</b></td>";
            echo "<td style='vertical-align: middle;'><a class='pc'  href='indicadores_actterminadas_empleados.php?reactiva=".$f['IdActividad']."'   title='Archivar la actividad'>";
            echo "<img src='icon/renovar.png' style='width:40px; padding:5px;'>";        

            echo "</tr>";
        }
    echo "</table>";
    
    echo "</div>";

    echo "</center>";

    echo "</div>";


?>
<script>
 function reactiva(actividad){
    alert('se reactivo actividad'+ actividad );
    window.location.href='indicadores_actterminadas_empleados.php?reactiva='+actividad;
 }
</script>    

<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>


<?php include ("./lib/body_footer.php"); ?>
