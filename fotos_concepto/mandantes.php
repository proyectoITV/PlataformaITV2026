<?php include ("./unica/body_head.php"); include ("./unica/body_menu.php"); ?>


<?php



//PROCESO PARA INICIAR UNA APP 
// * ANTES registrarla en la tabla aplicaciones, y generarse un permiso para usarla
$id_aplicacion ="ap52"; //ap07=Permisos de Aplicacion
$nivel = aplicacion_nivel($id_aplicacion, $nitavu);
$nivel = 3; //Puedes alterar aqui el nivel para las pruebas
if (sanpedro($id_aplicacion, $nitavu)==TRUE){
echo "<h5>".app_detalle($id_aplicacion)."</h5>";

  //obtener datos para guardar en la BD
  if(isset($_POST['mandante']) ){
    
    $idmunicipio = $_POST['idmunicipio'];
    $idcolonia = $_POST['idcolonia'];
    $idmandante = $_POST['idmandante'];
    $mandante = $_POST['mandante'];
    $apoderado = $_POST['apoderado'];
    $sql = 'UPDATE cat_mandantes SET Propietarios="'.$mandante.'", Mandante="'.$apoderado.'" WHERE IdMandante='.$idmandante.' and IdColonia='.$idcolonia.' and IdMunicipio='.$idmunicipio.'';
    //echo $sql;
    if ($conexion->query($sql) == TRUE) {
      mensaje('Se ha modificado con éxito la información.','mandantes.php');
    }else{
      mensaje('Ocurrio un error, por favor intentelo de nuevo.','mandantes.php');
    }
  }

  echo "<div id='mandantes'>";

  if (isset($_GET['busqueda'])){//Que hacer si esta buscando
    $sql="select 
	  DISTINCT Mandante, mandantes.ReresentanteLegal, mandantes.Propietarios
	
    from mandantes
    WHERE Mandante like'%".$_GET['busqueda']."%' OR ReresentanteLegal like '%".$_GET['busqueda']."%' OR Propietarios like '%".$_GET['busqueda']."%'
    ORDER BY Mandante";

    $sql="SELECT * FROM cat_mandantes
    WHERE cat_mandantes.Propietarios like '%".$_GET['busqueda']."%' OR cat_mandantes.Mandante like '%".$_GET['busqueda']."%'
    ORDER BY Mandante";
    $busqueda = $_GET['busqueda'];
    $vuelta = 0;
    $rc= $conexion -> query($sql);
    $r_count = $rc -> num_rows;
    
    if ($rc->num_rows>0)
    {
        
      historia($nitavu,'Busco un mandante o colonia '.$_GET['busqueda']); //registra log de historia
     
      echo "<h3 class=''>Resultados de <b class='normal'>".$_GET['busqueda']."</b> </h3>";
      echo "<center>";
      
      

      while($r = $rc -> fetch_array())    
      {
        $vuelta++;
        echo "<div id='resultado_elemento'  >";		
        echo "<table border='0'>";
				echo "<tr>";													
						echo "<td width='90%' class='tipo_nitavu'>";								
						echo "<table border='0'>";
						echo "<tr>";							
						echo "<td>";
						echo "<span class='normal tmediano'>".$r['Propietarios']."</span>";
						echo "<span class='pc tchico'><br>Apoderado (s): ".$r['Mandante']."</span>";
						echo "</td>";
						echo "</tr>";
						echo "</table>";
						echo "</td>";	
            echo "<td style='text-align: right; width='10px;'  class='tipo_menu'>";
				      echo "<a href='modificar_mandantes.php?idmandante=".$r['IdMandante']."&idcolonia=".$r['IdColonia']."&idmunicipio=".$r['IdMunicipio']."'><img src='icon/entrar.png' class='icono'></a>";
            echo " </td>";
					echo "</tr></table>";
				echo "</div>";	
										
      }
      echo "</center>";

      echo "<a class='btn btn-default' href='mandantes.php'>Buscar nuevamente</a>";
    } else {
      mensaje("Sin resultados buscando <b>".$_GET['busqueda']."</b>",'mandantes.php');
    }
    
  }
  else {
      buscar('mandantes.php', 'Mandante', '');
    }
echo "</div>";
}else{
  mensaje("No tiene permiso para ver esta aplicacion",'');
}	 
?>
<script>

function modificarMandante(reg){
  alert('entro');

   $("#apoderado1").css({'display':'inline-block',});
   $("#apoderado").css({'display':'none',});
   $("#propietarios1").css({'display':'inline-block',});
   $("#propietarios").css({'display':'none',});
}
</script>






















<!-- Hacer algo de espacio para testear -->
<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>


<?php include ("./unica/body_footer.php"); ?>