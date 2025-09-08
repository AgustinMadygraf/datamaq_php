<?php
/*
Path: app/interface_adapters/controller/dashboard_controller_v1.php
*/

require_once __DIR__ . '/../../use_cases/get_dashboard_data_v1.php';
require_once __DIR__ . '/../presenter/dashboard_presenter.php';
require_once __DIR__ . '/../gateway/dashboard_repository.php';
require_once __DIR__ . '/../gateway/dashboard_repository_interface.php';

class DashboardControllerV1 {
    protected $repository;
    protected $useCase;
    protected $presenter;

    public function __construct(
        $repository = null,
        $useCase = null,
        $presenter = null
    ) {
        $this->repository = $repository ?: new DashboardRepository();
        $this->useCase = $useCase ?: new GetDashboardData($this->repository);
        $this->presenter = $presenter ?: new DashboardPresenter();
    }

    // Unifica la interfaz con otros controladores
    public function handle($request) {
        try {
            $fecha = $request['fecha'] ?? date('Y-m-d');
            $turno = $request['turno'] ?? 'completo';
            $dashboard = $this->useCase->execute($fecha, $turno);
            return $this->presenter->present($dashboard, 'v1');
        } catch (\Exception $e) {
            return $this->presenter->presentError($e->getMessage(), 'v1', 500);
        }
    }
}
