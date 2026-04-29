<?php
require ("config.php");
// echo "<ul class='done'>";
//include ("./lib/body_head.php");

require_once('seguridad.php');
require_once('lib/funciones.php');
require('lib/flor_funciones.php');
require('lib/yes_funciones.php');
$nitavuemp= $_POST['nitavu'];
$idapp= $_POST['idapp'];
 //$quien = $nitavu;
 $quien = $_POST['nitavu1'];

 $accion = $_POST['accion'];
 $nivel = $_POST['nivel'];
 if($accion=='delete')
 {
   $sql ="delete from aplicaciones_permisos WHERE
   idapp='".$idapp."' and nitavu='".$nitavuemp."'";
  /// $sql = "UPDATE cp_colaboradores SET activo=1 WHERE nitavu=". $nitavuemp. " and numcaso=".$numcaso;
  
      if ($conexion->query($sql) == TRUE) 
    {      
    
      historia($quien,"Se retiro el acceso a la aplicacion  ".$idapp." - ".nitavu_nombre($nitavuemp)." (".$nitavuemp.")");
    Toast("Se ha retirado el acceso con exito",1,""); 
     // notificarParticipantes($numcaso,$nitavu,'Se quitó como colaborador del caso: '.$numcaso.' a '.nitavu_nombre($nitavuemp),'Exclusión de colaborador al caso '.$numcaso); 
   

    // echo "Empleado Borrado Correctamente";  
    }
    else

          { //echo "Empleado no se Guardado Correctamente";
        }
 }
else
 {
  $sql ="insert into aplicaciones_permisos(nitavu, idapp,nivel,quien_autorizo,fecha_autorizacion)values('".$nitavuemp."','".$idapp."','".$nivel."','". $quien."',Now())";
  echo $sql;
 
     if ($conexion->query($sql) == TRUE) 
   {      
   
     historia($quien,"Se ha otorgado el acceso a la aplicacion  ".$idapp." - ".nitavu_nombre($nitavuemp)." (".$nitavuemp.")");
   Toast("Se ha otorgado el acceso con exito",1,""); 
    // notificarParticipantes($numcaso,$nitavu,'Se quitó como colaborador del caso: '.$numcaso.' a '.nitavu_nombre($nitavuemp),'Exclusión de colaborador al caso '.$numcaso); 
  

   // echo "Empleado Borrado Correctamente";  
   }
 }

  


echo "<div id='bloque' style='height:60px;'>";   
echo "<div style='display: inline-block;    width: 40%;     vertical-align: top;' >"; 
 echo "<h4>Permisos:</h4>";   
echo "</div>";

echo "<div style='display: inline-block;    width: 40%;     vertical-align: top;'  >"; 
 echo "<h4>Permisos Activos:</h4>";   
echo "</div>";  
echo "</div>"; 
    echo "<div class='list' id='divEmpleados' style='height:auto;'>";     
            echo "<ul class='empleados'>";

        $query = "select 	 a.* from aplicaciones as a  where 
            a.idapp NOT IN
            (
                SELECT aplicaciones_permisos.idapp
                FROM aplicaciones_permisos
                WHERE nitavu = ".$nitavuemp."
            ) and a.estado=0  order by nombre asc";

    echo $query ;

        // 	$descripcion = '';
            $r = $conexion -> query($query);
            while($f = $r -> fetch_array())
        { // resultado de la busqueda.................   
            
            echo "<li id='".$f['idapp']."_".$nitavu."' onclick=AgregarPermiso('".$f['idapp']."','".$nitavuemp."'); >";
            echo " <table style='width:100%'><tr><td style='width: 80%;'>
            <span class='tchico normal'>".$f['nombre']."</span><br>	";
            if (!empty($f['admin_comentario']))
            {
            echo "<p>
            <label for='temp1'>Nivel:</label>
            <input type='range' id='temp1' name='temp1' value='1'  list='values'  min='1' max='4' title='Seleccione un nivel' id='Nivel_".$f['idapp']."' oninput='Niv".$f['idapp']."();' style='width:60px; Opacity:1; position:relative;'/>
          </p> 
          <cite style='color:gray; font-size:8pt;'>".$f['admin_comentario']."</cite>
        <datalist id='values'>
        <option value='1' label='1'></option>
        <option value='2' label='2'></option>
        <option value='3' label='3'></option>
        <option value='4' label='4'></option>
        </datalist>";
        
    }
            
    echo "</td><td class='tchico' style='width: 20%; text-align: center;'>
            <img src='icon/entrar.png' class='icono' title='Agregar a permiso' style='width: 30px; height:30px;'>
            
            </td></tr></table></li>";







        }        
            echo "</ul>";  
    echo "</div>";
      
        
      echo "<div class='list' id='divColaboradores' style='height:auto;'>";
      echo "<ul class='colaboradores'>";  
        
      $query = "select * from aplicaciones  where 
          aplicaciones.idapp  IN
          (
              SELECT aplicaciones_permisos.idapp
              FROM aplicaciones_permisos
              WHERE nitavu = ".$nitavuemp."
          ) and aplicaciones.estado=0 order by nombre asc ";
          echo $query;
         $r = $conexion -> query($query);
           while($f = $r -> fetch_array())
           { // resultado de la busqueda.................      
         
              
              echo "<li id='".$f['idapp']."_".$nitavuemp."' onclick=QuitarPermiso('".$f['idapp']."','".$nitavuemp."'); >";
             
              echo"<table style='width:100%'><tr><td class='tchico' style='width: 20%; text-align: center;'>
             <img src='icon/atras2.png' class='icono' title='Quitar permisos' style='width: 30px; height:30px;'>
             </td><td style='width: 80%;'>
            <span class='tchico normal'>".$f['nombre']."</span>
          
            </td></tr></table>";
      echo "</li>";
           }        
      echo "</ul>"; 
  echo "</div>";
   
?>
