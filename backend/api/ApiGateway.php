<?php
/*
Path: backend/api/ApiGateway.php
*/

namespace Backend\Api;

require_once __DIR__ . '/../core/ViewRenderer.php';
require_once __DIR__ . '/responses/ApiResponse.php';
require_once __DIR__ . '/../middleware/ApiSecurityMiddleware.php';

use Backend\Api\Responses\ErrorResponse;

class ApiGateway {
    private const ALLOWED_METHODS = ['GET', 'POST', 'PUT', 'DELETE'];
    private const CONTENT_TYPE = 'Content-Type: application/json';
    
    /**
     * @var array Registra los endpoints disponibles y sus controladores
     */
    private $routes;

    public function __construct() {
        $this->routes = [
            'dashboard' => [
                'controller' => 'DashboardEndpoint',
                'methods' => ['GET']
            ],
            'test' => [
                'controller' => 'TestEndpoint',
                'methods' => ['GET']
            ]
        ];
    }

    /**
     * Procesa la solicitud entrante
     */
    public function handleRequest(): void {
        // Configurar headers
        header('Content-Type: application/json');
        header('Access-Control-Allow-Origin: *');
        
        // Apply API security checks using global namespace
        if (!\ApiSecurityMiddleware::apply()) {
            exit;
        }
        
        try {
            $method = $_SERVER['REQUEST_METHOD'];
            if (!in_array($method, self::ALLOWED_METHODS)) {
                throw new \Exception("Método HTTP no permitido", 405);
            }
            // Extraer endpoint utilizando el base path
            $endpoint = $this->getEndpointFromUrl();
            
            if (!isset($this->routes[$endpoint])) {
                throw new \Exception("Endpoint no encontrado", 404);
            }
            
            if (!in_array($method, $this->routes[$endpoint]['methods'])) {
                throw new \Exception("Método no permitido para este endpoint", 405);
            }
            
            $controllerClass = "Backend\\Api\\Endpoints\\" . $this->routes[$endpoint]['controller'];
            $controller = new $controllerClass();
            $response = $controller->handle($method);
            echo json_encode($response);
        } catch (\Exception $e) {
            $this->handleError($e);
        }
    }

    /**
     * Extrae el nombre del endpoint de la URL
     * @return string
     */
    // Updated to remove base path and return first segment post-base.
    private function getEndpointFromUrl(): string {
        $path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $basePath = '/DataMaq/backend/api';
        $trimmed = substr($path, strlen($basePath));
        $segments = explode('/', trim($trimmed, '/'));
        return $segments[0] ?? '';
    }

    /**
     * Maneja errores de forma consistente
     * @param \Exception $e
     */
    private function handleError(\Exception $e): void {
        $statusCode = $e->getCode() ?: 500;
        $errorResponse = ErrorResponse::error($e->getMessage(), $statusCode);
        echo json_encode($errorResponse);
    }
}

// Inicializar y ejecutar
$gateway = new ApiGateway();
$gateway->handleRequest();