<?php
include ("./unica/seguridad.php");
include ("./unica/config.php");
include ("./unica/funciones.php");

?>


<?php
//entregara la informacion de carga en funcion del numero de paginas * 10
//
if (isset($_GET['pagina']) and isset($_GET['id'])){
    
    if (isset($_GET['pagina'])){
        
            $avance = 2; $de= 0;
            $de = $_GET['pagina'] * $avance;
            $cuantos = $de + $avance;
    
        
    } else {
        $pag = 0; $cuantos = $avance;
    }

    if (soytitular($_GET['id'])=='FALSE'){ //sino soy titular, solo puedo ver mi actividad
        $sql = "SELECT * FROM ActividadDeUsuarios WHERE nitavu='".$_GET['id']."'  order by fecha DESC limit ".$de.",".$cuantos." ";			
    }else {
        $MisDepartamentos = misdptos($_GET['id']);    
        $sql = "SELECT * FROM ActividadDeUsuarios WHERE dpto in(".$MisDepartamentos.")  order by fecha DESC limit ".$de.",".$cuantos." ";			
        
    }
    echo $sql;
    $r= $conexion -> query($sql);
    while($f = $r -> fetch_array()) {

        $Descripcion = $f['descripcion'];$x = 0;
        $Origen = strpos($Descripcion, 'Agente'); if ($Origen !== false) {
            echo "<div id='actividad' style='background-color:#FFFFCC; border: #FF9933 1px solid; color:#FF9933;'>";
            $x= 1;
        } 

        $Buscar = strpos($Descripcion, 'Busqueda'); if ($Buscar !== false) {
            echo "<div id='actividad' style='background-color:#F4FCCF; border: #D7F352 1px solid; color:#FF9933;'>";
            $x= 1;
        } 

        $fallida = strpos($Descripcion, 'fallida'); if ($fallida !== false) {
            echo "<div id='actividad' style='background-color:#FF9393; border: #990000 1px solid; color:#990000;'>";
            $x= 1;
        } 

        $error = strpos($Descripcion, 'ERROR'); if ($error !== false) {
            echo "<div id='actividad' style='background-color:#FF9393; border: #990000 1px solid; color:#990000;'>";
            $x= 1;
        } 
        
        $ac = strpos($Descripcion, 'actividad'); if ($ac !== false) {
            echo "<div id='actividad' style='background-color:#E9EBEE; border: #4267B2 1px solid; color:#4267B2;'>";
            $x= 1;
        } 
        
        $c = strpos($Descripcion, 'Cumpleaños'); if ($c !== false) {
            echo "<div id='actividad' style='background-color:#EBD7FF; border: #990099 1px solid; color:#990099;'>";
            $x= 1;
        } 
        
        $pe = strpos($Descripcion, 'permiso'); if ($pe !== false) {
            echo "<div id='actividad' style='background-color:#A4A400; border: #515100 1px solid; color:white;'>";
            $x= 1;
        } 

        $co = strpos($Descripcion, 'Correo'); if ($co !== false) {
            echo "<div id='actividad' style='background-color:#FF6600; border: #FF0000 1px solid; color:white;'>";
            $x= 1;
        } 

        $a = strpos($Descripcion, 'Aprobo'); if ($a !== false) {
            echo "<div id='actividad' style='background-color:#A2C30D; border: #A4A400 1px solid; color:white;'>";
            $x= 1;
        } 

        $em = strpos($Descripcion, 'Embarques'); if ($em !== false) {
            echo "<div id='actividad' style='background-color:#A2C30D; border: #006666 1px solid; color:#006666;'>";
            $x= 1;
        } 

        $salida = strpos($Descripcion, 'Dio'); if ($salida !== false) {
            echo "<div id='actividad' style='background-color:#C1CEE8; border: #4267B2 1px solid; color:#4267B2;'>";
            $x= 1;
        } 

        $req = strpos($Descripcion, 'Req'); if ($req !== false) {
            echo "<div id='actividad' style='background-color:#FFCCCC; border: #400020 1px solid; color:#400020;'>";
            $x= 1;
        } 

        if ($x==0){ //normal
            echo "<div id='actividad'>".$Origen;
        }

        
        //echo $sql;
        
        echo "<table  >";
        echo "<tr>";
        echo "<td width=100px style='background-color:' valign=center align=center>";
        echo ponerfoto("fotos/".$f['nitavu'].".jpg",'foto_actividad');
        echo "<br><b>".nombre_corto($f['nitavu'],0)." ".nombre_corto($f['nitavu'],1)."</b>";
        echo "<label><br>".$f['dpto_nombre']."</label>";
        echo "</td>";
        
        echo "<td id='descripcion'>";
        echo "<label>[id:".$f['id']."]</label><br>";
        echo $f['descripcion']."<br>";
        echo "<label>".fecha_larga($f['fecha'])." a las ".hora12($f['hora'])."</label>";
        echo "</td>";
        
        echo "</tr>";
        echo "</table>";
        echo "</div>";
    
    }
    
}


// $sql = "SELECT * FROM empleados WHERE (estado='' AND dpto in(".misdptos($nitavu).") )";			
// echo $sql;
// $rc= $conexion -> query($sql);
// echo "<h1>Personal que dependende de ud:</h1>";
// while($f = $rc -> fetch_array()) {
//     echo $f['nombre']."<br>";

// }
sleep(1);


//include("unica/body_footer.php");
?>