<?php
/**
 * API Endpoint para obtener datos del Dashboard
 * Path: backend/api/dashboard.php
 */

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

// Cargar el controlador y obtener los datos
require_once __DIR__ . '/../controllers/DashboardController.php';
$controller = new DashboardController();

// Llamar al método que devuelve los datos como JSON
$controller->apiGetDashboardData();
