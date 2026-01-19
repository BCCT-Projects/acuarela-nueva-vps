# Guía: Cómo Revertir el Cifrado de Nombres y Apellidos

## 📋 Contexto

Por defecto, el sistema cifra los siguientes campos de niños:

- ✅ `name` (nombre)
- ✅ `lastname` (apellido)
- ✅ `birthday` (fecha de nacimiento)

Esta guía explica cómo **desactivar el cifrado SOLO de nombre y apellido**, manteniendo cifrada la fecha de nacimiento, en caso de que se requiera por temas de rendimiento o búsquedas en base de datos.

---

## ⚠️ Consideraciones Antes de Revertir

### Ventajas de NO cifrar nombre/apellido

- ✅ Permite búsquedas directas en base de datos sin descifrar
- ✅ Mejor rendimiento en consultas
- ✅ Facilita reportes y sistemas de búsqueda
- ✅ Evita problemas con sistemas legacy

### Desventajas de NO cifrar nombre/apellido

- ❌ Menor privacidad de datos personales
- ❌ Posible incumplimiento con políticas de privacidad estrictas
- ❌ Riesgo si hay brecha de seguridad en la BD

---

## 🔧 Pasos para Revertir (Desactivar Cifrado de Nombres)

### 1️⃣ Modificar `encryptChildData()` en `sdk.php`

**Archivo**: `miembros/acuarela-app-web/includes/sdk.php`

**Ubicación**: Línea ~826

**Cambio**:

```php
// ANTES (cifra nombre, apellido, birthday)
$fieldsToEncrypt = ['name', 'lastname', 'birthday'];

// DESPUÉS (solo cifra birthday)
$fieldsToEncrypt = ['birthday']; // Solo birthday - nombre y apellido NO se cifran
```

---

### 2️⃣ Modificar `decryptChildData()` en `sdk.php`

**Archivo**: `miembros/acuarela-app-web/includes/sdk.php`

**Ubicación**: Línea ~857

**Cambio**:

```php
// ANTES (descifra nombre, apellido, birthday)
$fieldsToDecrypt = ['name', 'lastname', 'birthday'];

// DESPUÉS (solo descifra birthday)
$fieldsToDecrypt = ['birthday']; // Solo birthday - nombre y apellido NO están cifrados
```

---

### 3️⃣ Simplificar `createInscripcion.php`

**Archivo**: `miembros/acuarela-app-web/set/createInscripcion.php`

**Ubicación**: Línea ~99-115

**Eliminar** todo el bloque de descifrado de nombres:

```php
// ELIMINAR ESTE BLOQUE COMPLETO:
// IMPORTANTE: Descifrar el nombre antes de usarlo en el email
$childNamePlain = ($dataObj['name'] ?? '') . ' ' . ($dataObj['lastname'] ?? '');
$childNamePlain = trim($childNamePlain);

// Si el nombre está cifrado, descifrarlo para el email
if (isset($a->crypto) && $a->crypto && $a->crypto->isEncrypted($dataObj['name'] ?? '')) {
    try {
        $firstName = $a->crypto->decrypt($dataObj['name']);
        $lastName = isset($dataObj['lastname']) ? $a->crypto->decrypt($dataObj['lastname']) : '';
        $childNamePlain = trim($firstName . ' ' . $lastName);
    } catch (Exception $e) {
        error_log("Error decrypting child name for email: " . $e->getMessage());
        $childNamePlain = "su hijo/a";
    }
}
```

**Reemplazar con**:

```php
// REEMPLAZAR CON ESTO (más simple):
$childName = ($dataObj['name'] ?? '') . ' ' . ($dataObj['lastname'] ?? '');
$childName = trim($childName);
```

**Y también cambiar** la llamada a `initiateCoppaConsent`:

```php
// ANTES
$consentResult = initiateCoppaConsent($childId, $parentEmail, $parentName, $childNamePlain, $daycareId, $a);

// DESPUÉS
$consentResult = initiateCoppaConsent($childId, $parentEmail, $parentName, $childName, $daycareId, $a);
```

---

## 📝 Resumen de Cambios

| Archivo | Línea Aprox | Cambio |
|---------|------------|--------|
| `sdk.php` | ~826 | Cambiar array de `['name', 'lastname', 'birthday']` a `['birthday']` |
| `sdk.php` | ~857 | Cambiar array de `['name', 'lastname', 'birthday']` a `['birthday']` |
| `createInscripcion.php` | ~99-120 | Simplificar lógica eliminando descifrado de nombres |

---

## ✅ Verificación Post-Cambios

Después de hacer los cambios:

1. **Crear un niño de prueba**

   ```
   Nombre: Juan
   Apellido: Pérez
   Birthday: 2020-01-01
   ```

2. **Verificar en Base de Datos**:
   - `name`: debe estar en texto plano → `"Juan"`
   - `lastname`: debe estar en texto plano → `"Pérez"`
   - `birthday`: debe estar cifrado → algo como `"megBPInwopMpUvt..."`

3. **Verificar en Interfaz**:
   - El nombre debe verse correctamente: "Juan Pérez"
   - La fecha debe verse correctamente (descifrada automáticamente)

4. **Verificar en Correo**:
   - El correo debe mostrar: "Juan Pérez" (sin necesidad de descifrado)

---

## 🔄 Revertir de Vuelta (Volver a Cifrar Nombres)

Si decides **volver a cifrar** nombre y apellido después:

1. En `sdk.php` línea ~826:

   ```php
   $fieldsToEncrypt = ['name', 'lastname', 'birthday'];
   ```

2. En `sdk.php` línea ~857:

   ```php
   $fieldsToDecrypt = ['name', 'lastname', 'birthday'];
   ```

3. En `createInscripcion.php` restaurar el bloque de descifrado completo (ver arriba)

---

## 📊 Estado Actual del Sistema

**ACTUAL (con cifrado de nombres):**

- ✅ name: **CIFRADO**
- ✅ lastname: **CIFRADO**
- ✅ birthday: **CIFRADO**

**SI APLICAS ESTA GUÍA (sin cifrado de nombres):**

- ❌ name: **TEXTO PLANO**
- ❌ lastname: **TEXTO PLANO**
- ✅ birthday: **CIFRADO**

---

## ⚠️ Advertencia Importante

**Datos Existentes**: Si ya tienes niños con nombres cifrados en la base de datos y dejas de cifrar:

- Los datos viejos (cifrados) seguirán siendo descifrados correctamente gracias a `isEncrypted()`
- Los datos nuevos se guardarán en texto plano
- Esto NO causará problemas gracias a la compatibilidad de `decryptChildData()`

**Migración**: Si quieres que TODOS los nombres vuelvan a texto plano (no solo los nuevos), necesitarías un script de migración separado.

---

## 📞 Soporte

Si tienes dudas sobre esta reversión, revisa:

- `docs/ENCRYPTION-IMPLEMENTATION.md` - Documentación completa del sistema
- `scripts/test-crypto.php` - Tests del sistema de cifrado
- `miembros/includes/CryptoService.php` - Servicio base de cifrado

---

**Última actualización**: 2026-01-19  
**Versión del documento**: 1.0
