<?php
require("config.php");
require("components.php");

$nitavu = VarClean($_POST['nitavu']);
if (isset($_POST['busqueda'])){
    $busqueda = VarClean($_POST['busqueda']);
} else {
    $busqueda = "";
}
$mode = VarClean($_POST['mode']);

// echo "mode=".$mode;
// echo "- ".$nitavu." buscando ".$busqueda;
if ($mode == 0){
    PreferenceUpdate('VistaMenu', $nitavu, '',0);
if ($busqueda <> ''){
    $sqlCat="
    select ifnull(Categoria,'') as Categoria
    from _searchpermisos a where IdEmpleado = ".$nitavu."
    and (Label like '%".$busqueda."%' or  descripcion like '%".$busqueda."%')
    GROUP BY ifnull(Categoria,'')
    order by count(*) DESC
    ";

} else {
$sqlCat="
select ifnull(Categoria,'') as Categoria
from _searchpermisos a where IdEmpleado = ".$nitavu." 
GROUP BY ifnull(Categoria,'')
order by count(*) DESC
";
}
// echo $sqlCat;
$rc = $conexion -> query($sqlCat);
echo "<div id='app_contenedor' >";
$c=0;
while($fc = $rc -> fetch_array())
{

        echo "<div id='aplicaciones' >
        <h4 style='font-size:10pt; color: #990000; font-weight: bold;'>".$fc['Categoria']."</h4>
        ";
        if ($busqueda <> ''){
            $sql = "select
            a.*,
            ifnull(p.Value, 'NoR') as MiApp
            from _searchpermisos a
            left join preferences p
                on p.Preference = a.IdApp
                and p.GroupA = '".$nitavu."'
                and p.GroupB = ''
            where a.IdEmpleado = ".$nitavu." and a.Categoria='".$fc['Categoria']."'
            and (a.Label like '%".$busqueda."%' or  a.descripcion like '%".$busqueda."%')
            ";
        } else {
            $sql = "select
            a.*,
            ifnull(p.Value, 'NoR') as MiApp
            from _searchpermisos a
            left join preferences p
                on p.Preference = a.IdApp
                and p.GroupA = '".$nitavu."'
                and p.GroupB = ''
            where a.IdEmpleado = ".$nitavu." and a.Categoria='".$fc['Categoria']."' order by a.Label";
        }
        // echo $sql;
        $r = $conexion -> query($sql);
        while($fap = $r -> fetch_array())
        {//Categorias de Aplicaciones

            $MiApp = $fap['MiApp'];

            if ($MiApp == 'NoR'){ //No registrada        
                echo "<article>";
            } else {

                if ($MiApp == '0') { //No Favorita
                    // $IdFavorite = 1;
                    echo "<article style='background-color:#ffe0c5;'>";
                } else {// Favorita
                    // $IdFavorite = 0;
                    echo "<article>";
                }
                
            }
            echo "<table width=100%><tr>";

            echo "<td align=center class='MisApps_backgroundIcon'>
            <a href='".$fap['URL']."' style='display:block; text-decoration:none; text-decoration:none;' title='".$fap['Title']."'><img class='MisApps_Icon'src='icon/".$fap['Icono']."' ></a></td>";
            echo "<td >";
            
            echo "<span  title='".$fap['Title']."' style='font-size:8pt; cursor:pointer;'> <a style='display:block; text-decoration:none;  color:black; width:100%; height:200%;' href='".$fap['URL']."'>".$fap['Label']."</a></span>";
            // echo "<cite style='font-size:7pt; font-family:Light;'>".$fap['Title']."</cite>";
            
            echo "</td>";

           
            if ($MiApp == 'NoR'){ //No registrada                
                echo "<td align=right><img id='fav_".$fap['IdApp']."' title = 'Haga clic aqui para hacerla su favorita' src='icon/favorite0.png' style='width:18px; cursor:pointer;' onclick='Favorite(`".$fap['IdApp']."`)';>"."</td>";
            } else{
                if ($MiApp == '0') { //No Favorita
                    // $IdFavorite = 1;
                    echo "<td align=right><img id='fav_".$fap['IdApp']."' title = 'Haga clic aqui para hacerla su favorita' src='icon/favorite1.png' style='width:18px; cursor:pointer;' onclick='Favorite(`".$fap['IdApp']."`)';>"."</td>";
                } else {// Favorita
                    // $IdFavorite = 0;
                    echo "<td align=right><img id='fav_".$fap['IdApp']."' title = 'Haga clic aqui para hacerla su favorita' src='icon/favorite0.png' style='width:18px; cursor:pointer;' onclick='Favorite(`".$fap['IdApp']."`)';>"."</td>";
                }
            }
            
            echo "</tr></table>";
            echo "</article>";
            
        }
        unset($r, $fap);
        echo "</div>";
        $c = $c +1;
}
if ($c == 0){
    echo "Sin ningun acceso a aplicaciones";
}
echo "</div>";
unset($rc, $fc);

if ($c == 0){
    echo "<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>";
}
}


