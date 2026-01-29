# Estado de Cumplimiento SOC 2 & ISO/IEC 27001 - Acuarela Web/App

**Fecha de Auditoría:** 27 de Enero, 2026
**Estatus General:** ✅ CUMPLIMIENTO TÉCNICO ALCANZADO (7/8 Implementados)
**Versión:** 1.3 (Final con Evidencia y Explicación)

Este documento certifica el estado actual de la implementación de seguridad y cumplimiento normativo de la plataforma, detallando los controles implementados, la evidencia técnica verificada y las acciones pendientes para la excelencia operativa.

---

## 📊 RESUMEN EJECUTIVO (MATRIZ MAESTRA)

| Dominio | Nombre | Estado | Nivel de Riesgo |
|:---:|---|:---:|:---:|
| 🧱 | 1. Gobernanza y Políticas | 🟢 IMPLEMENTADO | Bajo |
| 🔐 | 2. Control de Acceso | 🟢 IMPLEMENTADO | Bajo |
| ☁️ | 3. Infraestructura | 🟢 IMPLEMENTADO | Bajo |
| 🔑 | 4. Cifrado de Datos | 🟢 IMPLEMENTADO | Bajo |
| 🧾 | 5. Auditoría y Logging | 🟢 IMPLEMENTADO | Bajo |
| 🔄 | 6. Gestión de Cambios | 🟢 IMPLEMENTADO | Bajo |
| 👶 | 7. Privacidad (COPPA/CCPA) | 🟢 IMPLEMENTADO | Medio (Falta FERPA) |
| ♻️ | 8. Retención y Eliminación | 🟢 IMPLEMENTADO | Bajo |

---

## 📝 DETALLE DE DOMINIOS Y EVIDENCIA TÉCNICA

### 🧱 DOMINIO 1 – GOBERNANZA Y POLÍTICAS
**Objetivo:** Establecer el marco legal y operativo de seguridad.
*   **Estado:** ✅ Documentado y Aprobado.
*   **📝 Descripción del Cumplimiento:**
    Acuarela ha formalizado la seguridad mediante un conjunto de políticas documentadas que definen claramente las reglas de juego. No es seguridad "tribal" ni improvisada; existen documentos rectores (Policies) que dictan cómo se debe cifrar la información, cuánto tiempo se retienen los datos y cómo debe configurarse la infraestructura base. Estas políticas actúan como la ley interna que guía al equipo técnico.
*   **📍 Evidencia Documental (Docs):**
    *   `docs/POLITICA_CIFRADO_DATOS.md` (Política A.8.24)
    *   `docs/POLITICA_RETENCION_DATOS_ISO27001.md` (Política SOC 2 CC8)
    *   `docs/REPORTE_HARDENING_SERVIDOR.md` (Baseline de Seguridad)
*   **Cumplimiento:** SOC 2 CC1.1, ISO 27001 A.5.1.

### 🔐 DOMINIO 2 – CONTROL DE ACCESO
**Objetivo:** Garantizar que solo usuarios autorizados accedan a datos sensibles.
*   **Estado:** ✅ Robusto con MFA y Trazabilidad.
*   **📝 Descripción del Cumplimiento:**
    El sistema ya no confía ciegamente en una contraseña. Hemos implementado una arquitectura de "Defensa en Profundidad" para el login. Primero, autenticamos con credenciales estándar. Segundo, exigimos un token de un segundo factor (2FA) enviado al correo verificado. Tercero, registramos cada paso de este baile (éxito, fallo o reto) en un log inmutable. Además, las sesiones críticas se destruyen proactivamente hasta que se valida el segundo factor, previniendo secuestro de sesiones a medias.
*   **📍 Evidencia Documental (Docs):**
    *   `docs/GUIA_TECNICA_MFA.md` (Guía técnica del flujo 2FA)
*   **📂 Evidencia en Código (Implementación):**
    *   **Login & Reto MFA:** `miembros/set/login.php` (Generación de token y bloqueo de sesión).
    *   **Verificación:** `miembros/set/verify_2fa.php` (Validación y desbloqueo).
    *   **Logs:** `miembros/cron/AuditLogger.php` (Registro de eventos `LOGIN_SUCCESS`, `LOGIN_FAILED`).
*   **Cumplimiento:** SOC 2 CC6.1, CC6.3, ISO 27001 A.5.15, A.9.2.

### ☁️ DOMINIO 3 – INFRAESTRUCTURA Y HARDENING
**Objetivo:** Proteger el servidor y la red contra ataques externos.
*   **Estado:** ✅ Hardening Nivel Producción (Calif. A+).
*   **📝 Descripción del Cumplimiento:**
    El servidor VPS ha sido endurecido ("Hardened") siguiendo estándares de industria. La puerta de entrada web (Apache) ahora rechaza conexiones inseguras (no-TLS) y fuerza HTTPS estricto. Se han instalado "cerrojos digitales" (Security Headers) que instruyen al navegador del visitante a protegerse contra ataques de Cross-Site Scripting (XSS) y Clickjacking. Además, se ha limpiado la "superficie de ataque" ocultando archivos técnicos (.env, .git) que nunca deberían ser públicos.
