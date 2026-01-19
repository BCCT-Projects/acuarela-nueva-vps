# 🤖 Reglas de Arquitectura - SDKs Acuarela

Este proyecto maneja una arquitectura de doble SDK. Es CRÍTICO diferenciar cuál usar dependiendo de la tarea.

## 1. SDK Antiguo (Legacy/Auth)

**Ubicación:** `miembros/includes/sdk.php`

**Uso Exclusivo:**

- 🔐 **Autenticación y Login**
- 🛡️ **Doble Factor de Autenticación (2FA)**
- 👤 **Gestión de Sesiones de Usuario**

**Características:**

- No contiene lógica moderna de la aplicación.
- No gestiona el cifrado de datos (CryptoService).
- No carga automáticamente el archivo `.env` del directorio web app.

---

## 2. SDK Nuevo (App/Logic)

**Ubicación:** `miembros/acuarela-app-web/includes/sdk.php`

**Uso Principal:**

- 📱 **Lógica de la Aplicación Web**
- 🔒 **Servicios de Cifrado (CryptoService)**
- 📅 **Inscripciones, Grupos, Niños, Asistencia**
- 🏥 **Datos de Salud y Consentimientos**

**Características:**

- ✅ Contiene los métodos `initCrypto()`, `encryptChildData()`, `decryptChildData()`.
- ✅ Carga variables de entorno desde `.env`.
- ✅ Implementa borrado en cascada y lógicas complejas de negocio.

---

## ⚠️ Regla de Oro

- Si estás trabajando en **Login/2FA**: Usa `miembros/includes/sdk.php`.
- Si estás trabajando en **Cualquier otra cosa (App Web)**: Usa `miembros/acuarela-app-web/includes/sdk.php`.
- **NUNCA** intentes usar métodos de cifrado con el SDK Antiguo.
