<?php
//require("config.php");
include ("./lib/body_head.php"); include ("./lib/body_menu.php");
require_once('lib/laura_funciones.php');
require_once('lib/flor_funciones.php');
?>


<?php
$id_aplicacion ="viaticos"; //tabla aplicaciones
$nivel = aplicacion_nivel($id_aplicacion, $nitavu); //tabla aplicaciones permisos

echo "<script>$('body').css('background-color','white');</script>";
echo "<script>$('body').css('background-image','url(img/recorridos.jpg)');</script>";
echo "<script>$('body').css('background-size','100% 100%');</script>";
echo "<script>$('body').css('background-repeat','repeat');</script>";
echo "<script>$('body').css('background-position','left top');</script>";

echo "<div id='AppDetalle'>".app_detalle($id_aplicacion, $nitavu)."</div>";

if($nivel==2)
    {
    echo "<a style='background-color: #ddc9a3; right: 20px; position: absolute; top: 50px; margin-top: 10px;font-size: 12px; color: black; text-decoration: unset;' href='#modalAgregarRecorrido' rel='MyModal:open'class='Mbtn btn-Gray' title='Agregar un nuevo recorrido a la lista'>Agregar Nuevo Recorrido</a>";
    }
    
    if(isset($_GET['id'])){
        //if (isset($_GET['idactividad'])){
            $idrecorrido = $_GET['id'];           
    
            $sql = "Delete  from cat_recorridosviaticos   where idrecorrido = ".$idrecorrido;
            echo $sql ;
                if ($conexion->query($sql) == TRUE){ 
                    if(isset($_GET['del'])){
                        mensaje('Se eliminó el recorrido','viaticos_admonrecorridos.php');  
                    }
                    else
                    {
                        mensaje('Se eliminó con exito el recorrido','viaticos_admonrecorridos.php');  
                    }

                }else{
                    if(isset($_GET['del'])){
                        mensaje('Ocurrio un error al intentar eliminar el recorrido , favor de intentarlo nuevamente.','viaticos_admonrecorridos.php');
                    }else
                    {
                        mensaje('Ocurrio un error al intentar eliminar el reccorido, favor de intentarlo nuevamente.','viaticos_admonrecorridos.php');
                    }
                }           
    }

    /******************************************************/ 
        /*MODAL AGREGAR RECORRIDO*/
   
        echo "<div id='modalAgregarRecorrido' class='MyModal' style='width:30%' >"; 
        echo '<form action="agregarnuevorecorrido.php" method="POST">';
        echo '<h3 style="color:black; font-size:13pt;">Agregar un nuevo recorrido</h3>';
        echo '<br>';
       
        echo '<div class="container">';
        echo '<div class="row" style="width:100%;">';
        
        echo '<div >';
            echo '<span style="font-family:Compacta;">Origen:</b></span><br>';
            echo '<input style="                               
        border: 2px solid #ffffff17;
        border-radius: 4px;
        background-color: white;
        text-align: center;                
        border: #d2d2d2 solid 1px;
        class="form-control" id="origen" name="origen" type="text" onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()" required  >';
        echo '</div>';
    
        echo '<div>';
            echo '<span style="font-family:Compacta;">Destino:</b></span><br>';
            echo '<input style="                               
            border: 2px solid #ffffff17;
            border-radius: 4px;
            background-color: white;
            text-align: center;                
            border: #d2d2d2 solid 1px;
            class="form-control" id="destino" name="destino" type="text"   onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()"     required>';
        echo '</div>';
    
        echo '<div >';
        echo '<span style="font-family:Compacta;">Distancia (km):</b></span><br>';
        echo '<input style="                                   
        border: 2px solid #ffffff17;
        border-radius: 4px;
        background-color: white;
        text-align: center;                
        border: #d2d2d2 solid 1px;
        class="form-control" id="distanciakm"  name="distanciakm" type="number" required>';
        echo '</div>';
    


        echo '<div >';
        echo '<span style="font-family:Compacta;">Tarifa</b></span><br>';
        echo '<select name="cboxtipotarifa" required style="text-align: center;">
        <option value=""></option>
        <option value="A">A (Centro)</option>
        <option value="B">B (Front-Conurb)</option>
         </select>';
        echo '</div>';

        echo "</br>";
        echo "<center>";
        echo "<input type='submit' value='Guardar'  class='btn btn-danger' style='color:white; width:100px;' name='btnGuardar' id='btnGuardar' >"; 
        echo "</center>";
    
        echo '</div>';
        echo '</div>';
        echo "</form>";
        echo "</div>"; 

    echo "<br>";
    echo "<h3 style='color: black;'>EXPEDIENTE DE VIATICOS</h3>";
    echo "<hr>";
    echo "<br>";
    //  echo "<br>";
    //  echo "<br>";

     echo "<center>";
     echo "<div style='width:80%;'>";     
     echo '<table class="table bordered" align="center" style="font-size: 14;">';
     echo '<tr bgcolor="#991204" style="font-size:8pt;">';
     echo '<th style=" bacKground:#ddc9a3; color:black; text-align:center;" >NO</th>';
     echo '<th style=" bacKground:#ddc9a3; color:black; text-align:center;" >ORIGEN</th>';
     echo '<th style=" bacKground:#ddc9a3; color:black; text-align:center;" >DESTINO</th>';
     echo '<th style=" bacKground:#ddc9a3; color:black; text-align:center;" >DISTANCIA</th>';
       echo '<th style=" bacKground:#ddc9a3; color:black; text-align:center;" >TIPO RARIFA</th>';
     echo '<th style=" bacKground:#ddc9a3; color:black; text-align:center; width:10%;" colspan=2 >ACCIONES</th>';
     $sql="Select * from cat_recorridosviaticos ";
     //echo $sql;
 
    $r= $conexion -> query($sql);
    while($f = $r -> fetch_array()) {
      echo '<tr>';
      echo '<td><center>'.$f["idrecorrido"] .'</center></td>';
      echo '<td><center>'.$f["origen"] .'</center></td>';
      echo '<td><center>'.$f["destino"] .'</center></td>';
      echo '<td><center>'.$f["distancia"] .'</center></td>';
      echo '<td><center>'.$f["tipo"] .'</center></td>';
      echo '<td  style="text-align:center;">';
      echo "<a class='pc' href='#delete".$f['idrecorrido']."' rel='MyModal:open' title='Eliminar'>";                    
      echo "<img src='icon/eliminar.png' style='width:35px; padding:5px;'> </a>";
            echo "<div id='delete".$f['idrecorrido']."' class='MyModal' style='width:30%' >";      
            $mensaje="¿Esta seguro de eliminar el recorrido?";
            $link='viaticos_admonrecorridos.php?id='.$f['idrecorrido'];
            $link1='viaticos_admonrecorridos.php';
            echo "<center>";
            echo '<p style="font-family: Regular; font-size:13pt;">'.$mensaje.'</p>';

            echo "<table>";
            echo "<tr>";
            echo "<td style='width: 44%;'>";
            echo '<a class="Mbtn btn-Danger" style="text-decoration: unset;" href="'.$link.'">Aceptar</a>';
            echo "</td>";
            echo "<td  style='width: 45%;'>";
            echo '<a class="Mbtn btn-Danger" style="text-decoration: unset;" href="'.$link1.'">Cancelar</a>';
            echo "</td>";
            echo "</tr>";
            echo "</table>";
            echo "</center>";
            echo "</div>"; 
       echo ' </td>';
      echo '</tr>';
     }
  
     echo "</table>";
     
     echo "</div>";
 
     echo "</center>";
         
?>

<!-- <br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br> -->

<?php include ("./lib/body_footer.php"); ?>


