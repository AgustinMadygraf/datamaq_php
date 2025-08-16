<?php
/*
Path: backend/api/responses/ErrorResponse.php
*/

namespace Backend\Api\Responses;

class ErrorResponse {
    public static function error(string $message, int $code = 500): array {
        http_response_code($code);
        return [
            'status'  => 'error',
            'message' => $message,
            'code'    => $code
        ];
    }
}
