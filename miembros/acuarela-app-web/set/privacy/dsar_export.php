<?php
// set/privacy/dsar_export.php
// Script de uso interno/administrativo para generar el paquete de datos "Access Request"
// Este script debería estar protegido por autenticación de ADMIN o ser ejecutado vía CLI/Cron seguro.
// Por ahora, asumimos que se llamará desde un contexto seguro o se añadrá auth de admin.

session_start();
include __DIR__ . "/../../includes/config.php";
$a = new Acuarela();

// Inicializar criptografía para exportar datos legibles (descifrados)
if (method_exists($a, 'initCrypto')) {
    $a->initCrypto();
}

header('Content-Type: application/json');

// Validar que quien llama sea ADMIN (Implementar lógica de auth real aquí)
// if (!isAdmin()) die('Unauthorized');

$userId = $_GET['user_id'] ?? '';
$dsarId = $_GET['dsar_id'] ?? '';

if (empty($userId)) {
    die(json_encode(['error' => 'User ID required']));
}

$exportData = [
    'generated_at' => date('c'),
    'dsar_reference' => $dsarId,
    'data_subject' => [],
    'related_children' => [],
    'consents' => []
];

// 1. Obtener Datos del Padre (AcuarelaUser)
$user = $a->queryStrapi("acuarelausers/$userId");

if (!$user || !isset($user->id)) {
    die(json_encode(['error' => 'User not found']));
}

// Descifrar datos sensibles del padre si aplica
if (isset($user->phone) && isset($a->crypto) && $a->crypto->isEncrypted($user->phone)) {
    $user->phone = $a->crypto->decrypt($user->phone);
}
// Limpiar password y otros campos técnicos
unset($user->password);
unset($user->resetPasswordToken);
unset($user->confirmationToken);

$exportData['data_subject'] = $user;

// 2. Obtener Hijos Relacionados (Vía hijos directos en acuarelausers o buscando children vinculados)
// La estructura de Strapi suele tener la relación. Si no, buscamos children donde parent = user
$children = $a->queryStrapi("children?acuarelausers_in=$userId");

if (is_array($children)) {
    foreach ($children as $child) {
        // Descifrar datos del niño
        if (isset($a->crypto)) {
            // Usar métodos helper si existen en SDK o descifrar manualmente
            // Ejemplo manual genérico:
            if (isset($child->name) && $a->crypto->isEncrypted($child->name))
                $child->name = $a->crypto->decrypt($child->name);
            if (isset($child->lastname) && $a->crypto->isEncrypted($child->lastname))
                $child->lastname = $a->crypto->decrypt($child->lastname);
            if (isset($child->birthday) && $a->crypto->isEncrypted($child->birthday))
                $child->birthday = $a->crypto->decrypt($child->birthday);

            // Descifrar HealthInfo relacionado si se carga
            if (isset($child->healthinfo) && is_string($child->healthinfo)) {
                // A veces healthinfo viene como texto cifrado completo o JSON
                // Manejar según implementación actual
            }
        }

        $exportData['related_children'][] = $child;
    }
}

// 3. Obtener Consentimientos
$consents = $a->queryStrapi("parental-consents?parent_email=" . $user->mail);
$exportData['consents'] = $consents;

// Retornar JSON
echo json_encode($exportData, JSON_PRETTY_PRINT);
?>