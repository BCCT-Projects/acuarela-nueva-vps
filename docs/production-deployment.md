# Reporte Técnico: Migración y Despliegue de Infraestructura

**Fecha:** Enero 2026  
**Proyecto:** Acuarela (Unificación y Migración a VPS)  
**Entorno:** Producción (DigitalOcean)

## 1. Resumen Ejecutivo

Este documento detalla la reingeniería completa de la infraestructura de Acuarela. El objetivo principal fue migrar de un entorno compartido/fragmentado a una solución **VPS dedicada en DigitalOcean**, unificando los códigos base (`landing` y `app`) y adoptando una arquitectura contenerizada segura, escalable y mantenible.

---

## 2. Unificación del Código Base

Previo a la migración, los componentes del sistema operaban dispersos. Se realizó un proceso de **consolidación de repositorios**:

* **Estructura Monolítica**: Se unificó `acuarela-web-page` (Sitio Institucional) y `acuarela-app-web` (Aplicación de Miembros) en una sola estructura de directorios coherente.
* **Beneficio Técnico**: Esto permite un único pipeline de despliegue, versiones consistentes de PHP/Apache para toda la plataforma y gestión centralizada de dependencias y secretos.

---

## 3. Estrategia de Contenerización (Docker)

Se abandonó el modelo tradicional de despliegue por transferencia de archivos en favor de una **infraestructura inmutable** basada en Docker.

### 3.1. Segregación de Entornos

Se diseñaron dos definiciones de contenedor distintas para garantizar seguridad y facilidad de desarrollo:

* **Desarrollo (`Dockerfile` + `docker-compose.yml`)**:
  * Monta el código fuente como volumen (`bind-mount`) para permitir edición en tiempo real ("hot-reload").
  * Habilita `display_errors` y herramientas de depuración.

* **Producción (`Dockerfile.production` + `docker-compose.production.yml`)**:
  * **Inmutabilidad**: El código fuente se copia (`COPY`) dentro de la imagen durante el proceso de construcción (`build`). El contenedor NO tiene acceso al código en el host, evitando modificaciones accidentales en tiempo de ejecución ("Code Baking").
  * **PHP Hardening**: Se deshabilita la exposición de versiones (`expose_php = Off`), errores en pantalla y se optimizan límites de memoria (`256M`) y ejecución.
  * **Limpieza**: Se eliminan cachés de `apt` y herramientas de desarrollo para reducir la superficie de ataque y el tamaño de la imagen.

---

## 4. Seguridad de Infraestructura y Red (Hardening)

Se implementó una estrategia de seguridad en profundidad ("Defense in Depth").

### 4.1. Seguridad del Sistema Operativo (VPS)

* **Autenticación SSH**: Se deshabilitó completamente la autenticación por contraseña (`PasswordAuthentication no`). El acceso es exclusivo mediante llaves criptográficas SSH (Ed25519), mitigando ataques de fuerza bruta.
* **Usuario Operativo**: Se creó el usuario `webadmin` para evitar el uso directo de `root` en operaciones diarias.

### 4.2. Firewall Perimetral (Cloud Firewall)

Se configuró el Firewall de DigitalOcean con una política de **"Deny All"** (Denegar todo) por defecto, permitiendo únicamente:

* `TCP/22`: SSH (Administración).
* `TCP/80`: HTTP (Tráfico entrante desde Cloudflare).
* `TCP/443`: HTTPS (Reservado para futuro uso directo).

### 4.3. Seguridad de Aplicación (Apache)

El servidor web fue configurado con (`apache-config.production.conf`) para inyectar cabeceras de seguridad HTTP en todas las respuestas:

* **X-Frame-Options: SAMEORIGIN**: Previene ataques de Clickjacking.
* **X-Content-Type-Options: nosniff**: Evita ataques de MIME-sniffing.
* **X-XSS-Protection**: Bloqueo activo de scripts maliciosos.
* **Bloqueo de Archivos Sensibles**: Reglas explícitas para denegar acceso web a `.env`, `.git`, `.yml` y archivos de log.

---

## 5. Arquitectura SSL y Distribución de Tráfico

Se implementó un modelo de **Proxy Inverso** utilizando la red global de Cloudflare.

```mermaid
Browser (HTTPS) <==> Cloudflare Edge (SSL Termination) <==> VPS DigitalOcean (HTTP/80)
```

* **Modo SSL: Flexible**: Cloudflare gestiona los certificados SSL/TLS públicos. La comunicación entre Cloudflare y el VPS viaja por el puerto 80 optimizado.
* **Prevención de Bucles de Redirección**:
  * Problema común: Si Cloudflare usa SSL Flexible y el VPS fuerza HTTPS, se crea un bucle infinito.
  * Solución Implementada: Apache en el VPS **NO** realiza redirecciones HTTPS. Se delegó esta responsabilidad a las "Edge Rules" de Cloudflare ("Always Use HTTPS"), garantizando una conexión segura sin romper la cadena de peticiones.

---

## 6. Procedimiento de Despliegue Automatizado

Se desarrolló el script `deploy-production.sh` para estandarizar las actualizaciones:

1. **Limpieza**: Detiene contenedores y elimina imágenes huérfanas (`docker image prune`) para gestión eficiente del disco.
2. **Construcción**: Ejecuta `docker-compose build --no-cache`. El flag `--no-cache` es crítico: obliga a Docker a descargar las últimas actualizaciones de seguridad del sistema base (Debian) en cada despliegue.
3. **Lanzamiento**: Inicia los servicios en segundo plano con políticas de reinicio automático (`restart: always`).

---

## 7. Estado Actual y Pendientes

* **Infraestructura**: 🟢 Operativa (DigitalOcean Fra1).
* **Dominio**: 🟢 `acuarela.app` migrado y propagado.
* **Seguridad**: 🟢 Auditada y activa.
* **Backups**: � **Pendiente de Autorización**. La funcionalidad de Snapshots automáticos en DigitalOcean requiere activación manual y conlleva un costo adicional (~20% del droplet). Elemento crítico para la recuperación ante desastres (DRP).
