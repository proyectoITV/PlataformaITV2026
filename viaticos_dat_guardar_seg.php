<?php
require("config.php");
require("seguridad.php");
require("var_clean.php");
require("lib/funciones.php");
require("viaticos_fun.php");
require("lib/yes_funciones.php");
// require_once("lib/flor_funciones.php");

          
            //     if (viaticosIn($IdViatico, $NEmpleado, $nitavu) == TRUE){
            //         Toast("Se Registro el Viatico con Id ".$IdViatico,4,"");
            //     } else {Toast("Error al registrar el IdViatico",2,"");}
$IdViatico = VarClean($_POST['IdViatico']);    
$NEmpleado = VarClean($_POST['NEmpleado']);
$Estatus = VarClean($_POST['Estatus']);
$Observaciones=VarClean($_POST['Observaciones']);

//Validaciones pendientes
$Go = TRUE;
//1-- La Fechas no pueden menor a la de hoy
// echo "Fecha de salida = ".$FechaSalida." | ";
// echo "Fecha hoy = ".$fecha." | ";
// if ($FechaSalida < $fecha ){
//     $Go = FALSE;
//     Toast("La Fecha de Salida no puede ser menor a la de hoy ",2,"");
// }

// //2.- La fecha de Regreso no puede ser menor a la Fecha de Salida
// if ($FechaRegreso < $FechaSalida ){
//     $Go = FALSE;
//     Toast("La Fecha de Regreso no puede ser menor a la de Salida ",2,"");
// }
if ($Estatus==5)
{
 $Total= totalGastosFull($IdViatico);
 //$montodispible=ExistePresupuestoViatico(  $IdViatico);
 //$nuevomonto=floatval($montodispible)- floatval($Total);
 $iddireccion=quienEsmiDireccion(nitavu_dpto($NEmpleado));
 $sql="Update viaticosadmin set montoutilizado=(montoutilizado+". $Total."), montodisponible=(montodisponible-". $Total.")
 where iddireccion=". $iddireccion;

                echo $sql;
                $r = $conexion -> query($sql);
                if ($conexion->query($sql) == TRUE) {
                
                   $Go = TRUE;                  

                    //               
                    
                }else{
                    $Go = FALSE;
                    Toast("No se pudo registrar el pago del viatico ",2,"");    
                }
            }

if ($Go == TRUE) {
   
                $sql="UPDATE viaticos SET                          
                estatus='".$Estatus."'
                WHERE IdViatico='".$IdViatico."'
                ";

                echo $sql;
                $r = $conexion -> query($sql);
                if ($conexion->query($sql) == TRUE) {
                    $IdSegViatico=  NextIdSeguimiento($IdViatico);
                $sql2="INSERT INTO viaticosseguimiento(IdViatico,IdSegViatico,IdEstatus,FechaCrea,NitavuCrea,Observaciones)VALUES($IdViatico,($IdSegViatico+1),$Estatus,NOW(),$nitavu,'$Observaciones')";
               echo $sql2;
                if ($conexion->query($sql2) == TRUE) {

                    echo "exito";
                    Toast("Se guardo correctamente el Viatico ".$IdViatico,4,"");
                    // echo "
                    // <script>
                    // Swal.fire({
                    //     icon: 'error',
                    //     title: 'EXITO',
                    //     text: 'Se guardo correctamente el Viatico ',
                    //     timer: 1500,
                    //     footer: '<a>Verifique los datos y vuelva a intentarlo</a>'
                    // });
                    // </script>
                    // ";
                    historia($nitavu,"Actualizo el Viatico con IdViatico=".$IdViatico." del empleado con No=".$NEmpleado.", Estatus=".$Estatus);               
                    
                }

            }
            else {
                return  FALSE;
                NotificaError("Error al Guardar viaticos ".$sql, "Error en viaticos");
            }
            
            

        }
    

?>
<!-- //<script> viaticosResumen();</script> -->