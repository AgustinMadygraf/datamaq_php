<?php
/*
Path: app/interface_adapters/controller/dashboard_controller_v1_1.php
*/

require_once dirname(__DIR__, 1) . '/presenter/dashboard_presenter.php';
require_once dirname(__DIR__, 1) . '/gateway/dashboard_repository.php';
require_once dirname(__DIR__, 2) . '/use_cases/get_dashboard_data_v1_1.php';

class DashboardControllerV1_1 {
    public function handle($request) {
        $repository = new DashboardRepository();
        $useCase = new GetDashboardDataV1_1($repository);
    $presenter = new DashboardPresenter();
    $data = $useCase->execute($request);
    return $presenter->present($data, 'v1.1');
    }
}
