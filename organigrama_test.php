<html>
<head>
<title>Google Charts Tutorial</title>
  

   <style>
      body {
         color: gray;
      }

      .gera_direccion {
         color: 
      }
   </style>
</head>
<body>

<?php
require ("config.php");
require("lib/funciones.php");
$sql="SELECT * FROM cat_gerarquia";
$r2 = $conexion -> query($sql);

echo "<ul>";


while($f = $r2 -> fetch_array())
{
   if ($f['nivel']=='CONSEJO'){
      echo "<li>".$f['nombre']."</li>";

      $sql="SELECT * FROM cat_gerarquia WHERE dependencia='".$f['id']."'";
      $r3 = $conexion -> query($sql);
      echo "<ul>";         
      while($n1 = $r3 -> fetch_array())
      {
         echo "<li>".$n1['nombre']."</li>";
         $sql="SELECT * FROM cat_gerarquia WHERE dependencia='".$n1['id']."'";
         $r3 = $conexion -> query($sql);
         echo "<ul>";         
         while($n2 = $r3 -> fetch_array())
         {
            echo "<li>[".$n1['id']."]".$n2['nombre']."</li>";

            $sql="SELECT * FROM cat_gerarquia WHERE dependencia='".$n2['id']."'";
            //echo $sql;
            $r4 = $conexion -> query($sql);
            echo "<ul>";         
            while($n3 = $r4 -> fetch_array())
            {
               echo "<li>".$n3['nombre']."</li>";
               $sql="SELECT * FROM cat_gerarquia WHERE dependencia='".$n3['id']."'";
               //echo $sql;
               $r5 = $conexion -> query($sql);
               echo "<ul>";         
               while($n4 = $r5 -> fetch_array())
               {
                  echo "<li>".$n4['nombre']."</li>";
                  $sql="SELECT * FROM cat_gerarquia WHERE dependencia='".$n4['id']."'";
                  //echo $sql;
                  $r6 = $conexion -> query($sql);
                  echo "<ul>";         
                  while($n5 = $r6 -> fetch_array())
                  {
                     echo "<li>".$n5['nombre']."</li>";           
            
                  }echo "</ul>";             
            
               }echo "</ul>";          
         
            }echo "</ul>";

            
         
         }echo "</ol>";
            
         
      }echo "</ol>";


   }
}
echo "</ul>";
?>
</body>
</html>