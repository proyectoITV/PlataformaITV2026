<?php include ("./unica/body_head.php"); include ("./unica/body_menu.php"); ?>
<script>
</script>
<?php

    echo "<h1>Crea la solicitud para el programa tal...</h1>";
//     echo "<div id='result'></div>";
      
// $idprog=1;
//     echo "<div id='bloque1' style='width:100%'>"; 
//         echo "<h2>Datos Generales</h2>";
//         echo "<div  id='contenedor' style='float: left; width: 48%; height: 300px; border-style: solid; border-color: coral;' class='ui orange basic button' ondrop='dropAgregar(this, event)'ondragenter='return false' ondragover='return false'>
//                 <div><span id='span1'><b>Campos Agregados</b></span></div></div>";  
//         echo "<div id='contenedor2' style='float: right; width: 48%; height: 300px; border-style: solid; border-color: coral;' class='ui orange basic button' ondrop='dropEliminar(this, event)'ondragenter='return false' ondragover='return false'>";
//             echo "<div ><span id='span1'><b>Campos Disponibles</b></span></div>";
//             $query="select * from TramitesRequisitos where IdCatRequisitos = 1";  
//             $descripcion = '';
//             $vuelta =0;
//        //$background_colors = array('red', 'orange', 'yellow', 'olive', 'green', 'blue', 'violet', 'purple', 'pink', 'brown','grey','teal');
//        //$rand_background = $background_colors[array_rand($background_colors)];     
//        $r = $conexion -> query($query);
//             while($f = $r -> fetch_array())
//             {
//                 $vuelta++;
//                 echo " <div class='caja ui orange button'  id='".$f['IdRequisito']."' draggable='true' ondragstart='dragstart(this, event)'> 
//                 ".$f['NombreRequisito']."</div>";
//             }
//         echo "</div>";
//     echo "</div>";
//     echo "<br>";
//     echo "<br>";

//     echo "<div id='result'></div>";
//     echo "<br>";
    
        
//     echo "<div id='bloque2' style='width:100%'>"; 
//         echo "<h2>Datos Domicilio</h2>";
//         echo "<div  id='contenedor' style='float: left; width: 48%; height: 300px; border-style: solid; border-color: blue;' class='ui green basic button' ondrop='dropAgregar(this, event)'ondragenter='return false' ondragover='return false'>
//                 <div><span id='span1'><b>Campos Agregados</b></span></div></div>";  
//         echo "<div id='contenedor2' style='float: right; width: 48%; height: 300px;  border-style: solid; border-color: blue;' class='ui green basic button' ondrop='dropEliminar(this, event)'ondragenter='return false' ondragover='return false'>";
//             echo "<div ><span id='span1'><b>Campos Disponibles</b></span></div>";
//             $query="select * from TramitesRequisitos where IdCatRequisitos = 2";  
//             $descripcion = '';
//             $vuelta =0;
//        //$background_colors = array('red', 'orange', 'yellow', 'olive', 'green', 'blue', 'violet', 'purple', 'pink', 'brown','grey','teal');
//        //$rand_background = $background_colors[array_rand($background_colors)];     
//        $r = $conexion -> query($query);
//             while($f = $r -> fetch_array())
//             {
//                 $vuelta++;
//                 echo " <div class='caja ui green button'  id='".$f['IdRequisito']."' draggable='true' ondragstart='dragstart(this, event)'> 
//                 ".$f['NombreRequisito']."</div>";
//             }
//         echo "</div>";
//     echo "</div>";
//     echo "<br>";

    

//     echo "<div id='bloque3' style='width:100%'>"; 
//         echo "<h2>Datos Vivienda</h2>";
//         echo "<div  id='contenedor' style='float: left; width: 48%; height: 300px;  border-style: solid; border-color: green;' class='ui blue basic button' ondrop='dropAgregar(this, event)'ondragenter='return false' ondragover='return false'>
//                 <div><span id='span1'><b>Campos Agregados</b></span></div></div>";  
//         echo "<div id='contenedor2' style='float: right; width: 48%; height: 300px;  border-style: solid; border-color: green;' class='ui blue basic button' ondrop='dropEliminar(this, event)'ondragenter='return false' ondragover='return false'>";
//             echo "<div ><span id='span1'><b>Campos Disponibles</b></span></div>";
//             $query="select * from TramitesRequisitos where IdCatRequisitos = 3";  
//             $descripcion = '';
//             $vuelta =0;
//        //$background_colors = array('red', 'orange', 'yellow', 'olive', 'green', 'blue', 'violet', 'purple', 'pink', 'brown','grey','teal');
//        //$rand_background = $background_colors[array_rand($background_colors)];     
//        $r = $conexion -> query($query);
//             while($f = $r -> fetch_array())
//             {
//                 $vuelta++;
//                 echo " <div class='caja ui blue button'  id='".$f['IdRequisito']."' draggable='true' ondragstart='dragstart(this, event)'> 
//                 ".$f['NombreRequisito']."</div>";
//             }
//         echo "</div>";
//     echo "</div>";
//     echo "<br>";
            
