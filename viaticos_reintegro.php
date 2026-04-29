<?php include ("./lib/body_head.php"); include ("./lib/body_menu.php"); 
require_once("config.php");
require("viaticos_fun.php");
?>
<?php

$id_aplicacion ="viaticosR"; //tabla aplicaciones
$nivel = aplicacion_nivel($id_aplicacion, $nitavu); //tabla aplicaciones permisos

if (sanpedro($id_aplicacion, $nitavu)==TRUE){
    echo "<div id='AppDetalle'>".app_detalle($id_aplicacion, $nitavu)."</div>";


    echo "<script>$('body').css('background-color','rgb(108, 116, 119)');</script>";
    echo "<script>$('body').css('background-image','url(img/wallviaticos.png)');</script>";
    echo "<script>$('body').css('background-position','top');</script>";
    echo "<script>$('#AppDetalle').css('background-color','rgba(2, 2, 2, 0.41)');</script>";    
    // echo "<script>$('body').css('background-size','120%');</script>";
   
    echo "<div id='CapturaViatico' style='width:100%; background-color:white; padding:10px;'>";
    echo "<table width=100%>";
    echo "<tr>";
    echo "<td >";
    echo "<input id='IdViatico' placeholder='Selecciona el Viatico' list='viaticos' type='text' class='form-control' value=''
    style='width:100%; height:50px; font-size:14pt;
    
    '>";
    $sql="select 
    a.IdViatico,
    a.NEmpleado,
    (select nombre from empleados where nitavu= a.NEmpleado) as Empleado,
    a.Comision
    
    from viaticosfull a where Activa=1";
    $r= $conexion -> query($sql);
    $IdColores = "";
	echo '<datalist id="viaticos">';
    while($f = $r -> fetch_array()) {
		echo '<option value="'.$f['IdViatico'].'">'.$f['IdViatico']." - ".$f['Empleado']." - ".$f['Comision']."</option>";

    }
    echo "</datalist>";
    unset($sql, $f, $r);
   

    echo "</td>";
    echo "<td align=right width=50px>";
    echo "<button class='btn btn-primary' style='
    height: 50px;
    margin-top: -3px;
    margin-left: 10px;
    ' onclick='Seleccionar();'>Entrar</button>";
    echo "</td>";
    echo "</tr>";
    echo "</table>";
    echo "</div>";


    echo "<div id='Resultado' style='padding:11px;'>";

    echo "</div>";
}
else {MsgBox_Lite("No tiene permiso para ver esta aplicacion",'');}	 


?>

<script>
    function Seleccionar(){
        IdViatico = $('#IdViatico').val();
        $('#progressbar').show();
            $.ajax({
                url: "viaticos_reintegro_dat_select.php",
            type: "post",        
            data: {IdViatico:IdViatico},
            success: function(data){                
                $("#Resultado").html(data+"");                    
                $('#progressbar').hide();
            }
        });
    }



</script>

<script>
function RecibirReintegro(){
        IdViatico = $('#IdViatico').val();
        CatidadRecibida = $('#ReintegroCantidad').val();
        InputToken = '<?php if (isset($_GET['tkn'])){echo $_GET['tkn'];} else {echo "0";} ?>';
        
        $('#progressbar').show();
            $.ajax({
                url: "viaticos_reintegro_dat_ingresar.php",
            type: "post",        
            data: {IdViatico:IdViatico, CatidadRecibida:CatidadRecibida, InputToken: InputToken},
            success: function(data){                
                $("#DivRecibo").html(data+"");                    
                $('#progressbar').hide();
            }
            });

}
</script>


<?php include ("./lib/body_footer.php"); ?>