# CLAUDE.md - Guía de Desarrollo para Acuarela

## Descripción del Proyecto

**Acuarela** es una plataforma SaaS para gestión de daycares (guarderías bilingual). Permite administrar inscripciones, asistencia, grupos, finanzas, inspecciones y más. La aplicación es multi-tenant, donde cada usuario puede tener acceso a múltiples daycares.

## Stack Tecnológico

### Backend
- **PHP 8.2** (sin framework moderno, código procedural con clases aisladas)
- **Apache** con mod_rewrite, headers, expires
- **Composer** para gestión de dependencias
- **SDK propio** (`includes/sdk.php`) para comunicación con API externa

### Frontend
- **JavaScript Vanilla** (sin framework)
- **jQuery** para manipulación DOM
- **CSS nativo** (sin preprocesadores)
- Librerías CDN: Toastify, Splide, Fancybox, Driver.js, Chart.js

### Servicios Externos
- **AcuarelaCore API**: `https://acuarelacore.com/api/` - API principal
- **Stripe**: Pagos y suscripciones (SDK en `marketplace/stripe/`)
- **Mandrill/Mailchimp**: Envío de emails
- **OpenAI**: Generación de contenido con IA
- **Zoho CRM**: Gestión de clientes
- **WordPress**: CMS para contenido estático

### Infraestructura
- **Docker** con PHP 8.2 + Apache
- **GitHub Actions** para CI/CD
- Deploy automático: `dev` → crea PR → `main` → producción

## Estructura de Directorios

```
acuarela-nueva-vps/
├── .github/workflows/          # CI/CD con GitHub Actions
├── .env                        # Variables de entorno (NO commitear)
├── .env.example.txt            # Template de variables de entorno
├── docker-compose.yml          # Desarrollo local
├── docker-compose.production.yml
├── Dockerfile                  # PHP 8.2 + Apache
├── apache-config.conf          # Configuración Apache
├── admin/                      # WordPress Admin
├── landing-daycare/            # Landing page independiente
├── miembros/                   # Aplicación principal
│   ├── index.php               # Login
│   ├── cerrar-sesion.php       # Logout
│   └── acuarela-app-web/       # App principal (área de miembros)
│       ├── includes/
│       │   ├── config.php      # Configuración y sesión
│       │   ├── head.php        # <head> HTML
│       │   ├── header.php      # Header + navegación
│       │   ├── footer.php      # Footer
│       │   └── sdk.php         # SDK para API AcuarelaCore
│       ├── js/
│       │   └── main.js         # JavaScript principal (~6000 líneas)
│       ├── css/
│       │   ├── styles.css      # Estilos principales
│       │   └── acuarela_theme.css
│       ├── img/                # Imágenes estáticas
│       ├── templates/          # Templates parciales
│       └── marketplace/        # Integración Stripe
├── cache/                      # Sistema de caché
├── logs/                       # Logs de aplicación
├── certs/                      # Certificados SSL
└── uploads/                    # Archivos subidos
```

## Patrones de Código

### PHP
- **Sesiones**: Siempre verificar `session_status()` antes de `session_start()`
- **Autenticación**: Verificar `$_SESSION["userLogged"]` o `$_SESSION["user"]`
- **SDK**: Usar `$a = new Acuarela()` para interactuar con la API
- **Includes**: Usar `__DIR__` para rutas relativas

```php
// Ejemplo de página típica
<?php include __DIR__ . "/includes/config.php"; ?>
<?php include __DIR__ . "/includes/head.php"; ?>
<?php include __DIR__ . "/includes/header.php"; ?>
<!-- Contenido -->
<?php include __DIR__ . "/includes/footer.php"; ?>
```

### JavaScript
- Variables globales inyectadas desde PHP: `userMainT`, `daycareActiveId`, `daycares`
- Usar Toastify para notificaciones
- AJAX con fetch API o jQuery

### CSS
- Clases BEM donde sea posible
- Iconos con fuente propia: `class="acuarela acuarela-[Nombre]"`
- Tema oscuro por defecto

## Modelo de Suscripción

- **LITE**: Funcionalidad básica (gratuito)
- **PRO**: Acceso completo (IDs: `66df29c33f91241d635ae818` anual, `66dfcce23f91241d635ae934` mensual)

Verificar con:
```php
$validProIds = ["66df29c33f91241d635ae818", "66dfcce23f91241d635ae934"];
$isProUser = // verificar si tiene suscripción con estos IDs
```

## URLs y Rutas

- **Base de la app**: `/miembros/acuarela-app-web/`
- **Login**: `/miembros/`
- **Logout**: `/miembros/cerrar-sesion`
- **Cambiar daycare**: `/miembros/acuarela-app-web/cambiar-daycare`
- Las URLs amigables se manejan con `.htaccess`

## Variables de Entorno (.env)

```env
APP_ENV=production
APP_DEBUG=false
OPENAI_API_KEY=
ZOHO_CLIENT_ID=
ZOHO_CLIENT_SECRET=
MANDRILL_API_KEY=
STRIPE_SECRET_KEY=
ACUAREACT_APP_ENDPOINT=https://acuarelacore.com/api/
DATA_ENCRYPTION_KEY=
RECAPTCHA_SITE_KEY=
RECAPTCHA_SECRET_KEY=
APP_URL=
```

## Flujo de Git

1. **Rama `dev`**: Desarrollo activo
   - Push a `dev` → Crea/actualiza PR automáticamente
2. **Rama `main`**: Producción
   - Merge PR → Deploy automático a producción

### Comandos útiles
```bash
# Desarrollo local con Docker
docker-compose up -d

# Acceder al contenedor
docker exec -it acuarela-web bash

# Instalar dependencias
composer install --no-dev --optimize-autoloader
```

## Convenciones de Código

### Nomenclatura
- **Archivos PHP**: snake_case.php
- **Clases**: PascalCase
- **Funciones/Variables**: camelCase en JS, snake_case en PHP
- **Constantes**: UPPER_SNAKE_CASE

### Idioma
- Código y comentarios: **Inglés**
- UI y contenido: **Español** (con soporte multiidioma)
- Usar atributos `data-translate` para traducciones

### Sesiones PHP
```php
// Siempre usar este patrón
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
```

## Módulos Principales

| Módulo | URL | Descripción |
|--------|-----|-------------|
| Social | `/miembros/acuarela-app-web/` | Muro social |
| Inscripciones | `/inscripciones` | Gestión de niños |
| Asistencia | `/asistencia` | Control de asistencia |
| Asistentes | `/asistentes` | Gestión de personal |
| Grupos | `/grupos` | Clases y grupos |
| Finanzas | `/finanzas` | Solo PRO |
| Inspección | `/inspeccion` | Reportes |
| Configuración | `/configuracion` | Ajustes |

## Notas Importantes

1. **No commitear** `.env`, `logs/`, `cache/`, `uploads/`
2. **SDK**: La clase `Acuarela` en `sdk.php` maneja toda la comunicación con la API externa
3. **Multi-daycare**: Los usuarios pueden cambiar entre daycares; usar `$a->daycareID` para el activo
4. **Permisos**: Algunas funcionalidades requieren suscripción PRO
5. **Traducciones**: El sistema usa `data-translate` con IDs numéricos

## Contacto y Recursos

- Documentación técnica: `docs/`
- Diagnóstico del proyecto: `docs/diagnostico-acuarela.md`
