<?php include ("./lib/body_head.php"); include ("./lib/body_menu.php"); ?>




<?php

//PROCESO PARA TOCAR LA PUERTA DE SAN PEDRO
$id_aplicacion ="ap39"; //Id de la aplicacion a cargar
$nivel = aplicacion_nivel($id_aplicacion, $nitavu);
if (sanpedro($id_aplicacion, $nitavu)==TRUE){
echo "<div id='AppDetalle'>".app_detalle($id_aplicacion, $nitavu)."</div>";

echo "<div id='notigaleria'>";
// echo "<nav>";
// 	echo "<a href=''>Baldios</a>";
// 	echo "<a href=''>Habitados</a>";
// 	echo "<a href=''>En Construccion</a>";
// 	echo "<a href=''>Rentado</a>";
// 	echo "<a href=''>Vandalizado</a>";
// echo "</nav>";


//beneficiario_old_curp
//beneficiario_idsol  * temporalmente lo hare con idsoliciante pero dejar preparado para curp

historia($nitavu,'Vio NotiGaleria app:'.$id_aplicacion);

echo "<section>"; 
$ft= "";

if (isset($_GET['id'])){
	if ($_GET['id']<>""){

$sql = "SELECT * FROM notificadores_visitas where id='".$_GET['id']."'";
	$rc= $conexion -> query($sql);	if($f = $rc -> fetch_array())
	{// id=OK // foto seleccionada
		historia($nitavu,'Vio NotiGaleria con id '.$_GET['id'].' app:'.$id_aplicacion);
		$archivo = 'notificadores/'.$f['contrato'].'_'.$f['visita_fecha'].'_lote.jpg';
		$ft = $ft.ponerfoto($archivo,'notigaleria_foto');
		$ft = $ft."<label>";
		$ft = $ft."<b class='normal'> ID ".$f['id']." </b>, CONTRATO: ".$f['contrato'].":  ";
		$ft = $ft."<div class='comentario'>".$f['visita_comentarios']."</div>";
		$ft = $ft." En ".$f['colonia']." ".$f['manzana_lote']." Deleg. ".delegacion_id($f['delegacion']);
		$situacion="";
		if ($f['estado_lotebaldio']=='1'){$situacion="Baldio";}//Si =1
		if ($f['estado_lotehabitado']=='1'){$situacion="Habitado";}//Si =1
		if ($f['estado_loteenconstruccion']=='1'){$situacion="En Construccion";}//Si =1
		if ($f['estado_loterentado']=='1'){$situacion="Rentado";}//Si =1
		if ($f['estado_ubvvaciavandalizada']=='1'){$situacion="Vandalizado";}//Si =1
		if ($f['estado_ubvhabitada']=='1'){$situacion="UBV habitada";}//Si =1
		if ($f['estado_ubvvaciaenbuenestado']=='1'){$situacion="UBV Vacia en Buen Estado";}//Si =1
		if ($f['estado_ubvrentada']=='1'){$situacion="UBV Rentada";}//Si =1
		if ($situacion==""){$situacion="La respuesta a la encuesta del visitador fue NO a todas.";}



		$ft = $ft."<b class='ejecutandose'> Situacion: ".$situacion."</b>";

		$ft = $ft. "<br>Notificador:<b class='normal'> ".nitavu_nombre($f['notificador_nitavu'])."</b> Visitada  el ".fecha_larga($f['visita_fecha'])." a las ".$f['visita_hora'];
		$ft = $ft."</label>";

		// $sql2 = "SELECT * FROM notificaciones_old where contrato='".$f['contrato']."' and follio='x'";
		// $r= $conexion-migra -> query($sql);	if($f2 = $rc -> fetch_array())
		// {
		// 	$id_sol = $f['id']
		// }
		$ft = $ft. "<a href='?id=&busqueda=".$_GET['busqueda']."' class='Mbtn btn-secundario'>"."<img src='icon/left.png' class='icono'>"."</a> ";
		$ft = $ft. "<a href='notificadores_visita.php?brig=1&busqueda=".$f['contrato']."' class='Mbtn btn-default'>"."<img src='icon/more.png' class='icono'> "."</a> ";
		if ($nivel==2){
			$ft = $ft. "<a href='?busqueda=".$_GET['busqueda']."&id=".$_GET['id']."&x=TRUE&contrato=".$f['contrato']."&brig=".$f['brigada_id']."' class='Mbtn btn-cancel'>  "." <img src='icon/notificadores2.png' class='icono' title='Eliminara la captura, para que el notificador pueda recapturar la visita'>"." </a> ";
			
			$rest_msg="";		
			if (isset($_GET['contrato']) and isset($_GET['brig'])){
			$sql="UPDATE notificaciones_old SET folio='' WHERE contrato='".$_GET['contrato']."' and brigada_id='".$_GET['brig']."'";
			$rest = $conexionmigra -> query($sql);
			if ($conexionmigra->query($sql) == TRUE) {
					
					$sql="DELETE from notificadores_visitas  WHERE id='".$_GET['id']."'";
					$rest = $conexion -> query($sql);
					if ($conexion->query($sql) == TRUE) {$rest_msg="Recaptura activada con exito del Lote con contrato ".$_GET['contrato'];} else {mensaje("error ".$sql,'');}
					

			}else {mensaje("error ".$sql,'');}}
			if ($rest_msg<>""){
				historia($nitavu, "Utilizo Recaptura de Lote en Noti-Galeria ap39 : ".$rest_msg);
				mensaje($rest_msg,'notificadores_galeria.php?&busqueda='.$_GET['busqueda']);}

		}
		
		$id_hasta = $_GET['id'] + 3;
		$id_desde = $_GET['id'] - 3;

		$barra = "<div id='notigaleria_barra' class=''>"; // menu de fotos (siguientes y atras 5+-)

			$sql = "SELECT * FROM notificadores_visitas where id>='$id_desde' and id<='$id_hasta' order by id ASC";
			$r2 = $conexion -> query($sql);
			$tmp="";
			while($f = $r2 -> fetch_array())
			{//Categorias de Aplicaciones
				if ($f['id']==$_GET['id']){
				$barra = $barra."<a href='&busqueda=".$_GET['busqueda']."' class='ejecutandose' title='<-- Seleccionada'>";
				$archivo = 'notificadores/'.$f['contrato'].'_'.$f['visita_fecha'].'_lote.jpg';
				$barra = $barra."<img src='$archivo' class='notigaleria_foto_barra_select'>";
				//$barra = $barra."".$f['id'];
				$barra = $barra."</a>";
				} else
				{
				$barra = $barra."<a href='?id=".$f['id']."&busqueda=".$_GET['busqueda']."' class='normal' title='".$f['id']."'>";
				$archivo = 'notificadores/'.$f['contrato'].'_'.$f['visita_fecha'].'_lote.jpg';
				$barra = $barra."<img src='$archivo' class='notigaleria_foto_barra'>";
				
				//$barra = $barra."".$f['id'];
				$barra = $barra."</a>";
				}

			}


		$barra = "<span class='pc'>".$barra."</div></span>";


		echo "<article>".$ft;
	
		echo "</article>";
			echo $barra;
	}
	}

	
	if ($_GET['id']==""){
			echo "<div id='notigaleria_aleatorias'>";
			$sql = "SELECT * FROM notificadores_visitas ORDER BY RAND() LIMIT 10";
			$r2 = $conexion -> query($sql);
			$barra="";
			while($f = $r2 -> fetch_array())
			{//Categorias de Aplicaciones

				$barra = $barra."<a href='?id=".$f['id']."' class='normal' title='".$f['id']."'>";
				$archivo = 'notificadores/'.$f['contrato'].'_'.$f['visita_fecha'].'_lote.jpg';
				$barra = $barra."<img src='$archivo' class='notigaleria_foto_barra'></a>";
				
				
			}
			//echo $barra;			
			echo "</div>";
    }
	}

	echo "<br><br>";
	buscar("notificadores_galeria.php","BUSCAR ID, CONTRATO, Colonia, Comentarios, Tambien ejemplo: M:2, L:1",'');

	if (isset($_GET['busqueda'])){
	historia($nitavu,'Busco en NotiGaleria con  '.$_GET['busqueda'].' app:'.$id_aplicacion);
	$b=$_GET['busqueda'];
	echo "<div id='notigaleria_aleatorias'>";
	$sql="";
	if ($_GET['busqueda']=='baldio'){

		$sql = 	"SELECT  DISTINCT contrato FROM notificadores_visitas WHERE  estado_lotebaldio='1'";
		$sql="SELECT DISTINCT
	contrato,
	(
		SELECT
			MIN(dos.id) AS id
		FROM
			notificadores_visitas AS dos
		WHERE
			dos.contrato = notificadores_visitas.contrato
	) AS id,
	(
		SELECT
			tres.visita_fecha AS visita_fecha
		FROM
			notificadores_visitas AS tres
		WHERE
			tres.contrato = notificadores_visitas.contrato
		AND tres.id = notificadores_visitas.id
	) AS visita_fecha,
	(
		SELECT
			cuatro.manzana_lote AS visita_fecha
		FROM
			notificadores_visitas AS cuatro
		WHERE
			cuatro.contrato = notificadores_visitas.contrato
		AND cuatro.id = notificadores_visitas.id
	) AS manzana_lote
FROM
	notificadores_visitas
WHERE
	id_estado_lote=1";
	

	}


if ($_GET['busqueda']=='habitado'){

		$sql = 	"SELECT  DISTINCT contrato FROM notificadores_visitas WHERE  estado_lotebaldio='1'";
		$sql="SELECT DISTINCT
	contrato,
	(
		SELECT
			MIN(dos.id) AS id
		FROM
			notificadores_visitas AS dos
		WHERE
			dos.contrato = notificadores_visitas.contrato
	) AS id,
	(
		SELECT
			tres.visita_fecha AS visita_fecha
		FROM
			notificadores_visitas AS tres
		WHERE
			tres.contrato = notificadores_visitas.contrato
		AND tres.id = notificadores_visitas.id
	) AS visita_fecha,
	(
		SELECT
			cuatro.manzana_lote AS visita_fecha
		FROM
			notificadores_visitas AS cuatro
		WHERE
			cuatro.contrato = notificadores_visitas.contrato
		AND cuatro.id = notificadores_visitas.id
	) AS manzana_lote
FROM
	notificadores_visitas
WHERE
	id_estado_lote=3";
}


if ($_GET['busqueda']=='construccion'){

		$sql = 	"SELECT  DISTINCT contrato FROM notificadores_visitas WHERE  estado_lotebaldio='1'";
		$sql="SELECT DISTINCT
	contrato,
	(
		SELECT
			MIN(dos.id) AS id
		FROM
			notificadores_visitas AS dos
		WHERE
			dos.contrato = notificadores_visitas.contrato
	) AS id,
	(
		SELECT
			tres.visita_fecha AS visita_fecha
		FROM
			notificadores_visitas AS tres
		WHERE
			tres.contrato = notificadores_visitas.contrato
		AND tres.id = notificadores_visitas.id
	) AS visita_fecha,
	(
		SELECT
			cuatro.manzana_lote AS visita_fecha
		FROM
			notificadores_visitas AS cuatro
		WHERE
			cuatro.contrato = notificadores_visitas.contrato
		AND cuatro.id = notificadores_visitas.id
	) AS manzana_lote
FROM
	notificadores_visitas
WHERE
	id_estado_lote=5";
}


if ($_GET['busqueda']=='rentado'){

		$sql = 	"SELECT  DISTINCT contrato FROM notificadores_visitas WHERE  estado_lotebaldio='1'";
		$sql="SELECT DISTINCT
	contrato,
	(
		SELECT
			MIN(dos.id) AS id
		FROM
			notificadores_visitas AS dos
		WHERE
			dos.contrato = notificadores_visitas.contrato
	) AS id,
	(
		SELECT
			tres.visita_fecha AS visita_fecha
		FROM
			notificadores_visitas AS tres
		WHERE
			tres.contrato = notificadores_visitas.contrato
		AND tres.id = notificadores_visitas.id
	) AS visita_fecha,
	(
		SELECT
			cuatro.manzana_lote AS visita_fecha
		FROM
			notificadores_visitas AS cuatro
		WHERE
			cuatro.contrato = notificadores_visitas.contrato
		AND cuatro.id = notificadores_visitas.id
	) AS manzana_lote
FROM
	notificadores_visitas
WHERE
	id_estado_lote=4";
	

	}



if ($_GET['busqueda']=='duplicados'){

		$sql = 	"SELECT  DISTINCT contrato FROM notificadores_visitas WHERE  estado_lotebaldio='1'";
		$sql="SELECT
	COUNT(*),
	contrato,
	contrato,
	visita_fecha,
	brigada_id, delegacion, id, manzana_lote
FROM
	notificadores_visitas
GROUP BY
	contrato,
	contrato
HAVING
	COUNT(*) > 1 and brigada_id";
	

	}


	if (isset($_GET['del'])){
		if ($_GET['del']<>''){$sql = $sql." and delegacion='".$_GET['del']."'";}
	}

	if ($sql=='') { // 
		$sql = "SELECT * FROM notificadores_visitas WHERE 
		contrato like'%$b%' or 
		visita_comentarios like'%$b%' or
		colonia like'%$b%'or 
		manzana_lote like '%$b%' or
		id like '%$b%' 



	";}	
	//echo $sql;
	
	if (isset($_GET['col'])){
		$sql = $sql." and colonia='".$_GET['col']."'";
	}
	$r2 = $conexion -> query($sql);
	$r_count = $r2 -> num_rows;
	echo "<h1>Buscando sobre <b>".$_GET['busqueda']."(".$r_count.")</b><br>";

	$r3 = $conexion -> query("select DISTINCT colonia from notificadores_visitas");
	while($f3 = $r3 -> fetch_array())
	{
		echo "<a class='tchico' href='notificadores_galeria.php?brig=&busqueda=".$_GET['busqueda']."&col=".$f3['colonia']."'>".$f3['colonia']."</a> | ";
	}
	echo "</h1>";

	$barra="";
	while($f = $r2 -> fetch_array())
	{//Categorias de Aplicaciones

		$barra = $barra."<a href='?id=".$f['id']."&busqueda=".$_GET['busqueda']."' class='normal' title='".$f['manzana_lote']." Contrato: ".$f['contrato']."'>";
		$archivo = 'notificadores/'.$f['contrato'].'_'.$f['visita_fecha'].'_lote.jpg';
		$barra = $barra."<img src='$archivo' class='notigaleria_foto_barra'></a>";
		
		
	}
	echo $barra;			
	echo "</div>";

	



	


	
}


echo "</section>";















echo "</div>";










}
else
{
	mensaje("No tiene acceso a esta aplicacion",'');
}

?>



</div> 
   

<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>


<script language="javascript">

function cambia(id_del_objeto,nueva_clase){
	var objeto = getElementById(id_del_objeto);
	objeto.className = nueva_clase;
	alert();
	
	//document.getElementById("divDatos").className = "nombreDeClase";
}

function notify(evt){
    var url = Aldama.target.getAttribute('data-url');
    window.open(url);
}
</script>
<?php include ("./lib/body_footer.php"); ?>
</section>