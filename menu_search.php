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
?>

<style>
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap');

    /* Category Cards Container */
    #menu_app_contenedor {
        display: grid !important;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)) !important;
        gap: 24px !important;
        padding: 24px !important;
        width: 100% !important;
        box-sizing: border-box !important;
        background-color: #f8fafc !important; /* Soft warm grey background for contrast */
        border-radius: 20px !important;
        margin-top: 10px !important;
        border: 1px solid #e2e8f0 !important;
    }
    
    #menu_app_contenedor #aplicaciones {
        background: #ffffff !important;
        border-radius: 16px !important;
        border: 1.5px solid #bc955c !important; /* Defined gold border */
        box-shadow: 0 10px 25px -5px rgba(188, 149, 92, 0.05) !important;
        padding: 24px !important;
        margin: 0 !important;
        display: flex !important;
        flex-direction: column !important;
        gap: 12px !important;
        box-sizing: border-box !important;
        width: 100% !important;
        transition: all 0.3s ease !important;
    }
    #menu_app_contenedor #aplicaciones:hover {
        box-shadow: 0 15px 35px -5px rgba(124, 18, 29, 0.1) !important;
        border-color: #7c121d !important; /* Smooth transition to guinda on hover */
    }

    /* Category Titles */
    #menu_app_contenedor #aplicaciones h4 {
        font-family: 'Inter', sans-serif !important;
        font-size: 14.5px !important;
        font-weight: 700 !important;
        color: #7c121d !important; /* Institutional Guinda */
        text-align: left !important;
        margin: 0 0 6px 0 !important;
        text-transform: uppercase !important;
        letter-spacing: 0.5px !important;
        border-bottom: 2px solid #f1f5f9 !important;
        padding-bottom: 10px !important;
    }

    /* Application Row Card */
    #menu_app_contenedor #aplicaciones article {
        width: 100% !important;
        margin: 0 !important;
        padding: 10px 14px !important;
        background-color: #f8fafc !important;
        border: 1.5px solid #e2e8f0 !important;
        border-radius: 10px !important;
        transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1) !important;
        box-sizing: border-box !important;
        display: block !important;
    }
    #menu_app_contenedor #aplicaciones article:hover {
        background-color: #ffffff !important;
        border-color: #7c121d !important;
        transform: translateY(-2px) !important;
        box-shadow: 0 4px 12px rgba(124, 18, 29, 0.08) !important;
    }

    /* Highlighted / Orange Favorite style */
    #menu_app_contenedor #aplicaciones article[style*="background-color:#ffe0c5"] {
        background-color: #fff7ed !important;
        border-color: #fed7aa !important;
    }
    #menu_app_contenedor #aplicaciones article[style*="background-color:#ffe0c5"]:hover {
        background-color: #ffffff !important;
        border-color: #7c121d !important;
    }

    /* Layout reset inside article */
    #menu_app_contenedor #aplicaciones article table {
        border-collapse: collapse !important;
        width: 100% !important;
        margin: 0 !important;
    }
    #menu_app_contenedor #aplicaciones article td {
        padding: 0 !important;
        vertical-align: middle !important;
        border: none !important;
    }
    #menu_app_contenedor #aplicaciones article td:first-child {
        width: 36px !important;
        text-align: center !important;
    }
    #menu_app_contenedor #aplicaciones article td:nth-child(2) {
        text-align: left !important;
        padding-left: 12px !important;
    }
    #menu_app_contenedor #aplicaciones article td:last-child {
        text-align: right !important;
        width: 24px !important;
    }

    /* Icon wrapper and image */
    .MisApps_backgroundIcon {
        width: 36px !important;
        height: 36px !important;
        display: inline-flex !important;
        align-items: center !important;
        justify-content: center !important;
        border-radius: 8px !important;
        background-color: #ffffff !important;
        border: 1px solid #e2e8f0 !important;
        box-shadow: 0 1px 3px rgba(0,0,0,0.02) !important;
        margin-right: 12px !important;
    }
    .MisApps_Icon {
        width: 20px !important;
        height: 20px !important;
        object-fit: contain !important;
        transition: transform 0.2s ease !important;
    }
    #menu_app_contenedor #aplicaciones article:hover .MisApps_Icon {
        transform: scale(1.1) !important;
    }

    /* Text Link and hover */
    #menu_app_contenedor #aplicaciones article td span {
        font-family: 'Inter', sans-serif !important;
        font-size: 13px !important;
        font-weight: 600 !important;
        color: #334155 !important;
    }
    #menu_app_contenedor #aplicaciones article td span a {
        color: #334155 !important;
        text-decoration: none !important;
        transition: color 0.2s ease !important;
    }
    #menu_app_contenedor #aplicaciones article:hover td span a {
        color: #7c121d !important;
    }

    /* Favorite Star icon */
    #menu_app_contenedor #aplicaciones article td img[src*="favorite"] {
        width: 18px !important;
        height: 18px !important;
        opacity: 0.3 !important;
        transition: all 0.2s ease !important;
    }
    #menu_app_contenedor #aplicaciones article td img[src*="favorite"]:hover {
        opacity: 1 !important;
        transform: scale(1.15) !important;
    }
    #menu_app_contenedor #aplicaciones article td img[src*="favorite1.png"] {
        opacity: 1 !important;
    }

    /* Icon Grid Mode (mode 2 & 4) */
    #app_iconos {
        display: grid !important;
        grid-template-columns: repeat(auto-fit, minmax(120px, 1fr)) !important;
        gap: 16px !important;
        padding: 20px !important;
        width: 100% !important;
        box-sizing: border-box !important;
    }
    #app_iconos article {
        background: #ffffff !important;
        border: 1px solid rgba(226, 232, 240, 0.8) !important;
        border-radius: 12px !important;
        padding: 16px 12px !important;
        text-align: center !important;
        box-shadow: 0 4px 10px rgba(0,0,0,0.02) !important;
        transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1) !important;
        box-sizing: border-box !important;
        width: 100% !important;
    }
    #app_iconos article:hover {
        transform: translateY(-2px) !important;
        box-shadow: 0 8px 20px rgba(124, 18, 29, 0.08) !important;
        border-color: #7c121d !important;
    }
    #app_iconos article a {
        color: #475569 !important;
        font-family: 'Inter', sans-serif !important;
        font-size: 11.5px !important;
        font-weight: 600 !important;
        text-decoration: none !important;
        display: block !important;
    }
    #app_iconos article a img {
        width: 36px !important;
        height: 36px !important;
        margin-bottom: 8px !important;
    }
    #app_iconos article:hover a {
        color: #7c121d !important;
    }
