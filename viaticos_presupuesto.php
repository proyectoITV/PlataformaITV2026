<?php
//require("config.php");
include ("./lib/body_head.php"); include ("./lib/body_menu.php");
require_once('lib/laura_funciones.php');
require_once('lib/flor_funciones.php');
?>


<?php
$id_aplicacion ="viaticos"; //tabla aplicaciones
echo "<div id='AppDetalle'>".app_detalle($id_aplicacion, $nitavu)."</div>";


$nivel = aplicacion_nivel($id_aplicacion, $nitavu); //tabla aplicaciones permisos
//Niveles
// 1 = Crear y Editar
// 2 = VoBo Viaticos
// 3 = VoBo Admon
// 4 = VoBo Recursos Fincieros
// 5 = VoBo Comisaria
if($nivel==4){
  echo "<a style='right: 50px; position: absolute; top: 50px; margin-right: 10px;margin-top: 10px; font-size: 12px; color: white;text-decoration: unset;' href='#AgregarPresupuesto' rel='MyModal:open'  class='Mbtn btn-Gray' title='Agregar Nueva Información' class='btn btn-link'>
     Agregar presupuesto</a>"; }

     echo "<div id='AgregarPresupuesto' class='MyModal' style='width: 50%; height: auto; '>";
     echo " <a  rel='MyModal:close' class='close-modal' id='Cerrar_ag' name='Cerrar_ag'></a>";
     echo "<form action='viaticos_presupuesto.php' method='POST'>
     <h4 style='color: #ab0033;'>AGREGAR PRESUPUESTO</h4>";
    echo "<center>";   
    echo '<div class=" "  style="width:70%;"><span style="font-family:Compacta; font-weight:bold;">Direccion:</span><br>';   
    echo '<select class="form-control"     style="border-radius:5px; text-align: center;" name="iddireccion" id="iddireccion">';	
    $sql="SELECT	* from cat_gerarquia where nivel='dir'";
    //echo $sql;
    $r = $conexion -> query($sql);	
    while($f = $r -> fetch_array())
    {       
      echo '<option value="'.$f['id'].'">'.$f['nombre'].'</option>';		
    
    }	        
    echo "</select>";
     
     
     echo '</div><br>';
 
     

     echo '<div class=" "style="width:70%;"><span style="font-family:Compacta; font-weight:bold;; font-weight:bold;">Monto Autorizado:</span><br>  
     <input type="number" class="form-control" id="montoautorizado" name="montoautorizado"   style="border-radius:5px;text-align:center;"/>
     </div><br>';
 
    echo '<div class=" "style="width:70%;"><span style="font-family:Compacta; font-weight:bold;; font-weight:bold;">Año:</span><br> ';
    echo '<select style="text-align:center;" id="año" name="año">';
    $InicioYear = 2022; // Aqui coloca el año de inicio, el que estará más abajo
    $MinYear = $InicioYear-1;
    $ActualYear = date("Y");; // Aquí coloca el año actual 
    for ($i=$ActualYear; $i > $MinYear ; $i--) { 
		echo '<option value="'.$i.'">'.$i.'</option>'; // Aqui puedes agregarle cosas como class, name, id.
	  }
    echo '</select>';    
     echo "</center>";
     echo '<center><button type="submit"  name="btnGuardarA" id="btnGuardarA" class="btn btn-danger">Guardar</button></center>';    
             
     echo "</form>";
     echo "</div>";


     echo "<br>";
     echo "<br>";
     echo "<br>";



                  ///MODAL AGREGAR
                  if(isset($_POST['btnGuardarA'])){        
                    
                    

                    
                    $iddireccion = $_POST['iddireccion'];
                    $año = $_POST['año'];
                    $montoautorizado = $_POST['montoautorizado'];
                    $siglas=nomenclaturaDir($iddireccion);
                    if(EstaDadoAltaUnPresupuesto($iddireccion)=="no")
                    {
                     $sql = "Insert into viaticosadmin(iddireccion,año, montoautorizado, montodisponible,siglas)values('$iddireccion','$año','$montoautorizado','$montoautorizado','$siglas');";
                      //echo $sql;     
                      if ($conexion->query($sql) == TRUE){ 
                          mensaje('Se agregó el presupuesto con exito','viaticos_presupuesto.php');
                      }else{
                          mensaje('Ocurrio un error al intentar agregar el registro, favor de intentarlo nuevamente.','viaticos_presupuesto.php');
                      }     
                    } else
                    {
                      mensaje('No se pudo agregar el presupuesto, Ya existe un presupuesto asignado para esta dirección.','viaticos_presupuesto.php');
                    }              
                } 


                ///MODAL MODIFICAR
                if(isset($_POST['btnGuardarE'])){
                $id = $_POST['idviatico'];
                 $montoautorizado = $_POST['montoautorizado'. $id ];
                 $montoutilizado = $_POST['montoutilizado'. $id];
                 $montodisponible =  floatval($montoautorizado) -  floatval($montoutilizado);
                 $sql = "Update viaticosadmin set montoautorizado='$montoautorizado', montoutilizado='$montoutilizado', montodisponible='$montodisponible' where id=$id";

                   echo $sql;     
                  if ($conexion->query($sql) == TRUE){ 
                      mensaje('Se modificó el presupuesto con exito','viaticos_presupuesto.php');
                  }else{
                      mensaje('Ocurrio un error al modificar  el registro, favor de intentarlo nuevamente.','viaticos_presupuesto.php');
                  }                    
              } 

     echo "<center>";
     echo "<div style='width:80%;'>";     
     echo '<table class="table bordered" align="center" style="font-size: 14;">';
     echo '<tr bgcolor="#991204" style="font-size:8pt;">';
     echo '<th style=" bacKground:#bc955c; color:white;text-align:center;" >NO</th>';
     echo '<th style=" bacKground:#bc955c; color:white;text-align:center;" >DIRECCION</th>';
     echo '<th style=" bacKground:#bc955c; color:white;text-align:center;" >AÑO</th>';
     echo '<th style=" bacKground:#bc955c; color:white;text-align:center;" >MONTO AUTORIZADO</th>';
     echo '<th style=" bacKground:#bc955c; color:white;text-align:center;" >MONTO UTILIZADO</th>';
     echo '<th style=" bacKground:#bc955c; color:white;text-align:center;" >MONTO DISPONIBLE</th>';
     if($nivel==4)
      {    echo '<th style=" bacKground:#bc955c; color:white;text-align:center; width:10%;" colspan=2 >ACCIONES</th>';} 
     $sql="Select ad.id,ad.iddireccion,cg.nombre as direccion ,ad.año,ad.montoautorizado, ad.montodisponible,ad .montoutilizado from 
      viaticosadmin ad inner join cat_gerarquia as cg on cg.id=ad.iddireccion where año>=year(CURDATE()) ";
     //echo $sql;
 
    $r= $conexion -> query($sql);
    while($f = $r -> fetch_array()) {
      echo '<tr>';
      echo ' <td><center>'.$f["id"] .'</center></td>';
      echo ' <td><center>'.$f["direccion"] .'</center></td>';
      echo ' <td><center>'.$f["año"] .'</center></td>';
      echo ' <td><center>'.$f["montoautorizado"] .'</center></td>';
      echo ' <td><center>'.$f["montoutilizado"] .'</center></td>';
      echo ' <td><center>'.$f["montodisponible"] .'</center></td>';  
      if($nivel==4)
      {  
      echo ' <td style="text-align:center;">';      
      echo "<a class='pc' href='#edit".$f['id']."' rel='MyModal:open' title='Editar el presupuesto'>";                    
      echo "<img src='icon/editar.png' style='width:35px; padding:5px; '>";
      
          //#modalHistorial".$f['IdActividad']."
          echo "<div id='edit".$f['id']."' class='MyModal' style='width: 50%; height: auto;'>";
          echo "<form action='viaticos_presupuesto.php' method='POST'>";
          echo "<a  rel='MyModal:close' class='close-modal'></a>";
          echo "<form action='indicadores_empleados.php' method='POST'>";
          echo "<h4 style='color: #ab0033;'>MODIFCAR PRESUPUESTO</h4>";
          echo "<center>"; 
          $sql2="select * from viaticosadmin where id=".$f['id'];
          //echo $sql2;
          $rr= $conexion -> query($sql2);
          while($ff = $rr -> fetch_array()) {
  

            echo '<div class=" "style="width:70%;"> 
            <input type="hidden" class="form-control" id="idviatico" name="idviatico"   style="border-radius:5px;text-align:center;" value="'.$f['id'].'"/>
            </div><br>';

           echo '<div class=" "  style="width:70%;"><span style="font-family:Compacta; font-weight:bold;">Direccion:</span><br>';   
           echo '<select class="form-control"     style="border-radius:5px; text-align: center;" disabled>';	
           $sql2="SELECT	* from cat_gerarquia where nivel='dir'";
          //echo $sql;
          $rx = $conexion -> query($sql2);	
          while($fx = $rx -> fetch_array())
          {   
          if($fx['id']==$ff['iddireccion'])  
          {
            echo '<option value="'.$fx['id'].'" selected>'.$fx['nombre'].'</option>';		
          }else
          { echo '<option value="'.$fx['id'].'" >'.$fx['nombre'].'</option>';		
  
          }
  
          }	        
          echo "</select>";
          
          
          echo '</div><br>';
      
          echo '<div class=" "style="width:70%;"><span style="font-family:Compacta; font-weight:bold;; font-weight:bold;">Monto Autorizado:</span><br>  
          <input type="number" class="form-control" id="montoautorizado'.$f['id'].'" name="montoautorizado'.$f['id'].'"  onkeyup="calculardiponible('.$f['id'].')" style="border-radius:5px;text-align:center;" value="'.$f['montoautorizado'].'"/>
          </div><br>';
      
          echo '<div class=" "style="width:70%;"><span style="font-family:Compacta; font-weight:bold;; font-weight:bold;">Monto Utilizado:</span><br>  
          <input type="number" class="form-control" id="montoutilizado'.$f['id'].'" name="montoutilizado'.$f['id'].'"  readonly  style="border-radius:5px;text-align:center;" value="'.$f['montoutilizado'].'"/>
          </div><br>';
  
          echo '<div class=" "style="width:70%;"><span style="font-family:Compacta; font-weight:bold;; font-weight:bold;">Monto Dispoible:</span><br>  
          <input type="number" class="form-control" id="montodisponible'.$f['id'].'" name="montodisponible'.$f['id'].'"  readonly  style="border-radius:5px;text-align:center;" value="'.$f['montodisponible'].'"/>
          </div><br>';

          echo '<div class=" "style="width:70%;"><span style="font-family:Compacta; font-weight:bold;; font-weight:bold;">Año:</span><br> ';
          echo '<select  class="form-control"     style="border-radius:5px; text-align: center;" disabled >';
          $InicioYear = 2022; // Aqui coloca el año de inicio, el que estará más abajo
          $MinYear = $InicioYear-1;
          $ActualYear = 2023; // Aquí coloca el año actual 
          for ($i=$ActualYear; $i > $MinYear ; $i--) { 
          if(  $f['año']==$i)
          {
            echo '<option value="'.$i.'" selected>'.$i.'</option>'; 
          }else
          {
            echo '<option value="'.$i.'">'.$i.'</option>'; 
          }
          
          }
  
          echo '</select>';  
          echo '</div> ';
           echo'<br>';
            }
        
            echo '<center><button type="submit"  name="btnGuardarE" id="btnGuardarE" class="btn btn-danger">Guardar</button></center>';       
          echo "</center>";
          echo "</form>";
          echo "</div>";
      echo ' </a>';
      echo ' </td>';
      echo ' <td  style="text-align:center;">';
      //echo "<a class='pc' href='#add".$f['id']."' rel='MyModal:open' title='Eliminar'>";                    
      echo "<img src='icon/eliminar.png' style='width:35px; padding:5px;'>";
      //echo ' </a>';
      echo ' </td>';
          }
      echo '</tr>';
    }
  
     echo "</table>";
     
     echo "</div>";
 
     echo "</center>";




         
?>




<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>


<?php include ("./lib/body_footer.php"); ?>

<script>
function calculardiponible(id)
{
  console.log("entro");
  
  var montoautorizado=$('#montoautorizado'+id).val();
  var montoutilizado=$('#montoutilizado'+id).val();
  var montodisponible=parseFloat(montoautorizado)-parseFloat(montoutilizado);
  $('#montodisponible'+id).val(montodisponible.toFixed(2));

  console.log(montodisponible);
}
</script>
