<?php
/*
Path: backend/core/ViewRenderer.php
*/

require_once __DIR__ . '/ComponentRenderer.php';

/*
 * Nota: El método render ahora se utiliza para cargar plantillas estáticas desde /frontend/templates,
 * permitiendo así desacoplar la lógica del backend del frontend.
 */

class ViewRenderer {
    private const TEMPLATES_DIR = __DIR__ . '/../../frontend/templates/';
    private static $cache = []; // Removed array type declaration

    /**
     * Renderiza una plantilla HTML reemplazando los marcadores
     * @param string $templatePath Ruta al archivo de plantilla
     * @param array $data Variables para inyectar en la plantilla
     * @param string $mode Modo de renderizado (web o api)
     * @return string HTML renderizado
     */
    public static function render($templatePath, array $data = [], string $mode = 'web'): string {
        error_log("DEBUG - Renderizando template: $templatePath en modo $mode");
        
        try {
            // Verificar que el archivo existe
            if (!file_exists($templatePath)) {
                throw new \Exception("Template no encontrado: $templatePath");
            }

            // Usar caché si está disponible
            $cacheKey = md5($templatePath);
            if (!isset(self::$cache[$cacheKey])) {
                self::$cache[$cacheKey] = file_get_contents($templatePath);
            }
            
            $content = self::$cache[$cacheKey];
            if ($content === false) {
                throw new \Exception("No se pudo leer el template: $templatePath");
            }

            error_log("DEBUG - Variables disponibles: " . implode(', ', array_keys($data)));
            
            // Procesar includes solo si no es ambiente API
            if ($mode !== 'api') {
                $content = preg_replace_callback(
                    '/@include\(\'([^\']+)\'\)/',
                    function($matches) use ($data) {
                        return ComponentRenderer::render($matches[1], $data);
                    },
                    $content
                );
            }
            

            // Reemplazar los marcadores {{variable}} con los valores
            foreach ($data as $key => $value) {
                // Si el valor es un array, lo convertimos a JSON para evitar el notice
                if (is_array($value)) {
                    $value = json_encode($value, JSON_UNESCAPED_UNICODE);
                }
                $content = str_replace('{{'.$key.'}}', $value, $content);
            }

            return $content;
        } catch (\Exception $e) {
            error_log("Error en ViewRenderer: " . $e->getMessage());
            return '';
        }
    }

    /**
     * Limpia la caché de templates
     */
    public static function clearCache(): void {
        self::$cache = [];
    }
}