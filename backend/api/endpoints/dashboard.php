<?php
/*
Path: backend/api/endpoints/DashboardEndpoint.php
API endpoint que devuelve datos del dashboard en formato JSON.
*/

// Habilitar reporte de errores para debugging (temporal, solo en desarrollo)
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Updated require_once path to fix file not found error
require_once __DIR__ . '/../../config/error_config.php';
require_once __DIR__ . '/../../controllers/DashboardController.php';
// Added requires for API responses
require_once __DIR__ . '/../responses/ApiResponse.php';
require_once __DIR__ . '/../responses/ErrorResponse.php';

try {
    // Extraer parámetros y loguearlos para debugging
    $params = filter_input_array(INPUT_GET, [
        // Reemplazar FILTER_SANITIZE_STRING por FILTER_SANITIZE_SPECIAL_CHARS (alternativa recomendada)
        'periodo' => FILTER_SANITIZE_SPECIAL_CHARS,
        'conta'   => FILTER_SANITIZE_NUMBER_INT,
    ]);
    error_log("DashboardEndpoint input params: " . json_encode($params));

    // Validar que 'periodo' sea uno de los valores permitidos.
    $allowedPeriods = ['semana', 'turno', 'hora'];
    if (!in_array($params['periodo'] ?? 'semana', $allowedPeriods)) {
        $params['periodo'] = 'semana';
    }

    // Reinyectar parámetros saneados para que Navigation los use
    if (isset($params['periodo'])) {
        $_GET['periodo'] = $params['periodo'];
    }
    if (isset($params['conta'])) {
        $_GET['conta'] = $params['conta'];
    }

    // Instanciar el controlador y capturar datos (ahora forzamos respuesta API)
    $controller = new DashboardController();
    $data = $controller->index(true); // Forzamos respuesta JSON

    // Reordenar el array para que 'rawdata' esté al final
    if (is_array($data) && isset($data['rawdata'])) {
        $rawdata = $data['rawdata'];
        unset($data['rawdata']);
        // Agregar 'rawdata' al final
        $data['rawdata'] = $rawdata;
    }

    echo json_encode(\Backend\Api\Responses\ApiResponse::success($data));
    exit;
} catch (Exception $e) {
    error_log("DashboardEndpoint error: " . $e->getMessage());
    echo json_encode(\Backend\Api\Responses\ErrorResponse::error("Ocurrió un error. Consulte los logs.", 500));
    exit;
}
