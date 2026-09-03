<?php
require("config.php");
require("seguridad.php");
require("var_clean.php");
require("lib/funciones.php");
require("vehiculos_fun.php");

$id_aplicacion = "ci";
$nivel = aplicacion_nivel($id_aplicacion, $nitavu);

echo "<div>";
if ($nivel == 2) {
    echo "
            <div class='content'>
                <h1 style = 'color:black; text-align: left;'>Agregar/Quitar archivos</h1>
            </div>

            <a href='subirarchivos_normatividad.php' class='theme-btn btn-style-one' >Administrar Documentos</a>
        ";
} else {
    echo "
            <div class='content'>
                <h1 style = 'color:black; text-align: left;'>Archivos disponibles</h1>
            </div>
        ";
}

$groups = [
    1 => [
        'title' => '1. MARCO NORMATIVO INSTITUCIONAL',
        'docs' => []
    ],
    2 => [
        'title' => '2. ALINEACIÓN SUPERIOR',
        'docs' => []
    ],
    3 => [
        'title' => '3.(SCII) SISTEMA DE CONTROL INTERNO INSTITUCIONAL',
        'docs' => []
    ],
    4 => [
        'title' => '4. ETICA, CONDUCTA Y PREV',
        'docs' => []
    ],
    5 => [
        'title' => '5.ACTIVIDADES INSTITUCIONALES',
        'docs' => []
    ],
    6 => [
        'title' => '6.UNIDAD DE IGUALDAD DE GÉNERO',
        'docs' => []
    ],
    7 => [
        'title' => '7. COMITÉ DE COMPRAS',
        'docs' => []
    ]

];

$sql = "SELECT ci_html.*, ci.grupo, ci.OrdenVisual FROM ci_html JOIN ci ON ci_html.IdCi = ci.IdCi ORDER BY ci.grupo ASC, ci.OrdenVisual ASC";
$r = $conexion->query($sql);

while ($f = $r->fetch_array()) {
    $gId = intval($f['grupo']);
    if (isset($groups[$gId])) {
        $groups[$gId]['docs'][] = $f;
    } else {
        if (!isset($groups[99])) {
            $groups[99] = [
                'title' => '8. OTROS DOCUMENTOS',
                'docs' => []
            ];
        }
        $groups[99]['docs'][] = $f;
    }
}

echo "<div class='ci-accordion'>";
foreach ($groups as $gId => $group) {
    $docCount = count($group['docs']);

    echo "<div class='ci-group' id='group-$gId'>";
    echo "  <div class='ci-group-header' onclick='toggleGroup(this)'>";
    echo "    <div class='ci-group-title'>";
    echo "      <svg width='18' height='18' viewBox='0 0 24 24' fill='none' stroke='currentColor' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'><path d='M22 19a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h5l2 3h9a2 2 0 0 1 2 2z'></path></svg>";
    echo "      <span style='margin-left: 8px;'>" . $group['title'] . "</span>";
    echo "      <span class='ci-group-badge'>$docCount</span>";
    echo "    </div>";
    echo "    <div class='ci-toggle-icon'>";
    echo "      <svg class='ci-chevron' width='16' height='16' viewBox='0 0 24 24' fill='none' stroke='currentColor' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'><polyline points='6 9 12 15 18 9'></polyline></svg>";
    echo "    </div>";
    echo "  </div>";

    echo "  <div class='ci-group-content' style='display: none;'>";
    if ($docCount > 0) {
        echo "    <table class='styled-table' width='100%'>";
        echo "      <thead>";
        echo "        <tr>";
        echo "          <th width='2%'>Cve</th>";
        echo "          <th width='55%'>Nombre del documento</th>";
        echo "          <th width='20%'>Descripción</th>";
        echo "          <th width='10%'>Vistas</th>";
        echo "          <th width='13%'> </th>";
        echo "        </tr>";
        echo "      </thead>";
        echo "      <tbody>";
        foreach ($group['docs'] as $f) {
            echo "        <tr>";
            echo "          <td>" . $f["IdCi"] . "</td>";
            echo "          <td>" . $f["Documento"] . "</td>";
            echo "          <td>" . $f["Descripcion"] . "</td>";
            echo "          <td>" . $f["Vistas"] . "</td>";
            echo "          <td>" . '' . "</td>";
            echo "        </tr>";
        }
        echo "      </tbody>";
        echo "    </table>";
    } else {
        echo "    <div class='no-docs-message' style='color: #666; font-style: italic; text-align: center; padding: 20px 0;'>No hay documentos disponibles en esta sección por el momento.</div>";
    }
    echo "  </div>";
    echo "</div>";
}
echo "</div>";
echo "</div>";
?>

<script>
    if (typeof toggleGroup !== 'function') {
        window.toggleGroup = function (header) {
            var group = $(header).closest('.ci-group');
            var content = group.find('.ci-group-content');
            var isActive = group.hasClass('active');

            // Collapse all other groups
            $('.ci-group').not(group).removeClass('active').find('.ci-group-content').slideUp(300);

            // Toggle active state for current group
            if (isActive) {
                group.removeClass('active');
                content.slideUp(300);
            } else {
                group.addClass('active');
                content.slideDown(300);
            }
        };
    }
</script>