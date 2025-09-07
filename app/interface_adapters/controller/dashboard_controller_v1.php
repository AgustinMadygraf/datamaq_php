<?php
/*
Path: app/interface_adapters/controller/dashboard_controller_v1.php
*/

require_once __DIR__ . '/../../use_cases/get_dashboard_data.php';
require_once __DIR__ . '/../presenter/dashboard_presenter_v1.php';
require_once __DIR__ . '/../gateway/dashboard_repository.php';
require_once __DIR__ . '/../gateway/dashboard_repository_interface.php';

class DashboardControllerV1 {
    protected $repository;

    public function __construct() {
        $this->repository = new DashboardRepository();
    }

    public function getDashboardData($fecha, $turno) {
        $useCase = new GetDashboardData($this->repository);
        $dashboard = $useCase->execute($fecha, $turno);
        $presenter = new DashboardPresenterV1();
        return $presenter->present($dashboard);
    }
}
