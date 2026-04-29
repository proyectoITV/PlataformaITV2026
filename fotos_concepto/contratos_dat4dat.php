<?php
require("unica/seguridad.php"); 
require_once("unica/config.php");
require_once("unica/funciones.php");
require_once("unica/flor_funciones.php");

error_reporting(0); //<-- para simular produccion

$IdDelegacion = $_GET['IdDelegacion'];
$IdPrograma = $_GET['IdPrograma'];
 //Parametros
 
            $Moratorio = 0;
            
            $MSSQL = "
            select 
            IdPrograma, Programa,
            (Select SUM(Saldo_Moratorio) from Vivienda_InformacionFinanciera WHERE Vivienda_InformacionFinanciera.IdPrograma = PROGRAMA.IdPrograma) as MoratorioPrograma
            from PROGRAMA
            WHERE IdPrograma = ".$IdPrograma."
            ";
            $ConsultaDATA = DatosViviendaLarge($IdDelegacion, "WSContratos", "Test", $MSSQL);    
            $array = json_decode($ConsultaDATA, true);
            // var_dump($array);
            $error = 0;
            if(is_array($array)){            
                foreach ($array as $value) {
                    if (isset($value['r'])){// si hay un error
                        echo "<b style='background-color:red; color:white; padding:5px; border-radius:3px; margin:3px;'>*Error: ".$value['r']."</b>";
                        $error = $value['r'];                        
                        $Moratorio = 0;
                    } else {
                        $Moratorio = $value['MoratorioPrograma'];
                        echo "<b title='".$Moratorio."'>$ ".number_format($value['Saldo'],2,'.',',')."</b>";
                    }
                }
            } else {//error no es un array
                $Moratorio = 0;
                echo "<b title='".$ConsultaDATA."' style='background-color:red; color:white; padding:5px; border-radius:3px; margin:3px;'>Error : </b>";

            }            
            
        
 





?>

