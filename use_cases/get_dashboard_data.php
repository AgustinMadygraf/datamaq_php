<?php
// Caso de uso para obtener los datos del dashboard (v1)
require_once __DIR__ . '/../entities/dashboard.php';

class GetDashboardData {
    protected $repository;

    public function __construct(DashboardRepositoryInterface $repository) {
        $this->repository = $repository;
    }

    public function execute($fecha, $turno) {
        // Aquí iría la lógica real de negocio, por ahora devolvemos datos simulados (como en v1)
        $min = 50; $max = 120;
        switch ($turno) {
            case 'central': $min = 60; $max = 90; break;
            case 'manana': $min = 70; $max = 100; break;
            case 'tarde': $min = 50; $max = 80; break;
            case 'dia': $min = 60; $max = 110; break;
        }
        $intervals = ($fecha === date('Y-m-d')) ? (getdate()['hours'] * 12 + intval(getdate()['minutes'] / 5)) : 288;
        if ($intervals > 288) $intervals = 288;
        $hoy_data = array_merge($this->random_series($min, $max, $intervals), array_fill(0, 288 - $intervals, null));
        $ayer_data = $this->random_series($min-10, $max-10, 288);
        $semana_anterior_data = $this->random_series($min-20, $max-20, 288);
        $series = [
            'hoy' => ['data' => $hoy_data],
            'ayer' => ['data' => $ayer_data],
            'semana_anterior' => ['data' => $semana_anterior_data]
        ];
        $dashboard = new Dashboard(100, strtotime($fecha), $series);
        return $dashboard;
    }

    private function random_series($min, $max, $count = 288) {
        $arr = [];
        for ($i = 0; $i < $count; $i++) {
            $arr[] = rand($min, $max);
        }
        return $arr;
    }
}
