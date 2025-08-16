<?php
/*
Path: backend/api/Router.php
*/

// Cargar el middleware de seguridad
require_once __DIR__ . '/../middleware/ApiSecurityMiddleware.php';

// Aplicar comprobaciones de seguridad
if (!ApiSecurityMiddleware::apply()) {
    // El middleware enviará la respuesta de error apropiada y terminará la ejecución
    exit;
}

$requestMethod = $_SERVER['REQUEST_METHOD'];
$requestUri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

// Remove base path if necessary. Adjust this prefix based on your deployment.
$basePath = '/DataMaq/backend/api';
$endpoint = '/' . ltrim(substr($requestUri, strlen($basePath)), '/');

// Registramos la petición para seguimiento y auditoría
error_log("API Request: $requestMethod $endpoint");

// Route API calls if endpoint starts with "/endpoints"
if (strpos($endpoint, '/endpoints') === 0) {
    // Construir ruta dinámica al archivo del endpoint.
    $apiFile = __DIR__ . $endpoint . '.php';
    if (file_exists($apiFile)) {
        require_once $apiFile;
    } else {
        echo json_encode(\Backend\Api\Responses\ErrorResponse::error('Endpoint not found', 404));
    }
    exit;
}

switch ($endpoint) {
    default:
        echo json_encode(\Backend\Api\Responses\ErrorResponse::error('Endpoint not found', 404));
        break;
}
