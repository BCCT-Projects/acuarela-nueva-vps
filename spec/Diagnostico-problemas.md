# Diagnóstico de Problemas - Plataforma Acuarela

**Fecha:** Marzo 2026
**Versión:** 1.0

---

# RESUMEN EJECUTIVO

| Parte | Críticos | Importantes | Mejoras | Total |
|-------|----------|-------------|---------|-------|
| Página Institucional | 5 | 3 | 4 | 12 |
| Login/Autenticación | 2 | 2 | 3 | 7 |
| Plataforma Principal | 17 | 21 | 23 | 61 |
| **TOTAL** | **24** | **26** | **30** | **80** |

---

# PARTE 1: PÁGINA INSTITUCIONAL

## 1.1 Home (index.php)

| ID | Problema | Criticidad | Descripción |
|----|----------|------------|-------------|
| PI-01 | Modal demo tiene "Lorem Ipsum" | CRITICO | El modal de demostración muestra texto placeholder en lugar de contenido real |
| PI-02 | reCAPTCHA comentado | CRITICO | El formulario no tiene protección contra bots |
| PI-03 | Mensaje planes desactualizado | CRITICO | El texto no refleja el modelo actual LITE gratis + comisiones |
| PI-04 | Sección clientes comentada | IMPORTANTE | Código de sección de clientes/daycares está comentado |
| PI-05 | Testimonios no cargan imágenes | CRITICO | Las imágenes de testimonios no se muestran correctamente |

## 1.2 Sobre Nosotros (about.php)

| ID | Problema | Criticidad | Descripción |
|----|----------|------------|-------------|
| PI-06 | Diseño desactualizado | MEJORA | Layout y estilo visual necesitan modernización |
| PI-07 | Contenido 100% dinámico sin fallback | IMPORTANTE | Si la API falla, la página queda vacía |
| PI-08 | Sin cache de contenido | MEJORA | Cada visita hace petición a API sin cache |

## 1.3 Contacto (contact.php)

| ID | Problema | Criticidad | Descripción |
|----|----------|------------|-------------|
| PI-09 | Sin validación frontend | CRITICO | Campos no validan antes de enviar |
| PI-10 | Sin email confirmación usuario | IMPORTANTE | Usuario no recibe confirmación de envío |
| PI-11 | Selector país limitado | MEJORA | Solo 4 opciones de países |

## 1.4 Planes y Precios (pricing.php)

| ID | Problema | Criticidad | Descripción |
|----|----------|------------|-------------|
| PI-12 | Planes desactualizados | CRITICO | Contenido no refleja modelo LITE gratis + comisiones PRO |
| PI-13 | Toggle anual/mensual no funciona | IMPORTANTE | El switch de frecuencia no tiene funcionalidad |
| PI-14 | Mucho código comentado | MEJORA | Código legible que debería limpiarse |

## 1.5 Invitaciones (invitation.php)

| ID | Problema | Criticidad | Descripción |
|----|----------|------------|-------------|
| PI-15 | Evaluar si mantener | IMPORTANTE | Con el nuevo modelo, esta página puede no ser necesaria |

## 1.6 Políticas (politics.php)

| ID | Problema | Criticidad | Descripción |
|----|----------|------------|-------------|
| PI-16 | Contenido y diseño mejorar | MEJORA | Textos legales y presentación visual |

---

# PARTE 2: LOGIN / AUTENTICACIÓN

## 2.1 Login (miembros/index.php)

| ID | Problema | Criticidad | Descripción |
|----|----------|------------|-------------|
| LG-01 | Diseño no ambientado a Acuarela | IMPORTANTE | Login no refleja branding de Acuarela |
| LG-02 | Sin "Olvidé contraseña" visible | CRITICO | Link de recuperación no es visible para usuarios |
| LG-03 | Recuperar en dominio externo | IMPORTANTE | Redirige a bilingualchildcaretraining.com |
| LG-04 | Sin "Recordarme" | MEJORA | No hay opción para mantener sesión |
| LG-05 | Sin indicador caps lock | MEJORA | Usuario no sabe si mayúsculas activas |

## 2.2 Sistema de Sesiones

| ID | Problema | Criticidad | Descripción |
|----|----------|------------|-------------|
| LG-06 | Verificar sesiones 8h | CRITICO | Confirmar que la sesión dura 8 horas correctamente |
| LG-07 | Optimizar sesiones | MEJORA | Revisar configuración de garbage collection |

---

# PARTE 3: PLATAFORMA PRINCIPAL

## 3.0 Sistema Global

| ID | Problema | Criticidad | Descripción |
|----|----------|------------|-------------|
| SG-01 | Sin sistema de notificaciones | IMPORTANTE | No hay campana ni centro de notificaciones |
| SG-02 | Rendimiento general | MEJORA | Posibles mejoras en queries y assets |
| SG-03 | Fluidez entre páginas | MEJORA | Transiciones abruptas entre secciones |

