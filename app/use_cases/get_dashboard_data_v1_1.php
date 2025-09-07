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
        try {
            // Get data from repository
            $data = $this->dashboardRepository->getRealDashboardData($params);
            
            // Check for errors
            if (isset($data['error']) && $data['error']) {
                error_log('Error in GetDashboardDataV1_1: ' . $data['message']);
                return $data; // Return the error as is
            }
            
            // Process and transform data if needed
            // This is where you would add any additional business logic
            
            return $data;
            
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
