<?php
include ("./lib/body_head.php");
include ("./lib/body_menu.php"); 
$idDepartamento=nitavu_dpto($nitavu);
$id_aplicacion ="DigitalFile";
$nivel =aplicacion_nivel($id_aplicacion, $nitavu);
if (sanpedro($id_aplicacion, $nitavu)==TRUE){

    echo "<div id='AppDetalle'>".app_detalle($id_aplicacion, $nitavu)."</div>";	

    if (!isset($_GET['share']) ){
    echo '
    <div id="DivBuscar" style="padding: 10px;">
    <input class="form-control mr-sm-2" id="InputBusqueda" type="search" placeholder="Busqueda..." aria-label="Busqueda"
    onkeypress="BuscarFiles(1);"
    >
        <div id="PreLoader_buscando" style="
            position: absolute;
            right: 26px;
            margin-top: -24px;
            display:none;
        ">
            <img src="img/loader_bar.gif" style="">

        </div>

    </div>
    ';

    echo "<div id='DivResultado' style='
        font-size: 14pt;
        color: white;
        text-align: center;
    '>";
    echo "</div>";
    }


    if (isset($_GET['share'])){
        $IdFile_share = VarClean($_GET['share']);
        if ($IdFile_share <> ''){
            if (DigitalFile_propietario($IdFile_share) == $nitavu){      
                if (isset($_GET['x'])){
                    $nitavu_declinar = VarClean($_GET['x']);
                    // $nitavu_share = VarClean($_GET['nitavu']);
                    //INSERT
                    $sql = "DELETE FROM digitalfile_permisos WHERE IdFile='".$IdFile_share."' and IdUser='".$nitavu_declinar."'";
                    if ($conexion->query($sql) == TRUE){                   	
                        historia($nitavu, "Retiro Permiso a ".$nitavu_declinar." para usar el Archivo con Id.".$IdFile_share." (".DigitalFile_nombre($IdFile_share).")");
                        mensaje("Se retiro correctamente el permiso a ".nitavu_nombre($nitavu_declinar)."","DigitalFile.php?share=".$IdFile_share);
                    } else {
                        mensaje("ERROR: Hubo un problema al retirar el permiso ".nitavu_nombre($nitavu_share)."","DigitalFile.php?share=".$IdFile_share);
                    }

                }
                
                if (isset($_GET['btnShare'])){
                    $nitavu_share = VarClean($_GET['nitavu']);
                    //INSERT
                    $sql = "INSERT INTO digitalfile_permisos(IdFile, IdUser, Autorizo, fecha, hora) 
                    VALUES ('".$IdFile_share."', '".$nitavu_share."', '".$nitavu."','".$fecha."','".$hora."')";
                    if ($conexion->query($sql) == TRUE){                   	
                        historia($nitavu, "Dio permiso a ".$nitavu_share." para usar el Archivo con Id.".$IdFile_share." (".DigitalFile_nombre($IdFile_share).")");

                        $msgPermiso = "";
                        //Permiso de la Applicacion
                        if (sanpedro("DigitalFile", $nitavu_share)==TRUE){
                            $msgPermiso.=". Este usuario, ya tiene permiso para usar esta aplicación";
                        } else {
                            $sqlI = "INSERT INTO aplicaciones_permisos(nitavu, idapp, nivel, quien_autorizo, fecha_autorizacion, descripcion) 
                            VALUES ('".$nitavu_share."', 'DigitalFile', '1','".$nitavu."','".$fecha."','Se ortorgo automaticamente al compartir el archivo de DigitalFile con id ".$IdFile_share."( ".DigitalFile_nombre($IdFile_share).")')";
                            if ($conexion->query($sqlI) == TRUE){                   	
                                $msgPermiso.=". Se le ha dado permiso al usuario ".$nitavu_share.", para usar esta aplicación.";
                                historia($nitavu, "Dio permiso a ".$nitavu_share." para usar el Archivo con Id.".$IdFile_share." (".DigitalFile_nombre($IdFile_share)."), así mismo acceso a DigitalFile");        
                            
                            } else {
                                $msgPermiso.=". Hubo un error con el usuario ".$nitavu_share.", para darle acceso esta aplicación; Comuniquese con el Dpto. de Informatica.<br>".$sqlI;
                                

                            }

                        }



                        mensaje("Se otorgo correctamente el permiso a ".nitavu_nombre($nitavu_share)."<br>".$msgPermiso,"DigitalFile.php?share=".$IdFile_share);
                    } else {
                        mensaje("ERROR: Hubo un problema al darle el permiso ".nitavu_nombre($nitavu_share)."","DigitalFile.php?share=".$IdFile_share);
                    }
                }
                
                echo "<div id='DF_head' style='
                background-color: #ffc336;
                width: 90%;
                display: inline-block;
                position: relative;
                padding: 10px;
                border-radius: 10px;
                left: 5%;
                '>";
                echo DigitalFile_Info($IdFile_share);
                echo "</div>";

                echo "<div id='Lista' style='
                background-color: white;
                width: 90%;
                display: inline-block;
                position: relative;
                padding: 10px;
                border-radius: 10px;
                left: 5%;
                margin-top: 10px;
                margin-bottom: 10px;
                '>";
                echo "<h4>Usuarios con permiso para ver este archivo:</h4>";
                $sql = "select * from digitalfilepermisos where IdFile='".$IdFile_share."'";
                echo TablaDinamica_MySQL("",$sql,"Usuarios","TblUsuarios","",2);
                echo "</div>";


                echo "<div id='DF_new' style='            
                    background-color: #dadfd8;
                    width: 90%;
                    display: inline-block;
                    position: relative;
                    padding: 10px;
                    border-radius: 10px;
                    left: 5%;
                '><h4 style='color:black'>Otorgar permiso para ver el archivo<br>
                <cite style='font-size:8pt;'>Si aun no tiene acceso a la Aplicacion DigitalFile, se le dara automaticamente al compartir un archivo</cite>
                </h4>";
                echo "<form action='' method='GET'>";
                echo "<table width=100%><tr><td><br><label>Selecciona el empleado:</label><br>";
                echo "<select id='nitavu' name='nitavu'>";
                $sql="select * from empleados where estado='' order by nombre";
                $r= $conexion -> query($sql);
                while($f = $r -> fetch_array()) {
                    echo "<option value='".$f['nitavu']."'>".$f['nombre']."</option>";
                }
                echo "</select></td>";
                echo "<input type='hidden' name='share' value='".$IdFile_share."'>";
                echo "<td width=50px valign=bottom>";
                echo "<input type='submit' name='btnShare' value='Compartir' class='btn btn-success'>";
                echo "</td></tr></table>";

                echo "</form>";
                echo "</div>";
            } else {
                Toast("No tienes permiso para administrar este reporte ".$IdFile_share,2,"");
            }
            

        }
    }
    
    if (isset($_GET['new'])){
        echo "<form method='POST' enctype='multipart/form-data' id='DigitalFileForm' 
        style='
        z-index: 100;
        ' 
        >
        <h4>Subir un nuevo archivo</h4>
        ";    
        // echo "<input type='text' name='IdApp' value='".$id_aplicacion."'>";
        echo '
        
            <div class="custom-file ">
                <input type="file" class="custom-file-input" 
                id="archivo" class="form-control" name="archivo" accept="application/pdf"
                >
                <label class="custom-file-label" for="archivo">Archivo a Subir</label>
            </div>
        
        ';

        
      
        echo '        
            <label for="Descripcion"><br>Descripcion: (max 255char) </label>        
            <textarea class="form-control" name="Descripcion" id="Descripcion"></textarea>
            <small id="emailHelp" class="form-text text-muted"></small>        
        ';



        echo '       
        <label for="Descripcion"><br>Tags: (Organizacion por Tag) </label>       
        <input type="text" data-role="tagsinput" value="" id="Tags" name="Tags">
        
        
    ';
        echo '
        <hr>
            <label for="btnSubir"></label>    
            <input type="submit" name="btnSubir" class="Mbtn btn-azulTam" value="Guardar">
            <small id="emailHelp" class="form-text text-muted"></small>
        ';


        echo "</form>";
        
        
        






    }



    echo "<div class=' btn-g' title='Haz clic aquí para crear un nuevo reporte'
    style='
    // background-color:white;
    bottom:20px; right:20px;
    -webkit-box-shadow: -3px -1px 5px 0px rgba(0,0,0,0.75);
    -moz-box-shadow: -3px -1px 5px 0px rgba(0,0,0,0.75);
    box-shadow: -3px -1px 5px 0px rgba(0,0,0,0.75);
    '
    >
    <a href='DigitalFile.php?new=' > <img src='icon/btnMas.png' style='width:100%;'>
    </a>
    </div>";

    echo "
    <script>
    function BuscarFiles(mode){   
        $('#PreLoader_buscando').show();
        $('#IconBusqueda').hide();
        busqueda = $('#InputBusqueda').val();
        console.log('Buscando ' + busqueda);
            $.ajax({
                url: 'DigitalFile_data2.php',
                type: 'post',			
                data: {nitavu: '".$nitavu."', busqueda:busqueda, mode:mode },
                success: function(data){
                $('#DivResultado').html(data);
                $('#PreLoader_buscando').hide();
                
                }
            });
                
    }
    // BuscarTicket(0);
    </script>
        ";
    // echo '
    // <div class="row">
    //     <div class="col-1"></div>
    //     <div class="col-5 alert alert-warning alert-dismissible fade show" role="alert">
    //     Se recomienda, checar los archivos una vez subidos, verificar que se descarguen bien.


    //     <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    //         <span aria-hidden="true">&times;</span>
    //     </button>
    //     </div>

    //     <div class="col-1"></div>
    //     <div class="col-4 alert alert-warning alert-dismissible fade show" role="alert">
    //         Recuerda, solo tu puedes compartir los archivos que subiste; así mismo al compartir das acceso a esta aplicación al usuario.   

    //         <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    //             <span aria-hidden="true">&times;</span>
    //         </button>
    //     </div>
    //     <div class="col-1"></div>
    // </div>
    //     ';
} else {
    mensaje("ERROR: no tiene acceso a esta aplicacion",'./index.php?home=');
}
?>

