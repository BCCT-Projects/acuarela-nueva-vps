# Plan de Unificación de Proyectos

## Análisis de la Situación Actual

### 1. **portal-miembros** (Login/Autenticación)
- **Ubicación**: `/miembros/`
- **Funcionalidad**: Login, registro, recuperación de contraseña, perfil de usuario
- **Rutas principales**:
  - `/miembros/` → Login
  - `/miembros/crear-cuenta` → Registro
  - `/miembros/recuperar-contrasena` → Recuperar contraseña
  - `/miembros/mi-perfil` → Perfil (redirige después del login)
  - `/miembros/s/login/` → Endpoint de login
  - `/miembros/s/createUser/` → Endpoint de registro

### 2. **acuarela-app-web** (Aplicación Web)
- **Ubicación**: `/miembros/acuarela-app-web/`
- **Funcionalidad**: Aplicación principal para gestión de daycare
- **Rutas principales**:
  - `/miembros/acuarela-app-web/` → Muro social (index)
  - `/miembros/acuarela-app-web/inscripciones` → Gestión de inscripciones
  - `/miembros/acuarela-app-web/asistencia` → Control de asistencia
  - `/miembros/acuarela-app-web/asistentes` → Gestión de asistentes
  - `/miembros/acuarela-app-web/grupos` → Gestión de grupos
  - `/miembros/acuarela-app-web/finanzas` → Finanzas
  - `/miembros/acuarela-app-web/configuracion` → Configuración
  - `/miembros/acuarela-app-web/s/` → Endpoints de servicios

### 3. **acuarela-web-page** (Página Institucional)
- **Ubicación**: `/` (raíz)
- **Funcionalidad**: Landing page, información institucional
- **Rutas principales**:
  - `/` → Home
  - `/sobre-nosotros` → About
  - `/planes-precios` → Pricing
  - `/preguntas-frecuentes` → FAQ
  - `/free-demo` → Contact
  - `/s/` → Endpoints de servicios (pagos, etc.)

## Propuesta de Unificación

### Estructura Unificada en `acuarela-web-page`

```
acuarela-web-page/
├── /                    → Página institucional (mantener)
├── /login/              → Login (copiar de portal-miembros)
├── /register/           → Registro (copiar de portal-miembros)
├── /app/               → Aplicación web (copiar de acuarela-app-web)
│   ├── /app/           → Muro social
│   ├── /app/inscripciones/
│   ├── /app/asistencia/
│   ├── /app/asistentes/
│   ├── /app/grupos/
│   ├── /app/finanzas/
│   └── /app/configuracion/
└── /s/                 → Endpoints unificados
```

### Análisis de Rutas

#### ¿Mantener las mismas rutas?

**OPCIÓN A: Mantener rutas originales (NO RECOMENDADO)**
- Pros: Compatibilidad total con URLs existentes
- Contras: Rutas largas y confusas (`/miembros/acuarela-app-web/`)

**OPCIÓN B: Simplificar rutas (RECOMENDADO)**
- Pros: URLs más limpias y modernas
- Contras: Requiere redirecciones 301 para SEO y compatibilidad

### Recomendación: **OPCIÓN B con redirecciones**

#### Nuevas Rutas Propuestas:

1. **Login/Auth**:
   - `/login/` (antes: `/miembros/`)
   - `/register/` (antes: `/miembros/crear-cuenta`)
   - `/recuperar-contrasena/` (antes: `/miembros/recuperar-contrasena`)

2. **Aplicación**:
   - `/app/` (antes: `/miembros/acuarela-app-web/`)
   - `/app/inscripciones/` (antes: `/miembros/acuarela-app-web/inscripciones`)
   - `/app/asistencia/` (antes: `/miembros/acuarela-app-web/asistencia`)
   - `/app/asistentes/` (antes: `/miembros/acuarela-app-web/asistentes`)
   - `/app/grupos/` (antes: `/miembros/acuarela-app-web/grupos`)
   - `/app/finanzas/` (antes: `/miembros/acuarela-app-web/finanzas`)
   - `/app/configuracion/` (antes: `/miembros/acuarela-app-web/configuracion`)

3. **Endpoints**:
   - `/s/login/` → Login endpoint
   - `/s/createUser/` → Registro endpoint
   - `/s/daycareActive/` → Activar daycare
   - `/s/getPosts/` → Obtener posts
   - `/s/getInscripciones/` → Obtener inscripciones
   - etc.

