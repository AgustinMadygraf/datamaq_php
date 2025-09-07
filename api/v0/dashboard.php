<?php
/*
Path: api/v0/dashboard.php
API Endpoint para obtener datos del Dashboard
*/

// Activa la visualización de errores en el navegador
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Cabeceras CORS y tipo de contenido
header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET');
header('Access-Control-Allow-Headers: Content-Type, Authorization');

// Si es una solicitud OPTIONS (preflight), terminar aquí
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    exit(0);
}

// Verificar que sea una solicitud GET
if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
    http_response_code(405);
    echo json_encode([
        'status' => 'error',
        'message' => 'Método no permitido'
    ]);
    exit;
}

// Cargar el controlador de Clean Architecture y obtener los datos
require_once __DIR__ . '/../../interface_adapters/controller/DashboardControllerV0.php';
$controller = new DashboardController();
// Llamar al método que devuelve los datos como JSON
$controller->apiGetDashboardData();
