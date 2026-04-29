<?php
require ("config.php");
// echo "<ul class='done'>";
include ("./lib/body_head.php");


 $idcampo= $_POST['idcampo'];
 $idprog= $_POST['idprograma'];
    $cam_ant = yaExisteelPrograma($idprog);
    if($cam_ant !=""){
        $sql = "UPDATE esquemasol SET campos=".$cam_ant.",".$idcampo." WHERE idprograma=".$idprog."";
        if ($conexion->query($sql) == TRUE) {
        
        }else{
        
        }
    }else{
        $sql = "INSERT INTO esquemasol(idesquemasolicitud, campos,idprograma)  
        VALUES ('',$idcampo,'$idprog')";
            
            if ($conexion->query($sql) == TRUE){            
            
            }else{
            
            }
    }
   
 

echo "<div id='bloque' style='height:15px;'>";   
    echo "<div style='display: inline-block;    width: 40%;     vertical-align: top;' >"; 
     echo "<h4>Empleados:</h4>";   
    echo "</div>";
    
    echo "<div style='display: inline-block;    width: 40%;     vertical-align: top;'  >"; 
     echo "<h4>Colaboradores:</h4>";   
    echo "</div>";  
    echo "</div>"; 
    
    echo "<div class='list' id='divEmpleados' >";     
          echo "<ul class='empleados'>";
        
        $query="select * from cat_campos where idgrupo = 1";
  
  
        $descripcion = '';
          $r = $conexion -> query($query);
          while($f = $r -> fetch_array())
          { // resultado de la busqueda.................   
             
            echo "<li id='".$f['idcampo']."' onclick=AgregarCampos('".$f['idcampo']."','".$idprog."'); style='background: #e6e6e1;' >";
             
            echo " <table><tr><td style='width: 80%;'>
            <span class='tchico normal'>".$f['campo']."</span>
            </td><td class='tchico' style='width: 20%; text-align: center;'>
            <img src='icon/entrar.png' class='icono' title='Aregar a colaboradores' style='width: 30px; height:30px;'>
            </td></tr></table></li>";
          }        
          echo "</ul>";  
      echo "</div>";
      
        
          echo "<div class='list' id=divColaboradores >";
            echo "<ul class='colaboradores'>";  
               
               $query = "select * from esquemasol where idesquemasolicitud=".$idprog."";
                $r = $conexion -> query($query);
                while($f = $r -> fetch_array())
                { // resultado de la busqueda.................      
                   if($f['campos']!=""){
                        $campos = explode(",", $f['campos']);
                        for($i=0; $i<sizeof($campos); $i++){
                            if($campos[$i]!=null){
                                echo "<li id='".$campos[$i]."' onclick=QuitarCampos('".$campos[$i]."','".$idprog."'); style='background: #e6e6e1;' >";
                      
                                echo"<table><tr><td class='tchico' style='width: 20%; text-align: center;'>
                            <img src='icon/atras2.png' class='icono' title='Quitar de colaboradores' style='width: 30px; height:30px;'>
                            </td><td style='width: 80%;'>
                            <span class='tchico normal'>".nombreDelCampo($campos[$i])."</span>
                            
                            </td></tr></table></li>";
                            }

                            
                        } 
                         
                   }
                   
                }        
            echo "</ul>"; 
        echo "</div>";
    echo "</div>";
  
   
?>