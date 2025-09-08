<?php
/*
Path: app/use_cases/dashboard_repository_interface.php
*/

interface DashboardRepositoryInterface {
    public function getDashboardData($periodo, $conta = null);
    // Alias para v1.1, permite futura extensión
    public function getRealDashboardData($params = []);
}
