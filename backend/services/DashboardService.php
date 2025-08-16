<?php
/*
Path: backend/services/DashboardService.php
Este archivo contiene la lógica de negocio para la vista del panel de control.
La clase ahora recibe la dependencia de DashboardModel mediante inyección de dependencias,
lo que evita la instanciación directa y permite mayor flexibilidad y testabilidad.
*/

require_once __DIR__ . '/../models/DashboardModel.php';

class DashboardService {
    protected $model;
    
    // Inyectamos la dependencia de DashboardModel en el constructor
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
?>