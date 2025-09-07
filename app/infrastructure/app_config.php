<?php
/*
Path: app/infrastructure/app_config.php
*/

require_once __DIR__ . '/../../env.php';


// Database configuration
define('DB_SERVER', $_ENV['DB_SERVER']);
define('DB_USERNAME', $_ENV['DB_USERNAME']);
define('DB_PASSWORD', $_ENV['DB_PASSWORD']);
define('DB_NAME', $_ENV['DB_NAME']);

// Error reporting configuration
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('log_errors', 1);
ini_set('error_log', '/c:/AppServ/www/datamaq_php/php_error.log');

// Add logging configuration
// Make sure error logging is enabled
ini_set('log_errors', 1);
ini_set('error_log', __DIR__ . '/../../logs/app_errors.log');

// Create logs directory if it doesn't exist
if (!file_exists(__DIR__ . '/../../logs')) {
    mkdir(__DIR__ . '/../../logs', 0755, true);
}
