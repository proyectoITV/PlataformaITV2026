<?php
//require("config.php");
include ("./lib/body_head.php"); include ("./lib/body_menu.php");
require_once('lib/laura_funciones.php');
require_once('lib/flor_funciones.php');
?>


<?php

//$nitavu = $_GET['nitavu'];


 $id_aplicacion = 'ap130';
// xd_update('ap130',$nitavu);//guarda la experiencia del usuario
// echo "<div id='AppDetalle'>".app_detalle($id_aplicacion, $nitavu)."</div>";
// //PROCESO PARA TOCAR LA PUERTA DE SAN PEDRO
 $nivel =aplicacion_nivel($id_aplicacion, $nitavu);
// echo "<input type='hidden' id='nitavu' name='nitavu' value='".$nitavu."'>";

//if (sanpedro($id_aplicacion, $nitavu)==TRUE)
//{

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

    echo "<a style='right: 70px; position: absolute; top: 50px; margin-top: 10px;font-size: 12px;' href='reporte_indicadores.php?nitavu=".$nitavu."&idrep=2' class='Mbtn btn-danger' title='Imprimir actividades en pdf' class='btn btn-link'>
    Imprimir</a>";    

//    echo '<div style="right: 220px; position: absolute; top: 50px;"   class="btn-group" role="group" aria-label="Basic example">
//         <button type="submit" class="btn btn-danger" href="#AgregarActividad" rel="MyModal:open" title="Agregar una nueva actividad general">AgregarActividad</button>
//         <button type="button" class="btn btn-danger">Middle</button>
//         <button type="button" class="btn btn-danger">Right</button>
//     </div>';

if(isset($_GET['reactiva'])){
    //if (isset($_GET['idactividad'])){
        $idactividad = $_GET['reactiva'];           

        $sql = "Update actividades_indicadores set 
            Estatus=1
            where IdActividad = ".$idactividad;
            if ($conexion->query($sql) == TRUE){ 
                mensaje('Se REACTIVO la actividad, podrá consultarla en el Historial','indicadores_dir.php');    
            }else{
                mensaje('Ocurrio un error al intentar REACTIVAR la actividad, favor de intentarlo nuevamente.','indicadores_dir.php');
            }   

        
    }    



    echo "<center>";
    echo "<div style='width:80%;'>";
    
    echo '<table class="table bordered" align="center" style="font-size: 14;">';
    echo '<tr bgcolor="#991204" style="font-size:8pt;">';
    echo '<th style="width:2%; bacKground:#bc955c; color:white;" rowspan="2">NO</th>';
    echo '<th style="width:3%; bacKground:#bc955c; color:white;" rowspan="2">INF<br>GOB</th>';
    echo '<th style="width:3%; bacKground:#bc955c; color:white;" rowspan="2">PRIOR.</th>';
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


    //echo "<th style='bacKground:#991204; color:white;'>Responsable </th>";
    //echo "<th style='bacKground:#991204; color:white;'>Observaciones </th>";
     
    echo '</tr>';
     /* echo "<thead style='bacKground:#991204; color:white;' >";
        echo "<th style='bacKground:#991204; color:white;'>N°</th>";
        echo "<th style='bacKground:#991204; color:white;'>INF. GOB.</th>";
        echo "<th style='bacKground:#991204; color:white;'>Prioridad</th>";
        echo "<th style='bacKground:#991204; color:white;'>Tema</th>";
        echo "<th style='bacKground:#991204; color:white;'>Actividad</th>";
        echo "<th style='bacKground:#991204; color:white;'>Meta</th>";
        echo "<th style='bacKground:#991204; color:white;'>Estatus</th>";
        echo "<th style='bacKground:#991204; color:white;'>Progreso</th>";
        echo "<th style='bacKground:#991204; color:white;'>Inicio </th>";
        echo "<th style='bacKground:#991204; color:white;'>Término</th>";
        echo "<th style='bacKground:#991204; color:white;'>Fecha </th>";
        echo "<th style='bacKground:#991204; color:white;'>% </th>";
        echo "<th style='bacKground:#991204; color:white;'>Responsable </th>";
        echo "<th style='bacKground:#991204; color:white;'>Observaciones </th>";
        if(nitavu_dpto($nitavu)==1){
          echo "<th colspan=2 style='bacKground:#991204; color:white;'><center>Acciones</center></th>";
        }
      echo "</thead>"; */
        //FILTRAR POR DIRECCION
        if(nitavu_dpto($nitavu)==1 or $nivel==2){
            //$sql ="select * from actividades_indicadores";
            $sql =" SELECT *, (CASE WHEN prioridad='A' THEN 0 WHEN prioridad='B' THEN 2 WHEN prioridad='M' THEN 1 END) as valorprioridad 
            FROM actividades_indicadores WHERE  Estatus=3  ORDER BY IdDireccion, valorprioridad";
        }else{
           // $sql ="select * from actividades_indicadores where IdDireccion = ".nitavu_dpto($nitavu)."";
            $sql =" SELECT *, (CASE WHEN prioridad='A' THEN 0 WHEN prioridad='B' THEN 2 WHEN prioridad='M' THEN 1 END) as valorprioridad 
            FROM actividades_indicadores WHERE IdDireccion = ".nitavu_dpto($nitavu)."  ORDER BY IdDireccion, valorprioridad";
            //and Estatus!=3
        }

      
