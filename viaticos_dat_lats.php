<?php
require("config.php");
require("seguridad.php");
require("var_clean.php");
require("lib/funciones.php");
require("viaticos_fun.php");
// require_once("lib/flor_funciones.php");

$addressFrom = VarClean($_POST['Origen']);
$addressTo = VarClean($_POST['Destino']);
$IdViatico = VarClean($_POST['IdViatico']);
$Distancia = VarClean($_POST['Distancia']);
$RecorridoInterno = VarClean($_POST['RecorridoInterno']);
$viajeredondo = VarClean($_POST['viajeredondo']);
$id = VarClean($_POST['id']);
//$IdViatico = NIdViatico(TRUE);


// echo "Origen: ".$addressFrom.", Destino: ".$addressTo;
if ($addressFrom<>'' || $addressTo <>''){
    if ($ServiciosGoogle==TRUE){
    $OrigenLat = getOrigenLat($addressFrom, $addressTo, "K");
    $OrigenLon = getOrigenLon($addressFrom, $addressTo, "K");
    $DestinoLat = getDestinoLat($addressFrom, $addressTo, "K");
    $DestinoLon = getDestinoLon($addressFrom, $addressTo, "K");
    } else {
        $OrigenLat = 0;
        $OrigenLon = 0;
        $DestinoLat = 0;
        $DestinoLon = 0;
    }

    if ($Distancia>0){
        //******* SE INSERTA RECORRIDO DE IDA ******** */
        $sql = "INSERT INTO viaticosrecorridos(IdViatico, Origen, Destino, Origen_lat, Destino_lat, Origen_lon, Destino_lon, Distancia, RecorridoInterno, fecha,id) 
        VALUES ('".$IdViatico."',   
        '".$addressFrom."',
        '".$addressTo."',
        '".$OrigenLat."',
        '".$DestinoLat."',
        '".$OrigenLon."',
        '".$DestinoLon."',
        '".$Distancia."',    
        '".$RecorridoInterno."',  
        '".$fecha."',
        '".$id."'
        )";
    //  echo $sql;
    // echo $viajeredondo;
        $msg = "";
        if ($conexion->query($sql) == TRUE){     


            if(viaticos_NReccorridos($IdViatico)<2)
            {
                if($viajeredondo==1)
                {
                    
                    $RecorridoInterno=0;          
                    //******* SE INSERTA RECORRIDO DE VUELTA ******** */
                    $sql2 = "INSERT INTO viaticosrecorridos(IdViatico, Origen, Destino, Origen_lat, Destino_lat, Origen_lon, Destino_lon, Distancia, RecorridoInterno, fecha,id) 
                    VALUES ('".$IdViatico."',    
                    '".$addressTo."',
                    '".$addressFrom."',
                    '".$OrigenLat."',
                    '".$DestinoLat."',
                    '".$OrigenLon."',
                    '".$DestinoLon."',
                    '".$Distancia."',    
                    '".$RecorridoInterno."',  
                    '".$fecha."',
                    '".$id."'
                    )";
            // echo $sql;
                $msg = "";
                    if ($conexion->query($sql2) == TRUE){  
                        
                        historia($nitavu,"[viaticos] = Registro un recorrido ".$addressFrom." a ".$addressTo." con una distancia de ".$Distancia." y un IdViatico =".$IdViatico);
                        $msg = "y se registraron";

                    }
                }
        }
    

        } else {
            $msg = ", hubo un error al registrar";
        }
    } else {
        $msg = "No se registro, por no tener la distancia";
    }




    echo "
    <script>
    $('#OrigenLat').val(".$OrigenLat.");
    $('#OrigenLon').val(".$OrigenLon.");
    $('#DestinoLat').val(".$DestinoLat.");
    $('#DestinoLon').val(".$DestinoLon.");





    </script>";


    $sql="select  * from viaticosrecorridos WHERE IdViatico='".$IdViatico."'";
    $r= $conexion -> query($sql);   
    echo "<table class='tabla'>";
    echo "<th style = 'background-color:#ddc9a3; color:black;'>Punto</th>";
    echo "<th style = 'background-color:#ddc9a3; color:black;'>Recorrido</th>";
    echo "<th style = 'background-color:#ddc9a3; color:black;'>Distancia</th>";    
    echo "<th style = 'background-color:#ddc9a3; color:black;'>Recorrido Interno</th>";   
    echo "<th style='padding: 10px; background-color:#ddc9a3; color:black;'>#Dias</th>";      
    echo "<th style='padding: 10px;text-align: center; background-color:#ddc9a3; color:black;'>¿Dormirá en el lugar?</th>";
    echo "<th style = 'background-color:#ddc9a3; color:black; padding: 10px;text-align: center;'>¿Pagar combustible?</th>";
    echo "<th style = 'background-color:#ddc9a3; color:black;'>Acción</th>";
    
    $Lin = 1;
    $kms = 0;
    $checked="";
    $checked1="";
    $numrecorridos=viaticos_NReccorridos($IdViatico);
    while($V = $r -> fetch_array())
    {
        if($V['duerme_en_lugar']=="1")
    {
        $checked="checked";
    }else{$checked="";}
     
    if($V['pagarcombustible']=="1")
    {
        $checked1="checked";
    }else{
        $checked1="";
    }
    
        echo "<tr>";
        echo "<td><b title='IdRecorrido=".$V['IdRecorrido']."'>".$Lin."</b></td>";
        echo "<td><b title='IdRecorrido=".$V['IdRecorrido']."'>".$V['Origen']." ~ ".$V['Destino']."</b></td>";
        echo "<td>".$V['Distancia']." km</td>";   
        echo "<td>".$V['RecorridoInterno']." km</td>";   
        if($numrecorridos!=$Lin)
        {
            echo "<td width=10 align=center> <input  style='text-align: center;' type='text' id='dias".$V['IdRecorrido']."' name='dias".$V['IdRecorrido']."' onkeyup='CalculoxDias(".$V['IdRecorrido'].")' value='".$V['dias']."'>  </td>";
            echo "<td width=100 align=center> <input style='text-align: center;' type='checkbox' id='check".$V['IdRecorrido']."' name='check".$V['IdRecorrido']."' onclick='duermeLugar(".$V['IdRecorrido'].")' ". $checked. "> Si </td>";    
          
        }else{
            echo "<td width=10 align=center> 1 </td>";
            echo "<td width=100 align=center>  </td>";    
          
        }
        echo "<td width=100 align=center> <input style='text-align: center;' type='checkbox' id='checkCombustible".$V['IdRecorrido']."' name='checkCombustible".$V['IdRecorrido']."'  onclick='pagarcombustible(".$V['IdRecorrido'].")' ". $checked1. "> Si </td>";  
        echo "<td width=50 align=right><button onclick='del(".$V['IdRecorrido'].");' class='btn btn-danger'>X</button></td>";
        
        echo "</tr>";
        $kms = $kms + floatval($V['Distancia']+floatval($V['RecorridoInterno']));
        $Lin = $Lin + 1;
    }
    echo "<tr style='background-color:orange;'>";
    echo "<td></td>";
    echo "<td align=right>TOTAL</td>";
    echo "<td align=left>".$kms." km</td>";    

    echo "<td width=50 align=right></td>";
   
    echo "</tr>";

    echo "</table>";
    echo "<script>$('#KilometrosTotal').val(".$kms.");</script>";
    unset($sql, $V, $r);
    // TablaDinamica_MySQL("",$sql, "RecorridosDiv", "RecorridosTable", "", 2); //0 = Basica, 1 = ScrollVertical, 2 = Scroll Horizontal
    
   // Toast("Se calcularon las coordenas ".$msg,1,"");
} else {
  //  Toast("Primero escriba un lugar de origen y destino",1,"");

  echo "
  <script>
  Swal.fire({
      icon: 'error',
      title: 'ERROR',
      text: 'Primero escriba un lugar de origen y destino',
      timer: 1500,
      footer: '<a>Verifique los datos y vuelva a intentarlo</a>'
  });
  </script>  ";
}

?>