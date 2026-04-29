<?php 
require("config.php");
require("lib/funciones.php");
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>ITAVU Validacion del Cerficado</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        @font-face {
            font-family: "Regular";
            src: url("lib/HelveticaNeueLTStd-Lt.otf") format("truetype")
        }
        body * {
            font-family:"Regular";
        }
        body {
            background-color:#484848;
            color: white;
        }
        #valido{
            position: fixed;
            top:30%; left:30%;
            width:40%;
            padding: 10px; 
            background-color:white; border-radius:5px; color:gray;
        }
        #novalido{
            position: fixed;
            top:30%; left:30%;
            width:40%;
            padding: 10px; 
            background-color:red; color:white; border-radius:5px;
        }
        @media only screen and (max-width:500px) {
            #valido, #novalido {
                width:90%; position:relative; top:0; left:0;
            }
        }        
    </style>
</head>
<body>
    <?php
        if (isset($_GET['id'])){
            $sql = "
            select * from fer where nfer_id='".$_GET['id']."' and estado=0";	
            $rc= $conexion -> query($sql);
            if($f = $rc -> fetch_array())
                {//valido
                    echo "<div id='valido'>";
                    echo "<img src='img/LogotipoOficial.jpg' style='width:60%;'><br>";
                    echo "<h1>CERTIFICADO DE SUBSIDIO ESTATAL</H1>";
                    echo "<h2> Fondo Economico de Reserva ITAVU </H2>";

                    echo "<table width=100%>";
                    echo "<tr><td>No. de Certificado</td><td>".$_GET['id']."</td></tr>";
                    echo "<tr><td>Beneficiario</td><td>".$f['nombre']."</td></tr>";
                    echo "<tr><td>Contrato</td><td>".$f['contrato']."</td></tr>";
                    echo "<tr><td>Fecha de Autorizacion</td><td>".$f['autorizo_fecha']."</td></tr>";

                    echo "</table>";
                    echo "<label>* Si los datos que ves aquí no son los mismo que la versión impresa, reportalo al 01800 633 3333</label>";
                    echo "</div>";
                    
                    
                }
            else {//NO VALIDO
                echo "<div id='novalido'>";
                echo "<img src='img/LogotipoOficial.jpg' style='width:80%;'><br>";
                echo "<h1> CERTIFICADO DE SUBSIDIO ESTATAL NO VALIDO </H1>";
                echo "<div id='AppDetalle'> Fondo Economico de Reserva ITAVU </div>";
                echo "El No. ".$_GET['id']." no esta registrado por ITAVU";
                
                echo "</div>";

            }
        }

    ?>
</body>
</html>