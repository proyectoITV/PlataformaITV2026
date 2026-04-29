<?php
require("config.php");
require("seguridad.php");
require("var_clean.php");
require("lib/funciones.php");
require("viaticos_fun.php");
// require_once("lib/flor_funciones.php");


$IdViatico = VarClean($_POST['IdViatico']);
$VehMode = VarClean($_POST['VehMode']);
$sqlV = "select * from viaticos WHERE IdViatico='".$IdViatico."'";	
// echo $sqlV;
$rV= $conexion -> query($sqlV);					
if($Viatico = $rV -> fetch_array())
{
    
    // if ($Viatico['TipoTransporte']=='PARTICULAR'){$VehMode=2;};
    // if ($Viatico['TipoTransporte']=='OFICIAL'){$VehMode=1;};
    // if ($Viatico['TipoTransporte']=='PUBLICO'){$VehMode=3;};

    if ($VehMode==1){ //Oficial
        $sql = "select * from vehiculos_ WHERE IdEstatus=0 order by Placas DESC";
        //echo $sql;
        $r= $conexion -> query($sql);  
        echo "<label style='font-family:Compacta;' ><i class='fa-solid fa-car-side'></i><b>  Listado de vehículos oficiales</b></label><br>";



       
        echo '<input value="'.$Viatico['IdVehiculoOficial'].'" style="font-size:8pt; width:300px"   onkeydown="vaciarDescripcion();" list="opciones" id="IdVehiculoOficial" name="IdVehiculoOficial" placeholder="Selecciona una opción" onchange="cambioOpciones()">';
     
        echo '<datalist id="opciones">';
        while($f = $r -> fetch_array()) {       

      if ($f['Cilindros']==0){
                    echo "<option title='Falta capturar los Cilindros' style=' font-size:8pt; background-color:rgb(249, 202, 202);' value='".$f['Placas']."'>".$f['Placas']."  Marca ".$f['Marca']." ".$f['Tipo'].", Cil=".$f['Cilindros']."</option>";
                    //' value='".$f['Placas']."'>".$f['Placas']."  Marca ".$f['Marca']." ".$f['Tipo'].", Núm. económico ".$f['Num_economico'].", Serie ".$f['Serie'].", Cil=".$f['Cilindros']."</option>";
                } else {
                echo "<option style='font-size:8pt;' value='".$f['Placas']."'>".$f['Placas']."  Marca ".$f['Marca']." ".$f['Tipo'].", Cil=".$f['Cilindros']."</option>";
                //' value='".$f['Placas']."'>".$f['Placas']."  Marca ".$f['Marca']." ".$f['Tipo'].", Núm. económico ".$f['Num_economico'].", Serie ".$f['Serie'].", Cil=".$f['Cilindros']."</option>";
                }
      
        }
        echo'</datalist>';      

      echo "<label style='font-family:Compacta;' id='lblVehiculoOficial'></label><br>";
           
if($Viatico['IdVehiculoOficial']!='')
{
    echo "<script> cambioOpciones();</script>";
}
    //echo "<div class='form-group'>";
        // echo "<select  id='IdVehiculoOficial' name='IdVehiculoOficial'  style='font-size:10pt;'>";
        // while($f = $r -> fetch_array()) {

      
           
        //     if ($Viatico['IdVehiculoOficial']==$f['Placas']){
        //         echo "<option style='font-size:8pt; ' value='".$f['Placas']."' selected>".$f['Placas']."  Marca ".$f['Marca']." ".$f['Tipo'] ;//."</option>";

        //         //' value='".$f['Placas']."' selected>".$f['Placas']."  Marca ".$f['Marca']." ".$f['Tipo'].", Núm. económico ".$f['Num_economico'].", Serie ".$f['Serie'].", Cil=".$f['Cilindros']."</option>";
        //     } else {
        //         if ($f['Cilindros']==0){
        //             echo "<option title='Falta capturar los Cilindros' style=' font-size:8pt; background-color:rgb(249, 202, 202);' value='".$f['Placas']."'>".$f['Placas']."  Marca ".$f['Marca']." ".$f['Tipo']."</option>";
        //             //' value='".$f['Placas']."'>".$f['Placas']."  Marca ".$f['Marca']." ".$f['Tipo'].", Núm. económico ".$f['Num_economico'].", Serie ".$f['Serie'].", Cil=".$f['Cilindros']."</option>";
        //         } else {
        //         echo "<option style='font-size:8pt;' value='".$f['Placas']."'>".$f['Placas']."  Marca ".$f['Marca']." ".$f['Tipo']."</option>";
        //         //' value='".$f['Placas']."'>".$f['Placas']."  Marca ".$f['Marca']." ".$f['Tipo'].", Núm. económico ".$f['Num_economico'].", Serie ".$f['Serie'].", Cil=".$f['Cilindros']."</option>";
        //         }
        //     }
          
        // }
        // echo "</select>";



        unset($f, $r,$sql);

    } else {
        if($VehMode == 2){ //Particular
            FormElement_input("Marca:", "", $Viatico['Particular_Marca'], "", "text", "Veh_Marca");
            FormElement_input("Placas:", "", $Viatico['Particular_Placas'], "", "text", "Veh_Placas");
            FormElement_input("Modelo:", "", $Viatico['Particular_Modelo'], "", "text", "Veh_Modelo");
            FormElement_input("Tipo:", "", $Viatico['Particular_Tipo'], "", "text", "Veh_Tipo");
            FormElement_input("Cilindraje:", "No. de Cilindros", $Viatico['Particular_Cilindros'], "", "number", "Veh_Cilindros");


        } else {
            if($VehMode == 3){ //Trnstporte Publico
                
                FormElement_input("Transporte:", "", $Viatico['Veh_Transporte'], "Autobus, taxi..", "text", "Veh_Trasporte");
                FormElement_input("Gasto por Transporte:", "", $Viatico['Veh_TransporteGasto'], "Costo de pasajes...", "number", "Veh_TrasporteGasto");

            } else {
                //Toast("Seleccione un Tipo de Vehiculo",2,"");

                echo "
                <script>
                Swal.fire({
                    icon: 'error',
                    title: 'ERROR',
                    text: 'Seleccione un Tipo de Vehiculo,
                    timer: 1500,
                    footer: '<a>Verifique los datos y vuelva a intentarlo</a>'
                });
                </script>  ";
            }
        }
    }

 }


