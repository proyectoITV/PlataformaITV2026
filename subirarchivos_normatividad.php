<link href="css/style.css" rel="stylesheet">
<link href="css/slick.css" rel="stylesheet">
<link href="css/responsive.css" rel="stylesheet">

<?php
//require("config.php");
include("./lib/body_head.php");
include("./lib/body_menu.php");
require_once('lib/laura_funciones.php');
require_once('lib/flor_funciones.php');
require_once('lib/yes_funciones.php');
?>


<?php
$id_aplicacion = "ci";
xd_update('ci', $nitavu);//guarda la experiencia del usuario
$nivel = aplicacion_nivel($id_aplicacion, $nitavu);
echo "<div id='AppDetalle'>" . app_detalle($id_aplicacion, $nitavu) . "</div>";





// ACTUALIZAR GRUPO Y ORDEN DE UN ARCHIVO
if (isset($_POST['actualizarDoc'])) {
  $idDoc = intval($_POST['idDoc']);
  $grupo = intval($_POST['grupo']);
  $orden = intval($_POST['orden']);

  $sql = "UPDATE ci SET grupo = $grupo, OrdenVisual = $orden WHERE IdCi = $idDoc";
  if ($conexion->query($sql) == TRUE) {
    historia($nitavu, 'Actualice grupo (' . $grupo . ') y orden (' . $orden . ') del archivo con id: ' . $idDoc);
    mensaje('Archivo actualizado con éxito', 'subirarchivos_normatividad.php');
  } else {
    mensaje('Ocurrió un error al actualizar el archivo.', 'subirarchivos_normatividad.php');
  }
}

//Subir archivo en el historial
if (isset($_POST['subirHistorial'])) {
  $dir_subida = 'ci/';
  $fichero_subido = $dir_subida . basename($_FILES['nuevoDoc']['name']);
  $nombre = basename($_FILES['nuevoDoc']['name']);
  echo '<pre>';
  if (move_uploaded_file($_FILES['nuevoDoc']['tmp_name'], $fichero_subido)) {
    $pos = strpos($nombre, '.');
    $extension = substr($nombre, $pos + 1, strlen($nombre));

    $id = ObtenerIdCid();
    $id = $id + 1;
    if ($extension == 'mp4') {
      $icon = 'video.png';
      $descripcion = 'Video';
    } else {
      $icon = 'pdf.png';
      $descripcion = 'Documento';
    }

    $grupo = isset($_POST['grupo']) ? intval($_POST['grupo']) : 1;
    $orden = isset($_POST['orden']) ? intval($_POST['orden']) : 1;

    $sql = "INSERT INTO ci(IdCi, Nombre, Descripcion, Link, Cancelado, icon, fechadepublicacion, grupo, OrdenVisual) 
                            VALUES ($id, '$nombre', '$descripcion', '$nombre', '0', '$icon', Now(), $grupo, $orden)";

    if ($conexion->query($sql) == TRUE) {
      mensaje('Archivo subido con exito', 'ci.php');
    } else {
      mensaje('Ocurrio un error al momento de subir el archivo.', 'subirarchivos_normatividad.php');
    }
  } else {
    mensaje('Ocurrio un error al momento de subir el archivo.', 'subirarchivos_normatividad.php');
  }
}

//ELIMINAR UN ARCHIVO DEL HISTORIAL DE DOCUMENTOS
if (isset($_GET['idDoc'])) {
  $idDoc = $_GET['idDoc'];
  // $id = $_POST['id'];
  //$numDoc = $_POST['numDoc'];

  $sql = "Update ci SET cancelado=1 WHERE IdCi=" . $idDoc . "";
  echo $sql;
  if ($conexion->query($sql) == TRUE) {
    historia($nitavu, 'cp_Elimine (marco como eliminado) el archivo con id: ' . $idDoc);

    mensaje('Se ha eliminado con éxito el archivo.', 'ci.php');

  } else {
    mensaje('Ocurrio un error al momento de eliminar, por favor intentelo de nuevo.', 'subirarchivos_normatividad.php');
  }
}

echo "<div id='anexos'>";

