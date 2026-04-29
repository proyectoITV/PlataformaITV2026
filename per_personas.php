<?php
//include (".//seguridad.php"); 
include ("./lib/body_head.php");
include ("./lib/body_menu.php");

// contenido:
?>







<?php 


$id_aplicacion ="ap54"; //ap07=Permisos de Aplicacion
if (sanpedro($id_aplicacion, $nitavu)==TRUE){
	echo "<div id='AppDetalle'>".app_detalle($id_aplicacion, $nitavu)."</div>";	
	

echo '<div class ="centrar_padre">';
echo '<div class = "centrar_hijo">';
	buscar('per_persona_buscar.php','Busqueda por nombre del beneficiario','');
		historia($nitavu, "Per_Entró a buscar un persona");




	/*	<form action="empleados_buscar.php" method="get">
			<table width="100%" border='0'>
			<tr>
			<td  valign="middle">				
				<input required="" type="text" name="search" id="search" placeholder="Tipea parte del nombre">
				<br>
			</td>
			
			<td valign="top">
				<button class="Mbtn btn-default pc"> Buscar </button>
			</td>
			</tr>
			<tr>
			<td colspan="2" =3 align="center">

			<button class="Mbtn btn-default movil"> Buscar </button>
			</td>
			
			</tr>				
			</table>

			
		</form>*/
echo '</div>';
echo '</div>';
}else
{
echo "<br><br>";
	mensaje("No tiene acceso al modúlo de personas beneficiadas (".$id_aplicacion.")", "index.php");}

?>
	<br><br><br><br><br><br>
	<br><br><br><br><br><br>
<?php
include ("./lib/body_footer.php");
?>