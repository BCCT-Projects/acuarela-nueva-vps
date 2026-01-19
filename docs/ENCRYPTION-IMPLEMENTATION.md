# Cifrado en Reposo - Implementación Completada

## ✅ Componentes Implementados

### 1. Servicio de Cifrado

- **Archivo**: `miembros/includes/CryptoService.php`
- **Algoritmo**: AES-256-CBC
- **Funciones**:
  - `encrypt()` - Cifra texto plano
  - `decrypt()` - Descifra texto
  - `isEncrypted()` - Detecta si un valor está cifrado
  - `encryptArray()` / `decryptArray()` - Para arrays (alergias, medicamentos, etc.)

### 2. Integración SDK

- **Archivo**: `miembros/includes/sdk.php`
- **Métodos agregados**:
  - `init Crypto()` - Inicialización automática
  - `encryptChildData()` / `decryptChildData()`
  - `encryptParentData()` / `decryptParentData()`
  - `encryptHealthData()` / `decryptHealthData()`

### 3. Endpoints Modificados

#### CREATE/UPDATE (Cifran antes de enviar)

- ✅ `set/updateChildren.php`
- ✅ `set/createInscripcion.php`
- ✅ `set/createHealthInfo.php`
- ✅ `set/updateHealthInfo.php`

#### GET (Descifran después de recibir)

- ✅ `get/getChildren.php`

### 4. Gestión de Claves

- ✅ `.env.example` - Template de configuración
- ✅ `.gitignore` - Protege `.env`
- ✅ `scripts/generate-key.php` - Generador de claves
- ✅ `scripts/test-crypto.php` - Suite de tests

---

## 🚀 Pasos para Activar el Cifrado

### Paso 1: Generar Clave de Cifrado

En tu servidor, ejecuta:

```bash
cd /ruta/a/acuarela-nueva-vps
php scripts/generate-key.php
```

Copia la clave generada (64 caracteres hexadecimales).

### Paso 2: Configurar Variable de Entorno

#### Opción A: Archivo .env (Recomendado para desarrollo)

```bash
# Crear archivo .env en la raíz
echo "DATA_ENCRYPTION_KEY=tu_clave_aqui" > .env
```

#### Opción B: Apache/Servidor (Recomendado para producción)

**En Apache** (`apache-config.conf` o `.htaccess`):

```apache
SetEnv DATA_ENCRYPTION_KEY "tu_clave_de_64_caracteres"
```

**En Docker** (`docker-compose.yml`):

```yaml
environment:
  - DATA_ENCRYPTION_KEY=tu_clave_de_64_caracteres
```

**En servidor directo** (agregar a `/etc/environment` o perfil de PHP-FPM).

### Paso 3: Verificar Instalación

Ejecuta el test:

```bash
php scripts/test-crypto.php
```

Deberías ver output exitoso de todos los tests.

### Paso 4: Reiniciar Servidor

```bash
# Apache
sudo systemctl restart apache2

# Docker
docker-compose restart

# PHP-FPM
sudo systemctl restart php-fpm
```

---

## 🔐 Datos que se Cifran

### Children (Menores)

- ✅ `name` - Nombre
- ✅ `lastname` - Apellido  
- ✅ `birthday` - Fecha de nacimiento

### Parents (Padres)

- ❌ `email` - **NO se cifra** (usado para login)
- ✅ `phone` - Teléfono

### HealthInfo (Salud)

- ✅ `allergies` - Alergias (array cifrado)
- ✅ `medicines` - Medicamentos (array)
- ✅ `physical_health` - Salud física
- ✅ `emotional_health` - Salud emocional
- ✅ `suspected_abuse` - Sospecha de abuso
- ✅ `pediatrician` - Pediatra
- ✅ `pediatrician_email` - Email pediatra
- ✅ `pediatrician_number` - Teléfono pediatra
- ✅ `incidents` - Incidentes (array completo)

---

## 🔄 Compatibilidad con Datos Existentes

**El sistema maneja automáticamente datos mixtos:**

- **Datos viejos** (creados antes): Permanecen en texto plano
- **Datos nuevos** (creados después): Se cifran automáticamente
- **Lectura**: El sistema detecta y descifra solo los datos cifrados

