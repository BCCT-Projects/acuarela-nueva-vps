# Documentación de Implementación de 2FA (Doble Autenticación)

## Descripción General
Se ha implementado un sistema robusto de Autenticación de Dos Factores (2FA) basado en correo electrónico para el portal de miembros. Este sistema cumple con estándares de seguridad al asegurar que, incluso si una contraseña es comprometida, el atacante no pueda acceder sin el código de verificación único enviado al correo del usuario.

## Flujo de Seguridad ("Cuarentena de Sesión")

Para garantizar la máxima seguridad sin modificar la estructura de la base de datos (Strapi), implementamos un mecanismo de cuarentena de sesión en PHP:

1.  **Validación de Credenciales (`login.php`):**
    *   El usuario ingresa email y contraseña.
    *   Si son correctos, el sistema obtiene los datos del usuario pero **NO inicia la sesión final**.
    *   Se genera un código aleatorio de 6 dígitos.
    *   Se guarda una copia de los datos de sesión en una variable temporal (`$_SESSION['temp_2fa']`) y se **destruyen** las variables de sesión activas (`$_SESSION['user']`, etc.).
    *   Se envía el código por correo electrónico (vía Mandrill).
    *   Se retorna al frontend la instrucción de pedir el código.

2.  **Interfaz de Usuario (`index.php` & `main.js`):**
    *   El formulario de login se oculta.
    *   Aparece el formulario de verificación de código.
    *   Se incluye un temporizador de 60 segundos para reenviar el código si es necesario.

3.  **Verificación (`verify_2fa.php`):**
    *   El usuario ingresa el código.
    *   El backend verifica que coincida con el almacenado en `temp_2fa` y que no haya expirado (15 minutos).
    *   **Éxito:** Se restaura la sesión real desde la copia de seguridad y se permite el acceso al dashboard.
    *   **Fallo:** Se deniega el acceso.

4.  **Reenvío de Código (`resend_2fa.php`):**
    *   Permite generar un nuevo código si el anterior no llegó o expiró, siempre validando que exista una sesión temporal válida previa.

## Archivos Modificados y Creados

### Modificados
*   `miembros/index.php`: Se agregó el formulario HTML oculto para el ingreso del código 2FA.
*   `miembros/set/login.php`: Se alteró la lógica para interceptar el login exitoso, enviar el correo y activar el modo "Cuarentena".
*   `miembros/js/main.js`: Se agregó la lógica para manejar la respuesta del login, alternar formularios, manejar el temporizador y el reenvío de código.

### Creados
*   `miembros/set/verify_2fa.php`: Endpoint encargado de validar el código y restaurar la sesión.
*   `miembros/set/resend_2fa.php`: Endpoint para reenviar el código de verificación.

## Configuración de Correo (Mandrill)
*   **Template Slug:** `portal-miembros-2fa`
*   **Remitente:** `info@acuarela.app`
*   **Asunto:** Tu código de verificación

---

## Resumen para Publicación (Task Completion)

> **Implementación de MFA (2FA) Completada:**
> Se integró exitosamente la autenticación de dos factores vía correo electrónico en el portal de miembros. El sistema intercepta el login tradicional y coloca la sesión en "cuarentena" hasta que el usuario verifica su identidad con un código único de 6 dígitos. Incluye protección contra expiración (15 min), temporizador de reenvío (60s), manejo de errores en frontend y backend, y asegura que ningún usuario pueda navegar por la aplicación sin completar ambos pasos de seguridad. Todo implementado sin alterar el esquema de base de datos existente.
