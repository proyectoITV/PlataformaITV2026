<?php
require("config.php");
require("lib/funciones.php");
echo "<h1>Historial de Documentos</h1>";

    for($i=0; $i<=100; $i++){

    
      $sql = "SELECT * FROM cp_historialdocumentos";
      $rc= $conexion -> query($sql); 
      if ($rc->num_rows>0){
        echo "<div id=''>";
        echo "<table class='tabla'>";
        echo "<th>ID</th>";
        echo "<th >Oficio Número</th>";
        echo "<th >Nombre Archivo</th>";
        echo "<th >Fecha</th>";
        //echo "<th style='width:10%'></th>";
        while($r = $rc -> fetch_array())    
        {
          echo "<tr>";
          echo "<td>".$r['idInc']."</td>";
          echo "<td>".$r['numOficio']."</td>";
          $archivo = "peticiones/".$r['idDoc'].'_'.$r['NumCaso'].'_'.$r['archivo']."";
           if (FTP_existe_archivo($archivo)=="TRUE"){		
            if (FTP_descargar_doc($archivo)=="TRUE"){
              $archivo = "/tmp/".$archivo;		
              $link= "<a  download='".$archivo."' href='$archivo' target='_blank' class='digitalizados_vinculos' title='Haga click aqui para descargar'>".$r['archivo']."</a>";
              echo "<td>".$link."</td>";//archivo
            }else{echo "<td>No lo puede descargar</td>";}
          }else{				
            echo "<td>".$r['archivo']."</td>";//archivo
            //echo "<td>".$archivo."-no lo encontro</td>";
          }		
          echo "<td style='font-family:Compacta;font-size:15px;'>".$r['fecha']."</td>";
           
        }
      }
      echo '</tr>';
        echo "</table>";
        echo "</div>";
        echo "</div>";
    }
    

?>