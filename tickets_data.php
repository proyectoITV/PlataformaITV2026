<?php
require("config.php");
require("components.php");

$nitavu = VarClean($_POST['nitavu']);
$busqueda = VarClean($_POST['busqueda']);
$mode = VarClean($_POST['mode']);

// echo "mode=".$mode;
// echo "- ".$nitavu." buscando ".$busqueda;
if ($mode == 0){
    $sql = "select DISTINCT a.nitavu,
    (select nombre from empleados where nitavu = a.nitavu) as Nombre,
    (select count(*) from ticketpendientes where nitavu = a.nitavu and estado = 0) as Pendientes
    from ticketpendientes a  where  dpto = ".nitavu_dpto($nitavu)." and estado=0";
    // echo $sql;
    $r= $conexion -> query($sql);
    $data = "";
    $html_resume = "<h3>COLABORACIONES ACTIVAS</h3><table class='tabla'>";
    while($f = $r -> fetch_array()) {
        $data = $data."['".$f['Nombre']."',".$f['Pendientes']."],";
        $html_resume = $html_resume."<tr>";
        $html_resume = $html_resume."<td style='font-size: 16px;'>".$f['Nombre']."</td><td style='font-size: 16px;'><a href='#modal".$f['nitavu']."' rel='MyModal:open'>".$f['Pendientes']."</a></td>";
        $html_resume = $html_resume."</tr>";

        //Construimos el modal
        echo "<div id='modal".$f['nitavu']."' class='MyModal'><h3>Casos activos, atendidos por:".$f['Nombre']." </h3>";
        $sqlR = "
        SELECT 
        a.*,
        (select asunto from cp_nuevosdocumentos where id = a.numcaso) as Asunto,
        (select estado from cp_nuevosdocumentos where id = a.numcaso) as Estado

        FROM cp_colaboradores a WHERE nitavu = ".$f['nitavu']." and activo = 0
                ";
        $rx= $conexion -> query($sqlR);
        echo  "<table class='tabla'>";
        while($fx = $rx -> fetch_array()) {
            if ($fx['Estado']==0) {
            echo "<tr>";
            echo "<td>
            <a href='cp_nuevos_oficios.php?id=".$fx['numcaso']."&txtplus=1&pv=1'>
            ".$fx['numcaso']."</a></td><td>".$fx['Asunto']."</td>";
            
        
            }
        
        }
        echo "</table>";
        echo "</div>";
    }
    $html_resume = $html_resume."</table>";
    echo $html_resume;

    
    echo "<br><br><br><center><a href='cp_controldocumental.php' class='btn-identidad-color2'>Ver mi correspondencia</a></center>";
    $data = substr($data, 0, -1); //quita la ultima coma.


}


if ($mode == 1){ //Desde Buscar
    
echo "<div id='aplicaciones'>";
echo "<h6>Tickets: </h6>";
if (sanpedro("ap66", $nitavu)==TRUE)
{
$sql = "
select * from busquedas_tickets 
    WHERE 
        Descripcion like '%".$busqueda."%' or Asunto like '%".$busqueda."%'
";
// echo $sql;
$r = $conexion -> query($sql);
while($fap = $r -> fetch_array())
{//Categorias de Aplicaciones
    
    echo "<article>";    
    echo "<table width=100%><tr>";

    echo "<td align=center class='MisApps_backgroundIcon'>";
    
        echo "<a href='".$fap['URL']."' style='display:block;' title='".$fap['Asunto']."
        '
        >";
    
    echo "<img class='MisApps_Icon' src='icon/page.png' style='width:32px;' >";
   
        echo "</a>";
   
    echo "</td>";
    echo "<td >";
    echo "<span  title='".$fap['Asunto']."' style='font-size:8pt; cursor:pointer;' title='".$fap['Descripcion']."'>";
    
        echo "<a style='display:block; color:black; width:100%; height:200%;' href='".$fap['URL']."'
        title='".$fap['Descripcion']."'
        >".$fap['Asunto']."</a>";
    
    echo "</span>";
    echo "<cite style='font-size:7pt; font-family:Light;' title='".$fap['Descripcion']."'>".substr($fap['Descripcion'], 0, 20)."...</cite>";
    
    echo "</td>";

    echo "</td>";
    
    echo "</tr></table>";
    echo "</article>";
    
}
unset($r, $fap);
} else {
    echo "Sin Permiso para usar Tickets";
}



//-----------------------------------	

}


// echo $sql;





?>