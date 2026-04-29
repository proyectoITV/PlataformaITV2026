
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"> </script>
   
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
$NOficio = VarClean($_POST['NOficio']);
$FechaSalida = VarClean($_POST['FechaSalida']);
// $HoraSalida = VarClean($_POST['HoraSalida']);
$HoraSalida = date("H:i:s" , strtotime($_POST['HoraSalida']));
$FechaRegreso = VarClean($_POST['FechaRegreso']);
// $HoraRegreso = VarClean($_POST['HoraRegreso']);
$HoraRegreso = date("H:i:s" , strtotime($_POST['HoraRegreso']));
// $IdHospedaje = VarClean($_POST['IdHospedaje']);
$Comision = VarClean($_POST['Comision']);
$JefeInmediato = VarClean($_POST['JefeInmediato']);
$TipoTransporte = VarClean($_POST['TipoTransporte']);
$Status = VarClean($_POST['Status']);
$Particular_Marca = "";
$Particular_Placas = "";
$Particular_Modelo = "";
$Particular_Tipo = "";
$Particular_Cilindros = "";
$IdVehiculoOficial = "";
$Veh_Transporte = "";
$Veh_TransporteGasto = "";
$IdTipoTransporte = VarClean($_POST['IdTipoTransporte']);

$RecorridoExcedente = VarClean($_POST['RecorridoExcedente']); 

if ($TipoTransporte=='PARTICULAR'){
    $Particular_Marca = VarClean($_POST['Marca']);
    $Particular_Placas = VarClean($_POST['Placas']);
    $Particular_Modelo = VarClean($_POST['Modelo']);
    $Particular_Tipo = VarClean($_POST['Tipo']);
    $Particular_Cilindros = VarClean($_POST['Cilindros']);


    if($Particular_Marca=="" or $Particular_Placas=="" or $Particular_Modelo=="" or  $Particular_Tipo=="" or $Particular_Cilindros=="" or $Particular_Cilindros=="0")
    {
        echo "<script>
        Swal.fire({
            icon: 'error',
            title: 'ERROR',
            text: 'Los datos del vehiculo no estan llenos correctamente.',
            timer: 5000,
            footer: '<a>Verifique los datos y vuelva a intentarlo</a>'
        });
        </script>
        ";
        return;
    }

} else {
    if ($TipoTransporte=='OFICIAL'){
        $IdVehiculoOficial = VarClean($_POST['IdVehiculoOficial']);
        if($IdVehiculoOficial=="")
        {
            echo "<script>
            Swal.fire({
                icon: 'error',
                title: 'ERROR',
                text: 'El tipo de transporte de regreso no a sido seleccionado',
                timer: 5000,
                footer: '<a>Verifique los datos y vuelva a intentarlo</a>'
            });
            </script>
            ";
            return;
        }

    } else {
        if ($TipoTransporte=='PUBLICO' or $TipoTransporte== 'NINGUNO' or  $TipoTransporte=='AEREO'){
            $Veh_Transporte = VarClean($_POST['Veh_Transporte']);
            $Veh_TransporteGasto = VarClean($_POST['Veh_TransporteGasto']);

        }
         else {
            //Toast("ERROR: sin Tipo de Transporte Seleccionado",2,"");
            echo "<script>
            Swal.fire({
                icon: 'error',
                title: 'ERROR',
                text: 'Sin Tipo de Transporte Seleccionado',
                timer: 5000,
                footer: '<a>Verifique los datos y vuelva a intentarlo</a>'
            });
            </script>
            ";
            return;
        }
    }

}









$TipoTransporteR = VarClean($_POST['TipoTransporteR']);
$Particular_MarcaR = "";
$Particular_PlacasR = "";
$Particular_ModeloR = "";
$Particular_TipoR = "";
$Particular_CilindrosR = "";
$IdVehiculoOficialR = "";
$Veh_TransporteR = "";
$Veh_TransporteGastoR = "";
$IdTipoTransporteR = VarClean($_POST['IdTipoTransporteR']);


