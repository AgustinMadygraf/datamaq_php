<?php
/*
Path: infrastructure/db_initializer.php
Inicializa la base de datos y todas las tablas necesarias.
*/

require_once 'app_config.php';

function initializeDatabase() {
    $mysqli = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD);
    if ($mysqli->connect_errno) {
        die("Error de conexión: " . $mysqli->connect_error);
    }

    // Crear base de datos si no existe
    if (!$mysqli->query("CREATE DATABASE IF NOT EXISTS `" . DB_NAME . "`")) {
        die("Error creando base de datos: " . $mysqli->error);
    }
    $mysqli->select_db(DB_NAME);

    // Crear tablas principales
    $tables = [
        "CREATE TABLE IF NOT EXISTS registro_stock (
            id INT AUTO_INCREMENT PRIMARY KEY,
            producto VARCHAR(255) NOT NULL,
            cantidad INT NOT NULL,
            fecha DATETIME DEFAULT CURRENT_TIMESTAMP
        )",
        "CREATE TABLE IF NOT EXISTS listado_precios (
            ID_listado INT AUTO_INCREMENT PRIMARY KEY,
            ID_formato INT,
            cantidad INT,
            precio_u_sIVA DECIMAL(8,2),
            fecha_listado DATE,
            KEY(ID_formato)
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
        )",
        "CREATE TABLE IF NOT EXISTS tabla_2 (
            ID_registro INT AUTO_INCREMENT PRIMARY KEY,
            ID_formato INT NOT NULL,
            papel VARCHAR(11) NOT NULL,
            fecha DATE NOT NULL,
            pedido INT NOT NULL,
            detalle VARCHAR(50) NOT NULL,
            origen INT NOT NULL,
            ingreso INT NOT NULL,
            egreso INT NOT NULL,
            saldo INT NOT NULL,
            destino_sobrante INT NOT NULL,
            sobrante INT NOT NULL,
            facturado INT NOT NULL,
            entregado INT NOT NULL,
            remito INT NOT NULL,
            sobreconsumo INT NOT NULL,
            lote INT NOT NULL
        )"
        // Agrega aquí más tablas según tus necesidades
    ];

    foreach ($tables as $sql) {
        if (!$mysqli->query($sql)) {
            echo "Error creando tabla: " . $mysqli->error . "\n";
        }
    }

    // Ejemplo: crear tabla intervalproduction (ajusta según tu SQL real)
    $sqlInterval = "CREATE TABLE IF NOT EXISTS intervalproduction (
        ID INT AUTO_INCREMENT PRIMARY KEY,
        production_rate FLOAT DEFAULT NULL
    )";
    if (!$mysqli->query($sqlInterval)) {
        echo "Error creando tabla intervalproduction: " . $mysqli->error . "\n";
    }

    $mysqli->close();
    echo "Inicialización completada.\n";
}

// Permite ejecutar el script desde CLI
if (php_sapi_name() === 'cli') {
    initializeDatabase();
}