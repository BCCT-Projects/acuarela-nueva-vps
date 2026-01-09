<?php
/**
 * Carga variables de entorno desde archivo .env
 * El archivo .env está en la raíz del proyecto, protegido por .htaccess
 * 
 * Uso:
 *   require_once 'env.php';
 *   $apiKey = Env::get('STRIPE_SECRET_KEY');
 */

class Env {
    private static $loaded = false;
    private static $vars = [];
    
    /**
     * Carga las variables desde el archivo .env
     * @param string|null $path Ruta al archivo .env (opcional)
     */
    public static function load($path = null) {
        if (self::$loaded) return;
        
        // Ruta por defecto: raíz del proyecto (un nivel arriba de includes/)
        if ($path === null) {
            $path = __DIR__ . '/../.env';
        }
        
        if (!file_exists($path)) {
            error_log("ENV: Archivo .env no encontrado en: $path");
            return;
        }
        
        $lines = file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        
        foreach ($lines as $line) {
            // Ignorar comentarios
            $line = trim($line);
            if (empty($line) || strpos($line, '#') === 0) continue;
            
            // Parsear KEY=VALUE
            if (strpos($line, '=') !== false) {
                list($key, $value) = explode('=', $line, 2);
                $key = trim($key);
                $value = trim($value);
                
                // Remover comillas si existen
                $value = trim($value, '"\'');
                
                self::$vars[$key] = $value;
                putenv("$key=$value");
                $_ENV[$key] = $value;
            }
        }
        
        self::$loaded = true;
    }
    
    /**
     * Obtiene el valor de una variable de entorno
     * @param string $key Nombre de la variable
     * @param mixed $default Valor por defecto si no existe
     * @return mixed
     */
    public static function get($key, $default = null) {
        // Primero buscar en nuestro cache
        if (isset(self::$vars[$key])) {
            return self::$vars[$key];
        }
        
        // Luego en getenv()
        $value = getenv($key);
        if ($value !== false) {
            return $value;
        }
        
        // Finalmente en $_ENV
        if (isset($_ENV[$key])) {
            return $_ENV[$key];
        }
        
        return $default;
    }
    
    /**
     * Verifica si una variable existe
     * @param string $key Nombre de la variable
     * @return bool
     */
    public static function has($key) {
        return isset(self::$vars[$key]) || getenv($key) !== false || isset($_ENV[$key]);
    }
    
    /**
     * Obtiene todas las variables cargadas
     * @return array
     */
    public static function all() {
        return self::$vars;
    }
}

// Cargar automáticamente al incluir este archivo
Env::load();

