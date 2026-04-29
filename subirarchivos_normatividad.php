<link href="css/style.css" rel="stylesheet">
<link href="css/slick.css" rel="stylesheet">
<link href="css/responsive.css" rel="stylesheet">

<?php
//require("config.php");
include ("./lib/body_head.php"); include ("./lib/body_menu.php");
require_once('lib/laura_funciones.php');
require_once('lib/flor_funciones.php');
require_once('lib/yes_funciones.php');
?>


<?php
$id_aplicacion ="ci";
xd_update('ci',$nitavu);//guarda la experiencia del usuario
$nivel =aplicacion_nivel($id_aplicacion, $nitavu);
echo "<div id='AppDetalle'>".app_detalle($id_aplicacion, $nitavu)."</div>";



 
            //Subir archivo en el historial
            if(isset($_POST['subirHistorial']) ){
                ///mensaje( 'entro a subir','subirarchivos_normatividad.php');

                $dir_subida = 'ci/';
                $fichero_subido = $dir_subida . basename($_FILES['nuevoDoc']['name']);
                $nombre= basename($_FILES['nuevoDoc']['name']);
                echo '<pre>';
                if (move_uploaded_file($_FILES['nuevoDoc']['tmp_name'], $fichero_subido)) {
                 //   echo "El fichero es válido y se subió con éxito.\n";
                   // echo  $fichero_subido;
                    


                    $pos = strpos($nombre, '.');
                    $extension=substr($nombre,$pos+1,strlen($nombre));

                    $id=ObtenerIdCid();
                    $id=$id+1;
                    if($extension=='mp4')
                    {
                      $icon='video.png';
                      $descripcion='Video';
                    }else
                    {   $icon='pdf.png';
                      $descripcion='Documento';
                    }
                    
                           $sql = "INSERT INTO ci(IdCi, Nombre, Descripcion, Link,Cancelado,icon,fechadepublicacion) 
                              VALUES ($id, '$nombre', '$descripcion', '$nombre', '0', '$icon', Now())";
                           if ($conexion->query($sql) == TRUE){ 
                            mensaje('Archivo subido con exito','ci.php');  
                       
                        }else{
                          mensaje('Ocurrio un error al momento de subir el archivo.','subirarchivos_normatividad.php');   
                        }

                }
                else{
                  mensaje('Ocurrio un error al momento de subir el archivo.','subirarchivos_normatividad.php');   
                }
                
              }

              //ELIMINAR UN ARCHIVO DEL HISTORIAL DE DOCUMENTOS
              if(isset($_GET['idDoc'])){
                $idDoc = $_GET['idDoc'];
               // $id = $_POST['id'];
                //$numDoc = $_POST['numDoc'];
                
                 $sql = "Update ci SET cancelado=1 WHERE IdCi=".$idDoc."";
                 echo $sql;
                 if ($conexion->query($sql) == TRUE){
                  historia($nitavu,'cp_Elimine (marco como eliminado) el archivo con id: '.$idDoc);
    
                  mensaje('Se ha eliminado con éxito el archivo.','ci.php'); 
              
                }else{
                  mensaje('Ocurrio un error al momento de eliminar, por favor intentelo de nuevo.','subirarchivos_normatividad.php'); 
                 }
              }

echo "<div id='anexos'>";

echo "
<section class='page-title' style='background-image:url(img/controlinterno.jpg); '>
    <div class='auto-container'>
        <h2>Departamento de Control Interno</h2>
    </div>
</section>
";

echo "<br>";
echo "
<div class='content'>
    <h1 style = 'color:black; text-align: center;'>Historial de archivos</h1>
</div>
";

