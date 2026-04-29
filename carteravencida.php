<?php include ("./lib/body_head.php"); include ("./lib/body_menu.php"); ?>


<script>
function CalcularCartera(IdDelegacion,nitavu){   
$("#EstadisticaPorColonia_Loader").show();
   $.ajax({
        url: "carteravencida_calc.php",
        type: "get",   
        data: {IdDelegacion: IdDelegacion, nitavu:nitavu},
      success: function(data){
       $('#RV').html(data+"\n");
       $("#EstadisticaPorColonia_Loader").hide();
      }
   });
   
}
</script>
<?php
$id_aplicacion ="ap100"; 
$nivel =aplicacion_nivel($id_aplicacion, $nitavu);
docdigital_no(FALSE, 1); 
historia($nitavu, "[ap100] notfisicas inicio");


$nivel=2;
if (sanpedro($id_aplicacion, $nitavu)==TRUE){
    echo "<div id='AppDetalle'>".app_detalle($id_aplicacion, $nitavu)."</div>";

    if ($nivel == 1){//Oficinas Centrales | Monitoreo | Cancelacion del candado para reimprimir

    }

    if ($nivel == 2){//Delegaciones | Impresion y Captura
        $MiIdDelegacion = MiIdDelegacion($nitavu);

        echo "<div id='EstadiscaPorCol'
        style='
        display: inline-block;
        background-color:   #fbf3e0;        
        width: 40%;        
        margin: 10px;        
        border-radius: 5px;        
        padding-bottom: 10px;        
        border: 1px solid   #f9eac9;
        '
        >";
        echo "<h3 style='margin:0px;'>Estadistica por Colonias</h3>";
        // $sql="select * from cat_colonias where IdDelegacion  = ".$MiIdDelegacion." Order by Municipio, Colonia";
        // $r= $conexion -> query($sql);
        // echo "<table class='tabla'>";
        // while($f = $r -> fetch_array()) {
        //     echo "<tr>";
        //     echo "<td><b>".$f['Colonia']."</b><cite>".$f['Municipio']."</cite></td>";
        //     echo "<td><div id='Contratos".$f['IdMunicipio']."_".$f['IdColonia']."'></div></td>";

        //     echo "</tr>";
        // }
        // echo "</table>";
        echo "<div id='EstadisticaPorColonia_Loader' style='width:100%; height:400px;display:none;'><br><br><br>";
        echo "<img src='img/loader_chat.gif' style='width:20%;'><br>";
        echo "<label>Se está calculando la cartera vencida, <b>No cierre!</b> <br>Espere por favor..</label>";
        echo "</div>";
        echo "<div id='EstadisticaPorColonia_UltimoCalculo'>";
        if (CarteraVencida_CalculoHoy($MiIdDelegacion)==0){
            // $sql="";
            // $rc= $conexion -> query($sql);
            // echo "<h1>Personal que dependende de ud:</h1>";
            // while($f = $rc -> fetch_array()) {
            // }
        }
        echo "</div>";

        

        
        
        echo "</div>";





        if (CarteraVencida_CalculoHoy($MiIdDelegacion)==0){
            echo "<label>Tu IdDelegacion = ".$MiIdDelegacion.", aun sin calculo de cartera vencida de hoy.</label>";
            
            //lanzamos la funcion para calcular
            echo "<script>CalcularCartera(".$MiIdDelegacion.",".$nitavu.");</script>";
        } else {
            echo "<label>Tu IdDelegacion = ".$MiIdDelegacion."</label>";
            
        }
        
    }



} else {mensaje("ERROR; sin acceso a esta aplicacion","");}
?>


<?php include ("./lib/body_footer.php"); ?>