echo "
<section class='page-title' style='background-image:url(img/controlinterno.jpg); '>
    <div class='auto-container'>
        <h2>Departamento de Control Interno</h2>
    </div>
</section>
";

echo "<br>";
echo "
<div class='content'>
    <h1 style = 'color:black; text-align: center;'>Historial de archivos</h1>
</div>
";

echo "<div class='container' style='background-color: #ddddddb0; padding: 20px; border-radius: 10px; margin-top: 30px; '>";
echo "<table class='styled-table' width='100%'>";
echo "<thead>";
echo "<tr>";
echo "<th width='2%'>Cve</th>";
echo "<th width='40%'>Nombre del documento</th>";
echo "<th width='15%'>Descripción</th>";
echo "<th width='8%'>Vistas</th>";
echo "<th width='12%'>Publicación</th>";
echo "<th width='13%'>Grupo</th>";
echo "<th width='5%'>Orden</th>";
echo "<th width='10%'>Acción</th>";
echo "</tr>";
echo "</thead>";
echo "<tbody>";
require("config.php");
$sql = "SELECT ci_html.*, ci.grupo, ci.OrdenVisual 
              FROM ci_html 
              JOIN ci ON ci_html.IdCi = ci.IdCi 
              ORDER BY ci.grupo ASC, ci.OrdenVisual ASC";
$r = $conexion->query($sql);
while ($f = $r->fetch_array()) {
  // Register form for inline modification
  echo "<form id='form-edit-" . $f['IdCi'] . "' action='subirarchivos_normatividad.php' method='POST'>";
  echo "<input type='hidden' name='actualizarDoc' value='1'>";
  echo "<input type='hidden' name='idDoc' value='" . $f['IdCi'] . "'>";
  echo "</form>";

  echo "<tr>";
  echo "<td>" . $f["IdCi"] . "</td>";
  echo "<td>" . $f["Documento"] . "</td>";
  echo "<td>" . $f["Descripcion"] . "</td>";
  echo "<td>" . $f["Vistas"] . "</td>";
  echo "<td>" . substr($f["fechadepublicacion"], 0, 16) . "</td>";

  // Grupo dropdown selector
  echo "<td>";
  echo "<select name='grupo' form='form-edit-" . $f['IdCi'] . "' class='form-control' style='padding: 2px 5px; height: auto;'>";
  $groupOptions = [
    1 => '1. MARCO NORMATIVO INSTITUCIONAL',
    2 => '2. ÉTICA, CONDUCTA Y PREVENCIÓN DE CONFLICTOS DE INTERÉS',
    3 => '3. ACTIVIDADES INSTITUCIONALES',
    4 => '4. UNIDAD DE IGUALDAD DE GÉNERO',
    5 => '5. COMITÉ DE COMPRAS'
  ];
  foreach ($groupOptions as $val => $label) {
    $selected = ($f['grupo'] == $val) ? 'selected' : '';
    echo "<option value='$val' $selected>$label</option>";
  }
  echo "</select>";
  echo "</td>";

  // Visual Order input
  echo "<td>";
  echo "<input type='number' name='orden' form='form-edit-" . $f['IdCi'] . "' value='" . $f['OrdenVisual'] . "' style='width: 50px; padding: 2px; text-align: center;' min='1'>";
  echo "</td>";

  // Actions (Save changes / Delete)
  echo "<td style=' text-align: center;'>";
  echo "<div style='display: flex; gap: 5px; justify-content: center;'>";
  echo "<button type='submit' form='form-edit-" . $f['IdCi'] . "' class='Mbtn btn-default' title='Guardar cambios' style='padding: 4px 8px;'> <img src='icon/subirDoc.png' style='width:16px; '> </button>";
  echo "<a href='subirarchivos_normatividad.php?idDoc=" . $f['IdCi'] . "' class='Mbtn btn-cancel' title='Eliminar archivo' style='padding: 4px 8px; display: inline-block;' onclick='return confirm(\"¿Seguro que desea marcar como eliminado este archivo?\");'> <img src='icon/delete.png' style='width:16px; '> </a>";
  echo "</div>";
  echo "</td>";
  echo "</tr>";
}

