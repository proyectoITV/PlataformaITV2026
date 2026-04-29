<?php include ("./lib/body_head.php"); include ("./lib/body_menu.php"); 
require_once("config.php");
require("viaticos_fun.php");
?>
<?php

$id_aplicacion ="viaticosOK"; //tabla aplicaciones
$nivel = aplicacion_nivel($id_aplicacion, $nitavu); //tabla aplicaciones permisos

if (sanpedro($id_aplicacion, $nitavu)==TRUE){
    echo "<div id='AppDetalle'>".app_detalle($id_aplicacion, $nitavu)."</div>";

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


            // echo "<div id='DivGastos' style='
            //     background-color: #fbfbfb9e;
            //     margin: 10px;
            //     border-radius: 10px;
            //     padding: 15px;
            //     text-align: center;
            // '>";

            // echo "</div>";






            echo "<div id='bloque'>";  
          echo "<div class='tablaHistorial' style='background-color: #fbfbfb9e;
            padding: 10px;
            margin-top: 10px;
            border-radius: 8px;
            width: 101%;
            border: 1px solid #dae89d;'>";
          //Filtro de si soy colaborador y soy del departamento entonces solo puedo agregar anexos.
          

          echo "<h3 style='color:black;'>HISTORIAL DE EVIDENCIAS</h3>";
          echo "<table id='historialTabla' class='tabla' >";
          echo "<th style = 'background-color: #ddc9a3; color: black;' class='pc'>Oficio Número</th>";
          echo "<th style = 'background-color: #ddc9a3; color: black;' >Nombre Archivo</th>";
          echo "<th style = 'background-color: #ddc9a3; color: black;' class='pc'>Fecha</th><th class='pc'></th>";

          $sql = "SELECT * FROM documentos WHERE idapporigen='viaticosOK' and substring_index(nombre,'_',1)=$IdViatico";
          $rc= $conexion -> query($sql); 
          if ($rc->num_rows>0)
          {
            
            
            // //echo "<th style='width:10%'></th>";
         
             while($r = $rc -> fetch_array())    
             {
              echo "<tr>";
                echo "<td >".$r['ndocumento']."</td >";
                $archivo = "documentos/".$r['ndocumento'].'_'.$r['nombre']."";
                $href='cp_descarga_archivo.php?ruta=".$archivo."';            
                $link = "<a id=".$r['ndocumento']." name='$archivo' href='cp_descargar.php?nombre=".$archivo."' target='_self'  class='digitalizados_vinculos' onclick =''  title='Haga click aqui para descargar'>".$r['nombre']."</a>";
                echo "<td >".$link."</td>";
                echo "<td >".$r['fecha']."</td >";
              echo '</tr>';
             }

        }
        echo '<tr class="pc">';
        echo "<form action='viaticosevidencia.php?idviatico=".$IdViatico."' method='POST' enctype='multipart/form-data'>"; 
        echo '<input type="hidden" name="idviatico" value='.$IdViatico.'>';
        echo '<input type="hidden" name="subirHistorial" value="1">';
        echo '<td>';
          
          // echo "<input type='text' id='nombreArchivo' name='nombreArchivo'>";
          echo "<input type='hidden' name='idviatico' value= ".$IdViatico.">";
       
        echo '</td>';
        echo '<td>';
          echo '<input name="nuevoDoc" type="file" accept=".pdf">';
        echo '</td>';
        echo '<td>';
          echo '<input type="date" id="fechaEvidencia" name="fechaEvidencia" value='.$fecha.' required>';
        
        echo '</td>';
        echo "<td><button type='submit' class='btn-identidad-color1' title='Haga clic para subir el archivo'> <img src='icon/subirDoc.png' style='width:20px; '> </button></td>";
        echo "</form>";
        echo '</tr>';    
        echo "</table>";
        echo "</div>";
        echo "<br><br>";


        } else {
            Toast("Error ".$sql,2,"");
        }
        unset($sql, $V, $r);
    } else {
        MsgBox_Lite("Seleccione un Viatico","viaticosc.php");
    }
    
}
else {MsgBox_Lite("No tiene permiso para ver esta aplicacion",'');}	 



//Subir archivo en el historial
if(isset($_POST['subirHistorial'])  and isset($_POST['idviatico'])){
    $id=$_POST['idviatico'];
    if(!empty($_FILES['nuevoDoc']['name']) != null){
                    
        $doc = $_FILES["nuevoDoc"]["name"];
        $doc= $id."_".$doc;
        $num = ndocumento(TRUE);       
        $archivo = "documentos/".$num."_".$doc."";
        $tmp =$_FILES["nuevoDoc"]["tmp_name"];
        $subida = FTP_subir($tmp,$archivo);


      if ($subida == "TRUE"){


        if(documento_add($num,$doc,$nitavu,$id_aplicacion)=="TRUE")
        {
            mensaje('Se ha subido el archivo con éxito.','viaticosevidencia.php?id='.$id.'');  
            ndocumento(FALSE);   
        }else{
          mensaje('Hubo un error al momento de subir el archivo, por favor vuelva a intentarlo.','viaticosevidencia.php?id='.$id.'');
        }
      }else{
        mensaje('Ocurrio un error al momento de subir el archivo.','viaticosevidencia.php?id='.$id.'');   
      }
    }else{
      mensaje('No ha seleccionado ningun archivo.','viaticosevidencia.php?id='.$id.'');
    }
  }


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