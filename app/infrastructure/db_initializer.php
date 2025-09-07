<?php
/*
Path: infrastructure/db_initializer.php
Inicializa la base de datos y todas las tablas necesarias.
Permite importar datos desde un archivo SQL externo (Opción 1).
*/

require_once 'app_config.php';

class DatabaseInitializer
{
    private $mysqli;

    public function __construct()
    {
        $this->mysqli = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD);
        if ($this->mysqli->connect_errno) {
            die("Error de conexión: " . $this->mysqli->connect_error);
        }
    }

    public function initialize()
    {
        // Crear base de datos si no existe
        if (!$this->mysqli->query("CREATE DATABASE IF NOT EXISTS `" . DB_NAME . "`")) {
            die("Error creando base de datos: " . $this->mysqli->error);
        }
        $this->mysqli->select_db(DB_NAME);

        // Crear tablas principales
        $tables = [
            "CREATE TABLE IF NOT EXISTS registro_stock (
                id INT AUTO_INCREMENT PRIMARY KEY,
                producto VARCHAR(255) NOT NULL,
                cantidad INT NOT NULL,
                fecha DATETIME DEFAULT CURRENT_TIMESTAMP
            )",
            "CREATE TABLE IF NOT EXISTS produccion_bolsas_aux (
                ID INT AUTO_INCREMENT PRIMARY KEY,
                ancho_bobina DECIMAL(5,2) NOT NULL,
                ID_formato INT NOT NULL,
                Fecha DATETIME NOT NULL,
                KEY idx_ID_formato (ID_formato)
            )",
            "CREATE TABLE IF NOT EXISTS tabla_1 (
                ID_formato INT PRIMARY KEY,
                formato VARCHAR(14) NOT NULL,
                ancho INT NOT NULL,
                fuelle INT NOT NULL,
                alto INT NOT NULL,
                color VARCHAR(11) NOT NULL,
                gramaje INT NOT NULL,
                cantidades INT NOT NULL,
                manijas BIT(1) NOT NULL,
                fechatiempo TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
            )"
        ];

        foreach ($tables as $sql) {
            if (!$this->mysqli->query($sql)) {
                echo "Error creando tabla: " . $this->mysqli->error . "\n";
            }
        }

        // Tabla adicional: intervalproduction
        $sqlInterval = "CREATE TABLE IF NOT EXISTS intervalproduction (
            ID INT AUTO_INCREMENT PRIMARY KEY,
            unixtime INT,
            HR_COUNTER1 INT,
            HR_COUNTER2 INT,
            production_rate FLOAT DEFAULT NULL
        )";
        if (!$this->mysqli->query($sqlInterval)) {
            echo "Error creando tabla intervalproduction: " . $this->mysqli->error . "\n";
        }

        echo "Inicialización de tablas completada.\n";
    }

    public function importIntervalProductionData($sqlFilePath)
    {
        $sql = file_get_contents($sqlFilePath);
        if ($sql === false) {
            echo "No se pudo leer el archivo SQL: $sqlFilePath\n";
            return;
        }
        if (!$this->mysqli->multi_query($sql)) {
            echo "Error importando datos: " . $this->mysqli->error . "\n";
        } else {
            do {
                // Si hay un error en el resultado actual, mostrarlo y salir
                if ($result = $this->mysqli->store_result()) {
                    $result->free();
                }
                if ($this->mysqli->errno) {
                    echo "Error en multi_query: " . $this->mysqli->error . "\n";
                    break;
                }
            } while ($this->mysqli->more_results() && $this->mysqli->next_result());
            echo "Datos importados correctamente desde $sqlFilePath\n";
        }
    }

    public function close()
    {
        $this->mysqli->close();
    }
}

// Permite ejecutar el script desde CLI
if (php_sapi_name() === 'cli') {
    $initializer = new DatabaseInitializer();
    $initializer->initialize();
    // Importar datos después de crear las tablas
    $initializer->importIntervalProductionData(__DIR__ . '/../database/intervalproduction.sql');
    $initializer->close();
}