<?php
// Controller para la versión v1 del dashboard
require_once __DIR__ . '/../../use_cases/GetDashboardData.php';
require_once __DIR__ . '/../presenter/DashboardPresenterV1.php';
require_once __DIR__ . '/../gateway/DashboardRepository.php';
require_once __DIR__ . '/../gateway/DashboardRepositoryInterface.php';

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
