<?php
//include (".//seguridad.php"); 
include ("./lib/body_head.php");
include ("./lib/body_menu.php");

$id_aplicacion = 'ap03';
$nivel =aplicacion_nivel($id_aplicacion, $nitavu);
//PROCESO PARA TOCAR LA PUERTA DE SAN PEDRO
$id_aplicacion ="ap03"; //ap07=Permisos de Aplicacion

if (sanpedro($id_aplicacion, $nitavu)==TRUE){
	echo "<div id='AppDetalle'>".app_detalle($id_aplicacion, $nitavu)."</div>";

	?>
<script>

 function BuscarEmpleado(){
		//alert('entro');
        txtName = $("#q").val();
		//alert(txtName );
        var n = txtName.length;
        console.log(txtName + "N=" + n);
        //if (n>=4){
            console.log("Ya esta listo para su busqueda--> "+ n);
            
            BuscarEmpleadoBD();
        //}
    }


    function BuscarEmpleadoBD(){
		
		$("#EmpleadosBusqueda").html("<p style='font-size:20; color:orange;padding:30px;'>Buscando <img src='img/loader_bar.gif' style=''></p>");
		txtq = $("#q").val();
		console.log("Ejecutando.." + txtq);
        $.ajax({
            url: "empleados_dat1.php",
            type: "get",        
            data: {q: txtq, user:"<?php echo $nitavu; ?>"},
            success: function(data){
				$("#EmpleadosBusqueda").html("");
                $("#EmpleadosBusqueda").html(data+"\n");            
            }
        });
	}
	
</script>

<?php
	echo "<div id='EmpleadosBuscar'>";
	// echo "<form action='' method='POST'>";
	
	echo '<table border="0" width="97%"><tr>';
	echo "<td width=20px></td>";
	echo '<td>';

	

	if (isset($_GET['search'])){
		echo '<input type="text" style="
			width: 98%;
			font-size: 20pt;
			border-radius: 6px;
			border: 0px;
			padding: 7px;
			height: 50px;
			background-color: rgba(0,0,0,0.3);
			color: #6bf458;
			" name="q" id="q" value="'.$_GET['search'].'" placeholder="Nombre del Empleado" ></td>';
			echo "<script>BuscarEmpleado();</script>";
	} else {
			echo '<input type="text" style="
			width: 100%;
			font-size: 20pt;
			border-radius: 6px;
			border: 0px;
			padding: 7px;
			height: 50px;
			background-color: rgba(0,0,0,0.3);
			color: #6bf458;
			" name="q" id="q"   placeholder="Nombre del Empleado" onkeyup = "if(event.keyCode == 13) BuscarEmpleado();" ></td>';
		// echo '<td align="right" width="15px">                    
		// 
		// </td>';
	}
		echo '<td width=20px>
		<button id="beta_buscar_boton" onclick="BuscarEmpleado();">
		 <img  src="icon/buscar.png"></button>
		
		';
		echo "</td>";

	echo '</tr></table>';

	//echo "</form>";
	echo "</div>";


	echo "<div id='EmpleadosBusqueda'>";
	echo "</div>";

	/*if (isset($_GET['search'])) {

		echo "
		<script>
			BuscarEmpleado();
		</script>";
		
	}*/

// 	echo "<div id='ActividadReciente' style='
// 	background-color: #ffffff2b;
// padding: 20px;
// '>";
// echo  "<h1 style='font-size:15pt;'>Actividad reciente en la Plataforma :</h1><br>";

// $sql="
	
// select 
// CONCAT( Nombre,', ', Puesto, ' - ',Departamento) as Empleado,
// CONCAT('[',fecha, ' : ',hora,']',Descripcion ) as Actividad

// from actividad 
// WHERE fecha = CURDATE() 
// limit 1000
// ";
// TablaDinamica_MySQL("",$sql, "MiIdDivTabla2", "IdTabla2", "", 2); //0 = Basica, 1 = ScrollVertical, 2 = Scroll Horizontal



// echo "</div>";


	// xd_update('ap02',$nitavu);//guarda la experiencia del usuario
	
	// historia($nitavu, "Entro a buscar un empleado");

} else {mensaje("ERROR: sin acceso autorizado","");}
echo "
<script>
$('body').css('background-color','rgb(85, 85, 85)');
$('#EmpleadosBuscar').css('background-color','rgb(85, 85, 85)')

</script>";
?>



<?php
	include ("./lib/body_footer.php");
?>