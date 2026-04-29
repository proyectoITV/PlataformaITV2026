
<?php
require ("rintera-config.php");
require ("components.php");

    include("seguridad.php");   

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">	
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title><?php echo $Cliente.": ".$ClienteInfo; ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=yes">
    <meta http-equiv="x-ua-compatible" content="ie-edge">

    <script src="lib/popper.min.js"></script>
    <script src="lib/jquery-3.5.1.js"></script>
    <script src="lib/bootstrap/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="src/default.css">



<link rel="stylesheet" type="text/css" href="lib/bootstrap/css/bootstrap.css">
<link rel="stylesheet" href="lib/jquery.toast.min.css">
<script type="text/javascript" src="lib/jquery.toast.min.js"></script>
<link rel="stylesheet" type="text/css" href="lib/datatables.min.css"/> 
<script type="text/javascript" src="lib/datatables.min.js"></script>
<script src="lib/jquery.modalpdz.js"></script> 
<link rel="stylesheet" href="lib/jquery.modalcsspdz.css" />



<link type="text/css" rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jsgrid/1.5.3/jsgrid.min.css" />
<link type="text/css" rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jsgrid/1.5.3/jsgrid-theme.min.css" />
 
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jsgrid/1.5.3/jsgrid.min.js"></script>



</head>
<body>

<?php Init();?>
<div id='PreLoader'>
    <div id='Loader'>
        <img src='img/loader_classic.gif'><br>      
    </div>
</div>


<?php
//TOKENS
$MiToken = MiToken($nitavu, "Users");
// if ($MiToken == ''){
//     $MiToken = MiToken_Init($nitavu, "Edit");
// }
// echo "Token: ".$MiToken;




include ("header.php");

?>


<?php
if (UserAdmin($nitavu)==TRUE){
    if ($UsuariosForaneaos == FALSE){

        $sql ="select * from users";
        $IdTabla = "MiTabla";
        $Clase = "";
        $db= 0 ;
        // DynamicTable_MySQL($sql, "DivUsuarios", $IdTabla, $Clase, 0, $db);

        echo "<div id='jsGrid'></div>";
        
        $r= $db0 -> query($sql);   $clients  = "";
        while($f = $r -> fetch_array()) {   
            $clients = $clients.'{"Nombre": "'.$f['UserName'].'", "IdUser":"'.$f['IdUser'].'","Tipo":'.$f['RinteraLevel'].'},';

        }
        $clients = substr($clients, 0, -1); //quita la ultima coma.
        echo '
            <script>
            var clients = [
                '.$clients.'
            ];
        
            var Tipos = [
                { Name: "", Id: 0 },
                { Name: "Administrador", Id: 1 },
                { Name: "Consultas", Id: 2 }
                
            ];
        
            $("#jsGrid").jsGrid({
                width: "100%",
                height: "400px",
        
                inserting: true,
                editing: true,
                sorting: true,
                paging: true,
        
                data: clients,
        
                fields: [
                    { name: "IdUser", width: 50 },                    
                    { name: "Nombre", type: "text", width: 150, validate: "required" },                    
                    { name: "Tipo", type: "select", items: Tipos, valueField: "Id", textField: "Name" },                    
                    { type: "control" }
                ]
            });
        </script>
        ';

    } else {
        echo "<p>La administración de usuarios se realiza en una base de datos externa!.</p>";
    }
    
} else {
    LocationFull("index.php");
}
?>




</body>
</html>
