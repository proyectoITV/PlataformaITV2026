<?php
//include ("./unica/seguridad.php"); 
include ("./unica/body_head.php");
include ("./unica/body_menu.php");

$id_aplicacion = 'ap03';
$nivel =aplicacion_nivel($id_aplicacion, $nitavu);
//PROCESO PARA TOCAR LA PUERTA DE SAN PEDRO
$id_aplicacion ="ap03"; //ap07=Permisos de Aplicacion
if (sanpedro($id_aplicacion, $nitavu)==TRUE){
	echo "<h5>".app_detalle($id_aplicacion)."</h5>";

	?>


<script>
 function BuscarEmpleado(){
        
        txtName = $("#q").val();
        var n = txtName.length;
        console.log(txtName + "N=" + n);
        if (n>=4){
            console.log("Ya esta listo "+ n);
            
            BuscarEmpleadoBD();
        }
    }


    function BuscarEmpleadoBD(){
		
		$("#EmpleadosBusqueda").html("<img src='img/loader4.gif' style='width:200px;'><br> <label style='font-size:14pt; color:gray;'>buscando...</label>");
		txtq = $("#q").val();
		console.log("Ejecuanto.." + txtq);
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
	
	echo '<table border="0" width="100%"><tr>';
	echo "<td width=20px></td>";
	echo '<td>';
			echo '<input type="text" name="q" id="q" value="" placeholder="Nombre del Empleado" onkeypress="BuscarEmpleado()"></td>';
		// echo '<td align="right" width="15px">                    
		// <button id="beta_buscar_boton">
		// <img  src="icon/buscar.png"></button>
		// </td>';
		echo "<td width=20px></td>";
	echo '</tr></table>';

	echo "</form>";
	echo "</div>";


	echo "<div id='EmpleadosBusqueda'>";
	echo "</div>";

	// xd_update('ap02',$nitavu);//guarda la experiencia del usuario
	
	// historia($nitavu, "Entro a buscar un empleado");

} else {mensaje("ERROR: sin acceso autorizado","");}

?>



<?php
	include ("./unica/body_footer.php");
?>