<?php
/*
Path: app/use_cases/get_dashboard_data_v1_1.php
*/

require_once __DIR__ . '/../interface_adapters/gateway/dashboard_repository_interface.php';

class GetDashboardDataV1_1 {
    private $dashboardRepository;

    public function __construct(DashboardRepositoryInterface $dashboardRepository) {
        $this->dashboardRepository = $dashboardRepository;
    }

    public function execute($params = []) {
        // Lógica real: obtener datos desde el repositorio
        return $this->dashboardRepository->getRealDashboardData($params);
    }
}
