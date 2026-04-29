<?php 

 include ("./lib/body_head.php");
include ("./lib/body_menu.php"); 


//echo "<div class ='centrar_mensaje_padre'>";
//echo "<div class = 'centrar_mensaje_hijo'>";
$id_aplicacion ="ap58";
$nivel =aplicacion_nivel($id_aplicacion, $nitavu);




if (sanpedro($id_aplicacion, $nitavu)==TRUE)
{
	historia($nitavu,'Req_ Entró a la aplicacion de reporte de requisiciones'); 
	echo "<div id='AppDetalle'>".app_detalle($id_aplicacion, $nitavu)."</div>";

	echo "<center>";
	include("req_menu.php");
	echo "<br>";
	//echo "<div id='AppDetalle'>Generación de reporte </div>";
	echo "<br>";

	
	
	if(isset($_GET['tipo']) and isset($_GET['iddir']) and isset($_GET['iddpto'])  )
	{
		
		// CODIGO QUE SE EJECUTARÁ SI LA PAGINA NO ES LA PRIMERA VEZ. 
        $idtipo = $_GET['tipo'];
        $iddir = $_GET['iddir'];
        $iddpto = $_GET['iddpto'];
			
		
		echo "<div id=req_contenedor  style='background: white;width: 90%;'>" ;
		echo "<form action='req_reporte.php' method='POST' enctype='multipart/form-data'>";
			echo "<div>";			
			echo "<label for='idTipoRequisicion'>Seleccione el filtro por el que desea generar el reporte:";
			echo"<select name='idTipoRequisicion' id='idTipoRequisicion' required='required'>";				
			
			if ($idtipo==1)
			{
				echo"<option value='1' selected='selected'>Requisicion Papeleria</option>
				<option value='2'>Requisicion Material-Limpieza</option>
				<option value='3'>Requisicion Electronica</option>
				<option value='4'>Producto</option>";
			}
			else if ($idtipo==2)
			{
				echo"<option value='1'>Requisicion Papeleria</option>
				<option value='2' selected='selected'>Requisicion Material-Limpieza</option>
				<option value='3'>Requisicion Electronica</option>
				<option value='4'>Producto</option>";
			}
			else if ($idtipo==3)
			{
				echo"<option value='1' >Requisicion Papeleria</option>
				<option value='2'>Requisicion Material-Limpieza</option>
				<option value='3' selected='selected'>Requisicion Electronica</option>
				<option value='4'>Producto</option>";
			}
			else if  ($idtipo==4)
			{
				echo"<option value='1'>Requisicion Papeleria</option>
				<option value='2'>Requisicion Material-Limpieza</option>
				<option value='3'>Requisicion Electronica</option>
				<option value='4' selected='selected'>Producto</option>";
			}
			else  
			{
				echo "<option value='' selected='selected'> Seleccione un tipo de reporte</option>		
				<option value='1' >Requisicion Papeleria</option>
				<option value='2'>Requisicion Material-Limpieza</option>
				<option value='3'>Requisicion Electronica</option>
				<option value='4'>Producto</option>";
			}
				  

			echo "</select>";
			echo "</label>";
			echo "</div>";


			echo "<div>";
			echo "<label for='iddirección'>Direccion:";
			echo "<select name='iddireccion' id='iddireccion'>";				
			$rc= $conexion -> query("select * from cat_gerarquia  where nivel = 'dir' order by nombre ASC");
			while($dir = $rc -> fetch_array()) 
			{		
				if ($iddir==$dir['id'])
					{
						$entro=true;
						echo '<option value="'.$dir['id'].'" selected="selected">'.$dir['nombre'].'</option>';							
					}
					else
					{
						echo '<option value="'.$dir['id'].'">'.$dir['nombre'].'</option>';		
					}	
			}				
			echo "</select>";
			echo "</label>";			
			echo "</div>";


						
			echo "<div>";	
			$sql = "select * from cat_gerarquia where dependencia in(
				select id from cat_gerarquia where id in 
				(select id  from cat_gerarquia as cgg where (cgg.id in(select cat_gerarquia.id from cat_gerarquia where dependencia=" .$iddir." or id=".$iddir."))))
				union select * from cat_gerarquia where id =".$iddpto." order by nombre";       
			$r = $conexion -> query($sql);		
			echo "<label for='departametno'>Departamento:";
			echo "<select id='departamento' name='departamento' >";
			echo "<option>Seleccione un departamento...</option>";					
			while($f = $r -> fetch_array())
			{ 
				if ($iddpto==$f['id'])
				{
				
				echo '<option value="'.$f['id'].'" selected="selected">'.$f['nombre'].'</option>';							
				}
				else
				{
				  echo '<option value="'.$f['id'].'">'.$f['nombre'].'</option>';		
				}							
			}
				
			echo "</select>";
			echo "</label>";
			echo "</div>";			
			
			
			echo "<div>";
					echo "<div>";
					echo "<label>Desde:</label>";
					echo "<input type='date' name='fechaI' value='".$fecha."'>";				
					echo "</div>";
					echo "<div>";
					echo "<label>Hasta:</label>";
					echo "<input type='date' name='fechaF' value='".$fecha."'>";
					echo "</div>";
			echo "</div>";

		
			echo "<div id='texto' style='display:none;'>";
			echo "<label for='search'>Texto a buscar:";
			echo "<input type='text' name='search' PLACEHOLDER='Producto..'>";
			echo "</label>";
			echo "</div>";

			echo "<div>";
			echo "<label>Haga clic aqui</label>";
			echo "<input type='submit' name='' value='Consultar' class='Mbtn btn-default'>";
			echo "</div>";
				
	echo "</form>";	
	echo "</div>";	
	
		}	
		else // CUANDO SE CARGA POR PRIMERA VEZ LA PAGINA
		{
			
		
		
			echo "<div id=req_contenedor style='background: white;width: 90%;'>" ;
			echo "<form action='req_pdf_reporte.php' method='POST' enctype='multipart/form-data'>";
			echo "<div>";
			
			echo "<label for='idTipoRequisicion'>Seleccione el filtro por el que desea generar el reporte:";
			echo"<select name='idTipoRequisicion' id='idTipoRequisicion' required='required'>";		
				echo"<option value='' selected='selected'> Seleccione un tipo de reporte</option>";			
				echo"<option value='1'>Requisicion Papeleria</option>
				<option value='2'>Requisicion Material-Limpieza</option>
				<option value='3'>Requisicion Electronica</option>
  				<option value='4'>Producto</option>
			</select>";
			echo "</label>";
			echo "</div>";

			echo "<div>";
			echo "<label for='iddirección'  style='width: 100%;'>Direccion:";
			echo "<select name='iddireccion' id='iddireccion'>";
				echo $iddir;
			$rc= $conexion -> query("select * from cat_gerarquia  where nivel = 'dir' order by nombre ASC");
			while($dir = $rc -> fetch_array()) 
			{
				echo "<option value='".$dir['id']."'>".$dir['nombre']."</option>";			
			}
			echo "<option value='' selected>Seleccione una dirección...</option>";
				

			echo "</select>";
			echo "</label>";			
			echo "</div>";


			echo "<div id='divprueba'>";
			echo "<label for='departamento' style='width: 90%;'>Departamento:";
			echo "<select name='departamento' id='departamento'>";	
			echo "<option value=''>Seleccione un departamento...</option>";		
			echo "</select>";
			echo "</label>";			
			echo "</div>";
			
			echo "<div>";
					echo "<div>";
					echo "<label>Desde:</label>";
					echo "<input type='date' name='fechaI' value='".$fecha."'>";				
					echo "</div>";
					echo "<div>";
					echo "<label>Hasta:</label>";
					echo "<input type='date' name='fechaF' value='".$fecha."'>";
					echo "</div>";
			echo "</div>";

		
			echo "<div id='texto' style='display:none;'>";
			echo "<label style='width:90%' for='search'>Texto a buscar:";
			echo "<input type='text' name='search' PLACEHOLDER='Producto..'>";
			echo "</label>";
			echo "</div>";

			echo "<div>";
			echo "<label>Haga clic aqui</label>";
			echo "<input type='submit' name='' value='Consultar' class='Mbtn btn-default'>";
			echo "</div>";
				
	echo "</form>";	
	echo "</div>";	
	echo "</center>";
		}

			
		
}
else
{
	echo "	<br><br>";echo "No tiene acceso a ".$id_aplicacion;
}
	
