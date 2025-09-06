<?php
require_once __DIR__ . '/DashboardRepositoryInterface.php';
require_once __DIR__ . '/../../backend/core/Database.php';

class DashboardModel implements DashboardRepositoryInterface {
    public function getDashboardData($periodo) {
        $ls_periodos = ['semana' => 604800, 'turno' => 28800, 'hora' => 7200];
        if (!isset($ls_periodos[$periodo])) {
            throw new InvalidArgumentException('Periodo no válido');
        }
        $db = Database::getInstance();
        $conn = $db->getConnection();
        $sqlLast = "SELECT `unixtime`, `HR_COUNTER1` FROM `intervalproduction` ORDER BY `unixtime` DESC LIMIT 1";
        $result = $conn->query($sqlLast);
        $last = $result ? $result->fetch_assoc() : null;
        // Aquí se puede continuar con la lógica de obtención de datos
        return $last;
    }
}
