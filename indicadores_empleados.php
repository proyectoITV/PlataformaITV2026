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


$("body").on("keydown", "input", function(e) {
  var self = $(this),
    form = self.parents("form:eq(0)"),
    focusable,
    next;
  
  // si presiono el enter
  if (e.keyCode == 13) {
    // busco el siguiente elemento
    focusable = form.find("input,a,select,button,textarea").filter(":visible");
    next = focusable.eq(focusable.index(this) + 1);
    
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

<?php


$id_aplicacion = 'ap132';
xd_update('ap132',$nitavu);//guarda la experiencia del usuario
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
        echo "<table style='width:80%;' id='uno'>";
            echo "<tr >";
            //echo '<td  style="vertical-align: middle; width:110px"><img src="img/logot.png" style="width:110px;">'; //style="width:110px;
            echo "</td><td>";
          
            echo "</td>";
          
            echo '<td ></td>';            
            echo "<td><h2 style='font-size: 26px;'>MIS ACTIVIDADES</h2>";
        
             if( ((titular(nitavu_dpto($nitavu))==$nitavu  or nitavu_dpto_nivel($nitavu)=='dir') ) or  $nivel==5){
            ECHO "<h1 class='card-header h5' style='text-transform: uppercase;font-size: 10pt; color: #ab0033;'>".nitavu_dpto_nombre($nitavu)."</h1>";
            }
            else
            {
                ECHO "<h1 class='card-header h5' style='text-transform: uppercase;font-size: 12pt; color: #ab0033;'>".nitavu_dpto_nombre($nitavu)."<br><span style='text-transform: uppercase;font-size: 10pt; color: gray;'>".nitavu_nombre($nitavu)."<span></h1>";
            }
            echo "</td></tr>";
        echo "</table>";
        echo "<br><br>";
    echo "</div>"; 
    echo "</center>";
     echo "<a style='right: 220px; position: absolute; top: 50px; margin-right: 10px;margin-top: 10px; font-size: 12px; color: white;text-decoration: unset;' href='#AgregarActividad' rel='MyModal:open'  class='Mbtn btn-Gray' title='Agregar una nueva actividad general' class='btn btn-link'>
     Agregar Actividad</a>";
     
      echo "<a style='right: 150px; position: absolute; top: 50px; margin-top: 10px;font-size: 12px; color: white;text-decoration: unset;'  href='indicadores_actterminadas_empleados.php'  class='Mbtn btn-Gray' title='Ver el historial de actividades' class='btn btn-link'>     
      Historial</a>";

     echo "<a style='right: 70px; position: absolute; top: 50px; margin-top: 10px;font-size: 12px; color: white;text-decoration: unset;' href='reporte_indicadores_empleados.php?nitavu=".$nitavu."' class='Mbtn btn-Gray' title='Imprimir actividades en pdf' class='btn btn-link'>
     Imprimir</a>";

     if( ((titular(nitavu_dpto($nitavu))==$nitavu  or nitavu_dpto_nivel($nitavu)=='dir') ) or  $nivel==5){  
     echo "<center>"; 
     echo "<div style='width:80%;' id='dos'>"; 
     buscarSinRequired('indicadores_empleados.php','Busqueda por Departamento, Actividad o Tema','');
     echo "</div>"; 
     echo "</center><br>"; 
     }
     




      echo "<center>";
    echo "<div id='tres' style='width:80%;'>";  
    echo '<table class="table bordered " align="center" style="font-size: 14; vertical-align: middle;">'; 
    echo '<tr  style="border-color=#9d9d9d; "  >';
        echo '<th style="width:2%; font-size:8pt; color: white;background: #9d9d9d;  border: 1px solid #ccc;  border-bottom: 2px solid #ccc;"      rowspan="2">NO</th>'; //bacKground:#E75F54;
   
   echo '<th style="width:9%; color: white;background: #9d9d9d; border: 1px solid #ccc;  border-bottom: 2px solid #ccc;" rowspan="2"><center>FECHA</center></th>';
    echo '<th style="width:30%; color: white;background: #9d9d9d; border: 1px solid #ccc;  border-bottom: 2px solid #ccc;" rowspan="2"><center>ACTIVIDAD</center></th>';
   
    echo '<th style="width:2%; color: white;background: #9d9d9d; border: 1px solid #ccc;  border-bottom: 2px solid #ccc;" rowspan="2"><center>OK</center></th>'; 
  
    echo '<th style="width:6%; color: white;background: #9d9d9d; border: 1px solid #ccc;  border-bottom: 2px solid #ccc;"   rowspan="2">PROGRESO</th>';
  echo '<th style="width:20%; color: white;background: #9d9d9d; border: 1px solid #ccc;  border-bottom: 2px solid #ccc;" rowspan="2"><center>DEPARTAMENTO</center></th>'; ;
    echo '<th style="width:20%; color: white;background: #9d9d9d; border: 1px solid #ccc;  border-bottom: 2px solid #ccc;" rowspan="2"><center>RESPONSABLE</center></th>'; ;

    echo '<th style="width:14%;  color: white;background:#9d9d9d; border: 1px solid #ccc;  border-bottom: 2px solid #ccc;" rowspan="2"><center>OBSERVACIONES</center></th>';

     echo "<th colspan='3' style=' color: white;background: #9d9d9d; border: 1px solid #ccc;  border-bottom: 2px solid #ccc;'><center>ACCIONES</center></th>";
   

     echo '</tr>';
  
    $direc=quienEsmiDireccion(nitavu_dpto($nitavu));

      
        
        if( (nitavu_dpto_nivel($nitavu)!='dir' and  $nivel==5) or titular(nitavu_dpto($nitavu))==$nitavu )
        {
           // echo "soy jefe de dpto o tengo nivel 5";
        //    $sql="Select * from actividades_empleados INNER JOIN cat_gerarquia on actividades_empleados.IdDepartamento=cat_gerarquia.id 
        //     where actividades_empleados.IdDepartamento=".nitavu_dpto($nitavu) ."  and (cat_gerarquia.nombre like '%".$search ."%' or actividades_empleados.Actividad like '%".$search."%' or actividades_empleados.Tema like'%".$search."%')  and Estatus not in (2,3) 
        //     order by actividades_empleados.IdDepartamento";

            $sql="Select * from actividades_empleados INNER JOIN cat_gerarquia on actividades_empleados.IdDepartamento=cat_gerarquia.id 
            where( actividades_empleados.IdDepartamento=".nitavu_dpto($nitavu) ." or  actividades_empleados.IdDepartamento in (select id from cat_gerarquia 
            where dependencia in(".misdptos($nitavu).") ) ) and (cat_gerarquia.nombre like '%".$search ."%' or actividades_empleados.Actividad like '%".$search."%' or actividades_empleados.Tema like'%".$search."%')  and Estatus not in (2,3) 
            order by actividades_empleados.IdDepartamento, actividades_empleados.nitavu";

        }
        else if (nitavu_dpto_nivel($nitavu)=='dir' or  $nivel==5){       
            $sql="Select * from actividades_empleados INNER JOIN cat_gerarquia on actividades_empleados.IdDepartamento=cat_gerarquia.id 
            where( actividades_empleados.IdDepartamento=".nitavu_dpto($nitavu) ." or  actividades_empleados.IdDepartamento in (select id from cat_gerarquia 
            where dependencia in(".misdptos($nitavu).") ) ) and (cat_gerarquia.nombre like '%".$search ."%' or actividades_empleados.Actividad like '%".$search."%' or actividades_empleados.Tema like'%".$search."%')  and Estatus not in (2,3) 
            order by actividades_empleados.IdDepartamento, actividades_empleados.nitavu";
            //echo "soy direccion o tengo nivel 5";

        }
        else{
            //echo "soy un emplado normal";
            $sql="Select * from  actividades_empleados where nitavu=".$nitavu." and IdDepartamento=".nitavu_dpto($nitavu) ." and Estatus not in (2,3)  ORDER BY IdActividad";
         
        } 


        $conexion->set_charset('utf8mb4');
        $r= $conexion -> query($sql);        
        while($f = $r -> fetch_array()) {         
           // $color = color_catjerarquia(nitavu_dpto($nitavu));
            echo "<tr></tr>";
            echo "<tr>"; 
                echo "<td style='vertical-align: middle;color:black;  background:".color_catjerarquia($f['IdDepartamento'])." ' ><center><b>".$f['IdActividad']."</b></center></td>";                
                echo "<td><center><b>".date_format(date_create($f['FechaInicio']), 'd-m-y')."</b></center></td>";
                echo "<td><b>".$f['Actividad']."</b><br>";
                    echo "<a href='#modalHistorial".$f['IdActividad']."' rel='MyModal:open' style='font-size:11px;'>Historial actividades";
                              /*MODAL   HISTORIAL*/
                    /********************************************************************************************************************/
                    echo "<div id='modalHistorial".$f['IdActividad']."' class='MyModal' >"; 
                    echo '<h1 class="card-header h5" style="text-transform: uppercase;font-size: 10pt; color: #ab0033;">'.$f['Actividad'].'</h1><br>';
                   // $sql2="select * from historial_actividades_empleados  where IdActividad=".$f['IdActividad'];          
                    
                    $sql2="select * from historial_actividades_empleados  left join documentos on documentos.ndocumento=historial_actividades_empleados.iddocumento
                    where historial_actividades_empleados.IdActividad=".$f['IdActividad'];          
                    
                    echo '<table class="tabla_punteada tabla"  align="center" style="font-size: 12; vertical-align: middle; ">
                    <thead>
                    <tr  align="center" style=" bacKground:#E75F54; color:white;">                   
                        <th style="width:10%;">Id</th>
                        <th  style=" vertical-align: middle; width:10%;">Fecha</th>
                        <th>Comentario</th>    
                        <th>Avance</th>  
                        <th>Archivo</th>           
                        </tr>
                    </thead>
                    <tbody>';
//echo $sql;
                    $ll = $conexion -> query($sql2);
                    while($v = $ll -> fetch_array())
                    {
                        echo ' <tr>';    
                        echo ' <td><center>'.$v["Id"] .'</center></td>';                                                        
                        echo ' <td><center>'.date_format(date_create($v["Fecha"]), 'd-m-y').'</center></td>';
                        echo ' <td>'.$v["Comentario"] .'</td>';   
                        echo ' <td><center>'.$v["Avance"] .'%</center></td>'; 
                        //"documentos/".$num."_".$doc."";         
                        $archivo = "documentos/".$v['iddocumento'].'_'.$v['nombre']."";
                        //href='cp_descarga_archivo.php?ruta=".$archivo."'
                        //echo $archivo; 
                        $link='';
                        if($v['iddocumento']!='' or $v['iddocumento']!=null)
                        { 
                             $link = "<a id=".$v['iddocumento']." name='$archivo' href='cp_descargar.php?nombre=".$archivo."' target='_self'  class='digitalizados_vinculos' onclick =''  title='Haga click aqui para descargar'><img src='icon/pdf.png' style='width:18px;'></a>";
                        }

                        echo "<td >".$link;
                        //echo $archivo; 
                       // echo "<span style='font-size:7pt;'>por ".nitavu_nombre($r['nitavuSube'])." de ".nitavu_dpto_nombre($r['nitavuSube'])."</span>";
                        echo "</td>";//archivo
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
            
                if($f['Estatus']== 1){
                    echo '<td style="vertical-align: middle;"><img src="icon/ok.png" style="width:25px;"></td>';
                }else{
                    echo "<td></td>";
                }

                echo '<td style="vertical-align: middle;">';
                echo '<center>           
                <div class="progress progress-blue"><span style="width: '.$f['Avance'].'%; background-color: '.colorbar_catjerarquia($f['IdDepartamento']).';"><b>'.$f['Avance'].'%</b></span></div>';
                if ($f['Estatus']!= 1 or   ( (nitavu_dpto_nivel($nitavu)=='dir' or  $nivel==5)  )){ 
                    echo "<a href='#modalAvance".$f['IdActividad']."' rel='MyModal:open' style='float: right!important; '><img src='icon/addRep.png' style='width:15px;'> ";
                        /*MODAL   avance*/
                          /********************************************************************************************************************/   
                        echo "<div id='modalAvance".$f['IdActividad']."' class='MyModal' style='width:30%' >"; 
                        echo '<form action="guardarAvanceEmpleados.php" method="POST"  enctype="multipart/form-data">';
                        echo "<center >";              
                            echo '<input type="hidden" id="idactividad" name="idactividad" value='.$f['IdActividad'].'>';
                            
                            echo '<div class="" style="width:100%;"><span style="text-transform: uppercase;font-size: 12pt; color: #ab0033; font-weight:bold; font-family:Compacta; font-weight:bold;">'.$f['Actividad'].'</span></div><br>';
                        
                            echo '<div class=" " style="width:100%;" ><span style="font-family:Compacta; font-weight:bold;">Avance:</span><br>  
                            <input type="number" readonly class="form-control" id="avance" name="avance"  min="1" max="100" value='.obtenerAvanceEmpleados($f['IdActividad']).' style="border-radius:5px; text-align: center; color:#dc3545 ;font-weight: bold;">
                            </div><br>';

                            echo '<div class=" " style="width:100%;"><span style="font-family:Compacta; font-weight:bold;">Nuevo Avance:</span><br>  
                            <input type="number" class="form-control" id="avance" name="avance"  min="1" max="100" value='.obtenerAvanceEmpleados($f['IdActividad']).' style="border-radius:5px; text-align: center;">
                            </div><br>';

                            echo '<div class=" " style="width:100%;"><span style="font-family:Compacta; font-weight:bold;">Fecha Avance:</span><br>  
                            <input type="date" class="form-control" id="fechaavance" name="fechaavance"   value='.$fecha.' style="border-radius:5px; text-align: center;" >
                            </div><br>';
                    
                            echo '<div class=" " style="width:100%;"><span style="font-family:Compacta; font-weight:bold;">Comentarios:</span><br> '; 
                            echo "<p class='emoji-picker-container'>
                                <textarea class='input-field form-control' data-emojiable='true' data-emoji-input='unicode'  style='height: 200px;width: 100%;'
                                type='text' name='comentario' id='comentario' ></textarea>
                                </p>";
                            echo' </div>'; 
                            
                            echo '<div class=" " style="width:100%;"><span style="font-family:Compacta; font-weight:bold;">Subir Archivo:</span><br> '; 
                            echo '<input name="nuevoDoc" id="nuevoDoc"  type="file" accept=".pdf">';
                            echo' </div>'; 
                            
                            echo "</BR>";
                            echo "<input type='submit' value='Guardar'  class='btn btn-danger' style='color:white; width:100px;' name='btnGuardar' >";                 
                    echo "</center>";
                    echo "</form>";
                    echo "</div>";
                        /********************************************************************************************************************/   
                    echo " </a>";
                
                    }
                echo "</center>";
                echo "</td>";

                $nombreencargado = nitavu_nombre($f['nitavu']);
                $nombreDpto=DptoNombre($f['IdDepartamento']);            
                echo "<td style='vertical-align: middle;  ';><b><center>".$nombreDpto."</center></b></td>";
                //se agrega nombre del personal
                echo "<td style='vertical-align: middle;';><b><center>".$nombreencargado."</center></b></td>";
                    $ultimocomentario=UltimaObservacionEmpleado($f['IdActividad']);
                
                    if ( UltimaObservacionEmpleado($f['IdActividad'])==''){
                        
                        echo "<td style='font-size:13px'><b>". $f['Comentarios'] ."</b></td>";
                        
                    }else{
                        echo "<td style='font-size:13px'><b>".$ultimocomentario."</b></td>";
                    }


                    echo "<td style='vertical-align: middle; border: 0px solid #f8f9fa; border-left: 1px solid #ccc; border-top: 1px solid #ccc; border-right: 1px solid #fff;'>";
                    echo "<a class='pc' href='#add".$f['IdActividad']."' rel='MyModal:open' title='Editar la actividad'>";
                    echo "<img src='icon/editar.png' style='width:35px; padding:5px; '>";
                    //--
                            ///MODAL MODIFICAR
                    if(isset($_POST['btnGuardarM'])){
                        $idactividad = $_POST['idactividad'];
                       // $tema = $_POST['tema'];
                        $actividad = $_POST['vactividad'];
                        //$meta = $_POST['meta'];
                        $fechainicio = $_POST['fechainicio'];
                        //$fechatermino = $_POST['fechatermino'];
                        $comentarios = $_POST['ncomentarios'];
                        $sql = "Update actividades_empleados set 
                              Actividad = '".$actividad."'                           
                            , FechaInicio = '".$fechainicio."'                           
                            , Comentarios = '".$comentarios."'
                            where IdActividad = ".$idactividad;

                        // echo $sql;     
                        if ($conexion->query($sql) == TRUE){ 
                            mensaje('Se ha modificado la actividad '.$idactividad.' con éxito','indicadores_empleados.php');
                        }else{
                            mensaje('Ocurrio un error al intentar modificar el registro, favor de intentarlo nuevamente.','indicadores_empleados.php');
                        }                    
                    }  else{ 
                            /********************************************************************************************************************/  
                            // MODAL MODIFICAR
                        echo "<div id='add".$f['IdActividad']."' class='MyModal' style='width: 50%; height: auto;'>";
                        echo " <a  rel='MyModal:close' class='close-modal' id='Cerrar_add".$f['IdActividad']."' name='Cerrar_add".$f['IdActividad']."'></a>";
                        echo "<form action='indicadores_empleados.php' method='POST'>
                        <h3 style='color: #ab0033;'>Modificar Actividad ".$f['IdActividad']." </h3>";

                        echo "<center>";
                         echo "<input type='text' id='idactividad' name='idactividad' value = '".$f['IdActividad']."' hidden>";
                        echo '<div class=" "  style="width:70%;"><span style="font-family:Compacta; font-weight:bold;">Departamento:</span><br>  
                        <input type="text" readonly class="form-control" id="" name=""   value="'.nitavu_dpto_nombre($nitavu).'" style="border-radius:5px; text-align: center;"
                        "></div><br>';
                               

                        echo '<div class=" "style="width:70%;"><span style="font-family:Compacta; font-weight:bold;">Actividad:</span><br> '; 
                        echo "
                        <textarea class='input-field form-control' data-emojiable='true' data-emoji-input='unicode'  style='height: 60px;width: 100%;'
                        type='text' name='vactividad' id='vactividad' >".$f['Actividad']."</textarea>
                        ";
                         echo' </div>';
                
                        echo '<div class=" "style="width:70%;"><span style="font-family:Compacta; font-weight:bold;; font-weight:bold;">Fecha Inicio:</span><br>  
                        <input type="date" class="form-control" id="fechainicio" name="fechainicio"  value="'.$f['FechaInicio'].'"  style="border-radius:5px; text-align: center;" ></div><br>';
                
                        echo '<div class=" "style="width:70%;"><span style="font-family:Compacta; font-weight:bold;">Comentarios:</span><br> '; 
                        echo "<p class='emoji-picker-container'>
                        <textarea class='input-field form-control' data-emojiable='true' data-emoji-input='unicode'  style='height: 200px;width: 100%;'
                        type='text' name='ncomentarios' id='ncomentarios' >".$f['Comentarios']."</textarea>
                        </p>";
                         echo' </div>';
                        echo '<center><button type="submit"  name="btnGuardarM" id="btnGuardarM" class="btn btn-danger">Guardar</button></center>';     
                        echo "</form></div>";
                            /********************************************************************************************************************/  
                    }
                    //--
                    echo "</a>";                    
                    echo "</td>";     
                    
                    if (porcentajeActividadEmpleado($f['IdActividad'])==100  and  ( (nitavu_dpto_nivel($nitavu)=='dir' or  $nivel==5)  )){
                        echo "<td style='vertical-align: middle;'><a class='pc'  href='indicadores_empleados.php?idactividad=".$f['IdActividad']."'   title='Archivar la actividad'>";
                        echo "<img src='icon/ci.png' style='width:35px; padding:5px;'>";
                    }else{
                    echo "<td style='vertical-align: middle; border: 0px solid #f8f9fa; border-left: 1px solid #ccc; border-top: 1px solid #ccc; border-right: 1px solid #fff;'><a class='pc'  href='#addelim".$f['IdActividad']."' rel='MyModal:open'  title='Eliminar la actividad'>";
                    echo "<img src='icon/eliminar.png' style='width:35px; padding:5px;'>";
                            //--MODAL ELIMINAR
                        if(isset($_POST['btnGuardarElim'])){
                            $idactividad = $_POST['idactividad'];           

                            $sql = "Update actividades_empleados set 
                                Estatus=2
                                where IdActividad = ".$idactividad;

                            if ($conexion->query($sql) == TRUE){ 
                                mensaje('Se ha eliminado la actividad '.$idactividad.' con éxito','indicadores_empleados.php');
                            }else{
                                mensaje('Ocurrio un error al intentar eliminar la actividad, favor de intentarlo nuevamente.','indicadores_empleados.php');
                            }                    
                        }  
                        else{ 
                            
                            echo "<div id='addelim".$f['IdActividad']."' class='MyModal' style='width: 50%; height: 80%;'>";
                            echo " <a  rel='MyModal:close' class='close-modal' id='Cerrar_addelim".$f['IdActividad']."' name='Cerrar_addelim".$f['IdActividad']."'></a>";
                            echo "<form action='indicadores_empleados.php' method='POST'>
                            <h3 style='color: #ab0033;'>Eliminar Actividad ".$f['IdActividad']." </h3>";

                            echo "<input type='text' id='idactividad' name='idactividad' value = '".$f['IdActividad']."' hidden> ";

                            echo "<center><table style='width:70%;'>";
                            echo "<tr><td>";
                    
                            echo "<div id='direcciones'><label style='font-size: 14; '>Dirección a cargo de la actividad</label></td>";
                            
                            echo "<td><select name='iddireccion'  class='form-select'  aria-label='Default select example' style='width:91%; font-size: 14;' id='iddireccion'  onchange='ShowSelected();' disabled>"; 
                                $sql="";
                                $sql = "SELECT * FROM cat_gerarquia ";  
                                $v = $conexion -> query($sql);
                                while($vv = $v -> fetch_array()){ 
                                    echo "<option value='".$vv['id']."' >".$vv['NomCorto']. "</option>";
                                }  
                        
                            echo "<option value='".$f['IdDepartamento']."' selected>".buscaidconceptocx('nombre', 'cat_gerarquia','id', $f['IdDepartamento'] ? $f['IdDepartamento']  : '0' )."</option>";
                                                                                                        
                            echo "</select> </td> ";               
                            echo "</tr>";                                
                        
                            echo "<tr>";
                            echo "<td><label>Actividad</label><br></td>";
                            echo "<td><b><label style='height:60px;'>".$f['Actividad']."</label></b></td>";                                
                            echo "</tr>";                                
                            echo "<tr>";
                            echo "<td><label>Fecha inicio</label><br></td><td><input type='date' id='fechainicio' name='fechainicio' value = '".$f['FechaInicio']."' disabled></td>";
                            echo "</tr>";
                                                    
                            echo "</table></center>";
                            echo '<center><button type="submit"  name="btnGuardarElim" id="btnGuardarElim" class="btn btn-danger">Eliminar</button></center>';     
                            echo "</form></div>";
                        }
                        }
                    //-- FIN MODAL ELIMINAR
                        
                    echo "</a></td>";              
                    echo "</tr>";
                }
          
    echo "</table>";
    echo "</center>";
    echo "</div>";


  /**************************************************************************************************************************************** */
  //ARCHIVAR ACTIVIDAD
    if(isset($_GET['idactividad'])){
    
        $idactividad = $_GET['idactividad'];           

        $sql = "Update actividades_empleados set 
            Estatus=3
            where IdActividad = ".$idactividad;
            if ($conexion->query($sql) == TRUE){ 
                mensaje('Se archivo con éxito la actividad, podrá consultarla en el Historial','indicadores_empleados.php');    
            }else{
                mensaje('Ocurrio un error al intentar archivar la actividad, favor de intentarlo nuevamente.','indicadores_empleados.php');
            }           
}
/**************************************************************************************************************************************** */

        //INSERT PARA AGREGAR ACTIVIDAD
        if(isset($_POST['btnGuardarA'])){
            
           // $tema=$_POST['tema'];
            $actividad=$_POST['vactividad'];
           // $meta=$_POST['meta'];
            $fechainicio=$_POST['fechainicio'];
           // $fechatermino=$_POST['fechatermino'];
            $comentarios=$_POST['vcomentarios'];
        
            $sql = "INSERT INTO actividades_empleados( Actividad,
            FechaInicio,IdDireccion,IdDepartamento,Estatus,Comentarios,nitavu)VALUES('".$actividad."','"
            .$fechainicio."',".quienEsmiDireccion(nitavu_dpto($nitavu)).",".nitavu_dpto($nitavu).",0,'".$comentarios."',".$nitavu.")";
           // echo $sql;
            
        if ($conexion->query($sql) == TRUE){                
            mensaje('Registrado con éxito ','indicadores_empleados.php');                  
        }else{
            mensaje('Error al guardar '.$sql.'  , intente nuevamente por favor','indicadores_empleados.php');  
        }

    }  else{ 
        
        /**************************************************************************************************************************************** */
        //aqui esta el modal 
        //aqui esta el modal de alta de actividad
        $direccion=quienEsmiDireccion(nitavu_dpto($nitavu));
        echo "<div id='AgregarActividad' class='MyModal' style='width: 50%; height: auto; '>";
        echo " <a  rel='MyModal:close' class='close-modal' id='Cerrar_ag' name='Cerrar_ag'></a>";
            echo "<form action='indicadores_empleados.php' method='POST'>
                <h3 style='color: #ab0033;'>Agregar Actividad </h3>";
                echo "<center>";
            
                echo '<div class=" "  style="width:70%;"><span style="font-family:Compacta; font-weight:bold;">Departamento:</span><br>  
                <input type="text" readonly class="form-control" id="" name=""   value="'.nitavu_dpto_nombre($nitavu).'" style="border-radius:5px; text-align: center;"
                "></div><br>';
                // echo '<div class=" "style="width:70%;"><span style="font-family:Compacta; font-weight:bold;; font-weight:bold;">Tema:</span><br>  
                // <input type="text" class="form-control" id="tema" name="tema"    style="border-radius:5px; text-align: Justify;"
                // "></div><br>';
                echo '<div class=" "style="width:70%;"><span style="font-family:Compacta; font-weight:bold;; font-weight:bold;">Actividad:</span><br>  
                <textarea type="text" class="form-control" id="vactividad" name="vactividad"   style="border-radius:5px;  height:60px;">
                </textarea>
                </div><br>';

                echo '<div class=" "style="width:70%;"><span style="font-family:Compacta; font-weight:bold;; font-weight:bold;">Fecha Inicio:</span><br>  
                <input type="date" class="form-control" id="fechainicio" name="fechainicio"    style="border-radius:5px; text-align: center;" value="'.$fecha.'"></div><br>';

                echo '<div class=" "style="width:70%;"><span style="font-family:Compacta; font-weight:bold;">Comentarios:</span><br> '; 
                echo "<p class='emoji-picker-container'>
                <textarea class='input-field form-control' data-emojiable='true' data-emoji-input='unicode'  style='height: 200px;width: 100%;'
                type='text' name='vcomentarios' id='vcomentarios' ></textarea>
                </p>";
                echo' </div>';    
                echo "</center>";
                echo '<center><button type="submit"  name="btnGuardarA" id="btnGuardarA" class="btn btn-danger">Guardar</button></center>';          
            echo "</form>";
        echo "</div>";
        /**************************************************************************************************************************************** */
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
    </script>
 



<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>


<?php include ("./lib/body_footer.php"); ?>
