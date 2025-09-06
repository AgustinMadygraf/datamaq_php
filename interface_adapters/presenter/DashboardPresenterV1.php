<?php
// Presentador para la versión v1 del dashboard
class DashboardPresenterV1 {
    public function present($dashboard) {
        $response = [
            "meta" => [
                "title" => "Dashboard Test",
                "date" => date('Y-m-d', $dashboard->unixtime),
                "turno" => null // El turno puede ser agregado si se requiere
            ],
            "series" => $dashboard->rawdata,
            "features" => [],
            "producto" => "Test Producto",
            "velocidad" => $dashboard->velUlt,
            "formato" => "22 x 10 x30",
            "anchoBobina" => 690,
            "debug_params" => []
        ];
        return json_encode($response, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    }
}
