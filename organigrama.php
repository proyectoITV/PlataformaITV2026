<?php
//include (".//seguridad.php");
include ("lib/body_head.php");
include ("lib/body_menu.php");
// contenido:
?>



<iframe src='org/index.php' style='width:100%; border: 0px; height:70%; margin:0px'>
</iframe>

<div class='org-lista' style='background-color:black; width:100%; padding:5px; border-radius:4px;'>
    <label>Descripcion de los colores:</label>
    <b class='dir'>Direcicones</b> | 
    <b class='sub'>Sub Direcicones</b> | 
    <b class='dpto'>Departamentos</b> | 
    <b class='staft'>Departamentos STAFT</b> | 
    <b class='del'>Delegacion</b> | 



</div>
<div class='org-lista' id='org-lista'>
<?php
historia($nitavu, "Utilizo el orgranigrama de la plataforma");
$sql="SELECT * FROM cat_gerarquia where activo=1";
$r2 = $conexion -> query($sql);
historia($nitavu, "Vio el organigrama");
echo "<ul>";
$str_java="";
while($f = $r2 -> fetch_array())
{
	if ($f['nivel']=='CONSEJO'){
		echo "<li class=".$f['nivel']."><span>".$f['nombre']."</span></li>";
		$sql="SELECT * FROM cat_gerarquia WHERE  activo=1 and dependencia='".$f['id']."'";
	
		$r3 = $conexion -> query($sql);
		echo "<ul>";			
		while($n1 = $r3 -> fetch_array())
		{
			echo "<li class=".$n1['nivel']."><span>".$n1['nombre']."</span></li>";
			 $sql="SELECT * FROM cat_gerarquia WHERE  activo=1 and dependencia='".$n1['id']."' order by orden asc";
			// echo $sql;
			 $r3 = $conexion -> query($sql);
			echo "<ul>";			
			 while($n2 = $r3 -> fetch_array())
			 {
                echo "<li class=".$n2['nivel']."><span>".$n2['nombre']."</span></li>";
				$sql="SELECT * FROM cat_gerarquia WHERE activo=1 and dependencia='".$n2['id']."'";			
			 	$r4 = $conexion -> query($sql);
			 	echo "<ul>";			
			 	while($n3 = $r4 -> fetch_array())
			 	{
			 		echo "<li class=".$n3['nivel']."><span>".$n3['nombre']."</span></li>";

					$sql="SELECT * FROM cat_gerarquia WHERE activo=1 and dependencia='".$n3['id']."'";
					//echo $sql;
					$r5 = $conexion -> query($sql);
					echo "<ul>";			
					while($n4 = $r5 -> fetch_array())
					{
						echo "<li class=".$n4['nivel']."><span>".$n4['nombre']."</span></li>";
						$sql="SELECT * FROM cat_gerarquia WHERE activo=1 and dependencia='".$n4['id']."'";
						//echo $sql;
						$r6 = $conexion -> query($sql);
						echo "<ul>";			
						while($n5 = $r6 -> fetch_array())
						{
							echo "<li class=".$n5['nivel']."><span>".$n5['nombre']."</span></li>";
							
							
				
						}echo "</ul>";					
				
					}echo "</ul>";				
			
			 	}echo "</ul>";

				
			
			}echo "</ul>";
				
			
		}echo "</ul>";


	}
}
echo "</ul>";
?>
</div>
  
<?php include ("lib/body_footer.php"); ?>