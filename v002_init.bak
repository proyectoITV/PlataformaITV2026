<?php
include("./lib/body_head.php");
include("./lib/body_menu.php"); 

$id_aplicacion ="v002"; 
$nivel =aplicacion_nivel($id_aplicacion, $nitavu);
if (sanpedro($id_aplicacion, $nitavu)==TRUE){   
    echo "<div id='AppDetalle'>".app_detalle($id_aplicacion, $nitavu)."</div>";
    

    if (isset($_GET['numcontrato'])|| isset($_GET['origindata'])){    
        $contrato = $_GET['numcontrato']; if (ValidaVAR($contrato)==TRUE){$contrato = LimpiarVAR($contrato);} else {$contrato = "";}
        $OriginData = $_GET['origindata']; if (ValidaVAR($OriginData)==TRUE){$OriginData = LimpiarVAR($OriginData);} else {$OriginData = "";}
        
        echo "<div id='ContratoDatos' style='
        padding: 5px;

            background-color:
            #4d4d4d;

            color:
            white;
        
        '>";
    echo "<form action='v002_init.php' method='GET'>";
        echo "<table width=100%><tr><td><label style='color:white;'>Num.Contrato:</label><input name='numcontrato' id='numcontrato' placeholder='Num. de Contrato' value='".$contrato."'></td>";
        
        echo "<td><label style='color:white;'>Delegacion (Origen): </label>";
        echo "<select name='origindata' id='origindata' style='margin:0px;'>";
        $sql = 'select * from cat_delegaciones where cat_delegaciones.dpto_id <> ""  and id <>0 order by nombre ';
        $l=0; $style="";
        $r= $conexion -> query($sql); while($f = $r -> fetch_array()) {
            if ($l%2){
                $style='
                font-size: 9pt;
                font-family: Light;
                background-color:  #fff;
                ';
            } else {
                $style='
                font-size: 9pt;
                font-family: Light;
                background-color:  #F2F2F2;;
                ';
            }
            echo "<option value='".$f['id']."' style='".$style."'>".$f['nombre']."</option>";
            $l = $l +1;
        }
        echo "<option value='".$OriginData."' selected>".DelegacionNombre($OriginData)."</option>";

        echo "</select>";
        echo "</td>";

        echo '<td valing="top" width="10px"><label></label><input style="width:250px; height:43px;" class="Mbtn btn-Success" type="submit" value="Consultar" name="ContratoConsultar"></td>';

        $urlActual="?numcontrato=".$_GET['numcontrato']."&origindata=".$_GET['origindata'];        
        echo '<td width="3%" valing="top" align="center">'."<a 
        style='margin-top: -1px;        '
        class='btn btn-secondary' 
        href='".$urlActual."&cancelados=' title='Incluir los movimientos cancelados'>
        ";
        echo "<img src='icon/Cancelarcontrato.png' style='width:30px;'>";
        
        echo "</a>"."</td>";

        if (nitavu_dpto($nitavu) == 55){
            echo '<td valing="top" align="center" width="3%">'."<a 
            style='margin-top: -1px; '
            class='btn btn-warning' href='".$urlActual."&full=' title='Checar Calculo'>";
            echo "<img src='icon/check3.png' style='width: 21px;
            margin: 5px;'>";
            echo "</a></td>";

            if (isset($_GET['full'])){
                // echo '<td valing="top" align="center" width="3%">'."<a style='padding: 5px;
                // margin-top: 14px; width:100px; font-size:10pt; height:33px;'class='Mbtn btn-Secondary' href='".$urlActual."&recalc='>Corregir<br>Calculo</b></a>"."</td>";

                echo '<td valing="top" align="center" width="3%">'."<a 
                style='margin-top: -1px;'
                class='btn btn-primary' href='".$urlActual."&recalc=' title='Corregir Calculo en el Esado de Cuenta'>";
                echo "<img src='icon/check2.png' style='width:33px;'>";
                echo "</a></td>";
                
            }
        }

        if (isset($_GET['recalc'])){    //Corregir
            $contrato = $_GET['numcontrato']; if (ValidaVAR($contrato)==TRUE){$contrato = LimpiarVAR($contrato);} else {$contrato = "";}
            $OriginData = $_GET['origindata']; if (ValidaVAR($OriginData)==TRUE){$OriginData = LimpiarVAR($OriginData);} else {$OriginData = "";}
            // echo $contrato;
            if (EstadoDeCuenta_recalcularsaldo($contrato, $OriginData, $nitavu)==TRUE){
                mensaje("Se ha actualizado correctamente el Saldo del Contrato ".$contrato."",$urlActual."&full=");
            } else {
                mensaje("ERROR al actualizar el Saldo del Contrato ".$contrato."",$urlActual);
            }
        }

        



        echo "</tr></table>";
        
        echo "<script>
        $('#grancontenido').css({'background-color':'#4d4d4d'});
        $('body').css({'background-color':'#4d4d4d'});
        </script>";
    echo "</form>";
    echo "</div>";
        if (isset($_GET['full'])){
            echo "<iframe src='v002.php?numcontrato=".$contrato."&origindata=".$OriginData."&full' 
            style='width:100%; height:86%; border: 0px solid black;' border=0></iframe>";
      
        } else {
            if (isset($_GET['cancelados'])){
                echo "<iframe src='v002.php?numcontrato=".$contrato."&origindata=".$OriginData."&cancelados' 
                style='width:100%; height:86%; border: 0px solid black;' border=0></iframe>";
          
            } else {
                echo "<iframe src='v002.php?numcontrato=".$contrato."&origindata=".$OriginData."' 
              style='width:100%; height:86%; border: 0px solid black;' border=0></iframe>";
        
            }
            
        }
        
    } else {
        echo "<div id='ContratoDatos' style='padding:5px; background-color: antiquewhite;'>";
    echo "<form action='v002_init.php' method='GET'>";
        echo "<table width=100%><tr><td><label>Num.Contrato:</label><input name='numcontrato' id='numcontrato' placeholder='Num. de Contrato'></td>";
        
 
        echo "<td><label>Delegacion (Origen): </label>";
        echo "<select name='origindata' id='origindata' style='margin:0px;'>";
        $sql = 'select * from cat_delegaciones where cat_delegaciones.dpto_id <> ""  and id <>0 order by nombre ';
        $l=0; $style="";
        $r= $conexion -> query($sql); while($f = $r -> fetch_array()) {
            if ($l%2){
                $style='
                font-size: 9pt;
                font-family: Light;
                background-color:  #fff;
                ';
            } else {
                $style='
                font-size: 9pt;
                font-family: Light;
                background-color:  #F2F2F2;;
                ';
            }
            echo "<option value='".$f['id']."' style='".$style."'>".$f['nombre']."</option>";
            $l = $l +1;
        }
        echo "</select>";
        echo "</td>";

        echo "<td><label></label><input class='Mbtn btn-AzulTam' type='submit' value='Consultar' name='ContratoConsultar'></td></tr></table>";

    echo "</form>";
    echo "</div>";
        
    }

   
    
    
    // xd_update('ap18',$nitavu);//guarda la experiencia del usuario
    // historia($nitavu, "Entro a la aplicacion [ap18], Para ver el Directorio ");
     
} else {mensaje("Error: No esta autorizado para ver Estados de Cuenta.","index.php");}
?>

<?php include ("./lib/body_footer.php"); ?>