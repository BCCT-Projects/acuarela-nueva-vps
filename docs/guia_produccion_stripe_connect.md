# 🚀 Guía de Pase a Producción: Acuarela Finanzas (Stripe Connect)

Esta guía detalla el proceso exacto, y las responsabilidades divididas, para llevar el módulo de pagos de Daycares a producción real sin afectar los ingresos actuales de suscripciones.

## 📖 Contexto Actual de la Plataforma

Actualmente, el módulo de Finanzas de Acuarela ha sido diseñado e implementado con éxito operando en un **entorno de desarrollo (Test Mode)**. El núcleo principal de esta tecnología es la integración con la suite **Stripe Connect (Modelo Marketplace)**.

**¿Qué se ha logrado hasta ahora?**
* **Vinculación Descentralizada:** Los diferentes usuarios (Daycares) pueden conectar sus cuentas bancarias a través de nuestro portal y completar su perfil fiscal (*Onboarding*).
* **Cobros Personalizados ("Al vuelo"):** Los Daycares pueden generar enlaces de pago por montos y conceptos completamente arbitrarios y variables, sin inflar ni depender de un catálogo de productos estático en la cuenta matriz de la empresa.
* **Sistema Inteligente de Retención de Comisiones (Fees):** El sistema fue programado para identificar y aplicar reglas de negocio sobre cada enlace creado:
  * Las suscripciones gratuitas (**LITE**) reciben retenciones automatizadas de la cuota transaccional de Stripe (2.9% + $0.30) sumado a la comisión propia de nuestra plataforma ($0.50 USD). 
  * Las suscripciones **PRO** (que pagan un plan independiente) evaden dicha comisión cruzada y procesan sus ingresos pagando únicamente la comisión base transaccional de Stripe. 

**¿Por qué es necesario el Pase a Producción?**
El ecosistema ya ha validado flujos críticos, cálculos y estabilización de sesión segura detrás de la infraestructura, pero opera con tarjetas de prueba e ingresos ficticios bajo una cuenta de desarrollador. **Pasar a Producción (Live Mode)** significa transicionar este código, bajo estricta titularidad legal de sus dueños de negocio, hacia un ecosistema habilitado para procesar fondos reales, enviar *payouts* a las cuentas de los Daycares y cumplir con los reportes impositivos del organismo regulador estadounidense (IRS). 

Para lograrlo de manera profesional, estructurada y exenta de contingencias cruzadas, se estipula el siguiente flujo.

---

## 🎯 1. La Estrategia Recomendada

La estrategia ideal es **crear una NUEVA cuenta (o "Proyecto") llamada "Acuarela Marketplace"** dentro del inicio de sesión oficial de Stripe que ya usan los gerentes. 

**¿Por qué no usar la cuenta de prueba actual?**
Porque la cuenta de prueba fue creada por un desarrollador con su correo. Las cuentas de producción manejan responsabilidades fiscales (IRS), por lo que **el dueño debe ser el creador legal de la cuenta**.

**¿Por qué no usar "Child Care Training" directamente?**
"Child Care Training" debe quedarse trabajando al 100% como lo hace hoy: cobrando exclusivamente las suscripciones LITE/PRO del software. Al crear dentro del mismo Stripe una sub-cuenta o proyecto nuevo llamado "Acuarela Marketplace", lograrás que las comisiones de los Daycares ($0.50) caigan allí, manteniendo la contabilidad limpia y 100% separada.

---

## 👨‍💼 2. Tareas del Dueño del Negocio / Representante Legal

El desarrollador **no debe** ingresar datos bancarios ni completar formularios legales. Stripe exige información corporativa o personal altamente confidencial (Número de Identificación de Empleador EIN, Seguro Social, Escaneo de Pasaportes, etc.), la cual debe ser suministrada por la entidad correspondiente. 

El dueño legal de la empresa debe entrar a Stripe (con su usuario administrador principal) y hacer lo siguiente:

1. **Crear el entorno:** En la esquina superior izquierda, darle a "Nueva Cuenta" o "Nuevo Proyecto" y nombrarlo **"Acuarela Marketplace"**.
2. **Activar pagos:** Quitar el modo de prueba (Test Mode) en esta nueva cuenta y darle click a "Activar pagos".
3. **Verificación KYC:** Llenar el formulario legal de Stripe con los datos corporativos de la empresa y asociar la **cuenta bancaria real** donde caerán las comisiones.
4. **Activar Connect:** Ir a **Más > Connect** y completar el perfil de la plataforma (Logo, colores, enlaces, términos de servicio).

---

## 👨‍💻 3. Tareas del Desarrollador

Una vez que el dueño o responsable técnico confirme que la cuenta "Acuarela" (o "Acuarela Marketplace") ya está validada y documentada formalmente en Stripe, el desarrollador procederá a realizar la configuración técnica:

1. **Obtener las llaves de Producción (Live API Keys):**
   - Asegurarse de seleccionar la nueva cuenta "Acuarela" en el panel y que el *Test Mode* esté apagado.
   - Ir a **Desarrolladores > Claves de API**.
   - Copiar la `Secret key` de producción (comienza con `sk_live_...`).

2. **Obtener el ID de la Plataforma:**
   - Ir a **Configuración > Perfil de la cuenta**.
   - Copiar el ID principal de la plataforma, que comienza con `acct_...` (Este será el valor de la variable `STRIPE_PLATFORM_ACCOUNT` requerida para que Stripe sepa a dónde direccionar las comisiones base de Acuarela).

3. **Actualizar el Servidor (VPS):**
   - Ingresar al archivo `.env` del servidor en el entorno de producción.
   - Reemplazar las variables `STRIPE_SECRET_KEY` y `STRIPE_PLATFORM_ACCOUNT` con las claves Live obtenidas en el paso anterior.
   - Confirmar o agregar `APP_URL=https://acuarela.app` en el archivo `.env`.

4. **Configurar los Webhooks (Opcional, de cara a automatizaciones futuras):**
   - Bajo la nueva cuenta Acuarela (Live), dirigirse a **Desarrolladores > Webhooks**.
   - Añadir un nuevo *endpoint* apuntando a la URL destino de Acuarela (ej. `https://acuarela.app/webhooks/connect.php`).
   - Seleccionar los eventos a escuchar (ej: `payment_intent.succeeded`, `account.updated`).

---

## 🚦 4. Prueba Final (En Producción Real)

Para asegurar que todo quedó perfecto, deben hacer una prueba del flujo en caliente (con dinero real):

1. **Conectar un Daycare Real:**
   Entrar al portal `acuarela.app` con una cuenta o daycare de acceso real, navegar a Finanzas y ejecutar el proceso "Conectar con Stripe". Es imprescindible que los datos de onboarding sean llenados con la información verídica de quien recibirá los fondos (no se permite el envío de datos de prueba "falsos" en producción).

2. **Generar un pago real de $1.00 USD:**
   Se debe generar un enlace de pago por un monto comprobatorio (ej. 1 dólar) y completarlo con una tarjeta de crédito real, con el fin de verificar que:
   - El padre visualiza la interfaz y monto correctamente.
   - El sistema disgrega correctamente la comisión estipulada ($0.50 para LITE + fees de Stripe).
   - El importe líquido alcanza adecuadamente el saldo (Balance) del Daycare.

Siguiendo esta guía, las finanzas de múltiples canales se mantienen separadas contablemente, y la responsabilidad civil/fiscal del perfil es asumida de forma correcta por los representantes legales de la empresa titular como dictan los mandatos de seguridad vigentes.