// Add upload row at the bottom
echo "<tr>";
echo "<td></td>";

echo '<td>';
echo "<form id='form-upload' action='subirarchivos_normatividad.php' method='POST' enctype='multipart/form-data'>";
echo '<input type="hidden" name="subirHistorial" value="1">';
echo '<input name="nuevoDoc" type="file" required style="width: 100%;">';
echo '</td>';

echo "<td></td>"; // Desc
echo "<td></td>"; // Vistas
echo "<td></td>"; // Publicacion

// Group selector in upload row
echo "<td>";
echo "<select name='grupo' form='form-upload' class='form-control' style='padding: 2px 5px; height: auto;'>";
echo "<option value='1'>1. MARCO NORMATIVO INSTITUCIONAL</option>";
echo "<option value='2'>2. ÉTICA, CONDUCTA Y PREVENCIÓN DE CONFLICTOS DE INTERÉS</option>";
echo "<option value='3'>3. ACTIVIDADES INSTITUCIONALES</option>";
echo "<option value='4'>4. UNIDAD DE IGUALDAD DE GÉNERO</option>";
echo "<option value='5'>5. COMITÉ DE COMPRAS</option>";
echo "</select>";
echo "</td>";

// Visual Order input in upload row
echo "<td>";
echo "<input type='number' name='orden' form='form-upload' value='1' style='width: 50px; padding: 2px; text-align: center;' min='1'>";
echo "</td>";

echo "<td style=' text-align: center;'>";
echo "<button type='submit' form='form-upload' class='Mbtn btn-default' title='Haga clic para subir el archivo' style='padding: 4px 8px;'> <img src='icon/subirDoc.png' style='width:20px; '> </button>";
echo "</td>";
echo "</form>";
echo "</tr>";

echo "</tbody>";
echo "</table>";
echo "</div>";


/* $anexos = "select * from ci where cancelado=0";
$rc= $conexion -> query($anexos); 
if ($rc->num_rows>0){
  echo "<center>";
  echo "<div style='width:100%;' >";
  echo "<br>";
  echo "<h4>Archivos disponibles</h4>";
  echo "<table id='historialTabla' class='styled-table' width='80%'>";

  echo "<thead>";
  echo "<tr>";
          echo "<th width='2%'>Cve</th>";
          echo "<th width='65%'>Nombre Archivo</th>";
          echo "<th width='10%'>Tipo</th>";
          echo "<th width='13%'>Publicación</th>";
          echo "<th width='10%'>Acción</th>";
  echo "</tr>";
  echo "</thead>";

  while($r = $rc -> fetch_array())    
  {
    echo "<tr>";
    echo "<td>".$r['IdCi']."</td>";
    echo "<td>".$r['Nombre']."</td>";
    echo "<td>".$r['Descripcion']."</td>";
    echo "<td>".substr($r["fechadepublicacion"], 0, 16)."</td>";
    echo "<td style=' text-align: center;'>";
    echo "<form action='subirarchivos_normatividad.php?idDoc=".$r['IdCi']."' method='POST'>";
    echo "<button type='submit' class='Mbtn btn-cancel' title='Haga clic para eliminar el archivo'> <img src='icon/delete.png' style='width:20px; '> </button>";
    echo "</form>";
    echo "</td>";
  }

  echo "</tr>";
  echo "<tr>";

  echo "<td></td>";
  echo "<td></td>";

  echo '<td>';
    echo "<form action='subirarchivos_normatividad.php' method='POST' enctype='multipart/form-data'>"; 
    echo '<input type="hidden" name="subirHistorial" value="1">';
    echo '<input name="nuevoDoc" type="file">';
  echo '</td>';

  echo "<td style=' text-align: center;'><button type='submit' class='Mbtn btn-default' title='Haga clic para subir el archivo'> <img src='icon/subirDoc.png' style='width:20px; '> </button></td>";
  echo "</form>";
  echo "</tr>";
  echo "</table>"; */

echo "</div>";
echo "</center>";

echo "</div>";
?>

<?php include("./lib/body_footer.php"); ?>