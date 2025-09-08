<?php
/*
Path: app/use_cases/interfaces/DashboardRepositoryInterface.php
*/

interface DashboardRepositoryInterface {
    public function getDashboardData($periodo, $conta = null);
    public function getRealDashboardData($params = []);
}
