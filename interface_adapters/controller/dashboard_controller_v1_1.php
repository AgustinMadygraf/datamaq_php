<?php
// Controlador para dashboard v1.1

require_once __DIR__ . '/../../presenter/dashboard_presenter_v1_1.php';
require_once __DIR__ . '/../../gateway/dashboard_repository.php';
require_once __DIR__ . '/../../../use_cases/get_dashboard_data_v1_1.php';

class DashboardControllerV1_1 {
    public function handle($request) {
        $repository = new DashboardRepository();
        $useCase = new GetDashboardDataV1_1($repository);
        $presenter = new DashboardPresenterV1_1();
        $data = $useCase->execute($request);
        return $presenter->present($data);
    }
}