## 3.1 Social (Muro)

| ID | Problema | Criticidad | Descripción |
|----|----------|------------|-------------|
| MU-01 | Sin validación al crear publicación | CRITICO | Se puede enviar formulario vacío |
| MU-02 | Layout no responsive | IMPORTANTE | Vista móvil deficiente |
| MU-03 | Sin poder fijar publicaciones | MEJORA | No hay forma de destacar posts importantes |
| MU-04 | Sin animaciones en reacciones | MEJORA | Likes y comentarios sin feedback visual |
| MU-05 | Sin editar/eliminar publicaciones | IMPORTANTE | Usuario no puede modificar sus posts |
| MU-06 | Sin filtros | MEJORA | No se puede filtrar por fecha, grupo, actividad |

## 3.2 Inscripciones (Agregar Niños)

| ID | Problema | Criticidad | Descripción |
|----|----------|------------|-------------|
| IN-01 | Sin filtros por parámetros | IMPORTANTE | No se puede filtrar por grupo, edad, asistente |
| IN-02 | Niños en borrador sin alerta | CRITICO | Estado borrador no es visible claramente |
| IN-03 | Sin auto-guardado | CRITICO | Pérdida de datos si usuario cierra sin guardar |
| IN-04 | Validación solo al final | IMPORTANTE | Errores se muestran solo al submit |
| IN-05 | Sin duplicar para hermanos | MEJORA | Proceso tedioso para inscribir hermanos |

## 3.3 Asistencia

| ID | Problema | Criticidad | Descripción |
|----|----------|------------|-------------|
| AS-01 | Fecha por defecto muestra "AYER" | CRITICO | Default incorrecto confunde al usuario |
| AS-02 | Sin búsqueda rápida por nombre | IMPORTANTE | Lista larga de niños difícil de navegar |
| AS-03 | Sin estadísticas de asistencia | MEJORA | No hay métricas ni gráficos |
| AS-04 | Sin notificación automática padres | MEJORA | Padres no reciben aviso de asistencia |

## 3.4 Asistentes

| ID | Problema | Criticidad | Descripción |
|----|----------|------------|-------------|
| AT-01 | Error: app se cierra al editar asistente | CRITICO | Bug que impide editar asistentes |
| AT-02 | Sincronizar rol + asistencia | IMPORTANTE | Rol no se refleja en permisos de asistencia |
| AT-03 | Sin sistema de permisos/roles | CRITICO | Todos tienen los mismos permisos |
| AT-04 | Sin reenviar invitación | IMPORTANTE | No se puede reenviar invitación pendiente |
| AT-05 | Sin ver si aceptó invitación | MEJORA | Estado de invitación no visible |
| AT-06 | Sin asignación a grupos | MEJORA | Asistentes no vinculados a grupos |
| AT-07 | Sin loader al cargar lista | IMPORTANTE | Lista de asistentes carga sin indicador visual |
| AT-08 | Sin filtros básicos | IMPORTANTE | No se puede filtrar por nombre, rol, estado |
| AT-09 | Vista detalles muy pobre | IMPORTANTE | Modal de detalles muestra información mínima, diseño deficiente |

## 3.5 Grupos

| ID | Problema | Criticidad | Descripción |
|----|----------|------------|-------------|
| GR-01 | **BUG: Límite LITE 3 grupos NO funciona** | CRITICO | Usuarios LITE pueden crear más de 3 grupos |
| GR-02 | **BUG: Botón Eliminar grupo NO funciona** | CRITICO | Click en eliminar no ejecuta acción |
| GR-03 | Sin botón editar grupo | IMPORTANTE | Solo existe opción eliminar |
| GR-04 | Sin drag & drop para asignar niños | MEJORA | Asignación manual poco práctica |
| GR-05 | Sin horarios por grupo | MEJORA | Grupos no tienen horarios definidos |
| GR-06 | Sin contador de niños en card | MEJORA | No muestra cuántos niños tiene el grupo |
| GR-07 | Nombres de niños NO se desencriptan en actividades | CRITICO | Al agregar actividad/integrantes, nombres aparecen encriptados |
| GR-08 | Colores en selección de niños confusos | IMPORTANTE | Los 3 botones de rate (verde/amarillo/rojo) no tienen colores visibles ni explicación del significado |
| GR-09 | Flujo creación actividades pobre UX | IMPORTANTE | Wizard de 3 pasos sin indicadores, sin progreso visual, sin explicaciones |
| GR-10 | Sin historial/registro de actividades | IMPORTANTE | No hay trazabilidad de actividades realizadas por el grupo |
| GR-11 | Sin explicación gestión actividades | MEJORA | Usuario no entiende cómo funciona el sistema de actividades y rates |

