<?php
/*
Path: backend/core/Database.php
Este archivo contiene la clase Database, que se encarga de manejar la conexión a la base de datos.
*/

// Incluir las constantes definidas en conn.php
require_once __DIR__ . '/../config/conn.php';

class Database {
    private static $instance = null;
    private $connection;

    // Usar las constantes definidas en conn.php para los datos de conexión
    private $host = DB_SERVER;
    private $username = DB_USERNAME;
    private $password = DB_PASSWORD;
    private $dbname = DB_NAME;

    // Constructor privado para aplicar el patrón Singleton
    private function __construct() {
        $this->connection = new mysqli($this->host, $this->username, $this->password, $this->dbname);
        if ($this->connection->connect_error) {
            die("Conexión fallida: " . $this->connection->connect_error);
        }
    }

    // Retorna la instancia única de Database
    public static function getInstance() {
        if (!self::$instance) {
            self::$instance = new Database();
        }
        return self::$instance;
    }

    // Retorna la conexión activa
    public function getConnection() {
        return $this->connection;
    }
}
?>