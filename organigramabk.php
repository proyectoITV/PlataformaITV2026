<?php 	require("seguridad.php"); ?>
<?php 	require("lib/funciones.php"); ?>
<?php 	require("config.php"); ?>
<!DOCTYPE html>
<html>
<head>
	<title></title>
	 <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
  <script>
  $( function() {
    $( "#organigrama_flow" ).draggable();
  } );
  </script>


  <style>
  body {
  	text-align: center;
  	background-color: #002540;
  	background-color: white;
  	
  	
  	font-family: arial,helvetica;
  	margin: 0px;
  }
  #organigrama_flow { 
  	width: 100%; height: 20px; padding: 0.5em; 
  	
  	cursor: move;
  }


.myNodeClass {
	text-align: center;
    vertical-align: middle;
    font-family: arial,helvetica;

    cursor: default;
    border: 1px solid #999999;

    border-radius: 5px;
    background:-webkit-gradient(linear, 11% 100%, 9% 21%, from(#959897), to(#FFFFFF));

    padding: 0px;
    
	-moz-box-shadow: 1px 1px 2px #151721;
	-webkit-box-shadow: 1px 1px 2px #151721;
	box-shadow: 1px 1px 2px #151721;
}
.myNodeClass img {
	border-radius: 10px;
	border: 1px solid gray;
	padding:0px;
	
}


.myNodeClass a {
	

}
.mySelectedNodeClass, .myNodeClass:hover {
    border: 1px solid #94AB27;
    background:-webkit-gradient(radial, 165 0, 0, 159 -257, 524, from(#34FF44), to(#213A19));
    /*background: -webkit-gradient(linear, left top, left bottom, from(#ffb0d7), to(#eeb0d7));*/
    color: black;
    -moz-box-shadow: 2px 3px 22px #05f020;
-webkit-box-shadow: 2px 3px 22px #05f020;
box-shadow: 2px 3px 22px #05f020;

  transition: all 1s ease-in-out;

}
h5 {
	width: 100%;
	color: white;
	background-color: transparent;
	font-size: 18pt;
	padding-top: 0px;
	margin-top: 0px;
	padding: 0px;

}

h4 {
	width: 100%;
	color: white;
	background-color: transparent;
	font-size: 10pt;
	padding-top: 0px;
	margin-top: -50px;
	padding: 5px;

}

h5, h4 {

}

a {
text-decoration: none;
color: cyan;
padding-left: 5px;
padding-right: 5px;
background-color:transparent;
border-radius: 5px;
}

a:hover {

	color:#94AB27;


}

</style>





</head>
<body>
<div id='AppDetalle'>ORGANIGRAMA <b>ITAVU</b></div>
<H4>* Clic sobre la foto para ir a editar los datos del empleado.   * Doble clic en el reacuadro gris para colapsar dependencias
<a href="index.php">Regresar a la Plataforma</a></h4>

<?php

//include ("./lib/body_menu.php"); ?>
<?php //AQUI VA TU CONTENIDO ?>



<?php
$sql="SELECT * FROM cat_gerarquia";
$r2 = $conexion -> query($sql);
historia($nitavu, "Vio el organigrama");
//echo "<ol>";
$str_java="";
while($f = $r2 -> fetch_array())
{
	if ($f['nivel']=='CONSEJO'){
		//echo "<li><span>".$f['nombre']."</span></li>";
		$str_java="[{v:'".$f['nombre']."', f:'".$f['nombre']."<div>"."</div>'},'', 'The President'],";

		$sql="SELECT * FROM cat_gerarquia WHERE dependencia='".$f['id']."'";
		$r3 = $conexion -> query($sql);
		//echo "<ol>";			
		while($n1 = $r3 -> fetch_array())
		{
			//echo "<li>".$n1['nombre']."</li>";
			$str_java=$str_java."[{v:'".$n1['nombre']."', f:'".$n1['nombre']."<div style=color:#004274; ><br>". ponerfoto_org("fotos/".$n1['titular'].".jpg",$n1['titular'])." <br>".nitavu_nombre2($n1['titular'])."</div>'},'".$f['nombre']."', 'VP'],";

			 $sql="SELECT * FROM cat_gerarquia WHERE dependencia='".$n1['id']."'";
			 $r3 = $conexion -> query($sql);
			// echo "<ol>";			
			 while($n2 = $r3 -> fetch_array())
			 {
			 	//echo "<li>".$n2['nombre']."</li>";
			 // 	
				//$str_java=$str_java."['".$n2['nombre']."', '".$n1['nombre']."',''],";
				$dep2 = "'".$n2['nombre']."<div style=color:#0064AE;>";
				$dep2 = $dep2."<br>".ponerfoto_org('fotos/'.$n2['titular'].'.jpg',$n2['titular']);
				$dep2 = $dep2."<br>".nitavu_nombre2($n2['titular'])."</div>'";

				$str_java=$str_java."[".$dep2.", '".$n1['nombre']."',''],";
			 	
			// 	$str_java = $str_java."['x', 'General', ''],";
			
				$sql="SELECT * FROM cat_gerarquia WHERE dependencia='".$n2['id']."'";
			// 	//echo $sql;
			 	$r4 = $conexion -> query($sql);
			 	//echo "<ol>";			
			 	while($n3 = $r4 -> fetch_array())
			 	{
			// 		echo "<li>".$n3['nombre']."</li>";

//#333333

			 		//$str_java=$str_java."['".$n3['nombre']."', '".$n2['nombre']."',''],";
			 		
					$dep3 = "'".$n3['nombre']."<div style=color:#0064AE;>";
					$dep3 = $dep3."<br>".ponerfoto_org('fotos/'.$n3['titular'].'.jpg',$n3['titular']);
					$dep3 = $dep3."<br>".nitavu_nombre2($n3['titular'])."</div>'";

					$str_java=$str_java."[".$dep3.", ".$dep2.",''],";


			 		//$str_java=$str_java."['".$n3['nombre']."'<div style=color:gray;><br>".ponerfoto_org('fotos/'.$n3['titular'].'.jpg',$n3['titular'])."<br>".nitavu_nombre($n3['titular'])."</div>', '".$n2['nombre']."',''],";
			
					$sql="SELECT * FROM cat_gerarquia WHERE dependencia='".$n3['id']."'";
					//echo $sql;
					$r5 = $conexion -> query($sql);
					//echo "<ol>";			
					while($n4 = $r5 -> fetch_array())
					{
						//echo "<li>".$n4['nombre']."</li>";


					$dep4 = "'".$n4['nombre']."<div style=color:#0064AE;>";
					$dep4 = $dep4."<br>".ponerfoto_org('fotos/'.$n4['titular'].'.jpg',$n4['titular']);
					$dep4 = $dep4."<br>".nitavu_nombre2($n4['titular'])."</div>'";

					$str_java=$str_java."[".$dep4.", ".$dep3.",''],";


						//$str_java=$str_java."['".$n4['nombre']."', '".$n3['nombre']."',''],";
						//$str_java=$str_java."['".$n4['nombre']."<div style=color:gray;><br>".ponerfoto_org('fotos/'.$n4['titular'].'.jpg',$n4['titular'])."<br>".nitavu_nombre($n4['titular'])."</div>', '".$n3['nombre']."',''],";
			
						$sql="SELECT * FROM cat_gerarquia WHERE dependencia='".$n4['id']."'";
						//echo $sql;
						$r6 = $conexion -> query($sql);
						//echo "<ol>";			
						while($n5 = $r6 -> fetch_array())
						{
							//echo "<li>".$n5['nombre']."</li>";
							$dep5 = "'".$n5['nombre']."<div style=color:#0064AE;>";
							$dep5 = $dep5."<br>".ponerfoto_org('fotos/'.$n5['titular'].'.jpg',$n5['titular']);
							$dep5 = $dep5."<br>".nitavu_nombre2($n5['titular'])."</div>'";

							$str_java=$str_java."[".$dep5.", ".$dep4.",''],";
							//$str_java=$str_java."['".$n5['nombre']."', '".$n4['nombre']."',''],";				
							//$str_java=$str_java."['".$n5['nombre']."<div style=color:gray;><br>".ponerfoto_org('fotos/'.$n5['titular'].'.jpg',$n5['titular'])."<br>".nitavu_nombre($n5['titular'])."</div>', '".$n4['nombre']."',''],";
				
						}//echo "</ol>";					
				
					}//echo "</ol>";				
			
			 	}//echo "</ol>";

				
			
			}//echo "</ol>";
				
			
		}//echo "</ol>";


	}
}
//echo "</ul>";
?>




 <script type="text/javascript" src="lib/gstatic_loader.js"></script>
 <script type="text/javascript">
      google.charts.load('current', {packages:["orgchart"]});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {
        var data = new google.visualization.DataTable();
        data.addColumn('string', 'Name');
        data.addColumn('string', 'Manager');
        data.addColumn('string', 'ToolTip');

		//aqui en la espera de la info de php    
		<?php  echo "data.addRows([".$str_java."]);"; ?>


    var chart = new google.visualization.OrgChart(document.getElementById('organigrama_flow'));
    chart.draw(data, {allowHtml:true});

    $("div[data-group]").each(function ()
     {
            var parent = $(this).parent();
    		$(this).css('position', 'relative');
    		$(this).css('padding-top', '0');
            parent.removeClass("google-visualization-orgchart-node");
            parent.removeClass("google-visualization-orgchart-node-medium");
    		parent.css('vertical-align', 'top');
            parent.css('min-width', '120px');
            parent.css('vertical-align', 'top');
    		parent.css('padding-top', '0');

    var group = $(this).data('group');
    if(group !== undefined) 
    {
    	for(var i=0; i < nodes.length; i++)
                {
        		var node = nodes[i];
        		if(node[1] === group) 
        			{
        				$(this).append(node[0].f); 
        			}
        		}
      			$('div', this).addClass("google-visualization-orgchart-node");
      			$('div', this).addClass("google-visualization-orgchart-node-medium");
      			$('div', this).css('margin-bottom','5px');
            	$('div', this).css('width', '100px');
     }
       
     });


    }
   </script>

 <div id="organigrama_flow"  ></div> 






















<?// NO BORRAR ESTA ULTIMA ?>
<?php //include ("./lib/body_footer.php"); ?>

</body>
</html>