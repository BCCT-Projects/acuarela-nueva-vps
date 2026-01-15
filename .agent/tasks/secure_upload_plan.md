# Plan de Implementación de Seguridad en Subida de Archivos

## Objetivo
Asegurar la subida de archivos en `addPost.php` mediante validación estricta de MIME types, tamaño y renombrado seguro.

## Archivos Afectados
- `miembros/acuarela-app-web/set/addPost.php`

## Reglas de Validación
1. **Tipos Permitidos (MIME Real)**:
   - `image/jpeg` -> `.jpg`
   - `image/png` -> `.png`
   - `image/webp` -> `.webp`
2. **Tamaño Máximo**:
   - 5 MB (5 * 1024 * 1024 bytes)
3. **Renombrado**:
   - UUID v4 o Hex aleatorio (32 chars) + Extensión derivada del MIME real.

## Cambios en `addPost.php`
1. **Configuración**: Definir constantes `ALLOWED_MIME_TYPES` y `MAX_FILE_SIZE`.
2. **Lógica de Iteración**:
   - Agregar verificación de `upload_error`.
   - Agregar validación de `finfo_file` (o `mime_content_type`).
   - Agregar validación de tamaño.
   - Generar nuevo nombre seguro.
   - Pasar los datos saneados a `$a->uploadImage`.

## Consideraciones
- Se mantendrá el uso de `sdk.php` existente (`uploadImage`), ya que este acepta los parámetros `name` y `type` que le pasemos saneados.
- Se devolverá un error JSON claro si algún archivo no cumple las reglas.
