<?php include ("./unica/body_head.php"); include ("./unica/body_menu.php"); ?>


<?php

//TEST DE CONECCION A  MS SQL SERVER
// $connectionInfo = array( "Database"=>"$mssql_vic_dbname", "UID"=>"$mssql_vic_dbuser", "PWD"=>"$mssql_vic_dbpass");
// $conn = sqlsrv_connect( $mssql_vic_dbhost, $connectionInfo);

// if( $conn ) {
//      echo "Conexión establecida.<br />";
// }else{
//      echo "Conexión no se pudo establecer.<br />";
//      die( print_r( sqlsrv_errors(), true));
// }





if ($mssql_vic_err==0){
echo "Conectados con exito a Bd victoria";



	$sql = "SELECT * FROM Lotes";
	
	$r = sqlsrv_query( $mssql_vic, $sql );

	if( $r === false) {
	    die( print_r( sqlsrv_errors(), true) );
	}

	while( $f = sqlsrv_fetch_array( $r, SQLSRV_FETCH_ASSOC) ) {
	      echo $f['calle'].", "."<br />";
	}

	sqlsrv_free_stmt( $r); //cierra el $r
}












?>




<?php include ("./unica/body_footer.php"); ?>