if ($mode == 1){
    $DivApps="";
    $CountApp = 0;
    $DivApps.= "<h3 style='
        background-color: ".Preference("ColorResaltado", "", "").";
        width: 90%;
        display: inline-block;
        padding: 6px;
        border-radius: 6px;
        margin-top: -10px;
        color: white;
    '><table width=100%><tr><td width=50px><img src='icon/busqueda.png' style='width:32px'></td><td
    style='color:white;'
    >Buscando ".$busqueda."</td></tr></table></h3>";
    
    $DivApps.= "<div id='app_contenedor' >";

    
    $DivApps.= "<div id='aplicaciones'>";
    $DivApps.= "<h6>Aplicaciones encontradas: </h6>";
    
    $sql = "
    SELECT
	`a`.`icono` AS `Icono`,
	`a`.`vinculo` AS `URL`,
	`a`.`nombre` AS `Label`,
	concat( 'IdApp=', `a`.`IdApp`, ' ', `a`.`descripcion` ) AS `Title`,
    (select count(*) from aplicaciones_permisos where nitavu='".$nitavu."' and idapp = a.IdApp) as Permiso,
    a.IdApp
    FROM
        `aplicaciones` `a`
    WHERE nombre like '%".$busqueda."%' or descripcion like '%".$busqueda."%' and estado=0
    ";
     // echo $sql;
    $r = $conexion -> query($sql);
    while($fap = $r -> fetch_array())
    {//Categorias de Aplicaciones
        if ($fap['Permiso']==1){
            $DivApps.= "<article>";
        } else {
            $DivApps.= "<article style='opacity: 0.5;'>";
        }
        $DivApps.= "<table width=100%><tr>";
    
        $DivApps.= "<td align=center class='MisApps_backgroundIcon'>";
        if ($fap['Permiso']==1){
            $DivApps.= "<a href='".$fap['URL']."' style='display:block; text-decoration:none; ' title='".$fap['Title']."'>";
        }
        $DivApps.= "<img class='MisApps_Icon'src='icon/".$fap['Icono']."' >";
        if ($fap['Permiso']==1){
            $DivApps.= "</a>";
        }
        $DivApps.=         "<td >";
        $DivApps.= "<span  title='".$fap['Title']."' style='font-size:8pt; cursor:pointer;'>";
        if ($fap['Permiso']==1){
            $DivApps.= "<a style='display:block; text-decoration:none;  color:black; width:100%; height:200%;' href='".$fap['URL']."'>".$fap['Label']."</a>";
        } else {
            $DivApps.= "".$fap['Label']."";
        }
        $DivApps.= "</span>";
        // echo "<cite style='font-size:7pt; font-family:Light;'>".$fap['Title']."</cite>";
        
        $DivApps.= "</td>";
        if ($fap['Permiso']==0){
            $DivApps.= "<td width=50px align=right><a href='solicita_app.php?id=".$fap['IdApp']."' title='Haga clic aqui para imprimir formato de solicitud de acceso'>
            <img src='icon/permiso.png' style='width:23px;'></a></td>";
            }
    
            $DivApps.= "</tr></table>";
            $DivApps.= "</article>";
            $CountApp = $CountApp  + 1;
        
    }
    unset($r, $fap);
    
   
    $DivApps.= "</div>";

    // if ($CountApp>0){
        echo $DivApps;
    // }
    



    echo "<div id='aplicaciones'>";
    echo "<h6>Reportes: </h6>";
    $sql = "
        SELECT
        IF(a.out_type=0,'reportes/icons/html0.png',
            IF(a.out_type=1,'reportes/icons/datatable0.png',
                IF(a.out_type=2,'reportes/icons/pdf.png',
                    IF(a.out_type=3,'reportes/icons/excel.png',
                        IF(a.out_type=4,'reportes/icons/word.png', 'reportes/icons/page.png'
                        )
                    )
                )
            )
        ) AS `Icono`,
        CONCAT('reportes/r.php?id=',a.id_rep) AS `URL`,
        `a`.`rep_name` AS `Label`,
        concat( '', a.rep_description,'. Desde bd ',
        (select ConName from dbs where IdCon = a.IdCon)
        ) AS `Title`,
        (select count(*) from reportes_permisos where reportes_permisos.IdUser='".$nitavu."' and id_rep = a.id_rep) as Permiso,
        a.id_rep
        FROM
            reportes a
        WHERE 
            rep_name like '%".$busqueda."%' or rep_description like '%".$busqueda."%'
    ";
    // echo $sql;
    $r = $conexion -> query($sql);
    while($fap = $r -> fetch_array())
    {//Categorias de Aplicaciones
        if ($fap['Permiso']==1){
            echo "<article>";
        } else {
            echo "<article style='opacity:0.8' class='disable'>";
        }
        echo "<table width=100%><tr>";
    
        echo "<td align=center class='MisApps_backgroundIcon'>";
        if ($fap['Permiso']==1){
            echo "<a href='".$fap['URL']."' style='display:block; text-decoration:none; ' title='".$fap['Title']."'>";
        }
        echo "<img class='MisApps_Icon'src='".$fap['Icono']."' >";
        if ($fap['Permiso']==1){
            echo "</a>";
        }
        echo "</td>";
        echo "<td >";
        echo "<span  title='".$fap['Title']."' style='font-size:8pt; cursor:pointer;'>";
        if ($fap['Permiso']==1){
            echo "<a style='display:block; text-decoration:none;  color:black; width:100%; height:200%;' href='".$fap['URL']."'>".$fap['Label']."</a>";
        } else {
            echo $fap['Label'];
        }
        echo "</span>";
        // echo "<cite style='font-size:7pt; font-family:Light;'>".$fap['Title']."</cite>";
        
        echo "</td>";

        echo "</td>";
        if ($fap['Permiso']==0){
        echo "<td width=50px align=right><a href='reportes/solicita/?id=".$fap['id_rep']."' title='Haga clic aqui para imprimir formato de solicitud de acceso'>
        <img src='icon/permiso.png' style='width:23px;'></a></td>";
        }
        echo "</tr></table>";
        echo "</article>";
        
    }
    unset($r, $fap);
    
    echo "</div>";
    


//-----------------------------------	





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
    
        echo "<a href='".$fap['URL']."' style='display:block; text-decoration:none; ' title='".$fap['Asunto']."
        '
        >";
    
    echo "<img class='MisApps_Icon' src='icon/page.png' style='width:32px;' >";
   
        echo "</a>";
   
    echo "</td>";
    echo "<td >";
    echo "<span  title='".$fap['Asunto']."' style='font-size:8pt; cursor:pointer;' title='".$fap['Descripcion']."'>";
    
        echo "<a style='display:block; text-decoration:none;  color:black; width:100%; height:200%;' href='".$fap['URL']."'
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
echo "</div>";



//-----------------------------------	

}


