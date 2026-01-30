# Política de Auditoría y Logging v1.0
**Bilingual Child Care Training (Acuarela)**

---

**Versión:** 1.0  
**Fecha:** 30 de Enero, 2026  
**Estado:** Activo  
**Cumplimiento:** SOC 2 Tipo II (CC 4.1, 7.2), ISO 27001:2022 (A.8.15)

---

## 1. Propósito
Establecer los lineamientos técnicos y operativos para la generación, transmisión, almacenamiento y protección de logs de auditoría dentro de la plataforma Acuarela. Este sistema garantiza la trazabilidad de eventos críticos para detectar incidentes de seguridad, fallos operativos y asegurar la responsabilidad (accountability) de las acciones de los usuarios.

## 2. Alcance
Esta política aplica a todos los componentes de la aplicación web Acuarela (`acuarela-web`), incluyendo:
- Sistema de autenticación (Login, MFA).
- Manejo de datos sensibles (COPPA, FERPA).
- Subida de archivos.
- Errores críticos de sistema y comunicaciones con terceros (API).

## 3. Arquitectura de Nuevo Sistema de Auditoría
Acuarela implementa una estrategia de **Doble Logger** para separar responsabilidades y garantizar la integridad de los datos de seguridad.

### 3.1. Logger de Seguridad (`SecurityAuditLogger`)
*   **Propósito:** Registrar eventos exclusivos de seguridad y cumplimiento normativo.
*   **Ubicación de Log:** `/var/www/html/logs/audit.log` (Contenedor) → `./logs/audit.log` (VPS Host).
*   **Formato:** JSON Estructurado (Line-delimited JSON).
*   **Persistencia:** Volumen Docker persistente. No se borra en despliegues.

### 3.2. Logger Operacional de Cron (`AuditLogger` Legacy)
*   **Propósito:** Registrar actividades de tareas programadas y mantenimiento rutinario.
*   **Ubicación de Log:** `/var/www/html/miembros/cron/logs/audit.log`.
*   **Estado:** Se mantiene operativo e independiente para no afectar procesos legacy.

## 4. Estándar de Registro (Log Schema)
Cada evento de seguridad debe seguir estrictamente la siguiente estructura JSON para facilitar su ingesta por sistemas SIEM o herramientas de análisis:

```json
{
  "timestamp": "2026-01-30T10:00:00-05:00",
  "event_type": "string (snake_case)",
  "severity": "INFO | WARN | ERROR | CRITICAL",
  "user_id": "string (or null)",
  "ip_address": "x.x.x.x",
  "user_agent": "string",
  "resource": "/path/to/script.php",
  "details": {
    "key": "value"
  }
}
```

## 5. Eventos Auditados e Instrumentados
El sistema captura automáticamente los siguientes eventos críticos:

### 5.1. Autenticación y Acceso
*   `auth_mfa_challenge`: Inicio de proceso de login (Credenciales válidas, 2FA enviado).
*   `auth_login_success`: Verificación exitosa de 2FA. Token de sesión emitido.
*   `auth_login_failed`: Fallo en credenciales o código 2FA inválido.

### 5.2. Privacidad y Datos de Menores (COPPA)
*   `parental_consent_requested`: Envío de solicitud de consentimiento a un padre.
*   `parental_consent_granted`: Padre verifica y aprueba el consentimiento vía token.
*   `parental_consent_revoked`: Padre revoca el consentimiento explícitamente.

### 5.3. Derechos Educativos (FERPA)
*   `ferpa_access_requested`: Solicitud de acceso a registros educativos.
*   `ferpa_access_granted`: Envío de reportes/fichas al padre.
*   `ferpa_correction_requested`: Solicitud de rectificación de datos.
*   `ferpa_correction_approved`: Aprobación de corrección (evidencia manual registrada).
*   `ferpa_correction_rejected`: Rechazo de corrección.
*   `ferpa_status_change`: Cambio administrativo de estado en una solicitud.

### 5.4. Seguridad de Archivos
*   `file_upload_success`: Archivo subido correctamente.
*   `file_upload_rejected`: Archivo bloqueado por política (MIME type prohibido o Exceso de tamaño). **Severidad WARN**.

### 5.5. Sistema
*   `system_api_error`: Fallos de comunicación con APIs críticas (Zoho, Mandrill) o errores internos. **Severidad ERROR**.

## 6. Seguridad y Protección de Logs

### 6.1. Control de Acceso
*   El directorio `/logs/` está protegido por un archivo `.htaccess` con directiva `Deny from all`.
*   El acceso vía web (HTTP/HTTPS) está estrictamente prohibido.
*   Solo personal autorizado con acceso SSH al servidor puede leer los archivos.

### 6.2. Protección de Datos (PII)
*   Está **prohibido** registrar contraseñas, tokens de sesión activos o datos financieros completos en los logs.
*   Los datos personales (Email, Nombres) se registran solo cuando es indispensable para la trazabilidad (Ej. Identificar qué usuario realizó la acción).

### 6.3. Persistencia e Integridad
*   Los logs residen en un volumen de Docker (`./logs:/var/www/html/logs:rw`) mapeado al sistema de archivos del host.
*   Las políticas de despliegue (`deploy-production.sh` y GitHub Actions) están configuradas para **ignorar** y **preservar** el directorio de logs, asegurando que no se sobrescriban o eliminen durante actualizaciones de código.

## 7. Retención y Rotación
*   **Retención Operativa:** Los logs deben mantenerse disponibles en el servidor por un mínimo de 90 días.
*   **Archivado:** Logs mayores a 90 días pueden ser rotados, comprimidos y transferidos a almacenamiento en frío (Cold Storage) si el volumen de datos lo requiere.
*   Los backups del servidor (Snapshots VPS) incluyen el volumen de logs.

## 8. Revisión y Monitoreo
*   El equipo de seguridad/DevOps debe revisar el archivo `audit.log` periódicamente o ante alertas de sistema.
*   Se buscarán patrones anómalos, picos de eventos `WARN`/`ERROR` o intentos de acceso fallido repetidos (`auth_login_failed`).

---
Manuel Martinez
