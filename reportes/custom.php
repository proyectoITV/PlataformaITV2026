<?php include("head.php"); ?>
<div id='PreLoader'>
    <div id='Loader'>
        <img src='img/loader_classic.gif'><br>
    </div>
</div>


<?php
//TOKENS
$MiToken = MiToken($nitavu, "Custom");


include("header.php");

?>



<?php
//     echo '
//     <!-- Default switch -->
// <div class="custom-control custom-switch">
//   <input type="checkbox" class="custom-control-input" id="customSwitches">
//   <label class="custom-control-label" for="customSwitches">Toggle this switch element</label>
// </div>
//     ';


if (UserAdmin($nitavu) == TRUE) {
    echo "<center>";
    echo "<h4 style='
    background-color: ".Preference("ColorSecundario", "", "").";
    padding: 7px;
    '>Preferencias de Rintera</h4>";

    $sql = "select * from dbs";
    $r = $db0->query($sql);
    echo '<div id="accordion" class="Panel" 
    style="
        background-color: #f0f0f0;
        padding: 10px;
    "
    >';
    echo '<h6 style="
    font-weight:bold;
    ">Configuracion de Origen de Datos:</h6>';


    $checked = '';
    $txt_checked = '';
    while ($f = $r->fetch_array()) {
        if ($f['Active'] == 1) {
            $Color = '#d3f0cf';
        } else {
            $Color = '#f4f4f4';
        }
        $IdCard = 'Card' . $f['IdCon'];
        $IdCollapsed = 'Coll' . $f['IdCon'];
        if ($f['ConType'] == 0) {
            $btnText = '<table width=100% border=0><tr><td width=20px align=left><img  title="Base de Datos MYSQL | Rintera" src="icons/dbr.png" style="width:20px"></td><td
            id ="Tit_' . $f['IdCon'] . '"
            >[' . $f['IdCon'] . '] ' . $f['ConName'] . '</td></tr></table>';
        }

        if ($f['ConType'] == 1) {
            $btnText = '<table width=100% border=0><tr><td width=20px align=left><img title="Base de Datos MYSQL" src="icons/db.png" style="width:20px"></td><td
            id ="Tit_' . $f['IdCon'] . '"
            >[' . $f['IdCon'] . '] ' . $f['ConName'] . '</td></tr></table>';
        }

        if ($f['ConType'] == 2) {
            $btnText = '<table width=100% border=0><tr><td width=20px align=left><img title="WebService" src="icons/ws.png" style="width:20px"></td><td
            id ="Tit_' . $f['IdCon'] . '"
            >[' . $f['IdCon'] . '] ' . $f['ConName'] . '</td></tr></table>';
        }


        if ($f['ConType'] == 3) {
            $btnText = '<table width=100% border=0><tr><td width=20px align=left><img title="WebService: Rintera SQLSERVER-toJSON ASP" src="icons/wsms.png" style="width:20px"></td><td
            id ="Tit_' . $f['IdCon'] . '"
            >[' . $f['IdCon'] . '] ' . $f['ConName'] . '</td></tr></table>';
        }

        if ($f['Active'] == 1) {
            $checked = 'checked';
            $txt_checked = 'Desactivar';
        } else {
            $checked = '';
            $txt_checked = 'Activar';
        }
        $ContenidoDelCard = '
            <form action="" method="">
            <div class="row ">
                <div class="custom-control custom-switch col-sm-6 ">
                    <input type="checkbox" class="custom-control-input" id="Active_' . $f['IdCon'] . '" 
                    onclick="Active(' . $f['IdCon'] . ');" ' . $checked . '
                    >
                    <label 
                    onclick="Active(' . $f['IdCon'] . ');"
                    class="custom-control-label" for="Active_' . $f['IdCon'] . '">' . $txt_checked . '</label>
                </div>

                <div class="col-sm-6 form-group">
                    <label class="" for="ConName_' . $f['IdCon'] . '" >Etiqueta:</label>
                    <input class="form-control" type="text" name="ConName_' . $f['IdCon'] . '" id="ConName_' . $f['IdCon'] . '"
                    title="Con este nombre podras identificar esta conección"
                    onkeypress="ActTit(' . $f['IdCon'] . ');"
                    value="' . $f['ConName'] . '"
                    >
                </div>
            
            </div>';
        $ContenidoDelCard =  $ContenidoDelCard . '<input type="hidden" id="ConType_' . $f['IdCon'] . '" value="' . $f['ConType'] . '">';
        if ($f['ConType'] <= 1) {

            if ($f['ConType'] == 0) {
                $ContenidoDelCard =  $ContenidoDelCard . '
                    <b class="Etiqueta">* Esta conección es la base de rintera</b>
                    <div class="row ">
                        
                        <div class="col-sm-6 form-group">
                            <label class="" for="dbhost_' . $f['IdCon'] . '" >Host:</label>
                            <input class="form-control" type="text" name="dbhost_' . $f['IdCon'] . '" id="dbhost_' . $f['IdCon'] . '"
                            title="URL o ip del servidor de la base de datos"                    
                            value="' . $db0_host . '"
                            >
                        </div>

                        
                        <div class="col-sm-6 form-group">
                            <label class="" for="dbuser_' . $f['IdCon'] . '" >Usuario:</label>
                            <input class="form-control" type="text" name="dbuser_' . $f['IdCon'] . '" id="dbuser_' . $f['IdCon'] . '"
                            title="Usuario para acceder a la base de datos"                    
                            value="' . $db0_user . '"
                            >
                        </div>
                    </div>
                    ';


                $ContenidoDelCard =  $ContenidoDelCard . '
                    <div class="row ">
                        
                        <div class="col-sm-6 form-group">
                            <label class="" for="dbname_' . $f['IdCon'] . '" >Nombre de la Base:</label>
                            <input class="form-control" type="text" name="dbname_' . $f['IdCon'] . '" id="dbname_' . $f['IdCon'] . '"
                            title="Nombre de la base de datos"                    
                            value="' . $db0_name . '"
                            >
                        </div>

                        
                        <div class="col-sm-6 form-group">
                            <label class="" for="dbpassword_' . $f['IdCon'] . '" >Password:</label>
                            <input class="form-control" type="text" name="dbpassword_' . $f['IdCon'] . '" id="dbpassword_' . $f['IdCon'] . '"
                            title="Password del usuario de la base de datos"                    
                            value="' . $db0_pass . '"
                            >
                        </div>
                    </div>
                    ';
            } else {
                $ContenidoDelCard =  $ContenidoDelCard . '
                    <div class="row ">
                        
                        <div class="col-sm-6 form-group">
                            <label class="" for="dbhost_' . $f['IdCon'] . '" >Host:</label>
                            <input class="form-control" type="text" name="dbhost_' . $f['IdCon'] . '" id="dbhost_' . $f['IdCon'] . '"
                            title="URL o ip del servidor de la base de datos"                    
                            value="' . $f['dbhost'] . '"
                            >
                        </div>

                        
                        <div class="col-sm-6 form-group">
                            <label class="" for="dbuser_' . $f['IdCon'] . '" >Usuario:</label>
                            <input class="form-control" type="text" name="dbuser_' . $f['IdCon'] . '" id="dbuser_' . $f['IdCon'] . '"
                            title="Usuario para acceder a la base de datos"                    
                            value="' . $f['dbuser'] . '"
                            >
                        </div>
                    </div>
                    ';


                $ContenidoDelCard =  $ContenidoDelCard . '
                    <div class="row ">
                        
                        <div class="col-sm-6 form-group">
                            <label class="" for="dbname_' . $f['IdCon'] . '" >Nombre de la Base:</label>
                            <input class="form-control" type="text" name="dbname_' . $f['IdCon'] . '" id="dbname_' . $f['IdCon'] . '"
                            title="Nombre de la base de datos"                    
                            value="' . $f['dbname'] . '"
                            >
                        </div>

                        
                        <div class="col-sm-6 form-group">
                            <label class="" for="dbpassword_' . $f['IdCon'] . '" >Password:</label>
                            <input class="form-control" type="text" name="dbpassword_' . $f['IdCon'] . '" id="dbpassword_' . $f['IdCon'] . '"
                            title="Password del usuario de la base de datos"                    
                            value="' . $f['dbpassword'] . '"
                            >
                        </div>
                    </div>
                    ';
            }
        } else {

            if ($f['ConType'] == 2) { //SQLSERVERTOJON
                $ContenidoDelCard =  $ContenidoDelCard . '
                    <b class="Etiqueta">
                    WebService: <a href="https://github.com/prymecode/sqlservertojson" title="Conecta el proyecto mediante consultas SQL a tu servidor MSSQL-Server"
                    >sqlservertojson</a>. <p>Conecta el proyecto mediante consultas SQL a tu servidor MSSQL-Server</p>
                    </b>
                    <div class="row ">                    
                        <div class="col-sm-6 form-group">
                            <label  class="" for="wsmethod_' . $f['IdCon'] . '" >Metodo:</label>
                            <select class="form-control" type="text" name="wsmethod_' . $f['IdCon'] . '" id="wsmethod_' . $f['IdCon'] . '"
                                title="Metodo del webservice GET o POST"                                                
                                required
                            >';
                $ContenidoDelCard =  $ContenidoDelCard . '                                                                 
                                    <option value="1" selected>POST</option>';

                // if ($f['wsmethod'] == '0'){
                //     $ContenidoDelCard =  $ContenidoDelCard.'
                //         <option value="0" selected>GET</option>                                
                //         <option value="1">POST</option>
                //     ';

                // } else {
                //         $ContenidoDelCard =  $ContenidoDelCard.'
                //         <option value="1" selected>POST</option>                                
                //         <option value="0">GET</option>                                
                //         ';

                // }




                $ContenidoDelCard =  $ContenidoDelCard . '
    
                            </select>
                        </div>
    
                        
                        <div class="col-sm-6 form-group">
                            <label class="" for="wsurl_' . $f['IdCon'] . '" >URL:</label>
                            <input class="form-control" type="text" name="wsurl_' . $f['IdCon'] . '" id="wsurl_' . $f['IdCon'] . '"
                            title="URL del Webservice"                    
                            value="' . $f['wsurl'] . '"
                            >
                        </div>
                    </div>
                    ';

                $ContenidoDelCard =  $ContenidoDelCard . '
                    <div class="row ">  
                    <h6>Parametros:</h6>
                    <table width=100% class="tabla">
                    <th>n</th><th>Id</th><th>Valor</th>
                    <tr>
                        <td>1</td>
                        <td> 
                            <input class="form-control" type="text" name="wsP1_id_' . $f['IdCon'] . '" id="wsP1_id_' . $f['IdCon'] . '"
                            title="Id del Primer Parametro"                    
                            value="token"
                            >
                        </td>
    
                        <td> 
                            <input class="form-control" type="text" name="wsP1_value_' . $f['IdCon'] . '" id="wsP1_value_' . $f['IdCon'] . '"
                            title="Valor del Primer Parametro"                    
                            value="' . $f['wsP1_value'] . '"
                            >
                        </td>
                    </tr>
    
                    <tr>
                        <td>2</td>
                        <td> 
                            <input class="form-control" type="text" name="wsP2_id_' . $f['IdCon'] . '" id="wsP2_id_' . $f['IdCon'] . '"
                            title="Id del Segundo Parametro"                    
                            value="method"
                            readonly
                            >
                        </td>
    
                        <td> 
                            <input class="form-control" type="text" name="wsP2_value_' . $f['IdCon'] . '" id="wsP2_value_' . $f['IdCon'] . '"
                            title="Valor del Primer Parametro"                    
                            value="POST"
                            readonly
                            >
                        </td>
                    </tr>
    
    
                    </tr>
    
                    </table>
    
                    </div>
                    ';
            } else {
                $ContenidoDelCard =  $ContenidoDelCard . '
                    <div class="row ">                    
                        <div class="col-sm-6 form-group">
                            <label  class="" for="wsmethod_' . $f['IdCon'] . '" >Metodo:</label>
                            <select class="form-control" type="text" name="wsmethod_' . $f['IdCon'] . '" id="wsmethod_' . $f['IdCon'] . '"
                                title="Metodo del webservice GET o POST"                                                
                                required
                            >';

                if ($f['wsmethod'] == '0') {
                    $ContenidoDelCard =  $ContenidoDelCard . '
                                    <option value="0" selected>GET</option>                                
                                    <option value="1">POST</option>
                                ';
                } else {
                    $ContenidoDelCard =  $ContenidoDelCard . '
                                    <option value="1" selected>POST</option>                                
                                    <option value="0">GET</option>                                
                                    ';
                }




                $ContenidoDelCard =  $ContenidoDelCard . '
    
                            </select>
                        </div>
    
                        
                        <div class="col-sm-6 form-group">
                            <label class="" for="wsurl_' . $f['IdCon'] . '" >URL:</label>
                            <input class="form-control" type="text" name="wsurl_' . $f['IdCon'] . '" id="wsurl_' . $f['IdCon'] . '"
                            title="URL del Webservice"                    
                            value="' . $f['wsurl'] . '"
                            >
                        </div>
                    </div>
                    ';

                $ContenidoDelCard =  $ContenidoDelCard . '
                    <div class="row ">  
                    <h6>Parametros:</h6>
                    <table width=100% class="tabla">
                    <th>n</th><th>Id</th><th>Valor</th>
                    <tr>
                        <td>1</td>
                        <td> 
                            <input class="form-control" type="text" name="wsP1_id_' . $f['IdCon'] . '" id="wsP1_id_' . $f['IdCon'] . '"
                            title="Id del Primer Parametro"                    
                            value="' . $f['wsP1_id'] . '"
                            >
                        </td>
    
                        <td> 
                            <input class="form-control" type="text" name="wsP1_value_' . $f['IdCon'] . '" id="wsP1_value_' . $f['IdCon'] . '"
                            title="Valor del Primer Parametro"                    
                            value="' . $f['wsP1_value'] . '"
                            >
                        </td>
                    </tr>
    
                    <tr>
                        <td>2</td>
                        <td> 
                            <input class="form-control" type="text" name="wsP2_id_' . $f['IdCon'] . '" id="wsP2_id_' . $f['IdCon'] . '"
                            title="Id del Segundo Parametro"                    
                            value="' . $f['wsP2_id'] . '"
                            >
                        </td>
    
                        <td> 
                            <input class="form-control" type="text" name="wsP2_value_' . $f['IdCon'] . '" id="wsP2_value_' . $f['IdCon'] . '"
                            title="Valor del Primer Parametro"                    
                            value="' . $f['wsP2_value'] . '"
                            >
                        </td>
                    </tr>
    
    
                    <tr>
                        <td>3</td>
                        <td> 
                            <input class="form-control" type="text" name="wsP3_id_' . $f['IdCon'] . '" id="wsP3_id_' . $f['IdCon'] . '"
                            title="Id del Tercer Parametro"                    
                            value="' . $f['wsP3_id'] . '"
                            >
                        </td>
    
                        <td> 
                            <input class="form-control" type="text" name="wsP3_value_' . $f['IdCon'] . '" id="wsP3_value_' . $f['IdCon'] . '"
                            title="Valor del Tercer Parametro"                    
                            value="' . $f['wsP3_value'] . '"
                            >
                        </td>
                    </tr>
    
                    <tr>
                        <td>4</td>
                        <td> 
                            <input class="form-control" type="text" name="wsP4_id_' . $f['IdCon'] . '" id="wsP4_id_' . $f['IdCon'] . '"
                            title="Id del Cuarto Parametro"                    
                            value="' . $f['wsP4_id'] . '"
                            >
                        </td>
    
                        <td> 
                            <input class="form-control" type="text" name="wsP4_value_' . $f['IdCon'] . '" id="wsP4_value_' . $f['IdCon'] . '"
                            title="Valor del Cuarto Parametro"                    
                            value="' . $f['wsP4_value'] . '"
                            >
                        </td>
                    </tr>
    
                    </table>
    
                    </div>
                    ';
            }
        }



        $ContenidoDelCard =  $ContenidoDelCard . '
            <hr style="
                border-color: #9a9b9b;
                border-style: dashed;
            ">


            <table width=100%><tr><td align=left>
               
            </td>

            <td align=right>
                    <button type="button" class="btn btn-success"  onclick="Active(' . $f['IdCon'] . ');" >
                        <img src="icons/ok2.png" style="width:22px;">
                    </button>
            </td></tr></table>

            


            </form>
        
        
        ';
        AcordionCard($IdCard, $btnText, $IdCollapsed, $Color);
        AcordionCard_Data($IdCard, $ContenidoDelCard, $IdCollapsed, $Color);
    }
    echo '</div>';




    echo '<div id="Preferencias" class="Panel" 
    style="
        background-color: #f4f3ec;
        padding: 10px;
    "
    ">';
    echo '<h6 style="
    font-weight:bold;
    ">Perfil Empresarial</h6>';
    echo "<form method='POST' enctype='multipart/form-data' id='EmpresaForm' >";
    echo "<label style='width:100%;' >Nombre de la Empresa: <input type='text' class='form-control' id='RinteraName'  value='" . Preference("RinteraName", "", "") . "'></label>";
    echo "<label style='width:100%;' >Descripcion: <input type='text' class='form-control' id='RinteraDescription' value='" . Preference("RinteraDescription", "", "") . "'></label>";
    echo '
      <hr style="
        border-color: #9a9b9b;
        border-style: dashed;
    ">


        <table width=100%><tr>
        <td width=50%>';
    if (Preference("LogoImagePNG", "", "") == "TRUE") {
        if (file_exists("img/Logo.png")) { //Existe el archivo
            echo "<img src='img/Logo.png' style='width:150px;' id='ImgEmpresa'>";
        }
    } else {
        if (file_exists("img/Logo.jpg")) { //Existe el archivo
            echo "<img src='img/Logo.jpg' style='width:150px;' id='ImgEmpresa' >";
        }
    }

    echo "<br>";
    echo "<input class='form-control' type='file' name='archivo'  id='archivo' accept='image/jpeg, image/png' >";

    echo '
        </td>
        

        <td align=right valign=bottom>
                <button type="button" class="btn btn-success"  onclick="SaveEmpresa();" >
                    <img src="icons/ok2.png" style="width:22px;">
                </button>
        </td></tr></table>



    </form>
       ';

    echo '</div>';



    

    echo '<div id="Visual" class="Panel" 
    style="
        background-color: #f4f3ec;
        padding: 10px;
    "
    ">';
    echo '<h6 style="
    font-weight:bold;
    ">Estilo Visual</h6>';

    if (Preference("VisualLogo","","") == "TRUE") {
        $checked = 'checked';
        $txt_checked = 'Desactivar';
    } else {
        $checked = '';
        $txt_checked = 'Activar';
    }


    if (Preference("SearchVisualList","","") == "TRUE") {
        $checkedList = 'checked';
        $txt_checkedList = 'Desactivar';
    } else {
        $checkedList = '';
        $txt_checkedList = 'Activar';
    }
    // echo $checkedList;

    echo '<table class="tabla">';
    echo '<tr>
        
       
            <td  width=90% align=right>
                <b style="font-weight:bold; font-size:10pt;">Visualizar Logotipo.<br></b>
                <cite>Muestra la imagen cargada en el Perfil empresarial en la parte superior de la aplicacion; así como en otras partes donde corresponda.</cite>
            </td>

            <td align=left valign=top>  
            <div class="custom-control custom-switch col-sm-6 " >
            <input type="checkbox" class="custom-control-input" id="VisualLogo" onclick="ActivarLogo();" '.$checked.'>
            <label onclick="" class="custom-control-label" for="VisualLogo"></label>
            </div>

            
            </td>
        </tr>             
        ';
    

        echo '<tr>              
            <td  width=90% align=right>
                <b style="font-weight:bold; font-size:10pt;">Color Principal<br></b>
                
            </td>

            <td align=left valign=top>  
            
            <input type="color" class="form-control" id="ColorPrincipal" onclick="" value="'.Preference("ColorPrincipal", "", "").'" >
            
            
            </td>
        </tr>             
        ';


        
        echo '<tr>              
            <td  width=90% align=right>
                <b style="font-weight:bold; font-size:10pt;">Color Secundario<br></b>
                
            </td>

            <td align=left valign=top>  
            
            <input type="color" class="form-control" id="ColorSecundario" onclick="" value="'.Preference("ColorSecundario", "", "").'"  >
            
            
            </td>
        </tr>             
        ';

        
        echo '<tr>              
            <td  width=90% align=right>
                <b style="font-weight:bold; font-size:10pt;">Color Resaltado<br></b>
                
            </td>

            <td align=left valign=top>  
            
            <input type="color" class="form-control" id="ColorResaltado" onclick=""  value="'.Preference("ColorResaltado", "", "").'" >
            
            
            </td>
        </tr>             
        ';

        
        echo '<tr>              
            <td  width=90% align=right>
                <b style="font-weight:bold; font-size:10pt;">Color de Fondo<br></b>
                
            </td>

            <td align=left valign=top>  
            
            <input type="color" class="form-control" id="ColorDeFondo" onclick=""  value="'.Preference("ColorDeFondo", "", "").'" >
            
            
            </td>
        </tr>             
        ';

        echo '<tr>              
        <td  width=90% align=right>
            <b style="font-weight:bold; font-size:10pt;">Resultados de Busqueda en forma de Lista<br></b>
            <cite>Si esta apagada esta opcion, el resultado sale en cuadricula</cite>
            
        </td>

        <td align=left valign=top>  
        
        <div class="custom-control custom-switch col-sm-6 " >
            <input type="checkbox" class="custom-control-input" id="SearchVisualList" '.$checkedList.'>
            <label onclick="" class="custom-control-label" for="SearchVisualList"></label>
        </div>
        
        
        </td>
    </tr>             
    ';


    //Privacidad
    
    if (Preference("SearchVisualList","","") == "TRUE") {
        $checkedList = 'checked';
        $txt_checkedList = 'Desactivar';
    } else {
        $checkedList = '';
        $txt_checkedList = 'Activar';
    }
    // echo $checkedList;



        


    echo '<tr>              
    <td  width=90% align=right>
     
    </td>

    <td align=left valign=top>  
                    <button type="button" class="btn btn-success"  onclick="SaveVisual();" >
                        <img src="icons/ok2.png" style="width:22px;">
                    </button>
    </td>
</tr>             
';
    echo '</table>';

    echo "</div>";



    

    echo '<div id="Security" class="Panel" 
    style="
        background-color: #f4ecec;
        padding: 10px;
    "
    ">';
    echo '<h6 style="
    font-weight:bold;
    ">Seguridad y Privacidad</h6>';



    $styleF = "";
    if (Preference("UsuariosForaneos","","") == "TRUE") {
        $checkedF = 'checked';        
        
    } else {
        $checkedF= '';        
    }
    // echo $checkedList;

    echo '<table class="tabla">';
    
    echo '<tr>     
       
            <td  width=90% align=right>
                <b style="font-weight:bold; font-size:10pt;">Utilizar Usuarios Foraneos<br></b>
                Puedes utilizar una base de datos externa, respetando el nombre de los campos.
                    <b style="font-weight:bold; color:black;">IdUser, NIP, UserName y RinteraLevel. </b> (1=Administrador y 2=Para Usuarios de Consulta)<br>
                    <code class="Code">select * from UsuariosRintera where RinteraLevel>0</code>
                
            </td>

            <td align=left valign=top>  
            <div class="custom-control custom-switch col-sm-6 " >
            <input onclick="ActivarForaneos();" type="checkbox" class="custom-control-input" id="UsuariosForaneos" '.$checkedF.'>
            <label onclick="" class="custom-control-label" for="UsuariosForaneos"></label>
            </div>

            
            </td>
        </tr>             
        ';
    




        echo '<tr  class="Foraneos">     
       
            <td  width=90% align=right colspan=2>';

        echo '<label class="form-control-label" >Conección donde estan los usuarios:</label>
        <select id="UsuariosForaneosIdCon" class="form-control" >';

        $sql="select * from dbs where Active=1 and ConType in(0,1)";
        $r= $db0 -> query($sql);
        while($f = $r -> fetch_array()) {               
            echo "<option value='".$f['IdCon']."'>".$f['ConName']."</option>";
        }

        echo "</select>";
            

        echo '            
            </td>
        </tr>             
        ';
    

        echo '<tr class="Foraneos">     
       
        <td  width=90% align=right colspan=2>';

    echo '<label class="form-control-label" >UsuariosForaneosQuery:</label><br>
    <cite>Considera que Rintera añadira <b style="color:blue;">and IdUser=IdUsuario</b></cite>
    ';

    echo '<textarea class="Query ">'.Preference("UsuariosForaneosQuery", "", "").'</textarea>';
        

    echo '            
        </td>
    </tr>             
    ';


    
    echo '<tr class="Usuarios">     
       
    <td  width=90% align=right colspan=2 align=center>';

echo '<a href="users.php" class="btn btn-primary" style="
color:white;
">Administrar Usuarios </a>';

    

echo '            
    </td>
</tr>             
';


            // echo '<tr >              
            //     <td  width=90% align=right>
            //         <b style="font-weight:bold; font-size:10pt;">Color Principal<br></b>
                    
            //     </td>

            //     <td align=left valign=top>  
                
            //     <input type="color" class="form-control" id="ColorPrincipal" onclick="" value="'.Preference("ColorPrincipal", "", "").'" >
                
                
            //     </td>
            // </tr>             
            // ';







    echo '<tr>              
    <td  width=90% align=right>
     
    </td>

    <td align=left valign=top>  
                    <button type="button" class="btn btn-success"  onclick="SavePrivacidad();" >
                        <img src="icons/ok2.png" style="width:22px;">
                    </button>
    </td>
</tr>             
';
    echo '</table>';

    echo "</div>";

    

















    echo "</div>";


    echo "</center>";
} else {
    LocationFull("index.php");
}
?>

