<?php
    require_once("config.php");
    
    
    $id=$_POST['id'];
   // echo $id;
    //mensaje('en funcion','desarrolladores.php');
    //mensaje('Registrado con éxito','programas_alta2.php?Id='.$IdPrograman);
    //$tabla=$_POST['tabla'];

    //$sql="Select * from ".$tabla."where IdDesarrollador=".$id;
    $sql="Select * from catdesarrolladores where IdDesarrollador=".$id;
    $resultado2 = $Vivienda -> query($sql);   
    //$arr=array("nombre"=>)
    //$f = $resultado2 -> fetch_array(MYSQLI_ASSOC);
    $f = $resultado2 -> fetch_assoc();
    echo json_encode($f);
    //printf($f['CURP']);
    //printf( $f["Nombre"], $f["CURP"]); 
    //$f = $resultado2 ;
    //$nombre=$f['Nombre'];
    //return array($nombre);
    //echo array($nombre);
    //return array ($f);
  //return array($f);
    //echo json_encode($resultado2);
    //echo array($f) ;
    //return array($Nombre,$RFC,$Representante_Legal,$CURP);
      //    echo (array($nombre,$RFC,$Representante_Legal,$CURP));

?>