*   **📍 Evidencia Documental (Docs):**
    *   `docs/REPORTE_HARDENING_SERVIDOR.md` (Reporte de configuración de headers y SSL)
    *   `docs/PROTOCOLO_SEGURIDAD_UPLOADS.md` (Validación y sanitización de archivos)
*   **📂 Evidencia en Código (Configuración):**
    *   **Servidor Web:** `apache-config.production.conf` (TLS 1.2, HSTS, Headers).
    *   **Contenedor:** `Dockerfile.production` (Configuración de entorno seguro).
*   **Cumplimiento:** SOC 2 CC6.6, ISO 27001 A.8.9.

### 🔑 DOMINIO 4 – CIFRADO Y PROTECCIÓN DE DATOS
**Objetivo:** Proteger la confidencialidad de los datos en reposo y tránsito.
*   **Estado:** ✅ Cifrado Fuerte (AES-256).
*   **📝 Descripción del Cumplimiento:**
    Los datos sensibles (como teléfonos personales o identificadores) no se guardan en texto plano en la base de datos. Utilizamos un servicio centralizado de criptografía (`CryptoService`) que aplica el algoritmo estándar AES-256-CBC, el mismo que utilizan las instituciones financieras. Esto asegura que, en el hipotético caso de que un atacante robara la base de datos física ("data at rest"), la información sería ilegible sin la clave de cifrado correspondiente.
*   **📍 Evidencia Documental (Docs):**
    *   `docs/ENCRYPTION-IMPLEMENTATION.md` (Detalle del algoritmo y gestión de claves)
    *   `docs/POLITICA_CIFRADO_DATOS.md` (Política normativa)
*   **📂 Evidencia en Código (Implementación):**
    *   **Servicio:** `miembros/includes/CryptoService.php` (Clase `CryptoService`).
    *   **Uso:** Llamadas a `$a->crypto->encrypt()` en controladores de usuario.
*   **Cumplimiento:** SOC 2 CC6.7, ISO 27001 A.8.24.

### 🧾 DOMINIO 5 – AUDITORÍA Y LOGGING
**Objetivo:** Mantener un registro inalterable de eventos del sistema para análisis forense.
*   **Estado:** ✅ Sistema Centralizado de Auditoría.
*   **📝 Descripción del Cumplimiento:**
    El sistema mantiene un registro detallado ("Audit Trail") de los eventos críticos. A diferencia de un simple log de errores, nuestro `AuditLogger` registra acciones de negocio: "¿Quién entró?", "¿Quién falló la contraseña?", "¿Cuándo se borraron datos viejos?". Estos registros son inmutables y se almacenan en un formato estructurado (JSON), permitiendo reconstruir la historia de eventos ante cualquier incidente de seguridad o auditoría externa.
*   **📍 Evidencia Documental (Docs):**
    *   `docs/REPORTE_HARDENING_SERVIDOR.md` (Sección 5: Evidencias de Logs)
*   **📂 Evidencia en Código (Implementación):**
    *   **Clase Logger:** `miembros/cron/AuditLogger.php` (Estandarización de logs JSON).
    *   **Archivo Log:** `miembros/cron/logs/audit.log` (Repositorio de eventos).
    *   **Suficiencia:** Registra Tiempos, Actores y Resultados de eventos críticos (Login, Purga, Errores).
*   **Cumplimiento:** SOC 2 CC7.2, ISO 27001 A.8.15.

### 🔄 DOMINIO 6 – GESTIÓN DE CAMBIOS
**Objetivo:** Asegurar que los cambios de código no introduzcan vulnerabilidades.
*   **Estado:** ✅ Flujo controlado con CI/CD (GitHub Actions).
*   **📝 Descripción del Cumplimiento:**
    Los cambios en el entorno productivo no se realizan de forma manual o improvisada. Se ha implementado un **despliegue continuo (CI/CD)** con GitHub Actions que garantiza un flujo trazable y repetible: (1) commits en la rama `dev` generan automáticamente un Pull Request hacia `main`; (2) al aceptar el PR y hacer merge a `main`, el workflow sincroniza el código con la VPS vía rsync (solo cambios) y ejecuta en el servidor el script `deploy-production.sh`, que reconstruye la imagen Docker cuando hay cambios relevantes o levanta contenedores sin rebuild cuando no los hay. El código en producción es idéntico a la versión aprobada en el repositorio. Se utilizan contenedores Docker para encapsular la aplicación y se protegen las carpetas de cache del servidor (`cache/`, `miembros/cache/`) para que no se borren en cada deploy, manteniendo el rendimiento del cache de API.
