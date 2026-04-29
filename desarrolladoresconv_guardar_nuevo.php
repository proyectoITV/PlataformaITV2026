<?php

require("config.php");
require("seguridad.php");
require("var_clean.php");
require("lib/funciones.php");
require("lib/laura_funciones.php");
require_once("lib/flor_funciones.php");



require("vehiculos_fun.php");


$VFolio=IdNuevo('convdesarrollador','Folio');
$VFolio=VarClean($VFolio);
$VFechaConvenio=VarClean($_POST['VFechaConvenio']);
$VIdDesarrollador=VarClean($_POST['VIdDesarrollador']);
$VIdDelegacion=VarClean($_POST['VIdDelegacion']);
$VIdMunicipio=VarClean($_POST['VIdMunicipio']);
$VMontoConvenio=VarClean($_POST['VMontoConvenio']);
$VAnticipoGlobal=VarClean($_POST['VAnticipoGlobal']);
$VPlazoConvenio=VarClean($_POST['VPlazoConvenio']);
$VSubsidioLote=VarClean($_POST['VSubsidioLote']);
$VIdMunicipio=VarClean($_POST['VIdMunicipio']);
$VTotalLotes=VarClean($_POST['VTotalLotes']);

       
if ($VIdDesarrollador == ''){
    Toast("Error, Desarrollador no identificado",2,"");
} else{
    $sql="
    INSERT INTO convdesarrollador
    (IdDelegacion, IdPrograma,Folio,Completo, FechaConvenio,IdDesarrollador, 
    MontoConvenio,AnticipoGlobal, PlazoConvenio, SubsidioLote,  TotalLotes,
    IdMunicipio, 
     IdEmpCrea,FechaCaptura)
      values(
          ".$VIdDelegacion.",
          165,
          ".$VFolio.",
          0,
          '".$VFechaConvenio."',
          ".$VIdDesarrollador.",
          ".$VMontoConvenio.",
          ".$VAnticipoGlobal.",
          ".$VPlazoConvenio.",
          ".$VSubsidioLote.",
          ".$VTotalLotes.",
          ".$VIdMunicipio.",
          '".$nitavu."',
          '".$fecha."'    
    )
    
    ";
    //echo $sql;
    //echo 'Numero de convenio:'.$VFolio;
    echo "<script>$('#VIdConv').val('".$VFolio."');</script>";
    
    
    //echo $VFolio;
     //echo '<script>Console.log("'. $sql.'");</script>';
    // $resultado = $conexion -> query($sql);
    
    if ($Vivienda->query($sql) == TRUE) {
        Toast("Actualizado con exito",1,"");
    }else {
      Toast("Error al Guardar Convenio  ".$VFolio."",2,"");
     }

    unset($sql,$resultado);
}

?>
