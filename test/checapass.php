<?php
// $hash='$2y$10$zlyUY3l/7ekZSG6GNxWBpOhyZ5m3rThfj5BphKa0S9wF1vnpIyoSG';
$hash= $_GET['hash'];
$contraseña = $_GET['pass'];
echo $hash."<br>";
if (password_verify($contraseña, $hash)) {
    echo '¡La contraseña '.$contraseña.' es válida!';
} else {
    echo 'La contraseña '.$contraseña.' no es válida.';
}
?>