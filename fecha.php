<?php
if (isset($_GET['MSSQL'])){
    // 1999-10-22 00:00:00.000
    $fecha = date('Y-m-d')." 00:00:00.000";
} else {
    $fecha = date('Y-m-d');

}
    
    echo $fecha;
?>