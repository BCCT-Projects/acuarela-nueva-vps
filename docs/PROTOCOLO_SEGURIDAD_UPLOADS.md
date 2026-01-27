# Seguridad en Subida de Archivos

Este documento detalla las mejoras de seguridad implementadas en el sistema de carga de archivos de la plataforma Acuarela.

## 1. Problema Identificado
La aplicación permitía la subida directa de archivos a la API de Strapi desde el frontend y a través de scripts PHP sin validación suficiente. Esto exponía el sistema a riesgos como:
- Subida de archivos maliciosos (ej. scripts PHP disfrazados de imágenes).
- Carga de archivos excesivamente grandes (Denegación de Servicio).
- Exposición de metadatos sensibles (EXIF) y nombres de archivo originales.

## 2. Solución Implementada: Proxy de Seguridad

Se creó una capa intermedia en PHP que intercepta, valida y sanitiza todos los archivos antes de enviarlos al almacenamiento final (Strapi).

### Nuevos Componentes
- **`set/uploadFile.php`**: Nuevo endpoint centralizado para la subida segura de archivos.
- **Modificación de `set/addPost.php`**: Actualizado para incluir la misma lógica de seguridad para las publicaciones del Muro Social.

### Reglas de Seguridad Aplicadas
1.  **Validación de Tipo MIME Real:**
    - Se utiliza `finfo_file()` para inspeccionar el contenido binario del archivo.
    - **Lista blanca (Allowlist):** Solo se permiten:
        - Imágenes: `image/jpeg`, `image/png`, `image/webp`
        - Documentos: `application/pdf` (solo en inscripciones)
    - Se rechaza cualquier archivo que no coincida, independientemente de su extensión.

2.  **Límite de Tamaño:**
    - Máximo **5 MB** por archivo.

3.  **Renombrado Seguro (Sanitización):**
    - Se descarta el nombre original del archivo.
    - Se genera un nuevo nombre aleatorio criptográficamente seguro (32 caracteres hexadecimales).
    - Se asigna la extensión correcta basada en el tipo MIME detectado.
    - Esto previene ataques de *Path Traversal* y ejecución de scripts por doble extensión (ej. `malware.php.jpg`).
    - **Neutralización de Doble Extensión:** Al reescribir completamente el nombre del archivo, cualquier intento de usar extensiones dobles (ej. `archivo.php.jpg`) es eliminado automáticamente.

4.  **Auditoría y Logs:**
    - Se registran en el `error_log` del servidor todos los intentos fallidos o rechazados con el prefijo `[SECURITY]`, incluyendo la IP del solicitante y la razón del rechazo.

## 3. Puntos de Entrada Asegurados

Se actualizaron los scripts del frontend (JS) para utilizar los nuevos endpoints seguros en lugar de subir archivos directamente a Strapi:

| Módulo | Archivo JS | Endpoint Seguro |
| :--- | :--- | :--- |
| **Muro Social** | `js/main.js` | `set/addPost.php` |
| **Inscripción Niñx** | `js/main.js` | `set/uploadFile.php` |
| **Agregar Asistente**| `js/utils.js` | `set/uploadFile.php` |

## 4. Experiencia de Usuario (UX) Mejorada
- **Validación Triple en Cliente:** El navegador realiza tres comprobaciones inmediatas antes de subir nada:
    1.  **Tipo de Archivo:** Solo permite extensiones válidas.
    2.  **Tamaño:** Detecta si el archivo pesa más de 5MB y lo bloquea al instante.
    3.  **Integridad:** Detecta archivos vacíos (0 bytes) o corruptos.
- **Feedback Inmediato:** Se implementaron notificaciones visuales mediante **SweetAlert**.
- **Mensajes Amigables:** Si un archivo es rechazado por el servidor, el usuario ve un mensaje claro (ej. "Solo se permiten imágenes (JPG, PNG, WebP)") en lugar de códigos de error técnicos.

## 5. Infraestructura

- **Manejo de Excepciones:** Los endpoints PHP ahora capturan errores fatales (Try-Catch) y siempre devuelven una respuesta JSON válida, evitando que la interfaz de usuario se congele o reinicie inesperadamente.

---
**Resumen:**
Hemos eliminado la exposición directa de la API de carga de archivos. Ahora, cada archivo que entra al sistema es inspeccionado rigurosamente por el servidor: se verifica que sea realmente una imagen o PDF, se asegura que no sea una "bomba" de tamaño y se le cambia el nombre por uno inofensivo antes de guardarlo. Esto garantiza que **archivos con doble extensión sean rechazados y neutralizados**.

Además, la implementación de una **Defensa en Profundidad** (validaciones redundantes en frontend y backend) asegura no solo la integridad del servidor, sino también una experiencia de usuario fluida y libre de frustraciones, proporcionando feedback inmediato y comprensible ante cualquier error.
