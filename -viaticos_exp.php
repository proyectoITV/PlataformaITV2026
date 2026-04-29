<?php include ("./lib/body_head.php"); include ("./lib/body_menu.php"); 
require_once("config.php");
require("viaticos_fun.php");
?>
<?php

$id_aplicacion ="viaticosEXP"; //tabla aplicaciones
$nivel = aplicacion_nivel($id_aplicacion, $nitavu); //tabla aplicaciones permisos

if (sanpedro($id_aplicacion, $nitavu)==TRUE){
    echo "<div id='AppDetalle'>".app_detalle($id_aplicacion, $nitavu)."</div>";

    //echo "<script>$('body').css('background-image','url(img/wallviaticos.png)');</script>";
    echo "<script>$('body').css('background-color','rgb(108, 116, 119)');</script>";
    echo "<script>$('body').css('background-image','url(img/viaticosexpedientes.jpg)');</script>";
    echo "<script>$('body').css('background-position','top');</script>";
    echo "<script>$('#AppDetalle').css('background-color','rgba(2, 2, 2, 0.41)');</script>";    
    echo "<script>$('body').css('background-size','100%');</script>";
   
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
            <br><cite style='font-size:8pt;'>IdViatico</cite>
            </td>";
            echo "
            <td style='padding:5px;'>Empleado<b> ".$V['Empleado']."</b><br>";
            echo "<b style='font-size:14pt; '>".$V['Comision']."</b><br>";
            echo "Lugar: <b>".$V['LugarComision']."</b>, ";
            echo "Fecha: <b>".$V['Fecha']."</b></td></tr>";
            
            echo "<tr><td align=right>Captura: <b>".$V['Captura']."</b></td>";
            echo "</tr>";
            echo "</table>";

           


            echo "</div>";

           /// $sql="select * from viaticosexpediente where IdViatico='".$IdViatico."'";    

           $sql=" select * from viaticosexpediente where IdViatico='577'
           union 
             select substring_index(nombre,'_',1)='".$IdViatico."', documentos.fecha, CONCAT('EVIDENCIA ',documentos.nombre), CONCAT('cp_descargar.php?nombre=','documentos/',documentos.ndocumento,'_',documentos.nombre) from documentos where substring_index(nombre,'_',1)='".$IdViatico."'";


            echo "<div id='Ayudas' class='container' style='
            background-color: #ffffffb0;
            padding: 20px;
            border-radius: 10px;
            margin-top: 30px;
        
            '>";
          // echo $sql;
            $r= $conexion -> query($sql);            
            echo "<table class='tabla'>";
            echo "<th style = 'background-color: #ddc9a3; color:Black;'>Fecha</th>";
            echo "<th style = 'background-color: #ddc9a3; color:Black;'>Tipo</th>";
            echo "<th style = 'background-color: #ddc9a3; color:Black;'>Descarga</th>";
            
            while($f = $r -> fetch_array()) {
                echo "<tr>";
                echo "<td>".$f['Fecha']."</td>";
                echo "<td>".$f['Tipo']."</td>";
                echo "<td><a class='btn btn-success' title='Haz clic aqui para descargar' href='".$f['file_url']."' download='".EasyName("",6)."'><img src='icon/download-from-cloud.png' style='width:18px; cursor:pointer;'>"."</a></td>";


                echo "</tr>";
        
            }
            echo "</table>";
            unset($r,$f,$sql);

            echo "</div>";
            // echo "<script>$('tr').css('background-color','transparent');</script>";
            // echo "<script>$('td').css('background-color','transparent');</script>";
        } else {
            Toast("Viatico No Disponible",2,"");
        }



    } else {
        LocationFull("viaticosc.php");
    }
    
}
else {MsgBox_Lite("No tiene permiso para ver esta aplicacion",'');}	 


?>



<?php include ("./lib/body_footer.php"); ?>