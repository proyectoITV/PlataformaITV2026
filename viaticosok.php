<?php include ("./lib/body_head.php"); include ("./lib/body_menu.php"); 
require_once("config.php");
require("viaticos_fun.php");
?>
<?php

$id_aplicacion ="viaticosOK"; //tabla aplicaciones
$nivel = aplicacion_nivel($id_aplicacion, $nitavu); //tabla aplicaciones permisos

if (sanpedro($id_aplicacion, $nitavu)==TRUE){
    echo "<div id='AppDetalle'>".app_detalle($id_aplicacion, $nitavu)."</div>";

    //echo "<script>$('body').css('background-image','url(img/wallviaticos.png)');</script>";
    echo "<script>$('body').css('background-color','rgb(108, 116, 119)');</script>";
    echo "<script>$('body').css('background-image','url(img/viaticosexpedientes.jpg)');</script>";
    echo "<script>$('body').css('background-position','top');</script>";
    echo "<script>$('#AppDetalle').css('background-color','rgba(2, 2, 2, 0.41)');</script>";    
    //echo "<script>$('body').css('background-size','100%');</script>";

    if (isset($_GET['id'])){
        $IdViatico = VarClean($_GET['id']);
        $sql="select * from viaticosconsulta where IdViatico='".$IdViatico."'";
        $r= $conexion -> query($sql);					
        if($V = $r -> fetch_array())
        {
            echo "<div id='viaticosDiv' class='' style='
                background-color: #fbfbfb9e;
                margin: 10px;
                border-radius: 10px;
                padding: 15px;
                text-align: center;
            '>";
            echo "<table width=100% >";
            echo "<tr>";
            echo "<td style='
            background-color: #ab0033;
                margin: 10px;
                border-radius: 10px;
                color:white;
            ' rowspan=2 valign=middle align=center><b style='font-size:18pt'>".$IdViatico."</b>
            <br><cite style='font-size:7pt;'>IdViatico</cite>
            </td>";
            echo "
            <td style='padding:5px;'>Empleado<b>".$V['Empleado']."</b><br>";
            echo "<b style='font-size:14pt; '>".$V['Comision']."</b><br>";
            echo "Lugar: <b>".$V['LugarComision']."</b>, ";
            echo "Fecha: <b>".$V['Fecha']."</b></td></tr>";
            
            echo "<tr><td align=right>Captura: <b>".$V['Captura']."</b></td>";
            echo "</tr>";
            echo "</table>";

           


            echo "</div>";


            echo "<div id='DivGastos' style='
                background-color: #fbfbfb9e;
                margin: 10px;
                border-radius: 10px;
                padding: 15px;
                text-align: center;
            '>";

            echo "</div>";
        } else {
            Toast("Error ".$sql,2,"");
        }
        unset($sql, $V, $r);
    } else {
        MsgBox_Lite("Seleccione un Viatico","viaticosc.php");
    }
    
}
else {MsgBox_Lite("No tiene permiso para ver esta aplicacion",'');}	 


?>
<script>
function GastosReload(){		    
    IdViatico = "<?php if (isset($IdViatico)){echo $IdViatico;} else {}?>";        
    
    $('#progressbar').show();
        $.ajax({
            url: "viaticos_dat_gastosc.php",
        type: "post",        
        data: {IdViatico:IdViatico},
        success: function(data){                
            $("#DivGastos").html(data);                
            $('#progressbar').hide();
        }
        });
            
}
GastosReload();
</script>


<?php include ("./lib/body_footer.php"); ?>