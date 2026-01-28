# Implementación FERPA en Acuarela (Acceso y Corrección)

## Objetivo
Implementar flujos FERPA **formales, trazables y operables** para padres/tutores (solicitantes) y personal administrativo (equipo educativo / soporte), con evidencia auditable (SOC 2 / ISO 27001).

En Acuarela FERPA se implementa como un flujo **paralelo** a DSAR (privacidad general), evitando confusiones entre marcos legales.

## Alcance
### Incluye
- Canal FERPA explícito (formulario público + panel de gestión).
- Flujo FERPA de **Acceso** a registros educativos.
- Flujo FERPA de **Corrección** (revisión y resolución) con evidencia.
- Verificación de identidad (email/teléfono) y vínculo tutor–menor.
- Estados claros para solicitudes y cierre.
- Auditoría por eventos FERPA.

### No incluye (por ahora)
- Audiencias formales FERPA (hearings) complejas: se manejan como proceso manual documentado.
- Estudiantes mayores de edad (fase futura si aplica).

## Definición clave: “Registro educativo” (allowlist operativa)
Se consideran registros educativos FERPA dentro de Acuarela:
- Asistencia (checkins/checkouts)
- Evaluaciones / actividades (posts / actividades)
- Reportes de desarrollo
- Observaciones pedagógicas
- Registros de inscripción
- Comunicaciones institucionales asociadas al proceso educativo

No se consideran registros FERPA:
- Logs técnicos
- Métricas internas
- Datos puramente administrativos no educativos

## Roles / Sujetos con derecho
### Solicitante (Padre/Tutor)
- Se valida por **email + teléfono** registrados (y se listan hijos asociados).
- Puede solicitar:
  - Acceso formal a registros educativos
  - Corrección de registros inexactos o engañosos

### Equipo administrativo (operación FERPA)
- Ejecuta el flujo desde el panel de inspección (`inspeccion.php`).
- En el estado actual, el acceso a la plataforma está limitado a administradores (suficiente para el scope actual).

## Modelo de datos (Strapi: `ferpa-requests`)
Colección: `ferpa-requests`

Campos usados por el flujo:
- `id`: ID Strapi
- `request_type`: `access | correction`
- `requester`: relación a `acuarelausers` (padre/tutor)
- `requester_email`: fallback (si existe en Strapi / populate)
- `child`: relación a `children` (si se seleccionó un hijo)
- `record_type`: string (ej. `attendance`, `activities`, `report`, etc.)
- `record_ref`: string (referencia interna / ID del registro si se cuenta con él)
- `description`: texto de la solicitud (motivo / justificación)
- `status`: `received | under_review | approved | denied | completed`
- `created_at` / `received_at`: fecha de creación/recepción (según configuración)
- `completed_at`: fecha de cierre
- `resolution_notes`: respuesta al padre + evidencia de corrección (bloque técnico)

> Nota: la evidencia técnica se guarda en `resolution_notes` para no depender de campos nuevos en Strapi.

## Auditoría (eventos FERPA)
Los cambios de estado y entregas generan eventos en `AuditLogger`:
- `ferpa_access_requested`: cuando el tutor envía solicitud de acceso
- `ferpa_access_granted`: cuando se entrega el acceso (link/reportes enviados)
- `ferpa_correction_requested`: cuando el tutor envía solicitud de corrección
- `ferpa_correction_approved`: cuando el admin aprueba la corrección (con evidencia)
- `ferpa_correction_denied`: cuando el admin rechaza la corrección

Archivos donde se registran:
- `miembros/acuarela-app-web/set/privacy/submit_ferpa.php`
- `miembros/acuarela-app-web/set/privacy/send_ferpa_reports.php`
- `miembros/acuarela-app-web/set/privacy/apply_ferpa_correction.php`

## Canales / UI
### Formulario público FERPA (padre/tutor)
- Ruta: `miembros/acuarela-app-web/privacy/ferpa.php`
- Flujo:
  1) Tutor ingresa email + teléfono y presiona “Validar”.
  2) El sistema devuelve un **selector** de niños asociados (si existen), para seleccionar el menor.
  3) Tutor elige tipo de solicitud: **Acceso** o **Corrección**.
  4) Tutor describe la solicitud y envía.

### Panel de gestión FERPA (admin)
- Ruta: `miembros/acuarela-app-web/inspeccion.php`
- Funciones:
  - Ver listado de solicitudes FERPA
  - Abrir modal con detalle
  - Transicionar estados según el tipo (acceso/corrección)
  - Enviar reportes (acceso)
  - Aprobar/rechazar corrección con evidencia (corrección)
  - Paginación: 5 en 5

## Flujo FERPA – Acceso
### Estado y transiciones
Estado inicial:
- `received`

Transiciones:
- `received` → `under_review` (admin: “En Revisión”)
- `received` → `denied` (admin: “Rechazar” + nota)
- `under_review` → `completed` (admin: envía reportes / link + nota opcional)