*   **📍 Evidencia Documental (Docs):**
    *   `docs/PROTOCOLO_DESPLIEGUE_SEGURO.md` (Procedimiento estándar de despliegue)
    *   `docs/DESPLIEGUE_CONTINUO_GITHUB_ACTIONS.md` (Flujo CI/CD con GitHub Actions)
*   **📂 Evidencia en Código (Workflows y Scripts):**
    *   **Workflow dev (PR automático):** `.github/workflows/deploy-dev.yml`
    *   **Workflow main (sync + deploy):** `.github/workflows/deploy-main.yml`
    *   **Script en servidor:** `deploy-production.sh` (build condicional y levantado de contenedores)
    *   **Estado último deploy:** `.deploy_state` (commit desplegado)
*   **Cumplimiento:** SOC 2 CC8.1, ISO 27001 A.8.32.

### 👶 DOMINIO 7 – PRIVACIDAD (COPPA / CCPA / FERPA)
**Objetivo:** Cumplir con leyes de protección de datos de menores y estudiantes.
*   **Estado:** 🟢 Cumple COPPA/CCPA - ⚠️ Falta FERPA.
*   **📝 Descripción del Cumplimiento:**
    Cumplimos con las leyes de privacidad proporcionando a los usuarios control total sobre sus datos. Hemos implementado un portal de Derechos ARCO (DSAR) donde los usuarios pueden solicitar acceso, corrección o eliminación de su información. Este proceso verifica rigurosamente la identidad del solicitante (cruzando email y teléfono) antes de procesar la solicitud, evitando fugas de información por suplantación. Todo queda registrado y se notifica tanto al usuario como al equipo de soporte.
*   **📍 Evidencia Documental (Docs):**
    *   `docs/PROTOCOLO_DERECHOS_ARCO_DSAR.md` (Documentación técnica del módulo DSAR)
    *   `docs/POLITICA_CONSENTIMIENTO_COPPA.md` (Gestión de consentimiento parental)
*   **📂 Evidencia en Código (Implementación):**
    *   **Formulario DSAR:** `miembros/acuarela-app-web/privacy/dsar.php` (Interfaz de Usuario).
    *   **Procesador:** `miembros/acuarela-app-web/set/privacy/submit_dsar.php` (Validación identidad + Persistencia).
*   **Cumplimiento:** SOC 2 CC2.1, ISO 27001 A.5.34.

### ♻️ DOMINIO 8 – RETENCIÓN Y ELIMINACIÓN
**Objetivo:** Minimización de datos y cumplimiento del "Derecho al Olvido".
*   **Estado:** ✅ Automatizado.
*   **📝 Descripción del Cumplimiento:**
    Aplicamos el principio de "Minimización de Datos" mediante procesos automáticos que eliminan la información que ya no es necesaria. Un sistema de tareas programadas (Cron) revisa periódicamente los registros de auditoría y archivos temporales, eliminando aquellos que superan el tiempo de vida definido en nuestras políticas (ej. 90 días para logs). Esto asegura que no retenemos "basura digital" que podría convertirse en un riesgo legal o de seguridad.
*   **📍 Evidencia Documental (Docs):**
    *   `docs/POLITICA_RETENCION_DATOS_ISO27001.md` (Reglas de retención y purga)
*   **📂 Evidencia en Código (Automatización):**
    *   **Motor:** `miembros/cron/RetentionJob.php` (Script de ejecución).
    *   **Reglas:** `miembros/cron/retention_rules.json` (Configuración de TTLs: 90 días logs, 7 días cache).
*   **Cumplimiento:** SOC 2 CC8, ISO 27001 A.8.10.

---

## 🚀 HOJA DE RUTA: EXCELENCIA OPERATIVA

### 1. Implementación de Backups (Crítico SOC 2 Disponibilidad)
**Riesgo:** Pérdida total de datos ante fallo del servidor VPS.
*   **Estado:** ❌ NO IMPLEMENTADO.
*   **Acción Falta:** Script `BackupJob.php` automatizado para dump diario encrypted a S3/FTP.

### 2. Cierre de Brecha FERPA (Funcionalidad)
**Riesgo:** Incumplimiento normativo específico para clientes educativos (K-12).
*   **Acción Falta:** Implementar módulo "Registro de Divulgación" (Disclosure Log) y formulario de "Solicitud de Enmienda" en perfil del alumno.

### 3. Alertas Activas de Seguridad
**Riesgo:** Detección tardía de ataques.
*   **Acción:** Configurar `AuditLogger` para monitorear patrones (ej. >5 fallos login/minuto) y enviar alerta email inmediata a los administradores.
