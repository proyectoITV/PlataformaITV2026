<?php
//include (".//seguridad.php"); 
require ("config.php");



// Buscar Cliente
if ($_POST['action'] == 'usodesuelo') {
  if (!empty($_POST['idusodesuelo'])) {
    $id = $_POST['idusodesuelo'];
$sql="select * from catalogodeusodesuelo where IdUsoDeSuelo= '".$id."'";
//echo $sql;
    $query = mysqli_query($Vivienda, $sql);

    mysqli_close($Vivienda);
    $result = mysqli_num_rows($query);
    $data = '';
    if ($result > 0) {
      $data = mysqli_fetch_assoc($query);
    }else {
      $data = 0;
    }
    echo json_encode($data,JSON_UNESCAPED_UNICODE);
  }
  exit;
}
?>