## Plan de Implementación

### Fase 1: Copiar Login (portal-miembros → acuarela-web-page)
1. Copiar `portal-miembros/index.php` → `acuarela-web-page/login/index.php`
2. Copiar `portal-miembros/register.php` → `acuarela-web-page/register/index.php`
3. Copiar `portal-miembros/forgot_pass.php` → `acuarela-web-page/login/recuperar-contrasena.php`
4. Copiar endpoints de login: `set/login.php`, `set/createUser.php`, `set/update_password.php`
5. Adaptar rutas en archivos copiados:
   - Cambiar `/miembros/` → `/login/` o `/register/`
   - Cambiar `s/login/` → `/s/login/`
   - Cambiar `s/createUser/` → `/s/createUser/`

### Fase 2: Copiar Aplicación (acuarela-app-web → acuarela-web-page)
1. Copiar estructura completa de `acuarela-app-web/` → `acuarela-web-page/app/`
2. Copiar todos los endpoints de `acuarela-app-web/set/` → `acuarela-web-page/s/`
3. Copiar todos los endpoints de `acuarela-app-web/get/` → `acuarela-web-page/get/`
4. Adaptar rutas en archivos copiados:
   - Cambiar `/miembros/acuarela-app-web/` → `/app/`
   - Cambiar rutas absolutas en includes
   - Actualizar base href en headers

### Fase 3: Unificar SDK y Configuración
1. Verificar que `includes/sdk.php` tenga todas las funciones necesarias
2. Unificar `includes/config.php` para manejar ambas autenticaciones
3. Asegurar que las sesiones funcionen correctamente

### Fase 4: Configurar .htaccess
1. Agregar reglas para nuevas rutas (`/login/`, `/register/`, `/app/`)
2. Agregar redirecciones 301 de rutas antiguas a nuevas
3. Mantener compatibilidad con endpoints `/s/` y `/g/`

### Fase 5: Adaptar Redirecciones Post-Login
1. Cambiar redirección después de login: `/miembros/mi-perfil` → `/app/`
2. Actualizar redirecciones en `set/login.php`
3. Actualizar redirecciones en `set/daycareActive.php`

## Consideraciones Importantes

### Sesiones y Autenticación
- **portal-miembros** usa: `$_SESSION["user"]` y `$_SESSION["userAll"]`
- **acuarela-app-web** usa: `$_SESSION["userLogged"]` y `$_SESSION["user"]`
- **Necesario**: Unificar el manejo de sesiones para que ambos sistemas funcionen

### Includes y Paths
- **portal-miembros**: `include 'includes/config.php'`
- **acuarela-app-web**: `include $_SERVER['DOCUMENT_ROOT'] . "/miembros/acuarela-app-web/includes/config.php"`
- **Solución**: Usar rutas relativas con `__DIR__` o rutas absolutas desde la raíz

### Base Href
- Actualizar todos los `<base href>` para que apunten a `/` en lugar de `/miembros/` o `/miembros/acuarela-app-web/`

### Assets (CSS, JS, Imágenes)
- Verificar que todas las rutas de assets funcionen desde la nueva estructura
- Considerar mover assets compartidos a carpetas comunes

## Redirecciones 301 (SEO y Compatibilidad)

```apache
# Redirecciones de rutas antiguas a nuevas
RewriteRule ^miembros/?$ /login/ [R=301,L]
RewriteRule ^miembros/crear-cuenta/?$ /register/ [R=301,L]
RewriteRule ^miembros/recuperar-contrasena/?$ /recuperar-contrasena/ [R=301,L]
RewriteRule ^miembros/acuarela-app-web/?$ /app/ [R=301,L]
RewriteRule ^miembros/acuarela-app-web/(.*)$ /app/$1 [R=301,L]
```

## Próximos Pasos

1. ✅ Crear este plan
2. ⏳ Revisar y aprobar plan
3. ⏳ Implementar Fase 1 (Login)
4. ⏳ Implementar Fase 2 (App)
5. ⏳ Implementar Fase 3 (SDK)
6. ⏳ Implementar Fase 4 (.htaccess)
7. ⏳ Implementar Fase 5 (Redirecciones)
8. ⏳ Testing completo
9. ⏳ Deploy

