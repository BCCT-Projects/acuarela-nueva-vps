# Despliegue continuo con GitHub Actions

**Fecha:** Enero 2026  
**Proyecto:** Acuarela (acuarela-nueva-vps)  
**Repositorio:** BCCT-Projects/acuarela-nueva-vps

Este documento describe el flujo de **despliegue continuo (CI/CD)** implementado con GitHub Actions: desde la rama de desarrollo hasta la sincronización con la VPS de producción y la ejecución del script de despliegue Docker.

---

## 1. Resumen del flujo

1. **Commit en `dev`** → GitHub Actions crea o actualiza un **Pull Request** hacia `main`.
2. **Aceptación del PR** (merge a `main`) → GitHub Actions sincroniza el código con la VPS vía **rsync** y ejecuta el script **`deploy-production.sh`** en el servidor.
3. El script en el servidor **reconstruye la imagen Docker** cuando hay cambios relevantes o **levanta contenedores** sin rebuild cuando no hay cambios (optimización por commit).

Todo el despliegue a producción está automatizado; no se suben archivos a mano ni se ejecutan comandos manuales en el servidor para el código que ya está en `main`.

---

## 2. Workflows

### 2.1. Rama `dev`: crear/actualizar PR hacia `main`

**Archivo:** `.github/workflows/deploy-dev.yml`

**Disparador:** `push` a la rama `dev`.

**Qué hace:**
- **No** sincroniza nada con la VPS.
- Usa GitHub CLI (`gh`) para crear un Pull Request de `dev` → `main`, o actualizar el PR abierto si ya existe.
- No requiere secretos; usa el `GITHUB_TOKEN` automático del repositorio.

**Permisos necesarios en el repositorio:**  
En *Settings → Actions → General → Workflow permissions* debe estar marcada la opción **"Allow GitHub Actions to create and approve pull requests"**.

---

### 2.2. Rama `main`: sincronizar VPS y desplegar

**Archivo:** `.github/workflows/deploy-main.yml`

**Disparador:** `push` a la rama `main` (típicamente tras merge del PR desde `dev`).

**Pasos:**

1. **Checkout** del código (solo último commit, `fetch-depth: 1`) para reducir tiempo.
2. **Configuración SSH:** se escribe la llave privada en un archivo temporal y se añade el host a `known_hosts`.
3. **Sincronización con rsync** al servidor:
   - Destino: `/home/webadmin/acuarela` (configurable vía `PROD_PATH`).
   - Se excluyen: `.git/`, `.github/`, `.env`, `vendor/`, `cache/`, `logs/`, `certs/`, archivos de IDE, etc.
   - Se usa **`--delete`** para que el destino refleje el código actual (archivos eliminados en el repo se eliminan en el servidor).
   - Se usan **`--filter 'P cache/'`** y **`--filter 'P miembros/cache/'`** para **proteger** las carpetas de cache en el servidor: no se envían desde el repo (están en `.gitignore`) pero **no se borran** en cada deploy, evitando que se pierda el cache de API (WordPress, etc.) y se degrade el rendimiento.
4. **Ejecución del script en el servidor** vía SSH (`appleboy/ssh-action`):
   - Se convierte el formato de línea del script a LF si es necesario (`sed -i 's/\r$//' deploy-production.sh`).
   - Se pasa `GITHUB_SHA` como variable de entorno.
   - Se ejecuta `./deploy-production.sh` en `/home/webadmin/acuarela`.
5. **Limpieza:** se elimina la llave SSH temporal.

**Secretos requeridos en el repositorio:**
- `VPS_HOST`: IP o hostname del servidor.
- `SSH_USERNAME`: usuario SSH (ej. `webadmin`).
- `SSH_PRIVATE_KEY`: contenido completo de la llave privada SSH (incluyendo `-----BEGIN ...` y `-----END ...`).

---

## 3. Script de despliegue en el servidor

**Archivo:** `deploy-production.sh` (en la raíz del proyecto, sincronizado por rsync).

**Comportamiento:**

- **Build condicional:** según el commit actual (`GITHUB_SHA`) y el último desplegado (archivo `.deploy_state`):
  - Si el commit es el **mismo** → solo `docker compose up -d` (sin rebuild).
  - Si hay **cambios** → `docker compose build --no-cache=false` y luego `up -d` (aprovecha cache de Docker; Composer no se reinstala si no cambia `composer.json`).
- **Limpieza:** `docker compose down` y `docker image prune -f` (imágenes huérfanas).
- **Estado:** tras un rebuild exitoso, se guarda el commit actual en `.deploy_state` para el siguiente despliegue.

**Nota:** En el servidor no existe `.git` (rsync excluye `.git/`), por lo que el script no puede calcular qué archivos cambiaron; solo compara commits. La decisión de rebuild o no se basa en si el commit cambió.

---

## 4. Protección del cache en despliegue

- Las carpetas **`cache/`** (raíz) y **`miembros/cache/`** se usan en tiempo de ejecución para cache de respuestas API (p. ej. `miembros/includes/sdk.php` con `queryWorpress` y `queryWorpressParallel`).
- Están en **`.gitignore`**, por lo que **no** se envían en el rsync.
- Si solo se usara **`--exclude='cache/'`** con **`--delete`**, rsync **borraría** esas carpetas en el destino en cada deploy, vaciando el cache y degradando el rendimiento.
- Por eso se añaden **`--filter 'P cache/'`** y **`--filter 'P miembros/cache/'`**: la regla **P (protect)** indica a rsync que **no borre** esas rutas en el destino cuando aplique `--delete`. Así el cache del servidor se conserva entre despliegues.

---

## 5. Docker en producción

- **Imagen:** construida con `Dockerfile.production`; el código se copia en el build (no se monta como volumen en producción).
- **Composer:** dependencias (p. ej. Stripe) se instalan en el build desde `miembros/acuarela-app-web/composer.json`; no se sincroniza `vendor/` por rsync.
- **Compose:** `docker-compose.production.yml` (sin atributo `version`, obsoleto en versiones recientes).

---

## 6. Evidencia técnica (Dominio 6 – Gestión de cambios)

| Elemento | Ubicación |
|----------|-----------|
| Workflow rama `dev` (PR automático) | `.github/workflows/deploy-dev.yml` |
| Workflow rama `main` (sync + deploy) | `.github/workflows/deploy-main.yml` |
| Script de despliegue en servidor | `deploy-production.sh` |
| Estado último commit desplegado | `.deploy_state` (sincronizado por rsync) |
| Exclusión y protección de cache | `deploy-main.yml` (--exclude y --filter 'P ...') |

---

## 7. Referencias

- **Protocolo de despliegue seguro:** `docs/PROTOCOLO_DESPLIEGUE_SEGURO.md`
- **Estado de cumplimiento SOC 2 / ISO (Dominio 6):** `docs/ESTADO_CUMPLIMIENTO_SOC2_ISO.md`
- **Producción y Docker:** `docs/production-deployment.md` (si existe)
