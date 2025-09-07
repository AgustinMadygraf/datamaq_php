<?php
/*
Path: use_cases/DashboardService.php
*/

require_once __DIR__ . '/../interface_adapters/gateway/dashboard_repository_interface.php';

class DashboardService {
    protected $repository;
    public function __construct(DashboardRepositoryInterface $repository) {
        $this->repository = $repository;
    }
    public function getDashboardData($periodo = 'semana', $conta = null) {
        try {
            return $this->repository->getDashboardData($periodo, $conta);
        } catch (Exception $e) {
            throw new Exception("DashboardService error: " . $e->getMessage());
        }
    }
}
?>
