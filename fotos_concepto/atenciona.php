<?php
//include ("./unica/seguridad.php"); 
include ("./unica/body_head.php");
include ("./unica/body_menu.php");

// contenido:
?>
<?php

//PROBANDO FUNCION

$id_aplicacion ="atenciona"; //Id de la aplicacion a cargar
$IdDpto = nitavu_dpto($nitavu);	//id de la delegacion de acuerdo con cat_gerarquia
docdigital_no(FALSE, 1); //ahorra 1 hoja
xd_update('atenciona',$nitavu);//guarda la experiencia del usuario
historia($nitavu, "[atenciona] Uso la aplicacion");
if (sanpedro($id_aplicacion, $nitavu)==TRUE){
    echo "<h5>".app_detalle($id_aplicacion)."</h5><br><br>";
    $sql="select 
	IdArea as Id_Area,
	(select CatAreas.Nombre from CatAreas where CatAreas.IdArea = Id_Area) as Area,
	nitavu as IdEmpleado,
	(select nombre from empleados where nitavu=IdEmpleado) as Nombre,
	IdDelegacion as IdDel,
        (select cat_gerarquia.nombre from cat_gerarquia where cat_gerarquia.id = IdDel) as Delegacion
    from CatAreas_encargados
    WHERE IdDelegacion='".$IdDpto."' ORDER BY nitavu ";
    $r= $conexion -> query($sql);
    echo "<table class='tabla'><th>Empleado</th><th>Modulo(s) que atentiende</th><th width=20px></th>";
    while($f = $r -> fetch_array()) {
        echo "<tr>";
        echo "<td>".$f['Nombre']." (".$f['IdEmpleado'].")</td>";
        echo "<td>".$f['Area']." (".$f['Id_Area'].")</td>";
        echo "<td>";

        echo "<a href='?IdArea=".$f['Id_Area']."&IdDel=".$f['IdDel']."&IdE=".$f['IdEmpleado']."' class='btn btn-cancel'><img src='icon/cancel.png' style='width:14px;'></a>";
        echo "</td>";
        
        echo "</tr>";

    }
    echo "</table>";


    echo "<hr>";
    echo "<a href='#Accesos' class='btn btn-AzulTam'  rel='modal:open' > Agregar </a>";

    echo "<form action='atenciona.php' method='POST' name='Accesos' class='modal' id='Accesos'> ";
    echo "<div><label>Selecciona al empleado</label>";
    echo "<select name='empleado'>";
    $sql="select 
    *
    from empleados
    where 
    dpto = 45
    and estado = '' ";
    
    $r2= $conexion -> query($sql);
    while($f2 = $r2 -> fetch_array()) {
        
        echo "<option value='".$f2['nitavu']."'>".$f2['nombre']."</option>";
    }
    echo "</select>";
    echo "</div>";


    echo "<div><label>Modulos que atendera:</label>";
    echo "<select name='modulos'>";
    $sql="select 
    *
    from CatAreas
    ";
    $r3= $conexion -> query($sql);
    while($f3 = $r3 -> fetch_array()) {
        
        echo "<option value='".$f3['IdArea']."'>".$f3['Nombre']."</option>";
    }
    echo "</select>";
    echo "</div>";

    echo "<div><input type='submit' class='btn btn-default' value='Dar acceso' name='btnAcceso'></div>";
    echo "</form>";
} else{mensaje("ERROR: no tiene acceso a este modulo","");}


if (isset($_POST['btnAcceso'])){
    $IdArea = $_POST['modulos']; 
    $IdEmpleado = $_POST['empleado'];
    $IdDelegacion =  nitavu_dpto($IdEmpleado);
    $sql = "INSERT INTO CatAreas_encargados(IdArea, IdDelegacion, nitavu) VALUES ('$IdArea', '$IdDelegacion', '$IdEmpleado')";
    //$resultado = $conexion -> query($sql);
    if ($conexion->query($sql) == TRUE){
        historia($nitavu,"TURNOS: Dio acceso a control de Turnos a ".$IdEmpleado." al modulo con Id ".$IdArea." de la Delegacion(dpto) ".$IdDelegacion);
        mensaje("Guardado correctamente","atenciona.php");
    } else {
        mensaje("ERROR: Hubo un problema al intentar guardar el permiso. Es probable que ya tenga este permiso, de ser así comunicate con el Dpto. de Informática <br>".$sql,"atenciona.php");
    }

}

if ( isset($_GET['IdArea']) and isset($_GET['IdDel']) and isset($_GET['IdE']) ){
    $IdArea = $_GET['IdArea']; 
    $IdEmpleado = $_GET['IdE'];
    $IdDelegacion =  $_GET['IdDel'];
    $sql = "DELETE from CatAreas_encargados WHERE IdArea='".$IdArea."' and nitavu='".$IdEmpleado."' and IdDelegacion='".$IdDelegacion."'";
    $resultado = $conexion -> query($sql);
    if ($conexion->query($sql) == TRUE){
        historia($nitavu,"TURNOS: Retiro el permiso  a ".$IdEmpleado." del modulo con Id ".$IdArea." de la Delegacion (dpto) ".$IdDelegacion);
        mensaje("Permiso retirado correctamente <br>","atenciona.php");
    } else {
        mensaje("ERROR: Hubo un problema al intentar guardar el permiso. Comunicate con el Dpto. de Informática","atenciona.php");
    }


}


?>

<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>


<?php
include ("./unica/body_footer.php");
?>