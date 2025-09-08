<?php
/*
Path: app/use_cases/get_dashboard_data_v1_1.php
*/

require_once __DIR__ . '/../interface_adapters/gateway/dashboard_repository_interface.php';
require_once __DIR__ . '/../entities/dashboard.php';

class GetDashboardDataV1_1 {
    private $dashboardRepository;

    public function __construct(DashboardRepositoryInterface $dashboardRepository) {
        $this->dashboardRepository = $dashboardRepository;
    }

    public function execute($params = []) {
        try {
            $data = $this->dashboardRepository->getRealDashboardData($params);

            if (isset($data['error']) && $data['error']) {
                error_log('Error in GetDashboardDataV1_1: ' . $data['message']);
                return $data; // Retorna el error como ahora
            }

            // Mapear a entidad Dashboard
            return new Dashboard(
                $data['vel_ult'] ?? null,
                $data['unixtime'] ?? null,
                $data['rawdata'] ?? []
            );

        } catch (Exception $e) {
            error_log('Exception in GetDashboardDataV1_1: ' . $e->getMessage());
            return [
                'error' => true,
                'message' => 'Error processing dashboard data',
                'vel_ult' => 0,
                'unixtime' => time(),
                'rawdata' => [],
            ];
        }
    }
}
