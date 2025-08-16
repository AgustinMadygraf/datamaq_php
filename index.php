<?php
/*
Path: index.php
*/

// Nuevo: Redirigir peticiones API a Router.php
if (strpos($_SERVER['REQUEST_URI'], '/backend/api') !== false) {
    require_once __DIR__ . '/backend/api/Router.php';
    exit;
}

// Permitir acceso a archivos estáticos JS y CSS
if (preg_match('/\.(js|css)$/i', $_SERVER['REQUEST_URI'])) {
    // Esta es una solicitud de archivo estático
    $filePath = __DIR__ . parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    if (file_exists($filePath)) {
        // Establecer el tipo de contenido correcto
        $extension = strtolower(pathinfo($filePath, PATHINFO_EXTENSION));
        $contentType = $extension === 'js' ? 'application/javascript' : 'text/css';
        header("Content-Type: $contentType");
        readfile($filePath);
        exit;
    }
    // Si el archivo no existe, continuamos con el flujo normal para que se muestre un 404
}

require_once __DIR__ . '/backend/controllers/DashboardController.php';
require_once __DIR__ . '/backend/core/ViewRenderer.php';

// Instanciar el controlador y obtener los datos para la vista principal
$controller = new DashboardController();
$data = $controller->index();

// Renderizar la cabecera
$header = ViewRenderer::render(__DIR__ . '/frontend/templates/header.html');

// Agregar la cabecera y datos iniciales al array de datos
$data['header'] = $header;
$data['initialData'] = json_encode([
    'periodo' => $data['periodo'] ?? null,
    'conta' => $data['conta'] ?? null,
    'csrfToken' => $data['csrfToken'] ?? null
]);

// Renderizar la vista principal con los datos preparados por el controlador
echo ViewRenderer::render(__DIR__ . '/frontend/templates/main.html', $data);

error_log("INFO - Renderizado básico completado - Memory usage: " . memory_get_peak_usage(true));
?>