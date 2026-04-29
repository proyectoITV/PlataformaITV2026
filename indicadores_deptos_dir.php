<?php
//require("config.php");
include ("./lib/body_head.php"); include ("./lib/body_menu.php");
require_once('lib/laura_funciones.php');
require_once('lib/yes_funciones.php');
?>
<script >
$(function()
{
$('.slider').on('input change', function(){
          $(this).next($('.slider_label')).html(this.value);
        });
      $('.slider_label').each(function(){
          var value = $(this).prev().attr('value');
          $(this).html(value);
        });  

  
})


// document.getElementById('beta_buscar_input').addEventListener('keydown', inputCharacters);

// function inputCharacters(event) {
 
//   if (event.keyCode == 13) {
//     form.submit();
//     }
//   }




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
        next.focus();
     if( next.attr('id')=="beta_buscar_boton")
     {
        form.submit();
     } 
   

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

<?php


$id_aplicacion = 'ap131';
xd_update('ap131',$nitavu);//guarda la experiencia del usuario
echo "<div id='AppDetalle'>".app_detalle($id_aplicacion, $nitavu)."</div>";
//PROCESO PARA TOCAR LA PUERTA DE SAN PEDRO
$nivel =aplicacion_nivel($id_aplicacion, $nitavu);
echo "<input type='hidden' id='nitavu' name='nitavu' value='".$nitavu."'>";

