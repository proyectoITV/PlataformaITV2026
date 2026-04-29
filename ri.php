<?php include ("./lib/body_head.php"); include ("./lib/body_menu.php"); ?>
  
<script>
function r2Data(){   
var Len = $("#txtBeneficiario").val().length;    
var txtBeneficiaro = $("#txtBeneficiario").val();
$('#buscando').html(txtBeneficiaro);
var nitavu = "<?php echo $nitavu;?>";
if (Len >= 1){
    $("#indicaciones").html("<a href='' style='display:block;'>Iniciar nueva busqueda</a>");
    

    $("#Loader2").show()
    $("#Data").html("");
    search = $('#txtBeneficiario').val();
    $.ajax({
        url: "ri_data.php",
        type: "post",   
        data: {nitavu: nitavu, q: search },
        success: function(data){
        $('#Data').html(data+"\n");
        $("#Loader2").hide()
      }
   });
} else {
    var faltan = 1- Len;
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
AhorrePapel(FALSE,3);
$id_aplicacion ="ap50"; 
$nivel =aplicacion_nivel($id_aplicacion, $nitavu);
if (sanpedro($id_aplicacion, $nitavu)==TRUE){   
    echo "<div id='AppDetalle'>".app_detalle($id_aplicacion, $nitavu)."</div>";
    historia($nitavu,'['.$id_aplicacion.'] Iniciando...'); 
    
    echo "<div style='margin-top:80px' class='movil'></div>";
    echo "<section id='v001' style='
        background-color: #f9f3f0;
        width: 100%;
        height: 100%;
    '>";
    echo "<div style='
        background-color:#e6e3e1;
        width: 100%;
        padding-top: 13px;
        padding-bottom: 13px;
    '><table width=100%><tr><td width=90%><input style='
        height: 65px;
        border-radius: 5px;    
        font-size: 23pt;    
        font-family: Light;    
        margin-left: 12px;    
        padding: 10px;    
        margin-right: 20px;
    'type='text' placeholder='Reporte (Nombre o descripcion)' id='txtBeneficiario'></td><td>
    
    <button class='Mbtn btn-Success' id='indicaciones2' style='
    font-size: 8pt;
    width: 100%;
    height: 60px;
    margin-top: 0px;
    
    ' onclick='r2Data();'>
    <img src='icon/buscar2.png' style='width:40px;'>
    </button></td>";
    
    

    // echo "<td><a href='#ReporteNuevo' class='Mbtn btn-Primary ' style='
    // width: 54px;
    // margin-right: 4px;
    // margin-top: 0px;
    
    // ' rel='MyModal:open' >Solicitar Reporte</a></td>";    

    // echo "<div class='MyModal' id='ReporteNuevo'>";
    // echo "<h1>Crear Reporte</h1>";
    // echo "<form method='POST'  >";
    // echo "<div>"."<label>Nombre del Reporte</label> <input type='text' name='ReporteNombre' id='ReporteNombre' required> "."</div>";
    // echo "<div>"."<label>Descripcion: </label> <textarea type='text' style='height:200px;' name='ReporteDescripcion' id='ReporteDescripcion' required> "."</textarea></div>";
    // echo "<div>"."<label>Solicitud</label> <input type='file' name='ReporteFile' id='ReporteFile' Accept='application/pdf' required> "."</div>";

    // echo "<div><label>Solicitante:</label><select id='ReporteSolicitante' name='ReporteSolicitante'>";
    // $sql="select * from Areas";
    // $rc= $conexion -> query($sql);
    // while($f = $rc -> fetch_array()) {
    //     echo "<option value='".$f['IdArea']."'>".$f['Area']."</option>";
    // }
    // echo "</select><div>";

    // echo "<div><input class='Mbtn btn-Success' type='submit' value='Crear' style='width:200px;'>
    // <label>* En esta primera etapa sea crea en Estatus 0, aun requiere autorizarse, configurarlo y publicarlo</label>
    
    // </div>";
   
    // echo "</form>";
    // echo "</div>";


    echo "</tr></table>

";

echo " </div>";



    echo "<div id='Resultado'
    style='
        width: 100%;
        padding-top: 13px;
        padding-bottom: 13px;
    '>";
    
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


} else {mensaje("ERROR: no tiene permiso para usar esta aplicación","");}    


include ("./lib/body_footer.php"); ?>