<?php
//include ("./unica/seguridad.php"); 
include ("./unica/body_head.php");
include ("./unica/body_menu.php");

// contenido:
?>


<?php
xd_update('ap10',$nitavu);//guarda la experiencia del usuario
historia($nitavu, "Vio la Lista de Aplicaciones [ap10]");

//PROCESO PARA TOCAR LA PUERTA DE SAN PEDRO
//$id_aplicacion ="ap30"; //ap07=Permisos de Aplicacion
//if (sanpedro($id_aplicacion, $nitavu)==TRUE){
	//echo "<h5>".app_detalle($id_aplicacion)."</h5>";


	//$n=$_GET['n'];//var con la que nos manda la busqueda y nos indica que numero de itavu tiene
	$sql = "SELECT * FROM aplicaciones WHERE version>0 ORDER by idapp ASC";
	//$r_count = $r -> num_rows;
	

	$r = $conexion -> query($sql);
	echo "<table border='0' class='tabla'>";
	echo "<tr><td class='pc'> ID / Ver</td>";
	echo "<td>  </td>";
	echo "<td> NOMBRE </td>";
	echo "<td> DESCRIPCION </td>";
	echo "<td>  </td>";
	echo "</tr>";



	//CONFIGURAR PARAMETROS PARA QUIEN SE LE ENVIARIA NOTIFICACION ELECTRONICA
	//DEL PERMISO

	//Jefe de Sistemas
	//119460 - Juan Jose Pedraza Perales
	$id= 2809;

	//Dir. Administrativo
	//	Rodrigo Elizondo Ramirez
	$id2 = 2774;

	//Rec. Humanos



	while($f = $r -> fetch_array())
		{ // resultado de la busqueda.................

			echo "<tr><td class='tenue pc' >".$f['idapp']." V".$f['version']."</td>";
			echo "<td> "."<img src='./icon/".$f['icono']."' class='icono_menu'>"." </td>";
	
			echo "<td> ".$f['nombre']." </td>";
			echo "<td> ".$f['descripcion']."</td>";






			echo "<td> <a href='documentar.php?g=&id=".$id."&id2=".$id2."&a=ACCESO A PROGRAMA ".$f['idapp']."'>Solicitar Acceso</a></td>";
			echo "</tr>";
			
		}
	echo"</table>";


// }
// else{
// 	mensaje("No tiene acceso a esta aplicacion","");
// }











?>





<?php
include ("./unica/body_footer.php");
?>