<?php
/*
Path: app/use_cases/get_dashboard_data_v0.php
Caso de uso específico para la obtención de datos del dashboard versión V0.
*/

require_once __DIR__ . '/../interface_adapters/gateway/dashboard_repository_interface.php';
require_once __DIR__ . '/../entities/dashboard.php';

class GetDashboardDataV0 {
    private $dashboardRepository;

    public function __construct(DashboardRepositoryInterface $dashboardRepository) {
        $this->dashboardRepository = $dashboardRepository;
    }

    public function execute($periodo = 'semana', $conta = null) {
        try {
            $data = $this->dashboardRepository->getDashboardData($periodo, $conta);
            // Mapear a entidad Dashboard
            return new Dashboard(
                $data['vel_ult'] ?? null,
                $data['unixtime'] ?? null,
                $data['rawdata'] ?? []
            );
        } catch (Exception $e) {
            throw new Exception("GetDashboardDataV0 error: " . $e->getMessage());
        }
    }
}
?>
