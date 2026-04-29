<?php include ("./lib/body_head.php"); include ("./lib/body_menu.php"); ?>
<?php


$id_aplicacion ="ap94"; 
$nivel =aplicacion_nivel($id_aplicacion, $nitavu);

if (sanpedro($id_aplicacion, $nitavu)==TRUE){   
    echo "<div id='AppDetalle'>".app_detalle($id_aplicacion, $nitavu)."</div>";
    echo "<div id='Beneficiarios' style='width:90%;'>";
    echo "<table width=100%><tr><td align='center' valign='top'>";
    
    
    
    
        echo "<div style='display:none; width:400px;padding:30px;' id='LoaderBeneficiarios'><img src='img/loader4.gif' style='width:100px'><br><span style='color:gray;'>Cargando...</span></div>";
        echo "<div id='BeneficiariosData'></div>";
  

    echo "</td><td width=100px valign='top' align='center'>";
    echo "<a href='pub.php' class='Mbtn btn-azulTam'>Por Programas</a>  " ;
    echo "<a href='pub2.php' class='Mbtn btn-celesteTam'>Por Delegacion</a>";

    echo "<div id='GraficaProgramas' style='width:400px; height:400px;'></div>";
    
    
    
    echo "</td></tr>
    <tr><td colspan='2'><hr>

    <div id='GraficaPorAnio' style='width:100%; height:800px;'></div>
    <div id='EstadisticaPorAño' ></div>
    </td></tr>
    </table>";
    
    echo "</div>";

} else {mensaje("Error: No esta autorizado para ver esta aplicacion","index.php");}
?>
<script>

PorPrograma();

function PorPrograma(){   
   
    $("#LoaderBeneficiarios").show();   
   $.ajax({
       url: "pub_dat3.php",
      type: "post",   
      data: {nitavu: <?php echo $nitavu; ?> },
      success: function(data){
     
       $('#BeneficiariosData').html(data+"\n");
     
       $("#LoaderBeneficiarios").hide();
      }
   });

   PorAnio();
   
}


function PorAnio(){   
   
   $("#LoaderBeneficiarios").show();   
  $.ajax({
      url: "pub_dat4.php",
     type: "post",   
     data: {nitavu: <?php echo $nitavu; ?> },
     success: function(data){
    
      $('#EstadisticaPorAño').html(data+"\n");
    
      $("#LoaderBeneficiarios").hide();
     }
  });
  
}




</script>


<?php include ("lib/body_footer.php"); ?>