<?php
/*
Path: backend/api/responses/ApiResponse.php
*/

namespace Backend\Api\Responses;

class ApiResponse {
    public static function success($data, int $code = 200): array {
        http_response_code($code);
        return [
            'status' => 'success',
            'data'   => $data
        ];
    }
}
