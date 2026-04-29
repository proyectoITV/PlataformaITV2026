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
		
        
        $idmunicipio = $_POST['IdMunicipioNva'];       
        $colonia=$_POST['ColoniaNva'];
        $nombreoficial=$_POST['ColoniaNva'];
        $idtipoadquisicion=$_POST['IdTipoAdquisicionNva'];
        $observaciones=$_POST['ObservacionesNva'];

        $soloescritura=(isset($_POST['Solo_EscrituracionNva']) == '1' ? '1' : '0');
      //  $montoahorro=$_POST['MontoAhorroNva'];
      //   $plantillaahorro=$_POST['PlantillaDeAhorroNva'];
      //   $contratomaestro=$_POST['ContratoMaestroNva'];

        $montoahorro=NULL;
        $plantillaahorro=NULL;
        $contratomaestro=NULL;
 
        $idcolonia=siguienteIdColonia($idmunicipio);
               
        $sql = "Insert into  catcolonia ( Colonia, NOMBRE_OFICIAL,IdTipoAdquisicionCol,
        Observaciones,IdMunicipio,IdColonia,Solo_Escrituracion,MontoAhorro,PlantillaDeAhorro,ContratoMaestro ,IdEmpCrea
        ,FechaCaptura) 
        Values ('".$colonia."','".$nombreoficial."', ".$idtipoadquisicion
        .",'".$observaciones."' ,".$idmunicipio.",".$idcolonia.",".$soloescritura.",'".$montoahorro."','".$plantillaahorro."','".$contratomaestro."','".$nitavu."','".$fecha."')";
      
      if ($Vivienda->query($sql) == TRUE)
        {     
          mensaje('La colonia  ha sido agregada correctamente','lot_capturacolonias.php?m='.$idmunicipio);
        }
        else
        {
          mensaje('Hubo un error al agregar la colonia','lot_capturacolonias.php?m='.$idmunicipio); 
        }
         
     } 
     else 
     {
     	
       $idmunicipio = $_POST['IdMunicipioEdit'];
       $idcolonia=$_POST['IdColoniaEdit'];
       $colonia=$_POST['ColoniaEdit'.$idmunicipio.'_'.$idcolonia];
       $nombreoficial=$_POST['NombreOficialEdit'.$idmunicipio.'_'.$idcolonia];
       $idtipoadquisicion=$_POST['IdTipoAdquisicionEdit'.$idmunicipio.'_'.$idcolonia];
       $observaciones=$_POST['ObservacionesEdit'.$idmunicipio.'_'.$idcolonia];
       $soloescritura=isset($_POST['Solo_EscrituracionEdit'.$idmunicipio.'_'.$idcolonia]) ? 1 : 0;
       //$montoahorro=$_POST['MontoAhorroEdit'.$idmunicipio.'_'.$idcolonia];
       //$plantillaahorro=$_POST['PlantillaDeAhorroEdit'.$idmunicipio.'_'.$idcolonia];
       //$contratomaestro=$_POST['ContratoMaestroEdit'.$idmunicipio.'_'.$idcolonia];

       $montoahorro=NULL;
        $plantillaahorro=NULL;
        $contratomaestro=NULL;
 

       

       $sql = "UPDATE catcolonia SET Colonia='".$colonia."',  NOMBRE_OFICIAL='".$nombreoficial."', IdTipoAdquisicionCol=".$idtipoadquisicion
       .", Observaciones='".$observaciones."',Solo_Escrituracion=".$soloescritura.",MontoAhorro='".$montoahorro."',PlantillaDeAhorro='".$plantillaahorro."',ContratoMaestro='".$contratomaestro."'
       , FechaUltimaMod='".$fecha."',IdEmpModifica='".$nitavu."' WHERE IdMunicipio = ".$idmunicipio." and IdColonia= ".$idcolonia;
   
       
      if ($Vivienda->query($sql) == TRUE)
      {     
        mensaje('Se editó la información de la colonia correctamente','lot_capturacolonias.php?m='.$idmunicipio);
      }
      else
      {
        mensaje('Hubo un error al editar la información de la colonia','lot_capturacolonias.php?m='.$idmunicipio); 
      }

     }
}
else{echo "	<br><br>";echo "No tiene acceso a ".$id_aplicacion;}

    ?>