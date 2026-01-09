# 🎯 Plan de Sincronización de Cursor para 3 Desarrolladores

## Objetivo
Sincronizar el uso de Cursor AI entre desarrolladores para evitar conflictos y maximizar la eficiencia.

---

## 📁 Archivos a Crear en Cada Repo

| Archivo/Carpeta | Propósito |
|-----------------|-----------|
| `.cursorrules` | Reglas compartidas para la IA |
| `.cursorignore` | Archivos excluidos del contexto |
| `docs/` | Documentación técnica para humanos e IA |
| `.cursor/prompts/` | Prompts reutilizables para el equipo |

---

## 1. `.cursorrules` (Crear en raíz del repo)

```markdown
# Reglas del Proyecto

## General
- Responder siempre en español
- PHP 8.1 | SCSS | JavaScript vanilla
- Servidor: VPS GoDaddy con cPanel

## Estructura
- `/includes/` → Config y SDK
- `/get/` → Endpoints GET
- `/set/` → Endpoints POST
- `/scss/` → Estilos (compilar a /css/)

## Convenciones
- camelCase para PHP
- BEM para CSS
- 4 espacios de indentación
- JSON para respuestas de API

## CI/CD
- `dev` → Deploy a DEV (automático)
- `main` → Deploy a PROD (vía PR)

## NO Modificar
- vendor/ (Composer)
- DEPLOY_VERSION.txt
- *.css.map
```

---

## 2. `.cursorignore` (Crear en raíz del repo)

```gitignore
# Dependencias
vendor/

# Generados
*.css.map
css/*.css
DEPLOY_VERSION.txt
error_log
*.log

# Builds
marketplace/*.js
marketplaceapp/*.js

# Media
*.png
*.jpg
*.svg
*.gif
*.mp4
*.pdf

# Sistema
.git/
.github/
node_modules/
cache/
```

---

## 3. Carpeta `docs/` (Estructura)

```
docs/
├── README.md           # Índice
├── ARCHITECTURE.md     # Arquitectura del sistema
├── API.md              # Endpoints disponibles
├── WORKFLOWS.md        # Flujos de negocio
└── TROUBLESHOOTING.md  # Problemas comunes
```

---

## 4. Carpeta `.cursor/prompts/` (Prompts Reutilizables)

Prompts predefinidos que el equipo puede invocar con `@` en el chat de Cursor.

```
.cursor/
└── prompts/
    ├── crear-endpoint-get.md    # Template para crear endpoint GET
    ├── crear-endpoint-set.md    # Template para crear endpoint POST
    ├── componente-scss.md       # Template para nuevo componente SCSS
    ├── fix-error-php.md         # Guía para debuggear errores PHP
    ├── consulta-bd.md           # Template para queries con PDO
    └── enviar-email.md          # Template para enviar email con Mandrill
```


### Uso en Cursor:
Escribir `@crear-endpoint-get` en el chat para invocar el prompt.

---

## 🔄 Flujo de Trabajo

```
1. Crear archivos (.cursorrules, .cursorignore, docs/, .cursor/prompts/)
2. Commitear a git
3. Todos hacen git pull
4. Cursor lee las reglas automáticamente
5. Todos usan los mismos prompts con @nombre-prompt
6. Todos trabajan con el mismo contexto
```


## 📋 Checklist por Repo

- [ ] Crear `.cursorrules`
- [ ] Crear `.cursorignore`
- [ ] Crear `docs/` con documentación del proyecto
- [ ] Crear `.cursor/prompts/` con templates útiles
- [ ] Commitear todo a git
- [ ] Avisar al equipo: `git pull`

---

## 💡 Recomendaciones de Uso

### 1. Usar la Herramienta de Planificación (TODOs)

Cursor tiene un sistema de tareas integrado. Úsalo para tareas complejas:

```
Usuario: "Agregar sistema de notificaciones push"

Cursor crea TODOs automáticamente:
- [ ] Configurar service worker
- [ ] Crear endpoint para suscripciones
- [ ] Implementar lógica de envío
- [ ] Agregar UI para permisos
```

**Cuándo usarlo:**
- Tareas con 3+ pasos
- Features nuevas
- Refactorizaciones grandes

**Cuándo NO usarlo:**
- Correcciones simples
- Preguntas rápidas
- Cambios de 1-2 archivos

### 2. Contexto Óptimo

| Acción | Cómo |
|--------|------|
| Agregar archivo al contexto | `@archivo.php` en el chat |
| Agregar carpeta | `@get/` o `@includes/` |
| Agregar documentación | `@docs/ARCHITECTURE.md` |
| Usar prompt guardado | `@crear-endpoint-get` |

### 3. Evitar Conflictos entre Desarrolladores

- **No trabajar en el mismo archivo** simultáneamente con Cursor
- **Commits frecuentes** para sincronizar cambios
- **Pull antes de pedir cambios** grandes a Cursor
- **Revisar siempre** antes de aceptar cambios de la IA

### 4. Buenas Prácticas

```
✅ HACER:
- Dar contexto específico: "En get/getChildren.php..."
- Pedir cambios pequeños y revisar
- Usar @docs para que la IA entienda el proyecto
- Describir el resultado esperado

❌ EVITAR:
- Pedir cambios masivos sin revisar
- Aceptar todo sin leer
- Trabajar sin .cursorrules configurado
- Ignorar los TODOs pendientes
```



## Repos a Configurar

1. ✅ `acuarela-app-web` (este repo)
2. ⬜ `nueva-web-BCCT`
3. ⬜ `portal-miembros`
4. ⬜ `checkout`

---

*Creado: Enero 2026*

