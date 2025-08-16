<?php
/*
Path: backend/controllers/DashboardController.php
Este archivo contiene la lógica de control para la vista del panel de control.
*/

require_once __DIR__ . '/../models/DashboardModel.php';
require_once __DIR__ . '/../services/DashboardService.php';
require_once __DIR__ . '/../models/FormatoModel.php';
require_once __DIR__ . '/../core/NavigationInterface.php';
require_once __DIR__ . '/../core/Navigation.php';
require_once __DIR__ . '/../helpers/GradientHelper.php';

class DashboardController {
    protected $service;
    protected $navigation;
    
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

    // Ahora inyectamos la dependencia de navegación.
    public function __construct(NavigationInterface $navigation = null) {
        $dashboardModel = new DashboardModel();
        $this->service = new DashboardService($dashboardModel);
        // Si no se provee una implementación, usamos la concreta por defecto.
        $this->navigation = $navigation ?: new Navigation();
    }

    /**
     * Método principal del controlador, puede devolver datos para la vista o como API
     * @param bool $asApiResponse Si es true, devuelve JSON
     * @return array|void
     */
    public function index($asApiResponse = false) {
        // Auto-detect API requests via Accept header.
        if (!$asApiResponse && isset($_SERVER['HTTP_ACCEPT']) && strpos($_SERVER['HTTP_ACCEPT'], 'application/json') !== false) {
            $asApiResponse = true;
        }
        try {
            // Obtiene el período y datos del dashboard
            $periodo = $this->navigation->getPeriod();
            $dashboardData = $this->service->getDashboardData($periodo);
            $vel_ult  = $dashboardData['vel_ult'];
            $unixtime = $dashboardData['unixtime'];
            $rawdata  = $dashboardData['rawdata'];

            // Procesar el parámetro "conta"
            $valorInicial = $unixtime * 1000;
            $conta        = $this->navigation->getConta($valorInicial);

            // Calcular el degradado usando el helper
            $d = GradientHelper::calculateGradient($this->pot);

            // Obtener la información de formato desde el modelo
            $formatoModel = new FormatoModel();
            $formatoData  = $formatoModel->getUltimoFormato();

            // Preparar los datos para la vista o API
            $data = [
                'periodo'             => $periodo,
                'ls_periodos'         => $this->ls_periodos,
                'menos_periodo'       => $this->menos_periodo,
                'rawdata'             => $rawdata,
                'conta'               => $conta,
                'vel_ult_calculada'   => $vel_ult,
                'unixtime'            => $unixtime,
                'gradient'            => $d,
                'formatoData'         => [
                    'formato' => $formatoData['formato'] ?? 'No disponible',
                    'ancho_bobina' => $formatoData['ancho_bobina'] ?? 'No disponible'
                ]
            ];

            // Para API, añadimos datos formatados específicamente para UI
            if ($asApiResponse) {
                // Calcula datos de la interfaz necesarios para JavaScript
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
                    'estiloFondo' => sprintf(
                        "background: linear-gradient(195deg, rgba(107,170,34,0.9) %d%%, rgba(255,164,1,0.9) %d%%, rgba(234,53,34,0.9) %d%%, rgba(100,10,5,0.9) %d%%);",
                        $d[3], $d[2], $d[1], $d[0]
                    )
                ];
                
                header('Content-Type: application/json; charset=utf-8');
                echo json_encode(['status' => 'success', 'data' => $data], JSON_UNESCAPED_UNICODE);
                exit;
            }

            // Para vista, devuelve el array de datos
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
    
    /**
     * Nuevo método que devuelve solo los datos necesarios para la API
     * @return void Envía respuesta JSON directamente
     */
    public function apiGetDashboardData() {
        $this->index(true);
    }
}