# Informe de Diagnóstico Técnico - Plataforma Acuarela Web

**Fecha:** 27 de Enero, 2026
**Versión:** 1.0
**Alcance:** Acuarela App Web (Miembros), Backend (PHP), Integraciones (Stripe/PayPal), UX/UI
**Estado:** Finalizado

---

## 1. Resumen Ejecutivo

El presente diagnóstico revela que la plataforma Acuarela Web, aunque funcional en sus características básicas, presenta una **deuda técnica crítica** que compromete su escalabilidad, seguridad y experiencia de usuario a corto plazo.

Se han identificado **114 oportunidades de mejora**, de las cuales un **30% son de prioridad crítica** (Estabilidad, Performance y Dashboard). La arquitectura actual basada en PHP nativo con múltiples SDKs no estandarizados y consultas a base de datos (Strapi) ineficientes (problema N+1, falta de paginación) está generando cuellos de botella severos.

La intervención inmediata es necesaria para evitar:
1.  Fallo sistémico al aumentar la carga de usuarios (por falta de paginación y optimización).
2.  Abandono de usuarios por fricción en la experiencia (tiempos de carga y falta de feedback visual).

---

## 2. Contexto y Referencias

Este informe da continuidad a los análisis previos de seguridad y funcionalidad. Se toma como referencia:
*   **Diagnóstico Previo:** Auditoría de acuarela web  y Seguridad (2025).
*   **Base de Código:** Repositorio actual `acuarela-nueva-vps`.

El foco de este nuevo diagnóstico ha sido profundizar en la **Experiencia de Usuario (UX)**, **Performance del Frontend/Backend** y la **Seguridad Operativa** de los módulos de miembros.

---

## 3. Descripción del Estado Actual

### Arquitectura Técnica
*   **Backend:** PHP nativo mezclado con lógica de presentación. Multiplicidad de librerías SDK (Stripe/PayPal) redundantes.
*   **Frontend:** JavaScript vanilla (`main.js` monolítico de >6,000 líneas) y CSS sin procesar.
*   **Datos:** Consultas directas a Strapi sin capa de caché intermedia eficiente ni paginación en el backend.

### Experiencia de Usuario (UX)
*   **Navegación:** Funcional pero lenta. Falta de feedback visual (skeleton loaders) durante las cargas.
*   **Mobile:** Tablas y vistas de datos no optimizadas para dispositivos móviles (rompen el layout).
*   **Interacción:** Ausencia de validaciones en tiempo real y estados de carga en botones, provocando errores por doble envío.

---

## 4. Listado Consolidado de Problemas

Se han categorizado los hallazgos en 4 áreas principales:

### A. Estabilidad, Deuda Técnica y Limpieza (Crítico)
1.  **Limpieza de Código Legacy:** Presencia de archivos de prueba (`createproduct.php`, `paypaltoken.php`) con credenciales sandbox hardcodeadas que deben eliminarse o refactorizarse para evitar confusión.
2.  **Robustez Web:** Ausencia de protección CSRF en formularios y falta de Rate Limiting en endpoints.
3.  **Código Redundante:** 3 implementaciones diferentes de clientes HTTP/SDKs.

### B. Performance y Escalabilidad (Alto Riesgo)
1.  **Problema N+1:** El endpoint `getInscripciones` realiza una consulta API adicional *por cada niño* para obtener consentimientos, saturando el servidor con N usuarios.
2.  **Ausencia de Paginación Server-Side:** Listas de Niños, Asistencia y Finanzas cargan *todos* los registros de la base de datos en memoria. Daycares grandes colapsarán la vista.
3.  **Recursos Pesados:** Archivo `main.js` monolítico de 283KB sin minificar; imágenes subidas sin compresión.

### C. Funcionalidad y Lógica de Negocio
1.  **Control de Asistencia:** Limitado a uno por uno; falta funcionalidad grupal crítica para operación diaria.
2.  **Finanzas:** Reportes limitados, sin gráficas ni capacidad de exportación real.
3.  **Roles:** Sistema de permisos (Admin vs Asistente) ambiguo y parcialmente implementado.

### D. UX/UI y Contenido
1.  **Contenido Falso:** Presencia de textos "Lorem Ipsum" en modales de producción (Demo).
2.  **Feedback Pobre:** Uso de preloader genérico bloqueante en lugar de cargas progresivas (Skeleton).
3.  **Mobile:** Tablas de datos ilegibles en pantallas pequeñas.

