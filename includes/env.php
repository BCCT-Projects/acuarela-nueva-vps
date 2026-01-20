<?php
/**
 * Clase auxiliar para cargar variables de entorno (.env) sin dependencias externas
 * Ubicación: includes/env.php
 */

class Env
{
    private static $loaded = false;
    private static $vars = [];

    /**
     * Carga las variables desde el archivo .env
     * @param string|null $path Ruta al archivo .env (opcional)
     */
    public static function load($path = null)
    {
        if (self::$loaded)
            return;

        // Asumiendo que este archivo está en /includes/ y el .env en la raíz /
        if ($path === null) {
            $path = __DIR__ . '/../.env';
        }

        if (!file_exists($path)) {
            // Silencioso o log error
            return;
        }

        $lines = file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

        foreach ($lines as $line) {
            $line = trim($line);
            if (empty($line) || strpos($line, '#') === 0)
                continue;

            if (strpos($line, '=') !== false) {
                list($key, $value) = explode('=', $line, 2);
                $key = trim($key);
                $value = trim($value);

                // Remover comillas si existen
                $value = trim($value, '"\'');

                self::$vars[$key] = $value;

                // También poblar getenv() y $_ENV para compatibilidad
                putenv("$key=$value");
                $_ENV[$key] = $value;
            }
        }

        self::$loaded = true;
    }

    public static function get($key, $default = null)
    {
        if (isset(self::$vars[$key]))
            return self::$vars[$key];
        $val = getenv($key);
        if ($val !== false)
            return $val;
        if (isset($_ENV[$key]))
            return $_ENV[$key];
        return $default;
    }

    public static function all()
    {
        return self::$vars;
    }
}

// Auto-load al incluir
Env::load();
