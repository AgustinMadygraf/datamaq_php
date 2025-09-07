<?php
/*
Path: interface_adapters/gateway/dashboard_repository_interface.php
*/

interface DashboardRepositoryInterface {
    public function getDashboardData($periodo, $conta = null);
}
