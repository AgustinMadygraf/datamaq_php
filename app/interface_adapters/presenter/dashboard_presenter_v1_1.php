<?php
/*
Path: app/interface_adapters/presenter/dashboard_presenter_v1_1.php
*/

class DashboardPresenterV1_1 {
    public function present($data) {
        header('Content-Type: application/json');
        return json_encode([
            'status' => 'success',
            'data' => $data
        ]);
    }
}
