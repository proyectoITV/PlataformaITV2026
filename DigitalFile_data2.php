<?php
require("seguridad.php");
require("config.php");
require("var_clean.php");
require("lib/funciones.php");
$busqueda = VarClean($_POST['busqueda']);
$mode = VarClean($_POST['mode']);
$nitavu = VarClean($_POST['nitavu']);

if ($mode = 1){
$sql = "select * from digitalfiles 
where Descripcion like '%".$busqueda."%' or Tags like '%".$busqueda."%'";
$R = "";
historia($nitavu, "Realizo busqueda de un archivo en DigitalFile de  ".$busqueda);
	$r= $conexion -> query($sql);
    while($f = $r -> fetch_array()) {
        if (DigitalFile_view($f['IdFile'], $nitavu) == TRUE){
            $R.="<tr>";
            $R.="<td width=20% >";
            $R.="<a href='DigitalFile_download.php?id=".$f['IdFile']."'>";
            $R.="<img src='icon/pdf.png' style='width:32px;' title='Subido el ".$f['fecha']." a ".$f['hora']." por ".$f['Propietario']."'> ".$f['FileName'];
            $R.="</a>";
            $R.="</td>";
            $R.="<td><b style='font-size:11pt;'>".$f['Descripcion']."</b>";
            $R.="<br><cite>".$f['Tags']."</cite></td>";
            $R.="<td><img src='icon/user.png' style='width:32px;'>".nitavu_nombre($f['Propietario'])."<br>";
                $sqlU = "select * from digitalfilepermisos where IdFile='".$f['IdFile']."'";                
                $ru= $conexion -> query($sqlU);
                while($fu = $ru -> fetch_array()) {
                    $R.="<img src='icon/atencion.png' style='' class='minUser' title='".$fu['Nombre']." autorizado por ".$fu['Autorizo']."'> ";

                }
                unset($ru,$fu);

            $R.="</td>";            
            $R.="<td width=50px align=right><a href='DigitalFile.php?share=".$f['IdFile']."'
            class='btn btn-success'
            ><img src='icon/Share.png' style='width:32px;'></a></td>";
            $R.="</tr>";
        } else {
            $R.="<tr style='background-color:red; opacity:0.7;'>";
            $R.="<td width=20% >";
            // $R.="<a href='DigitalFile_download.php?id=".$f['IdFile']."'>";
            $R.="<img src='icon/pdf.png' style='width:32px;' title='Subido el ".$f['fecha']." a ".$f['hora']." por ".$f['Propietario']."'> ".$f['FileName'];
            // $R.="</a>";
            $R.="</td>";
            $R.="<td><b style='font-size:11pt;'>".$f['Descripcion']."</b>";
            $R.="<br><cite>".$f['Tags']."</cite></td>";
            $R.="<td><img src='icon/user.png' style='width:32px;'>".nitavu_nombre($f['Propietario'])."</td>";
            $R.="<td width=50px align=right><img title='No tienes acceso como Administrador de este archivo' src='icon/alerta.png' style='width:32px; cursor:pointer;'></td>";
            $R.="</tr>";
        }
            
       
    }
if ($R == ''){
    echo "Sin resultados con <b>".$busqueda."</b>";
} else {
    echo "<table class='tabla'>
    <th>Archivo</th>
    <th>Descripcion </th>
    <th>Administrador </th>
    <th> </th>


    ".$R."</table>";
}
}

?>