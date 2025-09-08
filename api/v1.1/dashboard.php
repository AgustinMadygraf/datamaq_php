<?php
/*
Path: api/v1.1/dashboard.php
Description: Endpoint v1.1 para el dashboard usando Clean Architecture
*/

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

// Mostrar errores (para desarrollo)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Leer parámetros GET


// Cargar el controlador de Clean Architecture
require_once __DIR__ . '/../../app/interface_adapters/controller/dashboard_controller_v1.php';
require_once __DIR__ . '/../../app/use_cases/get_dashboard_data_v1_1.php';

require_once __DIR__ . '/../../app/interface_adapters/gateway/dashboard_repository.php';
require_once __DIR__ . '/../../app/infrastructure/MySQLDatabaseConnection.php';

$repository = new DashboardRepository(new MySQLDatabaseConnection());
$useCase = new GetDashboardDataV1_1($repository);
$controller = new DashboardControllerV1($repository, $useCase);

$params = [
	'fecha' => isset($_GET['fecha']) ? $_GET['fecha'] : date('Y-m-d'),
	'turno' => isset($_GET['turno']) ? $_GET['turno'] : 'completo'
];
echo $controller->handle($params);
