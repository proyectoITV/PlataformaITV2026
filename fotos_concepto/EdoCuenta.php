
<?php include ("./unica/body_head.php"); include ("./unica/body_menu.php"); ?>


<?php

if (isset($_GET['del']) and isset($_GET['contrato'])){
    $Contrato = $_GET['contrato']; if (ValidaVAR($Contrato)==TRUE){$Contrato = LimpiarVAR($Contrato);} else {$Contrato = "";}
    $IdDelegacion = $_GET['del']; if (ValidaVAR($IdDelegacion)==TRUE){$IdDelegacion = LimpiarVAR($IdDelegacion);} else {$IdDelegacion = "";}
    
}


    $id_aplicacion ="ap90"; 
    $nivel =aplicacion_nivel($id_aplicacion, $nitavu);

    if (sanpedro($id_aplicacion, $nitavu)==TRUE){   
        echo "<h5>".app_detalle($id_aplicacion)."</h5>";
        echo "<div id='ContratoDatos' style='padding:5px;'>";
        echo "<form action='EdoCuenta.php' method='GET'>";
            echo "<table width=100%><tr><td><label>Num.Contrato:</label><input name='contrato' id='contrato' placeholder='Num. de Contrato'></td>";

            echo "<td><label>Selecciona la Delegacion: </label>";
            echo "<select name='del' id='del'>";
            $sql = 'select * from cat_delegaciones where cat_delegaciones.dpto_id <> "" order by nombre ';
            $r= $conexion -> query($sql); while($f = $r -> fetch_array()) {

                echo "<option value='".$f['id']."'>".$f['nombre']."</option>";
            }
            echo "</select>";
            echo "</td>";

            echo "<td><label></label><input class='btn btn-AzulTam' type='submit' value='Consultar' name='ContratoConsultar'></td></tr></table>";

        echo "</form>";
        echo "</div>";

        if (isset($Contrato)){
           echo "<iframe src='estadodecuenta.php?contrato=".$Contrato."&del=".$IdDelegacion."' 
           style='width:100%; height:80%;'></iframe>";
        }
        
 




    } else {
        mensaje("ERROR: no tiene acceso a esta aplicacion","");
    }
// } else {
//     mensaje("ERROR: parametros incorrectos","");

// }
?>

<?php include ("./unica/body_footer.php"); ?>