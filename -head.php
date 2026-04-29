
<?php

//require ("rintera-config.php");
require ("config.php");
require ("components.php");
    include("seguridad.php");   
   // include("lib/flor_funciones.php");
    //include("tokens.php");
    if (isset($nitavu)){
        MiToken_CloseALL($nitavu);
    }
    
    

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">	
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>REPORTES_</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=yes">
    <meta http-equiv="x-ua-compatible" content="ie-edge">
    <link rel="stylesheet" href="src/default.css">

    <!-- JQUERY -->
    <script src="node_modules/jquery/dist/jquery.min.js"></script>

    
    <!-- BOOTSTRAP -->
    <script src="node_modules/bootstrap/dist/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="node_modules/bootstrap/dist/css/bootstrap.min.css">    
    <script src="node_modules/popper.js/dist/popper.min.js"></script>
    
    <!-- DATATABLE -->
    <script src="lib/datatables.min.js"></script>
    <!-- <script src="lib/jquery.dataTables.min.js"></script> -->
    <script src="lib/dataTables.fixedColumns.min.js"></script>    
    <script src="lib/dataTables.buttons.min.js"></script>    
    <script src="lib/jszip.min.js"></script>    
    <script src="lib/pdfmake.min.js"></script>    
    <script src="lib/vfs_fonts.js"></script>    
    <script src="lib/buttons.html5.min.js"></script>    
    <!-- <script src="lib/datetime.js"></script>     -->
    
    
   
     <!-- fluid -->
     <link rel="stylesheet" href="lib/fluid/fluid.css">
    
    <link rel="stylesheet" href="lib/jquery.dataTables.min.css">    
    <link rel="stylesheet" href="lib/buttons.dataTables.min.css">    
    
    <!-- fontawesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">    

    
   


    <!-- TOAST -->
    <link rel="stylesheet" href="lib/jquery.toast.min.css">
    <script type="text/javascript" src="lib/jquery.toast.min.js"></script>

    <!-- Modal -->
    <script src="lib/jquery.modalpdz.js"></script> 
    <link rel="stylesheet" href="lib/jquery.modalcsspdz.css" />

    <!-- ChatJS -->
    <script src="node_modules/chart.js/dist/Chart.bundle.js"></script> 
    <link rel="stylesheet" href="node_modules/chart.js/dist/Chart.css" />

    
    
    <!-- <link href="lib/jquery.flexdatalist.css" rel="stylesheet" type="text/css">
    <script src="lib/jquery.flexdatalist.js"></script> -->
    <!-- <script src="lib/jcanvas.min.js"></script> --> 
    <!-- <script src="lib/apexcharts.min.js"></script> -->
    <!-- <link rel="stylesheet" type="text/css" href="lib/bootstrap/css/bootstrap.css">
    
    
    <link rel="stylesheet" type="text/css" href="lib/datatables.min.css"/> 
    <script type="text/javascript" src="lib/datatables.min.js"></script>
    <script src="lib/jquery.modalpdz.js"></script> 
    <link rel="stylesheet" href="lib/jquery.modalcsspdz.css" /> -->


 

<link rel="icon" href="data:;base64,iVBORw0KGgo=">
<link rel="shortcut icon" href="4t.ico">
<link rel="shortcut icon" href="data:image/x-icon;," type="image/x-icon">
</head>
<body style="
background-color: <?php echo Preference("ColorDeFondo", "", ""); ?>;
text-align:center;
">
<?php
// Init();
?>

<div id='PreLoader' style='
    background-color: <?php echo Preference("ColorPrincipal", "", ""); ?> ;
    opacity: 0.7;
'>
    <div id='Loader' style='
        left: 30%;
        top: 26%;
        '>
        <img src='img/Logo.png' style='width:42px;'><br>
        <b style='color:white;'>Cargando</b> <img src='img/loader_bar.gif' style='width:13px;'><br>
    </div>
</div>