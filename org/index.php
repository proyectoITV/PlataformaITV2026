<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <link rel="stylesheet" href="css/font-awesome.min.css">
  <link rel="stylesheet" href="css/jquery.orgchart.css">
  <link rel="stylesheet" href="css/style.css">
  <style type="text/css">
    #chart-container { background-color: white; }
    .orgchart { background: #fff; }
  </style>


    <style type="text/css">
    .orgchart { background: #fff; }
    .orgchart td.left, .orgchart td.right, .orgchart td.top { border-color: #aaa; }
    .orgchart td>.down { background-color: #aaa; }
    .orgchart .dir .title { background-color: #006699; }
    .orgchart .dir .content { border-color: #006699; }
    .orgchart .dpto .title { background-color: #009933; }
    .orgchart .dpto .content { border-color: #009933; }
    .orgchart .sub .title { background-color: #993366; }
    .orgchart .sub .content { border-color: #993366; }
    .orgchart .del .title { background-color: #996633; }
    .orgchart .del .content { border-color: #996633; }
    .orgchart .staft .title { background-color: #cc0066; }
    .orgchart .staft .content { border-color: #cc0066; }
  </style>


</head>
<body>
  <div id="chart-container"></div>

  <script src="js/jquery.min.js"></script>
  <!-- the following reference is specific for IE -->
  <script type="text/javascript" src="https://cdn.rawgit.com/stefanpenner/es6-promise/master/dist/es6-promise.auto.min.js"></script>
  <script type="text/javascript" src="js/html2canvas.min.js"></script>
  <script type="text/javascript" src="js/jspdf.min.js"></script>
  <script type="text/javascript" src="js/jquery.orgchart.js"></script>





<?php
require('../config.php'); 
// require('../lib/funciones.php');
$data="";
$j="";





$sql="SELECT * FROM cat_gerarquia where id='0' and activo=1";
$r2 = $conexion -> query($sql);


$data = " 'name': 'Direccion General', 'title': '2772', 'className': 'dir', 
    'children': [
        { 'name': 'Direccion General', 'title': '2772', 'className': 'dir', 
            'children': [
                { 'name': 'Secretaria Particular', 'title': '2775', 'className': 'staft' }, 
                { 'name': 'Dpto. de Atencion ciudadana', 'title': '1533', 'className': 'staft' }, 
                { 'name': 'Dpto. de Soporte Tecnico', 'title': '', 'className': 'staft' }, 
                { 'name': 'Dpto. Control Documental', 'title': '2239', 'className': 'staft' }, 
                { 'name': 'Dir. Planeacion y Evaluacion', 'title': '2780', 'className': 'dir'},                 
                { 'name': 'Dir. Jurídica y Seguridad Patrimonial', 'title': '2824', 'className': 'dir'}, 
                { 'name': 'Coordinacion de Delegaciones', 'title': '2773', 'className': 'dir' }, 
                { 'name': 'Dir. de Programas de Suelo y Vivienda', 'title': '2777', 'className': 'dir' }, 
                { 'name': 'Direccion de Administracion y Finanzas', 'title': '2774', 'className': 'dir' },
                { 'name': 'Dpto. de Informatica', 'title': '2809', 'className': 'staft' }
            ] 
        }
    ] 
";
$data =  org_json();





function org_json(){
  //ESTA FUNCION AFECTA 3 NIVELES EN SU BUSQUEDA, DE NECESITARSE MAS AJUSTAR LA BUSQUED A MAS	
  require("../config.php");
  $j="";
  $sql = "SELECT * FROM cat_gerarquia WHERE id='0' and activo=1";
  
  if ($conexion->query($sql) == TRUE){
    $r2 = $conexion -> query($sql = "SELECT * FROM cat_gerarquia WHERE id='0' and activo=1"); while($f = $r2 -> fetch_array())
    {if (org_dependencias($f['id'])==0){$j=$j."{'name' : '".$f['nombre']."', 'title': '".nitavu_nombre($f['titular'])."', 'className': '".$f['nivel']."'},";}
    else{
      $j=$j."'name' : '".$f['nombre']."', 'title': '".nitavu_nombre($f['titular'])."', 'className': '".$f['nivel']."', 'children':[";
  
  
      $r3 = $conexion -> query($sql = "SELECT * FROM cat_gerarquia WHERE dependencia='".$f['id']."' "); while($f3 = $r3 -> fetch_array())
      {if (org_dependencias($f3['id'])==0){$j=$j."{'name' : '".$f['nombre']."', 'title': '".nitavu_nombre($f3['titular'])."', 'className': '".$f3['nivel']."'},";}
      else{
        $j=$j."{'name' : '".$f3['nombre']."', 'title': '".nitavu_nombre($f3['titular'])."', 'className': '".$f3['nivel']."', 'children':[";

  
      $r4 = $conexion -> query($sql = "SELECT * FROM cat_gerarquia WHERE dependencia='".$f3['id']."' and activo=1 and activo=1 order by orden asc"); while($f4 = $r4 -> fetch_array())
      {if (org_dependencias($f4['id'])==0){$j=$j."{'name' : '".$f4['nombre']."', 'title': '".nitavu_nombre($f4['titular'])."', 'className': '".$f4['nivel']."'},";}
      else{
        $j=$j."{'name' : '".$f4['nombre']."', 'title': '".nitavu_nombre($f4['titular'])."', 'className': '".$f4['nivel']."', 'children':[";
  
  
      $r5 = $conexion -> query($sql = "SELECT * FROM cat_gerarquia WHERE dependencia='".$f4['id']."' and activo=1"); while($f5 = $r5 -> fetch_array())
      {if (org_dependencias($f5['id'])==0){$j=$j."{'name' : '".$f5['nombre']."', 'title': '".nitavu_nombre($f5['titular'])."', 'className': '".$f5['nivel']."'},";}
      else{
        $j=$j."{'name' : '".$f5['nombre']."', 'title': '".nitavu_nombre($f5['titular'])."', 'className': '".$f5['nivel']."', 'children':[";
  
  
      
      $r6 = $conexion -> query($sql = "SELECT * FROM cat_gerarquia WHERE dependencia='".$f5['id']."' and activo=1 "); while($f6 = $r6 -> fetch_array())
      {if (org_dependencias($f6['id'])==0){$j=$j."{'name' : '".$f6['nombre']."', 'title': '".nitavu_nombre($f6['titular'])."', 'className': '".$f6['nivel']."'},";}
      else{
        $j=$j."{'name' : '".$f6['nombre']."', 'title': '".nitavu_nombre($f6['titular'])."', 'className': '".$f6['nivel']."', 'children':[";
  
  
      $r7 = $conexion -> query($sql = "SELECT * FROM cat_gerarquia WHERE dependencia='".$f6['id']."' and activo=1 "); while($f7 = $r7 -> fetch_array())
      {if (org_dependencias($f7['id'])==0){$j=$j."{'name' : '".$f7['nombre']."', 'title': '".nitavu_nombre($f7['titular'])."', 'className': '".$f7['nivel']."'},";}
      else{
        $j=$j."{'name' : '".$f7['nombre']."', 'title': '".nitavu_nombre($f7['titular'])."', 'className': '".$f7['nivel']."', 'children':[";
  
      $r8 = $conexion -> query($sql = "SELECT * FROM cat_gerarquia WHERE dependencia='".$f7['id']."' and activo=1 "); while($f8 = $r8 -> fetch_array())
      {if (org_dependencias($f8['id'])==0){$j=$j."{'name' : '".$f8['nombre']."', 'title': '".nitavu_nombre($f8['titular'])."', 'className': '".$f8['nivel']."'},";}
      else{
        $j=$j."{'name' : '".$f8['nombre']."', 'title': '".nitavu_nombre($f8['titular'])."', 'className': '".$f8['nivel']."', 'children':[";
  
  
      
  
  
      $j =$j."]},"; //3
      }  
      //$j = substr($j, 0, -2);//quita coma
      }	
      
  
  
      $j =$j."]},"; //3
      }  
      //$j = substr($j, 0, -2);//quita coma
      }	
      
  
  
      $j =$j."]},"; //3
      }  
      //$j = substr($j, 0, -2);//quita coma
      }	
  
  
      $j =$j."]},"; //3
      }  
      //$j = substr($j, 0, -2);//quita coma
      }	
  
  
  
      $j =$j."]},"; //3
      }  
      //$j = substr($j, 0, -2);//quita coma
      }	
  
  
  
      $j =$j."]},"; //3
      }
      //$j = substr($j, 0, -2);//quita coma
      }	
  
  
      $j =$j."]"; //3
    }}
  
  }
  
  return $j;
  
  }
  


  
function org_dependencias($nodo){
  //ESTA FUNCION AFECTA 3 NIVELES EN SU BUSQUEDA, DE NECESITARSE MAS AJUSTAR LA BUSQUED A MAS	
  require("../config.php");
  $j="";
  $sql = "select count(*) as n from cat_gerarquia where dependencia = '".$nodo."' and activo=1 ";
  if ($conexion->query($sql) == TRUE)
  {	$rc = $conexion -> query($sql);
    if($f = $rc -> fetch_array())
    {
      return $f['n'];
    }
    else {
      return 0;
    }
  
  } else {
    return 0;
  }
  
  
  
  }


  

function nitavu_nombre($id){
  require("../config.php");
  $sql = "SELECT * FROM empleados WHERE nitavu='".$id."'";
  $rc= $conexion -> query($sql);
  $msg="";
  if($f = $rc -> fetch_array())
  {
  if ($f['profesion_abr']==""){
  return $f['nombre'];}
  else
  {return $f['profesion_abr'].". ".$f['nombre'];}
  }
  else
  { return FALSE;}
  }
  
  
?>








<?php 


echo "
  <script type='text/javascript'>
    $(function() {

 var datascource = {
   ".$data."
    };

    $('#chart-container').orgchart({
      'data' : datascource,
      
      'nodeContent': 'title',
      'exportButton': true,
      'exportFilename': 'MyOrgChart',      
      'exportFilename': 'Organigrama-ITAVU',
      'pan': true,
      'zoom': true
      
    });

  });
  </script>
  ";
?>
  </body>
</html>