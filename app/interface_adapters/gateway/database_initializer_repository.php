<?php
/*
Path: app/interface_adapters/gateway/database_initializer_repository.php
Repositorio para inicialización de base de datos y tablas.
*/

require_once __DIR__ . '/../../shared/app_config.php';

class DatabaseInitializerRepository
{
    private $conn;

    public function __construct()
    {
        // Conexión sin base de datos para crearla si no existe
        $this->conn = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD);
        if (!$this->conn) {
            throw new Exception("Conexión fallida: " . mysqli_connect_error());
        }
    }

    public function createDatabaseIfNotExists()
    {
        $sql = "CREATE DATABASE IF NOT EXISTS `" . DB_NAME . "` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci";
        if (!mysqli_query($this->conn, $sql)) {
            throw new Exception("Error creando base de datos: " . mysqli_error($this->conn));
        }
        // Selecciona la base de datos para siguientes operaciones
        if (!mysqli_select_db($this->conn, DB_NAME)) {
            throw new Exception("No se pudo seleccionar la base de datos: " . mysqli_error($this->conn));
        }
    }

    public function createTables()
    {
        // Crea la tabla intervalproduction con todas las columnas necesarias
        $sql = "CREATE TABLE IF NOT EXISTS `intervalproduction` (
            `ID` INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
            `unixtime` INT(11) NOT NULL,
            `HR_COUNTER1` INT(11) NOT NULL,
            `HR_COUNTER2` INT(11) NOT NULL,
            `datetime` DATETIME GENERATED ALWAYS AS (FROM_UNIXTIME(`unixtime`)) VIRTUAL,
            `production_rate` FLOAT DEFAULT NULL
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;";

        if (!mysqli_query($this->conn, $sql)) {
            throw new Exception("Error creando tabla intervalproduction: " . mysqli_error($this->conn));
        }

        // Puedes agregar aquí más sentencias para otras tablas necesarias
    }

    public function importSqlFile($filePath)
    {
        $sql = file_get_contents($filePath);
        if ($sql === false) {
            throw new Exception("No se pudo leer el archivo SQL: $filePath");
        }
        // Ejecuta múltiples sentencias
        if (!mysqli_multi_query($this->conn, $sql)) {
            throw new Exception("Error importando SQL: " . mysqli_error($this->conn));
        }
        // Limpia resultados pendientes
        do {
            if ($result = mysqli_store_result($this->conn)) {
                mysqli_free_result($result);
            }
        } while (mysqli_more_results($this->conn) && mysqli_next_result($this->conn));
    }

    public function close()
    {
        if ($this->conn) {
            mysqli_close($this->conn);
        }
    }
}
