<?php
require("config.php");
require("seguridad.php");
require("var_clean.php");
require("lib/funciones.php");
require("viaticos_fun.php");
// require_once("lib/flor_funciones.php");


$IdViatico = VarClean($_POST['IdViatico']);
$VehMode = VarClean($_POST['VehModeR']);
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



       
        echo '<input value="'.$Viatico['IdVehiculoOficialR'].'" style="font-size:8pt; width:300px"   onkeydown="vaciarDescripcionR();" list="opciones" id="IdVehiculoOficialR" name="IdVehiculoOficialR" placeholder="Selecciona una opción" onchange="cambioOpcionesR()">
        <datalist id="opciones">';
        while($f = $r -> fetch_array()) {
      echo "<option style='font-size:8pt; ' value='".$f['Placas']."'>".$f['Placas']."  Marca ".$f['Marca']." ".$f['Tipo'] ."</option>";
      
        }echo'</datalist>';      

      echo "<label style='font-family:Compacta;' id='lblVehiculoOficialR'></label><br>";

      if($Viatico['IdVehiculoOficialR']!='')
{
    echo "<script> cambioOpcionesR();</script>";
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
            FormElement_input("Marca:", "", $Viatico['Particular_MarcaR'], "", "text", "Veh_MarcaR");
            FormElement_input("Placas:", "", $Viatico['Particular_PlacasR'], "", "text", "Veh_PlacasR");
            FormElement_input("Modelo:", "", $Viatico['Particular_ModeloR'], "", "text", "Veh_ModeloR");
            FormElement_input("Tipo:", "", $Viatico['Particular_TipoR'], "", "text", "Veh_TipoR");
            FormElement_input("Cilindraje:", "No. de Cilindros", $Viatico['Particular_CilindrosR'], "", "number", "Veh_CilindrosR");


        } else {
            if($VehMode == 3){ //Trnstporte Publico
                
                FormElement_input("Transporte:", "", $Viatico['Veh_TransporteR'], "Autobus, taxi..", "text", "Veh_TrasporteR");
                FormElement_input("Gasto por Transporte:", "", $Viatico['Veh_TransporteGastoR'], "Costo de pasajes...", "number", "Veh_TrasporteGastoR");

            } else {
                Toast("Seleccione un Tipo de Vehiculo",2,"");
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

