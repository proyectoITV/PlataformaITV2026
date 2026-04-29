<?php include ("./lib/body_head.php"); include ("./lib/body_menu.php"); ?>

<script>


function RevisaCantidad(){
    console.log('RevisaCantidad');
    if ($.isNumeric($('#cantidad').val()) == false){
        $('#cantidad').val('');
    }
    if ($('#cantidad').val() <= 0) {
        $('#cantidad').val('');
    }
}


function RevisaCel(){ 
    cel = $('#celular').val(); 
    longCel = cel.length; console.log("Log. Cel =".longCel);
    if (longCel>10){
        $("#celular").css("background-color","red");
    } else {
        $("#celular").css("background-color","white");
    }

    for (var i = 0; i < longCel; i++) {
        cel = $('#celular').val(); 
        cel = cel.replace('-',''); 
        $('#celular').val(cel);

        cel = $('#celular').val(); 
        cel = cel.replace('.',''); 
        $('#celular').val(cel);

        cel = $('#celular').val(); 
        cel = cel.replace('*',''); 
        $('#celular').val(cel);

    }

    if ($.isNumeric($('#celular').val()) == false){
        $('#celular').val('');
    }

   


    
}



function RevisaTel(){ 
    cel = $('#telefono').val(); 
    longCel = cel.length; console.log("Log. Cel =".longCel);
    if (longCel>10){
        $("#telefono").css("background-color","red");
    } else {
        $("#telefono").css("background-color","white");
    }

    for (var i = 0; i < longCel; i++) {
        cel = $('#telefono').val(); 
        cel = cel.replace('-',''); 
        $('#telefono').val(cel);

        cel = $('#telefono').val(); 
        cel = cel.replace('.',''); 
        $('#telefono').val(cel);

        cel = $('#telefono').val(); 
        cel = cel.replace('*',''); 
        $('#telefono').val(cel);

    }

    if ($.isNumeric($('#telefono').val()) == false){
        $('#telefono').val('');
    }

   


    
}

</script>

<?php


