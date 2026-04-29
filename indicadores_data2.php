<?php
require ("config.php");
require ("components.php");
include("seguridad.php");

$IdTrimestre = VarClean($_POST['IdTrimestre']);
$Anio = VarClean($_POST['Anio']);
$Campo = VarClean($_POST['Campo']);
$Valor = VarClean($_POST['Valor']);
$IdDelegacion = VarClean($_POST['IdDelegacion']);




if ($IdDelegacion <> ""){


$id_aplicacion ="indicadores"; 
$nivel = aplicacion_nivel($id_aplicacion, $nitavu);
// $nivel = 1; //<--- Administrador completo
// $nivel = 2; //<--- Delegacion (Delegado)
// $nivel = 3; //<--- Oficinas Centrales
// $nivel = 4; //<-- Capturista
if (sanpedro($id_aplicacion, $nitavu)==TRUE){ 
       //UPdate o Insert
        
        $sql = 'select ifnull('.$Campo.',"") as Campo from indicadorestrimestrales Where Anio='.$Anio.' and IdTrimestre='.$IdTrimestre.' and
        IdDelegacion = '.$IdDelegacion.'';
        echo $sql;
        
        $r= $conexion -> query($sql);        
        if($f = $r -> fetch_array())
        {
          
                $sqlUpdate = "UPDATE indicadorestrimestrales SET ".$Campo."='".$Valor."'
                WHERE Anio ='".$Anio."' AND IdTrimestre='".$IdTrimestre."' and IdDelegacion=".$IdDelegacion."";
                if ($conexion->query($sqlUpdate) == TRUE){                   	
                    echo "<script>console.log('Guardado correctamente');</script>";
                    $sqlH = "
                    INSERT INTO indicadorestrimestrales_historia
                        (IdEmpleado,Anio,IdTrimestre,Campo,Valor,fecha,hora, IdDelegacion)
                    VALUES
                        ('".$nitavu."','".$Anio."','".$IdTrimestre."','".$Campo."','".$Valor."','".$fecha."','".$hora."','".$IdDelegacion."')";
                    if ($conexion->query($sqlH) == TRUE)
                    {	
                     
                    }else{ }
                } else {
                    echo "<script>console.log('ERROR al guardar');</script>";
                    Toast("No ha podido guardar, intentelo nuevamente",2,"");
                }
            
        } else {
            $sqlInsert = "insert INTO indicadorestrimestrales (Anio, IdTrimestre, IdDelegacion, ".$Campo.") VALUES(".$Anio.",".$IdTrimestre.",".$IdDelegacion.",".$Valor.")";
            if ($conexion->query($sqlInsert) == TRUE){                   	
                echo "<script>console.log('Guardado nuevo correctamente');</script>";

                $sqlH = "
                    INSERT INTO indicadorestrimestrales_historia
                        (IdEmpleado,Anio,IdTrimestre,Campo,Valor,fecha,hora, IdDelegacion)
                    VALUES
                        ('".$nitavu."','".$Anio."','".$IdTrimestre."','".$Campo."','".$Valor."','".$fecha."','".$hora."','".$IdDelegacion."')";
                    if ($conexion->query($sqlH) == TRUE)
                    {	
                     
                    }else{ }

                
            } else {
                echo "<script>console.log('ERROR al guardar nuevo');</script>";
                Toast("No ha podido guardar el nuevo registro, intentelo nuevamente",2,"");
            }
        }





     
        // echo '<script>';

        // echo '</script>';


     





} else {mensaje("ERROR: no tienes acceso","");}


} else {
    Toast('
    Por favor seleccione antes la Delegacion, y despues clic en el Trimestre.
    ',2,"");
        
}

?>


<?php
// include ("./lib/body_footer.php"); //Cierre de Estructura de la Plaforma
?>