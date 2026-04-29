<?php
    include ("unica/body_head.php");
    include ("unica/body_menu.php");
?>

<?php
set_time_limit(72000) ;
    
$id_aplicacion ="ap76"; //Id de la aplicacion a cargar
$nivel = aplicacion_nivel($id_aplicacion, $nitavu);
// $nivel='1';
echo "<h5>".app_detalle($id_aplicacion)."</h5>";        
xd_update('ap76',$nitavu);//guarda la experiencia del usuario
historia($nitavu, "Entro a la App [ap76] Control Interno");

echo "<div class='Ventana'>";
echo "<h3>Lista de archivos disponibles</h3>";
echo "<table class='tabla'>";

echo "<tr>";
echo "<td width=50px><img src='icon/pdf.png' class='icono'></td><td>";
echo "<a href='ci/00-OrdendeLectura.pdf' target=_blank title='Haga clic aqui para ver el archivo'>
00 - Orden de Lectura.pdf
</a>
";
echo "</td>";
echo "</tr>";



echo "<tr>";
echo "<td width=30px><img src='icon/pdf.png' class='icono'></td><td>";
echo "<a href='ci/01-ITAVU.pdf' target=_blank title='Haga clic aqui para ver el archivo'>
01 - ITAVU.pdf
</a>
";
echo "</td>";
echo "</tr>";


echo "<tr>";
echo "<td width=30px><img src='icon/pdf.png' class='icono'></td><td>";
echo "<a href='ci/02-ManualdeOrganizacionyEstatutoOrgánico.pdf' target=_blank title='Haga clic aqui para ver el archivo'>
02 - Manual de Organización y Estatuto Orgánico.pdf
</a>
";
echo "</td>";
echo "</tr>";




echo "<tr>";
echo "<td width=30px><img src='icon/pdf.png' class='icono'></td><td>";
echo "<a href='ci/03-ManualdeProcedimientos(Ejemplo).pdf' target=_blank title='Haga clic aqui para ver el archivo'>
03 - Manual de Procedimientos (Ejemplo).pdf
</a>
";
echo "</td>";
echo "</tr>";


echo "<tr>";
echo "<td width=30px><img src='icon/pdf.png' class='icono'></td><td>";
echo "<a href='ci/04-MarcoJuridico.pdf' target=_blank title='Haga clic aqui para ver el archivo'>
04 - Marco Juridico.pdf
</a>
";
echo "</td>";
echo "</tr>";



echo "<tr>";
echo "<td width=30px><img src='icon/pdf.png' class='icono'></td><td>";
echo "<a href='ci/05-CodigoEticaTamaulipas2018.pdf' target=_blank title='Haga clic aqui para ver el archivo'>
05 - Código Ética Tamaulipas 2018.pdf
</a>
";
echo "</td>";
echo "</tr>";


echo "<tr>";
echo "<td width=50px><img src='icon/pdf.png' class='icono'></td><td>";
echo "<a href='ci/06-CodigodeConducta.pdf' target=_blank title='Haga clic aqui para ver el archivo'>
06 - Codigo de Conducta.pdf
</a>
";
echo "</td>";
echo "</tr>";



echo "<tr>";
echo "<td width=50px><img src='icon/pdf.png' class='icono'></td><td>";
echo "<a href='ci/07-CartaCompromiso.pdf' target=_blank title='Haga clic aqui para ver el archivo'>
07 - Carta Compromiso.pdf
</a>
";
echo "</td>";
echo "</tr>";









echo "</table>";
echo "</div>";








if ($nivel == 1){//GRAFICA
    echo "<div class='ventana' style=''>";
    echo "<label>AVANCE DE LECTURA </label>";
    $sql = "
    select 
	
	(select 
		count(DISTINCT(nitavu))
		from historia where descripcion like '%[ap76]%' ) as Leidos,
		
		( (select count(*) from empleados where estado='') - 	(select 
		count(DISTINCT(nitavu))
		from historia where descripcion like '%[ap76]%' )) as Total

    ";
    
    $r= $conexion -> query($sql);
    
    while($f = $r -> fetch_array()) {
    
$data =   "['Empleados', 'Cantidad'],['Total',". $f['Total']."], ['Leidos',".$f['Leidos']."]";
}
$grafica = '

<script type="text/javascript">
google.charts.load("current", {packages:["corechart"]});
google.charts.setOnLoadCallback(drawChart);
function drawChart() {
var data = google.visualization.arrayToDataTable([
'.$data.'

]);

var options = {
pieHole: 0.4, legend:"none",

is3D: true



};

var chart = new google.visualization.PieChart(document.getElementById("donutchart"));
chart.draw(data, options);
}
</script>
<div id="donutchart" style="height: 320px;"></div>

';
echo $grafica;

    echo "</div>";
    }
















if ($nivel == 1){
echo "<div class='ventana' style='width:90%; overflow:auto;  '>";
echo "<label>PERSONAL </label>";
$sql = "select 
nitavu as QNitavu,
nombre,
dpto as IdDpto, Puesto,
(select nombre from cat_gerarquia where id = IdDpto) as Departamento,
(select 
    count(*)
    from historia where descripcion like '%[ap76]%' and nitavu=QNitavu) as Leido

from
empleados
where estado ='' order by Leido, Departamento DESC";

$r= $conexion -> query($sql);
echo "<table class='tabla' style='font-size:11pt;'>";
while($f = $r -> fetch_array()) {
    if ($f['Leido']==0){
        echo "<tr>";
    } else {
        echo "<tr style='background-color:#A6FFBC; color:#006600;'>";
    }
    
    echo "<td><b>".$f['nombre']."</b><br>".$f['Puesto']." de ".$f['Departamento']."</td>";
    
    echo "<td width=200px style='font-size:8pt;'>";

    $archivo = 'ci/ca/'.$f['QNitavu'].'.pdf';
    if (file_exists($archivo)){
        echo "<a target=_blank href='".$archivo."' class='btn btn-secundario'>Carta de Aceptacion</a>";
    } else {
        echo '<form action="ci.php" method="post"  enctype="multipart/form-data">';
        echo "<input type='hidden' value='".$f['QNitavu']."' name='QNitavu'>";
        echo "<input type='hidden' value='".$archivo."' name='archivo'  >";
        echo "<input type='file' name='ci' accept='.pdf'><input type='submit' name='submit_ci' class='btn btn-default' value='Subir'>";
        echo "</form>";


    }
    echo "</td>";
    
    echo "</tr>";
}
echo "</table>";
echo "</div>";
}

if (isset($_POST['submit_ci'])){
    if (subirpdf3('ci',$_POST['archivo'])=="TRUE" ){
        historia($nitavu,"Subio correctamente el archivo <a href='".$_POST['archivo']."'>".$_POST['archivo']."</a>");

        $sql1="
        INSERT INTO historia
		(nitavu, fecha, hora, descripcion)
		VALUES
		('".$_POST['QNitavu']."', CURTIME(), CURTIME(), '[ap76]  ".nitavu_nombre($nitavu)." le ha subido su carta compromiso')";        
	    if ($conexion->query($sql1) == TRUE)
            { }
            
        mensaje("Archivo subido correctamete ",'ci.php');
        
    } else {
        mensaje("ERROR: Hubo algun problema al subir el archivo ".$_POST['archivo'],'ci.php');
    }
}
echo "<div class='ventana' style='width:100%; overflow:auto;  '>";
echo "<label>SELECCIONE EL PERSONAL PARA ARCHIVAR LA CARTA COMPROMISO</label>";


echo "</div>";

?>





<?php include ("unica/body_footer.php"); ?>