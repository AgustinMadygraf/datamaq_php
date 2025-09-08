<?php
/*
Path: app/use_cases/get_dashboard_data_v1_1.php
*/

require_once __DIR__ . '/../entities/dashboard.php';

class GetDashboardDataV1_1 {
    protected $repository;

    public function __construct(DashboardRepositoryInterface $repository) {
        $this->repository = $repository;
    }

    public function execute($fecha = null, $turno = null) {
        // Asegurar que solo se devuelven datos desde las 00:00 del día actual
        if (!$fecha) {
            $fecha = date('Y-m-d'); // Fecha actual
        }
        
        // Calcular timestamp de las 00:00 del día especificado
        $timestampInicio = strtotime($fecha . ' 00:00:00');
        
        // Obtener datos del repositorio con el filtro aplicado
        $params = [
            'fecha' => $fecha,
            'turno' => $turno ?? 'completo',
            'desde_timestamp' => $timestampInicio
        ];
        
        $data = $this->repository->getRealDashboardData($params);

        // Convertir a objeto esperado por el presentador
        $dashboard = new \stdClass();
        $dashboard->velUlt = isset($data['vel_ult']) ? $data['vel_ult'] : null;
        $dashboard->unixtime = isset($data['unixtime']) ? $data['unixtime'] : null;
        $dashboard->rawdata = isset($data['rawdata']) ? $data['rawdata'] : [];
        return $dashboard;
    }
}
?>
