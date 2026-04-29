<?php
require("config.php");
require("seguridad.php");
require("var_clean.php");
require("lib/funciones.php");
require("viaticos_fun.php");
// require_once("lib/flor_funciones.php");

$IdRecorrido = VarClean($_POST['IdRecorrido']);
$IdViatico = VarClean($_POST['IdViatico']);
$sql = "DELETE from viaticosrecorridos WHERE IdRecorrido='".$IdRecorrido."'";
$resultado = $conexion -> query($sql);
if ($conexion->query($sql) == TRUE){
    historia($nitavu, "[viaticos] Borro recorrido cargado al IdRecorrido=".$IdRecorrido." del Viatico ".$IdViatico);
    // echo "
    // <script>
    // Swal.fire({
    //     icon: 'error',
    //     title: 'EXITO',
    //     text: 'Se guardo correctamente el Viatico ',
    //     timer: 1500,
    //     footer: '<a>Verifique los datos y vuelva a intentarlo</a>'
    // });
    // </script>
    // ";
  //  Toast("Se borro correctamente",4,"");
} else {
 
    echo "<script>
    Swal.fire({
        icon: 'error',
        title: 'ERROR',
        text: 'No se pudo borrar el IdRecorrido ".$IdRecorrido."',
        timer: 1500,
        footer: ''
    });
    </script>
    ";
 //   Toast("ERROR al borrar el IdRecorrido ".$IdRecorrido."",2,"");
}

unset($resultado, $sql);



?>