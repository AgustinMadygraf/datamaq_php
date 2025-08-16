<?php
/*
Path: backend/config/error_config.php
*/

// Removed individual error settings; now centralized in app_config.php.
require_once __DIR__ . '/app_config.php';

// Definir constante para la ruta base
define('BASE_URL', '/DataMaq');
define('ASSETS_URL', BASE_URL . '/frontend');

// Configuración de errores
error_reporting(E_ALL);
ini_set('display_errors', 1);
?>
