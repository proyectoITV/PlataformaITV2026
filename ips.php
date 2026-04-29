<?php
include("./lib/body_head.php");
include("./lib/body_menu.php"); 

$idDepartamento=nitavu_dpto($nitavu);
$id_aplicacion ="ap102";
$nivel =aplicacion_nivel($id_aplicacion, $nitavu);
// $nivel=1;
if (sanpedro($id_aplicacion, $nitavu)==TRUE){
    echo "<h5 >".app_detalle($id_aplicacion, $nitavu)."</div>";	
    historia($nitavu,'['.$id_aplicacion.'] Iniciando'); 

    $sql="
    select DISTINCT ip_local

    from IPS where TipoIP<> 16
    
    order by ip_local

    
    ";
    $rc= $conexion -> query($sql);    
    echo "<table class='tabla'>";
    echo "<th>Direccion IP</th><th>Usuario</th>";
    while($f = $rc -> fetch_array()) {
        echo "<tr>";
        echo "<td style='font-size:12pt;' width=200px><b style=''>".substr($f['ip_local'], 0, 3)."</b>".substr($f['ip_local'], 3)."</td>";        
        // echo "<td><b>".$f['Empleado']."</b><br>".$f['Departamento']."</td>";

        echo "</tr>";
    }
    echo "</table>";
    
} else {
    mensaje("ERROR: no tiene acceso a esta aplicacion. <br>
    <a href='organigrama.php'>Solicitelo al Departamento de Informática a traves de la Dirección General. </a> <br>
    ","");
}




?>



<?php
include ("./lib/body_footer.php"); ?>