//echo $sql;
        $r= $conexion -> query($sql);
        while($f = $r -> fetch_array()) {
            $color = color_catjerarquia($f['IdDireccion']);
            echo "<tr></tr>";
          //  echo "<tr style='background-color: ".$color."'>";
                
                echo "<td><b>".$f['IdActividad']."</b></td>";
                echo "<td><b>".$f['informedegobierno']."</b></td>";
               // style='vertical-align: middle; color: ".colorbar_catjerarquia($f['IdDireccion'])."'
                echo "<td style='font-size:13px; color: ".colorbar_catjerarquia($f['IdDireccion'])."'><b><center>".$f['prioridad']."</center></b></td>";
                echo "<td>".$f['Tema']."</td>";
                if (porcentajeActividad($f['IdActividad'])==100 ){
                   // echo "<td style='color:#7C787E; ' ><b><del>".$f['Tema']."</del></b></td>";
                    echo "<td style='color:#7C787E; ' ><b><del>".$f['Actividad']."</del></b><br>
                <a href='#modalHistorial".$f['IdActividad']."' rel='MyModal:open' style='font-size:13px;'>Historial actividades";
                } else{
                    echo "<td><b>".$f['Actividad']."</b><br>
                    <a href='#modalHistorial".$f['IdActividad']."' rel='MyModal:open' style='font-size:13px;'>Historial actividades";
                }

              //  echo "<td>".$f['Actividad']."<br>
              //  <a href='#modalHistorial".$f['IdActividad']."' rel='MyModal:open' style='font-size:12px;'>Historial actividades";

                                  /*MODAL   HISTORIAL*/
                        echo "<div id='modalHistorial".$f['IdActividad']."' class='MyModal' >"; 
                        echo '<h1 class="card-header h5" style="text-transform: uppercase;font-size: 10pt;">'.$f['Actividad'].'</h1><br>';
                        $sql2="select * from historial_actividades  where IdActividad=".$f['IdActividad'];
                        //echo $sql2;  echo $f['Actividad'];
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
                            // echo ' <tr>';    
                            // echo ' <td>'.$v["Id"] .'</td>';
                            // echo ' <td>'.$v["Fecha"] .'</td>';
                            // echo ' <td>'.$v["Comentario"] .'</td>';   
                            // echo ' <td>'.$v["Avance"] .'%</td>';          
                        
                            // echo ' </tr>';
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
                echo "</a>";
                echo "</td>";
                echo "<td style='vertical-align: middle; color: ".colorbar_catjerarquia($f['IdDireccion'])."';><b><center>".$f['meta']."</center></b></td>";
                if($f['Estatus']== 3){
                    echo '<td style="vertical-align: middle;"><img src="icon/ok.png" style="width:40px;"></td>';
                }else{
                    echo "<td></td>";
                }

                // <progress  id="file" max="100" value="'.$f['Avance'].'"> '.$f['Avance'].'% </progress> <label>'.$f['Avance'].'% </label>
                echo '<td style="vertical-align: middle;"> <center>
                
                <div class="progress progress-blue"><span style="width: '.$f['Avance'].'%; background-color: '.colorbar_catjerarquia($f['IdDireccion']).';"><b>'.$f['Avance'].'%</b></span></div>
                
               ';
               if ($f['Estatus']!= 1){ 

                //echo "<a href='#modalAvance' rel='MyModal:open' style='float: right!important; '><img src='icon/addRep.png' style='width:15px;'> </a></center></td>";
               }
               //echo $f['Estatus'];

                //echo "<td>".$f['FechaInicio']."</td>";
                //echo "<td>".$f['FechaTermino']."</td>";
                echo "<td>".date_format(date_create(Fechaultimoavance($f['FechaInicio'])), 'd-m-y')."</td>";
                echo "<td>".date_format(date_create(Fechaultimoavance($f['FechaTermino'])), 'd-m-y')."</td>";
                


                /*echo "<td>".$f['Avance']."
                <a href='#modalAvance' rel='MyModal:open'onclick='' style='  margin-top: -3px;  margin-left: 5px;' > <img src='icon/addRep.png' style='width:15px;'>";
                */
                /*MODAL   avance*/
                 /*   echo "<div id='modalAvance' class='MyModal' style='width:30%' >"; 
                    echo '<form action="guardarAvance.php" method="POST">';
                    echo "<center >";
                    echo '<h1 class="h5" style="text-transform: uppercase;font-size: 10pt;">'.$f['Actividad'].'</h1><br>';

                    echo "<div >";
                    echo '<input type="hidden" id="idactividad" name="idactividad" value='.$f['IdActividad'].'>';		
                    echo "<label for='avance' class='label'>Avance</label>";
                    
                    echo '<input type="number" id="avance" name="avance"  min="10" max="100" value='.obtenerAvance($f['IdActividad']).'>';





                echo "</div>";
                echo "</BR>";

                echo "<div >";			
                echo "<label for='comentario' class='label'>Observaciones</label>";
                echo "<textarea id='comentario' name='comentario' rows='3'  style='height:10%; width:100%'></textarea>";
                echo "</div>";
                echo "</BR>";
                
                echo "<input type='submit' value='Guardar'  class='btn btn-danger' style='color:white; width:100px;' name='btnGuardar' >";                 
                echo "</center>";
                echo "</form>";
                "</div>";*/

                //echo "</td>";


                //DIBUJAOS LA GRAFICA

              /*  ECHO '<script type="text/javascript">

                    google.charts.load("current", {packages:["corechart"]});
                    google.charts.setOnLoadCallback(drawChart);

                    function drawChart() {
                    var data = google.visualization.arrayToDataTable([
                        ["", "Avance", { role: "style" } ],
                        ["", '.$f['Avance'].', "color: #e5e4e2"]
                    ]);

                    var view = new google.visualization.DataView(data);
                    view.setColumns([0, 1,
                                    { calc: "stringify",
                                        sourceColumn: 1,
                                        type: "string",
                                        role: "annotation" },
                                    2]);

                    var options = {
                        title: "",
                        width: 100,
                        height: 50,
                        bar: {groupWidth: "100"},
                        legend: { position: "none" },
                    };
                    var chart = new google.visualization.BarChart(document.getElementById("barchart_values'.$f['IdActividad'].'"));
                    chart.draw(view, options);
                    }
                    </script>';*/
            // <div id="barchart_values'.$f['IdActividad'].'"></div>  style='margin-top: -3px; margin-left: 5px;' href='#modalAvance' rel='MyModal:open' 
               
                               
           

            echo "<td>".date_format(date_create(Fechaultimoavance($f['IdActividad'])), 'd-m-y')."</td>";

               
                
            echo "<td>".porcentajeActividad($f['IdActividad'])."</td>";
                
                
                
                
                $nombreDpto = DptoNombreCorto($f['IdDireccion']);
                $encargado = titular($f['IdDireccion']);
                $nombreencargado = nitavu_nombre($encargado);
                echo "<td>".$nombreDpto."</td>";
                $ultimocomentario=UltimaObservacion($f['IdActividad']);
                echo "<td style='font-size:13px'><b>".$ultimocomentario."</b></td>";


                 
                //si echo "<td  ><div class='form-check form-switch'><input class='form-check-input' type='checkbox' id='reactiva' onclick='reactiva(".$f['IdActividad'].") '></div></td>";        
                //                                                         //  href='indicadores_dir.php?idactividad=".$f['IdActividad']."'
                //  echo "<td style='vertical-align: middle;'><a class='pc'  href='indicadores_actterminadas.php?reactiva=".$f['IdActividad']."'   title='Archivar la actividad'>";
                //          echo "<img src='icon/ci.png' style='width:35px; padding:5px;'>";
                //     // echo  "<div class='form-check form-switch'><input class='form-check-input' type='checkbox' id='reactiva' ></div>";
                //  echo "</td>";

                 echo "<td style='vertical-align: middle;'><a class='pc'  href='indicadores_actterminadas.php?reactiva=".$f['IdActividad']."'   title='Archivar la actividad'>";
                 echo "<img src='icon/renovar.png' style='width:40px; padding:5px;'>";        



                                                                                                                            //onclick="window.location.href = 'test.php?Period=' + this.selectedIndex;"                                                                                                 
               // echo "<td  ><div class='form-check form-switch'><input class='form-check-input' type='checkbox' id='reactiva' onclick='window.location.href(indicadores_dir.php?reactiva=".$f['IdActividad'].")'></div></td>";
                //onclick='window.location.href(indicadores_dir.php?reactiva=".$f['IdActividad'].")'    
                //onClick='reactiva();'
               // echo "<td style='vertical-align: middle;'><a class='pc'  href='indicadores_dir.php?idactividad=".$f['IdActividad']."'   title='Archivar la actividad'>";
               // echo "<img src='icon/ci.png' style='width:35px; padding:5px;'>";                    



                //<input class='form-check-input' type='checkbox' id='elimina' onClick=noincremento('".$lotes['idLote']."','".$lotes['NumContrato']."');>

                // if(nitavu_dpto($nitavu)==1){  

                //     echo "<td style='vertical-align: middle;'>";                    
                //     echo "<a class='pc' href='#add".$f['IdActividad']."' rel='MyModal:open' title='Editar la actividad'>";                                  
                //     echo "<img src='icon/editar.png' style='width:35px; padding:5px; '>";                    
                //     echo "</a>"; 

                //     if (porcentajeActividad($f['IdActividad'])==100 ){
                //         echo "<td style='vertical-align: middle;'><a class='pc'  href='indicadores_dir.php?idactividad=".$f['IdActividad']."'   title='Archivar la actividad'>";
                //          echo "<img src='icon/ci.png' style='width:35px; padding:5px;'>";
                //     }else{
                 
                //     echo "<td style='vertical-align: middle;'><a class='pc'  href='#addelim".$f['IdActividad']."' rel='MyModal:open'  title='Eliminar la actividad'>";
                //     echo "<img src='icon/eliminar.png' style='width:35px; padding:5px;'>";
                            
                //     }        
                //     echo "</a></td>"; //</table>
                //     echo "</td>";
                // }
            echo "</tr>";
        }
    echo "</table>";
    
    echo "</div>";

    echo "</center>";

    echo "</div>";

    
   
        
   

//{
//    mensaje("No tiene acceso a esta aplicacion",'');
//}



?>
<script>
 function reactiva(actividad){
    alert('se reactivo actividad'+ actividad );
    //window.location.href=indicadores_dir.php?reactiva=+actividad;
    //window.location='indicadores_dir.php?reactiva='+actividad;
    window.location.href='indicadores_actterminadas.php?reactiva='+actividad;
 }
</script>    

<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>


<?php include ("./lib/body_footer.php"); ?>