if ($TipoTransporteR=='PARTICULAR'){
    $Particular_MarcaR = VarClean($_POST['MarcaR']);
    $Particular_PlacasR = VarClean($_POST['PlacasR']);
    $Particular_ModeloR = VarClean($_POST['ModeloR']);
    $Particular_TipoR = VarClean($_POST['TipoR']);
    $Particular_CilindrosR = VarClean($_POST['CilindrosR']);

    if($Particular_MarcaR=="" or $Particular_PlacasR=="" or $Particular_ModeloR=="" or  $Particular_TipoR=="" or $Particular_CilindrosR=="" or $Particular_CilindrosR=="0")
    {
        echo "<script>
        Swal.fire({
            icon: 'error',
            title: 'ERROR',
            text: 'Los datos del vehiculo de regreso no estan llenos correctamente.',
            timer: 5000,
            footer: '<a>Verifique los datos y vuelva a intentarlo</a>'
        });
        </script>
        ";
        return;
    }

} else {
    if ($TipoTransporteR=='OFICIAL'){
        $IdVehiculoOficialR = VarClean($_POST['IdVehiculoOficialR']);
        if($IdVehiculoOficialR=="")
        {
            echo "<script>
            Swal.fire({
                icon: 'error',
                title: 'ERROR',
                text: 'El tipo de transporte de regreso no a sido seleccionado',
                timer: 5000,
                footer: '<a>Verifique los datos y vuelva a intentarlo</a>'
            });
            </script>
            ";
            return;
        }
    

    } else {
        if ($TipoTransporteR=='PUBLICO' or $TipoTransporteR== 'NINGUNO' or  $TipoTransporteR=='AEREO'){
            $Veh_TransporteR = VarClean($_POST['Veh_TransporteR']);
            $Veh_TransporteGastoR = VarClean($_POST['Veh_TransporteGastoR']);

        }
         else {
            //Toast("ERROR: sin Tipo de Transporte Seleccionado",2,"");
            echo "<script>
            Swal.fire({
                icon: 'error',
                title: 'ERROR',
                text: 'Sin Tipo de Transporte SeleccionadoR',
                timer: 5000,
                footer: '<a>Verifique los datos y vuelva a intentarlo</a>'
            });
            </script>
            ";
            return;
        }
    }

}

if(    $IdTipoTransporte ==0)
{
    $Veh_Transporte = "";
    $Veh_TransporteGasto = "";
}
if(    $IdTipoTransporteR ==0)
{
    $Veh_TransporteR = "";
    $Veh_TransporteGastoR = "";
}


//Validaciones pendientes
$Go = TRUE;


// //1.- Se valida si se capturo un numero de oficio
if (!empty($NOficio)) 
{
    $Go = TRUE;
}else
{   $Go = FALSE;
   // Toast("No se ha capturado el número de oficio",5,"");
   echo "<script>
   Swal.fire({
       icon: 'error',
       title: 'ERROR',
       text: 'No se ha capturado el número de oficio',
       timer: 5000,
       footer: '<a>Verifique los datos y vuelva a intentarlo</a>'
   });
   </script>
   ";
    return;
    //echo "No se ha capturado el Numero de Oficiio";
}


//2-- La Fechas no pueden menor a la de hoy
// echo "Fecha de salida = ".$FechaSalida." | ";
// echo "Fecha hoy = ".$fecha." | ";
if ($FechaSalida < $fecha ){
    $Go = FALSE;
   // Toast("La Fecha de Salida no puede ser menor a la de hoy ",5,"");
   echo "<script>
   Swal.fire({
       icon: 'error',
       title: 'ERROR',
       text: 'La Fecha de Salida no puede ser menor a la de hoy',
       timer: 5000,
       footer: '<a>Verifique los datos y vuelva a intentarlo</a>'
   });
   </script>
   ";
    return;
}

