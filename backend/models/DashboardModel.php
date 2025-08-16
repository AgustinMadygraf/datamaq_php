<?php
/*
Path: backend/models/DashboardModel.php
Este archivo contiene la lógica de acceso a la base de datos para la vista del panel de control.
Utiliza la clase Database implementada en /backend/core/Database.php para gestionar la conexión.
*/

require_once __DIR__ . '/../core/Database.php';

class DashboardModel {
    public function getDashboardData($periodo) {
        $ls_periodos = ['semana' => 604800, 'turno' => 28800, 'hora' => 7200];
        if (!isset($ls_periodos[$periodo])) {
            $periodo = 'semana';
        }
        
        $db = Database::getInstance();
        $conn = $db->getConnection();
        
        // Obtener el último valor registrado
        $sqlLast = "SELECT `unixtime`, `HR_COUNTER1` FROM `intervalproduction` ORDER BY `unixtime` DESC LIMIT 1";
        $result = $conn->query($sqlLast);
        $res = [];
        if ($result && $result->num_rows > 0) {
            $res[] = $result->fetch_assoc();
        }
        $vel_ult = isset($res[0]['HR_COUNTER1']) ? $res[0]['HR_COUNTER1'] : 0;
        $unixtime = isset($res[0]['unixtime']) ? $res[0]['unixtime'] : time();

        // Procesar el parámetro "conta"
        $valorInicial = $unixtime * 1000;
        $conta = $valorInicial;
        if (isset($_GET["conta"]) && $_GET["conta"] <= $valorInicial) {
            $conta = $_GET["conta"];
        }
        
        $tiempo1 = ($conta / 1000) - $ls_periodos[$periodo] - 80 * 60;
        $tiempo2 = $conta / 1000;
        
        // Obtener los datos en el período especificado
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
?>