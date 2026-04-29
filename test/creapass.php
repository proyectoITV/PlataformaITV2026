<?php
echo "PASSWORD CIFRADA";
echo "<br>";
$pass=$_GET['pass'];
$hash=password_hash($pass, PASSWORD_DEFAULT);
echo "HASH: " . $hash;
?>