// //3.- La fecha de Regreso no puede ser menor a la Fecha de Salida
if ($FechaRegreso < $FechaSalida ){
    $Go = FALSE;
   // Toast("La Fecha de Regreso no puede ser menor a la de Salida ",5,"");
    echo "
    <script>
    Swal.fire({
        icon: 'error',
        title: 'ERROR',
        text: 'La Fecha de Regreso no puede ser menor a la de Salida',
        timer: 5000,
        footer: '<a>Verifique los datos y vuelva a intentarlo</a>'
    });
    </script>
    ";
    return;
}


// //4.- Verifica si se captura la comision
if (!empty($Comision)) 
{
    $Go = TRUE;
}else
{    $Go = FALSE;
   // Toast("No se ha capturado la comision",5,"");
   echo "
   <script>
   Swal.fire({
       icon: 'error',
       title: 'ERROR',
       text: 'No se ha capturado la comision',
       timer: 5000,
       footer: '<a>Verifique los datos y vuelva a intentarlo</a>'
   });
   </script>
   ";
    return;
    //echo "No se ha capturado la comision";
}
// //5.- Verifica si se captura el tipotransporte
if (!empty($TipoTransporte)) 
{
    $Go = TRUE;
}else
{    $Go = FALSE;
   // Toast("No se ha capturado el tipo de transporte",2,"");
   echo "
   <script>
   Swal.fire({
       icon: 'error',
       title: 'ERROR',
       text: 'No se ha capturado el tipo de transporte ',
       timer: 5000,
       footer: '<a>Verifique los datos y vuelva a intentarlo</a>'
   });
   </script>
   ";
    return;
   // echo "No se ha capturado el tipo de transporte";
}

// //6.- Se verifica que se hayan agregado gastos
if(viaticos_GastosFull($IdViatico)==TRUE)
{
    $Go = TRUE;
}else{
    //Toast("Faltan algunos datos",2,"");
    
    echo "
    <script>
    Swal.fire({
        icon: 'error',
        title: 'ERROR',
        text: 'Faltan algunos datos ',
        timer: 5000,
        footer: '<a>Verifique los datos y vuelva a intentarlo</a>'
    });
    </script>
    ";
    return;
   //echo "Faltan algunos datos";
}

// //6.- Se verifica que se hayan agregado gastos
if(viaticos_NReccorridos($IdViatico)>0)
{
    $Go = TRUE;
}else{
    //Toast("Faltan algunos datos",2,"");
    
    echo "
    <script>
    Swal.fire({
        icon: 'error',
        title: 'ERROR',
        text: 'No se ha agregado un recorrido',
        timer: 5000,
        footer: '<a>Verifique los datos y vuelva a intentarlo</a>'
    });
    </script>
    ";
    return;
   //echo "Faltan algunos datos";
}


// // // //7.- Se valida si esta dado de alta el presupuesto para esa direccion
// $iddireccion=quienEsmiDireccion(nitavu_dpto($NEmpleado));
// EstaDadoAltaUnPresupuesto($iddireccion);

// if(EstaDadoAltaUnPresupuesto($iddireccion)=="si")
// {
//     $Go = TRUE;
//  }else
//  {     $Go = FALSE;
   
// //     $sql3="UPDATE viaticos SET estatus=8 WHERE IdViatico='".$IdViatico."'";
// //     echo $sql3;

// //     if ($conexion->query($sql3) == TRUE) {
//       //  Toast("No Esta dado de alta un presupuesto para esa direccion ",5,"");
//       echo "
//                                                         <script>
//                                                         Swal.fire({
//                                                             icon: 'error',
//                                                             title: 'ERROR',
//                                                             text: 'No Esta dado de alta un presupuesto para esa direccion ',
//                                                             timer: 1500,
//                                                             footer: '<a>Verifique los datos y vuelva a intentarlo</a>'
//                                                         });
//                                                         </script>
//                                                         ";
//         return;
// //        // echo "No Existe Presupuesto ";
// //     }

