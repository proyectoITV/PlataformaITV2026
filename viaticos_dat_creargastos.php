<?php
require("config.php");
require("seguridad.php");
require("var_clean.php");
require("lib/funciones.php");
require("viaticos_fun.php");
// require_once("lib/flor_funciones.php");

$IdViatico = VarClean($_POST['IdViatico']);
$CapSalidaFecha = VarClean($_POST['FechaSalida']);
$CapRegresoFecha = VarClean($_POST['FechaRegreso']);
$NEmpleado = viaticos_NEmpleado($IdViatico);

$SalidaFecha = viaticos_SalidaFecha($IdViatico);
$SalidaHora = viaticos_SalidaHora($IdViatico);
$RegresoFecha = viaticos_RegresoFecha($IdViatico);
$RegresoHora = viaticos_RegresoHora($IdViatico);

$msgE = ""; //Validaciones:
if ($SalidaFecha == '') {$msgE.= "Fecha de Salida,";}
if ($SalidaHora == '') {$msgE.= "Hora deSalida,";}
if ($RegresoFecha == '') {$msgE.= "Fecha de Regreso,";}
if ($RegresoHora == '') {$msgE.= "Hora de Regreso,";}
if ($SalidaFecha <> $CapSalidaFecha) {$msgE.= "La fecha de Salida aun no se guarda, hagalo antes.";}
if ($RegresoFecha <> $CapRegresoFecha) {$msgE.= "La fecha de Regreso todavia no se guarda, hagalo antes.";}




