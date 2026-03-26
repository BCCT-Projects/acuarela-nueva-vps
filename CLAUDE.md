# CLAUDE.md - Guía de Desarrollo para Acuarela

## Descripción del Proyecto

**Acuarela** es una plataforma SaaS para gestión de daycares (guarderías bilingual). Permite administrar inscripciones, asistencia, grupos, finanzas, inspecciones y más. La aplicación es multi-tenant, donde cada usuario puede tener acceso a múltiples daycares.

---

## Estructura de Proyectos

El workspace contiene 3 proyectos relacionados:

```
Proyecto-acuarela/
├── acuarela-nueva-vps/     # 🔴 LEGACY - Proyecto actual en producción
├── acuarela-v2/           # 🟢 NUEVO - Modernización (Next.js + NestJS)
└── acuarela-superadmin/    # 🔵 STRAPI 3 - Referencia de datos y API
```

### 1. acuarela-nueva-vps/ (Legacy - PHP)
Proyecto actual en producción. **Solo mantenimiento**, no nuevas features.

**Stack:**
- PHP 8.2 procedural + Apache
- JavaScript vanilla + jQuery
- API externa: AcuarelaCore (Strapi 3)
- Docker + GitHub Actions

**Uso:** Referencia para comportamiento actual, diseño visual, flujos de usuario.

### 2. acuarela 2.0/ (Nuevo - Modernización)
Proyecto nuevo donde se desarrolla la versión modernizada.

**Stack:**
- **Backend**: NestJS + TypeORM + PostgreSQL
- **Frontend**: Next.js 15 (App Router) + shadcn/ui + Tailwind CSS
- **Infraestructura**: Docker

**Uso:** Todo el desarrollo nuevo va aquí.

### 3. acuarela-superadmin/ (Strapi 3)
Backend actual con MongoDB. **Referencia para datos y API**.

**Uso:**
- Estructura de modelos de datos
- Endpoints de API existentes
- Lógica de negocio a replicar

---

## Plan de Modernización

Ver detalle completo en: `acuarela-nueva-vps/spec/plan.md`

### Fases

| Fase | Descripción | Estado |
|------|-------------|--------|
| 1 | Fundación (NestJS + Next.js + Docker) | 🔄 En progreso |
| 2 | Página Institucional | ⏳ Pendiente |
| 3 | Autenticación (bridge con legacy) | ⏳ Pendiente |
| 4 | Dashboard + Widgets | ⏳ Pendiente |
| 5 | Configuración | ⏳ Pendiente |
| 6 | Inscripciones | ⏳ Pendiente |
| 7 | Asistencia | ⏳ Pendiente |
| 8 | Grupos | ⏳ Pendiente |
| 9 | Finanzas (simplificado) | ⏳ Pendiente |
| 10 | Inspección | ⏳ Pendiente |
| 11 | Social (chat, imágenes) | ⏳ Pendiente |

### Estrategia de Migración

**Sin migración de datos tradicional.** El portal legacy actúa como "registration authority":

1. Usuario entra al portal legacy (PHP)
2. Legacy autentica y solicita contraseña (primera vez)
3. Legacy envía datos al nuevo sistema vía API
4. Nuevo sistema crea usuario + daycare
5. Autologin SSO redirige a la nueva plataforma

---

## Identidad Visual

### Paleta de Colores

| Color | Variable | Código | Uso |
|-------|----------|--------|-----|
| 🌊 Cielo | `--cielo` | `#0cb5c3` | Primario |
| 🍉 Sandía | `--sandia` | `#eb5d5e` | Acento/Danger |
| 🐤 Pollito | `--pollito` | `#f5aa16` | Warning |
| 💜 Morita | `--morita` | `#8773ae` | Especial |
| 🌿 Verde | `--secundario1` | `#3fb072` | Success |
| 🧠 Naranja | `--secundario2` | `#f0862f` | Info |
| 🌸 Rosa | `--secundario3` | `#e45e9e` | Acento |

### Tipografía
- **Principal**: Raleway (Google Fonts)
- **Iconos**: Lucide (shadcn) + fuente propia acuarela

### Estilo
- Bordes redondeados (0.75rem)
- Colores pasteles, diseño amigable
- Sidebar colapsable (257px expandido)

---

## Módulos Principales

| Módulo | Descripción | Complejidad |
|--------|-------------|-------------|
| Social | Muro, posts, comentarios, chat | Alta |
| Inscripciones | CRUD niños, padres, consentimientos | Media |
| Asistencia | Check-in/out, reportes | Media |
| Grupos | Clases, asignaciones | Baja |
| Finanzas | Ingresos/gastos manuales, gráficos | Media |
| Inspección | Formularios, checklist | Media |
| Configuración | Daycares, usuarios, roles | Baja |

---

## Modelo de Suscripción

- **LITE**: Funcionalidad básica (gratuito)
- **PRO**: Acceso completo

---

## Flujo de Autologin (Legacy → Nuevo)

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
         │                        4. Crea registros
         │                        5. Genera token SSO
         │                                      │
         │  6. Redirect con token SSO           │
         │◀─────────────────────────────────────│
         │                                      │
         │  7. Usuario accede con autologin     │
         │─────────────────────────────────────▶│
```

---

## Convenciones de Código

### Nomenclatura
- **Archivos**: kebab-case (frontend), camelCase (backend)
- **Clases**: PascalCase
- **Funciones/Variables**: camelCase
- **Constantes**: UPPER_SNAKE_CASE

### Idioma
- **Código y comentarios**: Inglés
- **UI y contenido**: Español (con soporte multiidioma)

### Git
- Rama `dev`: Desarrollo activo
- Rama `main`: Producción
- Commits en español

---

## Notas Importantes

1. **Referencias**: Usar `acuarela-nueva-vps/` y `acuarela-superadmin/` como referencia para diseño y funcionalidad
2. **Multi-tenant**: Cada usuario puede acceder a múltiples daycares
3. **Desarrollo nuevo**: Todo va en `acuarela 2.0/`
4. **Sin migración de datos**: Los usuarios se registran gradualmente desde el legacy
