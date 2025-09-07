<?php
/*
Path: app/infrastructure/database.php
Este archivo contiene la clase Database, que se encarga de manejar la conexión a la base de datos.
*/

// Incluir las constantes definidas en app_config.php
require_once __DIR__ . '/app_config.php';

class Database {
    private static $instances = [];
    private $connection;

    // Usar las constantes definidas en app_config.php para los datos de conexión
    private $host;
    private $username;
    private $password;
    private $dbname;

    // Constructor privado para aplicar el patrón Singleton por base de datos
    private function __construct($dbname = DB_NAME) {
        $this->host = DB_SERVER;
        $this->username = DB_USERNAME;
        $this->password = DB_PASSWORD;
        $this->dbname = $dbname;

            // Solo conectar a la base de datos, sin lógica de inicialización
            $this->connection = new mysqli($this->host, $this->username, $this->password, $this->dbname);

            if ($this->connection->connect_error) {
                throw new Exception('Error de conexión a la base de datos: ' . $this->connection->connect_error);
            }
    }

    // Retorna la instancia única de Database para una base de datos específica
    public static function getInstance($dbname = DB_NAME) {
        if (!isset(self::$instances[$dbname])) {
            self::$instances[$dbname] = new Database($dbname);
        }
        return self::$instances[$dbname];
    }

    // Retorna la conexión activa
    public function getConnection() {
        return $this->connection;
    }
}
?>