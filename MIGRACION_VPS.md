# Migración de Acuarela a VPS DigitalOcean

## 📋 Tabla de Contenidos

1. [Contexto y Problema](#contexto-y-problema)
2. [Objetivo del Cambio](#objetivo-del-cambio)
3. [Alcance del Proyecto](#alcance-del-proyecto)
4. [Arquitectura Actual](#arquitectura-actual)
5. [Arquitectura Objetivo](#arquitectura-objetivo)
6. [Estrategia de Migración](#estrategia-de-migración)
7. [Integración con Portal de Miembros](#integración-con-portal-de-miembros)
8. [Conclusión](#conclusión)

---

## 1. Contexto y Problema

### Situación Actual

Actualmente **Acuarela** opera sobre **hosting compartido (cPanel)** en `bilingualchildcaretraining.com`, lo que implica limitaciones críticas:

#### ❌ Limitaciones Técnicas

- **Sin aislamiento real entre tenants**: Compartimos recursos con otros servicios
- **Sin control fino de firewall, red o procesos**: Configuración limitada por el proveedor
- **Sin logging centralizado ni monitoreo**: Dificulta auditoría y troubleshooting
- **Sin MFA a nivel sistema**: Dependemos de las capacidades del hosting compartido
- **Sin control de parches ni hardening**: Actualizaciones gestionadas por el proveedor
- **Riesgo elevado ante tráfico automatizado**: Bots o explotación lateral pueden afectar otros servicios

#### ❌ Incompatibilidad con Estándares

Este entorno **no es compatible** con:

- **SOC 2** (Control de seguridad y disponibilidad)
- **ISO/IEC 27001** (Gestión de seguridad de la información)
- **Buenas prácticas NIST CSF** (Marco de ciberseguridad)
- **Manejo seguro de datos de menores** (COPPA / SOPIPA)

### Estructura Actual de Servicios

Acuarela está dividido en **3 repositorios** que operan de forma separada:

1. **`acuarela-web-page`**: Página institucional
   - URL: `https://acuarela.app/`
   - Funcionalidad: Landing page, información institucional, marketing

2. **`portal-miembros`**: Portal de autenticación y gestión de miembros
   - URL: `https://bilingualchildcaretraining.com/miembros/`
   - Funcionalidad: Login, registro, perfil de usuario, dashboard

3. **`acuarela-app-web`**: Aplicación principal de gestión
   - URL: `https://bilingualchildcaretraining.com/miembros/acuarela-app-web/`
   - Funcionalidad: Gestión de daycare, inscripciones, asistencia, finanzas

---

## 2. Objetivo del Cambio

### Objetivo Principal

Migrar **Acuarela** a un entorno dedicado (**VPS en DigitalOcean**) que permita:

✅ **Aislamiento completo del sistema**  
✅ **Control total de red, sistema operativo y servicios**  
✅ **Implementación de controles de seguridad por capas**  
✅ **Base técnica sólida para auditoría, escalabilidad y continuidad**

### Objetivos Específicos

1. **Consolidación**: Unificar los 3 servicios en un solo entorno Docker
2. **Separación de dominios**: Separar servicios de `bilingualchildcaretraining.com` de `acuarela.app`
3. **Integración mantenida**: Mantener conexión entre `portal-miembros` y `acuarela-app-web` (similar a Bilingual Child Care University moodle)
4. **Mejoras de seguridad**: Implementar controles de seguridad avanzados
5. **Mejoras de estabilidad**: Mejor rendimiento y disponibilidad

---

## 3. Alcance del Proyecto

### ✅ Incluye

- ✅ Aprovisionamiento de VPS en DigitalOcean
- ✅ Hardening del sistema operativo (Ubuntu 22.04 LTS)
- ✅ Migración de aplicación Web (PHP) con Docker
- ✅ Configuración segura de servicios (Nginx/Apache, PHP, SSH)
- ✅ Firewall y controles de red (ufw)
- ✅ Monitoreo básico y logging centralizado
- ✅ Documentación técnica mínima
- ✅ Integración con portal-miembros (autologin)

### 🚫 No incluye (esta fase)

- ❌ Arquitectura multi-zona o alta disponibilidad (HA)
- ❌ Kubernetes / contenedores avanzados (fase futura)
- ❌ Auto-scaling
- ❌ CDN avanzado (Cloudflare puede integrarse después)
- ❌ Migración de otros servicios de `bilingualchildcaretraining.com`

---

## 4. Arquitectura Actual

### Estructura de Servicios

```
┌─────────────────────────────────────────────────────────────┐
│         bilingualchildcaretraining.com (cPanel)             │
├─────────────────────────────────────────────────────────────┤
│                                                              │
│  ┌──────────────────┐         ┌──────────────────────────┐  │
│  │ portal-miembros  │         │   acuarela-app-web      │  │
│  │  /miembros/      │────────▶│  /miembros/acuarela-    │  │
│  │                  │         │      app-web/           │  │
│  └──────────────────┘         └──────────────────────────┘  │
│                                                              │
└─────────────────────────────────────────────────────────────┘

┌─────────────────────────────────────────────────────────────┐
│                    acuarela.app (cPanel)                    │
├─────────────────────────────────────────────────────────────┤
│                                                              │
│  ┌──────────────────┐                                        │
│  │ acuarela-web-page│                                        │
│  │  (Landing Page)  │                                        │
│  └──────────────────┘                                        │
│                                                              │
└─────────────────────────────────────────────────────────────┘
```

### Problemas de la Arquitectura Actual

1. **Servicios dispersos**: 3 repositorios en 2 dominios diferentes
2. **Dependencias cruzadas**: `acuarela-app-web` depende de `portal-miembros` para autenticación
3. **Sin containerización**: Código ejecutándose directamente en cPanel
4. **Sin control de infraestructura**: Limitaciones del hosting compartido

---

## 5. Arquitectura Objetivo

### Estructura Unificada en DigitalOcean

```
┌─────────────────────────────────────────────────────────────┐
│              DigitalOcean VPS (Ubuntu 22.04 LTS)            │
│                    IP: [IP_PUBLICA]                          │
├─────────────────────────────────────────────────────────────┤
│                                                              │
│  ┌──────────────────────────────────────────────────────┐  │
│  │              Docker Compose Stack                     │  │
│  │                                                       │  │
│  │  ┌──────────────────────────────────────────────┐   │  │
│  │  │  acuarela-web (Container)                    │   │  │
│  │  │  - acuarela-web-page (Landing)              │   │  │
│  │  │  - acuarela-app-web (App)                   │   │  │
│  │  │  - portal-miembros (Login - integrado)      │   │  │
│  │  │  Port: 80/443                                │   │  │
│  │  └──────────────────────────────────────────────┘   │  │
│  │                                                       │  │
│  └──────────────────────────────────────────────────────┘  │
│                                                              │
│  ┌──────────────────────────────────────────────────────┐  │
│  │  Nginx Reverse Proxy                                  │  │
│  │  - SSL/TLS (Let's Encrypt)                           │  │
│  │  - HTTP → HTTPS redirect                              │  │
│  └──────────────────────────────────────────────────────┘  │
│                                                              │
│  ┌──────────────────────────────────────────────────────┐  │
│  │  Firewall (ufw)                                       │  │
│  │  - 22 (SSH - IPs restringidas)                        │  │
│  │  - 80 (HTTP)                                          │  │
│  │  - 443 (HTTPS)                                        │  │
│  └──────────────────────────────────────────────────────┘  │
│                                                              │
└─────────────────────────────────────────────────────────────┘
```

### URLs Objetivo

| Servicio | URL Actual | URL Objetivo |
|----------|-----------|--------------|
| **Landing Page** | `https://acuarela.app/` | `https://acuarela.app/` ✅ (mantiene) |
| **Login/Registro** | `https://bilingualchildcaretraining.com/miembros/` | `https://acuarela.app/miembros/` |
| **Aplicación** | `https://bilingualchildcaretraining.com/miembros/acuarela-app-web/` | `https://acuarela.app/miembros/acuarela-app-web/` |

### Integración con Portal de Miembros

**Patrón similar a Bilingual Child Care University:**

```
┌─────────────────────────────────────────────────────────────┐
│     bilingualchildcaretraining.com/miembros/                │
│              (Portal de Miembros)                           │
├─────────────────────────────────────────────────────────────┤
│                                                              │
│  ┌──────────────────┐         ┌──────────────────────────┐ │
│  │  Dashboard        │         │  Servicios Disponibles    │ │
│  │                   │         │                          │ │
│  │  [Usuario logueado]│────────▶│  • Bilingual Child Care  │ │
│  │                   │         │    University            │ │
│  │                   │         │  • Acuarela App          │ │
│  └──────────────────┘         └──────────────────────────┘ │
│                                                              │
└─────────────────────────────────────────────────────────────┘
                              │
                              │ Autologin (POST)
                              │ Token + Credenciales
                              ▼
┌─────────────────────────────────────────────────────────────┐
│              acuarela.app/app/                               │
│         (Acuarela App - Nuevo Entorno)                      │
├─────────────────────────────────────────────────────────────┤
│                                                              │
│  ┌──────────────────────────────────────────────────────┐  │
│  │  Endpoint: /set/autologinAcuarela.php                │  │
│  │  - Valida token                                       │  │
│  │  - Crea/actualiza sesión                             │  │
│  │  - Redirige a /app/                                  │  │
│  └──────────────────────────────────────────────────────┘  │
│                                                              │
└─────────────────────────────────────────────────────────────┘
```

### Especificación Técnica del Servidor

| Recurso | Especificación |
|---------|----------------|
| **OS** | Ubuntu 22.04 LTS |
| **CPU** | 2 vCPU |
| **RAM** | 4 GB |
| **Disco** | 80-100 GB SSD |
| **Red** | IP pública fija |
| **Acceso** | SSH por llave (NO password) |

---

## 6. Estrategia de Migración

### Decisión Estratégica: Mejoras Primero, Conexión Después

Se ha definido una estrategia clara para la migración que prioriza la estabilidad y seguridad antes de exponer integraciones externas.

### Análisis de Opciones

#### Opción A: Migrar → Conectar Inmediatamente → Mejoras

**Pros**:
- ✅ Los usuarios pueden acceder desde el portal desde el inicio
- ✅ **No hay dos servicios funcionando en paralelo**: Se migra directamente al nuevo entorno

**Contras**:
- ❌ Demasiadas variables en juego simultáneamente (migración + integración + mejoras)
- ❌ Si falla la integración, difícil saber si es por migración o por autologin
- ❌ Menos tiempo para validar que el sistema funciona de forma independiente (sin integraciones externas)
- ❌ Riesgo de exponer sistema sin hardening completo
- ❌ **Configuración de doble autenticación (MFA) debe implementarse inmediatamente**: No hay tiempo para planificar y probar la integración MFA con el autologin, lo que aumenta el riesgo de vulnerabilidades de seguridad

#### Opción B: Migrar → Mejoras → Conectar (✅ RECOMENDADA)

**Pros**:
- ✅ **Continuidad del servicio**: Acuarela sigue funcionando normalmente en `bilingualchildcaretraining.com` durante todo el proceso de mejoras
- ✅ **Sin interrupción**: Los usuarios pueden seguir accediendo al sistema actual mientras se trabaja en el nuevo entorno
- ✅ Validar que el sistema funciona de forma independiente (sin integraciones externas) antes de integrar
- ✅ Hardening y seguridad completos antes de exponerlo
- ✅ Debugging más simple (menos variables)
- ✅ Cumplimiento de estándares antes de la integración
- ✅ Menor riesgo: si algo falla, es más fácil identificar la causa
- ✅ Mejor para auditoría: sistema seguro antes de conectar
- ✅ **Migración sin presión**: Se puede trabajar con calma en las mejoras sin afectar usuarios activos
- ✅ **Conexión controlada**: Solo se conecta al final cuando todo está listo y probado

**Contras**:
- ⚠️ Los usuarios no pueden acceder desde el portal al nuevo entorno hasta que se conecte (pero pueden seguir usando el sistema actual)
- ⚠️ Durante las mejoras, hay dos sistemas funcionando en paralelo (actual y nuevo)


### Estado Actual

✅ **Dockerización Completada**: Los 3 servicios están unificados y dockerizados en `acuarela-web-page`.

**Próximo paso**: Aprovisionamiento de VPS y migración básica.

---


## 7. Integración con Portal de Miembros

### 7.1 Patrón de Integración (Similar a Bilingual Child Care University)

**Referencia**: Bilingual Child Care University está en `https://bilingualchildcareuniversity.com/` pero se accede desde el portal de miembros mediante autologin.

### 7.2 Flujo de Autologin

```
┌─────────────────────────────────────────────────────────────┐
│  Usuario en Portal de Miembros                             │
│  (bilingualchildcaretraining.com/miembros/)                 │
└─────────────────────────────────────────────────────────────┘
                        │
                        │ Click en "Acuarela App"
                        ▼
┌─────────────────────────────────────────────────────────────┐
│  JavaScript genera token seguro                             │
│  - Email del usuario                                        │
│  - Timestamp                                                │
│  - Hash de seguridad                                        │
└─────────────────────────────────────────────────────────────┘
                        │
                        │ POST con token
                        ▼
┌─────────────────────────────────────────────────────────────┐
│  acuarela.app/set/autologinAcuarela.php                    │
│  - Valida token                                             │
│  - Verifica usuario en sesión del portal                   │
│  - Crea/actualiza sesión en Acuarela                       │
│  - Redirige a /app/                                        │
└─────────────────────────────────────────────────────────────┘
                        │
                        │ Redirect
                        ▼
┌─────────────────────────────────────────────────────────────┐
│  acuarela.app/app/                                         │
│  Usuario autenticado y listo para usar                     │
└─────────────────────────────────────────────────────────────┘
```

### 7.3 Consideración Crítica: Doble Autenticación (MFA/2FA)

#### ⚠️ Problema Identificado

Se ha identificado una **vulnerabilidad de seguridad potencial** relacionada con la implementación de **doble autenticación (MFA/2FA)** en Acuarela:

**Escenario de riesgo**:
- Si Acuarela implementa MFA/2FA para acceso directo (`acuarela.app`)
- Pero el autologin desde portal-miembros **bypasea** la verificación MFA
- Esto crea una **vulnerabilidad de seguridad** que permite:
  - Acceso no autorizado mediante autologin sin MFA
  - Bypass de controles de seguridad implementados
  - Inconsistencia en los controles de acceso

#### 🔒 Decisiones Requeridas

Se debe tomar una decisión estratégica sobre cómo manejar MFA en el contexto del autologin:

##### Opción A: MFA Obligatorio en Autologin

**Implementación**:
- El autologin desde portal-miembros **requiere** que el usuario haya completado MFA en el portal
- El portal solo permite autologin si el usuario tiene MFA activado y verificado
- El token de autologin incluye un flag `mfa_verified: true` con timestamp
- Acuarela valida que el MFA fue verificado recientemente (ej: últimos 15 minutos)

**Pros**:
- ✅ Consistencia en controles de seguridad
- ✅ No hay bypass de MFA
- ✅ Cumple con estándares SOC 2 / ISO 27001
- ✅ Protección uniforme independientemente del punto de entrada

**Contras**:
- ⚠️ Requiere que portal-miembros también implemente MFA
- ⚠️ Usuarios deben completar MFA en portal antes de acceder a Acuarela

##### Opción B: MFA Opcional en Autologin

**Implementación**:
- El autologin permite acceso sin MFA
- MFA solo se requiere para acceso directo a `acuarela.app`
- Se registra en logs que el acceso fue mediante autologin (sin MFA)

**Pros**:
- ✅ Experiencia de usuario más fluida
- ✅ No requiere MFA en portal-miembros

**Contras**:
- ❌ **VULNERABILIDAD DE SEGURIDAD**: Bypass de MFA
- ❌ No cumple con estándares de seguridad estrictos
- ❌ Inconsistencia en controles de acceso
- ❌ Riesgo de acceso no autorizado

##### Opción D: Login Separado con MFA en Acuarela + Redirección desde Portal (✅ RECOMENDADA PARA ESTA FASE)

**Contexto actual**:
- Portal-miembros **no tiene MFA** y **se mantendrá así en esta intervención**.
- Acuarela **sí tendrá MFA/2FA** en su propio login.
- Cada sistema maneja su propia autenticación.

**Implementación (Fase actual)**:
- Portal-miembros y Acuarela manejan **login separado**
- Usuarios acceden a Acuarela directamente (`acuarela.app`) con login propio y MFA
- Portal-miembros mantiene su login actual (sin MFA por ahora, sin cambios técnicos profundos en esta fase)
- **Desde portal-miembros se puede redirigir a Acuarela**, pero **sin autologin**:
  - Portal muestra botón/enlace a Acuarela en el dashboard
  - Al hacer clic, redirige a `acuarela.app/login/` (página de login de Acuarela)
  - El usuario debe hacer login manualmente en Acuarela con sus credenciales y MFA
  - No hay transferencia de sesión ni tokens de autenticación
- **No hay autologin en esta fase**: Cada sistema mantiene su autenticación independiente

**Fase futura (Mejora en Portal, fuera de esta intervención)**:
- Proyecto separado para agregar MFA a portal-miembros
- Una vez portal tenga MFA, se podrá implementar autologin seguro con validación de `mfa_verified: true`
- Ese trabajo se considera **una mejora de portal-miembros**, no de Acuarela, y no se aborda en este alcance

**Flujo en Fase Inicial**:
```
┌─────────────────────────────────────────────────────────────┐
│  Usuario en Portal de Miembros                             │
│  (bilingualchildcaretraining.com/miembros/)                 │
└─────────────────────────────────────────────────────────────┘
                        │
                        │ Click en "Acuarela App"
                        │ (Botón/Enlace)
                        ▼
┌─────────────────────────────────────────────────────────────┐
│  Redirección simple (sin autologin)                        │
│  window.location = 'https://acuarela.app/login/'           │
└─────────────────────────────────────────────────────────────┘
                        │
                        │ Redirect
                        ▼
┌─────────────────────────────────────────────────────────────┐
│  acuarela.app/login/                                       │
│  Usuario debe hacer login manualmente                      │
│  - Email/Usuario                                           │
│  - Contraseña                                              │
│  - MFA/2FA                                                 │
└─────────────────────────────────────────────────────────────┘
                        │
                        │ Login exitoso
                        ▼
┌─────────────────────────────────────────────────────────────┐
│  acuarela.app/app/                                         │
│  Usuario autenticado y listo para usar                     │
└─────────────────────────────────────────────────────────────┘
```

**Pros**:
- ✅ **No requiere intervención inmediata en portal-miembros**: Permite implementar MFA en Acuarela sin esperar cambios complejos en portal
- ✅ **Seguridad desde el inicio**: MFA implementado en Acuarela desde la migración, cumpliendo estándares
- ✅ **Integración simple inicial**: Portal puede redirigir a Acuarela sin necesidad de autologin complejo
- ✅ **Implementación gradual**: Se puede trabajar en autologin con MFA en una intervención posterior, con tiempo para planificar
- ✅ **Cumple con estándares de seguridad**: MFA siempre requerido en Acuarela, sin bypass
- ✅ **Menor presión**: No hay necesidad de coordinar cambios simultáneos complejos en ambos sistemas
- ✅ **Flexibilidad**: Permite probar y ajustar MFA en Acuarela antes de integrar autologin con portal
- ✅ **Experiencia de usuario aceptable**: Aunque requiere login manual, el usuario puede acceder fácilmente desde portal

**Contras**:
- ⚠️ Usuarios deben hacer login manual en Acuarela (no hay autologin inicialmente)
- ⚠️ Requiere intervención futura en portal-miembros para implementar autologin con MFA
- ⚠️ Experiencia de usuario menos fluida que con autologin (pero aceptable)

#### 📋 Resumen de Opciones

En esta intervención se consideran **tres opciones principales**:

- **Opción A – MFA obligatorio en autologin**  
  - Requiere que portal-miembros tenga MFA y genere tokens con `mfa_verified: true`.  
  - Ofrece máxima seguridad y consistencia, pero **implica cambiar portal-miembros ahora mismo**.

- **Opción B – MFA opcional en autologin (DESCARTADA)**  
  - Permite acceso por autologin sin MFA.  
  - Crea una vulnerabilidad clara (bypass de MFA), no cumple estándares de seguridad.  
  - Se documenta solo como referencia, pero **no se recomienda implementarla**.

- **Opción D – Login separado con MFA en Acuarela + redirección desde portal (OPCIÓN ELEGIDA AHORA)**  
  - Portal-miembros sigue como está hoy (sin MFA, sin autologin).  
  - Acuarela implementa su propio login con MFA/2FA.  
  - Desde portal-miembros se expone solo un **link de acceso** que lleva a la página de login de Acuarela.  
  - El autologin con MFA se deja para una **intervención futura en portal-miembros**.

En esta fase, la opción que se implementará es **Opción D**.

---


## 8. Conclusión

Esta migración permitirá:

1. ✅ **Mejorar la seguridad** mediante controles avanzados y hardening
2. ✅ **Mejorar la estabilidad** con infraestructura dedicada
3. ✅ **Facilitar la auditoría** con logging y monitoreo centralizados
4. ✅ **Preparar el terreno** para futuras mejoras (HA, escalabilidad)
5. ✅ **Mantener la integración** con portal-miembros mediante autologin

El nuevo entorno será compatible con estándares SOC 2, ISO/IEC 27001 y NIST CSF, proporcionando una base sólida para el crecimiento futuro de Acuarela.

---

**Documento creado**: [Fecha]  
**Última actualización**: [Fecha]  
**Versión**: 1.0
