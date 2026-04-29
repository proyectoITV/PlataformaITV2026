<?php
    $servername = "192.168.159.5";
    $database = "produccion_itavu";
    $username = "root";
    $password = "3LS4NT0**";

    global $conexion;
    $conexion = mysqli_connect($servername, $username, $password, $database);

    if (!$conexion) {
        die("Connection failed: " . mysqli_connect_error());
    }
?>