<script>
function SaveVisual(){
    var VisualLogoCheck = 0
    if ($('#VisualLogo').prop('checked')) {
        VisualLogoCheck = 1
    } else {
        VisualLogoCheck = 0
    }
    var ColorPrincipal = $('#ColorPrincipal').val();
    var ColorSecundario = $('#ColorSecundario').val();
    var ColorResaltado = $('#ColorResaltado').val();
    var ColorDeFondo = $('#ColorDeFondo').val();
    
    
    var SearchVisualList = 0
    if ($('#SearchVisualList').prop('checked')) {
        SearchVisualList = 1
    } else {
        SearchVisualList = 0
    }

    $('#PreLoader').show();
            $.ajax({
                url: 'custom_dataVisual.php',
                type: 'post',
                data: {
                    IdUser: '<?php echo $nitavu; ?>',              
                    VisualLogoCheck: VisualLogoCheck,     
                    ColorPrincipal:ColorPrincipal,
                    ColorSecundario: ColorSecundario,                           
                    ColorResaltado:ColorResaltado,
                    ColorDeFondo:ColorDeFondo,
                    SearchVisualList:SearchVisualList,
                    Token: '<?php echo $MiToken; ?>'

                },
                success: function(data) {
                    $('#R').html(data);
                    $('#PreLoader').hide();
                }
            });
}



