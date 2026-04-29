<?php
    // ¡MANTENER ESTO ACTIVO DURANTE LA DEPURACIÓN!
    ini_set('display_errors', 1);
    error_reporting(E_ALL);

    require ("config.php");
    require ("components.php");
    include("seguridad.php");

    $id_rep = 26; // <-- ¡VALOR FIJO PARA PRUEBAS!
    //$id_rep = VarClean($_POST['id_rep'] ?? null);
    //$id_rep = VarClean($_POST['id_rep']);
    $Tipo = ReporteTipo($id_rep);
    $ClaseDiv  = "ContenedorDeReporte"; $ClaseTabla = "tabla";
    $Data =  Reporte($id_rep, $Tipo, $ClaseDiv, $ClaseTabla, $nitavu );
?>