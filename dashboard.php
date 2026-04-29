<?php
// Iniciar la sesión
session_start();

// Verificar si el usuario NO está logueado
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: index.php"); // Redirigir al login si no está autenticado
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard | Sistema de Gestión</title>
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background-color: #f4f7f6; color: #333; margin: 0; padding: 0; }
        .header { background-color: #007bff; color: white; padding: 20px; display: flex; justify-content: space-between; align-items: center; }
        .header h1 { margin: 0; font-size: 1.5em; }
        .header a { color: white; text-decoration: none; padding: 8px 15px; border: 1px solid white; border-radius: 5px; transition: background-color 0.3s; }
        .header a:hover { background-color: #0056b3; }
        .container { width: 90%; margin: 20px auto; max-width: 1200px; }
        
        /* Estilos de ejemplo para el carousel y las opciones */
        .carousel-placeholder { background-color: #e9ecef; border: 1px solid #ddd; padding: 50px; text-align: center; margin-bottom: 30px; border-radius: 8px; }
        .options-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 20px; }
        .option-card { background-color: white; padding: 25px; border-radius: 8px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); text-align: center; }
        .option-card h3 { color: #007bff; margin-top: 0; }
    </style>
</head>
<body>
    <div class="header">
        <h1>Bienvenido, <?php echo htmlspecialchars($_SESSION["username"]); ?> 👋</h1>
        <a href="logout.php">Cerrar Sesión</a>
    </div>

    <div class="container">
        <h2>Panel Principal del Sistema</h2>

        <div class="carousel-placeholder">
            <h3>[Aquí irá tu Carousel de Información / Noticias]</h3>
            <p>Integra aquí tu librería de carousel preferida (ej. Bootstrap Carousel).</p>
        </div>

        <div class="options-grid">
            <div class="option-card">
                <h3>👥 Gestión de Usuarios</h3>
                <p>Administra las cuentas de usuario y sus permisos.</p>
            </div>
            <div class="option-card">
                <h3>📊 Reportes Financieros</h3>
                <p>Genera informes detallados y estadísticas.</p>
            </div>
            <div class="option-card">
                <h3>⚙️ Configuración del Sistema</h3>
                <p>Ajustes generales y mantenimiento.</p>
            </div>
            <div class="option-card">
                <h3>📚 Documentación</h3>
                <p>Acceso a manuales y guías de uso.</p>
            </div>
        </div>
    </div>
</body>
</html>