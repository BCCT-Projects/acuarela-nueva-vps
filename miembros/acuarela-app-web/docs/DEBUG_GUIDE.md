# 🐛 Guía de Debugging con Logs en PHP

Esta guía explica cómo implementar debugging efectivo en archivos PHP usando `file_put_contents()`.

## ¿Por qué usar esta técnica?

- `error_log()` a veces escribe en ubicaciones impredecibles
- Con `file_put_contents()` controlamos exactamente dónde van los logs
- Fácil de leer con comandos de terminal
- Incluye timestamps para rastrear el orden de ejecución

---

## 📝 Sintaxis básica

```php
file_put_contents('/ruta/absoluta/debug.log', date('Y-m-d H:i:s') . " - Tu mensaje\n", FILE_APPEND);
```

### Componentes:

| Parte | Descripción |
|-------|-------------|
| `/ruta/absoluta/debug.log` | Ruta completa al archivo de log |
| `date('Y-m-d H:i:s')` | Timestamp del momento |
| `" - Tu mensaje\n"` | Mensaje + salto de línea |
| `FILE_APPEND` | Agrega al final sin sobrescribir |

---

## 🔧 Ejemplos de uso

### 1. Marcar inicio de script
```php
file_put_contents('/home/oldmacdonald/public_html/dev2/debug.log', 
    date('Y-m-d H:i:s') . " - INICIO SCRIPT\n", FILE_APPEND);
```

### 2. Registrar variables
```php
$email = $_POST['email'] ?? '';
$nombre = $_POST['nombre'] ?? '';

file_put_contents('/home/oldmacdonald/public_html/dev2/debug.log', 
    date('Y-m-d H:i:s') . " - Email: $email, Nombre: $nombre\n", FILE_APPEND);
```

### 3. Registrar objetos/arrays (usar json_encode)
```php
$resultado = $api->crearUsuario($data);

file_put_contents('/home/oldmacdonald/public_html/dev2/debug.log', 
    date('Y-m-d H:i:s') . " - Resultado API: " . json_encode($resultado) . "\n", FILE_APPEND);
```

### 4. Registrar errores en try-catch
```php
try {
    $resultado = $servicio->ejecutar();
} catch (Exception $e) {
    file_put_contents('/home/oldmacdonald/public_html/dev2/debug.log', 
        date('Y-m-d H:i:s') . " - ERROR: " . $e->getMessage() . "\n", FILE_APPEND);
}
```

### 5. Ejemplo completo de flujo
```php
<?php
session_start();

// LOG: Inicio
file_put_contents('/home/oldmacdonald/public_html/dev2/debug.log', 
    date('Y-m-d H:i:s') . " - === INICIO PROCESO ===\n", FILE_APPEND);

include "includes/sdk.php";
$a = new Acuarela();

// LOG: SDK cargado
file_put_contents('/home/oldmacdonald/public_html/dev2/debug.log', 
    date('Y-m-d H:i:s') . " - SDK cargado correctamente\n", FILE_APPEND);

$email = $_POST['email'] ?? '';

// LOG: Datos recibidos
file_put_contents('/home/oldmacdonald/public_html/dev2/debug.log', 
    date('Y-m-d H:i:s') . " - Email recibido: $email\n", FILE_APPEND);

$resultado = $a->crearAsistente($data);

// LOG: Respuesta del API
file_put_contents('/home/oldmacdonald/public_html/dev2/debug.log', 
    date('Y-m-d H:i:s') . " - Respuesta: " . json_encode($resultado) . "\n", FILE_APPEND);

// LOG: Verificar estructura
if (isset($resultado->entity->_id)) {
    file_put_contents('/home/oldmacdonald/public_html/dev2/debug.log', 
        date('Y-m-d H:i:s') . " - ID creado: " . $resultado->entity->_id . "\n", FILE_APPEND);
} else {
    file_put_contents('/home/oldmacdonald/public_html/dev2/debug.log', 
        date('Y-m-d H:i:s') . " - ERROR: No se encontró ID en respuesta\n", FILE_APPEND);
}

echo json_encode($resultado);
?>
```

---

## 🖥️ Comandos de terminal para ver logs

### Ver todo el archivo
```bash
cat /home/oldmacdonald/public_html/dev2/debug.log
```

### Ver las últimas N líneas
```bash
tail -30 /home/oldmacdonald/public_html/dev2/debug.log
```

### Ver en tiempo real (mientras pruebas)
```bash
tail -f /home/oldmacdonald/public_html/dev2/debug.log
```

### Filtrar por palabra clave
```bash
grep "ERROR" /home/oldmacdonald/public_html/dev2/debug.log
grep -E "INICIO|ERROR|Resultado" /home/oldmacdonald/public_html/dev2/debug.log
```

### Limpiar el archivo (borrar contenido)
```bash
> /home/oldmacdonald/public_html/dev2/debug.log
```

### Eliminar el archivo
```bash
rm /home/oldmacdonald/public_html/dev2/debug.log
```

---

## ⚠️ Importante: Limpieza antes de producción

**SIEMPRE elimina los logs de debug antes de desplegar a producción:**

1. Elimina todas las líneas de `file_put_contents()` del código
2. Elimina el archivo de debug del servidor
3. Verifica que no queden rastros en el código

---

## 🎯 Prompt para pedir debug al AI

Cuando necesites ayuda con debugging, usa este prompt:

> "Agrega debug con file_put_contents al archivo `[nombre_archivo.php]` para rastrear `[qué quieres ver]`. El log debe ir en `[ruta del archivo de log]`"

### Ejemplo:
> "Agrega debug con file_put_contents al archivo `set/addAsistente.php` para rastrear el flujo de creación y la respuesta del API. El log debe ir en `/home/oldmacdonald/public_html/dev2/miembros/acuarela-app-web/debug_asistente.log`"

---

## 📁 Rutas comunes de logs en este proyecto

| Ambiente | Ruta base |
|----------|-----------|
| DEV | `/home/oldmacdonald/public_html/dev2/miembros/acuarela-app-web/` |
| Producción | `/home/oldmacdonald/public_html/miembros/acuarela-app-web/` |

---

*Última actualización: Enero 2026*

