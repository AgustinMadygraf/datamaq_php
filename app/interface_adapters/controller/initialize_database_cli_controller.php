<?php
/*
Path: app/interface_adapters/controller/initialize_database_cli_controller.php
Controlador CLI para inicializar la base de datos usando el caso de uso InitializeDatabase.
*/


require_once __DIR__ . '/../../../env.php';
require_once __DIR__ . '/../gateway/database_initializer_repository.php';
require_once __DIR__ . '/../../use_cases/initialize_database.php';
require_once __DIR__ . '/../presenter/initialize_database_cli_presenter.php';


class InitializeDatabaseCliController
{
    private $presenter;

    public function __construct()
    {
        $this->presenter = new InitializeDatabaseCliPresenter();
    }

    public function handle($sqlFile = null)
    {
        try {
            $repository = new DatabaseInitializerRepository();
            $useCase = new InitializeDatabase($repository);
            $result = $useCase->execute($sqlFile);
            $this->presenter->present($result);
        } catch (Exception $e) {
            $this->presenter->presentException($e);
        } finally {
            if (isset($useCase) && method_exists($useCase, 'getRepository')) {
                $repo = $useCase->getRepository();
                if ($repo) {
                    $repo->close();
                }
            }
        }
    }
}

// CLI runner
if (php_sapi_name() === 'cli') {
    $sqlFile = __DIR__ . '/../../../database/intervalproduction.sql';
    $controller = new InitializeDatabaseCliController();
    $controller->handle($sqlFile);
}
