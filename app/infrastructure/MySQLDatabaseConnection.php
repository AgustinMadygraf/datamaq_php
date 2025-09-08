<?php
// Path: app/infrastructure/MySQLDatabaseConnection.php
require_once __DIR__ . '/../interface_adapters/gateway/DatabaseConnectionInterface.php';
require_once __DIR__ . '/database.php';

class MySQLDatabaseConnection implements DatabaseConnectionInterface {
    private $database;

    public function __construct($dbname = DB_NAME) {
        $this->database = Database::getInstance($dbname);
    }

    public function getConnection() {
        return $this->database->getConnection();
    }
}
