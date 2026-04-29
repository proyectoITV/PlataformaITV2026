<?php
//include (".//seguridad.php"); 
include ("./lib/body_head.php");
include ("./lib/body_menu.php");

// contenido:
?>
<?php



$sql="SELECT * FROM cat_gerarquia";
$r2 = $conexion -> query($sql);

echo "<div id='orgalist'>";
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
         echo "<li class='gera1'>";
         echo 	$n1['nombre'];
         echo  "<b>".titular($f['id'])."</b>";
         echo "</li>";
         $sql="SELECT * FROM cat_gerarquia WHERE dependencia='".$n1['id']."'";
         $r3 = $conexion -> query($sql);
         echo "<ul>";         
         while($n2 = $r3 -> fetch_array())
         {
            echo "<li class='gera2'>";
            //echo "[".$n2['nivel']."]";
            if ($n2['nivel']=='Dir.'){echo "<b class='dir'>".$n2['nombre']."</b>";}
            if ($n2['nivel']=='Sub.'){echo "<b class='sub'>".$n2['nombre']."</b>";}
            if ($n2['nivel']=='Dpto.'){echo "<b class='dpto'>".$n2['nombre']."</b>";}
            if ($n2['nivel']=='Del.'){echo "<b class='del'>".$n2['nombre']."</b>";}
            if ($n2['nivel']==''){echo "<b class='tenue'>".$n2['nombre']."</b>";}                   
           	echo  "<br>".nitavu_nombre(titular($n2['id']))."";            
            echo "</li>";

            $sql="SELECT * FROM cat_gerarquia WHERE dependencia='".$n2['id']."'";
            //echo $sql;
            $r4 = $conexion -> query($sql);
            echo "<ul>";         
            while($n3 = $r4 -> fetch_array())
            {
             
	             echo "<li class='gera2'>";
	            //echo "[".$n2['nivel']."]";
	            if ($n3['nivel']=='Dir.'){echo "<b class='dir'>".$n3['nombre']."</b>";}
	            if ($n3['nivel']=='Sub.'){echo "<b class='sub'>".$n3['nombre']."</b>";}
	            if ($n3['nivel']=='Dpto.'){echo "<b class='dpto'>".$n3['nombre']."</b>";}
	            if ($n3['nivel']=='Del.'){echo "<b class='del'>".$n3['nombre']."</b>";}
	            if ($n3['nivel']==''){echo "<b class='tenue'>".$n3['nombre']."</b>";}                   
	           	echo  "<br>".nitavu_nombre(titular($n3['id']))."";            
	            echo "</li>";

               $sql="SELECT * FROM cat_gerarquia WHERE dependencia='".$n3['id']."'";
               //echo $sql;
               $r5 = $conexion -> query($sql);
               echo "<ul>";         
               while($n4 = $r5 -> fetch_array())
               {
                  
                  echo "<li class='gera2'>";
		            //echo "[".$n2['nivel']."]";
		            if ($n4['nivel']=='Dir.'){echo "<b class='dir'>".$n4['nombre']."</b>";}
		            if ($n4['nivel']=='Sub.'){echo "<b class='sub'>".$n4['nombre']."</b>";}
		            if ($n4['nivel']=='Dpto.'){echo "<b class='dpto'>".$n4['nombre']."</b>";}
		            if ($n4['nivel']=='Del.'){echo "<b class='del'>".$n4['nombre']."</b>";}
		            if ($n4['nivel']==''){echo "<b class='tenue'>".$n4['nombre']."</b>";}    

		           	echo  "<br>".nitavu_nombre(titular($n4['id']))."";            
		            echo "</li>";

                  $sql="SELECT * FROM cat_gerarquia WHERE dependencia='".$n4['id']."'";
                  //echo $sql;
                  $r6 = $conexion -> query($sql);
                  echo "<ul>";         
                  while($n5 = $r6 -> fetch_array())
                  {
                     echo "<li class='gera2'>";
				        //echo "[".$n2['nivel']."]";
				        if ($n5['nivel']=='Dir.'){echo "<b class='dir'>".$n5['nombre']."</b>";}
				        if ($n5['nivel']=='Sub.'){echo "<b class='sub'>".$n5['nombre']."</b>";}
				        if ($n5['nivel']=='Dpto.'){echo "<b class='dpto'>".$n5['nombre']."</b>";}
				        if ($n5['nivel']=='Del.'){echo "<b class='del'>".$n5['nombre']."</b>";}
				        if ($n5['nivel']==''){echo "<b class='tenue'>".$n5['nombre']."</b>";}                   
				       	echo  "<br>".nitavu_nombre(titular($n5['id']))."";            
				        echo "</li>";        
            
                  }echo "</ul>";             
            
               }echo "</ul>";          
         
            }echo "</ul>";

            
         
         }echo "</ol>";
            
         
      }echo "</ol>";


   }
}
echo "</ul>";
echo "</div>";
?>

<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>


<?php
include ("./lib/body_footer.php");
?>