function ActivarLogo(){
    var VisualLogoCheck = 0
    if ($('#VisualLogo').prop('checked')) {
        VisualLogoCheck = 1
    } else {
        VisualLogoCheck = 0
    }
    $('#PreLoader').show();
            $.ajax({
                url: 'custom_dataActivarLogo.php',
                type: 'post',
                data: {
                    IdUser: '<?php echo $nitavu; ?>',              
                    VisualLogoCheck: VisualLogoCheck,                                
                    Token: '<?php echo $MiToken; ?>'

                },
                success: function(data) {
                    $('#R').html(data);
                    $('#PreLoader').hide();
                }
            });
}

    function Active(IdCon) {
        var IdUser = '<?php echo $nitavu; ?>'
        var Active = 0
        if ($('#Active_' + IdCon).prop('checked')) {
            Active = 1
            $('#Card' + IdCon).css('background-color', '#d3f0cf')
            $('#Coll' + IdCon).css('background-color', '#d3f0cf')
            $('#Tit_' + IdCon).html('[' + IdCon + '] ' + '' + $('#ConName_' + IdCon).val())

        } else {
            Active = 0
            $('#Card' + IdCon).css('background-color', '#f4f4f4')
            $('#Coll' + IdCon).css('background-color', '#f4f4f4')
            $('#Tit_' + IdCon).html('[' + IdCon + '] ' + '' + $('#ConName_' + IdCon).val())
        }

        var ConType = $('#ConType_' + IdCon).val();

        if (ConType <= 1) {
            var dbhost = $('#dbhost_' + IdCon).val();
            var dbuser = $('#dbuser_' + IdCon).val();
            var dbname = $('#dbname_' + IdCon).val();
            var dbpassword = $('#dbpassword_' + IdCon).val();
            $('#PreLoader').show();
            var ConName = $('#ConName_' + IdCon).val();

            $.ajax({
                url: 'custom_data.php',
                type: 'post',
                data: {
                    IdUser: IdUser,
                    IdCon: IdCon,
                    ConName: ConName,
                    Active: Active,
                    dbhost: dbhost,
                    dbuser: dbuser,
                    dbname: dbname,
                    dbpassword: dbpassword,
                    Token: '<?php echo $MiToken; ?>'
                }

                ,
                success: function(data) {
                    $('#R').html(data);
                    $('#PreLoader').hide();
                }
            });
        } else {
            var wsmethod = $('#wsmethod_' + IdCon).val();
            var wsurl = $('#wsurl_' + IdCon).val();
            var ConName = $('#ConName_' + IdCon).val();

            var wsP1_id = $('#wsP1_id_' + IdCon).val();
            var wsP1_value = $('#wsP1_value_' + IdCon).val();

            var wsP2_id = $('#wsP2_id_' + IdCon).val();
            var wsP2_value = $('#wsP2_value_' + IdCon).val();

            var wsP3_id = $('#wsP3_id_' + IdCon).val();
            var wsP3_value = $('#wsP3_value_' + IdCon).val();

            var wsP4_id = $('#wsP4_id_' + IdCon).val();
            var wsP4_value = $('#wsP4_value_' + IdCon).val();


            $('#PreLoader').show();
            $.ajax({
                url: 'custom_data.php',
                type: 'post',
                data: {
                    IdUser: IdUser,
                    IdCon: IdCon,
                    ConName: ConName,
                    Active: Active,
                    wsmethod: wsmethod,
                    wsurl: wsurl,
                    wsP1_id: wsP1_id,
                    wsP1_value: wsP1_value,
                    wsP2_id: wsP2_id,
                    wsP2_value: wsP2_value,
                    wsP3_id: wsP3_id,
                    wsP3_value: wsP3_value,
                    wsP4_id: wsP4_id,
                    wsP4_value: wsP4_value,
                    Token: '<?php echo $MiToken; ?>'


                },
                success: function(data) {
                    $('#R').html(data);
                    $('#PreLoader').hide();
                }
            });
        }



    }

    function ActTit(IdCon) {
        $('#Tit_' + IdCon).html('[' + IdCon + '] ' + '' + $('#ConName_' + IdCon).val())

    }



    // $("#EmpresaForm").on("submit", function(e){
    // alert('Click');
    function SaveEmpresa() {
        // e.preventDefault();
        var RinteraName = $('#RinteraName').val();
        var RinteraDescription = $('#RinteraDescription').val();
        var f = $(this);
        var formData = new FormData(document.getElementById("EmpresaForm"));
        formData.append("IdUser", "<?php echo $nitavu; ?>");
        formData.append("Token", "<?php echo $MiToken; ?>");
        formData.append("RinteraName", RinteraName);
        formData.append("RinteraDescription", RinteraDescription);


        $.ajax({
            url: "custom_dataEmpresa.php",
            type: "post",
            dataType: "html",
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
            beforeSend: function() {
                $('#Loader').show();
            },
            success: function(data) {
                $('#R').html(data);
                $('#Loader').hide();

            }
        });
    }
    // });

