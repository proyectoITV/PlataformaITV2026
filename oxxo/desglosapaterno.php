<?php 
    $cont1 = $_GET["referencia1"];
    $cont2 = $_GET["referencia2"];

    include "lib/variables.php";
    $ch = curl_init();
    $peticion="http://".$nomservidor."/".$nomwebservice."?method=GET&token=".$token."&sql=select%20*%20from%20Vivienda_Ws_PagosOXXO%20where%20numcontrato=%27".$cont1."%27%20or%20numcontrato%20=%20%27".$cont2."%27";
    $array_options = array(CURLOPT_URL=>$peticion, CURLOPT_RETURNTRANSFER=>true,   );
    curl_setopt_array($ch,$array_options);
    $resp = curl_exec($ch);
    $final_decoded_data = json_decode($resp,true);
    if(is_array($final_decoded_data)){
        $ControlUno = 1;
        foreach ($final_decoded_data as $value) {
            if (empty($value['NumMov'])==0){
                if ($ControlUno == 1) {
                    echo $value['Paterno'];
                    $ControlUno = $ControlUno + 1;
                }
                else {
                    echo "";
                    $ControlUno = $ControlUno + 1;
                }
            }
            else {
                echo "NOLOCALIZADO";
            }
        }
    }
    else {
        echo "NOCONEXION";
    }
    curl_close($ch);
?>