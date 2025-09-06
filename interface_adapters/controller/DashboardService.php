<?php
// Servicio migrado desde backend/services/DashboardService.php
require_once __DIR__ . '/../gateway/DashboardModel.php';

class DashboardService {
    protected $model;
    public function __construct(DashboardModel $model) {
        $this->model = $model;
    }
    public function getDashboardData($periodo = 'semana') {
        try {
            return $this->model->getDashboardData($periodo);
        } catch (Exception $e) {
            throw new Exception("DashboardService error: " . $e->getMessage());
        }
    }
}