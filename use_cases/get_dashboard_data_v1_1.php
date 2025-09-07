<?php
// Caso de uso para obtener datos reales del dashboard v1.1

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
