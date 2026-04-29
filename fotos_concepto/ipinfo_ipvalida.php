<?php 	require("unica/funciones.php"); ?>
<?php 	require("unica/config.php"); ?>

<?php
if (isset($_GET['ipcliente'])){
    if (IPautorizada($_GET['ipcliente'])==TRUE){
        // echo "<img src='icon/ok.png' style='width:12px;'><span id='label_ip' style='font-size:8pt;'>".$_GET['ipcliente']."</span>";
    } else {
        // echo "<img src='icon/x.png' style='width:12px;'><span id='label_ip' style='font-size:8pt;'>".$_GET['ipcliente']."</span>";
    }
}            

?>            