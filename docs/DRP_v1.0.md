# Plan de Recuperación ante Desastres (DRP) - Acuarela Web/App

**Versión:** 1.0
**Fecha:** 2026-01-27
**Estado:** Borrador (Draft)

---

## 5.1 Identificación del Sistema
*   **Nombre del Sistema:** Acuarela Web/App
*   **Propietario del Sistema:** BCCT
*   **Alcance:** Recuperación de la infraestructura Web (VPS), Aplicación PHP, Datos de uploads y conectividad con servicios externos.

## 5.2 Clasificación de Activos Críticos

| Activo | Tipo | Criticidad | Ubicación/Detalle |
| :--- | :--- | :--- | :--- |
| **Código Fuente** | Software | Alta | GitHub (Repositorio `acuarela-nueva-vps`) |
| **Infraestructura** | Infra | Alta | VPS (Docker Host) |
| **Base de Datos** | Datos | Crítica | Externo (Strapi Cloud / Servidor Dedicado - **MongoDB**) |
| **Archivos Uploads** | Datos | Alta | Externo (Strapi Cloud - `acuarelacore.com`) |
| **Configuración** | Config | Crítica | Archivos `.env` (**Carpeta Secretos Drive**), Certificados SSL |
| **Dependencias** | Servicios | Alta | Mandrill (Email), PayPal/Stripe (Pagos) |

## 5.3 Escenarios de Desastre Cubiertos
1.  **Caída Total del Servidor (VPS Down):** Pérdida completa de la instancia de cómputo.
2.  **Corrupción de Datos (Uploads):** Pérdida o corrupción del volumen de imágenes/documentos.
3.  **Error Humano/Deploy Fallido:** Container no inicia tras un update.
4.  **Falla de Proveedor (Strapi):** Backend indisponible (Modo degradado).
5.  **Ataque (Malware/Intrusión):** Compromiso del servidor por agente externo.
6.  **Eliminación Accidental:** Borrado de configuraciones críticas o código.

## 5.4 Objetivos de Recuperación
*   **RTO (Recovery Time Objective):** 8 horas. (Tiempo máximo para restaurar el servicio web).
*   **RPO (Recovery Point Objective):** 16 horas. (Máxima pérdida de datos aceptable para uploads/BD).

---

## 6. Procedimientos de Recuperación

### 6.1 Procedimiento General
1.  **Declaración del Incidente:** El equipo técnico confirma la caída crítica.
2.  **Evaluación:** Determinar si es falla de app, servidor o proveedor externo.
3.  **Ejecución:** Seguir el procedimiento específico según el escenario.
4.  **Validación:** Verificar acceso web, login y carga de imágenes.
5.  **Comunicación:** Informar a stakeholders.

### 6.2 Restauración de Infraestructura (Código y App)
*Caso: El servidor VPS se perdió o se requiere mover a uno nuevo.*

#### Opción A: Despliegue Automatizado (CI/CD) - **Recomendado**
El flujo estándar de recuperación aprovecha GitHub Actions, eliminando la configuración manual del servidor.

1.  **Provisionar el nuevo VPS** y habilitar acceso SSH.
2.  **Actualizar Secretos en GitHub:**
    *   Ir a `Settings > Secrets and variables > Actions` en el repositorio.
    *   Actualizar `VPS_HOST` con la **nueva IP**.
    *   Actualizar `SSH_PRIVATE_KEY` (si se generó un par de llaves nuevo).
    *   **Importante (.env):** Asegurar que los secretos de la aplicación (bases de datos, claves API) estén cargados en los secretos del repositorio, ya que el Action generará el archivo `.env` automáticamente durante el despliegue.
3.  **Disparar el Despliegue:**
    *   Re-ejecutar el último Workflow exitoso en `main` o hacer un commit vacío.
    *   El Action conectará al nuevo VPS, inyectará el `.env` y levantará Docker.

#### Opción B: Despliegue Manual (Break-glass)
*Caso: Falla en GitHub Actions o urgencia crítica.*

1.  **Acceder vía SSH** al servidor.
2.  **Clonar/Actualizar Código:**
    ```bash
    git clone <URL_DEL_REPO> acuarela-vps
    cd acuarela-vps
    ```
3.  **Configurar Secretos:**
    *   Crear `.env` manual (Recuperar de **carpeta de secretos de Drive**).
    *   Instalar certificados SSL.
4.  **Levantar Docker:**
    ```bash
    docker-compose -f docker-compose.production.yml up -d --build
    ```

### 6.3 Restauración de Datos (Uploads)
*Caso: Pérdida de imágenes o archivos subidos.*

**Nota:** La aplicación está configurada para subir archivos directamente al backend de Strapi (`acuarelacore.com`).
*   **No hay persistencia local de archivos** en este servidor VPS.
*   La recuperación de archivos depende enteramente de la estrategia de backup de **Strapi/MongoDB** (ver Sección 6.4).

### 6.4 Dependencias Externas (Strapi / APIs)
*   **Falla de Strapi:** La web mostrará errores al intentar login o ver contenido dinámico.
    *   *Acción:* Verificar estado del servidor Strapi. No hay acción de restore local para esto (es servicio externo).
    *   *Modo Degradado:* Página de mantenimiento si la API no responde > 1 hora.

### 6.5 Reversión de Cambios (Rollback)
*Caso: Un deploy introdujo un error crítico y se debe volver a la versión anterior.*

**Método Oficial (Git Revert):**
1.  **Identificar el Commit Estable:** Revisar historial en GitHub.
2.  **Revertir en Rama Local (Dev):**
    ```bash
    git checkout dev
    git pull origin dev
    git revert <HASH_DEL_COMMIT_FALLIDO>
    # Esto crea un nuevo commit que deshace los cambios "malos"
    ```
3.  **Push a Rama de Desarrollo:**
    *   `git push origin dev`
4.  **Aprobación y Despliegue:**
    *   GitHub Actions **creará automáticamente** el PR de **Dev -> Main**.
    *   El Líder Técnico aprueba y hace merge del PR.
    *   Esto dispara el despliegue automático de la versión corregida.

*(Nota: Se utiliza `git revert` para mantener la historia limpia, en lugar de resets forzados).*

---

## 7. Roles y Responsabilidades (RACI)

| Rol | Responsabilidad |
| :--- | :--- |
| **Líder Técnico** | **(A/R)** Activa el DRP y dirige la recuperación técnica. |
| **DevOps / SysAdmin** | **(R)** Ejecuta los comandos de restore y provisión de servidor. |
| **QA / Soporte** | **(C)** Valida que el sistema recuperado funcione correctamente. |
| **Gerencia** | **(I)** Recibe informes de estado y comunica a clientes si es necesario. |

---

## 8. Evidencia y Mantenimiento
*   Este documento debe ser revisado **anualmente**.
*   Cada prueba de DR debe generar un reporte de "Lecciones Aprendidas".

## 9. Historial de Pruebas de Recuperación (DR Test Log)

| Fecha | Escenario Probado | Resultado | Realizado por | Evidencia/Notas |
| :--- | :--- | :--- | :--- | :--- |
| **2026-01-27** | Restauración Manual (Localhost) | **Exitoso** | Equipo Técnico | **Todo funcionó correctamente** (app funcional en puerto 3000). Se valida el uso del `.env` recuperado de la **carpeta de secretos de Drive**. |
| *Pendiente* | Despliegue CI/CD (Github Actions) | - | - | Requiere validar flujo automático con secretos. |
