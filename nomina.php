<?php
include("./lib/body_head.php");
include("./lib/body_menu.php"); 


$idDepartamento=nitavu_dpto($nitavu);
$id_aplicacion ="nomina";
$nivel =aplicacion_nivel($id_aplicacion, $nitavu);
// $nivel=1;
if (sanpedro($id_aplicacion, $nitavu)==TRUE){
    echo "<div id='AppDetalle'>".app_detalle($id_aplicacion, $nitavu)."</div>";	

   
    echo "<script>";
    echo "function ReloadContenido(){
        FechaReview = $('#txtFechaNomina').val();
        $('#preloader').show();	
        $.ajax({
               url: 'nomina_reload.php',
              type: 'post',   
              data: {FechaReview:FechaReview},
              success: function(data){	   
                $('#Contenido').html(data);	   			
               $('#preloader').hide();  
          }
       });
    }
    ";


    echo "function baja(IdEmpleado){
        
        $('#preloader').show();	
        $.ajax({
               url: 'nomina_baja.php',
              type: 'post',   
              data: {IdEmpleado:IdEmpleado},
              success: function(data){	   
                $('#R').html(data);	   			
               $('#preloader').hide();  
          }
       });
    }
    ";
    echo "</script>";
    // historia($nitavu,'['.$id_aplicacion.'] Iniciando'); 
    $IdArticle = 1;    
    // SonidoBoop2();
    // echo "
    // <div id='FormsNomina' style='background-color: #adadad99;
    // margin-top: -5px;'>
    // <table border=0 width=100%><tr>";

    // echo "    <form method='POST' enctype='multipart/form-data' id='FormNomina' >";                                        

    // echo "
    // <td width=30%>
    // <label style='font-size:8pt;'>Empleado</label>
    // <select id='IdEmpleado' name='IdEmpleado' class='form-control' required>";
    // $sql = "select * from empleados where estado='' order by nombre";
    // $r2 = $conexion -> query($sql);
    // while($f = $r2 -> fetch_array())
    //     {
    //         echo "<option value='".$f['nitavu']."'>".$f['nombre']."</option>";
    //     }
    // unset($r2, $f);


    // echo "
    // <option value='' selected>Seleccione un empleado </option>
    // </select>
    // </td>
    // ";
    
    // if (isset($_GET['f'])){
    //     $FechaNomina = $_GET['f'];
    //     echo "
    //     <td width=20%>
    //     <label style='font-size:8pt;'>Fecha de la Nomina</label>
    //     <input style='background-color: antiquewhite; '  onchange='ReloadContenido();' type='date' name='FechaNomina' id='FechaNomina' value='".$FechaNomina."' class='form-control' required>
    //     </td>
    //     ";
    //     echo "<script>ReloadContenido();</script>";
    
    
    // } else {
    //     echo "
    //     <td width=20%>
    //     <label style='font-size:8pt;' >Fecha de la Nomina</label>
    //     <input style='background-color: antiquewhite; ' onchange='ReloadContenido();'  type='date' name='FechaNomina' id='FechaNomina' value='".$fecha."' class='form-control' required>
    //     </td>
    //     ";
    
    //     echo "<script>ReloadContenido();</script>";
    
    // }
   
    // echo "
    // <td width=20%>
    // <label style='font-size:8pt;'>Archivo XML</label>
    // <input type='file' name='File_XML' id='File_XML' accept='application/xml' class='form-control' required>
    // </td>
    // ";


    // echo "
    // <td width=20%>
    // <label style='font-size:8pt;'>Archivo PDF</label>
    // <input type='file' name='File_PDF' id='File_PDF' accept='application/pdf' class='form-control' required>
    // </td>
    // ";



    // echo '
    //     <td width=10% align=center valing=middle><div class="btn btn-success" id="btnSubir" onclick="Subir();">Subir</div></td>
            
    // ';
    // echo "</form>";
    
    // echo "</tr></table>";
    // echo "</div>";
if ($nivel==1){
    echo '        
    <div id="FilesUploads">
   
    <form id="FormsLoads" action="nomina_upload2.php" class="btn btn-success" style="
    border: dashed 2px #188c20;
    width: 100%;
    padding: 0px;
    margin-top: -3px;
    border-radius: 0px;
    
    "     enctype="multipart/form-data" >';
    
    echo "
            <input style='
            background-color: transparent;
            border: 0px;
            font-size: 12pt;
            color: white;
            ' type='file' name='File_XML[]' id='File_XML' accept='application/xml' class='form-control' multiple=>
        ";


    echo '
    </form>';
   
    
    echo "<div id='R_Loads'></div>";
    echo '
    </div>
    ';
}
    echo "<input style='
    height: 50px;
    margin-top: -3px;
    width: 166px;
    position: absolute;
    right: -1px;
    top: 61px;
    ' type='date' id='txtFechaNomina' value='".$fecha."' class='btn btn-warning'
    onchange='ReloadContenido();'
    >";
    
    echo "
    <script>
    var holder = document.getElementById('File_XML');
    holder.ondragover = function () { this.className = 'hover'; return false; };
    holder.ondragend = function () { this.className = ''; return false; };
    holder.ondrop = function (e) {
    this.className = '';
    e.preventDefault();
    readfiles(e.dataTransfer.files);

    
    </script>
    ";
   

   echo "<script>ReloadContenido();</script>";
if ($nivel == 1 ){
echo "         
<script>                                   
$(document).on('change', '#FilesUploads', function(event) {
    console.log('detectados');
            var f = $('#FormsLoads');
            var formData = new FormData(document.getElementById('FormsLoads'));
            $('#progressbar').show();
            // $('#FormsLoads').hide();
            $.ajax({
                url: 'nomina_upload2.php',
                type: 'post',
                dataType: 'html',
                data: formData,             
                cache: false,
                contentType: false,
                processData: false,
                beforeSend:function(){
                    
                },
                success:function(data){
                    console.log(data);
                    $('#R').html(data);
                    $('#progressbar').hide();
                }
            });

});
</script>
";
}


    echo "
    <div id='R_'></div>
    ";
    

    echo "<div id='Contenido'>";

    echo "</div>";



echo "         
<script>                                   
function Subir() {
    console.log('clic ');

    
    if ( $('#IdEmpleado').val() != '' &&  $('#FechaNomina').val() != '' && $('#File_XML').val() != '' && $('#File_PDF').val() != '' ) {
        console.log('Subir');       

        var f = $('#FormNomina');
        var formData = new FormData(document.getElementById('FormNomina'));
        formData.append('IdEvento', 'x');
        $('#progressbar').show();
        $('#FormNomina').hide();
        $('#R_').html('Subiendo ...');
        $.ajax({
            url: 'nomina_upload.php',
            type: 'post',
            dataType: 'html',
            data: formData,             
            cache: false,
            contentType: false,
            processData: false,
            beforeSend:function(){
                $('#R_').html(`Cargando <img src='img/loader_bar.gif' >`);
            },
            success:function(data){
                console.log('data='+data);
                $('#Contenido').html(data);
                $('#progressbar').hide();
                $('#FormNomina').show();
                $('#R_').html('');
            }
        });

        
    
    } else {
        $.toast({
                heading: 'Error',
                text: 'Faltan datos por llenar',
                showHideTransition: 'slide',                                
                icon: 'error'
            })
    }

}




</script>
";



} else {
    mensaje("ERROR: no tiene acceso a esta aplicacion","");
}


include ("./lib/body_footer.php"); ?>