//  }


// // //8.- Se valida que exista un presupuesto para crear el viatico
 //$iddireccion=quienEsmiDireccion(nitavu_dpto($NEmpleado));


// $presupuestodispible=ExistePresupuestoViatico($iddireccion);
// $Total= totalGastosFull($IdViatico);
// echo $Total;
// //echo $presupuestodispible;
// if($Total<$presupuestodispible)
// {
//     $Go = TRUE;
// }else
// {     $Go = FALSE;
   
//     $sql3="UPDATE viaticos SET estatus=8 WHERE IdViatico='".$IdViatico."'";
//     echo $sql3;

//     if ($conexion->query($sql3) == TRUE) {
//         Toast("No Existe Presupuesto ",5,"");
//         return;
//        // echo "No Existe Presupuesto ";
//     }

// }
// // //8.- Se valida que exista un recorrido para crear el viatico






//$Go = FALSE;
if ($Go == TRUE) {
    if ($FechaSalida=='' OR $FechaRegreso ==''){
       // Toast("ERROR, debes seleccionar una Fecha de Salida y Regreso",5,"");

       echo "
       <script>
       Swal.fire({
           icon: 'error',
           title: 'ERROR',
           text: 'Debes seleccionar una Fecha de Salida y Regreso ',
           timer: 1500,
           footer: '<a>Verifique los datos y vuelva a intentarlo</a>'
       });
       </script>
       ";
    } else {
        if (viaticos_Valida($IdViatico,$NEmpleado) == TRUE){
                $FechaRegreso_anterior = viaticos_RegresoFecha($IdViatico);                
                $FechaSalida_anterior = viaticos_SalidaFecha($IdViatico);



                if ( EstoyenDelegacion($nitavu) =='del' and $nivel==1){
                    $Status=10;
                 
                }
                //else{
                //     $Status=1;
                // }
                
                  // IdHospedaje='".$IdHospedaje."',
                $sql="UPDATE viaticos SET
                NOficio='".$NOficio."',
                SalidaFecha='".$FechaSalida."',
                SalidaHora='".$HoraSalida."',
                RegresoFecha='".$FechaRegreso."',
                RegresoHora='".$HoraRegreso."',
              
                Comision ='".$Comision."',
                TipoTransporte = '".$TipoTransporte."',
                Particular_Marca = '".$Particular_Marca."',
                Particular_Placas = '".$Particular_Placas."',
                Particular_Modelo = '".$Particular_Modelo."',
                Particular_Tipo = '".$Particular_Tipo."',
                Particular_Cilindros = '".$Particular_Cilindros."',
                IdVehiculoOficial = '".$IdVehiculoOficial."',
                Veh_Transporte = '".$Veh_Transporte."',
                Veh_TransporteGasto = '".$Veh_TransporteGasto."',
                IdTipoTransporte = '".$IdTipoTransporte."',


                TipoTransporteR = '".$TipoTransporteR."',
                Particular_MarcaR = '".$Particular_MarcaR."',
                Particular_PlacasR = '".$Particular_PlacasR."',
                Particular_ModeloR = '".$Particular_ModeloR."',
                Particular_TipoR = '".$Particular_TipoR."',
                Particular_CilindrosR = '".$Particular_CilindrosR."',
                IdVehiculoOficialR = '".$IdVehiculoOficialR."',
                Veh_TransporteR = '".$Veh_TransporteR."',
                Veh_TransporteGastoR = '".$Veh_TransporteGastoR."',
                IdTipoTransporteR = '".$IdTipoTransporteR."',
                JefeInmediato='".$JefeInmediato."',
                estatus='".$Status."',
                Recorrido_Excedente='".$RecorridoExcedente."'
                WHERE IdViatico='".$IdViatico."'
                ";
                   // Activa='".$Status."',
               // echo $sql;
               //IdHospedaje=".$IdHospedaje.",
                $txt_act="NOficio=".$NOficio.", SalidaFecha=".$FechaSalida.", SalidaHora=".$HoraSalida.", RegresoFecha=".$FechaRegreso.", RegresoHora=".$HoraRegreso.", Comision=".$Comision;

                //echo $sql;

           
            if ($conexion->query($sql) == TRUE) {    
                echo "<script> CrearGastos();</script>";       

               if($Status==1)
               {

                $sql2="INSERT INTO viaticosseguimiento(IdViatico,IdSegViatico,IdEstatus,FechaCrea,NitavuCrea,Observaciones)VALUES($IdViatico,2,$Status,NOW(),$nitavu,'')";
               
                if ($conexion->query($sql2) == TRUE) {

                    echo "exito";
                   // Toast("Se guardo correctamente el Viatico ".$IdViatico,4,"");
                   echo "
                   <script>
                   Swal.fire({
                       icon: 'success',
                       title: 'EXITO',
                       text: 'Se guardo correctamente el Viatico ',
                       timer: 1500,
                       footer: ''
                   });
                   </script>
                   ";
                    historia($nitavu,"Actualizo el Viatico con IdViatico=".$IdViatico." del empleado con No=".$NEmpleado.",".$txt_act);               
                    unset($r, $sql);    
                
                    //if ($FechaSalida_anterior <> $FechaSalida OR $FechaRegreso_anterior <> $FechaRegreso){
                      
                        echo "<script> CrearGastos();</script>";
                       // ECHO "ENTRO A  GASTOS";
    
                   // }
                }

            }
                
            

            }
            else {
                return  FALSE;
                NotificaError("Error al Guardar viaticos ".$sql, "Error en viaticos");
            }
            
            

        } else {
        //     $FechaRegreso_anterior = viaticos_RegresoFecha($IdViatico);                
        //     $FechaSalida_anterior = viaticos_SalidaFecha($IdViatico);         
        //     $txt_act="NOficio=".$NOficio.", SalidaFecha=".$FechaSalida.", SalidaHora=".$HoraSalida.", RegresoFecha=".$FechaRegreso.", RegresoHora=".$HoraRegreso.", IdHospedaje=".$IdHospedaje.", Comision=".$Comision;

        //     $IdViatico = NIdViatico(FALSE);
        //     $sql="INSERT INTO  viaticos (IdViatico,NEmpleado,CapturaNitavu,CapturaFecha, NOficio,SalidaFecha,SalidaHora,RegresoFecha,RegresoHora,IdHospedaje,Comision,
        //     TipoTransporte,Particular_Marca,Particular_Placas,Particular_Modelo,Particular_Tipo,Particular_Cilindros,IdVehiculoOficial,Veh_Transporte,Veh_TransporteGasto,Activa)
        //     values('$IdViatico','$NEmpleado','$nitavu',now(),'$NOficio','$FechaSalida','$HoraSalida','$FechaRegreso','$HoraRegreso','$IdHospedaje','$Comision','$TipoTransporte','$Particular_Marca','$Particular_Placas',
        //     '$Particular_Modelo','$Particular_Tipo','$Particular_Cilindros','$IdVehiculoOficial','$Veh_Transporte','$Veh_TransporteGasto','$Status')";
        //      echo $sql;

        // $r = $conexion -> query($sql);
        // if ($conexion->query($sql) == TRUE) {
        //     Toast("Se guardo correctamente el Viatico ".$IdViatico,4,"");
        //     historia($nitavu,"Actualizo el Viatico con IdViatico=".$IdViatico." del empleado con No=".$NEmpleado.",".$txt_act);
        // }




            //Toast("Viatico no Valido",2,"");
        }
    }
}
?>
<script> viaticosResumen();</script>

