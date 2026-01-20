# Documentación Técnica: Sistema de Retención Automática de Datos

**Proyecto:** Acuarela Web Application  
**Fecha de Implementación:** 20 de Enero, 2026  
**Versión:** 1.0.0  
**Responsable Técnico:** Equipo DevOps BCCT  
**Marco Normativo:** ISO/IEC 27001, COPPA, CCPA/CPRA

---

## Tabla de Contenidos

1. [Resumen Ejecutivo](#resumen-ejecutivo)
2. [Arquitectura del Sistema](#arquitectura-del-sistema)
3. [Componentes Implementados](#componentes-implementados)
4. [Configuración y Despliegue](#configuración-y-despliegue)
5. [Reglas de Retención](#reglas-de-retención)
6. [Auditoría y Logging](#auditoría-y-logging)
7. [Integración con Docker](#integración-con-docker)
8. [Gestión de Dependencias](#gestión-de-dependencias)
9. [Operación y Mantenimiento](#operación-y-mantenimiento)
10. [Troubleshooting](#troubleshooting)

---

## Resumen Ejecutivo

Se implementó un sistema automatizado de retención y purga de datos para cumplir con las normativas de protección de datos (ISO 27001, COPPA, CCPA) y optimizar el uso de recursos del servidor. El sistema opera mediante un job programado (cron) que se ejecuta dentro del contenedor Docker de producción.

### Objetivos Alcanzados

✅ Purga automática de logs y archivos temporales según políticas definidas  
✅ Auditoría completa con trazabilidad de todas las operaciones  
✅ Persistencia de logs de auditoría fuera del contenedor (inmune a rebuilds)  
✅ Gestión automatizada de dependencias PHP mediante Composer  
✅ Optimización de builds Docker mediante exclusión de archivos innecesarios  
✅ Modo de simulación (dry-run) para validación segura  

---

## Arquitectura del Sistema

### Diagrama de Flujo

```
┌─────────────────────┐
│   Cron (Host)       │
│   0 3 * * *         │
└──────────┬──────────┘
           │
           ▼
┌─────────────────────────────────────┐
│   Docker Container                  │
│   acuarela-web-prod                 │
│                                     │
│  ┌──────────────────────────────┐  │
│  │  run_retention.php           │  │
│  │  (Script de Entrada)         │  │
│  └────────────┬─────────────────┘  │
│               │                     │
│               ▼                     │
│  ┌──────────────────────────────┐  │
│  │  RetentionJob.php            │  │
│  │  (Motor Principal)           │  │
│  └────────────┬─────────────────┘  │
│               │                     │
│       ┌───────┴────────┐            │
│       │                │            │
│       ▼                ▼            │
│  ┌─────────┐    ┌──────────────┐   │
│  │ Reglas  │    │ AuditLogger  │   │
│  │ (JSON)  │    │   (Logs)     │   │
│  └─────────┘    └──────┬───────┘   │
│                        │            │
└────────────────────────┼────────────┘
                         │
                         ▼
                ┌────────────────┐
                │ Host Volume    │
                │ miembros/cron/ │
                │ logs/audit.log │
                └────────────────┘
```

### Stack Tecnológico

- **Lenguaje:** PHP 8.2
- **Orquestación:** Docker Compose 3.8
- **Scheduler:** Cron (Linux)
- **Formato de Configuración:** JSON
- **Formato de Logs:** JSON Lines (JSONL)
- **Gestión de Dependencias:** Composer 2.x

---

## Componentes Implementados

### 1. AuditLogger.php

**Ubicación:** `miembros/cron/AuditLogger.php`

**Responsabilidad:** Registro estructurado de eventos de auditoría.

**Características:**
- Formato JSON para facilitar parsing automatizado
- Timestamps en formato ISO 8601
- Diferenciación de modos (DRY_RUN / EXECUTE)
- Salida dual: archivo + stdout (para captura por logs de Docker)

**Ejemplo de Salida:**
```json
{"timestamp":"2026-01-20 16:30:37","event":"JOB_STARTED","mode":"DRY_RUN","details":{"message":"Starting retention job"}}
```

### 2. RetentionJob.php

**Ubicación:** `miembros/cron/RetentionJob.php`

**Responsabilidad:** Lógica de negocio del sistema de retención.

**Métodos Principales:**
- `run()`: Orquesta la ejecución completa del job
- `processRule($rule)`: Procesa una regla individual
- `processFileRule($rule)`: Implementa lógica de purga de archivos locales

**Manejo de Errores:**
- Try/catch por regla individual (fallo no bloquea ejecución de otras reglas)
- Logging de errores sin exposición de PII
- Continuación garantizada ante fallos parciales

### 3. run_retention.php

**Ubicación:** `miembros/cron/run_retention.php`

**Responsabilidad:** Script de entrada CLI.

**Argumentos:**
- `--dry-run`: Modo simulación (no realiza cambios)
- (sin argumentos): Modo ejecución real

**Seguridad:**
- Verificación de SAPI (solo ejecución CLI)
- Delay de 3 segundos en modo ejecución real (prevención de ejecución accidental)

### 4. retention_rules.json

**Ubicación:** `miembros/cron/retention_rules.json`

**Formato:**
```json
{
  "name": "nombre_regla",
  "type": "file",
  "path": "../../ruta/relativa/*.extension",
  "retention_days": 90,
  "action": "delete"
}
```

**Campos:**
- `name`: Identificador único de la regla
- `type`: Tipo de procesamiento (`file` implementado)
- `path`: Ruta relativa desde `miembros/cron/` (soporta wildcards)
- `retention_days`: Antigüedad mínima para considerar archivo como candidato
- `action`: Acción a ejecutar (`delete` implementado)

---

## Configuración y Despliegue

### Dockerfile.production

**Cambios Implementados:**

```dockerfile
# Línea 54-65: Instalación de Composer y Dependencias
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

COPY --chown=www-data:www-data miembros/acuarela-app-web/composer.json \
     miembros/acuarela-app-web/composer.lock* \
     /var/www/html/miembros/acuarela-app-web/

WORKDIR /var/www/html/miembros/acuarela-app-web
RUN composer install --no-dev --no-scripts --optimize-autoloader --no-interaction

WORKDIR /var/www/html
COPY --chown=www-data:www-data . /var/www/html/
```

**Beneficios:**
- Dependencias (Stripe, etc.) instaladas automáticamente en build
- Aprovechamiento de cache de Docker (solo reinstala si `composer.json` cambia)
- Autoloader optimizado para producción

### docker-compose.production.yml

**Volumen Crítico Añadido:**

```yaml
volumes:
  - ./logs:/var/log/apache2:rw
  - ./miembros/cron/logs:/var/www/html/miembros/cron/logs:rw  # ← NUEVO
  - acuarela_uploads:/var/www/html/uploads:rw
  - php_sessions:/tmp:rw
```

**Implicaciones:**
- Los logs de auditoría persisten en el host (`~/acuarela/miembros/cron/logs/`)
- Inmunes a `docker compose down` o rebuilds
- Accesibles sin necesidad de `docker exec`
- Cumplimiento de requisito de evidencia auditable (ISO 27001)

### .dockerignore

**Nuevas Exclusiones:**

```
# Logs y Cache
logs/
cache/
miembros/cache/
admin/wp-admin/log/
error_log
wp_debug.log
**/logs/
**/cache/
```

**Impacto:**
- Imágenes Docker más ligeras (reducción ~50MB en builds típicos)
- Evita copiar logs viejos del ambiente de desarrollo
- Cada deploy empieza con estado limpio

### .gitignore

**Nuevas Entradas:**

```
miembros/cache/
admin/wp-admin/log/
logs/
*.log
```

**Propósito:**
- Evitar commit accidental de logs con PII
- Mantener repositorio limpio de archivos temporales

---

## Reglas de Retención

### Tabla de Reglas Configuradas

| Regla | Objetivo | Ruta | Retención | Justificación |
|:------|:---------|:-----|:----------|:--------------|
| `purge_local_logs` | Logs de aplicación | `logs/*.log` | 90 días | Balance entre debugging y compliance |
| `purge_root_error_log` | Error log raíz | `error_log` | 30 días | Alto volumen, bajo valor histórico |
| `purge_api_cache` | Caché de APIs | `cache/*.json` | 7 días | Caché se regenera automáticamente |
| `purge_miembros_cache` | Caché WP | `miembros/cache/wp/*.json` | 7 días | Reducción de datos temporales |
| `purge_admin_logs` | Logs administrativos | `admin/wp-admin/log/*.log` | 60 días | Valor para auditorías internas |

### Criterios de Selección de Períodos

- **7 días:** Archivos de caché (regenerables, bajo riesgo)
- **30 días:** Logs de error (alto volumen)
- **60 días:** Logs administrativos (soporte técnico)
- **90 días:** Logs de aplicación (compliance mínimo)

**Base Legal:**
- ISO 27001: A.18.1.3 (Protección de registros)
- COPPA: Minimización de datos de menores
- CCPA: § 1798.105 (Derecho al olvido)

---

## Auditoría y Logging

### Estructura del Log de Auditoría

**Archivo:** `miembros/cron/logs/audit.log`

**Eventos Registrados:**

| Evento | Descripción | Campos Adicionales |
|:-------|:------------|:-------------------|
| `JOB_STARTED` | Inicio de ejecución | `message` |
| `JOB_COMPLETED` | Fin de ejecución | `message` |
| `RULE_START` | Inicio de regla | `rule` (name) |
| `RULE_SUMMARY` | Resumen de regla | `rule`, `analyzed`, `candidates`, `deleted` |
| `RULE_SKIPPED` | Regla omitida | `rule`, `reason` |
| `RULE_ERROR` | Error en regla | `rule`, `error` |
| `ITEM_CANDIDATE` | Archivo candidato (dry-run) | `rule`, `file`, `age_days` |
| `ITEM_DELETED` | Archivo eliminado | `file` |
| `ITEM_ERROR` | Error al eliminar | `file`, `message` |

### Acceso a Logs para Auditoría

**Vía Host (recomendado para auditorías):**
```bash
cat ~/acuarela/miembros/cron/logs/audit.log
```

**Vía Docker:**
```bash
docker exec acuarela-web-prod cat /var/www/html/miembros/cron/logs/audit.log
```

**Procesamiento Automatizado:**
```bash
# Contar ejecuciones del último mes
grep "JOB_COMPLETED" audit.log | grep "2026-01" | wc -l

# Ver archivos eliminados hoy
grep "ITEM_DELETED" audit.log | grep "$(date +%Y-%m-%d)"

# Exportar a CSV para análisis
jq -r '[.timestamp, .event, .details.rule, .details.deleted] | @csv' audit.log > report.csv
```

---

## Integración con Docker

### Comando de Ejecución Manual

**Simulacro (Dry-run):**
```bash
docker exec -it acuarela-web-prod php /var/www/html/miembros/cron/run_retention.php --dry-run
```

**Ejecución Real:**
```bash
docker exec -it acuarela-web-prod php /var/www/html/miembros/cron/run_retention.php
```

### Automatización con Cron (Host)

**Archivo:** `/etc/crontab` o `crontab -e` (usuario webadmin)

**Configuración:**
```bash
# Ejecutar diariamente a las 3:00 AM (bajo tráfico)
0 3 * * * docker exec acuarela-web-prod php /var/www/html/miembros/cron/run_retention.php >> /var/log/acuarela-retention.log 2>&1
```

**Notas:**
- El output va a `/var/log/acuarela-retention.log` (independiente del audit.log)
- Captura tanto stdout como stderr (debugging de fallos catastróficos)
- Se ejecuta en el contexto del usuario que configura el cron

### Verificación de Cron Activo

```bash
# Ver tareas programadas del usuario actual
crontab -l

# Ver última ejecución (requiere mailutils)
tail -f /var/log/syslog | grep CRON

# Verificar si el contenedor está corriendo
docker ps | grep acuarela-web-prod
```

---

## Gestión de Dependencias

### composer.json

**Ubicación:** `miembros/acuarela-app-web/composer.json`

**Dependencias Actuales:**
```json
{
  "require": {
    "php": "^8.1",
    "stripe/stripe-php": "^10.0"
  }
}
```

### Flujo de Instalación en Build

1. Dockerfile copia `composer.json` y `composer.lock` (si existe)
2. Ejecuta `composer install --no-dev --no-scripts --optimize-autoloader`
3. Copia el resto del código (aprovecha cache de Docker)

### Verificación Post-Deploy

**Confirmar que Stripe está disponible:**
```bash
docker exec acuarela-web-prod php -r "require '/var/www/html/miembros/acuarela-app-web/vendor/autoload.php'; echo class_exists('\\Stripe\\Stripe') ? 'OK' : 'FAIL'; echo PHP_EOL;"
```

**Salida esperada:** `OK`

### Agregar Nuevas Dependencias

1. Actualizar `composer.json` localmente
2. Generar `composer.lock` (opcional pero recomendado):
   ```bash
   composer update --lock
   ```
3. Commit y push de ambos archivos
4. Rebuild de Docker:
   ```bash
   ./deploy-production.sh
   ```

---

## Operación y Mantenimiento

### Modificar Reglas de Retención

**1. Editar archivo de configuración:**
```bash
nano ~/acuarela/miembros/cron/retention_rules.json
```

**2. Validar JSON:**
```bash
cat retention_rules.json | jq .
```
*(Salida sin errores = JSON válido)*

**3. Probar en Dry-run:**
```bash
docker exec acuarela-web-prod php /var/www/html/miembros/cron/run_retention.php --dry-run
```

**4. Aplicar cambios:**
No requiere reinicio de contenedor. El script lee el JSON en cada ejecución.

### Monitoreo de Espacio en Disco

**Antes de la purga:**
```bash
du -sh ~/acuarela/cache ~/acuarela/logs ~/acuarela/admin/wp-admin/log
```

**Después de la purga (comparar):**
```bash
du -sh ~/acuarela/miembros/cron/logs/audit.log
grep "RULE_SUMMARY" audit.log | tail -5
```

### Rotación de Logs de Auditoría

El archivo `audit.log` crece indefinidamente. Para evitar problemas:

**Opción 1: Logrotate (recomendado)**

Crear `/etc/logrotate.d/acuarela-retention`:
```
/home/webadmin/acuarela/miembros/cron/logs/audit.log {
    daily
    rotate 365
    compress
    delaycompress
    missingok
    notifempty
    create 0644 webadmin webadmin
}
```

**Opción 2: Manual (temporal)**
```bash
cd ~/acuarela/miembros/cron/logs
mv audit.log audit.log.$(date +%Y%m%d)
gzip audit.log.$(date +%Y%m%d)
```

---

## Troubleshooting

### Problema: El script no encuentra archivos (analyzed: 0)

**Diagnóstico:**
```bash
# Verificar que las rutas en las reglas son correctas
docker exec acuarela-web-prod ls -la /var/www/html/cache/
docker exec acuarela-web-prod ls -la /var/www/html/logs/
```

**Causas comunes:**
- Ruta relativa incorrecta en `retention_rules.json`
- Archivos ya fueron borrados en ejecución anterior
- Permisos insuficientes (poco probable con www-data)

**Solución:**
Ajustar el campo `path` en la regla para que coincida con la estructura dentro del contenedor.

---

### Problema: No se crea audit.log en el host

**Diagnóstico:**
```bash
# 1. Verificar que el volumen está montado
docker inspect acuarela-web-prod | grep -A 5 "miembros/cron/logs"

# 2. Verificar permisos de la carpeta en el host
ls -ld ~/acuarela/miembros/cron/logs
```

**Causas comunes:**
- Volumen no configurado en `docker-compose.production.yml`
- Carpeta no existía antes del `docker compose up` (crear con `mkdir -p`)
- Permisos restrictivos (debe ser 777 o al menos 775)

**Solución:**
```bash
mkdir -p ~/acuarela/miembros/cron/logs
chmod 777 ~/acuarela/miembros/cron/logs
docker compose -f docker-compose.production.yml down
docker compose -f docker-compose.production.yml up -d
```

---

### Problema: Cron no se ejecuta automáticamente

**Diagnóstico:**
```bash
# Ver si el cron está configurado
crontab -l

# Ver logs del sistema (ejecuciones de cron)
grep CRON /var/log/syslog | tail -20

# Verificar que el contenedor existe en el momento de la ejecución
docker ps -a | grep acuarela-web-prod
```

**Causas comunes:**
- Cron no configurado (verificar con `crontab -l`)
- Sintaxis incorrecta en la línea de cron
- Contenedor detenido o con nombre diferente
- PATH del cron no incluye `docker` (usar ruta completa: `/usr/bin/docker`)

**Solución:**
```bash
# Usar ruta absoluta a docker
crontab -e

# Asegurar línea correcta:
0 3 * * * /usr/bin/docker exec acuarela-web-prod php /var/www/html/miembros/cron/run_retention.php >> /var/log/acuarela-retention.log 2>&1
```

---

### Problema: Composer no instala dependencias en build

**Diagnóstico:**
```bash
# Verificar que vendor existe en el contenedor
docker exec acuarela-web-prod ls -la /var/www/html/miembros/acuarela-app-web/vendor

# Ver logs del build
docker compose -f docker-compose.production.yml build 2>&1 | grep composer
```

**Causas comunes:**
- `composer.json` tiene errores de sintaxis
- Falta `composer.lock` y hay conflictos de versiones
- Fallback de Packagist (red lenta o bloqueada)

**Solución:**
```bash
# Validar composer.json localmente
composer validate miembros/acuarela-app-web/composer.json

# Rebuild forzando descarga
docker compose -f docker-compose.production.yml build --no-cache
```

---

## Anexos

### A. Checklist de Post-Deploy

- [ ] Ejecutar dry-run y verificar salida
- [ ] Verificar que `audit.log` se crea en el host
- [ ] Confirmar montaje de volumen con `docker inspect`
- [ ] Verificar que Stripe está disponible (`class_exists`)
- [ ] Configurar crontab
- [ ] Probar ejecución manual de cron
- [ ] Documentar en Zoho Project

### B. Contactos y Escalamiento

| Rol | Responsable | Contacto |
|:----|:------------|:---------|
| DevOps Lead | [Nombre] | [Email/Slack] |
| DPO (Data Protection Officer) | [Nombre] | [Email] |
| Soporte Técnico | Equipo BCCT | support@bcct.com |

### C. Referencias Normativas

- **ISO/IEC 27001:2013** - A.18.1.3 (Protection of records)
- **COPPA (15 U.S.C. §§ 6501–6506)** - Minimización de datos de menores
- **CCPA (Cal. Civ. Code § 1798.100 et seq.)** - Derecho al olvido
- **GDPR Article 5(1)(e)** - Storage limitation principle

### D. Historial de Cambios

| Versión | Fecha | Cambios | Autor |
|:--------|:------|:--------|:------|
| 1.0.0 | 2026-01-20 | Implementación inicial | DevOps BCCT |

---

**Fin del Documento**

*Este documento es confidencial y está sujeto a las políticas de seguridad de la información de BCCT.*