## 3.6 Finanzas

| ID | Problema | Criticidad | Descripción |
|----|----------|------------|-------------|
| FZ-01 | **BUG: Botón "Agregar ingreso" NO funciona** | CRITICO | Botón no tiene onclick |
| FZ-02 | **BUG: Botón "Agregar gasto" NO funciona** | CRITICO | Botón no tiene onclick |
| FZ-03 | Modal Stripe bloqueante | CRITICO | Modal impide usar la app si no hay cuenta |
| FZ-04 | Sin modal formulario ingreso | CRITICO | No existe UI para agregar ingreso manual |
| FZ-05 | Sin modal formulario gasto | CRITICO | No existe UI para agregar gasto manual |
| FZ-06 | Sin gráficos visuales | IMPORTANTE | Solo tablas, sin dashboard visual |
| FZ-07 | Sin exportación Excel/PDF | IMPORTANTE | No se pueden descargar reportes |
| FZ-08 | Sin editar/eliminar movimientos | IMPORTANTE | Movimientos son permanentes |
| FZ-09 | Stripe Connect a producción | IMPORTANTE | Sistema en Test Mode, pendiente producción |

## 3.7 Tareas

| ID | Problema | Criticidad | Descripción |
|----|----------|------------|-------------|
| TK-01 | **BUG: Sin mensaje cuando no hay tareas** | IMPORTANTE | Lista vacía no muestra feedback |
| TK-02 | **BUG: Sin editar tarea existente** | IMPORTANTE | No se pueden modificar tareas |
| TK-03 | **BUG: Sin eliminar tarea** | IMPORTANTE | No se pueden borrar tareas |
| TK-04 | UX muy básica | IMPORTANTE | Interfaz tipo lista simple |
| TK-05 | Sin estados de tarea | IMPORTANTE | Solo completado/no completado |
| TK-06 | Sin colores por urgencia | MEJORA | No destaca tareas urgentes |
| TK-07 | Sin trazabilidad/historial | MEJORA | No registra quién completó/cuándo |
| TK-08 | Sin dependencias entre tareas | MEJORA | Tareas no se relacionan entre sí |
| TK-09 | Tareas muy básicas sin detalle | IMPORTANTE | No hay opción de agregar pasos/subtareas ni descripción detallada |
| TK-10 | Sin explicación del flujo | MEJORA | Usuario no entiende la utilidad y flujo del módulo de tareas |

## 3.8 Inspección

| ID | Problema | Criticidad | Descripción |
|----|----------|------------|-------------|
| IP-01 | Generar informes NO funciona | CRITICO | Botón no genera reporte |
| IP-02 | Sin decidir destinatario informe | IMPORTANTE | No hay selector de destino |

## 3.9 Perfil del Niño

| ID | Problema | Criticidad | Descripción |
|----|----------|------------|-------------|
| PN-01 | Información muy densa | MEJORA | Muchos datos sin organización |
| PN-02 | Sin tabs para organizar | MEJORA | Todo en una sola vista |

## 3.10 Configuración

| ID | Problema | Criticidad | Descripción |
|----|----------|------------|-------------|
| CF-01 | "Mis Daycares" sin funcionalidad | MEJORA | Lista no permite cambiar de daycare |
| CF-02 | Sin gestión suscripción visible | MEJORA | Usuario no ve estado de su plan |

## 3.11 Facturación (NUEVO MÓDULO)

| ID | Problema | Criticidad | Descripción |
|----|----------|------------|-------------|
| FAC-01 | Sin módulo de facturación | IMPORTANTE | No existe sección para ver historial de pagos a la plataforma |
| FAC-02 | Sin ver comisiones LITE | IMPORTANTE | Usuarios LITE no ven comisiones cobradas |
| FAC-03 | Sin ver pagos a Stripe | IMPORTANTE | No hay forma de ver fees de pasarela de pago |
| FAC-04 | Sin ver historial suscripciones | IMPORTANTE | Usuarios PRO no ven historial de pagos de suscripción |

## 3.12 Traducciones / Idiomas

| ID | Problema | Criticidad | Descripción |
|----|----------|------------|-------------|
| TR-01 | Traducciones incompletas en nav | IMPORTANTE | Partes de la navegación no se traducen de inglés a español |
| TR-02 | Sistema de traducciones inconsistente | MEJORA | Algunos textos usan data-translate, otros están hardcodeados |

---

*Documento v1.1 - Diagnóstico de Problemas*
*Total: 80 problemas | 24 críticos | 26 importantes | 30 mejoras*
*Ver Plan de Tareas: [plan-tareas-mejora.md](plan-tareas-mejora.md)*
