<?php include ("./lib/body_head.php"); include ("./lib/body_menu.php"); ?>
<?php


$id_aplicacion ="ap94"; 
$nivel =aplicacion_nivel($id_aplicacion, $nitavu);

if (sanpedro($id_aplicacion, $nitavu)==TRUE){   
    echo "<div id='AppDetalle'>".app_detalle($id_aplicacion, $nitavu)."</div>";
    historia($nitavu, "Uso ap94: Padron de Beneficiarios TAM - Por Delegacion");
    echo "<div id='Beneficiarios' style='width:90%;'>";
    echo "<table width=100%><tr><td align='center' valign='top'>";
    
    
    
    
        echo "<div style='display:none; width:400px;padding:30px;' id='LoaderBeneficiarios'><img src='img/loader4.gif' style='width:100px'><br><span style='color:gray;'>Cargando...</span></div>";
        echo "<div id='BeneficiariosData'></div>";
  

    echo "</td><td width=100px valign='top' align='center'>";
    echo "<a href='pub.php' class='Mbtn btn-azulTam'>Por Programas</a>  " ;
    echo "<a href='pub2.php' class='Mbtn btn-celesteTam'>Por Delegacion</a>";

    echo "
    
    <div id='GraficaPorAnio' style='width:600px; height:500px;'></div>
    <div id='EstadisticaPorAño' ></div>
    ";
    
    echo "</td></tr>
    <tr><td colspan='2'><hr>

    </td></tr>
    </table>";
    
    echo "</div>";

} else {mensaje("Error: No esta autorizado para ver esta aplicacion","index.php");}
?>
<input type='hidden' id='row' value='0'>
<script>

PorPrograma(<?php echo $_GET['IdDelegacion']; ?>);

function PorPrograma(IdDelegacion){   
    var DesdeVal = parseInt($('#row').val());
    console.log(DesdeVal);
    var Desde = 0; var Hasta = 0;
    if (DesdeVal == 0 ){
        Desde = 0
        Hasta = 100
        $('#row').val(Hasta)
    } else {
        Desde = DesdeVal
        Hasta = DesdeVal + 100
        $('#row').val(Hasta);
    }
    $("#LoaderBeneficiarios").show();   
   $.ajax({
       url: "pub_dat7.php",
      type: "post",   
      data: {nitavu: <?php echo $nitavu; ?>, IdDelegacion:IdDelegacion, Desde:Desde, Hasta:Hasta},
      success: function(data){
     
       $('#BeneficiariosData').html(data+"\n");
     
    //    $("#LoaderBeneficiarios").hide();
      }
   });

   PorAnio(IdDelegacion);
   
}


function PorAnio(IdDelegacion){   
   
   $("#LoaderBeneficiarios").show();   
  $.ajax({
      url: "pub_dat8.php",
     type: "post",   
     data: {nitavu: <?php echo $nitavu; ?>, IdDelegacion:IdDelegacion },
     success: function(data){
    
      $('#EstadisticaPorAño').html(data+"\n");
    
      $("#LoaderBeneficiarios").hide();
     }
  });
  
}




</script>


<?php include ("lib/body_footer.php"); ?>