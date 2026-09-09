<?php 
include ("./lib/body_head.php"); 
include ("./lib/body_menu.php"); 
?>
<link rel="stylesheet" href="lib/laura.css" />
<link rel="stylesheet" href="lib/plataforma_modern.css" />
<?php
require("config.php");
$id_aplicacion = 'ap70';
xd_update('ap70',$nitavu);//guarda la experiencia del usuario
echo "<div id='AppDetalle'>".app_detalle($id_aplicacion, $nitavu)."</div>";

//PROCESO PARA TOCAR LA PUERTA DE SAN PEDRO
$nivel = aplicacion_nivel($id_aplicacion, $nitavu);
if (sanpedro($id_aplicacion, $nitavu) == TRUE){

    if(isset($_GET['id']) and isset($_GET['idcolonia']) and isset($_GET['idmunicipio'])){
        $idmandante = $_GET['id'];
        $idcolonia = $_GET['idcolonia'];
        $idmunicipio = $_GET['idmunicipio'];

        // ELIMINAR UN DOCUMENTO
        if(isset($_POST['ndocumento'])){
            $ndocumento = $_POST['ndocumento'];
            $res = eliminarDocumentoMandantes($ndocumento);
            if($res == TRUE){
                historia($nitavu, 'Elimine un archivo de documentos con id'.$ndocumento.'del Mandante '.$idmandante.' colonia '.$idcolonia.' municipio '.$idmunicipio);
                mensaje('Se ha eliminado el archivo con éxito.',"md_documentos.php?id=".$idmandante."&idcolonia=".$idcolonia."&idmunicipio=".$idmunicipio."");
            }else{
                mensaje('Ocurrio un problema al momento de eliminar el archivo, por favor intentelo de nuevo.',"md_documentos.php?id=".$idmandante."&idcolonia=".$idcolonia."&idmunicipio=".$idmunicipio."");
            }
        }

        // SUBIR ANEXOS
        if(isset($_POST['idmandante1'])){
            $idmandante_post = $_POST['idmandante1']; 
            $idcolonia_post = $_POST['idcolonia1']; 
            $idmunicipio_post = $_POST['idmunicipio1']; 

            foreach($_FILES["archivo"]['tmp_name'] as $key => $tmp_name){
                if($_FILES["archivo"]["name"][$key]){
                    $doc = $_FILES["archivo"]["name"][$key];
                    $tmp = $_FILES["archivo"]["tmp_name"][$key];
                    $num = ndocumento(TRUE);
                    $archivo = "docs_mandantes/".$num."_".$doc."";
                    $subida = FTP_subir($tmp,$archivo);

                    if ($subida == "TRUE"){
                        documento_add($num, $doc, $nitavu,$id_aplicacion);
                        $sql = "INSERT INTO mandantes_documentos (idmunicipio, idcolonia, idmandante, n_archivo, idpago) VALUES ('$idmunicipio_post','$idcolonia_post','$idmandante_post','$num',0)";
                        if ($conexion->query($sql) == TRUE){ 
                            ndocumento(FALSE);
                            historia($nitavu,'md_Subí un documento al mandante: '.$idmandante_post .' archivo: '.$doc);
                            mensaje('Se ha subido el archivo con éxito.','md_documentos.php?id='.$idmandante_post.'&idcolonia='.$idcolonia_post.'&idmunicipio='.$idmunicipio_post.'');  
                        }else{
                            historia($nitavu,'No se pudo guardar la informacion del archivo: '.$doc.' en la base de datos del mandante');
                            mensaje('Hubo un error al momento de subir los archivos, por favor vuelva a intentarlo.','md_documentos.php?id='.$idmandante_post.'&idcolonia='.$idcolonia_post.'&idmunicipio='.$idmunicipio_post.'');
                        }      
                    }else{    
                        historia($nitavu,'No se pudo guardar el documento en el servidor FTP, archivo: '.$doc);
                        mensaje('Hubo un error al momento de subir el archivo, por favor vuelva a intentarlo.','md_documentos.php?id='.$idmandante_post.'&idcolonia='.$idcolonia_post.'&idmunicipio='.$idmunicipio_post.'');
                    }
                }
            }
        }

        historia($nitavu,'Entre a la pantalla documentos del mandante: idmandante: '.$idmandante.' idcolonia: '.$idcolonia.' idmunicipio:'.$idmunicipio.'');
?>

<div class="cd-wrapper">
    <!-- Hero Banner -->
    <div class="cd-hero">
        <div>
            <h1 class="cd-hero-title">
                <i class="fa-solid fa-folder-open"></i> Documentos y Expediente del Mandante
            </h1>
            <div class="cd-hero-dept">
                <i class="fa-solid fa-building"></i> Municipio: <span><?php echo strtoupper(nombreMunicipio($idmunicipio)); ?></span> | Colonia: <span><?php echo strtoupper(nombreColonia($idmunicipio,$idcolonia)); ?></span>
            </div>
        </div>
        <div class="cd-top-links">
            <a href="mandantes_pago.php?idmandante=<?php echo $idmandante; ?>&idcolonia=<?php echo $idcolonia; ?>&idmunicipio=<?php echo $idmunicipio; ?>" class="cd-top-link-btn" title="Regresar al control de pagos">
                <i class="fa-solid fa-arrow-left"></i> Regresar a Pago
            </a>
        </div>
    </div>

    <!-- Lista de Documentos Registrados -->
    <div class="cd-card-section" style="margin-bottom:24px;">
        <div class="cd-card-header cd-card-header-primary">
            <h3 class="cd-card-title">
                <i class="fa-solid fa-file-pdf"></i> Archivos Adjuntos del Mandante
            </h3>
        </div>
        <div class="cd-card-body" style="padding:0;">
            <div class="cd-table-container">
                <?php
                $sql = "SELECT ndocumento, nombre, nitavusube FROM mandantes_documentos, documentos WHERE mandantes_documentos.idmandante=".$idmandante." and mandantes_documentos.idcolonia=".$idcolonia." and mandantes_documentos.idmunicipio=".$idmunicipio." and mandantes_documentos.n_archivo=documentos.ndocumento and mandantes_documentos.idpago = 0";
                $rc = $conexion->query($sql);

                if ($rc && $rc->num_rows > 0){
                    echo "<table class='cd-table'>";
                    echo "<thead><tr><th>Nombre de Archivo</th><th style='width:140px; text-align:center;'>Descargar</th><th style='width:80px; text-align:center;'>Eliminar</th></tr></thead><tbody>";
                    while($r = $rc->fetch_array()){
                        $archivo = "docs_mandantes/".$r['ndocumento'].'_'.$r['nombre'];
                        echo "<tr>";
                        echo "<td style='font-weight:600;'><i class='fa-solid fa-file-pdf' style='color:#dc2626; margin-right:8px;'></i>".htmlspecialchars($r['nombre'])."</td>";
                        echo "<td style='text-align:center;'><a href='md_descargar.php?nombre=".$archivo."' target='_self' class='cd-btn cd-btn-light' style='padding:4px 12px; font-size:0.82rem;'><i class='fa-solid fa-download'></i> Descargar</a></td>";
                        
                        echo "<td style='text-align:center;'>";
                        if($r['nitavusube'] == $nitavu) {
                            echo "<form action='md_documentos.php?id=".$idmandante."&idcolonia=".$idcolonia."&idmunicipio=".$idmunicipio."' method='POST' style='margin:0;'>";
                            echo "<input type='hidden' name='ndocumento' value='".$r['ndocumento']."'>";
                            echo "<button type='submit' onclick=\"return confirm('¿Desea eliminar este archivo?');\" class='cd-icon-btn delete' title='Eliminar archivo'><i class='fa-solid fa-trash-can'></i></button>";
                            echo "</form>";
                        } else {
                            echo "-";
                        }
                        echo "</td>";
                        echo "</tr>";
                    }
                    echo "</tbody></table>";
                } else {
                    echo "<div style='padding:30px; text-align:center;'><i class='fa-solid fa-folder-open' style='font-size:2.5rem; color:var(--cd-gray-mid); margin-bottom:10px;'></i><p style='color:var(--cd-gray-dark); font-weight:600; margin:0;'>No hay documentos registrados para este mandante.</p></div>";
                }
                ?>
            </div>
        </div>
    </div>

    <!-- Formulario para Subir Nuevos Documentos -->
    <div class="cd-card-section">
        <div class="cd-card-header cd-card-header-gold">
            <h3 class="cd-card-title">
                <i class="fa-solid fa-cloud-arrow-up"></i> Agregar Nuevos Documentos Anexos
            </h3>
        </div>
        <div class="cd-card-body">
            <form action="md_documentos.php?id=<?php echo $idmandante; ?>&idcolonia=<?php echo $idcolonia; ?>&idmunicipio=<?php echo $idmunicipio; ?>" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="idmandante1" value="<?php echo $idmandante; ?>">
                <input type="hidden" name="idcolonia1" value="<?php echo $idcolonia; ?>">
                <input type="hidden" name="idmunicipio1" value="<?php echo $idmunicipio; ?>">

                <div class="cd-form-group">
                    <label class="cd-form-label"><i class="fa-solid fa-file-pdf" style="color:var(--cd-primary);"></i> Seleccione los archivos PDF que se van a agregar:</label>
                    <input id="archivo[]" name="archivo[]" type="file" accept=".pdf" multiple class="cd-form-control" required style="margin-bottom:15px;">
                </div>

                <div style="text-align:right;">
                    <button type="submit" class="cd-btn cd-btn-primary">
                        <i class="fa-solid fa-upload"></i> Subir Archivos al Expediente
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php
    }
} else {
    mensaje("No tiene acceso a ".$id_aplicacion,'');
}
include ("./lib/body_footer.php"); 
?>