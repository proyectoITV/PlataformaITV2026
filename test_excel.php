

<?php
$Contenido = '

<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:w="urn:schemas-microsoft-com:office:word" xmlns="http://www.w3.org/TR/REC-html40">
<head><title>Ejemplo Microsoft Office HTML</title></head>
<body>
<h1>Título 1</h1>
<h2>Título 2</h2>
<h3>Título 3</h3>
<p>Texto en nivel 3</p>
<h2>2º título 2</h2>
<h3>Otro título 3</h3>

<table width="100%">
<thead style="background-color:#A0A0FF;"><td nowrap>Columna A</td><td nowrap>Columna B</td><td nowrap>Columna C</td></thead>
<tr><td>A1</td><td>B1</td><td>C1</td></tr>
<tr><td>A2</td><td>B2 Prueba con texto laaaargo: Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla sed sapien 
ac tortor porttitor lobortis. Donec velit urna, vulputate eu egestas eu, lacinia non dolor. Cras lacus diam, tempus 
sed ullamcorper a, euismod id nunc. Fusce egestas velit sed est fermentum tempus. Duis sapien dui, consectetur eu 
accumsan id, tristique sit amet ante.</td><td>C2</td></tr>
<tr><td>A3</td><td>B3</td><td>C3</td></tr>
</table>


<p>Listas:</p>
<ul>
<li>elemento 1</li>
<li>elemento 2</li>
<li>elemento 3</li>
  <ul>
  <li>elemento 4</li>
  <li>elemento 5</li>
  <li>elemento 6</li>
      <ul>
      <li>elemento 7</li>
      <li>elemento 8</li>
      </ul>
  </ul>
<li>elemento 9</li>
<li>elemento 10</li>
</ul>
</body>
</html>

';


ExportarWord($Contenido,"Test");


function ExportarWord($Contenido, $Archivo){
    header('Content-type: application/vnd.ms-excel;charset=iso-8859-15');
    header('Content-Disposition: attachment; filename='.$Archivo.'.doc');
    echo $Tabla;


}

?>