//     echo "<button id='save' class='ui grey button' onclick='guardarDatos(".$idprog.")'>Guardar</button>";

//     echo "<br><br>";
//     echo "<center><div id='solicitud' style='display:none;'>";
//         echo "<div>";
//             echo "<br>";
//             echo "<label>Datos personales</label>";
//             echo '<input type="text" name="campo1" id="campo1" placeholder="Nombre" style="display:none;">';
//             echo "<input type='text' name='campo2' id='campo2' placeholder='Apellido Paterno' style='display:none;'>";
//             echo "<input type='text' name='campo3' id='campo3' placeholder='Apellido Materno' style='display:none;'>";
            
//         echo "</div>";
//         echo "<button id='update' class='ui grey button' onclick=''>Modificar</button>";
//     echo "</div></center>";
             
echo '<div id="cuadro1" ondragenter="return enter(event)" ondragover="return over(event)" ondragleave="return leave(event)" ondrop="return drop(event)">';
    echo '<center>';
$query="select * from TramitesRequisitos where IdCatRequisitos = 1";  
$descripcion = '';
$vuelta =0;

$r = $conexion -> query($query);
while($f = $r -> fetch_array())
{
    $vuelta++;

    echo '<div class="cuadradito" id="'.$vuelta.'" draggable="true" ondragstart="start(event)" ondragend="end(event)">';
    echo $f['NombreRequisito'];
    echo '</div>' ;
}
echo '</center>';
echo '</div>
<div id="cuadro2" ondragenter="return enter(event)" ondragover="return over(event)" ondragleave="return leave(event)" ondrop="return drop(event)">
</div>';
        
?>

<script>
 /*
function dragstart(caja, event) {
    // el elemento a arrastrar
    event.dataTransfer.setData('Data', caja.id);
    
}

function drag(target, event) {
    console.log("drag");
    return false;
}

function dragend(target, event) {
    console.log("dragend");
    return false;
}

function dragenter(target, event) {
    console.log("dragenter");
    return false;
}

function dragleave(target, event) {
    console.log("dragleave");
    return false;
}

function dragover(event) {
    console.log("dragover");
    event.preventDefault();
    return false;
}

function dropAgregar(target, event) {
    //alert('entre en drop');
    var temp = [];
    // obtenemos los datos
    var caja = event.dataTransfer.getData('Data');
    
    // agregamos el elemento de arrastre al contenedor
    target.appendChild(document.getElementById(caja));
    var nom = document.getElementById(caja).innerHTML;

    var nom=document.getElementById(caja).innerHTML;

    var id=caja;
    console.log(nom);
    sessionStorage.setItem(nom,id); //ó sessionStorage[producto]=precio
    
    sessionStorage.setItem(nom, JSON.stringify(id));
  
}

function dropEliminar(target, event) {
   // alert('entre en dropEliminar');
    var temp = [];
    // obtenemos los datos
    var caja = event.dataTransfer.getData('Data');
    
    // agregamos el elemento de arrastre al contenedor
    target.appendChild(document.getElementById(caja));
    var nom = document.getElementById(caja).innerHTML;
    var nom=document.getElementById(caja).innerHTML;
    var id=caja;
    sessionStorage.removeItem(nom); //ó sessionStorage[producto]=precio


}

function guardarDatos(idprog){
    var ids = [];
    for(var i=0;i<sessionStorage.length;i++)
    {
        var nom=sessionStorage.key(i);
        var id=sessionStorage.getItem(nom);
         ids[i]=id;
    }

    $.ajax({ 
        type: "POST", 
        url: "mec_agregarcampos.php", 
        data: {data: ids, idprog:idprog }, 
        success: function(data) {    
            var cadena = data;
            document.getElementById('result').innerHTML = data;
            document.getElementById('bloque1').style.display = 'none';
            document.getElementById('bloque2').style.display = 'none';
            document.getElementById('bloque3').style.display = 'none';
            document.getElementById('save').style.display = 'none';
            document.getElementById('solicitud').style.display = 'inline-block';
            arr = cadena.split(',');
            
            for(i=0 ; i<arr.length; i++){
                             
                document.getElementById('campo'+arr[i].trim()).style.display = 'inline-block';
            }
           
            
        } 
    }); 
 
}*/
function start(e) {
    e.dataTransfer.effecAllowed = 'move'; // Define el efecto como mover (Es el por defecto)
    e.dataTransfer.setData("Data", e.target.id); // Coje el elemento que se va a mover
    e.dataTransfer.setDragImage(e.target, 0, 0); // Define la imagen que se vera al ser arrastrado el elemento y por donde se coje el elemento que se va a mover (el raton aparece en la esquina sup_izq con 0,0)
    e.target.style.opacity = '0.4'; 
}

