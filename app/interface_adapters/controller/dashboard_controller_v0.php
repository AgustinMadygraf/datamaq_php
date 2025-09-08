<?php
/*
Path: app/interface_adapters/controller/DashboardControllerV0.php
*/

require_once __DIR__ . '/../gateway/dashboard_repository.php';
require_once __DIR__ . '/../../use_cases/get_dashboard_data_v0.php';
require_once __DIR__ . '/../gateway/formato_repository.php';
require_once __DIR__ . '/../../use_cases/get_ultimo_formato.php';

class DashboardController {
    protected $useCase;

    protected $ls_periodos = [
        'semana' => 604800,
        'turno'  => 28800,
        'hora'   => 7200
    ];
    protected $ls_class = [
        'semana' => [1, 0, 0],
        'turno'  => [0, 1, 0],
        'hora'   => [0, 0, 1]
    ];
    protected $menos_periodo = [
        'semana' => 'turno',
        'turno'  => 'hora',
        'hora'   => 'hora'
    ];
    protected $pot = 0;

    public function __construct() {
        $dashboardRepository = new DashboardRepository();
        $this->useCase = new GetDashboardDataV0($dashboardRepository);
    }

    public function index($periodo = null, $conta = null) {
        try {
            // Obtener periodo desde argumento o default
            $periodo = ($periodo && array_key_exists($periodo, $this->ls_periodos)) ? $periodo : 'semana';
            $dashboardData = $this->useCase->execute($periodo, $conta);
            $vel_ult  = $dashboardData['vel_ult'] ?? null;
            $unixtime = $dashboardData['unixtime'] ?? time();
            $rawdata  = $dashboardData['rawdata'] ?? [];

            $unixtime_arg = $unixtime - 10800;
            foreach ($rawdata as &$row) {
                if (isset($row['unixtime'])) {
                    $row['unixtime'] = $row['unixtime'] - 10800;
                }
            }
            unset($row);

            // Obtener conta desde argumento o default
            $valorInicial = $unixtime * 1000;
            if ($conta !== null && $conta <= $valorInicial) {
                $conta = intval($conta);
            } else {
                $conta = $valorInicial;
            }

            $formatoRepository = new FormatoRepository();
            $getUltimoFormato = new GetUltimoFormato($formatoRepository);
            $formatoData = $getUltimoFormato->execute();

            $class = $this->ls_class[$periodo];
            $ref_class = ['presione', 'presado'];

            $data = [
                'periodo'             => $periodo,
                'ls_periodos'         => $this->ls_periodos,
                'menos_periodo'       => $this->menos_periodo,
                'rawdata'             => $rawdata,
                'conta'               => $conta,
                'vel_ult_calculada'   => $vel_ult,
                'unixtime'            => $unixtime_arg,
                'formatoData'         => [
                    'formato' => $formatoData->nombre ?? 'No disponible',
                    'ancho_bobina' => $formatoData->datos['ancho_bobina'] ?? 'No disponible'
                ],
                'uiData' => [
                    'class' => $class,
                    'refClass' => [
                        $ref_class[$class[0]],
                        $ref_class[$class[1]],
                        $ref_class[$class[2]]
                    ],
                    'preConta' => $conta - 1000 * $this->ls_periodos[$periodo],
                    'postConta' => $conta + 1000 * $this->ls_periodos[$periodo],
                ]
            ];
            return $data;
        } catch (Exception $e) {
            error_log("DashboardController error: " . $e->getMessage());
            throw $e;
        }
    }

    public function apiGetDashboardData($periodo = null, $conta = null) {
        // Devuelve los datos crudos para el presentador
        return $this->index($periodo, $conta);
    }
}