if (sanpedro($id_aplicacion, $nitavu)==TRUE)
{

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
     echo "<div>";
        echo "<br><br><br><br>";
        echo "<table style='width:80%;'>";
            echo "<tr >";
            echo '<td  style="vertical-align: middle; width:110px"><img src="img/logot.png" style="width:110px;">'; //style="width:110px;
            echo "</td><td>";
           // echo "<h2 style=''>INSTITUTO TAMAULIPECO DE VIVIENDA Y URBANISMO</h2>";
            echo "</td>";
            //echo "<tr>";
            echo '<td ></td>';            
            echo "<td><h2 style='font-size: 26px;'>ACTIVIDADES POR DEPARTAMENTOS</h2>";

            ECHO "<h1 class='card-header h5' style='text-transform: uppercase;font-size: 10pt; color: #ab0033;'>".nitavu_dpto_nombre($nitavu)."</h1>";
            echo "</td></tr>";
        echo "</table>";
        echo "<br><br>";
    echo "</div>"; 
    echo "</center>";
     echo "<a style='right: 220px; position: absolute; top: 50px; margin-right: 10px;margin-top: 10px; font-size: 12px;' href='#AgregarActividad' rel='MyModal:open'  class='Mbtn btn-danger' title='Agregar una nueva actividad general' class='btn btn-link'>
     Agregar Actividad</a>";
     
     echo "<a style='right: 150px; position: absolute; top: 50px; margin-top: 10px;font-size: 12px;'  href='indicadores_actterminadas_dpto.php'  class='Mbtn btn-danger' title='Ver el historial de actividades' class='btn btn-link'>
     
     Historial</a>";
     echo "<a style='right: 70px; position: absolute; top: 50px; margin-top: 10px;font-size: 12px;' href='reporte_indicadores.php?nitavu=".$nitavu."&idrep=3&ss=".$search."' class='Mbtn btn-danger' title='Imprimir actividades en pdf' class='btn btn-link'>
     Imprimir</a>";

     if (nitavu_dpto_nivel($nitavu)=='dir'){  
     echo "<center>"; 
     echo "<div style='width:80%;'>"; 
     buscarSinRequired('indicadores_deptos_dir.php','Busqueda por Departamento, Actividad o Tema','');
     echo "</div>"; 
     echo "</center>"; 
     }
     // historia($nitavu, "Entro a buscar un empleado");
  
 
  
  
  





    if(isset($_GET['idactividad'])){
    
            $idactividad = $_GET['idactividad'];           

            $sql = "Update actividades_dpto set 
                Estatus=3
                where IdActividad = ".$idactividad;
                if ($conexion->query($sql) == TRUE){ 
                    mensaje('Se archivo con éxito la actividad, podrá consultarla en el Historial','indicadores_deptos_dir.php');    
                }else{
                    mensaje('Ocurrio un error al intentar archivar la actividad, favor de intentarlo nuevamente.','indicadores_deptos_dir.php');
                }           
    }



    if(isset($_GET['IdActEnv'])){
 
        $idactividad = $_GET['IdActEnv'];           

        $sql = " INSERT INTO actividades_indicadores(Tema,Actividad,meta,FechaInicio,FechaTermino,IdDireccion,IdDepartamento,Avance,Comentarios,Estatus,nitavu,IdActividadDpto) 
        SELECT Tema,Actividad,meta,FechaInicio,FechaTermino,IdDireccion,IdDepartamento,Avance,Comentarios,Estatus,nitavu,IdActividad FROM actividades_dpto
        WHERE IdActividad= ".$idactividad;
        //echo $sql; 
            if ($conexion->query($sql) == TRUE){ 

                      $sql2 = " Update  actividades_dpto set Estatus=4          WHERE IdActividad= ".$idactividad;
                    //echo $sql2; 
                        if ($conexion->query($sql2) == TRUE){ 
                            
                            mensaje('Se envió con exito la actividad a las Actividades Relevantes del ITAVU','indicadores_deptos_dir.php');    
                        }else{
                            mensaje('Ocurrio un error al enviar  la actividad a las Actividades Relevantes del ITAVU, favor de intentarlo nuevamente.','indicadores_deptos_dir.php');
                        }   
              
            }else{
                mensaje('Ocurrio un error al enviar  la actividad a las Actividades Relevantes del ITAVU, favor de intentarlo nuevamente.','indicadores_deptos_dir.php');
            }           
}

      echo "<center>";

      echo "<br>";
      //echo "</div>";
      echo "<br>";
    echo "<div style='width:80%;'>";  
    echo '<table class="table bordered " align="center" style="font-size: 14; vertical-align: middle;">'; //class="table bordered" table table-bordered
    echo '<tr  style="border-color=#F93308; "  >'; //bgcolor="white" bacKground:white;  border:ridge
    echo '<th style="width:2%; font-size:8pt; color: white;background: #B40404;  border: 1px solid #ccc;  border-bottom: 2px solid #ccc;"      rowspan="2">NO</th>'; //bacKground:#E75F54;
   // echo '<th style="width:3%; background:white; color:black;  border: 1px solid #ccc;  border-bottom: 2px solid #ccc;" rowspan="2">INF<br>GOB</th>';

  //echo '<th style="width:3%; background:#bc955c; color:black; border: 1px solid #ccc;  border-bottom: 2px solid #ccc;" rowspan="2">PRIOR.</th>';

    echo '<th style="width:12%; color: white;background: #B40404; border: 1px solid #ccc;  border-bottom: 2px solid #ccc;" rowspan="2"><center>TEMA</center></th>';
    echo '<th style="width:18%; color: white;background: #B40404; border: 1px solid #ccc;  border-bottom: 2px solid #ccc;" rowspan="2"><center>ACTIVIDAD</center></th>';
    echo '<th style="width:4%; color: white;background: #B40404; border: 1px solid #ccc;  border-bottom: 2px solid #ccc;" rowspan="2">META</th>';
    echo '<th style="width:2%; color: white;background: #B40404; border: 1px solid #ccc;  border-bottom: 2px solid #ccc;" rowspan="2"><center>OK</center></th>'; 
  
    echo '<th style="width:6%; color: white;background: #B40404; border: 1px solid #ccc;  border-bottom: 2px solid #ccc;"   rowspan="2">PROGRESO</th>';
    echo '<th colspan="2" style="width:13%; color: white;background: #B40404; border: 1px solid #ccc;  border-bottom: 1px solid #ccc;"><center>PROGRAMA</center></th>';

    echo '<th colspan="2" style="width:13%;  color: white;background: #B40404; border: 1px solid #ccc;  border-bottom: 1px solid #ccc;"><center>AVANCE ACUM.</center></th>';

    echo '<th style="width:10%; color: white;background: #B40404; border: 1px solid #ccc;  border-bottom: 2px solid #ccc;" rowspan="2"><center>RESPONSABLE</center></th>'; ;

    echo '<th style="width:14%;  color: white;background: #B40404; border: 1px solid #ccc;  border-bottom: 2px solid #ccc;" rowspan="2"><center>OBSERVACIONES</center></th>';

      //if(nitavu_dpto($nitavu)==1){
         
         echo "<th colspan=3 rowspan='2' style=' color: white;background: #B40404; border: 1px solid #ccc;  border-bottom: 2px solid #ccc;'><center>ACCIONES</center></th>";
    // }

    echo '</tr>';
    echo '<tr   style="font-size:7pt;">';   
    echo '<td style="width:7%;  color: white;background: #B40404; border: 1px solid #ccc;  border-bottom: 2px solid #ccc;" ><center><b>INICIO<center></b></td>';
    echo '<td style="width:7%;   color: white;background: #B40404; border: 1px solid #ccc;  border-bottom: 2px solid #ccc;"><center><b>TERMINO<center></b></td>';  

    echo '<td style="width:8%;  color: white;background: #B40404; border: 1px solid #ccc;  border-bottom: 2px solid #ccc; "><center><b>FECHA</b><center></td>';  
    echo '<td style="width:5%;  color: white;background: #B40404; border: 1px solid #ccc;  border-bottom: 2px solid #ccc; "><center><b>%</b></center></td>';  
  
    echo '</tr>';


        if (nitavu_dpto_nivel($nitavu)=='dir'){            
            // $sql="Select * from  actividades_dpto where IdDireccion=".quienEsmiDireccion(nitavu_dpto($nitavu))
            // ." and Estatus not in (2,3) and ".
            
            // ." ORDER BY IdDepartamento";
            $direc=quienEsmiDireccion(nitavu_dpto($nitavu));
            //$sql=" Select * from  actividades_dpto INNER JOIN cat_gerarquia on actividades_dpto.IdDepartamento=cat_gerarquia.id where actividades_dpto.IdDireccion=19
            $sql=" Select * from  actividades_dpto INNER JOIN cat_gerarquia on actividades_dpto.IdDepartamento=cat_gerarquia.id where actividades_dpto.IdDireccion=". $direc."
            
            and (cat_gerarquia.nombre like '%".$search."%' or actividades_dpto.Actividad like '%".$search."%' or actividades_dpto.Tema like'%".$search."%')  and Estatus not in (2,3) ";
          
        }else{
            $sql="Select * from  actividades_dpto where IdDepartamento=".nitavu_dpto($nitavu)." and Estatus not in (2,3)  ORDER BY IdDepartamento";
        } 

//echo $sql;
        $conexion->set_charset('utf8mb4');
        $r= $conexion -> query($sql);
        while($f = $r -> fetch_array()) {
            $color = color_catjerarquia($f['IdDireccion']);
            echo "<tr></tr>";
                     
                echo "<td style='vertical-align: middle;color:black; background:".color_catjerarquia($f['IdDepartamento']).";'><center><b>".$f['IdActividad']."</b></center></td>";
                //echo "<td><center><b>".$f['informedegobierno']."</b></center></td>";      
                //echo "<td style='font-size:13px; color: ".colorbar_catjerarquia($f['IdDireccion'])."'><b><center>".$f['prioridad']."</center></b></td>";
                echo "<td>".$f['Tema']."</td>";
                if (porcentajeActividadDpto($f['IdActividad'])==100 ){               
                    echo "<td style='color:#7C787E; ' ><b><del>".$f['Actividad']."</del></b><br>
                <a href='#modalHistorial".$f['IdActividad']."' rel='MyModal:open' style='font-size:11px;'>Historial actividades";
                } else{
                    echo "<td><b>".$f['Actividad']."</b><br>
                    <a href='#modalHistorial".$f['IdActividad']."' rel='MyModal:open' style='font-size:11px;'>Historial actividades";
                }

                                  /*MODAL   HISTORIAL*/
                        echo "<div id='modalHistorial".$f['IdActividad']."' class='MyModal' >"; 
                        echo '<h1 class="card-header h5" style="text-transform: uppercase;font-size: 10pt; color: #ab0033;">'.$f['Actividad'].'</h1><br>';
                        $sql2="select * from historial_actividades_dpto  where IdActividad=".$f['IdActividad'];
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
                echo "</a>";
                echo "</td>";
                echo "<td style='vertical-align: middle; font-size:12px; ';><b><center>".$f['meta']."</center></b></td>";
                if($f['Estatus']== 1){
                    echo '<td style="vertical-align: middle;"><img src="icon/ok.png" style="width:25px;"></td>';
                }else{
                    echo "<td></td>";
                }

                echo '<td style="vertical-align: middle;"> <center>
                
                <div class="progress progress-blue"><span style="width: '.$f['Avance'].'%; background-color: '.colorbar_catjerarquia($f['IdDepartamento']).';"><b>'.$f['Avance'].'%</b></span></div>
                
               ';
               if ($f['Estatus']!= 1){ 

                echo "<a href='#modalAvance".$f['IdActividad']."' rel='MyModal:open' style='float: right!important; '><img src='icon/addRep.png' style='width:15px;'> </a></center></td>";
               }
    
                echo "<td style='font-size:12px'><center>".date_format(date_create($f['FechaInicio']), 'd-m-y')."</center></td>";
                echo "<td style='font-size:12px'><center>".date_format(date_create($f['FechaTermino']), 'd-m-y')."</center></td>";            

                /*MODAL   avance*/

                    echo "<div id='modalAvance".$f['IdActividad']."' class='MyModal' style='width:30%' >"; 
                    echo '<form action="guardarAvanceDpto.php" method="POST">';
                    echo "<center >";
                    echo '<h1 class="h5" style="text-transform: uppercase;font-size: 10pt; color: #ab0033;">'.$f['Actividad'].'</h1><br>';

                    echo "<div >";
                    echo '<input type="hidden" id="idactividad" name="idactividad" value='.$f['IdActividad'].'>';	
                    
                    echo "<label class='label'>Avance actual</label><br>";	
                    echo '<b><label style="font-size: 12pt; color:'.colorbar_catjerarquia($f['IdDireccion']).'">'.obtenerAvanceDpto($f['IdActividad']).'%</label></b><br><br>';

                    echo "<b><label for='avance' class='label'>Seleccione el nuevo avance</label></b><br>";
                    
                    echo '<input type="number" id="avance" name="avance"  min="0" max="100" value='.obtenerAvanceDpto($f['IdActividad']).' style="width: 70px; font-size: 13pt; text-align: center" >%<br>' ;

                    echo "<label>Fecha nuevo avance</label><br><input type='date' id='fechaavance' name='fechaavance' style='width: 130px;' value='".$fecha."' >";
                     //


                  
                   //----
                
                   
                echo "</div>";
                echo "</BR>";

                echo "<div >";			
                echo "<label for='comentario' class='label'>Observaciones</label>";
                //echo "<textarea id='comentario' name='comentario' rows='3'  style='height:10%; width:100%'></textarea>";
                
                echo "<p class='emoji-picker-container'>
                <textarea class='input-field' data-emojiable='true' data-emoji-input='unicode'  style='height: 200px;width: 100%;'
                type='text' name='comentario' id='comentario' placeholder='Agregue su mensaje'></textarea>
                </p>";
                echo "</div>";

                echo "</BR>";       
                echo "<input type='submit' value='Guardar'  class='btn btn-danger' style='color:white; width:100px;' name='btnGuardar' >";                 
                echo "</center>";
                echo "</form>";
                "</div>";
            if  (FechaultimoavanceDpto($f['IdActividad'])){   
                echo "<td style='width:200px; font-size:12px'><center><b>".date_format(date_create(FechaultimoavanceDpto($f['IdActividad'])), 'd-m-y')."</b></center></td>";
            }else{
                echo "<td style='width:200px; font-size:12px'><center><b></b></center></td>";
            }    
            echo "<td><center><b>".porcentajeActividadDpto($f['IdActividad'])." </b></center></td>";
                
               // $nombreDpto = nitavu_dpto_nombre($f['nitavu']);
                //$nombreDpto = DptoNombreCorto($f['IdDireccion']);
                $encargado = titular($f['IdActividad']);
                $nombreencargado = nitavu_nombre($encargado);
                $nombreDpto=DptoNombre($f['IdDepartamento']);
               // echo "<td >".$nombreDpto."</td>";
               echo "<td style='vertical-align: middle;';><b><center>".$nombreDpto."</center></b></td>";
                $ultimocomentario=UltimaObservacionDpto($f['IdActividad']);
               
                //-
                // <p class='emoji-picker-container'>
                // <textarea class='input-field' data-emojiable='true' data-emoji-input='unicode'  style='height: 200px;width: 100%;'
                // type='text' name='ncomentarios' id='ncomentarios' placeholder='Agregue su mensaje'>".$f['Comentarios']."</textarea>
                // </p>
                //-

                if ( UltimaObservacionDpto($f['IdActividad'])==''){
                    echo "<td style='font-size:13px'><b>".$f['Comentarios']."</b></td>";
                    
                }else{
                    echo "<td style='font-size:13px'><b>".$ultimocomentario."</b></td>";
                }

               // $revisa=RevisaEditaActividad($f['IdActividad']);

                
               // if(nitavu_dpto($nitavu)==1 || RevisaEditaActividad($f['IdActividad'])==null){    
                    echo "<td style='vertical-align: middle; border: 0px solid #f8f9fa; border-left: 1px solid #ccc; border-top: 1px solid #ccc; border-right: 1px solid #fff;'>";
                    echo "<a class='pc' href='#add".$f['IdActividad']."' rel='MyModal:open' title='Editar la actividad'>";
                    echo "<img src='icon/editar.png' style='width:35px; padding:5px; '>";

                    //--
                            ///MODAL MODIFICAR
                    if(isset($_POST['btnGuardarM'])){
                        $idactividad = $_POST['idactividad'];
                     //   $informegob = $_POST['informegob'];
                       // $prioridad = $_POST['prioridad'];
                        $tema = $_POST['tema'];
                        $actividad = $_POST['vactividad'];
                        $meta = $_POST['meta'];
                        $fechainicio = $_POST['fechainicio'];
                        $fechatermino = $_POST['fechatermino'];
                       // $iddireccion = $_POST['iddireccion'];
                        $comentarios = $_POST['ncomentarios'];


                       // informedegobierno = ".$informegob."
                       //    , prioridad = '".$prioridad."'
                        $sql = "Update actividades_dpto set 
                            
                             Tema = '".$tema."'
                            , Actividad = '".$actividad."'
                            , meta = ".$meta."
                            , FechaInicio = '".$fechainicio."'
                            , FechaTermino = '".$fechatermino."'
                            
                            , Comentarios = '".$comentarios."'
                            where IdActividad = ".$idactividad;

                        // echo $sql;     
                        if ($conexion->query($sql) == TRUE){ 
                            mensaje('Se ha modificado la actividad '.$idactividad.' con éxito','indicadores_deptos_dir.php');
                        }else{
                            mensaje('Ocurrio un error al intentar modificar el registro, favor de intentarlo nuevamente.'.$sql,'indicadores_deptos_dir.php');
                        }                    
                    }  else{ 
                        echo "<div id='add".$f['IdActividad']."' class='MyModal' style='width: 50%; height: 80%;'>
                        <form action='indicadores_deptos_dir.php' method='POST'>
                        <a  rel='MyModal:close' class='close-modal'></a>
                        <h3 style='color: #ab0033;'>Modificar Actividad ".$f['IdActividad']." </h3>";

                        echo "<input type='text' id='idactividad' name='idactividad' value = '".$f['IdActividad']."' hidden>";

                        echo "<center><table style='width:70%; style='font-size: 12;'>";
                      
                        echo "<tr><td>";
                        echo "<div id='direcciones'><label style='font-size: 12; '>Departamento</label></td>";
                        //deberia ser f['nitavu'] ??
                        //echo "<td><label style='font-size: 12; '>".nitavu_dpto_nombre($nitavu)."</label></td>";
                        echo "<td><label style='font-size: 12; '>".DptoNombre($f['IdDepartamento'])."</label></td>";
                        echo "</tr>";    

                        echo "<tr>";
                        echo "<td><label>Tema</label><br></td>";
                        echo "<td><input type='text'  style='font-size: 12; ' id='tema' name='tema' value = '".$f['Tema']."'></td>";
                        echo "</tr>";
                        echo "<tr>";
                        echo "<td><label>Actividad</label><br></td>";
                        echo "<td><textarea style='height:60px;  font-size: 12; ''; placeholder='' name='vactividad' >".$f['Actividad']."</textarea></td>";
                        echo "</tr>";
                        echo "<tr>";
                        echo "<td><label>Meta</label><br></td>";
                        echo "<td><input type='number' id='meta' name='meta' min='1' style='font-size: 12; ' value = '".$f['meta']."'></td>";
                        echo "</tr>";
                        echo "<tr>";
                        echo "<td><label>Fecha inicio</label><br></td><td><input type='date' id='fechainicio' name='fechainicio' style='font-size: 12; ' value = '".$f['FechaInicio']."'></td>";
                        echo "</tr>";
                        echo "<tr>";
                        echo "<td><label>Fecha termino</label><br></td><td><input type='date' id='fechatermino' name='fechatermino' style='font-size: 12; ' value = '".$f['FechaTermino']."'></td>";
                        echo "</tr>";
                    
                        echo "<tr>";
                        echo "<td><label style='font-size: 12; '>Comentarios</label></td>";                                    
                        //echo "<td><textarea style='height:60px; font-size: 12; ' name='ncomentarios' >".$f['Comentarios']."</textarea></td>";
                        echo "<td>
                        <p class='emoji-picker-container'>
                        <textarea class='input-field' data-emojiable='true' data-emoji-input='unicode'  style='height: 150px;width: 100%;'
                        type='text' name='ncomentarios' id='ncomentarios' placeholder='Agregue su mensaje'>".$f['Comentarios']."</textarea>
                        </p>                        
                        </td>";
                        echo "</tr>";    

                        echo "</table></center>";
                        echo '<center><button type="submit"  name="btnGuardarM" id="btnGuardarM" class="btn btn-danger">Guardar</button></center>';     
                        echo "</form></div>";
                    }
                    //--
                    echo "</a>"; 

                    if (porcentajeActividadDpto($f['IdActividad'])==100 ){
                        echo "<td style='vertical-align: middle;'><a class='pc'  href='indicadores_deptos_dir.php?idactividad=".$f['IdActividad']."'   title='Archivar la actividad'>";
                         echo "<img src='icon/ci.png' style='width:35px; padding:5px;'>";
                    }else{
                    echo "<td style='vertical-align: middle; border: 0px solid #f8f9fa; border-left: 1px solid #ccc; border-top: 1px solid #ccc; border-right: 1px solid #fff;'><a class='pc'  href='#addelim".$f['IdActividad']."' rel='MyModal:open'  title='Eliminar la actividad'>";
                    echo "<img src='icon/eliminar.png' style='width:35px; padding:5px;'>";
                             //--MODAL ELIMINAR
                            if(isset($_POST['btnGuardarElim'])){
                                $idactividad = $_POST['idactividad'];           

                                $sql = "Update actividades_dpto set 
                                    Estatus=2
                                    where IdActividad = ".$idactividad;

                                if ($conexion->query($sql) == TRUE){ 
                                    mensaje('Se ha eliminado la actividad '.$idactividad.' con éxito','indicadores_deptos_dir.php');
                                }else{
                                    mensaje('Ocurrio un error al intentar eliminar la actividad, favor de intentarlo nuevamente.','indicadores_deptos_dir.php');
                                }                    
                            }  else{ 
                                
                                echo "<div id='addelim".$f['IdActividad']."' class='MyModal' style='width: 50%; height: 80%;'>
                                <form action='indicadores_deptos_dir.php' method='POST'>
                                <a  rel='MyModal:close' class='close-modal'></a>
                                <h3 style='color: #ab0033;'>Eliminar Actividad ".$f['IdActividad']." </h3>";

                                echo "<input type='text' id='idactividad' name='idactividad' value = '".$f['IdActividad']."' hidden> ";

                                echo "<center><table style='width:70%;'>";
                                echo "<tr><td>";
                        
                                echo "<div id='direcciones'><label style='font-size: 14; '>Departamento a cargo de la actividad</label></td>";
                                // echo "<td><select name='iddireccion'  class='form-select'  aria-label='Default select example' style='width:91%; font-size: 14;' id='iddireccion'  onchange='ShowSelected();' disabled>"; 
                                //     $sql="";
                                //     $sql = "SELECT * FROM cat_gerarquia where nivel='dir' ";
                                //     $v = $conexion -> query($sql);
                                //     while($vv = $v -> fetch_array()){ 
                                //         echo "<option value='".$vv['id']."' >".$vv['NomCorto']. "</option>";
                                //     }  
                                // echo "<option value='".$f['IdDireccion']."' selected>".buscaidconceptocx('NomCorto', 'cat_gerarquia','id', $f['IdDireccion'] ? $f['IdDireccion']  : '0' )."</option>";
                                //                                                                             // $campo, $tabla,$campoigual, $idconcepto
                                // echo "</select> </td> ";      
                                echo "<td><label style='font-size: 12; '>".DptoNombre($f['IdDepartamento'])."</label></td>";
                                echo "</tr>";                                
                                // echo "<tr>";
                                // echo "<td><label style='font-size: 13; '>Nivel de prioridad</label></td>";
                                // echo "<td><select id='prioridad' name='prioridad' class='form-select' aria-label='Default select example'  style='width: 130px' disabled>
                                //     <option value='A'>Alta</option>
                                //     <option value='M'>Media</option>
                                //     <option value='B'>Baja</option>";
                                //     if ($f['prioridad']=='A') {echo "<option value='".$f['prioridad']."' selected>Alta</option>";}
                                //     if ($f['prioridad']=='M') { echo "<option value='".$f['prioridad']."' selected>Media</option>";}
                                //     if ($f['prioridad']=='B') { echo "<option value='".$f['prioridad']."' selected>Baja</option>";}
                                // echo "</select></td></tr>";
                                
                                echo "<tr>";
                                echo "<td><label>Tema</label><br></td>";
                                echo "<td><label>".$f['Tema']."</label><br></td>";                                
                                echo "</tr>";
                                echo "<tr>";
                                echo "<td><label>Actividad</label><br></td>";
                                echo "<td><b><label style='height:60px;'>".$f['Actividad']."</label></b></td>";                                
                                echo "</tr>";                                
                                echo "<tr>";
                                echo "<td><label>Fecha inicio</label><br></td><td><input type='date' id='fechainicio' name='fechainicio' value = '".$f['FechaInicio']."' disabled></td>";
                                echo "</tr>";
                                echo "<tr>";
                                echo "<td><label>Fecha termino</label><br></td><td><input type='date' id='fechatermino' name='fechatermino' value = '".$f['FechaTermino']."' disabled></td>";
                                echo "</tr>";                            
                                echo "</table></center>";
                                echo '<center><button type="submit"  name="btnGuardarElim" id="btnGuardarElim" class="btn btn-danger">Eliminar</button></center>';     
                                echo "</form></div>";
                            }
        //-- FIN MODAL ELIMINAR
                    }        
                    echo "</a></td>"; 
                    echo "</td>";
                    // si es un director y la actividad no se escalo a actividades de direccion general
                    if (nitavu_dpto_nivel($nitavu)=='dir' and $f['Estatus']!=4){   
                    echo "<td style='vertical-align: middle;'border-left: 1px solid #ccc; border-top: 1px solid #ccc; border-right: 1px solid #ccc;'>";
                    echo "<a class='pc' href='indicadores_deptos_dir.php?IdActEnv=".$f['IdActividad']."'  title='Enviar a Actividad a Actividades Generales'>";
                    echo "<img src='icon/enviarRep.png' style='width:35px; padding:5px; '>";
                    echo "</td>";
                    }
                }
            echo "</tr>";
        //}  //termina
    echo "</table>";
    
    echo "</div>";

    echo "</center>";

    echo "</div>";

                //aqui esta el modal 
            //aqui esta el modal de alta de actividad
            if(isset($_POST['btnGuardarA'])){
                
               /*  $informe=$_POST['informegob'];
                if(nitavu_dpto($nitavu)==1){
                    $prioridad='';
                }else{
                    $prioridad=$_POST['prioridad'];
                }    */ 
                $tema=$_POST['tema'];
                $actividad=$_POST['vactividad'];
                $meta=$_POST['meta'];
                $fechainicio=$_POST['fechainicio'];
                $fechatermino=$_POST['fechatermino'];
              //  $iddireccion=$_POST['iddireccion'];
                $comentarios=$_POST['vcomentarios'];
            
                // $sql = "INSERT INTO actividades_indicadores( informedegobierno,prioridad,Tema, Actividad,meta,
                // FechaInicio,FechaTermino,IdDireccion,Avance,Comentarios,nitavu)VALUES(".$informe.",'".$prioridad."','".$tema."','".$actividad."',"
                // .$meta.",'".$fechainicio."','". $fechatermino."',".$iddireccion.",0,'".$comentarios."',".$nitavu.")";
                
                $sql = "INSERT INTO actividades_dpto(Tema, Actividad,meta,
                FechaInicio,FechaTermino,IdDireccion,IdDepartamento,Avance,Comentarios,nitavu)VALUES('".$tema."','".$actividad."',"
                .$meta.",'".$fechainicio."','". $fechatermino."',".quienEsmiDireccion(nitavu_dpto($nitavu)).",".nitavu_dpto($nitavu).",0,'".$comentarios."',".$nitavu.")";

            if ($conexion->query($sql) == TRUE){                
                mensaje('Registrado con éxito ','indicadores_deptos_dir.php');                  
            }else{
                mensaje('Error al guardar '.$sql.'  , intente nuevamente por favor','indicadores_deptos_dir.php');  
            }

        }  else{ 

         $direccion=quienEsmiDireccion(nitavu_dpto($nitavu));

        echo "<div id='AgregarActividad' class='MyModal' style='width: 50%; height: 80%; '>
        <form action='indicadores_deptos_dir.php' method='POST'>
        <a  rel='MyModal:close' class='close-modal'></a>
        <h3 style='color: #ab0033;'>Agregar Actividad </h3>";
        echo "<center><table style='width:80%; font-size: 12;'>";
        echo "<tr><td>";

        echo "<div id='direcciones'><label style='font-size: 12; '>Departamento</label></td>";
        //echo "<td><label style='font-size: 12; '>".nitavu_dpto_nombre($nitavu)."</label></td>";
        echo "<td><label style='font-size: 12; '>".nitavu_dpto_nombre($f['nitavu'])."</label></td>";
        
        // echo "<td><select name='iddireccion'  class='form-select'  aria-label='Default select example' style='width:91%; font-size: 14;' id='iddireccion'  onchange='ShowSelected();'>"; 
            

        //     $sql="";
        //     $sql = "SELECT * FROM cat_gerarquia where nivel='dir' ";            
        //     $v = $conexion -> query($sql);
        //     while($vv = $v -> fetch_array())
        //     { 
        //         echo "<option value='".$vv['id']."' >".$vv['NomCorto']. "</option>";
        //     }  
        //    echo "<option value='".$direccion."' selected>".buscaidconceptocx('NomCorto', 'cat_gerarquia','id',$direccion ? $direccion  : '0' )."</option>";
        
        // echo "</select> </td> ";               
        echo "</tr>";
       /*  echo "<tr>";        
        echo "<td><label style='font-size: 12; '>Informe de gobierno</label></td>";
        echo "<td><select id='informegob' name='informegob' class='form-select' aria-label='Default select example'  style='width: 130px; font-size: 12;'>
                <option value=1>1</option>
                </select></td>";
        echo "</tr>"; */
        echo "<tr>";
        echo "<td><label style='font-size: 12;'>Tema</label><br></td>";
        echo "<td><input type='text' id='tema' name='tema' style='font-size: 12; ' ></td>";
        echo "</tr>";
        echo "<tr>";
        echo "<td><label style='font-size: 12; '>Actividad</label><br></td>";
        echo "<td><textarea style='height:60px; font-size: 12; ' placeholder='Ingrese detalles de la actividad' name='vactividad' ></textarea></td>";            
        echo "</tr>";
        echo "<tr>";
        echo "<td><label>Meta</label><br></td>";
        echo "<td><input type='number' id='meta' name='meta' min='1'  style='font-size: 12; width:200px' placeholder='Escriba el número' value=0></td>";
        echo "</tr>";
        echo "<tr>";
        echo "<td><label  style='font-size: 12; '>Fecha inicio</label><br></td><td><input type='date' id='fechainicio' name='fechainicio' value=".$fecha."  style='font-size: 12; width:200px'></td>";
        echo "</tr>";
        echo "<tr>";
        echo "<td><label style='font-size: 12; '>Fecha termino</label><br></td><td><input type='date' id='fechatermino' name='fechatermino' value=".$fecha."  style='font-size: 12; width:200px'></td>";
        echo "</tr>";

        // echo "<tr>";
        // echo "<td><label style='font-size: 12; '>Comentarios</label></td>";                
        // echo "<td><textarea style='height:60px; font-size: 12; '; name='vcomentarios' ></textarea></td>";        
        // echo "</tr>";    

        echo "<tr>";
        echo "<td><label style='font-size: 12; '>Comentarios</label></td>";                
       //<textarea style='height:60px; font-size: 12; '; name='vcomentarios' ></textarea>
        echo "<td>        
                 <p class='emoji-picker-container'>
                <textarea class='input-field' data-emojiable='true' data-emoji-input='unicode'  style='height: 200px;width: 100%;'
                type='text' name='vcomentarios' id='vcomentarios' placeholder='Agregue su mensaje'></textarea>
                </p>
      
        </td>";        
        echo "</tr>";  


        echo "</table></center>";
        echo '<center><button type="submit"  name="btnGuardarA" id="btnGuardarA" class="btn btn-danger">Guardar</button></center>';            
        echo "</form>";
        echo "</div>";
        }   
       
        
   
}
else 
{
    mensaje("No tiene acceso a esta aplicacion",'');
}



