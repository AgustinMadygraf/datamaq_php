<?php
/*
Path: interface_adapters/controller/DashboardController.php
*/

require_once __DIR__ . '/../gateway/DashboardModel.php';
require_once __DIR__ . '/../gateway/FormatoModel.php';
require_once __DIR__ . '/DashboardService.php';

class DashboardController {
    protected $service;

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
        $dashboardModel = new DashboardModel();
        $this->service = new DashboardService($dashboardModel);
    }

    public function index($asApiResponse = false) {
        if (!$asApiResponse && isset($_SERVER['HTTP_ACCEPT']) && strpos($_SERVER['HTTP_ACCEPT'], 'application/json') !== false) {
            $asApiResponse = true;
        }
        try {
            // Obtener periodo directamente de $_GET
            $periodo = 'semana';
            if (isset($_GET['periodo']) && array_key_exists($_GET['periodo'], $this->ls_periodos)) {
                $periodo = $_GET['periodo'];
            }
            $dashboardData = $this->service->getDashboardData($periodo);
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

            // Obtener conta directamente de $_GET
            $valorInicial = $unixtime * 1000;
            $conta = $valorInicial;
            if (isset($_GET['conta']) && $_GET['conta'] <= $valorInicial) {
                $conta = intval($_GET['conta']);
            }

            $formatoModel = new FormatoModel();
            $formatoData  = $formatoModel->getUltimoFormato();

            $data = [
                'periodo'             => $periodo,
                'ls_periodos'         => $this->ls_periodos,
                'menos_periodo'       => $this->menos_periodo,
                'rawdata'             => $rawdata,
                'conta'               => $conta,
                'vel_ult_calculada'   => $vel_ult,
                'unixtime'            => $unixtime_arg,
                'formatoData'         => [
                    'formato' => $formatoData['formato'] ?? 'No disponible',
                    'ancho_bobina' => $formatoData['ancho_bobina'] ?? 'No disponible'
                ]
            ];

            if ($asApiResponse) {
                $class = $this->ls_class[$periodo];
                $ref_class = ['presione', 'presado'];
                $data['uiData'] = [
                    'class' => $class,
                    'refClass' => [
                        $ref_class[$class[0]],
                        $ref_class[$class[1]],
                        $ref_class[$class[2]]
                    ],
                    'preConta' => $conta - 1000 * $this->ls_periodos[$periodo],
                    'postConta' => $conta + 1000 * $this->ls_periodos[$periodo],
                ];
                header('Content-Type: application/json; charset=utf-8');
                echo json_encode(['status' => 'success', 'data' => $data], JSON_UNESCAPED_UNICODE);
                exit;
            }
            return $data;
        } catch (Exception $e) {
            error_log("DashboardController error: " . $e->getMessage());
            if ($asApiResponse) {
                header('Content-Type: application/json; charset=utf-8', true, 500);
                echo json_encode(['status' => 'error', 'message' => $e->getMessage()], JSON_UNESCAPED_UNICODE);
                exit;
            }
            throw $e;
        }
    }

    public function apiGetDashboardData() {
        $this->index(true);
    }
}