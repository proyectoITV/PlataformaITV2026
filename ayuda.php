<?php include ("./lib/body_head.php"); include ("./lib/body_menu.php"); ?>

<?php
$id_aplicacion = "ap62";
echo "<script>$('body').css('background-color','rgb(108, 116, 119)');</script>";
echo "<script>$('body').css('background-image','url(img/wall_ayuda3.jpg)');</script>";
echo "<script>$('body').css('background-position','top');</script>";
// echo "<script>$('body').css('background-size','120%');</script>";

echo "<div id='AppDetalle'>".app_detalle($id_aplicacion, $nitavu)."</div>";
echo "<script>$('#AppDetalle').css('background-color','rgba(2, 2, 2, 0.41)');</script>";    

$IdApp = "";
if (isset($_GET['idapp'])){
    $IdApp = VarClean($_GET['idapp']);
    $NombreAplicacion = app_nombre($IdApp);
    $sql="select * from ayuda_html where IdApp ='".$IdApp."'";
    // echo $sql;
    echo "<h3 style='        
    color: #eaebe6;
    text-shadow: 0px 3px 7px rgba(0, 0, 0, 0.6);
    text-transform: capitalize;
    '>Ayuda relacionada para la Aplicacion <b>".$NombreAplicacion."</b> (".$IdApp.")</h3>";
} else {
    $sql="select * from ayuda_html";
}



echo "<div id='Ayudas' class='container' style='
background-color: #ffffffb0;
padding: 20px;
border-radius: 10px;
margin-top: 30px;

'>";
TablaDinamica_MySQL("",$sql, "AyudaLista", "AyudaTabla", "", 2,"AyudaTabla"); //0 = Basica, 1 = ScrollVertical, 2 = Scroll Horizontal
echo "</div>";

// echo "<script>$('.odd').css('background-color','#f9f9f93d');</script>";
 




echo "<div id='AyudaInformatica' class='' style='
width:100%;
'><h3 style='color:white; font-size:9pt;'> <b>Estamos a tus ordenes: </b> </h3>";

echo "<h3 style='color:white; font-size:8pt; text-transform: Capitalize;'> Dpto. de Informatica:</h3>";
$sqlInforamticos="select * from informaticos";
$r= $conexion -> query($sqlInforamticos);
while($f = $r -> fetch_array()) {
    echo "<article><a href='mailto:".$f['correoelectronico']."' style='color:white;'>";
    echo ponerfoto("fotos/".$f['nitavu'].".jpg",'fotoAyuda');
    echo "<br><b>".nombre_corto($f['nitavu'],0).' '.nombre_corto($f['nitavu'],1)."<b><br>";
    echo "<img src='icon/tel_blanco.png' style='width:15px;'> ".$f['telefono_extension']."<br>";
    // echo "<img src='icon/letters.png' style='width:15px;'>:".$f['correoelectronico']."";


    echo "</a></article>";

}

unset($r,$f);




echo "<h3 style='color:white; font-size:8pt; text-transform: Capitalize;'>Soporte Tecnico:</h3>";
$sqlInforamticos="select * from soporte";
$r= $conexion -> query($sqlInforamticos);
while($f = $r -> fetch_array()) {
    echo "<article><a href='mailto:".$f['correoelectronico']."' style='color:white;'>";
    echo ponerfoto("fotos/".$f['nitavu'].".jpg",'fotoAyuda');
    echo "<br><b>".nombre_corto($f['nitavu'],0).' '.nombre_corto($f['nitavu'],1)."<b><br>";
    echo "<img src='icon/tel_blanco.png' style='width:15px;'> ".$f['telefono_extension']."<br>";
    // echo "<img src='icon/letters.png' style='width:15px;'>:".$f['correoelectronico']."";


    echo "</a></article>";

}
unset($r,$f);


echo "</div>";


echo "<script>$('tr').css('background-color','transparent');</script>";
echo "<script>$('td').css('background-color','transparent');</script>";

?>



</div>
<?php include ("./lib/body_footer.php"); ?>