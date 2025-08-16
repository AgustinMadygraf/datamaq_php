<?php
/*
Path: backend/helpers/SessionHelper.php
Clase para gestionar sesiones de forma segura
*/

class SessionHelper {
    /**
     * Inicia la sesión si no está ya iniciada
     * @return bool True si la sesión se inició correctamente
     */
    public static function start(): bool {
        if (session_status() === PHP_SESSION_NONE) {
            // Configurar cookies de sesión seguras
            session_set_cookie_params([
                'lifetime' => 3600,       // 1 hora
                'path' => '/',
                'domain' => '',           // Dominio actual
                'secure' => isset($_SERVER['HTTPS']), // Solo HTTPS si está disponible
                'httponly' => true,       // No accesible por JavaScript
                'samesite' => 'Lax'       // Protección cross-site
            ]);
            
            return session_start();
        }
        
        return true;
    }
    
    /**
     * Regenera el ID de sesión para prevenir fixation attacks
     * @return bool True si se regeneró el ID correctamente
     */
    public static function regenerateId(): bool {
        self::start();
        return session_regenerate_id(true);
    }
    
    /**
     * Guarda un valor en la sesión
     * @param string $key Clave del valor
     * @param mixed $value Valor a guardar
     */
    public static function set(string $key, $value): void {
        self::start();
        $_SESSION[$key] = $value;
    }
    
    /**
     * Obtiene un valor de la sesión
     * @param string $key Clave del valor
     * @param mixed $default Valor por defecto si no existe la clave
     * @return mixed El valor almacenado o el valor por defecto
     */
    public static function get(string $key, $default = null) {
        self::start();
        return $_SESSION[$key] ?? $default;
    }
    
    /**
     * Elimina un valor de la sesión
     * @param string $key Clave del valor a eliminar
     */
    public static function remove(string $key): void {
        self::start();
        if (isset($_SESSION[$key])) {
            unset($_SESSION[$key]);
        }
    }
    
    /**
     * Finaliza la sesión actual
     */
    public static function destroy(): void {
        if (session_status() === PHP_SESSION_ACTIVE) {
            session_unset();
            session_destroy();
            setcookie(session_name(), '', time() - 42000, '/');
        }
    }
}