if ($mode == 2){
    PreferenceUpdate('VistaMenu', $nitavu, '',2);
            $sql = "select  
            *
            from 
    
            _searchpermisos a where IdEmpleado = ".$nitavu." and URL <> ''  order by Label";
            // echo $sql;
            echo "<div id='app_iconos'>";
            $r = $conexion -> query($sql);
            while($fap = $r -> fetch_array())
            {//Categorias de Aplicaciones
                echo "<article>";
                echo "<a href='".$fap['URL']."' style='display:block; text-decoration:none; ' title='".$fap['Title']." - ".$fap['Label']."'>";
                echo "<img class=''src='icon/".$fap['Icono']."' >";
                echo "<br><span title='".$fap['Label']."'>".substr($fap['Label'], 0, 10)."...</span>";
                echo "</a>";
                echo "</article>";
                
            }
            unset($r, $fap);
            echo "</div>";
}


if ($mode == 3){
    PreferenceUpdate('VistaMenu', $nitavu, '',3);
    $sql = "  
    select 
    *
    
    from misapp_html a where IdEmpleado = ".$nitavu." order by App ";
    // echo $sql;
    // $sql = "select * from digitalfilepermisos where IdFile='".$IdFile_share."'";
    echo "<div class='container'>";
    echo TablaDinamica_MySQL("",$sql,"Usuarios","TblUsuarios","",2);
    echo "</div>";
}



if ($mode == 4){
    PreferenceUpdate('VistaMenu', $nitavu, '',4);
            $sql = "select  
            *
            from 
    
            _searchpermisos a where IdEmpleado = ".$nitavu." and URL <> ''  and IdFavorite=1
            order by Label";
            // echo $sql;
            echo "<h1 style='
            background-color: #bc955c;
            margin-top: -67px;
            padding-top: 18px;
            text-align: left;
            padding-bottom: 10px;
            height: 61px;
            color: #ffebd0;
            font-size:13pt;
            '><b style='color:white; margin-left:10px;' class='pc'>Mis Apps Favoritas </b></h1>";
            echo "<div id='app_iconos'>";
            $r = $conexion -> query($sql);
            while($fap = $r -> fetch_array())
            {//Categorias de Aplicaciones
                echo "<article>";
                echo "<a href='".$fap['URL']."' style='display:block; text-decoration:none; ' title='".$fap['Title']." - ".$fap['Label']."'>";
                echo "<img class=''src='icon/".$fap['Icono']."' >";
                echo "<br><span title='".$fap['Label']."'>".substr($fap['Label'], 0, 10)."...</span>";
                echo "</a>";
                echo "</article>";
                
            }
            unset($r, $fap);
            echo "</div>";
}

// echo $sql;





?>