# Arquitectura de Proxy Inverso (Nginx Proxy Manager)

## 📌 Objetivo
El proyecto original (`acuarela-web-prod`) utilizaba los puertos `80` y `443` directamente en el servidor (VPS de DigitalOcean). Para permitir que el mismo servidor aloje múltiples servicios y dominios (como `acuarela.app` y `childcareexpo360.com`), se ha implementado una arquitectura de **Proxy Inverso** utilizando **Nginx Proxy Manager (NPM)**.

NPM actúa como un "recepcionista" que recibe todo el tráfico HTTP/HTTPS en los puertos 80 y 443 del servidor VPS, y enruta las solicitudes a los contenedores internos de Docker correspondientes, dependiendo del dominio solicitado.

---

## 🏗️ Estructura Implementada

### 1. Red de Comunicación Interna (Docker Network)
Se creó una red global externa en Docker llamada `web-proxy`.
Todos los contenedores web que necesiten responder a peticiones externas deben conectarse a esta red, pero **SIN EMPLEAR la directiva `ports`** para mapear los puertos `80` y `443` a la máquina host.

Comando ejecutado en el VPS:
```bash
docker network create web-proxy
```

### 2. Nginx Proxy Manager (Administrador del Proxy)
Se instaló completamente independiente del código de Acuarela por seguridad.
Ubicación en el servidor: `/opt/proxy/docker-compose.yml`.

Contiene el servicio principal y una base de datos MariaDB para guardar las configuraciones, certificados Let's Encrypt y reglas de acceso. Las reglas y certificados se administran visualmente mediante el panel web.

### 3. Ajuste en el Contenedor de Acuarela Producción (`acuarela-web-prod`)
Se editó el archivo `docker-compose.production.yml` del repositorio de Acuarela para:
- Quitar la exposición pública de puertos:
  ```yaml
  # Eliminado
  # ports:
  #   - "80:80"
  #   - "443:443"
  ```
- Sumarlo a la red externa `web-proxy` para que el gestor NPM pueda comunicarse con él de manera directa.

### 4. Seguridad - Acceso Privado al Panel de Control de NPM
El puerto `81` (puerto predeterminado del entorno administrativo de NPM) se **cerró al público**.
En su lugar, se creó un subdominio `proxy.acuarela.app` administrado por NPM que se redirecciona (proxy inverso) a sí mismo. Está asegurado con **HTTPS** y con Let's Encrypt.

Para acceder y administrar las reglas:
- **URL Segura:** `https://proxy.acuarela.app`

---

## 🚀 Guía: Cómo agregar nuevos proyectos (Ej: Childcare Expo)

La nueva infraestructura facilita agregar múltiples sitios. Cuando el desarrollo de `childcareexpo` esté listo para subir al VPS, simplemente hay que seguir 3 pasos estandarizados:

### Paso 1: Configurar el DNS
Ir al proveedor del dominio (Cloudflare/GoDaddy/etc.) de `childcareexpo360.com` y crear un registro **A** apuntando a la IP de la VPS (`152.42.152.212`).

### Paso 2: Configurar Docker Compose del nuevo proyecto
El nuevo proyecto debe ejecutarse con un archivo `docker-compose.yml` que:
1. NO exponga puertos 80/443.
2. Forme parte de la red `web-proxy`.

**Ejemplo de estructura recomendada para un nuevo contenedor:**
```yaml
version: '3.8'

services:
  childcare-web:
    image: nginx:alpine # Sustituir por la imagen correspondiente
    container_name: childcareexpo-web-prod
    networks:
      - web-proxy
    # NOTA: Sin puertos 'ports: - "80:80"'. NPM se encargará de acceder internamente.

networks:
  web-proxy:
    external: true
```

### Paso 3: Agregar la regla en Nginx Proxy Manager
1. Ingresar al panel `https://proxy.acuarela.app`.
2. Ir a **Proxy Hosts** -> **Add Proxy Host**.
3. Pestaña **Details**:
   - `Domain Names`: `childcareexpo360.com` y `www.childcareexpo360.com`
   - `Scheme`: `http` (A menos que la app traiga sus propios certificados SSL internamente como Acuarela).
   - `Forward Hostname / IP`: El `container_name`, en el ejemplo anterior `childcareexpo-web-prod` (o la IP interna del backend, o `childcare-web`).
   - `Forward Port`: El puerto interno en el que escucha el servicio, típicamente `80`, `3000`, `8080`, etc.
   - Activar `Block Common Exploits` y `Websockets Support` si la app lo requiere.
4. Pestaña **SSL**:
   - Tildar `Request a new SSL Certificate` (Para obtener el candadito verde HTTPS gratis con Let's Encrypt).
   - Tildar `Force SSL`.
   - Aceptar los términos de Let's Encrypt.
5. Hacer clic en **Save** y esperar unos instantes hasta que se apruebe el certificado.

¡Sitio web publicado local y seguramente tras el proxy de la VPS!