function end(e){
    e.target.style.opacity = ''; // Pone la opacidad del elemento a 1           
    e.dataTransfer.clearData("Data");
}

function enter(e) {
    e.target.style.border = '3px dotted #555'; 
}

function leave(e) {
    e.target.style.border = ''; 
}

function over(e) {
    var elemArrastrable = e.dataTransfer.getData("Data"); // Elemento arrastrado
    var id = e.target.id; // Elemento sobre el que se arrastra
    
    // return false para que se pueda soltar
    if (id == 'cuadro1'){
        return false; // Cualquier elemento se puede soltar sobre el div destino 1
    }

    if ((id == 'cuadro2') && (elemArrastrable != 'arrastrable3')){
        return false; // En el cuadro2 se puede soltar cualquier elemento menos el elemento con id=arrastrable3
    }   
 
}


/*---------------------Mueve el elemento-------------------------*/
function drop(e){

    var elementoArrastrado = e.dataTransfer.getData("Data"); // Elemento arrastrado
    console.log(elementoArrastrado);
    var padre = $('#'+elementoArrastrado).parent();
    console.log(padre);
    e.target.appendChild(document.getElementById(elementoArrastrado));
    e.target.style.border = '';  // Quita el borde
    tamContX = $('#'+e.target.id).width();
    tamContY = $('#'+e.target.id).height();

    tamElemX = $('#'+elementoArrastrado).width();
    tamElemY = $('#'+elementoArrastrado).height();

    //console.log(tamElemX+'-'+tamElemY);
    posXCont = $('#'+e.target.id).position().left;
    posYCont = $('#'+e.target.id).position().top;
    //console.log(posXCont+'-'+posYCont);
    // Posicion absoluta del raton
    x = e.layerX;
    y = e.layerY;

    // Si parte del elemento que se quiere mover se queda fuera se cambia las coordenadas para que no sea asi
    if (posXCont + tamContX <= x + tamElemX){
        x = posXCont + tamContX - tamElemX;
    }

    if (posYCont + tamContY <= y + tamElemY){
        y = posYCont + tamContY - tamElemY;
    }

    document.getElementById(elementoArrastrado).style.position = "absolute";
    document.getElementById(elementoArrastrado).style.left = x + "px";
    document.getElementById(elementoArrastrado).style.top = y + "px";
    //idpadre = document.getElementById(padre);
   
   var  idpadre =$(padre).attr("id");
    console.log('idpadre'+idpadre);
    if(idpadre=='cuadro1'){
        console.log("es agregar");
        $.ajax({
            url: "mec_agregarcampos.php",
            type: "post",        
            data: {IdTipoTramite:500, IdRequisito:elementoArrastrado, Clase:500, tipo:1},
            success: function(data){                                
                  
            }
        });
    }else{
        console.log('es quitar');
        $.ajax({
            url: "mec_agregarcampos.php",
            type: "post",        
            data: {IdTipoTramite:500, IdRequisito:elementoArrastrado, Clase:500, tipo:2},
            success: function(data){                                
               
            }
        });
    }
}


       
</script>
<?php include ("./unica/body_footer.php"); ?> 