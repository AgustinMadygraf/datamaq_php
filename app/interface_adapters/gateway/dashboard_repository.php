<?php
/*
Path: app/interface_adapters/gateway/dashboard_repository.php
*/

require_once __DIR__ . '/../../use_cases/interfaces/DatabaseConnectionInterface.php';
require_once __DIR__ . '/../../use_cases/interfaces/DashboardRepositoryInterface.php';

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
        $desdeTimestamp = isset($params['desde_timestamp']) ? $params['desde_timestamp'] : strtotime($fecha . ' 00:00:00');
        $conn = $this->dbConnection->getConnection();

        // Corrige aquí el nombre de la columna
        $sql = "SELECT unixtime, HR_COUNTER1 FROM intervalproduction WHERE unixtime >= {$desdeTimestamp} ORDER BY unixtime ASC";
        $result = $conn->query($sql);

        $hoy = [];
        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $hoy[] = intval($row['HR_COUNTER1']);
            }
        }
        error_log('Hoy: ' . json_encode($hoy));

        return [
            'vel_ult' => end($hoy),
            'unixtime' => count($hoy) ? $result->fetch_assoc()['unixtime'] : null,
            'rawdata' => [
                'hoy' => ['data' => $hoy],
                'ayer' => ['data' => []],
                'semana_anterior' => ['data' => []]
            ]
        ];
    }
}
