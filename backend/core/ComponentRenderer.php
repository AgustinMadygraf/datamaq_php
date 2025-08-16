<?php
/*
Path: backend/core/ComponentRenderer.php
*/

class ComponentRenderer {
    private const COMPONENTS_DIR = __DIR__ . '/../../frontend/templates/components/';
    private static $cache = []; // Removed array type declaration

    /**
     * Renderiza un componente con sus datos
     * @param string $componentName Nombre del componente (sin extensión)
     * @param array $props Propiedades para el componente
     * @param string $mode Modo de renderizado (predeterminado "web")
     * @return string HTML renderizado
     */
    public static function render(string $componentName, array $props = [], string $mode = 'web'): string {
        $componentPath = self::COMPONENTS_DIR . $componentName . '.html';
        
        try {
            // Usar caché si está disponible
            if (!isset(self::$cache[$componentName])) {
                if (!file_exists($componentPath)) {
                    throw new \Exception("Componente no encontrado: $componentName");
                }
                self::$cache[$componentName] = file_get_contents($componentPath);
            }
            
            $content = self::$cache[$componentName];
            
            // Reemplazar props
            foreach ($props as $key => $value) {
                // En entorno web se escapan los valores; en API se inyecta tal cual.
                $replacement = $mode === 'api' ? $value : htmlspecialchars((string)$value);
                $content = str_replace('{{'.$key.'}}', $replacement, $content);
            }
            
            // Limpiar props no utilizados
            $content = preg_replace('/\{\{[^}]+\}\}/', '', $content);
            
            return $content;
        } catch (\Exception $e) {
            error_log("Error en ComponentRenderer: " . $e->getMessage());
            return '';
        }
    }

    /**
     * Limpia la caché de componentes
     */
    public static function clearCache(): void {
        self::$cache = [];
    }
}