### Implementación técnica
- **Crear solicitud**: `set/privacy/submit_ferpa.php`
  - Crea `ferpa-requests` con `status=received`
  - Audita `ferpa_access_requested`
- **Entrega de acceso**: `set/privacy/send_ferpa_reports.php`
  - Genera link de “modo inspección”
  - Envía correo al padre con HTML directo (sin depender de template Mandrill)
  - Actualiza solicitud a `completed`
  - Audita `ferpa_access_granted`

### Restricciones operativas
- Exportes/reportes deben limitarse a registros del menor y daycare correspondiente.
- No exponer datos de otros estudiantes.

## Flujo FERPA – Corrección (manual + evidencia)
Este flujo fue intencionalmente simplificado para operación real:
- El admin realiza la corrección **manualmente** donde corresponda (Strapi / módulo de Acuarela).
- Luego documenta la corrección en FERPA con evidencia “Antes / Después”.

### Estado y transiciones (igual patrón que Acceso)
- `received`:
  - acciones: “En Revisión” o “Rechazar”
  - no pide evidencia aún
- `under_review`:
  - acciones: “Aprobar Corrección” o “Rechazar”
  - pide:
    - Nota de resolución (mensaje al padre)
    - Antes (qué estaba mal)
    - Después (cómo quedó corregido)
- `approved` / `denied`:
  - estado final (solo lectura)

### Implementación técnica
- **Crear solicitud**: `set/privacy/submit_ferpa.php`
  - Audita `ferpa_correction_requested`
- **Pasar a revisión / rechazar (corrección)**: `set/privacy/update_ferpa_status.php`
  - Cambia estado a `under_review` o `denied`
  - Envía correo al padre con template existente `dsar-status-update` (requiere nota)
- **Aprobar corrección**: `set/privacy/apply_ferpa_correction.php`
  - No modifica registros educativos automáticamente.
  - Guarda evidencia en `resolution_notes`:
    - `manual_before`, `manual_after`, `approved_by`, `approved_at`, `record_type`, `record_ref`
  - Cambia estado a `approved`
  - Envía correo al padre con template `dsar-status-update` (requiere nota)
  - Audita `ferpa_correction_approved`

### Evidencia (auditoría / SOC2 / ISO)
La evidencia se guarda como bloque JSON dentro de `resolution_notes`:
- Prefijo: `---FERPA_CORRECTION_EVIDENCE---`
- Contenido JSON (versión `v=2`)

> La UI (modal) oculta este bloque técnico para no confundir al usuario; queda disponible para auditoría.

## Correos
### Confirmación inicial de solicitud (padre)
No se envía correo de confirmación “recibimos tu solicitud”. (Decisión operativa)
- Razón: FERPA no lo exige; evita dependencia de templates Mandrill faltantes.
- El “acuse” queda como confirmación en UI + registro en `ferpa-requests`.

### Corrección / Rechazo (padre)
Se envía correo con la nota del admin usando template existente:
- Template: `dsar-status-update` (Mandrill)
- Variables usadas:
  - `USER_NAME`
  - `DSAR_ID` (se reusa para mostrar el ID corto)
  - `STATUS_TITLE`
  - `STATUS_COLOR`
  - `UPDATE_MESSAGE`
  - `CURRENT_YEAR`

### Entrega de acceso (padre)
Se envía correo HTML directo (sin template Mandrill):
- `set/privacy/send_ferpa_reports.php`

## Runbook (operación para el equipo)
### Para solicitudes de Acceso
1) Abrir solicitud en `inspeccion.php`
2) Cambiar a **En Revisión**
3) Configurar reportes y rango de fechas
4) Enviar informes (el sistema cierra como `completed`)

### Para solicitudes de Corrección
1) Abrir solicitud en `inspeccion.php`
2) Si procede, cambiar a **En Revisión**
3) Hacer la corrección en el módulo correspondiente (manual)
4) Volver a FERPA:
   - Completar “Antes” y “Después”
   - Escribir Nota de Resolución (mensaje al padre)
5) “Aprobar Corrección” (se envía correo + queda evidencia + auditoría)

## Referencias de implementación (archivos)
- Formulario público: `miembros/acuarela-app-web/privacy/ferpa.php`
- Crear solicitud + auditoría: `miembros/acuarela-app-web/set/privacy/submit_ferpa.php`
- Reportes acceso + email + auditoría: `miembros/acuarela-app-web/set/privacy/send_ferpa_reports.php`
- Corrección aprobada (manual evidence) + email + auditoría: `miembros/acuarela-app-web/set/privacy/apply_ferpa_correction.php`
- Cambios de estado + email: `miembros/acuarela-app-web/set/privacy/update_ferpa_status.php`
- UI admin: `miembros/acuarela-app-web/inspeccion.php`
- SDK Strapi: `miembros/acuarela-app-web/includes/sdk.php`