$id_aplicacion ="ap74"; //ap07=Permisos de Aplicacion
$nivel = aplicacion_nivel($id_aplicacion, $nitavu);
// $nivel=1;
if (sanpedro($id_aplicacion, $nitavu)==TRUE){
    echo "<div id='AppDetalle'>".app_detalle($id_aplicacion, $nitavu)."</div>";        
    xd_update('ap74',$nitavu);//guarda la experiencia del usuario
    historia($nitavu, "Entro a la App [ap74] Administracion de Fondo Economico de Reserva");
    
    echo "<table width=100%><tr><td width=90%>";
    buscar('fer.php', 'Nombre del beneficiario', '');
    echo "</td><td>";
    if ($nivel==1){
        echo "<a class='pc' href='#add' rel='MyModal:open'>";
        echo "<img src='icon/editar.png' style='width:80px'>";
        echo "</a>";
    }
    echo "</td></tr></table>";


    echo "<div class=''>";
    echo "</div>";

    /* echo "<form id='add' action='fer.php' method='post' enctype='multipart/form-data' class='MyModal'>
    <h1>Crear certificado del Fondo Económico de Reserva</h1>
    <span><label>Nombre del Beneficiario:</label>
        <input type='text' placeholder='' id='beneficiario' name='beneficiario' value='' required>
    </span>
    
    <div><label>CURP:</label>
        <input style='background-color:#F7A724;'  type='text' placeholder='' id='curp' name='curp' value='' required>
    </div>

    <div><label>Fecha de Nacimiento:</label>
        <input type='date' placeholder='' id='nacimiento' name='nacimiento' value='' required>
    </div>

    <div><label>Contrato:</label>
        <input type='text' placeholder='' id='contrato' name='contrato' value='' required>
    </div>

    
    <div><label>Concepto:</label>
        <select id='concepto_id' name='concepto_id' required>";
            
        $sql = "select * from cat_fer";
        $r= $conexion -> query($sql);
        while($f = $r -> fetch_array()) {
            echo "<option value='".$f['fer_IdCon']."'>".$f['fer_descripcion']."</option>";
        }



    echo "
        
        </select>
    </div>

   
    

    <div><label>Municipio:</label>
        <select id='IdMunicipio' name='IdMunicipio' required>";
            
        $sql = "select * from cat_municipios order by municipio";
        $r= $conexion -> query($sql);
        while($f = $r -> fetch_array()) {
            echo "<option value='".$f['IdMunicipio']."'>".$f['nombre']."</option>";
        }



    echo "
        
        </select>
    </div>


    <div><label>Telefono:</label>
        <input type='text' placeholder='' id='telefono'  onkeyup='RevisaTel();'name='telefono' value=''   maxlength='10' size='10' >
    </div>

    <div><label>Celular:</label>
        <input type='text' placeholder=''  onkeyup='RevisaCel();' id='celular' name='celular' value='' maxlength='10' size='10' >
    </div>

    <div><label>Cantidad:</label>
        <input type='text' style='background-color:#F7A724;' placeholder='' onkeyup='RevisaCantidad();' id='cantidad' name='cantidad' value='' required >
    </div>

    <div><label>Sexo:</label>
        <select name='sexo' id='sexo'>
            <option value='F'> Femenino </option>
            <option value='M'> Masculino </option>
            
        </select>
    </div>
    
  

    <span><label>Domicilio:</label>
        <textarea style='height:50px' type='text' placeholder='' id='domicilio' name='domicilio'></textarea>
    </span>

    <div style='width:20%;'><label>Describa el motivo:</label>
        <textarea style='height:80px; font-size:8pt;' type='text' placeholder='' id='descripcion' name='descripcion'></textarea>
    </div>

    <div style='width:20%;'><label>Parrafo adicional(opcional):</label>
        <textarea style='height:80px; font-size:8pt; background-color:orange;' type='text' placeholder='' id='parrafo_opcional' name='parrafo_opcional'></textarea>
    </div>

    <div style='width:20%;'><label>Doc para sustento (PDF):</label>
    <input type='file' placeholder='Documento para el sustento' id='sustento' name='sustento' accept='.pdf'  >
</div>

    <div  style='width:20%;'>
        <input type='submit'  class='Mbtn btn-default' id='ferAdd' name='ferAdd' value='Disponer' >
    </div>

  
    

<label>* Por favor capture correctamente, de acuerdo a expediente. Por el momento no hay una validacion del contrato o curp.</label>
    </form>";
 */

 //nuevo form
 echo "<form id='add' action='fer.php' method='post' enctype='multipart/form-data' class='MyModal'>
    <h2 style='color:darkred'>Nuevo certificado del Fondo Económico de Reserva</h2>
    <span>
        <label style='color:darkred; '>Nombre del Beneficiario:</label>
        <input type='text' placeholder='' id='beneficiario' name='beneficiario' style='height: 30; font-size: 13;' value='' required >        
    </span>
    
    <div style='display: inline;'>
        <div style='margin-right: 30px;' ><label style='color:darkred'>CURP:</label>
            <input style=' height: 30; font-size: 11; width:170px; '  type='text' placeholder='' id='curp' name='curp' value=''>
        </div>

        <div><label style='color:darkred'>Fecha de Nacimiento:</label>
            <input type='date' style=' height: 30; font-size: 13;' placeholder='' id='nacimiento' name='nacimiento' value='' required>
        </div>

        <div><label style='color:darkred'>Sexo:</label>
            <select style=' height: 30; font-size: 13;' name='sexo' id='sexo'>
                <option value='F'> Femenino </option>
                <option value='M'> Masculino </option>
                
            </select>
        </div>
            
        <div><label style='color:darkred'>Telefono:</label>
            <input type='text' placeholder='' id='telefono'  onkeyup='RevisaTel();'name='telefono' value=''   maxlength='10' size='10' style=' height: 30; font-size: 13;' >
        </div>

        <div><label style='color:darkred'>Celular:</label>
            <input type='text' placeholder=''  onkeyup='RevisaCel();' id='celular' name='celular' value='' maxlength='10' size='10' style=' height: 30; font-size: 13;'>
        </div>
    </div>    
    <br>

    <div>    
    <span><label style='color:darkred'>Domicilio:</label>
    <textarea style='height:50px; font-size: 13; width: 1000;' type='text' placeholder='' id='domicilio' name='domicilio'></textarea>
    </span></div>
    <br>" ;
    
     echo "   

    <div><label style='color:darkred'>Municipio:</label>
        <select style=' height: 30; font-size: 13;' id='IdMunicipio' name='IdMunicipio' required>";
            
        $sql = "select * from cat_municipios order by municipio";
        $r= $conexion -> query($sql);
        while($f = $r -> fetch_array()) {
            echo "<option value='".$f['IdMunicipio']."'>".$f['nombre']."</option>";
        }
    
        echo "</select></div>
        
        <div><label style='color:darkred'>Contrato:</label>
        <input style=' height: 30; font-size: 13;' type='text' placeholder='' id='contrato' name='contrato' value='' required>
        
        </div>
        
       ";
 

     echo "
     <div><label style='color:darkred'>Concepto:</label>
         <select id='concepto_id' name='concepto_id' style='font-size: 13; width: 400; font-size: 13;'  required>";
            
         $sql = "select * from cat_fer";
         $r= $conexion -> query($sql);
         while($f = $r -> fetch_array()) {
             echo "<option value='".$f['fer_IdCon']."'>".$f['fer_descripcion']."</option>";
         }

         
     echo "    </select>
     </div>
     
     <div style='margin-left: 260px;' ><label style='color:darkred'>Cantidad:</label>
        <input type='text'  placeholder='' onkeyup='RevisaCantidad();' id='cantidad' name='cantidad' value='' required  style='font-size: 13;'>
    </div>
    <br>
    
    <div style='width:100%'>
        <div style='width:20%;'><label style='color:darkred'>Describa el motivo:</label>
            <textarea style='height:80px; font-size:8pt;' type='text' placeholder='Información adicional sobre la autorización del subsidio' id='descripcion' name='descripcion'></textarea>
        </div>
        
        <div style='width:20%;'><label style='color:darkred'>Párrafo adicional(opcional):</label>
            <textarea style='height:80px; font-size:8pt; ' type='text' placeholder='Lo redactado aquí se imprimirá en el certificado de subsidio antes de la firma del director' id='parrafo_opcional' name='parrafo_opcional'></textarea>
        </div>

        <div style='width:20%;'><label style='color:darkred'>Doc para sustento (PDF):</label>
            <input type='file' placeholder='Documento para el sustento' id='sustento' name='sustento' accept='.pdf'  >
        </div>

        <div  style='width:20%;'>
            <input type='submit'  class='Mbtn btn-danger' id='ferAdd' name='ferAdd' value='Disponer' >
        </div>
    </div>     
    ";

 

 
    
echo "
<label>* Por favor capture correctamente, de acuerdo a expediente. Por el momento no hay una validacion del contrato o curp.</label>
    </form>";


 //fin nuevo form

    echo "<div id='fer_lista'>";

    echo "<table width=100%><tr><td>";
    $ejercicio = date('Y');
   // $ejercicio = 2023;


    if (isset($_GET['busqueda'])){
        echo "<h4>Busqueda de  ".$_GET['busqueda']."</h4>";
        historia($nitavu, "Busco ".$_GET['busqueda']." en FER");
        $sql = "select * from fer where estado=0 and (nombre like '%".$_GET['busqueda']."%' or ejercicio like '%".$_GET['busqueda']."%') order by  cast(nfer_id as INTEGER) ";
    }
    else{
        $sql = 'select * from fer where estado=0 and ejercicio='.$ejercicio.' order by ejercicio, cast(nfer_id as INTEGER)';
        //order by ejercicio, nfer_id";
        echo "<h4>Ejercicio ".$ejercicio."</h4>";
        historia($nitavu, "Vio el ejercicio de ".$ejercicio." en FER");
    }
    $sqlreporte="Select numcertificado as NumCertificado, date_format(autorizo_fecha, '%d-%m-%Y') as Fecha, contrato as Contrato, Nombre, Curp, descripcion as Descripcion, Cantidad as Subsidio,
    (
    select fer_descripcion from cat_fer where fer.nfer_concepto=fer_IdCon
    )  as Concepto
    from fer
    where estado=0 and ejercicio=".$ejercicio." order by ejercicio, cast(nfer_id as INTEGER)";

    guardareporte(1,$sqlreporte,$nitavu,'','',$ejercicio,'','produccion_itavu' );
            
            echo "<table class='tabla'>
                <th class='pc' hidden>IdFer </th>
                <th>Num.</th>
                <th>Beneficiario </th>
               
                <th>Cantidad </th>
                <th></th>
                
                
                
            ";
            
            $r= $conexion -> query($sql);
            $GranCantidad=0;
            $b = 0; $d="";
            $styleG="style='background-color: green; color:black; font-weight:bold;'";
            $styleR="style='background-color: red; color:black; font-weight:bold;'";
            while($f = $r -> fetch_array()) {
                if ($f['estado']<>0){
                    echo "<tr ".$styleR.">";
                }else {
                echo "<tr >";
                }
                    echo "<td id='idactividad' name='idactividad'  class='pc' hidden>".$f['nfer_id']."</td>";
                    echo "<td id='numcert' name='numcert' >".$f['numcertificado']."</td>";
                    echo "<td>".$f['nombre'];
                    if ($f['estado']<>0){
                        echo "<br><label>Inactivo o Eliminado</label>";
                        echo "".$f['descripcion'];
                    }
                    echo "</td>";
                    // number_format($TotalDeducciones, 2, '.', ',')
                    echo "<td align=right>$".number_format($f['cantidad'],2,'.',',')."</td>";

                    echo "<td width=150px>";
                        //botones
                    
                        //$d = "";
                        //$d = "<div id='modalModif".$f['nfer_id']."' class='MyModal'>";
                        // originalmente $d = "<div id='".$f['nfer_id']."' class='MyModal'>";
                       /*  $d = $d."<p style='font-size:10pt;'><b class='normal'>".$f['nombre']."</b><br><b>CURP:</b> ".$f['curp']."<br>";
                        $d = $d."<b>Numero de certificado:</b> ".$f['nfer_id'].",<b>CONTRATO:</b> ".$f['contrato']."<br>";
                        $d = $d."<b>Fecha de Nacimiento: </b>".$f['nacimiento'].", <b>Cantidad:</b> $".number_format($f['cantidad'],2,'.',',')."<br>";
                        $d = $d."<b>Domicilio:</b> ".$f['domicilio'].". <b>Telefono:</b> ".$f['telefono'].",<b> Celular:</b> ".$f['celular'];
                        $d = $d."<br>".$f['descripcion']."<br>";
                        $archivo = 'fer/'.$f['nfer_id'].".pdf";
                        if (file_exists($archivo)){
                            $d = $d."<a href='".$archivo."' class='Mbtn btn-tercero' target=blank>Archivo de sustento</a>";
                        }                      

                        $d = $d."<br><br>Lo autorizoooo: ".$f['autorizo']." | ".nitavu_nombre($f['autorizo'])." el dia ".$f['autorizo_fecha']." a las ".$f['autorizo_hora'];
                        $d = $d."</p></div>"; */
                        
                            ///MODAL MODIFICAR
                        //echo "<div id='modalModif".$f['nfer_id']."' class='MyModal'>";
                            if(isset($_POST['btnGuardarM'])){
                                $idcertificado = $_POST['idcertificado'];
                                $contrato = $_POST['contrato'];
                                $nombre = $_POST['beneficiario'];
                                $curp = $_POST['curp'];
                                $descripcion=$_POST['descripcion'];
                                $cantidad=$_POST['cantidad'];
                                $concepto=$_POST['concepto_id'];
                                $nacimiento=$_POST['nacimiento'];
                                $domicilio=$_POST['domicilio'];
                                $telefono=$_POST['telefono'];
                                $celular=$_POST['celular'];
                                $IdMunicipio=$_POST['IdMunicipio'];
                                $sexo=$_POST['sexo'];
                                if ($sexo==1)
                                 {
                                       $sexo='F';      
                                 }
                                 if ($sexo==2){
                                     $sexo='M';
                                 }
                                $parrafo_opcional=$_POST['parrafo_opcional'];

                                //----
                                            //validamos que no se pase del fondo que hay
                                            // $Disponible = FERdisponible();
                                            // if ($cantidad <= $Disponible){

                                                //segunda validacion, la fecha de fin
                                               // if ($fecha <= FER_fechafin()){
                                                           

                                                    // if (FER_curp($curp)==""){
                                                            //....
                                                            $sql="";
                                                            $sql = "Update fer set 
                                                            contrato = ".$contrato.", nombre = '".$nombre."'
                                                            , curp = '".$curp."', descripcion = '".$descripcion."', cantidad = ".$cantidad.", nfer_concepto = '".$concepto."'
                                                            , nacimiento = '".$nacimiento."', domicilio = '".$domicilio."', telefono = '".$telefono."'
                                                            , celular = '".$celular."', IdMunicipio = '".$IdMunicipio."', sexo = '".$sexo."'                                                           
                                                            , parrafo_opcional = '".$parrafo_opcional."', idempmodifica = '".$nitavu."', fechaultimamod = '".$fecha."'
                                                             where  ejercicio=2024  and nfer_id = ".$idcertificado;
                                                            //revisar traer el mismo año que se habia guardado


                                        
                                                            // echo $sql;     
                                                            if ($conexion->query($sql) == TRUE){ 
                                                                mensaje('Se ha modificado el certificado con éxito','fer.php');
                                                              //  mensaje('Se ha modificado el certificado '.$idcertificado.' con éxito','fer.php');
                                                            }else{
                                                                mensaje('Ocurrio un error al intentar modificar el registro, favor de intentarlo nuevamente.','fer.php');
                                                             }




                                                   /*  if ($conexion->query($sql) == TRUE)
                                                    {
                                                        $subida= subirpdf3('sustento','fer/'.$NferId.'.pdf');
                                                        historia($nitavu, "<b >Creo un cerficicado del Fondo Economico de Reserva con certificado No. ".$NferId." para  ".$nombre.", con el contrato: ".$contrato." y CURP: ".$curp."</b>");
                                                        
                                                        
                                                        $msg = "
                                                        <p> Buen dia "."<br>
                                                        Esto es una notificación automatica de la Plataforma ITAVU<br>
                                                        Se le informa que se ha creado un nuevo certificado con No.".$NferId."
                                                        para consumir del Fondo Economico de Reserva para la persona ".$nombre." la cantidad de 
                                                        $ ".number_format($cantidad,2,'.',',')."</p>

                                                        <p> Puede seguir este movimiento en el modulo FER de la Plataforma </p>
                                                        <p> Saludos</p>
                                                        ";

                                                        mensaje ("Se ha descontado correctamente el certificado ".$NferId." del Fondo Economico de Reserva",'fer.php');
                                                    }
                                                    else
                                                    {
                                                        mensaje ("ERROR: al tratar de guardar el cerficado. ".$sql,'fer.php');
                                                    } */
                                         
                                                /* } else {
                                                    mensaje ("ERROR: Ya no puede utilizar el presente Fondo ya que la fecha actual excede la fecha (".FER_fechafin().")programada de uso del fondo",'fer.php');
                                                }  */


                                            // } else {
                                            //     mensaje("ERROR: Tu Fondo actual (".$Disponible.") es insuficiente para cubrir la cantidad solicitada (".$cantidad.")",'fer.php');
                                            // }

                                //---
        
                                                    
                            }  else{ 
                                //#modalHistorial".$f['IdActividad']."
                                echo " <form id='modalModif".$f['nfer_id']."' action='fer.php' method='post' enctype='multipart/form-data' class='MyModal'>";
                                

                                //echo "<div id='modalModif".$f['nfer_id']."' class='MyModal' style='width: 50%; height: auto;'>                               
                                
                                //<form action='fer.php' method='POST'>

                                echo "<a  rel='MyModal:close' class='close-modal'></a>
                                <h3 style='color: #ab0033;'>Modificar Datos del Certificado Num. ".$f['numcertificado']." </h3>";

                                //echo "<input type='text' id='idactividad' name='idactividad' value = '".$f['nfer_id']."' hidden>";
                                echo "<center><table style='width:90%; style='font-size: 12;'>";
                                        echo "<tr>";
                                        echo "<td >    <span>
                                            <input type='text' id='idcertificado' name='idcertificado' value='".$f['nfer_id']."' hidden >
                                            <label style='color:darkred; '>Nombre del Beneficiario:</label>
                                            <input type='text' placeholder='' id='beneficiario' name='beneficiario' style='height: 30; font-size: 13; width:80%' value='".$f['nombre']."' required >        
                                        </span></td>
                                        </tr>
                                        </table>
                                        <table style='width:90%; style='font-size: 12;'>
                                        <tr><td >
                                        
                                            <div style='margin-right: 25px;' ><label style='color:darkred'>CURP:</label>
                                                <input style=' height: 30; font-size: 11; width:170px; '  type='text' placeholder='' id='curp' name='curp' value='".$f['curp']."' required>
                                            </div></td>
                                    
                                            <td style=' margin-right: 30px; ' ><label style='color:darkred; width:150px '>Fecha de Nacimiento:</label>
                                                <input type='date' style=' height: 30; font-size: 13; ' placeholder='' id='nacimiento' name='nacimiento' value='".$f['nacimiento']."' required>
                                                </td>
                                    
                                            <td style='width:20%;'><div><label style='color:darkred; margin-left: 15px;'>Sexo:</label>
                                                <select style=' height: 30; font-size: 13; display: block;width: 140; margin-left: 15px;' name='sexo' id='sexo'>
                                                    <option value='F'> Femenino </option>
                                                    <option value='M'> Masculino </option>
                                                    ";

                                                    if ($f['sexo']=='F') {echo "<option value='1' selected>Femenino</option>";}
                                                    if ($f['sexo']=='M') {echo "<option value='2' selected>Masculino</option>";}
                                                    
                                           echo   "</select></div>


                                           </td>
                                                
                                            <td style='width:20%;' ><div><label style='color:darkred; margin-left: 15px'>Telefono:</label>
                                                <input type='text' placeholder='' id='telefono'  onkeyup='RevisaTel();'name='telefono' value='".$f['telefono']."'   maxlength='10' size='10' style=' height: 30; font-size: 13; margin-left: 15px; width:150px;' >
                                            </div></td>
                                    
                                            <td style='width:20%;'><div><label style='color:darkred'>Celular:</label>
                                                <input type='text' placeholder=''  onkeyup='RevisaCel();' id='celular' name='celular' value='".$f['celular']."' maxlength='10' size='10' style=' height: 30; font-size: 13; width:150px;'>
                                            </div></td>
                                            <td></td>
                                        
                                        </tr>
                                        </table>
                                        <table >
                                        <tr>
                                        <td colspan='6'>
                                        <div>    
                                        <span><label style='color:darkred'>Domicilio:</label>
                                        <textarea style='height:50px; font-size: 13; width: 1000;' type='text' placeholder='' id='domicilio' name='domicilio'>".$f['domicilio']."</textarea>
                                        </span></div>
                                        <br></td></tr>
                                        </table>

                                        <table style='width:90%; style='font-size: 12;'>
                                        <tr><td><div><label style='color:darkred'>Municipio:</label>
                                        <select style=' height: 30; font-size: 13; width:220px;' id='IdMunicipio' name='IdMunicipio' required>";
                                        $sql="";    
                                        $sql = "select * from cat_municipios order by municipio";
                                        $rr= $conexion -> query($sql);
                                        while($mm = $rr -> fetch_array()) {
                                            echo "<option value='".$mm['IdMunicipio']."'>".$mm['nombre']."</option>";
                                        }

                                        echo "<option value='".$f['IdMunicipio']."' selected>".buscaidconceptocx('municipio', 'cat_municipios','IdMunicipio', $f['IdMunicipio'] ? $f['IdMunicipio']  : '0' )."</option>";
                                                                                                    // $campo, $tabla,$campoigual, $idconcepto
                                    
                                        echo "</select></div></td>

                                             <td ><div><label style='color:darkred;  '>Contrato:</label>
                                                 <input style=' height: 30; font-size: 13; width:160px;' type='text' placeholder='' id='contrato' name='contrato' value='".$f['contrato']."' required>
                                            </div></td>
                                        " ;                                       
                                      
                                    //<div style='display: inline-block;'></div>    
                                         echo "<td >
                                        <div><label style='color:darkred'>Concepto:</label>
                                            <select id='concepto_id' name='concepto_id' style='font-size: 13; width:350px; '  required>";
                                                
                                            $sql = "select * from cat_fer";
                                            $rx= $conexion -> query($sql);
                                            while($fx = $rx -> fetch_array()) {
                                                echo "<option value='".$fx['fer_IdCon']."'>".$fx['fer_descripcion']."</option>";
                                            }
                                            echo "<option value='".$f['nfer_concepto']."' selected>".buscaidconceptocx('fer_descripcion', 'cat_fer','fer_idCon', $f['nfer_concepto'] ? $f['nfer_concepto']  : '0' )."</option>";
                                                                                                    // $campo, $tabla,$campoigual, $idconcepto 
                                            
                                        echo "    </select>
                                        </div></td>
                                        
                                        <td><div><label style='color:darkred'>Monto:</label>
                                            <input type='text'  placeholder='' onkeyup='RevisaCantidad();' id='cantidad' name='cantidad' value='".$f['cantidad']."' required  style='font-size: 13; width:180px'>
                                        </div>
                                        <br></td>
                                        </tr>
                                        </table>

                                        <table style='width:90%; style='font-size: 12;'>
                                        <tr>
                                            <td  style=' width:300px;' >                                        
                                            <div style=' width:300px;'><label style='color:darkred'>Describa el motivo:</label>
                                                <textarea style='height:80px; font-size:8pt;' type='text' placeholder='Información adicional sobre la autorización del subsidio' id='descripcion' name='descripcion'>".$f['descripcion']."</textarea>
                                            </div></td>
                                            
                                            <td  style=' width:300px;' ><div style=' width:300px;'><label style='color:darkred; '>Párrafo adicional(opcional):</label>
                                                <textarea style='height:80px; font-size:8pt; ' type='text' placeholder='Lo redactado aquí se imprimirá en el certificado de subsidio antes de la firma del director' id='parrafo_opcional' name='parrafo_opcional'>".$f['parrafo_opcional']."</textarea>
                                            </div></td>
                                    
                                    
                                            <td  style=' width:250px;'><div >
                                                <input type='submit' style='width:200px' class='Mbtn btn-danger' name='btnGuardarM' id='btnGuardarM' value='Guardar Cambios' >
                                            </div></td>
                                        </tr>
                                        ";
                          
                                                //quite el documento en lo que investigo----- onClick='this.disabled=disabled'
                                                
                                            //<td   style=' width:250px;'><div style=' width:300px;'><label style='color:darkred'>Doc para sustento (PDF):</label>
                                           // <input type='file' placeholder='Documento para el sustento' id='sustento' name='sustento' accept='.pdf'  >
                                         //</div></td>
                            

                               echo "</table></center>";

                               
                               // echo '<center><button type="submit"  name="btnGuardarM" id="btnGuardarM" class="btn btn-danger">Guardar</button></center>';     
                                echo "</form>";
                                //</div>";
                            }
                           //yo echo "</div>";                
	                //fin modal modificar
                    



                      //  echo $d;
                        //si el registro es de un año diferente al actual no se muestra modificar
                        if ($f['ejercicio']== date("Y", time()) ){   
                            echo "<a href='#modalModif".$f['nfer_id']."' rel='MyModal:open' class='Mbtn btn-secundario'><img src='icon/info.png' style='width:15px;'></a>";
                        //echo "<a href='#".$f['nfer_id']."' rel='MyModal:open' class='Mbtn btn-secundario'><img src='icon/info.png' style='width:15px;'></a>";
                       
                        }

                        if ($f['ejercicio']== date("Y", time()) ){ 
                            if ($f['estado'] == 0 and $nivel==1){
                                echo " <a href='?del=".$f['nfer_id']."' class='Mbtn btn-secundario'><img src='icon/x.png' style='width:15px;'></a>";
                                echo " <a href='fer_print.php?print=".$f['nfer_id']."' class='Mbtn btn-secundario'><img src='icon/imprimir.png' style='width:15px;'></a>";
                            }
                        }
                    echo "</td>";

                    if ($f['estado']==0){
                    $GranCantidad = $GranCantidad + $f['cantidad'];
                    }
                    $b = $b +1;
                echo "</tr>";
            }
            echo "<tr ".$styleG."><td></td><td>".$b." beneficiarios</td><td align=right><b>$".number_format($GranCantidad,2,'.',',')."</b></td></tr>";
            echo "</table>";
            //echo "<label>Imprime</label>";
            echo"<a class='btn_menu'  href='excel_export.php?n=1'   name='btnExportar' id='btnExportar'
					style='
							width: 120px;
							height: 20px;
							margin-left: 18px;
							background: #E5E5E5;
							text-decoration: none;
                            font-size: 12px;
                            color: teal;'
							
							
					>Exporta a Excel</a>	";

//class='Mbtn btn_menu'
    echo "</td></tr><tr><td>";
    ////////////////////


    
    if (isset($_GET['busqueda'])){
        if (is_numeric($_GET['busqueda'])){
            echo "<hr><h4>Distribución por Municipio  de  ".$_GET['busqueda']."</h4>";     
            $sql = "
            select 
                DISTINCT(IdMunicipio) as Mun,
                (select cat_municipios.Municipio from cat_municipios where cat_municipios.IdMunicipio = Mun) as Nombre,
                (select count(*) from fer where (IdMunicipio = Mun and  ejercicio like '%".$_GET['busqueda']."%') OR  nombre like '%".$_GET['busqueda']."%' and estado = 0) as n,
                (select sum(cantidad) from fer where (IdMunicipio = Mun and ejercicio like '%".$_GET['busqueda']."%' and estado=0) OR (nombre like '%".$_GET['busqueda']."%' and estado=0)) as Cantidad,
                ejercicio
                
                
            from 
                fer
            where 
                nombre like '%".$_GET['busqueda']."%'
                OR ejercicio like '%".$_GET['busqueda']."%'
                and estado=0
                ORDER BY Nombre
            
            ";
        } 
    }
    else{
        $sql = "
        SELECT
        fer.IdMunicipio as Mun,cat_municipios.municipio as Nombre, 
        count(fer.cantidad) as n,
        sum(fer.cantidad) as Cantidad,
        ejercicio
        FROM  fer
        INNER JOIN  cat_municipios   ON 
            fer.IdMunicipio = cat_municipios.IdMunicipio
        WHERE ejercicio ='".$ejercicio."' and estado=0
        GROUP BY
        fer.IdMunicipio
        ORDER BY municipio
";
      
    

        echo "<hr><h4>Distribución por municipio del ejercicio ".$ejercicio."</h4>";
    }

    

    if (isset($_GET['busqueda'])){
        if (is_numeric($_GET['busqueda'])){
            echo "<table class='tabla3'>
                <th>Municipio </th>
                <th>Beneficiarios </th>               
                <th>Cantidad </th>
            ";
            // echo $sql;
            $r= $conexion -> query($sql);
            $GranCantidad=0;
            $b = 0;
            $styleG="style='background-color: green; color:black; font-weight:bold;'";
            while($f = $r -> fetch_array()) {
                echo "<tr >";
                    echo "<td>".$f['Nombre']."</td>";
                    echo "<td>".$f['n']."</td>";
                    
                    echo "<td align=right>$".number_format($f['Cantidad'],2,'.',',')."</td>";

                   
                    $GranCantidad = $GranCantidad + $f['Cantidad'];
                    $b = $b +1;
                echo "</tr>";
            }
            // echo "<tr ".$styleG."><td></td><td>".$b." beneficiarios</td><td align=right><b>$".number_format($GranCantidad)."</b></td></tr>";
            echo "</table>";
        }
    } else {
            echo "<table class='tabla3'>
            <th>Municipio </th>
            <th>Beneficiarios </th>               
            <th>Cantidad </th>
        ";
        // echo $sql;
        $r= $conexion -> query($sql);
        $GranCantidad=0;
        $b = 0;
        $styleG="style='background-color: green; color:black; font-weight:bold;'";
        while($f = $r -> fetch_array()) {
            echo "<tr >";
                echo "<td>".$f['Nombre']."</td>";
                echo "<td>".$f['n']."</td>";
                
                echo "<td align=right>$".number_format($f['Cantidad'],2,'.',',')."</td>";

            
                $GranCantidad = $GranCantidad + $f['Cantidad'];
                $b = $b +1;
            echo "</tr>";
        }
        // echo "<tr ".$styleG."><td></td><td>".$b." beneficiarios</td><td align=right><b>$".number_format($GranCantidad)."</b></td></tr>";
        echo "</table>";
    }
            
        
///////////////////////////////////////

echo "</td></tr><tr><td>";
//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\



    
if (isset($_GET['busqueda'])){
    if (is_numeric($_GET['busqueda'])){
        echo "<hr><h4>Distribución por Género  de  ".$_GET['busqueda']."</h4>";     
        $sql = "
        select 
            DISTINCT(sexo) as Sex,
            
            (select count(*) from fer where (sexo = Sex and  ejercicio like '%".$_GET['busqueda']."%') OR  nombre like '%".$_GET['busqueda']."%' and estado=0) as n,
            (select sum(cantidad) from fer where (sexo = Sex and ejercicio like '%".$_GET['busqueda']."%' and estado=0) OR nombre like '%".$_GET['busqueda']."%' and estado=0) as Cantidad,
            ejercicio
            
            
        from 
            fer
        where 
            nombre like '%".$_GET['busqueda']."%'
            OR ejercicio like '%".$_GET['busqueda']."%'
            and estado=0
        ";
    } 
}
else{
    $sql = "
    select 
        DISTINCT(sexo) as Sex,
        
        (select count(*) from fer where sexo = Sex and ejercicio='".$ejercicio."' and estado=0) as n,
        (select sum(cantidad) from fer where sexo = Sex and ejercicio='".$ejercicio."' and estado=0 ) as Cantidad,
        ejercicio
        
        
    from 
        fer
    where ejercicio = '".$ejercicio."' and estado=0
";
    echo "<hr><h4>Distribución por género del ejercicio ".$ejercicio."</h4>";
}


if (isset($_GET['busqueda'])){
    if (is_numeric($_GET['busqueda'])){
        echo "<table class='tabla3'>
            <th>Genero </th>
            <th>Beneficiarios </th>
           
            <th>Cantidad </th>
            
            
            
            
        ";
        // echo $sql;
        $r= $conexion -> query($sql);
        $GranCantidad=0;
        $b = 0;
        $styleG="style='background-color: green; color:black; font-weight:bold;'";
        while($f = $r -> fetch_array()) {
            echo "<tr >";
                echo "<td>".$f['Sex']."</td>";
                echo "<td>".$f['n']."</td>";
                
                echo "<td align=right>$".number_format($f['Cantidad'],2,'.',',')."</td>";

              
                $GranCantidad = $GranCantidad + $f['Cantidad'];
                $b = $b +1;
            echo "</tr>";
        }
        // echo "<tr ".$styleG."><td></td><td>".$b." beneficiarios</td><td align=right><b>$".number_format($GranCantidad)."</b></td></tr>";
        echo "</table>";
    }

} else {
    echo "<table class='tabla3'>
    <th>Genero </th>
    <th>Beneficiarios </th>
   
    <th>Cantidad </th>
    
    
    
    
";
// echo $sql;
    $r= $conexion -> query($sql);
    $GranCantidad=0;
    $b = 0;
    $styleG="style='background-color: green; color:black; font-weight:bold;'";
    while($f = $r -> fetch_array()) {
        echo "<tr >";
            echo "<td>".$f['Sex']."</td>";
            echo "<td>".$f['n']."</td>";
            
            echo "<td align=right>$".number_format($f['Cantidad'],2,'.',',')."</td>";

        
            $GranCantidad = $GranCantidad + $f['Cantidad'];
            $b = $b +1;
        echo "</tr>";
    }
    // echo "<tr ".$styleG."><td></td><td>".$b." beneficiarios</td><td align=right><b>$".number_format($GranCantidad)."</b></td></tr>";
    echo "</table>";
}
    





//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\

if (isset($_GET['busqueda'])){
    if (is_numeric($_GET['busqueda'])){
        echo "<hr><h4>Distribución por Género  de  ".$_GET['busqueda']."</h4>";     
        $sql = "
        select 
            DISTINCT(nfer_concepto )as IdConcepto,
            (select cat_fer.fer_descripcion from cat_fer where cat_fer.fer_IdCon = IdConcepto) as Concepto,
            (select count(*) from fer where nfer_concepto = IdConcepto and estado=0 and ejercicio='".$_GET['busqueda']."') as n,
            (select sum(cantidad) from fer where nfer_concepto = IdConcepto and estado=0 and ejercicio='".$_GET['busqueda']."') as Cantidad
            

        from
            fer

            
        where 
            nombre like '%".$_GET['busqueda']."%'
            OR ejercicio like '%".$_GET['busqueda']."%'
            and estado=0
        ";
    } 
}
else{
    //sin busqueda
    $sql = "
    select 
        DISTINCT(nfer_concepto )as IdConcepto,
        (select cat_fer.fer_descripcion from cat_fer where cat_fer.fer_IdCon = IdConcepto) as Concepto,
        (select count(*) from fer where nfer_concepto = IdConcepto and estado=0 and ejercicio='".$ejercicio."') as n,
        (select sum(cantidad) from fer where nfer_concepto = IdConcepto and estado=0 and ejercicio='".$ejercicio."') as Cantidad
        

    from
        fer

        
    where 
        ejercicio = '".$ejercicio."'
        and estado=0
    
";
    echo "<hr><h4>Distribución por concepto ".$ejercicio."</h4>";
}


if (isset($_GET['busqueda'])){
    if (is_numeric($_GET['busqueda'])){
        echo "<table class='tabla2'>
            <th>Concepto </th>
            <th>Beneficiarios </th>
           
            <th>Cantidad </th>
            
            
            
            
        ";
        // echo $sql;
        $r= $conexion -> query($sql);
        $GranCantidad=0;
        $b = 0;
        $styleG="style='background-color: green; color:black; font-weight:bold;'";
        while($f = $r -> fetch_array()) {
            echo "<tr >";
                echo "<td>".$f['Concepto']."</td>";
                echo "<td>".$f['n']."</td>";
                
                echo "<td align=right>$".number_format($f['Cantidad'],2,'.',',')."</td>";

              
                $GranCantidad = $GranCantidad + $f['Cantidad'];
                $b = $b +1;
            echo "</tr>";
        }
        // echo "<tr ".$styleG."><td></td><td>".$b." beneficiarios</td><td align=right><b>$".number_format($GranCantidad)."</b></td></tr>";
        echo "</table>";
    }

} else {
    echo "<table class='tabla2'>
            <th>Concepto </th>
            <th>Beneficiarios </th>
           
            <th>Cantidad </th>
            
            
            
            
        ";
        // echo $sql;
        $r= $conexion -> query($sql);
        $GranCantidad=0;
        $b = 0;
        $styleG="style='background-color: green; color:black; font-weight:bold;'";
        while($f = $r -> fetch_array()) {
            echo "<tr >";
                echo "<td>".$f['Concepto']."</td>";
                echo "<td>".$f['n']."</td>";
                
                echo "<td align=right>$".number_format($f['Cantidad'],2,'.',',')."</td>";

              
                $GranCantidad = $GranCantidad + $f['Cantidad'];
                $b = $b +1;
            echo "</tr>";
        }
        // echo "<tr ".$styleG."><td></td><td>".$b." beneficiarios</td><td align=right><b>$".number_format($GranCantidad)."</b></td></tr>";
        echo "</table>";
}
    







//------------------------------

echo "</td></tr>";



    
    echo "</table>";            


    
    
    echo "</div>";











    echo "<div id='fer_g'>";
    //echo "<h4>Resumen del Ejercicio del presente año</h4>";
    echo "<h4 style='font-size: 16px;'>Resumen de aplicación del fondo en la Presente Administración</h4>";
    
    echo "<h4 style='font-size: 14px;'>".date_format(date_create(FechaInicioAdmin()), 'd-m-Y')." al ".date_format(date_create(FechaTerminaAdmin()), 'd-m-Y')." </h4>";
    
    echo "<table class='tabla2'>";
    $FondoEconomicoDeReserva = FondoEconomicoDeReserva();
    
       // $sql = "select * from fer where ejercicio='".date('Y')."' and estado=0";
        $sql=" SELECT Cantidad as cantidad, ejercicio, nfer_id
        FROM fer
        where autorizo_fecha>='".FechaInicioAdmin()."' and autorizo_fecha<='".FechaTerminaAdmin()."' and estado=0";
        
        //where autorizo_fecha>='2022-10-01 00:00:00' and autorizo_fecha<='2028-09-30 23:59:59' and estado=0";

        $r= $conexion -> query($sql);
        $GranCantidad=0;
        $b = 0;
        while($f = $r -> fetch_array()) {
                $GranCantidad = $GranCantidad + $f['cantidad'];
                $b = $b +1;
       
        }
        echo "<tr><td>Fondo:</td><td> $".number_format($FondoEconomicoDeReserva,2,'.',',')."</td></tr>";
        echo "<tr><td>Utilizado:</td><td>$ ".number_format($GranCantidad,2,'.',',')."</td></tr>";
        $FondoRestante = $FondoEconomicoDeReserva - $GranCantidad;
        echo "<tr><td>Fondo Disponible: </td><td>$".number_format($FondoRestante,2,'.',',')."</td></tr>";
        
    echo "</table>";


$data =   "['Fondo', 'Cantidad'],
['Fondo restante',     $FondoRestante],
['Utilizado',      $GranCantidad]
";

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
<div id="donutchart" style="width: 350px; height: 400px; background-color:pink;"></div>

';
echo $grafica;

echo "<p style='font-size:8pt; color:gray;'><b>SUSTENTO</b>: ".FER_sustento();
echo "<br><a href='fer/acta63.pdf' target=blank>Ver Acta 63</a>";
echo " | <a href='fer/acta65.pdf' target=blank>Ver Acta 65</a>";
echo "</p>";

    echo "</div>";





    if (isset($_POST['ferAdd']) and $nivel==1){        

        $ejercicio = date('Y');
        //$NferId = Nfer_new(FALSE);
        $NferId = Nfer_new2(TRUE);

        $nuevocert=Ncert_new(TRUE);
       // $NferId = $ejercicio.$NferId;
        $contrato = $_POST['contrato'];
        $nombre = $_POST['beneficiario'];
        $curp = $_POST['curp'];
        $nfer_concepto = $_POST['concepto_id'];
        $cantidad = $_POST['cantidad'];
        $nacimiento = $_POST['nacimiento'];
        $domicilio = $_POST['domicilio'];
        $telefono = $_POST['telefono'];
        $celular = $_POST['celular'];
        $IdMunicipio = $_POST['IdMunicipio'];
        $sexo = $_POST['sexo'];
        $descripcion = $_POST['descripcion'];
        $parrafo_opcional = $_POST['parrafo_opcional'];
        //validaciones pendientes:
        //validamos que no se pase del fondo que hay
       // $Disponible = FERdisponible();
        $Disponible = FERdisponibleSexenio();
        if ($cantidad <= $Disponible){

            //segunda validacion, la fecha de fin
            //if ($fecha <= FER_fechafin()){
            if ($fecha <= FechaTerminaAdmin()){    
                
                   // if (FER_curp($curp)==""){
                        //....
                        $sql = "INSERT INTO fer
                        (nfer_id, ejercicio,numcertificado, contrato, nombre, curp, cantidad, nfer_concepto, nacimiento, domicilio, telefono, celular, autorizo, IdMunicipio, sexo, autorizo_fecha, autorizo_hora, descripcion, parrafo_opcional)
                        VALUES
                        ('$NferId', '$ejercicio','$nuevocert','$contrato','$nombre', '$curp', '$cantidad', '$nfer_concepto', '$nacimiento', '$domicilio', '$telefono', '$celular', '$nitavu', '$IdMunicipio', '$sexo','$fecha','$hora', '$descripcion','$parrafo_opcional')";

                        if ($conexion->query($sql) == TRUE)
                        {
                            $subida= subirpdf3('sustento','fer/'.$NferId.'.pdf');
                            historia($nitavu, "<b >Creo un nuevo certificado del Fondo Económico de Reserva con No. ".$NferId." para  ".$nombre.", con el contrato: ".$contrato." y CURP: ".$curp."</b>");
                            
                            
                            $msg = "
                            <p> Buen dia "."<br>
                            Esto es una notificación automatica de la Plataforma ITAVU<br>
                            Se le informa que se ha creado un nuevo certificado con No.".$NferId."
                            para consumir del Fondo Economico de Reserva para la persona ".$nombre." la cantidad de 
                            $ ".number_format($cantidad,2,'.',',')."</p>

                            <p> Puede seguir este movimiento en el modulo FER de la Plataforma </p>
                            <p> Saludos</p>
                            ";

                            
                            // notificacion_add (CATgerarquia_director(), "Nuevo Certificado FER ".$NferId, date('Y-m-d'), $nitavu, $msg);	
                            // notificacion_add (CATgerarquia_finanzas(), "Nuevo Certificado FER ".$NferId, date('Y-m-d'), $nitavu, $msg);	
                            // notificacion_add (CATgerarquia_coordinador(), "Nuevo Certificado FER ".$NferId, date('Y-m-d'), $nitavu, $msg);	
                            // notificacion_add (CATgerarquia_credito(), "Nuevo Certificado FER ".$NferId, date('Y-m-d'), $nitavu, $msg);	
                           
                            // notificacion_add (2809, "Nuevo Certificado FER ".$NferId, date('Y-m-d'), $nitavu, $msg);	//para seguimiento de la app
                           

                            // notificacion_add (CATgerarquia_contabilidad(), "Nuevo Certificado FER ".$NferId, date('Y-m-d'), $nitavu, $msg);	
                            // notificacion_add (CATgerarquia_finanzas(), "Nuevo Certificado FER ".$NferId, date('Y-m-d'), $nitavu, $msg);	
                            
                            
                            // historia($nitavu,"FER: ".$msg);


                         //   mensaje ("Se ha descontado correctamente el certificado ".$NferId." del Fondo Economico de Reserva",'fer.php');
                            mensaje ("Se ha descontado correctamente el certificado ".$nuevocert." del Fondo Economico de Reserva",'fer.php');
                        }
                        else
                        {
                            mensaje ("ERROR: al tratar de guardar el cerficado. ".$sql,'fer.php');
                        }
                        //........
                    // } else {
                    //     mensaje ("ERROR: ".FER_curp($curp),'fer.php');
                    // }
            } else {
                mensaje ("ERROR: Ya no puede utilizar el presente Fondo ya que la fecha actual excede la fecha (".FER_fechafin().")programada de uso del fondo",'fer.php');
            }


        } else {
            mensaje("ERROR: Tu Fondo actual (".$Disponible.") es insuficiente para cubrir la cantidad solicitada (".$cantidad.")",'fer.php');
        }

    }

    if (isset($_GET['del']) and $nivel==1){
        //marcar para  borrrar
        $sql = "UPDATE  fer
        set estado=1, descripcion='Desactivado por ".$nitavu.", ".nitavu_nombre($nitavu)."' where nfer_id='".$_GET['del']."'
        ";

        if ($conexion->query($sql) == TRUE)
        {
            historia($nitavu, "<b >Desactivo el certificado FER ".$_GET['del']."</b>");
            mensaje ("Se ha desactivado correctamente el certificado del Fondo Economico de Reserva",'fer.php');
            //mensaje ("Se ha desactivado correctamente el certificado ".$_GET['del']." del Fondo Economico de Reserva",'fer.php');
        }
        else
        {
            mensaje ("ERROR: al tratar de desactivar el cerficado. ".$sql,'fer.php');
        }
    }
    
   
}
else {
    mensaje ("ERROR: no tiene acceso a esta aplicacion",'');
}
























?>



<?php include ("./lib/body_footer.php"); ?>