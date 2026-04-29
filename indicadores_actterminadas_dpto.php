<?php
//require("config.php");
include ("./lib/body_head.php"); include ("./lib/body_menu.php");
require_once('lib/laura_funciones.php');
require_once('lib/flor_funciones.php');
?>


<?php
$id_aplicacion = 'ap131';
xd_update('ap131',$nitavu);//guarda la experiencia del usuario
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

    echo "<div>";
        echo "<br><br>";
    echo "<h2>HISTORIAL DE ACTIVIDADES FINALIZADAS:</h2>";
        echo "<br><br>";
    echo "<div>";  
    
    echo "<a style='right: 70px; position: absolute; top: 50px; margin-top: 10px;font-size: 12px;' href='reporte_indicadores.php?nitavu=".$nitavu."&idrep=4&ss=".$search."' class='Mbtn btn-danger' title='Imprimir actividades en pdf' class='btn btn-link'>
    Imprimir</a>";
    //echo "<a style='right: 70px; position: absolute; top: 50px; margin-top: 10px;font-size: 12px;' href='reporte_indicadores.php?nitavu=".$nitavu."' class='Mbtn btn-danger' title='Imprimir actividades en pdf' class='btn btn-link'>
    //Imprimir</a>";

if(isset($_GET['reactiva'])){  
        $idactividad = $_GET['reactiva'];           

        $sql = "Update actividades_dpto set 
            Estatus=1
            where IdActividad = ".$idactividad;
            if ($conexion->query($sql) == TRUE){ 
                mensaje('Se REACTIVO la actividad, podrá consultarla en el listado de actividades en desarrollo','indicadores_deptos_dir.php');    
            }else{
                mensaje('Ocurrio un error al intentar REACTIVAR la actividad, favor de intentarlo nuevamente.','indicadores_deptos_dir.php');
            }   

        
    }   
    
    
  
    
    if (nitavu_dpto_nivel($nitavu)=='dir'){  
        echo "<center>"; 
        echo "<div style='width:80%;'>"; 
        buscarSinRequired('indicadores_actterminadas_dpto.php','Busqueda por Departamento, Actividad o Tema','');
        echo "</div>"; 
        echo "</center>"; 
        }


        echo "<br><br>";
    echo "<center>";
    echo "<div style='width:80%;'>";
    
    echo '<table class="table bordered" align="center" style="font-size: 14;">';
    echo '<tr bgcolor="#991204" style="font-size:8pt;">';
    echo '<th style="width:2%; bacKground:#bc955c; color:white;" rowspan="2">NO</th>';
    //echo '<th style="width:3%; bacKground:#bc955c; color:white;" rowspan="2">INF<br>GOB</th>';
    //echo '<th style="width:3%; bacKground:#bc955c; color:white;" rowspan="2">PRIOR.</th>';
    echo '<th style="width:13%; bacKground:#bc955c; color:white;" rowspan="2"><center>TEMA</center></th>';
    echo '<th style="width:18%; bacKground:#bc955c; color:white;" rowspan="2"><center>ACTIVIDAD</center></th>';
    echo '<th style="width:4%; bacKground:#bc955c; color:white;" rowspan="2">META</th>';
    echo '<th style="width:3%; bacKground:#bc955c; color:white;" rowspan="2"><center>OK</center></th>';   
    echo '<th style="width:6%; bacKground:#bc955c; color:white;" rowspan="2">PROGRESO</th>'; 
    echo '<th colspan="2" style="width:14%; bacKground:#bc955c; color:white;"><center>PROGRAMA</center></th>';
    echo '<th colspan="2" style="width:10%; bacKground:#bc955c; color:white;">AVANCE ACUM.</th>';
    echo '<th style="width:10%; bacKground:#bc955c; color:white;" rowspan="2"><center>RESPONSABLE</center></th>'; ;
    echo '<th style="width:14%; bacKground:#bc955c; color:white;" rowspan="2"><center>OBSERVACIONES</center></th>';
    echo "<th  rowspan='2' style='bacKground:#bc955c; color:white;'><center>REACTIVAR</center></th>";
    

    echo '</tr>';
    echo '<tr  bgcolor="#C0BDBD"  style="font-size:7pt;">';    
    echo '<td style="width:7%; bacKground:#bc955c; color:white;"><center><b>INICIO</b><center></td>';
    echo '<td style="width:7%;  bacKground:#bc955c; color:white;"><center><b>TERMINO</b><center></td>';  
    echo '<td style="width:6%; bacKground:#bc955c; color:white;"><center><b>FECHA</b><center></td>';  
    echo '<td style="width:5%; bacKground:#bc955c; color:white;"><center>%<center></td>';  


 
     
    echo '</tr>';
    
        //FILTRAR POR DIRECCION
        /* if(nitavu_dpto($nitavu)==1){
           
            $sql =" SELECT *, (CASE WHEN prioridad='A' THEN 0 WHEN prioridad='B' THEN 2 WHEN prioridad='M' THEN 1 END) as valorprioridad 
            FROM actividades_indicadores WHERE  Estatus=3  ORDER BY IdDireccion, valorprioridad";
        }else{
          
            $sql =" SELECT *, (CASE WHEN prioridad='A' THEN 0 WHEN prioridad='B' THEN 2 WHEN prioridad='M' THEN 1 END) as valorprioridad 
            FROM actividades_indicadores WHERE IdDireccion = ".nitavu_dpto($nitavu)."  ORDER BY IdDireccion, valorprioridad";
           
        }
 */
        if (nitavu_dpto_nivel($nitavu)=='dir'){ 
          //  $sql="Select * from  actividades_dpto where Estatus=3 and IdDireccion=".quienEsmiDireccion(nitavu_dpto($nitavu))." ORDER BY IdDepartamento";
          $sql="Select * from  actividades_dpto INNER JOIN cat_gerarquia on actividades_dpto.IdDepartamento=cat_gerarquia.id where actividades_dpto.IdDireccion=19 
          and (cat_gerarquia.nombre like '%".$search."%' or actividades_dpto.Actividad like '%".$search."%' or actividades_dpto.Tema like'%".$search."%')  and Estatus=3 ";
       // echo $sql;
        }else{
            $sql="Select * from  actividades_dpto where Estatus=3 and IdDepartamento=".nitavu_dpto($nitavu)." ORDER BY IdDepartamento";
        } 
      
