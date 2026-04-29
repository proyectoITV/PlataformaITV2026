
<?php
require ("rintera-config.php");
require ("components.php");
include("seguridad.php");   

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">	
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title><?php echo $Cliente.": ".$ClienteInfo; ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=yes">
    <meta http-equiv="x-ua-compatible" content="ie-edge">

    <script src="lib/popper.min.js"></script>
    <script src="lib/jquery-3.5.1.js"></script>
    <script src="lib/bootstrap/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="src/default.css">



<link rel="stylesheet" type="text/css" href="lib/bootstrap/css/bootstrap.css">
<link rel="stylesheet" href="lib/jquery.toast.min.css">
<script type="text/javascript" src="lib/jquery.toast.min.js"></script>
<link rel="stylesheet" type="text/css" href="lib/datatables.min.css"/> 
<script type="text/javascript" src="lib/datatables.min.js"></script>
<script src="lib/jquery.modalpdz.js"></script> 
<link rel="stylesheet" href="lib/jquery.modalcsspdz.css" />


</head>
<body>

<?php 

// Init();
?>
<div id='PreLoader'>
    <div id='Loader'>
        <img src='img/loader_classic.gif'><br>      
    </div>
</div>

<?php


echo "Preferencia Test = ".Preference('test', '', '');

?>


<div id='R' style='display:none;' >
</div>

</body>
</html>
