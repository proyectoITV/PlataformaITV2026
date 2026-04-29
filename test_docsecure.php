<?php 
include ("./lib/body_head.php"); 
include ("./lib/body_menu.php"); 
require_once("config.php");
?>

<?php
require("lib/docsecure.php");

// echo "URL Actual: ".URL_actual()."<br>";
// echo "URI ".URL_uri()."<br>";


if (isset($_GET['up'])){ //acciones del ajax
    // var_dump($_FILES['Archivo']);
    // $_FILES['Archivo']['tmp_name'];

    $UpLoad = DocSecure_upload_post('Archivo',"2809","Recibo Reintegro 1234","RECIBO");
    var_dump($UpLoad);
    
    // echo "<hr>
} else {
    $ArchivoOrigen = "ping.png";

    // //... Basico:
    // $UpLoad = DocSecure_upload($ArchivoOrigen);var_dump($UpLoad);


    // //... Con Usuario:
    // $UpLoad = DocSecure_upload($ArchivoOrigen,"2809");var_dump($UpLoad);

    //... Con Usuario, y tag de identifacion DocSecure_upload($ArchivoOrigen, $IdUser="", $Descripcion="", $Tag=""); 
    $UpLoad = DocSecure_upload($ArchivoOrigen,"tEST Descripcion","TAG");var_dump($UpLoad);

    echo "<hr>
    <form id='Form'  enctype='multipart/form-data'>
        <input type='file' id='Archivo' name='Archivo' class='form-control'>
        
    </form>
    
    <button class='btn btn-primary' onclick='SubirArchivo()'>Subir
    
    </button>

    <div id='Resultado'></div>";
}



?>

<script>
    function SubirArchivo(){
    // extension = archivo.substring(archivo.lastIndexOf('.'),archivo.length);
    var formData = new FormData(document.getElementById('Form'));        
    // formData.append('IdViatico',  IdViatico);        
    
  
        $.ajax({
            url: 'test_docsecure.php?up=',
        type: 'post',                
        dataType: 'html',
        data: formData,             
        cache: false,
        contentType: false,
        processData: false,
        beforeSend:function(){
            // $('#progressbar').show();        
        },                    
        success: function(data){                
            $('#Resultado').html(data);                            
            $('#preloader').hide(); 
        }
        });

    }
</script>

<?php 
include ("./lib/body_footer.php"); 
?>