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



function PreferenceDb(){
    static $dbPConn = null;
    if ($dbPConn === null){
        require("preference_config.php");
        $dbPConn = $dbP;
    }
    return $dbPConn;
}

function Preference($Preference, $GroupA, $GroupB){
    global $PreferenceCache;
    if (!isset($PreferenceCache)){
        $PreferenceCache = array();
    }
    $cacheKey = $Preference."|".$GroupA."|".$GroupB;
    if (array_key_exists($cacheKey, $PreferenceCache)){
        return $PreferenceCache[$cacheKey];
    }

    $dbP = PreferenceDb();
    $sql = "select Value from preferences 
    WHERE Preference ='".$Preference."' and GroupA='".$GroupA."' and GroupB='".$GroupB."'";
    $rP = $dbP -> query($sql);
    if($rP && ($fP = $rP -> fetch_array()))
    {
        $PreferenceCache[$cacheKey] = $fP['Value'];
        return $fP['Value'];
    }

    $PreferenceCache[$cacheKey] = 'NoR';
    return 'NoR';
    //NoR = No Registrada
}

function PreferenceNew($Preference, $GroupA, $GroupB, $Value){
    global $PreferenceCache;
    $dbP = PreferenceDb();
    $sql = "INSERT INTO preferences 
    (Preference, GroupA, GroupB, Value) 
    VALUES ('".$Preference."', '".$GroupA."', '".$GroupB."','".$Value."')";
    // echo $sql;
    if ($dbP->query($sql) == TRUE)
    {
        $PreferenceCache[$Preference."|".$GroupA."|".$GroupB] = $Value;
        return TRUE;
    }
    else {return FALSE;}

}


function PreferenceDelete($Preference, $GroupA, $GroupB){
    global $PreferenceCache;
    $dbP = PreferenceDb();
    $sql = "DELETE preferences 
    WHERE Preference ='".$Preference."' and GroupA='".$GroupA."' and GroupB='".$GroupB."'";    
    if ($dbP->query($sql) == TRUE)
    {
        unset($PreferenceCache[$Preference."|".$GroupA."|".$GroupB]);
        return TRUE;
    }
    else {return FALSE;}

}

function PreferenceEdit($Preference, $GroupA, $GroupB, $Value){
    global $PreferenceCache;
    $dbP = PreferenceDb();
    $sql = "UPDATE preferences 
    SET Value='".$Value."'
    WHERE Preference ='".$Preference."' and GroupA='".$GroupA."' and GroupB='".$GroupB."'";    
    // echo $sql;
    if ($dbP->query($sql) == TRUE)
    {
        $PreferenceCache[$Preference."|".$GroupA."|".$GroupB] = $Value;
        return TRUE;
    }
    else {return FALSE;}

}

function PreferenceUpdate($Preference, $GroupA, $GroupB, $Value){
    if (Preference($Preference, $GroupA, $GroupB) == 'NoR'){
        return PreferenceNew($Preference, $GroupA, $GroupB,$Value);
    } else {
        return PreferenceEdit($Preference, $GroupA, $GroupB, $Value);
    }
}
?>