<script>
// $(window).resize(function(){
//     width = $('body').width() / 4;
//     console.log('Width Body = '+width);
//     $('body').css('background-color','#eceae0;');
//     $('body').css('background-image','url(icon/fondoFile.png)');   
//     $('body').css('background-size',width); 
//     // $('body').css('background-blend-mode','screen'); 
// });

$('body').css('background-image','url(img/wall3mil.jpg)');   
width = $('body').width();
$('body').css('background-size', '100%' ); 


// $(document).ready(function() {	
    function Recomendacion1() {
        $.toast({
                heading: 'Information',
                text: 'Recomendacion: Checa que descargue bien el archivo que subas',
                showHideTransition: 'slide',
                icon: 'info'
            })
        
    }

    function Recomendacion2() {
        $.toast({
                heading: 'Information',
                text: 'Solo tu puedes compartir el archivo que subas',
                showHideTransition: 'slide',
                icon: 'info'
            })
        
    }
    setInterval(Recomendacion1, 60000);
    setInterval(Recomendacion2, 30000);
// });
        $("#DigitalFileForm").on("submit", function(e){
            // alert('Click');
            e.preventDefault();
            Descripcion = $('#Descripcion').val();
            Tags = $('#Tags').val();
            var f = $(this);
            var formData = new FormData(document.getElementById("DigitalFileForm"));
                formData.append("Descripcion", Descripcion);
                formData.append("Tags", Tags);
                formData.append("nitavu", "<?php echo $nitavu; ?>");
                

            $.ajax({
                url: "DigitalFile_data.php",
                type: "post",
                dataType: "html",
                data: formData,             
                cache: false,
                contentType: false,
                processData: false,
                beforeSend:function(){
                    $('#loader').html('<img src="icon/loaderDir.gif" style="width:80%; border-radius:15px;">Guardando...');
                    $('#preloader').show();
                },
                success:function(data){
                    
                    $('#preloader').hide();
                    $('#R').html(data);
                }
            });
        
        });

</script>

<?php

include ("./lib/body_footer.php");

?>
