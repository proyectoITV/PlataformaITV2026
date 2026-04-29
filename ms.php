<?php include ("./lib/body_head.php"); include ("./lib/body_menu.php"); ?>

<?php


// Hacer una consulta simple, seleccionar la versión de
// MSSQL y mostrarla.



$sql = "SELECT  count(*) as n FROM lotes WHERE (IdMunicipio IN(13, 16, 20, 30, 34, 36, 41))";	
echo "<h1>".$sql."</h1>";
if ($mssql_vic_err==0){
//echo "Conectados con exito a Bd victoria";
	$r = sqlsrv_query( $mssql_vic, $sql );
	if( $r === false) {
	    die( print_r( sqlsrv_errors(), true) );
	}

	while( $f = sqlsrv_fetch_array( $r, SQLSRV_FETCH_ASSOC) ) {
	      echo "<b>MS SQL </b>, Lotes: ".$f['n'].", "."<br />";
	}

	sqlsrv_free_stmt( $r); //cierra el $r
}



	
	$rc= $conexion -> query($sql);
	if($f = $rc -> fetch_array())
	{
		echo "<b>MYSQL</b>, Lotes:".$f['n']."<br>";
	}

?>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<?php include ("./lib/body_footer.php"); ?>