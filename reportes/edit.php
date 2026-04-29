<?php     include("head.php"); ?>
<div id='PreLoader'>
    <div id='Loader'>
        <img src='img/loader_classic.gif'><br>      
    </div>
</div>


<?php
//TOKENS
$MiToken = MiToken($nitavu, "Edit");
// if ($MiToken == ''){
//     $MiToken = MiToken_Init($nitavu, "Edit");
// }
// echo "Token: ".$MiToken;


$id_rep = VarClean($_GET['id']);

include ("header.php");

?>


<?php
if (UserAdmin($nitavu)==TRUE){
  if (isset($_GET['id'])){
    $IdRep = VarClean($_GET['id']);
  }
  else {
    LocationFull("index.php");
  }
    

  $sql = "select * from reportes WHERE id_rep='".$IdRep."'";
  
  $rP= $db0 -> query($sql);  
  if($fRep = $rP -> fetch_array())
  {

echo "<center><h4>".$fRep['rep_name']."</h4>";
echo "<cite>".$fRep['rep_description']."</cite></center>";
echo "<div id='Respuesta' style='
// background-color: #fff7b3;
padding: 10px;
font-size: 8pt;
color: #573800;
margin-bottom: 11px;
margin: 10px;
border-radius: 5px;
display:none;
'>

</div>";
echo '
  <div class="accordion width" id="TabsReportes">
  <div class="card">
    <div class="card-header" data-toggle="collapse" data-target="#xcollapseOne" 
    style="
    background-color:#ecd3b5;
    cursor:pointer;
    "
   
    >';
echo '

Configuración de Reporte

</div>';

echo '
    <div id="xcollapseOne" class="collapse  width" data-parent="#TabsReportes" 
    style="
    background-color:rgb(244, 229, 211);
    cursor:pointer;
    box-shadow: inset 2px 26px 19px -20px rgba(0, 0, 0, 0.3);
"
    >
    <div class="card-body" style="

    ">';

      
   

    
   echo '
<div class="container-fluid"

>
    <div class="row">
        <div class="col-sm-8" style="" >
        
        ';

        echo "<br><label>Nombre del Reporte:</label>";
        echo "<input class='form-control' type='text' name='rep_name' id='rep_name' value='".$fRep['rep_name']."'>";

        echo "<br><label>Descripción del Reporte:</label>";
        echo "<input class='form-control' type='text' name='rep_description' id='rep_description' value='".$fRep['rep_description']."'>";

        echo '<br>
        <label>Consulta a la Base de Datos: (solo comillas dobles ) <br>
        
        <b>Ejemplo:</b> 
        <cite>select * from mitabla where parametro=<b style="color:blue">{var1}</b>  and otroparametro=1</cite>
        </label>
        <textarea  id="rep_query" rows=10 style="background-color: #272822;
        color: #cccc82;"
        class="Query form-control">'.$fRep['sql1'].'</textarea>
        ';

        
        echo "<br><label>¿Que base de datos usara la consulta? </label> <select id='db' class='form-control' name='db'>";      
        
        $r= $db0 -> query("select * from dbs where Active=1");    
        while($finfo = $r -> fetch_array()) {   
            echo "<option value='".$finfo['IdCon']."'>".$finfo['ConName']."</opion>";
        }
        echo "<option style='background-color:orange;color:white;' 
        value='".$fRep['IdCon']."' selected>".ConName($fRep['IdCon'])."</opion>";
        echo "</select>";
        unset($r); unset($finfo);
        


        echo "<br><label>Orientación</label><br>";
        
        echo "<select name='Orientacion' class='form-control' id='Orientacion'>";
        if ($fRep['orientacion']=='L'){
            echo "<option value='L' selected>Horizontal</option>";
        } else {
            echo "<option value='L'>Horizontal</option>";
        }

        if ($fRep['orientacion']=='P'){
            echo "<option value='P' selected>Vertical</option>";
        } else {
            echo "<option value='P'>Vertical</option>";
        }

        
        
        
        echo "</select>";

        echo "<br><label>Tamaño de Pagina</label><br>";
        echo "<select name='PageSize' class='form-control' id='PageSize'>";
        if ($fRep['PageSize']=='0'){
            echo "<option value='0' selected>Carta</option>";
        } else {
            echo "<option value='0'>Carta</option>";
        }


        if ($fRep['PageSize']=='1'){
            echo "<option value='1' selected>Oficio</option>";
        } else {
            echo "<option value='1'>Oficio</option>";
        }



        
        echo "</select>
        
        
        
        ";
        
        echo '
        </div>
        <div class="col-sm-4" 
        style="
        background-color: #eef0f04f;
        height:100%;
        "
        >
        <center><b style="color: #ff7800;
        font-size: 10pt;">Configuracion de las variables:</b></center>
        <div id="accordion">
        <div class="card">
        <div class="card-header DivVar1" id="headingOne">
            <h5 class="mb-0">
            <button class="btn btn-link" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne"
            style="
                display: block;
                width: 100%;
            "
            >
                {var1}
            </button>
            </h5>
        </div>
    
        <div id="collapseOne" style="background-color:rgb(218, 220, 221);"
         class="collapse " aria-labelledby="headingOne" data-parent="#accordion">
            <div class="card-body">
            
            <br><label>¿Utilizaras var1?</label>
            <select name="var1" class="form-control"  style="background-color:orange; color:white;" id="var1" onclick="Var1_ON();">
            ';
            if ($fRep['var1']=='0'){
                echo '<option value="0" selected>NO</option>';
            } else {
                echo '<option value="0" >NO</option>';
            }
            if ($fRep['var1']=='1'){
                echo '<option value="1" selected>SI</option>';
               
            } else {
                echo '<option value="1" >SI</option>';
            }
            


            echo '
            </select>';

            echo '
            <script>
                function Var1_ON(){
                    Var1 =  $("#var1").val();
                    console.log(Var1);
                    if ( Var1 == 1 ){
                        $(".DivVar1").css("background-color", "#bbdb76");                
                    } else {
                        $(".DivVar1").css("background-color", "white");                
                    }
                }
                Var1_ON();

            </script>';

            echo '
            

            <br><label>Tipo:</label>
            <select name="var1_type"  id="var1_type" class="form-control" onclick="Activardb1();">';

            
            if ($fRep['var1_type']=='text'){
                echo '<option value="text" selected>Texto</option>';
            } else {
                echo '<option value="text" >Texto</option>';
            }

            if ($fRep['var1_type']=='number'){
                echo '<option value="number" selected>Numero</option>';
            } else {
                echo '<option value="number" >Numero</option>';
            }

            if ($fRep['var1_type']=='date'){
                echo '<option value="date" selected>Fecha</option>';
            } else {
                echo '<option value="date" >Fecha</option>';
            }

            if ($fRep['var1_type']=='option'){
                echo '<option value="option"  selected>Lista desplegable</option>';
            } else {
                echo '<option value="option">Lista desplegable</option>';
            }

            

            echo '
          
            </select>';

            


            echo "<span id='db1'><br><label>¿Desde que base de datos? </label> <select id='var1_IdCon' class='form-control' name='var1_IdCon'>";      
        
            $rg= $db0 -> query("select * from dbs where Active=1");    
            while($finfo = $rg -> fetch_array()) {   
                echo "<option value='".$finfo['IdCon']."'>".$finfo['ConName']."</opion>";
            }
            echo "<option style='background-color:orange;color:white;' 
            value='".$fRep['var1_IdCon']."' selected>".ConName($fRep['var1_IdCon'])."</opion>";
            echo "</select></span>";
            unset($rg); unset($finfo);
            
    

            echo '




            <br><label>Texto para mostrar:</label>';

            echo '
            <input type="text" class="form-control" name="var1_label" id="var1_label" value="'.$fRep['var1_label'].'">

            <br><label>Consulta de llenado (MySQL): <cite>Los controles buscaran value y data, tomalo en cuenta</cite></label>
            <textarea name="var1_sql" id="var1_sql" class="Query form-control" style="background-color: #c3c6b1;
            color: #304a4d;">'.$fRep['var1_sql'].'</textarea>';

            echo '
            <script>
            function Activardb1(){
                // console.log($("#var1_type option:selected").val());
                if ($("#var1_type option:selected").val() == "option"){
                    $("#db1").show();
                } else {
                    $("#db1").hide();
                }    
                
            }
            Activardb1();
            </script>
            ';


            echo '






            </div>
        </div>
        </div>


        <div class="card">
        <div class="card-header DivVar2" id="headingTwo">
            <h5 class="mb-0">
            <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo"
            style="
                display: block;
                width: 100%;
            "
            >
                {var2}
            </button>
            </h5>
        </div>
        <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordion" style="background-color:rgb(218, 220, 221);">
            <div class="card-body">

            <br><label>¿Utilizaras var2?</label>
            <select name="var1" class="form-control"  style="background-color:orange; color:white;" id="var2" onclick="Var2_ON();">
            ';
            if ($fRep['var2']=='0'){
                echo '<option value="0" selected>NO</option>';
            } else {
                echo '<option value="0" >NO</option>';
            }
            if ($fRep['var2']=='1'){
                echo '<option value="1" selected>SI</option>';
            } else {
                echo '<option value="1" >SI</option>';
            }
            
            echo '
            </select>';

            echo '
            <script>
                function Var2_ON(){
                    Var2 =  $("#var2").val();
                    console.log(Var2);
                    if ( Var2 == 1 ){
                        $(".DivVar2").css("background-color", "#bbdb76");                
                    } else {
                        $(".DivVar2").css("background-color", "white");                
                    }
                }
                Var2_ON();

            </script>';

            echo '
            

            <br><label>Tipo:</label>
            <select name="var2_type"  id="var2_type" class="form-control"  onclick="Activardb2();">';

            
            if ($fRep['var2_type']=='text'){
                echo '<option value="text" selected>Texto</option>';
            } else {
                echo '<option value="text" >Texto</option>';
            }

            if ($fRep['var2_type']=='number'){
                echo '<option value="number" selected>Numero</option>';
            } else {
                echo '<option value="number" >Numero</option>';
            }

            if ($fRep['var2_type']=='date'){
                echo '<option value="date" selected>Fecha</option>';
            } else {
                echo '<option value="date" >Fecha</option>';
            }

            if ($fRep['var2_type']=='option'){
                echo '<option value="option" selected>Lista desplegable</option>';
            } else {
                echo '<option value="option" >Lista desplegable</option>';
            }

            echo "</select>";

            echo "<span id='db2'><br><label>¿Desde que base de datos? </label> 
            <select id='var2_IdCon' class='form-control' name='var2_IdCon''>";      
        
            $rg= $db0 -> query("select * from dbs where Active=1");    
            while($finfo = $rg -> fetch_array()) {   
                echo "<option value='".$finfo['IdCon']."'>".$finfo['ConName']."</opion>";
            }
            echo "<option style='background-color:orange;color:white;' 
            value='".$fRep['var2_IdCon']."' selected>".ConName($fRep['var2_IdCon'])."</opion>";
            echo "</select></span>";
            unset($rg); unset($finfo);

            echo '
            <script>
            function Activardb2(){
                // console.log($("#var1_type option:selected").val());
                if ($("#var2_type option:selected").val() == "option"){
                    $("#db2").show();
                } else {
                    $("#db2").hide();
                }    
                
            }
            Activardb2();
            </script>
            ';

            echo '
          
           

            <br><label>Texto para mostrar:</label>';

            echo '
            <input type="text" class="form-control" name="var2_label" id="var2_label" value="'.$fRep['var2_label'].'">

            <br><label>Consulta de llenado (MySQL): <cite>Los controles buscaran value y data, tomalo en cuenta</cite></label>
            <textarea name="var2_sql" id="var2_sql" class="Query form-control" style="background-color: #c3c6b1;
            color: #304a4d;">'.$fRep['var2_sql'].'</textarea>








            </div>
        </div>
        </div>
        <div class="card">
        <div class="card-header DivVar3" id="headingThree">
            <h5 class="mb-0">
            <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree"
            style="
                display: block;
                width: 100%;
            "
            >
                {var3}
            </button>
            </h5>
        </div>
        <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordion" style="background-color:rgb(218, 220, 221);"> 
            <div class="card-body">
            <br><label>¿Utilizaras var3?</label>
            <select name="var3" class="form-control"  style="background-color:orange; color:white;" id="var3" onclick="Var3_ON();">
            ';
            if ($fRep['var3']=='0'){
                echo '<option value="0" selected>NO</option>';
            } else {
                echo '<option value="0" >NO</option>';
            }
            if ($fRep['var3']=='1'){
                echo '<option value="1" selected>SI</option>';
            } else {
                echo '<option value="1" >SI</option>';
            }
            
            echo '
            </select>';

            echo '
            <script>
                function Var3_ON(){
                    Var3 =  $("#var3").val();
                    console.log(Var3);
                    if ( Var3 == 1 ){
                        $(".DivVar3").css("background-color", "#bbdb76");                
                    } else {
                        $(".DivVar3").css("background-color", "white");                
                    }
                }
                Var3_ON();

            </script>';

            echo '
            

            <br><label>Tipo:</label>
            <select name="var3_type"  id="var3_type" class="form-control" onclick="Activardb3();">';

            
            if ($fRep['var3_type']=='text'){
                echo '<option value="text" selected>Texto</option>';
            } else {
                echo '<option value="text" >Texto</option>';
            }

            if ($fRep['var3_type']=='number'){
                echo '<option value="number" selected>Numero</option>';
            } else {
                echo '<option value="number" >Numero</option>';
            }

            if ($fRep['var3_type']=='date'){
                echo '<option value="date" selected>Fecha</option>';
            } else {
                echo '<option value="date" >Fecha</option>';
            }

            if ($fRep['var3_type']=='option'){
                echo '<option value="option" selected>Lista desplegable</option>';
            } else {
                echo '<option value="option" >Lista desplegable</option>';
            }
            echo "</select>";
            
            echo "<span id='db3'><br><label>¿Desde que base de datos? </label>
             <select id='var3_IdCon' class='form-control' name='var3_IdCon' >";      
        
            $rg= $db0 -> query("select * from dbs where Active=1");    
            while($finfo = $rg -> fetch_array()) {   
                echo "<option value='".$finfo['IdCon']."'>".$finfo['ConName']."</opion>";
            }
            echo "<option style='background-color:orange;color:white;' 
            value='".$fRep['var3_IdCon']."' selected>".ConName($fRep['var3_IdCon'])."</opion>";
            echo "</select></span>";
            unset($rg); unset($finfo);


            echo '
            <script>
            function Activardb3(){
                // console.log($("#var1_type option:selected").val());
                if ($("#var3_type option:selected").val() == "option"){
                    $("#db3").show();
                } else {
                    $("#db3").hide();
                }    
                
            }
            Activardb3();
            </script>
            ';

            echo '
          
           

            <br><label>Texto para mostrar:</label>';

            echo '
            <input type="text" class="form-control" name="var3_label" id="var3_label" value="'.$fRep['var3_label'].'">

            <br><label>Consulta de llenado (MySQL): <cite>Los controles buscaran value y data, tomalo en cuenta</cite></label>
            <textarea name="var3_sql" id="var3_sql" class="Query form-control" style="background-color: #c3c6b1;
            color: #304a4d;">'.$fRep['var3_sql'].'</textarea>









            </div>
        </div>
        </div>

        
    </div>';
    echo "<br><label>Formato:</label><br>";
    echo "<select name='Formato' id='Formato' class='form-control'>";
    echo "<option value='0'>HTML</option>";
    echo "<option value='1'>DataTable</option>";
    echo "<option value='2'>PDF</option>";
    echo "<option value='3'>Excel</option>";
    echo "<option value='4'>Word</option>";


    switch ($fRep['out_type']) {
        case 0:
            echo "<option value='0' selected >HTML</option>";
            break;
        case 1:
            echo "<option value='1' selected>DataTable</option>";
            break;
        case 2:
            echo "<option value='2' selected>PDF</option>";
            break;
        case 3:
            echo "<option value='3' selected>Excel</option>";
            break;
        case 4:
            echo "<option value='4' selected>Word</option>";
            break;
    }


    
    echo "</select>";




    // if ($UsuariosForaneaos == "FALSE"){
    //     echo "<br><label>Usuario Administrador: <a href='users.php' title='Haga clic para administrar los usuarios'><img src='icons/user_add.png' style='width:17px;'></a></label><br>";
    //     echo "<select name='ReporteIdUser' id='ReporteIdUser' class='form-control'>";
    //     echo "<option value=''>Seleccione</option>";         
    // } else {    
    //     echo "<br><label>Usuario Administrador: </label><br>";
    //     echo "<select name='ReporteIdUser' id='ReporteIdUser' class='form-control'>";
    //     echo "<option value=''>Seleccione</option>";        
    // }
       

    // if ($UsuariosForaneaos == "FALSE") {
    //     $sql = "select * from users";
    // } else {
    //     $sql = $QueryUsuariosForaneos . " order by UserName";
    // }
    // echo $sql;
    // $rc = $dbUser->query($sql); 
    // $SelUser_IdUser = "";
    // $SelUser_Name = "";
    // if ($dbUser->query($sql) == TRUE){
    //     // echo "OK";
    //     while($fu= $rc -> fetch_array()) {   
    //         echo "<option value='".$fu['IdUser']."' title='IdUser=".$fu['IdUser']."'>".$fu['UserName']."</option>";
    //         if ($fu['IdUser']==$fRep['admin']){
    //             $SelUser_IdUser = $fu['IdUser'];
    //             $SelUser_Name = $fu['UserName'];
    //         }
    //     }
        
    //     echo "<option value='".$SelUser_IdUser."' title='IdUser seleccionado=".$SelUser_IdUser."' selected>".$SelUser_Name."</option>";

    // } else {
    //     Toast("ERROR al obtener la lista de usuarios",3,"");
    // }

    

    
    
    
    // echo "</select>";


    echo '
        <br><br><br>';
        echo "
        <script>
        
        function SendData(){   
            var rep_name = $('#rep_name').val();
            var rep_descripcion = $('#rep_description').val();
            var rep_query = $('#rep_query').val();
            var db = $('#db').val();
            var Orientacion = $('#Orientacion').val();
            var PageSize = $('#PageSize').val();
            var Formato = $('#Formato').val();

            //Var1
            var var1 = $('#var1').val();
            var var1_type = $('#var1_type').val();
            var var1_label = $('#var1_label').val();
            var var1_sql = $('#var1_sql').val();


            //Var2
            var var2 = $('#var2').val();
            var var2_type = $('#var2_type').val();
            var var2_label = $('#var2_label').val();
            var var2_sql = $('#var2_sql').val();


            //Var3
            var var3 = $('#var3').val();
            var var3_type = $('#var3_type').val();
            var var3_label = $('#var3_label').val();
            var var3_sql = $('#var3_sql').val();


            var var1_IdCon = $('#var1_IdCon').val();
            var var2_IdCon = $('#var2_IdCon').val();
            var var3_IdCon = $('#var3_IdCon').val();

            var ReporteIdUser = $('#ReporteIdUser').val();

            

            


            $('#PreLoader').show();
            $.ajax({
                url: 'editdata.php',
                type: 'post',        
                data: {IdUser:'".$nitavu."', Token: '".$MiToken."', IdRep:'".$IdRep."',
                    ReporteIdUser: ReporteIdUser,
                    rep_name: rep_name,
                    rep_descripcion: rep_descripcion,
                    rep_query: rep_query,
                    db: db,
                    Orientacion: Orientacion,
                    PageSize: PageSize,
                    var1:var1,
                    var1_type:var1_type,
                    var1_label:var1_label,
                    var1_sql:var1_sql,

                    var2:var2,
                    var2_type:var2_type,
                    var2_label:var2_label,
                    var2_sql:var2_sql,

                    var3:var3,
                    var3_type:var3_type,
                    var3_label:var3_label,
                    var3_sql:var3_sql,
                    Formato:Formato,

                    var1_IdCon: var1_IdCon,
                    var2_IdCon: var2_IdCon,
                    var3_IdCon: var3_IdCon,
                    ReporteIdUser:ReporteIdUser


        
                },
                success: function(data){                    
                    $('#Respuesta').html(data);
                    $('#Respuesta').show();
                    $('#PreLoader').hide();
                }
            });
            
        }
        
        
        </script>
        ";

        
        // if (MiToken_valida($MiToken, $nitavu, "Nuevo")==TRUE){//Valido
            echo '
                <center><button class="Mbtn btn-Primary" style="font-size:13pt;font-family:ExtraBold" onclick="SendData();">Actualizar</button></center>
                ';
        
        // } else { //No Valido
            

        // }
    
    echo '
        <br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
        </div>
    </div>
</div>';

echo '  </div>
</div>
</div>';


echo '
<div class="card">
    <div class=" card-r" data-toggle="collapse" data-target="#UsuariosThis"
    style="
        padding: 0.75rem 1.25rem;
        background-color: #bbd1d9;
        color: #4b7180;
        cursor: pointer;
        "
    >';
    echo '

Usuarios de éste Reporte
    
    
    ';
    echo '</div>';

    echo '<div id="UsuariosThis" class="collapse  width" data-parent="#TabsReportes"
        style="
            background-color: #d9e7ec;
            box-shadow: inset 2px 26px 19px -20px rgba(0, 0, 0, 0.3);
        "
        >';
        echo '<div class="card-body">';

        echo "<table class='tabla' id='TablaUser'>";
        $sqlU="
        SELECT
        a.nitavu AS IdUser,
        a.nombre AS UserName
        ,( SELECT count(*) FROM reportes_permisos WHERE id_rep = '".$id_rep."' AND IdUser = a.nitavu )  as Permiso
            FROM
                empleados a
            WHERE
                estado = ''
       
        ";
        // echo $sqlU;
        echo "
        <thead>
        <tr>
      
        <th>Usuario</th>       
        <th>Permiso</th>
        <th>Acceso</th>
        
        </tr>
        </thead>
        <tbody>
        ";

        $rU= $db0 -> query($sqlU);    
        while($fU = $rU -> fetch_array()) {   
            if ($fU['Permiso']==1){
                echo "<tr style='background-color:green;' id='Lin_".$fU['IdUser']."'>";
            } else {
                echo "<tr id='Lin_".$fU['IdUser']."'>";
            }
            // echo "<td width=50px>";
            // echo "<img src='https://plataformaitavu.tamaulipas.gob.mx/ws/fotos/".$fU['IdUser'].".jpg' class='FotoUser'>";
            // echo "</td>";
            echo "<td style='font-size:11pt;'>".$fU['UserName']."</td>";
            echo "<td style='font-size:11pt;'>";
            if ($fU['Permiso']==1){ 
                echo "<span id='Etiqueta_".$fU['IdUser']."'>Con Acceso</span>";            
            } else {
                echo "<span id='Etiqueta_".$fU['IdUser']."'></span>";      
            }
            echo "</td>";
            echo "<td>";
            echo '
                <div class="custom-control custom-switch col-sm-6 " style="cursor:pointer;">';
                if ($fU['Permiso']==1){
                    echo '
                    <input   style="cursor:pointer;" type="checkbox" class="custom-control-input" id="ChecU_'.$fU['IdUser'].'" onclick="Permitir('.$id_rep.',`'.$fU['IdUser'].'`);" checked="">
                    <label  style="cursor:pointer;" class="custom-control-label" for="ChecU_'.$fU['IdUser'].'"></cite></label>';
                } else {
                    echo '
                    <input  style="cursor:pointer;" type="checkbox" class="custom-control-input" id="ChecU_'.$fU['IdUser'].'" onclick="Permitir('.$id_rep.',`'.$fU['IdUser'].'`);" >
                    <label   style="cursor:pointer;" class="custom-control-label" for="ChecU_'.$fU['IdUser'].'"></label>';
                }
            echo ' </div>';
            echo "</td>";
            echo "</tr>";
            
        }
        echo "</tbody ></table>";
        echo "
        <script>
        $(document).ready(function() {
            $('#TablaUser').DataTable();
        } );
        </script>";



        echo '</div>';
    echo '</div>';
echo '</div>';



echo '
<div class="card">
    <div class=" card-r " data-toggle="collapse" data-target="#Estadistica"
    style="
        padding: 0.75rem 1.25rem;
        background-color: #b1dfb0;
        color: #45773a;
        cursor: pointer;
        "
    >';
    echo '
    
Estadistica del Reporte
    
    ';
    echo '</div>';

    echo '<div id="Estadistica" class="collapse  show width" data-parent="#TabsReportes"
        style="
            background-color: #d3ead2;
            box-shadow: inset 2px 26px 19px -20px rgba(0, 0, 0, 0.3);
            padding-bottom:100%;
        "
        >';
        echo '<div class="card-body">';
            
            $QueryEstadistica = "
            SELECT 
                (select count(*) from historia_rintera WHERE IdApp='VIO' and Descripcion='".$id_rep."') as Vistas,
                (select count(*) from historia_rintera WHERE IdApp='VIO' and Descripcion='".$id_rep."' and IdUser='".$nitavu."') as MisVistas,
                (select count(DISTINCT IdUser) from historia_rintera WHERE IdApp='VIO' and Descripcion='".$id_rep."') as Usuarios,
                (select IdUser  from historia_rintera WHERE IdApp='VIO' and Descripcion='".$id_rep."' order by fecha DESC, hora DESC
                limit 1) as UltimoUsuario,
                (select CONCAT(fecha,' a las ',hora, 'hr')  from historia_rintera WHERE IdApp='VIO' and Descripcion='".$id_rep."' 
                order by fecha DESC, hora DESC limit 1) as UltimaVisita
                
            ";
            // echo $QueryEstadistica;
            $r= $db0 -> query($QueryEstadistica);    
            echo "<table class='tabla' style='
            
            font-size: 11pt;
            padding: 10px;
            background-color: #0eb02f;            
            border-radius: 12px;
            '>";
            while($fe = $r -> fetch_array()) {   
                
                echo "<tr><td align=right>Visitas</td><td align=left>".$fe['Vistas']."</td></tr>";
                echo "<tr><td align=right>Mis Visitas</td><td align=left>".$fe['MisVistas']."</td></tr>";
                echo "<tr><td align=right>Usuarios</td><td align=left>".$fe['Usuarios']."</td></tr>";
                echo "<tr><td align=right>Ultimo Usuario que visito</td><td align=left>".$fe['UltimoUsuario']."</td></tr>";
                echo "<tr><td align=right>La Ultima Visita</td><td align=left>".$fe['UltimaVisita']."</td></tr>";
                
            }
            echo "</table>";
            unset($r); unset($fe);
           
            $QueryEstadistica2 = "
            SELECT
                a.fecha,
                a.hora,
                ifnull(( SELECT CONCAT( nombre, ' (', nitavu, ')' ) FROM empleados WHERE nitavu = a.IdUser ), 'Sin Registro de Usuario' ) AS UserName,
                a.IdUser 
            FROM
                historia_rintera a 
            WHERE
                IdApp = 'VIO' 
                AND Descripcion = '".$id_rep."' 
            ORDER BY
                fecha DESC,
                hora DESC 
                LIMIT 1000
            ";
            // echo $QueryEstadistica2;
            $r= $db0 -> query($QueryEstadistica2);    
            echo "<br>
            <h5>Ultimas 1000 Visitas:</h5>
            <table class='tabla'>";
            while($fe = $r -> fetch_array()) {   
                
                echo "<tr>";
                echo "<td width=50px>";
                    echo $fe['IdUser'];
                echo "</td>";
                echo "<td>".fecha_larga($fe['fecha'])."</td>";
                echo "<td>".hora12($fe['hora'])."</td>";
                echo "<td>".$fe['UserName']."</td>";

                echo "</tr>";
                
            }
            echo "</table>";
            unset($r); unset($fe);
        echo '</div>';
    echo '</div>';
echo '</div>';


    //echo "</form>";
} else {
    // Toast("No se ha localizado tu Reporte ".$IdRep,2,"");
    LocationFull("index.php?e1=".$IdRep."");
}
    
} else {
    LocationFull("index.php");
}
?>
<!-- <script>
const horizontalAccordions = $(".accordion.width");

horizontalAccordions.each((index, element) => {
	const accordion = $(element);
  const collapse = accordion.find(".collapse");
  const bodies = collapse.find("> *");
  accordion.height(accordion.height());  
  bodies.width(bodies.eq(0).width());
  collapse.not(".show").each((index, element) => {
  	$(element).parent().find("[data-toggle='collapse']").addClass("collapsed");
  });
});
</script> -->

<script>
function Permitir(id_rep,IdUser){

    $('#PreLoader').show();
            $.ajax({
                url: 'userpermisos_data.php',
                type: 'post',
                data: {
                    id_rep: id_rep,                    
                    IdUserAdmin: '<?php echo $nitavu; ?>',
                    IdUser:IdUser
                },
                success: function(data) {
                    $('#R').html(data);
                   
                    $('#PreLoader').hide();
                }
            });
    
}

</script>

<?php include ("footer.php"); ?>