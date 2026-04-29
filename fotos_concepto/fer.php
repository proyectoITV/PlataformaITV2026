<?php include ("./unica/body_head.php"); include ("./unica/body_menu.php"); ?>

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
    echo "<h5>".app_detalle($id_aplicacion)."</h5>";        
    xd_update('ap74',$nitavu);//guarda la experiencia del usuario
    historia($nitavu, "Entro a la App [ap74] Administracion de Fondo Economico de Reserva");
    
    echo "<table width=100%><tr><td width=90%>";
    buscar('fer.php', 'Nombre del beneficiario', '');
    echo "</td><td>";
    if ($nivel==1){
        echo "<a class='pc' href='#add' rel='modal:open'>";
        echo "<img src='icon/editar.png' style='width:80px'>";
        echo "</a>";
    }
    echo "</td></tr></table>";


    echo "<div class=''>";
    echo "</div>";

    echo "<form id='add' action='fer.php' method='post' enctype='multipart/form-data' class='modal'>
    <h1>Crear certificado del Fondo Economico de Reserva</h1>
    <span><label>Nombre del Beneficiario:</label>
        <input type='text' placeholder='' id='beneficiario' name='beneficiario' value='' required>
    </span>
    
    <div><label>CURP:</label>
        <input style='background-color:#F7A724;'  type='text' placeholder='' id='curp' name='curp' value='' required>
    </div>

    <div><label>Contrato:</label>
        <input type='text' placeholder='' id='contrato' name='contrato' value='' required>
    </div>

    <div><label>Fecha de Nacimiento:</label>
        <input type='date' placeholder='' id='nacimiento' name='nacimiento' value='' required>
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
            
        $sql = "select * from cat_municipios";
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
        <input type='submit'  class='btn btn-default' id='ferAdd' name='ferAdd' value='Disponer' >
    </div>

  
    

