<?php
include("./lib/body_head.php");
include("./lib/body_menu.php"); 
?>
<script>
function v001Data(){   
var Len = $("#txtBeneficiario").val().length;    
var txtBeneficiaro = $("#txtBeneficiario").val();
$('#buscando').html(txtBeneficiaro);
var nitavu = "<?php echo $nitavu;?>";
if (Len >= 10){
    $("#indicaciones").html("<a href='' style='display:block;'>Iniciar nueva busqueda</a>");
    

    $("#Loader2").show()
    $("#Data").html("");
    search = $('#txtBeneficiario').val();
    $.ajax({
        url: "v001_data.php",
        type: "get",   
        data: {nitavu: nitavu, search: search },
        success: function(data){
        $('#Data').html(data+"\n");
        $("#Loader2").hide()
      }
   });
} else {
    var faltan = 10- Len;
    $.toast({
    heading: 'Warning',
    text: "Escriba <b>"+faltan+"</b> caracteres, para poder iniciar la busqueda.",
    showHideTransition: 'plain',
    icon: 'warning'
})
}

}
</script>
<?php
$idDepartamento=nitavu_dpto($nitavu);
$id_aplicacion ="v001";
$nivel =aplicacion_nivel($id_aplicacion, $nitavu);
// $nivel=1;
if (sanpedro($id_aplicacion, $nitavu)==TRUE){
    echo "<div id='AppDetalle'>".app_detalle($id_aplicacion, $nitavu)."</div>";	
    historia($nitavu,'['.$id_aplicacion.'] Iniciando'); 
    echo "<div style='margin-top:45px' class='movil'></div>";
    echo "<section id='v001' style='
        background-color: #f9f3f0;
        width: 100%;
        height: 100%;
    '>";
    echo "<div style='
        background-color:#e6e3e1;
        width: 100%;
        padding-top: 50px;
        padding-bottom: 13px;
    '><table width=100%><tr><td width=90%>";
    
    if (isset($_GET['search'])) {
        $Search = $_GET['search']; if (ValidaVAR($Search)==TRUE){$Search = LimpiarVAR($Search);} else {$Search = "";}
        echo "<input style='
        height: 65px;
        border-radius: 5px;    
        font-size: 23pt;    
        font-family: Light;    
        margin-left: 12px;    
        padding: 10px;    
        margin-right: 20px;
        'type='text' placeholder='Nombre del Beneficiario' id='txtBeneficiario' value='".$Search."'>";

        echo "
        <script>
            v001Data();
        
        </script>";
    } else {
        echo "<input style='
            height: 65px;
            border-radius: 5px;    
            font-size: 23pt;    
            font-family: Light;    
            margin-left: 12px;    
            padding: 10px;    
            margin-right: 20px;
        'type='text' placeholder='Nombre del Beneficiario' id='txtBeneficiario'>";
    }
    echo "</td><td>
    
    <button class='Mbtn btn-Success' id='indicaciones2' style='
    font-size: 8pt;
    width: 100%;
    height: 60px;
    margin-top: 0px;
    
    ' onclick='v001Data();'>
    <img src='icon/buscar2.png' style='width:40px;'>
    </button></td></tr></table>
    </div>";

        echo "<div id='Resultado'
        style='
            width: 100%;
            padding-top: 13px;
            padding-bottom: 13px;
        '>";
        echo "<div id='leyenda' style='margin-top:-10px;'>";
        echo "<b style='
        background-color:
        #E6CCE6;
        display: inline-block;
        vertical-align: top;
        margin: 3px;
        padding: 3px;
        color:
        beige;
        font-family: Light;
        font-size: 8pt;
        border-radius: 3px;            
        '> Dato Foraneo </b>";


        echo "<b style='
        background-color:
        #FFEDCC;
        display: inline-block;
        vertical-align: top;
        margin: 3px;
        padding: 3px;
        color:
        #c69177;
        font-family: Light;
        font-size: 8pt;
        border-radius: 3px;            
        '> Posible Error </b>";

        echo "<b style='
        background-color:
        #EDBABA;
        display: inline-block;
        vertical-align: top;
        margin: 3px;
        padding: 3px;
        color:
        white;
        font-family: Light;
        font-size: 8pt;
        border-radius: 3px;            
        '> Solicitud Cancelada </b>";

        echo "</div>";
            echo "<div id='Loader2' style='
                width: 100%;
                padding-top: 13px;
                padding-bottom: 13px;
                text-align:center;
                display:none;
                '>
            
            <label style='font-size:14pt; font-weight:bold; color:orange;'>Buscando <span id='buscando' style='color:#00468C; font-weight;bold;'>"."</span>, Espere por favor <img src='img/loader_bar.gif' ></label>
            
            </div>";
            echo "<div id='Data' style='
            width: 100%;
            padding-top: 13px;
            padding-bottom: 13px;
            text-align:center;
            
            '>";
            echo "</div>";

        echo "</div>";

    echo "</section>";
    
} else {
    mensaje("ERROR: no tiene acceso a esta aplicacion. <br>
    <a href='organigrama.php'>Solicitelo al Departamento de Informática a traves de la Dirección General. </a> <br>
    ","");
}




?>

<?php

if (isset($_GET['search'])) {
    echo "
    <script>
        v001Data();
    
    </script>";
}
?>


<?php
include ("./lib/body_footer.php"); ?>
