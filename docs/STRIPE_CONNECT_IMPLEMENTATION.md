# Implementación de Stripe Connect - Módulo de Finanzas

**Fecha:** Marzo 2026
**Versión:** 2.0
**Estado:** Implementado

---

## Tabla de Contenidos

1. [Resumen Ejecutivo](#resumen-ejecutivo)
2. [Estado Anterior (Problemas)](#estado-anterior-problemas)
3. [Estado Actual (Solución)](#estado-actual-solución)
4. [Arquitectura del Sistema](#arquitectura-del-sistema)
5. [Variables de Entorno](#variables-de-entorno)
6. [Flujo de Pagos](#flujo-de-pagos)
7. [Archivos Modificados](#archivos-modificados)
8. [Guía de Configuración](#guía-de-configuración)
9. [Guía de Pruebas](#guía-de-pruebas)
10. [Troubleshooting](#troubleshooting)

---

## Resumen Ejecutivo

Se implementó una solución correcta de Stripe Connect con `application_fee` para que Acuarela pueda cobrar automáticamente su comisión de $0.50 USD por cada transacción procesada a través de la plataforma.

### Cambios Principales

- ✅ Cuenta destino dinámica (usa `idStripe` del daycare, no hardcodeada)
- ✅ Comisión de Acuarela automatizada con `application_fee`
- ✅ Variables de entorno configurables
- ✅ Uso de Checkout Session (en lugar de Payment Links)
- ✅ Documentación completa

---

## Estado Anterior (Problemas)

### Problema 1: Cuenta Destino Hardcodeada

```php
// ANTES - set/createPaymentLink.php
'transfer_data' => [
    'destination' => 'acct_1HS0yeEQeRGcldhl',  // ❌ CUENTA FIJA
    'amount' => $tax
]
```

**Consecuencia:** TODOS los pagos de TODOS los daycares iban a la MISMA cuenta, sin importar qué daycare generó el cobro.

### Problema 2: API Keys Hardcodeadas

```php
// ANTES - Múltiples archivos
'Authorization: Basic c2tfdGVzdF9KYUl2UWt3dG5ueFBNNmlRdk5rNGQ1cE06'
```

**Consecuencia:** Las credenciales estaban expuestas en el código fuente y no podían cambiarse sin modificar el código.

### Problema 3: Cálculo de Comisiones en Frontend

```javascript
// ANTES - main.js
let price = amount * 100;
let commission = price * 0.029 + 30;
let tax = price - commission - 50;
let finalAmount = Math.round(tax);
```

**Consecuencia:** El cálculo de comisiones era manual e inseguro (podía manipularse desde el cliente).

### Problema 4: Sin application_fee Real

El sistema anterior intentaba "descontar" la comisión restando $0.50 del monto a transferir, pero **esa comisión nunca llegaba a Acuarela**. Solo reducía lo que recibía el daycare.

---

## Estado Actual (Solución)

### Solución 1: Cuenta Destino Dinámica

```php
// AHORA - set/createPaymentLink.php
$a = new Acuarela();
$daycareInfo = $a->daycareInfo;
$idStripe = $daycareInfo->idStripe;  // ✅ Cuenta del daycare actual

'transfer_data' => [
    'destination' => $idStripe  // ✅ Dinámico por daycare
]
```

### Solución 2: Variables de Entorno

```php
// AHORA - Todos los archivos Stripe
$stripeSecretKey = Env::get('STRIPE_SECRET_KEY');
$applicationFee = (int) Env::get('STRIPE_APPLICATION_FEE', 50);
```

### Solución 3: application_fee de Stripe Connect

```php
// AHORA - set/createPaymentLink.php
'payment_intent_data' => [
    'application_fee_amount' => $applicationFee,  // ✅ Comisión automática
    'transfer_data' => [
        'destination' => $idStripe
    ]
]
```

### Solución 4: Checkout Session

Se usa Checkout Session en lugar de Payment Links porque soporta `application_fee` directamente:

```php
// AHORA
curl_setopt_array($curl, [
    CURLOPT_URL => 'https://api.stripe.com/v1/checkout/sessions',
    // ...
]);
```

---

## Arquitectura del Sistema

```
┌─────────────────────────────────────────────────────────────────────────────┐
│                    ARQUITECTURA STRIPE CONNECT                               │
├─────────────────────────────────────────────────────────────────────────────┤
│                                                                             │
│  ┌─────────────────────────────────────────────────────────────────────┐   │
│  │                    CUENTA PLATAFORMA (ACUARELA)                     │   │
│  │                                                                     │   │
│  │  • Recibe: Comisión de $0.50 por transacción (application_fee)      │   │
│  │  • Producto: "Pago de Servicios de Guardería" (prod_xxx)            │   │
│  │  • Configuración: STRIPE_SECRET_KEY, STRIPE_PLATFORM_ACCOUNT       │   │
│  └─────────────────────────────────────────────────────────────────────┘   │
│                                    │                                        │
│                                    │ application_fee                        │
│                                    ▼                                        │
│  ┌─────────────────────────────────────────────────────────────────────┐   │
│  │                    STRIPE (Procesador de Pagos)                     │   │
│  │                                                                     │   │
│  │  • Cobra al padre: $200.00                                          │   │
│  │  • Comisión Stripe: -$5.80 (2.9% + $0.30)                          │   │
│  │  • Comisión Acuarela: -$0.50 (application_fee)                      │   │
│  │  • Transfiere al daycare: $193.70                                   │   │
│  └─────────────────────────────────────────────────────────────────────┘   │
│                                    │                                        │
│                                    │ transfer_data                          │
│                                    ▼                                        │
│  ┌─────────────────────────────────────────────────────────────────────┐   │
│  │                    CUENTAS CONECTADAS (DAYCARES)                    │   │
│  │                                                                     │   │
│  │  Daycare A → acct_111 → Recibe $193.70 de pago de $200             │   │
│  │  Daycare B → acct_222 → Recibe $145.35 de pago de $150             │   │
│  │  Daycare C → acct_333 → Recibe $290.70 de pago de $300             │   │
│  │                                                                     │   │
│  │  Cada daycare tiene su idStripe guardado en Strapi                 │   │
│  └─────────────────────────────────────────────────────────────────────┘   │
│                                                                             │
└─────────────────────────────────────────────────────────────────────────────┘
```

### Componentes

| Componente | Archivo | Función |
|------------|---------|---------|
| **Env** | `includes/env.php` | Carga variables de entorno desde `.env` |
| **SDK** | `includes/sdk.php` | Acceso a `daycareInfo->idStripe` |
| **createPrices** | `set/createPrices.php` | Crea precio dinámico en Stripe |
| **createPaymentLink** | `set/createPaymentLink.php` | Crea Checkout Session con `application_fee` |
| **createproduct** | `set/createproduct.php` | Crea producto genérico (usar una vez) |
| **account** | `marketplace/account.php` | Crea cuenta conectada para daycare |
| **account_link** | `marketplace/account_link.php` | Genera URL de onboarding |
| **Frontend** | `js/main.js` | Maneja flujo de creación de cobros |

---

## Variables de Entorno

### Configuración en `.env`

```env
# Stripe
# API key secreta de Stripe (sk_test_xxx para pruebas, sk_live_xxx para producción)
STRIPE_SECRET_KEY=

# ID de la cuenta de plataforma de Acuarela (donde se reciben las comisiones)
# Se obtiene en: https://dashboard.stripe.com/settings/account
STRIPE_PLATFORM_ACCOUNT=

# ID del producto para crear enlaces de pago
# Crear producto: acceder a s/createproduct.php?name=Pago%20Servicios
# O crear manualmente en Stripe Dashboard
STRIPE_PAYMENT_PRODUCT_ID=

# Comisión que Acuarela cobra por transacción (en centavos)
# 50 = $0.50 USD | 100 = $1.00 USD
STRIPE_APPLICATION_FEE=50

# URL base de la aplicación
APP_URL=https://bilingualchildcaretraining.com
```

### Descripción de Variables

| Variable | Obligatoria | Descripción |
|----------|-------------|-------------|
| `STRIPE_SECRET_KEY` | ✅ Sí | API key secreta de Stripe |
| `STRIPE_PLATFORM_ACCOUNT` | ⚠️ Recomendada | ID de cuenta plataforma (acct_xxx) |
| `STRIPE_PAYMENT_PRODUCT_ID` | ✅ Sí | ID del producto para pagos (prod_xxx) |
| `STRIPE_APPLICATION_FEE` | ⚠️ Opcional | Comisión en centavos (default: 50) |
| `APP_URL` | ✅ Sí | URL base para callbacks |

---

## Flujo de Pagos

### Flujo Completo de Creación de Cobro

```
┌─────────────────────────────────────────────────────────────────────────────┐
│  FLUJO: CREAR COBRO A PADRE                                                 │
├─────────────────────────────────────────────────────────────────────────────┤
│                                                                             │
│  PASO 1: Usuario (Daycare) crea cobro                                       │
│  ─────────────────────────────────────────                                  │
│  • Accede a: Finanzas → Pagos → Crear Pago                                 │
│  • Completa: Concepto, Padre, Fecha, Monto ($200)                          │
│  • Clic: "Crear pago"                                                       │
│                                                                             │
│                    │                                                        │
│                    ▼                                                        │
│                                                                             │
│  PASO 2: main.js - handleAddMovement()                                      │
│  ─────────────────────────────────────                                      │
│  • POST a s/createPayLink/ → Crea movimiento pendiente en Strapi           │
│  • GET a s/createPrices/?price=20000 → Crea precio en Stripe               │
│  • GET a s/createPaymentLink/?id=price_xxx&amount=20000                    │
│                                                                             │
│                    │                                                        │
│                    ▼                                                        │
│                                                                             │
│  PASO 3: createPrices.php                                                   │
│  ──────────────────────────                                                 │
│  • Lee STRIPE_SECRET_KEY y STRIPE_PAYMENT_PRODUCT_ID de .env               │
│  • POST https://api.stripe.com/v1/prices                                   │
│    {                                                                        │
│      "currency": "usd",                                                     │
│      "unit_amount": 20000,                                                  │
│      "product": "prod_xxx"                                                  │
│    }                                                                        │
│  • Retorna: { "id": "price_abc123" }                                        │
│                                                                             │
│                    │                                                        │
│                    ▼                                                        │
│                                                                             │
│  PASO 4: createPaymentLink.php                                              │
│  ──────────────────────────────                                             │
│  • Lee STRIPE_SECRET_KEY, STRIPE_APPLICATION_FEE, APP_URL de .env          │
│  • Obtiene idStripe del daycare: $a->daycareInfo->idStripe                 │
│  • POST https://api.stripe.com/v1/checkout/sessions                        │
│    {                                                                        │
│      "mode": "payment",                                                     │
│      "line_items": [{ "price": "price_abc123", "quantity": 1 }],           │
│      "payment_intent_data": {                                               │
│        "application_fee_amount": 50,                                        │
│        "transfer_data": { "destination": "acct_daycare" }                  │
│      },                                                                     │
│      "success_url": "...?payment=success",                                 │
│      "cancel_url": "...?payment=cancelled"                                 │
│    }                                                                        │
│  • Retorna: { "url": "https://checkout.stripe.com/xxx" }                   │
│                                                                             │
│                    │                                                        │
│                    ▼                                                        │
│                                                                             │
│  PASO 5: Email al Padre                                                     │
│  ─────────────────────────                                                  │
│  • sendPendingNotification(result.url)                                     │
│  • POST a s/pendingMovementsEmail/                                          │
│    {                                                                        │
│      "email": "padre@email.com",                                            │
│      "link": "https://checkout.stripe.com/xxx",                            │
│      "amount": "200"                                                        │
│    }                                                                        │
│                                                                             │
│                    │                                                        │
│                    ▼                                                        │
│                                                                             │
│  PASO 6: Padre Paga                                                         │
│  ─────────────────────                                                      │
│  • Padre abre enlace                                                        │
│  • Completa datos de tarjeta                                                │
│  • Pago procesado por Stripe                                                │
│                                                                             │
│                    │                                                        │
│                    ▼                                                        │
│                                                                             │
│  PASO 7: Distribución Automática                                            │
│  ────────────────────────────                                               │
│  Padre paga: $200.00                                                        │
│       │                                                                     │
│       ├─▶ Stripe retiene: $5.80 (2.9% + $0.30)                             │
│       │                                                                     │
│       ├─▶ Acuarela recibe: $0.50 (application_fee)                         │
│       │    └─▶ Depositado en cuenta plataforma                             │
│       │                                                                     │
│       └─▶ Daycare recibe: $193.70 (transfer_data)                          │
│            └─▶ Depositado en su cuenta conectada                           │
│                                                                             │
└─────────────────────────────────────────────────────────────────────────────┘
```

### Flujo de Vinculación de Cuenta Stripe (Daycare)

```
┌─────────────────────────────────────────────────────────────────────────────┐
│  FLUJO: VINCULAR CUENTA STRIPE (Una vez por daycare)                        │
├─────────────────────────────────────────────────────────────────────────────┤
│                                                                             │
│  PASO 1: Usuario accede a Configuración → Métodos de pago                  │
│                                                                             │
│  PASO 2: Clic en "Activar pagos electrónicos"                              │
│       │                                                                     │
│       ▼                                                                     │
│  PASO 3: marketplace/account.php                                            │
│       │  • Crea cuenta conectada en Stripe                                  │
│       │  • Retorna: { "account": "acct_xxx" }                               │
│       ▼                                                                     │
│  PASO 4: marketplace/account_link.php                                       │
│       │  • Genera URL de onboarding                                         │
│       │  • Redirige a Stripe para completar datos                          │
│       ▼                                                                     │
│  PASO 5: Usuario completa formulario en Stripe                              │
│       │  • Datos bancarios                                                  │
│       │  • Información fiscal                                               │
│       │  • Verificación de identidad                                        │
│       ▼                                                                     │
│  PASO 6: Stripe redirige a return-to-app.php?id=acct_xxx                   │
│       │                                                                     │
│       ▼                                                                     │
│  PASO 7: Se guarda idStripe en Strapi (daycare.idStripe)                   │
│       │                                                                     │
│       ▼                                                                     │
│  PASO 8: stripeConfig.php confirma vinculación exitosa                     │
│                                                                             │
└─────────────────────────────────────────────────────────────────────────────┘
```

---

## Archivos Modificados

### Archivos PHP

| Archivo | Cambios |
|---------|---------|
| `set/createPaymentLink.php` | Reescrito: usa Checkout Session, application_fee, idStripe dinámico |
| `set/createPrices.php` | Actualizado: usa variables de entorno, validaciones |
| `set/createproduct.php` | Actualizado: usa variables de entorno, documentación |
| `marketplace/account.php` | Actualizado: usa variables de entorno, tipo express |
| `marketplace/account_link.php` | Actualizado: usa variables de entorno, APP_URL dinámico |

### Archivos JavaScript

| Archivo | Cambios |
|---------|---------|
| `js/main.js` | Eliminado cálculo manual de comisiones, usa `amount` completo |

### Archivos de Configuración

| Archivo | Cambios |
|---------|---------|
| `.env.example.txt` | Agregadas variables de Stripe con documentación |

---

## Guía de Configuración

### Requisitos Previos

- Cuenta de Stripe (https://dashboard.stripe.com)
- Stripe Connect habilitado en la cuenta
- Acceso al servidor donde está alojado Acuarela

### Paso 1: Crear Cuenta de Stripe

1. Ir a https://dashboard.stripe.com/register
2. Completar registro con email y datos de negocio
3. Verificar cuenta según las instrucciones de Stripe

### Paso 2: Habilitar Stripe Connect

1. En el Dashboard de Stripe, ir a **Developers** → **Connect** → **Settings**
2. Habilitar **Express** o **Custom** accounts
3. Configurar branding y URLs de redirección

### Paso 3: Obtener API Keys

1. Ir a **Developers** → **API Keys**
2. Copiar **Secret key** (empieza con `sk_test_` o `sk_live_`)
3. Agregar a `.env`:
   ```
   STRIPE_SECRET_KEY=sk_test_tu_api_key
   ```

### Paso 4: Crear Producto Genérico

**Opción A: Usando el script**

1. Acceder a: `https://tu-dominio.com/miembros/acuarela-app-web/s/createproduct.php?name=Pago%20Servicios%20Guarderia`
2. Copiar el ID retornado (ej: `prod_abc123`)

**Opción B: Manualmente en Stripe Dashboard**

1. Ir a **Products** → **Add product**
2. Nombre: "Pago de Servicios de Guardería"
3. Tipo: **Service**
4. Guardar y copiar el ID

5. Agregar a `.env`:
   ```
   STRIPE_PAYMENT_PRODUCT_ID=prod_abc123
   ```

### Paso 5: Obtener ID de Cuenta Plataforma

1. Ir a **Settings** → **Account details**
2. Copiar el **Account ID** (empieza con `acct_`)
3. Agregar a `.env`:
   ```
   STRIPE_PLATFORM_ACCOUNT=acct_tu_cuenta
   ```

### Paso 6: Configurar URL de la Aplicación

```
APP_URL=https://tu-dominio.com
```

### Paso 7: Configurar Comisión

```
STRIPE_APPLICATION_FEE=50
```

| Valor | Comisión |
|-------|----------|
| 50 | $0.50 USD |
| 100 | $1.00 USD |
| 25 | $0.25 USD |

### Paso 8: Verificar Configuración

```env
# .env final
STRIPE_SECRET_KEY=sk_test_xxxxxxxxxxxxx
STRIPE_PLATFORM_ACCOUNT=acct_xxxxxxxxxxxxx
STRIPE_PAYMENT_PRODUCT_ID=prod_xxxxxxxxxxxxx
STRIPE_APPLICATION_FEE=50
APP_URL=https://tu-dominio.com
```

---

## Guía de Pruebas

### Modo Test vs Modo Live

| Modo | API Key | Uso |
|------|---------|-----|
| **Test** | `sk_test_xxx` | Desarrollo y pruebas |
| **Live** | `sk_live_xxx` | Producción |

### Tarjetas de Prueba

| Número | Resultado |
|--------|-----------|
| `4242 4242 4242 4242` | ✅ Pago exitoso |
| `4000 0000 0000 0002` | ❌ Pago declinado |
| `4000 0000 0000 9995` | ❌ Fondos insuficientes |
| `4000 0025 0000 3155` | ⚠️ Requiere autenticación 3D |

**Datos adicionales:**
- Cualquier fecha futura (MM/AA)
- Cualquier CVC (3 dígitos)
- Cualquier código postal

### Prueba 1: Vincular Cuenta de Daycare

1. Iniciar sesión como usuario PRO
2. Ir a **Configuración** → **Métodos de pago**
3. Clic en "Activar pagos electrónicos"
4. Completar onboarding de Stripe (en modo test, usar datos de prueba)
5. Verificar que se guarda `idStripe` en el daycare

### Prueba 2: Crear Cobro

1. Ir a **Finanzas** → **Pagos**
2. Clic en "Crear Pago"
3. Llenar formulario:
   - Concepto: "Matrícula prueba"
   - Padre: Seleccionar de la lista
   - Fecha: Hoy
   - Monto: $100
4. Clic en "Crear pago"
5. Verificar que se envía email con enlace

### Prueba 3: Completar Pago

1. Abrir enlace de pago recibido
2. Usar tarjeta de prueba: `4242 4242 4242 4242`
3. Completar datos
4. Verificar:
   - Stripe Dashboard → Payments → Pago aparece
   - **Application fee**: $0.50
   - **Transfer**: $93.70 al daycare

### Verificar Distribución

En Stripe Dashboard:

```
Payment: $100.00
    │
    ├─▶ Stripe fee: -$3.20 (2.9% + $0.30)
    │
    ├─▶ Application fee: $0.50 → Tu cuenta plataforma
    │
    └─▶ Net transfer: $96.30 → Cuenta daycare
```

---

## Troubleshooting

### Error: "Daycare no tiene cuenta Stripe vinculada"

**Causa:** El daycare no completó el proceso de vinculación.

**Solución:**
1. Ir a Configuración → Métodos de pago
2. Completar el onboarding de Stripe
3. Verificar que `idStripe` se guardó en Strapi

### Error: "Stripe configuration missing: STRIPE_SECRET_KEY"

**Causa:** Variable de entorno no configurada.

**Solución:**
1. Verificar que `.env` existe en la raíz del proyecto
2. Agregar `STRIPE_SECRET_KEY=sk_test_xxx`
3. Reiniciar el servidor web

### Error: "Invalid or missing price"

**Causa:** El monto del pago es inválido.

**Solución:**
1. Verificar que el monto sea mayor a $0
2. El monto se convierte a centavos automáticamente

### Error: "Error connecting to Stripe"

**Causa:** Problema de conexión con la API de Stripe.

**Solución:**
1. Verificar conexión a internet
2. Verificar que la API key sea válida
3. Revisar logs del servidor: `/logs/`

### El padre no recibe el email

**Causa:** Problema con Mandrill o configuración de email.

**Solución:**
1. Verificar `MANDRILL_API_KEY` en `.env`
2. Revisar logs de Mandrill
3. Verificar que el email del padre sea válido

### La comisión no llega a la cuenta plataforma

**Causa:** `application_fee` no está configurado correctamente.

**Solución:**
1. Verificar `STRIPE_APPLICATION_FEE` en `.env`
2. Verificar que la cuenta plataforma esté habilitada para Connect
3. Revisar en Stripe Dashboard → Connect → Application fees

---

## Referencias

- [Stripe Connect Documentation](https://stripe.com/docs/connect)
- [Checkout Session API](https://stripe.com/docs/api/checkout/sessions)
- [Application Fees](https://stripe.com/docs/connect/application-fees)
- [Stripe Testing](https://stripe.com/docs/testing)

---

## Historial de Cambios

| Fecha | Versión | Cambios |
|-------|---------|---------|
| Mar 2026 | 2.0 | Implementación completa con application_fee |
| - | 1.0 | Versión inicial (con problemas) |

---

**Documento generado automáticamente - Acuarela Development Team**
