<?php

//WIDGET PROTOTIPO

$nitavu = $_POST['nitavu'];
require_once("config.php");
require_once("lib/funciones.php");
//mi turno actual

$TurnoActual =  MiTurnoActual($nitavu);
if ($TurnoActual == ""){
    echo "<b style='font-size:14pt;'>Sin Turno actualmente</b>";
} else {
    if (FinalizarTurnoAuscente($nitavu)==TRUE){
        echo "Turno finalizo ".$TurnoActual;
        echo "<script>
        NPush('Turno Finalizado ".$TurnoActual."','Plataforma ITAVU')
        </script>";
    } else{
        echo "<script>
        NPush('Hubo un problema al finalizar el Turno  ".$TurnoActual."','Plataforma ITAVU')
        </script>";
    }
    
}


//echo $tmp."</section>";
?>

