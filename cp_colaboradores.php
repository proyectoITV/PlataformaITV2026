<?php
require ("config.php");
// echo "<ul class='done'>";
//include ("./lib/body_head.php");

require_once('seguridad.php');
require_once('lib/funciones.php');
require('lib/flor_funciones.php');
require('lib/yes_funciones.php');

 $nitavuemp= $_POST['nitavu'];
 $numcaso= $_POST['numcaso'];
 //$quien = $nitavu;
 $quien = $_POST['nitavu1'];

   $sql = "INSERT INTO cp_colaboradores(nitavu, numcaso,quienautorizo,activo)  
   VALUES ($nitavuemp,$numcaso,'$quien',0)";
      
    if ($conexion->query($sql) == TRUE){

      revisarSiTienePermiso($nitavuemp); 
      if(revisarSiTienePermiso($nitavuemp)=='TRUE'){
        //echo "Empleado Guardado Correctamente"; 
        historia($nitavu,'Agregó como colaborador al caso: '.$numcaso.' a '.nitavu_nombre($nitavuemp));
        notificarParticipantes($numcaso,$nitavu,'Se agregó como colaborador al caso:<b> '.$numcaso.' a '.nitavu_nombre($nitavuemp).'</b><br>Asunto:<b>'.asuntoCaso($numcaso).'<b/>','Nuevo colaborador al caso '.$numcaso); 
      
        //AGREGAR COMENTARIO DE CUANTO SE COMPARTIO EL CASO
        $comentario='Se agregó como colaborador a '.nitavu_nombre($nitavuemp);
        $sql = "INSERT INTO cp_comentarios (CasoId, Comentario,  Nuser, Fecha, Hora) 
        VALUES ('$numcaso', '$comentario', '$nitavu', '$fecha', '$hora')";      
        if ($conexion->query($sql) == TRUE)
            {

              historia($nitavu,'cp_Comentar caso: '.$numcaso.' Agrego el comentario: '.'Se agregó como colaborador a"'.nitavu_nombre($nitavuemp)."'");      
            }

      }else{
       
        $res = darPermisoNivelDosAColaborador($nitavuemp,'ap66',2,$nitavu,'Estoy agregando a un colaborador sin permiso, por eso otrogo nivel 2.' );
     
        if($res == "TRUE"){
          historia($nitavu,'Agregó como colaborador al caso: '.$numcaso.' a '.nitavu_nombre($nitavuemp));       
          notificarParticipantes($numcaso,$nitavu,'Se agregó como colaborador al caso:<b> '.$numcaso.' a '.nitavu_nombre($nitavuemp).'</b><br>Asunto:<b>'.asuntoCaso($numcaso).'<b/>','Nuevo colaborador al caso '.$numcaso); 
          
            //AGREGAR COMENTARIO DE CUANTO SE COMPARTIO EL CASO          
          $comentario='Se agregó como colaborador a '.nitavu_nombre($nitavuemp);
          $sql = "INSERT INTO cp_comentarios (CasoId, Comentario,  Nuser, Fecha, Hora) 
          VALUES ('$numcaso', '$comentario', '$nitavu', '$fecha', '$hora')";
          
          if ($conexion->query($sql) == TRUE)
              {
                historia($nitavu,'cp_Comentar caso: '.$numcaso.' Agrego el comentario: '.'Se agregó como colaborador a"'.nitavu_nombre($nitavuemp)."'");            
              }
        
        
        }else{
        
          mensaje('Ocurrio un error, favor de volver a intentarlo.','cp_nuevos_oficios&id='.$numcaso.'');
        }
        
      }    
    }else{// echo "Empleado no se Guardado Correctamente";
    }
    
   

 