//else{



//     if ($VehMode==1){ //Oficial
//         $sql = "select * from vehiculos_ WHERE IdEstatus=0 order by Modelo DESC";
//         $r= $conexion -> query($sql);  
//         echo "
//         <label>Seleccione un Vehiculo Oficial </label>
//         <select id='IdVehiculoOficial' class='form-control' style='font-size:10pt;'>";
//         while($f = $r -> fetch_array()) {
           
//                 if ($f['Cilindros']==0){
//                     echo "<option title='Falta capturar los Cilindros' style='
//                     font-size:8pt; background-color:rgb(249, 202, 202); 
//                     ' value='".$f['Num_economico']."'>".$f['Num_economico']."- Marca ".$f['Marca']." ".$f['Tipo']." Placas:".$f['Placas'].", Serie:".$f['Serie'].", Cil=".$f['Cilindros']."</option>";
//                 } else {
//                 echo "<option style='
//                 font-size:8pt;
//                 ' value='".$f['Num_economico']."'>".$f['Num_economico']."- Marca ".$f['Marca']." ".$f['Tipo']." Placas:".$f['Placas'].", Serie:".$f['Serie'].", Cil=".$f['Cilindros']."</option>";
//                 }
            
          
//         }
//         echo "</select>";
//         unset($f, $r,$sql);

//     } else {
//         if($VehMode == 2){ //Particular
//             FormElement_input("Marca:", "", "", "", "text", "Veh_Marca");
//             FormElement_input("Placas:", "", "", "", "text", "Veh_Placas");
//             FormElement_input("Modelo:", "", "", "", "text", "Veh_Modelo");
//             FormElement_input("Tipo:", "", "", "", "text", "Veh_Tipo");
//             FormElement_input("Cilindraje:", "No. de Cilindros", "", "", "number", "Veh_Cilindros");


//         } else {
//             if($VehMode == 3){ //Trnstporte Publico
                
//                 FormElement_input("Transporte:", "", "", "Autobus, taxi..", "text", "Veh_Trasporte");
//                 FormElement_input("Gasto por Transporte:", "", "", "Costo de pasajes...", "number", "Veh_TrasporteGasto");

//             } else {
//                 Toast("Seleccione un Tipo de Vehiculo",2,"");
//             }
//         }
//     }
// }
unset($Viatico,$rV,$sqlV);
?> 