### E. Módulos Secundarios (Revisados)
1.  **Reportes de Salud:** Formulario sin validación en tiempo real de campos.
2.  **Reportes de Incidentes:** Sin historial/timeline de incidentes previos del niño.
3.  **Checklist/Tareas:** Selector de asistentes hardcodeado y sin edición/eliminación.
4.  **Visitas:** Módulo vacío sin implementar.
5.  **Modo Inspección:** Sin preview de reporte ni historial de generados.
6.  **Dashboard:** Módulo descubierto a medias. Existe la estructura básica con widgets Chart.js, pero:
    - Los datos son **hardcodeados** (no conectados a API)
    - Los botones "Agregar" redirigen incorrectamente a `/inspeccion`
    - No hay persistencia de widgets seleccionados
    - 2 widgets definidos en `add.php` no tienen gráfica en `widgets.php`
    - No está visible en el sidebar
    - No es la página de inicio (es Social)

---

## 5. Matriz de Hallazgos por Severidad

| Severidad | Cantidad | Ejemplos Principales | Impacto |
|:---:|:---:|---|---|
| 🔴 **CRÍTICA** | ~18 | Falta de Paginación, N+1 Query, Módulo Visitas vacío | **Pérdida de servicio o inestabilidad** |
| 🟠 **ALTA** | ~28 | Falta CSRF, Tablas no responsive, Validaciones, Checklist dinámico | Degradación severa de UX |
| 🟡 **MEDIA** | ~36 | Falta de Skeleton Loaders, Textos Lorem Ipsum, Preview Reportes | Fricción en el uso diario |
| 🔵 **BAJA** | ~20 | Mejoras visuales menores, SEO, Historial reportes | Oportunidad de mejora |

---

## 6. Evidencias Técnicas

**Evidencia 1: Problema N+1 en `getInscripciones.php`**
```php
// Ciclo que ejecuta una consulta HTTP por CADA niño en el array
foreach ($posts as &$post) {
    // ...
    if ($childId) {
        // ESTO MATARÁ EL RENDIMIENTO CON MUCHOS NIÑOS
        $consents = $a->queryStrapi("parental-consents?child_id=$childId...");
    }
}
```

**Evidencia 2: Carga Masiva sin Paginación (`sdk.php` / `getInscripciones`)**
*   No existe parámetro `_limit` ni `_start` en las llamadas principales, lo que obliga a traer toda la colección de Strapi a la memoria de PHP.

**Evidencia 3: Archivo Monolítico (`main.js`)**
*   Tamaño: ~283KB
*   Líneas: >6,180
*   Consecuencia: Tiempo de "Parse & Compile" elevado en móviles de gama media/baja.

---

## 7. Análisis de Riesgos

### 🚨 Riesgos Técnicos
*   **Colapso por Carga:** Al escalar a daycares con >100 niños, las pantallas de asistencia y listados dejarán de cargar por timeout (504 Gateway Time-out) debido a la falta de paginación y problema N+1.
*   **Deuda Técnica Insostenible:** La duplicidad de SDKs hace que actualizar una librería de pagos requiera cambios en 5-6 archivos dispersos, aumentando el riesgo de romper los pagos.

### 💼 Riesgos de Negocio
*   **Pérdida de Confianza:** Textos de "Lorem Ipsum" en producción transmiten falta de profesionalismo.
*   **Churn (Abandono):** La lentitud en tareas repetitivas (asistencia diaria) frustrará a los usuarios operativos.
*   **Fraude/Abuso:** La falta de Rate Limiting permite ataques de fuerza bruta o scraping de datos.

### ⚖️ Riesgos de Cumplimiento
*   **Mantenibilidad:** Código de prueba en repositorio productivo genera deuda técnica y confusión para nuevos desarrolladores.
*   **CSRF:** La falta de tokens permite que un atacante fuerce acciones en nombre de un usuario logueado sin su consentimiento.

---

## 8. Documento Relacionado

El plan de acción detallado con las **114 mejoras identificadas**, su priorización y cronograma de ejecución en 5 fases semanales se encuentra en:

📄 **[PLAN_MEJORA_ACUARELA.md](./PLAN_MEJORA_ACUARELA.md)**

---

*Fin del Informe de Diagnóstico Técnico - Acuarela Web*
