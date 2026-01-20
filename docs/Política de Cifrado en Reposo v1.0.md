# Política de Cifrado en Reposo - Acuarela

**Versión:** 1.2  
**Fecha de Vigencia:** Enero 2026  
**Última Actualización:** 19 de Enero 2026  
**Estado:** Activa

---

## 1. Propósito y Alcance

Esta política establece los estándares y procedimientos para proteger la confidencialidad de la Información de Identificación Personal (PII) de menores y familias almacenada en los sistemas de Acuarela. Su objetivo es asegurar el cumplimiento con normativas de privacidad (COPPA) y estándares de seguridad (SOC 2, ISO 27001), mitigando el riesgo de exposición de datos en caso de acceso no autorizado a la infraestructura.

Esta política aplica a todos los datos almacenados en:

- Bases de datos de la aplicación (Strapi/MySQL).
- Archivos adjuntos y evidencias.

## 2. Clasificación de Datos y Estrategia de Protección

Se ha definido una estrategia de protección granular basada en la sensibilidad del dato y el impacto operativo.

### 2.1 Datos Protegidos Mediante Cifrado (AES-256)

Los siguientes campos se consideran de **Alta Sensibilidad** y se almacenan cifrados:

| Tipo de Dato | Campos Específicos | Método de Cifrado | Justificación |
| :--- | :--- | :--- | :--- |
| **Identidad del Menor** | `name`, `lastname`, `birthday` | Cifrado Completo | Identidad completa protegida. Garantiza anonimato total en BD. |
| **Salud del Menor - Historial** | `allergies`, `medicines`, `vacination`, `accidents`, `ointments`, `incidents` | Cifrado Completo (Array → String) | Información médica sensible general (HIPAA compliant approach). |
| **Salud del Menor - Observaciones** | `physical_health`, `emotional_health`, `suspected_abuse`, `pediatrician` (nombre) | Cifrado Completo | Notas clínicas y observaciones médicas. |
| **Salud del Menor - Health Check** | `temperature`, `report`, `bodychild` | **Cifrado Granular** (Valores dentro de objetos) | Registros diarios de salud. **Nota:** `daily_fecha` se mantiene en plano para índices/calendario. |
| **Contacto Padres** | `phone`, `work_phone` | Cifrado Completo | Dato de contacto directo primario y laboral. |

### 2.2 Datos Protegidos Mediante Anonimización

Los siguientes activos se protegen eliminando metadatos identificables:

| Tipo de Dato | Estrategia | Justificación |
| :--- | :--- | :--- |
| **Archivos Adjuntos** | Renombramiento Aleatorio (Hashing) | Se eliminan nombres reales de archivos (ej: `Foto_Juan.jpg` -> `a8f92bd.jpg`) antes del almacenamiento. Esto impide identificar al sujeto solo por acceder al sistema de archivos. |

### 2.3 Excepciones Justificadas (Datos NO Cifrados)

Se ha decidido explícitamente **NO cifrar** los siguientes datos tras un análisis de riesgo/operatividad:

| Tipo de Dato | Justificación de Riesgo Aceptado | Control Compensatorio |
| :--- | :--- | :--- |
| **Email de Padres** | **Riesgo Sistémico:** Cifrar el email (que es el ID de usuario) rompería la integración con sistemas externos de autenticación (Auth0/Firebase) y servicios de correo transaccional. | El email se trata como identificador público dentro del sistema. Se protege mediante TLS en tránsito. |
| **Datos de Pediatra** | **Validación y Naturaleza Pública:** El email del pediatra (`pediatrician_email`) requiere validación de formato estricta en base de datos. Además, son datos de contacto profesional (Tarjetas de presentación), no PII confidencial del menor. | Se almacenan en texto plano (`pediatrician_email`, `pediatrician_number`). |
| **Fecha de Health Check** | **Requerimiento Operativo:** `daily_fecha` debe permanecer en texto plano para permitir búsquedas, ordenamiento y visualización de calendario sin necesidad de descifrado masivo. | Solo la fecha es visible; el contenido médico (temperatura, síntomas) está cifrado. |
| **Archivos Binarios (Contenido)** | **Complejidad Técnica y Operativa:** Cifrar el contenido binario de imágenes impediría el uso de funcionalidades nativas del CMS (redimensionado, miniaturas, optimización CDN). | **Anonimización de nombres** (ver 2.2) y restricción de acceso a carpetas de uploads. |

