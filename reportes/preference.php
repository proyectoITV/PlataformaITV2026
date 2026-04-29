<?php
// ██████╗ ██████╗ ███████╗███████╗███████╗██████╗ ███████╗███╗   ██╗ ██████╗███████╗
// ██╔══██╗██╔══██╗██╔════╝██╔════╝██╔════╝██╔══██╗██╔════╝████╗  ██║██╔════╝██╔════╝
// ██████╔╝██████╔╝█████╗  █████╗  █████╗  ██████╔╝█████╗  ██╔██╗ ██║██║     █████╗  
// ██╔═══╝ ██╔══██╗██╔══╝  ██╔══╝  ██╔══╝  ██╔══██╗██╔══╝  ██║╚██╗██║██║     ██╔══╝  
// ██║     ██║  ██║███████╗██║     ███████╗██║  ██║███████╗██║ ╚████║╚██████╗███████╗
// ╚═╝     ╚═╝  ╚═╝╚══════╝╚═╝     ╚══════╝╚═╝  ╚═╝╚══════╝╚═╝  ╚═══╝ ╚═════╝╚══════╝
//            A d m i n i s t r a d o r    d  e   P r e f e r e n c i a  s
//                      by JPedraza | printepolis@gmail.com
// 
// Utilize GroupA y B para orgnizar caracteristicas
// especiales agrupadas
//
// 
//----------------------------------------------


//Conección a la base datos, se requite tabla preferences:

//DDL:
// CREATE TABLE `preferences` (
//     `Preference` varchar(200) NOT NULL,
//     `Value` varchar(255) NOT NULL,
//     `GroupA` varchar(255) NOT NULL COMMENT 'Agrupacion para organizar 1',
//     `GroupB` varchar(255) NOT NULL COMMENT 'Agrupacion para organizar 2',
//     PRIMARY KEY (`Preference`)
//   ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;



function Preference($Preference, $GroupA, $GroupB){  
    require("preference_config.php");    
    $sql = "select Value from preferences 
    WHERE Preference ='".$Preference."' and GroupA='".$GroupA."' and GroupB='".$GroupA."'";    
    $rP= $dbP -> query($sql);
    if($fP = $rP -> fetch_array())
    {
        return $fP['Value'];
    } else {
        return 'NoR';
        //NoR = No Registrada
    }
}

function PreferenceNew($Preference, $GroupA, $GroupB){  
    require("preference_config.php");    
    $sql = "INSERT INTO preferences 
    (Preference, GroupA, GroupB) 
    VALUES ('".$Preference."', '".$GroupA."', '".$GroupB."')";
    if ($dbP->query($sql) == TRUE)
    {return TRUE;}
    else {return FALSE;}

}


function PreferenceDelete($Preference, $GroupA, $GroupB){  
    require("preference_config.php");    
    $sql = "DELETE preferences 
    WHERE Preference ='".$Preference."' and GroupA='".$GroupA."' and GroupB='".$GroupA."'";    
    if ($dbP->query($sql) == TRUE)
    {return TRUE;}
    else {return FALSE;}

}

function PreferenceEdit($Preference, $GroupA, $GroupB, $Value){  
    require("preference_config.php");    
    $sql = "UPDATE preferences 
    SET Value='".$Value."'
    WHERE Preference ='".$Preference."' and GroupA='".$GroupA."' and GroupB='".$GroupA."'";    
    echo $sql;
    if ($dbP->query($sql) == TRUE)
    {return TRUE;}
    else {return FALSE;}

}
?>