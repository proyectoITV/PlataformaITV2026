<?php
require_once("config.php");
require_once("funciones.php");

$nitavu          = $_POST['nitavu'];
$FileDescripcion = $conexion->real_escape_string($_POST['FileDescripcion']);
$IdApp           = 'ap105';

// Normalizar el array de archivos (soporta 1 o varios)
$archivos = [];
if (isset($_FILES['archivo']) && is_array($_FILES['archivo']['name'])) {
    $total = count($_FILES['archivo']['name']);
    for ($i = 0; $i < $total; $i++) {
        $archivos[] = [
            'name'     => $_FILES['archivo']['name'][$i],
            'type'     => $_FILES['archivo']['type'][$i],
            'tmp_name' => $_FILES['archivo']['tmp_name'][$i],
            'error'    => $_FILES['archivo']['error'][$i],
        ];
    }
}

$resultados = [];
$total_ok   = 0;

foreach ($archivos as $archivo) {

    $FileNombre   = $archivo['name'];
    $tipo_archivo = $archivo['type'];

    if ($archivo['error'] !== UPLOAD_ERR_OK) {
        switch ($archivo['error']) {
            case UPLOAD_ERR_INI_SIZE:
                $mensajeError = "El archivo excede la directiva upload_max_filesize en php.ini.";
                break;
            case UPLOAD_ERR_FORM_SIZE:
                $mensajeError = "El archivo excede el límite MAX_FILE_SIZE especificado en el formulario HTML.";
                break;
            case UPLOAD_ERR_PARTIAL:
                $mensajeError = "El archivo fue subido solo parcialmente.";
                break;
            case UPLOAD_ERR_NO_FILE:
                $mensajeError = "No se subió ningún archivo.";
                break;
            case UPLOAD_ERR_NO_TMP_DIR:
                $mensajeError = "Falta la carpeta temporal en el servidor.";
                break;
            case UPLOAD_ERR_CANT_WRITE:
                $mensajeError = "No se pudo escribir el archivo en el disco (problema de permisos).";
                break;
            case UPLOAD_ERR_EXTENSION:
                $mensajeError = "Una extensión de PHP detuvo la subida del archivo.";
                break;
            default:
                $mensajeError = "Error desconocido (" . $archivo['error'] . ").";
                break;
        }

        $resultados[] = htmlspecialchars($FileNombre) . ": " . $mensajeError;
        continue;
    }

    if (strpos($tipo_archivo, 'pdf') === false) {
        $resultados[] = htmlspecialchars($FileNombre) . ": tipo no permitido";
        continue;
    }

    $NFile        = NFile($IdApp);
    $pos          = strpos($tipo_archivo, '/');
    $extension    = substr($tipo_archivo, $pos + 1);
    $archivofinal = 'files/' . $NFile . '.' . $extension;

    if (move_uploaded_file($archivo['tmp_name'], $archivofinal)) {
        $FileNombreEsc = $conexion->real_escape_string($FileNombre);
        $sql = "INSERT INTO TransparenciaGo(IdFile, FileNombre, IdUser, fecha, hora, FileDescripcion)
                VALUES ('" . $NFile . "', '" . $FileNombreEsc . "', '" . $nitavu . "', '" . $fecha . "','" . $hora . "', '" . $FileDescripcion . "')";
        if ($conexion->query($sql) == TRUE) {
            $total_ok++;
            $resultados[] = htmlspecialchars($FileNombre) . ": subido y guardado";
            historia($nitavu, 'TransparenciaGo, subio el archivo ' . $FileNombre . ' con IdFile ' . $NFile . InfoEquipo() . '');
        } else {
            $resultados[] = htmlspecialchars($FileNombre) . ": guardado en disco pero error en BD";
        }
    } else {
        $resultados[] = htmlspecialchars($FileNombre) . ": error al mover el archivo";
    }
}

$total_archivos = count($archivos);
$msg = $total_ok . " de " . $total_archivos . " archivo(s) subido(s). " . implode(" | ", $resultados);

header('Content-Type: application/json');
echo json_encode([
    'success' => ($total_ok === $total_archivos && $total_archivos > 0),
    'total_ok' => $total_ok,
    'total_archivos' => $total_archivos,
    'message' => $msg
]);
?>