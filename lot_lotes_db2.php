<?php
include ("./lib/body_head.php");
?>
<?php
$id_aplicacion ="ap89";
//$nivel =aplicacion_nivel($id_aplicacion, $nitavu);

if (sanpedro($id_aplicacion, $nitavu)==TRUE)
{



  
   

    if(isset($_GET['agregar']))
      {
		
        
        $idmunicipio = $_POST['IdMunicipio'];       
        $idcolonia=$_POST['IdColonia'];
        $seccion=$_POST['Seccion'];
        $fila=$_POST['Fila'];
        $manzana=$_POST['Manzana'];
        $lote=$_POST['Lote'];
    

 
        $idlote=siguienteIdLote();
        
        $sql = "Insert into  lotes ( idLote, IdMunicipio, IdColonia,seccion,fila, manzana, lote, FechaCaptura,IdEmpCrea, IdEstatus) Values ('".$idlote."',".$idmunicipio.", ".$idcolonia
        .",'".$seccion."' ,'".$fila."','".$manzana."','".$lote."','".$fecha."','".$nitavu."',0)";
    
      if ($Vivienda->query($sql) == TRUE)
        {     
          mensaje('El lote ha sido agregado correctamente','lot_capturalotes.php?m='.$idmunicipio);
        }
        else
        {
          mensaje('Hubo un error al agregar la colonia','lot_capturalotes.php?m='.$idmunicipio); 
        } 
         
     } 
     else 
     {
     	
     /*   $idmunicipio = $_POST['IdMunicipio'];
       $idcolonia=$_POST['IdColonia'];
       $colonia=$_POST['Colonia'];
       $nombreoficial=$_POST['NombreOficial'];
       $idtipoadquisicion=$_POST['IdTipoAdquisicion'];
       $observaciones=$_POST['Observaciones'];
       $soloescritura=isset($_POST['Solo_Escrituracion']) ? 1 : 0;
       $montoahorro=$_POST['MontoAhorro'];
       $plantillaahorro=$_POST['PlantillaDeAhorro'];
       $contratomaestro=$_POST['ContratoMaestro'];

       $sql = "UPDATE catcolonia SET Colonia='".$colonia."',  NOMBRE_OFICIAL='".$nombreoficial."', Idtipoadquisicioncol=".$idtipoadquisicion
       .", Observaciones='".$observaciones."',Solo_Escrituracion=".$soloescritura.",MontoAhorro='".$montoahorro."',PlantillaDeAhorro='".$plantillaahorro."',ContratoMaestro='".$contratomaestro."'
         WHERE IdMunicipio = ".$idmunicipio." and IdColonia= ".$idcolonia;
   
       
      if ($Vivienda->query($sql) == TRUE)
      {     
        mensaje('Se editó la información de la colonia correctamente','lot_capturacolonias.php?m='.$idmunicipio);
      }
      else
      {
        mensaje('Hubo un error al editar la información de la colonia','lot_capturacolonias.php?m='.$idmunicipio); 
      } */

     }
}
else{echo "	<br><br>";echo "No tiene acceso a ".$id_aplicacion;}

    ?>