<?php include ("./unica/body_head.php"); include ("./unica/body_menu.php"); ?>


<?php
$sql="SELECT * FROM cat_gerarquia";
$r2 = $conexion -> query($sql);
historia($nitavu, "Vio el organigrama");
echo "<div id='departamental' style=' '>";

while($f = $r2 -> fetch_array())
{
	if ($f['nivel']=='CONSEJO'){		
		$sql="SELECT * FROM cat_gerarquia WHERE dependencia='".$f['id']."'";
		$r3 = $conexion -> query($sql);		
		while($n1 = $r3 -> fetch_array())
		{
			//echo "<h3>".nitavu_nombre($n1['titular'])." (".$n1['nombre'].")</h3>";
			//echo tarjeta_dpto($n1['id']);	
			echo "<div style='width:90%; background-color:white; border: 1px #CCCCCC solid; margin: 10px; display:inline-block; '>";
			 	echo "<table class='tbl_dir' style='width:100%;'>";
			 	//echo tarjeta_dpto($n2['id']);				 		
			 	//echo "<th width='20%'>Dpto</th>";
			 	//echo "<th>Tiular</th>";
			 	echo "<tr style='background-color:#A7A7A7; color:white;'>";
			 		$foto= "<img src='fotos/".$n1['titular'].".jpg' class='foto_org1'>";
			 		echo "<td width='20px'>".$foto."</td>";			 		
			 		echo "<td width='200px' ><b>".$n1['nombre']."</b><br>";
			 		echo "".nitavu_nombre($n1['titular'])."</td>";
			 		echo "<td >Tel. ".nitavu_tel($n1['titular'])." ext. ".nitavu_tel_ext($n1['titular']);
			 		echo "<br>".nitavu_correo($n1['titular'])."</td>";
			 	echo "</tr>";
			 	echo "</table></div>";		

			$sql="SELECT * FROM cat_gerarquia WHERE dependencia='".$n1['id']."' order by dependencia DESC";
			$r3 = $conexion -> query($sql);
				
			 	
			while($n2 = $r3 -> fetch_array())
			 {
			 	echo "<div style='width:90%; background-color:white; border: 1px #CCCCCC solid; margin: 10px; display:inline-block; '>";
			 	echo "<table class='tbl_dir' style='width:100%;'>";
			 	//echo tarjeta_dpto($n2['id']);				 		
			 	//echo "<th width='20%'>Dpto</th>";
			 	//echo "<th>Tiular</th>";
			 	echo "<tr style='background-color:#A7A7A7; color:white;'>";
			 		$foto= "<img src='fotos/".$n2['titular'].".jpg' class='foto_org1'>";
			 		echo "<td width='20px'>".$foto."</td>";			 		
			 		echo "<td width='200px' ><b>".$n2['nombre']."</b><br>";
			 		echo "".nitavu_nombre($n2['titular'])."</td>";
			 		echo "<td >Tel. ".nitavu_tel($n2['titular'])." ext. ".nitavu_tel_ext($n2['titular']);
			 		echo "<br>".nitavu_correo($n2['titular'])."</td>";
			 	echo "</tr>";
				
				 $sql="SELECT * FROM cat_gerarquia WHERE dependencia='".$n2['id']."'";
				 $r4 = $conexion -> query($sql);			 	
			     while($n3 = $r4 -> fetch_array())
			  	{
			  		echo "<tr style='color:#006595;'>";
					$foto= "<img src='fotos/".$n3['titular'].".jpg' class='foto_org1'>";
			 		echo "<td width='20px'>".$foto."</td>";			 		
			 		echo "<td width='200px' ><b>".$n3['nombre']."</b><br>";
			 		echo "".nitavu_nombre($n3['titular'])."</td>";
			 		echo "<td >Tel. ".nitavu_tel($n3['titular'])." ext. ".nitavu_tel_ext($n3['titular']);
			 		echo "<br>".nitavu_correo($n3['titular'])."</td>";

			 		echo "</tr>";
				
				

				// 	echo "<section class='departamental_dpto'>";
			 // 		//echo tarjeta_dpto($n3['id']);	
				 	$sql="SELECT * FROM cat_gerarquia WHERE dependencia='".$n3['id']."'";
				 	$r5 = $conexion -> query($sql);
					
				 	while($n4 = $r5 -> fetch_array())
				 	{
					echo "<tr style='color:black;'>";
					$foto= "<img src='fotos/".$n4['titular'].".jpg' class='foto_org1'>";
			 		echo "<td width='20px'>".$foto."</td>";			 		
			 		echo "<td width='200px' ><b>".$n4['nombre']."</b><br>";
			 		echo "".nitavu_nombre($n4['titular'])."</td>";
			 		echo "<td >Tel. ".nitavu_tel($n4['titular'])." ext. ".nitavu_tel_ext($n4['titular']);
			 		
			 		echo "<br>".nitavu_correo($n4['titular'])."</td>";

			 		echo "</tr>";
				// 		$dep4 = "'".$n4['nombre']."<div style=color:#0064AE;>";
				// 		//$dep4 = $dep4."<br>".ponerfoto_org('fotos/'.$n4['titular'].'.jpg',$n4['titular']);
				// 		$dep4 = $dep4."<br>".nitavu_nombre2($n4['titular'])."</div>'";
				 		$sql="SELECT * FROM cat_gerarquia WHERE dependencia='".$n4['id']."'";
				 		$r6 = $conexion -> query($sql);
				 		while($n5 = $r6 -> fetch_array())
				 		{
				 			echo "<tr style='color:gray;'>";
							$foto= "<img src='fotos/".$n5['titular'].".jpg' class='foto_org1'>";
					 		echo "<td width='20px'>".$foto."</td>";			 		
					 		echo "<td width='200px' ><b>".$n5['nombre']."</b><br>";
					 		echo "".nitavu_nombre($n5['titular'])."</td>";
					 		echo "<td >Tel. ".nitavu_tel($n5['titular'])." ext. ".nitavu_tel_ext($n5['titular']);
					 		echo "<br>".nitavu_correo($n5['titular'])."</td>";

					 		echo "</tr>";
				// 			$dep5 = "'".$n5['nombre']."<div style=color:#0064AE;>";
				// 			//$dep5 = $dep5."<br>".ponerfoto_org('fotos/'.$n5['titular'].'.jpg',$n5['titular']);
				// 			$dep5 = $dep5."<br>".nitavu_nombre2($n5['titular'])."</div>'";
				
				 		}
				
				 	}
			
			 	}
			 
			 

				
			echo "</table></div>";		
			}
				
			
		}


	}
}



echo "</div>";

?>



















<?// NO BORRAR ESTA ULTIMA ?>
<?php include ("./unica/body_footer.php"); ?>
