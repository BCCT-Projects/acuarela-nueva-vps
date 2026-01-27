# Documentación Técnica: Implementación de Seguridad del Servidor
**Proyecto:** Acuarela Web Application  
**Fecha de Implementación:** 26 de Enero, 2026  
**Autor:** Manuel Martinez  
**Versión:** 2.1 (Final)  

---

## 1. Resumen Ejecutivo

Se implementó un baseline de seguridad en el servidor VPS que cumple con los estándares SOC 2 / ISO 27001, incluyendo:
- TLS/HTTPS moderno con certificados de origen Cloudflare
- Cabeceras de seguridad HTTP obligatorias
- Cookies de sesión endurecidas (Secure, HttpOnly, SameSite=Strict)
- Protección de directorios y archivos sensibles
- Ocultamiento de información del servidor

**Resultado:** SSL Labs **A+** en todos los endpoints, sin regresiones en funcionalidad.

---

## 2. Criterios de Aceptación (DoD) - CUMPLIDOS

| Criterio | Estado | Evidencia |
|----------|--------|-----------|
| ✅ HTTPS forzado y TLS moderno | Completado | TLS 1.2/1.3, redirección 301 |
| ✅ HSTS activo | Completado | `max-age=31536000; includeSubDomains` |
| ✅ Cabeceras presentes en todas las respuestas | Completado | Verificado con `curl -I` |
| ✅ Directorios/archivos sensibles inaccesibles | Completado | `.env`, `.git` → 403 Forbidden |
| ✅ No se exponen versiones ni listados | Completado | `Server: cloudflare`, `expose_php=Off` |
| ✅ Pruebas superadas sin regresiones | Completado | Login, Videos, Testimonios funcionando |
| ✅ Cookies de sesión seguras | Completado | `secure; HttpOnly; SameSite=Strict` |

---

## 3. Configuración Técnica Implementada

### 3.1 SSL/TLS (HTTPS)

```
Protocolo mínimo: TLS 1.2
Protocolo recomendado: TLS 1.3
Ciphers: HIGH:!aNULL:!MD5:!RC4:!3DES
Certificados: Cloudflare Origin CA (15 años)
Modo Cloudflare: Full (Strict)
```

### 3.2 Cabeceras de Seguridad

| Cabecera | Valor Implementado |
|----------|-------------------|
| `Strict-Transport-Security` | `max-age=31536000; includeSubDomains` |
| `X-Frame-Options` | `DENY` |
| `X-Content-Type-Options` | `nosniff` |
| `X-XSS-Protection` | `1; mode=block` |
| `Referrer-Policy` | `strict-origin-when-cross-origin` |
| `Permissions-Policy` | `geolocation=(), microphone=(), camera=(), payment=()` |
| `Content-Security-Policy-Report-Only` | Política permisiva en modo reporte |

### 3.3 Cookies de Sesión (Endurecidas)

| Atributo | Valor | Propósito |
|----------|-------|-----------|
| `secure` | ✅ Activo | Solo se envía por HTTPS |
| `HttpOnly` | ✅ Activo | No accesible desde JavaScript |
| `SameSite` | `Strict` | Máxima protección contra CSRF |

### 3.4 Protección de Archivos/Directorios

**Bloqueados (403 Forbidden):**
- Archivos que empiezan con punto: `.env`, `.git`, `.htaccess`
- Extensiones peligrosas: `*.env`, `*.ini`, `*.log`, `*.sql`, `*.bak`
- Directorios sensibles: `/config`, `/logs`, `/backups`, `/.git`, `/.svn`

**NO bloqueados (para evitar regresiones):**
- `/uploads` - Contiene medios del CMS
- `/includes` - Contiene assets de la aplicación

### 3.5 Configuración de PHP (Seguridad)

```ini
expose_php = Off
display_errors = Off
session.cookie_httponly = 1
session.cookie_secure = 1
session.cookie_samesite = Strict
```

---

## 4. Archivos Modificados

| Archivo | Cambios |
|---------|---------|
| `apache-config.production.conf` | VirtualHost 443 con SSL, cabeceras de seguridad, bloqueo de archivos |
| `Dockerfile.production` | Habilitado `mod_remoteip`, configuración PHP segura, cookies endurecidas |
| `docker-compose.production.yml` | Volumen para certificados SSL |
| `.gitignore` | Excluir carpeta `certs/` del repositorio |

---

## 5. Evidencias de Auditoría

