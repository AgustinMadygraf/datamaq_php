<?php
/*
Path: interface_adapters/gateway/DashboardRepository.php
*/

require_once __DIR__ . '/DashboardRepositoryInterface.php';
require_once __DIR__ . '/../../infrastructure/Database.php';

class DashboardRepository implements DashboardRepositoryInterface {
    public function getDashboardData($periodo, $conta = null) {
        $ls_periodos = ['semana' => 604800, 'turno' => 28800, 'hora' => 7200];
        if (!isset($ls_periodos[$periodo])) {
            throw new InvalidArgumentException('Periodo no válido');
        }
        $db = Database::getInstance();
        $conn = $db->getConnection();
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
}
