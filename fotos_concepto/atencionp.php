<?php
include ("./unica/body_head.php");
include ("./unica/body_menu.php");
$id_aplicacion ="atencionp"; //ap06=Permisos de Aplicacion
if (sanpedro($id_aplicacion, $nitavu)==TRUE){
    echo "<h5>".app_detalle($id_aplicacion)."</h5>";
    echo "<table width=100%><tr><td width=30% valign=top>";
    WOWSlider('atencionp','100%','70%');

    echo "</td><td>";
        $sql="select * from WOWSlider WHERE idapp='atencionp'";
        $r= $conexion -> query($sql);
        echo "<div id='imagenes'>";
        while($f = $r -> fetch_array()) {
            echo "<article class='IMGnormal'>";
                echo "<a class='btn btn-cancel' href='atencionp.php?x=".$f['id']."' id='cerrar'><img src='icon/cancel.png' style='width:18px;'></a>";
                echo "<img src='".$f['src']."' title='".$f['fecha']." | ".$f['hora']."'>";
                echo "<br><b>".$f['Titulo']."</b>";

            echo "</article>";
        }
        echo "<article class='IMGnuevo' id='IMGSubir'>";
        echo "<form method='POST' enctype='multipart/form-data' id='IMGSubirForm' >";    
        // echo "<input type='text' name='IdApp' value='".$id_aplicacion."'>";
        echo "<label>Seleccione la imagen para subir: </label><input type='file' name='archivo' accept='image/jpeg'><br>";
        echo "<label>Titulo: </label><input type='text' name='titulo'><br>";
        
        echo "<input type='submit' name='btnSubir' class='btn btn-azulTam' value='Guardar'>";
        echo "</form>";
        echo "<div id='R'></div>";
        echo "</article>";
        echo "</div>";
    echo "</td></tr></table>";
    

    if (isset($_GET['x'])){
            $sql = "DELETE FROM WOWSlider WHERE (id='".$_GET['x']."')";
             if ($conexion->query($sql) == TRUE){
               mensaje("Archivo eliminado correctamente ","atencionp.php?sl=");
            }
            
    }

} else {mensaje("ERROR: no tienes acceso a esta aplicacion","");}



?>
<script>
    
        $("#IMGSubirForm").on("submit", function(e){
            // alert('Click');
            e.preventDefault();
            var f = $(this);
            var formData = new FormData(document.getElementById("IMGSubirForm"));
                formData.append("IdApp", "atencionp");
                formData.append("nitavu", "<?php echo $nitavu; ?>");
                

            $.ajax({
                url: "atencionp_upload.php",
                type: "post",
                dataType: "html",
                data: formData,             
                cache: false,
                contentType: false,
                processData: false,
                beforeSend:function(){
                    $('#R').html('<img src="img/loader5.gif">');
                },
                success:function(data){
                    console.log(data);
                    $('#R').html(data);
                }
            });
        
        });



    // var form_data = new FormData();
    //     form_data.append("file",property);
    //     $.ajax({
    //       url:'upload.php',
    //       method:'POST',
    //       data:form_data,
    //       contentType:false,
    //       cache:false,
    //       processData:false,
    //       beforeSend:function(){
    //         $('#msg').html('Loading......');
    //       },
    //       success:function(data){
    //         console.log(data);
    //         $('#msg').html(data);
    //       }
    //     });
    </script>
<?php
include ("./unica/body_footer.php");
?>