Esto se logra con el método `isEncrypted()` que identifica si un valor está cifrado antes de intentar descifrarlo.

---

## ⚠️ Importante

### Backup de la Clave

**CRÍTICO**: Guarda la clave en un lugar seguro. Opciones:

1. **Gestor de contraseñas** del equipo
2. **Vault** corporativo (ej. HashiCorp Vault)
3. **Documento cifrado** en ubicación segura

**SI PIERDES LA CLAVE, LOS DATOS CIFRADOS SE PIERDEN PERMANENTEMENTE.**

### No Commitear la Clave

El archivo `.env` está en `.gitignore`. Nunca:

- Hagas commit de `.env`
- Pongas la clave en código
- La compartas por email/Slack sin cifrar

---

## 🧪 Testing

### Test Manual en Base de Datos

```sql
-- Ver un niño recién creado
SELECT id, name, birthday FROM children ORDER BY id DESC LIMIT 1;

-- El 'name' y 'birthday' deben verse como base64 ilegible, ej:
-- U2FsdGVkX1+8kMbYx2Q3fG...
```

### Test en Aplicación

1. **Crear un niño nuevo** desde la interfaz
2. **Ver en BD**: Los campos deben estar cifrados
3. **Ver en frontend**: El nombre debe mostrarse correctamente (descifrado)

---

## 📊 Rendimiento

- **Overhead por cifrado/descifrado**: ~5-10ms por operación
- **Impacto esperado**: Mínimo (imperceptible para usuarios)
- **Recomendación**: Monitorear logs inicialmente

---

## 🐛 Troubleshooting

### Error: "DATA_ENCRYPTION_KEY not set"

**Síntoma**: Error al cargar páginas  
**Solución**: Configurar variable de entorno (ver Paso 2)

### Datos no se descifran

**Síntoma**: Ves texto base64 en frontend  
**Solución**: Verificar que CryptoService esté inicializado:

```bash
# Ver logs
tail -f /var/log/apache2/error.log
```

### Datos nuevos no se cifran

**Síntoma**: Datos en BD siguen en texto plano  
**Solución**:

1. Verificar que la variable de entorno esté configurada
2. Reiniciar servidor
3. Verificar que no haya errores en logs

---

## 📝 Próximos Pasos (Opcional)

### No Incluidos en Esta Implementación

1. **Cifrado de archivos** (fotos, documentos) - Requiere plan separado
2. **Rotación de claves** - Procedimiento documentado pero no automatizado
3. **KMS avanzado** (AWS KMS, Google Cloud KMS) - Recomendado para producción a gran escala

---

## 🔗 Archivos Clave

```
acuarela-nueva-vps/
├── .env.example              # Template de configuración
├── .gitignore                # Protege .env
├── scripts/
│   ├── generate-key.php      # Generador de claves
│   └── test-crypto.php       # Tests
├── miembros/includes/
│   ├── CryptoService.php     # Servicio de cifrado
│   └── sdk.php              # Integración (6 métodos nuevos)
├── miembros/acuarela-app-web/
│   ├── set/
│   │   ├── updateChildren.php       # Cifra antes de actualizar
│   │   ├── createInscripcion.php    # Cifra al crear
│   │   ├── createHealthInfo.php     # Cifra salud
│   │   └── updateHealthInfo.php     # Cifra  salud
│   └── get/
│       └── getChildren.php          # Descifra al leer
```

---

## ✅ Checklist de Activación

- [ ] Generar clave con `generate-key.php`
- [ ] Configurar `DATA_ENCRYPTION_KEY` en entorno
- [ ] Ejecutar `test-crypto.php` y verificar éxito
- [ ] Reiniciar servidor
- [ ] Crear niño de prueba
- [ ] Verificar que datos estén cifrados en BD
- [ ] Verificar que datos se vean correctos en frontend
- [ ] Guardar backup de la clave en lugar seguro
- [ ] Documentar ubicación de backup

---

**Implementado por**: Acuarela Security Team  
**Fecha**: 2026-01-19  
**Versión**: 1.0