//echo $sql;
        $r= $conexion -> query($sql);
        while($f = $r -> fetch_array()) {
            $color = color_catjerarquia($f['IdDepartamento']);
            echo "<tr></tr>";
        
                
                echo "<td style='vertical-align: middle;color:black; background:".color_catjerarquia($f['IdDepartamento'])."'><b>".$f['IdActividad']."</b></td>";
      //          echo "<td><b>".$f['informedegobierno']."</b></td>";
           
        //        echo "<td style='font-size:13px; color: ".colorbar_catjerarquia($f['IdDireccion'])."'><b><center>".$f['prioridad']."</center></b></td>";
                echo "<td>".$f['Tema']."</td>";
                if (porcentajeActividadDpto($f['IdActividad'])==100 ){                  
                    echo "<td style='color:#7C787E; ' ><b><del>".$f['Actividad']."</del></b><br>
                <a href='#modalHistorial".$f['IdActividad']."' rel='MyModal:open' style='font-size:13px;'>Historial actividades";
                } else{
                    echo "<td><b>".$f['Actividad']."</b><br>
                    <a href='#modalHistorial".$f['IdActividad']."' rel='MyModal:open' style='font-size:13px;'>Historial actividades";
                }

                                  /*MODAL   HISTORIAL*/
                        echo "<div id='modalHistorial".$f['IdActividad']."' class='MyModal' >"; 
                        echo '<h1 class="card-header h5" style="text-transform: uppercase;font-size: 10pt;">'.$f['Actividad'].'</h1><br>';
                        $sql2="select * from historial_actividades_dpto  where IdActividad=".$f['IdActividad'];              
                        echo '<table class="tabla_punteada tabla">
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
                        //     echo ' <td>'.$v["Id"] .'</td>';
                        //    // echo ' <td>'.$v["Fecha"] .'</td>';                        
                        //     echo ' <td>'.$v["Comentario"] .'</td>';   
                        //     echo ' <td>'.$v["Avance"] .'%</td>';        
                            
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
                echo "</a>";
                echo "</td>";
                echo "<td style='vertical-align: middle; ';><b><center>".$f['meta']."</center></b></td>";
                if($f['Estatus']== 3){
                    echo '<td style="vertical-align: middle;"><img src="icon/ok.png" style="width:40px;"></td>';
                }else{
                    echo "<td></td>";
                }
           
                echo '<td style="vertical-align: middle;"> <center>
                
                <div class="progress progress-blue"><span style="width: '.$f['Avance'].'%; background-color: '.colorbar_catjerarquia($f['IdDepartamento']).';"><b>'.$f['Avance'].'%</b></span></div>
                
               ';
               if ($f['Estatus']!= 1){ 

                
               }
               
                echo "<td>".date_format(date_create(FechaultimoavanceDpto($f['FechaInicio'])), 'd-m-y')."</td>";
                echo "<td>".date_format(date_create(FechaultimoavanceDpto($f['FechaTermino'])), 'd-m-y')."</td>";
                                              
            echo "<td>".date_format(date_create(FechaultimoavanceDpto($f['IdActividad'])), 'd-m-y')."</td>";               
                
            echo "<td>".porcentajeActividad($f['IdActividad'])."</td>";
                                
                $nombreDpto = DptoNombre($f['IdDepartamento']);//DptoNombreCorto($f['IdDepartamento']);
                $encargado = titular($f['IdDireccion']);
                $nombreencargado = nitavu_nombre($encargado);
                echo "<td>". $nombreDpto."</td>";
                $ultimocomentario=UltimaObservacionDpto($f['IdActividad']);
                echo "<td style='font-size:13px'><b>".$ultimocomentario."</b></td>";


                 echo "<td style='vertical-align: middle;'><a class='pc'  href='indicadores_actterminadas_dpto.php?reactiva=".$f['IdActividad']."'   title='Archivar la actividad'>";
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
    window.location.href='indicadores_actterminadas_dpto.php?reactiva='+actividad;
 }


// $(function()
// {
// $('.slider').on('input change', function(){
//           $(this).next($('.slider_label')).html(this.value);
//         });
//       $('.slider_label').each(function(){
//           var value = $(this).prev().attr('value');
//           $(this).html(value);
//         });  

  
// })





$("body").on("keydown", "input, select, textarea", function(e) {
  var self = $(this),
    form = self.parents("form:eq(0)"),
    focusable,
    next;
  
  // si presiono el enter
  if (e.keyCode == 13) {
    // busco el siguiente elemento
    focusable = form.find("input,a,select,button,textarea").filter(":visible");
    next = focusable.eq(focusable.index(this) + 1);
   //console.log( next.name);
    // si existe siguiente elemento, hago foco
    if (next.length) {
     
     if( next.attr('id')=="beta_buscar_boton")
     {
        form.submit();
     } 
     next.focus();

    } else {
      // si no existe otro elemento, hago submit
      // esto lo podrías quitar pero creo que puede
      // ser bastante útil
      form.submit();
    }
    return false;
  }
});

</script>

</script>    

<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>


<?php include ("./lib/body_footer.php"); ?>