?>
<script>

// funcion para obtener url
function obtenerValorParametro(sParametroNombre) {
var sPaginaURL = window.location.search.substring(1);
 var sURLVariables = sPaginaURL.split('&');
  for (var i = 0; i < sURLVariables.length; i++) {
    var sParametro = sURLVariables[i].split('=');
    if (sParametro[0] == sParametroNombre) {
      return sParametro[1];
    }
  }
 return null;
}


$( document ).ready(function() {
	iddir=$("#iddireccion option:selected").val();
     mostrarDepartamentos(iddir); 
});



 $(document).on("change", "#idTipoRequisicion", function(event) 
 { 
	if ($("#idTipoRequisicion option:selected").val()==4)
	{
		document.getElementById('texto').style.display = 'inline-block';
	}
	else
	{
		document.getElementById('texto').style.display = 'none';
	}
	 
	 
});



$(document).on("change", "#iddireccion", function(event)
  {    
	  
	iddir=$("#iddireccion option:selected").val();	     
	
	 

	  var t = obtenerValorParametro('tipo');
	  var d = obtenerValorParametro('iddir');
	  var dp = obtenerValorParametro('iddpto');	   
		 mostrarDepartamentos(iddir); 
  
    }); 


 $(document).on("change", "#departamento", function(event)
  { 	   

	   idpto=$("#departamento option:selected").val();	
	   console.log('dpto '+idpto);
	  
	 //identifico si existe el valor dir en la url
	  //var valor = obtenerValorParametro('iddir');
	
		// if (valor)
		// {	
  		// 	location.href='req_reporte_requisiciones2.php?tipo='+$("#idTipoRequisicion option:selected").val()+'&iddir='+$("#iddireccion option:selected").val()+'&iddpto='+idpto; 
		// }
		// else
		// {			
  		 //	location.href='req_reporte_requisiciones2.php?tipo='+$("#idTipoRequisicion option:selected").val()+'&iddir='+$("#iddireccion option:selected").val()+'&iddpto='+idpto; 
		// }
		
        
    });  

function mostrarDepartamentos(id){        
     $.ajax({
    	 url: "rq_departamentos.php",
         type: "get",
         data: {id: id},
         success: function(data){   
			 console.log(data);      
		 $('#departamento').html(data+"\n");
		
		 }
        });
        document.getElementById("iddireccion").value=id;        
    }

	  
 
</script>
<br><br><br><br><br><br>
<br><br><br><br><br><br>
<br><br><br><br><br><br>
<br><br><br><br><br><br>
<br><br><br><br><br><br>
<?php
include ("./lib/body_footer.php");
?>