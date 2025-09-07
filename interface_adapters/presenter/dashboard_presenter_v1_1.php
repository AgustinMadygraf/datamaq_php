<?php
// Presentador para dashboard v1.1

class DashboardPresenterV1_1 {
    public function present($data) {
        header('Content-Type: application/json');
        return json_encode([
            'status' => 'success',
            'data' => $data
        ]);
    }
}
