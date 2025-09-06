<?php
// Controller para la versión v1 del dashboard
require_once __DIR__ . '/../../use_cases/GetDashboardData.php';
require_once __DIR__ . '/../presenter/DashboardPresenterV1.php';

class DashboardControllerV1 {
    public function getDashboardData($fecha, $turno) {
        $useCase = new GetDashboardData();
        $dashboard = $useCase->execute($fecha, $turno);
        $presenter = new DashboardPresenterV1();
        return $presenter->present($dashboard);
    }
}
