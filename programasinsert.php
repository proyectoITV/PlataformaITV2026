<?php    
    require_once("config.php");
    
    $idprograma=$_POST['idprograma'];
    $usuario=$_POST['usuario'];
    $areaap=$_POST['areaap'];
    $arraytabla = $_POST['arrayFinal'];
    
   // $tipoprog= $_POST['tipoprog'];
    //echo $usuario;
    var_dump($arraytabla);  
   
 /*   for($e=0;$e<sizeof($array);$e++){
       /* for($i=0;$i<sizeof($e);$i++){
            $idconcepto=$array[$i];
        }*/
        /*echo 'pos'.$array[$e].'<br>';
    }*/

    $array = json_decode($arraytabla, true);    
    foreach ($array as $value) {   
        //$idconcepto = $value['id'];."<br>";

        //echo "item: ".$value['item']."<br>";
        //echo "precio: ".$value['precio']."<br>";
        //echo "idconcepto: ".$value['idConcepto']."<br>";

        $idconcepto = $value['idConcepto'];
        $idtipoconcepto=$value['idTipoConcepto'];
        $monto= $value['precio'];
        $listapaquetes=$value['paqs'];
       // $idempleado=$nitavu;
        $sql="";
        $sql="INSERT INTO programaconfig (IdPrograma,IdConcepto,IdTipoCuenta,Monto,Cancelado,IdempCrea,FechaCaptura,ListaIdPaqueteMat,AreaAplicacion) VALUES(".$idprograma.",".$idconcepto.","
        .$idtipoconcepto.",".$monto.",0,".$usuario.",'".$fecha."','".$listapaquetes."','".$areaap."')";
     //   echo $sql;
        $resultado2 = $Vivienda -> query($sql);    
    }
    
    //echo 'concepto'.$idconcepto;


?>