echo "<div id='bloque' style='height:60px;'>";   
    echo "<div style='display: inline-block;    width: 40%;     vertical-align: top;' >"; 
     echo "<h4>Titulares de las Areas:</h4>";   
    echo "</div>";
    
    echo "<div style='display: inline-block;    width: 40%;     vertical-align: top;'  >"; 
     echo "<h4>Colaboradores del Caso::</h4>";   
    echo "</div>";  
    echo "</div>"; 
    echo "<div class='list' id='divEmpleados' >";     
          echo "<ul class='empleados'>";
        
           //-------------FILTRO DIRECCION JURIDICA
			$res = SoyDireccionJuridica($nitavu);
      $flag=0;
			for($i=0; $i<sizeof($res); $i++){
				//echo $res[$i];
        if(nitavu_dpto($nitavu) == $res[$i]){ 
          $flag = 1;
        }
      }
      
      if($flag==1){
        $query="-- cp
        SELECT empleados.nombre, empleados.departamento, empleados.puesto, empleados.nitavu, cat_gerarquia.titular 
       FROM empleados 
      inner join cat_gerarquia on empleados.nitavu=cat_gerarquia.titular
      WHERE empleados.nitavu not in (SELECT nitavu from cp_colaboradores where numcaso=".$numcaso." and activo = 0)
      and empleados.dpto in (".misdptos(directorJuridico()).")
      and empleados.nitavu <> ".$nitavu." and empleados.estado = ''
UNION
      SELECT empleados.nombre, empleados.departamento, empleados.puesto, empleados.nitavu, 'no'
       FROM empleados 
       WHERE empleados.nitavu not in (SELECT nitavu from cp_colaboradores where numcaso=".$numcaso." and activo = 0)
       and empleados.nitavu not in(SELECT titular from cat_gerarquia)  
       and empleados.dpto in (".misdptos(directorJuridico()).")
       and empleados.nitavu <> ".$nitavu." and empleados.estado = ''
         ORDER by nombre ASC";
       // echo $query;
      }else{
        if(strlen (titular(nitavu_dpto($nitavu)))>0)
        {
        $query="-- cp
        SELECT DISTINCT empleados.nombre, cat_gerarquia.nombre as departamento, empleados.puesto, empleados.nitavu, cat_gerarquia.titular FROM empleados
       inner join cat_gerarquia on empleados.nitavu=cat_gerarquia.titular
       inner join aplicaciones_permisos as permisos on permisos.nitavu=empleados.nitavu
       and  empleados.nitavu not in (SELECT nitavu from cp_colaboradores where numcaso=".$numcaso.") 
       and  empleados.nitavu<>".$nitavu." and empleados.nitavu<>".titular(nitavu_dpto($nitavu))." and permisos.idapp='ap66' and empleados.estado = ''
       union select empleados.nombre, empleados.departamento, empleados.puesto, empleados.nitavu, 'no'
       from empleados inner join aplicaciones_permisos as permisos on permisos.nitavu=empleados.nitavu
       where empleados.dpto=".nitavu_dpto($nitavu)." and empleados.nitavu<>".titular(nitavu_dpto($nitavu))."
       and  empleados.nitavu not in (SELECT nitavu from cp_colaboradores where numcaso=".$numcaso." and activo=0) 
       and  empleados.nitavu<>".$nitavu." and permisos.idapp='ap66' and empleados.estado = '' order by nombre asc";
        }else
        {
          $query="-- cp
        SELECT DISTINCT empleados.nombre, cat_gerarquia.nombre as departamento, empleados.puesto, empleados.nitavu, cat_gerarquia.titular FROM empleados
       inner join cat_gerarquia on empleados.nitavu=cat_gerarquia.titular
       inner join aplicaciones_permisos as permisos on permisos.nitavu=empleados.nitavu
       and  empleados.nitavu not in (SELECT nitavu from cp_colaboradores where numcaso=".$numcaso.") 
       and  empleados.nitavu<>".$nitavu." and permisos.idapp='ap66' and empleados.estado = ''
       union select empleados.nombre, empleados.departamento, empleados.puesto, empleados.nitavu, 'no'
       from empleados inner join aplicaciones_permisos as permisos on permisos.nitavu=empleados.nitavu
       where empleados.dpto=".nitavu_dpto($nitavu)."
       and  empleados.nitavu not in (SELECT nitavu from cp_colaboradores where numcaso=".$numcaso." and activo=0) 
       and  empleados.nitavu<>".$nitavu." and permisos.idapp='ap66' and empleados.estado = '' order by nombre asc";
        }
      }
    //echo $query;
          $descripcion = '';
          $r = $conexion -> query($query);
          while($f = $r -> fetch_array())
          { // resultado de la busqueda.................   
            if($f['titular']=="no"){   
              echo "<li id='".$f['nitavu']."_".$numcaso."' onclick=AgregarColaboradores('".$numcaso."','".$f['nitavu']."'); style='background: #e6e6e1;' >";
            }else{
              echo "<li id='".$f['nitavu']."_".$numcaso."' onclick=AgregarColaboradores('".$numcaso."','".$f['nitavu']."'); >";
            }   
            
              echo " <table width=100%><tr><td style='width: 80%;'>
                <span class='tchico normal'>".$f['nombre']."</span>
                <span class='tchico'><br>".$f['departamento']."</span>
                </td><td width=40px class='tchico' style='width: 20%; text-align: center;'>
                <img src='icon/entrar.png' class='icono' title='Aregar a colaboradores' style='width: 30px; height:30px;'>
                </td></tr></table></li>";
          }        
          echo "</ul>";  
      echo "</div>";
      
        
          echo "<div class='list' id=divColaboradores >";
            echo "<ul class='colaboradores'>";               
               $query = "-- cp
               SELECT empleados.nombre, cat_gerarquia.nombre as departamento, empleados.puesto, empleados.nitavu, ifnull(cat_gerarquia.titular,'no') as titular FROM cp_colaboradores inner join empleados
               on cp_colaboradores.nitavu=empleados.nitavu left join cat_gerarquia on cat_gerarquia.titular=empleados.nitavu where  numcaso=".$numcaso." and cp_colaboradores.activo=0 order by cp_colaboradores.id desc"; 
               
               $r = $conexion -> query($query);
                while($f = $r -> fetch_array())
                { // resultado de la busqueda.................      
                 
                    if($f['titular']=="no")
                    {   
                    echo "<li id='".$f['nitavu']."_".$numcaso."' onclick=QuitarColaboradores('".$numcaso."','".$f['nitavu']."'); style='background: #e6e6e1;' >";
                    }else
                    {
                    echo "<li id='".$f['nitavu']."_".$numcaso."' onclick=QuitarColaboradores('".$numcaso."','".$f['nitavu']."'); >";
                    }   
                    echo"<table><tr><td class='tchico' style='width: 20%; text-align: center;'>
                   <img src='icon/atras2.png' class='icono' title='Quitar de colaboradores' style='width: 30px; height:30px;'>
                   </td><td style='width: 80%;'>
                  <span class='tchico normal'>".$f['nombre']."</span>
                  <span class='tchico '><br>".$f['departamento']."</span>
                  </td></tr></table></li>";
                }        
            echo "</ul>"; 
        echo "</div>";
   
?>


   