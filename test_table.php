
<?php
// include ("lib/seguridad.php"); 
include ("lib/body_head.php");
include ("lib/body_menu.php");




//Tabla Dinamica para MYSQL
$sql="select nitavu, nombre, telefono, numNoti, dpto, sueldo, compensacion from empleados where estado=''";
TablaDinamica_MySQL("",$sql, "MiIdDivTabla2", "IdTabla2", "Modulo", 2); //0 = Basica, 1 = ScrollVertical, 2 = Scroll Horizontal



//----- Ejemplo para hacerlo con MSSQL SERVER


//hacemos la consulta con el WebService de MSSQLSERVER
$IdDelegacion = 6; //IdDe la Delegacion sobre la que consumiras el webservice
$IdDiv = "MiIdDiv"; //El id del contenedos de la tabla
$Clase = "Modulo"; //Nombre de la clase del contenedos
$IdTabla = "IdMiTabla"; //Id de la Tabla



$sql = " select top 10 IdPrograma, Programa, Descripcion from PROGRAMA";
$ConsultaDATA = DatosViviendaLarge($IdDelegacion, "TablaDinamica", "TablaDinamica", $sql);
$array = json_decode($ConsultaDATA, true);

//recorremos y creamos la tabla HTML

$tbCont = '<div id="'.$IdDiv.'" class="'.$Clase.'"><table id="'.$IdTabla.'" class="display" style="width:100%" class="tabla" style="font-size:8pt;">';

//creamos los encabezados de la tabla
$tbCont = $tbCont."  
<thead>
<tr>
    <td>IdPrograma</td>
    <td>Programa</td>
    <td>Descripcion</td>
</tr>
</thead>"; //Encabezados        
$tbCont = $tbCont."<tbody class='tabla'>"; //ponemos la clase de la plataforma en la tbla

    if(is_array($array)){            
         foreach ($array as $value) {
            if (isset($value['r'])){// si hay un error
                echo "Error: ".$value['r'];
    
            } else {
                
                //creamos el contenido en funcion de los encabezados
                $tbCont = $tbCont."<tr>";
                $tbCont = $tbCont."<td>".$value['IdPrograma']."</td>";
                $tbCont = $tbCont."<td>".$value['Programa']."</td>";
                $tbCont = $tbCont."<td>".$value['Descripcion']."</td>";
                $tbCont = $tbCont."</tr>";
             
    
            }
               
         }
    } else {
        echo "ERROR: No es un array";
    }

$tbCont = $tbCont."</tbody>";
$tbCont = $tbCont."</table></div>";

// echo $tbCont;

//Usamos la funcion para la tabla pero, en vez de darle el $sql le daremos la tabla ya hecha, indicarle el resto de las variables
TablaDinamica_MySQL($tbCont, "", $IdDiv, $IdTabla, $Clase, 0); //0 = Basica, 1 = ScrollVertical, 2 = Scroll Horizontal



?>
<button id="download">DESCARGAR PDF</button>
<script>
$(function() { 
 $('#download').click(function() {
  var options = {
  };
  var pdf = new jsPDF('p', 'pt', 'a4');
  pdf.addHTML($("#MiIdDivTabla2"), 15, 15, options, function() {
    pdf.save('informe.pdf');
  });
 });
});
</script>

<script type="text/javascript" src="lib/html2canvas.js"></script>
		<script type="text/javascript">
			html2canvas(document.body).then(function(canvas) {
				document.body.appendChild(canvas);
			});
		</script>
<?php



include ("./lib/body_footer.php");
?>

