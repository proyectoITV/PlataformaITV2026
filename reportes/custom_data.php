<?php
require ("rintera-config.php");
require ("components.php");
// include("seguridad.php");   
echo "=>". $_POST['Token']."|";


$ElToken = VarClean($_POST['Token']);
if (    isset($_POST['IdUser'])
    &&  isset($_POST['IdCon'])
    &&  isset($_POST['Active'])
    &&  isset($_POST['ConName'])
){
    $IdUser = VarClean($_POST['IdUser']);
    $IdCon = VarClean($_POST['IdCon']);
    $Active = VarClean($_POST['Active']);
    $ConName = VarClean($_POST['ConName']);

    if (isset($_POST['dbhost'])){$dbhost = VarClean($_POST['dbhost']);} else {$dbhost="";}
    if (isset($_POST['dbuser'])){$dbuser = VarClean($_POST['dbuser']);} else {$dbuser="";}
    if (isset($_POST['dbname'])){$dbname = VarClean($_POST['dbname']);} else {$dbname="";}
    if (isset($_POST['dbpassword'])){$dbpassword = VarClean($_POST['dbpassword']);} else {$dbpassword = "";}


    if (isset($_POST['wsmethod'])){$wsmethod = VarClean($_POST['wsmethod']);} else {$wsmethod="";}    
    if (isset($_POST['wsurl'])){$wsurl = VarClean($_POST['wsurl']);} else {$wsurl="";}           

    if (isset($_POST['wsP1_id'])){$wsP1_id = VarClean($_POST['wsP1_id']);} else {$wsP1_id="";}           
    if (isset($_POST['wsP1_value'])){$wsP1_value = VarClean($_POST['wsP1_value']);} else {$wsP1_value="";}           

    if (isset($_POST['wsP2_id'])){$wsP2_id = VarClean($_POST['wsP2_id']);} else {$wsP2_id="";}           
    if (isset($_POST['wsP2_value'])){$wsP2_value = VarClean($_POST['wsP2_value']);} else {$wsP2_value="";}           

    if (isset($_POST['wsP3_id'])){$wsP3_id = VarClean($_POST['wsP3_id']);} else {$wsP3_id="";}           
    if (isset($_POST['wsP3_value'])){$wsP3_value = VarClean($_POST['wsP3_value']);} else {$wsP3_value="";}           

    if (isset($_POST['wsP4_id'])){$wsP4_id = VarClean($_POST['wsP4_id']);} else {$wsP4_id="";}           
    if (isset($_POST['wsP4_value'])){$wsP4_value = VarClean($_POST['wsP4_value']);} else {$wsP4_value="";}           



    if (MiToken_valida($ElToken, $IdUser, "custom")==TRUE) { //Token Valido
        $sql="UPDATE dbs  SET 
            ConName='".$ConName."', 
            Active='".$Active."', 
            dbhost='".$dbhost."',
            dbuser='".$dbuser."',
            dbname='".$dbname."',
            dbpassword='".$dbpassword."',
            wsmethod='".$wsmethod."',
            wsurl='".$wsurl."',
            wsP1_id='".$wsP1_id."',
            wsP1_value='".$wsP1_value."',

            wsP2_id='".$wsP2_id."',
            wsP2_value='".$wsP2_value."',

            wsP3_id='".$wsP3_id."',
            wsP3_value='".$wsP3_value."',

            wsP4_id='".$wsP4_id."',
            wsP4_value='".$wsP4_value."'

            

            WHERE IdCon='".$IdCon."'";    
            if ($db0->query($sql) == TRUE)
            {
                Toast("Se actualizo correctamente",1,"");
                // echo "ConType = ".ConType($IdCon);
                if (ConType($IdCon)<=1){
                    TestConectionDB($IdCon);
                }

                if (ConType($IdCon)<=2){
                    TestConectionWS($IdCon);
                }
                historia_rintera($IdUser, "CONECCIONES", "Actualizo la coneccion: ".$IdCon." - ".$ConName."[SQL=".$sql."]");
            }
            else {
                Toast("ERROR al Actualizar ",3,"");
            
            }
        } else {
            echo "Token Invalido";
        }
}  else {
    echo "Parametros incorrectos";
}
?>