</style>

<?php
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
echo "<div id='menu_app_contenedor' >";
$c=0;
while($fc = $rc -> fetch_array())
{

        echo "<div id='aplicaciones' >
        <h4><i class='fa-solid fa-folder-open' style='color:var(--cd-gold); margin-right:6px;'></i> ".$fc['Categoria']."</h4>
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

                if ($MiApp == '0') { //Favorita activa
                    echo "<article style='background-color:#ffe0c5;'>";
                } else {// No Favorita
                    echo "<article>";
                }
                
            }
            echo "<table width=100%><tr>";

            $iconPath = "icon/" . $fap['Icono'];
            echo "<td align=center class='MisApps_backgroundIcon'>
            <a href='".$fap['URL']."' style='display:block; text-decoration:none;' title='".$fap['Title']."'>
              <img class='MisApps_Icon' src='".$iconPath."' onerror=\"this.onerror=null; this.src='icon/page.png';\" />
            </a></td>";
            echo "<td >";
            
            echo "<span title='".$fap['Title']."' style='font-size:8.5pt; cursor:pointer;'> <a style='display:block; text-decoration:none; color:#1e293b; font-weight:600; width:100%;' href='".$fap['URL']."'>".$fap['Label']."</a></span>";
            
            echo "</td>";

           
            if ($MiApp == 'NoR'){ //No registrada                
                echo "<td align=right><i class='fa-regular fa-star' title='Marcar como favorita' style='font-size:16px; color:#cbd5e1; cursor:pointer; transition:all 0.2s;' onclick='Favorite(`".$fap['IdApp']."`)'></i></td>";
            } else{
                if ($MiApp == '0') { //Favorita (activa)
                    echo "<td align=right><i class='fa-solid fa-star' title='Quitar de favoritas' style='font-size:16px; color:#f59e0b; cursor:pointer; filter:drop-shadow(0 2px 4px rgba(245,158,11,0.4)); transform:scale(1.1); transition:all 0.2s;' onclick='Favorite(`".$fap['IdApp']."`)'></i></td>";
                } else {// No Favorita
                    echo "<td align=right><i class='fa-regular fa-star' title='Marcar como favorita' style='font-size:16px; color:#cbd5e1; cursor:pointer; transition:all 0.2s;' onclick='Favorite(`".$fap['IdApp']."`)'></i></td>";
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
    
    $DivApps.= "<div id='menu_app_contenedor' >";

    
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