# Plan de Modernización - Acuarela v2

## Contexto

Acuarela es una plataforma SaaS para gestión de daycares (guarderías bilingual). Actualmente corre sobre PHP procedural + JavaScript vanilla, con datos en MongoDB via Strapi 3.

### Stack Actual
- **Backend**: PHP 8.2 procedural + API externa (AcuarelaCore/Strapi)
- **Frontend**: JavaScript vanilla + jQuery
- **Base de datos**: MongoDB (Strapi 3)
- **Infraestructura**: Docker + Apache

### Stack Nuevo
- **Backend**: NestJS + TypeORM
- **Frontend**: Next.js 15 (App Router)
- **UI Components**: shadcn/ui + Tailwind CSS
- **Base de datos**: PostgreSQL
- **Infraestructura**: Docker

### Identidad Visual
- **Colores**: Paleta Acuarela (cielo, sandía, pollito, morita)
- **Tipografía**: Raleway
- **Iconos**: Lucide (shadcn) + fuente propia acuarela (fallback)
- **Estilo**: Bordes redondeados, colores pasteles, diseño amigable

---

## Estrategia de Migración

### Sin migración de datos tradicional

El portal legacy (PHP) actuará como **registration authority**:

1. Usuario entra al portal legacy
2. Portal legacy autentica y solicita contraseña (primera vez)
3. Portal legacy envía al nuevo sistema: email, contraseña, info usuario, info daycare
4. Nuevo sistema crea el registro
5. Autologin SSO redirige al usuario a la nueva plataforma

**Ventajas**:
- No hay ETL complejo
- Usuarios se registran gradualmente
- Ambos sistemas coexisten sin conflictos
- Zero downtime

---

## Fases del Proyecto

### Fase 1: Fundación
- [x] Estructura del proyecto (backend/ + frontend/)
- [x] NestJS base con TypeORM + PostgreSQL
- [x] Next.js base con App Router
- [x] Docker Compose para desarrollo
- [x] Configuración de entorno (.env, variables)

### Fase 2: Página Institucional
- [x] Landing page estática (sin WordPress)
- [x] Secciones: Home, Servicios, Precios, Contacto
- [x] Responsive design
- [x] SEO básico

### Fase 3: Autenticación ✅
- [x] Endpoint para recibir datos del portal legacy (registro)
- [x] Validación de token SSO desde portal legacy
- [x] Login local (email + contraseña)
- [x] JWT + cookies httpOnly
- [x] Middleware de autenticación
- [x] Refresh tokens (15min access, 8h refresh)

### Fase 4: Dashboard ✅
- [x] Layout principal (sidebar, header, etc.)
- [x] Widgets de resumen:
  - Total niños inscritos
  - Asistencia del día
  - Últimos movimientos financieros
  - Tareas pendientes
- [x] Selector de daycare (multi-tenant) - UI lista, pendiente conectar con API

### Fase 5: Configuración
- [ ] Gestión de daycares
- [ ] Gestión de usuarios
- [ ] Perfil de usuario
- [ ] Roles y permisos

### Fase 6: Inscripciones ✅
- [x] CRUD de niños
- [x] Información de padres/tutores
- [x] Consentimientos parentales (COPPA)
- [x] Historial de inscripciones
- [x] Flujo COPPA completo con Mandrill
- [x] Página pública de consentimiento
- [x] Versionado de políticas
- [x] Sistema de duplicación para hermanos
- [x] Autoguardado en formularios
- [x] Límite de plan LITE (16 niños)
- [x] CoppaGuard para bloquear funcionalidades sin consentimiento

### Fase 7: Asistencia
- [ ] Check-in / Check-out
- [ ] Vista por día/semana
- [ ] Reportes de asistencia
- [ ] Justificación de faltas

### Fase 8: Grupos
- [ ] CRUD de grupos/clases
- [ ] Asignación de niños a grupos
- [ ] Asignación de teachers a grupos

### Fase 9: Finanzas (Simplificado)
- [ ] CRUD de ingresos (manual)
- [ ] CRUD de gastos (manual)
- [ ] Categorías de ingresos/gastos
- [ ] Reportes y tablas
- [ ] Gráficos (Chart.js o Recharts)
- [ ] Sin integraciones externas (Stripe, PayPal, etc.)

### Fase 10: Inspección
- [ ] Formularios de inspección
- [ ] Checklist de cumplimiento
- [ ] Historial de inspecciones
- [ ] Generación de reportes

### Fase 11: Social (Último - Más complejo)
- [ ] Posts y feed
- [ ] Comentarios y reacciones
- [ ] Upload de imágenes (con múltiples formatos)
- [ ] Chat en tiempo real (WebSocket)
- [ ] Notificaciones

---

## Autologin: Flujo Técnico

```
┌─────────────────┐                    ┌─────────────────┐
│  Portal Legacy  │                    │   Acuarela v2   │
│    (PHP)        │                    │ (NestJS+Next)   │
└────────┬────────┘                    └────────┬────────┘
         │                                      │
         │  1. Usuario se autentica             │
         │  2. Primera vez? → solicita pass     │
         │                                      │
         │  3. POST /api/legacy/register        │
         │─────────────────────────────────────▶│
         │     {email, password, user, daycare} │
         │                                      │
         │                        4. Crea usuario y daycare
         │                        5. Genera token SSO
         │                                      │
         │  6. Redirect con token SSO           │
         │◀─────────────────────────────────────│
         │                                      │
         │  7. Usuario accede con autologin     │
         │─────────────────────────────────────▶│
         │     /auth/autologin?token=XXX        │
         │                                      │
         │                        8. Valida token
         │                        9. Genera JWT
         │                        10. Establece sesión
         │                                      │
```

---

## Estructura de Directorios

```
acuarela-v2/
├── backend/                    # NestJS
│   ├── src/
│   │   ├── auth/
│   │   ├── daycares/
│   │   ├── users/
│   │   ├── children/
│   │   ├── attendance/
│   │   ├── groups/
│   │   ├── finances/
│   │   ├── inspections/
│   │   ├── social/
│   │   └── common/
│   ├── data-source.ts
│   └── package.json
│
├── frontend/                   # Next.js
│   ├── app/
│   │   ├── (marketing)/       # Página institucional
│   │   ├── (auth)/            # Login, autologin
│   │   └── (dashboard)/       # App principal
│   ├── components/
│   ├── lib/
│   └── package.json
│
├── docker-compose.yml
└── .env.example
```

---

## Consideraciones Técnicas

### Multi-tenant
- Cada usuario puede acceder a múltiples daycares
- Sesión maneja `activeDaycare`
- Queries siempre filtradas por `daycareId`

### Roles
- `owner`: Acceso completo, gestión de suscripción
- `admin`: Gestión de usuarios y configuración
- `teacher`: Inscripciones, asistencia, grupos, social
- `parent`: Solo ver información de sus hijos

### Seguridad
- Contraseñas hasheadas con bcrypt
- JWT con expiración (access token corto, refresh token largo)
- Cookies httpOnly + secure
- Rate limiting en endpoints de auth
- Validación de input con class-validator

---

## Próximos Pasos

1. Crear estructura de carpetas (backend/ + frontend/)
2. Configurar NestJS con TypeORM
3. Configurar Next.js
4. Implementar página institucional
5. Implementar autenticación con bridge del portal legacy
