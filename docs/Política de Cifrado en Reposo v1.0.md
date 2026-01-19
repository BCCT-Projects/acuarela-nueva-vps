# Política de Cifrado en Reposo - Acuarela

**Versión:** 1.0
**Fecha de Vigencia:** Enero 2026
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

| Tipo de Dato | Campos Específicos | Justificación |
| :--- | :--- | :--- |
| **Identidad del Menor** | `birthday` (Fecha Nacimiento) | Dato crítico para identificación única. |
| **Salud del Menor** | `healthinfos` (Alergias, medicamentos, incidentes) | Información médica sensible (HIPAA compliant approach). |
| **Contacto Padres** | `phone` (Teléfono) | Dato de contacto directo primario. |

### 2.2 Datos Protegidos Mediante Anonimización

Los siguientes activos se protegen eliminando metadatos identificables:

| Tipo de Dato | Estrategia | Justificación |
| :--- | :--- | :--- |
| **Archivos Adjuntos** | Renombramiento Aleatorio (Hashing) | Se eliminan nombres reales de archivos (ej: `Foto_Juan.jpg` -> `a8f92bd.jpg`) antes del almacenamiento. Esto impide identificar al sujeto solo por acceder al sistema de archivos. |

### 2.3 Excepciones Justificadas (Datos NO Cifrados)

Se ha decidido explícitamente **NO cifrar** los siguientes datos tras un análisis de riesgo/operatividad:

| Tipo de Dato | Justificación de Riesgo Aceptado | Control Compensatorio |
| :--- | :--- | :--- |
| **Nombre del Menor** (`name`, `lastname`) | Necesario para indexación y búsquedas rápidas en base de datos. El cifrado impediría funciones críticas de búsqueda de alumnos por parte del personal. | Control de acceso estricto a nivel de aplicación (Roles y Permisos). |
| **Email de Padres** | **Riesgo Sistémico:** Cifrar el email (que es el ID de usuario) rompería la integración con sistemas externos de autenticación (Auth0/Firebase) y servicios de correo transaccional (Mandrill). | El email se trata como identificador público dentro del sistema. Se protege mediante TLS en tránsito. |
| **Archivos Binarios (Cuerpo)** | **Complejidad Técnica y Operativa:** Cifrar el contenido binario de imágenes impediría el uso de funcionalidades nativas del CMS (redimensionado, miniaturas, optimización CDN). El impacto en el rendimiento (tiempos de carga) y la complejidad de mantenimiento se considera desproporcionado al riesgo. | **Anonimización de nombres** (ver 2.2) y restricción de acceso a carpetas de uploads mediante configuración del servidor web. |

## 3. Estándar Técnico de Cifrado

### 3.1 Algoritmo

Todo cifrado realizado bajo esta política utiliza el siguiente estándar criptográfico robusto:

- **Algoritmo:** AES-256-CBC (Advanced Encryption Standard).
- **Modo:** Cipher Block Chaining (CBC).
- **IV (Vector de Inicialización):** Aleatorio y único por registro (16 bytes), almacenado junto al texto cifrado.
- **Librería:** OpenSSL (vía PHP `openssl_encrypt`).

### 3.2 Implementación

El cifrado se realiza a **nivel de aplicación** (Application Update Layer) antes de que los datos sean enviados a la base de datos.

- **Servicio:** `CryptoService.php` (Helper centralizado).
- **Flujo de Escritura:** `Dato Plano` -> `CryptoService::encrypt()` -> `Base de Datos`.
- **Flujo de Lectura:** `Base de Datos` -> `CryptoService::decrypt()` -> `Vista de Usuario`.

## 4. Gestión de Llaves (Key Management)

### 4.1 Almacenamiento

- La **Clave Maestra de Cifrado (DEK)** NUNCA se almacena en el código fuente ni en la base de datos.
- Se inyecta exclusivamente mediante **Variables de Entorno** (`DATA_ENCRYPTION_KEY`) en el servidor de producción.

### 4.2 Generación

- Las claves deben ser de **256 bits (32 bytes)** generadas mediante generadores de números pseudoaleatorios criptográficamente seguros (CSPRNG).
- Formato: Cadena hexadecimal de 64 caracteres.

### 4.3 Rotación y Compromiso

- En caso de sospecha de compromiso de la clave, se deberá ejecutar el procedimiento de **Rotación de Claves de Emergencia** (re-cifrado masivo de la base de datos con nueva clave).

---
**Aprobado por:** Equipo de Ingeniería y Seguridad Acuarela.
