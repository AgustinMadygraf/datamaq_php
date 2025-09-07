<?php
/*
Path: infrastructure/database.php
Este archivo contiene la clase Database, que se encarga de manejar la conexión a la base de datos.
*/

// Incluir las constantes definidas en conn.php
require_once __DIR__ . '/conn.php';

class Database {
    private static $instances = [];
    private $connection;

    // Usar las constantes definidas en conn.php para los datos de conexión
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

        // Intentar conectar a la base de datos
        $this->connection = new mysqli($this->host, $this->username, $this->password, $this->dbname);

        // Si la base de datos no existe, crearla y volver a conectar
        if ($this->connection->connect_errno === 1049) { // 1049 = Unknown database
            $tmpConn = new mysqli($this->host, $this->username, $this->password);
            if ($tmpConn->connect_error) {
                die("Conexión fallida: " . $tmpConn->connect_error);
            }
            $tmpConn->query("CREATE DATABASE IF NOT EXISTS `{$this->dbname}`");
            $tmpConn->close();
            // Intentar conectar de nuevo
            $this->connection = new mysqli($this->host, $this->username, $this->password, $this->dbname);
        }

        if ($this->connection->connect_error) {
            die("Conexión fallida: " . $this->connection->connect_error);
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

    public function ensureIntervalProductionTable() {
        $sql = "CREATE TABLE IF NOT EXISTS `intervalproduction` (
            `ID` int(11) NOT NULL,
            `unixtime` int(11) NOT NULL,
            `HR_COUNTER1` int(11) NOT NULL,
            `HR_COUNTER2` int(11) NOT NULL,
            `datetime` datetime GENERATED ALWAYS AS (from_unixtime(`unixtime`)) VIRTUAL
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;";
        $this->connection->query($sql);
    }
}
?>