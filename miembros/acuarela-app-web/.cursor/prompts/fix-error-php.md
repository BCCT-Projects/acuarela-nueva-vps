# Debuggear Error PHP

## Pasos para encontrar el error:

1. **Ver el log:**
   ```bash
   tail -50 error_log
   ```

2. **Habilitar errores temporalmente:**
   ```php
   ini_set('display_errors', 1);
   error_reporting(E_ALL);
   ```

3. **Verificar includes:**
   - ¿Existe el archivo?
   - ¿Ruta correcta? (../ vs ./)
   - ¿config.php carga antes que sdk.php?

4. **Verificar sesión:**
   ```php
   var_dump($_SESSION);
   exit;
   ```

5. **Verificar respuesta JSON:**
   ```php
   header('Content-Type: application/json');
   // Antes de cualquier echo/print
   ```

## Errores comunes:
- **500**: Error de sintaxis o include faltante
- **404**: Ruta incorrecta
- **403**: Permisos de archivo
- **Headers already sent**: Echo antes de header()