function ActivarForaneos(){
    if ($('#UsuariosForaneos').prop('checked')) {
            $('.Foraneos').show();
            $('.Usuarios').hide();
        } else {
            $('.Foraneos').hide();
            $('.Usuarios').show();

        }

}
ActivarForaneos();


function SavePrivacidad(){
    
    var UsuariosForaneos = "";
    if ($('#UsuariosForaneos').prop('checked')) {
            UsuariosForaneos = "TRUE";
        } else {
            UsuariosForaneos = "FALSE";
        }
    var UsuariosForaneosQuery = $('#UsuariosForaneosQuery').val();
    var UsuariosForaneosIdCon = $('#UsuariosForaneosIdCon').val();
    
    $('#PreLoader').show();
            $.ajax({
                url: 'custom_dataPriv.php',
                type: 'post',
                data: {
                    IdUser: '<?php echo $nitavu; ?>',              
                    UsuariosForaneos: UsuariosForaneos,     
                    UsuariosForaneosQuery:UsuariosForaneosQuery,
                    UsuariosForaneosIdCon: UsuariosForaneosIdCon,                                               
                    Token: '<?php echo $MiToken; ?>'

                },
                success: function(data) {
                    $('#R').html(data);
                    $('#PreLoader').hide();
                }
            });
}
</script>
<div id='R' style='display:none;'>
</div>

</body>

</html>