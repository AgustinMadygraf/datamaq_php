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
    public function present($data, $version = 'v1') {
        switch ($version) {
            case 'v1.1':
                return $this->presentV1_1($data);
            case 'v1':
            default:
                return $this->presentV1($data);
        }
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

    private function presentV1_1($data) {
        // Formato v1.1 (real, simple)
        return json_encode([
            'status' => 'success',
            'data' => $data
        ]);
    }
}
