<?php
    ini_set('display_errors', 1);
    error_reporting(E_ALL);

    require("config.php");
    require("components.php");
    include("seguridad.php");

    $id_rep = isset($_POST['id_rep']) ? (int)$_POST['id_rep'] : (isset($_GET['id_rep']) ? (int)$_GET['id_rep'] : 0);

    if ($id_rep === 27) {
        $sql = "SELECT * FROM encuesta_satisfaccion2026";
        $resultado = $conexion->query($sql);

        if (!$resultado) {
            echo "No fue posible consultar la vista encuesta_satisfaccion2026. Error: " . $conexion->error;
            exit;
        }

        echo "
        <style>
            @page {
                size: Letter;
                margin: 0.5in;
            }
            body {
                font-family: Arial, sans-serif;
                font-size: 8pt;
                margin: 0;
            }
            .no-print {
                margin-bottom: 10px;
                text-align: right;
            }
            .report-wrap {
                width: 100%;
                max-width: 100%;
                overflow: hidden;
            }
            table {
                width: 100%;
                border-collapse: collapse;
                table-layout: fixed;
                page-break-inside: avoid;
            }
            th, td {
                border: 1px solid #333;
                padding: 4px 6px;
                text-align: left;
                vertical-align: top;
                word-break: break-word;
            }
            th {
                background: #f0f0f0;
                font-weight: bold;
            }
            @media print {
                .no-print {
                    display: none !important;
                }
                body {
                    font-size: 7.5pt;
                    margin: 0;
                }
                table {
                    width: 100%;
                    max-width: 100%;
                    font-size: 7.5pt;
                }
            }
        </style>
        ";

        echo "<div class='no-print'><button type='button' onclick='window.print();'>Imprimir</button></div>";
        echo "<div class='report-wrap'><table><thead><tr>";

        $fields = $resultado->fetch_fields();
        foreach ($fields as $field) {
            echo "<th>" . htmlspecialchars($field->name, ENT_QUOTES, 'UTF-8') . "</th>";
        }
        echo "</tr></thead><tbody>";

        while ($row = $resultado->fetch_assoc()) {
            echo "<tr>";
            foreach ($fields as $field) {
                $valor = isset($row[$field->name]) ? $row[$field->name] : "";
                echo "<td>" . htmlspecialchars((string)$valor, ENT_QUOTES, 'UTF-8') . "</td>";
            }
            echo "</tr>";
        }

        echo "</tbody></table></div>";
        exit;
    }

    if ($id_rep <= 0) {
        echo "Reporte no válido.";
        exit;
    }

    $Tipo = ReporteTipo($id_rep);
    $ClaseDiv  = "ContenedorDeReporte";
    $ClaseTabla = "tabla";
    $Data = Reporte($id_rep, $Tipo, $ClaseDiv, $ClaseTabla, $nitavu);
    echo $Data;
?>