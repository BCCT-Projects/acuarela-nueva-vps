# Plan de Tareas de Mejora - Acuarela

**Fecha:** Marzo 2026 | **Versión:** 1.0 | **Total:** 80 tareas

---

## Cómo usar este documento

Este plan puede abordarse de **dos formas complementarias**:

| Enfoque | Ideal para | Sección |
|---------|------------|---------|
| **Por Módulos** | Desarrollo por área, asignar a desarrolladores específicos | [Ver por Partes ↓](#vista-por-partes-y-módulos) |
| **Por Prioridad** | Sprint planning, roadmap de releases | [Ver por Fases ↓](#vista-por-fases-de-prioridad) |


---

# VISTA POR PARTES Y MÓDULOS
*Organizado por área funcional para asignación de trabajo*

## PARTE 1: PÁGINA INSTITUCIONAL

### 1.1 Home (index.php)

| ID | Problema | Tarea | Prioridad | Archivo | Esf. |
|----|----------|-------|-----------|---------|------|
| PI-01 | Modal demo tiene "Lorem Ipsum" | Escribir contenido real para modal demo (beneficios, features, CTA) | CRITICA | index.php | 1 |
| PI-02 | reCAPTCHA comentado | Descomentar y configurar reCAPTCHA en formularios de contacto | CRITICA | index.php, contact.php | 1 |
| PI-03 | Mensaje planes desactualizado | Actualizar textos para reflejar modelo LITE gratis + comisiones | CRITICA | index.php | 2 |
| PI-04 | Sección clientes comentada | Descomentar sección o eliminar código muerto | IMPORTANTE | index.php | 1 |
| PI-05 | Testimonios no cargan imágenes | Debug: verificar URLs de API y corregir path de imágenes | CRITICA | index.php, about.php | 2 |

## 1.2 Sobre Nosotros (about.php)

| ID | Problema | Tarea | Prioridad | Archivo | Esf. |
|----|----------|-------|-----------|---------|------|
| PI-06 | Diseño desactualizado | Rediseñar layout con cards y mejor tipografía | MEJORA | about.php, styles.css | 2 |
| PI-07 | Contenido 100% dinámico sin fallback | Agregar contenido estático de respaldo si API falla | IMPORTANTE | about.php | 2 |
| PI-08 | Sin cache de contenido | Implementar cache simple para contenido de API | MEJORA | about.php, cache/ | 1 |

## 1.3 Contacto (contact.php)

| ID | Problema | Tarea | Prioridad | Archivo | Esf. |
|----|----------|-------|-----------|---------|------|
| PI-09 | Sin validación frontend | Agregar validación JS antes de submit (email, teléfono requeridos) | CRITICA | contact.php, main.js | 1 |
| PI-10 | Sin email confirmación | Implementar envío de email de confirmación al usuario | IMPORTANTE | contact.php, mandrill | 2 |
| PI-11 | Selector país limitado | Expandir lista de países o usar librería de países | MEJORA | contact.php | 1 |

## 1.4 Planes y Precios (pricing.php)

| ID | Problema | Tarea | Prioridad | Archivo | Esf. |
|----|----------|-------|-----------|---------|------|
| PI-12 | Planes desactualizados | Actualizar contenido: LITE gratis + comisiones, PRO sin comisiones | CRITICA | pricing.php | 2 |
| PI-13 | Toggle anual/mensual no funciona | Implementar funcionalidad de toggle o eliminar si no se usa | IMPORTANTE | pricing.php, main.js | 1 |
| PI-14 | Mucho código comentado | Limpiar código comentado y mantener solo lo necesario | MEJORA | pricing.php | 1 |

## 1.5 Invitaciones (invitation.php)

| ID | Problema | Tarea | Prioridad | Archivo | Esf. |
|----|----------|-------|-----------|---------|------|
| PI-15 | Evaluar si mantener | **Decisión pendiente:** Mantener, rediseñar o eliminar | IMPORTANTE | invitation.php | 1 |

## 1.6 Políticas (politics.php)

| ID | Problema | Tarea | Prioridad | Archivo | Esf. |
|----|----------|-------|-----------|---------|------|
| PI-16 | Contenido y diseño mejorar | Actualizar texto legal y mejorar presentación visual | MEJORA | politics.php | 2 |

---

# PARTE 2: LOGIN / AUTENTICACIÓN

## 2.1 Login (miembros/index.php)

| ID | Problema | Tarea | Prioridad | Archivo | Esf. |
|----|----------|-------|-----------|---------|------|
| LG-01 | Diseño no ambientado | Rediseñar con colores Acuarela, logo y branding | IMPORTANTE | miembros/index.php, styles.css | 2 |
| LG-02 | Sin "Olvidé contraseña" visible | Agregar link visible "¿Olvidaste tu contraseña?" debajo del formulario | CRITICA | miembros/index.php | 1 |
| LG-03 | Recuperar en dominio externo | Configurar URL de recuperación dentro del dominio acuarela.app | IMPORTANTE | miembros/index.php | 1 |
| LG-04 | Sin "Recordarme" | Implementar checkbox "Recordarme" con extensión de sesión | MEJORA | miembros/index.php, config.php | 2 |
| LG-05 | Sin indicador caps lock | Agregar indicador visual cuando caps lock está activo | MEJORA | miembros/index.php, main.js | 1 |

## 2.2 Sistema de Sesiones

| ID | Problema | Tarea | Prioridad | Archivo | Esf. |
|----|----------|-------|-----------|---------|------|
| LG-06 | Verificar sesiones 8h | Auditar configuración de sesión y verificar que dura 8h correctamente | CRITICA | config.php, php.ini | 2 |
| LG-07 | Optimizar sesiones | Revisar garbage collection y storage de sesiones | MEJORA | config.php | 1 |

---

# PARTE 3: PLATAFORMA PRINCIPAL

## 3.0 Sistema Global

| ID | Problema | Tarea | Prioridad | Archivo | Esf. |
|----|----------|-------|-----------|---------|------|
| SG-01 | Sin notificaciones | Implementar sistema: DB + API + campana en header | IMPORTANTE | header.php, main.js, API | 3 |
| SG-02 | Rendimiento general | Auditar queries, agregar índices, optimizar assets | MEJORA | Multiple | 2 |
| SG-03 | Fluidez entre páginas | Implementar transiciones suaves o skeleton loading | MEJORA | styles.css, main.js | 2 |

## 3.1 Social (Muro)

| ID | Problema | Tarea | Prioridad | Archivo | Esf. |
|----|----------|-------|-----------|---------|------|
| MU-01 | Sin validación publicación | Agregar validación: título requerido, máximo caracteres | CRITICA | main.js | 1 |
| MU-02 | Layout no responsive | Revisar CSS grid/flexbox para móvil | IMPORTANTE | styles.css | 2 |
| MU-03 | Sin fijar publicaciones | Implementar campo "pinned" y lógica de ordenamiento | MEJORA | main.js, API | 2 |
| MU-04 | Sin animaciones reacciones | Agregar transiciones CSS en likes/comentarios | MEJORA | styles.css | 1 |
| MU-05 | Sin editar/eliminar | Agregar botones y modales para editar/eliminar publicaciones | IMPORTANTE | main.js, social.php | 2 |
| MU-06 | Sin filtros | Implementar filtros por fecha, grupo, tipo de actividad | MEJORA | main.js | 2 |

## 3.2 Inscripciones (Agregar Niños)

| ID | Problema | Tarea | Prioridad | Archivo | Esf. |
|----|----------|-------|-----------|---------|------|
| IN-01 | Sin filtros | Agregar dropdowns para filtrar por grupo, edad, asistente | IMPORTANTE | inscripciones.php, main.js | 2 |
| IN-02 | Niños borrador sin alerta | Agregar badge/indicador visual para niños en estado borrador | CRITICA | inscripciones.php | 1 |
| IN-03 | Sin auto-guardado | Implementar localStorage auto-save cada 30 segundos | CRITICA | main.js | 3 |
| IN-04 | Validación solo al final | Validar campo por campo con feedback inmediato | IMPORTANTE | main.js | 2 |
| IN-05 | Sin duplicar para hermanos | Agregar botón "Duplicar" que copie datos familiares | MEJORA | main.js, API | 2 |

## 3.3 Asistencia

| ID | Problema | Tarea | Prioridad | Archivo | Esf. |
|----|----------|-------|-----------|---------|------|
| AS-01 | Fecha muestra "AYER" | Cambiar default de fecha a `new Date()` (hoy) | CRITICA | asistencia.php | 1 |
| AS-02 | Sin búsqueda rápida | Agregar input de búsqueda con filtro en tiempo real | IMPORTANTE | asistencia.php, main.js | 1 |
| AS-03 | Sin estadísticas | Agregar gráfico de asistencia semanal/mensual | MEJORA | asistencia.php, Chart.js | 2 |
| AS-04 | Sin notificación padres | Implementar notificación automática al marcar asistencia | MEJORA | API, notifications | 2 |

## 3.4 Asistentes

| ID | Problema | Tarea | Prioridad | Archivo | Esf. |
|----|----------|-------|-----------|---------|------|
| AT-01 | Error al editar asistente | Debug y fix: investigar por qué se cierra la app al editar | CRITICA | main.js, asistentes.php | 2 |
| AT-02 | Sincronizar rol + asistencia | Vincular rol del asistente con permisos de asistencia | IMPORTANTE | API, DB | 2 |
| AT-03 | Sin permisos/roles | Diseñar e implementar sistema de roles (Admin, Cuidador, Observador) | CRITICA | DB, API, UI | 3 |
| AT-04 | Sin reenviar invitación | Agregar botón "Reenviar invitación" en cada asistente | IMPORTANTE | main.js, API | 2 |
| AT-05 | Sin ver si aceptó | Mostrar estado de invitación (pendiente/aceptada) | MEJORA | asistentes.php | 2 |
| AT-06 | Sin asignación a grupos | Agregar campo de grupo(s) asignados en perfil de asistente | MEJORA | asistentes.php, API | 2 |
| AT-07 | Sin loader al cargar lista | Agregar spinner/skeleton mientras carga lista de asistentes | IMPORTANTE | asistentes.php, main.js | 1 |
| AT-08 | Sin filtros básicos | Agregar filtros por nombre, rol y estado | IMPORTANTE | asistentes.php, main.js | 2 |
| AT-09 | Vista detalles muy pobre | Rediseñar modal de detalles con más info y mejor layout | IMPORTANTE | asistentes.php, main.js | 2 |

## 3.5 Grupos

| ID | Problema | Tarea | Prioridad | Archivo | Esf. |
|----|----------|-------|-----------|---------|------|
| GR-01 | Límite LITE no funciona | Fix: verificar lógica de conteo y aplicar límite 3 grupos | CRITICA | grupos.php, main.js | 1 |
| GR-02 | Eliminar grupo no funciona | Fix: investigar y corregir función de eliminación | CRITICA | main.js, API | 2 |
| GR-03 | Sin botón editar | Agregar opción "Editar" en menú de opciones del grupo | IMPORTANTE | main.js, grupos.php | 1 |
| GR-04 | Sin drag & drop niños | Implementar drag & drop para mover niños entre grupos | MEJORA | main.js, sortable.js | 2 |
| GR-05 | Sin horarios por grupo | Crear sección de horarios en cada grupo | MEJORA | grupos.php, API | 2 |
| GR-06 | Sin contador de niños | Mostrar número de niños en cada card de grupo | MEJORA | main.js | 1 |
| GR-07 | Nombres no se desencriptan | Fix: desencriptar nombres de niños en modal de actividades | CRITICA | boxes/addActivity.php, main.js | 2 |
| GR-08 | Colores selección confusos | Agregar colores visibles (verde/amarillo/rojo) y tooltips explicativos | IMPORTANTE | boxes/addActivity.php, styles.css | 2 |
| GR-09 | Flujo creación actividades pobre | Mejorar wizard: agregar indicadores de paso, progreso visual, títulos claros | IMPORTANTE | boxes/addActivity.php, main.js | 2 |
| GR-10 | Sin historial de actividades | Crear sección/tab de historial de actividades del grupo | IMPORTANTE | grupo.php, API | 2 |
| GR-11 | Sin explicación gestión | Agregar tooltip o ayuda contextual sobre sistema de actividades | MEJORA | grupo.php | 1 |

## 3.6 Finanzas

| ID | Problema | Tarea | Prioridad | Archivo | Esf. |
|----|----------|-------|-----------|---------|------|
| FZ-01 | Botón ingreso no funciona | Agregar `onclick="fadeIn(modalIngreso)"` al botón | CRITICA | finanzas.php | 1 |
| FZ-02 | Botón gasto no funciona | Agregar `onclick="fadeIn(modalGasto)"` al botón | CRITICA | finanzas.php | 1 |
| FZ-03 | Modal Stripe bloqueante | Convertir modal a banner no bloqueante en la parte superior | CRITICA | finanzas.php, styles.css | 1 |
| FZ-04 | Sin modal ingreso | Crear modal con formulario: concepto, monto, fecha, categoría | CRITICA | finanzas.php | 1 |
| FZ-05 | Sin modal gasto | Crear modal con formulario: concepto, monto, fecha, categoría | CRITICA | finanzas.php | 1 |
| FZ-06 | Sin gráficos | Implementar dashboard con Chart.js (ingresos vs gastos) | IMPORTANTE | finanzas.php, main.js | 2 |
| FZ-07 | Sin exportación | Agregar botón exportar Excel con librería SheetJS | IMPORTANTE | finanzas.php, main.js | 2 |
| FZ-08 | Sin editar movimientos | Agregar click en fila para editar/eliminar movimiento | IMPORTANTE | finanzas.php, main.js | 2 |
| FZ-09 | Stripe a producción | Seguir guía en `docs/guia_produccion_stripe_connect.md` | IMPORTANTE | .env, Stripe | 2 |

## 3.7 Tareas

| ID | Problema | Tarea | Prioridad | Archivo | Esf. |
|----|----------|-------|-----------|---------|------|
| TK-01 | Sin mensaje vacío | Agregar mensaje "No hay tareas" cuando la lista está vacía | IMPORTANTE | main.js | 1 |
| TK-02 | Sin editar tarea | Agregar botón editar que abra modal con datos de la tarea | IMPORTANTE | main.js, checklist.php | 1 |
| TK-03 | Sin eliminar tarea | Agregar botón eliminar con confirmación | IMPORTANTE | main.js, API | 1 |
| TK-04 | UX muy básica | Rediseñar vista tipo Kanban con columnas por estado | IMPORTANTE | checklist.php, styles.css | 3 |
| TK-05 | Sin estados de tarea | Agregar estados: pendiente, en progreso, completada | IMPORTANTE | DB, API, UI | 2 |
| TK-06 | Sin colores por urgencia | Agregar colores: rojo (atrasada), amarillo (hoy), verde (futura) | MEJORA | main.js, styles.css | 1 |
| TK-07 | Sin trazabilidad | Guardar historial de cambios (quién, cuándo, qué) | MEJORA | DB, API | 2 |
| TK-08 | Sin dependencias | Implementar relaciones entre tareas (bloqueada por / bloquea a) | MEJORA | DB, API, UI | 3 |
| TK-09 | Tareas muy básicas | Agregar campo de pasos/subtareas y descripción detallada | IMPORTANTE | checklist.php, API | 2 |
| TK-10 | Sin explicación flujo | Agregar onboarding o tooltip explicativo del módulo de tareas | MEJORA | checklist.php, main.js | 1 |

## 3.8 Inspección

| ID | Problema | Tarea | Prioridad | Archivo | Esf. |
|----|----------|-------|-----------|---------|------|
| IP-01 | Generar informes no funciona | Debug y fix: investigar por qué falla la generación | CRITICA | inspeccion.php, API | 2 |
| IP-02 | Sin decidir destinatario | Agregar selector de destinatario (email, imprimir, descargar) | IMPORTANTE | inspeccion.php | 2 |

## 3.9 Perfil del Niño

| ID | Problema | Tarea | Prioridad | Archivo | Esf. |
|----|----------|-------|-----------|---------|------|
| PN-01 | Información muy densa | Organizar información en secciones colapsables | MEJORA | perfil-nino.php | 2 |
| PN-02 | Sin tabs | Implementar tabs: Datos, Asistencia, Pagos, Documentos | MEJORA | perfil-nino.php | 2 |

## 3.10 Configuración

| ID | Problema | Tarea | Prioridad | Archivo | Esf. |
|----|----------|-------|-----------|---------|------|
| CF-01 | "Mis Daycares" sin funcionalidad | Implementar lista de daycares con opción de cambiar | MEJORA | configuracion.php | 2 |
| CF-02 | Sin gestión suscripción visible | Agregar sección de suscripción actual con opción de upgrade | MEJORA | configuracion.php | 2 |

## 3.11 Facturación (NUEVO MÓDULO)

| ID | Problema | Tarea | Prioridad | Archivo | Esf. |
|----|----------|-------|-----------|---------|------|
| FAC-01 | Sin módulo de facturación | Crear página facturacion.php con dashboard de pagos | IMPORTANTE | facturacion.php (nuevo) | 3 |
| FAC-02 | Sin ver comisiones LITE | Mostrar tabla de comisiones cobradas por transacción | IMPORTANTE | facturacion.php, API | 2 |
| FAC-03 | Sin ver pagos a Stripe | Mostrar fees de Stripe desglosados por transacción | IMPORTANTE | facturacion.php, Stripe API | 2 |
| FAC-04 | Sin ver historial suscripciones | Mostrar historial de pagos de suscripción PRO | IMPORTANTE | facturacion.php, API | 2 |

## 3.12 Traducciones / Idiomas

| ID | Problema | Tarea | Prioridad | Archivo | Esf. |
|----|----------|-------|-----------|---------|------|
| TR-01 | Traducciones incompletas en nav | Revisar y agregar data-translate a textos de navegación | IMPORTANTE | header.php, main.js | 2 |
| TR-02 | Sistema inconsistente | Auditar y estandarizar uso de data-translate en toda la app | MEJORA | Multiple | 3 |

---

# VISTA POR FASES DE PRIORIDAD
*Organizado por urgencia para roadmap y releases*

## 🔴 FASE 1: CRÍTICAS (24 tareas)
*Bugs bloqueantes - Impiden funcionamiento básico o afectan conversión*

### Página Institucional
- PI-01: Escribir contenido modal demo
- PI-02: Activar reCAPTCHA
- PI-03: Actualizar mensaje planes
- PI-05: Fix testimonios imágenes
- PI-09: Validación frontend contacto
- PI-12: Actualizar planes pricing

### Login
- LG-02: Agregar link olvidé contraseña
- LG-06: Verificar sesiones 8h

### Plataforma - Bugs Bloqueantes
- AS-01: Fix fecha asistencia (mostrar HOY)
- AT-01: Fix error editar asistente
- AT-03: Implementar sistema de roles
- GR-01: Fix límite LITE 3 grupos
- GR-02: Fix eliminar grupo
- GR-07: Fix desencriptar nombres en actividades
- FZ-01: Fix botón agregar ingreso
- FZ-02: Fix botón agregar gasto
- FZ-03: Convertir modal Stripe a banner
- FZ-04: Crear modal ingreso
- FZ-05: Crear modal gasto
- IN-02: Agregar alerta niños borrador
- IN-03: Implementar auto-guardado
- IP-01: Fix generar informes
- MU-01: Validación publicaciones

---

## 🟡 FASE 2: IMPORTANTES (26 tareas)
*Funcionalidades necesarias para operatividad completa*

### Página Institucional
- PI-04: Descomentar sección clientes
- PI-07: Agregar fallback contenido
- PI-10: Email confirmación contacto
- PI-13: Toggle anual/mensual
- PI-15: Decidir página invitaciones

### Login
- LG-01: Rediseñar login con branding
- LG-03: Configurar URL recuperación

### Plataforma - Funcionalidad
- SG-01: Sistema de notificaciones
- MU-02: Layout responsive muro
- MU-05: Editar/eliminar publicaciones
- IN-01: Filtros inscripciones
- IN-04: Validación campo por campo
- AS-02: Búsqueda rápida asistencia
- AT-02: Sincronizar rol + asistencia
- AT-04: Reenviar invitación
- AT-07: Loader lista asistentes
- AT-08: Filtros asistentes
- AT-09: Mejorar vista detalles
- GR-03: Botón editar grupo
- GR-08: Colores selección niños
- GR-09: Mejorar flujo actividades
- GR-10: Historial actividades
- FZ-06: Gráficos finanzas
- FZ-07: Exportar Excel
- FZ-08: Editar movimientos
- FZ-09: Stripe a producción
- TK-01: Mensaje vacío tareas
- TK-02: Editar tarea
- TK-03: Eliminar tarea
- TK-04: UX tipo Kanban
- TK-05: Estados de tarea
- TK-09: Pasos/subtareas
- IP-02: Selector destinatario informes
- FAC-01: Crear módulo facturación
- FAC-02: Ver comisiones LITE
- FAC-03: Ver pagos Stripe
- FAC-04: Historial suscripciones
- TR-01: Traducciones navegación

---

## 🟢 FASE 3: MEJORAS UX (30 tareas)
*Optimizaciones de experiencia y calidad*

### Página Institucional
- PI-06: Rediseño about.php
- PI-08: Cache contenido
- PI-11: Expandir países
- PI-14: Limpiar código
- PI-16: Mejorar políticas

### Login
- LG-04: Checkbox recordarme
- LG-05: Indicador caps lock
- LG-07: Optimizar sesiones

### Plataforma - UX
- SG-02: Auditoría rendimiento
- SG-03: Transiciones páginas
- MU-03: Fijar publicaciones
- MU-04: Animaciones reacciones
- MU-06: Filtros muro
- IN-05: Duplicar inscripción para hermanos
- AS-03: Estadísticas asistencia
- AS-04: Notificación padres
- AT-05: Ver estado invitación
- AT-06: Asignación asistentes a grupos
- GR-04: Drag & drop niños entre grupos
- GR-05: Horarios por grupo
- GR-06: Contador niños en card
- GR-11: Explicación gestión actividades
- TK-06: Colores por urgencia tareas
- TK-07: Trazabilidad tareas
- TK-08: Dependencias tareas
- TK-10: Onboarding tareas
- PN-01: Secciones colapsables perfil niño
- PN-02: Tabs perfil niño
- CF-01: Mis Daycares funcional
- CF-02: Gestión suscripción visible
- TR-02: Estandarizar traducciones

---

*Documento v1.0 - Plan de Tareas*
*Total: 80 tareas | 24 críticas | 26 importantes | 30 mejoras*
*Ver Diagnóstico detallado: [Diagnostico-problemas.md](Diagnostico-problemas.md)*
