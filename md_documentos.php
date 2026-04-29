<?php include ("./lib/body_head.php"); include ("./lib/body_menu.php"); ?>

<?php

require("config.php");
$id_aplicacion = 'ap70';
xd_update('ap70',$nitavu);//guarda la experiencia del usuario
echo "<div id='AppDetalle'>".app_detalle($id_aplicacion, $nitavu)."</div>";
//PROCESO PARA TOCAR LA PUERTA DE SAN PEDRO
$nivel =aplicacion_nivel($id_aplicacion, $nitavu);
if (sanpedro($id_aplicacion, $nitavu)==TRUE){
  echo "<br><br>";
    

    if(isset($_GET['id']) and isset($_GET['idcolonia']) and isset($_GET['idmunicipio'])  ){
      
      $idmandante = $_GET['id'];
      $idcolonia = $_GET['idcolonia'];
      $idmunicipio = $_GET['idmunicipio'];

      //ELIMINAR UN DOCUMENTO
      if(isset($_POST['ndocumento'])){
        $ndocumento = $_POST['ndocumento'];
        echo "entro";
        $res = eliminarDocumentoMandantes($ndocumento);
        if($res==TRUE){
          historia($nitavu, 'Elimine un archivo de documentos con id'.$ndocumento.'del Mandante '.$idmandante.' colonia '.$idcolonia.' municipio '.$idmunicipio);
          mensaje('Se ha eliminado el archivo con éxito.',"md_documentos.php?id=".$idmandante."&idcolonia=".$idcolonia."&idmunicipio=".$idmunicipio."");
        }else{
          mensaje('Ocurrio un problema al momento de eliminar el archivo, por favor intentelo de nuevo.',"md_documentos.php?id=".$idmandante."&idcolonia=".$idcolonia."&idmunicipio=".$idmunicipio."");

        }
      }
      echo '<a id="regCargo" href="mandantes_pago.php?idmandante='.$idmandante.'&idcolonia='.$idcolonia.'&idmunicipio='.$idmunicipio.'" title="Clic para regresar a la página anterior"><ins>Regresar</ins></a>';

    echo "<center><div style='width:70%;' >";
    echo "<h2>Documentos del mandante</h2>";
        historia($nitavu,'Entre a la pantalla documentos del mandante: idmandante: '.$idmandante.' idcolonia: '.$idcolonia.' idmunicipio:'.$idmunicipio.'');

       $sql = "SELECT ndocumento, nombre, nitavusube FROM mandantes_documentos, documentos WHERE mandantes_documentos.idmandante=".$idmandante." and mandantes_documentos.idcolonia=".$idcolonia." and mandantes_documentos.idmunicipio=".$idmunicipio." and mandantes_documentos.n_archivo=documentos.ndocumento and mandantes_documentos.idpago = 0";
       //echo $sql;
       $rc = $conexion -> query($sql);

        if ($rc->num_rows>0){
          echo "<table id='registros' class='tabla'  >";
          echo "<th>Nombre archivo</th>";
          while($r = $rc -> fetch_array()){
            echo "<tr>";
              echo "<td>";
                $archivo = "docs_mandantes/".$r['ndocumento'].'_'.$r['nombre']; 
                 
                $link = "<a style='font-size:12px;' id=".$r['ndocumento']." name='$archivo' href='md_descargar.php?nombre=".$archivo."' target='_self'  onclick =''  title='Haga click aqui para descargar'>".$r['nombre']."</a>";
                echo $link;//archivo
              echo "</td>";
              if($r['nitavusube']==$nitavu) {

                echo "<td style='width:40px;' class='pc' >";
                echo '<center>';
                echo "<form  action='md_documentos.php?id=".$idmandante."&idcolonia=".$idcolonia."&idmunicipio=".$idmunicipio."' method='POST'>";
                echo '<input type="hidden" name="ndocumento" id="ndocumento" value='.$r['ndocumento'].'>'; //style='width:15px; height:15px;'
                echo "<button style='width:30px; height:25px;' class='Mbtn btn-cancel' type='submit' title='Haga clic para eliminar el archivo'> <img src='icon/delete.png' style='width:10px; height:10px;'> </button>";
                
                echo "</form>";
                echo '</center>';
                echo "</td>";
               }
            echo "</tr>";
          }
        }
        echo "</table>";

        echo "<br><br>";
          echo "<form action='md_documentos.php?id=".$idmandante."&idcolonia=".$idcolonia."&idmunicipio=".$idmunicipio."' method='POST'  enctype='multipart/form-data'>";
              echo "<label>Seleccione los archivos que se van a agregar como anexos</label>";
              echo "<input type='hidden' name='idmandante1' id='idmandante1' value='".$idmandante."'>";
              echo "<input type='hidden' name='idcolonia1' id='idcolonia1' value='".$idcolonia."'>";
              echo "<input type='hidden' name='idmunicipio1' id='idmunicipio1' value='".$idmunicipio."'>";
              echo '<input id="archivo[]" name="archivo[]" type="file" accept=".pdf" multiple="" required>';
              echo "<button type='submit' class='Mbtn btn-danger' title='Haga clic para subir el archivo'> Subir archivos </button>";
          echo "</form>"; 
      echo "</div></center>";


      //SUBIR ANEXOS
      if(isset($_POST['idmandante1'])){
        $idmandante = $_POST['idmandante1']; 
        $idcolonia = $_POST['idcolonia1']; 
        $idmunicipio = $_POST['idmunicipio1']; 
        //Como el elemento es un arreglos utilizamos foreach para extraer todos los valores
        foreach($_FILES["archivo"]['tmp_name'] as $key => $tmp_name){
          //Validamos que el archivo exista
          if($_FILES["archivo"]["name"][$key]){
            $doc = $_FILES["archivo"]["name"][$key]; //Obtenemos el nombre original del archivo
            $tmp = $_FILES["archivo"]["tmp_name"][$key]; //Obtenemos un nombre temporal del archivo
            $num = ndocumento(TRUE);
            //$directorio = 'docs/'; //Declaramos un  variable con la ruta donde guardaremos los archivos
            $archivo = "docs_mandantes/".$num."_".$doc."";
            $subida = FTP_subir($tmp,$archivo);
            

            if ($subida == "TRUE"){
              documento_add($num, $doc, $nitavu,$id_aplicacion);
              $sql = "INSERT INTO mandantes_documentos (idmunicipio, idcolonia, idmandante, n_archivo, idpago) VALUES  ('$idmunicipio','$idcolonia','$idmandante','$num',0)";
              if ($conexion->query($sql) == TRUE){ 
                ndocumento(FALSE);
                historia($nitavu,'md_Subí un documento al mandante: '.$idmandante .' archivo: '.$doc);
                mensaje('Se ha subido el archivo con éxito.','md_documentos.php?id='.$idmandante.'&idcolonia='.$idcolonia.'&idmunicipio='.$idmunicipio.'');  
              }else{
                historia($nitavu,'No se pudo guardar la informacion del archivo: '.$doc.' en la base de datos del mamdante: idmandante: '.$idmandante.' idcolonia: '.$idcolonia.' idmunicipio:'.$idmunicipio.'');
                mensaje('Hubo un error al momento de subir los archivos, por favor vuelva a intentarlo.','md_documentos.php?id='.$idmandante.'&idcolonia='.$idcolonia.'&idmunicipio='.$idmunicipio.'');
              }      
            }else{    
              historia($nitavu,'No se pudo guardar el documento en el servidor FTP, archivo: '.$doc.' del mamdante: idmandante: '.$idmandante.' idcolonia: '.$idcolonia.' idmunicipio:'.$idmunicipio.'');                                                                                                                             
              mensaje('Hubo un error al momento de subir el archivo, por favor vuelva a intentarlo.','md_documentos.php?id='.$idmandante.'&idcolonia='.$idcolonia.'&idmunicipio='.$idmunicipio.'');
            }
          }
            
        }
          
      }

    }

     
}
else{
    mensaje("No tiene acceso a ".$id_aplicacion,'');
}

    
    
?>
<br><br><br>
<br>
<br>
<br><br><br>
<br>
<br>
<br><br><br>
<br>
<br>
<br><br><br>
<br>
<br>
<?php include ("./lib/body_footer.php"); ?>