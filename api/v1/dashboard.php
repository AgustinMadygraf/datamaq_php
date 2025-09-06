<?php
/*
Path: api/v1/dashboard.php
Description: Endpoint v1 para el dashboard usando Clean Architecture
*/

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

// Mostrar errores (para desarrollo)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Leer parámetros GET
$fecha = isset($_GET['fecha']) ? $_GET['fecha'] : date('Y-m-d');
$turno = isset($_GET['turno']) ? $_GET['turno'] : 'completo';

// Cargar el controlador de Clean Architecture
require_once __DIR__ . '/../../interface_adapters/controller/DashboardControllerV1.php';

$controller = new DashboardControllerV1();
echo $controller->getDashboardData($fecha, $turno);
