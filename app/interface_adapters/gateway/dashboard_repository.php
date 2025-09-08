<?php
/*
Path: app/interface_adapters/gateway/dashboard_repository.php
*/

require_once __DIR__ . '/DatabaseConnectionInterface.php';
require_once __DIR__ . '/../../use_cases/dashboard_repository_interface.php';

class DashboardRepository implements DashboardRepositoryInterface {
    private $dbConnection;

    public function __construct(DatabaseConnectionInterface $dbConnection) {
        $this->dbConnection = $dbConnection;
    }

    public function getDashboardData($periodo, $conta = null) {
        $ls_periodos = ['semana' => 604800, 'turno' => 28800, 'hora' => 7200];
        if (!isset($ls_periodos[$periodo])) {
            throw new InvalidArgumentException('Periodo no válido');
        }
    $conn = $this->dbConnection->getConnection();
        $sqlLast = "SELECT `unixtime`, `HR_COUNTER1` FROM `intervalproduction` ORDER BY `unixtime` DESC LIMIT 1";
        $result = $conn->query($sqlLast);
        $res = [];
        if ($result && $result->num_rows > 0) {
            $res[] = $result->fetch_assoc();
        }
        $vel_ult = isset($res[0]['HR_COUNTER1']) ? $res[0]['HR_COUNTER1'] : 0;
        $unixtime = isset($res[0]['unixtime']) ? $res[0]['unixtime'] : time();
        $valorInicial = $unixtime * 1000;
        if ($conta !== null && $conta <= $valorInicial) {
            $conta = intval($conta);
        } else {
            $conta = $valorInicial;
        }
        $tiempo1 = ($conta / 1000) - $ls_periodos[$periodo] - 80 * 60;
        $tiempo2 = $conta / 1000;
        $sqlData = "SELECT `unixtime`, `HR_COUNTER1`, `HR_COUNTER2` FROM `intervalproduction`
                    WHERE unixtime > {$tiempo1} AND unixtime <= {$tiempo2} ORDER BY `unixtime` ASC";
        $resultData = $conn->query($sqlData);
        $rawdata = [];
        if ($resultData && $resultData->num_rows > 0) {
            while ($row = $resultData->fetch_assoc()) {
                $rawdata[] = $row;
            }
        }
        return [
            'vel_ult'   => $vel_ult,
            'unixtime'  => $unixtime,
            'rawdata'   => $rawdata,
        ];
    }

    // Implementación real para v1.1: ejemplo accediendo a tabla 'produccion'
    public function getRealDashboardData($params = []) {
        $fecha = isset($params['fecha']) ? $params['fecha'] : date('Y-m-d');
        $turno = isset($params['turno']) ? $params['turno'] : 'completo';
        $rawdata = [];
        
        try {
            $conn = $this->dbConnection->getConnection();
            
            // Datos del día actual
            $sqlCurrentDay = "SELECT * FROM produccion_bolsas_aux 
                              WHERE DATE(timestamp) = ? 
                              ORDER BY ID DESC";
            $stmtCurrentDay = $conn->prepare($sqlCurrentDay);
            $stmtCurrentDay->bind_param("s", $fecha);
            $stmtCurrentDay->execute();
            $resultCurrentDay = $stmtCurrentDay->get_result();
            
            $currentDayData = [];
            if ($resultCurrentDay && $resultCurrentDay->num_rows > 0) {
                while ($row = $resultCurrentDay->fetch_assoc()) {
                    $currentDayData[] = $row;
                }
            }
            
            // Datos del día anterior
            $previousDay = date('Y-m-d', strtotime($fecha . ' -1 day'));
            $sqlPreviousDay = "SELECT * FROM produccion_bolsas_aux 
                               WHERE DATE(timestamp) = ? 
                               ORDER BY ID DESC";
            $stmtPreviousDay = $conn->prepare($sqlPreviousDay);
            $stmtPreviousDay->bind_param("s", $previousDay);
            $stmtPreviousDay->execute();
            $resultPreviousDay = $stmtPreviousDay->get_result();
            
            $previousDayData = [];
            if ($resultPreviousDay && $resultPreviousDay->num_rows > 0) {
                while ($row = $resultPreviousDay->fetch_assoc()) {
                    $previousDayData[] = $row;
                }
            }
            
            // Promedio de la semana anterior
            $weekStartDate = date('Y-m-d', strtotime($fecha . ' -7 days'));
            $weekEndDate = date('Y-m-d', strtotime($fecha . ' -1 day'));
            $sqlWeekAvg = "SELECT AVG(velocidad) as avg_velocidad, 
                           AVG(bolsas) as avg_bolsas
                           FROM produccion_bolsas_aux 
                           WHERE DATE(timestamp) BETWEEN ? AND ?";
            $stmtWeekAvg = $conn->prepare($sqlWeekAvg);
            $stmtWeekAvg->bind_param("ss", $weekStartDate, $weekEndDate);
            $stmtWeekAvg->execute();
            $resultWeekAvg = $stmtWeekAvg->get_result();
            
            $weeklyAvgData = [];
            if ($resultWeekAvg && $resultWeekAvg->num_rows > 0) {
                $weeklyAvgData = $resultWeekAvg->fetch_assoc();
            }
            
            // Format the data to match v1 structure
            // Get the latest velocity if available
            $vel_ult = 0;
            if (!empty($currentDayData)) {
                $vel_ult = isset($currentDayData[0]['velocidad']) ? $currentDayData[0]['velocidad'] : 0;
            }
            
            // Current timestamp in Unix format
            $unixtime = time();
            
            // Combine all data for rawdata
            $rawdata = [
                'current_day' => $currentDayData,
                'previous_day' => $previousDayData,
                'weekly_avg' => $weeklyAvgData
            ];
            
            return [
                'vel_ult' => $vel_ult,
                'unixtime' => $unixtime,
                'rawdata' => $rawdata,
            ];
            
        } catch (Exception $e) {
            // Log the error
            error_log('Error in getRealDashboardData: ' . $e->getMessage());
            
            return [
                'error' => true,
                'message' => 'Error retrieving dashboard data',
                'vel_ult' => 0,
                'unixtime' => time(),
                'rawdata' => [],
            ];
        }
    }
}
