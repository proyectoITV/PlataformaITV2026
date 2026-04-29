<?php

//TOMAR TURNO

$nitavu = $_POST['nitavu'];
require_once("unica/config.php");
require_once("unica/funciones.php");
//mi turno actual


if (FinalizarTurno($nitavu)==TRUE){
    echo MiTurnoActual($nitavu);
} else {
    echo "<b style='font-size:12pt; color:red;'>No se ha podido finalizar el Turno</b>";
    echo "<script>
    NPush('No se ha podido finalizar el Turno','Plataforma ITAVU')
    </script>";
}

//echo $tmp."</section>";
?>

