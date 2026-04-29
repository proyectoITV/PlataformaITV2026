<?php include("head.php"); ?>

<?php
//TOKENS
// $MiToken = MiToken($nitavu, "Users");
// if ($MiToken == ''){
//     $MiToken = MiToken_Init($nitavu, "Edit");
// }
// echo "Token: ".$MiToken;




include ("header.php");

?>


<?php

if (UserAdmin($nitavu)==TRUE){
    if (Preference("UsuariosForaneos", "", "") == "FALSE"){

        if (isset($_GET['i1'])){//Se actualizo correctamente
            Toast("Se actualizo correctamente a ".$_GET['i1'],1,"");
        }
        if (isset($_POST['BtnActualizar'])){
            $IdUser = VarClean($_POST['IdUser']);
            $RinteraLevel = 0;
            $UserName = VarClean($_POST['UserName']);
            $NIP = VarClean($_POST['NIP']);
            $sql = "UPDATE users SET RinteraLevel='".$RinteraLevel."', UserName='".$UserName."', NIP='".$NIP."' WHERE IdUser='".$IdUser."'";
            // echo $sql;

            if ($db0->query($sql) == TRUE)
                {
                    $page = "users.php?i1=".$IdUser;            
                    historia_rintera($nitavu, "Usuarios", "Actualizo al usuario".$IdUser." [SQL=".$sql."]");
                    LocationFull($page);

                }
                else {
                    // MiToken_Close($IdUser, $ElToken);             
                    Toast("Ha habido un Error al intentar actualizar",2,"");
                    // echo "Ha habido un error al intentar guardar tu reporte: <br>QUERY= <br>".$sql;
                }
       
        }



        if (isset($_GET['i2'])){//Se actualizo correctamente
            Toast("Se ha eliminado al usuario ".$_GET['i2'],1,"");
        }
        if (isset($_GET['x'])){
            $IdUser = VarClean($_GET['x']);
            if ($IdUser == 'admin'){
                Toast("No puedes eliminar al usuario admin",2,"");

            } else {
                $sql = "DELETE from users WHERE IdUser='".$IdUser."'";
                echo $sql;

                if ($db0->query($sql) == TRUE)
                    {
                        $page = "users.php?i2=".$IdUser;            
                        historia_rintera($nitavu, "Usuarios", "Elimino al usuario".$IdUser." [SQL=".$sql."]");
                        LocationFull($page);

                    }
                    else {
                        // MiToken_Close($IdUser, $ElToken);             
                        Toast("Ha habido un Error al intentar eliminar",2,"");
                        // echo "Ha habido un error al intentar guardar tu reporte: <br>QUERY= <br>".$sql;
                    }
            }
       
        }

        if (isset($_GET['id'])){
            $IdUser = VarClean($_GET['id']);
            $sql = "select * from users WHERE IdUser ='".$IdUser."'";
            $rc= $db0 -> query($sql);
            if($f = $rc -> fetch_array())
            {
                echo "<h3 style='text-align:center; color: #28a745;' class=''>
                
                Usuario: ".$IdUser." 
                
                </h3><br>";
                
                echo "
                <center>
                <form action='' method='POST' class='row container' style='
                background-color:#ececec;
                border-radius: 5px;
                padding: 5px;

                '>";
                echo "<input type='hidden' name='IdUser' value='".$IdUser."'>";
                echo "<div class='col-sm-4'><label>Nombre: <input class='form-control' type='text' name='UserName' value='".$f['UserName']."'></label></div>";
                
                // echo "<div class='col-sm-4'><label>Tipo: ";
                // echo "<select name='RinteraLevel' class='form-control'>";

                // if ($f['RinteraLevel']==0) {
                //     echo "<option value='' selected>No Definido</option>";
                //     echo "<option value='1' >Administrador</option>";
                //     echo "<option value='2' >Consulta</option>";
                // } else {
                //     if ($f['RinteraLevel']==1) {
                //         echo "<option value='1' selected>Administrador</option>";                    
                //         echo "<option value='2' >Consulta</option>";
                //     } else {
                //         echo "<option value='2' selected>Consulta</option>";
                //         echo "<option value='1' >Administrador</option>";                    

                //     }

                // }
                // echo "</select>";
                
                echo "</label></div>";
                echo "<div class='col-sm-4'><label>NIP: <input class='form-control' type='text' name='NIP' value='".$f['NIP']."'></label></div>";
                echo "<div class='col-sm-12'><label><br><input class='btn btn-success' type='submit' name='BtnActualizar' value='Actualizar' ></label></div>";
            
                echo "</form>
                </center>
                ";
                
            } else {
                echo "<p>ERROR: Usuario no localizado</p>";
            }


            
        }

        if (isset($_GET['new'])){



                if (isset($_GET['i3'])){//Se actualizo correctamente
                    Toast("Se creo el usuario = ".$_GET['i3'],1,"");
                }
                if (isset($_POST['BtnNew'])){
                    $IdUser = VarClean($_POST['IdUser']);
                    $RinteraLevel = 0;
                    $UserName = VarClean($_POST['UserName']);
                    $NIP = VarClean($_POST['NIP']);
                    $sql = "INSERT INTO users
                    (IdUser, UserName, RinteraLevel, NIP)
                    VALUES
                    ('".$IdUser."','".$UserName."','".$RinteraLevel."','".$NIP."')
                    ";
                    // echo $sql;
        
                    if ($db0->query($sql) == TRUE)
                        {
                            $page = "users.php?i3=".$IdUser;            
                            historia_rintera($nitavu, "Usuarios", "Creo Al Usuario al usuario".$IdUser." [SQL=".$sql."]");
                            LocationFull($page);
        
                        }
                        else {
                            // MiToken_Close($IdUser, $ElToken);             
                            Toast("Ha habido un Error al intentar actualizar",2,"");
                            // echo "Ha habido un error al intentar guardar tu reporte: <br>QUERY= <br>".$sql;
                        }
               
                }
        

            
        

            echo "
            <center>
            <h3>Crear nuevo usuario</h3><br>
            <form action='' method='POST' class='row container' style='
            background-color:#ececec;
            border-radius: 5px;
            padding: 5px;

            '>";
            
            echo "<div class='col-sm-4'><label>IdUser: <input class='form-control' type='text' name='IdUser' value='' required></label></div>";
            echo "<div class='col-sm-4'><label>Nombre: <input class='form-control' type='text' name='UserName' value='' required></label></div>";
            // echo "<div class='col-sm-4'><label>Tipo: ";
            // echo "<select name='RinteraLevel' class='form-control' required>";
            //     echo "<option value='' selected>No Definido</option>";
            //     echo "<option value='1' >Administrador</option>";
            //     echo "<option value='2' >Consulta</option>";
            // echo "</select>";
            
            // echo "</label></div>";
            echo "<div class='col-sm-4'><label>NIP: <input class='form-control' type='text' name='NIP' value='' required></label></div>";
            echo "<div class='col-sm-4'><label><br><input class='btn btn-success' type='submit' name='BtnNew' value='Guardar' ></label></div>";
            
            echo "</form>

            
            </center>
            ";

        } else {

        echo "<hr style='
        border: dashed 1px #bfbfbf;
        '><div class='container' style='
        background-color:#ececec;
            border-radius: 5px;
            padding: 5px;'>
        
        
        <h2 style='
        text-align: center;
        font-size: 17pt;
        background-color: #bdbdbd;
        color: white;
        border-top-left-radius: 4px;
        border-top-right-radius: 4px;
        '>
        <table border=0 width=100%>
        <tr><td align=center>
        <b>USUARIOS REGISTRADOS:</b>
        </td><td width=30px align=right>
        <a href='?new=' title='Haga clic aqui para agregar un nuevo usuario'>
        <img src='icons/user_add.png' style='width:32px;'>
        </a>

        </td>
        </tr>
        </table>
        
        </h2><br>";



        $sql ="
        SELECT
	IdUser,
	`rintera`.`users`.`UserName` AS `UserName`,

	concat( '<a href=\'?x=', `rintera`.`users`.`IdUser`, '\' title=\'Haga clic para Eliminar al Usuario\' class=\'btn btn-warning\'><img src=\'icons/x.png\' style=\'width:17px;\'></a>' ) AS `Eliminar` 
FROM
	`users`
        
        ";
        $IdTabla = "MiTabla";
        $Clase = "container ";
        $db= 0 ;        
        
        DynamicTable_MySQL($sql, "DivUsuarios", $IdTabla, $Clase, 0, $db);
        }
        echo "</div>";
    } else {
        echo "<p>La administración de usuarios se realiza en una base de datos externa!.</p>";
    }
    
} else {
    LocationFull("index.php");
}
?>



<?php include ("footer.php"); ?>