echo "<div class='container' style='background-color: #ddddddb0; padding: 20px; border-radius: 10px; margin-top: 30px; '>";
  echo "<table class='styled-table' width='100%'>";
  echo "<thead>";
  echo "<tr>";
          echo "<th width='2%'>Cve</th>";
          echo "<th width='55%'>Nombre del documento</th>";
          echo "<th width='00%'>Descripcion</th>";
          echo "<th width='10%'>Vistas</th>";
          Echo "<th width='13%'>Publicación</th>";
          Echo "<th width='10%'>Acción</th>";
  echo "</tr>";
  echo "</thead>";
  echo "<tbody>";
      require("config.php");
      $sql="select * from ci_html";
      $r = $conexion -> query($sql);
      while($f = $r-> fetch_array()) 
        {
          echo "<tr>";
            echo "<td>".$f["IdCi"]."</td>";
            echo "<td>".$f["Documento"]."</td>";
            echo "<td>".$f["Descripcion"]."</td>";
            echo "<td>".$f["Vistas"]."</td>";
            echo "<td>".substr($f["fechadepublicacion"], 0, 16)."</td>";
            echo "<td style=' text-align: center;'>";
              echo "<form action='subirarchivos_normatividad.php?idDoc=".$f['IdCi']."' method='POST'>";
                echo "<button type='submit' class='Mbtn btn-cancel' title='Haga clic para eliminar el archivo'> <img src='icon/delete.png' style='width:20px; '> </button>";
              echo "</form>";
            echo "</td>";
          echo "</tr>";
        }

        echo "<td></td>";
      
        echo '<td>';
          echo "<form action='subirarchivos_normatividad.php' method='POST' enctype='multipart/form-data'>"; 
          echo '<input type="hidden" name="subirHistorial" value="1">';
          echo '<input name="nuevoDoc" type="file">';
        echo '</td>';

        echo "<td></td>";
        echo "<td></td>";
        echo "<td></td>";
      
        echo "<td style=' text-align: center;'><button type='submit' class='Mbtn btn-default' title='Haga clic para subir el archivo'> <img src='icon/subirDoc.png' style='width:20px; '> </button></td>";
        echo "</form>";
        echo "</tr>";
        
  echo "</tbody>";
  echo "</table>";
echo "<div>";
                                                                                                                                                                                                                                                                  
/* $anexos = "select * from ci where cancelado=0";
$rc= $conexion -> query($anexos); 
if ($rc->num_rows>0){
  echo "<center>";
  echo "<div style='width:100%;' >";
  echo "<br>";
  echo "<h4>Archivos disponibles</h4>";
  echo "<table id='historialTabla' class='styled-table' width='80%'>";

  echo "<thead>";
  echo "<tr>";
          echo "<th width='2%'>Cve</th>";
          echo "<th width='65%'>Nombre Archivo</th>";
          echo "<th width='10%'>Tipo</th>";
          echo "<th width='13%'>Publicación</th>";
          echo "<th width='10%'>Acción</th>";
  echo "</tr>";
  echo "</thead>";

  while($r = $rc -> fetch_array())    
  {
    echo "<tr>";
    echo "<td>".$r['IdCi']."</td>";
    echo "<td>".$r['Nombre']."</td>";
    echo "<td>".$r['Descripcion']."</td>";
    echo "<td>".substr($r["fechadepublicacion"], 0, 16)."</td>";
    echo "<td style=' text-align: center;'>";
    echo "<form action='subirarchivos_normatividad.php?idDoc=".$r['IdCi']."' method='POST'>";
    echo "<button type='submit' class='Mbtn btn-cancel' title='Haga clic para eliminar el archivo'> <img src='icon/delete.png' style='width:20px; '> </button>";
    echo "</form>";
    echo "</td>";
  }

  echo "</tr>";
  echo "<tr>";

  echo "<td></td>";
  echo "<td></td>";

  echo '<td>';
    echo "<form action='subirarchivos_normatividad.php' method='POST' enctype='multipart/form-data'>"; 
    echo '<input type="hidden" name="subirHistorial" value="1">';
    echo '<input name="nuevoDoc" type="file">';
  echo '</td>';

  echo "<td style=' text-align: center;'><button type='submit' class='Mbtn btn-default' title='Haga clic para subir el archivo'> <img src='icon/subirDoc.png' style='width:20px; '> </button></td>";
  echo "</form>";
  echo "</tr>";
  echo "</table>"; */

echo "</div>";
echo "</center>";

echo "</div>";
?>

<?php include ("./lib/body_footer.php"); ?>
