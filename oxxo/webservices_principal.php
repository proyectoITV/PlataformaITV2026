<?php
    if (empty($_POST['txtbuscar'])==0)
    {
        $referencia = $_POST['txtbuscar'];
        $numcontrato1 = substr($referencia, 4, 11);
        $numcontrato2 = substr($referencia, 3, 12);
        $validacion1 = $_POST['txtprimerapellido'];
    }
?>