if ($msgE == ''){
    if (viaticos_GastosReset($IdViatico) ==TRUE){
        Toast("Se ha limpiado la tabla de gastos",0,"");
    } else {
        Toast("Error al limpiar la tabla de gastos",2,"");
    }
   

    $NDias = viaticos_NDias($IdViatico); // Numero de dias calculado por las fechas
    $NDias2=viaticosrecorridosNdias($IdViatico); // Numero de dias ingresados por el usuario

//      if( ((int)$NDias<( (int)$NDias2) ) and $NDias>1 )
//  {
//     echo "
//                    <script>
//                    Swal.fire({
//                        icon: 'Error',
//                        title: 'Error',
//                        text: 'Favor de verificar los días , No corresponde a los días calculados por el sistema. ',
//                        timer: 1500,
//                        footer: ''
//                    });
//                    </script>
//                    ";
//                    return;
// }





// $fecha_actual = date("d-m-Y");

    $SigFecha = $SalidaFecha;
    $EmpleadoNivel = nitavu_nivel($NEmpleado);
    // echo "Nivel ".$EmpleadoNivel;


    $noNoches= viaticos_NoNoches($IdViatico);


       $j=0;
    for ($i = 1; $i <= $NDias; $i++) {

        // $Almuerzo = viaticos_IdAlmuerzo($EmpleadoNivel);
        // $Comida = viaticos_IdComida($EmpleadoNivel);
        // $Cena = viaticos_IdCena($EmpleadoNivel);
        // $IdHospedaje = viaticos_IdHospedaje($IdViatico);

              
        $destinos = destinos_donde_dormira($IdViatico);
      //  echo var_dump($destinos);

        $Hora_Inicial = strtotime($SalidaHora);
        $hora_i = date('H:i:s',$Hora_Inicial);

        $Hora_Final = strtotime($RegresoHora);
        $hora_f = date('H:i:s',$Hora_Final);

        //almuerzo  iniciio
        $Horario_ini_1  = strtotime( "00:00:00" );
        $hora_i1 = date('H:i:s',$Horario_ini_1);

        //almuerzo  fin
        $Horario_fin_1  =  strtotime( "12:00:00" );
        $hora_f1 = date('H:i:s',$Horario_fin_1);

        //comida
        $Horario_ini_2  = strtotime( "12:01:00" );
        $hora_i2 = date('H:i:s',$Horario_ini_2);

        //comida  fin
        $Horario_fin_2  =strtotime( "17:00:00" );
        $hora_f2 = date('H:i:s',$Horario_fin_2);

        //cena
        $Horario_ini_3  =  strtotime( "17:01:00" );
        $hora_i3 = date('H:i:s',$Horario_ini_3); 

         //comida  fin
         $Horario_fin_3  = strtotime( "23:59:59" ); 
         $hora_f3 = date('H:i:s',$Horario_fin_3);



         //echo $SigFecha;
        if($SalidaFecha==$SigFecha)
        {
           
            
            if((( $hora_i<=$hora_f1)))
            {
                $Almuerzo = viaticos_IdAlmuerzo($EmpleadoNivel);            
                //echo "Aplica almuerzo";
            }
            else{
                //echo "No aplica almuerzo";
                $Almuerzo=0;;
            }
          
            if(( $hora_i<=$hora_f2))
            {
                $Comida = viaticos_IdComida($EmpleadoNivel);
                //echo "Aplica comida";
            }
            else{
                //echo "No aplica comida";
                $Comida = 0;
            }
           
            if(( $hora_i<=$hora_f3))
            {
                $Cena = viaticos_IdCena($EmpleadoNivel);
                //$IdHospedaje = viaticos_IdHospedaje($IdViatico) ;// se comenta para nuevo calculo;
                $IdHospedaje=viaticos_IdHospedajeDestino($EmpleadoNivel,$destinos[$j]);// nuevo
               // echo "Aplica cena";
            }
            else{
                $Cena =0;
                $IdHospedaje =0;    
               // echo "entro1";           
            }
        }

        if($SalidaFecha!=$SigFecha and $RegresoFecha>$SigFecha)
        {

            // echo "Aplica almuerzo";
            // echo "Aplica comida";
            // echo "Aplica cena";
            $Almuerzo = viaticos_IdAlmuerzo($EmpleadoNivel);
            $Comida = viaticos_IdComida($EmpleadoNivel);
            $Cena = viaticos_IdCena($EmpleadoNivel);            
          //  $IdHospedaje = viaticos_IdHospedaje($IdViatico); // se comenta para nuevo calculo;
            $IdHospedaje=viaticos_IdHospedajeDestino($EmpleadoNivel,$destinos[$j]);// nuevo
           // echo "entro2";  
        }

        //***** R E G R E S O  ********/
        if($RegresoFecha==$SigFecha)
          {

                if((($hora_f>= $hora_f1)))
                {
                    $Almuerzo = viaticos_IdAlmuerzo($EmpleadoNivel);              
                }
                else{                 
                    $Almuerzo=0;;
                }
                
                if((  $hora_f>=$hora_i2))
                {
                    $Comida = viaticos_IdComida($EmpleadoNivel);                  
                    
                }
                else
                {
                     $Comida = 0;    
                }

                if(( $hora_f>=$hora_i3   ))
                {
                    $Cena = viaticos_IdCena($EmpleadoNivel);
                    $IdHospedaje =0;                
                    
                }
                else{
                    $Cena =0;
                    $IdHospedaje =0;
                    echo "entro3";  
                }

                //echo "<br>"."hospedaje===".$IdHospedaje."===".$destinos[$j]."<br>";
              
        
              //  echo "entro4";
        }
 
     echo "<br>"."hospedaje===".$IdHospedaje."<br>";

        if (viaticosGastosIn($IdViatico, $SigFecha, $nitavu, $Almuerzo, $Comida, $Cena, $IdHospedaje)==TRUE){
            Toast("Se registro la fecha ".$SigFecha." correctamente en el Viatico ".$IdViatico,4,"");
        } else {
            Toast("Error al registrar la fecha ".$SigFecha."  en el Viatico ".$IdViatico,2,"");
        }
       
        if ($j<sizeof($destinos)-1)
        {
            $j=$j+1;
            //"entro";
        }
   
//     }
// }



        $SigFecha = date("Y-m-d",strtotime($SigFecha."+ 1 days")); 
    
        
    }
    echo "<script>ReloadGastos();</script>";




    

} else {
    Toast("ERROR, tal vez captura: ".$msgE,5,"");
}

//Validar que tegna Fecha de Regreso y Salida


?>