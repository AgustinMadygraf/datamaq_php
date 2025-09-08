<?php
/*
Path: app/interface_adapters/presenter/dashboard_presenter.php
Presentador unificado y configurable para el dashboard (v1, v1.1, ...)
*/

class DashboardPresenter {
    /**
     * Presenta los datos del dashboard según la versión solicitada.
     * @param mixed $data Datos del dashboard (puede ser objeto o array)
     * @param string $version Versión de formato ('v1', 'v1.1', ...)
     * @return string JSON formateado según la versión
     */
    /**
     * Presenta los datos del dashboard según la versión solicitada.
     * @param mixed $data Datos del dashboard (puede ser objeto o array)
     * @param string $version Versión de formato ('v0', 'v1', 'v1.1', ...)
     * @param string $status Estado de la respuesta (solo para v0)
     * @param string|null $message Mensaje opcional (solo para v0)
     * @return string JSON formateado según la versión
     */
    public function present($data, $version = 'v1', $status = 'success', $message = null) {
        switch ($version) {
            case 'v0':
                return $this->presentV0($data, $status, $message);
            case 'v1':
            case 'v1.1':
            default:
                return $this->presentV1($data);
        }
    }

    /**
     * Presenta un error según la versión
     */
    public function presentError($message, $version = 'v1', $code = 500) {
        http_response_code($code);
        if ($version === 'v0') {
            return $this->presentV0(null, 'error', $message);
        }
        // Para otras versiones, se puede personalizar el formato de error si es necesario
        return json_encode([
            'status' => 'error',
            'message' => $message
        ]);
    }
    private function presentV0($data, $status = 'success', $message = null) {
        $response = [
            'status' => $status,
            'data' => $data
        ];
        if ($message !== null) {
            $response['message'] = $message;
        }
        return json_encode($response, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    }

    private function presentV1($dashboard) {
        // Formato v1 (simulado)
        $response = [
            "meta" => [
                "title" => "Dashboard Test",
                "date" => isset($dashboard->unixtime) ? date('Y-m-d', $dashboard->unixtime) : null,
                "turno" => null
            ],
            "series" => isset($dashboard->rawdata) ? $dashboard->rawdata : [],
            "features" => [],
            "producto" => "Test Producto",
            "velocidad" => isset($dashboard->velUlt) ? $dashboard->velUlt : null,
            "formato" => "22 x 10 x30",
            "anchoBobina" => 690,
            "debug_params" => []
        ];
        return json_encode($response, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    }
}