<label>* Por favor capture correctamente, de acuerdo a expediente. Por el momento no hay una validacion del contrato o curp.</label>
    </form>";


    echo "<div id='fer_lista'>";

    echo "<table width=100%><tr><td>";
    $ejercicio = date('Y');


    if (isset($_GET['busqueda'])){
        echo "<h4>Busqueda de  ".$_GET['busqueda']."</h4>";
        historia($nitavu, "Busco ".$_GET['busqueda']." en FER");
        $sql = "select * from fer where nombre like '%".$_GET['busqueda']."%' or ejercicio like '%".$_GET['busqueda']."%'";
    }
    else{
        $sql = "select * from fer where ejercicio='".$ejercicio."'";
        echo "<h4>Ejercicio ".$ejercicio."</h4>";
        historia($nitavu, "Vio el ejercicio de ".$ejercicio." en FER");
    }

            
            echo "<table class='tabla'>
                <th class='pc'>IdFer </th>
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
                    echo "<td class='pc'>".$f['nfer_id']."</td>";
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
                    
                        $d = "";
                        $d = "<div id='".$f['nfer_id']."' class='modal'>";
                        $d = $d."<p style='font-size:10pt;'><b class='normal'>".$f['nombre']."</b><br><b>CURP:</b> ".$f['curp']."<br>";
                        $d = $d."<b>Numero de certificado:</b> ".$f['nfer_id'].",<b>CONTRATO:</b> ".$f['contrato']."<br>";
                        $d = $d."<b>Fecha de Nacimiento: </b>".$f['nacimiento'].", <b>Cantidad:</b> $".number_format($f['cantidad'],2,'.',',')."<br>";
                        $d = $d."<b>Domicilio:</b> ".$f['domicilio'].". <b>Telefono:</b> ".$f['telefono'].",<b> Celular:</b> ".$f['celular'];
                        $d = $d."<br>".$f['descripcion']."<br>";
                        $archivo = 'fer/'.$f['nfer_id'].".pdf";
                        if (file_exists($archivo)){
                            $d = $d."<a href='".$archivo."' class='btn btn-tercero' target=blank>Archivo de sustento</a>";
                        }

                        

                        $d = $d."<br><br>Lo autorizo: ".$f['autorizo']." | ".nitavu_nombre($f['autorizo'])." el dia ".$f['autorizo_fecha']." a las ".$f['autorizo_hora'];
                        $d = $d."</p></div>";
                        
                        echo $d;

                        echo "<a href='#".$f['nfer_id']."' rel='modal:open' class='btn btn-secundario'><img src='icon/info.png' style='width:15px;'></a>";

                        if ($f['estado'] == 0 and $nivel==1){
                            echo " <a href='?del=".$f['nfer_id']."' class='btn btn-secundario'><img src='icon/x.png' style='width:15px;'></a>";
                            echo " <a href='fer_print.php?print=".$f['nfer_id']."' class='btn btn-secundario'><img src='icon/imprimir.png' style='width:15px;'></a>";
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
            
    echo "</td></tr><tr><td>";
    ////////////////////


    
    if (isset($_GET['busqueda'])){
        if (is_numeric($_GET['busqueda'])){
            echo "<hr><h4>Distribucion por Municipio  de  ".$_GET['busqueda']."</h4>";     
            $sql = "
            select 
                DISTINCT(IdMunicipio) as Mun,
                (select cat_municipios.Municipio from cat_municipios where cat_municipios.IdMunicipio = Mun) as Nombre,
                (select count(*) from fer where (IdMunicipio = Mun and  ejercicio like '%".$_GET['busqueda']."%') OR  nombre like '%".$_GET['busqueda']."%' and estado = 0) as n,
                (select sum(cantidad) from fer where (IdMunicipio = Mun and ejercicio like '%".$_GET['busqueda']."%') OR nombre like '%".$_GET['busqueda']."%' and estado=0) as Cantidad,
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
            DISTINCT(IdMunicipio) as Mun,
            (select cat_municipios.Municipio from cat_municipios where cat_municipios.IdMunicipio = Mun) as Nombre,
            (select count(*) from fer where IdMunicipio = Mun and ejercicio='".$ejercicio."' and estado = 0) as n,
            (select sum(cantidad) from fer where IdMunicipio = Mun and ejercicio ='".$ejercicio."' and estado=0) as Cantidad,
            ejercicio
            
            
        from 
            fer
        where ejercicio = '".$ejercicio."' and estado=0
";
        echo "<hr><h4>Distribucion por municipio del ejercicio ".$ejercicio."</h4>";
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
        echo "<hr><h4>Distribucion por Genero  de  ".$_GET['busqueda']."</h4>";     
        $sql = "
        select 
            DISTINCT(sexo) as Sex,
            
            (select count(*) from fer where (sexo = Sex and  ejercicio like '%".$_GET['busqueda']."%') OR  nombre like '%".$_GET['busqueda']."%' and estado=0) as n,
            (select sum(cantidad) from fer where (sexo = Sex and ejercicio like '%".$_GET['busqueda']."%') OR nombre like '%".$_GET['busqueda']."%' and estado=0) as Cantidad,
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
    echo "<hr><h4>Distribucion por genero del ejercicio ".$ejercicio."</h4>";
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
        echo "<hr><h4>Distribucion por Genero  de  ".$_GET['busqueda']."</h4>";     
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
    echo "<hr><h4>Distribucion por concepto ".$ejercicio."</h4>";
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
    echo "<h4>Resumen del Ejercicio del presente año</h4>";
    echo "<table class='tabla2'>";
    $FondoEconomicoDeReserva = FondoEconomicoDeReserva();
        $sql = "select * from fer where ejercicio='".date('Y')."' and estado=0";
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
        $NferId = Nfer_new(FALSE);
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
        $Disponible = FERdisponible();
        if ($cantidad <= $Disponible){

            //segunda validacion, la fecha de fin
            if ($fecha <= FER_fechafin()){

                   // if (FER_curp($curp)==""){
                        //....
                        $sql = "INSERT INTO fer
                        (nfer_id, ejercicio, contrato, nombre, curp, cantidad, nfer_concepto, nacimiento, domicilio, telefono, celular, autorizo, IdMunicipio, sexo, autorizo_fecha, autorizo_hora, descripcion, parrafo_opcional)
                        VALUES
                        ('$NferId', '$ejercicio', '$contrato','$nombre', '$curp', '$cantidad', '$nfer_concepto', '$nacimiento', '$domicilio', '$telefono', '$celular', '$nitavu', '$IdMunicipio', '$sexo','$fecha','$hora', '$descripcion','$parrafo_opcional')";

                        if ($conexion->query($sql) == TRUE)
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

                            
                            // notificacion_add (CATgerarquia_director(), "Nuevo Certificado FER ".$NferId, date('Y-m-d'), $nitavu, $msg);	
                            // notificacion_add (CATgerarquia_finanzas(), "Nuevo Certificado FER ".$NferId, date('Y-m-d'), $nitavu, $msg);	
                            // notificacion_add (CATgerarquia_coordinador(), "Nuevo Certificado FER ".$NferId, date('Y-m-d'), $nitavu, $msg);	
                            // notificacion_add (CATgerarquia_credito(), "Nuevo Certificado FER ".$NferId, date('Y-m-d'), $nitavu, $msg);	
                           
                            // notificacion_add (2809, "Nuevo Certificado FER ".$NferId, date('Y-m-d'), $nitavu, $msg);	//para seguimiento de la app
                           

                            // notificacion_add (CATgerarquia_contabilidad(), "Nuevo Certificado FER ".$NferId, date('Y-m-d'), $nitavu, $msg);	
                            // notificacion_add (CATgerarquia_finanzas(), "Nuevo Certificado FER ".$NferId, date('Y-m-d'), $nitavu, $msg);	
                            
                            
                            // historia($nitavu,"FER: ".$msg);


                            mensaje ("Se ha descontado correctamente el certificado ".$NferId." del Fondo Economico de Reserva",'fer.php');
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
            mensaje ("Se ha desactivado correctamente el certificado ".$_GET['del']." del Fondo Economico de Reserva",'fer.php');
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



<?php include ("./unica/body_footer.php"); ?>