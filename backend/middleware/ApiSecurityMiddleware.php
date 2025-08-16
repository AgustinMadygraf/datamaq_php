<?php
/*
Path: backend/middleware/ApiSecurityMiddleware.php
Middleware para seguridad de APIs
*/

require_once __DIR__ . '/../helpers/CsrfHelper.php';
require_once __DIR__ . '/../helpers/SessionHelper.php';

class ApiSecurityMiddleware {
    /**
     * Aplica todas las verificaciones de seguridad para peticiones API
     * @return bool True si todas las comprobaciones pasan, false en caso contrario
     */
    public static function apply(): bool {
        // Verificar que el origen de la petición es válido
        if (!self::validateOrigin()) {
            return false;
        }

        // Verificar CSRF para métodos que pueden modificar datos
        if (in_array($_SERVER['REQUEST_METHOD'], ['POST', 'PUT', 'DELETE', 'PATCH'])) {
            if (!self::validateCsrfForApi()) {
                return false;
            }
        }

        // Verificar límites de ratio de peticiones
        if (!self::checkRateLimit()) {
            return false;
        }

        return true;
    }

    /**
     * Valida que el origen de la petición sea el esperado
     * @return bool
     */
    private static function validateOrigin(): bool {
        $headers = getallheaders();
        $origin = $headers['Origin'] ?? $headers['origin'] ?? '';
        
        // Lista blanca de dominios permitidos (actualizar según necesidades)
        $allowedOrigins = [
            'http://localhost',
            'http://127.0.0.1',
            'http://datamaq-server'
            // Añadir dominios permitidos
        ];
        
        // Si no hay Origin (petición desde el mismo dominio) o está en la lista blanca
        if (empty($origin) || in_array($origin, $allowedOrigins)) {
            return true;
        }
        
        self::sendErrorResponse(403, 'Origen no autorizado');
        return false;
    }

    /**
     * Valida el token CSRF para peticiones API
     * @return bool
     */
    private static function validateCsrfForApi(): bool {
        // Obtener el token CSRF del header o de los datos POST
        $token = $_SERVER['HTTP_X_CSRF_TOKEN'] ?? $_POST['csrf_token'] ?? null;
        
        if (!CsrfHelper::validateToken($token)) {
            self::sendErrorResponse(403, 'Token CSRF inválido o faltante');
            return false;
        }
        
        return true;
    }

    /**
     * Comprueba límites de frecuencia de peticiones
     * @return bool
     */
    private static function checkRateLimit(): bool {
        SessionHelper::start();
        
        $currentTime = time();
        $windowSize = 60; // 1 minuto
        $maxRequests = 60; // 60 peticiones por minuto
        
        $requestLog = $_SESSION['api_request_log'] ?? [];
        
        // Eliminar peticiones antiguas fuera de la ventana de tiempo
        $requestLog = array_filter($requestLog, function($timestamp) use ($currentTime, $windowSize) {
            return $timestamp >= ($currentTime - $windowSize);
        });
        
        // Verificar si se supera el límite
        if (count($requestLog) >= $maxRequests) {
            self::sendErrorResponse(429, 'Demasiadas peticiones. Por favor, espere antes de realizar más solicitudes.');
            return false;
        }
        
        // Registrar esta petición
        $requestLog[] = $currentTime;
        $_SESSION['api_request_log'] = $requestLog;
        
        return true;
    }

    /**
     * Envía una respuesta de error al cliente
     * @param int $code Código HTTP
     * @param string $message Mensaje de error
     */
    private static function sendErrorResponse(int $code, string $message): void {
        http_response_code($code);
        header('Content-Type: application/json');
        echo json_encode(['status' => 'error', 'message' => $message]);
        exit;
    }
}
