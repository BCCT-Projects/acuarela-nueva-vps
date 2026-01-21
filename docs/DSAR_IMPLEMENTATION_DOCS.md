# Documentación Técnica: Módulo de Privacidad y DSAR (Acuarela)

## 1. Visión General
Este documento detalla la implementación técnica del módulo de Solicitudes de Acceso de Sujeto de Datos (DSAR). El sistema se diseñó para cumplir con normativas CCPA/GDPR, solucionando retos específicos de integración con **Strapi v3** y asegurando transaccionalidad mediante **Mandrill**.

## 2. Puntos Clave de Ingeniería

### 2.1. Gestión de Relaciones en Strapi v3 (Reto Técnico)
Uno de los desafíos principales fue la asociación inconsistente de datos entre usuarios y sus *daycares*.
*   **Problema:** La API de Strapi v3, en sus endpoints de listado (ej. `GET /users?email=...`), no siempre popula relaciones profundas o matrices de componentes por razones de rendimiento. Esto resultaba en objetos de usuario sin la propiedad `daycares` visible.
*   **Solución Algorítmica:** Se implementó una estrategia de "Verificación de Dos Pasos" en `submit_dsar.php`:
    1.  Búsqueda ligera por email para validar existencia.
    2.  **Llamada Profunda (`Deep Fetch`):** Una vez obtenido el ID, se ejecuta una petición directa `GET /users/{id}`. Este endpoint específico en Strapi v3 sí garantiza la carga completa del grafo de relaciones (Eager Loading), permitiendo extraer correctamente el ID del `daycare`.
    3.  **Fallback de Propiedades:** El código maneja dinámicamente si Strapi devuelve la relación como un array `daycares` (plural) o un objeto simple `daycare` (singular), robusteciendo la integración contra cambios en el modelo de datos.

### 2.2. Seguridad y Criptografía
*   **Tokens de Verificación:** Se generan tokens de alta entropía de 64 caracteres hexadecimales para los enlaces de verificación de email.
    *   Implementación: Uso de `bin2hex(random_bytes(32))` con un fallback a `openssl_random_pseudo_bytes` para máxima compatibilidad entre versiones de PHP.
*   **Normalización de Datos:** El número de teléfono se normaliza eliminando cualquier carácter no numérico mediante Regex (`preg_replace('/[^0-9]/', ...)`) antes de compararlo con la base de datos.
    *   **Lógica Fuzzy:** Se permite coincidencia exacta O coincidencia de los últimos 6 dígitos, balanceando seguridad con usabilidad (tolerancia a formatos con/sin código de país).

### 2.3. Estabilidad de Respuestas JSON
Para garantizar que el frontend (Javascript) nunca reciba respuestas corruptas:
*   **Supresión de Ruido:** Se fuerza `ini_set('display_errors', 0)` al inicio de los scripts PHP de backend. Esto evita que `Warnings` o `Notices` de PHP se inyecten en el cuerpo de la respuesta HTTP, lo cual rompería la estructura JSON válida (`Unexpected token < in JSON`).
*   **Logging Silencioso:** Los errores críticos se redirigen al log del servidor (`error_log`), manteniendo la respuesta al cliente limpia.

## 3. Arquitectura del Flujo de Datos

### 3.1. Envío de Solicitud (`submit_dsar.php`)
1.  **Recepción:** POST con `email`, `phone`, `request_type`.
2.  **Validación Cruzada:** Consulta Strapi para verificar que el email exista y que el teléfono coincida con el registro.
3.  **Cálculo de SLA:** Se genera automáticamente el campo `due_at` sumando 45 días a la fecha actual (`date('c', strtotime('+45 days'))`), estableciendo un plazo legal duro en la base de datos.
4.  **Persistencia:** Se inserta el registro en la colección `dsar-requests`.
5.  **Disparo de Evento:** Se invoca al SDK de Mandrill para enviar el template `dsar-verification` con el token generado.

### 3.2. Actualización de Estado (`update_status.php`)
1.  **Control de Enum:** Verifica que el estado solicitado (`received`, `completed`, `rejected`, etc.) sea válido según la lógica de negocio.
2.  **Verificación de Respuesta Strapi:** Tras el `PUT` a la API, el script compara el estado devuelto por Strapi vs el enviado.
    *   *Por qué:* Strapi v3 ignora silenciosamente valores que no están definidos en su esquema `Enumeration`. Si el admin envía "rejected" pero el esquema no lo tiene, Strapi no devuelve error, solo no actualiza. Nuestro código detecta esta discrepancia y alerta al administrador.
3.  **Notificaciones Dinámicas (Merge Vars):**
    Se construye un payload JSON para Mandrill inyectando variables de diseño:
    ```php
    [
        'name' => 'STATUS_COLOR',
        'content' => ($status == 'rejected') ? '#dc3545' : '#28a745'
    ]
    ```
    Esto permite que **una sola plantilla de correo HTML** sirva para notificaciones positivas, negativas o neutrales, cambiando visualmente según el contexto.

## 4. Componentes y Servicios Externos

### 4.1. Base de Datos: Strapi v3 (Headless CMS)
Colección: **`dsar-requests`**
*   **Relaciones:**
    *   `linked_user`: Relación polimórfica o directa con `users-permissions_user`.
    *   `daycare`: Relación vital para filtrar solicitudes por centro educativo.
*   **Campos Críticos:** `verification_token` (Indexado), `status` (Enum), `due_at` (Timestamp).

### 4.2. Motor de Correo: Mandrill (Mailchimp Transactional)
Uso de **Handlebars/Merge Tags** (`*|VAR|*`) para inyección de contenido seguro.
*   **Template `dsar-verification`**: Enlace de acción única.
*   **Template `dsar-status-update`**: Comunicación de resolución. Uso de estilos en línea (CSS inliner) para asegurar renderizado correcto en clientes antiguos (Outlook, Gmail).

## 5. Requisitos de Despliegue
*   **PHP Configuration:** `allow_url_fopen` habilitado (para SDK de Mandrill/Strapi).
*   **Variables de Entorno (`.env` o Server Config):**
    *   `MANDRILL_API_KEY`: Credencial de envío.
    *   `ACUARELA_API_URL`: Endpoint base de Strapi.
*   **Cron/Workers (Opcional):** Para monitoreo futuro de fechas `due_at` vencidas.

---
*Documento generado automáticamente tras implementación del módulo DSAR - Enero 2026*