?>
<script>



	$(document ).ready(function() {

		bq=getQueryVariable('busqueda');
       
		if (bq!=false){
		document.getElementById("beta_buscar_input").value=bq;}
});




function getQueryVariable(variable)
{
       var query = window.location.search.substring(1);
       var vars = query.split("&");
       for (var i=0;i<vars.length;i++) {
               var pair = vars[i].split("=");
               if(pair[0] == variable){return pair[1];}
       }

       return(false);
}

function ActualizarVisto(id,nitavu){

//var id= $(this).data("id8");
console.log("entro");
    $.ajax({
        url:"marcarMensajeVisto.php",
        method:"Post",
        data:{id:id,nitavu:nitavu},
        dataType:"html",
        success:function(data){
            console.log(data);
            $('#mensajeDirector').html(data);
        }
    });
}



$(function() {
        // Initializes and creates emoji set from sprite sheet
        window.emojiPicker = new EmojiPicker({
          emojiable_selector: '[data-emojiable=true]',
          assetsPath: './lib/img/',
          popupButtonClasses: 'fa fa-smile-o'
        });
        // Finds all elements with `emojiable_selector` and converts them to rich emoji input fields
        // You may want to delay this step if you have dynamically created input fields that appear later in the loading process
        // It can be called as many times as necessary; previously converted input fields will not be converted again
        window.emojiPicker.discover();
      });
document.querySelectorAll(".close-modal").forEach(el => {

  el.addEventListener("click", e => {

    const id = e.target.getAttribute("id");
if(id=='CerrarMensajeDir')
{
    location.reload();
}
    

  });

});

 </script>   



<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>


<?php include ("./lib/body_footer.php"); ?>
