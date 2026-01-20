# Guía de Verificación y Puesta en Marcha - Sistema de Retención

## 1. Verificación (Modo Simulacro)
>
> [!IMPORTANT]
> Ejecuta esto primero para asegurar que las reglas son correctas.

Accede a tu servidor VPS via SSH o Terminal y navega a la carpeta del proyecto. Ejecuta:

```bash
php miembros/cron/run_retention.php --dry-run
```

**Resultado Esperado:**

- Verás en pantalla una lista de archivos "Candidatos" a borrar.
- **NO** se borrará nada.
- Se creará un archivo de log en `miembros/cron/logs/audit.log`.

## 2. Ejecución Real (Manual)

Si el simulacro se ve bien, ejecuta el modo real para la primera limpieza:

```bash
php miembros/cron/run_retention.php
```

## 3. Automatización (Cron Job)

Para que esto corra automáticamente todos los días a las 3:00 AM (hora del servidor), agrega esto a tu crontab (`crontab -e`):

```bash
0 3 * * * php /ruta/absoluta/a/tu/proyecto/miembros/cron/run_retention.php >> /dev/null 2>&1
```

*(Asegúrate de reemplazar `/ruta/absoluta/...` con la ruta real en tu VPS).*

## Reglas Configuradas

Puedes ver o editar las reglas en:
`miembros/cron/retention_rules.json`

| Regla | Ruta | Antigüedad | Acción |
| :--- | :--- | :--- | :--- |
| `purge_local_logs` | `logs/*.log` | > 90 días | Borrar |
| `purge_root_error_log` | `error_log` | > 30 días | Borrar |
| `purge_api_cache` | `cache/*.json` | > 7 días | Borrar |
| `purge_miembros_cache` | `miembros/cache/wp/*.json` | > 7 días | Borrar |
| `purge_admin_logs` | `admin/wp-admin/log/*.log` | > 60 días | Borrar |
