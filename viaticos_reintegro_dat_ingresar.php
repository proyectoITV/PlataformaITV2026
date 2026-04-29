<?php
require("config.php");
require("seguridad.php");
require("var_clean.php");
require("lib/funciones.php");
require("viaticos_fun.php");
// require_once("lib/flor_funciones.php");

$IdViatico = VarClean($_POST['IdViatico']);
$CantidadRecibida = VarClean($_POST['CatidadRecibida']);
$InputToken = VarClean($_POST['InputToken']);

    $sqlC = "select * from viaticoscomprobaciones  WHERE IdViatico='".$IdViatico."'";		
	$rC= $conexion -> query($sqlC);					
	if($fc = $rC -> fetch_array())
	{
        if ($CantidadRecibida > $fc['Faltante']){
            Toast("La cantidad recibida es mayor que el Faltante ",2,"");
        } else {
            $IdReintegro = NIdReintegro(FALSE);
            $sql="INSERT INTO viaticosreintegros (IdReintegro,IdViatico, Fecha, Hora, Cajero, Reintegro, InputToken) 
            VALUES(
                '".$IdReintegro."',
                '".$IdViatico."',
                '".$fecha."',
                '".$hora."',
                '".$nitavu."',
                '".$CantidadRecibida."',
                '".$InputToken."'
            )";

            if ($conexion->query($sql) == TRUE){ 
                historia($nitavu,"[viaticosR] =  Reintegro ".$CantidadRecibida." al IdViatico=".$IdViatico);	
               // Toast("Reintegro guardado correctamente",4,"");       
                echo "
                <script>
                Swal.fire({
                    icon: 'error',
                    title: 'EXITO',
                    text: 'Reintegro guardado correctamente ',
                    footer: '<a>Verifique los datos y vuelva a intentarlo</a>'
                });
                </script>
                ";         

                echo "<a href='viaticor_printrecibo.php?id=".$IdReintegro."' class='btn btn-warning' 
                download='".EasyName("Recibo"."4").".pdf'>Imprimir Recibo ".$IdReintegro."</a>";

                echo "<script>Seleccionar();</script>";

            } else {
                //Toast("Error al guardar el Reintegro",2,"");
                echo "
                <script>
                Swal.fire({
                    icon: 'error',
                    title: 'ERROR',
                    text: 'Error al guardar el Reintegro ',
                    footer: '<a>Verifique los datos y vuelva a intentarlo</a>'
                });
                </script>
                ";  
            }        
        }
       
	}  else {
        echo "ESTE VIATICO <b>[".$IdViatico."] </b>NO ESTA LISTO PARA LA COMPROBACION";
    }  
    unset($sqlC, $rC, $fc);
    echo "</div>";






?>

