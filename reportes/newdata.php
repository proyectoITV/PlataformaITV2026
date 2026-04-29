<?php
require_once("rintera-config.php");
require("components.php");

$ElToken = VarClean($_POST['Token']);

$IdUser = VarClean($_POST['IdUser']);
$MiToken = MiToken($IdUser, "Nuevo");

$rep_name = VarClean($_POST['rep_name']);
$rep_descripcion = VarClean($_POST['rep_descripcion']);
// $rep_query = VarClean($_POST['rep_query']);
$rep_query = $_POST['rep_query'];
$db = VarClean($_POST['db']);
$Orientacion = VarClean($_POST['Orientacion']);
$PageSize = VarClean($_POST['PageSize']);
$Formato = VarClean($_POST['Formato']);

$var1 = VarClean($_POST['var1']);
$var1_type = VarClean($_POST['var1_type']);
$var1_label = VarClean($_POST['var1_label']);
$var1_sql = $_POST['var1_sql'];

$var2 = VarClean($_POST['var2']);
$var2_type = VarClean($_POST['var2_type']);
$var2_label = VarClean($_POST['var2_label']);
$var2_sql = $_POST['var2_sql'];

$var3 = VarClean($_POST['var3']);
$var3_type = VarClean($_POST['var3_type']);
$var3_label = VarClean($_POST['var3_label']);
$var3_sql = $_POST['var3_sql'];

$var1_IdCon = VarClean($_POST['var1_IdCon']);
$var2_IdCon = VarClean($_POST['var2_IdCon']);
$var3_IdCon = VarClean($_POST['var3_IdCon']);
// echo strlen($rep_query);
//VALIDACION DE CAPTURA
$OK = TRUE; $msg="";
if ($rep_name == '' or strlen($rep_name)<=5){$OK = FALSE; $msg= $msg."<li>El <b>nombre del reporte</b> requiere mas caracteres </li><script>$('#rep_name').css('background-color', '#ffeed8');</script>";}
if ($rep_descripcion == '' or strlen($rep_descripcion)<=20){$OK = FALSE; $msg= $msg."<li>Se necesita un minimo de 10 caractares para la <b>descripcion</b> </li> <script>$('#rep_description').css('background-color', '#ffeed8');</script>";}
if ($rep_query == '' or strlen($rep_query)<=5){$OK = FALSE; $msg= $msg."<li>Debes ingresar una <b>Consulta</b> en lenguaje SQL para MySQL </li> <script>$('#rep_query').css('border-color', 'rgb(223, 166, 93)');
    $('#rep_query').css('border-width', '4px');
    </script>";}

    // $ReporteIdUser = VarClean($_POST['ReporteIdUser']);
    // if ($ReporteIdUser == ''){$OK = FALSE; $msg= $msg."<li>Se requiere seleccionar un Administrador del Reporte</li><script>$('#ReporteIdUser').css('background-color', '#ffeed8');</script>";}
    

// var_dump($var1_sql);
if ($var1_type  == 'option' AND $var1_sql ==''){$OK = FALSE; 
    $msg= $msg."<li>Usaste Lista Desplegable en la Variable {var1}. DEBES LLENAR UN QUERY EN SQL con resultado value y data</li>
    <script>$('#var1_sql').css('background-color', '#ffeed8');</script>";
}


if ($var2_type  == 'option' AND $var2_sql ==''){$OK = FALSE; 
    $msg= $msg."<li>Usaste Lista Desplegable en la Variable {var2}. DEBES LLENAR UN QUERY EN SQL con resultado value y data</li>
    <script>$('#var2_sql').css('background-color', '#ffeed8');</script>";
}

if ($var3_type  == 'option' AND  $var3_sql ==''){$OK = FALSE; 
    $msg= $msg."<li>Usaste Lista Desplegable en la Variable {var3}. DEBES LLENAR UN QUERY EN SQL con resultado value y data</li>
    <script>$('#var3_sql').css('background-color', '#ffeed8');</script>";
}

if ($var1_type  == 'option' AND  $var1_IdCon ==''){$OK = FALSE; 
    $msg= $msg."<li>Usaste Lista Desplegable en la Variable {var1}. DEBES Seleccionar una base de datos</li>
    <script>$('#var1_IdCon').css('background-color', '#ffeed8');</script>";
}

if ($var2_type  == 'option' AND  $var2_IdCon ==''){$OK = FALSE; 
    $msg= $msg."<li>Usaste Lista Desplegable en la Variable {var2}. DEBES Seleccionar una base de datos</li>
    <script>$('#var2_IdCon').css('background-color', '#ffeed8');</script>";
}

if ($var3_type  == 'option' AND  $var3_IdCon ==''){$OK = FALSE; 
    $msg= $msg."<li>Usaste Lista Desplegable en la Variable {var3}. DEBES Seleccionar una base de datos</li>
    <script>$('#var3_IdCon').css('background-color', '#ffeed8');</script>";
}


if ($OK ==TRUE){
    //Listo empezamos a trabajar

    //Validar las var

    //Insertar 
    
    $sql = "INSERT INTO reportes
    (
        
        rep_name,
        sql1,
        sql2,
        sql3,
        rep_description,
        IdUser,
        fecha,
        hora,
        orientacion,
        estado,
        solicitante,
        IdCon,
        PageSize,
        out_type,
        var1,
        var1_type,
        var1_label,
        var2,
        var2_type,
        var2_label,
        var3,
        var3_type,
        var3_label,
        var1_sql,
        var2_sql,
        var3_sql, admin,
        var1_Idcon, var2_IdCon, var3_IdCon

    )

   VALUES (
    '".$rep_name."', 
    '".$rep_query."', 
    '', 
    '', 
    '".$rep_descripcion."', 
    '".$IdUser."', 
    '".$fecha."', 
    '".$hora."', 
    '".$Orientacion."', 
    '1', 
    '".$IdUser."',
    '".$db."',
    '".$PageSize."',
    '".$Formato."',
    '".$var1."',
    '".$var1_type."',
    '".$var1_label."',
    '".$var2."',
    '".$var2_type."',
    '".$var2_label."',
    '".$var3."',
    '".$var3_type."',
    '".$var3_label."',
    '".$var1_sql."',
    '".$var2_sql."',
    '".$var3_sql."',
    '',
    '".$var1_IdCon."',
    '".$var2_IdCon."',
    '".$var3_IdCon."'    
    )";
    
    // echo $sql;
    // mensaje($sql,'login.php');

    echo "".$ElToken." | ".$MiToken;
    if (MiToken_valida($ElToken, $IdUser, "Nuevo")==TRUE){//Valido
        if ($db0->query($sql) == TRUE)
        {
            $page = "index.php?q=".$rep_name."&i1=";
            MiToken_Close($IdUser, $ElToken);    
            historia_rintera($IdUser, "NUEVO", "Creo el Reporte ".$rep_name." [SQL=".$sql."]");
            LocationFull($page);
        }
        else {
            // MiToken_Close($IdUser, $ElToken);             
            echo "Ha habido un error al intentar guardar tu reporte: <br>QUERY= <br>".$sql;
        }
    } else {
        // MiToken_Close($IdUser, $ElToken);             
        echo "Ha habido un error, vuelva a intentarlo.";
    }
} else {
    Toast("Te faltan algunos datos",2,"");
    // MiToken_Close($IdUser, $ElToken);             
    echo "<div>Por favor llena los siguientes datos: <ul>".$msg."</ul></div>";
}


                  

//Hay que cerrar el Token
?>