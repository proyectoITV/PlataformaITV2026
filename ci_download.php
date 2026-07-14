<?php
require("config.php");
require("seguridad.php");
require("var_clean.php");
require("lib/funciones.php");
require("vehiculos_fun.php");

header('Content-Type: application/json');

if (isset($_GET['id'])){
    $id = $_GET['id'];

    $sql = "SELECT * FROM ci WHERE IdCi='".$id."'";
	$rc = $conexion->query($sql);
	
	if($f = $rc->fetch_array())	
    {
        // Register visit
        ciHistory($id, $nitavu);
        
        $localPath = "ci/" . $f['Link'];
        $fileUrl = $localPath;
        
        // Fallback to production URL when running on localhost and the file is not found locally
        if (!file_exists($localPath)) {
            $fileUrl = "https://plataformaitavu.tamaulipas.gob.mx/ci/" . rawurlencode($f['Link']);
        }
        
        $response = [
            'success' => true,
            'nombre' => trim($f['Nombre']),
            'link' => $fileUrl,
            'icon' => $f['icon'],
            'isVideo' => ($f['icon'] == 'video.png')
        ];
        echo json_encode($response);
    }
	else
	{
        echo json_encode(['success' => false, 'message' => 'Archivo no Disponible']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'ID no proporcionado']);
}
?>