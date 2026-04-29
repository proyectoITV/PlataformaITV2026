<?php
require ("rintera-config.php");
require ("components.php");
include("seguridad.php");

$nip = VarClean($_POST['nip']);
$sql="UPDATE users  SET NIP='".$nip."' WHERE IdUser='".$nitavu."'";
if ($db0->query($sql) == TRUE)
{
    echo "<script>
    $('#FormNIP').hide();
    $('#ResultadoNIP').show();
    </script>";

    echo "<img src='icons/ok.png' style='width:32px;'>Se ha actualizado correctamente.
    <a href='login.php' class='btn btn-success'>Continuar</a>
    ";
}
else {
    echo "<script>
    $('#FormNIP').hide();
    $('#ResultadoNIP').show();
    </script>";

    echo "<img src='icons/x.png' style='width:32px;'>Ha Habido un error.
    <a href='index.php' class='btn btn-warning'>Intentarlo Nuevamente</a>
    ";
}
?>