### 5.1 curl -I https://acuarela.app (26/01/2026 10:34 -05:00)

```http
HTTP/1.1 200 OK
Date: Mon, 26 Jan 2026 15:34:14 GMT
Content-Type: text/html; charset=UTF-8
Connection: keep-alive
Server: cloudflare
Strict-Transport-Security: max-age=31536000; includeSubDomains
X-Frame-Options: DENY
X-Content-Type-Options: nosniff
X-XSS-Protection: 1; mode=block
Referrer-Policy: strict-origin-when-cross-origin
Permissions-Policy: geolocation=(), microphone=(), camera=(), payment=()
Content-Security-Policy-Report-Only: default-src 'self'; script-src 'self' 'unsafe-inline' 'unsafe-eval' https:; style-src 'self' 'unsafe-inline' https:; font-src 'self' https: data:; img-src * data: blob:; media-src * data: blob:; connect-src *; frame-src *; frame-ancestors 'none'; object-src 'none'; base-uri 'self';
Set-Cookie: PHPSESSID=...; path=/; secure; HttpOnly; SameSite=Strict
CF-RAY: 9c4112c2ded1e881-MIA
```

### 5.2 SSL Labs - Calificación A+

| Servidor | Calificación | Fecha |
|----------|-------------|-------|
| 2606:4700:3032:0:0:0:6815:282c (IPv6) | A+ | 26 Jan 2026 13:29:24 UTC |
| 2606:4700:3035:0:0:0:ac43:af5e (IPv6) | A+ | 26 Jan 2026 13:30:12 UTC |
| 104.21.40.44 (IPv4) | A+ | 26 Jan 2026 13:31:06 UTC |
| 172.67.175.94 (IPv4) | A+ | 26 Jan 2026 13:31:56 UTC |

### 5.3 Prueba de Acceso Denegado

```
GET https://acuarela.app/.env → 403 Forbidden ✅
GET https://acuarela.app/.git/config → 403 Forbidden ✅
```

---

## 6. Configuración del VHost (apache-config.production.conf)

```apache
# Redirección HTTP → HTTPS
<VirtualHost *:80>
    ServerName acuarela.app
    Redirect permanent / https://acuarela.app/
</VirtualHost>

# HTTPS Principal
<VirtualHost *:443>
    ServerName acuarela.app
    DocumentRoot /var/www/html

    # SSL
    SSLEngine on
    SSLCertificateFile /etc/ssl/certs/acuarela.crt
    SSLCertificateKeyFile /etc/ssl/certs/acuarela.key
    SSLProtocol all -SSLv3 -TLSv1 -TLSv1.1
    SSLCipherSuite HIGH:!aNULL:!MD5:!RC4:!3DES

    # Cabeceras de Seguridad
    Header always set Strict-Transport-Security "max-age=31536000; includeSubDomains"
    Header always set X-Frame-Options "DENY"
    Header always set X-Content-Type-Options "nosniff"
    Header always set X-XSS-Protection "1; mode=block"
    Header always set Referrer-Policy "strict-origin-when-cross-origin"
    Header always set Permissions-Policy "geolocation=(), microphone=(), camera=(), payment=()"
    Header always set Content-Security-Policy-Report-Only "..."

    # Bloqueo de archivos sensibles
    <FilesMatch "^\.">
        Require all denied
    </FilesMatch>
    <FilesMatch "\.(env|ini|log|sql|bak)$">
        Require all denied
    </FilesMatch>
    <LocationMatch "^/(\.git|config|logs|backups)">
        Require all denied
    </LocationMatch>

    ServerSignature Off
</VirtualHost>
```

---

## 7. Registro de Cambios

| Fecha | Autor | Cambio |
|-------|-------|--------|
| 23/01/2026 | Manuel Martinez | Primer intento (revertido por regresiones) |
| 26/01/2026 08:28 | Manuel Martinez | Implementación exitosa v2.0 con CSP Report-Only |
| 26/01/2026 09:50 | Manuel Martinez | Cookies de sesión endurecidas (secure, Strict) |

---

## 8. Referencias

- [Mozilla SSL Configuration Generator](https://ssl-config.mozilla.org/)
- [OWASP Secure Headers Project](https://owasp.org/www-project-secure-headers/)
- [Cloudflare Origin CA](https://developers.cloudflare.com/ssl/origin-configuration/origin-ca/)
- [SSL Labs Server Test](https://www.ssllabs.com/ssltest/)
