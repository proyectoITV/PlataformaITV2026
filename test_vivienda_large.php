
<?php include ("./lib/body_head.php"); include ("./lib/body_menu.php"); ?>
<?php
//Utilizacion de DatosViviendaLarge
//envia las variables por POST y consume sql_large.asp en el Servidor del Webservice

echo "<hr> Metodo PARA UPDATE E INSERT:";

//====== METODO PARA UN UPDATE O INSERT ==========================
$consulta = "

DECLARE @RESULTADO INT;

    exec registrarSolicitudDesdePlataforma 'PEPF950323MTSRRL07','12', 'PEPF950323MTSRRL07','2019-11-05','1995-03-23', '2850',

    '7','1','PEREZ', 'aaaa','FLOR SELINA', 'PEREZ','aaaa','FLOR SELINA PEREZ PEREZ','PEPF950323MCLRRL','MEXICANO(A)',

    'aaaaaa','12', '78','16767','1','CALLE aa NUM. 11/11  COLONIA aa','1',

    '1','DAVID FUENTES VARGAS','1','8342095002', '1','1', '1',

    '1','1','1', '1', 'EFREN DE LEON GARCIA', 'CALLE aaa NUM. 111/11  COLONIA aa', 'a',

    '24', '11','5000','1', '3', 'aaa', '', '3', '', '', '','AERL800605HHGRMB04','1980-06-05','PERL800605HCLRMB','7','2','RAMIREZ', 'asd', 'LIBORIO', 'PEREZ', 'asd', 'MEXICANO(A)', '39','asd', 'asdasd','asd','6', '1', '10000','asdasd', 'asd','asd','asd','True','aaa','aaa','111 #111 N. int:111','340070','557','21','1','111','111','aaa', '1111111', '6 años', '1111','11111','aaa','','aaa','aaa','zzz','zc','13', '2','333','zzz', 'zz','zz','zz','True','False','3','4', '', @RESULTADO output;

    SELECT @RESULTADO as Resultado;
    
    ";

    $consulta= "select @@version";
    $IdDelegacion = 12; // (la tabla Test esta solo en Estatal)
	$Usuario = "2809";
	$DescripcionDeUso = "Test"; // en que programa o uso

$ConsultaDATA2 = DatosViviendaLarge($IdDelegacion, $Usuario, $DescripcionDeUso, $consulta);

if ($ConsultaDATA2 == TRUE){ //construir los datos
    $array2 = json_decode($ConsultaDATA2, true);
    if(is_array($array2)){

        foreach ($array2 as $value2) {
            if (isset($value2['r'])){// si hay un error
                echo "Error: ".$value2['r'];

            } else {
                //Se obtenien las variables $value['campo'] de acuerdo a la consulta
                echo "SQL = ".$consulta."<br>";
                echo "Respuesta del Webservice: exito=".$value2['exito']."<br>";
            

            }
            
        }
    } else {
        echo "ERROR: No es posible construir los datos: ".$ConsultaDATA2;
    }
} else {echo "Sin exito la coneccion";}





// echo "<hr> Metodo SELECT:";

// //====== METODO PARA UN SELECT ==========================
// $consulta = "SELECT count(*) as Resultado from CatalogoDeVPN";
// 	$IdDelegacion = 6; // IdDelegacion donde se ejecutara
// 	$Usuario = $nitavu; // Usuario que la Ejecutara
// 	$DescripcionDeUso = "Test"; // en que programa o uso

// $ConsultaDATA = DatosViviendaLarge($IdDelegacion, $Usuario, $DescripcionDeUso, $consulta);
// $array = json_decode($ConsultaDATA, true);
// if(is_array($array)){

//      foreach ($array as $value) {
//         if (isset($value['r'])){// si hay un error
//             echo "Error: ".$value['r'];

//         } else {
// 			//Se obtenien las variables $value['campo'] de acuerdo a la consulta
// 			echo "SQL = ".$consulta."<br>";
//             echo "Respuesta:".$value['Resultado']."<br>";
         

//         }
           
//      }
// } else {
//     echo "ERROR: No es posible construir los datos: ".$ConsultaDATA;
// }




?>
<?php include ("lib/body_footer.php"); ?>