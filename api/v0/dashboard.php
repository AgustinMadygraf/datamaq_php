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



require_once __DIR__ . '/../../app/infrastructure/MySQLDatabaseConnection.php';
require_once __DIR__ . '/../../app/interface_adapters/gateway/dashboard_repository.php';
require_once __DIR__ . '/../../app/use_cases/get_dashboard_data_v0.php';
require_once __DIR__ . '/../../app/interface_adapters/presenter/dashboard_presenter.php';

require_once __DIR__ . '/../../app/interface_adapters/controller/dashboard_controller_v0.php';

$dbConnection = new MySQLDatabaseConnection();
$dashboardRepository = new DashboardRepository($dbConnection);
$useCase = new GetDashboardDataV0($dashboardRepository);
$presenter = new DashboardPresenter();
$controller = new DashboardControllerV0($dashboardRepository, $useCase);

// Asegurando que la clase instanciada sea DashboardControllerV0

try {
    $periodo = isset($_GET['periodo']) ? $_GET['periodo'] : null;
    $conta = isset($_GET['conta']) ? $_GET['conta'] : null;
    $data = $controller->apiGetDashboardData($periodo, $conta);
    header('Content-Type: application/json; charset=utf-8');
    echo $presenter->present($data, 'v0');
} catch (Exception $e) {
    header('Content-Type: application/json; charset=utf-8', true, 500);
    echo $presenter->presentError($e->getMessage(), 'v0', 500);
}