## 3. Estándar Técnico de Cifrado

### 3.1 Algoritmo

Todo cifrado realizado bajo esta política utiliza el siguiente estándar criptográfico robusto:

- **Algoritmo:** AES-256-CBC (Advanced Encryption Standard).
- **Modo:** Cipher Block Chaining (CBC).
- **IV (Vector de Inicialización):** Aleatorio y único por registro (16 bytes), almacenado junto al texto cifrado.
- **Librería:** OpenSSL (vía PHP `openssl_encrypt`).

### 3.2 Implementación

El cifrado se realiza a **nivel de aplicación** (Application Layer Encryption) antes de que los datos sean enviados a la base de datos.

- **Servicio:** `CryptoService.php` (Helper centralizado).
- **Flujo de Escritura:** `Dato Plano` -> `CryptoService::encrypt()` -> `Base de Datos`.
- **Flujo de Lectura:** `Base de Datos` -> `CryptoService::decrypt()` -> `Vista de Usuario`.

#### 3.2.1 Cifrado Granular (Health Check)

Para campos estructurados que Strapi valida como `Array` (ej: `healthcheck`), se implementa **cifrado granular**:

- La estructura del array se mantiene visible para la base de datos.
- Los valores sensibles dentro de cada objeto se cifran individualmente.
- **Ejemplo:**

  ```json
  // Antes del cifrado:
  [{"temperature": "38", "report": "Fiebre", "daily_fecha": "2026-01-19"}]
  
  // Después del cifrado:
  [{"temperature": "Xy9z...==", "report": "Ab3d...==", "daily_fecha": "2026-01-19"}]
  ```

## 4. Gestión de Llaves (Key Management)

### 4.1 Almacenamiento

- La **Clave Maestra de Cifrado (DEK)** NUNCA se almacena en el código fuente ni en la base de datos.
- Se inyecta exclusivamente mediante **Variables de Entorno** (`DATA_ENCRYPTION_KEY`) en el servidor de producción.

### 4.2 Generación

- Las claves deben ser de **256 bits (32 bytes)** generadas mediante generadores de números pseudoaleatorios criptográficamente seguros (CSPRNG).
- Formato: Cadena hexadecimal de 64 caracteres.

### 4.3 Rotación y Compromiso

- En caso de sospecha de compromiso de la clave, se deberá ejecutar el procedimiento de **Rotación de Claves de Emergencia** (re-cifrado masivo de la base de datos con nueva clave).

## 5. Controles de Acceso COPPA

Además del cifrado en reposo, se implementan controles de acceso basados en el estado del **Consentimiento Parental (COPPA)**:

### 5.1 Restricciones de Modificación

Los siguientes módulos están **bloqueados** si el consentimiento parental no está en estado `granted` (Aprobado):

- ❌ Agregar/Editar Datos de Salud (`agregar-salud.php`)
- ❌ Agregar Incidentes de Salud (`agregar-reporte.php`)
- ❌ Registrar Health Check Diario (Calendario de salud)

### 5.2 Implementación Técnica

- **Validación Backend:** Los endpoints PHP verifican el estado COPPA antes de procesar solicitudes.
- **Validación Frontend:** Los botones de acción se ocultan y se muestra un mensaje informativo cuando el consentimiento no está aprobado.
- **Mensaje al Usuario:**  
  > ⚠️ No se puede modificar información de salud porque el consentimiento COPPA está **[Pendiente/Revocado]**.

---

**Aprobado por:** Manuel Martinez
**Última revisión:** 19 de Enero 2026
