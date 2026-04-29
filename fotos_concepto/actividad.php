<?php
include ("./unica/body_head.php");
include ("./unica/body_menu.php");


//PROCESO PARA TOCAR LA PUERTA DE SAN PEDRO
$id_aplicacion ="ap33"; //Id de la aplicacion a cargar
docdigital_no(FALSE, 1); //ahorra 1 hoja
// xd_update('ap33',$nitavu);//guarda la experiencia del usuario
historia($nitavu, "[ap10] consulto la actividad");

$nivel = aplicacion_nivel($id_aplicacion, $nitavu);	//Nivel 1 = todos, otro nivel solo los que dependen de el

if (sanpedro($id_aplicacion, $nitavu)==TRUE){
    $MisDepartamentos = misdptos($nitavu);
	echo "<h5>".app_detalle($id_aplicacion)."</h5>";
    echo "<div class='ModulosInteriores pc' style='background-color:#FFFF73; border: 1px solid #D9A300; width:20%; height: 121px; display: inline-block: '>";    
    echo "
    <form action='' method='GET'>";
    if (isset($_GET['desde'])){
        echo "<span><label>Desde:</label><input type='date' name='desde' value='".$_GET['desde']."'></span><br>";
    } else{
        echo "<span><label>Desde:</label><input type='date' name='desde' value='".$fecha."'></span><br>";
    }
    // echo "<div><label>Hasta:</label><input type='date' name='hasta' value='".$fecha."'></div>";
    echo "<span><br><input type='submit' name='btn_historia' value='Consultar' class='btn btn-secundario' style='color:white;'></span>";
   
    echo "</form>";
    echo "</div>";

    echo "<div class='ModulosInteriores pc' style='background-color:gray; border: 1px solid #D9A300; width:70%;  height: 121px; display: inline-block; overflow-y:auto;'>";    
    // echo "<h2>Selecciona y Consulta</h2>";
    
   
    
    $sql="
    SELECT
	dpto as IdDpto,
	(select nombre from cat_gerarquia where id=IdDpto) as Departamento,
	empleados.* 
    FROM
        empleados 
    WHERE
        dpto  in(".$MisDepartamentos.")
    ";    
    $r1= $conexion -> query($sql);   
    // echo $sql;
    while($femp = $r1 -> fetch_array()) {
        // var_dump($femp);
        if (isset($_GET['desde'])){
            echo "<a href='?desde=".$_GET['desde']."&IdUser=".$femp['nitavu']."' title='".$femp['nombre']."'>";        
        } else {
            echo "<a href='?desde=".$fecha."&IdUser=".$femp['nitavu']."'>";        
        }
        
        echo ponerfoto("fotos/".$femp['nitavu'].".jpg",'foto_actividad')." ";
        echo "</a>";
    }
    echo "</div>";

    
    
    if (isset($_GET['desde']))  {$FechaSeleccionada  = $_GET['desde'];} else {$FechaSeleccionada = $fecha;}
    
    if ($nivel == 1){
        $sql = "SELECT * FROM actividad WHERE fecha='".$FechaSeleccionada."'";
    } else {
        $sql = "SELECT * FROM actividad WHERE dpto in(".$MisDepartamentos.")  and fecha='".$FechaSeleccionada."'";			
    }

    if (isset($_GET['IdUser'])){
        $quien = $_GET['IdUser'];
        if (ValidaVAR($quien)==TRUE){$quien = LimpiarVAR($quien);}
        
        $sql="SELECT * FROM actividad WHERE NEmpleado=".$quien." and fecha='".$FechaSeleccionada."'";
    }
    

    
        

    
    // echo $sql;
    
    $r= $conexion -> query($sql);   
   
    $Resultados =  "<table class='tabla' >";
    $Cuantos = 0; $NotItem = 0;
    while($f = $r -> fetch_array()) {
        $Descripcion = $f['Descripcion'];

        $item = strpos($Descripcion, 'Agente'); if ($item !== false) { $NotItem = $NotItem +1;
        $Resultados = $Resultados."<tr style='background-color:cyan;'>";} 

        $item = strpos($Descripcion, 'Busqueda'); if ($item !== false) { $NotItem = $NotItem +1;
        $Resultados = $Resultados."<tr style='background-color:#F4FCCF;'>";} 

        $item = strpos($Descripcion, 'ERROR'); if ($item !== false) { $NotItem = $NotItem +1;
        $Resultados = $Resultados."<tr style='background-color:#FF9393;'>";} 

        $item = strpos($Descripcion, 'permiso'); if ($item !== false) { $NotItem = $NotItem +1;
        $Resultados = $Resultados."<tr style='background-color:#A4A400;'>";} 

        $item = strpos($Descripcion, 'correo'); if ($item !== false) { $NotItem = $NotItem +1;
        $Resultados = $Resultados."<tr style='background-color:#FF6600;'>";} 
    
        $item = strpos($Descripcion, 'mbarques'); if ($item !== false) { $NotItem = $NotItem +1;
        $Resultados = $Resultados."<tr style='background-color:#A2C30D;'>";} 

        $item = strpos($Descripcion, 'Req'); if ($item !== false) { $NotItem = $NotItem +1;
        $Resultados = $Resultados."<tr style='background-color:#FFCCCC;'>";} 
    
        $item = strpos($Descripcion, 'mt'); if ($item !== false) { $NotItem = $NotItem +1;
        $Resultados = $Resultados."<tr style='background-color:#DC73FF;'>";} 

   
        
        if ($NotItem == 0 ) {$Resultados = $Resultados. "<tr>";}

        $Resultados = $Resultados. "<td width=150px align=center valign=middle><b>";
        $Resultados = $Resultados.ponerfoto("fotos/".$f['NEmpleado'].".jpg",'foto_actividad')."<br>";
        $Resultados = $Resultados."<b>".$f['Nombre']."</b><br><span style='font-size:6pt;'>".$f['Puesto']." ".$f['Departamento']."</span></td>";            
        $Resultados = $Resultados. "<td>".$f['Descripcion']."<br><span style='color:gray;font-size:7pt;'>".fecha_larga($f['fecha'])." ".hora12($f['hora'])."</span></td>";
        $Resultados = $Resultados. "</tr>";

        $Cuantos = $Cuantos +1 ;
    }
    $Resultados = $Resultados. "</table>";
    
  
    
    echo "</div>";
    
    echo "<div id='DivHistoria'  >"; //Resultado
    //estadistica:
    echo "<h1><b>Movimientos registrados el ".fecha_larga($FechaSeleccionada)."(".$Cuantos.")</b></h1>";
    echo $Resultados;
    
    echo "</div>";
    

} else {mensaje("ERROR: no tienes acceso a esta aplicacion",'');}









include("unica/body_footer.php");
?>