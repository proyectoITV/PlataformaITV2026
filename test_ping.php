<?php include ("lib/body_head.php");


$ipserver="172.16.120.2";
echo "Haciendo ping a ".$ipserver."...";
$ping=  ping($ipserver,"80");
if ($ping == TRUE) {
    echo ":)";
} else {echo ":(";}





include ("lib/body_footer.php");
?>
