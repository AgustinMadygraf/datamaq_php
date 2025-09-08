<?php
/*
Path: app/tools/db_initializer.php
Inicializa la base de datos y todas las tablas necesarias usando el repositorio de inicialización.
Permite importar datos desde un archivo SQL externo.
*/


require_once __DIR__ . '/../interface_adapters/controller/initialize_database_cli_controller.php';

// Permite ejecutar el script desde CLI
if (php_sapi_name() === 'cli') {
    $sqlFile = __DIR__ . '/../../database/intervalproduction.sql';
    $controller = new InitializeDatabaseCliController();
    $controller->handle($sqlFile);
}